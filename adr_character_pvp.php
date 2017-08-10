<?php 
/***************************************************************************
 *					adr_character_pvp.php
 *				------------------------
 *	begin 			: 30/03/2004
 *	copyright		: Malicious Rabbit / Dr DLP
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
define('IN_ADR_BATTLE', true);
define('IN_ADR_PVP', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'battle_community';
$sub_loc = 'adr_character_pvp';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_functions_armour_sets.'.$phpEx);
$user_id = $userdata['user_id'];

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character_pvp.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// have the mail sender infos
$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
$script_name = ( $script_name != '' ) ? $script_name . '/adr_character_pvp.'.$phpEx.'?mode=waiting' : 'adr_character_pvp.'.$phpEx;
$server_name = trim($board_config['server_name']);
$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';

adr_template_file('adr_battle_pvp_list_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
$adr_user = adr_get_user_infos($user_id);

if ( !$adr_general['battle_pvp_enable'] ) 
{	
	adr_previous ( Adr_pvp_disabled , adr_character , '' );
}

// Deny access if user is imprisioned
if($userdata['user_cell_time']){
	adr_previous(Adr_shops_no_thief, adr_cell, '');}

if ( (!( isset($HTTP_POST_VARS[POST_USERS_URL]) || isset($HTTP_GET_VARS[POST_USERS_URL]))) || ( empty($HTTP_POST_VARS[POST_USERS_URL]) && empty($HTTP_GET_VARS[POST_USERS_URL])))
{ 
	$view_userdata = $userdata; 
} 
else 
{ 
	$view_userdata = get_userdata(intval($HTTP_GET_VARS[POST_USERS_URL])); 
} 
$searchid = $view_userdata['user_id'];

if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);	
}
else
{
	$mode = "";
}

$defy_action = isset($HTTP_POST_VARS['defy']);
$accept_action = isset($HTTP_POST_VARS['accept_action']);

// Now we define some strange cases
$mode = ( $defy_action ) ? 'defy_action' : $mode;
$mode = ( $accept_action ) ? 'accept_action' : $mode;
$mode = ( $mode == 'current' ) ? '' : $mode;
### START restriction checks ###
$item_sql = adr_make_restrict_sql($adr_user);
### END restriction checks ###

if ( $mode != "" )
{
	switch($mode)
	{
		case 'accept' :

			$battle_id = intval($HTTP_GET_VARS['battle_id']);

			$template->assign_block_vars('equip',array());
			$template->assign_block_vars('equip.accept',array());

			// Be sure the user is 	live before beginning the battle
			$char = adr_get_user_infos($user_id);
			if ( $char['character_hp'] < 1 )
			{
				$message = $lang['Adr_battle_character_dead'];
				$message .= '<br /><br />'.sprintf($lang['Adr_battle_temple'] ,"<a href=\"" . 'adr_temple.'.$phpEx . "\">", "</a>") ;
				$message .= '<br /><br />'.sprintf($lang['Adr_character_return'] ,"<a href=\"" . 'adr_character.'.$phpEx . "\">", "</a>") ;
				message_die ( GENERAL_MESSAGE , $message );
			}

			// First select the available items
			$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_in_shop = 0 
				AND item_duration > 0
				$item_sql
			AND item_owner_id = $user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$items = $db->sql_fetchrowset($result);

			// Prepare the items list
			$armor_list = '<select name="item_armor">';
			$armor_list .= '<option value = "0" >' . $lang['Adr_battle_no_armor'] . '</option>';
			$buckler_list = '<select name="item_buckler">';
			$buckler_list .= '<option value = "0" >' . $lang['Adr_battle_no_buckler'] . '</option>';
			$helm_list = '<select name="item_helm">';
			$helm_list .= '<option value = "0" >' . $lang['Adr_battle_no_helm'] . '</option>';
			$greave_list = '<select name="item_greave">';
			$greave_list .= '<option value = "0" >' . $lang['Adr_battle_no_greave'] . '</option>';



			$boot_list = '<select name="item_boot">';
			$boot_list .= '<option value = "0" >' . $lang['Adr_battle_no_boot'] . '</option>';



			$gloves_list = '<select name="item_gloves">';
			$gloves_list .= '<option value = "0" >' . $lang['Adr_battle_no_gloves'] . '</option>';
			$amulet_list = '<select name="item_amulet">';
			$amulet_list .= '<option value = "0" >' . $lang['Adr_battle_no_amulet'] . '</option>';
			$ring_list = '<select name="item_ring">';
			$ring_list .= '<option value = "0" >' . $lang['Adr_battle_no_ring'] . '</option>';
			$equip_armor = $char['equip_armor'];
			$equip_buckler = $char['equip_buckler'];
			$equip_helm = $char['equip_helm'];



			$equip_greave = $char['equip_greave'];
			$equip_boot = $char['equip_boot'];

			$equip_gloves = $char['equip_gloves'];
			$equip_amulet = $char['equip_amulet'];
			$equip_ring = $char['equip_ring'];

			for ( $i = 0 ; $i < count($items) ; $i ++ )
			{
				$item_power = $items[$i]['item_power'] + $items[$i]['item_add_power'];

				if ( $items[$i]['item_type_use'] == 7 )
				{
					$armor_selected = ( $equip_armor == $items[$i]['item_id'] ) ? 'selected' : '';
					$armor_list .= '<option value = "'.$items[$i]['item_id'].'" '.$armor_selected.' >' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $items[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
				if ( $items[$i]['item_type_use'] == 8 )
				{
					$buckler_selected = ( $equip_buckler == $items[$i]['item_id'] ) ? 'selected' : '';
					$buckler_list .= '<option value = "'.$items[$i]['item_id'].'" '.$buckler_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $items[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
				if ( $items[$i]['item_type_use'] == 9 )
				{
					$helm_selected = ( $equip_helm == $items[$i]['item_id'] ) ? 'selected' : '';
					$helm_list .= '<option value = "'.$items[$i]['item_id'].'" '.$helm_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $items[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}



				if ( $items[$i]['item_type_use'] == 29 )
				{
					$greave_selected = ( $equip_greave == $items[$i]['item_id'] ) ? 'selected' : '';
					$greave_list .= '<option value = "'.$items[$i]['item_id'].'" '.$greave_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $items[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
				if ( $items[$i]['item_type_use'] == 30 )
				{
					$boot_selected = ( $equip_boot == $items[$i]['item_id'] ) ? 'selected' : '';
					$boot_list .= '<option value = "'.$items[$i]['item_id'].'" '.$boot_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $items[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}

				if ( $items[$i]['item_type_use'] == 10 )
				{
					$gloves_selected = ( $equip_gloves == $items[$i]['item_id'] ) ? 'selected' : '';
					$gloves_list .= '<option value = "'.$items[$i]['item_id'].'" '.$gloves_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $items[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
				if ( $items[$i]['item_type_use'] == 13 )
				{
					$amulet_selected = ( $equip_amulet == $items[$i]['item_id'] ) ? 'selected' : '';
					$amulet_list .= '<option value = "'.$items[$i]['item_id'].'" '.$amulet_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $items[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
				if ( $items[$i]['item_type_use'] == 14 )
				{
					$ring_selected = ( $equip_ring == $items[$i]['item_id'] ) ? 'selected' : '';
					$ring_list .= '<option value = "'.$items[$i]['item_id'].'" '.$ring_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $items[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
			}

			$armor_list .= '</select>';
			$buckler_list .= '</select>';
			$helm_list .= '</select>';



			$greave_list .= '</select>';
			$boot_list .= '</select>';

			$gloves_list .= '</select>';
			$amulet_list .= '</select>';
			$ring_list .= '</select>';

			$template->assign_vars(array(
				'BATTLE_ID' => $battle_id,
				'SELECT_ARMOR'  => $armor_list,
				'SELECT_BUCKLER' => $buckler_list,
				'SELECT_HELM' => $helm_list,
				'SELECT_GREAVE' => $greave_list,
				'SELECT_BOOT' => $boot_list,
				'SELECT_GLOVES' => $gloves_list,
				'SELECT_AMULET' => $amulet_list,
				'SELECT_RING' => $ring_list, 
				"L_ACCEPT_DEFY" => $lang['Adr_pvp_defy_accept'],
				'L_EQUIPMENT' => $lang['Adr_battle_equipment'],
				'L_SELECT_ARMOR'  => $lang['Adr_battle_select_armor'],
				'L_SELECT_BUCKLER' => $lang['Adr_battle_select_buckler'],
				'L_SELECT_HELM' => $lang['Adr_battle_select_helm'],
				'L_SELECT_GREAVE' => $lang['Adr_battle_select_greave'],
				'L_SELECT_BOOT' => $lang['Adr_battle_select_boot'],
				'L_SELECT_GLOVES' => $lang['Adr_battle_select_gloves'],
				'L_SELECT_AMULET' => $lang['Adr_battle_select_amulet'],
				'L_SELECT_RING' => $lang['Adr_battle_select_ring'],
			));

			break;

		case 'accept_action' :

			$battle_id = intval($HTTP_POST_VARS['battle_id']);
	
			// Fix the items ids
			$armor = intval($HTTP_POST_VARS['item_armor']);
			$buckler = intval($HTTP_POST_VARS['item_buckler']);
			$helm = intval($HTTP_POST_VARS['item_helm']);



			$greave = intval($HTTP_POST_VARS['item_greave']);
			$boot = intval($HTTP_POST_VARS['item_boot']);

			$gloves = intval($HTTP_POST_VARS['item_gloves']);
			$amulet = intval($HTTP_POST_VARS['item_amulet']);
			$ring = intval($HTTP_POST_VARS['item_ring']);

			// Get the user infos
			$char = adr_get_user_infos($user_id);

			// Be sure he has a character 
			if ( !(is_numeric($char['character_id'])))
			{
				adr_previous( Adr_your_character_lack , adr_character , '' );
			}

			// Calculate the base stats
			$hp = $char['character_hp'];
			$mp = $char['character_mp'];
			$hp_max = $char['character_hp_max'];
			$mp_max = $char['character_mp_max'];
			$hp_regen = 0;
			$mp_regen = 0;
			$elemental = $char['character_element'];

			// Firstly, create the users' phyisial attack and magic attack stats
			$att = adr_battle_make_att($char['character_might'], $char['character_dexterity']);
			$ma = adr_battle_make_magic_att($char['character_intelligence']);
			$def = adr_battle_make_def($char['character_ac'], $char['character_dexterity']);
			$md = adr_battle_make_magic_def($char['character_wisdom']);

			if ( $armor )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $armor ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				adr_use_item($armor , $user_id);
				$armour_name = adr_get_lang($item['item_name']);
			}

			if ( $buckler )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $buckler ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				adr_use_item($buckler, $user_id);
				$buckler_name = adr_get_lang($item['item_name']);
			}

			if ( $gloves )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id
					$item_sql
					AND item_id = $gloves ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				adr_use_item($gloves, $user_id);
				$gloves_name = adr_get_lang($item['item_name']);
			}

			if ( $helm )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $helm ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				adr_use_item($helm, $user_id);
				$helm_name = adr_get_lang($item['item_name']);
			}

			if ( $greave )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $greave ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				adr_use_item($greave, $user_id);
				$greave_name = adr_get_lang($item['item_name']);
			}

			if ( $boot )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $boot ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				adr_use_item($boot, $user_id);
				$boot_name = adr_get_lang($item['item_name']);
			}

			// Now we modify mp and hp regeneration with amulets and rings
			if ( $amulet )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $amulet ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$hp_regen = $hp_regen + $item['item_power'];

				adr_use_item($amulet, $user_id);
				$amulet_name = adr_get_lang($item['item_name']);
			}

			if ( $ring )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $ring ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$mp_regen = $mp_regen + $item['item_power'];

				adr_use_item($ring, $user_id);
				$ring_name = adr_get_lang($item['item_name']);
			}

			// Now update the database
			$sql = " UPDATE " . ADR_BATTLE_PVP_TABLE . "
				SET battle_opponent_att = $att, 
					battle_opponent_def = $def,
					battle_opponent_magic_attack = $ma,
					battle_opponent_magic_resistance = $md, 
					battle_opponent_hp = $hp, 
					battle_opponent_mp = $mp, 
					battle_opponent_hp_max = $hp_max, 
					battle_opponent_mp_max = $mp_max, 
					battle_opponent_hp_regen = $hp_regen, 
					battle_opponent_mp_regen = $mp_regen,
					battle_opponent_element = $elemental,
					battle_turn = " . $user_id . ",
					battle_result = 3
				WHERE battle_id = $battle_id
				AND battle_opponent_id = $user_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new battle", "", __LINE__, __FILE__, $sql);
			}

			$sql = " SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE battle_result = 3
				AND battle_id = $battle_id
				AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			// Get the "other" id
			$other_id = ( $row['battle_opponent_id'] != $user_id ) ? intval($row['battle_opponent_id']) : intval($row['battle_challenger_id']);
			// Get opponent's character name name
			$ssql = "SELECT character_name FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = '$other_id'";
			if(!($sresult = $db->sql_query($ssql))){
				message_die(GENERAL_ERROR, 'Could not query character name', '', __LINE__, __FILE__, $ssql);}
			$opponent = $db->sql_fetchrow($sresult);
			$opponent_name = $opponent['character_name'];

			$sql = " SELECT prefs_pvp_notif_pm FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = $other_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't query preferences", "", __LINE__, __FILE__, $sql);
			}
			$opponent = $db->sql_fetchrow($result);

			$subject = $lang['Adr_pvp_accepted'];
			$message = sprintf($lang['Adr_pvp_accepted_by'] , $adr_user['character_name']);
			
			if ( $opponent['prefs_pvp_notif_pm'] )
			{
				adr_send_pm ( $other_id , $subject  , $message );
			}

         // Auto-redirect straight to PvP battle
//       header('Location: ' . append_sid("adr_battle_pvp.$phpEx?battle_id=$battle_id", true));

			// Notify user and give progress options
			$message = sprintf($lang['Adr_pvp_start_pvp'], '<b>', $other_user['character_name'], '</b>');
			$message .= '<br /><br />'.sprintf($lang['Adr_pvp_start_pvp_1'], '<a href="adr_battle_pvp.'.$phpEx . '?battle_id='.$battle_id.'">', '</a>', '<a href="adr_character_pvp.'.$phpEx.'">', '</a>');
			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'break' :

			$battle_id = intval($HTTP_GET_VARS['battle_id']);

			$sql = " SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE battle_result = 0
				AND battle_id = $battle_id
				AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			// Get the "other" id
			$other_id = ( $row['battle_opponent_id'] != $user_id ) ? intval($row['battle_opponent_id']) : intval($row['battle_challenger_id']);
			$stopped_by = ( $row['battle_opponent_id'] != $user_id ) ? 6 : 5 ;

			$sql = " SELECT prefs_pvp_notif_pm FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = $other_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't query preferences", "", __LINE__, __FILE__, $sql);
			}
			$opponent = $db->sql_fetchrow($result);

			$sql = " DELETE FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE battle_result = 0
				AND battle_id = $battle_id
				AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}

			$subject = $lang['Adr_pvp_broken'];
			$message = sprintf($lang['Adr_pvp_broken_by'] , $adr_user['character_name']);
			
			if ( $opponent['prefs_pvp_notif_pm'] )
			{
				adr_send_pm ( $other_id , $subject  , $message );
			}

			adr_previous ( Adr_pvp_broken_ok , adr_character_pvp , "" );

			break;

		case 'defy' :

			$template->assign_block_vars('equip',array());
			$template->assign_block_vars('equip.defy',array());

			// checkdate(month, day, year) if the user hasn't already his maximum number of defies allowed
			$sql = " SELECT count(*) AS total FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE ( battle_result = 0 OR battle_result = 3 )
				AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) ";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain user list', '', __LINE__, __FILE__, $sql);
			}
			$total = $db->sql_fetchrow($result);

			if ( ( $adr_general['battle_pvp_defies_max'] <= $total['total'] ) && $adr_general['battle_pvp_defies_max'] )
			{
				adr_previous ( Adr_pvp_defy_too_much , adr_character_pvp , '' );
			}

			// Be sure the user is 	live before beginning the battle
			$char = adr_get_user_infos($user_id);
			if ( $char['character_hp'] < 1 )
			{
				$message = $lang['Adr_battle_character_dead'];
				$message .= '<br /><br />'.sprintf($lang['Adr_battle_temple'] ,"<a href=\"" . 'adr_temple.'.$phpEx . "\">", "</a>") ;
				$message .= '<br /><br />'.sprintf($lang['Adr_character_return'] ,"<a href=\"" . 'adr_character.'.$phpEx . "\">", "</a>") ;
				message_die ( GENERAL_MESSAGE , $message );
			}

			// First select the available items
			$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_in_shop = 0 
				AND item_duration > 0
				$item_sql
			AND item_owner_id = $user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$items = $db->sql_fetchrowset($result);

			// Prepare the items list
			$armor_list = '<select name="item_armor">';
			$armor_list .= '<option value = "0" >' . $lang['Adr_battle_no_armor'] . '</option>';
			$buckler_list = '<select name="item_buckler">';
			$buckler_list .= '<option value = "0" >' . $lang['Adr_battle_no_buckler'] . '</option>';
			$helm_list = '<select name="item_helm">';
			$helm_list .= '<option value = "0" >' . $lang['Adr_battle_no_helm'] . '</option>';



			$greave_list = '<select name="item_greave">';
			$greave_list .= '<option value = "0" >' . $lang['Adr_battle_no_greave'] . '</option>';
			$boot_list = '<select name="item_boot">';
			$boot_list .= '<option value = "0" >' . $lang['Adr_battle_no_boot'] . '</option>';

			$gloves_list = '<select name="item_gloves">';
			$gloves_list .= '<option value = "0" >' . $lang['Adr_battle_no_gloves'] . '</option>';
			$amulet_list = '<select name="item_amulet">';
			$amulet_list .= '<option value = "0" >' . $lang['Adr_battle_no_amulet'] . '</option>';
			$ring_list = '<select name="item_ring">';
			$ring_list .= '<option value = "0" >' . $lang['Adr_battle_no_ring'] . '</option>';
			$equip_armor = $char['equip_armor'];
			$equip_buckler = $char['equip_buckler'];
			$equip_helm = $char['equip_helm'];
			$equip_greave = $char['equip_greave'];
			$equip_boot = $char['equip_boot'];
			$equip_gloves = $char['equip_gloves'];
			$equip_amulet = $char['equip_amulet'];
			$equip_ring = $char['equip_ring'];

			for ( $i = 0 ; $i < count($items) ; $i ++ )
			{
				$item_power = $items[$i]['item_power'] + $items[$i]['item_add_power'];

				if ( $items[$i]['item_type_use'] == 7 )
				{
					$armor_selected = ( $equip_armor == $items[$i]['item_id'] ) ? 'selected' : '';
					$armor_list .= '<option value = "'.$items[$i]['item_id'].'" '.$armor_selected.' >' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
				if ( $items[$i]['item_type_use'] == 8 )
				{
					$buckler_selected = ( $equip_buckler == $items[$i]['item_id'] ) ? 'selected' : '';
					$buckler_list .= '<option value = "'.$items[$i]['item_id'].'" '.$buckler_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
				if ( $items[$i]['item_type_use'] == 9 )
				{
					$helm_selected = ( $equip_helm == $items[$i]['item_id'] ) ? 'selected' : '';
					$helm_list .= '<option value = "'.$items[$i]['item_id'].'" '.$helm_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}



				if ( $items[$i]['item_type_use'] == 29 )
				{
					$greave_selected = ( $equip_greave == $items[$i]['item_id'] ) ? 'selected' : '';
					$greave_list .= '<option value = "'.$items[$i]['item_id'].'" '.$greave_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}



				if ( $items[$i]['item_type_use'] == 30 )
				{
					$boot_selected = ( $equip_boot == $items[$i]['item_id'] ) ? 'selected' : '';
					$boot_list .= '<option value = "'.$items[$i]['item_id'].'" '.$boot_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}

				if ( $items[$i]['item_type_use'] == 10 )
				{
					$gloves_selected = ( $equip_gloves == $items[$i]['item_id'] ) ? 'selected' : '';
					$gloves_list .= '<option value = "'.$items[$i]['item_id'].'" '.$gloves_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
				if ( $items[$i]['item_type_use'] == 13 )
				{
					$amulet_selected = ( $equip_amulet == $items[$i]['item_id'] ) ? 'selected' : '';
					$amulet_list .= '<option value = "'.$items[$i]['item_id'].'" '.$amulet_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
				if ( $items[$i]['item_type_use'] == 14 )
				{
					$ring_selected = ( $equip_ring == $items[$i]['item_id'] ) ? 'selected' : '';
					$ring_list .= '<option value = "'.$items[$i]['item_id'].'" '.$ring_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
				}
			}

			$armor_list .= '</select>';
			$buckler_list .= '</select>';
			$helm_list .= '</select>';



			$greave_list .= '</select>';
			$boot_list .= '</select>';

			$gloves_list .= '</select>';
			$amulet_list .= '</select>';
			$ring_list .= '</select>';

			$sql = " SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE ( battle_result = 0 OR battle_result = 3 )
				AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) ";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain user list', '', __LINE__, __FILE__, $sql);
			}
			$targets = $db->sql_fetchrowset($result);

			$ever = '(';
			for ( $i = 0; $i < count ( $targets ) ; $i++ )
			{
				$other_id = ( $targets[$i]['battle_opponent_id'] != $user_id ) ? intval($targets[$i]['battle_opponent_id']) : intval($targets[$i]['battle_challenger_id']);
				$ever .= $other_id . ',' ;
			}
			$ever .= ' -1 , 1 , 0)';

			$sql = "SELECT u.user_id, username, c.* FROM " . USERS_TABLE . " u, " . ADR_CHARACTERS_TABLE . " c
				WHERE u.user_id NOT IN $ever
				AND u.user_id != '$user_id'
				AND u.user_id = c.character_id
				AND c.prefs_pvp_allow = '1'
				ORDER by u.username";
			if(!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not obtain user list', '', __LINE__, __FILE__, $sql);
			$users = $db->sql_fetchrowset($result);

			// Create list of characters available for PvP battle
			$chars_list = '<select name="defied">';
			for($i = 0; $i < count($users); $i++)
				$chars_list .= '<option value = "'.$users[$i]['user_id'].'" >' . $users[$i]['character_name'] . '&nbsp;(' . $users[$i]['username'] . ';&nbsp;' . $lang['Adr_character_level'] . ':&nbsp;' . $users[$i]['character_level'] . ')&nbsp;</option>';
			$chars_list .= '</select>';

			$template->assign_vars(array(
				'SELECT_ARMOR'  => $armor_list,
				'SELECT_BUCKLER' => $buckler_list,
				'SELECT_HELM' => $helm_list,



				'SELECT_GREAVE' => $greave_list,
				'SELECT_BOOT' => $boot_list,

				'SELECT_GLOVES' => $gloves_list,
				'SELECT_AMULET' => $amulet_list,
				'SELECT_RING' => $ring_list, 
				"DEFY" => $chars_list,
				"L_DEFY" => $lang['Adr_pvp_defy_user'],
				"L_DEFY_USER" => $lang['Adr_pvp_defy_select'],
				"L_SUBMIT" => $lang['Submit'],
				'L_EQUIPMENT' => $lang['Adr_battle_equipment'],
				'L_SELECT_ARMOR'  => $lang['Adr_battle_select_armor'],
				'L_SELECT_BUCKLER' => $lang['Adr_battle_select_buckler'],
				'L_SELECT_HELM' => $lang['Adr_battle_select_helm'],



				'L_SELECT_GREAVE' => $lang['Adr_battle_select_greave'],
				'L_SELECT_BOOT' => $lang['Adr_battle_select_boot'],

				'L_SELECT_GLOVES' => $lang['Adr_battle_select_gloves'],
				'L_SELECT_AMULET' => $lang['Adr_battle_select_amulet'],
				'L_SELECT_RING' => $lang['Adr_battle_select_ring'],
				'L_FIGHT' => $lang['Adr_battle_fight'],
			));

			break;

		case 'defy_action' :


			$defied = (!empty($HTTP_POST_VARS['defied'])) ? intval($HTTP_POST_VARS['defied']) : intval($HTTP_GET_VARS['defied']);

			##=== START challenger checks ===##
			// Grab challenger infos
			$char = adr_get_user_infos($user_id);

			// Be sure he has a character
			if(!(is_numeric($char['character_id']))){
				adr_previous(Adr_your_character_lack, adr_character, '');}

			// Be sure user isn't trying to attack theirselves
			if($defied === $user_id) adr_previous(Adr_pvp_self, adr_character_pvp, '');

			// Check challenger has enough quota left for today
//			if(($adr_general['Adr_character_limit_enable'] == '1') && ($char['character_pvp_limit'] < '1'))
//				adr_previous(Adr_pvp_no_quota_you, adr_character_pvp, '');

			// Check if the user hasn't already his maximum number of defies allowed
			$sql = "SELECT count(*) AS total FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE (battle_result = 0 OR battle_result = 3)
				AND (battle_opponent_id = $user_id	OR battle_challenger_id = $user_id)";
			if(!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not obtain user list', '', __LINE__, __FILE__, $sql);
			$total_challenger = $db->sql_fetchrow($result);

			// Make sure challenger hasn't already exceeded max active PvP battles
			if(($adr_general['battle_pvp_defies_max'] <= $total_challenger['total']) && ($adr_general['battle_pvp_defies_max']))
				adr_previous(Adr_pvp_defy_too_much, adr_character_pvp, '');

			// Make sure character isn't already dead
			if($char['character_hp'] < '1'){
				$message = $lang['Adr_battle_character_dead'];
				$message .= '<br /><br />'.sprintf($lang['Adr_battle_temple'] ,"<a href=\"" . 'adr_temple.'.$phpEx . "\">", "</a>") ;
				$message .= '<br /><br />'.sprintf($lang['Adr_character_return'] ,"<a href=\"" . 'adr_character.'.$phpEx . "\">", "</a>") ;
				message_die(GENERAL_MESSAGE, $message);
			}
			##=== END challenger checks ===##

			##=== START opponent checks ===##
			// Grab opponent infos
			$other_user = adr_get_user_infos($defied);

			// Be sure he has a character
			if(!(is_numeric($other_user['character_id']))){
				adr_previous(Adr_your_character_lack, adr_character, '');}

			// Check opponent has enough quota left for today
//			if(($adr_general['Adr_character_limit_enable'] == '1') && ($other_user['character_pvp_limit'] < '1'))
//				adr_previous(Adr_pvp_no_quota_other, adr_character_pvp, '');

			// Check if the user hasn't already his maximum number of defies allowed
			$sql = "SELECT count(*) AS total FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE (battle_result = 0 OR battle_result = 3)
				AND (battle_opponent_id = $defied	OR battle_challenger_id = $defied)";
			if(!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not obtain user list', '', __LINE__, __FILE__, $sql);
			$total_opponent = $db->sql_fetchrow($result);

			// Make sure challenger hasn't already exceeded max active PvP battles
			if(($adr_general['battle_pvp_defies_max'] <= $total_opponent['total']) && ($adr_general['battle_pvp_defies_max']))
				adr_previous(Adr_pvp_defy_too_much_opponent, adr_character_pvp, '');

			// Make sure character isn't already dead
			if($other_user['character_hp'] < '1'){
				$message = $lang['Adr_battle_character_dead'];
				$message .= '<br /><br />'.sprintf($lang['Adr_battle_temple'] ,"<a href=\"" . 'adr_temple.'.$phpEx . "\">", "</a>") ;
				$message .= '<br /><br />'.sprintf($lang['Adr_character_return'] ,"<a href=\"" . 'adr_character.'.$phpEx . "\">", "</a>") ;
				message_die(GENERAL_MESSAGE, $message);
			}
			##=== END opponent checks ===##

			$sql = " SELECT battle_id FROM " . ADR_BATTLE_PVP_TABLE . "
				ORDER BY battle_id DESC LIMIT 1 ";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain user list', '', __LINE__, __FILE__, $sql);
			}
			$last_row = $db->sql_fetchrow($result);
			$last_id = $last_row['battle_id'] + 1;

			// Fix the items ids
			$armor = intval($HTTP_POST_VARS['item_armor']);
			$buckler = intval($HTTP_POST_VARS['item_buckler']);
			$helm = intval($HTTP_POST_VARS['item_helm']);



			$greave = intval($HTTP_POST_VARS['item_greave']);
			$boot = intval($HTTP_POST_VARS['item_boot']);

			$gloves = intval($HTTP_POST_VARS['item_gloves']);
			$amulet = intval($HTTP_POST_VARS['item_amulet']);
			$ring = intval($HTTP_POST_VARS['item_ring']);

			// Get the user infos
			$char = adr_get_user_infos($user_id);

			// Calculate the base stats
			$hp = $char['character_hp'];
			$mp = $char['character_mp'];
			$hp_max = $char['character_hp_max'];
			$mp_max = $char['character_mp_max'];
			$hp_regen = 0;
			$mp_regen = 0;
			$elemental = $char['character_element'];

			// Firstly, create the users' phyisial attack and magic attack stats
			$att = adr_battle_make_att($char['character_might'], $char['character_dexterity']);
			$ma = adr_battle_make_magic_att($char['character_intelligence']);
			$def = adr_battle_make_def($char['character_ac'], $char['character_dexterity']);
			$md = adr_battle_make_magic_def($char['character_wisdom']);

			if ( $armor )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $armor ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				$armour_name = adr_get_lang($item['item_name']);
			}

			if ( $buckler )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $buckler ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				$buckler_name = adr_get_lang($item['item_name']);
			}

			if ( $gloves )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $gloves ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				$gloves_name = adr_get_lang($item['item_name']);
			}

			if ( $helm )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $helm ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				$helm_name = adr_get_lang($item['item_name']);
			}
			if ( $greave )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $greave ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				$greave_name = adr_get_lang($item['item_name']);
			}

			if ( $boot )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $boot ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$def = ( $def + $item['item_power'] ) + $item['item_add_power'];

				$boot_name = adr_get_lang($item['item_name']);
			}


			// Now we modify mp and hp regeneration with amulets and rings
			if ( $amulet )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $amulet ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$hp_regen = $hp_regen + $item['item_power'];

				$amulet_name = adr_get_lang($item['item_name']);
			}

			if ( $ring )
			{
				$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_in_shop = 0 
					AND item_owner_id = $user_id 
					$item_sql
					AND item_id = $ring ";
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
				}
				$item = $db->sql_fetchrow($result);

				$mp_regen = $mp_regen + $item['item_power'];

				$ring_name = adr_get_lang($item['item_name']);
			}

			// Now update the database
			$sql = " INSERT INTO " . ADR_BATTLE_PVP_TABLE . "
				( battle_id, battle_turn , battle_challenger_id , battle_challenger_att , battle_challenger_def , battle_challenger_hp , battle_challenger_mp , battle_challenger_magic_attack , battle_challenger_magic_resistance , battle_challenger_hp_max , battle_challenger_mp_max , battle_challenger_hp_regen , battle_challenger_mp_regen , battle_challenger_element , battle_opponent_id )
				VALUES ( $last_id , $user_id, $user_id , $att , $def , $hp , $mp , $ma , $md , $hp_max , $mp_max , $hp_regen , $mp_regen , $elemental , $defied ) ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new battle", "", __LINE__, __FILE__, $sql);
			}

			// Do armour set check for challenger
			adr_pvp_armour_set_check($last_id, $user_id, 0, $armour_name, $buckler_name, $gloves_name, $helm_name, $amulet_name, $ring_name, $greave_name, $boot_name);

			$sql = " SELECT prefs_pvp_notif_pm FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = $defied ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't query preferences", "", __LINE__, __FILE__, $sql);
			}
			$opponent = $db->sql_fetchrow($result);

			$subject = sprintf($lang['Adr_pvp_defied_by'] , $char['character_name']);
			$message = $subject;
			$link = $server_protocol . $server_name . $server_port . $script_name ;
			$message .= sprintf($lang['Adr_pvp_defied_by_link'],$link);
			
			if ( $opponent['prefs_pvp_notif_pm'] )
			{
				adr_send_pm ( $defied , $subject  , $message );
			}

			adr_previous ( Adr_pvp_defy_ok , adr_character_pvp , 'mode=waiting' );

			break;

		case 'deny' :

			$battle_id = intval($HTTP_GET_VARS['battle_id']);

			$sql = " SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE battle_result = 0
				AND battle_id = $battle_id
				AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			// Get the "other" id
			$other_id = ( $row['battle_opponent_id'] != $user_id ) ? intval($row['battle_opponent_id']) : intval($row['battle_challenger_id']);

			// Get opponent's character name name
			$ssql = "SELECT character_name FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = '$other_id'";
			if(!($sresult = $db->sql_query($ssql))){
				message_die(GENERAL_ERROR, 'Could not query character name', '', __LINE__, __FILE__, $ssql);}
			$opponent = $db->sql_fetchrow($sresult);
			$opponent_name = $opponent['character_name'];

			$sql = " SELECT prefs_pvp_notif_pm FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = $other_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't query preferences", "", __LINE__, __FILE__, $sql);
			}
			$opponent = $db->sql_fetchrow($result);

			$subject = $lang['Adr_pvp_denied'];
			$message = sprintf($lang['Adr_pvp_denied_by'] , $adr_user['character_name']);
			
			$sql = " DELETE FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE battle_result = 0
				AND battle_id = $battle_id
				AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not delete defy', '', __LINE__, __FILE__, $sql);
			}

			if ( $opponent['prefs_pvp_notif_pm'] )
			{
				adr_send_pm ( $other_id , $subject  , $message );
			}

			adr_previous ( Adr_pvp_deny_ok , adr_character_pvp , "mode=waiting" );

			break;

		case 'see' :

			$battle_id = intval($HTTP_GET_VARS['battle_id']);

			adr_template_file('adr_battle_pvp_body.tpl');

			$sql = " SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE battle_result = 3
				AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) 
				AND battle_id = $battle_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$battle_pvp = $db->sql_fetchrow($result);

			// Get the current user and the opponent infos
			if ( $user_id == $battle_pvp['battle_challenger_id'] )
			{
				$current_hp  = $battle_pvp['battle_challenger_hp'];
				$current_mp  = $battle_pvp['battle_challenger_mp'];
				$current_hp_max  = $battle_pvp['battle_challenger_hp_max'];
				$current_mp_max  = $battle_pvp['battle_challenger_mp_max'];
				$current_hp_regen  = $battle_pvp['battle_challenger_hp'];
				$current_mp_regen  = $battle_pvp['battle_challenger_mp'];
				$current_att  = $battle_pvp['battle_challenger_att'];
				$current_def  = $battle_pvp['battle_challenger_def'];
				$current_ma  = $battle_pvp['battle_challenger_magic_attack'];
				$current_md  = $battle_pvp['battle_challenger_resistance'];
				$opponent_hp  = $battle_pvp['battle_opponent_hp'];
				$opponent_mp  = $battle_pvp['battle_opponent_mp'];
				$opponent_hp_max  = $battle_pvp['battle_opponent_hp_max'];
				$opponent_mp_max  = $battle_pvp['battle_opponent_mp_max'];
				$opponent_hp_regen  = $battle_pvp['battle_opponent_hp'];
				$opponent_mp_regen  = $battle_pvp['battle_opponent_mp'];
				$opponent_att  = $battle_pvp['battle_opponent_att'];
				$opponent_def  = $battle_pvp['battle_opponent_def'];
				$opponent_ma  = $battle_pvp['battle_opponent_magic_attack'];
				$opponent_md  = $battle_pvp['battle_opponent_magic_resistance'];
				$dest = $battle_pvp['battle_opponent_id'];
			}
			else if ( $user_id == $battle_pvp['battle_opponent_id'] )
			{
				$current_hp  = $battle_pvp['battle_opponent_hp'];
				$current_mp  = $battle_pvp['battle_opponent_mp'];
				$current_hp_max  = $battle_pvp['battle_opponent_hp_max'];
				$current_mp_max  = $battle_pvp['battle_opponent_mp_max'];
				$current_hp_regen  = $battle_pvp['battle_opponent_hp'];
				$current_mp_regen  = $battle_pvp['battle_opponent_mp'];
				$current_att  = $battle_pvp['battle_opponent_att'];
				$current_def  = $battle_pvp['battle_opponent_def'];
				$current_ma  = $battle_pvp['battle_opponent_magic_attack'];
				$current_md  = $battle_pvp['battle_opponent_magic_resistance'];
				$opponent_hp  = $battle_pvp['battle_challenger_hp'];
				$opponent_mp  = $battle_pvp['battle_challenger_mp'];
				$opponent_hp_max  = $battle_pvp['battle_challenger_hp_max'];
				$opponent_mp_max  = $battle_pvp['battle_challenger_mp_max'];
				$opponent_hp_regen  = $battle_pvp['battle_challenger_hp'];
				$opponent_mp_regen  = $battle_pvp['battle_challenger_mp'];
				$opponent_att  = $battle_pvp['battle_challenger_att'];
				$opponent_def  = $battle_pvp['battle_challenger_def'];
				$opponent_ma  = $battle_pvp['battle_challenger_magic_attack'];
				$opponent_md  = $battle_pvp['battle_challenger_magic_resistance'];
				$dest = $battle_pvp['battle_challenger_id'];
			}
			$battle_challenger_id = $battle_pvp['battle_challenger_id'];
			$battle_opponent_id = $battle_pvp['battle_opponent_id'];
			$battle_text = $battle_pvp['battle_text'];
			$battle_text_chat = $battle_pvp['battle_text_chat'];

			$current_name = htmlspecialchars($adr_user['character_name']);

			$sql = "SELECT character_name FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = '$dest'";
			if(!($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not query opponent name', '', __LINE__, __FILE__, $sql);
			$opponent_inf = $db->sql_fetchrow($result);
			$opponent_name = htmlspecialchars($opponent_inf['character_name']);

			$sql = "SELECT user_avatar , user_avatar_type, user_allowavatar FROM " . USERS_TABLE . "
				WHERE user_id = $dest ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query user', '', __LINE__, __FILE__, $sql);
			}
			$challenger = $db->sql_fetchrow($result);

			$opponent_avatar_img = '';
			if ( $challenger['user_avatar_type'] && $challenger['user_allowavatar'] )
			{
				switch( $challenger['user_avatar_type'] )
				{
					case USER_AVATAR_UPLOAD:
						$opponent_avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
						break;
					case USER_AVATAR_REMOTE:
						$opponent_avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
						break;
					case USER_AVATAR_GALLERY:
						$opponent_avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
						break;
				}
			}

			$sql = "SELECT c.character_level , u.user_avatar , u.user_avatar_type, u.user_allowavatar FROM " . USERS_TABLE . " u , " . ADR_CHARACTERS_TABLE . " c
				WHERE u.user_id = $user_id 
				AND c.character_id = u.user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query user', '', __LINE__, __FILE__, $sql);
			}
			$challenger = $db->sql_fetchrow($result);

			$current_avatar_img = '';
			if ( $challenger['user_avatar_type'] && $challenger['user_allowavatar'] )
			{
				switch( $challenger['user_avatar_type'] )
				{
					case USER_AVATAR_UPLOAD:
						$current_avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
						break;
					case USER_AVATAR_REMOTE:
						$current_avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
						break;
					case USER_AVATAR_GALLERY:
						$current_avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
						break;
				}
			}

			// START calculate HP/MP bar width
			if ( $current_hp > $current_hp_max )
			{
				$challenger_hp_width = "100";
			}
			else
			{
				$challenger_hp_width = floor(( $current_hp / $current_hp_max ) * 100  );
			}

			if ( $current_mp > $current_mp_max )
			{
      				$challenger_mp_width = "100";
			}
			else
			{
				$challenger_mp_width = floor(( $current_mp / $current_mp_max ) * 100  );
			}

			if ( $opponent_hp > $opponent_hp_max )
			{
      				$opponent_hp_width = "100";
			}
			else
			{
				$opponent_hp_width = floor(( $opponent_hp / $opponent_hp_max ) * 100  );
			}

			if ( $opponent_mp > $opponent_mp_max )
			{
      				$opponent_mp_width = "100";
			}
			else
			{
				$opponent_mp_width = floor(( $opponent_mp / $opponent_mp_max ) * 100  );
			}
			// END calculate HP/MP bar width

			$template->assign_vars(array(
				'NAME' => $current_name,
				'AVATAR_IMG' => $current_avatar_img, 
				'OPPONENT_NAME' => $opponent_name,
				'OPPONENT_IMG' => $opponent_avatar_img,
				'BATTLE_TEXT' => $battle_text,
				'BATTLE_CHAT' => $battle_text_chat,
				'HP' => $current_hp,
				'MP' => $current_mp,
				'HP_MAX' => $current_hp_max,
				'MP_MAX' => $current_mp_max,
   			      'HP_WIDTH' => $challenger_hp_width,
   			      'MP_WIDTH' => $challenger_mp_width,
				'ATT' => $current_att,
				'DEF' => $current_def,
				'OPPONENT_HP' => $opponent_hp,
				'OPPONENT_MP' => $opponent_mp,
				'OPPONENT_HP_MAX' => $opponent_hp_max,
				'OPPONENT_MP_MAX' => $opponent_mp_max,
     			      'OPPONENT_HP_WIDTH' => $opponent_hp_width,
        			'OPPONENT_MP_WIDTH' => $opponent_mp_width,
				'OPPONENT_ATT' => $opponent_att,
				'OPPONENT_DEF' => $opponent_def,
				'L_HP'=> $lang['Adr_character_health'],
				'L_MP' => $lang['Adr_character_magic'],
				'L_ATT' => $lang['Adr_attack'],
				'L_DEF' => $lang['Adr_defense'],
				'L_BATTLE_CHAT' => $lang['Adr_pvp_battle_chat'],
			));

			break;

		case 'stop' :

			$battle_id = intval($HTTP_GET_VARS['battle_id']);

			$sql = " SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE battle_result = 3
				AND battle_id = $battle_id
				AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			// Get the "other" id
			$other_id = ( $row['battle_opponent_id'] != $user_id ) ? intval($row['battle_opponent_id']) : intval($row['battle_challenger_id']);
			$stopped_by = ( $row['battle_opponent_id'] != $user_id ) ? 6 : 5 ;

			$sql = " UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_victories = character_victories + 1
				WHERE character_id = $other_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
			}

			$sql = " UPDATE " . ADR_CHARACTERS_TABLE . "
				SET character_flees = character_flees + 1
				WHERE character_id = $user_id ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
			}

			$sql = " UPDATE " . ADR_BATTLE_PVP_TABLE . "
				SET battle_result = $stopped_by
				WHERE battle_id = $battle_id
				AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not delete defy', '', __LINE__, __FILE__, $sql);
			}

			$sql = " SELECT prefs_pvp_notif_pm FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = $other_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't query preferences", "", __LINE__, __FILE__, $sql);
			}
			$opponent = $db->sql_fetchrow($result);

			$subject = $lang['Adr_pvp_stopped'];
			$message = sprintf($lang['Adr_pvp_stopped_by'] , $adr_user['character_name']);
			
			if ( $opponent['prefs_pvp_notif_pm'] )
			{
				adr_send_pm ( $other_id , $subject  , $message );
			}

			adr_previous ( Adr_pvp_stop_ok , adr_character_pvp , "" );

			break;

		case 'waiting' :

			$template->assign_block_vars('waiting_battles',array());

			$sql = " SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE battle_result = 0
				AND battle_opponent_id = $user_id 
				ORDER BY battle_id DESC ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			if ( $row = $db->sql_fetchrow($result) )
			{
				$i = 0;
				do
				{
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

					// Get the "other" id
					$other_id = ( $row['battle_opponent_id'] != $user_id ) ? intval($row['battle_opponent_id']) : intval($row['battle_challenger_id']);

					// Get his name
					$ssql = "SELECT character_name FROM " . ADR_CHARACTERS_TABLE . "
						WHERE character_id = $other_id ";
					if( !($sresult = $db->sql_query($ssql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query character name', '', __LINE__, __FILE__, $ssql);
					}
					$opponent = $db->sql_fetchrow($sresult);

					$template->assign_block_vars('waiting_battles.waiting', array(
						"ROW_CLASS" => $row_class,
						"OPPONENT" => $opponent['character_name'],
						"U_OPPONENT"  => append_sid("adr_character.$phpEx?". POST_USERS_URL . "=".$other_id),
						"U_ACCEPT" => append_sid("adr_character_pvp.$phpEx?mode=accept&amp;battle_id=".$row['battle_id']),
						"U_DENY" => append_sid("adr_character_pvp.$phpEx?mode=deny&amp;battle_id=".$row['battle_id']),
					));

					$i++;
				}
				while ( $row = $db->sql_fetchrow($result) );

			}

			$sql = " SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
				WHERE battle_result = 0
				AND battle_challenger_id = $user_id 
				ORDER BY battle_id DESC ";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
			}
			if ( $row = $db->sql_fetchrow($result) )
			{
				$i = 0;
				do
				{
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

					// Get the "other" id
					$other_id = ( $row['battle_opponent_id'] != $user_id ) ? intval($row['battle_opponent_id']) : intval($row['battle_challenger_id']);

					// Get his name
					$ssql = "SELECT character_name FROM " . ADR_CHARACTERS_TABLE . "
						WHERE character_id = $other_id ";
					if( !($sresult = $db->sql_query($ssql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query character name', '', __LINE__, __FILE__, $ssql);
					}
					$opponent = $db->sql_fetchrow($sresult);

					$template->assign_block_vars('waiting_battles.waitings', array(
						"ROW_CLASS" => $row_class,
						"OPPONENT" => $opponent['character_name'],
						"U_OPPONENT"  => append_sid("adr_character.$phpEx?". POST_USERS_URL . "=".$other_id),
						"U_BREAK" => append_sid("adr_character_pvp.$phpEx?mode=break&amp;battle_id=".$row['battle_id']),
					));

					$i++;
				}
				while ( $row = $db->sql_fetchrow($result) );

			}

			$template->assign_vars(array(	
				"L_OPPONENT" => $lang['Adr_pvp_opponent'],
				"L_ACCEPT" => $lang['Adr_pvp_waiting_accept'],
				"L_DENY" => $lang['Adr_pvp_waiting_deny'],
				"L_BREAK" => $lang['Adr_pvp_waiting_break'],
				"L_WAITING_YOU" => $lang['Adr_pvp_waiting_battles_you'],
				"L_WAITING_OTHER" => $lang['Adr_pvp_waiting_battles_other'],
			));

			break;
	}
}
else
{
	$template->assign_block_vars('current_battles',array());

	$sql = " SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
		WHERE battle_result = 3
		AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id ) 
		ORDER BY battle_id DESC ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	}
	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			// Get the "other" id
			$other_id = ( $row['battle_opponent_id'] != $user_id ) ? intval($row['battle_opponent_id']) : intval($row['battle_challenger_id']);

			// Get his name
			$ssql = "SELECT character_name , character_id FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = $other_id ";
			if( !($sresult = $db->sql_query($ssql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query character name', '', __LINE__, __FILE__, $ssql);
			}
			$opponent = $db->sql_fetchrow($sresult);

			// Current turn?
			$turn = ($row['battle_turn'] == $opponent['character_id']) ? $opponent['character_name'] : '<b>'.$lang['Adr_pvp_your_turn'].'</b>';

			// Is this the turn of the user ?
			$join = ( $row['battle_turn'] == $user_id ) ? $lang['Adr_pvp_join'] : '';

			$template->assign_block_vars('current_battles.current', array(
				"JOIN_BATTLE" => $join,
				"ROW_CLASS" => $row_class,
				"OPPONENT" => $opponent['character_name'],
				"TURN" => $turn,
				"U_OPPONENT"  => append_sid("adr_character.$phpEx?". POST_USERS_URL . "=".$other_id),
				"U_JOIN_BATTLE" => append_sid("adr_battle_pvp.$phpEx?battle_id=".$row['battle_id']),
				"U_STOP" => append_sid("adr_character_pvp.$phpEx?mode=stop&amp;battle_id=".$row['battle_id']),
				"U_SEE" => append_sid("adr_battle_pvp.$phpEx?battle_id=".$row['battle_id'])
			));

			$i++;
		}
		while ( $row = $db->sql_fetchrow($result) );

	}

	$template->assign_vars(array(	
		'L_CURRENT_PVP' => $lang['Adr_pvp_current_battles'],
		'L_OPPONENT' => $lang['Adr_pvp_opponent'],
		'L_TURN' => $lang['Adr_pvp_turn'],
		'L_JOIN' => $lang['Adr_pvp_join'],
		'L_STOP' => $lang['Adr_pvp_stop'],
		'L_SEE' => $lang['Adr_pvp_see'],
	));
}


## Work out total battles awaiting for submenu ##
$sql = "SELECT count(battle_id) AS total FROM " . ADR_BATTLE_PVP_TABLE . "
	WHERE battle_result = '0'
	AND (battle_challenger_id = '$user_id' OR battle_opponent_id = '$user_id')
	ORDER BY battle_id DESC";
if(!($result = $db->sql_query($sql)))
{
	message_die(GENERAL_ERROR, 'Could not obtain user list', '', __LINE__, __FILE__, $sql);
}
$total_reply = $db->sql_fetchrow($result);

## Work out total battles in progress for submenu ##
$sql = "SELECT count(battle_id) AS total FROM " . ADR_BATTLE_PVP_TABLE . "
	WHERE battle_result = '3'
	AND (battle_opponent_id = '$user_id'	OR battle_challenger_id = '$user_id')";
if(!($result = $db->sql_query($sql))){
	message_die(GENERAL_ERROR, 'Could not obtain user list', '', __LINE__, __FILE__, $sql);}
$total_battles = $db->sql_fetchrow($result);


$template->assign_vars(array(	
	"L_DEFY" => $lang['Adr_pvp_defy'],
	"L_CURRENT" => $lang['Adr_pvp_current_battles'].' ('.$total_battles['total'].')',
	"L_WAITING" => $lang['Adr_pvp_waiting_battles'].' ('.$total_reply['total'].')',

	'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
	'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
	'L_COPYRIGHT' => $lang['Adr_copyright'],
	'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
	'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
	'U_TOWNBOUTONRETOUR' => append_sid("adr_TownMap.$phpEx"),

	"U_DEFY" => append_sid("adr_character_pvp.$phpEx?mode=defy"),
	"U_CURRENT" => append_sid("adr_character_pvp.$phpEx?mode=current"),
	"U_WAITING" => append_sid("adr_character_pvp.$phpEx?mode=waiting"),
	"S_PVP_ACTION" => append_sid("adr_character_pvp.$phpEx?". POST_USERS_URL . "=".$searchid),
));

// Empty the request in memory
$db->sql_freeresult($result);

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);




$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 
