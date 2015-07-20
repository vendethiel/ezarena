<?php
/***************************************************************************
 *                                 adr_functions_spells_complete.php
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

// Physical attack increase
function spell_battle_pa_increase($user_id, $power, $character_name, $spell_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$combat = intval($combat);

	spell_pa_increase($user_id, $power, $combat);

	$message =  sprintf($lang['Adr_battle_spell_pa_increase'], $character_name, $spell_name, $power).'<br />';
	return $message;

}
// Physical defense increase
function spell_battle_pd_increase($user_id, $power, $character_name, $spell_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$combat = intval($combat);

	spell_pd_increase($user_id, $power, $combat);

	$message =  sprintf($lang['Adr_battle_spell_pd_increase'], $character_name, $spell_name, $power).'<br />';
	return $message;

}
// Magical attack increase
function spell_battle_ma_increase($user_id, $power, $character_name, $spell_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$combat = intval($combat);

	spell_ma_increase($user_id, $power, $combat);

	$message =  sprintf($lang['Adr_battle_spell_ma_increase'], $character_name, $spell_name, $power).'<br />';
	return $message;

}
// Magical defense increase
function spell_battle_md_increase($user_id, $power, $character_name, $spell_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$combat = intval($combat);

	spell_md_increase($user_id, $power, $combat);

	$message =  sprintf($lang['Adr_battle_spell_md_increase'], $character_name, $spell_name, $power).'<br />';
	return $message;

}
// Magical attack and defense increase
function spell_battle_mamd_increase($user_id, $power, $character_name, $spell_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$combat = intval($combat);

	spell_ma_increase($user_id, $power, $combat);
	spell_md_increase($user_id, $power, $combat);

	$message =  sprintf($lang['Adr_battle_spell_mamd_increase'], $character_name, $spell_name, $power).'<br />';
	return $message;

}
// Physical and magical attack increase
function spell_battle_pama_increase($user_id, $power, $character_name, $spell_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$combat = intval($combat);

	spell_ma_increase($user_id, $power, $combat);
	spell_pa_increase($user_id, $power, $combat);

	$message =  sprintf($lang['Adr_battle_spell_pama_increase'], $character_name, $spell_name, $power).'<br />';
	return $message;

}
// Physical and magical defense increase
function spell_battle_pdmd_increase($user_id, $power, $character_name, $spell_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$combat = intval($combat);

	spell_md_increase($user_id, $power, $combat);
	spell_pd_increase($user_id, $power, $combat);

	$message =  sprintf($lang['Adr_battle_spell_pdmd_increase'], $character_name, $spell_name, $power).'<br />';
	return $message;

}
// Physical and magical attack and defense increase
function spell_battle_papdmamd_increase($user_id, $power, $character_name, $spell_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$combat = intval($combat);

	spell_md_increase($user_id, $power, $combat);
	spell_pd_increase($user_id, $power, $combat);
	spell_ma_increase($user_id, $power, $combat);
	spell_pa_increase($user_id, $power, $combat);

	$message =  sprintf($lang['Adr_battle_spell_papdmamd_increase'], $character_name, $spell_name, $power).'<br />';
	return $message;

}
// Monster physical attack decrease
function spell_battle_monster_pa_decrease($user_id, $power, $character_name, $spell_name, $battle_monster_att, $monster_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$battle_monster_att = intval($battle_monster_att);
	$monster_name = $monster_name;
	$combat = intval($combat);

	if($battle_monster_att > '0')
	{
		if(($battle_monster_att - $power) < '0')
		{
			$att_loss = $battle_monster_att;
		}
		else
		{
			$att_loss = $power;
		}

		spell_monster_pa_decrease($user_id, $att_loss, $combat);

		$message = sprintf($lang['Adr_battle_spell_monster_pa_decrease'], $character_name, $spell_name, $monster_name, $att_loss).'<br />';
	}
	else
	{
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
		$message = sprintf($lang['Adr_battle_spell_monster_pa_decrease_fail'], $character_name, $spell_name, $monster_name).'<br />';
	}
	return $message;

}
// Monster physical defense decrease
function spell_battle_monster_pd_decrease($user_id, $power, $character_name, $spell_name, $battle_monster_def, $monster_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$battle_monster_def = intval($battle_monster_def);
	$monster_name = $monster_name;
	$combat = intval($combat);

	if($battle_monster_def > '0')
	{
		if(($battle_monster_def - $power) < '0')
		{
			$def_loss = $battle_monster_def;
		}
		else
		{
			$def_loss = $power;
		}

		spell_monster_pd_decrease($user_id, $def_loss, $combat);

		$message = sprintf($lang['Adr_battle_spell_monster_pd_decrease'], $character_name, $spell_name, $monster_name, $def_loss).'<br />';
	}
	else
	{
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
		$message = sprintf($lang['Adr_battle_spell_monster_pd_decrease_fail'], $character_name, $spell_name, $monster_name).'<br />';
	}
	return $message;

}
// Monster magical attack decrease
function spell_battle_monster_ma_decrease($user_id, $power, $character_name, $spell_name, $battle_monster_magic_att, $monster_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$battle_monster_magic_att = intval($battle_monster_magic_att);
	$monster_name = $monster_name;
	$combat = intval($combat);

	if($battle_monster_def > '0')
	{
		if(($battle_monster_magic_att - $power) < '0')
		{
			$att_loss = $battle_monster_magic_att;
		}
		else
		{
			$att_loss = $power;
		}

		spell_monster_ma_decrease($user_id, $att_loss, $combat);

		$message = sprintf($lang['Adr_battle_spell_monster_ma_decrease'], $character_name, $spell_name, $monster_name, $att_loss).'<br />';
	}
	else
	{
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
		$message = sprintf($lang['Adr_battle_spell_monster_ma_decrease_fail'], $character_name, $spell_name, $monster_name).'<br />';
	}
	return $message;

}
// Monster magical defense decrease
function spell_battle_monster_md_decrease($user_id, $power, $character_name, $spell_name, $battle_monster_magic_def, $monster_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$battle_monster_magic_def = intval($battle_monster_magic_def);
	$monster_name = $monster_name;
	$combat = intval($combat);

	if($battle_monster_def > '0')
	{
		if(($battle_monster_magic_def - $power) < '0')
		{
			$def_loss = $battle_monster_magic_def;
		}
		else
		{
			$def_loss = $power;
		}

		spell_monster_md_decrease($user_id, $def_loss, $combat);

		$message = sprintf($lang['Adr_battle_spell_monster_md_decrease'], $character_name, $spell_name, $monster_name, $def_loss).'<br />';
	}
	else
	{
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
		$message = sprintf($lang['Adr_battle_spell_monster_md_decrease_fail'], $character_name, $spell_name, $monster_name).'<br />';
	}
	return $message;

}

// Exchange hp for mp
function spell_convert_hp($user_id,$power ,$character_name, $spell_name, $combat)
{
	global $db, $lang;

	$user_id = intval($user_id);
	$power = intval($power);
	$character_name = $character_name;
	$spell_name = $spell_name;
	$combat = intval($combat);

	$mp_gain = spell_mp_gain($user_id, $power);

	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_hp = (character_hp - $mp_gain)
		WHERE character_id = '$user_id'";
	if(!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}

	$message = sprintf($lang['Adr_battle_spell_mana_dura'], $character_name, $item['spell_name'], $mp_gain).'<br />';
	return $message;
}

?>