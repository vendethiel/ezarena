<?php
/***************************************************************************
 *                             admin_arcade.php
 *                            -------------------
 *   Commencé le mardi 10 juillet 2006
 *   Par Saint-Pere www.yep-yop.com
 *
 *   Cette page permet de régler les paramétrages globaux de l'arcade
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);


if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['AreaBB Arcade']['Configurer'] = '../areabb/mods/games/'.$file;
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
load_lang('admin_arcade');

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

// tri des jeux
$s_alpha	= ( $new['game_order'] == 'Alpha' ) ? 'selected' : '';
$s_popular	= ( $new['game_order'] == 'Popular' ) ? 'selected' : '';
$s_fixed	= ( $new['game_order'] == 'Fixed') ? 'selected' : '';
$s_random	= ( $new['game_order'] == 'Random') ? 'selected' : '';
$s_news		= ( $new['game_order'] == 'News') ? 'selected' : '';
$s_order  = '<option value="Alpha" '.$s_alpha.' >' . $lang['game_order_alpha'] . "</option>\n";
$s_order .= '<option value="Popular" '.$s_popular.' >' . $lang['game_order_popular'] . "</option>\n";
$s_order .= '<option value="Fixed" '.$s_fixed.' >' . $lang['game_order_fixed'] . "</option>\n";
$s_order .= '<option value="Random" '.$s_random.' >' . $lang['game_order_random'] . "</option>\n";
$s_order .= '<option value="News" '.$s_news.' >' . $lang['game_order_news'] . "</option>\n";
// mod d'ouverture
$s_ouv_portail = ( $new['game_popup'] == '0') ? 'selected' : '';
$s_ouv_popup = ( $new['game_popup'] == '1') ? 'selected' : '';
// type de pagination
$s_pag_norm = ( $new['format_pag'] == '0') ? 'selected' : '';
$s_pag_google = ( $new['format_pag'] == '1') ? 'selected' : '';
$s_pag_phpbb = ( $new['format_pag'] == '2') ? 'selected' : '';
// autoriser le download ?
$s_auth_dwld_yes = ( $new['auth_dwld'] == 1) ? 'checked' : '';
$s_auth_dwld_no = ( $new['auth_dwld'] == 0) ? 'checked' : '';
// tolerence anti triche
$s_time_tolerence = ( $new['games_time_tolerance'] == '') ? '10' : $new['games_time_tolerance'];
// utiliser des VIP ? 
$s_group_vip_yes = ( $new['group_vip'] == 1) ? 'checked' : '';
$s_group_vip_no = ( $new['group_vip'] == 0) ? 'checked' : '';
// Id du groupe VIP 
$sql = 'SELECT group_id , group_name 
	FROM '. GROUPS_TABLE .' 
	WHERE group_single_user != 1 OR   	
	group_name = "Admin"
	ORDER BY group_name';

if(!$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Failed to update areabb configuration for '.$arcade_name, '', __LINE__, __FILE__, $sql);
}
$s_nom_group_vip = '';
while( $row = $db->sql_fetchrow($result) )
{
	if ($row['group_id'] == $new['nom_group_vip']) $selected = 'selected'; else $selected = '';
	$s_nom_group_vip .= '<option value="'.$row['group_id'].'" '.$selected.'>'.$row['group_name']."</option>\n";
}
// Faut poster pour jouer ?
$s_avoir_poste_joue_yes = ( $new['avoir_poste_joue'] == 1) ? 'checked' : '';
$s_avoir_poste_joue_no = ( $new['avoir_poste_joue'] == 0) ? 'checked' : '';
// nombre de topics minimum
$s_nbre_topics_min = ( $new['nbre_topics_min'] == '') ? 0 : $new['nbre_topics_min'];
// se présenter pour jouer ?
$s_presente_yes = ( $new['presente'] == 1) ? 'checked' : '';
$s_presente_no = ( $new['presente'] == 0) ? 'checked' : '';
// quel est le forum de présentation ? 
$sql = 'SELECT forum_id, forum_name 
		FROM '. FORUMS_TABLE .' 
		ORDER BY forum_order ASC';
if(!$result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, 'Failed to update areabb configuration for '.$arcade_name, '', __LINE__, __FILE__, $sql);
}
$s_forum_presente = '';
while( $row = $db->sql_fetchrow($result) )
{
	if ($row['forum_id'] == $new['forum_presente']) $selected = 'selected'; else $selected= '';
	$s_forum_presente .= '<option value="'.$row['forum_id'].'" '.$selected.'>'.$row['forum_name']."</option>\n";
}				
// autorisez vous les images devant els cétégories ?
$s_affichage_icone_yes = ( $new['affichage_icone'] == 1) ? 'checked' : '';
$s_affichage_icone_no = ( $new['affichage_icone'] == 0) ? 'checked' : '';
// autorisez vous les nombre de jeux ? 				
$s_affichage_nbre_jeux_yes = ( $new['affichage_nbre_jeux'] == 1) ? 'checked' : '';
$s_affichage_nbre_jeux_no = ( $new['affichage_nbre_jeux'] == 0) ? 'checked' : '';
	
// repertoire où sauvegarder les jeux
$chemin_pkg_jeux = 	( $new['chemin_pkg_jeux'] == '') ? CHEMIN_JEU : $new['chemin_pkg_jeux'];
				
$template->set_filenames(array(
	'body' => 'areabb/mods/games/tpl/arcade_config_body.tpl'
));


$template->assign_vars(array(
	'L_YES'						=> $lang['Yes'],
	'L_NO'						=> $lang['No'],
	'L_CONFIGURATION_TITLE_ARCADE'		=> $lang['L_CONFIGURATION_TITLE_ARCADE'],
	'L_CONFIGURATION_EXPLAIN_ARCADE'	=> $lang['L_CONFIGURATION_EXPLAIN_ARCADE'],
	'L_GENERAL_SETTINGS'		=> $lang['L_GENERAL_SETTINGS'],
	'L_GAMES_AREA_SETTINGS'		=> $lang['games_area_settings'],
	'L_GAMES_PAR_PAGE'			=> $lang['games_par_page'],
	'L_GAMES_PAR_PAGE_EXPLAIN'	=> $lang['games_par_page_explain'],
	'L_GAME_ORDER'				=> $lang['games_order'],
	'L_GAME_ORDER_EXPLAIN'		=> $lang['games_order_explain'],
	'l_mod_ouvert'				=> $lang['l_mod_ouvert'],
	'ouv_portail'				=> $s_ouv_portail,
	'ouv_popup'					=> $s_ouv_popup,
	'l_format_pag'				=> $lang['l_format_pag'],
	'pag_norm'					=> $s_pag_norm,
	'pag_google'				=> $s_pag_google,
	'pag_phpbb'					=> $s_pag_phpbb,
	'l_aut_dwld'				=> $lang['l_aut_dwld'],
	'aut_dwld_yes'				=> $s_auth_dwld_yes,
	'aut_dwld_no'				=> $s_auth_dwld_no,
	'l_icone_cat'				=> $lang['l_icone_cat'],
	'affichage_icone_yes'		=> $s_affichage_icone_yes,
	'affichage_icone_no'		=> $s_affichage_icone_no,
	'l_nbre_jeu_cat'			=> $lang['l_nbre_jeu_cat'],
	'affichage_nbre_jeux_yes'	=> $s_affichage_nbre_jeux_yes,
	'affichage_nbre_jeux_no'	=> $s_affichage_nbre_jeux_no,
	'l_time_tolerence'			=> $lang['l_time_tolerence'],
	'time_tolerence'			=> $s_time_tolerence,
	'l_group_vip'				=> $lang['l_group_vip'],
	'group_vip_yes'				=> $s_group_vip_yes,
	'group_vip_no'				=> $s_group_vip_no,
	'l_nom_group_vip'			=> $lang['l_nom_group_vip'],
	'nom_group_vip'				=> $s_nom_group_vip,
	'l_avoir_poste_joue'		=> $lang['l_avoir_poste_joue'],
	'avoir_poste_joue_yes'		=> $s_avoir_poste_joue_yes,
	'avoir_poste_joue_no'		=> $s_avoir_poste_joue_no,
	'l_nbre_topics_min'			=> $lang['l_nbre_topics_min'],
	'nbre_topics_min'			=> $s_nbre_topics_min,
	'l_presente'				=> $lang['l_presente'],
	'presente_yes'				=> $s_presente_yes,
	'presente_no'				=> $s_presente_no,
	'l_forum_presente'			=> $lang['l_forum_presente'],
	'forum_presente'			=> $s_forum_presente,
	'l_popup'					=> $lang['l_popup'],
	'l_portail'					=> $lang['l_portail'],
	'l_normal'					=> $lang['l_normal'],
	'l_google'					=> $lang['l_google'],
	'l_phpbb'					=> $lang['l_phpbb'],
	'l_securite'				=> $lang['l_securite'],
	'S_CATEGORY_PREVIEW_GAMES'	=> intval($new['category_preview_games']),
	'S_GAMES_PAR_PAGE'			=> intval($new['games_par_page']),
	'S_STAT_PAR_PAGE'			=> intval($new['stat_par_page']),
	'chemin_pkg_jeux'			=> $chemin_pkg_jeux,
	'L_CHEMIN_JEUX'				=> $lang['L_CHEMIN_JEUX'],
	'S_GAME_ORDER'				=> $s_order,
	'LAST_SEEN'					=> $new['last_seen'],
	'L_SUBMIT'					=> $lang['Submit'], 
	'L_RESET'					=> $lang['Reset']
));

// Génération de la page

$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>