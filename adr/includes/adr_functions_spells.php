<?php
/***************************************************************************
 *                                 adr_functions_spells.php
 *                            -------------------
 *	Begun                : 2007
 *	Copyright            : egdcltd (http://games.directorygold.com)
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

function adr_spell_add_new($spell_id, $user_id, $location)
{

	global $db;

	$spell_id = intval($spell_id);
	$user_id = intval($user_id);
	$location = $location;

	$user = adr_get_user_infos($user_id);
	$level = $user['character_level'];
	$char_class = $user['character_class'];

	$sql = "SELECT spell_id FROM " . ADR_SHOPS_SPELLS_TABLE ."
		WHERE spell_owner_id = $user_id
		ORDER BY spell_id 
		DESC LIMIT 1";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$new_spell = $db->sql_fetchrow($result);
	$new_item_id = $new_spell['spell_id'] + 1 ;

	$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE ."
		WHERE spell_owner_id = '1'
		AND spell_id = $spell_id";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$data = $db->sql_fetchrow($result);

	$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE ."
		WHERE spell_owner_id = $user_id
		AND spell_original_id = $spell_id";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$learned = $db->sql_fetchrow($result);

	if(!$learned)
	{
		$classes = explode(",", $data['spell_class']);
		$success = ((in_array($char_class, $classes)) || (in_array('0', $classes)));

		if ( $success )
		{

			if($data['spell_level'] > $level )
			{
				adr_previous( Adr_spells_too_powerful , $location , '' ); 
			}
			else
			{
				$item_type_use = $data['item_type_use'];
				$item_name = addslashes($data['spell_name']);
				$item_desc = addslashes($data['spell_desc']);
				$item_icon = trim($data['spell_icon']);
				$item_power = $data['spell_power'];
				$item_add_power = $data['spell_add_power'];
				$item_mp_use = $data['spell_mp_use'];
				$item_element = $data['spell_element'];
				$item_element_str_dmg = $data['spell_element_str_dmg'];
				$item_element_same_dmg = $data['spell_element_same_dmg'];
				$item_element_weak_dmg = $data['spell_element_weak_dmg'];
				$item_max_skill = $data['spell_max_skill'];
				$item_original_id = $data['spell_id'];
				$item_components = $data['spell_items_req'];
				$item_battle = $data['spell_battle'];
				$item_xtreme = addslashes($data['spell_xtreme']);
				$item_xtreme_battle = addslashes($data['spell_xtreme_battle']);
				$item_xtreme_pvp = addslashes($data['spell_xtreme_pvp']);


				$sql = "INSERT INTO " . ADR_SHOPS_SPELLS_TABLE . " 
					( spell_id , spell_owner_id , item_type_use , spell_name , spell_desc , spell_icon , spell_power , spell_add_power , spell_mp_use , spell_element , spell_element_str_dmg , spell_element_same_dmg , spell_element_weak_dmg , spell_max_skill , spell_original_id, spell_items_req, spell_battle, spell_xtreme, spell_xtreme_battle, spell_xtreme_pvp)
					VALUES ( $new_item_id , $user_id , $item_type_use , '$item_name' , '$item_desc' , '" . str_replace("\'", "''", $item_icon) . "' , $item_power , $item_add_power , $item_mp_use , $item_element , $item_element_str_dmg , $item_element_same_dmg , $item_element_weak_dmg , $item_max_skill , $item_original_id , '".$item_components."' , $item_battle , '" . str_replace("\'", "''", $item_xtreme) . "' , '" . str_replace("\'", "''", $item_xtreme_battle) . "' , '" . str_replace("\'", "''", $item_xtreme_pvp) . "' )";
				$result = $db->sql_query($sql);
				if( !$result )
				{
					message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
				}
			}
		}
		else
		{
			adr_previous( Adr_spells_wrong_class , $location , '' );
		}
	}
	else
	{
		adr_previous( Adr_spells_already_learned , $location , '' ); 
	}
}

function adr_learn_spell($recipe_id,$user_id)
{
	global $db;

	// Fix the values
	$recipe_id = intval($recipe_id);
	$user_id = intval($user_id);

	//get info of the owners recipe
  	$sql_owner = "SELECT item_name, item_owner_id, item_id FROM ". ADR_SHOPS_ITEMS_TABLE ."
		WHERE item_owner_id = $user_id
		AND item_id = $recipe_id";
	$result_owner = $db->sql_query($sql_owner);
	if( !$result_owner )
		message_die(GENERAL_ERROR, 'Could not obtain owners recipes information', "", __LINE__, __FILE__, $sql_owner);
	$owner_recipe = $db->sql_fetchrow($result_owner);
	$item_name = $owner_recipe['item_name'];

	//get info of the original recipe
  	$sql_original = "SELECT * FROM ". ADR_SHOPS_ITEMS_TABLE ."
		WHERE item_owner_id = 1
		AND item_name = '$item_name'";
	$result_original = $db->sql_query($sql_original);
	if( !$result_original )
		message_die(GENERAL_ERROR, 'Could not obtain original recipe information', "", __LINE__, __FILE__, $sql_owner);
	$admin_recipe = $db->sql_fetchrow($result_original);

	//get now all info of the up-to-date spell in the spell shop (id 1) (Admin might have changed or deleted it)
  	$sql_admin = "SELECT spell_id, spell_owner_id, spell_linked_item FROM ". ADR_SHOPS_SPELLS_TABLE ."
		WHERE spell_owner_id = 1
		AND spell_linked_item = ".$admin_recipe['item_id'];
		$result_admin = $db->sql_query($sql_admin);
	if( !$result_admin )
		message_die(GENERAL_ERROR, 'Could not obtain original spell information', "", __LINE__, __FILE__, $sql_owner);
	$admin_spell = $db->sql_fetchrow($result_admin);
	$spell_id = $admin_spell['spell_id'];

	if( !$spell_id ) 
	{
		//recipe deleted
		return 2;
	}
	else 
	{
		adr_spell_add_new($spell_id, $user_id, 'adr_character_inventory');

		//delete the just used recipe
		$sql = "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_id = " . $recipe_id . "
			AND item_owner_id = $user_id";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, "Couldn't delete owners recipe", "", __LINE__, __FILE__, $sql);
	
		return 1;

	}
}

function adr_spell_check_components($spell_id, $user_id, $location)
{
	global $db;

	$spell_id = intval($spell_id);
	$user_id = intval($user_id);
	$location = $location;

	//Get spell details
	$sql = "SELECT spell_id, spell_original_id, spell_owner_id FROM " . ADR_SHOPS_SPELLS_TABLE ."
		WHERE spell_id = $spell_id
		AND spell_owner_id = $user_id";
	$result = $db->sql_query($sql);
	if( !$result )
	       message_die(GENERAL_ERROR, 'Could not obtain owners spells information', "", __LINE__, __FILE__, $sql);
	$spell_data = $db->sql_fetchrow($result);

	$spell_id = $spell_data['spell_original_id'];

	//Get original spell details
	$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . "
		WHERE spell_id = '$spell_id'
		AND spell_owner_id = '1'";
	$result = $db->sql_query($sql);
	if( !$result )
	       message_die(GENERAL_ERROR, 'Could not obtain owners spells information', "", __LINE__, __FILE__, $sql);
	$original_data = $db->sql_fetchrow($result);

	$items_req = explode(':',$original_data['spell_items_req']);

	for ($i = 0; $i < count($items_req); $i++)
	{
		$switch = ( !($i % 2) ) ? $check_item=0 : $check_item=1;
		if ($check_item == 1) 
		{
			//get item info
			$sql_info = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_id = ".$items_req[$i-1]."
					AND item_owner_id = '1'";
			$result_info = $db->sql_query($sql_info);
			if( !$result_info )
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql_info);
			$item_info = $db->sql_fetchrow($result_info);
					
			//check the amount in user inventory of each needed item
			$req_item_name = str_replace("'","\'",$item_info['item_name']);
			$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_owner_id = $user_id
				AND item_name = '".$req_item_name."'
				AND item_in_warehouse = 0
				AND item_in_shop = 0
				AND item_duration > 0
				";
			$result = $db->sql_query($sql);
			if( !$result )
			         message_die(GENERAL_ERROR, 'Could not obtain total amount of the needed item', "", __LINE__, __FILE__, $sql);
			$total = $db->sql_fetchrow($result);
					
			if ($total['total'] < $items_req[$i])
				adr_previous ( Adr_spells_missing_item , $location , "" ); 
		}		
	}

	for ($i = 0; $i < count($items_req); $i++)
	{
		$switch = ( !($i % 2) ) ? $check_item=0 : $check_item=1;
		if ($check_item == 1) 
		{
			//get item info
			$sql_info = "SELECT item_name, item_owner_id, item_id FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_id = ".$items_req[$i-1]."
				AND item_owner_id = '1'";
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

}

?>