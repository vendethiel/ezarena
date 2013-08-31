<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

function adr_send_pm($dest_user, $subject, $message, $check_from_id='')
{
	global $db , $phpbb_root_path , $phpEx , $lang, $user_ip, $board_config , $userdata;

	$dest_user = intval($dest_user);
	$msg_time = time();
	$from_id = ($check_from_id === '') ? intval($userdata['user_id']) : $check_from_id;

	$html_on = 1;
    $bbcode_on = 1;
    $smilies_on = 1;

	include_once($phpbb_root_path . 'includes/functions_post.'.$phpEx);
	include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
   
	$privmsg_subject = trim(strip_tags($subject));
	$bbcode_uid = make_bbcode_uid();
	$privmsg_message = trim(strip_tags($message));

	// APM compliance
	if ( defined('PRIVMSGA_TABLE'))
	{
		include_once($phpbb_root_path . 'includes/functions_messages.'.$phpEx);
		send_pm( 0 , '' , $dest_user , $privmsg_subject, $privmsg_message, '' );
	}
	else
	{
		$sql = "SELECT user_id, user_notify_pm, user_email, user_lang, user_active
			 FROM " . USERS_TABLE . "
			 WHERE user_id = $dest_user ";
		if ( !($result = $db->sql_query($sql)) )
		{
			$error = TRUE;
			$error_msg = $lang['No_such_user'];
		}
		$to_userdata = $db->sql_fetchrow($result);

		$sql = "SELECT COUNT(privmsgs_id) AS inbox_items, MIN(privmsgs_date) AS oldest_post_time
			FROM " . PRIVMSGS_TABLE . "
			WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
			  OR privmsgs_type = " . PRIVMSGS_READ_MAIL . " 
				OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . " )
			AND privmsgs_to_userid = $dest_user ";
		if ( !($result = $db->sql_query($sql)) )
		{
			 message_die(GENERAL_MESSAGE, $lang['No_such_user']);
		}

		$sql_priority = ( SQL_LAYER == 'mysql' ) ? 'LOW_PRIORITY' : '';

		if ( $inbox_info = $db->sql_fetchrow($result) )
		{
			if ( $inbox_info['inbox_items'] >= $board_config['max_inbox_privmsgs'] )
			{
				$sql = "SELECT privmsgs_id FROM " . PRIVMSGS_TABLE . "
					WHERE ( privmsgs_type = " . PRIVMSGS_NEW_MAIL . "
					OR privmsgs_type = " . PRIVMSGS_READ_MAIL . "
					OR privmsgs_type = " . PRIVMSGS_UNREAD_MAIL . "  )
					AND privmsgs_date = " . $inbox_info['oldest_post_time'] . "
					AND privmsgs_to_userid = $dest_user ";
				if ( !$result = $db->sql_query($sql) )
				{	
					message_die(GENERAL_ERROR, 'Could not find oldest privmsgs (inbox)', '', __LINE__, __FILE__, $sql);
				}
				$old_privmsgs_id = $db->sql_fetchrow($result);
				$old_privmsgs_id = $old_privmsgs_id['privmsgs_id'];
           
				$sql = "DELETE $sql_priority FROM " . PRIVMSGS_TABLE . "
					WHERE privmsgs_id = $old_privmsgs_id";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete oldest privmsgs (inbox)'.$sql, '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE $sql_priority FROM " . PRIVMSGS_TEXT_TABLE . "
					WHERE privmsgs_text_id = $old_privmsgs_id";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete oldest privmsgs text (inbox)', '', __LINE__, __FILE__, $sql);
				}
			}
		}

		$sql_info = "INSERT INTO " . PRIVMSGS_TABLE . " 
			(privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_ip, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies)
			VALUES ( 1 , '" . str_replace("\'", "''", addslashes($privmsg_subject)) . "' , " . $from_id . ", " . $to_userdata['user_id'] . ", $msg_time, '$user_ip' , $html_on, $bbcode_on, $smilies_on)";
		if ( !$db->sql_query($sql_info) )
		{
			message_die(GENERAL_ERROR, 'Could not delete oldest privmsgs text (inbox)', '', __LINE__, __FILE__, $sql_info);
		}

		$privmsg_sent_id = $db->sql_nextid();

		$sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_bbcode_uid, privmsgs_text)
			VALUES ($privmsg_sent_id, '" . $bbcode_uid . "', '" . str_replace("\'", "''", addslashes($privmsg_message)) . "')"; 
		if ( !$db->sql_query($sql, END_TRANSACTION) )
		{
			message_die(GENERAL_ERROR, "Could not insert/update private message sent text.", "", __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . USERS_TABLE . "
			SET user_new_privmsg = user_new_privmsg + 1, user_last_privmsg = " . time() . " 
			WHERE user_id = " . $to_userdata['user_id'];
		if ( !$status = $db->sql_query($sql) )
		{
			 message_die(GENERAL_ERROR, 'Could not update private message new/read status for user', '', __LINE__, __FILE__, $sql);
		}

		if ( $to_userdata['user_notify_pm'] && !empty($to_userdata['user_email']) && $to_userdata['user_active'] )
		{
			// have the mail sender infos
			$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
			$script_name = ( $script_name != '' ) ? $script_name . '/privmsg.'.$phpEx : 'privmsg.'.$phpEx;
			$server_name = trim($board_config['server_name']);
			$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
			$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';

			include_once($phpbb_root_path . './includes/emailer.'.$phpEx);
			$emailer = new emailer($board_config['smtp_delivery']);
        
			if  ( $board_config['version'] == '.0.5' || $board_config['version'] == '.0.6' || $board_config['version'] == '.0.7' || $board_config['version'] == '.0.8' || $board_config['version'] == '.0.9' )
			{   
				$emailer->from($board_config['board_email']);
				$emailer->replyto($board_config['board_email']);
				$emailer->use_template('privmsg_notify', $to_userdata['user_lang']);
			}
			else
			{
				$email_headers = 'From: ' . $board_config['board_email'] . "\nReturn-Path: " . $board_config['board_email'] . "\n";
				$emailer->use_template('privmsg_notify', $to_userdata['user_lang']);
				$emailer->extra_headers($email_headers);
			}
			$emailer->email_address($to_userdata['user_email']);
			$emailer->set_subject($lang['Notification_subject']);

			$emailer->assign_vars(array(
				'USERNAME' => $to_username,
				'SITENAME' => $board_config['sitename'],
				'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '',
				'U_INBOX' => $server_protocol . $server_name . $server_port . $script_name . '?folder=inbox')
			 );

			$emailer->send();
			$emailer->reset();
		}
	}
	return;
}

?>