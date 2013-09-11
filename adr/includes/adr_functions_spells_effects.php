<?php
/***************************************************************************
 *                                 adr_functions_spells_effects.php
 *                            -------------------
 *	Begun                : 2007
 *	Copyright            : egdcltd
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


function spell_pa_increase($user_id, $power, $combat)
{
	global $db;

	$user_id = intval($user_id);
	$power = intval($power);
	$combat = intval($combat);

	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_challenger_att = battle_challenger_att + $power ,
			battle_turn = 2
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}
}

function spell_pd_increase($user_id, $power, $combat)
{
	global $db;

	$user_id = intval($user_id);
	$power = intval($power);
	$combat = intval($combat);

	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_challenger_def = battle_challenger_def + $power ,
			battle_turn = 2
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}
}

function spell_ma_increase($user_id, $power, $combat)
{
	global $db;

	$user_id = intval($user_id);
	$power = intval($power);
	$combat = intval($combat);

	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_challenger_magic_attack = battle_challenger_magic_attack + $power ,
			battle_turn = 2
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}
}

function spell_md_increase($user_id, $power, $combat)
{
	global $db;

	$user_id = intval($user_id);
	$power = intval($power);
	$combat = intval($combat);

	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_challenger_magic_resistance = battle_challenger_magic_resistance + $power ,
			battle_turn = 2
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}
}

function spell_monster_pa_decrease($user_id, $power, $combat)
{
	global $db;

	$user_id = intval($user_id);
	$power = intval($power);
	$combat = intval($combat);

	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_opponent_att = battle_opponent_att - $power ,
			battle_turn = 2
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}
}

function spell_monster_pd_decrease($user_id, $power, $combat)
{
	global $db;

	$user_id = intval($user_id);
	$power = intval($power);
	$combat = intval($combat);

	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_opponent_def = battle_opponent_def - $power ,
			battle_turn = 2
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}
}

function spell_monster_ma_decrease($user_id, $power, $combat)
{
	global $db;

	$user_id = intval($user_id);
	$power = intval($power);
	$combat = intval($combat);

	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_opponent_magic_attack = battle_opponent_magic_attack - $power ,
			battle_turn = 2
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}
}

function spell_monster_md_decrease($user_id, $power, $combat)
{
	global $db;

	$user_id = intval($user_id);
	$power = intval($power);
	$combat = intval($combat);

	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_opponent_magic_resistance = battle_opponent_magic_resistance - $power ,
			battle_turn = 2
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}
}

function spell_random_damage($dice_number,$dice_side, $combat)
{
	global $db;
	$dice_number = intval($dice_number);
	$dice_side = intval($dice_side);
	$combat = intval($combat);

	$rand_damage = '0';

	for ($i = 0; $i < count($dice_number); $i++)
	{
		$damage = rand(1, $dice_side);
		$rand_damage = $rand_damage + $damage;
	}
	return $rand_damage;
}

function spell_add_hp_to_member($other_member_id, $hp_heal, $combat)
{
	global $db , $phpbb_root_path , $phpEx , $table_prefix ;
	$combat = intval($combat);

	include_once($phpbb_root_path . 'includes/constants.'.$phpEx);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	// Set character HP to script config
	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_hp = character_hp + $hp_heal
		WHERE character_id = $other_member_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
	}
}

function spell_remove_mp($user_id, $mp_cost, $combat)
{
 	global $db;

	$user_id = intval($user_id);
	$mp_cost = intval($mp_cost);
	$combat = intval($combat);

	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_mp = character_mp - $mp_cost
		WHERE character_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Error in adding MP cost', '', __LINE__, __FILE__, $sql);
	}
}

function spell_remove_hp_from_member($user_id, $hp, $combat)
{
 	global $db;

	$user_id = intval($user_id);
	$hp = intval($hp);
	$combat = intval($combat);

	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_hp = character_hp - $hp
		WHERE character_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Error in deducting HP', '', __LINE__, __FILE__, $sql);
	}
}

/*
function spell_buff($user_id, $buff, $name, $dura, $debuff)
{
   global $db;

   $user_id = intval($user_id);

   // Update the database
   $sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
      SET '$buff', character_buff_name = '$name', character_buff_dura = '$dura', $debuff WHERE character_id = $user_id;
   if( !($result = $db->sql_query($sql)) )
   {
      message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
   }
} 
*/

?>