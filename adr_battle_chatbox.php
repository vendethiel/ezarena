<?php

/***************************************************************************
 *                                 adr_battle_chatbox.php
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
$phpbb_root_path = './';

include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.'.$phpEx);
include_once($phpbb_root_path . 'includes/bbcode.'. $phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR);
init_userprefs($userdata);
// End session management
//
$user_id = $userdata['user_id'];
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
        $redirect = "adr_battle.$phpEx";
        $redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
        header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Get the general config
$adr_general = adr_get_general_config();

// Load the headers
$gen_simple_header = TRUE;
include_once($phpbb_root_path .'includes/page_header.'. $phpEx);

// Grab info
adr_template_file('adr_battle_chatbox_body.tpl');

$battle = adr_get_battle($user_id);

/* Start: Format chat - Credit to aUsTiN*/
$format_chat = str_replace('%END%', '<tr><td class="row2"><span class="genmed"><i>', $battle['battle_text']);
$format_chat .= str_replace('%ST%', '</i></span></td></tr>', $format_chat);
$format_chat .= str_replace('%COLOR%orange', '', $format_chat);
$format_chat .= str_replace('%COLOR%blue', '', $format_chat);
$format_chat .= str_replace('%COLOR%purple', '', $format_chat);
$format_chat .= str_replace('%APOS%', '\'', $format_chat);
/* End: Format chat */

$log 	= $battle['battle_text'];
$blue = $battle['battle_challenger_id'];
$orange = $battle['battle_opponent_id'];

// Grab the current battle info
$sql = "SELECT c.character_id, c.character_name, m.monster_id, m.monster_name
		FROM ". ADR_CHARACTERS_TABLE ." c, ". ADR_BATTLE_MONSTERS_TABLE ." m
		WHERE c.character_id = '$blue'
		AND m.monster_id = '$orange'";
if(!($result = $db->sql_query($sql)))
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
$player_details = $db->sql_fetchrow($result);

// Get player 2 infos
$sql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ."
		WHERE character_id = '$purple'";
if(!($result = $db->sql_query($sql)))
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
$player_2_details = $db->sql_fetchrow($result);

// Set name colours
$new_blue = $player_details['character_name'];
$new_purple = $player_2_details['character_name'];
$new_orange = $player_details['monster_name'];

/* Start: Format chat */
$log 			= smilies_pass($log);
$format_chat 	= str_replace('%ST%', '<tr><td class="row2" align="left" width="100%" cellpadding="3"><span class="genmed"><i>', $log);
$format_chat2 	= str_replace('%END%', '</i></span></td></tr>', $format_chat);
$format_chat3 	= str_replace('%APOS%', '\'', $format_chat2);
$format_chat4	= str_replace($new_orange, '<font color="orange"><b>'. $new_orange .'</b></font>', $format_chat3);
$format_chat5	= str_replace($new_purple, '<font color="purple"><b>'. $new_purple .'</b></font>', $format_chat4);
$format_chat6	= str_replace($new_blue, '<font color="blue"><b>'. $new_blue .'</b></font>', $format_chat5);
$format_chat7	= str_replace('%BSS%', '<tr><td class="row2" align="left" width="100%"><span class="genmed"><font color="red"><i>', $format_chat6);
$format_chat8	= str_replace('%BSE%', '</i></font></span></td></tr>', $format_chat7);
$formatted		= $format_chat8;
$formatted      = stripslashes($formatted);
/* End: Format chat */

if(empty($formatted))
	$formatted = '<tr><td class="row2" align="left" width="100%"><span class="genmed"><font color="red"><i>The battle has begun!<i></font></span></td></tr>';

$template->assign_vars(array(
	'LOG' => $formatted
));

$template->pparse('body');
?>
