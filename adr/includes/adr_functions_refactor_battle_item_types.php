<?php
/* V:
 * This functions were made as modifications done to the EzArena premodded board
 * and are "just" code refactoring, because sometimes it makes me cry to have 5-times dups.
 */

function adr_update_element_item_name($item)
{
  if (!$item['item_element'])
    return;
	$element_name = adr_get_element_infos($item['item_element']);
	
	// Here we apply text colour if set
	if ($element_name['element_colour'] != '')
	{
		$item['item_name'] = '<span style="color: ' . $element_name['element_colour'] . '">' . $item['item_name'] . '</span>';
	} //$element_name['element_colour'] != ''
	else
	{
		$item['item_name'] = adr_get_lang($item['item_name']);
	}
}

function adr_calc_magic_power($item, $power, $intelligence, $wisdom)
{
	$dice = rand(1, 20);
  $mod = adr_modifier_calc($intelligence);
	$magic_check = ceil($dice + $item['item_power'] + $mod);
	$fort_save = 11 + adr_modifier_calc($wisdom);
	$diff = ($magic_check >= $fort_save && $dice != '1') || $dice == '20';
  $success = ($diff && $dice != 1) || $dice == 20;
	return array($diff, $power + $mod);
}

function adr_spell_text($item, $current_name, $opponent_name, $damage, $type)
{
  global $lang;

  if (!empty($item['item_element']))
  {
    $element_name = adr_get_element_infos($item['item_element']);
    return sprintf($lang['Adr_'.$type.'_spell_success'], $current_name, $item['item_name'], adr_get_lang($element_name['element_name']), $opponent_name, $damage).'<br />';}
  else
  {
    return sprintf($lang['Adr_'.$type.'_spell_success_norm'], $current_name, $item['item_name'], $opponent_name, $damage).'<br />';
  }
}

function adr_pvp_spell_offensive($item, $power)
{
  global $lang, $self_prefix, $opp_prefix, $battle_message, $battle_id;
  global $opponent_element, $current_infos, $current_name;

  // Grab details for Elemental infos
  $elemental = adr_get_element_infos($opponent_element);
  adr_update_element_item_name($item);

  // Sort out magic check & opponents saving throw
  list($success, $power) = adr_calc_magic_power($item, $power, $current_infos['character_intelligence'], $opponent_infos['character_wisdom']);
  $attbonus = adr_weapon_skill_check_item($user_id, $item);

  // Check for successful strike upon opponent
  if ($success)
  {
    $damage = adr_calc_item_damage($item, $power, $attbonus, $opponent_element);
    $battle_message .= adr_spell_text($item, $current_name, $opponent_name, $damage, 'pvp');
  }
  else{
    $damage = 0;
    $battle_message .= sprintf($lang['Adr_pvp_spell_failure'], $current_name, $item['item_name'], $opponent_name).'<br />';
  }
  adr_pvp_inflict_damage($opp_prefix, $damage, $battle_id);
}

function adr_pvp_spell_defensive($item, $power)
{
  global $db, $battle_message, $lang, $current_name;
  // Create message
  $battle_message .= sprintf($lang['Adr_pvp_spell_defensive_success'], $current_name, adr_get_lang($item['item_name']), $current_name, $power).'<br />';

  $sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
    SET battle_{$self_prefix}_att = (battle_{$self_prefix}_att + $power),
          battle_{$self_prefix}_def = (battle_{$self_prefix}_def + $power)
          WHERE battle_id = '$battle_id'";
  if(!($result = $db->sql_query($sql))){
    message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
}

function adr_spell_offensive($item, $power)
{
	global $monster, $power, $bat, $adr_user, $opponent_element, $db, $lang, $user_id, $quality;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay;

	// Sort out magic check & opponents saving throw
	$wisdom = 10 + (rand(1, $monster['monster_level']) * 2); //temp calc
  list($success, $power) = adr_calc_magic_power($item, $power, $challenger['character_intelligence'], $wisdom);
	
  adr_update_element_item_name($item);
	
	$threat_range = ($item['item_type_use'] == '6') ? '19' : '20'; // magic weaps get slightly better threat range
	list($crit_result, $power) = adr_battle_make_crit_roll($bat['battle_challenger_att'], $challenger['character_level'], $bat['battle_opponent_def'], $item['item_type_use'], $power, $quality, $threat_range);

	rabbit_pet_regen();
	
	$attbonus = adr_weapon_skill_check_item($user_id, $item);
  if ($success)
	{
		$damage = adr_calc_item_damage($item, $power, $attbonus, $opponent_element);
		
		// Fix dmg value
		$damage = ($damage > $bat['battle_opponent_hp']) ? $bat['battle_opponent_hp'] : $damage;
    $battle_message .= adr_spell_text($item, $challenger['character_name'], $monster['monster_name'], $damage, 'battle');
	}
	else
	{
		$damage = 0;
		$battle_message .= sprintf($lang['Adr_battle_spell_failure'], $challenger['character_name'], $item_name, $monster['monster_name']) . '<br />';
	}
  $battle_message .= adr_duration_text($item, $challenger['character_name']);
	
  adr_next_round(BATTLE_TURN_MONSTER,
    "battle_opponent_hp = battle_opponent_hp - $damage,
			battle_challenger_dmg = $damage,");
	// Let's sort out the spell (attack) animations...
	// Make table for battle sequence...
	// 0 = Standing image , 1 = Attack image
	$user_action        = 1;
	$monster_action     = 1;
	$attack_img         = $item['item_name'];
	$attackwith_overlay = ((file_exists("adr/images/battle/spells/" . $attack_img . ".gif"))) ? '<img src="adr/images/battle/spells/' . $attack_img . '.gif" width="256" height="96" border="0">' : '';
}

function adr_spell_defensive($item, $power)
{
	global $monster, $bat, $adr_user, $opponent_element, $db, $lang, $user_id;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay;

	$attbonus = adr_weapon_skill_check($user_id);
	$power = ceil($power * $attbonus);
	rabbit_pet_regen();

	// Create battle message
	$battle_message .= sprintf($lang['Adr_battle_spell_defensive_success'], $challenger['character_name'], $item['item_name'], $power) . '<br>';
  $battle_message .= adr_duration_text($item, $challenger['character_name']);
	
  adr_next_round(BATTLE_TURN_MONSTER, "
		battle_challenger_att = battle_challenger_att + $power ,
			battle_challenger_def = battle_challenger_def + $power ,");
	// Let's sort out the spell (defence) animations...
	// Make table for start battle sequence...
	// 0 = Standing image , 1 = Attack image
	$user_action        = 0;
	$monster_action     = 1;
	$attack_img         = $item['item_name'];
	$attackwith_overlay = ((file_exists("adr/images/battle/spells/" . $attack_img . ".gif"))) ? '<img src="adr/images/battle/spells/' . $attack_img . '.gif" width="256" height="96" border="0">' : '';
}

function adr_magic_attack()
{
	global $monster, $bat, $adr_user, $opponent_element, $item, $db, $lang, $user_id, $power;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay;

	// Sort out magic check & opponents saving throw
	$dice = rand(1,20);
	$monster['monster_wisdom'] = (10 + (rand(1, $monster['monster_level']) *2)); //temp calc
	$magic_check = ceil($dice + $item['spell_power'] + adr_modifier_calc($challenger['character_intelligence']));
	$fort_save = (11 + adr_modifier_calc($monster['monster_wisdom']));
	$diff = ((($magic_check >= $fort_save) && ($dice != '1')) || ($dice == '20')) ? TRUE : FALSE;
	$power = ($power + adr_modifier_calc($challenger['character_intelligence']));

	// Grab details for Elemental infos
	$elemental = adr_get_element_infos($opponent_element);
	$element_name = ($item['spell_name'] != '') ? adr_get_element_infos($item['spell_element']) : '';

	// Here we apply text colour if set
	if($element_name['element_colour'] != ''){
		$item['spell_name'] = '<span style="color: '.$element_name['element_colour'].'">'.adr_get_lang($item['spell_name']).'</span>';}
	else{
		$item['spell_name'] = adr_get_lang($item['spell_name']);
	}

	$attbonus = adr_weapon_skill_check($user_id);

	if((($diff === TRUE) && ($dice != '1')) || ($dice == '20')){
		$damage = 1;

		if($code = $item['spell_xtreme_battle'])
		{
			eval($code);
		}
		else
		{
      $damage = adr_calc_item_damage($item, $power, $attbonus);
			$damage = ($damage > $bat['battle_opponent_hp']) ? $bat['battle_opponent_hp'] : $damage;

			// Fix attack msg type
			if(($item['spell_element'] > '0') && ($element_name['element_name'] != '')){
				$battle_message .= sprintf($lang['Adr_battle_spell_success'], $challenger['character_name'], $item['spell_name'], adr_get_lang($element_name['element_name']), $damage, $monster['monster_name']).'<br>';}
			else{
				$battle_message .= sprintf($lang['Adr_battle_spell_success_norm'], $challenger['character_name'], $item['spell_name'], $damage, $monster['monster_name']).'<br>';}
		}
	}
	else{
		$damage = 0;
		$battle_message .= sprintf( $lang['Adr_battle_spell_failure'], $challenger['character_name'], $item['spell_name'], $monster['monster_name']).'<br />';
	}

  adr_next_round(BATTLE_TURN_MONSTER,
    "battle_opponent_hp = battle_opponent_hp - $damage");
}

function adr_magic_healing()
{
	global $user_id, $item, $db, $power;

	$attbonus = adr_weapon_skill_check($user_id);
	$power = ceil($power * $attbonus);

	if($code = $item['spell_xtreme_battle'])
	{
		eval($code);
		adr_next_round(BATTLE_TURN_MONSTER);
	}
	else
	{
		$hp_check = adr_hp_check();
		$power = ( $power > ( $hp_check['character_hp_max'] - $hp_check['character_hp'] ) ) ? ( $hp_check['character_hp_max'] - $hp_check['character_hp'] ) : $power ;

		$battle_message .= sprintf($lang['Adr_battle_healing_success'] ,$challenger['character_name'], adr_get_lang($item['spell_name']) , $power ).'<br />' ; 
		adr_increase_hp($power);
    adr_next_round(BATTLE_TURN_MONSTER);
	}
}

function adr_magic_defense()
{
	global $user_id, $db, $lang, $power;

	$attbonus = adr_weapon_skill_check($user_id);
	$power = ceil($power * $attbonus);

	if($code = $item['spell_xtreme_battle'])
	{
		eval($code);
		adr_next_round(BATTLE_TURN_MONSTER);
	}
	else
	{
		$battle_message .= sprintf($lang['Adr_battle_spell_defensive_success'], $challenger['character_name'], $item['spell_name'], $power).'<br>';

    adr_next_round(BATTLE_TURN_MONSTER, "
			battle_challenger_att = battle_challenger_att + $power ,
      battle_challenger_def = battle_challenger_def + $power ,
    ");
	}
}

function adr_potion_hp()
{
	global $monster, $bat, $adr_user, $opponent_element, $item, $db, $lang, $user_id, $power;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay;

	rabbit_pet_regen();
	$hp_check = adr_hp_check();
	
	if ($item['item_duration'] < 2 && $power > 0 && $hp_check['character_hp'] < $hp_check['character_hp_max'])
	{
		$power = ($power > ($hp_check['character_hp_max'] - $hp_check['character_hp'])) ? ($hp_check['character_hp_max'] - $hp_check['character_hp']) : $power;
		$battle_message .= sprintf($lang['Adr_battle_potion_hp_dura'], $challenger['character_name'], adr_get_lang($item['item_name']), $power, adr_get_lang($item['item_name'])) . '<br />';
	} //$item['item_duration'] < 2 && $power > 0 && $hp_check['character_hp'] < $hp_check['character_hp_max']
	elseif ($item['item_duration'] < 2 && $power < 1 && $hp_check['character_hp'] < $hp_check['character_hp_max'])
	{
		$power = 0;
		$battle_message .= sprintf($lang['Adr_battle_potion_hp_dura_none'], $challenger['character_name'], adr_get_lang($item['item_name']), adr_get_lang($item['item_name'])) . '<br />';
	} //$item['item_duration'] < 2 && $power < 1 && $hp_check['character_hp'] < $hp_check['character_hp_max']
	elseif ($item['item_duration'] > 1 && $power > 0 && $hp_check['character_hp'] < $hp_check['character_hp_max'])
	{
		$power = ($power > ($hp_check['character_hp_max'] - $hp_check['character_hp'])) ? ($hp_check['character_hp_max'] - $hp_check['character_hp']) : $power;
		$battle_message .= sprintf($lang['Adr_battle_potion_hp_success'], $challenger['character_name'], adr_get_lang($item['item_name']), $power) . '<br />';
	} //$item['item_duration'] > 1 && $power > 0 && $hp_check['character_hp'] < $hp_check['character_hp_max']
	elseif ($item['item_duration'] > 1 && $power < 1 && $hp_check['character_hp'] < $hp_check['character_hp_max'])
	{
		$power = 0;
    $battle_message .= sprintf($lang['Adr_battle_potion_hp_success_none'], $challenger['character_name'], adr_get_lang($item['item_name'])) . '<br />';
	} //$item['item_duration'] > 1 && $power < 1 && $hp_check['character_hp'] < $hp_check['character_hp_max']
	else
	{
		$power = 0;
		
		if ($item['item_duration'] < 2)
		{
			$battle_message .= sprintf($lang['Adr_battle_potion_hp_dura_none'], $challenger['character_name'], adr_get_lang($item['item_name']), adr_get_lang($item['item_name'])) . '<br />';
		} //$item['item_duration'] < 2
		else
		{
			$battle_message .= sprintf($lang['Adr_battle_potion_hp_success_none'], $challenger['character_name'], adr_get_lang($item['item_name'])) . '<br />';
		}
	}
	
	adr_next_round(BATTLE_TURN_MONSTER); // V: note: was *NOT* increasing round...
	adr_increase_hp($power);
	// Let's sort out the potion (hp) animations...
	// Make table for start battle sequence...
	// 0 = Standing image , 1 = Attack image
	$user_action        = 0;
	$monster_action     = 1;
	$attack_img         = $item['item_name'];
	$attackwith_overlay = ((file_exists("adr/images/battle/spells/" . $attack_img . ".gif"))) ? '<img src="adr/images/battle/spells/' . $attack_img . '.gif" width="256" height="96" border="0">' : '';
}

function adr_potion_mp()
{
	global $monster, $bat, $adr_user, $opponent_element, $item, $db, $lang, $user_id, $power;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay;

	rabbit_pet_regen();
	
	if (($item['item_duration'] > '0') && ($challenger['character_mp'] < $challenger['character_mp_max']))
	{
		$power = ($power < '1') ? rand(1, 3) : $power;
		$power = (($power + $challenger['character_mp']) > $challenger['character_mp_max']) ? ($challenger['character_mp_max'] - $challenger['character_mp']) : $power;
		$battle_message .= sprintf($lang['Adr_battle_potion_mp_success'], $challenger['character_name'], adr_get_lang($item['item_name']), $power) . '<br>';
		
    adr_increase_mp($power);
		
    // V: do NOT use item. see the comment in adr_potion_generic
		//adr_use_item($item_potion, $user_id);
	} //($item['item_duration'] > '0') && ($challenger['character_mp'] < $challenger['character_mp_max'])
	elseif (($item['item_duration'] > '0') && ($challenger['character_mp'] >= $challenger['character_mp_max']))
	{
		$power = 0;
		$battle_message .= sprintf($lang['Adr_battle_potion_mp_success_none'], $challenger['character_name'], adr_get_lang($item['item_name'])) . '<br>';
	} //($item['item_duration'] > '0') && ($challenger['character_mp'] >= $challenger['character_mp_max'])
	
	// low dura message
	if (($item['item_duration'] < '2') && ($power > '0'))
	{
		$battle_message .= '</span><span class="gensmall">'; // set new span class
		$battle_message .= '&nbsp;&nbsp;>&nbsp;' . sprintf($lang['Adr_battle_potion_mp_dura_none'], $challenger['character_name'], adr_get_lang($item['item_name']), adr_get_lang($item['item_name'])) . '<br>';
		$battle_message .= '</span><span class="genmed">'; // reset span class to default
	} //($item['item_duration'] < '2') && ($power > '0')
	
	adr_next_round(BATTLE_TURN_MONSTER);
	// Let's sort out the potion (mp) animations...
	// Make table for start battle sequence...
	// 0 = Standing image , 1 = Attack image
	$user_action        = 0;
	$monster_action     = 1;
	$attack_img         = $item['item_name'];
	$attackwith_overlay = ((file_exists("adr/images/battle/spells/" . $attack_img . ".gif"))) ? '<img src="adr/images/battle/spells/' . $attack_img . '.gif" width="256" height="96" border="0">' : '';
}

function adr_potion_generic()
{
	global $monster, $bat, $adr_user, $opponent_element, $item, $db, $lang, $user_id, $power, $phpbb_root_path, $phpEx;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay, $item_potion;

	rabbit_pet_regen();
	
	include_once($phpbb_root_path . '/adr/includes/adr_functions_battle_setup.' . $phpEx);
	$e_message = adr_battle_effects_initialise($user_id, $item_potion, $monster['monster_name'], 0);
	
	// V: NO [OLD: Use item]
  // adr_battle already calls use_item (in its if ($potion ...)). Do NOT call it again here.
	//adr_use_item($item_potion, $user_id);
	
	$battle_message .= $e_message;
	
	// low dura message
	if (($item['item_duration'] < '2') && ($power > '0'))
	{
		//$battle_message .= '</span><span>'; // set new span class
    // V: use _hp text here, instead of _mp
		$battle_message .= '&nbsp;&nbsp;&nbsp;' . sprintf($lang['Adr_battle_potion_hp_dura_none'], $challenger['character_name'], adr_get_lang($item['item_name']), adr_get_lang($item['item_name'])) . '<br>';
		$battle_message .= '</span><span>'; // reset span class to default
	} //($item['item_duration'] < '2') && ($power > '0')
	
	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_turn = 2,
			battle_round = (battle_round + 1)
		WHERE battle_challenger_id = '$user_id'
		AND battle_result = '0'
		AND battle_type = '1'";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
	// Let's sort out the potion (mp) animations...
	// Make table for start battle sequence...
	// 0 = Standing image , 1 = Attack image
	$user_action        = 0;
	$monster_action     = 1;
	$attack_img         = $item['item_name'];
	$attackwith_overlay = ((file_exists("adr/images/battle/spells/" . $attack_img . ".gif"))) ? '<img src="adr/images/battle/spells/' . $attack_img . '.gif" width="256" height="96" border="0">' : '';
}

function adr_pet_special()
{
	global $monster, $bat, $adr_user, $opponent_element, $item, $db, $lang, $user_id, $power;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay;
	global $rabbit_user;

	if ($rabbit_user['creature_attack'] < 1 || $rabbit_user['creature_health'] < 1)
	{
		adr_previous('Adr_battle_pet_dead_or_limitattack', 'adr_battle', '');
	}

	$poison       = '0';
	$pet_regen    = '0';
	$mp_consumned = '0';
	$pet_damage   = '0';
	$health_give  = '0';
	$mana_give    = '0';
	
	if ($rabbit_user['creature_ability'] == '0') //pet have no special ability
	{
		adr_previous(Adr_battle_pet_noability, 'adr_battle', '');
	} //$rabbit_user['creature_ability'] == '0'
	
	
	if ($rabbit_user['creature_ability'] == '1') //pet have regeneration ability
	{
		adr_previous(Adr_battle_pet_regeneration_mess, 'adr_battle', '');
	} //$rabbit_user['creature_ability'] == '1'
	
	if ($rabbit_user['creature_ability'] == '2') //pet have health transfert ability
	{
		$health_give = (($rabbit_user['creature_health'] * $rabbit_general['health_transfert_percent']) / 100);
		$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_pet_health_transfert'], intval($health_give)) . '<br />';
	} //$rabbit_user['creature_ability'] == '2'
	
	if ($rabbit_user['creature_ability'] == '3') //pet have mana transfert ability
	{
		$mana_give = (($rabbit_user['creature_mp'] * $rabbit_general['mana_transfert_percent']) / 100);
		$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_pet_mana_transfert'], intval($mana_give)) . '<br />';
	} //$rabbit_user['creature_ability'] == '3'
	
	if ($rabbit_user['creature_ability'] == '4') //pet have sacrifice ability
	{
		$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + ($rabbit_user['creature_health'] * rand(1, 3)));
		$battle_message .= sprintf($lang['Rabbitoshi_Adr_battle_pet_sacrifice'], intval($pet_damage)) . '<br />';
	} //$rabbit_user['creature_ability'] == '4'
	
	rabbit_pet_regen();
	
	// Check if pet is poisonned
	if ($rabbit_user['creature_statut'] == '3')
	{
		if ($rabbit_user['creature_health'] > 0)
		{
			$poison = rand(1, 3);
			if (($rabbit_user['creature_health'] - $poison) < 0)
			{
				$poison = ($rabbit_user['creature_health_max'] - $rabbit_user['creature_health']);
			} //($rabbit_user['creature_health'] - $poison) < 0
			$battle_message .= sprintf($lang['Adr_battle_pet_poison'], intval($poison)) . '<br />';
		} //$rabbit_user['creature_health'] > 0
	} //$rabbit_user['creature_statut'] == '3'
	
	// Check if user a Amulet for HP regen this turn
	if ($bat['battle_challenger_hp'] != 0)
	{
		if ($challenger['character_hp'] < $challenger['character_hp_max'])
		{
			$hp_regen = intval(adr_hp_regen_check($user_id, $bat['battle_challenger_hp']));
			$battle_message .= sprintf($lang['Adr_battle_regen_xp'], intval($hp_regen)) . '<br />';
		} //$challenger['character_hp'] < $challenger['character_hp_max']
	} //$bat['battle_challenger_hp'] != 0
	
	// Check if user a Ring for MP regen this turn
	if ($bat['battle_challenger_mp'] != 0)
	{
		if ($challenger['character_mp'] < $challenger['character_mp_max'])
		{
			$mp_regen = intval(adr_mp_regen_check($user_id, $bat['battle_challenger_mp']));
			$battle_message .= sprintf($lang['Adr_battle_regen_mp'], intval($mp_regen)) . '<br />';
		} //$challenger['character_mp'] < $challenger['character_mp_max']
	} //$bat['battle_challenger_mp'] != 0
	
	$hp_changes = (($poison + $health_give) - $pet_regen);
	$mp_changes = ($mp_consumned + $mana_give);
	
	if ($hp_changes < 0)
	{
		$hp_changes = ($rabbit_user['creature_health_max'] - $rabbit_user['creature_health']);
	} //$hp_changes < 0
	if ($mp_changes < 0)
	{
		$mp_changes = ($rabbit_user['creature_max_mp'] - $rabbit_user['creature_mp']);
	} //$mp_changes < 0
	if ($rabbit_user['creature_ability'] == '4')
	{
		$hp_changes = ($rabbit_user['creature_health_max'] - $rabbit_user['creature_health']);
	} //$rabbit_user['creature_ability'] == '4'
	
	$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
		SET creature_health = creature_health - $hp_changes,
		    creature_mp = creature_mp - $mp_changes
		WHERE owner_id = $user_id ";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
	} //!$result = $db->sql_query($sql)
	
	if (($challenger['character_hp'] + $health_give) > $challenger['character_hp_max'])
	{
		$health_give = ($challenger['character_hp_max'] - $challenger['character_hp']);
	} //($challenger['character_hp'] + $health_give) > $challenger['character_hp_max']
	
	if (($challenger['character_mp'] + $mana_give) > $challenger['character_mp_max'])
	{
		$mana_give = ($challenger['character_mp_max'] - $challenger['character_mp']);
	} //($challenger['character_mp'] + $mana_give) > $challenger['character_mp_max']
	
	$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . "
            	SET character_hp = character_hp + $health_give,
            	    character_mp = character_mp + $mana_give
            	WHERE character_id = $user_id ";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
	
	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_opponent_hp = battle_opponent_hp - '$pet_damage',
		    battle_turn = 2 ,
		    battle_challenger_dmg = '$pet_damage'
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
}

function adr_pet_attack()
{
	global $monster, $bat, $adr_user, $opponent_element, $item, $db, $lang, $user_id, $power;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay;
	global $rabbit_user;

	if ($rabbit_user['creature_attack'] < 1 || $rabbit_user['creature_health'] < 1)
	{
		adr_previous(Adr_battle_pet_dead_or_limitattack, 'adr_battle', '');
	}

	$pet_poison = '0';
		
	$pet_dice = rand(0, 20);
	if ($rabbit_user['creature_statut'] == '0') //pet in good health
	{
		if ($pet_dice == '20') //define critical hit
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + (rand(2, 5) * 3));
			$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)) . '<br />';
		} //$pet_dice == '20'
		else
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(1, 5));
			$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)) . '<br />';
		}
	} //$rabbit_user['creature_statut'] == '0'
	
	if ($rabbit_user['creature_statut'] == '1') //pet is sad
	{
		if ($pet_dice == '20') //define critical hit
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(2, 10));
			$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)) . '<br />';
		} //$pet_dice == '20'
		else
		{
			$pet_damage = ($rabbit_user['creature_power'] * $rabbit_user['creature_level'] + rand(0, 3));
			$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)) . '<br />';
		}
	} //$rabbit_user['creature_statut'] == '1'
	
	if ($rabbit_user['creature_statut'] == '2') //pet is ill
	{
		if ($pet_dice == '20') //define critical hit
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(1, 5));
			$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)) . '<br />';
		} //$pet_dice == '20'
		else
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) - rand(0, 3));
			$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)) . '<br />';
		}
	} //$rabbit_user['creature_statut'] == '2'
	
	if ($rabbit_user['creature_statut'] == '3') //pet is poisoned
	{
		if ($pet_dice == '20') //define critical hit
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + (rand(2, 5) * 4));
			$poison     = rand(0, 5); // V: poison hurts more if you crit??
			$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)) . '<br />';
		} //$pet_dice == '20'
		else
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(0, 3));
			$poison     = rand(0, 3);
			$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)) . '<br />';
		}
		if ($poison)
		{
			$battle_message .= sprintf($lang['Adr_battle_pet_poison'], intval($poison)) . '<br />';
		}
	} //$rabbit_user['creature_statut'] == '3'
	
	if ($rabbit_user['creature_statut'] == '4') //pet is furious
	{
		if ($pet_dice == '20') //define critical hit
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + (rand(2, 5) * 5));
			$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)) . '<br />';
		} //$pet_dice == '20'
		else
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(0, 10));
			$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)) . '<br />';
		}
	} //$rabbit_user['creature_statut'] == '4'
	
	rabbit_pet_regen();
	adr_use_hp_amulet();
	adr_use_mp_ring();
	
	$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
		SET creature_health = creature_health - '$poison',
		    creature_attack = (creature_attack - 1)
		WHERE owner_id = $user_id ";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
	} //!$result = $db->sql_query($sql)
	
	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_opponent_hp = battle_opponent_hp - '$pet_damage',
		    battle_turn = 2 ,
		    battle_challenger_dmg = '$pet_damage'
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
}

function adr_pet_magic()
{
	global $monster, $bat, $adr_user, $opponent_element, $item, $db, $lang, $user_id, $power;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay;
	global $rabbit_user;

	if ($rabbit_user['creature_attack'] < 1 || $rabbit_user['creature_health'] < 1)
	{
		adr_previous(Adr_battle_pet_dead_or_limitattack, 'adr_battle', '');
	}

	$pet_poison = '0';
	$price_mp   = (rand($rabbit_general['mp_min'], $rabbit_general['mp_max']) * $rabbit_user['creature_level']) || 1; // V: at least 1...
	rabbit_check_mp($price_mp);
	$pet_dice = rand(0, 20);	

	if ($rabbit_user['creature_statut'] == '0') //pet in good health
	{
		if ($pet_dice == '20') //define critical hit
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + (rand(2, 5) * 5));
			$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)) . '<br />';
		} //$pet_dice == '20'
		else
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(3, 8));
			$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)) . '<br />';
		}
	} //$rabbit_user['creature_statut'] == '0'
	
	if ($rabbit_user['creature_statut'] == '1') //pet is sad
	{
		if ($pet_dice == '20') //define critical hit
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(5, 15));
			$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)) . '<br />';
		} //$pet_dice == '20'
		else
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(2, 5));
			$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)) . '<br />';
		}
	} //$rabbit_user['creature_statut'] == '1'
	
	if ($rabbit_user['creature_statut'] == '2') //pet is hill
	{
		if ($pet_dice == '20') //define critical hit
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(3, 8));
			$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)) . '<br />';
		} //$pet_dice == '20'
		else
		{
			$pet_damage = ($rabbit_user['creature_power'] * $rabbit_user['creature_level']);
			$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)) . '<br />';
		}
	} //$rabbit_user['creature_statut'] == '2'
	
	if ($rabbit_user['creature_statut'] == '3') //pet is poisoned
	{
		if ($pet_dice == '20') //define critical hit
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + (rand(2, 5) * 5));
			$poison     = rand(0, 5);
			$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)) . '<br />';
			$battle_message .= sprintf($lang['Adr_battle_pet_poison'], intval($poison)) . '<br />';
		} //$pet_dice == '20'
		else
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(3, 8));
			$poison     = rand(0, 3);
			$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)) . '<br />';
			$battle_message .= sprintf($lang['Adr_battle_pet_poison'], intval($poison)) . '<br />';
		}
	} //$rabbit_user['creature_statut'] == '3'
	
	if ($rabbit_user['creature_statut'] == '4') //pet is furious
	{
		if ($pet_dice == '20') //define critical hit
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + (rand(3, 8) * 6));
			$battle_message .= sprintf($lang['Adr_battle_pet_success_critical'], intval($pet_damage)) . '<br />';
		} //$pet_dice == '20'
		else
		{
			$pet_damage = (($rabbit_user['creature_power'] * $rabbit_user['creature_level']) + rand(5, 10));
			$battle_message .= sprintf($lang['Adr_battle_pet_success'], intval($pet_damage)) . '<br />';
		}
	} //$rabbit_user['creature_statut'] == '4'
	
	rabbit_pet_regen();
	adr_use_hp_amulet();
	adr_use_mp_ring();
	
	$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
		SET creature_health = creature_health - '$poison',
		    creature_mp = creature_mp - '$price_mp',
		    creature_magicattack = (creature_magicattack - 1)
		WHERE owner_id = $user_id ";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not update pet info', '', __LINE__, __FILE__, $sql);
	} //!$result = $db->sql_query($sql)
	
	// Update the database
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_opponent_hp = battle_opponent_hp - '$pet_damage',
		    battle_turn = 2 ,
		    battle_challenger_dmg = '$pet_damage'
		WHERE battle_challenger_id = $user_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if (!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	} //!($result = $db->sql_query($sql))
}

function adr_attack_bare()
{
	global $monster, $bat, $adr_user, $opponent_element, $item, $db, $lang, $user_id, $power, $crit_result;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay;
	global $damage, $dice;


	$monster_def_dice = rand(1, 10);
	$monster_modifier = rand(1, 10); // this is temp. until proper monster characteristics are added to ADR
								     // V: temporary modified to 10 -- see below
	$bare_dice = rand(1, 20);
    // Grab modifers
    $bare_power = adr_modifier_calc($challenger['character_might']);

	// weaprof (yes, even for bare hand)
	$attbonus = adr_weapon_skill_check($user_id);
	if ((($bare_dice + $bare_power > $monster_def_dice + $monster_modifier) && ($bare_dice != '1')) || ($bare_dice == '20'))
	{
		rabbit_pet_regen();
		adr_use_hp_amulet();
		adr_use_mp_ring();

		// Attack success , calculate the damage . Critical dice roll is still success
		$damage = (($bare_dice == '20') && ($crit_roll == '20')) ? ($bare_power * 2) : $bare_power;
		// weap prof
		$damage = ceil($damage * $attbonus);
		// V: sigh.
		$damage = $damage < 1 ? 1 : $damage;
		$damage = ($damage > $bat['battle_opponent_hp']) ? $bat['battle_opponent_hp'] : $damage;

		$battle_message .= $crit_result ? $lang['Adr_battle_critical_hit'] . "<br>" : '';
		$battle_message .= sprintf($lang['Adr_battle_attack_bare'], $challenger['character_name'], floor($attbonus), $damage, $monster['monster_name']) . "<br>";
	} //(($bare_dice + $bare_power > $monster_def_dice + $monster_modifier) && ($bare_dice != '1')) || ($bare_dice == '20')
	else
	{
		$battle_message .= sprintf($lang['Adr_battle_attack_bare_fail'], $challenger['character_name'], $monster['monster_name']) . "<br>";
	}
}

function adr_attack_weap()
{
	global $monster, $bat, $adr_user, $opponent_element, $item, $db, $lang, $user_id, $power, $crit_result;
	global $challenger, $battle_message, $user_action, $monster_action, $attack_img, $attackwith_overlay;
	global $damage, $dice;

	// weaprof
	$attbonus = adr_weapon_skill_check($user_id);
	if ((($diff === TRUE) && ($dice != '1')) || ($dice >= $threat_range))
	{
		// Prefix msg if crit hit
		$battle_message .= ($crit_result === TRUE) ? '<br>' . $lang['Adr_battle_critical_hit'] . '</b><br />' : '';
		$damage = adr_calc_item_damage($item, $power, $attbonus);
		$damage = ($damage > $bat['battle_opponent_hp']) ? $bat['battle_opponent_hp'] : $damage;

		// V: fix element
		$element_name = adr_get_element_infos($item['item_element']);
		
		// Here we apply text colour if set
		if ($element_name['element_colour'] != '')
		{
			$item['item_name'] = '<span style="color: ' . $element_name['element_colour'] . '">' . $item['item_name'] . '</span>';
		} //$element_name['element_colour'] != ''
		else
		{
			$item['item_name'] = $item['item_name'];
		}

		// Fix attack msg type
		if (($item['item_element'] > '0') && ($element_name['element_name'] != ''))
		{
			$battle_message .= sprintf($lang['Adr_battle_attack_success'], $challenger['character_name'], $monster['monster_name'], $item['item_name'], adr_get_lang($element_name['element_name']), floor($attbonus), $damage) . '<br>';
		} //($item['item_element'] > '0') && ($element_name['element_name'] != '')
		else
		{
			$battle_message .= sprintf($lang['Adr_battle_attack_success_norm'], $challenger['character_name'], $monster['monster_name'], $item['item_name'], floor($attbonus), $damage) . '<br>';
		}
	} //(($diff === TRUE) && ($dice != '1')) || ($dice >= $threat_range)
	else
	{
		$damage = 0;
		$battle_message .= sprintf($lang['Adr_battle_attack_failure'], $challenger['character_name'], $monster['monster_name'], $item['item_name']) . '<br>';
	}
}
