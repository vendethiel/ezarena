<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//					games.php
//
//   Commencé le   :  Mardi 20 juin 2006
//   Par Saint-Pere 
//
//--------------------------------------------------------------------------------------------------------------------------------------

define('IN_PHPBB', true);
define('ROOT_STYLE','page');
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
load_function('functions_arcade');
load_lang('main');
load_lang('arcade');

//
// Start session management
//

$userdata = session_pagestart($user_ip, PAGE_GAME);
init_userprefs($userdata);


//
// Vérification des groupes d'accès autorisés à accéder à cette salle

if (!verification_acces_page($areabb['games_par_defaut']))
{
	$message = $lang['salle_interdite'] . '<br /><br />' ;
	$message .=	sprintf($lang['Click_return_areabb'], '<a href="' . append_sid(NOM_ARCADE.'.'.$phpEx) . '">', '</a>') ;
	message_die(GENERAL_MESSAGE,$message);
	exit;
}


// Si on récupere un score on charge proarcade.php
if(isset($HTTP_GET_VARS['act']) || isset($HTTP_POST_VARS['act'])|| isset($HTTP_POST_VARS['sessdo'])  || isset($HTTP_GET_VARS['do']) || isset($HTTP_POST_VARS['do']))
{ 
	$sessdo = $HTTP_POST_VARS['sessdo'];
	// hack pour les types 3
	if ($sessdo != '')
	{
		switch($sessdo)
		{
			case 'sessionstart' :
				echo '&connStatus=1&gametime=123456&initbar=toto|toto&lastid=1&val=x';
				exit;
			case 'permrequest' :
			  	$microone = $HTTP_POST_VARS['score'] . '|toto';
				echo '&validate=1&microone='.$microone.'&val=x';
				exit;
			case 'burn' :
				$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";
				$tbinfos = explode('|',$HTTP_POST_VARS['microone']);
				$newhash = substr( $tbinfos[2] , 24 , 8 ) . substr( $tbinfos[2] , 0 , 24 ) ;
				header($header_location . append_sid('proarcade.'.$phpEx.'?' . $userdata['areabb_variable']. '=' . $tbinfos[0] . '&gid='.$userdata['areabb_gid'].'&newhash='.$newhash.'&hashoffset=8&settime='.$userdata['areabb_tps_depart'].'&gpaver=GFARV2', true));
				exit;
		}
	}
	include_once($phpbb_root_path.'proarcade.php');
	exit;
}


// ---------------------------------------------------------------------------------------------
// CONFIGURATION
//

// Un jeu as-t-il été choisis ? 
if ((isset($HTTP_GET_VARS['gid'])) || (isset($HTTP_POST_VARS['gid'])))
{
	if (isset($HTTP_GET_VARS['gid']))
	{
		$gid = eregi_replace('[^0-9]','',$HTTP_GET_VARS['gid']);
	}else{
		$gid = eregi_replace('[^0-9]','',$HTTP_POST_VARS['gid']);
	}
}else{
	message_die(GENERAL_ERROR, "Aucun jeu n'a été séléctionné.", ''); 
}

load_function('class_jeux');
$partie = new jeux();
$partie->gid = $gid;
$partie->recup_infos();

// Affichage complet
if ($areabb['game_popup'] != 1)
{

		//-------------------------------------------------------------------------------------
		//		AFFICHAGE du SQUELETTE
		//
		load_function('class_squelette');
		unset($squelette);
		$squelette = new generation_squelette($phpbb_root_path);

		$squelette->id_squelette = $areabb['games_par_defaut'];

		
		// On récupere dans le cache les infos à afficher
		$squelette->lire_cache_squelette();

		// on teste la présence ou non du template demandé
		if (!file_exists($phpbb_root_path.'areabb/cache/squelette_'.$squelette->id_squelette.'.tpl'))
		{
			message_die(GENERAL_ERROR, "Vous devez aller dans l'ACP créer une salle afin de visualiser votre portail");
		}
		$template->set_filenames(array(
		   	'body' =>  'areabb/cache/squelette_'.$squelette->id_squelette.'.tpl'
		));

		// on assemble les mods dans le squelette			
		$squelette->fusionner_bloc_mod();

		$template->assign_vars(array(
			'SQUELETTE'		=> $squelette->squelette
		));

		$page_title = stripslashes($partie->info_jeu['game_libelle']); 
		define('SHOW_ONLINE', true);
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);	
		$template->pparse('body');
		include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

}else{

		//-------------------------------------------------------------------------------------
		//		AFFICHAGE du POPUP
		//

		//chargement du template
		$template->set_filenames(array(
		   'body' => 'areabb/mods/games/tpl/games_pop_body.tpl'
		));
		
		$partie->definir_partie();

		// type de jeu à afficher
		$template->assign_block_vars($partie->affichage,array());

		// On envoit nos données dans le templates.
		$template->assign_vars(array(
			'SWF_GAME'		=> 'areabb/games/'.$partie->info_jeu['game_name'].'/'.$partie->info_jeu['game_swf'] ,
			'CSS'			=> $phpbb_root_path . '/templates/' . $theme['template_name'] .'/'. $theme['template_name'] .'.css',
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
		//
		// Output page header
		$page_title = $lang['arcade_game'];

		$template->pparse('body');

}

?>