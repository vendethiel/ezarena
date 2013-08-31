<?php
/* 
**************************************************************************
 *                             admin_arcade_jeux.php
 *                            -------------------
 *   Commencé le jeudi 15 juin 2006
 *   Par Saint-Pere www.yep-yop.com
 *
 *
 **************************************************************************
 */

define('IN_PHPBB', 1);
if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['AreaBB Arcade']['Installer un jeu'] = '../areabb/mods/games/'.$file;
	return;
}
// --------------------------------------------------------------------------------------------
//  APPEL de fichiers
//
define('ROOT_STYLE','admin');
$phpbb_root_path = '../../../';
require($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
load_lang('admin');
load_lang('admin_arcade');
load_function('class_games');
load_function('fonctions_chaine');
$games_root = $phpbb_root_path . 'areabb/games/';
$jeux = new games($games_root);

// --------------------------------------------------------------------------------------------
// TRAITEMENT DES PARAMETRES
//
if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action = $HTTP_POST_VARS['action']; 
		$check = $HTTP_POST_VARS['check']; 
	}else{
		$action = $HTTP_GET_VARS['action'];
	}
}
$url		= $HTTP_POST_VARS['url'];
$nom		= $HTTP_GET_VARS['nom'];
$version	= $HTTP_GET_VARS['version'];


switch($action)
{
	case 'ajout':
			// On ajoute un jeu distant sur le site
			if (!$jeux->ajoute($url))
			{
				$message = $lang['jeu_non_ajoute'] . '<br /><br />' ;
				$message .=	sprintf($lang['Click_return_arcade_jeux'], '<a href="' . append_sid('admin_arcade_jeux.'.$phpEx).'">', '</a>') ;
				message_die(GENERAL_MESSAGE,$message);
				exit;
			}
			break;
	case 'instal':
			// on installe le jeu séléctionné sur le site
			if (!$jeux->installe($nom))
			{
				$message = $lang['jeu_non_installe'] . '<br /><br />' ;
				$message .=	sprintf($lang['Click_return_arcade_jeux'], '<a href="' . append_sid('admin_arcade_jeux.'.$phpEx).'">', '</a>') ;
				message_die(GENERAL_MESSAGE,$message);
				exit;
			}else{
				$message = $lang['jeu_installe'] . '<br /><br />' ;
				$message .=	sprintf($lang['Click_return_arcade_jeux'], '<a href="' . append_sid('arcade_elmt.'.$phpEx.'?arcade_catid=0').'">', '</a>') ;
				message_die(GENERAL_MESSAGE,$message);
				exit;
			}
			break;
			
	case 'massinstall':
			// On installe tous les jeux cochés
			if (isset($check))
			{
				foreach ($check as $choix)
				{
					if (!$jeux->installe($choix))
					{
						$message = $lang['jeu_non_installe'] . '<br /><br />' ;
						$message .=	sprintf($lang['Click_return_arcade_jeux'],'<a href="' . append_sid('admin_arcade_jeux.'.$phpEx).'">', '</a>') ;
						message_die(GENERAL_MESSAGE,$message);
						exit;
					}
				}
				$message = $lang['jeu_installe'] . '<br /><br />' ;
				$message .=	sprintf($lang['Click_return_arcade_jeux'], '<a href="' . append_sid('arcade_elmt.'.$phpEx.'?arcade_catid=0').'">', '</a>') ;
				message_die(GENERAL_MESSAGE,$message);
				exit;
			}
			break;
}

// --------------------------------------------------------------------------------------------
//     RECUPERATION des jeux 
//

$sql = 'SELECT game_name 
		FROM '. AREABB_GAMES_TABLE.'
		ORDER BY game_name ASC';
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'afficher la liste des jeux", '', __LINE__, __FILE__, $sql); 
}
$listes_jeux = array();
while ($row = $db->sql_fetchrow($result))
{
	$listes_jeux[$row['game_name']] = 'ok';
}

$jeux->getGames(true);
$liste_jeux = $jeux->getGamesList();


// --------------------------------------------------------------------------------------------
//     AFFiCHAGE
//

$template->set_filenames(array(
	'body' => 'areabb/mods/games/tpl/arcade_jeux.tpl'
));
// Si il y a + de jeux dans le dossier que de jeux installés on lance le listing de nouveaux jeux.
$jeux_installes = count($listes_jeux);
$jeux_en_stock = count($liste_jeux);
if ($jeux_installes < $jeux_en_stock) $template->assign_block_vars('listing', array());
$i = 0;
foreach ($liste_jeux as $k => $v)
{
	// jeu déjà installé ? 
	if (!array_key_exists($k,$listes_jeux))
	{
		// lien pour l'installer
		$installer = append_sid('admin_arcade_jeux.'.$phpEx.'?action=instal&nom='.$k);

		$titre = (!empty($v['label'])) ? $v['label'] : $v['nom'];
		if (file_exists($games_root.$k.'/'.$v['icone'])) $image = $games_root.$k.'/'.$v['icone'];
		

		$template->assign_block_vars('listing.jeux', array(
			'TITRE'		 	=> $titre,
			'IMAGE'			=> $image,
			'DESC'			=> $v['description'],
			'ADAPTEUR'		=> url_cliquable($v['adapteur']),
			'INSTALLER' 	=> $installer,
			'CHECK'			=> $k
		));
		
		// Nombre de jeux affiché
		$i++;
	}
}	

if ($i == 0) $template->assign_block_vars('no_jeux', array());
$template->assign_vars(array(	
	'L_JEUX'				=> $lang['L_JEUX'],
	'L_ADAPTEUR'			=> $lang['L_ADAPTEUR'],
	'L_EXPLAIN_JEUX'		=> $lang['L_EXPLAIN_JEUX'],
	'L_AJOUT_JEUX'			=> $lang['L_AJOUT_JEUX'],
	'L_AJOUT_EXPLAIN_JEUX'	=> $lang['L_AJOUT_EXPLAIN_JEUX'],
	'AJOUTER'				=> $lang['AJOUTER'],
	'L_NO_JEU'				=> $lang['L_NO_JEU'],
	'NOTHING_CHECKED'		=> $lang['Nothing_checked'],
	'ALL_CHECKED'			=> $lang['All_checked'],
	'I_INSTALLER'			=> $phpbb_root_path .$images['icon_areabb_installer'],
	'L_INSTALLES'			=> $lang['jeux_installes'],
	'L_STOCKS'				=> $lang['jeux_en_stock'],
	'J_INSTALLES'			=> $jeux_installes,
	'J_STOCK'				=> $jeux_en_stock
));	

// Génération de la page

$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>