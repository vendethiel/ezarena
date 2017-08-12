<?php 
/***************************************************************************
 *					adr_herbal.php
 *				------------------------
 *	begin 			: 06/29/2006
 *	copyright		: ShadowTek
 *  modded			: Raven
 *  re-modded       : Makien
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
define('IN_ADR_HERBAL', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_CHARACTER', true);
define('IN_TOWNMAP_INFOBOX', true);
define('IN_ADR_TOWNMAP', true);
define('IN_ADR_LOOTTABLES', 1);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_herbal';

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
	$redirect = "adr_herbal.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_herbal_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();

// Grab details for skill limit
$sql = " SELECT character_skill_limit, character_area FROM " . ADR_CHARACTERS_TABLE . "
		WHERE character_id = $user_id ";
if( !($result = $db->sql_query($sql)) ){
	message_die(GENERAL_ERROR, 'Could not query skill limit value', '', __LINE__, __FILE__, $sql);}
$limit_update = $db->sql_fetchrow($result);

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
$adr_user = adr_get_user_infos($user_id); 
$info = zone_get($adr_user['character_area']);

$access = $info['zone_herbal'];

if ( $access == '0' )
	adr_previous( Adr_zone_building_noaccess , adr_zones , '' );

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
if ( $mode != "" )
{
	switch($mode)
	{
		case 'herbalism' :

			$template->assign_block_vars('herbalism',array());
			$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_owner_id = $user_id
				AND item_in_shop = 0
				AND item_in_warehouse = 0
				AND item_duration > 0
				AND item_type_use = 25 ";
			if ( !($result = $db->sql_query($sql)))			{
				message_die(GENERAL_ERROR, 'Could not check user tools',"", __LINE__, __FILE__, $sql);}
			$tools = $db->sql_fetchrowset($result);
		
			$tool_list = '<select name="item_tool">';
			$tool_list .= '<option value = "0" >' . $lang['Adr_forge_herbalism_no_tool'] . '</option>';

			for ( $i = 0 ; $i < count($tools) ; $i ++ )
			{
				$tool_list .= '<option value = "'.$tools[$i]['item_id'].'" >' . adr_get_lang($tools[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $tools[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $tools[$i]['item_duration'] . ' )'.'</option>';
			}
			$tool_list .= '</select>';

			$template->assign_vars(array(
				'TOOL_LIST' => $tool_list,
				'L_SELECT_TOOL' => $lang['Adr_forge_herbalism_select_tool'],
				'L_GO_HERBALISM' => $lang['Adr_forge_herbalism_go'],
				'L_HERBALISM_EXPLAIN' => $lang['Adr_forge_herbalism_explain'],
			));
			break;

		case 'herbalism_action' :
			
			$tool = intval($HTTP_POST_VARS['item_tool']);

			// No tool , no herbalism
			if ( !$tool )
			{
				adr_previous ( Adr_forge_herbalism_tool_needed , adr_herbal , "mode=herbalism" );
			}
			else
			{	
			  //Tool gets used even if character doesn't find anything
			  adr_use_item($tool , $user_id);
				$item = drop_gather_loot($actual_zone, $user_id, 'herbalism', 10);

				if ( !$item )
				{
					include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
					$direction = append_sid("adr_herbal.$phpEx?mode=herbalism");
					$message .= "Vous n'avez rien trouvé.";
					$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;

					message_die ( GENERAL_MESSAGE , $message );
				}
				else{
				include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
						 					$message = $item . '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;								
						 message_die ( GENERAL_MESSAGE , $message );
				}
			}
		break;
	}
}

else
{
	$template->assign_block_vars('main',array());
}
// Fix the values

$InfoHerb = $HTTP_POST_VARS['InfoHerb'];

if ( $InfoHerb ){
	adr_previous( Adr_Herb_Infos , adr_herbal , '' );}

$template->assign_vars(array(
	'L_CREATE_ITEM' => $lang['Adr_herbalism_create'],
	'L_HERBALISM' => $lang['Adr_forge_herbalism'],
	'L_GO_TO_HERB' => $lang['Adr_herbalism_go_to'],
	'L_HERBALISM_EXPLAIN_AREA' => $lang['Adr_herbalism_explain'],
	'U_CREATE_ITEM' => append_sid("adr_herbal.$phpEx?mode=create"),
	'U_HERBALISM' => append_sid("adr_herbal.$phpEx?mode=herbalism"),
	'S_FORGE_ACTION'=> append_sid("adr_herbal.$phpEx"),
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 
?>
