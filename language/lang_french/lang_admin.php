<?php
/***************************************************************************
 *                            lang_admin.php [french]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2004 PhpBB France
 *
 *     $Id: lang_admin.php
 *
 ****************************************************************************/

/***************************************************************************
 *   English
 *   --------
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   Francais
 *   ----------
 *   Ce programme est un logiciel libre; vous pouvez les redistribuer
 *   et/ou le modifier tel que le prévoit la license GNU General Public License
 *   (GNU/GPL) publiée par la Fondation des logiciels libres (Free Software Foundation)
 *   Est appliquée la version 2 de la licence ou n'importe qu'elle version antérieure
 *   de votre choix.
 *
 ***************************************************************************/

//
// Traduction : phpBB France (http://www.phpbbfrance.org/)
//

//
// Login attempts configuration
//
$lang['Max_login_attempts'] = 'Nombre de tentatives de connexion autorisées';
$lang['Max_login_attempts_explain'] = 'Nombre maximum de tentatives de connexion qui, s\'il est dépassé, bloquera l\'utilisateur pendant le temps défini ci dessous.';
$lang['Login_reset_time'] = 'Temps de blocage';
$lang['Login_reset_time_explain'] = 'Nombre de minutes durant lesquelles l\'utilisateur ayant dépassé le nombre de tentatives de connexions autorisées devra patienter pour pouvoir se connecter de nouveau.';

//
// Format is same as lang_main
//

//
// Modules, this replaces the keys used
// in the modules[][] arrays in each module file
//
$lang['General'] = 'Administration générale';
$lang['Users'] = 'Utilisateurs';
$lang['Groups'] = 'Groupes';
$lang['Forums'] = 'Forums';
// xs'd
// $lang['Styles'] = 'Thèmes';

$lang['Configuration'] = 'Configuration';
$lang['Permissions'] = 'Permissions';
$lang['Manage'] = 'Gestion';
$lang['Disallow'] = 'Contrôle des noms interdits';
$lang['Prune'] = 'Délester';
$lang['Mass_Email'] = 'E-Mails multiples';
$lang['Ranks'] = 'Rangs';
$lang['Smilies'] = 'Emoticônes';
$lang['Ban_Management'] = 'Contrôle des exclusions';
$lang['Word_Censor'] = 'Censure';
$lang['Export'] = 'Exporter';
$lang['Create_new'] = 'Créer';
$lang['Add_new'] = 'Ajouter';
$lang['Backup_DB'] = 'Sauvegarder la base de données';
$lang['Restore_DB'] = 'Restaurer la base de données';
$lang['DB_Maintenance'] = 'Maintenance de la base de données';
$lang['Logos'] = 'Gérer les logos';

//
// Index
//
$lang['Admin'] = 'Administration';
$lang['Not_admin'] = 'Vous n\'êtes pas autorisé à administrer ce forum';
$lang['Welcome_phpBB'] = 'Bienvenue sur phpBB';
$lang['Admin_intro'] = 'Merci d\'avoir choisi phpBB comme système de forum. Cette page vous donnera un rapide aperçu des statistiques de votre forum. Vous pouvez y revenir en cliquant sur le lien <u>Index de l\'Administration</u> sur le panneau de gauche. Pour revenir à  l\'index de votre forum, cliquez sur le logo phpBB, lui aussi situé sur la panneau de gauche. Les autres liens situés à  gauche de cet écran vous permettront de paramétrer chaque aspect de votre forum. Chaque écran contiendra des instructions concernant la manière d\'utiliser les outils qu\'il propose.';
$lang['Main_index'] = 'Index du forum';
$lang['Forum_stats'] = 'Statistiques du forum';
$lang['Admin_Index'] = 'Index de l\'administration';
$lang['Preview_forum'] = 'Aperçu du forum';

$lang['Click_return_admin_index'] = 'Cliquez %sici%s pour retourner à  l\'index d\'administration';

$lang['Statistic'] = 'Statistiques';
$lang['Value'] = 'Valeur';
$lang['Number_posts'] = 'Nombre de messages ';
$lang['Posts_per_day'] = 'Messages par jour ';
$lang['Number_topics'] = 'Nombre de sujets ';
$lang['Topics_per_day'] = 'Sujets par jour ';
$lang['Number_users'] = 'Nombre d\'utilisateurs ';
$lang['Users_per_day'] = 'Utilisateurs par jour ';
$lang['Board_started'] = 'Création du forum ';
$lang['Avatar_dir_size'] = 'Taille du dossier des avatars ';
$lang['Database_size'] = 'Taille de la base de données ';
$lang['Gzip_compression'] ='Compression Gzip ';
$lang['Not_available'] = 'Indisponible';

$lang['ON'] = 'Activé'; // This is for GZip compression
$lang['OFF'] = 'Désactivé'; 


//
// DB Utils
//
$lang['Database_Utilities'] = 'Utilitaires pour la base de données';

$lang['Restore'] = 'Restaurer';
$lang['Backup'] = 'Sauvegarder';
$lang['Restore_explain'] = 'Cet utilitaire exécutera une restauration complète des tables phpBB à partir d\'un fichier. Si votre serveur le supporte, vous pouvez directement uploader un fichier compressé au format gzip. Il sera automatiquement décompressé. <br /><b>Attention !</b> Cette opération écrasera toutes les données existantes. Une restauration peut prendre un certain temps, veuillez patienter en restant sur cette page tant que l\'opération n\'est pas terminée.';
$lang['Backup_explain'] = 'Cet utilitaire vous permet de sauvegarder toutes les données relatives à phpBB. Si vous avez créé des tables additionnelles dans la même base de données et que vous souhaitez les sauvegarder, entrez leurs noms séparés par une virgule dans la zone \'Tables Additionnelles\' ci-dessous. Si votre serveur le supporte, vous pouvez également compresser votre fichier de sauvegarde au format gzip  avant de le télécharger';
$lang['Backup_options'] = 'Options de sauvegarde';
$lang['Start_backup'] = 'Démarrer la sauvegarde';
$lang['Full_backup'] = 'Sauvegarde complète';
$lang['Structure_backup'] = 'Sauvegarde de la structure uniquement';
$lang['Data_backup'] = 'Sauvegarde des données uniquement';
$lang['Additional_tables'] = 'Tables additionnelles';
$lang['Gzip_compress'] = 'Fichier compressé gzip';
$lang['Select_file'] = 'Choisissez un fichier';
$lang['Start_Restore'] = 'Commencer la restauration';

$lang['Restore_success'] = 'La base de données a été restaurée avec succès.<br /><br />Votre forum devrait être revenu dans l\'état dans lequel il était lors de la dernière sauvegarde.';
$lang['Backup_download'] = 'Le téléchargement va démarrer sous peu, attendez s\'il vous plait jusqu\'à ce qu\'il commence.';
$lang['Backups_not_supported'] = 'Désolé, mais les sauvegardes de base de données ne sont actuellement pas supportées par votre système.';

$lang['Restore_Error_uploading'] = 'Erreur lors du transfert de votre fichier';
$lang['Restore_Error_filename'] = 'Problème sur le nom du fichier, essayez un autre fichier s\'il vous plait';
$lang['Restore_Error_decompress'] = 'Impossible de décompresser le fichier gzip, essayez avec un fichier non compressé s\'il vous plait.';
$lang['Restore_Error_no_file'] = 'Aucun fichier n\'a été transféré';


//
// Auth pages
//
$lang['Select_a_User'] = 'Choisissez un utilisateur';
$lang['Select_a_Group'] = 'Choisissez un groupe';
$lang['Select_a_Forum'] = 'Choisissez un forum';
$lang['Auth_Control_User'] = 'Contrôle des permissions des utilisateurs'; 
$lang['Auth_Control_Group'] = 'Contrôle des permissions des groupes'; 
$lang['Auth_Control_Forum'] = 'Contrôle des permissions des forums'; 
$lang['Look_up_User'] = 'Rechercher un utilisateur'; 
$lang['Look_up_Group'] = 'Rechercher un groupe'; 
$lang['Look_up_Forum'] = 'Rechercher un forum'; 

$lang['Group_auth_explain'] = 'Cette page vous permet de modifier les permissions et statuts de modération pour chaque groupe d\'utilisateurs. N\'oubliez pas qu\'en modifiant les permissions de groupe, certaines permissions individuelles peuvent toutefois permettre à un utilisateur d\'accéder à un forum. Vous en serez informé, le cas échéant.';
$lang['User_auth_explain'] = 'Cette page vous permet de modifier les permissions et statuts de modération pour chaque utilisateur. N\'oubliez pas qu\'en modifiant des permisions individuelles, certaines permissions de groupe peuvent toutefois permettre à un utilisateur d\'accéder à un forum. Vous en serez informé le cas échéant.';
$lang['Forum_auth_explain'] = 'Cette page vous permet de modifier les permissions pour chaque forum. Vous disposez de deux modes : un mode simple et un mode avancé. Le mode avancé offre un plus grand choix de contrôles. N\'oubliez pas qu\'en modifiant les permissions des forums, les utilisateurs pourront en être affectés.';

$lang['Simple_mode'] = 'Mode simple';
$lang['Advanced_mode'] = 'Mode avancé';
$lang['Moderator_status'] = 'Statut des modérateurs';

$lang['Allowed_Access'] = 'Accès autorisé';
$lang['Disallowed_Access'] = 'Accès non autorisé';
$lang['Is_Moderator'] = 'Est modérateur';
$lang['Not_Moderator'] = 'N\'est pas modérateur';

$lang['Conflict_warning'] = 'Avertissement: Il y a un conflit d\'autorisation.';
$lang['Conflict_access_userauth'] = 'L\'utilisateur a toujours des droits d\'accès sur ce forum via les droits de groupe. Vous devriez peut être modifier les droits de groupe ou sortir l\'utilisateur du groupe afin de prévenir tout accès au forum concerné. Les groupes accordant des droits (et les forums impliqués) sont indiqués ci-dessous.';
$lang['Conflict_mod_userauth'] = 'L\'utilisateur a toujours des droits de modération pour ce forum via son groupe d\'appartenance. Vous devriez peut être modifier les droits de groupe ou sortir l\'utilisateur du groupe afin de prévenir tout accès au forum concerné. Les groupes accordant des droits (et les forums impliqués) sont indiqués ci-dessous.';

$lang['Conflict_access_groupauth'] = 'L\'utilisateur concerné a toujours des droits d\'accès au forum via ses paramètres d\'autorisation. Vous devriez peut être modifier ses paramètres d\'autorisation pour lui empècher d\avoir des droits d\accès. Les droits d\'accès utilisateur (et les forums concernés) sont indiqués ci-dessous.';
$lang['Conflict_mod_groupauth'] = 'L\'utilisateur suivant possède toujours des droits de modération sur le forum via ses paramètre d\'autorisation. Vous devriez peut être modifier ses paramètres d\'autorisation pour lui empècher d\'avoir des droits d\'accès. Les droits d\'accès utilisateur (et les forums concernés) sont indiqués ci-dessous.';

$lang['Public'] = 'Public';
$lang['Private'] = 'Privé';
$lang['Registered'] = 'Enregistré';
$lang['Administrators'] = 'Administrateurs';
$lang['Hidden'] = 'Caché';

// These are displayed in the drop down boxes for advanced
// mode forum auth, try and keep them short!
$lang['Forum_ALL'] = 'Tous';
$lang['Forum_REG'] = 'Membres';
$lang['Forum_PRIVATE'] = 'Privé';
$lang['Forum_MOD'] = 'Modérateurs';
$lang['Forum_ADMIN'] = 'Administrateurs';

$lang['View'] = 'Voir';
$lang['Read'] = 'Lire';
$lang['Post'] = 'Poster';
$lang['Reply'] = 'Répondre';
$lang['Edit'] = 'Editer';
$lang['Delete'] = 'Supprimer';
$lang['Sticky'] = 'Faire une note';
$lang['Announce'] = 'Annoncer'; 
$lang['Vote'] = 'Voter';
$lang['Pollcreate'] = 'Créer un sondage';

$lang['Permissions'] = 'Permissions';
$lang['Simple_Permission'] = 'Permissions simples';

$lang['User_Level'] = 'Niveau utilisateur'; 
$lang['Auth_User'] = 'Utilisateur';
$lang['Auth_Admin'] = 'Administrateur';
$lang['Group_memberships'] = 'Composition des groupes d\'utilisateurs';
$lang['Usergroup_members'] = 'Ce groupe est composé des membres suivants';

$lang['Forum_auth_updated'] = 'Permissions du forum mises à jour';
$lang['User_auth_updated'] = 'Permissions de l\'utilisateur mises à jour';
$lang['Group_auth_updated'] = 'Permissions de groupe mises à jour';

$lang['Auth_updated'] = 'Les permissions ont été mises à jour';
$lang['Click_return_userauth'] = 'Cliquez %sici%s pour retourner aux permissions utilisateurs';
$lang['Click_return_groupauth'] = 'Cliquez %sici%s pour retourner aux permissions de groupe';
$lang['Click_return_forumauth'] = 'Cliquez %sici%s pour retourner aux permissions des forums';


//
// Banning
//
$lang['Ban_control'] = 'Contrôle des exclusions';
$lang['Ban_explain'] = 'Cette page vous permet de contrôler l\'exclusion des utilisateurs. Vous pouvez exclure un utilisateur spécifique ou toute une plage d\'adresses IP ou de noms de serveur (ou de domaine). Ces deux méthodes empêcheront purement et simplement un utilisateur d\'accéder à la page d\'accueil du forum. Pour empêcher un utilisateur de s\'enregistrer sous un autre nom, vous pouvez également exclure son e-mail. Veuillez noter qu\'exclure uniquement l\'adresse e-mail n\'empechera pas un utilisateur de se connecter et de poster. Pour cela, vous devrez utiliser une des deux premières méthodes d\'exclusion citées ci-dessus.';
$lang['Ban_explain_warn'] = 'Veuillez noter qu\'entrer un intervalle d\'adresses IP aura pour résultat de prendre en compte toutes les adresses entre l\'IP de départ et l\'IP de fin dans la liste d\'exclusion. Des essais seront effectués afin de réduire le nombre d\'adresses IP ajoutées à la base de données en introduisant des jokers automatiquement aux endroits appropriés. Si vous devez réellement entrer un intervalle, essayez de le garder réduit ou au mieux, fixez des adresses spécifiques.';

$lang['Select_username'] = 'Choisissez un nom d\'utilisateur';
$lang['Select_ip'] = 'Choisissez une adresse IP';
$lang['Select_email'] = 'Choisissez une adresse e-mail';

$lang['Ban_username'] = 'Exclure un ou plusieurs utilisateurs spécifiques';
$lang['Ban_username_explain'] = 'Vous pouvez exclure plusieurs utilisateurs en une seule opération en utilisant les sélections multiples avec le clavier et la souris (en général ctrl+clic)';

$lang['Ban_IP'] = 'Exclure une ou plusieurs adresses IP et noms d\'hôte';
$lang['IP_hostname'] = 'Adresses IP et noms d\'hôtes';
$lang['Ban_IP_explain'] = 'Pour spécifier plusieurs adresses IP différentes ou plusieurs noms de serveur/domaine, utiliser des virgules comme séparateur. Pour spécifier une plage d\'adresses IP, utilisez le tiret (-) pour séparer le début et la fin de la plage; utilisez l\'astérisque (*) pour utiliser un joker.';


$lang['Ban_email'] = 'Exclure une ou plusieurs adresses e-mail';
$lang['Ban_email_explain'] = 'Pour spécifier plus d\'une adresse e-mail, séparez les avec des virgules, Pour utiliser un joker, utilisez un astérisque, exemple: *@hotmail.com.';

$lang['Unban_username'] = 'Accepter à nouveau un ou plusieurs utilisateurs';
$lang['Unban_username_explain'] = 'Vous pouvez accepter à nouveau plusieurs utilisateurs d\'un coup en utilisant la bonne combinaison des touches configurées pour votre clavier et navigateur (en général ctrl+clic)';

$lang['Unban_IP'] = 'Accepter à nouveau une ou plusieurs adresses IP';
$lang['Unban_IP_explain'] = 'Vous pouvez accepter à nouveau une ou plusieurs adresses IP d\'un coup en utilisant la bonne combinaison des touches configurées pour votre clavier et navigateur (en général ctrl+clic)';

$lang['Unban_email'] = 'Accepter à nouveau une ou plusieurs adresses e-mail';
$lang['Unban_email_explain'] = 'Vous pouvez accepter à nouveau une ou plusieurs adresses e-mail d\'un coup en utilisant la bonne combinaison des touches configurées pour votre clavier et navigateur (en général ctrl+clic)';

$lang['No_banned_users'] = 'Aucun nom d\'utilisateur exclu';
$lang['No_banned_ip'] = 'Aucune adresse IP exclue';
$lang['No_banned_email'] = 'Aucune adresse e-mail exclue';

$lang['Ban_update_sucessful'] = 'La liste d\'exclusion à été mise à jour correctement.';
$lang['Click_return_banadmin'] = 'Cliquez %sici%s pour retourner au panneau de contrôle des exclusionss';


//
// Configuration
//
$lang['General_Config'] = 'Configuration générale';
$lang['Config_explain'] = 'Cette page vous permet de personnaliser toutes les options générales du forum. Pour personnaliser les options relatives aux utilisateurs ou aux rubriques, veuillez utiliser les liens appropriés dans le menu de gauche.';
$lang['Click_return_config'] = 'Cliquez %sici%s pour retourner à la configuration générale.';

$lang['General_settings'] = 'Configuration générale du forum';
$lang['Server_name'] = 'Nom de domaine';
$lang['Server_name_explain'] = 'Le nom de domaine sur lequel le forum est installé';
$lang['Script_path'] = 'Chemin du script';
$lang['Script_path_explain'] = 'Le chemin où phpBB2 est situé relativement à la racine du domaine';
$lang['Server_port'] = 'Port du serveur';
$lang['Server_port_explain'] = 'Le port sur lequel votre serveur est établi, classiquement le port 80. Ne changez cette valeur que si c\'est nécessaire';
$lang['Site_name'] = 'Nom du site';
$lang['Site_desc'] = 'Description du site';
$lang['Acct_activation'] = 'Activer la validation des comptes';
$lang['Acc_None'] = 'Aucune';  // These three entries are the type of activation
$lang['Acc_User'] = 'Utilisateur';
$lang['Acc_Admin'] = 'Administrateur';

$lang['Abilities_settings'] = 'Options de base des utilisateurs et du forum';
$lang['Max_poll_options'] = 'Nombre maximum de choix dans les sondages';
$lang['Flood_Interval'] = 'Intervalle de flood';
$lang['Flood_Interval_explain'] = 'Nombre de secondes d\'attente entre chaque message posté'; 
$lang['Board_email_form'] = 'Messagerie e-mail via le forum';
$lang['Board_email_form_explain'] = 'Les utilisateurs peuvent s\'envoyer des e-mails via le forum';
$lang['Topics_per_page'] = 'Nombre de sujets par page';
$lang['Posts_per_page'] = 'Nombre de messages par page';
$lang['Hot_threshold'] = 'Nombre de messages pour qu\'un sujet soit \'populaire\'';

$lang['Default_style'] = 'Thème par défaut';
$lang['Override_style'] = 'Imposer un thème aux utilisateurs';
$lang['Override_style_explain'] = 'Remplace le thème choisi par l\'utilisateur par le thème par défaut';
$lang['Default_language'] = 'Langue par défaut';
$lang['Date_format'] = 'Format de la date';
$lang['System_timezone'] = 'Fuseau horaire';
$lang['Enable_gzip'] = 'Activer la compression GZip';
$lang['Enable_prune'] = 'Activer le délestage du forum';
$lang['Topics_on_index'] = 'Nombre de topics à montrer dans les derniers topics sur l\'index.';
$lang['Allow_HTML'] = 'Autoriser le HTML (non recommandé)';
$lang['Allow_BBCode'] = 'Autoriser le BBCode';
$lang['Allowed_tags'] = 'Balises HTML admises';
$lang['Allowed_tags_explain'] = 'Utilisez des virgules pour séparer les balises admises';
$lang['Allow_smilies'] = 'Autoriser les emôticones';
$lang['Smilies_path'] = 'Chemin de stockage des émoticônes';
$lang['Smilies_path_explain'] = 'Chemin à partir de la racine phpBB, ex: images/smiles';
$lang['Allow_sig'] = 'Autoriser les signatures';
$lang['Max_sig_length'] = 'Longueur maximum des signatures';
$lang['Max_sig_length_explain'] = 'Nombre maximum de caractères dans les signatures utilisées par les utilisateurs';
$lang['Allow_name_change'] = 'Autoriser les changements de nom d\'utilisateur';
//BEGIN ACP Site Announcement Centre by lefty74
$lang['Announcements'] = 'Annonces';
$lang['Announcement_text'] = 'Texte Annonce';
$lang['Announcement_text_explain'] = 'Entrez l\'ID du forum ou du topic pour utiliser le premier ou le dernier post en tant qu\'annonce. La hierarchie du texte d\'annonce est définie comme suit :</br>1. ID du Forum. Si aucune ID, alors :</br>2. ID du Topic. Si aucune ID, alors :</br>3. Texte d\'annonce personnalisée';
$lang['Announcement_guest_text'] = 'Annonces pour les invités seulement';
$lang['Announcement_main_title'] = 'Configuration de l\'annonce du site';
$lang['Announcement_main_title_explain'] = 'Vous pouvez choisir qui verra ces annonces. Vous pouvez également disposer d\'annonces alternatives pour les invités.';
$lang['Announcement_block_title'] = 'ACP Centre d\'annonce';
$lang['Announcement_draft_text'] = 'Ebauche d\'annonce';
$lang['Announcement_draft_text_explain'] = 'Faites une ébauche de votre annonce en utilisant les smilies et bbcodes. Une fois votre annonce prête, copiez la et collez la dans le champs approprié du texte d\'annonce';
$lang['Show_announcement_text'] = 'Montrez l\'annonce du site';
$lang['Select_all'] = 'Sélection';
$lang['Copy_to_Announcement'] = 'Annonce du site';
$lang['Copy_to_Guest_Announcement'] = 'Annonce pour les invités';
$lang['Submit'] = 'Soumettre';
$lang['Reset'] = 'Réinitialiser';
$lang['Yes'] = 'Oui';
$lang['No'] = 'Non';
$lang['Show_announcement_all'] = 'Tout le monde';
$lang['Show_announcement_reg'] = 'Membres enregistrés';
$lang['Show_announcement_mod'] = 'Modérateurs';
$lang['Show_announcement_adm'] = 'Administrateurs';
$lang['Show_announcement_who'] = 'Montrez l\'annonce du site à';
$lang['Announcement_guests_only'] = 'Montrez une annonce différente aux invités';
$lang['Announcement_guests_only_explain'] = 'Montrez une annonce différente aux invités sauf si l\'annonce du site est autorisée pour tous. </br></br>';
$lang['Announcement_updated'] = 'La configuration de l\'annonce du site a été mise à jour avec succès';
$lang['Announcement_draft_updated'] = 'Prévisualisation générée avec succès !';
$lang['Click_return_announcement'] = 'Cliquez %sIci%s pour revenir à la configuration de l\'annonce du site';
$lang['Forum_ID'] = 'ID du Forum';
$lang['Topic_ID'] = 'ID du Topic';
$lang['Announcement_forum_topic_latest'] = 'Dernier post';
$lang['Announcement_forum_topic_first'] = 'Premier post';
$lang['Announcement_title'] = 'Titre de l\'annonce';
$lang['Announcement_title_explain'] = 'Personnalisez ici le titre de l\'annonce';
$lang['Announcement_guest_title'] = 'Titre de l\'annonce pour les invités';
$lang['Announcement_guest_title_explain'] = 'Personnalisez ici le titre de l\'annonce pour les invités';
$lang['Announcement_default_title_explain'] = 'La variable de langue par défaut pour le titre du bloc est : ';
//END ACP Site Announcement Centre by lefty74

$lang['Avatar_settings'] = 'Paramètres des avatars';
$lang['Allow_local'] = 'Activer la galerie d\'avatars';
$lang['Allow_remote'] = 'Autoriser les avatars distants';
$lang['Allow_remote_explain'] = 'Les avatars sont liés à partir d\'une autre adresse.';
$lang['Allow_upload'] = 'Autoriser l\'upload d\'avatar';
$lang['Max_filesize'] = 'Taille maximum des fichiers d\'avatar';
$lang['Max_filesize_explain'] = 'Pour les fichiers d\'avatar uploadés';
$lang['Max_avatar_size'] = 'Dimensions maximales des avatars';
$lang['Max_avatar_size_explain'] = '(hauteur x largeur en pixels)';
$lang['Avatar_storage_path'] = 'Chemin de stockage des avatars';
$lang['Avatar_storage_path_explain'] = 'Chemin à partir de la racine phpBB, ex: images/avatars';
$lang['Avatar_gallery_path'] = 'Chemin de la galerie d\'avatars';
$lang['Avatar_gallery_path_explain'] = 'Chemin à partir de la racine phpBB pour les avatars pré-établis, ex: images/avatars/galerie';

$lang['COPPA_settings'] = 'Configuration COPPA';
$lang['COPPA_fax'] = 'Numéro de fax COPPA';
$lang['COPPA_mail'] = 'Adresse postale COPPA';
$lang['COPPA_mail_explain'] = 'Adresse à laquelle les parents enverront leur formulaire COPPA';

$lang['Email_settings'] = 'Configuration des e-mails';
$lang['Admin_email'] = 'Adresse e-mail de l\'administrateur';
$lang['Email_sig'] = 'Signature des e-mails';
$lang['Email_sig_explain'] = 'Ce texte sera ajouté en bas des e-mails envoyés via le forum';
$lang['Use_SMTP'] = 'Utiliser un serveur SMTP pour les e-mails';
$lang['Use_SMTP_explain'] = 'Cochez oui si vous souhaitez envoyer les e-mails via un serveur SMTP plutôt que par la fonction mail() locale.';
$lang['SMTP_server'] = 'Adresse du serveur SMTP';
$lang['SMTP_username'] = 'Nom d\'utilsateur SMTP';
$lang['SMTP_username_explain'] = 'Entrez un nom d\'utilisateur seulement si vous serveur SMTP en requiert un';
$lang['SMTP_password'] = 'Mot de passe SMTP';
$lang['SMTP_password_explain'] = 'Entrez un mot de passe seulement si vous serveur SMTP en requiert un';

$lang['Disable_privmsg'] = 'Messages privés';
$lang['Inbox_limits'] = 'Nombre maximum de messages dans la boîte privée';
$lang['Sentbox_limits'] = 'Nombre maximum de messages dans la boîte d\'envoi';
$lang['Savebox_limits'] = 'Nombre maximum de messages dans la boîte de sauvegarde';

$lang['Cookie_settings'] = 'Configuration des cookies'; 
$lang['Cookie_settings_explain'] = 'Ces détails définissent la manière dont les cookies sont envoyés sur l\'ordinateur de vos utilisateurs. Dans la plupart des cas, la valeur par défaut sera adaptée. La modification de ces valeurs est recommandé aux utilisateurs avertis : la saisie de valeurs erronées pourrait empêcher vos utilisateurs de se connecter au forum.';

$lang['Cookie_domain'] = 'Domaine du cookie';
$lang['Cookie_name'] = 'Nom du cookie';
$lang['Cookie_path'] = 'Chemin du cookie';
$lang['Cookie_secure'] = 'Cookie securisé';
$lang['Cookie_secure_explain'] = 'Si votre serveur possède une extension SSL, activez cette option, sinon laissez la telle quelle.';
$lang['Session_length'] = 'Durée de la session [ en secondes ]';


// Visual Confirmation

$lang['Visual_confirm'] = 'Activer la confirmation visuelle';
$lang['Visual_confirm_explain'] = 'Oblige les utilisateurs à saisir un code défini par une image à l\'enregistrement.';

// Autologin Keys - added 2.0.18
$lang['Allow_autologin'] = 'Autoriser les connexions automatiques';
$lang['Allow_autologin_explain'] = 'Détermine si les utilisateurs du forum peuvent utiliser l\'option de connexion automatique';
$lang['Autologin_time'] = 'Expiration de la clef de connexion automatique';
$lang['Autologin_time_explain'] = 'Nombre de jours durant laquelle la clef de connexion automatique reste valide. Mettre 0 pour désactiver l\'expiration de clefs.';

// Search Flood Control - added 2.0.20
$lang['Search_Flood_Interval'] = 'Intervalle de flood de la recherche';
$lang['Search_Flood_Interval_explain'] = 'Temps en secondes qu\'un utilisateur doit attendre entre deux recherches';

//
// Forum Management
//

$lang['Forum_admin'] = 'Administration des forums';
$lang['Forum_admin_explain'] = 'Vous pouvez ajouter, supprimer, éditer, réordonner et resynchroniser les catégories et les forums depuis cette page';
$lang['Edit_forum'] = 'Éditer un forum';
$lang['Create_forum'] = 'Créer un nouveau forum';
$lang['Create_category'] = 'Créer une nouvelle catégorie';
$lang['Remove'] = 'Enlever';
$lang['Action'] = 'Action';
$lang['Update_order'] = 'Mettre à jour l\'ordre';
$lang['Config_updated'] = 'La configuration du forum a été correctement mise à jour';
$lang['Edit'] = 'Éditer';
$lang['Delete'] = 'Supprimer';
$lang['Move_up'] = 'Monter';
$lang['Move_down'] = 'Descendre';
$lang['Resync'] = 'Resynchroniser';
$lang['No_mode'] = 'Aucun mode n\'a été défini';
$lang['Forum_edit_delete_explain'] = 'Le formulaire ci-dessous vous permet de modifier les options générales du forum. Pour la configuration de utilisateurs et des forums, veuillez utiliser les liens relatifs dans le volet de gauche.';
$lang['Move_contents'] = 'Déplacer tout le contenu vers';
$lang['Forum_delete'] = 'Supprimer un forum';
$lang['Forum_delete_explain'] = 'Le formulaire ci-dessous vous permet de supprimer un forum (ou une catégorie) et de choisir l\'endroit où vous souhaitez déplacer les sujets (ou forums) qu\'il contient.';
$lang['Status_locked'] = 'Verrouillé';
$lang['Status_unlocked'] = 'Déverrouillé';
$lang['Forum_settings'] = 'Options générales des forums';
$lang['Forum_name'] = 'Nom du forum';
$lang['Forum_desc'] = 'Description';
$lang['Forum_status'] = 'Statut du forum';
$lang['Forum_icon'] = 'Icône du forum'; // Forum Icon MOD
$lang['Forum_icon_path'] = 'Chemin du stockage de l\'icône du forum'; // Forum Icon MOD
$lang['Forum_icon_path_explain'] = 'Chemin depuis le répertoire de vôtre forum phpBB, comme par exemple ceci : images/forum_icons'; // Forum Icon MOD
$lang['Forum_pruning'] = 'Auto-délestage';
$lang['prune_freq'] = 'Vérifier l\'âge des sujets tous les ';
$lang['prune_days'] = 'Supprimer les sujets n\'ayant pas eu de réponses depuis';
$lang['Set_prune_data'] = 'Vous avez activer l\'auto-délestage pour ce forum mais n\'avez pas défini une fréquence ou un nombre de jours à délester. Veuillez revenir en arrière et le faire.';
$lang['Move_and_Delete'] = 'Déplacer et supprimer';
$lang['Delete_all_posts'] = 'Supprimer tous les messages';
$lang['Nowhere_to_move'] = 'Nulle part où déplacer';
$lang['Edit_Category'] = 'Éditer une catégorie';
$lang['Edit_Category_explain'] = 'Utilisez ce formulaire pour modifer le nom d\'une catégorie.';
$lang['Forums_updated'] = 'Les informations du forum et de la catégorie ont été correctement mise à jour';

$lang['Must_delete_forums'] = 'Vous devez supprimer tous les forums avant de pouvoir supprimer cette catégorie';
$lang['Click_return_forumadmin'] = 'Cliquez %sici%s pour revenir à l\'administration des forums';


//
// Smiley Management
//
$lang['smiley_title'] = 'Gestion des émoticônes';
$lang['smile_desc'] = 'Vous pouvez ajouter, supprimer et éditer les émoticons ou les émoticônes que vos utilisateurs peuvent utiliser dans leurs messages et dans leurs messages privés depuis cette page.';
$lang['smiley_config'] = 'Configuration des émoticônes';
$lang['smiley_code'] = 'Code de l\'émoticône';
$lang['smiley_url'] = 'Fichier image de l\'émoticône';
$lang['smiley_emot'] = 'Emoticône';
$lang['smile_add'] = 'Ajouter un nouvel émoticône';
$lang['Smile'] = 'Image';
$lang['Emotion'] = 'Emoticône';
$lang['Select_pak'] = 'Sélectionnez un fichier pack (.pak)';
$lang['replace_existing'] = 'Remplacer les émoticônes existants';
$lang['keep_existing'] = 'Conserver les émoticônes existants';
$lang['smiley_import_inst'] = 'Vous devez décompresser le pack d\'émoticônes et uploader tous les fichiers dans le répertoire approprié pour l\'installation. Ensuite complétez correctement les informations du formulaire pour importer votre pack.';
$lang['smiley_import'] = 'Importer un pack d\'émoticônes';
$lang['choose_smile_pak'] = 'Choisir un pack d\'émoticônes (fichier .pak)';
$lang['import'] = 'Importer les émoticônes';
$lang['smile_conflicts'] = 'Que faire en cas de conflits ?';
$lang['del_existing_smileys'] = 'Supprimer les émoticônes existants avant l\'importation';
$lang['import_smile_pack'] = 'Importer un pack d\'émoticônes';
$lang['export_smile_pack'] = 'Créer un pack de émoticônes';
$lang['export_smiles'] = 'Pour créer un pack d\'émoticônes à partir de vos émoticônes actuellement installés, cliquez %sici%s pour télécharger le fichier smiles.pak. Renommez-le si besoin est en prennant soin de concerver l\'extension .pak. Créez ensuite un fichier zip contenant toutes les images de vos émoticônes, ainsi que le fichier de configuration (.pak).';
$lang['smiley_add_success'] = 'L\'émoticône a bien été ajouté';
$lang['smiley_edit_success'] = 'L\'émoticône a été correctement mis à jour';
$lang['smiley_import_success'] = 'Le pack d\'émoticône a été correctement importé !';
$lang['Confirm_delete_smiley'] = 'Êtes-vous sûr de vouloir supprimer ce smiley ?';
$lang['smiley_del_success'] = 'L\'émoticône a bien été supprimé';
$lang['Click_return_smileadmin'] = 'Cliquez %sici%s pour revenir à la gestion des émoticônes';

//
// User Management
//
$lang['User_admin'] = 'Administration des utilisateurs';
$lang['User_admin_explain'] = 'Vous pouvez changer ici les informations des utilisateurs et certaines options spécifiques. Pour modifier les permissions des utilisateurs, veuillez utiliser les systèmes de permissions des utilisateurs et de groupes.';
$lang['Look_up_user'] = 'Rechercher l\'utilisateur';
$lang['Admin_user_fail'] = 'Impossible de mettre à jour le profil de l\'utilisateur.';
$lang['Admin_user_updated'] = 'Le profil de l\'utilisateur a été correctement mis à jour.';
$lang['Click_return_useradmin'] = 'Cliquez %sici%s pour revenir à l\'administration des utilisateurs';
$lang['User_delete'] = 'Supprimer cet utilisateur';
$lang['User_delete_explain'] = 'Cliquez ici pour supprimer l\'utilisateur. Attention, cette opération est irréversible !';
$lang['User_deleted'] = 'L\'utilisateur a bien été supprimé.';
$lang['User_status'] = 'L\'utilisateur est actif';
$lang['User_allowpm'] = 'L\'utilisateur peut envoyer des messages privés';
$lang['User_allowavatar'] = 'L\'utilisateur peut afficher un avatar';
$lang['Admin_avatar_explain'] = 'Vous pouvez voir et supprimer l\'avatar actuel de l\'utilisateur ici.';
$lang['User_special'] = 'Champs réservés à l\'administration uniquement';
$lang['User_special_explain'] = 'Ces champs ne sont pas modifiables par les utilisateurs. Vous pouvez y définir leur statut ainsi que diverses options non données aux utilisateurs.';

//
// Group Management
//

$lang['Group_administration'] = 'Administration des groupes';
$lang['Group_admin_explain'] = 'Depuis cette page, vous pouvez administrer tous les groupes. Il est possible de supprimer, ajouter et éditer les groupes existants. Vous pouvez choisir des modérateurs, définir le statut (ouvert, fermé ou invisible) ainsi que les noms et descriptions des groupes';
$lang['Error_updating_groups'] = 'Une erreur s\'est produite lors de la mise à jour des groupes';
$lang['Updated_group'] = 'Le groupe a été correctement mis à jour';
$lang['Added_new_group'] = 'Le nouveau groupe a bien été créé';
$lang['Deleted_group'] = 'Le groupe a bien été supprimé';
$lang['New_group'] = 'Créer un nouveau groupe';
$lang['Edit_group'] = 'Editer un groupe';
$lang['group_name'] = 'Nom du groupe';
$lang['group_description'] = 'Description du groupe';
$lang['group_moderator'] = 'Modérateur du groupe';
$lang['group_status'] = 'Statut du groupe';
$lang['group_open'] = 'Groupe ouvert';
$lang['group_closed'] = 'Groupe fermé';
$lang['group_hidden'] = 'Groupe invisible';
$lang['group_delete'] = 'Supprimer le groupe';
$lang['group_delete_check'] = 'Cochez cette case pour supprimer le groupe';
$lang['submit_group_changes'] = 'Soumettre les modifications';
$lang['reset_group_changes'] = 'Remettre à zéro';
$lang['No_group_name'] = 'Vous devez préciser un nom pour ce groupe';
$lang['No_group_moderator'] = 'Vous devez préciser un modérateur pour ce groupe';
$lang['No_group_mode'] = 'Vous devez préciser le statut du groupe : ouvert, fermé ou invisible';
$lang['No_group_action'] = 'Aucune action n\'a été spécifiée';
$lang['delete_group_moderator'] = 'Supprimer l\'ancien modérateur du groupe ?';
$lang['delete_moderator_explain'] = 'Si vous changez le modérateur du groupe, cochez cette case pour que l\'ancien modérateur ne soit plus dans le groupe. Autrement, vous pouvez ne pas la cocher et il deviendra simplement membre du groupe.';
$lang['Click_return_groupsadmin'] = 'Cliquez %sici%s pour revenir à l\'administration des groupes.';
$lang['Select_group'] = 'Sélectionner un groupe';
$lang['Look_up_group'] = 'Rechercher un groupe';


//
// Prune Administration
//
$lang['Forum_Prune'] = 'Délestage des forums';
$lang['Forum_Prune_explain'] = 'Cette opération va supprimer tous les sujets n\'ayant pas eu de réponses depuis x jour(s), où vous avez choisi x. Si vous ne choisissez pas de nombre x, tous les sujets seront supprimés. En revanche, cela ne supprimera pas les sujets dans lesquels un sondage est encore en cours, ni les annonces. Vous devrez supprimer vous-même ces sujets.';
$lang['Do_Prune'] = 'Délester';
$lang['All_forums'] = 'Tous les forums';
$lang['Prune_topics_not_posted'] = 'Délester les sujets n\'ayant pas eu de réponses depuis '; // La phrase n'est volontairement pas finie afin de laisser la case à remplir, puis jour
$lang['Topics_pruned'] = 'Sujets délestés';
$lang['Posts_pruned'] = 'Messages délestés';
$lang['Prune_success'] = 'Le délestage des forums a été correctement effectué';

//
// Word censor
//
$lang['Words_title'] = 'Censure du contenu';
$lang['Words_explain'] = 'Vous pouvez ajouter, éditer et supprimer les mots qui seront automatiquement censurés sur vos forums depuis cette page. De plus, les utilisateurs ne pourront s\'enregistrer avec des noms contenant ces mots. Les jokers (*) sont acceptés. Par exemple, le mot *test* va prendre en compte le mot detestable, test* va prendre en compte le mot tester et *test va prendre en compte le mot psychotest.';
$lang['Word'] = 'Mot';
$lang['Edit_word_censor'] = 'Editer le mot à censurer';
$lang['Replacement'] = 'Remplacer par';
$lang['Add_new_word'] = 'Ajouter un nouveau mot';
$lang['Update_word'] = 'Mettre à jour le mot à censurer';
$lang['Must_enter_word'] = 'Vous devez entrer un mot ainsi que son remplaçant';
$lang['No_word_selected'] = 'Aucun mot n\'a été selectionné pour l\'édition';
$lang['Word_updated'] = 'Le mot à censurer sélectionné a été correctement mis à jour';
$lang['Word_added'] = 'Le mot à censurer a bien été ajouté';
$lang['Word_removed'] = 'Le mot à censurer a bien été supprimé';
$lang['Click_return_wordadmin'] = 'Cliquez %sici%s pour revenir à la censure du contenu';
$lang['Confirm_delete_word'] = 'Êtes-vous sûr de vouloir supprimer ce mot censuré ?';
//
// Mass Email
//
$lang['Mass_email_explain'] = 'Cette page vous permet d\'envoyer des e-mails à tous vos utilisateurs ou à tous les utilisateurs d\'un groupe spécifique. Pour ce faire, un e-mail sera envoyé à l\'administrateur, et chaque destinataire recevra une copie cachée. Lors de l\'envoi d\'un e-mail à un grand nombre de personnes, veuillez patienter  et ne pas interrompre le chargement de la page. L\'envoi d\'e-mail en masse peut, en effet, prendre un peu de temps, vous serez averti dès la fin de l\'opération.';
$lang['Compose'] = 'Rédiger'; 
$lang['Recipients'] = 'Destinataires'; 
$lang['All_users'] = 'Tous les utilisateurs';
$lang['Email_successfull'] = 'Votre message a été envoyé';
$lang['Click_return_massemail'] = 'Cliquez %sici%s pour revenir au formulaire d\'envoi d\'e-mails de masse';

//
// Ranks admin
//
$lang['Ranks_title'] = 'Administration des rangs';
$lang['Ranks_explain'] = 'Vous pouvez voir, ajouter, éditer et supprimer les rangs sur cette page. Vous pouvez aussi créer des rangs personnalisés qui seront assignés aux utilisateurs via l\'outil de gestion des utilisateurs';
$lang['Add_new_rank'] = 'Ajouter un nouveau rang';
$lang['Rank_title'] = 'Nom du rang';
$lang['Rank_special'] = 'Définir en tant que rang spécial';
$lang['Rank_minimum'] = 'Messages minimum';
$lang['Rank_maximum'] = 'Messages maximum';
$lang['Rank_image'] = 'Url de l\'image associée au rang';
$lang['Rank_img'] = 'Image du Rang';
$lang['Rank_image_explain'] = '(relative au chemin de phpBB)';
$lang['Must_select_rank'] = 'Vous devez sélectionner un rang';
$lang['No_assigned_rank'] = 'Aucun rang spécial assigné';
$lang['Rank_updated'] = 'Le rang a été correctement mis à jour';
$lang['Rank_added'] = 'Le rang a bien été ajouté';
$lang['Rank_removed'] = 'Le rang a bien été supprimé';
$lang['No_update_ranks'] = 'Le rang a bien été supprimé, toutefois les comptes des utilisateurs ayant ce rang n\'ont pas été mis à jour. Vous devrez modifier le rang de chacun de ces utilisateurs manuellement';
$lang['Click_return_rankadmin'] = 'Cliquez %sici%s pour revenir à l\'administration des rangs';
$lang['Confirm_delete_rank'] = 'Êtes-vous sûr de vouloir supprimer ce rang ?';
$lang['Rank_tags'] = 'Rank Tags';
$lang['Rank_tags_explain'] = 'Entrer le tag de début dans le 1er champ et le tag de fin dans le second.';


//
// Disallow Username Admin
//
$lang['Disallow_control'] = 'Panneau de restriction des noms d\'utilisateurs';
$lang['Disallow_explain'] = 'Cette page vous permet de gérer les noms d\'utilisateurs interdit à l\'usage. Les noms d\'utilisateurs interdits peuvent contenir des jokers (*). Veuillez noter qu\'il est impossible d\'interdire le nom d\'un utilisateur déjà enregistré. Vous devrez préalablement supprimer le compte de cet utilisateur avant d\'en interdire le nom.';
$lang['Delete_disallow'] = 'Supprimer';
$lang['Delete_disallow_title'] = 'Supprimer un nom d\'utilisateur interdit';
$lang['Delete_disallow_explain'] = 'Vous pouvez supprimer un nom d\'utilisateur interdit en le sélectionnant dans la liste puis en cliquant sur \'Supprimer\'';
$lang['Add_disallow'] = 'Ajouter';
$lang['Add_disallow_title'] = 'Ajouter un nom d\'utilisateur interdit';
$lang['Add_disallow_explain'] = 'Vous pouvez interdire un nom d\'utilisateur en utilisant des jokers (*) pour remplacer n\'importe quel caractère';
$lang['No_disallowed'] = 'Aucun nom d\'utilisateur interdit';
$lang['Disallowed_deleted'] = 'Le nom d\'utilisateur interdit a été correctement supprimé';
$lang['Disallow_successful'] = 'Le nom d\'utilisateur interdit a bien été ajouté';
$lang['Disallowed_already'] = 'Le nom que vous avez entré ne peut être interdit. Soit il existe déjà dans la liste des noms d\'utilisateurs interdit, soit il figure dans la liste des mots censurés, soit il est actuellement utilisé par un utilisateur enregistré.';
$lang['Click_return_disallowadmin'] = 'Cliquez %sici%s pour revenir au panneau de restriction des noms d\'utilisateurs';


//
// Styles Admin
//
$lang['Styles_admin'] = 'Administration des thèmes';
$lang['Styles_explain'] = 'Cette page vous permet d\'ajouter, supprimer et gérer les styles (modèles de documents et thèmes) disponibles auprès des utilisateurs';
$lang['Styles_addnew_explain'] = 'La liste suivante contient tous les thèmes qui sont disponibles dans votre dossier /templates, et non installés. Pour installer un thème, cliquez simplement sur le lien installer à côté du nom du thème.';
$lang['Select_template'] = 'Sélectionner un modèle de document';
$lang['Style'] = 'Thème';
$lang['Template'] = 'Modèle de document';
$lang['Install'] = 'Installer';
$lang['Download'] = 'Télécharger';
$lang['Edit_theme'] = 'Editer un thème';
$lang['Edit_theme_explain'] = 'Vous pouvez modifier les réglages du thème sélectionné dans le formulaire suivant';
$lang['Create_theme'] = 'Créer un thème';
$lang['Create_theme_explain'] = 'Utilisez le formulaire ci-dessous pour créer un nouveau thème pour le modèle de document sélectionné. Lorsque vous entrez une couleur (le code hexadécimal est impératif) vous ne devrez pas inclure le # initial. Autrement dit : CCCCCC est valide, #CCCCCC ne l\'est pas';
$lang['Export_themes'] = 'Exporter des thèmes';
$lang['Export_explain'] = 'Cette page vous permet d\'exporter les informations d\'un thème pour le modèle de document sélectionné. Selectionnez un modèle de document depuis la liste ci-dessous et un fichier de configuration du thème sera créé et sauvegardé dans le dossier du modèle de document. Si le fichier de configuration ne peut être sauvegardé, il vous sera proposé de le télécharger. Pour permettre la sauvegarde du fichier, vous devez donner les droits d\'écriture sur le répertoire du thème (chmod 666 minimum). Pour plus de renseignements, consultez le guide des utilisateurs de phpBB 2.';
$lang['Theme_installed'] = 'Le thème sélectionné a été correctement installé';
$lang['Style_removed'] = 'Le thème sélectionné a bien été supprimé de la base de données. Pour le supprimer totalement vous devez effacer les fichiers contenus dans le répertoire du modèle de document.';
$lang['Theme_info_saved'] = 'Les informations du thème pour le modèle de document sélectionné ont été correctement sauvegardées. Vous devriez dès à présent remettre les permissions du fichier theme_info.cfg (et si possible celle du répertoire du modèle de document selectionné) en lecture seule';
$lang['Theme_updated'] = 'Le thème sélectionné a été correctement mis à jour. Vous devriez dès à présent exporter les nouveaux paramètres du thème';
$lang['Theme_created'] = 'Le thème a bien été crée. Vous devriez dès à présent exporter le thème vers un fichier de configuration de thème afin de le conserver en lieu sur ou de le réutiliser plus tard.';
$lang['Confirm_delete_style'] = 'Voulez-vous vraiment supprimer ce thème ?';
$lang['Download_theme_cfg'] = 'Le script d\'exportation ne peut pas écrire le fichier d\'information du thème. Cliquez sur le bouton ci-dessous pour télécharger le fichier avec votre navigateur. Une fois téléchargé, vous pouvez le transférer dans le répertoire contenant les fichiers du thème. Vous pouvez ensuite créer un pack de ces fichiers pour le distribuer ou l\'utiliser autrement si vous le souhaitez';
$lang['No_themes'] = 'Le modèle de document que vous avez sélectionné ne possède pas de thème associé. Pour créer un nouveau thème cliquez sur le lien créer un thème dans le volet de gauche';
$lang['No_template_dir'] = 'Impossible d\'ouvrir le répertoire du modèle de document. Il est peut-être illisible par le serveur ou n\'existe pas';
$lang['Cannot_remove_style'] = 'Vous ne pouvez pas supprimer le thème tant qu\'il est définit comme étant le thème par défaut du forum. Veuillez changer le thème par défaut et essayer à nouveau.';
$lang['Style_exists'] = 'Le nom du thème choisi existe déjà, veuillez revenir en arrière et choisir un nom différent.';
$lang['Click_return_styleadmin'] = 'Cliquez %sici%s pour revenir à l\'administration des thèmes';
$lang['Theme_settings'] = 'Options du thème';
$lang['Theme_element'] = 'Element du thême';
$lang['Simple_name'] = 'Nom Simple';
$lang['Value'] = 'Valeur';
$lang['Save_Settings'] = 'Sauvegarder les paramètres';
$lang['Stylesheet'] = 'Feuille de style CSS';
$lang['Background_image'] = 'Image de fond';
$lang['Background_color'] = 'Couleur de fond';
$lang['Theme_name'] = 'Nom du thème';
$lang['Link_color'] = 'Couleur du lien';
$lang['Text_color'] = 'Couleur du texte';
$lang['VLink_color'] = 'Couleur du lien visité';
$lang['ALink_color'] = 'Couleur du lien actif';
$lang['HLink_color'] = 'Couleur du lien survolé';
$lang['Tr_color1'] = 'Couleur 1 des lignes';
$lang['Tr_color2'] = 'Couleur 2 des lignes';
$lang['Tr_color3'] = 'Couleur 3 des lignes';
$lang['Tr_class1'] = 'Classe 1 des lignes';
$lang['Tr_class2'] = 'Classe 2 des lignes';
$lang['Tr_class3'] = 'Classe 3 des lignes';
$lang['Th_color1'] = 'Couleur 1 des cellules en-tête';
$lang['Th_color2'] = 'Couleur 2 des cellules en-tête';
$lang['Th_color3'] = 'Couleur 3 des cellules en-tête';
$lang['Th_class1'] = 'Classe 1 des cellules en-tête';
$lang['Th_class2'] = 'Classe 2 des cellules en-tête';
$lang['Th_class3'] = 'Classe 3 des cellules en-tête';
$lang['Td_color1'] = 'Couleur 1 des cellules';
$lang['Td_color2'] = 'Couleur 2 des cellules';
$lang['Td_color3'] = 'Couleur 3 des cellules';
$lang['Td_class1'] = 'Classe 1 des cellules';
$lang['Td_class2'] = 'Classe 2 des cellules';
$lang['Td_class3'] = 'Classe 3 des cellules';
$lang['fontface1'] = 'Nom de la police 1';
$lang['fontface2'] = 'Nom de la police 2';
$lang['fontface3'] = 'Nom de la police 3';
$lang['fontsize1'] = 'Taille de la police 1';
$lang['fontsize2'] = 'Taille de la police 2';
$lang['fontsize3'] = 'Taille de la police 3';
$lang['fontcolor1'] = 'Couleur de la police 1';
$lang['fontcolor2'] = 'Couleur de la police 2';
$lang['fontcolor3'] = 'Couleur de la police 3';
$lang['span_class1'] = 'Span Classe 1';
$lang['span_class2'] = 'Span Classe 2';
$lang['span_class3'] = 'Span Classe 3';
$lang['img_poll_size'] = 'Taille des barres de sondage [px]';
$lang['img_pm_size'] = 'Taille des barres de la messagerie privée [px]';


//
// Install Process
//
$lang['Welcome_install'] = 'Bienvenue à l\'installation de phpBB 2';
$lang['Initial_config'] = 'Configuration de base';
$lang['DB_config'] = 'Configuration de la base de données';
$lang['Admin_config'] = 'Configuration du compte administrateur';
$lang['continue_upgrade'] = 'Une fois le fichier de configuration téléchargé sur votre ordinateur, vous pouvez cliquer sur le bouton \'Continuer la mise à jour\' ci-dessous afin de continuer le processus de mise à jour. Veuillez patienter jusqu\'à la fin de la mise à jour avant d\'uploader le fichier de configuration (config.php).';
$lang['upgrade_submit'] = 'Continuer la mise à jour';

$lang['Installer_Error'] = 'Une erreur s\'est produite au cours de l\'installation';
$lang['Previous_Install'] = 'Une installation antérieure de phpBB a été détectée';
$lang['Install_db_error'] = 'Une erreur s\'est produite lors de la tentative de mise à jour de la base de données';

$lang['Re_install'] = 'Votre installation antérieure est toujours active.<br /><br />Si vous souhaitez ré-installer phpBB 2, cliquez sur le bouton \'Oui\' ci-dessous. Veuillez noter que ceci va supprimer toutes les informations et qu\'aucune sauvegarde ne sera faite ! Le nom et le mot de passe de l\'administrateur vont être recréés après la ré-installation, rien d\'autre ne sera conservé.<br /><br />Réfléchissez à deux fois avant de cliquer sur \'Oui\' !';

$lang['Inst_Step_0'] = 'Merci d\'avoir choisi phpBB 2. Afin de poursuivre l\'installation, veuillez compléter soigneusement le formulaire ci-dessous. Veuillez noter que la base de données dans laquelle vous allez installer devrait déjà exister. Si vous êtes en train d\'installer sur une base de données qui utilise ODBC, MS Access par exemple, vous devez d\'abord lui créer un SGBD avant de continuer.';

$lang['Start_Install'] = 'Commencer l\'installation';
$lang['Finish_Install'] = 'Terminer l\'installation';

$lang['Default_lang'] = 'Langue utilisée par défaut sur le forum';
$lang['DB_Host'] = 'Nom du serveur de base de données / SGBD';
$lang['DB_Name'] = 'Nom de votre base de données';
$lang['DB_Username'] = 'Nom d\'utilisateur de la base de données';
$lang['DB_Password'] = 'Mot de passe de la base de données';
$lang['Database'] = 'Votre base de données';
$lang['Install_lang'] = 'Choisissez la langue pour l\'installation';
$lang['dbms'] = 'Type de la base de données';
$lang['Table_Prefix'] = 'Préfixe des tables';
$lang['Admin_Username'] = 'Nom d\'utilisateur de l\'administrateur';
$lang['Admin_Password'] = 'Mot de passe de l\'administrateur';
$lang['Admin_Password_confirm'] = 'Confirmez le mot de passe de l\'administrateur';

$lang['Inst_Step_2'] = 'Votre nom d\'utilisateur (administrateur) a été créé. à ce point, l\'installation basique du forum est terminée. Vous allez maintenant être redirigé vers une page qui vous permettra d\'administrer votre nouvelle installation. Veuillez vous assurer de vérifier les détails de la configuration générale et d\'opérer les changements qui s\'imposent. Merci d\'avoir choisi phpBB 2.';

$lang['Unwriteable_config'] = 'Votre fichier de configuration est en lecture seule actuellement. Une copie du fichier va vous être proposer en téléchargement dès que vous aurez cliqué sur le bouton ci-dessous. Vous devrez uploader ce fichier à la racine de votre forum. Une fois réalisé, vous pourrez vous connecter en tant qu\'administrateur avec le nom et le mot de passe donnés dans le formulaire précédent. Vous pourrez visiter le panneau d\'administration (un lien apparraîtra en bas de chaque page une fois connecté) pour vérifier la configuration générale. Merci d\'avoir choisi phpBB 2.';
$lang['Download_config'] = 'Télécharger le fichier de configuration';

$lang['ftp_choose'] = 'Choisir la méthode de téléchargement';
$lang['ftp_option'] = '<br />Tant que les extensions FTP seront activées dans cette version de PHP, l\'option d\'essayer d\'envoyer automatiquement le fichier config sur un ftp peut vous être donnée.';
$lang['ftp_instructs'] = 'Vous avez choisi de transferer automatiquement le fichier vers le répertoire contenant phpBB 2 par FTP. Veuillez compléter les informations ci-dessous afin de faciliter le processus. Notez que le chemin du FTP doit être exactement celui du répertoire où est installé votre forum, comme si vous étiez en train d\'envoyer le fichier avec n\'importe quel client FTP.';
$lang['ftp_info'] = 'Entrez vos informations FTP';
$lang['Attempt_ftp'] = 'Essayer de transférer le fichier de configuration vers un serveur FTP';
$lang['Send_file'] = 'Juste m\'envoyer le fichier et je l\'enverrai manuellement sur le serveur FTP';
$lang['ftp_path'] = 'Chemin de phpBB2 sur le FTP';
$lang['ftp_username'] = 'Votre nom d\'utilisateur sur le FTP';
$lang['ftp_password'] = 'Votre mot de passe sur le FTP';
$lang['Transfer_config'] = 'Démarrer le transfert';
$lang['NoFTP_config'] = 'La tentative d\'envois du fichier de configuration par FTP a échoué. Veuillez télécharger le fichier et le mettre en ligne manuellement.';

$lang['Install'] = 'Installation';
$lang['Upgrade'] = 'mise à jour';
$lang['Install_Method'] = 'Choix du type d\'installation';
$lang['Install_No_Ext'] = 'La configuration de PHP sur votre serveur ne supporte pas le type de base de données que vous avez choisi';
$lang['Install_No_PCRE'] = 'phpBB 2 requiert le support des expressions régulières Perl pour PHP. Il semblerait que votre configuration de PHP ne le supporte pas !';
//
// Admin Userlist Start
//
$lang['Userlist'] = 'Liste des utilisateurs';
$lang['Userlist_description'] = 'Voir une liste complète de vos utilisateurs et accomplir diverses actions sur ceux-ci';

$lang['Add_group'] = 'Ajouter à un groupe';
$lang['Add_group_explain'] = 'Choisir le groupe auquel vous voulez ajouter le membre sélectionné';

$lang['Open_close'] = 'Ouvrir/Fermer';
$lang['Active'] = 'Actif';
$lang['Group'] = 'Groupe(s)';
$lang['Rank'] = 'Rang';
$lang['Last_activity'] = 'Dernière activité';
$lang['Never'] = 'Jamais';
$lang['User_manage'] = 'Gérer';
$lang['Find_all_posts'] = 'Trouver tous les posts';

$lang['Select_one'] = 'Sélectionner une action';
$lang['Ban'] = 'Bannir';
$lang['Is_Banned'] = 'Banni !'; 
$lang['UnBan'] = 'Dé-bannir';
$lang['Activate_deactivate'] = 'Activer/Désactiver';
$lang['Select_All'] = 'Tout sélectionner';
$lang['Deselect_All'] = 'Tout dé-sélectionner';

$lang['User_id'] = 'ID du membre';
$lang['User_level'] = 'Niveau du membre';
$lang['Ascending'] = 'Ascendant';
$lang['Descending'] = 'Descendant';
$lang['Show'] = 'Montrer';
$lang['All'] = 'Tout';

$lang['Member'] = 'Membre';
$lang['Pending'] = 'En attente';

$lang['Confirm_user_ban'] = 'Êtes-vous sur de vouloir bannir le(s) membre(s) sélectionné(s) ?';
$lang['Confirm_user_un_ban'] = 'Êtes-vous sur de vouloir dé-bannir le(s) membre(s) sélectionné(s) ?';
$lang['Confirm_user_deleted'] = 'Êtes-vous sur de vouloir supprimer le(s) membre(s) sélectionné(s) ?';
$lang['User_status_updated'] = 'Le statuts des utilisateurs ont &eacute;t&eacute; mis &agrave; jour correctement !';
$lang['User_banned_successfully'] = 'Membre(s) banni(s) avec succès !';
$lang['User_un_banned_successfully'] = 'Membre(s) dé-banni(s) avec succès !';
$lang['User_deleted_successfully'] = 'Membre(s) supprimé(s) avec succès !';
$lang['User_add_group_successfully'] = 'Membre(s) ajouté(s) au groupe avec succès !';
$lang['Click_return_userlist'] = 'Cliquez %sici%s pour revenir à la liste des utilisateurs';
//
// Admin Userlist End
//

//
// Version Check
//
$lang['Version_up_to_date'] = 'Votre installation est à jour, il n\'y a pas de nouvelle version actuellement.';
$lang['Version_not_up_to_date'] = 'Votre installation <b>n\'est pas</b> à jour. Veuillez visiter <a href="http://www.phpbb.com/downloads.php" target="_new">http://www.phpbb.com/</a> ou un site de <a href="http://www.phpbbfrance.com" target="_new">support</a> pour obtenir la version la plus récente, ainsi que les informations nécessaires à la mise à jour de votre installation.';
$lang['Latest_version_info'] = 'La version la plus récente est <b>phpBB %s</b>.';
$lang['Current_version_info'] = 'Vous utilisez <b>phpBB %s</b>.';
$lang['Connect_socket_error'] = 'Impossible d\'établir une connexion vers le serveur du site officiel. L\'erreur signalée est :<br />%s';
$lang['Socket_functions_disabled'] = 'Les fonctions sockets semblent avoir été désactivées, il est impossible de les utiliser.';
$lang['Mailing_list_subscribe_reminder'] = 'Pour les informations les plus récentes sur les mises à jour pour phpBB, <a href="http://www.phpbb.com/support/" target="_new">incrivez-vous à notre liste de diffusion</a> (vous trouverez également une liste de diffusion en français sur votre site de <a href="http://www.phpbbfrance.com" target="_blank">support français</a>).';
$lang['Version_information'] = 'Information sur la version';

//
//Advance Admin Index 
//
$lang['Board_statistic'] = 'Statistiques du forum';
$lang['Database_statistic'] = 'Statistiques de la Base De Données';
$lang['Version_info'] = 'Informations de Version';
$lang['Thereof_deactivated_users'] = 'Nombre de Membres Inactifs';
$lang['Thereof_Moderators'] = 'Nombres de Modérateurs';
$lang['Thereof_Administrators'] = 'Nombres d\'Administrateurs';
$lang['Deactivated_Users'] = 'Membres en attente d\'Activation';
$lang['Users_with_Admin_Privileges'] = 'Membres ayant les droits d\'Administrateur';
$lang['Users_with_Mod_Privileges'] = 'Membres ayant les droits de Modérateur';
$lang['DB_size'] = 'Taille de la Base De Données';
$lang['Version_of_PHP'] = 'Version de <a href="http://www.php.net/">PHP</a>';
$lang['Version_of_MySQL'] = 'Version de <a href="http://www.mysql.com/">MySQL</a>'; 

// DÉBUT MOD Logo aléatoire 
$lang['LoAl_title'] = 'Utilitaire d\'Edition des logos'; 
$lang['LoAl_desc'] = 'Depuis cette page vous pouvez ajouter, retirer et éditer des logos de la liste des logos qui pourront êtres choisis aléatoirement. Le champ proba détermine par rapport aux autres logos, leur chance d\'être choisis.'; 
$lang['LoAl_Intervalle_logos'] = 'Intervalle de renouvellement du logo [ minutes ]'; 
$lang['LoAl_Intervalle_logos_explain'] = 'Entrez ici le nombre de minutes au bout duquel un nouveau logo doit être tiré aléatoirement. Il est préférable de ne pas prendre un intervalle trop petit car le choix d\'un nouveau logo génère quatre requêtes SQL supplémentaires et impose au visiteur de recharger un nouveau logo (ce qui augmente votre consommation de bande passante et, dans le cas d\'une connexion lente, peut être désagrable pour le visiteur).'; 

$lang['LoAl_config'] = 'Configuration des logos'; 
$lang['LoAl_adresse'] = 'Adresse du logo'; 
$lang['LoAl_proba'] = 'Proba'; 
$lang['LoAl_proba_edit'] = 'Coefficient d\'apparition'; 
$lang['LoAl_proba_explain'] = 'Plus ce coefficient est grand, plus le logo a de chances d\'être choisi.'; 
$lang['LoAl_image'] = 'Image'; 
$lang['LoAl_add'] = 'Ajouter un nouveau logo'; 

$lang['LoAl_add_success'] = 'Le logo a été ajouté avec succès'; 
$lang['LoAl_edit_success'] = 'Le logo a été mis à jour avec succès'; 
$lang['LoAl_del_success'] = 'Le logo a été retiré avec succès'; 
$lang['LoAl_click_return_LOGOAdmin'] = 'Cliquez %sici%s pour revenir à l\'Administration des logos'; 
// FIN MOD Logo aléatoire

//
// Auth pages overall forum permissions
//
$lang['Forum_auth_explain_overall'] = 'Ici vous pouvez changer les niveaux d\'autorisations pour chaque forum. Rappelez vous que changer les niveaux de permission des forums affectera les users qui peuvent faire des opérations diverses dans ceux-ci.';
$lang['Forum_auth_explain_overall_edit'] = 'Premièrement, cliquer sur la couleur de la clef. Cliquer ensuite sur la clef du forum que vous voulez changer. Utiliser "Restaurer" pour annuler les changements. Utilisez "Arreter l\'édition" pour arrêter de faire d\'autres changements.';
$lang['Forum_auth_overall_restore'] = 'Restaurer';
$lang['Forum_auth_overall_stop'] = 'Arrêter l\'édition';
$lang['voir'] = 'Voir';
$lang['lire'] = 'Lire';
$lang['poster'] = 'Post';
$lang['reponse'] = 'Rep';
$lang['editer'] = 'Edit';
$lang['supprimer'] = 'Sup';
$lang['poste_it'] = 'P_it';
$lang['annonces'] = 'Ann';
$lang['vote'] = 'Voter';
$lang['sondage'] = 'Sond';
$lang['ban'] = 'Ban';
$lang['bluecard'] = 'Rapp.';
$lang['greencard'] = 'Déban';
//
// Auth pages overall forum permissions
//

// Toggle ACP Login
$lang['admin_login'] = "Ré-identification pour acceder au panneau d'administration";
$lang['admin_login_explain'] = "Cette option vous permet de choisir si vous voulez vous ré-identifier pour entrer dans le panneau d'administration. Il s'agit d'une sécurité mais elle n'est pas indispensable.";

// Start add - Yellow Card Mod
$lang['Ban'] = 'Bannir';
$lang['Max_user_bancard'] = 'Nombre maximum d\'avertissements';
$lang['Max_user_bancard_explain'] = 'Si un utilisateur dépasse la limite des avertissements (cartons jaunes), il sera banni';
$lang['ban_card'] = 'Avertissement';
$lang['ban_card_explain'] = 'L\'utilisateur sera banni lorsqu\'il dépassera la limite de %d avertissements';
$lang['Greencard'] = 'Débannir';
$lang['Bluecard'] = 'Rapporter';
$lang['Bluecard_limit'] = 'Intervalle des rapports';
$lang['Bluecard_limit_explain'] = 'Informer les modérateurs tous les X rapports envoyés à un message';
$lang['Bluecard_limit_2'] = 'Limite des rapports';
$lang['Bluecard_limit_2_explain'] = 'La première notification aux modérateurs est envoyée lorsqu\'un message obtient ce nombre de rapports';
$lang['Report_forum']= 'Rapporter un forum';
$lang['Report_forum_explain'] = 'Sélectionnez le forum où les utilisateurs posteront les rapports, une valeur de 0 désactivera cette option. Les utilisateurs DOIVENT au moins avoir les droits pour poster/répondre dans ce forum';
// End add - Yellow Card Mod

//-- mod : Edit Forums On Index -----------------------------------------------------
//-- add
$lang['successfull_popup']	= 'Forum édité avec succès.';
$lang['close_popup'] 		= 'Fermer la fenêtre';
//-- fin mod : Edit Forums On Index -------------------------------------------------

// Points System MOD - Admin
$lang['Points_updated']	= 'Configuration du système de points mise à jour avec succès';
$lang['Click_return_points'] = 'Cliquez %sIci%s pour retourner à la configuration du système de points';
$lang['Points_config_explian'] = 'Le formulaire ci-dessous vous permet d\'éditer la configuration du système de points.';
$lang['Points_sys_settings'] = 'Paramètres du système de points';
$lang['Points_disabled'] = 'Désactiver les %s';
$lang['Points_enable_post']	= 'Gagner des %s en postant';
$lang['Points_enable_browse'] = 'Gagner des %s en naviguant';
$lang['Points_enable_donation']	= 'Autoriser les dons';
$lang['Points_name'] = 'Nom des points';
$lang['Points_per_reply'] = 'Points par réponse';
$lang['Points_per_topic'] = 'Points par nouveaux sujets';
$lang['Points_per_page'] = 'Points par page';
$lang['Points_user_group_auth'] = 'Groupes autorisés';
$lang['Points_enable_post_explain']	= 'Laisse les utilisateurs gagner des %s en postant des nouveaux sujets et en répondant à ceux existants';
$lang['Points_enable_browse_explain'] = 'Laisse les utilisateurs gagner des %s en naviguant sur les forums';
$lang['Points_enable_donation_explain']	= 'Laisse les utlisateurs donner des %s à leurs amis';
$lang['Points_name_explain'] = 'Appelation des points sur votre forum ( par exemple dollars , carottes)';
$lang['Points_per_reply_explain'] = 'Montant de %s gagné(s) par réponse';
$lang['Points_per_topic_explain'] = 'Montant de %s gagné(s) pour chaque nouveau sujet créé';
$lang['Points_per_page_explain'] = 'Montant de %s gagné(s) pour chaque page affichée';
$lang['Points_user_group_auth_explain'] = 'Entrez les ids des groupes autorisés à accéder au panneau de contrôle des points. Une seule id par ligne.';
$lang['Allow_Points'] = 'Utiliser le système de points ?';
$lang['Points_reset'] = 'Réinitialiser les points de tous les utilisateurs';
$lang['Points_reset_explain'] = 'Entrez un nombre puis validez : cela deviendra le nombre de points de tous les utilisateurs.';

//Beginning Inactive Users
$lang['Users_Inactive'] = 'Membres inactifs';
$lang['Users_Inactive_Explain'] = 'Si dans "Activation du compte", vous avez choisi "Utilisateur" ou "Administrateur", vous aurez dans cette liste les utilisateurs qui n\'ont jamais eu leur compte activé.<br /><br />En cliquant sur "Contacter", vous enverrez un e-mail à tous les utilisateurs sélectionnés.<br />En cliquant sur "Activer", vous activerez les comptes de tous les utilisateurs sélectionnés.<br />En cliquant sur "Supprimer", vous enverrez un e-mail et supprimerez tous les utilisateurs sélectionnés.';
$lang['UI_Check_None'] = '"Activation du compte" est sur <b>Aucune</b>.';
$lang['UI_Check_User'] = '"Activation du compte" est sur <b>Utilisateur</b>.';
$lang['UI_Check_Admin'] = '"Activation du compte" est sur <b>Administrateur</b>.';
$lang['UI_Check_Recom'] = '%sModifier%s.';
$lang['UI_Removed_Users'] = 'Membre(s) supprimés';
$lang['UI_User'] = 'Membre';
$lang['UI_Registration_Date'] = 'Date d\'enregistrement';
$lang['UI_Last_Visit'] = 'Dernière visite';
$lang['UI_Active'] = 'Actif';
$lang['UI_Email_Sents'] = 'E-mails envoyés';
$lang['UI_Last_Email_Sents'] = 'Dernier e-mail';
$lang['UI_CheckColor'] = 'Cocher';
$lang['UI_CheckAll'] = 'Tout cocher';
$lang['UI_UncheckAll'] = 'Tout décocher';
$lang['UI_InvertChecked'] = 'Inverser';
$lang['UI_Contact_Users'] = 'Contacter';
$lang['UI_Delete_Users'] = 'Supprimer';
$lang['UI_Activate_Users'] = 'Activer';
$lang['UI_select_user_first'] = 'Vous devez d\'abord sélectionner un utilisateur';
$lang['UI_return'] = 'Cliquez %sici%s pour retourner à l\'administration des utilisateurs inactifs';
$lang['UI_Deleted_Users'] = 'Les utilisateurs sélectionnés ont été supprimés';
$lang['UI_Activated_Users'] = 'Les utilisateurs sélectionnés ont eu leur compte activé';
$lang['UI_Alert_Days'] = "jours";
$lang['UI_with_zero_messages'] = "avec 0 messages";
$lang['UI_Alert_Every'] = "Tous les";
$lang['UI_Alert_UpTo'] = "Jusqu'à";
$lang['UI_Alert_Over'] = "Plus de";
//End Inactive Users

// MOD ColorText
$lang['Allow_colortext'] = 'Autoriser la Personnalisation de la Couleur des Posts';
$lang['Colortext'] = 'Couleur du texte';
// Default Avatar MOD, By Manipe (Begin)
$lang['Default_avatar_settings'] = 'Paramètres avatars par défaut';
$lang['Default_avatar_settings_explain'] = 'L\'avatar par défaut est un avatar qui est montré lorsqu\'un membre n\'a pas sélectionné d\'avatar. Vous pouvez l\'activer ou le désactiver ici. Différents avatars peuvent être choisis pour montrer les membres enregistrés ou les invités. Un avatar aléatoire peut ausi être choisi à partir de la galerie des avatars. Vous pouvez enfin choisir ou non de laisser les membres décider s\'ils veulent ou non un avatar par défaut. Cette option peut-être désactivée.';
$lang['Default_avatar_use'] = 'Pemettre les avatars par défaut';
$lang['Default_avatar_random'] = 'Pemettre les avatars aléatoires par défaut';
$lang['Default_avatar_random_explain'] = 'Vous pourrez choisir un avatar aléatoire dans votre galerie d\'avatars, défini par le chemin de la galerie d\'avatars dans les paramètres des avatars. Tous les répertoires de la galerie seront examinés, et un avatar sera alors choisi de manière aléatoire pour tous les membres. Un même membre n\'aura pas le même avatar et pourra avoir différents avatars sur une même page du viewtopic.php.';
$lang['Default_avatar_type'] = 'Activer l\'avatar par défaut pour une catégorie de membre';
$lang['Default_avatar_users'] = 'Membres';
$lang['Default_avatar_guests'] = 'Invités';
$lang['Default_avatar_both'] = 'Membres &amp; Invités';
$lang['Default_avatar_users_set'] = 'Chemin pour l\'avatar par défaut des membres enregistrés';
$lang['Default_avatar_users_explain'] = 'Chemin dans votre dossier phpBB. Par exemple : images/avatars/avatar.jpg. Cette image sera montrée pour chaque membre enregistré n\'ayant pas choisi d\'avatar personnel. L\'activation de l\'avatar aléatoire par défaut prévaut sur cette option.';
$lang['Default_avatar_guests_set'] = 'Chemin pour l\'avatar par défaut des invités';
$lang['Default_avatar_guests_explain'] = 'Chemin dans votre dossier phpBB. Par exemple : images/avatars/avatar.jpg. Cette image sera montrée pour chaque invité. L\'activation de l\'avatar aléatoire par défaut prévaut sur cette option. Saisissez la même URL qu\'au dessus si vous souhaitez que les membres enregistrés et les invités aient le même avatar.';
$lang['Default_avatar_choose'] = 'Laisser les membres choisir s\'ils veulent ou non un avatar par défaut.';
$lang['Default_avatar_choose_explain'] = 'Cette option permet aux membres de décider d\'avoir ou non un avatar par défaut s\'ils n\'en ont pas personnellement choisi un.';
$lang['Default_avatar_override'] = 'Neutraliser l\'avatar du membre';
$lang['Default_avatar_override_explain'] = 'Cela vous permet de montrer un avatar par défaut aux membres qui ont malgré tout sélectionné un avatar. Il est cependant conseillé de ne pas permettre aux membres de décider d\'avoir ou non un avatar par défaut.';
// Default Avatar MOD, By Manipe (End)

// Replace Posts MOD
$lang['Replace_title'] = 'Remplacer dans les posts';
$lang['Replace_text'] = 'A partir de cette page, vous pouvez remplacer des mots ou bien des phrases par ce que vous vous voulez. Cela est définitif et ne peut-être défait.';
$lang['Link'] = 'Lien';
$lang['Str_old'] = 'Texte actuel';
$lang['Str_new'] = 'Remplacer par';
$lang['No_results'] = 'Aucun résultat';
$lang['Replaced_count'] = 'Nombre de posts modifiés: %s';

//+MOD: Search latest 24h 48h 72h
$lang['Search_latest_hours'] = 'Rechercher les derniers messages';
$lang['Search_latest_hours_explain'] = 'Indiquer la ou les période, séparées par une virgule. Ces périodes seront utilisées pour afficher dynamiquement sur l\'index du forum les liens correspondant à la période de recherche demandée.';
$lang['Search_latest_hours_error'] = 'Valeur saisie dans le champs \'Rechercher les derniers messages\' incorrecte.<br /><br />Veuillez spécifier une période ou liste de périodes (24, 48 et/ ou 72 heures, séparées par une virgule.';
$lang['Search_latest_results'] = 'Résultat de la recherche';
$lang['Search_latest_results_explain'] = 'Indiquer comment les résultats de recherche des dernières heures doivent être montrés.';
//-MOD: Search latest 24h 48h 72h

$lang['game_access_settings'] = 'Restrictions d\'accès aux Jeux'; 
$lang['limit_by_posts'] = 'Activer les restrictions'; 
$lang['posts_needed'] = 'Nombres de messages obligatoires'; 
$lang['days_limit'] = 'Nombre de jours'; 
$lang['limit_by_posts_explain'] = 'En activant ces restrictions, vous empêcherer les membres n\'ayant jamais posté de messages ou depuis un temps défini de jouer aux jeux.'; 
$lang['posts_needed_explain'] = 'Le nombre de messages obligatoires pour jouer.'; 
$lang['days_limit_explain'] = 'Le nombre de jours servant à la vérification des messages.'; 
$lang['posts_only'] = 'Messages seulement'; 
$lang['posts_date'] = 'Messages et Date'; 
$lang['limit_type'] = 'Type de Restriction'; 
$lang['limit_type_explain'] = 'Restreint l\'accès aux jeux par messages seulement ou par date et messages.';

//Ajout confirmation écrite
$lang['Active_question_conf_ecrite'] = 'Voulez vous activer la confirmation écrite ?';
$lang['Question_conf_ecrite'] = 'Entrez votre question pour la confirmation de l\'inscription';
$lang['Reponse_conf_write'] = 'Entrez la réponse à la question pour la confirmation de l\'inscription';
//Fin confirmation écrite

// BEGIN Today-Yesterday Mod
$lang['Lastpost_cutoff'] = 'Limite de caractères pour le dernier post'; 
$lang['Lastpost_cutoff_explain'] = 'Nombre de caractères du titre du topic qui seront affichés dans le dernier post.'; 
$lang['Lastpost_append'] = 'Caractères à joindre au dernier post';  
$lang['Lastpost_append_explain'] = 'Caractères qui seront joints à la fin du dernier post s\'il est plus long que la limite fixée.';  
// END Today-Yesterday Mod

//
// That's all Folks!
// -------------------------------------------------

//
// Quicklinks
//
$lang['Quicklinks'] = 'Liens rapides';

$lang['Quicklinks_title'] = 'Liens rapides';
$lang['Quicklinks_explain'] = 'Vous pouvez ajouter les mots qui seront automatiquement remplacés par des liens dans les sujets et réponses.';
$lang['Quicklinks_Edit_word_censor'] = 'Editer lien rapide';
$lang['Quicklinks_Replacement'] = 'URL pour le lien rapide';
$lang['Quicklinks_Add_new_word'] = 'Ajouter un lien rapide';
$lang['Quicklinks_Update_word'] = 'Mise à jour du lien rapide';

$lang['Quicklinks_Must_enter_word'] = 'Un mot et un lien sont nécessaires.';
$lang['Quicklinks_No_word_selected'] = 'Aucun lien rapide choisi pour l\'édition.';

$lang['Quicklinks_updated'] = 'Le lien rapide a été mis à jour.';
$lang['Quicklinks_added'] = 'Le lien rapide a été ajouté.';
$lang['Quicklinks_removed'] = 'Le lien rapide a été supprimé.';

$lang['Quicklinks_Click_return_admin'] = 'Cliquez %sici%s, pour retourner a l\'administration des liens rapides.';

// Start add - Gender Mod
$lang['Gender_required'] = 'Obliger les membres à indiquer leur sexe';

// external forum redirect
$lang['Forum_redirect_url'] = 'URL';
$lang['Forum_ext_newwin'] = 'Ouvrir le lien externe dans une nouvelle fenêtre';
$lang['Forum_ext_image'] = 'Image pour le lien externe';

//-- mod : pm threshold ----------------------------------------------------------------------------
$lang['pm_allow_threshold'] = 'Autoriser le seuil de MP';
$lang['pm_allow_threshold_explain'] = 'Indiquer ici le nombre minimal de posts que doit avoir écrit un membre avant de pouvoir utiliser la messagerie privée.';

// Begin Account Self-Delete MOD
$lang['account_delete'] = 'Permettre aux membres de supprimer leurs propres comptes';

// BEGIN mx Google Sitemaps www.phpBB.SEO.com
$lang['Google_SiteMaps'] = "GYM Sitemaps & RSS";

// Advanced Board Disable
$lang['Board_disable'] = 'Désactiver le forum';
$lang['Board_disable_explain'] = 'Ceci empêchera l\'accès au forum pour plusieurs groupes que vous pouvez définir en desssous.';
$lang['Board_disable_mode'] = 'Désactiver le forum pour...';
$lang['Board_disable_mode_explain'] = 'Vous pouvez ici choisir qui ne sera pas autorisé à accéder au forum une fois celui-ci désactivé. Vous pouvez sélectionner plusieurs groupes à l\'aide de la touche Ctrl.';
$lang['Board_disable_mode_opt'] = array(ANONYMOUS => 'Invités', USER => 'Membres enregistrés', MOD => 'Modérateurs', ADMIN => 'Administrateurs');
$lang['Board_disable_msg'] = 'Message du forum désactivé';
$lang['Board_disable_msg_explain'] = 'Ce message sera montré lorsque le forum sera désactivé (message vide = message par défaut).';

// Start add - Fully integrated shoutbox Mod
$lang['Prune_shouts'] = 'Suppression automatique des messages';
$lang['Prune_shouts_explain'] = 'Choisissez le nombre de jours avant que les messages du Chat ne soient supprimés. Si elle est mise sur 0, cette option désactivera la suppression automatique.';

$lang['Max_url_length'] = 'Nombre maximal de caractères pour les URLs';//Autoshorten URL MOD v1.0.4

$lang['Overall_Permissions'] = 'Permissions interactives';

// ADR stuff
$lang['Rabbitoshi_Pets_Management']='Gestions créatures'; 
$lang['Rabbitoshi_Shop']='Animalerie'; 
$lang['Rabbitoshi_settings']='Configurations générales'; 
$lang['Rabbitoshi_owners']='Propriétaires'; 

$lang['User_adr_ban']='Ban RPG ADR ?'; 
$lang['User_adr_ban_explain']='Permet de bannir l\'utilisateur de toutes les fonctionnalités du RPG (Advanced Dungeons & Rabbits)'; 

// presentation required
$lang['Presentation_Required'] = 'Obliger les membres à se présenter';
$lang['Presentation_Forum'] = 'Sélectionnez le forum de présentation';
// sub title
$lang['Sub_title_length'] = 'Longueur du sous-titre (description) du sujet';
$lang['Sub_title_length_explain'] = 'Choisissez la longueur en nombre de caractères des sous-titres (description) des messages. Renseignez cette valeur à 0 si vous ne désirez pas afficher les sous-titres.';
