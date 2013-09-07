<?php 
/***************************************************************************
 *					adr_character_jobs.php
 *				------------------------
 *	begin 			: 14/11/2004
 *	copyright			: Seteo-Bloke
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
define('IN_ADR_SHOPS', true); 
define('IN_ADR_CHARACTER', true);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_functions_armour_sets.'.$phpEx);

$loc = 'character';
$sub_loc = 'adr_character_armour_sets';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 
// End session management
//

adr_template_file('adr_character_armour_sets_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character_armour_sets.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

$user_id = $userdata['user_id'];

// Get the general settings
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

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

if ( isset($HTTP_GET_VARS['mode2']) || isset($HTTP_POST_VARS['mode2']) )
{
	$mode2 = ( isset($HTTP_POST_VARS['mode2']) ) ? htmlspecialchars($HTTP_POST_VARS['mode2']) : htmlspecialchars($HTTP_GET_VARS['mode2']);
}
else
{
	$mode2 = 'username';
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


$mode_types_text = array( $lang['Adr_set_name'] );
$mode_types = array( 'set_name' );

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
	case 'set_name':
		$order_by = "set_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	default:
		$order_by = "set_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
}

$sql = "SELECT * FROM " . ADR_ARMOUR_SET_TABLE . "
		ORDER BY $order_by";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
}

if ( $sets = $db->sql_fetchrow($result) )
{
	$i = 0;
	do
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		$image = $sets['set_img'] != '' ? '<img src="adr/images/sets/'.$sets['set_img'].'">' : '' ;
			
		$template->assign_block_vars('sets', array(
			"ROW_CLASS" => $row_class,
			"SET_ID"                => $sets['set_id'],
			"SET_IMG"                => $image,
			"SET_NAME"                => $sets['set_name'],
			"SET_DESC"                => $sets['set_desc'],
			"SET_HELM"                => adr_get_lang($sets['set_helm']),
			"SET_ARMOUR"        => adr_get_lang($sets['set_armour']),
			"SET_GLOVES"        => adr_get_lang($sets['set_gloves']),
			"SET_SHIELD"        => adr_get_lang($sets['set_shield']),
			"SET_MIGHT_BONUS"        => $sets['set_might_bonus'],
			"SET_CON_BONUS"        => $sets['set_constitution_bonus'],
			"SET_AC_BONUS"        => $sets['set_ac_bonus'],
			"SET_DEX_BONUS"        => $sets['set_dexterity_bonus'],
			"SET_INT_BONUS"        => $sets['set_intelligence_bonus'],
			"SET_WIS_BONUS"        => $sets['set_wisdom_bonus'],
			"SET_MIGHT_PEN"        => $sets['set_might_penalty'],
			"SET_CON_PEN"        => $sets['set_constitution_penalty'],
			"SET_AC_PEN"        => $sets['set_ac_penalty'],
			"SET_DEX_PEN"        => $sets['set_dexterity_penalty'],
			"SET_INT_PEN"        => $sets['set_intelligence_penalty'],
			"SET_WIS_PEN"        => $sets['set_wisdom_penalty'],
		));

		$i++;
	}
	while ( $sets = $db->sql_fetchrow($result) );

}

$sql = "SELECT count(*) AS total FROM " . ADR_ARMOUR_SET_TABLE;
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
}
if ( $total = $db->sql_fetchrow($result) )
{
	$total_users = $total['total'];
	$pagination = generate_pagination("adr_character_armour_sets.$phpEx?".POST_USERS_URL."=$searchid&amp;mode2=$mode2&amp;order=$sort_order", $total_users, $board_config['topics_per_page'], $start). '&nbsp;';	
}

$template->assign_vars(array(	
	'POINTS' => get_reward_name(),
	'L_SET_HELM' 		=> $lang['Adr_set_helm'],
	'L_SET_ARMOUR'                 => $lang['Adr_set_armour'],
	'L_SET_GLOVES'                 => $lang['Adr_set_gloves'],
	'L_SET_SHIELD'                 => $lang['Adr_set_shield'],
	'L_SET_MIGHT_BONUS'        => $lang['Adr_set_might_bonus'],
	'L_SET_CON_BONUS'         => $lang['Adr_set_con_bonus'],
	'L_SET_AC_BONUS'                 => $lang['Adr_set_ac_bonus'],
	'L_SET_DEX_BONUS'         => $lang['Adr_set_dex_bonus'],
	'L_SET_INT_BONUS'         => $lang['Adr_set_int_bonus'],
	'L_SET_WIS_BONUS'                => $lang['Adr_set_wis_bonus'],
	'L_SET_MIGHT_PEN'                => $lang['Adr_set_might_pen'],
	'L_SET_CON_PEN'                 => $lang['Adr_set_con_pen'],
	'L_SET_AC_PEN'                 => $lang['Adr_set_ac_pen'],
	'L_SET_DEX_PEN'                 => $lang['Adr_set_dex_pen'],
	'L_SET_INT_PEN'                 => $lang['Adr_set_int_pen'],
	'L_SET_WIS_PEN'                => $lang['Adr_set_wis_pen'],
	'L_SET_IMG'             => $lang['Adr_races_image'],
	'L_SET_IMG_EXPLAIN'	=> $lang['Adr_set_img_explain'],
	'L_SELECT_SORT_METHOD' 	=> $lang['Select_sort_method'],
	'L_ORDER' 			=> $lang['Order'],
	'L_SORT' 			=> $lang['Sort'],
	'S_MODE_SELECT' 		=> $select_sort_mode,
	'S_ORDER_SELECT' 		=> $select_sort_order,
	'PAGINATION' 		=> $pagination,
	'PAGE_NUMBER' 		=> sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_users / $board_config['topics_per_page'] )), 
	'L_GOTO_PAGE' 		=> $lang['Goto_page'],
	"S_LIST_ACTION" 		=> append_sid("adr_character_armour_sets.$phpEx?".POST_USERS_URL."=$searchid&amp;mode2=$mode2&amp;order=$sort_order"),
	"S_HIDDEN_FIELDS" 		=> $s_hidden_fields, 
));


include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 