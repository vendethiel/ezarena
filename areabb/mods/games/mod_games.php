<?php
/*********************************************************************
*		  mod_games.php
*
*  Commencé le vendredi 23 juin 2006 par Saint-Pere - www.yep-yop.com
*
*  Ce bloc charge le jeu flash
*  
*
**********************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

global $board_config,$lang,$gid,$phpEx,$partie,$root_extreme;
load_lang('arcade');

//chargement du template
$template->set_filenames(array(
   'games' => $root_extreme .'areabb/mods/games/tpl/games_body.tpl'
));

$partie->definir_partie();

// type de jeu à afficher 0/1/2/3/4
$template->assign_block_vars($partie->affichage,array());

$template->assign_vars(array(
	'SWF_GAME'		=> 'areabb/games/'.$partie->info_jeu['game_name'].'/'.$partie->info_jeu['game_swf'] ,
	'GAME_WIDTH'	=> $partie->info_jeu['game_width'] , 
	'GAME_HEIGHT'	=> $partie->info_jeu['game_height'] , 
	'L_GAME'		=> $partie->info_jeu['game_libelle'] ,
	'HIGHSCORE'		=> $partie->info_jeu['highscore'],
	'TITLE'			=> $partie->info_jeu['game_libelle'],
	'SCRIPT_PATH'	=> $partie->scriptpath ,	
	'SETTIME'		=> $partie->temps_depart,
	'GID'			=> $partie->gid ,
	'UIP'			=> '' ,
	'SID'			=> '',
	'GAMEHASH'		=> '',	
	'BBTITLE'		=> stripslashes($board_config['sitename']),
	'USER_NAME'		=> $userdata['username'],
	'L_TOP'			=> $lang['best_scores']

));

// On incrémente le compteur de parties
$partie->incremente_gameset();

$page_title = $lang['arcade_game'];

$template->assign_var_from_handle('games', 'games'); 
?>