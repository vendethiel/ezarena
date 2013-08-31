<?php 
/***************************************************************************
 *					adr_cell.php
 *				------------------------
 *	begin 		: 26/02/2004
 *	copyright		: Malicious Rabbit / Dr DLP
 *
 *
 ***************************************************************************/

define('IN_PHPBB', true); 
define('IN_ADR_CELL', true); 
define('CELL', true); 
define('IN_ADR_CHARACTER', true); 

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

adr_template_file('adr_cell_body.tpl');
include_once($phpbb_root_path . 'includes/page_header.'.$phpEx);

$user_id = $userdata['user_id'];
$caution = $userdata['user_cell_caution'];
$pay = isset($HTTP_POST_VARS['submit']);

// Update the time sentence
adr_cell_update_users();

if( $pay )
{
	$sql = "UPDATE " . ADR_JAIL_USERS_TABLE . " 
		SET user_freed_by = $user_id
		WHERE user_id = $user_id ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
	}
	$sql = "DELETE FROM " . ADR_JAIL_VOTES_TABLE . " 
		WHERE vote_id = $user_id ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . USERS_TABLE . " 
		SET user_points = user_points - $caution ,
		user_cell_time = 0 ,
		user_cell_time_judgement = 0 ,
		user_cell_enable_caution = 0,
		user_cell_enable_free = 0,
		user_cell_sentence = '',
		user_cell_caution = 0
		WHERE user_id = $user_id ";
	if ( !($result = $db->sql_query($sql)) )
	{
			message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
	}

	message_die(GENERAL_MESSAGE, $lang['Adr_cell_free']);
}

if ( ( $userdata['user_points'] >= $caution ) && $caution != 0 )
{
	$template->assign_block_vars('is_rich',array());
}

$punishment[1] = $lang['Adr_cell_time_explain'];
$punishment[2] = $lang['Adr_cell_time_explain_posts'];
$punishment[3] = $lang['Adr_cell_time_explain_read'];

$template->assign_vars(array(
	'DAY'                 => $days,
	'HOUR'                => $hours,
	'MINUTE'              => $minutes,
	'CAUTION'             => $caution.'&nbsp;'.get_reward_name(),
	'L_CELL'		      => $lang['Adr_cell_title'],
	'L_CELL_EXPLAIN'	  => $lang['Adr_cell_explain'],
	'L_CELL_TIME'         => $lang['Adr_cell_time'],
	'L_CELL_TIME_EXPLAIN' => $punishment[$userdata['user_cell_punishment']],
	'L_CELLED_TIME'       => adr_make_time($userdata['user_cell_time']),
	'L_CAUTION'           => $lang['Adr_cell_caution'],
	'L_SENTENCE'          => $userdata['user_cell_sentence'],
	'L_CAUTION_PAY'       => $lang['Adr_cell_caution_pay'],
	'S_CELL_ACTION'       => append_sid("adr_cell.$phpEx"),
	
));

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 