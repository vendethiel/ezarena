<?php
/***************************************************************************
 *                              admin_arcade_modele.php
 *                            -------------------
 *   Commencé le Dimanche 4 juin 2006
 *   Par Saint-Pere www.yep-yop.com
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['AreaBB']['Gestion des modeles'] = '../areabb/mods/config/'.$file;
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
load_function('class_squelette');
$squelette = new generation_squelette();

// --------------------------------------------------------------------------------------------
//    TRAITEMENTS 
//
if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{	
	// nettoyage des données. ... Karchër
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action = $HTTP_POST_VARS['action']; 
	}else{
		$action = $HTTP_GET_VARS['action'];
	}
	$modele		= $HTTP_POST_VARS['modele'];
	$details	= $HTTP_POST_VARS['details'];
	$id_modele	= eregi_replace('[^0-9]','',$HTTP_POST_VARS['id_modele']);
			
	switch ($action)
	{
		case 'ajouter_modele':
			
			// On ajoute un modele de la base
			if (!$squelette->ajouter_modele_base($modele,$details)) 
			{
				$message = $lang['L_MODELE_NON_AJOUTE'];
			}else{
				$message = $lang['L_MODELE_AJOUTE'];
			}
			break;
		
		case 'supprimer_modele':
			
			// On supprime un modele de la base
			$id_modele	= eregi_replace('[^0-9]','',$HTTP_GET_VARS['id_modele']);
			if (!$squelette->supprimer_modele_base($id_modele)) 
			{
				$message = $lang['L_MODELE_NON_SUPPRIME'];
			}else{
				$message = $lang['L_MODELE_SUPPRIME'];
			}
			break;
		
		case 'modifier_modele':
			
			// on modifie un modele
			if (!$squelette->modifier_modele_base($id_modele,$modele,$details)) 
			{
				$message = $lang['L_MODELE_NON_MODIFIE'];
			}else{
				$message = $lang['L_MODELE_MODIFIE'];
			}
			break;
		default : exit;
	}
}

// --------------------------------------------------------------------------------------------
//    AFFICHAGE
//

$template->set_filenames(array(
	'body' => 'areabb/mods/config/tpl/areabb_schema.tpl'
));


// On affiche la liste des schemas
$sql = 'SELECT id_modele,modele, details 
		FROM '. AREABB_MODELE .' 
		ORDER BY details ASC';
		
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'afficher la liste des modeles", '', __LINE__, __FILE__, $sql); 
}
while ($row = $db->sql_fetchrow($result))
{
	 $template->assign_block_vars('liste_modeles', array(
		'TITRE'			=> $row['details'],
		'SUPPRIMER'		=> append_sid('admin_areabb_modele.php?action=supprimer_modele&id_modele='.$row['id_modele']),	 
		'ID_MODELE'		=> $row['id_modele'],
		'MODELE'		=> stripslashes($row['modele']),
		'DETAILS'		=> stripslashes($row['details'])
		
	 ));

}

if ($message != '') $message = '<div style="border-style:dotted;border-width:thin;width:50%;text-align:center;"><p>'.$message.'</p></div>';

$template->assign_vars(array(
		'MESSAGE'				=> $message,
		'MODIFIER'				=> $lang['MODIFIER'],
		'AJOUTER'				=> $lang['AJOUTER'],
		'L_MODELE'				=> $lang['L_MODELE'],
		'L_EXPLAIN'				=> $lang['L_EXPLAIN'], 
		'L_AJOUT_MODELE'		=> $lang['L_AJOUT_MODELE'],
		'L_AJOUT_MODELE_EXPLAIN'=> $lang['L_AJOUT_MODELE_EXPLAIN'],
		'L_DETAILS_EXPLAIN'		=> $lang['L_DETAILS_EXPLAIN'],
		'L_EDITION_MODELE'		=> $lang['L_EDITION_MODELE'],
		'L_LISTE'				=> $lang['L_LISTE'],
		'I_EDIT'				=> $phpbb_root_path .$images['icon_edit'],
		'I_SUPP'				=> $phpbb_root_path .$images['icon_delpost']
));

// Génération de la page

$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
?>