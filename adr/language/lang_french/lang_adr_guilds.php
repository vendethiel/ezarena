<?php 
/*************************************************************************** 
*                   lang_adr.php [French] 
*                      ------------------- 
* 
*                   Traduction : lechacal 
*                Forums : 
* 
****************************************************************************/ 

if ( defined('IN_ADR_GUILDS')) 
{ 
   // General Guild mod messages 
   $lang['Adr_guilds_closed']='La hutte des guildes est actuellement fermée'; 
   $lang['Adr_town_guilds_overall_error']='Le dispositif de guilde est actuellement neutralisé'; 
   $lang['Adr_town_guilds_closed']='La hutte des guildes est actuellement fermée. <br /> Svp essai encore plus tard'; 
   $lang['Adr_guilds_yes']='Oui'; 
   $lang['Adr_guilds_no']='Non'; 
   $lang['Adr_guilds_back']='Retour liste des Guildes'; 
	 $lang['Adr_guilds_back_to_guild']='Retour guilde';
	 $lang['Adr_guilds_back_to_guild_admin']='Retour au panel administration';
   $lang['Adr_guilds_submit']='Mise à jour'; 
   $lang['Adr_character_guilds_leader']=''; 

   // Main town index messages 
   $lang['Adr_guilds_league_table']='Tableau de Ligue des Guildes'; 
	// Guild HQ messages
	$lang['Adr_guilds_no_hq']='Cette guilde n\'a pas de forum';
	$lang['Adr_guilds_buy_hq']='Acheter un forum de guilde (100.000)';
	$lang['Adr_guilds_go_hq']='Aller au forum de la guilde';
	$lang['Adr_guilds_have_hq']='Votre guilde &agrave; un forum';
	$lang['Adr_guilds_too_expensive']='Vous n\'avez pas assez d\'argent dans le coffre de guilde pour acheter un forum (vous avez %s dans votre compte / 300,000)';
	$lang['Adr_guilds_hq_postfix']=' Forum'; // This is what the title of the forum would be. ex. Guildname HQ
   $lang['Adr_guilds_position']='#'; 
   $lang['Adr_guilds_name2']='Nom de Guilde:'; 
   $lang['Adr_guilds_leader']='Chef:'; 
   $lang['Adr_guilds_members']='Membres:'; 
   $lang['Adr_guilds_wins']='Victoires:'; 
   $lang['Adr_guilds_defeats']='Défaites:'; 
   $lang['Adr_guilds_escapes']='Fuites:'; 
   $lang['Adr_guilds_difference']='+/-'; 
   $lang['Adr_guilds_level']='Niveau:'; 
   $lang['Adr_guilds_create_title']='Créez la Nouvelle Guilde'; 
	$lang['Adr_guilds_donate']='Merci pour votre contribution';
	$lang['Adr_guilds_withdraw_lack']='Vous n\'avez pas assez d\'argent.';
	$lang['Adr_guild_account_ok']='Le retrait s\'est effectu&eacute; avec succ&egrave;s';

   // 'Create Guild' messages 
   $lang['Adr_guilds_creation_error']='Vous n\'avez pas satisfait les conditions de base de créer une Guilde'; 
   $lang['Adr_guilds_create_confirm']='Êtes-vous sûr que vous voulez-vous créer une nouvelle Guilde?'; 
   $lang['Adr_guilds_name']='Nom de la Guilde*'; 
   $lang['Adr_guilds_description']='Petite description pour la Guilde*'; 
   $lang['Adr_guilds_logo']='URL pour le logo de Guilde (max dimensions: 225px x 150px)'; 
   $lang['Adr_guilds_leader_rank']='Rang Fait sur commande Du Chef De Guilde'; 
   $lang['Adr_guilds_join_level']='Niveau minimum pour que quelqu\'un s\'applique à la Guilde*'; 
   $lang['Adr_guilds_join_money1']='Quantité de '; 
   $lang['Adr_guilds_join_money2']=' à payé par le demandeur après avoir joint la Guilde*'; 
   $lang['Adr_guilds_create_title']='Création de Guilde'; 
   $lang['Adr_guilds_create_success']='Vous avez avec succès créé une nouvelle Guilde'; 
   $lang['Adr_guilds_create_submit']='Créez la Guilde'; 
   $lang['Adr_guilds_create_required']='Vous n\'avez pas correctement complété un ou plusieurs des champs demandés'; 
    
   // General error messages 
   $lang['Adr_guilds_general_error_title']='Erreur Générale de Guilde'; 
   $lang['Adr_guilds_general_error_text']='Vous essayez d\'accéder à un secteur non autorisé'; 
   $lang['Adr_guilds_join_money_title']='Erreur de Guilde d\'Argent'; 
   $lang['Adr_guilds_join_money_text']='Vous n\'avez pas assez d\'argent pour vous appliquer à cette guilde'; 
   $lang['Adr_guilds_create_money_title']='Erreur de Guilde d\'Argent'; 
   $lang['Adr_guilds_create_money_text']='Vous n\'avez pas assez d\'argent pour créer une nouvelle guilde'; 

   // 'Join Guild' messages 
   $lang['Adr_guilds_info']='Guilde Information'; 
   $lang['Adr_guilds_info_leader']='Chef de la Guilde:'; 
   $lang['Adr_guilds_info_members']='Totale des Membres de la Guilde:'; 
   $lang['Adr_guilds_info_level']='Guilde Niveau:'; 
   $lang['Adr_guilds_info_vault']='Totale des Fonds de la Guilde:'; 
   $lang['Adr_guilds_info_date']='Date de Création de la Guilde:'; 
   $lang['Adr_guilds_info_length']='Age de la Guilde:'; 
	 $lang['Adr_guilds_copper_pec']='Pourcentage de taxe sur l\'argent : ';
	 $lang['Adr_guilds_exp_pec']='Pourcentage de taxe sur l\'experience : ';
	 $lang['Adr_guilds_heal_pec']='Pourcentage de financement sur le soin au temple';
   $lang['Adr_guilds_info_date2']=' jours'; 
   $lang['Adr_guilds_info_ranks']='Structure de la Guilde & Liste des Membres'; 
   $lang['Adr_guilds_info_bio']='Histoire de la Guilde'; 
   $lang['Adr_guilds_join_reqs']='Conditions d\'Application pour la Guilde'; 
   $lang['Adr_guilds_join_reqs_level']='Niveau minimum du personnage:'; 
   $lang['Adr_guilds_join_reqs_money']='Quantité à payer par le demandeur:'; 
	 $lang['Adr_guilds_join_approve']='Approbation de l\'application';
   $lang['Adr_guilds_join_approve_enabled']='Approuv&eacute;'; 
   $lang['Adr_guilds_join_approve_disabled']='Non approuv&eacute;'; 
   $lang['Adr_guilds_join_success']='Vous avez avec succès rejoint cette Guilde'; 
   $lang['Adr_guilds_join_approval']='Vous avez été ajouté à la liste d\'attente d\'approbation.<br /><br /> On vous préviendra quand le Chef aura pris une décision.'; 
   $lang['Adr_guilds_join_button']='Demande d\'Adhésion à la Guilde'; 
   $lang['Adr_guilds_retract_button']='Se rétracter de l\'Application'; 
   $lang['Adr_guilds_retract_success']='Vous avez été enlevé de la liste d\'attente de la Guilde'; 
   $lang['Adr_guilds_leave_button']='Laissez la Guilde'; 
   $lang['Adr_guilds_join_accept_new']='Accepter actuellement de nouveaux Membres:'; 
   $lang['Adr_guilds_leave_success']='vous avez avec succès quitté la Guilde'; 
   $lang['Adr_guilds_apply_title']='Membres de la Guilde'; 
   $lang['Adr_guilds_apply_text']='Vous étes sur de vouloir être dans cette Guilde?'; 
   $lang['Adr_guilds_leave_title']='Partir de la Guilde'; 
   $lang['Adr_guilds_leave_text']='Etes vous sur de vouloir partir de cette Guilde?'; 
   $lang['Adr_guilds_leader_button']='Tableau de Controle du Chef'; 
   $lang['Adr_guilds_join_pm_subject']='%s a rejoint votre Guilde %s'; 
   $lang['Adr_guilds_join_pm_msg']='%s s\'est joint avec succes &agrave; %s'; 
   $lang['Adr_guilds_join_pm_list_sub']='%s a été ajouté à la Guilde %s .'; 
   $lang['Adr_guilds_join_pm_list_msg']='%s attend actuellement une décision sur sa demande d\'adhésion.'; 

   // 'Guild Leader' Control Panel messages 
   $lang['Adr_guilds_logo_none']='Pas de logo'; 
   $lang['Adr_guilds_leader_cp']=' Tableau de Controle'; 
   $lang['Adr_guilds_leader_desc']='Guilde description:'; 
   $lang['Adr_guilds_leader_general']='Guilde Generale'; 
   $lang['Adr_guilds_logo']='URL externe pour le logo de la guilde:<br />(max dimensions: 250px x 200px)'; 
   $lang['Adr_guilds_management']='Gestion de la Guilde'; 
   $lang['Adr_guilds_leader_approve']='Liste d\'Approbation'; 
   $lang['Adr_guilds_leader_users']='Gestion des Membres de la Guilde'; 
   $lang['Adr_guilds_leader_set_ranks']='Promouvoir les Membres de la Guilde'; 
	$lang['Adr_guilds_vault']='Coffre de la guilde';
   $lang['Adr_guilds_leader_new_leader']='Nommez le nouveau Chef de la guilde'; 
   $lang['Adr_guilds_leader_delete']='Supprimez la Guilde'; 
   $lang['Adr_guilds_leader_rank_leader']='Titre du chef de guilde :'; 
   $lang['Adr_guilds_leader_rank1']='Titre Rang 1 :'; 
   $lang['Adr_guilds_leader_rank2']='Titre Rang 2 :'; 
   $lang['Adr_guilds_leader_rank3']='Titre Rang 3 :'; 
   $lang['Adr_guilds_leader_rank4']='Titre Rang 4 :'; 
   $lang['Adr_guilds_leader_rank5']='Titre Rang 5 :'; 
   $lang['Adr_guilds_leader_bio']='Mise à jour Configuration de la Guilde'; 
   $lang['Adr_guilds_leader_rank_member']='Rang membre :'; 
	 $lang['Adr_guilds_leader_page_updated']='Configuration mise &agrave; jour';
   $lang['Adr_guilds_leader_page_updated']='Configuration mise &agrave; jour'; 

	 //increase guild size thingy
	 $lang['Adr_guilds_increase_title']='Augmenter la taille de votre guilde';
	 $lang['Adr_guilds_increase_text']='Votre guilde peut accueillir %s membres actuellement. Vous pouvez augmenter sa capacit&eacute; &agrave; %s membres, pour %s points.';
	 $lang['Adr_guilds_leader_size_increased']='La taille de votre guide a &eacute;t&eacute; accrue';
	 $lang['Adr_guilds_leader_size_increase_error']='Vous n\'avez pas assez de points dans votre coffre';

	 // 'Guild Ranks' messages 
	 $lang['Adr_guilds_ranks']='Structure de la Guilde'; 
	 $lang['Adr_guilds_ranks_no_members']='Actuellement aucun membre'; 

   // 'Guild Approve List' messages 
   $lang['Adr_guilds_approve_list']='Nouvelle liste d\'Approbation de Demandeur'; 
   $lang['Adr_check_all']='Choisissez Tous'; 
   $lang['Adr_uncheck_all']='Tous Dé-selectionner'; 
   $lang['Adr_guilds_approve_yes']='Approuvez'; 
   $lang['Adr_guilds_approve_no']='Rejettez'; 
   $lang['Adr_guilds_approve_applicant']='Membres:'; 
   $lang['Adr_guilds_approve_select']='Select:'; 
   $lang['Adr_guilds_approve_level']='Niveau:'; 
   $lang['Adr_guilds_approve_hp']='HP Max:'; 
   $lang['Adr_guilds_approve_mp']='MP Max:'; 
   $lang['Adr_guilds_approve_wins']='Victoires:'; 
   $lang['Adr_guilds_approve_defeats']='Defaites:'; 
   $lang['Adr_guilds_approve_flees']='Fuites:'; 
   $lang['Adr_guilds_approve_hops']='Houblon de la Guilde:'; 
   $lang['Adr_guilds_approve_list_approve']='Vous avez avec succès approuvé les membres choisis'; 
   $lang['Adr_guilds_approve_list_reject']='Vous avez avec succès rejeté les membres choisis'; 
   $lang['Adr_guilds_approve_pm_subject']='Le chef de %s a pris une décision sur votre application'; 
   $lang['Adr_guilds_approve_pm_yes']='Le chef de la %s Guilde, %s, a pris une décision positive concernant votre application récente à la guilde. <br /><br />Vous avez été approuvés et pouvez maintenant acceder à toutes les activités de la guilde. <br /><br />Si vous avez des questions ou des soucis contactez le chef de guilde pour l\'aide.'; 
   $lang['Adr_guilds_approve_pm_no']='Le chef de la %s Guilde, %s, a pris une décision concernant votre application récente à la guilde. <br /><br />Votre application à joindre a été rejetée. <br /><br />Si vous avez des questions concernant ceci contactez le chef de guilde.'; 
   $lang['Adr_guilds_prefs_notification_pm']='Permettre les avis de la guilde par PM'; 
   $lang['Adr_guilds_prefs']='Alliance Addon de la Guilde'; 

   // 'Delete Guild' messages... 
   $lang['Adr_guilds_delete_title']='Effacement entiére de la Guilde'; 
   $lang['Adr_guilds_delete_text']='Êtes-vous sûr que vous souhaitez supprimer complètement cette guilde?'; 
   $lang['Adr_guilds_leader_delete_updated']='Guilde entièrement supprimée avec succès'; 

   // Guild bio... 
   $lang['Adr_guilds_bio_title']='Page Biographique de la Guilde'; 
   $lang['Adr_guilds_bio_text']='Mettez à jour l\'histoire de votre guilde'; 
   $lang['Adr_guilds_bio_none']='<i>Pas d\'Histoire</i>'; 
   $lang['Adr_guilds_leader_bio_updated']='Biographie de la guilde mis à jour avec succès'; 

   // User Management messages... 
   $lang['Adr_guilds_users_remove']='Enlevez de la guilde'; 
   $lang['Adr_guilds_users']='Gestion D\'Utilisateur'; 
   $lang['Adr_guilds_users_pm_remove_subject']='Vous avez été enlevés de la %s Guilde'; 
   $lang['Adr_guilds_users_pm_remove_msg']='Vous avez été enlevés par le chef de guilde de %s, %s. Svp contactez %s pour avoir la raison de ceci.'; 
   $lang['Adr_guilds_leader_users_updated']='Gestion d\'utilisateur mise à jour avec succès'; 

   // New Leader... 
   $lang['Adr_guilds_leader_new']='Nommez le Nouveau Chef de Guilde'; 
   $lang['Adr_guilds_leader_current']='Chef courant de la guilde:'; 
   $lang['Adr_guilds_leader_select']='A choisi le nouveau Chef:'; 
   $lang['Adr_guilds_no_members']='Choisissez un membre'; 
   $lang['Adr_guilds_leader_new_leader_updated']='Nouveau chef de guilde mis à jour avec succès'; 

   // Set ranks... 
   $lang['Adr_guilds_set_rank_1']='Promotion du Rang 1'; 
   $lang['Adr_guilds_rank_1']='Membre rang 1 :'; 
   $lang['Adr_guilds_set_rank_2']='Promotion du Rang 2'; 
   $lang['Adr_guilds_rank_2']='Membre rang 2 :'; 
   $lang['Adr_guilds_set_rank_3']='Promotion du Rang 3'; 
   $lang['Adr_guilds_rank_3']='Membre rang 3 :'; 
   $lang['Adr_guilds_set_rank_4']='Promotion du Rang 4'; 
   $lang['Adr_guilds_rank_4']='Membre rang 4 :'; 
   $lang['Adr_guilds_set_rank_5']='Promotion du Rang 5'; 
   $lang['Adr_guilds_rank_5']='Membre rang 5 :'; 
   $lang['Adr_guilds_set_rank_list']='Choisissez le membre à Promouvoir:'; 
   $lang['Adr_guilds_set_rank']='Position Vacante'; 
   $lang['Adr_guilds_rank_none']='<i>Non selectionné</i>'; 
   $lang['Adr_guilds_leader_set_ranks_updated']='Le rang de la Guilde a été mis à jour a avec succès'; 
	
	//guild vault
	$lang['Adr_guild_vault_title']='Coffre de guilde';
	$lang['Adr_guild_vault_total']='Argent dans le coffre : ';
 
	//other stuff i was too lazy to sort out
	$lang['Adr_guild_size_limit'] = 'Capacity: ';
	$lang['Adr_guild_guild_full']='Sorry you cannot join this guild it currently has the maximum number of members it can hold';
	$lang['Adr_guilds_already_member']='You are already a member of this guild you can only join it once.';
} 

// V: added
$lang['Adr_no_guild'] = 'Vous n\'avez pas de guilde';
$lang['Adr_guild_not_leader'] = 'Vous n\'&ecirc;tes pas chef de guilde';
// V: Should've been there to start with.
$lang['ACCOUNT_WITHDRAW'] = 'Retrait du coffre';
$lang['ADR_DONATE_GUILD_FUND'] = 'Don au coffre de guilde :';

?>
