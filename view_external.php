<?php
/***************************************************************************
 *                       view_external.php
 *                      -------------------
 *                    (C) 2003 John McKernan
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
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);


// start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);


// start initial var setup
if ( isset($HTTP_GET_VARS[POST_FORUM_URL]))
{
	$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);
}
else
{
	message_die(GENERAL_MESSAGE, "Error redirecting to external forum. Please try again.");
}

// update the hit counter
if ( !$userdata['session_logged_in'] )
{
	$sql = "UPDATE " . FORUMS_TABLE . "
		SET forum_redirects_guest = forum_redirects_guest + 1
		WHERE forum_id = $forum_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Could not update forum hit counter.", '', __LINE__, __FILE__, $sql);
	}
}
else
{
	$sql = "UPDATE " . FORUMS_TABLE . "
		SET forum_redirects_user = forum_redirects_user + 1
		WHERE forum_id = $forum_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Could not update forum hit counter.", '', __LINE__, __FILE__, $sql);
	}
}

// pull the external redirect info
$sql = "SELECT f.forum_redirect_url FROM " . FORUMS_TABLE . " f WHERE forum_id = $forum_id";

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain redirection information.", '', __LINE__, __FILE__, $sql);
}

if ( !($row = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, "Could not obtain redirection information.", '', __LINE__, __FILE__, $sql);
}

$external_url = "Location: " . $row['forum_redirect_url'];

header($external_url);

?>