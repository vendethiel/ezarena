<?php
/**********************************************************
			mod_meteo.php

***********************************************************/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $lang;
load_lang('meteo');


$template->set_filenames(array(
   'meteo' => 'areabb/mods/meteo/tpl/mod_meteo.tpl')
);

$template->assign_vars(array(	
	'L_MOD_METEO'		=> $lang['L_MOD_METEO'],
	'L_DEFINIR_VILLE'	=> $lang['L_DEFINIR_VILLE'],
	'L_TA_VILLE'		=> $lang['L_TA_VILLE'],
	'L_GO'				=> $lang['L_GO']
));

$template->assign_var_from_handle('meteo', 'meteo');

?>