<?php 
/***************************************************************************
 *					adr_shops.php
 *				------------------------
 *	begin 			: 08/02/2004
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


define('IN_ADR_SHOPS', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_CELL', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_TEMPLE', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'shops';
$sub_loc = 'adr_shops';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$user_id = $userdata['user_id'];
$points = $userdata['user_points'];
$character_id = $userdata['username'];

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_shops.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_shops_body.tpl');

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);


//
//BEGIN zone Shops Restriction
//
$zone_user = adr_get_user_infos($user_id);
$info = zone_get($zone_user['character_area']);
$actual_zone = $zone_user['character_area'];

$access = $info['zone_shops'];

if ( $access == '0' )
	adr_previous( Adr_zone_building_noaccess , adr_zones , '' );
//
//END zone Shops Restriction
//

// Deny access if the user is into a battle or is imprisoned
adr_battle_cell_check($user_id, $userdata);

$points_name = get_reward_name() ? get_reward_name() : $lang['Adr_default_points_name'];
$quantity = isset($HTTP_POST_VARS['quantity']) ? intval($HTTP_POST_VARS['quantity']) : 1 ;

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$item_id = isset($HTTP_GET_VARS['item_id']) ? intval($HTTP_GET_VARS['item_id']) : 0;
$shop_owner_id = isset($HTTP_GET_VARS['shop_owner_id']) ? intval($HTTP_GET_VARS['shop_owner_id']) : 0;
$shop_id = isset($HTTP_GET_VARS['shop_id']) ? intval($HTTP_GET_VARS['shop_id']) : 0;
### START restriction checks ###
$adr_user = adr_get_user_infos($user_id);
$item_sql = adr_make_restrict_sql($adr_user);
### END restriction checks ###

// V: this was missing... but it is important...
$show_only_mine = !empty($_GET['show_only_mine']);

if ( isset($HTTP_POST_VARS['mode']) && !empty($HTTP_POST_VARS['mode']) )
{
	$mode = htmlspecialchars($HTTP_POST_VARS['mode']); 
}
else if ( isset($HTTP_GET_VARS['mode']) )
{
	$mode = htmlspecialchars($HTTP_GET_VARS['mode']); 
}
else
{
	$mode = "view_store_list";
}

if (!$shop_id && !$shop_owner_id && in_array($mode, array('buy', 'buy_admin', 'steal')))
{ // V: TODO few others use "store_id" check there as well?
	adr_previous ( Adr_store_closed_msg , 'adr_shops' , '' );
}
if ( !$shop_id )
{
	$sql = "SELECT * FROM " . ADR_SHOPS_TABLE . "
		WHERE shop_owner_id = $shop_owner_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$shop_id = intval($row['shop_id']);
}


if ( $mode != "" )
{
	switch($mode)
	{

		case 'buy':

			// Define some values
			$shop_id = intval($HTTP_GET_VARS['shop_id']);
			if(!$shop_id) $shop_id = 1;
			$store_id = intval($HTTP_POST_VARS['store_id']);
			if(!$store_id) $store_id = 0;
			$shop_owner_id = intval($HTTP_POST_VARS['shop_owner_id']);
			if(!$shop_owner_id) $shop_owner_id = 1;
			$items = (isset($HTTP_POST_VARS['item_box'])) ? $HTTP_POST_VARS['item_box'] : array();
			$buying_checks = FALSE;
			// Check is buying from forum or user store
			$sql_buy_check = ($shop_owner_id != '1') ? 'AND item_in_shop = 1' : '';

			// Grab all inventory array..fetchrowset will save on ALOT of sql queries here!
			$sql = "SELECT * FROM ". ADR_SHOPS_ITEMS_TABLE ."
				WHERE item_owner_id = '$shop_owner_id'
				$sql_buy_check
				AND item_no_sell = 0 
				AND item_in_warehouse = '0'
				AND item_monster_thief = '0'";
			$result = $db->sql_query($sql);
			if (!$result)
				message_die(GENERAL_ERROR, 'Could not obtain inventory infos', '', __LINE__, __FILE__, $sql);
			$invent_array = $db->sql_fetchrowset($result);

			if(count($items) > '0'){
				// First check if enough quota for trade
				if(($adr_general['Adr_character_limit_enable'] != '0') && ($adr_user['character_trading_limit'] < '1'))
					adr_previous(Adr_trading_limit, adr_shops, '');

				for($i = 0; $i < count($items); $i++){
					$item_id = $items[$i];
					$nav = "view_store&amp;shop_id=".$shop_id."";
					$item_price = 0;
					$new_item_id = $items[$i];

					for($j = 0; $j < $quantity; $j++){
						for($in = 0; $in < count($invent_array); $in++){
							if($new_item_id == $invent_array[$in]['item_id']){
								$item_price = (adr_use_skill_trading($user_id, $invent_array[$in]['item_price'], buy) + $item_price);
							}
						}
					}

					// Check for user_points
					if(get_reward($user_id) < $item_price){
						adr_previous(Adr_lack_points, adr_shops, $nav);}
					else{
						for($j = 0; $j < $quantity; $j++){
							$price = adr_buy_item($user_id, $item_id, $shop_owner_id, $shop_id, adr_shops, "see_shop&amp;shop_id=".$shop_id."");
							$sum = intval($sum + $price);
							$buying_checks = TRUE;
						}
					}
				}
			}

			// Remove quota
			if($buying_checks && $adr_general['Adr_character_limit_enable'] == '1')
			{
				adr_trading_limit($user_id);
			}

			if($shop_owner_id > '1'){
				// Update user store transaction log
				if(count($items) > '0'){
					adr_update_store_user_trans($user_id, $shop_owner_id, $items, $sum, $invent_array);
				}

				$direction = append_sid("adr_shops.$phpEx?mode=see_shop&amp;shop_id=".$shop_id);
			}
			elseif($shop_owner_id == '1'){
				// Update store status
				adr_update_store_status($user_id, $store_id, $items, $quantity);
				$direction = append_sid("adr_shops.$phpEx?mode=view_store&amp;shop_id=".$shop_id);
			}

			// Create confirmation msg
			$message = sprintf($lang['Adr_buy_item_success'], $sum, $points_name);
			$message .= '<br /><br />'.sprintf($lang['Adr_return'], "<a href=\"" . $direction . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'buy_admin' :

			// Define some values
			$shop_id = intval($HTTP_GET_VARS['shop_id']);
			if ( !$shop_id ) $shop_id = 1;
			$shop_owner_id = intval($HTTP_POST_VARS['shop_owner_id']);
			if ( !$shop_owner_id ) $shop_owner_id = 1;
			$items = ( isset($HTTP_POST_VARS['item_box']) ) ?  $HTTP_POST_VARS['item_box'] : array();

			if ( count($items) > 0 )
			{	
				for($i = 0; $i < count($items); $i++)
				{
	   				$item_id = $items[$i];
   
					for ( $j = 0 ; $j < $quantity ; $j ++ )
					{
						$sum = intval($sum + adr_buy_admin_item($user_id , $item_id , $shop_owner_id , $shop_id , adr_shops , "?mode=see_shop&amp;shop_id=".$shop_id."") );
					}
				}
			}

			$direction = append_sid("adr_shops.$phpEx?mode=view_store_admin");				

			$message = $lang['Adr_admin_move_success'];
			$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;

			message_die ( GENERAL_MESSAGE , $message );

			break;

		case 'steal':

			// Define some values
			$shop_id = intval($HTTP_GET_VARS['shop_id']);
			if(!$shop_id) $shop_id = 1;
			$shop_owner_id = intval($HTTP_POST_VARS['shop_owner_id']);
			$store_id = intval($HTTP_POST_VARS['store_id']);
			if(!$store_id) $store_id = 0;

			$items = (isset($HTTP_POST_VARS['item_box'])) ?  $HTTP_POST_VARS['item_box'] : array();

			// Loop is broken after item 1 to prevent numerous steals...easier to manage.
			if(count($items) > '0'){
				for($i = 0; $i < count($items); $i++){
	   				$item_id = $items[$i];
					adr_steal_item($user_id, $item_id, $shop_owner_id, $shop_id);
					break;
				}
			}

			break;

		case 'give' :

			adr_template_file('adr_inventory_give_body.tpl');

			$s_hidden_fields = '<input type="hidden" name="mode" value="give_item" />';
			$s_hidden_fields .= '<input type="hidden" name="cat" value="'.$cat.'" />';

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
				AND i.item_auth = 1 
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
				$s_hidden_fields .= '<input type="hidden" name="'.$item_id.'" value="1" />';
				$items_name .= adr_get_lang($item['item_name']);
				$items_name .= '<br />';
			}
			$sql = "SELECT * FROM " . USERS_TABLE . "
				WHERE user_id > 1 
				AND user_id <> $user_id 
				ORDER BY username ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}
			$users = $db->sql_fetchrowset($result);

			$give_to = '<select name="give_to">';
			for ($t = 0 ; $t < count($users) ; $t++ )
			{
				$give_to .= '<option value = "'.$users[$t]['user_id'].'">' . $users[$t]['username'] . '</option>';
			}
			$give_to .= '</select>';

			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE ."
				WHERE item_id = $item_id 
				AND item_owner_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				adr_previous( Adr_shop_items_failure_deleted , adr_shops , '');
			}
			$items = $db->sql_fetchrow($result);

			$template->assign_vars(array(
				"GIVE_TO" => $give_to,
				"L_ITEM_DONATION" => sprintf($lang['Adr_items_donation'],'<br />'.$items_name),
				"L_GIVE_TO" => $lang['Adr_items_give_to'],
				"L_SUBMIT" => $lang['Submit'],
				"S_ITEMS_ACTION" => append_sid("adr_shops.$phpEx"),
				"S_HIDDEN_FIELDS" => $s_hidden_fields, 
			));

		break;

		case 'give_item' :

			$to_user_id = ( !empty($HTTP_POST_VARS['give_to']) ) ? $HTTP_POST_VARS['give_to'] : $HTTP_GET_VARS['give_to'];

			// V: changed this to require item_owner_id == $user_id (instead of 1, wtf?)
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . " 
				WHERE item_owner_id = $user_id
				AND item_in_shop = 0
				AND item_duration > 0 
				AND item_auth = 1 ";
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

			adr_previous( Adr_give_item_success , adr_shops , '' );

		break;

		case 'sell' :

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
				'S_SELL_CONFIRM_ACTION' => append_sid("adr_shops.$phpEx"),
				'HIDDEN_FIELDS' => $s_hidden_fields, 
			));

		break;

		case 'create_shop' :

			$sql = "SELECT shop_id FROM " . ADR_SHOPS_TABLE . "
				WHERE shop_owner_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			if ( is_numeric($row['shop_id']) )
			{
				adr_previous ( Adr_users_shops_already , adr_shops , '' );	
			}
			else
			{
				$template->assign_block_vars('create_shop',array());	
			}

			$adr_general = adr_get_general_config();

			$template->assign_vars(array(
				'L_CREATE_NEW_SHOP' => $lang['Adr_users_shops_create'],
				'L_CREATE_NEW_SHOP_PRICE' => sprintf( $lang['Adr_users_shops_create_price'], $adr_general['new_shop_price'] , get_reward_name() ),
				'L_CREATE_NEW_SHOP_NAME' => $lang['Adr_users_shops_create_name'],
				'L_CREATE_NEW_SHOP_DESC' => $lang['Adr_users_shops_create_desc'],
				'L_SUBMIT' => $lang['Submit'],
			));

			break;

		case 'delete_item' :

			// Define some values
			$shop_id = intval($HTTP_GET_VARS['shop_id']);
			if ( !$shop_id ) $shop_id = 1;
			$shop_owner_id = intval($HTTP_POST_VARS['shop_owner_id']);

			$items = ( isset($HTTP_POST_VARS['item_box']) ) ?  $HTTP_POST_VARS['item_box'] : array();

			if ( count($items) > 0 )
			{	
				for($i = 0; $i < count($items); $i++)
				{
	   				$item_id = $items[$i];
					$sql = "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE ."
						WHERE item_owner_id = $user_id 
						AND item_id = $item_id
						AND item_in_shop = 1 ";
					if( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
					}
				}
			}
			
			adr_previous( Adr_shop_items_successful_deleted , adr_shops , "mode=see_shop&amp;shop_id=".$shop_id."" );
			break;

		case 'inventory' :

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
				adr_previous( Adr_lack_shops , adr_character_inventory , '' );	
			}

			// Define some values
			$shop_id = intval($HTTP_GET_VARS['shop_id']);
			if ( !$shop_id ) $shop_id = 1;
			$shop_owner_id = intval($HTTP_POST_VARS['shop_owner_id']);

			$items = ( isset($HTTP_POST_VARS['item_box']) ) ?  $HTTP_POST_VARS['item_box'] : array();

			if ( count($items) > 0 )
			{	
				for($i = 0; $i < count($items); $i++)
				{
	   				$item_id = $items[$i];
					$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE ."
						SET item_in_shop = 0, 
							item_in_warehouse = 0
						WHERE item_id = $item_id 
						AND item_owner_id = $user_id ";
					if( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
					}
				}
			}

			adr_previous( Adr_shop_items_successful_removed , adr_shops , "mode=see_shop&amp;shop_id=".$shop_id."" );
			break;

		case 'shop_edit' :

			$sql = "SELECT * FROM " . ADR_SHOPS_TABLE . "
				WHERE shop_owner_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			if ( !(is_numeric($row['shop_id'])) )
			{
				adr_previous ( Adr_lack_shops , adr_shops , '' );	
			}
			else
			{
				$template->assign_block_vars('edit_shop',array());	
			}

			$template->assign_vars(array(
				'SHOP_ID' => $row['shop_id'],
				'SHOP_NAME' => $row['shop_name'],
				'SHOP_DESC' => $row['shop_desc'],
				'L_CREATE_NEW_SHOP' => $lang['Adr_users_shops_edit'],
				'L_CREATE_NEW_SHOP_NAME' => $lang['Adr_users_shops_create_name'],
				'L_CREATE_NEW_SHOP_DESC' => $lang['Adr_users_shops_create_desc'],
				'L_SUBMIT' => $lang['Submit'],
			));
			break;

		case 'shop_delete' :

			$sql = "SELECT * FROM " . ADR_SHOPS_TABLE . "
				WHERE shop_owner_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			if ( !(is_numeric($row['shop_id'])) )
			{
				adr_previous ( Adr_lack_shops , adr_shops , '' );	
			}

			$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE ."
				SET item_in_shop = 0
				WHERE item_owner_id = $user_id ";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . ADR_SHOPS_TABLE ."
				WHERE shop_owner_id = $user_id ";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
			}

			// Remove all transaction logs for user store
			$sql = "DELETE FROM " . ADR_STORES_USER_HISTORY ."
				WHERE user_store_owner_id = '$user_id'";
			if( !$db->sql_query($sql) ){
				message_die(GENERAL_ERROR, 'Could not delete user store trans logs', "", __LINE__, __FILE__, $sql);}

			adr_previous( Adr_users_shops_deleted , adr_shops , '' );
			break;

		case 'save_new_shop' :

			$adr_general = adr_get_general_config();

			adr_substract_points( $user_id , $adr_general['new_shop_price'] , adr_shops , '?mode=create_shop' );

			$sql = "SELECT * FROM " . ADR_SHOPS_TABLE ."
				ORDER BY shop_id 
				DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain alignments information', "", __LINE__, __FILE__, $sql);
			}
			$fields_data = $db->sql_fetchrow($result);

			$shop_name = ( isset($HTTP_POST_VARS['shop_name']) ) ? trim($HTTP_POST_VARS['shop_name']) : trim($HTTP_GET_VARS['shop_name']);
			$shop_desc = ( isset($HTTP_POST_VARS['shop_desc']) ) ? trim($HTTP_POST_VARS['shop_desc']) : trim($HTTP_GET_VARS['shop_desc']);
			$shop_id = $fields_data['shop_id'] +1;

			if ( !$shop_name )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "INSERT INTO " . ADR_SHOPS_TABLE . " 
				( shop_id , shop_name , shop_desc ,  shop_owner_id )
				VALUES ( $shop_id ,'" . str_replace("\'", "''", $shop_name) . "','" . str_replace("\'", "''", $shop_desc) . "',  $user_id )";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new shop", "", __LINE__, __FILE__, $sql);
			}

			adr_previous ( Adr_users_shops_create_success , adr_shops , '' );	
			break;

		case 'save_shop' :

			$shop_name = ( isset($HTTP_POST_VARS['shop_name']) ) ? trim($HTTP_POST_VARS['shop_name']) : trim($HTTP_GET_VARS['shop_name']);
			$shop_desc = ( isset($HTTP_POST_VARS['shop_desc']) ) ? trim($HTTP_POST_VARS['shop_desc']) : trim($HTTP_GET_VARS['shop_desc']);
			$shop_id = ( !empty($HTTP_POST_VARS['shop_id']) ) ? $HTTP_POST_VARS['shop_id'] : $HTTP_GET_VARS['shop_id'];

			if ( !$shop_name )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "UPDATE " . ADR_SHOPS_TABLE . " 
				SET  shop_name = '". str_replace("\'", "''", $shop_name) . "',
				     shop_desc = '" . str_replace("\'", "''", $shop_desc) . "'
				WHERE shop_id = $shop_id
				AND shop_owner_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new shop", "", __LINE__, __FILE__, $sql);
			}

			adr_previous ( Adr_users_shops_edited_success , adr_shops , "?mode=see_shop&amp;shop_id=".$shop_id."" );	
			break;

		case 'search_item' :

			$template->assign_block_vars('search_item',array());

			$template->assign_vars(array(
				'ITEM_TYPE' => adr_get_item_type(0,search),
				'ITEM_QUALITY' => adr_get_item_quality(0,search),
				'L_POINTS' => get_reward_name(),
				'L_ITEM_QUALITY' => $lang['Adr_items_quality'],
				'L_ITEM_TYPE' => $lang['Adr_items_type_use'],
				'L_ITEM_QUALITY_LEAST' => $lang['Adr_items_type_least'],
				'L_ITEM_POWER_LEAST' => $lang['Adr_items_power_least'],
				'L_ITEM_DURATION_LEAST' => $lang['Adr_items_duration_least'],
				'L_ITEM_PRICE_MAX' => $lang['Adr_items_price_max'],
				'L_SEARCH_ITEM_CRITERA' => $lang['Adr_items_search_criteria'],
				'L_SUBMIT' => $lang['Submit'],
			));
			break;

	    case 'search_item_results':
			$template->assign_block_vars('search_item_results', array());

			$item_quality = (intval($HTTP_POST_VARS['item_quality']) -1);
			$item_power_least = (intval($HTTP_POST_VARS['item_power_least']) -1);
			$item_duration_least = (intval($HTTP_POST_VARS['item_duration_least']) -1);
			$item_type = intval($HTTP_POST_VARS['item_type_use']);
			$item_price_max = intval($HTTP_POST_VARS['item_price_max']);

			// Check user input for errors
			$item_quality = ($item_quality < '0') ? intval(0) : $item_quality;
			$item_power_least = ($item_power_least < '0') ? intval(0) : $item_power_least;
			$item_duration_least = ($item_duration_least < '0') ? intval(0) : $item_duration_least;
			$search_type_sql = ($item_type > '0') ? 'AND item_type_use = '.$item_type : '';
			$search_price_sql = ($item_price_max > '0') ? 'AND item_price < '.$item_price_max : '';

			$sql = "SELECT i.*, s.*, q.item_quality_lang, t.item_type_lang
				FROM (" . ADR_SHOPS_ITEMS_TABLE . " i, " . ADR_SHOPS_TABLE . " s)
				LEFT JOIN " . ADR_SHOPS_ITEMS_QUALITY_TABLE . " q ON (i.item_quality = q.item_quality_id)
				LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON (i.item_type_use = t.item_type_id)
				WHERE i.item_quality > '$item_quality'
				AND i.item_power > '$item_power_least'
				AND i.item_duration > '$item_duration_least'
				AND i.item_owner_id = s.shop_owner_id
				AND i.item_auth = '0'
				AND ((i.item_in_shop = '1' AND s.shop_id != '1') OR (i.item_in_shop = '0' AND s.shop_id = '1'))
			$search_type_sql
			$search_price_sql
			ORDER BY i.item_price";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not query items', '', __LINE__, __FILE__, $sql);}
			$row = $db->sql_fetchrowset($result);

			// If no results then no items to display for search criteria
			if(!(count($row))){
				adr_previous(Adr_search_no_results, adr_shops, 'mode=search_item');}

			for($f = 0; $f < count($row); $f++)
			{
				$row_class = (!($f % 2)) ? $theme['td_class1'] : $theme['td_class2'];

				$template->assign_block_vars('search_item_results.items', array(
				   "ROW_CLASS" => $row_class,
				   "ITEM_NAME" => adr_get_lang($row[$f]['item_name']),
				   "ITEM_QUALITY" => $lang[$row[$f]['item_quality_lang']],
				   "ITEM_DURATION" => $row[$f]['item_duration'],
				   "ITEM_DURATION_MAX" => $row[$f]['item_duration_max'],
				   "ITEM_POWER" => $row[$f]['item_power'],
				   "ITEM_PRICE" => $row[$f]['item_price'],
				   "ITEM_WEIGHT" => $row[$f]['item_weight'],
				   "ITEM_TYPE" => $lang[$row[$f]['item_type_lang']],
				   "SHOP_NAME" => adr_get_lang($row[$f]['shop_name']),
				   "U_ITEM_INFO" => append_sid("adr_shops.$phpEx?mode=view_item&amp;item_id=".$row[$f]['item_id'].""),
				   "U_SHOP_NAME" => append_sid("adr_shops.$phpEx?mode=see_shop&amp;shop_id=".$row[$f]['shop_id'])
				));
			}

			$template->assign_vars(array(
				'L_SHOP_NAME'       => $lang['Adr_shop_name'],
				'L_ITEM_QUALITY'    => $lang['Adr_items_quality'],
				'L_ITEM_TYPE'       => $lang['Adr_items_type_use'],
				"L_ITEM_NAME"       => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_POWER"       => $lang['Adr_items_power'],
				"L_ITEM_WEIGHT"    => $lang['Adr_character_weight'],
				"L_ITEM_DURATION"    => $lang['Adr_items_duration'],
				"L_ITEM_PRICE"       => $lang['Adr_items_price'],
				'L_SUBMIT'          => $lang['Submit'],
			));
			break;


		case 'view_store_list' :
			$template->assign_block_vars('view_store_list',array());

			// All user view stores and zone restriction by cedô
			$sql = "SELECT * FROM " . ADR_STORES_TABLE . " 
					WHERE store_admin = 0 
					ORDER BY store_name ASC ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain custom store info', "", __LINE__, __FILE__, $sql);
			}

			$i = 0;
			while ( $row = $db->sql_fetchrow($result) )
			{
				// V: properly check zone
				$zones = explode(',', $row['store_zone']);
				if (!in_array($actual_zone, $zones) && $zones[0] != 0) {
					continue;
				}

				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				if ( $row['store_status'] == 1 )
				{
					$store_status = $lang['Adr_store_open'];
				}
				else
				{
					$store_status = $lang['Adr_store_closed'];
				}

				if ( $row['store_img'] != '' )
				{
					$store_img = '<img src="adr/images/store/' . $row['store_img'] . '">';
				}
				else
				{
					$store_img = '';
				}

				$template->assign_block_vars('view_store_list.store', array(
					"ROW_CLASS" => $row_class,
					"STORE_NAME" => $row['store_name'],
					"STORE_DESC" => $row['store_desc'],
					"STORE_IMG" => $store_img,
					"STORE_STATUS" => $store_status,
					"U_STORE_NAME" => append_sid("adr_shops.$phpEx?mode=view_store&amp;shop_id=".$row[ 'store_id']),
				));

				$i++;
			}
			
			if ( $userdata['user_level'] == ADMIN )		
			{
				// Admin only stores
				$sql = "SELECT * FROM " . ADR_STORES_TABLE . " 
						WHERE store_admin = 1 
							ORDER BY store_name ASC ";
				$result = $db->sql_query($sql);
				if( !$result )
				{
					message_die(GENERAL_ERROR, 'Could not obtain custom store info', "", __LINE__, __FILE__, $sql);
				}

				if ( $admin = $db->sql_fetchrow($result) )
				{
					$i = 0;
					do
					{
						$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

						if ( $admin['store_img'] != '' )
						{
							$store_img = '<img src="adr/images/store/' . $admin['store_img'] . '">';
						}

						if ( $admin['store_img'] == '' )
						{
							$store_img = '';
						}

						if ( $admin['store_admin'] == 1 )
						{
							$store_auth = $lang['Adr_store_admin'];
						}

						$template->assign_block_vars('view_store_list.admin', array(
							"ROW_CLASS" => $row_class,
							"STORE_NAME" => $admin['store_name'],
							"STORE_DESC" => $admin['store_desc'],
							"STORE_IMG" => $admin['store_img'],
							"STORE_STATUS" => $store_auth,
							"U_STORE_NAME" => append_sid("adr_shops.$phpEx?mode=view_store_admin"),
						));

						$i++;
					}
					while ( $row = $db->sql_fetchrow($result) );
				}
			}

			$template->assign_vars(array(
				"L_STORE_NAME" => $lang['Adr_store_name'],
				"L_STORE_DESC" => $lang['Adr_store_desc'],
				"L_STORE_IMG" => $lang['Adr_store_img'],
				"L_STORE_STATUS" => $lang['Adr_store_status'],
				"L_STORE_ADMIN" => $lang['Adr_store_admin']
			));

			break;

		case 'view_store' :

			$template->assign_block_vars('view_store',array());

			// Prevents blank page
			if ( !$shop_id ) $shop_id = 1;
			if(($shop_id != '0') && ($shop_id != '2'))
			   $template->assign_block_vars('view_store.forum_shops', array());
		     // Since this is not the admin store let's show the my points view
		     $template->assign_block_vars('view_store.my_points', array());
			// Prevent unauthorised access to admin only store
			if(($userdata['user_level'] != ADMIN) && ($shop_id == '2')){
			   // Send admin alert of invalid user attempt
			   $subject = $lang['Adr_report_pm_sub'];
			   $message = sprintf($lang['Adr_report_pm_msg'], $character_id);
			   adr_send_pm('2', $subject, $message);
			   adr_previous(Adr_admin_only_area, 'adr_shops', '');
			}

			$sql = "SELECT * FROM " . ADR_STORES_TABLE . "
				WHERE store_id = $shop_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			// V: properly check zone
			$zones = explode(',', $row['store_zone']);
			if (!in_array($actual_zone, $zones) && $zones[0] != 0) {
				$row = false;
			}

			if ( !$row['store_status'] )
			{
				adr_previous ( Adr_store_closed_msg , 'adr_shops' , '' );
			}

			$store_name = adr_get_lang($row['store_name']);
			$store_desc = adr_get_lang($row['store_desc']);
			$shop_owner_id = $row['store_owner_id'];

			( $shop_owner_id == '1' ) ? $zone_restriction = 'AND ( i.item_zone = 0 || i.item_zone = '.$actual_zone.' )' : $zone_restriction = '';
			( $shop_owner_id == '1' ) ? $zone_restriction_1 = 'AND ( item_zone = 0 || item_zone = '.$actual_zone.' )' : $zone_restriction_1 = '';

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
				$cat = ( isset($HTTP_POST_VARS['cat']) ) ? htmlspecialchars($HTTP_POST_VARS['cat']) : htmlspecialchars( $HTTP_GET_VARS['cat']);
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

			$mode_types_text = array( $lang['Adr_shops_categories_item_name'] , $lang['Adr_items_price'] , $lang[ 'Adr_items_type_use'] , $lang['Adr_items_quality'] , $lang['Adr_items_power'] );
			$mode_types = array( 'name', 'price' , 'type' , 'quality' , 'power' );

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

			##=== START: show all items or just those available to user?
			$show_type = ($show_only_mine == '1') ? $lang['Adr_show_all'] : $lang['Adr_show_only_mine'];
			if($show_only_mine == '1') $show_link = append_sid("adr_shops.$phpEx?mode=view_store&amp;shop_id=".$shop_id."");
			else $show_link = append_sid("adr_shops.$phpEx?mode=view_store&amp;shop_id=".$shop_id."&amp;show_only_mine=1");
			$points_check_sql = ($show_only_mine == '1') ? ' AND i.item_price <= '.$points : '';
			$item_sql = ($show_only_mine == '1') ? $item_sql : '';
			##=== END: show all items or just those available to user?

			$shop_more_sql = ( $shop_owner_id != 1 ) ? 'AND i.item_in_shop = 1' : '';
			$sql = "SELECT i.* , q.item_quality_lang , t.item_type_lang
				FROM " . ADR_SHOPS_ITEMS_TABLE . " i
				LEFT JOIN " . ADR_SHOPS_ITEMS_QUALITY_TABLE . " q ON ( i.item_quality = q.item_quality_id )
				LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
				WHERE i.item_store_id = $shop_id
				AND i.item_owner_id = $shop_owner_id
				AND i.item_auth = 0
				$item_sql
				$points_check_sql
				$shop_more_sql 
				$cat_sql

				$zone_restriction

				ORDER BY $order_by";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
			}

			$select_quantity = '<select name="quantity">';
			for($i = 1; $i < 21; $i++)
			{
				$select_quantity .= '<option value="' . $i . '">' .$i . '</option>';
			}
			$select_quantity .= '</select>';

			$action_select = '<select name="mode">';
			$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
			$action_select .= '<option value = "buy">' . $lang['Adr_items_buy'] . '</option>';
			if ( $adr_general['allow_shop_steal'] )
			{
				$action_select .= '<option value = "steal">' . $lang['Adr_items_steal'] . '</option>';
			}
			$action_select .= '</select>';

			if ( $row = $db->sql_fetchrow($result) )
			{
				$i = 0;
				do
				{
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

					$template->assign_block_vars('view_store.items', array(
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
                                	"U_ITEM_INFO" => append_sid("adr_shops.$phpEx?mode=view_item&amp;item_id=".$row['item_id']."&amp;store_id=".$row['item_store_id']."&amp;shop_id=1"),
					));
					##=== START: show stealability level if enabled by admin
					if($adr_general['Adr_shop_steal_show'] == '1'){
						if($row['item_steal_dc'] == '0') $steal_dc = $lang['Adr_steal_none'];
						elseif($row['item_steal_dc'] == '1') $steal_dc = $lang['Adr_steal_very_easy'];
						elseif($row['item_steal_dc'] == '2') $steal_dc = $lang['Adr_steal_easy'];
						elseif($row['item_steal_dc'] == '3') $steal_dc = $lang['Adr_steal_average'];
						elseif($row['item_steal_dc'] == '4') $steal_dc = $lang['Adr_steal_tough'];
						elseif($row['item_steal_dc'] == '5') $steal_dc = $lang['Adr_steal_challenging'];
						elseif($row['item_steal_dc'] == '6') $steal_dc = $lang['Adr_steal_formidable'];
						elseif($row['item_steal_dc'] == '7') $steal_dc = $lang['Adr_steal_heroic'];
						elseif($row['item_steal_dc'] == '8') $steal_dc = $lang['Adr_steal_impossible'];

						$template->assign_block_vars('view_store.items.steal_show', array(
							"L_STEAL_SHOW" => $lang['Adr_items_steal_dc'],
							"STEAL_SHOW" => $steal_dc
						));
					}
					##=== END: show stealability level if enabled by admin

					##==== START: Check items' critical threat infos
					$crit_item_types = array('5', '6'); // only show for weaps, magic weaps
					if(($row['item_crit_hit'] != '20') && (in_array($row['item_type_use'], $crit_item_types)))
					{
						$crit_lang = ($row['item_crit_hit'] < '20') ? '['.$row['item_crit_hit'].'-20/'.$row['item_crit_hit_mod'].']' : $lang['Adr_item_crit_range_none'];
						$template->assign_block_vars('view_store.items.crit_hit', array(
							"L_CRIT_HIT" => $lang['Adr_item_crit_range'],
							"CRIT_HIT" => $crit_lang
						));
					}
					##==== END: Check items' critical threat infos

					// Show restriction. Doesn't prevent user from buying
					$align_array = explode(",", $row['item_restrict_align']);
					if ($row['item_restrict_align_enable'] == '1')
					{
						$align_count = count($align_array);
						$align_list = '';

       					for ($a = 0; $a < $align_count; $a++)
						{
							// Cached sql query
							$align_info = adr_get_alignment_infos($align_array[$a]);

							$align_list .= adr_get_lang($align_info['alignment_name']);
							if ($a < ($align_count - 2))
								$align_list .= ", ";
						}

						$template->assign_block_vars('view_store.items.align_restrict', array(
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
							if ($c < ($class_count - 2))
								$class_list .= ", ";
						}

						$template->assign_block_vars('view_store.items.class_restrict', array(
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
							if ($e < ($element_count - 2))
								$element_list .= ", ";
						}

						$template->assign_block_vars('view_store.items.element_restrict', array(
						"ELEMENT_LIST" => $element_list,
						"L_ELEMENT_LIST" => $lang['Adr_character_element']
						));
					}

					$race_array = explode(",", $row['item_restrict_race']);
					if ($row['item_restrict_race_enable'] == '1')
					{
						$race_count = count($race_array);
						$race_list = '';

       					for ($r = 0; $r < $race_count; $r++)
						{
							// Cached sql query
							$race_info = adr_get_race_infos($race_array[$r]);

							$race_list .= adr_get_lang($race_info['race_name']);
							if ($r < ($race_count - 2))
								$race_list .= ", ";
						}

						$template->assign_block_vars('view_store.items.race_restrict', array(
						"RACE_LIST" => $race_list,
						"L_RACE_LIST" => $lang['Adr_character_race']
						));
					}

					##==== START: Show any level or characteristic restrictions for this item ===##
					$char_resist_list = '';
					if ($row['item_restrict_level'] > '1') // level restriction. Has to be more than one otherwise pointless restriction
						$char_resist_list = $lang['Adr_char_lvl'].' ['.$row['item_restrict_level'].']; ';
					if ($row['item_restrict_str'] > '0') // Strength restriction. Has to be more than 0 otherwise pointless restriction
						$char_resist_list .= $lang['Adr_char_str'].' ['.$row['item_restrict_str'].']; ';
					if ($row['item_restrict_dex'] > '0') // Dexterity restriction. Has to be more than 0 otherwise pointless restriction
						$char_resist_list .= $lang['Adr_char_dex'].' ['.$row['item_restrict_dex'].']; ';
					if ($row['item_restrict_con'] > '0') // Constitution restriction. Has to be more than 0 otherwise pointless restriction
						$char_resist_list .= $lang['Adr_char_con'].' ['.$row['item_restrict_con'].']; ';
					if ($row['item_restrict_int'] > '0') // Intelligence restriction. Has to be more than 0 otherwise pointless restriction
						$char_resist_list .= $lang['Adr_char_int'].' ['.$row['item_restrict_int'].']; ';
					if ($row['item_restrict_wis'] > '0') // Wisdom restriction. Has to be more than 0 otherwise pointless restriction
						$char_resist_list .= $lang['Adr_char_wis'].' ['.$row['item_restrict_wis'].']; ';
					if ($row['item_restrict_cha'] > '0') // Charisma restriction. Has to be more than 0 otherwise pointless restriction
						$char_resist_list .= $lang['Adr_char_cha'].' ['.$row['item_restrict_cha'].']; ';
					$char_resist_list = substr($char_resist_list,0,strlen($char_resist_list) -2);

					if(($row['item_restrict_level'] > '1') || ($row['item_restrict_str'] > '0') || ($row['item_restrict_dex'] > '0') || ($row['item_restrict_con'] > '0') || ($row['item_restrict_int'] > '0') || ($row['item_restrict_wis'] > '0') || ($row['item_restrict_cha'] > '0'))
					{
						$template->assign_block_vars('view_store.items.resist_chars', array(
							"CHAR_RESIST_LIST" => $char_resist_list,
							"L_CHAR_RESIST_LIST" => $lang['Adr_char_restrict_title']
						));
					}
					##==== END: Show any level or characteristic restrictions for this item ===##

					$i++;
				}
				while ( $row = $db->sql_fetchrow($result) );
			}

			##=== START: show all items or just those available to user?
			$points_check_sql = ($show_only_mine == '1') ? ' AND item_price <= '.$points : '';
			$item_sql = ($show_only_mine == '1') ? $item_sql : '';
			##=== END: show all items or just those available to user?
			$cat_sql = ( $cat ) ? 'AND item_type_use = '.intval($cat) : '';
			$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_ITEMS_TABLE . " 
				WHERE item_store_id = $shop_id 
				AND item_owner_id = 1 
				AND item_auth = 0
				$item_sql
				$points_check_sql
				$cat_sql

				$zone_restriction_1

				AND item_duration > 0 ";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
			}

			if ( $total = $db->sql_fetchrow($result) )
			{
				$total_items = $total['total'];
				$pagination = generate_pagination("adr_shops.$phpEx?mode=view_store&amp;mode2=$mode2&amp;order=$sort_order&amp;shop_id=".$shop_id."", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';
			}

			$template->assign_vars(array(
				'ORDER_BY' => $order_by,
				'ACTION_SELECT' => $action_select,
				'SELECT_CAT' => $select_category,
				'SELECT_QUANTITY' => $select_quantity,
				'STORE_ID' => $shop_id,
				'STORE_NAME' => $store_name,
				'STORE_DESC' => $store_desc,
				'SHOP_OWNER_ID' => $shop_owner_id,
				'POINTS' => number_format(get_reward($user_id)),
				'SHOW_LINK' => $show_link,
				'L_POINTS' => $lang['Adr_my'].get_reward_name(),
				'L_SHOW_LINK' => $show_type,
				"L_SELECT_CAT" => $lang['Adr_items_select'],
				"L_SELECT_QUANTITY" => $lang['Adr_items_select_quantity'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
				"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
				"L_ITEM_POWER" => $lang['Adr_items_power'],
				"L_ITEM_WEIGHT" => $lang['Adr_character_weight'],
				"L_ITEM_DURATION" => $lang['Adr_items_duration'],
				"L_ACTION" => $lang['Adr_items_action'],
				"L_ITEM_IMG" => $lang['Adr_races_image'],
				"L_ITEM_PRICE" => $lang['Adr_items_price'],
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
				'S_MODE_ACTION' => append_sid("adr_shops.$phpEx?mode=view_store&amp;shop_id=".$shop_id.""),
			));
			break;


		case 'view_store_admin' :

			$template->assign_block_vars('view_store',array());

			if ( $userdata['user_level'] != ADMIN )
			{
				// Send user PM notification...
				$member_id = 2;
				$subject = $lang['Adr_report_pm_sub'];	
				$message = sprintf($lang['Adr_report_pm_msg'] , $character_id);

				adr_send_pm ( $member_id , $subject , $message );
				adr_previous ( Adr_admin_only_area , 'adr_shops' , '' );					
			}
	
			// Prevents blank page
			if ( !$shop_id ) $shop_id = 1;
			if ( $shop_id == 1 ) $template->assign_block_vars('view_store.forum_shops',array());

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
				$cat = ( isset($HTTP_POST_VARS['cat']) ) ? htmlspecialchars($HTTP_POST_VARS['cat']) : htmlspecialchars( $HTTP_GET_VARS['cat']);
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

			$mode_types_text = array( $lang['Adr_shops_categories_item_name'] , $lang['Adr_items_price'] , $lang[ 'Adr_items_type_use'] , $lang['Adr_items_quality'] , $lang['Adr_items_power'] );
			$mode_types = array( 'name', 'price' , 'type' , 'quality' , 'power' );

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

			$sql = "SELECT i.* , q.item_quality_lang , t.item_type_lang FROM " . ADR_SHOPS_ITEMS_TABLE . " i
				LEFT JOIN " . ADR_SHOPS_ITEMS_QUALITY_TABLE . " q ON ( i.item_quality = q.item_quality_id )
				LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
				WHERE i.item_auth = 1
				$cat_sql
				ORDER BY $order_by";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
			}

			$select_quantity = '<select name="quantity">';
			for($i = 1; $i < 21; $i++)
			{
				$select_quantity .= '<option value="' . $i . '">' .$i . '</option>';
			}
			$select_quantity .= '</select>';

			$action_select = '<select name="mode">';
			$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
			$action_select .= '<option value = "buy_admin">' . $lang['Adr_items_buy'] . '</option>';
//			$action_select .= '<option value = "give">' . $lang['Adr_items_give'] . '</option>';
			$action_select .= '</select>';

			if ( $row = $db->sql_fetchrow($result) )
			{
				$i = 0;
				do
				{
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

					$template->assign_block_vars('view_store.items', array(
						"ROW_CLASS" => $row_class,
						"ITEM_ID" => $row['item_id'],
						"ITEM_NAME" => adr_get_lang($row['item_name']),
						"ITEM_DESC" => adr_get_lang($row['item_desc']),
						"ITEM_IMG" => $row['item_icon'],
						"ITEM_QUALITY" => $lang[$row['item_quality_lang']],
						"ITEM_TYPE" => $lang[$row['item_type_lang']],
						"ITEM_WEIGHT" => $row['item_weight'],
						"ITEM_DURATION" => $row['item_duration'],
						"ITEM_DURATION_MAX" => $row['item_duration_max'],
						"ITEM_POWER" => $row['item_power'],
						"ITEM_PRICE" => $row['item_price'],
                                	"U_ITEM_INFO" => append_sid("adr_shops.$phpEx?mode=view_item&amp;item_id=".$row['item_id']."&amp;store_id=".$row['item_store_id']."&amp;shop_id=1"),
					));

					$i++;
				}
				while ( $row = $db->sql_fetchrow($result) );
			}

			$cat_sql = ( $cat ) ? 'AND item_type_use = '.$cat : '';
			$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_ITEMS_TABLE ." 
				WHERE item_owner_id = 1 
				AND item_auth = 1
				$cat_sql
				AND item_duration > 0 ";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
			}
			if ( $total = $db->sql_fetchrow($result) )
			{
				$total_items = $total['total'];
				$pagination = generate_pagination("adr_shops.$phpEx?mode=view_store_admin&amp;mode2=$mode2&amp;order=$sort_order&amp;store_id=".$shop_id."", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';
			}

			$template->assign_vars(array(
				'ORDER_BY' => $order_by,
				'ACTION_SELECT' => $action_select,
				'SELECT_CAT' => $select_category,
				'SELECT_QUANTITY' => $select_quantity,
				'STORE_ID' => $shop_id,
				'STORE_NAME' => $store_name,
				'STORE_DESC' => $store_desc,
				'SHOP_OWNER_ID' => $shop_owner_id,
				"L_SELECT_CAT" => $lang['Adr_items_select'],
				"L_SELECT_QUANTITY" => $lang['Adr_items_select_quantity'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
				"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
				"L_ITEM_POWER" => $lang['Adr_items_power'],
				"L_ITEM_WEIGHT" => $lang['Adr_character_weight'],
				"L_ITEM_DURATION" => $lang['Adr_items_duration'],
				"L_ACTION" => $lang['Adr_items_action'],
				"L_ITEM_IMG" => $lang['Adr_races_image'],
				"L_ITEM_PRICE" => $lang['Adr_items_price'],
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
				'S_MODE_ACTION' => append_sid("adr_shops.$phpEx?mode=view_store&amp;shop_id=".$shop_id.""),
			));
			break;



		case 'view_item' :

			$template->assign_block_vars('view_item',array());

			$shop_id = intval($HTTP_GET_VARS['shop_id']);
			$item_owner_id = intval($HTTP_GET_VARS['item_owner_id']);
			$item_id = intval($HTTP_GET_VARS['item_id']);
			$store_id = intval($HTTP_GET_VARS['store_id']);

			// Prevents blank page
			if ( !$shop_id ) $shop_id = 1;
			if ( !$item_owner_id ) $item_owner_id = 1;
			// if ( $shop_id == 1 ) $template->assign_block_vars('view_item.forum_shops',array());

			$sql = "SELECT store_status FROM " . ADR_STORES_TABLE . "
				WHERE store_id = $store_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);
			}
			$shop = $db->sql_fetchrow($result);

			// V: properly check zone
			$zones = explode(',', $shop['store_zone']);
			if (!in_array($actual_zone, $zones) && $zones[0] != 0) {
				$shop = false;
			}

			if ( !$shop['store_status'] )
			{
				adr_previous ( Adr_store_closed_msg , 'adr_shops' , '' );
			}


			// All item info
			$sql = "SELECT i.* , q.item_quality_lang , t.item_type_lang , e.element_img FROM " . ADR_SHOPS_ITEMS_TABLE . " i
				LEFT JOIN " . ADR_SHOPS_ITEMS_QUALITY_TABLE . " q ON ( i.item_quality = q.item_quality_id )
				LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
				LEFT JOIN " . ADR_ELEMENTS_TABLE . " e ON ( i.item_element = e.element_id )
				WHERE i.item_id = $item_id 
				AND i.item_owner_id = $item_owner_id";
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

			if ( $shop['store_status'] == 1 )
			{
				$action_select = '<select name="mode">';
				$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
				$action_select .= '<option value = "buy">' . $lang['Adr_items_buy'] . '</option>';

				if ( $adr_general['allow_shop_steal'] && $shop_id == 1 )
				{
					$action_select .= '<option value = "steal">' . $lang['Adr_items_steal'] . '</option>';
				}
				$action_select .= '</select>';

				$select_quantity = '<select name="quantity">';
				for($i = 1; $i < 21; $i++)
				{
					$select_quantity .= '<option value="' . $i . '">' .$i . '</option>';
				}
				$select_quantity .= '</select>';
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
				"SELECT_QUANTITY" => $select_quantity,
				"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
				"L_SELECT_QUANTITY" => $lang['Adr_items_select_quantity'],
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
				"L_ITEM_WEIGHT" => $lang['Adr_character_weight'],
				"L_ITEM_ELEMENT" => $lang['Adr_shops_item_element'],
				"L_ACTION" => $lang['Adr_items_action'],
				"L_SUBMIT" => $lang['Submit'],
			));

			break;


		case 'see_shop' : 

			$template->assign_block_vars('see_shop',array()); 

			// Prevents blank page 
			if ( !$shop_id ) $shop_id = 1; 
			if ( $shop_id == 1 ) $template->assign_block_vars('see_shop.forum_shops',array()); 

			$sql = "SELECT * FROM " . ADR_SHOPS_TABLE . " 
			WHERE shop_id = $shop_id "; 
			$result = $db->sql_query($sql); 
			if( !$result ) 
			{ 
				message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql); 
			}
			$row = $db->sql_fetchrow($result);

			// V: properly check zone
			$zones = explode(',', $row['store_zone']);
			if (!in_array($actual_zone, $zones) && $zones[0] != 0) {
				continue;
			}

			$shop_owner = intval($row['shop_owner_id']);
			$shop_name = adr_get_lang($row['shop_name']);
			$shop_desc = adr_get_lang($row['shop_desc']);

			( $shop_owner == '1' ) ? $zone_restriction = 'AND ( i.item_zone = 0 || i.item_zone = '.$actual_zone.' )' : $zone_restriction = '';
			( $shop_owner == '1' ) ? $zone_restriction_1 = 'AND ( item_zone = 0 || item_zone = '.$actual_zone.' )' : $zone_restriction_1 = '';


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

			$select_quantity = '<select name="quantity">';
			for($i = 1; $i < 21; $i++)
			{
				$select_quantity .= '<option value="' . $i . '">' .$i . '</option>';
			}
			$select_quantity .= '</select>';


			$mode_types_text = array( $lang['Adr_shops_categories_item_name'] , $lang['Adr_items_price'] , $lang['Adr_items_type_use'] , $lang['Adr_items_quality'] , $lang['Adr_items_power'] );
			$mode_types = array( 'name', 'price' , 'type' , 'quality' , 'power' );

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

			##=== START: show all items or just those available to user?
			$show_type = ($show_only_mine == '1') ? $lang['Adr_show_all'] : $lang['Adr_show_only_mine'];
			if($show_only_mine == '1') $show_link = append_sid("adr_shops.$phpEx?mode=see_shop&amp;shop_id=".$shop_id."");
			else $show_link = append_sid("adr_shops.$phpEx?mode=see_shop&amp;shop_id=".$shop_id."&amp;show_only_mine=1");
			$points_check_sql = ($show_only_mine == '1') ? ' AND i.item_price <= '.$points : '';
			$item_sql = ($show_only_mine == '1') ? $item_sql : '';
			##=== END: show all items or just those available to user?

			// Grab all shop names for stolen infos later on
			$sql = "SELECT shop_id, shop_name FROM  " . ADR_SHOPS_TABLE . "
				WHERE shop_owner_id = '1'";
			$result = $db->sql_query($sql);
			if (!$result)
				message_die(GENERAL_ERROR, 'Could not obtain shop infos', '', __LINE__, __FILE__, $sql);
			$shop_info = $db->sql_fetchrowset($result);

			$shop_more_sql = ( $shop_owner != 1 ) ? 'AND i.item_in_shop = 1' : '';
			$sql = "SELECT i.* , q.item_quality_lang , t.item_type_lang FROM " . ADR_SHOPS_ITEMS_TABLE . " i
				LEFT JOIN " . ADR_SHOPS_ITEMS_QUALITY_TABLE . " q ON ( i.item_quality = q.item_quality_id )
				LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
				WHERE i.item_owner_id = $shop_owner
				AND i.item_auth = 0 
				$item_sql
				$points_check_sql
				$shop_more_sql 
				$cat_sql

				$zone_restriction

				ORDER BY $order_by";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
			}

			$action_select = '<select name="mode">';
			$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
			if ( $user_id == $shop_owner )
			{
				$template->assign_block_vars('see_shop.owner',array());
				$action_select .= '<option value = "delete_item">' . $lang['Dispose'] . '</option>';
				$action_select .= '<option value = "inventory">' . $lang['Adr_items_into_inventory'] . '</option>';
			}
			else
			{
				$action_select .= '<option value = "buy">' . $lang['Adr_items_buy'] . '</option>';
				if ( $adr_general['allow_shop_steal'] && $shop_id == 1 )
				{
					$action_select .= '<option value = "steal">' . $lang['Adr_items_steal'] . '</option>';
				}
			}
			$action_select .= '</select>';

			$i = 0;
			while ( $row = $db->sql_fetchrow($result) )
			{
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				##==== START: Check items' critical threat infos
				$crit_item_types = array('5', '6'); // only show for weaps, magic weaps
				if(($row['item_crit_hit'] != '20') && (in_array($row['item_type_use'], $crit_item_types)))
				{
					$crit_lang = ($row['item_crit_hit'] < '20') ? '['.$row['item_crit_hit'].'-20/'.$row['item_crit_hit_mod'].']' : $lang['Adr_item_crit_range_none'];
					$template->assign_block_vars('see_shop.items.crit_hit', array(
						"L_CRIT_HIT" => $lang['Adr_item_crit_range'],
						"CRIT_HIT" => $crit_lang
					));
				}
				##==== END: Check items' critical threat infos

				// Show restriction.
				$align_array = explode(",", $row['item_restrict_align']);
				if ($row['item_restrict_align_enable'] == '1')
				{
					$align_count = count($align_array);
					$align_list = '';

					for ($a = 0; $a < $align_count; $a++)
					{
						// Cached sql query
						$align_info = adr_get_alignment_infos($align_array[$a]);

						$align_list .= adr_get_lang($align_info['alignment_name']);
						if ($a < ($align_count - 2))
							$align_list .= ", ";
					}

					$template->assign_block_vars('see_shop.items.align_restrict', array(
						"ALIGN_LIST" => $align_list,
						"L_ALIGN_LIST" => $lang['Adr_character_alignment']
					));
				}

				$class_array = explode(",", $row['item_restrict_class']);
				if ($row['item_restrict_class_enable'] == '1')
				{
					$class_count = count($class_array);
					$class_list = '';

					for ($c = 0; $c < $class_count; $c++)
					{
						// Cached sql query
						$class_info = adr_get_class_infos($class_array[$c]);

						$class_list .= adr_get_lang($class_info['class_name']);
						if ($c < ($class_count - 2))
							$class_list .= ", ";
					}

					$template->assign_block_vars('see_shop.items.class_restrict', array(
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
						if ($e < ($element_count - 2))
							$element_list .= ", ";
					}

					$template->assign_block_vars('see_shop.items.element_restrict', array(
					"ELEMENT_LIST" => $element_list,
					"L_ELEMENT_LIST" => $lang['Adr_character_element']
					));
				}

				$race_array = explode(",", $row['item_restrict_race']);
				if ($row['item_restrict_race_enable'] == '1')
				{
					$race_count = count($race_array);
					$race_list = '';

 					for ($r = 0; $r < $race_count; $r++)
					{
						// Cached sql query
						$race_info = adr_get_race_infos($race_array[$r]);

						$race_list .= adr_get_lang($race_info['race_name']);
						if ($r < ($race_count - 2))
							$race_list .= ", ";
					}

					$template->assign_block_vars('see_shop.items.race_restrict', array(
						"RACE_LIST" => $race_list,
						"L_RACE_LIST" => $lang['Adr_character_race']
					));
				}

				##==== START: Show any level or characteristic restrictions for this item ===##
				$char_resist_list = '';
				if ($row['item_restrict_level'] > '1') // level restriction. Has to be more than one otherwise pointless restriction
					$char_resist_list = $lang['Adr_char_lvl'].' ['.$row['item_restrict_level'].']; ';
				if ($row['item_restrict_str'] > '0') // Strength restriction. Has to be more than 0 otherwise pointless restriction
					$char_resist_list .= $lang['Adr_char_str'].' ['.$row['item_restrict_str'].']; ';
				if ($row['item_restrict_dex'] > '0') // Dexterity restriction. Has to be more than 0 otherwise pointless restriction
					$char_resist_list .= $lang['Adr_char_dex'].' ['.$row['item_restrict_dex'].']; ';
				if($row['item_restrict_con'] > '0') // Constitution restriction. Has to be more than 0 otherwise pointless restriction
					$char_resist_list .= $lang['Adr_char_con'].' ['.$row['item_restrict_con'].']; ';
				if($row['item_restrict_int'] > '0') // Intelligence restriction. Has to be more than 0 otherwise pointless restriction
					$char_resist_list .= $lang['Adr_char_int'].' ['.$row['item_restrict_int'].']; ';
				if($row['item_restrict_wis'] > '0') // Wisdom restriction. Has to be more than 0 otherwise pointless restriction
					$char_resist_list .= $lang['Adr_char_wis'].' ['.$row['item_restrict_wis'].']; ';
				if($row['item_restrict_cha'] > '0') // Charisma restriction. Has to be more than 0 otherwise pointless restriction
					$char_resist_list .= $lang['Adr_char_cha'].' ['.$row['item_restrict_cha'].']; ';
				$char_resist_list = substr($char_resist_list,0,strlen($char_resist_list) -2);


				if(($row['item_restrict_level'] > '1') || ($row['item_restrict_str'] > '0') || ($row['item_restrict_dex'] > '0') || ($row['item_restrict_con'] > '0') || ($row['item_restrict_int'] > '0') || ($row['item_restrict_wis'] > '0') || ($row['item_restrict_cha'] > '0'))
				{
					$template->assign_block_vars('see_shop.items.resist_chars', array(
						"CHAR_RESIST_LIST" => $char_resist_list,
						"L_CHAR_RESIST_LIST" => $lang['Adr_char_restrict_title']
					));
				}
				##==== END: Show any level or characteristic restrictions for this item ===##

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
						$stolen_by = $user_infos['character_name'];}
					elseif(($row['item_stolen_by'] != '') && ($row['item_stolen_by'] != $user_infos['character_name'])){
						$stolen_by = $row['item_stolen_by'];}
					else{
						$stolen_by = 'n/a';}
	
					$template->assign_block_vars('see_shop.items.stolen_info', array(
						"L_STOLEN_INFO" => sprintf($lang['Adr_shop_stolen_info'], '<i><b>', '</b>', sprintf($lang['Adr_shop_stolen_by'], $stolen_by), $shop_name, date("D j M 'y", $row['item_stolen_timestamp']), '</i>')
					));
				}
				##=== END: Show stolen status

				$template->assign_block_vars('see_shop.items', array(
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
					"ITEM_ELEMENT" => $row['item_element'],
					"ITEM_STORE_ID" => $row['item_store_id'],
                    "U_ITEM_INFO" => append_sid("adr_shops.$phpEx?mode=view_item&amp;item_owner_id=".$row['item_owner_id']."&amp;shop_id=$shop_id&amp;item_id=".$row['item_id'].""),
				));

				$i++;
			}

			##=== START: show all items or just those available to user?
			$points_check_sql = ($show_only_mine == '1') ? ' AND item_price <= '.$points : '';
			$item_sql = ($show_only_mine == '1') ? $item_sql : '';
			##=== END: show all items or just those available to user?

			$shop_more_sql = ( $shop_owner != 1 ) ? 'AND item_in_shop = 1' : '';
			$cat_sql = ( $cat ) ? 'AND item_type_use = '.$cat : '';
			$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_ITEMS_TABLE ." 
				WHERE item_owner_id = $shop_owner 
				$item_sql
				$points_check_sql
				$shop_more_sql 
				$cat_sql

				$zone_restriction_1

				AND item_duration > 0 ";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
			}
			if ( $total = $db->sql_fetchrow($result) )
			{
				$total_items = $total['total'];
				$pagination = generate_pagination("adr_shops.$phpEx?mode=see_shop&amp;mode2=$mode2&amp;order=$sort_order&amp;shop_id=".$shop_id."", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';
			}

			$template->assign_vars(array(
				'ORDER_BY' => $order_by,
				'ACTION_SELECT' => $action_select,
				'SELECT_CAT' => $select_category,
				'SELECT_QUANTITY' => $select_quantity,
				'SHOP_OWNER_ID' => $shop_owner,
				'SHOP_NAME' => $shop_name,
				'SHOP_DESC' => $shop_desc,
				'POINTS' => number_format(get_reward($user_id)),
				'SHOW_LINK' => $show_link,
				'L_POINTS' => $lang['Adr_my'].get_reward_name(),
				'L_SHOW_LINK' => $show_type,
				"L_SELECT_CAT" => $lang['Adr_items_select'],
				"L_SELECT_QUANTITY" => $lang['Adr_items_select_quantity'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
				"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
				"L_ITEM_POWER" => $lang['Adr_items_power'],
				"L_ITEM_WEIGHT" => $lang['Adr_character_weight'],
				"L_ITEM_DURATION" => $lang['Adr_items_duration'],
				"L_ITEM_ELEMENT" => $lang['Adr_shops_item_element'],
				"L_ACTION" => $lang['Adr_items_action'],
				"L_ITEM_IMG" => $lang['Adr_races_image'],
				"L_ITEM_PRICE" => $lang['Adr_items_price'],
				"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
				"L_NO_ITEMS" => $lang['Adr_items_none'],
				'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
				'L_ORDER' => $lang['Order'],
				'L_SORT' => $lang['Sort'],
				'L_SUBMIT' => $lang['Submit'],
				'S_MODE_SELECT' => $select_sort_mode,
				'S_ORDER_SELECT' => $select_sort_order,
				'PAGINATION' => $pagination,
				'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )), 
				'L_GOTO_PAGE' => $lang['Goto_page'],
				'S_MODE_ACTION' => append_sid("adr_shops.$phpEx?mode=see_shop&amp;shop_id=".$shop_id.""),
			));
			break;

		case 'shop_list' :

			$template->assign_block_vars('shop_list',array());

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

			$mode_types_text = array($lang['Adr_shop_name'], $lang['Adr_shop_owner_name'], $lang['Adr_shops_update_date']);
			$mode_types = array('name', 'owner', 'last_updated');

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
					$order_by = "s.shop_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				case 'owner':
					$order_by = "c.character_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				case 'last_updated':
					$order_by = "s.shop_last_updated $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				default:
					$order_by = "s.shop_last_updated $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
			}


			#==== Start: Build shop ids, shop item count & total shops
			$sql = "SELECT s.*, c.character_name, c.character_id
					FROM " . ADR_SHOPS_TABLE . " s, " . ADR_CHARACTERS_TABLE . " c
					WHERE s.shop_id <> '1'
					AND s.shop_owner_id <> '1'
					AND s.shop_owner_id = c.character_id
					ORDER BY $order_by";
			$result = $db->sql_query($sql);
			if (!$result)
				message_die(GENERAL_ERROR, 'Could not obtain shops infos', "", __LINE__, __FILE__, $sql);

			$row = $db->sql_fetchrowset($result);
			$total_shops = 0;
			$shops = $shops_count = $shops_join = array();
			$shops_per_page = 10;

			for ($x = 0; $x < count($row); $x++)
			{
				$total_items = adr_count_store_items($row[$x]['character_id']);
				if ($total_items > '0')
				{
					$total_items = ($total_items < '10') ? '0'. $total_items : $total_items;
					$total_shops++;
					$shops[] = $row[$x]['shop_id'];
					$shops_count[] = $total_items;
					$shops_join[] = $total_items .':'. $row[$x]['shop_id'];
				}
			}
			#==== End: Build shop ids, shop item count & total shops

			#==== Start: Rebuild shops arrays if ordered by total items
			if ($mode2 == 'total_items'){
				unset($shops, $shops_count);
				$shops = $shops_count = array();
				if ($sort_order == 'ASC')
					array_multisort($shops_join, SORT_ASC);
				else
					array_multisort($shops_join, SORT_DESC);

				for ($x = 0; $x < count($shops_join); $x++){
					unset($shop_exp);
					$shop_exp = explode(':', $shops_join[$x]);
					$shops[] = $shop_exp[1];
					$shops_count[] = $shop_exp[0];
				}
			}
			#==== End: Rebuild shops arrays if ordered by total items

			#==== Start: Build the page with the above info
			for ($x = 0; $x < count($row); $x++)
			{
				for ($y = $start; $y < ($shops_per_page + $start); $y++)
				{
					// V: better check for existing shops...
					if (!isset($shops[$y]))
					{
						// break because there's not gonna be "later" shops
						break;
					}

					if ($shops[$y] == $row[$x]['shop_id'])
					{
//  						$logo_url_check = ($row[$x]['shop_logo'] != '') ? (@fopen($row[$x]['shop_logo'], "r")) : '';
//  						if ((!$logo_url_check) && ($row[$x]['shop_logo'] != ''))
//  							adr_store_img_delete($row[$x]['character_id']);

						$template->assign_block_vars('shop_list.shops', array(
							"ROW_CLASS" 		=> (!($y % 2)) ? $theme['td_class1'] : $theme['td_class2'],
							"SHOP_NAME" 		=> $row[$x]['shop_name'],
							"SHOP_LAST_UPDATED" => ($row[$x]['shop_last_updated'] != '0') ? adr_make_time(time() - $row[$x]['shop_last_updated']) : $lang['Adr_shops_update_never'],
							"SHOP_LOGO" 		=> ((!empty($row[$x]['shop_logo'])) && ($logo_url_check)) ? '<img style="border:0" src="'.$row['shop_logo'].'">' : '',
							"SHOP_DESC" 		=> $row[$x]['shop_desc'],
							"SHOP_TOTAL" 		=> '<b><font color="red">'. $shops_count[$y] .'</font></b>',
							"OWNER_NAME" 		=> $row[$x]['character_name'],
							"U_SHOP_NAME" 		=> append_sid("adr_shops.$phpEx?mode=see_shop&amp;shop_id=".$row[$x]['shop_id']),
							"U_OWNER_NAME"		=> append_sid("adr_character.$phpEx?" . POST_USERS_URL . "=".$row[$x]['user_id']),
						));
					} #==== If ($shops[$y] == $row[$x]['shop_id'])
				} #==== for $y array
			} #==== for $x array

			$pagination = generate_pagination("adr_shops.$phpEx?&amp;mode=shop_list&amp;mode2=$mode2&amp;order=$sort_order&amp;cat=$cat", $total_shops, $shops_per_page, $start). '&nbsp;';
			#==== End: Build the page with the above info

			$template->assign_vars(array(
				"L_OWNER_NAME" => $lang['Adr_shop_owner_name'],
				"L_SHOP_NAME" => $lang['Adr_shop_name'],
				"L_SHOP_DESC" => $lang['Adr_shop_desc'],
				"L_SHOP_LAST_UPDATED" => $lang['Adr_shops_update_date'],
				"L_SHOP_TOTAL" => $lang['Adr_shop_total_items'],
				"L_OWNER" => $lang['Adr_users_shops_owner'],
				'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
				'L_ORDER' => $lang['Order'],
				'L_SORT' => $lang['Sort'],
				'L_SUBMIT' => $lang['Sort'],
				'S_MODE_SELECT' => $select_sort_mode,
				'S_ORDER_SELECT' => $select_sort_order,
				'PAGINATION' => $pagination,
				'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_shops / $board_config['topics_per_page'] )), 
				'L_GOTO_PAGE' => $lang['Goto_page'],
				'S_MODE_ACTION' => append_sid("adr_shops.$phpEx?mode=shop_list"),
			));
			break;
	}
}
else
{
	$template->assign_block_vars('main',array());

	$sql = "SELECT shop_id FROM " . ADR_SHOPS_TABLE . "
		WHERE shop_owner_id = $user_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	if ( is_numeric($row['shop_id']) )
	{
		$template->assign_block_vars('main.shop',array());	
	}
	else
	{
		$template->assign_block_vars('main.no_shop',array());	
	}
}

$sql = "SELECT shop_id FROM " . ADR_SHOPS_TABLE . "
	WHERE shop_owner_id = $user_id ";
$result = $db->sql_query($sql);
if( !$result )
{
	message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);
}
$shop_verify = $db->sql_fetchrow($result);
if ( is_numeric($shop_verify['shop_id']) )
{
	$decide_title = $lang['Adr_users_shops_manage'];	
	$decide_link = 'adr_shops.php?mode=see_shop&amp;shop_owner_id='.$user_id.'';
}
else
{
	$decide_title = $lang['Adr_users_shops_create'];
	$decide_link = 'adr_shops.php?mode=create_shop';
}

$money = $userdata['user_points'] . ' ' . $board_config['points_name'];


$template->assign_vars(array(
	'L_CHECK_ALL' => $lang['Adr_check_all'],
	'L_UNCHECK_ALL' => $lang['Adr_uncheck_all'],
	'L_FORUM_SHOPS' => $lang['Adr_forum_shops_go'],
	'L_LIST_SHOPS'  => $lang['Adr_users_shops_list'],
	'L_SHOPS'  		=> $lang['Adr_users_shops'],
	'L_SEARCH_ITEM' => $lang['Adr_items_search'],
	'L_CREATE_SHOP' => $lang['Adr_users_shops_create'],
	'L_MANAGE_SHOP' => $lang['Adr_users_shops_manage'],
	'L_SHOP_EDIT'   => $lang['Adr_users_shops_edit'],
	'L_SHOP_DELETE' => $lang['Adr_users_shops_delete'],

	'MONEY' => $money,
	'L_USER_MONEY' => $lang['Adr_shops_user_money'],
	'L_DECIDE' => $decide_title,
	'U_DECIDE' => append_sid("$decide_link"),

	'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
	'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
	'L_COPYRIGHT' => $lang['Adr_copyright'],
	'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
	'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
	'U_TOWNBOUTONRETOUR' => append_sid("adr_TownMap.$phpEx"),

	'U_FORUM_SHOPS' => append_sid("adr_shops.$phpEx?mode=see_shop&amp;shop_id=1"),
	'U_CREATE_SHOP' => append_sid("adr_shops.$phpEx?mode=create_shop"),
	'U_MANAGE_SHOP' => append_sid("adr_shops.$phpEx?mode=see_shop&amp;shop_owner_id=".$user_id),
	'U_SHOPS' 		 => append_sid("adr_shops.$phpEx"),
	'U_LIST_SHOPS'  => append_sid("adr_shops.$phpEx?mode=shop_list"),
	'U_SEARCH_ITEM' => append_sid("adr_shops.$phpEx?mode=search_item"),
	'U_SHOP_EDIT'  => append_sid("adr_shops.$phpEx?mode=shop_edit"),
	'U_SHOP_DELETE' => append_sid("adr_shops.$phpEx?mode=shop_delete"),
	'U_WAREHOUSE_DELETE' => append_sid("adr_shops.$phpEx?mode=warehouse_delete"),
	'S_SHOPS_ACTION'=> append_sid("adr_shops.$phpEx"),
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);


$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 
