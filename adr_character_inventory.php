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
define('IN_TOWNMAP_COPYRIGHT', true);
define('IN_ADR_TOWNMAP', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_SHOPS', true); 
define('IN_ADR_CHARACTER', true);
define('IN_ADR_BREWING', true);
define('IN_ADR_COOKING', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
$loc = 'character';
$sub_loc = 'adr_character_inventory';
//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
$user_id = $userdata['user_id'];
// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character_inventory.$phpEx";
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
$mode_types_text = array( $lang['Adr_shops_categories_item_name'] , $lang['Adr_items_price'] , $lang['Adr_items_type_use'] , $lang['Adr_items_quality'] , $lang['Adr_items_power'] , $lang['Adr_items_duration']);
$mode_types = array( 'name', 'price' , 'type' , 'quality' , 'power' , 'duration' );
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
	case 'duration':
		$order_by = "i.item_duration $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	default:
		$order_by = "i.item_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
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
$categories_text = array();
$categories = array();
$categories_cat = array();
adr_get_item_type_categories();
$select_category = '<select name="cat">';
$prev_cat = null;
for($i = 0; $i < count($categories_text); $i++)
{
	if($prev_cat != $categories_cat[$i]) $select_category .= '<option style="font-weight:bold;color:black" disabled>' . adr_get_lang($categories_cat[$i]) . '</option>';
	$selected = ( $cat == $categories[$i] ) ? ' selected="selected"' : '';
	$select_category .= '<option value="' . $categories[$i] . '"' . $selected . '>' . adr_get_lang($categories_text[$i]) . '</option>';
	$prev_cat = $categories_cat[$i];
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
if( isset($HTTP_POST_VARS['use_item']) || isset($HTTP_GET_VARS['use_item']) )
{
	$use_item = ( isset($HTTP_POST_VARS['use_item']) ) ? $HTTP_POST_VARS['use_item'] : $HTTP_GET_VARS['use_item'];
	$use_item = htmlspecialchars($use_item);
}
else
{
	$use_item = "";
}
if ( $mode != "" )
{
	// Prevent some jokes ...
	if ( $user_id != $searchid )
	{
		adr_previous( Adr_not_authed , adr_character_inventory , '' );
	}
	switch($mode)
	{
		case 'delete' :
			// Define some values
			$items = ( isset($HTTP_POST_VARS['item_box']) ) ?  $HTTP_POST_VARS['item_box'] : array();
			// Deny deletion  if the user is in a battle
			$sql = "SELECT battle_id FROM  " . ADR_BATTLE_LIST_TABLE . "
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
			$bat = $db->sql_fetchrow($result);
			if(is_numeric($bat['battle_id']))
				adr_previous(Adr_battle_no_delete_items, adr_character_inventory, '');
			$item_id_list .= '(';
			if ( count($items) > 0 )
			{	
				for($i = 0; $i < count($items); $i++)
				{
	   				$item_id_list .= $items[$i].',';
				}
			}
			$item_id_list .= '0)';
			$sql = "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE ."
				WHERE item_owner_id = $user_id 
				AND item_id IN $item_id_list
				AND item_in_shop = 0 ";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_shop_items_successful_deleted , adr_character_inventory , '' );
			break;
		case 'edit' :
			adr_template_file('adr_inventory_edit_body.tpl');
			// Define some values
			$items = ( isset($HTTP_POST_VARS['item_box']) ) ?  $HTTP_POST_VARS['item_box'] : array();
			if ( count($items) > 0 )
			{	
				for($i = 0; $i < count($items); $i++)
				{
	   				$item_id = $items[$i];
				}
			}
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE ."
				WHERE item_id = $item_id 
				AND item_owner_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				adr_previous( Adr_shop_items_failure_deleted , adr_character_inventory , '');
			}
			$items = $db->sql_fetchrow($result);
			$s_hidden_fields = '<input type="hidden" name="mode" value="save_item" /><input type="hidden" name="item_id" value="' . $item_id . '" />';
			$template->assign_vars(array(
				"ITEM_NAME" => adr_get_lang($items['item_name']),
				"ITEM_DESC" => adr_get_lang($items['item_desc']),
				"ITEM_PRICE" => $items['item_price'],
				"L_POINTS" => get_reward_name(),
				"L_NAME" => $lang['Adr_races_name'],
				"L_DESC" => $lang['Adr_races_desc'],
				"L_ITEM_PRICE" => $lang['Adr_items_price'],
				"L_ITEM_EDITION" => sprintf($lang['Adr_items_edition'],adr_get_lang($items['item_name'])),
				"L_SUBMIT" => $lang['Submit'],
				"S_ITEMS_ACTION" => append_sid("adr_character_inventory.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
			));
		break;
		case 'give' :
			adr_template_file('adr_inventory_give_body.tpl');
			$s_hidden_fields = '<input type="hidden" name="mode" value="give_item" />';
			$s_hidden_fields .= '<input type="hidden" name="cat" value="'.$cat.'" />';
			// Deny donations if the user is in a battle
			$sql = "SELECT battle_id FROM  " . ADR_BATTLE_LIST_TABLE . "
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
			$bat = $db->sql_fetchrow($result);
			if(is_numeric($bat['battle_id']))
				adr_previous(Adr_battle_no_give_items, adr_character_inventory, '');
			// Define some values
			$items = ( isset($HTTP_POST_VARS['item_box']) ) ?  $HTTP_POST_VARS['item_box'] : array();
			$item_id_list = '(' . implode(',', $items) . ',0)';
			// V: added item_no_sell here.
			$sql = "SELECT i.* FROM " . ADR_SHOPS_ITEMS_TABLE . " i
				WHERE i.item_owner_id = $user_id
				AND i.item_in_shop = 0
				AND i.item_no_sell = 0
				AND i.item_duration > 0 
				AND i.item_id IN $item_id_list 
				ORDER BY i.item_name ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}
			$items = $db->sql_fetchrowset($result);
			if (empty($items))
			{
				adr_previous('Adr_inventory_items_fail_selled', 'adr_character_inventory', '');
			}
			$items_name = '';
			while( list(,$item) = @each($items) )
			{
				$item_id = $item['item_id'];
				$s_hidden_fields .= '<input type="hidden" name="'.$item_id.'" value="1" />';
				$items_name .= adr_get_lang($item['item_name']);
				$items_name .= '<br />';
			}
			// V: add RCS
			$sql = "SELECT u.user_id, u.username, u.user_level, u.user_color, u.user_group_id,
					c.character_name, c.character_id
				FROM " . USERS_TABLE . " u,
					" . ADR_CHARACTERS_TABLE . " c
				WHERE u.user_id <> $user_id
				AND u.user_id = c.character_id
				ORDER by c.character_name";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not obtain user list', '', __LINE__, __FILE__, $sql);}
			$users = $db->sql_fetchrowset($result);
			$give_to = '<select name="give_to">';
			for($t = 0; $t < count($users); $t++){
				$give_to .= '<option value = "'.$users[$t]['character_id'].'">' . $rcs->get_colors($users[$t], $users[$t]['character_name']) . '&nbsp;('.$users[$t]['username'].')&nbsp;</option>';}
			$give_to .= '</select>';
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE ."
				WHERE item_id = $item_id 
				AND item_owner_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				adr_previous( Adr_shop_items_failure_deleted , adr_character_inventory , '');
			}
			$items = $db->sql_fetchrow($result);
			$template->assign_vars(array(
				"GIVE_TO" => $give_to,
				"L_ITEM_DONATION" => sprintf($lang['Adr_items_donation'],'<br />'.$items_name),
				"L_GIVE_TO" => $lang['Adr_items_give_to'],
				"L_SUBMIT" => $lang['Submit'],
				"S_ITEMS_ACTION" => append_sid("adr_character_inventory.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
			));
		break;
		case 'give_item' :
			$to_user_id = ( !empty($HTTP_POST_VARS['give_to']) ) ? $HTTP_POST_VARS['give_to'] : $HTTP_GET_VARS['give_to'];
			// Deny donations if the other user is in a battle
			$sql = "SELECT battle_id FROM  " . ADR_BATTLE_LIST_TABLE . "
				WHERE battle_challenger_id = '$to_user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
			$bat = $db->sql_fetchrow($result);
			if(is_numeric($bat['battle_id']))
				adr_previous(Adr_battle_no_give_items_2, adr_character_inventory, '');
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . " 
				WHERE item_owner_id = $user_id
				AND item_in_shop = 0
				AND item_no_sell = 0 
				AND item_duration > 0 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, $lang['Adr_shop_items_failure_deleted']);
			}
			$items = $db->sql_fetchrowset($result);
			while( list(,$item) = @each($items) )
			{
				if ( isset($HTTP_POST_VARS[$item['item_id']]))
				{
					$item_id = $item['item_id'];
					adr_give_item($user_id , $to_user_id , $item_id  );
				}
			}
			adr_previous( Adr_give_item_success , adr_character_inventory , '' );
		break;
		case "save_item":
			$item_id = intval($HTTP_POST_VARS['item_id']);
			$item_desc = ( isset($HTTP_POST_VARS['item_desc']) ) ? trim($HTTP_POST_VARS['item_desc']) : trim($HTTP_GET_VARS['item_desc']);
			$item_price = intval($HTTP_POST_VARS['item_price']);
			if ($item_price >= 0)
     		{ 
				$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
					SET item_desc = '" . str_replace("\'", "''", $item_desc) . "', 
						item_price = $item_price
					WHERE item_id = " . $item_id . "
					AND item_owner_id = $user_id ";
				if (!($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, $lang['Adr_shop_items_failure_deleted']);
				}
    		}
  			else
     		{   
        			message_die(GENERAL_ERROR, 'Negative amounts are not allowed');            
     		}
			adr_previous( Adr_inventory_items_successful_edited , adr_character_inventory , '' );
		break;
		case 'view_item' :
			adr_template_file('adr_inventory_body.tpl');
			$template->assign_block_vars('view_item',array());
			$item_owner_id = intval($HTTP_GET_VARS['item_owner_id']);
			$item_id = intval($HTTP_GET_VARS['item_id']);
			// All item info
			$sql = "SELECT i.* , q.item_quality_lang , t.item_type_lang , e.element_img FROM " . ADR_SHOPS_ITEMS_TABLE . " i
				LEFT JOIN " . ADR_SHOPS_ITEMS_QUALITY_TABLE . " q ON ( i.item_quality = q.item_quality_id )
				LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
				LEFT JOIN " . ADR_ELEMENTS_TABLE . " e ON ( i.item_element = e.element_id )
				WHERE i.item_id = $item_id
				AND i.item_owner_id = $item_owner_id
				AND i.item_auth = 0 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$item_logo = $row['item_icon'];
			$store_owner_id = $row['item_store_id'];
			if ( $row['item_icon'] != '' )
			{
				$item_img = '<img src="adr/images/items/'.$item_logo.'">';
			}
			else
			{
				$item_img = '';
			}
			if ( $row['element_img'] != '' && $row['item_element'] != 0 )
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
				"ITEM_ID" => $row['item_id'],
				"ITEM_NAME" => adr_get_lang($row['item_name']),
				"ITEM_DESC" => adr_get_lang($row['item_desc']),
				"ITEM_IMG" => $item_img,
				"ITEM_QUALITY" => $lang[$row['item_quality_lang']],
				"ITEM_TYPE" => $lang[$row['item_type_lang']],
				"ITEM_DURA" => $row['item_duration'],
				"ITEM_DURA_MAX" => $row['item_duration_max'],
				"ITEM_POWER" => $row['item_power'],
				"ITEM_PRICE" => $row['item_price'],
				"ITEM_WEIGHT" => $row['item_weight'],
				"ITEM_ELEMENT" => $element_img,
				"ITEM_ADD_POWER" => $row['item_add_power'], 
				"ITEM_MP" => $row['item_mp_use'],
				"ITEM_POINTS" => $points_name,
				"SHOP_OWNER_ID" => $store_owner_id,
				"L_ITEM_INFO" => 	$lang['Adr_store_item'],
				"L_ITEM_NAME" => $lang['Adr_store_name'],
				"L_ITEM_DESC" => $lang['Adr_store_desc'],
				"L_ITEM_QUALITY" => $lang['Adr_store_quality'],
				"L_ITEM_POWER" => $lang['Adr_store_power'],
				"L_ITEM_ADD_POWER" => $lang['Adr_items_dex'], 
				"L_ITEM_MP" => $lang['Adr_items_mp_use'], 
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
		case 'sell' :
			// Define some values
			$items = ( isset($_POST['item_box']) && is_array($_POST['item_box']) ) ?  $_POST['item_box'] : array();
			// Deny sale if the user is in a battle
			$sql = "SELECT battle_id FROM  " . ADR_BATTLE_LIST_TABLE . "
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
			$bat = $db->sql_fetchrow($result);
			if(is_numeric($bat['battle_id']))
				adr_previous('Adr_battle_no_sell_items', 'adr_character_inventory', '');
			$item_id_list = '('.implode(',', $items).',0)';
			$sql = "SELECT i.* FROM " . ADR_SHOPS_ITEMS_TABLE . " i
				WHERE i.item_owner_id = $user_id
				AND i.item_in_shop = 0
				AND i.item_duration > 0 
				AND i.item_auth = 0 
				AND i.item_no_sell = 0 
				AND i.item_id IN $item_id_list 
				ORDER BY i.item_name ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}
			$items = $db->sql_fetchrowset($result);
			$items_name = '';
			while( list(,$item) = @each($items) )
			{
				$item_id = $item['item_id'];
				$temp_price = adr_get_item_real_price($item_id , $user_id);
				$price = intval($price + adr_use_skill_trading($user_id , $temp_price , sell));
				$s_hidden_fields .= '<input type="hidden" name="'.$item_id.'" value="1" />';
			}
			adr_template_file('adr_confirm_body.tpl');
			$template->assign_block_vars('sell_item' , array());
			$s_hidden_fields .= '<input type="hidden" name="cat" value="'.$cat.'" />';
			$s_hidden_fields .= '<input type="hidden" name="mode" value="sell_item" />';
			$template->assign_vars(array(
				'MESSAGE_TITLE' => $lang['Adr_items_sell_confirm'],
				'MESSAGE_TEXT' => sprintf($lang['Adr_items_sell_confirm_price'], intval($price) , get_reward_name() ),
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],
				'S_SELL_CONFIRM_ACTION' => append_sid("adr_character_inventory.$phpEx"),
				'HIDDEN_FIELDS' => $s_hidden_fields, 
			));
		break;
		case 'sell_item' :
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . " 
				WHERE item_owner_id = $user_id
				AND item_in_shop = 0
				AND item_duration > 0
				AND item_auth = 0 
				AND item_no_sell = 0 
				AND item_monster_thief = 0 ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, $lang['Adr_shop_items_failure_deleted']);
			}
			$items = $db->sql_fetchrowset($result);
			while( list(,$item) = @each($items) )
			{
				if ( isset($HTTP_POST_VARS[$item['item_id']]))
				{
					$item_id = $item['item_id'];
					// Prevent selling of stolen items, if enabled
					if(($adr_general['Adr_shop_steal_sell'] === '1') && ($item['item_stolen_id'] > '0'))
					{
						$message = $lang['Adr_shop_stolen_no_sell'].'<br ><br />';
						$message .= sprintf($lang['Adr_shop_stolen_no_sell1'], '<b>', adr_get_lang($item['item_name']), '</b>');
						$message .= '<br /><br />'.$lang['Adr_shop_stolen_no_sell2'];
						$message .= '<br /><br />'.sprintf($lang['Adr_shop_inventory_link'], "<a href=\"" . 'adr_character_inventory.'.$phpEx . "\">", "</a>");
						message_die(GENERAL_MESSAGE, $message);
					}
					adr_sell_item($item_id , $user_id);
				}
			}
			adr_previous( 'Adr_inventory_items_successful_selled' , 'adr_character_inventory' , '' );
		break;
		case 'warehouse' :
			$sql = "SELECT character_warehouse FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			if ( $row['character_warehouse'] != 1 )
			{
				adr_previous( Adr_lack_warehouse , adr_character_inventory , '' );	
			}
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
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_owner_id = $user_id
				AND item_in_shop = 0
				AND item_duration > 0 
				AND item_auth = 0 
				AND item_monster_thief = 0 
				AND item_id IN $item_id_list 
				ORDER BY item_name ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}
			$items = $db->sql_fetchrowset($result);
			$items_name = '';
			while( list(,$item) = @each($items) )
			{
				$item_id = $item['item_id'];
				$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE ."
					SET item_in_warehouse = 1
					WHERE item_id = $item_id 
					AND item_owner_id = $user_id ";
				$result = $db->sql_query($sql);
				if( !$result )
				{
					adr_previous( 'Adr_shop_items_failure_deleted' , 'adr_character_inventory' , '');
				}
			}
			adr_previous( 'Adr_warehouse_items_successful_added' , 'adr_character_inventory' , '' );
		break;
		case 'shop' :
			$sql = "SELECT shop_id FROM " . ADR_SHOPS_TABLE . "
				WHERE shop_owner_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			if ( !(is_numeric($row['shop_id'])) )
			{
				adr_previous( 'Adr_lack_shops' , 'adr_character_inventory' , '' );	
			}
			// Deny access if the user is in a battle
			$sql = "SELECT battle_id FROM  " . ADR_BATTLE_LIST_TABLE . "
				WHERE battle_challenger_id = '$user_id'
				AND battle_result = '0'
				AND battle_type = '1'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
			$bat = $db->sql_fetchrow($result);
			if(is_numeric($bat['battle_id']))
				adr_previous('Adr_battle_no_move_to_shop', 'adr_character_inventory', '');
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
			$sql = "SELECT i.* FROM " . ADR_SHOPS_ITEMS_TABLE . " i
				WHERE i.item_owner_id = $user_id
				AND i.item_in_shop = 0
				AND i.item_duration > 0 
				AND i.item_auth = 0 
				AND i.item_no_sell = 0 
				AND i.item_id IN $item_id_list 
				ORDER BY i.item_name ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}
			$items = $db->sql_fetchrowset($result);
			$items_name = '';
			while( list(,$item) = @each($items) )
			{
				$item_id = $item['item_id'];
				$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE ."
					SET item_in_shop = 1
					WHERE item_id = $item_id 
					AND item_owner_id = $user_id ";
				$result = $db->sql_query($sql);
				if( !$result )
				{
					adr_previous( Adr_shop_items_failure_deleted , adr_character_inventory , '');
				}
			}
			// Set 'last updated' timestamp for user store
			$sql = "UPDATE " . ADR_SHOPS_TABLE ."
				SET shop_last_updated = ".time()."
				WHERE shop_owner_id = '$user_id'";
			$result = $db->sql_query($sql);
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not update last updated timestamp to personal store', "", __LINE__, __FILE__, $sql);
			}
			adr_previous( Adr_inventory_items_successful_added , adr_character_inventory , '' );
		break;
	}
}
else if ( $use_item != "" )
{
	switch($use_item)
	{
		case "use_food":
			$food_id = ( !empty($HTTP_POST_VARS['food_id']) ) ? intval($HTTP_POST_VARS['food_id']) : intval($HTTP_GET_VARS['food_id']);

			$used_food = adr_consume($food_id,$user_id);
			if ($used_food[0] == 1) {
				$direction = append_sid("adr_character_inventory.$phpEx");
				$message .= $used_food[1] .'<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;
				message_die( GENERAL_MESSAGE,$message);
			}
			else if ($used_food[0] == 0) {
				adr_previous ( Adr_food_used , adr_character_inventory , '' );
			}
		break;
		case "use_potion":
			$potion_id = ( !empty($HTTP_POST_VARS['potion_id']) ) ? intval($HTTP_POST_VARS['potion_id']) : intval($HTTP_GET_VARS['potion_id']);

			$used_potion = adr_consume($potion_id,$user_id);
			if ($used_potion[0] == 1) {
				$direction = append_sid("adr_character_inventory.$phpEx");
				$message .= $used_potion[1] .'<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;
				message_die( GENERAL_MESSAGE,$message);
			}
			else if ($used_potion[0] == 0) {
				adr_previous ( Adr_potion_used , adr_character_inventory , '' );
			}
		break;
		case "use_recipe";
			$recipe_id = ( !empty($HTTP_POST_VARS['recipe_id']) ) ? intval($HTTP_POST_VARS['recipe_id']) : intval($HTTP_GET_VARS['recipe_id']);
			$learn_recipe = adr_use_recipe($recipe_id,$user_id);
			if ($learn_recipe == 1)
				adr_previous ( Adr_recipe_successful_added , adr_character_inventory , '' );
			else if ($learn_recipe == 2)
				adr_previous ( Adr_recipe_was_delted , adr_character_inventory , '' );
			else if ($learn_recipe == 0)
				adr_previous ( Adr_recipe_already_known , adr_character_inventory , '' );
		break;
	}
}
else
{
	adr_template_file('adr_inventory_body.tpl');
	$template->assign_block_vars('main',array());
	// Grab all shop names for stolen infos later on
	$sql = "SELECT shop_id, shop_name FROM  " . ADR_SHOPS_TABLE . "
		WHERE shop_owner_id = '1'";
	$result = $db->sql_query($sql);
	if (!$result)
		message_die(GENERAL_ERROR, 'Could not obtain shop infos', '', __LINE__, __FILE__, $sql);
	$shop_info = $db->sql_fetchrowset($result);
	$sql = "SELECT i.* , q.item_quality_lang , t.item_type_lang FROM " . ADR_SHOPS_ITEMS_TABLE . " i
			LEFT JOIN " . ADR_SHOPS_ITEMS_QUALITY_TABLE . " q ON ( i.item_quality = q.item_quality_id )
			LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
		WHERE i.item_owner_id = $searchid
		AND i.item_in_shop = 0
		AND i.item_duration > 0
		AND i.item_in_warehouse < 1
		AND i.item_auth = 0 
		AND i.item_monster_thief = 0 
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
			$show_potion_link = '';
			$show_recipe_link = '';
			$show_food_link = '';
			if ($row['item_type_use'] == 19)
				$show_potion_link = '<br /><input class="mainoption" type="button" onclick="location=\'adr_character_inventory.'.$phpEx.'?use_item=use_potion&amp;potion_id='.$row['item_id'].'\'" value="'.$lang['adr_brewing_potion_link'].'">';
			if ($row['item_type_use'] == 20)
				$show_recipe_link = '<br /><input class="mainoption" type="button" onclick="location=\'adr_character_inventory.'.$phpEx.'?use_item=use_recipe&amp;recipe_id='.$row['item_id'].'\'" value="'.$lang['adr_brewing_recipe_link'].'">';
			if ($row['item_type_use'] == 94)
				$show_food_link = '<br /><input class="mainoption" type="button" onclick="location=\'adr_character_inventory.'.$phpEx.'?use_item=use_food&amp;food_id='.$row['item_id'].'\'" value="'.$lang['adr_cooking_food_link'].'">';
			if ( $row['item_no_sell'] == 1 ){
				$item_sellable = $lang['Adr_items_sellable_no'];
			}else{
				$item_sellable = $lang['Adr_items_sellable_yes'];
			}
			$template->assign_block_vars('main.items', array(
				"SHOW_POTION_LINK" => $show_potion_link,
				"SHOW_RECIPE_LINK" => $show_recipe_link,
				"SHOW_FOOD_LINK" => $show_food_link,
				"ROW_CLASS" => $row_class,
				"ITEM_NAME" => adr_get_lang($row['item_name']),
				"ITEM_SELLABLE" => $item_sellable,
				"ITEM_DESC" => adr_get_lang($row['item_desc']),
				"ITEM_IMG" => $row['item_icon'],
				"ITEM_QUALITY" => $lang[$row['item_quality_lang']],
				"ITEM_TYPE" => $lang[$row['item_type_lang']],
				"ITEM_DURATION" => $row['item_duration'],
				"ITEM_DURATION_MAX" => $row['item_duration_max'],
				"ITEM_POWER" => $row['item_power'],
				"ITEM_WEIGHT" => $row['item_weight'],
				"ITEM_PRICE" => $row['item_price'],
				"ITEM_ID" => $row['item_id'],
				"U_ITEM_GIVE" => append_sid("adr_character_inventory.$phpEx?mode=give&amp;item_id=".$row['item_id']),
				"U_ITEM_SELL" => append_sid("adr_character_inventory.$phpEx?mode=sell&amp;item_id=".$row['item_id']),
				"U_ITEM_EDIT" => append_sid("adr_character_inventory.$phpEx?mode=edit&amp;item_id=".$row['item_id']),
				"U_ITEM_SHOP" => append_sid("adr_character_inventory.$phpEx?mode=shop&amp;item_id=".$row['item_id']),
				"U_ITEM_INFO" => append_sid("adr_character_inventory.$phpEx?mode=view_item&amp;item_owner_id=".$row['item_owner_id']."&amp;item_id=".$row['item_id'].""),
			));
			##==== START: Check items' critical threat infos
			$crit_item_types = array('5', '6'); // only show for weaps, magic weaps
			if(($row['item_crit_hit'] != '20') && (in_array($row['item_type_use'], $crit_item_types)))
			{
				$crit_lang = ($row['item_crit_hit'] < '20') ? '['.$row['item_crit_hit'].'-20/'.$row['item_crit_hit_mod'].']' : $lang['Adr_item_crit_range_none'];
				$template->assign_block_vars('main.items.crit_hit', array(
					"L_CRIT_HIT" => $lang['Adr_item_crit_range'],
					"CRIT_HIT" => $crit_lang
				));
			}
			##==== END: Check items' critical threat infos
			##=== START: Show restrictions
			$align_array = explode(",", $row['item_restrict_align']);
			if($row['item_restrict_align_enable'] == '1')
			{
				$align_count = count($align_array);
				$align_list = '';
				for($r = 0; $r < $align_count; $r++)
				{
					// Cached sql query
					$align_info = adr_get_alignment_infos($align_array[$r]);
					$align_list .= adr_get_lang($align_info['alignment_name']);
					if($r < ($align_count - 2)){
						$align_list .= ", ";
					}
				}
				$template->assign_block_vars('main.items.align_restrict', array(
					"ALIGN_LIST" => $align_list,
					"L_ALIGN_LIST" => $lang['Adr_character_alignment']
				));
			}
			$class_array = explode(",", $row['item_restrict_class']);
			if($row['item_restrict_class_enable'] == '1')
			{
				$class_count = count($class_array);
				$class_list = '';
				for($c = 0; $c < $class_count; $c++)
				{
					// Cached sql query
					$class_info = adr_get_class_infos($class_array[$c]);
					$class_list .= adr_get_lang($class_info['class_name']);
					if($c < ($class_count - 2)){
						$class_list .= ", ";
					}
				}
				$template->assign_block_vars('main.items.class_restrict', array(
					"CLASS_LIST" => $class_list,
					"L_CLASS_LIST" => $lang['Adr_character_class']
				));
			}
			$element_array = explode(",", $row['item_restrict_element']);
			if($row['item_restrict_element_enable'] == '1')
			{
				$element_count = count($element_array);
				$element_list = '';
				for($e = 0; $e < $element_count; $e++)
				{
					// Cached sql query
					$element_info = adr_get_element_infos($element_array[$e]);
					$element_list .= adr_get_lang($element_info['element_name']);
					if($e < ($element_count - 2)){
						$element_list .= ", ";
					}
				}
				$template->assign_block_vars('main.items.element_restrict', array(
					"ELEMENT_LIST" => $element_list,
					"L_ELEMENT_LIST" => $lang['Adr_character_element']
				));
			}
			$race_array = explode(",", $row['item_restrict_race']);
			if($row['item_restrict_race_enable'] == '1')
			{
				$race_count = count($race_array);
				$race_list = '';
     			for($r = 0; $r < $race_count; $r++)
				{
					// Cached sql query
					$race_info = adr_get_race_infos($race_array[$r]);
					$race_list .= adr_get_lang($race_info['race_name']);
					if($r < ($race_count - 2)){
						$race_list .= ", ";
					}
				}
				$template->assign_block_vars('main.items.race_restrict', array(
					"RACE_LIST" => $race_list,
					"L_RACE_LIST" => $lang['Adr_character_race']
				));
			}
			##=== END: Show restrictions
			##=== START: Show any level or characteristic restrictions for this item
			$char_resist_list = '';
			if($row['item_restrict_level'] > '1'){ // level restriction. Has to be more than one otherwise pointless restriction
				$char_resist_list = $lang['Adr_char_lvl'].' ['.$row['item_restrict_level'].']; ';}
			if($row['item_restrict_str'] > '0'){ // Strength restriction. Has to be more than 0 otherwise pointless restriction
				$char_resist_list .= $lang['Adr_char_str'].' ['.$row['item_restrict_str'].']; ';}
			if($row['item_restrict_dex'] > '0'){ // Dexterity restriction. Has to be more than 0 otherwise pointless restriction
				$char_resist_list .= $lang['Adr_char_dex'].' ['.$row['item_restrict_dex'].']; ';}
			if($row['item_restrict_con'] > '0'){ // Constitution restriction. Has to be more than 0 otherwise pointless restriction
				$char_resist_list .= $lang['Adr_char_con'].' ['.$row['item_restrict_con'].']; ';}
			if($row['item_restrict_int'] > '0'){ // Intelligence restriction. Has to be more than 0 otherwise pointless restriction
				$char_resist_list .= $lang['Adr_char_int'].' ['.$row['item_restrict_int'].']; ';}
			if($row['item_restrict_wis'] > '0'){ // Wisdom restriction. Has to be more than 0 otherwise pointless restriction
				$char_resist_list .= $lang['Adr_char_wis'].' ['.$row['item_restrict_wis'].']; ';}
			if($row['item_restrict_cha'] > '0'){ // Charisma restriction. Has to be more than 0 otherwise pointless restriction
				$char_resist_list .= $lang['Adr_char_cha'].' ['.$row['item_restrict_cha'].']';}
			if(($row['item_restrict_level'] > '1') || ($row['item_restrict_str'] > '0') || ($row['item_restrict_dex'] > '0') || ($row['item_restrict_con'] > '0') || ($row['item_restrict_int'] > '0') || ($row['item_restrict_wis'] > '0') || ($row['item_restrict_cha'] > '0'))
			{
				$template->assign_block_vars('main.items.resist_chars', array(
					"CHAR_RESIST_LIST" => $char_resist_list,
					"L_CHAR_RESIST_LIST" => $lang['Adr_char_restrict_title']
				));
			}
			##=== END: Show any level or characteristic restrictions for this item
			##=== START: Show stolen info
			if($row['item_stolen_id'] > '0')
			{
				// Loop through the shop infos array and grab info
				for($s = 0; $s < count($shop_info); $s++){
					if($row['item_stolen_id'] == $shop_info[$s]['shop_id']){
						$shop_name = $shop_info[$s]['shop_name'];
					}
				}
				// Make sure we have a shop name!
				$shop_name = ($shop_name == '') ? 'Unknown' : adr_get_lang($shop_name);
				// Check who originally stole this item
				$user_infos = adr_get_user_infos($user_id);
				if($row['item_stolen_by'] === $user_infos['character_name']){
					$stolen_by = $lang['Adr_shop_stolen_by_you'];}
				elseif(($row['item_stolen_by'] != '') && ($row['item_stolen_by'] != $user_infos['character_name'])){
					$stolen_by = $row['item_stolen_by'];}
				else{
					$stolen_by = 'n/a';}
				$template->assign_block_vars('main.items.stolen_info', array(
					"L_STOLEN_INFO" => sprintf($lang['Adr_shop_stolen_info'], '<i><b>', '</b>', sprintf($lang['Adr_shop_stolen_by'], $stolen_by), $shop_name, date("D j M 'y", $row['item_stolen_timestamp']), '</i>')
				));
			}
			##=== END: Show stolen status
			##=== START: Show donated info
			if($row['item_donated_by'] != '')
			{
				$template->assign_block_vars('main.items.donated_info', array(
					"L_DONATED_INFO" => sprintf($lang['Adr_shop_donated_by'],'<i><b>' , '</b>', $row['item_donated_by'], date("D j M 'y", $row['item_donated_timestamp']), '</i>')
				));
			}
			##=== END: Show donated status
			// If viewer is owner then show additional options
			if($user_id == $searchid){
  				$template->assign_block_vars("main.items.owner", array());}
			$i++;
		}
		while ( $row = $db->sql_fetchrow($result) );
	}
	if ( $user_id == $searchid )
	{
		$colspan = 9;
		$template->assign_block_vars("main.owner", array());
		##== START: Showing weight bar ==##
		if($adr_general['weight_enable'] == '1')
		{
			$adr_user = adr_get_user_infos($user_id);
			$adr_user_race = adr_get_race_infos($adr_user['character_race']);
			$sql = "SELECT SUM(item_weight) AS total FROM  " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_owner_id = '$searchid'
				AND item_in_warehouse = '0'
				AND item_duration > '0'
				AND item_in_shop = '0'";
			if(!($result = $db->sql_query($sql))){
				message_die(CRITICAL_ERROR, 'Error Getting Adr Users!');}
			$weight = $db->sql_fetchrow($result);
			$max_weight = adr_weight_stats($adr_user['character_level'], $adr_user_race['race_weight'], $adr_user_race['race_weight_per_level'], $adr_user['character_might']);
			if($weight['total'] != '') $current_weight = $weight['total'];
			else $current_weight = 0;
			list($weight_percent_width, $weight_percent_empty) = adr_make_bars($current_weight, $max_weight, '200');
			$weight_details = ($current_weight > $max_weight) ? '<font="FF0000"><b>'.$current_weight.'</b></font> / '.$max_weight : $current_weight.' / '.$max_weight;
			// If overweight then show message in inventory
			if($current_weight > $max_weight){
				$template->assign_block_vars("main.owner.overweight", array(
					"L_WEIGHT_MSG" => $lang['Adr_character_overweight_error']
				));
			}
			$template->assign_vars(array(
				"WEIGHT" => $weight_details,
				"WEIGHT_PERCENT_WIDTH" => $weight_percent_width,
				"WEIGHT_PERCENT_EMPTY" => $weight_percent_empty,
				"L_WEIGHT" => $lang['Adr_character_weight']
			));
		}
		##== END: Showing weight bar ==##
		// Delete broken items from users inventory
		$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_duration < 1 
			AND item_owner_id = $user_id ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not delete broken items', '', __LINE__, __FILE__, $sql);
		}
	}
	$cat_sql = ( $cat ) ? 'AND item_type_use = '.$cat : '';
	$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_ITEMS_TABLE ." 
		WHERE item_owner_id = $searchid
		AND item_in_shop = 0
		AND item_duration > 0
		AND item_in_warehouse < 1
		AND item_monster_thief = 0  
		AND item_auth = 0 
		$cat_sql ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}
	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_items = $total['total'];
		$pagination = generate_pagination("adr_character_inventory.$phpEx?".POST_USERS_URL."=$searchid&amp;mode2=$mode2&amp;order=$sort_order&amp;cat=$cat", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';	
	}
	$action_select = '<select name="mode">';
	$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
	$action_select .= '<option value = "give">' . $lang['Adr_items_give'] . '</option>';
	$action_select .= '<option value = "sell">' . $lang['Adr_items_sell'] . '</option>';
	$action_select .= '<option value = "edit">' . $lang['Adr_items_edit'] . '</option>';
	$action_select .= '<option value = "delete">' . $lang['Dispose'] . '</option>';
	$action_select .= '<option value = "warehouse">' . $lang['Adr_items_into_warehouse'] . '</option>';
	$action_select .= '<option value = "shop">' . $lang['Adr_items_into_shop'] . '</option>';
	$action_select .= '</select>';
	$template->assign_vars(array(
		"COLSPAN" => $colspan + 1,
		"ACTION_LIST" => $action_select,
		'SELECT_CAT' => $select_category,
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )), 
		"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
		"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
		"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
		"L_ITEM_POWER" => $lang['Adr_store_power'],
		"L_ITEM_WEIGHT" => $lang['Adr_character_weight'],
		"L_ITEM_DURATION" => $lang['Adr_items_duration'],
		"L_ITEM_SELLABLE" => $lang['Adr_items_sellable'],
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
		'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
		'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
		'L_COPYRIGHT' => $lang['Adr_copyright'],
		'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
		'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
		'U_TOWNBOUTONRETOUR' => append_sid("adr_TownMap.$phpEx"),
		'S_MODE_SELECT' => $select_sort_mode,
		'S_ORDER_SELECT' => $select_sort_order,
		"S_ITEMS_ACTION" => append_sid("adr_character_inventory.$phpEx?".POST_USERS_URL."=$searchid&amp;mode2=$mode2&amp;order=$sort_order&amp;cat=$cat"),
		"S_HIDDEN_FIELDS" => isset($s_hidden_fields) ? $s_hidden_fields : '', 
	));
}
include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
