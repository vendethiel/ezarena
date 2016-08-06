<?php

/***************************************************************************
 *                                 adr_global_chat.php
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

$loc = 'battle_community';
$sub_loc = 'battle_community';

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

// Sorry , only logged users
if(!$userdata['session_logged_in']){
	$redirect = "adr_battle_community.$phpEx";
	$redirect .= (isset($user_id)) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Get the general config
$adr_general = adr_get_general_config();
$adr_user = adr_get_user_infos($user_id);

// Load the headers
$gen_simple_header = TRUE;
//include_once($phpbb_root_path .'includes/page_header.'. $phpEx);
adr_template_file('adr_global_chat_body.tpl');

$mode = isset($_POST['mode']) ? $_POST['mode'] : '';

	if(!$mode)
		$mode = isset($_GET['mode']) ? $_GET['mode'] : '';

	$todays_chat_info 	= GC_GetTodaysChat();
	$todays_chat 		= $todays_chat_info['chat_text'];

	// Basic error checks before postings
	$error_['1']		='<i><font color="#FF0000">'.$lang['Adr_global_shout_error_1'].'</font></i><br><br>';
	$error_['2']		='<i><font color="#FF0000">'.$lang['Adr_global_shout_error_2'].'</font></i><br><br>';
	$error_['3']		='<i><font color="#FF0000">'.$lang['Adr_global_shout_error_3'].'</font></i><br><br>';
	$error_['4']		='<i><font color="#FF0000">'.$lang['Adr_global_shout_incorrect_user'].'</font></i><br><br>';

	if($mode == 'archives'){
		$template->assign_block_vars('archives', array(
			'MSG'	=> 'Setup the archives here, with the header & footer included!'
		));
	}

	if($mode == 'add')
	{
	$msg = ($_POST['msg']) ? $_POST['msg'] : $_POST['msg'];

	#==== Check: did they post all spaces? ======================== |		
	$msg = trim($msg);
	
	#==== Check: did they post? =================================== |
	if(empty($msg)) $error_messages = '1';
	
	#==== Check: max characters exceeded? ========================= |
	$some_number = 250; # Make this a config value!
	if(strlen($msg) > $some_number){
		$over = ($some_number - $msg);
		$error_messages = '2';
	}

	#==== Check: admin has posted a command sequence ========================= |
	if($userdata['user_level'] == ADMIN){
		// Checks if admin wants to instant kill a user.
		// First 5 characters are '/kill', sixth is a space ' ' and then from 7 onwards we have the username
		// Remember [0] is the first letter in the array
		if(substr($msg, 0, 5) == '/kill'){
			$username = substr($msg, 6);
			$msg = '<font color="purple"><i><b>'.$lang['Adr_global_shout_adm_cmd'].' </b>'.adr_gc_admin_cmd_kill($username).'</i></font>';
		}

		// Revive user with full HP
		elseif(substr($msg, 0, 7) == '/revive'){
			$username = substr($msg, 8);
			$msg = '<font color="purple"><i><b>'.$lang['Adr_global_shout_adm_cmd'].' </b>'.adr_gc_admin_cmd_revive($username).'</i></font>';
		}

		// Finish a users monster battle
		elseif(substr($msg, 0, 10) == '/endallmon'){
			$username = substr($msg, 11);
			$msg = '<font color="purple"><i><b>'.$lang['Adr_global_shout_adm_cmd'].' </b>'.adr_admin_cmd_endallmon($username).'</i></font>';
		}

		// Finish a users all current PvP battles
		elseif(substr($msg, 0, 10) == '/endallpvp'){
			$username = substr($msg, 11);
			$msg = '<font color="purple"><i><b>'.$lang['Adr_global_shout_adm_cmd'].' </b>'.adr_admin_cmd_endallpvp($username).'</i></font>';
		}

		// Finish one PvP battle. Pass battle_pvp_id for success
		elseif(substr($msg, 0, 7) == '/endpvp'){
			$battle_id = intval(substr($msg, 8));
			$msg = '<font color="purple"><i><b>'.$lang['Adr_global_shout_adm_cmd'].' </b>'.adr_admin_cmd_endpvp($battle_id).'</i></font>';
		}

		// Instant ban a user from participating in ADR/RPG
		elseif(substr($msg, 0, 4) == '/ban'){
			// Find first instance of '?' within cmd to grab ban reason
			$pos = strpos($msg, '?');

			// Check if a '?' is present. If not show error msg
			if(strpos($msg, '?')){
				$reason = trim(substr(($pos + 1)));
          		 	$username = substr($msg, 5, ($pos - 6));
				$msg = '<font color="purple"><i><b>'.$lang['Adr_global_shout_adm_cmd'].' </b>'.adr_admin_cmd_ban($username, $reason).'</i></font>';
			}
			else{
				$msg = '<font color="purple"><i><b>'.$lang['Adr_global_shout_adm_cmd'].' </b>'.$lang['Adr_global_shout_error_3'].'</i></font>';
			}
		}

		// Instant UNban a user from participating in ADR/RPG
		elseif(substr($msg, 0, 6) == '/unban')
		{
			// Find first instance of '?' within cmd to grab ban reason
			$pos = strpos($msg, '?');

			// Check if a '?' is present. If not show error msg
			if(strpos($msg, '?')){
				$reason = trim(substr(($pos + 1)));
       	    	$username = trim(substr($msg, 7, ($pos - 8)));
				$msg = '<font color="purple"><i><b>'.$lang['Adr_global_shout_adm_cmd'].' </b>'.adr_admin_cmd_unban($username, $reason).'</i></font>';
			}
			else{
				$msg = '<font color="purple"><i><b>'.$lang['Adr_global_shout_adm_cmd'].' </b>'.$lang['Adr_global_shout_error_3'].'</i></font>';
			}
		}
	}

	#==== Check: wordwrapping the message? ======================== |	
		# This is so the kids can't stretch the page!
	$msg = wordwrap($msg, 25, ' ', 1);

	#==== Check for admin global shout ================================= |
	$admin_shout = ((substr($msg, 0, 1) == '!') && ($userdata['user_level'] == ADMIN)) ? TRUE : FALSE;
	$msg = ($admin_shout) ? substr_replace($msg, '', 0, 1) : $msg;
	$msg = ($admin_shout) ? '<font color="#FF0000"><b>'.$msg.'</b></font>' : $msg;
	$msg = ($admin_shout) ? strtoupper($msg) : $msg;
	
	#==== Get Username To add to Message ================================= |
	$umsg = ($admin_shout == FALSE) ? '<a href="profile.'. $phpEx .'?mode=viewprofile&u='. $adr_user['character_id'] .'" target="_blank">'. $adr_user['character_name'] .'</a>' : '<font color="#FF0000"><b>'.$lang['Adr_global_shout_announcer'].'</b></font>';

	#==== check if shouter is a GM (admin)========|
	$umsg = ($userdata['user_level'] == ADMIN) ? '<b>'. $umsg .'</b>' : $umsg;

	#==== Check for emotes ================================= |
	$emote_= (substr($msg, 0, 3) != "/me") ? FALSE : TRUE;
	$clear_text_= ((substr($msg, 0, 6) == "/clear") && ($userdata['user_level'] == ADMIN)) ? TRUE : FALSE;
	$killme_ = (substr($msg, 0, 7) != "/killme") ? FALSE : TRUE;
	$pvpme_ = (substr($msg, 0, 6) != "/pvpme") ? FALSE : TRUE;
	$vitals = (substr($msg, 0, 6) != '/stats') ? FALSE : TRUE;

	if($emote_){
		$msg = '<i>'.$umsg.' '.substr($msg, 4).'</i>';
	}
	elseif($clear_text_){
		GC_clear_today_chat();
		$error_messages = $lang['Adr_global_shout_error_no_log'];
	}
	elseif($killme_){
		$killme_msg = substr($msg, 8);
		$msg = '<i>'.sprintf($lang['Adr_global_shout_killme'], $adr_user['character_name'], $killme_msg).'</i>';
	}
	elseif($pvpme_){
		$msg = '<font color="red"><b>'.sprintf($lang['Adr_global_shout_pvpme'], $adr_user['character_name']).'</b></font>';
	}
	elseif($vitals){
		$username = substr($msg, 7);
		$msg = '<i>'.adr_gc_admin_cmd_vitals($username).'</i>';
	}
	elseif(substr($msg, 0, 9) == '/realname'){
		// Not complete
		$character_name = substr($msg, 10);
		$msg = sprintf($lang['Adr_global_shout_realname'], '<font color="purple"><i>', '<b>'.$character_name.'</b>', '<b>'.$username.'</b>', '</i></font>');
	}
	else{
		$msg = $umsg.": ".'<font color="#0000FF">'.$msg.'</font>';
	}

	$msg = str_replace("\'", "''", $msg);
	
	#==== Add Beginning & End To Message ========================== |
	$msg = '%S%'. $msg;
	$msg .= '%E%';

	#==== Escape ' ========================== |
	if($error_messages == "")
		GC_AddChat($msg);

	redirect('adr_global_chat.'. $phpEx.'?err='.$error_messages, TRUE);
	exit;
	}

	// Include page header now to prevent redirect errors
	include_once($phpbb_root_path .'includes/page_header.'. $phpEx);
	if(!$mode){
		if(!$todays_chat)
			$todays_chat = '%S%*'.$lang['Adr_global_shout_error_no_log'].'*%E%';

	#==== Word Censor Pass ======================================== |
	$q = "SELECT * FROM ". WORDS_TABLE;
		if(!$r = $db->sql_query($q))
    	   	message_die(GENERAL_ERROR, "Error Selecting Censored Word List.", "", __LINE__, __FILE__, $q);
			
		while($row = $db->sql_fetchrow($r)){
			if(eregi(quotemeta($row['word']), $todays_chat))
			$todays_chat = str_replace($row['word'], $row['replacement'], $todays_chat);
		}
					
	#==== Generic BBCode Pass ===================================== |
		# Did it this way so i wouldn't have to use bbcode_uid for each post		
	$todays_chat	= str_replace('[b]', '<b>', $todays_chat);
	$todays_chat	= str_replace('[/b]', '</b>', $todays_chat);
	$todays_chat	= str_replace('[i]', '<i>', $todays_chat);
	$todays_chat	= str_replace('[/i]', '</i>', $todays_chat);			
	
	#==== HTML Block Pass ========================================= |
		# This is done to prevent stretching the page or a redirect exploit.
	$allowed 		= '<b><i><a><font>';
	$todays_chat	= strip_tags($todays_chat, $allowed);
		
	#==== Starting Pass =========================================== |	
	$todays_chat 	= str_replace('%S%', '<tr><td class="row2" align="left" width="100%"><span class="genmed">', $todays_chat);
	
	#==== Closing Pass ============================================ |	
	$todays_chat 	= str_replace('%E%', '</span></td></tr>', $todays_chat);

	#==== Smilies Pass ============================================ |
	if ($board_config['allow_smilies'])
		$todays_chat = smilies_pass($todays_chat);

	#==== Unquote where necessary ===================================== |
	$todays_chat = stripslashes($todays_chat);

	$chat_session	= $todays_chat;
	$error_messages = isset($_POST['err']) ? $_POST['err'] : '';
	if (!$error_messages)
		$error_messages = isset($_GET['err']) ? $_GET['err'] : '';
		
	$error_messages = (!$error_messages) ? '' : $error_[$error_messages];

	$template->assign_block_vars('chat_body', array(
		'FORM'		=> append_sid("adr_global_chat.$phpEx"),
		//'TOP_L'		=> sprintf($lang['Adr_shoutbox_archive'], date('Y-m-d')),
		'TOP_M'		=> ' : ',
		'TOP_R'		=> '<a href="'. append_sid('adr_global_chat.'. $phpEx .'?mode=archives') .'">Archives</a>',
		'MSG'		=> $lang['Adr_shoutbox_enter'],
		'BUTTON'	=> $lang['Adr_shoutbox_shout'],
		'ERROR'		=> $error_messages,
		'TXT'		=> $chat_session,
		'U_CHAT_VIEW' => append_sid("adr_global_chat.$phpEx")
	));
}

$template->assign_vars(array(
	'U_CHAT_VIEW' => append_sid("adr_global_chat.$phpEx")
));

$template->pparse('body');
?>
