<?php
/*****************************************************************************
*
*		admin_liens.php
*
* commencé le 22 Août 2006 par Saint-Pere - www.yep-yop.com
*
*
******************************************************************************/


define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['AreaBB Extensions']['Les liens'] = '../areabb/mods/liens/'.$file;
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
load_function('fonctions_chaine');
load_lang('admin');
load_lang('liens');

//
// Modifie l'ordre d'affichage des liens
// $sens = '+'  monter
// $sens = '-'  descendre
//
function monter_lien($id_lien,$sens='+')
{
	global $db;
	$liste_lien= array();
	
	$sql = 'SELECT id_lien
		FROM '. AREABB_LIENS .'
		ORDER BY ordre ASC';
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'obtenir des infos sur ce lien", '', __LINE__, __FILE__, $sql); 
	}
	while ($row = $db->sql_fetchrow($result))
	{
		$liste_lien[] = $row['id_lien'];
	}
	if (in_array($id_lien,$liste_lien))
	{
		
		$clef = array_search($id_lien,$liste_lien);
		switch ($sens)
		{
			case '+':
				$tmp = $liste_lien[$clef]; 
				$liste_lien[$clef] = $liste_lien[($clef-1)];
				$liste_lien[($clef-1)] = $tmp;
				break;
			case '-':
				$tmp = $liste_lien[$clef]; 
				$liste_lien[$clef] = $liste_lien[($clef+1)];
				$liste_lien[($clef+1)] = $tmp;		
				break;		
		}
		$cmpt = count($liste_lien);
		for ($i=0;$i<$cmpt;$i++)
		{
			$sql = 'UPDATE '. AREABB_LIENS .' 
					SET ordre='.$i.' 
					WHERE id_lien='.$liste_lien[$i];
			$db->sql_query($sql);
		}
		return true;
	}else{
		return false;
	}
	
}

//
// Renvoit l'image corrigée

function corriger_image_liensBB($image,$titre)
{
	global $phpbb_root_path;
	if ($image != '') 
	{
		if (!ereg('http://',$image)) $image = $phpbb_root_path.$image; 
		$image = '<img src="'.$image.'" border="0" alt="'.$titre.'"  title="'.$titre.'" align="center" />';
	}else{
		$image= '';
	}
	return $image;
}

//
// Crée la mise en cache du contenu du mod lien.

function creer_cache_mod_lien()
{
	global $template,$db,$areabb,$lang;
	ob_start();
	$template->set_filenames(array(
	      'cache_liens' => 'areabb/mods/liens/tpl/mod_liens.tpl'
	));

	$ordre = ($areabb['liens_aleatoire'] == '1')? ' RAND() ' : ' ordre ASC ';
	$limit = ($areabb['liens_nbre_liens'] == '0')? ' 100 ' : $areabb['liens_nbre_liens'];

	$sql = 'SELECT id_lien, titre, lien, vignette 
		FROM '. AREABB_LIENS .' 
		ORDER BY '.$ordre.' 
		LIMIT '.$limit;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain link information', '', __LINE__, __FILE__, $sql);
	}
	while ($row = $db->sql_fetchrow($result))
	{
		$titre = $row['titre'];
		// si il y a une image on l'affiche
		if ($row['vignette'] != '')
		{
			$image = '<img src="'.$row['vignette'].'" border="0" alt="'.$row['titre'].'" title="'.$row['titre'].'">';
			$titre = '';
		}	
		$template->assign_block_vars('liens', array(
			// on crée un lien renvoyant vers ce mod
			'IMAGE'	=> $image,
			'TITRE' => $titre,
			'LIEN'	=> $row['lien']
		));
	}

	// on affiche le scroll ? 
	if ($areabb['liens_scroll'] == 1) $template->assign_block_vars('scroll', array());
	$template->assign_vars(array(	
		'L_MOD_LIENS'	=> $lang['L_MOD_LIENS']
	));	
	$template->pparse('cache_liens');
	$template->destroy();
	
	$recuperation_sortie = ob_get_contents();
	ob_clean();
	
	// ecriture du fichier de cache
	$rFile = @fopen(CHEMIN_LIENS,"w+");
	if (!$rFile) {
		return "ERREUR: Impossible d'ecrire dans le dossier 1 " . dirname(realpath(CHEMIN_LIENS)) ." (avez vous fait un CHMOD 777 ? )" ;
	}
	fwrite($rFile,$recuperation_sortie);
	fclose($rFile);

	return true;
}

// --------------------------------------------------------------------------------------------
// TRAITEMENT des données
//
$editer_titre = ''; 
$editer_url = ''; 
$editer_image = ''; 
$hidden = '<input type="hidden" name="action" value="ajouter" />';
$apercu_image = '';

if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action	= $HTTP_POST_VARS['action']; 
		if (isset($HTTP_POST_VARS['news_forums']))
		{
			$HTTP_POST_VARS['news_forums'] = implode(',',$HTTP_POST_VARS['news_forums']);
		}
		$titre	= $HTTP_POST_VARS['titre']; 
		$url	= $HTTP_POST_VARS['url']; 
		$image	= $HTTP_POST_VARS['image']; 
		$id_lien= eregi_replace('[^0-9]','',$HTTP_POST_VARS['id_lien']);
	}else{
		$action	= $HTTP_GET_VARS['action']; 
		$id_lien= eregi_replace('[^0-9]','',$HTTP_GET_VARS['id_lien']);
	}

	switch($action)
	{
		case 'ajouter':
			// on définit la position maximale
			$sql =  'SELECT MAX(ordre) as max FROM '.AREABB_LIENS;
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Failed to select link information', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$max = $row['max'];
			
			// On ajoute un lien dans notre base
			$sql = 'INSERT INTO '.AREABB_LIENS.' (titre,lien,ordre,vignette) 
				VALUES (\''.$titre.'\',\''.$url.'\','.($max+10).',\''.$image.'\')';
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Failed to select link information', '', __LINE__, __FILE__, $sql);
			}
		break;
		
		case 'enregistrer':
			// Enregistrement des modifications effectuées sur la config générale	
			$sql = 'SELECT * FROM ' . AREABB;
			if(!$result = $db->sql_query($sql))
			{
				message_die(CRITICAL_ERROR, "Could not query config information in Admin AreaBB", "", __LINE__, __FILE__, $sql);
			}
			while( $row = $db->sql_fetchrow($result) )
			{
				$nom = $row['nom'];
				$valeur = $row['valeur'];
				$default[$nom] = $valeur;
				
				$new[$nom] = ( isset($HTTP_POST_VARS[$nom]) ) ? $HTTP_POST_VARS[$nom] : $default[$nom];
		
				$sql = 'UPDATE ' . AREABB . ' 
					SET valeur = \'' . str_replace("\'", "''", $new[$nom]) . '\'
					WHERE nom = \''.$nom.'\'';
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Failed to update Areabb configuration for '.$nom, '', __LINE__, __FILE__, $sql);
				}
			}
			break;
			
		case 'monter':
			// monter le lien
			monter_lien($id_lien,'+');
			break;
			
		case 'descendre':
			// descendre le lien
			monter_lien($id_lien,'-');
			break;
			
		case 'supprimer':
			// supprimer le lien
			$sql = 'DELETE FROM '.AREABB_LIENS.' WHERE id_lien='.$id_lien;
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Failed to delete link', '', __LINE__, __FILE__, $sql);
			}
			break;
		case 'editer':
			// préparer l'edition
			$sql = 'SELECT id_lien, titre, lien, vignette 
					FROM '. AREABB_LIENS .' 
					WHERE id_lien='.$id_lien;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain link information', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$editer_titre = $row['titre'];
			$editer_url = $row['lien'];
			$editer_image = $row['vignette'];
			$apercu_image = corriger_image_liensBB($row['vignette'],$row['titre']);
			$hidden = '<input type="hidden" name="id_lien" value="'.$id_lien.'"><input type="hidden" name="action" value="edit" />';
			break;
		case 'edit':
			// On ajoute un lien dans notre base
			$sql = 'UPDATE '.AREABB_LIENS.' SET 
						titre=\''.$titre.'\',
						lien=\''.$url.'\',
						vignette=\''.$image.'\'
					WHERE id_lien='.$id_lien;
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Failed to select link information', '', __LINE__, __FILE__, $sql);
			}
			break;
	}
	read_config();
	if ($areabb['liens_cache'] == 1)
	{
		// on refait le cache
		creer_cache_mod_lien();
	}
}

// --------------------------------------------------------------------------------------------
//    AFFICHAGE
//

$template->set_filenames(array(
	'body' => 'areabb/mods/liens/tpl/admin_liens.tpl'
));

//
// INFOS sur l'Arcade 

$sql = 'SELECT * FROM ' . AREABB;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_arcade", "", __LINE__, __FILE__, $sql);
}
while( $row = $db->sql_fetchrow($result) )
{
	$new[$row['nom']]= $row['valeur'];	
}

// nbre de liens
$s_nbre_liens = ( $new['liens_nbre_liens'] == '') ? '0' : $new['liens_nbre_liens'];

// liens aléatoire ?
$s_aleatoire_yes = ( $new['liens_aleatoire'] == 1) ? 'checked' : '';
$s_aleatoire_no = ( $new['liens_aleatoire'] == 0) ? 'checked' : '';

// afficher les clics ?
$s_clics_yes = ( $new['liens_clics'] == 1) ? 'checked' : '';
$s_clics_no = ( $new['liens_clics'] == 0) ? 'checked' : '';

// Afficher le scroll ?
$s_scroll_yes = ( $new['liens_scroll'] == 1) ? 'checked' : '';
$s_scroll_no = ( $new['liens_scroll'] == 0) ? 'checked' : '';

// Activer le cache ?
$s_cache_yes = ( $new['liens_cache'] == 1) ? 'checked' : '';
$s_cache_no = ( $new['liens_cache'] == 0) ? 'checked' : '';

// listing des liens

$sql = 'SELECT id_lien, titre, lien, vignette 
	FROM '. AREABB_LIENS .' 
	ORDER BY ordre ASC';
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain link information', '', __LINE__, __FILE__, $sql);
}
while ($row = $db->sql_fetchrow($result))
{
	$image = corriger_image_liensBB($row['vignette'],$row['titre']);
	$titre = $row['titre'];
	$lien = '<a href="'.$row['lien'].'" target="_blank">'.substr($row['lien'],0,25).'</a>';
	$template->assign_block_vars('liens', array(
		'IMAGE'	=> $image,
		'TITRE' => $titre,
		'LIEN'	=> $lien,
		'DESCENDRE'	=> append_sid('admin_liens.'.$phpEx.'?action=descendre&id_lien='.$row['id_lien']),
		'MONTER'	=> append_sid('admin_liens.'.$phpEx.'?action=monter&id_lien='.$row['id_lien']),
		'EDITER'	=> append_sid('admin_liens.'.$phpEx.'?action=editer&id_lien='.$row['id_lien']),
		'SUPPR'		=> append_sid('admin_liens.'.$phpEx.'?action=supprimer&id_lien='.$row['id_lien'])
	));
}




$template->assign_vars(array(	
	'L_YES'						=> $lang['Yes'],
	'L_NO'						=> $lang['No'],
	'TITRE'						=> $editer_titre,
	'LIEN'						=> $editer_url,
	'IMAGE'						=> $editer_image,
	'APERCU_IMAGE'				=> $apercu_image,
	'HIDDEN'					=> $hidden,
	'NBRE_LIENS'				=> $s_nbre_liens,
	'ALEA_YES'					=> $s_aleatoire_yes,
	'ALEA_NO'					=> $s_aleatoire_no,
	'SCROLL_YES'				=> $s_scroll_yes,
	'SCROLL_NO'					=> $s_scroll_no,	
	'CACHE_YES'					=> $s_cache_yes,
	'CACHE_NO'					=> $s_cache_no,
	'L_CACHE'					=> $lang['L_CACHE'],
	'L_GENERAL_LIENS_ADMIN'		=> $lang['L_GENERAL_LIENS_ADMIN'],
	'L_GENERAL_LIENS_ADMIN_EXP'	=> $lang['L_GENERAL_LIENS_ADMIN_EXP'],
	'L_GENERAL_SETTINGS'		=> $lang['Config_arcade'],
	'L_NBRE_LIENS'				=> $lang['L_NBRE_LIENS'],
	'L_ALEATOIRE'				=> $lang['L_ALEATOIRE'],
	'L_SCROLL'					=> $lang['L_SCROLL'],
	'L_SUBMIT'					=> $lang['Submit'],
	'L_RESET'					=> $lang['Reset'],
	'L_AJOUTER_LIEN'			=> $lang['L_AJOUTER_LIEN'],
	'L_URL_LIEN'				=> $lang['L_URL_LIEN'],
	'L_IMG_LIEN'				=> $lang['L_IMG_LIEN'],
	'L_TITRE'					=> $lang['L_TITRE'],
	'L_LISTE_LIENS'				=> $lang['L_LISTE_LIENS'],
	'L_T_CLICS'					=> $lang['L_T_CLICS'],
	'L_T_IMAGE'					=> $lang['L_T_IMAGE'],
	'L_T_TITRE'					=> $lang['L_T_TITRE'],
	'L_T_LIEN'					=> $lang['L_T_LIEN'],
	'L_GERER'					=> $lang['L_GERER'],
	'I_UP'						=> $phpbb_root_path.$images['icon_areabb_up'],
	'I_DOWN'					=> $phpbb_root_path.$images['icon_areabb_down'],
	'I_EDIT'					=> $phpbb_root_path .$images['icon_edit'],
	'I_SUPP'					=> $phpbb_root_path.$images['icon_delpost']
	
	));


$template->pparse('body');
include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
?>