<?php

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $userdata,$lang;
load_lang('arcade');

if (file_exists('areabb/cache/statsjeux.tpl'))
{
	//chargement du template
	$template->set_filenames(array(
	   'statsjeux' => 'areabb/cache/statsjeux.tpl'
	));

	// Si le user a déjà soumis un score son fichier perso doit exister
	if (file_exists('areabb/cache/statsjeux_'.$userdata['user_id'].'.tpl'))
	{
		//chargement du template
		$template->set_filenames(array(
		   'statsarcade_perso' => 'areabb/cache/statsjeux_'.$userdata['user_id'].'.tpl'
		));

		// Perso
		$template->assign_vars(array(
			'L_INFO_PERSO'			=> $lang['L_INFO_PERSO'],
			'NBRE_VICTOIRES'		=> $lang['NBRE_VICTOIRES'],
			'TPS_TOTAL_JOUE'		=> $lang['TPS_TOTAL_JOUE'],
			'NBRE_PARTIES_JOUEES'	=> $lang['NBRE_PARTIES_JOUEES']
		));
		$template->assign_var_from_handle('STATS_ARCADE_PERSO', 'statsarcade_perso');
	}


	// Public
	$template->assign_vars(array(
		'L_INFO_GENERALES'	=> $lang['L_INFO_GENERALES'],
		'L_INFO_TOPJOUEUR'	=> $lang['L_INFO_TOPJOUEUR'],
		'NBRE_JEUX'			=> $lang['NBRE_JEUX'],
		'TOTAL_PARTIES'		=> $lang['TOTAL_PARTIES'],
		'NBRE_JOUEURS'		=> $lang['NBRE_JOUEURS'],
		'TPS_TOTAL'			=> $lang['TPS_TOTAL'],
		'TOP_VICTOIRES'		=> $lang['TOP_VICTOIRES'],
		'TOP_TPS'			=> $lang['TOP_TPS'],
		'TOP_PARTIES'		=> $lang['TOP_PARTIES']
	));	

	$template->assign_var_from_handle('statsjeux', 'statsjeux');
}
?>