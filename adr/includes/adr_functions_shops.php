<?php
/***************************************************************************
 *                                 adr_functions_shop.php
 *                            -------------------
 *   begin                : 08/02/2004
 *   copyright            : Dr DLP / Malicious Rabbit
 *   email                : ukc@wanadoo.fr
 *
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
 ***************************************************************************/

define('IN_ADR_BATTLE', true);
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

function adr_count_store_items($user_id)
{
	global $db;

	$user_id = intval($user_id);

	$sql = "SELECT item_in_shop FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = '$user_id'
		AND (item_duration > '0' OR item_duration_max = '-1')
		AND item_in_warehouse = '0'
		AND item_in_shop = '1'";
	if(!($result = $db->sql_query($sql))){
		message_die(CRITICAL_ERROR, 'Error Getting Adr Users!');}
	$items = $db->sql_fetchrowset($result);
	$items_owned = count($items);

	return number_format($items_owned);
}

function adr_store_img_delete($user_id)
{
	global $db, $lang;

	$sql = "UPDATE " . ADR_SHOPS_TABLE . "
			SET shop_logo = ''
			WHERE shop_owner_id = '$user_id'";
	$result = $db->sql_query($sql);
	if(!$result){
		message_die(GENERAL_ERROR, 'Could not obtain shops information', "", __LINE__, __FILE__, $sql);}

	return;
}

function adr_update_store_user_trans($user_id, $shop_owner_id, $items, $sum)
{
	global $db, $lang, $adr_user, $invent_array;

	// Fix the values
	$user_id = intval($user_id);
	$shop_owner_id = intval($shop_owner_id);
	$sum = intval($sum);

	##=== START: Update the user store transaction table ===##
	$sql = "SELECT user_store_trans_id FROM ".ADR_STORES_USER_HISTORY."
		WHERE user_store_owner_id = '$shop_owner_id'
		ORDER BY user_store_trans_id
		DESC LIMIT 1";
	$result = $db->sql_query($sql);
	if(!$result){
		message_die(GENERAL_ERROR, 'Could not query for store stats', '', __LINE__, __FILE__, $sql);}
	$seller_infos = $db->sql_fetchrow($result);
	$new_trans_id = intval($seller_infos['user_store_trans_id'] + 1);

	// Create item name array for trans log
	for($i = 0; $i < count($items); $i++){
		$item_id = $items[$i];

		for($in = 0; $in < count($invent_array); $in++){
			if($item_id == $invent_array[$in]['item_id']){
				$item_list .= adr_get_lang($invent_array[$in]['item_name']);
				if($in < (count($items) - 1))
					$item_list .= ', ';
			}
		}
	}

	// If no stats for store already exist in table then create new for this user
	$sql = "INSERT INTO ".ADR_STORES_USER_HISTORY."
		(user_store_trans_id, user_store_owner_id, user_store_info, user_store_total_price, user_store_date, user_store_buyer)
		VALUES($new_trans_id, $shop_owner_id, '".str_replace("\'", "''", $item_list)."', $sum, ".time().", '".$adr_user['character_name']."')";
	$result = $db->sql_query($sql);
	if(!$result){
		message_die(GENERAL_ERROR, "Couldn't insert user store transaction", "", __LINE__, __FILE__, $sql);}

	// Send PM to seller (if enabled) with transaction details
	$subject = sprintf($lang['Adr_seller_item_subject']);
	$message = sprintf($lang['Adr_seller_item_msg'], $adr_user['character_name'], $sum,  get_reward_name(), '<i>', $item_list, '</i>');
	$seller = adr_get_user_infos($shop_owner_id);
	if($seller['character_pref_seller_pm']){
		adr_send_pm($shop_owner_id, $subject, $message);}

	return;
}

// New sql insert function introduced into v0.4.4 for ease
function adr_shop_insert_item($item_id, $new_item_id, $user_id, $shop_owner_id, $type=0, $shop_id=0)
{
	global $db;

	$item_id = intval($item_id);
	$new_item_id = intval($new_item_id);
	$user_id = intval($user_id);
    $shop_owner_id = intval($shop_owner_id);
	$type = intval($type);
    $shop_id = intval($shop_id);

	// Select the item infos
	$shop_more_sql = ($shop_owner_id != '1') ? 'AND item_in_shop = 1' : ''; // Prevents users from buying items not in shops
	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = '$shop_owner_id'
		AND item_id = '$item_id'
		$shop_more_sql";
	$result = $db->sql_query($sql);
	if(!$result){
		message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);}
	$item_data = $db->sql_fetchrow($result);

	$item_type_use = $item_data['item_type_use'];
	$item_name = addslashes($item_data['item_name']);
	$item_desc = addslashes($item_data['item_desc']);
	$item_icon = trim($item_data['item_icon']);
	$item_price = $item_data['item_price'];
	$item_quality = $item_data['item_quality'];
	$item_duration = $item_data['item_duration'];
	$item_duration_max = $item_data['item_duration_max'];
	$item_power = $item_data['item_power'];
	$item_add_power = $item_data['item_add_power'];
	$item_mp_use = $item_data['item_mp_use'];
	$item_element = $item_data['item_element'];
	$item_element_str_dmg = $item_data['item_element_str_dmg'];
	$item_element_same_dmg = $item_data['item_element_same_dmg'];
	$item_element_weak_dmg = $item_data['item_element_weak_dmg'];
	$item_weight = $item_data['item_weight'];
	$item_max_skill = $item_data['item_max_skill'];
	$item_sell_back_percentage = $item_data['item_sell_back_percentage'];
	$item_bought_timestamp = $item_data['item_bought_timestamp'];
	$align_enable = $item_data['item_restrict_align_enable'];
	$align_type = $item_data['item_restrict_align'];
	$class_enable = $item_data['item_restrict_class_enable'];
	$class_type = $item_data['item_restrict_class'];
	$element_enable = $item_data['item_restrict_element_enable'];
	$element_type = $item_data['item_restrict_element'];
	$race_enable = $item_data['item_restrict_race_enable'];
	$race_type = $item_data['item_restrict_race'];
	$restrict_level = intval($item_data['item_restrict_level']);
	$restrict_str = intval($item_data['item_restrict_str']);
	$restrict_dex = intval($item_data['item_restrict_dex']);
	$restrict_con = intval($item_data['item_restrict_con']);
	$restrict_int = intval($item_data['item_restrict_int']);
	$restrict_wis = intval($item_data['item_restrict_wis']);
	$restrict_cha = intval($item_data['item_restrict_cha']);
	$item_crit = (intval($item_data['item_crit_hit'] == '0')) ? intval(20) : intval($item_data['item_crit_hit']);
	$item_crit_mod = (intval($item_data['item_crit_hit_mod'])) ? intval(2) : intval($item_data['item_crit_hit_mod']);

	// We need to check if this insert is for a stolen item or not
	if(($type = '1') && ($shop_id > '0')){
		$adr_user = adr_get_user_infos($user_id);
		$stolen_id = $shop_id;
		$stolen_by = str_replace("\'", "''", $adr_user['character_name']);
		$stolen_timestamp = time();
	}
	else{
		$stolen_id = $item_data['item_stolen_id'];
		$stolen_by = $item_data['item_stolen_by'];
		$stolen_timestamp = $item_data['item_stolen_timestamp'];
	}

	if($item_duration_max < $item_duration) $item_duration_max = $item_duration;

	$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . "
		(item_id, item_owner_id, item_type_use, item_name, item_desc, item_icon, item_price, item_quality, item_duration, item_duration_max, item_power, item_add_power, item_mp_use, item_weight, item_auth, item_element, item_element_str_dmg, item_element_same_dmg, item_element_weak_dmg, item_max_skill, item_sell_back_percentage, item_bought_timestamp, item_restrict_align_enable, item_restrict_align, item_restrict_class_enable, item_restrict_class, item_restrict_element_enable, item_restrict_element, item_restrict_race_enable, item_restrict_race, item_restrict_level, item_restrict_str, item_restrict_dex, item_restrict_con, item_restrict_int, item_restrict_wis, item_restrict_cha, item_crit_hit, item_crit_hit_mod, item_stolen_id, item_stolen_by, item_stolen_timestamp)
		VALUES($new_item_id, $user_id, $item_type_use, '$item_name', '$item_desc', '" . str_replace("\'", "''", $item_icon) . "', $item_price, $item_quality, $item_duration, $item_duration_max, $item_power, $item_add_power, $item_mp_use, $item_weight, 0, $item_element, $item_element_str_dmg, $item_element_same_dmg, $item_element_weak_dmg, $item_max_skill, $item_sell_back_percentage, ".time().", $align_enable, '$align_type', $class_enable, '$class_type', $element_enable, '$element_type', $race_enable, '$race_type', $restrict_level, $restrict_str, $restrict_dex, $restrict_con, $restrict_int, $restrict_wis, $restrict_cha, $item_crit, $item_crit_mod, $stolen_id, '$stolen_by', $stolen_timestamp)";
	$result = $db->sql_query($sql);
	if(!$result){
		message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);}
}

function adr_buy_item($user_id , $item_id , $shop_owner_id , $shop_id , $direct , $nav )
{
	global $db , $lang , $board_config , $phpEx , $userdata, $adr_general, $adr_user;

	// Fix the values
	$user_id = intval($user_id);
	$item_id = intval($item_id);
	$shop_owner_id = intval($shop_owner_id);
	$shop_id = intval($shop_id);

	$sql = "SELECT character_trading_limit FROM " . ADR_CHARACTERS_TABLE . "
			WHERE character_id = $user_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);
	}
	$trading_limit = $db->sql_fetchrow($result);

	if ( $adr_general['Adr_character_limit_enable'] != 0 && $trading_limit['character_trading_limit'] < 1 )
	{
		adr_previous( Adr_trading_limit , adr_shops , '' );
	}

	// Select the item infos
	$shop_more_sql = ( $shop_owner_id != 1 ) ? 'AND item_in_shop = 1' : ''; // Prevents users to buy items not in shops
	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = $shop_owner_id
		AND item_id = $item_id 
		$shop_more_sql ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);
	}
	$item_data = $db->sql_fetchrow($result);

	// Check if the item exists
	if ( !(is_numeric($item_data['item_price'])))
	{
		adr_previous( Adr_lack_items , $direct , $nav );
	}

	// Calculate the sum using the trading skill
	$sum = $item_data['item_price'];
	$sum = adr_use_skill_trading($user_id , $sum , buy);
	
	// Substract the points
	adr_substract_points( $user_id , $sum , $direct , $nav );

	// Make the new id for the item
	$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ."
		WHERE item_owner_id = $user_id
		ORDER BY item_id 
		DESC LIMIT 1";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$data = $db->sql_fetchrow($result);
	$new_item_id = $data['item_id'] + 1 ;

	// If the shop isn't the forums one , transfer , else duplicate 
	if ( $shop_owner_id != 1 )
	{
		$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
			SET item_owner_id = $user_id ,
				item_id = $new_item_id ,
				item_bought_timestamp = ".time().",
				item_in_shop = 0 , 
				item_auth = 0,
				item_donated_by = '',
				item_donated_timestamp = 0
			WHERE item_owner_id = $shop_owner_id
			AND item_id = $item_id ";
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);
		}

		// Give money to the seller
		adr_add_points( $shop_owner_id , $sum );
	}
	else
	{
		// Commenting out instead of deleting in order to preserve additional MOD changes
		/*
		$item_type_use = $item_data['item_type_use'];
		$item_name = addslashes($item_data['item_name']);
		$item_desc = addslashes($item_data['item_desc']);
		$item_icon = trim($item_data['item_icon']);
		$item_price = $item_data['item_price'];
		$item_quality = $item_data['item_quality'];
		$item_duration = $item_data['item_duration'];
		$item_duration_max = $item_data['item_duration_max'];
		$item_power = $item_data['item_power'];
		$item_add_power = $item_data['item_add_power'];
		$item_mp_use = $item_data['item_mp_use'];
		$item_element = $item_data['item_element'];
		$item_element_str_dmg = $item_data['item_element_str_dmg'];
		$item_element_same_dmg = $item_data['item_element_same_dmg'];
		$item_element_weak_dmg = $item_data['item_element_weak_dmg'];
		$item_weight = $item_data['item_weight'];
		$item_max_skill = $item_data['item_max_skill'];
		$item_sell_back_percentage = $item_data['item_sell_back_percentage'];
		$item_bought_timestamp = $item_data['item_bought_timestamp'];

		if ( $item_duration_max < $item_duration ) $item_duration_max = $item_duration;

		$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . " 
			( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_duration_max , item_power , item_add_power , item_mp_use , item_weight , item_auth , item_element , item_element_str_dmg , item_element_same_dmg , item_element_weak_dmg , item_max_skill , item_sell_back_percentage, item_bought_timestamp )
			VALUES ( $new_item_id , $user_id , $item_type_use , '$item_name' , '$item_desc' , '" . str_replace("\'", "''", $item_icon) . "' , $item_price , $item_quality , $item_duration , $item_duration_max , $item_power , $item_add_power , $item_mp_use , $item_weight , 0 , $item_element , $item_element_str_dmg , $item_element_same_dmg , $item_element_weak_dmg , $item_max_skill , $item_sell_back_percentage, , ".time()." )";
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
		}
		*/
		// Insert item details
		adr_shop_insert_item($item_id, $new_item_id, $user_id, $shop_owner_id);
	}

	return $sum;
}

function adr_buy_admin_item($user_id , $item_id , $shop_owner_id , $shop_id , $direct , $nav )
{
	global $db , $lang , $board_config , $phpEx;

	// Fix the values
	$user_id = intval($user_id);
	$item_id = intval($item_id);
	$shop_owner_id = intval($shop_owner_id);
	$shop_id = intval($shop_id);

	// Select the item infos
	$shop_more_sql = ( $shop_owner_id != 1 ) ? 'AND item_in_shop = 1' : ''; // Prevents users to buy items not in shops
	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = $shop_owner_id
		AND item_id = $item_id 
		$shop_more_sql ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);
	}
	$item_data = $db->sql_fetchrow($result);

	// Check if the item exists
	if ( !(is_numeric($item_data['item_price'])))
	{
		adr_previous( Adr_lack_items , $direct , $nav );
	}

	// Make the new id for the item
	$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ."
		WHERE item_owner_id = $user_id
		ORDER BY item_id 
		DESC LIMIT 1";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
	}
	$data = $db->sql_fetchrow($result);
	$new_item_id = $data['item_id'] + 1 ;

	// Insert item details
	adr_shop_insert_item($item_id, $new_item_id, $user_id, $shop_owner_id);

	return $sum;
}


function adr_give_item($user_id , $to_user_id , $item_id )
{
	global $db , $lang , $userdata , $adr_general ;

	// Fix the values
	$user_id = intval($user_id);
	$to_user_id = intval($to_user_id);
	$item_id = intval($item_id);

	// Grab user infos
	$give_limit = adr_get_user_infos($user_id);

	if ( $adr_general['Adr_character_limit_enable'] != 0 && $give_limit['character_trading_limit'] < 1 )
	{
		adr_previous( Adr_trading_limit , adr_shops , '' );
	}
	else
	{
		adr_trading_limit( $user_id );
	}

	// Make the new id for the item
	$sql = "SELECT item_id, item_name FROM " . ADR_SHOPS_ITEMS_TABLE ."
		WHERE item_owner_id = $to_user_id
		ORDER BY item_id 
		DESC LIMIT 1";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		adr_previous( Adr_shop_items_failure_deleted , adr_character_inventory , '');
	}
	$data = $db->sql_fetchrow($result);
	$new_item_id = $data['item_id'] + 1 ;

	// Grab the items details
	$sql = "SELECT item_id, item_name, item_stolen_id, item_stolen_by, item_stolen_timestamp, item_donated_by, item_donated_timestamp
		FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = '$user_id'
		AND item_id = '$item_id'";
	$result = $db->sql_query($sql);
	if(!$result){
		adr_previous(Adr_shop_items_failure_deleted, adr_character_inventory, '');}
	$item_details = $db->sql_fetchrow($result);

	// Check if recieving user has notify of donated items enabled
	$sql = "SELECT character_pref_give_pm FROM " . ADR_CHARACTERS_TABLE . "
			WHERE character_id = $to_user_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);
	}
	$reciever = $db->sql_fetchrow($result);

	// Send recieving user PM notification
	$subject = sprintf($lang['Adr_give_item_subject'] , $userdata['username']);
	$message = sprintf($lang['Adr_give_item_msg'] , adr_get_lang( $item_details['item_name'] ) , $userdata['username']);
	
	if ( $reciever['character_pref_give_pm'] )
	{
		adr_send_pm ( $to_user_id , $subject , $message );
	}

	$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
		SET item_owner_id = $to_user_id,
			item_id = $new_item_id,
			item_bought_timestamp = ".time().",
			item_in_shop = 0,
			item_auth = 0,
			item_stolen_id = ".$item_details['item_stolen_id'].",
			item_stolen_by = '".$item_details['item_stolen_by']."',
			item_stolen_timestamp = ".$item_details['item_stolen_timestamp'].",
			item_donated_by = '".str_replace("\'", "''", $give_limit['character_name'])."',
			item_donated_timestamp = ".time()."
		WHERE item_owner_id = '$user_id'
		AND item_id = '$item_id'";
	$result = $db->sql_query($sql);
	if(!$result){
		message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);}
}

function adr_steal_item($user_id , $item_id , $shop_owner_id , $shop_id )
{
	global $db , $lang , $phpEx, $adr_general ,$board_config, $store_id;

	// Fix the values
	$user_id = intval($user_id);
	$item_id = intval($item_id);
	$shop_owner_id = intval($shop_owner_id);
	$shop_id = intval($shop_id);

	if ( $shop_owner_id != 1 )
	{
		$direction = append_sid("adr_shops.$phpEx?mode=see_shop&amp;shop_id=".$shop_id);
	}
	else
	{
		$direction = append_sid("adr_shops.$phpEx?mode=view_store&amp;shop_id=".$shop_id);
	}

	// Check if stealing is enabled by admin
	if(!$adr_general['allow_shop_steal']){
		$message = sprintf($lang['Adr_steal_item_forbidden'], $sum, $points_name);
		$message .= '<br /><br />'.sprintf($lang['Adr_return'], "<a href=\"" . $direction . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}

	// Check if user is high enough lvl to be allowed steal attempt
	if($adr_general['Adr_shop_steal_min_lvl'] > '0'){
		$adr_user = adr_get_user_infos($user_id);
		if($adr_user['character_level'] < $adr_general['Adr_shop_steal_min_lvl']){
			$message = $lang['Adr_shop_steal_min_lvl'].'<br /><br />';
			$message .= sprintf($lang['Adr_shop_steal_min_lvl2'], '<b>', $adr_general['Adr_shop_steal_min_lvl'], '</b>');
			$message .= '<br /><br />'.sprintf($lang['Adr_return'], "<a href=\"" . $direction . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);}
	}

	$sql = "SELECT character_thief_limit FROM " . ADR_CHARACTERS_TABLE . "
		WHERE character_id = $user_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain thief limit info', "", __LINE__, __FILE__, $sql);
	}
	$thief_limit = $db->sql_fetchrow($result);

	if ( $adr_general['Adr_character_limit_enable'] != 0 && $thief_limit['character_thief_limit'] < 1 )
	{
		adr_previous( Adr_thief_limit , adr_shops , '' );
	}

	// Select the item infos
	$shop_more_sql = ($shop_owner_id != '1') ? 'AND item_in_shop = 1' : '';
	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = '$shop_owner_id'
		AND item_id = '$item_id'
		$shop_more_sql";
	$result = $db->sql_query($sql);
	if(!$result){
		message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);}
	$item_data = $db->sql_fetchrow($result);

	// Check item is stealable
	if(($item_data['item_steal_dc'] == '0') && ($shop_owner_id == '1'))
//		adr_previous(Adr_store_not_stealable, shops, "view_store&amp;shop_id=".$shop_id."", '', 'adr/images/store_owners/'.$store_info['shop_logo'].'');
		adr_previous(Adr_store_not_stealable, adr_shops);

	// Check for successful steal or not
	$success = adr_use_skill_thief($user_id, $item_data['item_steal_dc']);

	if($success == TRUE)
	{
		// Make the new id for the item
		$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE ."
			WHERE item_owner_id = '$user_id'
			ORDER BY item_id
			DESC LIMIT 1";
		$result = $db->sql_query($sql);
		if(!$result){
			message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);}
		$data = $db->sql_fetchrow($result);
		$new_item_id = ($data['item_id'] + 1);

		if($shop_owner_id != '1'){
			// This will never be TRUE as of v0.4.3 because there is no player store stealing allowed
			$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
				SET item_owner_id = $user_id,
					item_id = $new_item_id,
					item_bought_timestamp = ".time().",
					item_in_shop = '0', 
					item_auth = '0'
					item_stolen_by = '',
					item_stolen_timestamp = ".time."
				WHERE item_owner_id = '$shop_owner_id'
				AND item_id = '$item_id'";
			$result = $db->sql_query($sql);
			if(!$result){
				message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);}
		}
		else{
			// Insert item details
			$type = 1; //This is so the insert function knows that this is a stolen item for update purposes only (optional function variable)
			adr_shop_insert_item($item_id, $new_item_id, $user_id, $shop_owner_id, $type, $shop_id);
		}
		adr_thief_limit( $user_id );
		adr_store_stats_update_steal($success, $user_id, $shop_owner_id, $store_id);

		$message = sprintf($lang['Adr_steal_item_success'] , $sum , $points_name );
		$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;
		message_die ( GENERAL_MESSAGE , $message );

	}
	else
	{
		$message = sprintf($lang['Adr_steal_item_failure'] , $sum , $points_name );

		if ( $adr_general['skill_thief_failure_damage'] )
		{
			// Select the item price
			$shop_more_sql = ( $shop_owner_id != 1 ) ? 'AND i.item_in_shop = 1' : ''; // Prevents users to buy items not in shops
			$sql = "SELECT i.item_price , i.item_name, u.user_points
				FROM " . ADR_SHOPS_ITEMS_TABLE . " i ,
					" . USERS_TABLE . " u
				WHERE i.item_owner_id = $shop_owner_id
					AND u.user_id = $user_id
					AND i.item_id = $item_id 
				$shop_more_sql ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);
			}
			$data = $db->sql_fetchrow($result);
			$user_points = $data['user_points'];
			$price = $data['item_price'];

			$fine = ( $price < intval($adr_general['skill_thief_failure_damage']) ) ? intval($adr_general['skill_thief_failure_damage']) : $price ;

			if ( ( $fine > $user_points ) && $adr_general['skill_thief_failure_punishment'] )
			{
           			$sql = " SELECT owner_id , account_sum FROM " . ADR_VAULT_USERS_TABLE . "
						WHERE owner_id = $user_id ";
          			if( !($result = $db->sql_query($sql)) )
            			{
                  			message_die(GENERAL_ERROR, 'Could not query user stats page', '', __LINE__, __FILE__, $sql);
            			}
            			$vault_sum = $db->sql_fetchrow($result);

				if ( $adr_general['skill_thief_failure_punishment'] == 1 )
				{
					if ( is_numeric($vault_sum['owner_id']) && $vault_sum['account_sum'] >= $fine )
					{
						$vault_fine = $fine;
						$fine = 0;

						// Remove cash from Vault instead
						$sql = "UPDATE " . ADR_VAULT_USERS_TABLE . "
							SET account_sum = account_sum - $vault_fine
							WHERE owner_id = $user_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not update user points from Vault',"", __LINE__, __FILE__, $sql);
						}
					}
					elseif ( is_numeric($vault_sum['owner_id']) && $vault_sum['account_sum'] > 0 && $vault_sum['account_sum'] < $fine )
					{
						$vault_fine = $vault_sum['account_sum'];	
						$fine = 0;

						// Remove cash from Vault instead
						$sql = "UPDATE " . ADR_VAULT_USERS_TABLE . "
							SET account_sum = account_sum - $vault_fine
							WHERE owner_id = $user_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not update user points from Vault',"", __LINE__, __FILE__, $sql);
						}
					}
					else
					{
						$fine = $user_points;
						$vault_fine = 0;
					}
				}

				else if ( $adr_general['skill_thief_failure_punishment'] == 2 )
				{
					adr_cell_imprison_user($user_id , 0 , $adr_general['skill_thief_failure_time'] , 0 , $price  , 1 , 1 , $lang['Adr_steal_item_failure_critical_all_sentence'] , $adr_general['skill_thief_failure_type'] );

					$failure[0] = $lang['Adr_steal_item_failure_critical_all'];	
					$failure[1] = $lang['Adr_steal_item_failure_critical_post'];	
					$failure[2] = $lang['Adr_steal_item_failure_critical_read'];	
					$fail = $failure[$adr_general['skill_thief_failure_type']];

					$fail_message = sprintf($lang['Adr_steal_item_failure_critical'], '<b>', adr_get_lang($data['item_name']), '</b>');
					$fail_message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;
					message_die ( GENERAL_MESSAGE , $fail_message );
				}
			}

			adr_thief_limit( $user_id );
			adr_store_stats_update_steal($success, $user_id, $shop_owner_id, $store_id);
			
			subtract_reward( $user_id, $fine );
		}
	
		if ( $fine != 0 )
		{
			$fine = $fine;
		}
		else
		{
			$fine = $vault_fine;	
		}
		$message .= '<br /><br />'.sprintf($lang['Adr_steal_item_failure_suite'], $fine , $points_name);	
		$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;
		message_die ( GENERAL_MESSAGE , $message );
	}
}

function adr_store_stats_update_steal($success, $user_id, $shop_owner_id, $store_id)
{
	global $db;

	if($shop_owner_id == '1'){
		##=== START: Update the store stats table with user infos ===##
		$sql = "SELECT store_stats_character_id, store_stats_stolen_item_total, store_stats_stolen_item_fail_total
			FROM ". ADR_STORES_STATS_TABLE ."
			WHERE store_stats_character_id = '$user_id'
			AND store_stats_store_id = '$store_id'";
		$result = $db->sql_query($sql);
		if (!$result){
			message_die(GENERAL_ERROR, 'Could not query for store stats', '', __LINE__, __FILE__, $sql);}
		$store_stats = $db->sql_fetchrow($result);

		if($success == '1'){
			$total_stolen = intval($store_stats['store_stats_stolen_item_total'] + 1);
			$total_stolen_fail = intval($store_stats['store_stats_stolen_item_fail_total']);
		}
		else{
			$total_stolen = intval($store_stats['store_stats_stolen_item_total']);
			$total_stolen_fail = intval($store_stats['store_stats_stolen_item_fail_total'] + 1);
		}

		// If no stats for store already exist in table then create new for this user
		if($store_stats['store_stats_character_id'] == ''){
			$sql = "INSERT INTO " . ADR_STORES_STATS_TABLE . "
				(store_stats_character_id, store_stats_store_id, store_stats_stolen_item_total, store_stats_stolen_item_fail_total, store_stats_stolen_item_last)
				VALUES($user_id, $store_id, $total_stolen, $total_stolen_fail, ".time().")";
			$result = $db->sql_query($sql);
			if(!$result){
				message_die(GENERAL_ERROR, "Couldn't insert user store stats", "", __LINE__, __FILE__, $sql);}
		}

		// if store stats for this user do already exist then we'll simply update current entry
		if($store_stats['store_stats_character_id'] != ''){
			$sql = "UPDATE " . ADR_STORES_STATS_TABLE ."
				SET store_stats_stolen_item_total = $total_stolen,
					store_stats_stolen_item_fail_total = $total_stolen_fail,
					store_stats_stolen_item_last = ".time()."
				WHERE store_stats_store_id = '$store_id'
				AND store_stats_character_id = '$user_id'";
			if(!$db->sql_query($sql)){
				message_die(GENERAL_ERROR, 'Could not update store with updated stats', "", __LINE__, __FILE__, $sql);}
		}
		##=== END: Update the store stats table with user infos ===##
	}
}

function adr_get_item_real_price($item_id , $user_id)
{
	global $db ;

	// Fix the values
	$item_id = intval($item_id);
	$user_id = intval($user_id);

	$adr_general = adr_get_general_config();


	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_id = $item_id 
		AND item_owner_id = $user_id ";
	if ( !($result=$db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, "Couldn't query item infos", "", __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	
	// Once again , let's protect us about malicious users ...
	if ( !(is_numeric($row['item_type_use'])))
	{
		message_die(GENERAL_ERROR, "This item doesn't exist");
	}

	$item_type = $row['item_type_use'];
	$item_quality = $row['item_quality'];
	$item_duration = $row['item_duration'];
	$item_duration_max = $row['item_duration_max'];
	$item_power = $row['item_power'];

	// Get the base and modifier price
	$adr_quality_price = adr_get_item_quality( $item_quality , price );
	$adr_type_price = adr_get_item_type( $item_type , price );

	// First define the base price
	$item_price = $adr_type_price;

	// Apply the sell back penalty
	$item_price = ( $row['item_sell_back_percentage'] * $item_price ) / 100;

	// Then apply the quality modifier
	$item_price = $item_price * ( ( $adr_quality_price / 100 ));

	// And now the power - it's a little more complicated
	$item_price = ( $item_power > 1 ) ? ( $item_price + ( $item_price * ( ( $item_power - 1 ) * ( $adr_general['item_modifier_power'] - 100 ) / 100 ))) : $item_price ;

	// Apply the duration penalty
	$item_price = abs($item_price / ($item_duration_max / $item_duration));

	// Finally let's use a non decimal value
	$item_price = ceil($item_price);

	return $item_price ;
}

function adr_sell_item($item_id , $user_id)
{
	global $db, $adr_general;

	// Fix the values
	$user_id = intval($user_id);
	$item_id = intval($item_id);

	$sql = "SELECT character_trading_limit FROM " . ADR_CHARACTERS_TABLE . "
			WHERE character_id = $user_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain shops items information', "", __LINE__, __FILE__, $sql);
	}
	$trading_limit = $db->sql_fetchrow($result);

	if ( $adr_general['Adr_character_limit_enable'] != 0 && $trading_limit['character_trading_limit'] < 1 )
	{
		adr_previous( Adr_trading_limit , adr_shops , '' );
	}
	else
	{
		adr_trading_limit( $user_id );
	}

	// Get the item real price
	$temp_price = adr_get_item_real_price($item_id , $user_id);

	// Apply the trading skill modification
	$price = adr_use_skill_trading($user_id , $temp_price , sell);

	// Delete the item
	$sql = "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE ."
		WHERE item_owner_id = $user_id
		AND item_id = $item_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		adr_previous( Adr_shop_items_failure_deleted , adr_character_inventory , '');
	}

	// Give points to the seller - has to be done at the end to prevent treacherous users !
	adr_add_points( $user_id , $price );

}

function adr_use_item($item_id , $user_id)
{
	global $db;

	// Fix the values
	$user_id = intval($user_id);
	$item_id = intval($item_id);

	// Update the item
	$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE ."
		SET item_duration = item_duration - 1
		WHERE item_owner_id = $user_id
		AND item_id = $item_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not delete item ', "", __LINE__, __FILE__, $sql);
	}
}

function adr_thief_limit($user_id)
{
	global $db , $lang, $adr_general;

	// Fix the values
	$user_id = intval($user_id);

   // Only remove if quota is enabled
   if($adr_general['Adr_character_limit_enable'] == '1'){
      // Update the item
      $sql = "UPDATE " . ADR_CHARACTERS_TABLE ."
         SET character_thief_limit = (character_thief_limit - 1)
         WHERE character_id = '$user_id'";
      $result = $db->sql_query($sql);
      if(!$result){
         message_die(GENERAL_ERROR, 'Could not update thief skill ', "", __LINE__, __FILE__, $sql);}
   }
}

function adr_trading_limit($user_id)
{
	global $db , $lang, $adr_general;

	// Fix the values
	$user_id = intval($user_id);

   // Only remove if quota is enabled
   if($adr_general['Adr_character_limit_enable'] == '1'){
      // Update the item
      $sql = "UPDATE " . ADR_CHARACTERS_TABLE ."
         SET character_trading_limit = (character_trading_limit - 1)
         WHERE character_id = '$user_id'";
      $result = $db->sql_query($sql);
      if(!$result){
         message_die(GENERAL_ERROR, 'Could not update trading skill ', "", __LINE__, __FILE__, $sql);}
   }
}