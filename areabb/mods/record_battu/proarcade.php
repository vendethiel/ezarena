<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $userdata,$lang,$cas_score;
load_lang('arcade');
define('ROOT_STYLE','page');

// On veut combien de champions ??
$limite_champions = 5;
	
	
// Si le user a battu le record on charge la liste des champions en cache.
if ($cas_score > 2)
{
	// Chargement de la librairie de lancement des jeux
	load_function('class_liste_jeux');
	$record_battu = new liste_jeux();

	// Chargement de la class squelette pour verifier les droits d'accès à ce jeu
	load_function('class_squelette');
	$squelette = new generation_squelette();

	// On bloque le flux de sortie vers le tampon
	ob_start();
	ob_clean();
	//chargement du template
	$template->set_filenames(array(
	   'record_battu' =>'areabb/mods/record_battu/tpl/mod_record_battu.tpl'
	));


	$sql = 'SELECT g.game_id, game_name,game_pic,game_width,game_height, game_libelle, game_highuser, username, game_highscore, game_highdate, q.groupes 
		FROM ' . AREABB_GAMES_TABLE . ' as g 
		LEFT JOIN ' . USERS_TABLE . ' as u 
		ON (g.game_highuser = u.user_id) 
		LEFT JOIN '.AREABB_CATEGORIES_TABLE.' as c
		ON (g.arcade_catid=c.arcade_catid)
		LEFT JOIN '.AREABB_SQUELETTE.' as q
		ON (c.salle=q.id_squelette)
		WHERE game_highscore > 0	
		ORDER BY game_highdate DESC
		LIMIT '.$limite_champions;
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not query recent topics information', '', __LINE__, __FILE__, $sql);
	}
	$i = 0;
	while ($row = $db->sql_fetchrow($result))
	{
		if ($squelette->salle_autorisee($row['groupes']))
		{
			$class =  ($class == 'row2')? 'row1' : 'row2';
			$template->assign_block_vars('champions', array(
				'USER'		=> areabb_profile($row['game_highuser'],$row['username']),
				'JEU'		=> $row['game_libelle'],
				'ICONE'		=> CHEMIN_JEU.$row['game_name'].'/'.$row['game_pic'],
				'LIEN'		=> $record_battu->definir_lancement_jeu($row['game_id'],$row['game_width'],$row['game_height']),
				'DATE'		=> date('d/m/Y à H:i',$row['game_highdate']),
				'CLASS'		=> $class
			));
		}
	}

	ob_get_status();
	//
	// Génération du fichier de cache

	$template->pparse('record_battu');
	$template->destroy();
	$recuperation_sortie = ob_get_clean();
	$recuperation_sortie = str_replace('[','{',$recuperation_sortie);
	$recuperation_sortie = str_replace(']','}',$recuperation_sortie);
	ob_end_clean();
	// ecriture du fichier de cache
	$rFile = @fopen('areabb/cache/mod_record_battu.tpl',"w+");
	if (!$rFile) {
		return "ERREUR: Impossible d'ecrire dans le dossier 1 " . dirname(realpath('areabb/cache/mod_record_battu.tpl')) ." (avez vous fait un CHMOD 777 ? )" ;
	}
	fwrite($rFile,$recuperation_sortie);
	fclose($rFile);
	unset($recuperation_sortie,$rFile);
// -------------------------------------------------------------------------------------------------------------------------------
}
?>