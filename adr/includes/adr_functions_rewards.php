<?php
/***************************************************************************
 *                                 adr_functions_rewards.php
 *                            -------------------
 *	Begun                : 22/11/2004
 *	Copyright            : Seteo-Bloke
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

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

// give rewards to the user
// copied from Xore's "rewards_api.php"
function add_reward( $user_id, $amount )
{
	global $userdata, $db;
	$user_id = intval($user_id);
	$amount = intval($amount);

	$sql = " UPDATE " . USERS_TABLE . "
		SET user_points = user_points + $amount
		WHERE user_id = $user_id ";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to add rewards", "", __LINE__, __FILE__, $sql);
	}
}

// subtract rewards from the user
function subtract_reward( $user_id, $amount )
{
	global $userdata, $db;
	$user_id = intval($user_id);
	$amount = intval($amount);

	$sql = " UPDATE " . USERS_TABLE . "
		SET user_points = user_points - $amount
		WHERE user_id = $user_id ";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to subtract rewards", "", __LINE__, __FILE__, $sql);
	}
}

// set the user's rewards
function set_reward( $user_id, $amount )
{
	global $userdata, $db;
	$user_id = intval($user_id);
	$amount = intval($amount);

	$sql = " UPDATE " . USERS_TABLE . "
		SET user_points = $amount
		WHERE user_id = $user_id ";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Failed to set rewards", "", __LINE__, __FILE__, $sql);
	}
}

// get the user's reward amounts
function get_reward( $user_id )
{
   global $userdata, $db;
   $user_id = intval($user_id);

   $sql = "SELECT user_points FROM " . USERS_TABLE . "
      WHERE user_id = '$user_id'";
   if (!($result = $db->sql_query($sql))){
      message_die(CRITICAL_ERROR, 'Error checking if user has character');}
   $row = $db->sql_fetchrow($result);

   return $row['user_points'];
}

// check if user has $amount minimum rewards
function has_reward( $user_id, $amount )
{
	$user_id = intval($user_id);
	$amount = intval($amount);
	$users_amount = get_reward($user_id);

	return ($users_amount >= $amount);
}

// Get the rewards name
function get_reward_name()
{
	global $board_config;
	return $board_config['points_name'];
}

?>