<?php
/*********************************************************
		desinstall.php

  Créé le 08/08/2006 par Saint-Pere

  Si votre mod requiert l'éxecution de requêtes 
  servez-vous de ce script


*********************************************************/

if (!defined('IN_PHPBB'))
{
	die("Hacking attempt");
}

global $lang,$userdata,$db,$table_prefix;

// 2 précautions valent mieux qu'une
if ($userdata['user_level'] != ADMIN)
{
	message_die(GENERAL_MESSAGE, $lang['Not_admin']);
}

$requetes = array (
	"delete from `".$table_prefix."areabb_config` WHERE arcade_name = 'news_nbre_mots'",
	"delete from `".$table_prefix."areabb_config` WHERE arcade_name = 'news_aff_asv'",
	"delete from `".$table_prefix."areabb_config` WHERE arcade_name = 'news_forums'",
	"delete from `".$table_prefix."areabb_config` WHERE arcade_name = 'news_nbre_coms'",
	"delete from `".$table_prefix."areabb_config` WHERE arcade_name = 'news_nbre_news'",
	"delete from `".$table_prefix."areabb_config` WHERE arcade_name = 'news_aff_icone'",
	"delete from `".$table_prefix."areabb_config` WHERE arcade_name = 'news_aff_coms'"
);

$nbre_requetes = sizeof($requetes);

for ($i=0;$i < $nbre_requetes; $i++)
{
	if( !($result = $db->sql_query($requetes[$i])) )
	{
		message_die(GENERAL_ERROR, "Impossible de lancer cette requete de désinstallation", '', __LINE__, __FILE__, $requetes[$i]);
	}	
}

?>