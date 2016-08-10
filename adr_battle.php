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
include($phpbb_root_path . 'common.' . $phpEx);

$loc     = 'town';
$sub_loc = 'adr_battle';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR);
init_userprefs($userdata);
// End session management
//
$user_id     = $userdata['user_id'];
$user_points = $userdata['user_points'];
include($phpbb_root_path . 'adr/includes/adr_global.' . $phpEx);
include($phpbb_root_path . 'rabbitoshi/language/lang_' . $board_config['default_lang'] . '/lang_rabbitoshi.' . $phpEx);

// Sorry , only logged users ...
if (!$userdata['session_logged_in'])
{
	$redirect = "adr_battle.$phpEx";
	$redirect .= (isset($user_id)) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
} //!$userdata['session_logged_in']

// Get the general config
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
adr_levelup_check($user_id);
adr_weight_check($user_id);

if (!$adr_general['battle_enable'])
{
	adr_previous(Adr_battle_disabled, adr_character, '');
} //!$adr_general['battle_enable']

// Deny access if user is imprisioned
if ($userdata['user_cell_time'])
{
	adr_previous(Adr_shops_no_thief, adr_cell, '');
} //$userdata['user_cell_time']

// Includes the tpl and the header
adr_template_file('adr_battle_body.tpl');
include($phpbb_root_path . 'includes/page_header.' . $phpEx);

// Select pet infos
include($phpbb_root_path . 'rabbitoshi/includes/functions_rabbitoshi.' . $phpEx);
$pet_invoc = '1';
$sql       = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE . " 
WHERE owner_id = $user_id ";
if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not get pet info', '', __LINE__, __FILE__, $sql);
} //!$result = $db->sql_query($sql)
$rabbit_user = $db->sql_fetchrow($result);
if (!$rabbit_user['owner_id'])
{
	$pet_invoc = '0';
} //!$rabbit_user['owner_id']
$sql = "SELECT * FROM  " . RABBITOSHI_GENERAL_TABLE;
if (!$result = $db->sql_query($sql, false, 'rabbitoshi_config'))
{
	message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
} //!$result = $db->sql_query($sql, false, 'rabbitoshi_config')
$rabbit_general = rabbitoshi_get_general();

$equip             = isset($_POST['equip']);
$attack            = isset($_POST['attack']);
$spell             = isset($_POST['spell']);
$spell2            = isset($_POST['spell2']);
$potion            = isset($_POST['potion']);
$defend            = isset($_POST['defend']);
$flee              = isset($_POST['flee']);
$scan              = isset($_POST['scan']);
$invoc             = isset($_POST['invoc']);
$pet_attack        = isset($_POST['pet_attack']);
$pet_magicattack   = isset($_POST['pet_magicattack']);
$pet_specialattack = isset($_POST['pet_specialattack']);
// V: doing that because :-°
$petstuff          = $invoc || $pet_attack || $pet_magicattack || $pet_specialattack;

$bat = adr_get_battle($user_id);
$battle_started = !empty($bat['battle_id']);

if (!$battle_started && !$equip)
{
	// Moved the equip screen infos into adr_funtions_battle_setup.php
	include_once($phpbb_root_path . '/adr/includes/adr_functions_battle_setup.' . $phpEx);
	adr_battle_equip_screen($user_id);
} //!(is_numeric($bat['battle_id'])) && !$equip
else if (!(is_numeric($bat['battle_id'])) && $equip)
{
	// Let's calculate all the statistics now
	if ($adr_general['Adr_character_limit_enable'] == '1')
		adr_battle_quota_check($user_id);
	
	// Fix the items ids
	$armor   = intval($HTTP_POST_VARS['item_armor']);
	$buckler = intval($HTTP_POST_VARS['item_buckler']);
	$helm    = intval($HTTP_POST_VARS['item_helm']);
	$greave  = intval($HTTP_POST_VARS['item_greave']);
	$boot    = intval($HTTP_POST_VARS['item_boot']);
	$gloves  = intval($HTTP_POST_VARS['item_gloves']);
	$amulet  = intval($HTTP_POST_VARS['item_amulet']);
	$ring    = intval($HTTP_POST_VARS['item_ring']);
	
	// Battle start infos gone into adr_functions_battle_setup.php
	include_once($phpbb_root_path . '/adr/includes/adr_functions_battle_setup.' . $phpEx);
	adr_battle_equip_initialise($user_id, $armor, $buckler, $helm, $gloves, $amulet, $ring, $greave, $boot);
	adr_battle_effects_initialise($user_id, 0, '', 0);
	
	// V: auto-call pet
	$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
	SET creature_invoc = 1
	WHERE owner_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, '', __LINE__, __FILE__, $usql);
	} //!$db->sql_query($sql)

	// Update battle limit for user
	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_battle_limit = character_battle_limit - 1  
			WHERE character_id = $user_id ";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle limit', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
} //!(is_numeric($bat['battle_id'])) && $equip

// Let's sort out the start animations...
// Make table for start battle sequence...
// 0 = Standing image , 1 = Attack image
$user_action    = 0;
$monster_action = 0;

$bat = adr_get_battle($user_id);

// Get the monster infos
$monster = adr_get_monster_infos($bat['battle_opponent_id']);

// Get character infos
$challenger = adr_get_user_infos($user_id);

$user_ma            = $bat['battle_challenger_magic_attack'];
$user_md            = $bat['battle_challenger_magic_resistance'];
$monster_ma         = $bat['battle_opponent_magic_attack'];
$monster_md         = $bat['battle_opponent_magic_resistance'];
$challenger_element = $challenger['character_element'];
$opponent_element   = $monster['monster_base_element'];
$loot_id            = $bat['battle_opponent_id'];
$battle_round       = $bat['battle_round'];

### START armour info arrays ###
// array info: 0=helm, 1=armour, 2=gloves, 3=buckler, 4=amulet, 5=ring, 6=hp_regen, 7=mp_regen
// V: 8 greave, 9 boot
$armour_info             = explode('-', $bat['battle_challenger_equipment_info']);
$helm_equip              = !empty($armour_info[0]) ? $armour_info[0] : 0;
$armour_equip            = !empty($armour_info[1]) ? $armour_info[1] : 0;
$gloves_equip            = !empty($armour_info[2]) ? $armour_info[2] : 0;
$buckler_equip           = !empty($armour_info[3]) ? $armour_info[3] : 0;
$amulet_equip            = !empty($armour_info[4]) ? $armour_info[4] : 0;
$ring_equip              = !empty($armour_info[5]) ? $armour_info[5] : 0;
$greave_equip            = !empty($armour_info[8]) ? $armour_info[8] : 0;
$boot_equip              = !empty($armour_info[9]) ? $armour_info[9] : 0;
### END armour info arrays ###
### START restriction checks ###
$item_sql                = adr_make_restrict_sql($challenger);
### END restriction checks ###
$challenger_intelligence = $bat['battle_challenger_intelligence'];
$opponent_message_enable = $bat['battle_opponent_message_enable'];
$opponent_message        = $bat['battle_opponent_message'];

$hp_regen = 0;
$mp_regen = 0;
$battle_message = '';

$user_action        = null;
$monster_action     = null;
$attack_img         = null;
$attackwith_overlay = null;

if ((is_numeric($bat['battle_id']) && $bat['battle_type'] == 1)
	&& ($petstuff || $attack || $spell || $potion || $defend || $flee || $equip || $spell2))
{
	// Prefix challenger battle message
	$battle_message .= '<span style="color: blue">[' . $lang['Adr_battle_msg_check'] . htmlspecialchars($challenger['character_name']) . ']: </span>';
	if (($bat['battle_round'] == '0') && ($bat['battle_turn'] == '2'))
	{ // V: this is the early beginning.
		$battle_message .= $monster['monster_name'] . ' ' . $lang['Adr_battle_msg_monster_start'] . '<br>';
	} //($bat['battle_round'] == '0') && ($bat['battle_turn'] == '2')
	else if ($scan && $bat['battle_turn'] == 1)
	{
		rabbit_pet_regen();
		adr_use_hp_amulet();
		adr_use_mp_ring();
		
		// Check if the scan failed or not
		$scan_dice    = rand(20, 60);
		$scan_success = ($challenger_intelligence + $scan_dice);
		if ($scan_success > 69)
		{
			($opponent_message_enable == '') ? $scan_message = '' . $lang['Adr_battle_scan_no_message'] . '' : $scan_message = '' . $lang['Adr_battle_scan_success'] . ' :<br />' . $opponent_message . '<br />';
			$battle_message .= sprintf($scan_message) . '<br />';
		} //$scan_success > 69
		else
		{
			$battle_message .= sprintf($lang['Adr_battle_scan_fail']) . '<br />';
		}
		
		adr_set_turn($user_id, BATTLE_TURN_MONSTER);
	} // end if scan
	else if ($flee && $bat['battle_turn'] == BATTLE_TURN_PLAYER)
	{
		$dice         = rand(1, 20);
		$monster_dice = rand(1, 20);
		
		// To flee you must roll higher than opponent or roll straight 20. 1= auto fail
		if (($dice > $monster_dice && $dice != '1') || $dice == '20')
		{
			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_result = 3 ,
	            	battle_finish = " . time() . " 
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if (!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_flees = (character_flees + 1)
				WHERE character_id = '$user_id'";
			if (!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
			
			adr_items_clear_stolen();
			adr_items_clear_broken();

			rabbit_reset_pet();
			$message = sprintf($lang['Adr_battle_flee'], $challenger['character_name']);
			$message .= '<br /><br />' . sprintf($lang['Adr_battle_return'], "<a href=\"" . 'adr_battle.' . $phpEx . "\">", "</a>");
			$message .= '<br /><br />' . sprintf($lang['Adr_character_return'], "<a href=\"" . 'adr_character.' . $phpEx . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		} //(($dice > $monster_dice) && ($dice != '1')) || ($dice == '20')
		else
		{
			rabbit_pet_regen();
			
			// If flee attempt fails
			// Create failure message
			$battle_message .= sprintf($lang['Adr_battle_flee_fail'], $challenger['character_name']) . '<br>';
			
			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_turn = 2, battle_round = (battle_round + 1)
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if (!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
		}
	} // end if flee
	else if ($spell && $bat['battle_turn'] == BATTLE_TURN_PLAYER)
	{
		// Define the weapon quality and power
		$item_spell = intval($HTTP_POST_VARS['item_spell']);
		$power      = 0;
		$damage     = 0;
		
		if ($item_spell && ($item = adr_get_item_in_battle($item_spell)))
		{
			adr_check_mp($challenger, $item, 'item');
			$dice     = rand(0, 5);
			$power    = (($item['item_power']) + $item['item_add_power'] + $dice);
			$mp_usage = $item['item_power'] + $item['item_mp_use'];
			if ($mp_usage == '')
			{
				adr_previous('Adr_battle_check', 'adr_battle', '');
			} //$mp_usage == ''
			
			//adr_use_item($item_spell , $user_id);
			adr_substract_mp($mp_usage);
		} // end if item_spell
    else
    { // V: this is totes supposed to error out
      adr_previous('Adr_battle_no_spell', 'adr_battle', '');
    }
		
		if ($item['item_type_use'] == 11)
		{
			adr_spell_offensive();
		} // end if item type 11
		
		else if ($item['item_type_use'] == 12)
		{
			adr_spell_defensive();
		} // end if item type 12
	} // end if spell
	else if ( $spell2 && $bat['battle_turn'] == BATTLE_TURN_PLAYER )
	{
		// Define the weapon quality and power
		$item_spell2 = intval($HTTP_POST_VARS['item_spell2']);
		$power = 0;
		$damage = 0;

		if ( $item_spell2 )
		{
			$item = adr_get_spell($item_spell2, ADR_ERROR_ON_EMPTY);

			if ($item['spell_items_req'] !='' && $item['spell_items_req'] !='0')
			{
				adr_spell_check_components($item_spell2, $user_id, 'adr_battle');
			}

			adr_check_mp($challenger, $item, 'spell');

			$power = (($item['spell_power'] * 1.2) + $item['spell_add_power']);
			$mp_usage = ($item['spell_mp_use'] + $item['spell_power']);

			adr_use_item($item_spell2 , $user_id);
			adr_substract_mp($mp_usage);
		}
    else
    {
      adr_previous ( 'Adr_battle_no_spell_learned' , 'adr_battle' , '' );
    }

		if ( $item['item_type_use'] == 107 )
		{ // magic attack
			adr_magic_attack();
		} // end if item type 107

		if ( $item['item_type_use'] == 108 )
		{
			adr_magic_healing();
		} // end if item type 108
	
		else if ( $item['item_type_use'] == 109 )
		{
			adr_magic_defense();
		} // end if item type 109
	} // end if spell2
	else if ($potion && $bat['battle_turn'] == BATTLE_TURN_PLAYER)
	{
		// Define the weapon quality and power
		$item_potion = intval($HTTP_POST_VARS['item_potion']);
		$power       = 1;
		
		if ($item_potion && ($item = adr_get_item_in_battle($item_potion)))
		{
			if ($challenger['character_mp'] < 1)
			{
				adr_previous(Adr_battle_check, 'adr_battle', '');
			} //$challenger['character_mp'] < 0
			
			$power             = ($item['item_power'] + $item['item_add_power']);
			$item['item_name'] = adr_get_lang($item['item_name']);
			
			adr_use_item($item_potion, $user_id);
		} // end if item_potion
    else
    {
      adr_previous('Adr_battle_no_potion', 'adr_battle', '');
    }
		
		if ($item['item_type_use'] == 15)
		{
			adr_potion_hp();
		} // end if item type 15
		else if ($item['item_type_use'] == 16)
		{
			adr_potion_mp();
		} // end if item type 16
		else if ($item['item_type_use'] == 19)
		{
			adr_potion_generic();
		} // end if item type 19
	} // end if potion
	else if ($pet_specialattack && $bat['battle_turn'] == BATTLE_TURN_PLAYER)
	{
		adr_pet_special();
	} // end if pet special attack
	else if ($pet_attack && $bat['battle_turn'] == BATTLE_TURN_PLAYER)
	{
		adr_pet_attack();
	} // end if pet attack
	else if ($pet_magicattack && $bat['battle_turn'] == BATTLE_TURN_PLAYER)
	{
		adr_pet_magic();
	} // end of special attack
	else if ($attack && $bat['battle_turn'] == BATTLE_TURN_PLAYER)
	{
		// Define the weapon quality and power
		$weap    = intval($HTTP_POST_VARS['item_weapon']);
		$power   = 1;
		$quality = 0;
		$dice    = rand(0, 5);
		if ($weap && ($item = adr_get_item_in_battle($weap)))
		{
			if ($challenger['character_mp'] < $item['item_mp_use']
				|| $challenger['character_mp'] < 0 || $item['item_mp_use'] == '')
			{
				adr_previous(Adr_battle_check, 'adr_battle', '');
			} //$challenger['character_mp'] < $item['item_mp_use'] || $challenger['character_mp'] < 0 || $item['item_mp_use'] == ''
			
			adr_substract_mp($item['item_mp_use']);

			// Define theses values according to the item type ( enchanted weapon are better than normal weapons )
			$quality = ($item['item_type_use'] == 6) ? ($item['item_quality'] * 2) : $item['item_quality'];
			$dice    = rand(0, 5);
			$power   = ($item['item_type_use'] == 6) ? ($item['item_power'] * 3) + $dice + ($char['might'] * 0.2) + $item['item_add_power'] : ($item['item_power'] * 2) + $item['item_add_power'] + $dice + ($char['might'] * 0.2);
			
			rabbit_pet_regen();
			adr_use_hp_amulet();
			adr_use_mp_ring();

			adr_use_item($weap, $user_id);
		} // end if weapon

		// Let's sort out the weapon animations...
		// Make table for start battle sequence...
		// 0 = Standing image , 1 = Attack image
		$damage = 0;
		$user_action        = 1;
		$monster_action     = 1;
		$attack_img         = isset($item) ? $item['item_name'] : '';
		$attackwith_overlay = ((file_exists("adr/images/battle/spells/" . $attack_img . ".gif"))) ? '<img src="adr/images/battle/spells/' . $attack_img . '.gif" width="256" height="96" border="0">' : '';

		list($crit_result, $power) = adr_battle_make_crit_roll($bat['battle_challenger_att'], $challenger['character_level'], $bat['battle_opponent_def'], $item['item_type_use'], $power, $quality, 20);


		if ($item['item_name'] == '')
		{
			adr_attack_bare();
		}
		else
		{
			adr_attack_weap();
		}

		if (($item['item_duration'] < '2') && ($item['item_name'] != ''))
		{
			$battle_message .= '</span><span class="gensmall">'; // set new span class
			$battle_message .= '&nbsp;&nbsp;>&nbsp;' . sprintf($lang['Adr_battle_attack_dura'], $challenger['character_name'], adr_get_lang($item['item_name'])) . '<br>';
			$battle_message .= '</span><span class="genmed">'; // reset span class to default
		} //($item['item_duration'] < '2') && ($item['item_name'] != '')

		// Update the database
		$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
			SET battle_opponent_hp = battle_opponent_hp - " . intval($damage) . ",
				battle_turn = 2 , 
				battle_round = (battle_round + 1),
				battle_challenger_dmg = $damage
			WHERE battle_challenger_id = $user_id
			AND battle_result = 0
			AND battle_type = 1 ";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
		} //!($result = $db->sql_query($sql))
	} // end of attack
	else if ($defend && $bat['battle_turn'] == BATTLE_TURN_PLAYER)
	{
		$def          = TRUE;
		$power        = floor(($monster['monster_level'] * rand(1, 3)) / 2);
		rabbit_pet_regen();
		
		$battle_message .= sprintf($lang['Adr_battle_defend'], $challenger['character_name'], $monster['monster_name']) . '<br>';
		
		if ($armour_info[3] != '0')
		{
			adr_shield_skill_check($user_id);
		}
		
		// Update the database
		$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
			SET battle_turn = 2,
				 battle_round = (battle_round + 1)
			WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
		} //!($result = $db->sql_query($sql))
		// Let's sort out the defend animations...
		// Make table for start battle sequence...
		// 0 = Standing image , 1 = Attack image
		$user_action        = 0;
		$monster_action     = 1;
		$attack_img         = $item['item_name'];
		$attackwith_overlay = ((file_exists("adr/images/battle/spells/" . $attack_img . ".gif"))) ? '<img src="adr/images/battle/spells/' . $attack_img . '.gif" width="256" height="96" border="0">' : '';
	} // end if defend
	
	// Get the user infos
	$challenger = adr_get_user_infos($user_id);
	
	##=== START: additional status checks on user ===##
  if (($bat['battle_turn'] == BATTLE_TURN_PLAYER)
    && ($petstuff || $attack || $item_spell || $item_potion || $defend || $flee || $equip || $item_spell2))
	{
		$hp_regen = adr_hp_regen_check($user_id, $bat['battle_challenger_hp']);
		$challenger['character_hp'] += $hp_regen;
		$mp_regen = adr_mp_regen_check($user_id, $bat['battle_challenger_mp']);
		// V: commented out as I don't know if this is needed
		//$challenger['character_mp'] += $mp_regen;
		
		$battle_message .= '<span class="gensmall" style="color: #FF0000">'; // prefix new span class
		if ((($hp_regen > '0') && ($mp_regen == '0')) || (($mp_regen > '0') && ($hp_regen == '0')))
		{
			if ($hp_regen > '0')
			{
				$battle_message .= '&nbsp;&nbsp;>&nbsp;' . sprintf($lang['Adr_battle_regen_xp'], $challenger['character_name'], intval($hp_regen)) . '<br />';
			} //$hp_regen > '0'
			elseif ($mp_regen > '0')
			{
				$battle_message .= '&nbsp;&nbsp;>&nbsp;' . sprintf($lang['Adr_battle_regen_mp'], $challenger['character_name'], intval($mp_regen)) . '<br />';
			} //$mp_regen > '0'
		} //(($hp_regen > '0') && ($mp_regen == '0')) || (($mp_regen > '0') && ($hp_regen == '0'))
		elseif (($hp_regen > '0') && ($mp_regen > '0'))
		{
			$battle_message .= '&nbsp;&nbsp;>&nbsp;' . sprintf($lang['Adr_battle_regen_both'], $challenger['character_name'], intval($hp_regen), intval($mp_regen)) . '<br />';
		} //($hp_regen > '0') && ($mp_regen > '0')
		$battle_message .= '</span>'; // reset span class to default
	} //($bat['battle_turn'] == '1') && ($petstuff || $attack || $item_spell || $item_potion || $defend || $flee || $equip || $item_spell2)
	##=== END: additional status checks on user ===##
	
	$bat = adr_get_battle($user_id);
	
	if ($bat['battle_turn'] == BATTLE_TURN_MONSTER)
	{
		$who_opponent = rand(0, 20);
		
		if (($monster['monster_regeneration'] != '0') && ($bat['battle_opponent_hp'] < $bat['battle_opponent_hp_max']))
		{
			$monster_regen  = $monster['monster_regeneration'];
			$monster_new_hp = $bat['battle_opponent_hp'] + $monster_regen;
			
			if ($monster_new_hp > $bat['battle_opponent_hp_max'])
			{
				$monster_new_hp = $bat['battle_opponent_hp_max'];
			} //$monster_new_hp > $bat['battle_opponent_hp_max']
			
			$battle_message .= sprintf($lang['Adr_battle_monster_regen'], $monster['monster_name'], intval($monster_regen)) . '<br />';
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_hp = $monster_new_hp
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update monster info', '', __LINE__, __FILE__, $sql);
			} //!$result = $db->sql_query($sql)
		} //($monster['monster_regeneration'] != '0') && ($bat['battle_opponent_hp'] < $bat['battle_opponent_hp_max'])
		
		if (($monster['monster_mp_regeneration'] != '0') && ($bat['battle_opponent_mp'] < $bat['battle_opponent_mp_max']))
		{
			$monster_mp_regen = $monster['monster_mp_regeneration'];
			$monster_new_mp   = $bat['battle_opponent_mp'] + $monster_mp_regen;
			
			if ($monster_new_mp > $bat['battle_opponent_mp_max'])
			{
				$monster_new_mp = $bat['battle_opponent_mp_max'];
			} //$monster_new_mp > $bat['battle_opponent_mp_max']
			
			$battle_message .= sprintf($lang['Adr_battle_monster_mp_regen'], $monster['monster_name'], intval($monster_mp_regen)) . '<br />';
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_mp = $monster_new_mp
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update monster info', '', __LINE__, __FILE__, $sql);
			} //!$result = $db->sql_query($sql)
		} //($monster['monster_mp_regeneration'] != '0') && ($bat['battle_opponent_mp'] < $bat['battle_opponent_mp_max'])
		
		if (($monster['monster_base_mp_drain'] != '0') && ($challenger['character_mp'] > '0'))
		{
			$monster_mp_drain  = $monster['monster_base_mp_drain'];
			$challenger_new_mp = $challenger['character_mp'] - $monster_mp_drain;
			
			if ($challenger_new_mp < '0')
			{
				$challenger_new_mp = '0';
			} //$challenger_new_mp < '0'
			
			$battle_message .= sprintf($lang['Adr_battle_monster_mp_drain'], $monster['monster_name'], intval($monster_mp_drain)) . '<br />';
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_mp = $challenger_new_mp
				WHERE character_id = $user_id";
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update player info', '', __LINE__, __FILE__, $sql);
			} //!$result = $db->sql_query($sql)
		} //($monster['monster_base_mp_drain'] != '0') && ($challenger['character_mp'] > '0')
		
		if (($monster['monster_base_hp_drain'] != '0') && ($challenger['character_hp'] > '0'))
		{
			$monster_hp_drain  = $monster['monster_base_hp_drain'];
			$challenger_new_hp = $challenger['character_hp'] - $monster_hp_drain;
			
			if ($challenger_new_hp < '0')
			{
				$challenger_new_hp = '0';
			} //$challenger_new_hp < '0'
			
			$battle_message .= sprintf($lang['Adr_battle_monster_hp_drain'], $monster['monster_name'], intval($monster_hp_drain)) . '<br />';
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_hp = $challenger_new_hp
				WHERE character_id = $user_id";
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update player info', '', __LINE__, __FILE__, $sql);
			} //!$result = $db->sql_query($sql)
		} //($monster['monster_base_hp_drain'] != '0') && ($challenger['character_hp'] > '0')
		
		if (($monster['monster_base_mp_transfer'] != '0') && ($challenger['character_mp'] > '0'))
		{
			$monster_mp_drain  = $monster['monster_base_mp_transfer'];
			$challenger_new_mp = $challenger['character_mp'] - $monster_mp_drain;
			
			if ($challenger_new_mp < '0')
			{
				$challenger_new_mp = '0';
			} //$challenger_new_mp < '0'
			
			$monster_mp_transfer = $monster['monster_base_mp_transfer'];
			$monster_new_mp      = $bat['battle_opponent_mp'] + $monster_mp_transfer;
			
			if ($monster_new_mp > $bat['battle_opponent_mp_max'])
			{
				$monster_new_mp = $bat['battle_opponent_mp_max'];
			} //$monster_new_mp > $bat['battle_opponent_mp_max']
			
			$battle_message .= sprintf($lang['Adr_battle_monster_mp_transfer'], $monster['monster_name'], intval($monster_mp_drain)) . '<br />';
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_mp = $monster_new_mp
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update monster info', '', __LINE__, __FILE__, $sql);
			} //!$result = $db->sql_query($sql)
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_mp = $challenger_new_mp
				WHERE character_id = $user_id";
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update player info', '', __LINE__, __FILE__, $sql);
			} //!$result = $db->sql_query($sql)
		} //($monster['monster_base_mp_transfer'] != '0') && ($challenger['character_mp'] > '0')
		
		if (($monster['monster_base_hp_transfer'] != '0') && ($challenger['character_hp'] > '0'))
		{
			$monster_hp_drain  = $monster['monster_base_hp_transfer'];
			$challenger_new_hp = $challenger['character_hp'] - $monster_hp_drain;
			
			if ($challenger_new_hp < '0')
			{
				$challenger_new_hp = '0';
			} //$challenger_new_hp < '0'
			
			$monster_hp_transfer = $monster['monster_base_hp_transfer'];
			$monster_new_hp      = $bat['battle_opponent_hp'] + $monster_hp_transfer;
			
			if ($monster_new_hp > $bat['battle_opponent_hp_max'])
			{
				$monster_new_hp = $bat['battle_opponent_hp_max'];
			} //$monster_new_hp > $bat['battle_opponent_hp_max']
			
			$battle_message .= sprintf($lang['Adr_battle_monster_hp_transfer'], $monster['monster_name'], intval($monster_hp_drain)) . '<br />';
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
				SET battle_opponent_hp = $monster_new_hp
				WHERE battle_challenger_id = $user_id
				AND battle_result = 0
				AND battle_type = 1 ";
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update monster info', '', __LINE__, __FILE__, $sql);
			} //!$result = $db->sql_query($sql)
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_hp = $challenger_new_hp
				WHERE character_id = $user_id";
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update player info', '', __LINE__, __FILE__, $sql);
			} //!$result = $db->sql_query($sql)
		} //($monster['monster_base_hp_transfer'] != '0') && ($challenger['character_hp'] > '0')
		
		if (($rabbit_user['creature_invoc'] == '1') && ($who_opponent > 15) && ($rabbit_user['creature_health'] > 0))
		{
			$power = rand(0, 20);
			if ($power == '20') //define critical hit
			{
				$monster_damage = (((rand(1, 10) * $rabbit_user['creature_level']) - $rabbit_user['creature_armor']) + rand(1, 10));
				if ($monster_damage < 0) //define if damage is negative
				{
					$monster_damage = rand(1, 3);
				} //$monster_damage < 0
				$damage_ratio = ($rabbit_user['creature_health'] - $monster_damage);
				if ($damage_ratio < 0) //define if health is negative
				{
					$monster_damage = ($rabbit_user['creature_health_max'] - $rabbit_user['creature_health']);
				} //$damage_ratio < 0
				$battle_message .= sprintf($lang['Adr_battle_monster_success_critical'], intval($monster_damage)) . '<br />';
				
				$statut_dice = rand(1, 4); //define the change of health statut
				
				if ($statut_dice == '1')
				{
					$new_statut = '1';
					$battle_message .= sprintf($lang['Adr_battle_pet_newstatut_1']) . '<br />';
				} //$statut_dice == '1'
				if ($statut_dice == '2')
				{
					$new_statut = '2';
					$battle_message .= sprintf($lang['Adr_battle_pet_newstatut_2']) . '<br />';
				} //$statut_dice == '2'
				if ($statut_dice == '3')
				{
					$new_statut = '3';
					$battle_message .= sprintf($lang['Adr_battle_pet_newstatut_3']) . '<br />';
				} //$statut_dice == '3'
				if ($statut_dice == '4')
				{
					$new_statut = '4';
					$battle_message .= sprintf($lang['Adr_battle_pet_newstatut_4']) . '<br />';
				} //$statut_dice == '4'
				$damage_ratio = ($rabbit_user['creature_health'] - $monster_damage);
				if ($damage_ratio < 0) //define if health is negative
				{
					$monster_damage = ($rabbit_user['creature_health_max'] - $rabbit_user['creature_health']);
				} //$damage_ratio < 0
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					Set creature_statut = '$new_statut',
					    creature_health = ( creature_health - $monster_damage )
				WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				} //!$result = $db->sql_query($sql)
			} //$power == '20'
			else
			{
				$monster_damage = ((rand(1, 10) * $rabbit_user['creature_level']) - $rabbit_user['creature_armor']);
				if ($monster_damage < 0) //define if damage is negative
				{
					$monster_damage = rand(1, 3);
				} //$monster_damage < 0
				$damage_ratio = ($rabbit_user['creature_health'] - $monster_damage);
				if ($damage_ratio < 0) //define if health is negative
				{
					$monster_damage = ($rabbit_user['creature_health_max'] - $rabbit_user['creature_health']);
				} //$damage_ratio < 0
				$battle_message .= sprintf($lang['Adr_battle_monster_success'], intval($monster_damage)) . '<br />';
				
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
					SET creature_health = ( creature_health - $monster_damage )
					WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				} //!$result = $db->sql_query($sql)
			} // end of not crit
		} // end of invoc
		
		// V: after rabbitoshi played
		//  this fixes a dumb bug ;_;
		if ($bat['battle_opponent_hp'] > '0') // not rabbitoshi's turn
		{
			$monster_name                    = adr_get_lang($monster['monster_name']);
			$character_name                  = $challenger['character_name'];
			$monster['monster_crit_hit_mod'] = intval(2);
			$monster['monster_crit_hit']     = intval(20);
			$monster['monster_int']          = (10 + (rand(1, $monster['monster_level']) * 2)); //temp calc
			$monster['monster_str']          = (10 + (rand(1, $monster['monster_level']) * 2)); //temp calc
			
			// Prefix monster message
			// V: should use sprintf() here (and the other occurence for the player)
			$battle_message .= '<span style="color: orange">[' . $lang['Adr_battle_msg_check'] . $monster_name . ']: </span>';
			
			if ($def != TRUE)
				$power = ceil($monster['monster_level'] * rand(1, 3));
			else
				$power = floor(($monster['monster_level'] * rand(1, 3)) / 2);
			
			// Has the monster the ability to steal from user?
			$thief_chance = rand(1, 20);
			
			if (($board_config['Adr_thief_enable'] == '1') && ($thief_chance == '20'))
			{
				$sql = "SELECT item_id, item_name FROM  " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_monster_thief = '0'
				AND item_in_warehouse = '0'
				AND item_in_shop = '0'
				AND item_duration > '0'
				AND item_owner_id = '$user_id'
				AND item_id NOT IN ($helm_equip, $armour_equip, $gloves_equip, $buckler_equip, $amulet_equip, $ring_equip)
				ORDER BY rand() LIMIT 1";
				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, 'Could not query items for monster item steal', '', __LINE__, __FILE__, $sql);
				} //!($result = $db->sql_query($sql))
				$item_to_steal = $db->sql_fetchrow($result);
				
				// Rand to check type of thief attack
				$success_chance = rand(1, 20);
				$rand           = rand(1, 20);
				
				##=== START: steal item checks
				$challenger_item_spot_check = (20 + adr_modifier_calc($challenger['character_skill_thief']));
				$monster_item_attempt       = (((($rand + adr_modifier_calc($monster['monster_thief_skill'])) > $challenger_item_spot_check) && ($rand != '1')) || ($rand == '20')) ? TRUE : FALSE;
				##=== END: steal item checks
				
				##=== START: steal points checks
				$challenger_points_spot_check = (10 + adr_modifier_calc($challenger['character_skill_thief']));
				$monster_points_attempt       = (((($rand + $monster['monster_thief_skill']) > $challenger_points_spot_check) && ($rand != '1')) || ($rand == '20')) ? TRUE : FALSE;
				##=== END: steal points checks
				
				if (($success_chance == '20') && ($monster_item_attempt == TRUE) && ($item_to_steal['item_name'] != ''))
				{
					$damage = 0;
					
					// Mark the item as stolen
					$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
					SET item_monster_thief = 1
					WHERE item_owner_id = '$user_id'
					AND item_id = '" . $item_to_steal['item_id'] . "'";
					if (!($result = $db->sql_query($sql)))
					{
						message_die(GENERAL_ERROR, 'Could not update stolen item by monster', '', __LINE__, __FILE__, $sql);
					} //!($result = $db->sql_query($sql))
					
					$battle_message .= sprintf($lang['Adr_battle_opponent_thief_success'], $monster_name, adr_get_lang($item_to_steal['item_name']), $character_name);
				} //($success_chance == '20') && ($monster_item_attempt == TRUE) && ($item_to_steal['item_name'] != '')
				elseif (($success_chance >= '15') && ($success_chance != '20') && ($user_points > '0') && ($monster_points_attempt == TRUE))
				{
					$damage        = 0;
					$points_stolen = floor(($user_points / 100) * $board_config['Adr_thief_points']);
					subtract_reward($user_id, $points_stolen);
					$battle_message .= sprintf($lang['Adr_battle_opponent_thief_points'], $monster_name, $points_stolen, get_reward_name(), $character_name);
				} //($success_chance >= '15') && ($success_chance != '20') && ($user_points > '0') && ($monster_points_attempt == TRUE)
				else
				{
					$damage = 0;
					$battle_message .= sprintf($lang['Adr_battle_opponent_thief_failure'], $monster_name, adr_get_lang($item_to_steal['item_name']), $character_name);
				}
				// Let's sort out the monster theft animation
				$monster_action     = 0;
				$attack_img         = $item['item_name'];
				$attackwith_overlay = ((file_exists("adr/images/battle/monster/theft_attempt.gif"))) ? '<img src="adr/images/battle/monster/theft_attempt.gif" width="256" height="96" border="0">' : '';
			} // thief fail
			else
			{
				$attack_type  = rand(1, 20);
				##=== START: Critical hit code
				$threat_range = $monster['monster_crit_hit'];
				//			list($crit_result, $power) = explode('-', adr_battle_make_crit_roll($bat['battle_opponent_att'], $monster['monster_level'], $bat['battle_challenger_def'], 0, $power, 0, $threat_range, 0));
				##=== END: Critical hit code
				
				if (($bat['battle_opponent_mp'] > '0') && ($bat['battle_opponent_mp'] >= $bat['battle_opponent_mp_power']) && ($attack_type > '16'))
				{
					$damage            = 1;
					$power             = ceil($power + adr_modifier_calc($bat['battle_opponent_mp_power']));
					$monster_elemental = adr_get_element_infos($opponent_element);
					
					// Sort out magic check & opponents saving throw
					$dice        = rand(1, 20);
					$magic_check = ceil($dice + $bat['battle_opponent_mp_power'] + adr_modifier_calc($monster['monster_int']));
					$fort_save   = (11 + adr_modifier_calc($challenger['character_wisdom']));
					$success     = ((($magic_check >= $fort_save) && ($dice != '1')) || ($dice >= $threat_range)) ? TRUE : FALSE;
					
					if ($success === TRUE)
					{
						// Prefix msg if crit hit
						$battle_message .= ($dice >= $threat_range) ? $lang['Adr_battle_critical_hit'] . ' ' : '';
						
						// Work out attack type
						if ($challenger_element === $monster_elemental['element_oppose_weak'])
						{
							$damage = ceil(($power * ($monster_elemental['element_oppose_strong_dmg'] / 100)));
						} //$challenger_element === $monster_elemental['element_oppose_weak']
						elseif ($challenger_element === $opponent_element)
						{
							$damage = ceil(($power * ($monster_elemental['element_oppose_same_dmg'] / 100)));
						} //$challenger_element === $opponent_element
						elseif ($challenger_element === $monster_elemental['element_oppose_strong'])
						{
							$damage = ceil(($power * ($monster_elemental['element_oppose_weak_dmg'] / 100)));
						} //$challenger_element === $monster_elemental['element_oppose_strong']
						else
						{
							$damage = ceil($power);
						}
						
						// Fix dmg value
						$damage = ($damage < '1') ? rand(1, 3) : $damage;
						$damage = ($dice >= $threat_range) ? ($damage * $monster['monster_crit_hit_mod']) : $damage;
						$damage = ($damage > $challenger['character_hp']) ? $challenger['character_hp'] : $damage;
						
						// Fix attack msg type
						if ($monster['monster_base_custom_spell'] != '')
						{
							$battle_message .= sprintf($lang['Adr_battle_opponent_spell_success'], $monster_name, $monster['monster_base_custom_spell'], $character_name, $damage);
						} //$monster['monster_base_custom_spell'] != ''
						else
						{
							$battle_message .= sprintf($lang['Adr_battle_opponent_spell_success2'], $monster_name, $character_name, $damage);
						}
					} //$success === TRUE
					else
					{
						$damage = 0;
						$battle_message .= sprintf($lang['Adr_battle_opponent_spell_failure'], $monster_name, $character_name);
					}
					
					// Remove monster MP
					$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
					SET battle_opponent_mp = (battle_opponent_mp - '" . $bat['battle_opponent_mp_power'] . "')
					WHERE battle_challenger_id = '$user_id'
						AND battle_result = '0'
						AND battle_type = '1'";
					if (!($result = $db->sql_query($sql)))
					{
						message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
					} //!($result = $db->sql_query($sql))
				} //($bat['battle_opponent_mp'] > '0') && ($bat['battle_opponent_mp'] >= $bat['battle_opponent_mp_power']) && ($attack_type > '16')
				else
				{
					// Let's check if the attack succeeds
					$dice    = rand(1, 20);
					$success = (((($bat['battle_opponent_att'] + $dice) >= ($bat['battle_challenger_def'] + adr_modifier_calc($challenger['character_dexterity']))) && ($dice != '1')) || ($dice >= $threat_range)) ? TRUE : FALSE;
					$power   = ceil(($power / 2) + (adr_modifier_calc($monster['monster_str'])));
					$damage  = 1;
					
					if ($success == TRUE)
					{
						// Attack success , calculate the damage . Critical dice roll is still success
						$damage = ($power < '1') ? rand(1, 3) : $power;
						$damage = ($dice >= $threat_range) ? ceil($damage * $monster['monster_crit_hit_mod']) : ceil($damage);
						$damage = ($damage > $challenger['character_hp']) ? $challenger['character_hp'] : $damage;
						$battle_message .= ($dice >= $threat_range) ? $lang['Adr_battle_critical_hit'] . ' ' : '';
						$battle_message .= sprintf($lang['Adr_battle_opponent_attack_success'], $monster_name, $character_name, $damage);
					} //$success == TRUE
					else
					{
						$damage = 0;
						$battle_message .= sprintf($lang['Adr_battle_opponent_attack_failure'], $monster_name, $character_name);
					}
					// Let's sort out the monster theft animation
					$monster_action     = 1;
					$attack_img         = $item['item_name'];
					$attackwith_overlay = ((file_exists("adr/images/battle/monster/attack.gif"))) ? '<img src="adr/images/battle/monster/attack.gif" width="256" height="96" border="0">' : '';
				}
				
				// Prevent instant kills at start of battle
				if (($bat['battle_round'] == '0') && (($challenger['character_hp'] - $damage) < '1'))
					$character_hp = '1';
				else
				{
					$character_hp = '(character_hp - ' . $damage . ')';
				}
				$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_hp = $character_hp
				WHERE character_id = '$user_id'";
				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
				} //!($result = $db->sql_query($sql))
			}
			
			// End msg with round number
			$round_check    = (($bat['battle_round'] == '0') && ($bat['battle_turn'] == '2')) ? 'battle_round = (battle_round + 1), ' : '';
			$battle_message = '<font size="1"><div align="left">[Round ' . ($battle_round + 1) . ']</div></font>' . $battle_message;
			
			// Fix battle text
			$battle_text        = $battle_message . $bat['battle_text'];
			$battle_text_format = str_replace('<br />', "<br>", $battle_text);
			$battle_text_format = str_replace('\'', '%APOS%', $battle_text_format);

			// V: battle texts are too long ...
			if (strlen($battle_text) > 1000) {
				$battle_text = substr($battle_text, 0, 1000);

				// now, to make sure it doesn't stop after a "
				$text_end = substr($battle_text, 1000);
				$end_span_pos = strpos($text_end, '</span>'); // 7 is "</span>"'s length
				$battle_text .= substr($text_end, 0, substr($text_end, 0, $end_span_pos + 7));
			}
			
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
			SET battle_text = '" . str_replace("\'", "''", $battle_text_format) . "',
				battle_turn = 1,
				$round_check
				battle_opponent_dmg = $damage
			WHERE battle_challenger_id = '$user_id'
			AND battle_result = '0'
			AND battle_type = '1'";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not update battle at end of user turn', '', __LINE__, __FILE__, $sql);
			} //!($result = $db->sql_query($sql))
		} //$bat['battle_opponent_hp'] > '0'

		$bat = adr_get_battle($user_id);

		// Check for any stolen items
		$sql = " SELECT item_name FROM  " . ADR_SHOPS_ITEMS_TABLE . " 
		WHERE item_owner_id = '$user_id'
		AND item_monster_thief = '1'
		LIMIT 1";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
		} //!($result = $db->sql_query($sql))
		$stolen = $db->sql_fetchrow($result);
		
		// Get the user infos
		$sql = "SELECT c.* , u.user_avatar , u.user_avatar_type, u.user_allowavatar FROM " . ADR_CHARACTERS_TABLE . " c , " . USERS_TABLE . " u
		WHERE c.character_id = $user_id 
		AND c.character_id = u.user_id ";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not query user', '', __LINE__, __FILE__, $sql);
		} //!($result = $db->sql_query($sql))
		$challenger = $db->sql_fetchrow($result);
		
		$challenger_hp = $challenger['character_hp'];
		$opponent_hp   = $bat['battle_opponent_hp'];
		
		// We have to know if one of the opponents is dead
		if (($opponent_hp < 1 && $challenger_hp > 0) || (($opponent_hp < '1') && ($challenger_hp < '1')))
		{
			// The monster is dead , give money and xp to the users , then update the database
			
			// Get the experience earned
			$exp = rand($adr_general['battle_base_exp_min'], $adr_general['battle_base_exp_max']);
			if (($monster['monster_level'] - $challenger['character_level']) > 1)
			{
				$exp = floor((($monster['monster_level'] - $challenger['character_level']) * $adr_general['battle_base_exp_modifier']) / 100);
			} //($monster['monster_level'] - $challenger['character_level']) > 1
			
			// Share EXP
			$exp2 = round($exp / 10);
			$exp  = $exp + $count_members;
			$exp  = round($exp);
			if ($exp < 0)
			{
				$exp = 0;
			} //$exp < 0
			
			// Get the money earned
			$reward = rand($adr_general['battle_base_reward_min'], $adr_general['battle_base_reward_max']);
			if (($monster['monster_level'] - $challenger['character_level']) > 1)
			{
				$reward = floor((($monster['monster_level'] - $challenger['character_level']) * $adr_general['battle_base_reward_modifier']) / 100);
			} //($monster['monster_level'] - $challenger['character_level']) > 1
			
			$sql = " UPDATE  " . ADR_BATTLE_LIST_TABLE . " 
			SET battle_result = 1 ,
				battle_opponent_hp = 0,
				battle_finish = " . time() . ",
				battle_text = ''
			WHERE battle_challenger_id = $user_id
			AND battle_result = 0
			AND battle_type = 1 ";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);
			} //!($result = $db->sql_query($sql))
			
			// If $challenger['character_hp'] is < '1' then update sql to hp = 1
			$sql_update_hp = ($challenger['character_hp'] < '1') ? 'character_hp = 1,' : '';
			
			$sql = " UPDATE  " . USERS_TABLE . " 
			SET user_points = user_points + $reward
			WHERE user_id = $user_id ";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
			} //!($result = $db->sql_query($sql))
			
			$sql  = 'SELECT character_party FROM ' . ADR_CHARACTERS_TABLE . ' WHERE character_id = ' . $user_id;
			$re   = $db->sql_query($sql);
			$char = $db->sql_fetchrow($re);
			
			$sql = "UPDATE  " . ADR_CHARACTERS_TABLE . "
		        SET     character_victories = character_victories + 1 ,
		                character_sp = character_sp + '" . $bat['battle_opponent_sp'] . "',
						character_xp = character_xp + $exp
		        WHERE character_id = $user_id ";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
			} //!($result = $db->sql_query($sql))
			if ($char['character_party'] != 0)
			{
				$sql = "UPDATE  " . ADR_CHARACTERS_TABLE . "
			        SET     character_xp = character_xp + $exp2
			        WHERE character_party = " . $char['character_party'] . "
			AND character_id != " . $userdata['user_id'] . "						";
				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
				} //!($result = $db->sql_query($sql))
			} //$char['character_party'] != 0
			
			// Remove item stolen status
			$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
			SET item_monster_thief = 0 
			WHERE item_owner_id = $user_id ";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not update stolen item status', '', __LINE__, __FILE__, $sql);
			} //!($result = $db->sql_query($sql))
			
			adr_items_clear_broken();
			$message = sprintf($lang['Adr_battle_won'], $bat['battle_challenger_dmg'], $exp, $bat['battle_opponent_sp'], $reward, get_reward_name(), $challenger['character_hp'], $challenger['character_mp']);
			
			///Call Loot System/// 
			$message .= drop_loot($loot_id, $challenger['character_id'], $dropped_loot_list);
			
			// Check if the character killed a monster that he needed for a killing quest !
			$sql    = " SELECT * FROM " . ADR_QUEST_LOG_TABLE . "
	   		WHERE quest_kill_monster = '" . $monster['monster_name'] . "'
			AND quest_kill_monster_current_amount < quest_kill_monster_amount
			AND user_id = '" . $challenger['character_id'] . "'
	   		";
			$result = $db->sql_query($sql);
			if (!$result)
				message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql);
			if ($quest_log = $db->sql_fetchrow($result))
			{
				//Now increase the current amount killed value by 1 for each killing quest 
				//that requires still the monster the player just killed
				for ($i = 0; $i < count($quest_log = $db->sql_fetchrow($result)); $i++)
				{
					$sql    = "UPDATE " . ADR_QUEST_LOG_TABLE . "
					set quest_kill_monster_current_amount = quest_kill_monster_current_amount + 1 
					WHERE quest_kill_monster = '" . $monster['monster_name'] . "'
					AND quest_kill_monster_current_amount < quest_kill_monster_amount
					AND user_id = '" . $challenger['character_id'] . "'
					";
					$result = $db->sql_query($sql);
					if (!$result)
						message_die(GENERAL_ERROR, "Couldn't update quest", "", __LINE__, __FILE__, $sql);
				} //$i = 0; $i < count($quest_log = $db->sql_fetchrow($result)); $i++
			} //$quest_log = $db->sql_fetchrow($result)
			######### QUESTBOOK MOD v1.0.2 - END

			if ($rabbit_user['creature_invoc'] == '1')
			{
				rabbit_reset_pet();
				// V: dead pets don't gain exp
				if ($rabbit_user['creature_health'] > 0)
				{
					$pet_xp       = rand($rabbit_general['experience_min'], $rabbit_general['experience_max']);
					$pet_xp_lvl   = $pet_xp;
					$pet_xp_limit = ($rabbit_user['creature_experience_level_limit'] - ($rabbit_user['creature_experience_level'] + $pet_xp_lvl));
					
					if ($pet_xp_limit < 0)
					{
						$pet_xp_lvl = ($rabbit_user['creature_experience_level_limit'] - $rabbit_user['creature_experience_level']);
					} //$pet_xp_limit < 0
					$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . " SET
		         		creature_experience = creature_experience + '$pet_xp', 
		         		creature_experience_level = creature_experience_level + '$pet_xp_lvl' 
		  			WHERE owner_id = $user_id ";
					if (!$result = $db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
					} //!$result = $db->sql_query($sql)
					$message .= '<br />' . sprintf($lang['Adr_battle_pet_win'], $pet_xp);
				}
				else
				{
					$message .= '<br />' . $lang['Adr_battle_pet_was_dead'];
				}
			} //$rabbit_user['creature_invoc'] == '1'

			if ($stolen['item_name'] != '')
			{
				$message .= '<br />' . sprintf($lang['Adr_battle_stolen_items'], $monster['monster_name']);
			} //$stolen['item_name'] != ''
			$message .= '<br /><br />' . sprintf($lang['Adr_battle_return'], "<a href=\"" . 'adr_battle.' . $phpEx . "\">", "</a>");
			$message .= '<br /><br />' . sprintf($lang['Adr_character_return'], "<a href=\"" . 'adr_character.' . $phpEx . "\">", "</a>");
			
			message_die(GENERAL_MESSAGE, $message);
		} // end if one of opponent is dead
		
		if ($challenger_hp < 1 && $opponent_hp > 0)
		{
			// The character is dead , update the database
			
			$sql = " UPDATE  " . ADR_BATTLE_LIST_TABLE . " 
			SET battle_result = 2,
				battle_finish = " . time() . ",
				battle_text = '' 
			WHERE battle_challenger_id = $user_id
			AND battle_result = 0
			AND battle_type = 1 ";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);
			} //!($result = $db->sql_query($sql))
			
			$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_hp = 0 ,
			    character_defeats = character_defeats + 1
			WHERE character_id = $user_id ";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
			} //!($result = $db->sql_query($sql))
			
			// Delete stolen items from users inventory
			$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_monster_thief = 1
			AND item_owner_id = $user_id ";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not delete stolen items', '', __LINE__, __FILE__, $sql);
			} //!($result = $db->sql_query($sql))
			
			// Delete broken items from users inventory
			$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_duration < 1 
			AND item_owner_id = $user_id ";
			if (!($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not delete broken items', '', __LINE__, __FILE__, $sql);
			} //!($result = $db->sql_query($sql))
			// Pet part
			if ($rabbit_user['creature_invoc'] == '1')
			{
				// Set invoc default stats
				$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
			Set creature_invoc = '0'
		WHERE owner_id = $user_id ";
				if (!$result = $db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
				} //!$result = $db->sql_query($sql)
				
				// Set default pet health statut
				if ($rabbit_user['creature_statut'] == '4')
				{
					$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
			Set creature_statut = '0'
		WHERE owner_id = $user_id ";
					if (!$result = $db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
					} //!$result = $db->sql_query($sql)
				} //$rabbit_user['creature_statut'] == '4'
			} //$rabbit_user['creature_invoc'] == '1'
			$message = sprintf($lang['Adr_battle_lost'], $monster['monster_name'], $bat['battle_opponent_dmg']);
			if ($stolen['item_name'] != '')
			{
				$message .= '<br /><br />' . sprintf($lang['Adr_battle_stolen_items_lost'], $monster['monster_name']);
			} //$stolen['item_name'] != ''
			$message .= '<br /><br />' . sprintf($lang['Adr_battle_temple'], "<a href=\"" . 'adr_temple.' . $phpEx . "\">", "</a>");
			$message .= '<br /><br />' . sprintf($lang['Adr_character_return'], "<a href=\"" . 'adr_character.' . $phpEx . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		} //$challenger_hp < 1 && $opponent_hp > 0
	} //$bat['battle_turn'] == 2
} //(is_numeric($bat['battle_id']) && $bat['battle_type'] == 1) && ($petstuff || $attack || $spell || $potion || $defend || $flee || $equip || $spell2)

// Prepare the items list
$weapon_list = '<select name="item_weapon">';
$weapon_list .= '<option value = "0" >' . $lang['Adr_battle_no_weapon'] . '</option>';
$spell_list = '<select name="item_spell">';
$spell_list .= '<option value = "0" >' . $lang['Adr_battle_no_spell'] . '</option>';
$potion_list = '<select name="item_potion">';
$potion_list .= '<option value = "0" >' . $lang['Adr_battle_no_potion'] . '</option>';

$sql = " SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . "
	WHERE spell_owner_id = $user_id 
	AND (spell_battle = '0' OR spell_battle = '2')
	ORDER BY spell_name ASC";
if (!($result = $db->sql_query($sql)))
{
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
} //!($result = $db->sql_query($sql))
$spells      = $db->sql_fetchrowset($result);
$spell2_list = '<select name="item_spell2">';
$spell2_list .= '<option value = "0" >' . $lang['Adr_battle_no_spell_learned'] . '</option>';

$avatar_img = '';
if (($userdata['user_avatar_type']) && ($userdata['user_allowavatar']))
{
	switch ($userdata['user_avatar_type'])
	{
		case USER_AVATAR_UPLOAD:
			$avatar_img = ($board_config['allow_avatar_upload']) ? '<img src="' . $board_config['avatar_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_REMOTE:
			$avatar_img = ($board_config['allow_avatar_remote']) ? '<img src="' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_GALLERY:
			$avatar_img = ($board_config['allow_avatar_local']) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
	} //$userdata['user_avatar_type']
} //($userdata['user_avatar_type']) && ($userdata['user_allowavatar'])

// First select the available items
$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_in_shop = 0 
		$item_sql
		AND item_duration > 0
		AND item_in_warehouse = 0
		AND item_monster_thief = 0
		AND item_owner_id = $user_id ";
if (!($result = $db->sql_query($sql)))
{
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
} //!($result = $db->sql_query($sql))
$items = $db->sql_fetchrowset($result);

// V: moved below that end-of-if
// I don't know who's making ADR changelogs, but
// he's being a damn pig sometimes
for ($i = 0, $count_items = count($items); $i < $count_items; $i++)
{
	$item_name  = adr_get_lang($items[$i]['item_name']);
	$item_power = ($adr_general['item_power_level'] == '1') ? ($items[$i]['item_power'] + $items[$i]['item_add_power']) : $items[$i]['item_power'];

	
	if ( ( $items[$i]['item_type_use'] ==  5 || $items[$i]['item_type_use'] ==  6 ||
		// weap prof mod : 40-46
		$items[$i]['item_type_use'] ==  40 || $items[$i]['item_type_use'] ==  41 || $items[$i]['item_type_use'] ==  42 || $items[$i]['item_type_use'] == 43
		|| $items[$i]['item_type_use'] ==  44 || $items[$i]['item_type_use'] ==  45 || $items[$i]['item_type_use'] ==  46 )
	 && ( $items[$i]['item_mp_use'] <= $challenger['character_mp'] ) )
	{
		$item_weapon = isset($HTTP_POST_VARS['item_weapon']) ? $HTTP_POST_VARS['item_weapon'] : null;
		$weapon_selected = ($item_weapon == $items[$i]['item_id']) ? 'selected' : '';
		$weapon_list .= '<option value = "' . $items[$i]['item_id'] . '" ' . $weapon_selected . '>' . $item_name . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )' . '</option>';
	}
	else if (($items[$i]['item_type_use'] == 11 || $items[$i]['item_type_use'] == 12) && (($items[$i]['item_power'] + $items[$i]['item_mp_use']) <= $challenger['character_mp']))
	{
		$spell_selected = ($HTTP_POST_VARS['item_spell'] == $items[$i]['item_id']) ? 'selected' : '';
		$spell_list .= '<option value = "' . $items[$i]['item_id'] . '" ' . $spell_selected . ' >' . $item_name . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )' . '</option>';
	}
	else if ($items[$i]['item_type_use'] == 15 || $items[$i]['item_type_use'] == 16 || $items[$i]['item_type_use'] == 19)
	{
		$potion_selected = ($HTTP_POST_VARS['item_potion'] == $items[$i]['item_id']) ? 'selected' : '';
		$potion_list .= '<option value = "' . $items[$i]['item_id'] . '" ' . $potion_selected . ' >' . $item_name . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )' . '</option>';
	}
} //$i = 0, $count_items = count($items); $i < $count_items; $i++
for ($s = 0; $s < count($spells); $s++)
{
	$spells_power = $spells[$s]['spell_power'] + $spells[$s]['spell_add_power'];
	
	if (($spells[$s]['item_type_use'] == 11 || $spells[$s]['item_type_use'] == 108 || $spells[$s]['item_type_use']) && ($spells[$s]['spell_mp_use'] <= $challenger['character_mp']))
	{
		$spell2_selected = ($HTTP_POST_VARS['item_spell2'] == $spells[$s]['spell_id']) ? 'selected' : '';
		$spell2_list .= '<option value = "' . $spells[$s]['spell_id'] . '" ' . $spell2_selected . '>' . adr_get_lang($spells[$s]['spell_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $spells_power . ' )' . '</option>';
	} //($spells[$s]['item_type_use'] == 11 || $spells[$s]['item_type_use'] == 108 || $spells[$s]['item_type_use']) && ($spells[$s]['spell_mp_use'] <= $challenger['character_mp'])
} //$s = 0; $s < count($spells); $s++
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
$monster_element_name   = adr_get_element_infos($monster['monster_base_element']);
$monster_alignment_name = adr_get_alignment_infos(2);
// V: I don't know no monster base align'
//(!$monster['monster_base_alignment']) ?: 
//	adr_get_alignment_infos($monster['monster_base_alignment']);
$challenger_element     = adr_get_element_infos($challenger['character_element']);
$challenger_alignment   = adr_get_alignment_infos($challenger['character_alignment']);
$challenger_class       = adr_get_class_infos($challenger['character_class']);
###=== END: grab challenger & opponent infos ===###

list($creature_health_width, $creature_health_empty) = adr_make_bars($rabbit_user['creature_health'], $rabbit_user['creature_health_max'], '100');
list($creature_mp_width, $creature_mp_empty) = adr_make_bars($rabbit_user['creature_mp'], $rabbit_user['creature_max_mp'], '100');
list($creature_attack_width, $creature_attack_empty) = adr_make_bars($rabbit_user['creature_attack'], $rabbit_user['creature_attack_max'], '100');
list($creature_magicattack_width, $creature_magicattack_empty) = adr_make_bars($rabbit_user['creature_magicattack'], $rabbit_user['creature_magicattack_max'], '100');

// Grab pet details again
$sql = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE . "
		WHERE owner_id = $user_id ";
if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not get pet info', '', __LINE__, __FILE__, $sql);
} //!$result = $db->sql_query($sql)
$rabbit_user = $db->sql_fetchrow($result);

$ability       = '';
$ability_level = $rabbit_user['creature_ability'];
if ($ability_level == '0')
{
	$ability = ''; //$lang['Rabbitoshi_ability_lack'];
} //$ability_level == '0'
if ($ability_level == '1')
{
	$ability = $lang['Rabbitoshi_ability_regeneration'];
} //$ability_level == '1'
if ($ability_level == '2')
{
	$ability = $lang['Rabbitoshi_ability_health'];
} //$ability_level == '2'
if ($ability_level == '3')
{
	$ability = $lang['Rabbitoshi_ability_mana'];
} //$ability_level == '3'
if ($ability_level == '4')
{
	$ability = $lang['Rabbitoshi_ability_sacrifice'];
} //$ability_level == '4'
$magicattack = $rabbit_user['creature_magicattack'];

$invoc_table    = $pet_table = $pet_img = '';
$show_pet_table = $rabbit_user['creature_invoc'];
if ($show_pet_table == '1')
{
  // V: let's extract this to hide the last panel if no attacks are available
  $pet_can_attack = $rabbit_user['creature_attack'] || $magicattack || $ability;

	$pet_health_text = $rabbit_user['creature_health'] > 0 ? $lang['Rabbitoshi_battle_pet_health'] . ' : ' . $rabbit_user['creature_health'] . '/' . $rabbit_user['creature_health_max'] : 'Morte';
	$pet_table       = '
<table align="center" border="0" cellpadding="3" cellspacing="1" class="forumline" width="100%">
<tr>
	<th colspan="' . ($pet_can_attack ? 4 : 3) . '">' . $lang['Rabbitoshi_battle_pet_title' . ($rabbit_user['creature_health'] > 0 ? '' : '_dead')] . '</th>
</tr>
<tr align="center">
	<td class="row1" width="25%"><span class="gen">' . $rabbit_user['owner_creature_name'] . '</span><br /><img src="rabbitoshi/images/pets/' . $rabbit_user['creature_avatar'] . '"></td>
	<td class="row1" width="25%"><span class="gen">' . $pet_health_text . '<br />
		' . ($rabbit_user['creature_health'] > 0 ? '<img src="rabbitoshi/images/stats/bar_left.gif" border="0" width="6" height="13" /><img src="rabbitoshi/images/stats/bar_fil.gif" border="0" width="' . $creature_health_width . '" height="13" /><img src="rabbitoshi/images/stats/bar_right.gif" border="0" width="6" height="13" /><br /><br />
		' . $lang['Rabbitoshi_battle_pet_mp'] . ' : ' . $rabbit_user['creature_mp'] . '/' . $rabbit_user['creature_max_mp'] . '<br />
   		<img src="rabbitoshi/images/stats/bar_left2.gif" width="6" height="13" /><img src="rabbitoshi/images/stats/bar_fil2.gif" width="' . $creature_mp_width . '" height="13" /><img src="rabbitoshi/images/stats/bar_right2.gif" width="6" height="13" /><br /></span>' : '') . '</td>
	<td class="row1" width="25%"><span class="gen">
		' . $lang['Rabbitoshi_battle_pet_attack'] . ' : ' . $rabbit_user['creature_attack'] . '/' . $rabbit_user['creature_attack_max'] . '<br />
    	<img src="rabbitoshi/images/stats/bar_left1.gif" width="6" height="13" /><img src="rabbitoshi/images/stats/bar_fil1.gif" width="' . $creature_attack_width . '" height="13" /><img src="rabbitoshi/images/stats/bar_right1.gif" width="6" height="13" /><br /><br />' . '

    	'  . $lang['Rabbitoshi_battle_pet_magicattack'] . ' : ' . $rabbit_user['creature_magicattack'] . '/' . $rabbit_user['creature_magicattack_max'] . '<br />
    	<img src="rabbitoshi/images/stats/bar_left4.gif" width="6" height="13" /><img src="rabbitoshi/images/stats/bar_fil4.gif" width="' . $creature_magicattack_width . '" height="13" /><img src="rabbitoshi/images/stats/bar_right4.gif" width="6" height="13" /><br /></span>' . '
    </td>
' . ($pet_can_attack ? '
	<td class="row1" width="25%">
		' . ($rabbit_user['creature_health'] > 0 && $rabbit_user['creature_attack'] ? '<input type="submit" style="width: 135" value="' . $lang['Rabbitoshi_battle_pet_action_attack'] . '" onClick="return checksubmit(this)" name="pet_attack" class="mainoption" /><br /><br />' : '') . '
		' . ($rabbit_user['creature_health'] > 0 && $magicattack ? '<input type="submit" style="width: 135" value="' . $lang['Rabbitoshi_battle_pet_action_magicattack'] . '" onClick="return checksubmit(this)" name="pet_magicattack" class="mainoption" /><br /><br />' : '') . '
		' . ($rabbit_user['creature_health'] > 0 && $ability ? '<input type="submit" style="width: 135" value="' . $ability . '" onClick="return checksubmit(this)" name="pet_specialattack" class="mainoption" />' : '') . '</td>' : '') . '
</tr>
</table>';
} //$show_pet_table == '1'

if (($pet_invoc == '1') && ($rabbit_user['creature_health'] > 0))
{
	if ($show_pet_table == '0')
	{
		$invoc_table = '<tr>
					  <td align="center" class="row1" width="100%" colspan="2"><input type="submit" style="width: 225" value="' . $lang['Rabbitoshi_battle_pet_action_invoc'] . '' . $rabbit_user['owner_creature_name'] . '" onClick="return checksubmit(this)" name="invoc" class="mainoption" /></td>
				  </tr>';
	} //$show_pet_table == '0'
} //($pet_invoc == '1') && ($rabbit_user['creature_health'] > 0)

// Grab user details for graphical battles...
$sql = "SELECT * 
		FROM " . ADR_RACES_TABLE . " r , " . ADR_ELEMENTS_TABLE . " e , " . ADR_ALIGNMENTS_TABLE . " a , " . ADR_CLASSES_TABLE . " c
		WHERE r.race_id = '" . $challenger['character_race'] . "' 
		AND e.element_id = '" . $challenger['character_element'] . "' 
		AND a.alignment_id = '" . $challenger['character_alignment'] . "'
		AND c.class_id = '" . $challenger['character_class'] . "' ";
if (!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, 'Error grabbing character details!');
} //!$result = $db->sql_query($sql)
$class = $db->sql_fetchrow($result);

// Armour set?
$armour_set = !$bat['battle_challenger_armour_set'] ? $lang['Adr_store_element_none'] : $bat['battle_challenger_armour_set'];

// Only required until a monster alignment mod is released
$monster_alignment_id = 2;
//!$monster['monster_base_alignment'] ? 2 : $monster['monster_base_alignment'];

// Grab monster details for graphical battles...
$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE . " e , " . ADR_ALIGNMENTS_TABLE . " a
		WHERE a.alignment_id = $monster_alignment_id 
		AND e.element_id = '" . $monster['monster_base_element'] . "' ";
if (!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, 'Error grabbing monster details!');
} //!$result = $db->sql_query($sql)
$monster_details = $db->sql_fetchrow($result);

// Grab background details
if (empty($bck_grnd_name))
{
	$bck_grnd_name = $bat['battle_bkg'];
} //empty($bck_grnd_name)

// Required to prevent battles with no background image
if (!$bck_grnd_name && !$bat['battle_bkg'])
{
	$bck_grnd_name = "battle_bgnd_1.gif";
} //!$bck_grnd_name && !$bat['battle_bkg']

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
	'ATTACK_OVERLAY' => $attackwith_overlay,
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
	'L_HP' => $lang['Adr_character_health'],
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
	'MONSTER_LEVEL'=> $monster['monster_level'],
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
	'TAUNT_LIST' => '', // $level_list,
	'L_COMMS' => '', //$lang['Adr_pvp_comms'],
	'L_TYPE_HERE' => $lang['Adr_pvp_custom_taunt'],
	'L_CUSTOM_SENTANCE' => $lang['Adr_pvp_taunt'],
	'S_CHATBOX' => append_sid("adr_battle_chatbox.$phpEx?battle_id=" . $bat['battle_id'])
));

// V: include header only if the battle hasn't started yet
if (!$battle_started)
{
  include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
}

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.' . $phpEx);
