<?php
/***************************************************************************
*                               admin_adr_alignments.php
*                              -------------------
*     begin                : 31/01/2004
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
	$module['Adr']['Adr_alignments'] = $filename;

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
	adr_template_file('admin/config_adr_alignments_edit_body.tpl');

	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	$template->assign_block_vars( 'alignments_add', array());

	$level[0] = $lang['Adr_races_level_all'];
	$level[1] = $lang['Adr_races_level_admin'];
	$level[2] = $lang['Adr_races_level_mod'];

	$level_list = '<select name="level">';
	for( $i = 0; $i < 3; $i++ )
	{
		$level_list .= '<option value = "'.$i.'" >' . $level[$i] . '</option>';
	}
	$level_list .= '</select>';

	$template->assign_vars(array(
		"LEVEL_LIST" => $level_list,
		"L_ALIGNMENTS_TITLE" => $lang['Adr_alignments_add_edit'],
		"L_ALIGNMENTS_EXPLAIN" => $lang['Adr_alignments_add_edit_explain'],
		"L_NAME" => $lang['Adr_races_name'],
		"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
		"L_DESC" => $lang['Adr_races_desc'],
		"L_IMG" => $lang['Adr_races_image'],
		"L_IMG_EXPLAIN" => $lang['Adr_alignments_image_explain'],
		"L_LEVEL" => $lang['Adr_races_level'],
		"L_LEVEL_EXPLAIN" => $lang['Adr_alignments_level_explain'],
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

			$alignment_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			if ( $alignment_id == '1' )
			{
				adr_previous( Adr_alignment_default , admin_adr_alignments , '' );
			}

			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_alignment = 1
				WHERE character_alignment = " . $alignment_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete alignment", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . ADR_ALIGNMENTS_TABLE . "
				WHERE alignment_id = " . $alignment_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete alignment", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_alignment_successful_deleted , admin_adr_alignments , '' );
			break;

		case 'edit':

			$alignment_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			adr_template_file('admin/config_adr_alignments_edit_body.tpl');

			$template->assign_block_vars( 'alignments_edit', array());

			$sql = "SELECT *
				FROM " . ADR_ALIGNMENTS_TABLE ."
				WHERE alignment_id = $alignment_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain alignments information', "", __LINE__, __FILE__, $sql);
			}
			$alignments = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="alignment_id" value="' . $alignments['alignment_id'] . '" />';

			$pic = $alignments['alignment_img'];

			$level[0] = $lang['Adr_races_level_all'];
			$level[1] = $lang['Adr_races_level_admin'];
			$level[2] = $lang['Adr_races_level_mod'];
			$level_list = '<select name="level">';
			for( $i = 0; $i < 3; $i++ )
			{
				$selected = ( $i == $alignments['alignment_level'] ) ? ' selected="selected"' : '';
				$level_list .= '<option value = "'.$i.'" '.$selected.' >' . $level[$i] . '</option>';
			}
			$level_list .= '</select>';

			$template->assign_vars(array(
				"ALIGNMENT_NAME" => $alignments['alignment_name'],
				"ALIGNMENT_NAME_EXPLAIN" => adr_get_lang($alignments['alignment_name']),
				"ALIGNMENT_DESC" => $alignments['alignment_desc'],
				"ALIGNMENT_DESC_EXPLAIN" => adr_get_lang($alignments['alignment_desc']),
				"ALIGNMENT_IMG" => $alignments['alignment_img'],
				"ALIGNMENT_IMG_EX" => $pic ,
				"LEVEL_LIST" => $level_list,
				"L_ALIGNMENTS_TITLE" => $lang['Adr_alignments_add_edit'],
				"L_ALIGNMENTS_EXPLAIN" => $lang['Adr_alignments_add_edit_explain'],
				"L_NAME" => $lang['Adr_races_name'],
				"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
				"L_DESC" => $lang['Adr_races_desc'],
				"L_IMG" => $lang['Adr_races_image'],
				"L_IMG_EXPLAIN" => $lang['Adr_alignments_image_explain'],
				"L_LEVEL" => $lang['Adr_races_level'],
				"L_LEVEL_EXPLAIN" => $lang['Adr_alignments_level_explain'],
				"L_SUBMIT" => $lang['Submit'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields) 
			);

			$template->pparse("body");
			break;

		case "save":

			$alignment_id = ( !empty($HTTP_POST_VARS['alignment_id']) ) ? intval($HTTP_POST_VARS['alignment_id']) : intval($HTTP_GET_VARS['alignment_id']);
			$alignment_name = ( isset($HTTP_POST_VARS['alignment_name']) ) ? trim($HTTP_POST_VARS['alignment_name']) : trim($HTTP_GET_VARS['alignment_name']);
			$alignment_img = ( isset($HTTP_POST_VARS['alignment_img']) ) ? trim($HTTP_POST_VARS['alignment_img']) : trim($HTTP_GET_VARS['alignment_img']);
			$alignment_desc = ( isset($HTTP_POST_VARS['alignment_desc']) ) ? trim($HTTP_POST_VARS['alignment_desc']) : trim($HTTP_GET_VARS['alignment_desc']);
			$level = intval($HTTP_POST_VARS['level']);

			if ($alignment_name == '' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "UPDATE " . ADR_ALIGNMENTS_TABLE . "
				SET alignment_name = '" . str_replace("\'", "''", $alignment_name) . "', 	
					alignment_desc = '" . str_replace("\'", "''", $alignment_desc) . "', 
					alignment_img = '" . str_replace("\'", "''", $alignment_img) . "',
					alignment_level = $level 
				WHERE alignment_id = " . $alignment_id;
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update alignments info", "", __LINE__, __FILE__, $sql);
			}
			// Update cache
			adr_update_alignment_infos();

			adr_previous( Adr_alignment_successful_edited , admin_adr_alignments , '' );
			break;

		case "savenew":

			$sql = "SELECT alignment_id
			FROM " . ADR_ALIGNMENTS_TABLE ."
			ORDER BY alignment_id 
			DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain alignments information', "", __LINE__, __FILE__, $sql);
			}
			$fields_data = $db->sql_fetchrow($result);

			$alignment_name = ( isset($HTTP_POST_VARS['alignment_name']) ) ? trim($HTTP_POST_VARS['alignment_name']) : trim($HTTP_GET_VARS['alignment_name']);
			$alignment_img = ( isset($HTTP_POST_VARS['alignment_img']) ) ? trim($HTTP_POST_VARS['alignment_img']) : trim($HTTP_GET_VARS['alignment_img']);
			$alignment_desc = ( isset($HTTP_POST_VARS['alignment_desc']) ) ? trim($HTTP_POST_VARS['alignment_desc']) : trim($HTTP_GET_VARS['alignment_desc']);
			$level = intval($HTTP_POST_VARS['level']);

			// V: ye ok, I guess an AI field was too much to ask.
			$alignment_id = $fields_data['alignment_id'] +1;

			if ($alignment_name == '' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "INSERT INTO " . ADR_ALIGNMENTS_TABLE . " 
				( alignment_id , alignment_name , alignment_desc ,  alignment_level , alignment_img )
				VALUES ( $alignment_id,'" . str_replace("\'", "''", $alignment_name) . "', '" . str_replace("\'", "''", $alignment_desc) . "' , $level , '" . str_replace("\'", "''", $alignment_img) . "' )";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new alignment", "", __LINE__, __FILE__, $sql);
			}
			// Update cache
			adr_update_alignment_infos();

			adr_previous( Adr_alignment_successful_added , admin_adr_alignments , '' );
			break;
	}
}
else
{
	adr_template_file('admin/config_adr_alignments_list_body.tpl');

	$sql = "SELECT *
		FROM " . ADR_ALIGNMENTS_TABLE;
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain alignments information', "", __LINE__, __FILE__, $sql);
	}
	$alignments = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($alignments); $i++)
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$level[0] = $lang['Adr_races_level_all'];
		$level[1] = $lang['Adr_races_level_admin'];
		$level[2] = $lang['Adr_races_level_mod'];
		$alignment_level = $level[$alignments[$i]['alignment_level']];

		$pic = $alignments[$i]['alignment_img'];

		$template->assign_block_vars("alignments", array(
			"ROW_CLASS" => $row_class,
			"NAME" => adr_get_lang($alignments[$i]['alignment_name']),
			"DESC" => adr_get_lang($alignments[$i]['alignment_desc']),
			"IMG" => $pic ,
			"LEVEL" => $alignment_level,
			"U_ALIGNMENTS_EDIT" => append_sid("admin_adr_alignments.$phpEx?mode=edit&amp;id=" . $alignments[$i]['alignment_id']), 
			"U_ALIGNMENTS_DELETE" => append_sid("admin_adr_alignments.$phpEx?mode=delete&amp;id=" . $alignments[$i]['alignment_id']))
		);
	}


	$template->assign_vars(array(
		"L_ALIGNMENTS_TITLE" => $lang['Adr_alignments'],
		"L_ALIGNMENTS_TEXT" => $lang['Adr_alignments_explain'],
		"L_NAME" => $lang['Adr_races_name'],
		"L_IMG" => $lang['Adr_races_image'],
		"L_DESC" => $lang['Adr_races_desc'],
		"L_LEVEL" => $lang['Adr_races_level'],
		"L_ALIGNMENTS_ADD" => $lang['Adr_alignments_add'],
		"L_ACTION" => $lang['Action'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		"L_SUBMIT" => $lang['Submit'],
		"S_ALIGNMENTS_ACTION" => append_sid("admin_adr_alignments.$phpEx"))
	);

	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}



?>
