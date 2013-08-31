<?php
/***************************************************************************
 *                             admin_areabb.php
 *                            -------------------
 *   Commencé le mardi 10 juillet 2006
 *   Par Saint-Pere www.yep-yop.com
 *
 *   Cette page permet de régler les paramétrages globaux d'AreaBB
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);


if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['AreaBB']['Configurer'] = '../areabb/mods/config/'.$file;
	return;
}

//
// Let's set the root dir for phpBB
//
define('ROOT_STYLE','admin');
$phpbb_root_path = '../../../';
require($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
load_lang('admin');


// --------------------------------------------------------------------------------------------
// TRAITEMENT DES PARAMETRES
//
if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action = $HTTP_POST_VARS['action']; 
	}else{
		$action = $HTTP_GET_VARS['action'];
	}
	

	switch($action)
	{
		case 'enregistrer':
			// Enregistrement des modifications effectuées sur la config générale	
			$sql = 'SELECT * FROM ' . AREABB;
			if(!$result = $db->sql_query($sql))
			{
				message_die(CRITICAL_ERROR, "Could not query config information in admin_arcade", "", __LINE__, __FILE__, $sql);
			}
			while( $row = $db->sql_fetchrow($result) )
			{
				$nom = $row['nom'];
				$valeur = $row['valeur'];
				$defaut[$nom] = $valeur;
				
				$new[$nom] = ( isset($HTTP_POST_VARS[$nom]) ) ? $HTTP_POST_VARS[$nom] : $defaut[$nom];
		
				$sql = 'UPDATE ' . AREABB . ' 
					SET valeur = \'' . str_replace("\'", "''", $new[$nom]) . '\'
					WHERE nom = \''.$nom.'\'';
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Failed to update areabb configuration for '.$nom, '', __LINE__, __FILE__, $sql);
				}
			}
		break;
	}

}



// --------------------------------------------------------------------------------------------
// AFFICHAGE
//
$sql = 'SELECT * FROM ' . AREABB;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_arcade", "", __LINE__, __FILE__, $sql);
}
while( $row = $db->sql_fetchrow($result) )
{
	$new[$row['nom']]= $row['valeur'];	
}

// rcs ? 
$s_rcs_yes = ( $new['mod_rcs'] == 1) ? 'checked' : '';
$s_rcs_no = ( $new['mod_rcs'] == 0) ? 'checked' : '';
$desactive_rcs = (file_exists($phpbb_root_path.'includes/class_rcs.php'))? 'enabled':'disabled';
// gender ? 
$s_gender_yes = ( $new['mod_gender'] == 1) ? 'checked' : '';
$s_gender_no = ( $new['mod_gender'] == 0) ? 'checked' : '';
$sql = 'SHOW COLUMNS FROM '.USERS_TABLE;
if( ! $result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Impossible d'accéder aux stats de la table USERS", "", __LINE__, __FILE__, $sql);
}
unset($liste_colonnes);
while ( $row = $db->sql_fetchrow( $result ) )
{
	$liste_colonnes[] = $row['Field'];
}
$desactive_gender = (in_array('user_gender',$liste_colonnes))? 'enabled':'disabled';
// point system ? 
$s_point_system_yes = ( $new['mod_point_system'] == 1) ? 'checked' : '';
$s_point_system_no = ( $new['mod_point_system'] == 0) ? 'checked' : '';
$desactive_point = ($board_config['points_system_version'] != '')? 'enabled':'disabled';
// nombre de topics recents
$nbre_topics_recents = ( $new['nbre_topics_recents'] == '') ? '10' : $new['nbre_topics_recents'];
// On autorise le téléchargement d'extensions ?
$autorise_extension_yes = ( $new['autorise_extension'] == 1) ? 'checked' : '';
$autorise_extension_no = ( $new['autorise_extension'] == 0) ? 'checked' : '';
// chemin de stockages des archives des Extensions
$chemin_extension = ( $new['chemin_extension'] == '') ? 'areabb/mods/' : $new['chemin_extension'];
// Faire défiler les topics récents? 
$defiler_topics_recents_yes = ( $new['defiler_topics_recents'] == 1) ? 'checked' : '';
$defiler_topics_recents_no = ( $new['defiler_topics_recents'] == 0) ? 'checked' : '';
// sondage à afficher sur le portail ?
$sql = 'SELECT vote_text,t.topic_id FROM ' . TOPICS_TABLE	 . ' AS t, ' . VOTE_DESC_TABLE  . ' AS vd
		WHERE  t.topic_status <> 1 AND
		t.topic_status <> 2 AND t.topic_vote = 1 AND t.topic_id = vd.topic_id
		ORDER BY t.topic_time DESC ' ;

if( ! $result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Impossible d'accéder aux sondages", "", __LINE__, __FILE__, $sql);
}
$liste_poll = '' ;
while ( $row = $db->sql_fetchrow( $result ) )
{
	$selected = ( $new['id_sondage'] == $row['topic_id'] ) ? 'selected' : '' ;	
	$libelle_sondage = ( strlen($row['vote_text']) > 50 ) ? substr( $row['vote_text'], 0, 47 ) . '...' : $row['vote_text'] ;
	$liste_poll .= '<option value="' . $row['topic_id'] . '" '.$selected.' >'. $libelle_sondage . '</option>' ;
}

// Utiliser les popup pour le profile ?
$mod_profile_yes = ( $new['mod_profile'] == 1) ? 'checked' : '';
$mod_profile_no = ( $new['mod_profile'] == 0) ? 'checked' : '';
				

$template->set_filenames(array(
	'body' => 'areabb/mods/config/tpl/areabb_config.tpl'
));


$template->assign_vars(array(
	'L_YES'						=> $lang['Yes'],
	'L_NO'						=> $lang['No'],
	'L_CONFIGURATION_TITLE'		=> $lang['L_CONFIGURATION_TITLE'],
	'L_CONFIGURATION_EXPLAIN'	=> $lang['L_CONFIGURATION_EXPLAIN'],
	'L_GENERAL_SETTINGS'		=> $lang['L_GENERAL_SETTINGS'],
	'L_GAMES_AREA_SETTINGS'		=> $lang['games_area_settings'],
	'l_mod_rcs'					=> $lang['l_mod_rcs'],
	'mod_rcs_yes'				=> $s_rcs_yes,
	'mod_rcs_no'				=> $s_rcs_no,
	'l_mod_gender'				=> $lang['l_mod_gender'],
	'mod_gender_yes'			=> $s_gender_yes,
	'mod_gender_no'				=> $s_gender_no,
	'l_mod_point_system'		=> $lang['l_mod_point_system'],
	'mod_point_system_yes'		=> $s_point_system_yes,
	'mod_point_system_no'		=> $s_point_system_no,
	'LAST_SEEN'					=> $new['last_seen'],
	'L_SUBMIT'					=> $lang['Submit'], 
	'L_RESET'					=> $lang['Reset'],
	'nbre_topics_recents'		=> $nbre_topics_recents,
	'l_nbre_topics_recents'		=> $lang['l_nbre_topics_recents'],
	'defiler_topics_recents_yes'=> $defiler_topics_recents_yes ,
	'defiler_topics_recents_no'	=> $defiler_topics_recents_no,
	'defiler_topics_recents'	=> $lang['defiler_topics_recents'],
	'liste_poll'				=> $liste_poll,
	'l_sondage'					=> $lang['l_sondage'],
	'mod_profile_yes'			=> $mod_profile_yes,
	'mod_profile_no'			=> $mod_profile_no,
	'l_popup_prodile'			=> $lang['l_popup_prodile'],
	'l_chemin_extension'		=> $lang['l_chemin_extension'],
	'chemin_extension'			=> $chemin_extension,
	'l_autorise_extension'		=> $lang['autorise_extension'],
	'autorise_extension_yes'	=> $autorise_extension_yes,
	'autorise_extension_no'		=> $autorise_extension_no,
	'desactive_gender'			=> $desactive_gender,
	'desactive_rcs'				=> $desactive_rcs,
	'desactive_point'			=> $desactive_point
));

// Génération de la page

$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>