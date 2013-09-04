<?php
/*********************************************************************
		  mod_calendrier.php

  Le 20 Août 2006 par Saint-Pere - www.yep-yop.com

  Ce bloc affiche un calendrier vous permettant de parcourrir les news 
  par leur date
  
**********************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

//chargement du template
$template->set_filenames(array(
   'calendrier' => 'areabb/mods/calendrier/tpl/calendrier.tpl'
));

// Appel au script du calendrier
require_once('areabb/mods/calendrier/calendar.php');
// Parametrage
$params = array(
   'LANGUAGE_CODE'		=> 'fr',
   'OUTPUT_MODE'		=> 'return',
   'DATE_URL'			=> append_sid(NOM_NEWS.'.'.$phpEx.'?action=date'),
   'FIRST_WEEK_DAY'		=> 1,
   'URL_PARAMETER'		=> 'date_news',
   'URL_DAY_DATE_FORMAT'=> 'Y-m-d'
   
);
// Affichage
$affichage_calendrier = Calendar($params);


$template->assign_vars(array(
	'L_CALENDRIER'	=> $lang['L_CALENDRIER'],
	'CALENDRIER' => $affichage_calendrier
));


$template->assign_var_from_handle('calendrier', 'calendrier'); 
?>