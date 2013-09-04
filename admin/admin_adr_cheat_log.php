<?php
/***************************************************************************
 *                           admin_adr_cheat_log.php
 *                           -----------------------
 *		Version			: 0.2.0
 *		Email			: GOster@OzziesWorld.com
 *		Site			: http://www.OzziesWorld.com
 *
 ***************************************************************************/

define('IN_PHPBB', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_ZONES_ADMIN', 1);
define('IN_ADR_CHARACTER', 1);
define('IN_ADR_ZONES', 1);
define('IN_ADR', 1);
define('IN_ADR_CELL', 1);
define('IN_ADR_CHEAT', 1);
define('IN_ADR_SHOPS', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ADR-Zones']['Cheat CP'] = $filename;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

adr_template_file('admin/config_adr_zones_cheat_log_body.tpl');

// Get the general settings
$adr_general = adr_get_general_config();

$start = isset($HTTP_GET_VARS['start']) ? intval($HTTP_GET_VARS['start']) : 0;
$start = (intval($start) > 0) ? intval($start) : 0;
$submit = isset($HTTP_POST_VARS['submit']);
$ban_board = isset($HTTP_POST_VARS['ban_board']);
$ban_adr = isset($HTTP_POST_VARS['ban_adr']);

if( isset($HTTP_POST_VARS['cheat_id']) || isset($HTTP_GET_VARS['cheat_id']) )
{
	$cheat_id  = ( isset($HTTP_POST_VARS['cheat_id']) ) ? $HTTP_POST_VARS['cheat_id'] : $HTTP_GET_VARS['cheat_id'];
	$cheat_id  = intval($cheat_id);
}

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);
}

if ( $mode != "" )
{
	// Define some values
	$items = ( isset($HTTP_POST_VARS['action_box']) ) ?  $HTTP_POST_VARS['action_box'] : array();

	switch($mode)
	{

		case 'delete':

			if(count($items) > '0')
			{
				for($i = 0; $i < count($items); $i++)
				{
					$cheat_id = $items[$i];

					$sql = "DELETE FROM " . ADR_CHEAT_LOG_TABLE . "
							WHERE cheat_id = " . $cheat_id;
					$result = $db->sql_query($sql);
					if( !$result )
						message_die(GENERAL_ERROR, "Couldn't delete alignment", "", __LINE__, __FILE__, $sql);
				}
			}

			adr_previous( Adr_zone_acp_cheat_entry_successful_deleted , admin_adr_cheat_log , '' );
			break;

		case 'hide':

			if(count($items) > '0')
			{
				for($i = 0; $i < count($items); $i++)
				{
					$cheat_id = $items[$i];

					$sql = "UPDATE " . ADR_CHEAT_LOG_TABLE . "
		    			    SET cheat_public = '0'
					        WHERE cheat_id = '$cheat_id'";
					$result = $db->sql_query($sql);
					if( !$result )
						message_die(GENERAL_ERROR, "Couldn't UPDATE ADR Cheat Public Status", "", __LINE__, __FILE__, $sql);
				}
			}

			adr_previous( Adr_zone_acp_cheat_entry_successful_hidden , admin_adr_cheat_log , '' );
			break;

		case 'public':

			if(count($items) > '0')
			{
				for($i = 0; $i < count($items); $i++)
				{
					$cheat_id = $items[$i];

					$sql = "UPDATE " . ADR_CHEAT_LOG_TABLE . "
		    			    SET cheat_public = '1'
					        WHERE cheat_id = '$cheat_id'";
					$result = $db->sql_query($sql);
					if( !$result )
						message_die(GENERAL_ERROR, "Couldn't UPDATE ADR Cheat Public Status", "", __LINE__, __FILE__, $sql);
				}
			}

			adr_previous( Adr_zone_acp_cheat_entry_successful_public , admin_adr_cheat_log , '' );
			break;

		case 'punish':

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

			$celled_id = $jailed_userid;

			$template->assign_block_vars( 'punishment' , array());
			
			if( $submit )
			{
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

				adr_cell_imprison_user($celled_id,$time_day,$time_hour,$time_minute,$caution,$cautionable,$freeable,$sentence,$punishment);

				$sql = "SELECT * FROM " . ADR_CHEAT_LOG_TABLE . "
						WHERE cheat_id = '$cheat_id'";
				$result	= $db->sql_query($sql);
				if( !$result )
					message_die(GENERAL_ERROR, "Couldn't get cheat log info", "", __LINE__, __FILE__, $sql);

				$cheat_info = $db->sql_fetchrow($result);

				$cheat_punishment_array = explode( '~' , $cheat_info['cheat_punished'] );
				$cheat_punishment_array[2] = '1';
				$cheat_punishment_array[3] = 'Imprisoned for ';
				if ( $time_day )
				{
				    if ( $time_day > 1 )
				        $cheat_punishment_array[3] .= $time_day . ' Days';
					else
					    $cheat_punishment_array[3] .= $time_day . ' Day';
				}
				if ( $time_hour )
				{
				    if ( $time_day )
				    {
				        if ( $time_minute )
				        	$cheat_punishment_array[3] .= ', ';
						else
				        	$cheat_punishment_array[3] .= ' and ';
					}
				    if ( $time_hour > 1 )
				        $cheat_punishment_array[3] .= $time_hour . ' Hours';
					else
					    $cheat_punishment_array[3] .= $time_hour . ' Hour';
				}
				if ( $time_minute )
				{
					if ( $time_hour && $time_day )
					    $cheat_punishment_array[3] .= ', and ';
					else if ( ( !$time_hour && $time_day ) || ( $time_hour && !$time_day ) )
					    $cheat_punishment_array[3] .= ' and ';
				    if ( $time_minute > 1 )
				        $cheat_punishment_array[3] .= $time_hour . ' Minutes';
					else
					    $cheat_punishment_array[3] .= $time_hour . ' Minute';
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

				adr_previous( Adr_cell_admin_celled_ok , admin_adr_cheat_log , '' );
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

				adr_previous( Adr_zone_acp_banned_board_ok , admin_adr_cheat_log , '' );
			}

			if( $ban_adr )
			{
				$adr_ban_id = $jailed_userid;

				if (!$adr_ban_id)
				{
					message_die(GENERAL_ERROR, 'No User Selected!', 'Error');
				}

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

				adr_previous( Adr_zone_acp_banned_adr_ok , admin_adr_cheat_log , '' );
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
				    		$current_punishments .= $lang['Adr_zone_cheat_log_comma_and'] . $lang['Adr_zone_cheat_log_banned_board'];
	    				else
				    		$current_punishments .= $lang['Adr_zone_cheat_log_and'] . $lang['Adr_zone_cheat_log_banned_board'];
				    }
				    else
				    	$current_punishments .= $lang['Adr_zone_cheat_log_banned_board'];
				}
				if ( $cheat_punishment_array[2] )
				{
					if ( $cheat_punishment_array[0] )
					{
						if ( $cheat_punishment_array[1] )
				    		$current_punishments .= $lang['Adr_zone_cheat_log_comma_and'] . $cheat_punishment_array[3];
	    				else
				    		$current_punishments .= $lang['Adr_zone_cheat_log_and'] . $cheat_punishment_array[3];
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
				"L_PAGE_TITLE"      	=> $lang['Adr_zone_cheat_log_title'],
				"L_PAGE_TITLE_EXPLAIN"  => $lang['Adr_zone_cheat_log_title_explain'],
				"L_CHEAT_TITLE2" => $lang['Adr_zone_cheat_log_title2'],
				"TIME_DAY" => 0,
				"TIME_HOUR" => 0,
				"TIME_MINUTE" => 0,
				"CURRENT_PUNISHMENTS" => $current_punishments,
				"JAILED_ID" => $jailed_userid,
				"USERNAME" => sprintf( $lang['Adr_zone_cheat_log_evaluating'] , $row['username'] ),
				"CHEAT_ID" => $cheat_id,
				"L_PUNISH" => $lang['Adr_zone_cheat_log_punish'],
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
				"S_SUBMIT_ACTION" => append_sid("admin_adr_cheat_log.$phpEx"),
			));
	}
}
else
{
	$template->assign_block_vars( 'list' , array());
$sql = "SELECT c.*, u.username, a.character_name FROM " . ADR_CHEAT_LOG_TABLE . " c
		LEFT JOIN " . USERS_TABLE . " u ON ( c.cheat_user_id = u.user_id )
		LEFT JOIN " . ADR_CHARACTERS_TABLE . " a ON ( c.cheat_user_id = a.character_id )
		LIMIT $start, " . $board_config['posts_per_page'];
$result	= $db->sql_query($sql);

$cheat_info = $db->sql_fetchrowset($result);

$sql = "SELECT * FROM " . ADR_CHEAT_LOG_TABLE;
$result = $db->sql_query($sql);
$total = $db->sql_numrows($result);

$cheat_count = count($cheat_info);

$pagination 	= generate_pagination($phpbb_root_path . "admin/admin_adr_cheat_log.$phpEx?mode=", $total, $board_config['posts_per_page'], $start). '&nbsp;';
$page_number 	= sprintf($lang['Page_of'], (floor($start / $board_config['posts_per_page']) + 1 ), ceil($total / $board_config['posts_per_page']));

if (!$total)
{
	$message = $lang['Adr_Npc_character_no_cheat_message'] . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
	message_die(GENERAL_MESSAGE, $message);
}

for ($a = 0; $a < $cheat_count; $a++)
{
	$cheat_ip 			= decode_ip($cheat_info[$a]['cheat_ip']);
	$cheat_type 		= $cheat_info[$a]['cheat_reason'];
	switch($cheat_type)
	{
		case 'NPC Refresh Cheat' :
			$cheat_type_no = 1;
			break;
		case 'NPC URL Insertion Cheat' :
			$cheat_type_no = 2;
			break;
	}
	$cheat_date 		= create_date($board_config['default_dateformat'], $cheat_info[$a]['cheat_date'], $board_config['board_timezone']);
	$fix_ip 			= explode('.', $cheat_ip);
	$fixed_ip 			= '<a href="http://www.dnsstuff.com/tools/whois.ch?ip=' . $cheat_ip . '" target="_phpbbwhois">' . $cheat_ip . '</a>';
	$row_class 			= ( !($a % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	$cheat_punishment_array = explode( '~' , $cheat_info[$a]['cheat_punished'] );
	$cheat_punishment = '';
	for ( $x = 0 ; $x < 3 ; $x++ )
	{
		if ( $cheat_punishment_array[$x] == '1' )
		{
			if ( $x == 0 )
		    	$cheat_punishment_text = 'Banned from ADR';
			else if ( $x == 1 )
		    	$cheat_punishment_text = 'Banned from Board';
			else if ( $x == 2 )
		    	$cheat_punishment_text = $cheat_punishment_array[3];
		}
		if ( strlen( $cheat_punishment ) == 0 && strlen( $cheat_punishment_array[$x] >= 1 ) )
			$cheat_punishment .= $cheat_punishment_text;
		else if ( strlen( $cheat_punishment ) != 0 && strlen( $cheat_punishment_array[$x] >= 1 ) )
		{
			if ( ( $x == 2 ) )
				$cheat_punishment .= ', and ' . $cheat_punishment_text;
			else if ( ( $x == 1 ) && !$cheat_punishment_array[2] )
				$cheat_punishment .= ', and ' . $cheat_punishment_text;
			else
				$cheat_punishment .= ', ' . $cheat_punishment_text;
		}
	}
	if ( strlen( $cheat_punishment >= 1 ) )
		$cheat_punishment .= '.';

	$template->assign_block_vars('list.rows', array(
		'CHEAT_IP'			=> $fixed_ip,
		'CHEAT_TYPE'		=> $cheat_type,
		'CHEAT_PUNISHMENT'	=> ( $cheat_punishment != '' ) ? $cheat_punishment : $lang['Adr_zone_cheat_log_no_punishment'],
		'CHEAT_DATE'		=> $cheat_date,
		'CHEAT_USERNAME'	=> $cheat_info[$a]['username'],
		'CHEAT_CHARACTER'	=> $cheat_info[$a]['character_name'],
		'U_CHEAT_USERNAME'	=> append_sid("../profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=" . $cheat_info[$a]['cheat_user_id']),
		'U_CHEAT_CHARACTER'	=> append_sid("../adr_character.$phpEx?" . POST_USERS_URL . "=" . $cheat_info[$a]['cheat_user_id']),
    	'U_CHEAT_PUNISH'	=> append_sid("admin_adr_cheat_log.$phpEx?" . POST_USERS_URL . "=" . $cheat_info[$a]['cheat_user_id'] . "&amp;cheat=" . $cheat_type_no . "&amp;mode=punish&amp;cheat_id=" . $cheat_info[$a]['cheat_id']),
		'L_PUNISH'			=> ( $cheat_punishment == '' ) ? $lang['Adr_zone_cheat_log_punish_2'] : $lang['Adr_zone_cheat_log_punished'],
		'NUM'				=> ( $cheat_info[$a]['cheat_public'] ) ? $start + ($a + 1) : $start + ($a + 1) . '<span class="genmed"><font color="red">**</font></span>',
		'CHEAT_ID'          => $cheat_info[$a]['cheat_id'],
		'ROWS'				=> $row_class,
	));

	if (!$cheat_info[$a]['cheat_user_id'])
		break;
}

$action_select = '<select name="mode">';
$action_select .= '<option value = "" class="post">' . $lang['Adr_items_select_action'] . '</option>';
$action_select .= '<option value = "delete" class="post">' . $lang['Adr_zone_cheat_log_delete'] . '</option>';
$action_select .= '<option value = "hide" class="post">' . $lang['Adr_zone_cheat_log_hide'] . '</option>';
$action_select .= '<option value = "public" class="post">' . $lang['Adr_zone_cheat_log_public'] . '</option>';

$action_select .= '</select>';

$template->assign_vars(array(
	'L_PAGE_TITLE'      	=> $lang['Adr_zone_cheat_log_title'],
	'L_PAGE_TITLE_EXPLAIN'  => $lang['Adr_zone_cheat_log_title_explain'],
	'L_CHEAT_IP'			=> $lang['Adr_zone_cheat_log_ip'],
	'L_CHEAT_TYPE'			=> $lang['Adr_zone_cheat_log_attempted'],
	'L_CHEAT_DATE'			=> $lang['Adr_zone_cheat_log_date'],
	'L_CHEAT_USERNAME'		=> $lang['Username'],
	'L_CHEAT_CHARACTER' 	=> $lang['Adr_zone_cheat_log_character_name'],
	'L_CHEAT_ACTION'		=> $lang['Adr_zone_cheat_log_action'],
	'L_PROFILE'         	=> $lang['Adr_zone_cheat_log_view_profile'],
	'L_CHARACTER'			=> $lang['Adr_character_see'],
	'L_CHEAT_PUNISH_TEXT'   => $lang['Adr_zone_cheat_log_punish_text'],
	'ACTION_SELECT' 		=> $action_select,
	'L_SUBMIT' 				=> $lang['Submit'],
	'L_CHECK_ALL' 			=> $lang['Adr_check_all'],
	'L_UNCHECK_ALL' 		=> $lang['Adr_uncheck_all'],
	'PAGINATION'			=> $pagination,
	'PAGE_NUMBER'			=> $page_number,
));
}

$template->pparse("body");
include_once('./page_footer_admin.'.$phpEx);

?>
