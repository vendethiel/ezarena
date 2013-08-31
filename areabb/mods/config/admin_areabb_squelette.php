<?php
/***************************************************************************
 *                              admin_arcade_squelette.php
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
	$module['AreaBB']['Les Salles'] = '../areabb/mods/config/'.$file;
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

// On définit les salles 
$constantes_definies = get_defined_constants();
foreach($constantes_definies as $key => $value)
{ 
	if (ereg('NOM_',$key))	$type_salles[] = $value;
}
$nbre_types = sizeof($type_salles);

load_function('class_squelette');
$squelette = new generation_squelette($phpbb_root_path);


// ---------------------------------------------------------------------------
// TRAITEMENT DES PARAMETRES
//

if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action 		= $HTTP_POST_VARS['action']; 
		if (isset($HTTP_POST_VARS['pris']))
		{
			$pris 		=  eregi_replace('[^0-9,]','',implode(',',$HTTP_POST_VARS['pris'])); 
		}
		$titre 			= $HTTP_POST_VARS['titre'];
		$id_squelette 	=  eregi_replace('[^0-9]','',$HTTP_POST_VARS['id_squelette']);
		$pagephp 		=  eregi_replace('[^0-9]','',$HTTP_POST_VARS['pagephp']);
	}else{
		$action 		= $HTTP_GET_VARS['action'];
		$id_squelette 	=  eregi_replace('[^0-9]','',$HTTP_GET_VARS['id_squelette']);
		$type		 	=  eregi_replace('[^0-9]','',$HTTP_GET_VARS['type']);
	}
}


// ---------------------------------------------------------------------------
// ACTIONS
//
$defaut =  eregi_replace('[^0-9]','',$HTTP_GET_VARS['defaut']);
$type =  eregi_replace('[^0-9]','',$HTTP_GET_VARS['type']);
if ($defaut != '') $action = 'defaut';


switch($action)
{
	case 'monter':
		$squelette->monter_squelette($id_squelette,$type,'+');
		break;
	case 'descendre':
		$squelette->monter_squelette($id_squelette,$type,'-');
		break;
	case 'droits':
		// Enregistrement des droits d'accès à cette salle
		$sql = 'UPDATE '.AREABB_SQUELETTE .' 
			SET groupes=\''. $pris .'\' 
			WHERE id_squelette='.$id_squelette;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible de mettre à jour les droits d'accès à cette salle", '', __LINE__, __FILE__, $sql); 
		}	
		break;
	case 'defaut':
		// On place la salle indiquée pour ce type de fichier comme salle par défaut
		$sql = 'SELECT nom FROM '.AREABB.' WHERE nom=\''.$type_salles[($type - 1)].'_par_defaut\'';
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
		}
		if ($db->sql_numrows($result) > 0)
		{
			$sql = 'UPDATE '. AREABB .' 
				SET valeur='.$defaut.'
				WHERE nom=\''.$type_salles[($type - 1)].'_par_defaut\'';
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
			}
			break;
		}else{
			$sql = 'INSERT INTO '. AREABB .' (valeur, nom) VALUES ('.$defaut.',\''.$type_salles[($type - 1)].'_par_defaut\')';
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
			}
			break;
		}
	case 'ajout':
		// On créée un nouveau squelette pour une nouvelle salle
		if (!$squelette->ajouter_squelette($titre,$pagephp))
		{
			$message = $lang['squelette_non_ajoute'] . "<br /><br />" ;
			$message .=	sprintf($lang['Click_return_arcade_squelette'], "<a href=\"" . append_sid("admin_areabb_squelette.$phpEx") . "\">", "</a>") ;
			$message .= "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"".append_sid($phpbb_root_path ."index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
		$dernier_squelette = $db->sql_nextid($result);
		// on met en place la premiere page par défaut.
		$sql = 'SELECT id_squelette FROM '.AREABB_SQUELETTE.' WHERE type=\''.$pagephp.'\'';
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
		}
		if ($db->sql_numrows($result) == 1)
		{
			$sql = 'SELECT nom FROM '.AREABB.' WHERE nom=\''.$type_salles[($pagephp - 1)].'_par_defaut\'';
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
			}
			if ($db->sql_numrows($result) > 0)
			{
				$sql = 'UPDATE '. AREABB .' 
						SET valeur='.$dernier_squelette.'
						WHERE nom=\''.$type_salles[($pagephp - 1)].'_par_defaut\'';
				if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
					}
			}else{
					$sql = 'INSERT INTO '. AREABB .' (valeur, nom) VALUES ('.$dernier_squelette.',\''.$type_salles[($pagephp - 1)].'_par_defaut\')';
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, "Impossible de mettre cette salle en espace par défaut.", '', __LINE__, __FILE__, $sql); 
					}
			}
		}		
		break;		
		
	case 'suppression':
		// On désire supprimer une salle.
		if (!$squelette->supprimer_squelette($id_squelette))
		{
			$message = $lang['squelette_non_supprime'] . "<br /><br />" ;
			$message .=	sprintf($lang['Click_return_arcade_squelette'], "<a href=\"" . append_sid("admin_areabb_squelette.$phpEx") . "\">", "</a>") ;
			$message .= "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"".append_sid($phpbb_root_path ."index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
		break;
	case 'edit':
		// on modifie le nom d'une salle
		if (!$squelette->editer_squelette($titre,$id_squelette))
		{
			$message = $lang['squelette_non_ajoute'] . "<br /><br />" ;
			$message .=	sprintf($lang['Click_return_arcade_squelette'], "<a href=\"" . append_sid("admin_areabb_squelette.$phpEx") . "\">", "</a>") ;
			$message .= "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"".append_sid($phpbb_root_path ."index.$phpEx?pane=right") . "\">", "</a>");
			message_die(GENERAL_MESSAGE, $message);
		}
		break;
		
}
read_config();

// --------------------------------------------------------------------------------------------
//    AFFICHAGE
//

$template->set_filenames(array(
	'body' => 'areabb/mods/config/tpl/areabb_squelette.tpl'
));

$nbre_salles = 0;
for ($i=0; $i <= $nbre_types;$i++)
{
	// On affiche la liste des squelettes
	$sql = 'SELECT id_squelette, titre, type, groupes   
		FROM '. AREABB_SQUELETTE .' 
		WHERE type = '.$i.' 
		ORDER BY position ASC';
		
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible d'afficher la liste des squelettes", '', __LINE__, __FILE__, $sql); 
	}
	
	if ($db->sql_numrows($result)  != 0 )
	{
		$template->assign_block_vars('type_salle', array(
			'SALLE' => $type_salles[($i-1)].'.'.$phpEx
		));
		
		while ($row = $db->sql_fetchrow($result))
		{	
			// Salle par défaut
			if($areabb[$type_salles[($row['type'] - 1)].'_par_defaut'] == $row['id_squelette']){
				$salle_def = true;
				$defaut = '<img src="'.$phpbb_root_path.'areabb/images/true.gif" border="0">';
			}else{
				$salle_def = false;
				$defaut = '<a href="'.append_sid('admin_areabb_squelette.'.$phpEx.'?type='.$row['type'].'&defaut='.$row['id_squelette']).'" alt="" title="'.$lang['L_DEFAULT_SQUEL'].'">
				<img src="'.$phpbb_root_path.'areabb/images/false.gif" border="0"></a>';
			}
			$template->assign_block_vars('type_salle.liste_squelettes', array(
				'ID'			=> $row['id_squelette'],
				'U_HREF'		=> $phpbb_root_path . $type_salles[($i-1)].'.'.$phpEx . ($salle_def ? '' : '?salle=' . $row['id_squelette']),
				'TITRE'			=> stripslashes($row['titre']),
				'UP'			=> append_sid('admin_areabb_squelette.'.$phpEx.'?action=monter&type='.$i.'&id_squelette='.$row['id_squelette']),
				'DOWN'			=> append_sid('admin_areabb_squelette.'.$phpEx.'?action=descendre&type='.$i.'&id_squelette='.$row['id_squelette']),
				'BLOCS'			=> append_sid('areabb_squelette_blocs.'.$phpEx.'?id_squelette='.$row['id_squelette']),	 
				'EDITER'		=> append_sid('areabb_squelette_feuilles.'.$phpEx.'?id_squelette='.$row['id_squelette']),	 
				'SUPPRIMER'		=> append_sid('admin_areabb_squelette.'.$phpEx.'?action=suppression&id_squelette='.$row['id_squelette']),	 
				'ID_SQUELETTE'	=> $row['id_squelette']	,
				'DEFAUT'		=> $defaut
			));
			
			// groupes selectionnés
			$salle[$nbre_salles]['groupes'] = explode(',',$row['groupes']);
			// ID salle
			$salle[$nbre_salles]['id_salle'] = $row['id_squelette'];
			// nom de la salle
			$salle[$nbre_salles]['titre_salle'] = stripslashes($row['titre']);
			
			$nbre_salles++;
			
		}
	}
}

// --------------------------------------------------------------------------------------------
// AFFICHAGE des groupes 
//
$sql = 'SELECT group_id , group_name 
	FROM '. GROUPS_TABLE .' 
	WHERE group_single_user != 1 OR   	
	group_name = "Admin"
	ORDER BY group_name';
         
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Impossible d\'acceder à la table des groupes', '', __LINE__, __FILE__, $sql);
}
 
$i = 0;
$groupes_existants = array();
while( $row = $db->sql_fetchrow($result) )
{
	$groupes_existants[$i]['group_id'] = $row['group_id'];
	$groupes_existants[$i]['group_name'] = stripslashes($row['group_name']);
	$i++;
}

// nombre de groupes existants
$nbre_groupes_existants = $i;

// on parcours nos salles 
for ($i=0;$i < $nbre_salles;$i++)
{
	$pris = '';
	for ($a=0; $a < $nbre_groupes_existants; $a++)
	{
		// ce groupe fait-il partie de ceux déjà séléctionnés ?
		if (in_array($groupes_existants[$a]['group_id'],$salle[$i]['groupes']))	$selected= 'selected';	else $selected= '';
		
		$pris .= '<option value="'.$groupes_existants[$a]['group_id'].'" '.$selected.'>'.$groupes_existants[$a]['group_name']."</option>\n";			
	}
	$template->assign_block_vars("salles", array(
		'TITRE_SALLE'	=> $salle[$i]['titre_salle'],
		'ID_SALLE'		=> $salle[$i]['id_salle'],
		'PRIS'			=> $pris
	));
	unset($pris);
}



$listing_salles = '';
for ($i=0;$i < $nbre_types;$i++)
{
	$listing_salles .= "\n \t".'<option value="'.($i+1).'">'.$type_salles[$i].'.'.$phpEx.'</option>';
}



$template->assign_vars(array(
	'LISTING_SALLES'			=> $listing_salles,
	'L_AJOUT_EXPLAIN_PAGE_PHP'	=> $lang['L_AJOUT_EXPLAIN_PAGE_PHP'],
	'MODIFIER'					=> $lang['MODIFIER'],
	'AJOUTER'					=> $lang['AJOUTER'],
	'L_SQUELETTE'				=> $lang['L_SQUELETTE'],
	'L_EXPLAIN_SQUELETTE'		=> $lang['L_EXPLAIN_SQUELETTE'], 
	'L_AJOUT_EXPLAIN_SQUELETTE'	=> $lang['L_AJOUT_EXPLAIN_SQUELETTE'], 
	'L_AJOUT_SQUELETTE'			=> $lang['L_AJOUT_SQUELETTE'],
	'L_SALLES'					=> $lang['L_SALLES'],
	'L_DEFAULT'					=> $lang['L_DEFAULT'],
	'L_EDITION'					=> $lang['L_EDITION'],
	'L_GESTION'					=> $lang['L_GESTION'],
	'L_PRIS'					=> $lang['L_PRIS'],
	'L_ENREGISTRER'				=> $lang['L_ENREGISTRER'],
	'I_DOWN'					=> $phpbb_root_path .$images['icon_areabb_down'],
	'I_UP'						=> $phpbb_root_path .$images['icon_areabb_up'],	
	'I_EDIT'					=> $phpbb_root_path .$images['icon_edit'],
	'I_SUPP'					=> $phpbb_root_path .$images['icon_delpost'],
	'I_ACCES'					=> $phpbb_root_path .$images['icon_areabb_acces'],
	'I_BLOCS'					=> $phpbb_root_path .$images['icon_areabb_blocs'],
	'I_FEUILLES'				=> $phpbb_root_path .$images['icon_areabb_feuilles']
));


$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
?>