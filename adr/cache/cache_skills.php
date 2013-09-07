<?php
/***************************************************************************
 *						cache_skills.php
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

$adr_skills = array(
		'1' => array('skill_id' => '1', 'skill_name' => 'Adr_mining', 'skill_desc' => 'Adr_skill_mining_desc', 'skill_img' => 'skill_mining.gif', 'skill_req' => '80', 'skill_chance' => '1'),
		'2' => array('skill_id' => '2', 'skill_name' => 'Adr_stone', 'skill_desc' => 'Adr_skill_stone_desc', 'skill_img' => 'skill_stone.gif', 'skill_req' => '90', 'skill_chance' => '1'),
		'3' => array('skill_id' => '3', 'skill_name' => 'Adr_forge', 'skill_desc' => 'Adr_skill_forge_desc', 'skill_img' => 'skill_forge.gif', 'skill_req' => '35', 'skill_chance' => '1'),
		'4' => array('skill_id' => '4', 'skill_name' => 'Adr_enchantment', 'skill_desc' => 'Adr_skill_enchantment_desc', 'skill_img' => 'skill_enchantment.gif', 'skill_req' => '40', 'skill_chance' => '1'),
		'5' => array('skill_id' => '5', 'skill_name' => 'Adr_trading', 'skill_desc' => 'Adr_skill_trading_desc', 'skill_img' => 'skill_trading.gif', 'skill_req' => '125', 'skill_chance' => '1'),
		'6' => array('skill_id' => '6', 'skill_name' => 'Adr_thief', 'skill_desc' => 'Adr_skill_thief_desc', 'skill_img' => 'skill_thief.gif', 'skill_req' => '25', 'skill_chance' => '1'),
		'7' => array('skill_id' => '7', 'skill_name' => 'Adr_brewing', 'skill_desc' => 'Adr_skill_brewing_desc', 'skill_img' => 'skill_brewing.gif', 'skill_req' => '50', 'skill_chance' => '5'),
		'12' => array('skill_id' => '12', 'skill_name' => 'Adr_cooking', 'skill_desc' => 'Adr_skill_cooking_desc', 'skill_img' => 'skill_cooking.gif', 'skill_req' => '50', 'skill_chance' => '5'),
		'13' => array('skill_id' => '13', 'skill_name' => 'Adr_blacksmithing', 'skill_desc' => 'Adr_skill_blacksmithing_desc', 'skill_img' => 'skill_blacksmithing.gif', 'skill_req' => '50', 'skill_chance' => '5'),
	);
?>