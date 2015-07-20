<?php
/***************************************************************************
 *                                 adr_functions_admin.php
 *                            -------------------
 *   begin                : 11/02/2004
 *   copyright            : Seteo-Bloke
 *   email                : www.phpbb-adr.com
 *
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
 ***************************************************************************/

if(!defined('IN_PHPBB'))
{
	die("Hacking attempt");
}

function adr_admin_make_array($enable, $elements)
{
	global $db, $lang;

	$enable = intval($enable);

	if($enable == '1')
	{
		$count = count($elements);
		$newlist = '';
		for ($x = 0; $x < $count; $x++)
		{
			$newlist .= $elements[$x].",";
		}
	}
	else
	{
		$newlist = '0';
	}

	return $newlist;
}

function adr_get_db_stat($mode)
{
	global $db;

	switch($mode)
	{
		case 'character_count':
			$sql = "SELECT COUNT(character_id) AS total
				FROM " . ADR_CHARACTERS_TABLE;
			break;

		case 'newest_character':
			$sql = "SELECT character_id, character_name
				FROM " . ADR_CHARACTERS_TABLE . "
				ORDER BY character_id DESC
				LIMIT 1";
			break;

		case 'pvp_battle_count':
			$sql = "SELECT COUNT(battle_id) AS battle_pvp_total
				FROM " . ADR_BATTLE_PVP_TABLE;
			break;

		case 'monster_battle_count':
			$sql = "SELECT COUNT(battle_id) AS battle_total
				FROM " . ADR_BATTLE_LIST_TABLE;
			break;
	}

	if(!($result = $db->sql_query($sql)))
	{
		return false;
	}

	$row = $db->sql_fetchrow($result);

	switch($mode)
	{
		case 'character_count':
			return number_format($row['total']);
			break;
		case 'newest_character':
			return $row;
			break;
		case 'pvp_battle_count':
			return number_format($row['battle_pvp_total']);
			break;
		case 'monster_battle_count':
			return number_format($row['battle_total']);
			break;
	}

	return FALSE;
}

function adr_admin_get_item_use_name($type_use_id)
{
	global $db, $lang;

	// Fix the values
	$type_use_id = intval($type_use_id);

	$sql = "SELECT item_type_lang FROM ". ADR_SHOPS_ITEMS_TYPE_TABLE ."
		WHERE item_type_id = '$type_use_id'";
	$result = $db->sql_query($sql);
	if(!$result){
		message_die(GENERAL_ERROR, 'Could not obtain raw material type info', "", __LINE__, __FILE__, $sql);}
	$row = $db->sql_fetchrow($result);

return adr_get_lang($row['item_type_lang']);
}

?>
