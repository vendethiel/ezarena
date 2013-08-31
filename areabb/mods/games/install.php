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

// on rajoute une salle arcade.php
load_function('class_squelette');
$squelette = new generation_squelette($phpbb_root_path);
$squelette->ajouter_squelette('Arcade de jeux Flash','1');

$salle_arcade = $db->sql_nextid($result);
// on met en place la premiere page par défaut.
$sql = 'SELECT id_squelette FROM '.AREABB_SQUELETTE.' WHERE type=\'1\'';
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
}
if ($db->sql_numrows($result) == 1)
{
	$sql = 'SELECT nom FROM '.AREABB.' WHERE nom=\'arcade_par_defaut\'';
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
	}
	if ($db->sql_numrows($result) > 0)
	{
		$sql = 'UPDATE '. AREABB .' 
				SET valeur='.$salle_arcade.'
				WHERE nom=\'arcade_par_defaut\'';
		if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
			}
	}else{
			$sql = 'INSERT INTO '. AREABB .' (valeur, nom) VALUES ('.$salle_arcade.',\'arcade_par_defaut\')';
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
			}
	}
}
// On rajoute une feuille
$squelette->id_squelette = $salle_arcade;
$squelette->ajouter_feuille('3');
	

// on rajoute une salle games.php
$squelette->ajouter_squelette('Partie engagée - Bonne chance','2');

$dernier_squelette = $db->sql_nextid($result);
// on met en place la premiere page par défaut.
$sql = 'SELECT id_squelette FROM '.AREABB_SQUELETTE.' WHERE type=\'2\'';
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
}
if ($db->sql_numrows($result) == 1)
{
	$sql = 'SELECT nom FROM '.AREABB.' WHERE nom=\'games_par_defaut\'';
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
	}
	if ($db->sql_numrows($result) > 0)
	{
		$sql = 'UPDATE '. AREABB .' 
				SET valeur='.$dernier_squelette.'
				WHERE nom=\'games_par_defaut\'';
		if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
			}
	}else{
			$sql = 'INSERT INTO '. AREABB .' (valeur, nom) VALUES ('.$dernier_squelette.',\'games_par_defaut\')';
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
			}
	}
}	
// On rajoute une feuille
$squelette->id_squelette = $dernier_squelette;
$squelette->ajouter_feuille('1');



$requetes = array (
"CREATE TABLE `".$table_prefix."areabb_categories` (
  `arcade_catid` smallint(6) NOT NULL auto_increment,
  `arcade_parent` int(11) NOT NULL default '0',
  `arcade_cattitle` varchar(100) NOT NULL default '',
  `salle` int(11) NOT NULL default '0',
  `arcade_nbelmt` mediumint(8) unsigned NOT NULL default '0',
  `arcade_catorder` mediumint(8) unsigned NOT NULL default '0',
  `arcade_icone` varchar(100) default NULL,
  KEY `arcade_catid` (`arcade_catid`)
);",
"CREATE TABLE `".$table_prefix."areabb_note` (
  `game_id` smallint(6) NOT NULL default '0',
  `user_id` smallint(6) NOT NULL default '0',
  `note` tinyint(4) NOT NULL default '0'
)",
"CREATE TABLE `".$table_prefix."areabb_scores` (
  `game_id` mediumint(8) NOT NULL default '0',
  `user_id` mediumint(8) NOT NULL default '0',
  `score_game` int(11) unsigned NOT NULL default '0',
  `score_date` int(11) NOT NULL default '0',
  `score_time` int(11) NOT NULL default '0',
  `score_set` mediumint(8) NOT NULL default '0',
  KEY `game_id` (`game_id`),
  KEY `user_id` (`user_id`)
)",
"CREATE TABLE `".$table_prefix."areabb_games` (
  `game_id` mediumint(8) NOT NULL auto_increment,
  `game_pic` varchar(50) NOT NULL default '',
  `game_pic_large` varchar(50) default NULL,
  `game_desc` varchar(255) NOT NULL default '',
  `game_highscore` int(11) NOT NULL default '0',
  `game_highdate` int(11) NOT NULL default '0',
  `game_highuser` mediumint(8) NOT NULL default '0',
  `game_name` varchar(50) NOT NULL default '',
  `game_libelle` varchar(50) NOT NULL default '',
  `game_date` int(11) NOT NULL default '0',
  `game_swf` varchar(50) NOT NULL default '',
  `game_scorevar` varchar(20) NOT NULL default '',
  `game_type` tinyint(4) NOT NULL default '0',
  `game_width` mediumint(5) NOT NULL default '550',
  `game_height` varchar(5) NOT NULL default '380',
  `game_order` mediumint(8) NOT NULL default '0',
  `game_set` mediumint(8) NOT NULL default '0',
  `arcade_catid` mediumint(8) unsigned NOT NULL default '0',
  `game_cheat_control` tinyint(1) NOT NULL default '0',
  `note` smallint(5) unsigned NOT NULL default '2',
  `clics_pkg` int(11) default '0',
  `clics_zip` int(11) default '0',
  KEY `game_id` (`game_id`)
);",
"CREATE TABLE `".$table_prefix."areabb_hackgame` (
  `id_hack` int(11) NOT NULL auto_increment,
  `user_id` mediumint(8) NOT NULL default '0',
  `game_id` mediumint(8) NOT NULL default '0',
  `date_hack` int(11) NOT NULL default '0',
  `id_modo` int(11) default NULL,
  `flashtime` int(11) NULL default '0',
  `realtime` int(11) NULL default '0',
  `score` float NULL default '0',
  `type` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_hack`)
)","ALTER TABLE `".$table_prefix."users` ADD `areabb_gid` INT( 5 ) ,ADD `areabb_tps_depart` INT( 11 ) ,ADD `areabb_variable` INT( 10 ) ;",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('nom_group_vip', '2');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('group_vip', '0');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('games_par_page', '20');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('game_order', 'Fixed');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('auth_dwld', '0');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('format_pag', '2');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('affichage_jeux', '2');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('affichage_categorie', '2');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('affichage_icone', '1');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('affichage_nbre_jeux', '1');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('game_popup', '0');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('games_time_tolerance', '4');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('avoir_poste_joue', '0');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('nbre_topics_min', '5');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('presente', '0');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('forum_presente', '1');",
"INSERT INTO `".$table_prefix."areabb_config` VALUES ('chemin_pkg_jeux', 'areabb/games/');",
"INSERT INTO `".$table_prefix."areabb_categories` VALUES (1, 0, 'Sports', ".$salle_arcade.", 0, 10, 'basket.jpg');",
"INSERT INTO `".$table_prefix."areabb_categories` VALUES (2, 0, 'Billard', ".$salle_arcade.", 0, 20, 'billard.jpg');",
"INSERT INTO `".$table_prefix."areabb_categories` VALUES (3, 0, 'Bowling', ".$salle_arcade.", 0, 30, 'bowling.jpg');",
"INSERT INTO `".$table_prefix."areabb_categories` VALUES (4, 0, 'Jeux de cartes', ".$salle_arcade.", 0, 40, 'carte.jpg');",
"INSERT INTO `".$table_prefix."areabb_categories` VALUES (5, 0, 'Shoot', ".$salle_arcade.", 0, 50, 'counter_strike.jpg');",
"INSERT INTO `".$table_prefix."areabb_categories` VALUES (6, 0, 'Echecs', ".$salle_arcade.", 0, 60, 'echiquier.jpg');",
"INSERT INTO `".$table_prefix."areabb_categories` VALUES (7, 0, 'Pacman', ".$salle_arcade.", 0, 70, 'pac_man.jpg');",
"INSERT INTO `".$table_prefix."areabb_categories` VALUES (8, 0, 'Courses auto', ".$salle_arcade.", 0, 80, 'voiture.jpg');"
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