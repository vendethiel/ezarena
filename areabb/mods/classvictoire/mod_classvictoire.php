<?php
/********************************************************
	mod_classvictoire.php


*********************************************************/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $lang;

load_lang('arcade');

$limite_victoires = 20;

//chargement du template
$template->set_filenames(array(
   'classvictoire' =>'areabb/mods/classvictoire/tpl/mod_classvictoire.tpl'
));

$sql = 'SELECT game_highuser , COUNT(game_highscore) as victoires , username 
	FROM ' . AREABB_GAMES_TABLE . ' as g LEFT JOIN ' . USERS_TABLE . ' as u 
	ON g.game_highuser = u.user_id 
	WHERE game_highscore != 0
	GROUP BY game_highuser 
	ORDER BY victoires DESC
	LIMIT '.$limite_victoires;
if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not query recent topics information', '', __LINE__, __FILE__, $sql);
}
$i = 0;
$victoire = -9999;
while ($row = $db->sql_fetchrow($result))
{
	if ($row['victoires'] != $victoire)
	{
		// Les égalités sont sur la même place
		$i++;
	}
	$class =  ($userdata['user_id'] == $row['game_highuser'])? 'row1' : 'row2';
	$template->assign_block_vars('victoires', array(
		'USER'		=> areabb_profile($row['game_highuser'],$row['username']),
		'VICTOIRES'	=> $row['victoires'],
		'PLACE'		=> $i,
		'CLASS'		=> $class
	));
	$victoire = $row['victoires'];
}
$template->assign_vars(array(
	'L_TOP_VICTOIRES'	=> $lang['L_TOP_VICTOIRES'],
	'L_PLACE'			=> $lang['L_PLACE'],
	'L_JOUEUR'			=> $lang['L_JOUEUR'],
	'L_VICTOIRES'		=> $lang['L_VICTOIRES']
));

$template->assign_var_from_handle('classvictoire', 'classvictoire');

?>