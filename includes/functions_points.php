<?php
/***************************************************************************
 *                               functions_points.php
 *                            -------------------
 *   begin                : Sunday, April 14, 2002
 *   copyright            : (C) 2002 Bulletin Board Mods
 *   email                : robbie@robbieshields.net
 *
 *   $Id: mod_install.php,v 1.0.1 2003/12/08 17:13:00 Robbie Shields Exp $
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
 ***************************************************************************/

function get_username_from_id($user_id)
{
	global $db;

	$sql = "SELECT username
		FROM " . USERS_TABLE . "
		WHERE user_id = $user_id
			AND user_id != " . ANONYMOUS;

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not get username from $user_id.", '', __LINE__, __FILE__, $sql);
	}
	$username = $db->sql_fetchrow($result);
	
	return $username['username'];
}

function get_userid_from_name($username)
{
	global $db;
	
	$username = str_replace("\'", "''", trim($username));

	$sql = "SELECT user_id
		FROM " . USERS_TABLE . "
		WHERE username = '$username'
			AND user_id != " . ANONYMOUS;
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not get user_id from $username.", '', __LINE__, __FILE__, $sql);
	}
	$user_id = $db->sql_fetchrow($result);
	
	return $user_id['user_id'];
}

function get_user_points($user_id)
{
	global $db;
	
	$sql = "SELECT user_points
		FROM " . USERS_TABLE . "
		WHERE user_id = $user_id";

	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not get user_points from $user_id.", '', __LINE__, __FILE__, $sql);
	}
	$points = $db->sql_fetchrow($result);
	
	return $points['user_points'];
}

function add_points($user_id, $amount)
{
	global $db;

	$sql = "UPDATE " . USERS_TABLE . "
		SET user_points = user_points + $amount
		WHERE user_id = $user_id";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update user's points", '', __LINE__, __FILE__, $sql);
	}

	return;
}

function subtract_points($user_id, $amount)
{
	global $db;

	$sql = "UPDATE " . USERS_TABLE . "
		SET user_points = user_points - $amount
		WHERE user_id = $user_id";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update user's points", '', __LINE__, __FILE__, $sql);
	}
	
	return;
}

function user_is_authed($user_id)
{
	global $db, $board_config;

	if ($user_id == ANONYMOUS)
		return false;

	static $is_authed;

	if (!isset($is_authed))
	{
		$is_authed = false;

		$points_user_group_auth_ids = explode("\n", $board_config['points_user_group_auth_ids']);

		$valid_ids = array();

		foreach ($points_user_group_auth_ids as $id)
		{
			$id = intval(trim($id));

			if (!empty($id))
			{
				$valid_ids[] = $id;
			}
		}

		$valid_ids_sql = implode(',', $valid_ids);

		$sql = "SELECT group_id
			FROM " . USER_GROUP_TABLE . "
			WHERE group_id IN ($valid_ids_sql)
				AND user_id = $user_id
				AND user_pending = 0";
		$result = $db->sql_query($sql);

		if ($row = $db->sql_fetchrow($result))
		{
			$is_authed = true;
		}
		$db->sql_freeresult($result);
	}

	return $is_authed;
}

?>