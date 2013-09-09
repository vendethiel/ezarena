<?php
/***************************************************************************
 *                              admin_rabbitoshi.php
 *                              -------------------
 *     begin                : Thurs June 9 2006
 *     copyright            : (C) 2006 The ADR Dev Crew
 *     site                 : http://www.adr-support.com
 *
 *     $Id: admin_rabbitoshi.php,v 4.00.0.00 2006/06/09 02:32:18 Ethalic Exp $
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

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Rabbitoshi']['Rabbitoshi_Pets_Management'] = $filename;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.'.$phpEx);
include($phpbb_root_path.'rabbitoshi/includes/functions_rabbitoshi.'.$phpEx);

$board_config['points_name'] = $board_config['points_name'] ? $board_config['points_name'] : $lang['Rabbitoshi_default_points_name'] ;

if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
}
else
{
	$mode = "";
}

if( isset($HTTP_POST_VARS['add']) || isset($HTTP_GET_VARS['add']) )
{
	rabbitoshi_template_file('admin/config_rabbitoshi_edit_body.tpl');

	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	$template->assign_block_vars( 'rabbitoshi_add', array());

	$rsql = "SELECT item_name
		FROM " . RABBITOSHI_SHOP_TABLE . "
		WHERE item_type = 1 
		ORDER by item_id";
	$rresult = $db->sql_query($rsql);
	if( !$rresult )
	{
		message_die(GENERAL_ERROR, 'Could not obtain pets information', "", __LINE__, __FILE__, $rsql);
	}
	$food_data = $db->sql_fetchrowset($rresult);
	for( $i = 0; $i < count($food_data); $i++ )
	{
		$food_favorite = isset($lang[$food_data[$i]['item_name']]) ? $lang[$food_data[$i]['item_name']] : $food_data[$i]['item_name'];
		$type = $i + 1;
		$filename_list .= '<option value = "'.$type.'" >' . $food_favorite . '</option>';
	}

	$esql = "SELECT creature_id , creature_name
		FROM " . RABBITOSHI_CONFIG_TABLE . "
		ORDER by creature_id";
	$eresult = $db->sql_query($esql);
	if( !$eresult )
	{
		message_die(GENERAL_ERROR, 'Could not obtain pets information', "", __LINE__, __FILE__, $esql);
	}
	$pets = $db->sql_fetchrowset($eresult);

	$pets_list = '<option value = 0 >' . $lang['Rabbitoshi_is_evolution_of_none'] . '</option>';
	for( $i = 0; $i < count($pets); $i++ )
	{
		$pets_list .= '<option value = "'.$pets[$i]['creature_id'].'" >' . $pets[$i]['creature_name'] . '</option>';
	}


	$template->assign_vars(array(
		"L_RABBITOSHI_TITLE" => $lang['Rabbitoshi_manage_title'],
		"L_RABBITOSHI_CONFIG" => $lang['Rabbitoshi_config'],
		"L_RABBITOSHI_EXPLAIN" => $lang['Rabbitoshi_desc'],
		"L_RABBITOSHI_NAME" => $lang['Rabbitoshi_name'],
		"L_RABBITOSHI_PRIZE" => $lang['Rabbitoshi_pet_prize'],
		"L_RABBITOSHI_RHEALTH" => $lang['Rabbitoshi_pet_health'],
		"L_RABBITOSHI_RTHIRST" => $lang['Rabbitoshi_pet_thirst'],
		"L_RABBITOSHI_RFOOD" => $lang['Rabbitoshi_pet_hunger'],
		"L_RABBITOSHI_RDIRT" => $lang['Rabbitoshi_pet_hygiene'],
		"L_RABBITOSHI_MP" => $lang['Rabbitoshi_pet_mp'],
		"L_RABBITOSHI_POWER" => $lang['Rabbitoshi_pet_power'],
		"L_RABBITOSHI_MAGICPOWER" => $lang['Rabbitoshi_pet_magicpower'],
		"L_RABBITOSHI_ARMOR" => $lang['Rabbitoshi_pet_armor'],
		"L_RABBITOSHI_ATTACK" => $lang['Rabbitoshi_pet_ratioattack'],
		"L_RABBITOSHI_MAGICATTACK" => $lang['Rabbitoshi_pet_ratiomagic'],
		"L_RABBITOSHI_EXPERIENCE" => $lang['Rabbitoshi_pet_experience_limit'],
		"L_RABBITOSHI_FOOD_TYPE" => $lang['Rabbitoshi_food_type'],
		"L_RABBITOSHI_IMG" => $lang['Rabbitoshi_img'],
		"L_RABBITOSHI_IMG_EXPLAIN" => $lang['Rabbitoshi_img_explain'],
		"L_IMG_EXPLAIN" => $lang['Rabbitoshi_img_explain'],
		"L_SUBMIT" => $lang['Submit'],
		"L_RESET" => $lang['Reset'],
		"L_EVOLUTION" => $lang['Rabbitoshi_is_evolution_of'],
		"L_BUYABLE" => $lang['Rabbitoshi_buyable'],
		"L_RABBITOSHI_BUYABLE_EXPLAIN" => $lang['Rabbitoshi_buyable_explain'],
		"L_RABBITOSHI_EVOLUTION_OF_EXPLAIN" => $lang['Rabbitoshi_is_evolution_of_explain'],
		"L_POINTS" => $board_config['points_name'],
		"RABBITOSHI_FOOD_TYPE" => $filename_list,
		"RABBITOSHI_EVOLUTION_OF" => $pets_list,
		"S_RABBITOSHI_ACTION" => append_sid("admin_rabbitoshi.$phpEx"), 
		"S_HIDDEN_FIELDS" => $s_hidden_fields) 
	);

	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}
else if ( $mode != "" )
{
	switch( $mode )
	{
		case 'delete':

			$creature_id = ( !empty($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];

			$sql = "DELETE FROM " . RABBITOSHI_CONFIG_TABLE . "
				WHERE creature_id = " . $creature_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete pet", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . RABBITOSHI_USERS_TABLE . "
				WHERE owner_creature_id = " . $creature_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete pet", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Rabbitoshi_del_success'] . "<br /><br />" . sprintf($lang['Click_return_rabbitoshiadmin'], "<a href=\"" . append_sid("admin_rabbitoshi.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
			break;

		case 'edit':

			$creature_id = ( !empty($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];

			$sql = "SELECT *
				FROM " . RABBITOSHI_CONFIG_TABLE . "
				WHERE creature_id = " . $creature_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain pets information', "", __LINE__, __FILE__, $sql);
			}
			$field_data = $db->sql_fetchrow($result);

			$rsql = "SELECT item_name , item_id
				FROM " . RABBITOSHI_SHOP_TABLE . "
				WHERE item_type = 1 
				ORDER by item_id";
			$rresult = $db->sql_query($rsql);
			if( !$rresult )
			{
				message_die(GENERAL_ERROR, 'Could not obtain pets information', "", __LINE__, __FILE__, $rsql);
			}
			$food_data = $db->sql_fetchrowset($rresult);
			for( $i = 0; $i < count($food_data); $i++ )
			{
				$food_favorite = isset($lang[$food_data[$i]['item_name']]) ? $lang[$food_data[$i]['item_name']] : $food_data[$i]['item_name'];
				$selected = ( $field_data['creature_food_id'] == $food_data[$i]['item_id'] ) ? ' selected="selected"' : '';
				$filename_list .= '<option value = "'.$food_data[$i]['item_id'].'" '.$selected.' >' . $food_favorite . '</option>';
			}

			$esql = "SELECT creature_id , creature_name
				FROM " . RABBITOSHI_CONFIG_TABLE . "
				ORDER by creature_id";
			$eresult = $db->sql_query($esql);
			if( !$eresult )
			{
				message_die(GENERAL_ERROR, 'Could not obtain pets information', "", __LINE__, __FILE__, $esql);
			}
			$pets = $db->sql_fetchrowset($eresult);

			$pets_list = '<option value = 0 >' . $lang['Rabbitoshi_is_evolution_of_none'] . '</option>';
			for( $i = 0; $i < count($pets); $i++ )
			{
				$selected = ( $field_data['creature_evolution_of'] == $pets[$i]['creature_id'] ) ? ' selected="selected"' : '';
				$pets_list .= '<option value = "'.$pets[$i]['creature_id'].'" '.$selected.' >' . $pets[$i]['creature_name'] . '</option>';
			}

			rabbitoshi_template_file('admin/config_rabbitoshi_edit_body.tpl');

			$template->assign_block_vars( 'rabbitoshi_edit', array());

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="creature_id" value="' . $field_data['creature_id'] . '" />';

			$pic = $field_data['creature_img'];
			if (!(file_exists("../rabbitoshi/images/pets/$pic")) || !$pic )
			{
				$pic = $field_data['creature_name'].'.gif';
			}
			$creature_name = isset($lang[$field_data['creature_name']]) ? $lang[$field_data['creature_name']] : $field_data['creature_name'];

			$template->assign_vars(array(
				"RABBITOSHI_NAME" => $field_data['creature_name'],
				"RABBITOSHI_NAME_EXPLAIN" => '('.$creature_name.')',
				"RABBITOSHI_IMG" =>  $field_data['creature_img'],
				"RABBITOSHI_IMG_EX" =>  $pic ,
				"RABBITOSHI_PRIZE" => $field_data['creature_prize'],
				"RABBITOSHI_RHEALTH" => $field_data['creature_max_hunger'],
				"RABBITOSHI_RTHIRST" => $field_data['creature_max_thirst'],
				"RABBITOSHI_RFOOD" => $field_data['creature_max_hunger'],
				"RABBITOSHI_RDIRT" => $field_data['creature_max_hygiene'],
				"RABBITOSHI_MP" => $field_data['creature_mp_max'],
				"RABBITOSHI_POWER" => $field_data['creature_power'],
				"RABBITOSHI_MAGICPOWER" => $field_data['creature_magicpower'],
				"RABBITOSHI_ARMOR" => $field_data['creature_armor'],
				"RABBITOSHI_ATTACK" => $field_data['creature_max_attack'],
				"RABBITOSHI_MAGICATTACK" => $field_data['creature_max_magicattack'],
				"RABBITOSHI_EXPERIENCE" => $field_data['creature_experience_max'],
				"RABBITOSHI_FOOD_TYPE" => $filename_list,
				"RABBITOSHI_EVOLUTION_OF" => $pets_list,
				"RABBITOSHI_BUYABLE_CHECKED" => ( $field_data['creature_buyable'] ? checked : '' ),
				"L_POINTS" => $board_config['points_name'],
				"L_RABBITOSHI_TITLE" => $lang['Rabbitoshi_manage_title'],
				"L_RABBITOSHI_CONFIG" => $lang['Rabbitoshi_config'],
				"L_RABBITOSHI_EXPLAIN" => $lang['Rabbitoshi_desc'],
				"L_RABBITOSHI_NAME" => $lang['Rabbitoshi_name'],
				"L_RABBITOSHI_PRIZE" => $lang['Rabbitoshi_pet_prize'],
				"L_RABBITOSHI_RHEALTH" => $lang['Rabbitoshi_pet_health'],
				"L_RABBITOSHI_RTHIRST" => $lang['Rabbitoshi_pet_thirst'],
				"L_RABBITOSHI_RFOOD" => $lang['Rabbitoshi_pet_hunger'],
				"L_RABBITOSHI_RDIRT" => $lang['Rabbitoshi_pet_hygiene'],
				"L_RABBITOSHI_MP" => $lang['Rabbitoshi_pet_mp'],
				"L_RABBITOSHI_POWER" => $lang['Rabbitoshi_pet_power'],
				"L_RABBITOSHI_MAGICPOWER" => $lang['Rabbitoshi_pet_magicpower'],
				"L_RABBITOSHI_ARMOR" => $lang['Rabbitoshi_pet_armor'],
				"L_RABBITOSHI_ATTACK" => $lang['Rabbitoshi_pet_ratioattack'],
				"L_RABBITOSHI_MAGICATTACK" => $lang['Rabbitoshi_pet_ratiomagic'],
				"L_RABBITOSHI_EXPERIENCE" => $lang['Rabbitoshi_pet_experience_limit'],
				"L_RABBITOSHI_FOOD_TYPE" => $lang['Rabbitoshi_food_type'],
				"L_RABBITOSHI_IMG" => $lang['Rabbitoshi_img'],
				"L_RABBITOSHI_IMG_EXPLAIN" => $lang['Rabbitoshi_img_explain'],
				"L_EVOLUTION" => $lang['Rabbitoshi_is_evolution_of'],
				"L_BUYABLE" => $lang['Rabbitoshi_buyable'],
				"L_RABBITOSHI_BUYABLE_EXPLAIN" => $lang['Rabbitoshi_buyable_explain'],
				"L_RABBITOSHI_EVOLUTION_OF_EXPLAIN" => $lang['Rabbitoshi_is_evolution_of_explain'],
				"L_IMG_EXPLAIN" => $lang['Rabbitoshi_img_explain'],
				"L_SUBMIT" => $lang['Submit'],
				"L_RESET" => $lang['Reset'],
				"L_TRANSLATOR" => $lang['Rabbitoshi_translation'],
				"S_RABBITOSHI_ACTION" => append_sid("admin_rabbitoshi.$phpEx"), 
				"S_HIDDEN_FIELDS" => $s_hidden_fields) 
			);

			$template->pparse("body");
                        include('./page_footer_admin.'.$phpEx);
			break;

		case "save":

			$creature_id = ( !empty($HTTP_POST_VARS['creature_id']) ) ? $HTTP_POST_VARS['creature_id'] : $HTTP_GET_VARS['creature_id'];

			$creature_name = ( isset($HTTP_POST_VARS['creature_name']) ) ? trim($HTTP_POST_VARS['creature_name']) : trim($HTTP_GET_VARS['creature_name']);
			$creature_img = ( isset($HTTP_POST_VARS['creature_img']) ) ? trim($HTTP_POST_VARS['creature_img']) : trim($HTTP_GET_VARS['creature_img']);
			$creature_prize = ( isset($HTTP_POST_VARS['prize']) ) ? trim($HTTP_POST_VARS['prize']) : trim($HTTP_GET_VARS['prize']);
			$creature_max_hunger = ( isset($HTTP_POST_VARS['rfood']) ) ? trim($HTTP_POST_VARS['rfood']) : trim($HTTP_GET_VARS['rfood']);
			$creature_max_thirst = ( isset($HTTP_POST_VARS['rthirst']) ) ? trim($HTTP_POST_VARS['rthirst']) : trim($HTTP_GET_VARS['rthirst']);
			$creature_max_health = ( isset($HTTP_POST_VARS['rhealth']) ) ? trim($HTTP_POST_VARS['rhealth']) : trim($HTTP_GET_VARS['rhealth']);
			$creature_max_hygiene = ( isset($HTTP_POST_VARS['rdirt']) ) ? trim($HTTP_POST_VARS['rdirt']) : trim($HTTP_GET_VARS['rdirt']);
			$creature_mp_max = ( isset($HTTP_POST_VARS['mp']) ) ? trim($HTTP_POST_VARS['mp']) : trim($HTTP_GET_VARS['mp']);
			$creature_power = ( isset($HTTP_POST_VARS['power']) ) ? trim($HTTP_POST_VARS['power']) : trim($HTTP_GET_VARS['power']);
			$creature_magicpower = ( isset($HTTP_POST_VARS['magicpower']) ) ? trim($HTTP_POST_VARS['magicpower']) : trim($HTTP_GET_VARS['magicpower']);
			$creature_armor = ( isset($HTTP_POST_VARS['armor']) ) ? trim($HTTP_POST_VARS['armor']) : trim($HTTP_GET_VARS['armor']);
			$creature_attack = ( isset($HTTP_POST_VARS['attack']) ) ? trim($HTTP_POST_VARS['attack']) : trim($HTTP_GET_VARS['attack']);
			$creature_magicattack = ( isset($HTTP_POST_VARS['magicattack']) ) ? trim($HTTP_POST_VARS['magicattack']) : trim($HTTP_GET_VARS['magicattack']);
			$creature_experience = ( isset($HTTP_POST_VARS['experience']) ) ? trim($HTTP_POST_VARS['experience']) : trim($HTTP_GET_VARS['experience']);
			$creature_food_id = ( isset($HTTP_POST_VARS['food_type']) ) ? trim($HTTP_POST_VARS['food_type']) : trim($HTTP_GET_VARS['food_type']);
			$buyable = ( isset($HTTP_POST_VARS['buyable']) ) ? trim($HTTP_POST_VARS['buyable']) : trim($HTTP_GET_VARS['buyable']);
			$evolution_of = ( isset($HTTP_POST_VARS['evolution_of']) ) ? trim($HTTP_POST_VARS['evolution_of']) : trim($HTTP_GET_VARS['evolution_of']);

			if ($creature_name == '' || $creature_prize == '' || $creature_max_hunger == '' || $creature_max_thirst == '' || $creature_max_health == '' || $creature_max_hygiene == '' || $creature_mp_max == '' || $creature_power == '' || $creature_magicpower == '' || $creature_armor == '' || $creature_attack == '' || $creature_magicattack == '' || $creature_experience == '' || $creature_food_id == '')
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "UPDATE " . RABBITOSHI_CONFIG_TABLE . "
				SET creature_name = '" . str_replace("\'", "''", $creature_name) . "',
				    creature_img = '" . str_replace("\'", "''", $creature_img) . "',
				    creature_prize = '" . str_replace("\'", "''", $creature_prize) . "',
				    creature_max_hunger = '" . str_replace("\'", "''", $creature_max_hunger) . "',
				    creature_max_thirst = '" . str_replace("\'", "''", $creature_max_thirst) . "',
				    creature_max_health = '" . str_replace("\'", "''", $creature_max_health) . "',
				    creature_max_hygiene = '" . str_replace("\'", "''", $creature_max_hygiene) . "',
				    creature_mp_max = '" . str_replace("\'", "''", $creature_mp_max) . "',
				    creature_power = '" . str_replace("\'", "''", $creature_power) . "',
				    creature_magicpower = '" . str_replace("\'", "''", $creature_magicpower) . "',
				    creature_armor = '" . str_replace("\'", "''", $creature_armor) . "',
				    creature_max_attack = '" . str_replace("\'", "''", $creature_attack) . "',
				    creature_max_magicattack = '" . str_replace("\'", "''", $creature_magicattack) . "',
				    creature_experience_max = '" . str_replace("\'", "''", $creature_experience) . "',
				    creature_food_id = '" . str_replace("\'", "''", $creature_food_id) . "',
				    creature_buyable = '" . str_replace("\'", "''", $buyable) . "',
				    creature_evolution_of = '" . str_replace("\'", "''", $evolution_of) . "'					
				WHERE creature_id = " . $creature_id;
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update pets info", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Rabbitoshi_edit_success'] . "<br /><br />" . sprintf($lang['Click_return_rabbitoshiadmin'], "<a href=\"" . append_sid("admin_rabbitoshi.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
			break;

		case "savenew":

			$sql = "SELECT *
			FROM " . RABBITOSHI_CONFIG_TABLE ."
			ORDER BY creature_id 
			DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain pets information', "", __LINE__, __FILE__, $sql);
			}
			$fields_data = $db->sql_fetchrow($result);

			$creature_name = ( isset($HTTP_POST_VARS['creature_name']) ) ? trim($HTTP_POST_VARS['creature_name']) : trim($HTTP_GET_VARS['creature_name']);
			$creature_img = ( isset($HTTP_POST_VARS['creature_img']) ) ? trim($HTTP_POST_VARS['creature_img']) : trim($HTTP_GET_VARS['creature_img']);
			$creature_prize = ( isset($HTTP_POST_VARS['prize']) ) ? trim($HTTP_POST_VARS['prize']) : trim($HTTP_GET_VARS['prize']);
			$creature_max_hunger = ( isset($HTTP_POST_VARS['rfood']) ) ? trim($HTTP_POST_VARS['rfood']) : trim($HTTP_GET_VARS['rfood']);
			$creature_max_thirst = ( isset($HTTP_POST_VARS['rthirst']) ) ? trim($HTTP_POST_VARS['rthirst']) : trim($HTTP_GET_VARS['rthirst']);
			$creature_max_health = ( isset($HTTP_POST_VARS['rhealth']) ) ? trim($HTTP_POST_VARS['rhealth']) : trim($HTTP_GET_VARS['rhealth']);
			$creature_max_hygiene = ( isset($HTTP_POST_VARS['rdirt']) ) ? trim($HTTP_POST_VARS['rdirt']) : trim($HTTP_GET_VARS['rdirt']);
			$creature_mp_max = ( isset($HTTP_POST_VARS['mp']) ) ? trim($HTTP_POST_VARS['mp']) : trim($HTTP_GET_VARS['mp']);
			$creature_power = ( isset($HTTP_POST_VARS['power']) ) ? trim($HTTP_POST_VARS['power']) : trim($HTTP_GET_VARS['power']);
			$creature_magicpower = ( isset($HTTP_POST_VARS['magicpower']) ) ? trim($HTTP_POST_VARS['magicpower']) : trim($HTTP_GET_VARS['magicpower']);
			$creature_armor = ( isset($HTTP_POST_VARS['armor']) ) ? trim($HTTP_POST_VARS['armor']) : trim($HTTP_GET_VARS['armor']);
			$creature_attack = ( isset($HTTP_POST_VARS['attack']) ) ? trim($HTTP_POST_VARS['attack']) : trim($HTTP_GET_VARS['attack']);
			$creature_magicattack = ( isset($HTTP_POST_VARS['magicattack']) ) ? trim($HTTP_POST_VARS['magicattack']) : trim($HTTP_GET_VARS['magicattack']);
			$creature_experience = ( isset($HTTP_POST_VARS['experience']) ) ? trim($HTTP_POST_VARS['experience']) : trim($HTTP_GET_VARS['experience']);
			$creature_food_id = ( isset($HTTP_POST_VARS['food_type']) ) ? trim($HTTP_POST_VARS['food_type']) : trim($HTTP_GET_VARS['food_type']);
			$buyable = ( isset($HTTP_POST_VARS['buyable']) ) ? trim($HTTP_POST_VARS['buyable']) : trim($HTTP_GET_VARS['buyable']);
			$evolution_of = ( isset($HTTP_POST_VARS['evolution_of']) ) ? trim($HTTP_POST_VARS['evolution_of']) : trim($HTTP_GET_VARS['evolution_of']);
			$creature_id = $fields_data['creature_id'] +1;

			if ($creature_name == '' || $creature_img == '' || $creature_prize == '' || $creature_max_hunger == '' || $creature_max_thirst == '' || $creature_max_health == '' || $creature_max_hygiene == '' || $creature_mp_max == '' || $creature_power == '' || $creature_magicpower == '' || $creature_armor == '' || $creature_attack == '' || $creature_magicattack == '' || $creature_experience == '' || $creature_food_id == '')
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "INSERT INTO " . RABBITOSHI_CONFIG_TABLE . " (creature_id, creature_name , creature_img , creature_prize , creature_max_hunger , creature_max_thirst , creature_max_health , creature_max_hygiene , creature_mp_max , creature_power , creature_magicpower , creature_armor , creature_food_id , creature_buyable , creature_evolution_of, creature_experience_max, creature_max_attack, creature_max_magicattack)
				VALUES ( $creature_id,'" . str_replace("\'", "''", $creature_name) . "' ,'" . str_replace("\'", "''", $creature_img) . "', '" . str_replace("\'", "''", $creature_prize) . "',  '" . str_replace("\'", "''", $creature_max_hunger) . "',   '" . str_replace("\'", "''", $creature_max_thirst) . "',  '" . str_replace("\'", "''", $creature_max_health) . "',  '" . str_replace("\'", "''", $creature_max_hygiene) . "',  '" . str_replace("\'", "''", $creature_mp_max) . "', '" . str_replace("\'", "''", $creature_power) . "', '" . str_replace("\'", "''", $creature_magicpower) . "', '" . str_replace("\'", "''", $creature_armor) . "','" . str_replace("\'", "''", $creature_food_id) . "',  '" . str_replace("\'", "''", $buyable) . "',  '" . str_replace("\'", "''", $evolution_of) . "' ,  '" . str_replace("\'", "''", $creature_experience) . "' , '" . str_replace("\'", "''", $creature_attack) . "' , '" . str_replace("\'", "''", $creature_magicattack) . "' )";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new pet", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Rabbitoshi_add_success'] . "<br /><br />" . sprintf($lang['Click_return_rabbitoshiadmin'], "<a href=\"" . append_sid("admin_rabbitoshi.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
			break;
	}
}
else
{

	$sql = "SELECT *
		FROM " . RABBITOSHI_CONFIG_TABLE ."
		ORDER BY creature_id";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain rabbitoshis from database", "", __LINE__, __FILE__, $sql);
	}
	$rabbitoshi = $db->sql_fetchrowset($result);

	rabbitoshi_template_file('admin/config_rabbitoshi_list_body.tpl');

	for($i = 0; $i < count($rabbitoshi); $i++)
	{
		$rsql = "SELECT item_name
			FROM " . RABBITOSHI_SHOP_TABLE . "
			WHERE item_id = ".$rabbitoshi[$i]['creature_food_id'];
		$rresult = $db->sql_query($rsql);
		if( !$rresult )
		{
			message_die(GENERAL_ERROR, 'Could not obtain pets information', "", __LINE__, __FILE__, $rsql);
		}
		$food_type = $db->sql_fetchrow($rresult);

		$esql = "SELECT creature_name
			FROM " . RABBITOSHI_CONFIG_TABLE . "
			WHERE creature_id = ".$rabbitoshi[$i]['creature_evolution_of'];
		$eresult = $db->sql_query($esql);
		if( !$eresult )
		{
			message_die(GENERAL_ERROR, 'Could not obtain pets information', "", __LINE__, __FILE__, $esql);
		}
		$evo = $db->sql_fetchrow($eresult);
		$evolution_of = $evo['creature_name'];

		$buyable = ( $rabbitoshi[$i]['creature_buyable'] ) ? $lang['Yes'] : $lang['No'];
		$evolution = ( $rabbitoshi[$i]['creature_evolution_of'] ) ? sprintf($evolution_of) : $lang['No'];

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$creature_name = isset($lang[$rabbitoshi[$i]['creature_name']]) ? $lang[$rabbitoshi[$i]['creature_name']] : $rabbitoshi[$i]['creature_name'];
		$favorite_food = isset($lang[$food_type['item_name']]) ? $lang[$food_type['item_name']] : $food_type['item_name'];

		$pic = $rabbitoshi[$i]['creature_img'];
		if (!(file_exists("../rabbitoshi/images/pets/$pic"))|| !$pic )
		{
			$pic = $rabbitoshi[$i]['creature_name'].'.gif';
		}
		$template->assign_block_vars("rabbitoshi", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"EVOLUTION" => $evolution ,
			"BUYABLE" => $buyable,
			"NAME" =>  $creature_name ,
			"IMG" =>  $pic , 
			"PRICE" =>  $rabbitoshi[$i]['creature_prize'],
			"RFOOD" =>  $rabbitoshi[$i]['creature_max_hunger'],
			"RTHIRST" =>  $rabbitoshi[$i]['creature_max_thirst'],
			"RHEALTH" =>  $rabbitoshi[$i]['creature_max_health'],
			"RDIRT" =>  $rabbitoshi[$i]['creature_max_hygiene'],
			"MP" =>  $rabbitoshi[$i]['creature_mp_max'],
			"POWER" =>  $rabbitoshi[$i]['creature_power'],
			"MAGICPOWER" =>  $rabbitoshi[$i]['creature_magicpower'],
			"ARMOR" =>  $rabbitoshi[$i]['creature_armor'],
			"ATTACK" =>  $rabbitoshi[$i]['creature_max_attack'],
			"MAGICATTACK" =>  $rabbitoshi[$i]['creature_max_magicattack'],
			"EXPERIENCE" =>  $rabbitoshi[$i]['creature_experience_max'],
			"FOOD_TYPE" =>  $favorite_food,
			"U_RABBITOSHI_EDIT" => append_sid("admin_rabbitoshi.$phpEx?mode=edit&amp;id=" . $rabbitoshi[$i]['creature_id']), 
			"U_RABBITOSHI_DELETE" => append_sid("admin_rabbitoshi.$phpEx?mode=delete&amp;id=" . $rabbitoshi[$i]['creature_id']))
		);
	}


	$template->assign_vars(array(
		"L_ACTION" => $lang['Action'],
		"L_RABBITOSHI_TITLE" => $lang['Rabbitoshi_manage_title'],
		"L_RABBITOSHI_TEXT" => $lang['Rabbitoshi_desc'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		"L_SUBMIT" => $lang['Submit'],
		"L_RABBITOSHI_ADD" => $lang['Rabbitoshi_add'],
		"L_NAME" => $lang['Rabbitoshi_name'],
		"L_IMG" => $lang['Rabbitoshi_img'],
		"L_RHEALTH" => $lang['Rabbitoshi_pet_health'],
		"L_PRICE" => $lang['Rabbitoshi_pet_prize'],
		"L_RFOOD" => $lang['Rabbitoshi_pet_hunger'],
		"L_RTHIRST" => $lang['Rabbitoshi_pet_thirst'],
		"L_RDIRT" => $lang['Rabbitoshi_pet_hygiene'],
		"L_FOOD_TYPE" => $lang['Rabbitoshi_food_type'],
		"L_MP"  => $lang['Rabbitoshi_pet_mp'],
		"L_POWER"  => $lang['Rabbitoshi_pet_power'],
		"L_MAGICPOWER" => $lang['Rabbitoshi_pet_magicpower'],
		"L_ARMOR"  => $lang['Rabbitoshi_pet_armor'],
		"L_MAGICATTACK"  => $lang['Rabbitoshi_battle_pet_magicattack'],
		"L_ATTACK"  => $lang['Rabbitoshi_battle_pet_attack'],
		"L_EXPERIENCE" => $lang['Rabbitoshi_pet_xp'],
		"S_HIDDEN_FIELDS" => $s_hidden_fields, 
		"L_YES" => $lang['Yes'],
		"L_NO" => $lang['No'],
		"L_EVOLUTION" => $lang['Rabbitoshi_is_evolution_of'],
		"L_BUYABLE" => $lang['Rabbitoshi_buyable'],
		"L_RABBITOSHI_BUYABLE_EXPLAIN" => $lang['Rabbitoshi_buyable_explain'],
		"L_RABBITOSHI_EVOLUTION_OF_EXPLAIN" => $lang['Rabbitoshi_is_evolution_of_explain'],
		"L_TRANSLATOR" => $lang['Rabbitoshi_translation'],
		"S_RABBITOSHI_ACTION" => append_sid("admin_rabbitoshi.$phpEx"))
	);

	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}

?>