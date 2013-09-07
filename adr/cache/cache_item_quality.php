<?php
/***************************************************************************
 *						cache_item_quality.php
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

$adr_item_quality = array(
		'0' => array('item_quality_id' => '0', 'item_quality_modifier_price' => '0', 'item_quality_lang' => 'Adr_dont_care'),
		'1' => array('item_quality_id' => '1', 'item_quality_modifier_price' => '20', 'item_quality_lang' => 'Adr_items_quality_very_poor'),
		'2' => array('item_quality_id' => '2', 'item_quality_modifier_price' => '50', 'item_quality_lang' => 'Adr_items_quality_poor'),
		'3' => array('item_quality_id' => '3', 'item_quality_modifier_price' => '100', 'item_quality_lang' => 'Adr_items_quality_medium'),
		'4' => array('item_quality_id' => '4', 'item_quality_modifier_price' => '140', 'item_quality_lang' => 'Adr_items_quality_good'),
		'5' => array('item_quality_id' => '5', 'item_quality_modifier_price' => '200', 'item_quality_lang' => 'Adr_items_quality_very_good'),
		'6' => array('item_quality_id' => '6', 'item_quality_modifier_price' => '300', 'item_quality_lang' => 'Adr_items_quality_excellent'),
	);
?>