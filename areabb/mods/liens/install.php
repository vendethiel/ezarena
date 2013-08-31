<?php
/*********************************************************
		install.php

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
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('liens_nbre_liens', '0');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('liens_aleatoire', '0');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('liens_cache', '1');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('liens_scroll', '1');",
"CREATE TABLE `".$table_prefix."areabb_liens` (
`id_lien` SMALLINT NOT NULL AUTO_INCREMENT ,
`titre` VARCHAR( 255 ) NOT NULL ,
`lien` VARCHAR( 255 ) NOT NULL ,
`ordre` SMALLINT UNSIGNED DEFAULT '99' NOT NULL ,
`vignette` VARCHAR( 255 ) ,
PRIMARY KEY ( `id_lien` )
);"
);

$nbre_requetes = sizeof($requetes);

for ($i=0;$i < $nbre_requetes; $i++)
{
	if( !($result = $db->sql_query($requetes[$i])) )
	{
		message_die(GENERAL_ERROR, "Impossible de lancer cette requete d\'installation", '', __LINE__, __FILE__, $requetes[$i]);
	}	
}

?>