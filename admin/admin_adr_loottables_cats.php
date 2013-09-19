<?php
/***************************************************************************
*                               admin_adr_loottables_cats.php
*                              -------------------
*     begin                : 01/03/2006
*     copyright            : Himmelweiss
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
define('IN_ADR_LOOTTABLES', 1);
define('IN_ADR_SHOPS', 1);
define('IN_ADR_BATTLE', 1);
define('IN_ADR_CHARACTER', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr_Items']['Loottable_Categories'] = $filename;
	// $module['ADR_Loot_System']['Loottable_Categories'] = $filename;

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

		case 'add_loottable':

			adr_template_file('admin/config_adr_loottables_cats_edit_body.tpl');

			$s_hidden_fields = '<input type="hidden" name="mode" value="savenew_loottable" /><input type="hidden" name="loottable_type" value="' . $loottable_type . '" />';

			$sql = "SELECT * FROM " . ADR_LOOTTABLES_TABLE ;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain loottable information', "", __LINE__, __FILE__, $sql);
			}
			$loottables = $db->sql_fetchrowset($result);

			$template->assign_vars(array(
				"L_LOOTTABLE_TITLE" => $lang['Adr_loottable_title'],
				"L_LOOTTABLE_EXPLAIN" => $lang['Adr_loottable_title_explain'],
				"LOOTTABLE_NAME" => $loottables['loottable_name'],
				"LOOTTABLE_DESC" => $loottables['loottable_desc'],
				"LOOTTABLE_DROPCHANCE" => $loottables['loottable_dropchance'],
				"L_LOOTTABLE_NAME" => $lang['Adr_loottable_name'],
				"L_LOOTTABLE_NAME_EXPLAIN" => $lang['Adr_loottable_name_explain'],
				"L_LOOTTABLE_DESC" => $lang['Adr_loottable_desc'],
				"L_LOOTTABLE_DESC_EXPLAIN" => $lang['Adr_loottable_desc_explain'],
				"L_LOOTTABLE_DROPCHANCE" => $lang['Adr_loottable_dropchance_title'],
				"L_LOOTTABLE_DROPCHANCE_EXPLAIN" => $lang['Adr_loottable_dropchance_explain'],
				"L_LOOTTABLE_STATUS" => $lang['Adr_loottable_status'],
				'LOOTTABLE_ACTIVATED_CHECKED' => ( $loottables['loottable_status'] ? 'CHECKED' :'' ),
				'LOOTTABLE_DEACTIVATED_CHECKED' => ( !$loottables['loottable_status'] ? 'CHECKED' :'' ),
				"L_LOOTTABLE_DEACTIVATED" => $lang['Adr_loottable_status_deactivated'],
				"L_LOOTTABLE_ACTIVATED" => $lang['Adr_loottable_status_activated'],
				"L_LOOTTABLE_SUBMIT" => $lang['Submit'],
				"S_LOOTTABLE_ACTION" => append_sid("admin_adr_loottables_cats.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
			));

			$template->pparse("body");

		break;

		case 'delete_loottable':

			$loottable_id = ( !empty($HTTP_POST_VARS['loottable_id']) ) ? intval($HTTP_POST_VARS['loottable_id']) : intval($HTTP_GET_VARS['loottable_id']);

			$sql = "DELETE FROM " . ADR_LOOTTABLES_TABLE . "
				WHERE loottable_id = " . $loottable_id . "
				";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete loottable", "", __LINE__, __FILE__, $sql);
			}

			//remove the loottable as well on all items
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_owner_id = 1
				";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
			}
			$items_loottables = $db->sql_fetchrowset($result);
			
			for ( $i=0 ; $i < count($items_loottables) ; $i++ )
			{
				$loottables_list = "";
				$split_loottables = explode(':',$items_loottables[$i]['item_loottables']);
				foreach ($split_loottables as $value) 
				{
					if ($value != $loottable_id)
					{
						$loottables_list .= ( $loottables_list == '' ) ? $value : ":".$value;
					}
				}
				
				$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
					SET item_loottables = '".$loottables_list."'
					WHERE item_id = " . $items_loottables[$i]['item_id'] . " 
					AND item_owner_id = 1
					";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Couldn't update item", "", __LINE__, __FILE__, $sql);
				}
			}

			//remove the loottable as well on all monsters
			$sql = "SELECT * FROM " . ADR_BATTLE_MONSTERS_TABLE . "
				";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain monsters information', "", __LINE__, __FILE__, $sql);
			}
			$monsters_loottables = $db->sql_fetchrowset($result);
			
			for ( $i=0 ; $i < count($monsters_loottables) ; $i++ )
			{
				$loottables_list = "";
				$split_loottables = explode(':',$monsters_loottables[$i]['monster_loottables']);
				foreach ($split_loottables as $value) 
				{
					if ($value != $loottable_id)
					{
						$loottables_list .= ( $loottables_list == '' ) ? $value : ":".$value;
					}
				}
				
				$sql = "UPDATE " . ADR_BATTLE_MONSTERS_TABLE . "
					SET monster_loottables = '".$loottables_list."'
					WHERE monster_id = " . $monsters_loottables[$i]['monster_id'] . " 
					";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Couldn't update monster", "", __LINE__, __FILE__, $sql);
				}
			}

			adr_previous( Adr_loottable_cats_successful_deleted , admin_adr_loottables_cats , '' );

		break;

		case 'edit_loottable':

			$loottable_id = ( !empty($HTTP_POST_VARS['loottable_id']) ) ? intval($HTTP_POST_VARS['loottable_id']) : intval($HTTP_GET_VARS['loottable_id']);

			adr_template_file('admin/config_adr_loottables_cats_edit_body.tpl');

			$sql = "SELECT * FROM " . ADR_LOOTTABLES_TABLE . "
				WHERE loottable_id = $loottable_id 
				";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain loottables information', "", __LINE__, __FILE__, $sql);
			}
			$loottables = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save_loottable" /><input type="hidden" name="loottable_id" value="' . $loottable_id . '" />';

			$template->assign_vars(array(
				"L_LOOTTABLE_TITLE" => $lang['Adr_loottable_title'],
				"L_LOOTTABLE_EXPLAIN" => $lang['Adr_loottable_title_explain'],
				"LOOTTABLE_NAME" => $loottables['loottable_name'],
				"LOOTTABLE_DESC" => $loottables['loottable_desc'],
				"LOOTTABLE_DROPCHANCE" => $loottables['loottable_dropchance'],
				"L_LOOTTABLE_NAME" => $lang['Adr_loottable_name'],
				"L_LOOTTABLE_NAME_EXPLAIN" => $lang['Adr_loottable_name_explain'],
				"L_LOOTTABLE_DESC" => $lang['Adr_loottable_desc'],
				"L_LOOTTABLE_DESC_EXPLAIN" => $lang['Adr_loottable_desc_explain'],
				"L_LOOTTABLE_DROPCHANCE" => $lang['Adr_loottable_dropchance_title'],
				"L_LOOTTABLE_DROPCHANCE_EXPLAIN" => $lang['Adr_loottable_dropchance_explain'],
				"L_LOOTTABLE_STATUS" => $lang['Adr_loottable_status'],
				'LOOTTABLE_ACTIVATED_CHECKED' => ( $loottables['loottable_status'] ? 'CHECKED' :'' ),
				'LOOTTABLE_DEACTIVATED_CHECKED' => ( !$loottables['loottable_status'] ? 'CHECKED' :'' ),
				"L_LOOTTABLE_DEACTIVATED" => $lang['Adr_loottable_status_deactivated'],
				"L_LOOTTABLE_ACTIVATED" => $lang['Adr_loottable_status_activated'],
				"L_LOOTTABLE_SUBMIT" => $lang['Submit'],
				"S_LOOTTABLE_ACTION" => append_sid("admin_adr_loottables_cats.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
			));

			$template->pparse("body");

		break;

		case "save_loottable":

			$loottable_id = intval($HTTP_POST_VARS['loottable_id']);
			$loottable_name = ( isset($HTTP_POST_VARS['loottable_name']) ) ? trim($HTTP_POST_VARS['loottable_name']) : trim($HTTP_GET_VARS['loottable_name']);
			$loottable_desc = ( isset($HTTP_POST_VARS['loottable_desc']) ) ? trim($HTTP_POST_VARS['loottable_desc']) : trim($HTTP_GET_VARS['loottable_desc']);
			$loottable_dropchance = intval($HTTP_POST_VARS['loottable_dropchance']);
			$loottable_status = intval($HTTP_POST_VARS['loottable_status']);


			$sql = "UPDATE " . ADR_LOOTTABLES_TABLE . "
				SET loottable_name = '" . str_replace("\'", "''", $loottable_name) . "', 
					loottable_desc = '" . str_replace("\'", "''", $loottable_desc) . "', 
					loottable_status = $loottable_status, 
					loottable_dropchance = $loottable_dropchance 
				WHERE loottable_id = " . $loottable_id . " 
				";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update loottables", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_loottable_cats_successful_edit , admin_adr_loottables_cats , '' );

		break;

		case "savenew_loottable":

			$loottable_name = ( isset($HTTP_POST_VARS['loottable_name']) ) ? trim($HTTP_POST_VARS['loottable_name']) : trim($HTTP_GET_VARS['loottable_name']);
			$loottable_desc = ( isset($HTTP_POST_VARS['loottable_desc']) ) ? trim($HTTP_POST_VARS['loottable_desc']) : trim($HTTP_GET_VARS['loottable_desc']);
			$loottable_dropchance = intval($HTTP_POST_VARS['loottable_dropchance']);
			$loottable_status = intval($HTTP_POST_VARS['loottable_status']);

			if ($loottable_name == '' || $loottable_desc == '' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "INSERT INTO " . ADR_LOOTTABLES_TABLE . " 
				( loottable_name , loottable_desc , loottable_dropchance , loottable_status )
				VALUES ( '" . str_replace("\'", "''", $loottable_name) . "', '" . str_replace("\'", "''", $loottable_desc) . "' , $loottable_dropchance , $loottable_status )";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new loottable", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_loottable_cats_successful_new , admin_adr_loottables_cats , '' );

		break;

		case "view_loottable":

			$loottable_id = ( !empty($HTTP_POST_VARS['loottable_id']) ) ? intval($HTTP_POST_VARS['loottable_id']) : intval($HTTP_GET_VARS['loottable_id']);

			adr_template_file('admin/config_adr_loottables_cats_view_body.tpl');

			$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

			if ( isset($HTTP_GET_VARS['mode2']) || isset($HTTP_POST_VARS['mode2']) )
			{
				$mode2 = ( isset($HTTP_POST_VARS['mode2']) ) ? htmlspecialchars($HTTP_POST_VARS['mode2']) :  htmlspecialchars($HTTP_GET_VARS['mode2']);
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
		      $cat = ( isset($HTTP_POST_VARS['cat']) ) ? htmlspecialchars($HTTP_POST_VARS['cat']) : htmlspecialchars($HTTP_GET_VARS['cat']);
		   }
		   else
		   {
		      $cat = 0;
		   }
		   $cat_sql = ( $cat ) ? 'AND i.item_type_use = '.$cat : '';
			
		

			$categories_text = array();
			$categories = array();
			$categories_cat = array();
			adr_get_item_type_categories();

			$select_category = '<select name="cat">';
			for($i = 0; $i < count($categories_text); $i++)
			{
				if($prev_cat != $categories_cat[$i]) $select_category .= '<option style="font-weight:bold;color:black" disabled>' . adr_get_lang($categories_cat[$i]) . '</option>';
				$selected = ( $cat == $categories[$i] ) ? ' selected="selected"' : '';
				$select_category .= '<option value="' . $categories[$i] . '"' . $selected . '>' . adr_get_lang($categories_text[$i]) . '</option>';
				$prev_cat = $categories_cat[$i];
			}
			$select_category .= '</select>';
			
			
			$mode_types_text = array( $lang['Adr_shops_categories_item_name'] , $lang['Adr_items_price'] , $lang['Adr_items_type_use'] , $lang['Adr_items_quality'] , $lang['Adr_items_power'] , $lang['Adr_items_lvlb'] , $lang['Adr_items_spp'] , $lang['Adr_items_crm'] , $lang['Adr_items_gpb'] , $lang['Adr_items_exb'] , $lang['Adr_items_hpb'] , $lang['Adr_items_mpb'] , $lang['Adr_items_rng'] , $lang['Adr_items_dbl'] , $lang['Adr_items_hnd'] , $lang['Adr_items_red'] , $lang['Adr_items_sdmg'] , $lang['Adr_items_crt'] , $lang['Adr_items_acb'] , $lang['Adr_items_rsl'] , $lang['Adr_items_atk'] , $lang['Adr_items_dex'] );
			$mode_types = array( 'name', 'price' , 'type' , 'quality' , 'power' , 'lvlb' , 'spp' , 'crm' , 'gpb' , 'exb' , 'hpb' , 'mpb' , 'rng' , 'dbl' , 'hnd' , 'red' , 'sdmg' , 'crt' , 'acb' , 'rsl' , 'atk' , 'dex' );
			
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
					$order_by = "i.item_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				case 'price':
					$order_by = "i.item_price $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				case 'type':
					$order_by = "i.item_type_use $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				case 'quality':
					$order_by = "i.item_quality $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				case 'power':
					$order_by = "i.item_power $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				default:
					$order_by = "i.item_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
			}

			$sql = "SELECT i.* , q.item_quality_lang , t.item_type_lang  FROM " . ADR_SHOPS_ITEMS_TABLE . " i
					LEFT JOIN " . ADR_SHOPS_ITEMS_QUALITY_TABLE . " q ON ( i.item_quality = q.item_quality_id )
					LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
				WHERE (i.item_loottables like '".$loottable_id.":"."%'
					OR i.item_loottables = '".$loottable_id."'
					OR i.item_loottables like '%".":".$loottable_id.":"."%'
					OR i.item_loottables like '%".":".$loottable_id."')
			        $cat_sql
				ORDER BY $order_by";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query items', '', __LINE__, __FILE__, $sql);
			}

			if ( $row = $db->sql_fetchrow($result) )
			{
				$i = 0;
				do
				{
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

					$template->assign_block_vars('items', array(
						"ROW_CLASS" => $row_class,
						"ITEM_ID" => $row['item_id'],
						"ITEM_NAME" => adr_get_lang($row['item_name']),
						"ITEM_DESC" => adr_get_lang($row['item_desc']),
						"ITEM_IMG" => $row['item_icon'],
						"ITEM_QUALITY" => $lang[$row['item_quality_lang']],
						"ITEM_TYPE" => $lang[$row['item_type_lang']],
						"ITEM_DURATION" => $row['item_duration'],
						"ITEM_DURATION_MAX" => $row['item_duration_max'],
						"ITEM_POWER" => $row['item_power'],
						"ITEM_WEIGHT" => $row['item_weight'],
						"ITEM_PRICE" => $row['item_price'],
						"U_ITEM_DELETE" => append_sid("admin_adr_loottables_cats.$phpEx?mode=delete_item&amp;loottable_id=".$loottable_id."&amp;item_id=".$row['item_id']),
					));
					$i++;
				}
				while ( $row = $db->sql_fetchrow($result) );
			}

			// Check if power limit is enabled
			if ( $adr_general['item_power_level'] == 1 )
			{
				$lang_power = $lang['Adr_items_level'];
			}
			else
			{
				$lang_power = $lang['Adr_items_power'];
			}

			$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_ITEMS_TABLE . " 
				WHERE (item_loottables like '".$loottable_id.":"."%'
					OR item_loottables = '".$loottable_id."'
					OR item_loottables like '%".":".$loottable_id.":"."%'
					OR item_loottables like '%".":".$loottable_id."')
				";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting total items', '', __LINE__, __FILE__, $sql);
			}

			if ( $total = $db->sql_fetchrow($result) )
			{
				$total_items = $total['total'];
				$pagination = generate_pagination("admin_adr_loottables_cats.$phpEx?mode=view_store&amp;mode2=$mode2&amp;order=$sort_order&amp;loottable_id=".$loottable_id."", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';
			}

			$template->assign_vars(array(
				'ORDER_BY' => $order_by,
				'ACTION_SELECT' => $action_select,
				'SELECT_CAT' => $select_category,
				'LOOTTABLE_ID' => $shop_id,
				'LOOTTABLE_NAME' => $store_name,
				'LOOTTABLE_DESC' => $store_desc,
				"L_SELECT_CAT" => $lang['Adr_items_select'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
				"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
				"L_ITEM_POWER" => $lang_power,
				"L_ITEM_WEIGHT" => $lang['Adr_character_weight'],
				"L_ITEM_DURATION" => $lang['Adr_items_duration'],
				"L_ACTION" => $lang['Adr_items_action'],
				"L_ITEM_EDIT" => $lang['Edit'],
				"L_ITEM_DELETE" => $lang['Delete'],
				"L_ITEM_IMG" => $lang['Adr_races_image'],
				"L_ITEM_PRICE" => $lang['Adr_items_price'],
				"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
				"L_ITEM_RACE_LIMIT" => $lang['Adr_items_race_limit'],
				"L_ITEM_LIMIT" => $lang['Adr_items_class_limit'],
				"L_NO_ITEMS" => $lang['Adr_items_none'],
				'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
				'L_ORDER' => $lang['Order'],
				'L_SORT' => $lang['Sort'],
				'L_SUBMIT' => $lang['Submit'],
				'S_MODE_SELECT' => $select_sort_mode,
				'S_ORDER_SELECT' => $select_sort_order,
				'PAGINATION' => $pagination,
				'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ),  ceil( $total_items / $board_config['topics_per_page'] )), 
				'L_GOTO_PAGE' => $lang['Goto_page'],
				'S_MODE_ACTION' => append_sid("admin_adr_loottables_cats.$phpEx?mode=view_loottable&amp;loottable_id=".$loottable_id.""),
			));
				$template->pparse("body");
		break;
		
		
		case "delete_item":

			$loottable_id = ( !empty($HTTP_POST_VARS['loottable_id']) ) ? intval($HTTP_POST_VARS['loottable_id']) : intval($HTTP_GET_VARS['loottable_id']);
			$item_id = ( !empty($HTTP_POST_VARS['item_id']) ) ? intval($HTTP_POST_VARS['item_id']) : intval($HTTP_GET_VARS['item_id']);

			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_id = $item_id
				AND item_owner_id = 1
				";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
			}
			$del_item = $db->sql_fetchrow($result);
			
			$split_loottables = explode(':',$del_item['item_loottables']);
			foreach ($split_loottables as $value) 
			{
				if ($value != $loottable_id)
				{
					$loottables_list .= ( $loottables_list == '' ) ? $value : ":".$value;
				}
			}

			$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
				SET item_loottables = '".$loottables_list."'
				WHERE item_id = " . $item_id . " 
				AND item_owner_id = 1
				";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update item", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_loottable_cats_successful_item_deleted , admin_adr_loottables_cats , 'mode=view_loottable&amp;loottable_id='.$loottable_id.'' );
			
		break;

	}
}
else
{
	adr_template_file('admin/config_adr_loottables_cats_list_body.tpl');

	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

	if ( isset($HTTP_GET_VARS['mode2']) || isset($HTTP_POST_VARS['mode2']) )
	{
		$mode2 = ( isset($HTTP_POST_VARS['mode2']) ) ? htmlspecialchars($HTTP_POST_VARS['mode2']) : htmlspecialchars($HTTP_GET_VARS['mode2']);
	}
	else
	{
		$mode2 = 'loottablename';
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

	$mode_types_text = array( $lang['Adr_loottable_name'] , $lang['Adr_loottable_dropchance_title']  , $lang['Adr_loottable_status'] );
	$mode_types = array( 'name', 'dropchance', 'status' );

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
			$order_by = "loottable_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'dropchance':
			$order_by = "loottable_dropchance $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'status':
			$order_by = "loottable_status $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		default:
			$order_by = "loottable_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
	}

	$sql = "SELECT * FROM " . ADR_LOOTTABLES_TABLE . "
		ORDER BY $order_by";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain loottable information', "", __LINE__, __FILE__, $sql);
	}
	$loottables = $db->sql_fetchrowset($result);

	$s_hidden_fields = '<input type="hidden" name="mode" value="add_loottable" /><input type="hidden" name="loottable_type" value="' . $category_id . '" />';

	for($k = 0; $k < count($loottables); $k++)
	{
		$row_class = ( !($k % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		if ( $loottables[$k]['loottable_status'] == 0 )
		{
			$loottable_status = $lang['Adr_loottable_status_deactivated'];
		}

		if ( $loottables[$k]['loottable_status'] == 1 )
		{
			$loottable_status = $lang['Adr_loottable_status_activated'];
		}

		$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE (item_loottables like '".$loottables[$k]['loottable_id'].":"."%'
				OR item_loottables = '".$loottables[$k]['loottable_id']."'
				OR item_loottables like '%".":".$loottables[$k]['loottable_id'].":"."%'
				OR item_loottables like '%".":".$loottables[$k]['loottable_id']."')
			";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query items', '', __LINE__, __FILE__, $sql);
		}
		$total_items = $db->sql_fetchrowset($result);
		
		$template->assign_block_vars("loottables", array(
			"ROW_CLASS" => $row_class,
			"LOOTTABLE_NAME" => adr_get_lang($loottables[$k]['loottable_name']),
			"LOOTTABLE_DESC" => adr_get_lang($loottables[$k]['loottable_desc']),
			"LOOTTABLE_ITEMS" => count($total_items),
			"LOOTTABLE_STATUS" => $loottable_status,
			"LOOTTABLE_DROPCHANCE" => $loottables[$k]['loottable_dropchance'],
			"U_LOOTTABLE_VIEW" => append_sid("admin_adr_loottables_cats.$phpEx?mode=view_loottable&amp;loottable_id=" . $loottables[$k]['loottable_id']), 
			"U_LOOTTABLE_EDIT" => append_sid("admin_adr_loottables_cats.$phpEx?mode=edit_loottable&amp;loottable_id=" . $loottables[$k]['loottable_id']), 
			"U_LOOTTABLE_DELETE" => append_sid("admin_adr_loottables_cats.$phpEx?mode=delete_loottable&amp;loottable_id=" . $loottables[$k]['loottable_id']),
		));
	}

	$sql = "SELECT count(*) AS total FROM " . ADR_LOOTTABLES_TABLE ." 
		";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total loottables', '', __LINE__, __FILE__, $sql);
	}
	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_loottables = $total['total'];
		$pagination = generate_pagination("admin_adr_loottables_cats.$phpEx?mode2=$mode2&amp;order=$sort_order", $total_loottables, $board_config['topics_per_page'], $start). '&nbsp;';	
	}

	$template->assign_vars(array(
		"L_LOOTTABLE_TITLE" => $lang['Adr_loottable_title'],
		"L_LOOTTABLE_EXPLAIN" => $lang['Adr_loottable_title_explain'],
		"L_LOOTTABLE_NAME" => $lang['Adr_loottable_name'],
		"L_LOOTTABLE_DESC" => $lang['Adr_loottable_desc'],
		"L_LOOTTABLE_ITEMS" => $lang['Adr_loottable_items'],
		"L_LOOTTABLE_DROPCHANCE" => $lang['Adr_loottable_dropchance_title'],
		"L_LOOTTABLE_STATUS" => $lang['Adr_loottable_status'],
		"L_LOOTTABLE_ADD" => $lang['Adr_loottable_cat_add'],
		"L_LOOTTABLE_ACTION" => $lang['Action'],
		"L_LOOTTABLE_VIEW" => $lang['View'],
		"L_LOOTTABLE_EDIT" => $lang['Edit'],
		"L_LOOTTABLE_DELETE" => $lang['Delete'],
		'L_LOOTTABLE_ORDER' => $lang['Order'],
		'L_LOOTTABLE_SORT' => $lang['Sort'],
		'L_LOOTTABLE_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
		'S_LOOTTABLE_MODE_SELECT' => $select_sort_mode,
		'S_LOOTTABLE_ORDER_SELECT' => $select_sort_order,
		'LOOTTABLE_PAGINATION' => $pagination,
		'LOOTTABLE_PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_loottables / $board_config['topics_per_page'] )), 
		"S_LOOTTABLE_ACTION" => append_sid("admin_adr_loottables_cats.$phpEx?mode2=$mode2&amp;order=$sort_order"),
		"S_HIDDEN_FIELDS" => $s_hidden_fields, 
	));

	$template->pparse("body");
}

include('./page_footer_admin.'.$phpEx);

?>