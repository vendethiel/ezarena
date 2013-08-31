<?php
//--------------------------------------------------------------------------------------------
//                              arcade.php
//
//   Commencé le   :  mercredi 24 Mai 2006
//   Par  Saint-Pere
//
//--------------------------------------------------------------------------------------------

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
$userdata = session_pagestart($user_ip, PAGE_ARCADES);
init_userprefs($userdata);
//
// End session management

// une catégorie a été sélectionnée ? 
if (isset($HTTP_GET_VARS['cid']))
{
	$arcade_catid = eregi_replace('[^0-9]','',$HTTP_GET_VARS['cid']);
}
// Si on a selectionné une salle d'arcade en particulier ...
$id_squelette =(isset($HTTP_GET_VARS['salle'])) ? eregi_replace('[^0-9]','',$HTTP_GET_VARS['salle']): $areabb['arcade_par_defaut'];

//
// Vérification des groupes d'accès autorisés à accéder à cette salle

if (!verification_acces_page($id_squelette))
{
	$message = $lang['salle_interdite'] . '<br /><br />' ;
	$message .=	sprintf($lang['Click_return_arcade'], '<a href="' . append_sid(NOM_ARCADE.'.'.$phpEx) . '">', '</a>') ;
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






//-------------------------------------------------------------------------------------
//		AFFICHAGE du SQUELETTE
//
define('SHOW_ONLINE', true);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);	

load_function('class_squelette');
unset($squelette);
$squelette = new generation_squelette($phpbb_root_path);

// définit notre squelette de travail.
$squelette->id_squelette = $id_squelette;

// On récupere dans le cache les infos à afficher
$squelette->lire_cache_squelette();


// on teste la présence ou non du template demandé
if (!file_exists($phpbb_root_path . 'areabb/cache/squelette_'.$squelette->id_squelette.'.tpl'))
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


$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>