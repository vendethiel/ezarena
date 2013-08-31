<?php
/***************************************************************************
 *					adr_zones.php
 *				------------------------
 *	begin 		: 05/03/2005
 *	copyright		: One_Piece
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
define('IN_ADR_TOWN', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_ZONES', true);
$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR);
init_userprefs($userdata);
// End session management
//
$user_id = $userdata['user_id'];
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_zones_body.tpl');
include_once($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config and character infos
$adr_general = adr_get_general_config();
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
$adr_user = adr_get_user_infos($user_id);

// Get Zone infos
$area_id = $adr_user['character_area'];

$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_id = '$area_id' ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$zone = $db->sql_fetchrow($result);
$zone_name = $zone['zone_name'];
$zone_img = $zone['zone_img'];
$zone_desc = $zone['zone_desc'];
$zone_element = $zone['zone_element'];
$cost_goto1 = $zone['cost_goto1'];
$cost_goto2 = $zone['cost_goto2'];
$cost_goto3 = $zone['cost_goto3'];
$cost_goto4 = $zone['cost_goto4'];
$cost_return = $zone['cost_return'];
$goto1_name = $zone['goto1_name'];
$goto2_name = $zone['goto2_name'];
$goto3_name = $zone['goto3_name'];
$goto4_name = $zone['goto4_name'];
$return_name = $zone['return_name'];
$zone_shops = $zone['zone_shops'];
$zone_forge = $zone['zone_forge'];
$zone_mine = $zone['zone_mine'];
$zone_enchant = $zone['zone_enchant'];
$zone_temple = $zone['zone_temple'];
$zone_prison = $zone['zone_prison'];
$zone_bank = $zone['zone_bank'];
$event_1 = $zone['zone_event1'];
$event_2 = $zone['zone_event2'];
$event_3 = $zone['zone_event3'];
$event_4 = $zone['zone_event4'];
$event_5 = $zone['zone_event5'];
$event_6 = $zone['zone_event6'];
$event_7 = $zone['zone_event7'];
$event_8 = $zone['zone_event8'];
$zone_pointwin1 = $zone['zone_pointwin1'];
$zone_pointwin2 = $zone['zone_pointwin2'];
$zone_pointloss1 = $zone['zone_pointloss1'];
$zone_pointloss2 = $zone['zone_pointloss2'];
$zone_chance = $zone['zone_chance'];
$npc_price = $zone['npc_price'];
$zone_npc1 = $zone['npc1_enable'];
$zone_npc2 = $zone['npc2_enable'];
$zone_npc3 = $zone['npc3_enable'];
$zone_npc4 = $zone['npc4_enable'];
$zone_npc5 = $zone['npc5_enable'];
$zone_npc6 = $zone['npc6_enable'];
$npc1_message = $zone['npc1_message'];
$npc2_message = $zone['npc2_message'];
$npc3_message = $zone['npc3_message'];
$npc4_message = $zone['npc4_message'];
$npc5_message = $zone['npc5_message'];
$npc6_message = $zone['npc6_message'];

//prevent blank destination
if ( $goto2_name == '' )
{
	$goto2_name = $lang['Adr_zone_destination_none'];
}
else
{
	$template->assign_var('HAS_GOTO_2', true);
}

if ( $goto3_name == '' )
{
	$goto3_name = $lang['Adr_zone_destination_none'];
}
else
{
	$template->assign_var('HAS_GOTO_3', true);
}

if ( $goto4_name == '' )
{
	$goto4_name = $lang['Adr_zone_destination_none'];
}
else
{
	$template->assign_var('HAS_GOTO_4', true);
}

if ( $return_name == '' )
{
	$return_name = $lang['Adr_zone_destination_none'];
}
else
{
	$template->assign_var('HAS_GOTO_RETURN', true);
}


//
// BEGIN of Zones Navigation
//

//Go To first choice zone
$goto1 = $HTTP_POST_VARS['goto1'];

if ( $goto1 )
{
	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Select the zone destination
	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
      	WHERE zone_name = '$goto1_name' ";
	if( !($result = $db->sql_query($sql)) )
       	 message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone_id = $db->sql_fetchrow($result);
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_goto1 , adr_zones , '' );

		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_area = '$destination_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = '' . $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//Go To second choice zone
$goto2 = $HTTP_POST_VARS['goto2'];

if ( $goto2 )
{
	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Prevent blank destination error
	if ( $goto2_name == '' . $lang['Adr_zone_destination_none'] . '' )
		adr_previous( Adr_zone_change_unavaible , adr_zones , '' );

	//Select the zone destination
	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
      	WHERE zone_name = '$goto2_name' ";
	if( !($result = $db->sql_query($sql)) )
       	 message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone_id = $db->sql_fetchrow($result);
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_goto2 , adr_zones , '' );

		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_area = '$destination_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = '' . $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//Go To third choice zone
$goto3 = $HTTP_POST_VARS['goto3'];

if ( $goto3 )
{
	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Prevent blank destination error
	if ( $goto3_name == '' . $lang['Adr_zone_destination_none'] . '' )
		adr_previous( Adr_zone_change_unavaible , adr_zones , '' );

	//Select the zone destination
	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
      	WHERE zone_name = '$goto3_name' ";
	if( !($result = $db->sql_query($sql)) )
       	 message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone_id = $db->sql_fetchrow($result);
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_goto3 , adr_zones , '' );

		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_area = '$destination_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = '' . $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//Go To fourth choice zone
$goto4 = $HTTP_POST_VARS['goto4'];

if ( $goto4 )
{
	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Prevent blank destination error
	if ( $goto4_name == '' . $lang['Adr_zone_destination_none'] . '' )
		adr_previous( Adr_zone_change_unavaible , adr_zones , '' );

	//Select the zone destination
	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
      	WHERE zone_name = '$goto4_name' ";
	if( !($result = $db->sql_query($sql)) )
       	 message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone_id = $db->sql_fetchrow($result);
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_goto4 , adr_zones , '' );

		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_area = '$destination_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = '' . $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//Return to the previous zone
$return = $HTTP_POST_VARS['return'];

if ( $return )
{
	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Prevent blank destination error
	if ( $return_name == '' . $lang['Adr_zone_destination_none'] . '' )
		adr_previous( Adr_zone_change_unavaible , adr_zones , '' );

	//Select the zone destination
	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
      	WHERE zone_name = '$return_name' ";
	if( !($result = $db->sql_query($sql)) )
       	 message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone_id = $db->sql_fetchrow($result);
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_return , adr_zones , '' );

		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_area = '$destination_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);
	
		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = '' . $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//
// END of Zones Navigation
//

//
// BEGIN of Zones Events
//

//Define if the event happened
$zone_events = rand( 1 , $zone_chance );

if ( $zone_events == '1' )
{
	$what_event = rand( 1 , 8 );

	//Get points
	if ( $what_event == '1' && $event_1 == '1' )
	{
		//Define money value
		$win = rand( $zone_pointwin1 , $zone_pointwin2 );

		adr_add_points( $user_id , $win );

		$message = '<img src="adr/images/zones/get_money.gif"><br \><br \>' . $lang['Adr_zone_event_winpoint'] . ' ' . $win . ' ' . $board_config['points_name'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Loss of points
	else if ( $what_event == '2' && $event_2 == '1' )
	{
		//Define money value
		$loss = rand( $zone_pointloss1 , $zone_pointloss2 );

		if ( $loss > $userdata['user_points'] ) $loss = ( $userdata['user_points'] / 2 );

		adr_substract_points( $user_id , $loss , adr_zones , '' );

		$message = '<img src="adr/images/zones/loss_money.gif"><br \><br \>' . $lang['Adr_zone_event_losspoint'] . ' ' . $loss . ' ' . $board_config['points_name'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Fountain of youth
	else if ( $what_event == '3' && $event_3 == '1' )
	{
		//Update character health
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_hp = character_hp_max
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		$message = '<img src="adr/images/zones/fountain_of_youth.gif"><br \><br \>' . $lang['Adr_zone_event_fountain_youth'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Fountain of mana
	else if ( $what_event == '4' && $event_4 == '1' )
	{
		//Update character mp
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_mp = character_mp_max
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		$message = '<img src="adr/images/zones/fountain_of_mana.gif"><br \><br \>' . $lang['Adr_zone_event_fountain_mana'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Poisonned
	else if ( $what_event == '5' && $event_5 == '1' )
	{
		//Update character hp
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_hp = '1'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		$message = '<img src="adr/images/zones/poisonned.gif"><br \><br \>' . $lang['Adr_zone_event_poison'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Weakness
	else if ( $what_event == '6' && $event_6 == '1' )
	{
		//Update character mp
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_mp = '0'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		$message = '<img src="adr/images/zones/weakness.gif"><br \><br \>' . $lang['Adr_zone_event_weakness'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Get items
	else if ( $what_event == '7' && $event_7 == '1' )
	{
		// Make the new id for the item
		$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_owner_id = '$user_id'
			ORDER BY 'item_id' DESC 
			LIMIT 1";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);

		$data = $db->sql_fetchrow($result);
		$new_item_id = $data['item_id'] + 1 ;

		//Select zone specific items
		$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . " 
			WHERE item_owner_id = '1'
			AND ( item_zone = '$area_id' || item_zone = '0' )
			ORDER BY rand() LIMIT 1 ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);

		$new_item				= $db->sql_fetchrow($result);
		$item_type_use 			= $new_item['item_type_use'];
		$item_name 				= trim(rtrim(addslashes(stripslashes($new_item['item_name']))));
		$item_desc 				= trim(rtrim(addslashes(stripslashes($new_item['item_desc']))));
		$item_icon 				= trim(rtrim($new_item['item_icon']));
		$item_price				= $new_item['item_price'];
		$item_quality 			= $new_item['item_quality'];
		$item_duration 			= $new_item['item_duration'];
		$item_duration_max 		= $new_item['item_duration_max'];
		$item_power 			= $new_item['item_power'];
		$item_add_power 			= $new_item['item_add_power'];
		$item_mp_use 			= $new_item['item_mp_use'];
		$item_element 			= $new_item['item_element'];
		$item_element_str_dmg 		= $new_item['item_element_str_dmg'];
		$item_element_same_dmg 		= $new_item['item_element_same_dmg'];
		$item_element_weak_dmg 		= $new_item['item_element_weak_dmg'];
		$item_weight 			= $new_item['item_weight'];
		$item_max_skill 			= $new_item['item_max_skill'];
		$item_sell_back_percentage 	= $new_item['item_sell_back_percentage'];

		if ( $item_duration_max < $item_duration ) $item_duration_max = $item_duration;

		$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . "
			( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_duration_max , item_power , item_add_power , item_mp_use , item_weight , item_auth , item_element , item_element_str_dmg , item_element_same_dmg , item_element_weak_dmg , item_max_skill , item_sell_back_percentage )
			VALUES ( '$new_item_id' , '$user_id' , '$item_type_use' , '$item_name' , '$item_desc' , '" . str_replace("\'", "''", $item_icon) . "' , '$item_price' , '$item_quality' , '$item_duration' , '$item_duration_max' , '$item_power' , '$item_add_power' , '$item_mp_use' , '$item_weight' , '0' , '$item_element' , '$item_element_str_dmg' , '$item_element_same_dmg' , '$item_element_weak_dmg' , '$item_max_skill' , '$item_sell_back_percentage' )";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);

		$message = '<img src="adr/images/zones/get_item.gif"><br \><br \>' . $lang['Adr_zone_event_item'] . '<br \><br \><b>' . $item_name . '</b><br \><br \><img src="adr/images/items/' . $item_icon . '"><br \><br \>' . $item_desc . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Ambush
	else if ( $what_event == '8' && $event_8 == '1' )
	{
		//Define money value
		$loss = rand( $zone_pointloss1 , $zone_pointloss2 );

		if ( $loss > $userdata['user_points'] ) $loss =  $userdata['user_points'];

		adr_substract_points( $user_id , $loss , adr_zones , '' );

		$message = '<img src="adr/images/zones/ambush.gif"><br \><br \>' . $lang['Adr_zone_event_ambush'] . ' ' . $loss . ' ' . $board_config['points_name'] . '<br \><br \>' . $lang['Adr_zone_event_battle'] . '<br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//
// END of Zones Events
//


//
// BEGIN of NPCs Action
//

// NPCs images
( $zone_npc1 == '1' ) ? $npc1 = 'npc1_enable' : $npc1 = 'npc1_disable';
( $zone_npc2 == '1' ) ? $npc2 = 'npc2_enable' : $npc2 = 'npc2_disable';
( $zone_npc3 == '1' ) ? $npc3 = 'npc3_enable' : $npc3 = 'npc3_disable';
( $zone_npc4 == '1' ) ? $npc4 = 'npc4_enable' : $npc4 = 'npc4_disable';
( $zone_npc5 == '1' ) ? $npc5 = 'npc5_enable' : $npc5 = 'npc5_disable';
( $zone_npc6 == '1' ) ? $npc6 = 'npc6_enable' : $npc6 = 'npc6_disable';

// NPCs links
( $zone_npc1 == '1' ) ? $npc1_link = '<input type="submit" name="npc1" value="'. $lang['Adr_zone_npc_talk'] .'" class="mainoption" />' : $npc1_link = $lang['Adr_zone_npc_disable'];
( $zone_npc2 == '1' ) ? $npc2_link = '<input type="submit" name="npc2" value="'. $lang['Adr_zone_npc_talk'] .'" class="mainoption" />' : $npc2_link = $lang['Adr_zone_npc_disable'];
( $zone_npc3 == '1' ) ? $npc3_link = '<input type="submit" name="npc3" value="'. $lang['Adr_zone_npc_talk'] .'" class="mainoption" />' : $npc3_link = $lang['Adr_zone_npc_disable'];
( $zone_npc4 == '1' ) ? $npc4_link = '<input type="submit" name="npc4" value="'. $lang['Adr_zone_npc_talk'] .'" class="mainoption" />' : $npc4_link = $lang['Adr_zone_npc_disable'];
( $zone_npc5 == '1' ) ? $npc5_link = '<input type="submit" name="npc5" value="'. $lang['Adr_zone_npc_talk'] .'" class="mainoption" />' : $npc5_link = $lang['Adr_zone_npc_disable'];
( $zone_npc6 == '1' ) ? $npc6_link = '<input type="submit" name="npc6" value="'. $lang['Adr_zone_npc_event'] .'" class="mainoption" />' : $npc6_link = $lang['Adr_zone_npc_disable'];

//NPC1
$npc1_action = $HTTP_POST_VARS['npc1'];

if ( $npc1_action )
{
	adr_substract_points( $user_id , $npc_price , adr_zones , '' );

	$message = '<img src="adr/images/zones/npc/npc1_enable.gif"><br \><br \>' . $npc1_message . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
	message_die(GENERAL_ERROR, $message , Zones , '' );
	break;
}

//NPC2
$npc2_action = $HTTP_POST_VARS['npc2'];

if ( $npc2_action )
{
	adr_substract_points( $user_id , $npc_price , adr_zones , '' );

	$message = '<img src="adr/images/zones/npc/npc2_enable.gif"><br \><br \>' . $npc2_message . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
	message_die(GENERAL_ERROR, $message , Zones , '' );
	break;
}

//NPC3
$npc3_action = $HTTP_POST_VARS['npc3'];

if ( $npc3_action )
{
	adr_substract_points( $user_id , $npc_price , adr_zones , '' );

	$message = '<img src="adr/images/zones/npc/npc3_enable.gif"><br \><br \>' . $npc3_message . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
	message_die(GENERAL_ERROR, $message , Zones , '' );
	break;
}

//NPC4
$npc4_action = $HTTP_POST_VARS['npc4'];

if ( $npc4_action )
{
	adr_substract_points( $user_id , $npc_price , adr_zones , '' );

	$message = '<img src="adr/images/zones/npc/npc4_enable.gif"><br \><br \>' . $npc4_message . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
	message_die(GENERAL_ERROR, $message , Zones , '' );
	break;
}

//NPC5
$npc5_action = $HTTP_POST_VARS['npc5'];

if ( $npc5_action )
{
	adr_substract_points( $user_id , $npc_price , adr_zones , '' );

	$message = '<img src="adr/images/zones/npc/npc5_enable.gif"><br \><br \>' . $npc5_message . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
	message_die(GENERAL_ERROR, $message , Zones , '' );
	break;
}

//NPC6
$npc6_action = $HTTP_POST_VARS['npc6'];

if ( $npc6_action )
{
	adr_substract_points( $user_id , $npc_price , adr_zones , '' );

	$message = '<img src="adr/images/zones/npc/npc6_enable.gif"><br \><br \>' . $npc6_message . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
	message_die(GENERAL_ERROR, $message , Zones , '' );
	break;
}

//
// END of NPCs Action
//


//
// BEGIN of zones seasons and weather
//

//Begin seasons
$actual_season = $board_config['adr_seasons'];

if ( $actual_season == '1' ) 
{
	$season_image = 'spring';
	$season_name = $lang['Adr_Zone_Season_1'];
}

if ( $actual_season == '2' ) 
{
	$season_image = 'summer';
	$season_name = $lang['Adr_Zone_Season_2'];
}

if ( $actual_season == '3' ) 
{
	$season_image = 'automn';
	$season_name = $lang['Adr_Zone_Season_3'];
}

if ( $actual_season == '4' ) 
{
	$season_image = 'winter';
	$season_name = $lang['Adr_Zone_Season_4'];
}

//Begin weather
$weather = $adr_user['character_weather'];

if ( $weather == '1' ) 
{
	$weather_image = 'sun';
	$weather_name = $lang['Adr_Zone_Weather_1'];
}

if ( $weather == '2' ) 
{
	$weather_image = 'night';
	$weather_name = $lang['Adr_Zone_Weather_2'];
}

if ( $weather == '3' ) 
{
	$weather_image = 'cloud';
	$weather_name = $lang['Adr_Zone_Weather_3'];
}

if ( $weather == '4' ) 
{
	$weather_image = 'rain';
	$weather_name = $lang['Adr_Zone_Weather_4'];
}

if ( $weather == '5' ) 
{
	$weather_image = 'cloudsun';
	$weather_name = $lang['Adr_Zone_Weather_5'];
}

if ( $weather == '6' ) 
{
	$weather_image = 'snow';
	$weather_name = $lang['Adr_Zone_Weather_6'];
}

//
// END of zones seasons and weather
//

//
// BEGIN of characters in zone
//

$sql = " SELECT * FROM  " . ADR_CHARACTERS_TABLE . "
      WHERE character_area = '$area_id'
	ORDER BY character_name ASC";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

while( $row = $db->sql_fetchrow($result)) 
	$users_connected_list.=' <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['character_id']) . '">' . $row['character_name'] . '</a> . ';

if ( !$users_connected_list) $users_connected_list = $lang['None'];

$users_connected_list = '<b><u>'. $lang['Adr_zone_connected']. '</u></b> : ' . $users_connected_list;

//
// END of characters in zone
//

// Building images


( $zone_temple == '1' ) ? $temple = 'temple_enable' : $temple = 'temple_disable';


( $zone_prison == '1' ) ? $prison = 'prison_enable' : $prison = 'prison_disable';


( $zone_shops == '1' ) ? $shops = 'shops_enable' : $shops = 'shops_disable';


( $zone_forge == '1' ) ? $forge = 'forge_enable' : $forge = 'forge_disable';
( $zone_mine == '1' ) ? $mine = 'mine_enable' : $mine = 'mine_disable';
( $zone_enchant == '1' ) ? $enchant = 'enchant_enable' : $enchant = 'enchant_disable';


( $zone_bank == '1' ) ? $bank = 'bank_enable' : $bank = 'bank_disable';





// Building links


( $zone_temple == '1' ) ? $temple_link = '<a href="'.append_sid("adr_temple.$phpEx").'">'. $lang['Adr_zone_goto_temple'] .'</a>' : $temple_link = $lang['Adr_zone_building_disable'];
( $zone_prison == '1' ) ? $prison_link = '<a href="'.append_sid("adr_courthouse.$phpEx").'">'. $lang['Adr_zone_goto_prison'] .'</a>' : $prison_link = $lang['Adr_zone_building_disable'];
( $zone_shops == '1' ) ? $shops_link = '<a href="'.append_sid("adr_shops.$phpEx").'">'. $lang['Adr_zone_goto_shops'] .'</a>' : $shops_link = $lang['Adr_zone_building_disable'];
( $zone_forge == '1' ) ? $forge_link = '<a href="'.append_sid("adr_forge.$phpEx").'">'. $lang['Adr_zone_goto_forge'] .'</a>' : $forge_link = $lang['Adr_zone_building_disable'];
( $zone_mine == '1' ) ? $mine_link = '<a href="'.append_sid("adr_mine.$phpEx").'">'. $lang['Adr_zone_goto_mine'] .'</a>' : $mine_link = $lang['Adr_zone_building_disable'];
( $zone_enchant == '1' ) ? $enchant_link = '<a href="'.append_sid("adr_enchant.$phpEx").'">'. $lang['Adr_zone_goto_enchant'] .'</a>' : $enchant_link = $lang['Adr_zone_building_disable'];
( $zone_bank == '1' ) ? $bank_link = '<a href="'.append_sid("adr_vault.$phpEx").'">'. $lang['Adr_zone_goto_bank'] .'</a>' : $bank_link = $lang['Adr_zone_building_disable'];


// Define user money
$points = $userdata['user_points'] . ' ' . $board_config['points_name'];
$zone_npc_price = $npc_price ? '<b><u>' . $lang['Adr_zone_npc_price'] . '</u> :</b> ' . $npc_price. ' ' . $board_config['points_name'] : '';

$template->assign_vars(array(
	'LANG' => $board_config['default_lang'],
	'POINTS' => $points,
	'ZONE_NPC_PRICE' => $zone_npc_price,
	'ZONE_NAME' => $zone_name,
	'ZONE_IMG' => $zone_img,
	'ZONE_DESCRIPTION' => $zone_desc,
	'ZONE_ELEMENT' => $zone_element,
	'ZONE_SEASON' => $actual_season,
	'ZONE_SEASON_NAME' => $season_name,
	'ZONE_SEASON_IMG' => $season_image,
	'ZONE_WEATHER_NAME' => $weather_name,
	'ZONE_WEATHER_IMG' => $weather_image,
	'ZONE_GOTO1' => $goto1_name,
	'ZONE_COST1' => $cost_goto1,
	'ZONE_GOTO2' => $goto2_name,
	'ZONE_COST2' => $cost_goto2,
	'ZONE_GOTO3' => $goto3_name,
	'ZONE_COST3' => $cost_goto3,
	'ZONE_GOTO4' => $goto4_name,
	'ZONE_COST4' => $cost_goto4,
	'ZONE_RETURN' => $return_name,
	'ZONE_COST_RETURN' => $cost_return,
	'USERS_CONNECTED_LIST' => $users_connected_list,
	'SHOPS_IMG' => $shops,
	'TEMPLE_IMG' => $temple,
	'FORGE_IMG' => $forge,
	'MINE_IMG' => $mine,
	'ENCHANT_IMG' => $enchant,
	'BANK_IMG' => $bank,
	'PRISON_IMG' => $prison,
	'SHOPS_LINK' => $shops_link,
	'TEMPLE_LINK' => $temple_link,
	'FORGE_LINK' => $forge_link,
	'MINE_LINK' => $mine_link,
	'ENCHANT_LINK' => $enchant_link,
	'BANK_LINK' => $bank_link,
	'PRISON_LINK' => $prison_link,
	'NPC1_IMG' => $npc1,
	'NPC2_IMG' => $npc2,
	'NPC3_IMG' => $npc3,
	'NPC4_IMG' => $npc4,
	'NPC5_IMG' => $npc5,
	'NPC6_IMG' => $npc6,
	'NPC1_LINK' => $npc1_link,
	'NPC2_LINK' => $npc2_link,
	'NPC3_LINK' => $npc3_link,
	'NPC4_LINK' => $npc4_link,
	'NPC5_LINK' => $npc5_link,
	'NPC6_LINK' => $npc6_link,
	'L_TEMPLE_NAME' => $lang['Adr_zone_goto_temple'],
	'L_FORGE_NAME' => $lang['Adr_zone_goto_forge'],
	'L_MINE_NAME' => $lang['Adr_zone_goto_mine'],
	'L_ENCHANT_NAME' => $lang['Adr_zone_goto_enchant'],
	'L_SHOPS_NAME' => $lang['Adr_zone_goto_shops'],
	'L_PRISON_NAME' => $lang['Adr_zone_goto_prison'],
	'L_BANK_NAME' => $lang['Adr_zone_goto_bank'],
	'L_NPC1_NAME' => $lang['Adr_zone_npc1_name'],
	'L_NPC2_NAME' => $lang['Adr_zone_npc2_name'],
	'L_NPC3_NAME' => $lang['Adr_zone_npc3_name'],
	'L_NPC4_NAME' => $lang['Adr_zone_npc4_name'],
	'L_NPC5_NAME' => $lang['Adr_zone_npc5_name'],
	'L_NPC6_NAME' => $lang['Adr_zone_npc6_name'],
	'L_ZONE_NPC' => $lang['Adr_zone_npc_title'],
	'L_ZONE_BUILDINGS' => $lang['Adr_zone_buildings_title'],
	'L_ZONE_ACTION' => $lang['Adr_zone_action_title'],
	'L_ZONE_CONNECTED' => $lang['Adr_zone_connected_title'],
	'L_ZONE_DESCRIPTION' => $lang['Adr_zone_description_title'],
	'L_ZONE_ELEMENT' => $lang['Adr_zone_element_title'],
	'L_ZONE_SEASON' => $lang['Adr_zone_season_title'],
	'L_ZONE_WEATHER' => $lang['Adr_zone_weather_title'],
	'L_ZONE_GOTO' => $lang['Adr_zone_goto_title'],
	'L_ZONE_GOTO1' => $lang['Adr_zone_goto1_title'],
	'L_ZONE_GOTO2' => $lang['Adr_zone_goto2_title'],
	'L_ZONE_GOTO3' => $lang['Adr_zone_goto3_title'],
	'L_ZONE_GOTO4' => $lang['Adr_zone_goto4_title'],
	'L_ZONE_RETURN' => $lang['Adr_zone_return_title'],
	'L_ZONE_COST' => $lang['Adr_zone_cost_title'],
	'L_ZONE_TOWN' => $lang['Adr_zone_town_title'],
	'L_ZONE_BATTLE' => $lang['Adr_zone_battle_title'],
	'L_ZONE_SHOUTBOX' => $lang['Adr_zone_other_title'],
	'L_BATTLE' => $lang['Adr_zone_battle'],
	'L_PVP_BATTLE' => $lang['Adr_zone_pvp_battle'],
	'L_GOTO' => $lang['Adr_zone_goto'],
	'L_POINTS' => $lang['Adr_zone_points'],
	'U_ZONE_GUILD' => append_sid("adr_guilds.$phpEx"),
	'U_ZONE_ANIMALERY' => append_sid("rabbitoshi.$phpEx"),
	'U_ZONE_AUTEL' => append_sid("adr_cauldron.$phpEx"),
	'U_ZONE_BARRACK' => append_sid("adr_town.$phpEx"),
	'U_ZONE_WORKSHOP' => append_sid("adr_jobs.$phpEx"),
	'U_ZONE_HOUSE' => append_sid("adr_house.$phpEx"),
	'U_ZONE_LIBRARY' => append_sid("adr_library.$phpEx"),
	'U_ZONE_TOWER' => append_sid("adr_tower.$phpEx"),
	'U_ZONE_BATTLE' => append_sid("adr_battle.$phpEx"),
	'U_ZONE_PVP_BATTLE' => append_sid("adr_battle_pvp.$phpEx"),
	'S_ZONES_ACTION' => append_sid("adr_zones.$phpEx"),
));

$template->pparse('body');

include_once($phpbb_root_path . 'adr_battle_community.'.$phpEx);
include_once($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>