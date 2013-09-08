<?php
/***************************************************************************
 *				  adr_maps_teleport.php
 *				------------------------
 *	begin 		    : 06/12/2005
 *	copyright		: Ozzie
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
define('IN_ADR', true);
define('IN_ADR_ZONES', true);
define('IN_ADR_CAULDRON', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_TOWN', true);
$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
include_once($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/lang_adr.'.$phpEx);
$loc = 'town';
$sub_loc = 'adr_TownMap';

//
// Start session management
$userdata = session_pagestart($user_ip, $lang['Adr_zone_maps_adr_map_popup_title']);
init_userprefs($userdata);
// End session management
//

$user_id = $userdata['user_id'];

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_maps.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}
adr_template_file('adr_maps_teleport_body.tpl');
$page_title = $lang['Adr_zone_maps_adr_map_popup_title'];
$gen_simple_header = TRUE;
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
// Get the general config and character infos
$adr_general = adr_get_general_config();
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
$adr_user = adr_get_user_infos($user_id);

if ( isset($HTTP_GET_VARS['zone']) || isset($HTTP_POST_VARS['zone']) )
{
	$dest_zone = ( isset($HTTP_POST_VARS['zone']) ) ? htmlspecialchars($HTTP_POST_VARS['zone']) : htmlspecialchars($HTTP_GET_VARS['zone']);
}
else
{
	$dest_zone = $teleport_zone;
}
if ( isset($HTTP_GET_VARS['teleport']) || isset($HTTP_POST_VARS['teleport']) )
{
	$teleport = ( isset($HTTP_POST_VARS['teleport']) ) ? htmlspecialchars($HTTP_POST_VARS['teleport']) : htmlspecialchars($HTTP_GET_VARS['teleport']);
}
$teleported = $HTTP_POST_VARS['teleported'];

// Get Zone infos
$current_zone = $adr_user['character_area'];


$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_name = '$dest_zone' ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, $lang['Adr_zone_maps_error_message_4'], '', __LINE__, __FILE__, $sql);

$destination_zone = $db->sql_fetchrow($result);
$destination_zone_name = $destination_zone['zone_name'];
$destination_zone_id = $destination_zone['zone_id'];
$destination_zone_img = $destination_zone['zone_img'];
$destination_zone_desc = $destination_zone['zone_desc'];
$destination_zone_element = $destination_zone['zone_element'];
$destination_cost_goto1 = $destination_zone['cost_goto1'];
$destination_cost_goto2 = $destination_zone['cost_goto2'];
$destination_cost_goto3 = $destination_zone['cost_goto3'];
$destination_cost_goto4 = $destination_zone['cost_goto4'];
$destination_cost_return = $destination_zone['cost_return'];
$destination_goto1_name = $destination_zone['goto1_name'];
$destination_goto2_name = $destination_zone['goto2_name'];
$destination_goto3_name = $destination_zone['goto3_name'];
$destination_goto4_name = $destination_zone['goto4_name'];
$destination_return_name = $destination_zone['return_name'];
$destination_event_1 = $destination_zone['zone_event1'];
$destination_event_2 = $destination_zone['zone_event2'];
$destination_event_3 = $destination_zone['zone_event3'];
$destination_event_4 = $destination_zone['zone_event4'];
$destination_event_5 = $destination_zone['zone_event5'];
$destination_event_6 = $destination_zone['zone_event6'];
$destination_event_7 = $destination_zone['zone_event7'];
$destination_event_8 = $destination_zone['zone_event8'];
$destination_zone_pointwin1 = $destination_zone['zone_pointwin1'];
$destination_zone_pointwin2 = $destination_zone['zone_pointwin2'];
$destination_zone_pointloss1 = $destination_zone['zone_pointloss1'];
$destination_zone_pointloss2 = $destination_zone['zone_pointloss2'];
$destination_zone_chance = $destination_zone['zone_chance'];
$destination_required_item = $destination_zone['zone_item'];
$destination_return_cost = $destination_zone['cost_return'];

if ( $destination_zone['zone_shops'] > 0 ){ $map_shops = $lang['Adr_zone_maps_yes']; }else{ $map_shops = $lang['Adr_zone_maps_no'];}
if ( $destination_zone['zone_forge'] > 0 ){ $map_forge = $lang['Adr_zone_maps_yes']; }else{ $map_forge = $lang['Adr_zone_maps_no'];}
if ( $destination_zone['zone_temple'] > 0 ){ $map_temple = $lang['Adr_zone_maps_yes']; }else{ $map_temple = $lang['Adr_zone_maps_no'];}
if ( $destination_zone['zone_prison'] > 0 ){ $map_prison = $lang['Adr_zone_maps_yes']; }else{ $map_prison = $lang['Adr_zone_maps_no'];}
if ( $destination_zone['zone_bank'] > 0 ){ $map_bank = $lang['Adr_zone_maps_yes']; }else{ $map_bank = $lang['Adr_zone_maps_no'];}

// Check if user has the required item
$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
	WHERE item_name = '$destination_required_item'
   	AND item_owner_id = '$user_id'
   	AND item_in_shop = '0'
	AND item_duration > 0
   	AND item_in_warehouse = '0' ";
$result = $db->sql_query($sql);
if( !$result )
	message_die(GENERAL_ERROR, $lang['Adr_zone_maps_error_message_5'], "", __LINE__, __FILE__, $sql);

$item_check = $db->sql_fetchrow($result);

if ( ( $destination_required_item == '0' ) || ( $destination_required_item == $item_check['item_name'] ) ){ $destination_zone_required_item = 1; }else{ $destination_zone_required_item = 0; }

if ( $userdata['user_points'] > $destination_return_cost ){ $destination_zone_return_cost = 1; }else{ $destination_zone_return_cost = 0; }

// Check if user has a Teleport Scroll
$scroll = 'Adr_items_scroll_5';
$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
	WHERE item_name = '$scroll'
   	AND item_owner_id = '$user_id'
   	AND item_in_shop = '0'
	AND item_duration > 0
   	AND item_in_warehouse = '0' ";
$result = $db->sql_query($sql);
if( !$result )
	message_die(GENERAL_ERROR, $lang['Adr_zone_maps_error_message_5'], "", __LINE__, __FILE__, $sql);

$scroll_check = $db->sql_fetchrow($result);
$scroll_item_id = $scroll_check['item_id'];
$scroll_item_duration = $scroll_check['item_duration'];

if ( $scroll == $scroll_check['item_name'] ){ $destination_zone_required_scroll = 1; }else{ $destination_zone_required_scroll = 0; }

if ( $destination_zone_id == $adr_user['character_area'] )
{
	$teleport_enable = 0;
	$teleport_welcome = sprintf( $lang['Adr_zone_maps_teleport_welcome'] ,$destination_zone_name );
	$template->assign_block_vars('switch_Adr_zone_teleport_welcome',array());
}
else
{
	$teleport_enable = 1;
	$template->assign_block_vars('switch_Adr_zone_teleport_no_welcome',array());
}
//Can the player teleport
if ( $destination_zone_required_item && $destination_zone_return_cost && $destination_zone_required_scroll && $teleport_enable )
{
	$template->assign_block_vars('switch_Adr_zone_teleport_enable',array());
}
//Display Required Items?
if ( $board_config['Adr_zone_townmap_display_required'] )
{
	$template->assign_block_vars('switch_Adr_zone_townmap_display_required',array());
}
//Change Item to No Item if no item is required
if ( $destination_required_item == '0' )
{
	$destination_required_item_text = $lang['Adr_zone_maps_item_nothing'];
}
else
{
	$destination_required_item_text = $destination_required_item;
}

//teleport the player
if ( $destination_zone_required_item && $destination_zone_return_cost && $destination_zone_required_scroll && $teleport == $lang['Adr_zone_maps_teleport_to_zone'] )
{
		adr_substract_points( $user_id , $cost_return , adr_zones , '' );
        $new_scroll_item_duration = $scroll_item_duration - 1;
		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . "
			SET character_area = '$destination_zone_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);
		$sql = " UPDATE  " . ADR_SHOPS_ITEMS_TABLE . "
			SET item_duration = '$new_scroll_item_duration'
			WHERE item_id = '$scroll_item_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, $lang['Adr_zone_maps_error_message_6'], '', __LINE__, __FILE__, $sql);
			// Delete broken items from users inventory
		if ( $new_scroll_item_duration < 1 )
		{
			$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_duration < 1
   				AND item_in_shop = '0'
				AND item_in_warehouse = '0'
				AND item_owner_id = $user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, $lang['Adr_zone_maps_error_message_7'], '', __LINE__, __FILE__, $sql);
			}
		}
		$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       		WHERE zone_id = '$destination_zone_id' ";
		if( !($result = $db->sql_query($sql)) )
        	message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);
		$teleport_destination_zone = $db->sql_fetchrow($result);
		$teleported = 1;
		$teleport_zone = 'zone='.$teleport_destination_zone['zone_name'];

		adr_previous( Adr_zone_change_success , adr_maps_teleport , $teleport_zone );
		break;
}


$template->assign_vars(array(
	'POINTS' => $board_config['points_name'],
	'ZONE_NAME' => $destination_zone_name,
	'ZONE_IMG' => $destination_zone_img,
	'ZONE_DESCRIPTION' => $destination_zone_desc,
	'ZONE_ELEMENT' => $destination_zone_element,
	'ZONE_RETURN' => $destination_return_name,
	'ZONE_COST_RETURN' => $destination_cost_return,
	'ZONE_REQUIRED_ITEM' => $destination_required_item_text,
	'MAP_SHOPS' => $map_shops,
	'MAP_FORGE' => $map_forge,
	'MAP_TEMPLE' => $map_temple,
	'MAP_PRISON' => $map_prison,
	'MAP_BANK' => $map_bank,
	'WELCOME' => $teleport_welcome,
	'L_MAP_TELEPORT' => $lang['Adr_zone_maps_teleport_to_zone'],
	'L_MAP_CLOSE_WINDOW' => $lang['Adr_zone_maps_close_window'],
	'L_MAP_SHOPS' => $lang['Adr_zone_goto_shops'],
	'L_MAP_FORGE' => $lang['Adr_zone_goto_forge'],
	'L_MAP_TEMPLE' => $lang['Adr_zone_goto_temple'],
	'L_MAP_PRISON' => $lang['Adr_zone_goto_prison'],
	'L_MAP_BANK' => $lang['Adr_zone_goto_bank'],
	'L_ZONE_DESCRIPTION' => $lang['Adr_zone_description_title'],
	'L_ZONE_ELEMENT' => $lang['Adr_zone_element_title'],
	'L_ZONE_COST' => $lang['Adr_zone_cost_title'],
	'L_ZONE_REQUIRED_ITEM' => $lang['Adr_Zone_maps_item_title'],
	'L_ZONE_TOWN' => $lang['Adr_zone_town_title'],
	'L_POINTS' => $lang['Adr_zone_points'],
	'S_TELEPORT_ACTION' => append_sid("adr_maps_teleport.$phpEx"),
));


$template->pparse('body');
?>
