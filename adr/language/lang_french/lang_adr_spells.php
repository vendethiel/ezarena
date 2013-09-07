<?php 
/*************************************************************************** 
* 			lang_adr_spells.php [English] 
* 				------------------- 
*				begin: 01/07/2007
*				copyright: egdcltd (http://games.directorygold.com)
****************************************************************************/ 

if ( defined ('IN_ADR_CHARACTER'))
{
	$lang['Adr_spells_page_name'] = 'Sorts';
	$lang['Adr_battle_check_two'] = 'Vous n\'avez pas assez de mana pour lancer ce sort';
	$lang['Adr_battle_healing_success'] = '%s lance %s, se rendant %s HP !';
	$lang['Adr_battle_no_spell_learned'] = 'Pas de sort';
	$lang['Adr_spell_learned'] = 'Lancer un sort';
    $lang['Adr_items_class_limit'] = 'Classes autorisées';
	$lang['Adr_items_type_magic_heal'] = 'Sort de soin';
	$lang['Adr_spell_not_learned'] = 'Vous n\'avez pas appris de sort';
	$lang['Adr_spell_learned'] = 'Vous avez appris %s';
}

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
}