<?php
/***************************************************************************
 *                                 adr_functions_armour_sets.php
 *                            -------------------
 *	Begun                : 22/10/2004
 *	Copyright            : Seteo-Bloke
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

if(!defined('IN_PHPBB')){
	die("Hacking attempt");}

function adr_armour_set_check($user_id, $armour='', $shield='', $gloves='', $helm='', $amulet='', $ring='', $greave ='', $boot = '')
{
	global $db;

	$user_id = intval($user_id);

	if($user_id != '0'){
		// Check if current armour is equal to a set in table
		$sql = "SELECT a.*, b.* FROM " . ADR_ARMOUR_SET_TABLE . " a, " . ADR_BATTLE_LIST_TABLE . " b
				WHERE a.set_helm = '" . str_replace("\'", "''", $helm) . "'
				AND a.set_armour = '" . str_replace("\'", "''", $armour) . "'
				AND a.set_gloves = '" . str_replace("\'", "''", $gloves) . "'
				AND a.set_shield = '" . str_replace("\'", "''", $shield) . "'
				AND a.set_greave = '" . str_replace("\'", "''", $greave) . "'
				AND a.set_boot = '" . str_replace("\'", "''", $boot) . "'
				AND b.battle_challenger_id = '$user_id'
				AND b.battle_result = '0'
				AND b.battle_type = '1'";
		if( !($result = $db->sql_query($sql)) ){
			message_die(GENERAL_ERROR, 'Could not query armour set table', '', __LINE__, __FILE__, $sql);}
		$bat = $db->sql_fetchrow($result);

		if(($bat['set_id'] != '0') && ($bat['set_id'] != '')){
			// Calculate bonuses & penalties for armour set
			$att = $bat['battle_challenger_att'] + ($bat['set_might_bonus'] + $bat['set_constitution_bonus']);
			$att = $att - ($bat['set_might_penalty'] + $bat['set_constitution_penalty']);
			$att = $att < 1 ? 0 : $att;

			$def = $bat['battle_challenger_def'] + ($bat['set_dexterity_bonus'] + $bat['set_ac_bonus']);
			$def = $def - ($bat['set_dexterity_penalty'] + $bat['set_ac_penalty']);
			$def = $def < 1 ? 0 : $def;

			$m_att = $bat['battle_challenger_magic_attack'] + $bat['set_intelligence_bonus'];
			$m_att = $m_att - $bat['set_intelligence_penalty'];
			$m_att = $m_att < 1 ? 0 : $m_att;

			$m_def = $bat['battle_challenger_magic_resistance'] + $bat['set_wisdom_bonus'];
			$m_def = $m_def - $bat['set_wisdom_penalty'];
			$m_def = $m_def < 1 ? 0 : $m_def;

			$armour_set = adr_get_lang($bat['set_name']);

			// Update user stats to db
			$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
					SET battle_challenger_att = $att,
						battle_challenger_def = $def,
						battle_challenger_magic_attack = $m_att,
						battle_challenger_magic_resistance = $m_def,
						battle_challenger_armour_set = '" . str_replace("\'", "''", $armour_set) . "'
					WHERE battle_challenger_id = '$user_id'
					AND battle_result = '0'
					AND battle_type = '1'";
			if( !($result = $db->sql_query($sql)) ){
				message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);}

			return;
		}
	}
}

function adr_pvp_armour_set_check($battle_id, $challenger_id, $opponent_id, $armour='', $shield='', $gloves='', $helm='', $amulet='', $ring='', $greave ='', $boot = '')
{
	global $db;

	$battle_id = intval($battle_id);
	$challenger_id = intval($challenger_id);
	$opponent_id = intval($opponent_id);

	// Check if current armour is equal to a set in table
	$sql = " SELECT a.*, b.* FROM " . ADR_ARMOUR_SET_TABLE . " a, " . ADR_BATTLE_PVP_TABLE . " b
			WHERE a.set_helm = '" . str_replace("\'", "''", $helm) . "'
			AND a.set_armour = '" . str_replace("\'", "''", $armour) . "'
			AND a.set_gloves = '" . str_replace("\'", "''", $gloves) . "'
			AND a.set_shield = '" . str_replace("\'", "''", $shield) . "'
			AND a.set_greave = '" . str_replace("\'", "''", $greave) . "'
			AND a.set_boot = '" . str_replace("\'", "''", $boot) . "'
			AND b.battle_id = '$battle_id'";
	if( !($result = $db->sql_query($sql)) ){
		message_die(GENERAL_ERROR, 'Could not query armour set table for PvP', '', __LINE__, __FILE__, $sql);}
	$bat = $db->sql_fetchrow($result);

	if(($bat['set_id'] != '0') && ($bat['set_id'] != '')){
		if($challenger_id == $bat['battle_challenger_id'])
		{
			// Calculate bonuses & penalties for armour set
			$att = $bat['battle_challenger_att'] + ($bat['set_might_bonus'] + $bat['set_constitution_bonus']);
			$att = $att - ($bat['set_might_penalty'] + $bat['set_constitution_penalty']);
			$att = $att < 1 ? 1 : $att;
	
			$def = $bat['battle_challenger_def'] + ($bat['set_dexterity_bonus'] + $bat['set_ac_bonus']);
			$def = $def - ($bat['set_dexterity_penalty'] + $bat['set_ac_penalty']);
			$def = $def < 1 ? 1 : $def;
	
			$m_att = $bat['battle_challenger_magic_attack'] + $bat['set_intelligence_bonus'];
			$m_att = $m_att - $bat['set_intelligence_penalty'];
			$m_att = $m_att < 1 ? 1 : $m_att;
	
			$m_def = $bat['battle_challenger_magic_resistance'] + $bat['set_wisdom_bonus'];
			$m_def = $m_def - $bat['set_wisdom_penalty'];
			$m_def = $m_def < 1 ? 1 : $m_def;
	
			$armour_set = adr_get_lang($bat['set_name']);
	
			// Now update the database
			$sql = " UPDATE " . ADR_BATTLE_PVP_TABLE . "
				SET battle_challenger_att = $att, 
					battle_challenger_def = $def,
					battle_challenger_magic_attack = $m_att,
					battle_challenger_magic_resistance = $m_def,
					battle_challenger_armour_set = '" . str_replace("\'", "''", $armour_set) . "'
				WHERE battle_id = '$battle_id'
				AND battle_challenger_id = '$challenger_id'";
			$result = $db->sql_query($sql);
			if( !$result ){
				message_die(GENERAL_ERROR, "Couldn't update challenger armour set stats", "", __LINE__, __FILE__, $sql);}

			return;
		}
		elseif($opponent_id == $bat['battle_opponent_id'])
		{
			// Calculate bonuses & penalties for armour set
			$att = $bat['battle_opponent_att'] + ($bat['set_might_bonus'] + $bat['set_constitution_bonus']);
			$att = $att - ($bat['set_might_penalty'] + $bat['set_constitution_penalty']);
			$att = ($att < 1) ? 1 : $att;
	
			$def = $bat['battle_opponent_def'] + ($bat['set_dexterity_bonus'] + $bat['set_ac_bonus']);
			$def = $def - ($bat['set_dexterity_penalty'] + $bat['set_ac_penalty']);
			$def = ($def < 1) ? 1 : $def;
	
			$m_att = $bat['battle_opponent_magic_attack'] + $bat['set_intelligence_bonus'];
			$m_att = $m_att - $bat['set_intelligence_penalty'];
			$m_att = ($m_att < 1) ? 1 : $m_att;
	
			$m_def = $bat['battle_opponent_magic_resistance'] + $bat['set_wisdom_bonus'];
			$m_def = $m_def - $bat['set_wisdom_penalty'];
			$m_def = ($m_def < 1) ? 1 : $m_def;
	
			$armour_set = adr_get_lang($bat['set_name']);
	
			// Now update the database
			$sql = " UPDATE " . ADR_BATTLE_PVP_TABLE . "
				SET battle_opponent_att = $att, 
					battle_opponent_def = $def,
					battle_opponent_magic_attack = $m_att,
					battle_opponent_magic_resistance = $m_def, 
					battle_opponent_armour_set = '" . str_replace("\'", "''", $armour_set) . "'
				WHERE battle_id = '$battle_id'
				AND battle_opponent_id = '$opponent_id'";
			$result = $db->sql_query($sql);
			if( !$result ){
				message_die(GENERAL_ERROR, "Couldn't update opponent armour set stats", "", __LINE__, __FILE__, $sql);}

			return;
		}	
	}
}

?>
