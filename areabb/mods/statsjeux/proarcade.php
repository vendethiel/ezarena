<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $userdata,$lang;
load_lang('arcade');
define('ROOT_STYLE','page');

ob_start();

//chargement du template
$template->set_filenames(array(
   'statsarcade' => 'areabb/mods/statsjeux/tpl/statsarcade.tpl'
));

//
// Nombre de Jeux
// Nombre de parties jouées

$sql = 'SELECT count(game_id) AS nbj,sum(game_set) AS total_partie  
		FROM ' .AREABB_GAMES_TABLE ;
if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query games information", "", __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);
$template->assign_vars(array(
	'ARCADE_JEUX' 			=> $row['nbj'],
	'ARCADE_TOTAL_PARTIE'	=> $row['total_partie']
));
// -------------------------------------------------------------------------------------------------------------------------------


//
// Temps total joué
// Nombre de joueurs sur l'Arcade

$sql = 'SELECT sum(score_time) AS score_time , count(DISTINCT user_id) AS total_user 
		FROM ' .AREABB_SCORES_TABLE;
if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query games information", "", __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);
$heur2	= intval( $row['score_time']/ 3600) ;
$min2	= intval($row['score_time'] / 60  - ( $heur2 * 60 ));
$sec2	= $row['score_time'] - (( $min2 * 60 )+ ( $heur2 * 3600 ));
$template->assign_vars(array(
	'ARCADE_TOTAL_USER' => $row['total_user'],
	'ARCADE_TIME'		=> ( $row['score_time'] == 0 ) ? "n/a" :  ( ($heur2 >0 ) ? $heur2 . "" . $lang['topstatheure'] . ":" .$min2 . "" . $lang['topstatminute'] . ":" . $sec2 . "" . $lang['topstatseconde'] : (($min2 >0 ) ? $min2 . "" . $lang['topstatminute'] . ":" . $sec2 . "" . $lang['topstatseconde']: $sec2 . "" . $lang['topstatseconde']))
));
// -------------------------------------------------------------------------------------------------------------------------------




//
// User ayant le + de Victoires 
// Nombre de victoires

$sql = 'SELECT count(  `game_highuser`  ) as topVictoire,username,u.user_id 
		FROM  ' .AREABB_GAMES_TABLE .' as g 
		LEFT JOIN '.USERS_TABLE .' as u 
		ON (g.game_highuser=u.user_id) 
		WHERE `game_highuser` > 0 
		GROUP  BY  `game_highuser` 
		ORDER BY topVictoire DESC';
if( !($result = $db->sql_query($sql)) )
{
	message_die(CRITICAL_ERROR, "Could not query games information", "", __LINE__, __FILE__, $sql);
}
$personbre_topVictoire = $i=0;
while ($row = $db->sql_fetchrow($result))
{
	// User ayant le plus de victoires
	if ($i == 0)
	{
		$nom_topVictoire = areabb_profile($row['user_id'],$row['username']);
		$nbre_topVictoire = $row['topVictoire'];
	}
	// Victoires du User connecté
	if ($userdata['user_id'] == $row['user_id'])
	{
		$perso_topVictoire = areabb_profile($row['user_id'],$row['username']);
		$personbre_topVictoire = $row['topVictoire'];
	}
	$i++;
}



$template->assign_vars(array(
	'ARCADE_TOP_VICTOIRE' =>sprintf("%s (%s %s)",$nom_topVictoire,$nbre_topVictoire,$lang['topstatvictoire'])
));
// -------------------------------------------------------------------------------------------------------------------------------





//
// Temps total de jeu
// Nbre total de parties
// Idem mais pour le user

$sql = 'SELECT sum(s.score_time) as topTemps,sum(score_set)as topPartie, u.username,u.user_id 
		FROM  ' .AREABB_SCORES_TABLE .' as s 
		LEFT JOIN ' .USERS_TABLE .' as u 
		ON (s.user_id=u.user_id) 
		GROUP BY s.user_id 
		ORDER BY TopTemps DESC';
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'acceder aux tables users/scores/games", '', __LINE__, __FILE__, $sql); 
}
$maxPartie = $i = 0;
while ($row=$db->sql_fetchrow($result))
{
	// Nombre de parties max
	if ($maxPartie<$row['topPartie']) 
	{
		$maxPartie=$row['topPartie'];
		$nom_topPartie = areabb_profile($row['user_id'],$row['username']);
	}
	// Nombres d'heures max
	if ($i == 0)
	{
		$nom_topTemps	= areabb_profile($row['user_id'],$row['username']);
		$maxTemps		= $row['topTemps'];
		$heur			= intval( $maxTemps/ 3600) ;
		$min			= intval($maxTemps / 60  - ( $heur * 60 ));
		$sec			= $maxTemps - (( $min * 60 )+ ( $heur * 3600 ));
	}
	// Infos du user qui joue
	if ($userdata['user_id'] == $row['user_id'])
	{
		$topTempsPerso	= $row['topTemps'];
		$topPartiePerso = ($row['topPartie']==NULL) ? 0:$row['topPartie'];
	}
	$i++;
}
$heur3 = intval( $topTempsPerso/ 3600) ;
$min3 = intval($topTempsPerso / 60  - ( $heur3 * 60 ));
$sec3 = $topTempsPerso - (( $min3 * 60 )+ ( $heur3 * 3600 ));
$template->assign_vars(array(
	'TOP_TEMPS'			=> sprintf("%s (%s)",$nom_topTemps,( $maxTemps == 0 ) ? "n/a" :  ( ($heur >0 ) ? $heur . "" . $lang['topstatheure'] . ":" .$min . "" . $lang['topstatminute'] . ":" . $sec. "" . $lang['topstatseconde'] : (($min >0 ) ? $min . "" . $lang['topstatminute'] . ":" . $sec . "" . $lang['topstatseconde']: $sec . "" . $lang['topstatseconde']))),
	'TOP_PARTIE'		=> sprintf("%s (%s %s)",$nom_topPartie,$maxPartie,$lang['topstatpartie'])
));
// -------------------------------------------------------------------------------------------------------------------------------

ob_get_status();
//
// Génération du fichier de cache

$template->pparse('statsarcade');
$template->destroy();
$recuperation_sortie = ob_get_clean();
$recuperation_sortie = str_replace('[','{',$recuperation_sortie);
$recuperation_sortie = str_replace(']','}',$recuperation_sortie);
ob_end_clean();
// ecriture du fichier de cache
$rFile = @fopen('areabb/cache/statsjeux.tpl',"w+");
if (!$rFile) {
	return "ERREUR: Impossible d'ecrire dans le dossier 1 " . dirname(realpath('areabb/cache/statsjeux.tpl')) ." (avez vous fait un CHMOD 777 ? )" ;
}
fwrite($rFile,$recuperation_sortie);
fclose($rFile);
unset($recuperation_sortie,$rFile);
// -------------------------------------------------------------------------------------------------------------------------------



//
//  Génération du template PERSO du user
ob_start();
ob_clean();

//chargement du template
$template->set_filenames(array(
   'perso' => 'areabb/mods/statsjeux/tpl/statsarcade_perso.tpl'
));

$template->assign_vars(array(
	'VICTOIRE_PERSO'	=> $personbre_topVictoire,
	'TOP_TEMPS_PERSO'	=> ($topTempsPerso == 0 ) ? "n/a" :  ( ($heur3 >0 ) ? $heur3 . "" . $lang['topstatheure'] . ":" .$min3 . "" . $lang['topstatminute'] . ":" . $sec3 . "" . $lang['topstatseconde'] : (($min3 >0 ) ? $min3 . "" . $lang['topstatminute'] . ":" . $sec3 . "" . $lang['topstatseconde']: $sec3 . "" . $lang['topstatseconde'])),
	'TOP_PARTIE_PERSO'	=> sprintf("%s %s",$topPartiePerso,$lang['topstatpartie'])
));

//
// Génération du fichier de cache

$template->pparse('perso');
$template->destroy();
$recuperation_sortie = ob_get_clean();
$recuperation_sortie = str_replace("[","{",$recuperation_sortie);
$recuperation_sortie = str_replace("]","}",$recuperation_sortie);

ob_end_clean();
// ecriture du fichier de cache
$rFile = @fopen('areabb/cache/statsjeux_'.$userdata['user_id'].'.tpl',"w+");
if (!$rFile) {
	return "ERREUR: Impossible d'ecrire dans le dossier 1 " . dirname(realpath('areabb/cache/statsjeux_'.$userdata['user_id'].'.tpl')) ." (avez vous fait un CHMOD 777 ? )" ;
}
fwrite($rFile,$recuperation_sortie);
fclose($rFile);
// -------------------------------------------------------------------------------------------------------------------------------

?>