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
	$module['Adr_Items']['Spell Mod'] = $filename;

	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_functions_admin.'.$phpEx);

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

		case 'add_item':

			adr_template_file('admin/config_adr_shops_spells_edit_body.tpl');

			$template->assign_block_vars('add',array());

			$s_hidden_fields = '<input type="hidden" name="mode" value="savenew_item" /><input type="hidden" name="item_type" value="' . $item_type . '" />';

			//class list
			$sql = "SELECT *
				FROM " . ADR_CLASSES_TABLE;
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain classes information', "", __LINE__, __FILE__, $sql);
			$class_list = $db->sql_fetchrowset($result);

			$class_type = '<select name="item_class_limit[]" size="10" multiple>';
			$class_type .= '<option value = "0" SELECTED class="post">' . $lang['Adr_classes_all'] . '</option>';
			for( $i = 0; $i < count($class_list); $i++ )
				$class_type .= '<option value = "' . $class_list[$i]['class_id'] . '" class="post">' . adr_get_lang($class_list[$i]['class_name']) . '</option>';
			$class_type .= '</select>';

    			$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE ;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);
			}
			$element_list = $db->sql_fetchrowset($result);

			$element_weap_list = '<select name="element_weap_list">';
                  	$element_weap_list .= '<option value = "0" >' . $lang['Adr_items_element_none'] . '</option>';
                  	for( $i = 0; $i < count($element_list); $i++ )
                  	{
				$element_list[$i]['element_name'] = adr_get_lang($element_list[$i]['element_name']);
				$element_selected = ( $items['spell_element'] == $element_list[$i]['element_id'] ) ? 'selected' : '';
				$element_weap_list .= '<option value = "'.$element_list[$i]['element_id'].'" '.$element_selected.' >' . $element_list[$i]['element_name'] . '</option>';
                	}
                  	$element_weap_list .= '</select>';	

			$template->assign_vars(array(
				"ITEM_TYPE" => adr_get_item_type($items['item_type_use'],'list'),
                                "ITEM_CLASS_LIMIT" => $class_type,
				"ITEM_ELEMENT_LIST" => $element_weap_list,
				"ITEM_ELEMENT_STR" => $items['item_element_str_dmg'],
				"ITEM_ELEMENT_SAME" => $items['item_element_same_dmg'],
				"ITEM_ELEMENT_WEAK" => $items['item_element_weak_dmg'],
				"ITEM_MAX_SKILL" => $items['item_max_skill'],
                                "L_CLASS_LIMIT" => $lang['Adr_items_class_limit'],
                                "L_CLASS_LIMIT_EXPLAIN" => $lang['Adr_spells_class_explain'],
				"L_ITEM_ELEMENT" => $lang['Adr_shops_item_element'],
				"L_ITEM_ELEMENT_STR" => $lang['Adr_shops_item_element_str'],
				"L_ITEM_ELEMENT_SAME" => $lang['Adr_shops_item_element_same'],
				"L_ITEM_ELEMENT_WEAK" => $lang['Adr_shops_item_element_weak'],
				"L_ITEM_MAX_SKILL" => $lang['Adr_item_max_skill'],
				"L_ITEM_ENHANCEMENTS" => $lang['Adr_items_enhancements'],
				"L_ITEM_ADD_POWER" => $lang['Adr_items_dex'],
				"L_ITEM_ADD_POWER_EXPLAIN" => $lang['Adr_items_dex_explain'],
				"L_ITEM_MP_USE" => $lang['Adr_items_mp_use'],
				"L_ITEM_MP_USE_EXPLAIN" => $lang['Adr_items_mp_use_explain'],
				"L_POINTS" => $board_config['points_name'],
				"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
				"L_ITEMS_TITLE" => $lang['Adr_spells_add_title'],
				"L_ITEMS_EXPLAIN" => $lang['Adr_spells_add_title_explain'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
				"L_ITEM_LEVEL" => $lang['Adr_items_level'],
				"L_ITEM_POWER" => $lang['Adr_items_power'],
				"L_ITEM_ADD_POWER" => $lang['Adr_items_dex'],
				"L_ITEM_ADD_POWER_EXPLAIN" => $lang['Adr_items_dex_explain'],
				"L_ITEM_MP_USE" => $lang['Adr_items_mp_use'],
				"L_ITEM_MP_USE_EXPLAIN" => $lang['Adr_items_mp_use_explain'],
				"L_ITEM_TYPE" => $lang['Adr_spells_type'],
				"L_ITEM_TYPE_EXPLAIN" => $lang['Adr_spells_type_use_explain'],
				"L_NAME" => $lang['Adr_races_name'],
				"L_DESC" => $lang['Adr_races_desc'],
				"L_ACTION" => $lang['Action'],
				"L_ITEMS" => $lang['Adr_shops_categories_items'],
				"L_EDIT" => $lang['Edit'],
				"L_DELETE" => $lang['Delete'],
				"L_ITEM_IMG" => $lang['Adr_races_image'],
				"L_IMG" => $lang['Adr_races_image'],
				"L_IMG_EXPLAIN" => $lang['Adr_items_image_explain'],
				"L_ITEM_ELEMENT" => $lang['Adr_shops_item_element'],
				"L_SUBMIT" => $lang['Submit'],
				"S_ITEMS_ACTION" => append_sid("admin_adr_forums_shop_spells.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
			));

			$template->pparse("body");

		break;

		case 'delete_item':

			$item_id = ( !empty($HTTP_POST_VARS['item_id']) ) ? intval($HTTP_POST_VARS['item_id']) : intval($HTTP_GET_VARS['item_id']);

			$sql = "DELETE FROM " . ADR_SHOPS_SPELLS_TABLE . "
				WHERE spell_id = " . $item_id . "
				AND spell_owner_id = 1 ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete item", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_shops_items_successful_deleted , admin_adr_forums_shop_spells , '' );

		break;

		case 'edit_item':

			$item_id = ( !empty($HTTP_POST_VARS['item_id']) ) ? intval($HTTP_POST_VARS['item_id']) : intval($HTTP_GET_VARS['item_id']);

			adr_template_file('admin/config_adr_shops_spells_edit_body.tpl');
			$template->assign_block_vars('edit',array());

			$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . "
				WHERE spell_id = $item_id 
				AND spell_owner_id = 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}
			$items = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save_item" /><input type="hidden" name="item_id" value="' . $item_id . '" />';

			//class list
			$class_selected_array = explode( ',' , $items['spell_class'] );
			$sql = "SELECT *
					FROM " . ADR_CLASSES_TABLE;
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain classes information', "", __LINE__, __FILE__, $sql);
			$class_list = $db->sql_fetchrowset($result);

			$class_type = '<select name="item_class_limit[]" size="10" multiple>';
   			$class_type .= ( $class_selected_array[0] == '0' ) ? '<option value="0" SELECTED class="post">'. $lang['Adr_classes_all'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_classes_all'] .'</option>';
			for( $i = 0; $i < count($class_list); $i++ )
			{
				if ( in_array( $class_list[$i]['class_id'] , $class_selected_array ) )
					$class_type .= '<option value = "' . $class_list[$i]['class_id'] . '" SELECTED class="post">' . adr_get_lang($class_list[$i]['class_name']) . '</option>';
				else
					$class_type .= '<option value = "' . $class_list[$i]['class_id'] . '" class="post">' . adr_get_lang($class_list[$i]['class_name']) . '</option>';
			}
			$class_type .= '</select>';

                        $sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE ;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);
			}
			$element_list = $db->sql_fetchrowset($result);

			$element_weap_list = '<select name="element_weap_list">';
                  	$element_weap_list .= '<option value = "0" >' . $lang['Adr_items_element_none'] . '</option>';
                  	for( $i = 0; $i < count($element_list); $i++ )
                  	{
				$element_list[$i]['element_name'] = adr_get_lang($element_list[$i]['element_name']);
				$element_selected = ( $items['spell_element'] == $element_list[$i]['element_id'] ) ? 'selected' : '';
				$element_weap_list .= '<option value = "'.$element_list[$i]['element_id'].'" '.$element_selected.' >' . $element_list[$i]['element_name'] . '</option>';
                  	}
                  	$element_weap_list .= '</select>';	

			$template->assign_vars(array(
				"ITEM_NAME" => $items['spell_name'],
				"ITEM_DESC" => $items['spell_desc'],
                                "ITEM_CLASS_LIMIT" => $class_type,
				"ITEM_NAME_EXPLAIN" => adr_get_lang($items['spell_name']),
				"ITEM_DESC_EXPLAIN" => adr_get_lang($items['spell_desc']),
				"ITEM_IMG" => $items['spell_icon'],
				"ITEM_TYPE" => adr_get_item_type($items['item_type_use'],'list'),
				"ITEM_LEVEL" => $items['spell_level'],
				"ITEM_POWER" => $items['spell_power'],
				"ITEM_ADD_POWER" => $items['spell_add_power'],
				"ITEM_MP_USE" => $items['spell_mp_use'],
				"ITEM_ELEMENT_LIST" => $element_weap_list,
				"ITEM_ELEMENT_STR" => $items['spell_element_str_dmg'],
				"ITEM_ELEMENT_SAME" => $items['spell_element_same_dmg'],
				"ITEM_ELEMENT_WEAK" => $items['spell_element_weak_dmg'],
				"ITEM_MAX_SKILL" => $items['spell_max_skill'],
                                "L_CLASS_LIMIT" => $lang['Adr_items_class_limit'],
                                "L_CLASS_LIMIT_EXPLAIN" => $lang['Adr_spells_class_explain'],
				"L_ITEM_ELEMENT" => $lang['Adr_shops_item_element'],
				"L_ITEM_ELEMENT_STR" => $lang['Adr_shops_item_element_str'],
				"L_ITEM_ELEMENT_SAME" => $lang['Adr_shops_item_element_same'],
				"L_ITEM_ELEMENT_WEAK" => $lang['Adr_shops_item_element_weak'],
				"L_ITEM_MAX_SKILL" => $lang['Adr_item_max_skill'],
				"L_ITEM_ADD_POWER" => $lang['Adr_items_dex'],
				"L_ITEM_ADD_POWER_EXPLAIN" => $lang['Adr_items_dex_explain'],
				"L_ITEM_MP_USE" => $lang['Adr_items_mp_use'],
				"L_ITEM_MP_USE_EXPLAIN" => $lang['Adr_items_mp_use_explain'],
				"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
				"L_ITEMS_TITLE" => $lang['Adr_spells_add_title'],
				"L_ITEMS_EXPLAIN" => $lang['Adr_spells_add_title_explain'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
				"L_ITEM_LEVEL" => $lang['Adr_items_level'],
				"L_ITEM_POWER" => $lang['Adr_items_power'],
				"L_NAME" => $lang['Adr_races_name'],
				"L_DESC" => $lang['Adr_races_desc'],
				"L_ACTION" => $lang['Action'],
				"L_ITEMS" => $lang['Adr_shops_categories_items'],
				"L_EDIT" => $lang['Edit'],
				"L_DELETE" => $lang['Delete'],
				"L_ITEM_IMG" => $lang['Adr_races_image'],
				"L_IMG" => $lang['Adr_races_image'],
				"L_IMG_EXPLAIN" => $lang['Adr_items_image_explain'],
				"L_ITEM_TYPE" => $lang['Adr_spells_type'],
				"L_ITEM_TYPE_EXPLAIN" => $lang['Adr_spells_type_use_explain'],
				"L_SUBMIT" => $lang['Submit'],
				"S_ITEMS_ACTION" => append_sid("admin_adr_forums_shop_spells.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
			));

			$template->pparse("body");

		break;

		case "save_item":

			$item_id = intval($HTTP_POST_VARS['item_id']);
			$item_name = ( isset($HTTP_POST_VARS['item_name']) ) ? trim($HTTP_POST_VARS['item_name']) : trim($HTTP_GET_VARS['item_name']);
			$item_desc = ( isset($HTTP_POST_VARS['item_desc']) ) ? trim($HTTP_POST_VARS['item_desc']) : trim($HTTP_GET_VARS['item_desc']);
			$item_icon = ( isset($HTTP_POST_VARS['item_img']) ) ? trim($HTTP_POST_VARS['item_img']) : trim($HTTP_GET_VARS['item_img']);
			$item_type_use = intval($HTTP_POST_VARS['item_type_use']);
                        $item_power = intval($HTTP_POST_VARS['item_power']);
			$item_level = intval($HTTP_POST_VARS['item_level']);
			$item_add_power = intval($HTTP_POST_VARS['item_add_power']);
			$item_mp_use = intval($HTTP_POST_VARS['item_mp_use']);
			$item_element = intval($HTTP_POST_VARS['element_weap_list']);
			$item_element_str = intval($HTTP_POST_VARS['item_element_str']);
			$item_element_same = intval($HTTP_POST_VARS['item_element_same']);
			$item_element_weak = intval($HTTP_POST_VARS['item_element_weak']);	
			$item_max_skill = intval($HTTP_POST_VARS['item_max_skill']);
			$item_class = (isset($HTTP_POST_VARS['item_class_limit'])) ? $HTTP_POST_VARS['item_class_limit'] : array();
			$item_class_limit = adr_admin_make_array('1', $item_class);

			$sql = "UPDATE " . ADR_SHOPS_SPELLS_TABLE . "
				SET 	spell_name = '" . str_replace("\'", "''", $item_name) . "', 
					spell_desc = '" . str_replace("\'", "''", $item_desc) . "', 
					spell_icon = '" . str_replace("\'", "''", $item_icon) . "', 
					item_type_use = $item_type_use, 
					spell_class = '$item_class_limit', 
					spell_power = $item_power, 
					spell_level = $item_level, 
					spell_add_power = $item_add_power,
					spell_mp_use = $item_mp_use,
					spell_max_skill = $item_max_skill ,
					spell_element = $item_element,
					spell_element_str_dmg = $item_element_str,
					spell_element_same_dmg = $item_element_same,
					spell_element_weak_dmg = $item_element_weak 
				WHERE spell_id = " . $item_id . "
				AND spell_owner_id = 1 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update shops items", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_shops_items_successful_edited , admin_adr_forums_shop_spells , '' );

		break;

		case "savenew_item":

			$sql = "SELECT spell_id FROM " . ADR_SHOPS_SPELLS_TABLE ."
				ORDER BY spell_id 
				DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain races information', "", __LINE__, __FILE__, $sql);
			}
			$fields_data = $db->sql_fetchrow($result);
			$item_id = $fields_data['spell_id'] + 1 ;

			$item_name = ( isset($HTTP_POST_VARS['item_name']) ) ? trim($HTTP_POST_VARS['item_name']) : trim($HTTP_GET_VARS['item_name']);
			$item_desc = ( isset($HTTP_POST_VARS['item_desc']) ) ? trim($HTTP_POST_VARS['item_desc']) : trim($HTTP_GET_VARS['item_desc']);
			$item_icon = ( isset($HTTP_POST_VARS['item_img']) ) ? trim($HTTP_POST_VARS['item_img']) : trim($HTTP_GET_VARS['item_img']);
			$item_type = intval($HTTP_POST_VARS['item_type_use']);
			$item_power = intval($HTTP_POST_VARS['item_power']);
			$item_level = intval($HTTP_POST_VARS['item_level']);
			$item_add_power = intval($HTTP_POST_VARS['item_add_power']);
			$item_mp_use = intval($HTTP_POST_VARS['item_mp_use']);
			$item_element = intval($HTTP_POST_VARS['element_weap_list']);
			$item_element_str = intval($HTTP_POST_VARS['item_element_str']);
			$item_element_same = intval($HTTP_POST_VARS['item_element_same']);
			$item_element_weak = intval($HTTP_POST_VARS['item_element_weak']);	
			$item_max_skill = intval($HTTP_POST_VARS['item_max_skill']);
			$item_class = (isset($HTTP_POST_VARS['item_class_limit'])) ? $HTTP_POST_VARS['item_class_limit'] : array();
			$item_class_limit = adr_admin_make_array('1', $item_class);

			if ($item_name == '' || !$item_power || !$item_level )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}



			$sql = "INSERT INTO " . ADR_SHOPS_SPELLS_TABLE . " 
				( spell_id , spell_owner_id , item_type_use , spell_name , spell_desc , spell_icon , spell_power , spell_class , spell_level , spell_add_power , spell_mp_use , spell_max_skill , spell_element , spell_element_str_dmg , spell_element_same_dmg , spell_element_weak_dmg )
				VALUES ( $item_id , 1 , $item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_power , '$item_class_limit' , $item_level , $item_add_power , $item_mp_use , $item_max_skill , $item_element , $item_element_str , $item_element_same , $item_element_weak )";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_shops_items_successful_added , admin_adr_forums_shop_spells , '' );

		break;

	}
}
else
{
	adr_template_file('admin/config_adr_shops_spells_list_body.tpl');

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
		$cat = ( isset($HTTP_POST_VARS['cat']) ) ? htmlspecialchars($HTTP_POST_VARS['cat']) : htmlspecialchars($HTTP_GET_VARS['cat']);
	}
	else
	{
		$cat = 0;
	}
	$cat_sql = ( $cat ) ? 'AND i.item_type_use = '.$cat : '';

	$categories_text = array( Adr_items_type_magic_attack , Adr_items_type_magic_heal , Adr_items_type_magic_defend );
	$categories = array( 18 , 19 , 20);

	$select_category = '<select name="cat">';
	for($i = 0; $i < count($categories_text); $i++)
	{
		$selected = ( $cat == $categories[$i] ) ? ' selected="selected"' : '';
		$select_category .= '<option value="' . $categories[$i] . '"' . $selected . '>' .$lang[$categories_text[$i]] . '</option>';
	}
	$select_category .= '</select>';

	$mode_types_text = array( $lang['Adr_shops_categories_item_name'] , $lang['Adr_items_type_use'] , $lang['Adr_items_power'] );
	$mode_types = array( 'name', 'type' , 'power' );

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
			$order_by = "i.spell_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'type':
			$order_by = "i.spell_type_use $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'power':
			$order_by = "i.spell_power $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		default:
			$order_by = "i.spell_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
	}

	$sql = "SELECT i.* , t.item_type_lang , c.class_name FROM " . ADR_SHOPS_SPELLS_TABLE . " i
			LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
			LEFT JOIN " . ADR_CLASSES_TABLE . " c ON ( i.spell_class = c.class_id ) 
		WHERE i.spell_owner_id = 1
		$cat_sql
		ORDER BY $order_by";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
	}
	$items = $db->sql_fetchrowset($result);

	$s_hidden_fields = '<input type="hidden" name="mode" value="add_item" /><input type="hidden" name="item_type" value="' . $category_id . '" />';

	for($k = 0; $k < count($items); $k++)
	{
		$row_class = ( !($k % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
                if ( $items[$k]['spell_class'] == 0 )
                {
                $item_class_limit= $lang['Adr_items_type_all'];
                }
                else
                {
                $item_class_limit= $items[$k]['class_name'];
                }

		$template->assign_block_vars("items", array(
			"ROW_CLASS" => $row_class,
			"ITEM_NAME" => adr_get_lang($items[$k]['spell_name']),
                        "ITEM_CLASS_LIMIT" => adr_get_lang($item_class_limit),
                        "ITEM_DESC" => adr_get_lang($items[$k]['spell_desc']),
			"ITEM_IMG" => $items[$k]['spell_icon'],
			"ITEM_TYPE" => $lang[$items[$k]['item_type_lang']],
			"ITEM_POWER" => $items[$k]['spell_power'],
			"ITEM_LEVEL" => $items[$k]['spell_level'],
			"ITEM_ADD_POWER" => $items[$k]['spell_add_power'],
			"ITEM_MP_USE" => $items[$k]['spell_mp_use'],
			"U_ITEM_EDIT" => append_sid("admin_adr_forums_shop_spells.$phpEx?mode=edit_item&amp;item_id=" . $items[$k]['spell_id']), 
			"U_ITEM_DELETE" => append_sid("admin_adr_forums_shop_spells.$phpEx?mode=delete_item&amp;item_id=" . $items[$k]['spell_id']),
		));
	}

	$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_SPELLS_TABLE ." 
		WHERE spell_owner_id = 1 ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}
	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_items = $total['total'];
		$pagination = generate_pagination("admin_adr_forums_shop_spells.$phpEx?mode2=$mode2&amp;order=$sort_order&amp;cat=$cat", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';	
	}

	$template->assign_vars(array(
		"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
		"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
		"L_ITEM_TITLE" => $lang['Adr_spells_title'],
		"L_ITEM_TEXT" => $lang['Adr_spells_title_explain'],
		"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
                "L_ITEM_CLASS_LIMIT" => $lang['Adr_items_class_limit'],
                "L_ADD_ITEM" => $lang['Adr_shops_item_add'],
		"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
		"L_ITEM_POWER" => $lang['Adr_items_power'],
		"L_ITEM_LEVEL" => $lang['Adr_items_level'],
		"L_ACTION" => $lang['Action'],
		"L_ITEMS" => $lang['Adr_shops_categories_items'],
		"L_EDIT" => $lang['Edit'],
		"L_DELETE" => $lang['Delete'],
		"L_ITEM_IMG" => $lang['Adr_races_image'],
		'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
		'L_ORDER' => $lang['Order'],
		'L_SORT' => $lang['Sort'],
		'L_SUBMIT' => $lang['Sort'],
		'S_MODE_SELECT' => $select_sort_mode,
		'S_ORDER_SELECT' => $select_sort_order,
		'SELECT_CAT' => $select_category,
		'L_SELECT_CAT' => $lang['Adr_items_select'],
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )), 
		'L_GOTO_PAGE' => $lang['Goto_page'],
		"L_GIVE" => $lang['Adr_items_give'],
		"L_SELL" => $lang['Adr_items_sell'],
		"L_EDIT" => $lang['Adr_items_edit'],
		"L_SHOP" => $lang['Adr_items_into_shop'],
		"S_SHOPS_ACTION" => append_sid("admin_adr_forums_shop_spells.$phpEx?mode2=$mode2&amp;order=$sort_order"),
		"S_HIDDEN_FIELDS" => $s_hidden_fields, 
	));

	$template->pparse("body");
}

include('./page_footer_admin.'.$phpEx);

?>