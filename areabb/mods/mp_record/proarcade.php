<?php
// -----------------------------------------------------------------------------------------------------
/*
			Notification de record par MP
			
			Envoi un MP (mail si coché dans le profil) si le record a été battu			
*/
// -----------------------------------------------------------------------------------------------------

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
include_once($phpbb_root_path . 'includes/emailer.'.$phpEx);
load_lang('arcade');
global $cas_score,$gid;

// Le record a-t-il été battu ? 
if ($cas_score == 3)
{
	$sql = 'SELECT s.user_id , s.score_game , s.score_date , s.score_time, u.username, g.game_libelle, g.game_desc  
			FROM '.AREABB_SCORES_TABLE.' as s LEFT JOIN '.USERS_TABLE.' as u ON s.user_id=u.user_id 
			LEFT JOIN '. AREABB_GAMES_TABLE .' as g ON s.game_id=g.game_id 
			WHERE s.game_id='.$gid.'
			ORDER BY score_game DESC LIMIT 2';

	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'extraire des infos sur ce jeu", '', __LINE__, __FILE__, $sql); 
	}
	// Si c'est le premier score pas la peine de vérifier..
	if ($db->sql_numrows($result)>1 )
	{
		// Le nouveau
		$row[0] = $db->sql_fetchrow($result);
		// l'ancien
		$row[1] = $db->sql_fetchrow($result);

		// Il a été battu donc j'envoi un mail à l'ancien recordman
		// on initialise tout ce qui doit l'être 
		$privmsg_subject = sprintf($lang['record_battu_sujet'],$row[0]['game_libelle']);
		$msg_time = time();
		$message = sprintf($lang['record_battu_message'],$row[0]['username'],$row[0]['game_libelle'],$row[1]['score_game'],$row[0]['score_game'],'<a href="'.$server_protocol . $server_name . $server_port .'games.'.$phpEx.'?gid='.$gid.'">','</a>');
		$html_on = $userdata['user_allowhtml'];
		$bbcode_on = $userdata['user_allowbbcode'];
		$bbcode_uid = $userdata['bbcode_uid'];
		$smilies_on =  $userdata['user_allowsmile'];
		$attach_sig = $userdata['user_attachsig'];
		$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
		$script_name = ( $script_name != '' ) ? $script_name . '/privmsg.'.$phpEx : 'privmsg.'.$phpEx;
		$server_name = trim($board_config['server_name']);
		$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
		$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';
		
		
		// On récupère les infos sur l'ancien recordman
		$sql = 'SELECT user_id, user_notify_pm, user_email, user_lang, user_active 
		FROM ' . USERS_TABLE . ' WHERE user_id = \'' . $row[1]['user_id'] . '\' AND user_id <> ' . ANONYMOUS;

		if( !($resultat = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain user to send PM', '', __LINE__, __FILE__, $sql);
		}

		$to_userdata = $db->sql_fetchrow($resultat);
		// On enregistre le MP
		$sql_info = 'INSERT INTO ' . PRIVMSGS_TABLE . ' 
		(privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_ip, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig) 
		VALUES (' . PRIVMSGS_UNREAD_MAIL . ', \'' . str_replace("\'", "''", $privmsg_subject) . '\',	' . $userdata['user_id'] . ', ' . $row[1]['user_id']  . ', '.$msg_time.', \''.$user_ip.'\',	 '.$html_on.', '.$bbcode_on.', '.$smilies_on.', '.$attach_sig.')';
		
		if ( !($result = $db->sql_query($sql_info, BEGIN_TRANSACTION)) )
		{
			message_die(GENERAL_ERROR, "Could not insert/update private message sent info.", "", __LINE__, __FILE__, $sql_info);
		}

		$privmsg_sent_id = $db->sql_nextid();
		$privmsg_message = $message;
		// 2eme partie du MP
		$sql = 'INSERT INTO ' . PRIVMSGS_TEXT_TABLE . ' (privmsgs_text_id, privmsgs_bbcode_uid, privmsgs_text) 
		VALUES ('.$privmsg_sent_id.', 	\'' . $bbcode_uid . '\', \'' . str_replace("\'", "''", $privmsg_message) . '\')';		

		if ( !$db->sql_query($sql, END_TRANSACTION) )
		{
			message_die(GENERAL_ERROR, "Could not insert/update private message sent text.", "", __LINE__, __FILE__, $sql_info);
		}
		// On incrémente le compteur de MP
		$sql = 'UPDATE ' . USERS_TABLE . '	
				SET user_new_privmsg = user_new_privmsg + 1, user_last_privmsg = ' . $msg_time . '	
				WHERE user_id = ' . $to_userdata['user_id'] ; 
					
		if ( !$status = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update private message new/read status for user', '', __LINE__, __FILE__, $sql);
		}
		
		if ( $to_userdata['user_notify_pm'] && !empty($to_userdata['user_email']) && $to_userdata['user_active'] )
		{
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
			$emailer->use_template('privmsg_notify', $to_userdata['user_lang']);
			$emailer->email_address($to_userdata['user_email']);
			$emailer->set_subject($lang['Notification_subject']);
			$emailer->assign_vars(array(
				'USERNAME' => $to_username, 
				'SITENAME' => $board_config['sitename'],
				'EMAIL_SIG' => (!empty($board_config['board_email_sig'])) ? str_replace('<br />', "\n", "-- \n" . $board_config['board_email_sig']) : '', 
				'U_INBOX' => $server_protocol . $server_name . $server_port . $script_name . '?folder=inbox'
			));
			$emailer->send();
			$emailer->reset();
		}		
	}
}

?>