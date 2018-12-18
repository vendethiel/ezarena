<?php
/***************************************************************************
 *                              admin_arcade_games.php
 * 
 *  Entierement réecrit le 15 Juin 2006
 *  Par Saint-Pere  www.yep-yop.com
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['AreaBB Arcade']['Les catégories'] = '../areabb/mods/games/'.$file;
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
load_lang('admin_arcade');

load_function('class_categorie');
$cat = new manage_cat();


// --------------------------------------------------------------------------------------------
//    RECUPERATION des DONNES 
//	
if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{	
	// nettoyage des données. ... 
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action				= $HTTP_POST_VARS['action']; 
		$arcade_cattitle	= $HTTP_POST_VARS['arcade_cattitle'];
		$icones				= $HTTP_POST_VARS['icones'];
		$arcade_parent		= intval($HTTP_POST_VARS['arcade_parent']);
		$arcade_catid		= intval($HTTP_POST_VARS['arcade_catid']);
		$to_catid			= intval($HTTP_POST_VARS['to_catid']);
		$salle				= intval($HTTP_POST_VARS['salle']);
		
	}else{
		$action 			= $HTTP_GET_VARS['action'];
		$arcade_catid		= intval($HTTP_GET_VARS['arcade_catid']);
		$catid2				= intval($HTTP_GET_VARS['catid2']);
		$arcade_catorder	= intval($HTTP_GET_VARS['arcade_catorder']);
		$catorder2			= intval($HTTP_GET_VARS['catorder2']);
	}


	// --------------------------------------------------------------------------------------------
	//    TRAITEMENTS 
	//	
	switch ($action)
	{

		case 'resynch':
			// A-t'on demandé la resynchronisation d'une catégorie ?
			if (!$cat->resynch_arcade_categorie($arcade_catid))
			{
				$message = $lang['categorie_non_synchro'] . "<br /><br />" ;
				$message .=	sprintf($lang['Click_return_arcade_games'], "<a href=\"" . append_sid("admin_arcade_games.$phpEx") . "\">", "</a>") ;
				message_die(GENERAL_MESSAGE,$message);
				exit;				
			}
			break;
		case 'movedel':
			//A-t'on demandé déplacement + suppression d'une catégorie ?
			if (!$cat->movedel_arcade_categorie($arcade_catid,$to_catid))
			{
				$message = $lang['categorie_non_deplace'] . "<br /><br />" ;
				$message .=	sprintf($lang['Click_return_arcade_games'], "<a href=\"" . append_sid("admin_arcade_games.$phpEx") . "\">", "</a>") ;
				message_die(GENERAL_MESSAGE,$message);
				exit;	
			}
			if (!$cat->resynch_arcade_categorie($to_catid))
			{
				$message = $lang['categorie_non_synchro'] . "<br /><br />" ;
				$message .=	sprintf($lang['Click_return_arcade_games'], "<a href=\"" . append_sid("admin_arcade_games.$phpEx") . "\">", "</a>") ;
				message_die(GENERAL_MESSAGE,$message);
				exit;			
			}
			break;
		case 'delete':
			// A-t'on demandé la suppression d'une catégorie ?
			if (!$cat->delete_arcade_categorie($arcade_catid))
			{
				$message = $lang['categorie_non_suppr'] . "<br /><br />" ;
				$message .=	sprintf($lang['Click_return_arcade_games'], "<a href=\"" . append_sid("admin_arcade_games.$phpEx") . "\">", "</a>") ;
				message_die(GENERAL_MESSAGE,$message);
				exit;	
			}
			break;
		case 'editcreate':
			// A-t'on demandé la création d'une nouvelle catégorie ?
			if (trim($arcade_cattitle) =='')	message_die(GENERAL_ERROR, "Impossible de créer une catégorie sans nom");
			if (!$cat->ajoute_arcade_categorie($arcade_cattitle,$icones,$arcade_parent,$salle))
			{
				$message = $lang['categorie_non_ajoute'] . "<br /><br />" ;
				$message .=	sprintf($lang['Click_return_arcade_games'], "<a href=\"" . append_sid("admin_arcade_games.$phpEx") . "\">", "</a>") ;
				message_die(GENERAL_MESSAGE,$message);
				exit;	
			}
			break;

		case 'editsave':
			// A-t'on demandé la mise à jour d'une catégorie ?
			if(trim($arcade_cattitle) == '')	message_die(GENERAL_ERROR, "Impossible d'éditer une catégorie sans nom");
			if (!$cat->edite_arcade_categorie($arcade_cattitle,$icones,$arcade_catid,$arcade_parent,$salle))
			{
				$message = $lang['categorie_non_edite'] . "<br /><br />" ;
				$message .=	sprintf($lang['Click_return_arcade_games'], "<a href=\"" . append_sid("admin_arcade_games.$phpEx") . "\">", "</a>") ;
				message_die(GENERAL_MESSAGE,$message);
				exit;	
			}
			break;
		case 'monter':
			// A-t'on demandé de monter  une catégorie ?
			if (!$cat->move_arcade_categorie($arcade_catid,'+'))
			{
				$message = $lang['categorie_non_edite'] . "<br /><br />" ;
				$message .=	sprintf($lang['Click_return_arcade_games'], "<a href=\"" . append_sid("admin_arcade_games.$phpEx") . "\">", "</a>") ;
				message_die(GENERAL_MESSAGE,$message);
				exit;	
			}
			break;
		case 'descendre':
			// A-t'on demandé de descendre une catégorie ?
			if (!$cat->move_arcade_categorie($arcade_catid,'-'))
			{
				$message = $lang['categorie_non_edite'] . "<br /><br />" ;
				$message .=	sprintf($lang['Click_return_arcade_games'], "<a href=\"" . append_sid("admin_arcade_games.$phpEx") . "\">", "</a>") ;
				message_die(GENERAL_MESSAGE,$message);
				exit;	
			}
			break;
		case 'edit':
			//A-t'on demandé l'édition d'une catégorie ?
			$sql = 'SELECT arcade_cattitle, arcade_icone, arcade_parent, salle   
					FROM ' . AREABB_CATEGORIES_TABLE . ' 
					WHERE arcade_catid = \''.$arcade_catid.'\'';

			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible d'obtenir les infos de la table arcade_categories", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$template->set_filenames(array(
				'body' => 'areabb/mods/games/tpl/arcade_catedit_body.tpl'
			));
			$cat_title = stripslashes($row['arcade_cattitle']);
			$cat_parent = $row['arcade_parent'];
			
			
			// Listage des icones du menu
			$liste_icones = $cat->icone_arcade($phpbb_root_path.'areabb/images/menu/');
			$max_icones = sizeof($liste_icones);
			$icones ='';
			FOR ($i=0;$i<$max_icones;$i++)
			{
				if (($row['arcade_icone'] != '') AND ($row['arcade_icone'] == $liste_icones[$i]))
				{
					$icones .= '<option value="'.$liste_icones[$i].'"  selected="selected">'.$liste_icones[$i]."</options>\n";
				}else{
					$icones .= '<option value="'.$liste_icones[$i].'">'.$liste_icones[$i]."</options>\n";
				}
			}
			if ($row['arcade_icone'] != '')$icon_select = $row['arcade_icone']; else $icon_select = 'blank.gif';
			
			// liste des catégories parentes
			$sql = 'SELECT arcade_catid, arcade_cattitle 
					FROM '.AREABB_CATEGORIES_TABLE.' 
					WHERE arcade_parent = 0 ';
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible d'acceder à la table des catégorie", "", __LINE__, __FILE__, $sql);
			}
			$liste_cat = '<option value="0">' . $lang['cat_racine']. "</options>\n";
			while( $rowCat = $db->sql_fetchrow($result))
			{
				if ($rowCat['arcade_catid'] == $row['arcade_parent'])$selected = 'selected'; else $selected = '';
				if ($rowCat['arcade_catid'] != $arcade_catid)
				{
					$liste_cat .= '<option value="'.$rowCat['arcade_catid'].'" '.$selected.'>' . stripslashes($rowCat['arcade_cattitle']). "</options>\n";
				}
			}
			
			// Salle où se trouve cette catégorie
			$sql = 'SELECT id_squelette, titre 
					FROM '. AREABB_SQUELETTE .' 
					WHERE type=1 
					ORDER BY titre ASC';
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible d'acceder à la table des salles", "", __LINE__, __FILE__, $sql);
			}
			$s_salle = '';
			while( $rowSalle = $db->sql_fetchrow($result))
			{
				if ($rowSalle['id_squelette'] == $row['salle']) $selected = 'selected'; else $selected = '';
				$s_salle .=	'<option value="'.$rowSalle['id_squelette'].'" '.$selected.'>'.stripslashes($rowSalle['titre'])."</option>\n";			
			}
			
			$hidden_fields = '<input type="hidden" name="action" value="editsave" />';
			$hidden_fields .= '<input type="hidden" name="arcade_catid" value="' . $arcade_catid . '" />';
			
			$template->assign_vars(array(
				'S_ACTION'			=> append_sid("admin_arcade_games.$phpEx"),
				'S_HIDDEN_FIELDS'	=> $hidden_fields,
				'S_AUTH'			=> $liste_auth,
				'L_TITLE'			=> $lang['Admin_arcade_cat'],
				'L_EXPLAIN'			=> $lang['Admin_arcade_editcat_explain'],
				'L_SETTINGS'		=> $lang['arcade_categorie_settings'],
				'L_CAT_TITRE'		=> $lang['arcade_cat_titre'],
				'L_SUBMIT'			=> $lang['Submit'],
				'L_CAT_PARENT'		=> $lang['L_CAT_PARENT'],
				'S_CAT_PARENT'		=> $liste_cat,
				'CAT_TITLE'			=> $cat_title,
				'L_ICONE'			=> $lang['L_ICONE'],
				'S_SALLE'			=> $s_salle,
				'L_SALLE'			=> $lang['L_SALLE'],
				'ICONE'				=> $icones,
				'ICONE_SELECT'		=> $icon_select
			));

			$template->pparse("body");

			include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
			exit;

		case 'new':
			// A-t'on demandé l'édition d'une nouvelle catégorie ?
			$template->set_filenames(array(
				'body' => 'areabb/mods/games/tpl/arcade_catedit_body.tpl'
			));

			// liste des catégories parentes
			$sql = 'SELECT arcade_catid, arcade_cattitle 
					FROM '.AREABB_CATEGORIES_TABLE.' 
					WHERE arcade_parent = 0 ';
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible d'acceder à la table des catégorie", "", __LINE__, __FILE__, $sql);
			}
			$liste_cat = '<option value="0" selected="selected">' . $lang['cat_racine']. '</options>';
			while( $row = $db->sql_fetchrow($result))
			{
				$liste_cat .= '<option value="'.$row['arcade_catid'].'">' . stripslashes($row['arcade_cattitle']). "</options>\n";
			}
			
			// génération de la liste d'icones
			$liste_icones = $cat->icone_arcade ($phpbb_root_path.'areabb/images/menu/');
			$max_icones = sizeof($liste_icones);
			$icones ='';
			FOR ($i=0;$i<$max_icones;$i++)
			{
				$icones .= '<option value="'.$liste_icones[$i].'">'.$liste_icones[$i]."</options>\n";
			}
			// Salle où se trouve cette catégorie
			$sql = 'SELECT id_squelette, titre 
				FROM '. AREABB_SQUELETTE .' 
				WHERE type=1 
				ORDER BY titre ASC';
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible d'acceder à la table des salles", "", __LINE__, __FILE__, $sql);
			}
			$s_salle = '';
			while( $rowSalle = $db->sql_fetchrow($result))
			{
				if ($rowSalle['id_squelette'] == $row['salle']) $selected = 'selected'; else $selected = '';
				$s_salle .=	'<option value="'.$rowSalle['id_squelette'].'" '.$selected.'>'.stripslashes($rowSalle['titre'])."</option>\n";			
			}
			
			$hidden_fields = '<input type="hidden" name="action" value="editcreate" />';
			$template->assign_vars(array(
				'S_ACTION'			=> append_sid("admin_arcade_games.".$phpEx),
				'S_HIDDEN_FIELDS'	=> $hidden_fields,
				'S_SALLE'			=> $s_salle,
				'L_SALLE'			=> $lang['L_SALLE'],
				'L_TITLE'			=> $lang['Admin_arcade_cat'],
				'L_EXPLAIN'			=> $lang['Admin_arcade_editcat_explain'],
				'L_SETTINGS'		=> $lang['arcade_categorie_settings'],
				'L_CAT_TITRE'		=> $lang['arcade_cat_titre'],
				'L_SUBMIT'			=> $lang['Submit'],
				'L_CAT_PARENT'		=> $lang['L_CAT_PARENT'],
				'S_CAT_PARENT'		=> $liste_cat,
				'L_ICONE'			=> $lang['L_ICONE'],
				'ICONE'				=> $icones,
				'ICONE_SELECT'		=> 'blank.gif'
			));

			$template->pparse("body");

			include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
			exit;
	}

}

// --------------------------------------------------------------------------------------------
//    AFFICHAGE de la liste des catégories 
//	
$sql = 'SELECT arcade_catid,arcade_catorder,arcade_cattitle,arcade_parent, salle, arcade_nbelmt,arcade_icone, titre  
	    FROM ' . AREABB_CATEGORIES_TABLE . ' as c 
		LEFT JOIN '. AREABB_SQUELETTE .' as s ON c.salle=s.id_squelette 
		ORDER BY salle,arcade_catorder ASC';
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query arcade_categorie in admin_arcade", "", __LINE__, __FILE__, $sql);
}

$template->set_filenames(array(
	'body' =>  'areabb/mods/games/tpl/arcade_cat_manage_body.tpl'
));

$liste_cat = array();
while( $row = $db->sql_fetchrow($result) )
{
  $liste_cat[] = $row;
}

$salle_precedente = -99;
$nbcat = sizeof($liste_cat);
for ( $b = 0 ; $b < $nbcat ; $b++ )
{
	if ($liste_cat[$b]['salle'] != $salle_precedente)
	{
		$template->assign_block_vars('salle', array(
			'TITRE_SALLE' => stripslashes($liste_cat[$b]['titre'])
		));
	}
		
	if ( $td_row == 'row1' )	$td_row = 'row2'; else $td_row = 'row1';
	// C'est une catégorie racine 
	if ($liste_cat[$b]['arcade_parent'] == '0')
	{
		// On affiche les catégories racines
		$cat->affichage_liste($liste_cat,$b);

		// On cherche les sous cat
		for ($a=0;$a<$nbcat;$a++)
		{
			if ($liste_cat[$b]['arcade_catid'] == $liste_cat[$a]['arcade_parent'])
			{
				// On affiche les sous catégories SEULEMENT si
				// il s'agit bien d'une catégorie enfant
				$cat->affichage_liste($liste_cat,$a);
			}
		}
	}
	$salle_precedente = $liste_cat[$b]['salle'];
}

// Affichage de la catégorie joker "Jeux non classés" uniquement visible dans l'admin
if ( $td_row == 'row1' )	$td_row = 'row2'; else $td_row = 'row1';
$template->assign_block_vars('arcade_catrow', array(
  'TD_ROW'			=> $td_row,
  'L_UP'			=> '',
  'L_DOWN'			=> '',
  'ARCADE_CATID'	=> '0',
  'U_EDIT'			=> '',
  'U_UP'			=> '',
  'U_DOWN'			=> '',
  'ICONE'			=> '',
  'U_DELETE'		=> '',
  'U_SYNCHRO'		=> '',
  'ARCADE_CAT_NBELMT'=> '',
  'ARCADE_CATORDER'	=> ''
));



$hidden_fields = '<input type="hidden" name="action" value="new" />';

$template->assign_vars(array(
	'S_ACTION'			=> append_sid("admin_arcade_games.".$phpEx),
	'S_HIDDEN_FIELDS'	=> $hidden_fields,
	'ARCADE_CATTITLE' 	=> $lang['jeu_non_classe'],
	'U_MANAGE'			=> append_sid('arcade_elmt.'.$phpEx.'?arcade_catid=0'),  
	'U_SYNCHRO'			=> append_sid("admin_arcade_games.$phpEx?action=resynch"),
	'L_TITLE'			=> $lang['Admin_arcade_cat'],
	'L_EXPLAIN'			=> $lang['Admin_arcade_cat_explain'],
	'L_DESCRIPTION'		=> $lang['Description'],
	'L_NBRE_JEUX'		=> $lang['L_NBRE_JEUX'],
	'L_ACTION'			=> $lang['Action'],
	'L_EDIT'			=> $lang['Edit'],
	'L_MANAGE'			=> $lang['Manage'],
	'L_DELETE'			=> $lang['Delete'],
	'L_DEPLACE'			=> $lang['Deplace'],
	'L_SYNCHRO'			=> $lang['Resynch'],
	'L_NEWCAT'			=> $lang['New_category'],
	'L_SUBMIT'			=> $lang['Submit'], 
	'L_RESET'			=> $lang['Reset'],
	'L_UP'				=> $lang['Up_arcade_cat'],
	'L_DOWN'			=> $lang['Down_arcade_cat'],
	'I_EDIT'			=> $phpbb_root_path .$images['icon_edit'],
	'I_SYNC'			=> $phpbb_root_path .$images['icon_areabb_synchro'],
	'I_GERER'			=> $phpbb_root_path .$images['icon_areabb_gerer'],
	'I_UP'				=> $phpbb_root_path .$images['icon_areabb_up'],
	'I_DOWN'			=> $phpbb_root_path .$images['icon_areabb_down'],
	'I_SUPP'			=> $phpbb_root_path .$images['icon_delpost']
));

$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>
