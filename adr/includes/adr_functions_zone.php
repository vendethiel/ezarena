<?php

if ( !defined('IN_PHPBB') )
	die("Hacking attempt");

function adr_item_quest_check($npc_id, $npc_check, $times)
{
	if ( $npc_check == "" || $times <= 0 )
	    return 1;

	$npc_check_list = explode(";", $npc_check);

	for ( $i=0 ; $i<count($npc_check_list) ; $i++ )
	{
	    $npc_check_list[$i] = explode(":", $npc_check_list[$i]);
		if ( $npc_check_list[$i][0] == $npc_id )
			if ( $npc_check_list[$i][1] >= $times )
			    return 0;
	}

	return 1;
}

function adr_item_quest_check_insert($quest_check, $npc_id, $user_id)
{
	global $db;
	
	if ($quest_check=="")
	    $quest_check = $npc_id.":1";
	else
	{
	    $present = 0;
	    $quest_check_list = explode(";", $quest_check);
		for ( $i=0 ; $i<count($quest_check_list) ; $i++ )
		{
		    $quest_check_list[$i] = explode(":", $quest_check_list[$i]);
			if ( $quest_check_list[$i][0] == $npc_id )
			{
			    $present = 1;
				$quest_check_list[$i][1] = intval($quest_check_list[$i][1]);
				$quest_check_list[$i][1]++;
				break;
			}
		}
		if ( $present == 1 )
		{
			for ( $i=0 ; $i<count($quest_check_list) ; $i++ )
			    $quest_check_list[$i] = implode(":", $quest_check_list[$i]);
		    $quest_check = implode(";", $quest_check_list);
		}
		else
		    $quest_check = $quest_check.";".$npc_id.":1";

	}
	$sql = "UPDATE  " . ADR_CHARACTERS_TABLE . "
			SET character_npc_check = '$quest_check'
			WHERE character_id = '$user_id' ";
	if ( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not update character check information', '', __LINE__, __FILE__, $sql);
}

function adr_item_quest_cheat_notification($user_id, $cheat_type)
{
	global $board_config, $userdata, $adr_general, $adr_user, $lang, $db, $phpEx, $table_prefix, $HTTP_SERVER_VARS, $HTTP_ENV_VARS;

	$adr_ban_punishment = false;
	if ( $board_config['zone_cheat_auto_ban_adr'] )
	{
		$sql = "UPDATE " . USERS_TABLE . "
				SET user_adr_ban = '1'
				WHERE user_id = '$user_id'";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, "Couldn't UPDATE ADR User Ban", "", __LINE__, __FILE__, $sql);
        $cheat_punishment = '1~';
		$adr_ban_punishment = true;
	}
	else
	    $cheat_punishment = '0~';

	$board_ban_punishment = false;
	if ( $board_config['zone_cheat_auto_ban_board'] )
	{
		$sql = "SELECT *
				FROM " . BANLIST_TABLE;
		if ( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, "Couldn't obtain banlist information", "", __LINE__, __FILE__, $sql);

		$current_banlist = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);

		$kill_session_sql = '';
		$in_banlist = false;
		for($j = 0; $j < count($current_banlist); $j++)
		{
			if ( $user_id == $current_banlist[$j]['ban_userid'] )
				$in_banlist = true;
		}

		if ( !$in_banlist )
		{
			$kill_session_sql .= ( ( $kill_session_sql != '' ) ? ' OR ' : '' ) . "session_user_id = " . $user_id;

			$sql = "INSERT INTO " . BANLIST_TABLE . " (ban_userid)
					VALUES (" . $user_id . ")";
			if ( !$db->sql_query($sql) )
				message_die(GENERAL_ERROR, "Couldn't insert ban_userid info into database", "", __LINE__, __FILE__, $sql);
		}

		if ( $kill_session_sql != '' )
		{
			$sql = "DELETE FROM " . SESSIONS_TABLE . "
					WHERE $kill_session_sql";
			if ( !$db->sql_query($sql) )
				message_die(GENERAL_ERROR, "Couldn't delete banned sessions from database", "", __LINE__, __FILE__, $sql);
		}
        $cheat_punishment .= '1~';
		$board_ban_punishment = true;
	}
	else
	    $cheat_punishment .= '0~';

	$jail_punishment = false;
	if ( $board_config['zone_cheat_auto_jail'] )
	{
		include_once($phpbb_root_path . 'adr/includes/adr_functions_jail.' . $phpEx);
		define('ADR_JAIL_USERS_TABLE', $table_prefix.'adr_jail_users');

		$time_day 			= intval( $board_config['zone_cheat_auto_time_day'] );
		$time_hour 			= intval( $board_config['zone_cheat_auto_time_hour'] );
		$time_minute 		= intval( $board_config['zone_cheat_auto_time_minute'] );
		$caution 			= intval( $board_config['zone_cheat_auto_caution'] );
		$cautionable 		= intval( $board_config['zone_cheat_auto_cautionable'] );
		$freeable 			= intval( $board_config['zone_cheat_auto_freeable'] );
		$punishment 		= intval( $board_config['zone_cheat_auto_punishment'] );
		$sentence 			= sprintf( $lang['Adr_zone_cell_sentence_example'], $cheat_type );

		adr_cell_imprison_user($user_id,$time_day,$time_hour,$time_minute,$caution,$cautionable,$freeable,$sentence,$punishment);

		$jail_term = $lang['Adr_zone_cheat_log_imprisoned_for'];
		if ( $time_day )
		{
	    	if ( $time_day > 1 )
	        	$jail_term .= $time_day . $lang['Adr_zone_cheat_log_days'];
			else
			    $jail_term .= $time_day . $lang['Adr_zone_cheat_log_day'];
		}
		if ( $time_hour )
		{
		    if ( $time_day )
	    	{
	        	if ( $time_minute )
	        		$jail_term .= ', ';
				else
		        	$jail_term .= $lang['Adr_zone_cheat_log_and'];
			}
		    if ( $time_hour > 1 )
		        $jail_term .= $time_hour . $lang['Adr_zone_cheat_log_hours'];
			else
		    	$jail_term .= $time_hour . $lang['Adr_zone_cheat_log_hour'];
		}
		if ( $time_minute )
		{
			if ( $time_hour && $time_day )
			    $jail_term .= $lang['Adr_zone_cheat_log_comma_and'];
			else if ( ( !$time_hour && $time_day ) || ( $time_hour && !$time_day ) )
			    $jail_term .= $lang['Adr_zone_cheat_log_and'];
	    	if ( $time_minute > 1 )
	        	$jail_term .= $time_hour . $lang['Adr_zone_cheat_log_minutes'];
			else
			    $jail_term .= $time_hour . $lang['Adr_zone_cheat_log_minute'];
		}
        $cheat_punishment .= '1~' . $jail_term;
		$jail_punishment = true;
	}
	else
	    $cheat_punishment .= '0~';
	    
	$cheat_public = '0';
	
	if ( !$board_config['zone_cheat_auto_ban_adr'] && !$board_config['zone_cheat_auto_ban_board'] && !$board_config['zone_cheat_auto_jail'] )
	{
        $cheat_punishment = '';
        $current_punishments = '';
	}
	else
	{
		$current_punishments = '';
		if ( $adr_ban_punishment )
	    	$current_punishments .= $lang['Adr_zone_cheat_log_banned_adr'];
		if ( $board_ban_punishment )
		{
			if ( $adr_ban_punishment )
			{
				if ( $jail_punishment )
	    			$current_punishments .= sprintf( $lang['Adr_zone_cheat_log_comma_and_sprintf'], $lang['Adr_zone_cheat_log_banned_board'] );
	    		else
	    			$current_punishments .= sprintf( $lang['Adr_zone_cheat_log_and_sprintf'], $lang['Adr_zone_cheat_log_banned_board'] );
		    }
		    else
	    		$current_punishments .= $lang['Adr_zone_cheat_log_banned_board'];
		}
		if ( $jail_punishment )
		{
			if ( $adr_ban_punishment )
			{
				if ( $board_ban_punishment )
	    			$current_punishments .= sprintf( $lang['Adr_zone_cheat_log_comma_and_sprintf'], $jail_term );
		    	else
		    		$current_punishments .= sprintf( $lang['Adr_zone_cheat_log_and_sprintf'], $jail_term );
	    	}
		    else
		    	$current_punishments .= $jail_term;
		}
    	$current_punishments = sprintf( $lang['Adr_zone_cheat_log_punishment'], $current_punishments );
    }

	$cheat_public = $board_config['zone_cheat_auto_public'];
	$pm_members = explode( ',' , $board_config['zone_cheat_member_pm'] );
	
	$port = ( $board_config['server_port'] == '80' ) ? '' : ':' . $board_config['server_port'];
	$profile = 'http://' . $board_config['server_name'] . $port . $board_config['script_path'] . 'profile.php?mode=viewprofile&u=' . $user_id;
	$subject = sprintf( $lang['Adr_zone_npc_cheating_pm_subject'], $userdata['username'] );
	$message = sprintf( $lang['Adr_zone_npc_cheating_pm_message'], $userdata['username'], $adr_user['character_name'], $cheat_type, $current_punishments, $profile );

	for ( $i = 0 ; $i < count( $pm_members ) ; $i++ )
		adr_send_pm ( $pm_members[$i] , $subject , $message );

	$ip = ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : getenv('REMOTE_ADDR') );

	$sql = "INSERT INTO " . ADR_CHEAT_LOG_TABLE . "
			VALUES ('', '". encode_ip($ip) ."', '". $cheat_type ."', '". time() ."', '$user_id', '$cheat_punishment', '$cheat_public' )";
	$db->sql_query($sql);


	adr_previous( Adr_zone_npc_cheating , adr_zones , '' );
	break;
}

function adr_zone_cheat_imprison( $celled_id , $submit , $user_id )
{
	global $board_config, $lang, $HTTP_POST_VARS, $userdata;

	if (!$celled_id)
	{
		message_die(GENERAL_ERROR, 'No User Selected!', 'Error');
	}
	#==== End: Add By aUsTiN =============================== |
	#======================================================= |

	$time_day 			= intval( $HTTP_POST_VARS['time_day'] );
	$time_hour 			= intval( $HTTP_POST_VARS['time_hour'] );
	$time_minute 		= intval( $HTTP_POST_VARS['time_minute'] );
	$caution 			= intval( $HTTP_POST_VARS['caution'] );
	$cautionable 		= intval( $HTTP_POST_VARS['cautionable'] );
	$freeable 			= intval( $HTTP_POST_VARS['freeable'] );
	$punishment 		= intval( $HTTP_POST_VARS['punishment'] );
	$sentence 			= addslashes(stripslashes( $HTTP_POST_VARS['sentence'] ));

	if ( ( $time_day == '' && $time_hour == '' && $time_minute == '' ) || !$punishment )
	{
		message_die(MESSAGE, $lang['Fields_empty']);
	}

// Modified for ADR Zones Test Board
if ($userdata['user_level'] == ADMIN)
{
	adr_cell_imprison_user($celled_id,$time_day,$time_hour,$time_minute,$caution,$cautionable,$freeable,$sentence,$punishment);
}
// Modified for ADR Zones Test Board
else if ($submit && $userdata['user_level'] != ADMIN)
{
	$message = 'You are unable to change settings!!  You are ONLY allowed to view the Zone MOD ACP Settings!';
	message_die(GENERAL_ERROR, $message);
}
// Modified for ADR Zones Test Board
}

function adr_npc_visit_update( $npc_id, $adr_user )
{
	global $db;

	$npc_update = false;
	if ( $adr_user['character_npc_visited'] == '' )
	{
	    $adr_user['character_npc_visited'] = $npc_id;
		$npc_update = true;
	}
	else
	{
		$character_npc_visited_array = explode( ',' , $adr_user['character_npc_visited'] );
		if ( !in_array( $npc_id , $character_npc_visited_array ) )
		{
	        $adr_user['character_npc_visited'] = $adr_user['character_npc_visited'] . ',' . $npc_id;
	        $npc_update = true;
	    }
	}

	if ( $npc_update )
	{
		//Update character zone
		$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_npc_visited = '" . $adr_user['character_npc_visited'] . "'
				WHERE character_id = '" . $adr_user['character_id'] . "' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character npc visits', '', __LINE__, __FILE__, $sql);
	}

	return $adr_user;
}

?>
