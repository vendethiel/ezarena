<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                             mod_downloads_games.php
//
//    par Saint-Pere
//--------------------------------------------------------------------------------------------------------------------------------------

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $lang,$images,$phpbb_root_path ;
load_lang('arcade');

$limit = 15;
//chargement du template
$template->set_filenames(array(
   'download_games' => 'areabb/mods/download_games/tpl/mod_download_games.tpl'
));

$sql = 'SELECT game_id ,game_name, game_pic, game_libelle, game_date, clics_pkg, clics_zip
		FROM '.AREABB_GAMES_TABLE.' 
		ORDER BY game_date DESC';
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d\'acceder à la tables des jeux", '', __LINE__, __FILE__, $sql); 
}
$jeux_telecharges = array();
while ($row = $db->sql_fetchrow($result))
{
	$jeux_telecharges[] = $row;
} 
// Affichage des jeux récents

for ($i=0;$i<10;$i++)
{
	$template->assign_block_vars('jeux_recents',array(
		'ICONE' => 'areabb/games/'.$jeux_telecharges [$i]['game_name'].'/'.$jeux_telecharges [$i]['game_pic'],
		'TITRE'	=> $jeux_telecharges [$i]['game_libelle'],
		'PKG'	=> $jeux_telecharges [$i]['clics_pkg'],
		'ZIP'	=> $jeux_telecharges [$i]['clics_zip'],
		'L_PKG'	=> append_sid('areabb/dl.'.$phpEx.'?jeu_pkg_gz='.$jeux_telecharges [$i]['game_id']),
		'L_ZIP'	=> append_sid('areabb/dl.'.$phpEx.'?jeu_zip='.$jeux_telecharges [$i]['game_id'])
	));
}


//template
$template->assign_vars( array(
	'I_TELECHARGER'	=> $phpbb_root_path .$images['icon_areabb_pkggz'],
	'I_TELECHARGER_ZIP'	=> $phpbb_root_path .$images['icon_areabb_zip'],
	'L_DOWNLOADS_GAMES'	=> $lang['L_DOWNLOADS_GAMES']
));

$template->assign_var_from_handle('download_games', 'download_games');

?>