<?php
/****************************************************
	mod_switcharcade.php

Ce mod affiche la liste des salles d'Arcade. On ne prend
pas en compte le droit de voir ou non cette salle.
****************************************************/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $lang;
load_lang('arcade');
$template->set_filenames(array(
      'switcharcade' => 'areabb/mods/switcharcade/tpl/mod_switcharcade.tpl'
));

$sql = 'SELECT id_squelette, titre 
	FROM '.AREABB_SQUELETTE.' 
	WHERE type=1 
	ORDER BY position ASC';
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain forum information', '', __LINE__, __FILE__, $sql);
}
while ($row = $db->sql_fetchrow($result))
{
	$template->assign_block_vars('salles_arcade', array(
		'NOM_SALLE'		=> stripslashes($row['titre']),
		'LIEN_SALLE'	=> append_sid(NOM_ARCADE.'.'.$phpEx.'?salle='.$row['id_squelette'])
	));
}


$template->assign_vars(array(	
	'L_TITRE_SWITCHEUR_ARCADE' => $lang['L_TITRE_SWITCHEUR_ARCADE']
));


$template->assign_var_from_handle('switcharcade', 'switcharcade');
?>