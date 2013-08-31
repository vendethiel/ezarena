<?php 
/***************************************************************************
 *				rabbitoshi_progress.php
 *				------------------------
 *	begin 			: 05/01/2005
 *	copyright			: One_piece
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

define('IN_PHPBB', true); 
define('IN_RABBITOSHI', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true); 
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);


//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_RABBITOSHI); 
init_userprefs($userdata); 
// End session management
//
$user_id = $userdata['user_id'];
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_rabbitoshi.'.$phpEx);

// Get the general settings
$adr_general = adr_get_general_config();
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

// Deny access if the user is into a battle
	$sql = "SELECT * 
			FROM  ". ADR_BATTLE_LIST_TABLE ." 
			WHERE battle_challenger_id = '$user_id'
			AND battle_result = '0'
			AND battle_type = '1'";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	
	$bat = $db->sql_fetchrow($result);
	
	if (is_numeric($bat['battle_id']))
		adr_previous( Adr_battle_progress , adr_battle , '' );

include($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/lang_adr.'.$phpEx);

if ( !$userdata['session_logged_in'] )
{
	$redirect = "rabbitoshi.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
$template->set_filenames(array(
	'body' => 'rabbitoshi_progress_body.tpl')
);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$board_config['points_name'] = $board_config['points_name'] ? $board_config['points_name'] : $lang['Rabbitoshi_default_points_name'] ;

$user_id = $userdata['user_id'];
if ( empty($HTTP_GET_VARS[POST_USERS_URL])) 
{ 
	$view_userdata = $userdata; 
} 
else 
{ 
	$view_userdata = get_userdata($HTTP_GET_VARS[POST_USERS_URL]); 
} 
$searchid = $view_userdata['user_id'];
$points = $userdata['user_points'];

$sql = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE . " 
WHERE owner_id = ".$view_userdata['user_id'];	
if (!$result = $db->sql_query($sql)) 
{
	message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
}
$rabbit_user = $db->sql_fetchrow($result);

$sql = "SELECT * FROM  " . RABBITOSHI_GENERAL_TABLE ; 
if (!$result = $db->sql_query($sql)) 
{
	message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
}
while( $row = $db->sql_fetchrow($result) )
{
	$rabbit_general[$row['config_name']] = $row['config_value'];
}

//number of points raised
$health_raise = $rabbit_general['health_raise'];
$hunger_raise = $rabbit_general['hunger_raise'];
$thirst_raise = $rabbit_general['thirst_raise'];
$hygiene_raise = $rabbit_general['hygiene_raise'];
$level_raise = $rabbit_general['level_raise'];
$power_raise = $rabbit_general['power_raise'];
$magicpower_raise = $rabbit_general['magicpower_raise'];
$armor_raise = $rabbit_general['armor_raise'];
$attack_raise = $rabbit_general['attack_raise'];
$magicattack_raise = $rabbit_general['magicattack_raise'];
$mp_raise = $rabbit_general['mp_raise'];
$health_levelup = $rabbit_general['health_levelup'];
$hunger_levelup = $rabbit_general['hunger_levelup'];
$thirst_levelup = $rabbit_general['thirst_levelup'];
$hygiene_levelup = $rabbit_general['hygiene_levelup'];
$power_levelup = $rabbit_general['power_levelup'];
$magicpower_levelup = $rabbit_general['magicpower_levelup'];
$armor_levelup = $rabbit_general['armor_levelup'];
$attack_levelup = $rabbit_general['attack_levelup'];
$magicattack_levelup = $rabbit_general['magicattack_levelup'];
$mp_levelup = $rabbit_general['mp_levelup'];

//stats proce
$health_price = $rabbit_general['health_price'];
$hunger_price = $rabbit_general['hunger_price'];
$thirst_price = $rabbit_general['thirst_price'];
$hygiene_price = $rabbit_general['hygiene_price'];
$level_price = $rabbit_general['level_price'];
$power_price = $rabbit_general['power_price'];
$magicpower_price = $rabbit_general['magicpower_price'];
$armor_price = $rabbit_general['armor_price'];
$attack_max_price = $rabbit_general['attack_price'];
$magicattack_price = $rabbit_general['magicattack_price'];
$mp_price = $rabbit_general['mp_price'];
$attack_reload_price = $rabbit_general['attack_reload'];
$magic_reload_price = $rabbit_general['magic_reload'];

//experience needed
$price_health = ($rabbit_user['creature_experience'] - $health_price);
$price_hunger = ($rabbit_user['creature_experience'] - $hunger_price);
$price_thirst = ($rabbit_user['creature_experience'] - $thirst_price);
$price_hygiene = ($rabbit_user['creature_experience'] - $hygiene_price);
$price_level = ($rabbit_user['creature_experience'] - $level_price);
$price_power = ($rabbit_user['creature_experience'] - $power_price);
$price_magicpower = ($rabbit_user['creature_experience'] - $magicpower_price);
$price_armor = ($rabbit_user['creature_experience'] - $armor_price);
$price_attack = ($rabbit_user['creature_experience'] - $attack_max_price);
$price_magicattack = ($rabbit_user['creature_experience'] - $magicattack_price);
$price_mp = ($rabbit_user['creature_experience'] - $mp_price);
$attack_lack = ( $rabbit_user['creature_attack_max'] - $rabbit_user['creature_attack']);
$magic_lack = ( $rabbit_user['creature_magicattack_max'] - $rabbit_user['creature_magicattack']);
$attack_price = ($attack_lack * $attack_reload_price);
$magic_price = ($magic_lack * $magic_reload_price);

//Special attacks restrictions
$regeneration_level = $rabbit_general['regeneration_level'];
$regeneration_magicpower = $rabbit_general['regeneration_magicpower'];
$regeneration_mp = $rabbit_general['regeneration_mp'];
$regeneration_price = $rabbit_general['regeneration_price'];
$health_transfert_level = $rabbit_general['health_transfert_level'];
$health_transfert_magicpower = $rabbit_general['health_transfert_magicpower'];
$health_transfert_health = $rabbit_general['health_transfert_health'];
$health_transfert_percent = $rabbit_general['health_transfert_percent'];
$health_transfert_price = $rabbit_general['health_transfert_price'];
$mana_transfert_level = $rabbit_general['mana_transfert_level'];
$mana_transfert_magicpower = $rabbit_general['mana_transfert_magicpower'];
$mana_transfert_mp = $rabbit_general['mana_transfert_mp'];
$mana_transfert_percent = $rabbit_general['mana_transfert_percent'];
$mana_transfert_price = $rabbit_general['mana_transfert_price'];
$sacrifice_level = $rabbit_general['sacrifice_level'];
$sacrifice_power = $rabbit_general['sacrifice_power'];
$sacrifice_armor = $rabbit_general['sacrifice_armor'];
$sacrifice_mp = $rabbit_general['sacrifice_mp'];
$sacrifice_price = $rabbit_general['sacrifice_price'];

//submit buttons
$health_action = isset($HTTP_POST_VARS['health_action']);
$hunger_action = isset($HTTP_POST_VARS['hunger_action']);
$thirst_action = isset($HTTP_POST_VARS['thirst_action']);
$hygiene_action = isset($HTTP_POST_VARS['hygiene_action']);
$level_action = isset($HTTP_POST_VARS['level_action']);
$power_action = isset($HTTP_POST_VARS['power_action']);
$magicpower_action = isset($HTTP_POST_VARS['magicpower_action']);
$armor_action = isset($HTTP_POST_VARS['armor_action']);
$attack_action = isset($HTTP_POST_VARS['attack_action']);
$magicattack_action = isset($HTTP_POST_VARS['magicattack_action']);
$mp_action = isset($HTTP_POST_VARS['mp_action']);
$attack_reload = isset($HTTP_POST_VARS['attack_reload']);
$magic_reload = isset($HTTP_POST_VARS['magic_reload']);
$regeneration_ability = isset($HTTP_POST_VARS['regeneration_ability']);
$health_ability = isset($HTTP_POST_VARS['health_ability']);
$mana_ability = isset($HTTP_POST_VARS['mana_ability']);
$sacrifice_ability = isset($HTTP_POST_VARS['sacrifice_ability']);


if ( $board_config['rabbitoshi_enable'] && $searchid == $user_id ) 
{

	if ( $regeneration_ability )
	{
		if ($rabbit_user['creature_experience'] < $regeneration_price)
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_ability_price_lack']);
		}
		else
		{
		if ( ($rabbit_user['creature_level'] > $regeneration_level) && ($rabbit_user['creature_magicpower'] > $regeneration_magicpower) && ($rabbit_user['creature_max_mp'] > $regeneration_mp) )
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_ability = '1',
			creature_experience = creature_experience - $regeneration_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_ability_stats_lack']);
		}
		}
	}

	if ( $health_ability )
	{
		if ($rabbit_user['creature_experience'] < $health_transfert_price)
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_ability_price_lack']);
		}
		else
		{
		if ( ($rabbit_user['creature_level'] > $health_transfert_level) && ($rabbit_user['creature_magicpower'] > $health_transfert_magicpower) && ($rabbit_user['creature_health_max'] > $health_transfert_health) )
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_ability = '2',
			creature_experience = creature_experience - $health_transfert_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_ability_stats_lack']);
		}
		}
	}

	if ( $mana_ability )
	{
		if ($rabbit_user['creature_experience'] < $mana_transfert_price)
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_ability_price_lack']);
		}
		else
		{
		if ( ($rabbit_user['creature_level'] > $mana_transfert_level) && ($rabbit_user['creature_magicpower'] > $mana_transfert_magicpower) && ($rabbit_user['creature_max_mp'] > $mana_transfert_mp) )
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_ability = '3',
			creature_experience = creature_experience - $mana_transfert_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_ability_stats_lack']);
		}
		}
	}

	if ( $sacrifice_ability )
	{
		if ($rabbit_user['creature_experience'] < $sacrifice_price)
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_ability_price_lack']);
		}
		else
		{
		if ( ($rabbit_user['creature_level'] > $sacrifice_level) && ($rabbit_user['creature_power'] > $sacrifice_power) && ($rabbit_user['creature_max_mp'] > $sacrifice_mp) && ($rabbit_user['creature_armor'] > $sacrifice_armor) )
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_ability = '4',
			creature_experience = creature_experience - $sacrifice_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_ability_stats_lack']);
		}
		}
	}

	if ( $attack_reload )
	{
		if ($rabbit_user['creature_experience'] < $attack_price)
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_attack = creature_attack_max,
			creature_experience = creature_experience - $attack_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

	if ( $magic_reload )
	{
		if ($rabbit_user['creature_experience'] < $magic_price)
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_magicattack = creature_magicattack_max,
			creature_experience = creature_experience - $magic_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

	if ( $health_action )
	{
		if ($price_health < '0')
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_health_max = creature_health_max + $health_raise,
			creature_experience = creature_experience - $health_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

	if ( $hunger_action )
	{
		if ($price_hunger < '0')
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_hunger_max = creature_hunger_max + $hunger_raise,
			creature_experience = creature_experience - $hunger_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

	if ( $thirst_action )
	{
		if ($price_thirst < '0')
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_thirst_max = creature_thirst_max + $thirst_raise,
			creature_experience = creature_experience - $thirst_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

	if ( $hygiene_action )
	{
		if ($price_hygiene < '0')
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_hygiene_max = creature_hygiene_max + $hygiene_raise,
			creature_experience = creature_experience - $hygiene_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

	if ( $level_action )
	{
	If ( $rabbit_user['creature_experience_level'] == $rabbit_user['creature_experience_level_limit'] )
	{
		if ($price_level < '0')
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_level = creature_level + $level_raise,
			creature_experience = creature_experience - $level_price,
			creature_health_max = creature_health_max + $health_levelup,
			creature_hunger_max = creature_hunger_max + $hunger_levelup,
			creature_thirst_max = creature_thirst_max + $thirst_levelup,
			creature_hygiene_max = creature_hygiene_max + $hygiene_levelup,
			creature_power = creature_power + $power_levelup,
			creature_magicpower = creature_magicpower + $magicpower_levelup,
			creature_armor = creature_armor + $armor_levelup,
			creature_max_mp = creature_max_mp + $mp_levelup,
			creature_attack_max = creature_attack_max + $attack_levelup,
			creature_magicattack_max = creature_magicattack_max + $magicattack_levelup,
			creature_experience_level = 0
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}
	else
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experiencelimit_lack']);
		}
	}

	if ( $power_action )
	{
		if ($price_power < '0')
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_power = creature_power + $power_raise,
			creature_experience = creature_experience - $power_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

	if ( $magicpower_action )
	{
		if ($price_magicpower < '0')
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_magicpower = creature_magicpower + $magicpower_raise,
			creature_experience = creature_experience - $magicpower_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

	if ( $armor_action )
	{
		if ($price_armor < '0')
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_armor = creature_armor + $armor_raise,
			creature_experience = creature_experience - $armor_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

      if ( $attack_action )
      {
         if ($price_attack < '0')
         {
            message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
         }
         else
         {
         $sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
            SET creature_attack_max = creature_attack_max + $attack_raise,
            creature_experience = creature_experience - $attack_max_price
            WHERE owner_id = $user_id ";
         if (!$result = $db->sql_query($sql))
         {
            message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
         }
            message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
         }
      } 

	if ( $magicattack_action )
	{
		if ($price_magicattack < '0')
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_magicattack_max = creature_magicattack_max + $magicattack_raise,
			creature_experience = creature_experience - $magicattack_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

	if ( $mp_action )
	{
		if ($price_mp < '0')
		{
			message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_experience_lack']);
		}
		else
		{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_max_mp = creature_max_mp + $mp_raise,
			creature_experience = creature_experience - $mp_price
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users stats!');
		}
	      message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_progress_ok']);
		}
	}

}

$template->assign_vars(array(
	'ABILITY_HEALTH_PRICE' 	 => $rabbit_general['health_transfert_price'],
	'ABILITY_SACRIFICE_PRICE'=> $rabbit_general['sacrifice_price'],
	'ABILITY_MANA_PRICE' 	 => $rabbit_general['mana_transfert_price'],
	'ABILITY_REGENERATION_PRICE'=> $rabbit_general['regeneration_price'],
	'HEALTH_RAISE' 		 => $rabbit_general['health_raise'],
	'HUNGER_RAISE' 		 => $rabbit_general['hunger_raise'],
	'THIRST_RAISE' 		 => $rabbit_general['thirst_raise'],
	'HYGIENE_RAISE' 		 => $rabbit_general['hygiene_raise'],
	'LEVEL_RAISE' 		 => $rabbit_general['level_raise'],
	'POWER_RAISE' 		 => $rabbit_general['power_raise'],
	'MAGICPOWER_RAISE' 	 => $rabbit_general['magicpower_raise'],
	'ARMOR_RAISE' 		 => $rabbit_general['armor_raise'],
	'MP_RAISE' 			 => $rabbit_general['mp_raise'],
	'ATTACK_RAISE' 		 => $rabbit_general['attack_raise'],
	'MAGICATTACK_RAISE' 	 => $rabbit_general['magicattack_raise'],
	'HEALTH_PRICE' 		 => $rabbit_general['health_price'],
	'HUNGER_PRICE' 		 => $rabbit_general['hunger_price'],
	'THIRST_PRICE' 		 => $rabbit_general['thirst_price'],
	'HYGIENE_PRICE' 	 	 => $rabbit_general['hygiene_price'],
	'LEVEL_PRICE' 		 => $rabbit_general['level_price'],
	'POWER_PRICE' 		 => $rabbit_general['power_price'],
	'MAGICPOWER_PRICE' 	 => $rabbit_general['magicpower_price'],
	'ARMOR_PRICE' 		 => $rabbit_general['armor_price'],
	'MP_PRICE' 			 => $rabbit_general['mp_price'],
	'ATTACK_PRICE' 		 => $rabbit_general['attack_price'],
	'MAGICATTACK_PRICE' 	 => $rabbit_general['magicattack_price'],
	'ATTACK_RELOAD_PRICE' 	 => $attack_price,
	'MAGIC_RELOAD_PRICE' 	 => $magic_price,
      'L_PUBLIC_TITLE'       => $lang['Rabbitoshi_pet_progress'],
	'L_RETURN' 			 => $lang['Rabbitoshi_shop_return'],
	'L_PET_EXPERIENCE' => $lang['Rabbitoshi_pet_experience'],
	'L_EXPERIENCE'     => $lang['Rabbitoshi_experience_name'],
	'L_NAME' 		 => $lang['Rabbitoshi_progress_name'],
	'L_ABILITY_NAME' 	 => $lang['Rabbitoshi_ability_name'],
	'L_EXPLAIN' 	 => $lang['Rabbitoshi_progress_explain'],
	'L_ABILITY_EXPLAIN'=> $lang['Rabbitoshi_ability_explain'],
	'L_NUMBER_RAISE' 	 => $lang['Rabbitoshi_progress_number'],
	'L_PRICE' 		 => $lang['Rabbitoshi_progress_price'],
	'L_ABILITY_PRICE'  => $lang['Rabbitoshi_ability_price'],
	'L_SUBMIT' 	 	 => $lang['Rabbitoshi_progress_submit'],
	'L_ABILITY_SUBMIT' => $lang['Rabbitoshi_ability_submit'],
	'L_ABILITY_SUBMIT_TITLE' => $lang['Rabbitoshi_ability_submit_title'],
	'L_RELOAD' 	 	 => $lang['Rabbitoshi_progress_reload'],
	'L_SUBMIT_TITLE' 	 => $lang['Rabbitoshi_progress_submit_title'],
	'L_HEALTH' 		 => $lang['Rabbitoshi_owner_pet_health'],
	'L_HUNGER' 		 => $lang['Rabbitoshi_owner_pet_hunger'],
	'L_THIRST' 		 => $lang['Rabbitoshi_owner_pet_thirst'],
	'L_HYGIENE' 	 => $lang['Rabbitoshi_owner_pet_hygiene'],
	'L_LEVEL' 		 => $lang['Rabbitoshi_owner_pet_level'],
	'L_POWER' 		 => $lang['Rabbitoshi_owner_pet_power'],
	'L_MAGICPOWER' 	 => $lang['Rabbitoshi_owner_pet_magicpower'],
	'L_ARMOR' 		 => $lang['Rabbitoshi_owner_pet_armor'],
	'L_MP' 		 => $lang['Rabbitoshi_owner_pet_mpmax'],
	'L_ATTACK' 		 => $lang['Rabbitoshi_owner_pet_attack'],
	'L_ATTACK_RELOAD'  => $lang['Rabbitoshi_owner_pet_attack_reload'],
	'L_MAGIC_RELOAD'   => $lang['Rabbitoshi_owner_pet_magic_reload'],
	'L_MAGICATTACK' 	 => $lang['Rabbitoshi_owner_pet_magicattack'],
	'L_HEALTH_EXPLAIN'  => $lang['Rabbitoshi_owner_pet_health_explain'],
	'L_HUNGER_EXPLAIN'  => $lang['Rabbitoshi_owner_pet_hunger_explain'],
	'L_THIRST_EXPLAIN'  => $lang['Rabbitoshi_owner_pet_thirst_explain'],
	'L_HYGIENE_EXPLAIN' => $lang['Rabbitoshi_owner_pet_hygiene_explain'],
	'L_LEVEL_EXPLAIN'   => $lang['Rabbitoshi_owner_pet_level_explain'],
	'L_POWER_EXPLAIN'   => $lang['Rabbitoshi_owner_pet_power_explain'],
	'L_MAGICPOWER_EXPLAIN' 	=> $lang['Rabbitoshi_owner_pet_magicpower_explain'],
	'L_ARMOR_EXPLAIN'   => $lang['Rabbitoshi_owner_pet_armor_explain'],
	'L_MP_EXPLAIN' 	  => $lang['Rabbitoshi_owner_pet_mpmax_explain'],
	'L_ATTACK_EXPLAIN'  => $lang['Rabbitoshi_owner_pet_attack_explain'],
	'L_MAGICATTACK_EXPLAIN'  => $lang['Rabbitoshi_owner_pet_magicattack_explain'],
	'L_ABILITY_REGENERATION' => $lang['Rabbitoshi_ability_regeneration'],
	'L_ABILITY_REGENERATION_EXPLAIN' => $lang['Rabbitoshi_ability_regeneration_explain'],
	'L_ABILITY_HEALTH' => $lang['Rabbitoshi_ability_health'],
	'L_ABILITY_HEALTH_EXPLAIN' => $lang['Rabbitoshi_ability_health_explain'],
	'L_ABILITY_MANA' => $lang['Rabbitoshi_ability_mana'],
	'L_ABILITY_MANA_EXPLAIN' => $lang['Rabbitoshi_ability_mana_explain'],
	'L_ABILITY_SACRIFICE' => $lang['Rabbitoshi_ability_sacrifice'],
	'L_ABILITY_SACRIFICE_EXPLAIN' => $lang['Rabbitoshi_ability_sacrifice_explain'],
	'L_TRANSLATOR'     => $lang['Rabbitoshi_translation'],
	'POINTS'           => $rabbit_user['creature_experience'],
	'S_PET_ACTION'     => append_sid("rabbitoshi_progress.$phpEx"),
	'S_PET_RETURN'     => append_sid("rabbitoshi.$phpEx"),
	'S_HIDDEN_FIELDS'	 => $s_hidden_fields,
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 