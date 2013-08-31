<?php
// -------------------------------------------------------------------------
//
//				preload.php
//
//	Chargement des tests de base d'AreaBB, des fonctions 
//      indispensables au mod pour fonctionner.
// -------------------------------------------------------------------------
if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

//
// Chargement des constantes
include('constants.' . $phpEx);

//
// Cette fonction retourne le tableau des paramètres de config générale

function read_config()
{
	global $db,$areabb;
	$areabb = array();
	$sql = 'SELECT * FROM ' . AREABB;
	if( !($result = $db->sql_query($sql, false, true)) )
	{
		message_die(CRITICAL_ERROR, 'Could not query arcade config information', '', __LINE__, __FILE__, $sql);
	}

	while ( $row = $db->sql_fetchrow($result) )
	{
		$areabb[$row['nom']] = $row['valeur'];
	}

	return true;
}

if (!read_config())
{
	message_die(GENERAL_ERROR, 'Impossible de récupérer la configuration d\'AreaBB', '');
}

//
// Charge le fichier de lang demandé

function load_lang($fichier='main')
{
	global $userdata,$board_config,$phpbb_root_path,$phpEx,$lang;
	
	// Quelle est la langue du visiteur ?
	if ( $userdata['user_id'] != ANONYMOUS )
	{
		if ( !empty($userdata['user_lang']))	$board_config['default_lang'] = $userdata['user_lang'];
		
	}else{
		$board_config['default_lang'] = 'french';
	}
	// Si le fichier de langue demandé n'existe pas dans sa langue on charge la langue francaise qui sera celle par défaut d'AreaBB
	if (file_exists($phpbb_root_path . 'areabb/language/lang_' . $board_config['default_lang'] . '/lang_'.$fichier.'.' . $phpEx))
	{
		include_once($phpbb_root_path . 'areabb/language/lang_' . $board_config['default_lang'] . '/lang_'.$fichier.'.' . $phpEx);
	}else{
		include_once($phpbb_root_path . 'areabb/language/lang_french/lang_'.$fichier.'.' . $phpEx);
	}
}

//
// Charge le fichier de fonction global demandé

function load_function($fichier='')
{
	global $phpbb_root_path,$phpEx;
	if (empty($fichier) || !file_exists($phpbb_root_path . 'areabb/fonctions/'.$fichier.'.'.$phpEx)) return;
	include_once( $phpbb_root_path . 'areabb/fonctions/'.$fichier.'.'.$phpEx);
	return true;
}

//
// Vérification de l'autorisation d'accès à une salle

function verification_acces_page($id_squelette)
{
	global $db,$userdata,$page_title;
	$sql = 'SELECT titre, groupes 
			FROM '.AREABB_SQUELETTE.' 
			WHERE id_squelette='.$id_squelette;
	if( !$result = $db->sql_query($sql, false, true) )
	{
		message_die(GENERAL_ERROR, "Impossible d'obtenir les infos de la table des salles", "", __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$page_title = $row['titre'];
	if ($row['groupes'] != '')
	{
		$sql = 'SELECT user_id 
			FROM '.USER_GROUP_TABLE.' 
			WHERE user_id='.$userdata['user_id'].' 
			AND group_id IN 
			(
				'.$row['groupes'].'	
			)';
			
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'obtenir les infos de la table des salles", "", __LINE__, __FILE__, $sql);
		}
		if (!$row = $db->sql_fetchrow($result))
		{
			return false;
		}	
	}
	return true;
}

//
// Listing des mods installé sur AreaBB

$sql = 'SELECT nom 
	FROM '.AREABB_MODS.' 
	ORDER BY nom ASC';
if( !($result = $db->sql_query($sql, false, true)) )
{
	message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des mods", '', __LINE__, __FILE__, $sql);
}
$liste_mods = array();
while ($row = $db->sql_fetchrow($result))
{
	$liste_mods[] = $row['nom'];
}



// rcs activé ?
if ($areabb['mod_rcs'] == 1) load_function('fonctions_rcs');
// Gender activé ?
if($areabb['mod_gender'] == 1) load_function('fonctions_gender');
// On a choisit d'Utiliser les popup pour le profile ?
if($areabb['mod_profile'] == 1) load_function('fonctions_profile');

//
// Chargement du formatage des pseudos
if(($areabb['mod_gender'] == 1) || ($areabb['mod_rcs'] == 1))
{

	unset($sql);
	$sql = 'SELECT u.user_id  
			FROM '. USERS_TABLE.' as u
			WHERE user_active=1		
			ORDER BY user_id ASC';
	$sql = ($areabb['mod_gender'] == 1)? parse_gender($sql):$sql;
	$sql = ($areabb['mod_rcs'] == 1)? parse_rcs($sql):$sql;

	if( !($result = $db->sql_query($sql)) )
	{
			message_die(GENERAL_ERROR, "Impossible d\'accéder à la tables des users", '', __LINE__, __FILE__, $sql);
	}
	$info_user = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$info_user[$row['user_id']] = $row;
	}
}


//
// Affiche un popup DHTML avec le profil du membre
//
function areabb_profile($user_id,$username)
{
	global $theme,$onglets,$liste_profiles,$areabb,$phpEx,$info_user;
	// si t'as le mod gender on rajouter l'icone mâle/femelle à coté du pseudo
	if($areabb['mod_gender'] == 1) $username = formate_gender($username,$user_id);
	
	// si t'as le mod ERC on colorise le nom du membre
	if ($areabb['mod_rcs'] == 1) $username = formate_rcs($username,$user_id);
	// si on a choisit d'utiliser les popups pour le profile
	if($areabb['mod_profile'] == 1)
	{
		return '<a href="javascript:;" onClick="initFloatingWindowWithTabs(Array(\''.implode('\',\'',$liste_profiles).'\'),'.$user_id.',\'profile\',Array(\''.implode('\',\'',$onglets).'\'),false,650,400,200,200);">'.$username.'</a>';

	}else{
		return '<a href="'.append_sid('profile.'.$phpEx.'?mode=viewprofile&u='.$user_id).'">'.$username.'</a>';
	}
}

?>