<?php 
/*************************************************************************** 
* 			lang_adr_spells.php [English] 
* 				------------------- 
*				begin: 01/07/2007
*				copyright: egdcltd (http://games.directorygold.com)
****************************************************************************/ 

$lang['Adr_spells_page_name'] = 'Sorts';
$lang['Adr_battle_check_two'] = 'Vous n\'avez pas assez de mana pour lancer ce sort';
$lang['Adr_battle_healing_success'] = '%s lance %s, se rendant %s HP !';
$lang['Adr_battle_no_spell_learned'] = 'Pas de sort';
$lang['Adr_spell_learned'] = 'Lancer un sort';
$lang['Adr_spells_learned'] = 'Lancer un sort';
$lang['Adr_items_class_limit'] = 'Classes autorisées';
$lang['Adr_items_type_magic_heal'] = 'Sort de soin';
$lang['Adr_spell_not_learned'] = 'Vous n\'avez pas appris de sort';


$lang['Adr_items_type_spell_attack'] = 'Sort : &Eacute;vocation';
$lang['Adr_items_type_spell_defend'] = 'Sort : Abjuration';
$lang['Adr_spells_already_learned'] = 'Sort déjà connu';
$lang['Adr_spells_too_powerful'] = 'Le personnage n\'est pas assez haut niveau pour apprendre ce sort';
$lang['Adr_spells_wrong_class'] = 'Votre classe ne vous permet pas d\'apprendre ce sort';
$lang['Adr_spells_wrong_alignment'] = 'Votre alignement ne vous permet pas d\'apprendre ce sort';
$lang['Adr_spells_wrong_element'] = 'Votre élément ne vous permet pas d\'apprendre ce sort';
$lang['Adr_spells_skill_evocation'] = '&Eacute;vocation';
$lang['Adr_spells_skill_healing'] = 'Soin';
$lang['Adr_spells_skill_abjuration'] = 'Abjuration';
$lang['Adr_spells_successful_added'] = 'Vosu avze correctement appris ce sort';
$lang['Adr_spells_learn_link'] = 'Apprendre';
$lang['Adr_items_type_spell_recipe'] = 'Parchemin de sort';
$lang['Adr_spells_was_deleted'] = 'Ce sort a été supprimé';
$lang['Adr_spells_missing_item'] = 'Vous ne disposez pas des composants nécessaires pour lancer ce sort';

//Casting messages
$lang['Adr_spells_cast'] = 'Lancer ce sort';
$lang['Adr_spells_cast_mp'] = 'Vous avez %s points de Mana';
$lang['Adr_spells_target_select'] = 'Choisissez sur qui lancer le sort :';
$lang['Adr_spells_target_battle'] = 'Ce personnage est en combat, vous ne pouvez pas lui lancer de sort dessus pour le moment';
$lang['Adr_spells_target_dead'] = 'Ce personnage est mort, vous ne pouvez pas lui lancer de sort dessus pour le moment';
$lang['Adr_spells_target_health_full'] = 'La vie de ce personnage est déjà au maximum';
$lang['Adr_spells_heal_cast'] = 'Vous venez de lancer <i>%s</i> sur %s, rendant %s points de vie !';
$lang['Adr_spells_heal_pm_title'] = 'Vous avez été soigné par un autre joueur';
$lang['Adr_spells_heal_pm_text'] = '%s vous a lancé un sort de soin, vous rendant %s points de vie !';
$lang['Adr_spells_cast_already'] = '%s a déjà lancé un sort de soin sur ce personnage';
$lang['Adr_spells_cast_boost_success'] = 'Vous avez lancé <i>%s</i> sur %s, augmentant son attaque et son défense pour son prochain combat';
$lang['Adr_lang_cast_boost_pm_title'] = 'On vous a lancé un sort';
$lang['Adr_lang_cast_boost_pm_text'] = '%s a lancé <i>%s</i> sur vous, augmentant votre attaque et votre défense pour votre prochain combat';
$lang['Adr_spells_wrong_place'] = 'Vous devez être dans la même zone que votre cible';

//Battle messages
$lang['Adr_battle_spell_ma_increase'] = '%s lance %s, augmentant votre attaque magique par %s points !';
$lang['Adr_battle_spell_md_increase'] = '%s lance %s, augmentant votre défense magique par %s points !';
$lang['Adr_battle_spell_pa_increase'] = '%s lance %s, augmentant votre attaque physique par %s points !';
$lang['Adr_battle_spell_pd_increase'] = '%s lance %s, augmentant votre défense physique par %s points !';	
$lang['Adr_battle_spell_mamd_increase'] = '%s lance %s augmentant votre attaque et défense magique par %s points !';
$lang['Adr_battle_spell_pama_increase'] = '%s lance %s augmentant votre attaque physique et magique par %s points !';
$lang['Adr_battle_spell_pdmd_increase'] = '%s lance %s augmentant votre défense physique et magique par %s points !';
$lang['Adr_battle_spell_papdmamd_increase'] = '%s lance %s augmentant votre physical attack and defense and magical attack and defense par %s points !';
	$lang['Adr_battle_spell_hpmana'] = '%s lance %s, échangeant des points de vie pour des points de mana, pour un total de %s points de Mana !';
$lang['Adr_battle_spell_monster_pa_decrease'] = '%s lance %s sur %s, diminuant leur attaque physique par %s';
$lang['Adr_battle_spell_monster_pa_decrease_fail'] = '%s lance %s sur %s, mais leur attaque physique est déjà 0';
$lang['Adr_battle_spell_monster_pd_decrease'] = '%s lance %s sur %s, diminuant leur défense physique par %s';
$lang['Adr_battle_spell_monster_pd_decrease_fail'] = '%s lance %s sur %s, mais leur défense physique est déjà 0';
$lang['Adr_battle_spell_monster_ma_decrease'] = '%s lance %s sur %s, diminuant leur attaque magique par %s';
$lang['Adr_battle_spell_monster_ma_decrease_fail'] = '%s lance %s sur %s, mais leur attaque magique est déjà 0';
$lang['Adr_battle_spell_monster_md_decrease'] = '%s lance %s sur %s, diminuant leur défense magique par %s';
$lang['Adr_battle_spell_monster_md_decrease_fail'] = '%s lance %s sur %s, mais leur défense magique est déjà 0';
$lang['Adr_battle_spell_disease_cure'] = '%s lance %s, se guérissant de %s';
$lang['Adr_battle_spell_disease_no_cure'] = '%s lance %s mais ce sort ne peut pas guérir l\'empoisonnement qui vous touche';
$lang['Adr_battle_spell_no_disease'] = '%s lance %s mais vous n\'avez pas été empoisonné';

if ( defined ('IN_ADR_ADMIN'))
{
	$lang['Adr_forum_shop_spells'] = 'Sorts';
	$lang['Adr_spells_type_use_explain'] = 'Choisissez le type de sort depuis la liste déroulante.<br/><b>Assurez vous d\'utiliser un type de sort valide (par défaut : "sort offensif", "sort défensif", "sort de soin")';
	$lang['Adr_spells_type'] = 'Type de sort';
	$lang['Adr_spells_title'] = 'Gestion des sorts';
	$lang['Adr_spells_title_explain'] = 'Ici, vous pouvez gérer les sorts du RPG';
	$lang['Adr_spells_class_explain'] = 'Choisissez les classes qui pourront utiliser ce sort. Sélectionnez "Toutes les classes" pour retirer la limitation. Utilisez ctrl+clic pour sélectionner plusieurs classes.';
	$lang['Adr_spells_add_title'] = 'Ajouter ou éditer des sorts';
	$lang['Adr_spells_add_title_explain'] = 'Ici vous pouvez ajouter ou éditer des sorts';

	$lang['Adr_spells_attention'] = 'ATTENTION. Supprimer un sort le retirera aussi de la liste de sorts des joueurs.';
	$lang['Adr_spells_level_explain'] = 'Niveau que le personnage doit avoir pour apprendre ce sort';
	$lang['Adr_spells_auth'] = 'Pas en montant de niveau';
	$lang['Adr_spells_auth_explain'] = 'En cochant cette case, les joueurs n\'apprendront pas ce sort en montant de niveau.';
	$lang['Adr_spells_item_recipe'] = 'Recette';
	$lang['Adr_spells_item_recipe_explain'] = 'Si vous voulez qu\'une recette pré-existant serve de recette (parchemin) pour apprendre ce sort, sélectionnez-le ici. Sinon, choisissez "Non".';
	$lang['Adr_spells_recipe_none'] = 'Pas de recette';
	$lang['Adr_spells_items_req'] = 'Composants pour lancer';
	$lang['Adr_spells_items_req_desc'] = 'Sélectionnez les objets nécessaires au lancement du sort. Si aucun, choisissez \'Non\'';
	$lang['Adr_spells_items_amount'] = 'Montant de chaque objet nécessaire pour lancer le sort';
	$lang['Adr_spells_items_amount_desc'] = 'Exemple : si vous avez choisis 3 objets et que vous voulez 2x le premier, 1x le second et 5x du dernière, mettez dans le champ 2:1:5. L\'ordre correspond à l\'ordre de la liste !<br /><br />Laissez blanc pour utiliser "1" comme quantité partout';
	$lang['Adr_spells_components'] = 'Composants';
	$lang['Adr_spells_battle'] = 'Sort lançable ...';
	$lang['Adr_spells_battle_explain'] = 'Choisissez \'En combat\' si le sort est lançable SEULEMENT pendant un combat, \'En combat\' si le sort est seulement lançable en combat (contre des monstres et en PVP), ou \'Les deux\' si le sort est utilisable dans les deux cas.';
	$lang['Adr_spells_xtreme'] = 'Code PHP au lancement du sort - Hors combat';
	$lang['Adr_spells_xtreme_explain'] = 'Code (PHP) a exécuter au lancement du sort <i>hors combat</i>, <b>au lieu</b> d\'utiliser le code de base.<br/><b>Si vous ne savez pas à quoi cette case correspond, LAISSEZ LA BLANCHE</b>';
	$lang['Adr_spells_xtreme_battle'] = 'Code PHP au lancement du sort - En combat';
	$lang['Adr_spells_xtreme_battle_explain'] = 'Code (PHP) a exécuter au lancement du sort <i>en combat</i>, <b>au lieu</b> d\'utiliser le code de base.<br/><b>Si vous ne savez pas à quoi cette case correspond, LAISSEZ LA BLANCHE</b>';
	$lang['Adr_spells_xtreme_pvp'] = 'Code PHP au lancement du sort - en JcJ';
	$lang['Adr_spells_xtreme_pvp_explain'] = 'Code (PHP) a exécuter au lancement du sort <i>dans un combat Joueur contre Joueur</i>.<br/><b>Si vous ne savez pas à quoi cette case correspond, LAISSEZ LA BLANCHE</b>';
	$lang['Adr_spells_no_battle'] = 'Hors combat';
	$lang['Adr_spells_battle'] = 'En combat';
	$lang['Adr_spells_battle_no_battle'] = 'Les deux';
	$lang['Adr_spells_admin_only'] = 'Administrateurs seulement ?';
	$lang['Adr_spells_spell_successful_deleted'] = 'Sort supprimé avec succès';
	$lang['Adr_spells_spell_successful_edited'] = 'Sort édité avec succès';
	$lang['Adr_spells_spell_successful_added'] = 'Sort ajouté avec succès';
	$lang['Adr_spells_spell_add'] = 'Ajouter un sort';
	$lang['Adr_spells_spell_name'] = 'Nom';
	$lang['Adr_spells_skill'] = 'Compétence';
	$lang['Adr_spells_alignment_limit'] = 'Restriction d\'alignement';
	$lang['Adr_spells_alignment_limit_explain'] = 'Choisissez le(s) alignement(s) autorisés à utiliser ce sort. Utilisez ctrl - click pour sélectionner plusieurs alignements.';
	$lang['Adr_spells_element_limit'] = 'Restriction d\'élément';
	$lang['Adr_spells_element_limit_explain'] = 'Choisissez les éléments qui peuvent utiliser ce sort. Utilisez ctrl - click pour sélectionner plusieurs éléments.';
	$lang['Adr_spells_give_spell_success'] = 'Sort(s) ajoutés avec succès';
	$lang['Adr_spells_general_change_successful'] = 'Réglages mis à jour';
	$lang['Adr_spells_pm'] = 'Envoyer des MPs';
	$lang['Adr_spells_pm_explain'] = 'Choisissez Oui pour que les joueurs reçoivent un message privé lorsqu\'ils sont la cible d\'un sort.';
	$lang['Adr_spells_general_title'] = 'Réglages';
	$lang['Adr_spells_general_explain'] = 'Ici vous pouvez modifier les réglages des sorts';
}