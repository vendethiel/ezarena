<?php
/***************************************************************************
 *                             admin_arcade_blocs_html.php
 *                            -------------------
 *   Commencé le mardi 10 juillet 2006
 *   Par Saint-Pere www.yep-yop.com
 *
 *   Cette page permet de gérer les blocs HTML. 
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['AreaBB']['Les blocs HTML'] = '../areabb/mods/config/'.$file;
	return true;
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

// Nombre de caracsteres à afficher dans l'apercu du message
$nbcar = 100;

// Paramètre par défaut
$message	= $lang['DEFAULT_MSG_HTML'];

// --------------------------------------------------------------------------------------------
// TRAITEMENT des données
//

if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action = $HTTP_POST_VARS['action']; 
		$titre	= $HTTP_POST_VARS['titre'];
		$message= $HTTP_POST_VARS['message'];
		$id	= eregi_replace('[^0-9]','',$HTTP_POST_VARS['id']);
	}else{
		$action = $HTTP_GET_VARS['action'];
		$id	= eregi_replace('[^0-9]','',$HTTP_GET_VARS['id']);
	}
}


switch($action)
{
	case 'ajouter':
		// ENREGISTREMENT
		$sql = 'INSERT INTO '.AREABB_BLOCS_HTML.' (titre, message) 
			VALUES (\''.$titre.'\',\''.$message.'\')';
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'enregistrer ce nouveau bloc HTML", '', __LINE__, __FILE__, $sql); 
		}
		$hidden		= '<input type="hidden" name="action" value="ajouter">';
		$titre		= '';
		$message		= '';
		break;
	case 'editer':
		// On prépare le bloc pour qu'il soit éditable
		$sql = 'SELECT id_bloc, titre, message 
			FROM '.AREABB_BLOCS_HTML.' 
			WHERE id_bloc='.$id;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible de récuperer les infos sur ce bloc HTML", '', __LINE__, __FILE__, $sql); 
		}
		$row	= $db->sql_fetchrow($result);
		$titre	= $row['titre'];
		$message= $row['message'];
		$hidden	= '<input type="hidden" name="action" value="edit"><input type="hidden" name="id" value="'.$row['id_bloc'].'">';		
		break;
	case 'edit':
		// MISE A JOUR
		$sql = 'UPDATE '.AREABB_BLOCS_HTML.' 
			SET titre=\''.$titre.'\', message=\''.$message.'\' 
			WHERE id_bloc='.$id;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible de mettre à jour les infos sur ce bloc HTML", '', __LINE__, __FILE__, $sql); 
		}
		$hidden		= '<input type="hidden" name="action" value="ajouter">';
		$titre		= '';
		$message	= '';
		break;
	case 'supprimer':
		// SUPPRESSION
		$sql = 'DELETE FROM '. AREABB_BLOCS_HTML.' 
			WHERE id_bloc='.$id;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible de supprimer ce bloc HTML", '', __LINE__, __FILE__, $sql); 
		}
		break;
	default :
		$hidden		= '<input type="hidden" name="action" value="ajouter">';
		$titre		= '';
		$message		= '';
		break;
}
		
		


// --------------------------------------------------------------------------------------------
//    AFFICHAGE
//

$template->set_filenames(array(
	'body' => 'areabb/mods/config/tpl/areabb_blocs_html.tpl')
);



//
// LISTE DES BLOCS DISPOS
//
$sql = 'SELECT id_bloc, titre, message 
	FROM '. AREABB_BLOCS_HTML .' 
	ORDER BY titre ASC';
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible de récuperer la liste des blocs HTML dispos", '', __LINE__, __FILE__, $sql); 
}
if ($db->sql_numrows($result) > 0)
{
	$template->assign_block_vars('html', array());
	while ($row = $db->sql_fetchrow($result))
	{
		$apercu_message = strip_tags(preg_replace("'<php>(.*)<php>'si",'',$row['message']));

		$template->assign_block_vars('html.lignes', array(
			'TITRE'		=> strip_tags($row['titre']),
			'MESSAGE'	=> (strlen($apercu_message) > $nbcar)? ereg_replace("(.{$nbcar})( .*)$","\\1 ...", $apercu_message): $apercu_message,
			'EDITER'	=> append_sid('admin_areabb_blocs_html.'.$phpEx.'?action=editer&id='.$row['id_bloc']),
			'SUPPRIMER'	=> append_sid('admin_areabb_blocs_html.'.$phpEx.'?action=supprimer&id='.$row['id_bloc'])
		));
	}	
}

$template->assign_vars(array(	
	'TITRE'					=> $titre,
	'MESSAGE'				=> $message,
	'HIDDEN'				=> $hidden,
	'L_BLOCS_HTML'			=> $lang['L_BLOCS_HTML'],
	'L_EXPLAIN_BLOCS_HTML'	=> $lang['L_EXPLAIN_BLOCS_HTML'],
	'L_TITLE'				=> $lang['L_TITLE'],
	'L_MESSAGE'				=> $lang['L_MESSAGE'],
	'L_ENVOYER'				=> $lang['L_ENVOYER'],
	'LISTE_BLOCS_HTML'		=> $lang['LISTE_BLOCS_HTML'],
	'I_EDIT'				=> $phpbb_root_path .$images['icon_edit'],
	'I_SUPP'				=> $phpbb_root_path .$images['icon_delpost']
	
));	


$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>