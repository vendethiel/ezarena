<?php

/**************************************************************************
                                mod_minichat.php


***************************************************************************/


if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $board_config,$userdata,$board_config;

$template->set_filenames(array(
	  'minichat' => 'areabb/mods/minichat/tpl/mod_minichat.tpl'
));

$template->assign_var('U_SHOUTBOX', append_sid("shoutbox.$phpEx"));

$template->pparse('minichat');