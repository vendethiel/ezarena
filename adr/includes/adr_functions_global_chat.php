<?PHP

/***************************************************************************************
 *                               adr_functions_global_chat.php
 *                              -------------------------------
 *		Version			: 1.0.0
 *		Authors			: aUsTiN [ (austin_inc@hotmail.com) (http://phpbb-amod.com)]
 *		Modified:		: Seteo-Bloke [ (admin@phpbb-adr.com) (http://www.phpbb-adr.com)]
 *                      : Gurukast
 *
 ***************************************************************************************/

function GC_AddChat($txt)
{
	global $db, $table_prefix;

	$q = "SELECT * FROM ". ADR_BATTLE_COMMUNITY ."
		WHERE chat_date = '". date('Y-m-d') ."'";
	$r 			= $db->sql_query($q);
	$t_chat 	= $db->sql_fetchrow($r);

	#==== Add A Chat Session For Today ====================================== |
	if(!$t_chat['chat_id'])
	{
		$q = "INSERT INTO ". ADR_BATTLE_COMMUNITY ."
			  VALUES ('', '1', '". $txt ."', '". date('Y-m-d') ."')";
		$db->sql_query($q);
	}
			
	#==== Add To Todays Chat Session ======================================== |
	if($t_chat['chat_id'] != '')
	{
		$chat_id = $t_chat['chat_id'];
		$new_txt = $txt;
		$new_txt .= addslashes($t_chat['chat_text']);
		
		$sql = "UPDATE ". $table_prefix .'adr_battle_community' ."
			  SET chat_posts = (chat_posts + 1),
				chat_text = '". $new_txt ."'
			WHERE chat_id = '$chat_id'";
		$result = $db->sql_query($sql);
		if(!$result)
		{
			message_die(GENERAL_ERROR, 'Could not update todays chat', "", __LINE__, __FILE__, $sql);
		}
	}
}

function GC_GetTodaysChat()
{
	global $db;
		
	$q = "SELECT * FROM ". ADR_BATTLE_COMMUNITY ."
		  WHERE chat_date = '". date('Y-m-d') ."'";
	$r 		= $db->sql_query($q);
	$chat 	= $db->sql_fetchrow($r);		
		
return $chat;
}

function GC_clear_today_chat()
{
	global $db;

	$sql = "UPDATE ". ADR_BATTLE_COMMUNITY ."
		  SET chat_text = '". $new_txt ."'
		  WHERE chat_date = '". date('Y-m-d') ."'";
	$result = $db->sql_query($sql);
	if(!$result)
	{
		message_die(GENERAL_ERROR, 'Could not clear todays chat', "", __LINE__, __FILE__, $sql);
	}
}

function adr_gc_username($username)
{
	global $db;

	$sql = "SELECT user_id, username, user_adr_ban
	FROM  " . USERS_TABLE . "
	WHERE username = '$username'";
	if(!($result = $db->sql_query($sql))){
		message_die(GENERAL_ERROR, 'Could not query user table', '', __LINE__, __FILE__, $sql);}
	$row = $db->sql_fetchrow($result);

return $row;
}

function adr_gc_admin_cmd_vitals($username)
{
	global $db, $lang;

	$user_infos = adr_gc_username($username);
	$user_id = $user_infos['user_id'];

	if(is_numeric($user_id))
	{
		$sql = "SELECT character_hp, character_hp_max, character_mp, character_mp_max
			FROM  " . ADR_CHARACTERS_TABLE . "
			WHERE character_id = '$user_id'";
		if(!($result = $db->sql_query($sql))){
			message_die(GENERAL_ERROR, 'Could not query character', '', __LINE__, __FILE__, $sql);}
		$adr_user = $db->sql_fetchrow($result);

		$error_messages = sprintf($lang['Adr_global_shout_vitals'], $user_infos['username'], $adr_user['character_hp'], $adr_user['character_hp_max'], $adr_user['character_mp'], $adr_user['character_mp_max']);
	}
	else
	{
		$error_messages = sprintf($lang['Adr_global_shout_incorrect_user'], $username);
	}

return $error_messages;
}

function adr_gc_admin_cmd_kill($username)
{
	global $db, $lang;

	$user_infos = adr_gc_username($username);
	$user_id = $user_infos['user_id'];

	if(is_numeric($user_id))
	{
		$sql = "SELECT character_hp FROM  " . ADR_CHARACTERS_TABLE . "
			WHERE character_id = '$user_id'";
		if(!($result = $db->sql_query($sql))){
			message_die(GENERAL_ERROR, 'Could not query character', '', __LINE__, __FILE__, $sql);}
		$adr_user = $db->sql_fetchrow($result);

		if($adr_user['character_hp'] > '0')
		{
			$sql = "UPDATE ". ADR_CHARACTERS_TABLE ."
		  		SET character_hp = 0
				WHERE character_id = '$user_id'";
			$result = $db->sql_query($sql);
			if(!$result)
			{
				message_die(GENERAL_ERROR, 'Could not KILL character', "", __LINE__, __FILE__, $sql);
			}

			$error_messages = sprintf($lang['Adr_global_shout_kill_yes'], $user_infos['username']);
		}
		else
		{
			$error_messages = sprintf($lang['Adr_global_shout_kill_already'], $user_infos['username']);
		}
	}
	else
	{
		$error_messages = sprintf($lang['Adr_global_shout_incorrect_user'], $username);
	}

return $error_messages;
}

function adr_gc_admin_cmd_revive($username)
{
	global $db, $lang;

	$user_infos = adr_gc_username($username);
	$user_id = $user_infos['user_id'];
//	$error_msg = '';

	if(is_numeric($user_id))
	{
		$sql = "SELECT character_hp FROM  " . ADR_CHARACTERS_TABLE . "
			WHERE character_id = '$user_id'";
		if(!($result = $db->sql_query($sql))){
			message_die(GENERAL_ERROR, 'Could not query character', '', __LINE__, __FILE__, $sql);}
		$adr_user = $db->sql_fetchrow($result);

		if($adr_user['character_hp'] < '1')
		{
			$sql = "UPDATE ". ADR_CHARACTERS_TABLE ."
		  		SET character_hp = character_hp_max
				WHERE character_id = '$user_id'";
			$result = $db->sql_query($sql);
			if(!$result)
			{
				message_die(GENERAL_ERROR, 'Could not REVIVE character', "", __LINE__, __FILE__, $sql);
			}

			$error_msg = sprintf($lang['Adr_global_shout_revive_yes'], $user_infos['username']);
		}
		else
		{
			$error_msg = sprintf($lang['Adr_global_shout_revive_already'], $user_infos['username']);
		}
	}
	else
	{
		$error_messages = sprintf($lang['Adr_global_shout_incorrect_user'], $username);
	}

return $error_msg;
}

function adr_admin_cmd_endallmon($username)
{
	global $db, $lang;

	$user_infos = adr_gc_username($username);
	$user_id = $user_infos['user_id'];
    $error_messages = '';

	if(is_numeric($user_id))
	{
		$sql = "SELECT battle_id FROM  " . ADR_BATTLE_LIST_TABLE . "
			WHERE battle_challenger_id = '$user_id'
			AND battle_result = '0'
			AND battle_type = '1'";
		if(!($result = $db->sql_query($sql))){
			message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
		$bat = $db->sql_fetchrow($result);

		if(is_numeric($bat['battle_id']))
		{
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_result = 3
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if( !($result = $db->sql_query($sql)) ){
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}

			$error_messages = sprintf($lang['Adr_global_shout_endmon_yes'], $user_infos['username']);
		}
		else
		{
			$error_messages = sprintf($lang['Adr_global_shout_endmon_none'], $user_infos['username']);
		}
	}
	else
	{
		$error_messages = sprintf($lang['Adr_global_shout_incorrect_user'], $username);
	}

return $error_messages;
}

function adr_admin_cmd_endallpvp($username)
{
	global $db, $lang;

	$user_infos = adr_gc_username($username);
	$user_id = $user_infos['user_id'];
    $error_messages = '';

	if(is_numeric($user_id))
	{
		$sql = "SELECT battle_id, battle_challenger_id FROM  " . ADR_BATTLE_PVP_TABLE . "
			WHERE (battle_challenger_id = '$user_id' OR battle_opponent_id = '$user_id')
			AND battle_result = '3'";
		if(!($result = $db->sql_query($sql))){
			message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
		$bat = $db->sql_fetchrowset($result);

		if(!empty($bat))
		{
			for($i = 0; $i < count($bat); $i++)
			{
				if($user_id == $bat['battle_challenger_id']){
					$battle_result = 9;
				}
				else{
					$battle_result = 8;
				}

				$battle_id = $bat[$i]['battle_id'];

				$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
					SET battle_result = $battle_result
					WHERE battle_id = '$battle_id'";
				if( !($result = $db->sql_query($sql)) ){
					message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
			}

			$error_messages = sprintf($lang['Adr_global_shout_endallpvp_yes'], $user_infos['username']);
		}
		else
		{
			$error_messages = sprintf($lang['Adr_global_shout_endallpvp_none'], $user_infos['username']);
		}
	}
	else
	{
		$error_messages = sprintf($lang['Adr_global_shout_incorrect_user'], $username);
	}

return $error_messages;
}

function adr_admin_cmd_endpvp($battle_id)
{
	global $db, $lang;

	$user_id = $user_infos['user_id'];
	$battle_id = intval($battle_id);

	$sql = "SELECT battle_id, battle_challenger_id, battle_opponent_id FROM  " . ADR_BATTLE_PVP_TABLE . "
		WHERE battle_id = '$battle_id'";
	if(!($result = $db->sql_query($sql))){
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
	$bat = $db->sql_fetchrow($result);

	if(is_numeric($bat['battle_id']))
	{
		if($user_id == $battle_pvp['battle_challenger_id']){
			$battle_result = 9;
		}
		else{
			$battle_result = 8;
		}

		$challenger_name = adr_get_user_infos($bat['battle_challenger_id']);
		$opponent_name = adr_get_user_infos($bat['battle_opponent_id']);

		$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
			SET battle_result = $battle_result
			WHERE battle_id = '$battle_id'";
		if( !($result = $db->sql_query($sql)) ){
			message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}

		$error_messages = sprintf($lang['Adr_global_shout_endpvp_yes'], $challenger_name['character_name'], $opponent_name['character_name']);
	}
	else
	{
		$error_messages = sprintf($lang['Adr_global_shout_endpvp_none'], $battle_id);
	}

return $error_messages;
}

function adr_admin_cmd_ban($username, $reason)
{
	global $db, $lang;

	$user_infos = adr_gc_username($username);
	$user_id = $user_infos['user_id'];
    $error_messages = '';

	if(is_numeric($user_id))
	{
		if($user_infos['user_adr_ban'] == '0')
		{
			$sql = "UPDATE ". USERS_TABLE ."
		  		SET user_adr_ban = 1
				WHERE user_id = '$user_id'";
			$result = $db->sql_query($sql);
			if(!$result)
			{
				message_die(GENERAL_ERROR, 'Could not update user to ADR banage', "", __LINE__, __FILE__, $sql);
			}

			// Send PM to user to notify
			$subject = $lang['Adr_global_shout_ban_pm'];
			adr_send_pm($user_id, $subject, $reason);

			$error_messages = sprintf($lang['Adr_global_shout_ban_yes'], $user_infos['username']);
		}
		else
		{
			$error_messages = sprintf($lang['Adr_global_shout_ban_already'], $user_infos['username']);
		}
	}
	else
	{
		$error_messages = sprintf($lang['Adr_global_shout_incorrect_user'], $username);
	}

return $error_messages;
}

function adr_admin_cmd_unban($username, $reason)
{
	global $db, $lang;

	$user_infos = adr_gc_username($username);
	$user_id = $user_infos['user_id'];
    $error_messages = '';

	if(is_numeric($user_id))
	{
		if($user_infos['user_adr_ban'] == '1')
		{
			$sql = "UPDATE ". USERS_TABLE ."
		  		SET user_adr_ban = 0
				WHERE user_id = '$user_id'";
			$result = $db->sql_query($sql);
			if(!$result)
			{
				message_die(GENERAL_ERROR, 'Could not update user to ADR unbanage', "", __LINE__, __FILE__, $sql);
			}

			// Send PM to user to notify
			$subject = $lang['Adr_global_shout_unban_pm'];
			adr_send_pm($user_id, $subject, $reason);

			$error_messages = sprintf($lang['Adr_global_shout_unban_yes'], $user_infos['username']);
		}
		else
		{
			$error_messages = sprintf($lang['Adr_global_shout_unban_already'], $user_infos['username']);
		}
	}
	else
	{
		$error_messages = sprintf($lang['Adr_global_shout_incorrect_user'], $username);
	}

return $error_messages;
}
?>
