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
/*


*/
$requetes = array (
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('news_forums', '1');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('news_nbre_mots', '500');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('news_nbre_coms', '20');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('news_nbre_news', '10');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('news_aff_icone', '0');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('news_aff_coms', '1');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('news_aff_asv', '1');"
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