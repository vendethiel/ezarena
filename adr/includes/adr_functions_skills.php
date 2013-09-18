<?php
/***************************************************************************
 *                                 adr_functions_skills.php
 *                            -------------------
 *   begin                : 10/02/2004
 *   copyright            : Dr DLP / Malicious Rabbit
 *   email                : ukc@wanadoo.fr
 *
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

function adr_use_skill_trading($user_id, $price, $type)
{
	global $db;

	$user_id = intval($user_id);
	$price = intval($price);
	$new_price = $price;

	$adr_general = adr_get_general_config();
	$adr_user = adr_get_user_infos($user_id);

	// Roll 1d20 ($rand), then add skill modifier to result
	$rand_start = rand(1,20);
	$trading_modifier = ($rand_start + adr_modifier_calc($adr_user['character_charisma']));

	// Work out chance
	$user_chance = $trading_modifier;
	$user_chance = ($user_chance > '100') ? intval(100) : intval($user_chance);
	$rand = rand(0,100);

	if($user_chance > $rand)
	{
		$modifier = (adr_modifier_calc($adr_user['character_charisma']) *(2 /100));

		switch($type)
		{
			case 'buy':

				$new_price = floor($price *(1 - $modifier));

				// Prevents high Charisma level users from purchasing items for less than the half the price
				$new_price = ($new_price < ($price /2)) ? ($price /2) : $new_price;

				break;

			case 'sell':

				$new_price = floor($price *(1 + $modifier));

				// Prevents high Charisma level users from selling items for more than twice the original price
				$new_price = ($new_price > ($price *2)) ? ($price *2) : $new_price;

				break;
		}
	}

	return $new_price;
}
/*
function adr_skills_max_req($skill_id, $user_skill_level)
{
	global $db, $lang;

	$skill_id = intval($skill_id);
	$user_skill_level = intval($user_skill_level);

	// Get the general config
	$adr_general = adr_get_general_config();

	// Grab skill data
	$sql = "SELECT skill_req, skill_levelup_pen FROM  " . ADR_SKILLS_TABLE . "
			WHERE skill_id = '$skill_id'";
	if(!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain skill infos', "", __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	// Work out max skill req to levelup
	$max_xp = $row['skill_req'];
	for($p = 1; ($p < $user_skill_level); $p++)
	{
		$max_xp = floor($max_xp *(($row['skill_levelup_pen'] +100) /100));
	}

return $max_xp;
}
*/

function adr_use_skill_thief($user_id, $item_dc)
{
	global $db;

	$user_id = intval($user_id);
	$item_dc = intval($item_dc);
	$success = FALSE;

	$adr_general = adr_get_general_config();
	$adr_user = adr_get_user_infos($user_id);
	$skill_data = adr_get_skill_data(6);

	// Work out item steal dc, then roll 1d20 ($rand), then add skill modifier to result
	$item_steal_chance = adr_steal_dc($item_dc);
	$rand = rand(1,20);
	$item_steal_modifier = ($rand + adr_modifier_calc($adr_user['character_skill_thief']));

	// Success theft of item if ($rand + $item_steal_modifier) is more than item steal dc ($item_steal_chance)
	if((($item_steal_modifier > $item_steal_chance) && ($rand != '1')) || ($rand == '20'))
	{
		$success = TRUE;

		// Increases the success uses of this skill and increase level if needed
//		if(($adr_user['character_skill_thief_uses'] + 1) >= adr_skills_max_req($skill_data['skill_id'], $adr_user['character_skill_thief']))
		if(($adr_user['character_skill_thief_uses'] + 1) >= $skill_data['skill_req'])
		{
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_skill_thief_uses = 0,
					character_skill_thief = (character_skill_thief + 1)
				WHERE character_id = '$user_id'";
			$result = $db->sql_query($sql);
			if(!$result){
				message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);}
		}
		else
		{
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_skill_thief_uses = (character_skill_thief_uses + 1)
				WHERE character_id = '$user_id'";
			$result = $db->sql_query($sql);
			if(!$result){
				message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);}
		}
	}

	return $success;
}

function adr_steal_dc($item_dc)
{
	global $db;

	$item_dc = intval($item_dc);

	if($item_dc == '1') $dc = 7; //Very easy
	elseif($item_dc == '2') $dc = 12; //Easy
	elseif($item_dc == '3') $dc = 20; //Average
	elseif($item_dc == '4') $dc = 30; //Tough
	elseif($item_dc == '5') $dc = 45; //Challenging
	elseif($item_dc == '6') $dc = 75; //Formidable
	elseif($item_dc == '7') $dc = 100; //Heroic
	elseif($item_dc == '8') $dc = 150; //Near Impossible

return $dc;
}

function adr_use_skill_forge($user_id , $tool, $item_to_repair )
{
	global $db;

	$user_id = intval($user_id);
	$tool = intval($tool);
	$item_to_repair = intval($item_to_repair);
	$success = 0;
   	$adr_general = adr_get_general_config();

	// START skill limit check
	$sql = " SELECT character_skill_limit FROM " . ADR_CHARACTERS_TABLE . "
			WHERE character_id = $user_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query skill limit value', '', __LINE__, __FILE__, $sql);
	}
	$limit_check = $db->sql_fetchrow($result);

	if ( $adr_general['Adr_character_limit_enable'] != 0 && $limit_check['character_skill_limit'] < 1 )
	{
		adr_previous( Adr_skill_limit , adr_town , '' );
	}
	// END skill limit check

	$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_in_shop = 0 
		AND item_owner_id = $user_id 
		AND item_id = $tool ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query tool informations', '', __LINE__, __FILE__, $sql);
	}
	$item = $db->sql_fetchrow($result);

	if ( $item['item_duration'] < 0 )
	{
		adr_previous( Adr_forge_mining_broken , adr_forge , "mode=repair" );
	}

	// Alter the tool
	adr_use_item($tool , $user_id);

	$sql = " SELECT item_duration , item_duration_max FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_in_shop = 0 
		AND item_owner_id = $user_id 
		AND item_id = $item_to_repair ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query item to repair informations', '', __LINE__, __FILE__, $sql);
	}
	$item_repaired = $db->sql_fetchrow($result);
	if ( $item_repaired['item_duration_max'] < 1 )
	{
		adr_previous( Adr_forge_repair_broken_definitive , adr_forge , "mode=repair" );
	}
	if ( $item_repaired['item_duration'] +1 > $item_repaired['item_duration_max'] )
	{
		adr_previous( Adr_forge_repair_not_needed , adr_forge , "mode=repair" );
	}

	$adr_general = adr_get_general_config();
	$adr_user = adr_get_user_infos($user_id);
	$skill_data = adr_get_skill_data(3);

	$user_chance = ( $adr_user['character_skill_forge'] * $skill_data['skill_chance'] );
	$user_chance = ( $user_chance > 100 ) ? 100 : $user_chance ;
	$rand = rand(0,100);

	// At first let's introduce a little fun
	if ( $rand < 5 )
	{
		// Destroy the item
		$success = -1;

		$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_in_shop = 0 
			AND item_owner_id = $user_id 
			AND item_id = $item_to_repair ";
		if ( !$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update item information', "", __LINE__, __FILE__, $sql);
		}
		
	}

	else if ( ( $user_chance > $rand  ) && $rand > 4 )
	{
		$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_in_shop = 0 
			AND item_owner_id = $user_id 
			AND item_id = $tool ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query tool informations', '', __LINE__, __FILE__, $sql);
		}
		$tool_data = $db->sql_fetchrow($result);

		$modif = ( $tool_data['item_quality'] > 3 ) ? ( $tool_data['item_quality'] - 3 ) : 0 ;
		$modif = $modif + ( $tool_data['item_power'] - 1 );
		$repair_power = ceil( ( $modif + $adr_user['character_skill_forge'] ) / 2 );
		$success = $repair_power;
		adr_skill_limit( $user_id );

		$sql = " UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
			SET item_duration = item_duration + $repair_power ,
			item_duration_max = item_duration_max - 1
			WHERE item_in_shop = 0 
			AND item_owner_id = $user_id 
			AND item_id = $item_to_repair ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update item informations', '', __LINE__, __FILE__, $sql);
		}

		// Increases the success uses of this skill and increase level if needed
		if ( ( $adr_user['character_skill_forge_uses'] +1 ) >= $skill_data['skill_req'] )
		{
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_skill_forge_uses = 0 , 
					character_skill_forge = character_skill_forge + 1
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_skill_forge_uses = character_skill_forge_uses + 1
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
			}
		}
	}

	return $success;
}

function adr_use_skill_enchant($user_id , $tool, $item_to_repair, $mode='' )
{
	global $db;

	$user_id = intval($user_id);
	$tool = intval($tool);
	$item_to_repair = intval($item_to_repair);
	$success = 0;
   	$adr_general = adr_get_general_config();

	// START skill limit check
	$sql = " SELECT character_skill_limit FROM " . ADR_CHARACTERS_TABLE . "
			WHERE character_id = $user_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query skill limit value', '', __LINE__, __FILE__, $sql);
	}
	$limit_check = $db->sql_fetchrow($result);

	if ( $adr_general['Adr_character_limit_enable'] != 0 && $limit_check['character_skill_limit'] < 1 )
	{
		adr_previous( Adr_skill_limit , adr_town , '' );
	}
	// END skill limit check

	$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_in_shop = 0 
		AND item_owner_id = $user_id 
		AND item_id = $tool ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query tool informations', '', __LINE__, __FILE__, $sql);
	}
	$item = $db->sql_fetchrow($result);

	if ( $item['item_duration'] < 0 )
	{
		adr_previous( Adr_forge_mining_broken , adr_forge , "mode=recharge" );
	}

	$adr_general = adr_get_general_config();

	// Alter the tool
	adr_use_item($tool , $user_id);

	$adr_user = adr_get_user_infos($user_id);
	$skill_data = adr_get_skill_data(4);

	$user_chance = ( $adr_user['character_skill_enchantment'] * $skill_data['skill_chance'] );
	$user_chance = ( $user_chance > 100 ) ? 100 : $user_chance ;
	$rand = rand(0,100);

	// At first let's introduce a little fun
	if ( $rand < 5 )
	{
		// Destroy the item
		$success = -1;

		$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_in_shop = 0 
			AND item_owner_id = $user_id 
			AND item_id = $item_to_repair ";
		if ( !$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update item information', "", __LINE__, __FILE__, $sql);
		}
		
	}

	else if ( ( $user_chance > $rand  ) && $rand > 4 )
	{
		$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_in_shop = 0 
			AND item_owner_id = $user_id 
			AND item_id = $tool ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query tool informations', '', __LINE__, __FILE__, $sql);
		}
		$tool_data = $db->sql_fetchrow($result);

		switch($mode)
		{
			case 'recharge' :

				$sql = " SELECT item_duration , item_duration_max FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					AND item_id = $item_to_repair ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query item to repair informations', '', __LINE__, __FILE__, $sql);
				}
				$item_repaired = $db->sql_fetchrow($result);
				if ( $item_repaired['item_duration_max'] < 1 )
				{
					adr_previous( Adr_forge_enchant_broken_definitive , adr_forge , "mode=recharge" );
				}
				if ( $item_repaired['item_duration'] + 1 > $item_repaired['item_duration_max'] )
				{
					adr_previous( Adr_forge_recharge_not_needed , adr_forge , "mode=repair" );
				}

				$modif = ( $tool_data['item_quality'] > 3 ) ? ( $tool_data['item_quality'] - 3 ) : 0 ;
				$modif = $modif + ( $tool_data['item_power'] - 1 );
				$repair_power = ceil( ( $modif + $adr_user['character_skill_enchantment'] ) / 2 );
				$repair_power = (($item_repaired['item_duration'] + $repair_power) > ($item_repaired['item_duration_max'] -1)) ? (($item_repaired['item_duration_max'] -1) - $item_repaired['item_duration']) : $repair_power;
				$success = intval($repair_power); 
				adr_skill_limit( $user_id );

				$sql = " UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
					SET item_duration = item_duration + $repair_power ,
						item_duration_max = item_duration_max - 1
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					AND item_id = $item_to_repair ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not update item informations', '', __LINE__, __FILE__, $sql);
				}
				
				break;

			case 'enchant' :

				$modif = ( $tool_data['item_quality'] > 3 ) ? ( $tool_data['item_quality'] - 3 ) : 0 ;
				$modif = $modif + ( $tool_data['item_power'] - 1 );
				$repair_power = ceil( $modif / 2 );
//				if ( $adr_general['item_power_level'] != 0 )
//				{					
//					if (( $tool_data['item_add_power'] + $repair_power ) > $tool_data['item_max_skill'] )
//					{
//						$repair_power = $tool_data['item_max_skill'];
//					}
//				}
//				else
//				{			
//					if (( $tool_data['item_power'] + $repair_power ) > $tool_data['item_max_skill'] )
//					{
//						$repair_power = $tool_data['item_max_skill'];
//					}				
//				}
				$success = $repair_power;

				// Check if power limit is enabled
				if ( $adr_general['item_power_level'] != 0 )
				{
					$sql = " UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
						SET item_add_power = item_add_power + $repair_power 
						WHERE item_in_shop = 0 
						AND item_owner_id = $user_id 
						AND item_id = $item_to_repair ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not update item informations', '', __LINE__, __FILE__, $sql);
					}
				}
				else
				{
					$sql = " UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
						SET item_power = item_power + $repair_power 
						WHERE item_in_shop = 0 
						AND item_owner_id = $user_id 
						AND item_id = $item_to_repair ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not update item informations', '', __LINE__, __FILE__, $sql);
					}
				}
				
				break;
		}

		// Increases the success uses of this skill and increase level if needed
		if ( ( $adr_user['character_skill_enchantment_uses'] +1 ) >= $skill_data['skill_req'] )
		{
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_skill_enchantment_uses = 0 , 
					character_skill_enchantment = character_skill_enchantment + 1
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_skill_enchantment_uses = character_skill_enchantment_uses + 1
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
			}
		}
	}

	return $success;
}

function adr_use_skill_stone($user_id , $tool, $item_to_repair)
{
	global $db;

	$user_id = intval($user_id);
	$tool = intval($tool);
	$item_to_repair = intval($item_to_repair);
	$success = 0;
	$adr_general = adr_get_general_config();

	// START skill limit check
	$sql = " SELECT character_skill_limit FROM " . ADR_CHARACTERS_TABLE . "
			WHERE character_id = $user_id ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query skill limit value', '', __LINE__, __FILE__, $sql);
	}
	$limit_check = $db->sql_fetchrow($result);

	if ( $adr_general['Adr_character_limit_enable'] != 0 && $limit_check['character_skill_limit'] < 1 )
	{
		adr_previous( Adr_skill_limit , adr_town , '' );
	}
	// END skill limit check

	// Alter the tool
	adr_use_item($tool , $user_id);

	$adr_general = adr_get_general_config();
	$adr_user = adr_get_user_infos($user_id);
	$skill_data = adr_get_skill_data(2);

	$user_chance = ( $adr_user['character_skill_stone'] * $skill_data['skill_chance'] );
	$user_chance = ( $user_chance > 100 ) ? 100 : $user_chance ;
	$rand = rand(0,100);

	// At first let's introduce a little fun
	if ( $rand < 5 )
	{
		// Destroy the item
		$success = -1;

		$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_in_shop = 0 
			AND item_owner_id = $user_id 
			AND item_id = $item_to_repair ";
		if ( !$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not update item information', "", __LINE__, __FILE__, $sql);
		}
		
	}

	else if ( ( $user_chance > $rand  ) && $rand > 4 )
	{
		$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_in_shop = 0 
			AND item_owner_id = $user_id 
			AND item_id = $tool ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query tool informations', '', __LINE__, __FILE__, $sql);
		}
		$tool_data = $db->sql_fetchrow($result);

		$modif = ( $tool_data['item_quality'] > 3 ) ? ( $tool_data['item_quality'] - 3 ) : 0 ;
		$modif = $modif + ( $tool_data['item_power'] - 1 );
		$repair_power = floor( ( $modif + $adr_user['character_skill_stone'] ) / 2 );
		$success = $repair_power;
		adr_skill_limit( $user_id );

		// Check max dura
		$sql = "SELECT item_duration, item_duration_max FROM " . ADR_SHOPS_ITEMS_TABLE . "
		   WHERE item_owner_id = '$user_id'
		   AND item_id = '$item_to_repair'";
		if( !($result = $db->sql_query($sql)) ){
		   message_die(GENERAL_ERROR, 'Could not query tool informations', '', __LINE__, __FILE__, $sql);}
		$max_dura_check = $db->sql_fetchrow($result);
		$new_max_dura = (($max_dura_check['item_duration'] + $repair_power) > $max_dura_check['item_duration_max']) ? ($max_dura_check['item_duration'] + $repair_power) : $max_dura_check['item_duration_max'];

		$sql = " UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
			SET item_duration = item_duration + $repair_power ,
 	           item_duration_max = $new_max_dura,
			    item_quality = item_quality + 1 
			WHERE item_in_shop = 0 
			AND item_quality < 5
			AND item_owner_id = $user_id 
			AND item_id = $item_to_repair ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update item informations', '', __LINE__, __FILE__, $sql);
		}

		// Increases the success uses of this skill and increase level if needed
		if ( ( $adr_user['character_skill_stone_uses'] +1 ) >= $skill_data['skill_req'] )
		{
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_skill_stone_uses = 0 , 
					character_skill_stone = character_skill_stone + 1
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_skill_stone_uses = character_skill_stone_uses + 1
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
			}
		}
	}

	return $success;
}

function adr_skill_limit($user_id)
{
	global $db , $lang, $adr_general;

	// Fix the values
	$user_id = intval($user_id);

   // Only remove if quota is enabled
   if($adr_general['Adr_character_limit_enable'] == '1'){
      $sql = "UPDATE " . ADR_CHARACTERS_TABLE ."
         SET character_skill_limit = (character_skill_limit - 1)
         WHERE character_id = '$user_id'";
      $result = $db->sql_query($sql);
      if(!$result){
         message_die(GENERAL_ERROR, 'Could not update skill skill ', "", __LINE__, __FILE__, $sql);}
   }
}


function adr_use_skill($user_id , $tool, $recipe_item_id, $skill_id, $type)
{
	global $db;

	$user_id = intval($user_id);
	$item_id=intval($item_id);
	$tool = intval($tool);
	$recipe_item_id = intval($recipe_item_id);
	$new_item_id = 0;
	$adr_general = adr_get_general_config();
	$adr_user = adr_get_user_infos($user_id);
	$skill_data = adr_get_skill_data($skill_id);
	$current_file = 'adr_'.$type;
	$character_skill = 'character_skill_'.$type;
	$character_skill_uses = 'character_skill_'.$type.'_uses';

	// START skill limit check

	if ( $adr_general['Adr_character_limit_enable'] != 0 && $adr_user['character_skill_limit'] < 1 )
		adr_previous( Adr_skill_limit , $current_file , "mode=view&known_recipes=$recipe_item_id" );
	// END skill limit check

	$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_in_shop = 0 
		AND item_owner_id = $user_id 
		AND item_id = $tool ";
	if( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, 'Could not query tool informations', '', __LINE__, __FILE__, $sql);
	$item = $db->sql_fetchrow($result);

	// get the information of the item that will be crafted
	//get original recipe information
	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = 1
		AND item_original_recipe_id = $recipe_item_id
		";
	$result = $db->sql_query($sql);
	if( !$result )
	       message_die(GENERAL_ERROR, 'Could not obtain owners recipes information', "", __LINE__, __FILE__, $sql);
	$original_recipe = $db->sql_fetchrow($result);

	//get original (up-to-date) recipe info now
	$sql_recipe = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_id = " . $original_recipe['item_recipe_linked_item'] . "
		AND item_owner_id = 1
		";
	$result_recipe = $db->sql_query($sql_recipe);
	if( !$result_recipe )
		message_die(GENERAL_ERROR, "Couldn't select recipe info", "", __LINE__, __FILE__, $sql_recipe);
	$crafted_item = $db->sql_fetchrow($result_recipe);

	if ( $item['item_duration'] < 0 )
		adr_previous( Adr_forge_broken , $current_file , "mode=view&known_recipes=$recipe_item_id" );

	// Alter the tool
	adr_use_item($tool , $user_id);

	//roll
	$difference = intval($adr_user['character_skill_'.$type.''] - $original_recipe['item_power']);
	$impossible_loose_bonus = 0;
	switch(TRUE)
	{
		case ($difference < -9):$modifier = '-100%';$lose_roll = 100;$impossible_loose_bonus = 1;break; //Impossible
		case ($difference >= -9 && $difference < -6):$modifier = '-80%';$lose_roll = 80;$item_quality = rand(1,2);break; //Very Hard
		case ($difference >= -6 && $difference < -4):$modifier =  '-60%';$lose_roll = 60;$item_quality = rand(1,3);break; //Hard
		case ($difference >= -4 && $difference < -2):$modifier =  '-40%';$lose_roll = 40;$item_quality = rand(1,4);break; //Normal
		case ($difference >= -2 && $difference < 0):$modifier = '-20%';$lose_roll = 20;$item_quality = rand(1,5);break; //Easy
		case ($difference >= 0):$modifier = '-1%';$lose_roll = 5;$item_quality = rand(1,6);break; //Very Easy
	}
	$user_chance =	rand(0,($adr_user['character_skill_'.$type.''] * 100));
	$user_chance = $user_chance + floor( ( $user_chance * $modifier ) / 100 );
	$loose_chance = rand($impossible_loose_bonus,($adr_user['character_skill_'.$type.''] * $lose_roll));

	/*
	echo $modifier." : modifier<br>";
	echo $difference." : difference<br>";
	echo $user_chance." : user chance<br>";
	echo $loose_chance." : loose_chance<br>";
	*/


	// loose a needed item if the rolled dice is bad
	$items_req = explode(':',$crafted_item['item_brewing_items_req']);
	if ( $user_chance < $loose_chance )
	{
		for ($i = 0; $i < count($items_req); $i++)
		{
			$switch = ( !($i % 2) ) ? $get_info=1 : $get_info=0;
			if ($get_info == 1)
				$req_list .= ( $req_list == '' ) ? $items_req[$i] : ':'.$items_req[$i];
		}
		$req_list = explode(':',$req_list);
		$random = rand(0,count($req_list)-1);

		$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE ."
				WHERE item_id = '".$req_list[$random]."'
				AND item_owner_id = 1
				";
		$result = $db->sql_query($sql); 
		if( !$result ) 
			message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql); 
		$req_item = $db->sql_fetchrow($result);
			
        $req_item_name = str_replace("'","\'",$req_item['item_name']); 
		
		//delete item from inventory
		$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_in_shop = 0
			AND item_in_warehouse = 0
			AND item_owner_id = $user_id
			AND item_name = '". $req_item_name ."'
			LIMIT 1
			";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, 'Could not delete item',"", __LINE__, __FILE__, $sql);
			
		$new_item_id  = 'You lost a <br><br><center>'.adr_get_lang($req_item['item_name']).'<br><img src="./adr/images/items/'.$req_item['item_icon'].'"></center><br>during your attempt to cook this food!';
	}
	elseif ( $user_chance > $loose_chance )
	{
		$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
			SET character_xp = character_xp + 3 
			WHERE character_id = $user_id ";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, 'Could not update characters xp', "", __LINE__, __FILE__, $sql);

		for ($i = 0; $i < count($items_req); $i++)
		{
			$switch = ( !($i % 2) ) ? $check_item=0 : $check_item=1;
			if ($check_item == 1) 
			{
				//get item info
				$sql_info = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					where item_id = ".$items_req[$i-1];
				$result_info = $db->sql_query($sql_info);
				if( !$result_info )
					message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql_info);
				$item_info = $db->sql_fetchrow($result_info);
				
				$req_item_name = str_replace("'","\'",$item_info['item_name']);
				echo $rew_item_name."<br>";

				//delete item from inventory
				$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0
					AND item_in_warehouse = 0
					AND item_owner_id = $user_id
					AND item_name = '". $req_item_name ."'
					LIMIT ".$items_req[$i]."
					";
				$result = $db->sql_query($sql);
				if( !$result )
					message_die(GENERAL_ERROR, 'Could not delete item',"", __LINE__, __FILE__, $sql);
			}
		}
		
		// Make the new id for the item
		$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ."
			WHERE item_owner_id = $user_id
			ORDER BY item_id 
			DESC LIMIT 1";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
		$data = $db->sql_fetchrow($result);

		$new_item_id = $data['item_id'] + 1 ;
		$item_name = $crafted_item['item_name'];
		$item_type = $crafted_item['item_type_use'] ; 
		$item_desc = 'Crafted by '.$adr_user['character_name'].''; 
		$item_icon = $crafted_item['item_icon'];
		$item_duration = $crafted_item['item_duration']; 
		$item_duration_max = $crafted_item['item_duration_max']; 
		$item_power = $crafted_item['item_power'];
		$item_add_power = $crafted_item['item_add_power'];
		$item_mp_use = $crafted_item['item_mp_use']; 
		$item_element = $crafted_item['item_element']; 
		$item_element_str_dmg = $crafted_item['item_element_str_dmg']; 
		$item_element_same_dmg = $crafted_item['item_element_same_dmg']; 
		$item_element_weak_dmg = $crafted_item['item_element_weak_dmg']; 
		$item_max_skill = $crafted_item['item_max_skill']; 
		$item_weight = $crafted_item['item_weight']; 
		$item_brewing_items_req = $crafted_item['item_brewing_items_req'];
		$item_effect = $crafted_item['item_effect']; 
		
		adr_skill_limit( $user_id );
		
		// Generate the item price 
		$adr_quality_price = adr_get_item_quality( $item_quality , price ); 
		$adr_type_price = adr_get_item_type( $item_type , price ); 
		$item_price = $adr_type_price; 
		$item_price = $item_price * ( ( $adr_quality_price / 100 )); 
		$item_price = ( $item_power > 1 ) ? ( $item_price + ( $item_price * ( ( $item_power - 1 ) * ( $adr_general['item_modifier_power'] - 100 ) / 100 ))) : $item_price ; 
		$item_price = ceil($item_price); 
		 
		$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . " ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , 
				item_duration , item_duration_max , item_power ,  item_add_power , item_mp_use , item_element , item_element_str_dmg , 
				item_element_same_dmg , item_element_weak_dmg , item_max_skill  , item_weight, item_brewing_items_req, item_effect ) 
				VALUES ( $new_item_id , $user_id , $item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , 
				'" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_duration_max , $item_power , 
				$item_add_power , $item_mp_use , $item_element , $item_element_str_dmg , $item_element_same_dmg , $item_element_weak_dmg , $item_max_skill , $item_weight, '".$item_brewing_items_req."', '".$item_effect."')";
		$result = $db->sql_query($sql); 
		if( !$result ) 
		   message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql); 
		
		// Increases the success uses of this skill and increase level if needed 
		if ( ( $adr_user['character_skill_'.$type.'_uses'] +1 ) >= $skill_data['skill_req'] ) 
		{ 
		   $sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
		      SET $character_skill_uses = 0 , 
		          $character_skill = $character_skill + 1 
		      WHERE character_id = $user_id "; 
		   $result = $db->sql_query($sql); 
		   if( !$result ) 
		      message_die(GENERAL_ERROR, 'Could not update skill information', "", __LINE__, __FILE__, $sql); 
		} 
		else 
		{ 
		   $sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
		      SET $character_skill_uses = $character_skill_uses + 1 
		      WHERE character_id = $user_id "; 
		   $result = $db->sql_query($sql); 
		   if( !$result ) 
		      message_die(GENERAL_ERROR, 'Could not update item information', "", __LINE__, __FILE__, $sql); 
		} 
	}
	
	return $new_item_id; 
} 

function drop_gather_loot($zone_id, $user_id, $type, $skill_number) 
{

	define('IN_ADR_ZONES', true);
	/******************************************************************************
	* $zone_id = zone the chracter is in
	* $user_id = chracters id
	* $type = type of gathering being done, mine, fish, etc, corresponds to 
	* 	               the loottable field in phpbb_adr_zone table
	* $skill_number = number of skill given in phpbb_adr_skills	                
	******************************************************************************/

	global $db , $lang, $adr_general;
	$user_id = intval($user_id);
	$zone_id = intval($zone_id);

	$sql = "SELECT * FROM " . ADR_ZONES_TABLE ."
	WHERE zone_id = $zone_id
	";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain zone information', "", __LINE__, __FILE__, $sql);
	}
	$zone = $db->sql_fetchrow($result);

	//build zone check from table 
	$loot_to_find = 'zone_' .$type . '_table';

	$zone_loottables = explode(':',$zone[$loot_to_find]);

	$sql = "SELECT * FROM " . ADR_SKILLS_TABLE ."
	WHERE skill_id = $skill_number";
	$result = $db->sql_query($sql); 
	if( !$result ) 
	{ 
		message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql); 
	} 
	$skill_data = mysql_fetch_array($result);

	//build character check from table	
	$skill_to_use = "character_skill_" . $type;

	//$difficulty = loottable drop chance?

	$user_chance = ( $adr_user[$skill_to_use] * $skill_data['skill_chance']);


	do
	{
		$timer++;
		//roll the loottable
		$rnd_loottable = rand ( 0 , ( count($zone_loottables) ));

		//sort out deactivated loottables
		$sql = "SELECT * FROM " . ADR_LOOTTABLES_TABLE."
			WHERE loottable_status = 1
			AND loottable_id = '".$zone_loottables[$rnd_loottable]."'";
		$result = $db->sql_query($sql); 
		if( !$result ) 
		{ 
			message_die(GENERAL_ERROR, 'Could not obtain loottable information', "", __LINE__, __FILE__, $sql); 
		} 
		//incase all monsters loottables are deactivated for some reason
		if ($timer > 10){break;}
	}
	while(!$rolled_loottable = $db->sql_fetchrow($result)) ;

	//incase all monsters loottables are deactivated for some reason
	//if ($timer > 10000){break;}

	//now roll to see if we actually get an item
	$max = $user_chance * 100 ;
	$dicer = rand ( 1, $max) ;

	$dicer = $dicer  + ( $adr_user[$skill_to_use] * $skill_data['skill_chance']);

	if ($dicer >= $rolled_loottable['loottable_dropchance'])
	{
		$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE."
		WHERE item_owner_id = 1
		AND (item_loottables like '".$rolled_loottable['loottable_id'].":"."%'
		OR item_loottables like '".$rolled_loottable['loottable_id']."'
		OR item_loottables like '%".":".$rolled_loottable['loottable_id'].":"."%'
		OR item_loottables like '%".":".$rolled_loottable['loottable_id']."')";
		if( !($result = $db->sql_query($sql)) ) 
		{
			message_die(GENERAL_ERROR, 'Could not query items list', '', __LINE__, __FILE__, $sql); 
		}
		$possible_items_db = $db->sql_fetchrowset($result); 

		//now roll for the item
		$rnd_item = rand ( 0 , ( count($possible_items_db) - 1 ));

		//echo "<br> possible_items_db[rnd_item]['item_id']" . $possible_items_db[$rnd_item]['item_id'];


		$item_id = $possible_items_db[$rnd_item]['item_id'];
		// V: REFACTOOOR
		$item_data = adr_shop_insert_item($item_id, adr_make_new_item_id($user_id), $user_id, 1);

		$message .= "<br><br><table align=\"center\" border=\"0\" cellpadding=\"0\" class=\"gen\"><tr>";
		$message .= "<tr><td align=\"center\"  valign=\"top\"><span class=\"gen\">Vous avez obtenu : ".adr_get_lang($item_data['item_name'])."<br><img src=\"./adr/images/items/".$item_data['item_icon']."\"</span></td></tr>";
		$message .= "</table>";
	}
	return $message;
}
