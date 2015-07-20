<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

function adr_cell_update_users()
{
	global $db , $lang ;

	$sql = "SELECT * FROM " . USERS_TABLE . "
		WHERE user_cell_time > 0
		ORDER BY username";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain celled list', '', __LINE__, __FILE__, $sql);
	}
	$celleds = $db->sql_fetchrowset($result);

	for ( $i = 0 ;$i < count($celleds) ; $i++ )
	{
		$less_time = ( time() - $celleds[$i]['user_cell_time_judgement'] );
		if ( ( $celleds[$i]['user_cell_time'] - $less_time ) < 60 )
		{
			$sql = "UPDATE " . ADR_JAIL_USERS_TABLE . " 
				SET user_freed_by = 1
			WHERE user_id = '" . $celleds[$i]['user_id'] . "'";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . ADR_JAIL_VOTES_TABLE . " 
			WHERE vote_id = '" . $celleds[$i]['user_id'] . "'";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
			}


			$sql = "UPDATE " . USERS_TABLE . " 
				SET user_cell_time = 0 ,
				user_cell_time_judgement = 0 ,
				user_cell_enable_caution = 0,
				user_cell_enable_free = 0,
				user_cell_sentence = '',
				user_cell_caution = 0
			WHERE user_id = '" . $celleds[$i]['user_id'] . "'";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
			}
			$free .= sprintf($celleds[$i]['username']).'<br />';
		}
		else
		{
			$sql = "UPDATE " . USERS_TABLE . " 
				SET user_cell_time = user_cell_time - $less_time,
				user_cell_time_judgement = ".time()."
			WHERE user_id = '" . $celleds[$i]['user_id'] . "'";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
			}
		}

	}

	return $free;
}

function adr_cell_imprison_user($celled_id , $time_day , $time_hour , $time_minute , $caution , $cautionable , $freeable , $sentence , $punishment )
{
	global $db , $lang ;

	$caution = intval($caution);
	$punishment = intval($punishment);
	$time = ( $time_day * 86400 ) + ( $time_hour * 3600 ) + ( $time_minute * 60 );

	$ssql = "SELECT celled_id FROM " . ADR_JAIL_USERS_TABLE . "
		ORDER BY celled_id
		DESC LIMIT 1 ";
	if (!$db->sql_query($ssql))
	{
		message_die(GENERAL_ERROR, "Could not update user's jail infos", '', __LINE__, __FILE__, $ssql);
	}
	$total = $db->sql_fetchrow($sresult);
	$cell_id = $total['celled_id'] +1 ;

	// See if the user is already imprisoned ( some never understand .... )
	$ssql = "SELECT user_cell_time FROM " . USERS_TABLE . "
		WHERE  user_id = $celled_id";
	if (!$db->sql_query($ssql))
	{
		message_die(GENERAL_ERROR, "Could not update user's jail infos", '', __LINE__, __FILE__, $ssql);
	}
	$user = $db->sql_fetchrow($sresult);

	// Only one entry per user at the same time
	if ( !$user['user_cell_time'] )
	{
		$sql = "INSERT INTO " . ADR_JAIL_USERS_TABLE . "
			( celled_id , user_id , user_cell_date , user_freed_by , user_sentence , user_caution , user_time )
			VALUES ( $cell_id , $celled_id , ".time()." , 0 , '$sentence' , $caution , ".$time." ) ";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update user's jail infos", '', __LINE__, __FILE__, $sql);
		}
	}

	$sql = "UPDATE " . USERS_TABLE . "
		SET user_cell_time = user_cell_time + $time ,
		user_cell_time_judgement = user_cell_time_judgement + ".time()." ,
		user_cell_caution = user_cell_caution + $caution,
		user_cell_enable_caution = $cautionable,
		user_cell_enable_free = $freeable,
		user_cell_celleds = user_cell_celleds + 1,
		user_cell_punishment = $punishment,
		user_cell_sentence = '$sentence'
		WHERE user_id = $celled_id";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update user's jail infos", '', __LINE__, __FILE__, $sql);
	}
}

function adr_cell_free_user( $celled_id , $freed_by )
{
	global $db;

	$celled_id = intval($celled_id); 
	$freed_by = intval($freed_by);

	$sql = "UPDATE " . ADR_JAIL_USERS_TABLE . " 
		SET user_freed_by = $freed_by
		WHERE user_id = $celled_id ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
	}
	
	$sql = "DELETE FROM " . ADR_JAIL_VOTES_TABLE . " 
		WHERE vote_id = $celled_id ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . USERS_TABLE . " 
		SET user_cell_time = 0 ,
		user_cell_time_judgement = 0 ,
		user_cell_enable_caution = 0,
		user_cell_enable_free = 0,
		user_cell_sentence = '',
		user_cell_punishment = 0,
		user_cell_caution = 0
	WHERE user_id = $celled_id ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
	}
}

?>