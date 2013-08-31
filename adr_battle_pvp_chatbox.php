<?php

/***************************************************************************
 *                                 adr_battle_chatbox_pvp.php
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

// Grab some values
$battle_id = $_GET['battle_id'];

// Select the battle text again
$sql = "SELECT battle_text, battle_text_chat, battle_turn
		FROM " . ADR_BATTLE_PVP_TABLE . "
        WHERE battle_result = '3'
        AND (battle_opponent_id = '$user_id'	OR battle_challenger_id = '$user_id')
        AND battle_id = '$battle_id'";
if(!($result = $db->sql_query($sql))){
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
}
$battle = $db->sql_fetchrow($result);

/* Start: Format chat - Credit to aUsTiN*/
$format_chat = str_replace('%END%', '<tr><td class="row2"><span class="genmed"><i>', $battle['battle_text']);
$format_chat .= str_replace('%ST%', '</i></span></td></tr>', $format_chat);
$format_chat .= str_replace('%COLOR%orange', '', $format_chat);
$format_chat .= str_replace('%COLOR%blue', '', $format_chat);
$format_chat .= str_replace('%APOS%', '\'', $format_chat);
/* End: Format chat */

if(!$battle_id){
	message_die(GENERAL_MESSAGE, '<i>No Fight Specified!</i>');
}
else
{
	// Grab the current battle info
	$q = "SELECT character_id, character_name
		  FROM ". ADR_CHARACTERS_TABLE ."";
	$r 			= $db -> sql_query($q);
	$user_data 	= $db -> sql_fetchrowset($r);
	$user_count = $db -> sql_numrows($r);

	$sql = "SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
			WHERE battle_id = '$battle_id'";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	}
	$row 	= $db->sql_fetchrow($result);
	$log 	= $row['battle_text'];
	$blue = $row['battle_challenger_id'];
	$orange = $row['battle_opponent_id'];
}

$b = 0;
for($b = 0; $b < $user_count; $b++)
{
	if($user_data[$b]['character_id'] == $blue)
	{
		$new_blue = $user_data[$b]['character_name'];
		$new_blue = str_replace('"', '&quot;', $new_blue);
		break;
	}
}

$o = 0;
for($o = 0; $o < $user_count; $o++)
{
	if($user_data[$o]['character_id'] == $orange)
	{
		$new_orange = $user_data[$o]['character_name'];
		$new_orange = str_replace('"', '&quot;', $new_orange);
		break;
	}
}

/* Start: Format chat */
$log 			= smilies_pass($log);
$log 			= stripslashes($log);
$format_chat 	= str_replace('%ST%', '<tr><td class="row2" align="left" width="100%"><span class="genmed"><i>', $log);
$format_chat2 	= str_replace('%END%', '</i></span></td></tr>', $format_chat);
$format_chat3 	= str_replace('%APOS%', '\'', $format_chat2);
$format_chat4	= str_replace($new_orange, '<font color="orange"><b>'. ucfirst($new_orange) .'</b></font>', $format_chat3);
$format_chat5	= str_replace($new_blue, '<font color="blue"><b>'. ucfirst($new_blue) .'</b></font>', $format_chat4);
$format_chat6	= str_replace('%BSS%', '<tr><td class="row2" align="left" width="100%"><span class="genmed"><font color="red"><i>', $format_chat5);
$format_chat7	= str_replace('%BSE%', '</i></font></span></td></tr>', $format_chat6);
$formatted		= $format_chat7;
/* End: Format chat */

if(empty($formatted))
	$formatted = '<tr><td class="row2" align="left" width="100%"><span class="genmed"><font color="red"><i>The battle has begun!<i></font></span></td></tr>';

$template->assign_vars(array(
	'LOG' => $formatted
));

$template->pparse('body');
?>
