<?php
/***************************************************************************
*                               admin_adr_zones.php
*                              -------------------
*     begin                : 06/03/2005
*     copyright            : One_Piece
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
define('IN_ADR_CHARACTER', 1);
define('IN_ADR_SHOPS', 1);
define('IN_ADR_BATTLE', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ADR-Zones']['Zones'] = $filename;
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

if( isset($HTTP_POST_VARS['add']) || isset($HTTP_GET_VARS['add']) )
{

	adr_template_file('admin/config_adr_zones_edit_body.tpl');

	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	//
	//BEGIN lists
	//

	//destinations lists
	$sql = "SELECT * FROM " . ADR_ZONES_TABLE ."
		ORDER BY zone_name ASC";
	$result = $db->sql_query($sql);
	if( !$result ) 
		message_die(GENERAL_ERROR, 'Could not obtain zones information', "", __LINE__, __FILE__, $sql);
	
	$zonelist = $db->sql_fetchrowset($result);

/*
	$destination1_list = '<select name="zone_goto1">';
	$destination1_list .= '<option value = "" >' . $lang['Adr_zone_acp_choose_destination'] . '</option>';
	for ( $i = 0 ; $i < count($zonelist) ; $i ++)
	  	$destination1_list .= '<option value = "' . $zonelist[$i]['zone_name'] . '" >' . $zonelist[$i]['zone_name'] . '</option>';
	$destination1_list .= '</select>';
*/

	$destination2_list = '<select name="zone_goto2">';
	$destination2_list .= '<option value = "" >' . $lang['Adr_zone_acp_choose_destination'] . '</option>';
	for ( $i = 0 ; $i < count($zonelist) ; $i ++)
	  	$destination2_list .= '<option value = "' . $zonelist[$i]['zone_name'] . '" >' . $zonelist[$i]['zone_name'] . '</option>';
	$destination2_list .= '</select>';

	$destination3_list = '<select name="zone_goto3">';
	$destination3_list .= '<option value = "" >' . $lang['Adr_zone_acp_choose_destination'] . '</option>';
	for ( $i = 0 ; $i < count($zonelist) ; $i ++)
	  	$destination3_list .= '<option value = "' . $zonelist[$i]['zone_name'] . '" >' . $zonelist[$i]['zone_name'] . '</option>';
	$destination3_list .= '</select>';

	$destination4_list = '<select name="zone_goto4">';
	$destination4_list .= '<option value = "" >' . $lang['Adr_zone_acp_choose_destination'] . '</option>';
	for ( $i = 0 ; $i < count($zonelist) ; $i ++)
	  	$destination4_list .= '<option value = "' . $zonelist[$i]['zone_name'] . '" >' . $zonelist[$i]['zone_name'] . '</option>';
	$destination4_list .= '</select>';

	$return_list = '<select name="zone_return">';
	$return_list .= '<option value = "" >' . $lang['Adr_zone_acp_choose_destination'] . '</option>';
	for ( $i = 0 ; $i < count($zonelist) ; $i ++)
	  	$return_list .= '<option value = "' . $zonelist[$i]['zone_name'] . '" >' . $zonelist[$i]['zone_name'] . '</option>';
	$return_list .= '</select>';

	//elements list
	$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE ;
	$result = $db->sql_query($sql);
	if( !$result ) 
		message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);

	$elements = $db->sql_fetchrowset($result);

	$element_list = '<select name="zone_element">';
	$element_list .= '<option value = "" >' . $lang['Adr_zone_acp_choose_element'] . '</option>';
	for ( $i = 0 ; $i < count($elements) ; $i ++)
		$element_list .= '<option value = "'. adr_get_lang($elements[$i]['element_name']) .'" >' . adr_get_lang($elements[$i]['element_name']) . '</option>';
	$element_list .= '</select>';

	//items list
  	$sql = "SELECT * FROM ". ADR_SHOPS_ITEMS_TABLE ."
       	WHERE item_owner_id = '1'
		ORDER BY item_name ASC";
   	if (!$result = $db->sql_query($sql))
     		message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $sql);

   	$itemlist = $db->sql_fetchrowset($result);

   	$item_list = '<select name="zone_item">';
   	$item_list .= '<option selected value="0" class="post">'. $lang['Adr_zone_acp_item_nothing'] .'</option>';
   	for ($i = 0; $i < count($itemlist); $i++)
     		$item_list .= '<option value = "'. adr_get_lang($itemlist[$i]['item_name']) .'" class="post">' . adr_get_lang($itemlist[$i]['item_name']) . '</option>';
   	$item_list .= '</select>';

   	//monsters lists
   	$sql = "SELECT * FROM " . ADR_BATTLE_MONSTERS_TABLE ."
   		ORDER BY monster_name ASC";
   	$result = $db->sql_query($sql);
   	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain monster information', "", __LINE__, __FILE__, $sql);

   	$monsterlist = $db->sql_fetchrowset($result);

   	$monsters_list = '<select name="monsters[]" size="8" multiple>';
   	$monsters_list .= '<option value="0">' . $lang['Adr_zones_all_monsters'] . '</option>';
   	for ( $i = 0 ; $i < count($monsterlist) ; $i++ )
   	  	$monsters_list .= '<option value = "' . $monsterlist[$i]['monster_id'] . '" >' . $monsterlist[$i]['monster_name'] . ' - ' . $lang['Adr_zones_monster_level'] . ' ' . $monsterlist[$i]['monster_level'] . '</option>';
   	$monsters_list .= '</select>';

	//
	//END lists
	//
	
	$template->assign_vars(array(
		// V: set defaults ...
		'ZONE_COSTRETURN' => 0,
		'ZONE_COSTDESTINATION2' => 0,
		'ZONE_COSTDESTINATION3' => 0,
		'ZONE_COSTDESTINATION4' => 0,
		'ZONE_CHANCE' => 0,
		'ZONE_POINTWIN1' => 0,
		'ZONE_POINTWIN2' => 0,
		'ZONE_POINTLOSS1' => 0,
		'ZONE_POINTLOSS2' => 0,
		// basic fields
		"ZONE_ELEMENT" => $element_list,
		"ZONE_ITEM" => $item_list,
		"ZONE_MONSTER_LIST" => $monsters_list,
		"ZONE_DESTINATION1" => $destination1_list,
		"ZONE_DESTINATION2" => $destination2_list,
		"ZONE_DESTINATION3" => $destination3_list,
		"ZONE_DESTINATION4" => $destination4_list,
		"ZONE_RETURN" => $return_list,
		"L_ZONE_TITLE" => $lang['Adr_Zone_acp_title'],
		"L_ZONE_EXPLAIN" => $lang['Adr_Zone_acp_title_explain'],
		"L_ZONE_SETTINGS" => $lang['Adr_Zone_acp_settings_title'],
		"L_ZONE_NAME" => $lang['Adr_Zone_acp_name'],
		"L_ZONE_NAME_EXPLAIN" => $lang['Adr_Zone_acp_name_explain'],
		"L_ZONE_DESC" => $lang['Adr_Zone_acp_desc'],
		"L_ZONE_DESC_EXPLAIN" => $lang['Adr_Zone_acp_desc_explain'],
		"L_ZONE_IMG" => $lang['Adr_Zone_acp_img'],
		"L_ZONE_IMG_EXPLAIN" => $lang['Adr_Zone_acp_img_explain'],
		"L_ZONE_ELEMENT" => $lang['Adr_Zone_acp_element'],
		"L_ZONE_ELEMENT_EXPLAIN" => $lang['Adr_Zone_acp_element_explain'],
		"L_ZONE_ITEM" => $lang['Adr_Zone_acp_item'],
		"L_ZONE_ITEM_EXPLAIN" => $lang['Adr_Zone_acp_item_explain'],
		"L_ZONE_DESTINATION1" => $lang['Adr_Zone_acp_destination1'],
		"L_ZONE_DESTINATION1_EXPLAIN" => $lang['Adr_Zone_acp_destination1_explain'],
		"L_ZONE_DESTINATION2" => $lang['Adr_Zone_acp_destination2'],
		"L_ZONE_DESTINATION2_EXPLAIN" => $lang['Adr_Zone_acp_destination2_explain'],
		"L_ZONE_DESTINATION3" => $lang['Adr_Zone_acp_destination3'],
		"L_ZONE_DESTINATION3_EXPLAIN" => $lang['Adr_Zone_acp_destination3_explain'],
		"L_ZONE_DESTINATION4" => $lang['Adr_Zone_acp_destination4'],
		"L_ZONE_DESTINATION4_EXPLAIN" => $lang['Adr_Zone_acp_destination4_explain'],
		"L_ZONE_RETURN" => $lang['Adr_Zone_acp_return'],
		"L_ZONE_RETURN_EXPLAIN" => $lang['Adr_Zone_acp_return_explain'],
		"L_ZONE_DESTINATION1_COST" => $lang['Adr_Zone_acp_destination1_cost'],
		"L_ZONE_DESTINATION1_COST_EXPLAIN" => $lang['Adr_Zone_acp_destination1_cost_explain'],
		"L_ZONE_DESTINATION2_COST" => $lang['Adr_Zone_acp_destination2_cost'],
		"L_ZONE_DESTINATION2_COST_EXPLAIN" => $lang['Adr_Zone_acp_destination2_cost_explain'],
		"L_ZONE_DESTINATION3_COST" => $lang['Adr_Zone_acp_destination3_cost'],
		"L_ZONE_DESTINATION3_COST_EXPLAIN" => $lang['Adr_Zone_acp_destination3_cost_explain'],
		"L_ZONE_DESTINATION4_COST" => $lang['Adr_Zone_acp_destination4_cost'],
		"L_ZONE_DESTINATION4_COST_EXPLAIN" => $lang['Adr_Zone_acp_destination4_cost_explain'],
		"L_ZONE_RETURN_COST" => $lang['Adr_Zone_acp_return_cost'],
		"L_ZONE_RETURN_COST_EXPLAIN" => $lang['Adr_Zone_acp_return_cost_explain'],
		"L_ZONE_BATTLE" => $lang['Adr_Zone_acp_battle'],
		"L_ZONE_MONSTER_LIST" => $lang['Adr_Zone_acp_monsters_list'],
		"L_ZONE_MONSTER_LIST_EXPLAIN" => $lang['Adr_Zone_acp_monsters_list_explain'],
		"L_ZONE_TEMPLE" => $lang['Adr_Zone_acp_temple'],
		"L_ZONE_TEMPLE_EXPLAIN" => $lang['Adr_Zone_acp_temple_explain'],
		"L_ZONE_FORGE" => $lang['Adr_Zone_acp_forge'],
		"L_ZONE_FORGE_EXPLAIN" => $lang['Adr_Zone_acp_forge_explain'],
		"L_ZONE_MINE" => $lang['Adr_Zone_acp_mine'],
		"L_ZONE_MINE_EXPLAIN" => $lang['Adr_Zone_acp_mine_explain'],
		"L_ZONE_ENCHANT" => $lang['Adr_Zone_acp_enchant'],
		"L_ZONE_ENCHANT_EXPLAIN" => $lang['Adr_Zone_acp_enchant_explain'],
		"L_ZONE_BANK" => $lang['Adr_Zone_acp_bank'],
		"L_ZONE_BANK_EXPLAIN" => $lang['Adr_Zone_acp_bank_explain'],
		"L_ZONE_PRISON" => $lang['Adr_Zone_acp_prison'],
		"L_ZONE_PRISON_EXPLAIN" => $lang['Adr_Zone_acp_prison_explain'],
		"L_ZONE_SHOPS" => $lang['Adr_Zone_acp_shops'],
		"L_ZONE_SHOPS_EXPLAIN" => $lang['Adr_Zone_acp_shops_explain'],
		"L_ZONE_CONFIG" => $lang['Adr_Zone_acp_config'],
		"L_ZONE_BUILDINGS" => $lang['Adr_Zone_acp_buildings'],
		"L_ZONE_EVENTS" => $lang['Adr_Zone_acp_events'],
		"L_ZONE_CHANCE" => $lang['Adr_Zone_acp_chance'],
		"L_ZONE_LEVEL" => $lang['Adr_Zone_acp_level'],
		"L_ZONE_CHANCE_EXPLAIN" => $lang['Adr_Zone_acp_chance_explain'],
		"L_ZONE_POINTWIN1" => $lang['Adr_Zone_acp_pointwin1'],
		"L_ZONE_POINTWIN1_EXPLAIN" => $lang['Adr_Zone_acp_pointwin1_explain'],
		"L_ZONE_POINTWIN2" => $lang['Adr_Zone_acp_pointwin2'],
		"L_ZONE_POINTWIN2_EXPLAIN" => $lang['Adr_Zone_acp_pointwin2_explain'],
		"L_ZONE_POINTLOSS1" => $lang['Adr_Zone_acp_pointloss1'],
		"L_ZONE_POINTLOSS1_EXPLAIN" => $lang['Adr_Zone_acp_pointloss1_explain'],
		"L_ZONE_POINTLOSS2" => $lang['Adr_Zone_acp_pointloss2'],
		"L_ZONE_POINTLOSS2_EXPLAIN" => $lang['Adr_Zone_acp_pointloss2_explain'],
		"L_ZONE_EVENT1" => $lang['Adr_Zone_acp_event1'],
		"L_ZONE_EVENT1_EXPLAIN" => $lang['Adr_Zone_acp_event1_explain'],
		"L_ZONE_EVENT2" => $lang['Adr_Zone_acp_event2'],
		"L_ZONE_EVENT2_EXPLAIN" => $lang['Adr_Zone_acp_event2_explain'],
		"L_ZONE_EVENT3" => $lang['Adr_Zone_acp_event3'],
		"L_ZONE_EVENT3_EXPLAIN" => $lang['Adr_Zone_acp_event3_explain'],
		"L_ZONE_EVENT4" => $lang['Adr_Zone_acp_event4'],
		"L_ZONE_EVENT4_EXPLAIN" => $lang['Adr_Zone_acp_event4_explain'],
		"L_ZONE_EVENT5" => $lang['Adr_Zone_acp_event5'],
		"L_ZONE_EVENT5_EXPLAIN" => $lang['Adr_Zone_acp_event5_explain'],
		"L_ZONE_EVENT6" => $lang['Adr_Zone_acp_event6'],
		"L_ZONE_EVENT6_EXPLAIN" => $lang['Adr_Zone_acp_event6_explain'],
		"L_ZONE_EVENT7" => $lang['Adr_Zone_acp_event7'],
		"L_ZONE_EVENT7_EXPLAIN" => $lang['Adr_Zone_acp_event7_explain'],
		"L_ZONE_EVENT8" => $lang['Adr_Zone_acp_event8'],
		"L_ZONE_EVENT8_EXPLAIN" => $lang['Adr_Zone_acp_event8_explain'],
		"L_SUBMIT" => $lang['Submit'],
		"S_HIDDEN_FIELDS" => $s_hidden_fields,
		"S_ZONES_ACTION" => append_sid("admin_adr_zones.$phpEx")) 
	);

	$template->pparse("body");
}
else if ( $mode != "" )
{
	switch( $mode )
	{
		case 'delete':

			$zone_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			if ( $zone_id == '1' )
				adr_previous( Adr_zone_default_undeletable , admin_adr_zones , '' );

			$sql = "DELETE FROM " . ADR_ZONES_TABLE . "
				WHERE zone_id = '$zone_id' ";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, "Couldn't delete zones", "", __LINE__, __FILE__, $sql);

			adr_previous( Adr_zone_successful_deleted , admin_adr_zones , '' );
			break;

		case 'edit':

			$zone_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			adr_template_file('admin/config_adr_zones_edit_body.tpl');

			$sql = "SELECT * FROM " . ADR_ZONES_TABLE ."
				WHERE zone_id = '$zone_id' ";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain zones information', "", __LINE__, __FILE__, $sql);

			$zones = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="zone_id" value="' . $zones['zone_id'] . '" />';

			//
			//BEGIN lists
			//

			// $existing_destination1 = $zones['goto1_name'];
			$existing_destination2 = $zones['goto2_name'];
			$existing_destination3 = $zones['goto3_name'];
			$existing_destination4 = $zones['goto4_name'];
			$existing_return = $zones['return_name'];
			$existing_element = $zones['zone_element'];
			$existing_item = $zones['zone_item'];
			(  $existing_item == '0' ) ? $existing_item_name = $lang['Adr_zone_acp_item_nothing'] : $existing_item_name = $existing_item;
			(  $existing_destination2 == '' ) ? $existing_destination2_name = $lang['Adr_zone_acp_choose_nothing'] : $existing_destination2_name = $existing_destination2;
			(  $existing_destination3 == '' ) ? $existing_destination3_name = $lang['Adr_zone_acp_choose_nothing'] : $existing_destination3_name = $existing_destination3;
			(  $existing_destination4 == '' ) ? $existing_destination4_name = $lang['Adr_zone_acp_choose_nothing'] : $existing_destination4_name = $existing_destination4;
			(  $existing_return == '' ) ? $existing_return_name = $lang['Adr_zone_acp_choose_nothing'] : $existing_return_name = $existing_return;

			//destinations lists
			$sql = "SELECT * FROM " . ADR_ZONES_TABLE ."
				ORDER BY zone_name ASC";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain zones information', "", __LINE__, __FILE__, $sql);

			$zonelist = $db->sql_fetchrowset($result);

/*			$destination1_list = '<select name="zone_goto1">';
			$destination1_list .= '<option value = "' . $existing_destination1 . '" >' . $existing_destination1 . '</option>';
			for ( $i = 0 ; $i < count($zonelist) ; $i ++)
			{
				if ($zonelist[$i]['zone_name'] == $existing_destination1 || $zonelist[$i]['zone_name'] == $zones['zone_name'])
					continue;
			  	$destination1_list .= '<option value = "' . $zonelist[$i]['zone_name'] . '" >' . $zonelist[$i]['zone_name'] . '</option>';
			}
			$destination1_list .= '</select>';
*/
			$destination2_list = '<select name="zone_goto2">';
			$destination2_list .= '<option value = "' . $existing_destination2 . '" >' . $existing_destination2_name . '</option><option value = "" >' . $lang['Adr_zone_acp_choose_nothing'] . '</option>';
			for ( $i = 0 ; $i < count($zonelist) ; $i ++)
			{
				if ($zonelist[$i]['zone_name'] == $existing_destination2 || $zonelist[$i]['zone_name'] == $zones['zone_name'])
					continue;
			  	$destination2_list .= '<option value = "' . $zonelist[$i]['zone_name'] . '" >' . $zonelist[$i]['zone_name'] . '</option>';
			}
			$destination2_list .= '</select>';

			$destination3_list = '<select name="zone_goto3">';
			$destination3_list .= '<option value = "' . $existing_destination3 . '" >' . $existing_destination3_name . '</option><option value = "" >' . $lang['Adr_zone_acp_choose_nothing'] . '</option>';
			for ( $i = 0 ; $i < count($zonelist) ; $i ++)
			{
				if ($zonelist[$i]['zone_name'] == $existing_destination3 || $zonelist[$i]['zone_name'] == $zones['zone_name'])
					continue;
			  	$destination3_list .= '<option value = "' . $zonelist[$i]['zone_name'] . '" >' . $zonelist[$i]['zone_name'] . '</option>';
			}
			$destination3_list .= '</select>';

			$destination4_list = '<select name="zone_goto4">';
			$destination4_list .= '<option value = "' . $existing_destination4 . '" >' . $existing_destination4_name . '</option><option value = "" >' . $lang['Adr_zone_acp_choose_nothing'] . '</option>';
			for ( $i = 0 ; $i < count($zonelist) ; $i ++)
			{
				if ($zonelist[$i]['zone_name'] == $existing_destination4 || $zonelist[$i]['zone_name'] == $zones['zone_name'])
					continue;
			  	$destination4_list .= '<option value = "' . $zonelist[$i]['zone_name'] . '" >' . $zonelist[$i]['zone_name'] . '</option>';
			}
			$destination4_list .= '</select>';

			$return_list = '<select name="zone_return">';
			$return_list .= '<option value = "' . $existing_return . '" >' . $existing_return_name . '</option><option value = "" >' . $lang['Adr_zone_acp_choose_nothing'] . '</option>';
			for ( $i = 0 ; $i < count($zonelist) ; $i ++)
			{
				if ($zonelist[$i]['zone_name'] == $existing_return_name || $zonelist[$i]['zone_name'] == $zones['zone_name'])
					continue;
			  	$return_list .= '<option value = "' . $zonelist[$i]['zone_name'] . '" >' . $zonelist[$i]['zone_name'] . '</option>';
			}
			$return_list .= '</select>';

			//elements list
			$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE ;
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);

			$elements = $db->sql_fetchrowset($result);

			$element_list = '<select name="zone_element">';
			$element_list .= '<option value = "' . $existing_element . '" >' . $existing_element . '</option>';
			for ( $i = 0 ; $i < count($elements) ; $i ++)
			  	$element_list .= '<option value = "'. adr_get_lang($elements[$i]['element_name']) .'" >' . adr_get_lang($elements[$i]['element_name']) . '</option>';
			$element_list .= '</select>';

			//items list
  			$sql = "SELECT * FROM ". ADR_SHOPS_ITEMS_TABLE ."
       			WHERE item_owner_id = '1'
				ORDER BY item_name ASC";
   			if (!$result = $db->sql_query($sql))
     				message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $sql);

   			$itemlist = $db->sql_fetchrowset($result);

   			$item_list = '<select name="zone_item">';
   			$item_list .= '<option selected value="0" class="post">'. $lang['Adr_zone_acp_item_nothing'] .'</option><option selected value="'. $existing_item .'" class="post">'. $existing_item_name .'</option>';
   			for ($i = 0; $i < count($itemlist); $i++)
     				$item_list .= '<option value = "'. adr_get_lang($itemlist[$i]['item_name']) .'" class="post">' . adr_get_lang($itemlist[$i]['item_name']) . '</option>';
   			$item_list .= '</select>';

   			//monsters lists
			$sql = "SELECT * FROM " . ADR_BATTLE_MONSTERS_TABLE ."
				ORDER BY monster_name ASC";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain monsters information', "", __LINE__, __FILE__, $sql);

			$monsterlist = $db->sql_fetchrowset($result);

            $existing_monsters = explode(", ",$zones['zone_monsters_list']);

			$monsters_list = '<select name="monsters[]" size="8" multiple>';
			if( in_array('0',$existing_monsters) )
			    $selected_all_monsters = 'selected';
			$monsters_list .= '<option value = "0" '.$selected_all_monsters.'>' . $lang['Adr_zones_all_monsters'] . '</option>';
			for ( $i = 0 ; $i < count($monsterlist) ; $i++ )
			{
			    if( in_array($monsterlist[$i]['monster_id'], $existing_monsters) && !isset($selected_all_monsters) )
			        $selected_monster = 'selected';
	  			$monsters_list .= '<option value = "' . $monsterlist[$i]['monster_id'] . '" '.$selected_monster.'>' . $monsterlist[$i]['monster_name'] . ' - ' . $lang['Adr_zones_monster_level'] . ' ' . $monsterlist[$i]['monster_level'] . '</option>';
	  			$selected_monster = '';
			}
			$monsters_list .= '</select>';

			//
			//END lists
			//

			$template->assign_vars(array(
				"ZONE_LEVEL" => $zones['zone_level'],

				"ZONE_NAME" => $zones['zone_name'],
				"ZONE_DESC" => $zones['zone_desc'],
				"ZONE_IMG" => $zones['zone_img'],
				"ZONE_ELEMENT" => $element_list,
				"ZONE_ITEM" => $item_list,
				"ZONE_MONSTER_LIST" => $monsters_list,
				"ZONE_DESTINATION1" => $destination1_list,
				"ZONE_DESTINATION2" => $destination2_list,
				"ZONE_DESTINATION3" => $destination3_list,
				"ZONE_DESTINATION4" => $destination4_list,
				"ZONE_RETURN" => $return_list,
				// "ZONE_COSTDESTINATION1" => $zones['cost_goto1'],
				"ZONE_COSTDESTINATION2" => $zones['cost_goto2'],
				"ZONE_COSTDESTINATION3" => $zones['cost_goto3'],
				"ZONE_COSTDESTINATION4" => $zones['cost_goto4'],
				"ZONE_COSTRETURN" => $zones['cost_return'],
				"ZONE_SHOPS" => ($zones['zone_shops'] ? 'CHECKED' : ''),
				"ZONE_TEMPLE" => ($zones['zone_temple'] ? 'CHECKED' : ''),
				"ZONE_BANK" => ($zones['zone_bank'] ? 'CHECKED' : ''),
				"ZONE_FORGE" => ($zones['zone_forge'] ? 'CHECKED' : ''),
				"ZONE_MINE" => ($zones['zone_mine'] ? 'CHECKED' : ''),
				"ZONE_ENCHANT" => ($zones['zone_enchant'] ? 'CHECKED' : ''),
				"ZONE_PRISON" => ($zones['zone_prison'] ? 'CHECKED' : ''),
				"ZONE_CHANCE" => $zones['zone_chance'],
				"ZONE_POINTWIN1" => $zones['zone_pointwin1'],
				"ZONE_POINTWIN2" => $zones['zone_pointwin2'],
				"ZONE_POINTLOSS1" => $zones['zone_pointloss1'],
				"ZONE_POINTLOSS2" => $zones['zone_pointloss2'],
				"ZONE_EVENT1" => ($zones['zone_event1'] ? 'CHECKED' : ''),
				"ZONE_EVENT2" => ($zones['zone_event2'] ? 'CHECKED' : ''),
				"ZONE_EVENT3" => ($zones['zone_event3'] ? 'CHECKED' : ''),
				"ZONE_EVENT4" => ($zones['zone_event4'] ? 'CHECKED' : ''),
				"ZONE_EVENT5" => ($zones['zone_event5'] ? 'CHECKED' : ''),
				"ZONE_EVENT6" => ($zones['zone_event6'] ? 'CHECKED' : ''),
				"ZONE_EVENT7" => ($zones['zone_event7'] ? 'CHECKED' : ''),
				"ZONE_EVENT8" => ($zones['zone_event8'] ? 'CHECKED' : ''),
				"L_ZONE_BATTLE" => $lang['Adr_Zone_acp_battle'],
				"L_ZONE_MONSTER_LIST" => $lang['Adr_Zone_acp_monsters_list'],
				"L_ZONE_MONSTER_LIST_EXPLAIN" => $lang['Adr_Zone_acp_monsters_list_explain'],
				"L_ZONE_TITLE" => $lang['Adr_Zone_acp_title'],
				"L_ZONE_EXPLAIN" => $lang['Adr_Zone_acp_title_explain'],
				"L_ZONE_SETTINGS" => $lang['Adr_Zone_acp_settings_title'],
				"L_ZONE_NAME" => $lang['Adr_Zone_acp_name'],
				"L_ZONE_NAME_EXPLAIN" => $lang['Adr_Zone_acp_name_explain'],
				"L_ZONE_DESC" => $lang['Adr_Zone_acp_desc'],
				"L_ZONE_DESC_EXPLAIN" => $lang['Adr_Zone_acp_desc_explain'],
				"L_ZONE_IMG" => $lang['Adr_Zone_acp_img'],
				"L_ZONE_IMG_EXPLAIN" => $lang['Adr_Zone_acp_img_explain'],
				"L_ZONE_ELEMENT" => $lang['Adr_Zone_acp_element'],
				"L_ZONE_ELEMENT_EXPLAIN" => $lang['Adr_Zone_acp_element_explain'],
				"L_ZONE_ITEM" => $lang['Adr_Zone_acp_item'],
				"L_ZONE_ITEM_EXPLAIN" => $lang['Adr_Zone_acp_item_explain'],
				"L_ZONE_DESTINATION1" => $lang['Adr_Zone_acp_destination1'],
				"L_ZONE_DESTINATION1_EXPLAIN" => $lang['Adr_Zone_acp_destination1_explain'],
				"L_ZONE_DESTINATION2" => $lang['Adr_Zone_acp_destination2'],
				"L_ZONE_DESTINATION2_EXPLAIN" => $lang['Adr_Zone_acp_destination2_explain'],
				"L_ZONE_DESTINATION3" => $lang['Adr_Zone_acp_destination3'],
				"L_ZONE_DESTINATION3_EXPLAIN" => $lang['Adr_Zone_acp_destination3_explain'],
				"L_ZONE_DESTINATION4" => $lang['Adr_Zone_acp_destination4'],
				"L_ZONE_DESTINATION4_EXPLAIN" => $lang['Adr_Zone_acp_destination4_explain'],
				"L_ZONE_RETURN" => $lang['Adr_Zone_acp_return'],
				"L_ZONE_RETURN_EXPLAIN" => $lang['Adr_Zone_acp_return_explain'],
				"L_ZONE_DESTINATION1_COST" => $lang['Adr_Zone_acp_destination1_cost'],
				"L_ZONE_DESTINATION1_COST_EXPLAIN" => $lang['Adr_Zone_acp_destination1_cost_explain'],
				"L_ZONE_DESTINATION2_COST" => $lang['Adr_Zone_acp_destination2_cost'],
				"L_ZONE_DESTINATION2_COST_EXPLAIN" => $lang['Adr_Zone_acp_destination2_cost_explain'],
				"L_ZONE_DESTINATION3_COST" => $lang['Adr_Zone_acp_destination3_cost'],
				"L_ZONE_DESTINATION3_COST_EXPLAIN" => $lang['Adr_Zone_acp_destination3_cost_explain'],
				"L_ZONE_DESTINATION4_COST" => $lang['Adr_Zone_acp_destination4_cost'],
				"L_ZONE_DESTINATION4_COST_EXPLAIN" => $lang['Adr_Zone_acp_destination4_cost_explain'],
				"L_ZONE_RETURN_COST" => $lang['Adr_Zone_acp_return_cost'],
				"L_ZONE_RETURN_COST_EXPLAIN" => $lang['Adr_Zone_acp_return_cost_explain'],
				"L_ZONE_TEMPLE" => $lang['Adr_Zone_acp_temple'],
				"L_ZONE_TEMPLE_EXPLAIN" => $lang['Adr_Zone_acp_temple_explain'],
				"L_ZONE_FORGE" => $lang['Adr_Zone_acp_forge'],
				"L_ZONE_FORGE_EXPLAIN" => $lang['Adr_Zone_acp_forge_explain'],
				"L_ZONE_MINE" => $lang['Adr_Zone_acp_mine'],
				"L_ZONE_FORGE_MINE" => $lang['Adr_Zone_acp_mine_explain'],
				"L_ZONE_ENCHANT" => $lang['Adr_Zone_acp_enchant'],
				"L_ZONE_ENCHANT_EXPLAIN" => $lang['Adr_Zone_acp_enchant_explain'],
				"L_ZONE_BANK" => $lang['Adr_Zone_acp_bank'],
				"L_ZONE_BANK_EXPLAIN" => $lang['Adr_Zone_acp_bank_explain'],
				"L_ZONE_PRISON" => $lang['Adr_Zone_acp_prison'],
				"L_ZONE_PRISON_EXPLAIN" => $lang['Adr_Zone_acp_prison_explain'],
				"L_ZONE_SHOPS" => $lang['Adr_Zone_acp_shops'],
				"L_ZONE_SHOPS_EXPLAIN" => $lang['Adr_Zone_acp_shops_explain'],
				"L_ZONE_CONFIG" => $lang['Adr_Zone_acp_config'],
				"L_ZONE_BUILDINGS" => $lang['Adr_Zone_acp_buildings'],
				"L_ZONE_EVENTS" => $lang['Adr_Zone_acp_events'],
				"L_ZONE_CHANCE" => $lang['Adr_Zone_acp_chance'],
				"L_ZONE_LEVEL" => $lang['Adr_Zone_acp_level'],
				"L_ZONE_CHANCE_EXPLAIN" => $lang['Adr_Zone_acp_chance_explain'],
				"L_ZONE_POINTWIN1" => $lang['Adr_Zone_acp_pointwin1'],
				"L_ZONE_POINTWIN1_EXPLAIN" => $lang['Adr_Zone_acp_pointwin1_explain'],
				"L_ZONE_POINTWIN2" => $lang['Adr_Zone_acp_pointwin2'],
				"L_ZONE_POINTWIN2_EXPLAIN" => $lang['Adr_Zone_acp_pointwin2_explain'],
				"L_ZONE_POINTLOSS1" => $lang['Adr_Zone_acp_pointloss1'],
				"L_ZONE_POINTLOSS1_EXPLAIN" => $lang['Adr_Zone_acp_pointloss1_explain'],
				"L_ZONE_POINTLOSS2" => $lang['Adr_Zone_acp_pointloss2'],
				"L_ZONE_POINTLOSS2_EXPLAIN" => $lang['Adr_Zone_acp_pointloss2_explain'],
				"L_ZONE_EVENT1" => $lang['Adr_Zone_acp_event1'],
				"L_ZONE_EVENT1_EXPLAIN" => $lang['Adr_Zone_acp_event1_explain'],
				"L_ZONE_EVENT2" => $lang['Adr_Zone_acp_event2'],
				"L_ZONE_EVENT2_EXPLAIN" => $lang['Adr_Zone_acp_event2_explain'],
				"L_ZONE_EVENT3" => $lang['Adr_Zone_acp_event3'],
				"L_ZONE_EVENT3_EXPLAIN" => $lang['Adr_Zone_acp_event3_explain'],
				"L_ZONE_EVENT4" => $lang['Adr_Zone_acp_event4'],
				"L_ZONE_EVENT4_EXPLAIN" => $lang['Adr_Zone_acp_event4_explain'],
				"L_ZONE_EVENT5" => $lang['Adr_Zone_acp_event5'],
				"L_ZONE_EVENT5_EXPLAIN" => $lang['Adr_Zone_acp_event5_explain'],
				"L_ZONE_EVENT6" => $lang['Adr_Zone_acp_event6'],
				"L_ZONE_EVENT6_EXPLAIN" => $lang['Adr_Zone_acp_event6_explain'],
				"L_ZONE_EVENT7" => $lang['Adr_Zone_acp_event7'],
				"L_ZONE_EVENT7_EXPLAIN" => $lang['Adr_Zone_acp_event7_explain'],
				"L_ZONE_EVENT8" => $lang['Adr_Zone_acp_event8'],
				"L_ZONE_EVENT8_EXPLAIN" => $lang['Adr_Zone_acp_event8_explain'],
				"L_SUBMIT" => $lang['Submit'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields,
				"S_ZONES_ACTION" => append_sid("admin_adr_zones.$phpEx"))
			);

			$template->pparse("body");
			break;

		case "save":

			$zone_id = ( !empty($HTTP_POST_VARS['zone_id']) ) ? intval($HTTP_POST_VARS['zone_id']) : intval($HTTP_GET_VARS['zone_id']);
			$name = ( isset($HTTP_POST_VARS['zone_name']) ) ? trim($HTTP_POST_VARS['zone_name']) : trim($HTTP_GET_VARS['zone_name']);
			$description = ( isset($HTTP_POST_VARS['zone_desc']) ) ? trim($HTTP_POST_VARS['zone_desc']) : trim($HTTP_GET_VARS['zone_desc']);
			$image = ( isset($HTTP_POST_VARS['zone_img']) ) ? trim($HTTP_POST_VARS['zone_img']) : trim($HTTP_GET_VARS['zone_img']);
			$element = ( isset($HTTP_POST_VARS['zone_element']) ) ? trim($HTTP_POST_VARS['zone_element']) : trim($HTTP_GET_VARS['zone_element']);
			$item = ( isset($HTTP_POST_VARS['zone_item']) ) ? trim($HTTP_POST_VARS['zone_item']) : trim($HTTP_GET_VARS['zone_item']);
			// $goto1 = ( isset($HTTP_POST_VARS['zone_goto1']) ) ? trim($HTTP_POST_VARS['zone_goto1']) : trim($HTTP_GET_VARS['zone_goto1']);
			$goto2 = ( isset($HTTP_POST_VARS['zone_goto2']) ) ? trim($HTTP_POST_VARS['zone_goto2']) : trim($HTTP_GET_VARS['zone_goto2']);
			$goto3 = ( isset($HTTP_POST_VARS['zone_goto3']) ) ? trim($HTTP_POST_VARS['zone_goto3']) : trim($HTTP_GET_VARS['zone_goto3']);
			$goto4 = ( isset($HTTP_POST_VARS['zone_goto4']) ) ? trim($HTTP_POST_VARS['zone_goto4']) : trim($HTTP_GET_VARS['zone_goto4']);
			$return = ( isset($HTTP_POST_VARS['zone_return']) ) ? trim($HTTP_POST_VARS['zone_return']) : trim($HTTP_GET_VARS['zone_return']);
			// $cost1 = $HTTP_POST_VARS['zone_cost1'];
			$cost2 = $HTTP_POST_VARS['zone_cost2'];
			$cost3 = $HTTP_POST_VARS['zone_cost3'];
			$cost4 = $HTTP_POST_VARS['zone_cost4'];
			$costreturn = $HTTP_POST_VARS['zone_costreturn'];
			$shops = intval($HTTP_POST_VARS['zone_shops']);
			$forge = intval($HTTP_POST_VARS['zone_forge']);
			$mine = intval($HTTP_POST_VARS['zone_mine']);
			$enchant = intval($HTTP_POST_VARS['zone_enchant']);
			$prison = intval($HTTP_POST_VARS['zone_prison']);
			$temple = intval($HTTP_POST_VARS['zone_temple']);
			$bank = intval($HTTP_POST_VARS['zone_bank']);
			$event1 = intval($HTTP_POST_VARS['zone_event1']);
			$event2 = intval($HTTP_POST_VARS['zone_event2']);
			$event3 = intval($HTTP_POST_VARS['zone_event3']);
			$event4 = intval($HTTP_POST_VARS['zone_event4']);
			$event5 = intval($HTTP_POST_VARS['zone_event5']);
			$event6 = intval($HTTP_POST_VARS['zone_event6']);
			$event7 = intval($HTTP_POST_VARS['zone_event7']);
			$event8 = intval($HTTP_POST_VARS['zone_event8']);
			$pointwin1 = $HTTP_POST_VARS['zone_pointwin1'];
			$pointwin2 = $HTTP_POST_VARS['zone_pointwin2'];
			$pointloss1 = $HTTP_POST_VARS['zone_pointloss1'];
			$pointloss2 = $HTTP_POST_VARS['zone_pointloss2'];
			$chance = (string) intval($HTTP_POST_VARS['zone_chance']);
			$level = intval($HTTP_POST_VARS['zone_level']);

			$monsters = array();
			$monsters = $HTTP_POST_VARS['monsters'];
			
			$selected_monsters = count($monsters);
			if ( $selected_monsters == 0 )
				$monsters_list = '';
			elseif ( in_array('0',$monsters) )
				$monsters_list = '0';
			else
			{
	            sort($monsters);
				$monsters_list = '';
				for ($a = 0; $a < $selected_monsters; $a++)
					$monsters_list .= ( $monsters_list == '' ) ? $monsters[$a] : ", ".$monsters[$a];
			}

			// || $goto1 == ''  || $cost1 == ''
			if ( $name == '' || $description == '' || $element == '' || $cost2 == '' || $cost3 == '' || $cost4 == '' || $costreturn == '' || $pointwin1 == '' || $pointwin2 == '' || $pointloss1 == '' || $pointloss2 == '' || $chance == '' )
				adr_previous( Fields_empty , admin_adr_zones , '' );

			// goto1_name = '" . str_replace("\'", "''", $goto1) . "',
			// cost_goto1 = '$cost1',
			$sql = "UPDATE " . ADR_ZONES_TABLE . "
				SET zone_name = '" . str_replace("\'", "''", $name) . "', 
				zone_desc = '" . str_replace("\'", "''", $description) . "', 
				zone_img = '" . str_replace("\'", "''", $image) . "',
				zone_element = '" . str_replace("\'", "''", $element) . "',
				zone_item = '" . str_replace("\'", "''", $item) . "',
				cost_goto2 = '$cost2',
				cost_goto3 = '$cost3',
				cost_goto4 = '$cost4',
				cost_return = '$costreturn',
				goto2_name = '" . str_replace("\'", "''", $goto2) . "',
				goto3_name = '" . str_replace("\'", "''", $goto3) . "',
				goto4_name = '" . str_replace("\'", "''", $goto4) . "',
				return_name = '" . str_replace("\'", "''", $return) . "',
				zone_shops = '$shops',
				zone_forge = '$forge',
				zone_mine = '$mine',
				zone_enchant = '$enchant',
				zone_prison = '$prison',
				zone_temple = '$temple',
				zone_bank = '$bank',
				zone_monsters_list = '" . $monsters_list . "',
				zone_event1 = '$event1',
				zone_event2 = '$event2',
				zone_event3 = '$event3',
				zone_event4 = '$event4',
				zone_event5 = '$event5',
				zone_event6 = '$event6',
				zone_event7 = '$event7',
				zone_event8 = '$event8',
				zone_pointwin1 = '$pointwin1',
				zone_pointwin2 = '$pointwin2',
				zone_pointloss1 = '$pointloss1',
				zone_pointloss2 = '$pointloss2',
				zone_chance = '$chance',
				zone_level = '$level'
				WHERE zone_id = '$zone_id'";
			if( !($result = $db->sql_query($sql)) )
				message_die(GENERAL_ERROR, "Couldn't update zones info", "", __LINE__, __FILE__, $sql);

			adr_previous( Adr_zone_edit_success , admin_adr_zones , '' );
			break;

		case "savenew":

			$sql = "SELECT * FROM " . ADR_ZONES_TABLE ."
				ORDER BY zone_id 
				DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain zones information', "", __LINE__, __FILE__, $sql);

			$fields_data = $db->sql_fetchrow($result);
			$zone_id = $fields_data['zone_id'] +1;
			$name = ( isset($HTTP_POST_VARS['zone_name']) ) ? trim($HTTP_POST_VARS['zone_name']) : trim($HTTP_GET_VARS['zone_name']);
			$description = ( isset($HTTP_POST_VARS['zone_desc']) ) ? trim($HTTP_POST_VARS['zone_desc']) : trim($HTTP_GET_VARS['zone_desc']);
			$image = ( isset($HTTP_POST_VARS['zone_img']) ) ? trim($HTTP_POST_VARS['zone_img']) : trim($HTTP_GET_VARS['zone_img']);
			$element = ( isset($HTTP_POST_VARS['zone_element']) ) ? trim($HTTP_POST_VARS['zone_element']) : trim($HTTP_GET_VARS['zone_element']);
			$item = ( isset($HTTP_POST_VARS['zone_item']) ) ? trim($HTTP_POST_VARS['zone_item']) : trim($HTTP_GET_VARS['zone_item']);
			// $goto1 = ( isset($HTTP_POST_VARS['zone_goto1']) ) ? trim($HTTP_POST_VARS['zone_goto1']) : trim($HTTP_GET_VARS['zone_goto1']);
			$goto2 = ( isset($HTTP_POST_VARS['zone_goto2']) ) ? trim($HTTP_POST_VARS['zone_goto2']) : trim($HTTP_GET_VARS['zone_goto2']);
			$goto3 = ( isset($HTTP_POST_VARS['zone_goto3']) ) ? trim($HTTP_POST_VARS['zone_goto3']) : trim($HTTP_GET_VARS['zone_goto3']);
			$goto4 = ( isset($HTTP_POST_VARS['zone_goto4']) ) ? trim($HTTP_POST_VARS['zone_goto4']) : trim($HTTP_GET_VARS['zone_goto4']);
			$return = ( isset($HTTP_POST_VARS['zone_return']) ) ? trim($HTTP_POST_VARS['zone_return']) : trim($HTTP_GET_VARS['zone_return']);
			// $cost1 = $HTTP_POST_VARS['zone_cost1'];
			$cost2 = $HTTP_POST_VARS['zone_cost2'];
			$cost3 = $HTTP_POST_VARS['zone_cost3'];
			$cost4 = $HTTP_POST_VARS['zone_cost4'];
			$costreturn = $HTTP_POST_VARS['zone_costreturn'];
			$shops = intval($HTTP_POST_VARS['zone_shops']);
			$forge = intval($HTTP_POST_VARS['zone_forge']);
			$mine = intval($HTTP_POST_VARS['zone_mine']);
			$enchant = intval($HTTP_POST_VARS['zone_enchant']);
			$prison = intval($HTTP_POST_VARS['zone_prison']);
			$temple = intval($HTTP_POST_VARS['zone_temple']);
			$bank = intval($HTTP_POST_VARS['zone_bank']);
			$event1 = intval($HTTP_POST_VARS['zone_event1']);
			$event2 = intval($HTTP_POST_VARS['zone_event2']);
			$event3 = intval($HTTP_POST_VARS['zone_event3']);
			$event4 = intval($HTTP_POST_VARS['zone_event4']);
			$event5 = intval($HTTP_POST_VARS['zone_event5']);
			$event6 = intval($HTTP_POST_VARS['zone_event6']);
			$event7 = intval($HTTP_POST_VARS['zone_event7']);
			$event8 = intval($HTTP_POST_VARS['zone_event8']);
			$pointwin1 = $HTTP_POST_VARS['zone_pointwin1'];
			$pointwin2 = $HTTP_POST_VARS['zone_pointwin2'];
			$pointloss1 = $HTTP_POST_VARS['zone_pointloss1'];
			$pointloss2 = $HTTP_POST_VARS['zone_pointloss2'];
			// V: coerce to string to allow 0
			$chance = (string)intval($HTTP_POST_VARS['zone_chance']);
			$level = intval($HTTP_POST_VARS['zone_level']);

			$monsters = array();
			$monsters = $HTTP_POST_VARS['monsters'];

			$selected_monsters = count($monsters);
			if ( $selected_monsters == 0 )
				$monsters_list = '';
			elseif ( in_array('0',$monsters) )
				$monsters_list = '0';
			else
			{
	            sort($monsters);
				$monsters_list = '';
				for ($a = 0; $a < $selected_monsters; $a++)
					$monsters_list .= ( $monsters_list == '' ) ? $monsters[$a] : ", ".$monsters[$a];
			}

			//$goto1 == '' || $cost1 == ''
			if ( $name == '' || $description == '' || $element == '' || $cost2 == '' || $cost3 == '' || $cost4 == '' || $costreturn == '' || $pointwin1 == '' || $pointwin2 == '' || $pointloss1 == '' || $pointloss2 == '' || $chance == '' )
				adr_previous( Fields_empty , admin_adr_zones , '' );

			$sql = "INSERT INTO " . ADR_ZONES_TABLE . " 
				( zone_id , zone_name , zone_desc, zone_img , zone_element, zone_item, cost_goto2, cost_goto3, cost_goto4, cost_return, goto2_name, goto3_name, goto4_name, return_name, zone_shops , zone_forge , zone_prison , zone_temple, zone_bank, zone_event1, zone_event2, zone_event3, zone_event4, zone_event5, zone_event6, zone_event7, zone_event8, zone_pointwin1, zone_pointwin2, zone_pointloss1, zone_pointloss2, zone_chance, zone_mine, zone_enchant, zone_monsters_list , zone_level )
				VALUES ( '$zone_id' ,'" . str_replace("\'", "''", $name) . "','" . str_replace("\'", "''", $description) . "', '" . str_replace("\'", "''", $image) . "' , '" . str_replace("\'", "''", $element) . "', '" . str_replace("\'", "''", $item) . "' , '$cost2' , '$cost3' , '$cost4' , '$costreturn' , '" . str_replace("\'", "''", $goto2) . "' , '" . str_replace("\'", "''", $goto3) . "' , '" . str_replace("\'", "''", $goto4) . "' , '" . str_replace("\'", "''", $return) . "', '$shops' , '$forge' , '$prison' , '$temple' , '$bank' , '$event1' , '$event2' , '$event3' , '$event4' , '$event5' , '$event6' , '$event7' , '$event8' , '$pointwin1' , '$pointwin2' , '$pointloss1' , '$pointloss2' , '$chance' , '$mine' , '$enchant', '" . $monsters_list . "' , '$level' )";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, "Couldn't insert new zones", "", __LINE__, __FILE__, $sql);

			adr_previous( Adr_zone_add_success , admin_adr_zones , '' );
			break;
	}
}
else
{

	adr_template_file('admin/config_adr_zones_list_body.tpl');

	$sql = "SELECT * FROM " . ADR_ZONES_TABLE;
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, 'Could not obtain zones information', "", __LINE__, __FILE__, $sql);

	$zones = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($zones); $i++)
	{
		//Prevent blank value in the list
		$zone2_value = $zones[$i]['goto2_name'];
		$zone3_value = $zones[$i]['goto3_name'];
		$zone4_value = $zones[$i]['goto4_name'];
		$zonereturn_value = $zones[$i]['return_name'];
		$required_item = $zones[$i]['zone_item'];

		if( $zone2_value == '' ) $zone2_value = 'X';
		if( $zone3_value == '' ) $zone3_value = 'X';
		if( $zone4_value == '' ) $zone4_value = 'X';
		if( $zonereturn_value == '' ) $zonereturn_value = 'X';
		if( $required_item == '0' ) $required_item = 'X';

		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		$template->assign_block_vars("zones", array(
			"ROW_CLASS" => $row_class,
			"NAME" => $zones[$i]['zone_name'],
			"ELEMENT" => $zones[$i]['zone_element'],
			"LEVEL" => $zones[$i]['zone_level'],
			"ITEM" => $required_item,
			// "DESTINATION1" => $zones[$i]['goto1_name'] ,
			"DESTINATION2" => $zone2_value,
			"DESTINATION3" => $zone3_value,
			"DESTINATION4" => $zone4_value,
			"RETURN" => $zonereturn_value,
			"U_ZONES_EDIT" => append_sid("admin_adr_zones.$phpEx?mode=edit&amp;id=" . $zones[$i]['zone_id']), 
			"U_ZONES_DELETE" => append_sid("admin_adr_zones.$phpEx?mode=delete&amp;id=" . $zones[$i]['zone_id'])
		));
	}

	$template->assign_vars(array(
		"L_ZONE_LEVEL" => $lang['Adr_Zone_acp_level'],
		"L_ZONE_TITLE" => $lang['Adr_Zone_acp_title'],
		"L_ZONE_EXPLAIN" => $lang['Adr_Zone_acp_title_explain'],
		"L_ZONE_NAME" => $lang['Adr_Zone_acp_name'],
		"L_ZONE_ELEMENT" => $lang['Adr_Zone_acp_element'],
		"L_ZONE_ITEM" => $lang['Adr_Zone_acp_item_title'],
		"L_ZONE_DESTINATION1" => $lang['Adr_Zone_acp_destination1'],
		"L_ZONE_DESTINATION2" => $lang['Adr_Zone_acp_destination2'],
		"L_ZONE_DESTINATION3" => $lang['Adr_Zone_acp_destination3'],
		"L_ZONE_DESTINATION4" => $lang['Adr_Zone_acp_destination4'],
		"L_ZONE_RETURN" => $lang['Adr_Zone_acp_return'],
		"L_ZONE_ADD" => $lang['Adr_Zone_acp_add'],
		"L_ZONE_ACTION" => $lang['Action'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		"L_SUBMIT" => $lang['Submit'],
		"S_ZONES_ACTION" => append_sid("admin_adr_zones.$phpEx"))
	);

	$template->pparse("body");
	include_once('./page_footer_admin.'.$phpEx);
}

?>