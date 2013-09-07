<?php 
/***************************************************************************
 *					adr_character_inventory.php
 *				------------------------
 *	begin 			: 09/02/2004
 *	copyright			: Malicious Rabbit / Dr DLP
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

define('IN_PHPBB', true); 
define('IN_ADR_SHOPS', true); 
define('IN_ADR_CHARACTER', true); 
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'character';
$sub_loc = 'adr_character_inventory_spells';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 
// End session management
//

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$user_id = $userdata['user_id'];

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character_inventory_spells.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

if ( (!( isset($HTTP_POST_VARS[POST_USERS_URL]) || isset($HTTP_GET_VARS[POST_USERS_URL]))) || ( empty($HTTP_POST_VARS[POST_USERS_URL]) && empty($HTTP_GET_VARS[POST_USERS_URL])))
{ 
	$view_userdata = $userdata; 
} 
else 
{ 
	$view_userdata = get_userdata(intval($HTTP_GET_VARS[POST_USERS_URL])); 
} 
$searchid = $view_userdata['user_id'];
$colspan = 8;

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

$mode_types_text = array( $lang['Adr_shops_categories_item_name'] , $lang['Adr_items_type_use'] , $lang['Adr_items_power'] , $lang['Adr_items_level']);
$mode_types = array( 'name' , 'type' , 'quality' , 'power' , 'level' );

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
		$order_by = "i.item_type_use $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'level':
		$order_by = "i.spell_level $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'power':
		$order_by = "i.spell_power $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	default:
		$order_by = "i.spell_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
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
$categories = array( 18 , 19 , 20 );
$select_category = '<select name="cat">';
for($i = 0; $i < count($categories_text); $i++)
{
	$selected = ( $cat == $categories[$i] ) ? ' selected="selected"' : '';
	$select_category .= '<option value="' . $categories[$i] . '"' . $selected . '>' .$lang[$categories_text[$i]] . '</option>';
}
$select_category .= '</select>';


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
	// Prevent some jokes ...
	if ( $user_id != $searchid )
	{
		adr_previous( Adr_not_authed , adr_character_inventory_spells , '' );
	}

	switch($mode)
	{
		case 'delete' :

			// Define some values
			$items = ( isset($HTTP_POST_VARS['item_box']) ) ?  $HTTP_POST_VARS['item_box'] : array();

			$item_id_list .= '(';
			if ( count($items) > 0 )
			{	
				for($i = 0; $i < count($items); $i++)
				{
	   				$item_id_list .= $items[$i].',';
				}
			}
			$item_id_list .= '0)';

			$sql = "DELETE FROM " . ADR_SHOPS_SPELLS_TABLE ."
				WHERE spell_owner_id = $user_id ";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}
	
			adr_previous( Adr_shop_items_successful_deleted , adr_character_inventory_spells , '' );
			break;

		case 'view_item' :

			adr_template_file('adr_inventory_body_spells.tpl');
			$template->assign_block_vars('view_item',array());

			$item_owner_id = intval($HTTP_GET_VARS['item_owner_id']);
			$item_id = intval($HTTP_GET_VARS['item_id']);

			// All item info
			$sql = "SELECT i.* , t.item_type_lang , e.element_img FROM " . ADR_SHOPS_SPELLS_TABLE . " i
				LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
				LEFT JOIN " . ADR_ELEMENTS_TABLE . " e ON ( i.spell_element = e.element_id )
				WHERE i.spell_id = $item_id
				AND i.spell_owner_id = $item_owner_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$item_logo = $row['spell_icon'];

			if ( $row['spell_icon'] != '' )
			{
				$item_img = '<img src="adr/images/items/'.$item_logo.'">';
			}
			else
			{
				$item_img = '';
			}

			if ( $row['element_img'] != '' && $row['spell_element'] != 0 )
			{
				$element_img = '<img src="adr/images/elements/'. $row['element_img'] .'">';
			}
			else
			{
				$element_img = $lang['Adr_store_element_none'];
			}

			$template->assign_vars(array(
				"ROW_CLASS" => $theme['td_class1'],
				"ROW_CLASS_2" => $theme['td_class2'],
				"ACTION_SELECT" => $action_select,
				"ITEM_ID" => $row['spell_id'],
				"ITEM_NAME" => $row['spell_name'],
				"ITEM_DESC" => $row['spell_desc'],
				"ITEM_IMG" => $item_img,
				"ITEM_TYPE" => $lang[$row['item_type_lang']],
				"ITEM_POWER" => $row['spell_power'],
				"ITEM_ELEMENT" => $element_img,
				"ITEM_ADD_POWER" => $row['spell_add_power'], 
				"ITEM_MP" => $row['spell_mp_use'],
				"ITEM_POINTS" => $points_name,
				"SHOP_OWNER_ID" => $store_owner_id,
				"L_ITEM_POWER" => $lang['Adr_items_power'],
				"L_ITEM_ADD_POWER" => $lang['Adr_items_dex'], 
				"L_ITEM_MP" => $lang['Adr_items_mp_use'], 
				"L_ITEM_DESC" => $lang['Adr_store_desc'],
				"L_ITEM_DURA" => $lang['Adr_store_duration'],
				"L_ITEM_IMG" => $lang['Adr_races_image'],
				"L_ITEM_PRICE" => $lang['Adr_store_price'],
				"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
				"L_ITEM_WEIGHT" => $lang['Adr_store_weight'],
				"L_ITEM_ELEMENT" => $lang['Adr_store_element'],
				"L_ACTION" => $lang['Adr_items_action'],
				"L_SUBMIT" => $lang['Submit'],
			));

			break;

	}
}
else
{
	adr_template_file('adr_inventory_body_spells.tpl');
	$template->assign_block_vars('main',array());

	$sql = "SELECT i.* , t.item_type_lang FROM " . ADR_SHOPS_SPELLS_TABLE . " i
			LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
		WHERE i.spell_owner_id = $searchid
		$cat_sql
		ORDER BY $order_by";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query users items', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			$template->assign_block_vars('main.items', array(
				"ROW_CLASS" => $row_class,
				"ITEM_NAME" => adr_get_lang($row['spell_name']),
				"ITEM_DESC" => adr_get_lang($row['spell_desc']),
				"ITEM_IMG" => $row['spell_icon'],
				"ITEM_TYPE" => $lang[$row['item_type_lang']],
				"ITEM_POWER" => $row['spell_power'],
				"ITEM_ID" => $row['spell_id'],
				"U_ITEM_GIVE" => append_sid("adr_character_inventory_spells.$phpEx?mode=give&amp;item_id=".$row['spell_id']),
				"U_ITEM_SELL" => append_sid("adr_character_inventory_spells.$phpEx?mode=sell&amp;item_id=".$row['spell_id']),
				"U_ITEM_EDIT" => append_sid("adr_character_inventory_spells.$phpEx?mode=edit&amp;item_id=".$row['spell_id']),
				"U_ITEM_SHOP" => append_sid("adr_character_inventory_spells.$phpEx?mode=shop&amp;item_id=".$row['spell_id']),
				"U_ITEM_INFO" => append_sid("adr_character_inventory_spells.$phpEx?mode=view_item&amp;item_owner_id=".$row['spell_owner_id']."&amp;item_id=".$row['spell_id'].""),
			));

			if ( $user_id == $searchid )
			{
				$template->assign_block_vars("main.items.owner", array());
			}

			$i++;
		}
		while ( $row = $db->sql_fetchrow($result) );

	}

	if ( $user_id == $searchid )
	{
		$colspan = 9;
		$template->assign_block_vars("main.owner", array());

	}

	$cat_sql = ( $cat ) ? 'AND item_type_use = '.$cat : '';
	$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_SPELLS_TABLE ." 
		WHERE spell_owner_id = $searchid
		$cat_sql ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}
	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_items = $total['total'];
		$pagination = generate_pagination("adr_character_inventory_spells.$phpEx?".POST_USERS_URL."=$searchid&amp;mode2=$mode2&amp;order=$sort_order&amp;cat=$cat", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';	
	}

	$action_select = '<select name="mode">';
	$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
	$action_select .= '<option value = "delete">' . $lang['Dispose'] . '</option>';
	$action_select .= '</select>';

	// Check if power limit is enabled
	if ( $adr_general['item_power_level'] == 1 )
	{
		$lang_power = $lang['Adr_items_level'];
	}
	else
	{
		$lang_power = $lang['Adr_items_power'];
	}

	$template->assign_vars(array(
		"COLSPAN" => $colspan,
		"ACTION_LIST" => $action_select,
		'SELECT_CAT' => $select_category,
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )), 
		"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
		"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
		"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
		"L_ITEM_POWER" => $lang_power,
		"L_ITEM_LEVEL" => $lang['Adr_items_level'],
		"L_ACTION" => $lang['Adr_items_action'],
		"L_SELECT_CAT" => $lang['Adr_items_select'],
		"L_ITEM_IMG" => $lang['Adr_races_image'],
		"L_ITEM_PRICE" => $lang['Adr_items_price'],
		"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
		'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
		'L_ORDER' => $lang['Order'],
		'L_SORT' => $lang['Sort'],
		'L_GOTO_PAGE' => $lang['Goto_page'],
		'L_SUBMIT' => $lang['Submit'],
		'L_CHECK_ALL' => $lang['Adr_check_all'],
		'L_UNCHECK_ALL' => $lang['Adr_uncheck_all'],
		'S_MODE_SELECT' => $select_sort_mode,
		'S_ORDER_SELECT' => $select_sort_order,
		"S_ITEMS_ACTION" => append_sid("adr_character_inventory_spells.$phpEx?".POST_USERS_URL."=$searchid&amp;mode2=$mode2&amp;order=$sort_order&amp;cat=$cat"),
		"S_HIDDEN_FIELDS" => $s_hidden_fields, 
	));
}

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 