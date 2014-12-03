<?php
/***************************************************************************
 *                            usercp_register.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: usercp_register.php,v 1.20.2.74 2006/04/05 12:42:23 grahamje Exp $
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
 *
 ***************************************************************************/

/*

	This code has been modified from its original form by psoTFX @ phpbb.com
	Changes introduce the back-ported phpBB 2.2 visual confirmation code. 

	NOTE: Anyone using the modified code contained within this script MUST include
	a relevant message such as this in usercp_register.php ... failure to do so 
	will affect a breach of Section 2a of the GPL and our copyright

	png visual confirmation system : (c) phpBB Group, 2003 : All Rights Reserved

*/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
	exit;
}

$unhtml_specialchars_match = array('#&gt;#', '#&lt;#', '#&quot;#', '#&amp;#');
$unhtml_specialchars_replace = array('>', '<', '"', '&');
// Change "$ban_ip = false;" to "$ban_ip = true;" to ban the of the user if it tries to enter in something in the website or signature sections
$ban_ip = false;

// End Website Signature removal mod

// ---------------------------------------
// Load agreement template since user has not yet
// agreed to registration conditions/coppa
//

function show_coppa()
{
	global $userdata, $template, $lang, $phpbb_root_path, $phpEx;
//-- mod : vAgreement Terms ----------------------------------------------------
//-- add
	global $board_config;
//-- fin mod : vAgreement Terms ------------------------------------------------	

//-- mod : vAgreement Terms ----------------------------------------------------
//-- delete
//	$template->set_filenames(array(
//		'body' => 'agreement.tpl')
//	);
//-- add
	$template->set_filenames(array(
		'body' => 'agreement_new.tpl')
	);
//-- fin mod : vAgreement Terms ------------------------------------------------

	$template->assign_vars(array(
		'REGISTRATION' => $lang['Registration'],
		'AGREEMENT' => $lang['Reg_agreement'],
//-- mod : vAgreement Terms ----------------------------------------------------
//-- add
		'FORUM_RULES' => $lang['Forum_Rules'],
		'TO_JOIN' => $lang['To_Join'],
		'AGREE_CHECKBOX' => sprintf($lang['Agree_checkbox'], $board_config['sitename']),
		'L_REGISTER' => $lang['Register'],
//-- fin mod : vAgreement Terms ------------------------------------------------		
		"AGREE_OVER_13" => $lang['Agree_over_13'],
		"AGREE_UNDER_13" => $lang['Agree_under_13'],
		'DO_NOT_AGREE' => $lang['Agree_not'],
//-- mod : vAgreement Terms ----------------------------------------------------
//-- add
		"S_AGREE" => append_sid("profile.$phpEx?mode=register"),
//-- fin mod : vAgreement Terms ------------------------------------------------
		"U_AGREE_OVER13" => append_sid("profile.$phpEx?mode=register&amp;agreed=true"),
		"U_AGREE_UNDER13" => append_sid("profile.$phpEx?mode=register&amp;agreed=true&amp;coppa=true"))
	);

	$template->pparse('body');

}
//
// ---------------------------------------

$error = FALSE;
$error_msg = '';
$page_title = ( $mode == 'editprofile' ) ? $lang['Edit_profile'] : $lang['Register'];

//-- mod : vAgreement Terms ----------------------------------------------------
//-- delete
//	if ( $mode == 'register' && !isset($HTTP_POST_VARS['agreed']) && !isset($HTTP_GET_VARS['agreed']) )
//	{
//		include($phpbb_root_path . 'includes/page_header.'.$phpEx);
//
//		show_coppa();
//
//		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
//	}
//-- add
if ( $mode == 'register' && !isset($HTTP_POST_VARS['agreed']) && !isset($HTTP_POST_VARS['not_agreed']) )
{
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	show_coppa();

	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}
else if ( $mode == 'register' && !isset($HTTP_POST_VARS['agreed']) && isset($HTTP_POST_VARS['not_agreed']) )
{
	redirect(append_sid($phpbb_root_path . 'index.' . $phpEx, true));
	exit;
}
//-- fin mod : vAgreement Terms ------------------------------------------------

$coppa = ( empty($HTTP_POST_VARS['coppa']) && empty($HTTP_GET_VARS['coppa']) ) ? 0 : TRUE;

//
// Check and initialize some variables if needed
//
if (
	isset($HTTP_POST_VARS['submit']) ||
	isset($HTTP_POST_VARS['avatargallery']) ||
	isset($HTTP_POST_VARS['submitavatar']) ||
	isset($HTTP_POST_VARS['cancelavatar']) ||
	$mode == 'register' )
{
	include($phpbb_root_path . 'includes/functions_validate.'.$phpEx);
	include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
	include($phpbb_root_path . 'includes/functions_post.'.$phpEx);

	if ( $mode == 'editprofile' )
	{
		$user_id = intval($HTTP_POST_VARS['user_id']);
		$current_email = trim(htmlspecialchars($HTTP_POST_VARS['current_email']));
	}

  // Begin Account Self-Delete MOD
  if( $HTTP_POST_VARS['deleteuser'] )
  {
    $message = "<form action=\"". append_sid("profile.$phpEx?mode=editprofile") ."\" method=\"post\">". $lang['Delete_account_question'] ."<br /><br /><input type=\"submit\" name=\"delete_confirm\" value=\"". $lang['Yes'] ."\" class=\"mainoption\" />&nbsp;&nbsp;<input type=\"submit\" name=\"delete_cancel\" value=\"". $lang['No'] ."\" class=\"liteoption\" /><input type=\"hidden\" name=\"user_id\" value=\"$user_id\" /></form>";

    message_die(GENERAL_MESSAGE, $message);  
  }
  // End Account Self-Delete MOD	
	$strip_var_list = array('email' => 'email', 'icq' => 'icq', 'aim' => 'aim', 'msn' => 'msn', 'yim' => 'yim', 'website' => 'website', 'location' => 'location', 'occupation' => 'occupation', 'interests' => 'interests', 'reponse_conf' => 'reponse_conf', 'confirm_code' => 'confirm_code');

	// Strip all tags from data ... may p**s some people off, bah, strip_tags is
	// doing the job but can still break HTML output ... have no choice, have
	// to use htmlspecialchars ... be prepared to be moaned at.
	while( list($var, $param) = @each($strip_var_list) )
	{
		if ( !empty($HTTP_POST_VARS[$param]) )
		{
			$$var = trim(htmlspecialchars($HTTP_POST_VARS[$param]));
		}
	}

	$username = ( !empty($HTTP_POST_VARS['username']) ) ? phpbb_clean_username($HTTP_POST_VARS['username']) : '';

	$trim_var_list = array('cur_password' => 'cur_password', 'new_password' => 'new_password', 'password_confirm' => 'password_confirm', 'signature' => 'signature');

	while( list($var, $param) = @each($trim_var_list) )
	{
		if ( !empty($HTTP_POST_VARS[$param]) )
		{
			$$var = trim($HTTP_POST_VARS[$param]);
		}
	}

	$signature = (isset($signature)) ? str_replace('<br />', "\n", $signature) : '';
	$signature_bbcode_uid = '';
	// Start add - Gender MOD
	$gender = ( isset($HTTP_POST_VARS['gender']) ) ? intval ($HTTP_POST_VARS['gender']) : 0;
	// End add - Gender MOD	

	// Run some validation on the optional fields. These are pass-by-ref, so they'll be changed to
	// empty strings if they fail.
	validate_optional_fields($icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $signature);

	$viewemail = ( isset($HTTP_POST_VARS['viewemail']) ) ? ( ($HTTP_POST_VARS['viewemail']) ? TRUE : 0 ) : 0;
	$allowviewonline = ( isset($HTTP_POST_VARS['hideonline']) ) ? ( ($HTTP_POST_VARS['hideonline']) ? 0 : TRUE ) : TRUE;
	$notifyreply = ( isset($HTTP_POST_VARS['notifyreply']) ) ? ( ($HTTP_POST_VARS['notifyreply']) ? TRUE : 0 ) : 0;
	$notifypm = ( isset($HTTP_POST_VARS['notifypm']) ) ? ( ($HTTP_POST_VARS['notifypm']) ? TRUE : 0 ) : TRUE;
	$notifydonation = ( isset($HTTP_POST_VARS['notifydonation']) ) ? ( ($HTTP_POST_VARS['notifydonation']) ? TRUE : 0 ) : TRUE;	
	$popup_pm = ( isset($HTTP_POST_VARS['popup_pm']) ) ? ( ($HTTP_POST_VARS['popup_pm']) ? TRUE : 0 ) : TRUE;
// Default avatar MOD, By Manipe (Begin)
	$allowdefaultavatar = ( isset($HTTP_POST_VARS['allowdefaultavatar']) ) ? ( ($HTTP_POST_VARS['allowdefaultavatar']) ? TRUE : 0 ) : 0;
// Default avatar MOD, By Manipe (End)	
	$sid = (isset($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : 0;	

	if ( $mode == 'register' )
	{
		$attachsig = ( isset($HTTP_POST_VARS['attachsig']) ) ? ( ($HTTP_POST_VARS['attachsig']) ? TRUE : 0 ) : $board_config['allow_sig'];

		$allowhtml = ( isset($HTTP_POST_VARS['allowhtml']) ) ? ( ($HTTP_POST_VARS['allowhtml']) ? TRUE : 0 ) : $board_config['allow_html'];
		$allowbbcode = ( isset($HTTP_POST_VARS['allowbbcode']) ) ? ( ($HTTP_POST_VARS['allowbbcode']) ? TRUE : 0 ) : $board_config['allow_bbcode'];
		$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $board_config['allow_smilies'];
		$use_rel_date = ( isset($HTTP_POST_VARS['use_rel_date']) ) ? ( ($HTTP_POST_VARS['use_rel_date']) ? TRUE : 0 ) : $board_config['ty_use_rel_date'];
		$use_rel_time = ( isset($HTTP_POST_VARS['use_rel_time']) ) ? ( ($HTTP_POST_VARS['use_rel_time']) ? TRUE : 0 ) : $board_config['ty_use_rel_time'];		
	}
	else
	{
		$attachsig = ( isset($HTTP_POST_VARS['attachsig']) ) ? ( ($HTTP_POST_VARS['attachsig']) ? TRUE : 0 ) : $userdata['user_attachsig'];

		$allowhtml = ( isset($HTTP_POST_VARS['allowhtml']) ) ? ( ($HTTP_POST_VARS['allowhtml']) ? TRUE : 0 ) : $userdata['user_allowhtml'];
		$allowbbcode = ( isset($HTTP_POST_VARS['allowbbcode']) ) ? ( ($HTTP_POST_VARS['allowbbcode']) ? TRUE : 0 ) : $userdata['user_allowbbcode'];
		$allowsmilies = ( isset($HTTP_POST_VARS['allowsmilies']) ) ? ( ($HTTP_POST_VARS['allowsmilies']) ? TRUE : 0 ) : $userdata['user_allowsmile'];
		$use_rel_date = ( isset($HTTP_POST_VARS['use_rel_date']) ) ? ( ($HTTP_POST_VARS['use_rel_date']) ? TRUE : 0 ) : $userdata['user_use_rel_date'];
		$use_rel_time = ( isset($HTTP_POST_VARS['use_rel_time']) ) ? ( ($HTTP_POST_VARS['use_rel_time']) ? TRUE : 0 ) : $userdata['user_use_rel_time'];		
	}

	$user_style = ( isset($HTTP_POST_VARS['style']) ) ? intval($HTTP_POST_VARS['style']) : $board_config['default_style'];

	if ( !empty($HTTP_POST_VARS['language']) )
	{
		if ( preg_match('/^[a-z_]+$/i', $HTTP_POST_VARS['language']) )
		{
			$user_lang = htmlspecialchars($HTTP_POST_VARS['language']);
		}
		else
		{
			$error = true;
			$error_msg = $lang['Fields_empty'];
		}
	}
	else
	{
		$user_lang = $board_config['default_lang'];
	}

	$user_timezone = ( isset($HTTP_POST_VARS['timezone']) ) ? doubleval($HTTP_POST_VARS['timezone']) : $board_config['board_timezone'];
	$user_dateformat = ( !empty($HTTP_POST_VARS['dateformat']) ) ? trim(htmlspecialchars($HTTP_POST_VARS['dateformat'])) : $board_config['default_dateformat'];
	$user_colortext = ( $board_config['allow_colortext'] ) ? $HTTP_POST_VARS['colortext'] : '';	

	$user_avatar_local = ( isset($HTTP_POST_VARS['avatarselect']) && !empty($HTTP_POST_VARS['submitavatar']) && $board_config['allow_avatar_local'] ) ? htmlspecialchars($HTTP_POST_VARS['avatarselect']) : ( ( isset($HTTP_POST_VARS['avatarlocal'])  ) ? htmlspecialchars($HTTP_POST_VARS['avatarlocal']) : '' );
	$user_avatar_category = ( isset($HTTP_POST_VARS['avatarcatname']) && $board_config['allow_avatar_local'] ) ? htmlspecialchars($HTTP_POST_VARS['avatarcatname']) : '' ;

	$user_avatar_remoteurl = ( !empty($HTTP_POST_VARS['avatarremoteurl']) ) ? trim(htmlspecialchars($HTTP_POST_VARS['avatarremoteurl'])) : '';
	$user_avatar_upload = ( !empty($HTTP_POST_VARS['avatarurl']) ) ? trim($HTTP_POST_VARS['avatarurl']) : ( ( $HTTP_POST_FILES['avatar']['tmp_name'] != "none") ? $HTTP_POST_FILES['avatar']['tmp_name'] : '' );
	$user_avatar_name = ( !empty($HTTP_POST_FILES['avatar']['name']) ) ? $HTTP_POST_FILES['avatar']['name'] : '';
	$user_avatar_size = ( !empty($HTTP_POST_FILES['avatar']['size']) ) ? $HTTP_POST_FILES['avatar']['size'] : 0;
	$user_avatar_filetype = ( !empty($HTTP_POST_FILES['avatar']['type']) ) ? $HTTP_POST_FILES['avatar']['type'] : '';

	$user_avatar = ( empty($user_avatar_local) && $mode == 'editprofile' ) ? $userdata['user_avatar'] : '';
	$user_avatar_type = ( empty($user_avatar_local) && $mode == 'editprofile' ) ? $userdata['user_avatar_type'] : '';
//-- mod : flags ---------------------------------------------------------------
//-- add
	$flag = request_var('flag', TYPE_NO_HTML);
//-- fin mod : flags -----------------------------------------------------------	
//-- mod : birthday ------------------------------------------------------------
//-- add
	$bday_day = request_var('bday_day', TYPE_INT);
	$bday_month = request_var('bday_month', TYPE_INT);
	$bday_year = request_var('bday_year', TYPE_INT);

	// zodiac signs
	$user_zodiac = $birthday->zodiac->get_zodiac(array('d' => $bday_day, 'm' => $bday_month));
//-- fin mod : birthday --------------------------------------------------------	
//-- mod : quick post es -------------------------------------------------------
//-- add
	// config data
	if (!empty($board_config['users_qp_settings']))
	{
		list($board_config['user_qp'], $board_config['user_qp_show'], $board_config['user_qp_subject'], $board_config['user_qp_bbcode'], $board_config['user_qp_smilies'], $board_config['user_qp_more']) = explode('-', $board_config['users_qp_settings']);
	}

	$params = array('user_qp', 'user_qp_show', 'user_qp_subject', 'user_qp_bbcode', 'user_qp_smilies', 'user_qp_more');
	for($i = 0; $i < count($params); $i++)
	{
		$qp_config = ($mode == 'register') ? intval($board_config[$params[$i]]) : intval($userdata[$params[$i]]);
		$$params[$i] = (isset($HTTP_POST_VARS[$params[$i]])) ? (!empty($HTTP_POST_VARS[$params[$i]]) ? intval($HTTP_POST_VARS[$params[$i]]) : intval($$params[$i])) : $qp_config;
	}
//-- fin mod : quick post es ---------------------------------------------------	

	if ( (isset($HTTP_POST_VARS['avatargallery']) || isset($HTTP_POST_VARS['submitavatar']) || isset($HTTP_POST_VARS['cancelavatar'])) && (!isset($HTTP_POST_VARS['submit'])) )
	{
		$username = stripslashes($username);
		$email = stripslashes($email);
		$cur_password = htmlspecialchars(stripslashes($cur_password));
		$new_password = htmlspecialchars(stripslashes($new_password));
		$password_confirm = htmlspecialchars(stripslashes($password_confirm));

		$icq = stripslashes($icq);
		$aim = stripslashes($aim);
		$msn = stripslashes($msn);
		$yim = stripslashes($yim);

		$website = stripslashes($website);
		$location = stripslashes($location);
		$occupation = stripslashes($occupation);
		$interests = stripslashes($interests);
		$signature = htmlspecialchars(stripslashes($signature));

		$user_lang = stripslashes($user_lang);
		$user_dateformat = stripslashes($user_dateformat);

		if ( !isset($HTTP_POST_VARS['cancelavatar']))
		{
			$user_avatar = $user_avatar_category . '/' . $user_avatar_local;
			$user_avatar_type = USER_AVATAR_GALLERY;
		}
	}
}

// Begin Account Self-Delete MOD ** Code from admin/admin_users.php
if( isset($HTTP_POST_VARS['delete_confirm']) )
{  
  $user_id = intval( $HTTP_POST_VARS['user_id'] );

  $sql = "SELECT g.group_id 
    FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g  
    WHERE ug.user_id = $user_id 
    AND g.group_id = ug.group_id 
    AND g.group_single_user = 1";
  if( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not obtain group information for this user', '', __LINE__, __FILE__, $sql);
  }

  $row = $db->sql_fetchrow($result);

  $sql = "UPDATE " . POSTS_TABLE . "
    SET poster_id = " . DELETED . ", post_username = '$username' 
    WHERE poster_id = $user_id";
  if( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not update posts for this user', '', __LINE__, __FILE__, $sql);
  }

  $sql = "UPDATE " . TOPICS_TABLE . "
    SET topic_poster = " . DELETED . " 
    WHERE topic_poster = $user_id";
  if( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not update topics for this user', '', __LINE__, __FILE__, $sql);
  }
			
  $sql = "UPDATE " . VOTE_USERS_TABLE . "
    SET vote_user_id = " . DELETED . "
    WHERE vote_user_id = $user_id";
  if( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not update votes for this user', '', __LINE__, __FILE__, $sql);
  }
			
  $sql = "SELECT group_id
    FROM " . GROUPS_TABLE . "
    WHERE group_moderator = $user_id";
  if( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not select groups where user was moderator', '', __LINE__, __FILE__, $sql);
  }
			
  while ( $row_group = $db->sql_fetchrow($result) )
  {
    $group_moderator[] = $row_group['group_id'];
  }
			
  if ( count($group_moderator) )
  {
    $update_moderator_id = implode(', ', $group_moderator);
			
    $sql = "UPDATE " . GROUPS_TABLE . "
      SET group_moderator = " . $userdata['user_id'] . "
      WHERE group_moderator IN ($update_moderator_id)";
    if( !$db->sql_query($sql) )
    {
      message_die(GENERAL_ERROR, 'Could not update group moderators', '', __LINE__, __FILE__, $sql);
    }
  }

  $sql = "DELETE FROM " . USERS_TABLE . "
    WHERE user_id = $user_id";
  if( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not delete user', '', __LINE__, __FILE__, $sql);
  }

  $sql = "DELETE FROM " . USER_GROUP_TABLE . "
    WHERE user_id = $user_id";
  if( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not delete user from user_group table', '', __LINE__, __FILE__, $sql);
  }

  $sql = "DELETE FROM " . GROUPS_TABLE . "
    WHERE group_id = " . $row['group_id'];
  if( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not delete group for this user', '', __LINE__, __FILE__, $sql);
  }

  $sql = "DELETE FROM " . AUTH_ACCESS_TABLE . "
    WHERE group_id = " . $row['group_id'];
  if( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not delete group for this user', '', __LINE__, __FILE__, $sql);
  }

  $sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
    WHERE user_id = $user_id";
  if ( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not delete user from topic watch table', '', __LINE__, __FILE__, $sql);
  }
			
  $sql = "DELETE FROM " . BANLIST_TABLE . "
    WHERE ban_userid = $user_id";
  if ( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not delete user from banlist table', '', __LINE__, __FILE__, $sql);
  }

  $sql = "SELECT privmsgs_id
    FROM " . PRIVMSGS_TABLE . "
    WHERE privmsgs_from_userid = $user_id 
    OR privmsgs_to_userid = $user_id";
  if ( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not select all users private messages', '', __LINE__, __FILE__, $sql);
  }

  // This little bit of code directly from the private messaging section.
  while ( $row_privmsgs = $db->sql_fetchrow($result) )
  {
    $mark_list[] = $row_privmsgs['privmsgs_id'];
  }
			
  if ( count($mark_list) )
  {
    $delete_sql_id = implode(', ', $mark_list);
		
    $delete_text_sql = "DELETE FROM " . PRIVMSGS_TEXT_TABLE . "
      WHERE privmsgs_text_id IN ($delete_sql_id)";
    $delete_sql = "DELETE FROM " . PRIVMSGS_TABLE . "
      WHERE privmsgs_id IN ($delete_sql_id)";
				
    if ( !$db->sql_query($delete_sql) )
    {
      message_die(GENERAL_ERROR, 'Could not delete private message info', '', __LINE__, __FILE__, $delete_sql);
    }
				
    if ( !$db->sql_query($delete_text_sql) )
    {
      message_die(GENERAL_ERROR, 'Could not delete private message text', '', __LINE__, __FILE__, $delete_text_sql);
    }
  }
  $db->clear_cache('usercount');

  $message = $lang['User_deleted'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

  message_die(GENERAL_MESSAGE, $message);
}
// End Account Self-Delete MOD
//
// Let's make sure the user isn't logged in while registering,
// and ensure that they were trying to register a second time
// (Prevents double registrations)
//
if ($mode == 'register' && ($userdata['session_logged_in'] || $username == $userdata['username']))
{
	message_die(GENERAL_MESSAGE, $lang['Username_taken'], '', __LINE__, __FILE__);
}

//
// Did the user submit? In this case build a query to update the users profile in the DB
//
if ( isset($HTTP_POST_VARS['submit']) )
{
	include($phpbb_root_path . 'includes/usercp_avatar.'.$phpEx);
	// session id check
	if ($sid == '' || $sid != $userdata['session_id'])
	{
		$error = true;
		$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Session_invalid'];
	}	

	$passwd_sql = '';
	if ( $mode == 'editprofile' )
	{
		if ( $user_id != $userdata['user_id'] )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Wrong_Profile'];
		}
	}
	else if ( $mode == 'register' )
	{
		if ( empty($username) || empty($new_password) || empty($password_confirm) || empty($email) )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Fields_empty'];
		}
	
       else if ($board_config['question_conf_enable'])
	   {
            if ( empty($reponse_conf))
			{ 
            message_die(GENERAL_MESSAGE, $lang['Question_conf_fields_empty'], '', __LINE__, __FILE__);
			}
			if ($reponse_conf != $board_config['reponse_conf']) 
            { 
            message_die(GENERAL_MESSAGE, $lang['Question_conf_fields_false'], '', __LINE__, __FILE__);
			}
		} 
	}

	if ($board_config['enable_confirm'] && $mode == 'register')
	{
		if (empty($HTTP_POST_VARS['confirm_id']))
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Confirm_code_wrong'];
		}
		else
		{
			$confirm_id = htmlspecialchars($HTTP_POST_VARS['confirm_id']);
			if (!preg_match('/^[A-Za-z0-9]+$/', $confirm_id))
			{
				$confirm_id = '';
			}
			
			$sql = 'SELECT code 
				FROM ' . CONFIRM_TABLE . " 
				WHERE confirm_id = '$confirm_id' 
					AND session_id = '" . $userdata['session_id'] . "'";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not obtain confirmation code', '', __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				if ($row['code'] != $confirm_code)
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Confirm_code_wrong'];
				}
				else
				{
					$sql = 'DELETE FROM ' . CONFIRM_TABLE . " 
						WHERE confirm_id = '$confirm_id' 
							AND session_id = '" . $userdata['session_id'] . "'";
					if (!$db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not delete confirmation code', '', __LINE__, __FILE__, $sql);
					}
				}
			}
			else
			{		
				$error = TRUE;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Confirm_code_wrong'];
			}
			$db->sql_freeresult($result);
		}
	}

	$passwd_sql = '';
	if ( !empty($new_password) && !empty($password_confirm) )
	{
		if ( $new_password != $password_confirm )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
		}
		else if ( strlen($new_password) > 32 )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_long'];
		}
		else
		{
			if ( $mode == 'editprofile' )
			{
				$sql = "SELECT user_password
					FROM " . USERS_TABLE . "
					WHERE user_id = $user_id";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not obtain user_password information', '', __LINE__, __FILE__, $sql);
				}

				$row = $db->sql_fetchrow($result);

				if ( $row['user_password'] != md5($cur_password) )
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Current_password_mismatch'];
				}
			}

			if ( !$error )
			{
				$new_password = md5($new_password);
				$passwd_sql = "user_password = '$new_password', ";
			}
		}
	}
	else if ( ( empty($new_password) && !empty($password_confirm) ) || ( !empty($new_password) && empty($password_confirm) ) )
	{
		$error = TRUE;
		$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Password_mismatch'];
	}

	//
	// Do a ban check on this email address
	//
	if ( $email != $userdata['user_email'] || $mode == 'register' )
	{
		$result = validate_email($email);
		if ( $result['error'] )
		{
			$email = $userdata['user_email'];

			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $result['error_msg'];
		}

		if ( $mode == 'editprofile' )
		{
			$sql = "SELECT user_password
				FROM " . USERS_TABLE . "
				WHERE user_id = $user_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain user_password information', '', __LINE__, __FILE__, $sql);
			}

			$row = $db->sql_fetchrow($result);

			if ( $row['user_password'] != md5($cur_password) )
			{
				$email = $userdata['user_email'];

				$error = TRUE;
				$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Current_password_mismatch'];
			}
		}
	}

	$username_sql = '';
	if ( $board_config['allow_namechange'] || $mode == 'register' )
	{
		if ( empty($username) )
		{
			// Error is already triggered, since one field is empty.
			$error = TRUE;
		}
		else if ( $username != $userdata['username'] || $mode == 'register')
		{
			if (strtolower($username) != strtolower($userdata['username']) || $mode == 'register')
			{
				$result = validate_username($username);
				if ( $result['error'] )
				{
					$error = TRUE;
					$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $result['error_msg'];
				}
			}

			if (!$error)
			{
				$username_sql = "username = '" . str_replace("\'", "''", $username) . "', ";
			}
		}
	}

	if ( $signature != '' )
	{
		if ( strlen($signature) > $board_config['max_sig_chars'] )
		{
			$error = TRUE;
			$error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Signature_too_long'];
		}

		if ( !isset($signature_bbcode_uid) || $signature_bbcode_uid == '' )
		{
			$signature_bbcode_uid = ( $allowbbcode ) ? make_bbcode_uid() : '';
		}
		$signature = prepare_message($signature, $allowhtml, $allowbbcode, $allowsmilies, $signature_bbcode_uid);
	}

	if ( $website != '' )
	{
		rawurlencode($website);
	}
// Start Website Signature removal mod
	if ( ($mode == 'register') && (($signature != '')||($website != '')) )
	{
		if ($ban_ip == true)
		{
			$sql = "INSERT INTO ".BANLIST_TABLE." (`ban_ip`) VALUES ('".$userdata['session_ip']."')";
			if ( !$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't insert ban_ip info into database", "", __LINE__, __FILE__, $sql);
			}
		}
		session_end($userdata['session_id'], $userdata['user_id']);
		message_die(GENERAL_ERROR, 'Die robot!');
	}
// End Website Signature removal mod	

	$avatar_sql = '';

	if ( isset($HTTP_POST_VARS['avatardel']) && $mode == 'editprofile' )
	{
		$avatar_sql = user_avatar_delete($userdata['user_avatar_type'], $userdata['user_avatar']);
	}
	else
	if ( ( !empty($user_avatar_upload) || !empty($user_avatar_name) ) && $board_config['allow_avatar_upload'] )
	{
		if ( !empty($user_avatar_upload) )
		{
			$avatar_mode = (empty($user_avatar_name)) ? 'remote' : 'local';
			$avatar_sql = user_avatar_upload($mode, $avatar_mode, $userdata['user_avatar'], $userdata['user_avatar_type'], $error, $error_msg, $user_avatar_upload, $user_avatar_name, $user_avatar_size, $user_avatar_filetype);
		}
		else if ( !empty($user_avatar_name) )
		{
			$l_avatar_size = sprintf($lang['Avatar_filesize'], round($board_config['avatar_filesize'] / 1024));

			$error = true;
			$error_msg .= ( ( !empty($error_msg) ) ? '<br />' : '' ) . $l_avatar_size;
		}
	}
	else if ( $user_avatar_remoteurl != '' && $board_config['allow_avatar_remote'] )
	{
		user_avatar_delete($userdata['user_avatar_type'], $userdata['user_avatar']);
		$avatar_sql = user_avatar_url($mode, $error, $error_msg, $user_avatar_remoteurl);
	}
	else if ( $user_avatar_local != '' && $board_config['allow_avatar_local'] )
	{
		user_avatar_delete($userdata['user_avatar_type'], $userdata['user_avatar']);
		$avatar_sql = user_avatar_gallery($mode, $error, $error_msg, $user_avatar_local, $user_avatar_category);
	}
   // Start add - Gender Mod
   if ( $board_config['gender_required'] )
   {
      if (!$gender)
      {
         $error = TRUE;
         $error_msg .= ( ( isset($error_msg) ) ? '<br />' : '' ) . $lang['Gender_require'];
      }
   }
// End add - Gender Mod	
	
//-- mod : birthday ------------------------------------------------------------
//-- add
	$birthdate_invalid = empty($bday_day) || empty($bday_month) || empty($bday_year);
	if ( $birthdate_invalid && !empty($board_config['bday_require']) )
	{
		$error = true;
		$error_msg .= ( isset($error_msg) ? '<br />' : '' ) . $lang['birthday_invalid'];
	}
//-- fin mod : birthday --------------------------------------------------------	

	if ( !$error )
	{
		if ( $avatar_sql == '' )
		{
			$avatar_sql = ( $mode == 'editprofile' ) ? '' : "'', " . USER_AVATAR_NONE;
		}

		if ( $mode == 'editprofile' )
		{
			if ( $email != $userdata['user_email'] && $board_config['require_activation'] != USER_ACTIVATION_NONE && $userdata['user_level'] != ADMIN )
			{
				$user_active = 0;

				$user_actkey = gen_rand_string(true);
				$key_len = 54 - ( strlen($server_url) );
				$key_len = ( $key_len > 6 ) ? $key_len : 6;
				$user_actkey = substr($user_actkey, 0, $key_len);

				if ( $userdata['session_logged_in'] )
				{
					session_end($userdata['session_id'], $userdata['user_id']);
				}
			}
			else
			{
				$user_active = 'user_active'; 
				$user_actkey = 'user_actkey';
			}
			
//-- mod : quick post es -------------------------------------------------------
//-- add
			$qp_data = array($user_qp, $user_qp_show, $user_qp_subject, $user_qp_bbcode, $user_qp_smilies, $user_qp_more);
			$user_qp_settings = implode('-', $qp_data);
// here we added
//	, user_qp_settings = '" . $user_qp_settings . "'
//	, user_colortext = '$user_colortext'
//	, user_gender = '$gender'
//-- modify
			$sql = "UPDATE " . USERS_TABLE . "
				SET " . $username_sql . $passwd_sql . "user_email = '" . str_replace("\'", "''", $email) ."', user_icq = '" . str_replace("\'", "''", $icq) . "', user_website = '" . str_replace("\'", "''", $website) . "', user_occ = '" . str_replace("\'", "''", $occupation) . "', user_from = '" . str_replace("\'", "''", $location) . "', user_interests = '" . str_replace("\'", "''", $interests) . "', user_sig = '" . str_replace("\'", "''", $signature) . "', user_sig_bbcode_uid = '$signature_bbcode_uid', user_viewemail = $viewemail, user_aim = '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', user_yim = '" . str_replace("\'", "''", $yim) . "', user_msnm = '" . str_replace("\'", "''", $msn) . "', user_attachsig = $attachsig, user_colortext = '$user_colortext', user_qp_settings = '" . $user_qp_settings . "', user_allowsmile = $allowsmilies, user_allowhtml = $allowhtml, user_allowbbcode = $allowbbcode, user_allow_viewonline = $allowviewonline, user_notify = $notifyreply, user_notify_pm = $notifypm, user_notify_donation = $notifydonation, user_popup_pm = $popup_pm, user_timezone = $user_timezone, user_use_rel_date = $use_rel_date, user_use_rel_time = $use_rel_time, user_dateformat = '" . str_replace("\'", "''", $user_dateformat) . "', user_lang = '" . str_replace("\'", "''", $user_lang) . "', user_style = $user_style, user_active = $user_active, user_actkey = '$user_actkey'" . $avatar_sql . ", user_allowdefaultavatar = $allowdefaultavatar, user_gender = '$gender'
				WHERE user_id = $user_id";
//-- mod : flags ---------------------------------------------------------------
//-- add
			$sql = str_replace('SET ', 'SET user_flag = \'' . str_replace("\'", "''", $flag) . '\', ', $sql);
//-- fin mod : flags -----------------------------------------------------------				
//-- fin mod : quick post es ---------------------------------------------------
//-- mod : birthday ------------------------------------------------------------
//-- add
			$sql = str_replace('SET ', 'SET user_birthday = \'' . $birthday->pack(array('d' => $bday_day, 'm' => $bday_month, 'y' => $bday_year)) . '\', user_zodiac = ' . $user_zodiac . ', ', $sql);
//-- fin mod : birthday --------------------------------------------------------				
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql);
			}

			// We remove all stored login keys since the password has been updated
			// and change the current one (if applicable)
			if ( !empty($passwd_sql) )
			{
				session_reset_keys($user_id, $user_ip);
			}

			if ( !$user_active )
			{
				//
				// The users account has been deactivated, send them an email with a new activation key
				//
				include($phpbb_root_path . 'includes/emailer.'.$phpEx);
				$emailer = new emailer($board_config['smtp_delivery']);

 				if ( $board_config['require_activation'] != USER_ACTIVATION_ADMIN )
 				{
 					$emailer->from($board_config['board_email']);
 					$emailer->replyto($board_config['board_email']);
 
 					$emailer->use_template('user_activate', stripslashes($user_lang));
 					$emailer->email_address($email);
 					$emailer->set_subject($lang['Reactivate']);
  
 					$emailer->assign_vars(array(
 						'SITENAME' => $board_config['sitename'],
 						'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
 						'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
  
 						'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
 					);
 					$emailer->send();
 					$emailer->reset();
 				}
 				else if ( $board_config['require_activation'] == USER_ACTIVATION_ADMIN )
 				{
 					$sql = 'SELECT user_email, user_lang 
 						FROM ' . USERS_TABLE . '
 						WHERE user_level = ' . ADMIN;
 					
 					if ( !($result = $db->sql_query($sql)) )
 					{
 						message_die(GENERAL_ERROR, 'Could not select Administrators', '', __LINE__, __FILE__, $sql);
 					}
 					
 					while ($row = $db->sql_fetchrow($result))
 					{
 						$emailer->from($board_config['board_email']);
 						$emailer->replyto($board_config['board_email']);
 						
 						$emailer->email_address(trim($row['user_email']));
 						$emailer->use_template("admin_activate", $row['user_lang']);
 						$emailer->set_subject($lang['Reactivate']);
 
 						$emailer->assign_vars(array(
 							'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
 							'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),
 
 							'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
 						);
 						$emailer->send();
 						$emailer->reset();
 					}
 					$db->sql_freeresult($result);
 				}

				$message = $lang['Profile_updated_inactive'] . '<br /><br />' . sprintf($lang['Click_return_index'],  '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
			}
			else
			{
				$message = $lang['Profile_updated'] . '<br /><br />' . sprintf($lang['Profile_see'],  '<a href="' . append_sid('profile.' . $phpEx . '?mode=editprofile&u=' . $userdata['user_id']) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'],  '<a href="' . append_sid("index.$phpEx") . '">', '</a>');
			}

			$template->assign_vars(array(
				"META" => '<meta http-equiv="refresh" content="5;url=' . append_sid("index.$phpEx") . '">')
			);

			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$sql = "SELECT MAX(user_id) AS total
				FROM " . USERS_TABLE;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain next user_id information', '', __LINE__, __FILE__, $sql);
			}

			if ( !($row = $db->sql_fetchrow($result)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain next user_id information', '', __LINE__, __FILE__, $sql);
			}
			$user_id = $row['total'] + 1;

			//
			// Get current date
			//
//-- mod : quick post es -------------------------------------------------------
//-- add
			$qp_data = array($user_qp, $user_qp_show, $user_qp_subject, $user_qp_bbcode, $user_qp_smilies, $user_qp_more);
			$user_qp_settings = implode('-', $qp_data);
//-- mod : birthday ------------------------------------------------------------
// here we added
//	, user_birthday, user_zodiac
//	, '" . $birthday->pack(array('d' => $bday_day, 'm' => $bday_month, 'y' => $bday_year)) . "', $user_zodiac
//	, user_qp_settings
//	, '" . $user_qp_settings . "'
//	, user_flag
//	, '" . str_replace("\'", "''", $flag) . "'
//	, user_colortext, '" . str_replace("\'", "''", $user_colortext) . "'
//	, user_gender
//	, '$gender'
//-- modify			
			$sql = "INSERT INTO " . USERS_TABLE . "	(user_id, username, user_regdate, user_password, user_email, user_icq, user_website, user_occ, user_from, user_interests, reponse_conf, user_flag, user_birthday, user_zodiac, user_sig, user_qp_settings, user_sig_bbcode_uid, user_avatar, user_avatar_type, user_viewemail, user_aim, user_yim, user_msnm, user_attachsig, user_colortext, user_allowsmile, user_allowhtml, user_allowbbcode, user_allow_viewonline, user_notify, user_notify_pm, user_notify_donation, user_popup_pm, user_timezone, user_use_rel_date, user_use_rel_time, user_dateformat, user_lang, user_style, user_gender, user_level, user_allow_pm, user_active, user_actkey)
				VALUES ($user_id, '" . str_replace("\'", "''", $username) . "', " . time() . ", '" . str_replace("\'", "''", $new_password) . "', '" . str_replace("\'", "''", $email) . "', '" . str_replace("\'", "''", $icq) . "', '" . str_replace("\'", "''", $website) . "', '" . str_replace("\'", "''", $occupation) . "', '" . str_replace("\'", "''", $location) . "', '" . str_replace("\'", "''", $interests) . "', '" . str_replace("\'", "''", $reponse_conf) . "', '" . str_replace("\'", "''", $flag) . "', '" . $birthday->pack(array('d' => $bday_day, 'm' => $bday_month, 'y' => $bday_year)) . "', $user_zodiac, '" . str_replace("\'", "''", $signature) . "', '" . $user_qp_settings . "', '$signature_bbcode_uid', $avatar_sql, $viewemail, '" . str_replace("\'", "''", str_replace(' ', '+', $aim)) . "', '" . str_replace("\'", "''", $yim) . "', '" . str_replace("\'", "''", $msn) . "', $attachsig, '" . str_replace("\'", "''", $user_colortext) . "', $allowsmilies, $allowhtml, $allowbbcode, $allowviewonline, $notifyreply, $notifypm, $notifydonation, $popup_pm, $user_timezone, $use_rel_date, $use_rel_time, '" . str_replace("\'", "''", $user_dateformat) . "', '" . str_replace("\'", "''", $user_lang) . "', $user_style, '$gender', 0, 1, ";
//-- fin mod : flags -----------------------------------------------------------				
//-- fin mod : quick post es ---------------------------------------------------
//-- fin mod : birthday --------------------------------------------------------				
			if ( $board_config['require_activation'] == USER_ACTIVATION_SELF || $board_config['require_activation'] == USER_ACTIVATION_ADMIN || $coppa )
			{
				$user_actkey = gen_rand_string(true);
				$key_len = 54 - (strlen($server_url));
				$key_len = ( $key_len > 6 ) ? $key_len : 6;
				$user_actkey = substr($user_actkey, 0, $key_len);
				$sql .= "0, '" . str_replace("\'", "''", $user_actkey) . "')";
			}
			else
			{
				$sql .= "1, '')";
			}

			if ( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert data into users table', '', __LINE__, __FILE__, $sql);
			}

			$sql = "INSERT INTO " . GROUPS_TABLE . " (group_name, group_description, group_single_user, group_moderator)
				VALUES ('', 'Personal User', 1, 0)";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert data into groups table', '', __LINE__, __FILE__, $sql);
			}

			$group_id = $db->sql_nextid();

			$sql = "INSERT INTO " . USER_GROUP_TABLE . " (user_id, group_id, user_pending)
				VALUES ($user_id, $group_id, 0)";
			if( !($result = $db->sql_query($sql, END_TRANSACTION)) )
			{
				message_die(GENERAL_ERROR, 'Could not insert data into user_group table', '', __LINE__, __FILE__, $sql);
			}

			$db->clear_cache('users_');

			if ( $coppa )
			{
				$message = $lang['COPPA'];
				$email_template = 'coppa_welcome_inactive';
			}
			else if ( $board_config['require_activation'] == USER_ACTIVATION_SELF )
			{
				$message = $lang['Account_inactive'];
				$email_template = 'user_welcome_inactive';
			}
			else if ( $board_config['require_activation'] == USER_ACTIVATION_ADMIN )
			{
				$message = $lang['Account_inactive_admin'];
				$email_template = 'admin_welcome_inactive';
			}
			else
			{
				$message = $lang['Account_added'];
				$email_template = 'user_welcome';
			}

			include($phpbb_root_path . 'includes/emailer.'.$phpEx);
			$emailer = new emailer($board_config['smtp_delivery']);

			$emailer->from($board_config['board_email']);
			$emailer->replyto($board_config['board_email']);

			$emailer->use_template($email_template, stripslashes($user_lang));
			$emailer->email_address($email);
			$emailer->set_subject(sprintf($lang['Welcome_subject'], $board_config['sitename']));

			if( $coppa )
			{
				$emailer->assign_vars(array(
					'SITENAME' => $board_config['sitename'],
					'WELCOME_MSG' => sprintf($lang['Welcome_subject'], $board_config['sitename']),
					'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
					'PASSWORD' => $password_confirm,
					'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),

					'FAX_INFO' => $board_config['coppa_fax'],
					'MAIL_INFO' => $board_config['coppa_mail'],
					'EMAIL_ADDRESS' => $email,
					'ICQ' => $icq,
					'AIM' => $aim,
					'YIM' => $yim,
					'MSN' => $msn,
					'WEB_SITE' => $website,
					'FROM' => $location,
					'OCC' => $occupation,
					'INTERESTS' => $interests,
					'SITENAME' => $board_config['sitename']));
			}
			else
			{
				$emailer->assign_vars(array(
					'SITENAME' => $board_config['sitename'],
					'WELCOME_MSG' => sprintf($lang['Welcome_subject'], $board_config['sitename']),
					'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
					'PASSWORD' => $password_confirm,
					'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),

					'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
				);
			}

			$emailer->send();
			$emailer->reset();

			if ( $board_config['require_activation'] == USER_ACTIVATION_ADMIN )
			{
				$sql = "SELECT user_email, user_lang 
					FROM " . USERS_TABLE . "
					WHERE user_level = " . ADMIN;
				
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not select Administrators', '', __LINE__, __FILE__, $sql);
				}
				
				while ($row = $db->sql_fetchrow($result))
				{
					$emailer->from($board_config['board_email']);
					$emailer->replyto($board_config['board_email']);
					
					$emailer->email_address(trim($row['user_email']));
					$emailer->use_template("admin_activate", $row['user_lang']);
					$emailer->set_subject($lang['New_account_subject']);

					$emailer->assign_vars(array(
						'USERNAME' => preg_replace($unhtml_specialchars_match, $unhtml_specialchars_replace, substr(str_replace("\'", "'", $username), 0, 25)),
						'EMAIL_SIG' => str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']),

						'U_ACTIVATE' => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $user_id . '&act_key=' . $user_actkey)
					);
					$emailer->send();
					$emailer->reset();
				}
				$db->sql_freeresult($result);
			}
  			$db->clear_cache('usercount');

			$message = $message . '<br /><br />' . sprintf($lang['Click_return_index'],  '<a href="' . append_sid("index.$phpEx") . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
		} // if mode == register
	}
} // End of submit


if ( $error )
{
	//
	// If an error occured we need to stripslashes on returned data
	//
	$username = stripslashes($username);
	$email = stripslashes($email);
	$cur_password = '';
	$new_password = '';
	$password_confirm = '';

	$icq = stripslashes($icq);
	$aim = str_replace('+', ' ', stripslashes($aim));
	$msn = stripslashes($msn);
	$yim = stripslashes($yim);

	$website = stripslashes($website);
	$location = stripslashes($location);
	$occupation = stripslashes($occupation);
	$interests = stripslashes($interests);
	//Ajout confirmation écrite
	$reponse_conf = stripslashes($reponse_conf);
	//Fin confirmation écrite
	$signature = stripslashes($signature);
	$signature = ($signature_bbcode_uid != '') ? preg_replace("/:(([a-z0-9]+:)?)$signature_bbcode_uid(=|\])/si", '\\3', $signature) : $signature;
	$user_colortext = stripslashes($user_colortext);	

	$user_lang = stripslashes($user_lang);
	$user_dateformat = stripslashes($user_dateformat);

}
else if ( $mode == 'editprofile' && !isset($HTTP_POST_VARS['avatargallery']) && !isset($HTTP_POST_VARS['submitavatar']) && !isset($HTTP_POST_VARS['cancelavatar']) )
{
	$user_id = $userdata['user_id'];
	$username = $userdata['username'];
	$email = $userdata['user_email'];
	$cur_password = '';
	$new_password = '';
	$password_confirm = '';

	$icq = $userdata['user_icq'];
	$aim = str_replace('+', ' ', $userdata['user_aim']);
	$msn = $userdata['user_msnm'];
	$yim = $userdata['user_yim'];

	$website = $userdata['user_website'];
	$location = $userdata['user_from'];
	$occupation = $userdata['user_occ'];
	$interests = $userdata['user_interests'];
// Start add - Gender MOD
$gender=$userdata['user_gender']; 
// End add - Gender MOD	
	$signature_bbcode_uid = $userdata['user_sig_bbcode_uid'];
	$signature = ($signature_bbcode_uid != '') ? preg_replace("/:(([a-z0-9]+:)?)$signature_bbcode_uid(=|\])/si", '\\3', $userdata['user_sig']) : $userdata['user_sig'];
	$user_colortext = $userdata['user_colortext'];	

	$viewemail = $userdata['user_viewemail'];
	$notifypm = $userdata['user_notify_pm'];
	$popup_pm = $userdata['user_popup_pm'];
	$notifyreply = $userdata['user_notify'];
	$notifydonation = $userdata['user_notify_donation'];
	$attachsig = $userdata['user_attachsig'];
//-- mod : flags ---------------------------------------------------------------
//-- add
	$flag = htmlspecialchars($userdata['user_flag']);
//-- fin mod : flags -----------------------------------------------------------	
//-- mod : birthday ------------------------------------------------------------
//-- add
	$bday_day = $bday_month = $bday_year = 0;
	if ( !empty($userdata['user_birthday']) )
	{
		list($bday_month, $bday_day, $bday_year) = explode('-', $userdata['user_birthday']);
	}
//-- fin mod : birthday --------------------------------------------------------	
//-- mod : quick post es -------------------------------------------------------
//-- add
	$user_qp = $user_qp_show = $user_qp_subject = $user_qp_bbcode = $user_qp_smilies = $user_qp_more = 0;
	if (!empty($userdata['user_qp_settings']))
	{
		list($user_qp, $user_qp_show, $user_qp_subject, $user_qp_bbcode, $user_qp_smilies, $user_qp_more) = explode('-', $userdata['user_qp_settings']);
	}
//-- fin mod : quick post es ---------------------------------------------------	
	$allowhtml = $userdata['user_allowhtml'];
	$allowbbcode = $userdata['user_allowbbcode'];
	$allowsmilies = $userdata['user_allowsmile'];
	$allowviewonline = $userdata['user_allow_viewonline'];
// Default avatar MOD, By Manipe (Begin)
	$allowdefaultavatar = $userdata['user_allowdefaultavatar'];
// Default avatar MOD, By Manipe (End)	

	$user_avatar = ( $userdata['user_allowavatar'] ) ? $userdata['user_avatar'] : '';
	$user_avatar_type = ( $userdata['user_allowavatar'] ) ? $userdata['user_avatar_type'] : USER_AVATAR_NONE;

	$user_style = $userdata['user_style'];
	$user_lang = $userdata['user_lang'];
	$user_timezone = $userdata['user_timezone'];
	$use_rel_date = $userdata['user_use_rel_date'];				
	$use_rel_time = $userdata['user_use_rel_time'];	
	$user_dateformat = $userdata['user_dateformat'];
}

//
// Default pages
//
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

make_jumpbox('viewforum.'.$phpEx);

if ( $mode == 'editprofile' )
{
	if ( $user_id != $userdata['user_id'] )
	{
		$error = TRUE;
		$error_msg = $lang['Wrong_Profile'];
	}
}

if( isset($HTTP_POST_VARS['avatargallery']) && !$error )
{
	include($phpbb_root_path . 'includes/usercp_avatar.'.$phpEx);

	$avatar_category = ( !empty($HTTP_POST_VARS['avatarcategory']) ) ? htmlspecialchars($HTTP_POST_VARS['avatarcategory']) : '';

	$template->set_filenames(array(
		'body' => 'profile_avatar_gallery.tpl')
	);

	$allowviewonline = !$allowviewonline;

//-- mod : quick post es -------------------------------------------------------
//-- add
	$qp_data = array($user_qp, $user_qp_show, $user_qp_subject, $user_qp_bbcode, $user_qp_smilies, $user_qp_more);
	$user_qp_settings = implode('-', $qp_data);
//-- mod : birthday ------------------------------------------------------------
// here we added
//	, $bday_day, $bday_month, $bday_year
//	, $user_qp_settings
//	, $flag
//	, $user_colortext
//	, $gender
//-- modify	
	display_avatar_gallery($mode, $avatar_category, $user_id, $email, $current_email, $coppa, $username, $email, $new_password, $cur_password, $password_confirm, $icq, $aim, $msn, $yim, $website, $location, $occupation, $interests, $flag, $bday_day, $bday_month, $bday_year, $signature, $viewemail, $notifypm, $popup_pm, $notifyreply, $attachsig, $user_colortext, $allowhtml, $allowbbcode, $allowsmilies, $allowviewonline, $user_style, $user_lang, $user_timezone, $user_dateformat, $userdata['session_id'], $user_qp_settings, $gender);
//-- fin mod : flags -----------------------------------------------------------	
//-- fin mod : quick post es ---------------------------------------------------
//-- fin mod : birthday --------------------------------------------------------	
}
else
{
	include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);

	if ( !isset($coppa) )
	{
		$coppa = FALSE;
	}

	if ( !isset($user_style) )
	{
		$user_style = $board_config['default_style'];
	}

	$avatar_img = '';
	if ( $user_avatar_type )
	{
		switch( $user_avatar_type )
		{
			case USER_AVATAR_UPLOAD:
				$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img onload="rmwa_img_loaded(this,' .  $board_config['avatar_max_width'] . ',' .  $board_config['avatar_max_height'] . ')"' . ' src="' . $board_config['avatar_path'] . '/' . $user_avatar . '" alt="" />' : '';
				break;
			case USER_AVATAR_REMOTE:
				$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img onload="rmwa_img_loaded(this,' .  $board_config['avatar_max_width'] . ',' .  $board_config['avatar_max_height'] . ')"' . ' src="' . $user_avatar . '" alt="" />' : '';
				break;
			case USER_AVATAR_GALLERY:
				$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img onload="rmwa_img_loaded(this,' .  $board_config['avatar_max_width'] . ',' .  $board_config['avatar_max_height'] . ')"' . ' src="' . $board_config['avatar_gallery_path'] . '/' . $user_avatar . '" alt="" />' : '';
				break;
		}
	}

	$s_hidden_fields = '<input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="agreed" value="true" /><input type="hidden" name="coppa" value="' . $coppa . '" />';
//-- mod : vAgreement Terms ----------------------------------------------------
//-- add
	$s_hidden_fields .= '<input type="hidden" name="not_agreed" value="false" />';
//-- fin mod : vAgreement Terms ------------------------------------------------	
	$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';	
	if( $mode == 'editprofile' )
	{
		$s_hidden_fields .= '<input type="hidden" name="user_id" value="' . $userdata['user_id'] . '" />';
		//
		// Send the users current email address. If they change it, and account activation is turned on
		// the user account will be disabled and the user will have to reactivate their account.
		//
		$s_hidden_fields .= '<input type="hidden" name="current_email" value="' . $userdata['user_email'] . '" />';
	}

	if ( !empty($user_avatar_local) )
	{
		$s_hidden_fields .= '<input type="hidden" name="avatarlocal" value="' . $user_avatar_local . '" /><input type="hidden" name="avatarcatname" value="' . $user_avatar_category . '" />';
	}

	$html_status =  ( $userdata['user_allowhtml'] && $board_config['allow_html'] ) ? $lang['HTML_is_ON'] : $lang['HTML_is_OFF'];
	$bbcode_status = ( $userdata['user_allowbbcode'] && $board_config['allow_bbcode']  ) ? $lang['BBCode_is_ON'] : $lang['BBCode_is_OFF'];
	$smilies_status = ( $userdata['user_allowsmile'] && $board_config['allow_smilies']  ) ? $lang['Smilies_are_ON'] : $lang['Smilies_are_OFF'];
// Start add - Gender MOD
switch ($gender) 
{ 
   case 1: $gender_male_checked="checked=\"checked\"";break; 
   case 2: $gender_female_checked="checked=\"checked\"";break; 
   default:$gender_no_specify_checked="checked=\"checked\""; 
}
// End add - Gender MOD	

	if ( $error )
	{
		$template->set_filenames(array(
			'reg_header' => 'error_body.tpl')
		);
		$template->assign_vars(array(
			'ERROR_MESSAGE' => $error_msg)
		);
		$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
	}

	$template->set_filenames(array(
		'body' => 'profile_add_body.tpl')
	);

	if ( $mode == 'editprofile' )
	{
		$template->assign_block_vars('switch_edit_profile', array());
	}

	if ( ($mode == 'register') || ($board_config['allow_namechange']) )
	{
		$template->assign_block_vars('switch_namechange_allowed', array());
	}
	else
	{
		$template->assign_block_vars('switch_namechange_disallowed', array());
	}


	// Visual Confirmation
	$confirm_image = '';
	if (!empty($board_config['enable_confirm']) && $mode == 'register')
	{
		$sql = 'SELECT session_id 
			FROM ' . SESSIONS_TABLE; 
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not select session data', '', __LINE__, __FILE__, $sql);
		}

		if ($row = $db->sql_fetchrow($result))
		{
			$confirm_sql = '';
			do
			{
				$confirm_sql .= (($confirm_sql != '') ? ', ' : '') . "'" . $row['session_id'] . "'";
			}
			while ($row = $db->sql_fetchrow($result));
		
			$sql = 'DELETE FROM ' .  CONFIRM_TABLE . " 
				WHERE session_id NOT IN ($confirm_sql)";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete stale confirm data', '', __LINE__, __FILE__, $sql);
			}
		}
		$db->sql_freeresult($result);

		$sql = 'SELECT COUNT(session_id) AS attempts 
			FROM ' . CONFIRM_TABLE . " 
			WHERE session_id = '" . $userdata['session_id'] . "'";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not obtain confirm code count', '', __LINE__, __FILE__, $sql);
		}

		if ($row = $db->sql_fetchrow($result))
		{
			if ($row['attempts'] > 3)
			{
				message_die(GENERAL_MESSAGE, $lang['Too_many_registers']);
			}
		}
		$db->sql_freeresult($result);
		
		// Generate the required confirmation code
		// NB 0 (zero) could get confused with O (the letter) so we make change it
		$code = dss_rand();
		$code = substr(str_replace('0', 'Z', strtoupper(base_convert($code, 16, 35))), 2, 6);

		$confirm_id = md5(uniqid($user_ip));

		$sql = 'INSERT INTO ' . CONFIRM_TABLE . " (confirm_id, session_id, code) 
			VALUES ('$confirm_id', '". $userdata['session_id'] . "', '$code')";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not insert new confirm code information', '', __LINE__, __FILE__, $sql);
		}

		unset($code);
		
		$confirm_image = '<img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id") . '" alt="" title="" />';
		$s_hidden_fields .= '<input type="hidden" name="confirm_id" value="' . $confirm_id . '" />';

		$template->assign_block_vars('switch_confirm', array());
	}
//Ajout confirmation écrite
if ($mode == 'register')
     {
     if ($board_config['question_conf_enable'])
	{

        $sql = "SELECT *
	FROM " . CONFIG_TABLE . "
	WHERE (`config_name`  = 'reponse_conf' )";
	if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain write confirmation', '', __LINE__, __FILE__, $sql);
			}
        $sql = "SELECT *
	FROM " . CONFIG_TABLE . "
	WHERE (`config_name`  = 'question_conf' )";
	if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain question confirmation', '', __LINE__, __FILE__, $sql);
			}

			$row = $db->sql_fetchrow($result);
	        $question_conf = $row['config_value'];
	$template->assign_block_vars('switch_reponse_conf', array());
       }
    }
//Fin confirmation écrite	

	if ( $board_config['allow_colortext'] )
	{
		$template->assign_block_vars('switch_colortext', array());
	}
	//
	// Let's do an overall check for settings/versions which would prevent
	// us from doing file uploads....
	//
	$ini_val = ( phpversion() >= '4.0.0' ) ? 'ini_get' : 'get_cfg_var';
	$form_enctype = ( @$ini_val('file_uploads') == '0' || strtolower(@$ini_val('file_uploads') == 'off') || phpversion() == '4.0.4pl1' || !$board_config['allow_avatar_upload'] || ( phpversion() < '4.0.3' && @$ini_val('open_basedir') != '' ) ) ? '' : 'enctype="multipart/form-data"';

	$template->assign_vars(array(
		'USERNAME' => isset($username) ? $username : '',
		'CUR_PASSWORD' => isset($cur_password) ? $cur_password : '',
		'NEW_PASSWORD' => isset($new_password) ? $new_password : '',
		'PASSWORD_CONFIRM' => isset($password_confirm) ? $password_confirm : '',
		'EMAIL' => isset($email) ? $email : '',
		'CONFIRM_IMG' => $confirm_image, 
		'YIM' => $yim,
		'ICQ' => $icq,
		'MSN' => $msn,
		'AIM' => $aim,
		'OCCUPATION' => $occupation,
		'INTERESTS' => $interests,
		//Ajout confirmation écrite
		'QUESTION_CONF' => $question_conf,
		'REPONSE_CONF' => $reponse_conf,
		//Fin confirmation écrite
		'LOCATION' => $location,
		'WEBSITE' => $website,
		'SIGNATURE' => str_replace('<br />', "\n", $signature),
		'COLORTEXT' => $user_colortext,		
//-- mod : quick post es -------------------------------------------------------
//-- add
		'L_QP_SETTINGS' => $lang['qp_settings'],
//-- fin mod : quick post es ---------------------------------------------------
// Start add - Gender MOD
'LOCK_GENDER' =>($mode!='register') ? 'DISABLED':'', 
'GENDER' => $gender,
'GENDER_REQUIRED' => ( $board_config['gender_required'] ) ? ' *' : '',
'GENDER_NO_SPECIFY_CHECKED' => $gender_no_specify_checked, 
'GENDER_MALE_CHECKED' => $gender_male_checked, 
'GENDER_FEMALE_CHECKED' => $gender_female_checked, 
// End add - Gender MOD		
		'VIEW_EMAIL_YES' => ( $viewemail ) ? 'checked="checked"' : '',
		'VIEW_EMAIL_NO' => ( !$viewemail ) ? 'checked="checked"' : '',
		'HIDE_USER_YES' => ( !$allowviewonline ) ? 'checked="checked"' : '',
		'HIDE_USER_NO' => ( $allowviewonline ) ? 'checked="checked"' : '',
		'NOTIFY_PM_YES' => ( $notifypm ) ? 'checked="checked"' : '',
		'NOTIFY_PM_NO' => ( !$notifypm ) ? 'checked="checked"' : '',
		'POPUP_PM_YES' => ( $popup_pm ) ? 'checked="checked"' : '',
		'POPUP_PM_NO' => ( !$popup_pm ) ? 'checked="checked"' : '',
		'ALWAYS_ADD_SIGNATURE_YES' => ( $attachsig ) ? 'checked="checked"' : '',
		'ALWAYS_ADD_SIGNATURE_NO' => ( !$attachsig ) ? 'checked="checked"' : '',
		'NOTIFY_REPLY_YES' => ( $notifyreply ) ? 'checked="checked"' : '',
		'NOTIFY_REPLY_NO' => ( !$notifyreply ) ? 'checked="checked"' : '',
		'NOTIFY_DONATION_YES' => ( $notifydonation ) ? 'checked="checked"' : '',
		'NOTIFY_DONATION_NO' => ( !$notifydonation ) ? 'checked="checked"' : '',		
		'ALWAYS_ALLOW_BBCODE_YES' => ( $allowbbcode ) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_BBCODE_NO' => ( !$allowbbcode ) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_HTML_YES' => ( $allowhtml ) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_HTML_NO' => ( !$allowhtml ) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_SMILIES_YES' => ( $allowsmilies ) ? 'checked="checked"' : '',
		'ALWAYS_ALLOW_SMILIES_NO' => ( !$allowsmilies ) ? 'checked="checked"' : '',
		'ALLOW_AVATAR' => $board_config['allow_avatar_upload'],
		'AVATAR' => $avatar_img,
		'AVATAR_SIZE' => $board_config['avatar_filesize'],
		'LANGUAGE_SELECT' => language_select($user_lang, 'language'),
		'STYLE_SELECT' => style_select($user_style, 'style'),
		'TIMEZONE_SELECT' => tz_select($user_timezone, 'timezone'),
		'USE_REL_DATE_YES' => ( $use_rel_date ) ? 'checked="checked"' : '',
		'USE_REL_DATE_NO' => ( !$use_rel_date ) ? 'checked="checked"' : '',		
		'USE_REL_TIME_YES' => ( $use_rel_time ) ? 'checked="checked"' : '',
		'USE_REL_TIME_NO' => ( !$use_rel_time ) ? 'checked="checked"' : '',		
		'DATE_FORMAT' => $user_dateformat,
		'HTML_STATUS' => $html_status,
		'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . append_sid("faq.$phpEx?mode=bbcode") . '" target="_phpbbcode">', '</a>'),
		'SMILIES_STATUS' => $smilies_status,
// Default avatar MOD, By Manipe (Begin)
		'DEFAULT_AVATAR_YES' => ( $allowdefaultavatar ) ? 'checked="checked"' : '',
		'DEFAULT_AVATAR_NO' => ( !$allowdefaultavatar ) ? 'checked="checked"' : '',
		'L_DEFAULT_AVATAR' => $lang['Choose_default_avatar'],
		'L_DEFAULT_AVATAR_EXPLAIN' => $lang['Choose_default_avatar_explain'],
// Default avatar MOD, By Manipe (End)		

		'L_CURRENT_PASSWORD' => $lang['Current_password'],
		'L_NEW_PASSWORD' => ( $mode == 'register' ) ? $lang['Password'] : $lang['New_password'],
		'L_CONFIRM_PASSWORD' => $lang['Confirm_password'],
		'L_CONFIRM_PASSWORD_EXPLAIN' => ( $mode == 'editprofile' ) ? $lang['Confirm_password_explain'] : '',
		'L_PASSWORD_IF_CHANGED' => ( $mode == 'editprofile' ) ? $lang['password_if_changed'] : '',
		'L_PASSWORD_CONFIRM_IF_CHANGED' => ( $mode == 'editprofile' ) ? $lang['password_confirm_if_changed'] : '',
		'L_SUBMIT' => $lang['Submit'],
		'L_RESET' => $lang['Reset'],
		'L_ICQ_NUMBER' => $lang['ICQ'],
		'L_MESSENGER' => $lang['MSNM'],
		'L_YAHOO' => $lang['YIM'],
		'L_WEBSITE' => $lang['Website'],
		'L_AIM' => $lang['AIM'],
		'L_LOCATION' => $lang['Location'],
		'L_OCCUPATION' => $lang['Occupation'],
		'L_BOARD_LANGUAGE' => $lang['Board_lang'],
		'L_BOARD_STYLE' => $lang['Board_style'],
		'L_TIMEZONE' => $lang['Timezone'],
		'L_DATE_FORMAT' => $lang['Date_format'],
		'L_DATE_FORMAT_EXPLAIN' => $lang['Date_format_explain'],
		'L_USE_REL_DATE' => $lang['Use_rel_date'],		
		'L_USE_REL_DATE_EXPLAIN' => $lang['Use_rel_date_explain'],		
		'L_USE_REL_TIME' => $lang['Use_rel_time'],		
		'L_USE_REL_TIME_EXPLAIN' => $lang['Use_rel_time_explain'],		
		'L_YES' => $lang['Yes'],
		'L_NO' => $lang['No'],
		'L_INTERESTS' => $lang['Interests'],
		//Ajout confirmation écrite
		'L_QUESTION_CONF' => $question_conf,
		'L_QUESTION_CONF_EXPLAIN' => $lang['Question_conf_explain'],
		//Fin confirmation écrite
		// Start add - Gender MOD
		'L_GENDER' =>$lang['Gender'], 
		'L_GENDER_MALE' =>$lang['Male'], 
		'L_GENDER_FEMALE' =>$lang['Female'], 
		'L_GENDER_NOT_SPECIFY' =>$lang['No_gender_specify'], 
		// End add - Gender MOD		
		'L_ALWAYS_ALLOW_SMILIES' => $lang['Always_smile'],
		'L_ALWAYS_ALLOW_BBCODE' => $lang['Always_bbcode'],
		'L_ALWAYS_ALLOW_HTML' => $lang['Always_html'],
		'L_HIDE_USER' => $lang['Hide_user'],
		'L_ALWAYS_ADD_SIGNATURE' => $lang['Always_add_sig'],
		 // Begin Account Self-Delete MOD
		'L_ACCOUNT_DELETE' => $lang['Account_delete'],
		'L_DELETE_ACCOUNT_EXPLAIN' => $lang['Account_delete_explain'],
		// End Account Self-Delete MOD
		'L_COLORTEXT' => $lang['Colortext'],
		'L_COLORTEXT_EXPLAIN' => $lang['Colortext_Explain'],		

		'L_AVATAR_PANEL' => $lang['Avatar_panel'],
		'L_AVATAR_EXPLAIN' => sprintf($lang['Avatar_explain'], $board_config['avatar_max_width'], $board_config['avatar_max_height'], (round($board_config['avatar_filesize'] / 1024))),
		'L_UPLOAD_AVATAR_FILE' => $lang['Upload_Avatar_file'],
		'L_UPLOAD_AVATAR_URL' => $lang['Upload_Avatar_URL'],
		'L_UPLOAD_AVATAR_URL_EXPLAIN' => $lang['Upload_Avatar_URL_explain'],
		'L_AVATAR_GALLERY' => $lang['Select_from_gallery'],
		'L_SHOW_GALLERY' => $lang['View_avatar_gallery'],
		'L_LINK_REMOTE_AVATAR' => $lang['Link_remote_Avatar'],
		'L_LINK_REMOTE_AVATAR_EXPLAIN' => $lang['Link_remote_Avatar_explain'],
		'L_DELETE_AVATAR' => $lang['Delete_Image'],
		'L_CURRENT_IMAGE' => $lang['Current_Image'],

		'L_SIGNATURE' => $lang['Signature'],
		'L_SIGNATURE_EXPLAIN' => sprintf($lang['Signature_explain'], $board_config['max_sig_chars']),
		'L_NOTIFY_ON_REPLY' => $lang['Always_notify'],
		'L_NOTIFY_ON_REPLY_EXPLAIN' => $lang['Always_notify_explain'],
		'L_NOTIFY_ON_PRIVMSG' => $lang['Notify_on_privmsg'],
		'L_POPUP_ON_PRIVMSG' => $lang['Popup_on_privmsg'],
		'L_POPUP_ON_PRIVMSG_EXPLAIN' => $lang['Popup_on_privmsg_explain'],
		'L_PREFERENCES' => $lang['Preferences'],
		'L_PUBLIC_VIEW_EMAIL' => $lang['Public_view_email'],
		'L_ITEMS_REQUIRED' => $lang['Items_required'],
		'L_REGISTRATION_INFO' => $lang['Registration_info'],
		'L_PROFILE_INFO' => $lang['Profile_info'],
		'L_PROFILE_INFO_NOTICE' => $lang['Profile_info_warn'],
		'L_EMAIL_ADDRESS' => $lang['Email_address'],
		'L_NOTIFY_DONATION' => sprintf($lang['Points_notify'], $board_config['points_name']),
		'L_NOTIFY_DONATION_EXPLAIN' => sprintf($lang['Points_notify_explain'], $board_config['points_name']),	

		'L_CONFIRM_CODE_IMPAIRED'	=> sprintf($lang['Confirm_code_impaired'], '<a href="mailto:' . $board_config['board_email'] . '">', '</a>'), 
		'L_CONFIRM_CODE'			=> $lang['Confirm_code'], 
		'L_CONFIRM_CODE_EXPLAIN'	=> $lang['Confirm_code_explain'], 

		'S_ALLOW_AVATAR_UPLOAD' => $board_config['allow_avatar_upload'],
		'S_ALLOW_AVATAR_LOCAL' => $board_config['allow_avatar_local'],
		'S_ALLOW_AVATAR_REMOTE' => $board_config['allow_avatar_remote'],
		'S_HIDDEN_FIELDS' => $s_hidden_fields,
		'S_FORM_ENCTYPE' => $form_enctype,
		'S_PROFILE_ACTION' => append_sid("profile.$phpEx"))
	);
//-- mod : flags ---------------------------------------------------------------
//-- add
	get_flags_list($flag);
//-- fin mod : flags -----------------------------------------------------------	
//-- mod : birthday ------------------------------------------------------------
//-- add
	$birthday->select_birthdate(array('d' => $bday_day, 'm' => $bday_month, 'y' => $bday_year));
//-- fin mod : birthday --------------------------------------------------------
//-- mod : quick post es -------------------------------------------------------
//-- add
	display_qpes_data();
//-- fin mod : quick post es ---------------------------------------------------	

	//
	// This is another cheat using the block_var capability
	// of the templates to 'fake' an IF...ELSE...ENDIF solution
	// it works well :)
	//
	if ( $mode != 'register' )
	{
    // Begin Account Self-Delete MOD
    if( $board_config['account_delete'] )
    {
      $template->assign_block_vars('account_delete_block', array() );
    }
    // End Account Self-Delete MOD	
		if ( $userdata['user_allowavatar'] && ( $board_config['allow_avatar_upload'] || $board_config['allow_avatar_local'] || $board_config['allow_avatar_remote'] ) )
		{
			$template->assign_block_vars('switch_avatar_block', array() );

			if ( $board_config['allow_avatar_upload'] && file_exists(@phpbb_realpath('./' . $board_config['avatar_path'])) )
			{
				if ( $form_enctype != '' )
				{
					$template->assign_block_vars('switch_avatar_block.switch_avatar_local_upload', array() );
				}
				$template->assign_block_vars('switch_avatar_block.switch_avatar_remote_upload', array() );
			}
// Default avatar MOD, By Manipe (Begin)
			if ( $board_config['default_avatar_choose'] )
			{
				$template->assign_block_vars('switch_avatar_block.switch_default_avatar_choose', array() );
			}
// Default avatar MOD, By Manipe (End)			

			if ( $board_config['allow_avatar_remote'] )
			{
				$template->assign_block_vars('switch_avatar_block.switch_avatar_remote_link', array() );
			}

			if ( $board_config['allow_avatar_local'] && file_exists(@phpbb_realpath('./' . $board_config['avatar_gallery_path'])) )
			{
				$template->assign_block_vars('switch_avatar_block.switch_avatar_local_gallery', array() );
			}
		}
	}
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);