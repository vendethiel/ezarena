<?php
/***************************************************************************
 *                               shoutbox_max.php
 *                            -------------------
 *   begin                :  Feb, 2003
 *   author               : Niels Chr. Denmark <ncr@db9.dk> (http://mods.db9.dk)
 *
 * a fully phpBB2 integrated shoutbox
 * version 1.0.4
 *
 * History:
 *   0.9.0. - initial BETA
 *   0.9.1. - header added
 *   0.9.2. - shout can now be submitted by hitting enter
 *   0.9.3. - now support view back in time, + maximized view
 *   0.9.4. - now support preview in the maximized version
 *   0.9.5. - corrected currupted message if special combination
 *   0.9.6. - guest can't shout
 *   0.9.7. - max only version
 *   0.9.8. - improved some permission control
 *   0.9.9. - improved delete control
 *   0.9.10. - support auto prune
 *   0.9.11. - redirect corrected
 *   0.9.12. - guests should not have ranks assigned
 *   0.9.13. - corrected guests names
 *   1.0.0. - corrected a bug in the flood control code
 *   1.0.1. - word censor
 *   1.0.2. - line breaks added
 *   1.0.3. - bbcode moved to js script, to save line usage
 *   1.0.4. - highlight exploit by alcaeus
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
$userdata = session_pagestart($user_ip, PAGE_SHOUTBOX_MAX);
init_userprefs($userdata);
//
// End session management
//

//
// Start auth check
//
switch ($userdata['user_level'])
{
	//Costomice this, if you need other permission settings
      // please also make same changes to other shoutbox php files
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

$forum_id=PAGE_SHOUTBOX_MAX;
$refresh = (isset($HTTP_POST_VARS['auto_refresh']) || isset($HTTP_POST_VARS['refresh'])) ? 1 : 0;
$preview = (isset($HTTP_POST_VARS['preview'])) ? 1 : 0;
$submit = (isset($HTTP_POST_VARS['shout']) && isset($HTTP_POST_VARS['message'])) ? 1 : 0;
if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
}
else
{
	$mode = '';
}

//
// Set toggles for various options
//
if ( !$board_config['allow_html'] )
{
	$html_on = 0;
}
else
{
	$html_on = ( $submit || $refresh || preview) ? ( ( !empty($HTTP_POST_VARS['disable_html']) ) ? 0 : TRUE ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? $board_config['allow_html'] : $userdata['user_allowhtml'] );
}
if ( !$board_config['allow_bbcode'] )
{
	$bbcode_on = 0;
}
else
{
	$bbcode_on = ( $submit || $refresh || preview) ? ( ( !empty($HTTP_POST_VARS['disable_bbcode']) ) ? 0 : TRUE ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? $board_config['allow_bbcode'] : $userdata['user_allowbbcode'] );
}

if ( !$board_config['allow_smilies'] )
{
	$smilies_on = 0;
}
else
{
	$smilies_on = ( $submit || $refresh || preview) ? ( ( !empty($HTTP_POST_VARS['disable_smilies']) ) ? 0 : TRUE ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? $board_config['allow_smilies'] : $userdata['user_allowsmile'] );
}
if( !$userdata['session_logged_in'] || ( $mode == 'editpost' && $post_info['poster_id'] == ANONYMOUS ) )
{
	$template->assign_block_vars('switch_username_select', array());
}
$username = ( !empty($HTTP_POST_VARS['username']) ) ? $HTTP_POST_VARS['username'] : '';
// Check username
if ( !empty($username) )
{
	$username = htmlspecialchars(trim(strip_tags($username)));
	if ( !$userdata['session_logged_in'])
	{
		require_once($phpbb_root_path . 'includes/functions_validate.'.$phpEx);
		$result = validate_username($username);
		if ( $result['error'] )
		{
			$error = true;
			$error_msg .= ( !empty($error_msg) ) ? '<br />' . $result['error_msg'] : $result['error_msg'];
		}
	}
}

if ($refresh || $preview)
{
	$message = ( !empty($HTTP_POST_VARS['message']) ) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['message']))) : '';
	if (!empty($message))
	{
		if ($preview)
		{
			require_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);
			$orig_word = array();
			$replacement_word = array();
			obtain_word_list($orig_word, $replacement_word);
			$bbcode_uid = ( $bbcode_on ) ? make_bbcode_uid() : '';
			$preview_message = stripslashes(prepare_message(addslashes(unprepare_message($message)), $html_on, $bbcode_on, $smilies_on, $bbcode_uid));

			if( $bbcode_on )
			{
				$preview_message = bbencode_second_pass($preview_message, $bbcode_uid);
			}
			if( !empty($orig_word) )
			{
				$preview_message = ( !empty($preview_message) ) ? preg_replace($orig_word, $replacement_word, $preview_message) : '';
			}
			$preview_message = make_clickable($preview_message);
			if( $smilies_on )
			{
				$preview_message = smilies_pass($preview_message);
			}
			$preview_message = str_replace("\n", '<br />', $preview_message);
			$template->set_filenames(array(
				'preview' => 'posting_preview.tpl')
			);
			$template->assign_vars(array(
				'USERNAME' => $username,
				'POST_DATE' => create_date($board_config['default_dateformat'], time(), $board_config['board_timezone']),
				'MESSAGE' => $preview_message,
				'L_POSTED' => $lang['Posted'], 
				'L_PREVIEW' => $lang['Preview'])
			);
			$template->assign_var_from_handle('POST_PREVIEW_BOX', 'preview');
		} 
		$template->assign_var('MESSAGE',$message);
	}
} else
if ($submit || isset($HTTP_POST_VARS['message']))
{
	$current_time = time();
	//
	// Flood control
	//
		$where_sql = ( $userdata['user_id'] == ANONYMOUS ) ? "shout_ip = '$user_ip'" : 'shout_user_id = ' . $userdata['user_id'];
		$sql = "SELECT MAX(shout_session_time) AS last_post_time
		FROM " . SHOUTBOX_TABLE . "
		WHERE $where_sql";
	if ( $result = $db->sql_query($sql) )
	{
		if ( $row = $db->sql_fetchrow($result) )
		{
			if ( $row['last_post_time'] > 0 && ( $current_time - $row['last_post_time'] ) < $board_config['flood_interval'] )
			{
				$error = true;
				$error_msg .= ( !empty($error_msg) ) ? '<br />' . $lang['Flood_Error'] : $lang['Flood_Error'];
			}
		}
	}

	$message = (isset($HTTP_POST_VARS['message'])) ? trim($HTTP_POST_VARS['message']) : '';
	// insert shout !
	if (!empty($message) && $is_auth['auth_post'] && !$error)
	{
		require_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);
		$bbcode_uid = ( $bbcode_on ) ? make_bbcode_uid() : '';
		$message = prepare_message(trim($message), $html_on, $bbcode_on, $smilies_on, $bbcode_uid);
		$sql = "INSERT INTO " . SHOUTBOX_TABLE. " (shout_text, shout_session_time, shout_user_id, shout_ip, shout_username, shout_bbcode_uid,enable_bbcode,enable_html,enable_smilies) 
				VALUES ('$message', '".time()."', '".$userdata['user_id']."', '$user_ip', '".$username."', '".$bbcode_uid."',$bbcode_on,$html_on,$smilies_on)";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(GENERAL_ERROR, 'Error inserting shout.', '', __LINE__, __FILE__, $sql);
		}
		// auto prune
		if ($board_config['prune_shouts'])
		{
			$sql = "DELETE FROM " . SHOUTBOX_TABLE. " WHERE shout_session_time<=".(time()-86400*$board_config['prune_shouts']);
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(GENERAL_ERROR, 'Error autoprune shouts.', '', __LINE__, __FILE__, $sql);
			}
		}
	}
} else
if ($mode=='delete' || $mode=='censor')
{
	//	make shout inavtive
	if ( isset($HTTP_GET_VARS[POST_POST_URL]) || isset($HTTP_POST_VARS[POST_POST_URL]) )
	{
		$post_id = (isset($HTTP_POST_VARS[POST_POST_URL])) ? intval($HTTP_POST_VARS[POST_POST_URL]) : intval($HTTP_GET_VARS[POST_POST_URL]);
	}
	else
	{
		message_die(GENERAL_ERROR, 'Error no shout id specifyed for delete/censor.', '', __LINE__, __FILE__);
	}
	$sql = "SELECT s.shout_user_id, shout_ip FROM " . SHOUTBOX_TABLE . " s WHERE s.shout_id='$post_id'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get shoutbox information', '', __LINE__, __FILE__, $sql);
	}
	$shout_identifyer = $db->sql_fetchrow($result);
	$user_id = $shout_identifyer['shout_user_id'];

	if (
($userdata['user_id'] != ANONYMOUS || ( $userdata['user_id'] == ANONYMOUS && $userdata['session_ip'] == $shout_identifyer['shout_ip'])) &&
(($userdata['user_id'] == $user_id && $is_auth['auth_delete']) || $is_auth['auth_mod']) && $mode=='censor')
	{
		$sql = "UPDATE ".SHOUTBOX_TABLE." SET shout_active='".$userdata['user_id']."' WHERE shout_id='$post_id'";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(GENERAL_ERROR, 'Error censor shout.', '', __LINE__, __FILE__, $sql);
		}
	} else
	if ( $is_auth['auth_mod'] && $mode=='delete')
	{
		$sql = "DELETE FROM ".SHOUTBOX_TABLE." WHERE shout_id='$post_id'";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(GENERAL_ERROR, 'Error removing shout.', '', __LINE__, __FILE__, $sql);
		}
	} else
	message_die(GENERAL_MESSAGE, 'Not allowed.', '', __LINE__, __FILE__);
} else
if ($mode=='ip')
{
	//	show the ip
	if ( !$is_auth['auth_mod'])
	{
		message_die(GENERAL_MESSAGE, 'Not allowed.', '', __LINE__, __FILE__);
	}
	if ( isset($HTTP_GET_VARS[POST_POST_URL]) || isset($HTTP_POST_VARS[POST_POST_URL]) )
	{
		$post_id = (isset($HTTP_POST_VARS[POST_POST_URL])) ? intval($HTTP_POST_VARS[POST_POST_URL]) : intval($HTTP_GET_VARS[POST_POST_URL]);
	}
	else
	{
		message_die(GENERAL_ERROR, 'Error no shout id specifyed for show ip', '', __LINE__, __FILE__);
	}
	$sql = "SELECT s.shout_user_id, shout_username, shout_ip FROM " . SHOUTBOX_TABLE . " s WHERE s.shout_id='$post_id'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get shoutbox information', '', __LINE__, __FILE__, $sql);
	}
	$shout_identifyer = $db->sql_fetchrow($result);
	$poster_id = $shout_identifyer['shout_user_id'];
	$rdns_ip_num = ( isset($HTTP_GET_VARS['rdns']) ) ? $HTTP_GET_VARS['rdns'] : "";

	$ip_this_post = decode_ip($shout_identifyer['shout_ip']);
	$ip_this_post = ( $rdns_ip_num == $ip_this_post ) ? gethostbyaddr($ip_this_post) : $ip_this_post;
	require_once($phpbb_root_path . 'includes/page_header.'.$phpEx);


//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
	include($phpbb_root_path . 'includes/bbc_box_tags.'.$phpEx);
//-- fin mod : bbcode box reloaded ---------------------------------------------


	//
	// Set template files
	//
	$template->set_filenames(array(
		'viewip' => 'modcp_viewip.tpl')
	);
	$template->assign_vars(array(
		'L_IP_INFO' => $lang['IP_info'],
		'L_THIS_POST_IP' => $lang['This_posts_IP'],
		'L_OTHER_IPS' => $lang['Other_IP_this_user'],
		'L_OTHER_USERS' => $lang['Users_this_IP'],
		'L_LOOKUP_IP' => $lang['Lookup_IP'], 
		'L_SEARCH' => $lang['Search'],
		'SEARCH_IMG' => $images['icon_search'], 
		'IP' => $ip_this_post, 
		'U_LOOKUP_IP' => append_sid("shoutbox_max.$phpEx?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;rdns=" . $ip_this_post))
		);

	//
	// Get other IP's this user has posted under
	//
	$sql = "SELECT shout_ip, COUNT(*) AS postings 
		FROM " . SHOUTBOX_TABLE . " 
		WHERE shout_user_id = $poster_id 
		GROUP BY shout_ip 
		ORDER BY " . (( SQL_LAYER == 'msaccess' ) ? 'COUNT(*)' : 'postings' ) . " DESC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get IP information for this user', '', __LINE__, __FILE__, $sql);
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
				if ( $row['shout_ip'] == $post_row['shout_ip'] )
				{
					$template->assign_vars(array(
						'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ))
					);
					continue;
				}

				$ip = decode_ip($row['shout_ip']);
				$ip = ( $rdns_ip_num == $row['shout_ip'] || $rdns_ip_num == 'all') ? gethostbyaddr($ip) : $ip;

				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				$template->assign_block_vars('iprow', array(
					'ROW_COLOR' => '#' . $row_color, 
					'ROW_CLASS' => $row_class, 
					'IP' => $ip,
					'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ),

					'U_LOOKUP_IP' => append_sid("shoutbox_max.$phpEx?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;rdns=" . $row['shout_ip']))
				);

				$i++; 
			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		//
		// Get other users who've posted under this IP
		//
		$sql = "SELECT u.user_id, u.username, COUNT(*) as postings 
			FROM " . USERS_TABLE ." u, " . POSTS_TABLE . " p 
			WHERE p.poster_id = u.user_id 
				AND p.poster_ip = '" . $shout_identifyer['shout_ip'] . "'
			GROUP BY u.user_id, u.username
			ORDER BY " . (( SQL_LAYER == 'msaccess' ) ? 'COUNT(*)' : 'postings' ) . " DESC";

//-- mod : rank color system ---------------------------------------------------
//-- add
		$sql = str_replace('SELECT ', 'SELECT u.user_level, u.user_color, u.user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get posters information based on IP', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$i = 0;
			do
			{
				$id = $row['user_id'];
//				$username = ( $id == ANONYMOUS ) ? $lang['Guest'] : $row['username'];
				$shout_username = ( $id == ANONYMOUS && $row['username'] == '' ) ? $lang['Guest'] : $row['username'];

				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				$template->assign_block_vars('userrow', array(
					'ROW_COLOR' => '#' . $row_color, 
					'ROW_CLASS' => $row_class,

//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
					'SHOUT_USERNAME' => $shout_username,
MOD-*/
//-- add
					'SHOUT_USERNAME' => ($id == ANONYMOUS) ? $lang['Guest'] : $rcs->get_colors($row, $row['username']),
//-- fin mod : rank color system -----------------------------------------------

					'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ),
					'L_SEARCH_POSTS' => sprintf($lang['Search_user_posts'], $shout_username), 

					'U_PROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$id"),
					'U_SEARCHPOSTS' => append_sid("search.$phpEx?search_author=" . urlencode($shout_username) . "&amp;showresults=topics"))
				);

				$i++; 
			}
			while ( $row = $db->sql_fetchrow($result) );
		}


		$template->pparse('viewip');
	require_once($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	exit;
}

//
// display the defult page
//

// see if we need offset
if ((isset($HTTP_POST_VARS['start']) || isset($HTTP_GET_VARS['start'])) && !$submit)
{
	$start=(isset($HTTP_POST_VARS['start'])) ? intval($HTTP_POST_VARS['start']) : intval($HTTP_GET_VARS['start']);
} else $start=0;

	require_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);
	require_once($phpbb_root_path . 'includes/page_header.'.$phpEx);


//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
	include($phpbb_root_path . 'includes/bbc_box_tags.'.$phpEx);
//-- fin mod : bbcode box reloaded ---------------------------------------------


//
// Was a highlight request part of the URI?
//
$highlight_match = $highlight = '';
if (isset($HTTP_GET_VARS['highlight']))
{
	// Split words and phrases
	$words = explode(' ', trim(htmlspecialchars($HTTP_GET_VARS['highlight'])));

	for($i = 0; $i < sizeof($words); $i++)
	{
		if (trim($words[$i]) != '')
		{
			$highlight_match .= (($highlight_match != '') ? '|' : '') . str_replace('*', '\w*', phpbb_preg_quote($words[$i], '#'));
		}
	}
	unset($words);

	$highlight = urlencode($HTTP_GET_VARS['highlight']);
	$highlight_match = phpbb_rtrim($highlight_match, "\\");
}

$sql = "SELECT *
	FROM " . RANKS_TABLE . "
	ORDER BY rank_special, rank_min";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql);
}

$ranksrow = array();
while ( $row = $db->sql_fetchrow($result) )
{
	$ranksrow[] = $row;
}
$db->sql_freeresult($result);

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

	// get statistics
	$sql = "SELECT COUNT(*) as total FROM " . SHOUTBOX_TABLE; 
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get shoutbox stat information', '', __LINE__, __FILE__, $sql);
	}
	$total_shouts = $db->sql_fetchrow($result);
	$total_shouts = $total_shouts['total'];
	// parse post permission 
	if ($is_auth['auth_post'])
	{
		$template->set_filenames(array('body' => 'shoutbox_max_body.tpl'));
	} else
	{
		$template->set_filenames(array('body' => 'shoutbox_max_guest_body.tpl'));
	}
	// Generate pagination for shoutbox view
	$pagination = ( $highlight_match ) ? generate_pagination("shoutbox_max.$phpEx?highlight=".$highlight, $total_shouts, $board_config['posts_per_page'], $start) : generate_pagination("shoutbox_max.$phpEx?dummy=1", $total_shouts, $board_config['posts_per_page'], $start);

	// Generate smilies listing for page output
	generate_smilies('inline', PAGE_SHOUTBOX_MAX);

	//
	// Smilies toggle selection
	//
	if ( $board_config['allow_smilies'] )
	{
		$smilies_status = $lang['Smilies_are_ON'];
		$template->assign_block_vars('switch_smilies_checkbox', array());
	}
	else
	{
		$smilies_status = $lang['Smilies_are_OFF'];
	}
	//
	// HTML toggle selection
	//
	if ( $board_config['allow_html'] )
	{
		$html_status = $lang['HTML_is_ON'];
		$template->assign_block_vars('switch_html_checkbox', array());
	}
	else
	{
		$html_status = $lang['HTML_is_OFF'];
	}
	//
	// BBCode toggle selection
	//
	if ( $board_config['allow_bbcode'] )
	{
		$bbcode_status = $lang['BBCode_is_ON'];
		$template->assign_block_vars('switch_bbcode_checkbox', array());
	}
	else
	{
		$bbcode_status = $lang['BBCode_is_OFF'];
	}

	//
	// display the shoutbox
	//
	$sql = "SELECT s.*, u.* FROM " . SHOUTBOX_TABLE . " s, ".USERS_TABLE." u
		WHERE s.shout_user_id=u.user_id ORDER BY s.shout_session_time DESC LIMIT $start, ".$board_config['posts_per_page'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get shoutbox information', '', __LINE__, __FILE__, $sql);
	}
		while ($shout_row = $db->sql_fetchrow($result))
		{
			$i++;
			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
			$user_id = $shout_row['shout_user_id'];

//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
			$shout_username = ( $user_id == ANONYMOUS ) ? (( $shout_row['shout_username'] == '' ) ? $lang['Guest'] : $shout_row['shout_username'] ) : "<a href='".append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=".$shout_row['shout_user_id'])."' target='_top'>".$shout_row['username']."</a>" ;
MOD-*/
//-- add
			$style_color = $rcs->get_colors($shout_row);
			$shout_username = ($user_id != ANONYMOUS) ? '<a href="' . append_sid('profile.' . $phpEx . '?mode=viewprofile&amp;' . POST_USERS_URL . '=' . $shout_row['shout_user_id']) . '" target="_top"' . $style_color . '>' : '';
			$shout_username .= ($user_id != ANONYMOUS) ? $shout_row['username'] : (($shout_row['shout_username'] != '') ? $shout_row['shout_username'] : $lang['Guest'] );
			$shout_username .= ($user_id != ANONYMOUS) ? '</a>' : '';
//-- fin mod : rank color system -----------------------------------------------

			$user_profile = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id");
			$user_posts = ( $shout_row['user_id'] != ANONYMOUS ) ? $lang['Posts'] . ': ' . $shout_row['user_posts'] : '';
			$user_from = ( $shout_row['user_from'] && $shout_row['user_id'] != ANONYMOUS ) ? $lang['Location'] . ': ' . $shout_row['user_from'] : '';
			$user_joined = ( $shout_row['user_id'] != ANONYMOUS ) ? $lang['Joined'] . ': ' . create_date($lang['DATE_FORMAT'], $shout_row['user_regdate'], $board_config['board_timezone']) : '';
			if ( $shout_row['user_avatar_type'] && $user_id != ANONYMOUS && $shout_row['user_allowavatar'] )
			{
				switch( $shout_row['user_avatar_type'] )
				{
					case USER_AVATAR_UPLOAD:
						$user_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $shout_row['user_avatar'] . '" alt="" border="0" />' : '';
						break;
					case USER_AVATAR_REMOTE:
						$user_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $shout_row['user_avatar'] . '" alt="" border="0" />' : '';
						break;
					case USER_AVATAR_GALLERY:
						$user_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $shout_row['user_avatar'] . '" alt="" border="0" />' : '';
						break;
				}
				$user_avatar = ($shout_row['user_avatar_url']) ? '<a href="'.$shout_row['user_avatar_url'].'">'.$user_avatar.'</a>' : $user_avatar;
			} else $user_avatar='';
			$shout = (! $shout_row['shout_active']) ? $shout_row['shout_text'] : $lang['Shout_censor'].(($is_auth['auth_mod']) ? '<br/><hr/><br/>'.$shout_row['shout_text'] : '');
			$user_sig = ( $shout_row['enable_sig'] && $shout_row['user_sig'] != '' && $board_config['allow_sig'] ) ? $shout_row['user_sig'] : '';
			$user_sig_bbcode_uid = $shout_row['user_sig_bbcode_uid'];


			$user_rank = '';
			$rank_image = '';
			if ( $shout_row['user_rank'])
			{
				for($j = 0; $j < count($ranksrow); $j++)
				{
					if ( $shout_row['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
					{
						$user_rank = ($shout_row['user_id'] != ANONYMOUS) ? $ranksrow[$j]['rank_title'] : '';
						$rank_image = ( $ranksrow[$j]['rank_image'] && $shout_row['user_id'] != ANONYMOUS) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $user_rank . '" title="' . $user_rank . '" border="0" /><br />' : '';
					}
				}
			} else
			{
				for($j = 0; $j < count($ranksrow); $j++)
				{
					if ( $shout_row['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] )
					{
						$user_rank = ($shout_row['user_id'] != ANONYMOUS) ? $ranksrow[$j]['rank_title'] : '';
						$rank_image = ( $ranksrow[$j]['rank_image'] && $shout_row['user_id'] != ANONYMOUS) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $user_rank . '" title="' . $user_rank . '" border="0" /><br />' : '';
					}
				}
			}

			if ( $user_sig != '' )
			{
				$user_sig = make_clickable($user_sig);
			}
			$message = make_clickable($message);

	// 
   	// Highlight active words (primarily for search) 
   	// 
   	if ($highlight_match) 
   	{ 
		$shout = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace('#\b(" . str_replace('\\', '\\\\', addslashes($highlight_match)) . ")\b#i', '<span style=\"color:#" . $theme['fontcolor3'] . "\"><b>\\\\1</b></span>', '\\0')", '>' . $shout . '<'), 1, -1));
   	}
	//
	// Replace naughty words
	//
	if ( count($orig_word) )
	{
		if ( $user_sig != '' )
		{
			$user_sig = preg_replace($orig_word, $replacement_word, $user_sig);
		}
		$shout = preg_replace($orig_word, $replacement_word, $shout);
	}

	if ( $smilies_on && $shout != '' && $shout_row['enable_smilies'])
	{
		$shout = smilies_pass($shout);
	} 
	$shout = bbencode_second_pass($shout,$shout_row['shout_bbcode_uid']);
	$shout = str_replace("\n", "\n<br />\n", $shout);

	if ( $is_auth['auth_mod'] && $is_auth['auth_delete'])
	{
		$temp_url = append_sid("shoutbox_max.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $shout_row['shout_id']);
		$ip_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_ip'] . '" alt="' . $lang['View_IP'] . '" title="' . $lang['View_IP'] . '" border="0" /></a>';
		$ip = '<a href="' . $temp_url . '">' . $lang['View_IP'] . '</a>';

		$temp_url = append_sid("shoutbox_max.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $shout_row['shout_id']);
		$delshout_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>&nbsp;';
		$delshout = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';

		$temp_url = append_sid("shoutbox_max.$phpEx?mode=censor&amp;" . POST_POST_URL . "=" . $shout_row['shout_id']);
		$censorshout_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_censor'] . '" alt="' . $lang['Censor'] . '" title="' . $lang['Censor'] . '" border="0" /></a>&nbsp;';
		$censorshout = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
	}
	else
	{
		$ip_img = '';
		$ip = '';

		if ( ($userdata['user_id'] == $user_id && $is_auth['auth_delete'] ) &&
($userdata['user_id'] != ANONYMOUS || ( $userdata['user_id'] == ANONYMOUS && $userdata['session_ip'] == $shout_row['shout_ip'])) 
)

		{
			$temp_url = append_sid("shoutbox_max.$phpEx?mode=censor&amp;" . POST_POST_URL . "=" . $shout_row['shout_id']);
			$censorshout_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_censor'] . '" alt="' . $lang['Censor'] . '" title="' . $lang['Censor'] . '" border="0" /></a>&nbsp;';
			$censorshout = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
		}
		else
		{
			$delshout_img = '';
			$delshout = '';
			$censorshout_img = '';
			$censorshout = '';
		}
	}

		$template->assign_block_vars('shoutrow', array(
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'SHOUT' => $shout,
			'TIME' => create_date($board_config['default_dateformat'], $shout_row['shout_session_time'], $board_config['board_timezone']),
			'SHOUT_USERNAME' => $shout_username,
			'U_VIEW_USER_PROFILE' => $user_profile,
			'USER_RANK' => $user_rank,
			'RANK_IMAGE' => $rank_image,
			'IP_IMG' => $ip_img, 
			'IP' => $ip, 

			'DELETE_IMG' => $delshout_img, 
			'DELETE' => $delshout, 
			'CENSOR_IMG' => $censorshout_img, 
			'CENSOR' => $censorshout, 
			'USER_JOINED' => $user_joined,
			'USER_POSTS' => $user_posts,
			'USER_FROM' => $user_from,
			'USER_AVATAR' => $user_avatar,
			'U_SHOUT_ID' => $shout_row['shout_id']
			));
	}

	//
	// Show post options
	//
	if ( $is_auth['auth_post'] )
	{
		$template->assign_block_vars('switch_auth_post', array());
	}	
	else
	{	
		$template->assign_block_vars('switch_auth_no_post', array());
	}
		$template->assign_vars(array( 
			'USERNAME' => $username,
			'PAGINATION' => $pagination,
			'NUMBER_OF_SHOUTS' => $total_shouts,
			'HTML_STATUS' => $html_status,
			'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . append_sid("faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'), 
		'L_SHOUTBOX_LOGIN' => $lang['Login_join'],
		'L_POSTED' => $lang['Posted'], 
		'L_AUTHOR' => $lang['Author'],
		'L_MESSAGE' => $lang['Message'],
	'U_SHOUTBOX' => append_sid("shoutbox_max.$phpEx?start=$start"),
	'T_NAME' => $theme['template_name'],
'T_URL' => "templates/".$theme['template_name'],
	'L_SHOUTBOX' => $lang['Shoutbox'],
	'L_SHOUT_PREVIEW' => $lang['Preview'],
	'L_SHOUT_SUBMIT' => $lang['Go'],
	'L_SHOUT_TEXT' => $lang['Shout_text'],
	'L_SHOUT_REFRESH' => $lang['Shout_refresh'],
	'S_HIDDEN_FIELDS' => $s_hidden_fields,

	'SMILIES_STATUS' => $smilies_status,
	'L_BBCODE_B_HELP' => $lang['bbcode_b_help'], 
	'L_BBCODE_I_HELP' => $lang['bbcode_i_help'], 
	'L_BBCODE_U_HELP' => $lang['bbcode_u_help'], 
	'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'], 
	'L_BBCODE_C_HELP' => $lang['bbcode_c_help'], 
	'L_BBCODE_L_HELP' => $lang['bbcode_l_help'], 
	'L_BBCODE_O_HELP' => $lang['bbcode_o_help'], 
	'L_BBCODE_P_HELP' => $lang['bbcode_p_help'], 
	'L_BBCODE_W_HELP' => $lang['bbcode_w_help'], 
	'L_BBCODE_A_HELP' => $lang['bbcode_a_help'], 
	'L_BBCODE_S_HELP' => $lang['bbcode_s_help'], 
	'L_BBCODE_F_HELP' => $lang['bbcode_f_help'], 
	'L_EMPTY_MESSAGE' => $lang['Empty_message'],

	'L_FONT_COLOR' => $lang['Font_color'], 
	'L_COLOR_DEFAULT' => $lang['color_default'], 
	'L_COLOR_DARK_RED' => $lang['color_dark_red'], 
	'L_COLOR_RED' => $lang['color_red'], 
	'L_COLOR_ORANGE' => $lang['color_orange'], 
	'L_COLOR_BROWN' => $lang['color_brown'], 
	'L_COLOR_YELLOW' => $lang['color_yellow'], 
	'L_COLOR_GREEN' => $lang['color_green'], 
	'L_COLOR_OLIVE' => $lang['color_olive'], 
	'L_COLOR_CYAN' => $lang['color_cyan'], 
	'L_COLOR_BLUE' => $lang['color_blue'], 
	'L_COLOR_DARK_BLUE' => $lang['color_dark_blue'], 
	'L_COLOR_INDIGO' => $lang['color_indigo'], 
	'L_COLOR_VIOLET' => $lang['color_violet'], 
	'L_COLOR_WHITE' => $lang['color_white'], 
	'L_COLOR_BLACK' => $lang['color_black'], 

	'L_FONT_SIZE' => $lang['Font_size'], 
	'L_FONT_TINY' => $lang['font_tiny'], 
	'L_FONT_SMALL' => $lang['font_small'], 
	'L_FONT_NORMAL' => $lang['font_normal'], 
	'L_FONT_LARGE' => $lang['font_large'], 
	'L_FONT_HUGE' => $lang['font_huge'], 
	'L_DISABLE_HTML' => $lang['Disable_HTML_post'], 
	'L_DISABLE_BBCODE' => $lang['Disable_BBCode_post'], 
	'L_DISABLE_SMILIES' => $lang['Disable_Smilies_post'], 

	'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'], 
	'L_STYLES_TIP' => $lang['Styles_tip'],
	'S_HTML_CHECKED' => ( !$html_on ) ? 'checked="checked"' : '', 
	'S_BBCODE_CHECKED' => ( !$bbcode_on ) ? 'checked="checked"' : '', 
	'S_SMILIES_CHECKED' => ( !$smilies_on ) ? 'checked="checked"' : ''

	));

	if( $error_msg != '' )
	{
		$template->set_filenames(array(
			'reg_header' => 'error_body.tpl')
		);
		$template->assign_vars(array(
			'ERROR_MESSAGE' => $error_msg)
		);
		$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
		$message = ( !empty($HTTP_POST_VARS['message']) ) ? htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['message']))) : '';
		$template->assign_var('MESSAGE',$message);
	}

 $template->pparse('body'); 

//
// Include page tail
//
require_once($phpbb_root_path . 'includes/page_tail.'.$phpEx);



?>