<?php
/***************************************************************************
*                                mod_aleatoire.php
*
* Adapté par Polo - www.supernova.2010.info
*
* Ce bloc permet de se faire un jeu aléatoire en un seul click
*  
***************************************************************************/

define('IN_PHPBB', true);

global $squelette,$lang,$db,$phpEx;

$template->set_filenames(array(
   'aleatoire' => 'areabb/mods/aleatoire/tpl/mod_aleatoire.tpl'
));

load_function('class_liste_jeux');
load_function('class_jeux');
load_lang('arcade');

$jeu_aleatoire = new liste_jeux();
$jeu_aleatoire->order_by('Random');
$jeu_aleatoire->cat_id = '';
$jeu_aleatoire->start = '3';
$jeu_aleatoire->recup_infos_jeux($squelette->id_squelette);
$liste_jeux = $jeu_aleatoire->liste;

$nbjeux = sizeof($liste_jeux);
if ($nbjeux == 0) 
{
$sql = 'SELECT game_id
  FROM ' . AREABB_GAMES_TABLE . ' ORDER BY rand() LIMIT 0,1';

if( !($result = $db->sql_query($sql)) )
 {
	 message_die(GENERAL_ERROR, "Impossible d'accéder à la tables arreabb_games", '', __LINE__, __FILE__, $sql); 
 } else {
   $row = $db->sql_fetchrow($result);
   $game_id = $row['game_id'];
 }
   $image = '<img src="areabb/mods/aleatoire/images/aleatoire.gif" alt="' . $lang['aleatoire_game'] . '" title="' . $lang['aleatoire_game'] . '" />';

   $template->assign_block_vars('games',array(
	   'ALEATOIRE'	=> '<a href="' . append_sid(NOM_GAME.'.'.$phpEx.'?gid=' . $game_id ).'" alt="' . $lang['aleatoire_game'] . '" title="' . $lang['aleatoire_game'] . '">'.$image.'</a>'
	   ));
 } else {
 for ($i=0 ; $i<$nbjeux ; $i++)
 {
 if ($liste_jeux[$i]['game_pic'] != '')
 {				
	 $game_pic	= $jeu_aleatoire->definir_lancement_jeu($liste_jeux[$i]['game_id'],$liste_jeux[$i]['game_width'],$liste_jeux[$i]['game_height']);
	 $game_pic	.= "<img src='areabb/games/".$liste_jeux[$i]['game_name'] ."/".$liste_jeux[$i]['game_pic'];
	 $game_pic	.= "' align='left' valign='middle' border='0' width='40' height='40' vspace='1' hspace='1' alt=".$liste_jeux[$i]['game_libelle'] ." title=".$liste_jeux[$i]['game_libelle'] ."'" ;
	 $game_pic	.= $liste_jeux[$i]['game_libelle'] . "' ></a>";
 }
   
   $game_name	= $jeu_aleatoire->definir_lancement_jeu($liste_jeux[$i]['game_id'],$liste_jeux[$i]['game_width'],$liste_jeux[$i]['game_height']);
   $game_name	.= "<span class='cattitle' alt=".$liste_jeux[$i]['game_libelle'] ." title=".$liste_jeux[$i]['game_libelle'] .">".$liste_jeux[$i]['game_libelle'] ."</span></a>";

	 $template->assign_block_vars('arcade',array(
     'GAME_LINK'	=> $game_name,
     'GAME_PIC'	=> $game_pic
		 ));
   }
}
	
$template->assign_vars(array(
		'L_TITRE'	=> $lang['aleatoire_game'],
	  'NO_GAME'		=> $lang['NO_GAME']
		));

$template->assign_var_from_handle('aleatoire', 'aleatoire');

?>