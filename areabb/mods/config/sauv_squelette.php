<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                              sauv_squelette.php
//
//   Commencé le   :  lundi 12 juin 2006
//   Par  Saint-Pere
//
//--------------------------------------------------------------------------------------------------------------------------------------


define('IN_PHPBB', true);
$phpbb_root_path = '../../../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ADMIN_AREABB);
init_userprefs($userdata);
//
// End session management
//
// Start auth check
//
if (( !$userdata['session_logged_in']) OR ($userdata['user_level'] != ADMIN))
{
	$header_location = ( @preg_match("/Microsoft|WebSTAR|Xitami/", getenv("SERVER_SOFTWARE")) ) ? "Refresh: 0; URL=" : "Location: ";
	header($header_location . append_sid("../login.$phpEx?redirect=admin/", true));
	exit;
}
//
// End of auth check
//

$id_squelette =  eregi_replace('[^0-9]','',$HTTP_GET_VARS['id_squelette']);
$contenu = $HTTP_GET_VARS['contenu'];
// On récupere les différentes boites: 
$mods  = explode(";",$contenu );

$count_mod = count($mods);
for ($i=0;$i<$count_mod;$i++)
{
	if (!eregi('allItems', $mods[$i]))
	{
		$box = array();
		$box  = explode("|",$mods[$i]);
		
		// id_bloc[  numéro de l'id du bloc dans la BD ] = id du mod dans la base de données
		// modele : 
		// mod_XX donne le numéro du mod
		// box_XX donne l'ID d'un emplacement
		
		// On teste l'id du mod pour voir si il s'agit d'un bloc HTML
		// modele:
		// HTML_XX
		if (ereg('HTML_',$box[1]))
		{
			// Bloc HTML ..
			$id_bloc[str_replace('box_','',$box[0])] = str_replace('HTML_','',$box[1]);
			$type[str_replace('box_','',$box[0])] = 'HTML';
		}else{
			// BLOC PHP
			$id_bloc[str_replace('box_','',$box[0])] = str_replace('mod_','',$box[1]);
			$type[str_replace('box_','',$box[0])] = 'PHP';
		}
	}
}

// on récupere la liste des blocs de ce squelette
$sql = 'SELECT id_bloc, id_mod   
		FROM '. AREABB_FEUILLE .' as f LEFT JOIN '. AREABB_BLOCS .' as b 
		ON f.id_feuille=b.id_feuille 
		WHERE id_squelette='.$id_squelette;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d'afficher la liste des blocs", '', __LINE__, __FILE__, $sql); 
}
$listes_mods = array();
while ($row = $db->sql_fetchrow($result))
{

	if ($id_bloc[$row['id_bloc']] == '')
	{
		$id_bloc[$row['id_bloc']] = 0;
		$type[$row['id_bloc']] = '';
	}
	// On enregistre maintenant les résultats
	$sql = 'UPDATE '. AREABB_BLOCS .' 
			SET id_mod='.$id_bloc[$row['id_bloc']].' ,
			type_mod=\''.$type[$row['id_bloc']].'\' 
			WHERE id_bloc='.$row['id_bloc'].' 
			LIMIT 1';
	if( !($resultat = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible de mettre à jours les blocs", '', __LINE__, __FILE__, $sql); 
	}
}
load_function('class_squelette');
$squelette = new generation_squelette($phpbb_root_path);
$squelette->id_squelette = $id_squelette;

if (!$squelette->ecrire_cache_squelette()) message_die(GENERAL_ERROR, "Impossible d'écrire le cache") ;

// On signale que tout c'est bien passé
echo 'OK';
?>