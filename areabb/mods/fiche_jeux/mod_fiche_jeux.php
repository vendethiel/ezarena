<?php
/*********************************************************************
*		  mode_fiche_jeux.php
*
*  Commencé le 24 juin 2006 par Saint-Pere - www.yep-yop.com
*
*  Ce bloc affiche toutes les informations de "la carte d'identité" d'un jeu
*  Ce mod va donc être ammené à évoluer constamment en fonction des options 
*  activées sur l'arcade
*
**********************************************************************/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $partie,$userdata,$lang,$HTTP_GET_VARS,$areabb,$images;

load_function('fonctions_chaine');
load_lang('arcade');

//chargement du template
$template->set_filenames(array(
   'fiche_jeux' => 'areabb/mods/fiche_jeux/tpl/mod_fiche_jeux.tpl'
));

// On a  le droit de télécharger les jeux ?
if ($areabb['auth_dwld'])
{
	// On lance le téléchargement
	$download = $partie->scriptpath. 'areabb/dl.php?jeu_pkg_gz='.$partie->gid;
	$download_zip = $partie->scriptpath. 'areabb/dl.php?jeu_zip='.$partie->gid;
}else{
	$download = '';
	$download_zip = '';
}

// Anti-Triche activé ? 
if ($partie->info_jeu['game_cheat_control'] == 1) $triche = $lang['active']; else $triche = $lang['pas_active'];

// On a voté !
if (isset($HTTP_GET_VARS['note']))
{
	$note =  eregi_replace('[^0-9]','',$HTTP_GET_VARS['note']);
	if (($note <= 5) ||($note >= 0))
	{
		$partie->ajoute_note($note,$userdata['user_id']);
	}
}

// Ce joueur a-t-il déjà voté ?
$sql = 'SELECT note 
		FROM '.AREABB_NOTE.'
		WHERE user_id='.$userdata['user_id'].'
		AND game_id='.$partie->gid;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d\'acceder à la tables des notes", '', __LINE__, __FILE__, $sql); 
}
if (!$row = $db->sql_fetchrow($result))
{
	$noter  = '<a href="'.append_sid(NOM_GAME.'.'.$phpEx.'?gid='.$partie->gid.'&note=0').'"><img src="areabb/images/vote/0.gif" border="0" width="20"></a>';
	$noter .= '<a href="'.append_sid(NOM_GAME.'.'.$phpEx.'?gid='.$partie->gid.'&note=1').'"><img src="areabb/images/vote/1.gif" border="0" width="20"></a>';
	$noter .= '<a href="'.append_sid(NOM_GAME.'.'.$phpEx.'?gid='.$partie->gid.'&note=2').'"><img src="areabb/images/vote/2.gif" border="0" width="20"></a>';
	$noter .= '<a href="'.append_sid(NOM_GAME.'.'.$phpEx.'?gid='.$partie->gid.'&note=3').'"><img src="areabb/images/vote/3.gif" border="0" width="20"></a>';
	$noter .= '<a href="'.append_sid(NOM_GAME.'.'.$phpEx.'?gid='.$partie->gid.'&note=4').'"><img src="areabb/images/vote/4.gif" border="0" width="20"></a>';
	$noter .= '<a href="'.append_sid(NOM_GAME.'.'.$phpEx.'?gid='.$partie->gid.'&note=5').'"><img src="areabb/images/vote/5.gif" border="0" width="20"></a>';
	
	$template->assign_block_vars('noter',array(
		'L_NOTER'	=> $lang['L_NOTER'],
		'NOTER'		=> $noter
	));
}
$icone_jeu = (file_exists('areabb/games/'.$partie->info_jeu['game_name'] .'/'.$partie->info_jeu['game_pic_large']))? $partie->info_jeu['game_pic_large']:$partie->info_jeu['game_pic'];
$template->assign_vars(array(	
	'NOM'			=> $partie->info_jeu['game_libelle'],
	'DATE'			=> MySQLDateToExplicitDate(timestamp_to_gmd($partie->info_jeu['game_date'])),
	'PARTIES'		=> $partie->info_jeu['game_set'],
	'DESC'			=> $partie->info_jeu['game_desc'],
	'ICONE'			=> 'areabb/games/'.$partie->info_jeu['game_name'].'/'.$icone_jeu ,
	'TRICHE'		=> $triche,
	'NOTE'			=> $partie->info_jeu['note'].'/5',
	'L_NOTE'		=> $lang['L_NOTE'],
	'L_NOM_JEU'		=> $lang['L_NOM_JEU'],
	'L_DATE_AJOUT'	=> $lang['L_DATE_AJOUT'],
	'NBRE_PARTIES'	=> $lang['NBRE_PARTIES'],
	'DESC_JEU'		=> $lang['DESC_JEU'],
	'L_TRICHE'		=> $lang['L_TRICHE'],
	'I_TELECHARGER'	=> $phpbb_root_path .$images['icon_areabb_pkggz'],
	'I_TELECHARGER_ZIP'	=> $phpbb_root_path .$images['icon_areabb_zip'],
	'DOWNLOAD'		=> $download,
	'DOWNLOAD_ZIP'	=> $download_zip
));

if ($areabb['auth_dwld'])
{
	$template->assign_block_vars('download',array());
}

$template->assign_var_from_handle('fiche_jeux', 'fiche_jeux'); 

?>