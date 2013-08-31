<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                              fonctions arcade
//
//   Commencé le   :  mercredi 24 Mai 2006
//   Par  Saint-Pere
//
//--------------------------------------------------------------------------------------------------------------------------------------


if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

// 
// On fait différents tests pour savoir si l'utilisateur a le droit d'accéder à l'arcade
//
function test_acces_arcade($user_id)
{
	global $db,$areabb;
	
	//  On verifie si il n'appartiendrait pas au groupe accès spécial Arcade-VIP
	// 
	if ($areabb['group_vip']== 1)
	{
		$sql = 'SELECT u.group_id 
			FROM '. USER_GROUP_TABLE .' as u
			LEFT JOIN '. GROUPS_TABLE .' as g ON u.group_id=g.group_id 
			WHERE user_id='.$user_id.' 
			AND group_name = \''.$areabb['nom_group_vip'].'\'
			LIMIT 1';
		
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Impossible d\'acceder à la table des groupes', '', __LINE__, __FILE__, $sql);
		}
		// 1 enregistrement signifie qu'il est VIP
		if ($db->sql_numrows($result) > 0) return true;		
	}
	
	// il faut avoir posté au moins 1 fois avant de jouer
	if ($areabb['avoir_poste_joue']== 1)
	{
		$sql = 'SELECT COUNT(topic_id) as number_topics
		FROM ' . TOPICS_TABLE . ' 
		WHERE topic_poster=' . $user_id;
		
		if (!$result=$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Impossible de savoir si vous avez déjà posté');
		}
		$row = $db->sql_fetchrow($result);
		
		// si il n'y a aucune réponse c'est que la personne n'a jamais posté.
		if ($row['number_topics'] < $areabb['nbre_topics_min'] ) return false;	
	}
	
	// il faut avoir posté au moins 1 fois avant de jouer  dans le forum XX 
	if ($areabb['presente'] == 1)
	{
		$sql = 'SELECT topic_id
			FROM ' . TOPICS_TABLE . ' 
			WHERE topic_poster=' . $user_id . ' 
			AND forum_id='.$areabb['forum_presente'];
		
		if (!$result=$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Impossible de savoir si vous vous êtes déjà présenté avant de jouer');
		}
		
		// si il n'y a aucune réponse c'est que la personne n'a jamais posté.
		if ($db->sql_numrows($result) == 0) return false;
	}
	return true;
}

?>