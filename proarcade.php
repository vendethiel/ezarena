<?php
/***************************************************************************
 *                                proarcade.php
 *
 *	Par Saint-Pere le 10 Juillet 2006
 *
 ***************************************************************************/

//
// Start session management
//

define('IN_PHPBB', true);
$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.'.$phpEx);
include_once($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
load_function('functions_arcade');
load_lang('arcade');

$userdata = session_pagestart($user_ip, PAGE_GAME);
init_userprefs($userdata);

if ( !$userdata['session_logged_in'] )
{
	message_die(GENERAL_ERROR, $lang['arcade_session_expiree'] ) ;
	header($header_location . append_sid('login.'.$phpEx.'?redirect='.NOM_ARCADE.'.'.$phpEx, true));
	exit;
}
//
// End session management

// Si la personne a déjà soumis un score on le renvoit où il était
if (($userdata['areabb_tps_depart'] == '') || ($userdata['areabb_gid'] == '') || ($userdata['areabb_variable'] == ''))
{
	$message = $lang['arcade_partie_terimnee'] . '<br /><br />' ;
	$message .=	sprintf($lang['Click_return_arcade'], '<a href="' . append_sid(NOM_ARCADE.'.'.$phpEx, true).'">', '</a>') ;
	message_die(GENERAL_MESSAGE,$message);
	exit;
}
$datenow= time();
$temps_depart	= $userdata['areabb_tps_depart'];
$gid			= $userdata['areabb_gid'];
$variable		= $userdata['areabb_variable'];

// temps passé à jouer coté serveur
$temps_partie = $datenow - $temps_depart ;


// On nettoye la table de session
$sql = 'UPDATE '.SESSIONS_TABLE.' SET areabb_tps_depart=\'\',areabb_gid=\'\',areabb_variable=\'\' 
		WHERE session_id=\''.$userdata['session_id'].'\'';
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d\'accéder à la tables des sessions", '', __LINE__, __FILE__, $sql); 
}


// On recupere le temps de partie enregistré coté Flash
if (isset($HTTP_POST_VARS['flashgametime'])) $flashgametime =  intval($HTTP_POST_VARS['flashgametime']);
if (isset($HTTP_GET_VARS['flashgametime'])) $flashgametime = intval($HTTP_GET_VARS['flashgametime']);
if (!isset($HTTP_GET_VARS['flashgametime']) && !isset($HTTP_POST_VARS['flashgametime'])) $flashgametime = 0;

// On recupere la variable envoyée coté Flash
if (isset($HTTP_POST_VARS['gname'])) $variable_flash =  $HTTP_POST_VARS['gname'];
if (isset($HTTP_GET_VARS['gname'])) $variable_flash = $HTTP_GET_VARS['gname'];
if (!isset($HTTP_GET_VARS['gname']) && !isset($HTTP_POST_VARS['gname'])) $variable_flash = 'triche';


// ---------------------------------------------------------------------------------------------
//  RECUPERATION DES INFOS SUR LE JEU
//
$sql = 'SELECT game_highscore,game_highuser, game_type, game_cheat_control 
		FROM ' . AREABB_GAMES_TABLE . ' 
		WHERE game_id = '.$gid;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'acceder à la table des jeux", '', __LINE__, __FILE__, $sql); 
}
if ( $db->sql_numrows($result) == 0 )
{
	$message .=	$lang['aucun_jeu_ne_correspond'].'<br /><br />';
	$message .=	sprintf($lang['Click_return_arcade'], '<a href="' . append_sid(NOM_ARCADE.'.'.$phpEx, true).'">', '</a>') ;
	message_die(GENERAL_MESSAGE,$message);
	exit;
}
$row = $db->sql_fetchrow($result);

// meilleur score actuel sur ce jeu
$highscore = $row['game_highscore'];
$highuser = $row['game_highuser'];

// on recupere le score
if ($row['game_type'] == 4) $score = floatval($HTTP_POST_VARS['gscore']);
if ($row['game_type'] == 3) $score = floatval($HTTP_GET_VARS[$variable]);
if (($row['game_type'] != 3) && ($row['game_type'] != 4)) $score = floatval($HTTP_POST_VARS[$variable]);

// on place le temps flash au temps serveur si le jeu n'est pas compatible cheater tracker
$flashgametime = ($row['game_cheat_control'] == 0) ? $temps_partie : $flashgametime;

// ---------------------------------------------------------------------------------------------
//  TENTATIVE DE HACK
//
//Si triche archivage des valeurs temps php, temps flash, jeu, joueur, date, score

$pourcentage = ($areabb['games_time_tolerance']*$temps_partie)/100;
$moins = $temps_partie - $pourcentage;
$plus = $temps_partie + $pourcentage;

//if ((($flashgametime > $plus) || ($flashgametime < $moins) || ($temps_depart == 0)) && ($gcheatlm == 1) )
if ((($flashgametime > $plus) || ($flashgametime < $moins) || ($temps_depart == 0)  || ($variable_flash != $variable )) 
	&& ($row['game_cheat_control'] == 1) )
{
	$sql = 'INSERT INTO ' . AREABB_HACKGAME_TABLE . ' 
			(date_hack, user_id , game_id , flashtime, realtime,score) 
			VALUES 
			('.$datenow.',' . $userdata['user_id'] . ','.$gid.','.$flashgametime.','.$temps_partie.',\''.$score.'\')'; 
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible de mettre à jour la table de Hack", '', __LINE__, __FILE__, $sql); 
	}
	/*
	define('LOGS_TRICHE','areabb/cache/logs_triche.txt');
	$rFile = @fopen(LOGS_TRICHE,"a+");
	if (!$rFile) {
		return "ERREUR: Impossible d'ecrire dans le dossier 1 " . dirname(realpath(LOGS_TRICHE)) ." (avez vous fait un CHMOD 777 ? )" ;
	}
	$log  = 'Joueur : '.$userdata['username']." \n";
	$log  .= 'Temps réalisé : '. $plus. ' > '. $flashgametime. ' > '. $moins ." \n";
	$log  .= 'Temps départ  : '. $temps_depart." \n";
	$log  .= 'Var jeu flash : '.$variable_flash." \n";
	$log  .= 'Var coté PHP : '. $variable." \n";
	$log  .= '____________________________________________________________'." \n";	
	fwrite($rFile,$log);
	fclose($rFile);
	*/
	$message .=	$lang['triche_interdite'].'<br /><br />';
	$message .=	sprintf($lang['Click_return_arcade'], '<a href="' . append_sid(NOM_ARCADE.'.'.$phpEx, true).'">', '</a>') ;
	message_die(GENERAL_MESSAGE,$message);
	exit; 
} 


// ---------------------------------------------------------------------------------------------
//  ENREGISTREMENT DU NOUVEAU SCORE
//

// lecture des scores pour ce jeu et ce joueur
$sql = 'SELECT * 
		FROM ' . AREABB_SCORES_TABLE . ' 
		WHERE game_id = '.$gid.' 
		AND user_id = ' . $userdata['user_id'] ;

if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'acceder à la tables des scores", '', __LINE__, __FILE__, $sql); 
}
// On va récuperer le type de cas de figure dans lequel on se trouve.
unset($cas_score);

if ( !( $row = $db->sql_fetchrow($result) ) )
{
	// Aucun record enregistré
	$cas_score = 0;
	$sql = 'INSERT INTO ' . AREABB_SCORES_TABLE . ' 
			(game_id , user_id , score_game , score_date , score_time , score_set ) 
			VALUES 
			( '.$gid.' , '. $userdata['user_id'] .' , \''.$score.'\' , '.$datenow.' , '.$temps_partie.' , 1 )';
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'enregistrer ce score.", '', __LINE__, __FILE__, $sql); 
	}

}
elseif ( $row['score_game'] < $score )
{
	// Record battu
	$cas_score = 1;
	$sql = 'UPDATE ' . AREABB_SCORES_TABLE . ' SET 
			score_game = \''.$score.'\' , 
			score_set = score_set + 1 , 
			score_date = '.$datenow.' , 
			score_time = score_time + '.$temps_partie.'  
			WHERE game_id = '.$gid.' 
			AND user_id = ' . $userdata['user_id'] ;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'enregistrer que vous avez battu votre record.", '', __LINE__, __FILE__, $sql); 
	}
}	
else
{
	// Record non battu
	$cas_score = 2;
	$sql = 'UPDATE ' . AREABB_SCORES_TABLE . ' SET
			score_set = score_set + 1  ,
			score_time = score_time + '.$temps_partie.' 
			WHERE game_id = '.$gid.' 
			AND user_id = ' . $userdata['user_id'] ;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible de mettre à jour le temps joué à cette partie.", '', __LINE__, __FILE__, $sql); 
	}
}




if (( $highscore < $score) && ($highuser != $userdata['user_id'])){
	// l'utilisateur a battu le record du jeu / il n'était pas le recordman
	$cas_score = 3;
	$sql = 'UPDATE '. AREABB_GAMES_TABLE .' SET
			game_highscore = \''.$score.'\' ,
			game_highuser = '. $userdata['user_id'] . ',
			game_highdate = '. $datenow . ' 
			WHERE game_id = '.$gid;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible de mettre à jour ce HightScore", '', __LINE__, __FILE__, $sql); 
	}
}elseif(( $highscore < $score) && ($highuser == $userdata['user_id'])){
	// l'utilisateur a battu le record du jeu / il était déjà le recordman
	$cas_score = 4;
	$sql = 'UPDATE '. AREABB_GAMES_TABLE .' SET
			game_highscore = \''.$score.'\' ,
			game_highdate = '. $datenow . ' 
			WHERE game_id = '.$gid;
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible de mettre à jour ce HightScore", '', __LINE__, __FILE__, $sql); 
	}
}

/*******************************************************************
	On Charge les MODS intervenant sur les scores
*******************************************************************/

$max_mods = sizeof($liste_mods);
for ($l=0;$l<$max_mods;$l++)
{
	if (file_exists(CHEMIN_MODS.$liste_mods[$l].'/proarcade.'.$phpEx))
	{
		include_once(CHEMIN_MODS.$liste_mods[$l].'/proarcade.'.$phpEx);
	}
}
/*******************************************************************/

$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";
header($header_location . append_sid(NOM_GAME.'.'.$phpEx.'?gid='.$gid, true));
exit;
?>