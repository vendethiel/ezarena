<?php
/***************************************************************************
*                               admin_adr_forums_shop.php
*                              -------------------
*     begin                : 08/02/2004
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
define('IN_ADR_SHOPS', 1);
define('IN_ADR_CHARACTER', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr_Items']['Adr_store_cats'] = $filename;

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
		case 'add_store':
			adr_template_file('admin/config_adr_store_cats_edit_body.tpl');

			$template->assign_block_vars('add',array());


			$sql = "SELECT * FROM " . ADR_STORES_TABLE ;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);
			}
			$items = $db->sql_fetchrowset($result);
			
			//zone lists
			$zone_list = '<select name="store_zone[]" size="4" multiple>';
			$zone_list .= '<option value="0" SELECTED class="post">'. $lang['Adr_zones_all_stores'] .'</option>';

			$sql = "SELECT * FROM " . ADR_ZONES_TABLE ."
					ORDER BY zone_id ASC";
			if( !($result = $db->sql_query($sql)) ){
       			message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);}

			while( $row = $db->sql_fetchrow($result) ){
				$zone_list .= '<option value="' . $row['zone_id'] . '" class="post">' . $row['zone_id'] . '-' . $row['zone_name'] . '</option>';
			}
			$zone_list .= '</select>';
			
			
			//store lists
/*			$sql = "SELECT * FROM " . ADR_STORES_TABLE ."
					ORDER BY shop_name ASC";
			if ( !$result = $db->sql_query($sql)){
				message_die(GENERAL_ERROR, 'Could not obtain store information', "", __LINE__, __FILE__, $sql);}
*/
			$s_hidden_fields = '<input type="hidden" name="mode" value="savenew_store" /><input type="hidden" name="store_type" value="' . $item_type . '" />';
			
			$template->assign_vars(array(
				"ZONE_STORE_LIST" => $zone_list,
				"L_ZONE_STORE_LIST" => $lang['Adr_items_zone_title'],
				"L_ZONE_STORE_LIST_EXPLAIN" => $lang['Adr_zone_name_explain'],
				"ITEM_QUALITY" => adr_get_item_quality($items['item_quality'],'list'),
				"ITEM_TYPE" => adr_get_item_type($items['item_type_use'],'list'),
				"L_POINTS" => $board_config['points_name'],
				"L_CLOSED" => $lang['Adr_store_status_closed'],
				"L_OPEN" => $lang['Adr_store_status_open'],
				"L_NORMAL" => $lang['Adr_store_sales_off'],
				"L_SALE" => $lang['Adr_store_sales_on'],
				"L_ALL" => $lang['Adr_store_auth_all'],
				"L_ADMIN" => $lang['Adr_store_auth_admin'],
				"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
				"L_ITEMS_TITLE" => $lang['Adr_shops_item_add_title'],
				"L_ITEMS_EXPLAIN" => $lang['Adr_shops_item_add_title_explain'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
				"L_ITEM_STATUS" => $lang['Adr_store_status'],
				"L_ITEM_SALES" => $lang['Adr_store_sales'],
				"L_ITEM_AUTH" => $lang['Adr_store_auth'],
				"L_ITEM_VIEW" => $lang['Adr_store_view'],
				"L_NAME" => $lang['Adr_races_name'],
				"L_DESC" => $lang['Adr_races_desc'],
				"L_ACTION" => $lang['Action'],
				"L_ITEMS" => $lang['Adr_shops_categories_items'],
				"L_EDIT" => $lang['Edit'],
				"L_DELETE" => $lang['Delete'],
				"L_ITEM_IMG" => $lang['Adr_races_image'],
				"L_ITEM_PRICE" => $lang['Adr_items_price'],
				"L_ITEM_PRICE_EXPLAIN" => $lang['Adr_items_price_explain'],
				"L_IMG" => $lang['Adr_races_image'],
				"L_IMG_EXPLAIN" => $lang['Adr_shop_image_explain'],
				"L_SUBMIT" => $lang['Submit'],
				"S_ITEMS_ACTION" => append_sid("admin_adr_store_cats.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
				'ITEM_STATUS_CHECKED' => ' checked',
				'ITEM_SALES_CHECKED' => ' checked',
			));

			$template->pparse("body");
		break;

		case 'delete_store':
			$store_id = ( !empty($HTTP_POST_VARS['store_id']) ) ? intval($HTTP_POST_VARS['store_id']) : intval($HTTP_GET_VARS['store_id']);

			$sql = "DELETE FROM " . ADR_STORES_TABLE . "
				WHERE store_id = " . $store_id . "
				AND store_owner_id = 1 ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete item", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_store_cats_successful_deleted , admin_adr_store_cats , '' );
		break;

		case 'edit_store':
			$store_id = ( !empty($HTTP_POST_VARS['store_id']) ) ? intval($HTTP_POST_VARS['store_id']) : intval($HTTP_GET_VARS['store_id']);

			adr_template_file('admin/config_adr_store_cats_edit_body.tpl');
			$template->assign_block_vars('edit',array());

			$sql = "SELECT * FROM " . ADR_STORES_TABLE . "
				WHERE store_id = $store_id 
				AND store_owner_id = 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}
			$items = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save_store" /><input type="hidden" name="store_id" value="' . $store_id . '" />';
			
			//zone lists
			$zone_selected_array = explode( ',' , $items['store_zone'] );
			$zone_list = '<select name="store_zone[]" size="4" multiple>';
   			$zone_list .= ( $zone_selected_array[0] == '0' ) ? '<option value="0" selected="selected" class="post">'. $lang['Adr_zones_all_stores'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_zones_all_stores'] .'</option>';

			$sql = "SELECT zone_id, zone_name FROM " . ADR_ZONES_TABLE . "
					ORDER BY zone_id ASC";
			if( !($result = $db->sql_query($sql)) ){
        		message_die(GENERAL_ERROR, 'Could not query zone list', '', __LINE__, __FILE__, $sql);}

			while( $row = $db->sql_fetchrow($result) )
			{
				if ( in_array( $row['zone_id'] , $zone_selected_array ) ){
					$zone_list .= '<option value="' . $row['zone_id'] . '" SELECTED class="post">' . $row['zone_id'] . '-' . $row['zone_name'] . '</option>';}
				else{
					$zone_list .= '<option value="' . $row['zone_id'] . '" class="post">' . $row['zone_id'] . '-' . $row['zone_name'] . '</option>';}
			}
			$zone_list .= '</select>';

			$template->assign_vars(array(
				"ZONE_STORE_LIST" => $zone_list,
				"L_ZONE_STORE_LIST" => $lang['Adr_items_zone_title'],
				"L_ZONE_STORE_LIST_EXPLAIN" => $lang['Adr_zone_name_explain'],
				"ITEM_NAME" => $items['store_name'],
				"ITEM_DESC" => $items['store_desc'],
				"ITEM_NAME_EXPLAIN" => adr_get_lang($items['store_name']),
				"ITEM_DESC_EXPLAIN" => adr_get_lang($items['store_desc']),
				"ITEM_IMG" => $items['store_img'],
				"VIEW_CHECKED" => ( !$items['store_view'] ) ? 'checked' : '',
				'ITEM_STATUS_CHECKED' => ( $items['store_status'] ? 'CHECKED' :'' ),
				'NO_ITEM_STATUS_CHECKED' => ( !$items['store_status'] ? 'CHECKED' :'' ),
				'ITEM_SALES_CHECKED' => ( $items['store_sales_status'] ? 'CHECKED' :'' ),
				'NO_ITEM_SALES_CHECKED' => ( !$items['store_sales_status'] ? 'CHECKED' :'' ),
				'ITEM_AUTH_CHECKED' => ( $items['store_auth'] ? 'CHECKED' :'' ),
				'NO_ITEM_AUTH_CHECKED' => ( !$items['store_auth'] ? 'CHECKED' :'' ),
				"ITEM_STATUS" => $items['store_status'],
				"ITEM_SALES" => $items['store_sales'],
				"ITEM_AUTH" => $items['store_auth'],
				"L_POINTS" => $board_config['points_name'],
				"L_CLOSED" => $lang['Adr_store_status_closed'],
				"L_OPEN" => $lang['Adr_store_status_open'],
				"L_NORMAL" => $lang['Adr_store_sales_off'],
				"L_SALE" => $lang['Adr_store_sales_on'],
				"L_ALL" => $lang['Adr_store_auth_all'],
				"L_ADMIN" => $lang['Adr_store_auth_admin'],
				"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
				"L_ITEMS_TITLE" => $lang['Adr_shops_item_add_title'],
				"L_ITEMS_EXPLAIN" => $lang['Adr_shops_item_add_title_explain'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_STATUS" => $lang['Adr_store_status'],
				"L_ITEM_SALES" => $lang['Adr_store_sales'],
				"L_ITEM_AUTH" => $lang['Adr_store_auth'],
				"L_ITEM_VIEW" => $lang['Adr_store_view'],
				"L_NAME" => $lang['Adr_races_name'],
				"L_DESC" => $lang['Adr_races_desc'],
				"L_ACTION" => $lang['Action'],
				"L_ITEMS" => $lang['Adr_shops_categories_items'],
				"L_EDIT" => $lang['Edit'],
				"L_DELETE" => $lang['Delete'],
				"L_ITEM_IMG" => $lang['Adr_races_image'],
				"L_ITEM_PRICE" => $lang['Adr_items_price'],
				"L_ITEM_PRICE_EXPLAIN" => $lang['Adr_items_price_explain'],
				"L_ITEM_STORE" => $lang['Adr_items_store'],
				"L_IMG" => $lang['Adr_races_image'],
				"L_IMG_EXPLAIN" => $lang['Adr_store_image_explain'],
				"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
				"L_SUBMIT" => $lang['Submit'],
				"S_ITEMS_ACTION" => append_sid("admin_adr_store_cats.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
			));

			$template->pparse("body");
		break;

		case "save_store":
			$store_id = intval($HTTP_POST_VARS['store_id']);
			$store_name = ( isset($HTTP_POST_VARS['item_name']) ) ? trim($HTTP_POST_VARS['item_name']) : trim($HTTP_GET_VARS['item_name']);
			$store_desc = ( isset($HTTP_POST_VARS['item_desc']) ) ? trim($HTTP_POST_VARS['item_desc']) : trim($HTTP_GET_VARS['item_desc']);
			$store_img = ( isset($HTTP_POST_VARS['item_img']) ) ? trim($HTTP_POST_VARS['item_img']) : trim($HTTP_GET_VARS['item_img']);
			$store_status = intval($HTTP_POST_VARS['item_status']);
			$store_sales = intval($HTTP_POST_VARS['item_sales']);
			if ( !$HTTP_POST_VARS['store_zone'] || in_array( '0' , $HTTP_POST_VARS['store_zone'] ) ){
				$store_zone = '0';}
			else {
				$store_zone = implode(',' , $HTTP_POST_VARS['store_zone']);
			}

			$sql = "UPDATE " . ADR_STORES_TABLE . "
				SET 	store_name = '" . str_replace("\'", "''", $store_name) . "', 
					store_desc = '" . str_replace("\'", "''", $store_desc) . "', 
					store_img = '" . str_replace("\'", "''", $store_img) . "', 
					store_status = $store_status, 
					store_sales_status = $store_sales,
					store_zone = '" . str_replace("\'", "''", $store_zone) . "'
				WHERE store_id = " . $store_id . " 
				AND store_owner_id = 1";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update shops items", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_store_cats_successful_edit , admin_adr_store_cats , '' );
		break;

		case "savenew_store":
			$store_name = ( isset($HTTP_POST_VARS['item_name']) ) ? trim($HTTP_POST_VARS['item_name']) : trim($HTTP_GET_VARS['item_name']);
			$store_desc = ( isset($HTTP_POST_VARS['item_desc']) ) ? trim($HTTP_POST_VARS['item_desc']) : trim($HTTP_GET_VARS['item_desc']);
			$store_img = ( isset($HTTP_POST_VARS['item_img']) ) ? trim($HTTP_POST_VARS['item_img']) : trim($HTTP_GET_VARS['item_img']);
			$store_status = intval($HTTP_POST_VARS['item_status']);
			$store_sales = intval($HTTP_POST_VARS['item_sales']);
			if ( in_array( '0' , $HTTP_POST_VARS['store_zone'] ) || $HTTP_POST_VARS['store_zone'] == '' ){
			    $store_zone = '0';}
			else {
				$store_zone = implode(',' , $HTTP_POST_VARS['store_zone']);
			}

			if ($store_name == '' || $store_desc == '' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "INSERT INTO " . ADR_STORES_TABLE . " 
				( store_name , store_desc , store_img , store_status , store_sales_status , store_zone )
				VALUES ( '" . str_replace("\'", "''", $store_name) . "', '" . str_replace("\'", "''", $store_desc) . "' , '" . str_replace("\'", "''", $store_img) . "' , $store_status , $store_sales , '" . str_replace("\'", "''", $store_zone) . "')";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new store", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_store_cats_successful_new , admin_adr_store_cats , '' );
		break;
	}
}
else
{
	adr_template_file('admin/config_adr_store_cats_list_body.tpl');

	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

	if ( isset($HTTP_GET_VARS['mode2']) || isset($HTTP_POST_VARS['mode2']) ){
		$mode2 = ( isset($HTTP_POST_VARS['mode2']) ) ? htmlspecialchars($HTTP_POST_VARS['mode2']) : htmlspecialchars($HTTP_GET_VARS['mode2']);}
	else{
		$mode2 = 'store_zone';
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

	$mode_types_text = array( $lang['Adr_store_name'] , $lang['Adr_store_status'] , $lang['Adr_store_sales']);
	$mode_types = array( 'name', 'status' , 'sales', 'Zone' );	

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
			$order_by = "store_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'status':
			$order_by = "store_status $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'sales':
			$order_by = "store_sales_status $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		// case 'Zone':
		// 	$order_by = "store_zone $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		// 	break;
		default:
			$order_by = "store_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
	}

	$sql = "SELECT zone_id, zone_name FROM " . ADR_ZONES_TABLE ."
			ORDER BY zone_id ASC";
	if( !($result = $db->sql_query($sql)) ){
		message_die(GENERAL_ERROR, 'Could not obtain zones information', "", __LINE__, __FILE__, $sql);}
	$zone_list = $db->sql_fetchrowset($result);
	
	
	$sql = "SELECT * FROM " . ADR_STORES_TABLE . "
			WHERE store_admin = 0
			ORDER BY $order_by";
	if( !($result = $db->sql_query($sql)) ){
		message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);}
	$items = $db->sql_fetchrowset($result);

	$s_hidden_fields = '<input type="hidden" name="mode" value="add_store" /><input type="hidden" name="store_type" value="' . $category_id . '" />';

	for($k = 0; $k < count($items); $k++)
	{
		$row_class = ( !($k % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		
		$store_zone_array = explode( ',' , $items[$k]['store_zone'] );
		if ( $store_zone_array[0] == '0' ){
		    $store_zone = $lang['Adr_zones_all_stores'];
		} else {
			$store_zone = '';
			$first = true;
			for ( $x = 0 ; $x < count( $zone_list ) ; $x++ )
			{
			    if ( in_array( $zone_list[$x]['zone_id'] , $store_zone_array ) )
			    {
					if ( $first )
						$first = false;
					else
						$store_zone .= '<br/>';

					$store_zone .= $zone_list[$x]['zone_id'] . '-' . $zone_list[$x]['zone_name'];
				}
			}
		}

		if ( $items[$k]['store_status'] == 0 )
		{
			$store_status = $lang['Adr_store_status_closed'];
		}

		if ( $items[$k]['store_status'] == 1 )
		{
			$store_status = $lang['Adr_store_status_open'];
		}

		if ( $items[$k]['store_sales_status'] == 0 )
		{
			$store_sales = $lang['Adr_store_sales_off'];
		}

		if ( $items[$k]['store_sales_status'] == 1 )
		{
			$store_sales = $lang['Adr_store_sales_on'];
		}

		if ( $items[$k]['store_img'] != '' )
		{
			$store_img = '<img src="../adr/images/store/'.$items[$k]['store_img'].'">';
		}

		if ( $items[$k]['store_img'] == '' )
		{
			$store_img = '';
		}

		$template->assign_block_vars("items", array(
			"ROW_CLASS" => $row_class,
			"ITEM_NAME" => adr_get_lang($items[$k]['store_name']),
			"ITEM_DESC" => adr_get_lang($items[$k]['store_desc']),
			"ITEM_IMG" => $store_img,
			"ITEM_STATUS" => $store_status,
			"ITEM_VIEW" => $store_view,
			"ITEM_SALES_STATUS" => $store_sales,
			"STORE_ZONE" => $store_zone,
			"ITEM_AUTH" => $store_auth,
			"U_ITEM_EDIT" => append_sid("admin_adr_store_cats.$phpEx?mode=edit_store&amp;store_id=" . $items[$k]['store_id']), 
			"U_ITEM_DELETE" => append_sid("admin_adr_store_cats.$phpEx?mode=delete_store&amp;store_id=" . $items[$k]['store_id']),
		));
	}

	$sql = "SELECT count(*) AS total FROM " . ADR_STORES_TABLE ." 
		WHERE store_owner_id = 1 ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}
	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_items = $total['total'];
		$pagination = generate_pagination("admin_adr_store_cats.$phpEx?mode2=$mode2&amp;order=$sort_order", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';	
	}

	$template->assign_vars(array(
		"L_ITEM_NAME" => $lang['Adr_store_name'],
		"L_ITEM_DESC" => $lang['Adr_store_desc'],
		"L_ITEM_TITLE" => $lang['Adr_store_title'],
		"L_ITEM_TEXT" => $lang['Adr_store_title_explain'],
		"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
		"L_ADD_ITEM" => $lang['Adr_store_cat_add'],
		"L_ITEM_STATUS" => $lang['Adr_store_status'],
		"L_ITEM_SALES_STATUS" => $lang['Adr_store_sales'],
		"L_ITEM_AUTH" => $lang['Adr_store_auth'],
		"L_ITEM_VIEW" => $lang['Adr_store_view_title'],
		"L_ACTION" => $lang['Action'],
		"L_ITEMS" => $lang['Adr_shops_categories_items'],
		"L_EDIT" => $lang['Edit'],
		"L_DELETE" => $lang['Delete'],
		"L_ITEM_IMG" => $lang['Adr_races_image'],
		"L_ITEM_PRICE" => $lang['Adr_items_price'],
		'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
		'L_ORDER' => $lang['Order'],
		'L_SORT' => $lang['Sort'],
		'L_SUBMIT' => $lang['Sort'],
		'S_MODE_SELECT' => $select_sort_mode,
		'S_ORDER_SELECT' => $select_sort_order,
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )), 
		'L_GOTO_PAGE' => $lang['Goto_page'],
		"L_GIVE" => $lang['Adr_items_give'],
		"L_SELL" => $lang['Adr_items_sell'],
		"L_EDIT" => $lang['Adr_items_edit'],
		"L_SHOP" => $lang['Adr_items_into_shop'],
		"S_SHOPS_ACTION" => append_sid("admin_adr_store_cats.$phpEx?mode2=$mode2&amp;order=$sort_order"),
		"S_HIDDEN_FIELDS" => $s_hidden_fields, 
	));

	$template->pparse("body");
}

include('./page_footer_admin.'.$phpEx);

?>