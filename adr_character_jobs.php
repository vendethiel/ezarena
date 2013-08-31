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

$loc = 'character';
$sub_loc = 'adr_character_jobs';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

adr_template_file('adr_character_jobs_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character_jobs.$phpEx";
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


$mode_types_text = array( $lang['Adr_character'] , $lang['Adr_character_level'] , $lang['Adr_job_list_name'] , $lang['Adr_job_list_salary'] , $lang['Adr_job_list_total_earnings'] , $lang['Adr_job_list_completed'] );
$mode_types = array( 'character_name' , 'level' , 'job_name' , 'job_salary' , 'character_total_earned' , 'character_completed' );

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
	case 'character_name':
		$order_by = "c.character_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'character_level':
		$order_by = "c.character_level $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'job_name':
		$order_by = "j.job_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'job_salary':
		$order_by = "j.job_salary $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'character_total_earned':
		$order_by = "c.character_job_total_earned $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'character_completed':
		$order_by = "c.character_job_completed $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	default:
		$order_by = "c.character_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
}

$sql = "SELECT c.*, j.*, u.user_id FROM " . ADR_CHARACTERS_TABLE . " c
		LEFT JOIN " . ADR_JOB_TABLE . " j ON ( j.job_id = c.character_job_id )
		LEFT JOIN " . USERS_TABLE . " u ON ( u.user_id = c.character_id )
		WHERE c.character_job_id <> 0
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
		$image = $row['job_img'] != '' ? '<img src="adr/images/jobs/'.$row['job_img'].'">' : '' ;
		$completed = $row['character_job_completed'] != 0 ? round(($row['character_job_completed'] / $row['character_job_times_employed']) * 100) : 0 ;
		$days_remaining = ceil(( $row['character_job_end'] - time() ) / 86400 ) ;
			
		$template->assign_block_vars('characters', array(
			"ROW_CLASS" => $row_class,
			"JOB_NAME" => adr_get_lang($row['job_name']),
			"JOB_SALARY" => number_format($row['job_salary']),
			"JOB_TOTAL_EARNED" => number_format($row['character_job_total_earned']),
			"JOB_IMG" => $image,
			"CHARACTER_NAME" => $row['character_name'],
			"CHARACTER_LEVEL" => $row['character_level'],
			"CHARACTER_DURATION" => $days_remaining,
			"CHARACTER_TOTAL_JOBS" => $row['character_job_times_employed'],
			"CHARACTER_COMPLETED" => $completed,
			"U_CHARACTER_NAME" => append_sid("adr_character.$phpEx?" . POST_USERS_URL ."=".$row['user_id']),
		));

		$i++;
	}
	while ( $row = $db->sql_fetchrow($result) );

}

$sql = "SELECT count(*) AS total FROM " . ADR_CHARACTERS_TABLE . "
		WHERE character_job_id <> 0";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
}
if ( $total = $db->sql_fetchrow($result) )
{
	$total_users = $total['total'];
	$pagination = generate_pagination("adr_character_jobs.$phpEx?".POST_USERS_URL."=$searchid&amp;mode2=$mode2&amp;order=$sort_order", $total_users, $board_config['topics_per_page'], $start). '&nbsp;';	
}

$template->assign_vars(array(	
	'POINTS' => $board_config['points_name'],
	'L_CHARACTER_NAME' => $lang['Adr_character'],
	'L_LEVEL' => $lang['Adr_character_level'],
	'L_JOB_NAME' => $lang['Adr_job_list_name'],
	'L_JOB_COMPLETED' => $lang['Adr_job_list_completed'],
	'L_JOB_TOTAL_EARNED' => $lang['Adr_job_list_total_earnings'],
	'L_JOB_SALARY' => $lang['Adr_job_list_salary'],
	'L_JOB_DURATION' => $lang['Adr_job_list_duration'],
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'L_ORDER' => $lang['Order'],
	'L_SORT' => $lang['Sort'],
	'S_MODE_SELECT' => $select_sort_mode,
	'S_ORDER_SELECT' => $select_sort_order,
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_users / $board_config['topics_per_page'] )), 
	'L_GOTO_PAGE' => $lang['Goto_page'],
	"S_LIST_ACTION" => append_sid("adr_character_jobs.$phpEx?".POST_USERS_URL."=$searchid&amp;mode2=$mode2&amp;order=$sort_order"),
	"S_HIDDEN_FIELDS" => $s_hidden_fields, 
));


include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 