<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                             mod_classement_jeu.php
//
//   Commencé le   :  samedi 24 juin 2006
//   Par  Liz@rd
//
//--------------------------------------------------------------------------------------------------------------------------------------

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $partie,$lang;

$top = 15;
load_lang('arcade');

//chargement du template
$template->set_filenames(array(
   'classement_jeu' => 'areabb/mods/classement_jeu/tpl/mod_classement_jeu.tpl'
));

load_function('class_jeux');
$partie->recup_liste_scores($top);

for ($i=0;$i<$top;$i++)
{
	if ($partie->liste_score[$i]['username'] != '')
	{
		if ($partie->liste_score[$i]['username'] == $userdata['username']) $row = 'row2'; else $row='row1';
		
		$template->assign_block_vars('classement',array(
			'ROW'			=> $row,
			'USERNAME'		=> areabb_profile($partie->liste_score[$i]['user_id'],$partie->liste_score[$i]['username']),
			'SCORE'			=> $partie->liste_score[$i]['score'],
			'POSITION'		=> $partie->liste_score[$i]['position']
		));
	}
}

//template
$template->assign_vars( array(
   	'L_BEST_SCORE' => $lang['best_scores']
));

$template->assign_var_from_handle('classement_jeu', 'classement_jeu');

?>