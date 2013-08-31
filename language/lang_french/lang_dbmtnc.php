<?php

/***************************************************************************
 *                            lang_dbmtnc.php [French]
 *                              -------------------
 *   begin                : Fri Feb 07, 2003
 *   copyright            : (C) 2003 Philipp Kordowich
 *                          Parts: (C) 2002 The phpBB Group
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/


//
// Language file for DB Maintenance Mod
//

$lang['DB_Maintenance'] = 'Maintenance de la DB';
$lang['DB_Maintenance_Description'] = 'Ici vous pouvez vérifier que votre base de données ne contient pas de données incohérentes, ni d\'erreurs.<br /><br /> <b>Attention :</b> Certaines opérations nécessitent du temps pour s\'effectuer. Votre forum sera <b>désactivé</b> durant ces opérations. Faites-les donc de préférence durant la nuit.</br /> <br /><font color=red><b>Il est fortement recommandé de sauvegarder votre base de données avant d\'utiliser l\'une des fonctions listées ci-dessous !</b></color>';
$lang['Function'] = 'Fonction';
$lang['Function_Description'] = 'Description';

$lang['Incomplete_configuration'] = 'Une option pour <b>%s</b> n\'a pas été trouvée dans la configuration du forum. DB Maintenance ne peut pas fonctionner sans cette option.<br /> Vous avez peut-être oublié de faire les requêtes SQL décrites dans les instructions d\'installation';
$lang['dbtype_not_supported'] = 'Désolé, cette fonction n\'est pas supportée par votre base de données';
$lang['no_function_specified'] = 'Aucune fonction n\'a été spécifiée';
$lang['function_unknown'] = 'La fonction spécifiée est inconnue';
$lang['Old_MySQL_Version'] = 'Désolé, votre version de mysql ne supporte pas cette fonction. Veuillez utiliser la fonction 3.23.17 ou plus récente.';

$lang['Back_to_DB_Maintenance'] = 'Revenir à la maintenance de la base de données';
$lang['Processing_time'] = 'Cette opération prendra %f secondes';


$lang['Lock_db'] = '<font color=red>Désactivation du forum</color>';
$lang['Unlock_db'] = '<font color=green>Réactivation du forum</color>';
$lang['Already_locked'] = 'Le forum a déjà été désactivé';
$lang['Ignore_unlock_command'] = 'Le forum sera désactivé quand vous lancerez cette commande. Le forum ne sera pas réactivé';
$lang['Delay_info'] = 'Un délai de plusieurs secondes peut être nécessaire pour permettre aux actions réalisées sur votre base de données de se finaliser...';

$lang['Affected_row'] = 'Une donnée a été affectée';
$lang['Affected_rows'] = '%d données ont été affectées';
$lang['Done'] = 'Opération terminée';
// The following variable is used when nothing hat to be fixed in the database. It needs the complete paragraph-tag.
// If you do not want a message to be displayed in these cases, just leave the variable empty.
$lang['Nothing_to_do'] = "<p class=\"gen\"><i> &raquo;Rien à faire :o)</i></p>\n";

//
// Names for new records in several tables
//
$lang['New_cat_name'] = 'forums restaurés';
$lang['New_forum_name'] = 'Sujets restaurés';
$lang['New_topic_name'] = 'Messages restaurés';
$lang['Restored_topic_name'] = 'Sujet restauré';
$lang['New_poster_name'] = 'Message restauré'; // Name for Poster of a restored post

//
// Functions available
//
// Usage: $mtnc[] = array(internal Name, Name of Function, Description of Function, Warning Message (leef empty to avoid), Number of Check function (Integer))
// Use $mtnc[] = array('--', '', '', '', 0) for a space row (you can us a different check function)
//
$mtnc[] = array('statistic',
	'Statistiques',
	'Affiche des informations sur le forum et la base de données.',
	'',
	0);
$mtnc[] = array('config',
	'Configuration',
	'Autorise la configuration de DB Maintenance.',
	'',
	5);
$mtnc[] = array('--', '', '', '', 0);
$mtnc[] = array('check_user',
	'Vérifier les tables des utilisateurs et des groupes',
	'Cela va vérifier les tables des utilisateurs et des groupes qui pourraient contenir d\'éventuelles erreurs et restaurera les groupes d\'utilisateurs individuels manquants.',
	'Vous allez perdre tous les groupes qui n\'ont pas de membre en effectuant cette action. Continuer ?',
	0);
$mtnc[] = array('check_post',
	'Vérifier les tables des messages et des sujets',
	'Cela va vérifier les tables des messages et des sujets qui pourraient contenir d\'éventuelles erreurs.',
	'Vous allez perdre tous les messages qui n\'ont pas de texte. Continuer ?',
	0);
$mtnc[] = array('check_vote',
	'Vérifier les tables des sondages',
	'Cela va vérifier les tables des sondages qui pourraient contenir d\'éventuelles erreurs.',
	'Vous allez perdre toutes les données des sondages qui n\'ont pas de sondages correspondants. Continuer ?',
	0);
$mtnc[] = array('check_pm',
	'Vérifier les tables des messages privés',
	'Cela va vérifier les tables des messages privés qui pourraient contenir d\'éventuelles erreurs.',
	'Les messages non lus seront supprimés quand l\'émetteur ou le destinataire n\'existe pas. Continuer ?',
	0);
$mtnc[] = array('check_config',
	'Vérifier la table de configuration',
	'Cela vérifiera la table de configuration pour les entrées manquantes.',
	'',
	0);
$mtnc[] = array('--', '', '', '', 0);
$mtnc[] = array('check_search_wordmatch',
	'Vérifier la table identifiant les mots utilisés par la recherche',
	'Cela va vérifier la table identifiant les mots utilisés par la recherche qui pourrait contenir d\'éventuelles erreurs. Cette table est utilisée par la fonction recherche.',
	'',
	0);
$mtnc[] = array('check_search_wordlist',
	'Vérifier la table listant les mots utilisés par la recherche',
	'Cela va retirer tous les mots inutiles dans la liste des mots utilisés par la recherche.',
	'Cette commande demande un certain temps pour s\'accomplir. Il n\'est pas nécessaire d\'exécuter cette vérification mais la faire peut réduire la taille de la base de données. Continuer ?',
	0);
$mtnc[] = array('--', '', '', '');
$mtnc[] = array('synchronize_post',
	'Synchroniser les forums et les sujets',
	'Cela va synchroniser les compteurs des messages ainsi que les données des messages dans les forums et les sujets.',
	'Cette commande nécessite un certain temps pour se finaliser. Si votre serveur n\'autorise pas l\'usage de la commande set_time_limit(), alors celle-ci sera interrompue par PHP. Aucune donnée ne sera perdue par cette action mais certaines données peuvent ne pas être mises à jour. Continuer ?',
	0);
$mtnc[] = array('synchronize_user',
	'Synchroniser les compteurs de messages des utilisateurs',
	'Cela va synchroniser les compteurs de messages de tous les utilisateurs.',
	'<b>Attention :</b> les messages qui ont été délestés ne sont normalement pas soustraits du compteur de message. Quand vous effectuerez cette commande, les messages délestés seront soustraits du compteur et ne pourront pas être restaurés. Continuer ?',
	0);
$mtnc[] = array('synchronize_mod_state',
	'Synchroniser les statuts des modérateurs',
	'Cela va re-synchroniser le statut des modérateurs dans la table des utilisateurs.',
	'',
	0);
$mtnc[] = array('--', '', '', '', 0);
$mtnc[] = array('reset_date',
	'Réinitialiser la date des derniers messages',
	'Cela va réinitialiser les données des derniers messages si ils sont enregistrés avec une date future. Cela résoudra les problèmes que les utilisateurs peuvent rencontrer lorsqu\'ils envoient un message qu\'ils ne sont pas autorisés à créer aussitôt après le précédent message.',
	'L\'heure d\'un message futur sera synchronisée avec l\'heure actuelle. Continuer ?',
	0);
$mtnc[] = array('reset_sessions',
	'Réinitialiser toutes les sessions',
	'Cela va réinitialiser toutes les sessions actuelles en vidant la table session.',
	'Tous les utilisateurs actuellement actifs perdront leurs sessions et les résultats de leurs recherches. Continuer ?',
	0);
$mtnc[] = array('--', '', '', '', 8);
$mtnc[] = array('rebuild_search_index',
	'Reconstruire l\'index de recherche',
	'Cette fonction reconstruira l\'index utilisé pour la recherche. Vous n\'aurez pas besoin de cette fonction lors de conditions normales d\'utilisation. Cela supprimera complètement l\'index de recherche et le reconstruira. Cette tâche peut mettre plusieurs heures à s\'accomplir. Le forum ne sera pas accessible durant ce temps-là. Continuer ?',
	'',
	7);
$mtnc[] = array('proceed_rebuilding',
	'Recommencer la reconstruction',
	'Utiliser cette fonction si la recréation de l\'index de recherche a été interrompue.',
	'',
	4);
$mtnc[] = array('--', '', '', '', 1);
$mtnc[] = array('check_db',
	'Vérifier la base de données',
	'Vérifie que la base de données ne contient pas d\'erreurs.',
	'',
	1);

$mtnc[] = array('optimize_db',
	'Optimiser la base de données',
	'Optimiser les tables. Cela va réduire la taille de votre base de données après en avoir supprimé plusieurs enregistrements devenus obsolètes.',
	'',
	1);
$mtnc[] = array('repair_db',
	'Réparer la base de données',
	'Corrige les éventuelles erreurs trouvées dans la base de données.',
	'Vous ne devez exécuter cette action que si une erreur est rapportée au moment de la vérification de la base de données. Continuer ?',
	1);
$mtnc[] = array('--', '', '', '', 0);
$mtnc[] = array('reset_auto_increment',
	'Réinitialiser les valeurs auto incrémentées',
	'Cette fonction réinitialise les valeurs auto incrémentées. Cela doit être exécuté seulement si il apparaît des problèmes concernant l\'insertion de nouvelles données dans les tables.',
	'Voulez-vous vraiment réinitialiser les valeurs auto incrémentées ? Aucune donnée ne sera perdue mais cette fonction doit seulement être utilisée si elle s\'avère nécessaire.',
	0);
$mtnc[] = array('heap_convert',
	'Convertir la table session',
	'Cette fonction convertira la table session en une table de type HEAP. Cela s\'effectue normalement durant l\'installation et accélérera sensiblement phpBB. Vous devez utiliser cette fonction si votre table session n\'est pas une table de type HEAP.',
	'Voulez-vous vraiment convertir la table ?',
	2);
$mtnc[] = array('--', '', '', '', 3);
$mtnc[] = array('unlock_db',
	'Réactiver le forum',
	'Utiliser cette fonction si vous avez obtenu une erreur durant l\'exécution d\'une opération lancée auparavant et si le forum est toujours désactivé.',
	'',
	3);

//
// Function specific vars
//

// statistic
$lang['Statistic_title'] = 'Statistiques du forum et de la base de données';
$lang['Database_table_info'] = 'Les statistiques de la base de données sont fournis de trois façons différentes : celles pour toutes les tables de la base de données, celles pour toutes les tables utilisées par défaut par phpBB (tables noyaux) et celle commençant avec le préfixe des tables du forum (tables complémentaires).';
$lang['Board_statistic'] = 'Statistiques du forum';
$lang['Database_statistic'] = 'Statistiques de la base de données';
$lang['Version_info'] = 'Informations sur les versions';
$lang['Thereof_deactivated_users'] = 'désactivé(s)';
$lang['Thereof_Moderators'] = 'modérateur(s)';
$lang['Thereof_Administrators'] = 'administrateur(s)';
$lang['Users_with_Admin_Privileges'] = 'Utilisateur(s) avec des droits d\'administrateur';
$lang['Number_tables'] = 'Nombre de table(s)';
$lang['Number_records'] = 'Nombre d\'enregistrement(s)';
$lang['DB_size'] = 'Taille de la base de données';
$lang['Thereof_phpbb_core'] = 'Tables phpBB de base';
$lang['Thereof_phpbb_advanced'] = 'Avec les tables complémentaires';
$lang['Version_of_board'] = 'Version du forum';
$lang['Version_of_mod'] = 'Version de DB Maintenance';
$lang['Version_of_PHP'] = 'Version de PHP';
$lang['Version_of_MySQL'] = 'Version de MySQL';
// config
$lang['Config_title'] = 'Configuration de DB Maintenance ';
$lang['Config_info'] = 'Les options suivantes vous autorise à configurer le comportement de DB Maintenance. SVP, gardez à l\'esprit qu\'une mauvaise configuration peut conduire à des résultats inattendus.';
$lang['General_Config'] = 'Configuration Générale';
$lang['Rebuild_Config'] = 'Configuration de la reconstruction de l\'index de recherche';
$lang['Current_Rebuild_Config'] = 'Configuration de la reconstruction actuelle';
$lang['Rebuild_Settings_Explain'] = 'Ces options définissent le comportement de DB Maintenance lors de la recontruction de l\'index de recherche.';
$lang['Current_Rebuild_Settings_Explain'] = 'Ces options sont utilisées par DB Maintenance pour enregistrer la position de la reconstruction actuelle. Il n\'y a aucun besoin de modifier ces options dans des conditions normales d\'utilisation.';
$lang['Disallow_postcounter'] = 'Ne pas autoriser la synchronisation des compteurs de messages des utilisateurs';
$lang['Disallow_postcounter_Explain'] = 'Cela désactivera la fonction de synchronisation des compteurs de messages des utilisateurs. Vous pouvez désactiver cette fonction si vous ne voulez pas que les messages supprimés soient retirés du compteur des utilisateurs.';
$lang['Disallow_rebuild'] = 'Ne pas autoriser la reconstruction de l\'index de recherche';
$lang['Disallow_rebuild_Explain'] = 'Cela désactivera la reconstruction de l\'index de recherche. Une reconstruction interrompue précédemment pourra cependant être terminée.';
$lang['Rebuildcfg_Timelimit'] = 'Durée maximale d\'exécution pour la reconstruction (en secondes)';
$lang['Rebuildcfg_Timelimit_Explain'] = 'Durée maximale pour une étape lors d\'une reconstruction (par défaut: 240). Cette valeur limite la durée d\'exécution même si une durée plus longue est possible.';
$lang['Rebuildcfg_Timeoverwrite'] = 'Durée définie disponible pour l\'exécution (en secondes)';
$lang['Rebuildcfg_Timeoverwrite_Explain'] = 'Durée définie disponible pour l\'exécution (par défaut : 0). Avec 0 le résultat du calcul est utilisé comme durée d\'exécution, une autre valeur écrase la valeur calculée.';
$lang['Rebuildcfg_Maxmemory'] = 'Taille de message maximale pour la reconstruction (en Ko)';
$lang['Rebuildcfg_Maxmemory_Explain'] = 'Taille de message maximale indexée en une étape (par défaut : 500). Quand la somme des messages va au-delà de cette valeur, aucun messages supplémentaire n\'est indexé dans l\'étape en cours.';
$lang['Rebuildcfg_Minposts'] = 'Messages minimum à indexer par étape';
$lang['Rebuildcfg_Minposts_Explain'] = 'Nombre minimal de messages indexé par étape (par défaut : 3). Définit le nombre de messages par étape qui sont au moins indexés.';
$lang['Rebuildcfg_PHP3Only'] = 'Utiliser seulement une méthode standard compatible PHP 3 pour l\'indexation';
$lang['Rebuildcfg_PHP3Only_Explain'] = 'DB Maintenance utilise une méthode avancée pour l\'indexation quand PHP 4.0.5 ou une version plus récente est disponible. Vous pouvez désactiver la méthode avancée, dans ce cas DB Maintenance utilisera la méthode standard du forum.';
$lang['Rebuildcfg_PHP4PPS'] = 'Messages indexés par seconde quand la méthode d\'indexation avancée est utilisée';
$lang['Rebuildcfg_PHP4PPS_Explain'] = 'Valeur estimé de messages qui peuvent être indexé par seconde quand la méthode d\'indexation avancée est utilisée (par défaut : 8).';
$lang['Rebuildcfg_PHP3PPS'] = 'Messages indexés par seconde quand la méthode d\'indexation standard est utilisée';
$lang['Rebuildcfg_PHP3PPS_Explain'] = 'Valeur estimée de messages qui peuvent être indexé par seconde quand la méthode d\'indexation standard est utilisée (par défaut : 1).';
$lang['Rebuild_Pos'] = 'Dernier message indexé';
$lang['Rebuild_Pos_Explain'] = 'ID du dernier message indexé avec succès. Est à -1 quand la reconstruction est terminée.';
$lang['Rebuild_End'] = 'Dernier message à indexer';
$lang['Rebuild_End_Explain'] = 'ID du dernier message à indexer. Est à 0 quand la reconstruction est terminée.';
$lang['Dbmtnc_config_updated'] = 'Configuration mise à jour avec succès';
$lang['Click_return_dbmtnc_config'] = 'Cliquez %sIci%s pour retourner à la configuration';
// check_user
$lang['Checking_user_tables'] = 'Vérifie les tables des utilisateurs et des groupes';
$lang['Checking_missing_anonymous'] = 'Vérifie si le compte "anonyme" est manquant';
$lang['Anonymous_recreated'] = 'Compte "anonyme" recréé';
$lang['Checking_incorrect_pending_information'] = 'Vérifie que les renseignements en attente ne sont pas inexacts';
$lang['Updating_invalid_pendig_user'] = 'Met à jour les renseignements en attente qui s\'avèrent invalide pour un utilisateur';
$lang['Updating_invalid_pendig_users'] = 'Met à jour les renseignements en attente qui s\'avèrent invalide pour %d utilisateurs';
$lang['Updating_pending_information'] = 'Met à jour les renseignements en attente pour les groupes d\'utilisateurs individuels';
$lang['Checking_missing_user_groups'] = 'Vérifie les utilisateurs avec plusieurs ou aucun groupe d\'utilisateurs individuels';
$lang['Found_multiple_SUG'] = 'A trouvé des utilisateurs avec plusieurs groupes d\'utilisateurs individuels';
$lang['Resolving_user_id'] = 'Replace les utilisateurs dans un groupe';
$lang['Removing_groups'] = 'Retire les groupes';
$lang['Removing_user_groups'] = 'Retire les utilisateurs du groupe de connexion';
$lang['Recreating_SUG'] = 'Recrée les groupes d\'utilisateurs individuels pour les utilisateurs';
$lang['Checking_for_invalid_moderators'] = 'Vérifie que la configuration des modérateurs des groupes n\'est pas invalide';
$lang['Updating_Moderator'] = 'Configure les utilisateurs actuels comme modérateur du groupe';
$lang['Checking_moderator_membership'] = 'Vérifie les inscriptions au groupe du modérateur';
$lang['Updating_mod_membership'] = 'Met à jour les inscriptions du modérateur du groupe';
$lang['Moderator_added'] = 'Modérateur ajouté au groupe';
$lang['Moderator_changed_pending'] = 'Change le statut d\'attente du modérateur';
$lang['Remove_invalid_user_data'] = 'Retire les données invalides des utilisateurs dans la table des groupes d\'utilisateurs';
$lang['Remove_empty_groups'] = 'Retire les groupes vides';
$lang['Remove_invalid_group_data'] = 'Retire les données invalides des groupes dans la table des groupes d\'utilisateurs';
$lang['Checking_ranks'] = 'Vérifie qu\'il n\'y a pas de rangs invalides';
$lang['Invalid_ranks_found'] = 'Trouve des utilisateurs avec un rang invalide';
$lang['Removing_invalid_ranks'] = 'Retire les rangs invalides';
$lang['Checking_themes'] = 'Vérifie qu\'il n\'y a pas de configuration des thèmes invalide';
$lang['Updating_users_without_style'] = 'Mets à jour les utilisateurs sans thème configuré';
$lang['Default_theme_invalid'] = '<b>Attention :</b> Le thème par défaut est invalide. Veuillez vérifier votre configuration.';
$lang['Updating_themes'] = 'Met à jour les thèmes invalides vers le thème %d';
$lang['Checking_theme_names'] = 'Vérifie qu\'il n\'a pas de données invalides concernant le nom des thèmes';
$lang['Removing_invalid_theme_names'] = 'Retire les données invalides concernant le nom des thèmes';
$lang['Checking_languages'] = 'Vérifie qu\'il n\'y a pas de configuration de langue invalide';
$lang['Invalid_languages_found'] = 'Trouve des utilisateurs avec une configuration de la langue invalide';
$lang['Default_language_invalid'] = '<b>Attention :</b> La langue par défaut est invalide. Veuillez vérifier votre configuration.';
$lang['English_language_invalid'] = '<b>Attention :</b> La langue par défaut est invalide et les fichiers de langue anglaise n\'existent pas. Vous devez restaurer le répertoire <b>lang_english</b>.';
$lang['Changing_language'] = 'Change la langue de \'%s\' vers \'%s\'';
$lang['Remove_invalid_ban_data'] = 'Retire les données de bannissement invalides';
$lang['Remove_invalid_session_keys'] = 'Retire les clés de sessions invalides';

// check_post
$lang['Checking_post_tables'] = 'Vérifie les tables des messages et des sujets';
$lang['Checking_invalid_forums'] = 'Vérifie qu\'il n\'y a pas de forums avec une catégorie invalide';
$lang['Invalid_forums_found'] = 'Trouve des forums avec une catégorie invalide';
$lang['Setting_category'] = 'Déplace les forums dans la catégorie \'%s\'';
$lang['Checking_posts_wo_text'] = 'Vérifie qu\'il n\'y a pas de messages sans texte';
$lang['Posts_wo_text_found'] = 'Trouve des messages sans texte';
$lang['Deleting_post_wo_text'] = '%d (Sujet : %s (%d); Utilisateur : %s (%d))';
$lang['Deleting_Posts'] = 'Supprime les données des messages';
$lang['Checking_topics_wo_post'] = 'Vérifie qu\'il n\'y a pas de sujets sans message';
$lang['Topics_wo_post_found'] = 'Trouve des sujets sans message';
$lang['Deleting_topics'] = 'Supprime les données des sujets';
$lang['Checking_invalid_topics'] = 'Vérifie qu\'il n\'y a pas de sujets avec un forum invalide';
$lang['Invalid_topics_found'] = 'Trouve des sujets avec un forum invalide';
$lang['Setting_forum'] = 'Déplace les sujets dans le forum \'%s\'';
$lang['Checking_invalid_posts'] = 'Vérifie qu\'il n\'y a pas de messages avec un sujet invalide';
$lang['Invalid_posts_found'] = 'Trouve des messages avec un sujet invalide';
$lang['Setting_topic'] = 'Déplace les messages %s du sujet \'%s\' (%d) dans le forum \'%s\'';
$lang['Checking_invalid_forums_posts'] = 'Vérifie qu\'il n\'y a pas de messages avec un forum invalide';
$lang['Invalid_forum_posts_found'] = 'Trouve des messages avec un forum invalide';
$lang['Setting_post_forum'] = '%d: Déplace du forum \'%s\' (%d) vers \'%s\' (%d)';
$lang['Checking_texts_wo_post'] = 'Vérifie qu\'il n\'y a pas de texte sans message rattaché';
$lang['Invalid_texts_found'] = 'Trouve des textes sans message rattaché';
$lang['Recreating_post'] = 'Recrée le message %d et le déplace dans le sujet \'%s\' situé dans le forum \'%s\'<br />Extrait : %s';
$lang['Checking_invalid_topic_posters'] = 'Vérifie qu\'il n\'y a pas de sujet avec un utilisateur invalide';
$lang['Invalid_topic_poster_found'] = 'Trouve des sujets avec un utilisateur invalide';
$lang['Updating_topic'] = 'Met à jour le sujet %d (Utilisateur : %d -&gt; %d)';
$lang['Checking_invalid_posters'] = 'Vérifie qu\'il n\'y a pas de message avec un utilisateur invalide';
$lang['Invalid_poster_found'] = 'Trouve des messages avec un utilisateur invalide';
$lang['Updating_posts'] = 'Met à jour les messages';
$lang['Checking_moved_topics'] = 'Vérifie les sujets déplacés';
$lang['Deleting_invalid_moved_topics'] = 'Supprime les sujets déplacés invalides';
$lang['Updating_invalid_moved_topic'] = 'Met à jour les informations de déplacement invalides pour un sujet non déplacé';
$lang['Updating_invalid_moved_topics'] = 'Met à jour les informations des déplacements invalides pour %d sujets non déplacés';
$lang['Checking_prune_settings'] = 'Vérifie qu\'il n\'y a pas de données de délestage invalide';
$lang['Removing_invalid_prune_settings'] = 'Retire la configuration invalide pour le délestage';
$lang['Updating_invalid_prune_setting'] = 'Met à jour la configuration de délestage invalide d\'un forum';
$lang['Updating_invalid_prune_settings'] = 'Met à jour la configuration de délestage invalide pour %d forums';
$lang['Checking_topic_watch_data'] = 'Vérifie qu\'il n\'y a pas de sujets invalides surveillés';
$lang['Checking_auth_access_data'] = 'Vérifie qu\'il n\'y a pas de données d\'autorisation invalides pour les groupes';
$lang['Must_synchronize'] = 'Vous devez synchroniser les données des messages avant d\'utiliser votre forum. Cliquez pour continuer.';

// check_vote
$lang['Checking_vote_tables'] = 'Vérifie les tables des sondages';
$lang['Checking_votes_wo_topic'] = 'Vérifie qu\'il n\'y a pas de sondages sans sujets correspondants';
$lang['Votes_wo_topic_found'] = 'Trouve des sondages sans sujets';
$lang['Invalid_vote'] = '%s (%d) - Date de début : %s - Date de fin : %s';
$lang['Deleting_votes'] = 'Supprime les sondages';
$lang['Checking_votes_wo_result'] = 'Vérifie les sondages sans résultats';
$lang['Votes_wo_result_found'] = 'Trouve des sondages sans résultats';
$lang['Checking_topics_vote_data'] = 'Vérifie les données des sondages dans les tables des sujets';
$lang['Updating_topics_wo_vote'] = 'Met à jour les sujets affichant un sondage sans sondage correspondant';
$lang['Updating_topics_w_vote'] = 'Met à jour les sujets n\'affichant pas de sondage mais qui ont un sondage correspondant';
$lang['Checking_results_wo_vote'] = 'Vérifie les résultats sans sondage correspondant';
$lang['Results_wo_vote_found'] = 'Trouve des résultats sans sondage';
$lang['Invalid_result'] = 'Supprime le résultat : %s (Sondages : %d)';
$lang['Checking_voters_data'] = 'Vérifie qu\'il n\'y a pas de données de sondage invalides';

// check_pm
$lang['Checking_pm_tables'] = 'Vérifie les tables des messages privés';
$lang['Checking_pms_wo_text'] = 'Vérifie qu\'il n\'y a pas de messages privés sans texte';
$lang['Pms_wo_text_found'] = 'Trouve des messages privés sans texte';
$lang['Deleting_pn_wo_text'] = '%d (Sujet: %s; Expéditeur : %s (%d); Destinataire : %s (%d))';
$lang['Deleting_Pms'] = 'Supprime les données des messages privés';
$lang['Checking_texts_wo_pm'] = 'Vérifie le texte des messages privés qui seraient sans message';
$lang['Deleting_pm_texts'] = 'Supprime le texte des messages privés invalides';
$lang['Checking_invalid_pm_senders'] = 'Vérifie les messages privés qui pourraient avoir des expéditeurs invalides';
$lang['Invalid_pm_senders_found'] = 'Trouve des messages privés avec un expéditeur invalide';
$lang['Updating_pms'] = 'Met à jour les messages privés';
$lang['Checking_invalid_pm_recipients'] = 'Vérifie les messages privés qui pourraient avoir des destinataires invalides';
$lang['Invalid_pm_recipients_found'] = 'Trouve des messages privés avec un destinataire invalide';
$lang['Checking_pm_deleted_users'] = 'Vérifie les messages privés qui pourraient avoir un expéditeur ou un destinataire qui aurait été supprimé';
$lang['Invalid_pm_users_found'] = 'A trouvé des messages privés dont l\'expéditeur ou le destinataire a été supprimé';
$lang['Deleting_pms'] = 'Supprime les messages privés';
$lang['Synchronize_new_pm_data'] = 'Synchronise les compteurs des nouveaux messages privés';
$lang['Synchronizing_users'] = 'Met à jour les utilisateurs';
$lang['Synchronizing_user'] = 'Met à jour l\'utilisateur %s (%d)';
$lang['Synchronize_unread_pm_data'] = 'Synchronise les compteurs des messages privés non lus';

// check_config
$lang['Checking_config_table'] = 'Contôler la table de configuration';
$lang['Checking_config_entries'] = 'Contrôler les entrées de la table de configuration';
$lang['Restoring_config'] = 'Restaurer les entrées';

// check_search_wordmatch
$lang['Checking_search_wordmatch_tables'] = 'Vérifie la table identifiant les mots utilisés par la recherche';
$lang['Checking_search_data'] = 'Vérifie qu\'il n\'y a pas de données de recherches invalides';

// check_search_wordlist
$lang['Checking_search_wordlist_tables'] = 'Vérifie la table listant les mots utilisés par la recherche';
$lang['Checking_search_words'] = 'Vérifie qu\'il n\'y a pas de mots inutiles utilisés par la fonction recherche';
$lang['Removing_part_invalid_words'] = 'Retire certaines parties des mots utilisés par la recherche devenues inutiles';
$lang['Removing_invalid_words'] = 'Retire les mots utilisés par la recherche devenus inutiles';
// rebuild_search_index
$lang['Rebuilding_search_index'] = 'Reconstruit l\'index de recherche';
$lang['Deleting_search_tables'] = 'Nettoie les tables de recherche';
$lang['Reset_search_autoincrement'] = 'Réinitialise le compteur des tables de recherche';
$lang['Preparing_config_data'] = 'Prépare les informations de configuration';
$lang['Can_start_rebuilding'] = 'Vous pouvez maintenant commencer la reconstruction de l\'index de recherche';
$lang['Click_once_warning'] = '<b>Cliquez seulement UNE SEULE fois sur le lien!</b> - plusieurs minutes peuvent se passer avant l\'affichage d\'une nouvelle page.';
// proceed_rebuilding
$lang['Preparing_to_proceed'] = 'Préparation des tables por autoriser l\'exécution';
$lang['Preparing_search_tables'] = 'Préparation des tables de recherches pour l\'exécution';
// perform_rebuild
$lang['Click_or_wait_to_proceed'] = 'Cliquez ici pour exécuter l\'opération ou attendez quelques secondes';
$lang['Indexing_progress'] = '%d de %d messages (%01.1f%%) ont été indexé. Voici le dernier message indexé : %d';
$lang['Indexing_finished'] = 'La reconstruction de l\'index a été accomplie avec succès';
// synchronize_post
$lang['Synchronize_posts'] = 'Synchronise les données des messages';
$lang['Synchronize_topic_data'] = 'Synchronise les sujets';
$lang['Synchronizing_topics'] = 'Met à jour les sujets';
$lang['Synchronizing_topic'] = 'Met à jour le sujet %d (%s)';
$lang['Synchronize_moved_topic_data'] = 'Synchronise les sujets déplacés';
$lang['Inconsistencies_found'] = 'Des incohérences ont été trouvées dans votre base de données. Veuillez %Vérifier les tables des messages et des sujets%s';
$lang['Synchronizing_moved_topics'] = 'Met à jour les sujets déplacés';
$lang['Synchronizing_moved_topic'] = 'Met à jour le sujet déplacé %d -&gt; %d (%s)';
$lang['Synchronize_forum_topic_data'] = 'Synchronise les données des sujets dans les forums';
$lang['Synchronizing_forums'] = 'Met à jour les forums';
$lang['Synchronizing_forum'] = 'Met à jour le forum %d (%s)';
$lang['Synchronize_forum_data_wo_topic'] = 'Synchronise les forums sans sujet';
$lang['Synchronize_forum_post_data'] = 'Synchronise les données des messages dans les forums';
$lang['Synchronize_forum_data_wo_post'] = 'Synchronise les forums sans message';

// synchronize_user
$lang['Synchronize_post_counters'] = 'Synchronise les compteurs de messages';
$lang['Synchronize_user_post_counter'] = 'Synchronise les compteurs de messages des utilisateurs';
$lang['Synchronizing_user_counter'] = 'Met à jour l\'utilisateur %s (%d): %d -&gt; %d';

// synchronize_mod_state
$lang['Synchronize_moderators'] = 'Synchronise le statut de modérateur dans la table des utilisateurs';
$lang['Getting_moderators'] = 'Obtient la liste des modérateurs';
$lang['Checking_non_moderators'] = 'Vérifie que les utilisateurs avec le statut de modérateur ne modèrent pas tous le forum';
$lang['Updating_mod_state'] = 'Met à jour le statut de modérateur des utilisateurs';
$lang['Changing_moderator_status'] = 'Change le statut de modérateur de l\'utilisateur %s (%d)';
$lang['Checking_moderators'] = 'Vérifie que les utilisateurs n\'ayant pas le statut de modérateur ne modèrent pas un forum';

// reset_date
$lang['Resetting_future_post_dates'] = 'Réinitialise les données des derniers messages si ils sont enregistrés avec une date future';
$lang['Checking_post_dates'] = 'Vérifie les dates des messages';
$lang['Checking_pm_dates'] = 'Vérifie les dates des messages privés';
$lang['Checking_email_dates'] = 'Vérifie les dates des derniers emails';

// reset_sessions
$lang['Resetting_sessions'] = 'Réinitialise les sessions';
$lang['Deleting_session_tables'] = 'Supprime dans les tables appropriées les sessions et les résultats des recherches';
$lang['Restoring_session'] = 'Restaure les sessions des utilisateurs actifs';

// check_db
$lang['Checking_db'] = 'Vérifie la base de données';
$lang['Checking_tables'] = 'Vérifie les tables';
$lang['Table_OK'] = 'OK';
$lang['Table_HEAP_info'] = 'Commande non disponible pour les tables de type HEAP';

// repair_db
$lang['Repairing_db'] = 'Répare la base de données';
$lang['Repairing_tables'] = 'Répare les tables';

// optimize_db
$lang['Optimizing_db'] = 'Optimise la base de données';
$lang['Optimizing_tables'] = 'Optimise les tables';
$lang['Optimization_statistic'] = 'L\'optimisation à réduit la taille des tables de %s à %s. Cela correspond à une réduction de %s ou %01.2f%%.';

// reset_auto_increment
$lang['Reset_ai'] = 'Réinitialise les valeurs auto incrémentées';
$lang['Ai_message_update_table'] = 'Table mise à jour';
$lang['Ai_message_no_update'] = 'Aucune mise à jour n\'est nécessaire';
$lang['Ai_message_update_table_old_mysql'] = 'Table mise à jour'; // Used if an old version of MySQL is used which does not allow a table check before updating the table

// heap_convert
$lang['Converting_heap'] = 'Convertit la table session en HEAP';

// unlock_db
$lang['Unlocking_db'] = 'Réactive la base de données';

// Emergency Recovery Console
$lang['Forum_Home'] = 'Index du forum';
$lang['ERC'] = 'Console de récupération d\'urgence';
$lang['Submit_text'] = 'Envoyer';
$lang['Select_Language'] = 'Sélectionner une langue';
$lang['No_selectable_language'] = 'Aucune langue sélectionnable n\'existe';
$lang['Select_Option'] = 'Sélectionner une option';
$lang['Option_Help'] = 'Détails pour les options';
$lang['Authenticate_methods'] = 'Il y a deux méthodes pour vous identifier';
$lang['Authenticate_methods_help_text'] = 'Vous devez vous identifier avant de pouvoir effectuer le moindre changement dans la configuration du forum. Il y a deux possibilités pour cela : La première, vous pouvez vous identifier en entrant le nom d\'utilisateur et le mot de passe d\'un compte administrateur actif sur le forum (méthode préférée). La seconde, vous pouvez vous identifier en entrant le nom d\'utilisateur et le mot de passe correspondant au compte utilisant la base de données,le forum utilise ceux-ci pour accéder à la base de données.';
$lang['Authenticate_user_only'] = 'Vous devez vous identifier avec un compte administrateur actif.';
$lang['Authenticate_user_only_help_text'] = 'Vous devez vous identifier avant de pouvoir effectuer le moindre changement dans la configuration du forum. Vous pouvez seulement vous identifier en entrant le nom et le mot de passe d\'un compte administrateur actif sur le forum.';
$lang['Admin_Account'] = 'Compte administrateur du forum';
$lang['Database_Login'] = 'Nom d\'utilisateur de la base de données';
$lang['Username'] = 'Nom d\'utilisateur';
$lang['Password'] = 'Mot de passe';
$lang['Auth_failed'] = 'Identification échouée !';
$lang['Return_ERC'] = 'Revenir à la console de récupération d\'urgence';
$lang['cur_setting'] = 'Configuration actuelle';
$lang['rec_setting'] = 'Configuration recommandée';
$lang['secure'] = 'Sécuriser';
$lang['secure_yes'] = 'oui (https)';
$lang['secure_no'] = 'non (http)';
$lang['domain'] = 'Domaine';
$lang['port'] = 'Port';
$lang['path'] = 'Chemin';
$lang['Cookie_domain'] = 'Domaine du cookie';
$lang['Cookie_name'] = 'Nom du cookie';
$lang['Cookie_path'] = 'Chemin du cookie';
$lang['select_language'] = 'Sélectionner la nouvelle langue';
$lang['select_theme'] = 'Sélectionner le nouveau thème';
$lang['reset_thmeme'] = 'Recréer le thème par défaut';
$lang['new_admin_user'] = 'Utilisateur ayant des droits d\'administrateur';
$lang['dbms'] = 'Type de base de données';
$lang['DB_Host'] = 'Nom du Serveur de Base de données / SGBD';
$lang['DB_Name'] = 'Nom de votre Base de données';
$lang['DB_Username'] = 'Nom d\'utilisateur de la base de données';
$lang['DB_Password'] = 'Mot de passe de la base de données';
$lang['Table_Prefix'] = 'Préfixe des tables dans la base de données';
$lang['New_config_php'] = "Ceci est votre nouveau config.$phpEx";

// Options
$lang['cls'] = 'Vider toutes les sessions';
$lang['rdb'] = 'Réparer les tables de la base de données';
$lang['cct'] = 'Conôler la table de configuration';
$lang['rpd'] = 'Réinitialiser les données du script';
$lang['rcd'] = 'Réinitialiser les données des cookies';
$lang['rld'] = 'Réinitialiser les données des langues';
$lang['rtd'] = 'Réinitialiser les données des templates';
$lang['dgc'] = 'Désactiver la compression GZip';
$lang['cbl'] = 'Vider la liste des bannis';
$lang['raa'] = 'Retirer tous les administrateurs';
$lang['mua'] = 'Accorder des droits d\'administrateur à un utilisateur';
$lang['rcp'] = 'Recréer config.php';

// Info for options
$lang['cls_info'] = 'Quand vous effectuerez ceci toutes les sessions seront vidées.';
$lang['rdb_info'] = 'Quand vous effectuerez ceci les tables de la bas de données seront réparées.';
$lang['cct_info'] = 'Quand vous effectuerez ceci Les tables seront vérifiées et les entrées manquantes seron restaurées.';
$lang['rpd_info'] = 'Quand vous effectuerez ceci les données de configuration seront mises à jour si la configuration recommandée est sélectionnée.';
$lang['rcd_info'] = 'Quand vous effectuerez ceci les données des cookies seront mises à jour. L\'option permettant d\'activer les cookies sécurisés se trouve dans la partie \'Réinitialiser les données du script\'.';
$lang['rld_info'] = 'Quand vous effectuerez ceci la langue sélectionnée sera utilisée sur tout le forum. Ceci inclut les utilisateurs s\'étant identifié.';
$lang['rtd_info'] = 'Quand vous effectuerez ceci le style sélectionné sera alors utilisé par le forum. Ceci inclut les utilisateurs s\'étant identifié ou bien le thème par défaut (subSilver) sera recréé et utilisé par le forum et les utilisateurs.';
$lang['rtd_info_no_theme'] = 'Quand vous effectuerez ceci le thème par défaut (subSilver) sera recrée et utilisé sur tout le forum. Ceci inclut les utilisateurs s\'étant identifiés.';
$lang['dgc_info'] = 'Quand vous effectuerez ceci, la compression GZip sera désactivée.';
$lang['cbl_info'] = 'Quand vous effectuerez ceci la liste des utilisateurs bannis ainsi que celle des noms d\'utilisateurs interdits seront vidées.';
$lang['raa_info'] = 'Quand vous effectuerez ceci tous les administrateurs redeviendront des utilisateurs normaux. Si vous utilisez un compte administrateur pour vous identifier, alors celui-ci gardera les droits d\'administrateur.';
$lang['mua_info'] = 'Quand vous effectuerez ceci l\'utilisateur sélectionné obtiendra les droits d\'un administrateur. L\'utilisateur sera aussi activé.';
$lang['rcp_info'] = 'Quand vous effectuerez ceci un nouveau fichier config.php sera créé avec les données entrées.';

// Success messages for options
$lang['cls_success'] = 'Toutes les sessions ont été vidées avec succès.';
$lang['rdb_success'] = 'Les tables de la base de données ont été réparées.';
$lang['rpd_success'] = 'La configuration du forum a été mise à jour avec succès.';
$lang['cct_success'] = 'La configuration des tables a été vérifiée avec succès.';
$lang['rcd_success'] = 'Les données des cookies ont été mises à jour avec succès.';
$lang['rld_success'] = 'Les données de langue ont été mises à jour avec succès.';
$lang['rld_failed'] = "Les fichiers de langue requis (lang_main.$phpEx et lang_admin.$phpEx) n\'existent pas.";
$lang['rtd_restore_success'] = 'Le thème par défaut a été restauré avec succès.';
$lang['rtd_success'] = 'Les données du thème ont été mises à jour avec succès.';
$lang['dgc_success'] = 'La compression GZip a été désactivée avec succès.';
$lang['cbl_success'] = 'Les listes des utilisateurs bannis ainsi que celles des nom d\'utilisateurs désactivés ont été vidées avec succès.';$lang['raa_success'] = 'Tous les administrateurs ont été retirés avec succès.';
$lang['cbl_success_anonymous'] = 'La liste des bannis et des utilisateurs non-autorisés a été nettoyé avec succès. Le compte "Anonyme" a été recréé. Les informations de groupe du compte "Anonyme" pouvant être manquante, il est recommandé d\'utiliser la fonction &quot;Vérifier les tables des groupes et des utilisateurs&quot; dans la configuration générale de DB Maintenance.';
$lang['raa_success'] = 'Tous les administrateurs ont été supprimé avec succès.';
$lang['mua_success'] = 'L\'utilisateur sélectionné a maintenant des droits d\'administrateur.';
$lang['mua_failed'] = '<b>Erreur :</b> L\'utilisateur sélectionné n\'existe pas ou il a déjà des droits d\'administrateur.';
$lang['rcp_success'] = "Copiez ce code dans un fichier texte, puis renommez le en <b>config.$phpEx</b> et envoyez le dans le répertoire racine du forum. Vous pouvez aussi %stélécharger%s ce fichier sur votre ordinateur.";

// Text for success messages
$lang['Removing_admins'] = 'Retire les administrateurs';

// Help Text
$lang['Option_Help_Text'] = '<p>S\'il vous est rapporté une erreur concernant la création de nouvelle session ou autre, vous devriez alors vider les données des sessions en sélectionnant <b>Vider toutes les sessions</b>.</p>Si vous avez des problèmes à accéder aux tables de la base de données, vous pouvez réparer les tables en sélectionnant 
<b>Réparez les tables de la base de données</b>. <b>Vérifier la table de configuration</b> vérifiera la table de configuration pour les entrées manquantes, ce qui peut être utile pour plusieur types d\'erreurs.</p>
<p>Si vous êtes dans l\'incapacité de vous connecter ou d\'accéder au panneau d\'administration, il peut alors y avoir une erreur dans le chemin du script ou la configuration des cookies. Vous pouvez réinitialiser ceci grâce à <b>Réinitialiser les données du script</b> ou <b>Réinitialiser les données des cookies</b>. Vous pouvez aussi réinitialiser la configuration de la langue grâce à <b>Réinitialiser les données des langues</b> ou les données des templates avec <b>Réinitialiser les données des templates</b>.</p>
<p>Si des problèmes arrivent après avoir activer la compression GZip, vous pouvez la désactiver en sélecionnant  <b>Désactiver la compression GZip</b>.</p>
<p>Si vous perdez le mot de passe de votre compte, vous pouvez attribuer les droits d\'administrateur à un utilisateur en sélectionnant <b>Accorder des droits d\'administrateur à un utilisateur</b>. Ceci activera aussi l\'utilisateur que vous aurez créé auparavant permettant ainsi de s\'en servir aussitôt. Si vous êtes dans l\'incapacité d\'ajouter de nouveaux membres, vous pouvez vider la liste des bannis en choisissant <b>Vider la liste des bannis</b>.(cela restaurera également le compte \'Anonyme\')</p>
<p>Si votre forum a été piraté, il est recommandé de retirer tous les comptes administrateurs en sélectionnant <b>Retirer tous les administrateurs</b>. (Les comptes eux mêmes ne seront pas détruits mais se verront retirés leurs droits.)</p>
<p>Si vous avez besoin de restaurer config.php vous pouvez donc le faire en sélectionnant <b>Recréer config.php</b>.</p>';
?>