<?php
/***************************************************************************
*					lang_adr_admin.php [French]
*				    -------------------
*
*					    Translation : Thos
*					 http://www.thosforum.com
*
****************************************************************************/

if ( !defined ('IN_ADR_ADMIN') )
{
    return;
}

$lang['ADR_THIS_IS_LOOTTABLES'] = 'Note : cette liste est la liste des <b>tables de butin</b>.<br/>Vous pouvez les modifier dans l\'onglet "Objet" puis "Tables de butin".<br/>';

if ( defined ('IN_ADR_CHARACTER'))
{
    //ZONE
    if ( defined ('IN_ADR_SEASONS'))
    {
        $lang['Adr_seasons_acp_title']='Configurations des Saisons';
        $lang['Adr_seasons_acp_explain']='Ici vous pouvez changer les saisons et la durée écoulée entre chaque saison';
        $lang['Adr_seasons_acp_config']='Configurations des Saisons';
        $lang['Adr_seasons_acp_choice']='Changer de saison';
        $lang['Adr_seasons_acp_time']='Temps écoulé entre chaque saison';
        $lang['Adr_seasons_acp_days']='Jours';
        $lang['Adr_seasons_acp_submit']='Changer la configuration des saisons';
        $lang['Adr_season_change_successful']='La configuration des saisons a été changée avec succès';
        $lang['Adr_season_empty']='Vous devez obligatoirement mettre une durée entre chaque saison';
        $lang['Adr_Season_1']='Printemps';
        $lang['Adr_Season_2']='Eté';
        $lang['Adr_Season_3']='Automne';
        $lang['Adr_Season_4']='Hiver';
    }
    //ZONE end
    // Races
    $lang['Adr_races_explain']='Ici vous pouvez configurer les races , en ajouter , modifier celles existantes ou les supprimer .';
    $lang['Adr_races_add']='Ajouter une race';
    $lang['Adr_races_add_edit']='Ajout et édition de races';
    $lang['Adr_races_add_edit_explain']='Ici vous pouvez ajouter une race ou éditer une race déjà existante .';
    $lang['Adr_races_name_explain']='Vous pouvez utiliser une clé du tableau langue';
    $lang['Adr_races_image_explain']='L\'image correspondante doit être placée dans le répertoire /adr/images/races/';
    $lang['Adr_races_level']='Niveau des utilisateurs';
    $lang['Adr_races_level_explain']='Vous pouvez réserver certaines races à certains niveaux d\'utilisateurs';
    $lang['Adr_races_level_all']='Tous';
    $lang['Adr_races_level_admin']='Administrateur';
    $lang['Adr_races_level_mod']='Modérateur';
    $lang['Adr_race_successful_added']='Nouvelle race ajoutée avec succès';
    $lang['Adr_race_successful_edited']='Race éditée avec succès';
    $lang['Adr_race_default']='Vous ne pouvez pas supprimer la classe par défaut';
    $lang['Adr_race_successful_deleted']='Race supprimée avec succès';
    $lang['Adr_races_weight']='Poids de base maximum';
    $lang['Adr_races_weight_per_level']='Pourcentage de poids en plus lors de la montée de niveau';


    // Classes
    $lang['Adr_classes_explain']='Ici vous pouvez configurer les classes , en ajouter , modifier celles existantes ou les supprimer .';
    $lang['Adr_classes_add']='Ajouter une classe';
    $lang['Adr_classes_add_edit']='Ajout et édition de classes';
    $lang['Adr_classes_add_edit_explain']='Ici vous pouvez ajouter une classe ou éditer une classe déjà existante .';
    $lang['Adr_classes_image_explain']='L\'image correspondante doit être placée dans le répertoire /adr/images/classes/';
    $lang['Adr_classes_level_explain']='Vous pouvez réserver certaines classes à certains niveaux d\'utilisateurs';
    $lang['Adr_classes_req_might']='Caractéristique Force minimale';
    $lang['Adr_classes_req_dext']='Caractéristique Agilité minimale';
    $lang['Adr_classes_req_const']='Caractéristique Endurance minimale';
    $lang['Adr_classes_req_int']='Caractéristique Intelligence minimale';
    $lang['Adr_classes_req_wis']='Caractéristique Volonté minimale';
    $lang['Adr_classes_req_cha']='Caractéristique Charme minimale';
    $lang['Adr_classes_req_ma']='Caractéristique Attaque Magique minimale';
    $lang['Adr_classes_req_md']='Caractéristique Résistance à la Magie minimale';
    $lang['Adr_class_successful_added']='Nouvelle classe ajoutée avec succès';
    $lang['Adr_class_successful_edited']='Classe éditée avec succès';
    $lang['Adr_class_default']='Vous ne pouvez pas supprimer la classe par défaut';
    $lang['Adr_class_successful_deleted']='Classe supprimée avec succès';
    $lang['Adr_classes_update_xp_req']='Points d\'expérience nécessaires pour monter de niveau';
    $lang['Adr_classes_update_of']='Est une évolution de';
    $lang['Adr_classes_update_of_req']='Niveau minimal pour évoluer vers cette classe';
    $lang['Adr_classes_selectable']='Peut être sélectionné lors de la création d\'un nouveau personnage';
    $lang['Adr_classes_evolution_none']='N\'est pas une évolution';

    // Elements
    $lang['Adr_elements_add']='Ajouter un élément';
    $lang['Adr_elements_explain']='Ici vous pouvez configurer les éléments , en ajouter , modifier ceux existants ou les supprimer .';
    $lang['Adr_elements_add_edit']='Ajout et édition d\'éléments';
    $lang['Adr_elements_add_edit_explain']='Ici vous pouvez ajouter un élément ou éditer un élément déjà existante .';
    $lang['Adr_elements_colour']='Couleur';
    $lang['Adr_elements_colour_ex']='Ici, vous pouvez choisir une couleur pour l\'élément.<br>Vous pouvez utiliser une couleur nommée ou une couleur <a href="http://www.w3schools.com/html/html_colornames.asp" target="_blank">hexadécimale</a> à la place.';
    $lang['Adr_elements_image_explain']='L\'image correspondante doit être placée dans le répertoire /adr/images/elements/';
    $lang['Adr_elements_level_explain']='Vous pouvez réserver certains éléments à certains niveaux d\'utilisateurs';
    $lang['Adr_element_successful_added']='Nouvel élément ajouté avec succès';
    $lang['Adr_element_successful_edited']='Elément édité avec succès';
    $lang['Adr_element_successful_deleted']='Elément supprimé avec succès';
    $lang['Adr_element_default']='Vous ne pouvez supprimer l\'élément de base';

    $lang['Adr_element_oppose_str']='Choisissez un élément opposé contre lequel cet élément sera plus fort';
    $lang['Adr_element_oppose_weak']='Choisissez un élément opposé contre lequel cet élément sera plus faible';
    $lang['Adr_element_oppose_str_dmg']='Choisissez un pourcentage pour l\'élément le plus fort';
    $lang['Adr_element_oppose_same_dmg']='Choisissez un pourcentage pour le même élément';
    $lang['Adr_element_oppose_weak_dmg']='Choisissez un pourcentage pour l\'élément le plus faible';

    // Alignments
    $lang['Adr_alignments_add']='Ajouter un alignement';
    $lang['Adr_alignments_explain']='Ici vous pouvez configurer les alignements , en ajouter , modifier ceux existants ou les supprimer .';
    $lang['Adr_alignments_add_edit']='Ajout et édition d\'alignements';
    $lang['Adr_alignments_add_edit_explain']='Ici vous pouvez ajouter un élément ou éditer un alignement déjà existante .';
    $lang['Adr_alignments_image_explain']='L\'image correspondante doit être placée dans le répertoire /adr/images/alignments/';
    $lang['Adr_alignments_level_explain']='Vous pouvez réserver certains alignements à certains niveaux d\'utilisateurs';
    $lang['Adr_alignment_successful_added']='Nouvel alignement ajouté avec succès';
    $lang['Adr_alignment_successful_edited']='Alignement édité avec succès';
    $lang['Adr_alignment_successful_deleted']='Alignement supprimé avec succès';
    $lang['Adr_alignment_default']='Vous ne pouvez pas supprimer l\'alignement par défaut';

    //Skills
    $lang['Adr_skills_add_edit']='Edition des compétences';
    $lang['Adr_skills_explain']='Ici vous pouvez éditer les compétences';
    $lang['Adr_skills_req']='Utilisations';
    $lang['Adr_skills_req_explain']='Nombres d\'utilisations réussies avant que la compétence augmente';
    $lang['Adr_skills_chance']='Chances';
    $lang['Adr_skills_chance_explain']='Pourcentage de chance de réussite de l\'utilisation de la compétence pour chaque niveau de compétence';
    $lang['Adr_skills_successful_edited']='Compétence mise à jour avec succès';

    // Inventory
    $lang['Adr_character_admin_inventory']='Voir l\'inventaire du membre';
    $lang['Adr_delete_inventory']='Supprimer l\'inventaire entier';
    $lang['Adr_character_inventory_title']=' Contenu de l\'Inventaire & de l\'entrepot';
    $lang['Adr_admin_delete_entire_inventory']='L\'enventaire entier a été supprimé';
    $lang['Adr_admin_item_deleted']='Objet(s) supprimé(s) de l\'inventaire du membre';

    //ARMOUR SET
    $lang['Adr_admin_set_title']='Sets d\'armures'; 
    $lang['Adr_admin_set_text']='Ajouter & mettre a jour vos Sets d\'armures'; 
    $lang['Adr_admin_set_success']='Sets d\'armures ajouté avec succès'; 
    $lang['Adr_admin_set_updated']='Sets d\'armures mis a jour avec succès';
    $lang['Adr_admin_set_deleted']='Sets d\'armures supprimé avec succès';
    $lang['Adr_admin_set_add']='Ajouter Sets d\'armures';
    $lang['Adr_admin_set_no_item']='Rien Selectionné';
    $lang['Adr_admin_set_name']='Nom du Sets d\'armures:';
    $lang['Adr_admin_set_desc']='Description du Sets d\'armures:';
    $lang['Adr_admin_set_img']='Image du Sets d\'armures:';
    $lang['Adr_admin_set_img_explain']='Les images doivent être placées dans le repertoire adr/images/sets';
    $lang['Adr_admin_set_helm']='Choisir Casque:';
    $lang['Adr_admin_set_armour']='Choisir Armure:';
    $lang['Adr_admin_set_gloves']='Choisir Gant:';
    $lang['Adr_admin_set_shield']='Choisir Bouclier:';
    $lang['Adr_admin_set_greave']='Choisir Jambière:';
    $lang['Adr_admin_set_boot']='Choisir Bottes:';
    $lang['Adr_admin_set_hp_max_bonus']='HP max bonus:';
    $lang['Adr_admin_set_mp_max_bonus']='MP max  bonus:';
    $lang['Adr_admin_set_might_bonus']='Force bonus:';
    $lang['Adr_admin_set_con_bonus']='Constitution bonus:';
    $lang['Adr_admin_set_ac_bonus']='Classe d\'Armure bonus:';
    $lang['Adr_admin_set_dex_bonus']='Dexterité bonus:';
    $lang['Adr_admin_set_int_bonus']='Intelligence bonus:';
    $lang['Adr_admin_set_wis_bonus']='Charisme bonus:';
    $lang['Adr_admin_set_hp_max_pen']='HP max penalté:';
    $lang['Adr_admin_set_mp_max_pen']='MP max penalté:';
    $lang['Adr_admin_set_might_pen']='Force penalté:';
    $lang['Adr_admin_set_con_pen']='Constitution penalté:';
    $lang['Adr_admin_set_ac_pen']='Classe d\'Armure penalté:';
    $lang['Adr_admin_set_dex_pen']='Dexterité penalté:';
    $lang['Adr_admin_set_int_pen']='Intelligence penalté:';
    $lang['Adr_admin_set_wis_pen']='Charisme penalté:';
    //ARMOUR SET end
}

if ( defined ('IN_ADR_SETTINGS'))
{
    // General settings
    $lang['Adr_admin_general_settings']='Configuration générale';
    $lang['Adr_admin_general_settings_explain']='Ici vous pouvez définir toutes les options générales relatives à ADR';
    $lang['Adr_admin_general_character_creation']='Création de personnages';
    $lang['Adr_admin_general_character_page_name']='Nom du lien vers la page de la fiche des personnages';
    $lang['Adr_admin_general_character_allow_reroll']='Autoriser les utilisateurs à retirer leurs caractéristiques';
    $lang['Adr_admin_general_character_allow_delete']='Autoriser les utilisateurs à recréer leur personnage';
    $lang['Adr_admin_general_character_stats_max']='Valeur maximale des caractéristiques';
    $lang['Adr_admin_general_character_stats_min']='Valeur minimale des caractéristiques';
    $lang['Adr_character_general_update_error']='Erreur durant la mise à jour de la configuration générale';
    $lang['Adr_character_general_update_success']='Mise à jour de la configuration générale effectuée avec succès';

    $lang['Adr_admin_general_shop_settings']='Configuration des magasins';
    $lang['Adr_admin_general_item_base_price_settings']='Configuration des objets - Prix de base';
    $lang['Adr_admin_general_item_modifier_price_settings']='Configuration des objets - Modificateurs';
    $lang['Adr_admin_general_item_modifier_power_settings']='Modificateurs par la puissance des objets';
    $lang['Adr_admin_general_item_modifier_power_settings_explain']='Vous pouvez définir une valeur en pourcentage de la valeur d\'un objet en fonction de sa puissance';
    $lang['Adr_admin_general_item_modifier_quality_settings']='Modificateurs par la qualité des objets';
    $lang['Adr_admin_general_item_modifier_quality_settings_explain']='Vous pouvez définir une valeur en pourcentage de la valeur d\'un objet en fonction de sa qualité';
    $lang['Adr_admin_general_item_modifier_type_settings']='Prix de base des objets';
    $lang['Adr_admin_general_item_modifier_type_settings_explain']='Vous pouvez définir un prix de base pour les objets en fonction de leur type';
    $lang['Adr_admin_general_item_modifier_power']='Pourcentage de la valeur de base le l\'objet pour chaque niveau de puissance';
    $lang['Adr_admin_allow_steal']='Autoriser les utilisateurs à voler dans les magasins';
    $lang['Adr_admin_allow_steal_sell']='Permettre la revente d\'objets volés ?';
    $lang['Adr_admin_allow_steal_sell_ex']='Désactiver cette option empêchera les utilisateurs de revendre à la boutique du forum les objets volés à celle-ci. Ces objets ne pourront ainsi être vendus que via les boutiques des utilisateurs.';
    $lang['Adr_admin_allow_steal_lvl']='Niveau minimum requis pour utiliser la compétence \'voleur\'';
    $lang['Adr_admin_allow_steal_lvl_ex']='Les joueurs devront avoir atteint ce niveau pour être capables de voler.';
    $lang['Adr_admin_steal_show']='Afficher le niveau de difficulté du vol d\'un objet dans la boutique du forum';
    $lang['Adr_admin_steal_show_ex']='Cette option active l\'affichage du niveau de difficulté du vol de l\'objet concerné dans la boutique du forum';

    $lang['Adr_admin_cache_int']='Intervalle de mise à jour automatique du cache';
    $lang['Adr_admin_cache_int_ex']='Cette option permet au cache de se régenerer toutes les x minutes. Une vérification des renouvellements de quota est aussi effectuée.<br>La valeur recommandée est de 15 minutes. Diminuez cette valeur si vous jugez que les quotas sont incorrectement rafraîchies. Si cette valeur est trop faible vous risquez d\'avoir des problèmes de surcharge de votre serveur, il est recommandé de ne pas descendre en dessous de 5 minutes.';
    $lang['Adr_admin_new_shop_price']='Prix pour ouvrir un nouveau magasin';
    $lang['Adr_admin_character_age']='Age initial du personnage à la création';
    $lang['Adr_admin_character_tax']='Taxes des Magasins & Entrepots';
    $lang['Adr_admin_character_shop_tax']='Imposer une  taxe des magasins:';
    $lang['Adr_admin_character_shop_dura']='Durée entre les prélèvement des taxes des magasins:';
    $lang['Adr_admin_character_wh_tax']='Imposer une taxe des entrepots:';
    $lang['Adr_admin_character_wh_dura']='Durée entre les prélèvement des taxes des entrepots';
    $lang['Adr_admin_days']='Jours';
    $lang['Adr_items_element_none']='Pas d\'éléments';
    $lang['Adr_items_dex_explain']='Quand le membre s\'équipe avec des objets pour les combats, cette valeur sera ajoutée au total de la puissance des objets. *Ceci n\'a pas d\'effet sur les Anneaux & Amulettes*';
    $lang['Adr_items_mp_use_explain']='Si activé, cette valeur retirera des MP additionels au membre quand il utilise une *arme* ou un *sort*.';
    $lang['Adr_admin_general_item_modifier_settings']='Modificateurs au prix des objets';
    $lang['Adr_admin_general_item_modifier_power']='Pourcentage de la valeur de base de l\'objet gagnée pour chaque niveau de puissance';
    $lang['Adr_admin_experience_posting']='Expérience lors des posts';
    $lang['Adr_admin_weight_enable_title']='Restriction de poids';
    $lang['Adr_admin_weight_enable']='Mettre la restriction de poids sur ON / OFF';
    $lang['Adr_admin_experience_posting_new']='Points d\'expérience gagnés pour un nouveau sujet';
    $lang['Adr_admin_experience_posting_reply']='Points d\'expérience gagnés pour une réponse';
    $lang['Adr_admin_experience_posting_edit']='Points d\'expérience gagnés pour une édition de message';
    $lang['Adr_skill_trading_power']='Pourcentage de modifications de prix par tranche de niveaux';
    $lang['Adr_skill_thief_failure_amend']='Amende minimale pour les utilisateurs pris en train de voler';
    $lang['Adr_skill_thief_failure_amend_explain']='L\'amende est basée sur le prix de l\'objet volé : si ce dernier est inférieur à l\'amende minimale , c\'est cette dernière qui sera infligée . Laissez cette valeur nulle pour ne pas infliger d\'amende';
    $lang['Adr_fail_steal_punishment']='Que faire si l\'utilisateur ne peut pas payer l\'amende ?';
    $lang['Adr_fail_steal_punishment0']='Ne pas ingliger l\'amende';
    $lang['Adr_fail_steal_punishment1']='Prendre tous les points';
    $lang['Adr_fail_steal_punishment2']='Emprisonnement';
    $lang['Adr_fail_steal_type']='Type d\'emprisonnement dans ce cas';
    $lang['Adr_fail_steal_type0']='Bloquer l\'accès au forum';
    $lang['Adr_fail_steal_type1']='Interdire les nouveaux messages';
    $lang['Adr_fail_steal_type2']='Interdire la lecture des messages';
    $lang['Adr_fail_steal_time']='Nombre d\'heures d\'emprisonnement';

    $lang['Adr_admin_regen_enable']='Activer la limite pour les combats & les compétences';
    $lang['Adr_battle_item_power_level']='Limiter l\'utilisation des objets des combats';
    $lang['Adr_battle_item_power_level_explain']='Si vous cochez cette option , les utilisateurs ne pourront utiliser en combat que les objets dont la puissance est inférieure ou égale à leur niveau';
    $lang['Adr_town_training_grounds_admin']='Entrainement';
    $lang['Adr_town_training_grounds_admin_change_allow']='Autoriser le changement de classe';
    $lang['Adr_town_training_grounds_admin_change_cost']='Coût du changement de classe';
    $lang['Adr_town_training_grounds_admin_skill_cost']='Coût de l\'entrainement d\'une compétence ( par niveau )';
    $lang['Adr_town_training_grounds_admin_charac_cost']='Coût de l\'entrainement d\'une caractéristique ( par niveau )';
    $lang['Adr_town_training_grounds_admin_upgrade_cost']='Coût de la promotion d\'une classe';

    $lang['Adr_use_cache']='Utilisez le système de cache';
    $lang['Adr_use_cache_explain']='Le système de cache permet de réduire le nombre de requêtes SQL . Pour pouvoir l\'utiliser , vous devez faire un CHMOD 666 sur les fichiers suivants :';
    $lang['Adr_display_profile']='Affichage dans les profils';
    $lang['Adr_display_profile_allow']='Activer l\'affichage des informations du personnage dans le profil';
    $lang['Adr_display_topics']='Affichage dans les posts';
    $lang['Adr_display_topics_level']='Afficher le niveau';
    $lang['Adr_display_topics_text']='En tant que texte';
    $lang['Adr_display_topics_pic']='En tant qu\'image';
    $lang['Adr_display_topics_class']='Afficher la classe';
    $lang['Adr_display_topics_race']='Afficher la race';
    $lang['Adr_display_topics_element']='Afficher l\'élément';
    $lang['Adr_display_topics_alignment']='Afficher l\'alignement';
    $lang['Adr_display_topics_pvp']='Afficher un lien JcJ';
    $lang['Adr_display_topics_rank']='Afficher le rang RPG';
    $lang['Adr_display_topics_battle_stats']='Afficher les stats';
    $lang['Adr_next_level_penalty']='Pénalité à la montée de niveau';
    $lang['Adr_next_level_penalty_explain']='Pourcentage d\'expérience supplémentaire requise par niveau pour la montée de niveau ( au plus un personnage est de haut niveau , au plus il a besoin d\'expérience pour prendre un autre niveau ) ';
    //GUILD
    $lang['Adr_guilds_title']='Configuration des guildes';
    $lang['Adr_guilds_overall_allow']='Activer les guildes OUI ou NON';
    $lang['Adr_guilds_create_allow']='Activer la création des guildes OUI ou NON';
    $lang['Adr_guilds_join_allow']='Activer l\'accès aux guildes OUI ou NON';
    $lang['Adr_guilds_create_level']='Niveau minimum pour créer une guilde';
    $lang['Adr_guilds_create_money']='Coût de création d\'une guilde';
    $lang['On']='Oui';
    $lang['Off']='Non';
    //GUILD end
    $lang['Adr_admin_regen_period_title']='Limites des Combats & Utilisation des Compétences';
    $lang['Adr_admin_regen_period']='Période de régénération par combat et compétence ( en jours )';
    $lang['Adr_admin_battle_limit']='Nombres de combats autorisés par jour';
    $lang['Adr_admin_skill_limit']='Nombre d\'entrainement maximum réussi des caractéristiques par jour';
    $lang['Adr_admin_trading_limit']='Nombre maximum de vente réussie par jour';
    $lang['Adr_admin_thief_limit']='Nombre maximum de vols réussis par jour';
    $lang['Adr_admin_enable_rpg_title']='Activer / Désactiver le RPG';
    $lang['Adr_admin_enable_rpg']='Mettre le mod RPG entier sur on / off';
    $lang['Adr_admin_posts']='Activer le nombre de postes minimal nécessaire à la création d\'un personnage:';
    $lang['Adr_admin_posts_min']='Nombre de postes minimum pour créer un personnage:';

    $lang['Adr_pvp']='Combats entre utilisateurs';
    $lang['Adr_display_topics_link']='Afficher le lien vers le personnage';
    $lang['Adr_pvp_enable_pvp']='Autoriser les combats entre joueurs';
    $lang['Adr_pvp_defies_max']='Nombre maximal de défis simultanés autorisés';
    $lang['Adr_pvp_stats_exp_modifier_explain']='Définit un pourcentage de différence de l\'expérience gagnée pour chaque degré de différence entre les deux utilisateurs';
    $lang['Adr_pvp_stats_reward_modifier_explain']='Définit un pourcentage de différence de la récompense gagnée pour chaque degré de différence entre les deux utilisateurs';
}

if ( defined ('IN_ADR_SHOPS'))
{
    //ZONE
    $lang['Adr_item_zone_choose']='Dans quel zone apparait cet objet ?';
    $lang['Adr_items_zone_title']='Zone';
    //ZONE end
    $lang['Adr_shops_item_title']='Gestion des objets du magasin du forum';
    $lang['Adr_shops_item_title_explain']='Ici vous pouvez gérer les objets du magasin du forum';
    $lang['Adr_shops_item_add']='Ajouter un objet';
    $lang['Adr_shops_categories']='Catégorie';
    $lang['Adr_shops_item_add_title']='Ajout et édition d\'objets';
    $lang['Adr_shops_item_add_title_explain']='Ici vous pouvez ajouter ou éditer les objets du magasin du forum';
    $lang['Adr_items_image_explain']='L\'image correspondante doit être placée dans le répertoire /adr/images/items/';
    $lang['Adr_shop_image_explain']='L\'image correspondante doit être placée dans le répertoire /adr/images/store/';
    $lang['Adr_shops_items_successful_edited']='Objet mis à jour avec succès';
    $lang['Adr_shops_items_successful_added']='Objet ajouté au magasin des forums avec succès';
    $lang['Adr_shops_items_successful_deleted']='Objet supprimé du magasin des forums avec succès';
    $lang['Adr_items_price_explain']='Si vous laissez ce champ vide , le prix utilisé sera le prix idéal de l\'objet basé sur ses caractéristiques ( recommandé ) ';
    $lang['Adr_items_duration_max']='Durée maximale';
    $lang['Adr_item_max_skill']='Puissance maximum pour l\'utilisation de la Forge:';
    $lang['Adr_item_sell_back']='Revendre avec un pourcentage de pénalité:';
    $lang['Adr_item_sell_back_explain']='Ceci est le pourcentage de pénalité sur le prix pour un magasin de forum standard pour les objets quand ils sont revendus au magasin du forum. Ce calcul est fait avant de prendre en conte la qualité de l\'objet, la durabilité et la compétence marchandage dans le compte pour le prix de revente total.';
    $lang['Adr_item_sell_back_title']='Resell';
    $lang['Adr_item_sell_back_title']='Revendre';
    $lang['Adr_items_price_explain']='Si vous laissez ce champ vide, le prix idéal sera calculé et utilisé (recommandé)';
    $lang['Adr_shops_item_element']='Type d\'élément: (armes/sorts seulement)';
    $lang['Adr_shops_item_element_str']='Pourcentage donné contre un élément opposé plus faible:';
    $lang['Adr_shops_item_element_same']='Pourcentage donné contre le même élément:';
    $lang['Adr_shops_item_element_weak']='Pourcentage donné contre un élément opposé plus fort:';

    $lang['Adr_items_store']='Ajouter au type de magasin:';
    $lang['Adr_store_title']='Catégories de magasin du forum';
    $lang['Adr_store_title_explain']='Créer & éditer les categories de magasins:';
    $lang['Adr_store_name']='Nom du magasin:';
    $lang['Adr_store_desc']='Description:';
    $lang['Adr_store_status']='Status:';
    $lang['Adr_store_sales']='Status des ventes:';
    $lang['Adr_store_auth']='Faire un objet "que pour les admins":';
    $lang['Adr_store_no_sell']='Cocher la case pour empêcher les joueurs de vendre cet objet';
    $lang['Adr_store_view']='Rendre les objets du magasin impossible à acheter ( seulement visibles )';
    $lang['Adr_store_view_title']='Voir:';
    $lang['Adr_store_cat_add']='Ajouter une nouvelle Categorie';
    $lang['Adr_store_status_closed']='Fermé';
    $lang['Adr_store_status_open']='Ouvert';
    $lang['Adr_store_sales_on']='Ventes ON';
    $lang['Adr_store_sales_off']='Ventes OFF';
    $lang['Adr_store_auth_all']='Tout';
    $lang['Adr_store_auth_admin']='Admin seulement';
    $lang['Adr_store_open']='Ouvert';
    $lang['Adr_store_closed']='Fermé';
    $lang['Adr_store_normal']='Normal';
    $lang['Adr_store_sale']='Vente  ';
    $lang['Adr_store_all']='Tous les membres';
    $lang['Adr_store_admin']='Admin Seulement';
    $lang['Adr_store_image_explain']='L\'image doit être placée dans le répertoire /adr/images/store/';
    $lang['Adr_store_cats_successful_deleted']='Magasin supprimé avec succès';
    $lang['Adr_store_cats_successful_edit']='Magasin mis à jour avec succès';
    $lang['Adr_store_cats_successful_new']='Magasin créer avec succès';
}

if ( defined ('IN_ADR_VAULT'))
{
    $lang['Adr_vault_update_error']='Erreur durant la mise à jour de la configuration de la trésorerie';
    $lang['Adr_vault_updated_return_settings']='La configuration de la trésorerie a été mise à jour avec succès . <br /><br />Cliquez %sIci%s pour retourner à la configuration de la trésorerie';
    $lang['Adr_vault_settings']='Configuration de la trésorerie';
    $lang['Adr_vault_settings_explain']='Ici vous pouvez configurer les options de la trésorerie';
    $lang['Adr_vault_use']='Activer la trésorerie';
    $lang['Adr_vault_settings_name']='Nom de la trésorerie';
    $lang['Adr_vault_interests_rate']='Taux d\'interêts';
    $lang['Adr_vault_interests_rate_explain']='Pourcentage de la somme mise dans la trésorerie gagnée par l\'utilisateur lors de l\'expiration du temps de paiement des intêrets';
    $lang['Adr_vault_interests_time']='Temps de paiement des interêts';
    $lang['Adr_vault_interests_time_explain']='Intervalle de temps entre deux versement des interêts ( en secondes ).';
    $lang['Adr_vault_loan_use']='Activer le système de prêts';
    $lang['Adr_vault_loan_interests']='Taux d\'interêts des prêts';
    $lang['Adr_vault_loan_interests_explain']='Pourcentage de la somme empruntée que l\'utilisateur devra rembourser';
    $lang['Adr_vault_loan_interests_time']='Temps de paiement du prêt';
    $lang['Adr_vault_loan_interests_time_explain']='Temps au bout duquel l\'utilisateur ayant fait un emprunt devra le rembourser ( en secondes ).';
    $lang['Adr_vault_max_sum']='Somme maximale';
    $lang['Adr_vault_max_sum_explain']='Montant maximum que l\'utilisateur peut emprunter';
    $lang['Adr_vault_requirements']='Pré-requis';
    $lang['Adr_vault_requirements_explain']='Nombre de messages minimum que l\'utilisateur doit avoir pour pouvoir faire un prêt';
    $lang['Adr_vault_attack_use']='Activer le système d\'attaque de la trésorerie';
    $lang['Adr_vault_time_explain']='Soit ';
    $lang['Adr_vault_exchange_settings']='Configuration de la bourse';
    $lang['Adr_vault_exchange_settings_explain']='Ici vous pouvez configurer le système de bourse , ainsi qu\'ajouter/supprimer/éditer des actions';
    $lang['Adr_vault_exchange_use']='Activer la bourse';
    $lang['Adr_vault_exchange_min']='Pourcentage minimal de changements';
    $lang['Adr_vault_exchange_min_explain']='Ceci représente - en pourcentage - la variation minimale du cours des actions';
    $lang['Adr_vault_exchange_max']='Pourcentage maximal de changements';
    $lang['Adr_vault_exchange_max_explain']='Ceci représente - en pourcentage - la variation maximale du cours des actions';
    $lang['Adr_vault_exchange_time']='Intervalle entre les variations';
    $lang['Adr_vault_exchange_time_explain']='Ceci représente le temps en secondes entre les variations de valeurs des actions';
    $lang['Adr_vault_exchange_updated_return_settings']='La configuration de la bourse a été mise à jour avec succès . <br /><br />Cliquez %sIci%s pour retourner à la configuration de la bourse';
    $lang['Adr_vault_exchange_actions']='Actions disponibles';
    $lang['Adr_vault_exchange_actions_name']='Nom';
    $lang['Adr_vault_exchange_actions_desc']='Description';
    $lang['Adr_vault_exchange_actions_amount']='Valeur';
    $lang['Adr_vault_exchange_action']='Action';
    $lang['Adr_vault_exchange_edit']='Editer';
    $lang['Adr_vault_exchange_delete']='Supprimer';
    $lang['Adr_vault_exchange_actions_add']='Ajouter une action';
    $lang['Adr_vault_exchange_settings_add']='Ajouter une action';
    $lang['Adr_vault_exchange_settings_explain_add']='Ce formulaire vous permet d\'ajouter une action dans la bourse';
    $lang['Adr_vault_exchange_actions_add']='Ajout d\'une action';
    $lang['Adr_vault_exchange_settings_edit']='Editer une action';
    $lang['Adr_vault_exchange_settings_explain_edit']='Ce formulaire vous permet d\'éditer une action de la bourse';
    $lang['Adr_vault_exchange_actions_edit']='Edition d\'une action';
    $lang['Adr_vault_exchange_added_return_settings']='La nouvelle action a été ajoutée avec succès . <br /><br />Cliquez %sIci%s pour retourner à la configuration de la bourse';
    $lang['Adr_vault_exchange_edited_return_settings']='Cette action a été éditée avec succès . <br /><br />Cliquez %sIci%s pour retourner à la configuration de la bourse';
    $lang['Adr_vault_exchange_deleted_return_settings']='Cette action a été supprimée avec succès . <br /><br />Cliquez %sIci%s pour retourner à la configuration de la bourse';
    $lang['Adr_vault_users_title']='Gestion des possesseurs de compte';
    $lang['Adr_vault_users_title_explain']='Ici vous pouvez éditer toutes les informations relatives aux utilisateurs de la trésorerie';
    $lang['Adr_vault_user_select']='Sélectionnez un utilisateur';
    $lang['Adr_vault_user_select_list']='Depuis cette liste';
    $lang['Adr_vault_user_select_input']='Ou en entrant son pseudo';
    $lang['Adr_vault_user']='Utilisateur';
    $lang['Adr_vault_user_account']='Compte';
    $lang['Adr_vault_user_on_account']='Dans le compte';
    $lang['Adr_vault_no_loan']='Aucun emprunt effectué';
    $lang['Adr_vault_user_loan']='Somme empruntée';
    $lang['Adr_vault_user_pay_off']='Rembourser le prêt de cet utilisateur';
    $lang['Adr_vault_user_preferences']='Preferences';
    $lang['Adr_vault_user_protect_account']='Compte protégé';
    $lang['Adr_vault_user_protect_loan']='Emprunt protégé';
    $lang['Adr_vault_users_updated_return_settings']='Edition de l\'utilisateur effectuée avec succès . <br /><br /> Cliquez %sIci%s pour revenir à l\'édition des utilisateurs';
}

if ( defined ('IN_ADR_BATTLE'))
{
    //ZONE
    $lang['Adr_monster_message_yes']='Activé';
    $lang['Adr_monster_message_no']='Desactivé';
    $lang['Adr_monsters_zone_title']='Zone';
    $lang['Adr_monsters_seasons_title']='Saison';
    $lang['Adr_monsters_weather_title']='Temps';
    $lang['Adr_monsters_item_title']='Objet';
    $lang['Adr_monsters_message_title']='Message';
    $lang['Adr_monster_item_nothing']='Pas d\'objet';
    $lang['Adr_monster_item_choose']='Choisir un objet que le monstre peut donner a la fin du combat';
    $lang['Adr_monster_message_enable']='Activer le message du monstre ?';
    $lang['Adr_monster_message_choose']='Mettez ici le message que le monstre peut donner';
    $lang['Adr_monster_season_choose']='Apparait pour quelle saison ?';
    $lang['Adr_monster_weather_choose']='Apparait à quel temps ?';
    $lang['Adr_monster_zone_choose']='Apparait dans quelle zone ?';
    $lang['Adr_Season_all']='Toutes les saisons';
    $lang['Adr_Season_1']='Printemps';
    $lang['Adr_Season_2']='Eté';
    $lang['Adr_Season_3']='Automne';
    $lang['Adr_Season_4']='Hiver';
    $lang['Adr_Weather_all']='Tous les temps';
    $lang['Adr_Weather_1']='Soleil';
    $lang['Adr_Weather_2']='Nuit';
    $lang['Adr_Weather_3']='Nuages';
    $lang['Adr_Weather_4']='Pluie';
    $lang['Adr_Weather_5']='Eclaircie';
    $lang['Adr_Weather_6']='Neige';
    $lang['Adr_monster_all_zones']='Toutes les zones';
    //ZONE end
    $lang['Adr_battle_settings']='Configuration du système de combats';
    $lang['Adr_battle_settings_explain']='Ici vous pouvez paramétrer les options du système de combat';
    $lang['Adr_battle_use']='Activer le système de combat';
    $lang['Adr_battle_monsters']='Combats contre les monstres';
    $lang['Adr_battle_monsters_stats_modifier']='Modification des caractéristiques en fonction de la différence de niveaux';
    $lang['Adr_battle_monsters_stats_modifier_explain']='Définit un pourcentage de différence des statistiques pour chaque degré de différence entre le niveau de l\'utilisateur et du monstre';
    $lang['Adr_battle_monster_stats_exp_min']='Expérience minimale gagnée en cas de combat victorieux';
    $lang['Adr_battle_monster_stats_exp_max']='Expérience maximale gagnée en cas de combat victorieux';
    $lang['Adr_battle_monster_stats_exp_modifier']='Modification de l\'expérience gagnée en fonction de la différence de niveaux';
    $lang['Adr_battle_monster_stats_exp_modifier_explain']='Définit un pourcentage de différence de l\'expérience gagnée pour chaque degré de différence entre le niveau de l\'utilisateur et du monstre';
    $lang['Adr_battle_monster_stats_sp_modifier']='Modification des Spirit Points (SP) gagné selon la différence du niveau';
    $lang['Adr_battle_monster_stats_sp_modifier_explain']='Définissez une différence de pourcentage gagnée pour chaque degré de différence entre le niveau de l\'utilisateur et le niveau du monstre ';
    $lang['Adr_battle_monster_stats_reward_min']='Récompense minimale gagnée en cas de combat victorieux';
    $lang['Adr_battle_monster_stats_reward_max']='Récompense maximale gagnée en cas de combat victorieux';
    $lang['Adr_battle_monster_stats_reward_modifier']='Modification de la récompense gagnée en fonction de la différence de niveaux';
    $lang['Adr_battle_monster_stats_reward_modifier_explain']='Définit un pourcentage de différence de la récompense gagnée pour chaque degré de différence entre le niveau de l\'utilisateur et du monstre';
    $lang['Adr_admin_monsters']='Monstres';
    $lang['Adr_admin_monsters_explain']='Ici vous pouvez ajouter , éditer ou supprimer les monstres du sytème de combat';
    $lang['Adr_monsters_name']='Nom du monstre';
    $lang['Adr_monsters_image']='Image';
    $lang['Adr_monsters_level']='Niveau';
    $lang['Adr_admin_monsters_base_hp']='Points de vie';
    $lang['Adr_admin_monsters_base_def']='Défense';
    $lang['Adr_admin_monsters_att']='Attaque';
    $lang['Adr_admin_monsters_element']='Element';
    $lang['Adr_admin_monsters_ma']='Attaque magique';
    $lang['Adr_admin_monsters_md']='Resistance à la magie';
    $lang['Adr_admin_monsters_base_mp']='Points de mana';
    $lang['Adr_admin_monsters_base_mp_power']='Puissance du sort';
    $lang['Adr_admin_monsters_base_sp']='Spirit Points (SP)';
    $lang['Adr_admin_monsters_custom_spell']='Nom de sort personnalisé';
    $lang['Adr_admin_monsters_custom_spell_explain']='Entrez un nom de monstre personnalisé pour ce monstre pour qu\'il l\'utilise pendant le combat. Laisser ce champ vide fera utiliser un nom par défault.';
    $lang['Adr_admin_monsters_thief_skill']='Niveau de compétence de vol';
    $lang['Adr_monsters_add']='Ajouter un monstre';
    $lang['Adr_monsters_add_edit']='Ajout et édition de monstres';
    $lang['Adr_monsters_add_edit_explain']='Ici vous pouvez ajouter et éditer des monstres du système de combat';
    $lang['Adr_monsters_image_explain']='L\'image correspondante doit être placée dans le répertoire /adr/images/monsters/';
    $lang['Adr_monster_successful_added']='Nouveau monstre ajouté avec succès';
    $lang['Adr_monster_successful_deleted']='Monstre effacé avec succès';
    $lang['Adr_monster_successful_edited']='Monstre édité avec succès';
    $lang['Adr_battle_thief']='Réglages sur le vol des monstres';
    $lang['Adr_battle_thief_enable']='Activer / Désactiver la possibilité pour un monstre de voler';
    $lang['Adr_battle_thief_points']='Pourcentage de points à voler au membre';
    $lang['Adr_battle_disabled']='Le système de combat n\'est pas disponible actuellemnt . Veuillez réessayer plus tard';
}

if ( defined ('IN_ADR_TOOLS'))
{
    $lang['Adr_admin_tools_cache_settings']='Gestion du cache';
    $lang['Adr_admin_tools_cache_settings_explain']='Synchronisez le cache si vous constatez des décalages entre votre configuration et son application';
    $lang['Adr_admin_tools_update_cache']='Mettre le cache à jour';
    $lang['Adr_admin_tools_cache_updated']='Mise à jour du cache effectuée avec succès';
    $lang['Adr_admin_tools_convertors_settings']='Convertisseurs';
    $lang['Adr_admin_tools_convertors_settings_explain']='A partir de ce formulaire , vous pouvez convertir les données d\'autres mods vers ADR';
    $lang['Adr_admin_tools_convertors_update']='Mise à jour';
    $lang['Adr_admin_tools_convertors_update_items']='Convertir les objets du mod SHOP de Zarath vers ADR';
    $lang['Adr_admin_tools_convertors_update_bank']='Convertir les comptes du mod BANK de Zarath vers ADR';
    $lang['Adr_admin_tools_convertors_delete']='Supprimer';
    $lang['Adr_admin_tools_convertors_delete_item']='Supprimer les altérations de la base de données du mod SHOP de Zarath';
    $lang['Adr_admin_tools_convertors_delete_vault']='Supprimer les altérations de la base de données du mod VAULT de Dr DLP';
    $lang['Adr_admin_tools_convertors_delete_bank']='Supprimer les altérations de la base de données du mod BANK de Zarath';
    $lang['Adr_admin_tools_convertors_bank_updated']='Conversion du mod BANK effectuée avec succès';
    $lang['Adr_admin_tools_convertors_bank_deleted']='Altérations du mod BANK supprimées avec succès';
    $lang['Adr_admin_users_updated']='Conversion du mod RPG STATS effectuée avec succès';
    $lang['Adr_admin_tools_convertors_update_users']='Convertir les personnages du mod RPG STATS de Moogie vers ADR';
    $lang['Adr_admin_tools_convertors_delete_rpg_stats']='Supprimer les altérations de la base de données du mod RPG STATS de Moogie';
    $lang['Adr_admin_tools_convertors_update_vault']='Convertir les comptes du mod VAULT de Dr DLP vers ADR';
    $lang['Adr_admin_tools_convertors_vault_deleted']='Altérations de la base de données du mod VAULT supprimées avec succès';
    $lang['Adr_admin_tools_convertors_rpg_stats_deleted']='Altérations de la base de données du mod RPG STATS supprimées avec succès';
    $lang['Adr_admin_tools_convertors_shop_deleted']='Altérations de la base de données du mod SHOP supprimées avec succès';
    $lang['Adr_admin_tools_convertors_vault_updated']='Conversion du mod VAULT effectuée avec succès';
    $lang['Adr_admin_tools_convertors_shop_updated']='Conversion du mod SHOP effectuée avec succès';
    $lang['Adr_admin_tools_convertors_jail_updated']='Conversion du mod JAIL effectuée avec succès';
    $lang['Adr_admin_tools_convertors_update_jail']='Convertir les comptes du mod JAIL de Dr DLP vers ADR';
    $lang['Adr_admin_tools_convertors_jail_deleted']='Altérations du mod JAIL supprimées avec succès';
    $lang['Adr_admin_tools_convertors_delete_jail']='Supprimer les altérations de la base de données du mod JAIL de Dr DLP';
    $lang['Adr_admin_tools_convertors_warnings']='ATTENTION !! Toutes ces opérations sont irréversibles ! Soyez sûrs de savoir ce que vous faites avant de vous en servir .<br /><br />Faites une sauvegarde complète de votre base de données avant de lancer ces opérations .<br /><br />L\'auteur du mod n\'est en aucun cas responsable des erreurs qui pourraient survenir suite à la mauvaise utilisation de ces outils .';
    $lang['Adr_admin_tools_resync_items']='Resynchronisation du prix des objets';
    $lang['Adr_admin_tools_resync_items_explain']='Ceci vous permet de recalculer le prix des objets du magasin des forums à leur juste valeur , c\'est à dire basée sur vos paramètres de modificateurs de prix par le niveau , le type et la qualité .';
    $lang['Adr_admin_tools_resync_items_action']='Recalculer les prix';
    $lang['Adr_admin_tools_items_updated']='Prix recalculés avec succès';
    $lang['Adr_admin_tools_armaggedon']='Remise à zéro des magasins , objets et personnages';
    $lang['Adr_admin_tools_armaggedon_explain']='En cliquant sur le bouton ci-dessous , vous pouvez effacer tous les objets , magasins et personnages créés par vos utilisateurs . <br /><b>Cette opération est irréversible !</b> ';
    $lang['Adr_admin_tools_armaggedon_characters']='Supprimer seulement tous les personnages ADR';
    $lang['Adr_admin_tools_armaggedon_zero_dura']='Nettoyer les tables des objets ayant 0 de durabilité';
    $lang['Adr_admin_tools_armaggedon_shops']='Supprimer tous les magasins des utilisateurs seulement';
    $lang['Adr_admin_tools_armaggedon_user_items']='Supprimer tous les objets des utilisateurs seulement';
    $lang['Adr_admin_tools_armaggedon_shops_items']='Supprimer tous les objets des magasins du forum seulement';
    $lang['Adr_admin_tools_armaggedon_done']='Suppression effectuée avec succès';
    $lang['Adr_admin_tools_armaggedon_dura']='Objets avec 0 de durabilités supprimés avec succès';
    $lang['Adr_admin_tools_armaggedon_dura_done']='Tous les objets des magasins ont été supprimés avec succès';
}

if ( defined ('IN_ADR_USERS'))
{
    $lang['Adr_admin_character_inventory']='Selectioner l\'inventaire d\'un membre';
    $lang['Adr_admin_character_delete']='Supprimer ce personnage - Attention , cette opération est irréversible !';
    $lang['Adr_admin_character_edit']='Valider les modifications';
    $lang['Adr_admin_character_charac']='Caractéristiques';
    $lang['Adr_admin_character_edited']='Personnage édité avec succès';
    $lang['Adr_admin_character_deleted']='Personnage supprimé avec succès';
    $lang['Adr_admin_character_lack']='Cet utilisateur n\'a pas crée de personnage';
    $lang['Adr_user_admin']='Gestion des personnages';
    $lang['Adr_user_admin_explain']='Ici vous pouvez éditer ou supprimer les personnages du mod ADR';
    $lang['Adr_user_battle_skills']='Limites des Combats & Compétences';
    $lang['Adr_user_battle_limit']='Nombre de combats restants:';
    $lang['Adr_user_skill_limit']='Nombre d\'utilisation de compétences restant:';
    $lang['Adr_user_trading_limit']='Nombre d\'utilisation de la compétence marchandage restant:';
    $lang['Adr_user_thief_limit']='Nombre d\'utilisation de la compétence vol restant:';
    }

    if ( defined ('IN_ADR_TRACKER'))
    {
    $lang['Adr_tracker_title']='"Track" les objets ADR';
    $lang['Adr_tracker_text']='Ici vous pouvez voir les achats , ventes , donations et vols';
    $lang['Adr_tracker_name']='Membres:';
    $lang['Adr_tracker_item']='Objets:';
    $lang['Adr_tracker_from']='Du membre:';
    $lang['Adr_tracker_shop']='Nom du magasin:';
    $lang['Adr_tracker_action']='Action:';
    $lang['Adr_tracker_date']='Date:';
    $lang['Adr_tracker_clear']='Vider la liste';
}
if ( defined ('IN_ADR_JOB'))
{
    $lang['Adr_job_successful_added']='Metier ajouté avec succès';
    $lang['Adr_job_successful_updated']='Mise à jour accomplie avec succès';
    $lang['Adr_job_successful_deleted']='Metier supprimé avec succès';
    $lang['Adr_admin_job_add']='Ajouter un metier';
    $lang['Adr_admin_job_no_item_reward']='Pas de selection d\'objet';
    $lang['Adr_admin_job_all_races']='Toutes les races';
    $lang['Adr_admin_job_all_classes']='Toutes les classes';
    $lang['Adr_admin_job_all_alignments']='Tous les alignments';
    $lang['Adr_admin_job_name']='Nom du metier:';
    $lang['Adr_admin_job_desc']='Description:';
    $lang['Adr_admin_job_img']='Image:';
    $lang['Adr_admin_job_level']='Niveau requit:';
    $lang['Adr_admin_job_race']='Race requise:';
    $lang['Adr_admin_job_class']='Classe requise:';
    $lang['Adr_admin_job_alignment']='Alignement requit:';
    $lang['Adr_admin_job_salary']='Salaire: (gagné chaque jour)';
    $lang['Adr_admin_job_exp']='Experience: (gagné à la fin du metier)';
    $lang['Adr_admin_job_item_reward']='Récompense: (gagné à la fin du metier)';
    $lang['Adr_admin_job_duration']='Durée du métier: (en jours)';
    $lang['Adr_admin_job_slots']='Nombre de places disponibles:';
    $lang['Adr_admin_job_slots_max']='Nombre maximum de places disponibles:';
    $lang['Adr_admin_job_auth_level']='Niveau d\'authorisation:';
    $lang['Adr_admin_job_title']='Metiers';
    $lang['Adr_admin_job_enable']='Activers les metiers de ADR';
    $lang['Adr_admin_job_cron_time']='Durée entre les différents payement';
    $lang['Adr_admin_job_sp_reward']='Points de spiritualité (SP) gagné: (gagné à la fin du métier)';
}

if ( defined ('IN_ADR_TEMPLE'))
{
    $lang['Adr_temple_title']='Configuration du don d\'item du temple';
    $lang['Adr_temple_title_explain']='Ici vous pouvez configurer les items disponible apres les dons au temple';
    $lang['Adr_temple_chance']='Chance de gagner';
    $lang['Adr_temple_chance_explain']='Placez ceci à la chance de l\'utilisateur recevoir cet article lorsqu\'il reçoit une récompense du temple.<br />Régler celui ci à \'Exceptionellement Rare\' demande au membre de donner au minimum la somme précider dans le panneau \'Temple\' de l\ACP pour être accessible';
    $lang['Adr_temple_chance_common']='Commun';
    $lang['Adr_temple_chance_uncommon']='Non commun';
    $lang['Adr_temple_chance_rare']='Rare';
    $lang['Adr_temple_chance_very_rare']='Trés rare';
    $lang['Adr_temple_chance_super_rare']='Exceptionellement Rare';
    $lang['Adr_temple_min_amount']='Don minimun pour gagner un item:';
    $lang['Adr_temple_min_amount_explain']='Il s\'agit du minimum que doit donner un membre pour avoir une chance d\'avoir un item. <br />Ce n\'est pas le don minimum. Un membre peut donner plus ou moins que cette valeur.';
    $lang['Adr_temple_win_chance']='Chance de gagner un item:';
    $lang['Adr_temple_win_chance_explain']='Quand un utilisateur donne le minimum requis, c\'est le pourcentage de chance de gagner réellement n\'importe quel type d\'article';
    $lang['Adr_temple_chance_increase']='Seuil de chance:';
    $lang['Adr_temple_chance_increase_explain']='C\'est le seuil d\'argent qui permet d\'augmenter la chance de recevoir un item.  Par exemple placez le seuil à 100 points et si l\'utilisateur donne 500 points ils aura 5% plus de chance de recevoir un item';
    $lang['Adr_temple_super_rare']='Seuil de chance pour un objet super rare:';
    $lang['Adr_temple_super_rare_explain']='C\'est le don minimum exigée de l\'utilisateur pour avoir une chance à recevoir un item particulièrement rare.<br /><b>Note:</b> Ceci ne joue pas sur la chance pour l\'utilisateur de recevoir un article très rare';
    $lang['Adr_temple_title']='Donation au temple';
}

if ( defined ('IN_ADR_BEGGAR'))
{
    $lang['Adr_beggar_title']='Configuration du don d\'item du mendiant';
    $lang['Adr_beggar_title_explain']='Ici vous pouvez configurer les items disponible apres les dons au mendiant';
    $lang['Adr_beggar_chance']='Chance de gagner';
    $lang['Adr_beggar_chance_explain']='Placez ceci à la chance de l\'utilisateur recevoir cet article lorsqu\'il reçoit une récompense du mendiant.<br />Régler celui ci à \'Exceptionellement Rare\' demande au membre de donner au minimum la somme précider dans le panneau \'memdiant\' de l\ACP pour être accessible';
    $lang['Adr_beggar_chance_common']='Commun';
    $lang['Adr_beggar_chance_uncommon']='Non commun';
    $lang['Adr_beggar_chance_rare']='Rare';
    $lang['Adr_beggar_chance_very_rare']='Trés rare';
    $lang['Adr_beggar_chance_super_rare']='Exceptionellement Rare';
    $lang['Adr_beggar_min_amount']='Don minimun pour gagner un item:';
    $lang['Adr_beggar_min_amount_explain']='Il s\'agit du minimum que doit donner un membre pour avoir une chance d\'avoir un item. <br />Ce n\'est pas le don minimum. Un membre peut donner plus ou moins que cette valeur.';
    $lang['Adr_beggar_win_chance']='Chance de gagner un item:';
    $lang['Adr_beggar_win_chance_explain']='Quand un utilisateur donne le minimum requis, c\'est le pourcentage de chance de gagner réellement n\'importe quel type d\'article';
    $lang['Adr_beggar_chance_increase']='Seuil de chance:';
    $lang['Adr_beggar_chance_increase_explain']='C\'est le seuil d\'argent qui permet d\'augmenter la chance de recevoir un item.  Par exemple placez le seuil à 100 points et si l\'utilisateur donne 500 points ils aura 5% plus de chance de recevoir un item';
    $lang['Adr_beggar_super_rare']='Seuil de chance pour un objet super rare:';
    $lang['Adr_beggar_super_rare_explain']='C\'est le don minimum exigée de l\'utilisateur pour avoir une chance à recevoir un item particulièrement rare.<br /><b>Note:</b> Ceci ne joue pas sur la chance pour l\'utilisateur de recevoir un article très rare';
    $lang['Adr_beggar_title']='Donation au mendiant';
}

if ( defined ('IN_ADR_LAKE'))
{
    $lang['Adr_lake_title']='Configuration du don d\'item du Lac';
    $lang['Adr_lake_title_explain']='Ici vous pouvez configurer les items disponible apres les dons au Lac';
    $lang['Adr_lake_chance']='Chance de gagner';
    $lang['Adr_lake_chance_explain']='Placez ceci à la chance de l\'utilisateur recevoir cet article lorsqu\'il reçoit une récompense du Lac.<br />Régler celui ci à \'Exceptionellement Rare\' demande au membre de donner au minimum la somme précider dans le panneau \'Lac\' de l\ACP pour être accessible';
    $lang['Adr_lake_chance_common']='Commun';
    $lang['Adr_lake_chance_uncommon']='Non commun';
    $lang['Adr_lake_chance_rare']='Rare';
    $lang['Adr_lake_chance_very_rare']='Trés Rare';
    $lang['Adr_lake_chance_super_rare']='Exceptionellement Rare';
    $lang['Adr_lake_min_amount']='Don minimun pour gagner un item:';
    $lang['Adr_lake_min_amount_explain']='Il s\'agit du minimum que doit donner un membre pour avoir une chance d\'avoir un item. <br />Ce n\'est pas le don minimum. Un membre peut donner plus ou moins que cette valeur.';
    $lang['Adr_lake_win_chance']='Chance de gagner un item:';
    $lang['Adr_lake_win_chance_explain']='Quand un utilisateur donne le minimum requis, c\'est le pourcentage de chance de gagner réellement n\'importe quel type d\'article';
    $lang['Adr_lake_chance_increase']='Seuil de chance:';
    $lang['Adr_lake_chance_increase_explain']='C\'est le seuil d\'argent qui permet d\'augmenter la chance de recevoir un item.  Par exemple placez le seuil à 100 points et si l\'utilisateur donne 500 points ils aura 5% plus de chance de recevoir un item';
    $lang['Adr_lake_super_rare']='Seuil de chance pour un objet super rare:';
    $lang['Adr_lake_super_rare_explain']='C\'est le don minimum exigée de l\'utilisateur pour avoir une chance à recevoir un item particulièrement rare.<br /><b>Note:</b> Ceci ne joue pas sur la chance pour l\'utilisateur de recevoir un article très rare';
    $lang['Adr_lake_title']='Donation au Lac';
}


//CAULDRON
if ( defined ('IN_ADR_CAULDRON'))
{
    $lang['Adr_cauldron']='Chaudron Magique';
    $lang['Adr_cauldron_explain']='Ici vous pouvez créer des combinaisons afin de composer des objets avec le chaudron magique';
    $lang['Adr_item_created_name']='Objet à créer';
    $lang['Adr_item1_combine_name']='Ingrédient 1';
    $lang['Adr_item2_combine_name']='Ingrédient 2';
    $lang['Adr_item3_combine_name']='Ingrédient 3';
    $lang['Adr_cauldron_add']='Ajouter Combinaison';
    $lang['Action']='Actions';
    $lang['Delete']='Supprimer';
    $lang['Edit']='Editer';
    $lang['Submit']='Envoyer';
    $lang['Fields_empty']='Vous devez impérativement remplir tous les champs demandés';
    $lang['Adr_item_choose_item']='Choisir Objet';
    $lang['Adr_cauldron_pack_successful_added']='Combinaison ajoutée avec succès';
    $lang['Adr_cauldron_successful_edited']='Combinaison éditée avec succès';
    $lang['Adr_cauldron_pack_successful_deleted']='Combinaison supprimée avec succès';
}
//CAULDRON end


$lang['Adr_admin_tools_armaggedon_battle_list']='Supprimer le texte de combat';
$lang['Adr_admin_tools_armaggedon_optimise']='Optimiser les tables';
$lang['Adr_admin_tools_armaggedon_shops_done']='Objets du magasin général supprimés.';
$lang['Adr_admin_tools_armaggedon_shops_yes']='Tous les objets des magasins ont été supprimés';
$lang['Adr_admin_tools_user_items']='Tous les objets des utilisateurs ont été supprimés.';

$lang['Adr_items_steal_explain']='Choisissez le niveau de difficulté du vol de cet objet dans le magasin. La valeur entre parenthèses est la classe de difficulté (DC), elle devrait être doublée pour savoir quel niveau est nécessaire au joueur pour réussir son vol. Cette valeur est invisible pour le joueur et devrait le rester.';

// Item Restriction keys
$lang['Adr_admin_item_restrict_title']='Restrictions d\'utilisation de l\'objet';
$lang['Adr_admin_item_restrict_class_enable']='Activer la restriction de classe';
$lang['Adr_admin_item_restrict_class_enable_explain']='Activer cette option permet de restreindre cet objet à une ou plusieurs classes.<br>Si elle est désactivée alors l\'objet sera accessible à tous indépendamment de la classe.';
$lang['Adr_admin_item_restrict_class']='Sélection de classe';
$lang['Adr_admin_item_restrict_alignment_enable']='Activer la restriction d\'élément';
$lang['Adr_admin_item_restrict_alignment_enable_explain']='Activer cette option permet de restreindre cet objet à un ou plusieurs alignements.<br>Si elle est désactivée alors l\'objet sera accessible à tous indépendamment de l\'alignement.';
$lang['Adr_admin_item_restrict_alignment']='Sélection d\'alignement';
$lang['Adr_admin_item_restrict_race_enable']='Activer la restriction de race';
$lang['Adr_admin_item_restrict_race_enable_explain']='Activer cette option permet de restreindre cet objet à une ou plusieurs races.<br>Si elle est désactivée alors l\'objet sera accessible à tous indépendamment de la race';
$lang['Adr_admin_item_restrict_race']='Sélection de race';
$lang['Adr_admin_item_restrict_element_enable']='Activer la restriction d\'élement';
$lang['Adr_admin_item_restrict_element_enable_explain']='Activer cette option permet de restreindre cet objet à un ou plusieurs éléments.<br>Si elle est désactivée alors l\'objet sera accessible à tous indépendamment de l\'élément.';
$lang['Adr_admin_item_restrict_element']='Sélection d\'élément';
$lang['Adr_admin_item_restrict_level']='Restriction de niveau';
$lang['Adr_admin_item_restrict_level_explain']='Niveau minimum requis pour utiliser cet objet.';
$lang['Adr_admin_item_restrict_chars']='Restrictions de caractéristiques';
$lang['Adr_admin_item_restrict_chars_explain']='Vous pouvez définir ici les caractéristiques minimums nécessaires pour pouvoir utiliser cet objet.';
$lang['Adr_admin_item_mass_delete']='Suppresion massive de cet objet des inventaires des utilisateurs';
$lang['Adr_admin_item_mass_delete_ex']='Selectioner cette option supprimera toutes les occurences de cet objet dans les inventaires des utilisateurs.<br>La recherche dans la base de données se fait par nom d\'objet uniquement, vous devriez donc selectionner cette option AVANT de renommer un objet si vous souhaitez supprimer massivement cet objet.<br>Cette option ne supprimera pas l\'objet des boutiques du forum, vous continuerez donc de le voir dans la liste d\'objets de l\'ACP.';

$lang['Adr_items_price_sp']='Coût en Points de Spiritualité (SP)';
$lang['Adr_items_price_sp_explain']='Vous pouvez rajouter un coût additionnel en points de spiritualité à cet objet (SP). Ils se gagnent en gagnant des combats contre des monstres.<br>Si la valeur est à zéro alors ce ne sera pas affiché dans la boutique du forum.';
$lang['Adr_items_price_fp']='Coût en Points de Faction (FP)';
$lang['Adr_items_price_fp_explain']='Vous pouvez rajouter un coût additionnel en points de faction à cet objet (FP). Ils se gagnent en gagnat des duels.<br>Si la valeur est à zéro alors ce ne sera pas affiché dans la boutique du forum.';

$lang['Adr_item_type_explain']='Ici, vous pouvez configurer les types d\'objet.'; 
$lang['Adr_item_type_add_edit']='Ajoutez ou éditez des types';
$lang['Adr_item_type_name']='Nom';
$lang['Adr_item_type_name_explain']='Nom de ce type d\'objet. Vous pouvez utiliser une clef de langue.';
$lang['Adr_item_type_id']='ID';
$lang['Adr_item_type_id_explain']='L\'ID (identfiant) du type';
$lang['Adr_item_type_price']='Prix';
$lang['Adr_item_type_price_explain']='Prix basique pour ce type d\'objet.';
$lang['Adr_item_type_successful_added']='Type d\'objet ajouté avec succès';
$lang['Adr_item_type_successful_edited']='Type d\'objet édité avec succès';
$lang['Adr_item_type_successful_deleted']='Type d\'objet supprimé avec succès';
$lang['Adr_item_type_add']='Ajoutez un type d\'objet';
$lang['Adr_item_type_category']='Catégorie';
$lang['Adr_item_type_category_explain']='Sélectionnez une catégorie dans la liste ou ajoutez-en une en remplissant le champ de texte';

# Advanced NPC System Expansion
$lang['Adr_races_all']='Toutes les races';
$lang['Adr_classes_all']='Toutes les classes';
$lang['Adr_elements_all']='Tous les éléments';
$lang['Adr_alignments_all']='Tous les alignements';
$lang['Adr_levels_all']='N\'importe quel niveau';

$lang['Adr_zones_all_stores']='-Toutes les zones-';
  $lang['Adr_zone_name_explain']='Choisissez les zones dans lesquelles le magasin apparaîtra (utilisez ctrl+clic pour en sélectionner plusieurs).';

# Loots
if ( defined ('IN_ADR_LOOTTABLES'))
{
    $lang['Adr_no_loottable'] = 'Pas de table de butin';
    $lang['Adr_admin_loot'] = 'Réglages des objets à obtenir'; 
    $lang['Adr_admin_mine'] = 'Objets à obtenir à la mine'; 
    $lang['Adr_admin_fish'] = 'Objets à obtenir à la pêche';
    $lang['Adr_admin_hunt'] = 'Objets à obtenir à la chasse';
    $lang['Adr_admin_herb'] = 'Objets à obtenir en herborisme';
    $lang['Adr_admin_lumber'] = 'Objets à obtenir en bûcheronnage';
    $lang['Adr_admin_tailor'] = 'Objets à obtenir en couture';
    $lang['Adr_admin_alchemy'] = 'Objets à obtenir en alchimie';

    $lang['Adr_items_loottables_title']='Table de butin';   
    $lang['Adr_items_loottables']='Tables de butin';
    $lang['Adr_items_loottables_explain']='Choisissez les tables de butin auxquelles vous voulez ajouter l\'objet';
    $lang['Adr_loottable_title']='Catégories de table';
    $lang['Adr_loottable_title_explain']='Créez et éditez les catégories de tables de butin :';
    $lang['Adr_loottable_name']='Nom de la table de butin :';
    $lang['Adr_loottable_items']='Objets :';
    $lang['Adr_loottable_name_explain']='Choisissez un nom pour la table :';
    $lang['Adr_loottable_desc']='Description :';
    $lang['Adr_loottable_desc_explain']='Description courte :';
    $lang['Adr_loottable_status_deactivated']='Off';
    $lang['Adr_loottable_status_activated']='On';
    $lang['Adr_loottable_dropchance_explain']='Choisissez la chance d\'obtention (1 à 10000)';
    $lang['Adr_loottable_dropchance_title']='Chance d\'obtention :';
    $lang['Adr_loottable_status']='Statut :';
    $lang['Adr_loottable_cat_add']='Ajouter une table de butin';
    $lang['Adr_loottable_cats_successful_new']='Table de butin créée avec succès';
    $lang['Adr_loottable_cats_successful_deleted']='Table de butin supprimée avec succès';
    $lang['Adr_loottable_cats_successful_edit']='Table de butin mise à jour avec succès';
    $lang['Adr_loottable_cats_successful_item_deleted']='L\'objet a été retiré de la table de butin';
    $lang['Adr_monster_loottables_title']='Choisissez les tables de butin que le monstre utilisera pour déterminer les objets que le joueur obtiendra';
    $lang['Adr_monster_loottables_explain']='Choisissez autant de tables de butin que vous voulez';
    $lang['Adr_monster_possible_drop_title']='Nombre d\'objets maximum à obtenir';
    $lang['Adr_monster_possible_drop_explain']='Choisissez le nombre d\'objets un joueur peut obtenir AU MAXIMUM, ce n\'est pas garanti';
    $lang['Adr_monster_guranteened_drop_title']='Nombre d\'objets minimum à obtenir';
    $lang['Adr_monster_guranteened_drop_explain']='Choisissez le nombre d\'objets un joueur sera sûr d\'obtenir !';
    $lang['Adr_monster_specific_drop_title']='Quels objets spécifiques ce monstre devrait faire tomber ?';
    $lang['Adr_monster_specific_drop_explain']='Choisissez quels objets doivent toukours tomber !';
    $lang['Adr_no_items']='Pas d\'objets';
}

# Monster Abilities
$lang['Adr_admin_monsters_base_regeneration']='Regénération de vie par tour';
$lang['Adr_admin_monsters_base_mp_regeneration']='Regénération de mana par tour';
$lang['Adr_admin_monsters_base_mp_drain']='Drain de mana par round';
$lang['Adr_admin_monsters_base_mp_transfer']='Drain/transfert de mana par round';
$lang['Adr_admin_monsters_base_hp_drain']='Drain de vie par round';
$lang['Adr_admin_monsters_base_hp_transfer']='Drain/transfert de vie round';

// Dynamic Town Maps
if ( defined ('IN_ADR_ZONE_MAPS'))
{
    $lang['Adr_admin_maps_zonemaps_title']='<b>Types de zone de plan de ville</b><br />Création et gestion de zone de plan de ville.';
    $lang['Adr_admin_maps_townmap_types']='Types de plan de ville';
    $lang['Adr_admin_maps_building_title']='<b>Cellules de bâtiment</b><br />Déterminez où les bâtiments peuvent être utilisés dans quel plan de ville.';
    $lang['Adr_admin_maps_building_cells']='Cellules de bâtiment';
    $lang['Adr_admin_maps_building_types_title']='<b>Types de bâtiment/cité</b><br />Déterminez le genre de bâtiments/cités que vous utiliserez.';
    $lang['Adr_admin_maps_building_types']='Types de bâtiment/cité';
    $lang['Adr_admin_maps_townmap_create_title']='<b>Créer une zone de plan de ville</b><br />Liste de zones sans plan de ville attribué.';
    $lang['Adr_admin_maps_townmap_edit_title']='Editer une zone existante du plan de ville</b><br />Liste des zones existantes du plan de ville.';
    $lang['Adr_admin_maps_zone_townmap_edit']='Edition de zone de plan de ville';
    $lang['Adr_admin_maps_townmap_edit_title']='<b>Editer une zone existante du plan de ville</b><br />Liste de zones avec plan de ville attribué.';
    $lang['Adr_admin_maps_townmap_system_title']='Système de configuration de zone dynamique de plans de ville';
    $lang['Adr_admin_maps_townmap_system_explain']='Cette section permet de modifier le système de zone de plan de ville.';
    $lang['Adr_admin_maps_missing_town_name']='Veuillez saisir un nom de zone <b>ou</b> sélectionnez en une existante! ';
    $lang['Adr_admin_maps_return_1']='<p>Cliquez %sici%s';
    $lang['Adr_admin_maps_return_2']=' pour retourner à la page principale de plan de zone.<p>Cliquez %sici%s';
    $lang['Adr_admin_maps_zone_not_exist']='Zone %s inexistante! ';
    $lang['Adr_admin_maps_no_townmap']=' Pas de plan de ville, en créer un ?';
    $lang['Adr_admin_maps_edit_townmap']='Edition de plan de ville';
    $lang['Adr_admin_maps_townmap_type']='Type de plan de ville';
    $lang['Adr_admin_maps_edit_zonemaps_title']='Editer les plans de zones';
    $lang['Adr_admin_maps_edit_zonemaps_explain']='Cette section permet d\'éditer les plans de zones pour les zones assignées.';
    $lang['Adr_admin_maps_editing_townmap']='Edition du %s plan de ville';
    $lang['Adr_admin_maps_buildings']='Bâtiments';
    $lang['Adr_admin_maps_remove_building']='Supprimer un bâtiment du plan de ville:';
    $lang['Adr_admin_maps_item']='Elément:';
    $lang['Adr_admin_maps_edit_zonemap']='Edition de plan de zone';
    $lang['Adr_admin_maps_place']='Emplacement:';
    $lang['Adr_admin_maps_cells']='Cellule - ';
    $lang['Adr_admin_maps_building']='Bâtiment';
    $lang['Adr_admin_maps_place building']='Placer le bâtiment';
    $lang['Adr_admin_maps_delete_townmap_explain']='<b>Note:</b>  Vous devez effacer un plan de ville pour attribuer à la zone un autre plan de ville.';
    $lang['Adr_admin_maps_delete_townmap']='EFFACER le plan de ville';
    $lang['Adr_admin_maps_main_back']='Retour à la page principale de configuration de plan de ville';
    $lang['Adr_admin_maps_main']='Principal';
    $lang['Adr_admin_maps_edit_townmaps_title']='Edition de plans de ville';
    $lang['Adr_admin_maps_edit_zone_townmaps_explain']='Cette section permet d\'éditer les plans de ville attribués aux zones.';
    $lang['Adr_admin_maps_zone_townmap_deleted']='Zone de plan de ville effacée!';
    $lang['Adr_admin_maps_select_zonemap']='Veuillez sélectionner un plan de ville!';
    $lang['Adr_admin_maps_zonemap_assigned']='Plan de zone attribué!';
    $lang['Adr_admin_maps_building_removed']='Bâtiment enlevé avec succès!';
    $lang['Adr_admin_maps_edit_townmap_back']='Retour à la page d\'édition de plan de ville';
    $lang['Adr_admin_maps_townmaps_explain']='Cette section permet d\'éditer la zone des plans de ville.';
    $lang['Adr_admin_maps_need_info']='Vous n\'avez pas renseigné tous les champs requis,<P>Veuillez recommencer!';
    $lang['Adr_admin_maps_duplicate_buildings']='Il y à déjà un bâtiment à cet emplacement!<p> Les bâtiments ne sont pas superposables!<p> Veuillez enlever le bâtiment avant d\'en mettre un autre!';
    $lang['Adr_admin_maps_place_building_success']='Bâtiment placé avec succès!';
    $lang['Adr_admin_maps_defined_city_images']='Images de ville définies:';
    $lang['Adr_admin_maps_defined_building_images']='Images de bâtiment définies:';
    $lang['Adr_admin_maps_defined_landscape_images']='Images de paysage définies:';
    $lang['Adr_admin_maps_no_images']='La base de données n\'a pas d\'images de bâtiment, de ville ou de paysage.';
    $lang['Adr_admin_maps_edit_item']='Editition d\'élément';
    $lang['Adr_admin_maps_images_define']='Note: Les images de bâtiments/paysages/villes doivent être au format GIF avec un fond transparent !<br />      Si l\'image n\'est pas au format GIF elle n\'apparaîtra pas. Si l\'image n\'a pas de fond transparent elle recouvrira l\'image de la carte.';
    $lang['Adr_admin_maps_add_building_new']='Ajouter un nouveau bâtiment/paysage/ville';
    $lang['Adr_admin_maps_select_building']='<b>Bâtiment, paysage ou ville:</b><br />Précisez s\'il s\'agit d\'un bâtiment, paysage ou ville.';
    $lang['Adr_admin_maps_place_city']='ville à placer sur une map monde';
    $lang['Adr_admin_maps_place_building']='bâtiment à placer sur le plan de ville';
    $lang['Adr_admin_maps_place_image']='image à placer sur le plan de ville';
    $lang['Adr_admin_maps_building_name']='Nom du bâtiment/paysage/ville:';
    $lang['Adr_admin_maps_building_name_explain']='Description basique de l\'image du bâtiment/ville (exemple \'prison2\').';
    $lang['Adr_admin_maps_building_image']='Nom du fichier de l\'image:';
    $lang['Adr_admin_maps_building_image_explain']='Nom du fichier de l\'image (sans l\'extension, le fichier doit être dans le dossier adr/images/zones/townmap/buildings ), exemple \'banque_1\'.';
    $lang['Adr_admin_maps_building_zone_link']='Lien de Zone :';
    $lang['Adr_admin_maps_building_zone_link_explain']='Fichier à exécuter quand un bâtiment est sélectionné. (sans l\'extension.  (exemple \'adr_shops\').';
    $lang['Adr_admin_maps_building_mouseover_tag']='Commentaire souris:';
    $lang['Adr_admin_maps_building_mouseover_tag_explain']='Texte à afficher quand le pointeur de la souris passe sur le bâtiment (exemple \'Temple sacré\').';
    $lang['Adr_admin_maps_building_tag_no']='Numéro de commentaire bâtiment:';
    $lang['Adr_admin_maps_building_tag_no_explain']='Numéro correspondant au bâtiment dans lang_adr_buildings.js.';
    $lang['Adr_admin_maps_add_building']='AJOUTER bâtiment/ville';
    $lang['Adr_admin_maps_building_configure_title']='Configuration des bâtiments/paysages/villes';
    $lang['Adr_admin_maps_building_configure_title_explain']='Cette section permet de spécifier le type de bâtiments/paysages/villes sont dans la base de données.';
    $lang['Adr_admin_maps_bulding_added']='Bâtiment ajouté/édité/effacé avec succès!';
    $lang['Adr_admin_maps_building_update']='MISE A JOUR d\'élément';
    $lang['Adr_admin_maps_building_delete']='SUPPRESSION de bâtiment/ville';
    $lang['Adr_admin_maps_building_info']='Vous ne pouvez pas sélectionner \"Aucun\" avec des cellules.<P>Veuillez essayer à nouveau.';
    $lang['Adr_admin_maps_zone_cell_edit']='Edition de cellules de bâtiments pour une zone';
    $lang['Adr_admin_maps_zone_edit']='EDITION DE ZONE';
    $lang['Adr_admin_maps_zone_cell_edit_explain']='Cette section permet de déterminer dans quelles cellules tel bâtiment peut être placé.';
    $lang['Adr_admin_maps_zone_cell_edit_for']='Edition de cellules de bâtiment pour';
    $lang['Adr_admin_maps_zonemap_cell_explain']='Image de plan de zone - Utilisez la souris pour voir le numéro de cellule';
    $lang['Adr_admin_maps_zonemap_cell_define']='Déterminer les cellules de bâtiment';
    $lang['Adr_admin_maps_zonemap_cell_ctrl']='Appuyez sur CTRL pour faire une sélection multiple';
    $lang['Adr_admin_maps_zonemap_cell_update']='MISE A JOUR DE CELLULES';
    $lang['Adr_admin_maps_building_cell_updated']='Cellules de bâtiment mises à jour!';
    $lang['Adr_admin_maps_zonemap_edit']='Edition des types de zone de plan de ville';
    $lang['Adr_admin_maps_zonemap_edit_existing']='Edition de plan de ville existant';
    $lang['Adr_admin_maps_zonemap_edit_map']='EDITION DE PLAN';
    $lang['Adr_admin_maps_zonemap_add_new']='Ajouter un nouveau plan de ville';
    $lang['Adr_admin_maps_zonemap_map_id']='ID de plan de ville';
    $lang['Adr_admin_maps_zonemap_map_id_explain']='Valeur numérique pour chaque plan de ville (utilisez un entier supérieur à 0 et n\'étant pas déjà pris).';
    $lang['Adr_admin_maps_zonemap_map_name']='Nom de plan de ville';
    $lang['Adr_admin_maps_zonemap_map_name_explain']='Nom pour ce plan de ville (exemple \'Petite ville\').';
    $lang['Adr_admin_maps_zonemap_map_image']='Image de fond du plan de ville';
    $lang['Adr_admin_maps_zonemap_map_image_explain']='Entrez un nom de fichier avec son extension, les images doivent être dans le dossier /adr/images/zones/townmap, une image par saison (il y a un dossier par saison))';
    $lang['Adr_admin_maps_zonemap_map_image_width']='Largeur du plan de ville';
    $lang['Adr_admin_maps_zonemap_map_image_width_explain']='Largeur en pixels (utilisez les dimensions de l\'image de fond).';
    $lang['Adr_admin_maps_zonemap_map_cell_width']='Largeur de cellule du plan de ville';
    $lang['Adr_admin_maps_zonemap_map_cell_width_explain']='Largeur des cellules du plan de ville (utilisez des dimension pouvant couvrir le haut de l\'image de fond).';
    $lang['Adr_admin_maps_zonemap_map_cell_width_amount']='Nombre de cellules dans la largeur du plan de ville';
    $lang['Adr_admin_maps_zonemap_map_cell_width_amount_explain']='Quantité de cellules que le plan de ville a dans sa largeur (La quantité multipliée avec la largeur de cellule doit être <i>exactement</i> la largeur de l\'image de fond !!!).';
    $lang['Adr_admin_maps_zonemap_map_image_height']='Hauteur du plan de ville';
    $lang['Adr_admin_maps_zonemap_map_image_height_explain']='Hauteur du plan de ville en pixels (utilisez les dimensions de l\'image de fond).';
    $lang['Adr_admin_maps_zonemap_map_cell_height']='Hauteur de cellule du plan de ville';
    $lang['Adr_admin_maps_zonemap_map_cell_height_explain']='Hauteur des cellules dans le plan de ville (utilisez des dimension pouvant couvrir le haut de l\'image de fond).';
    $lang['Adr_admin_maps_zonemap_map_cell_height_amount']='Quantité de cellules dans la hauteur du plan de ville';
    $lang['Adr_admin_maps_zonemap_map_cell_height_amount_explain']='La quantité multipliée avec la hauteur de cellule doit être <i>exactement</i> la hauteur de l\'image de fond !!!).';
    $lang['Adr_admin_maps_zonemap_map_add']='AJOUT de plan de ville';
    $lang['Adr_admin_maps_zonemap_map_edit']='Edition des types de plan de ville';
    $lang['Adr_admin_maps_zonemap_map_edit_explain']='Permet d\'ajouter de nouveaux ou de modifier d\'exsistants plans de ville.';
    $lang['Adr_admin_maps_zonemap_added']='Bâtiment ajouté/édité/effacé avec succès!';
    $lang['Adr_admin_maps_zonemap_map_editing']='Edition';
    $lang['Adr_admin_maps_zonemap_map_update']='MISE A JOUR DE PLAN MAP';
    $lang['Adr_admin_maps_zonemap_map_note']='<b>Note:</b> Toutes les zones utilisant ce plan de ville n\'auront plus de plan.';
    $lang['Adr_admin_maps_zonemap_map_warn']='Modifier les paramètres d\'un plan de ville effacera tous les plans de zone de ville de ce genre actuellement utilisés dans les zones!<br />(Toutes les zones utilisant ce plan de ville de ville seront sans plan.)';
    $lang['Adr_admin_maps_zonemap_map_delete']='EFFACER LE PLAN';
    $lang['Adr_admin_maps_need_numeric']='Un ou plusieurs champs n\'est pas numérique!<P>Veuillez revenir en arrière et essayer à nouveau.';
    $lang['Adr_admin_maps_need_negative']='Cet ID de plan de ville ne peut pas être 0 ou négatif.';
    $lang['Adr_admin_maps_need_exists']='Ce type de zone de plan de ville existe déjà!<P>Veuillez revenir en arrière et entrez un nouveau type de zone de plan de ville.';
    $lang['Adr_admin_maps_zone_remove_info']='Vous devez sélectionner un élément à supprimer!';
    $lang['Adr_admin_maps_error_1']='Erreur fatale lors de l\'accès aux plans de zone!';
    $lang['Adr_admin_maps_error_2']='Erreur fatale lors de l\'accès au nom de zone!';
    $lang['Adr_admin_maps_error_3']='Erreur fatale lors de l\'accès aux données de la zone!';
    $lang['Adr_admin_maps_error_4']='Erreur fatale lors de l\'accès aux données du bâtiment!';
    $lang['Adr_admin_maps_error_5']='Erreur fatale lors de l\'accès au plan de zone!';
    $lang['Adr_admin_maps_error_6']='Erreur fatale lors de l\'accès aux zones!';
    $lang['Adr_admin_maps_error_7']='Erreur fatale lors de l\'accès aux données de plan de ville!';
    $lang['Adr_admin_maps_error_8']='Erreur fatale lors de la mise à jour de zone des plans de ville!';
    $lang['Adr_admin_maps_error_9']='Erreur fatale lors de l\'accès au plan de ville!';
    $lang['Adr_admin_maps_error_10']='Erreur fatale lors de la mise à jour des données de bâtiment!';
    $lang['Adr_admin_maps_error_11']='Erreur fatale lors de la mise à jour des données de zone.';
    $lang['Adr_admin_maps_error_12']='Erreur fatale lors de la mise à jour de type de zone de plan de ville';
    $lang['Adr_admin_maps_error_13']='Erreur fatale lors de la mise à jour de plan de ville!';
    $lang['Adr_admin_maps_required']='[Requis]';
    $lang['Adr_admin_maps_remove']='Supprimer';
    $lang['Adr_admin_maps_assign']='Assigner';
    $lang['Adr_admin_maps_none']='Aucun';
}

// Day & Night & moar
$lang['Adr_time_acp_title']='Réglages de la période de la journée';
$lang['Adr_time_acp_explain']='Ici vous pouvez changer la période de la journée et changer la durée entre chaque';
$lang['Adr_time_acp_config']='Réglages';
$lang['Adr_time_acp_choice']='Changer la période de la journée';
$lang['Adr_time_acp_time']='Temps entre chaque période';
$lang['Adr_time_acp_days']='Jours';
$lang['Adr_time_acp_submit']='Modifier';
$lang['Adr_time_change_successful']='Réglages modifiés correctement';
$lang['Adr_time_empty']='Vous devez donner un temps entre 2 périodes';
$lang['Adr_Time_all']='N\'importe';
$lang['Adr_Time_1']='Aube';
$lang['Adr_Time_2']='Jour';
$lang['Adr_Time_3']='Crépuscule';
$lang['Adr_Time_4']='Nuit';
$lang['Adr_monsters_time_title'] = 'Période de la journée';

$lang['Adr_monster_time_choose']='Apparaît à l\'heure :';