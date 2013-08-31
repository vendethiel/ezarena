<?php
/* 
**************************************************************************
 *                             admin_areabb_mods.php
 *                            -------------------
 *   Commencé le jeudi 8 juin 2006
 *   Par Saint-Pere www.yep-yop.com
 *
 *
 **************************************************************************
 */

define('IN_PHPBB', 1);
if( !empty($setmodules) )
{
	// recherche des fichiers d'administration des différents mods
	
	$phpbb_root_path = './../';
	require_once($phpbb_root_path . 'extension.inc');
	include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
	
	$sql = 'SELECT nom 
		FROM '.AREABB_MODS.' 
		ORDER BY nom ASC';
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d\'accéder à la tables des mods", '', __LINE__, __FILE__, $sql);
	}
	while ($row = $db->sql_fetchrow($result))
	{
		if (is_dir(CHEMIN_MODS.$row['nom'].'/')) 
		{
			$dossier = dir(CHEMIN_MODS.$row['nom'].'/');
			while( ($fichier = $dossier->read()) !== false)
			{
				if( preg_match("/^admin_.*?\." . $phpEx . "$/", $fichier) )
				{
					include(CHEMIN_MODS. $row['nom'] .'/'. $fichier);
				}
			}
		}
	}
	$file = basename(__FILE__);
	$module['AreaBB']['Extensions'] = $file;
	return;

	
	$phpbb_root_path = './';
}

// --------------------------------------------------------------------------------------------
//  APPEL de fichiers
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
load_lang('admin');
load_function('class_plugins');
$plugins = new plugins(CHEMIN_MODS);


// --------------------------------------------------------------------------------------------
// TRAITEMENT DES PARAMETRES
//
if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action = $HTTP_POST_VARS['action']; 
	}else{
		$action = $HTTP_GET_VARS['action'];
	}
}
$url		= $HTTP_POST_VARS['url'];
$titre		= $HTTP_GET_VARS['titre'];
$version	= $HTTP_GET_VARS['version'];
$page		= $HTTP_GET_VARS['page'];
$id_mod		= eregi_replace('[^0-9]','',$HTTP_GET_VARS['id_mod']);

switch($action)
{
	case 'ajout':
		// On ajoute un mod distant sur le site
		if (!$plugins->ajoute($url))
		{
			$message = $lang['mod_non_ajoute'] . '<br /><br />' ;
			$message .=	sprintf($lang['Click_return_areabb_mods'], '<a href="' . append_sid('admin_areabb_mods.'.$phpEx).'">', '</a>') ;
			message_die(GENERAL_MESSAGE,$message);
			exit;
		}
	break;
	case 'install':
		// on installe le mod séléctionné sur le site
		if (!$plugins->installe($titre,$page))
		{
			$message = $lang['mod_non_installe'] . '<br /><br />';
			$message .=	sprintf($lang['Click_return_areabb_mods'], '<a href="' . append_sid('admin_areabb_mods.'.$phpEx).'">','</a>') ;
			message_die(GENERAL_MESSAGE,$message);
			exit;
		}
	break;
	case 'supprime':
		// on veut supprimer son mod
		if (!$plugins->supprime($titre,$id_mod))
		{
			$message = $lang['mod_non_supprime'] . '<br /><br />' ;
			$message .=	sprintf($lang['Click_return_areabb_mods'], '<a href="' . append_sid('admin_areabb_mods.'.$phpEx).'">', '</a>') ;
			message_die(GENERAL_MESSAGE,$message);
			exit;
		}
		// On vire le dossier du site
		load_function('lib.files');
		$mod = NEW files();
		$mod->deltree(CHEMIN_MODS.$titre);
	break;
}

// --------------------------------------------------------------------------------------------
//     RECUPERATION des mods déjà installés et NON installés
//

$sql = 'SELECT id_mod, nom  
		FROM '. AREABB_MODS.'
		ORDER BY nom ASC';
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'afficher la liste des blocs", '', __LINE__, __FILE__, $sql); 
}
$listes_mods = array();
$liste_id = array();
while ($row = $db->sql_fetchrow($result))
{
	$listes_mods[] = $row['nom'];
	$liste_id[$row['nom']] = $row['id_mod'];
}

$plugins->getPlugins(true);
$plugins_list = $plugins->getPluginsList();


// --------------------------------------------------------------------------------------------
//     AFFiCHAGE
//

$template->set_filenames(array(
	'body' => 'admin/areabb_mods.tpl'
));

foreach ($plugins_list as $k => $v)
{

	$titre = (!empty($v['label'])) ? $v['label'] : $v['nom'];
	
	if (file_exists(CHEMIN_MODS.$k.'/logo.png')) {
		$image = CHEMIN_MODS.$k.'/logo.png';
	}
	
	$template->assign_block_vars('mods', array(
		'ID' 			=> $k,
		'TITRE'		 	=> $titre,
		'IMAGE'			=> $image,
		'DESC'			=> $v['description'],
		'AUTEUR'		=> $v['auteur'],
		'VERSION'		=> $v['version'],
		'SUPPRIMER'		=> append_sid('admin_areabb_mods.php?action=supprime&titre='.$k.'&id_mod='.$liste_id[$k]),
		'INSTALLER'		=> append_sid('admin_areabb_mods.php?action=install&titre='.$k.'&page='.$v['page']),
		'PACKAGER'		=> append_sid('admin_areabb_mods.php?action=package&titre='.$k.'&version='.$v['version']),
		'TELECHARGER'	=> $phpbb_root_path.'areabb/dl.php?extension='.$liste_id[$k]
	));
	
		// mod déjà installé ? 
	if (in_array($k,$listes_mods))
	{
		// Lien pour le supprimer
		$template->assign_block_vars("mods.supprimer", array());
	}else{
		// lien pour l'installer
		$template->assign_block_vars("mods.installer", array());
	}
}

//
// Recherche des versions

$version_actuelle =  (!isset($board_config['AreaBB_version']) || ($board_config['AreaBB_version']== ''))? '0.9':$board_config['AreaBB_version'];

$errno = 0;
$errstr = $version_info = '';

if ($fsock = @fsockopen('www.areabb.com', 80, $errno, $errstr, 10))
{
	@fputs($fsock, "GET /version.txt HTTP/1.1\r\n");
	@fputs($fsock, "HOST: www.areabb.com \r\n");
	@fputs($fsock, "Connection: close\r\n\r\n");

	$get_info = false;
	while (!@feof($fsock))
	{
		if ($get_info)
		{
			$version_info .= @fread($fsock, 1024);
		}
		else
		{
			if (@fgets($fsock, 1024) == "\r\n")
			{
				$get_info = true;
			}
		}
	}
	@fclose($fsock);
}
$version_serveur =  (!isset($version_info) || ($version_info== ''))? $lang['info_indisponible']:$version_info;		
	
$template->assign_vars(array(	
	'L_MODS'				=> $lang['L_MODS'],
	'L_EXPLAIN_MODS'		=> $lang['L_EXPLAIN_MODS'],
	'L_AJOUT_MOD'			=> $lang['L_AJOUT_MOD'],
	'L_AJOUT_EXPLAIN_MOD'	=> $lang['L_AJOUT_EXPLAIN_MOD'],
	'AJOUTER'				=> $lang['AJOUTER'],
	'L_AUTEUR'				=> $lang['L_AUTEUR'],
	'L_VERSION'				=> $lang['L_VERSION'],
	'L_VERSION_AREABB'		=> $lang['L_VERSION_AREABB'],
	'L_VERSION_ACTUELLE'	=> $lang['L_VERSION_ACTUELLE'],
	'L_VERSION_SERVEUR'		=> $lang['L_VERSION_SERVEUR'],
	'VERSION_ACTUELLE'		=> $version_actuelle,
	'VERSION_SERVEUR'		=> $version_serveur,
	'I_SUPPRIMER'			=> $phpbb_root_path .$images['icon_areabb_supprimer'],
	'I_INSTALLER'			=> $phpbb_root_path .$images['icon_areabb_installer']
));	

// Génération de la page

$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>