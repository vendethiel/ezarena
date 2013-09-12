<?php

if ( !defined('IN_PHPBB') )
	die("Hacking attempt");

if ( !$board_config['adr_time_last_time'] )
{
	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = ".time()." 
		WHERE config_name = 'adr_time_last_time' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $sql); 

	$board_config['adr_time_last_time'] = time();
	$db->clear_cache('config');
}

if ( ( time() - $board_config['adr_time_last_time'] ) > $board_config['adr_length_time'])
{
	$actual_time = $board_config['adr_time'];

	if ( $actual_time == '1' ) $new_time = '2';
	if ( $actual_time == '2' ) $new_time = '3';
	if ( $actual_time == '3' ) $new_time = '4';
	if ( $actual_time == '4' ) $new_time = '1';

	// update time
	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$new_time' 
		WHERE config_name = 'adr_time' "; 
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not access time table.", '', __LINE__, __FILE__, $sql);

	//define the new period
	$new_time = $board_config['adr_time_last_time'] +  $board_config['adr_length_time'];

	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$new_time' 
		WHERE config_name = 'adr_time_last_time' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $sql); 
	$db->clear_cache('config');
}

?>