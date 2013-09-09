<?php 
/***************************************************************************
 *					adr_research_learned.php
 *				------------------------
 *	Date				: 07/05/07  
 *  Original Author     : Maiken
 *  Version 			: 0.0.1
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true); 
define('IN_ADR_CAULDRON', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_CHARACTER', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 
// End session management
//

$user_id = $userdata['user_id'];

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_research_learned.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_research_learned_body.tpl');

include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

$sql = "SELECT * FROM " . ADR_LIBRARY_LEARN_TABLE . "
		WHERE user_id = '$user_id'
		ORDER BY book_id DESC";
if( !($result = $db->sql_query($sql)) ){
	message_die(GENERAL_ERROR, 'Could not obtain required learned information', "", __LINE__, __FILE__, $sql);}
$research_log = $db->sql_fetchrowset($result);

for ( $i = 0 ; $i < count( $research_log ) ; $i++ )
{
	$template->assign_block_vars('learned', array(		
		"BOOK_NAME" => $research_log[$i]['book_name'],
		"BOOK_INFO" => $research_log[$i]['book_details'],
	));
}

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>