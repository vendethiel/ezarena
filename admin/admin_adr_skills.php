<?php
/***************************************************************************
*                               admin_adr_skills.php
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
define('IN_ADR_SKILLS', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr']['Adr_skills'] = $filename;

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

if ( $mode != "" )
{
	switch( $mode )
	{
		case 'edit':

			$skill_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			adr_template_file('admin/config_adr_skills_edit_body.tpl');

			$sql = "SELECT *
				FROM " . ADR_SKILLS_TABLE ."
				WHERE skill_id = $skill_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain skills information', "", __LINE__, __FILE__, $sql);
			}
			$skills = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="skill_id" value="' . $skills['skill_id'] . '" />';

			$template->assign_vars(array(
				"SKILL_NAME" => $lang[$skills['skill_name']],
				"SKILL_DESC" => $skills['skill_desc'],
				"SKILL_DESC_EXPLAIN" => adr_get_lang($skills['skill_desc']),
				"SKILL_IMG" => $skills['skill_img'],
				"SKILL_IMG_EX" => $skills['skill_img'],
				"CHANCE" => $skills['skill_chance'],
				"REQ" => $skills['skill_req'],
				"L_SKILLS_TITLE" => $lang['Adr_skills_add_edit'],
				"L_SKILLS_EXPLAIN" => $lang['Adr_skills_explain'],
				"L_NAME" => $lang['Adr_races_name'],
				"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
				"L_DESC" => $lang['Adr_races_desc'],
				"L_CHANCE" => $lang['Adr_skills_chance'],
				"L_CHANCE_EXPLAIN" => $lang['Adr_skills_chance_explain'],
				"L_REQ" => $lang['Adr_skills_req'],
				"L_REQ_EXPLAIN" => $lang['Adr_skills_req_explain'],
				"L_IMG" => $lang['Adr_races_image'],
				"L_SUBMIT" => $lang['Submit'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields) 
			);

			$template->pparse("body");
			break;

		case "save":

			$skill_id = ( !empty($HTTP_POST_VARS['skill_id']) ) ? intval($HTTP_POST_VARS['skill_id']) : intval($HTTP_GET_VARS['skill_id']);
			$skill_img = ( isset($HTTP_POST_VARS['skill_img']) ) ? trim($HTTP_POST_VARS['skill_img']) : trim($HTTP_GET_VARS['skill_img']);
			$skill_desc = ( isset($HTTP_POST_VARS['skill_desc']) ) ? trim($HTTP_POST_VARS['skill_desc']) : trim($HTTP_GET_VARS['skill_desc']);
			$skill_req = intval($HTTP_POST_VARS['skill_req']);
			$skill_chance = intval($HTTP_POST_VARS['skill_chance']);

			$sql = "UPDATE " . ADR_SKILLS_TABLE . "
				SET 	skill_desc = '" . str_replace("\'", "''", $skill_desc) . "', 
					skill_img = '" . str_replace("\'", "''", $skill_img) . "',
					skill_req = $skill_req ,
					skill_chance = $skill_chance
				WHERE skill_id = " . $skill_id;
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update skills info", "", __LINE__, __FILE__, $sql);
			}

			adr_update_skills();	
			adr_previous( Adr_skills_successful_edited , admin_adr_skills , '' );
			break;
	}
}
else
{
	adr_template_file('admin/config_adr_skills_list_body.tpl');

	// V: WTF 5 ?
	$sql = "SELECT * FROM " . ADR_SKILLS_TABLE . "
			WHERE skill_id != '5'";
	$result = $db->sql_query($sql);
	if(!$result)
		message_die(GENERAL_ERROR, 'Could not obtain skills infos', "", __LINE__, __FILE__, $sql);
	$skills = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($skills); $i++)
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars("skills", array(
			"ROW_CLASS" => $row_class,
			"NAME" => adr_get_lang($skills[$i]['skill_name']),
			"DESC" => adr_get_lang($skills[$i]['skill_desc']),
			"REQ" => $skills[$i]['skill_req'],
			"CHANCE" => $skills[$i]['skill_chance'],
			"IMG" => $skills[$i]['skill_img'],
			"U_SKILLS_EDIT" => append_sid("admin_adr_skills.$phpEx?mode=edit&amp;id=" . $skills[$i]['skill_id'])) 
		);
	}

	$template->assign_vars(array(
		"L_SKILLS_TITLE" => $lang['Adr_skills'],
		"L_SKILLS_TEXT" => $lang['Adr_skills_explain'],
		"L_NAME" => $lang['Adr_races_name'],
		"L_IMG" => $lang['Adr_races_image'],
		"L_DESC" => $lang['Adr_races_desc'],
		"L_REQ" => $lang['Adr_skills_req'],
		"L_CHANCE" => $lang['Adr_skills_chance'],
		"L_ACTION" => $lang['Action'],
		"L_EDIT" => $lang['Edit'],
		"L_SUBMIT" => $lang['Submit'],
		"S_SKILLS_ACTION" => append_sid("admin_adr_skills.$phpEx"))
	);

	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}



?>