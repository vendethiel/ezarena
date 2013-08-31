<?php

/***************************************************************************
 *                                mod_whoisonline.php
 *                            -------------------
 *  Adapté par Saint-Pere
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $l_online_users,$online_userlist,$lang,$userdata,$board_config,$phpEx;

 //chargement du template
$template->set_filenames(array(
   'whoisonline' => 'areabb/mods/whoisonline/tpl/mod_whoisonline.tpl')
);

if( $userdata['session_logged_in'] )
{
	$template->assign_block_vars( 'switch_user_logged_in' , array() );
}
else
{
	$template->assign_block_vars( 'switch_user_logged_out' , array() );
}

$template->assign_vars(array(
	'TOTAL_USERS_ONLINE'	=> $l_online_users,
	'LOGGED_IN_USER_LIST'	=> $online_userlist,
	'RECORD_USERS'			=> sprintf($lang['Record_online_users'], $board_config['record_online_users'], create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),
	'U_VIEWONLINE'			=> append_sid('viewonline.'.$phpEx),
	'L_VIEW_COMPLETE_LIST'	=> $lang['View_complete_list'])
);

$template->assign_var_from_handle('whoisonline', 'whoisonline');

?>