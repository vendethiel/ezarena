<?php
// -------------------------------------------------------------------
//
//					admin_hackgame.php
//
//
// -------------------------------------------------------------------

define('IN_PHPBB', 1);


if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['AreaBB Arcade']['Gestion des tricheurs'] = '../areabb/mods/games/'.$file;
	return;
}

//
// Let's set the root dir for phpBB
//
define('ROOT_STYLE','admin');
$phpbb_root_path = '../../../';
require($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
load_lang('admin');
load_lang('admin_arcade');
load_function('fonctions_chaine');


// --------------------------------------------------------------------------------------------
// TRAITEMENT DES PARAMETRES
//
if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action = $HTTP_POST_VARS['action']; 
		$id_hack	= eregi_replace('[^0-9]','',$HTTP_POST_VARS['id_hack']);
	}else{
		$action = $HTTP_GET_VARS['action'];
		$id_hack	= eregi_replace('[^0-9]','',$HTTP_GET_VARS['id_hack']);
	}
	

	switch($action)
	{
		case 'retablir':
			// On récupère les infos sur ce hack
			$sql = 'SELECT * FROM '.AREABB_HACKGAME_TABLE.' WHERE  id_hack='.$id_hack;
			if(!$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de récupérer les infos sur ce hack', '', __LINE__, __FILE__, $sql);
			}
			$infos_hack = $db->sql_fetchrow($result);
			// Ce score est-il le meilleur ?
			$sql = 'SELECT score_game FROM '.AREABB_SCORES_TABLE.' WHERE game_id='.$infos_hack['game_id'].' ORDER BY score_game DESC LIMIT 1';
			if(!$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de récupérer les infos sur les scores de ce hack', '', __LINE__, __FILE__, $sql);
			}
			$infos = $db->sql_fetchrow($result);
			
			if ($infos['score_game'] < $infos_hack['score'])
			{
				// le record a été battu on mets à jour la table areabb_games.
				$sql = 'UPDATE '.AREABB_GAMES_TABLE.' 
						SET game_highscore='.$infos_hack['score'].', 
							game_highdate='.$infos_hack['date_hack'].', 
							game_highuser ='.$infos_hack['user_id'].'
						WHERE game_id='.$infos_hack['game_id'];
				$db->sql_query($sql);
			}
			// Cette personne avait elle déjà un score sur ce jeu ? 
			$sql = 'SELECT score_game FROM '.AREABB_SCORES_TABLE.' 
					WHERE game_id='.$infos_hack['game_id'].' AND user_id='.$infos_hack['user_id'].' 
					LIMIT 1';
			if(!$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de récupérer les infos sur les scores de ce hack', '', __LINE__, __FILE__, $sql);
			}
			if ( $db->sql_numrows($result) == 0)
			{
				// Elle n'avait jamais joué à ce jeu..
				$sql = 'INSERT INTO ' . AREABB_SCORES_TABLE . ' 
						(game_id , user_id , score_game , score_date , score_time , score_set ) 
						VALUES 
						( '.$infos_hack['game_id'].' , '. $infos_hack['user_id'] .' , '.$infos_hack['score'].' , '.$infos_hack['date_hack'].' , '.$infos_hack['realtime'].' , 1 )';
				$db->sql_query($sql);
			}else{
				/// elle avait déjà joué on met à jour son entrée.
				$sql = 'UPDATE ' . AREABB_SCORES_TABLE . ' SET 
						score_game = '.$infos_hack['score'].' , 
						score_set = score_set + 1 , 
						score_date = '.$infos_hack['date_hack'].' , 
						score_time = score_time + '.$infos_hack['realtime'].'  
						WHERE game_id = '.$infos_hack['game_id'].' 
						AND user_id = ' . $infos_hack['user_id'] ;
				$db->sql_query($sql);
			
			}
			break;
		case 'supprimer':
			// on supprime cette entrée du journal de log
			$sql = 'DELETE FROM '.AREABB_HACKGAME_TABLE.' WHERE id_hack='.$id_hack;
			if(!$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de supprimer cette entrée de la liste de hacks', '', __LINE__, __FILE__, $sql);
			}
			break;
		case 'bannir':
			// On bannit ce joueur
			$sql = 'SELECT user_id FROM '.AREABB_HACKGAME_TABLE.' WHERE  id_hack='.$id_hack;
			if(!$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de rajouter cette personne à la liste de hack', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$sql = 'INSERT INTO '.BANLIST_TABLE.' (ban_userid) VALUES ('.$row['user_id'].')';
			if(!$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Impossible de rajouter cette personne à la liste de hack', '', __LINE__, __FILE__, $sql);
			}
			break;
	}
}


$template->set_filenames(array(
	'body' => 'areabb/mods/games/tpl/arcade_hackgame.tpl'
));

$sql = 'SELECT id_hack, h.user_id,  u.username AS tricheur, u2.username AS modo, h.game_id, game_libelle,game_name, game_pic, date_hack,id_modo,  flashtime, realtime, score, type 
		FROM '.AREABB_HACKGAME_TABLE.' as h 
		LEFT JOIN '.USERS_TABLE.' as u ON (h.user_id = u.user_id)
		LEFT JOIN '.USERS_TABLE.' AS u2 ON ( h.id_modo = u2.user_id ) 
		LEFT JOIN '.AREABB_GAMES_TABLE.' as g ON (h.game_id=g.game_id)
		ORDER BY date_hack DESC';
if(!$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Impossible de lister les tentatives de Hack ', '', __LINE__, __FILE__, $sql);
}
if ($db->sql_numrows($result) == 0)
{
	$template->assign_block_vars('no_tricheurs', array());
}else{
	while( $row = $db->sql_fetchrow($result) )
	{
		// Le jeu en question..
		$type = ($row['modo'] != '')? $row['modo'] : '';
		$template->assign_block_vars('tricheurs', array(
			'ID_HACK' 	=> $row['id_hack'],
			'USERNAME'	=> $row['tricheur'],
			'GAME'		=> $row['game_libelle'],
			'ICONE'		=> $phpbb_root_path.'areabb/games/'.$row['game_name'].'/'.$row['game_pic'],
			'DATE'		=> MySQLDateToExplicitDate(timestamp_to_gmd($row['date_hack']),0,1,0),
			'TPS_SRV'	=> $row['realtime'],
			'TPS_FSH'	=> $row['flashtime'],
			'SCORE'		=> $row['score'],
			'TYPE'		=> $type
		));
		($row['modo'] != '')? $template->assign_block_vars('tricheurs.modo', array()):$template->assign_block_vars('tricheurs.robot', array());
	}
}



$template->assign_vars(array(
	'L_HACKGAME_TITLE'			=> $lang['L_HACKGAME_TITLE'],
	'L_HACKGAME_TITLE_EXPLAIN'	=> $lang['L_HACKGAME_TITLE_EXPLAIN'],
	'L_NO_TRICHEUR'				=> $lang['L_NO_TRICHEUR'],
	'L_JOUEUR'					=> $lang['L_JOUEUR'],
	'L_JEU'						=> $lang['L_JEU'],
	'L_DATE_HACK'				=> $lang['L_DATE_HACK'],
	'L_TPS_SRV'					=> $lang['L_TPS_SRV'],
	'L_TPS_FSH'					=> $lang['L_TPS_FSH'],
	'L_SCORE'					=> $lang['L_SCORE'],
	'L_TYPE'					=> $lang['L_TYPE'],
	'L_ACTIONS_HACK'			=> $lang['L_ACTIONS_HACK'],
	'Information'				=> $lang['Information'],
	'I_ROBOT'					=> $phpbb_root_path.$images['icon_areabb_bots'],
	'I_MODO'					=> $phpbb_root_path.$images['icon_areabb_humains'],
	'L_TYPE_ROBOT'				=> $lang['L_TYPE_ROBOT'],
	'L_TYPE_MODO'				=> $lang['L_TYPE_MODO'],
	'L_RETABLIR_SCORE'			=> $lang['L_RETABLIR_SCORE'],
	'L_SUPPRIMER_HACK'			=> $lang['L_SUPPRIMER_HACK'],
	'L_BANNIR'					=> $lang['L_BANNIR']
	

));


$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>