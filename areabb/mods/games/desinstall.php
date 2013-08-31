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
	"ALTER TABLE `".$table_prefix."users`
  DROP `areabb_variable`,
  DROP `areabb_tps_depart`,
  DROP `areabb_gid`;",
  "DROP TABLE `".$table_prefix."areabb_categories`, 
	`".$table_prefix."areabb_games`, 
	`".$table_prefix."areabb_hackgame`, 
	`".$table_prefix."areabb_note`, 
	`".$table_prefix."areabb_scores`;",
"DELETE FROM `".$table_prefix."areabb_config` WHERE `nom` = 'chemin_pkg_jeux' OR `nom` = 'forum_presente' OR `nom` = 'presente' 
OR `nom` = 'nbre_topics_min'  OR `nom` = 'avoir_poste_joue'  OR `nom` = 'games_time_tolerance'  OR `nom` = 'game_popup' 
OR `nom` = 'affichage_nbre_jeux' OR `nom` = 'affichage_icone' OR `nom` = 'affichage_categorie'  OR `nom` = 'affichage_jeux'  
OR `nom` = 'format_pag'  OR `nom` = 'auth_dwld'  OR `nom` = 'games_par_page' OR `nom` = 'game_order'  OR `nom` = 'group_vip' 
 OR `nom` = 'nom_group_vip';"
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