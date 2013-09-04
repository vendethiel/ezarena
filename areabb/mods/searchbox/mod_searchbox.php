<?php

/***************************************************************************
 *                                mod_searchbox.php
 *                            -------------------
 *  Par Saint-Pere www.yep-yop.com
 ***************************************************************************/
 
 
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $HTTP_POST_VARS;
load_lang('arcade');

// minimum de caractere pour effectuer une recherche
$min_char = 3;
$max_reponses = 30;

include_once( $phpbb_root_path . 'areabb/fonctions/class_liste_jeux.' . $phpEx);
$search = new liste_jeux();
$search ->game_popup == 1;


//chargement du template
$template->set_filenames(array(
   'searchbox' => 'areabb/mods/searchbox/tpl/mod_searchbox.tpl')
);

// on recherche
if (isset($HTTP_POST_VARS['recherche']))
{
	$mot_clef = $HTTP_POST_VARS['recherche'];

	$longueur_mot_clef= strlen($mot_clef);
	
	// si il  y a moins de 3 caracteres on cherche pas.. 
	if ($longueur_mot_clef < $min_char)
	{
		$template->assign_block_vars('trop_court',array(
			'COURT' => "Minimum ".$min_char." caractères"
		));
	}else{
		$sql = 'SELECT * FROM ' . AREABB_GAMES_TABLE . ' 
				WHERE game_desc LIKE \'%'.$mot_clef.'%\' 
				OR game_name LIKE \'%'.$mot_clef.'%\' 
				OR game_libelle LIKE \'%'.$mot_clef.'%\' 
				ORDER BY game_name';
		
		
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Impossible d\'accéder à la tables des catégories', '', __LINE__, __FILE__, $sql); 
		}
		$nbre_reponses = $db->sql_numrows($result);
		
		// aucun résultat
		if ($nbre_reponses != 0)
		{		
				$i = 0;
				while( $row = $db->sql_fetchrow($result))
				{	
					// On limite la casse en bloquant si il y a trop de réponses..
					
					$i++;
					if ($max_reponses <= $i) {break;}
					
					
					// tite image ....
					if ( $row['game_pic'] != '' )
					{
						$game_pic = $search->definir_lancement_jeu($row['game_id'],$row['game_width'],$row['game_height']);
						$game_pic .= '<img src="areabb/games/'.$row['game_name'].'/' .$row['game_pic'] . '"border="0" width="30" height="30"  alt="' . $row['game_libelle'] . '" ></a>';
					}else{
						$game_pic = '';
					}
					// un lien cliquable..
					$nom = $search->definir_lancement_jeu($row['game_id'],$row['game_width'],$row['game_height']).$row['game_libelle'].'</a>';
					
					
					$template->assign_block_vars('reponse',array(
						'NOMJEU' 		=> $nom,
						'IMAGEJEU' 		=> $game_pic
					));
				}
				$nbre_resultats = ($i == 1)? '':'s';
		}
		
		$template->assign_vars(array(
				'COMPTAGE' => $nbre_reponses.' résultat'.$nbre_resultats
		));
		
		
	}
}

$template->assign_vars(array(
		'TITRE_BLOC' => "SearchBOX",
		'L_RECHERCHER_JEU'	=> $lang['L_RECHERCHER_JEU']
));

$template->assign_var_from_handle('searchbox', 'searchbox');

?>