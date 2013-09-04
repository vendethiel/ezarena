<?php
/***************************************************************************
 *                           adr_cheat_moderate.php
 *                           ----------------------
 *		Version			: 0.2.0
 *		Email			: GOster@OzziesWorld.com
 *		Site			: http://www.OzziesWorld.com
 *
 ***************************************************************************/

define('IN_PHPBB', TRUE);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_CELL', true);
define('IN_ADR_ZONES', true);
define('IN_ADR_CHEAT', true);
$phpbb_root_path = './';
include_once($phpbb_root_path .'extension.inc');
include_once($phpbb_root_path .'common.'. $phpEx);

$loc = 'character_prefs';
$sub_loc = 'adr_cheat_log';

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

$user_id = $userdata['user_id'];

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_cheat_log.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

adr_template_file('adr_cheat_moderate_body.tpl');

$submit = isset($HTTP_POST_VARS['submit']);
$ban_board = isset($HTTP_POST_VARS['ban_board']);
$ban_adr = isset($HTTP_POST_VARS['ban_adr']);

// Get the general settings
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);

if( isset($HTTP_POST_VARS['u']) || isset($HTTP_GET_VARS['u']) )
{
	$jailed_userid  = ( isset($HTTP_POST_VARS['u']) ) ? $HTTP_POST_VARS['u'] : $HTTP_GET_VARS['u'];
	$jailed_userid  = intval($jailed_userid);
}
if( isset($HTTP_POST_VARS['cheat']) || isset($HTTP_GET_VARS['cheat']) )
{
	$jailed_cheat_type = ( isset($HTTP_POST_VARS['cheat']) ) ? $HTTP_POST_VARS['cheat'] : $HTTP_GET_VARS['cheat'];
	$jailed_cheat_type = intval($jailed_cheat_type);
}

if( isset($HTTP_POST_VARS['cheat_id']) || isset($HTTP_GET_VARS['cheat_id']) )
{
	$cheat_id  = ( isset($HTTP_POST_VARS['cheat_id']) ) ? $HTTP_POST_VARS['cheat_id'] : $HTTP_GET_VARS['cheat_id'];
	$cheat_id  = intval($cheat_id);
}

$adr_moderators = explode( ',' , $board_config['zone_adr_moderators'] );

if ( !in_array( $user_id , $adr_moderators ) &&  $userdata['user_level'] != ADMIN )
	adr_previous( Adr_cell_not_authorized_view , adr_cheat_log , '' );

if( $submit )
{
	$celled_id = $jailed_userid;

	if (!$celled_id)
	{
		message_die(GENERAL_ERROR, 'No User Selected!', 'Error');
	}
	#==== End: Add By aUsTiN =============================== |
	#======================================================= |

	$time_day 			= intval( $HTTP_POST_VARS['time_day'] );
	$time_hour 			= intval( $HTTP_POST_VARS['time_hour'] );
	$time_minute 		= intval( $HTTP_POST_VARS['time_minute'] );
	$caution 			= intval( $HTTP_POST_VARS['caution'] );
	$cautionable 		= intval( $HTTP_POST_VARS['cautionable'] );
	$freeable 			= intval( $HTTP_POST_VARS['freeable'] );
	$punishment 		= intval( $HTTP_POST_VARS['punishment'] );
	$sentence 			= addslashes(stripslashes( $HTTP_POST_VARS['sentence'] ));

	if ( ( $time_day == '' && $time_hour == '' && $time_minute == '' ) || !$punishment )
	{
		message_die(MESSAGE, $lang['Fields_empty']);
	}

// Modified for ADR Zones Test Board
if ($userdata['user_level'] == ADMIN)
{
	adr_cell_imprison_user($celled_id,$time_day,$time_hour,$time_minute,$caution,$cautionable,$freeable,$sentence,$punishment);

	$sql = "SELECT * FROM " . ADR_CHEAT_LOG_TABLE . "
			WHERE cheat_id = '$cheat_id'";
	$result	= $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, "Couldn't get cheat log info", "", __LINE__, __FILE__, $sql);

	$cheat_info = $db->sql_fetchrow($result);

	$cheat_punishment_array = explode( '~' , $cheat_info['cheat_punished'] );
	$cheat_punishment_array[2] = '1';
	$cheat_punishment_array[3] = $lang['Adr_zone_cheat_log_imprisoned_for'];
	if ( $time_day )
	{
	    if ( $time_day > 1 )
	        $cheat_punishment_array[3] .= $time_day . $lang['Adr_zone_cheat_log_days'];
		else
		    $cheat_punishment_array[3] .= $time_day . $lang['Adr_zone_cheat_log_day'];
	}
	if ( $time_hour )
	{
	    if ( $time_day )
	    {
	        if ( $time_minute )
	        	$cheat_punishment_array[3] .= ', ';
			else
	        	$cheat_punishment_array[3] .= $lang['Adr_zone_cheat_log_and'];
		}
	    if ( $time_hour > 1 )
	        $cheat_punishment_array[3] .= $time_hour . $lang['Adr_zone_cheat_log_hours'];
		else
		    $cheat_punishment_array[3] .= $time_hour . $lang['Adr_zone_cheat_log_hour'];
	}
	if ( $time_minute )
	{
		if ( $time_hour && $time_day )
		    $cheat_punishment_array[3] .= $lang['Adr_zone_cheat_log_comma_and'];
		else if ( ( !$time_hour && $time_day ) || ( $time_hour && !$time_day ) )
		    $cheat_punishment_array[3] .= $lang['Adr_zone_cheat_log_and'];
	    if ( $time_minute > 1 )
	        $cheat_punishment_array[3] .= $time_hour . $lang['Adr_zone_cheat_log_minutes'];
		else
		    $cheat_punishment_array[3] .= $time_hour . $lang['Adr_zone_cheat_log_minute'];
	}

	$cheat_punishment = '';
	for ( $x = 0 ; $x < 4 ; $x++ )
	{
		if ( $x < 3 )
		{
			if ( $cheat_punishment_array[$x] == '' )
			    $cheat_punishment .= '0~';
			else
				$cheat_punishment .= $cheat_punishment_array[$x] . '~';
		}
		else
   			$cheat_punishment .= $cheat_punishment_array[$x];
	}

	$sql = "UPDATE " . ADR_CHEAT_LOG_TABLE . "
			SET cheat_punished = '$cheat_punishment'
	        WHERE cheat_id = '$cheat_id'";
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, "Couldn't UPDATE ADR User Ban", "", __LINE__, __FILE__, $sql);
}
// Modified for ADR Zones Test Board
else if ($submit && $userdata['user_level'] != ADMIN)
{
	$message = 'You are unable to change settings!!  You are ONLY allowed to view the Zone MOD ACP Settings!';
	message_die(GENERAL_ERROR, $message);
}
// Modified for ADR Zones Test Board
	adr_previous( Adr_cell_admin_celled_ok , adr_cheat_log , '' );
}

if( $ban_board )
{
	$banned_id = $jailed_userid;

	if (!$banned_id)
	{
		message_die(GENERAL_ERROR, 'No User Selected!', 'Error');
	}

	$sql = "SELECT *
			FROM " . BANLIST_TABLE;
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Couldn't obtain banlist information", "", __LINE__, __FILE__, $sql);

	$current_banlist = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$kill_session_sql = '';
	$in_banlist = false;
	for($j = 0; $j < count($current_banlist); $j++)
	{
		if ( $banned_id == $current_banlist[$j]['ban_userid'] )
		{
			$in_banlist = true;
		}
	}

// Modified for ADR Zones Test Board
if ($userdata['user_level'] == ADMIN)
{
	if ( !$in_banlist )
	{
		$kill_session_sql .= ( ( $kill_session_sql != '' ) ? ' OR ' : '' ) . "session_user_id = " . $banned_id;

		$sql = "INSERT INTO " . BANLIST_TABLE . " (ban_userid)
				VALUES (" . $banned_id . ")";
		if ( !$db->sql_query($sql) )
			message_die(GENERAL_ERROR, "Couldn't insert ban_userid info into database", "", __LINE__, __FILE__, $sql);
	}

	if ( $kill_session_sql != '' )
	{
		$sql = "DELETE FROM " . SESSIONS_TABLE . "
			WHERE $kill_session_sql";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't delete banned sessions from database", "", __LINE__, __FILE__, $sql);
		}
	}

	$sql = "SELECT * FROM " . ADR_CHEAT_LOG_TABLE . "
			WHERE cheat_id = '$cheat_id'";
	$result	= $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, "Couldn't get cheat log info", "", __LINE__, __FILE__, $sql);

	$cheat_info = $db->sql_fetchrow($result);

	$cheat_punishment_array = explode( '~' , $cheat_info['cheat_punished'] );
	$cheat_punishment_array[1] = '1';

	$cheat_punishment = '';
	for ( $x = 0 ; $x < 4 ; $x++ )
	{
		if ( $x < 3 )
		{
			if ( $cheat_punishment_array[$x] == '' )
			    $cheat_punishment .= '0~';
			else
				$cheat_punishment .= $cheat_punishment_array[$x] . '~';
		}
		else
   			$cheat_punishment .= $cheat_punishment_array[$x];
	}

	$sql = "UPDATE " . ADR_CHEAT_LOG_TABLE . "
			SET cheat_punished = '$cheat_punishment'
	        WHERE cheat_id = '$cheat_id'";
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, "Couldn't UPDATE ADR User Ban", "", __LINE__, __FILE__, $sql);
}
// Modified for ADR Zones Test Board
else if ($submit && $userdata['user_level'] != ADMIN)
{
	$message = 'You are unable to change settings!!  You are ONLY allowed to view the Zone MOD ACP Settings!';
	message_die(GENERAL_ERROR, $message);
}
// Modified for ADR Zones Test Board
	adr_previous( Adr_cell_admin_celled_ok , adr_cheat_log , '' );
}

if( $ban_adr )
{
	$adr_ban_id = $jailed_userid;

	if (!$adr_ban_id)
	{
		message_die(GENERAL_ERROR, 'No User Selected!', 'Error');
	}

// Modified for ADR Zones Test Board
if ($userdata['user_level'] == ADMIN)
{
	$sql = "UPDATE " . USERS_TABLE . "
	        SET user_adr_ban = '1'
	        WHERE user_id = '$adr_ban_id'";
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, "Couldn't UPDATE ADR User Ban", "", __LINE__, __FILE__, $sql);

	$sql = "SELECT * FROM " . ADR_CHEAT_LOG_TABLE . "
			WHERE cheat_id = '$cheat_id'";
	$result	= $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, "Couldn't get cheat log info", "", __LINE__, __FILE__, $sql);

	$cheat_info = $db->sql_fetchrow($result);

	$cheat_punishment_array = explode( '~' , $cheat_info['cheat_punished'] );
	$cheat_punishment_array[0] = '1';

	$cheat_punishment = '';
	for ( $x = 0 ; $x < 4 ; $x++ )
	{
		if ( $x < 3 )
		{
			if ( $cheat_punishment_array[$x] == '' )
			    $cheat_punishment .= '0~';
			else
				$cheat_punishment .= $cheat_punishment_array[$x] . '~';
		}
		else
   			$cheat_punishment .= $cheat_punishment_array[$x];
	}

	$sql = "UPDATE " . ADR_CHEAT_LOG_TABLE . "
			SET cheat_punished = '$cheat_punishment'
	        WHERE cheat_id = '$cheat_id'";
	$result = $db->sql_query($sql);
	if( !$result )
		message_die(GENERAL_ERROR, "Couldn't UPDATE ADR User Ban", "", __LINE__, __FILE__, $sql);
}
// Modified for ADR Zones Test Board
else if ($submit && $userdata['user_level'] != ADMIN)
{
	$message = 'You are unable to change settings!!  You are ONLY allowed to view the Zone MOD ACP Settings!';
	message_die(GENERAL_ERROR, $message);
}
// Modified for ADR Zones Test Board

	adr_previous( Adr_cell_admin_celled_ok , adr_cheat_log , '' );
}

$sql = "SELECT * FROM " . ADR_CHEAT_LOG_TABLE . "
		WHERE cheat_id = '$cheat_id'";
$result	= $db->sql_query($sql);
if( !$result )
	message_die(GENERAL_ERROR, "Couldn't get cheat log info", "", __LINE__, __FILE__, $sql);

$cheat_info = $db->sql_fetchrow($result);

$cheat_punishment_array = explode( '~' , $cheat_info['cheat_punished'] );

if ( !$cheat_punishment_array[0] && !$cheat_punishment_array[1] && !$cheat_punishment_array[1] )
	$current_punishments = $lang['Adr_zone_cheat_log_no_punishment'];
else
{
	$current_punishments = '';
	if ( $cheat_punishment_array[0] )
	    $current_punishments .= $lang['Adr_zone_cheat_log_banned_adr'];
	if ( $cheat_punishment_array[1] )
	{
		if ( $cheat_punishment_array[0] )
		{
			if ( $cheat_punishment_array[2] )
	    		$current_punishments .= sprintf( $lang['Adr_zone_cheat_log_comma_and_sprintf'], $lang['Adr_zone_cheat_log_banned_board'] );
	    	else
	    		$current_punishments .= sprintf( $lang['Adr_zone_cheat_log_and_sprintf'], $lang['Adr_zone_cheat_log_banned_board'] );
	    }
	    else
	    	$current_punishments .= $lang['Adr_zone_cheat_log_banned_board'];
	}
	if ( $cheat_punishment_array[2] )
	{
		if ( $cheat_punishment_array[0] )
		{
			if ( $cheat_punishment_array[1] )
	    		$current_punishments .= sprintf( $lang['Adr_zone_cheat_log_comma_and_sprintf'], $cheat_punishment_array[3] );
	    	else
	    		$current_punishments .= sprintf( $lang['Adr_zone_cheat_log_and_sprintf'], $cheat_punishment_array[3] );
	    }
	    else
	    	$current_punishments .= $cheat_punishment_array[3];
	}
    $current_punishments = sprintf( $lang['Adr_zone_cheat_log_punishment'], $current_punishments );
}

$sql = "SELECT username
		FROM " . USERS_TABLE . "
		WHERE user_id = '$jailed_userid'";
$result	= $db->sql_query($sql);
$row 	= $db->sql_fetchrow($result);

$cheat_type_message = 'Adr_zone_npc_cheating_type_' . $jailed_cheat_type;

$template->assign_vars(array(
	"TIME_DAY" => 0,
	"TIME_HOUR" => 0,
	"TIME_MINUTE" => 0,
	"CHEAT_ID" => $cheat_id,
	"JAILED_ID" => $jailed_userid,
	"CURRENT_PUNISHMENTS" => $current_punishments,
	"USERNAME" => sprintf( $lang['Adr_zone_cheat_log_evaluating'] , $row['username'] ),
	"L_CHEAT_TITLE2" => $lang['Adr_zone_cheat_log_title2'],
	"L_SUBMIT" => $lang['Submit'],
	"L_SELECT" => $lang['Adr_cell_admin_select'],
	"L_SELECT2" => $lang['Adr_zone_cheat_log_ban_board'],
	"L_SELECT3" => $lang['Adr_zone_cheat_log_ban_adr'],
	"L_ZONE_DAY" => $lang['Adr_zone_cell_days'],
	"L_ZONE_HOUR" => $lang['Adr_zone_cell_hours'],
	"L_ZONE_MINUTE" => $lang['Adr_zone_cell_minutes'],
	"L_CELL_TIME" => $lang['Adr_cell_admin_time'],
	"L_CELL_TIME_EXPLAIN" => $lang['Adr_cell_admin_time_explain'],
	"L_CELL_CAUTION" => $lang['Adr_cell_admin_caution'],
	"L_CELL_CAUTION_EXPLAIN" => $lang['Adr_cell_admin_caution_explain'],
	"L_SENTENCE" => sprintf( $lang['Adr_zone_cell_sentence_example'], $lang[$cheat_type_message] ),
	"L_CELLED_SENTENCE" => $lang['Adr_cell_sentence'],
	"L_CELLED_SENTENCE_EXPLAIN" => $lang['Adr_cell_sentence_explain'],
	"L_CELLED_FREEABLE" => $lang['Adr_cell_freeable'],
	"L_CELLED_FREEABLE_EXPLAIN" => $lang['Adr_cell_freeable_explain'],
	"L_CELLED_CAUTIONNABLE" => $lang['Adr_cell_cautionnable'],
	"L_CELLED_CAUTIONNABLE_EXPLAIN" => $lang['Adr_cell_cautionnable_explain'],
	"L_CELLED_USERS" => $lang['Adr_cell_admin_celled_users'],
	"L_CELLED_USERS_EXPLAIN" => $lang['Adr_cell_admin_celled_users_explain'],
	"L_CELLED_NAME" => $lang['Adr_cell_admin_celled_name'],
	"L_CELLED_CAUTION" => $lang['Adr_cell_admin_celled_caution'],
	"L_CELLED_TIME" => $lang['Adr_cell_admin_celled_time'],
	"L_CELLED_FREE" => $lang['Adr_cell_admin_celled_free'],
	"L_MANUAL_UPDATE" => $lang['Adr_cell_admin_manual_update'],
	"L_MANUAL_UPDATE_EXPLAIN" => $lang['Adr_cell_admin_manual_update_explain'],
	"L_SELECTED_CELLED" => $lang['Adr_cell_selected_celled'],
	"L_CELLED_BLANK" => $lang['Adr_cell_admin_celled_blank'],
	"L_CELLED_BLANK_EXPLAIN" => $lang['Adr_cell_admin_celled_blank_explain'],
	"L_PUNISHMENT" => $lang['Adr_cell_admin_punishment'],
	"L_PUNISHMENT_GLOBAL" => $lang['Adr_cell_admin_punishment_global'],
	"L_PUNISHMENT_POSTS" => $lang['Adr_cell_admin_punishment_posts'],
	"L_PUNISHMENT_READ" => $lang['Adr_cell_admin_punishment_read'],
	"S_SELECT_CELLED" => $select_list,
	"S_SUBMIT_ACTION" => append_sid("adr_cheat_moderate.$phpEx"),
));

include_once($phpbb_root_path .'includes/page_header.'. $phpEx);

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');

include_once($phpbb_root_path .'includes/page_tail.'. $phpEx);

?>
