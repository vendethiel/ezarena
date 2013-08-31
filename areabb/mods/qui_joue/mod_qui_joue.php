<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $lang,$userdata,$squelette;
load_lang('arcade');
load_function('class_liste_jeux');

$quijoue = new liste_jeux();

unset($squelette->groupes_autorises);

$template->set_filenames(array(
      'qui_joue' => 'areabb/mods/qui_joue/tpl/mod_qui_joue.tpl'
));


$sql = 'SELECT u.user_id,s.session_user_id,u.username, s.areabb_gid,g.game_name,g.game_pic,g.game_width,g.game_height, g.game_libelle, q.groupes   
		FROM '.SESSIONS_TABLE.' as s LEFT JOIN '.USERS_TABLE.' as u 
		ON (s.session_user_id=u.user_id ) 
		LEFT JOIN '.AREABB_GAMES_TABLE.' as g 
		ON (s.areabb_gid=g.game_id) 
		LEFT JOIN '.AREABB_CATEGORIES_TABLE.' as c
		ON (g.arcade_catid=c.arcade_catid)
		LEFT JOIN '.AREABB_SQUELETTE.' as q
		ON (c.salle=q.id_squelette)
		WHERE session_logged_in = 1 
		AND s.areabb_tps_depart > '.(time()-900).'
		ORDER BY s.areabb_tps_depart DESC ';

if ( !($result = $db->sql_query($sql)) ) 
{
	message_die(GENERAL_ERROR, 'Could not obtain forum information', '', __LINE__, __FILE__, $sql);
}
if ($db->sql_numrows($result) == 0)
{
	$template->assign_block_vars('aucun_joueur', array());
}else{
	unset($liste_joueurs);
	$liste_jeux = array();
	$joueurs = array();
	$i = 0;
	while ($row = $db->sql_fetchrow($result))
	{
		if ($squelette->salle_autorisee($row['groupes']))
		{
			if (!in_array($row['areabb_gid'],$liste_jeux))	$liste_jeux[] = $row['areabb_gid'];
			if (!in_array($row['user_id'],$joueurs))
			{
				$liste_joueurs[$row['areabb_gid']][$i] = array(
					'user_id' 		=> $row['user_id'],
					'username'		=> $row['username'],
					'game_id'		=> $row['areabb_gid'],
					'game_name' 	=> $row['game_name'],
					'game_pic'		=> $row['game_pic'],
					'game_height'	=> $row['game_height'],
					'game_width'	=> $row['game_width'],
					'game_libelle'	=> $row['game_libelle']);
				$joueurs[] = $row['user_id'];
				$i++;
			}
		}
	}
	$max_jeux = count($liste_jeux);
	for($a=0;$a<$max_jeux;$a++)
	{
		unset($joueurs,$info_jeu);
		$max_joueurs = count($liste_joueurs[$a]);
		while (is_array($liste_joueurs[$liste_jeux[$a]]) && list($key, $joueur) = each($liste_joueurs[$liste_jeux[$a]]))
		{
			$virgule  = ($joueurs != '')? ',':'';
			$joueurs .= $virgule.areabb_profile($joueur['user_id'],$joueur['username']);
			$info_jeu = $joueur;
		}
		if ($joueurs != '')
		{
			$template->assign_block_vars('liste_qui_joue', array(
				'ICONE' 	=> 'areabb/games/'. $info_jeu['game_name'].'/'.$info_jeu['game_pic'],
				'JEU'		=> $quijoue->definir_lancement_jeu($info_jeu['game_id'],$info_jeu['game_width'],$info_jeu['game_height']).$info_jeu['game_libelle'].'</a>',
				'JOUEURS'	=> $joueurs		
			));
		}
	}
}

$template->assign_vars(array(	
	'L_QUI_JOUE_TITRE'	=> $lang['L_QUI_JOUE_TITRE'],
	'L_NO_JOUEUR'		=> $lang['L_NO_JOUEUR']
));


$template->assign_var_from_handle('qui_joue', 'qui_joue');
?>