<?php
/********************************************************
	mod_record_battu.php


*********************************************************/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $lang,$squelette;
if (file_exists('areabb/cache/mod_record_battu.tpl'))
{
	load_lang('arcade');

	//chargement du template
	$template->set_filenames(array(
	   'record_battu' =>'areabb/cache/mod_record_battu.tpl'
	));

	$template->assign_vars(array(
		'L_TOP_CHAMPIONS'	=> $lang['L_TOP_CHAMPIONS'],
		'L_EST_CHAMPION'	=> $lang['L_EST_CHAMPION']
	));

	$template->assign_var_from_handle('record_battu', 'record_battu');
}
?>