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
   {
		$dice= rand (1,9); 
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



function adr_use_skill_hunting($user_id , $tool)
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
      adr_previous( Adr_skill_limit , adr_hunting , '' );
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
      adr_previous( Adr_forge_hunting_broken , adr_hunting , "mode=hunting" );
   }

   // Alter the tool
   adr_use_item($tool , $user_id);

   $adr_general = adr_get_general_config();
   $adr_user = adr_get_user_infos($user_id);
   $skill_data = adr_get_skill_data(11);

   $user_chance = ( $adr_user['character_skill_hunting'] * $skill_data['skill_chance'] );
   $user_chance = ( $user_chance > 100 ) ? 100 : $user_chance ;
   $rand = rand(1,50);

   if ( $user_chance > $rand )
   {
      $modif = ( $item['item_quality'] > 3 ) ? ( $item['item_quality'] - 3 ) : 0 ;
      $modif = $modif + ( $item['item_power'] - 1 );

      $happiness = rand( $modif , 10 );
      $new_item_type = ( $happiness > 9 ) ? 28 : 28;
      
       $sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
            SET character_xp = character_xp + 3
            WHERE character_id = $user_id ";
         $result = $db->sql_query($sql);
         if( !$result )
         {
            message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);
         }
      
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

   if($new_item_type==28)
   { 
   $dice= rand (1,28);
switch ($dice)
{
case 1:
   $item_name = 'Ankylo';
   $item_desc = 'You caught a Ankylo inside the thick woods!';
   $item_icon =  'animals/Ankylo.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 2:
   $item_name = 'Gas Dragon';
   $item_desc = 'You slayed a Gas Dragon in the brush!';
   $item_icon = 'animals/gasdragon.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 3: 
   $item_name = 'Big Eye';
   $item_desc = 'You killed a Big Eye inside the thick woods!';
   $item_icon = 'animals/bigeye.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 4:
   $item_name = 'Blue Dragon';
   $item_desc = 'You slayed a Blue Dragon hidden withing a cave!';
   $item_icon = 'animals/bluedragon.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 5: 
   $item_name = 'Catman';
   $item_desc = 'You shot a Catman lerking in the trees!';
   $item_icon = 'animals/catman.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 6:
   $item_name = 'Chimera';
   $item_desc = 'You slayed a Chimera!';
   $item_icon =  'animals/chimera.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 7:
   $item_name = 'Gigas Worm';
   $item_desc = 'You caught a Gigas Worm in the thick forest!';
   $item_icon = 'animals/grworm.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 8:
   $item_name = 'Hydra';
   $item_desc = 'You slayed a Hydra in the lake beside the forest!';
   $item_icon =  'animals/hydra.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 9:
   $item_name = 'Guard';
   $item_desc = 'You slayed a Guard! What are they up to?';
   $item_icon =  'animals/guard.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 10:
   $item_name = 'Iron Golem';
   $item_desc = 'You slayed an Iron Golem! It wasnt easy!';
   $item_icon =  'animals/irongolem.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 11:
   $item_name = 'Mad Pony';
   $item_desc = 'You caught a Mad Pony!';
   $item_icon =  'animals/madpony.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 12:
   $item_name = 'Manticor';
   $item_desc = 'You caught a Manticor in the woods!';
   $item_icon =  'animals/manticor.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 13:
   $item_name = 'Purple Worm';
   $item_desc = 'You caught a Purple Worm withing the thickness of the forest!';
   $item_icon =  'animals/purpleworm.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 14:
   $item_name = 'Stone Golem';
   $item_desc = 'You slayed a Stone Golem!';
   $item_icon =  'animals/stonegolem.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 15:
   $item_name = 'Ogre';
   $item_desc = 'You slayed the menacing Ogre that has been menicing the towns people!';
   $item_icon =  'animals/ogre.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 16:
   $item_name = 'Red Eye';
   $item_desc = 'You slayed a Red Eye, awsome!';
   $item_icon =  'animals/redeye.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 17:
   $item_name = 'Muck Monster';
   $item_desc = 'You killed a Muck Monster, yuck!';
   $item_icon =  'animals/muck.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 18:
   $item_name = 'Naochu';
   $item_desc = 'You killed a Naochu!';
   $item_icon =  'animals/naocho.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 19:
   $item_name = 'Ochu';
   $item_desc = 'You killed a Ochu!';
   $item_icon =  'animals/ocho.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 20:
   $item_name = 'Sandworm';
   $item_desc = 'You slayed the giant Sand Worm!';
   $item_icon =  'animals/sandworm.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 21:
   $item_name = 'Troll';
   $item_desc = 'You slayed the giant Troll!';
   $item_icon =  'animals/seatroll.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 22:
   $item_name = 'Tyro';
   $item_desc = 'You slayed a Tyro in the clearing!';
   $item_icon =  'animals/tyro.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 23:
   $item_name = 'Fat Eye';
   $item_desc = 'You slayed a Fat Eye in the clearing!';
   $item_icon =  'animals/phsycic eye.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 24:
   $item_name = 'Warmech';
   $item_desc = 'You killed a Warmech next to a cave enterence!';
   $item_icon =  'animals/warmech.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 25:
   $item_name = 'Wyrm';
   $item_desc = 'You slayed the giant dragon, Wyrm!';
   $item_icon =  'animals/wyrm.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 26:
   $item_name = 'Wyvern';
   $item_desc = 'You slayed the giant dragon, Wyvern!';
   $item_icon =  'animals/wyvern.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 27:
   $item_name = 'Inocent Moogle';
   $item_desc = 'WTF is your problem?! You killed a poor inocent Moogle! You damn son-of-a b@#&%!';
   $item_icon =  'animals/mog2.gif';
   $item_quality = rand(1,6);
   $item_duration = rand(1,3);
   $item_power = rand(1,3);
break;
case 28:
   $item_name = 'Inocent Chocobo';
   $item_desc = 'WTF is your problem?! You killed a poor inocent Chocobo!! You damn son-of-a b@#&%! What did they ever do to you?! Youre going to jail! If the Ranger gets you!';
   $item_icon =  'animals/chocobo2.gif';
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
         ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_power )
         VALUES ( $new_item_id , $user_id , $new_item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_power )";
      $result = $db->sql_query($sql);
      if( !$result )
      {
         message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
      }

      // Increases the success uses of this skill and increase level if needed
      if ( ( $adr_user['character_skill_hunting_uses'] +1 ) >= $skill_data['skill_req'] )
      {
         $sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
            SET character_skill_hunting_uses = 0 ,
               character_skill_hunting = character_skill_hunting + 1
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
            SET character_skill_hunting_uses = character_skill_hunting_uses + 1
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
function adr_use_skill_fishing($user_id , $tool)
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
		adr_previous( Adr_skill_limit , adr_fish , '' );
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
		adr_previous( Adr_forge_fishing_broken , adr_fish , "mode=fishing" );
	}

	// Alter the tool
	adr_use_item($tool , $user_id);

	$adr_general = adr_get_general_config();
	$adr_user = adr_get_user_infos($user_id);
	$skill_data = adr_get_skill_data(7);

	$user_chance = ( $adr_user['character_skill_fishing'] * $skill_data['skill_chance'] );
	$user_chance = ( $user_chance > 100 ) ? 100 : $user_chance ;
	$rand = rand(1,50);

	if ( $user_chance > $rand )
	{
		$modif = ( $item['item_quality'] > 3 ) ? ( $item['item_quality'] - 3 ) : 0 ;
		$modif = $modif + ( $item['item_power'] - 1 );

		$happiness = rand( $modif , 10 );
		$new_item_type = ( $happiness > 9 ) ? 32 : 32;
		
		 $sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_xp = character_xp + 3 
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);
			}
		
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
		
	if($new_item_type==32)
	{  
	$dice= rand (1,30); 
switch ($dice) 
{ 
case 1: 
   $item_name = 'Squid'; 
   $item_desc = 'You caught a Squid'; 
   $item_icon = 'fish/INV_Misc_Fish_13.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 2:   
   $item_name = 'Lobster'; 
   $item_desc = 'You caught a Lobster'; 
   $item_icon = 'fish/INV_Misc_Fish_14.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 3: 
   $item_name = 'Shrimp'; 
   $item_desc = 'You caught a Shrimp'; 
   $item_icon = 'fish/INV_Misc_Fish_15.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 4:   
   $item_name = 'Catfish'; 
   $item_desc = 'You caught a Catfish'; 
   $item_icon = 'fish/INV_Misc_Fish_30.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 5: 
   $item_name = 'Eel'; 
   $item_desc = 'You caught a Eel'; 
   $item_icon = 'fish/INV_Misc_Fish_05.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 6: 
   $item_name = 'Smallfish'; 
   $item_desc = 'You caught a smallfish'; 
   $item_icon = 'fish/INV_Misc_Fish_07.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 7: 
   $item_name = 'Blood Belly Fish'; 
   $item_desc = 'You caught a Blood Belly Fish'; 
   $item_icon = 'fish/INV_Misc_Fish_06.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 8: 
   $item_name = 'Dezian Queenfish'; 
   $item_desc = 'You caught a Dezian Queenfish'; 
   $item_icon = 'fish/INV_Misc_Fish_09.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 9: 
   $item_name = 'Harvest Fish'; 
   $item_desc = 'You caught a Harvest Fish'; 
   $item_icon = 'fish/INV_Misc_Fish_19.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 10: 
   $item_name = 'Angel Fish'; 
   $item_desc = 'You caught a Angel Fish'; 
   $item_icon = 'fish/INV_Misc_Fish_08.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 11: 
   $item_name = 'Armor Fish'; 
   $item_desc = 'You caught a Armor Fish'; 
   $item_icon = 'fish/INV_Misc_Fish_04.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 12: 
   $item_name = 'Sage Fish'; 
   $item_desc = 'You caught a Sage Fish'; 
   $item_icon = 'fish/INV_Misc_Fish_20.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 13: 
   $item_name = 'Rockhide Strongfish'; 
   $item_desc = 'You caught a Rockhide Strongfish'; 
   $item_icon = 'fish/INV_Misc_Fish_25.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 14: 
   $item_name = 'Sunfish'; 
   $item_desc = 'You caught a Sunfish'; 
   $item_icon = 'fish/INV_Misc_Fish_03.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 15: 
   $item_name = 'Salmon'; 
   $item_desc = 'You caught a Salmon'; 
   $item_icon = 'fish/INV_Misc_Fish_02.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 16: 
   $item_name = 'Grouper'; 
   $item_desc = 'You caught a Grouper'; 
   $item_icon = 'fish/INV_Misc_Fish_21.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 17: 
   $item_name = 'Bass'; 
   $item_desc = 'You caught a Bass'; 
   $item_icon = 'fish/INV_Misc_Fish_26.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 18: 
   $item_name = 'Trout'; 
   $item_desc = 'You caught a Trout'; 
   $item_icon = 'fish/INV_Misc_Fish_23.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 19: 
   $item_name = 'Flounder'; 
   $item_desc = 'You caught a Flounder'; 
   $item_icon = 'fish/INV_Misc_Fish_22.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 20: 
   $item_name = 'Piranna'; 
   $item_desc = 'You caught a Piranna'; 
   $item_icon = 'fish/INV_Misc_Fish_11.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 21: 
   $item_name = 'Blue Shrimp'; 
   $item_desc = 'You caught a Blue Shrimp'; 
   $item_icon = 'fish/INV_Misc_Fish_34.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 22: 
   $item_name = 'Small Shark'; 
   $item_desc = 'You caught a Small Shark'; 
   $item_icon = 'fish/INV_Misc_Fish_01.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 23: 
   $item_name = 'Sapphire Electric Eel'; 
   $item_desc = 'You caught a Sapphire Electric Eel'; 
   $item_icon = 'fish/INV_Misc_Fish_12.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 24: 
   $item_name = 'Green Shrimp'; 
   $item_desc = 'You caught a Green Shrimp'; 
   $item_icon = 'fish/INV_Misc_Fish_16.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 25: 
   $item_name = 'Blue Eel'; 
   $item_desc = 'You caught a Blue Eel'; 
   $item_icon = 'fish/INV_Misc_Fish_17.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 26: 
   $item_name = 'Sapphire Eel'; 
   $item_desc = 'You caught a Sapphire Eel'; 
   $item_icon = 'fish/INV_Misc_Fish_18.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 27: 
   $item_name = 'Emerald Grouper'; 
   $item_desc = 'You caught a Emerald Grouper'; 
   $item_icon = 'fish/INV_Misc_Fish_24.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 28: 
   $item_name = 'Ruby Trout'; 
   $item_desc = 'You caught a Ruby Trout'; 
   $item_icon = 'fish/INV_Misc_Fish_27.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 29: 
   $item_name = 'Emerald Trout'; 
   $item_desc = 'You caught a Emerald Trout'; 
   $item_icon = 'fish/INV_Misc_Fish_28.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 30: 
   $item_name = 'Ruby Catfish'; 
   $item_desc = 'You caught a Ruby Catfish'; 
   $item_icon = 'fish/INV_Misc_Fish_29.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
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
         ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_power ) 
         VALUES ( $new_item_id , $user_id , $new_item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_power )"; 
      $result = $db->sql_query($sql); 
      if( !$result ) 
      { 
         message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql); 
      } 

      // Increases the success uses of this skill and increase level if needed 
      if ( ( $adr_user['character_skill_fishing_uses'] +1 ) >= $skill_data['skill_req'] ) 
      { 
         $sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
            SET character_skill_fishing_uses = 0 , 
               character_skill_fishing = character_skill_fishing + 1 
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
            SET character_skill_fishing_uses = character_skill_fishing_uses + 1 
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
function adr_use_skill_lumberjack($user_id , $tool)
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
		adr_previous( Adr_skill_limit , adr_lumberjack , '' );
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
		adr_previous( Adr_forge_lumberjack_broken , adr_lumberjack , "mode=lumberjacking" );
	}

	// Alter the tool
	adr_use_item($tool , $user_id);

	$adr_general = adr_get_general_config();
	$adr_user = adr_get_user_infos($user_id);
	$skill_data = adr_get_skill_data(8);

	$user_chance = ( $adr_user['character_skill_lumberjack'] * $skill_data['skill_chance'] );
	$user_chance = ( $user_chance > 100 ) ? 100 : $user_chance ;
	$rand = rand(1,50);

	if ( $user_chance > $rand )
	{
		$modif = ( $item['item_quality'] > 3 ) ? ( $item['item_quality'] - 3 ) : 0 ;
		$modif = $modif + ( $item['item_power'] - 1 );

		$happiness = rand( $modif , 10 );
		$new_item_type = ( $happiness > 9 ) ? 30 : 30;
		
		 $sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_xp = character_xp + 3 
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);
			}
		
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

	if($new_item_type==30)
	{  
	 $dice= rand (1,7);
switch ($dice) 
{ 
case 1: 

   $item_name = 'Badi'; 
   $item_desc = 'You chopped a badi wood out of the trees'; 
   $item_icon =  'wood/INV_Misc_Wood_01.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 2: 

   $item_name = 'Beech'; 
   $item_desc = 'You chopped a beech wood out of the trees'; 
   $item_icon = 'wood/INV_Misc_Wood_02.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 3: 
  
   $item_name = 'Oak'; 
   $item_desc = 'You chopped a oak wood out of the trees'; 
   $item_icon = 'wood/INV_Misc_Wood_03.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 4: 

   $item_name = 'Jatoba'; 
   $item_desc = 'You chopped a jatoba wood out of the trees'; 
   $item_icon = 'wood/INV_Misc_Wood_04.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 5: 
  
   $item_name = 'Ash'; 
   $item_desc = 'You chopped a ash wood out of the tree'; 
   $item_icon = 'wood/INV_Misc_Wood_05.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 6: 

   $item_name = 'Bright Ash'; 
   $item_desc = 'You chopped a bright ash wood out of the tree'; 
   $item_icon =  'wood/INV_Misc_Wood_06.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 7: 

   $item_name = 'Maple'; 
   $item_desc = 'You chopped a maple wood out of the tree'; 
   $item_icon = 'wood/INV_Misc_Wood_07.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
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
         ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_power ) 
         VALUES ( $new_item_id , $user_id , $new_item_type , '" . str_replace("\'", "''", $item_name) . "' , '" . str_replace("\'", "''", $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_power )"; 
      $result = $db->sql_query($sql); 
      if( !$result ) 
      { 
         message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql); 
      } 

      // Increases the success uses of this skill and increase level if needed 
      if ( ( $adr_user['character_skill_lumberjack_uses'] +1 ) >= $skill_data['skill_req'] ) 
      { 
         $sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
            SET character_skill_lumberjack_uses = 0 , 
               character_skill_lumberjack = character_skill_lumberjack + 1 
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
            SET character_skill_lumberjack_uses = character_skill_lumberjack_uses + 1 
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
function adr_use_skill_tailoring($user_id , $tool)
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
		adr_previous( Adr_skill_limit , adr_tailor , '' );
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
		adr_previous( Adr_forge_tailoring_broken , adr_tailor , "mode=tailoring" );
	}

	// Alter the tool
	adr_use_item($tool , $user_id);

	$adr_general = adr_get_general_config();
	$adr_user = adr_get_user_infos($user_id);
	$skill_data = adr_get_skill_data(9);

	$user_chance = ( $adr_user['character_skill_tailoring'] * $skill_data['skill_chance'] );
	$user_chance = ( $user_chance > 100 ) ? 100 : $user_chance ;
	$rand = rand(1,50);

	if ( $user_chance > $rand )
	{
		$modif = ( $item['item_quality'] > 3 ) ? ( $item['item_quality'] - 3 ) : 0 ;
		$modif = $modif + ( $item['item_power'] - 1 );

		$happiness = rand( $modif , 10 );
		$new_item_type = ( $happiness > 9 ) ? 22 : 22;
		
		 $sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_xp = character_xp + 3 
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);
			}
		
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
	if($new_item_type==22)
	{  
	$dice= rand (1,24); 
switch ($dice) 
{ 
case 1: 
   $item_name = 'Cloth Shirt'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth3.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 2:   
   $item_name = 'Cloth Pants'; 
   $item_type = 18;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth2.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 3: 
   $item_name = 'Cloth Robe'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth3.gif'; 
   $item_icon = 'clothes/cloth1.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 4:   
   $item_name = 'Cloth Gloves'; 
   $item_type = 10;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth10.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break;
case 5: 
   $item_name = 'Cloth Boots'; 
   $item_type = 19;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth15.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 6: 
   $item_name = 'Cloth Belt'; 
   $item_type = 32;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth18.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 7: 
   $item_name = 'Silk Shirt'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth8.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 8: 
   $item_name = 'Silk Pants'; 
   $item_type = 18;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth4.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 9: 
   $item_name = 'Silk Robe'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth5'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 10: 
   $item_name = 'Silk Gloves'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth11.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 11: 
   $item_name = 'Silk Boots'; 
   $item_type = 19;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator";
   $item_icon = 'clothes/cloth14.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 12: 
   $item_name = 'Silk Belt'; 
   $item_type = 32;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth16.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 13: 
   $item_name = 'Extravigant Shirt'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth9.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 14: 
   $item_name = 'Extravigant Pants'; 
   $item_type = 18;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth7.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 15: 
   $item_name = 'Extravigant Robe'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator";
   $item_icon = 'clothes/cloth6.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 16: 
   $item_name = 'Extravigant Gloves'; 
   $item_type = 10;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator";
   $item_icon = 'clothes/cloth12.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 17: 
   $item_name = 'Extravigant Boots'; 
   $item_type = 19;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth17.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 18: 
   $item_name = 'Extravigant Belt'; 
   $item_type = 32;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth13.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 19:
   $item_name = 'Sapphire Boots'; 
   $item_type = 19;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth19.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 20: 
   $item_name = 'Arcane Cloak'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth20.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 21: 
   $item_name = 'Emerald Cloak'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth21.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 22: 
   $item_name = 'Leath Shirt'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth22.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 23: 
   $item_name = 'Emerald Shirt'; 
   $item_type = 7;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth23.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 24: 
   $item_name = 'Emerald Sash'; 
   $item_type = 32;
   $item_creator = $adr_user['character_name']; 
   $item_desc = "Made by $item_creator"; 
   $item_icon = 'clothes/cloth24.gif'; 
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
         ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_power ) 
         VALUES ( $new_item_id , $user_id , $item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_power )"; 
      $result = $db->sql_query($sql); 
      if( !$result ) 
      { 
         message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql); 
      } 

      // Increases the success uses of this skill and increase level if needed 
      if ( ( $adr_user['character_skill_tailoring_uses'] +1 ) >= $skill_data['skill_req'] ) 
      { 
         $sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
            SET character_skill_tailoring_uses = 0 , 
               character_skill_tailoring = character_skill_tailoring + 1 
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
            SET character_skill_tailoring_uses = character_skill_tailoring_uses + 1 
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
function adr_use_skill_herbalism($user_id , $tool)
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
		adr_previous( Adr_skill_limit , adr_herbal , '' );
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
		adr_previous( Adr_forge_herbalism_broken , adr_herbal , "mode=herbalism" );
	}

	// Alter the tool
	adr_use_item($tool , $user_id);

	$adr_general = adr_get_general_config();
	$adr_user = adr_get_user_infos($user_id);
	$skill_data = adr_get_skill_data(10);

	$user_chance = ( $adr_user['character_skill_herbalism'] * $skill_data['skill_chance'] );
	$user_chance = ( $user_chance > 100 ) ? 100 : $user_chance ;
	$rand = rand(1,50);

	if ( $user_chance > $rand )
	{
		$modif = ( $item['item_quality'] > 3 ) ? ( $item['item_quality'] - 3 ) : 0 ;
		$modif = $modif + ( $item['item_power'] - 1 );

		$happiness = rand( $modif , 10 );
		$new_item_type = ( $happiness > 9 ) ? 25 : 25;
		
		 $sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_xp = character_xp + 3 
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);
			}
		
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
	if($new_item_type==25)
	{  
	$dice= rand (1,20); 
switch ($dice) 
{ 
case 1: 
   $item_name = 'Peacebloom'; 
   $item_desc = 'You grew a Peacebloom'; 
   $item_icon = 'plants/plant1.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 2:   
   $item_name = 'Silverleaf'; 
   $item_desc = 'You grew a Silverleaf'; 
   $item_icon = 'plants/plant2.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 3: 
   $item_name = 'Mageroyal'; 
   $item_desc = 'You grew a Mageroyal'; 
   $item_icon = 'plants/plant3.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 4:   
   $item_name = 'Briarthorn'; 
   $item_desc = 'You grew a Briarthorn'; 
   $item_icon = 'plants/plant4.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break;
case 5: 
   $item_name = 'Stranglekelp'; 
   $item_desc = 'You grew a Stranglekelp'; 
   $item_icon = 'plants/plant5.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 6: 
   $item_name = 'Swiftthistle'; 
   $item_desc = 'You grew a Swiftthistle'; 
   $item_icon = 'plants/plant6.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 7: 
   $item_name = 'Bruiseweed'; 
   $item_desc = 'You grew a Bruiseweed'; 
   $item_icon = 'plants/plant7.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 8: 
   $item_name = 'Wild Steelbloom'; 
   $item_desc = 'You grew a Wild Steelbloom'; 
   $item_icon = 'plants/plant8.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 9: 
   $item_name = 'Fadeleaf'; 
   $item_desc = 'You grew a Fadeleaf'; 
   $item_icon = 'plants/plant9'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 10:
   $item_name = 'Earthroot'; 
   $item_desc = 'You grew a Earthroot'; 
   $item_icon = 'plants/plant10.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 11: 
   $item_name = 'Weed'; 
   $item_desc = 'You grew a Weed'; 
   $item_icon = 'plants/plant11.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 12: 
   $item_name = 'Plentin'; 
   $item_desc = 'You grew a Plentin'; 
   $item_icon = 'plants/plant12.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 13: 
   $item_name = 'Caris'; 
   $item_desc = 'You grew a Caris'; 
   $item_icon = 'plants/plant13.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 14: 
   $item_name = 'Dandlin'; 
   $item_desc = 'You grew a Dandlin'; 
   $item_icon = 'plants/plant14.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 15: 
   $item_name = 'Bragdrop'; 
   $item_desc = 'You grew a Bragdrop'; 
   $item_icon = 'plants/plant15.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 16: 
   $item_name = 'Griffin'; 
   $item_desc = 'You grew a Griffin'; 
   $item_icon = 'plants/plant16.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 17: 
   $item_name = 'Hightin'; 
   $item_desc = 'You grew a Hightin'; 
   $item_icon = 'plants/plant17.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 18: 
   $item_name = 'Zentinis'; 
   $item_desc = 'You grew a Zentinis'; 
   $item_icon = 'plants/plant18.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 19: 
   $item_name = 'Heptis'; 
   $item_desc = 'You grew a Heptis'; 
   $item_icon = 'plants/plant19.gif'; 
   $item_quality = rand(1,6); 
   $item_duration = rand(1,3); 
   $item_power = rand(1,3); 
break; 
case 20: 
   $item_name = 'Bractin'; 
   $item_desc = 'You grew a Bractin'; 
   $item_icon = 'plants/plant20.gif'; 
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
         ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_power ) 
         VALUES ( $new_item_id , $user_id , $new_item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_power )"; 
      $result = $db->sql_query($sql); 
      if( !$result ) 
      { 
         message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql); 
      } 

      // Increases the success uses of this skill and increase level if needed 
      if ( ( $adr_user['character_skill_herbalism_uses'] +1 ) >= $skill_data['skill_req'] ) 
      { 
         $sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
            SET character_skill_herbalism_uses = 0 , 
               character_skill_herbalism = character_skill_herbalism + 1 
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
            SET character_skill_herbalism_uses = character_skill_herbalism_uses + 1 
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
function adr_use_skill_alchemy($user_id , $tool)
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
		adr_previous( Adr_skill_limit , adr_alchemy , '' );
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
		adr_previous( Adr_forge_alchemy_broken , adr_alchemy , "mode=alchemy" );
	}

	// Alter the tool
	adr_use_item($tool , $user_id);

	$adr_general = adr_get_general_config();
	$adr_user = adr_get_user_infos($user_id);
	$skill_data = adr_get_skill_data(12);

	$user_chance = ( $adr_user['character_skill_alchemy'] * $skill_data['skill_chance'] );
	$user_chance = ( $user_chance > 100 ) ? 100 : $user_chance ;
	$rand = rand(1,50);

	if ( $user_chance > $rand )
	{
		$modif = ( $item['item_quality'] > 3 ) ? ( $item['item_quality'] - 3 ) : 0 ;
		$modif = $modif + ( $item['item_power'] - 1 );

		$happiness = rand( $modif , 10 );
		$new_item_type = ( $happiness > 9 ) ? 34 : 34;
		
		 $sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_xp = character_xp + 3 
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain skill information', "", __LINE__, __FILE__, $sql);
			}
		
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
		
	if($new_item_type==34)
	{  
	$dice= rand (1,32); 
switch ($dice) 
{
case 1:
   $item_name = 'Small Wooden Crate'; 
   $item_desc = 'Basic small wooden crate'; 
   $item_icon = 'alchemy/1.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 2:  
   $item_name = 'Large Wooden Crate'; 
   $item_desc = 'Large wooden crate'; 
   $item_icon = 'alchemy/2.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 3:
   $item_name = 'Wooden Frame'; 
   $item_desc = 'A wooden frame for pictures'; 
   $item_icon = 'alchemy/3.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 4:  
   $item_name = 'Mithril Casing'; 
   $item_desc = 'Mithril casing for armor'; 
   $item_icon = 'alchemy/4.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 5:
   $item_name = 'Pipe'; 
   $item_desc = 'Bronze pipe'; 
   $item_icon = 'alchemy/5.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 6:
   $item_name = 'Ingot'; 
   $item_desc = 'Iron ingot'; 
   $item_icon = 'alchemy/6.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 7:
   $item_name = 'Gold Dust'; 
   $item_desc = 'A pound of gold dust'; 
   $item_icon = 'alchemy/7.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 8:
   $item_name = 'Copper Dust'; 
   $item_desc = 'A pound of copper dust'; 
   $item_icon = 'alchemy/8.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 9:
   $item_name = 'Bronze Dust'; 
   $item_desc = 'A pound of bronze dust'; 
   $item_icon = 'alchemy/9.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 10:
   $item_name = 'Metal Screw'; 
   $item_desc = 'A metal screw'; 
   $item_icon = 'alchemy/10.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 11:
   $item_name = 'Metal Gears'; 
   $item_desc = 'A bunch of metal gears'; 
   $item_icon = 'alchemy/11.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 12:
   $item_name = 'Spy Glass'; 
   $item_desc = 'Spy glass for looking around corners'; 
   $item_icon = 'alchemy/12.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 13:
   $item_name = 'Eye Glass'; 
   $item_desc = 'Small pocket eye glass'; 
   $item_icon = 'alchemy/13.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 14:
   $item_name = 'Goggles'; 
   $item_desc = 'Eye goggles'; 
   $item_icon = 'alchemy/14.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 15:
   $item_name = 'Lightning Collector'; 
   $item_desc = 'Device for collecting lightning magic'; 
   $item_icon = 'alchemy/15.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 16:
   $item_name = 'Water Collector'; 
   $item_desc = 'Device for collecting water magic'; 
   $item_icon = 'alchemy/16.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 17:
   $item_name = 'Earth Collector'; 
   $item_desc = 'Device for collecting earth magic'; 
   $item_icon = 'alchemy/17.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 18:
   $item_name = 'Holy Collector'; 
   $item_desc = 'Device for collecting holy magic'; 
   $item_icon = 'alchemy/18.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 19:
   $item_name = 'Fire Collector'; 
   $item_desc = 'Device for collecting fire magic'; 
   $item_icon = 'alchemy/19.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break; 
case 20:
   $item_name = 'Ice Collector'; 
   $item_desc = 'Device for collecting ice magic'; 
   $item_icon = 'alchemy/20.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 21:
   $item_name = 'Wind Collector'; 
   $item_desc = 'Device for collecting wind magic'; 
   $item_icon = 'alchemy/21.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 22:
   $item_name = 'Curse Collector'; 
   $item_desc = 'Device for collecting curse magic'; 
   $item_icon = 'alchemy/22.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 23:
   $item_name = 'Shadow Collector'; 
   $item_desc = 'Device for collecting shadow magic'; 
   $item_icon = 'alchemy/23.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 24:
   $item_name = 'Poison Collector'; 
   $item_desc = 'Device for collecting poison magic'; 
   $item_icon = 'alchemy/24.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 25:
   $item_name = 'Demi Collector'; 
   $item_desc = 'Device for collecting demi magic'; 
   $item_icon = 'alchemy/25.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 26:
   $item_name = 'Lolli Pop'; 
   $item_desc = 'Sweet lolli pop'; 
   $item_icon = 'alchemy/26.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 27:
   $item_name = 'Ice Cream Cone'; 
   $item_desc = 'Taste ice cream cone'; 
   $item_icon = 'alchemy/27.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 28:
   $item_name = 'Power Gauge'; 
   $item_desc = 'A gauge to your power'; 
   $item_icon = 'alchemy/28.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 29:
   $item_name = 'Building Material'; 
   $item_desc = 'Materials used to help in building'; 
   $item_icon = 'alchemy/29.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 30:
   $item_name = 'Voodoo Doll'; 
   $item_desc = 'Take away your enemies spirit'; 
   $item_icon = 'alchemy/30.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 31:
   $item_name = 'Dynamite'; 
   $item_desc = 'Dynamite sticks'; 
   $item_icon = 'alchemy/31.jpg'; 
   $item_quality = rand(1,6); 
   $item_duration = 1; 
   $item_power = rand(1,3); 
break;
case 32:
   $item_name = 'Dragon Elixer'; 
   $item_desc = 'Special unknown elier'; 
   $item_icon = 'alchemy/32.jpg'; 
   $item_quality = rand(4,6); 
   $item_duration = 1; 
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
         ( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_power ) 
         VALUES ( $new_item_id , $user_id , $new_item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_power )"; 
      $result = $db->sql_query($sql); 
      if( !$result ) 
      { 
         message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql); 
      } 

      // Increases the success uses of this skill and increase level if needed 
      if ( ( $adr_user['character_skill_alchemy_uses'] +1 ) >= $skill_data['skill_req'] ) 
      { 
         $sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
            SET character_skill_alchemy_uses = 0 , 
               character_skill_alchemy = character_skill_alchemy + 1 
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
            SET character_skill_alchemy_uses = character_skill_alchemy_uses + 1 
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