<?php
/***************************************************************************
 *                           functions_rabbitoshi.php
 *                            -------------------
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

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
	exit;
}

function rabbitoshi_get_pet_age($var)
{
	global $db , $lang;

	$age ='';
	$stamp_age =  time() - $var;
	$days = floor($stamp_age/86400);
	if ( $days == 1 )
	{
		$age .= $days . ' ' . $lang['Day'].' - ';
		$stamp_age = $stamp_age - 86400 ;
	}
	else if ( $days > 1 )
	{
		$age .= $days . ' ' . $lang['Days'].' - ';
		$stamp_age = $stamp_age - ( 86400 * $days );
	}
	$hours = floor($stamp_age/3600);
	if ( $hours == 1 )
	{
		$age .= $hours . ' ' . $lang['Hour'].' - ';
		$stamp_age = $stamp_age - 3600 ;
	}
	else if ( $hours > 1 )
	{
		$age .= $hours . ' ' . $lang['Hours'].' - ';
		$stamp_age = $stamp_age - ( 3600 * $hours );
	}
	$mins = ceil($stamp_age/60);
	if ( $mins == 1 )
	{
		$age .= $mins . ' ' . $lang['Minute'];
		$stamp_age = $stamp_age - 60 ;
	}
	else if ( $mins > 1 )
	{
		$age .= $mins . ' ' .$lang['Minutes'];
		$stamp_age = $stamp_age - ( 60 * $mins );
	}
	return $age ;

}

function rabbitoshi_get_pet_value()
{
	global $db , $lang , $rabbit_user , $rabbit_stats ;

	$time = time() - $rabbit_user['creature_age'];
	$time_bonus = floor ( $time / 86400 ) ;
	$bonus = 0.1 * $time_bonus ;

	$hunger_status = floor (( $rabbit_user['creature_hunger'] / $rabbit_stats['creature_max_hunger'] ) *100);
	$thirst_status = floor (( $rabbit_user['creature_thirst'] / $rabbit_stats['creature_max_thirst'] ) *100);
	$health_status = floor (( $rabbit_user['creature_health'] / $rabbit_stats['creature_max_health'] ) *100);
	$hygiene_status = floor (( $rabbit_user['creature_hygiene'] / $rabbit_stats['creature_max_hygiene'] ) *100);
	$status = 0;
	$prize = $rabbit_stats['creature_prize'];

	if ( $hunger_status < 0 || $rabbit_user['creature_hunger'] == '0')
	{
		$pet_dead = true;	
	}
	else if ( $hunger_status < 25 )
	{
		$message .= $lang['Rabbitoshi_message_very_hungry'].'<br />';
	}
	else if ( $hunger_status < 50 )
	{
		$message .= $lang['Rabbitoshi_message_hungry'].'<br />';
	}
	else
	{
		$status = $status +1 ;
	}
	if ( $thirst_status < 0 || $rabbit_user['creature_thirst'] == '0')
	{
		$pet_dead = true;	
	}
	else if ( $thirst_status < 25 )
	{
		$message .= $lang['Rabbitoshi_message_very_thirst'].'<br />';
	}
	else if ( $thirst_status < 50 )
	{
		$message .= $lang['Rabbitoshi_message_thirst'].'<br />';
	}
	else
	{
		$status = $status +1 ;
	}
	if ( $health_status < 0 || $rabbit_user['creature_health'] == '0')
	{
		$pet_dead = true;	
	}
	else if ( $health_status < 25 )
	{
		$message .= $lang['Rabbitoshi_message_very_health'].'<br />';
	}
	else if ( $health_status < 50 )
	{
		$message .= $lang['Rabbitoshi_message_health'].'<br />';
	}
	else
	{
		$status = $status +1 ;
	}
	if ( $hygiene_status < 0 || $rabbit_user['creature_hygiene'] == '0')
	{
		$pet_dead = true;	
	}
	else if ( $hygiene_status < 25 )
	{
		$message .= $lang['Rabbitoshi_message_very_hygiene'].'<br />';
	}
	else if ( $hygiene_status < 50 )
	{
		$message .= $lang['Rabbitoshi_message_hygiene'].'<br />';
	}
	else
	{
		$status = $status +1 ;
	}
	if ( $status =='0' )
	{
		$thought = $lang['Rabbitoshi_general_message_very_bad'];
		$value = floor($prize / 4 );
	}
	else if ( $status =='1' )
	{
		$thought = $lang['Rabbitoshi_general_message_bad'];
		$value = floor($prize / 3 );
	}
	else if ( $status =='2' )
	{
		$thought = $lang['Rabbitoshi_general_message_neutral'];
		$value = floor($prize / 2 );
	}
	else if ( $status =='3' )
	{
		$thought = $lang['Rabbitoshi_general_message_good'];
		$value = floor($prize / 1.5 );
	}
	else
	{
		$thought = $lang['Rabbitoshi_general_message_very_good'];
		$value = floor($prize / 1.1 );
	}

	$user_id = $rabbit_user['owner_id'] ;
	$price = 0;
	$itemsum = 0;

	$sql = "SELECT item_prize , item_id
		FROM " . RABBITOSHI_SHOP_TABLE ."
		ORDER by item_id ";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain items pets information', "", __LINE__, __FILE__, $sql);
	}
	$items = $db->sql_fetchrowset($result);
	for ($i=0; $i < count($items) ; $i++)
	{
		$item_id = $items[$i]['item_id'];
		$usql = "SELECT item_amount
			FROM " . RABBITOSHI_SHOP_USERS_TABLE . "
			WHERE user_id = $user_id
			AND item_id =  $item_id ";
		if( !$uresult = $db->sql_query($usql))
		{
			message_die(GENERAL_ERROR, 'Could not obtain items pets information', "", __LINE__, __FILE__, $usql);
		}
		$item_data = $db->sql_fetchrow($uresult);
		$price = (( $item_data['item_amount'] ) * ( $items[$i]['item_prize'] ));
		$itemsum = $itemsum + $price ;
	}
	$value = floor ( $value + ( $value * $bonus ) + $itemsum );

	return array( $value , $thought , $message , $pet_dead );
}

function rabbitoshi_get_user_stats($user_id)
{
	global $db , $view_userdata , $lang ;

	$user_id = intval($user_id);
	$sql = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE . " 
	WHERE owner_id = ".$user_id;	
	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
	}
	$rabbit_user = $db->sql_fetchrow($result);

	return $rabbit_user;
}

function get_rabbitoshi_config($creature_id) 
{ 
	global $db; 

	$creature_id = ( is_numeric($creature_id) ? $creature_id : FALSE); 
	if ( $creature_id == FALSE ) 
	{ 
		$sql = "SELECT * FROM " . RABBITOSHI_CONFIG_TABLE . " 
		WHERE creature_buyable = 1
		ORDER by creature_prize"; 
		if (!$result = $db->sql_query($sql)) 
		{ 
			message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi Config!'); 
		} 
		$rabbit_config = $db->sql_fetchrowset($result); 
	} 
	else 
	{ 
		$sql = "SELECT * FROM " . RABBITOSHI_CONFIG_TABLE . " 
		WHERE creature_id = ".$creature_id; 
		if (!$result = $db->sql_query($sql)) 
		{ 
			message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi Config!'); 
		} 
		$rabbit_config = $db->sql_fetchrow($result); 
	} 
	return $rabbit_config;
}

function rabbitoshi_get_hotel()
{
	global $db , $view_userdata;

	$rabbit_user = rabbitoshi_get_user_stats($view_userdata['user_id']);
	$hotel_time = $rabbit_user['creature_hotel'] - time() ;
	if ( $hotel_time > 0 )
	{
		$is_in_hotel = TRUE ;
	}
	else
	{
		$is_in_hotel = FALSE ;
		$sql = " UPDATE " . RABBITOSHI_USERS_TABLE . " 
			SET creature_hotel = 0
			WHERE owner_id = ".$view_userdata['user_id'];
		if (!$result = $db->sql_query($sql)) 
		{ 
			message_die(CRITICAL_ERROR, 'Error Getting Rabbitishi Config!'); 
		} 
	}
	return array( $is_in_hotel , $hotel_time );
}

function rabbitoshi_make_time($stamp_age)
{
	global $db , $lang ;

	$time = '';
	$days = floor($stamp_age/86400);
	$stamp_age = $stamp_age - ( $days * 86400 );
	$hours = floor($stamp_age/3600);
	$stamp_age = $stamp_age - ( $hours * 3600 );
	$minutes = ceil($stamp_age/60);
	if ( $days > 1 )
	{
		$time .= $days.'&nbsp;'.$lang['Days'].'&nbsp;';
	}
	else if ( $days != 0 )
	{
		$time .= $days.'&nbsp;'.$lang['Day'].'&nbsp;';
	}
	if ( $hours > 1 )
	{
		$time .= $hours.'&nbsp;'.$lang['Hours'].'&nbsp;';
	}
	else if ( $hours != 0 )
	{
		$time .= $hours.'&nbsp;'.$lang['Hour'].'&nbsp;';
	}
	if ( $minutes > 1 )
	{
		$time .= $minutes.'&nbsp;'.$lang['Minutes'].'&nbsp;';
	}
	else if ( $minutes != 0 )
	{
		$time .= $minutes.'&nbsp;'.$lang['Minute'].'&nbsp;';
	}
	return $time;
}

?>