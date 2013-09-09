<?php
/***************************************************************************
 *					adr_battle.php
 *				------------------------
 *	begin 			: 08/02/2004
 *	copyright			: Malicious Rabbit / Dr DLP
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
define('IN_ADR_CHARACTER', true); 
define('IN_ADR_BATTLE', true); 
define('IN_ADR_SHOPS', true);
define('IN_ADR_LOOTTABLES', true);
define('IN_ADR_ZONES', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_battle';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//
$user_id = $userdata['user_id'];
$user_points = $userdata['user_points'];
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
include($phpbb_root_path . 'rabbitoshi/language/lang_' . $board_config['default_lang'] . '/lang_rabbitoshi.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_battle.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Get the general config
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
adr_levelup_check($user_id);
adr_weight_check($user_id);

if ( !$adr_general['battle_enable'] ) 
{	
	adr_previous ( Adr_battle_disabled , adr_character , '' );
}

// Deny access if user is imprisioned
if($userdata['user_cell_time']){
	adr_previous(Adr_shops_no_thief, adr_cell, '');
}

// Includes the tpl and the header
adr_template_file('adr_battle_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Select pet infos
$pet_invoc = '1';
$sql = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE . " 
WHERE owner_id = $user_id ";	
if (!$result = $db->sql_query($sql)) 
{
	message_die(GENERAL_ERROR, 'Could not get pet info', '', __LINE__, __FILE__, $sql);
}
$rabbit_user = $db->sql_fetchrow($result);
if ( !$rabbit_user['owner_id'] ) 
{	
	$pet_invoc = '0';
}
$sql = "SELECT * FROM  " . RABBITOSHI_GENERAL_TABLE ; 
if (!$result = $db->sql_query($sql, false, 'rabbitoshi_config')) 
{
	message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
}
while( $row = $db->sql_fetchrow($result) )
{
	$rabbit_general[$row['config_name']] = $row['config_value'];
}

$equip = isset($HTTP_POST_VARS['equip']);
$attack = isset($HTTP_POST_VARS['attack']);
$spell = isset($HTTP_POST_VARS['spell']);
$spell2 = isset($HTTP_POST_VARS['spell2']);
$potion = isset($HTTP_POST_VARS['potion']);
$defend = isset($HTTP_POST_VARS['defend']);
$flee = isset($HTTP_POST_VARS['flee']);
$scan = isset($HTTP_POST_VARS['scan']);
$invoc = isset($HTTP_POST_VARS['invoc']);
$pet_attack = isset($HTTP_POST_VARS['pet_attack']);
$pet_magicattack = isset($HTTP_POST_VARS['pet_magicattack']);
$pet_specialattack = isset($HTTP_POST_VARS['pet_specialattack']);
// V: doing that because :-°
$petstuff = $invoc || $pet_attack || $pet_magicattack || $pet_specialattack;

// Select if the user has a battle in progress or no
$sql = " SELECT * FROM  " . ADR_BATTLE_LIST_TABLE . " 
	WHERE battle_challenger_id = $user_id
	AND battle_result = 0
	AND battle_type = 1 ";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
}
$bat = $db->sql_fetchrow($result);

if ( !(is_numeric($bat['battle_id'])) && !$equip )
{
	// Moved the equip screen infos into adr_funtions_battle_setup.php
	include_once($phpbb_root_path . '/adr/includes/adr_functions_battle_setup.'.$phpEx);
    adr_battle_equip_screen($user_id);
}
else if ( !(is_numeric($bat['battle_id'])) && $equip )
{
	// Let's calculate all the statistics now
	if($adr_general['Adr_character_limit_enable'] == '1') adr_battle_quota_check($user_id); 

	// Fix the items ids
	$armor = intval($HTTP_POST_VARS['item_armor']);
	$buckler = intval($HTTP_POST_VARS['item_buckler']);
	$helm = intval($HTTP_POST_VARS['item_helm']);
	$greave = intval($HTTP_POST_VARS['item_greave']);
	$boot = intval($HTTP_POST_VARS['item_boot']);
	$gloves = intval($HTTP_POST_VARS['item_gloves']);
	$amulet = intval($HTTP_POST_VARS['item_amulet']);
	$ring = intval($HTTP_POST_VARS['item_ring']);

	// Battle start infos gone into adr_functions_battle_setup.php
	include_once($phpbb_root_path . '/adr/includes/adr_functions_battle_setup.'.$phpEx);
	adr_battle_equip_initialise($user_id, $armor, $buckler, $helm, $gloves, $amulet, $ring, $greave, $boot);
	adr_battle_effects_initialise($user_id,0,'',0);

	// Update battle limit for user
	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_battle_limit = character_battle_limit - 1  
			WHERE character_id = $user_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle limit', '', __LINE__, __FILE__, $sql);
	}
}

// Let's sort out the start animations...
// Make table for start battle sequence...
// 0 = Standing image , 1 = Attack image
$user_action = 0; 
$monster_action = 0;

// Select again if the user has a battle in progress or no
$sql = " SELECT * FROM  " . ADR_BATTLE_LIST_TABLE . " 
	WHERE battle_challenger_id = $user_id
	AND battle_result = 0
	AND battle_type = 1 ";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
}
$bat = $db->sql_fetchrow($result);

// Get the monster infos
$monster = adr_get_monster_infos($bat['battle_opponent_id']);

// Get character infos
$challenger = adr_get_user_infos($user_id);

$user_ma = $bat['battle_challenger_magic_attack'];
$user_md = $bat['battle_challenger_magic_resistance'];
$monster_ma = $bat['battle_opponent_magic_attack'];
$monster_md = $bat['battle_opponent_magic_resistance'];
$challenger_element = $challenger['character_element'];
$opponent_element = $monster['monster_base_element'];
$loot_id = $bat['battle_opponent_id'];
$battle_round = $bat['battle_round'];

### START armour info arrays ###
// array info: 0=helm, 1=armour, 2=gloves, 3=buckler, 4=amulet, 5=ring, 6=hp_regen, 7=mp_regen
// V: 8 greave, 9 boot
$armour_info = explode('-', $bat['battle_challenger_equipment_info']);
$helm_equip = ($armour_info[0] != '') ? $armour_info[0] : 0;
$armour_equip = ($armour_info[1] != '') ? $armour_info[1] : 0;
$gloves_equip = ($armour_info[2] != '') ? $armour_info[2] : 0;
$buckler_equip = ($armour_info[3] != '') ? $armour_info[3] : 0;
$amulet_equip = ($armour_info[4] != '') ? $armour_info[4] : 0;
$ring_equip = ($armour_info[5] != '') ? $armour_info[5] : 0;
$greave_equip = ($armour_info[8] != '') ? $armour_info[8] : 0;
$boot_equip = ($armour_info[9] != '') ? $armour_info[9] : 0;
### END armour info arrays ###
### START restriction checks ###
$item_sql = adr_make_restrict_sql($challenger);
### END restriction checks ###
$challenger_intelligence = $bat['battle_challenger_intelligence'];
$opponent_message_enable = $bat['battle_opponent_message_enable'];
$opponent_message = $bat['battle_opponent_message'];

if (( is_numeric($bat['battle_id']) && $bat['battle_type'] == 1)
	&& ($petstuff || $attack || $spell || $potion || $defend || $flee || $equip || $spell2) )
{
	// Prefix challenger battle message
	$battle_message .= '<font color="blue">['.$lang['Adr_battle_msg_check'].htmlspecialchars($challenger['character_name']).']: </font>';
	if(($bat['battle_round'] == '0') && ($bat['battle_turn'] == '2')){
		$battle_message .= $monster['monster_name'].' '.$lang['Adr_battle_msg_monster_start'].'<br>';}
	if ( $invoc && $bat['battle_turn'] == 1 )
	{
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
		SET creature_invoc = 1
		WHERE owner_id = $user_id ";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, '', __LINE__, __FILE__, $usql);
		}
		adr_previous ( Adr_Rabbitoshi_invoc_succes , adr_battle , '' );
	} // end if pet invoc
	else if ( $scan && $bat['battle_turn'] == 1 )
	{
		// Check if pet have regeneration ability
		$mp_consumned = '0';
		$pet_regen = '0';
		if ( $rabbit_user['creature_ability'] == '1' )
		{
			if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
			{
				$mp_consumned = $rabbit_general['regeneration_mp_need'];
				$pet_regen = $rabbit_general['regeneration_hp_give'];
				$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
			}
			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
				SET creature_health = creature_health + " . intval($pet_regen) . ",
				    creature_mp = creature_mp - " . intval($mp_consumned) . "
				WHERE owner_id = $user_id ";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
			}
		}

		// Check if user a Amulet for HP regen this turn		
		if ( $bat['battle_challenger_hp'] != 0 )
		{
			if ( $challenger['character_hp'] < $challenger['character_hp_max'] )
			{
				$hp_regen = intval( adr_hp_regen_check( $user_id, $bat['battle_challenger_hp'] ) );
				$battle_message .= sprintf($lang['Adr_battle_regen_xp'], intval($hp_regen)).'<br />' ;
			}
		}

		// Check if user a Ring for MP regen this turn	
		if ( $bat['battle_challenger_mp'] != 0 )
		{
			if ( $challenger['character_mp'] < $challenger['character_mp_max'] )
			{
				$mp_regen = intval(adr_mp_regen_check( $user_id, $bat['battle_challenger_mp']));
				$battle_message .= sprintf($lang['Adr_battle_regen_mp'], intval($mp_regen)).'<br />' ;
			}
		}

		// Check if the scan failed or not
		$scan_dice = rand( 20 , 60 );
		$scan_success = ( $challenger_intelligence + $scan_dice );
		if ( $scan_success > 69 )
		{
			( $opponent_message_enable == '' ) ? $scan_message = '' . $lang['Adr_battle_scan_no_message'] . '' : $scan_message = '' . $lang['Adr_battle_scan_success'] . ' :<br />' . $opponent_message . '<br />';	
			$battle_message .= sprintf( $scan_message ).'<br />' ;
		}
		else
		{
			$battle_message .= sprintf( $lang['Adr_battle_scan_fail'] ).'<br />' ;
		}

		// Update the database
		$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
			SET battle_turn = 2 
			WHERE battle_challenger_id = $user_id
			AND battle_result = 0
			AND battle_type = 1 ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
		}
	} // end if scan
	else if ( $flee && $bat['battle_turn'] == 1 )
	{
		$dice = rand(1,20);
		$monster_dice = rand(1,20);

		// To flee you must roll higher than opponent or roll straight 20. 1= auto fail
		if((($dice > $monster_dice) && ($dice != '1')) || ($dice == '20') )
		{
			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_result = 3 ,
	            	battle_finish = ".time()." 
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if(!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);

			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_flees = (character_flees + 1)
				WHERE character_id = '$user_id'";
			if(!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);

			// Delete stolen items from users inventory
			$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_monster_thief = '1'
				AND item_owner_id = '$user_id'";
			if(!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not delete stolen items', '', __LINE__, __FILE__, $sql);

			// Delete broken items from users inventory
			$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_duration < '1'
				AND item_in_warehouse = '0'
				AND item_owner_id = '$user_id'";
			if(!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not delete broken items', '', __LINE__, __FILE__, $sql);
			// Pet part
           	if( $rabbit_user['creature_invoc']=='1' )
           	{
         		// Set invoc default stats
	   			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					Set creature_invoc = '0'
				WHERE owner_id = $user_id ";	
				if (!$result = $db->sql_query($sql)) 
				{
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}

	         	// Set default pet health statut
	          	if( $rabbit_user['creature_statut']=='4' )
	           	{
		   			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
						Set creature_statut = '0'
					WHERE owner_id = $user_id ";	
					if (!$result = $db->sql_query($sql)) 
					{
						message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
					}
				}
			}
			$message = sprintf($lang['Adr_battle_flee'], $challenger['character_name']);
			$message .= '<br /><br />'.sprintf($lang['Adr_battle_return'], "<a href=\"" . 'adr_battle.'.$phpEx . "\">", "</a>");
			$message .= '<br /><br />'.sprintf($lang['Adr_character_return'], "<a href=\"" . 'adr_character.'.$phpEx . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
		else{
			// Check if pet have regeneration ability
			$mp_consumned = '0';
			$pet_regen = '0';
			if ( $rabbit_user['creature_ability'] == '1' )
			{
				if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
				{
					$mp_consumned = $rabbit_general['regeneration_mp_need'];
					$pet_regen = $rabbit_general['regeneration_hp_give'];
					$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
				}
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = creature_health + " . intval($pet_regen) . ",
					    creature_mp = creature_mp - " . intval($mp_consumned) . "
					WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}

			// If flee attempt fails
			// Create failure message
			$battle_message .= sprintf($lang['Adr_battle_flee_fail'], $challenger['character_name']).'<br>';

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_turn = 2, battle_round = (battle_round + 1)
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if(!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
		}
	} // end if flee
	else if ( $spell && $bat['battle_turn'] == 1 )
	{
		// Define the weapon quality and power
		$item_spell = intval($HTTP_POST_VARS['item_spell']);
		$power = 0;
		$damage = 0;

		if ( $item_spell )
		{
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_in_shop = 0 
				AND item_in_warehouse = 0
				AND item_owner_id = $user_id 
				AND item_duration > 0
				$item_sql
				AND item_id = $item_spell ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$item = $db->sql_fetchrow($result);

			if ( $challenger['character_mp'] < ($item['item_mp_use'] + $item['item_power']) || $challenger['character_mp'] < 0 ) 
			{	
				adr_previous ( Adr_battle_check , 'adr_battle' , '' );
			}
         	$dice = rand(0,5);
			$power = (($item['item_power']) + $item['item_add_power'] + $dice);
			$mp_usage = $item['item_power'] + $item['item_mp_use'];
			if ( $mp_usage == '' )
			{
      			adr_previous ( Adr_battle_check , 'adr_battle' , '' );				
			}

			//adr_use_item($item_spell , $user_id);
			
			// Substract the magic points
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_mp = character_mp - $mp_usage
				WHERE character_id = $user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
		} // end if item_spell

		if ( $item['item_type_use'] == 11 )
		{
			// Sort out magic check & opponents saving throw
			$dice = rand(1,20);
			$monster['monster_wisdom'] = (10 + (rand(1, $monster['monster_level']) *2)); //temp calc
			$magic_check = ceil($dice + $item['item_power'] + adr_modifier_calc($challenger['character_intelligence']));
			$fort_save = (11 + adr_modifier_calc($monster['monster_wisdom']));
			$diff = ((($magic_check >= $fort_save) && ($dice != '1')) || ($dice == '20')) ? TRUE : FALSE;
			$power = ($power + adr_modifier_calc($challenger['character_intelligence']));

			// Grab details for Elemental infos
			$elemental = adr_get_element_infos($opponent_element);
			$element_name = adr_get_element_infos($item['item_element']);

			// Here we apply text colour if set
			if($element_name['element_colour'] != ''){
				$item['item_name'] = '<font color="'.$element_name['element_colour'].'">'.$item['item_name'].'</font>';
			}
			else{
				$item['item_name'] = $item['item_name'];
			}

			##=== START: Critical hit code
			$threat_range = ($item['item_type_use'] == '6') ? '19' : '20'; // magic weaps get slightly better threat range
			$crit_result = adr_battle_make_crit_roll($bat['battle_challenger_att'], $challenger['character_level'], $bat['battle_opponent_def'], $item['item_type_use'], $power, $quality, $threat_range);
			##=== END: Critical hit code

			// Check if pet have regeneration ability
			$mp_consumned = '0';
			$pet_regen = '0';
			if ( $rabbit_user['creature_ability'] == '1' )
			{
				if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
				{
					$mp_consumned = $rabbit_general['regeneration_mp_need'];
					$pet_regen = $rabbit_general['regeneration_hp_give'];
					$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
				}
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = creature_health + " . intval($pet_regen) . ",
					    creature_mp = creature_mp - " . intval($mp_consumned) . "
					WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}

			if((($diff === TRUE) && ($dice != '1')) || ($dice == '20')){
				$damage = 1;

				// Work out attack type
				if(($item['item_element']) && ($item['item_element'] === $elemental['element_oppose_strong']) && ($item['item_duration'] > '1') && (!empty($item['item_name']))){
					$damage = ceil(($power *($item['item_element_weak_dmg'] /100)));
				}
				elseif(($item['item_element']) && (!empty($item['item_name'])) && ($item['item_element'] === $opponent_element) && ($item['item_duration'] > '1')){
					$damage = ceil(($power *($item['item_element_same_dmg'] /100)));
				}
				elseif(($item['item_element']) && (!empty($item['item_name'])) && ($item['item_element'] === $elemental['element_oppose_weak']) && ($item['item_duration'] > '1')){
					$damage = ceil(($power *($item['item_element_str_dmg'] /100)));
				}
				else{
					$damage = ceil($power);
				}

				// Fix dmg value
				$damage = ($damage < '1') ? rand(1,3) : $damage;
				$damage = ($damage > $bat['battle_opponent_hp']) ? $bat['battle_opponent_hp'] : $damage;

				// Fix attack msg type
				if(($item['item_element'] > '0') && ($element_name['element_name'] != '')){
					$battle_message .= sprintf($lang['Adr_battle_spell_success'], $challenger['character_name'], $item['item_name'], adr_get_lang($element_name['element_name']), $damage, $monster['monster_name']).'<br>';}
				else{
					$battle_message .= sprintf($lang['Adr_battle_spell_success_norm'], $challenger['character_name'], $item['item_name'], $damage, $monster['monster_name']).'<br>';}
			}
			else{
				$damage = 0;
				$battle_message .= sprintf( $lang['Adr_battle_spell_failure'], $challenger['character_name'], $item_name, $monster['monster_name']).'<br />';
			}

			if ( $item['item_duration'] < 2 )
			{
				$battle_message .= '</span><span class="gensmall">'; // set new span class
				$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_battle_spell_dura'], $challenger['character_name'], $item['item_name']).'<br>';
				$battle_message .= '</span><span class="genmed">'; // reset span class to default
			}

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_hp = battle_opponent_hp - $damage ,
					battle_challenger_dmg = $damage , 
					battle_turn = 2 ,
					battle_round = (battle_round + 1)
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
			// Let's sort out the spell (attack) animations...
			// Make table for battle sequence...
			// 0 = Standing image , 1 = Attack image
			$user_action = 1; 
			$monster_action = 1;
			$attack_img = $item['item_name'];
			$attackwith_overlay = ((file_exists("adr/images/battle/spells/".$attack_img.".gif"))) ? '<img src="adr/images/battle/spells/'.$attack_img.'.gif" width="256" height="96" border="0">' : '';
		} // end if item type 11

		else if ( $item['item_type_use'] == 12 )
		{
			// Check if pet have regeneration ability
			$mp_consumned = '0';
			$pet_regen = '0';
			if ( $rabbit_user['creature_ability'] == '1' )
			{
				if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
				{
					$mp_consumned = $rabbit_general['regeneration_mp_need'];
					$pet_regen = $rabbit_general['regeneration_hp_give'];
					$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
				}
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = creature_health + " . intval($pet_regen) . ",
					    creature_mp = creature_mp - " . intval($mp_consumned) . "
					WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}

			// Create battle message
			$battle_message .= sprintf($lang['Adr_battle_spell_defensive_success'], $challenger['character_name'], $item['item_name'], $power).'<br>';
			if($item['item_duration'] < '2'){
				$battle_message .= '</span><span class="gensmall">'; // set new span class
				$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_battle_spell_def_dura'], $challenger['character_name'], $item['item_name']).'<br>';
				$battle_message .= '</span><span class="genmed">'; // reset span class to default
			}

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_challenger_att = battle_challenger_att + $power ,
					battle_challenger_def = battle_challenger_def + $power ,
					battle_turn = 2,
					battle_round = (battle_round + 1) 
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
			// Let's sort out the spell (defence) animations...
			// Make table for start battle sequence...
			// 0 = Standing image , 1 = Attack image
			$user_action = 0; 
			$monster_action = 1;
			$attack_img = $item['item_name'];
			$attackwith_overlay = ((file_exists("adr/images/battle/spells/".$attack_img.".gif"))) ? '<img src="adr/images/battle/spells/'.$attack_img.'.gif" width="256" height="96" border="0">' : '';
		} // end if item type 12
	} // end if spell
	else if ( $spell2 && $bat['battle_turn'] == 1 )
	{
		// Define the weapon quality and power
		$item_spell2 = intval($HTTP_POST_VARS['item_spell2']);
		$power = 0;
		$damage = 0;

		if ( $item_spell2 )
		{
			$sql = " SELECT spell_name , spell_power , item_type_use , spell_add_power , spell_mp_use , spell_element , spell_element_str_dmg, spell_element_weak_dmg , spell_element_same_dmg FROM " . ADR_SHOPS_SPELLS_TABLE . "
				WHERE spell_owner_id = $user_id 
				AND spell_id = $item_spell2 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$spell = $db->sql_fetchrow($result);

			if ( $challenger['character_mp'] < ($spell['spell_mp_use'] + $spell['spell_power']) || $challenger['character_mp'] < 0 ) 
			{	
				adr_previous ( Adr_battle_check_two , 'adr_battle' , '' );
			}

			$power = (($spell['spell_power'] * 1.2) + $spell['spell_add_power']);
			$mp_usage = $spell['spell_mp_use'];
			if ( $mp_usage == '' )
			{
      				adr_previous ( Adr_battle_check , 'adr_battle' , '' );				
			}

			adr_use_item($item_spell2 , $user_id);
			
			// Substract the magic points
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_mp = character_mp - $mp_usage
				WHERE character_id = $user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
		} // end if item_spell2

		if ( $spell['item_type_use'] == 11 )
		{
			// Sort out magic check & opponents saving throw
			$dice = rand(1,20);
			$monster['monster_wisdom'] = (10 + (rand(1, $monster['monster_level']) *2)); //temp calc
			$magic_check = ceil($dice + $item['item_power'] + adr_modifier_calc($challenger['character_intelligence']));
			$fort_save = (11 + adr_modifier_calc($monster['monster_wisdom']));
			$diff = ((($magic_check >= $fort_save) && ($dice != '1')) || ($dice == '20')) ? TRUE : FALSE;
			$power = ($power + adr_modifier_calc($challenger['character_intelligence']));

			// Grab details for Elemental infos
			$elemental = adr_get_element_infos($opponent_element);
			$element_name = ($spell['spell_name'] != '') ? adr_get_element_infos($spell['spell_element']) : '';

			// Here we apply text colour if set
			if($element_name['element_colour'] != ''){
				$spell['spell_name'] = '<font color="'.$element_name['element_colour'].'">'.adr_get_lang($spell['spell_name']).'</font>';}
			else{
				$spell['spell_name'] = adr_get_lang($spell['spell_name']);}

			if((($diff === TRUE) && ($dice != '1')) || ($dice == '20')){
				$damage = 1;

				// Work out attack type
				if(($spell['spell_element']) && ($spell['spell_element'] === $elemental['element_oppose_strong']) && (!empty($spell['spell_name']))){
					$damage = ceil(($power *($spell['spell_element_weak_dmg'] /100)));
				}
				elseif(($spell['spell_element']) && (!empty($spell['spell_name'])) && ($spell['spell_element'] === $opponent_element)){
					$damage = ceil(($power *($spell['spell_element_same_dmg'] /100)));
				}
				elseif(($spell['spell_element']) && (!empty($spell['spell_name'])) && ($spell['spell_element'] === $elemental['element_oppose_weak'])){
					$damage = ceil(($power *($spell['spell_element_str_dmg'] /100)));
				}
				else{
					$damage = ceil($power);
				}


				// Fix dmg value
				$damage = ($damage < '1') ? rand(1,3) : $damage;
				$damage = ($damage > $bat['battle_opponent_hp']) ? $bat['battle_opponent_hp'] : $damage;

				// Fix attack msg type
				if(($spell['spell_element'] > '0') && ($element_name['element_name'] != '')){
					$battle_message .= sprintf($lang['Adr_battle_spell_success'], $challenger['character_name'], $spell['spell_name'], adr_get_lang($element_name['element_name']), $damage, $monster['monster_name']).'<br>';}
				else{
					$battle_message .= sprintf($lang['Adr_battle_spell_success_norm'], $challenger['character_name'], $spell['spell_name'], $damage, $monster['monster_name']).'<br>';}
			}
			else{
				$damage = 0;
				$battle_message .= sprintf( $lang['Adr_battle_spell_failure'], $challenger['character_name'], $spell['spell_name'], $monster['monster_name']).'<br />';
			}

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_hp = battle_opponent_hp - $damage ,
					battle_challenger_dmg = $damage , 
					battle_turn = 2 ,
					battle_round = (battle_round + 1)
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
		} // end if item type 11

		if ( $spell['item_type_use'] == 108 )
		{
			// New HP check required after regeneration
			$sql = "SELECT character_hp, character_hp_max FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = $user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query user', '', __LINE__, __FILE__, $sql);
			}
			$hp_check = $db->sql_fetchrow($result);

			$power = ( $power > ( $hp_check['character_hp_max'] - $hp_check['character_hp'] ) ) ? ( $hp_check['character_hp_max'] - $hp_check['character_hp'] ) : $power ;

			$battle_message .= sprintf($lang['Adr_battle_healing_success'] ,$challenger['character_name'], adr_get_lang($spell['spell_name']) , $power ).'<br />' ; 

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_turn = 2,
					battle_round = (battle_round + 1)
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}

			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_hp = character_hp + $power
				WHERE character_id = $user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
		} // end if item type 108
	
		else if ( $spell['item_type_use'] == 12 )
		{
			$battle_message .= sprintf($lang['Adr_battle_spell_defensive_success'], $challenger['character_name'], $spell['spell_name'], $power).'<br>';

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_challenger_att = battle_challenger_att + $power ,
					battle_challenger_def = battle_challenger_def + $power ,
					battle_turn = 2,
					battle_round = (battle_round + 1)
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
		} // end if item type 12
	} // end if spell2
	else if ( $potion && $bat['battle_turn'] == 1 )
	{
		// Define the weapon quality and power
		$item_potion = intval($HTTP_POST_VARS['item_potion']);
		$power = 1;

		if ( $item_potion )
		{
			$sql = " SELECT *
				FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_in_shop = 0 
					AND item_in_warehouse = 0
					AND item_duration > 0
					$item_sql
					AND item_owner_id = $user_id 
					AND item_id = $item_potion ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$item = $db->sql_fetchrow($result);

			if ( $challenger['character_mp'] < 0 ) 
			{	
				adr_previous ( Adr_battle_check , 'adr_battle' , '' );
			}

			$power = ($item['item_power'] + $item['item_add_power']);
			$item['item_name'] = adr_get_lang($item['item_name']);

			adr_use_item($item_potion , $user_id);
		} // end if item_potion

		if ( $item['item_type_use'] == 15 )
		{
			// Check if pet have regeneration ability
			$mp_consumned = '0';
			$pet_regen = '0';
			if ( $rabbit_user['creature_ability'] == '1' )
			{
				if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
				{
					$mp_consumned = $rabbit_general['regeneration_mp_need'];
					$pet_regen = $rabbit_general['regeneration_hp_give'];
					$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
				}
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = creature_health + " . intval($pet_regen) . ",
					    creature_mp = creature_mp - " . intval($mp_consumned) . "
					WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}

			// New HP check required after regeneration
			$sql = "SELECT character_hp, character_hp_max FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = $user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query user', '', __LINE__, __FILE__, $sql);
			}
			$hp_check = $db->sql_fetchrow($result);

			if ( $item['item_duration'] < 2 && $power > 0 && $hp_check['character_hp'] < $hp_check['character_hp_max'] )
			{
				$power = ( $power > ( $hp_check['character_hp_max'] - $hp_check['character_hp'] ) ) ? ( $hp_check['character_hp_max'] - $hp_check['character_hp'] ) : $power ;
				$battle_message .= sprintf($lang['Adr_battle_potion_hp_dura'] , adr_get_lang($item['item_name']) , $power , adr_get_lang($item['item_name']) ).'<br />' ;					
			}
			elseif ( $item['item_duration'] < 2 && $power < 1 && $hp_check['character_hp'] < $hp_check['character_hp_max'] )
			{	
				$power = 0;
				$battle_message .= sprintf($lang['Adr_battle_potion_hp_dura_none'] , adr_get_lang($item['item_name']) , adr_get_lang($item['item_name'])).'<br />' ;					
			}
			elseif ( $item['item_duration'] > 1 && $power > 0 && $hp_check['character_hp'] < $hp_check['character_hp_max'] )
			{
				$power = ( $power > ( $hp_check['character_hp_max'] - $hp_check['character_hp'] ) ) ? ( $hp_check['character_hp_max'] - $hp_check['character_hp'] ) : $power ;
				$battle_message .= sprintf($lang['Adr_battle_potion_hp_success'] , adr_get_lang($item['item_name']) , $power ).'<br />' ;
			}
			elseif ( $item['item_duration'] > 1 && $power < 1 && $hp_check['character_hp'] < $hp_check['character_hp_max'] )
			{
				$power = 0;
				$battle_message .= sprintf($lang['Adr_battle_potion_hp_success_none'] , adr_get_lang($item['item_name'])).'<br />' ;					
			}
			else
			{
				$power = 0;

				if ( $item['item_duration'] < 2 )
				{
					$battle_message .= sprintf($lang['Adr_battle_potion_hp_dura_none'] , adr_get_lang($item['item_name']) , adr_get_lang($item['item_name'])).'<br />' ;				
				}
				else
				{
					$battle_message .= sprintf($lang['Adr_battle_potion_hp_success_none'] , adr_get_lang($item['item_name'])).'<br />' ;						
				}
			}

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_turn = 2 
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}

			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_hp = character_hp + $power
				WHERE character_id = $user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
			// Let's sort out the potion (hp) animations...
			// Make table for start battle sequence...
			// 0 = Standing image , 1 = Attack image
			$user_action = 0; 
			$monster_action = 1;
			$attack_img = $item['item_name'];
			$attackwith_overlay = ((file_exists("adr/images/battle/spells/".$attack_img.".gif"))) ? '<img src="adr/images/battle/spells/'.$attack_img.'.gif" width="256" height="96" border="0">' : '';
		} // end if item type 15
		else if ( $item['item_type_use'] == 16 )
		{
			// Check if pet have regeneration ability
			$mp_consumned = '0';
			$pet_regen = '0';
			if ( $rabbit_user['creature_ability'] == '1' )
			{
				if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
				{
					$mp_consumned = $rabbit_general['regeneration_mp_need'];
					$pet_regen = $rabbit_general['regeneration_hp_give'];
					$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
				}
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = creature_health + " . intval($pet_regen) . ",
					    creature_mp = creature_mp - " . intval($mp_consumned) . "
					WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}

			if(($item['item_duration'] > '0') && ($challenger['character_mp'] < $challenger['character_mp_max'])){
				$power = ($power < '1') ? rand(1,3) : $power;
				$power = (($power + $challenger['character_mp']) > $challenger['character_mp_max']) ? ($challenger['character_mp_max'] - $challenger['character_mp']) : $power;
				$battle_message .= sprintf($lang['Adr_battle_potion_mp_success'], $challenger['character_name'], adr_get_lang($item['item_name']), $power).'<br>';

				$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
					SET character_mp = (character_mp + $power)
					WHERE character_id = '$user_id'";
				if(!($result = $db->sql_query($sql))){
					message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}

				// Use item
				adr_use_item($item_potion, $user_id);
			}
			elseif(($item['item_duration'] > '0') && ($challenger['character_mp'] >= $challenger['character_mp_max'])){
				$power = 0;
				$battle_message .= sprintf($lang['Adr_battle_potion_mp_success_none'], $challenger['character_name'], adr_get_lang($item['item_name'])).'<br>';
			}

			// low dura message
			if(($item['item_duration'] < '2') && ($power > '0')){
				$battle_message .= '</span><span class="gensmall">'; // set new span class
				$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_battle_potion_mp_dura_none'], $challenger['character_name'], adr_get_lang($item['item_name']), adr_get_lang($item['item_name'])).'<br>';
				$battle_message .= '</span><span class="genmed">'; // reset span class to default
			}

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_turn = 2,
					battle_round = (battle_round + 1)
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
			// Let's sort out the potion (mp) animations...
			// Make table for start battle sequence...
			// 0 = Standing image , 1 = Attack image
			$user_action = 0; 
			$monster_action = 1;
			$attack_img = $item['item_name'];
			$attackwith_overlay = ((file_exists("adr/images/battle/spells/".$attack_img.".gif"))) ? '<img src="adr/images/battle/spells/'.$attack_img.'.gif" width="256" height="96" border="0">' : '';
		} // end if item type 16
		else if ( $item['item_type_use'] == 19 )
		{
			// Check if pet have regeneration ability
			$mp_consumned = '0';
			$pet_regen = '0';
			if ( $rabbit_user['creature_ability'] == '1' )
			{
				if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
				{
					$mp_consumned = $rabbit_general['regeneration_mp_need'];
					$pet_regen = $rabbit_general['regeneration_hp_give'];
					$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
				}
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = creature_health + " . intval($pet_regen) . ",
					    creature_mp = creature_mp - " . intval($mp_consumned) . "
					WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}

			include_once($phpbb_root_path . '/adr/includes/adr_functions_battle_setup.'.$phpEx);
			$e_message = adr_battle_effects_initialise($user_id,$item_potion,$monster['monster_name'],0);
			
			// Use item
			adr_use_item($item_potion, $user_id);

			$battle_message .= $e_message;

			// low dura message
			if(($item['item_duration'] < '2') && ($power > '0')){
				$battle_message .= '</span><span class="gensmall">'; // set new span class
				$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_battle_potion_mp_dura_none'], $challenger['character_name'], adr_get_lang($item['item_name']), adr_get_lang($item['item_name'])).'<br>';
				$battle_message .= '</span><span class="genmed">'; // reset span class to default
			}
			
			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_turn = 2,
					battle_round = (battle_round + 1)
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
			// Let's sort out the potion (mp) animations...
			// Make table for start battle sequence...
			// 0 = Standing image , 1 = Attack image
			$user_action = 0; 
			$monster_action = 1;
			$attack_img = $item['item_name'];
			$attackwith_overlay = ((file_exists("adr/images/battle/spells/".$attack_img.".gif"))) ? '<img src="adr/images/battle/spells/'.$attack_img.'.gif" width="256" height="96" border="0">' : '';
		} // end if item type 19
	} // end if potion
	else if ( $pet_specialattack && $bat['battle_turn'] == 1 )
	{
		if ( ($rabbit_user['creature_attack'] > 0) && ($rabbit_user['creature_health'] > 0) )
		{
			$poison = '0';
			$pet_regen = '0';
			$mp_consumned = '0';
			$pet_damage = '0';
			$health_give = '0';
			$mana_give = '0';

			if ( $rabbit_user['creature_ability'] == '0' ) //pet have no special ability
			{ adr_previous ( Adr_battle_pet_noability , 'adr_battle' , '' ); }


			if ( $rabbit_user['creature_ability'] == '1' ) //pet have regeneration ability
			{ adr_previous ( Adr_battle_pet_regeneration_mess , 'adr_battle' , '' ); }

			if ( $rabbit_user['creature_ability'] == '2' ) //pet have health transfert ability
			{
				$health_give = ( ($rabbit_user['creature_health'] * $rabbit_general['health_transfert_percent'] ) / 100 );
				$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_pet_health_transfert'], intval($health_give)).'<br />' ;
			}

			if ( $rabbit_user['creature_ability'] == '3' ) //pet have mana transfert ability
			{
				$mana_give = ( ($rabbit_user['creature_mp'] * $rabbit_general['mana_transfert_percent'] ) / 100 );
				$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_pet_mana_transfert'], intval($mana_give)).'<br />' ;
			}

			if ( $rabbit_user['creature_ability'] == '4' ) //pet have sacrifice ability
			{
				$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + ($rabbit_user['creature_health'] * rand(1,3)) );
				$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_pet_sacrifice'], intval($pet_damage)).'<br />' ;
			}

			// Check if pet have regeneration ability
			if ( $rabbit_user['creature_ability'] == '1' )
			{
				if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
				{
					$mp_consumned = $rabbit_general['regeneration_mp_need'];
					$pet_regen = $rabbit_general['regeneration_hp_give'];
					$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
				}
			}

			// Check if pet is poisonned
			if ( $rabbit_user['creature_statut'] == '3' )
			{
				if ( $rabbit_user['creature_health'] > 0 )
				{
					$poison = rand(1,3);
					if ( ($rabbit_user['creature_health'] - $poison) < 0 )
					{
						$poison = ($rabbit_user['creature_health_max'] - $rabbit_user['creature_health']);
					}
					$battle_message .= sprintf($lang['Adr_battle_pet_poison'], intval($poison)).'<br />' ;
				}
			}

			// Check if user a Amulet for HP regen this turn
			if ( $bat['battle_challenger_hp'] != 0 )
			{
				if ( $challenger['character_hp'] < $challenger['character_hp_max'] )
				{
					$hp_regen = intval( adr_hp_regen_check( $user_id, $bat['battle_challenger_hp'] ) );
					$battle_message .= sprintf($lang['Adr_battle_regen_xp'], intval($hp_regen)).'<br />' ;
				}
			}

			// Check if user a Ring for MP regen this turn
			if ( $bat['battle_challenger_mp'] != 0 )
			{
				if ( $challenger['character_mp'] < $challenger['character_mp_max'] )
				{
					$mp_regen = intval(adr_mp_regen_check( $user_id, $bat['battle_challenger_mp']));
					$battle_message .= sprintf($lang['Adr_battle_regen_mp'], intval($mp_regen)).'<br />' ;
				}
			}

			$hp_changes = (($poison + $health_give) - $pet_regen );
			$mp_changes = ($mp_consumned + $mana_give);

			if ( $hp_changes < 0 )
			{
				$hp_changes = ( $rabbit_user['creature_health_max'] - $rabbit_user['creature_health'] );
			}
			if ( $mp_changes < 0 )
			{
				$mp_changes = ( $rabbit_user['creature_max_mp'] - $rabbit_user['creature_mp'] );
			}
			if ( $rabbit_user['creature_ability'] == '4' )
			{
				$hp_changes = ( $rabbit_user['creature_health_max'] - $rabbit_user['creature_health'] );
			}

			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
				SET creature_health = creature_health - $hp_changes,
				    creature_mp = creature_mp - $mp_changes
				WHERE owner_id = $user_id ";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
			}

			if ( ($challenger['character_hp'] + $health_give ) > $challenger['character_hp_max'] )
			{
				$health_give = ( $challenger['character_hp_max'] - $challenger['character_hp'] );
			}

			if ( ($challenger['character_mp'] + $mana_give ) > $challenger['character_mp_max'] )
			{
				$mana_give = ( $challenger['character_mp_max'] - $challenger['character_mp'] );
			}

	         	$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . "
		            	SET character_hp = character_hp + $health_give,
	                	    character_mp = character_mp + $mana_give
		            	WHERE character_id = $user_id ";
	         	if( !($result = $db->sql_query($sql)) ) {
		               	message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
	         	}

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_hp = battle_opponent_hp - '$pet_damage',
				    battle_turn = 2 ,
				    battle_challenger_dmg = '$pet_damage'
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if( !($result = $db->sql_query($sql)) ) {
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
		} // end if attack / dead
		else {
			adr_previous ( Adr_battle_pet_dead_or_limitattack , 'adr_battle' , '' );
		}
	} // end if pet special attack

	else if ( $pet_attack && $bat['battle_turn'] == 1 )
	{
		$pet_poison = '0';
		if ( ($rabbit_user['creature_attack'] > 0) && ($rabbit_user['creature_health'] > 0) )
		{
			if ( $rabbit_user['creature_statut'] == '0' ) //pet in good health
			{
				$pet_dice = rand(0,20);
				if ( $pet_dice == '20' ) //define critical hit
				{
					$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + (rand(2,5)*3) );
					$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)).'<br />' ;
				}
				else  {
					$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(1,5) );
					$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)).'<br />' ;
				}
			}

			if ( $rabbit_user['creature_statut'] == '1' ) //pet is sad
			{
				$pet_dice = rand(0,20);
				if ( $pet_dice == '20' ) //define critical hit
				{
					$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(2,10) );
					$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)).'<br />' ;
				}
				else {
					$pet_damage = ( $rabbit_user['creature_power']* $rabbit_user['creature_level'] + rand(0,3));
					$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)).'<br />' ;
				}
			}

			if ( $rabbit_user['creature_statut'] == '2' ) //pet is hill
			{
				$pet_dice = rand(0,20);
				if ( $pet_dice == '20' ) //define critical hit
				{
					$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(1,5) );
					$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)).'<br />' ;
				}
				else {
					$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) - rand(0,3) );
					$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)).'<br />' ;
				}
			}

			if ( $rabbit_user['creature_statut'] == '3' ) //pet is poisoned
			{
				$pet_dice = rand(0,20);
				if ( $pet_dice == '20' ) //define critical hit
				{
					$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + (rand(2,5)*4) );
					$poison = rand(0,5);
					$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)).'<br />' ;
					$battle_message .= sprintf($lang['Adr_battle_pet_poison'], intval($poison)).'<br />' ;
				}
				else {
					$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(0,3) );
					$poison = rand(0,3);
					$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)).'<br />' ;
					$battle_message .= sprintf($lang['Adr_battle_pet_poison'], intval($poison)).'<br />' ;
				}
			}

			if ( $rabbit_user['creature_statut'] == '4' ) //pet is furious
			{
				$pet_dice = rand(0,20);
				if ( $pet_dice == '20' ) //define critical hit
				{
					$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + (rand(2,5)*5) );
					$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)).'<br />' ;
				}
				else {
					$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(0,10) );
					$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)).'<br />' ;
				}
			}

			// Check if pet have regeneration ability
			$mp_consumned = '0';
			if ( $rabbit_user['creature_ability'] == '1' )
			{
				if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
				{
					$mp_consumned = $rabbit_general['regeneration_mp_need'];
					$pet_regen = $rabbit_general['regeneration_hp_give'];
					$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
				}
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = creature_health + " . intval($pet_regen) . ",
					    creature_mp = creature_mp - " . intval($mp_consumned) . "
					WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}

			// Check if user a Amulet for HP regen this turn
			if ( $bat['battle_challenger_hp'] != 0 )
			{
				if ( $challenger['character_hp'] < $challenger['character_hp_max'] )
				{
					$hp_regen = intval( adr_hp_regen_check( $user_id, $bat['battle_challenger_hp'] ) );
					$battle_message .= sprintf($lang['Adr_battle_regen_xp'], intval($hp_regen)).'<br />' ;
				}
			}

			// Check if user a Ring for MP regen this turn
			if ( $bat['battle_challenger_mp'] != 0 )
			{
				if ( $challenger['character_mp'] < $challenger['character_mp_max'] )
				{
					$mp_regen = intval(adr_mp_regen_check( $user_id, $bat['battle_challenger_mp']));
					$battle_message .= sprintf($lang['Adr_battle_regen_mp'], intval($mp_regen)).'<br />' ;
				}
			}

			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
				SET creature_health = creature_health - '$poison',
				    creature_attack = (creature_attack - 1)
				WHERE owner_id = $user_id ";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
			}

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_hp = battle_opponent_hp - '$pet_damage',
				    battle_turn = 2 ,
				    battle_challenger_dmg = '$pet_damage'
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if( !($result = $db->sql_query($sql)) ) {
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
		} // end if pet is dead / cant attack
		else {
			adr_previous ( Adr_battle_pet_dead_or_limitattack , 'adr_battle' , '' );
		}
	} // end if pet attack

	else if ( $pet_magicattack && $bat['battle_turn'] == 1 )
	{
		if ( ($rabbit_user['creature_magicattack'] > 0) && ($rabbit_user['creature_health'] > 0) )
		{
			$pet_poison = '0';
			$price_mp = (rand($rabbit_general['mp_min'],$rabbit_general['mp_max'])* $rabbit_user['creature_level']);

			if ( $rabbit_user['creature_statut'] == '0' ) //pet in good health
			{
				if ( $rabbit_user['creature_mp'] > $price_mp ) //define if pet have enough mp
				{
					$pet_dice = rand(0,20);

					if ( $pet_dice == '20' ) //define critical hit
					{
						$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + (rand(2,5)*5) );
						$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)).'<br />' ;
					}
					else {
						$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(3,8) );
						$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)).'<br />' ;
					}
				}
				else {
					adr_previous ( Adr_battle_pet_mp_lack , 'adr_battle' , '' );
				}
			}

			if ( $rabbit_user['creature_statut'] == '1' ) //pet is sad
			{
				if ( $rabbit_user['creature_mp'] > $price_mp ) //define if pet have enough mp
				{
					$pet_dice = rand(0,20);

					if ( $pet_dice == '20' ) //define critical hit
					{
						$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(5,15) );
						$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)).'<br />' ;
					}
					else {
						$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(2,5) );
						$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)).'<br />' ;
					}
				}
				else {
					adr_previous ( Adr_battle_pet_mp_lack , 'adr_battle' , '' );
				}
			}

			if ( $rabbit_user['creature_statut'] == '2' ) //pet is hill
			{
				if ( $rabbit_user['creature_mp'] > $price_mp ) //define if pet have enough mp
				{
					$pet_dice = rand(0,20);

					if ( $pet_dice == '20' ) //define critical hit
					{
						$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(3,8) );
						$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)).'<br />' ;
					}
					else {
						$pet_damage = ($rabbit_user['creature_power']* $rabbit_user['creature_level']);
						$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)).'<br />' ;
					}
				}
				else {
					adr_previous ( Adr_battle_pet_mp_lack , 'adr_battle' , '' );
				}
			}

			if ( $rabbit_user['creature_statut'] == '3' ) //pet is poisoned
			{
				if ( $rabbit_user['creature_mp'] > $price_mp ) //define if pet have enough mp
				{
					$pet_dice = rand(0,20);

					if ( $pet_dice == '20' ) //define critical hit
					{
						$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + (rand(2,5)*5) );
						$poison = rand(0,5);
						$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)).'<br />' ;
						$battle_message .= sprintf($lang['Adr_battle_pet_poison'], intval($poison)).'<br />' ;
					}
					else {
						$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(3,8) );
						$poison = rand(0,3);
						$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)).'<br />' ;
						$battle_message .= sprintf($lang['Adr_battle_pet_poison'], intval($poison)).'<br />' ;
					}
				}
				else {
					adr_previous ( Adr_battle_pet_mp_lack , 'adr_battle' , '' );
				}
			}

			if ( $rabbit_user['creature_statut'] == '4' ) //pet is furious
			{
				if ( $rabbit_user['creature_mp'] > $price_mp ) //define if pet have enough mp
				{
					$pet_dice = rand(0,20);

					if ( $pet_dice == '20' ) //define critical hit
					{
						$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + (rand(3,8)*6) );
						$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)).'<br />' ;
					}
					else {
						$pet_damage = ( ($rabbit_user['creature_power']* $rabbit_user['creature_level']) + rand(5,10) );
						$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)).'<br />' ;
					}
				}
				else {
					adr_previous ( Adr_battle_pet_mp_lack , 'adr_battle' , '' );
				}
			}

			// Check if pet have regeneration ability
			$mp_consumned = '0';
			if ( $rabbit_user['creature_ability'] == '1' )
			{
				if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
				{
					$mp_consumned = $rabbit_general['regeneration_mp_need'];
					$pet_regen = $rabbit_general['regeneration_hp_give'];
					$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
				}
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = creature_health + " . intval($pet_regen) . ",
					    creature_mp = creature_mp - " . intval($mp_consumned) . "
					WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}

			// Check if user a Amulet for HP regen this turn
			if ( $bat['battle_challenger_hp'] != 0 )
			{
				if ( $challenger['character_hp'] < $challenger['character_hp_max'] )
				{
					$hp_regen = intval( adr_hp_regen_check( $user_id, $bat['battle_challenger_hp'] ) );
					$battle_message .= sprintf($lang['Adr_battle_regen_xp'], intval($hp_regen)).'<br />' ;
				}
			}

			// Check if user a Ring for MP regen this turn
			if ( $bat['battle_challenger_mp'] != 0 )
			{
				if ( $challenger['character_mp'] < $challenger['character_mp_max'] )
				{
					$mp_regen = intval(adr_mp_regen_check( $user_id, $bat['battle_challenger_mp']));
					$battle_message .= sprintf($lang['Adr_battle_regen_mp'], intval($mp_regen)).'<br />' ;
				}
			}

			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
				SET creature_health = creature_health - '$poison',
				    creature_mp = creature_mp - '$price_mp',
				    creature_magicattack = (creature_magicattack - 1)
				WHERE owner_id = $user_id ";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
			}

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_hp = battle_opponent_hp - '$pet_damage',
				    battle_turn = 2 ,
				    battle_challenger_dmg = '$pet_damage'
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if( !($result = $db->sql_query($sql)) ) {
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			}
		} // end of pet dead / no more attacks
		else {
			adr_previous ( Adr_battle_pet_dead_or_limitmagicattack , 'adr_battle' , '' );
		}
	} // end of special attack
	else if ( $attack && $bat['battle_turn'] == 1 )
	{
		// Define the weapon quality and power
		$weap = intval($HTTP_POST_VARS['item_weapon']);
		$power = 1;
		$quality = 0;
        $dice = rand(0,5);
		if ( $weap )
		{
			$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_in_shop = 0 
				AND item_in_warehouse = 0
				AND item_duration > 0
				$item_sql
				AND item_owner_id = $user_id 
				AND item_id = $weap ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$item = $db->sql_fetchrow($result);

			if ( $challenger['character_mp'] < $item['item_mp_use'] || $challenger['character_mp'] < 0 || $item['item_mp_use'] == '' ) 
			{	
				adr_previous ( Adr_battle_check , 'adr_battle' , '' );
			}

			if ( $item['item_mp_use'] > 0 )
			{
				$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
					SET character_mp = character_mp - " . $item['item_mp_use'] . "
					WHERE character_id = $user_id ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
				}
			}

			// Define theses values according to the item type ( enchanted weapon are better than normal weapons )
			$quality = ( $item['item_type_use'] == 6 ) ? ( $item['item_quality'] * 2 ) : $item['item_quality'] ;
         		$dice = rand(0,5);
			$power = ( $item['item_type_use'] == 6 ) ? ( $item['item_power'] * 3 ) + $dice + ( $char['might'] * 0.2 ) + $item['item_add_power'] : ( $item['item_power'] * 2 ) + $item['item_add_power'] + $dice + ( $char['might'] * 0.2 );
	
			// Check if pet have regeneration ability
			$mp_consumned = '0';
			$pet_regen = '0';
			if ( $rabbit_user['creature_ability'] == '1' )
			{
				if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
				{
					$mp_consumned = $rabbit_general['regeneration_mp_need'];
					$pet_regen = $rabbit_general['regeneration_hp_give'];
					$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
				}
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = creature_health + " . intval($pet_regen) . ",
					    creature_mp = creature_mp - " . intval($mp_consumned) . "
					WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql)) {
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}

			// Check if user a Amulet for HP regen this turn		
			if ( $bat['battle_challenger_hp'] != 0 )
			{
				if ( $challenger['character_hp'] < $challenger['character_hp_max'] )
				{
					$hp_regen = intval( adr_hp_regen_check( $user_id, $bat['battle_challenger_hp'] ) );
					$battle_message .= sprintf($lang['Adr_battle_regen_xp'], intval($hp_regen)).'<br />' ;
				}
			}

			// Check if user a Ring for MP regen this turn	
			if ( $bat['battle_challenger_mp'] != 0 )
			{
				if ( $challenger['character_mp'] < $challenger['character_mp_max'] )
				{
					$mp_regen = intval(adr_mp_regen_check( $user_id, $bat['battle_challenger_mp']));
					$battle_message .= sprintf($lang['Adr_battle_regen_mp'], intval($mp_regen)).'<br />' ;
				}
			}

			adr_use_item($weap , $user_id);
		} // end if weapon

		// Let's sort out the weapon animations...
		// Make table for start battle sequence...
		// 0 = Standing image , 1 = Attack image
		$user_action = 1; 
		$monster_action = 1;
		$attack_img = $item['item_name'];
		$attackwith_overlay = ((file_exists("adr/images/battle/spells/".$attack_img.".gif"))) ? '<img src="adr/images/battle/spells/'.$attack_img.'.gif" width="256" height="96" border="0">' : '';

		if($item['item_name'] == '')
		{
			$monster_def_dice = rand(1,20);
			$monster_modifier = rand(1,20); // this is temp. until proper monster characteristics are added to ADR
			$crit_roll = rand(1,20);

			// Grab modifers
			$bare_power = adr_modifier_calc($challenger['character_might']);

			if((($dice + $bare_power > $monster_def_dice + $monster_modifier) && ($dice != '1')) || ($dice == '20')){
				// Check if pet have regeneration ability
				$mp_consumned = '0';
				$pet_regen = '0';
				if ( $rabbit_user['creature_ability'] == '1' )
				{
					if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
					{
						$mp_consumned = $rabbit_general['regeneration_mp_need'];
						$pet_regen = $rabbit_general['regeneration_hp_give'];
						$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
					}
					$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
						SET creature_health = creature_health + " . intval($pet_regen) . ",
						    creature_mp = creature_mp - " . intval($mp_consumned) . "
						WHERE owner_id = $user_id ";
					if (!$result = $db->sql_query($sql)) {
						message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
					}
				}

				// Check if user a Amulet for HP regen this turn		
				if($bat['battle_challenger_hp'] > '0'){
					if($challenger['character_hp'] < $challenger['character_hp_max']){
						$hp_regen = intval(adr_hp_regen_check($user_id, $bat['battle_challenger_hp']));
						$battle_message .= sprintf($lang['Adr_battle_regen_xp'], intval($hp_regen)).'<br>';
					}
				}

				// Check if user a Ring for MP regen this turn	
				if($bat['battle_challenger_mp'] > '0'){
					if($challenger['character_mp'] < $challenger['character_mp_max']){
						$mp_regen = intval(adr_mp_regen_check($user_id, $bat['battle_challenger_mp']));
						$battle_message .= sprintf($lang['Adr_battle_regen_mp'], intval($mp_regen)).'<br>';
					}
				}

				// Attack success , calculate the damage . Critical dice roll is still success
				$damage = (($dice == '20') && ($crit_roll == '20')) ? ($bare_power *2) : $bare_power;
				$damage = ($damage > $bat['battle_opponent_hp']) ? $bat['battle_opponent_hp'] : $damage;

				$battle_message .= (($dice == '20') && ($crit_roll == '20')) ? $lang['Adr_battle_critical_hit']."<br>" : '';
				$battle_message .= sprintf($lang['Adr_battle_attack_bare'], $damage)."<br>";
			}
			else{
				$damage = 0;
				$battle_message .= sprintf($lang['Adr_battle_attack_bare_fail'], $challenger['character_name'], $monster['monster_name'])."<br>";
			}
		} // end if item_name is empty
		else{
			if((($diff === TRUE) && ($dice != '1')) || ($dice >= $threat_range)){
				// Prefix msg if crit hit
				$battle_message .= ($crit_result === TRUE) ? '<br>'.$lang['Adr_battle_critical_hit'].'</b><br />' : '';
				$damage = 1;

				// Work out attack type
				if(($item['item_element']) && ($item['item_element'] === $elemental['element_oppose_strong']) && ($item['item_duration'] > '1') && (!empty($item['item_name']))){
					$damage = ceil(($power *($item['item_element_weak_dmg'] /100)));
				}
				elseif(($item['item_element']) && (!empty($item['item_name'])) && ($item['item_element'] === $opponent_element) && ($item['item_duration'] > '1')){
					$damage = ceil(($power *($item['item_element_same_dmg'] /100)));
				}
				elseif(($item['item_element']) && (!empty($item['item_name'])) && ($item['item_element'] === $elemental['element_oppose_weak']) && ($item['item_duration'] > '1')){
					$damage = ceil(($power *($item['item_element_str_dmg'] /100)));
				}
				else{
					$damage = ceil($power);
				}

				// Fix dmg value
				$damage = ($damage < '1') ? rand(1,3) : $damage;
				$damage = ($damage > $bat['battle_opponent_hp']) ? $bat['battle_opponent_hp'] : $damage;

				// Fix attack msg type
				if(($item['item_element'] > '0') && ($element_name['element_name'] != '')){
					$battle_message .= sprintf($lang['Adr_battle_attack_success'], $challenger['character_name'], $monster['monster_name'], $item['item_name'], adr_get_lang($element_name['element_name']), $damage).'<br>';}
				else{
					$battle_message .= sprintf($lang['Adr_battle_attack_success_norm'], $challenger['character_name'], $monster['monster_name'], $item['item_name'], $damage).'<br>';}
			}
			else{
				$damage = 0;
				$battle_message .= sprintf($lang['Adr_battle_attack_failure'], $challenger['character_name'], $monster['monster_name'], $item['item_name']).'<br>';
			}
		} // end ELSE of item_name is empty
		if(($item['item_duration'] < '2') && ($item['item_name'] != '')){
			$battle_message .= '</span><span class="gensmall">'; // set new span class
			$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_battle_attack_dura'], $challenger['character_name'], adr_get_lang($item['item_name'])).'<br>';
			$battle_message .= '</span><span class="genmed">'; // reset span class to default
		}

		// Update the database
		$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
			SET battle_opponent_hp = battle_opponent_hp - $damage ,
				battle_turn = 2 , 
				battle_round = (battle_round + 1),
				battle_challenger_dmg = $damage
			WHERE battle_challenger_id = $user_id
			AND battle_result = 0
			AND battle_type = 1 ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
		}
	} // end of attack
	else if ( $defend && $bat['battle_turn'] == 1 )
	{
		$def = TRUE;
		$power = floor( ( $monster['monster_level'] * rand(1,3) ) / 2 );
		// Check if pet have regeneration ability	
		$mp_consumned = '0';
		if ( $rabbit_user['creature_ability'] == '1' )
		{
			if ( ( $rabbit_user['creature_health'] < $rabbit_user['creature_health_max'] ) && ( $rabbit_user['creature_health'] > 0 ) && ( $rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'] ) )
			{
				$mp_consumned = $rabbit_general['regeneration_mp_need'];
				$pet_regen = $rabbit_general['regeneration_hp_give'];
				$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)).'<br />' ;
			}
			$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
				Set creature_health = creature_health + $pet_regen,
				    creature_mp = creature_mp - $mp_consumned
			WHERE owner_id = $user_id ";	
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
			}
		}

		$battle_message .= sprintf($lang['Adr_battle_defend'], $challenger['character_name'], $monster['monster_name']).'<br>';

		// Update the database
		$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
			SET battle_turn = 2,
				 battle_round = (battle_round + 1)
			WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
		}
		// Let's sort out the defend animations...
		// Make table for start battle sequence...
		// 0 = Standing image , 1 = Attack image
		$user_action = 0; 
		$monster_action = 1;
		$attack_img = $item['item_name'];
		$attackwith_overlay = ((file_exists("adr/images/battle/spells/".$attack_img.".gif"))) ? '<img src="adr/images/battle/spells/'.$attack_img.'.gif" width="256" height="96" border="0">' : '';
	} // end if defend
	else
		exit('somethin went wrong lol');

	// Get the user infos
	$challenger = adr_get_user_infos($user_id);

	##=== START: additional status checks on user ===##
	if(($bat['battle_turn'] == '1') &&
		($petstuff || $attack || $item_spell || $item_potion || $defend || $flee || $equip || $item_spell2)) {
		$hp_regen = adr_hp_regen_check($user_id, $bat['battle_challenger_hp']);
		$challenger['character_hp'] += $hp_regen;
		$mp_regen = adr_mp_regen_check($user_id, $bat['battle_challenger_mp']);
		// V: commented out as I don't know if this is needed
		//$challenger['character_mp'] += $mp_regen;

		$battle_message .= '<span class="gensmall"><font color="#FF0000">'; // prefix new span class
		if((($hp_regen > '0') && ($mp_regen == '0')) || (($mp_regen > '0') && ($hp_regen == '0'))){
			if($hp_regen > '0'){ $battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_battle_regen_xp'], $challenger['character_name'], intval($hp_regen)).'<br />';}
			elseif($mp_regen > '0'){ $battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_battle_regen_mp'], $challenger['character_name'], intval($mp_regen)).'<br />';}
		}
		elseif(($hp_regen > '0') && ($mp_regen > '0')){
			$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_battle_regen_both'], $challenger['character_name'], intval($hp_regen), intval($mp_regen)).'<br />';
		}
		$battle_message .= '</font></span>'; // reset span class to default
	}
	##=== END: additional status checks on user ===##

	$sql = " SELECT * FROM  " . ADR_BATTLE_LIST_TABLE . " 
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	}
	$bat = $db->sql_fetchrow($result);

	if ( $bat['battle_turn'] == 2 )
	{
		$who_opponent = rand(0,20);

		if(($monster['monster_regeneration'] !='0') && ($bat['battle_opponent_hp'] < $bat['battle_opponent_hp_max']) )
		{
			$monster_regen = $monster['monster_regeneration'];
			$monster_new_hp = $bat['battle_opponent_hp'] + $monster_regen;

			if($monster_new_hp > $bat['battle_opponent_hp_max'])
			{
				$monster_new_hp = $bat['battle_opponent_hp_max'];
			}

			$battle_message .= sprintf($lang['Adr_battle_monster_regen'], $monster['monster_name'], intval($monster_regen)).'<br />' ;
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_hp = $monster_new_hp
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update monster info', '', __LINE__, __FILE__, $sql);
			}
		}

		if(($monster['monster_mp_regeneration'] !='0') && ($bat['battle_opponent_mp'] < $bat['battle_opponent_mp_max']) )
		{
			$monster_mp_regen = $monster['monster_mp_regeneration'];
			$monster_new_mp = $bat['battle_opponent_mp'] + $monster_mp_regen;

			if($monster_new_mp > $bat['battle_opponent_mp_max'])
			{
				$monster_new_mp = $bat['battle_opponent_mp_max'];
			}

			$battle_message .= sprintf($lang['Adr_battle_monster_mp_regen'], $monster['monster_name'], intval($monster_mp_regen)).'<br />' ;
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_mp = $monster_new_mp
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update monster info', '', __LINE__, __FILE__, $sql);
			}
		}

		if(($monster['monster_base_mp_drain'] !='0') && ($challenger['character_mp'] > '0' ) )
		{
			$monster_mp_drain = $monster['monster_base_mp_drain'];
			$challenger_new_mp = $challenger['character_mp'] - $monster_mp_drain;

			if($challenger_new_mp < '0')
			{
				$challenger_new_mp = '0';
			}

			$battle_message .= sprintf($lang['Adr_battle_monster_mp_drain'], $monster['monster_name'], intval($monster_mp_drain)).'<br />' ;
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_mp = $challenger_new_mp
				WHERE character_id = $user_id";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update player info', '', __LINE__, __FILE__, $sql);
			}
		}

		if(($monster['monster_base_hp_drain'] !='0') && ($challenger['character_hp'] > '0' ) )
		{
			$monster_hp_drain = $monster['monster_base_hp_drain'];
			$challenger_new_hp = $challenger['character_hp'] - $monster_hp_drain;

			if($challenger_new_hp < '0')
			{
				$challenger_new_hp = '0';
			}

			$battle_message .= sprintf($lang['Adr_battle_monster_hp_drain'], $monster['monster_name'], intval($monster_hp_drain)).'<br />' ;
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_hp = $challenger_new_hp
				WHERE character_id = $user_id";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update player info', '', __LINE__, __FILE__, $sql);
			}
		}

		if(($monster['monster_base_mp_transfer'] !='0') && ($challenger['character_mp'] > '0' ) )
		{
			$monster_mp_drain = $monster['monster_base_mp_transfer'];
			$challenger_new_mp = $challenger['character_mp'] - $monster_mp_drain;

			if($challenger_new_mp < '0')
			{
				$challenger_new_mp = '0';
			}

			$monster_mp_transfer = $monster['monster_base_mp_transfer'];
			$monster_new_mp = $bat['battle_opponent_mp'] + $monster_mp_transfer;

			if($monster_new_mp > $bat['battle_opponent_mp_max'])
			{
				$monster_new_mp = $bat['battle_opponent_mp_max'];
			}

			$battle_message .= sprintf($lang['Adr_battle_monster_mp_transfer'], $monster['monster_name'], intval($monster_mp_drain)).'<br />' ;
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_mp = $monster_new_mp
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update monster info', '', __LINE__, __FILE__, $sql);
			}
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_mp = $challenger_new_mp
				WHERE character_id = $user_id";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update player info', '', __LINE__, __FILE__, $sql);
			}
		}

		if(($monster['monster_base_hp_transfer'] !='0') && ($challenger['character_hp'] > '0' ) )
		{
			$monster_hp_drain = $monster['monster_base_hp_transfer'];
			$challenger_new_hp = $challenger['character_hp'] - $monster_hp_drain;

			if($challenger_new_hp < '0')
			{
				$challenger_new_hp = '0';
			}

			$monster_hp_transfer = $monster['monster_base_hp_transfer'];
			$monster_new_hp = $bat['battle_opponent_hp'] + $monster_hp_transfer;

			if($monster_new_hp > $bat['battle_opponent_hp_max'])
			{
				$monster_new_hp = $bat['battle_opponent_hp_max'];
			}

			$battle_message .= sprintf($lang['Adr_battle_monster_hp_transfer'], $monster['monster_name'], intval($monster_hp_drain)).'<br />' ;
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_hp = $monster_new_hp
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update monster info', '', __LINE__, __FILE__, $sql);
			}
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_hp = $challenger_new_hp
				WHERE character_id = $user_id";
			if (!$result = $db->sql_query($sql)) {
				message_die(GENERAL_ERROR, 'Could not update player info', '', __LINE__, __FILE__, $sql);
			}
		}

		if ( ($rabbit_user['creature_invoc']=='1') && ($who_opponent > 15) && ($rabbit_user['creature_health'] > 0) )
		{
			$power = rand(0,20);
			if ( $power == '20' ) //define critical hit
			{
				$monster_damage = ( ((rand(1,10) * $rabbit_user['creature_level'] )- $rabbit_user['creature_armor']) + rand(1,10) );
				if ( $monster_damage < 0 ) //define if damage is negative
				{
					$monster_damage = rand(1,3);
				}
				$damage_ratio = ( $rabbit_user['creature_health'] - $monster_damage );
				if ( $damage_ratio < 0 ) //define if health is negative
				{
					$monster_damage = ($rabbit_user['creature_health_max'] - $rabbit_user['creature_health']);
				}
				$battle_message .= sprintf($lang['Adr_battle_monster_success_critical'], intval($monster_damage)).'<br />' ;

				$statut_dice = rand(1,4); //define the change of health statut

				if ( $statut_dice == '1' )
				{
					$new_statut = '1';
					$battle_message .= sprintf($lang['Adr_battle_pet_newstatut_1']).'<br />' ;
				}
				if ( $statut_dice == '2' )
				{
					$new_statut = '2';
					$battle_message .= sprintf($lang['Adr_battle_pet_newstatut_2']).'<br />' ;
				}
				if ( $statut_dice == '3' )
				{
					$new_statut = '3';
					$battle_message .= sprintf($lang['Adr_battle_pet_newstatut_3']).'<br />' ;
				}
				if ( $statut_dice == '4' )
				{
					$new_statut = '4';
					$battle_message .= sprintf($lang['Adr_battle_pet_newstatut_4']).'<br />' ;
				}
				$damage_ratio = ( $rabbit_user['creature_health'] - $monster_damage );
				if ( $damage_ratio < 0 ) //define if health is negative
				{
					$monster_damage = ($rabbit_user['creature_health_max'] - $rabbit_user['creature_health']);
				}
   				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					Set creature_statut = '$new_statut',
					    creature_health = ( creature_health - $monster_damage )
				WHERE owner_id = $user_id ";	
				if (!$result = $db->sql_query($sql)) 
				{
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}
			else
			{
				$monster_damage = ((rand(1,10) * $rabbit_user['creature_level'] )- $rabbit_user['creature_armor']);
				if ( $monster_damage < 0 ) //define if damage is negative
				{
					$monster_damage = rand(1,3);
				}
				$damage_ratio = ( $rabbit_user['creature_health'] - $monster_damage );
				if ( $damage_ratio < 0 ) //define if health is negative
				{
					$monster_damage = ($rabbit_user['creature_health_max'] - $rabbit_user['creature_health']);
				}
				$battle_message .= sprintf($lang['Adr_battle_monster_success'], intval($monster_damage)).'<br />' ;

				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = ( creature_health - $monster_damage )
					WHERE owner_id = $user_id ";	
				if (!$result = $db->sql_query($sql)) 
				{
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
		} // end of rabbitoshi
	} // end of monster's turn
	else if ($bat['battle_opponent_hp'] > '0') // not rabbitoshi's turn
	{
		$monster_name = adr_get_lang($monster['monster_name']);
		$character_name = $challenger['character_name'];
        $monster['monster_crit_hit_mod'] = intval(2);
        $monster['monster_crit_hit'] = intval(20);
		$monster['monster_int'] = (10 + (rand(1, $monster['monster_level']) *2)); //temp calc
		$monster['monster_str'] = (10 + (rand(1, $monster['monster_level']) *2)); //temp calc

		// Prefix monster message
		// V: should use sprintf() here (and the other occurence for the player)
		$battle_message .= '<font color="orange">['.$lang['Adr_battle_msg_check'].$monster_name.']: </font>';

		if($def != TRUE)
			$power = ceil($monster['monster_level'] *rand(1,3));
		else
			$power = floor(($monster['monster_level'] *rand(1,3)) /2);

		// Has the monster the ability to steal from user?
		$thief_chance = rand(1,20);

		if(($board_config['Adr_thief_enable'] == '1') && ($thief_chance == '20')){
			$sql = "SELECT item_id, item_name FROM  " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_monster_thief = '0'
				AND item_in_warehouse = '0'
				AND item_in_shop = '0'
				AND item_duration > '0'
				AND item_owner_id = '$user_id'
				AND item_id NOT IN ($helm_equip, $armour_equip, $gloves_equip, $buckler_equip, $amulet_equip, $ring_equip)
				ORDER BY rand() LIMIT 1";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not query items for monster item steal', '', __LINE__, __FILE__, $sql);}
			$item_to_steal = $db->sql_fetchrow($result);

			// Rand to check type of thief attack
			$success_chance = rand(1,20);
			$rand = rand(1,20);

			##=== START: steal item checks
			$challenger_item_spot_check = (20 + adr_modifier_calc($challenger['character_skill_thief']));
			$monster_item_attempt = (((($rand + adr_modifier_calc($monster['monster_thief_skill'])) > $challenger_item_spot_check) && ($rand != '1')) || ($rand == '20')) ? TRUE : FALSE;
			##=== END: steal item checks

			##=== START: steal points checks
			$challenger_points_spot_check = (10 + adr_modifier_calc($challenger['character_skill_thief']));
			$monster_points_attempt = (((($rand + $monster['monster_thief_skill']) > $challenger_points_spot_check) && ($rand != '1')) || ($rand == '20')) ? TRUE : FALSE;
			##=== END: steal points checks

			if(($success_chance == '20') && ($monster_item_attempt == TRUE) && ($item_to_steal['item_name'] != '')){
				$damage = 0;

				// Mark the item as stolen
				$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
					SET item_monster_thief = 1
					WHERE item_owner_id = '$user_id'
					AND item_id = '" . $item_to_steal['item_id'] . "'";
				if(!($result = $db->sql_query($sql))){
					message_die(GENERAL_ERROR, 'Could not update stolen item by monster', '', __LINE__, __FILE__, $sql);}

					$battle_message .= sprintf($lang['Adr_battle_opponent_thief_success'], $monster_name, adr_get_lang($item_to_steal['item_name']), $character_name);
			}
			elseif(($success_chance >= '15') && ($success_chance != '20') && ($user_points > '0') && ($monster_points_attempt == TRUE)){
				$damage = 0;
				$points_stolen = floor(($user_points /100) *$board_config['Adr_thief_points']);
				subtract_reward($user_id, $points_stolen);
				$battle_message .= sprintf($lang['Adr_battle_opponent_thief_points'], $monster_name, $points_stolen, get_reward_name(), $character_name);
			}
			else{
				$damage = 0;
				$battle_message .= sprintf($lang['Adr_battle_opponent_thief_failure'], $monster_name, adr_get_lang($item_to_steal['item_name']), $character_name);
			}
			// Let's sort out the monster theft animation
			$monster_action = 0;
			$attack_img = $item['item_name'];
			$attackwith_overlay = ((file_exists("adr/images/battle/monster/theft_attempt.gif"))) ? '<img src="adr/images/battle/monster/theft_attempt.gif" width="256" height="96" border="0">' : '';
		} // thief fail
		else{
			$attack_type = rand(1,20);
			##=== START: Critical hit code
			$threat_range = $monster['monster_crit_hit'];
//			list($crit_result, $power) = explode('-', adr_battle_make_crit_roll($bat['battle_opponent_att'], $monster['monster_level'], $bat['battle_challenger_def'], 0, $power, 0, $threat_range, 0));
			##=== END: Critical hit code

			if(($bat['battle_opponent_mp'] > '0') && ($bat['battle_opponent_mp'] >= $bat['battle_opponent_mp_power']) && ($attack_type > '16')){
				$damage = 1;
				$power = ceil($power + adr_modifier_calc($bat['battle_opponent_mp_power']));
				$monster_elemental = adr_get_element_infos($opponent_element);

				// Sort out magic check & opponents saving throw
				$dice = rand(1,20);
				$magic_check = ceil($dice + $bat['battle_opponent_mp_power'] + adr_modifier_calc($monster['monster_int']));
				$fort_save = (11 + adr_modifier_calc($challenger['character_wisdom']));
				$success = ((($magic_check >= $fort_save) && ($dice != '1')) || ($dice >= $threat_range)) ? TRUE : FALSE;

				if($success === TRUE){
					// Prefix msg if crit hit
					$battle_message .= ($dice >= $threat_range) ? $lang['Adr_battle_critical_hit'].' ' : '';

					// Work out attack type
					if($challenger_element === $monster_elemental['element_oppose_weak']){
						$damage = ceil(($power *($monster_elemental['element_oppose_strong_dmg'] /100)));
					}
					elseif($challenger_element === $opponent_element){
						$damage = ceil(($power *($monster_elemental['element_oppose_same_dmg'] /100)));
					}
					elseif($challenger_element === $monster_elemental['element_oppose_strong']){
						$damage = ceil(($power *($monster_elemental['element_oppose_weak_dmg'] /100)));
					}
					else{
						$damage = ceil($power);
					}

					// Fix dmg value
					$damage = ($damage < '1') ? rand(1,3) : $damage;
					$damage = ($dice >= $threat_range) ? ($damage *$monster['monster_crit_hit_mod']) : $damage;
					$damage = ($damage > $challenger['character_hp']) ? $challenger['character_hp'] : $damage;

					// Fix attack msg type
					if($monster['monster_base_custom_spell'] != ''){
						$battle_message .= sprintf($lang['Adr_battle_opponent_spell_success'], $monster_name, $monster['monster_base_custom_spell'], $character_name, $damage);}
					else{
						$battle_message .= sprintf($lang['Adr_battle_opponent_spell_success2'], $monster_name, $character_name, $damage);}
				}
				else{
					$damage = 0;
					$battle_message .= sprintf($lang['Adr_battle_opponent_spell_failure'], $monster_name, $character_name);
				}

				// Remove monster MP
				$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
					SET battle_opponent_mp = (battle_opponent_mp - '" . $bat['battle_opponent_mp_power'] . "')
					WHERE battle_challenger_id = '$user_id'
						AND battle_result = '0'
						AND battle_type = '1'";
				if(!($result = $db->sql_query($sql))){
					message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
			}
			else{
				// Let's check if the attack succeeds
				$dice = rand(1,20);
				$success = (((($bat['battle_opponent_att'] + $dice) >= ($bat['battle_challenger_def'] + adr_modifier_calc($challenger['character_dexterity']))) && ($dice != '1')) || ($dice >= $threat_range)) ? TRUE : FALSE;
				$power = ceil(($power /2) + (adr_modifier_calc($monster['monster_str'])));
				$damage = 1;

				if($success == TRUE){
					// Attack success , calculate the damage . Critical dice roll is still success
					$damage = ($power < '1') ? rand(1,3) : $power;
					$damage = ($dice >= $threat_range) ? ceil($damage *$monster['monster_crit_hit_mod']) : ceil($damage);
					$damage = ($damage > $challenger['character_hp']) ? $challenger['character_hp'] : $damage;
					$battle_message .= ($dice >= $threat_range) ? $lang['Adr_battle_critical_hit'].' ' : '';
					$battle_message .= sprintf($lang['Adr_battle_opponent_attack_success'], $monster_name, $character_name, $damage);
				}
				else{
					$damage = 0;
					$battle_message .= sprintf($lang['Adr_battle_opponent_attack_failure'], $monster_name, $character_name);
				}
				// Let's sort out the monster theft animation
				$monster_action = 1;
				$attack_img = $item['item_name'];
				$attackwith_overlay = ((file_exists("adr/images/battle/monster/attack.gif"))) ? '<img src="adr/images/battle/monster/attack.gif" width="256" height="96" border="0">' : '';
			}

			// Prevent instant kills at start of battle
			if(($bat['battle_round'] == '0') && (($challenger['character_hp'] - $damage) < '1'))
				$character_hp = '1';
			else{
				$character_hp = '(character_hp - '.$damage.')';}
				$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_hp = $character_hp
				WHERE character_id = '$user_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
		}

		// End msg with round number
		$round_check = (($bat['battle_round'] == '0') && ($bat['battle_turn'] == '2')) ? 'battle_round = (battle_round + 1), ' : '';
		$battle_message = '<font size="1"><div align="left">[Round '.($battle_round + 1).']</div></font>'.$battle_message;

		// Fix battle text
		$battle_text = $battle_message.$bat['battle_text'];
		$battle_text_format = str_replace('<br />', "<br>", $battle_text);
		$battle_text_format = str_replace('\'', '%APOS%', $battle_text_format);

		$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
			SET battle_text = '" . str_replace("\'", "''", $battle_text_format) . "',
				battle_turn = 1,
				$round_check
				battle_opponent_dmg = $damage
			WHERE battle_challenger_id = '$user_id'
			AND battle_result = '0'
			AND battle_type = '1'";
		if(!($result = $db->sql_query($sql))){
			message_die(GENERAL_ERROR, 'Could not update battle at end of user turn', '', __LINE__, __FILE__, $sql);}
	}
	// Check again after the available actions
	$sql = " SELECT * FROM  " . ADR_BATTLE_LIST_TABLE . " 
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	}
	$bat = $db->sql_fetchrow($result);

	// Check for any stolen items
	$sql = " SELECT item_name FROM  " . ADR_SHOPS_ITEMS_TABLE . " 
		WHERE item_owner_id = '$user_id'
		AND item_monster_thief = '1'
		LIMIT 1";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	}
	$stolen = $db->sql_fetchrow($result);
	
	// Get the user infos
	$sql = "SELECT c.* , u.user_avatar , u.user_avatar_type, u.user_allowavatar FROM " . ADR_CHARACTERS_TABLE . " c , " . USERS_TABLE . " u
		WHERE c.character_id = $user_id 
		AND c.character_id = u.user_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query user', '', __LINE__, __FILE__, $sql);
	}
	$challenger = $db->sql_fetchrow($result);

   	$challenger_hp = $challenger['character_hp'];
   	$opponent_hp = $bat['battle_opponent_hp'];

	// We have to know if one of the opponents is dead
	if ( ($opponent_hp < 1 && $challenger_hp > 0) || (($opponent_hp < '1') && ($challenger_hp < '1')) )
	{
		// The monster is dead , give money and xp to the users , then update the database

		// Get the experience earned
		$exp = rand ( $adr_general['battle_base_exp_min'] , $adr_general['battle_base_exp_max'] );
		if (( $monster['monster_level'] - $challenger['character_level'] ) > 1 )
		{
			$exp = floor( ( ( $monster['monster_level'] - $challenger['character_level'] ) * $adr_general['battle_base_exp_modifier'] ) / 100 );
		}
		//Guild Experience
		$guild_exp = rand($adr_general['battle_guild_exp_min'], $adr_general['battle_guild_exp_max']);

		// Share EXP
		$exp2 = round($exp / 10);
		$exp = $exp + $count_members;
		$exp = round($exp);
		if($exp < 0) {
			$exp = 0;
		}

		// Get the money earned
		$reward = rand ( $adr_general['battle_base_reward_min'] , $adr_general['battle_base_reward_max'] );
		if (( $monster['monster_level'] - $challenger['character_level'] ) > 1 )
		{
			$reward = floor( ( ( $monster['monster_level'] - $challenger['character_level'] ) * $adr_general['battle_base_reward_modifier'] ) / 100 );
		}

		$sql = " UPDATE  " . ADR_BATTLE_LIST_TABLE . " 
			SET battle_result = 1 ,
				battle_opponent_hp = 0,
				battle_finish = ".time().",
				battle_text = ''
			WHERE battle_challenger_id = $user_id
			AND battle_result = 0
			AND battle_type = 1 ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);
		}

		// If $challenger['character_hp'] is < '1' then update sql to hp = 1
		$sql_update_hp = ($challenger['character_hp'] < '1') ? 'character_hp = 1,' : '';

		$sql = " UPDATE  " . USERS_TABLE . " 
			SET user_points = user_points + $reward
			WHERE user_id = $user_id ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
		}

		$sql = 'SELECT character_party FROM '.ADR_CHARACTERS_TABLE.' WHERE character_id = '.$user_id;
		$re = $db->sql_query($sql);
		$char = $db->sql_fetchrow($re); 

		$sql = "UPDATE  " . ADR_CHARACTERS_TABLE . "
		        SET     character_victories = character_victories + 1 ,
		                character_sp = character_sp + '" . $bat['battle_opponent_sp'] . "',
						character_xp = character_xp + $exp
		        WHERE character_id = $user_id ";
		if( !($result = $db->sql_query($sql)) )
		{
		    message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
		}
		if($char['character_party'] != 0)
		{
			$sql = "UPDATE  " . ADR_CHARACTERS_TABLE . "
			        SET     character_xp = character_xp + $exp2
			        WHERE character_party = ".$char['character_party']."
			AND character_id != ".$userdata['user_id']."						";
			if( !($result = $db->sql_query($sql)) )
			{
			    message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
			}
		}

		// Remove item stolen status
		$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
			SET item_monster_thief = 0 
			WHERE item_owner_id = $user_id ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update stolen item status', '', __LINE__, __FILE__, $sql);
		}
		
		//Update the Guilds Experience
		$sql = " UPDATE  " . ADR_GUILDS_TABLE . " 
			SET guild_exp = guild_exp + $guild_exp
			WHERE guild_id = '".$challenger['character_guild_id']."' ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update guild', '', __LINE__, __FILE__, $sql);
		}

		// Delete broken items from users inventory
		$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_duration < 1 
			AND item_owner_id = $user_id ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete broken items', '', __LINE__, __FILE__, $sql);
		}
		// Pet part
        if( $rabbit_user['creature_invoc']=='1' )
       	{
         	// Set default pet health statut
            if( $rabbit_user['creature_statut']=='4' )
           	{
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_statut = '0'
					WHERE owner_id = $user_id ";	
				if (!$result = $db->sql_query($sql)) 
				{
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				}
			}
			$pet_xp = rand($rabbit_general['experience_min'],$rabbit_general['experience_max']);
      		$pet_xp_lvl = $pet_xp; 
      		$pet_xp_limit = ( $rabbit_user['creature_experience_level_limit'] - ( $rabbit_user['creature_experience_level'] + $pet_xp_lvl ) ); 

            if( $pet_xp_limit < 0 ) 
            { 
         		$pet_xp_lvl = ( $rabbit_user['creature_experience_level_limit'] - $rabbit_user['creature_experience_level'] ); 
      		}
		}
		$message = sprintf($lang['Adr_battle_won'] , $bat['battle_challenger_dmg'] , $exp , $bat['battle_opponent_sp'] , $reward , get_reward_name(), $challenger['character_hp'] , $challenger['character_mp']);

		///Call Loot System/// 
		$message .= drop_loot($loot_id,$challenger['character_id'], $dropped_loot_list); 
		///Call Loot System///
		if( $rabbit_user['creature_invoc']=='1' )
        {
			$message .= '<br />'.sprintf($lang['Adr_battle_pet_win'] , $pet_xp ) ;
		}

		########## QUESTBOOK MOD v1.0.2 - START
		// Check if the character killed a monster that he needed for a killing quest !
		$sql = " SELECT * FROM " . ADR_QUEST_LOG_TABLE . "
	   		WHERE quest_kill_monster = '".$monster['monster_name']."'
			AND quest_kill_monster_current_amount < quest_kill_monster_amount
			AND user_id = '". $challenger['character_id'] ."'
	   		";
		$result = $db->sql_query($sql);
		if( !$result )
	   		message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql);
		if ( $quest_log = $db->sql_fetchrow($result) )
		{
			//Now increase the current amount killed value by 1 for each killing quest 
			//that requires still the monster the player just killed
			for ( $i=0 ; $i<count($quest_log = $db->sql_fetchrow($result)) ; $i++ )
			{
				$sql = "UPDATE " . ADR_QUEST_LOG_TABLE . "
					set quest_kill_monster_current_amount = quest_kill_monster_current_amount + 1 
					WHERE quest_kill_monster = '".$monster['monster_name']."'
					AND quest_kill_monster_current_amount < quest_kill_monster_amount
					AND user_id = '". $challenger['character_id'] ."'
					";
				$result = $db->sql_query($sql);
				if( !$result )
					message_die(GENERAL_ERROR, "Couldn't update quest", "", __LINE__, __FILE__, $sql);
			}
		}
		######### QUESTBOOK MOD v1.0.2 - END

		if ( $stolen['item_name'] != '' )
		{
			$message .= '<br />'.sprintf($lang['Adr_battle_stolen_items'] , $monster['monster_name'] ) ;
		}
		$message .= '<br /><br />'.sprintf($lang['Adr_battle_return'] ,"<a href=\"" . 'adr_battle.'.$phpEx . "\">", "</a>") ;
		$message .= '<br /><br />'.sprintf($lang['Adr_character_return'] ,"<a href=\"" . 'adr_character.'.$phpEx . "\">", "</a>") ;
        if( $rabbit_user['creature_invoc']=='1' )
       	{
        	// Set invoc default stats 
	     	$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " 
	     	Set creature_invoc = '0' , 
	         		creature_experience = creature_experience + '$pet_xp', 
	         		creature_experience_level = creature_experience_level + '$pet_xp_lvl' 
	  		WHERE owner_id = $user_id ";	
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
			}
		}
		message_die ( GENERAL_MESSAGE , $message );
	} // end if one of opponent is dead

	if ( $challenger_hp < 1 && $opponent_hp > 0 )
	{
		// The character is dead , update the database

		$sql = " UPDATE  " . ADR_BATTLE_LIST_TABLE . " 
			SET battle_result = 2,
				battle_finish = ".time().",
				battle_text = '' 
			WHERE battle_challenger_id = $user_id
			AND battle_result = 0
			AND battle_type = 1 ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);
		}

		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_hp = 0 ,
			    character_defeats = character_defeats + 1
			WHERE character_id = $user_id ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
		}

		// Delete stolen items from users inventory
		$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_monster_thief = 1
			AND item_owner_id = $user_id ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete stolen items', '', __LINE__, __FILE__, $sql);
		}

		// Delete broken items from users inventory
		$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_duration < 1 
			AND item_owner_id = $user_id ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete broken items', '', __LINE__, __FILE__, $sql);
		}
		// Pet part
            if( $rabbit_user['creature_invoc']=='1' )
           	{
         	// Set invoc default stats
   		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
			Set creature_invoc = '0'
		WHERE owner_id = $user_id ";	
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
		}

         	// Set default pet health statut
            if( $rabbit_user['creature_statut']=='4' )
           	{
   		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
			Set creature_statut = '0'
		WHERE owner_id = $user_id ";	
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
		}
		}
		}
		$message = sprintf($lang['Adr_battle_lost'] , $monster['monster_name'] , $bat['battle_opponent_dmg'] );
		if ( $stolen['item_name'] != '' )
		{
			$message .= '<br /><br />'.sprintf($lang['Adr_battle_stolen_items_lost'] , $monster['monster_name'] ) ;
		}
		$message .= '<br /><br />'.sprintf($lang['Adr_battle_temple'] ,"<a href=\"" . 'adr_temple.'.$phpEx . "\">", "</a>") ;
		$message .= '<br /><br />'.sprintf($lang['Adr_character_return'] ,"<a href=\"" . 'adr_character.'.$phpEx . "\">", "</a>") ;
		message_die ( GENERAL_MESSAGE , $message );
	}
}
}

	// Prepare the items list
	$weapon_list = '<select name="item_weapon">';
	$weapon_list .= '<option value = "0" >' . $lang['Adr_battle_no_weapon'] . '</option>';
	$spell_list = '<select name="item_spell">';
	$spell_list .= '<option value = "0" >' . $lang['Adr_battle_no_spell'] . '</option>';
	$potion_list = '<select name="item_potion">';
	$potion_list .= '<option value = "0" >' . $lang['Adr_battle_no_potion'] . '</option>';

	$sql = " SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . "
		WHERE spell_owner_id = $user_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	}
	$spells = $db->sql_fetchrowset($result);
	$spell2_list = '<select name="item_spell2">';
	$spell2_list .= '<option value = "0" >' . $lang['Adr_battle_no_spell_learned'] . '</option>';

	$avatar_img = '';
	if(($userdata['user_avatar_type']) && ($userdata['user_allowavatar'])){
		switch($userdata['user_avatar_type']){
			case USER_AVATAR_UPLOAD:
				$avatar_img = ($board_config['allow_avatar_upload']) ? '<img src="' . $board_config['avatar_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_REMOTE:
				$avatar_img = ($board_config['allow_avatar_remote']) ? '<img src="' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_GALLERY:
				$avatar_img = ($board_config['allow_avatar_local']) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
				break;
		}
	}

	// First select the available items
	$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_in_shop = 0 
		$item_sql
		AND item_duration > 0
		AND item_in_warehouse = 0
		AND item_monster_thief = 0
		AND item_owner_id = $user_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	}
	$items = $db->sql_fetchrowset($result);

	// V: moved below that end-of-if
	// I don't know who's making ADR changelogs, but
	// he's being a damn pig sometimes
	for ( $i = 0, $count_items = count($items) ; $i < $count_items ; $i ++ )
	{
 		$item_name = adr_get_lang($items[$i]['item_name']);
		$item_power = ($adr_general['item_power_level'] == '1') ? ($items[$i]['item_power'] + $items[$i]['item_add_power']) : $items[$i]['item_power'];


		if ( ( $items[$i]['item_type_use'] ==  5 || $items[$i]['item_type_use'] ==  6 ) && ( $items[$i]['item_mp_use'] <= $challenger['character_mp'] ) )
		{
			$weapon_selected = ( $HTTP_POST_VARS['item_weapon'] == $items[$i]['item_id'] ) ? 'selected' : '';
     			$weapon_list .= '<option value = "'.$items[$i]['item_id'].'" '.$weapon_selected.'>' . $item_name . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>'; 
		}
		else if ( ( $items[$i]['item_type_use'] == 11 ||  $items[$i]['item_type_use'] == 12 ) && ( ( $items[$i]['item_power'] + $items[$i]['item_mp_use'] ) <= $challenger['character_mp'] ) )
		{
			$spell_selected = ( $HTTP_POST_VARS['item_spell'] == $items[$i]['item_id'] ) ? 'selected' : '';
			$spell_list .= '<option value = "'.$items[$i]['item_id'].'" '.$spell_selected.' >' . $item_name . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
		}
		else if ( $items[$i]['item_type_use'] == 15 || $items[$i]['item_type_use'] == 16 || $items[$i]['item_type_use'] == 19 )
		{
			$potion_selected = ( $HTTP_POST_VARS['item_potion'] == $items[$i]['item_id'] ) ? 'selected' : '';
			$potion_list .= '<option value = "'.$items[$i]['item_id'].'" '.$potion_selected.' >' . $item_name . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
		}
	}
	for ( $s = 0 ; $s < count($spells) ; $s ++ )
	{
 		$spells_power = $spells[$s]['spell_power'] + $spells[$s]['spell_add_power'];

		if ( ( $spells[$s]['item_type_use'] ==  11 || $spells[$s]['item_type_use'] ==  108 || $spells[$s]['item_type_use'] ) && ( $spells[$s]['spell_mp_use'] <= $challenger['character_mp'] ) )
		{
			$spell2_selected = ( $HTTP_POST_VARS['item_spell2'] == $spells[$s]['spell_id'] ) ? 'selected' : '';
     			$spell2_list .= '<option value = "'.$spells[$s]['spell_id'].'" '.$spell2_selected.'>' . adr_get_lang($spells[$s]['spell_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $spells_power . ' )'.'</option>'; 
		}
	}
	$weapon_list .= '</select>';
	$spell_list .= '</select>';
	$spell2_list .= '</select>';
	$potion_list .= '</select>';

	##=== START: Create bar widths ===##
	list($challenger_hp_width, $challenger_hp_empty) = adr_make_bars($challenger['character_hp'], $challenger['character_hp_max'], '100');
	list($challenger_mp_width, $challenger_mp_empty) = adr_make_bars($challenger['character_mp'], $challenger['character_mp_max'], '100');
	list($opponent_hp_width, $opponent_hp_empty) = adr_make_bars($bat['battle_opponent_hp'], $bat['battle_opponent_hp_max'], '100');
	list($opponent_mp_width, $opponent_mp_empty) = adr_make_bars($bat['battle_opponent_mp'], $bat['battle_opponent_mp_max'], '100');
	##=== END: Create bar widths ===##

	###=== START: grab challenger & opponent infos ===###
	$monster_element_name = adr_get_element_infos($monster['monster_base_element']);
	$monster_alignment_name = adr_get_alignment_infos(2);
	// V: I don't know no monster base align'
	//(!$monster['monster_base_alignment']) ?: 
	//	adr_get_alignment_infos($monster['monster_base_alignment']);
	$challenger_element = adr_get_element_infos($challenger['character_element']);
	$challenger_alignment = adr_get_alignment_infos($challenger['character_alignment']);
	$challenger_class = adr_get_class_infos($challenger['character_class']);
	###=== END: grab challenger & opponent infos ===###

	list($creature_health_width, $creature_health_empty) = adr_make_bars($rabbit_user['creature_health'], $rabbit_user['creature_health_max'], '100');
	list($creature_mp_width, $creature_mp_empty) = adr_make_bars($rabbit_user['creature_mp'], $rabbit_user['creature_max_mp'], '100');
	list($creature_attack_width, $creature_attack_empty) = adr_make_bars($rabbit_user['creature_attack'], $rabbit_user['creature_attack_max'], '100');
	list($creature_magicattack_width, $creature_magicattack_empty) = adr_make_bars($rabbit_user['creature_magicattack'], $rabbit_user['creature_magicattack_max'], '100');

	// Grab pet details again
	$sql = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE . "
		WHERE owner_id = $user_id ";
	if (!$result = $db->sql_query($sql)) {
		message_die(GENERAL_ERROR, 'Could not get pet info', '', __LINE__, __FILE__, $sql);
	}
	$rabbit_user = $db->sql_fetchrow($result);

	$ability = '';
	$ability_level = $rabbit_user['creature_ability'];
	if ( $ability_level == '0' )
	{
		$ability = ''; //$lang['Rabbitoshi_ability_lack'];
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
	$magicattack = $rabbit_user['creature_magicattack'];

	$invoc_table = $pet_table = '';
	$show_pet_table = $rabbit_user['creature_invoc'];
	if ($show_pet_table == '1')
	{
		$pet_health_text = $rabbit_user['creature_health'] > 0 ? $lang['Rabbitoshi_battle_pet_health'].' : ' .$rabbit_user['creature_health'].'/'.$rabbit_user['creature_health_max']
			: 'Morte';
		$pet_table='<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
				<tr>
					<th colspan="4">'.$lang['Rabbitoshi_battle_pet_title' . ($rabbit_user['creature_health'] > 0 ? '' : '_dead')].'</th>
				</tr>
				<tr align="center">
					<td class="row1" width="25%"><span class="gen">'.$rabbit_user['owner_creature_name'].'</span><br /><img src="rabbitoshi/images/pets/'.$rabbit_user['creature_avatar'].'"></td>
					<td class="row1" width="25%"><span class="gen">'.$pet_health_text.'<br />
						' . ($rabbit_user['creature_health'] > 0 ? '<img src="rabbitoshi/images/stats/bar_left.gif" border="0" width="6" height="13" /><img src="rabbitoshi/images/stats/bar_fil.gif" border="0" width="'.$creature_health_width.'" height="13" /><img src="rabbitoshi/images/stats/bar_right.gif" border="0" width="6" height="13" />
							<br /><br />'.$lang['Rabbitoshi_battle_pet_mp'].' : '.$rabbit_user['creature_mp'].'/'.$rabbit_user['creature_max_mp'].'<br />
                                                    <img src="rabbitoshi/images/stats/bar_left2.gif" width="6" height="13" /><img src="rabbitoshi/images/stats/bar_fil2.gif" width="'.$creature_mp_width.'" height="13" /><img src="rabbitoshi/images/stats/bar_right2.gif" width="6" height="13" /><br /></span>' : '') . '</td>
					<td class="row1" width="25%"><span class="gen">'.$lang['Rabbitoshi_battle_pet_attack'].' : '.$rabbit_user['creature_attack'].'/'.$rabbit_user['creature_attack_max'].'<br />
                                            	<img src="rabbitoshi/images/stats/bar_left1.gif" width="6" height="13" /><img src="rabbitoshi/images/stats/bar_fil1.gif" width="'.$creature_attack_width.'" height="13" /><img src="rabbitoshi/images/stats/bar_right1.gif" width="6" height="13" /><br /><br />'.$lang['Rabbitoshi_battle_pet_magicattack'].' : '.$rabbit_user['creature_magicattack'].'/'.$rabbit_user['creature_magicattack_max'].'<br />
                                                    <img src="rabbitoshi/images/stats/bar_left4.gif" width="6" height="13" /><img src="rabbitoshi/images/stats/bar_fil4.gif" width="'.$creature_magicattack_width.'" height="13" /><img src="rabbitoshi/images/stats/bar_right4.gif" width="6" height="13" /><br /></span></td>
					<td class="row1" width="25%">
						' . ($rabbit_user['creature_health'] > 0 ? '<input type="submit" style="width: 135" value="'.$lang['Rabbitoshi_battle_pet_action_attack'].'" onClick="return checksubmit(this)" name="pet_attack" class="mainoption" /><br /><br />' : '') . '
						' . ($magicattack ? '<input type="submit" style="width: 135" value="'.$lang['Rabbitoshi_battle_pet_action_magicattack'].'" onClick="return checksubmit(this)" name="pet_magicattack" class="mainoption" /><br /><br />' : '') . '
						' . ($ability ? '<input type="submit" style="width: 135" value="'.$ability.'" onClick="return checksubmit(this)" name="pet_specialattack" class="mainoption" />' : '') . '</td>
				</tr>
			    </table>';
	}

	if ( ($pet_invoc == '1') && ($rabbit_user['creature_health'] > 0) )
	{
		if ($show_pet_table == '0')
		{
			$invoc_table='<tr>
					  <td align="center" class="row1" width="100%" colspan="2"><input type="submit" style="width: 225" value="'.$lang['Rabbitoshi_battle_pet_action_invoc'].''.$rabbit_user['owner_creature_name'].'" onClick="return checksubmit(this)" name="invoc" class="mainoption" /></td>
				  </tr>';
		}
	}

	// Grab user details for graphical battles...
	$sql = "SELECT * 
		FROM " . ADR_RACES_TABLE ." r , " . ADR_ELEMENTS_TABLE ." e , " . ADR_ALIGNMENTS_TABLE ." a , " . ADR_CLASSES_TABLE ." c
		WHERE r.race_id = '" . $challenger['character_race'] . "' 
		AND e.element_id = '" . $challenger['character_element'] . "' 
		AND a.alignment_id = '" . $challenger['character_alignment'] . "'
		AND c.class_id = '" . $challenger['character_class'] . "' ";
	if (!$result = $db->sql_query($sql)) 
	{
		message_die(CRITICAL_ERROR, 'Error grabbing character details!');
	}
	$class = $db->sql_fetchrow($result);

	// Armour set?
	$armour_set = !$bat['battle_challenger_armour_set'] ? $lang['Adr_store_element_none'] : $bat['battle_challenger_armour_set'];

	// Only required until a monster alignment mod is released
	$monster_alignment_id = 2;
	//!$monster['monster_base_alignment'] ? 2 : $monster['monster_base_alignment'];

	// Grab monster details for graphical battles...
	$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE ." e , " . ADR_ALIGNMENTS_TABLE ." a
		WHERE a.alignment_id = $monster_alignment_id 
		AND e.element_id = '" . $monster['monster_base_element'] . "' ";
	if (!$result = $db->sql_query($sql)) 
	{
		message_die(CRITICAL_ERROR, 'Error grabbing monster details!');
	}
	$monster_details = $db->sql_fetchrow($result);

	// Grab background details
	if( empty($bck_grnd_name) )
	{
		$bck_grnd_name = $bat['battle_bkg'];
	}

	// Required to prevent battles with no background image
	if ( !$bck_grnd_name && !$bat['battle_bkg'] )
	{
		$bck_grnd_name = "battle_bgnd_1.gif";
	}

	$template->assign_vars(array(
		'ATTACK' => $weapon_list,
		'PET_TABLE' => $pet_table,
		'INVOC_TABLE' => $invoc_table,
		'SPELL' => $spell_list,
		'SPELL2' => $spell2_list,
		'POTION' => $potion_list,
		'NAME' => $challenger['character_name'],
		'AVATAR_IMG' => $avatar_img, 
		'MONSTER_NAME' => adr_get_lang($monster['monster_name']),
		'MONSTER_IMG' => $monster['monster_img'],
		'BATTLE_TEXT' => str_replace('%APOS%', "'", $bat['battle_text']),
		'HP' => $challenger['character_hp'],
		'HP_MAX' => $challenger['character_hp_max'],
		'HP_WIDTH' => $challenger_hp_width,
		'MP' => $challenger['character_mp'],
		'MP_MAX' => $challenger['character_mp_max'],
		'MP_WIDTH' => $challenger_mp_width,
		'ATT' => $bat['battle_challenger_att'],
		'DEF' => $bat['battle_challenger_def'],
		'M_ATT' => $bat['battle_challenger_magic_attack'],
		'M_DEF' => $bat['battle_challenger_magic_resistance'],
		'USER_ACTION' => $user_action,
		'MONSTER_ACTION' => $monster_action,
		'CLASS' => adr_get_lang($class['class_name']),
      	'RANDOM_BKG' => $bck_grnd_name,
      	'ALIGNMENT' => adr_get_lang($class['alignment_name']),
      	'ELEMENT' => adr_get_lang($class['element_name']),
      	'ARMOUR_SET' => adr_get_lang($armour_set),
      	'MONSTER_ALIGNMENT' => adr_get_lang($monster_details['alignment_name']),
      	'MONSTER_ELEMENT' => adr_get_lang($monster_details['element_name']),
		'MONSTER_HP' => $bat['battle_opponent_hp'],
		'MONSTER_HP_MAX' => $bat['battle_opponent_hp_max'],
		'MONSTER_HP_WIDTH' => $opponent_hp_width,
		'MONSTER_MP' => $bat['battle_opponent_mp'],
		'MONSTER_MP_MAX' => $bat['battle_opponent_mp_max'],
		'MONSTER_MP_WIDTH' => $opponent_mp_width,
		'MONSTER_ATT' => $bat['battle_opponent_att'],
		'MONSTER_DEF' => $bat['battle_opponent_def'],
		'MONSTER_M_ATT' => $bat['battle_opponent_magic_attack'],
		'MONSTER_M_DEF' => $bat['battle_opponent_magic_resistance'],
 		'L_HP'=> $lang['Adr_character_health'],
		'L_MP' => $lang['Adr_character_magic'],
		'L_ATT' => $lang['Adr_attack'],
		'L_DEF' => $lang['Adr_defense'],
		'L_ATTACK' => $lang['Adr_attack_opponent'],
		'L_POTION' => $lang['Adr_potion_opponent'],
		'L_DEFEND' => $lang['Adr_defend_opponent'],
		'L_FLEE' => $lang['Adr_flee_opponent'],
		'L_SPELL' => $lang['Adr_spell_opponent'],
		'L_SPELL2' => $lang['Adr_spell_learned'],
		'L_ACTIONS' => $lang['Adr_actions_opponent'],
		'L_ATTRIBUTES' => $lang['Adr_battle_attributes'],
		'L_PHY_ATT' => $lang['Adr_battle_phy_att'],
		'L_PHY_DEF' => $lang['Adr_battle_phy_def'],
		'L_MAG_ATT' => $lang['Adr_battle_mag_att'],
		'L_MAG_DEF' => $lang['Adr_battle_mag_def'],
		'L_ALIGNMENT' => $lang['Adr_battle_alignment'],
		'L_ELEMENT' => $lang['Adr_battle_element'],
		'L_CLASS' => $lang['Adr_battle_class'],
      	'ALIGNMENT' => adr_get_lang($challenger_alignment['alignment_name']),
      	'ELEMENT' => adr_get_lang($challenger_element['element_name']),
		'CLASS' => adr_get_lang($challenger_class['class_name']),
		'M_ATT' => $bat['battle_challenger_magic_attack'],
		'M_DEF' => $bat['battle_challenger_magic_resistance'],
		'MONSTER_M_ATT' => $bat['battle_opponent_magic_attack'],
		'MONSTER_M_DEF' => $bat['battle_opponent_magic_resistance'],
      	'MONSTER_ALIGNMENT' => adr_get_lang($monster_alignment_name['alignment_name']),
      	'MONSTER_ELEMENT' => adr_get_lang($monster_element_name['element_name']),
		'HP_EMPTY' => $challenger_hp_empty,
		'MP_EMPTY' => $challenger_mp_empty,
		'MONSTER_HP_EMPTY' => $opponent_hp_empty,
		'MONSTER_MP_EMPTY' => $opponent_mp_empty,
		'TAUNT_LIST' => '',// $level_list,
		'L_COMMS' => '',//$lang['Adr_pvp_comms'],
		'L_TYPE_HERE' => $lang['Adr_pvp_custom_taunt'],
		'L_CUSTOM_SENTANCE' => $lang['Adr_pvp_taunt'],
		'S_CHATBOX' => append_sid("adr_battle_chatbox.$phpEx?battle_id=".$bat['battle_id']),
	));


$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

 
?> 
