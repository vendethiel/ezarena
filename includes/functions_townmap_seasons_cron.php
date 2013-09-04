<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

if ( !$board_config['townmap_seasons_cron_last_time'] )
{
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = ".time()." WHERE config_name = 'townmap_seasons_cron_last_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $lsql); 
	} 
	$board_config['townmap_seasons_cron_last_time']  = time();
	$db->clear_cache('config_');
}

if ( ( time() - $board_config['townmap_seasons_cron_last_time'] ) > $board_config['townmap_seasons_cron_time'])
{
$carte = '';

$sql = "select  townmap_map  from " . ADR_TOWNMAPMAP_TABLE ;
if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, "Could not acces TownMapMAP table.", '', __LINE__, __FILE__, $sql);
if ($alignments = $db->sql_fetchrow($result))
{
	$carte = $alignments['townmap_map'];
}
	if ( $carte == '1' ) 
	{
	$changement = '2';
	}

	if ( $carte == '2' ) 
	{
	$changement = '3';
	}

	if ( $carte == '3' ) 
	{
	$changement = '4';
	}

	if ( $carte == '4' ) 
	{
	$changement = '1';
	}

	// mettre à jour la bdd
	$dsql = "select  townmap_map  from " . ADR_TOWNMAPMAP_TABLE ;
	if ( !($dresult = $db->sql_query($dsql)) ) message_die(GENERAL_ERROR, "Could not acces TownMapMAP table.", '', __LINE__, __FILE__, $dsql);
	$exist = ($row = $db->sql_fetchrow($dresult));
	if (!$exist)
	{
	// création
	$sql = "insert into " . ADR_TOWNMAPMAP_TABLE . "(townmap_map) VALUES  ('$changement')";
	if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, "Could not acces TownMapMAP table.", '', __LINE__, __FILE__, $sql);
	}
	else
	{
	// mise à jour
	$sql ="update " . ADR_TOWNMAPMAP_TABLE . " set townmap_map='$changement'"; 
	if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, "Could not acces TownMapMAP table.", '', __LINE__, __FILE__, $sql);
	}

	//défini la nouvelle periode
	$new_time = $board_config['townmap_seasons_cron_last_time'] +  $board_config['townmap_seasons_cron_time'];

	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = $new_time WHERE config_name = 'townmap_seasons_cron_last_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $lsql); 
	}
	$db->clear_cache('config_');
}