<?php
/***************************************************************************
 *                             arcade_squelette_feuilles.php
 *                            -------------------
 *   Commencé le Dimanche 4 juin 2006
 *   Par Saint-Pere www.yep-yop.com
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

//
// Let's set the root dir for phpBB
//
define('ROOT_STYLE','admin');
$phpbb_root_path = '../../../';
require($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
load_lang('admin');


load_function('class_squelette');
$squelette = new generation_squelette();


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
$titre						= addslashes(trim($HTTP_POST_VARS['titre']));
$squelette->id_squelette	= eregi_replace('[^0-9]','',$HTTP_GET_VARS['id_squelette']);
$id_feuille					= eregi_replace('[^0-9]','',$HTTP_GET_VARS['id_feuille']);
$id_modele					= eregi_replace('[^0-9]','',$HTTP_POST_VARS['id_modele']);




switch($action)
{
	case 'ajout':
		if (!$squelette->ajouter_feuille($id_modele))
		{		
			$message = $lang['feuille_non_ajoute'] . "<br /><br />" ;
			$message .=	sprintf($lang['Click_return_arcade_squelette_feuille'], '<a href="' . append_sid("areabb_squelette_feuilles.$phpEx?id_squelette=".$squelette->id_squelette) . '">', '</a>') ;
			message_die(GENERAL_MESSAGE,$message);
			exit;		
		}
		break;
	case 'monter':

		if (!$squelette->monter_feuille($id_feuille,'+'))
		{
			$message = $lang['squelette_non_deplace'] . "<br /><br />" ;
			$message .=	sprintf($lang['Click_return_arcade_squelette_feuille'], '<a href="' . append_sid("areabb_squelette_feuilles.$phpEx?id_squelette=".$squelette->id_squelette) . '">', '</a>') ;
			message_die(GENERAL_MESSAGE,$message);
			exit;
		}
		break;		
	case 'descendre':

		if (!$squelette->monter_feuille($id_feuille,'-'))
		{
			$message = $lang['squelette_non_deplace'] . "<br /><br />" ;
			$message .=	sprintf($lang['Click_return_arcade_squelette_feuille'], '<a href="' . append_sid("areabb_squelette_feuilles.$phpEx?id_squelette=".$squelette->id_squelette) . '">', '</a>') ;
			message_die(GENERAL_MESSAGE, $message);
			exit;
		}
		break;			
	case 'suppression':
	
		if (!$squelette->supprimer_feuille($id_feuille))
		{	
			$message = $lang['feuille_non_supprimee'] . "<br /><br />" ;
			$message .=	sprintf($lang['Click_return_arcade_squelette_feuille'], '<a href="' . append_sid("areabb_squelette_feuilles.$phpEx?id_squelette=".$squelette->id_squelette) . '">', '</a>') ;
			message_die(GENERAL_MESSAGE, $message);		
			exit;		
		}
		break;
}



// --------------------------------------------------------------------------------------------
//    AFFICHAGE
//

$template->set_filenames(array(
	'body' => 'areabb/mods/config/tpl/areabb_squelette_feuille.tpl'
));


// On affiche la liste des feuilles
$sql = 'SELECT id_feuille, details, position 
	FROM '. AREABB_FEUILLE .' as f 
	LEFT JOIN '.AREABB_MODELE.' as m ON f.id_modele=m.id_modele
	WHERE id_squelette='.$squelette->id_squelette.'
	ORDER BY position ASC';
	
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'afficher la liste des feuilles", '', __LINE__, __FILE__, $sql); 
}
while ($row = $db->sql_fetchrow($result))
{
	$template->assign_block_vars('liste_feuilles', array(
		'TITRE'				=> $row['details'],
		'MONTER'			=> append_sid('areabb_squelette_feuilles.php?action=monter&id_squelette='.$squelette->id_squelette.'&id_feuille='.$row['id_feuille']),	 
		'DESCENDRE'			=> append_sid('areabb_squelette_feuilles.php?action=descendre&id_squelette='.$squelette->id_squelette.'&id_feuille='.$row['id_feuille']),	 
		'SUPPRIMER'			=> append_sid('areabb_squelette_feuilles.php?action=suppression&id_squelette='.$squelette->id_squelette.'&id_feuille='.$row['id_feuille']),	 
		'ID_SQUELETTE'		=> $squelette->id_squelette			
	));

}

if ($message != '') $message = '<div style="border-style:dotted;border-width:thin;width:50%;text-align:center;"><p>'.$message.'</p></div>';

//
// menu déroulant des différents modèles existants
//
$sql = 'SELECT id_modele, details 
	FROM '. AREABB_MODELE.' 
	ORDER BY details ASC';	
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'afficher la liste des modeles", '', __LINE__, __FILE__, $sql); 
}
$select = '<select name="id_modele">';
while ($row = $db->sql_fetchrow($result))
{
	$select .= "\t<option value=\"".$row['id_modele']."\">".$row['details']."</option>\n";
}
$select .= "</select>\n";
// fin du menu

// Raccourci vers les blocs
$blocs = '<a href="'.append_sid('areabb_squelette_blocs.'.$phpEx.'?id_squelette='.$squelette->id_squelette).'"><img src="'.$phpbb_root_path.$images['icon_areabb_blocs'].'" border=""></a>';

$template->assign_vars(array(
	'MESSAGE'					=> $message,
	'SELECT'					=> $select,
	'ID_SQUELETTE'				=> $squelette->id_squelette,
	'MODIFIER'					=> $lang['MODIFIER'],
	'AJOUTER'					=> $lang['AJOUTER'],
	'L_FEUILLE'					=> $lang['L_FEUILLE'],
	'L_EXPLAIN_FEUILLE'			=> sprintf($lang['L_EXPLAIN_FEUILLE'],$blocs), 
	'L_AJOUT_FEUILLE'			=> $lang['L_AJOUT_FEUILLE'], 
	'L_AJOUT_EXPLAIN_FEUILLE'	=> $lang['L_AJOUT_EXPLAIN_FEUILLE'],
	'I_UP'						=> $phpbb_root_path.$images['icon_areabb_up'],
	'I_DOWN'					=> $phpbb_root_path.$images['icon_areabb_down'],
	'I_SUPP'					=> $phpbb_root_path.$images['icon_delpost']
));



// Génération de la page

$template->pparse('body');

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
?>