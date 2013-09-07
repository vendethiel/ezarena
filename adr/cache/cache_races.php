<?php
/***************************************************************************
 *						cache_races.php
 *						-------------
 *	begin			: 15/02/2004
 *	copyright		: Ptirhiik
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}

$adr_races = array(
		'1' => array('race_id' => '1', 'race_name' => 'Adr_race_human', 'race_desc' => 'Adr_race_human_desc', 'race_level' => '0', 'race_img' => 'Human.gif', 'race_might_bonus' => '0', 'race_dexterity_bonus' => '0', 'race_constitution_bonus' => '0', 'race_intelligence_bonus' => '0', 'race_wisdom_bonus' => '0', 'race_charisma_bonus' => '0', 'race_skill_mining_bonus' => '5', 'race_skill_stone_bonus' => '5', 'race_skill_forge_bonus' => '5', 'race_skill_enchantment_bonus' => '5', 'race_skill_trading_bonus' => '5', 'race_skill_thief_bonus' => '5', 'race_might_malus' => '0', 'race_dexterity_malus' => '0', 'race_constitution_malus' => '0', 'race_intelligence_malus' => '0', 'race_wisdom_malus' => '0', 'race_charisma_malus' => '0', 'race_magic_attack_bonus' => '0', 'race_magic_resistance_bonus' => '0', 'race_magic_attack_malus' => '0', 'race_magic_resistance_malus' => '0', 'race_weight' => '1000', 'race_weight_per_level' => '5', 'race_zone_begin' => '1', 'race_zone_name' => 'Suzail', 'race_skill_brewing_bonus' => '0', 'race_skill_cooking_bonus' => '0', 'race_skill_blacksmithing_bonus' => '0', 'race_skill_alchemy_bonus' => '0', 'race_skill_fishing_bonus' => '0', 'race_skill_herbalism_bonus' => '0', 'race_skill_lumberjack_bonus' => '0', 'race_skill_tailoring_bonus' => '0', 'race_skill_hunting_bonus' => '0'),
		'2' => array('race_id' => '2', 'race_name' => 'Adr_race_half-elf', 'race_desc' => 'Adr_race_half-elf_desc', 'race_level' => '0', 'race_img' => 'Half-elf.gif', 'race_might_bonus' => '0', 'race_dexterity_bonus' => '1', 'race_constitution_bonus' => '0', 'race_intelligence_bonus' => '0', 'race_wisdom_bonus' => '0', 'race_charisma_bonus' => '1', 'race_skill_mining_bonus' => '0', 'race_skill_stone_bonus' => '5', 'race_skill_forge_bonus' => '0', 'race_skill_enchantment_bonus' => '10', 'race_skill_trading_bonus' => '5', 'race_skill_thief_bonus' => '10', 'race_might_malus' => '1', 'race_dexterity_malus' => '0', 'race_constitution_malus' => '1', 'race_intelligence_malus' => '0', 'race_wisdom_malus' => '0', 'race_charisma_malus' => '0', 'race_magic_attack_bonus' => '1', 'race_magic_resistance_bonus' => '0', 'race_magic_attack_malus' => '0', 'race_magic_resistance_malus' => '0', 'race_weight' => '900', 'race_weight_per_level' => '5', 'race_zone_begin' => '1', 'race_zone_name' => '', 'race_skill_brewing_bonus' => '0', 'race_skill_cooking_bonus' => '0', 'race_skill_blacksmithing_bonus' => '0', 'race_skill_alchemy_bonus' => '0', 'race_skill_fishing_bonus' => '0', 'race_skill_herbalism_bonus' => '0', 'race_skill_lumberjack_bonus' => '0', 'race_skill_tailoring_bonus' => '0', 'race_skill_hunting_bonus' => '0'),
		'3' => array('race_id' => '3', 'race_name' => 'Orc', 'race_desc' => 'Race Orc', 'race_level' => '0', 'race_img' => 'Half-orc.gif', 'race_might_bonus' => '2', 'race_dexterity_bonus' => '0', 'race_constitution_bonus' => '2', 'race_intelligence_bonus' => '0', 'race_wisdom_bonus' => '0', 'race_charisma_bonus' => '0', 'race_skill_mining_bonus' => '15', 'race_skill_stone_bonus' => '0', 'race_skill_forge_bonus' => '0', 'race_skill_enchantment_bonus' => '0', 'race_skill_trading_bonus' => '0', 'race_skill_thief_bonus' => '15', 'race_might_malus' => '0', 'race_dexterity_malus' => '0', 'race_constitution_malus' => '0', 'race_intelligence_malus' => '2', 'race_wisdom_malus' => '0', 'race_charisma_malus' => '2', 'race_magic_attack_bonus' => '0', 'race_magic_resistance_bonus' => '2', 'race_magic_attack_malus' => '0', 'race_magic_resistance_malus' => '0', 'race_weight' => '1500', 'race_weight_per_level' => '5', 'race_zone_begin' => '1', 'race_zone_name' => '', 'race_skill_brewing_bonus' => '0', 'race_skill_cooking_bonus' => '0', 'race_skill_blacksmithing_bonus' => '0', 'race_skill_alchemy_bonus' => '0', 'race_skill_fishing_bonus' => '0', 'race_skill_herbalism_bonus' => '0', 'race_skill_lumberjack_bonus' => '0', 'race_skill_tailoring_bonus' => '0', 'race_skill_hunting_bonus' => '0'),
		'4' => array('race_id' => '4', 'race_name' => 'Adr_race_elf', 'race_desc' => 'Adr_race_elf_desc', 'race_level' => '0', 'race_img' => 'Elf.gif', 'race_might_bonus' => '0', 'race_dexterity_bonus' => '2', 'race_constitution_bonus' => '0', 'race_intelligence_bonus' => '2', 'race_wisdom_bonus' => '0', 'race_charisma_bonus' => '0', 'race_skill_mining_bonus' => '0', 'race_skill_stone_bonus' => '0', 'race_skill_forge_bonus' => '5', 'race_skill_enchantment_bonus' => '15', 'race_skill_trading_bonus' => '10', 'race_skill_thief_bonus' => '0', 'race_might_malus' => '2', 'race_dexterity_malus' => '0', 'race_constitution_malus' => '2', 'race_intelligence_malus' => '0', 'race_wisdom_malus' => '0', 'race_charisma_malus' => '0', 'race_magic_attack_bonus' => '2', 'race_magic_resistance_bonus' => '0', 'race_magic_attack_malus' => '0', 'race_magic_resistance_malus' => '0', 'race_weight' => '800', 'race_weight_per_level' => '5', 'race_zone_begin' => '1', 'race_zone_name' => '', 'race_skill_brewing_bonus' => '0', 'race_skill_cooking_bonus' => '0', 'race_skill_blacksmithing_bonus' => '0', 'race_skill_alchemy_bonus' => '0', 'race_skill_fishing_bonus' => '0', 'race_skill_herbalism_bonus' => '0', 'race_skill_lumberjack_bonus' => '0', 'race_skill_tailoring_bonus' => '0', 'race_skill_hunting_bonus' => '0'),
	);

?>