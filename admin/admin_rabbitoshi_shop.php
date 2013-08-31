<?php
/***************************************************************************
*                               admin_rabbitoshi_shop.php
*                              -------------------
*     begin                : 27/11/2003
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

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Rabbitoshi']['Rabbitoshi_Shop'] = $filename;

	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_rabbitoshi.'.$phpEx);
$board_config['points_name'] = $board_config['points_name'] ? $board_config['points_name'] : $lang['Rabbitoshi_default_points_name'] ;

$template->set_filenames(array(
	"body" => "admin/config_rabbitoshi_shop_body.tpl")
);

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
	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	$template->assign_block_vars( 'add', array());

	$type_list ='<select name="item_type">';
	$type_list .= '<option value = "1" >' . $lang['Rabbitoshi_item_type_food'] . '</option>';
	$type_list .= '<option value = "2" >' . $lang['Rabbitoshi_item_type_water'] . '</option>';
	$type_list .= '<option value = "3" >' . $lang['Rabbitoshi_item_type_misc'] . '</option>';
	$type_list .='</select>';

	$template->assign_vars(array(
		"ITEM_TYPE" => $type_list,
		"L_POINTS" => $board_config['points_name'],
		"L_ITEM_NAME_EXPLAIN" => $lang['Rabbitoshi_language_key'],
		"L_ITEM_DESC_EXPLAIN" => $lang['Rabbitoshi_language_key'],
		"L_ITEM_IMG_EXPLAIN" => $lang['Rabbitoshi_img_item_explain'],
		"L_RABBITOSHI_TITLE" => $lang['Rabbitoshi_shop_title_add'],
		"L_RABBITOSHI_TEXT" => $lang['Rabbitoshi_shop_config_add'],
		"L_ITEM_NAME" => $lang['Rabbitoshi_shop_name'],
		"L_ITEM_PRIZE" => $lang['Rabbitoshi_shop_prize'],
		"L_ITEM_TYPE" => $lang['Rabbitoshi_shop_type'],
		"L_ITEM_DESC" => $lang['Rabbitoshi_item_desc'],
		"L_ITEM_IMG" => $lang['Rabbitoshi_shop_img'],
		"L_ITEM_POWER" => $lang['Rabbitoshi_shop_power'],
		"L_ITEM_POWER_EXPLAIN" => $lang['Rabbitoshi_shop_power_explain'],
		"L_SUBMIT" => $lang['Submit'],
		"S_RABBITOSHI_ACTION" => append_sid("admin_rabbitoshi_shop.$phpEx"), 
		"S_HIDDEN_FIELDS" => $s_hidden_fields) 
	);
}

else  
{ 
	switch( $mode ) 
	{
		case 'delete':

			$item_id = ( !empty($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];

			$sql = "SELECT * FROM " . RABBITOSHI_SHOP_USERS_TABLE . "
				WHERE item_id = " . $item_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete item", "", __LINE__, __FILE__, $sql);
			}
			$users = $db->sql_fetchrowset($result);
			for ( $i = 0 ; $i < count ( $users ) ; $i ++ )
			{
				$ssql = "SELECT item_prize FROM " . RABBITOSHI_SHOP_TABLE . "
					WHERE item_id = " . $item_id;
				$sresult = $db->sql_query($ssql);
				if( !$sresult )
				{
					message_die(GENERAL_ERROR, "Couldn't delete item", "", __LINE__, __FILE__, $ssql);
				}
				$prize = $db->sql_fetchrow($sresult);
				$price = $prize['item_prize'] * $users[$i]['item_amount'];
				$usql = "UPDATE " . USERS_TABLE . "
					SET user_points = user_points + $price 
					WHERE user_id =  ".$users[$i]['user_id'];
				$uresult = $db->sql_query($usql);
				if( !$uresult )
				{
					message_die(GENERAL_ERROR, "Couldn't delete item", "", __LINE__, __FILE__, $usql);
				}
			}

			$sql = "DELETE FROM " . RABBITOSHI_SHOP_USERS_TABLE . " 
 				WHERE item_id = " . $item_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete item", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . RABBITOSHI_SHOP_TABLE . "
				WHERE item_id = " . $item_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete item", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Rabbitoshi_shop_del_success'] . "<br /><br />" . sprintf($lang['Click_return_rabbitoshi_shopadmin'], "<a href=\"" . append_sid("admin_rabbitoshi_shop.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
			break;

		case 'edit':

			$template->assign_block_vars( 'edit', array());
			$item_id = ( !empty($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];

			$sql = "SELECT *
				FROM " . RABBITOSHI_SHOP_TABLE . "
				WHERE item_id = " . $item_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items pets information', "", __LINE__, __FILE__, $sql);
			}
			$field_data = $db->sql_fetchrow($result);
		
			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="item_id" value="' . $field_data['item_id'] . '" />';

			$food[1] =  $lang['Rabbitoshi_item_type_food'];
			$food[2] =  $lang['Rabbitoshi_item_type_water'];
			$food[3] =  $lang['Rabbitoshi_item_type_misc'];
			$type_list ='<select name="item_type">';
			for ( $p = 1 ; $p < 4 ; $p++)
			{
				$selected = ( $field_data['item_type'] == $p ) ? ' selected="selected"' : '';
				$type_list .= '<option value = "'.$p.'" '.$selected.'>' . $food[$p] . '</option>';
			}
			$type_list .='</select>';
			$item_desc = isset($lang[$field_data['item_desc']]) ? $lang[$field_data['item_desc']] : $field_data['item_desc'];
			$item_name = isset($lang[$field_data['item_name']]) ? $lang[$field_data['item_name']] : $field_data['item_name'];

			$pic = $field_data['item_img'];
			if (!(file_exists("images/Rabbitoshi/$pic")) || !$pic )
			{
				$pic = $field_data['item_name'].'.gif';
			}

			$template->assign_vars(array(
				"ITEM_NAME" => $field_data['item_name'],
				"ITEM_NAME_EXPLAIN" => $item_name,
				"ITEM_IMG" => $pic,
				"ITEM_PRIZE" => $field_data['item_prize'],
				"ITEM_TYPE" => $type_list,
				"ITEM_DESC" => $field_data['item_desc'],
				"ITEM_DESC_EXPLAIN" => $item_desc,
				"ITEM_POWER" => $field_data['item_power'],
				"L_POINTS" => $board_config['points_name'],
				"L_ITEM_NAME_EXPLAIN" => $lang['Rabbitoshi_language_key'],
				"L_ITEM_DESC_EXPLAIN" => $lang['Rabbitoshi_language_key'],
				"L_ITEM_IMG_EXPLAIN" => $lang['Rabbitoshi_img_item_explain'],
				"L_RABBITOSHI_TITLE" => $lang['Rabbitoshi_shop_title'],
				"L_RABBITOSHI_CONFIG" => $lang['Rabbitoshi_shop_config'],
				"L_RABBITOSHI_EXPLAIN" => $lang['Rabbitoshi_shop_desc'],
				"L_ITEM_NAME" => $lang['Rabbitoshi_shop_name'],
				"L_ITEM_PRIZE" => $lang['Rabbitoshi_shop_prize'],
				"L_ITEM_TYPE" => $lang['Rabbitoshi_shop_type'],
				"L_ITEM_DESC" => $lang['Rabbitoshi_item_desc'],
				"L_ITEM_IMG" => $lang['Rabbitoshi_shop_img'],
				"L_ITEM_POWER" => $lang['Rabbitoshi_shop_power'],
				"L_ITEM_POWER_EXPLAIN" => $lang['Rabbitoshi_shop_power_explain'],
				"L_SUBMIT" => $lang['Submit'],
				"S_RABBITOSHI_ACTION" => append_sid("admin_rabbitoshi_shop.$phpEx"), 
				"S_HIDDEN_FIELDS" => $s_hidden_fields) 
			);

			break;

		case "save":

			$item_id = ( !empty($HTTP_POST_VARS['item_id']) ) ? $HTTP_POST_VARS['item_id'] : $HTTP_GET_VARS['item_id'];
			$item_name = ( isset($HTTP_POST_VARS['item_name']) ) ? trim($HTTP_POST_VARS['item_name']) : trim($HTTP_GET_VARS['item_name']);
			$item_img = ( isset($HTTP_POST_VARS['item_img']) ) ? trim($HTTP_POST_VARS['item_img']) : trim($HTTP_GET_VARS['item_img']);
			$item_prize = ( isset($HTTP_POST_VARS['item_prize']) ) ? trim($HTTP_POST_VARS['item_prize']) : trim($HTTP_GET_VARS['item_prize']);
			$item_desc = ( isset($HTTP_POST_VARS['item_desc']) ) ? trim($HTTP_POST_VARS['item_desc']) : trim($HTTP_GET_VARS['item_desc']);
			$item_power = ( isset($HTTP_POST_VARS['item_power']) ) ? trim($HTTP_POST_VARS['item_power']) : trim($HTTP_GET_VARS['item_power']);
			$item_type = ( isset($HTTP_POST_VARS['item_type']) ) ? trim($HTTP_POST_VARS['item_type']) : trim($HTTP_GET_VARS['item_type']);

			if ($item_name == '' || $item_prize == '' || $item_desc == '' || $item_power == '' || $item_img == '')
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "UPDATE " . RABBITOSHI_SHOP_TABLE . "
				SET item_name = '" . str_replace("\'", "''", $item_name) . "',
			   	 item_prize = '" . str_replace("\'", "''", $item_prize) . "',
			   	 item_desc = '" . str_replace("\'", "''", $item_desc) . "',
			   	 item_img = '" . str_replace("\'", "''", $item_img) . "',
			   	 item_type = '" . str_replace("\'", "''", $item_type) . "',
			   	 item_power = '" . str_replace("\'", "''", $item_power) . "'
				WHERE item_id = " . $item_id;
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update items pets info", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Rabbitoshi_shop_edit_success'] . "<br /><br />" . sprintf($lang['Click_return_rabbitoshi_shopadmin'], "<a href=\"" . append_sid("admin_rabbitoshi_shop.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		
			message_die(GENERAL_MESSAGE, $message);
			break;

		case "savenew":

			$item_name = ( isset($HTTP_POST_VARS['item_name']) ) ? trim($HTTP_POST_VARS['item_name']) : trim($HTTP_GET_VARS['item_name']);
			$item_img = ( isset($HTTP_POST_VARS['item_img']) ) ? trim($HTTP_POST_VARS['item_img']) : trim($HTTP_GET_VARS['item_img']);
			$item_prize = ( isset($HTTP_POST_VARS['item_prize']) ) ? trim($HTTP_POST_VARS['item_prize']) : trim($HTTP_GET_VARS['item_prize']);
			$item_desc = ( isset($HTTP_POST_VARS['item_desc']) ) ? trim($HTTP_POST_VARS['item_desc']) : trim($HTTP_GET_VARS['item_desc']);
			$item_power = ( isset($HTTP_POST_VARS['item_power']) ) ? trim($HTTP_POST_VARS['item_power']) : trim($HTTP_GET_VARS['item_power']);
			$item_type = ( isset($HTTP_POST_VARS['item_type']) ) ? trim($HTTP_POST_VARS['item_type']) : trim($HTTP_GET_VARS['item_type']);

			if ($item_name == '' || $item_prize == '' || $item_desc == '' || $item_power == '' || $item_img == '')
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "SELECT *
			FROM " . RABBITOSHI_SHOP_TABLE ."
			ORDER BY item_id 
			DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items pets information', "", __LINE__, __FILE__, $sql);
			}
			$fields_data = $db->sql_fetchrow($result);
			$item_id = $fields_data['item_id'] + 1;

			$sql = "INSERT INTO " . RABBITOSHI_SHOP_TABLE . " (item_id, item_name , item_prize , item_desc , item_type , item_power , item_img )
				VALUES ( $item_id,'" . str_replace("\'", "''", $item_name) . "' ,'" . str_replace("\'", "''", $item_prize) . "', '" . str_replace("\'", "''", $item_desc) . "',  '" . str_replace("\'", "''", $item_type) . "',   '" . str_replace("\'", "''", $item_power) . "',  '" . str_replace("\'", "''", $item_type) . "')";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new item pet", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Rabbitoshi_shop_added_success'] . "<br /><br />" . sprintf($lang['Click_return_rabbitoshi_shopadmin'], "<a href=\"" . append_sid("admin_rabbitoshi_shop.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
		
			message_die(GENERAL_MESSAGE, $message);
			break;

		default : 

			$template->assign_block_vars( 'list', array());
			$sql = "SELECT *
				FROM " . RABBITOSHI_SHOP_TABLE ."
				ORDER BY item_type";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't obtain rabbitoshi_shops from database", "", __LINE__, __FILE__, $sql);
			}

			$rabbitoshi_shop = $db->sql_fetchrowset($result);

			for($i = 0; $i < count($rabbitoshi_shop); $i++)
			{	
				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				if ( $rabbitoshi_shop[$i]['item_type'] == '1' ) 
				{
					$type = $lang['Rabbitoshi_item_type_food'];
				}
				else if ( $rabbitoshi_shop[$i]['item_type'] == '2' ) 
				{
					$type = $lang['Rabbitoshi_item_type_water'];
				}
				else
				{
					$type = $lang['Rabbitoshi_item_type_misc'];
				}

				$item_desc = isset($lang[$rabbitoshi_shop[$i]['item_desc']]) ? $lang[$rabbitoshi_shop[$i]['item_desc']] : $rabbitoshi_shop[$i]['item_desc'];
				$item_name = isset($lang[$rabbitoshi_shop[$i]['item_name']]) ? $lang[$rabbitoshi_shop[$i]['item_name']] : $rabbitoshi_shop[$i]['item_name'];

				$pic = $rabbitoshi_shop[$i]['item_img'];
				if (!(file_exists("images/Rabbitoshi/$pic")) || !$pic )
				{
					$pic = $rabbitoshi_shop[$i]['item_name'].'.gif';
				}
				$template->assign_block_vars("list.rabbitoshi_shop", array(
					"ROW_COLOR" => "#" . $row_color,
					"ROW_CLASS" => $row_class,
					"NAME" =>  $item_name, 
					"IMG" =>  $pic,
					"PRICE" =>  $rabbitoshi_shop[$i]['item_prize'],
					"DESC" =>  $item_desc,
					"POWER" =>  $rabbitoshi_shop[$i]['item_power'],
					"TYPE" =>  $type,
					"U_RABBITOSHI_EDIT" => append_sid("admin_rabbitoshi_shop.$phpEx?mode=edit&amp;id=" . $rabbitoshi_shop[$i]['item_id']),
					"U_RABBITOSHI_DELETE" => append_sid("admin_rabbitoshi_shop.$phpEx?mode=delete&amp;id=" . $rabbitoshi_shop[$i]['item_id']),
				));
			}
			$template->assign_vars(array(
				"L_ACTION" => $lang['Action'],
				"L_RABBITOSHI_TITLE" => $lang['Rabbitoshi_shop_title'],
				"L_RABBITOSHI_TEXT" => $lang['Rabbitoshi_shop_desc'],
				"L_EDIT" => $lang['Edit'],
				"L_DELETE" => $lang['Delete'],
				"L_ADD" => $lang['Rabbitoshi_shop_add'],
				"L_POINTS" => $board_config['points_name'],
				"L_SUBMIT" => $lang['Submit'],
				"L_NAME" => $lang['Rabbitoshi_shop_name'],
				"L_IMG" => $lang['Rabbitoshi_shop_img'],
				"L_DESC" => $lang['Rabbitoshi_item_desc'],
				"L_TYPE" => $lang['Rabbitoshi_item_type'],
				"L_PRICE" => $lang['Rabbitoshi_shop_prize'],
				"L_POWER" => $lang['Rabbitoshi_shop_power'],
				"L_POWER_EXPLAIN" => $lang['Rabbitoshi_shop_power_explain'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
				"L_YES" => $lang['Yes'],
				"L_NO" => $lang['No'],
				"L_TRANSLATOR" => $lang['Rabbitoshi_translation'],
				"S_RABBITOSHI_ACTION" => append_sid("admin_rabbitoshi_shop.$phpEx"))
			);

			break;
	}
}

$template->pparse("body");
include('./page_footer_admin.'.$phpEx);

?>