<?php
/*********************************************************************
		  mod_liste_jeux_SP2.php

  Commencé le lundi 28 Août 2006 par Saint-Pere - www.yep-yop.com

   Affichage de la liste des jeux sous la forme de minis blocs avec une grosse vignette
   du jeu. C'est l'affichage actuel du site www.yep-yop.com

**********************************************************************/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $arcade_catid,$squelette,$lang,$HTTP_GET_VARS;
load_lang('arcade');

$start = 0;
$order = '';

if (isset($HTTP_GET_VARS['start']))
{
	$start = eregi_replace('[^0-9]','',$HTTP_GET_VARS['start']);
}
if (isset($HTTP_GET_VARS['order']))
{
	$order = eregi_replace('[^0-9]','',$HTTP_GET_VARS['order']);
}

$template->set_filenames(array(
      'arcade_liste_jeux_SP2' => 'areabb/mods/liste_jeux_SP2/tpl/arcade_liste_jeux_SP2.tpl'
));

//-------------------------------------------------------------------------------------
//		AFFICHAGE des JEUX
//	
load_function('class_liste_jeux');
$jeux = new liste_jeux();

// on trie l'ordre d'affichage des jeux
if (isset($order) && ($order != '')) $jeux->order_by($order); else $jeux->order_by($areabb['game_order']);

// Si une catégorie a été séléctionnée on affiche uniquement ses jeux
if (isset($arcade_catid))$jeux->cat_id = $arcade_catid;

// Si on désire limiter le nombre de jeux, ou la paginer
if (isset($start) && ($start != '')) $jeux-> definir_limites($start);


// On récupere les données sur les jeux en question
$jeux-> recup_infos_jeux($squelette->id_squelette);
$liste_jeux = $jeux->liste;


$nbjeux = sizeof($liste_jeux);
if ($nbjeux == 0) 
{
	// aucun jeu dans cette catégorie
	$template->assign_block_vars('no_game',array());
}else{

	$template->assign_block_vars('game',array());

	for ($i=0 ; $i<$nbjeux ; $i++)
	{
		// intialisation
		$gamepic= ''; $gameset = '0';$norecord = '';$highuser =	'';$imgfirst = '';$yourhighscore = 'N\A';

		//  mise en forme des données
		$gamename =	$liste_jeux[$i]['game_libelle'];
		$gamelink = $jeux->definir_lancement_jeu($liste_jeux[$i]['game_id'],$liste_jeux[$i]['game_width'],$liste_jeux[$i]['game_height']);
		$gamelink .=  $liste_jeux[$i]['game_libelle'] . '</a>';
		$icone_jeu = (file_exists('areabb/games/'.$liste_jeux[$i]['game_name'] .'/'.$liste_jeux[$i]['game_pic_large']))? $liste_jeux[$i]['game_pic_large']:$liste_jeux[$i]['game_pic'];

		if ($liste_jeux[$i]['game_pic'] != '')
		{				
			$gamepic	= $jeux->definir_lancement_jeu($liste_jeux[$i]['game_id'],$liste_jeux[$i]['game_width'],$liste_jeux[$i]['game_height']);
			$gamepic	.= '<img src="areabb/games/'.$liste_jeux[$i]['game_name'] .'/'.$icone_jeu;
			$gamepic	.= '" align="absmiddle" border="0" height="130" vspace="2" hspace="2" alt="' ;
			$gamepic	.= $liste_jeux[$i]['game_libelle'] . '"></a>';
		}
		if  ( $liste_jeux[$i]['game_set'] != '0'  )
		{
			$gameset =  $liste_jeux[$i]['game_set'];
		}
		$highscore = $liste_jeux[$i]['game_highscore'];
		if ($liste_jeux[$i]['score_game'] != '')
		{
			$yourhighscore = $liste_jeux[$i]['score_game'];
		}		
		if ( $liste_jeux[$i]['game_highscore'] == 0 )
		{
			$norecord = $lang['no_record'];
			$highscore  = '';
			$datehigh = '';
		}
		if ( $liste_jeux[$i]['game_highuser'] != 0 )
		{
			$highuser = '(' . areabb_profile($liste_jeux[$i]['user_id'],$liste_jeux[$i]['username']) . ')';
		}
		$gameid = $liste_jeux[$i]['game_id'];
		if ($liste_jeux[$i]['game_highdate'] != 0 )
		{
			$datehigh = create_date( $board_config['default_dateformat'] , $liste_jeux[$i]['game_highdate'] , $userdata['user_timezone'] );	
		}
		if ($liste_jeux[$row['arcade_catid']][$i]['score_date'] != 0)
		{
			$yourdatehigh = create_date( $board_config['default_dateformat'] , $liste_jeux[$row['arcade_catid']][$i]['score_date'] , $userdata['user_timezone'] );	
		}
		if ( $liste_jeux[$i]['game_highuser'] == $userdata['user_id'] )
		{
			$imgfirst = '&nbsp;&nbsp;<img src="areabb/images/couronne.gif" align="absmiddle">';
		}
		$gamedesc = stripslashes($liste_jeux[$i]['game_desc']);
		$note = $liste_jeux[$i]['note'].'/5';
		$template->assign_block_vars('game.gamerow',array(
			'NOTE'			=>$note,
			'GAMENAME'		=>$gamename,
			'GAMELINK'		=>$gamelink,
			'GAMEPIC'		=>$gamepic,
			'GAMESET'		=>$gameset,
			'HIGHSCORE'		=>$highscore,
			'YOURHIGHSCORE'	=>$yourhighscore,
			'NORECORD'		=>$norecord,
			'HIGHUSER'		=>$highuser,
			'GAMEID'		=>$gameid,
			'DATEHIGH'		=>$datehigh,
			'YOURDATEHIGH'	=>$yourdatehigh,
			'IMGFIRST'		=>$imgfirst,
			'GAMEDESC'		=>$gamedesc 
		 ));

	}
}

// On veut paginer nos pages ?
$jeux->pagination_jeux($start);

//On choisit l'apparance de la pagination
//il faut choisir entre les 3
// je me suis éclaté sur ces petites fonctions.. lol
//$jeux->pagination_classique();
//$jeux->pagination_google();
//$jeux->pagination_phpbb();

$template->assign_vars(array(
	'PAGINATION'	=>$jeux->pagination_classique(),
	'NO_GAME'		=> $lang['NO_GAME'],
	'CATTITLE'		=> stripslashes($jeux->titre_page),
	'L_GAME'		=> $lang['games'],
	'L_HIGHSCORE'	=> $lang['highscore'],
	'L_NOTE'		=> $lang['L_NOTE'],
	'L_YOURSCORE'	=> $lang['yourbestscore'],
	'L_DESC'		=> $lang['desc_game'],
	'L_ARCADE'		=> $lang['lib_arcade'],
	'L_ALLER_A'		=> $lang['L_ALLER_A'],
	'L_PARTIES'		=> $lang['game_actual_nbset']
));
	


$page_title = $jeux->titre_page;

$template->assign_var_from_handle('liste_jeux_SP2', 'arcade_liste_jeux_SP2');

?>