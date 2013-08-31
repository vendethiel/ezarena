<?php

define('IN_PHPBB', true);
define('IN_ADR_CHARACTER', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_ADR);
init_userprefs($userdata);
//
// end session management
//

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
include($phpbb_root_path . 'adr/includes/page_header_light.'.$phpEx);
adr_template_file('adr_mini_faq_body.tpl');

$race_field = ( intval($HTTP_GET_VARS['raceid']) ) ? intval($HTTP_GET_VARS['raceid']) : 1;
$element_field = ( intval($HTTP_GET_VARS['elementid']) ) ? intval($HTTP_GET_VARS['elementid']) : 1;
$alignment_field = ( intval($HTTP_GET_VARS['alignmentid']) ) ? intval($HTTP_GET_VARS['alignmentid']) : 1;

if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);
}
else
{
	$mode = 'race';
}

switch($mode)
{
	case 'race' :

		$template->assign_block_vars('race', array());

		$sql = "SELECT * FROM " . ADR_RACES_TABLE ."
			WHERE race_id = $race_field ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Getting ADR Config!');
		}
		$infos = $db->sql_fetchrow($result);

		$pic = $infos['race_img'];
	
		$might_modif = $infos['race_might_bonus'] - $infos['race_might_malus'];
		$might = ( $might_modif =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : $might_modif;
		$might = ($might > 0 ) ? '+'.$might : $might;
		$dexterity_modif = $infos['race_dexterity_bonus'] - $infos['race_dexterity_malus'];
		$dexterity = ( $dexterity_modif =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : $dexterity_modif;
		$dexterity = ($dexterity > 0 ) ? '+'.$dexterity : $dexterity;
		$constitution_modif = $infos['race_constitution_bonus'] - $infos['race_constitution_malus'];
		$constitution = ( $constitution_modif =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : $constitution_modif;
		$constitution = ($constitution > 0 ) ? '+'.$constitution : $constitution;
		$intelligence_modif = $infos['race_intelligence_bonus'] - $infos['race_intelligence_malus'];
		$intelligence = ( $intelligence_modif =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : $intelligence_modif;
		$intelligence = ($intelligence > 0 ) ? '+'.$intelligence : $intelligence;
		$wisdom_modif = $infos['race_wisdom_bonus'] - $infos['race_wisdom_malus'];
		$wisdom = ( $wisdom_modif =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : $wisdom_modif;
		$wisdom = ($wisdom > 0 ) ? '+'.$wisdom : $wisdom;
		$charisma_modif = $infos['race_charisma_bonus'] - $infos['race_charisma_malus'];
		$charisma = ( $charisma_modif =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : $charisma_modif;
		$charisma = ($charisma > 0 ) ? '+'.$charisma : $charisma;

		$mining = ( $infos['race_skill_mining_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['race_skill_mining_bonus'];
		$stone = ( $infos['race_skill_stone_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['race_skill_stone_bonus'];
		$forge = ( $infos['race_skill_forge_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['race_skill_forge_bonus'];
		$enchant = ( $infos['race_skill_enchantment_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['race_skill_enchantment_bonus'];
		$trading = ( $infos['race_skill_trading_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['race_skill_trading_bonus'];
		$thief = ( $infos['race_skill_thief_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['race_skill_thief_bonus'];

		$template->assign_vars(array(
			"MIGHT_MODIFIER" => $might,
			"DEXT_MODIFIER" => $dexterity,
			"CONST_MODIFIER" => $constitution,
			"INT_MODIFIER" => $intelligence,
			"WIS_MODIFIER" => $wisdom,
			"CHA_MODIFIER" => $charisma,
			"B_MINING" => $mining,
			"B_STONE" => $stone,
			"B_FORGE" => $forge,
			"B_ENCHANT" => $enchant,
			"B_TRADING" => $trading,
			"B_THIEF" => $thief,
			"NAME" => adr_get_lang($infos['race_name']),
			"DESC" => adr_get_lang($infos['race_desc']),
			"IMG" => $pic ,
			
		));
	
	break;
	case 'element' :

		$template->assign_block_vars('element', array());

		$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE ."
			WHERE element_id = $element_field ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Getting ADR Config!');
		}
		$infos = $db->sql_fetchrow($result);

		$pic = $infos['element_img'];

		$mining = ( $infos['element_skill_mining_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['element_skill_mining_bonus'];
		$stone = ( $infos['element_skill_stone_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['element_skill_stone_bonus'];
		$forge = ( $infos['element_skill_forge_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['element_skill_forge_bonus'];
		$enchant = ( $infos['element_skill_enchantment_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['element_skill_enchantment_bonus'];
		$trading = ( $infos['element_skill_trading_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['element_skill_trading_bonus'];
		$thief = ( $infos['element_skill_thief_bonus'] =='0' ) ? $lang['Adr_character_characteristics_no_modifiers'] : '+'.$infos['element_skill_thief_bonus'];

		$template->assign_vars(array(
			"B_MINING" => $mining,
			"B_STONE" => $stone,
			"B_FORGE" => $forge,
			"B_ENCHANT" => $enchant,
			"B_TRADING" => $trading,
			"B_THIEF" => $thief,
			"NAME" => adr_get_lang($infos['element_name']),
			"DESC" => adr_get_lang($infos['element_desc']),
			"IMG" => $pic ,
			
		));
	
	break;

	case 'alignment' :

		$template->assign_block_vars('alignment', array());

		$sql = "SELECT * FROM " . ADR_ALIGNMENTS_TABLE ."
			WHERE alignment_id = $alignment_field ";
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Getting ADR Config!');
		}
		$infos = $db->sql_fetchrow($result);

		$pic = $infos['alignment_img'];

		$template->assign_vars(array(
			"NAME" => adr_get_lang($infos['alignment_name']),
			"DESC" => adr_get_lang($infos['alignment_desc']),
			"IMG" => $pic ,
			
		));
	
	break;

}

$template->assign_vars(array(
	"L_MIGHT_MODIFIER" => $lang['Adr_character_characteristics_might_modifiers'],
	"L_DEXT_MODIFIER" => $lang['Adr_character_characteristics_dext_modifiers'],
	"L_CONST_MODIFIER" => $lang['Adr_character_characteristics_const_modifiers'],
	"L_INT_MODIFIER" => $lang['Adr_character_characteristics_int_modifiers'],
	"L_WIS_MODIFIER" => $lang['Adr_character_characteristics_wis_modifiers'],
	"L_CHA_MODIFIER" => $lang['Adr_character_characteristics_cha_modifiers'],
	"L_B_MINING" => $lang['Adr_races_bonus_mining'],
	"L_B_STONE" => $lang['Adr_races_bonus_stone'],
	"L_B_FORGE" => $lang['Adr_races_bonus_forge'],
	"L_B_ENCHANT" => $lang['Adr_races_bonus_enchant'],
	"L_B_TRADING" => $lang['Adr_races_bonus_trading'],
	"L_B_THIEF" => $lang['Adr_races_bonus_thief'],
	"L_NAME" => $lang['Adr_races_name'],
	"L_IMG" => $lang['Adr_races_image'],
	"L_DESC" => $lang['Adr_races_desc'],
));


$template->pparse('body');

?>