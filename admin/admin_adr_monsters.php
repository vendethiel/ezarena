<?php
/***************************************************************************
*                               admin_adr_monsters.php
*                              -------------------
*     begin                : 17/02/2004
*     copyright            : Dr DLP / Malicious Rabbit
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
define('IN_ADR_BATTLE', 1);
define('IN_ADR_CHARACTER', 1);
define('IN_ADR_LOOTTABLES', 1);
define('IN_ADR_SHOPS', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr_battle']['Adr_battle_monsters'] = $filename;

	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

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
	adr_template_file('admin/config_adr_monsters_edit_body.tpl');

	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	$template->assign_block_vars( 'monsters_add', array());

	$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE ;
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);
	}
	$element_list = $db->sql_fetchrowset($result);

	// Element list
	$element_mon_list = '<select name="element_mon_list">';
	for($i = 0; $i < count($element_list); $i++)
	{
		$element_list[$i]['element_name'] = adr_get_lang($element_list[$i]['element_name']);
		$element_selected = ( $monster['monster_base_element'] == $element_list[$i]['element_id'] ) ? 'selected' : '';
		$element_mon_list .= '<option value = "'.$element_list[$i]['element_id'].'" '.$element_selected.' >' . $element_list[$i]['element_name'] . '</option>';
	}
	$element_mon_list .= '</select>';

	//season list
	$season[0] = $lang['Adr_Season_all'];
	$season[1] = $lang['Adr_Season_1'];
	$season[2] = $lang['Adr_Season_2'];
	$season[3] = $lang['Adr_Season_3'];
	$season[4] = $lang['Adr_Season_4'];

	$season_list = '<select name="season">';
	for( $i = 0; $i < 5; $i++ )
		$season_list .= '<option value = "'.$i.'" >' . $season[$i] . '</option>';
	$season_list .= '</select>';

	//time list
	$time[0] = $lang['Adr_Time_all'];
	$time[1] = $lang['Adr_Time_1'];
	$time[2] = $lang['Adr_Time_2'];
	$time[3] = $lang['Adr_Time_3'];
	$time[4] = $lang['Adr_Time_4'];

	$time_list = '<select name="time">';
	for( $i = 0; $i < 5; $i++ )
		$time_list .= '<option value = "'.$i.'" >' . $time[$i] . '</option>';
	$time_list .= '</select>';

	//weather list
	$weather[0] = $lang['Adr_Weather_all'];
	$weather[1] = $lang['Adr_Weather_1'];
	$weather[2] = $lang['Adr_Weather_2'];
	$weather[3] = $lang['Adr_Weather_3'];
	$weather[4] = $lang['Adr_Weather_4'];
	$weather[5] = $lang['Adr_Weather_5'];
	$weather[6] = $lang['Adr_Weather_6'];

	$weather_list = '<select name="weather">';
	for( $i = 0; $i < 7; $i++ )
		$weather_list .= '<option value = "'.$i.'" >' . $weather[$i] . '</option>';
	$weather_list .= '</select>';

	//Loottables list
	$sql = "SELECT * FROM " . ADR_LOOTTABLES_TABLE."
			ORDER BY loottable_name ASC";
	$result = $db->sql_query($sql); 
	if( !$result ) 
	{ 
		message_die(GENERAL_ERROR, 'Could not obtain loottables information', "", __LINE__, __FILE__, $sql); 
	} 
	$loottables = $db->sql_fetchrowset($result); 

	$loottables_list = '<select name="monster_loottables[]" size="15" multiple>'; 
	$loottables_list .= '<option value = "0" selected>' . $lang['Adr_no_loottable'] . '</option>'; 
	for( $i = 0; $i < count($loottables); $i++ ) 
	{ 
		$loottables_list .= '<option value = "'.$loottables[$i]['loottable_id'].'" >'.adr_get_lang($loottables[$i]['loottable_name']).'</option>'; 
	} 
	$loottables_list .= '</select>'; 

	//Item list
	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE."
			WHERE item_owner_id = 1
			ORDER BY item_name ASC";
	$result = $db->sql_query($sql); 
	if( !$result ) 
	{ 
		message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql); 
	} 
	$items = $db->sql_fetchrowset($result); 

	$items_list = '<select name="items[]" size="15" multiple>'; 
	$items_list .= '<option value = "0" selected>' . $lang['Adr_no_item'] . '</option>'; 
	for( $i = 0; $i < count($items); $i++ ) 
	{ 
		$items_list .= '<option value = "'.$items[$i]['item_id'].'" >'.adr_get_lang($items[$i]['item_name']).'</option>'; 
	} 
	$items_list .= '</select>';

	$template->assign_vars(array(
		"BASE_ELEMENT" => $element_mon_list,
		"MONSTER_LOOTTABLES_LIST" => $loottables_list,
		"MONSTER_SPECIFIC_DROP_LIST" => $items_list,

		"ZONE_SEASON" => $season_list,
		"ZONE_TIME" => $time_list,
		"ZONE_WEATHER" => $weather_list,
		"L_SEASON" => $lang['Adr_monster_season_choose'],
		"L_WEATHER" => $lang['Adr_monster_weather_choose'],
		"L_MESSAGE_ENABLE" => $lang['Adr_monster_message_enable'],
		"L_MESSAGE" => $lang['Adr_monster_message_choose'],

		"L_MONSTERS_TITLE" => $lang['Adr_monsters_add_edit'],
		"L_MONSTERS_EXPLAIN" => $lang['Adr_monsters_add_edit_explain'],
		"L_LOOTTABLES_TITLE" => $lang['Adr_monster_loottables_title'],
		"L_LOOTTABLES_EXPLAIN" => $lang['Adr_monster_loottables_explain'],
		"L_POSSIBLE_DROP_TITLE" => $lang['Adr_monster_possible_drop_title'],
		"L_POSSIBLE_DROP_EXPLAIN" => $lang['Adr_monster_possible_drop_explain'],
		"L_GURANTEENED_DROP_TITLE" => $lang['Adr_monster_guranteened_drop_title'],
		"L_GURANTEENED_DROP_EXPLAIN" => $lang['Adr_monster_guranteened_drop_explain'],
		"L_SPECIFIC_DROP_TITLE" => $lang['Adr_monster_specific_drop_title'],
		"L_SPECIFIC_DROP_EXPLAIN" => $lang['Adr_monster_specific_drop_explain'],
		"L_NAME" => $lang['Adr_monsters_name'],
		"L_IMG" => $lang['Adr_monsters_image'],
		"L_LEVEL" => $lang['Adr_monsters_level'],
		"L_BASE_HP" => $lang['Adr_admin_monsters_base_hp'],
		"L_BASE_DEF" => $lang['Adr_admin_monsters_base_def'],
		"L_BASE_ATT" => $lang['Adr_admin_monsters_att'],
		"L_BASE_ELEMENT" => $lang['Adr_admin_monsters_element'],
		"L_BASE_MA" => $lang['Adr_admin_monsters_ma'],
		"L_BASE_MD" => $lang['Adr_admin_monsters_md'],
		"L_BASE_MP" => $lang['Adr_admin_monsters_base_mp'],
		"L_BASE_MP_POWER" => $lang['Adr_admin_monsters_base_mp_power'],
		"L_BASE_REGENERATION" => $lang['Adr_admin_monsters_base_regeneration'],
		"L_BASE_MP_REGENERATION" => $lang['Adr_admin_monsters_base_mp_regeneration'],
		"L_BASE_MP_DRAIN" => $lang['Adr_admin_monsters_base_mp_drain'],
		"L_BASE_MP_TRANSFER" => $lang['Adr_admin_monsters_base_mp_transfer'],
		"L_BASE_HP_DRAIN" => $lang['Adr_admin_monsters_base_hp_transfer'],
		"L_BASE_HP_TRANSFER" => $lang['Adr_admin_monsters_base_hp_transfer'],
		"L_BASE_SP" => $lang['Adr_admin_monsters_base_sp'],
		"L_BASE_SPELL" => $lang['Adr_admin_monsters_custom_spell'],
		"L_BASE_SPELL_EXPLAIN" => $lang['Adr_admin_monsters_custom_spell_explain'],
		"L_THIEF_SKILL" => $lang['Adr_admin_monsters_thief_skill'],
		"L_TIME" => $lang['Adr_monster_time_choose'],
		"L_KEY_EXPLAIN" => $lang['Adr_lang_key'],
		"L_IMG_EXPLAIN" => $lang['Adr_monsters_image_explain'],
		"L_SUBMIT" => $lang['Submit'],
		"S_HIDDEN_FIELDS" => $s_hidden_fields) 
	);

	$template->pparse("body");
}
else if ( $mode != "" )
{
	switch( $mode )
	{
		case 'delete':

			$monster_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			$sql = "DELETE FROM " . ADR_BATTLE_MONSTERS_TABLE . "
				WHERE monster_id = " . $monster_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete monster", "", __LINE__, __FILE__, $sql);
			}

			$sql = "SELECT zone_id, zone_monsters_list FROM " . ADR_ZONES_TABLE;
			$result = $db->sql_query($sql);
			$row = $db->sql_fetchrowset($result);
			for($a=0;$a<count($row);$a++)
			{
				if( ($row[$a]['zone_monsters_list']!='') && ($row[$a]['zone_monsters_list']!='0') )
				{
				    $present = false;
				    $monsters_list = explode(", ", $row[$a]['zone_monsters_list']);
					for ( $i=0 ; $i<count($monsters_list) ; $i++ )
					{
						if ( $monsters_list[$i] == $monster_id )
						{
						    $present = true;
						    array_splice($monsters_list, $i, 1);
							break;
						}
					}
					if ( $present == true )
					{
					    $zone_monsters_list = implode(", ", $monsters_list);
						$sql = "UPDATE " . ADR_ZONES_TABLE ." SET
						zone_monsters_list = '" . $zone_monsters_list . "'
						WHERE zone_id = '" . $row[$a]['zone_id'] . "' " ;
						$db->sql_query($sql);
					}
				}
			}

			adr_previous( Adr_monster_successful_deleted , admin_adr_monsters , '' );
			break;

		case 'edit':

			$monster_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			adr_template_file('admin/config_adr_monsters_edit_body.tpl');

			$template->assign_block_vars( 'monsters_edit', array());

			$sql = "SELECT * FROM " . ADR_BATTLE_MONSTERS_TABLE ."
				WHERE monster_id = $monster_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain monster information', "", __LINE__, __FILE__, $sql);
			}
			$monster = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="monster_id" value="' . $monster['monster_id'] . '" />';

			$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE ;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);
			}
			$element_list = $db->sql_fetchrowset($result);

			// Element list
			$element_mon_list = '<select name="element_mon_list">';
			for($i = 0; $i < count($element_list); $i++)
			{
				$element_list[$i]['element_name'] = adr_get_lang($element_list[$i]['element_name']);
				$element_selected = ( $monster['monster_base_element'] == $element_list[$i]['element_id'] ) ? 'selected' : '';
				$element_mon_list .= '<option value = "'.$element_list[$i]['element_id'].'" '.$element_selected.' >' . $element_list[$i]['element_name'] . '</option>';
			}
			$element_mon_list .= '</select>';

			//Grab existing infos
			$existing_season = $monster['monster_season'];
			$existing_time = $monster['monster_time'];
			$existing_weather = $monster['monster_weather'];
			$existing_name = $monster['monster_area_name'];

			//season list
			$season[0] = $lang['Adr_Season_all'];
			$season[1] = $lang['Adr_Season_1'];
			$season[2] = $lang['Adr_Season_2'];
			$season[3] = $lang['Adr_Season_3'];
			$season[4] = $lang['Adr_Season_4'];
			$show_season = $season[$existing_season];

			$season_list = '<select name="season">';
			$season_list .= '<option value = "'. $existing_season .'" >' . $show_season . '</option>';
			for( $i = 0; $i < 5; $i++ )
				$season_list .= '<option value = "'.$i.'" >' . $season[$i] . '</option>';
			$season_list .= '</select>';

			//time list
			$time[0] = $lang['Adr_Time_all'];
			$time[1] = $lang['Adr_Time_1'];
			$time[2] = $lang['Adr_Time_2'];
			$time[3] = $lang['Adr_Time_3'];
			$time[4] = $lang['Adr_Time_4'];
			$show_time = $time[$existing_time];

			$time_list = '<select name="time">';
			$time_list .= '<option value = "'. $existing_time .'" >' . $show_time . '</option>';
			for( $i = 0; $i < 5; $i++ )
				$time_list .= '<option value = "'.$i.'" >' . $time[$i] . '</option>';
			$time_list .= '</select>';

			//weather list
			$weather[0] = $lang['Adr_Weather_all'];
			$weather[1] = $lang['Adr_Weather_1'];
			$weather[2] = $lang['Adr_Weather_2'];
			$weather[3] = $lang['Adr_Weather_3'];
			$weather[4] = $lang['Adr_Weather_4'];
			$weather[5] = $lang['Adr_Weather_5'];
			$weather[6] = $lang['Adr_Weather_6'];
			$show_weather = $weather[$existing_weather];

			$weather_list = '<select name="weather">';
			$weather_list .= '<option value = "'. $existing_weather .'" >' . $show_weather . '</option>';
			for( $i = 0; $i < 7; $i++ )
				$weather_list .= '<option value = "'.$i.'" >' . $weather[$i] . '</option>';
			$weather_list .= '</select>';

			//Loottables list
			$sql = "SELECT * FROM " . ADR_LOOTTABLES_TABLE."
					ORDER BY loottable_name ASC";
			$result = $db->sql_query($sql); 
			if( !$result ) 
			{ 
				message_die(GENERAL_ERROR, 'Could not obtain loottables information', "", __LINE__, __FILE__, $sql); 
			} 
			$loottables = $db->sql_fetchrowset($result); 

			$existing_loottables = explode(":",$monster['monster_loottables']);
			
			$loottables_list = '<select name="monster_loottables[]" size="15" multiple>'; 
			if( in_array('0',$existing_loottables) )
			$selected_no_loottables = 'selected';
			$loottables_list .= '<option value = "0" '.$selected_no_loottables.'>'.$lang['Adr_no_loottable'].'</option>'; 
			for( $i = 0; $i < count($loottables); $i++ ) 
			{ 
				if( in_array($loottables[$i]['loottable_id'], $existing_loottables) && !isset($selected_no_loottables) )
				$selected_loottables = 'selected';
				$loottables_list .= '<option value = "'.$loottables[$i]['loottable_id'].'" '.$selected_loottables.'>'.adr_get_lang($loottables[$i]['loottable_name']).'</option>'; 
				$selected_loottables = '';
			} 
			$loottables_list .= '</select>';

			//Item list
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE."
					WHERE item_owner_id = 1
					ORDER BY item_name ASC";
			$result = $db->sql_query($sql); 
			if( !$result ) 
			{ 
				message_die(GENERAL_ERROR, 'Could not obtain loottables information', "", __LINE__, __FILE__, $sql); 
			} 
			$items = $db->sql_fetchrowset($result); 

			$existing_items = explode(":",$monster['monster_specific_drop']);
			
			$items_list = '<select name="items[]" size="15" multiple>'; 
			if( in_array('0',$existing_items) )
			$selected_no_items = 'selected';
			$items_list .= '<option value = "0" '.$selected_no_items.'>'.$lang['Adr_no_items'].'</option>'; 
			for( $i = 0; $i < count($items); $i++ ) 
			{ 
				if( in_array($items[$i]['item_id'], $existing_items) && !isset($selected_no_items) )
				$selected_items = 'selected';
				$items_list .= '<option value = "'.$items[$i]['item_id'].'" '.$selected_items.'>'.adr_get_lang($items[$i]['item_name']).'</option>'; 
				$selected_items = '';
			} 
			$items_list .= '</select>';

			$template->assign_vars(array(
				"NAME" => $monster['monster_name'],
				"NAME_EXPLAIN" => adr_get_lang($monster['monster_name']),
				"IMG" => $monster['monster_img'],
				"IMG_EX" => $monster['monster_img'],
				"LEVEL" => $monster['monster_level'],
				"BASE_HP" => $monster['monster_base_hp'],
				"BASE_DEF" => $monster['monster_base_def'],
				"BASE_ATT" => $monster['monster_base_att'],
				"BASE_ELEMENT" => $element_mon_list,
				"BASE_MA" => $monster['monster_base_magic_attack'],
				"BASE_MD" => $monster['monster_base_magic_resistance'],
				"BASE_MP" => $monster['monster_base_mp'],
				"BASE_MP_POWER" => $monster['monster_base_mp_power'],
				"BASE_REGENERATION" => $monster['monster_regeneration'],
				"BASE_MP_REGENERATION" => $monster['monster_mp_regeneration'],
				"BASE_MP_DRAIN" => $monster['monster_base_mp_drain'],
				"BASE_MP_TRANSFER" => $monster['monster_base_mp_transfer'],
				"BASE_HP_DRAIN" => $monster['monster_base_hp_drain'],
				"BASE_HP_TRANSFER" => $monster['monster_base_hp_transfer'],
				"BASE_SP" => $monster['monster_base_sp'],
				"BASE_SPELL" => $monster['monster_base_custom_spell'],
				"THIEF_SKILL" => $monster['monster_thief_skill'],
				"MONSTER_LOOTTABLES_LIST" => $loottables_list,
				"MONSTER_POSSIBLE_DROP" => $monster['monster_possible_drop'],
				"MONSTER_GURANTEENED_DROP" => $monster['monster_guranteened_drop'],
				"MONSTER_SPECIFIC_DROP_LIST" => $items_list,

				"ZONE_SEASON" => $season_list,
				"ZONE_TIME" => $time_list,
				"ZONE_WEATHER" => $weather_list,
				"ZONE_MESSAGE_ENABLE" => ($monster['monster_message_enable'] ? 'CHECKED' : ''),
				"ZONE_MESSAGE" => $monster['monster_message'],
				"L_SEASON" => $lang['Adr_monster_season_choose'],
				"L_WEATHER" => $lang['Adr_monster_weather_choose'],
				"L_MESSAGE_ENABLE" => $lang['Adr_monster_message_enable'],
				"L_MESSAGE" => $lang['Adr_monster_message_choose'],

				"L_LOOTTABLES_TITLE" => $lang['Adr_monster_loottables_title'],
				"L_LOOTTABLES_EXPLAIN" => $lang['Adr_monster_loottables_explain'],
				"L_POSSIBLE_DROP_TITLE" => $lang['Adr_monster_possible_drop_title'],
				"L_POSSIBLE_DROP_EXPLAIN" => $lang['Adr_monster_possible_drop_explain'],
				"L_GURANTEENED_DROP_TITLE" => $lang['Adr_monster_guranteened_drop_title'],
				"L_GURANTEENED_DROP_EXPLAIN" => $lang['Adr_monster_guranteened_drop_explain'],
				"L_SPECIFIC_DROP_TITLE" => $lang['Adr_monster_specific_drop_title'],
				"L_SPECIFIC_DROP_EXPLAIN" => $lang['Adr_monster_specific_drop_explain'],
				"L_MONSTERS_TITLE" => $lang['Adr_monsters_add_edit'],
				"L_MONSTERS_EXPLAIN" => $lang['Adr_monsters_add_edit_explain'],
				"L_NAME" => $lang['Adr_monsters_name'],
				"L_IMG" => $lang['Adr_monsters_image'],
				"L_LEVEL" => $lang['Adr_monsters_level'],
				"L_TIME" => $lang['Adr_monster_time_choose'],
				"L_BASE_HP" => $lang['Adr_admin_monsters_base_hp'],
				"L_BASE_DEF" => $lang['Adr_admin_monsters_base_def'],
				"L_BASE_ATT" => $lang['Adr_admin_monsters_att'],
				"L_BASE_ELEMENT" => $lang['Adr_admin_monsters_element'],
				"L_BASE_MA" => $lang['Adr_admin_monsters_ma'],
				"L_BASE_MD" => $lang['Adr_admin_monsters_md'],
				"L_BASE_SPELL" => $lang['Adr_admin_monsters_custom_spell'],
				"L_BASE_SPELL_EXPLAIN" => $lang['Adr_admin_monsters_custom_spell_explain'],
				"L_BASE_MP" => $lang['Adr_admin_monsters_base_mp'],
				"L_BASE_MP_POWER" => $lang['Adr_admin_monsters_base_mp_power'],
				"L_BASE_SP" => $lang['Adr_admin_monsters_base_sp'],
				"L_THIEF_SKILL" => $lang['Adr_admin_monsters_thief_skill'],
				"L_KEY_EXPLAIN" => $lang['Adr_lang_key'],
				"L_IMG_EXPLAIN" => $lang['Adr_monsters_image_explain'],
				"L_BASE_REGENERATION" => $lang['Adr_admin_monsters_base_regeneration'],
				"L_BASE_MP_REGENERATION" => $lang['Adr_admin_monsters_base_mp_regeneration'],
				"L_BASE_MP_DRAIN" => $lang['Adr_admin_monsters_base_mp_drain'],
				"L_BASE_MP_TRANSFER" => $lang['Adr_admin_monsters_base_mp_transfer'],
				"L_BASE_HP_DRAIN" => $lang['Adr_admin_monsters_base_hp_drain'],
				"L_BASE_HP_TRANSFER" => $lang['Adr_admin_monsters_base_hp_transfer'],
				"L_SUBMIT" => $lang['Submit'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields) 
			);

			$template->pparse("body");
			break;

		case "save":

			$monster_id = ( !empty($HTTP_POST_VARS['monster_id']) ) ? intval($HTTP_POST_VARS['monster_id']) : intval($HTTP_GET_VARS['monster_id']);
			$monster_name = ( isset($HTTP_POST_VARS['monster_name']) ) ? trim($HTTP_POST_VARS['monster_name']) : trim($HTTP_GET_VARS['monster_name']);
			$monster_img = ( isset($HTTP_POST_VARS['monster_img']) ) ? trim($HTTP_POST_VARS['monster_img']) : trim($HTTP_GET_VARS['monster_img']);
			$level = intval($HTTP_POST_VARS['monster_level']);
			$hp = intval($HTTP_POST_VARS['hp']);
			$def = intval($HTTP_POST_VARS['def']);
			$att = intval($HTTP_POST_VARS['att']);
			$element = intval($HTTP_POST_VARS['element_mon_list']);	
			$ma = intval($HTTP_POST_VARS['ma']);
			$md = intval($HTTP_POST_VARS['md']);
			$mp = intval($HTTP_POST_VARS['mp']);
			$mp_power = intval($HTTP_POST_VARS['mp_power']);
			$regeneration = intval($HTTP_POST_VARS['regeneration']);
			$mp_regeneration = intval($HTTP_POST_VARS['mpregeneration']);
			$mp_drain = intval($HTTP_POST_VARS['mp_drain']);
			$mp_transfer = intval($HTTP_POST_VARS['mp_transfer']);
			$hp_drain = intval($HTTP_POST_VARS['hp_drain']);
			$hp_transfer = intval($HTTP_POST_VARS['hp_transfer']);
			$sp = intval($HTTP_POST_VARS['sp']);
			$custom_spell = ( isset($HTTP_POST_VARS['custom_spell']) ) ? trim($HTTP_POST_VARS['custom_spell']) : trim($HTTP_GET_VARS['custom_spell']);
			$thief_skill = intval($HTTP_POST_VARS['thief_skill']);
			$possible_drop =  intval($HTTP_POST_VARS['possible_drop']);
			$guranteened_drop =  intval($HTTP_POST_VARS['guranteened_drop']);

			$season = intval($HTTP_POST_VARS['season']);
			$time = intval($HTTP_POST_VARS['time']);
			$weather = intval($HTTP_POST_VARS['weather']);
			$message_enable = intval($HTTP_POST_VARS['message_enable']);
			$message = ( isset($HTTP_POST_VARS['message']) ) ? trim($HTTP_POST_VARS['message']) : trim($HTTP_GET_VARS['message']);

			if ($monster_name == '' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$monster_loottables = array();
			$monster_loottables = $HTTP_POST_VARS['monster_loottables'];
			
			$selected_loottables = count($monster_loottables);
			if ( $selected_loottables == 0 )
				$loottables_list = '';
			elseif ( in_array('0',$monster_loottables) )
				$loottables_list = '0';
			else
			{
				sort($monster_loottables);
				$loottables_list = '';
				for ($a = 0; $a < $selected_loottables; $a++)
					$loottables_list .= ( $loottables_list == '' ) ? $monster_loottables[$a] : ":".$monster_loottables[$a];
			}

			$monster_items = array();
			$monster_items = $HTTP_POST_VARS['items'];
			
			$selected_items = count($monster_items);
			if ( $selected_items == 0 )
				$items_list = '';
			elseif ( in_array('0',$monster_items) )
				$items_list = '0';
			else
			{
				sort($monster_items);
				$items_list = '';
				for ($a = 0; $a < $selected_items; $a++)
					$items_list .= ( $items_list == '' ) ? $monster_items[$a] : ":".$monster_items[$a];
			}

			$sql = "UPDATE " . ADR_BATTLE_MONSTERS_TABLE . "
				SET monster_name = '" . str_replace("\'", "''", $monster_name) . "', 	
					monster_img = '" . str_replace("\'", "''", $monster_img) . "',
					monster_level = $level ,
					monster_base_hp = $hp , 
					monster_base_def = $def ,
					monster_base_att = $att ,
					monster_base_element = $element , 
					monster_base_magic_attack = $ma ,
					monster_base_magic_resistance = $md , 
					monster_base_mp = $mp ,
					monster_base_mp_power = $mp_power ,
					monster_base_sp = $sp ,
					monster_thief_skill = $thief_skill ,
					monster_possible_drop = $possible_drop,
					monster_guranteened_drop = $guranteened_drop,
					monster_loottables = '" . $loottables_list . "',
					monster_specific_drop = '" . $items_list . "',
					monster_base_custom_spell = '" . str_replace("\'", "''", $custom_spell) . "',
					monster_season = $season,
					monster_time = $time,
					monster_weather = $weather,
					monster_regeneration = $regeneration ,
					monster_mp_regeneration = $mp_regeneration ,
					monster_base_mp_drain = $mp_drain ,
					monster_base_mp_transfer = $mp_transfer ,
					monster_base_hp_drain = $hp_drain ,
					monster_base_hp_transfer = $hp_transfer ,
					monster_message_enable = $message_enable,
					monster_message = '" . str_replace("\'", "''", $message) . "'

				WHERE monster_id = " . $monster_id;
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update monster info", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_monster_successful_edited , admin_adr_monsters , '' );
			break;

		case "savenew":

			$sql = "SELECT monster_id
				FROM " . ADR_BATTLE_MONSTERS_TABLE ."
				ORDER BY monster_id 
				DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain monsters information', "", __LINE__, __FILE__, $sql);
			}
			$fields_data = $db->sql_fetchrow($result);

			$monster_name = ( isset($HTTP_POST_VARS['monster_name']) ) ? trim($HTTP_POST_VARS['monster_name']) : trim($HTTP_GET_VARS['monster_name']);
			$monster_img = ( isset($HTTP_POST_VARS['monster_img']) ) ? trim($HTTP_POST_VARS['monster_img']) : trim($HTTP_GET_VARS['monster_img']);
			$level = intval($HTTP_POST_VARS['monster_level']);
			$hp = intval($HTTP_POST_VARS['hp']);
			$def = intval($HTTP_POST_VARS['def']);
			$att = intval($HTTP_POST_VARS['att']);
			$element = intval($HTTP_POST_VARS['element_mon_list']);
			$ma = intval($HTTP_POST_VARS['ma']);
			$md = intval($HTTP_POST_VARS['md']);
			$mp = intval($HTTP_POST_VARS['mp']);
			$mp_power = intval($HTTP_POST_VARS['mp_power']);
			$regeneration = intval($HTTP_POST_VARS['regeneration']);
			$mp_regeneration = intval($HTTP_POST_VARS['mpregeneration']);
			$mp_drain = intval($HTTP_POST_VARS['mp_drain']);
			$mp_transfer = intval($HTTP_POST_VARS['mp_transfer']);
			$hp_drain = intval($HTTP_POST_VARS['hp_drain']);
			$hp_transfer = intval($HTTP_POST_VARS['hp_transfer']);
			$sp = intval($HTTP_POST_VARS['sp']);
			$custom_spell = ( isset($HTTP_POST_VARS['custom_spell']) ) ? trim($HTTP_POST_VARS['custom_spell']) : trim($HTTP_GET_VARS['custom_spell']);
			$thief_skill = intval($HTTP_POST_VARS['thief_skill']);
			$possible_drop =  intval($HTTP_POST_VARS['possible_drop']);
			$guranteened_drop =  intval($HTTP_POST_VARS['guranteened_drop']);

			$season = intval($HTTP_POST_VARS['season']);
			$time = intval($HTTP_POST_VARS['time']);
			$weather = intval($HTTP_POST_VARS['weather']);
			$message_enable = intval($HTTP_POST_VARS['message_enable']);
			$message = ( isset($HTTP_POST_VARS['message']) ) ? trim($HTTP_POST_VARS['message']) : trim($HTTP_GET_VARS['message']);


			$monster_id = $fields_data['monster_id'] + 1 ;

			if ($monster_name == '' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$monster_loottables = array();
			$monster_loottables = $HTTP_POST_VARS['monster_loottables'];
			
			$selected_loottables = count($monster_loottables);
			if ( $selected_loottables == 0 )
				$loottables_list = '';
			elseif ( in_array('0',$monster_loottables) )
				$loottables_list = '0';
			else
			{
				sort($monster_loottables);
				$loottables_list = '';
				for ($a = 0; $a < $selected_loottables; $a++)
					$loottables_list .= ( $loottables_list == '' ) ? $monster_loottables[$a] : ":".$monster_loottables[$a];
			}

			$monster_items = array();
			$monster_items = $HTTP_POST_VARS['items'];
			
			$selected_items = count($monster_items);
			if ( $selected_items == 0 )
				$items_list = '';
			elseif ( in_array('0',$monster_items) )
				$items_list = '0';
			else
			{
				sort($monster_items);
				$items_list = '';
				for ($a = 0; $a < $selected_items; $a++)
					$items_list .= ( $items_list == '' ) ? $monster_items[$a] : ":".$monster_items[$a];
			}

			$sql = "INSERT INTO " . ADR_BATTLE_MONSTERS_TABLE . " 
				( monster_id , monster_name , monster_img , monster_level , monster_base_hp , monster_base_def , monster_base_att , monster_base_element , monster_base_mp , monster_base_mp_power , monster_base_magic_attack , monster_base_magic_resistance , monster_base_sp , monster_base_custom_spell , monster_thief_skill, monster_season , monster_weather  , monster_message_enable , monster_message, monster_possible_drop, monster_guranteened_drop, monster_loottables, monster_specific_drop, monster_regeneration , monster_mp_regeneration , monster_base_mp_drain , monster_base_mp_transfer , monster_base_hp_drain , monster_base_hp_transfer, monster_time )
				VALUES ( $monster_id , '" . str_replace("\'", "''", $monster_name) . "', '" . str_replace("\'", "''", $monster_img) . "' , $level , $hp , $def , $att , $element , $mp , $mp_power , $ma , $md , $sp , '" . str_replace("\'", "''", $custom_spell) . "' , $thief_skill, $season , $weather , $message_enable , '" . str_replace("\'", "''", $message) . "' , $possible_drop, $guranteened_drop, '".$loottables_list."', '".$items_list."', $regeneration , $mp_regeneration , $mp_drain , $mp_transfer , $hp_drain , $hp_transfer, $time)";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new monster", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_monster_successful_added , admin_adr_monsters , '' );
			break;
	}
}
else
{

	adr_template_file('admin/config_adr_monsters_list_body.tpl');

	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

	if ( isset($HTTP_GET_VARS['mode2']) || isset($HTTP_POST_VARS['mode2']) )
	{
		$mode2 = ( isset($HTTP_POST_VARS['mode2']) ) ? htmlspecialchars($HTTP_POST_VARS['mode2']) : htmlspecialchars($HTTP_GET_VARS['mode2']);
	}
	else
	{
		$mode2 = 'itemname';
	}

	if(isset($HTTP_POST_VARS['order']))
	{
		$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else if(isset($HTTP_GET_VARS['order']))
	{
		$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else
	{
		$sort_order = 'ASC';
	}

	if ( isset($HTTP_GET_VARS['cat']) || isset($HTTP_POST_VARS['cat']) )
	{
		$cat = ( isset($HTTP_POST_VARS['cat']) ) ? htmlspecialchars($HTTP_POST_VARS['cat']) : htmlspecialchars( $HTTP_GET_VARS['cat']);
	}
	else
	{
		$cat = 0;
	}
	$cat_sql = ( $cat ) ? 'AND m.monster_name = '.$cat : '';

	$mode_types_text = array( $lang['Adr_monsters_name'] , $lang['Adr_monsters_level'] , $lang['Adr_admin_monsters_element'] );
	$mode_types = array( 'name', 'level' , 'element' );

	$select_sort_mode = '<select name="mode2">';
	for($i = 0; $i < count($mode_types_text); $i++)
	{
		$selected = ( $mode2 == $mode_types[$i] ) ? ' selected="selected"' : '';
		$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
	}
	$select_sort_mode .= '</select>';

	$select_sort_order = '<select name="order">';
	if($sort_order == 'ASC')
	{
		$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
	}
	else
	{
		$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
	}
	$select_sort_order .= '</select>';

	switch( $mode2 )
	{
		case 'name':
			$order_by = "m.monster_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'level':
			$order_by = "m.monster_level $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'element':
			$order_by = "m.monster_base_element $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;

		default:
			$order_by = "m.monster_level $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
	}

	$sql = "SELECT m.* , e.element_name FROM " . ADR_BATTLE_MONSTERS_TABLE . " m, " . ADR_ELEMENTS_TABLE . " e
   		WHERE e.element_id = m.monster_base_element
		$cat_sql
		ORDER BY $order_by";
   	$result = $db->sql_query($sql);
   	if( !$result )
   	{
      		message_die(GENERAL_ERROR, 'Could not obtain monsters information', "", __LINE__, __FILE__, $sql);
   	}
   	$monsters = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($monsters); $i++)
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		if ( $monsters[$i]['monster_season'] == '0' )
			$show_season = $lang['Adr_Season_all'];
		if ( $monsters[$i]['monster_season'] == '1' )
			$show_season = $lang['Adr_Season_1'];
		if ( $monsters[$i]['monster_season'] == '2' )
			$show_season = $lang['Adr_Season_2'];
		if ( $monsters[$i]['monster_season'] == '3' )
			$show_season = $lang['Adr_Season_3'];
		if ( $monsters[$i]['monster_season'] == '4' )
			$show_season = $lang['Adr_Season_4'];

		if ( $monsters[$i]['monster_weather'] == '0' )
			$show_weather = $lang['Adr_Weather_all'];
		if ( $monsters[$i]['monster_weather'] == '1' )
			$show_weather = $lang['Adr_Weather_1'];
		if ( $monsters[$i]['monster_weather'] == '2' )
			$show_weather = $lang['Adr_Weather_2'];
		if ( $monsters[$i]['monster_weather'] == '3' )
			$show_weather = $lang['Adr_Weather_3'];
		if ( $monsters[$i]['monster_weather'] == '4' )
			$show_weather = $lang['Adr_Weather_4'];
		if ( $monsters[$i]['monster_weather'] == '5' )
			$show_weather = $lang['Adr_Weather_5'];
		if ( $monsters[$i]['monster_weather'] == '6' )
			$show_weather = $lang['Adr_Weather_6'];

		if ( $monsters[$i]['monster_time'] == '0' )
			$show_time = $lang['Adr_Time_all'];
		if ( $monsters[$i]['monster_time'] == '1' )
			$show_time = $lang['Adr_Time_1'];
		if ( $monsters[$i]['monster_time'] == '2' )
			$show_time = $lang['Adr_Time_2'];
		if ( $monsters[$i]['monster_time'] == '3' )
			$show_time = $lang['Adr_Time_3'];
		if ( $monsters[$i]['monster_time'] == '4' )
			$show_time = $lang['Adr_Time_4'];

		( $monsters[$i]['monster_message_enable'] == '1' ) ? $show_message = $lang['Adr_monster_message_yes'] : $show_message = $lang['Adr_monster_message_no'];


		$template->assign_block_vars("monsters", array(
			"ROW_CLASS" => $row_class,
			"NAME" => adr_get_lang($monsters[$i]['monster_name']),
			"IMG" => $monsters[$i]['monster_img'],
			"LEVEL" => $monsters[$i]['monster_level'],
			"BASE_HP" => $monsters[$i]['monster_base_hp'],
			"BASE_DEF" => $monsters[$i]['monster_base_def'],
			"BASE_ATT" => $monsters[$i]['monster_base_att'],
			"BASE_MA" => $monsters[$i]['monster_base_magic_attack'],
			"TIME" => $show_time,
			"BASE_MD" => $monsters[$i]['monster_base_magic_resistance'],
			"BASE_MP" => $monsters[$i]['monster_base_mp'],
			"BASE_MP_POWER" => $monsters[$i]['monster_base_mp_power'],
			"BASE_SP" => $monsters[$i]['monster_base_sp'],
			"BASE_SPELL" => $monsters[$i]['monster_base_custom_spell'],
			"THIEF_SKILL" => $monsters[$i]['monster_thief_skill'],
			"BASE_ELEMENT" => adr_get_lang($monsters[$i]['element_name']),

			"SEASON" => $show_season,
			"WEATHER" => $show_weather,
			"MESSAGE" => $show_message,

			"U_MONSTERS_EDIT" => append_sid("admin_adr_monsters.$phpEx?mode=edit&amp;id=" . $monsters[$i]['monster_id']), 
			"U_MONSTERS_DELETE" => append_sid("admin_adr_monsters.$phpEx?mode=delete&amp;id=" . $monsters[$i]['monster_id']))
		);
	}

	$sql = "SELECT count(*) AS total FROM " . ADR_BATTLE_MONSTERS_TABLE;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}
	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_items = $total['total'];
		$pagination = generate_pagination("admin_adr_monsters.$phpEx?mode2=$mode2&amp;order=$sort_order&amp;cat=$cat", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';	
	}


	$template->assign_vars(array(
		"L_MONSTERS_TITLE" => $lang['Adr_admin_monsters'],
		"L_MONSTERS_TEXT" => $lang['Adr_admin_monsters_explain'],
		"L_NAME" => $lang['Adr_monsters_name'],
		"L_IMG" => $lang['Adr_monsters_image'],
		"L_LEVEL" => $lang['Adr_monsters_level'],
		"L_BASE_HP" => $lang['Adr_admin_monsters_base_hp'],
		"L_BASE_DEF" => $lang['Adr_admin_monsters_base_def'],
		"L_BASE_ATT" => $lang['Adr_admin_monsters_att'],
		"L_BASE_ELEMENT" => $lang['Adr_admin_monsters_element'],
		"L_BASE_MA" => $lang['Adr_admin_monsters_ma'],
		"L_BASE_MD" => $lang['Adr_admin_monsters_md'],
		"L_BASE_MP" => $lang['Adr_admin_monsters_base_mp'],
		"L_BASE_MP_POWER" => $lang['Adr_admin_monsters_base_mp_power'],
		"L_BASE_SP" => $lang['Adr_admin_monsters_base_sp'],
		"L_BASE_SPELL" => $lang['Adr_admin_monsters_custom_spell'],
		"L_THIEF_SKILL" => $lang['Adr_admin_monsters_thief_skill'],
		"L_BASE_ELEMENT" => $lang['Adr_admin_monsters_element'],
		"L_MONSTERS_ADD" => $lang['Adr_monsters_add'],

		"L_SEASON_TITLE" => $lang['Adr_monsters_seasons_title'],
		"L_TIME_TITLE" => $lang['Adr_monsters_time_title'],
		"L_WEATHER_TITLE" => $lang['Adr_monsters_weather_title'],
		"L_MESSAGE_TITLE" => $lang['Adr_monsters_message_title'],



		"L_ACTION" => $lang['Action'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
		'L_ORDER' => $lang['Order'],
		'L_SORT' => $lang['Sort'],
		'L_SORT_SUBMIT' => $lang['Sort'],
		'S_MODE_SELECT' => $select_sort_mode,
		'S_ORDER_SELECT' => $select_sort_order,
		'SELECT_CAT' => $select_category,
		'L_SELECT_CAT' => $lang['Adr_items_select'],
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )), 
		'L_GOTO_PAGE' => $lang['Goto_page'],
		"L_SUBMIT" => $lang['Submit'],
		"S_MONSTERS_ACTION" => append_sid("admin_adr_monsters.$phpEx"))
	);

	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}



?>