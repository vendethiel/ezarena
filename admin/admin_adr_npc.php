<?php
/***************************************************************************
*                               admin_adr_npc.php
*                              -------------------
*     begin                : 25/05/2005
*     copyright            : Dedo
*
*
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
define('IN_PHPBB', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_ZONES_ADMIN', 1);
define('IN_ADR_NPC_ADMIN', 1);
define('IN_ADR_SHOPS', 1);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_USERS', true);
define('IN_ADR_BATTLE', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ADR-Zones']['NPC'] = $filename;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);


if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = "";
}

// WYSIWYG IMAGE VIEWER
$xxx_images = get_images("adr/images/zones/npc");
$filename_list = get_filenames($xxx_images);

if( isset($HTTP_POST_VARS['add']) || isset($HTTP_GET_VARS['add']) )
{

	adr_template_file('admin/config_adr_npc_edit_body.tpl');

	$template->assign_block_vars( 'npc_add', array());

	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	//
	//BEGIN lists
	//

	//destinations lists
	$zone_list = '<select name="npc_zone[]" size="4" multiple>';
	$zone_list .= '<option value="0" SELECTED class="post">'. $lang['Adr_zone_acp_zones_all'] .'</option>';

	$sql = "SELECT * FROM " . ADR_ZONES_TABLE ."
			ORDER BY zone_id ASC";
	if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	while( $row = $db->sql_fetchrow($result) )
		$zone_list .= '<option value="' . $row['zone_id'] . '" class="post">' . $row['zone_id'] . '-' . $row['zone_name'] . '</option>';

	$zone_list .= '</select>';

	//items list
  	$sql = "SELECT * FROM ". ADR_SHOPS_ITEMS_TABLE ."
       		WHERE item_owner_id = '1'
			ORDER BY item_name ASC";
   	if (!$result = $db->sql_query($sql))
     	message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $sql);

   	$itemlist = $db->sql_fetchrowset($result);

	$item_list = '<select name="npc_item[]" size="4" multiple>';
	$item_list .= '<option value="0" SELECTED class="post">' . $lang['Adr_zone_acp_item_nothing'] . '</option>';
   	for ($i = 0; $i < count($itemlist); $i++)
     	$item_list .= '<option value = "'. $itemlist[$i]['item_name'] .'" class="post">' . adr_get_lang($itemlist[$i]['item_name']) . '</option>';
   	$item_list .= '</select>';

	$item2_list = '<select name="npc_item2[]" size="4" multiple>';
	$item2_list .= '<option value="0" SELECTED class="post">' . $lang['Adr_zone_acp_item_nothing'] . '</option>';
   	for ($i = 0; $i < count($itemlist); $i++)
     	$item2_list .= '<option value = "'. $itemlist[$i]['item_name'] .'" class="post">' . adr_get_lang($itemlist[$i]['item_name']) . '</option>';
   	$item2_list .= '</select>';

	//monster list
	$sql = "SELECT * FROM " . ADR_BATTLE_MONSTERS_TABLE ."
		ORDER BY monster_name ASC";
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, 'Could not obtain zones information', "", __LINE__, __FILE__, $sql);

	$monsterlist = $db->sql_fetchrowset($result);

	$monster_list = '<select name="npc_monster" size="4">';
	$monster_list .= '<option value = "" >' . $lang['Adr_zone_acp_choose_quest_kill_monster'] . '</option>';
	for ( $i = 0 ; $i < count($monsterlist) ; $i ++)
	  	$monster_list .= '<option value = "' . $monsterlist[$i]['monster_name'] . '" >' . $monsterlist[$i]['monster_name'] . ' - ' . $lang['Adr_zones_monster_level'] . ' ' . $monsterlist[$i]['monster_level'] . '</option>';
	$monster_list .= '</select>';

	//user level list
	$level[0] = $lang['Adr_zone_acp_level_all'];
	$level[1] = $lang['Adr_zone_acp_level_admin'];
	$level[2] = $lang['Adr_zone_acp_level_mod'];

	$user_level_list = '<select name="user_level">';
    $user_level_list .= '<option value = "0" SELECTED class="post">' . $level[0] . '</option>';
	for( $i = 1; $i < 3; $i++ )
		$user_level_list .= '<option value = "'.$i.'" class="post">' . $level[$i] . '</option>';
	$user_level_list .= '</select>';

	//class list
	$sql = "SELECT *
			FROM " . ADR_CLASSES_TABLE;
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, 'Could not obtain classes information', "", __LINE__, __FILE__, $sql);
	$classes = $db->sql_fetchrowset($result);

	$class_list = '<select name="class[]" size="4" multiple>';
	$class_list .= '<option value = "0" SELECTED class="post">' . $lang['Adr_classes_all'] . '</option>';
	for( $i = 0; $i < count($classes); $i++ )
		$class_list .= '<option value = "' . $classes[$i]['class_id'] . '" class="post">' . adr_get_lang($classes[$i]['class_name']) . '</option>';
	$class_list .= '</select>';

	//race list
	$sql = "SELECT *
			FROM " . ADR_RACES_TABLE ;
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, 'Could not obtain races information', "", __LINE__, __FILE__, $sql);
	$races = $db->sql_fetchrowset($result);

	$race_list = '<select name="race[]" size="4" multiple>';
	$race_list .= '<option value = "0" SELECTED class="post">' . $lang['Adr_races_all'] . '</option>';
	for($i = 0; $i < count($races); $i++)
		$race_list .= '<option value = "' . $races[$i]['race_id'] . '" class="post">' . adr_get_lang($races[$i]['race_name']) . '</option>';
	$race_list .= '</select>';

	//character level list
	$sql = "SELECT *
			FROM " . ADR_CHARACTERS_TABLE . "
			ORDER BY character_level DESC
			LIMIT 1";
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, 'Could not obtain races information', "", __LINE__, __FILE__, $sql);
	$characters = $db->sql_fetchrowset($result);

	$character_level_list = '<select name="character_level[]" size="4" multiple>';
	$character_level_list .= '<option value = "0" SELECTED class="post">' . $lang['Adr_levels_all'] . '</option>';
	$character_level_limit = ( $characters[0]['character_level'] > 49 ) ? $characters[0]['character_level'] + 50 : 100;
	for( $i = 1; $i < $character_level_limit; $i++ )
		$character_level_list .= '<option value = "' . $i . '" class="post">' . $i . '</option>';
	$character_level_list .= '</select>';

	//element list
	$sql = "SELECT *
			FROM " . ADR_ELEMENTS_TABLE ;
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);
	$elements = $db->sql_fetchrowset($result);

	$element_list = '<select name="element[]" size="4" multiple>';
	$element_list .= '<option value = "0" SELECTED class="post">' . $lang['Adr_elements_all'] . '</option>';
	for($i = 1; $i < count($elements); $i++)
		$element_list .= '<option value = "'.$elements[$i]['element_id'].'" class="post">' . adr_get_lang($elements[$i]['element_name']) . '</option>';
	$element_list .= '</select>';

	//allignment list
	$sql = "SELECT *
			FROM " . ADR_ALIGNMENTS_TABLE;
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, 'Could not obtain alignments information', "", __LINE__, __FILE__, $sql);
	$alignments = $db->sql_fetchrowset($result);

	$alignment_list = '<select name="alignment[]" size="4" multiple>';
	$alignment_list .= '<option value = "0" SELECTED class="post">' . $lang['Adr_alignments_all'] . '</option>';
	for($i = 0; $i < count($alignments); $i++)
		$alignment_list .= '<option value = "'.$alignments[$i]['alignment_id'].'" class="post">' . adr_get_lang($alignments[$i]['alignment_name']) . '</option>';
	$alignment_list .= '</select>';

	//NPC Prerequisite lists
	$sql = "SELECT * FROM ". ADR_NPC_TABLE . "
			ORDER BY npc_id ASC";
	if (!$result = $db->sql_query($sql))
		message_die(GENERAL_ERROR, 'Could not obtain NPC information', "", __LINE__, __FILE__, $sql);

	$npclist = $db->sql_fetchrowset($result);

	$npc_list = '<select name="npc_visit[]" size="4" multiple>';
	$npc_list .= '<option value="0" SELECTED class="post">' . $lang['Adr_npc_no_npc_requirement'] . '</option>';
	for ($i = 0; $i < count($npclist); $i++)
		$npc_list .= '<option value = "'. $npclist[$i]['npc_id'] .'" class="post">' . $npclist[$i]['npc_id'] . '-' . $npclist[$i]['npc_name'] . '</option>';
	$npc_list .= '</select>';

	$npc_list2 = '<select name="npc_quest[]" size="4" multiple>';
	$npc_list2 .= '<option value="0" SELECTED class="post">' . $lang['Adr_npc_no_npc_requirement'] . '</option>';
	for ($i = 0; $i < count($npclist); $i++)
		if ( $npclist[$i]['npc_item'] != '0' )
			$npc_list2 .= '<option value = "'. $npclist[$i]['npc_id'] .'" class="post">' . $npclist[$i]['npc_id'] . '-' . $npclist[$i]['npc_name'] . '</option>';
	$npc_list2 .= '</select>';

	//
	//END lists
	//

	$template->assign_vars(array(
		"NPC_ZONA" => $zone_list,
		"NPC_ITEM" => $item_list,
		"NPC_ITEM2" => $item2_list,
		"NPC_MONSTER" => $monster_list,
		"NPC_USER_LEVEL" => $user_level_list,
		"NPC_CLASS" => $class_list,
		"NPC_RACE" => $race_list,
		"NPC_CHARACTER_LEVEL" => $character_level_list,
		"NPC_ELEMENT" => $element_list,
		"NPC_ALIGNMENT" => $alignment_list,
		"NPC_VISIT" => $npc_list,
		"NPC_QUEST" => $npc_list2,
		"NPC_COST" => 0,
		"NPC_POINTS" => 0,
		"NPC_EXP" => 0,
		"NPC_SP" => 0,
		"NPC_TIMES" => 0,
		"NPC_RANDOM" => 0,
		"NPC_RANDOM_CHANCE" => 1,
		"NPC_VIEW" => 0,
		"NPC_QUEST_HIDE" => 0,
		"NPC_QUEST_CLUE" => 0,
		"NPC_QUEST_CLUE_PRICE" => 0,
		"L_NPC_TITLE" => $lang['Adr_Npc_acp_title'],
		"L_NPC_EXPLAIN" => $lang['Adr_Npc_acp_title_explain'],
		"L_NPC_SETTINGS" => $lang['Adr_Npc_acp_settings'],
		"L_NPC_ENABLE" => $lang['Adr_Npc_acp_npc_enable'],
		"L_NPC_ENABLE_EXPLAIN" => $lang['Adr_Npc_acp_npc_enable_explain'],
		"L_NPC_COST" => $lang['Adr_Npc_acp_npc_cost'],
		"L_NPC_COST_EXPLAIN" => $lang['Adr_Npc_acp_npc_cost_explain'],
		"L_NPC_NAME" => $lang['Adr_Npc_acp_npc_name'],
		"L_NPC_NAME_EXPLAIN" => $lang['Adr_Npc_acp_npc_name_explain'],
		"L_NPC_IMG" => $lang['Adr_Npc_acp_npc_img'],
		"L_NPC_IMG_EXPLAIN" => $lang['Adr_Npc_acp_npc_img_explain'],
		"L_NPC_MESSAGE" => $lang['Adr_Npc_acp_npc_message'],
		"L_NPC_MESSAGE_EXPLAIN" => $lang['Adr_Npc_acp_npc_message_explain'],
		"L_NPC_ZONE_NAME" => $lang['Adr_Npc_acp_zone_name'],
		"L_NPC_ZONE_NAME_EXPLAIN" => $lang['Adr_Npc_acp_zone_name_explain'],
		"L_NPC_QUEST_TITLE" => $lang['Adr_Npc_acp_quest'],
		"L_NPC_QUEST_KILL_TITLE" => $lang['Adr_Npc_acp_quest_kill'],
		"L_NPC_ITEM_NAME" => $lang['Adr_Npc_acp_item_name'],
		"L_NPC_ITEM_NAME_EXPLAIN" => $lang['Adr_Npc_acp_item_name_explain'],
		"L_NPC_QUEST_MONSTERKILL_NAME" => $lang['Adr_Npc_acp_quest_monsterkill_name'],
		"L_NPC_QUEST_MONSTERKILL_AMOUNT" => $lang['Adr_Npc_acp_quest_monsterkill_amount'],
		"L_NPC_QUEST_MONSTERKILL_EXPLAIN" => $lang['Adr_Npc_acp_quest_monsterkill_explain'],
		"L_NPC_QUEST_MONSTERAMOUNT_EXPLAIN" => $lang['Adr_Npc_acp_quest_monsteramount_explain'],
		"L_NPC_MESSAGE2" => $lang['Adr_Npc_acp_npc_message2'],
		"L_NPC_MESSAGE2_EXPLAIN" => $lang['Adr_Npc_acp_npc_message2_explain'],
		"L_NPC_MESSAGE3" => $lang['Adr_Npc_acp_npc_message3'],
		"L_NPC_MESSAGE3_EXPLAIN" => $lang['Adr_Npc_acp_npc_message3_explain'],
		"L_NPC_POINTS" => $lang['Adr_Npc_acp_npc_points'],
		"L_NPC_POINTS_EXPLAIN" => $lang['Adr_Npc_acp_npc_points_explain'],
		"L_NPC_EXP" => $lang['Adr_Npc_acp_npc_exp'],
		"L_NPC_EXP_EXPLAIN" => $lang['Adr_Npc_acp_npc_exp_explain'],
		"L_NPC_SP" => $lang['Adr_Npc_acp_npc_sp'],
		"L_NPC_SP_EXPLAIN" => $lang['Adr_Npc_acp_npc_sp_explain'],
		"L_NPC_ITEM2_NAME" => $lang['Adr_Npc_acp_item2_name'],
		"L_NPC_ITEM2_NAME_EXPLAIN" => $lang['Adr_Npc_acp_item2_name_explain'],
		"L_NPC_TIMES" => $lang['Adr_Npc_acp_times_name'],
		"L_NPC_TIMES_EXPLAIN" => $lang['Adr_Npc_acp_times_name_explain'],
		"L_NPC_RANDOM" => $lang['Adr_Npc_acp_npc_random'],
		"L_NPC_RANDOM_EXPLAIN" => $lang['Adr_Npc_acp_npc_random_explain'],
		"L_NPC_RANDOM_CHANCE" => $lang['Adr_Npc_acp_npc_random_chance'],
		"L_NPC_RANDOM_CHANCE_EXPLAIN" => $lang['Adr_Npc_acp_npc_random_chance_explain'],
		"L_NPC_USER_LEVEL" => $lang['Adr_Npc_acp_npc_user_level'],
		"L_NPC_USER_LEVEL_EXPLAIN" => $lang['Adr_Npc_acp_npc_user_level_explain'],
		"L_NPC_CLASS" => $lang['Adr_Npc_acp_npc_class'],
		"L_NPC_CLASS_EXPLAIN" => $lang['Adr_Npc_acp_npc_class_explain'],
		"L_NPC_RACE" => $lang['Adr_Npc_acp_npc_race'],
		"L_NPC_RACE_EXPLAIN" => $lang['Adr_Npc_acp_npc_race_explain'],
		"L_NPC_CHARACTER_LEVEL" => $lang['Adr_Npc_acp_npc_character_level'],
		"L_NPC_CHARACTER_LEVEL_EXPLAIN" => $lang['Adr_Npc_acp_npc_character_level_explain'],
		"L_NPC_ELEMENT" => $lang['Adr_Npc_acp_npc_element'],
		"L_NPC_ELEMENT_EXPLAIN" => $lang['Adr_Npc_acp_npc_element_explain'],
		"L_NPC_ALIGNMENT" => $lang['Adr_Npc_acp_npc_alignment'],
		"L_NPC_ALIGNMENT_EXPLAIN" => $lang['Adr_Npc_acp_npc_alignment_explain'],
		"L_NPC_VISIT" => $lang['Adr_Npc_acp_npc_visit'],
		"L_NPC_VISIT_EXPLAIN" => $lang['Adr_Npc_acp_npc_visit_explain'],
		"L_NPC_QUEST" => $lang['Adr_Npc_acp_npc_quest'],
		"L_NPC_QUEST_EXPLAIN" => $lang['Adr_Npc_acp_npc_quest_explain'],
		"L_NPC_VIEW" => $lang['Adr_Npc_acp_npc_view'],
		"L_NPC_VIEW_EXPLAIN" => $lang['Adr_Npc_acp_npc_view_explain'],
		"L_NPC_QUEST_HIDE" => $lang['Adr_Npc_acp_npc_quest_hide'],
		"L_NPC_QUEST_HIDE_EXPLAIN" => $lang['Adr_Npc_acp_npc_quest_hide_explain'],
		"L_NPC_QUEST_CLUE" => $lang['Adr_Npc_acp_npc_quest_clue'],
		"L_NPC_QUEST_CLUE_EXPLAIN" => $lang['Adr_Npc_acp_npc_quest_clue_explain'],
		"L_NPC_QUEST_CLUE_PRICE" => $lang['Adr_Npc_acp_npc_quest_clue_price'],
		"L_NPC_QUEST_CLUE_PRICE_EXPLAIN" => $lang['Adr_Npc_acp_npc_quest_clue_price_explain'],
		"L_SUBMIT" => $lang['Submit'],
		"S_HIDDEN_FIELDS" => $s_hidden_fields,
		// WYSIWYG IMAGE VIEWER
		"S_FILENAME_OPTIONS" => $filename_list,
		"NPC_IMG2" => $phpbb_root_path . 'adr/images/zones/npc/' . $xxx_images[0],
		"NPC_DEF" => $xxx_images[0],
		"S_NPC_BASEDIR" => $phpbb_root_path . 'adr/images/zones/npc',
		"S_NPC_ACTION" => append_sid("admin_adr_npc.$phpEx"))
	);

	$template->pparse("body");
}
else if ( $mode != "" )
{
	switch( $mode )
	{
		case 'delete':

			$npc_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			$sql = "DELETE FROM " . ADR_NPC_TABLE . "
					WHERE npc_id = '$npc_id' ";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, "Couldn't delete npc", "", __LINE__, __FILE__, $sql);

			adr_previous( Adr_npc_successful_deleted , admin_adr_npc , '' );
			break;

		case 'edit':

			$npc_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			adr_template_file('admin/config_adr_npc_edit_body.tpl');

			$template->assign_block_vars( 'npc_edit', array());

			$sql = "SELECT * FROM " . ADR_NPC_TABLE ."
					WHERE npc_id = '$npc_id' ";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain npc information', "", __LINE__, __FILE__, $sql);

			$npc = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="npc_id" value="' . $npc['npc_id'] . '" />';

			//
			//BEGIN lists
			//

			//zone lists
			$zone_selected_array = explode( ',' , $npc['npc_zone'] );
			$zone_list = '<select name="npc_zone[]" size="4" multiple>';
   			$zone_list .= ( $zone_selected_array[0] == '0' ) ? '<option value="0" selected="selected" class="post">'. $lang['Adr_zone_acp_zones_all'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_zone_acp_zones_all'] .'</option>';

			$sql = "SELECT zone_id, zone_name FROM " . ADR_ZONES_TABLE . "
					ORDER BY zone_id ASC";
			if( !($result = $db->sql_query($sql)) )
        		message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

			while( $row = $db->sql_fetchrow($result) )
			{
				if ( in_array( $row['zone_id'] , $zone_selected_array ) )
					$zone_list .= '<option value="' . $row['zone_id'] . '" SELECTED class="post">' . $row['zone_id'] . '-' . $row['zone_name'] . '</option>';
				else
					$zone_list .= '<option value="' . $row['zone_id'] . '" class="post">' . $row['zone_id'] . '-' . $row['zone_name'] . '</option>';
			}

			$zone_list .= '</select>';

			//items list
			$item1_selected_array = explode( ',' , $npc['npc_item'] );
			$item2_selected_array = explode( ',' , $npc['npc_item2'] );
			
  			$sql = "SELECT * FROM ". ADR_SHOPS_ITEMS_TABLE ."
       				WHERE item_owner_id = '1'
					ORDER BY item_name ASC";
   			if (!$result = $db->sql_query($sql))
     				message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $sql);

   			$itemlist = $db->sql_fetchrowset($result);

			$item_list = '<select name="npc_item[]" size="4" multiple>';
   			$item_list .= ( $item1_selected_array[0] == '0' ) ? '<option value="0" SELECTED class="post">'. $lang['Adr_zone_acp_item_nothing'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_zone_acp_item_nothing'] .'</option>';
   			for ($i = 0; $i < count($itemlist); $i++)
			{
				if ( in_array( $itemlist[$i]['item_name'] , $item1_selected_array ) )
					$item_list .= '<option value="' . $itemlist[$i]['item_name'] . '" SELECTED class="post">' . adr_get_lang($itemlist[$i]['item_name']) . '</option>';
				else
					$item_list .= '<option value="' . $itemlist[$i]['item_name'] . '" class="post">' . adr_get_lang($itemlist[$i]['item_name']) . '</option>';
			}
   			$item_list .= '</select>';

			$item2_list = '<select name="npc_item2[]" size="4" multiple>';
   			$item2_list .= ( $item2_selected_array[0] == '0' ) ? '<option value="0" SELECTED class="post">'. $lang['Adr_zone_acp_item_nothing'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_zone_acp_item_nothing'] .'</option>';
   			for ($i = 0; $i < count($itemlist); $i++)
			{
				if ( in_array( $itemlist[$i]['item_name'] , $item2_selected_array ) )
					$item2_list .= '<option value="' . $itemlist[$i]['item_name'] . '" SELECTED class="post">' . adr_get_lang($itemlist[$i]['item_name']) . '</option>';
				else
					$item2_list .= '<option value="' . $itemlist[$i]['item_name'] . '" class="post">' . adr_get_lang($itemlist[$i]['item_name']) . '</option>';
			}
   			$item2_list .= '</select>';

			//monster list
			$sql = "SELECT * FROM " . ADR_BATTLE_MONSTERS_TABLE ."
				WHERE '1'
				ORDER BY monster_name ASC";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain monsters information', "", __LINE__, __FILE__, $sql);

			$monsterlist = $db->sql_fetchrowset($result);

			$monster_list = '<select name="npc_monster" size="4">';
			$monster_list .= '<option selected value="0">'. $lang['Adr_zone_acp_choose_quest_kill_monster'] .'</option>';
   			for ($i = 0; $i < count($monsterlist); $i++)
			{
				if ( $monsterlist[$i]['monster_name'] == $npc['npc_kill_monster'] )
				  	$monster_list .= '<option selected value = "' . $monsterlist[$i]['monster_name'] . '" class="post">' . $monsterlist[$i]['monster_name'] . ' - ' . $lang['Adr_zones_monster_level'] . ' ' . $monsterlist[$i]['monster_level'] . '</option>';
				else
				  	$monster_list .= '<option value = "' . $monsterlist[$i]['monster_name'] . '" class="post">' . $monsterlist[$i]['monster_name'] . ' - ' . $lang['Adr_zones_monster_level'] . ' ' . $monsterlist[$i]['monster_level'] . '</option>';
			}
			$monster_list .= '</select>';

			//user level list
			$user_level_selected = $npc['npc_user_level'];
			$level[0] = $lang['Adr_zone_acp_level_all'];
			$level[1] = $lang['Adr_zone_acp_level_admin'];
			$level[2] = $lang['Adr_zone_acp_level_mod'];

			$user_level_list = '<select name="user_level">';
			for( $i = 0; $i < 3; $i++ )
			{
				if ( $user_level_selected == $i )
					$user_level_list .= '<option value = "'.$i.'" SELECTED class="post">' . $level[$i] . '</option>';
	 			else
					$user_level_list .= '<option value = "'.$i.'" class="post">' . $level[$i] . '</option>';
			}
			$user_level_list .= '</select>';

			//class list
			$class_selected_array = explode( ',' , $npc['npc_class'] );
			$sql = "SELECT *
					FROM " . ADR_CLASSES_TABLE;
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain classes information', "", __LINE__, __FILE__, $sql);
			$classes = $db->sql_fetchrowset($result);

			$class_list = '<select name="class[]" size="4" multiple>';
   			$class_list .= ( $class_selected_array[0] == '0' ) ? '<option value="0" SELECTED class="post">'. $lang['Adr_classes_all'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_classes_all'] .'</option>';
			for( $i = 0; $i < count($classes); $i++ )
			{
				if ( in_array( $classes[$i]['class_id'] , $class_selected_array ) )
					$class_list .= '<option value = "' . $classes[$i]['class_id'] . '" SELECTED class="post">' . adr_get_lang($classes[$i]['class_name']) . '</option>';
				else
					$class_list .= '<option value = "' . $classes[$i]['class_id'] . '" class="post">' . adr_get_lang($classes[$i]['class_name']) . '</option>';
			}
			$class_list .= '</select>';

			//race list
			$race_selected_array = explode( ',' , $npc['npc_race'] );
			$sql = "SELECT *
					FROM " . ADR_RACES_TABLE ;
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain races information', "", __LINE__, __FILE__, $sql);
			$races = $db->sql_fetchrowset($result);

			$race_list = '<select name="race[]" size="4" multiple>';
   			$race_list .= ( $race_selected_array[0] == '0' ) ? '<option value="0" SELECTED class="post">'. $lang['Adr_races_all'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_races_all'] .'</option>';
			for($i = 0; $i < count($races); $i++)
			{
				if ( in_array( $races[$i]['race_id'] , $race_selected_array ) )
					$race_list .= '<option value = "' . $races[$i]['race_id'] . '" SELECTED class="post">' . adr_get_lang($races[$i]['race_name']) . '</option>';
				else
					$race_list .= '<option value = "' . $races[$i]['race_id'] . '" class="post">' . adr_get_lang($races[$i]['race_name']) . '</option>';
			}
			$race_list .= '</select>';

			//character level list
			$character_level_selected_array = explode( ',' , $npc['npc_character_level'] );
			$sql = "SELECT *
					FROM " . ADR_CHARACTERS_TABLE . "
					ORDER BY character_level DESC
					LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain races information', "", __LINE__, __FILE__, $sql);
			$characters = $db->sql_fetchrowset($result);

			$character_level_limit = ( $characters[0]['character_level'] > 49 ) ? $characters[0]['character_level'] + 50 : 100;
			$character_level_list = '<select name="character_level[]" size="4" multiple>';
   			$character_level_list .= ( $character_level_selected_array[0] == '0' ) ? '<option value="0" SELECTED class="post">'. $lang['Adr_levels_all'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_levels_all'] .'</option>';
			for( $i = 1; $i < $character_level_limit; $i++ )
			{
				if ( in_array( $i , $character_level_selected_array ) )
					$character_level_list .= '<option value = "' . $i . '" SELECTED class="post">' . $i . '</option>';
				else
					$character_level_list .= '<option value = "' . $i . '" class="post">' . $i . '</option>';
			}
			$character_level_list .= '</select>';

			//element list
			$element_selected_array = explode( ',' , $npc['npc_element'] );
			$sql = "SELECT *
					FROM " . ADR_ELEMENTS_TABLE ;
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);
			$elements = $db->sql_fetchrowset($result);

			$element_list = '<select name="element[]" size="4" multiple>';
   			$element_list .= ( $element_selected_array[0] == '0' ) ? '<option value="0" SELECTED class="post">'. $lang['Adr_elements_all'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_elements_all'] .'</option>';
			for($i = 1; $i < count($elements); $i++)
			{
				if ( in_array( $elements[$i]['element_id'] , $element_selected_array ) )
					$element_list .= '<option value = "' . $elements[$i]['element_id'] . '" SELECTED class="post">' . adr_get_lang($elements[$i]['element_name']) . '</option>';
				else
					$element_list .= '<option value = "' . $elements[$i]['element_id'] . '" class="post">' . adr_get_lang($elements[$i]['element_name']) . '</option>';
			}
			$element_list .= '</select>';

			//allignment list
			$alignment_selected_array = explode( ',' , $npc['npc_alignment'] );
			$sql = "SELECT *
					FROM " . ADR_ALIGNMENTS_TABLE;
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain alignments information', "", __LINE__, __FILE__, $sql);
			$alignments = $db->sql_fetchrowset($result);

			$alignment_list = '<select name="alignment[]" size="4" multiple>';
   			$alignment_list .= ( $alignment_selected_array[0] == '0' ) ? '<option value="0" SELECTED class="post">'. $lang['Adr_alignments_all'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_alignments_all'] .'</option>';
			for($i = 0; $i < count($alignments); $i++)
			{
				if ( in_array( $alignments[$i]['alignment_id'] , $alignment_selected_array ) )
					$alignment_list .= '<option value = "' . $alignments[$i]['alignment_id'] . '" SELECTED class="post">' . adr_get_lang($alignments[$i]['alignment_name']) . '</option>';
				else
					$alignment_list .= '<option value = "' . $alignments[$i]['alignment_id'] . '" class="post">' . adr_get_lang($alignments[$i]['alignment_name']) . '</option>';
			}
			$alignment_list .= '</select>';

			//NPC Prerequisite lists
			$npc_visit_selected_array = explode( ',' , $npc['npc_visit_prerequisite'] );
			$npc_quest_selected_array = explode( ',' , $npc['npc_quest_prerequisite'] );
			
			$sql = "SELECT * FROM ". ADR_NPC_TABLE . "
					ORDER BY npc_id ASC";
			if (!$result = $db->sql_query($sql))
				message_die(GENERAL_ERROR, 'Could not obtain NPC information', "", __LINE__, __FILE__, $sql);

			$npclist = $db->sql_fetchrowset($result);

			$npc_list = '<select name="npc_visit[]" size="4" multiple>';
   			$npc_list .= ( $npc_visit_selected_array[0] == '0' ) ? '<option value="0" SELECTED class="post">'. $lang['Adr_npc_no_npc_requirement'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_npc_no_npc_requirement'] .'</option>';
			for ($i = 0; $i < count($npclist); $i++)
			{
        // V: hide current NPC from prerequisites list
        if ($npclist[$i]['npc_id'] == $npc_id)
          continue;
				if ( in_array( $npclist[$i]['npc_id'] , $npc_visit_selected_array ) )
					$npc_list .= '<option value = "' . $npclist[$i]['npc_id'] . '" SELECTED class="post">' . $npclist[$i]['npc_id'] . '-' . $npclist[$i]['npc_name'] . '</option>';
				else
					$npc_list .= '<option value = "' . $npclist[$i]['npc_id'] . '" class="post">' . $npclist[$i]['npc_id'] . '-' . $npclist[$i]['npc_name'] . '</option>';
			}
			$npc_list .= '</select>';

			$npc_list2 = '<select name="npc_quest[]" size="4" multiple>';
   			$npc_list2 .= ( $npc_quest_selected_array[0] == '0' ) ? '<option value="0" SELECTED class="post">'. $lang['Adr_npc_no_npc_requirement'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_npc_no_npc_requirement'] .'</option>';
			for ($i = 0; $i < count($npclist); $i++)
			{
        // V: hide current NPC from prerequisites list
        if ($npclist[$i]['npc_id'] == $npc_id)
          continue;
				if ( $npclist[$i]['npc_item'] != '0' )
				{
					if ( in_array( $npclist[$i]['npc_id'] , $npc_quest_selected_array ) )
						$npc_list2 .= '<option value = "' . $npclist[$i]['npc_id'] . '" SELECTED class="post">' . $npclist[$i]['npc_id'] . '-' . $npclist[$i]['npc_name'] . '</option>';
					else
						$npc_list2 .= '<option value = "' . $npclist[$i]['npc_id'] . '" class="post">' . $npclist[$i]['npc_id'] . '-' . $npclist[$i]['npc_name'] . '</option>';
				}
			}
			$npc_list2 .= '</select>';

			//
			//END lists
			//

			$template->assign_vars(array(
				"NPC_ENABLE" => ($npc['npc_enable'] ? 'CHECKED' : ''),
				"NPC_NAME" => $npc['npc_name'],
				"NPC_ZONA" => $zone_list,
				"NPC_COST" => $npc['npc_price'],
				"NPC_MSG" => $npc['npc_message'],
				"NPC_MSG_EXPLAIN" => adr_get_lang($npc['npc_message']),
				"NPC_ITEM" => $item_list,
				"NPC_MSG2" => $npc['npc_message2'],
				"NPC_MSG2_EXPLAIN" => adr_get_lang($npc['npc_message2']),
				"NPC_MSG3" => $npc['npc_message3'],
				"NPC_MSG3_EXPLAIN" => adr_get_lang($npc['npc_message3']),
				"NPC_POINTS" => $npc['npc_points'],
				"NPC_EXP" => $npc['npc_exp'],
				"NPC_SP" => $npc['npc_sp'],
				"NPC_ITEM2" => $item2_list,
				"NPC_MONSTER" => $monster_list,
				"NPC_MONSTER_AMOUNT" => $npc['npc_monster_amount'],
				"NPC_TIMES" => $npc['npc_times'],
				"NPC_RANDOM" => ( $npc['npc_random'] ? 'CHECKED' : ''),
				"NPC_RANDOM_CHANCE" => $npc['npc_random_chance'],
				"NPC_VIEW" => ( $npc['npc_view'] ? 'CHECKED' : ''),
				"NPC_USER_LEVEL" => $user_level_list,
				"NPC_CLASS" => $class_list,
				"NPC_RACE" => $race_list,
				"NPC_CHARACTER_LEVEL" => $character_level_list,
				"NPC_ELEMENT" => $element_list,
				"NPC_ALIGNMENT" => $alignment_list,
				"NPC_VISIT" => $npc_list,
				"NPC_QUEST" => $npc_list2,
				"NPC_QUEST_HIDE" => ( $npc['npc_quest_hide'] ? 'CHECKED' : ''),
				"NPC_QUEST_CLUE" => ( $npc['npc_quest_clue'] ? 'CHECKED' : ''),
				"NPC_QUEST_CLUE_PRICE" => $npc['npc_quest_clue_price'],
				"L_NPC_TITLE" => $lang['Adr_Npc_acp_title'],
				"L_NPC_EXPLAIN" => $lang['Adr_Npc_acp_title_explain'],
				"L_NPC_ENABLE" => $lang['Adr_Npc_acp_npc_enable'],
				"L_NPC_ENABLE_EXPLAIN" => $lang['Adr_Npc_acp_npc_enable_explain'],
				"L_NPC_COST" => $lang['Adr_Npc_acp_npc_cost'],
				"L_NPC_COST_EXPLAIN" => $lang['Adr_Npc_acp_npc_cost_explain'],
				"L_NPC_NAME" => $lang['Adr_Npc_acp_npc_name'],
				"L_NPC_NAME_EXPLAIN" => $lang['Adr_Npc_acp_npc_name_explain'],
				"L_NPC_IMG" => $lang['Adr_Npc_acp_npc_img'],
				"L_NPC_IMG_EXPLAIN" => $lang['Adr_Npc_acp_npc_img_explain'],
				"L_NPC_MESSAGE" => $lang['Adr_Npc_acp_npc_message'],
				"L_NPC_MESSAGE_EXPLAIN" => $lang['Adr_Npc_acp_npc_message_explain'],
				"L_NPC_ZONE_NAME" => $lang['Adr_Npc_acp_zone_name'],
				"L_NPC_ZONE_NAME_EXPLAIN" => $lang['Adr_Npc_acp_zone_name_explain'],
				"L_NPC_QUEST_TITLE" => $lang['Adr_Npc_acp_quest'],
				"L_NPC_QUEST_KILL_TITLE" => $lang['Adr_Npc_acp_quest_kill'],
				"L_NPC_ITEM_NAME" => $lang['Adr_Npc_acp_item_name'],
				"L_NPC_ITEM_NAME_EXPLAIN" => $lang['Adr_Npc_acp_item_name_explain'],
				"L_NPC_QUEST_MONSTERKILL_NAME" => $lang['Adr_Npc_acp_quest_monsterkill_name'],
				"L_NPC_QUEST_MONSTERKILL_AMOUNT" => $lang['Adr_Npc_acp_quest_monsterkill_amount'],
				"L_NPC_QUEST_MONSTERKILL_EXPLAIN" => $lang['Adr_Npc_acp_quest_monsterkill_explain'],
				"L_NPC_QUEST_MONSTERAMOUNT_EXPLAIN" => $lang['Adr_Npc_acp_quest_monsteramount_explain'],
				"L_NPC_MESSAGE2" => $lang['Adr_Npc_acp_npc_message2'],
				"L_NPC_MESSAGE2_EXPLAIN" => $lang['Adr_Npc_acp_npc_message2_explain'],
				"L_NPC_MESSAGE3" => $lang['Adr_Npc_acp_npc_message3'],
				"L_NPC_MESSAGE3_EXPLAIN" => $lang['Adr_Npc_acp_npc_message3_explain'],
				"L_NPC_POINTS" => $lang['Adr_Npc_acp_npc_points'],
				"L_NPC_POINTS_EXPLAIN" => $lang['Adr_Npc_acp_npc_points_explain'],
				"L_NPC_EXP" => $lang['Adr_Npc_acp_npc_exp'],
				"L_NPC_EXP_EXPLAIN" => $lang['Adr_Npc_acp_npc_exp_explain'],
				"L_NPC_SP" => $lang['Adr_Npc_acp_npc_sp'],
				"L_NPC_SP_EXPLAIN" => $lang['Adr_Npc_acp_npc_sp_explain'],
				"L_NPC_ITEM2_NAME" => $lang['Adr_Npc_acp_item2_name'],
				"L_NPC_ITEM2_NAME_EXPLAIN" => $lang['Adr_Npc_acp_item2_name_explain'],
				"L_NPC_TIMES" => $lang['Adr_Npc_acp_times_name'],
				"L_NPC_TIMES_EXPLAIN" => $lang['Adr_Npc_acp_times_name_explain'],
				"L_NPC_RANDOM" => $lang['Adr_Npc_acp_npc_random'],
				"L_NPC_RANDOM_EXPLAIN" => $lang['Adr_Npc_acp_npc_random_explain'],
				"L_NPC_RANDOM_CHANCE" => $lang['Adr_Npc_acp_npc_random_chance'],
				"L_NPC_RANDOM_CHANCE_EXPLAIN" => $lang['Adr_Npc_acp_npc_random_chance_explain'],
				"L_NPC_USER_LEVEL" => $lang['Adr_Npc_acp_npc_user_level'],
				"L_NPC_USER_LEVEL_EXPLAIN" => $lang['Adr_Npc_acp_npc_user_level_explain'],
				"L_NPC_CLASS" => $lang['Adr_Npc_acp_npc_class'],
				"L_NPC_CLASS_EXPLAIN" => $lang['Adr_Npc_acp_npc_class_explain'],
				"L_NPC_RACE" => $lang['Adr_Npc_acp_npc_race'],
				"L_NPC_RACE_EXPLAIN" => $lang['Adr_Npc_acp_npc_race_explain'],
				"L_NPC_CHARACTER_LEVEL" => $lang['Adr_Npc_acp_npc_character_level'],
				"L_NPC_CHARACTER_LEVEL_EXPLAIN" => $lang['Adr_Npc_acp_npc_character_level_explain'],
				"L_NPC_ELEMENT" => $lang['Adr_Npc_acp_npc_element'],
				"L_NPC_ELEMENT_EXPLAIN" => $lang['Adr_Npc_acp_npc_element_explain'],
				"L_NPC_ALIGNMENT" => $lang['Adr_Npc_acp_npc_alignment'],
				"L_NPC_ALIGNMENT_EXPLAIN" => $lang['Adr_Npc_acp_npc_alignment_explain'],
				"L_NPC_VISIT" => $lang['Adr_Npc_acp_npc_visit'],
				"L_NPC_VISIT_EXPLAIN" => $lang['Adr_Npc_acp_npc_visit_explain'],
				"L_NPC_QUEST" => $lang['Adr_Npc_acp_npc_quest'],
				"L_NPC_QUEST_EXPLAIN" => $lang['Adr_Npc_acp_npc_quest_explain'],
				"L_NPC_VIEW" => $lang['Adr_Npc_acp_npc_view'],
				"L_NPC_VIEW_EXPLAIN" => $lang['Adr_Npc_acp_npc_view_explain'],
				"L_NPC_QUEST_HIDE" => $lang['Adr_Npc_acp_npc_quest_hide'],
				"L_NPC_QUEST_HIDE_EXPLAIN" => $lang['Adr_Npc_acp_npc_quest_hide_explain'],
				"L_NPC_QUEST_CLUE" => $lang['Adr_Npc_acp_npc_quest_clue'],
				"L_NPC_QUEST_CLUE_EXPLAIN" => $lang['Adr_Npc_acp_npc_quest_clue_explain'],
				"L_NPC_QUEST_CLUE_PRICE" => $lang['Adr_Npc_acp_npc_quest_clue_price'],
				"L_NPC_QUEST_CLUE_PRICE_EXPLAIN" => $lang['Adr_Npc_acp_npc_quest_clue_price_explain'],
				"L_SUBMIT" => $lang['Submit'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields,
				// WYSIWYG IMAGE VIEWER
				"S_FILENAME_OPTIONS" => $filename_list,
				"NPC_IMG" => $npc['npc_img'],
				"NPC_DEF" => $phpbb_root_path . 'adr/images/zones/npc/' .  $npc['npc_img'],
				"S_NPC_BASEDIR" => $phpbb_root_path . 'adr/images/zones/npc',
				"S_NPC_ACTION" => append_sid("admin_adr_npc.$phpEx"))
			);

			$template->pparse("body");
			break;

		case "save":

			$npc_id = ( !empty($HTTP_POST_VARS['npc_id']) ) ? intval($HTTP_POST_VARS['npc_id']) : intval($HTTP_GET_VARS['npc_id']);
			$zone = $HTTP_POST_VARS['npc_zone'] ? $HTTP_POST_VARS['npc_zone'] : array('0');
			if ( in_array( '0' , $zone ) )
			    $npc_zone = '0';
			else
				$npc_zone = implode(',' , $HTTP_POST_VARS['npc_zone']);
				
			$npc_enable = intval($HTTP_POST_VARS['npc_enable']);
			$npc_price = ( $HTTP_POST_VARS['npc_price']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_price']);
			$npc_name = ( isset($HTTP_POST_VARS['npc_name']) ) ? trim($HTTP_POST_VARS['npc_name']) : trim($HTTP_GET_VARS['npc_name']);
			$npc_img = ( isset($HTTP_POST_VARS['npc_img']) ) ? trim($HTTP_POST_VARS['npc_img']) : trim($HTTP_GET_VARS['npc_img']);
			$npc_msg = ( isset($HTTP_POST_VARS['npc_message']) ) ? trim($HTTP_POST_VARS['npc_message']) : trim($HTTP_GET_VARS['npc_message']);
			$npc_item = implode(',' , $HTTP_POST_VARS['npc_item']);
			$npc_msg2 = ( isset($HTTP_POST_VARS['npc_message2']) ) ? trim($HTTP_POST_VARS['npc_message2']) : trim($HTTP_GET_VARS['npc_message2']);
			$npc_msg3 = ( isset($HTTP_POST_VARS['npc_message3']) ) ? trim($HTTP_POST_VARS['npc_message3']) : trim($HTTP_GET_VARS['npc_message3']);
			$npc_view = ( $HTTP_POST_VARS['npc_view']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_view']);
			$npc_points = ( $HTTP_POST_VARS['npc_points']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_points']);
			$npc_exp = ( $HTTP_POST_VARS['npc_exp']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_exp']);
			$npc_sp = ( $HTTP_POST_VARS['npc_sp']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_sp']);
			$npc_item2 = implode(',' , $HTTP_POST_VARS['npc_item2']);
			$npc_times = ( $HTTP_POST_VARS['npc_times']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_times']);
			$npc_random = ( $HTTP_POST_VARS['npc_random']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_random']);
			$npc_random_chance = ( $HTTP_POST_VARS['npc_random_chance']=='' ) ? '1' : intval($HTTP_POST_VARS['npc_random_chance']);
			$npc_user_level = ( $HTTP_POST_VARS['user_level']=='' ) ? '0' : intval($HTTP_POST_VARS['user_level']);
			$npc_quest_hide = intval($HTTP_POST_VARS['npc_quest_hide']);
			$npc_quest_clue = intval($HTTP_POST_VARS['npc_quest_clue']);
			$npc_quest_clue_price = intval($HTTP_POST_VARS['npc_quest_clue_price']);

			$monster = $npc['npc_kill_monster'];
			$npc_monster = ( isset($HTTP_POST_VARS['npc_monster']) ) ? trim($HTTP_POST_VARS['npc_monster']) : trim($HTTP_GET_VARS['npc_monster']);
			$npc_monster_amount = ( $HTTP_POST_VARS['npc_monster_amount']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_monster_amount']);

			if ( in_array( '0' , $HTTP_POST_VARS['class'] ) )
			    $npc_class = '0';
			else
				$npc_class = implode(',' , $HTTP_POST_VARS['class']);

			if ( in_array( '0' , $HTTP_POST_VARS['race'] ) )
			    $npc_race = '0';
			else
				$npc_race = implode(',' , $HTTP_POST_VARS['race']);

			if ( in_array( '0' , $HTTP_POST_VARS['character_level'] ) )
			    $npc_character_level = '0';
			else
				$npc_character_level = implode(',' , $HTTP_POST_VARS['character_level']);

			if ( in_array( '0' , $HTTP_POST_VARS['element'] ) )
			    $npc_element = '0';
			else
				$npc_element = implode(',' , $HTTP_POST_VARS['element']);

			if ( in_array( '0' , $HTTP_POST_VARS['alignment'] ) )
			    $npc_alignment = '0';
			else
				$npc_alignment = implode(',' , $HTTP_POST_VARS['alignment']);

			if ( in_array( '0' , $HTTP_POST_VARS['npc_visit'] ) )
			    $npc_visit = '0';
			else
				$npc_visit = implode(',' , $HTTP_POST_VARS['npc_visit']);

			if ( in_array( '0' , $HTTP_POST_VARS['npc_quest'] ) )
			    $npc_quest = '0';
			else
				$npc_quest = implode(',' , $HTTP_POST_VARS['npc_quest']);

			if ( $npc_enable && ( $npc_name == "" || $npc_img == ""  || $npc_msg == "" ) )
				adr_previous( Npc_Fields_empty , admin_adr_npc , '' );
			
			if ( ( $npc_item != "0" && $npc_quest_clue ) && $npc_item != "" && $npc_msg2 == "" )
				adr_previous( Npc_quest_Fields_empty , admin_adr_npc , '' );

			if ( $npc_quest_clue && $npc_item != "0" )
			    $npc_item = "0";

			$sql = "UPDATE " . ADR_NPC_TABLE . "
				SET npc_zone = '" . str_replace("\'", "''", $npc_zone) . "',
					npc_kill_monster = '$npc_monster',
					npc_monster_amount = '$npc_monster_amount',
					npc_name = '" . str_replace("\'", "''", $npc_name) . "',
					npc_img = '" . str_replace("\'", "''", $npc_img) . "',
					npc_enable = '$npc_enable',
					npc_price =  '$npc_price',
					npc_message = '" . str_replace("\'", "''", $npc_msg) . "',
					npc_item = '" . str_replace("\'", "''", $npc_item) . "',
					npc_message2 = '" . str_replace("\'", "''", $npc_msg2) . "',
					npc_message3 = '" . str_replace("\'", "''", $npc_msg3) . "',
					npc_points = '$npc_points',
					npc_exp =  '$npc_exp',
					npc_sp =  '$npc_sp',
					npc_item2 = '" . str_replace("\'", "''", $npc_item2) . "',
					npc_times =  '$npc_times',
					npc_random = '$npc_random',
					npc_random_chance = '$npc_random_chance',
					npc_user_level = '$npc_user_level',
					npc_class = '$npc_class',
					npc_race = '$npc_race',
					npc_character_level = '$npc_character_level',
					npc_element = '$npc_element',
					npc_alignment = '$npc_alignment',
					npc_visit_prerequisite = '$npc_visit',
					npc_quest_prerequisite = '$npc_quest',
					npc_view = '$npc_view',
					npc_quest_hide = '$npc_quest_hide',
					npc_quest_clue = '$npc_quest_clue',
					npc_quest_clue_price = '$npc_quest_clue_price'
				WHERE npc_id = '$npc_id'";
			if( !($result = $db->sql_query($sql)) )
				message_die(GENERAL_ERROR, "Couldn't update npc info", "", __LINE__, __FILE__, $sql);

			adr_previous( Adr_Npc_edit_success , admin_adr_npc , '' );
			break;

		case "savenew":

			if ( in_array( '0' , $HTTP_POST_VARS['npc_zone'] ) || $HTTP_POST_VARS['npc_zone'] == '' )
			    $npc_zone = '0';
			else
				$npc_zone = implode(',' , $HTTP_POST_VARS['npc_zone']);
			$npc_enable = intval($HTTP_POST_VARS['npc_enable']);
			$npc_price = ($HTTP_POST_VARS['npc_price']=='') ? '0' : intval($HTTP_POST_VARS['npc_price']);
			$npc_name = ( isset($HTTP_POST_VARS['npc_name']) ) ? trim($HTTP_POST_VARS['npc_name']) : trim($HTTP_GET_VARS['npc_name']);
			$npc_img = ( isset($HTTP_POST_VARS['npc_img']) ) ? trim($HTTP_POST_VARS['npc_img']) : trim($HTTP_GET_VARS['npc_img']);
			$npc_msg = ( isset($HTTP_POST_VARS['npc_message']) ) ? trim($HTTP_POST_VARS['npc_message']) : trim($HTTP_GET_VARS['npc_message']);
			$npc_item = implode(',' , $HTTP_POST_VARS['npc_item']);
			$npc_msg2 = ( isset($HTTP_POST_VARS['npc_message2']) ) ? trim($HTTP_POST_VARS['npc_message2']) : trim($HTTP_GET_VARS['npc_message2']);
			$npc_msg3 = ( isset($HTTP_POST_VARS['npc_message3']) ) ? trim($HTTP_POST_VARS['npc_message3']) : trim($HTTP_GET_VARS['npc_message3']);
			$npc_view = ( $HTTP_POST_VARS['npc_view']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_view']);
			$npc_points = ( $HTTP_POST_VARS['npc_points']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_points']);
			$npc_exp = ( $HTTP_POST_VARS['npc_exp']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_exp']);
			$npc_sp = ( $HTTP_POST_VARS['npc_sp']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_sp']);
			$npc_item2 = implode(',' , $HTTP_POST_VARS['npc_item2']);
			$npc_times = ( $HTTP_POST_VARS['npc_times']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_times']);
			$npc_random = ( $HTTP_POST_VARS['npc_random']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_random']);
			$npc_random_chance = ( $HTTP_POST_VARS['npc_random_chance']=='' ) ? '1' : intval($HTTP_POST_VARS['npc_random_chance']);
			$npc_user_level = ( $HTTP_POST_VARS['user_level']=='' ) ? '0' : intval($HTTP_POST_VARS['user_level']);
			$npc_quest_hide = intval($HTTP_POST_VARS['npc_quest_hide']);
			$npc_quest_clue = intval($HTTP_POST_VARS['npc_quest_clue']);
			$npc_quest_clue_price = intval($HTTP_POST_VARS['npc_quest_clue_price']);

			$npc_monster = ( isset($HTTP_POST_VARS['npc_monster']) ) ? trim($HTTP_POST_VARS['npc_monster']) : trim($HTTP_GET_VARS['npc_monster']);
			$npc_monster_amount = ( $HTTP_POST_VARS['npc_monster_amount']=='' ) ? '0' : intval($HTTP_POST_VARS['npc_monster_amount']);

			if ( in_array( '0' , $HTTP_POST_VARS['class'] ) )
			    $npc_class = '0';
			else
				$npc_class = implode(',' , $HTTP_POST_VARS['class']);
			if ( in_array( '0' , $HTTP_POST_VARS['race'] ) )
			    $npc_race = '0';
			else
				$npc_race = implode(',' , $HTTP_POST_VARS['race']);
			if ( in_array( '0' , $HTTP_POST_VARS['character_level'] ) )
			    $npc_character_level = '0';
			else
				$npc_character_level = implode(',' , $HTTP_POST_VARS['character_level']);
			if ( in_array( '0' , $HTTP_POST_VARS['element'] ) )
			    $npc_element = '0';
			else
				$npc_element = implode(',' , $HTTP_POST_VARS['element']);
			if ( in_array( '0' , $HTTP_POST_VARS['alignment'] ) )
			    $npc_alignment = '0';
			else
				$npc_alignment = implode(',' , $HTTP_POST_VARS['alignment']);
			if ( in_array( '0' , $HTTP_POST_VARS['npc_visit'] ) )
			    $npc_visit = '0';
			else
				$npc_visit = implode(',' , $HTTP_POST_VARS['npc_visit']);
			if ( in_array( '0' , $HTTP_POST_VARS['npc_quest'] ) )
			    $npc_quest = '0';
			else
				$npc_quest = implode(',' , $HTTP_POST_VARS['npc_quest']);

			if ( $npc_enable && ( $npc_name == "" || $npc_img == ""  || $npc_msg == "" ) )
				adr_previous( Npc_Fields_empty , admin_adr_npc , '' );
			if ( ( $npc_item != "0" && $npc_quest_clue ) && $npc_item != "" && $npc_msg2 == "" )
				adr_previous( Npc_quest_Fields_empty , admin_adr_npc , '' );
			if ( $npc_quest_clue && $npc_item != "0" )
			    $npc_item = "0";

			$sql = "INSERT INTO " . ADR_NPC_TABLE . "
					( npc_id , npc_zone , npc_name , npc_img , npc_enable , npc_price , npc_message , npc_item , npc_message2 , npc_message3 , npc_points , npc_exp , npc_sp , npc_item2 , npc_times , npc_random , npc_random_chance , npc_user_level , npc_class , npc_race , npc_character_level , npc_element , npc_alignment , npc_visit_prerequisite , npc_quest_prerequisite , npc_view , npc_quest_hide , npc_quest_clue , npc_quest_clue_price, npc_kill_monster, npc_monster_amount )
					VALUES ( '' , '" . str_replace("\'", "''", $npc_zone) . "' , '" . str_replace("\'", "''", $npc_name) . "', '" . str_replace("\'", "''", $npc_img) . "' , '$npc_enable' , '$npc_price' , '" . str_replace("\'", "''", $npc_msg) . "' , '" . str_replace("\'", "''", $npc_item) . "' , '" . str_replace("\'", "''", $npc_msg2) . "' , '" . str_replace("\'", "''", $npc_msg3) . "' , '$npc_points' , '$npc_exp' , '$npc_sp' , '" . str_replace("\'", "''", $npc_item2) . "' , '$npc_times' , '$npc_random' , '$npc_random_chance' , '$npc_user_level' , '$npc_class' , '$npc_race' , '$npc_character_level' , '$npc_element' , '$npc_alignment' , '$npc_visit' , '$npc_quest' , '$npc_view' , '$npc_quest_hide' , '$npc_quest_clue' , '$npc_quest_clue_price', '$npc_monster', '$npc_monster_amount' )";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, "Couldn't insert new npc", "", __LINE__, __FILE__, $sql);

			adr_previous( Adr_Npc_add_success , admin_adr_npc , '' );
			break;
	}
}
else
{

	adr_template_file('admin/config_adr_npc_list_body.tpl');

	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

	if ( isset($HTTP_GET_VARS['mode2']) || isset($HTTP_POST_VARS['mode2']) )
		$mode2 = ( isset($HTTP_POST_VARS['mode2']) ) ? htmlspecialchars($HTTP_POST_VARS['mode2']) : htmlspecialchars($HTTP_GET_VARS['mode2']);
	else
		$mode2 = 'npc_zone';

	if(isset($HTTP_POST_VARS['order']))
		$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
	else if(isset($HTTP_GET_VARS['order']))
		$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
	else
		$sort_order = 'ASC';

	$mode_types_text = array( $lang['Adr_npc_zone_id'] , $lang['Adr_npc_zone_name'] , $lang['Adr_npc_name'] , $lang['Adr_npc_price'] );
	$mode_types = array( 'npc_zone','zone_name', 'npc_name', 'npc_price' );

	$select_sort_mode = '<select name="mode2">';
	for($i = 0; $i < count($mode_types_text); $i++)
	{
		$selected = ( $mode2 == $mode_types[$i] ) ? ' selected="selected"' : '';
		$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
	}
	$select_sort_mode .= '</select>';

	$select_sort_order = '<select name="order">';
	if($sort_order == 'ASC')
		$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
	else
		$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
	$select_sort_order .= '</select>';

	switch( $mode2 )
	{
		case 'npc_name':
			$order_by = "npc_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'npc_price':
			$order_by = "npc_price $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;

		default:
			$order_by = "npc_zone $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
	}

	$sql = "SELECT zone_id, zone_name FROM " . ADR_ZONES_TABLE ."
			ORDER BY zone_id ASC";
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, 'Could not obtain zones information', "", __LINE__, __FILE__, $sql);

	$zone_list = $db->sql_fetchrowset($result);

	$sql = "SELECT * FROM " . ADR_NPC_TABLE . "
			ORDER BY $order_by";
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, 'Could not obtain npc information', "", __LINE__, __FILE__, $sql);

	$npc = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($npc); $i++)
	{
		//Prevent blank value in the list
		$npc_enable = $npc[$i]['npc_enable'];
		$npc_name = ( $npc[$i]['npc_user_level'] == '0' ) ? $npc[$i]['npc_name'] : ( ( $npc[$i]['npc_user_level'] == '1' ) ? '<font color="red"><b>' . $npc[$i]['npc_name'] . '</b></font>' : '<font color="blue"><b>' . $npc[$i]['npc_name'] . '</b></font>' ) ;
		$npc_user_level = ( $npc[$i]['npc_user_level'] == '0' ) ? $lang['Adr_zone_acp_level_all'] : ( ( $npc[$i]['npc_user_level'] == '1' ) ? $lang['Adr_zone_acp_level_admin'] : $lang['Adr_zone_acp_level_admin'] . ' & ' . $lang['Adr_zone_acp_level_mod'] ) ;
		$npc_title = $npc[$i]['npc_name'];
		$npc_price = $npc[$i]['npc_price'];
		$npc_img = $npc[$i]['npc_img'];
		$npc_random = $npc[$i]['npc_random'];
		$npc_zone_array = explode( ',' , $npc[$i]['npc_zone'] );
		$npc_monster = $npc[$i]['npc_kill_monster'];
		$npc_monster_amount = $npc[$i]['npc_monster_amount'];

		$npc_zone = '';
		$y = 0;
		for ( $x = 0 ; $x < count( $zone_list ) ; $x++ )
		{
		    if ( in_array( $zone_list[$x]['zone_id'] , $npc_zone_array ) )
		    {
				if ( $y == 0 )
				{
					$npc_zone .= $zone_list[$x]['zone_id'] . '-' . $zone_list[$x]['zone_name'];
					$y = $y + 1;
				}
				else
				    $npc_zone .= '<br />' . $zone_list[$x]['zone_id'] . '-' . $zone_list[$x]['zone_name'];
			}
			else
			{
				if ( $npc_zone_array[0] == '0' )
				    $npc_zone = $lang['Adr_zone_acp_zones_all'];
			}
		}

		$npc_enable = ( $npc_enable == 0 ) ? '<font color="red"><b>' . $lang["No"] . '</b></font>' : '<font color="green"><b>' . $lang["Yes"] . '</b></font>';
		$npc_random = ( $npc_random == 0 ) ? '<font color="red"><b>' . $lang["No"] . '</b></font>' : '<font color="green"><b>' . $lang["Yes"] . '</b></font>';
		if ( $npc_name == "" )
		    $npc_name = "---";
		if ( $npc_img == "" )
		    $npc_img = "none.gif";
		    
		$npc_quest = ( ( $npc[$i]['npc_item2']=="0" || $npc[$i]['npc_item2']=="" ) && !$npc[$i]['npc_quest_clue'] ) ? '<font color="red"><b>' . $lang["No"] . '</b></font>' : ( ( $npc[$i]['npc_quest_clue'] ) ? '<font color="green"><b>Clue</b></font>' : '<font color="green"><b>Item(s)</b></font>' );
		$npc_monster = ( $npc[$i]['npc_kill_monster']=="0" || $npc[$i]['npc_kill_monster']=="" ) ? $lang["No"] : $lang["Yes"];

		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		$template->assign_block_vars("npc", array(
			"ROW_CLASS" => $row_class,
			"NPC_ENABLE" => $npc_enable,
			"NPC_NAME" => $npc_name,
			"NPC_USER_LEVEL" => $npc_user_level,
			"NPC_TITLE" => $npc_title,
			"NPC_IMG" => $npc_img,
			"NPC_PRICE" => $npc_price,
			"NPC_ZONE" => $npc_zone,
			"NPC_MONSTER" => $npc_monster,
			"NPC_MONSTER_AMOUNT" => $npc_monster_amount,
			"NPC_QUEST" => $npc_quest,
			"NPC_RANDOM" => $npc_random,
			"U_NPC_EDIT" => append_sid("admin_adr_npc.$phpEx?mode=edit&amp;id=" . $npc[$i]['npc_id']),
			"U_NPC_DELETE" => append_sid("admin_adr_npc.$phpEx?mode=delete&amp;id=" . $npc[$i]['npc_id'])
		));
	}
	
	$sql = "SELECT * FROM " . ADR_NPC_TABLE;
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, 'Error getting total npc', '', __LINE__, __FILE__, $sql);

	if ( $total_npc = $db->sql_numrows($result) )
		$pagination = generate_pagination("admin_adr_npc.$phpEx?mode2=$mode2&amp;order=$sort_order", $total_npc, $board_config['topics_per_page'], $start). '&nbsp;';

	$template->assign_vars(array(
		"L_NPC_TITLE" => $lang['Adr_Npc_acp_title'],
		"L_NPC_EXPLAIN" => $lang['Adr_Npc_acp_title_explain'],
		"L_NPC_ENABLE" => $lang['Adr_Npc_acp_npc_enable'],
		"L_NPC_NAME" => $lang['Adr_Npc_acp_npc_name'],
		"L_NPC_IMG" => $lang['Adr_Npc_acp_npc_img'],
		"L_NPC_COST" => $lang['Adr_Npc_acp_npc_cost'],
		"L_NPC_ZONE_NAME" => $lang['Adr_Npc_acp_zone_name'],
		"L_NPC_QUEST" => $lang['Adr_Npc_acp_quest_name'],
		"L_NPC_KILL_QUEST" => $lang['Adr_Npc_acp_quest_kill_name'],
		"L_NPC_ADD" => $lang['Adr_Npc_acp_add'],
		"L_NPC_RANDOM" => $lang['Adr_Npc_acp_npc_random_title'],
		"L_NPC_ACTION" => $lang['Action'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		"L_SUBMIT" => $lang['Submit'],
		'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
		'L_ORDER' => $lang['Order'],
		'L_SORT' => $lang['Sort'],
		'L_SORT_SUBMIT' => $lang['Sort'],
		'S_MODE_SELECT' => $select_sort_mode,
		'S_ORDER_SELECT' => $select_sort_order,
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )),
		'L_GOTO_PAGE' => $lang['Goto_page'],
		"S_NPC_ACTION" => append_sid("admin_adr_npc.$phpEx"))
	);

	$template->pparse("body");
	include_once('./page_footer_admin.'.$phpEx);
}

?>
