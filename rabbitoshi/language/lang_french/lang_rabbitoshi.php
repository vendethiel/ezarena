<?php
/***************************************************************************
 *                            lang_rabbitoshi.php [French]
 *                              -------------------
 *     begin                : Thurs June 9 2006
 *     copyright            : (C) 2006 The ADR Dev Crew
 *     site                 : http://www.adr-support.com
 *
 *     $Id: lang_rabbitoshi.php,v 4.00.0.00 2006/06/09 02:32:18 Ethalic Exp $
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
// CONTRIBUTORS:
//	 Add your details here if wanted, e.g. Name, username, email address, website
// 200x-0x-xx  Malicious Rabbit - Original creation
// 200x-0x-xx  One Piece - Beta Development
// 200x-0x-xx  Seteo-Bloke & Narc0sis- English Translations
// 200x-06-09  Ethalic - New Release
// 2006-07-03  Vladek - French Translation
//

//
// The format of this file is ---> $lang['message'] = 'text';
//
// You should also try to set a locale and a character encoding (plus direction). The encoding and direction
// will be sent to the template. The locale may or may not work, it's dependent on OS support and the syntax
// varies ... give it your best guess!
//

$lang['Day']='Jour';
$lang['Days']='Jours';
$lang['Hour']='Heure';
$lang['Hours']='Heures';
$lang['Minute']='Minute';
$lang['Minutes']='Minutes';
$lang['Rabbitoshi_seconds']='Secondes';

// If you would like add a language key so that your items can be multi-languaged, then use the following.
// Replace x with the item name in lowercase of the item, then replace item name with the item name how you
// want it to appear on your site. Do the same for description. If you wish to add more, copy these two
// instances and repeat the same steps for each item.
// When you want to use the keys, goto your item management and input Rabbitoshi_items_x by itself as the item
// name and vice-verca with Rabbitoshi_items_x_desc for the description field. Remember to rename x for each
// individual item.
$lang['Rabbitoshi_items_x']='iten name';
$lang['Rabbitoshi_items_x_desc']='item description';


/***************************************************************************
 *   Rabbitoshi Page(s) Language Keys
 ***************************************************************************/

//
// General Messages
//
$lang['Rabbitoshi_title']='Rabbitoshi';
$lang['Rabbitoshi_previous']='Clicquez %sIci%s pour revenir a la page précédente';
$lang['Rabbitoshi_disable']='L\'animalerie est actuellement fermée . Veuillez réessayer plus tard.';
$lang['Rabbitoshi_owner_pet_lack']='Cet utilisateur ne possède pas de créature';
$lang['Rabbitoshi_default_points_name']='Neph';

//
// Index Page
//
$lang['Rabbitoshi_nopet_choose']='Il est préférable d\'avoir une créature avant de continuer';
$lang['Rabbitoshi_nopet_title']='Acheter une créature';
$lang['Rabbitoshi_nopet_lack']='Vous n\'avez pas suffisamment de Neph pour avoir une créature.';
$lang['Rabbitoshi_name_select']='Veuillez choisir un nom pour votre créature';
$lang['Rabbitoshi_buypet_success'] ='Félicitations pour votre achat ! Vous avez acheté cette créature avec succès.';
$lang['Rabbitoshi_pet_of']='La créature de';
$lang['Rabbitoshi_pet_prize']='Prix';
$lang['Rabbitoshi_pet_buy']='Acheter cette créature';
$lang['Rabbitoshi_pet_choose']='Choisir la créature ';
$lang['Rabbitoshi_pet_hunger']='Résistance à la faim';
$lang['Rabbitoshi_pet_thirst']='Résistance à la soif';
$lang['Rabbitoshi_pet_hygiene']='Résistance à la saleté';
$lang['Rabbitoshi_pet_call_vet']='Vétérinaire';
$lang['Rabbitoshi_pet_feed']='Nourrir';
$lang['Rabbitoshi_pet_drink']='Donner à boire';
$lang['Rabbitoshi_pet_clean']='Nettoyer';
$lang['Rabbitoshi_pet_caracs']='Caracteristiques';
$lang['Rabbitoshi_pet_characteristics']='Caractéristiques Combat';
$lang['Rabbitoshi_pet_attacks']='Ratio Attaques';
$lang['Rabbitoshi_pet_level']='Niveau';
$lang['Rabbitoshi_pet_experience']='Expérience';
$lang['Rabbitoshi_pet_curxp']='Expérience';
$lang['Rabbitoshi_pet_age']='Age';
$lang['Rabbitoshi_health']='Santé';
$lang['Rabbitoshi_health_explain']='Veuillez noter que l\'animal de compagnie perd également des points de santé s\'il a faim, altéré, ou son statut d\'hygiène est bas';
$lang['Rabbitoshi_ability_title']='Capacité restante';
$lang['Rabbitoshi_topic']='Voir l\'animal de compagnie de cet utilisateur';
$lang['Rabbitoshi_owner_last_visit']='Derniere visite';
$lang['Rabbitoshi_pet_favorite_food']='Nourriture favorite';
$lang['Rabbitoshi_pet_vet']='Votre créature est maintenant complètement guérie !';
$lang['Rabbitoshi_pet_vet_full']='Pourquoi aller chez le vétérinaire alors que votre créature est en bonne santé ?';
$lang['Rabbitoshi_pet_vet_lack']='Vous n\'avez pas suffisamment de points pour vous offrir ce service';
$lang['Rabbitoshi_vet_holidays']='Le vétérinaire est actuellement en déplacement . Veuillez réessayer plus tard.';
$lang['Rabbitoshi_services']='Services';
$lang['Rabbitoshi_pet_call_vet_explain']='Le vétérinaire peut guérir votre animal . Coût : ';
$lang['Rabbitoshi_owner_list']='Voir la liste des propriétaires';
$lang['Rabbitoshi_owner_list_explain']='Liste des possesseurs de créatures';
$lang['Rabbitoshi_food_no_need']='Votre créature n\'a pas besoin d\'être nourrie pour le moment';
$lang['Rabbitoshi_water_no_need']='Votre créature n\'a pas besoin de boire pour le moment';
$lang['Rabbitoshi_clean_no_need']='L\'habitat de votre créature n\'a pas besoin d\'être nettoyé pour le moment';
$lang['Rabbitoshi_lack_food']='Vous ne possédez pas la nourriture favorite de votre créature';
$lang['Rabbitoshi_lack_water']='Vous ne possédez rien pour donner à boire à votre créature';
$lang['Rabbitoshi_lack_cleaner']='Vous ne possédez rien pour nettoyer l\'habitat de votre créature';
$lang['Rabbitoshi_hidden']='Désolé , cet utilisateur souhaite garder secrètes les caractéristiques de sa créature<br /><br /> Cliquez <a href="'.append_sid("index.$phpEx").'">ici</a> pour retourner à l\'index du forum';

// Hotel
$lang['Rabbitoshi_hotel']='Hotel';
$lang['Rabbitoshi_hotel_explain']='Confier votre créature pendant les vacances';
$lang['Rabbitoshi_hotel_no_actions']='Vous ne pouvez pas effectuer cette action tant que votre créature est à l\'hôtel';
$lang['Rabbitoshi_pet_into_hotel']='Cette créature est actuellement à l\'hôtel . <br /> Elle reviendra le ';
$lang['Rabbitoshi_is_in_hotel']='Votre créature est dans l\'hôtel jusqu\'au ';
$lang['Rabbitoshi_hotel_welcome']='Bienvenue à l\'hôtel';
$lang['Rabbitoshi_out_of_hotel']='Cliquez ici pour récupérer votre créature';
$lang['Rabbitoshi_hotel_out_success']='Vous avez récupéré votre créature avec succès';
$lang['Rabbitoshi_hotel_welcome_services']='Nous pouvons garder votre créature si vous le désirez';
$lang['Rabbitoshi_hotel_welcome_services_select']='Selecionnez le nombre de jours';
$lang['Rabbitoshi_hotel_get_in']='Laisser votre animal à l\'hôtel';
$lang['Rabbitoshi_hotel_in_success']='Votre animal est maintenant hébergé à l\'hôtel';
$lang['Rabbitoshi_hotel_lack_money']='Vous n\'avez pas assez d\'argent pour payer l\'hôtel si longtemps à votre créature';
$lang['Rabbitoshi_hotel_disable']='L\'hotel est actuellement fermé.';

// Evolution
$lang['Rabbitoshi_evolution']='Evolution';
$lang['Rabbitoshi_evolution_explain']='Peut-être que votre créature peut évoluer...';
$lang['Rabbitoshi_no_evolution']='Votre créature est incapable d\'évoluer.';
$lang['Rabbitoshi_no_evolution_time']='Votre créature est trop jeune pour évoluer, réessayez plus tard !';
$lang['Rabbitoshi_evolution']='Evolution';
$lang['Rabbitoshi_evolution_welcome']='Veuillez choisir l\'évolution de votre créature';
$lang['Rabbitoshi_evolution_exec']='Evolution !';
$lang['Rabbitoshi_evolution_lack']='Vous ne pouvez pas vous permettre cette évolution';
$lang['Rabbitoshi_evolution_success']='Votre créature a évolué avec succès !!';
$lang['Rabbitoshi_evolution_enable']='Aucune évolution disponible.';

// Owners
$lang['Rabbitoshi_pet_name']='Nom de la créature';
$lang['Rabbitoshi_pet_time']='Age';
$lang['Rabbitoshi_pet_type']='Type';

// Preferences
$lang['Rabbitoshi_preferences']='Préférences';
$lang['Rabbitoshi_preferences_explain']='Gestion de vos préférences';
$lang['Rabbitoshi_preferences_notify']='Etre averti par message privé des besoins de ma créature';
$lang['Rabbitoshi_preferences_hide']='Cacher ma créature aux autres utilisateurs';
$lang['Rabbitoshi_preferences_feed_full']='Toujours donner à ma créature toute la nourriture dont elle a besoin';
$lang['Rabbitoshi_preferences_feed_full_explain']='En cochant cette option, vous utiliserez toute la nourriture disponible pour que votre créature n\'ait plus faim. Dans le cas contraire, vous ne lui donnerez qu\'un peu de nourriture à chaque fois';
$lang['Rabbitoshi_preferences_drink_full']='Toujours donner à ma créature l\'eau dont elle a besoin';
$lang['Rabbitoshi_preferences_drink_full_explain']='En cochant cette option, vous utiliserez toute l\'eau disponible pour que votre créature n\'ait plus soif. Dans le cas contraire, vous ne lui donnerez qu\'un peu d\'eau à chaque fois';
$lang['Rabbitoshi_preferences_clean_full']='Toujours nettoyer l\'habitat de ma créature jusqu\'à ce qu\'il soit complètement propre';
$lang['Rabbitoshi_preferences_clean_full_explain']='En cochant cette option vous nettoierez l\'habitat de votre créature jusqu\'à ce qu\'il soit entièrement propre. Dans le cas contraire, vous ne nettoirerez qu\'un peu à chaque fois';
$lang['Rabbitoshi_preferences_updated']='Vos préférences ont été mises à jour avec succès';

// Notification
$lang['Rabbitoshi_pm_news']='Quelques nouvelles de votre créature';
$lang['Rabbitoshi_pm_news_hotel']='Votre créature est actuellement confortablement installée à l\'hôtel';
$lang['Rabbitoshi_APM_pm']='Les statistiques de votre créature ont été mises à jour. Vous devriez aller prendre de ses nouvelles.';

// Selling Your Pet
$lang['Rabbitoshi_owner_sell']='Vendre votre créature';
$lang['Rabbitoshi_owner_pet_value']='Valeur de votre créature';
$lang['Rabbitoshi_pet_sell']='Vente de votre créature';
$lang['Rabbitoshi_pet_sell_for']='Voulez vraiment vendre votre créature pour';
$lang['Rabbitoshi_pet_sell_confirm']='Etes vous sûr de vouloir vendre votre créature ?';
$lang['Rabbitoshi_pet_sold']='Vous avez vendu votre créature pour ';
$lang['Rabbitoshi_return']='<br /><br /> Cliquez <a href="'.append_sid("rabbitoshi.$phpEx").'">ici</a> pour en acheter une autre<br /><br /> Cliquez <a href="'.append_sid("index.$phpEx").'">ici</a> pour retourner à l\'index du forum';

// Death of a Pet
$lang['Rabbitoshi_confirm']='Confirmation';
$lang['Rabbitoshi_pet_is_dead']='Votre créature est morte';
$lang['Rabbitoshi_pet_has_died']='Votre créature est morte.';
$lang['Rabbitoshi_pet_is_dead_cost']='Pour la revoir il vous en coutera';
$lang['Rabbitoshi_pet_is_dead_cost_explain']='Désirez vous payer ceci pour ressuciter votre créature ?';
$lang['Rabbitoshi_pet_dead_rebirth_no']='Votre créature est morte, revenez quand vous serez prêt à la ressuciter.<br /><br />Cliquez <a href="'.append_sid("adr_zones.$phpEx").'">ici</a> pour retourner au RPG<br /><br /> Cliquez <a href="'.append_sid("index.$phpEx").'">ici</a> pour retourner à l\'index du forum';
//Vous avez laissé mourrir votre créature .
$lang['Rabbitoshi_pet_dead_rebirth_ok']='Votre créature a ressucité !<br /><br /> Cliquez <a href="'.append_sid("rabbitoshi.$phpEx").'">ici</a> pour retourner vous en occuper<br /><br /> Cliquez <a href="'.append_sid("index.$phpEx").'">ici</a> pour retourner à l\'index du forum';
$lang['Rabbitoshi_pet_dead_lack']='Vous n\'avez pas les moyens de ressuciter votre créature';
$lang['Rabbitoshi_pet_dead']='Votre créature est morte. il est temps d\'en acheter une autre.';

//
// Progression Page
//
$lang['Rabbitoshi_pet_progress']='Progression de la créature';
$lang['Rabbitoshi_progress']='Ici vous pouvez augmenter les statistiques et le niveau de votre créature.';
$lang['Rabbitoshi_progress_experiencelimit_lack']='Votre créature n\'a pas le niveau requis pour augmenter de niveau.<br /><br />Cliquez <a href="'.append_sid("rabbitoshi.$phpEx").'">ici</a> pour retournez à la page de votre créature.';
$lang['Rabbitoshi_experience_name']='Points';
$lang['Rabbitoshi_progress_name']='Stats';
$lang['Rabbitoshi_progress_explain']='Explications';
$lang['Rabbitoshi_progress_number']='Points de progression';
$lang['Rabbitoshi_progress_price']='Prix';
$lang['Rabbitoshi_progress_submit']='Augmenter';
$lang['Rabbitoshi_progress_submit_title']='Progresser';
$lang['Rabbitoshi_owner_pet_health_explain']='Augmenter la Santé maximale';
$lang['Rabbitoshi_owner_pet_hunger_explain']='Augmenter la Faim maximale';
$lang['Rabbitoshi_owner_pet_thirst_explain']='Augmenter la Soif maximale';
$lang['Rabbitoshi_owner_pet_hygiene_explain']='Augmenter l\'Hygiène maximale';
$lang['Rabbitoshi_owner_pet_level_explain']='Augmentez le niveau de votre créature';
$lang['Rabbitoshi_owner_pet_power_explain']='Augmenter la Force';
$lang['Rabbitoshi_owner_pet_magicpower_explain']='Augmenter la Force mentale';
$lang['Rabbitoshi_owner_pet_armor_explain']='Augmenter l\'Armure';
$lang['Rabbitoshi_owner_pet_mpmax_explain']='Augmenter le Mana maximal';
$lang['Rabbitoshi_owner_pet_attack_explain']='Augmenter la limite d\'attaques';
$lang['Rabbitoshi_owner_pet_magicattack_explain']='Augmenter la limite de Magie';
$lang['Rabbitoshi_progress_ok']='Progression effectuée avec succès.';
$lang['Rabbitoshi_progress_experience_lack']='Votre créature n\'a pas assez d\'expérience pour augmenter cette statistique.';

// Reload
$lang['Rabbitoshi_progress_reload']='Recharger';
$lang['Rabbitoshi_owner_pet_attack_reload']='Limite d\'attaques rechargée au maximum';
$lang['Rabbitoshi_owner_pet_magic_reload']='Limite de Magie rechargée au maximum';

// Abilities
$lang['Rabbitoshi_ability_submit']='Apprendre';
$lang['Rabbitoshi_ability_name']='Capacités';
$lang['Rabbitoshi_ability_lack']='Aucune capacité';
$lang['Rabbitoshi_ability_explain']='Effet de la capacité';
$lang['Rabbitoshi_ability_price']='Coût de la capacité';
$lang['Rabbitoshi_ability_submit_title']='Apprendre';
$lang['Rabbitoshi_ability_regeneration']='Régénération';
$lang['Rabbitoshi_ability_regeneration_explain']='La régénération rend quelques points de santé à votre créature après chaque tour en utilisant ses propres points de mana.';
$lang['Rabbitoshi_ability_health']='Transfert de vie';
$lang['Rabbitoshi_ability_health_explain']='Le transfert de vie donne quelques points de vie de votre personnage à votre créature.';
$lang['Rabbitoshi_ability_mana']='Transfert de mana';
$lang['Rabbitoshi_ability_mana_explain']='Le transfert de mana donne quelques points de mana de votre personnage à votre créature.';
$lang['Rabbitoshi_ability_sacrifice']='Sacrifice';
$lang['Rabbitoshi_ability_sacrifice_explain']='Votre créature perd tous ses points de vie et inflige beaucoup de dommages à votre adversaire.';
$lang['Rabbitoshi_ability_price_lack']='Votre créature n\'a pas assez d\'expérience pour apprendre cette capacité<br /><br />Cliquez <a href="'.append_sid("rabbitoshi_progress.$phpEx").'">ici</a> pour revenir sur la page de progression de votre créature.';
$lang['Rabbitoshi_ability_stats_lack']='Les statistiques de votre créature ne sont pas suffisamment élevées pour apprendre cette capacité<br /><br />Cliquez <a href="'.append_sid("rabbitoshi_progress.$phpEx").'">ici</a> pour revenir sur la page de progression de votre créature.';

//
// Shop Page
//
$lang['Rabbitoshi_Shop']='Magasin';
$lang['Rabbitoshi_shop_name']='Nom';
$lang['Rabbitoshi_shop_img']='Image';
$lang['Rabbitoshi_item_desc']='Description';
$lang['Rabbitoshi_shop_prize']='Prix';
$lang['Rabbitoshi_item_type']='Type';
$lang['Rabbitoshi_item_sum']='Possédé';
$lang['Rabbitoshi_owner_points']='Votre argent';
$lang['Rabbitoshi_shop_action']='Objets en vente';
$lang['Rabbitoshi_shop_buy']='Acheter';
$lang['Rabbitoshi_shop_sell']='Vendre';
$lang['Rabbitoshi_lack_items']='Vous ne pouvez pas vendre un article que vous ne possédez pas.';
$lang['Rabbitoshi_lack']='Vous n\'avez pas assez d\'argent pour acheter cet article.';
$lang['Rabbitoshi_pet_shop']='Acheter et vendre des articles pour votre créature';
$lang['Rabbitoshi_general_return'] ='<br /><br /> Cliquez <a href="'.append_sid("rabbitoshi.$phpEx").'">ici</a> pour voir votre créature<br /><br /> Cliquez <a href="'.append_sid("rabbitoshi_shop.$phpEx").'">ici</a> pour acheter des articles pour votre créature<br /><br /> Cliquez <a href="'.append_sid("index.$phpEx").'">ici</a> pour retourner au Forum';
$lang['Rabbitoshi_shop_action_plus']='Ces articles ont été achetés pour ';
$lang['Rabbitoshi_shop_action_less']='Ces articles ont été vendus pour ';
$lang['Rabbitoshi_shop_lack_items']='Vous ne pouvez pas vendre des articles que vous ne possédez pas. ';

//
// Pet Inventory
//
$lang['Rabbitoshi_inventory']='Voir l\'Inventaire';
$lang['Rabbitoshi_inventory_value']='Valeur';
$lang['Rabbitoshi_inventory_quanity']='Quanity';
$lang['Rabbitoshi_inventory_action']='Vendre des Articles';


/***************************************************************************
 *   Rabbitoshi Pet Messages
 ***************************************************************************/

//
// Alerts
//
$lang['Rabbitoshi_message']='Alertes importantes';
$lang['Rabbitoshi_message_hungry']='Pitié, nourrissez-moi !';
$lang['Rabbitoshi_message_very_hungry']='Je deviens squelettique !';
$lang['Rabbitoshi_message_thirst']='Donnez-moi à boire, pitié ! ';
$lang['Rabbitoshi_message_very_thirst']='De l\'eau ... J\'en ai réellement besoin maintenant ...';
$lang['Rabbitoshi_message_health']='Pitié, soignez-moi !';
$lang['Rabbitoshi_message_very_health']='Argh ... Je meurs ... tout seul ... ';
$lang['Rabbitoshi_message_hygiene']='Je ne peux pas vivre dans cet endroit malpropre !';
$lang['Rabbitoshi_message_very_hygiene']='Je pense que j\'empeste. Ct endroit est trop sale.';

//
// Thoughts
//
$lang['Rabbitoshi_general_message']='Pensées récentes';
$lang['Rabbitoshi_general_message_very_bad']='Pourquoi?...Pourquoi moi?... Je meurs ... Je n\'ai plus aucune chance ... Que quelqu\'un m\'aide ...';
$lang['Rabbitoshi_general_message_bad']='Mon maître reviendra-t\'il ? il ne s\'occupe jamais de moi. Ce type de personne ne devrait pas être autorisée à posséder une créature !!';
$lang['Rabbitoshi_general_message_neutral']='Ma vie est sans intérêt !';
$lang['Rabbitoshi_general_message_good']='*chante sa joie de vivre*';
$lang['Rabbitoshi_general_message_very_good']='Je ne pourrais pas rêver d\'un meilleur maître ! Il est aux petits soins pour moi, je suis vraiment chanceux !';

//
// Pet Conditions
//
$lang['Rabbitoshi_creature_statut_0']='En bonne santé';
$lang['Rabbitoshi_creature_statut_1']='Triste';
$lang['Rabbitoshi_creature_statut_2']='Malade';
$lang['Rabbitoshi_creature_statut_3']='Empoisonné';
$lang['Rabbitoshi_creature_statut_4']='Furieux';


/***************************************************************************
 *   Administration Page Language Keys
 ***************************************************************************/

//
// Admin
//
$lang['rRabbitoshi_title']='Edition et suppression de créature';
$lang['rRabbitoshi_config_edit']='Edition de créature';
$lang['rRabbitoshi_desc']='Ici vous pouvez ajouter / éditer les créatures';

//
// Abilities
//
$lang['Rabbitoshi_abilities_settings']='Capacités spéciales';
$lang['Rabbitoshi_abilities_settings_explain']='Ici vous pouvez gérer toutes les capacités spéciales des créatures.';
$lang['Rabbitoshi_regeneration_level']='Niveau minimal requis pour apprendre la capacité Régénération';
$lang['Rabbitoshi_regeneration_magicpower']='Force mentale minimale requise pour apprendre la capacité Régénération';
$lang['Rabbitoshi_regeneration_mp']='Mana minimal requis pour apprendre la capacité Régénération';
$lang['Rabbitoshi_regeneration_mp_need']='Mana consummé par tour';
$lang['Rabbitoshi_regeneration_hp_give']='Points de vie reçus par tour';
$lang['Rabbitoshi_regeneration_price']='Coût de la capacité Régénération';
$lang['Rabbitoshi_health_level']='Niveau minimal requis pour apprendre la capacité Transfert de vie';
$lang['Rabbitoshi_health_magicpower']='Force mentale minimale requise pour apprendre la capacité Transfert de vie';
$lang['Rabbitoshi_health_health']='Points de vie requis pour apprendre la capacité Transfert de vie';
$lang['Rabbitoshi_health_percent']='Pourcentage de Points de vie donnés au personnage';
$lang['Rabbitoshi_healthtransfert_price']='Coût de la capacité Transfert de vie';
$lang['Rabbitoshi_mana_level']='Niveau minimal requis pour apprendre la capacité Transfert de mana';
$lang['Rabbitoshi_mana_magicpower']='Force mentale minimale requise pour apprendre la capacité Transfert de mana';
$lang['Rabbitoshi_mana_mp']='Mana minimal requis pour apprendre la capacité Transfert de mana';
$lang['Rabbitoshi_mana_percent']='Pourcentage de Points de mana donnés au personnage';
$lang['Rabbitoshi_mana_price']='Coût de la capacité Transfert de mana';
$lang['Rabbitoshi_sacrifice_level']='Niveau minimal requis pour apprendre la capacité Sacrifice';
$lang['Rabbitoshi_sacrifice_power']='Force minimale requise pour apprendre la capacité Sacrifice';
$lang['Rabbitoshi_sacrifice_armor']='Armure minimale requise pour apprendre la capacité Sacrifice';
$lang['Rabbitoshi_sacrifice_mp']='Mana minimal requis pour apprendre la capacité Sacrifice';
$lang['Rabbitoshi_sacrifice_price']='Coût de la compétence Sacrifice';

//
// Level Up
//
$lang['Rabbitoshi_levelup_settings']='Montée de niveau';
$lang['Rabbitoshi_levelup_settings_explain']='Ici vous pouvez paramétrer tous les bonus que reçoit la créature lors de la montée de niveau';
$lang['Rabbitoshi_levelup_earned']='Points max. gagnés';
$lang['Rabbitoshi_health_levelup']='Vie';
$lang['Rabbitoshi_hunger_levelup']='Faim';
$lang['Rabbitoshi_thirst_levelup']='Soif';
$lang['Rabbitoshi_hygiene_levelup']='Hygiène';
$lang['Rabbitoshi_power_levelup']='Force';
$lang['Rabbitoshi_magicpower_levelup']='Force mentale';
$lang['Rabbitoshi_armor_levelup']='Armure';
$lang['Rabbitoshi_mp_levelup']='Mana';
$lang['Rabbitoshi_attack_levelup']='Attaques';
$lang['Rabbitoshi_magicattack_levelup']='Attaques magiques';

//
// Pet Management
//
//$lang['Rabbitoshi_Pets_Management']='Gestion des créatures';
$lang['Rabbitoshi_manage_title']='Gestion de toutes les créatures';
$lang['Rabbitoshi_desc']='Ici vous pouvez gérer les créatures, modifier les valeurs, les éditer, ou les suprimer.';
$lang['Rabbitoshi_add']='Ajouter une créature';
$lang['Rabbitoshi_config']='Ajout de nouvelle créature';
$lang['Rabbitoshi_name']='Nom';
$lang['Rabbitoshi_img']='Image';
$lang['Rabbitoshi_img_explain']='Le nom de fichier et l\'extension où se trouve l\'image.';
$lang['Rabbitoshi_pet_health']='Vie';
$lang['Rabbitoshi_pet_hunger']='Faim';
$lang['Rabbitoshi_pet_thirst']='soif';
$lang['Rabbitoshi_pet_hygiene']='Hygiène';
$lang['Rabbitoshi_pet_armor']='Armure';
$lang['Rabbitoshi_pet_mp']='Mana';
$lang['Rabbitoshi_pet_power']='Force';
$lang['Rabbitoshi_pet_magicpower']='Force mentale';
$lang['Rabbitoshi_pet_ratioattack']='Attaques';
$lang['Rabbitoshi_pet_ratiomagic']='Magie';
$lang['Rabbitoshi_pet_xp']='Limite d\'expérience';
$lang['Rabbitoshi_pet_experience_limit']='Limite d\'expérience';
$lang['Rabbitoshi_food_type']='Type de nourriture';
$lang['Rabbitoshi_is_evolution_of']='Evolution';
$lang['Rabbitoshi_is_evolution_of_explain']='Vous pouvez sélectionnez une créature dont celle-ci sera l\'évolution.';
$lang['Rabbitoshi_is_evolution_of_none']='aucune';
$lang['Rabbitoshi_buyable']='En vente';
$lang['Rabbitoshi_buyable_explain']='Ceci permettra aux utilisateurs d\'acheter cette créature.';
$lang['Rabbitoshi_del_success']='Cette créature a été supprimée avec succès';
$lang['Rabbitoshi_add_success']='Cette créature a été ajoutée avec succès';
$lang['Rabbitoshi_edit_success']='Cette créature a été éditée avec succès';
$lang['Click_return_rabbitoshiadmin']='Cliquez %sici%s pour retourner à l\'administration des créatures';

// Pet specific levelup
$lang['Rabbitoshi_healthlevelup']='Vie à la montée de niveau';
$lang['Rabbitoshi_health_levelup_explain']='Nombre de points de vie que le familier reçoit quand il monte de niveau';
$lang['Rabbitoshi_hungerlevelup']='Faim à la montée de niveau';
$lang['Rabbitoshi_hunger_levelup_explain']='Nombre de points de faim que le familier reçoit quand il monte de niveau';
$lang['Rabbitoshi_thirstlevelup']='Soif à la montée de niveau';
$lang['Rabbitoshi_thirst_levelup_explain']='Nombre de points de soif que le familier reçoit quand il monte de niveau';
$lang['Rabbitoshi_hygienelevelup']='Hygiène à la montée de niveau';
$lang['Rabbitoshi_hygiene_levelup_explain']='Nombre de points d\'hygiène que le familier reçoit quand il monte de niveau';
$lang['Rabbitoshi_powerlevelup']='Force à la montée de niveau';
$lang['Rabbitoshi_power_levelup_explain']='Nombre de points de force que le familier reçoit quand il monte de niveau';
$lang['Rabbitoshi_magicpowerlevelup']='Force mentale à la montée de niveau';
$lang['Rabbitoshi_magicpower_levelup_explain']='Nombre de points de force mentale que le familier reçoit quand il monte de niveau';
$lang['Rabbitoshi_armorlevelup']='Défense à la montée de niveau';
$lang['Rabbitoshi_armor_levelup_explain']='Nombre de points de défense que le familier reçoit quand il monte de niveau';
$lang['Rabbitoshi_mplevelup']='Mana à la montée de niveau';
$lang['Rabbitoshi_mp_levelup_explain']='Nombre de points de mana que le familier reçoit quand il monte de niveau';
$lang['Rabbitoshi_attacklevelup']='Attaque à la montée de niveau';
$lang['Rabbitoshi_attack_levelup_explain']='Nombre de points d\'attaque que le familier reçoit quand il monte de niveau';
$lang['Rabbitoshi_magicattacklevelup']='Attaque magique à la montée de niveau';
$lang['Rabbitoshi_magicattack_levelup_explain']='Nombre de points d\'attaque magique que le familier reçoit quand il monte de niveau';

//
// Pet Shop
//
$lang['Rabbitoshi_shop_title']='Gestion du Magasin des créatures';
$lang['Rabbitoshi_shop_desc']='Ici vous pouvez gérer les articles du magasin des créatures';
$lang['Rabbitoshi_shop_edit_success']='Les articles ont été édités avec succès';
$lang['Rabbitoshi_shop_name']='Nom';
$lang['Rabbitoshi_shop_prize']='Prix';
$lang['Rabbitoshi_shop_type']='Type';
$lang['Rabbitoshi_shop_img']='Image';
$lang['Rabbitoshi_shop_power']='Puissance';
$lang['Rabbitoshi_shop_power_explain']='Points regagnés après utilisation de l\'article';
$lang['Rabbitoshi_item_type_food']='Nourriture';
$lang['Rabbitoshi_item_type_water']='Eau';
$lang['Rabbitoshi_item_type_misc']='Divers';
$lang['Rabbitoshi_item_type_food']='Nourriture';
$lang['Rabbitoshi_item_type_food_none']='Aucun';
$lang['Rabbitoshi_item_type_misc']='Divers';
$lang['Rabbitoshi_item_desc']='Description';
$lang['Rabbitoshi_shop_add']='Ajouter un article';
$lang['Rabbitoshi_shop_power_explain']='Ceci est le nombre de points regagnés quand l\'utilisateur utilise l\'article';
$lang['Rabbitoshi_item_type_misc']='Nettoyage';
$lang['Rabbitoshi_shop_title_add']='Ajouter un article';
$lang['Rabbitoshi_shop_config_add']='Cette fonction vous permet d\'ajouter un article dans le magasin des créatures';
$lang['Rabbitoshi_language_key']='Vous pouvez utiliser une clé de langue, référez-vous à language/lang_xxxx/lang_rabbitoshi.php';
$lang['Rabbitoshi_img_item_explain']='Le nom du fichier et l\'extension où se trouve l\'image.';
$lang['Rabbitoshi_shop_added_success']='Ce nouvel article a été ajouté avec succès';
$lang['Rabbitoshi_shop_del_success']='Cet article a été supprimé avec succès';
$lang['Click_return_rabbitoshi_shopadmin']='Cliquez %sici%s pour retourner sur la page de gestion du magasin des créatures';

//
// Pet Owners
//
$lang['Rabbitoshi_owner_admin_title']='Gestion des possesseurs de créatures';
$lang['Rabbitoshi_owner_admin_title_explain']='Ici vous pouvez modifier les caractéristiques des créatures des utilisateurs';
$lang['Rabbitoshi_owner_admin_submit']='Valider les modifications';
$lang['Rabbitoshi_owner_admin_select']='Sélectionnez un utilisateur :';
$lang['Rabbitoshi_owner_admin_select_submit']='Voir cet utilisateur';
$lang['Rabbitoshi_owner']='Nom du propriétaire';
$lang['Rabbitoshi_owner_pet']='Nom de la créature';
$lang['Rabbitoshi_owner_pet_type']='Type de créature';
$lang['Rabbitoshi_owner_pet_health']='Vie Max';
$lang['Rabbitoshi_owner_pet_hunger']='Faim Max';
$lang['Rabbitoshi_owner_pet_thirst']='Soif Max';
$lang['Rabbitoshi_owner_pet_hygiene']='Hygiène Max';
$lang['Rabbitoshi_owner_pet_mpmax']='Mana Max';
$lang['Rabbitoshi_owner_pet_level']='Niveau';
$lang['Rabbitoshi_owner_pet_power']='Force';
$lang['Rabbitoshi_owner_pet_magicpower']='Force mentale';
$lang['Rabbitoshi_owner_pet_armor']='Armure';
$lang['Rabbitoshi_owner_pet_experience']='Expérience';
$lang['Rabbitoshi_owner_pet_mp']='Mana';
$lang['Rabbitoshi_owner_pet_attack']='Attaque(s)';
$lang['Rabbitoshi_owner_pet_magicattack']='Attaque(s) magique(s)';
//$lang['Rabbitoshi_owner_pet_health']='Vie';
//$lang['Rabbitoshi_owner_pet_hunger']='Faim';
//$lang['Rabbitoshi_owner_pet_thirst']='Soif';
//$lang['Rabbitoshi_owner_pet_hygiene']='Hygiène';
$lang['Rabbitoshi_owner_admin_ok']='Caractéristiques de la créature éditées avec succès';
$lang['Rabbitoshi_admin_general_return']='<br /><br /> Cliquez <a href="'.append_sid("admin_rabbitoshi_owners.$phpEx").'">ici</a> pour retourner sur la page précédente<br /><br />';
$lang['Rabbitoshi_cron_admin_update']='Mise à jour manuelle ';
$lang['Rabbitoshi_cron_admin_update_explain']='Puisque les statistiques des créatures sont seulement mises à jour lorsque le propriétaire les regarde ou lors des mises à jour automatiques, les informations sur les propriétaires que vous pouvez voir à cette page pourraient être erronées. Cliquer sur le bouton de de mise à jour manuelle si vous voulez mettre à jour toutes les statistiques de créatures ';
$lang['Rabbitoshi_owner_admin_cron_ok']='Mise à jour manuelle effectuée avec succès';

//
// General Settings
//
//$lang['Rabbitoshi_settings']='Configuration générale du système de créatures';
//$lang['Rabbitoshi_settings_explanations']='Indiquez la période entre deux diminutions, et la valeur de chaque diminution';
$lang['Rabbitoshi_settings_explain']='Vous pouvez actuver/désactiver le système de créatures, changer son nom, etc.';
$lang['Rabbitoshi_use']='Utiliser le système de créatures';
$lang['Rabbitoshi_settings_name']='Nom du système de créature';
$lang['Rabbitoshi_cron_use']='Utiliser la mise à jour automatique des statistiques des créatures';
$lang['Rabbitoshi_cron_explain']='Ce système permet de mettre à jour automatiquement les statistiques des créatures . Etant donné que ceci consomme beaucoup de puissance machine , cela ne peut pas être réalisé en permanence . Si vous possédez beaucoup d\'utilisateurs , il est conseillé de ne pas mettre une durée entre deux mises à jour automatiques inférieure à une journée';
$lang['Rabbitoshi_cron_time']='Délai entre les mises à jour automatique des statistiques des créatures';
$lang['Rabbitoshi_rebirth_enable']='Autoriser la résurrection';
$lang['Rabbitoshi_rebirth_enable_explain']='Si vous cochez cette option , vos membres pourront payer pour que leur créature revive une fois morte. Dans le cas contraire ils devront en acheter une autre';
$lang['Rabbitoshi_rebirth_price']='Coût de la résurrection';
$lang['Rabbitoshi_vet_enable']='Activer le vétérinaire';
$lang['Rabbitoshi_rebirth_vet_explain']='En utilisant le vétérinaire, les propriétaires peuvent redonner tous ses points de vie à leur créature';
$lang['Rabbitoshi_vet_price']='Coût du vétérinaire';
$lang['Rabbitoshi_hotel_use']='Activer l\'hôtel';
$lang['Rabbitoshi_hotel_use_explain']='When a pet is in the hotel, his status bars don\'t decrease';
$lang['Rabbitoshi_hotel_price']='Coût de l\'hôtel';
$lang['Rabbitoshi_hotel_price_explain'] ='Coût pour chaque jour passé dans l\'hôtel';
$lang['Rabbitoshi_hotel_exp']='Perte d\'expérience';
$lang['Rabbitoshi_hotel_exp_explain']='Points d\'expérience perdus par jour passé à l\'hôtel';
$lang['Rabbitoshi_evolution_use']='Activer l\'évolution';
$lang['Rabbitoshi_evolution_use_explain']='Si vous cochez cette option, certaines créatures pourront évoluer ( regardez aussi dans la gestion des créatures )';
$lang['Rabbitoshi_evolution_price']='Prix d\'une évolution';
$lang['Rabbitoshi_evolution_price_explain']='Pourcentage du coût de la créature ( laissez cette valeur nulle si vous voulez que l\'évolution soit gratuite )';
$lang['Rabbitoshi_evolution_time']='Temps requis';
$lang['Rabbitoshi_evolution_time_explain']='Nombre de jours de possession minimal pour évoluer';
$lang['Rabbitoshi_hunger_time']='Temps avant que la <b>Faim</b> ne diminue (en secondes)';
$lang['Rabbitoshi_hunger_value']='Valeur de la diminution';
$lang['Rabbitoshi_thirst_time']='Temps avant que la <b>Soif</b> ne diminue (en secondes)';
$lang['Rabbitoshi_thirst_value']='Valeur de la diminution';
$lang['Rabbitoshi_health_time']='Temps avant que la <b>Santé</b> ne diminue (en secondes)';
$lang['Rabbitoshi_health_value']='Valeur de la diminution';
$lang['Rabbitoshi_hygiene_time']='Temps avant que l\'<b>Hygiène</b> ne diminue (en secondes)';
$lang['Rabbitoshi_hygiene_value']='Valeur de la diminution';
$lang['Rabbitoshi_level_price']='Points d\'expérience nécessaires pour la montée de niveau';
$lang['Rabbitoshi_attack_reload_price']='Expérience requise pour augmenter le nombre d\'attaques de 1';
$lang['Rabbitoshi_magic_reload_price']='Expérience requise pour augmenter la magie de 1';
$lang['Rabbitoshi_health_price']='Expérience nécessaire pour augmenter les Points de vie max.';
$lang['Rabbitoshi_hunger_price']='Expérience nécessaire pour augmenter la Faim max.';
$lang['Rabbitoshi_thirst_price']='Expérience nécessaire pour augmenter la Soif max.';
$lang['Rabbitoshi_hygiene_price']='Expérience nécessaire pour augmenter l\'Hygiène max.';
$lang['Rabbitoshi_power_price']='Expérience nécessaire pour augmenter la Force';
$lang['Rabbitoshi_magicpower_price']='Expérience nécessaire pour augmenter la Force mentale';
$lang['Rabbitoshi_armor_price']='Expérience nécessaire pour augmenter l\'Armure';
$lang['Rabbitoshi_attack_price']='Expérience nécessaire pour augmenter l\'Attaque max.';
$lang['Rabbitoshi_magicattack_price']='Expérience nécessaire pour augmenter la magie max.';
$lang['Rabbitoshi_mp_price']='Expérience nécessaire pour augmenter les Points de mana max.';
$lang['Rabbitoshi_health_raise']='Points gagnés';
$lang['Rabbitoshi_hunger_raise']='Points gagnés';
$lang['Rabbitoshi_thirst_raise']='Points gagnés';
$lang['Rabbitoshi_hygiene_raise']='Points gagnés';
$lang['Rabbitoshi_power_raise']='Points gagnés';
$lang['Rabbitoshi_magicpower_raise']='Points gagnés';
$lang['Rabbitoshi_armor_raise']='Points gagnés';
$lang['Rabbitoshi_attack_raise']='Points gagnés';
$lang['Rabbitoshi_magicattack_raise']='Points gagnés';
$lang['Rabbitoshi_mp_raise']='Points gagnés';
$lang['Rabbitoshi_experience_min']='Expérience minimale gagnée par la créature après chaque combat';
$lang['Rabbitoshi_experience_max']='Expérience maximale gagnée par la créature après chaque combat';
$lang['Rabbitoshi_mp_min']='Mana <b>minimum</b>requis pour une attaque magique, entre deux valeurs';
$lang['Rabbitoshi_mp_max']='Mana <b>maximum</b>requis pour une attaque magique, entre deux valeurs';
$lang['Rabbitoshi_updated_return_settings']='Configurations générales mises à jour avec succès<br /><br /> Clisuez %sici%s pour retourner sur la page de configuration générale des créatures';
$lang['Rabbitoshi_update_error']='Une erreur s\'est produite lors de la mise à jour !';


/***************************************************************************
 *   ADR Battle Language Keys
 ***************************************************************************/
$lang['Adr_Rabbitoshi_invoc_succes']='Vous avez appelé votre créature pour qu\'elle vous aide au combat.';
$lang['Rabbitoshi_battle_pet_title']='Votre créature est sur le champ de bataille';
$lang['Rabbitoshi_battle_pet_title_dead']='Votre créature est morte';
$lang['Rabbitoshi_battle_pet_health']='Vie';
$lang['Rabbitoshi_battle_pet_mp']='Mana';
$lang['Rabbitoshi_battle_pet_attack']='Attaques';
$lang['Rabbitoshi_battle_pet_magicattack']='Magie';
$lang['Rabbitoshi_battle_pet_action_attack']='Attaquer';
$lang['Rabbitoshi_battle_pet_action_magicattack']='Attaque magique';
$lang['Rabbitoshi_battle_pet_action_invoc']='Appeler ';

// Battle Text
$lang['Adr_battle_monster_success_critical']='Votre adversaire inflige un coup critique de %s point(s) de dégât à votre créature.';
$lang['Adr_battle_monster_success']='Votre adversaire inflige %s point(s) de dégât à votre créature.';
$lang['Adr_battle_pet_success']='Votre créature inflige %s points de dégât à votre adversaire.';
$lang['Adr_battle_pet_success_critical']='Votre créature inflige un coup critique de %s point(s) de dégât à votre adversaire.';
$lang['Adr_battle_pet_poison']='Le poison inflige %d point(s) de dégât à votre créature.';
$lang['Adr_battle_pet_dead_or_limitattack']='Vous ne pouvez pas lancer cette attaque avec votre créature parce qu\'elle est déjà morte ou que la limite d\'attaques a été atteinte.';
$lang['Adr_battle_pet_dead_or_limitmagicattack']='Vous ne pouvez pas lancer cette attaque avec votre créature parce qu\'elle est déjà morte ou que la limite d\'attaques magiques a été atteinte.';
$lang['Adr_battle_pet_mp_lack']='Vous n\'avez pas assez de mana pour tenter cette attaque';
$lang['Adr_battle_pet_regeneration_mess']='La capacité Régénération est automatique. Vous n\'avez pas besoin de l\'activer';
$lang['Adr_battle_pet_noability']='Vous n\'avez aucune capacité spéciale';
$lang['Rabbitoshi_Adr_battle_regen']='Votre créature regagne %s point(s) de vie avec la capacité Régénération.';
$lang['Rabbitoshi_Adr_battle_pet_sacrifice']='Votre créature se sacrifie et inflige %s point(s) de dégât à votre adversaire.';
$lang['Rabbitoshi_Adr_battle_pet_mana_transfert']='Votre créature vous cède %s points de mana.';
$lang['Rabbitoshi_Adr_battle_pet_health_transfert']='Votre créature vous cède %s points de vie.';
$lang['Adr_battle_pet_win']='Votre créature gagne %s point(s) d\'expérience pour avoir particippé au combat.';

// Condition
$lang['Adr_battle_pet_newstatut_1']='Votre créature déprime';
$lang['Adr_battle_pet_newstatut_2']='Votre créature est actuellement malade';
$lang['Adr_battle_pet_newstatut_3']='Votre créature est actuellement empoisonneé';
$lang['Adr_battle_pet_newstatut_4']='Votre créature est furieuse';

//
// That's all Folks!
// -------------------------------------------------

// V: Level Up Penalty

$lang['Rabbitoshi_level_up_penalty']='Pénalité d\'xp pour la montée de niveau';
$lang['Rabbitoshi_level_up_penalty_explain']='Pourcentage d\'expérience nécessaire pour monter de niveau (plus un familier est haut niveau, plus il a besoin d\'expérience pour passer le prochain niveau)';

// V: seems those were left out... completed by hand
$lang['Rabbitoshi_creature_characteristics'] = 'Caractéristiques du familier';
$lang['Rabbitoshi_creature_attacks'] = 'Attaques du familier';
$lang['Rabbitoshi_shop_return'] = 'Revenir au magasin';
