<?php
/***************************************************************************
 *				    adr_library.php
 *				------------------------
 *	begin 		: 10/03/2005
 *	copyright		: One_Piece
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
define('IN_ADR_ZONES', true);
define('IN_ADR_CHARACTER', true);
$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR);
init_userprefs($userdata);
// End session management
//
$user_id = $userdata['user_id'];
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_library_body.tpl');
include_once($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config and character infos
$adr_general = adr_get_general_config();
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
$adr_user = adr_get_user_infos($user_id);

$template->assign_vars(array(
	'L_ZONE_LIBRARY' => $lang['Adr_zone_library_title'],
	'L_ZONE_CHARACTER_FAQ' => $lang['Adr_zone_character_faq'],
	'L_ZONE_CHARACTER_LIST' => $lang['Adr_zone_character_list'],
	'L_ZONE_CHARACTER_PREFS' => $lang['Adr_zone_character_prefs'],
	'U_ZONE_CHARACTER_FAQ' => append_sid("adr_character_faq.$phpEx"),
	'U_ZONE_CHARACTER_LIST' => append_sid("adr_character_list.$phpEx"),
	'U_ZONE_CHARACTER_PREFS' => append_sid("adr_character_prefs.$phpEx"),
	'S_ZONES_ACTION' => append_sid("adr_library.$phpEx"),
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include_once($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>