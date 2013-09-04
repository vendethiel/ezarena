<?php
/***************************************************************************
 *                             adr_cheat_log.php
 *                            --------------------
 *		Version			: 0.2.0
 *		Email			: GOster@OzziesWorld.com
 *		Site			: http://www.OzziesWorld.com
 *
 ***************************************************************************/

define('IN_PHPBB', TRUE);
define('IN_ADR_CHARACTER', true);
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

adr_template_file('adr_cheat_log_body.tpl');

// Get the general settings
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);

$start = isset($HTTP_GET_VARS['start']) ? intval($HTTP_GET_VARS['start']) : 0;
$start = (intval($start) > 0) ? intval($start) : 0;

if( isset($HTTP_POST_VARS['cheat_id']) || isset($HTTP_GET_VARS['cheat_id']) )
{
	$cheat_id  = ( isset($HTTP_POST_VARS['cheat_id']) ) ? $HTTP_POST_VARS['cheat_id'] : $HTTP_GET_VARS['cheat_id'];
	$cheat_id  = intval($cheat_id);
}
if( isset($HTTP_POST_VARS['public']) || isset($HTTP_GET_VARS['public']) )
{
	$public_type = ( isset($HTTP_POST_VARS['public']) ) ? $HTTP_POST_VARS['public'] : $HTTP_GET_VARS['public'];
	$public_type = intval($public_type);
}

$adr_moderators = explode( ',' , $board_config['zone_adr_moderators'] );

if ( $cheat_id )
{
	if ( !in_array( $user_id , $adr_moderators ) &&  $userdata['user_level'] != ADMIN )
		adr_previous( Adr_cell_not_authorized_view , adr_cheat_log , '' );

	if ( $public_type )
	{
		$sql = "UPDATE " . ADR_CHEAT_LOG_TABLE . "
		        SET cheat_public = '1'
		        WHERE cheat_id = '$cheat_id'";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, "Couldn't UPDATE ADR Cheat Public Status", "", __LINE__, __FILE__, $sql);
	}
	else if ( !$public_type )
	{
		$sql = "UPDATE " . ADR_CHEAT_LOG_TABLE . "
		        SET cheat_public = '0'
		        WHERE cheat_id = '$cheat_id'";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, "Couldn't UPDATE ADR Cheat Public Status", "", __LINE__, __FILE__, $sql);
	}
}

if ( in_array( $user_id , $adr_moderators ) || $userdata['user_level'] == ADMIN )
{
	$width = '20';
	$template->assign_block_vars('moderate', array());

	$sql = "SELECT c.*, u.username, a.character_name FROM " . ADR_CHEAT_LOG_TABLE . " c
			LEFT JOIN " . USERS_TABLE . " u ON ( c.cheat_user_id = u.user_id )
			LEFT JOIN " . ADR_CHARACTERS_TABLE . " a ON ( c.cheat_user_id = a.character_id )
			LIMIT $start, " . $board_config['posts_per_page'];
}
else
{
	$width = '25';

	$sql = "SELECT c.*, u.username, a.character_name FROM " . ADR_CHEAT_LOG_TABLE . " c
			LEFT JOIN " . USERS_TABLE . " u ON ( c.cheat_user_id = u.user_id )
			LEFT JOIN " . ADR_CHARACTERS_TABLE . " a ON ( c.cheat_user_id = a.character_id )
			WHERE c.cheat_public = '1'
			LIMIT $start, " . $board_config['posts_per_page'];
}

$result	= $db->sql_query($sql);

$cheat_info = $db->sql_fetchrowset($result);

if ( in_array( $user_id , $adr_moderators ) || $userdata['user_level'] == ADMIN )
{
	$sql = "SELECT * FROM " . ADR_CHEAT_LOG_TABLE . "";
}
else
{
	$sql = "SELECT * FROM " . ADR_CHEAT_LOG_TABLE . "
			WHERE cheat_public = '1'";
}

$result = $db->sql_query($sql);
$total = $db->sql_numrows($result);

$cheat_count = count($cheat_info);

$pagination 	= generate_pagination("adr_cheat_log.$phpEx?u=$user_id", $total, $board_config['posts_per_page'], $start). '&nbsp;';
$page_number 	= sprintf($lang['Page_of'], (floor($start / $board_config['posts_per_page']) + 1 ), ceil($total / $board_config['posts_per_page']));

if (!$total)
	adr_previous( Adr_Npc_character_no_cheat_message , adr_character_prefs , '' );

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
	if ($userdata['user_level'] == ADMIN)
		$fixed_ip = '<a href="http://www.dnsstuff.com/tools/whois.ch?ip=' . $cheat_ip . '" target="_phpbbwhois">' . $cheat_ip . '</a>';
	else
		$fixed_ip 		= $fix_ip[0] .'.'. $fix_ip[1] .'.'. $fix_ip[2] .'.xxx';
	$row_class 			= ( !($a % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	$cheat_punishment_array = explode( '~' , $cheat_info[$a]['cheat_punished'] );
	$cheat_punishment = '';
	for ( $x = 0 ; $x < 3 ; $x++ )
	{
		if ( $cheat_punishment_array[$x] == '1' )
		{
			if ( $x == 0 )
		    	$cheat_punishment_text = $lang['Adr_zone_cheat_log_banned_adr'];
			else if ( $x == 1 )
		    	$cheat_punishment_text = $lang['Adr_zone_cheat_log_banned_board'];
			else if ( $x == 2 )
		    	$cheat_punishment_text = $cheat_punishment_array[3];
		}
		if ( strlen( $cheat_punishment ) == 0 && strlen( $cheat_punishment_array[$x] >= 1 ) )
			$cheat_punishment .= $cheat_punishment_text;
		else if ( strlen( $cheat_punishment ) != 0 && strlen( $cheat_punishment_array[$x] >= 1 ) )
		{
			if ( ( $x == 2 ) )
				$cheat_punishment .= sprintf( $lang['Adr_zone_cheat_log_comma_and_sprintf'], $cheat_punishment_text );
			else if ( ( $x == 1 ) && !$cheat_punishment_array[2] )
				$cheat_punishment .= sprintf( $lang['Adr_zone_cheat_log_comma_and_sprintf'], $cheat_punishment_text );
			else
				$cheat_punishment .= ', ' . $cheat_punishment_text;
		}
	}
	if ( strlen( $cheat_punishment >= 1 ) )
		$cheat_punishment .= '.';

	$template->assign_block_vars('rows', array(
		'CHEAT_IP'			=> $fixed_ip,
		'CHEAT_TYPE'		=> $cheat_type,
//		'CHEAT_PUNISHMENT1' => ( $cheat_punishment != '' ) ? 'arrow' : '' ,
		'CHEAT_PUNISHMENT'	=> ( $cheat_punishment != '' ) ? $cheat_punishment : $lang['Adr_zone_cheat_log_no_punishment'],
		'CHEAT_DATE'		=> $cheat_date,
		'CHEAT_USERNAME'	=> $cheat_info[$a]['username'],
		'CHEAT_CHARACTER'	=> $cheat_info[$a]['character_name'],
		
		'U_CHEAT_USERNAME'	=> append_sid("profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=" . $cheat_info[$a]['cheat_user_id']),
		'U_CHEAT_CHARACTER'	=> append_sid("adr_character.$phpEx?" . POST_USERS_URL . "=" . $cheat_info[$a]['cheat_user_id']),
		'NUM'				=> $start + ($a + 1),
		'ROWS'				=> $row_class,
	));

	if ( in_array( $user_id , $adr_moderators ) || $userdata['user_level'] == ADMIN )
	{
		$template->assign_block_vars('rows.moderate', array(
			'PUBLIC'            => ( $cheat_info[$a]['cheat_public'] ) ? $lang['Adr_zone_cheat_log_hide_link_title'] : $lang['Adr_zone_cheat_log_public_link_title'],
			'PUBLIC_LINK'       => ( $cheat_info[$a]['cheat_public'] ) ? append_sid("adr_cheat_log.$phpEx?cheat_id=" . $cheat_info[$a]['cheat_id'] . "&amp;public=0&amp;start=$start") : append_sid("adr_cheat_log.$phpEx?cheat_id=" . $cheat_info[$a]['cheat_id'] . "&amp;public=1&amp;start=$start"),
		    'MOD'           	=> $lang['Adr_zone_cheat_log_moderator_link_title'],
    		'CHEAT_MOD_LINK'	=> append_sid("adr_cheat_moderate.$phpEx?" . POST_USERS_URL . "=" . $cheat_info[$a]['cheat_user_id'] . "&amp;cheat=" . $cheat_type_no . "&amp;cheat_id=" . $cheat_info[$a]['cheat_id']),
   		));
   	}

	if (!$cheat_info[$a]['cheat_user_id'])
		break;
}

$template->assign_vars(array(
	'L_WIDTH'           => $width,
	'L_PAGE_TITLE'      => $lang['Adr_zone_cheat_log_title'],
	'L_CHEAT_IP'		=> $lang['Adr_zone_cheat_log_ip'],
	'L_CHEAT_TYPE'		=> $lang['Adr_zone_cheat_log_attempted'],
	'L_CHEAT_DATE'		=> $lang['Adr_zone_cheat_log_date'],
	'L_CHEAT_USERNAME'	=> $lang['Username'],
	'L_CHEAT_CHARACTER' => $lang['Adr_zone_cheat_log_character_name'],
	'L_CHEAT_PROFILE'	=> $lang['Adr_zone_cheat_log_view_profile'],
	'L_CHARACTER'		=> $lang['Adr_character_see'],
	'L_PAGE_NOTE'       => $lang['Adr_zone_cheat_log_page_note'],
	'L_CHEAT_ACTION'	=> $lang['Adr_zone_cheat_log_action'],
	'PAGINATION'		=> $pagination,
	'PAGE_NUMBER'		=> $page_number,
));

include_once($phpbb_root_path .'includes/page_header.'. $phpEx);

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');

include_once($phpbb_root_path .'includes/page_tail.'. $phpEx);

?>
