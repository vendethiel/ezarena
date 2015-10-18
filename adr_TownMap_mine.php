<?php 
/***************************************************************************
 *				adr_TownMap_mine.php
 *				------------------------
 *	begin 			: 22/11/2004
 *	copyright			: One_Piece
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
define('IN_ADR_TOWNMAP', true);
define('IN_TOWNMAP_INFOBOX', true);
define('IN_TOWNMAP_MINE', true);
define('IN_TOWNMAP_COPYRIGHT', true);
define('IN_ADR_FORGE', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_CHARACTER', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_TownMap_mine';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

$user_id = $userdata['user_id'];
$points = $userdata['user_points'];

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_TownMap_mine.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

// Includes the tpl and the header and the choice of season
adr_template_file('adr_TownMap_mine_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$saison = 'Carte' . $board_config['adr_seasons'];

// Get the general config
$adr_general = adr_get_general_config();

// Grab details for skill limit
$sql = "SELECT character_skill_limit FROM " . ADR_CHARACTERS_TABLE . "
		WHERE character_id = $user_id ";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query skill limit value', '', __LINE__, __FILE__, $sql);
}
$limit_update = $db->sql_fetchrow($result);

if ( !$adr_general['Adr_disable_rpg'] && $userdata['user_level'] != ADMIN ) 
{	
	adr_previous ( Adr_disable_rpg , 'index' , '' );
}
// Deny access if user is imprisioned
if($userdata['user_cell_time']){
	adr_previous(Adr_shops_no_thief, adr_cell, '');
}
	
if ( $adr_general['Adr_character_limit_enable'] != 0 && $limit_update['character_skill_limit'] <= 0 ) 
{	
	adr_previous ( Adr_skill_limit , adr_character , '' );
}

if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);	
}
else
{
	$mode = "";
}


if ( isset($_POST['InfoMine']) )
{
	adr_previous('Adr_TownMap_Mine_Infos', 'adr_TownMap_mine', '');
}

if ( $mode != "" )
{
	switch($mode)
	{

		case 'mining' :

			$template->assign_block_vars('mining',array());
			$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_owner_id = $user_id
				AND item_in_shop = 0
				AND item_in_warehouse = 0
				AND item_duration > 0
				AND item_type_use = 3 ";
			if ( !($result = $db->sql_query($sql)))
			{
				message_die(GENERAL_ERROR, 'Could not check user tools',"", __LINE__, __FILE__, $sql);
			}
			$tools = $db->sql_fetchrowset($result);
		
			$tool_list = '<select name="item_tool">';
			$tool_list .= '<option value = "0" >' . $lang['Adr_forge_mining_no_tool'] . '</option>';
			for ( $i = 0 ; $i < count($tools) ; $i ++ )
			{
				$tool_list .= '<option value = "'.$tools[$i]['item_id'].'" >' . adr_get_lang($tools[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $tools[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $tools[$i]['item_duration'] . ' )'.'</option>';
			}
			$tool_list .= '</select>';

			$template->assign_vars(array(
				'TOOL_LIST' => $tool_list,
				'L_SELECT_TOOL' => $lang['Adr_forge_mining_select_tool'],
				'L_GO_MINING' => $lang['Adr_forge_mining_go'],
				'L_MINING_EXPLAIN' => $lang['Adr_forge_mining_explain'],
			));

			break;

		case 'mining_action' :
			
			$tool = intval($HTTP_POST_VARS['item_tool']);

			// No tool , no mining
			if ( !$tool )
			{
				adr_previous ( Adr_forge_mining_tool_needed , adr_TownMap_mine , "mode=mining" );
			}
			else
			{	
				$new_item_id = adr_use_skill_mining($user_id , $tool);

				if ( !$new_item_id )
				{
					adr_previous ( Adr_forge_mining_failure , adr_TownMap_mine , "mode=mining" );
				}
				else
				{
					$sql = " SELECT item_name , item_price FROM " . ADR_SHOPS_ITEMS_TABLE . "
						WHERE item_owner_id = $user_id 
						AND item_in_warehouse = 0
						AND item_id = $new_item_id ";
					if ( !($result = $db->sql_query($sql)))
					{
						message_die(GENERAL_ERROR, 'Could not check user tools',"", __LINE__, __FILE__, $sql);
					}
					$new_item = $db->sql_fetchrow($result);

					$direction = append_sid("adr_TownMap_mine.$phpEx?mode=mining");
					$message = sprintf($lang['Adr_forge_mining_success'] , adr_get_lang($new_item['item_name']) , $new_item['item_price'] , $board_config['points_name'] );
					$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;

					message_die ( GENERAL_MESSAGE , $message );
				}
			}
		
			break;


		case 'create' :
			break;
	}
}
else
{
	$template->assign_block_vars('main',array());
}


$template->assign_vars(array(
	'SAISON' => $saison,
	'L_TOWNMAP_MINE' => $lang['TownMap_Mine'],
	'L_TOWNBOUTONINFO' => $lang['Adr_TownMap_Bouton_Infos'],
	'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
	'L_MINEPRESENTATION' => $lang['Adr_TownMap_Mine_Presentation'],
	'L_MINEENTREE' => $lang['TownMap_Mine_Entree'],
	'L_CREATE_ITEM' => $lang['Adr_forge_create'],
	'L_MINING' => $lang['Adr_forge_mining'],
	'L_COPYRIGHT' => $lang['Adr_copyright'],
	'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
	'U_TOWNBOUTONRETOUR' => append_sid("adr_zones.$phpEx"),
	'U_TOWNMAP_MINE' => append_sid("adr_TownMap_mine.$phpEx"),
	'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
	'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
	'U_CREATE_ITEM' => append_sid("adr_TownMap_pierrerunique.$phpEx?mode=create"),
	'U_MINING' => append_sid("adr_TownMap_mine.$phpEx?mode=mining"),
	'S_FORGE_ACTION'=> append_sid("adr_TownMap_mine.$phpEx"),
	'S_CHARACTER_ACTION' => append_sid("adr_TownMap_mine.$phpEx"),
));

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 