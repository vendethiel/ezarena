<?php 
/***************************************************************************
 *					adr_jobs.php
 *				------------------------
 *	begin 		: 09/11/2004
 *	copyright		: Seteo-Bloke
 *
 *
 ***************************************************************************/

define('IN_PHPBB', true); 
define('IN_ADR_CHARACTER', true); 
define('IN_ADR_SHOPS', true);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_town';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

adr_template_file('adr_jobs_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_jobs.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

$user_id = $userdata['user_id'];

// Get the general config
$adr_general = adr_get_general_config();

// Standard checks
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

// Check jobs are enabled by admin
if ( $adr_general['job_salary_enable'] != 1 )
{
	adr_previous( Adr_job_closed , adr_town , '' );
}

// Fix values
$apply = isset($HTTP_POST_VARS['apply']);
$quit = isset($HTTP_POST_VARS['quit']);

// Grab character details
$sql = "SELECT * FROM " . ADR_CHARACTERS_TABLE . "
	WHERE character_id = $user_id";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query user stats page', '', __LINE__, __FILE__, $sql);
}
$character = $db->sql_fetchrow($result);

$actual_zone = $character['character_area'];

$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_id = $actual_zone ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$info = $db->sql_fetchrow($result);
$access = $info['zone_jobs'];

if ( $access == '0' )
	adr_previous( Adr_zone_building_noaccess , adr_zones , '' );

if( $apply )
{
	$apply_id = intval($HTTP_POST_VARS['apply_select']);

	// Grab job details
	$sql = " SELECT * FROM " . ADR_JOB_TABLE . "
		WHERE job_id = $apply_id";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query user stats page', '', __LINE__, __FILE__, $sql);
	}
	$job = $db->sql_fetchrow($result);

	if ( $job['job_race_id'] != 0 )
	{
		if ( $job['job_race_id'] != $character['character_race'] )
		{
			adr_previous( Adr_job_wrong_race , 'adr_jobs' , '' );
		}
	}

	if ( $job['job_class_id'] != 0 )
	{
		if ( $job['job_class_id'] != $character['character_class'] )
		{
			adr_previous( Adr_job_wrong_class , 'adr_jobs' , '' );
		}
	}

	if ( $job['job_alignment_id'] != 0 )
	{
		if ( $job['job_alignment_id'] != $character['character_alignment'] )
		{
			adr_previous( Adr_job_wrong_alignment , 'adr_jobs' , '' );
		}
	}

	if ( $job['job_level'] != 0 )
	{
		if ( $job['job_level'] > $character['character_level'] )
		{
			adr_previous( Adr_job_wrong_level , 'adr_jobs' , '' );
		}
	}

	if ( $job['job_slots_available'] < 1 )
	{
		$message = sprintf($lang['Adr_job_none_left'] , $job['job_name'] );
		$message .= '<br /><br />'.sprintf($lang['Adr_job_return'] ,"<a href=\"" . 'adr_jobs.'.$phpEx . "\">", "</a>") ;
		message_die ( GENERAL_MESSAGE , $message );
	}

	// Remove a job slot
	$dsql = "UPDATE " . ADR_JOB_TABLE . "
		SET job_slots_available = job_slots_available - 1
		WHERE job_id = $apply_id ";
	if ( !($dresult = $db->sql_query($dsql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Failed updating the job slots' , "", __LINE__, __FILE__, $csql); 
	}

	// Work out job duration
	$current_time = time();
	$end_days = $current_time + ( $job['job_duration'] * 86400 );

	// Update the job to the character
	$dsql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_job_id = $apply_id,
			character_job_start = $current_time,
			character_job_end = $end_days,
			character_job_last_paid = $current_time,
			character_job_times_employed = character_job_times_employed + 1
		WHERE character_id = $user_id ";
	if ( !($dresult = $db->sql_query($dsql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Failed updating job to character table' , "", __LINE__, __FILE__, $csql); 
	}

	$message = sprintf($lang['Adr_job_accept'] , $job['job_name'] );
	$message .= '<br /><br />'.sprintf($lang['Adr_job_return'] ,"<a href=\"" . 'adr_jobs.'.$phpEx . "\">", "</a>") ;
	message_die ( GENERAL_MESSAGE , $message );
}

if( $quit )
{
	$quit_id = $character['character_job_id'];

	// Grab job details
	$sql = " SELECT * FROM " . ADR_JOB_TABLE . "
		WHERE job_id = $quit_id";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query user stats page', '', __LINE__, __FILE__, $sql);
	}
	$job = $db->sql_fetchrow($result);

	$job_slots = ( $job['job_slots_available'] + 1 ) > $job['job_slots_max'] ? $job['job_slots_max'] : $job['job_slots_available'] + 1;

	// Add job slot back
	$dsql = "UPDATE " . ADR_JOB_TABLE . "
		SET job_slots_available = '$job_slots'
		WHERE job_id = $quit_id ";
	if ( !($dresult = $db->sql_query($dsql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Error updating job slots' , "", __LINE__, __FILE__, $csql); 
	}

	// Update the job to the character
	$dsql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_job_id = 0,
			character_job_start = 0,
			character_job_end = 0,
			character_job_incomplete = character_job_incomplete + 1
		WHERE character_id = $user_id ";
	if ( !($dresult = $db->sql_query($dsql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Error updating character table' , "", __LINE__, __FILE__, $csql); 
	}

	$message = sprintf($lang['Adr_job_quit'] , $job['job_name'] );
	$message .= '<br /><br />'.sprintf($lang['Adr_job_return'] ,"<a href=\"" . 'adr_jobs.'.$phpEx . "\">", "</a>") ;
	message_die ( GENERAL_MESSAGE , $message );
}

// Check if user is currently employed & show stats
if ( $character['character_job_id'] != 0 )
{
	$job_id = $character['character_job_id'];

	// Grab job details
	$sql = " SELECT * FROM " . ADR_JOB_TABLE . "
		WHERE job_id = $job_id";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query user stats page', '', __LINE__, __FILE__, $sql);
	}
	$job_details = $db->sql_fetchrow($result);

	$image = $job_details['job_img'] != '' ? '<img src="adr/images/jobs/'.$job_details['job_img'].'">' : '' ;
	$days_remaining = ceil(( $character['character_job_end'] - time() ) / 86400 ) ;

	$template->assign_block_vars('employed', array(
		'EMPLOYED' 			=> $job_details['job_name'],
		'EMPLOYED_SALARY'		=> number_format($job_details['job_salary']),
		'EMPLOYED_EARNED'		=> number_format($character['character_job_earned']),
		'EMPLOYED_IMG'		=> $image,
		'EMPLOYED_DAYS_LEFT'	=> $days_remaining,
		'JOB_ID'			=> $job_id,
		'L_EMPLOYED_TIMES'	=> sprintf($lang['Adr_job_times_employed'] , $character['character_job_times_employed']),
	));
}
else
{
	$template->assign_block_vars('non_employed', array(

	));	
}

// Check auth level of user
if ( $userdata['user_level'] == ADMIN )
{
	$sql_level = '';
}
else if ( $userdata['user_level'] == MOD )
{
	$sql_level = 'WHERE job_auth_level <> 1';
}
else
{
	$sql_level = 'WHERE job_auth_level = 0';
}


// START categories & pagination
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

if ( isset($HTTP_GET_VARS['mode2']) || isset($HTTP_POST_VARS['mode2']) )
{
	$mode2 = ( isset($HTTP_POST_VARS['mode2']) ) ? htmlspecialchars($HTTP_POST_VARS['mode2']) : htmlspecialchars($HTTP_GET_VARS['mode2']);
}
else
{
	$mode2 = 'itemname';
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

if ( isset($HTTP_GET_VARS['cat']) || isset($HTTP_POST_VARS['cat']) )
{
	$cat = ( isset($HTTP_POST_VARS['cat']) ) ? htmlspecialchars($HTTP_POST_VARS['cat']) : htmlspecialchars( $HTTP_GET_VARS['cat']);
}
else
{
	$cat = 0;
}
$cat_sql = ( $cat ) ? 'AND m.monster_name = '.$cat : '';

$mode_types_text = array( $lang['Adr_job_name'] , $lang['Adr_job_level'] , $lang['Adr_job_alignment'], $lang['Adr_job_class'], $lang['Adr_job_race'] );
$mode_types = array( 'name', 'level' , 'alignment' , 'class' , 'race' );

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
	case 'name':
		$order_by = "j.job_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'level':
		$order_by = "j.job_level $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'alignment':
		$order_by = "j.job_alignment_id $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'class':
		$order_by = "j.job_class_id $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	case 'race':
		$order_by = "j.job_race_id $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
	default:
		$order_by = "j.job_level $sort_order LIMIT $start, " . $board_config['topics_per_page'];
		break;
}

// Show all jobs in list
$sql = "SELECT j.*, c.class_id, c.class_name, r.race_id, r.race_name, a.alignment_id, a.alignment_name FROM " . ADR_JOB_TABLE . " j
		LEFT JOIN " . ADR_CLASSES_TABLE . " c ON ( c.class_id = j.job_class_id )
		LEFT JOIN " . ADR_RACES_TABLE . " r ON ( r.race_id = j.job_race_id )
		LEFT JOIN " . ADR_ALIGNMENTS_TABLE . " a ON ( a.alignment_id = j.job_alignment_id )
		$sql_level
		$cat_sql
		ORDER BY $order_by ";
if ( !($result = $db->sql_query($sql)) ) 
{ 
	message_die(GENERAL_ERROR, 'Error showing all job list' , "", __LINE__, __FILE__, $sql); 
} 
$jobs = $db->sql_fetchrowset($result);
for( $i = 0; $i < count($jobs); $i++ )
{
	// Grab item reward details
	$sql = " SELECT item_name FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = 1
		AND item_id = '".$jobs[$i]['job_item_reward_id']."' ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query user stats page', '', __LINE__, __FILE__, $sql);
	}
	$item = $db->sql_fetchrow($result);

	$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2']; 
	$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2']; 

	$class = $jobs[$i]['job_class_id'] != 0 ? adr_get_lang($jobs[$i]['class_name']) : $lang['Adr_job_all_classes'];
	$race = $jobs[$i]['job_race_id'] != 0 ? adr_get_lang($jobs[$i]['race_name']) : $lang['Adr_job_all_classes'];
	$alignment = $jobs[$i]['job_alignment_id'] != 0 ? adr_get_lang($jobs[$i]['alignment_name']) : $lang['Adr_job_all_classes'];
	$image = $jobs[$i]['job_img'] != '' ? '<img src="adr/images/jobs/'.$jobs[$i]['job_img'].'">' : '' ;
	$item_reward = $jobs[$i]['job_item_reward_id'] != 0 ? adr_get_lang($item['item_name']) : $lang['Adr_job_no_item_reward'];
	$interval_lang = $jobs[$i]['job_payment_intervals'] > 1 ? $lang['Adr_job_days'] : $lang['Adr_job_day'];
	$duration_lang = $jobs[$i]['job_duration'] > 1 ? $lang['Adr_job_days'] : $lang['Adr_job_day'];

	$template->assign_block_vars('jobs', array(
		'ROW_CLASS'		=> $row_class, 
		'JOB_ID'		=> $jobs[$i]['job_id'],
		'JOB_IMG'		=> $image,
		'JOB_NAME'		=> adr_get_lang($jobs[$i]['job_name']),
		'JOB_DESC'		=> adr_get_lang($jobs[$i]['job_desc']),
		'JOB_LEVEL'		=> $jobs[$i]['job_level'],
		'JOB_CLASS'		=> $class,
		'JOB_RACE'		=> $race,
		'JOB_ALIGNMENT'	=> $alignment,
		'JOB_SALARY'	=> number_format($jobs[$i]['job_salary']),
		'JOB_SALARY_INT'	=> number_format($jobs[$i]['job_payment_intervals']),
		'L_JOB_INT_LANG'	=> $interval_lang,
		'JOB_DURATION'	=> $jobs[$i]['job_duration'],
		'L_JOB_DURA_LANG' => $duration_lang,
		'JOB_SLOTS'		=> $jobs[$i]['job_slots_available'],
		'JOB_SLOTS_MAX'	=> $jobs[$i]['job_slots_max'],
		'JOB_EXP'		=> number_format($jobs[$i]['job_exp']),
		'JOB_ITEM_REWARD'	=> $item_reward,
		'JOB_SP_REWARD'	=> number_format($jobs[$i]['job_sp_reward']),
	));

	if ( $character['character_job_id'] == 0 )
	{
		$template->assign_block_vars('jobs.not_employed', array(
		));
	}
}

// Show apply if not emaployed
if ( $character['character_job_id'] == 0 )
{
	$template->assign_block_vars('apply', array(
	));
}

// START pagination
$sql = "SELECT count(*) AS total FROM " . ADR_JOB_TABLE . "
		$sql_level ";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
}
if ( $total = $db->sql_fetchrow($result) )
{
	$total_items = $total['total'];
	$pagination = generate_pagination("adr_jobs.$phpEx?mode2=$mode2&amp;order=$sort_order&amp;cat=$cat", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';	
}
//  END pagination


$template->assign_vars(array(
	'POINTS'			=> $board_config['points_name'],
	'EMPLOYED_TOTAL'		=> number_format($character['character_job_total_earned']),
	'EMPLOYED_TIMES'		=> $character['character_job_times_employed'],
	'EMPLOYED_COMPLETED'	=> $character['character_job_completed'],
	'EMPLOYED_INCOMPLETE'	=> $character['character_job_incomplete'],
	'L_EMPLOYED_DAYS_LEFT'	=> $lang['Adr_job_days_remaining'],
	'L_EMPLOYED_TIMES'	=> $lang['Adr_job_times_employed'],
	'L_PERSONAL_STATS'	=> $lang['Adr_job_personal_stats'],
	'L_NON_EMPLOYED'		=> $lang['Adr_job_non_employed'],
	'L_EMPLOYED'		=> $lang['Adr_job_employed'],
	'L_EMPLOYED_TOTAL'	=> $lang['Adr_job_employed_total_earned'],
	'L_EMPLOYED_SALARY'	=> $lang['Adr_job_employed_salary'],
	'L_EMPLOYED_EARNED'	=> $lang['Adr_job_employed_total'],
	'L_EMPLOYED_COMPLETED'	=> $lang['Adr_job_employed_completed'],
	'L_EMPLOYED_INCOMPLETE'	=> $lang['Adr_job_employed_incomplete'],
	'L_JOB_TITLE'		=> $lang['Adr_job_title'],
	'L_JOB_NAME'		=> $lang['Adr_job_name'],
	'L_JOB_DESC'		=> $lang['Adr_job_desc'],
	'L_JOB_LEVEL'		=> $lang['Adr_job_level'],
	'L_JOB_RACE'		=> $lang['Adr_job_race'],
	'L_JOB_CLASS'		=> $lang['Adr_job_class'],
	'L_JOB_ALIGNMENT'		=> $lang['Adr_job_alignment'],
	'L_JOB_SALARY'		=> $lang['Adr_job_salary'],
	'L_JOB_SALARY_INTERVALS' => $lang['Adr_job_salary_intervals'],
	'L_JOB_DURATION'		=> $lang['Adr_job_duration'],
	'L_JOB_SLOTS'		=> $lang['Adr_job_slots'],
	'L_JOB_SLOTS_MAX'		=> $lang['Adr_job_slots_max'],
	'L_JOB_EXP'			=> $lang['Adr_job_exp'],
	'L_JOB_ITEM_REWARD'	=> $lang['Adr_job_item_reward'],
	'L_JOB_SP_REWARD'		=> $lang['Adr_job_sp_reward'],
	'L_SELECT_SORT_METHOD' 	=> $lang['Select_sort_method'],
	'L_ORDER' 			=> $lang['Order'],
	'L_SORT' 			=> $lang['Sort'],
	'L_SORT_SUBMIT' 		=> $lang['Sort'],
	'L_SELECT_CAT' 		=> $lang['Adr_items_select'],
	'L_GOTO_PAGE' 		=> $lang['Goto_page'],
	'SELECT_CAT' 		=> $select_category,
	'PAGINATION' 		=> $pagination,
	'PAGE_NUMBER' 		=> sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )), 
	'S_MODE_SELECT' 		=> $select_sort_mode,
	'S_ORDER_SELECT' 		=> $select_sort_order,
	'S_JOB_ACTION'		=> append_sid("adr_jobs.$phpEx"),
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 