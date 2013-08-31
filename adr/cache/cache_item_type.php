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
		'0' => array('item_type_id' => '0', 'item_type_base_price' => '0', 'item_type_lang' => 'Adr_dont_care'),
		'1' => array('item_type_id' => '1', 'item_type_base_price' => '3', 'item_type_lang' => 'Adr_items_type_raw_materials'),
		'2' => array('item_type_id' => '2', 'item_type_base_price' => '5', 'item_type_lang' => 'Adr_items_type_rare_raw_materials'),
		'3' => array('item_type_id' => '3', 'item_type_base_price' => '100', 'item_type_lang' => 'Adr_items_type_tools_pickaxe'),
		'4' => array('item_type_id' => '4', 'item_type_base_price' => '100', 'item_type_lang' => 'Adr_items_type_tools_magictome'),
		'5' => array('item_type_id' => '5', 'item_type_base_price' => '100', 'item_type_lang' => 'Adr_items_type_weapon'),
		'6' => array('item_type_id' => '6', 'item_type_base_price' => '1000', 'item_type_lang' => 'Adr_items_type_enchanted_weapon'),
		'7' => array('item_type_id' => '7', 'item_type_base_price' => '200', 'item_type_lang' => 'Adr_items_type_armor'),
		'8' => array('item_type_id' => '8', 'item_type_base_price' => '100', 'item_type_lang' => 'Adr_items_type_buckler'),
		'9' => array('item_type_id' => '9', 'item_type_base_price' => '75', 'item_type_lang' => 'Adr_items_type_helm'),
		'10' => array('item_type_id' => '29', 'item_type_base_price' => '150', 'item_type_lang' => 'Adr_items_type_greave'),
		'11' => array('item_type_id' => '30', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_boot'),
		'12' => array('item_type_id' => '10', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_gloves'),
		'13' => array('item_type_id' => '11', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_magic_attack'),
		'14' => array('item_type_id' => '12', 'item_type_base_price' => '50', 'item_type_lang' => 'Adr_items_type_magic_defend'),
		'15' => array('item_type_id' => '13', 'item_type_base_price' => '7000', 'item_type_lang' => 'Adr_items_type_amulet'),
		'16' => array('item_type_id' => '14', 'item_type_base_price' => '6000', 'item_type_lang' => 'Adr_items_type_ring'),
		'17' => array('item_type_id' => '15', 'item_type_base_price' => '20', 'item_type_lang' => 'Adr_items_type_health_potion'),
		'18' => array('item_type_id' => '16', 'item_type_base_price' => '20', 'item_type_lang' => 'Adr_items_type_mana_potion'),
		'19' => array('item_type_id' => '17', 'item_type_base_price' => '1', 'item_type_lang' => 'Adr_items_type_misc'),
	);
?>