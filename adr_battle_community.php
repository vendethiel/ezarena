<?php

/***************************************************************************
 *                                 adr_battle_community.php
 *                                ---------------------
 *		Version			: 1.0.0
 *		Authors			: aUsTiN 		
 *							[ (austin_inc@hotmail.com) 		(http://phpbb-amod.com) 	]
 *						  Seteo-Bloke 	
 *							[ (admin@phpbb-adr.com) 	(http://www.phpbb-adr.com) 	]
 *
 ***************************************************************************************/

define('IN_PHPBB', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_SHOPS', true);
$only_body = !empty($_GET['only_body']);

$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.'.$phpEx);

$loc = 'battle_community';
$sub_loc = 'adr_battle_community';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR);
init_userprefs($userdata);
// End session management
//
$user_id = $userdata['user_id'];
$user_points = $userdata['user_points'];
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_functions_global_chat.'.$phpEx);

// Sorry , only logged users ...
if(!$userdata['session_logged_in']){
	$redirect = "adr_battle_community.$phpEx";
	$redirect .= (isset($user_id)) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Get the general config
$adr_general = adr_get_general_config();
if (!$only_body)
{
	// Grab template file etc.
	include_once($phpbb_root_path . 'includes/page_header.'.$phpEx);
}
adr_template_file('adr_battle_community_body.tpl', 'battle_community');

$mode = isset($_POST['mode']) ? $_POST['mode'] : '';

//
// Get online users [START].
//
$sql = "SELECT u.*, s.session_logged_in, s.session_ip
	FROM ". ADR_CHARACTERS_TABLE ." u, ". SESSIONS_TABLE ." s
	WHERE u.character_id = s.session_user_id
	AND u.character_id <> '$user_id'
	AND s.session_time >= ".(time() - 300)."
	AND u.character_id > '1'
	ORDER BY u.character_name ASC, s.session_ip ASC";
if(!($result = $db->sql_query($sql)))
	message_die(GENERAL_ERROR, 'Could not obtain user/online information', '', __LINE__, __FILE__, $sql);

$userlist_ary = array();
$userlist_visible = array();
$prev_user_id = 0;
$prev_user_ip = '';
$user_count = 1;

while($row = $db->sql_fetchrow($result)){
	// User is logged in and therefor not a guest
	if($row['session_logged_in']){
		// Skip multiple sessions for one user
		if($row['character_id'] != $prev_user_id){
			$style_color = '';
			$user_online_link = '<span class="genmed"><a href="profile.'. $phpEx .'?mode=viewprofile&u='. $row['character_id'] .'" target="_blank">'. $row['character_name'] .'</a></span>';

			$user_count = ($user_count + 1);
			if($user_count > '10'){
				$online_userlist .= "<br />";
				$online_userlist .= $user_online_link;
			}
			else{
				$online_userlist .= ($online_userlist != '') ? ', ' . $user_online_link : $user_online_link;
			}
		}

		$prev_user_id = $row['character_id'];
	}
	$prev_session_ip = $row['session_ip'];
}

$online_userlist = ($prev_user_id == '0') ? $lang['Adr_community_no_users_online'] : $online_userlist;

//
// Get online users [END]
//

$template->assign_vars(array(
	'U_GLOBAL_CHAT'     => append_sid("adr_global_chat.$phpEx"),
	'U_CHAT_VIEW'       => append_sid("adr_battle_community.$phpEx"),
	'ONLINE_LIST' 		=> $online_userlist,
	'L_COMMUNITY'		=> $lang['Adr_shoutbox_community'],
	'L_ONLINE_LIST'     => $lang['Adr_shoubox_online_list']
));
	
if ($only_body)
{
	$template->assign_var('PARAMS', '&only_body=1');
}
else
{
	include_once($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
	$template->assign_block_vars('standalone', array());
}
$template->pparse('battle_community');
if (!$only_body)
{
	include_once($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}