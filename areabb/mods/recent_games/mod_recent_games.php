<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                             mod_recent_games.php
//
//    par Saint-Pere
//--------------------------------------------------------------------------------------------------------------------------------------

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $lang;
load_lang('arcade');
load_function('class_liste_jeux');
$recent = new liste_jeux();

$limit = 10;
//chargement du template
$template->set_filenames(array(
   'recent_games' => 'areabb/mods/recent_games/tpl/mod_recent_games.tpl'
));

$sql = 'SELECT game_id ,game_name, game_pic,game_width,game_height, game_libelle,game_date 
		FROM '.AREABB_GAMES_TABLE.' 
		ORDER BY game_date DESC
		LIMIT 0,'.$limit;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d\'acceder à la tables des jeux", '', __LINE__, __FILE__, $sql); 
}
while ($row = $db->sql_fetchrow($result))
{
	$template->assign_block_vars('jeux_recents_installes',array(
		'ICONE' => CHEMIN_JEU.$row['game_name'].'/'.$row['game_pic'],
		'LIEN'	=> $recent->definir_lancement_jeu($row['game_id'],$row['game_width'],$row['game_height']),
		'TITRE'	=> $row['game_libelle'],
		'DATE'	=> date("d/m/Y",$row['game_date'])
	));
}


//template
$template->assign_vars( array(
	'L_RECENT_GAMES'	=> $lang['L_RECENT_GAMES'],
	'L_DATE_AJOUT'		=> $lang['L_DATE_AJOUT']
));

$template->assign_var_from_handle('recent_games', 'recent_games');

?>