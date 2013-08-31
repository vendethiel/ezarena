<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                             mod_podium_jeu.php
//
//   Commencé le : vendredi 23 juin 2006
//   Par  Saint-Pere
//
//--------------------------------------------------------------------------------------------------------------------------------------
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $lang,$partie;

$nbre_podium = 5;
load_lang('arcade');

//chargement du template
$template->set_filenames(array(
   'podium_jeu' => 'areabb/mods/podium_jeu/tpl/mod_podium_jeu.tpl'
));

$partie->recup_liste_scores($nbre_podium);

if (sizeof($partie->liste_score) > 0)
{
	$template->assign_block_vars('score',array());
	for ($i=0;$i<=$nbre_podium;$i++)
	{
		if ($partie->liste_score[$i]['username'] != '')
		{
			if ($partie->liste_score[$i]['username'] == $userdata['username']) $row = 'row2'; else $row='row1';
			
			$template->assign_block_vars('score.podium',array(
				'ROW'		=> $row,
				'POS'		=> $partie->liste_score[$i]['position'],
				'PSEUDO'	=> areabb_profile($partie->liste_score[$i]['user_id'],$partie->liste_score[$i]['username']),
				'AVATAR'	=> $partie->liste_score[$i]['avatar'],
				'SCORE'		=> $partie->liste_score[$i]['score']
			));
		}
	}

	$template->assign_vars(array(	
		'L_PODIUM'	=> $lang['L_PODIUM'],
		'L_SCORE'	=> $lang['L_SCORE']
	));
}

$template->assign_var_from_handle('podium_jeu', 'podium_jeu'); 

?>