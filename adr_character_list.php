<?php 
/***************************************************************************
 *					adr_character_list.php
 *				------------------------
 *	begin 			: 12/02/2004
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
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'character_prefs';
$sub_loc = 'adr_character_list';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$user_id = $userdata['user_id'];

// Get the general settings
$adr_general = adr_get_general_config();
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character_inventory.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

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

adr_template_file('adr_character_list_body.tpl');

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


$mode_types_text = array( $lang['Username'] , $lang['Adr_character'] , $lang['Adr_character_level'] , $lang['Adr_shop_name'] );
$mode_types = array( 'username', 'character_name' , 'level' , 'shop_name' );

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
	case 'username':
		$order_by = "u.username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'character_name':
		$order_by = "c.character_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'level':
		$order_by = "c.character_level $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'shop_name':
		$order_by = "s.shop_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	default:
		$order_by = "u.username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
}

$sql = "SELECT c.* , s.shop_id , s.shop_name , r.race_img , z.zone_name ,
		u.username , u.user_id , u.user_avatar_type , u.user_allowavatar , u.user_avatar
    FROM " . ADR_CHARACTERS_TABLE . " c
  LEFT JOIN " . USERS_TABLE . " u  ON ( u.user_id = c.character_id )
	LEFT JOIN " . ADR_SHOPS_TABLE . " s ON ( s.shop_owner_id = u.user_id )
	LEFT JOIN " . ADR_ZONES_TABLE . " z ON ( z.zone_id = c.character_area )
	LEFT JOIN " . ADR_RACES_TABLE . " r ON ( r.race_id = c.character_race )
	ORDER BY $order_by";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
}

if ( $row = $db->sql_fetchrow($result) )
{
	$i = 0;
	do
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$user_avatar = '';
		if ( $row['user_avatar_type'] && $row['user_allowavatar'] )
		{
			switch( $row['user_avatar_type'] )
			{
				case USER_AVATAR_UPLOAD:
					$user_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
				break;
				case USER_AVATAR_REMOTE:
					$user_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
				break;
				case USER_AVATAR_GALLERY:
					$user_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			}
		}

		$shop_name = ( $row['shop_id'] ) ? $row['shop_name'] : '';
			
		$template->assign_block_vars('characters', array(
			"ROW_CLASS" => $row_class,
			"AVATAR" => $user_avatar,
			"USER_RACE_IMAGE" => '<img src="adr/images/races/' . $row['race_img'] . '" alt="" border="0" />',
			"USER_ZONE" => '<a href="'. append_sid('javascript:Teleport_Popup(\'adr_maps_teleport.'. $phpEx .'?zone='. str_replace("'", "\'", $row['zone_name']) .'\', \'New_Window\', \'800\', \'425\', \'no\')') .'" class="nav">' . $row['zone_name'],
			"USERNAME" => $row['username'],
			"SHOP_NAME" => $shop_name,
			"CHARACTER_NAME" => $row['character_name'],
			"CHARACTER_LEVEL" => $row['character_level'],
			"U_SHOP_NAME" => append_sid("adr_shops.$phpEx?mode=see_shop&amp;shop_id=".$row['shop_id']),
			"U_USERNAME" => append_sid("profile.$phpEx?mode=viewprofile&u=".$row['user_id']),
			"U_CHARACTER_NAME" => append_sid("adr_character.$phpEx?" . POST_USERS_URL ."=".$row['user_id']),
			"U_INVENTORY" => append_sid("adr_character_inventory.$phpEx?" . POST_USERS_URL ."=".$row['user_id']),
		));

		$i++;
	}
	while ( $row = $db->sql_fetchrow($result) );

}

$sql = "SELECT count(*) AS total FROM " . ADR_CHARACTERS_TABLE ;
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
}
if ( $total = $db->sql_fetchrow($result) )
{
	$total_users = $total['total'];
	$pagination = generate_pagination("adr_character_list.$phpEx?".POST_USERS_URL."=$searchid&amp;mode2=$mode2&amp;order=$sort_order", $total_users, $board_config['topics_per_page'], $start). '&nbsp;';	
}

$template->assign_vars(array(	
	'L_SHOP_NAME' => $lang['Adr_shop_name'],
	'L_CHARACTER_NAME' => $lang['Adr_character'],
	'L_USERNAME' => $lang['Username'],
	'L_ZONE_LOCATION' => 'Zone',
	'L_LEVEL' => $lang['Adr_character_level'],
	'L_ITEMS' => $lang['Adr_inventory_page_name'],
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'L_ORDER' => $lang['Order'],
	'L_SORT' => $lang['Sort'],

	'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
	'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
	'L_COPYRIGHT' => $lang['Adr_copyright'],
	'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
	'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
	'U_TOWNBOUTONRETOUR' => append_sid("adr_TownMap.$phpEx"),

	'S_MODE_SELECT' => $select_sort_mode,
	'S_ORDER_SELECT' => $select_sort_order,
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_users / $board_config['topics_per_page'] )), 
	'L_GOTO_PAGE' => $lang['Goto_page'],
	"S_LIST_ACTION" => append_sid("adr_character_list.$phpEx?".POST_USERS_URL."=$searchid&amp;mode2=$mode2&amp;order=$sort_order"),
	"S_HIDDEN_FIELDS" => $s_hidden_fields, 
));


include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);




$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 
