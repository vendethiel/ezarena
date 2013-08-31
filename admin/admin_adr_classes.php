<?php
/***************************************************************************
*                               admin_adr_classes.php
*                              -------------------
*     begin                : 02/02/2004
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
define('IN_ADR_CHARACTER', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr']['Adr_classes'] = $filename;

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
	adr_template_file('admin/config_adr_classes_edit_body.tpl');

	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	$template->assign_block_vars( 'classes_add', array());

	$level[0] = $lang['Adr_races_level_all'];
	$level[1] = $lang['Adr_races_level_admin'];
	$level[2] = $lang['Adr_races_level_mod'];

	$level_list = '<select name="level">';
	for( $i = 0; $i < 3; $i++ )
	{
		$level_list .= '<option value = "'.$i.'" >' . $level[$i] . '</option>';
	}
	$level_list .= '</select>';

	$sql = "SELECT *
		FROM " . ADR_CLASSES_TABLE;
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain classes information', "", __LINE__, __FILE__, $sql);
	}
	$classes = $db->sql_fetchrowset($result);

	$evolution_list = '<select name="evolution">';
	$evolution_list .= '<option value = "0" >' . $lang['Adr_classes_evolution_none'] . '</option>';
	for( $i = 0; $i < count($classes); $i++ )
	{
		$evolution_list .= '<option value = "'.$classes[$i]['class_id'].'" >'.adr_get_lang($classes[$i]['class_name']).'</option>';
	}
	$evolution_list .= '</select>';	

	$template->assign_vars(array(
		"LEVEL_LIST" => $level_list,
		"EVOLUTION_LIST" => $evolution_list,
		"L_CLASSES_TITLE" => $lang['Adr_classes_add_edit'],
		"L_CLASSES_EXPLAIN" => $lang['Adr_classes_add_edit_explain'],
		"L_NAME" => $lang['Adr_races_name'],
		"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
		"L_DESC" => $lang['Adr_races_desc'],
		"L_IMG" => $lang['Adr_races_image'],
		"L_IMG_EXPLAIN" => $lang['Adr_classes_image_explain'],
		"L_LEVEL" => $lang['Adr_races_level'],
		"L_LEVEL_EXPLAIN" => $lang['Adr_classes_level_explain'],
		"L_MIGHT_REQ" => $lang['Adr_classes_req_might'],
		"L_DEXT_REQ" => $lang['Adr_classes_req_dext'],
		"L_CONST_REQ" => $lang['Adr_classes_req_const'],
		"L_INT_REQ" => $lang['Adr_classes_req_int'],
		"L_WIS_REQ" => $lang['Adr_classes_req_wis'],
		"L_CHA_REQ" => $lang['Adr_classes_req_cha'],
		"L_MA_REQ" => $lang['Adr_classes_req_ma'],
		"L_MD_REQ" => $lang['Adr_classes_req_md'],
		"L_BASE_HP" => $lang['Adr_classes_base_hp'],
		"L_BASE_MP" => $lang['Adr_classes_base_mp'],
		"L_BASE_AC" => $lang['Adr_classes_base_ac'],
		"L_UPDATE_HP" => $lang['Adr_classes_update_hp'],
		"L_UPDATE_MP" => $lang['Adr_classes_update_mp'],
		"L_UPDATE_AC" => $lang['Adr_classes_update_ac'],
		"L_UPDATE_XP_REQ" => $lang['Adr_classes_update_xp_req'],
		"L_UPDATE_OF" => $lang['Adr_classes_update_of'],
		"L_UPDATE_OF_REQ" => $lang['Adr_classes_update_of_req'],
		"L_SELECTABLE" => $lang['Adr_classes_selectable'],
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

			$class_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			if ( $class_id == '1' )
			{
				adr_previous( Adr_class_default , admin_adr_classes , '' );
			}

			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_class = 1
				WHERE character_class = " . $class_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete class", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . ADR_CLASSES_TABLE . "
				WHERE class_id = " . $class_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete race", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_class_successful_deleted , admin_adr_classes , '' );
			break;

		case 'edit':

			$class_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			adr_template_file('admin/config_adr_classes_edit_body.tpl');

			$template->assign_block_vars( 'classes_edit', array());

			$sql = "SELECT *
				FROM " . ADR_CLASSES_TABLE ."
				WHERE class_id = $class_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain class information', "", __LINE__, __FILE__, $sql);
			}
			$class = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="class_id" value="' . $class['class_id'] . '" />';

			$level[0] = $lang['Adr_races_level_all'];
			$level[1] = $lang['Adr_races_level_admin'];
			$level[2] = $lang['Adr_races_level_mod'];
			$level_list = '<select name="level">';
			for( $i = 0; $i < 3; $i++ )
			{
				$selected = ( $i == $class['race_level'] ) ? ' selected="selected"' : '';
				$level_list .= '<option value = "'.$i.'" '.$selected.' >' . $level[$i] . '</option>';
			}
			$level_list .= '</select>';

			$sql = "SELECT *
				FROM " . ADR_CLASSES_TABLE ." 
				WHERE class_id <> $class_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain classes information', "", __LINE__, __FILE__, $sql);
			}
			$classes = $db->sql_fetchrowset($result);

			$evolution_list = '<select name="evolution">';
			$evolution_list .= '<option value = "0" >'.$lang['Adr_classes_evolution_none'].'</option>';
			for( $i = 0; $i < count($classes); $i++ )
			{
				$selected = ( $classes[$i]['class_id'] == $class['class_update_of'] ) ? ' selected="selected"' : '';
				$evolution_list .= '<option value = "'.$classes[$i]['class_id'].'" '.$selected.'>'.adr_get_lang($classes[$i]['class_name']).'</option>';
			}
			$evolution_list .= '</select>';

			$template->assign_vars(array(
				"LEVEL_LIST" => $level_list,
				"EVOLUTION_LIST" => $evolution_list,
				"CLASS_NAME" => $class['class_name'],
				"CLASS_NAME_EXPLAIN" => adr_get_lang($class['class_name']),
				"CLASS_DESC" => $class['class_desc'],
				"CLASS_DESC_EXPLAIN" => adr_get_lang($class['class_desc']),
				"CLASS_IMG" => $class['class_img'],
				"MIGHT_REQ" => $class['class_might_req'],
				"DEXT_REQ" => $class['class_dexterity_req'],
				"CONST_REQ" => $class['class_constitution_req'],
				"INT_REQ" => $class['class_intelligence_req'],
				"WIS_REQ" => $class['class_wisdom_req'],
				"CHA_REQ" => $class['class_charisma_req'],
				"MA_REQ" => $class['class_magic_attack_req'],
				"MD_REQ" => $class['class_magic_resistance_req'],
				"BASE_HP" => $class['class_base_hp'],
				"BASE_MP" => $class['class_base_mp'],
				"BASE_AC" => $class['class_base_ac'],
				"UPDATE_XP_REQ" => $class['class_update_xp_req'],
				"UPDATE_HP" => $class['class_update_hp'],
				"UPDATE_MP" => $class['class_update_mp'],
				"UPDATE_AC" => $class['class_update_ac'],
				"UPDATE_OF_REQ" => $class['class_update_of_req'],
				"SELECTABLE_CHECKED" => ( $class['class_selectable'] ) ? 'checked' : '',
				"L_CLASSES_TITLE" => $lang['Adr_classes_add_edit'],
				"L_CLASSES_EXPLAIN" => $lang['Adr_classes_add_edit_explain'],
				"L_NAME" => $lang['Adr_races_name'],
				"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
				"L_DESC" => $lang['Adr_races_desc'],
				"L_IMG" => $lang['Adr_races_image'],
				"L_IMG_EXPLAIN" => $lang['Adr_classes_image_explain'],
				"L_LEVEL" => $lang['Adr_races_level'],
				"L_LEVEL_EXPLAIN" => $lang['Adr_classes_level_explain'],
				"L_MIGHT_REQ" => $lang['Adr_classes_req_might'],
				"L_DEXT_REQ" => $lang['Adr_classes_req_dext'],
				"L_CONST_REQ" => $lang['Adr_classes_req_const'],
				"L_INT_REQ" => $lang['Adr_classes_req_int'],
				"L_WIS_REQ" => $lang['Adr_classes_req_wis'],
				"L_CHA_REQ" => $lang['Adr_classes_req_cha'],
				"L_MA_REQ" => $lang['Adr_classes_req_ma'],
				"L_MD_REQ" => $lang['Adr_classes_req_md'],
				"L_BASE_HP" => $lang['Adr_classes_base_hp'],
				"L_BASE_MP" => $lang['Adr_classes_base_mp'],
				"L_BASE_AC" => $lang['Adr_classes_base_ac'],
				"L_UPDATE_HP" => $lang['Adr_classes_update_hp'],
				"L_UPDATE_MP" => $lang['Adr_classes_update_mp'],
				"L_UPDATE_AC" => $lang['Adr_classes_update_ac'],
				"L_UPDATE_XP_REQ" => $lang['Adr_classes_update_xp_req'],
				"L_UPDATE_OF" => $lang['Adr_classes_update_of'],
				"L_UPDATE_OF_REQ" => $lang['Adr_classes_update_of_req'],
				"L_SELECTABLE" => $lang['Adr_classes_selectable'],
				"L_SUBMIT" => $lang['Submit'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields) 
			);

			$template->pparse("body");
			break;

		case "save":

			$class_id = ( !empty($HTTP_POST_VARS['class_id']) ) ? intval($HTTP_POST_VARS['class_id']) : intval($HTTP_GET_VARS['class_id']);

			$class_name = ( isset($HTTP_POST_VARS['class_name']) ) ? trim($HTTP_POST_VARS['class_name']) : trim($HTTP_GET_VARS['class_name']);
			$class_img = ( isset($HTTP_POST_VARS['class_img']) ) ? trim($HTTP_POST_VARS['class_img']) : trim($HTTP_GET_VARS['class_img']);
			$class_desc = ( isset($HTTP_POST_VARS['class_desc']) ) ? trim($HTTP_POST_VARS['class_desc']) : trim($HTTP_GET_VARS['class_desc']);
			$level = intval($HTTP_POST_VARS['level']);
			$evolution = intval($HTTP_POST_VARS['evolution']);
			$req_might = intval($HTTP_POST_VARS['might_req']);
			$req_dext = intval($HTTP_POST_VARS['dext_req']);
			$req_const = intval($HTTP_POST_VARS['const_req']);
			$req_int = intval($HTTP_POST_VARS['int_req']);
			$req_wis = intval($HTTP_POST_VARS['wis_req']);
			$req_cha = intval($HTTP_POST_VARS['cha_req']);
			$req_ma = intval($HTTP_POST_VARS['ma_req']);
			$req_md = intval($HTTP_POST_VARS['md_req']);
			$base_hp = intval($HTTP_POST_VARS['base_hp']);
			$base_mp = intval($HTTP_POST_VARS['base_mp']);
			$base_ac = intval($HTTP_POST_VARS['base_ac']);
			$update_xp_req = intval($HTTP_POST_VARS['update_xp_req']);
			$update_hp = intval($HTTP_POST_VARS['update_hp']);
			$update_mp = intval($HTTP_POST_VARS['update_mp']);
			$update_ac = intval($HTTP_POST_VARS['update_ac']);
			$update_of_req = intval($HTTP_POST_VARS['update_of_req']);
			$selectable = intval($HTTP_POST_VARS['selectable']);

			if ($class_name == '' || !$base_hp || !$base_mp  )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "UPDATE " . ADR_CLASSES_TABLE . "
				SET class_name = '" . str_replace("\'", "''", $class_name) . "', 	
					class_desc = '" . str_replace("\'", "''", $class_desc) . "', 
					class_img = '" . str_replace("\'", "''", $class_img) . "',
					class_level = $level ,
					class_might_req = $req_might , 
					class_dexterity_req = $req_dext ,
					class_constitution_req = $req_const ,
					class_intelligence_req = $req_int ,
					class_wisdom_req = $req_wis ,
					class_charisma_req = $req_cha ,
					class_magic_attack_req = $req_ma ,
					class_magic_resistance_req = $req_md ,
					class_base_hp = $base_hp ,
					class_base_mp = $base_mp ,
					class_base_ac = $base_ac ,
					class_update_hp = $update_hp ,
					class_update_mp = $update_mp ,
					class_update_ac = $update_ac ,
					class_update_xp_req = $update_xp_req ,
					class_update_of = $evolution , 
					class_update_of_req = $update_of_req ,
					class_selectable = $selectable 
				WHERE class_id = " . $class_id;
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update classes info", "", __LINE__, __FILE__, $sql);
			}
			// Update cache
			adr_update_class_infos();

			adr_previous( Adr_class_successful_edited , admin_adr_classes , '' );
			break;

		case "savenew":

			$sql = "SELECT class_id
			FROM " . ADR_CLASSES_TABLE ."
			ORDER BY class_id 
			DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain class information', "", __LINE__, __FILE__, $sql);
			}
			$fields_data = $db->sql_fetchrow($result);

			$class_name = ( isset($HTTP_POST_VARS['class_name']) ) ? trim($HTTP_POST_VARS['class_name']) : trim($HTTP_GET_VARS['class_name']);
			$class_img = ( isset($HTTP_POST_VARS['class_img']) ) ? trim($HTTP_POST_VARS['class_img']) : trim($HTTP_GET_VARS['class_img']);
			$class_desc = ( isset($HTTP_POST_VARS['class_desc']) ) ? trim($HTTP_POST_VARS['class_desc']) : trim($HTTP_GET_VARS['class_desc']);
			$level = intval($HTTP_POST_VARS['level']);
			$evolution = intval($HTTP_POST_VARS['evolution']);
			$req_might = intval($HTTP_POST_VARS['might_req']);
			$req_dext = intval($HTTP_POST_VARS['dext_req']);
			$req_const = intval($HTTP_POST_VARS['const_req']);
			$req_int = intval($HTTP_POST_VARS['int_req']);
			$req_wis = intval($HTTP_POST_VARS['wis_req']);
			$req_cha = intval($HTTP_POST_VARS['cha_req']);
			$req_ma = intval($HTTP_POST_VARS['ma_req']);
			$req_md = intval($HTTP_POST_VARS['md_req']);
			$base_hp = intval($HTTP_POST_VARS['base_hp']);
			$base_mp = intval($HTTP_POST_VARS['base_mp']);
			$base_ac = intval($HTTP_POST_VARS['base_ac']);
			$update_xp_req = intval($HTTP_POST_VARS['update_xp_req']);
			$update_hp = intval($HTTP_POST_VARS['update_hp']);
			$update_mp = intval($HTTP_POST_VARS['update_mp']);
			$update_ac = intval($HTTP_POST_VARS['update_ac']);
			$update_of_req = intval($HTTP_POST_VARS['update_of_req']);
			$selectable = intval($HTTP_POST_VARS['selectable']);

			$class_id = $fields_data['class_id'] +1;

			if ($class_name == '' || !$base_hp || !$base_mp  )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "INSERT INTO " . ADR_CLASSES_TABLE . " 
				( class_id , class_name , class_desc ,  class_level , class_img , class_might_req , class_dexterity_req , class_constitution_req , class_intelligence_req , class_wisdom_req , class_charisma_req , class_magic_attack_req , class_magic_resistance_req , class_base_hp , class_base_mp , class_base_ac , class_update_hp , class_update_mp , class_update_ac , class_update_xp_req , class_update_of , class_update_of_req , class_selectable )
				VALUES ( $class_id,'" . str_replace("\'", "''", $class_name) . "', '" . str_replace("\'", "''", $class_desc) . "' , $level , '" . str_replace("\'", "''", $class_img) . "' , $req_might , $req_dext , $req_const , $req_int, $req_wis, $req_cha , $req_ma , $req_md , $base_hp , $base_mp , $base_ac , $update_hp , $update_mp , $update_ac , $update_xp_req , $evolution , $update_of_req , $selectable )";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new class", "", __LINE__, __FILE__, $sql);
			}
			// Update cache
			adr_update_class_infos();

			adr_previous( Adr_class_successful_added , admin_adr_classes , '' );
			break;
	}
}
else
{

	adr_template_file('admin/config_adr_classes_list_body.tpl');

	$sql = "SELECT *
		FROM " . ADR_CLASSES_TABLE;
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain classes information', "", __LINE__, __FILE__, $sql);
	}
	$classes = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($classes); $i++)
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$level[0] = $lang['Adr_races_level_all'];
		$level[1] = $lang['Adr_races_level_admin'];
		$level[2] = $lang['Adr_races_level_mod'];
		$class_level = $level[$classes[$i]['class_level']];

		$template->assign_block_vars("classes", array(
			"ROW_CLASS" => $row_class,
			"NAME" => adr_get_lang($classes[$i]['class_name']),
			"DESC" => adr_get_lang($classes[$i]['class_desc']),
			"IMG" => $classes[$i]['class_img'],
			"LEVEL" => $class_level,
			"U_CLASSES_EDIT" => append_sid("admin_adr_classes.$phpEx?mode=edit&amp;id=" . $classes[$i]['class_id']), 
			"U_CLASSES_DELETE" => append_sid("admin_adr_classes.$phpEx?mode=delete&amp;id=" . $classes[$i]['class_id']))
		);
	}


	$template->assign_vars(array(
		"L_CLASSES_TITLE" => $lang['Adr_classes'],
		"L_CLASSES_TEXT" => $lang['Adr_classes_explain'],
		"L_NAME" => $lang['Adr_races_name'],
		"L_IMG" => $lang['Adr_races_image'],
		"L_DESC" => $lang['Adr_races_desc'],
		"L_LEVEL" => $lang['Adr_races_level'],
		"L_CLASSES_ADD" => $lang['Adr_classes_add'],
		"L_ACTION" => $lang['Action'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		"L_SUBMIT" => $lang['Submit'],
		"S_CLASSES_ACTION" => append_sid("admin_adr_classes.$phpEx"))
	);

	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}



?>