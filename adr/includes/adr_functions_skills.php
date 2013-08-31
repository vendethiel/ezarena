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

function adr_use_skill_mining($user_id , $tool) 
{ 
   global $db; 

   $user_id = intval($user_id); 
   $item_id=intval($item_id); 
   $tool = intval($tool); 
   $new_item_id = 0; 
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
      adr_previous( Adr_forge_mining_broken , adr_forge , "mode=mining" ); 
   } 

   // Alter the tool 
   adr_use_item($tool , $user_id); 

   $adr_general = adr_get_general_config(); 
   $adr_user = adr_get_user_infos($user_id); 
   $skill_data = adr_get_skill_data(1); 

   $user_chance = ( $adr_user['character_skill_mining'] * $skill_data['skill_chance'] ); 
   $user_chance = ( $user_chance > 100 ) ? 100 : $user_chance ; 
   $rand = rand(0,100); 

   if ( $user_chance > $rand ) 
   { 
      $modif = ( $item['item_quality'] > 3 ) ? ( $item['item_quality'] - 3 ) : 0 ; 
      $modif = $modif + ( $item['item_power'] - 1 ); 

      $happiness = rand( $modif , 10 ); 
      $new_item_type = ( $happiness > 9 ) ? 2 : 1; 
       
      // Make the new id for the item 
      $sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ." 
         WHERE item_owner_id = $user_id 
         ORDER BY item_id 
         DESC LIMIT 1"; 
      $result = $db->sql_query($sql); 
      if( !$result ) 
      { 
         message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql); 
      } 
      $data = $db->sql_fetchrow($result); 
      $new_item_id = $data['item_id'] + 1 ; 

      if($new_item_type==1) 
{ 
   $item_name =  'Ore'; 
   $item_desc =  'Adr_item_ore_desc'; 
   $item_icon =  'ore.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
} 
    else 
   {  $dice= rand (1,9); 
   switch ($dice) 
{ 
case 1: 

    $item_name = 'Diamond'; 
   $item_desc = 'A Diamond'; 
   $item_icon =  'diamond.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 2: 

    $item_name = 'Sapphire'; 
   $item_desc = 'A Sapphire'; 
   $item_icon = 'sapphire.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 3: 
  
    $item_name = 'Amethyst'; 
   $item_desc = 'A Amethyst'; 
   $item_icon = 'amethyst.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 4: 

    $item_name = 'Aquamarine'; 
   $item_desc = 'A Aquamarine'; 
   $item_icon = 'Aquamarine.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 5: 
  
    $item_name = 'Emerald'; 
   $item_desc = 'A Emerald'; 
   $item_icon = 'emerald.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break;
case 6: 

    $item_name = 'Ruby'; 
   $item_desc = 'A Ruby'; 
   $item_icon =  'ruby.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 7: 

    $item_name = 'Opal'; 
   $item_desc = 'A Opal'; 
   $item_icon = 'opal.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 8: 
  
    $item_name = 'Topaz'; 
   $item_desc = 'A Topaz'; 
   $item_icon = 'topaz.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 9: 

    $item_name = 'Zircon'; 
   $item_desc = 'A Zircon'; 
   $item_icon = 'zircon.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
} 
} 


      adr_skill_limit( $user_id ); 

      // Generate the item price 
      $adr_quality_price = adr_get_item_quality( $item_quality , price ); 
      $adr_type_price = adr_get_item_type( $new_item_type , price ); 
      $item_price = $adr_type_price; 
      $item_price = $item_price * ( ( $adr_quality_price / 100 )); 
      $item_price = ( $item_power > 1 ) ? ( $item_price + ( $item_price * ( ( $item_power - 1 ) * ( $adr_general['item_modifier_power'] - 100 ) / 100 ))) : $item_price ; 
      $item_price = ceil($item_price); 

       
       
      $sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . " 
         ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_duration_max , item_power ) 
         VALUES ( $new_item_id , $user_id , $new_item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration, $item_duration , $item_power )"; 
      $result = $db->sql_query($sql); 
      if( !$result ) 
      { 
         message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql); 
      } 

      // Increases the success uses of this skill and increase level if needed 
      if ( ( $adr_user['character_skill_mining_uses'] +1 ) >= $skill_data['skill_req'] ) 
      { 
         $sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
            SET character_skill_mining_uses = 0 , 
               character_skill_mining = character_skill_mining + 1 
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
            SET character_skill_mining_uses = character_skill_mining_uses + 1 
            WHERE character_id = $user_id "; 
         $result = $db->sql_query($sql); 
         if( !$result ) 
         { 
            message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql); 
         } 
      } 
   } 

   return $new_item_id; 
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