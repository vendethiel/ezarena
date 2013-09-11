<?php
/***************************************************************************
*                               admin_adr_give_users_spells.php
*                              -------------------
*		begin				: 2005/09/19
*		copyright			: Da Moose
*		Based on			: admin_adr_users and adr_shops by
*								Dr DLP / Malicious Rabbit
*		copyright           : Dr DLP / Malicious Rabbit
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

define('IN_PHPBB', true);
define('IN_ADR_ADMIN', true);
define('IN_ADR_USERS', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_SHOPS', true);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ADR Spells']['Give User Spells'] = $filename;
	return;
}

$phpbb_root_path = "./../";
$adr_image_path = $phpbb_root_path . "adr/images/items/";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/functions_selects.'.$phpEx);
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
$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;

if ( $mode != "" )
{
	switch( $mode )
	{
		case 'give' :
			adr_template_file('admin/config_adr_give_spell_body.tpl');
			$s_hidden_fields = '<input type="hidden" name="mode" value="give_item" />';
			$quantity = ($_POST['quantity']) ? intval($_POST['quantity']) : 1 ;			
			$s_hidden_fields .= '<input type="hidden" name="quantity" value="'.$quantity.'" />';
			// Define some values
			$items = ( isset($_POST['item_box']) ) ?  $_POST['item_box'] : array();
			$item_id_list .= '(';
			if ( count($items) > 0 )
			{	
				for($i = 0; $i < count($items); $i++)
				{
					$item_id_list .= $items[$i].',';
				}
			}

			$item_id_list .= '0)';
			$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . " 
				WHERE spell_owner_id = 1 
				AND spell_id IN $item_id_list 
				ORDER BY spell_name ";

			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}

			$items = $db->sql_fetchrowset($result);
			$items_name = '';
			while( list(,$item) = @each($items) )
			{
				$item_id = $item['spell_id'];
				$s_hidden_fields .= '<input type="hidden" name="'.$item_id.'" value="1" />';
				for ( $j = 0 ; $j < $quantity ; $j ++ )
				{
					$items_name .= adr_get_lang($item['spell_name']);
					$items_name .= '<br />';
				}
			}

			$sql = "SELECT * FROM " . ADR_CHARACTERS_TABLE . " 
				ORDER BY character_name ";

			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain character information', "", __LINE__, __FILE__, $sql);
			}
			$users = $db->sql_fetchrowset($result);
			$give_to = '<select name="give_to">';
			for ($t = 0 ; $t < count($users) ; $t++ )
			{
				$give_to .= '<option value = "'.$users[$t]['character_id'].'">' . $users[$t]['character_name'] . '</option>';
			}

			$give_to .= '</select>';
			$template->assign_vars(array(
				"GIVE_TO" => $give_to,
				"L_ITEM_DONATION" => sprintf($lang['Adr_items_donation'],'<br />'.$items_name),
				"L_GIVE_TO" => $lang['Adr_items_give_to'],
				"L_SUBMIT" => $lang['Submit'],
				"S_MODE_ACTION" => append_sid("admin_adr_give_users_spells.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
			));
			break;

		case 'give_item' :
			$quantity = ($_POST['quantity']) ? intval($_POST['quantity']) : 1 ;
			$to_user_id = ( !empty($_POST['give_to']) ) ? $_POST['give_to'] : $_GET['give_to'];
			$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . " 
				WHERE spell_owner_id = 1 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, $lang['Adr_shop_items_failure_deleted']);
			}

			$items = $db->sql_fetchrowset($result);
			while( list(,$item) = @each($items) )
			{
				if ( isset($_POST[$item['spell_id']]))
				{
					$item_id = $item['spell_id'];
					for ( $j = 0 ; $j < $quantity ; $j ++ )
					{
						adr_spell_add_new( $item_id, $to_user_id , 'admin_adr_give_users_spells');
					}
				}
			}

			adr_previous( Adr_spells_give_spell_success , admin_adr_give_users_spells , '' );

			break;
	}

}
else
{

	adr_template_file('admin/config_adr_give_user_spells_body.tpl');
	$template->assign_block_vars('view_store',array());
	if ( isset($_GET['mode2']) || isset($_POST['mode2']) )
	{
		$mode2 = ( isset($_POST['mode2']) ) ? htmlspecialchars($_POST['mode2']) :  htmlspecialchars($_GET['mode2']);
	}
	else
	{
		$mode2 = 'itemname';
	}
	if(isset($_POST['order']))
	{
		$sort_order = ($_POST['order'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else if(isset($_GET['order']))
	{
		$sort_order = ($_GET['order'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else
	{
		$sort_order = 'ASC';
	}
	if ( isset($_GET['cat']) || isset($_POST['cat']) )
	{
		$cat = ( isset($_POST['cat']) ) ? htmlspecialchars($_POST['cat']) : htmlspecialchars( $_GET['cat']);
	}
	else
	{
		$cat = 0;
	}

	$cat_sql = ( $cat ) ? 'AND i.item_type_use = '.$cat : '';
	$categories_text = array( Adr_items_type_spell_attack, Adr_items_type_magic_heal, Adr_items_type_spell_defend );
	$categories = array( 107, 108, 109);
	$select_category = '<select name="cat">';

	for($i = 0; $i < count($categories_text); $i++)
	{
		$selected = ( $cat == $categories[$i] ) ? ' selected="selected"' : '';
		$select_category .= '<option value="' . $categories[$i] . '"' . $selected . '>' .$lang[$categories_text[$i ]] . '</option>';
	}

	$select_category .= '</select>';
	$mode_types_text = array( $lang['Adr_shops_categories_item_name'] , $lang[ 'Adr_items_type_use'] , $lang['Adr_items_power'] );
	$mode_types = array( 'name', 'type' , 'power' );
	$select_sort_mode = '<select name="mode2">';

	for($i = 0; $i < count($mode_types_text); $i++)
	{
		$selected = ( $mode2 == $mode_types[$i] ) ? ' selected="selected"' : '';
		$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] .  '</option>';
	}
	$select_sort_mode .= '</select>';
	$select_sort_order = '<select name="order">';

	if($sort_order == 'ASC')
	{
		$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</ option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
	}
	else
	{
		$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC"  selected="selected">' . $lang['Sort_Descending'] . '</option>';
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

		case 'power':
			$order_by = "i.spell_power $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;

		default:
			$order_by = "i.spell_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
	}

	$sql = "SELECT i.* , t.item_type_lang FROM " . ADR_SHOPS_SPELLS_TABLE . " i
		LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
		WHERE i.spell_owner_id = 1
		$cat_sql
		ORDER BY $order_by";
			
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain a list of items', '', __LINE__, __FILE__, $sql);
	}

	$items = $db->sql_fetchrowset($result);

	$select_quantity = '<select name="quantity">';
	for($i = 1; $i < 21; $i++)
	{
		$select_quantity .= '<option value="' . $i . '">' .$i . '</option>';
	}
	$select_quantity .= '</select>';

	$action_select = '<select name="mode">';
	$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
	$action_select .= '<option value = "give">' . $lang['Adr_items_give'] . '</option>';
	$action_select .= '</select>';

	for($k = 0; $k < count($items); $k++)
	{
		$row_class = ( !($k % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$item_image = $adr_image_path . $items[$k]['spell_icon'];

		$template->assign_block_vars('view_store.items', array(
			"ROW_CLASS" => $row_class,
			"ITEM_ID" => $items[$k]['spell_id'],
			"ITEM_NAME" => adr_get_lang($items[$k]['spell_name']),
			"ITEM_DESC" => adr_get_lang($items[$k]['spell_desc']),
			"ITEM_IMG" => $item_image,
			"ITEM_TYPE" => $lang[$items[$k]['item_type_lang']],
			"ITEM_POWER" => $items[$k]['spell_power'],
			"SELECT_QUANTITY" => $select_quantity,
			));

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

	$cat_sql = ( $cat ) ? 'AND item_type_use = '.$cat : '';

	$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_SPELLS_TABLE . " 
		WHERE spell_owner_id = 1 
		$cat_sql";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total number of items', '', __LINE__, __FILE__, $sql);
	}

	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_items = $total['total'];
		$pagination = generate_pagination("admin_adr_give_users_spells.$phpEx?mode2=$mode2&amp;order=$sort_order", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';
	}
	$template->assign_vars(array(
		'ORDER_BY' => $order_by,
		'ACTION_SELECT' => $action_select,
		'SELECT_CAT' => $select_category,
		'SELECT_QUANTITY' => $select_quantity,
		'L_CHECK_ALL' => $lang['Adr_check_all'],
		'L_UNCHECK_ALL' => $lang['Adr_uncheck_all'],
		"L_SELECT_CAT" => $lang['Adr_items_select'],
		"L_SELECT_QUANTITY" => $lang['Adr_items_select_quantity'],
		"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
		"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
		"L_ITEM_POWER" => $lang_power,
		"L_ACTION" => $lang['Adr_items_action'],
		"L_ITEM_IMG" => $lang['Adr_races_image'],
		"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
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
		'S_MODE_ACTION' => append_sid("admin_adr_give_users_spells.$phpEx"),
	));
}
$template->assign_vars(array(
	'L_USER_TITLE' => $lang['Adr_user_admin'],
	'L_USER_EXPLAIN' => $lang['Adr_user_admin_explain'],
));

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>