<?php
/***************************************************************************
*                          	  adr_cauldron.php
*                              -------------------
*     begin                : 07/02/2005
*     copyright            : One_Piece
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
define('IN_ADR_CAULDRON', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

$user_id = $userdata['user_id'];

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_cauldron.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Get the general settings
$adr_general = adr_get_general_config();
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

// Deny access if the user is into a battle
$sql = "SELECT * 
		FROM  ". ADR_BATTLE_LIST_TABLE ." 
		WHERE battle_challenger_id = '$user_id'
		AND battle_result = '0'
		AND battle_type = '1'";
	if( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);

$bat = $db->sql_fetchrow($result);

if (is_numeric($bat['battle_id']))
	adr_previous( Adr_battle_progress , adr_battle , '' );

include($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/lang_adr.'.$phpEx);

$zone_user = adr_get_user_infos($user_id);
$actual_zone = $zone_user['character_area'];

$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_id = $actual_zone ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$info = $db->sql_fetchrow($result);
$access = $info['zone_cauldron'];

if ( $access == '0' )
	adr_previous( Adr_zone_building_noaccess , adr_zones , '' );
//
//Begin Item Choice List
//

//Fix item value
$first_item 	= intval($HTTP_POST_VARS['item1']);
$second_item 	= intval($HTTP_POST_VARS['item2']);
$third_item 	= intval($HTTP_POST_VARS['item3']);

// Show item1 list
$q = "SELECT * 
	  FROM " . ADR_SHOPS_ITEMS_TABLE . "
	  WHERE item_owner_id = '". $user_id ."'";
if (!$r = $db->sql_query($q))
	message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $q);

$item_data = $db->sql_fetchrowset($r);

$item1_list 	= '<select name="item1">';
$item1_list 	.= '<option selected value="" class="post">'. $lang['Adr_item_choose_item'] .'</option>';
for ($i = 0; $i < count($item_data); $i++)
	$item1_list .= '<option value = "'. $item_data[$i]['item_id'] .'" class="post">' . $item_data[$i]['item_name'] . '&nbsp;('. $item_data[$i]['item_id'] . ')</option>';
$item1_list 	.= '</select>';

// Show item2 list
$item2_list 	= '<select name="item2">';
$item2_list 	.= '<option selected value="" class="post">'. $lang['Adr_item_choose_item'] .'</option>';
for ($i = 0; $i < count($item_data); $i++)
	$item2_list .= '<option value = "'. $item_data[$i]['item_id'] .'" class="post">' . $item_data[$i]['item_name'] . '&nbsp;('. $item_data[$i]['item_id'] . ')</option>';
$item2_list 	.= '</select>';

// Show item3 list
$item3_list 	= '<select name="item3">';
$item3_list 	.= '<option selected value="" class="post">'. $lang['Adr_item_choose_item'] .'</option>';
for ($i = 0; $i < count($item_data); $i++)
	$item3_list .= '<option value = "'. $item_data[$i]['item_id'] .'" class="post">' . $item_data[$i]['item_name'] . '&nbsp;('. $item_data[$i]['item_id'] . ')</option>';
$item3_list 	.= '</select>';

//	
//END Item Choice List
//

//Begin Combine
if (isset($HTTP_POST_VARS['mode']))
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

		case "combine":

			include($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/lang_adr.'.$phpEx);

			//Verify empty fields
			if ( $first_item == '0' || $second_item == '0' || $third_item == '0' )
			{
				$message = '' . $lang['Adr_cauldron_item_empty'] . '<br \><br \>' . $lang['Adr_zone_return_cauldron'] . '<br \><br \>';
				message_die(GENERAL_ERROR, $message , Message , '' );
			}

			// V:
			// Okay. Take a deep breath.
			// I have no idea who coded this. But it's terrible code.
			// How the fuck did that ever work. I have no idea.
			// I'll fix it up a bit... But goddamn, that's bad code
			//
			// The lines below (search name of the items etc)
			// should probably use the adr functions to give/remove items
			// but i don't know them enough, i'm afraid :/

			//Verify if user have enough item if he use same items
			if ( $second_item == $first_item && $third_item == $second_item )
			{
					$message = '' . $lang['Adr_item_quantity_failed'] . '<br \><br \>' . $lang['Adr_zone_return_cauldron'] . '<br \><br \>';
					message_die(GENERAL_ERROR, $message , Message , '' );
			}
			if ( $second_item == $first_item )
			{
					$message = '' . $lang['Adr_item_quantity_failed'] . '<br \><br \>' . $lang['Adr_zone_return_cauldron'] . '<br \><br \>';
					message_die(GENERAL_ERROR, $message , Message , '' );
			}
			if ( $third_item == $first_item )
			{
					$message = '' . $lang['Adr_item_quantity_failed'] . '<br \><br \>' . $lang['Adr_zone_return_cauldron'] . '<br \><br \>';
					message_die(GENERAL_ERROR, $message , Message , '' );
			}
			if ( $third_item == $second_item )
			{
					$message = '' . $lang['Adr_item_quantity_failed'] . '<br \><br \>' . $lang['Adr_zone_return_cauldron'] . '<br \><br \>';
					message_die(GENERAL_ERROR, $message , Message , '' );
			}

			//Update user inventory
			// V: just use a fucking WHERE IN()
			$asql = "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_owner_id = '$user_id'
					AND item_id IN($first_item, $second_item, $third_item)";
			if( !($aresult = $db->sql_query($asql)) )
				message_die(GENERAL_ERROR, "Couldn't update inventory info", "", __LINE__, __FILE__, $asql);

			//Verify if the combination match to a pack
			// V: use fucking IDs
			$sql = "SELECT * 
				FROM " . ADR_CAULDRON_TABLE . "
				WHERE item1_id = '$first_item'
				AND item2_id = '$second_item'
				AND item3_id = '$third_item'";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);
			$pack_exist = $db->sql_fetchrow($result);
			$pack_verify = $pack_exist['itemwin_id'];	

			if ( !$pack_exist ) 
			{	
				$message = '' . $lang['Adr_item_combine_failed'] . '<br \><br \>' . $lang['Adr_zone_return_cauldron'] . '<br \><br \>';
				message_die(GENERAL_ERROR, $message , Message , '' );
			}
			else
			{
        $added_item = adr_add_item_to($pack_verify, $user_id);

				$message = '' . $lang['Adr_item_combine_success'] . '<br \><br \>' . $added_item['item_name'] . '<br \><br \><img src="adr/images/items/' . $added_item['item_icon'] . '"><br \><br \>' . $added_item['item_desc'] . '<br \><br \>' . $lang['Adr_zone_return_cauldron'] . '<br \><br \>';
				message_die(GENERAL_ERROR, $message , Message , '' );
				break;	
			}
	}
}
//End Combine

//
//Cauldron Main Page
//

include($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/lang_adr.'.$phpEx);

adr_template_file('adr_cauldron_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$s_hidden_fields = '<input type="hidden" name="mode" value="combine" />';

$template->assign_vars(array(
	"ITEM1" => $item1_list,
	"ITEM2" => $item2_list,
	"ITEM3" => $item3_list,
	"L_CAULDRON_TITLE" => $lang['Adr_cauldron_title'],
	"L_CAULDRON_EXPLAIN" => $lang['Adr_cauldron_explain'],
	"L_ITEM1_TITLE" => $lang['Adr_cauldron_item1'],
	"L_ITEM2_TITLE" => $lang['Adr_cauldron_item2'],
	"L_ITEM3_TITLE" => $lang['Adr_cauldron_item3'],
	"L_SUBMIT" => $lang['Adr_cauldron_combine'],
	"S_HIDDEN_FIELDS" => $s_hidden_fields,
	"S_CAULDRON_ACTION" => append_sid("adr_cauldron.$phpEx")) 
);

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse("body");
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
