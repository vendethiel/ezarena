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
$lang['Adr_spells_wrong_class'] = 'Cette classe ne peut pas apprendre ce sort';
$lang['Adr_spells_wrong_alignment'] = 'You are of the wrong alignment to learn this spell';
$lang['Adr_spells_wrong_element'] = 'You are of the wrong element to learn this spell';
$lang['Adr_spells_skill_evocation'] = 'Evocation';
$lang['Adr_spells_skill_healing'] = 'Healing';
$lang['Adr_spells_skill_abjuration'] = 'Abjuration';
$lang['Adr_spells_successful_added'] = 'You successfully learned this spell';
$lang['Adr_spells_learn_link'] = 'Learn Spell';
$lang['Adr_items_type_spell_recipe'] = 'Parchemin de sort';
$lang['Adr_spells_was_deleted'] = 'This spell has been deleted';
$lang['Adr_spells_missing_item'] = 'You don\'t have the required components to cast this spell';

//Casting messages
$lang['Adr_spells_cast'] = 'Cast Spell';
$lang['Adr_spells_cast_mp'] = 'You have %s MP';
$lang['Adr_spells_target_select'] = 'Select a character to cast upon:';
$lang['Adr_spells_target_battle'] = 'This user is currently in battle and cannot have spells cast upon them at the moment';
$lang['Adr_spells_target_dead'] = 'This character is dead. They cannot have spells cast upon them';
$lang['Adr_spells_target_health_full'] = 'This character is already at full health';
$lang['Adr_spells_heal_cast'] = 'You have cast <i>%s</i> upon %s replenishing %s points of health!';
$lang['Adr_spells_heal_pm_title'] = 'You have been healed by another user';
$lang['Adr_spells_heal_pm_text'] = 'You have been healed by %s for %s points of health!';
$lang['Adr_spells_cast_already'] = '%s already has a spell cast upon them';
$lang['Adr_spells_cast_boost_success'] = 'You have cast <i>%s</i> upon %s boosting their attack and defense for their next battle';
$lang['Adr_lang_cast_boost_pm_title'] = 'You have had a spell cast upon you';
$lang['Adr_lang_cast_boost_pm_text'] = '%s has cast <i>%s</i> upon you, increasing your attack and defense stats for your next battle';
$lang['Adr_spells_wrong_place'] = 'You need to be in the same zone as your target to cast spells upon them';

//Battle messages
$lang['Adr_battle_spell_ma_increase'] = '%s casts %s increasing your magic attack by %s points!.';
$lang['Adr_battle_spell_md_increase'] = '%s casts %s increasing your magic defence by %s points!.';
$lang['Adr_battle_spell_pa_increase'] = '%s casts %s increasing your physical attack by %s points!.';
$lang['Adr_battle_spell_pd_increase'] = '%s casts %s increasing your physical defence by %s points!.';	
$lang['Adr_battle_spell_mamd_increase'] = '%s casts %s increasing your magical attack and defense by %s points!.';
$lang['Adr_battle_spell_pama_increase'] = '%s casts %s increasing your physical attack and magical attack by %s points!.';
$lang['Adr_battle_spell_pdmd_increase'] = '%s casts %s increasing your physical defense and magical defense by %s points!.';
$lang['Adr_battle_spell_papdmamd_increase'] = '%s casts %s increasing your physical attack and defense and magical attack and defense by %s points!.';
	$lang['Adr_battle_spell_hpmana'] = '%s casts %s trading hit points for mana point, increasing your mana points by %s points!.';
$lang['Adr_battle_spell_monster_pa_decrease'] = '%s casts %s on %s, lowering their melee attack by %s';
$lang['Adr_battle_spell_monster_pa_decrease_fail'] = '%s casts %s on %s, but their melee attack is already 0';
$lang['Adr_battle_spell_monster_pd_decrease'] = '%s casts %s on %s, lowering their melee defense by %s';
$lang['Adr_battle_spell_monster_pd_decrease_fail'] = '%s casts %s on %s, but their melee defense is already 0';
$lang['Adr_battle_spell_monster_ma_decrease'] = '%s casts %s on %s, lowering their magic attack by %s';
$lang['Adr_battle_spell_monster_ma_decrease_fail'] = '%s casts %s on %s, but their magic attack is already 0';
$lang['Adr_battle_spell_monster_md_decrease'] = '%s casts %s on %s, lowering their magic resistance by %s';
$lang['Adr_battle_spell_monster_md_decrease_fail'] = '%s casts %s on %s, but their magic resistance is already 0';
$lang['Adr_battle_spell_disease_cure'] = '%s casts %s curing yourself of %s';
$lang['Adr_battle_spell_disease_no_cure'] = '%s casts %s but this spell will not cure the disease you have';
$lang['Adr_battle_spell_no_disease'] = '%s casts %s but you have no disease';

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

	$lang['Adr_spells_attention'] = 'ATTENTION. Deleting a Spell will remove it from players learned spell lists.';
	$lang['Adr_spells_level_explain'] = 'The level a character needs to be to learn this spell';
	$lang['Adr_spells_auth'] = 'Level Up Restrict';
	$lang['Adr_spells_auth_explain'] = 'By clicking here, this spell will not be learned by players on level up.';
	$lang['Adr_spells_item_recipe'] = 'Spell Recipe';
	$lang['Adr_spells_item_recipe_explain'] = 'If you want an already created item to be used to learn this spell, select it here. Otherwise, select \'None\'.';
	$lang['Adr_spells_recipe_none'] = 'No Recipe';
	$lang['Adr_spells_items_req'] = 'Spell Components';
	$lang['Adr_spells_items_req_desc'] = 'Select items that are required to cast this spell. If none, select \'None\'';
	$lang['Adr_spells_items_amount'] = 'Amount of each selected item that is needed to cast the spell';
	$lang['Adr_spells_items_amount_desc'] = 'Example: If selected 3 items and I want for the first one 2, second one 1 and the third one 5, then this field should look like 2:1:5. First item is the one that is selected and on top of all selected items !<br /><br />Leave blank if not more than 1 of each item is needed to cook this food (default 1 for each selected item)';
	$lang['Adr_spells_components'] = 'Spell Components';
	$lang['Adr_spells_battle'] = 'Spell Can be Cast In';
	$lang['Adr_spells_battle_explain'] = 'Choose \'Out of Battle\' if the spell can only be cast out of battle, \'In Battle\' if the spell can be cast in monster and PvP battle, but not out of it, or \'Both\' if the spell can be cast in both.';
	$lang['Adr_spells_xtreme'] = 'Custom Spell Code';
	$lang['Adr_spells_xtreme_explain'] = 'Code that is executed when the spell is cast when not in battle, instead of the default spell code. Use PHP/MySQL code. If you don\'t know what this is, leave it blank.';
	$lang['Adr_spells_xtreme_battle'] = 'Custom Spell Battle Code';
	$lang['Adr_spells_xtreme_battle_explain'] = 'Code that is executed when the spell is cast when in battle, instead of the default spell code. Use PHP/MySQL code. If you don\'t know what this is, leave it blank.';
	$lang['Adr_spells_xtreme_pvp'] = 'Custom Spell PvP Code';
	$lang['Adr_spells_xtreme_pvp_explain'] = 'Code that is executed when the spell is cast when in PvP, instead of the default spell code. Use PHP/MySQL code. If you don\'t know what this is, leave it blank.';
	$lang['Adr_spells_no_battle'] = 'Out of Battle';
	$lang['Adr_spells_battle'] = 'In Battle';
	$lang['Adr_spells_battle_no_battle'] = 'Both';
	$lang['Adr_spells_admin_only'] = 'Admin Only?';
	$lang['Adr_spells_spell_successful_deleted'] = 'Spell successfully deleted';
	$lang['Adr_spells_spell_successful_edited'] = 'Spell successfully edited';
	$lang['Adr_spells_spell_successful_added'] = 'Spell successfully added';
	$lang['Adr_spells_spell_add'] = 'Add a spell';
	$lang['Adr_spells_spell_name'] = 'Spell Name';
	$lang['Adr_spells_skill'] = 'Spell Skill';
	$lang['Adr_spells_alignment_limit'] = 'Alignment Limit';
	$lang['Adr_spells_alignment_limit_explain'] = 'Select the alignments you wish this spell to be useable by. For all alignments, sellect \'All\'. Use CTRL + Click to select multiple alignments.';
	$lang['Adr_spells_element_limit'] = 'Element Limit';
	$lang['Adr_spells_element_limit_explain'] = 'Select the elements you wish this spell to be useable by. For all elements, sellect \'All\'. Use CTRL + Click to select multiple elements.';
	$lang['Adr_spells_give_spell_success'] = 'Spell(s) successfully given';
	$lang['Adr_spells_general_change_successful'] = 'Spell settings successfully changed';
	$lang['Adr_spells_pm'] = 'Send PMs';
	$lang['Adr_spells_pm_explain'] = 'Setting this to Yes will mean a player will be sent a PM if they have a spell cast upon them. This applies to casting spells out of battle.';
	$lang['Adr_spells_general_title'] = 'Spell Settings';
	$lang['Adr_spells_general_explain'] = 'Here you can change any global spell settings';
}

?>