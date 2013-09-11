<?php
/***************************************************************************
 *                              page_tail.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: page_tail.php,v 1.27.2.4 2005/09/14 18:14:30 acydburn Exp $
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
	die('Hacking attempt');
}

// BEGIN RPG
if ( ( time() - $board_config['adr_seasons_last_time'] ) > $board_config['adr_seasons_time'] ) 
{ 
   include_once($php_root_path . 'adr/includes/functions_adr_seasons_cron.'.$phpEx); 
} 

if ( ( time() - $board_config['adr_time_last_time'] ) > $board_config['adr_time'] )
{
	include_once($php_root_path . 'adr/includes/functions_adr_time_cron.'.$phpEx);
}

if ( $board_config['rabbitoshi_enable_cron'] && ( ( time() - $board_config['rabbitoshi_cron_last_time'] ) > $board_config['rabbitoshi_cron_time'] )) 
{ 
   include_once($php_root_path . 'includes/functions_rabbitoshi_cron.'.$phpEx); 
} 
// END RPG

global $do_gzip_compress;

//
// Show the overall footer.
//
$template->set_filenames(array(
	'overall_footer' => ( empty($gen_simple_header) ) ? 'overall_footer.tpl' : 'simple_footer.tpl')
);
//
// Cached Generation
//
$page_gen_time = sprintf('%.5f', microtime_float() - $GLOBALS['page_gen_start']);

$template->assign_vars(array(
	// Cached Generation	
	'PAGE_GENERATION' => sprintf($lang['debug_generation'], $page_gen_time),
	'MYSQL_QUERIES' => sprintf($lang['sql_queries'], $db->num_queries),
	'PREMOD' => sprintf($lang['Premod'], $board_config['ezarena_version']) . '</strong>',
	'STYLE_C' => $lang['style_copyright'],
	'TRANSLATION_INFO' => (isset($lang['TRANSLATION_INFO'])) ? $lang['TRANSLATION_INFO'] :
	((isset($lang['TRANSLATION'])) ? $lang['TRANSLATION'] : ''),
));

$template->pparse('overall_footer');

//
// Close our DB connection.
//
$db->sql_close();

//
// Compress buffered output if required and send to browser
//
if ( $do_gzip_compress )
{
	//
	// Borrowed from php.net!
	//
	$gzip_contents = ob_get_contents();
	ob_end_clean();

	$gzip_size = strlen($gzip_contents);
	$gzip_crc = crc32($gzip_contents);

	$gzip_contents = gzcompress($gzip_contents, 9);
	$gzip_contents = substr($gzip_contents, 0, strlen($gzip_contents) - 4);

	echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	echo $gzip_contents;
	echo pack('V', $gzip_crc);
	echo pack('V', $gzip_size);
}
if (DEBUG)
{
	echo '<h1>Queries : </h1><pre>';
	foreach ($db->queries as $dummy)
	{
		$query = $dummy[0]; $t = $dummy[2];
		$bt = str_replace($query, '**QUERY**', $dummy[1]);
		// list($query, $bt) = each($dummy);
		echo "$query<br/>$bt<br/>${t}s<br/><br/><hr/>";
	}
	echo '</pre>';
}
exit;