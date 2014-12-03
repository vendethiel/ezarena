<?php
/***************************************************************************
 *                               shoutbox.php
 *                            -------------------
 *   begin                :  Feb, 2003
 *   author               : Niels Chr. Denmark <ncr@db9.dk> (http://mods.db9.dk)
 *
 * version 1.1.0
 *
 * History:
 *   0.9.0. - initial BETA
 *   0.9.1. - header added
 *   0.9.2. - shout can now be submitted by hitting enter
 *   0.9.3. - now support view back in time, + maximized view
 *   0.9.4. - now support preview in the maximized version
 *   0.9.5. - corrected currupted message if special combination
 *   0.9.6. - guest can't shout
 *   0.9.7. - shoutbox.php no longer support maximazed versin, instead sepperate file is offered
 *   1.0.0. - removed the DB stylesheet information, to speed up page load
 *   1.0.1. - corrected that guests username is stored correctly,when submitting a shout
 *   1.0.2. - corrected a bug regarding flood control
 *   1.0.3. - corrected displaying flood error more correctly
 *   1.1.0. - now include bbcode, in seperate js script
 *
 * a fully phpBB2 integrated shoutbox
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/bbcode.' . $phpEx);
define('NUM_SHOUT', 20);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_SHOUTBOX_MAX);
init_userprefs($userdata);
//
// End session management
//

//
// Start auth check
//
switch ($userdata['user_level']) {
	case ADMIN:
	case MOD:
		$is_auth['auth_mod'] = 1;
	default:
		$is_auth['auth_read'] = 1;
		$is_auth['auth_view'] = 1;
		if ($userdata['user_id'] == ANONYMOUS) {
			$is_auth['auth_delete'] = 0;
			$is_auth['auth_post']   = 0;
		} else {
			$is_auth['auth_delete'] = 1;
			$is_auth['auth_post']   = 1;
		}
}

if (!$is_auth['auth_read']) {
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}

//
// End auth check
//

$refresh = (isset($HTTP_POST_VARS['auto_refresh']) || isset($HTTP_POST_VARS['refresh'])) ? 1 : 0;
$submit  = (isset($HTTP_POST_VARS['shout']) && isset($HTTP_POST_VARS['message'])) ? 1 : 0;
if (!empty($HTTP_POST_VARS['mode']) || !empty($HTTP_GET_VARS['mode'])) {
	$mode = (!empty($HTTP_POST_VARS['mode'])) ? intval($HTTP_POST_VARS['mode']) : intval($HTTP_GET_VARS['mode']);
} else {
	$mode = '';
}

// V: this variable is used in later "if"s but never declared... idk...
$preview = false;

//
// Set toggles for various options
//
if (!$board_config['allow_html']) {
	$html_on = 0;
} else {
	$html_on = ($submit || $refresh || $preview) ? ((!empty($HTTP_POST_VARS['disable_html'])) ? 0 : TRUE) : (($userdata['user_id'] == ANONYMOUS) ? $board_config['allow_html'] : $userdata['user_allowhtml']);
}
if (!$board_config['allow_bbcode']) {
	$bbcode_on = 0;
} else {
	$bbcode_on = ($submit || $refresh || $preview) ? ((!empty($HTTP_POST_VARS['disable_bbcode'])) ? 0 : TRUE) : (($userdata['user_id'] == ANONYMOUS) ? $board_config['allow_bbcode'] : $userdata['user_allowbbcode']);
}

if (!$board_config['allow_smilies']) {
	$smilies_on = 0;
} else {
	$smilies_on = ($submit || $refresh || $preview) ? ((!empty($HTTP_POST_VARS['disable_smilies'])) ? 0 : TRUE) : (($userdata['user_id'] == ANONYMOUS) ? $board_config['allow_smilies'] : $userdata['user_allowsmile']);
	if ($smilies_on) {
		include($phpbb_root_path . 'includes/functions_post.' . $phpEx);
		//-- mod : bbcode box reloaded -------------------------------------------------
		//-- add
		include($phpbb_root_path . 'includes/bbc_box_tags.' . $phpEx);
		//-- fin mod : bbcode box reloaded ---------------------------------------------
		generate_smilies('inline', PAGE_SHOUTBOX_MAX);
		if ($mode == 'smilies') {
			generate_smilies('window', PAGE_SHOUTBOX_MAX);
			exit;
		}
		
	}
}

if ($refresh) {
	$message = (!empty($HTTP_POST_VARS['message'])) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['message']))) : '';
	if (!empty($message)) {
		$template->assign_var('MESSAGE', $message);
	}
} else if ($submit || isset($HTTP_POST_VARS['message'])) {
	$current_time = time();
	//
	// Flood control
	//
	// No Flood control for Admins & Mods
	
	if ($userdata['user_level'] != ADMIN && $userdata['user_level'] != MOD) {
		$where_sql = ($userdata['user_id'] == ANONYMOUS) ? "shout_ip = '$user_ip'" : 'shout_user_id = ' . $userdata['user_id'];
		$sql       = "SELECT MAX(shout_session_time) AS last_post_time
		FROM " . SHOUTBOX_TABLE . "
		WHERE $where_sql";
		if ($result = $db->sql_query($sql)) {
			if ($row = $db->sql_fetchrow($result)) {
				if ($row['last_post_time'] > 0 && ($current_time - $row['last_post_time']) < $board_config['flood_interval']) {
					$error = true;
					$error_msg .= (!empty($error_msg)) ? '<br />' . $lang['Flood_Error'] : $lang['Flood_Error'];
				}
			}
		}
	}
	// Check username
	if (!empty($username)) {
		$username = htmlspecialchars(trim(strip_tags($username)));
		
		if (!$userdata['session_logged_in'] || ($userdata['session_logged_in'] && $username != $userdata['username'])) {
			include($phpbb_root_path . 'includes/functions_validate.' . $phpEx);
			
			$result = validate_username($username);
			if ($result['error']) {
				$error_msg .= (!empty($error_msg)) ? '<br />' . $result['error_msg'] : $result['error_msg'];
			}
		}
	}
	$message = (isset($HTTP_POST_VARS['message'])) ? trim($HTTP_POST_VARS['message']) : '';
	// insert shout !
	if (!empty($message) && $is_auth['auth_post'] && !$error) {
		include_once($phpbb_root_path . 'includes/functions_post.' . $phpEx);
		$bbcode_uid = ($bbcode_on) ? make_bbcode_uid() : '';
		$message    = prepare_message(trim($message), $html_on, $bbcode_on, $smilies_on, $bbcode_uid);
		$sql        = "INSERT INTO " . SHOUTBOX_TABLE . " (shout_text, shout_session_time, shout_user_id, shout_ip, shout_username, shout_bbcode_uid,enable_bbcode,enable_html,enable_smilies) 
				VALUES ('$message', '" . time() . "', '" . $userdata['user_id'] . "', '$user_ip', '" . $username . "', '" . $bbcode_uid . "',$bbcode_on,$html_on,$smilies_on)";
		if (!$result = $db->sql_query($sql)) {
			message_die(GENERAL_ERROR, 'Error inserting shout.', '', __LINE__, __FILE__, $sql);
		}
		// auto prune
		if ($board_config['prune_shouts']) {
			$sql = "DELETE FROM " . SHOUTBOX_TABLE . " WHERE shout_session_time<=" . (time() - 86400 * $board_config['prune_shouts']);
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Error autoprune shouts.', '', __LINE__, __FILE__, $sql);
			}
		}
	}
}

// see if we need offset
if ((isset($HTTP_POST_VARS['start']) || isset($HTTP_GET_VARS['start'])) && !$submit) {
	$start = (isset($HTTP_POST_VARS['start'])) ? intval($HTTP_POST_VARS['start']) : intval($HTTP_GET_VARS['start']);
} else
	$start = 0;

//
// Show simple shoutbox
//

if ($is_auth['auth_post']) {
	$template->assign_block_vars('switch_auth_post', array());
} else {
	$template->assign_block_vars('switch_auth_no_post', array());
}

if ($bbcode_on) {
	$template->assign_block_vars('switch_auth_post.switch_bbcode', array());
}
$template->set_filenames(array(
	'body' => 'shoutbox_body.tpl'
));


$template->assign_vars(array(
	'U_SHOUTBOX' => append_sid("shoutbox.$phpEx?start=$start"),
	'U_SHOUTBOX_VIEW' => append_sid("shoutbox_view.$phpEx?start=$start"),
	'T_HEAD_STYLESHEET' => $theme['head_stylesheet'],
	'T_NAME' => $theme['template_name'],
	
	'L_SHOUTBOX' => $lang['Shoutbox'],
	'L_SHOUT_PREVIEW' => $lang['Preview'],
	'L_SHOUT_SUBMIT' => $lang['Go'],
	'L_SHOUT_TEXT' => $lang['Shout_text'],
	'L_SHOUT_REFRESH' => $lang['Shout_refresh'],
	'L_SMILIES' => $lang['Emoticons'],
	'T_URL' => "templates/" . $theme['template_name'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'U_MORE_SMILIES' => append_sid("posting.$phpEx?mode=smilies"),
	'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'],
	
	'SHOUT_VIEW_SIZE' => isset($max) ? $max : 0,
	'S_HIDDEN_FIELDS' => '',
));
if (!empty($error_msg)) {
	$template->set_filenames(array(
		'reg_header' => 'error_body.tpl'
	));
	$template->assign_vars(array(
		'ERROR_MESSAGE' => $error_msg
	));
	$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
	$message = (!empty($HTTP_POST_VARS['message'])) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['message']))) : '';
	$template->assign_var('MESSAGE', $message);
}

$template->pparse('body');

?>
