<?php
/***************************************************************************
*                               admin_adr_jobs.php
*                              -------------------
*     begin                : 11/11/2004
*     copyright            : Seteo-Bloke
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
define('IN_ADR_SHOPS', 1);
define('IN_ADR_CHARACTER', 1);
define('IN_ADR_JOB', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr']['Adr_jobs'] = $filename;

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

		case 'add_job':

			adr_template_file('admin/config_adr_jobs_edit_body.tpl');

			$template->assign_block_vars('add',array());

			$s_hidden_fields = '<input type="hidden" name="mode" value="savenew_job" /><input type="hidden" name="item_type" value="' . $item_type . '" />';

			// Grab items
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_owner_id = 1 ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);
			}
			$item_list = $db->sql_fetchrowset($result);

			// Stores list
			$item_reward_list = '<select name="item_reward_list">';
			$item_reward_list .= '<option value = "0" >' . $lang['Adr_job_no_item_reward'] . '</option>';
			for($i = 0; $i < count($item_list); $i++)
			{
				$item_list[$i]['item_name'] = adr_get_lang($item_list[$i]['item_name']);
				$item_selected = ( $items['item_id'] == $item_list[$i]['item_id'] ) ? 'selected' : '';
				$item_reward_list .= '<option value = "'.$item_list[$i]['item_id'].'" '.$item_selected.' >' . $item_list[$i]['item_name'] . '</option>';
			}
			$item_reward_list .= '</select>';

			// Grab races
			$sql = "SELECT * FROM " . ADR_RACES_TABLE;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain races information', "", __LINE__, __FILE__, $sql);
			}
			$race_list = $db->sql_fetchrowset($result);

			// Race list
			$race_req_list = '<select name="race_list">';
                  $race_req_list .= '<option value = "0" >' . $lang['Adr_admin_job_all_races'] . '</option>';
			for($i = 0; $i < count($race_list); $i++)
			{
				$race_list[$i]['race_name'] = adr_get_lang($race_list[$i]['race_name']);
				$race_selected = ( $jobs['job_race_id'] == $race_list[$i]['race_id'] ) ? 'selected' : '';
				$race_req_list .= '<option value = "'.$race_list[$i]['race_id'].'" '.$race_selected.' >' . $race_list[$i]['race_name'] . '</option>';
			}
			$race_req_list .= '</select>';

			// Grab classes
			$sql = "SELECT * FROM " . ADR_CLASSES_TABLE;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain classes information', "", __LINE__, __FILE__, $sql);
			}
			$class_list = $db->sql_fetchrowset($result);

			// Classes list
			$class_req_list = '<select name="class_list">';
                  $class_req_list .= '<option value = "0" >' . $lang['Adr_admin_job_all_classes'] . '</option>';
			for($i = 0; $i < count($class_list); $i++)
			{
				$class_list[$i]['class_name'] = adr_get_lang($class_list[$i]['class_name']);
				$class_selected = ( $jobs['job_class_id'] == $class_list[$i]['class_id'] ) ? 'selected' : '';
				$class_req_list .= '<option value = "'.$class_list[$i]['class_id'].'" '.$class_selected.' >' . $class_list[$i]['class_name'] . '</option>';
			}
			$class_req_list .= '</select>';

			// Grab alignment
			$sql = "SELECT * FROM " . ADR_ALIGNMENTS_TABLE;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain alignment information', "", __LINE__, __FILE__, $sql);
			}
			$alignment_list = $db->sql_fetchrowset($result);

			// alignment list
			$alignment_req_list = '<select name="alignment_list">';
                  $alignment_req_list .= '<option value = "0" >' . $lang['Adr_admin_job_all_alignments'] . '</option>';
			for($i = 0; $i < count($alignment_list); $i++)
			{
				$alignment_list[$i]['alignment_name'] = adr_get_lang($alignment_list[$i]['alignment_name']);
				$alignment_selected = ( $jobs['job_alignment_id'] == $alignment_list[$i]['alignment_id'] ) ? 'selected' : '';
				$alignment_req_list .= '<option value = "'.$alignment_list[$i]['alignment_id'].'" '.$alignment_selected.' >' . $alignment_list[$i]['alignment_name'] . '</option>';
			}
			$alignment_req_list .= '</select>';

			// Check auth level
			$level[0] = $lang['Adr_races_level_all'];
			$level[1] = $lang['Adr_races_level_admin'];
			$level[2] = $lang['Adr_races_level_mod'];

			$level_list = '<select name="job_auth_level">';
			for( $i = 0; $i < 3; $i++ )
			{
				$level_list .= '<option value = "'.$i.'" >' . $level[$i] . '</option>';
			}
			$level_list .= '</select>';

			$template->assign_vars(array(
				"JOB_AUTH_LEVEL"		=> $level_list,
				"ITEM_REWARD_LIST" 	=> $item_reward_list,
				"CLASS_LIST" 		=> $class_req_list,
				"RACE_LIST" 		=> $race_req_list,
				"ALIGNMENT_LIST" 		=> $alignment_req_list,
				"L_JOB_NAME" 		=> $lang['Adr_admin_job_name'],
				"L_JOB_DESC" 		=> $lang['Adr_admin_job_desc'],
				"L_JOB_IMG" 		=> $lang['Adr_admin_job_img'],
				"L_JOB_LEVEL" 		=> $lang['Adr_admin_job_level'],
				"L_JOB_AUTH_LEVEL" 	=> $lang['Adr_admin_job_auth_level'],
				"L_JOB_RACE" 		=> $lang['Adr_admin_job_race'],
				"L_JOB_CLASS" 		=> $lang['Adr_admin_job_class'],
				"L_JOB_ALIGNMENT"		=> $lang['Adr_admin_job_alignment'],
				"L_JOB_SALARY" 		=> $lang['Adr_admin_job_salary'],
				"L_JOB_SALARY_INT"	=> $lang['Adr_job_salary_intervals'],
				"L_JOB_EXP" 		=> $lang['Adr_admin_job_exp'],
				"L_JOB_DURATION" 		=> $lang['Adr_admin_job_duration'],
				"L_JOB_SLOTS" 		=> $lang['Adr_admin_job_slots'],
				"L_JOB_SLOTS_MAX" 	=> $lang['Adr_admin_job_slots_max'],
				"L_JOB_ITEM" 		=> $lang['Adr_admin_job_item_reward'],
				"L_JOB_SP_REWARD" 	=> $lang['Adr_admin_job_sp_reward'],
				"L_ACTION" 			=> $lang['Action'],
				"L_EDIT" 			=> $lang['Edit'],
				"L_DELETE"			=> $lang['Delete'],
				"L_SUBMIT" 			=> $lang['Submit'],
				"S_ITEMS_ACTION" 		=> append_sid("admin_adr_jobs.$phpEx"),
				"S_HIDDEN_FIELDS" 	=> $s_hidden_fields, 
			));

			$template->pparse("body");

		break;

		case 'delete_job':

			$job_id = ( !empty($HTTP_POST_VARS['job_id']) ) ? intval($HTTP_POST_VARS['job_id']) : intval($HTTP_GET_VARS['job_id']);

			// Remove job from current employees
			$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_job_id = 0,
					character_job_start = 0
				WHERE character_job_id = $job_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete job", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . ADR_JOB_TABLE . "
				WHERE job_id = $job_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete job", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_job_successful_deleted , admin_adr_jobs , '' );

		break;

		case 'edit_job':

			$job_id = ( !empty($HTTP_POST_VARS['job_id']) ) ? intval($HTTP_POST_VARS['job_id']) : intval($HTTP_GET_VARS['job_id']);

			adr_template_file('admin/config_adr_jobs_edit_body.tpl');
			$template->assign_block_vars('edit',array());

			$sql = "SELECT * FROM " . ADR_JOB_TABLE . "
				WHERE job_id = $job_id";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}
			$jobs = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save_job" /><input type="hidden" name="job_id" value="' . $job_id . '" />';

			// Grab shop items
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_owner_id = 1 ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
			}
			$item_list = $db->sql_fetchrowset($result);

			// Item reward list
			$item_reward_list = '<select name="item_reward_list">';
                  $item_reward_list .= '<option value = "0" >' . $lang['Adr_job_no_item_reward'] . '</option>';
			for($i = 0; $i < count($item_list); $i++)
			{
				$item_list[$i]['item_name'] = adr_get_lang($item_list[$i]['item_name']);
				$item_selected = ( $jobs['job_item_reward_id'] == $item_list[$i]['item_id'] ) ? 'selected' : '';
				$item_reward_list .= '<option value = "'.$item_list[$i]['item_id'].'" '.$item_selected.' >' . $item_list[$i]['item_name'] . '</option>';
			}
			$item_reward_list .= '</select>';

			// Grab races
			$sql = "SELECT * FROM " . ADR_RACES_TABLE;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain races information', "", __LINE__, __FILE__, $sql);
			}
			$race_list = $db->sql_fetchrowset($result);

			// Race list
			$race_req_list = '<select name="race_list">';
                  $race_req_list .= '<option value = "0" >' . $lang['Adr_admin_job_all_races'] . '</option>';
			for($i = 0; $i < count($race_list); $i++)
			{
				$race_list[$i]['race_name'] = adr_get_lang($race_list[$i]['race_name']);
				$race_selected = ( $jobs['job_race_id'] == $race_list[$i]['race_id'] ) ? 'selected' : '';
				$race_req_list .= '<option value = "'.$race_list[$i]['race_id'].'" '.$race_selected.' >' . $race_list[$i]['race_name'] . '</option>';
			}
			$race_req_list .= '</select>';

			// Grab classes
			$sql = "SELECT * FROM " . ADR_CLASSES_TABLE;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain classes information', "", __LINE__, __FILE__, $sql);
			}
			$class_list = $db->sql_fetchrowset($result);

			// Classes list
			$class_req_list = '<select name="class_list">';
                  $class_req_list .= '<option value = "0" >' . $lang['Adr_admin_job_all_classes'] . '</option>';
			for($i = 0; $i < count($class_list); $i++)
			{
				$class_list[$i]['class_name'] = adr_get_lang($class_list[$i]['class_name']);
				$class_selected = ( $jobs['job_class_id'] == $class_list[$i]['class_id'] ) ? 'selected' : '';
				$class_req_list .= '<option value = "'.$class_list[$i]['class_id'].'" '.$class_selected.' >' . $class_list[$i]['class_name'] . '</option>';
			}
			$class_req_list .= '</select>';

			// Grab alignment
			$sql = "SELECT * FROM " . ADR_ALIGNMENTS_TABLE;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain alignment information', "", __LINE__, __FILE__, $sql);
			}
			$alignment_list = $db->sql_fetchrowset($result);

			// alignment list
			$alignment_req_list = '<select name="alignment_list">';
                  $alignment_req_list .= '<option value = "0" >' . $lang['Adr_admin_job_all_alignments'] . '</option>';
			for($i = 0; $i < count($alignment_list); $i++)
			{
				$alignment_list[$i]['alignment_name'] = adr_get_lang($alignment_list[$i]['alignment_name']);
				$alignment_selected = ( $jobs['job_alignment_id'] == $alignment_list[$i]['alignment_id'] ) ? 'selected' : '';
				$alignment_req_list .= '<option value = "'.$alignment_list[$i]['alignment_id'].'" '.$alignment_selected.' >' . $alignment_list[$i]['alignment_name'] . '</option>';
			}
			$alignment_req_list .= '</select>';

			// Check auth level
			$level[0] = $lang['Adr_races_level_all'];
			$level[1] = $lang['Adr_races_level_admin'];
			$level[2] = $lang['Adr_races_level_mod'];
			$level_list = '<select name="job_auth_level">';
			for( $i = 0; $i < 3; $i++ )
			{
				$selected = ( $i == $jobs['job_auth_level'] ) ? ' selected="selected"' : '';
				$level_list .= '<option value = "'.$i.'" '.$selected.' >' . $level[$i] . '</option>';
			}
			$level_list .= '</select>';

			$template->assign_vars(array(
				"JOB_AUTH_LEVEL"		=> $level_list,
				"ITEM_REWARD_LIST" 	=> $item_reward_list,
				"CLASS_LIST" 		=> $class_req_list,
				"RACE_LIST" 		=> $race_req_list,
				"ALIGNMENT_LIST" 		=> $alignment_req_list,
				"JOB_NAME" 			=> $jobs['job_name'],
				"JOB_IMG" 			=> $jobs['job_img'],
				"JOB_DESC" 			=> $jobs['job_desc'],
				"JOB_LEVEL" 		=> $jobs['job_level'],
				"JOB_RACE" 			=> $jobs['job_race'],
				"JOB_CLASS" 		=> $jobs['job_class'],
				"JOB_ALIGNMENT" 		=> $jobs['job_alignment'],
				"JOB_SALARY" 		=> $jobs['job_salary'],
				"JOB_SALARY_INT" 		=> $jobs['job_payment_intervals'],
				"JOB_EXP" 			=> $jobs['job_exp'],
				"JOB_DURATION" 		=> $jobs['job_duration'],
				"JOB_SLOTS" 		=> $jobs['job_slots_available'],
				"JOB_SLOTS_MAX" 		=> $jobs['job_slots_max'],
				"JOB_SP_REWARD" 		=> $jobs['job_sp_reward'],
				"L_JOB_NAME" 		=> $lang['Adr_admin_job_name'],
				"L_JOB_DESC" 		=> $lang['Adr_admin_job_desc'],
				"L_JOB_IMG" 		=> $lang['Adr_admin_job_img'],
				"L_JOB_LEVEL" 		=> $lang['Adr_admin_job_level'],
				"L_JOB_AUTH_LEVEL" 	=> $lang['Adr_admin_job_auth_level'],
				"L_JOB_RACE" 		=> $lang['Adr_admin_job_race'],
				"L_JOB_CLASS" 		=> $lang['Adr_admin_job_class'],
				"L_JOB_ALIGNMENT"		=> $lang['Adr_admin_job_alignment'],
				"L_JOB_SALARY" 		=> $lang['Adr_admin_job_salary'],
				"L_JOB_SALARY_INT"	=> $lang['Adr_job_salary_intervals'],
				"L_JOB_EXP" 		=> $lang['Adr_admin_job_exp'],
				"L_JOB_DURATION" 		=> $lang['Adr_admin_job_duration'],
				"L_JOB_SLOTS" 		=> $lang['Adr_admin_job_slots'],
				"L_JOB_SLOTS_MAX" 	=> $lang['Adr_admin_job_slots_max'],
				"L_JOB_ITEM" 		=> $lang['Adr_admin_job_item_reward'],
				"L_JOB_CLASS" 		=> $lang['Adr_admin_job_class'],
				"L_JOB_RACE" 		=> $lang['Adr_admin_job_race'],
				"L_JOB_SP_REWARD" 	=> $lang['Adr_admin_job_sp_reward'],
				"L_POINTS" 			=> $board_config['points_name'],
				"L_ACTION" 			=> $lang['Action'],
				"L_EDIT" 			=> $lang['Edit'],
				"L_DELETE" 			=> $lang['Delete'],
				"L_SUBMIT" 			=> $lang['Submit'],
				"S_ITEMS_ACTION" 		=> append_sid("admin_adr_jobs.$phpEx"),
				"S_HIDDEN_FIELDS" 	=> $s_hidden_fields, 
			));

			$template->pparse("body");

		break;

		case "save_job":

			$job_id = ( !empty($HTTP_POST_VARS['job_id']) ) ? intval($HTTP_POST_VARS['job_id']) : intval($HTTP_GET_VARS['job_id']);

			$item_id = intval($HTTP_POST_VARS['item_reward_list']);
			$job_name = ( isset($HTTP_POST_VARS['job_name']) ) ? trim($HTTP_POST_VARS['job_name']) : trim($HTTP_GET_VARS['job_name']);
			$job_desc = ( isset($HTTP_POST_VARS['job_desc']) ) ? trim($HTTP_POST_VARS['job_desc']) : trim($HTTP_GET_VARS['job_desc']);
			$job_img = ( isset($HTTP_POST_VARS['job_img']) ) ? trim($HTTP_POST_VARS['job_img']) : trim($HTTP_GET_VARS['job_img']);
			$job_level = intval($HTTP_POST_VARS['job_level']);
			$job_auth_level = intval($HTTP_POST_VARS['job_auth_level']);
			$job_race = intval($HTTP_POST_VARS['race_list']);
			$job_class = intval($HTTP_POST_VARS['class_list']);
			$job_alignment = intval($HTTP_POST_VARS['alignment_list']);
			$job_salary = intval($HTTP_POST_VARS['job_salary']);
			$job_salary_int = intval($HTTP_POST_VARS['job_salary_int']);
			$job_sp_reward = intval($HTTP_POST_VARS['job_sp_reward']);
			$job_exp = intval($HTTP_POST_VARS['job_exp']);
			$job_duration = intval($HTTP_POST_VARS['job_duration']);
			$job_slots = intval($HTTP_POST_VARS['job_slots']);
			$job_slots_max = intval($HTTP_POST_VARS['job_slots_max']);

			if ($job_name == '' || !$job_level || !$job_salary || !$job_duration || $job_slots > $job_slots_max  )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "UPDATE " . ADR_JOB_TABLE . "
				SET 	job_name = '" . str_replace("\'", "''", $job_name) . "', 
					job_desc = '" . str_replace("\'", "''", $job_desc) . "', 
					job_img = '" . str_replace("\'", "''", $job_img) . "', 
					job_level = $job_level, 
					job_auth_level = $job_auth_level, 
					job_race_id = $job_race, 
					job_class_id = $job_class, 
					job_alignment_id = $job_alignment, 
					job_salary = $job_salary,
					job_payment_intervals = $job_salary_int,
					job_exp = $job_exp,
					job_item_reward_id = $item_id,
					job_sp_reward = $job_sp_reward,
					job_duration = $job_duration, 
					job_slots_available = $job_slots, 
					job_slots_max = $job_slots_max
				WHERE job_id = $job_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update job", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_job_successful_updated , admin_adr_jobs , '' );

		break;

		case "savenew_job":

			$job_id = ( !empty($HTTP_POST_VARS['job_id']) ) ? intval($HTTP_POST_VARS['job_id']) : intval($HTTP_GET_VARS['job_id']);

			$item_id = intval($HTTP_POST_VARS['item_reward_item']);
			$job_name = ( isset($HTTP_POST_VARS['job_name']) ) ? trim($HTTP_POST_VARS['job_name']) : trim($HTTP_GET_VARS['job_name']);
			$job_desc = ( isset($HTTP_POST_VARS['job_desc']) ) ? trim($HTTP_POST_VARS['job_desc']) : trim($HTTP_GET_VARS['job_desc']);
			$job_img = ( isset($HTTP_POST_VARS['job_img']) ) ? trim($HTTP_POST_VARS['job_img']) : trim($HTTP_GET_VARS['job_img']);
			$job_level = intval($HTTP_POST_VARS['job_level']);
			$job_auth_level = intval($HTTP_POST_VARS['job_auth_level']);
			$job_race = intval($HTTP_POST_VARS['race_list']);
			$job_class = intval($HTTP_POST_VARS['class_list']);
			$job_alignment = intval($HTTP_POST_VARS['alignment_list']);
			$job_salary = intval($HTTP_POST_VARS['job_salary']);
			$job_salary_int = intval($HTTP_POST_VARS['job_salary_int']);
			$job_exp = intval($HTTP_POST_VARS['job_exp']);
			$job_duration = intval($HTTP_POST_VARS['job_duration']);
			$job_slots = intval($HTTP_POST_VARS['job_slots']);
			$job_slots_max = intval($HTTP_POST_VARS['job_slots_max']);
			$job_sp_reward = intval($HTTP_POST_VARS['job_sp_reward']);

			if ($job_name == '' || !$job_level || !$job_salary )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "INSERT INTO " . ADR_JOB_TABLE . " 
				( job_name , job_desc , job_img , job_level , job_auth_level , job_race_id , job_class_id , job_alignment_id , job_salary , job_payment_intervals , job_exp , job_duration , job_slots_available , job_slots_max , job_sp_reward )
				VALUES ( '" . str_replace("\'", "''", $job_name) . "' , '" . str_replace("\'", "''", $job_desc) . "' , '" . str_replace("\'", "''", $job_img) . "' , '$job_level' , '$job_auth_level' , '$job_race' , '$job_class' , '$job_alignment' , '$job_salary' , '$job_salary_int' , '$job_exp' , '$job_duration' , '$job_slots' , '$job_slots_max' , '$job_sp_reward' )";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new job", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_job_successful_added , admin_adr_jobs , '' );

		break;

	}
}
else
{
	adr_template_file('admin/config_adr_jobs_list_body.tpl');

	$sql = "SELECT j.*, c.class_id, c.class_name, r.race_id, r.race_name, a.alignment_id, a.alignment_name FROM " . ADR_JOB_TABLE . " j
			LEFT JOIN " . ADR_CLASSES_TABLE . " c ON ( c.class_id = j.job_class_id )
			LEFT JOIN " . ADR_RACES_TABLE . " r ON ( r.race_id = j.job_race_id )
			LEFT JOIN " . ADR_ALIGNMENTS_TABLE . " a ON ( a.alignment_id = j.job_alignment_id )";
//		WHERE j.job_name <> 0 
//		$cat_sql
//		ORDER BY $order_by";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Error showing all job list' , "", __LINE__, __FILE__, $sql); 
	} 
	$jobs = $db->sql_fetchrowset($result);

	$s_hidden_fields = '<input type="hidden" name="mode" value="add_job" /><input type="hidden" name="item_type" value="' . $category_id . '" />';

	for($i = 0; $i < count($jobs); $i++)
	{
		// Grab item reward details
		$sql = " SELECT item_name FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_owner_id = 1
			AND item_id = '".$jobs[$i]['job_item_reward_id']."' ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query user stats page', '', __LINE__, __FILE__, $sql);
		}
		$item = $db->sql_fetchrow($result);

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2']; 
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2']; 

		$class = $jobs[$i]['job_class_id'] != 0 ? adr_get_lang($jobs[$i]['class_name']) : $lang['Adr_job_all_classes'];
		$race = $jobs[$i]['job_race_id'] != 0 ? adr_get_lang($jobs[$i]['race_name']) : $lang['Adr_job_all_classes'];
		$alignment = $jobs[$i]['job_alignment_id'] != 0 ? adr_get_lang($jobs[$i]['alignment_name']) : $lang['Adr_job_all_classes'];
		$image = $jobs[$i]['job_img'] != '' ? '<img src="../adr/images/jobs/'.$jobs[$i]['job_img'].'">' : '' ;
		$item_reward = $jobs[$i]['job_item_reward_id'] != 0 ? adr_get_lang($item['item_name']) : $lang['Adr_job_no_item_reward'];
		$interval_lang = $jobs[$i]['job_payment_intervals'] > 1 ? $lang['Adr_job_days'] : $lang['Adr_job_day'];
		$duration_lang = $jobs[$i]['job_duration'] > 1 ? $lang['Adr_job_days'] : $lang['Adr_job_day'];

		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars("jobs", array(
			"ROW_CLASS"		=> $row_class, 
			"JOB_ID"		=> $jobs[$i]['job_id'],
			"JOB_IMG"		=> $image,
			"JOB_NAME"		=> $jobs[$i]['job_name'],
			"JOB_DESC"		=> $jobs[$i]['job_desc'],
			"JOB_LEVEL"		=> $jobs[$i]['job_level'],
			"JOB_CLASS"		=> $class,
			"JOB_RACE"		=> $race,
			"JOB_ALIGNMENT"	=> $alignment,
			"JOB_SALARY"	=> number_format($jobs[$i]['job_salary']),
			'JOB_SALARY_INT'	=> number_format($jobs[$i]['job_payment_intervals']),
			'L_JOB_INT_LANG'	=> $interval_lang,
			"JOB_DURATION"	=> $jobs[$i]['job_duration'],
			'L_JOB_DURA_LANG' => $duration_lang,
			"JOB_SLOTS"		=> $jobs[$i]['job_slots_available'],
			"JOB_SLOTS_MAX"	=> $jobs[$i]['job_slots_max'],
			"JOB_EXP"		=> number_format($jobs[$i]['job_exp']),
			"JOB_SP_REWARD"	=> number_format($jobs[$i]['job_sp_reward']),
			"JOB_ITEM_REWARD"	=> $item_reward,
			"U_JOB_EDIT" 	=> append_sid("admin_adr_jobs.$phpEx?mode=edit_job&amp;job_id=" . $jobs[$i]['job_id']), 
			"U_JOB_DELETE" 	=> append_sid("admin_adr_jobs.$phpEx?mode=delete_job&amp;job_id=" . $jobs[$i]['job_id']),
		));
	}

	$sql = "SELECT count(*) AS total FROM " . ADR_JOB_TABLE ;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}
	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_jobs = $total['total'];
		$pagination = generate_pagination("admin_adr_jobs.$phpEx?mode2=$mode2&amp;order=$sort_order&amp;cat=$cat", $total_jobs, $board_config['topics_per_page'], $start). '&nbsp;';	
	}

	$template->assign_vars(array(
		"POINTS"			=> $board_config['points_name'],
		"L_ADD_JOB"			=> $lang['Adr_admin_job_add'],
		"L_JOB_TITLE"		=> $lang['Adr_job_title'],
		"L_JOB_NAME"		=> $lang['Adr_job_name'],
		"L_JOB_DESC"		=> $lang['Adr_job_desc'],
		"L_JOB_LEVEL"		=> $lang['Adr_job_level'],
		"L_JOB_RACE"		=> $lang['Adr_job_race'],
		"L_JOB_CLASS"		=> $lang['Adr_job_class'],
		"L_JOB_ALIGNMENT"		=> $lang['Adr_job_alignment'],
		"L_JOB_SALARY"		=> $lang['Adr_job_salary'],
		'L_JOB_SALARY_INT'	=> $lang['Adr_job_salary_intervals'],
		"L_JOB_DURATION"		=> $lang['Adr_job_duration'],
		"L_JOB_SLOTS"		=> $lang['Adr_job_slots'],
		"L_JOB_SLOTS_MAX"		=> $lang['Adr_job_slots_max'],
		"L_JOB_EXP"			=> $lang['Adr_job_exp'],
		"L_JOB_ITEM_REWARD"	=> $lang['Adr_job_item_reward'],
		"L_JOB_SP_REWARD"		=> $lang['Adr_job_sp_reward'],
		"L_ACTION"			=> $lang['Action'],
		"L_JOBS"			=> $lang['Adr_shops_categories_items'],
		"L_EDIT"			=> $lang['Edit'],
		"L_DELETE"			=> $lang['Delete'],
		"L_JOB_IMG"			=> $lang['Adr_races_image'],
		"L_JOB_PRICE"		=> $lang['Adr_items_price'],
		'L_SELECT_SORT_METHOD'	=> $lang['Select_sort_method'],
		'L_ORDER' 			=> $lang['Order'],
		'L_SORT' 			=> $lang['Sort'],
		'L_SUBMIT' 			=> $lang['Sort'],
		'L_GOTO_PAGE' 		=> $lang['Goto_page'],
		"L_GIVE" 			=> $lang['Adr_items_give'],
		"L_SELL" 			=> $lang['Adr_items_sell'],
		"L_EDIT" 			=> $lang['Adr_items_edit'],
		"L_SHOP" 			=> $lang['Adr_items_into_shop'],
		'L_SELECT_CAT' 		=> $lang['Adr_items_select'],
		'S_MODE_SELECT' 		=> $select_sort_mode,
		'S_ORDER_SELECT' 		=> $select_sort_order,
		'SELECT_CAT' 		=> $select_category,
		'PAGINATION' 		=> $pagination,
		'PAGE_NUMBER' 		=> sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_jobs / $board_config['topics_per_page'] )), 
		"S_JOB_ACTION" 		=> append_sid("admin_adr_jobs.$phpEx?mode2=$mode2&amp;order=$sort_order"),
		"S_HIDDEN_FIELDS" 	=> $s_hidden_fields, 
	));

	$template->pparse("body");
}

include('./page_footer_admin.'.$phpEx);

?>
