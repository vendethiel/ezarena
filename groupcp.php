<?php
/***************************************************************************
 *                               groupcp.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: groupcp.php,v 1.58.2.25 2005/09/17 18:36:48 grahamje Exp $
 *
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
include($phpbb_root_path . 'common.'.$phpEx);

// -------------------------
//
function generate_user_info(&$row, $date_format, $group_mod, &$from, &$posts, &$joined, &$poster_avatar, &$profile_img, &$profile, &$search_img, &$search, &$pm_img, &$pm, &$email_img, &$email, &$www_img, &$www, &$icq_status_img, &$icq_img, &$icq, &$aim_img, &$aim, &$msn_img, &$msn, &$yim_img, &$yim)
{
	global $lang, $images, $board_config, $phpEx;
//-- mod : rank color system ---------------------------------------------------
//-- add
	global $get;
//-- fin mod : rank color system -----------------------------------------------	

	$from = ( !empty($row['user_from']) ) ? $row['user_from'] : '&nbsp;';
	$joined = create_date($date_format, $row['user_regdate'], $board_config['board_timezone']);
	$posts = ( $row['user_posts'] ) ? $row['user_posts'] : 0;

	$poster_avatar = '';
	if ( $row['user_avatar_type'] && $row['user_id'] != ANONYMOUS && $row['user_allowavatar'] )
	{
		switch( $row['user_avatar_type'] )
		{
			case USER_AVATAR_UPLOAD:
				$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img onload="rmwa_img_loaded(this,' .  $board_config['avatar_max_width'] . ',' .  $board_config['avatar_max_height'] . ')"' . ' src="' . $board_config['avatar_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_REMOTE:
				$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img onload="rmwa_img_loaded(this,' .  $board_config['avatar_max_width'] . ',' .  $board_config['avatar_max_height'] . ')"' . ' src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_GALLERY:
				$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img onload="rmwa_img_loaded(this,' .  $board_config['avatar_max_width'] . ',' .  $board_config['avatar_max_height'] . ')"' . ' src="' . $board_config['avatar_gallery_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
				break;
		}
	}

	if ( !empty($row['user_viewemail']) || $group_mod )
	{
		$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $row['user_id']) : 'mailto:' . $row['user_email'];

		$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
		$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
	}
	else
	{
		$email_img = '&nbsp;';
		$email = '&nbsp;';
	}

//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
	$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']);
MOD-*/
//-- add
	$temp_url = $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true);
//-- fin mod : rank color system -----------------------------------------------
	$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
	$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';

	$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=" . $row['user_id']);
	$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
	$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

	$www_img = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
	$www = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';

	if ( !empty($row['user_icq']) )
	{
		$icq_status_img = '<a href="http://wwp.icq.com/' . $row['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $row['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
		$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
		$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '">' . $lang['ICQ'] . '</a>';
	}
	else
	{
		$icq_status_img = '';
		$icq_img = '';
		$icq = '';
	}

	$aim_img = ( $row['user_aim'] ) ? '<a href="aim:goim?screenname=' . $row['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '';
	$aim = ( $row['user_aim'] ) ? '<a href="aim:goim?screenname=' . $row['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '';

//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
	$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']);
MOD-*/
//-- add
	$temp_url = $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true);
//-- fin mod : rank color system -----------------------------------------------
	$msn_img = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
	$msn = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

	$yim_img = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
	$yim = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';

	$temp_url = append_sid("search.$phpEx?search_author=" . urlencode($row['username']) . "&amp;showresults=posts");
	$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . sprintf($lang['Search_user_posts'], $row['username']) . '" title="' . sprintf($lang['Search_user_posts'], $row['username']) . '" border="0" /></a>';
	$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $row['username']) . '</a>';

	return;
}
//
// --------------------------

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_GROUPCP);
init_userprefs($userdata);
//
// End session management
//

$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
$script_name = ( $script_name != '' ) ? $script_name . '/groupcp.'.$phpEx : 'groupcp.'.$phpEx;
$server_name = trim($board_config['server_name']);
$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';

$server_url = $server_protocol . $server_name . $server_port . $script_name;

if ( isset($HTTP_GET_VARS[POST_GROUPS_URL]) || isset($HTTP_POST_VARS[POST_GROUPS_URL]) )
{
	$group_id = ( isset($HTTP_POST_VARS[POST_GROUPS_URL]) ) ? intval($HTTP_POST_VARS[POST_GROUPS_URL]) : intval($HTTP_GET_VARS[POST_GROUPS_URL]);
}
else
{
	$group_id = '';
}

if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = '';
}

$confirm = ( isset($HTTP_POST_VARS['confirm']) ) ? TRUE : 0;
$cancel = ( isset($HTTP_POST_VARS['cancel']) ) ? TRUE : 0;
$sid = ( isset($HTTP_POST_VARS['sid']) ) ? $HTTP_POST_VARS['sid'] : '';

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$start = ($start < 0) ? 0 : $start;

//
// Default var values
//
$is_moderator = FALSE;

if ( isset($HTTP_POST_VARS['groupstatus']) && $group_id )
{
	if ( !$userdata['session_logged_in'] )
	{
		redirect(append_sid("login.$phpEx?redirect=groupcp.$phpEx&" . POST_GROUPS_URL . "=$group_id", true));
	}
	else if ( $sid !== $userdata['session_id'] )
	{
		message_die(GENERAL_ERROR, $lang['Session_invalid']);
	}	

//-- mod : group moderatorZ ----------------------------------------------------
//-- delete
/*
	$sql = "SELECT group_moderator 
		FROM " . GROUPS_TABLE . "  
		WHERE group_id = $group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain user and group information', '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrow($result);

	if ( $row['group_moderator'] != $userdata['user_id'] && $userdata['user_level'] != ADMIN )
	{
*/
//-- add
	$sql = 'SELECT ug.user_id
				FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
				WHERE ug.group_id = ' . intval($group_id) . '
					AND g.group_id = ug.group_id
					AND (ug.user_id = g.group_moderator OR ug.group_moderator = 1)';
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain user and group information', '', __LINE__, __FILE__, $sql);
	}
	$group_moderators = array();
	while ($row = $db->sql_fetchrow($result) )
	{
		$group_moderators[] = intval($row['user_id']);
	}
	$db->sql_freeresult($result);
	if ( (empty($group_moderators) || !in_array($userdata['user_id'], $group_moderators)) && ($userdata['user_level'] != ADMIN) )
	{
//-- fin mod : group moderatorZ ------------------------------------------------
//-- mod : rank color system ---------------------------------------------------
//-- add
		// delete default membership, if necessary
		if (intval($userdata['user_group_id']) == intval($group_id))
		{
			$rcs->update_user_group_id(intval($userdata['user_id']));
		}
//-- fin mod : rank color system -----------------------------------------------	
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("index.$phpEx") . '">')
		);

		$message = $lang['Not_group_moderator'] . '<br /><br />' . sprintf($lang['Click_return_group'], '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);
	}

	$sql = "UPDATE " . GROUPS_TABLE . " 
		SET group_type = " . intval($HTTP_POST_VARS['group_type']) . "
		WHERE group_id = $group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain user and group information', '', __LINE__, __FILE__, $sql);
	}

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">')
	);

	$message = $lang['Group_type_updated'] . '<br /><br />' . sprintf($lang['Click_return_group'], '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
	
	$db->clear_cache();

	message_die(GENERAL_MESSAGE, $message);

}
else if ( isset($HTTP_POST_VARS['joingroup']) && $group_id )
{
	//
	// First, joining a group
	// If the user isn't logged in redirect them to login
	//
	if ( !$userdata['session_logged_in'] )
	{
		redirect(append_sid("login.$phpEx?redirect=groupcp.$phpEx&" . POST_GROUPS_URL . "=$group_id", true));
	}

	$sql = "SELECT ug.user_id, g.group_type
		FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g 
		WHERE g.group_id = $group_id 
			AND g.group_type <> " . GROUP_HIDDEN . " 
			AND ug.group_id = g.group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain user and group information', '', __LINE__, __FILE__, $sql);
	}

	if (	$row = $db->sql_fetchrow($result) )
	{
		if ( $row['group_type'] == GROUP_OPEN )
		{
			do
			{
				if ( $userdata['user_id'] == $row['user_id'] )
				{
					$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("index.$phpEx") . '">')
					);

					$message = $lang['Already_member_group'] . '<br /><br />' . sprintf($lang['Click_return_group'], '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

					message_die(GENERAL_MESSAGE, $message);
				}
			} while ( $row = $db->sql_fetchrow($result) );
		}
		else
		{
			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("index.$phpEx") . '">')
			);

			$message = $lang['This_closed_group'] . '<br /><br />' . sprintf($lang['Click_return_group'], '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
		}
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['No_groups_exist']); 
	}

	$sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending) 
		VALUES ($group_id, " . $userdata['user_id'] . ", 1)";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Error inserting user group subscription", "", __LINE__, __FILE__, $sql);
	}

//-- mod : group moderatorZ ----------------------------------------------------
//-- delete
/*
	$sql = "SELECT u.user_email, u.username, u.user_lang, g.group_name 
		FROM ".USERS_TABLE . " u, " . GROUPS_TABLE . " g 
		WHERE u.user_id = g.group_moderator 
			AND g.group_id = $group_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Error getting group moderator data", "", __LINE__, __FILE__, $sql);
	}

	$moderator = $db->sql_fetchrow($result);

	include($phpbb_root_path . 'includes/emailer.'.$phpEx);
*/
//-- add
	// include the mailer api
	include($phpbb_root_path . 'includes/emailer.'.$phpEx);

	$sql = 'SELECT g.group_name, u.user_email, u.username, u.user_lang
				FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g, ' . USERS_TABLE . ' u
				WHERE ug.group_id = ' . intval($group_id) . '
					AND g.group_id = ug.group_id
					AND (ug.user_id = g.group_moderator OR ug.group_moderator = 1)
					AND u.user_id = ug.user_id';
	if ( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Error getting group moderator data", "", __LINE__, __FILE__, $sql);
	}
	$moderators = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$group_moderators[] = $row;
	}
	$db->sql_freeresult($result);

	// loop with group moderators
	$count_group_moderators = count($group_moderators);
	for ( $i = 0; $i < $count_group_moderators; $i++ )
	{
		$moderator = $group_moderators[$i];

	$emailer = new emailer($board_config['smtp_delivery']);

	$emailer->from($board_config['board_email']);
	$emailer->replyto($board_config['board_email']);

	$emailer->use_template('group_request', $moderator['user_lang']);
	$emailer->email_address($moderator['user_email']);
	$emailer->set_subject($lang['Group_request']);

	$emailer->assign_vars(array(
		'SITENAME' => $board_config['sitename'], 
		'GROUP_MODERATOR' => $moderator['username'],
		'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '', 

		'U_GROUPCP' => $server_url . '?' . POST_GROUPS_URL . "=$group_id&validate=true")
	);
	$emailer->send();
	$emailer->reset();
//-- mod : group moderatorZ ----------------------------------------------------
//-- add
	}
	unset($group_moderators);
//-- fin mod : group moderatorZ ------------------------------------------------

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("index.$phpEx") . '">')
	);

	$message = $lang['Group_joined'] . '<br /><br />' . sprintf($lang['Click_return_group'], '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
	
	$db->clear_cache();

	message_die(GENERAL_MESSAGE, $message);
}
else if ( isset($HTTP_POST_VARS['unsub']) || isset($HTTP_POST_VARS['unsubpending']) && $group_id )
{
	//
	// Second, unsubscribing from a group
	// Check for confirmation of unsub.
	//
	if ( $cancel )
	{
		redirect(append_sid("groupcp.$phpEx", true));
	}
	else if ( !$userdata['session_logged_in'] )
	{
		redirect(append_sid("login.$phpEx?redirect=groupcp.$phpEx&" . POST_GROUPS_URL . "=$group_id", true));
	}
	else if ( $sid !== $userdata['session_id'] )
	{
		message_die(GENERAL_ERROR, $lang['Session_invalid']);
	}

	if ( $confirm )
	{
		$sql = "DELETE FROM " . USER_GROUP_TABLE . " 
			WHERE user_id = " . $userdata['user_id'] . " 
				AND group_id = $group_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete group memebership data', '', __LINE__, __FILE__, $sql);
		}

		if ( $userdata['user_level'] != ADMIN && $userdata['user_level'] == MOD )
		{
			$sql = "SELECT COUNT(auth_mod) AS is_auth_mod 
				FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug 
				WHERE ug.user_id = " . $userdata['user_id'] . " 
					AND aa.group_id = ug.group_id 
					AND aa.auth_mod = 1";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain moderator status', '', __LINE__, __FILE__, $sql);
			}

			if ( !($row = $db->sql_fetchrow($result)) || $row['is_auth_mod'] == 0 )
			{
				$sql = "UPDATE " . USERS_TABLE . " 
					SET user_level = " . USER . " 
					WHERE user_id = " . $userdata['user_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not update user level', '', __LINE__, __FILE__, $sql);
				}
			}
		}
	
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("index.$phpEx") . '">')
		);
		$message = $lang['Unsub_success'] . '<br /><br />' . sprintf($lang['Click_return_group'], '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
		
		$db->clear_cache();

		message_die(GENERAL_MESSAGE, $message);
	}
	else
	{
		$unsub_msg = ( isset($HTTP_POST_VARS['unsub']) ) ? $lang['Confirm_unsub'] : $lang['Confirm_unsub_pending'];

		$s_hidden_fields = '<input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group_id . '" /><input type="hidden" name="unsub" value="1" />';
		$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';		

		$page_title = $lang['Group_Control_Panel'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$template->set_filenames(array(
			'confirm' => 'confirm_body.tpl')
		);

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Confirm'],
			'MESSAGE_TEXT' => $unsub_msg,
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			'S_CONFIRM_ACTION' => append_sid("groupcp.$phpEx"),
			'S_HIDDEN_FIELDS' => $s_hidden_fields)
		);

		$template->pparse('confirm');

		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
	}

}
else if ( $group_id )
{
	//
	// Did the group moderator get here through an email?
	// If so, check to see if they are logged in.
	//
	if ( isset($HTTP_GET_VARS['validate']) )
	{
		if ( !$userdata['session_logged_in'] )
		{
			redirect(append_sid("login.$phpEx?redirect=groupcp.$phpEx&" . POST_GROUPS_URL . "=$group_id", true));
		}
	}

	//
	// For security, get the ID of the group moderator.
	//
	switch(SQL_LAYER)
	{
		case 'postgresql':
			$sql = "SELECT g.group_moderator, g.group_type, aa.auth_mod 
				FROM " . GROUPS_TABLE . " g, " . AUTH_ACCESS_TABLE . " aa 
				WHERE g.group_id = $group_id
					AND aa.group_id = g.group_id 
					UNION (
						SELECT g.group_moderator, g.group_type, NULL 
						FROM " . GROUPS_TABLE . " g
						WHERE g.group_id = $group_id
							AND NOT EXISTS (
							SELECT aa.group_id 
							FROM " . AUTH_ACCESS_TABLE . " aa 
							WHERE aa.group_id = g.group_id  
						)
					)
				ORDER BY auth_mod DESC";
			break;

		case 'oracle':
			$sql = "SELECT g.group_moderator, g.group_type, aa.auth_mod 
				FROM " . GROUPS_TABLE . " g, " . AUTH_ACCESS_TABLE . " aa 
				WHERE g.group_id = $group_id
					AND aa.group_id (+) = g.group_id
				ORDER BY aa.auth_mod DESC";
			break;

		default:
			$sql = "SELECT g.group_moderator, g.group_type, aa.auth_mod 
				FROM ( " . GROUPS_TABLE . " g 
				LEFT JOIN " . AUTH_ACCESS_TABLE . " aa ON aa.group_id = g.group_id )
				WHERE g.group_id = $group_id
				ORDER BY aa.auth_mod DESC";
			break;
	}
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not get moderator information', '', __LINE__, __FILE__, $sql);
	}

	if ( $group_info = $db->sql_fetchrow($result) )
	{
//-- mod : group moderatorZ ----------------------------------------------------
//-- delete
/*
		$group_moderator = $group_info['group_moderator'];
	
		if ( $group_moderator == $userdata['user_id'] || $userdata['user_level'] == ADMIN )
		{
			$is_moderator = TRUE;
		}
*/
//-- add
		$sql = 'SELECT *
					FROM ' . USER_GROUP_TABLE . ' ug, ' . GROUPS_TABLE . ' g
					WHERE ug.group_id = ' . intval($group_id) . '
						AND g.group_id = ug.group_id
						AND (ug.user_id = g.group_moderator OR ug.group_moderator = 1)';
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain user and group information', '', __LINE__, __FILE__, $sql);
		}
		$group_moderators = array();
		while ($row = $db->sql_fetchrow($result) )
		{
			$group_moderators[] = $row['user_id'];
		}
		$db->sql_freeresult($result);

		$is_moderator = (!empty($group_moderators) && in_array($userdata['user_id'], $group_moderators)) || ($userdata['user_level'] == ADMIN);
//-- fin mod : group moderatorZ ------------------------------------------------
			
		//
		// Handle Additions, removals, approvals and denials
		//
//-- mod : group moderatorZ ----------------------------------------------------
//-- delete
/*
		if ( !empty($HTTP_POST_VARS['add']) || !empty($HTTP_POST_VARS['remove']) || isset($HTTP_POST_VARS['approve']) || isset($HTTP_POST_VARS['deny']) )
*/
//-- add
		if ( !empty($HTTP_POST_VARS['add']) || !empty($HTTP_POST_VARS['remove']) || isset($HTTP_POST_VARS['approve']) || isset($HTTP_POST_VARS['deny']) || isset($HTTP_POST_VARS['grant_ungrant']) )
//-- fin mod : group moderatorZ ------------------------------------------------
		{
			if ( !$userdata['session_logged_in'] )
			{
				redirect(append_sid("login.$phpEx?redirect=groupcp.$phpEx&" . POST_GROUPS_URL . "=$group_id", true));
			} 
			else if ( $sid !== $userdata['session_id'] )
			{
				message_die(GENERAL_ERROR, $lang['Session_invalid']);				
			}

			if ( !$is_moderator )
			{
				$template->assign_vars(array(
					'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("index.$phpEx") . '">')
				);

				$message = $lang['Not_group_moderator'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

				message_die(GENERAL_MESSAGE, $message);
			}

			if ( isset($HTTP_POST_VARS['add']) )
			{
				$username = ( isset($HTTP_POST_VARS['username']) ) ? phpbb_clean_username($HTTP_POST_VARS['username']) : '';
				
				$sql = "SELECT user_id, user_email, user_lang, user_level  
					FROM " . USERS_TABLE . " 
					WHERE username = '" . str_replace("\'", "''", $username) . "'";
//-- mod : rank color system ---------------------------------------------------
//-- add
				$sql = str_replace('SELECT ', 'SELECT user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------					
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not get user information", $lang['Error'], __LINE__, __FILE__, $sql);
				}

				if ( !($row = $db->sql_fetchrow($result)) )
				{
					$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">')
					);

					$message = $lang['Could_not_add_user'] . "<br /><br />" . sprintf($lang['Click_return_group'], "<a href=\"" . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_index'], "<a href=\"" . append_sid("index.$phpEx") . "\">", "</a>");

					message_die(GENERAL_MESSAGE, $message);
				}

				if ( $row['user_id'] == ANONYMOUS )
				{
					$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">')
					);

					$message = $lang['Could_not_anon_user'] . '<br /><br />' . sprintf($lang['Click_return_group'], '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

					message_die(GENERAL_MESSAGE, $message);
				}
				
				$sql = "SELECT ug.user_id, u.user_level 
					FROM " . USER_GROUP_TABLE . " ug, " . USERS_TABLE . " u 
					WHERE u.user_id = " . $row['user_id'] . " 
						AND ug.user_id = u.user_id 
						AND ug.group_id = $group_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not get user information', '', __LINE__, __FILE__, $sql);
				}

				if ( !($db->sql_fetchrow($result)) )
				{
					$sql = "INSERT INTO " . USER_GROUP_TABLE . " (user_id, group_id, user_pending) 
						VALUES (" . $row['user_id'] . ", $group_id, 0)";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not add user to group', '', __LINE__, __FILE__, $sql);
					}
					
					if ( $row['user_level'] != ADMIN && $row['user_level'] != MOD && $group_info['auth_mod'] )
					{
						$sql = "UPDATE " . USERS_TABLE . " 
							SET user_level = " . MOD . " 
							WHERE user_id = " . $row['user_id'];
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not update user level', '', __LINE__, __FILE__, $sql);
						}
					}

//-- mod : rank color system ---------------------------------------------------
//-- add
					// update user default group, if necessary
					if (empty($row['user_group_id']))
					{
						$rcs->update_user_group_id(intval($row['user_id']), $group_id);
					}
//-- fin mod : rank color system -----------------------------------------------					
					//
					// Get the group name
					// Email the user and tell them they're in the group
					//
					$group_sql = "SELECT group_name 
						FROM " . GROUPS_TABLE . " 
						WHERE group_id = $group_id";
					if ( !($result = $db->sql_query($group_sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not get group information', '', __LINE__, __FILE__, $group_sql);
					}

					$group_name_row = $db->sql_fetchrow($result);

					$group_name = $group_name_row['group_name'];

					include($phpbb_root_path . 'includes/emailer.'.$phpEx);
					$emailer = new emailer($board_config['smtp_delivery']);

					$emailer->from($board_config['board_email']);
					$emailer->replyto($board_config['board_email']);

					$emailer->use_template('group_added', $row['user_lang']);
					$emailer->email_address($row['user_email']);
					$emailer->set_subject($lang['Group_added']);

					$emailer->assign_vars(array(
						'SITENAME' => $board_config['sitename'], 
						'GROUP_NAME' => $group_name,
						'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '', 

						'U_GROUPCP' => $server_url . '?' . POST_GROUPS_URL . "=$group_id")
					);
					$emailer->send();
					$emailer->reset();
				}
				else
				{
					$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">')
					);

					$message = $lang['User_is_member_group'] . '<br /><br />' . sprintf($lang['Click_return_group'], '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

					message_die(GENERAL_MESSAGE, $message);
				}
			}
//-- mod : group moderatorZ ----------------------------------------------------
//-- add
			else if ( isset($HTTP_POST_VARS['grant_ungrant']) )
			{
				$selected_members = array();
				$count_post_members = count($HTTP_POST_VARS['members']);
				for ( $i = 0; $i < $count_post_members; $i++ )
				{
					if ( intval($HTTP_POST_VARS['members'][$i]) )
					{
						$selected_members[] = intval($HTTP_POST_VARS['members'][$i]);
					}
				}
				if ( count($selected_members) > 0 )
				{
					$sql = 'SELECT user_id
								FROM ' . USER_GROUP_TABLE . '
								WHERE group_id = ' . intval($group_id) . '
									AND group_moderator = 1
									AND user_id IN(' . implode(', ', $selected_members) . ')
									AND user_id <> ' . intval($group_info['group_moderator']);
					if ( !$result = $db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not get user/group information', '', __LINE__, __FILE__, $sql);
					}
					$group_moderators = array();
					while ( $row = $db->sql_fetchrow($result) )
					{
						$group_moderators[] = $row['user_id'];
					}
					$db->sql_freeresult($result);

					if ( count($group_moderators) > 0)
					{
						$sql = 'UPDATE ' . USER_GROUP_TABLE . '
									SET group_moderator = 0
									WHERE group_id = ' . intval($group_id) . '
										AND user_id <> ' . intval($group_info['group_moderator']) . '
										AND user_id IN(' . implode(', ', $group_moderators) . ')';
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not ungrant user/group mod status', '', __LINE__, __FILE__, $sql);
						}
					}
					$sql = 'UPDATE ' . USER_GROUP_TABLE . '
								SET group_moderator = 1
								WHERE group_id = ' . intval($group_id) . '
									AND user_id <> ' . intval($group_info['group_moderator']) . '
									AND user_id IN(' . implode(', ', $selected_members) . ')' . (empty($group_moderators) ? '' : '
									AND user_id NOT IN(' . implode(', ', $group_moderators) . ')');
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not ungrant user/group mod status', '', __LINE__, __FILE__, $sql);
					}

					// return message
					$template->assign_vars(array(
						'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">')
					);
					$message = $lang['Group_grant_ungrant_mod_ok'] . '<br /><br />' . sprintf($lang['Click_return_group'], '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
				}
			}
//-- fin mod : group moderatorZ ------------------------------------------------
			else 
			{
				if ( ( ( isset($HTTP_POST_VARS['approve']) || isset($HTTP_POST_VARS['deny']) ) && isset($HTTP_POST_VARS['pending_members']) ) || ( isset($HTTP_POST_VARS['remove']) && isset($HTTP_POST_VARS['members']) ) )
				{

					$members = ( isset($HTTP_POST_VARS['approve']) || isset($HTTP_POST_VARS['deny']) ) ? $HTTP_POST_VARS['pending_members'] : $HTTP_POST_VARS['members'];

					$sql_in = '';
					for($i = 0; $i < count($members); $i++)
					{
						$sql_in .= ( ( $sql_in != '' ) ? ', ' : '' ) . intval($members[$i]);
					}

					if ( isset($HTTP_POST_VARS['approve']) )
					{
						if ( $group_info['auth_mod'] )
						{
							$sql = "UPDATE " . USERS_TABLE . " 
								SET user_level = " . MOD . " 
								WHERE user_id IN ($sql_in) 
									AND user_level NOT IN (" . MOD . ", " . ADMIN . ")";
							if ( !$db->sql_query($sql) )
							{
								message_die(GENERAL_ERROR, 'Could not update user level', '', __LINE__, __FILE__, $sql);
							}
						}

						$sql = "UPDATE " . USER_GROUP_TABLE . " 
							SET user_pending = 0 
							WHERE user_id IN ($sql_in) 
								AND group_id = $group_id";
						$sql_select = "SELECT user_email 
							FROM ". USERS_TABLE . " 
							WHERE user_id IN ($sql_in)"; 
					}
					else if ( isset($HTTP_POST_VARS['deny']) || isset($HTTP_POST_VARS['remove']) )
					{
						if ( $group_info['auth_mod'] )
						{
							$sql = "SELECT ug.user_id, ug.group_id 
								FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug 
								WHERE ug.user_id IN  ($sql_in) 
									AND aa.group_id = ug.group_id 
									AND aa.auth_mod = 1 
								GROUP BY ug.user_id, ug.group_id 
								ORDER BY ug.user_id, ug.group_id";
							if ( !($result = $db->sql_query($sql)) )
							{
								message_die(GENERAL_ERROR, 'Could not obtain moderator status', '', __LINE__, __FILE__, $sql);
							}

							if ( $row = $db->sql_fetchrow($result) )
							{
								$group_check = array();
								$remove_mod_sql = '';

								do
								{
									$group_check[$row['user_id']][] = $row['group_id'];
								}
								while ( $row = $db->sql_fetchrow($result) );

								while( list($user_id, $group_list) = @each($group_check) )
								{
									if ( count($group_list) == 1 )
									{
										$remove_mod_sql .= ( ( $remove_mod_sql != '' ) ? ', ' : '' ) . $user_id;
									}
								}

								if ( $remove_mod_sql != '' )
								{
									$sql = "UPDATE " . USERS_TABLE . " 
										SET user_level = " . USER . " 
										WHERE user_id IN ($remove_mod_sql) 
											AND user_level NOT IN (" . ADMIN . ")";
									if ( !$db->sql_query($sql) )
									{
										message_die(GENERAL_ERROR, 'Could not update user level', '', __LINE__, __FILE__, $sql);
									}
								}
							}
						}

						$sql = "DELETE FROM " . USER_GROUP_TABLE . " 
							WHERE user_id IN ($sql_in) 
								AND group_id = $group_id";
					}

					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update user group table', '', __LINE__, __FILE__, $sql);
					}
					$db->clear_cache();

					//
					// Email users when they are approved
					//
					if ( isset($HTTP_POST_VARS['approve']) )
					{
						if ( !($result = $db->sql_query($sql_select)) )
						{
							message_die(GENERAL_ERROR, 'Could not get user email information', '', __LINE__, __FILE__, $sql);
						}

						$bcc_list = array();
						while ($row = $db->sql_fetchrow($result))
						{
							$bcc_list[] = $row['user_email'];
						}

						//
						// Get the group name
						//
						$group_sql = "SELECT group_name 
							FROM " . GROUPS_TABLE . " 
							WHERE group_id = $group_id";
						if ( !($result = $db->sql_query($group_sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not get group information', '', __LINE__, __FILE__, $group_sql);
						}

						$group_name_row = $db->sql_fetchrow($result);
						$group_name = $group_name_row['group_name'];

						include($phpbb_root_path . 'includes/emailer.'.$phpEx);
						$emailer = new emailer($board_config['smtp_delivery']);

						$emailer->from($board_config['board_email']);
						$emailer->replyto($board_config['board_email']);

						for ($i = 0; $i < count($bcc_list); $i++)
						{
							$emailer->bcc($bcc_list[$i]);
						}

						$emailer->use_template('group_approved');
						$emailer->set_subject($lang['Group_approved']);

						$emailer->assign_vars(array(
							'SITENAME' => $board_config['sitename'], 
							'GROUP_NAME' => $group_name,
							'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '', 

							'U_GROUPCP' => $server_url . '?' . POST_GROUPS_URL . "=$group_id")
						);
						$emailer->send();
						$emailer->reset();
					}
//-- mod : rank color system ---------------------------------------------------
//-- add
					if (isset($HTTP_POST_VARS['approve']) || isset($HTTP_POST_VARS['remove']))
					{
						$new_id = (isset($HTTP_POST_VARS['approve'])) ? $group_id : 0;
						$default_id = (isset($HTTP_POST_VARS['approve'])) ? 0 : $group_id;

						// update user default group, if necessary
						$rcs->update_user_group_id($sql_in, $new_id, true, $default_id);
					}
//-- fin mod : rank color system -----------------------------------------------					
				}
			}
		}
		//
		// END approve or deny
		//
		
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['No_groups_exist']);
	}

	//
	// Get group details
	//
	$sql = "SELECT *
		FROM " . GROUPS_TABLE . "
		WHERE group_id = $group_id
			AND group_single_user = 0";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
	}

	if ( !($group_info = $db->sql_fetchrow($result)) )
	{
		message_die(GENERAL_MESSAGE, $lang['Group_not_exist']); 
	}

	//
	// Get moderator details for this group
	//
	$sql = "SELECT username, user_id, user_viewemail, user_posts, user_regdate, user_from, user_website, user_email, user_icq, user_aim, user_yim, user_msnm  
		FROM " . USERS_TABLE . " 
		WHERE user_id = " . $group_info['group_moderator'];
//-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_level, user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------		
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting user list for group', '', __LINE__, __FILE__, $sql);
	}

	$group_moderator = $db->sql_fetchrow($result); 

	//
	// Get user information for this group
	//
	$sql = "SELECT u.username, u.user_id, u.user_viewemail, u.user_posts, u.user_regdate, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_msnm, ug.user_pending 
		FROM " . USERS_TABLE . " u, " . USER_GROUP_TABLE . " ug
		WHERE ug.group_id = $group_id
			AND u.user_id = ug.user_id
			AND ug.user_pending = 0 
			AND ug.user_id <> " . $group_moderator['user_id'] . " 
		ORDER BY u.username";
//-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT u.user_level, u.user_color, u.user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------		
	//-- mod : group moderatorZ ----------------------------------------------------
//-- add
	$sql = str_replace(', ug.user_pending', ', ug.group_moderator, ug.user_pending', $sql);
	$sql = str_replace('ORDER BY', 'ORDER BY ug.group_moderator DESC,', $sql);
//-- fin mod : group moderatorZ ------------------------------------------------

	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting user list for group', '', __LINE__, __FILE__, $sql);
	}

	$group_members = $db->sql_fetchrowset($result); 
	$members_count = count($group_members);
	$db->sql_freeresult($result);

	$sql = "SELECT u.username, u.user_id, u.user_viewemail, u.user_posts, u.user_regdate, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_msnm
		FROM " . GROUPS_TABLE . " g, " . USER_GROUP_TABLE . " ug, " . USERS_TABLE . " u
		WHERE ug.group_id = $group_id
			AND g.group_id = ug.group_id
			AND ug.user_pending = 1
			AND u.user_id = ug.user_id
		ORDER BY u.username"; 
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting user pending information', '', __LINE__, __FILE__, $sql);
	}

	$modgroup_pending_list = $db->sql_fetchrowset($result);
	$modgroup_pending_count = count($modgroup_pending_list);
	$db->sql_freeresult($result);

	$is_group_member = 0;
	if ( $members_count )
	{
		for($i = 0; $i < $members_count; $i++)
		{
			if ( $group_members[$i]['user_id'] == $userdata['user_id'] && $userdata['session_logged_in'] )
			{
				$is_group_member = TRUE; 
			}
		}
	}

	$is_group_pending_member = 0;
	if ( $modgroup_pending_count )
	{
		for($i = 0; $i < $modgroup_pending_count; $i++)
		{
			if ( $modgroup_pending_list[$i]['user_id'] == $userdata['user_id'] && $userdata['session_logged_in'] )
			{
				$is_group_pending_member = TRUE;
			}
		}
	}

	if ( $userdata['user_level'] == ADMIN )
	{
		$is_moderator = TRUE;
	}

	if ( $userdata['user_id'] == $group_info['group_moderator'] )
	{
		$is_moderator = TRUE;

		$group_details =  $lang['Are_group_moderator'];

		$s_hidden_fields = '<input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group_id . '" />';
	}
	else if ( $is_group_member || $is_group_pending_member )
	{
		$template->assign_block_vars('switch_unsubscribe_group_input', array());

		$group_details =  ( $is_group_pending_member ) ? $lang['Pending_this_group'] : $lang['Member_this_group'];

		$s_hidden_fields = '<input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group_id . '" />';
	}
	else if ( $userdata['user_id'] == ANONYMOUS )
	{
		$group_details =  $lang['Login_to_join'];
		$s_hidden_fields = '';
	}
	else
	{
		if ( $group_info['group_type'] == GROUP_OPEN )
		{
			$template->assign_block_vars('switch_subscribe_group_input', array());

			$group_details =  $lang['This_open_group'];
			$s_hidden_fields = '<input type="hidden" name="' . POST_GROUPS_URL . '" value="' . $group_id . '" />';
		}
		else if ( $group_info['group_type'] == GROUP_CLOSED )
		{
			$group_details =  $lang['This_closed_group'];
			$s_hidden_fields = '';
		}
		else if ( $group_info['group_type'] == GROUP_HIDDEN )
		{
			$group_details =  $lang['This_hidden_group'];
			$s_hidden_fields = '';
		}
	}

	$page_title = $lang['Group_Control_Panel'];
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	//
	// Load templates
	//
	$template->set_filenames(array(
		'info' => 'groupcp_info_body.tpl', 
		'pendinginfo' => 'groupcp_pending_info.tpl')
	);
	make_jumpbox('viewforum.'.$phpEx);

	//
	// Add the moderator
	//
	$username = $group_moderator['username'];
	$user_id = $group_moderator['user_id'];

	generate_user_info($group_moderator, $board_config['default_dateformat'], $is_moderator, $from, $posts, $joined, $poster_avatar, $profile_img, $profile, $search_img, $search, $pm_img, $pm, $email_img, $email, $www_img, $www, $icq_status_img, $icq_img, $icq, $aim_img, $aim, $msn_img, $msn, $yim_img, $yim);

	$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

	$template->assign_vars(array(
		'L_GROUP_INFORMATION' => $lang['Group_Information'],
		'L_GROUP_NAME' => $lang['Group_name'],
		'L_GROUP_DESC' => $lang['Group_description'],
		'L_GROUP_TYPE' => $lang['Group_type'],
		'L_GROUP_MEMBERSHIP' => $lang['Group_membership'],
		'L_SUBSCRIBE' => $lang['Subscribe'],
		'L_UNSUBSCRIBE' => $lang['Unsubscribe'],
		'L_JOIN_GROUP' => $lang['Join_group'], 
		'L_UNSUBSCRIBE_GROUP' => $lang['Unsubscribe'], 
		'L_GROUP_OPEN' => $lang['Group_open'],
		'L_GROUP_CLOSED' => $lang['Group_closed'],
		'L_GROUP_HIDDEN' => $lang['Group_hidden'], 
		'L_UPDATE' => $lang['Update'], 
		'L_GROUP_MODERATOR' => $lang['Group_Moderator'], 
		'L_GROUP_MEMBERS' => $lang['Group_Members'], 
		'L_PENDING_MEMBERS' => $lang['Pending_members'], 
		'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'], 
		'L_PM' => $lang['Private_Message'], 
		'L_EMAIL' => $lang['Email'], 
		'L_POSTS' => $lang['Posts'], 
		'L_WEBSITE' => $lang['Website'],
		'L_FROM' => $lang['Location'],
		'L_ORDER' => $lang['Order'],
		'L_SORT' => $lang['Sort'],
		'L_SUBMIT' => $lang['Sort'],
		'L_AIM' => $lang['AIM'],
		'L_YIM' => $lang['YIM'],
		'L_MSNM' => $lang['MSNM'],
		'L_ICQ' => $lang['ICQ'],
		'L_SELECT' => $lang['Select'],
		'L_REMOVE_SELECTED' => $lang['Remove_selected'],
		'L_ADD_MEMBER' => $lang['Add_member'],
		'L_FIND_USERNAME' => $lang['Find_username'],

//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
		'GROUP_NAME' => $group_info['group_name'],
MOD-*/
//-- add
		'GROUP_NAME' => $rcs->get_group_class($group_id, $group_info['group_name']),
//-- fin mod : rank color system -----------------------------------------------		
		'GROUP_DESC' => $group_info['group_description'],
		'GROUP_DETAILS' => $group_details,
		'MOD_ROW_COLOR' => '#' . $theme['td_color1'],
		'MOD_ROW_CLASS' => $theme['td_class1'],
//-- mod : rank color system ---------------------------------------------------
//-- add
		'MOD_STYLE' => $rcs->get_colors($group_moderator),
//-- fin mod : rank color system -----------------------------------------------
		'MOD_USERNAME' => $username,		
		'MOD_FROM' => $from,
		'MOD_JOINED' => $joined,
		'MOD_POSTS' => $posts,
		'MOD_AVATAR_IMG' => $poster_avatar,
		'MOD_PROFILE_IMG' => $profile_img, 
		'MOD_PROFILE' => $profile, 
		'MOD_SEARCH_IMG' => $search_img,
		'MOD_SEARCH' => $search,
		'MOD_PM_IMG' => $pm_img,
		'MOD_PM' => $pm,
		'MOD_EMAIL_IMG' => $email_img,
		'MOD_EMAIL' => $email,
		'MOD_WWW_IMG' => $www_img,
		'MOD_WWW' => $www,
		'MOD_ICQ_STATUS_IMG' => $icq_status_img,
		'MOD_ICQ_IMG' => $icq_img, 
		'MOD_ICQ' => $icq, 
		'MOD_AIM_IMG' => $aim_img,
		'MOD_AIM' => $aim,
		'MOD_MSN_IMG' => $msn_img,
		'MOD_MSN' => $msn,
		'MOD_YIM_IMG' => $yim_img,
		'MOD_YIM' => $yim,

//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
		'U_MOD_VIEWPROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"), 
MOD-*/
//-- add
		'U_MOD_VIEWPROFILE' => $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $user_id), true),
//-- fin mod : rank color system ----------------------------------------------- 
		'U_SEARCH_USER' => append_sid("search.$phpEx?mode=searchuser"), 

		'S_GROUP_OPEN_TYPE' => GROUP_OPEN,
		'S_GROUP_CLOSED_TYPE' => GROUP_CLOSED,
		'S_GROUP_HIDDEN_TYPE' => GROUP_HIDDEN,
		'S_GROUP_OPEN_CHECKED' => ( $group_info['group_type'] == GROUP_OPEN ) ? ' checked="checked"' : '',
		'S_GROUP_CLOSED_CHECKED' => ( $group_info['group_type'] == GROUP_CLOSED ) ? ' checked="checked"' : '',
		'S_GROUP_HIDDEN_CHECKED' => ( $group_info['group_type'] == GROUP_HIDDEN ) ? ' checked="checked"' : '',
		'S_HIDDEN_FIELDS' => $s_hidden_fields, 
		'S_MODE_SELECT' => $select_sort_mode,
		'S_ORDER_SELECT' => $select_sort_order,
		'S_GROUPCP_ACTION' => append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id"),
//-- mod : group moderatorZ ----------------------------------------------------
//-- add
		'L_GROUP_OWNER' => $lang['Group_owner'],
		'L_GRANT_UNGRANT_SELECTED' => $lang['Group_grant_mod_status'],
	));
	$last_member_type = -1;
	$color = false;
//-- fin mod : group moderatorZ ------------------------------------------------

	//
	// Dump out the remaining users
	//
	for($i = $start; $i < min($board_config['topics_per_page'] + $start, $members_count); $i++)
	{
		$username = $group_members[$i]['username'];
		$user_id = $group_members[$i]['user_id'];

		generate_user_info($group_members[$i], $board_config['default_dateformat'], $is_moderator, $from, $posts, $joined, $poster_avatar, $profile_img, $profile, $search_img, $search, $pm_img, $pm, $email_img, $email, $www_img, $www, $icq_status_img, $icq_img, $icq, $aim_img, $aim, $msn_img, $msn, $yim_img, $yim);

		if ( $group_info['group_type'] != GROUP_HIDDEN || $is_group_member || $is_moderator )
		{
//-- mod : group moderatorZ ----------------------------------------------------
//-- add
			$color &= $last_member_type == $group_members[$i]['group_moderator'];
			$color = !$color;
			$row_color = $color ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = $color ? $theme['td_class1'] : $theme['td_class2'];
//-- fin mod : group moderatorZ ------------------------------------------------

			$template->assign_block_vars('member_row', array(
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,
//-- mod : rank color system ---------------------------------------------------
//-- add
				'STYLE' => $rcs->get_colors($group_members[$i]),
//-- fin mod : rank color system -----------------------------------------------
				'USERNAME' => $username,				
				'FROM' => $from,
				'JOINED' => $joined,
				'POSTS' => $posts,
				'USER_ID' => $user_id, 
				'AVATAR_IMG' => $poster_avatar,
				'PROFILE_IMG' => $profile_img, 
				'PROFILE' => $profile, 
				'SEARCH_IMG' => $search_img,
				'SEARCH' => $search,
				'PM_IMG' => $pm_img,
				'PM' => $pm,
				'EMAIL_IMG' => $email_img,
				'EMAIL' => $email,
				'WWW_IMG' => $www_img,
				'WWW' => $www,
				'ICQ_STATUS_IMG' => $icq_status_img,
				'ICQ_IMG' => $icq_img, 
				'ICQ' => $icq, 
				'AIM_IMG' => $aim_img,
				'AIM' => $aim,
				'MSN_IMG' => $msn_img,
				'MSN' => $msn,
				'YIM_IMG' => $yim_img,
				'YIM' => $yim,
				
//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
				'U_VIEWPROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
			);
MOD-*/
//-- add
				'U_VIEWPROFILE' => $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $user_id), true),
			));
//-- fin mod : rank color system -----------------------------------------------

//-- mod : group moderatorZ ----------------------------------------------------
//-- delete
/*
			if ( $is_moderator )
			{
				$template->assign_block_vars('member_row.switch_mod_option', array());
			}
*/
//-- add
			if ( $last_member_type != $group_members[$i]['group_moderator'] )
			{
				$template->assign_block_vars('member_row.member_type', array(
					'L_TYPE' => ( $group_members[$i]['group_moderator'] ) ? $lang['Group_Moderator'] : $lang['Group_Members'],
				));
				$last_member_type = $group_members[$i]['group_moderator'];
			}
			if ( $is_moderator && (!$group_members[$i]['group_moderator'] || ($group_moderator['user_id'] == $userdata['user_id']) || ($userdata['user_level'] == ADMIN)) )
			{
				$template->assign_block_vars('member_row.switch_mod_option', array());
			}
//-- fin mod : group moderatorZ ------------------------------------------------
		}
	}

	if ( !$members_count )
	{
		//
		// No group members
		//
		$template->assign_block_vars('switch_no_members', array());
		$template->assign_vars(array(
			'L_NO_MEMBERS' => $lang['No_group_members'])
		);
	}

	$current_page = ( !$members_count ) ? 1 : ceil( $members_count / $board_config['topics_per_page'] );

	$template->assign_vars(array(
		'PAGINATION' => generate_pagination("groupcp.$phpEx?" . POST_GROUPS_URL . "=$group_id", $members_count, $board_config['topics_per_page'], $start),
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), $current_page ), 

		'L_GOTO_PAGE' => $lang['Goto_page'])
	);

	if ( $group_info['group_type'] == GROUP_HIDDEN && !$is_group_member && !$is_moderator )
	{
		//
		// No group members
		//
		$template->assign_block_vars('switch_hidden_group', array());
		$template->assign_vars(array(
			'L_HIDDEN_MEMBERS' => $lang['Group_hidden_members'])
		);
	}

	//
	// We've displayed the members who belong to the group, now we 
	// do that pending memebers... 
	//
	if ( $is_moderator )
	{
		//
		// Users pending in ONLY THIS GROUP (which is moderated by this user)
		//
		if ( $modgroup_pending_count )
		{
			for($i = 0; $i < $modgroup_pending_count; $i++)
			{
				$username = $modgroup_pending_list[$i]['username'];
				$user_id = $modgroup_pending_list[$i]['user_id'];

				generate_user_info($modgroup_pending_list[$i], $board_config['default_dateformat'], $is_moderator, $from, $posts, $joined, $poster_avatar, $profile_img, $profile, $search_img, $search, $pm_img, $pm, $email_img, $email, $www_img, $www, $icq_status_img, $icq_img, $icq, $aim_img, $aim, $msn_img, $msn, $yim_img, $yim);

				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				$user_select = '<input type="checkbox" name="member[]" value="' . $user_id . '">';

				$template->assign_block_vars('pending_members_row', array(
					'ROW_CLASS' => $row_class,
					'ROW_COLOR' => '#' . $row_color, 
					'USERNAME' => $username,
					'FROM' => $from,
					'JOINED' => $joined,
					'POSTS' => $posts,
					'USER_ID' => $user_id, 
					'AVATAR_IMG' => $poster_avatar,
					'PROFILE_IMG' => $profile_img, 
					'PROFILE' => $profile, 
					'SEARCH_IMG' => $search_img,
					'SEARCH' => $search,
					'PM_IMG' => $pm_img,
					'PM' => $pm,
					'EMAIL_IMG' => $email_img,
					'EMAIL' => $email,
					'WWW_IMG' => $www_img,
					'WWW' => $www,
					'ICQ_STATUS_IMG' => $icq_status_img,
					'ICQ_IMG' => $icq_img, 
					'ICQ' => $icq, 
					'AIM_IMG' => $aim_img,
					'AIM' => $aim,
					'MSN_IMG' => $msn_img,
					'MSN' => $msn,
					'YIM_IMG' => $yim_img,
					'YIM' => $yim,
					
//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
					'U_VIEWPROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
				);
MOD-*/
//-- add
					'U_VIEWPROFILE' => $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $user_id), true),
				));
//-- fin mod : rank color system -----------------------------------------------
			}

			$template->assign_block_vars('switch_pending_members', array() );

			$template->assign_vars(array(
				'L_SELECT' => $lang['Select'],
				'L_APPROVE_SELECTED' => $lang['Approve_selected'],
				'L_DENY_SELECTED' => $lang['Deny_selected'])
			);

			$template->assign_var_from_handle('PENDING_USER_BOX', 'pendinginfo');
		
		}
	}

	if ( $is_moderator )
	{
		$template->assign_block_vars('switch_mod_option', array());
		$template->assign_block_vars('switch_add_member', array());
		//-- mod : group moderatorZ ----------------------------------------------------
//-- add
		if ( ($group_moderator['user_id'] == $userdata['user_id']) || ($userdata['user_level'] == ADMIN) )
		{
			$template->assign_block_vars('switch_mod_option.switch_owner_option', array());
		}
//-- fin mod : group moderatorZ ------------------------------------------------

	}

	$template->pparse('info');
}
else
{
//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
	//
	// Show the main groupcp.php screen where the user can select a group.
	//
	// Select all group that the user is a member of or where the user has
	// a pending membership.
	//
	$in_group = array();
	
	if ( $userdata['session_logged_in'] ) 
	{
		$sql = "SELECT g.group_id, g.group_name, g.group_type, ug.user_pending 
			FROM " . GROUPS_TABLE . " g, " . USER_GROUP_TABLE . " ug
			WHERE ug.user_id = " . $userdata['user_id'] . "  
				AND ug.group_id = g.group_id
				AND g.group_single_user <> " . TRUE . "
			ORDER BY g.group_name, ug.user_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$in_group = array();
			$s_member_groups_opt = '';
			$s_pending_groups_opt = '';

			do
			{
				$in_group[] = $row['group_id'];
				if ( $row['user_pending'] )
				{
					$s_pending_groups_opt .= '<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
				}
				else
				{
					$s_member_groups_opt .= '<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
				}
			}
			while( $row = $db->sql_fetchrow($result) );

			$s_pending_groups = '<select name="' . POST_GROUPS_URL . '">' . $s_pending_groups_opt . "</select>";
			$s_member_groups = '<select name="' . POST_GROUPS_URL . '">' . $s_member_groups_opt . "</select>";
		}
	}

	//
	// Select all other groups i.e. groups that this user is not a member of
	//
	$ignore_group_sql =	( count($in_group) ) ? "AND group_id NOT IN (" . implode(', ', $in_group) . ")" : ''; 
	$sql = "SELECT group_id, group_name, group_type 
		FROM " . GROUPS_TABLE . " g 
		WHERE group_single_user <> " . TRUE . " 
			$ignore_group_sql 
		ORDER BY g.group_name";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
	}

	$s_group_list_opt = '';
	while( $row = $db->sql_fetchrow($result) )
	{
		if  ( $row['group_type'] != GROUP_HIDDEN || $userdata['user_level'] == ADMIN )
		{
			$s_group_list_opt .='<option value="' . $row['group_id'] . '">' . $row['group_name'] . '</option>';
		}
	}
	$s_group_list = '<select name="' . POST_GROUPS_URL . '">' . $s_group_list_opt . '</select>';

	if ( $s_group_list_opt != '' || $s_pending_groups_opt != '' || $s_member_groups_opt != '' )
	{
		//
		// Load and process templates
		//
		$page_title = $lang['Group_Control_Panel'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$template->set_filenames(array(
			'user' => 'groupcp_user_body.tpl')
		);
		make_jumpbox('viewforum.'.$phpEx);

		if ( $s_pending_groups_opt != '' || $s_member_groups_opt != '' )
		{
			$template->assign_block_vars('switch_groups_joined', array() );
		}

		if ( $s_member_groups_opt != '' )
		{
			$template->assign_block_vars('switch_groups_joined.switch_groups_member', array() );
		}

		if ( $s_pending_groups_opt != '' )
		{
			$template->assign_block_vars('switch_groups_joined.switch_groups_pending', array() );
		}

		if ( $s_group_list_opt != '' )
		{
			$template->assign_block_vars('switch_groups_remaining', array() );
		}

		$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		$template->assign_vars(array(
			'L_GROUP_MEMBERSHIP_DETAILS' => $lang['Group_member_details'],
			'L_JOIN_A_GROUP' => $lang['Group_member_join'],
			'L_YOU_BELONG_GROUPS' => $lang['Current_memberships'],
			'L_SELECT_A_GROUP' => $lang['Non_member_groups'],
			'L_PENDING_GROUPS' => $lang['Memberships_pending'],
			'L_SUBSCRIBE' => $lang['Subscribe'],
			'L_UNSUBSCRIBE' => $lang['Unsubscribe'],
			'L_VIEW_INFORMATION' => $lang['View_Information'], 

			'S_USERGROUP_ACTION' => append_sid("groupcp.$phpEx"), 
			'S_HIDDEN_FIELDS' => $s_hidden_fields, 

			'GROUP_LIST_SELECT' => $s_group_list,
			'GROUP_PENDING_SELECT' => $s_pending_groups,
			'GROUP_MEMBER_SELECT' => $s_member_groups)
		);

		$template->pparse('user');
	}
MOD-*/
//-- add
	/**
	* main process
	*
	* main usergroups page where the user can select a group.
	*/

	// grab usergroups data
	include($get->url('includes/class_rcs_set'));
	$set = new rcs_set();
	$items = $set->get_usergroups_list();
	unset($set);

	// let's go
	if ( !empty($items) )
	{
		// header
		$page_title = $lang['Group_Control_Panel'];
		include($get->url('includes/page_header'));

		// hidden fields
		_hide_build(array('sid' => $userdata['session_id']));
		_hide_send();

		// build groups list
		$groups_list = array('name' => POST_GROUPS_URL, 'items' => $items);
		$rcs->constructor($groups_list);
		unset($items);

		// display
		$template->set_filenames(array('user' => 'groupcp_select_body.tpl'));

		// constants
		$template->assign_vars(array(
			'L_USERGROUPS' => $lang['usergroups_list'],
			'L_SELECT_USERGROUP' => $lang['select_usergroup'],
			'L_SELECT_USERGROUP_DETAILS' => $lang['select_usergroup_details'],
			'L_VIEW_INFORMATION' => $lang['View_Information'],

			'I_SUBMIT' => $images['cmd_submit'],

			'S_USERGROUP_ACTION' => $get->url('groupcp', '', true),
		));

		// navigation
		$navigation = new navigation();
		$navigation->add('usergroups_list', 'select_usergroup', 'groupcp');
		$navigation->display();
		unset($navigation);

		// send the display
		$template->pparse('user');
	}
//-- fin mod : rank color system -----------------------------------------------	
	else
	{
		message_die(GENERAL_MESSAGE, $lang['No_groups_exist']);
	}

}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>