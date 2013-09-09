<?php
/***************************************************************************
 *                          functions_rabbitoshi_cron.php
 *                              -------------------
 *     begin                : Thurs June 9 2006
 *     copyright            : (C) 2006 The ADR Dev Crew
 *     site                 : http://www.adr-support.com
 *
 *     $Id: functions_rabbitoshi_cron.php,v 4.00.0.00 2006/06/09 02:32:18 Ethalic Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
if ( !defined('IN_RABBITOSHI') ) {
	include($phpbb_root_path . 'rabbitoshi/includes/functions_rabbitoshi.'.$phpEx);
}
include($phpbb_root_path . 'rabbitoshi/language/lang_' . $board_config['default_lang'] . '/lang_rabbitoshi.'.$phpEx);

// Advance Private Message Compadible
if ( defined('PRIVMSGA_TABLE'))
{
	include_once($phpbb_root_path . 'includes/functions_messages.'.$phpEx);
}

if ( !$board_config['rabbitoshi_cron_last_time'] )
{
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = ".time()." WHERE config_name = 'rabbitoshi_cron_last_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) {
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $lsql); 
	} 
	$board_config['rabbitoshi_cron_last_time']  = time();
}

if ( ( time() - $board_config['rabbitoshi_cron_last_time'] ) > $board_config['rabbitoshi_cron_time'])
{
	$sql = "SELECT * FROM  " . RABBITOSHI_GENERAL_TABLE ;
	if (!$result = $db->sql_query($sql)) {
		message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		$rabbit_general[$row['config_name']] = $row['config_value'];
	}
	$rsql = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE ;
	if (!$rresult = $db->sql_query($rsql)) {
		message_die(CRITICAL_ERROR, 'Unable to aquire user pet data.');
	}
	$rrow = $db->sql_fetchrowset($rresult);

	for ( $i = 0 ; $i < count ( $rrow ) ; $i ++)
	{
		$rabbit_user = rabbitoshi_get_user_stats($rrow[$i]['owner_id'] );
		$message = '';
		$pet_dead = FALSE;
		$thought = '';
		$status = 0;

		$hotel_time = $rabbit_user['creature_hotel'] - time() ;
		if ( $hotel_time > 0 )
		{
			$is_in_hotel = TRUE ;
		}
		else
		{
			$is_in_hotel = FALSE ;
		}

		$visit_time = time() - $rabbit_user['owner_last_visit'];
		$hunger_time = floor( $visit_time / $rabbit_general['hunger_time']);
		$hunger_less = ($hunger_time * $rabbit_general['hunger_value']);
		$thirst_time = floor( $visit_time / $rabbit_general['thirst_time']);
		$thirst_less = ($thirst_time * $rabbit_general['thirst_value']);
		$hygiene_time = floor( $visit_time / $rabbit_general['hygiene_time']);
		$hygiene_less =($hygiene_time * $rabbit_general['hygiene_value']);
		$health_time = floor( $visit_time / $rabbit_general['health_time']);
		$health_less = ( $health_time * $rabbit_general['health_value'] ) + floor ( ( $hunger_less + $hygiene_less + $thirst_less ) / 3 );

		if ( !$is_in_hotel )
		{
			$usql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
			SET creature_hunger = creature_hunger - $hunger_less ,
			creature_thirst = creature_thirst - $thirst_less ,
			creature_health = creature_health - $health_less ,
			creature_hygiene = creature_hygiene - $hygiene_less ,
			owner_last_visit = ".time()."
			WHERE owner_id = ".$rrow[$i]['owner_id'];
			if (!$db->sql_query($usql))
			{
				message_die(GENERAL_ERROR, '', __LINE__, __FILE__, $usql);
			}
		}

		$rabbit_stats = get_rabbitoshi_config($rabbit_user['owner_creature_id'] );
		$time = time() - $rabbit_user['creature_age'];
		$hunger_status = floor (( $rabbit_user['creature_hunger'] / $rabbit_stats['creature_max_hunger'] ) *100);
		$thirst_status = floor (( $rabbit_user['creature_thirst'] / $rabbit_stats['creature_max_thirst'] ) *100);
		$health_status = floor (( $rabbit_user['creature_health'] / $rabbit_stats['creature_max_health'] ) *100);
		$hygiene_status = floor (( $rabbit_user['creature_hygiene'] / $rabbit_stats['creature_max_hygiene'] ) *100);
		$status = 0;
		
		if ( $hunger_status < 0 || $rabbit_user['creature_hunger'] == '0')
		{
			$pet_dead = true;
		}
		else if ( $hunger_status < 25 )
		{
			$message .= $lang['Rabbitoshi_message_very_hungry'].'<br />';
		}
		else if ( $hunger_status < 50 )
		{
			$message .= $lang['Rabbitoshi_message_hungry'].'<br />';
		}
		else
		{
			$status = $status +1 ;
		}
		if ( $thirst_status < 0 || $rabbit_user['creature_thirst'] == '0')
		{
			$pet_dead = true;	
		}
		else if ( $thirst_status < 25 )
		{
			$message .= $lang['Rabbitoshi_message_very_thirst'].'<br />';
		}
		else if ( $thirst_status < 50 )
		{
			$message .= $lang['Rabbitoshi_message_thirst'].'<br />';
		}
		else
		{
			$status = $status +1 ;
		}
		if ( $health_status < 0 || $rabbit_user['creature_health'] == '0')
		{
			$pet_dead = true;	
		}
		else if ( $health_status < 25 )
		{
			$message .= $lang['Rabbitoshi_message_very_health'].'<br />';
		}
		else if ( $health_status < 50 )
		{
			$message .= $lang['Rabbitoshi_message_health'].'<br />';
		}
		else
		{
			$status = $status +1 ;
		}
		if ( $hygiene_status < 0 || $rabbit_user['creature_hygiene'] == '0')
		{
			$pet_dead = true;	
		}
		else if ( $hygiene_status < 25 )
		{
			$message .= $lang['Rabbitoshi_message_very_hygiene'].'<br />';
		}
		else if ( $hygiene_status < 50 )
		{
			$message .= $lang['Rabbitoshi_message_hygiene'].'<br />';
		}
		else
		{
			$status = $status +1 ;
		}
		if ( $status =='0' )
		{
			$thought = $lang['Rabbitoshi_general_message_very_bad'];
		}
		else if ( $status =='1' )
		{
			$thought = $lang['Rabbitoshi_general_message_bad'];
		}
		else if ( $status =='2' )
		{
			$thought = $lang['Rabbitoshi_general_message_neutral'];
		}
		else if ( $status =='3' )
		{
			$thought = $lang['Rabbitoshi_general_message_good'];
		}
		else
		{
			$thought = $lang['Rabbitoshi_general_message_very_good'];
		}

		$pm_comment = '<font color=red>'.$lang['Rabbitoshi_pm_news'].'</font><br /><br />';

		if ( $pet_dead )
		{
			$pm_comment .= $lang['Rabbitoshi_pet_has_died'];
		}
		else if ( $is_in_hotel )
		{
			$pm_comment .= $lang['Rabbitoshi_pm_news_hotel'];
		}
		else
		{
			$pm_comment .= '<b>'.$lang['Rabbitoshi_general_message'].'</b>'.'<br />'.$thought.'<br /><br />';
			$pm_comment .= '<b>'.$lang['Rabbitoshi_message'].'</b>'.'<br />'.$message.'<br /><br />';
		}

		if ( $rrow[$i]['owner_notification'] )
		{
			$user_id = $rrow[$i]['owner_id']; 
	
			$new_comment_subject = $lang['Rabbitoshi_pm_news'];
			$new_comment = $pm_comment;
			$comment_date = date("U"); 

			if ( defined('PRIVMSGA_TABLE'))
			{
				$new_comment = $lang['Rabbitoshi_APM_pm'];
				send_pm( 0 , '' , $user_id , $new_comment_subject, $new_comment, '' );
			}
			else
			{
				$sql = "UPDATE " . USERS_TABLE . " 
					SET user_new_privmsg = user_new_privmsg + 1 , user_last_privmsg = '9999999999' 
					WHERE user_id = " . $rrow[$i]['owner_id']; 
				if ( !($result = $db->sql_query($sql)) ) {
					message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql);
				}
				$sql = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig) VALUES ('" . PRIVMSGS_NEW_MAIL . "', '" . str_replace("\'", "''", addslashes(sprintf($new_comment_subject))) . "', '2', '" . $user_id . "', '" . $comment_date . "', '0', '1', '1', '0')";
				if ( !$db->sql_query($sql) ) {
					message_die(GENERAL_ERROR, 'Could not insert private message sent info', '', __LINE__, __FILE__, $sql); 
				} 
				$privmsg_sent_id = $db->sql_nextid(); 
				$privmsgs_text = $new_comment; 

				$sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_text) VALUES ($privmsg_sent_id, '" . str_replace("\'", "''", addslashes(sprintf($privmsgs_text))) . "')"; 
				if ( !$db->sql_query($sql) ) 
				{ 
					message_die(GENERAL_ERROR, 'Could not insert private message sent text', '', __LINE__, __FILE__, $sql); 
				}
			}
		}
	}

	$new_time = $board_config['rabbitoshi_cron_last_time'] +  $board_config['rabbitoshi_cron_time'];

	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = $new_time WHERE config_name = 'rabbitoshi_cron_last_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $lsql); 
	} 
}

?>