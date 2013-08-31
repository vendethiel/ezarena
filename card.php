<?php 
/*************************************************************************** 
*                            card.php 
*             php Script needed for Yellow card mod (card ban/report mod)
*
*		giving the rigth POST actions, this file can:
*		ban, unban, warn postes or report a post to the forums moderators
*		now also posible to block a user for limited time if "protect user account" mod is pressent
*		the moderators of the forum can have a email notification, 
*		this can be controled in the ADMIN PANEL
*
*                       ------------------- 
*   begin                : Feb 05, 2002 
*   author			 : Niels Chr. Rød Denmark < ncr@db9.dk > 
*   www			 : http://mods.db9.dk
*   email                : ncr@db9.dk 
* 
*      ver.1.4.14.
* 
*   History:
*	ver 0.9.0. - initial beta for RC-2
*	ver 1.0.0. - initial release for RC-2
*	ver 1.2.0. - initial release for phpBB2 ver 2.0.0.
*	ver 1.2.4. - history started, major rechange on how this file works, now uses POST action, for improved security
*	ver 1.2.5. - fixed that post report was send out evry time, regardless of the admin settings
*	ver 1.2.6. - allow admin to warn, ban outside a forum (e.g. in viewprofile/memberlist)
*	ver 1.2.7. - fixed that after ver 1.2.4. users was not banned when reatched the warn limit
*	ver 1.2.8. - fixed that the first post report was not sendt out
*	ver 1.2.9. - fixed a error that couses the "back" link not to work if not moderators
*	ver 1.3.0. - now posible to send PM to users if they are resiving cards / users can write a message to moderators easy
*	ver 1.3.1. - security update, this mod, now uses it own DB field, for counting warning cards
*	ver 1.3.2. - now also posible to post a report into a specific report forum (defined in admin panel)
*	ver 1.3.3. - fix some minor isues, regarding posting a report
*	ver 1.4.0. - security update
*	ver 1.4.1. - added block time, if protect useraccount mod is installed
*	ver 1.4.2. - users are now banned imidiatly if they are logged in same time as they are getting a red card
*	ver 1.4.3. - block email notification was not showing how long the user was blocked, now corrected
*	ver 1.4.5. - minor update
*	ver 1.4.6. - ver 1.4.1 introduced a bug, witch caused the ban email was not sendt out, this is now fixed
*	ver 1.4.7. - now compatible with admin panel, ban users panel
*	ver 1.4.8. - log ip of user witch have given block user card
*	ver 1.4.9. - ver 1.4.8. had a typo, witch is corrected
*	ver 1.4.10. - updated the RFC syntax in emails send out
* 	ver 1.4.11. - fix that admin is allowed to give cards, outside viewtopic.php
*     ver 1.4.12. - replaced all RAPPORT and RAPORT with REPORT
*     ver 1.4.13. - fixed some isues about RY card
*	ver 1.4.14. - now uses 2.0.6. email format for subject
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
// 
// Load default header 
// 
$phpbb_root_path = "./"; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx); 

// Find what we are to do
$mode = ( isset($HTTP_POST_VARS['report_x']) ) ? 'report' : 
		((isset($HTTP_POST_VARS['report_reset_x']) ) ? 'report_reset' : 
			((isset($HTTP_POST_VARS['ban_x']) ) ? 'ban' : 
				((isset($HTTP_POST_VARS['unban_x']) ) ? 'unban' : 
					((isset($HTTP_POST_VARS['warn_x']) ) ? 'warn' : 
						((isset($HTTP_POST_VARS['block_x']) ) ? 'block' : ''
						)
					)

				)
			)
		);
$post_id = ( isset($HTTP_POST_VARS['post_id']) ) ? intval ($HTTP_POST_VARS['post_id']) : '';
$user_id = ( isset($HTTP_POST_VARS[POST_USERS_URL]) ) ? intval ($HTTP_POST_VARS[POST_USERS_URL]) : '';

// check that we have all what is needed to know
if ( !( $post_id + $user_id ) )
	message_die(GENERAL_ERROR, "No user/post specified", "", __LINE__, __FILE__,'post_id="'.$post_id.'", user_id="'.$user_id.'"'); 
if ( empty($mode) )
	message_die(GENERAL_ERROR, "No action specified", "", __LINE__, __FILE__,'mode="'.$mode.'"'); 

$sql = 'SELECT DISTINCT forum_id, poster_id, post_bluecard FROM ' . POSTS_TABLE . ' WHERE post_id = "'.$post_id.'"'; 
if( !$result = $db->sql_query($sql) ) 
      message_die(GENERAL_ERROR, "Couldn't obtain forums information.", "", __LINE__, __FILE__, $sql); 
$result = $db->sql_fetchrow($result);
$blue_card = $result['post_bluecard'];
if ( $post_id )
{
	// post mode
	$forum_id = $result['forum_id'];
	$poster_id = $result['poster_id'];
} else
if ( $user_id )
{
	//user mode
	//forum_id will control witch permission, when no post_id is given, and a user_id is given instead
	//disable the frum_id line will give no default access when no post_id is given
	// installe extra permission mod, in order to enable this feature
//	$forum_id = PAGE_CARD;
	$poster_id = $user_id;
}

$userdata = session_pagestart($user_ip, PAGE_CARD);
init_userprefs($userdata);

//
// Start auth check
//
$is_auth = array(); 
$is_auth = auth(AUTH_ALL, $forum_id, $userdata);

if ($mode=="report_reset") 
{ 
	if (! $is_auth['auth_mod'])
		message_die(GENERAL_ERROR, $lang['Not_Authorised']);

	$sql = 'SELECT pt.post_subject, f.forum_name FROM '.POSTS_TEXT_TABLE.' pt, '.POSTS_TABLE.' p, '.FORUMS_TABLE.' f WHERE pt.post_id="'.$post_id.'" AND p.post_id=pt.post_id AND p.forum_id=f.forum_id';
	if( !$result = $db->sql_query($sql) ) 
	     	message_die(GENERAL_ERROR, "Couldn't get post subject information".$sql); 
	$subject = $db->sql_fetchrow($result);
	$post_subject=$subject['post_subject'];
	$forum_name=$subject['forum_name'];

 	$sql = 'UPDATE ' . POSTS_TABLE . ' SET post_bluecard="0" WHERE post_id="'.$post_id.'"'; 
		if( !$result = $db->sql_query($sql) ) 
	      	message_die(GENERAL_ERROR, "Couldn't update blue card information"); 
	message_die(GENERAL_MESSAGE, $lang['Post_reset']."<br /><br />". 
	sprintf($lang['Click_return_viewtopic'], "<a href=\"" . append_sid("viewtopic.$phpEx?p=".$post_id."#".$post_id). "\">", "</a>")); 

} else 
if ($mode=="report") 
{ 
	if (!$is_auth['auth_bluecard']) 
	{
		message_die(GENERAL_ERROR, $lang['Not_Authorised']); 
	}

	$sql = 'SELECT f.forum_name, p.topic_id  FROM '.POSTS_TABLE.' p, '.FORUMS_TABLE.' f WHERE p.post_id="'.$post_id.'" AND  p.forum_id=f.forum_id';
	if( !$result = $db->sql_query($sql) ) 
	     	message_die(GENERAL_ERROR, "Couldn't get post subject information"); 

	$post_details = $db->sql_fetchrow($result);
	$forum_name=$post_details['forum_name'];
	$topic_id=$post_details['topic_id'];
	$sql = 'SELECT pt.post_subject FROM '.POSTS_TEXT_TABLE.' pt, '.TOPICS_TABLE.' t WHERE t.topic_id="'.$topic_id.'" AND pt.post_id=t.topic_first_post_id';
	if( !$result = $db->sql_query($sql) ) 
     		message_die(GENERAL_ERROR, "Couldn't get topic subject information".$sql); 
	$post_details = $db->sql_fetchrow($result);
	$post_subject=$post_details['post_subject'];

	$sql = 'SELECT p.topic_id FROM '.POSTS_TEXT_TABLE.' pt, '.POSTS_TABLE.' p  WHERE pt.post_subject="('.$post_id.')'.$post_subject.'" AND pt.post_id=p.post_id';
	if( !$result = $db->sql_query($sql) ) 
     		message_die(GENERAL_ERROR, "Couldn't get topic subject information".$sql); 
	$post_details = $db->sql_fetchrow($result);
	$allready_reported= ($blue_card) ? $post_details['topic_id'] : '';

	$blue_card++;
	$sql = 'UPDATE ' . POSTS_TABLE . ' SET post_bluecard="'.$blue_card.'" WHERE post_id="'.$post_id.'"'; 
	if( !$result = $db->sql_query($sql) ) 
	     	message_die(GENERAL_ERROR, "Couldn't update blue card information"); 
	// 
      // Obtain list of moderators of this forum 
     	$sql = "SELECT g.group_name, u.username, u.user_email, u.user_lang 
     		FROM " . AUTH_ACCESS_TABLE . " aa,  " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g, " . USERS_TABLE . " u 
	      WHERE aa.forum_id = $forum_id   AND aa.auth_mod = " . TRUE . " 
     		AND ug.group_id = aa.group_id   AND g.group_id = aa.group_id AND u.user_id = ug.user_id"; 
      if( !$result_mods = $db->sql_query($sql) ) 
		message_die(GENERAL_ERROR, "Couldn't obtain moderators information.", "", __LINE__, __FILE__, $sql); 
	$total_mods = $db->sql_numrows($result_mods); 
	$i=0; 
      if (!$total_mods) 
		 message_die(GENERAL_MESSAGE, $lang['No_moderators']."<br /><br />".
		(($board_config['report_forum'])? sprintf($lang['Send_message'], "<a href=\"" . append_sid("posting.$phpEx?mode=".(($allready_reported)?"reply&t=".$allready_reported:"newtopic&f=".$board_config['report_forum'])."&postreport=".$post_id). "\">", "</a>"):"").
		sprintf($lang['Click_return_viewtopic'], "<a href=\"" . append_sid("viewtopic.$phpEx?p=".$post_id."#".$post_id). "\">", "</a>"));
      if ((	$blue_card>=$board_config['bluecard_limit_2'] && (!(($blue_card-$board_config['bluecard_limit_2'])%$board_config['bluecard_limit']))) || $blue_card==$board_config['bluecard_limit_2']) 
	{ 
		$mods_rowset = $db->sql_fetchrowset($result_mods); 
	      include($phpbb_root_path . 'includes/emailer.'.$phpEx); 
	      while ($i<$total_mods) 
      	{ 
			$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path'])). '/viewtopic.'.$phpEx;
			$server_name = trim($board_config['server_name']);
			$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
			$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
            	$emailer = new emailer($board_config['smtp_delivery']); 
	            $emailer->email_address($mods_rowset[$i]['user_email']); 
      	      $email_headers = "To: \"".$mods_rowset[$i]['username']."\" <".$mods_rowset[$i]['user_email']. ">\r\n"; 
	            $email_headers .= "From: \"".$board_config['sitename']."\" <".$board_config['board_email'].">\r\n"; 
      	      $email_headers .= "Return-Path: " . (($userdata['user_email']&&$userdata['user_viewemail'])? $userdata['user_email']."\r\n":"\r\n"); 
            	$email_headers .= "X-AntiAbuse: Board servername - " . $server_name . "\r\n"; 
	            $email_headers .= "X-AntiAbuse: User_id - " . $userdata['user_id'] . "\r\n"; 
      	      $email_headers .= "X-AntiAbuse: Username - " . $userdata['username'] . "\r\n"; 
            	$email_headers .= "X-AntiAbuse: User IP - " . decode_ip($user_ip) . "\r\n"; 
	            $emailer->use_template("repport_post",(file_exists($phpbb_root_path . "language/lang_" . $mods_rowset[$i]['user_lang'] . "/email/repport_post.tpl"))?$mods_rowset[$i]['user_lang'] : ""); 
      	      $i++;
//            	$emailer->set_subject($lang['Post_repport']);
	            $emailer->extra_headers($email_headers); 
      	      $emailer->assign_vars(array( 
			   'POST_URL' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_POST_URL . "=$post_id#$post_id",
			   'POST_SUBJECT' => $post_subject,
			   'FORUM_NAME' => $forum_name,
	               'USER' => '"'.$userdata['username'].'"', 
            	   'NUMBER_OF_REPPORTS' => $blue_card, 
	               'SITENAME' => $board_config['sitename'], 
      	         'BOARD_EMAIL' => $board_config['board_email'])); 
            	$emailer->send(); 
	            $emailer->reset(); 
		} 
	} 
	message_die(GENERAL_MESSAGE, (($total_mods)?sprintf($lang['Post_repported'],$total_mods):$lang['Post_repported_1'])."<br /><br />". 
(($board_config['report_forum'])? sprintf($lang['Send_message'], "<a href=\"" . append_sid("posting.$phpEx?mode=".(($allready_reported)?"reply&t=".$allready_reported:"newtopic&f=".$board_config['report_forum'])."&postreport=".$post_id). "\">", "</a>"):"").
sprintf($lang['Click_return_viewtopic'], "<a href=\"" . append_sid("viewtopic.$phpEx?p=".$post_id."#".$post_id). "\">", "</a>")); 
} else
if ( $mode == 'unban' )
{
      $no_error_ban=FALSE; 
	if (! $is_auth['auth_greencard'] )
		message_die(GENERAL_ERROR, $lang['Not_Authorised']); 
	// look up the user 
	$sql = 'SELECT user_active, user_warnings FROM ' . USERS_TABLE . ' WHERE user_id="'.$poster_id.'"'; 
	if( !$result = $db->sql_query($sql) ) 
      	message_die(GENERAL_ERROR, "Couldn't obtain judge information.", "", __LINE__, __FILE__, $sql); 
	$the_user = $db->sql_fetchrow($result); 
      // remove the user from ban list 
      $sql = 'DELETE FROM ' . BANLIST_TABLE . ' WHERE ban_userid="'.$poster_id.'"'; 
      if (! $result = $db->sql_query($sql) ) 
            message_die(GENERAL_ERROR, "Couldn't remove ban_userid info into database", "", __LINE__, __FILE__, $sql); 
      // update the user table with new status 
      $sql = 'UPDATE ' . USERS_TABLE . ' SET user_warnings="0" WHERE user_id="'.$poster_id.'"';
      if(! $result = $db->sql_query($sql) ) 
		message_die(GENERAL_ERROR, "Couldn't update user status information", "", __LINE__, __FILE__, $sql);
	$message = $lang['Ban_update_green']."<br /><br />".
		sprintf($lang['Send_PM_user'], "<a href=\"" . append_sid("privmsg.$phpEx?mode=post&u=$poster_id"). "\">", "</a>"); 
      $e_temp="ban_reactivated"; 
//      $e_subj=$lang['Ban_reactivate']; 
      $no_error_ban=true; 
} else

if ( $mode == 'ban' )
{
      $no_error_ban=FALSE; 
	if (! $is_auth['auth_ban'] )
		message_die(GENERAL_ERROR, $lang['Not_Authorised']); 
	// look up the user 
	$sql = 'SELECT user_active, user_level FROM ' . USERS_TABLE . ' WHERE user_id="'.$poster_id.'"'; 
	if( !$result = $db->sql_query($sql) ) 
      	message_die(GENERAL_ERROR, "Couldn't obtain judge information.", "", __LINE__, __FILE__, $sql); 
	$the_user = $db->sql_fetchrow($result); 
	if ($the_user['user_level']== ADMIN )
		message_die(GENERAL_ERROR, $lang['Ban_no_admin']); 

	// insert the user in the ban list 
      $sql = 'SELECT ban_userid FROM ' . BANLIST_TABLE . ' WHERE ban_userid="'.$poster_id.'"'; 
      if( $result = $db->sql_query($sql) ) 
      { 
		if (!$db->sql_fetchrowset($result)) 
		{ 
			// insert the user in the ban list 
			$sql = "INSERT INTO " . BANLIST_TABLE . " (ban_userid) VALUES ($poster_id)"; 
			if (!$result = $db->sql_query($sql) ) 
				message_die(GENERAL_ERROR, "Couldn't insert ban_userid info into database", "", __LINE__, __FILE__, $sql); 
			// update the user table with new status 
 			$sql = 'UPDATE ' . USERS_TABLE . ' SET user_warnings="'.$board_config['max_user_bancard'].'" WHERE user_id="'.$poster_id.'"'; 
			if(! $result = $db->sql_query($sql) ) 
				message_die(GENERAL_ERROR, "Couldn't update user status information", "", __LINE__, __FILE__, $sql);
			$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET session_logged_in="0" WHERE session_user_id="'.$poster_id.'"';
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update banned sessions from database", "", __LINE__, __FILE__, $sql);
			}
			$no_error_ban=true; 
			$message = $lang['Ban_update_red'];
			$e_temp="ban_block"; 
//			$e_subj=$lang['Card_banned']; 
		} else 
      	{ 
      		$no_error_ban = true; 
			$message = $lang['user_already_banned']; 
      	} 
	} else message_die(GENERAL_ERROR, "Couldn't obtain banlist information", "", __LINE__, __FILE__, $sql); 
} else

if ( $mode == 'block' )
{
	if (empty($board_config['block_time']) )
		message_die(GENERAL_ERROR, "Protect user account mod not installed, this is required for this operation"); 
      $no_error_ban=FALSE; 
	if (! $is_auth['auth_ban'] )
		message_die(GENERAL_ERROR, $lang['Not_Authorised']); 
	// look up the user 
	$sql = 'SELECT user_active, user_level FROM ' . USERS_TABLE . ' WHERE user_id="'.$poster_id.'"'; 
	if( !$result = $db->sql_query($sql) ) 
      	message_die(GENERAL_ERROR, "Couldn't obtain judge information.", "", __LINE__, __FILE__, $sql); 
	$the_user = $db->sql_fetchrow($result); 
	if ($the_user['user_level']== ADMIN )
		message_die(GENERAL_ERROR, $lang['Block_no_admin']); 
	// update the user table with new status 
	$sql = 'UPDATE ' . USERS_TABLE . ' SET user_block_by="'.$user_ip.'", user_blocktime="'.(time()+$board_config['RY_block_time']*60).'" WHERE user_id="'.$poster_id.'"'; 
	if(! $result = $db->sql_query($sql) ) 
		message_die(GENERAL_ERROR, "Couldn't update user status information", "", __LINE__, __FILE__, $sql);
	$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET session_logged_in="0", session_user_id=".ANONYMOUS." WHERE session_user_id="'.$poster_id.'"'; 
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't update blocked sessions from database", "", __LINE__, __FILE__, $sql);
	}

	$no_error_ban=true; 
	$block_time = make_time_text ($board_config['RY_block_time']);
	$message = sprintf($lang['Block_update'],$block_time) . "<br /><br />".
	sprintf($lang['Send_PM_user'], "<a href=\"" . append_sid("privmsg.$phpEx?mode=post&u=$poster_id"). "\">", "</a>");
	$e_temp="card_block"; 
//	$e_subj=sprintf($lang['Card_blocked'],$block_time); 
} else

if ( $mode == 'warn' )
{
      $no_error_ban=FALSE; 
	if (! $is_auth['auth_ban'] )
		message_die(GENERAL_ERROR, $lang['Not_Authorised']); 
	// look up the user 
	$sql = 'SELECT user_active, user_warnings, user_level FROM ' . USERS_TABLE . ' WHERE user_id="'.$poster_id.'"'; 
	if( !$result = $db->sql_query($sql) ) 
      	message_die(GENERAL_ERROR, "Couldn't obtain judge information.", "", __LINE__, __FILE__, $sql); 
	$the_user = $db->sql_fetchrow($result); 
	if ($the_user['user_level']== ADMIN )
		message_die(GENERAL_ERROR, $lang['Ban_no_admin']); 

	//update the warning counter
	$sql = 'UPDATE ' . USERS_TABLE . ' SET user_warnings=user_warnings+1 WHERE user_id="'.$poster_id.'"'; 
	if(! $result = $db->sql_query($sql) ) 
		message_die(GENERAL_ERROR, "Couldn't update user status information", "", __LINE__, __FILE__, $sql);

      // se if the user are to be banned, if so do it ... 
      if ($the_user['user_warnings']+1>=$board_config['max_user_bancard']) 
      { 
	$sql = 'SELECT ban_userid FROM ' . BANLIST_TABLE . ' WHERE ban_userid="'.$poster_id.'"'; 
	if( $result = $db->sql_query($sql) ) 
	{ 
		if (!$db->sql_fetchrowset($result)) 
		{ 
			// insert the user in the ban list 
			$sql = "INSERT INTO " . BANLIST_TABLE . " (ban_userid) VALUES ($poster_id)"; 
			if (!$result = $db->sql_query($sql) ) 
				message_die(GENERAL_ERROR, "Couldn't insert ban_userid info into database", "", __LINE__, __FILE__, $sql); 
			// update the user table with new status 
			$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET session_logged_in="0" WHERE session_user_id="'.$poster_id.'"';
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update banned sessions from database", "", __LINE__, __FILE__, $sql);
			}
			$no_error_ban=true; 
			$message = $lang['Ban_update_red'];
			$e_temp="ban_block"; 
//			$e_subj=$lang['Ban_blocked']; 
            } else 
            { 	
			$no_error_ban = true; 
			$message = $lang['user_already_banned'];
            } 
         } else message_die(GENERAL_ERROR, "Couldn't obtain banlist information", "", __LINE__, __FILE__, $sql); 
	} else
	{
		// the user shall not be baned this time, update the counter
	      $message = sprintf($lang['Ban_update_yellow'],$the_user['user_warnings']+1,$board_config['max_user_bancard'])."<br /><br />".
sprintf($lang['Send_PM_user'], "<a href=\"" . append_sid("privmsg.$phpEx?mode=post&u=$poster_id"). "\">", "</a>");		$no_error_ban=true; 
	      $e_temp="ban_warning"; 
//	      $e_subj=$lang['Ban_warning']; 
	}
}

if ($no_error_ban) 
{ 
	$sql = 'SELECT username, user_warnings, user_email, user_lang FROM ' . USERS_TABLE . ' WHERE user_id="'.$poster_id.'"'; 
      if( !$result = $db->sql_query($sql) ) 
		message_die(GENERAL_ERROR, "Couldn't find the users personal information", "", __LINE__, __FILE__, $sql); 
	$warning_data=$db->sql_fetchrow($result); 
      if (!empty($warning_data['user_email'])) 
      { 
		include($phpbb_root_path . 'includes/emailer.'.$phpEx); 
		$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path'])). '/viewtopic.'.$phpEx;
		$server_name = trim($board_config['server_name']);
		$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
            $emailer = new emailer($board_config['smtp_delivery']);
            $email_headers = "TO: '".$warning_data['username']."' <".$warning_data['user_email']. ">\r\n";
		$email_headers .= ($userdata['user_email'] && $userdata['user_viewemail']) ? 
			"FROM: \"".$userdata['username']."\" <".$userdata['user_email'].">\r\n"  : 
			"FROM: \"".$board_config['sitename']."\" <" .$board_config['board_email'] . ">\r\n"; 
	      $emailer->use_template($e_temp, stripslashes($warning_data['user_lang'])); 
            $emailer->email_address($warning_data['user_email']); 
//            $emailer->set_subject($e_subj); 
            $emailer->extra_headers($email_headers); 
            $emailer->assign_vars(array( 
            	'SITENAME' => $board_config['sitename'], 
	            'WARNINGS' => $warning_data['user_warnings'], 
      	      'TOTAL_WARN' => $board_config['max_user_bancard'], 
			'POST_URL' => $server_protocol . $server_name . $server_port . $script_name . '?' . POST_POST_URL . "=$post_id#$post_id",
      	      'EMAIL_SIG' => str_replace("<br />", "\n", "-- \n" . $board_config['board_email_sig']), 
            	'WARNER' => $userdata['username'], 
			'BLOCK_TIME' => $block_time,
	            'WARNED_POSTER' => $warning_data['username'])
		); 
//            if ($e_subj)
//		{
			$emailer->send(); 
//		}
            $emailer->reset(); 
	}
	else
	{
	 	$message .= "<br/><br/>".$lang['user_no_email']; 
	}
} 
else 
{
	$message = 'Error card.php file'; 
}

$message .= ( $post_id != '-1' ) ? "<br /><br />". sprintf($lang['Click_return_viewtopic'], "<a href=\"" . append_sid("viewtopic.$phpEx?p=".$post_id."#".$post_id). "\">", "</a>"):"<br /><br />". sprintf($lang['Click_return_index'], "<a href=\"" . append_sid("index.".$phpEx). "\">", "</a>"); 
message_die(GENERAL_MESSAGE, $message); 
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 

?>