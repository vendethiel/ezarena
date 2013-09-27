<?php
/***************************************************************************
 *                            lang_main.php [french]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2004 PhpBB France
 *
 *     $Id: lang_main.php
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
 *   Français
 *   ----------
 *   Ce programme est un logiciel libre : vous pouvez le redistribuer
 *   et/ou le modifier tel que le prévoit la license GNU General Public License
 *   (GNU/GPL) publiée par la Fondation des logiciels libres (Free Software Foundation)
 *   Est appliquée la version 2 de la licence ou n'importe quelle version antérieure
 *   de votre choix.
 *
 ***************************************************************************/

//
// Traduction : phpBB France (http://www.phpbbfrance.org/)
//

//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax

// varies ... give it your best guess!
//

$lang['ENCODING'] = 'ISO-8859-1';
$lang['DIRECTION'] = 'LTR';
$lang['LEFT'] = 'gauche';
$lang['RIGHT'] = 'droite';
$lang['DATE_FORMAT'] =  'd M Y'; // This should be changed to the default date format for your language, php date() format


// This is optional, if you would like a _SHORT_ message output
// along with our copyright message indicating you are the translator
// please add it here.

// Version de phpBB traduite en français par phpbbfrance.org , si vous souhaitez nous remercier
// vous pouvez retirer les commentaires // devant les deux lignes ci dessous afin d'afficher un lien
// vers notre forum.
//
//$lang['TRANSLATION'] = 'Traduction par : <a href="http://www.phpbbfrance.org/" target="_blank" class="copyright" title="Traduction de phpBB en français par phpBB France">phpBB France</a>';
$lang['TRANSLATION_INFO'] = 'Traduction par : <a href="http://www.phpbbfrance.org/" target="_blank" class="copyright" title="Traduction de phpBB en français par phpBB France">phpBBFrance.org</a>';
$lang['Premod'] = 'Prémod <a href="http://ezcom-fr.com">ezArena par EzCom</a> %s basée sur l\'Ultimarena';

$lang['Login_attempts_exceeded'] = 'Vous avez dépassé le nombre maximal de tentatives de connexions (%s). Vous ne pourrez ainsi plus vous connecter pendant %s minutes.';
$lang['Please_remove_install_contrib'] = 'Afin de terminer l\'installation, veuillez supprimer le dossier <strong>install/</strong> présent à la racine de votre forum.';
$lang['Session_invalid'] = 'Session invalide. Veuillez re-soumettre le formulaire.';
//
// Common, these terms are used
// extensively on several pages
//
$lang['Forum'] = 'Forum ';
$lang['Category'] = 'Catégorie ';
$lang['Topic'] = 'Sujet ';
$lang['Topics'] = 'Sujets';
$lang['Replies'] = 'Réponses';
$lang['Views'] = 'Vus ';
$lang['Post'] = 'Message ';
$lang['Posts'] = 'Messages';
$lang['Posted'] = 'Posté ';
$lang['Username'] = 'Nom d\'utilisateur ';
$lang['Password'] = 'Mot de passe ';
$lang['Email'] = 'E-mail ';
$lang['Poster'] = 'Poster';
$lang['Author'] = 'Auteur ';
$lang['Time'] = 'Temps';
$lang['Hours'] = 'Heures ';
$lang['Message'] = 'Message ';
$lang['1_Day'] = '1 jour';
$lang['7_Days'] = '7 jours';
$lang['2_Weeks'] = '2 semaines';
$lang['1_Month'] = '1 mois';
$lang['3_Months'] = '3 mois';
$lang['6_Months'] = '6 mois';
$lang['1_Year'] = '1 an';
$lang['Go'] = 'Valider';
$lang['Jump_to'] = 'Aller vers';
$lang['Submit'] = 'Envoyer';
$lang['Reset'] = 'Réinitialiser';
$lang['Cancel'] = 'Annuler';
$lang['Preview'] = 'Prévisualisation';
$lang['Confirm'] = 'Confirmer';
$lang['Spellcheck'] = 'Vérificateur d\'orthographe';
$lang['Yes'] = 'Oui';
$lang['No'] = 'Non';
$lang['Enabled'] = 'Activé';
$lang['Disabled'] = 'Désactivé';
$lang['Error'] = 'Erreur';
$lang['Next'] = 'Suivante';
$lang['Previous'] = 'Précédente';
$lang['Goto_page'] = 'Se rendre à la page :';
$lang['Joined'] = 'Inscrit le ';
$lang['IP_Address'] = 'Adresse IP ';
$lang['Select_forum'] = 'Sélectionner un forum';
$lang['View_latest_post'] = 'Voir le dernier message';
$lang['View_newest_post'] = 'Voir le message le plus récent';
$lang['Page_of'] = 'Page <b>%d</b> sur <b>%d</b>'; // Replaces with: Page 1 of 2 for example
$lang['ICQ'] = 'Numéro ICQ ';
$lang['AIM'] = 'Adresse AIM ';
$lang['MSNM'] = 'MSN Messenger ';
$lang['YIM'] = 'Yahoo Messenger ';
$lang['Forum_Index'] = 'Forums %s';  // eg. sitename Forum Index, %s can be removed if you prefer
$lang['Post_new_topic'] = 'Poster un nouveau sujet';
$lang['Reply_to_topic'] = 'Répondre au sujet';
$lang['Reply_with_quote'] = 'Répondre en citant';
$lang['Click_return_topic'] = 'Cliquez %sici%s pour retourner au sujet de discussion'; // %s's here are for uris, do not remove!
$lang['Click_return_login'] = 'Cliquez %sici%s pour essayer à nouveau';
$lang['Click_return_forum'] = 'Cliquez %sici%s pour retourner au forum';
$lang['Click_view_message'] = 'Cliquez %sici%s pour voir votre message';
$lang['Click_return_modcp'] = 'Cliquez %sici%s pour retourner au panneau de contrôle du modérateur';
$lang['Click_return_group'] = 'Cliquez %sici%s pour retourner aux informations du groupe';
$lang['Admin_panel'] = 'Panneau de Contrôle de l\'Administrateur';
$lang['Board_disable'] = 'Désolé, mais ce forum est actuellement indisponible. Veuillez réessayer plus tard.';


//
// Global Header strings
//
$lang['Registered_users'] = 'Utilisateurs connectés :';
$lang['Browsing_forum'] = 'Utilisateurs parcourant actuellement ce forum :';
$lang['Online_users_zero_total'] = 'Il n\'y a <b>aucun</b> utilisateur en ligne : ';
$lang['Online_users_total'] = 'Il y a <b>%d</b> utilisateurs en ligne : ';
$lang['Online_user_total'] = 'Il y a <b>%d</b> utilisateur en ligne : ';
$lang['Reg_users_zero_total'] = '0 Enregistré, ';
$lang['Reg_users_total'] = '%d Enregistrés, ';
$lang['Reg_user_total'] = '%d Enregistré, ';
// www.phpBB-SEO.com SEO TOOLKIT BEGIN
$lang['Hidden_users_zero_total'] = '0 Invisible, ';
$lang['Hidden_user_total'] = '%d Invisible, ';
$lang['Hidden_users_total'] = '%d Invisibles, ';
$lang['Guest_users_zero_total'] = '0 Invité et ';
$lang['Guest_users_total'] = '%d Invités et ';
$lang['Guest_user_total'] = '%d Invité et ';
$lang['Bot_online'] = 'Bots : ';
$lang['Bot_nul'] = '0 Bots';
$lang['Bot_total'] = '%d Bots';
$lang['Bot_one'] = '%d Bot';
// www.phpBB-SEO.com SEO TOOLKIT END
$lang['Record_online_users'] = 'Le plus grand nombre d\'utilisateurs en ligne est de <b>%s</b> le %s'; // first %s = number of users, second %s is the date.
$lang['Legend'] = 'Légende ';
$lang['Admin_online_color'] = '%sAdministrateur%s';
$lang['Mod_online_color'] = '%sModérateur%s';
$lang['User_online_color'] = '%sUtilisateur%s';
$lang['You_last_visit'] = 'Votre dernière visite : %s'; // %s replaced by date/time
$lang['Current_time'] = 'Page générée le : %s'; // %s replaced by date/time
$lang['Search_new'] = 'Voir les posts non lus';
$lang['Search_your_posts'] = 'Vos messages';
$lang['Search_unanswered'] = 'Les messages sans réponse';
$lang['Register'] = 'Inscription';
$lang['Profile'] = 'Profil';
$lang['Edit_profile'] = 'Editer votre profil';
$lang['Search'] = 'Recherche';
$lang['Memberlist'] = 'Membres';
$lang['FAQ'] = 'FAQ';
$lang['BBCode_guide'] = 'Guide du BBCode';
$lang['Usergroups'] = 'Groupes';
$lang['Last_Post'] = 'Derniers messages';
$lang['rmw_image_title'] = 'Cliquez pour agrandir'; // mod : Resize Posted Images Based on Max Width
$lang['Moderator'] = 'Modérateur ';
$lang['Moderators'] = 'Modérateurs ';


//
// Stats block text
//
$lang['Posted_articles_zero_total'] = 'Les membres n\'ont posté <b>aucun</b> message'; // Number of posts
$lang['Posted_articles_total'] = 'Les membres ont posté un total de <b>%d</b> messages'; // Number of posts
$lang['Posted_article_total'] = 'Les membres ont posté un total de <b>%d</b> message'; // Number of posts
$lang['Registered_users_zero_total'] = 'Il y a <b>0</b> utilisateur enregistré'; // # registered users
$lang['Registered_users_total'] = 'Il y a <b>%d</b> utilisateurs enregistrés'; // # registered users
$lang['Registered_user_total'] = 'Il y a <b>%d</b> utilisateur enregistré'; // # registered users
$lang['male_zero_total'] = 'et <b>0</b> <img src="images/icon_minigender_male.gif" /> inscrit sur le forum'; // # registered male users
$lang['male_total'] = 'et <b>%d</b> <img src="images/icon_minigender_male.gif" /> inscrits sur le forum'; // # registered male users
$lang['male_one_total'] = 'et <b>%d</b> <img src="images/icon_minigender_male.gif" /> inscrits sur le forum'; // # registered male users
$lang['female_zero_total'] = 'Nous avons <b>0</b> <img src="images/icon_minigender_female.gif" />'; // # registered female users
$lang['female_total'] = 'Nous avons <b>%d</b> <img src="images/icon_minigender_female.gif" />'; // # registered female users
$lang['female_one_total'] = 'Nous avons <b>%d</b> <img src="images/icon_minigender_female.gif" />'; // # registered female users
$lang['Newest_user'] = 'Le dernier membre inscrit est <b>%s%s%s</b>'; // a href, username, /a 
$lang['No_new_posts_last_visit'] = 'Pas de nouveau message depuis votre dernière visite';
$lang['No_new_posts'] = 'Pas de nouveau message';
$lang['New_posts'] = 'Nouveau message';
$lang['New_post'] = 'Nouveau message';
$lang['No_new_posts_hot'] = 'Pas de nouveau message [ populaire ]';
$lang['New_posts_hot'] = 'Nouveau message [ populaire ]';
$lang['No_new_posts_locked'] = 'Pas de nouveau message [ verrouillé ]';
$lang['New_posts_locked'] = 'Nouveau message [ verrouillé ]';
$lang['Forum_is_locked'] = 'Forum verrouillé';


//
// Login
//
$lang['Enter_password'] = 'Veuillez entrer votre nom d\'utilisateur et votre mot de passe pour vous connecter.';
$lang['Login'] = 'Connexion';
$lang['Logout'] = 'Déconnexion';
$lang['Forgotten_password'] = 'J\'ai oublié mon mot de passe';

/**
 *	Olympus Style Login Screen 3.0.0, Afterlife(69) of www.afterlife69.com
 *	@ Author	: (1) Afterlife_69
 *	@ Website	: http://www.afterlife69.com
 */
/* --- ADD --- */
$lang['Olympus_login_register']				= 'S\'enregistrer';
$lang['Olympus_login_info']					= 'Pour vous connecter, vous devez être enregistré(e).<br />L\'enregistrement ne prend que quelques secondes et vous donne des accès plus complets.<br /> L\'Administrateur peut aussi donner des permissions additionnelles aux membres enregistrés.<br />Avant de vous connecter, assurez-vous de vous être familiarisé(e) avec le réglement du forum.';
$lang['Olympus_login_index']				= 'Index du Forum';
$lang['Olympus_login_faq']					= 'Voir la F.A.Q.';
$lang['Olympus_login_admin']				= 'Afin de vous connecter au Panneau d\'Administration, vous devez à nouveau vous identifier.<br /><br />Une fois connecté, vous accéderez au Panneau d\'Administration jusqu\'à la fin de votre session.';
$lang['Olympus_login_activate']				= 'Envoyer de nouveau l\'activation';
$lang['Olympus_login_hideme']				= 'Apparaitre \'Hors-Ligne\' lors de cette session';
$lang['Olympus_login_options']				= 'Options';
$lang['Olympus_login_logged_in']			= 'Vous vous êtes connecté(e) avec succés';
$lang['Olympus_login_account_inactive']		= 'Désolé, ce compte est inactif';
$lang['Olympus_login_resend_activation']	= 'Cliquez %sici%s afin de recevoir un nouveau code d\'activation';
$lang['Olympus_login_click_return']			= 'Cliquez %sici%s afin de revenir à la page précédente';
$lang['Olympus_login_reset_password']		= 'Cliquez %sici%s afin de recevoir un nouveau mot de passe';
$lang['Olympus_login_register_account']		= 'Cliquez %sici%s afin de vous enregistrer';
$lang['Olympus_login_not_registered']		= 'Ce compte n\'existe pas';
$lang['Olympus_login_invalid_password']		= 'Votre mot de passe est incorrect';
$lang['Olympus_login_activation_resent']	= 'Une nouvelle clé d\'activation a été envoyée; veuillez vérifier votre e-mail afin de connaître les détails afin d\'activer votre compte.';
$lang['Olympus_login_admin_only_activate']	= 'Votre compte nécessite l\'activation par un administrateur.';
$lang['Olympus_login_account_is_active']	= 'Votre compte est déjà activé.';
$lang['Olympus_redirect_insecure']	= 'Redirection potentielle sur une URL non sécurisée.';
/* --- END --- */

$lang['Log_me_in'] = 'Connexion Automatique ';
$lang['Error_login'] = 'Vous avez spécifié un nom d\'utilisateur incorrect, inactif ou un mot de passe invalide.';

//
// Index page
//
$lang['Index'] = 'Index';
$lang['No_Posts'] = 'Pas de message';
$lang['No_forums'] = 'Ce forum n\'a pas de section';
$lang['Private_Message'] = 'Message privé ';
$lang['Private_Messages'] = 'Messages privés ';
$lang['Who_is_Online'] = 'Qui est en ligne';
$lang['Mark_all_forums'] = 'Déclarer les messages actuellement non-lus en tant que lus';
$lang['Forums_marked_read'] = 'Tous les forums ont été marqués comme lus';


//
// Viewforum
//
$lang['View_forum'] = 'Voir le forum';
$lang['Forum_not_exist'] = 'Le forum que vous avez sélectionné n\'existe pas.';
$lang['Reached_on_error'] = 'Vous avez atteint cette page par erreur.';
$lang['Display_topics'] = 'Montrer les sujets depuis ';
$lang['All_Topics'] = 'Tous les sujets';
$lang['Topic_Global_Announcement'] = '<b>Annonce Globale:</b>';
$lang['Topic_Announcement'] = '<b>Annonce : </b>';
$lang['Topic_Sticky'] = '<b>Note : </b>';
$lang['Topic_Moved'] = '<b>Déplacé : </b>';
$lang['Topic_Poll'] = '<b>Sondage : </b>';
$lang['Mark_all_topics'] = 'Marquer tous les sujets comme lus';
$lang['Topics_marked_read'] = 'Les sujets de ce forum sont maintenant marqués comme lus.';
$lang['Rules_post_can'] = 'Vous <b>pouvez</b> poster de nouveaux sujets dans ce forum';
$lang['Rules_post_cannot'] = 'Vous <b>ne pouvez pas</b> poster de nouveaux sujets dans ce forum';
$lang['Rules_reply_can'] = 'Vous <b>pouvez</b> répondre aux sujets dans ce forum';
$lang['Rules_reply_cannot'] = 'Vous <b>ne pouvez pas</b> répondre aux sujets dans ce forum';
$lang['Rules_edit_can'] = 'Vous <b>pouvez</b> éditer vos messages dans ce forum';
$lang['Rules_edit_cannot'] = 'Vous <b>ne pouvez pas</b> éditer vos messages dans ce forum';
$lang['Rules_delete_can'] = 'Vous <b>pouvez</b> supprimer vos messages dans ce forum';
$lang['Rules_delete_cannot'] = 'Vous <b>ne pouvez pas</b> supprimer vos messages dans ce forum';
$lang['Rules_vote_can'] = 'Vous <b>pouvez</b> répondre aux sondages de ce forum';
$lang['Rules_vote_cannot'] = 'Vous <b>ne pouvez pas</b> répondre aux sondages de ce forum';
$lang['Rules_moderate'] = 'Vous <b>pouvez</b> %smodérer ce forum%s'; // %s replaced by a href links, do not remove! 
$lang['No_topics_post_one'] = 'Il n\'y a pas de message sur ce forum<br />Cliquez sur le lien <b>Poster un Nouveau Sujet</b> pour en écrire un.';


//
// Viewtopic
//

$lang['View_topic'] = 'Voir le sujet';
$lang['Guest'] = 'Invité';
$lang['Post_subject'] = 'Sujet du message';
$lang['View_next_topic'] = 'Voir le sujet suivant';
$lang['View_previous_topic'] = 'Voir le sujet précédent';
$lang['Submit_vote'] = 'Envoyer le vote';
$lang['View_results'] = 'Voir les résultats';
$lang['No_newer_topics'] = 'Il n\'y a pas de nouveau sujet sur ce forum';
$lang['No_older_topics'] = 'Il n\'y a pas d\'ancien sujet sur ce forum';
$lang['Topic_post_not_exist'] = 'Le sujet ou message que vous recherchez n\'existe pas';
$lang['No_posts_topic'] = 'Il n\'existe pas de message pour ce sujet';
$lang['Display_posts'] = 'Montrer les messages depuis ';
$lang['All_Posts'] = 'Tous les messages';
$lang['Newest_First'] = 'Le plus récent en premier';
$lang['Oldest_First'] = 'Le plus ancien en premier';
$lang['Back_to_top'] = 'Revenir en haut';
$lang['Read_profile'] = 'Voir le profil de l\'utilisateur'; 
$lang['Visit_website'] = 'Visiter le site web de l\'utilisateur';
$lang['ICQ_status'] = 'Statut ICQ';
$lang['Edit_delete_post'] = 'Editer/Supprimer ce message';
$lang['View_IP'] = 'Voir l\'adresse IP de l\'utilisateur';
$lang['Delete_post'] = 'Supprimer ce message';
$lang['wrote'] = 'a écrit'; // proceeds the username and is followed by the quoted text
$lang['Quote'] = 'Citation'; // comes before bbcode quote output.
$lang['Code'] = 'Code'; // comes before bbcode code output.
// Extended_PM_Notification MOD
$lang['List'] = 'Liste';
$lang['Ordered_list'] = 'Liste ordonnée';
$lang['Edited_time_total'] = 'Dernière édition : %s le %s; Edité %d fois'; // Last edited by me on 12 Oct 2001, edited 1 time in total
$lang['Edited_times_total'] = 'Dernière édition : %s le %s; Edité %d fois'; // Last edited by me on 12 Oct 2001, edited 2 times in total
$lang['Lock_topic'] = 'Verrouiller le sujet';
$lang['Unlock_topic'] = 'Déverrouiller le sujet';
$lang['Move_topic'] = 'Déplacer le sujet';
$lang['Delete_topic'] = 'Supprimer le sujet';
$lang['Split_topic'] = 'Diviser le sujet';
$lang['Stop_watching_topic'] = 'Arrêter de surveiller ce sujet';
$lang['Start_watching_topic'] = 'Surveiller les réponses de ce sujet';
$lang['No_longer_watching'] = 'Vous ne surveillez plus ce sujet';
$lang['You_are_watching'] = 'Vous surveillez ce sujet maintenant';
//MV MOD -> 
$lang['Total_votes'] = 'Nombre de choix : '; 
$lang['Voted_show'] = 'Nombre de votants : '; // it means : users that voted (the number of voters will follow) 
$lang['Results_after'] = 'Les résultats seront publiés une fois le sondage terminé'; 
$lang['Poll_expires'] = 'Compte à rebours '; 
$lang['Poll_expiredyes'] = 'Sondage expiré'; 
$lang['Poll_noexpire'] = 'Ce sondage est permanent'; 
$lang['Minutes'] = 'minutes'; 
//<- MV MOD

//
// Posting/Replying (Not private messaging!)
//
$lang['Message_body'] = 'Message ';
$lang['Topic_review'] = 'Liste des derniers messages';
$lang['No_post_mode'] = 'Mode du sujet non spécifié'; // If posting.php is called without a mode (newtopic/reply/delete/etc, shouldn't be shown normaly)
$lang['Post_a_new_topic'] = 'Poster un nouveau sujet';
$lang['Post_a_reply'] = 'Poster une réponse';
$lang['Post_topic_as'] = 'Poster le sujet en tant que';
$lang['Edit_Post'] = 'Editer le sujet';
$lang['Options'] = 'Options';
$lang['Post_Global_Announcement'] = 'Annonce Globale';
$lang['Post_Announcement'] = 'Annonce';
$lang['Post_Sticky'] = 'Note';
$lang['Post_Normal'] = 'Normal';
$lang['Confirm_delete'] = 'Etes-vous sûr de vouloir supprimer ce message ?';
$lang['Confirm_delete_poll'] = 'Etes-vous sûr de vouloir supprimer ce sondage ?';
$lang['Flood_Error'] = 'Vous ne pouvez pas poster un autre sujet si peu de temps après le dernier, veuillez réessayer dans un court moment.';
$lang['Empty_subject'] = '<font color=#c00000>Vous devez préciser le nom du sujet avant de pouvoir en poster un nouveau.</font>';
$lang['Empty_message'] = 'Vous devez entrer un message avant de poster.';
$lang['Forum_locked'] = 'Ce forum est verrouillé, vous ne pouvez pas poster, ni répondre, ni éditer les sujets.';
$lang['Topic_locked'] = 'Ce sujet est verrouillé, vous ne pouvez pas éditer les messages ou faire de réponses.';
$lang['No_post_id'] = 'Vous devez sélectionner un message à éditer';
$lang['No_topic_id'] = 'Vous devez sélectionner le sujet auquel répondre';
$lang['No_valid_mode'] = 'Vous pouvez seulement poster, répondre, éditer ou citer des messages, veuillez revenir en arrière et réessayer.';
$lang['No_such_post'] = 'Il n\'y a pas de message de ce type, veuillez revenir en arrière et réessayer.';
$lang['Edit_own_posts'] = 'Désolé, mais vous pouvez seulement éditer vos propres messages.';
$lang['Delete_own_posts'] = 'Désolé, mais vous pouvez uniquement supprimer vos propres messages.';
$lang['Cannot_delete_replied'] = 'Désolé, mais vous ne pouvez pas supprimer un message ayant eu des réponses.';
$lang['Cannot_delete_poll'] = 'Désolé, mais vous ne pouvez pas supprimer un sondage actif.';
$lang['Empty_poll_title'] = 'Vous devez entrer un titre pour le sondage.';
$lang['To_few_poll_options'] = 'Vous devez au moins entrer deux options pour le sondage.';
$lang['To_many_poll_options'] = 'Vous avez entré trop d\'options pour le sondage.';
$lang['Post_has_no_poll'] = 'Ce sujet n\'a pas de sondage.';
$lang['Already_voted'] = 'Vous avez déjà participé à ce sondage.'; 
$lang['No_vote_option'] = 'Vous devez choisir une option avant de répondre.';
$lang['Add_poll'] = 'Ajouter un sondage';
$lang['Add_poll_explain'] = 'Si vous souhaitez envoyer le sujet sans y insérer de sondage, laissez ces champs vides.';
$lang['Poll_question'] = 'Question du sondage';
$lang['Poll_option'] = 'Choix du sondage';
$lang['Add_option'] = 'Ajouter le choix';
$lang['Update'] = 'Mettre à jour';
$lang['Delete'] = 'Supprimer';
$lang['Poll_for'] = 'Sondage pendant';
$lang['Days'] = 'Jours'; // This is used for the Run poll for ... Days + in admin_forums for pruning
$lang['Poll_for_explain'] = '[ Entrez 0 ou laissez vide pour un sondage sans fin ]';
$lang['Delete_poll'] = 'Supprimer le sondage';
//MV MOD -> 
$lang['Max_vote'] = 'Nombre maximum d\'options'; 
$lang['Max_vote_explain'] = '[ Mettez 1, ou laissez ce champ vide pour ne permettre qu\'une réponse ]'; 
$lang['Max_voting_1_explain'] = 'Cochez entre 1 et '; 
$lang['Max_voting_2_explain'] = ' cases !'; 
$lang['Max_voting_3_explain'] = ' (au delà, les coches supplémentaires ne seront pas prise en compte)'; 
$lang['Vhide'] = 'Cacher'; 
$lang['Hide_vote'] = 'les résultats'; 
$lang['Tothide_vote'] = 'le total des réponses'; 
$lang['Hide_vote_explain'] = ' [ jusqu\'à la fin du sondage ]'; 
//<- MV MOD
$lang['Disable_HTML_post'] = 'Désactiver l\'HTML dans ce message';
$lang['Disable_BBCode_post'] = 'Désactiver le BBCode dans ce message';
$lang['Disable_Smilies_post'] = 'Désactiver les émoticônes dans ce message';
$lang['HTML_is_ON'] = 'Le HTML est <u>activé</u>';
$lang['HTML_is_OFF'] = 'Le HTML est <u>désactivé</u>';
$lang['BBCode_is_ON'] = 'Le %sBBCode%s est <u>activé</u>'; // %s are replaced with URI pointing to FAQ
$lang['BBCode_is_OFF'] = 'Le %sBBCode%s est <u>désactivé</u>';
$lang['Smilies_are_ON'] = 'Les émoticônes sont <u>activées</u>';
$lang['Smilies_are_OFF'] = 'Les émoticônes sont <u>désactivées</u>';
$lang['Attach_signature'] = 'Attacher sa signature (les signatures peuvent être modifiées dans le profil)';
$lang['Notify'] = 'Etre averti lorsqu\'une réponse est postée';
$lang['Stored'] = 'Votre message a bien été enregistré.';
$lang['Deleted'] = 'Votre message a bien été supprimé.';
$lang['Poll_delete'] = 'Votre sondage a bien été supprimé.';
$lang['Vote_cast'] = 'Votre vote a été pris en compte.';
$lang['Topic_reply_notification'] = 'Notification de réponse au sujet';
$lang['bbcode_b_help'] = 'Texte gras : [b]texte[/b] (alt+b)';
$lang['bbcode_i_help'] = 'Texte italique : [i]texte[/i] (alt+i)';
$lang['bbcode_u_help'] = 'Texte souligné : [u]texte[/u] (alt+u)';
$lang['bbcode_q_help'] = 'Citation : [quote]texte cité[/quote] (alt+q)';
$lang['bbcode_c_help'] = 'Afficher du code : [code]code[/code] (alt+c)';
$lang['bbcode_l_help'] = 'Liste : [list]texte[/list] (alt+l)';
$lang['bbcode_o_help'] = 'Liste ordonnée : [list=]texte[/list] (alt+o)';
$lang['bbcode_p_help'] = 'Insérer une image : [img]http://image_url/[/img] (alt+p)';
$lang['bbcode_w_help'] = 'Insérer un lien : [url]http://url/[/url] ou [url=http://url/]Nom[/url] (alt+w)';
$lang['bbcode_a_help'] = 'Fermer toutes les balises BBCode ouvertes';
$lang['bbcode_s_help'] = 'Couleur du texte : [color=red]texte[/color] Astuce: #FF0000 fonctionne aussi';
$lang['bbcode_f_help'] = 'Taille du texte : [size=x-small]texte en petit[/size]';
$lang['bbcode_T1_help'] = "Titre de style 1: [titre1]texte[/titre1]";
$lang['bbcode_help']['dailymotion'] = 'Dailymotion: [dailymotion]Dailymotion URL[/dailymotion]';
$lang['bbcode_we_help'] = 'Afficher un Site Web: [website]http://url/[/website] (alt+we)';
$lang['bbcode_help']['dailymotion'] = 'Dailymotion: [dailymotion]dailymotion URL[/dailymotion]';
$lang['bbcode_help']['youtube'] = 'YouTube: [youtube]YouTube URL[/youtube]';
$lang['bbcode_help']['GVideo'] = 'GVideo: [GVideo]GVideo URL[/GVideo]';
$lang['GVideo_link'] = 'Lien';

$lang['Emoticons'] = 'Emoticônes';
$lang['More_emoticons'] = 'Voir plus d\'émoticônes';
$lang['Font_color'] = 'Couleur ';
$lang['color_default'] = 'Défaut';
$lang['color_dark_red'] = 'Rouge foncé';
$lang['color_red'] = 'Rouge';
$lang['color_orange'] = 'Orange';
$lang['color_brown'] = 'Marron';
$lang['color_yellow'] = 'Jaune';
$lang['color_green'] = 'Vert';
$lang['color_olive'] = 'Olive';
$lang['color_cyan'] = 'Cyan';
$lang['color_blue'] = 'Bleu';
$lang['color_dark_blue'] = 'Bleu foncé';
$lang['color_indigo'] = 'Indigo';
$lang['color_violet'] = 'Violet';
$lang['color_white'] = 'Blanc';
$lang['color_black'] = 'Noir';
$lang['Font_size'] = 'Taille ';
$lang['font_tiny'] = 'Très petit';
$lang['font_small'] = 'Petit';
$lang['font_normal'] = 'Normal';
$lang['font_large'] = 'Grand';
$lang['font_huge'] = 'Très grand';
$lang['Close_Tags'] = 'Fermer les balises';
$lang['Styles_tip'] = 'Astuce : une mise en forme peut être appliquée au texte sélectionné.';


//
// Private Messaging
//
$lang['Private_Messaging'] = 'Messagerie';
$lang['Login_check_pm'] = 'Se connecter pour vérifier ses messages privés';
$lang['New_pms'] = '%d nouveaux messages'; // You have 2 new messages
$lang['New_pm'] = '%d nouveau message'; // You have 1 new message
$lang['No_new_pm'] = 'Pas de nouveau message';
$lang['Unread_pms'] = 'Vous avez %d messages non lus';
$lang['Unread_pm'] = 'Vous avez %d message non lu';
$lang['No_unread_pm'] = 'Vous n\'avez pas de message non lus';
$lang['You_new_pm'] = 'Un nouveau message privé vous attend dans votre boîte de réception';
$lang['You_new_pms'] = 'De nouveaux messages privés vous attendent dans votre boîte de réception';
$lang['You_no_new_pm'] = 'Pas de nouveau message privé en attente';
$lang['Read_pm'] = 'Lire le message'; 
$lang['Post_new_pm'] = 'Poster le message'; 
$lang['Post_reply_pm'] = 'Répondre au message'; 
$lang['Post_quote_pm'] = 'Citer le message'; 
$lang['Edit_pm'] = 'Editer le message'; 
$lang['Unread_message'] = 'Message non lu'; 
$lang['Read_message'] = 'Message déjà lu';
$lang['Inbox'] = 'Messages reçus';
$lang['Outbox'] = 'Messages envoyés non lus';
$lang['Savebox'] = 'Sauvegardes';
$lang['Sentbox'] = 'Messages envoyés';
$lang['Flag'] = 'Drapeau ';
$lang['Subject'] = 'Sujet ';
$lang['From'] = 'De ';
$lang['To'] = 'A ';
$lang['Date'] = 'Date ';
$lang['Mark'] = 'Cocher';
$lang['Sent'] = 'Envoyé';
$lang['Saved'] = 'Sauvé';
$lang['Delete_marked'] = 'Supprimer la sélection';
$lang['Delete_all'] = 'Tout supprimer';
$lang['Save_marked'] = 'Sauvegarder la sélection'; 
$lang['Save_message'] = 'Sauvegarder le message';
$lang['Delete_message'] = 'Supprimer le message';
$lang['Display_messages'] = 'Montrer les messages depuis '; // Followed by number of days/weeks/months
$lang['All_Messages'] = 'Tous les messages';
$lang['No_messages_folder'] = 'Vous n\'avez pas de message dans ce dossier';
$lang['PM_disabled'] = 'Les messages privés ont été désactivés sur ce forum.';
$lang['Cannot_send_privmsg'] = 'Désolé, mais l\'administrateur ne vous autorise pas à envoyer des messages privés.';
$lang['No_to_user'] = 'Vous devez préciser un nom d\'utilisateur pour envoyer ce message.';
$lang['No_such_user'] = 'Désolé, mais cet utilisateur n\'existe pas.';
$lang['Disable_HTML_pm'] = 'Désactiver l\'HTML dans ce message';
$lang['Disable_BBCode_pm'] = 'Désactiver le BBCode dans ce message';
$lang['Disable_Smilies_pm'] = 'Désactiver les émoticônes dans ce message';
$lang['Message_sent'] = 'Votre message a été envoyé.';
$lang['Click_return_inbox'] = 'Cliquez %sici%s pour retourner à la liste des messages reçus';
$lang['Click_return_index'] = 'Cliquez %sici%s pour retourner sur le forum';
$lang['Send_a_new_message'] = 'Envoyer un nouveau message privé';
$lang['Send_a_reply'] = 'Répondre à un message privé';
$lang['Edit_message'] = 'Editer un message privé';
$lang['Notification_subject'] = 'Un Nouveau message privé vient d\'arriver.';
$lang['Find_username'] = 'Trouver un nom d\'utilisateur';
$lang['Find'] = 'Trouver';
$lang['No_match'] = 'Aucun enregistrement trouvé.';
$lang['No_post_id'] = 'L\'ID du message n\'a pas été spécifiée';
$lang['No_such_folder'] = 'Le dossier n\'existe pas';
$lang['No_folder'] = 'Pas de dossier spécifié';
$lang['Mark_all'] = 'Tout sélectionner';
$lang['Unmark_all'] = 'Tout désélectionner';
$lang['Confirm_delete_pm'] = 'Etes-vous sûr de vouloir supprimer ce message ?';
$lang['Confirm_delete_pms'] = 'Etes-vous sûr de vouloir supprimer ces messages ?';
$lang['Inbox_size'] = 'Votre boîte de messages reçus est pleine à %d%%'; // eg. Your Inbox is 50% full
$lang['Sentbox_size'] = 'Votre boîte de messages envoyés est pleine à %d%%'; 
$lang['Savebox_size'] = 'Votre boîte de sauvegarde est pleine à %d%%'; 
$lang['Click_view_privmsg'] = 'Cliquez %sici%s pour voir votre boîte des messages reçus';


//
// Profiles/Registration
//
$lang['Viewing_user_profile'] = 'Profil de %s'; // %s is username 
$lang['About_user'] = 'Tout à propos de %s'; // %s is username
$lang['Preferences'] = 'Préférences';
$lang['Items_required'] = 'Les champs marqué d\'un * sont obligatoires. <b>Attention Allez dans Profil également...</b>';
$lang['Registration_info'] = 'Enregistrement';
$lang['Profile_info'] = 'Profil';
$lang['Profile_info_warn'] = 'Ces informations seront visibles publiquement';
$lang['Avatar_panel'] = 'Panneau de contrôle des avatars';
$lang['Avatar_gallery'] = 'Galerie des avatars';
$lang['Website'] = 'Site Web ';
$lang['Location'] = 'Localisation ';
$lang['Contact'] = 'Contacter';
$lang['Email_address'] = 'Adresse e-mail ';
$lang['Send_private_message'] = 'Envoyer un message privé';
$lang['Hidden_email'] = '[ Invisible ]';
$lang['Interests'] = 'Loisirs ';
$lang['Occupation'] = 'Emploi '; 
$lang['Poster_rank'] = 'Rang du membre ';
$lang['Total_posts'] = 'Messages ';
$lang['User_post_pct_stats'] = '%.2f%% du total'; // 1.25% of total
$lang['User_post_day_stats'] = '%.2f messages par jour'; // 1.5 posts per day
$lang['Search_user_posts'] = 'Trouver tous les messages de %s'; // Find all posts by username
$lang['No_user_id_specified'] = 'Désolé, mais cet utilisateur n\'existe pas.';
$lang['Wrong_Profile'] = 'Vous ne pouvez pas modifier un profil qui n\'est pas le vôtre.';
$lang['Only_one_avatar'] = 'Seul un type d\'avatar peut être spécifié';
$lang['File_no_data'] = 'L\'adresse que vous avez entrée ne contient aucune donnée';
$lang['No_connection_URL'] = 'Une connexion ne peut être établie avec l\'adresse que vous avez donnée';
$lang['Incomplete_URL'] = 'L\'adresse que vous avez entrée est incomplète';
$lang['Wrong_remote_avatar_format'] = 'L\'adresse de l\'avatar est invalide';
$lang['No_send_account_inactive'] = 'Désolé, mais votre mot de passe ne peut pas être renouvelé étant donné que votre compte est actuellement inactif. Veuillez contacter l\'administrateur du forum afin d\'obtenir de plus amples informations.';
$lang['Always_smile'] = 'Toujours activer les émoticônes ';
$lang['Always_html'] = 'Toujours autoriser l\'HTML ';
$lang['Always_bbcode'] = 'Toujours autoriser le BBCode ';
$lang['Always_add_sig'] = 'Toujours attacher sa signature ';
$lang['Always_notify'] = 'Toujours m\'avertir des réponses ';
$lang['Always_notify_explain'] = 'Envoi d\'un e-mail lorsqu\'un utilisateur répond aux sujets que vous avez postés. Ceci peut être changé chaque fois que vous postez.';
$lang['Board_style'] = 'Thème du forum ';
$lang['Board_lang'] = 'Langue du forum ';
$lang['No_themes'] = 'Pas de thème dans la base de données';
$lang['Timezone'] = 'Fuseau horaire ';
$lang['Date_format'] = 'Format de la date ';
$lang['Date_format_explain'] = 'La syntaxe utilisée est identique à la fonction <a href=\'http://www.php.net/manual/fr/function.date.php\' target=\'_other\'>date()</a> du PHP.';
$lang['Signature'] = 'Signature ';
$lang['Signature_explain'] = 'Ceci est un bloc de texte qui peut être ajouté aux messages que vous postez. Il y a une limite de %d caractères.';
$lang['Public_view_email'] = 'Toujours montrer son adresse e-mail ';
$lang['Current_password'] = 'Mot de passe actuel ';
$lang['New_password'] = 'Nouveau mot de passe ';
$lang['Confirm_password'] = 'Confirmer le mot de passe ';
$lang['Confirm_password_explain'] = 'Vous devez confirmer votre mot de passe si vous souhaitez modifier votre adresse e-mail.';
$lang['password_if_changed'] = 'Vous avez seulement besoin de fournir un mot de passe si vous voulez le changer.';
$lang['password_confirm_if_changed'] = 'Vous avez seulement besoin de confirmer votre mot de passe si vous l\'avez changé ci-dessus.';
$lang['Avatar'] = 'Avatar ';
$lang['Avatar_explain'] = 'Affiche une petite image au-dessous de vos détails dans vos messages. Seule une image peut être affichée à la fois, sa largeur ne peut pas dépasser %d pixels, sa hauteur %d pixels et la taille du fichier, pas plus de %d ko.';
$lang['Upload_Avatar_file'] = 'Envoyer l\'avatar depuis votre ordinateur ';
$lang['Upload_Avatar_URL'] = 'Envoyer l\'avatar à partir d\'une URL ';
$lang['Upload_Avatar_URL_explain'] = 'Entrez l\'URL de l\'image, elle sera copiée sur ce site.';
$lang['Pick_local_Avatar'] = 'Sélectionner un avatar de la galerie ';
$lang['Link_remote_Avatar'] = 'Lier l\'avatar à partir d\'un autre site ';
$lang['Link_remote_Avatar_explain'] = 'Entrez l\'URL de l\'image que vous voulez lier.';
$lang['Avatar_URL'] = 'URL de l\'image ';
$lang['Select_from_gallery'] = 'Sélectionner un avatar à partir de la galerie ';
$lang['View_avatar_gallery'] = 'Montrer la galerie ';
$lang['Select_avatar'] = 'Sélectionner l\'avatar';
$lang['Return_profile'] = 'Annuler';
$lang['Select_category'] = 'Sélectionner une catégorie ';
$lang['Delete_Image'] = 'Supprimer l\'image';
$lang['Current_Image'] = 'Image actuelle';
$lang['Notify_on_privmsg'] = 'M\'avertir des nouveaux messages privés ';
$lang['Popup_on_privmsg'] = 'Ouverture d\'une pop-up lors de nouveaux messages privés '; 
$lang['Popup_on_privmsg_explain'] = 'Certains thèmes peuvent ouvrir une nouvelle fenêtre pour vous informer de l\'arrivée de nouveaux messages privés.'; 
$lang['Hide_user'] = 'Cacher sa présence en ligne ';
$lang['Profile_updated'] = 'Votre profil a été mis à jour.';
$lang['Profile_see'] = 'Cliquez %sici%s pour retourner à votre profil';
$lang['Profile_updated_inactive'] = 'Votre profil a été mis à jour, toutefois vous avez modifié des détails importants, votre compte est donc inactif. Vérifiez vos e-mails pour savoir comment réactiver votre compte, ou si l\'activation par l\'administrateur est requise, patientez jusqu\'à ce qu\'il le réactive.';
$lang['Password_mismatch'] = 'Les mots de passe que avez entrés sont différents.';
$lang['Current_password_mismatch'] = 'Le mot de passe que vous avez fourni est différent de celui stocké dans la base de données.';
$lang['Password_long'] = 'Votre mot de passe ne doit pas dépasser 32 caractères.';
$lang['Username_taken'] = 'Désolé, mais ce nom d\'utilisateur est déjà pris.';
$lang['Username_invalid'] = 'Désolé, mais ce nom d\'utilisateur contient un caractère invalide comme \' par exemple.';
$lang['Username_disallowed'] = 'Désolé, mais ce nom d\'utilisateur a été interdit.';
$lang['Email_taken'] = 'Désolé, mais cette adresse e-mail est déjà enregistrée par un autre utilisateur.';
$lang['Email_banned'] = 'Désolé, mais cette adresse e-mail a été bannie.';
$lang['Email_invalid'] = 'Désolé, mais cette adresse e-mail est invalide.';
$lang['Signature_too_long'] = 'Votre signature est trop longue.';
$lang['Fields_empty'] = 'Vous devez compléter les champs obligatoires.';
$lang['Avatar_filetype'] = 'Le type de fichier de l\'avatar doit être .jpg, .gif ou .png';
$lang['Avatar_filesize'] = 'La taille de l\'avatar doit être inférieure à %d ko'; // The avatar image file size must be less than 6 ko
$lang['Avatar_imagesize'] = 'La taille de l\'avatar doit être de %d pixels de largeur et de %d pixels de hauteur'; 
$lang['Welcome_subject'] = 'Bienvenue sur les forums de %s'; // Welcome to my.com forums
$lang['New_account_subject'] = 'Nouveau compte utilisateur';
$lang['Account_activated_subject'] = 'Compte activé';
$lang['Account_added'] = 'Merci de vous être enregistré, votre compte a été créé. Vous pouvez vous connecter avec votre nom d\'utilisateur et votre mot de passe.';
$lang['Account_inactive'] = 'Votre compte a été créé. Toutefois, votre compte est inactif et doit être activé. Une clé d\'activation a été envoyée à l\'adresse e-mail que vous avez fournie. Veuillez vérifier vos e-mails pour plus de détails.';
$lang['Account_inactive_admin'] = 'Votre compte a été créé. Toutefois, ce forum requiert que votre compte soit activé par l\'administrateur. Un e-mail lui a été envoyé et vous serez informé lorsque votre compte sera activé.';
$lang['Account_active'] = 'Votre compte a été activé. Merci de vous être inscrit';
$lang['Account_active_admin'] = 'Le compte a été activé';
$lang['Already_activated'] = 'Votre compte est déjà activé';
$lang['Reactivate'] = 'Réactivez votre compte !';
$lang['COPPA'] = 'Votre compte a été créé, mais il doit être approuvé, veuillez vérifier vos e-mails pour plus de détails.';
$lang['Registration'] = 'Inscription - Règlement';
//-- mod : vAgreement Terms ----------------------------------------------------
$lang['Reg_agreement'] = '<font color="red"><b>Message</b></font><br />Les administrateurs et modérateurs de ce forum s\'efforceront de supprimer ou d\'éditer tous les messages à caractère répréhensible aussi rapidement que possible. Toutefois, il leur est impossible de passer en revue tous les messages. Vous admettez donc que tous les messages postés sur ces forums expriment la vue et l\'opinion de leurs auteurs respectifs, et non pas des administrateurs, ou modérateurs, ou webmestres (excepté les messages postés par eux-même) et par conséquent ils ne peuvent être tenus pour responsables.<br /><br /><font color="red"><b>Contenu de vos messages</b></font><br />Vous consentez à ne pas poster de messages injurieux, obscènes, vulgaires, diffamatoires, menaçants, sexuels ou tout autre message qui violerait les lois applicables. Le faire peut vous conduire à être banni immédiatement et de façon permanente (et votre fournisseur d\'accès à internet en sera informé). L\'adresse IP de chaque message est enregistrée afin d\'aider à faire respecter ces conditions. Vous êtes d\'accord sur le fait que le webmestre, l\'administrateur et les modérateurs de ce forum ont le droit de supprimer, éditer, déplacer ou verrouiller n\'importe quel sujet de discussion à tout moment. En tant qu\'utilisateur, vous êtes d\'accord sur le fait que toutes les informations que vous donnerez ci-après seront stockées dans une base de données. Cependant, ces informations ne seront divulguées à aucune tierce personne ou société sans votre accord. Le webmestre, l\'administrateur, et les modérateurs ne peuvent pas être tenus pour responsables si une tentative de piratage informatique conduit à l\'accès de ces données.<br /><br /><font color="red"><b>Informations collectées et Cookies</b></font><br />Ce forum utilise les cookies pour stocker des informations sur votre ordinateur. Ces cookies ne contiendront aucune information que vous aurez entrée ci-après, ils servent uniquement à améliorer le confort d\'utilisation. L\'adresse e-mail est uniquement utilisée afin de confirmer les détails de votre inscription ainsi que votre mot de passe (et aussi pour vous envoyer un nouveau mot de passe dans le cas où vous l\'oublieriez).<br /><br /><font color="red"><b>Vous acceptez...</b></font><br />En vous inscrivant, vous vous portez garant du fait d\'être en accord avec le règlement ci-dessus.';
$lang['To_Join'] = 'Avant de procéder à votre inscription définitive, vous devez manifester votre accord avec les règles suivantes :';
$lang['Forum_Rules'] = 'Règles du forum';
$lang['Agree_checkbox'] = 'J\'ai lu et accepte de respecter les règles du forum %s.';
//-- fin mod : vAgreement Terms ------------------------------------------------
$lang['Agree_under_13'] = 'J\'accepte le règlement et j\'ai <b>moins</b> de 13 ans';
$lang['Agree_over_13'] = 'J\'accepte le règlement et j\'ai <b>exactement</b> ou <b>plus</b> de 13 ans';
$lang['Agree_not'] = 'Je n\'accepte pas le règlement';
$lang['Wrong_activation'] = 'La clef d\'activation que vous avez fournie ne correspond pas à celle de la base de données.';
$lang['Send_password'] = 'Envoyez-moi un nouveau mot de passe'; 
$lang['Password_updated'] = 'Un nouveau mot de passe a été créé, veuillez vérifier vos e-mail pour plus de détails concernant l\'activation de celui-ci.';
$lang['No_email_match'] = 'L\'adresse e-mail que vous avez fournie ne correspond pas avec celle qui a été utilisée pour ce nom d\'utilisateur.';
$lang['New_password_activation'] = 'Activation d\'un nouveau mot de passe';
$lang['Password_activated'] = 'Votre compte a été réactivé. Pour vous connecter, veuillez utiliser le mot de passe fourni dans l\'e-mail que vous avez reçu.';
$lang['Send_email_msg'] = 'Envoyer un e-mail';
$lang['No_user_specified'] = 'Aucun utilisateur spécifié';
$lang['User_prevent_email'] = 'Cet utilisateur ne souhaite pas recevoir d\'e-mail. Essayez de lui envoyer un message privé.';
$lang['User_not_exist'] = 'Cet utilisateur n\'existe pas';
$lang['CC_email'] = 'Recevoir une copie de cet e-mail';
$lang['Email_message_desc'] = 'Ce message sera envoyé en texte plein, n\'insérez aucun code HTML ou BBCode. L\'adresse de réponse pour ce message sera celle de votre e-mail.';
$lang['Flood_email_limit'] = 'Vous ne pouvez pas envoyer un autre e-mail pour le moment, essayez plus tard';
$lang['Recipient'] = 'Destinataire';
$lang['Email_sent'] = 'L\'e-mail a été envoyé.';
$lang['Send_email'] = 'Envoyer l\'e-mail';
$lang['Empty_subject_email'] = 'Vous devez spécifier le sujet pour l\'e-mail.';
$lang['Empty_message_email'] = 'Vous devez entrer un message pour qu\'il soit expédié.';


//
// Visual confirmation system settings
//
$lang['Confirm_code_wrong'] = 'Le code de confirmation que vous avez entré ne correspond pas à celui de l\'image. Veuillez essayer à nouveau.';
$lang['Too_many_registers'] = 'Vous avez dépassé le nombre de tentatives d\'enregistrements pour cette session. Veuillez réessayer ultérieurement.';
$lang['Confirm_code_impaired'] = 'Si vous êtes visuellement déficient ou si vous ne pouvez lire ce code, veuillez contacter l\'%sAdministrateur%s afin d\'obtenir de l\'aide.';
$lang['Confirm_code'] = 'Code de confirmation ';
$lang['Confirm_code_explain'] = 'Entrez exactement le code que vous voyez sur l\'image.';


//
// Memberslist
//
$lang['Select_sort_method'] = 'Sélectionner la méthode de tri ';
$lang['Sort'] = 'Trier';
$lang['Sort_Top_Ten'] = 'Top 10 des Membres';
$lang['Sort_Joined'] = 'Inscrit le';
$lang['Sort_Username'] = 'Nom d\'utilisateur';
$lang['Sort_Location'] = 'Localisation';
$lang['Sort_Posts'] = 'Messages';
$lang['Sort_Email'] = 'E-mail';
$lang['Sort_Website'] = 'Site Web';
$lang['Sort_Ascending'] = 'Croissant';
$lang['Sort_Descending'] = 'Décroissant';
$lang['Order'] = 'Ordre ';


//
// Group control panel
//
$lang['Group_Control_Panel'] = 'Panneau de Contrôle des Groupes';
$lang['Group_member_details'] = 'Détails des groupes ';
$lang['Group_member_join'] = 'Rejoindre un groupe';
$lang['Group_Information'] = 'Information du groupe';
$lang['Group_name'] = 'Nom du groupe ';
$lang['Group_description'] = 'Description du groupe ';
$lang['Group_membership'] = 'Votre statut ';
$lang['Group_Members'] = 'Membres du groupe';
$lang['Group_Moderator'] = 'Modérateur du groupe';
$lang['Pending_members'] = 'Membres en attente';
$lang['Group_type'] = 'Type de groupe ';
$lang['Group_open'] = 'Groupe ouvert';
$lang['Group_closed'] = 'Groupe fermé';
$lang['Group_hidden'] = 'Groupe invisible';
$lang['Current_memberships'] = 'Membre du groupe';
$lang['Non_member_groups'] = 'Non-membre du groupe';
$lang['Memberships_pending'] = 'Adhésions en attente';
$lang['No_groups_exist'] = 'Aucun groupe n\'existe';
$lang['Group_not_exist'] = 'Ce groupe d\'utilisateurs n\'existe pas';
$lang['Join_group'] = 'Rejoindre le Groupe';
$lang['No_group_members'] = 'Ce groupe n\'a pas de membres';
$lang['Group_hidden_members'] = 'Ce groupe est invisible ; vous ne pouvez pas voir sa composition';
$lang['No_pending_group_members'] = 'Ce groupe n\'a pas d\'utilisateurs en attente';
$lang['Group_joined'] = 'Vous vous êtes inscrit à ce groupe avec succès.<br />Vous serez averti lorsque votre inscription sera approuvée par le modérateur du groupe.';
$lang['Group_request'] = 'Une requête d\'adhésion à votre groupe a été faite.';
$lang['Group_approved'] = 'Votre requête a été approuvée.';
$lang['Group_added'] = 'Vous avez été admis dans ce groupe d\'utilisateurs.';
$lang['Already_member_group'] = 'Vous êtes déjà membre de ce groupe';
$lang['User_is_member_group'] = 'L\'utilisateur est déjà membre de ce groupe';
$lang['Group_type_updated'] = 'Vous avez mis à jour le type de groupe avec succès.';
$lang['Could_not_add_user'] = 'L\'utilisateur que vous avez sélectionné n\'existe pas.';
$lang['Could_not_anon_user'] = 'Vous ne pouvez pas définir un invité en tant que membre d\'un groupe.';
$lang['Confirm_unsub'] = 'Etes-vous sûr de vous vouloir vous désinscrire de ce groupe ?';
$lang['Confirm_unsub_pending'] = 'Votre inscription à ce groupe n\'a pas encore été approuvée ; êtes-vous sûr de vouloir vous désinscrire ?';
$lang['Unsub_success'] = 'Vous avez été désinscrit de ce groupe.';
$lang['Approve_selected'] = 'Approuver la sélection';
$lang['Deny_selected'] = 'Refuser la sélection';
$lang['Not_logged_in'] = 'Vous devez être connecté pour rejoindre un groupe.';
$lang['Remove_selected'] = 'Supprimer la sélection';
$lang['Add_member'] = 'Ajouter l\'utilisateur';
$lang['Not_group_moderator'] = 'Vous n\'êtes pas le modérateur de ce groupe, vous ne pouvez donc pas accomplir cette action.';
$lang['Login_to_join'] = 'Connectez-vous pour rejoindre ou gérer les adhésions du groupe';
$lang['This_open_group'] = 'Ceci est un groupe ouvert : cliquez pour faire une demande d\'adhésion';
$lang['This_closed_group'] = 'Ceci est un groupe fermé : plus aucun utilisateur accepté';
$lang['This_hidden_group'] = 'Ceci est groupe invisible : l\'ajout automatique d\'utilisateurs n\'est pas autorisé';
$lang['Member_this_group'] = 'Vous êtes membre du groupe';
$lang['Pending_this_group'] = 'Votre adhésion à ce groupe est en attente';
$lang['Are_group_moderator'] = 'Vous êtes le modérateur du groupe';
$lang['None'] = 'Aucun';
$lang['Subscribe'] = 'S\'inscrire';
$lang['Unsubscribe'] = 'Se désinscrire';
$lang['View_Information'] = 'Voir les informations';


//
// Search
//
$lang['Search_query'] = 'Rechercher';
$lang['Advanced_Search'] = 'Recherche avancée';
$lang['Search_options'] = 'Options de recherche';
$lang['Search_keywords'] = 'Recherche par mots-clés ';
$lang['Search_keywords_explain'] = 'Vous pouvez utiliser <u>AND</u> pour déterminer les mots qui seront visibles dans les résultats, <u>OR</u> pour déterminer les mots qui peuvent être visibles dans les résultats et <u>NOT</u> pour déterminer les mots qui ne doivent pas être visibles dans les résultats. Utilisez * comme un joker pour des recherches partielles.';
$lang['Search_author'] = 'Recherche par auteur ';
$lang['Search_author_explain'] = 'Utilisez * comme un joker pour des recherches partielles.';
$lang['Search_for_any'] = 'Rechercher n\'importe lequel de ces termes';
$lang['Search_for_all'] = 'Rechercher tous les termes';
$lang['Search_title_msg'] = 'Rechercher dans les titres et messages';
$lang['Search_msg_only'] = 'Rechercher dans les messages uniquement';
$lang['Return_first'] = 'Retourner les '; // followed by xxx characters in a select box
$lang['characters_posts'] = 'premiers caractères des messages';
$lang['Search_previous'] = 'Rechercher depuis '; // followed by days, weeks, months, year, all in a select box
$lang['Sort_by'] = 'Trier par ';
$lang['Sort_Time'] = 'Heure du message';
$lang['Sort_Post_Subject'] = 'Sujet du message';
$lang['Sort_Topic_Title'] = 'Titre du sujet';
$lang['Sort_Author'] = 'Auteur';
$lang['Sort_Forum'] = 'Forum';
$lang['Display_results'] = 'Afficher les résultats sous forme de ';
$lang['All_available'] = 'Tous disponibles';
$lang['No_searchable_forums'] = 'Vous n\'avez pas la permission de rechercher un quelconque forum sur ce site.';
$lang['No_search_match'] = 'Aucun sujet ou message ne correspond à vos critères de recherche';
$lang['Found_search_match'] = '%d résultat trouvé'; // eg. Search found 1 match
$lang['Found_search_matches'] = '%d résultats trouvés'; // eg. Search found 24 matches
$lang['Close_window'] = 'Fermer la fenêtre';


//
// Auth related entries
//
// Note the %s will be replaced with one of the following 'user' arrays
$lang['Sorry_auth_announce'] = 'Désolé, mais seuls les %s peuvent poster des annonces dans ce forum.';
$lang['Sorry_auth_sticky'] = 'Désolé, mais seuls les %s peuvent poster des notes dans ce forum.';
$lang['Sorry_auth_read'] = 'Désolé, mais seuls les %s peuvent lire des sujets dans ce forum.';
$lang['Sorry_auth_post'] = 'Désolé, mais seuls les %s peuvent poster dans ce forum.';
$lang['Sorry_auth_reply'] = 'Désolé, mais seuls les %s peuvent répondre aux messages dans ce forum.';
$lang['Sorry_auth_edit'] = 'Désolé, mais seuls les %s peuvent éditer des messages dans ce forum.';
$lang['Sorry_auth_delete'] = 'Désolé, mais seuls les %s peuvent supprimer des messages dans ce forum.';
$lang['Sorry_auth_vote'] = 'Désolé, mais seuls les %s peuvent répondre aux sondages dans ce forum.';

// These replace the %s in the above strings
$lang['Auth_Anonymous_Users'] = '<b>utilisateurs anonymes</b>';
$lang['Auth_Registered_Users'] = '<b>utilisateurs enregistrés</b>';
$lang['Auth_Users_granted_access'] = '<b>utilisateurs avec un accès spécial</b>';
$lang['Auth_Moderators'] = '<b>modérateurs</b>';
$lang['Auth_Administrators'] = '<b>administrateurs</b>';
$lang['Not_Moderator'] = 'Vous n\'êtes pas modérateur sur ce forum.';
$lang['Not_Authorised'] = 'Non Autorisé';
$lang['You_been_banned'] = 'Vous avez été banni de ce forum.<br />Veuillez contacter le webmestre ou l\'administrateur du forum pour plus de détails.';

//
// Online/Offline
//
$lang['Offline'] = 'Hors-ligne';
$lang['Online'] = 'En ligne';
$lang['Hidden'] = 'Caché';
$lang['On_off_status'] = 'Statut';

//
// Viewonline
//
$lang['Reg_users_zero_online'] = 'Il n\'y aucun utilisateur enregistré et '; // There are 5 Registered and
$lang['Reg_users_online'] = 'Il y a %d utilisateurs incrits et '; // There are 5 Registered and
$lang['Reg_user_online'] = 'Il y a %d utilisateur inscrit et '; // There is 1 Registered and
$lang['Hidden_users_zero_online'] = 'aucun utilisateur invisible en ligne'; // 6 Hidden users online
$lang['Hidden_users_online'] = '%d utilisateurs invisibles en ligne'; // 6 Hidden users online
$lang['Hidden_user_online'] = '%d utilisateur invisible en ligne'; // 6 Hidden users online
$lang['Guest_users_zero_online'] = 'Il n\'y aucun invité en ligne'; // There are 10 Guest users online
$lang['Guest_users_online'] = 'Il y a %d invités en ligne'; // There are 10 Guest users online
$lang['Guest_user_online'] = 'Il y a %d invité en ligne'; // There is 1 Guest user online
$lang['No_users_browsing'] = 'Il n\'y a actuellement personne sur ce forum';
$lang['Online_explain'] = 'Données basées sur les utilisateurs actifs lors des cinq dernières minutes.';
$lang['Forum_Location'] = 'Position sur le forum';
$lang['Last_updated'] = 'Dernière mise à jour';
$lang['Forum_index'] = 'Index du Forum';
$lang['Logging_on'] = 'Se connecte';
$lang['Posting_message'] = 'Poste un message';
$lang['Searching_forums'] = 'Recherche sur le forum';
$lang['Viewing_profile'] = 'Regarde un profil';
$lang['Viewing_online'] = 'Regarde qui est en ligne';
$lang['Viewing_member_list'] = 'Regarde la liste des membres';
$lang['Viewing_priv_msgs'] = 'Regarde ses messages privés';
$lang['Viewing_FAQ'] = 'Regarde la FAQ';
$lang['Viewing_ADR'] = 'Sur le RPG';
$lang['Viewing_RABBITOSHI'] = 'Regarde l\'animalerie';


//
// Moderator Control Panel
//
$lang['Mod_CP'] = 'Panneau de Contrôle des Modérateurs';
$lang['Mod_CP_explain'] = 'En utilisant le formulaire ci-dessous, vous pouvez accomplir des opérations de modération de masse sur ce forum. Vous pouvez verrouiller, déverrouiller, déplacer ou supprimer n\'importe quel nombre de sujets.';
$lang['Select'] = 'Sélectionner';
$lang['Delete'] = 'Supprimer';
$lang['Move'] = 'Déplacer';
$lang['Lock'] = 'Verrouiller';
$lang['Unlock'] = 'Déverrouiller';
$lang['Topics_Removed'] = 'Le(s) sujet(s) sélectionné(s) a/ont été retiré(s) de la base de données avec succès.';
$lang['Topics_Locked'] = 'Le(s) sujet(s) sélectionné(s) a/ont été verrouillé(s).';
$lang['Topics_Moved'] = 'Le(s) sujet(s) sélectionné(s) a/ont été déplacé(s).';
$lang['Topics_Unlocked'] = 'Le(s) sujet(s) sélectionné(s) a/ont été déverrouillé(s).';
$lang['No_Topics_Moved'] = 'Aucun sujet n\'a été déplacé.';
$lang['Confirm_delete_topic'] = 'Etes-vous sûr de vouloir supprimer le(s) sujet(s) sélectionné(s) ?';
$lang['Confirm_lock_topic'] = 'Etes-vous sûr de vouloir verrouiller le(s) sujet(s) sélectionné(s) ?';
$lang['Confirm_unlock_topic'] = 'Etes-vous sûr de vouloir déverrouiller le(s) sujet(s) sélectionné(s) ?';
$lang['Confirm_move_topic'] = 'Etes-vous sûr de vouloir déplacer le(s) sujet(s) sélectionné(s) ?';
$lang['Move_to_forum'] = 'Déplacer vers le forum';
$lang['Leave_shadow_topic'] = 'Laisser un traceur dans l\'ancien forum.';
$lang['Split_Topic'] = 'Panneau de Contrôle des sujets à diviser';
$lang['Split_Topic_explain'] = 'En utilisant le formulaire ci-dessous, vous pouvez diviser un sujet en deux sujets, soit en sélectionnant les messages individuellement, soit en divisant à partir d\'un message sélectionné.';
$lang['Split_title'] = 'Titre du nouveau sujet';
$lang['Split_forum'] = 'Forum du nouveau sujet';
$lang['Split_posts'] = 'Diviser les messages sélectionnés';
$lang['Split_after'] = 'Diviser à partir des messages sélectionnés';
$lang['Topic_split'] = 'Le sujet sélectionné a été divisé avec succès';
// start mod split posts and merge in one step
$lang['If_title_blank'] = '<br />(indiquez le nouveau titre du topic; laissez vide pour fusionner un message non divisé avec un sujet le sujet spécifié ci-dessous)';
$lang['Destination_topic'] = 'Destination du sujet';
$lang['Destination_topic_format'] = '<br />(Pour fusionner un sujet existant, insérez l\'ID du sujet ou son URL, ou insérez l\'URL d\'un post dans ce sujet)';
$lang['Forgot_to_specify'] = 'Vous avez oublié de spécifier un sujet ou un topic de destination.';
$lang['Split_move_or_copy'] = 'Déplacer ou copier';
$lang['Split_move'] = 'Déplacer';
$lang['Split_copy'] = 'Copier';
$lang['Split_move_or_copy_explanation'] = '<br />(Pour déplacer des posts divisés vers un nouveau topic, sélectionnez \'Déplacer\'; Pour copier les posts divisés vers un nouveau topic en le laissant également dans le vieux topic, sélectionnez \'Copier\')';
// end mod split posts and merge in one step
$lang['Too_many_error'] = 'Vous avez sélectionné trop de messages. Vous ne pouvez seulement sélectionner qu\'un seul message pour diviser le sujet à partir de ce message !';
$lang['None_selected'] = 'Vous n\'avez sélectionné aucun sujet pour accomplir cette opération. Veuillez revenir en arrière et sélectionnez-en au moins un.';
$lang['New_forum'] = 'Nouveau forum';
$lang['This_posts_IP'] = 'Adresse IP de ce message';
$lang['Other_IP_this_user'] = 'Autres adresses IP à partir desquelles cet utilisateur a posté';
$lang['Users_this_IP'] = 'Utilisateurs postant à partir de cette adresse IP';
$lang['IP_info'] = 'Informations sur l\'adresse IP';
$lang['Lookup_IP'] = 'Chercher l\'adresse IP';


//
// Timezones ... for display on each page
//
$lang['All_times'] = 'Les heures sont au format %s'; // eg. All times are GMT - 12 Hours (times from next block)
$lang['-12'] = 'GMT - 12 heures';
$lang['-11'] = 'GMT - 11 heures';
$lang['-10'] = 'GMT - 10 heures';
$lang['-9'] = 'GMT - 9 heures';
$lang['-8'] = 'GMT - 8 heures';
$lang['-7'] = 'GMT - 7 heures';
$lang['-6'] = 'GMT - 6 heures';
$lang['-5'] = 'GMT - 5 heures';
$lang['-4'] = 'GMT - 4 heures';
$lang['-3.5'] = 'GMT - 3,5 heures';
$lang['-3'] = 'GMT - 3 heures';
$lang['-2'] = 'GMT - 2 heures';
$lang['-1'] = 'GMT - 1 heure';
$lang['0'] = 'GMT';
$lang['1'] = 'GMT + 1 heure';
$lang['2'] = 'GMT + 2 heures';
$lang['3'] = 'GMT + 3 heures';
$lang['3.5'] = 'GMT + 3,5 heures';
$lang['4'] = 'GMT + 4 heures';
$lang['4.5'] = 'GMT + 4,5 heures';
$lang['5'] = 'GMT + 5 heures';
$lang['5.5'] = 'GMT + 5,5 heures';
$lang['6'] = 'GMT + 6 heures';
$lang['6.5'] = 'GMT + 6.5 heures';
$lang['7'] = 'GMT + 7 heures';
$lang['8'] = 'GMT + 8 heures';
$lang['9'] = 'GMT + 9 heures';
$lang['9.5'] = 'GMT + 9,5 heures';
$lang['10'] = 'GMT + 10 heures';
$lang['11'] = 'GMT + 11 heures';
$lang['12'] = 'GMT + 12 heures';
$lang['13'] = 'GMT + 13 heures';
// These are displayed in the timezone select box
$lang['tz']['-12'] = 'GMT - 12 heures';
$lang['tz']['-11'] = 'GMT - 11 heures';
$lang['tz']['-10'] = 'GMT - 10 heures';
$lang['tz']['-9'] = 'GMT - 9 heures';
$lang['tz']['-8'] = 'GMT - 8 heures';
$lang['tz']['-7'] = 'GMT - 7 heures';
$lang['tz']['-6'] = 'GMT - 6 heures';
$lang['tz']['-5'] = 'GMT - 5 heures';
$lang['tz']['-4'] = 'GMT - 4 heures';
$lang['tz']['-3.5'] = 'GMT - 3:30 heures';
$lang['tz']['-3'] = 'GMT - 3 heures';
$lang['tz']['-2'] = 'GMT - 2 heures';
$lang['tz']['-1'] = 'GMT - 1 heure';
$lang['tz']['0'] = 'GMT';
$lang['tz']['1'] = 'GMT + 1 heure';
$lang['tz']['2'] = 'GMT + 2 heures';
$lang['tz']['3'] = 'GMT + 3 heures';
$lang['tz']['3.5'] = 'GMT + 3:30 heures';
$lang['tz']['4'] = 'GMT + 4 heures';
$lang['tz']['4.5'] = 'GMT + 4:30 heures';
$lang['tz']['5'] = 'GMT + 5 heures';
$lang['tz']['5.5'] = 'GMT + 5:30 heures';
$lang['tz']['6'] = 'GMT + 6 heures';
$lang['tz']['6.5'] = 'GMT + 6:30 heures';
$lang['tz']['7'] = 'GMT + 7 heures';
$lang['tz']['8'] = 'GMT + 8 heures';
$lang['tz']['9'] = 'GMT + 9 heures';
$lang['tz']['9.5'] = 'GMT + 9:30 heures';
$lang['tz']['10'] = 'GMT + 10 heures';
$lang['tz']['11'] = 'GMT + 11 heures';
$lang['tz']['12'] = 'GMT + 12 heures';
$lang['tz']['13'] = 'GMT + 13 heures';
$lang['datetime']['Sunday'] = 'Dimanche';
$lang['datetime']['Monday'] = 'Lundi';
$lang['datetime']['Tuesday'] = 'Mardi';
$lang['datetime']['Wednesday'] = 'Mercredi';
$lang['datetime']['Thursday'] = 'Jeudi';
$lang['datetime']['Friday'] = 'Vendredi';
$lang['datetime']['Saturday'] = 'Samedi';
$lang['datetime']['Sun'] = 'Dim';
$lang['datetime']['Mon'] = 'Lun';
$lang['datetime']['Tue'] = 'Mar';
$lang['datetime']['Wed'] = 'Mer';
$lang['datetime']['Thu'] = 'Jeu';
$lang['datetime']['Fri'] = 'Ven';
$lang['datetime']['Sat'] = 'Sam';
$lang['datetime']['January'] = 'Janvier';
$lang['datetime']['February'] = 'Février';
$lang['datetime']['March'] = 'Mars';
$lang['datetime']['April'] = 'Avril';
$lang['datetime']['May'] = 'Mai';
$lang['datetime']['June'] = 'Juin';
$lang['datetime']['July'] = 'Juillet';
$lang['datetime']['August'] = 'Août';
$lang['datetime']['September'] = 'Septembre';
$lang['datetime']['October'] = 'Octobre';
$lang['datetime']['November'] = 'Novembre';
$lang['datetime']['December'] = 'Décembre';
$lang['datetime']['Jan'] = 'Jan';
$lang['datetime']['Feb'] = 'Fév';
$lang['datetime']['Mar'] = 'Mars';
$lang['datetime']['Apr'] = 'Avr';
$lang['datetime']['May'] = 'Mai';
$lang['datetime']['Jun'] = 'Juin';
$lang['datetime']['Jul'] = 'Juil';
$lang['datetime']['Aug'] = 'Août';
$lang['datetime']['Sep'] = 'Sept';
$lang['datetime']['Oct'] = 'Oct';
$lang['datetime']['Nov'] = 'Nov';
$lang['datetime']['Dec'] = 'Déc';


//
// Errors (not related to a specific failure on a page)
//
$lang['Information'] = 'Information';
$lang['Critical_Information'] = 'Information critique';
$lang['General_Error'] = 'Erreur générale';
$lang['Critical_Error'] = 'Erreur critique';
$lang['An_error_occured'] = 'Une erreur est survenue';
$lang['A_critical_error'] = 'Une erreur critique est survenue';
$lang['User_admin_f'] = "Gestion";
$lang['Permissions_control_f'] = "Permission";
$lang['Admin_reauthenticate'] = 'Pour administrer ce forum vous devez vous identifier à nouveau.';

//-- mod : thumbnails ----------------------------------------------------------
//-- add
$lang['Thumbnails_alt'] = 'Image postée, réduite en taille. Si aucune image n\'est visible le serveur est mort ou non liable à distance';
$lang['Thumbnails_title'] = 'Cliquez pour agrandir';
//-- fin mod : thumbnails ------------------------------------------------------

// BEGIN Today-Yesterday Mod
$lang['TY-Today'] = "Aujourd'hui, "; //intentional space
$lang['TY-Yesterday'] = "Hier, "; //intentional space
$lang['TY-in'] = "Dans : "; //intentional space
$lang['Go_to_topic'] = "Aller au topic : "; //intentional space
$lang['TY-by'] = "Par : "; //intentional space
$lang['TY-hr'] = "hr, "; //intentional space
$lang['TY-hrs'] = "hrs, "; //intentional space
$lang['TY-min'] = "min "; //intentional space
$lang['TY-mins'] = "mins "; //intentional space
$lang['TY-ago'] =  "Il y a "; //intentional space before the word
$lang['TY-seconds_ago'] = "Il y a quelques secondes";

$lang['Use_rel_date'] = "Afficher la date relative.";		
$lang['Use_rel_date_explain'] = "Aujourd'hui et Hier seront affichés au lieu de la date.";		
$lang['Use_rel_time'] = "Afficher le temps relatif.";		
$lang['Use_rel_time_explain'] = "Le temps sera relatif au temps courant. Exemple : - 10hrs, 43mins";
// END   Today-Yesterday Mod

$lang['Global_Announcements'] = 'Annonces globales';
$lang['Announcements'] = 'Annonces';
$lang['Sticky_Topics'] = 'Post-It';

// DEBUT >> MOD Advance Debug Mod
$lang['DEBUG'] = 'DEBUGGAGE';
$lang['DEBUG_line'] = 'Ligne';
$lang['DEBUG_file'] = 'Fichier';
$lang['DEBUG_sql_query'] = 'Requète SQL';
$lang['DEBUG_sql_error'] = 'Erreur SQL';
$lang['DEBUG_code_debbuger'] = 'Code de l\'erreur trouvée';
$lang['SQL_syntax_error'] = 'Vous avez une <b>erreur de syntaxe</b> dans votre requète SQL, si vous venez de modifier vos fichiers phpBB (en installant un MOD, FIX ou bien une mise à jour), reprenez les étapes de l\'installation de cette modification.';
$lang['SQL_duplicate_error'] = '<b>Duplicat d\'un champ</b>. Vous avez tenter de créer un champ qui existait déjà, il est donc inutile et impossible de le recréer une seconde fois.';
$lang['SQL_exist_error'] = '<b>La table que vous tentez de créer existe déjà</b>, il est donc inutile de la créer une seconde fois. Si vous souhaitez tout de même la créer vous devez supprimer l\'ancienne table existante (et tout ce qu\'elle contient).';
// FIN >> MOD Advance Debug Mod

//
// Cached generation
//
$lang['debug_generation'] = 'Page générée en <b>%s</b> secondes ||';
$lang['sql_queries'] = 'Requêtes SQL = <b>%s</b>';

// Start add - Yellow Card Mod
$lang['Give_G_card'] = 'Réactiver cet utilisateur';
$lang['Give_Y_card'] = 'Envoyer un avertissement à cet utilisateur: #%d';
$lang['Give_R_card'] = 'Bannir cet utilisateur maintenant';
$lang['Ban_update_sucessful'] = 'La liste de bannissement a été mise à jour avec succès';
$lang['Ban_update_green'] = 'Cet utilasateur a été réactivé';
$lang['Ban_update_yellow'] = 'Cet utilsateur a reçu un avertissement et a maintenant un total de %d avertissement(s) sur un maximum de %d';
$lang['Ban_update_red'] = 'Cet utilisateur a été banni';
$lang['Ban_reactivate'] = 'Votre compte a été réactivé';
$lang['Ban_warning'] = 'Vous avez reçu un avertissement';
$lang['Ban_blocked'] = 'Votre compte a été bloqué';
$lang['Click_return_viewtopic'] = 'Cliquez %sici%s pour revenir au sujet';
$lang['Rules_ban_can'] = 'Vous <b>pouvez</b> bannir des utilisateurs';
$lang['user_no_email'] = 'Cet utilisateur n\'a aucune adresse email, par conséquent aucun message sur cette action ne peut lui être envoyé. Vous devriez lui envoyer un message privé';
$lang['user_already_banned'] = 'L\'utilisateur sélectionné a déjà été banni';
$lang['Ban_no_admin'] = 'Cet utilisateur est l\'<b>administrateur</b>, par conséquent il ne peut pas être averti ou banni';
$lang['Rules_greencard_can'] = 'Vous <b>pouvez</b> débannir des utilisateurs';
$lang['Rules_bluecard_can'] = 'Vous <b>pouvez</b> rapporter un message aux modérateurs';
$lang['Give_b_card'] = 'Rapporter ce message à un modérateur';
$lang['Clear_b_card'] = 'Ce message a %d rapport(s). Si vous appuyez sur ce bouton, vous le remettrez à 0';
$lang['No_moderators'] = 'Ce forum n\'a aucun modérateur, par conséquent aucun rapport ne peut être envoyé!';
$lang['Post_repported'] = 'Ce message vient d\'être rapporté à %d modérateurs';
$lang['Post_repported_1'] = 'Ce message vient d\'être rapporté au modérateur';
$lang['Post_repport'] = 'Rapport'; //Subject in email notification
$lang['Post_reset'] = 'Les rapports pour ce message ont été réinitialisés';
$lang['Search_only_bluecards'] = 'Rechercher uniquement parmi les messages ayant des rapports';
$lang['Send_message'] = 'Cliquez %sici%s pour écrire un message aux modérateurs ou <br />';
$lang['Send_PM_user'] = 'Cliquez %sici%s pour écrire un MP à cet utilisateur ou';
$lang['Link_to_post'] = 'Cliquez %sici%s pour aller au message rapporté <br />--------------------------------<br /><br />';
$lang['Post_a_report'] = 'Rapport';
$lang['Report_stored'] = 'Votre rapport a été envoyé avec succès';
$lang['Send_report'] = 'Cliquez %sici%s pour revenir au message original';
$lang['Red_card_warning'] = "Vous êtes sur le point d\'envoyer un carton rouge à %s, ceci bannira définitivement l\'utilisateur. Etes-vous sûr ?";
$lang['Yellow_card_warning'] = "Vous êtes sur le point d\'envoyer un carton jaune à %s , ceci avertira l\'utilisateur. Etes-vous sûr ?";
$lang['Green_card_warning'] = "Vous êtes sur le point d\'envoyer un carton vert à %s, ceci débannira l\'utilisateur. Etes-vous sûr ?";
$lang['Blue_card_warning'] = 'Vous êtes sur le point de transmettre un rapport sur ce message, ceci avertira les modérateurs sur la présence de ce message. Etes-vous sûr de vouloir avertir les modérateurs de la présence de ce message ?';
$lang['Clear_blue_card_warning'] = 'Vous êtes sur le point de réinitialiser le compteur de rapports pour ce message. Souhaitez-vous continuez ?';
$lang['Warnings'] = 'Averti: %d fois'; //shown beside users post, if any warnings given to the user
$lang['Banned'] = 'Actuellement banni'; //shown beside users post, if user are banned
// End add - Yellow Card Mod

// MOD ColorText
$lang['Colortext'] = 'Couleur du texte de vos posts';
$lang['Colortext_Explain'] = 'Vous pouvez choisir une couleur personnalisée qui s\'appliquera à tout vos posts.<br />Vous avez 3 façons de choisir une couleur :<br /><font color="red">red</font> - <font color="#ff0000">#ff0000</font> - <font color="ff0000">ff0000</font>';

//
// Disallow editing/deleting administrator posts
//
$lang['Not_auth_edit_delete_admin'] = 'Vous ne pouvez ni éditer, ni effacer les posts des Administrateurs';

// Start Remote Avatar Check Mod
$lang['Smilies_invasion_error_count'] = 'Le nombre de smilies dans le sujet (%d) dépasse la limite (%d)';
// End Remote Avatar Check Mod

//+MOD: Search latest 24h 48h 72h
$lang['Search_latest'] = 'Voir les messages des dernières';
$lang['Search_latest_XXh'] = '%dh';
//-MOD: Search latest 24h 48h 72h


//Ajout confirmation écrite
$lang['Question_conf_fields_empty'] = 'Le champs confirmation écrite est vide';
$lang['Question_conf_fields_false'] = 'La réponse pour la confirmation écrite est fausse';
$lang['Question_conf_explain'] = 'Veuillez saisir la réponse en <b>toute lettre et en minuscule</b>.';
//Fin confirmation écrite

//
// Sort memberlist per letter
//
$lang['Sort_per_letter'] = 'Seulement montrer les membres dont le pseudo commence par';
$lang['Others'] = 'autres';
$lang['All'] = 'tous';

//
// That's all Folks!
// -------------------------------------------------


$lang['host'] = 'Votre hébergeur est :';
$lang['ip'] = 'Votre IP est :';

//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
// acp
$lang['BBcode_Box'] = 'BBcode Box';
$lang['bbc_box_a_settings'] = 'Configuration';
$lang['bbc_box_b_list'] = 'Liste des bbcodes';
$lang['bbc_box_c_manage'] = 'Gestion';
// spoiler
$lang['bbcbxr_spoil'] = 'Spoiler';
$lang['bbcbxr_show'] = 'voir';
$lang['bbcbxr_hide'] = 'cacher';
// code expand
$lang['bbcbxr_expand'] = 'Agrandir';
$lang['bbcbxr_expand_more'] = 'Agrandir encore';
$lang['bbcbxr_contract'] = 'Réduire';
$lang['bbcbxr_select'] = 'Tout sélectionner';
//-- fin mod : bbcode box reloaded ---------------------------------------------

//-- mod : addon hide for bbcbxr -------------------------------------------------------------------
//-- add
$lang['Hide'] = 'Message protégé';
$lang['Hide_text'] = '--- Seul les *membres* ayant posté dans ce sujet peuvent voir le message ---';
$lang['Hide_in_quote'] = '--- phpBB : Le message protégé n\'est pas recopié dans cette citation ---';
//-- fin mod : addon hide for bbcbxr ---------------------------------------------------------------

//-- mod : topics enhanced -----------------------------------------------------
//-- add
//-- bottoms tabs
$lang['bt_title'] = 'Informations';
$lang['bt_perms'] = 'Permissions du forum';
$lang['bt_icons'] = 'Icônes des messages';
$lang['bt_showhide_alt'] = 'voir ou cacher les informations';
//-- topics nav buttons
$lang['View_previous_post'] = 'Voir le message précédent';
$lang['View_next_post'] = 'Voir le message suivant';
$lang['Go_to_bottom'] = 'Aller en bas';
//-- fin mod : topics enhanced -------------------------------------------------

//+MOD: DHTML Collapsible FAQ MOD
// Please note: %sHERE%s is used to dynamically building the A HREF tag, do not remove the percent signs (%) around HERE!
$lang['dhtml_faq_noscript'] = "Il apparaît que votre navigateur ne supporte pas le javascript ou qu'il a été désactivé dans les options de votre navigateur.<br /><br />Svp, cliquez %sici%s pour voir une version standard de la FAQ.";
//-MOD: DHTML Collapsible FAQ MOD

// Points System MOD
$lang['Points_cp'] = 'Panneau de contrôle des points';
$lang['Points_sys']	= 'Système de points';
$lang['Points_donation'] = 'Don de points';
$lang['Points_method'] = 'Méthode';
$lang['Points_donate'] = '%sDonner%s';
$lang['Points_add_subtract'] = 'Ajouter ou soustraire des %s';
$lang['Points_amount'] = 'Montant';
$lang['Points_give_take'] = 'Montant de %s à donner ou à prendre';
$lang['Points_give'] = 'Montant de %s à donner';
$lang['Add'] = 'Ajouter';
$lang['Subtract'] = 'Soustraire';
$lang['Points_donate_to'] = 'La personne à qui vous voulez donner des %s ';
$lang['Points_no_username']	= 'Veuillez entrer un nom d\'utilisateur.';
$lang['Points_not_admin'] = 'Vous n\'êtes pas autorisé à administrer le système de points.';
$lang['Points_cant_take'] = 'Vous ne pouvez pas prendre cette somme de %s à cet utilisateur.'; //*
$lang['Points_thanks_donation']	= 'Merci pour votre don.';
$lang['Click_return_points_donate']	= 'Cliquez %sIci%s pour retourner au don de points';
$lang['Points_cant_donate']	= 'Vous ne pouvez pas donner ce montant de %s à cet utilisateur.';
$lang['Points_cant_donate_self'] = 'Vous ne pouvez pas vous donner des %s .';
$lang['Points_user_donation_off'] = 'Le don n\'est pas autorisé actuellement.';
$lang['Click_return_pointscp'] = 'Cliquez %sIci%s pour retourner au panneau de contrôle des points';
$lang['Points_user_updated'] = 'Les %s de cet utilisateur ont été mis à jour avec succès.';
$lang['Points_mass_edit'] = 'Edition de masse des utilisateurs';
$lang['Points_mass_edit_explain'] = 'Entrez un nom d\'utilisateur par ligne.';
$lang['Points_notify'] = 'Toujours m\'avertir des dons de %s ';
$lang['Points_notify_explain'] = 'M\'envoyer un e-mail quand quelqu\'un me donne des %s ';
$lang['Points_enter_some_donate'] = 'Entrez le montant de %s que vous désirez donner.';

// Start add - Regs - Posts - Topics Today
$lang['Count_regs_today'] = 'Aujourd\'hui, nous avons eu <b>%d</b> enregistrements';
$lang['Count_posts_today'] = 'Aujourd\'hui, nous avons eu <b>%d</b> reponses';
$lang['Count_topics_today'] = 'Aujourd\'hui, nous avons eu <b>%d</b> nouveaux sujets';
// End add - Regs - Posts - Topics Today

// Start add - Gender MOD
$lang['Gender'] = 'Sexe';
$lang['Male'] = 'Masculin';
$lang['Female'] = 'Féminin';
$lang['No_gender_specify'] = 'Non spécifié';
$lang['Gender_require'] = '<font color=#c00000>Vous devez spécifier votre sexe.</font>';
// End add - Gender MOD

// External forum redirection
// V: why in admin only?
$lang['Forum_external'] = 'Lien externe';
$lang['External_text'] = 'Ce lien a été visité ';
$lang['External_hit'] = ' fois.';
$lang['External_hits'] = ' fois.';
$lang['External_members'] = 'membres';
$lang['External_guests'] = 'invités';

$lang['marquee_topic'] = 'Les %s derniers topics';

//+MOD: DHTML Collapsible Forum Index MOD
$lang['CFI_options'] = "Options";
$lang['CFI_options_ex'] = "Options Collapsible Forum Index";
$lang['CFI_close'] = "Fermer";
$lang['CFI_delete'] = "Supprimer la sauvegarde";
$lang['CFI_restore'] = "Restaurer la sauvegarde";
$lang['CFI_save'] = "Sauver";
$lang['CFI_Expand_all'] = "Tout étendre";
$lang['CFI_Collapse_all'] = "Tout réduire";
//-MOD: DHTML Collapsible Forum Index MOD

$lang['Copy'] = 'Lien direct de ce message.';

$lang['ClickedXtimes'] = 'Lien cliqué %.0f fois';

$lang['Forum_enter_limit'] = 'Nombre de message(s) pour accéder au forum';
$lang['Forum_enter_limit_error'] = 'Vous devez avoir posté <b>%d</b> messages pour accéder à ce forum ou ce topic.';

// Begin Account Self-Delete MOD
$lang['Account_delete'] = 'Voulez-vous supprimer votre compte sur ce forum ?';
$lang['Account_delete_explain'] = 'La suppression de votre compte sera définitive';
$lang['User_deleted'] = 'Votre compte a été supprimé avec succès.';
$lang['Delete_account_question'] = 'La suppression de votre compte entraînera la suppression de toutes les informations personnelles vous concernant inclus dans votre profil, au sein de la base de données de ce forum. Les messages que vous avez écrits dans ce forum verront leur auteur remplacés par un invité. <b>Attention !</b> Toute suppression sera définitive.<br /><br />Souhaitez-vous supprimer votre compte sur ce forum?';

// Default avatar MOD, By Manipe (Begin)
$lang['Choose_default_avatar'] = 'Activer l\'avatar par défaut';
$lang['Default_avatar_choose_explain'] = 'Si l\'Administrateur a configuré les options pour montrer les avatars par défaut, les avatars par défaut pourront être montrés. Cela ne fonctionnera uniquement que si vous n\'avez pas chois vous-même de propre avatar. L\'Administrateur choisit l\'avatar par défaut.';

$lang['Posts_per_day'] = 'Posts par jour';
$lang['Total_topics'] = 'Nombre total de topics';
$lang['Topics_per_day'] = 'Topics par jour';
$lang['Users_per_day'] = 'Membres par jour';
$lang['Board_started'] = 'Forum en ligne depuis le';

//MOD Keep_unread
$lang['keep_post_unread_explain'] = 'Marquer les messages de ce sujet comme non-lus';
$lang['keep_unread_done'] = 'Le sujet a été marqué comme non-lu.';
$lang['View_unread_posts'] = 'Voir les messages non-lus';
$lang['No_unread_posts'] = 'Vous n\'avez pas de messages non-lus';

// Start add - Fully integrated shoutbox Mod
$lang['Shoutbox'] = 'Chat de discussion';
$lang['Shoutbox_date'] = ' d M Y G:i';
$lang['Shout_censor'] = 'Le message a été supprimé';
$lang['Shout_refresh'] = 'Rafraîchir';
$lang['Shout_text'] = 'Votre texte';
$lang['Viewing_Shoutbox']= 'Regarde le Chat de discussion';
$lang['Censor'] = 'Censurer';

// www.phpBB-SEO.com SEO TOOLKIT BEGIN - TITLE
 $lang['Page'] = 'Page ';

// Password-protected forums
$lang['Forum_password'] = 'Forum protégé par mot de passe';
$lang['Enter_forum_password'] = 'Entrez le mot de passe du forum';
$lang['Incorrect_forum_password'] = 'Mot de passe incorrect';
$lang['Password_login_success'] = 'Mot de passe correct';
$lang['Click_return_page'] = 'Cliquez %sici%s pour revenir à la page';
$lang['Only_alpha_num_chars'] = 'Le mot de passe doit contenir de 3 à 20 caractères et ne peut comprendre que des caractères alphanumériques (A-Z, a-z, 0-9).';

//BEGIN ACP Site Announcement Centre by lefty74
$lang['Site_announcement_block_title'] = 'Annonce du site';
$lang['Guest_announcement_block_title'] = 'Annonce pour les invités';

// Long forum desc
$lang['Forum_desc_explain'] = 'Description courte du forum, affichée sur l\'index du forum';
$lang['Forum_desc_long'] = 'Description longue';			
$lang['Forum_desc_long_explain'] = 'Description plus détaillée du forum, ou ses règles. Affichée sur la page de vue du forum.<br/><b>Note :</b> vous pouvez utiliser le BBcode et les Smilies ici.';

// Related topics
$lang['Related_topics'] = 'Sujets similaires';

// Rabbitoshi
$lang['Rabbitoshi_topic']='Voir le familier du membre'; 

// Mini profile
$lang['Read_mini_profile'] = 'Mini profil de l\'utilisateur';
$lang['Viewing_user_mini_profile'] = 'Mini profil de %s'; // %s is username

// presentation required
$lang['Presentation_Message'] = 'Vous devez vous présenter sur le forum prévu à cet effet avant de pouvoir poster';
$lang['Presentation_Forum_Link'] = 'Cliquez %sici%s';

// sub title
$lang['Sub_title'] = 'Description du sujet';