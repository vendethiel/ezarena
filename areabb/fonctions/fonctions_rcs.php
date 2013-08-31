<?php
// -------------------------------------------------------------------------
//
//				fonctions_rcs.php
//
//	Chargement des données sur RCS
// -------------------------------------------------------------------------
if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

//
// On parse la requete

function parse_rcs($sql)
{
	return str_replace('u.user_id', 'u.user_id, u.user_level, u.user_color, u.user_group_id', $sql);
}

//
// Fonction de formatage du pseudo

function formate_rcs($username,$user_id)
{
	global $info_user,$rcs;
	$style_color = $rcs->get_colors($info_user[$user_id]);
	return '<span '.$style_color.'>'.$username.'</span>';
}	
?>