<?php
/***************************************************************************
 *						cache_item_type.php
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

$adr_item_type = array(
		'0' => array('item_type_id' => '110', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_spell_recipe', 'item_type_order' => '1', 'item_type_category' => ''),
		'1' => array('item_type_id' => '37', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_tools_woodworking', 'item_type_order' => '1', 'item_type_category' => ''),
		'2' => array('item_type_id' => '36', 'item_type_base_price' => '150', 'item_type_lang' => 'Adr_items_type_animals', 'item_type_order' => '1', 'item_type_category' => ''),
		'3' => array('item_type_id' => '35', 'item_type_base_price' => '517', 'item_type_lang' => 'Adr_items_type_alchemy', 'item_type_order' => '1', 'item_type_category' => ''),
		'4' => array('item_type_id' => '34', 'item_type_base_price' => '17', 'item_type_lang' => 'Adr_items_type_tools_alchemy', 'item_type_order' => '1', 'item_type_category' => ''),
		'5' => array('item_type_id' => '33', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_fish', 'item_type_order' => '1', 'item_type_category' => ''),
		'6' => array('item_type_id' => '32', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_tools_pole', 'item_type_order' => '1', 'item_type_category' => ''),
		'7' => array('item_type_id' => '31', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_wood', 'item_type_order' => '1', 'item_type_category' => ''),
		'8' => array('item_type_id' => '30', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_boot', 'item_type_order' => '1', 'item_type_category' => ''),
		'9' => array('item_type_id' => '29', 'item_type_base_price' => '150', 'item_type_lang' => 'Adr_items_type_greave', 'item_type_order' => '1', 'item_type_category' => ''),
		'10' => array('item_type_id' => '28', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_tools_hunting', 'item_type_order' => '1', 'item_type_category' => ''),
		'11' => array('item_type_id' => '40', 'item_type_base_price' => '2000', 'item_type_lang' => 'Adr_items_type_staff', 'item_type_order' => '1', 'item_type_category' => ''),
		'12' => array('item_type_id' => '41', 'item_type_base_price' => '2000', 'item_type_lang' => 'Adr_items_type_dirk', 'item_type_order' => '1', 'item_type_category' => ''),
		'13' => array('item_type_id' => '42', 'item_type_base_price' => '2000', 'item_type_lang' => 'Adr_items_type_mace', 'item_type_order' => '1', 'item_type_category' => ''),
		'14' => array('item_type_id' => '109', 'item_type_base_price' => '1', 'item_type_lang' => 'Adr_items_type_magic_defend', 'item_type_order' => '1', 'item_type_category' => ''),
		'15' => array('item_type_id' => '108', 'item_type_base_price' => '1', 'item_type_lang' => 'Adr_items_type_magic_heal', 'item_type_order' => '1', 'item_type_category' => ''),
		'16' => array('item_type_id' => '107', 'item_type_base_price' => '1', 'item_type_lang' => 'Adr_items_type_magic_attack', 'item_type_order' => '1', 'item_type_category' => ''),
		'17' => array('item_type_id' => '95', 'item_type_base_price' => '100', 'item_type_lang' => 'Adr_items_type_tools_blacksmithing', 'item_type_order' => '1', 'item_type_category' => ''),
		'18' => array('item_type_id' => '94', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_food', 'item_type_order' => '1', 'item_type_category' => ''),
		'19' => array('item_type_id' => '55', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_tools_cooking', 'item_type_order' => '1', 'item_type_category' => ''),
		'20' => array('item_type_id' => '46', 'item_type_base_price' => '2000', 'item_type_lang' => 'Adr_items_type_spear', 'item_type_order' => '1', 'item_type_category' => ''),
		'21' => array('item_type_id' => '45', 'item_type_base_price' => '2000', 'item_type_lang' => 'Adr_items_type_axe', 'item_type_order' => '1', 'item_type_category' => ''),
		'22' => array('item_type_id' => '44', 'item_type_base_price' => '2000', 'item_type_lang' => 'Adr_items_type_fist', 'item_type_order' => '1', 'item_type_category' => ''),
		'23' => array('item_type_id' => '43', 'item_type_base_price' => '2000', 'item_type_lang' => 'Adr_items_type_ranged', 'item_type_order' => '1', 'item_type_category' => ''),
		'24' => array('item_type_id' => '27', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_water', 'item_type_order' => '1', 'item_type_category' => ''),
		'25' => array('item_type_id' => '26', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_plants', 'item_type_order' => '1', 'item_type_category' => ''),
		'26' => array('item_type_id' => '25', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_tools_seed', 'item_type_order' => '1', 'item_type_category' => ''),
		'27' => array('item_type_id' => '10', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_gloves', 'item_type_order' => '1', 'item_type_category' => ''),
		'28' => array('item_type_id' => '9', 'item_type_base_price' => '75', 'item_type_lang' => 'Adr_items_type_helm', 'item_type_order' => '1', 'item_type_category' => ''),
		'29' => array('item_type_id' => '8', 'item_type_base_price' => '100', 'item_type_lang' => 'Adr_items_type_buckler', 'item_type_order' => '1', 'item_type_category' => ''),
		'30' => array('item_type_id' => '7', 'item_type_base_price' => '200', 'item_type_lang' => 'Adr_items_type_armor', 'item_type_order' => '1', 'item_type_category' => ''),
		'31' => array('item_type_id' => '6', 'item_type_base_price' => '1000', 'item_type_lang' => 'Adr_items_type_enchanted_weapon', 'item_type_order' => '1', 'item_type_category' => ''),
		'32' => array('item_type_id' => '5', 'item_type_base_price' => '100', 'item_type_lang' => 'Adr_items_type_weapon', 'item_type_order' => '1', 'item_type_category' => ''),
		'33' => array('item_type_id' => '4', 'item_type_base_price' => '100', 'item_type_lang' => 'Adr_items_type_tools_magictome', 'item_type_order' => '1', 'item_type_category' => ''),
		'34' => array('item_type_id' => '3', 'item_type_base_price' => '100', 'item_type_lang' => 'Adr_items_type_tools_pickaxe', 'item_type_order' => '1', 'item_type_category' => ''),
		'35' => array('item_type_id' => '2', 'item_type_base_price' => '5', 'item_type_lang' => 'Adr_items_type_rare_raw_materials', 'item_type_order' => '1', 'item_type_category' => ''),
		'36' => array('item_type_id' => '1', 'item_type_base_price' => '3', 'item_type_lang' => 'Adr_items_type_raw_materials', 'item_type_order' => '1', 'item_type_category' => ''),
		'37' => array('item_type_id' => '11', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_magic_attack', 'item_type_order' => '1', 'item_type_category' => ''),
		'38' => array('item_type_id' => '12', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_magic_defend', 'item_type_order' => '1', 'item_type_category' => ''),
		'39' => array('item_type_id' => '13', 'item_type_base_price' => '7000', 'item_type_lang' => 'Adr_items_type_amulet', 'item_type_order' => '1', 'item_type_category' => ''),
		'40' => array('item_type_id' => '24', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_thread', 'item_type_order' => '1', 'item_type_category' => ''),
		'41' => array('item_type_id' => '23', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_clothes', 'item_type_order' => '1', 'item_type_category' => ''),
		'42' => array('item_type_id' => '22', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_tools_needle', 'item_type_order' => '1', 'item_type_category' => ''),
		'43' => array('item_type_id' => '20', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_recipe', 'item_type_order' => '1', 'item_type_category' => ''),
		'44' => array('item_type_id' => '19', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_potion', 'item_type_order' => '1', 'item_type_category' => ''),
		'45' => array('item_type_id' => '18', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_tools_brewing', 'item_type_order' => '1', 'item_type_category' => ''),
		'46' => array('item_type_id' => '17', 'item_type_base_price' => '1', 'item_type_lang' => 'Adr_items_type_misc', 'item_type_order' => '1', 'item_type_category' => ''),
		'47' => array('item_type_id' => '16', 'item_type_base_price' => '20', 'item_type_lang' => 'Adr_items_type_mana_potion', 'item_type_order' => '1', 'item_type_category' => ''),
		'48' => array('item_type_id' => '15', 'item_type_base_price' => '20', 'item_type_lang' => 'Adr_items_type_health_potion', 'item_type_order' => '1', 'item_type_category' => ''),
		'49' => array('item_type_id' => '14', 'item_type_base_price' => '6000', 'item_type_lang' => 'Adr_items_type_ring', 'item_type_order' => '1', 'item_type_category' => ''),
		'50' => array('item_type_id' => '0', 'item_type_base_price' => '0', 'item_type_lang' => 'Adr_dont_care', 'item_type_order' => '1', 'item_type_category' => ''),
	);
?>