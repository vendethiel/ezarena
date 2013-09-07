<?php
/***************************************************************************
*                               admin_adr_temple_donations.php
*                              -------------------
*     begin                : 08/02/2004
*     copyright            : Dr DLP / Malicious Rabbit
*     modified		   		: Seteo-Bloke
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
define('IN_ADR_TEMPLE', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ADR-Recipes']['Adr_temple_donations'] = $filename;

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
		case 'add_item':

			adr_template_file('admin/config_adr_temple_donations_edit_body.tpl');

			$template->assign_block_vars('add',array());

			$s_hidden_fields = '<input type="hidden" name="mode" value="savenew_item" /><input type="hidden" name="item_type" value="' . $item_type . '" />';

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
				$element_selected = ( $items['item_element'] == $element_list[$i]['element_id'] ) ? 'selected' : '';
				$element_weap_list .= '<option value = "'.$element_list[$i]['element_id'].'" '.$element_selected.' >' . $element_list[$i]['element_name'] . '</option>';
			}
			$element_weap_list .= '</select>';
			
			// Item chance
			$level[0] = $lang['Adr_temple_chance_common'];
			$level[1] = $lang['Adr_temple_chance_uncommon'];
			$level[2] = $lang['Adr_temple_chance_rare'];
			$level[3] = $lang['Adr_temple_chance_very_rare'];
			$level[4] = $lang['Adr_temple_chance_super_rare'];
			$level_list = '<select name="level">';
			for( $i = 0; $i < 5; $i++ )
			{
				$level_list .= '<option value = "'.$i.'" >' . $level[$i] . '</option>';
			}
			$level_list .= '</select>';

			$template->assign_vars(array(
				"ITEM_QUALITY" => adr_get_item_quality($items['item_quality'],'list'),
				"ITEM_TYPE" => adr_get_item_type($items['item_type_use'],'list'),
				"ITEM_ELEMENT_LIST" => $element_weap_list,
				"ITEM_ELEMENT_STR" => $items['item_element_str_dmg'],
				"ITEM_ELEMENT_SAME" => $items['item_element_same_dmg'],
				"ITEM_ELEMENT_WEAK" => $items['item_element_weak_dmg'],
				"ITEM_WEIGHT" => $items['item_weight'],
				"ITEM_AUTH" => ( $items['item_auth'] ) ? 'checked' : '',
				"ITEM_MAX_SKILL" => $items['item_max_skill'],
				"ITEM_SELL_BACK_PERCENT" => $items['item_sell_back_percentage'],
				"ITEM_CHANCE" => $level_list,
				"L_ITEM_CHANCE" => $lang['Adr_temple_chance'],
				"L_ITEM_CHANCE_EXPLAIN" => $lang['Adr_temple_chance_explain'],
				"L_ITEM_SELL_BACK_PERCENT" => $lang['Adr_item_sell_back'],
				"L_ITEM_SELL_BACK_PERCENT_EXPLAIN" => $lang['Adr_item_sell_back_explain'],
				"L_ITEM_ELEMENT" => $lang['Adr_shops_item_element'],
				"L_ITEM_ELEMENT_STR" => $lang['Adr_shops_item_element_str'],
				"L_ITEM_ELEMENT_SAME" => $lang['Adr_shops_item_element_same'],
				"L_ITEM_ELEMENT_WEAK" => $lang['Adr_shops_item_element_weak'],
				"L_ITEM_MAX_SKILL" => $lang['Adr_item_max_skill'],
				"L_ITEM_WEIGHT" => $lang['Adr_shops_item_weight'],
				"L_ITEM_STORE" => $lang['Adr_items_store'],
				"L_ITEM_ENHANCEMENTS" => $lang['Adr_items_enhancements'],
				"L_ITEM_ADD_POWER" => $lang['Adr_items_dex'],
				"L_ITEM_ADD_POWER_EXPLAIN" => $lang['Adr_items_dex_explain'],
				"L_ITEM_MP_USE" => $lang['Adr_items_mp_use'],
				"L_ITEM_MP_USE_EXPLAIN" => $lang['Adr_items_mp_use_explain'],
				"L_POINTS" => $board_config['points_name'],
				"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
				"L_ITEMS_TITLE" => $lang['Adr_shops_item_add_title'],
				"L_ITEMS_EXPLAIN" => $lang['Adr_shops_item_add_title_explain'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
				"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
				"L_ITEM_POWER" => $lang['Adr_items_power'],
				"L_ITEM_ENHANCEMENTS" => $lang['Adr_items_enhancements'],
				"L_ITEM_DURATION" => $lang['Adr_items_duration'],
				"L_ITEM_DURATION_MAX" => $lang['Adr_items_duration_max'],
				"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
				"L_CLASS_LIMIT" => $lang['Adr_items_class_limit'],
				"L_ITEM_AUTH" => $lang['Adr_store_auth'],
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
				"L_IMG_EXPLAIN" => $lang['Adr_items_image_explain'],
				"L_ITEM_ELEMENT" => $lang['Adr_shops_item_element'],
				"L_SUBMIT" => $lang['Submit'],
				"S_ITEMS_ACTION" => append_sid("admin_adr_temple_donations.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields,
			));

			$template->pparse("body");

		break;

		case 'delete_item':

			$item_id = ( !empty($HTTP_POST_VARS['item_id']) ) ? intval($HTTP_POST_VARS['item_id']) : intval($HTTP_GET_VARS['item_id']);

			$sql = "DELETE FROM " . ADR_TEMPLE_DONATIONS . "
				WHERE item_id = '$item_id'
				AND item_owner_id = 1 ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete item", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_shops_items_successful_deleted , admin_adr_temple_donations , '' );

		break;

		case 'edit_item':

			$item_id = ( !empty($HTTP_POST_VARS['item_id']) ) ? intval($HTTP_POST_VARS['item_id']) : intval($HTTP_GET_VARS['item_id']);

			adr_template_file('admin/config_adr_temple_donations_edit_body.tpl');
			$template->assign_block_vars('edit',array());

			$sql = "SELECT * FROM " . ADR_TEMPLE_DONATIONS . "
				WHERE item_id = '$item_id'
				AND item_owner_id = '1'";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}
			$items = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save_item" /><input type="hidden" name="item_id" value="' . $item_id . '" />';

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
				$element_selected = ( $items['item_element'] == $element_list[$i]['element_id'] ) ? 'selected' : '';
				$element_weap_list .= '<option value = "'.$element_list[$i]['element_id'].'" '.$element_selected.' >' . $element_list[$i]['element_name'] . '</option>';
			}
			$element_weap_list .= '</select>';
			
			// START chance drop down
			$level[0] = $lang['Adr_temple_chance_common'];
			$level[1] = $lang['Adr_temple_chance_uncommon'];
			$level[2] = $lang['Adr_temple_chance_rare'];
			$level[3] = $lang['Adr_temple_chance_very_rare'];
			$level[4] = $lang['Adr_temple_chance_super_rare'];
			$level_list = '<select name="level">';
			for( $i = 0; $i < 5; $i++ )
			{
				$selected = ( $i == $items['item_chance'] ) ? ' selected="selected"' : '';
				$level_list .= '<option value = "'.$i.'" '.$selected.' >' . $level[$i] . '</option>';
			}
			$level_list .= '</select>';

			$template->assign_vars(array(
				"ITEM_NAME" => $items['item_name'],
				"ITEM_DESC" => $items['item_desc'],
				"ITEM_NAME_EXPLAIN" => adr_get_lang($items['item_name']),
				"ITEM_DESC_EXPLAIN" => adr_get_lang($items['item_desc']),
				"ITEM_IMG" => $items['item_icon'],
				"ITEM_QUALITY" => adr_get_item_quality($items['item_quality'],'list'),
				"ITEM_TYPE" => adr_get_item_type($items['item_type_use'],'list'),
				"ITEM_DURATION" => $items['item_duration'],
				"ITEM_DURATION_MAX" => $items['item_duration_max'],
				"ITEM_POWER" => $items['item_power'],
				"ITEM_ADD_POWER" => $items['item_add_power'],
				"ITEM_MP_USE" => $items['item_mp_use'],
				"ITEM_PRICE" => $items['item_price'],
				"ITEM_ELEMENT_LIST" => $element_weap_list,
				"ITEM_ELEMENT_STR" => $items['item_element_str_dmg'],
				"ITEM_ELEMENT_SAME" => $items['item_element_same_dmg'],
				"ITEM_ELEMENT_WEAK" => $items['item_element_weak_dmg'],
				"ITEM_WEIGHT" => $items['item_weight'],
				"ITEM_AUTH" => ( $items['item_auth'] ) ? 'checked' : '',
				"ITEM_MAX_SKILL" => $items['item_max_skill'],
				"ITEM_SELL_BACK_PERCENT" => $items['item_sell_back_percentage'],
				"ITEM_CHANCE" => $level_list,
				"L_ITEM_CHANCE" => $lang['Adr_temple_chance'],
				"L_ITEM_CHANCE_EXPLAIN" => $lang['Adr_temple_chance_explain'],
				"L_ITEM_POWER" => $lang['Adr_items_power'],
				"L_ITEM_SELL_BACK_PERCENT" => $lang['Adr_item_sell_back'],
				"L_ITEM_SELL_BACK_PERCENT_EXPLAIN" => $lang['Adr_item_sell_back_explain'],
				"L_ITEM_ELEMENT" => $lang['Adr_shops_item_element'],
				"L_ITEM_ELEMENT_STR" => $lang['Adr_shops_item_element_str'],
				"L_ITEM_ELEMENT_SAME" => $lang['Adr_shops_item_element_same'],
				"L_ITEM_ELEMENT_WEAK" => $lang['Adr_shops_item_element_weak'],
				"L_ITEM_MAX_SKILL" => $lang['Adr_item_max_skill'],
				"L_ITEM_WEIGHT" => $lang['Adr_shops_item_weight'],
				"L_ITEM_ENHANCEMENTS" => $lang['Adr_items_enhancements'],
				"L_ITEM_ADD_POWER" => $lang['Adr_items_dex'],
				"L_ITEM_ADD_POWER_EXPLAIN" => $lang['Adr_items_dex_explain'],
				"L_ITEM_MP_USE" => $lang['Adr_items_mp_use'],
				"L_ITEM_MP_USE_EXPLAIN" => $lang['Adr_items_mp_use_explain'],
				"L_POINTS" => $board_config['points_name'],
				"L_NAME_EXPLAIN" => $lang['Adr_races_name_explain'],
				"L_ITEMS_TITLE" => $lang['Adr_shops_item_add_title'],
				"L_ITEMS_EXPLAIN" => $lang['Adr_shops_item_add_title_explain'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
				"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
				"L_ITEM_DURATION" => $lang['Adr_items_duration'],
				"L_ITEM_DURATION_MAX" => $lang['Adr_items_duration_max'],
				"L_ITEM_AUTH" => $lang['Adr_store_auth'],
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
				"L_IMG_EXPLAIN" => $lang['Adr_items_image_explain'],
				"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
				"L_SUBMIT" => $lang['Submit'],
				"S_ITEMS_ACTION" => append_sid("admin_adr_temple_donations.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields,
			));

			$template->pparse("body");

		break;

		case "save_item":

			$item_id = intval($HTTP_POST_VARS['item_id']);
			$item_name = ( isset($HTTP_POST_VARS['item_name']) ) ? trim($HTTP_POST_VARS['item_name']) : trim($HTTP_GET_VARS['item_name']);
			$item_desc = ( isset($HTTP_POST_VARS['item_desc']) ) ? trim($HTTP_POST_VARS['item_desc']) : trim($HTTP_GET_VARS['item_desc']);
			$item_icon = ( isset($HTTP_POST_VARS['item_img']) ) ? trim($HTTP_POST_VARS['item_img']) : trim($HTTP_GET_VARS['item_img']);
			$item_chance = intval($HTTP_POST_VARS['level']);
			$item_quality = intval($HTTP_POST_VARS['item_quality']);
			$item_type_use = intval($HTTP_POST_VARS['item_type_use']);
			$item_power = intval($HTTP_POST_VARS['item_power']);
			$item_add_power = intval($HTTP_POST_VARS['item_add_power']);
			$item_mp_use = intval($HTTP_POST_VARS['item_mp_use']);
			$item_duration = intval($HTTP_POST_VARS['item_duration']);
			$item_duration_max = intval($HTTP_POST_VARS['item_duration_max']);
			$item_price = intval($HTTP_POST_VARS['item_price']);
			$item_element = intval($HTTP_POST_VARS['element_weap_list']);
			$item_element_str = intval($HTTP_POST_VARS['item_element_str']);
			$item_element_same = intval($HTTP_POST_VARS['item_element_same']);
			$item_element_weak = intval($HTTP_POST_VARS['item_element_weak']);
			$item_weight = intval($HTTP_POST_VARS['item_weight']);
			$item_max_skill = intval($HTTP_POST_VARS['item_max_skill']);

			if ( !$item_price )
			{
				// If no price is defined , let's calculate the real item price
				$adr_general = adr_get_general_config();

				// Get the base and modifier price
				$adr_quality_price = adr_get_item_quality( $item_quality , price );
				$adr_type_price = adr_get_item_type( $item_type_use , price );

				// First define the base price
				$item_price = $adr_type_price;

				// Then apply the quality modifier
				$item_price = $item_price * ( ( $adr_quality_price / 100 ));

				// And now the power - it's a little more complicated
				$item_price = ( $item_power > 1 ) ? ( $item_price + ( $item_price * ( ( $item_power - 1 ) * ( $adr_general['item_modifier_power'] - 100 ) / 100 ))) : $item_price ;

				// Apply the duration penalty
				$item_price = abs($item_price / ($item_duration_max / $item_duration));

				// Finally let's use a non decimal value & add 10 %
				$item_price = ceil($item_price * 1.1);
			}

			$sql = "UPDATE " . ADR_TEMPLE_DONATIONS . "
				SET item_name = '" . str_replace("\'", "''", $item_name) . "',
					item_desc = '" . str_replace("\'", "''", $item_desc) . "',
					item_icon = '" . str_replace("\'", "''", $item_icon) . "',
					item_chance = $item_chance,
					item_quality = $item_quality,
					item_type_use = $item_type_use,
					item_power = $item_power,
					item_add_power = $item_add_power,
					item_mp_use = $item_mp_use,
					item_duration = $item_duration,
					item_duration_max = $item_duration_max,
					item_price = $item_price ,
					item_weight = $item_weight,
					item_max_skill = $item_max_skill ,
					item_element = $item_element,
					item_element_str_dmg = $item_element_str,
					item_element_same_dmg = $item_element_same,
					item_element_weak_dmg = $item_element_weak
				WHERE item_id = '$item_id'";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update shops items", "", __LINE__, __FILE__, $sql);
			}

			adr_previous(Adr_shops_items_successful_edited, admin_adr_temple_donations, '');

		break;

		case "savenew_item":

			$sql = "SELECT item_id FROM " . ADR_TEMPLE_DONATIONS ."
				ORDER BY item_id
				DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain races information', "", __LINE__, __FILE__, $sql);
			}
			$fields_data = $db->sql_fetchrow($result);
			$item_id = $fields_data['item_id'] + 1 ;

			$item_name = ( isset($HTTP_POST_VARS['item_name']) ) ? trim($HTTP_POST_VARS['item_name']) : trim($HTTP_GET_VARS['item_name']);
			$item_desc = ( isset($HTTP_POST_VARS['item_desc']) ) ? trim($HTTP_POST_VARS['item_desc']) : trim($HTTP_GET_VARS['item_desc']);
			$item_icon = ( isset($HTTP_POST_VARS['item_img']) ) ? trim($HTTP_POST_VARS['item_img']) : trim($HTTP_GET_VARS['item_img']);
			$item_chance = intval($HTTP_POST_VARS['level']);
			$item_quality = intval($HTTP_POST_VARS['item_quality']);
			$item_type = intval($HTTP_POST_VARS['item_type_use']);
			$item_power = intval($HTTP_POST_VARS['item_power']);
			$item_duration = intval($HTTP_POST_VARS['item_duration']);
			$item_duration_max = intval($HTTP_POST_VARS['item_duration_max']);
			$item_price = intval($HTTP_POST_VARS['item_price']);
			$item_add_power = intval($HTTP_POST_VARS['item_add_power']);
			$item_mp_use = intval($HTTP_POST_VARS['item_mp_use']);
			$item_element = intval($HTTP_POST_VARS['element_weap_list']);
			$item_element_str = intval($HTTP_POST_VARS['item_element_str']);
			$item_element_same = intval($HTTP_POST_VARS['item_element_same']);
			$item_element_weak = intval($HTTP_POST_VARS['item_element_weak']);
			$item_weight = intval($HTTP_POST_VARS['item_weight']);
			$item_max_skill = intval($HTTP_POST_VARS['item_max_skill']);

			if ($item_name == '' || !$item_power || !$item_duration )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			if ($item_price == '' )
			{
				// If no price is defined , let's calculate the real item price
				$adr_general = adr_get_general_config();

				// Get the base and modifier price
				$adr_quality_price = adr_get_item_quality( $item_quality , price );
				$adr_type_price = adr_get_item_type( $item_type , price );

				// First define the base price
				$item_price = $adr_type_price;

				// Then apply the quality modifier
				$item_price = $item_price * ( ( $adr_quality_price / 100 ));

				// And now the power - it's a little more complicated
				$item_price = ( $item_power > 1 ) ? ( $item_price + ( $item_price * ( ( $item_power - 1 ) * ( $adr_general['item_modifier_power'] - 100 ) / 100 ))) : $item_price ;

				// Apply the duration penalty
				$item_price = abs($item_price / ($item_duration_max / $item_duration));

				// Finally let's use a non decimal value & add 10 %
				$item_price = ceil($item_price * 1.1);
			}


			$sql = "INSERT INTO " . ADR_TEMPLE_DONATIONS . "
				( item_id , item_owner_id , item_chance , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_duration_max , item_power , item_add_power , item_mp_use , item_weight , item_max_skill , item_element , item_element_str_dmg , item_element_same_dmg , item_element_weak_dmg )
				VALUES ( $item_id , 1 , $item_chance , $item_type , '" . str_replace("\'", "''", $item_name) . "', '" . str_replace("\'", "''", $item_desc) . "' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_duration_max , $item_power , $item_add_power , $item_mp_use , $item_weight , $item_max_skill , $item_element , $item_element_str , $item_element_same , $item_element_weak )";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_shops_items_successful_added , admin_adr_temple_donations , '' );

		break;
	}
}
else
{
	adr_template_file('admin/config_adr_temple_donations_list_body.tpl');

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


	$mode_types_text = array( $lang['Adr_shops_categories_item_name'] , $lang['Adr_temple_chance'] , $lang['Adr_items_type_use'] , $lang['Adr_items_quality'] , $lang['Adr_items_power'] );
	$mode_types = array( 'name', 'chance' , 'type' , 'quality' , 'power' );

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
		case 'chance':
			$order_by = "i.item_chance $sort_order LIMIT $start, " . $board_config['topics_per_page'];
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

	$sql = "SELECT i.* , q.item_quality_lang , t.item_type_lang  FROM " . ADR_TEMPLE_DONATIONS . " i
			LEFT JOIN " . ADR_SHOPS_ITEMS_QUALITY_TABLE . " q ON ( i.item_quality = q.item_quality_id )
			LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
			WHERE i.item_owner_id = 1
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
		if($items[$k]['item_chance']=='0')$chance = $lang['Adr_temple_chance_common'];
		elseif($items[$k]['item_chance']=='1')$chance = $lang['Adr_temple_chance_uncommon'];
		elseif($items[$k]['item_chance']=='2')$chance = $lang['Adr_temple_chance_rare'];
		elseif($items[$k]['item_chance']=='3')$chance = $lang['Adr_temple_chance_very_rare'];
		elseif($items[$k]['item_chance']=='4')$chance = $lang['Adr_temple_chance_super_rare'];

		$template->assign_block_vars("items", array(
			"ROW_CLASS" => $row_class,
			"ITEM_NAME" => adr_get_lang($items[$k]['item_name']),
			"ITEM_DESC" => adr_get_lang($items[$k]['item_desc']),
			"ITEM_CHANCE" => $chance,
			"ITEM_IMG" => $items[$k]['item_icon'],
			"ITEM_TYPE" => $lang[$items[$k]['item_type_lang']],
			"ITEM_QUALITY" => $lang[$items[$k]['item_quality_lang']],
			"ITEM_DURATION" => $items[$k]['item_duration'],
			"ITEM_MAX_DURATION" => $items[$k]['item_duration_max'],
			"ITEM_POWER" => $items[$k]['item_power'],
			"ITEM_ADD_POWER" => $items[$k]['item_add_power'],
			"ITEM_MP_USE" => $items[$k]['item_mp_use'],
			"ITEM_PRICE" => $items[$k]['item_price'],
			"U_ITEM_EDIT" => append_sid("admin_adr_temple_donations.$phpEx?mode=edit_item&amp;item_id=" . $items[$k]['item_id']),
			"U_ITEM_DELETE" => append_sid("admin_adr_temple_donations.$phpEx?mode=delete_item&amp;item_id=" . $items[$k]['item_id']),
		));
	}

	$sql = "SELECT count(*) AS total FROM " . ADR_TEMPLE_DONATIONS . "
		WHERE item_owner_id = '1'";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}
	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_items = $total['total'];
		$pagination = generate_pagination("admin_adr_temple_donations.$phpEx?mode2=$mode2&amp;order=$sort_order&amp;cat=$cat", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';
	}

	$template->assign_vars(array(
		"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
		"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
		"L_ITEM_TITLE" => $lang['Adr_temple_title'],
		"L_ITEM_TEXT" => $lang['Adr_temple_title_explain'],
		"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
		"L_ADD_ITEM" => $lang['Adr_shops_item_add'],
		"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
		"L_ITEM_POWER" => $lang['Adr_items_power'],
		"L_ITEM_WEIGHT" => $lang['Adr_shops_item_weight'],
		"L_ITEM_DURATION" => $lang['Adr_items_duration'],
		"L_ITEM_CHANCE" => $lang['Adr_temple_chance'],
		"L_ITEM_CHANCE_EXPLAIN" => $lang['Adr_temple_chance_explain'],
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
        'SELECT_CAT' => $select_category,
     	'L_SELECT_CAT' => $lang['Adr_items_select'],
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )),
		'L_GOTO_PAGE' => $lang['Goto_page'],
		"L_GIVE" => $lang['Adr_items_give'],
		"L_SELL" => $lang['Adr_items_sell'],
		"L_EDIT" => $lang['Adr_items_edit'],
		"L_SHOP" => $lang['Adr_items_into_shop'],
		"S_SHOPS_ACTION" => append_sid("admin_adr_temple_donations.$phpEx?mode2=$mode2&amp;order=$sort_order"),
		"S_HIDDEN_FIELDS" => $s_hidden_fields,
	));

	$template->pparse("body");

}

include('./page_footer_admin.'.$phpEx);
?>
