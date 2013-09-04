<?php

if ( !defined('IN_PHPBB') )
	die("Hacking attempt");

if ( !$board_config['adr_seasons_last_time'] )
{
	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = ".time()." 
		WHERE config_name = 'adr_seasons_last_time' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $sql); 

	$board_config['adr_seasons_last_time'] = time();
	$db->clear_cache('config_');
}

if ( ( time() - $board_config['adr_seasons_last_time'] ) > $board_config['adr_seasons_time'])
{
	$actual_season = $board_config['adr_seasons'];

	if ( $actual_season == '1' ) $new_season = '2';
	if ( $actual_season == '2' ) $new_season = '3';
	if ( $actual_season == '3' ) $new_season = '4';
	if ( $actual_season == '4' ) $new_season = '1';

	// update seasons
	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$new_season' 
		WHERE config_name = 'adr_seasons' "; 
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not access seasons table.", '', __LINE__, __FILE__, $sql);

	//define the new period
	$new_time = $board_config['adr_seasons_last_time'] +  $board_config['adr_seasons_time'];

	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$new_time' 
		WHERE config_name = 'adr_seasons_last_time' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $sql);
	$db->clear_cache('config_');
}