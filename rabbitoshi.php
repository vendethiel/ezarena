<?php 
/***************************************************************************
 *					rabbitoshi.php
 *				------------------------
 *	begin 			: 18/10/2003
 *	copyright			: One_Piece & Dr DLP
 *
 *	version			: 2.0.0
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
include($phpbb_root_path . 'includes/functions_rabbitoshi.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
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

$Creature_name = $HTTP_POST_VARS['Creaturename'];
$Buypet = $HTTP_POST_VARS['Buypet'];
$Petbuyed = $HTTP_POST_VARS['petbuyed'];
$Vet = $HTTP_POST_VARS['Vet'];
$Feed = $HTTP_POST_VARS['Feed'];
$Shop = $HTTP_POST_VARS['Shop'];
$Drink = $HTTP_POST_VARS['Drink'];
$Clean = $HTTP_POST_VARS['Clean'];
$Owner_list = $HTTP_POST_VARS['Owner_list'];
$Hotel = $HTTP_POST_VARS['Hotel'];
$Hotel_out = $HTTP_POST_VARS['Hotel_out'];
$Hotel_in = $HTTP_POST_VARS['Hotel_in'];
$Evolution = $HTTP_POST_VARS['Evolution'];
$Evolution_exec = $HTTP_POST_VARS['Evolution_exec'];
$Evolution_pet = intval($HTTP_POST_VARS['evolution_pet']);
$resurrect_ok = $HTTP_POST_VARS['resurrect_ok'];
$resurrect_no = $HTTP_POST_VARS['resurrect_no'];
$Sellpet = $HTTP_POST_VARS['Sellpet'];
$confirm_sell = $HTTP_POST_VARS['confirm_sell'];
$prefs = $HTTP_POST_VARS['prefs'];
$prefs_exec = $HTTP_POST_VARS['prefs_exec'];

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

if(isset($HTTP_POST_VARS['from']))
{
	$Owner_list = ($HTTP_POST_VARS['from'] == 'list') ? TRUE : FALSE;
}
else if(isset($HTTP_GET_VARS['from']))
{
	$Owner_list = ($HTTP_GET_VARS['from'] == 'list') ? TRUE : FALSE;
}

if ( !$userdata['session_logged_in'] )
{
	$redirect = "rabbitoshi.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
$template->set_filenames(array(
	'body' => 'rabbitoshi_body.tpl')
);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$board_config['points_name'] = $board_config['points_name'] ? $board_config['points_name'] : $lang['Rabbitoshi_default_points_name'] ;

$user_id = $userdata['user_id'];
if (!( isset($HTTP_POST_VARS[POST_USERS_URL]) || isset($HTTP_GET_VARS[POST_USERS_URL]) ))
{ 
	$view_userdata = $userdata; 
} 
else 
{ 
	$view_userdata = get_userdata(intval($HTTP_GET_VARS[POST_USERS_URL])); 
} 
$searchid = $view_userdata['user_id'];
$points = $userdata['user_points'];

if ( !$board_config['rabbitoshi_enable'])
{
	message_die( GENERAL_MESSAGE,sprintf($lang['Rabbitoshi_disable']) );
}

$sql = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE . "  WHERE owner_id='$searchid'";
if ( !($result = $db->sql_query($sql)) ) 
{ 
	message_die(CRITICAL_ERROR, 'Error Getting Rabbitoshi Users!'); 
}
$row = $db->sql_fetchrow($result);

if ( $board_config['rabbitoshi_enable'] && (!(is_numeric($row['owner_creature_id'])) && $searchid != $user_id )) 
{
	message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
}


if ( $board_config['rabbitoshi_enable'] && (!(is_numeric($row['owner_creature_id'])) && $searchid == $user_id )) 
{
	$rabbit = get_rabbitoshi_config('');
	$template->assign_block_vars( 'nopet' , array());

	for($i = 0; $i < count($rabbit); $i++)
	{
		$creature_name = isset($lang[$rabbit[$i]['creature_name']]) ? $lang[$rabbit[$i]['creature_name']] : $rabbit[$i]['creature_name'];

		$pic = $rabbit[$i]['creature_img'];
		if (!(file_exists("images/Rabbitoshi/$pic")) || !$pic )
		{
			$pic = $rabbit[$i]['creature_name'].'.gif';
		}

		$template->assign_block_vars('nopet.pets',array(
		'RABBIT_NOPET_NAME' => $creature_name,
		'RABBIT_NOPET_IMG' => $pic,
		'RABBIT_NOPET_ID' => $rabbit[$i]['creature_id'],
		'RABBIT_NOPET_PRIZE' => $rabbit[$i]['creature_prize'],
		'RABBIT_NOPET_HUNGER' => $rabbit[$i]['creature_max_hunger'],
		'RABBIT_NOPET_THIRST' => $rabbit[$i]['creature_max_thirst'],
		'RABBIT_NOPET_HYGIENE' => $rabbit[$i]['creature_max_hygiene'],
		'RABBIT_NOPET_HEALTH' => $rabbit[$i]['creature_max_health'],
		'RABBIT_NOPET_POWER' => $rabbit[$i]['creature_power'],
		'RABBIT_NOPET_MAGICPOWER' => $rabbit[$i]['creature_magicpower'],
		'RABBIT_NOPET_ARMOR' => $rabbit[$i]['creature_armor'],
		'RABBIT_NOPET_MP' => $rabbit[$i]['creature_mp_max'],
		));
	}

	if ($Buypet)
	{
		if (( empty ($Petbuyed)) || (empty ( $Creature_name )))
		{
			message_die(GENERAL_ERROR, 'Vous devez choisir une créature avant de continuer !');
		}

		$sql = "SELECT * FROM  " . RABBITOSHI_CONFIG_TABLE . " WHERE creature_id = '$Petbuyed'";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi Config!');
		}
		$row = $db->sql_fetchrow($result);

		$power = $row['creature_power'];
		$avatar = $row['creature_img'];
		$magicpower = $row['creature_magicpower'];
		$armor = $row['creature_armor'];
		$hunger = $row['creature_max_hunger'];
		$hungermax = $row['creature_max_hunger'];
		$thirst = $row['creature_max_thirst'];
		$thirstmax = $row['creature_max_thirst'];
		$health = $row['creature_max_health'];
		$healthmax = $row['creature_max_health'];
		$mp = $row['creature_mp_max'];
		$mpmax = $row['creature_mp_max'];
		$attack = $row['creature_max_attack'];
		$attackmax = $row['creature_max_attack'];
		$magic = $row['creature_max_magicattack'];
		$magicmax = $row['creature_max_magicattack'];
		$hygiene = $row['creature_max_hygiene'];
		$hygienemax = $row['creature_max_hygiene'];
		$experience_level = $row['creature_experience_max'];
		$prize = $row['creature_prize'];
		$points = $userdata['user_points'];


		if ( $points < $prize )
		{
			message_die(GENERAL_ERROR, "Vous n'avez pas assez d'argent pour acheter cette créature !");
		}

		$sql = "INSERT INTO " . RABBITOSHI_USERS_TABLE . " (owner_id, owner_last_visit, owner_creature_id, owner_creature_name, creature_power, creature_magicpower, creature_armor, creature_hunger, creature_hunger_max, creature_thirst, creature_thirst_max, creature_health, creature_health_max, creature_mp, creature_max_mp, creature_hygiene, creature_hygiene_max, creature_age, creature_avatar, creature_experience_level_limit, creature_attack, creature_attack_max, creature_magicattack, creature_magicattack_max)                       
		VALUES ($user_id, ".time().", $Petbuyed, '$Creature_name', $power, $magicpower, $armor, $hunger, $hungermax, $thirst, $thirstmax, $health, $healthmax, $mp, $mpmax, $hygiene, $hygienemax, ".time().", '$avatar', $experience_level, $attack, $attackmax, $magic, $magicmax) ";
		if ( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
		{
			message_die(GENERAL_ERROR, 'Could not insert data into rabbitoshi users table', '', __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . USERS_TABLE . "
		SET user_points = user_points - $prize
		WHERE user_id = $user_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update user's points", '', __LINE__, __FILE__, $sql);
		}
		message_die( GENERAL_MESSAGE,sprintf($lang['Rabbitoshi_buypet_success']) );

	} 
}
else
{
	$rabbit_user = rabbitoshi_get_user_stats($view_userdata['user_id']);

	if ( $rabbit_user['owner_hide'] && $rabbit_user['owner_id'] != $user_id && $userdata['user_level'] != ADMIN )
	{
		message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_hidden'] );
	}

	$sql = "SELECT * FROM  " . RABBITOSHI_GENERAL_TABLE ; 
	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		$rabbit_general[$row['config_name']] = $row['config_value'];
	}

	list($is_in_hotel , $hotel_time) = rabbitoshi_get_hotel();
	if ( $is_in_hotel && ( $Vet || $Feed || $Drink || $Clean ))
	{
		message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_hotel_no_actions'].$lang['Rabbitoshi_general_return'] );
	}
	
	if ($Vet)
	{
		if ( $rabbit_general['vet_enable'] )
		{
			if ( $points > $rabbit_general['vet_price'] )
			{

				$sql = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE . " WHERE owner_id = ".$view_userdata['user_id'];
				if (!$result = $db->sql_query($sql)) 
				{
					message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi user!');
				}
				$row = $db->sql_fetchrow($result);
				$health = $rabbit_user['creature_health_max'];
				$mp = $rabbit_user['creature_max_mp'];

				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
				SET   creature_health = $health,
				      creature_mp = $mp,
					creature_statut = 0
				WHERE owner_id = ".$view_userdata['user_id'];
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not update creature stat", '', __LINE__, __FILE__, $sql);
				}
				$prize = $rabbit_general['vet_price'];
				$sql = "UPDATE " . USERS_TABLE . "
				SET user_points = user_points - $prize
				WHERE user_id = $user_id";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, "Could not update user's points", '', __LINE__, __FILE__, $sql);
				}
	
				message_die( GENERAL_MESSAGE, $lang['Rabbitoshi_pet_vet'].$lang['Rabbitoshi_general_return'] );
			}
			else
			{
				message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_pet_vet_lack'].$lang['Rabbitoshi_general_return'] );
			}
		}
		else
		{
				message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_vet_holidays'].$lang['Rabbitoshi_general_return'] );
		}
	}
	if ($Feed)
	{
		$rabbit_stats = get_rabbitoshi_config($rabbit_user['owner_creature_id']);
		$sql = "SELECT u.* , s.* 
			FROM  " . RABBITOSHI_SHOP_USERS_TABLE . " u , " . RABBITOSHI_SHOP_TABLE . " s
			WHERE u.item_id = s.item_id
			AND s.item_type = 1
			AND u.user_id = $user_id
			AND u.item_amount > 0
			ORDER BY s.item_power ASC";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi Config!');
		}
		$food = $db->sql_fetchrowset($result);
		$food_needed = $rabbit_user['creature_hunger_max'] - $rabbit_user['creature_hunger'];
		$given_food = 0;

		if ( $food_needed < 1 )
		{
			message_die(GENERAL_ERROR, $lang['Rabbitoshi_food_no_need'].$lang['Rabbitoshi_general_return'] );
		}
		else if ( $food[0]['item_amount'] < 1 )
		{
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_lack_food'].$lang['Rabbitoshi_general_return'] );
		}
		if ( !$rabbit_user['owner_feed_full'])
		{
			$power = $food[0]['item_power'];
			if ( $power > $food_needed )
			{
				$power = $food_needed ;
			}
			$sql = "UPDATE " . RABBITOSHI_SHOP_USERS_TABLE . " 
				SET item_amount = item_amount - 1
				WHERE user_id = $user_id
				AND item_id = ".$food[0]['item_id'];
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users items!');
			}
			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
				SET creature_hunger = creature_hunger + $power 
				WHERE owner_id = $user_id ";
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users items!');
			}					
		}
		else if ( count($food) > 0 )
		{
			$buckle_end = FALSE ;
			for ( $w = 0 ; $w < count($food) ; $w ++ )
			{
				if ( !$buckle_end)
				{
					for ( $wa = 0 ; $wa < $food[$w]['item_amount']; $wa ++ )
					{
						if ( !$buckle_end)
						{
							if (  $food[$w]['item_id'] == $rabbit_stats['creature_food_id'] )
							{
								$food[$w]['item_power'] = ( $food[$w]['item_power'] * 2 );
							}
							$given_food = $given_food + $food[$w]['item_power'];
							if ( $given_food > $food_needed )
							{
								$given_food = $food_needed ;
								$buckle_end = TRUE ;
							}
							$item_id = $food[$w]['item_id'] ;
							$ssql = "UPDATE " . RABBITOSHI_SHOP_USERS_TABLE . " 
								SET item_amount = item_amount - 1
								WHERE user_id = $user_id
								AND item_id = ".$item_id;
							if (!$sresult = $db->sql_query($ssql)) 
							{
								message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users items!');
							}							
						}
					}
				}
			}
			$usql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
				SET creature_hunger = creature_hunger + $given_food
				WHERE owner_id = ".$user_id ;
			if (!$uresult = $db->sql_query($usql)) 
			{
				message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users !');
			}
		}
	}
	if ($Drink)
	{		
		$rabbit_stats = get_rabbitoshi_config($rabbit_user['owner_creature_id']);
		$sql = "SELECT u.* , s.* 
			FROM  " . RABBITOSHI_SHOP_USERS_TABLE . " u , " . RABBITOSHI_SHOP_TABLE . " s
			WHERE u.item_id = s.item_id
			AND s.item_type = 2
			AND u.user_id = $user_id
			AND u.item_amount > 0
			ORDER BY s.item_power ASC";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi Config!');
		}
		$water = $db->sql_fetchrowset($result);
		$water_needed = $rabbit_user['creature_thirst_max'] - $rabbit_user['creature_thirst'];
		$given_water = 0;

		if ( $water_needed < 1 )
		{
			message_die(GENERAL_ERROR, $lang['Rabbitoshi_water_no_need'].$lang['Rabbitoshi_general_return'] );
		}
		else if ( $water[0]['item_amount'] < 1 )
		{
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_lack_water'].$lang['Rabbitoshi_general_return'] );
		}
		if ( !$rabbit_user['owner_drink_full'])
		{
			$power = $water[0]['item_power'];
			if ( $power > $water_needed )
			{
				$power = $water_needed ;
			}
			$sql = "UPDATE " . RABBITOSHI_SHOP_USERS_TABLE . " 
				SET item_amount = item_amount - 1
				WHERE user_id = $user_id
				AND item_id = ".$water[0]['item_id'];
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users items!');
			}
			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
				SET creature_thirst = creature_thirst + $power 
				WHERE owner_id = $user_id ";
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users items!');
			}					
		}
		else if ( count($water) > 0 )
		{
			$buckle_end = FALSE ;
			for ( $w = 0 ; $w < count($water) ; $w ++ )
			{
				if ( !$buckle_end)
				{
					for ( $wa = 0 ; $wa < $water[$w]['item_amount']; $wa ++ )
					{
						if ( !$buckle_end)
						{
							$given_water = $given_water + $water[$w]['item_power'];
							if ( $given_water > $water_needed )
							{
								$given_water = $water_needed ;
								$buckle_end = TRUE ;
							}
							$item_id = $water[$w]['item_id'] ;
							$ssql = "UPDATE " . RABBITOSHI_SHOP_USERS_TABLE . " 
								SET item_amount = item_amount - 1
								WHERE user_id = $user_id
								AND item_id = ".$item_id;
							if (!$sresult = $db->sql_query($ssql)) 
							{
								message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users items!');
							}							
						}
					}
				}
			}
			$usql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
				SET creature_thirst = creature_thirst + $given_water
				WHERE owner_id = ".$user_id ;
			if (!$uresult = $db->sql_query($usql)) 
			{
				message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users !');
			}
		}
	}
	if ($Clean)
	{
		$rabbit_stats = get_rabbitoshi_config($rabbit_user['owner_creature_id']);
		$sql = "SELECT u.* , s.* 
			FROM  " . RABBITOSHI_SHOP_USERS_TABLE . " u , " . RABBITOSHI_SHOP_TABLE . " s
			WHERE u.item_id = s.item_id
			AND s.item_type = 3
			AND u.user_id = $user_id
			AND u.item_amount > 0
			ORDER BY s.item_power ASC";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi Config!');
		}
		$hygiene = $db->sql_fetchrowset($result);
		$hygiene_needed = $rabbit_user['creature_hygiene_max'] - $rabbit_user['creature_hygiene'];
		$given_hygiene = 0;

		if ( $hygiene_needed < 1 )
		{
			message_die(GENERAL_ERROR, $lang['Rabbitoshi_clean_no_need'].$lang['Rabbitoshi_general_return'] );
		}
		else if ( $hygiene[0]['item_amount'] < 1 )
		{
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_lack_cleaner'].$lang['Rabbitoshi_general_return'] );
		}
		if ( !$rabbit_user['owner_clean_full'])
		{
			$power = $hygiene[0]['item_power'];
			if ( $power > $hygiene_needed )
			{
				$power = $hygiene_needed ;
			}
			$sql = "UPDATE " . RABBITOSHI_SHOP_USERS_TABLE . " 
				SET item_amount = item_amount - 1
				WHERE user_id = $user_id
				AND item_id = ".$hygiene[0]['item_id'];
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users items!');
			}
			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
				SET creature_hygiene = creature_hygiene + $power 
				WHERE owner_id = $user_id ";
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users items!');
			}					
		}
		else if ( count($hygiene) > 0 )
		{
			$buckle_end = FALSE ;
			for ( $w = 0 ; $w < count($hygiene) ; $w ++ )
			{
				if ( !$buckle_end)
				{
					for ( $wa = 0 ; $wa < $hygiene[$w]['item_amount']; $wa ++ )
					{
						if ( !$buckle_end)
						{
							$given_hygiene = $given_hygiene + $hygiene[$w]['item_power'];
							if ( $given_hygiene > $hygiene_needed )
							{
								$given_hygiene = $hygiene_needed ;
								$buckle_end = TRUE ;
							}
							$item_id = $hygiene[$w]['item_id'] ;
							$ssql = "UPDATE " . RABBITOSHI_SHOP_USERS_TABLE . " 
								SET item_amount = item_amount - 1
								WHERE user_id = $user_id
								AND item_id = ".$item_id;
							if (!$sresult = $db->sql_query($ssql)) 
							{
								message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users items!');
							}							
						}
					}
				}
			}
			$usql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
				SET creature_hygiene = creature_hygiene + $given_hygiene
				WHERE owner_id = ".$user_id ;
			if (!$uresult = $db->sql_query($usql)) 
			{
				message_die(CRITICAL_ERROR, 'Error Updating Rabbitishi users !');
			}
		}
	}

	if ($Hotel || $Hotel_out || $Hotel_in )
	{
		$template->set_filenames(array(
			'body' => 'rabbitoshi_hotel_body.tpl')
		);

		$hotel_time_days = $HTTP_POST_VARS['Hotel_time'];

		if ( $Hotel_out )
		{
			$sql = " UPDATE " . RABBITOSHI_USERS_TABLE . " 
				SET creature_hotel = 0
				WHERE owner_id = ".$userdata['user_id'];
			if (!$result = $db->sql_query($sql)) 
			{ 
				message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi user!'); 
			} 
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_hotel_out_success'].$lang['Rabbitoshi_general_return'] );
		}

		if ( $Hotel_in )
		{

			$hotel_price = $hotel_time_days * $rabbit_general['hotel_cost'];
			$hotel_exp = $hotel_time_days * $rabbit_general['exp_lose'];

			if ( $hotel_price > $points )
			{
				message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_hotel_lack_money'].$lang['Rabbitoshi_general_return'] );
			}

			$time = time() + ( $hotel_time_days * 86400 );

			$sql = " UPDATE " . RABBITOSHI_USERS_TABLE . " 
				SET creature_hotel = $time
				WHERE owner_id = ".$userdata['user_id'];
			if (!$result = $db->sql_query($sql)) 
			{ 
				message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi user!'); 
			} 
			$sql = " UPDATE " . RABBITOSHI_USERS_TABLE . " 
				SET creature_experience = creature_experience - $hotel_exp
				WHERE owner_id = ".$userdata['user_id'];
			if (!$result = $db->sql_query($sql)) 
			{ 
				message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi user!'); 
			} 
			$sql = " UPDATE " . USERS_TABLE . " 
				SET user_points = user_points - $hotel_price 
				WHERE user_id = ".$userdata['user_id'];
			if (!$result = $db->sql_query($sql)) 
			{ 
				message_die(CRITICAL_ERROR, 'Error Getting user points!'); 
			} 
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_hotel_in_success'].$lang['Rabbitoshi_general_return'] );
		}

		list($is_in_hotel , $hotel_time) = rabbitoshi_get_hotel();
		if ( $hotel_time > 1 )
		{
			$is_in_hotel = TRUE ;
			$template->assign_block_vars( 'in_hotel' , array());

		}
		else
		{
			$is_in_hotel = FALSE ;
			$template->assign_block_vars( 'not_in_hotel' , array());
			$hotel_price = $rabbit_general['hotel_cost'];
			for ( $i = 1 ; $i < 51 ; $i++ )
			{
				$hotel_day = $i.'&nbsp;'.$lang['Days'].'&nbsp;(&nbsp;'.$i*$hotel_price.'&nbsp;'.$board_config['points_name'].'&nbsp;)';
				$hotel_days .= '<option value = "'.$i.'" >'.$hotel_day.'</option>';
			}
		}


		$template->assign_vars(array(
			'L_HOTEL_TITLE' => $lang['Rabbitoshi_hotel'],
			'L_WELCOME_HOTEL' => $lang['Rabbitoshi_hotel_welcome'],
			'L_WELCOME_HOTEL_SERVICES' => $lang['Rabbitoshi_hotel_welcome_services'],
			'L_WELCOME_HOTEL_SERVICES_COST' => $lang['Rabbitoshi_hotel_price_explain'],
			'L_WELCOME_HOTEL_SERVICES_SELECT' => $lang['Rabbitoshi_hotel_welcome_services_select'],
			'L_INTO_HOTEL'  => $lang['Rabbitoshi_hotel_get_in'],
			'L_TRANSLATOR'  => $lang['Rabbitoshi_translation'],
			'L_ACTION'      => $lang['Submit'],
			'L_IS_IN_HOTEL' => $lang['Rabbitoshi_is_in_hotel'],
			'L_OUT_OF_HOTEL'=> $lang['Rabbitoshi_out_of_hotel'],
			'HOTEL_DAYS'    => $hotel_days,
			'HOTEL_SERVICES_COST' => $hotel_price.'&nbsp;'.$board_config['points_name'],
			'S_MODE_ACTION' => append_sid("rabbitoshi.$phpEx"))
		);
	}             

	if ($Evolution || $Evolution_exec )
	{
		$template->set_filenames(array(
			'body' => 'rabbitoshi_evolution_body.tpl')
		);

		if ( $Evolution_exec )
		{
			if ( !$Evolution_pet )
			{
				message_die(GENERAL_ERROR, 'Vous devez choisir une créature !');
			}

			$sql = "SELECT * FROM " . RABBITOSHI_CONFIG_TABLE . "
				WHERE creature_id = ".$Evolution_pet;
			if (!$result = $db->sql_query($sql)) 
			{ 
				message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi Config!');  
			} 
			$evolution_pet = $db->sql_fetchrow($result); 
			$prize = floor ( $evolution_pet['creature_prize'] * ( $rabbit_general['evolution_cost'] / 100 ));
			
			if ( $prize > $points )
			{ 
				message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_evolution_lack'].$lang['Rabbitoshi_general_return'] ); 
			} 

			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
				SET creature_power = ".$evolution_pet['creature_power']." ,
				creature_magicpower = ".$evolution_pet['creature_magicpower']." ,
				creature_armor = ".$evolution_pet['creature_armor']." ,
				creature_hunger = ".$evolution_pet['creature_max_hunger']." ,
				creature_hunger_max = ".$evolution_pet['creature_max_hunger']." ,
				creature_thirst = ".$evolution_pet['creature_max_thirst']." ,
				creature_thirst_max = ".$evolution_pet['creature_max_thirst']." ,
				creature_health = ".$evolution_pet['creature_max_health']." ,
				creature_health_max = ".$evolution_pet['creature_max_health']." ,
				creature_mp = ".$evolution_pet['creature_mp_max']." ,
				creature_max_mp = ".$evolution_pet['creature_mp_max']." ,
				creature_hygiene = ".$evolution_pet['creature_max_hygiene']." ,
				creature_hygiene_max = ".$evolution_pet['creature_max_hygiene']." ,
				owner_creature_id = ".$Evolution_pet." ,
				owner_last_visit = ".time()."			
				WHERE owner_id = $user_id";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, '', __LINE__, __FILE__, $sql);
			}

			$sql = "UPDATE " . USERS_TABLE . "
				SET user_points = user_points - $prize 		
				WHERE user_id = $user_id";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, '', __LINE__, __FILE__, $sql);
			}
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_evolution_success'].$lang['Rabbitoshi_general_return'] ); 
			
		}

		$rabbit_conf = get_rabbitoshi_config($rabbit_user['owner_creature_id']);
		$sql = "SELECT * FROM " . RABBITOSHI_CONFIG_TABLE . "
			WHERE creature_evolution_of = ".$rabbit_conf['creature_id'];
		if (!$result = $db->sql_query($sql)) 
		{ 
			message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi Config!');  
		} 
		$evolution_pets = $db->sql_fetchrowset($result); 

		if ( count($evolution_pets) < 1 || !$rabbit_general['evolution_enable'] )
		{
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_no_evolution'].$lang['Rabbitoshi_general_return'] ); 
		} 

		if ( ( time() - $rabbit_user['creature_age'] ) < ( $rabbit_general['evolution_time'] *86400 ) )
		{
			$days = $rabbit_general['evolution_time'];
			$message = $lang['Rabbitoshi_no_evolution_time'].$days.'&nbsp;'.$lang['Days'];
			message_die( GENERAL_MESSAGE,$message.$lang['Rabbitoshi_general_return'] ); 
		} 

		for($i = 0; $i < count($evolution_pets); $i++)
		{
			$prize = floor ( $evolution_pets[$i]['creature_prize'] * ( $rabbit_general['evolution_cost'] / 100 ));
			$template->assign_block_vars('available_pets',array(
				'PET_NAME' => $evolution_pets[$i]['creature_name'],
				'PET_ID' => $evolution_pets[$i]['creature_id'],
				'PET_PRIZE' => $prize,
				'PET_POWER' => $evolution_pets[$i]['creature_power'],
				'PET_MAGICPOWER' => $evolution_pets[$i]['creature_magicpower'],
				'PET_ARMOR' => $evolution_pets[$i]['creature_armor'],
				'PET_HUNGER' => $evolution_pets[$i]['creature_max_hunger'],
				'PET_HUNGERMAX' => $evolution_pets[$i]['creature_max_hunger'],
				'PET_THIRST' => $evolution_pets[$i]['creature_max_thirst'],
				'PET_THIRSTMAX' => $evolution_pets[$i]['creature_max_thirst'],
				'PET_HYGIENE' => $evolution_pets[$i]['creature_max_hygiene'],
				'PET_HYGIENEMAX' => $evolution_pets[$i]['creature_max_hygiene'],
				'PET_HEALTH' => $evolution_pets[$i]['creature_max_health'],
				'PET_HEALTHMAX' => $evolution_pets[$i]['creature_max_health'],
				'PET_MP' => $evolution_pets[$i]['creature_mp'],
				'PET_MPMAX' => $evolution_pets[$i]['creature_mp_max'],
			));
		}

		$template->assign_vars(array(
			'L_EVOLUTION_TITLE' => $lang['Rabbitoshi_evolution'],
			'L_WELCOME_EVOLUTION' => $lang['Rabbitoshi_evolution_welcome'],
			'L_TRANSLATOR'  => $lang['Rabbitoshi_translation'],
			'L_RETURN'      => $lang['Rabbitoshi_shop_return'],
			'L_EVOLUTION_EXEC' => $lang['Rabbitoshi_evolution_exec'],
			'S_MODE_ACTION' => append_sid("rabbitoshi.$phpEx"))
		);
	}

	if ($Sellpet || $confirm_sell)
	{
		$pet_value = intval($HTTP_POST_VARS['pet_value']);

		if ($confirm_sell)
		{
			$sql = "UPDATE " . USERS_TABLE . "
			SET user_points = user_points + $pet_value
			WHERE user_id = $user_id";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Could not update user's points", '', __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . RABBITOSHI_USERS_TABLE . "
			WHERE owner_id = " . $user_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete pet", "", __LINE__, __FILE__, $sql);
			}
			$sql = "DELETE FROM " . RABBITOSHI_SHOP_USERS_TABLE . "
			WHERE user_id = " . $user_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete pet shop user table", "", __LINE__, __FILE__, $sql);
			}
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_pet_sold']."$pet_value".'&nbsp;'.$board_config['points_name'].$lang['Rabbitoshi_return']);
		}
		else
		{
			$template->set_filenames(array(
				'body' => 'rabbitoshi_confirm_body.tpl')
			);
			$template->assign_block_vars( 'sellpet' , array());

			$template->assign_vars(array(
				'SELL_PET_FOR' => $pet_value,
				'L_PET_SOLD' => $lang['Rabbitoshi_pet_sell'],
				'L_SELL_PET_FOR' => $lang['Rabbitoshi_pet_sell_for'],
				'L_CONFIRM_TITLE' => $lang['Rabbitoshi_confirm'],
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],
			));
		}
	}

	if ($prefs || $prefs_exec )
	{
		$notify = intval($HTTP_POST_VARS['notify']);	
		$hide = intval($HTTP_POST_VARS['hide']);	
		$feed_full = intval($HTTP_POST_VARS['feed_full']);	
		$drink_full = intval($HTTP_POST_VARS['drink_full']);	
		$clean_full= intval($HTTP_POST_VARS['clean_full']);	
		
		if ($prefs_exec)
		{
			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
			SET owner_notification = $notify ,
			owner_hide = $hide ,
			owner_feed_full = $feed_full,
			owner_drink_full = $drink_full,
			owner_clean_full = $clean_full
			WHERE owner_id = $user_id";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Could not update rabbiotoshi user table", '', __LINE__, __FILE__, $sql);
			}
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_preferences_updated'].$lang['Rabbitoshi_general_return']);
		}
		else
		{
			$template->set_filenames(array(
				'body' => 'rabbitoshi_preferences_body.tpl')
			);

			$template->assign_vars(array(
				'RABBITOSHI_PREFERENCES_NOTIFY_CHECKED' => ( $rabbit_user['owner_notification'] ? 'CHECKED' : ''),
				'RABBITOSHI_PREFERENCES_HIDE_CHECKED' => ( $rabbit_user['owner_hide'] ? 'CHECKED' : ''),
				'RABBITOSHI_PREFERENCES_FEED_FULL_CHECKED' => ( $rabbit_user['owner_feed_full'] ? 'CHECKED' : ''),
				'RABBITOSHI_PREFERENCES_DRINK_FULL_CHECKED' => ( $rabbit_user['owner_drink_full'] ? 'CHECKED' : ''),
				'RABBITOSHI_PREFERENCES_CLEAN_FULL_CHECKED' => ( $rabbit_user['owner_clean_full'] ? 'CHECKED' : ''),
				'L_RABBITOSHI_PREFERENCES_NOTIFY' => $lang['Rabbitoshi_preferences_notify'],
				'L_RABBITOSHI_PREFERENCES_HIDE' => $lang['Rabbitoshi_preferences_hide'],
				'L_RABBITOSHI_PREFERENCES_FEED_FULL' => $lang['Rabbitoshi_preferences_feed_full'],
				'L_RABBITOSHI_PREFERENCES_FEED_FULL_EXPLAIN' => $lang['Rabbitoshi_preferences_feed_full_explain'],
				'L_RABBITOSHI_PREFERENCES_DRINK_FULL' => $lang['Rabbitoshi_preferences_drink_full'],
				'L_RABBITOSHI_PREFERENCES_DRINK_FULL_EXPLAIN' => $lang['Rabbitoshi_preferences_drink_full_explain'],
				'L_RABBITOSHI_PREFERENCES_CLEAN_FULL' => $lang['Rabbitoshi_preferences_clean_full'],
				'L_RABBITOSHI_PREFERENCES_CLEAN_FULL_EXPLAIN' => $lang['Rabbitoshi_preferences_clean_full_explain'],
				'L_SUBMIT' => $lang['Submit'],
				'L_CONFIRM_TITLE' => $lang['Preferences'],
			));
		}
	}

	if ($Owner_list)
	{
		$template->set_filenames(array(
			'body' => 'rabbitoshi_owners_body.tpl')
		);
		make_jumpbox('viewforum.'.$phpEx);

		if ( isset($HTTP_GET_VARS['mode2']) || isset($HTTP_POST_VARS['mode2']) )
		{
			$mode2 = ( isset($HTTP_POST_VARS['mode2']) ) ? htmlspecialchars($HTTP_POST_VARS['mode2']) : htmlspecialchars($HTTP_GET_VARS['mode2']);
		}
		else
		{
			$mode2 = 'username';
		}

		if(isset($HTTP_POST_VARS['order']))
		{
			$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
		}
		else if(isset($HTTP_GET_VARS['order']))
		{
			$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
		}
		else
		{
			$sort_order = 'ASC';
		}

		$mode_types_text = array($lang['Sort_Username'], $lang['Rabbitoshi_pet_name'] , $lang['Rabbitoshi_pet_time']);
		$mode_types = array( 'username', 'petname', 'petage');

		$select_sort_mode = '<select name="mode2">';
		for($i = 0; $i < count($mode_types_text); $i++)
		{
			$selected = ( $mode2 == $mode_types[$i] ) ? ' selected="selected"' : '';
			$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
		}
		$select_sort_mode .= '</select>';

		$select_sort_order = '<select name="order">';
		if($sort_order == 'ASC')
		{
			$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
		}
		else
		{
			$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
		}
		$select_sort_order .= '</select>';

		switch( $mode2 )
		{
			case 'username':
				$order_by = "u.username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
				break;
			case 'petname':
				$order_by = "ru.owner_creature_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
				break;
			case 'petage':
				if ( $sort_order == 'ASC')
				{
					$sort_order2 = 'DESC';
				}
				else if ( $sort_order == 'DESC')
				{
					$sort_order2 = 'ASC';
				}
				else
				{
					$sort_order2 = $sort_order ;
				}

				$order_by = "ru.creature_age $sort_order2 LIMIT $start, " . $board_config['topics_per_page'];
				break;
			default:
				$order_by = "username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
				break;
		}

		$sql = "SELECT u.user_id , u.username ,  u.user_avatar, u.user_avatar_type, u.user_allowavatar , ru.owner_creature_name , ru.creature_age , ru.owner_creature_id
			FROM " . USERS_TABLE . " u , " . RABBITOSHI_USERS_TABLE . " ru
			WHERE u.user_id = ru.owner_id
			AND ru.owner_hide = 0 
			ORDER BY $order_by";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$i = 0;
			do
			{
				$username = $row['username'];
				$user_id = $row['user_id'];

				$poster_avatar = '';
				if ( $row['user_avatar_type'] && $user_id != ANONYMOUS && $row['user_allowavatar'] )
				{
					switch( $row['user_avatar_type'] )
					{
						case USER_AVATAR_UPLOAD:
							$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
							break;
						case USER_AVATAR_REMOTE:
							$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
							break;
						case USER_AVATAR_GALLERY:
							$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
							break;
					}
				}				

				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				$tsql = "SELECT creature_name
					FROM " . RABBITOSHI_CONFIG_TABLE . "
					WHERE creature_id = ".$row['owner_creature_id'];
				if ( !($tresult = $db->sql_query($tsql)) )
				{
					message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $tsql);
				}
				$type = $db->sql_fetchrow($tresult);
				$pet_type = isset($lang[$type['creature_name']]) ? $lang[$type['creature_name']] : $type['creature_name'];
				$template->assign_block_vars('owner_list', array(
					'ROW_NUMBER' => $i + ( $HTTP_GET_VARS['start'] + 1 ),
					'ROW_COLOR' => '#' . $row_color,
					'ROW_CLASS' => $row_class,
					'USERNAME' => $username,
					'PET_NAME' => $row['owner_creature_name'],
					'PET_AGE' => rabbitoshi_get_pet_age($row['creature_age']),
					'PET_TYPE' => $pet_type,
					'AVATAR_IMG' => $poster_avatar,
					'PROFILE' => $profile, 
					'U_RABBITOSHI'  => append_sid("rabbitoshi.$phpEx?" . POST_USERS_URL . "=$user_id"),
					'U_VIEWPROFILE' => append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$user_id"))
				);

				$i++;
			}
			while ( $row = $db->sql_fetchrow($result) );

		}

		$sql = "SELECT count(*) AS total FROM " . RABBITOSHI_USERS_TABLE ." 
			WHERE owner_hide = 0 ";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
		}
		if ( $total = $db->sql_fetchrow($result) )
		{
			$total_members = $total['total'];
			$pagination = generate_pagination("rabbitoshi.$phpEx?from=list&amp;mode2=$mode2&amp;order=$sort_order", $total_members, $board_config['topics_per_page'], $start). '&nbsp;';
		}

		$template->assign_vars(array(
			'L_PET_NAME' => $lang['Rabbitoshi_pet_name'],
			'L_PET_TYPE' => $lang['Rabbitoshi_pet_type'],
			'L_PET_AGE' => $lang['Rabbitoshi_pet_time'],
			'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
			'L_ORDER' => $lang['Order'],
			'L_SORT' => $lang['Sort'],
			'L_SUBMIT' => $lang['Sort'],
			'S_MODE_SELECT' => $select_sort_mode,
			'S_ORDER_SELECT' => $select_sort_order,
			'PAGINATION' => $pagination,
			'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_members / $board_config['topics_per_page'] )), 
			'L_GOTO_PAGE' => $lang['Goto_page'],
			'S_MODE_ACTION' => append_sid("rabbitoshi.$phpEx"))
		);
	}

	$rabbit_user = rabbitoshi_get_user_stats($view_userdata['user_id']);

	$sql = "SELECT * FROM  " . RABBITOSHI_GENERAL_TABLE ; 
	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		$rabbit_general[$row['config_name']] = $row['config_value'];
	}

	if ( $searchid == $user_id ) 
	{
		$visit_time = time() - $rabbit_user['owner_last_visit'];
		$hunger_time = floor( $visit_time / $rabbit_general['hunger_time']);
		$hunger_less = ($hunger_time * $rabbit_general['hunger_value']);
		$thirst_time = floor( $visit_time / $rabbit_general['thirst_time']);
		$thirst_less = ($thirst_time * $rabbit_general['thirst_value']);
		$hygiene_time = floor( $visit_time / $rabbit_general['hygiene_time']);
		$hygiene_less =($hygiene_time * $rabbit_general['hygiene_value']);
		$health_time = floor( $visit_time / $rabbit_general['health_time']);
		$health_less = ( $health_time * $rabbit_general['health_value'] ) + floor ( ( $hunger_less + $hygiene_less + $thirst_less ) / 3 );

		list($is_in_hotel , $hotel_time) = rabbitoshi_get_hotel();
		if ( !$is_in_hotel )
		{
			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
			SET creature_hunger = creature_hunger - $hunger_less ,
			creature_thirst = creature_thirst - $thirst_less ,
			creature_health = creature_health - $health_less ,
			creature_hygiene = creature_hygiene - $hygiene_less ,
			owner_last_visit = ".time()."
			WHERE owner_id = $user_id";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, '', __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
			SET owner_last_visit = ".time()."
			WHERE owner_id = $user_id";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, '', __LINE__, __FILE__, $sql);
			}
		}

		$rabbit_stats = get_rabbitoshi_config($rabbit_user['owner_creature_id'] );
		list ( $value , $thought , $message , $pet_dead ) = rabbitoshi_get_pet_value();
	}

	if ( $board_config['rabbitoshi_enable'] ) 
	{
		$rabbit_user = rabbitoshi_get_user_stats($view_userdata['user_id']);
		$rabbit_stats = get_rabbitoshi_config($rabbit_user['owner_creature_id']);

	      list ( $value , $thought , $message , $pet_dead ) = rabbitoshi_get_pet_value();

		if ( $pet_dead && $searchid == $user_id )
		{
			if ( $rabbit_general['rebirth_enable'] )
			{
				if ( $points > $rabbit_general['rebirth_price'] )
				{
					if ( $resurrect_ok )
					{
						$hunger = $rabbit_user['creature_hunger_max'];
						$thirst = $rabbit_user['creature_thirst_max'];
						$health = $rabbit_user['creature_health_max'];
						$hygiene = $rabbit_user['creature_hygiene_max'];
						$mp = $rabbit_user['creature_max_mp'];
						$attack = $rabbit_user['creature_attack_max'];
						$magicattack = $rabbit_user['creature_magicattack_max'];

						$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
						SET   creature_hunger = $hunger, 
							creature_thirst = $thirst,
							creature_health = $health,
							creature_hygiene = $hygiene,
							creature_mp = $mp,
							creature_attack = $attack,
							creature_magicattack = $magicattack,
							owner_last_visit = ".time()."
						WHERE owner_id = ".$user_id;
						if ( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
						{
							message_die(GENERAL_ERROR, 'Could not insert data into rabbitoshi users table', '', __LINE__, __FILE__, $sql);
						}
						$prize = $rabbit_general['rebirth_price'];
						$sql = "UPDATE " . USERS_TABLE . "
						SET user_points = user_points - $prize
						WHERE user_id = $user_id";
						if (!$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, "Could not update user's points", '', __LINE__, __FILE__, $sql);
						}	

						message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_pet_dead_rebirth_ok'] );
					}
					else if ( $resurrect_no )
					{
						$sql = "DELETE FROM " . RABBITOSHI_USERS_TABLE . "
						WHERE owner_id = " . $user_id;
						$result = $db->sql_query($sql);
						if( !$result )
						{
							message_die(GENERAL_ERROR, "Couldn't delete pet", "", __LINE__, __FILE__, $sql);
						}
						$sql = "DELETE FROM " . RABBITOSHI_SHOP_USERS_TABLE . "
						WHERE user_id = " . $user_id;
						$result = $db->sql_query($sql);
						if( !$result )
						{
							message_die(GENERAL_ERROR, "Couldn't delete pet shop user table", "", __LINE__, __FILE__, $sql);
						}
						message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_pet_dead_rebirth_no'] );
					}
					else
					{
						$template->set_filenames(array(
							'body' => 'rabbitoshi_confirm_body.tpl')
						);
						$template->assign_block_vars( 'resurrect' , array());

						$template->assign_vars(array(
							'L_CONFIRM_TITLE' => $lang['Rabbitoshi_confirm'],
							'L_PET_IS_DEAD' => $lang['Rabbitoshi_pet_is_dead'],
							'L_PET_DEAD_COST' => $lang['Rabbitoshi_pet_is_dead_cost'],
							'L_PET_DEAD_COST_EXPLAIN' => $lang['Rabbitoshi_pet_is_dead_cost_explain'],
							'L_RESURRECT_OK' => $lang['Yes'],
							'L_RESURRECT_NO' => $lang['No'],
							'PET_DEAD_COST' => $rabbit_general['rebirth_price'])
						);

					}
				}
				else 
				{
					$sql = "DELETE FROM " . RABBITOSHI_USERS_TABLE . "
					WHERE owner_id = " . $user_id;
					$result = $db->sql_query($sql);
					if( !$result )
					{
						message_die(GENERAL_ERROR, "Couldn't delete pet", "", __LINE__, __FILE__, $sql);
					}
					$sql = "DELETE FROM " . RABBITOSHI_SHOP_USERS_TABLE . "
					WHERE user_id = " . $user_id;
					$result = $db->sql_query($sql);
					if( !$result )
					{
						message_die(GENERAL_ERROR, "Couldn't delete pet shop user table", "", __LINE__, __FILE__, $sql);
					}
					message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_pet_dead_lack'] );
				}
			}
			else
			{
				$sql = "DELETE FROM " . RABBITOSHI_USERS_TABLE . "
				WHERE owner_id = " . $user_id;
				$result = $db->sql_query($sql);
				if( !$result )
				{
					message_die(GENERAL_ERROR, "Couldn't delete pet", "", __LINE__, __FILE__, $sql);
				}
				$sql = "DELETE FROM " . RABBITOSHI_SHOP_USERS_TABLE . "
				WHERE user_id = " . $user_id;
				$result = $db->sql_query($sql);
				if( !$result )
				{
					message_die(GENERAL_ERROR, "Couldn't delete pet shop user table", "", __LINE__, __FILE__, $sql);
				}
				message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_pet_dead']);
			}
		}

		$rabbit_config = get_rabbitoshi_config($rabbit_user['owner_creature_id']);
		$template->assign_block_vars( 'pet' , array());

		list($is_in_hotel , $hotel_time) = rabbitoshi_get_hotel();
		if ( $hotel_time > 1 )
		{
			$is_in_hotel = TRUE ;
			$template->assign_block_vars( 'pet.pet_hotel' , array());
		}
		else
		{
			$is_in_hotel = FALSE ;
			$template->assign_block_vars( 'pet.pet_no_hotel' , array());
		}

		if ( $searchid == $user_id || $is_in_hotel == TRUE ) 
		{
			if ( $searchid == $user_id )
			{
				$template->assign_block_vars( 'pet.owner', array());
			}
			$hung = $rabbit_user['creature_hunger'];
			$thir = $rabbit_user['creature_thirst'];
			$heal = $rabbit_user['creature_health'];
			$hygi = $rabbit_user['creature_hygiene'];
			$mp = $rabbit_user['creature_mp'];
			$attack = $rabbit_user['creature_attack'];
			$magicattack = $rabbit_user['creature_magicattack'];
		}

		else
		{
			$visit_time = time() - $rabbit_user['owner_last_visit'];
			$hunger_time = floor( $visit_time / $rabbit_general['hunger_time']);
			$hunger_less = ($hunger_time * $rabbit_general['hunger_value']);
			$thirst_time = floor( $visit_time / $rabbit_general['thirst_time']);
			$thirst_less = ($thirst_time * $rabbit_general['thirst_value']);
			$hygiene_time = floor( $visit_time / $rabbit_general['hygiene_time']);
			$hygiene_less = ($hygiene_time * $rabbit_general['hygiene_value']);
			$health_time = floor( $visit_time / $rabbit_general['health_time']);
			$health_less = ( $health_time * $rabbit_general['health_value'] ) + floor ( ( $hunger_less + $hygiene_less + $thirst_less ) / 3 );
			$hung = $rabbit_user['creature_hunger'] - $hunger_less;
			$thir = $rabbit_user['creature_thirst'] - $thirst_less;
			$heal = $rabbit_user['creature_health'] - $health_less;
			$hygi = $rabbit_user['creature_hygiene'] - $hygiene_less;

			if ( $hung < 0 ) { $hung = 0; }
			if ( $thir < 0 ) { $thir = 0; }
			if ( $hygi < 0 ) { $hygi = 0; }
			if ( $heal < 0 ) { $heal = 0; }
		}
		
		$health_rate_percent_width = floor(( $heal / $rabbit_user['creature_health_max']) * 100 );
		$health_rate_percent_empty = ( 100 - $health_rate_percent_width );
		$thirst_rate_percent_width = floor(( $thir / $rabbit_user['creature_thirst_max']) * 100 );
		$thirst_rate_percent_empty = ( 100 - $thirst_rate_percent_width );
		$hygiene_rate_percent_width = floor(( $hygi / $rabbit_user['creature_hygiene_max']) * 100 );
		$hygiene_rate_percent_empty = ( 100 - $hygiene_rate_percent_width );
		$hunger_rate_percent_width = floor(( $hung / $rabbit_user['creature_hunger_max']) * 100 );
		$hunger_rate_percent_empty = ( 100 - $hunger_rate_percent_width );
     	      if ( $rabbit_user['creature_max_mp'] == 0 )
    	      {
    	     		 $mp_rate_percent_width = 0;      
     	      }
    	      else
     	      {
     		  	$mp_rate_percent_width = floor(( $mp / $rabbit_user['creature_max_mp']) * 100 );
      	} 
		$mp_rate_percent_empty = ( 100 - $mp_rate_percent_width );
     	      if ( $rabbit_user['creature_attack_max'] == 0 )
    	      {
    	     		 $attack_rate_percent_width = 0;      
     	      }
    	      else
     	      {
     		  	$attack_rate_percent_width = floor(( $attack / $rabbit_user['creature_attack_max']) * 100 );
      	} 
		$attack_rate_percent_empty = ( 100 - $attack_rate_percent_width );
     	      if ( $rabbit_user['creature_magicattack_max'] == 0 )
    	      {
    	     		 $magicattack_rate_percent_width = 0;      
     	      }
    	      else
     	      {
     		  	$magicattack_rate_percent_width = floor(( $magicattack / $rabbit_user['creature_magicattack_max']) * 100 );
      	} 
		$magicattack_rate_percent_empty = ( 100 - $magicattack_rate_percent_width );

		$last_visit = create_date($board_config['default_dateformat'], $rabbit_user['owner_last_visit'], $board_config['board_timezone']);
		$sql ="SELECT item_name 
		FROM ".RABBITOSHI_SHOP_TABLE." 
		WHERE item_id = ".$rabbit_config['creature_food_id'];
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi Config!');
		}
		$rabbit_food = $db->sql_fetchrow($result);
		$favorite_food = isset($lang[$rabbit_food['item_name']]) ? $lang[$rabbit_food['item_name']] : $rabbit_food['item_name'];
		$favorite_food = $favorite_food ? $favorite_food : $lang['Rabbitoshi_item_type_food_none'];
		$pic = $rabbit_config['creature_img'];
		if (!(file_exists("images/Rabbitoshi/$pic")) || !$pic )
		{
			$pic = $rabbit_config['creature_name'].'.gif';
		}

		$statut_health = '';
		$statut_level = $rabbit_user['creature_statut'];
		if ( $statut_level == '0' )
		{
			$statut_health = $lang['Rabbitoshi_creature_statut_0'];
		}
		if ( $statut_level == '1' )
		{
			$statut_health = $lang['Rabbitoshi_creature_statut_1'];
		}
		if ( $statut_level == '2' )
		{
			$statut_health = $lang['Rabbitoshi_creature_statut_2'];
		}
		if ( $statut_level == '3' )
		{
			$statut_health = $lang['Rabbitoshi_creature_statut_3'];
		}
		if ( $statut_level == '4' )
		{
			$statut_health = $lang['Rabbitoshi_creature_statut_4'];
		}

		$ability = '';
		$ability_level = $rabbit_user['creature_ability'];
		if ( $ability_level == '0' )
		{
			$ability = $lang['Rabbitoshi_ability_lack'];
		}
		if ( $ability_level == '1' )
		{
			$ability = $lang['Rabbitoshi_ability_regeneration'];
		}
		if ( $ability_level == '2' )
		{
			$ability = $lang['Rabbitoshi_ability_health'];
		}
		if ( $ability_level == '3' )
		{
			$ability = $lang['Rabbitoshi_ability_mana'];
		}
		if ( $ability_level == '4' )
		{
			$ability = $lang['Rabbitoshi_ability_sacrifice'];
		}

		$template->assign_vars(array(
			'HEALTH_PERCENT_WIDTH' => $health_rate_percent_width,
			'HEALTH_PERCENT_EMPTY' => $health_rate_percent_empty,
			'THIRST_PERCENT_WIDTH' => $thirst_rate_percent_width,
			'THIRST_PERCENT_EMPTY' => $thirst_rate_percent_empty,
			'HYGIENE_PERCENT_WIDTH' => $hygiene_rate_percent_width,
			'HYGIENE_PERCENT_EMPTY' => $hygiene_rate_percent_empty,
			'HUNGER_PERCENT_WIDTH' => $hunger_rate_percent_width,
			'HUNGER_PERCENT_EMPTY'=> $hunger_rate_percent_empty,
			'MP_PERCENT_WIDTH' => $mp_rate_percent_width,
			'MP_PERCENT_EMPTY'=> $mp_rate_percent_empty,
			'ATTACK_PERCENT_WIDTH' => $attack_rate_percent_width,
			'ATTACK_PERCENT_EMPTY'=> $attack_rate_percent_empty,
			'MAGICATTACK_PERCENT_WIDTH' => $magicattack_rate_percent_width,
			'MAGICATTACK_PERCENT_EMPTY'=> $magicattack_rate_percent_empty,
			'PET_AGE' => rabbitoshi_get_pet_age($rabbit_user['creature_age']),
			'PET_OWNER' => $view_userdata['username'],
			'PET_PIC' => $pic,
			'STATUT_HEALTH' => $statut_health,
			'ABILITY' => $ability,
			'PET_NAME' => $rabbit_user['owner_creature_name'],
			'PET_HUNGER' => $hung,
			'PET_THIRST' => $thir,
			'PET_HYGIENE' => $hygi,
			'PET_HEALTH' => $heal,
			'PET_MP' => $rabbit_user['creature_mp'],
			'PET_LEVEL' => $rabbit_user['creature_level'],
			'PET_POWER' => $rabbit_user['creature_power'],
			'PET_MAGICPOWER' => $rabbit_user['creature_magicpower'],
			'PET_ARMOR' => $rabbit_user['creature_armor'],
			'PET_EXPERIENCE' => $rabbit_user['creature_experience'],
			'PET_EXPERIENCE_LIMIT' => $rabbit_user['creature_experience_level'],
			'PET_EXPERIENCE_LIMIT_MAX' => $rabbit_user['creature_experience_level_limit'],
			'PET_ATTACK' => $rabbit_user['creature_attack'],
			'PET_MAGICATTACK' => $rabbit_user['creature_magicattack'],
			'CPET_NAME' => $rabbit_config['creature_name'],
			'CPET_HUNGER' => $rabbit_user['creature_hunger_max'],
			'CPET_THIRST' => $rabbit_user['creature_thirst_max'],
			'CPET_HYGIENE' => $rabbit_user['creature_hygiene_max'],
			'CPET_HEALTH' => $rabbit_user['creature_health_max'],
			'CPET_MP' => $rabbit_user['creature_max_mp'],
			'CPET_ATTACK' => $rabbit_user['creature_attack_max'],
			'CPET_MAGICATTACK' => $rabbit_user['creature_magicattack_max'],
			'L_LAST_VISIT' => $lang['Rabbitoshi_owner_last_visit'],
			'L_CHARACTERISTICS' => $lang['Rabbitoshi_creature_characteristics'],
			'L_ATTACKS' => $lang['Rabbitoshi_creature_attacks'],
			'LAST_VISIT' => $last_visit,
			'L_FAVORITE_FOOD' => $lang['Rabbitoshi_pet_favorite_food'],
			'FAVORITE_FOOD' => $favorite_food,
			'S_PET_ACTION' => append_sid("rabbitoshi.$phpEx"),
			'L_OWNER_POINTS' => $lang['Rabbitoshi_owner_points'],
			'L_PET_SELL' => $lang['Rabbitoshi_owner_sell'],
			'L_PET_VALUE' => $lang['Rabbitoshi_owner_pet_value'],
			'PET_VALUE' => $value,
			'POINTS' => $userdata['user_points'],
			'U_PET_SHOP' => append_sid("rabbitoshi_shop.$phpEx"),
			'U_PET_PROGRESS' => append_sid("rabbitoshi_progress.$phpEx"),
			'S_HIDDEN_FIELDS'	 => $s_hidden_fields,
		));
	}
	else
	{
		message_die( GENERAL_MESSAGE,sprintf($lang['Rabbitoshi_disable']) );
	}
}

$template->assign_vars(array(
	'L_NOPET_TITLE'    => $lang['Rabbitoshi_nopet_title'],
	'L_PET_HEALTH'     => $lang['Rabbitoshi_pet_health'],
	'L_PET_PRIZE'      => $lang['Rabbitoshi_pet_prize'],
	'L_PET_HUNGER'     => $lang['Rabbitoshi_pet_hunger'],
	'L_PET_THIRST'     => $lang['Rabbitoshi_pet_thirst'],
	'L_PET_HYGIENE'    => $lang['Rabbitoshi_pet_hygiene'],
	'L_PET_BUY'        => $lang['Rabbitoshi_pet_buy'],
	'L_PET_CHOOSE'     => $lang['Rabbitoshi_pet_choose'],
	'L_PET_NAME_SELECT'=> $lang['Rabbitoshi_name_select'],
	'L_POINTS'         => $board_config['points_name'],
	'L_CARACS' 		 => $lang['Rabbitoshi_pet_caracs'],
	'L_HEALTH' 		 => $lang['Rabbitoshi_pet_health'],
	'L_HUNGER' 		 => $lang['Rabbitoshi_pet_hunger'],
	'L_THIRST' 		 => $lang['Rabbitoshi_pet_thirst'],
	'L_HYGIENE' 	 => $lang['Rabbitoshi_pet_hygiene'],
	'L_CHARACTERISTICS'=> $lang['Rabbitoshi_pet_characteristics'],
	'L_ATTACKS' 	 => $lang['Rabbitoshi_pet_attacks'],
	'L_MP' 	       => $lang['Rabbitoshi_pet_mp'],
	'L_LEVEL' 	       => $lang['Rabbitoshi_pet_level'],
	'L_ABILITY' 	 => $lang['Rabbitoshi_ability_title'],
	'L_POWER' 	       => $lang['Rabbitoshi_pet_power'],
	'L_MAGICPOWER' 	 => $lang['Rabbitoshi_pet_magicpower'],
	'L_ARMOR' 	       => $lang['Rabbitoshi_pet_armor'],
	'L_EXPERIENCE' 	 => $lang['Rabbitoshi_pet_experience'],
	'L_EXPERIENCE_LIMIT'  => $lang['Rabbitoshi_pet_xp'],
	'L_RATIO_ATTACK' 	 => $lang['Rabbitoshi_pet_ratioattack'],
	'L_RATIO_MAGIC' 	 => $lang['Rabbitoshi_pet_ratiomagic'],
	'L_HEALTH' 	 	 => $lang['Rabbitoshi_pet_health'],
	'L_AGE'	 	 => $lang['Rabbitoshi_pet_age'],
	'L_PET_OF'	       => $lang['Rabbitoshi_pet_of'],
	'L_PUBLIC_TITLE'   => $lang['Rabbitoshi_title'],
	'L_VET'		 => $lang['Rabbitoshi_pet_call_vet'],
	'L_VET_EXPLAIN'    => $lang['Rabbitoshi_pet_call_vet_explain'],
	'L_FEED'		 => $lang['Rabbitoshi_pet_feed'],
	'L_DRINK'		 => $lang['Rabbitoshi_pet_drink'],
	'L_CLEAN'		 => $lang['Rabbitoshi_pet_clean'],
	'L_SHOP' 		 => $lang['Rabbitoshi_pet_shop'],
	'L_PROGRESS' 	 => $lang['Rabbitoshi_pet_progress'],
	'L_PET_SHOP' 	 => $lang['Rabbitoshi_Shop'],
	'L_PET_PROGRESS' 	 => $lang['Rabbitoshi_progress'],
	'L_TRANSLATOR'     => $lang['Rabbitoshi_translation'],
	'L_PET_GENERAL_MESSAGE' => $lang['Rabbitoshi_general_message'],
	'L_PET_MESSAGE'    => $lang['Rabbitoshi_message'],
	'L_PET_SERVICES'   => $lang['Rabbitoshi_services'],
	'L_OWNER_LIST'     => $lang['Rabbitoshi_owner_list'],
	'L_HOTEL'          => $lang['Rabbitoshi_hotel'],
	'L_HOTEL_EXPLAIN'  => $lang['Rabbitoshi_hotel_explain'],
	'L_EVOLUTION'          => $lang['Rabbitoshi_evolution'],
	'L_EVOLUTION_EXPLAIN'  => $lang['Rabbitoshi_evolution_explain'],
	'L_RETURN'      => $lang['Rabbitoshi_shop_return'],
	'L_OWNER_LIST_EXPLAIN' => $lang['Rabbitoshi_owner_list_explain'],
	'L_PREFERENCES' => $lang['Rabbitoshi_preferences'],
	'L_PREFERENCES_EXPLAIN' => $lang['Rabbitoshi_preferences_explain'],
	'VET_PRICE'        => $rabbit_general['vet_price'],
	'IN_HOTEL'         => $lang['Rabbitoshi_pet_into_hotel'],
	'HOTEL_TIME'       => create_date($board_config['default_dateformat'], $rabbit_user['creature_hotel'], $board_config['board_timezone']),
	'PET_GENERAL_MESSAGE' => $thought,
	'PET_MESSAGE'      => $message,
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 