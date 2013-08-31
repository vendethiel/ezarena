<?php
/***************************************************************************
 *                            admin_users_inactive.php
 *                            -------------------
 *   begin                : Tuesday, Sep 19, 2003
 *   copyright            : (C) 2003 Sko22
 *   email                : sko22@quellicheilpc.it
 *
 *   $Id: admin_users_inactive.php,v 1.1.8 2005/03/14 10:30:30 sko22
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

define('IN_PHPBB', 1);

if ( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Users']['Users_Inactive'] = $filename;

	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/emailer.'.$phpEx);

//
// Set default email variables
//
$script_name = preg_replace('/^\/?(.*?)\/?$/', '\1', trim($board_config['script_path']));
$script_name = ( $script_name != '' ) ? $script_name . '/profile.'.$phpEx : 'profile.'.$phpEx;
$server_name = trim($board_config['server_name']);
$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
$server_url = $server_protocol . $server_name . $server_port . $script_name;

//
// Set default color variables
//
$alert_color = "#00FF00";
$alert_color2 = "#FFFF00";
$alert_color3 = "#FFCC00";
$alert_color4 = "#FF9900";
$alert_color5 = "#FF6600";
$alert_color_over = "#FF0000";

if(!isset($HTTP_POST_VARS['inactive_users_do']))
{

	$alert_days = ( !empty($HTTP_POST_VARS['alert_days']) ) ? ( intval($HTTP_POST_VARS['alert_days']) != 0 ? intval($HTTP_POST_VARS['alert_days']) : 5 ) : 5;
	$zero_messages = isset( $HTTP_POST_VARS['zero_messages'] ) ? "checked" : "";

	$template->set_filenames(array(
		'body' => 'admin/user_inactive_body.tpl')
	);

	//
	//Select Inactive Users
	//
	$sql_zero_messages = ( $zero_messages == "checked" ) ? 'OR user_posts = 0' : '' ;
	$sql = "SELECT user_id, username, user_lastvisit, user_regdate, user_posts, user_email, user_active, user_inactive_emls, user_inactive_last_eml FROM " . USERS_TABLE . " WHERE ( user_active = 0 AND user_actkey <> '' $sql_zero_messages ) AND user_id <> " . ANONYMOUS . " ORDER BY user_regdate ASC";
//-- mod : rank color system ---------------------------------------------------
//-- add
	$sql = str_replace('SELECT ', 'SELECT user_level, user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------	

	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain list of inactive users', '', __LINE__, __FILE__, $sql);
	}

	$i = 0;
	while( $row = $db->sql_fetchrow($result) )
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		// 60s*60m*24h*Xgg*
		$past_days = time() - $row['user_regdate'];
		switch ($past_days) {
			case ( $past_days <=  (60*60*24*$alert_days) ):
				$row_class_alert = $alert_color;
				$id_name = "alert";
			break;
			
			case ( $past_days <=  (60*60*24*$alert_days*2) ):
				$row_class_alert = $alert_color2;
				$id_name = "alert2";
			break;
			
			case ( $past_days <=  (60*60*24*$alert_days*3) ):
				$row_class_alert = $alert_color3;
				$id_name = "alert3";
			break;
			
			case ( $past_days <=  (60*60*24*$alert_days*4) ):
				$row_class_alert = $alert_color4;
				$id_name = "alert4";
			break;
			
			case ( $past_days <=  (60*60*24*$alert_days*5) ):
				$row_class_alert = $alert_color5;
				$id_name = "alert5";
			break;

			default:
				$row_class_alert = $alert_color_over;
				$id_name = "alert_over";
		}

		$last_user_visit = ( $row['user_lastvisit'] == 0 ) ?  "- -" : create_date($lang['DATE_FORMAT'], $row['user_lastvisit'], $board_config['board_timezone']);
		$last_email_sents = ( $row['user_inactive_last_eml'] == 0 ) ? "- -" : create_date($lang['DATE_FORMAT'], $row['user_inactive_last_eml'], $board_config['board_timezone']);

		$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $row['user_id']) : 'mailto:' . $row['user_email'];

		$template->assign_block_vars("Table_InactiveUsers", array(
			"ROW_CLASS" => $row_class,
			"ROW_CLASS_ALERT" => $row_class_alert,
			"NUMBER" => $i +1,
			
//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
			"USERNAME" => $row['username'],
MOD-*/
			"USERNAME" => $rcs->get_colors($row, $row['username']),
//-- fin mod : rank color system -----------------------------------------------
			"EMAIL_IMG" => '<a href="' . $email_uri . '"><img src="../' . $images['icon_email'] . '" alt="' . $row['user_email'] . '" title="' . $row['user_email'] . '" border="0" /></a>',		

			"USER_REGDATE" => create_date($lang['DATE_FORMAT'], $row['user_regdate'], $board_config['board_timezone']),
			"USER_LASTVISIT" => $last_user_visit,
			"USER_ACTIVE" => ( $row['user_active'] != 0 ) ? $lang['Yes'] : $lang['No'],
			"USER_POSTS" => $row['user_posts'],
			"USER_EMAIL_SENTS" => $row['user_inactive_emls'],
			"USER_LAST_EMAIL_SENTS" => $last_email_sents,
			
			'U_USERNAME' => append_sid('admin_users.' . $phpEx . '?mode=edit&username=' . $row['username']),

			"S_SELECT_TABLE" => "<input type=\"checkbox\" id=\"" . $id_name . "\" name=\"selected_usr[]\" value=\"" . $row['user_id'] . "\">"
			)
		);

		$i++;
	}

	if ( $i != 0 )
	{
		$js_script = "
		<script language=\"JavaScript\">
		// I have copied and modified a script of phpMyAdmin.net
		<!--
		function setCheckboxes(the_form, do_check)
		{
		var elts = (typeof(document.forms[the_form].elements['selected_usr[]']) != 'undefined') 
		? document.forms[the_form].elements['selected_usr[]'] 
		: document.forms[the_form].elements = '';

		var elts_cnt  = (typeof(elts.length) != 'undefined') ? elts.length : 0;

		if (elts_cnt) {
			for (var i = 0; i < elts_cnt; i++) {
				if (do_check == \"invert\"){
				elts[i].checked == true ? elts[i].checked = false : elts[i].checked = true;
				} else {
				elts[i].checked = do_check;
				}
				} // end for
			} else {
				elts.checked = do_check;
			} // end if... else

		return true;
	}

	function selColor(the_form, color)
	{
		var ids = document.forms[the_form].elements[color].length;
		for (var i = 0; i < ids; i++)
		{
			document.forms[the_form].elements[color][i].checked = true;
		}
	}
	//-->
	</script>";
}
else
{
	$js_script = "
	<script language=\"JavaScript\">
	<!--
	function setCheckboxes(the_form, do_check)
	{

	}
	//-->
	</script>";
}

//
//Check Enable account activation
//
switch ( $board_config['require_activation'] ) {
    case 0:
        $check_enable_account_activation = $lang['UI_Check_None'];
        $recom_acc_act = sprintf($lang['UI_Check_Recom'], "<a href=\"" . append_sid("admin_board.php") . "\">", "</a>");
        break;
    case 1:
        $check_enable_account_activation = $lang['UI_Check_User'];
        break;
    case 2:
        $check_enable_account_activation = $lang['UI_Check_Admin'];
        break;
}

$template->assign_vars(array(
	"L_USERS_INACTIVE" => $lang['Users_Inactive'],
	"L_CHECK_ENABLE_ACCOUNT_ACTIVATION" => $check_enable_account_activation,
	"L_RECOM_ACC_ACTIV" => $recom_acc_act,
	"L_REMOVED_USERS" => $lang['UI_Removed_Users'],
	"L_USERS_INACTIVE_EXPLAIN" => $lang['Users_Inactive_Explain'],
	"L_USER" => $lang['UI_User'],
	"L_EMAIL" => $lang['Email'],
	"L_REGISTRATION_DATE" => $lang['UI_Registration_Date'],
	"L_LAST_VISIT" => $lang['UI_Last_Visit'],
	"L_ACTIVE" => $lang['UI_Active'],
	"L_POSTS" => $lang['Posts'],
	"L_EMAIL_SENTS" => $lang['UI_Email_Sents'],
	"L_LAST_EMAIL_SENTS" => $lang['UI_Last_Email_Sents'],
	"L_CHECKCOLOR" => $lang['UI_CheckColor'],
	"L_CHECKALL" => $lang['UI_CheckAll'],
	"L_UNCHECKALL" => $lang['UI_UncheckAll'],
	"L_INVERTCHECKED" => $lang['UI_InvertChecked'],
	"L_CONTACT_USERS" => $lang['UI_Contact_Users'],
	"L_DELETE_USERS" => $lang['UI_Delete_Users'],
	"L_ACTIVATE_USERS" => $lang['UI_Activate_Users'],
	"L_ALERT_DAYS" => $lang['UI_Alert_Days'],
	"L_WITH_ZERO_MESSAGES" => $lang['UI_with_zero_messages'],
	"L_ALERT_EVERY" => $lang['UI_Alert_Every'],
	"L_ALERT_UPTO" => $lang['UI_Alert_UpTo'],
	"L_ALERT_OVER" => $lang['UI_Alert_Over'],
	"L_POST" => $lang['Post'],

	"REMOVED_USERS" => $board_config['removed_users'],

	"ALERT_COLOR" => $alert_color,
	"ALERT_COLOR2" => $alert_color2,
	"ALERT_COLOR3" => $alert_color3,
	"ALERT_COLOR4" => $alert_color4,
	"ALERT_COLOR5" => $alert_color5,
	"ALERT_COLOR_OVER" => $alert_color_over,

	"ALERT_DAYS" => $alert_days,
	"ALERT_DAYS2" => $alert_days*2,
	"ALERT_DAYS3" => $alert_days*3,
	"ALERT_DAYS4" => $alert_days*4,
	"ALERT_DAYS5" => $alert_days*5,
	"ALERT_DAYS_OVER" => (($alert_days*5)+1),

	"JS_SCRIPT" => $js_script,

	"S_ALERT_DAYS" => $alert_days,
	"S_ZERO_MESSAGES" => $zero_messages,
	"S_INACTIVE_ACTION" => append_sid('admin_users_inactive.' . $phpEx)
	)
);

$template->pparse('body');

} 

else
	
{

switch ($HTTP_GET_VARS['mode']) {

	
	case "contact":
	
	if ( $HTTP_POST_VARS['selected_usr'] != "")
	{
	
	$date = time();

	//
	//Contact to Inactive Users
	//
	foreach ($HTTP_POST_VARS['selected_usr'] as $to_userdata)
	{

		//
		//Update email sends to Inactive Users
		//
		$sql = "UPDATE " . USERS_TABLE . " SET user_inactive_emls = user_inactive_emls+1, user_inactive_last_eml = $date WHERE user_id=$to_userdata AND user_id <> " . ANONYMOUS ;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update emails sends to inactive users', '', __LINE__, __FILE__, $sql);
		}

		//
		//Email to send to Inactive Users
		//
		$sql = "SELECT username, user_lang, user_email, user_actkey FROM " . USERS_TABLE . " WHERE user_id=$to_userdata AND user_id <> " . ANONYMOUS ;

		if ( $result = $db->sql_query($sql) )
		{
			$userdata = $db->sql_fetchrow($result);
			$emailer = new emailer($board_config['smtp_delivery']);

		if ( substr($board_config['version'], -1) <= 4)
			{ 
				$email_headers = "From: " . $board_config['board_email'] . "\nReturn-Path: " . $board_config['board_email'] . "\n";
				$emailer->extra_headers($email_headers);
			}
			else 
			{
				$emailer->from($board_config['board_email']);
				$emailer->replyto($board_config['board_email']);
			}

			$emailer->use_template('user_inactive_contact', $userdata['user_lang']);
			$emailer->email_address($userdata['user_email']);
							
			$emailer->assign_vars(array(
				"USERNAME" => $userdata['username'], 
				"SITENAME" => $board_config['sitename'],
				"EMAIL_SIG" => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
				"U_ACTIVE_REGISTRATION" => $server_url . '?mode=activate&' . POST_USERS_URL . '=' . $to_userdata . '&act_key=' . $userdata['user_actkey']
				)
				);

				$emailer->send();
				$emailer->reset();

		} else {

		message_die(GENERAL_ERROR, 'Could not sends emails to inactive users', '', __LINE__, __FILE__, $sql);

		}
	}

		$message = $lang['Message_sent']  . "." . 
			"<br /><br />" . sprintf($lang['UI_return'], "<a href=\"" . append_sid("admin_users_inactive.$phpEx?mode=modify") . "\">", "</a>")	 .
			"<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>")	;

		message_die(GENERAL_MESSAGE, $message);

		} 
		
		else 
		
		{
		
		$message = $lang['UI_select_user_first']  . "." .
		"<br /><br />" . sprintf($lang['UI_return'], "<a href=\"" . append_sid("admin_users_inactive.$phpEx?mode=modify") . "\">", "</a>")	 .
		"<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>")	;

		message_die(GENERAL_MESSAGE, $message);
		
		}

		break;



	case "activate":
	
	if ( $HTTP_POST_VARS['selected_usr'] != "")
	{
	
	//
	//Activate Users
	//
	foreach ($HTTP_POST_VARS['selected_usr'] as $to_userdata)
	{

		$sql = "UPDATE " . USERS_TABLE . " SET user_active = 1, user_actkey = '' WHERE user_id=$to_userdata AND user_id <> " . ANONYMOUS ;
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql_update);
		}

		//
		//Email to send to Inactive Users
		//
		$sql = "SELECT username, user_lang, user_email FROM " . USERS_TABLE . " WHERE user_id=$to_userdata AND user_id <> " . ANONYMOUS ;

		if ( $result = $db->sql_query($sql) )
		{
			$userdata = $db->sql_fetchrow($result);
			$emailer = new emailer($board_config['smtp_delivery']);

		if ( substr($board_config['version'], -1) <= 4)
			{ 
				$email_headers = 'From: ' . $board_config['board_email'] . "\nReturn-Path: " . $board_config['board_email'] . "\n";
				$emailer->extra_headers($email_headers);
			}
			else 
			{
				$emailer->from($board_config['board_email']);
				$emailer->replyto($board_config['board_email']);
			}

			$emailer->use_template('admin_welcome_activated', $userdata['user_lang']);
			$emailer->email_address($userdata['user_email']);
						
			$emailer->assign_vars(array(
				'SITENAME' => $board_config['sitename'], 
				'USERNAME' => $userdata['username'],
				'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '')
			);
			$emailer->send();
			$emailer->reset();

		} else {

		message_die(GENERAL_ERROR, 'Could not sends emails to activate users', '', __LINE__, __FILE__, $sql);

		}

	}

		$message = $lang['UI_Activated_Users']  . "." . 
			"<br /><br />" . sprintf($lang['UI_return'], "<a href=\"" . append_sid("admin_users_inactive.$phpEx?mode=modify") . "\">", "</a>")	 .
			"<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>")	;

		message_die(GENERAL_MESSAGE, $message);

		} 
		
		else 
		
		{
		
		$message = $lang['UI_select_user_first']  . "." .
		"<br /><br />" . sprintf($lang['UI_return'], "<a href=\"" . append_sid("admin_users_inactive.$phpEx?mode=modify") . "\">", "</a>")	 .
		"<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>")	;

		message_die(GENERAL_MESSAGE, $message);
		
		}

		break;



	case "delete":
		
		if ( $HTTP_POST_VARS['selected_usr'] != "")
		{
		
		//
		//Delete Inactive Users
		//
		$rem_users = 0;
		foreach ($HTTP_POST_VARS['selected_usr'] as $to_userdata)
		{
			
		//
		//Email to send to Inactive Users
		//
		$sql = "SELECT username, user_lang, user_email FROM " . USERS_TABLE . " WHERE user_id=$to_userdata AND user_id <> " . ANONYMOUS ;

		if ( $result = $db->sql_query($sql) )
		{
			$userdata = $db->sql_fetchrow($result);
			$emailer = new emailer($board_config['smtp_delivery']);

		if ( substr($board_config['version'], -1) <= 4)
			{ 
				$email_headers = 'From: ' . $board_config['board_email'] . "\nReturn-Path: " . $board_config['board_email'] . "\n";
				$emailer->extra_headers($email_headers);
			}
			else 
			{
				$emailer->from($board_config['board_email']);
				$emailer->replyto($board_config['board_email']);
			}

			$emailer->use_template('user_inactive_delete', $userdata['user_lang']);
			$emailer->email_address($userdata['user_email']);
							
			$emailer->assign_vars(array(
				'USERNAME' => $userdata['username'], 
				'SITENAME' => $board_config['sitename'],
				'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
				'U_REGISTER' => $server_protocol . $server_name . $server_port . $script_name . "?mode=register"
				)
				);

				$emailer->send();
				$emailer->reset();

		} else {

		message_die(GENERAL_ERROR, 'Could not sends emails to inactive users', '', __LINE__, __FILE__, $sql);

		}

		$sql = "DELETE FROM " . USERS_TABLE . " WHERE user_id=$to_userdata AND user_id <> " . ANONYMOUS ;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete inactive users', '', __LINE__, __FILE__, $sql);
		}

			$sql = "SELECT g.group_id 
				FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g  
				WHERE ug.user_id = $to_userdata 
					AND g.group_id = ug.group_id 
					AND g.group_single_user = 1";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain group information for this user', '', __LINE__, __FILE__, $sql);
			}

			$row = $db->sql_fetchrow($result);
			
			$sql = "UPDATE " . POSTS_TABLE . "
				SET poster_id = " . DELETED . ", post_username = '$username' 
				WHERE poster_id = $to_userdata";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update posts for this user', '', __LINE__, __FILE__, $sql);
			}

			$sql = "UPDATE " . TOPICS_TABLE . "
				SET topic_poster = " . DELETED . " 
				WHERE topic_poster = $to_userdata";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update topics for this user', '', __LINE__, __FILE__, $sql);
			}
			
			$sql = "UPDATE " . VOTE_USERS_TABLE . "
				SET vote_user_id = " . DELETED . "
				WHERE vote_user_id = $to_userdata";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update votes for this user', '', __LINE__, __FILE__, $sql);
			}
			
			$sql = "SELECT group_id
				FROM " . GROUPS_TABLE . "
				WHERE group_moderator = $to_userdata";
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
				WHERE user_id = $to_userdata";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete user', '', __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . USER_GROUP_TABLE . "
				WHERE user_id = $to_userdata";
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
				WHERE user_id = $to_userdata";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete user from topic watch table', '', __LINE__, __FILE__, $sql);
			}
			
			$sql = "DELETE FROM " . BANLIST_TABLE . "
				WHERE ban_userid = $to_userdata";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not delete user from banlist table', '', __LINE__, __FILE__, $sql);
			}

			$sql = "SELECT privmsgs_id
				FROM " . PRIVMSGS_TABLE . "
				WHERE privmsgs_from_userid = $to_userdata 
					OR privmsgs_to_userid = $to_userdata";
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
		$rem_users++;
		}

		$new_rem_users = intval($board_config['removed_users']) + $rem_users;
		$sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '" . $new_rem_users . "' WHERE config_name = 'removed_users' ";

		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update config table', '', __LINE__, __FILE__, $sql);
		}

		$message = $lang['UI_Deleted_Users'] . "." .
		"<br /><br />" . sprintf($lang['UI_return'], "<a href=\"" . append_sid("admin_users_inactive.$phpEx?mode=modify") . "\">", "</a>")	 .
		"<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>")	;

		message_die(GENERAL_MESSAGE, $message);
		
		} 
		
		else 
		
		{
		
		$message = $lang['UI_select_user_first']  . "." .
		"<br /><br />" . sprintf($lang['UI_return'], "<a href=\"" . append_sid("admin_users_inactive.$phpEx?mode=modify") . "\">", "</a>")	 .
		"<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>")	;

		message_die(GENERAL_MESSAGE, $message);
		
		}

		break;
}


}

include('./page_footer_admin.'.$phpEx);

?>