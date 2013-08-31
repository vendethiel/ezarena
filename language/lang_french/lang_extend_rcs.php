<?php
/**
*
* @package rank_color_system_mod [French]
* @version $Id: lang_extend_rcs.php,v 0.10 21/12/2006 09:48 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

/**
* description
*/
$lang['mod_rcs_title'] = 'Rank Color System';
$lang['mod_rcs_explain'] = 'Permet de cr&eacute;er et g&eacute;rer des rangs de couleurs au niveau des groupes et des utilisateurs qui seront affich&eacute;s sur l\'ensemble du forum, et ajoute &eacute;galement de nombreuses autres fonctionnalit&eacute;s.';

/**
* admin part
*/
if ( $lang_extend_admin )
{
	// versions check
	$lang['Versions'] = 'Versions';
	$lang['versions_check'] = 'V&eacute;rification de versions';
	$lang['versions_check_explain'] = 'Permet de v&eacute;rifier si la version de phpBB et celles d\'autres applications que vous utilisez actuellement sont &agrave; jour.';
	$lang['version_information'] = 'Informations de version';
	$lang['version_check'] = 'V&eacute;rifier les derni&egrave;res versions';
	$lang['version_current_info'] = 'Version actuellement install&eacute;e';
	$lang['version_stable_info'] = 'Derni&egrave;re version stable';
	$lang['version_not_stable'] = 'La version que vous utilisez actuellement n\'est pas &agrave; jour : veuillez mettre cette application &agrave; jour au moins jusqu\'&agrave; la derni&egrave;re version stable propos&eacute;e.';
	$lang['version_stable'] = 'La version que vous utilisez actuellement est &agrave; jour avec la derni&egrave;re version stable connue.';
	$lang['version_announcement'] = 'Veuillez lire l\'<a href="http://%s" target="_new">annonce</a> publi&eacute;e pour cette derni&egrave;re version avant de continuer la mise &agrave; jour, celle-ci peut contenir des informations utiles.';
	$lang['version_socket_error'] = 'Impossible d\'&eacute;tablir la connexion avec le serveur, l\'erreur rapport&eacute;e est :<br />%s.';
	$lang['version_socket_disabled'] = 'Impossible d\'utiliser les fonctions socket.';
	$lang['click_check_versions'] = '<p>Cliquez %sici%s pour v&eacute;rifier si la version de phpBB et celles d\'autres applications que vous utilisez actuellement sont &agrave; jour.</p>';

	// acp menu
	$lang['Color_Ranks'] = 'Rangs de couleur';
	$lang['rcs_a_settings'] = 'Configuration';
	$lang['rcs_b_manage'] = 'Gestion';

	// rcs settings part
	$lang['rcs_settings_title'] = 'Configuration du syst&egrave;me des rangs de couleurs';
	$lang['rcs_settings_title_desc'] = 'En utilisant ce formulaire, vous pouvez g&eacute;rer la configuration du syst&egrave;me des rangs de couleurs.';
	$lang['rcs_style_settings'] = 'Configuration du th&egrave;me';
	$lang['rcs_cache_settings'] = 'Configuration du cache';
	$lang['rcs_main_settings'] = 'Configuration g&eacute;n&eacute;rale';

	$lang['rcs_enable'] = 'Activer le syst&egrave;me des rangs de couleurs';
	$lang['rcs_enable_desc'] = 'Afficher les couleurs des utilisateurs et des groupes sur l\'ensemble du forum.';
	$lang['rcs_ranks_stats'] = 'Rangs de couleur';
	$lang['rcs_ranks_stats_desc'] = 'Afficher les rangs de couleur dans la l&eacute;gende sur l\'index du forum.';
	$lang['rcs_level_ranks'] = 'Rangs de niveau';
	$lang['rcs_level_ranks_desc'] = 'Afficher les rangs de niveau dans la l&eacute;gende sur l\'index du forum.';
	$lang['rcs_level_admin'] = 'Administrateur';
	$lang['rcs_level_mod'] = 'Mod&eacute;rateur';

	$lang['rcs_select_style'] = 'S&eacute;lectionner le th&egrave;me';
	$lang['rcs_admincolor'] = 'Couleur du groupe administrateur';
	$lang['rcs_modcolor'] = 'Couleur du groupe mod&eacute;rateur';
	$lang['rcs_usercolor'] = 'Couleur du groupe utilisateur';

	$lang['rcs_cache_regen'] = 'R&eacute;g&eacute;n&eacute;rer le cache';
	$lang['rcs_cache_last_generation'] = 'Derni&egrave;re r&eacute;g&eacute;n&eacute;ration';
	$lang['rcs_cache'] = 'Activer le cache du syst&egrave;me des rangs de couleurs';

	// rcs management part
	$lang['rcs_manage_title'] = 'Gestion du syst&egrave;me des rangs de couleur';
	$lang['rcs_manage_title_desc'] = 'Vous pouvez ici &eacute;diter, supprimer, cr&eacute;er et trier les rangs de couleur.';
	$lang['rcs_add_title'] = 'Ajouter un nouveau rang de couleur';
	$lang['rcs_add_title_desc'] = 'Vous pouvez ici d&eacute;finir les champs du nouveau rang de couleur.';
	$lang['rcs_edit_title'] = 'Edition du rang de couleur <span%s>%s</span>';
	$lang['rcs_edit_title_desc'] = 'Vous pouvez ici modifier les champs du rang de couleur s&eacute;lectionn&eacute;.';

	$lang['rcs_name'] = 'Nom du rang';
	$lang['rcs_name_desc'] = 'Vous pouvez utiliser une cl&eacute; du tableau $lang[] (cf. language/lang_<i>votre_langue</i>/lang_*.php), ou entrer le nom en clair.';
	$lang['rcs_color'] = 'Couleur du rang';
	$lang['rcs_color_desc'] = 'S&eacute;lectionnez une valeur dans le <i>color picker</i>, ou entrer la manuellement (sans #). Laisser vide pour utiliser une classe CSS nomm&eacute;e comme le rang.';
	$lang['rcs_single'] = 'Rang individuel';
	$lang['rcs_single_desc'] = 'ce rang ne pourra &ecirc;tre attribu&eacute; qu\'&agrave; des utilisateurs.';
	$lang['rcs_display'] = 'Afficher le rang';
	$lang['rcs_display_desc'] = 'Afficher le rang sur l\'index du forum.';
	$lang['rcs_move_after'] = 'Positionner ce rang apr&egrave;s';

	$lang['rcs_pick_color'] = 'S&eacute;lectionner une couleur';

	// actions
	$lang['rcs_updated'] = 'Le rang a &eacute;t&eacute; mis &agrave; jour avec succ&egrave;s.';
	$lang['rcs_added'] = 'Le rang a &eacute;t&eacute; ajout&eacute; avec succ&egrave;s.';
	$lang['rcs_removed'] = 'Le rang a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s.';
	$lang['rcs_order_updated'] = 'Le positionnement du rang a &eacute;t&eacute; mis &agrave; jour avec succ&egrave;s.';
	$lang['rcs_confirm_delete'] = '&Ecirc;tes-vous sûr de vouloir supprimer ce rang ?';
	$lang['rcs_confirm_delete_selected'] = '&Ecirc;tes-vous sûr de vouloir supprimer les rangs s&eacute;lectionn&eacute;s ?';

	$lang['rcs_setup_updated'] = 'La configuration du syst&egrave;me des rangs de couleur a &eacute;t&eacute; mise &agrave; jour.';
	$lang['rcs_cache_succeed'] = 'La mise en cache du syst&egrave;me des rangs de couleur a abouti.';
	$lang['rcs_cache_failed'] = 'La mise en cache du syst&egrave;me des rangs de couleur a &eacute;chou&eacute;. Le cache a &eacute;t&eacute; d&eacute;sactiv&eacute;.';
	$lang['rcs_cache_disabled'] = 'Le cache est d&eacute;sactiv&eacute;. Activez le avant de le r&eacute;g&eacute;n&eacute;rer.';
	$lang['rcs_style_updated'] = 'Les couleurs des groupes de niveau ont &eacute;t&eacute; mise &agrave; jour avec succ&egrave;s.';

	$lang['rcs_click_return'] = 'Cliquez %sici%s pour revenir &agrave; la page pr&eacute;c&eacute;dente.';
	$lang['rcs_click_return_settings'] = 'Cliquez %sici%s pour retourner &agrave; la configuration du syst&egrave;me des rangs de couleur.';
	$lang['rcs_click_return_manage'] = 'Cliquez %sici%s pour retourner &agrave; la gestion du syst&egrave;me des rangs de couleur.';

	// errors
	$lang['rcs_not_exists'] = 'Ce rang n\'existe pas.';
	$lang['rcs_must_select'] = 'Vous devez s&eacute;lectionner un rang.';
	$lang['rcs_must_fill'] = 'Vous devez remplir tous les champs.';
	$lang['rcs_no_valid_action'] = 'Cette action n\'est pas support&eacute;e.';
	$lang['rcs_no_ranks_create'] = 'Aucun rang n\'est disponible. Cliquez sur &quot;Cr&eacute;er&quot; pour en ajouter un.';

	// groups and users edition
	$lang['Top'] = '___ D&eacute;but ___';
	$lang['rcs_select_rank'] = 'S&eacute;lectionner un rang de couleur';
}

/**
* group control panel
*/

// usergroups selection
$lang['usergroups_list'] = 'Liste des groupes d\'utilisateurs';
$lang['select_usergroup'] = 'S&eacute;lectionner un groupe d\'utilisateurs';
$lang['select_usergroup_details'] = 's&eacute;lectionner un groupe d\'utilisateurs pour en voir les informations.';

/**
* userlist
*/

// display
$lang['userlist'] = 'Liste des utilisateurs';
$lang['click_return_userlist'] = 'Cliquez %sici%s pour retourner &agrave; la liste des utilisateurs.';
$lang['no_members_match'] = 'Aucun membre ne correspond &agrave; ce crit&egrave;re de recherche';

// usergroups
$lang['groups'] = 'Groupes d\'utilisateurs';
$lang['group_is_open'] = 'Ceci est un groupe ouvert';
$lang['group_is_hidden'] = 'Ceci est un groupe invisible';
$lang['group_is_closed'] = 'Ceci est un groupe ferm&eacute;';

$lang['change_default_group'] = 'Changer le groupe par d&eacute;faut';
$lang['changed_default_group'] = 'Le groupe par d&eacute;faut a &eacute;t&eacute; chang&eacute; avec succ&egrave;s pour tous les membres s&eacute;lectionn&eacute;s.';
$lang['already_default_group'] = 'Ce groupe est d&eacute;j&agrave; le groupe par d&eacute;faut pour tous les membres s&eacute;lectionn&eacute;s.';
$lang['click_return_usergroup'] = 'Cliquez %sici%s pour retourner aux informations du groupe.';

// leaders
$lang['the_team'] = 'Equipe du forum';
$lang['moderate_forums'] = 'Forums mod&eacute;r&eacute;s';
$lang['primary_group'] = 'Groupe primaire';

$lang['all_forums'] = 'Tous les forums';
$lang['forum_undisclosed'] = 'Forum(s) invisible(s)';
$lang['group_undisclosed'] = 'Groupe invisible';

$lang['Administrators'] = 'Administrateurs';
$lang['Moderators'] = 'Mod&eacute;rateurs';
$lang['no_administrators'] = 'Aucuns administrateurs assign&eacute;s sur ce forum.';
$lang['no_moderators'] = 'Aucuns moderateurs assign&eacute;s sur ce forum.';

// viewprofile
$lang['user_statistics'] = 'Statistiques';

$lang['rcs_rank'] = 'Rang de couleur';
$lang['post_pct_active'] = '%.2f%% de ses messages';
$lang['active_in_forum'] = 'Forum le plus actif';
$lang['active_in_topic'] = 'Sujet le plus actif';

$lang['change_individual_rank'] = 'Changer le rang individuel';
$lang['changed_individual_rank'] = 'Le rang de couleur individuel a &eacute;t&eacute; chang&eacute; avec succ&egrave;s pour l\'utilisateur s&eacute;lectionn&eacute;.';
$lang['removed_individual_rank'] = 'Le rang de couleur individuel a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s pour l\'utilisateur s&eacute;lectionn&eacute;.';
$lang['click_return_viewprofile'] = 'Cliquez %sici%s pour retourner au profil de cet utilisateur.';

// count
$lang['users_count'] = '[%d utilisateurs]';
$lang['users_count_1'] = '[%d utilisateur]';
$lang['posts_count'] = '[%d messages]';
$lang['posts_count_1'] = '[%d message]';
$lang['user_posts'] = '%d messages';
$lang['user_posts_1'] = '%d message';

// visited
$lang['Visited'] = 'Derni&egrave;re visite';
$lang['Hidden_last_visit'] = 'Indisponible';
$lang['Never_last_visit'] = 'Aucune';

// errors
$lang['no_users_selected'] = 'Vous n\'avez s&eacute;lectionn&eacute; aucun utilisateur.';
$lang['option_assigned_user'] = 'L\'option s&eacute;lectionn&eacute;e est d&eacute;j&agrave; assign&eacute;e &agrave; cet utilisateur.';
$lang['not_admin_of_board'] = 'L\'op&eacute;ration demand&eacute;e n\'a pu &ecirc;tre effectu&eacute;e car vous n\'&ecirc;tes pas un administrateur du forum.';

/**
* legend
*/

// display
$lang['Legend'] = 'L&eacute;gende';
$lang['Administrator'] = 'Administrateur';
$lang['Moderator'] = 'Mod&eacute;rateur';
$lang['User'] = 'Utilisateur';

?>