<?php
/***************************************************************************
 *                            functions_clans.php
 *                            -------------------
 *   begin                : Thursday, March 10, 2005
 *   copyright            : Nuladion
 *   email                : nuladion@gmail.com
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

// Send PM [START]
// Sends a private message from one user to the other
function clans_sendpm($from, $to, $subject, $text, $littlenote)
{
	global $db;

	$reciever_id = $to;
	$sender_id = $from;
	
	$sql = "UPDATE " . USERS_TABLE . " SET user_new_privmsg = '1', user_last_privmsg = '9999999999' WHERE user_id = '".$reciever_id."' ";
	if ( !($result = $db->sql_query($sql)) )
	{ message_die(GENERAL_ERROR, 'Could not update users table (sendpm)', '', __LINE__, __FILE__, $sql); }
		
	$pm_subject = $subject;
	$pm = $text.'<br /><br /><span class="gensmall">----------------------<br />'.$littlenote.'</span>';
	$privmsgs_date = date("U");
	$sql = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig) VALUES ('0', '" . str_replace("\'", "''", addslashes(sprintf($pm_subject,$board_config['sitename']))) . "', " . $sender_id . ", " . $reciever_id . ", " . $privmsgs_date . ", '0', '1', '1', '0')";
	if ( !$db->sql_query($sql) )
	{ message_die(GENERAL_ERROR, 'Could not insert private message sent info (sendpm)', '', __LINE__, __FILE__, $sql); }
		
	$privmsg_sent_id = $db->sql_nextid();
	$privmsgs_text = $pm_subject;
		
	$sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_text) VALUES ($privmsg_sent_id, '" . str_replace("\'", "''", addslashes(sprintf($pm,$board_config['sitename'],$board_config['sitename']))) . "')";
	if ( !$db->sql_query($sql) )
	{ message_die(GENERAL_ERROR, 'Could not insert private message sent text (sendpm)', '', __LINE__, __FILE__, $sql); }

	return 'aap';
}
// Send PM [END]

?>
