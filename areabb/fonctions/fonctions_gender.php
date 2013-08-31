<?php
// -------------------------------------------------------------------------
//
//				fonctions_gender.php
//
//	Chargement des données sur le mod Gender
// -------------------------------------------------------------------------
if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}
//
// On parse la requete

function parse_gender($sql)
{
	return str_replace('u.user_id', 'u.user_id, u.user_gender', $sql);
}


//
// Fonction de formatage du pseudo

function formate_gender($username,$user_id)
{
	global $lang, $images,$info_user;
	switch ($info_user[$user_id]['user_gender']) 
	{ 
		case 1 : 
			$gender_image = '<img src="' . $images['icon_minigender_male'] . '" alt="' . $lang['Gender'].  ':'.$lang['Male'].'" title="' . $lang['Gender'] . ':'.$lang['Male']. '" border="0" />'; 
			break; 
		case 2 : 
			$gender_image = '<img src="' . $images['icon_minigender_female'] . '" alt="' . $lang['Gender']. ':'.$lang['Female']. '" title="' . $lang['Gender'] . ':'.$lang['Female']. '" border="0" />'; 
			break; 
		default : $gender_image = ''; 
	}
	
	return $username.' '.$gender_image;
}



?>