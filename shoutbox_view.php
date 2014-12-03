<?php
/***************************************************************************
 *                               shoutbox_view.php
 *                            -------------------
 *   begin                :  Feb, 2003
 *   author               : Niels Chr. Denmark <ncr@db9.dk> (http://mods.db9.dk)
 *
 * version 0.9.3
 *
 * History:
 *   0.9.0. - initial BETA
 *   0.9.1. - header added
 *   0.9.2. - now support cenzored words
 *   0.9.3. - username is a link to users profile
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
require_once($phpbb_root_path . 'extension.inc');
require_once($phpbb_root_path . 'common.'.$phpEx);
require_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
define ('NUM_SHOUT', 20);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_SHOUTBOX);
init_userprefs($userdata);
//
// End session management
//

//
// Start auth check
//
switch ($userdata['user_level'])
{
	case ADMIN : 
	case MOD :	$is_auth['auth_mod'] = 1;
	default:
			$is_auth['auth_read'] = 1;
			$is_auth['auth_view'] = 1;
			if ($userdata['user_id']==ANONYMOUS)
			{
				$is_auth['auth_delete'] = 0;
				$is_auth['auth_post'] = 0;
			} else
			{
				$is_auth['auth_delete'] = 1;
				$is_auth['auth_post'] = 1;
			}
}

if( !$is_auth['auth_read'] )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}

//
// End auth check
//

// see if we need offset
if (isset($HTTP_POST_VARS['start']) || isset($HTTP_GET_VARS['start']))
{
	$start=(isset($HTTP_POST_VARS['start'])) ? intval($HTTP_POST_VARS['start']) : intval($HTTP_GET_VARS['start']);
} else $start=0;

$template->set_filenames(array( 
      'body' => 'shoutbox_view_body.tpl')); 

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

//
// display the shoutbox
//
	$sql = "SELECT s.*, u.* FROM " . SHOUTBOX_TABLE . " s, ".USERS_TABLE." u
		WHERE s.shout_user_id=u.user_id ORDER BY s.shout_session_time DESC LIMIT $start, ".$board_config['posts_per_page'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get shoutbox information', '', __LINE__, __FILE__, $sql);
	}
	$i = 0;
	while ($shout_row = $db->sql_fetchrow($result))
	{
		$i++;
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		$user_id = $shout_row['shout_user_id'];
//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
		$username = ( $user_id == ANONYMOUS ) ? (( $shout_row['shout_username'] == '' ) ? $lang['Guest'] : $shout_row['shout_username'] ) : "<a href='".append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=".$shout_row['shout_user_id'])."' target='_top'>".$shout_row['username']."</a>" ;
MOD-*/
//-- add
		$style_color = $rcs->get_colors($shout_row);
		$username = ($user_id != ANONYMOUS) ? '<a href="' . append_sid('profile.' . $phpEx . '?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $shout_row['shout_user_id']) . '" target="_top"' . $style_color . '>' : '';
		$username .= ($user_id != ANONYMOUS) ? $shout_row['username'] : (($shout_row['shout_username'] != '') ? $shout_row['shout_username'] : $lang['Guest'] );
		$username .= ($user_id != ANONYMOUS) ? '</a>' : '';
//-- fin mod : rank color system -----------------------------------------------
		$shout = (! $shout_row['shout_active']) ? $shout_row['shout_text'] : $lang['Shout_censor'];
		if ( $board_config['allow_smilies'] && $shout_row['user_allowsmile'] && $shout != '' & $shout_row['enable_smilies'])
		{
			$shout = smilies_pass($shout);
		} 
		$shout = bbencode_second_pass($shout,$shout_row['shout_bbcode_uid']);
		$shout = preg_replace($orig_word, $replacement_word, $shout);
		$shout = str_replace("\n", "\n<br />\n", $shout);

		$template->assign_block_vars('shoutrow', array(
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'SHOUT' => $shout,
			'TIME' => create_date($lang['Shoutbox_date'], $shout_row['shout_session_time'], $board_config['board_timezone']),
			'USERNAME' => $username
		));
}
$template->assign_vars(array( 
	'U_SHOUTBOX_VIEW' => append_sid("shoutbox_view.$phpEx?$start"),
	'T_NAME' => $theme['template_name'],
'T_URL' => "templates/".$theme['template_name'],
	'T_HEAD_STYLESHEET' => $theme['head_stylesheet'],
'S_CONTENT_ENCODING' => $lang['ENCODING']
));

 $template->pparse('body'); 

?>
