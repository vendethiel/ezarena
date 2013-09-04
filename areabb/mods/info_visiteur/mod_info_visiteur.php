<?php
// ------------------------------------------------------------------------------------------------
/*
		info_visiteur Par Saint-Pere
*/
// ------------------------------------------------------------------------------------------------

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}
$template->set_filenames(array(
	'info_visiteur' =>  'areabb/mods/info_visiteur/tpl/mod_info_visiteur.tpl')
);

// on appele notre boite à outils... qui pourra être réutilisée
include_once($phpbb_root_path . 'areabb/mods/info_visiteur/class_info_visiteur.'.$phpEx);
global $lang;
load_lang('info_visiteur');

// On charge nos infos
$info_visiteur = new info_visiteur();

$ip			= $info_visiteur->get_ip(); //récupération de l'IP
$host		= gethostbyaddr($ip); // hôte
$browser	= $info_visiteur->get_browser($_SERVER['HTTP_USER_AGENT']); // Navigateur
$langue		= $info_visiteur->get_langue($_SERVER['HTTP_ACCEPT_LANGUAGE']); // langue
$system		= $info_visiteur->get_os($_SERVER['HTTP_USER_AGENT']); //systeme d'exploitation
$origine	= $_SERVER['HTTP_REFERER']; // page d'où le visiteur vient

$template->assign_vars(array(
	'IP'				=> $ip,
	'HOST'				=> $host,
	'BROWSER' 			=> $browser,
	'OS'				=> $system,
	'LANGUE'			=> $langue,
	'L_LANGUE'			=> $lang['L_LANGUE'],
	'L_IP'				=> $lang['L_IP'],
	'L_HOST'			=> $lang['L_HOST'],
	'L_BROWSER'			=> $lang['L_BROWSER'],
	'L_OS'				=> $lang['L_OS'],
	'L_ORIGINE'			=> sprintf($lang['L_ORIGINE'],$origine),
	'L_INFO_VISITEUR'	=> $lang['L_INFO_VISITEUR']
));


	
$template->assign_var_from_handle('info_visiteur', 'info_visiteur');

?>