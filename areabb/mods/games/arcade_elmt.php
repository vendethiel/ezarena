<?php
/***************************************************************************
 *                             arcade_elmt.php
 *
 * 	Intégralement réecrit le 15 Juin 2006 
 *	Par Saint-Pere  www.yep-yop.com
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

define('ROOT_STYLE','admin');
$phpbb_root_path = '../../../';
require($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
load_lang('admin');
load_lang('admin_arcade');

load_function('class_games');
$games_root = $phpbb_root_path . 'areabb/games/';
$jeux = new games($games_root);


// --------------------------------------------------------------------------------------------
// TRAITEMENT DES PARAMETRES
//
$arcade_catid		= eregi_replace('[^0-9]','',$HTTP_GET_VARS['arcade_catid']);
	
if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{	
	// nettoyage des données. ... 
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action				= $HTTP_POST_VARS['action']; 
		$game_name			= $HTTP_POST_VARS['game_name']; 
		$game_id			= eregi_replace('[^0-9]','',$HTTP_POST_VARS['game_id']);
		$game_swf			= $HTTP_POST_VARS['game_swf']; 
		$game_pic			= $HTTP_POST_VARS['game_pic']; 
		$game_pic_large		= $HTTP_POST_VARS['game_pic_large']; 
		$game_desc			= $HTTP_POST_VARS['game_desc']; 
		$game_scorevar		= $HTTP_POST_VARS['game_scorevar']; 
		$valid				= $HTTP_POST_VARS['valid']; 
		$selection			= $HTTP_POST_VARS['selection']; 
		$game_type			= eregi_replace('[^0-9]','',$HTTP_POST_VARS['game_type']);
		$game_width			= eregi_replace('[^0-9]','',$HTTP_POST_VARS['game_width']);
		$game_height		= eregi_replace('[^0-9]','',$HTTP_POST_VARS['game_height']);
		$arcade_catid		= eregi_replace('[^0-9]','',$HTTP_POST_VARS['arcade_catid']);
		$last_catid			= eregi_replace('[^0-9]','',$HTTP_POST_VARS['last_catid']);
		$deplacer			= eregi_replace('[^0-9]','',$HTTP_POST_VARS['deplacer']);
		$cheater			= eregi_replace('[^0-9]','',$HTTP_POST_VARS['cheater']);	
	}else{
		$action 			= $HTTP_GET_VARS['action'];
		$game_name			= $HTTP_GET_VARS['game_name']; 
		$game_id			= eregi_replace('[^0-9]','',$HTTP_GET_VARS['game_id']);
		$last_catid			= eregi_replace('[^0-9]','',$HTTP_GET_VARS['last_catid']);	
		$gid2				= eregi_replace('[^0-9]','',$HTTP_GET_VARS['gid2']);	
		$game_order			= eregi_replace('[^0-9]','',$HTTP_GET_VARS['game_order']);	
		$game_order2		= eregi_replace('[^0-9]','',$HTTP_GET_VARS['game_order2']);	
	}


	
	// Traitement Prémiliminaire si il s'agit de mass actions
	if ($action == 'massaction')
	{
		$selected_check = ( isset($HTTP_POST_VARS['select_list']) ) ?  $HTTP_POST_VARS['select_list'] : array();
		$select_id_sql = '';
		$csc = count($selected_check);
		if($csc==0)		message_die(GENERAL_MESSAGE, 'Aucun jeu n\'est sélectionné', '', __LINE__, __FILE__, $sql);
		for($i = 0; $i < $csc; $i++)
		{
			if ($i != 0) $select_id_sql .= ', ';
			$select_id_sql .=  $selected_check[$i];
		}
		if ($deplacer != '0')
		{
			$action = 'deplacer';
		}else{
			$action =  $selection;
		}
	}
					
	// --------------------------------------------------------------------------------------------
	//  DIFFERENTES ACTIONS effectuées
	//
	switch ($action)
	{
		case 'monter':
				// A-t'on demandé de déplacer un jeu ?
				$jeux->monter_jeu($game_id,$arcade_catid,'+');
				break;
		case 'descendre':
				// A-t'on demandé de déplacer un jeu ?
				$jeux->monter_jeu($game_id,$arcade_catid,'-');
				break;
		case 'editsave':
				// on met à jour la fiche du jeu
				
				if (!$jeux->editsave_jeu($game_name,$game_desc,$game_pic,$game_pic_large,$game_scorevar,$game_swf,$game_width,$game_height,$game_type,$arcade_catid,$game_id,$last_catid,$cheater))
				{
					$message = $lang['Games_updated'] . '<br /><br />' ;
					$message .= sprintf($lang['Click_return_gameadmin'], '<a href="' . append_sid('arcade_elmt.'.$phpEx.'?arcade_catid='.$last_catid) . '">', '</a><br /><br />');
					$message .= sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid($phpbb_root_path.'admin/index.'.$phpEx.'?pane=right') . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
					exit;
				}
				break;
		
		case 'deplacer':
				// déplacer dans une autre catégorie les jeux séléctionnés
				if(!$jeux->deplacer_jeu($deplacer,$select_id_sql))
				{
					$message = $lang['Games_updated'] . '<br /><br />' ;
					$message .= sprintf($lang['Click_return_gameadmin'], '<a href="' . append_sid('arcade_elmt.'.$phpEx.'?arcade_catid='.$arcade_catid).'">', '</a><br /><br />');
					$message .= sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid($phpbb_root_path.'index.'.$phpEx.'?pane=right') . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
				}else{
					$message = $lang['Games_updated'] . '<br /><br />' ;
					$message .= sprintf($lang['Click_return_gameadmin'], '<a href="' . append_sid('admin_arcade_jeux.'.$phpEx).'">', '</a><br /><br />');
					$message .= sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid($phpbb_root_path.'admin/index.'.$phpEx.'?pane=right') . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
				}
				break;
		case 'Z':
				// mettre les scores à 0
				if(!$jeux->resetscore_jeu($select_id_sql))
				{
					$message = $lang['Games_updated'] . '<br /><br />' ;
					$message .= sprintf($lang['Click_return_gameadmin'], '<a href="' . append_sid('arcade_elmt.'.$phpEx.'?arcade_catid='.$arcade_catid).'">', '</a><br /><br />');
					$message .= sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid($phpbb_root_path.'admin/index.'.$phpEx.'?pane=right') . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
				}
				break;

		case 'S':
				// Supprmier le jeu
				if(!$jeux->suppr_jeu($select_id_sql,$arcade_catid,$csc))
				{
					$message = $lang['Games_updated'] . "<br /><br />" ;
					$message .= sprintf($lang['Click_return_gameadmin'], '<a href="'. append_sid('arcade_elmt.'.$phpEx.'?arcade_catid='.$arcade_catid).'">', '</a><br /><br />');
					$message .= sprintf($lang['Click_return_admin_index'], '<a href="'. append_sid($phpbb_root_path.'admin/index.'.$phpEx.'?pane=right') . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
				}
				break;

		case 'Y':
				// Resynchronisation des parties
				if(!$jeux->synchro_jeu($select_id_sql))
				{
					$message = $lang['Games_updated'] . "<br /><br />" ;
					$message .= sprintf($lang['Click_return_gameadmin'], '<a href="' . append_sid('arcade_elmt.'.$phpEx.'?arcade_catid='.$arcade_catid).'">', '</a><br /><br />');
					$message .= sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid($phpbb_root_path.'admin/index.'.$phpEx.'?pane=right') . '">','</a>');
					message_die(GENERAL_MESSAGE, $message);
				}
				break;
				
				
		case 'edit':
				// On a demandé à éditer une fiche de jeu
				$l_title = $lang['Edit_game'];
				$newmode = 'editsave';

				// récupération des infos existantes
				$sql = 'SELECT * 
						FROM ' . AREABB_GAMES_TABLE . ' 
						WHERE game_id = \''.$game_id.'\' 
						ORDER BY game_order ASC';
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Impossible d'acceder à la tables des jeux", '', __LINE__, __FILE__, $sql); 
				}

				if( !($row = $db->sql_fetchrow($result)) )
				{
					message_die(GENERAL_ERROR, 'Aucun jeu ne correspond à cet ID ('.$game_id.')'); 
				}
				$arcade_catid	= $row['arcade_catid'];
				$game_name		= $row['game_libelle'];
				$game_desc		= $row['game_desc'];
				$game_pic		= $row['game_pic'];
				$game_pic_large	= $row['game_pic_large'];
				$game_swf		= $row['game_swf'];
				$game_width		= $row['game_width']; 
				$game_height	= $row['game_height']; 
				$game_scorevar	= $row['game_scorevar'];

				// Cheater tracker est activé ?				
				$s_cheater_yes = ( $row['game_cheat_control'] == 1) ? 'checked' : '';
				$s_cheater_no = ( $row['game_cheat_control'] == 0) ? 'checked' : '';


				// Création d'un menu déroulant des différentes types
				$liste_type= '';
				for ($i=0;$i<=4;$i++)
				{
					if ( $row['game_type']== $i )
					{
						$liste_type .= '<option value="'.$i.'" selected="selected">Type '.$i.'</option>';
					}else{
						$liste_type .= '<option value="'.$i.'">Type '.$i.'</option>';
					}
				}
				
				// Récupération de la liste des catégories
				// afin de créer un menu déroulant
				$sql = 'SELECT arcade_cattitle, arcade_catid 
						FROM ' . AREABB_CATEGORIES_TABLE . ' 
						ORDER BY arcade_cattitle ASC';
				if( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Impossible d'acceder à la liste des catégories", '', __LINE__, __FILE__, $sql); 
				}
				$liste_cat = '';
				while ( $row = $db->sql_fetchrow($result))
				{
				  $selected = ( $row['arcade_catid'] == $arcade_catid ) ? ' selected="selected"' : '' ;
				  $liste_cat .= '<option value="' . $row['arcade_catid'] . '" '.$selected.' >';
				  $liste_cat .= stripslashes($row['arcade_cattitle']) . "</option>\n";
				}


				$hidden_fields  = '<input type="hidden" name="action" value="editsave" />';
				$hidden_fields .= '<input type="hidden" name="game_id" value="'.$game_id.'" />';
				$hidden_fields .= '<input type="hidden" name="last_catid" value="'.$arcade_catid.'" />';


				$template->set_filenames(array(
					'body' => 'areabb/mods/games/tpl/admin_edit_games.tpl'
				));

			  $template->assign_vars(array(
				'L_EDIT_GAME'				=> $l_title,
				'L_EDIT_GAME_EXPLAIN'		=> $lang['Edit_game_explain'],
				'L_GAME_SETTINGS'			=> $lang['Game_settings'],
				'L_GAME_NAME'				=> $lang['Game_name'],
				'L_GAME_NAME_EXPLAIN'		=> $lang['Game_name_explain'],
				'L_DESCRIPTION'				=> $lang['Game_description'],
				'L_DESCRIPTION_EXPLAIN'		=> $lang['Game_description_explain'],
				'L_VIGNETTE'				=> $lang['Game_thumbail'],
				'L_VIGNETTE_EXPLAIN'		=> $lang['Game_thumbail_explain'],
				'L_VIGNETTE_LARGE'			=> $lang['L_VIGNETTE_LARGE'],
				'L_VIGNETTE_LARGE_EXPLAIN'	=> $lang['L_VIGNETTE_LARGE_EXPLAIN'],
				'L_SWF'						=> $lang['Game_swf'],
				'L_SWF_EXPLAIN'				=> $lang['Game_swf_explain'],
	        	'L_WIDTH'					=> $lang['Game_width'], 
	        	'L_WIDTH_EXPLAIN'			=> $lang['Game_width_explain'], 
	    	   	'L_HEIGHT'					=> $lang['Game_height'], 
		    	'L_HEIGHT_EXPLAIN'			=> $lang['Game_height_explain'],
				'L_CATEGORIE'				=> $lang['Game_category'],
				'L_CATEGORIE_EXPLAIN'		=> $lang['Game_category_explain'],
				'L_SCORE_SETTINGS'			=> $lang['Score_settings'],
				'L_SCORE_SETTINGS_EXPLAIN'	=> $lang['Score_settings_explain'],
				'L_SCOREVARIABLE'			=> $lang['Game_scorevariable'],
				'L_SCOREVARIABLE_EXPLAIN'	=> $lang['Game_scorevariable_explain'],
				'L_GESTION_SCORE'			=> $lang['Game_typescore'],
				'L_GESTION_SCORE_EXPLAIN'	=> $lang['Game_typescore_explain'],
				'L_SUBMIT'					=> $lang['Submit'],
				'L_CHEATER'					=> $lang['L_CHEATER'],
				'L_YES'						=> $lang['Yes'],
				'L_NO'						=> $lang['No'],
				'GAME_NAME'					=> $game_name,
				'GAME_DESCRIPTION'			=> $game_desc,
				'GAME_VIGNETTE'				=> $game_pic,
				'GAME_VIGNETTE_LARGE'		=> $game_pic_large,
				'GAME_SWF'					=> $game_swf,
	          	'GAME_WIDTH'				=> $game_width, 
	            'GAME_HEIGHT'				=> $game_height,
				'SCOREVARIABLE'				=> $game_scorevar,
				'LISTE_TYPE'				=> $liste_type,
				'S_ACTION'					=> append_sid('arcade_elmt.'.$phpEx),
				'S_MODE'					=> $newmode,
	         	'S_CATEGORIE'				=> $liste_cat,
				'S_HIDDEN_FIELDS'			=> $hidden_fields,
				's_cheater_no'				=> $s_cheater_no,
				's_cheater_yes'				=> $s_cheater_yes
			));

			  $template->pparse('body');
			 include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
			  break;
	}
}

// --------------------------------------------------------------------------------------------
// AFFICHAGE des jeux
//


$template->set_filenames(array(
		'body' => 'areabb/mods/games/tpl/arcade_manage_body.tpl'
));


// Menu déroulant des catégories
$sql = 'SELECT arcade_catid, arcade_cattitle 
		FROM '. AREABB_CATEGORIES_TABLE .' 
		ORDER BY arcade_catorder';
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d\'accéder à la tables des jeux", '', __LINE__, __FILE__, $sql); 
}
$liste_cat = '<option value="0">'.$lang['jeu_non_classe'].'</option>';
while( $row = $db->sql_fetchrow($result) )
{
	  $liste_cat .= '<option value="'.$row['arcade_catid'].'">'.stripslashes($row['arcade_cattitle']).'</option>';
}	

// recup de la liste des jeux de la catégorie sélectionnée
$sql = 'SELECT COUNT(s.score_game) as nbset,game_libelle,game_pic, g.game_id, game_order, g.game_name, g.game_highscore, g.game_set 
		FROM ' . AREABB_GAMES_TABLE . ' as g 
		LEFT JOIN ' . AREABB_SCORES_TABLE .' as s 
		ON s.game_id = g.game_id 
		WHERE g.arcade_catid = '.$arcade_catid.' 
		GROUP BY g.game_id ORDER BY g.game_order';

if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des jeux", '', __LINE__, __FILE__, $sql); 
}

$liste_jeux = array();
while( $row = $db->sql_fetchrow($result) )
{
  $liste_jeux[] = $row;
}

$cg = count($liste_jeux);

for( $i=0 ; $i<$cg; $i++)
{
	if ($liste_jeux[$i]['game_pic'] != '')
	$icone = '<img src="'.$games_root.$liste_jeux[$i]['game_name'].'/'.$liste_jeux[$i]['game_pic'].'" border="0" width="30">';
	else $icone ='';
	
	
	$template->assign_block_vars('ligne_jeu', array(
		'ICONE'			=> $icone,
		'TITRE_JEU'		=> $liste_jeux[$i]['game_libelle'],
		'NB_SETS'		=> $liste_jeux[$i]['game_set'],
		'NB_SCORES'		=> $liste_jeux[$i]['nbset'],
		'RECORD_JEU'	=> $liste_jeux[$i]['game_highscore'],
		'CHECK'			=> $liste_jeux[$i]['game_id'],
		'L_UP'			=> ( $i > 0) ? $lang['Up_arcade_cat'] . '<br />' : '',
		'L_DOWN'		=> ( $i < $cg-1 ) ? $lang['Down_arcade_cat'] : '',
		'U_UP'			=> ( $i > 0) ? append_sid('arcade_elmt.'.$phpEx.'?action=monter&amp;arcade_catid='.$arcade_catid.'&amp;game_id=' . $liste_jeux[ $i ]['game_id']) : '',
		'U_DOWN'		=> ( $i < $cg-1) ? append_sid('arcade_elmt.'.$phpEx.'?action=descendre&amp;arcade_catid='.$arcade_catid.'&amp;game_id=' . $liste_jeux[ $i ]['game_id']) : '',
		'U_EDIT'		=> append_sid('arcade_elmt.'.$phpEx.'?action=edit&amp;game_id=' . $liste_jeux[$i]['game_id'] )
	));
}

// On affiche la combo action a effectuer sur la sélection seulement s'il
// existe au moins un jeu dans la liste
if ( $cg>0 )
{
  $template->assign_block_vars('switch_liste_non_vide', array());
}

// on s'assure que les actions par checkbox soient bien considéré comme du massaction
$hidden_fields = '<input type="hidden" name="arcade_catid" value="'.$arcade_catid.'" />
<input type="hidden" name="action" value="massaction" />';


$template->assign_vars(array(
	'ADD_GAME'				=> $lang['Add_new'],
	'INITIAL_SCORE'			=> $lang['Initialize_score'],
	'DELETE_GAME'			=> $lang['Delete_game'],
	'SYNCHRO_GAME_SET'		=> $lang['Synchro_game_set'],
	'L_PATH_NEW_LOGO'		=> $lang['Path_new_logo'],
	'L_ACTION'				=> $lang['Action'],
	'L_EDIT'				=> $lang['Edit'],
	'L_DEPLACE'				=> $lang['Deplace'],
	'L_GAME'				=> $lang['Arcade_game'],
	'L_HIGHSCORE'			=> $lang['Arcade_highscore'],
	'L_MANAGE_GAME'			=> $lang['Manage_game'],
	'L_SETS'				=> $lang['Arcade_sets'],
	'L_SCORES'				=> $lang['Arcade_scores'],
	'L_FOR_GAME_SELECTION'	=> $lang['For_game_selection'],
	'L_MANAGE_GAME_EXPLAIN' => $lang['Manage_game_explain'],
	'ALL_CHECKED'			=> $lang['All_checked'],
	'NOTHING_CHECKED'		=> $lang['Nothing_checked'],
	'HIDDEN_FIELDS'			=> $hidden_fields,
	'DEPLACER'				=> $liste_cat,
	'L_DEPLACER'			=> $lang['L_DEPLACER'],
	'I_EDIT'				=> $phpbb_root_path .$images['icon_edit'],
	'I_SUPP'				=> $phpbb_root_path .$images['icon_delpost'],
	'I_UP'					=> $phpbb_root_path .$images['icon_areabb_up'],
	'I_DOWN'				=> $phpbb_root_path .$images['icon_areabb_down'],
));
$template->pparse('body');
include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
?>