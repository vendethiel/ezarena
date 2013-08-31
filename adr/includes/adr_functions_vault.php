<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

if ( !$board_config['stock_last_change'] )
{
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = ".time()." WHERE config_name = 'stock_last_change' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, "Couldn't update stock exchange",  "", __LINE__, __FILE__, $lsql); 
	} 
	$board_config['stock_last_change'] = time();
}

if ( ( time() - $board_config['stock_last_change'] ) > $board_config['stock_time'] )
{
	$sql = "SELECT * FROM  " . ADR_GENERAL_TABLE ; 
	if (!$result = $db->sql_query($sql)) 
	{
		message_die(CRITICAL_ERROR, 'Error Getting Vault Config!');
	}
	while( $row = $db->sql_fetchrow($result) )
	{	
		$vault_general[$row['config_name']] = $row['config_value'];
	}

	$sql = "SELECT *
		FROM " . ADR_VAULT_EXCHANGE_TABLE ."
		ORDER BY stock_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain stock exchange from database", "", __LINE__, __FILE__, $sql);
	}	
	$exchange = $db->sql_fetchrowset($result);
	for($i = 0; $i < count($exchange); $i++)
	{
		if ( $vault_general['stock_min_change'] > $vault_general['stock_max_change'] )
		{
			$vault_general['stock_min_change'] = $vault_general['stock_max_change'];
		}
		$variation = rand($vault_general['stock_min_change'] , $vault_general['stock_max_change']);
		$hazard = rand(1,2);
		if ( $hazard == '2' )
		{
			$variation = - $variation ;
		}
		$new_price = $new_price = ceil($exchange[$i]['stock_price'] * ( 1 + ( $variation / 100 )));

		$old_price = $exchange[$i]['stock_price'] ;
		$best_price = ( $new_price > $exchange[$i]['stock_best_price'] ) ? $new_price : $exchange[$i]['stock_best_price'];
		$worst_price = ( $new_price < $exchange[$i]['stock_worst_price'] ) ? $new_price : $exchange[$i]['stock_worst_price'];

		$sql = "UPDATE " . ADR_VAULT_EXCHANGE_TABLE ."
			SET stock_price = $new_price ,
			stock_previous_price = $old_price ,
			stock_best_price = $best_price ,
			stock_worst_price = $worst_price
			WHERE stock_id = ".$exchange[$i]['stock_id'];
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, "Couldn't update stock exchange", "", __LINE__, __FILE__, $sql);
		}
	}

	$new_time = $board_config['stock_last_change'] +  $board_config['stock_time'];
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = $new_time WHERE config_name = 'stock_last_change' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, "Couldn't update stock exchange", "", __LINE__, __FILE__, $lsql); 
	} 
}

?>