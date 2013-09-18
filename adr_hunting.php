<?php
/***************************************************************************
 *               adr_hunting.php
 *            ------------------------
 *  begin           : 06/29/2006
 *	copyright		: ShadowTek
 *  modded			: FantasyKnight5
 *  re-modded       : Makien         
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
define('IN_ADR_HUNTING', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_CHARACTER', true);
define('IN_TOWNMAP_INFOBOX', true);
define('IN_ADR_TOWNMAP', true);
define('IN_ADR_LOOTTABLES', true);

$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_hunting';

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
   $redirect = "adr_hunting.$phpEx";
   $redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
   header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_hunting_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

// Grab details for skill limit
$sql = " SELECT character_skill_limit, character_area FROM " . ADR_CHARACTERS_TABLE . "
      WHERE character_id = $user_id ";
if( !($result = $db->sql_query($sql)) ){
   message_die(GENERAL_ERROR, 'Could not query skill limit value', '', __LINE__, __FILE__, $sql);}
$limit_update = $db->sql_fetchrow($result);

$actual_zone = $limit_update['character_area'];

$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_id = $actual_zone ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$info = $db->sql_fetchrow($result);
$access = $info['zone_hunting'];

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
      case 'hunting' :

         $template->assign_block_vars('hunting',array());
         $sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
            WHERE item_owner_id = $user_id
            AND item_in_shop = 0
            AND item_in_warehouse = 0
            AND item_duration > 0
            AND item_type_use = 28 ";
         if ( !($result = $db->sql_query($sql))) {
            message_die(GENERAL_ERROR, 'Could not check user tools',"", __LINE__, __FILE__, $sql); }
         $tools = $db->sql_fetchrowset($result);
      
         $tool_list = '<select name="item_tool">';
         $tool_list .= '<option value = "0" >' . $lang['Adr_forge_hunting_no_tool'] . '</option>';

         for ( $i = 0 ; $i < count($tools) ; $i ++ )
         {
            $tool_list .= '<option value = "'.$tools[$i]['item_id'].'" >' . adr_get_lang($tools[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $tools[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $tools[$i]['item_duration'] . ' )'.'</option>';
         }
         $tool_list .= '</select>';

         $template->assign_vars(array(
            'TOOL_LIST' => $tool_list,
            'L_SELECT_TOOL' => $lang['Adr_forge_hunting_select_tool'],
            'L_GO_HUNTING' => $lang['Adr_forge_hunting_go'],
            'L_HUNTING_EXPLAIN' => $lang['Adr_forge_hunting_explain'],
         ));
         break;

      case 'hunting_action' :
         
         $tool = intval($HTTP_POST_VARS['item_tool']);

         // No tool , no hunting
         if ( !$tool )
         {
            adr_previous ( Adr_forge_hunting_tool_needed , adr_hunting , "mode=hunting" );
         }
         else
         {  
           //Tool gets used even if character doesn't find anything
           adr_use_item($tool , $user_id);
            $item = drop_gather_loot($actual_zone, $user_id, 'hunting', 11);

            if ( !$item )
            {
               include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
               $direction = append_sid("adr_hunting.$phpEx?mode=hunting");
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

$InfoHunt = $HTTP_POST_VARS['InfoHunt'];

if ( $InfoHunt ){
	adr_previous( Adr_Hunt_Infos , adr_hunting , '' );}
$template->assign_vars(array(
   'L_CREATE_ITEM' => $lang['Adr_hunting_create'],
   'L_HUNTING' => $lang['Adr_forge_hunting'],
   'L_GO_TO_HUNT' => $lang['Adr_hunting_go_to'],
   'L_HUNTING_EXPLAIN_AREA' => $lang['Adr_hunting_explain'],
   'U_CREATE_ITEM' => append_sid("adr_hunting.$phpEx?mode=create"),
   'U_HUNTING' => append_sid("adr_hunting.$phpEx?mode=hunting"),
   'S_FORGE_ACTION'=> append_sid("adr_hunting.$phpEx"),
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 
?>