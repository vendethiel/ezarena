<?php
/***************************************************************************
*                               admin_adr_item_type.php
*                              -------------------
*     begin                : 31/01/2004
*     copyright            : vash1486
*	  email                : vash1486@hotmail.com
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
define('IN_ADR_ITEM_TYPE', 1);
define('IN_ADR_SHOPS', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr_settings']['Adr_items_settings_advanced'] = "$filename";

	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);


if( isset($_POST['mode']) || isset($_GET['mode']) )
{
	$mode = ( isset($_POST['mode']) ) ? $_POST['mode'] : $_GET['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = "";
}

if( isset($_POST['add']) || isset($_GET['add']) )
{
	adr_template_file('admin/config_adr_item_type_edit_body.tpl');
	$template->assign_block_vars( 'item_type_new', array());
	
	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';
	
	$sql = "SELECT item_type_category FROM " . ADR_SHOPS_ITEMS_TYPE_TABLE . " GROUP BY item_type_category ORDER BY item_type_category";
    $result = $db->sql_query($sql);
    if( !$result )
    {
    	message_die(GENERAL_ERROR, 'Could not obtain stype information', "", __LINE__, __FILE__, $sql);
    }
    $bz = $db->sql_fetchrowset($result);

    $cat_list = '<select name="item_type_category">';
    for( $i = 0; $i < count($bz); $i++ )
    {
		$cat_list .= '<option value = "'.$bz[$i]['item_type_category'].'" '.$selected.'>'.adr_get_lang($bz[$i]['item_type_category']).'</option>';
    }
    $cat_list .= '</select>';
	
	$template->assign_vars(array(
		"L_ITEM_TYPE_TITLE" => $lang['Adr_item_type_add_edit'],
		"L_ITEM_TYPE_EXPLAIN" => $lang['Adr_item_type_add_edit_explain'],
		"L_NAME" => $lang['Adr_item_type_name'],
		"L_NAME_EXPLAIN" => $lang['Adr_item_type_name_explain'],
		"L_ID" => $lang['Adr_item_type_id'],
		"L_ID_EXPLAIN" => $lang['Adr_item_type_id_explain'],
		"L_PRICE" => $lang['Adr_item_type_price'],
		"L_PRICE_EXPLAIN" => $lang['Adr_item_type_price_explain'],
		"L_SUBMIT" => $lang['Submit'],
		"L_CATEGORY" => $lang['Adr_item_type_category'],
		"L_CATEGORY_EXPLAIN" => $lang['Adr_item_type_category_explain'],
		"CATEGORY" => $cat_list,
		"S_HIDDEN_FIELDS" => $s_hidden_fields) 
	);

	$template->pparse("body");
}
else if ( $mode != "" )
{
	switch( $mode )
	{
		case 'delete': 
			$item_type_id = ( !empty($_POST['id']) ) ? intval($_POST['id']) : intval($_GET['id']);

			$sql = "DELETE FROM " . ADR_SHOPS_ITEMS_TYPE_TABLE . "
				WHERE item_type_id = " . $item_type_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete item type", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_item_type_successful_deleted , admin_adr_item_type , '' );
			break;

		case 'edit':
			$item_type_id = ( !empty($_POST['id']) ) ? intval($_POST['id']) : intval($_GET['id']);

			adr_template_file('admin/config_adr_item_type_edit_body.tpl');

			$template->assign_block_vars( 'item_type_edit', array());

			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TYPE_TABLE ."
				WHERE item_type_id = $item_type_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain item type information', "", __LINE__, __FILE__, $sql);
			}
			$item_type = $db->sql_fetchrow($result);

			$sql = "SELECT item_type_category FROM " . ADR_SHOPS_ITEMS_TYPE_TABLE . " GROUP BY item_type_category ORDER BY item_type_category";
		    $result = $db->sql_query($sql);
		    if( !$result )
		    {
		    	message_die(GENERAL_ERROR, 'Could not obtain stype information', "", __LINE__, __FILE__, $sql);
		    }
		    $bz = $db->sql_fetchrowset($result);
		
		    $cat_list = '<select name="item_type_category">';
		    for( $i = 0; $i < count($bz); $i++ )
		    {
		    	if($bz[$i]['item_type_category'] == $item_type['item_type_category']) $selected = 'selected';
		    	else $selected = '';
				$cat_list .= '<option value = '.$bz[$i]['item_type_category'].' '.$selected.'>'.adr_get_lang($bz[$i]['item_type_category']).'</option>';
		    }
		    $cat_list .= '</select>';
			
			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="item_type_id" value="' . $item_type['item_type_id'] . '" />';

			$template->assign_vars(array(
				"ITEM_TYPE_NAME" => $item_type['item_type_lang'],
				"ITEM_TYPE_NAME_EXPLAIN" => adr_get_lang($item_type['item_type_lang']),
				"ITEM_TYPE_ID" => $item_type['item_type_id'],
				"ITEM_TYPE_PRICE" => $item_type['item_type_base_price'],
				"ITEM_TYPE_PRICE_EXPLAIN" => $item_type['item_type_base_price'],
				"L_ITEM_TYPE_TITLE" => $lang['Adr_item_type_add_edit'],
				"L_ITEM_TYPE_EXPLAIN" => $lang['Adr_item_type_add_edit_explain'],
				"L_NAME" => $lang['Adr_item_type_name'],
				"L_NAME_EXPLAIN" => $lang['Adr_item_type_name_explain'],
				"L_ID" => $lang['Adr_item_type_id'],
				"L_ID_EXPLAIN" => $lang['Adr_item_type_id_explain'],
				"L_PRICE" => $lang['Adr_item_type_price'],
				"L_PRICE_EXPLAIN" => $lang['Adr_item_type_price_explain'],
				"L_SUBMIT" => $lang['Submit'],
				"L_CATEGORY" => $lang['Adr_item_type_category'],
				"L_CATEGORY_EXPLAIN" => $lang['Adr_item_type_category_explain'],
				"CATEGORY" => $cat_list,
				"ITEM_TYPE_CATEGORY_EXPLAIN" => $item_type['item_type_category'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields) 
			);

			$template->pparse("body");
			break;

		case "save":
			$item_type_id = ( !empty($_POST['item_type_id']) ) ? intval($_POST['item_type_id']) : intval($_GET['item_type_id']);
			$item_type_name = ( isset($_POST['item_type_name']) ) ? trim($_POST['item_type_name']) : trim($_GET['item_type_name']);
			$item_type_price = ( !empty($_POST['item_type_price']) ) ? intval($_POST['item_type_price']) : intval($_GET['item_type_price']);
			if($_POST['item_type_category'] == '' && $_POST['new_category'] == '') $item_type_category = "Varie";
			elseif($_POST['new_category'] != '') $item_type_category = trim($_POST['new_category']);
			elseif($_POST['item_type_category'] != '') $item_type_category = trim($_POST['item_type_category']);
			if (empty($item_type_id) || empty($item_type_name) || empty($item_type_price) )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "UPDATE " . ADR_SHOPS_ITEMS_TYPE_TABLE . "
				SET item_type_lang = '" . str_replace("\'", "''", $item_type_name) . "', 	
					item_type_base_price = '" . $item_type_price . "',
					item_type_category = '" . $item_type_category . "'
				WHERE item_type_id = " . $item_type_id;
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update minerals info", "", __LINE__, __FILE__, $sql);
			}

			// Update cache
			include_once($phpbb_root_path . 'adr/includes/adr_functions_cache.'.$phpEx);
			adr_update_item_type();
			
			adr_previous( Adr_item_type_successful_edited , admin_adr_item_type , '' );
			break;

		case "savenew":
			$item_type_id = ( !empty($_POST['item_type_id']) ) ? intval($_POST['item_type_id']) : intval($_GET['item_type_id']);
			$item_type_name = ( isset($_POST['item_type_name']) ) ? trim($_POST['item_type_name']) : trim($_GET['item_type_name']);
			$item_type_price = ( !empty($_POST['item_type_price']) ) ? intval($_POST['item_type_price']) : intval($_GET['item_type_price']);
			if($_POST['item_type_category'] == '' && $_POST['new_category'] == '') $item_type_category = "Varie";
			elseif($_POST['new_category'] != '') $item_type_category = trim($_POST['new_category']);
			elseif($_POST['item_type_category'] != '') $item_type_category = trim($_POST['item_type_category']);
			if (empty($item_type_id) || empty($item_type_name) || empty($item_type_price) )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}
			
			$sql = "SELECT MAX(item_type_order) AS max_order
				FROM " . ADR_SHOPS_ITEMS_TYPE_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't get order number from item type table", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$next_order = $row['max_order'] + 10;
			
			$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TYPE_TABLE . " 
				( item_type_id , item_type_lang , item_type_base_price, item_type_order, item_type_category )
				VALUES ( $item_type_id,'" . str_replace("\'", "''", $item_type_name) . "', $item_type_price, $next_order, '$item_type_category' )";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new item_type", "", __LINE__, __FILE__, $sql);
			}

			// Update cache
			include_once($phpbb_root_path . 'adr/includes/adr_functions_cache.'.$phpEx);
			adr_update_item_type();

			adr_previous( Adr_item_type_successful_edited , admin_adr_item_type , '' );
			break;
			
		case 'order':
			$move = intval($_GET['move']);
			$item_type_id = intval($_GET['id']);
			
			$sql = "UPDATE " . ADR_SHOPS_ITEMS_TYPE_TABLE . "
						SET item_type_order = item_type_order + $move
						WHERE item_type_id = $item_type_id";
			if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't change category order", "", __LINE__, __FILE__, $sql);
				}
			
			adr_renumber_order();
			adr_update_item_type();	
			adr_previous( Adr_item_type_successful_edited , admin_adr_item_type , '' );		
			break;
	}
}
else
{
	adr_template_file('admin/config_adr_item_type_list_body.tpl');

	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TYPE_TABLE . " ORDER BY item_type_category, item_type_order ASC";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain minerals information', "", __LINE__, __FILE__, $sql);
	}
	$item_type = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($item_type); $i++)
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		$template->assign_block_vars("items", array(
			"ROW_CLASS" => $row_class,
			"NAME" => adr_get_lang($item_type[$i]['item_type_lang']),
			"ID" => $item_type[$i]['item_type_id'],
			"PRICE" => $item_type[$i]['item_type_base_price'] ,
			"U_ITEM_TYPE_UP" => append_sid("admin_adr_item_type.$phpEx?mode=order&amp;move=-15&amp;id=" . $item_type[$i]['item_type_id']), 
			"U_ITEM_TYPE_DOWN" => append_sid("admin_adr_item_type.$phpEx?mode=order&amp;move=15&amp;id=" . $item_type[$i]['item_type_id']), 
			"U_ITEM_TYPE_EDIT" => append_sid("admin_adr_item_type.$phpEx?mode=edit&amp;id=" . $item_type[$i]['item_type_id']), 
			"U_ITEM_TYPE_DELETE" => append_sid("admin_adr_item_type.$phpEx?mode=delete&amp;id=" . $item_type[$i]['item_type_id']))
		);
		if($item_type[$i]['item_type_category'] != $prev_cat)
		{
			$template->assign_block_vars("items.categories", array(
				"CATEGORY" => $item_type[$i]['item_type_category'])
			);
		}
		$prev_cat = $item_type[$i]['item_type_category'];
	}

	$template->assign_vars(array(
		"L_ITEM_TYPE" => $lang['Adr_items_settings_advanced'],
		"L_ITEM_TYPE_TEXT" => $lang['Adr_item_type_explain'],
		"L_NAME" => $lang['Adr_item_type_name'],
		"L_ID" => $lang['Adr_item_type_id'],
		"L_PRICE" => $lang['Adr_item_type_price'],
		"L_ACTION" => $lang['Action'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		'L_MOVE_UP' => $lang['Move_up'], 
		'L_MOVE_DOWN' => $lang['Move_down'], 
		"L_ITEMS_ADD" => $lang['Adr_item_type_add'],
		"S_ITEM_TYPE_ACTION" => append_sid("admin_adr_item_type.$phpEx"))
	);

	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}

function adr_renumber_order()
{
	global $db;

	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TYPE_TABLE ."
		ORDER BY item_type_category, item_type_order ASC";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Item Types", "", __LINE__, __FILE__, $sql);
	}
	$i = 10;
	$inc = 10;

	while( $row = $db->sql_fetchrow($result) )
	{
		$sql = "UPDATE " . ADR_SHOPS_ITEMS_TYPE_TABLE ."
			SET item_type_order = " . $i . "
			WHERE item_type_id = " . $row['item_type_id'];
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update order fields", "", __LINE__, __FILE__, $sql);
		}
		$i += 10;
	}
}

?>
