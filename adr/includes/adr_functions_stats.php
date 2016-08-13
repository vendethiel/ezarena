<?php
/***************************************************************************
 *                                 adr_functions_alone.php
 *                            -------------------
 *   begin                : 11/02/2004
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

function adr_seek_levelup($user_id)
{
	global $db, $adr_general;

	$user_id = intval($user_id);
	$level_up = FALSE;

	$sql = "SELECT cl.class_update_xp_req , c.character_xp , c.character_level FROM " . ADR_CHARACTERS_TABLE . " c , " . ADR_CLASSES_TABLE . " cl
		WHERE cl.class_id = c.character_class 
		AND c.character_id = $user_id ";
	if (!($result = $db->sql_query($sql) ))
	{
		message_die(GENERAL_ERROR, 'Could not check user experience',"", __LINE__, __FILE__, $sql);
	}
	$level = $db->sql_fetchrow($result);

	$max_hp = $level['class_update_xp_req'];
	for ( $p = 1 ; $p < $level['character_level'] ; $p ++ )
	{
		$max_hp = floor($max_hp * ( ( $adr_general['next_level_penalty'] + 100 ) / 100 ));
	}

	if ( $level['character_xp'] >= $max_hp )
	{
		$level_up = TRUE;
	}

	return $level_up;
}

function adr_level_up($user_id , $from )
{
	global $db , $lang , $phpEx , $adr_general;

	$user_id = intval($user_id);

	$sql = "SELECT cl.* , c.* FROM " . ADR_CHARACTERS_TABLE . " c , " . ADR_CLASSES_TABLE . " cl
		WHERE cl.class_id = c.character_class 
		AND c.character_id = $user_id ";
	if (!($result = $db->sql_query($sql) ))
	{
		message_die(GENERAL_ERROR, 'Could not check user experience',"", __LINE__, __FILE__, $sql);
	}
	$level = $db->sql_fetchrow($result);

	$max_hp = $level['class_update_xp_req'];
	for ( $p = 1 ; $p < $level['character_level'] ; $p ++ )
	{
		$max_hp = floor($max_hp * ( ( $adr_general['next_level_penalty'] + 100 ) / 100 ));
	}

	// Damned vicious users :)
	if ( ( $level['character_xp'] < $max_hp ) && $from == 'character_page' )
	{
		exit;
	}

	$xp_req = $max_hp;
	$hp = intval($level['class_update_hp']);
	$mp = intval($level['class_update_mp']);
	$ac = intval($level['class_update_ac']);

	switch($from)
	{
		case 'character_page':
			$direction = append_sid("adr_character.$phpEx");
			$more_sql = 'character_xp = character_xp - '.$xp_req;
			break;

		case 'training':	
			$direction = append_sid("adr_character_training.$phpEx");
			$more_sql = 'character_xp = 0 ';
			break;
	}

	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_level = character_level + 1 ,
			character_ac = character_ac + $ac,
			character_mp_max = character_mp_max + $mp,
			character_hp_max = character_hp_max + $hp,
			$more_sql
		WHERE character_id = $user_id ";
	if (!($result = $db->sql_query($sql) ))
	{
		message_die(GENERAL_ERROR, 'Could not update user experience',"", __LINE__, __FILE__, $sql);
	}

	$new_level = $level['character_level'] + 1 ;
	$sql = "SELECT spell_id FROM " . ADR_SHOPS_SPELLS_TABLE ."
		WHERE spell_owner_id = $user_id
		ORDER BY spell_id 
		DESC LIMIT 1";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$data = $db->sql_fetchrow($result);
	$new_item_id = $data['spell_id'] + 1 ;

	$sql = "SELECT * FROM " .  ADR_CHARACTERS_TABLE ."
		WHERE character_id = $user_id";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$char1 = $db->sql_fetchrow($result);
	$char_class = $char1['character_class'];

	$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE ."
		WHERE spell_level = $new_level
		AND spell_owner_id = '1'";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$data = $db->sql_fetchrowset($result);

	$spell_list = array();
        for($i = 0; $i < count($data); $i++)
        {

			// Check to see if any spells are available
			$classes = explode(",", $data[$i]['spell_class']);    // Create our array
			$success = ((in_array($char_class, $classes)) || (in_array('0', $classes)));   // Check our array

		if ( $success )
		{
			// This row PASSES all checks so should be stored.
			$spell_list[] = $data[$i];
		}

	}

	if ( !$spell_list )
	{
		$new_spell = $lang['Adr_spell_not_learned'] ;
	}
	else
	{

		// Now roll for spell
		$rand_spell = $spell_list[array_rand($spell_list, 1)];

		$item_type_use = $rand_spell['item_type_use'];
		$item_name = addslashes($rand_spell['spell_name']);
		$item_desc = addslashes($rand_spell['spell_desc']);
		$item_icon = trim($rand_spell['spell_icon']);
		$item_power = $rand_spell['spell_power'];
		$item_add_power = $rand_spell['spell_add_power'];
		$item_mp_use = $rand_spell['spell_mp_use'];
		$item_element = $rand_spell['spell_element'];
		$item_element_str_dmg = $rand_spell['spell_element_str_dmg'];
		$item_element_same_dmg = $rand_spell['spell_element_same_dmg'];
		$item_element_weak_dmg = $rand_spell['spell_element_weak_dmg'];
		$item_max_skill = $rand_spell['spell_max_skill'];
		$item_original_id = $rand_spell['spell_id'];

		$sql = "INSERT INTO " . ADR_SHOPS_SPELLS_TABLE . " 
			( spell_id , spell_owner_id , item_type_use , spell_name , spell_desc , spell_icon , spell_power , spell_add_power , spell_mp_use , spell_element , spell_element_str_dmg , spell_element_same_dmg , spell_element_weak_dmg , spell_max_skill , spell_original_id)
			VALUES ( $new_item_id , $user_id , $item_type_use , '$item_name' , '$item_desc' , '" . str_replace("\'", "''", $item_icon) . "' , $item_power , $item_add_power , $item_mp_use , $item_element , $item_element_str_dmg , $item_element_same_dmg , $item_element_weak_dmg , $item_max_skill , $item_original_id)";
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
		}

		$new_spell = sprintf($lang['Adr_spell_learned'], $item_name);
	}

	$message = sprintf($lang['Adr_level_up_congrats'] , $new_level, $new_spell);
	$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;

	message_die(GENERAL_MESSAGE, $message);
}

?>
