<?php
/* V:
 * This functions were made as modifications done to the EzArena premodded board
 * and are "just" code refactoring, because sometimes it makes me cry to have 5-times dups.
 */

// battle_result constants
define('BATTLE_ONGOING', 0);
define('BATTLE_WON', 1);
define('BATTLE_LOST', 2);
define('BATTLE_FLEED', 3);

// battle_type constants
define('BATTLE_PVE', 1);
define('BATTE_PVP', 2);

// battle_turn constants
define('BATTLE_TURN_PLAYER', 1);
define('BATTLE_TURN_MONSTER', 2);

function adr_duration_text($item, $self_name)
{
  global $lang;
	if ($item['item_duration'] < 2)
	{
		$message = '</span><span class="gensmall">'; // set new span class
		$message .= '&nbsp;&nbsp;&nbsp;' . sprintf($lang['Adr_battle_spell_dura'], $self_name, $item['item_name']) . '<br>';
		$message .= '</span><span class="genmed">'; // reset span class to default
    return $message;
	} //$item['item_duration'] < 2
  return '';
}

// Select if the user has a battle in progress or no
function adr_get_battle($user_id)
{
	global $db;

	$sql = " SELECT *
	FROM  " . ADR_BATTLE_LIST_TABLE . " 
		WHERE battle_challenger_id = " . intval($user_id) . "
		AND battle_result = " . BATTLE_ONGOING . "
		AND battle_type = " . BATTLE_PVE;
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
	$bat = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	return $bat;
}

function adr_next_round($turn, $extra = '')
{
	global $db, $user_id;

	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
    SET $extra
      battle_round = (battle_round + 1),
			battle_turn = $turn
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}
}

function adr_use_hp_amulet()
{
	global $bat, $challeneger, $hp_regen, $battle_message;

	// Check if user a Amulet for HP regen this turn
	if ($bat['battle_challenger_hp'] != 0)
	{
		if ($challenger['character_hp'] < $challenger['character_hp_max'])
		{
			$hp_regen = intval(adr_hp_regen_check($user_id, $bat['battle_challenger_hp']));
			$battle_message .= sprintf($lang['Adr_battle_regen_xp'], intval($hp_regen)) . '<br />';
		} //$challenger['character_hp'] < $challenger['character_hp_max']
	} //$bat['battle_challenger_hp'] != 0
}

function adr_use_mp_ring()
{
	global $bat, $challeneger, $mp_regen, $battle_message;

	// Check if user a Ring for MP regen this turn	
	if ($bat['battle_challenger_mp'] != 0)
	{
		if ($challenger['character_mp'] < $challenger['character_mp_max'])
		{
			$mp_regen = intval(adr_mp_regen_check($user_id, $bat['battle_challenger_mp']));
			$battle_message .= sprintf($lang['Adr_battle_regen_mp'], intval($mp_regen)) . '<br />';
		} //$challenger['character_mp'] < $challenger['character_mp_max']
	} //$bat['battle_challenger_mp'] != 0
}

/**
 * Sets the turn.
 * If you want to set the round as well, use adr_next_round.
 */
function adr_set_turn($user_id, $turn)
{
	global $db;

	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_turn = " . intval($turn) . "
		WHERE battle_challenger_id = " . intval($user_id) . "
		AND battle_result = 0
		AND battle_type = 1 ";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
	$db->sql_freeresult($result);
}

function adr_items_clear_stolen()
{
	global $db, $user_id;

	// Delete stolen items from users inventory
	$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_monster_thief = '1'
		AND item_owner_id = '$user_id'";
	if (!($result = $db->sql_query($sql)))
		message_die(GENERAL_ERROR, 'Could not delete stolen items', '', __LINE__, __FILE__, $sql);
	$db->sql_freeresult($result);
}

function adr_items_clear_broken()
{
	global $db, $user_id;

	// Delete broken items from users inventory
	$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_duration < '1'
		AND item_in_warehouse = '0'
		AND item_owner_id = '$user_id'";
	if (!($result = $db->sql_query($sql)))
		message_die(GENERAL_ERROR, 'Could not delete broken items', '', __LINE__, __FILE__, $sql);
	$db->sql_freeresult($result);
}

// get an item that's usable in combat
//  = not in shop, not in warehouse, with duration, not bought during battle
function adr_get_item_in_battle($item_id, $ts = null, $pvp = false)
{
	global $item_sql, $user_id, $db;

  $ts_sql = $ts ? " AND (item_bought_timestamp < '$ts' OR item_bought_timestamp = '0')" : "";
  $pvp_sql = $pvp ? " AND item_monster_thief = 0" : "";
	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_in_shop = 0 
		AND item_in_warehouse = 0
		AND item_owner_id = $user_id 
		AND item_duration > 0
		$item_sql
    $ts_sql
    $pvp_sql
		AND item_id = " . intval($item_id);
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
	$item = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	return $item;
}

function adr_hp_check()
{
	global $db, $user_id;

	// New HP check required after regeneration
	$sql = "SELECT character_hp, character_hp_max FROM " . ADR_CHARACTERS_TABLE . "
		WHERE character_id = $user_id ";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not query user', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
	$hp_check = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	return $hp_check;
}

define('ADR_ERROR_ON_EMPTY', true);
define('ADR_ARRAY_ON_EMPTY', false);
function adr_get_spell($spell_id, $error_on_empty)
{
	global $db, $user_id;

	$sql = " SELECT spell_name , spell_power , item_type_use , spell_add_power , spell_mp_use , spell_element , spell_element_str_dmg, spell_element_weak_dmg , spell_element_same_dmg, spell_items_req, spell_xtreme_battle
	FROM " . ADR_SHOPS_SPELLS_TABLE . "
		WHERE spell_owner_id = $user_id 
		AND spell_id = $spell_id 
		ORDER BY spell_name ASC";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	}
	$item = $db->sql_fetchrow($result);
	if ( !$item && $error_on_empty )
	{
		adr_previous ( 'Adr_battle_check' , 'adr_battle' , '' );				
	}
	$db->sql_freeresult($result);
	return $item;
}

function adr_calc_item_damage($item, $power, $attbonus, $opponent_element)
{
  $elemental = adr_get_element_infos($opponent_element);

	if (($item['item_element']) && ($item['item_element'] === $elemental['element_oppose_strong']) && ($item['item_duration'] > '1') && (!empty($item['item_name'])))
	{
		$damage = ceil(($power * ($item['item_element_weak_dmg'] / 100)) * $attbonus);
	}
	elseif (($item['item_element']) && (!empty($item['item_name'])) && ($item['item_element'] === $opponent_element) && ($item['item_duration'] > '1'))
	{
		$damage = ceil(($power * ($item['item_element_same_dmg'] / 100)) * $attbonus);
	}
	elseif (($item['item_element']) && (!empty($item['item_name'])) && ($item['item_element'] === $elemental['element_oppose_weak']) && ($item['item_duration'] > '1'))
	{
		$damage = ceil(($power * ($item['item_element_str_dmg'] / 100)) * $attbonus);
	}
	else
	{
		$damage = ceil($power * $attbonus);
	}

	$damage = ($damage < 1) ? rand(1,3) : $damage;
	return $damage;
}

function adr_check_mp($challenger, $item, $type)
{
  return adr_check_mp_value($challenger['character_mp'], $item, $type);
}

function adr_check_mp_value($mp, $item, $type)
{
  $mp_usage = $item[$type.'_mp_use'] + $item[$type.'_power'];
	if ($mp_usage == '' || $mp < $mp_usage || $mp < 0)
	{ // not enough mana
		adr_previous('Adr_battle_check', 'adr_battle', '');
  }
  return $mp_usage;
}

function adr_substract_mp($mp_usage)
{
	global $db, $user_id;

	if ($mp_usage < 1)
	{
		return;
	}

	// Substract the magic points
	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_mp = character_mp - " . intval($mp_usage) . "
		WHERE character_id = $user_id ";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
	$db->sql_freeresult($result);
}

function adr_substract_hp($hp_usage)
{
	global $db, $user_id;

	if ($hp_usage < 1)
	{
		return;
	}

	// Substract the magic points
	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_hp = character_hp - " . intval($hp_usage) . "
		WHERE character_id = $user_id ";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
	$db->sql_freeresult($result);
}

function adr_increase_hp($hp_usage)
{
	global $db, $user_id;

	if ($hp_usage < 1)
	{
		return;
	}

	// Add HP
	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_hp = character_hp + " . intval($hp_usage) . "
		WHERE character_id = $user_id ";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
	$db->sql_freeresult($result);
}

function adr_increase_mp($mp_usage)
{
	global $db, $user_id;

	if ($mp_usage < 1)
	{
		return;
	}

	// Add MP
	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_mp = character_mp + " . intval($mp_usage) . "
		WHERE character_id = $user_id";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
	$db->sql_freeresult($result);
}

//
/// - RABBIT -
//

function rabbit_check_mp($price_mp)
{
	global $rabbit_user;

	if ($price_mp > $rabbit_user['creature_mp']) // pet doesn't have enough mp
	{
		adr_previous('Adr_battle_pet_mp_lack', 'adr_battle', '');
	}
}

function rabbit_pet_regen()
{
	global $rabbit_user, $battle_message, $db;

	// Check if pet have regeneration ability
	$mp_consumned = '0';
	$pet_regen    = '0';
	if ($rabbit_user['creature_ability'] == '1')
	{
		if (($rabbit_user['creature_health'] < $rabbit_user['creature_health_max']) && ($rabbit_user['creature_health'] > 0) && ($rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need']))
		{
			$mp_consumned = $rabbit_general['regeneration_mp_need'];
			$pet_regen    = $rabbit_general['regeneration_hp_give'];
			$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_regen'], intval($pet_regen)) . '<br />';
		} //($rabbit_user['creature_health'] < $rabbit_user['creature_health_max']) && ($rabbit_user['creature_health'] > 0) && ($rabbit_user['creature_mp'] > $rabbit_general['regeneration_mp_need'])
		$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
			SET creature_health = creature_health + " . intval($pet_regen) . ",
			    creature_mp = creature_mp - " . intval($mp_consumned) . "
			WHERE owner_id = $user_id ";
		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
		} //!$result = $db->sql_query($sql)
		$db->sql_freeresult($result);
	} //$rabbit_user['creature_ability'] == '1'
}

function rabbit_reset_pet()
{
	global $rabbit_user, $db, $user_id;

	if ($rabbit_user['creature_invoc'] != '1')
	{
		return;
	}

	// Set invoc default stats
	$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
		Set creature_invoc = '0'
	WHERE owner_id = $user_id ";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
	} //!$result = $db->sql_query($sql)
	
	// reset furious state
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
}
