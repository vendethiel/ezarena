<?php
/***************************************************************************
 *                                 adr_functions_battle.php
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

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}


function adr_make_restrict_sql($user)
{
	global $db;

	$restrict_sql = " AND (item_restrict_class LIKE '%".$user['character_class'].","."%' OR item_restrict_class_enable = '0')
		AND (item_restrict_race LIKE '%".$user['character_race'].","."%' OR item_restrict_race_enable = '0')
		AND (item_restrict_align LIKE '%".$user['character_alignment'].","."%' OR item_restrict_align_enable = '0')
		AND item_restrict_level <= '".$user['character_level']."'
		AND item_restrict_str <= '".$user['character_might']."'
		AND item_restrict_dex <= '".$user['character_dexterity']."'
		AND item_restrict_con <= '".$user['character_constitution']."'
		AND item_restrict_int <= '".$user['character_intelligence']."'
		AND item_restrict_wis <= '".$user['character_wisdom']."'
		AND item_restrict_cha <= '".$user['character_charisma']."'";

	return $restrict_sql;
} 

function adr_battle_make_att($str, $con)
{
   global $db;

   $str = intval($str);
   $con = intval($con);

   // Make calculation
   $att = ceil(($str + ($str *0.5)) + adr_modifier_calc($con));

	return $att;
}

function adr_battle_make_magic_att($int)
{
	global $db;

	$int = intval($int);

	// Make calculation
	$m_att = ceil($int + ($int *0.75));

	return $m_att;
}

function adr_battle_make_def($ac, $dex)
{
	global $db;

	$ac = intval($ac);
	$dex = intval($dex);

	// Make calculation
	$def = ceil(($ac + ($ac *0.5)) + adr_modifier_calc($dex));

	return $def;
}

function adr_battle_make_magic_def($wis)
{
	global $db;

	$wis = intval($wis);

	// Make calculation
	$m_def = ceil($wis + ($wis *0.75));

	return $m_def;
}

function adr_battle_make_crit_roll($att, $level, $opp_def, $item_type_use=0, $power, $quality=0, $threat_range=20, $party_bonus=0)
{
	global $db, $dice, $item;

	$att = intval($att);
	$level = intval($level);
	$opp_def = intval($opp_def);
	$item_type_use = intval($item_type_use);
	$power = intval($power);
	$quality = intval($quality);
	$threat_range = intval($threat_range);
	$party_bonus = intval($party_bonus);
    $item['item_crit_hit_mod'] = intval(2); //temp

	$crit_result = FALSE;
	if($dice >= $threat_range){
		// Since the result from die roll was a threat & a 100% hit, we now make a crit roll...
		// this must be a hit for a crit strike otherwise we use dmg from first roll
		$crit_die = rand(1,20);
		$crit_result = (((($att + $quality + $crit_die + $level + $party_bonus) > ($opp_def + $level)) && ($crit_die != '1')) || ($crit_die >= $threat_range)) ? TRUE : FALSE;
		$power = ($crit_result == TRUE) ? ($power *$item['item_crit_hit_mod']) : $power;
	}
	return $crit_result.'-'.intval($power);
}

function adr_battle_quota_check($user_id)
{
	global $db , $lang, $adr_general;

	$user_id = intval($user_id);

	$sql = " SELECT character_battle_limit FROM  " . ADR_CHARACTERS_TABLE . " 
		WHERE character_id = $user_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	}
	$char = $db->sql_fetchrow($result);
	
	if ( $adr_general['Adr_character_limit_enable'] == 1 && $char['character_battle_limit'] < 1 ) 
	{	
		adr_previous ( Adr_battle_limit , adr_character , '' );
	}

	// Update battle limit for user
	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_battle_limit = character_battle_limit - 1  
			WHERE character_id = $user_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle limit', '', __LINE__, __FILE__, $sql);
	}
}

function adr_weight_check($user_id)
{
	global $db, $lang, $adr_general;

	$user_id = intval($user_id);

	$sql = "SELECT c.*, r.race_weight, r.race_weight_per_level
		FROM  " . ADR_CHARACTERS_TABLE . " c, " . ADR_RACES_TABLE . " r
		WHERE c.character_id= '$user_id'
		AND r.race_id = c.character_race";
	if(!($result = $db->sql_query($sql)))
		message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
	$row = $db->sql_fetchrow($result);
	
	// START weight reqs
	$max_weight = adr_weight_stats($row['character_level'], $row['race_weight'], $row['race_weight_per_level'], $row['character_might']);

	// Count up characters current weight
	$sql = "SELECT SUM(item_weight) AS total FROM  " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = '$user_id'
		AND item_in_warehouse = '0'
		AND item_in_shop = '0'";
	if(!($result = $db->sql_query($sql)))
		message_die(CRITICAL_ERROR, 'Error Getting Adr Users!');
	$weight = $db->sql_fetchrow($result);
	$current_weight = $weight[total];

	if(($adr_general['weight_enable']) && ($current_weight > $max_weight))
		adr_previous(Adr_battle_over_weight, adr_character_inventory, '');
	// END Weight reqs
}

function adr_levelup_check($user_id)
{
	global $db , $lang , $adr_general;

	$user_id = intval($user_id);
	
	$sql = "SELECT c.* , r.race_weight , r.race_weight_per_level , cl.class_update_xp_req
		FROM  " . ADR_CHARACTERS_TABLE . " c , " . ADR_RACES_TABLE . " r , ". ADR_CLASSES_TABLE ." cl
		WHERE c.character_id= $user_id
		AND r.race_id = c.character_race 
		AND cl.class_id = c.character_class ";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
	}	
	$row = $db->sql_fetchrow($result);

	$max_xp = $row['class_update_xp_req'];
	for ( $p = 1 ; $p < $row['character_level'] ; $p ++ )
	{
		$max_xp = floor($max_xp * ( ( $adr_general['next_level_penalty'] + 100 ) / 100 ));
	}

	if ( $row['character_xp'] > $max_xp )
	{
		adr_previous ( Adr_battle_force_lvl_up , adr_character , '' );
	}
}

function adr_hp_regen_check($user_id, $battle_challenger_hp)
{
	global $db, $lang, $adr_general, $challenger;

	$user_id = intval($user_id);
	$battle_challenger_hp = intval($battle_challenger_hp);
	$hp_regen = 0;

	if($battle_challenger_hp > '0'){
		// Regeneration of the hp if the user has an amulet
		if($challenger['character_hp'] < $challenger['character_hp_max']){
			$hp_regen = (($battle_challenger_hp + $challenger['character_hp']) > $challenger['character_hp_max']) ? ($challenger['character_hp_max'] - $challenger['character_hp']) : $battle_challenger_hp;

			// Regeneration of the hp if the user has an amulet
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_hp = (character_hp + $hp_regen)
				WHERE character_id = '$user_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}

			return $hp_regen;
		}
	}
	return $hp_regen;
}

function adr_mp_regen_check($user_id, $battle_challenger_mp)
{
	global $db, $lang, $adr_general, $challenger;

	$user_id = intval($user_id);
	$battle_challenger_mp = intval($battle_challenger_mp);
	$mp_regen = 0;

	if($battle_challenger_mp > '0'){
		// Regeneration of the mp if the user has a ring
		if($challenger['character_mp'] < $challenger['character_mp_max']){
			$mp_regen = (($battle_challenger_mp + $challenger['character_mp']) > $challenger['character_mp_max']) ? ($challenger['character_mp_max'] - $challenger['character_mp']) : $battle_challenger_mp;

			// Regeneration of the mp if the user has an amulet
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_mp = (character_mp + $mp_regen)
				WHERE character_id = '$user_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}

			return $mp_regen;
		}
	}
	return $mp_regen;
}

function adr_armour_set_check($user_id, $armour_id, $shield_id, $gloves_id, $helm_id, $greave_id, $boot_id)
{
	global $db;

	$user_id = intval($user_id);
	$helm_id = addslashes($helm_id);
	$greave_id = addslashes($greave_id);
	$boot_id = addslashes($boot_id);
	$armour_id = addslashes($armour_id);
	$gloves_id = addslashes($gloves_id);
	$shield_id = addslashes($shield_id);

	if ( $user_id != 0 )
	{
		// Check if current armour is equal to a set in table
		$sql = " SELECT a.*, b.* FROM " . ADR_ARMOUR_SET_TABLE . " a , " . ADR_BATTLE_LIST_TABLE . " b
				WHERE a.set_helm = '$helm_id'
				AND a.set_greave = '$greave_id'
				AND a.set_boot = '$boot_id'
				AND a.set_armour = '$armour_id'
				AND a.set_gloves = '$gloves_id'
				AND a.set_shield = '$shield_id'
				AND b.battle_challenger_id = $user_id
				AND b.battle_result = 0
				AND b.battle_type = 1 ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query armour set table', '', __LINE__, __FILE__, $sql);
		}
		$bat = $db->sql_fetchrow($result);

		if ( $bat['set_id'] != 0 )
		{
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

			$armour_set = $bat['set_name'];

			// Update user stats to db
			$sql = " UPDATE " . ADR_BATTLE_LIST_TABLE . "
					SET 	battle_challenger_att = $att,
						battle_challenger_def = $def,
						battle_challenger_magic_attack = $m_att,
						battle_challenger_magic_resistance = $m_def,
						battle_challenger_armour_set = '$armour_set'
					WHERE battle_challenger_id = $user_id
					AND battle_result = 0
					AND battle_type = 1 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);
			}
		}
	}
}


function adr_pvp_armour_set_check($battle_id, $challenger_id, $opponent_id , $armour_id, $shield_id, $gloves_id, $helm_id, $greave_id, $boot_id)
{
	global $db;

	$battle_id = intval($battle_id);
	$challenger_id = intval($challenger_id);
	$opponent_id = intval($opponent_id);

	// Check if current armour is equal to a set in table
	$sql = " SELECT a.*, b.* FROM " . ADR_ARMOUR_SET_TABLE . " a , " . ADR_BATTLE_PVP_TABLE . " b
			WHERE a.set_helm = '$helm_id'
			AND a.set_greave = '$greave_id'
			AND a.set_boot = '$boot_id'
			AND a.set_armour = '$armour_id'
			AND a.set_gloves = '$gloves_id'
			AND a.set_shield = '$shield_id'
			AND b.battle_id = $battle_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query armour set table for PvP', '', __LINE__, __FILE__, $sql);
	}
	$bat = $db->sql_fetchrow($result);

	if ( $bat['set_id'] != 0 )
	{
	if ( $challenger_id == $bat['battle_challenger_id'] )
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

		$armour_set = $bat['set_name'];

		// Now update the database
		$sql = " UPDATE " . ADR_BATTLE_PVP_TABLE . "
			SET battle_challenger_att = $att, 
				battle_challenger_def = $def,
				battle_challenger_magic_attack = $m_att,
				battle_challenger_magic_resistance = $m_def,
				battle_challenger_armour_set = '$armour_set'
			WHERE battle_id = $battle_id
			AND battle_challenger_id = $challenger_id ";
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, "Couldn't update challenger armour set stats", "", __LINE__, __FILE__, $sql);
		}
	}

	elseif ( $opponent_id == $bat['battle_opponent_id'] )
	{
		// Calculate bonuses & penalties for armour set
		$att = $bat['battle_opponent_att'] + ($bat['set_might_bonus'] + $bat['set_constitution_bonus']);
		$att = $att - ($bat['set_might_penalty'] + $bat['set_constitution_penalty']);
		$att = $att < 1 ? 1 : $att;

		$def = $bat['battle_opponent_def'] + ($bat['set_dexterity_bonus'] + $bat['set_ac_bonus']);
		$def = $def - ($bat['set_dexterity_penalty'] + $bat['set_ac_penalty']);
		$def = $def < 1 ? 1 : $def;

		$m_att = $bat['battle_opponent_magic_attack'] + $bat['set_intelligence_bonus'];
		$m_att = $m_att - $bat['set_intelligence_penalty'];
		$m_att = $m_att < 1 ? 1 : $m_att;

		$m_def = $bat['battle_opponent_magic_resistance'] + $bat['set_wisdom_bonus'];
		$m_def = $m_def - $bat['set_wisdom_penalty'];
		$m_def = $m_def < 1 ? 1 : $m_def;

		$armour_set = $bat['set_name'];

		// Now update the database
		$sql = " UPDATE " . ADR_BATTLE_PVP_TABLE . "
			SET battle_opponent_att = $att, 
				battle_opponent_def = $def,
				battle_opponent_magic_attack = $m_att,
				battle_opponent_magic_resistance = $m_def, 
				battle_challenger_armour_set = '$armour_set',
				battle_result = 3
			WHERE battle_id = $battle_id
			AND battle_opponent_id = $opponent_id  ";
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, "Couldn't update opponent armour set stats", "", __LINE__, __FILE__, $sql);
		}
	}	
	}
}

function adr_temple_donation($user_id, $chance, $donated)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$chance = intval($chance);
	$donated = intval($donated);

	// Select correct item type
	// 0 = common, 1 = uncommon, 2 = rare, 3 = very rare, 4 = exceptionally rare
	$sql = "SELECT * FROM  " . ADR_TEMPLE_DONATIONS . "
			WHERE item_chance = '$chance'
			ORDER BY rand() LIMIT 1";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query item table', '', __LINE__, __FILE__, $sql);
	}
	$newitem = $db->sql_fetchrow($result);
	if (!$newitem)
	{
		message_die(GENERAL_MESSAGE, $lang['Adr_temple_no_donation']);
	}

	$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ."
		WHERE item_owner_id = '$user_id'
		ORDER BY item_id
		DESC LIMIT 1";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$data = $db->sql_fetchrow($result);
	$new_item_id = $data['item_id'] + 1;
	$item_type = $newitem['item_type_use'];
	$item_name = $newitem['item_name'];
	$item_desc = $newitem['item_desc'];
	$item_icon = $newitem['item_icon'];
	$item_quality = $newitem['item_quality'];
	$item_duration = $newitem['item_duration'];
	$item_duration_max = $newitem['item_duration_max'];
	$item_add_power = $newitem['item_add_power'];
	$item_power = $newitem['item_power'];
	$item_price = $newitem['item_price'];
	$item_mp_use = $newitem['item_mp_use'];
	$item_element = $newitem['item_element'];
	$item_element_str_dmg = $newitem['item_element'];
	$item_element_same_dmg = $newitem['item_element'];
	$item_element_weak_dmg = $newitem['item_element'];
	$item_max_skill = $newitem['item_max_skill'];
	$item_weight = $newitem['item_weight'];

	// Insert into database
	$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . "
		( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration ,  item_duration_max , item_power , item_add_power  , item_mp_use , item_element , item_element_str_dmg , item_element_same_dmg ,  item_element_weak_dmg , item_max_skill  , item_weight)
		VALUES ( $new_item_id , $user_id , $item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''",  $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_duration_max ,  $item_power , $item_add_power , $item_mp_use , $item_element , $item_element_str_dmg , $item_element_same_dmg , $item_element_weak_dmg ,  $item_max_skill , $item_weight)";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
	}
	
	adr_temple_tracker($user_id, $item_name, $donated);

	return $new_item_id;
}

function adr_beggar_donation($user_id, $chance, $donated)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$chance = intval($chance);
	$donated = intval($donated);

	// Select correct item type
	// 0 = common, 1 = uncommon, 2 = rare, 3 = very rare, 4 = exceptionally rare
	$sql = "SELECT * FROM  " . ADR_BEGGAR_DONATIONS . "
			WHERE item_chance = '$chance'
			ORDER BY rand() LIMIT 1";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query item table', '', __LINE__, __FILE__, $sql);
	}
	$newitem = $db->sql_fetchrow($result);

	$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ."
		WHERE item_owner_id = '$user_id'
		ORDER BY item_id
		DESC LIMIT 1";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$data = $db->sql_fetchrow($result);
	$new_item_id = $data['item_id'] + 1;
	$item_type = $newitem['item_type_use'];
	$item_name = $newitem['item_name'];
	$item_desc = $newitem['item_desc'];
	$item_icon = $newitem['item_icon'];
	$item_quality = $newitem['item_quality'];
	$item_duration = $newitem['item_duration'];
	$item_duration_max = $newitem['item_duration_max'];
	$item_add_power = $newitem['item_add_power'];
	$item_power = $newitem['item_power'];
	$item_price = $newitem['item_price'];
	$item_mp_use = $newitem['item_mp_use'];
	$item_element = $newitem['item_element'];
	$item_element_str_dmg = $newitem['item_element'];
	$item_element_same_dmg = $newitem['item_element'];
	$item_element_weak_dmg = $newitem['item_element'];
	$item_max_skill = $newitem['item_max_skill'];
	$item_weight = $newitem['item_weight'];

	// Insert into database
	$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . "
		( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration ,  item_duration_max , item_power , item_add_power  , item_mp_use , item_element , item_element_str_dmg , item_element_same_dmg ,  item_element_weak_dmg , item_max_skill  , item_weight)
		VALUES ( $new_item_id , $user_id , $item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''",  $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_duration_max ,  $item_power , $item_add_power , $item_mp_use , $item_element , $item_element_str_dmg , $item_element_same_dmg , $item_element_weak_dmg ,  $item_max_skill , $item_weight)";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
	}

	adr_beggar_tracker($user_id, $item_name, $donated);

	return $new_item_id;
}

function adr_lake_donation($user_id, $chance, $donated)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$chance = intval($chance);
	$donated = intval($donated);

	// Select correct item type
	// 0 = common, 1 = uncommon, 2 = rare, 3 = very rare, 4 = exceptionally rare
	$sql = "SELECT * FROM  " . ADR_LAKE_DONATIONS . "
			WHERE item_chance = '$chance'
			ORDER BY rand() LIMIT 1";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query item table', '', __LINE__, __FILE__, $sql);
	}
	$newitem = $db->sql_fetchrow($result);

	$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ."
		WHERE item_owner_id = '$user_id'
		ORDER BY item_id
		DESC LIMIT 1";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$data = $db->sql_fetchrow($result);
	$new_item_id = $data['item_id'] + 1;
	$item_type = $newitem['item_type_use'];
	$item_name = $newitem['item_name'];
	$item_desc = $newitem['item_desc'];
	$item_icon = $newitem['item_icon'];
	$item_quality = $newitem['item_quality'];
	$item_duration = $newitem['item_duration'];
	$item_duration_max = $newitem['item_duration_max'];
	$item_add_power = $newitem['item_add_power'];
	$item_power = $newitem['item_power'];
	$item_price = $newitem['item_price'];
	$item_mp_use = $newitem['item_mp_use'];
	$item_element = $newitem['item_element'];
	$item_element_str_dmg = $newitem['item_element'];
	$item_element_same_dmg = $newitem['item_element'];
	$item_element_weak_dmg = $newitem['item_element'];
	$item_max_skill = $newitem['item_max_skill'];
	$item_weight = $newitem['item_weight'];

	// Insert into database
	$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . "
		( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration ,  item_duration_max , item_power , item_add_power  , item_mp_use , item_element , item_element_str_dmg , item_element_same_dmg ,  item_element_weak_dmg , item_max_skill  , item_weight)
		VALUES ( $new_item_id , $user_id , $item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''",  $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_duration_max ,  $item_power , $item_add_power , $item_mp_use , $item_element , $item_element_str_dmg , $item_element_same_dmg , $item_element_weak_dmg ,  $item_max_skill , $item_weight)";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
	}

	adr_lake_tracker($user_id, $item_name, $donated);

	return $new_item_id;
}

function adr_temple_infos($user_id, $item_id)
{
	global $db;

	$user_id = intval($user_id);
	$item_id = intval($item_id);

	$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = '$user_id'
		AND item_id = '$item_id'";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR , 'Can not query the items table');
	}
	$row = $db->sql_fetchrow($result);

	return $row;
}

function adr_temple_tracker($user_id, $item_name, $donated)
{
	global $db;

	$user_id = intval($user_id);
	$donated = intval($donated);

	$sql = "SELECT character_name FROM  " . ADR_CHARACTERS_TABLE . "
		WHERE character_id = '$user_id'";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR , 'Can not query the items table');
	}
	$row = $db->sql_fetchrow($result);
	$name = $row['character_name'];

	// Insert into database
	$sql = "INSERT INTO " . ADR_TEMPLE_TRACKER . "
		(item_name, owner_name, donated , date)
		VALUES ( '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $name) . "', $donated, ".time().")";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
	}
}

function adr_beggar_tracker($user_id, $item_name, $donated)
{
	global $db;

	$user_id = intval($user_id);
	$donated = intval($donated);

	$sql = "SELECT character_name FROM  " . ADR_CHARACTERS_TABLE . "
		WHERE character_id = '$user_id'";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR , 'Can not query the items table');
	}
	$row = $db->sql_fetchrow($result);
	$name = $row['character_name'];

	// Insert into database
	$sql = "INSERT INTO " . ADR_BEGGAR_TRACKER . "
		(item_name, owner_name, donated , date)
		VALUES ( '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $name) . "', $donated, ".time().")";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
	}
}

function adr_lake_tracker($user_id, $item_name, $donated)
{
	global $db;

	$user_id = intval($user_id);
	$donated = intval($donated);

	$sql = "SELECT character_name FROM  " . ADR_CHARACTERS_TABLE . "
		WHERE character_id = '$user_id'";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR , 'Can not query the items table');
	}
	$row = $db->sql_fetchrow($result);
	$name = $row['character_name'];

	// Insert into database
	$sql = "INSERT INTO " . ADR_LAKE_TRACKER . "
		(item_name, owner_name, donated , date)
		VALUES ( '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $name) . "', $donated, ".time().")";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
	}
}

function drop_loot($monster_id,$user_id,$dropped_loot_list) 
{
	global $db , $lang, $adr_general;
	$user_id = intval($user_id);
	$monster_id = intval($monster_id);

	$sql = "SELECT * FROM " . ADR_BATTLE_MONSTERS_TABLE ."
		WHERE monster_id = $monster_id
		";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain monsters information', "", __LINE__, __FILE__, $sql);
	}
	$monster = $db->sql_fetchrow($result);

	$possible_items = $monster['monster_possible_drop'];
	$guranteened_items = $monster['monster_guranteened_drop'];
	$specific_items = explode(':',$monster['monster_specific_drop']);
	$monster_loottables = explode(':',$monster['monster_loottables']);

	$message .= "<br><br><table align=\"center\" border=\"0\" cellpadding=\"0\" class=\"gen\"><tr>";
	
	if ($possible_items != 0)
	{
		for ( $i = 0 ; $i < $possible_items ; $i++)
		{
			$rolled_loottable = "";
			$timer = 0;
			do
			{
				$timer++;
				//roll the loottable
				$rnd_loottable = rand ( 0 , ( count($monster_loottables) - 1 ));
				//sort out deactivated loottables
				$sql = "SELECT * FROM " . ADR_LOOTTABLES_TABLE."
						WHERE loottable_status = 1
						AND loottable_id = '".$monster_loottables[$rnd_loottable]."'
						";
				$result = $db->sql_query($sql); 
				if( !$result ) 
				{ 
					message_die(GENERAL_ERROR, 'Could not obtain loottable information', "", __LINE__, __FILE__, $sql); 
				} 
				//incase all monsters loottables are deactivated for some reason
				if ($timer > 10000){break;}
			}
			while(!$rolled_loottable = $db->sql_fetchrow($result)) ;
			
			//incase all monsters loottables are deactivated for some reason
			if ($timer > 10000){break;}
			
			//now roll to see if we actually get an item
			$dicer = rand ( 1, 10000);
			
			if ($dicer >= $rolled_loottable['loottable_dropchance'])
			{
				$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE."
				WHERE item_owner_id = 1
					AND (item_loottables like '".$rolled_loottable['loottable_id'].":"."%'
					OR item_loottables like '".$rolled_loottable['loottable_id']."'
					OR item_loottables like '%".":".$rolled_loottable['loottable_id'].":"."%'
					OR item_loottables like '%".":".$rolled_loottable['loottable_id']."')
				";
				if( !($result = $db->sql_query($sql)) ) 
				{
					message_die(GENERAL_ERROR, 'Could not query items list', '', __LINE__, __FILE__, $sql); 
				}
				$possible_items_db = $db->sql_fetchrowset($result); 
				
				//now roll for the item
				$rnd_item = rand ( 0 , ( count($possible_items_db) - 1 ));
				
				//get the rolled item info
				$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE."
				WHERE item_owner_id = 1
					AND item_id = '".$possible_items_db[$rnd_item]['item_id']."'
				";
				if( !($result = $db->sql_query($sql)) ) 
				{
					message_die(GENERAL_ERROR, 'Could not query items list', '', __LINE__, __FILE__, $sql); 
				}
				$rolled_item = $db->sql_fetchrow($result);
				
				//new id for the item
				$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ."
				   WHERE item_owner_id = $user_id
				   ORDER BY item_id
				   DESC LIMIT 1";
				$result = $db->sql_query($sql);
				if( !$result )
				{
					message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
				}
				$item_data = $db->sql_fetchrow($result); 
				
				$item_id_new = $item_data['item_id'] + 1 ; 
				$item_type = $rolled_item['item_type_use'] ; 
				$item_picture = $rolled_item['item_icon'] ; 
				$item_name = $rolled_item['item_name']; 
				$item_desc = $rolled_item['item_desc']; 
				$item_icon = $rolled_item['item_icon'] ; 
				$item_quality = $rolled_item['item_quality']; 
				$item_duration = $rolled_item['item_duration']; 
				$item_duration_max = $rolled_item['item_duration_max']; 
				$item_add_power = $rolled_item['item_add_power']; 
				$item_power = $rolled_item['item_power']; 
				$item_price = $rolled_item['item_price']; 
				$item_mp_use = $rolled_item['item_mp_use']; 
				$item_element = $rolled_item['item_element']; 
				$item_element_str_dmg = $rolled_item['item_element_str_dmg']; 
				$item_element_same_dmg = $rolled_item['item_element_same_dmg']; 
				$item_element_weak_dmg = $rolled_item['item_element_weak_dmg']; 
				$item_max_skill = $rolled_item['item_max_skill']; 
				$item_weight = $rolled_item['item_weight']; 
				
				// Give item to user
				$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . " ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , 
						item_duration , item_duration_max , item_power , item_add_power , item_mp_use , item_element , item_element_str_dmg , 
						item_element_same_dmg , item_element_weak_dmg , item_max_skill  , item_weight ) 
						VALUES ( $item_id_new , $user_id , $item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , 
						'" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_duration_max , $item_power ,  
						$item_add_power , $item_mp_use , $item_element , $item_element_str_dmg , $item_element_same_dmg , $item_element_weak_dmg , $item_max_skill , $item_weight)"; 
				$result = $db->sql_query($sql);
				if( !$result )
				{
					message_die(GENERAL_ERROR, "Item doesn't exist !", "", __LINE__, __FILE__, $sql); 
				}
				$dropped_loot_list .= ( $dropped_loot_list == '' ) ? $rolled_item['item_id'] : ":".$rolled_item['item_id'];
				
				$message .= "<tr><td align=\"center\"  valign=\"top\">You found a ".adr_get_lang($rolled_item['item_name'])."<br><img src=\"./adr/images/items/".$rolled_item['item_icon']."\"</td></tr>";
			}
		}
	}
	if ($guranteened_items != 0)
	{
		for ( $i = 0 ; $i < $guranteened_items ; $i++)
		{
			$rolled_loottable = "";
			$timer = 0;
			do
			{
				$timer++;
				//roll the loottable
				$rnd_loottable = rand ( 0 , ( count($monster_loottables) - 1 ));
				//sort out deactivated loottables
				$sql = "SELECT * FROM " . ADR_LOOTTABLES_TABLE."
						WHERE loottable_status = 1
						AND loottable_id = '".$monster_loottables[$rnd_loottable]."'
						";
				$result = $db->sql_query($sql); 
				if( !$result ) 
				{ 
					message_die(GENERAL_ERROR, 'Could not obtain loottable information', "", __LINE__, __FILE__, $sql); 
				} 
				//incase all monsters loottables are deactivated for some reason
				if ($timer > 10000){break;}
			}
			while(!$rolled_loottable = $db->sql_fetchrow($result)) ;
			
			//incase all monsters loottables are deactivated for some reason
			if ($timer > 10000){break;}
			
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE."
			WHERE item_owner_id = 1
				AND (item_loottables like '".$rolled_loottable['loottable_id'].":"."%'
				OR item_loottables like '".$rolled_loottable['loottable_id']."'
				OR item_loottables like '%".":".$rolled_loottable['loottable_id'].":"."%'
				OR item_loottables like '%".":".$rolled_loottable['loottable_id']."')
			";
			if( !($result = $db->sql_query($sql)) ) 
			{
				message_die(GENERAL_ERROR, 'Could not query items list', '', __LINE__, __FILE__, $sql); 
			}
			$guranteened_items_db = $db->sql_fetchrowset($result); 
			
			//now roll for the item
			$rnd_item = rand ( 0 , ( count($guranteened_items_db) - 1 ));
			
			//get the rolled item info
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE."
			WHERE item_owner_id = 1
				AND item_id = '".$guranteened_items_db[$rnd_item]['item_id']."'
			";
			if( !($result = $db->sql_query($sql)) ) 
			{
				message_die(GENERAL_ERROR, 'Could not query items list', '', __LINE__, __FILE__, $sql); 
			}
			$rolled_item = $db->sql_fetchrow($result);
			
			//new id for the item
			$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ."
			   WHERE item_owner_id = $user_id
			   ORDER BY item_id
			   DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
			}
			$item_data = $db->sql_fetchrow($result); 

			$item_id_new = $item_data['item_id'] + 1 ; 
			$item_type = $rolled_item['item_type_use'] ; 
			$item_picture = $rolled_item['item_icon'] ; 
			$item_name = $rolled_item['item_name']; 
			$item_desc = $rolled_item['item_desc']; 
			$item_icon = $rolled_item['item_icon'] ; 
			$item_quality = $rolled_item['item_quality']; 
			$item_duration = $rolled_item['item_duration']; 
			$item_duration_max = $rolled_item['item_duration_max']; 
			$item_add_power = $rolled_item['item_add_power']; 
			$item_power = $rolled_item['item_power']; 
			$item_price = $rolled_item['item_price']; 
			$item_mp_use = $rolled_item['item_mp_use']; 
			$item_element = $rolled_item['item_element']; 
			$item_element_str_dmg = $rolled_item['item_element_str_dmg']; 
			$item_element_same_dmg = $rolled_item['item_element_same_dmg']; 
			$item_element_weak_dmg = $rolled_item['item_element_weak_dmg']; 
			$item_max_skill = $rolled_item['item_max_skill']; 
			$item_weight = $rolled_item['item_weight']; 
			
			// Give item to user
			$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . " ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , 
					item_duration , item_duration_max , item_power , item_add_power , item_mp_use , item_element , item_element_str_dmg , 
					item_element_same_dmg , item_element_weak_dmg , item_max_skill  , item_weight ) 
					VALUES ( $item_id_new , $user_id , $item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , 
					'" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_duration_max , $item_power ,  
					$item_add_power , $item_mp_use , $item_element , $item_element_str_dmg , $item_element_same_dmg , $item_element_weak_dmg , $item_max_skill , $item_weight)"; 
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Item doesn't exist !", "", __LINE__, __FILE__, $sql); 
			}
			$dropped_loot_list .= ( $dropped_loot_list == '' ) ? $rolled_item['item_id'] : ":".$rolled_item['item_id'];
			
			$message .= "<tr><td align=\"center\"  valign=\"top\">You found a ".adr_get_lang($rolled_item['item_name'])."<br><img src=\"./adr/images/items/".$rolled_item['item_icon']."\"</td></tr>";
		}
	}
	if ($monster['monster_specific_drop'] != "" && $monster['monster_specific_drop'] != 0)
	{
		foreach ($specific_items as $value) 
		{
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE."
			WHERE item_owner_id = 1
				AND item_id = $value
			";
			if( !($result = $db->sql_query($sql)) ) 
			{
				message_die(GENERAL_ERROR, 'Could not query items list', '', __LINE__, __FILE__, $sql); 
			}
			$specific_items_db = $db->sql_fetchrow($result);
			
			//new id for the item
			$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ."
			   WHERE item_owner_id = $user_id
			   ORDER BY item_id
			   DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
			}
			$item_data = $db->sql_fetchrow($result); 

			$item_id_new = $item_data['item_id'] + 1 ; 
			$item_type = $specific_items_db['item_type_use'] ; 
			$item_picture = $specific_items_db['item_icon'] ; 
			$item_name = $specific_items_db['item_name']; 
			$item_desc = $specific_items_db['item_desc']; 
			$item_icon = $specific_items_db['item_icon'] ; 
			$item_quality = $specific_items_db['item_quality']; 
			$item_duration = $specific_items_db['item_duration']; 
			$item_duration_max = $specific_items_db['item_duration_max']; 
			$item_add_power = $specific_items_db['item_add_power']; 
			$item_power = $specific_items_db['item_power']; 
			$item_price = $specific_items_db['item_price']; 
			$item_mp_use = $specific_items_db['item_mp_use']; 
			$item_element = $specific_items_db['item_element']; 
			$item_element_str_dmg = $specific_items_db['item_element_str_dmg']; 
			$item_element_same_dmg = $specific_items_db['item_element_same_dmg']; 
			$item_element_weak_dmg = $specific_items_db['item_element_weak_dmg']; 
			$item_max_skill = $specific_items_db['item_max_skill']; 
			$item_weight = $specific_items_db['item_weight']; 
			
			// Give item to user
			$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . " ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , 
					item_duration , item_duration_max , item_power , item_add_power , item_mp_use , item_element , item_element_str_dmg , 
					item_element_same_dmg , item_element_weak_dmg , item_max_skill  , item_weight ) 
					VALUES ( $item_id_new , $user_id , $item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , 
					'" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_duration_max , $item_power ,  
					$item_add_power , $item_mp_use , $item_element , $item_element_str_dmg , $item_element_same_dmg , $item_element_weak_dmg , $item_max_skill , $item_weight)"; 
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Item doesn't exist !", "", __LINE__, __FILE__, $sql); 
			}
			$dropped_loot_list .= ( $dropped_loot_list == '' ) ? $specific_items_db['item_id'] : ":".$specific_items_db['item_id'];

			$message .= "<tr><td align=\"center\"  valign=\"top\">You found a ".adr_get_lang($specific_items_db['item_name'])."<br><img src=\"./adr/images/items/".$specific_items_db['item_icon']."\"</td></tr>";
		}
	}

	$message .= "</table>";

	$array_dropped_loot = explode(':',$dropped_loot_list);
	//////////////////////////////////////// ADVANCED NPC ADDON - START ////////////////////////////////////////
	foreach($array_dropped_loot as $item_drop)
	{
		//get item name
		$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE ."
		   WHERE item_owner_id = 1
		   AND item_id = '".$item_drop."'
			";
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
		}
		$item_data = $db->sql_fetchrow($result);
			
		// Check if the dropped item was needed for a quest
		$sql = " SELECT * FROM " . ADR_QUEST_LOG_TABLE . "
	   		WHERE quest_item_need = '".adr_get_lang($item_data['item_name'])."' 
			AND user_id = '". $user_id ."'
	   		";
		$result = $db->sql_query($sql);
		if( !$result )
	   		message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql);
		if ( $quest_log = $db->sql_fetchrow($result) )
		{
			//Update the Item Quest of the player
			do
			{
				$sql = "UPDATE " . ADR_QUEST_LOG_TABLE . "
					set quest_item_have = quest_item_need 
					WHERE quest_item_need = '".adr_get_lang($item_data['item_name'])."' 
					AND user_id = '". $user_id ."'
					";
				$result = $db->sql_query($sql);
				if( !$result )
					message_die(GENERAL_ERROR, "Couldn't update quest", "", __LINE__, __FILE__, $sql);
			}
			while($quest_log = $db->sql_fetchrow($result)) ;
		}
	}
	// Check if the character killed a monster that he needed for a killing quest !
	$sql = " SELECT * FROM " . ADR_QUEST_LOG_TABLE . "
   		WHERE quest_kill_monster = '".$monster['monster_name']."'
		AND quest_kill_monster_current_amount < quest_kill_monster_amount
		AND user_id = '". $user_id ."'
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
				AND user_id = '". $user_id ."'
				";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, "Couldn't update quest", "", __LINE__, __FILE__, $sql);
		}
	}
	//////////////////////////////////////// ADVANCED NPC ADDON - END ////////////////////////////////////////

	return $message;
}