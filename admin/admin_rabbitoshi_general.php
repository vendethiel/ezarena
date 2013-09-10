<?php
/***************************************************************************
 *                          admin_rabbitoshi_general.php
 *                              -------------------
 *     begin                : Thurs June 9 2006
 *     copyright            : (C) 2006 The ADR Dev Crew
 *     site                 : http://www.adr-support.com
 *
 *     $Id: admin_rabbitoshi_general.php,v 4.00.0.00 2006/06/09 02:32:18 Ethalic Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Rabbitoshi']['Rabbitoshi_settings'] = $file;
	return;
}

$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require("./pagestart.$phpEx");
include($phpbb_root_path.'rabbitoshi/includes/functions_rabbitoshi.'.$phpEx);

rabbitoshi_template_file('admin/config_rabbitoshi_general_body.tpl');

$submit = isset($HTTP_POST_VARS['submit']); 

$sql = "SELECT *
FROM " . RABBITOSHI_GENERAL_TABLE ;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
}
while( $row = $db->sql_fetchrow($result) )
{
	$rabitoshi[$row['config_name']] = $row['config_value'];
}

$template->assign_vars(array(
	'RABBITOSHI_NAME' => $board_config['rabbitoshi_name'],
	'RABBITOSHI_USE_CHECKED' => ( $board_config['rabbitoshi_enable'] ? 'CHECKED' :'' ),
	'RABBITOSHI_USE_CRON_CHECKED' => ( $board_config['rabbitoshi_enable_cron'] ? 'CHECKED' :'' ),
	'RABBITOSHI_CRON_TIME' => $board_config['rabbitoshi_cron_time'],
	'RABBITOSHI_CRON_TIME_EXPLAIN' => rabbitoshi_make_time($board_config['rabbitoshi_cron_time']),
	'RABBITOSHI_THIRST_TIME' => $rabitoshi['thirst_time'],
	'RABBITOSHI_THIRST_TIME_EXPLAIN' => rabbitoshi_make_time($rabitoshi['thirst_time']),
	'RABBITOSHI_THIRST_VALUE' => $rabitoshi['thirst_value'],
	'RABBITOSHI_HUNGER_TIME' => $rabitoshi['hunger_time'],
	'RABBITOSHI_HUNGER_TIME_EXPLAIN' => rabbitoshi_make_time($rabitoshi['hunger_time']),
	'RABBITOSHI_HUNGER_VALUE' => $rabitoshi['hunger_value'],
	'RABBITOSHI_HEALTH_TIME' => $rabitoshi['health_time'],
	'RABBITOSHI_HEALTH_TIME_EXPLAIN' => rabbitoshi_make_time($rabitoshi['health_time']),
	'RABBITOSHI_HEALTH_VALUE' => $rabitoshi['health_value'],
	'RABBITOSHI_HYGIENE_TIME' => $rabitoshi['hygiene_time'],
	'RABBITOSHI_HYGIENE_TIME_EXPLAIN' => rabbitoshi_make_time($rabitoshi['hygiene_time']),
	'RABBITOSHI_HYGIENE_VALUE' => $rabitoshi['hygiene_value'],
	'RABBITOSHI_REBIRTH_CHECKED' => ( $rabitoshi['rebirth_enable'] ? 'CHECKED' :'' ),
	'RABBITOSHI_REBIRTH_PRICE' => $rabitoshi['rebirth_price'],
	'RABBITOSHI_VET_CHECKED' => ( $rabitoshi['vet_enable'] ? 'CHECKED' :'' ),
	'RABBITOSHI_VET_PRICE' => $rabitoshi['vet_price'],
	'RABBITOSHI_HOTEL_CHECKED' => ( $rabitoshi['hotel_enable'] ? 'CHECKED' :'' ),
	'RABBITOSHI_HOTEL_PRICE' => $rabitoshi['hotel_cost'],
	'RABBITOSHI_HOTEL_EXP' => $rabitoshi['exp_lose'],
	'RABBITOSHI_HEALTH_PRICE' => $rabitoshi['health_price'],
	'RABBITOSHI_HUNGER_PRICE' => $rabitoshi['hunger_price'],
	'RABBITOSHI_THIRST_PRICE' => $rabitoshi['thirst_price'],
	'RABBITOSHI_HYGIENE_PRICE' => $rabitoshi['hygiene_price'],
	'RABBITOSHI_LEVEL_PRICE' => $rabitoshi['level_price'],
	'RABBITOSHI_POWER_PRICE' => $rabitoshi['power_price'],
	'RABBITOSHI_MAGICPOWER_PRICE' => $rabitoshi['magicpower_price'],
	'RABBITOSHI_ARMOR_PRICE' => $rabitoshi['armor_price'],
	'RABBITOSHI_ATTACK_PRICE' => $rabitoshi['attack_price'],
	'RABBITOSHI_MAGICATTACK_PRICE' => $rabitoshi['magicattack_price'],
	'RABBITOSHI_MP_PRICE' => $rabitoshi['mp_price'],
	'RABBITOSHI_HEALTH_RAISE' => $rabitoshi['health_raise'],
	'RABBITOSHI_HUNGER_RAISE' => $rabitoshi['hunger_raise'],
	'RABBITOSHI_THIRST_RAISE' => $rabitoshi['thirst_raise'],
	'RABBITOSHI_HYGIENE_RAISE' => $rabitoshi['hygiene_raise'],
	'RABBITOSHI_POWER_RAISE' => $rabitoshi['power_raise'],
	'RABBITOSHI_MAGICPOWER_RAISE' => $rabitoshi['magicpower_raise'],
	'RABBITOSHI_ARMOR_RAISE' => $rabitoshi['armor_raise'],
	'RABBITOSHI_ATTACK_RAISE' => $rabitoshi['attack_raise'],
	'RABBITOSHI_MAGICATTACK_RAISE' => $rabitoshi['magicattack_raise'],
	'RABBITOSHI_ATTACK_RELOAD_PRICE' => $rabitoshi['attack_reload'],
	'RABBITOSHI_MAGIC_RELOAD_PRICE' => $rabitoshi['magic_reload'],
	'RABBITOSHI_MP_RAISE' => $rabitoshi['mp_raise'],
	'RABBITOSHI_EXPERIENCE_MIN' => $rabitoshi['experience_min'],
	'RABBITOSHI_EXPERIENCE_MAX' => $rabitoshi['experience_max'],
	'RABBITOSHI_MP_MIN' => $rabitoshi['mp_min'],
	'RABBITOSHI_MP_MAX' => $rabitoshi['mp_max'],
	'RABBITOSHI_EVOLUTION_CHECKED' => ( $rabitoshi['evolution_enable'] ? 'CHECKED' :'' ),
	'RABBITOSHI_EVOLUTION_PRICE' => $rabitoshi['evolution_cost'],
	'RABBITOSHI_EVOLUTION_TIME' => $rabitoshi['evolution_time'],
	'RABBITOSHI_LEVEL_UP_PENALTY' => $rabitoshi['next_level_penalty'],
));

if ( $submit )
{
	$use = intval ( $HTTP_POST_VARS['use']);
	$rebirth = intval ( $HTTP_POST_VARS['rebirth']);
	$vet = intval ( $HTTP_POST_VARS['vet']);
	$hotel = intval ( $HTTP_POST_VARS['hotel']);
	$evolution = intval ( $HTTP_POST_VARS['evolution']);
	$name = $HTTP_POST_VARS['name'];
	$hunger_time = $HTTP_POST_VARS['hunger_time'];
	$hunger_value = $HTTP_POST_VARS['hunger_value'];
	$thirst_time = $HTTP_POST_VARS['thirst_time'];
	$thirst_value = $HTTP_POST_VARS['thirst_value'];
	$health_time = $HTTP_POST_VARS['health_time'];
	$health_value = $HTTP_POST_VARS['health_value'];
	$hygiene_time = $HTTP_POST_VARS['hygiene_time'];
	$hygiene_value = $HTTP_POST_VARS['hygiene_value'];
	$rebirth_price = $HTTP_POST_VARS['rebirth_price'];
	$vet_price = $HTTP_POST_VARS['vet_price'];
	$hotel_price = $HTTP_POST_VARS['hotel_price'];
	$hotel_exp = $HTTP_POST_VARS['exp_lose'];
	$evolution_price = $HTTP_POST_VARS['evolution_price'];
	$evolution_time = $HTTP_POST_VARS['evolution_time'];
	$use_cron = intval ( $HTTP_POST_VARS['use_cron']);
	$cron_time = $HTTP_POST_VARS['cron_time'];
	$health_price = $HTTP_POST_VARS['health_price'];
	$hunger_price = $HTTP_POST_VARS['hunger_price'];
	$thirst_price = $HTTP_POST_VARS['thirst_price'];
	$hygiene_price = $HTTP_POST_VARS['hygiene_price'];
	$level_price = $HTTP_POST_VARS['level_price'];
	$power_price = $HTTP_POST_VARS['power_price'];
	$magicpower_price = $HTTP_POST_VARS['magicpower_price'];
	$armor_price = $HTTP_POST_VARS['armor_price'];
	$attack_price = $HTTP_POST_VARS['attack_price'];
	$magicattack_price = $HTTP_POST_VARS['magicattack_price'];
	$mp_price = $HTTP_POST_VARS['mp_price'];
	$health_raise = $HTTP_POST_VARS['health_raise'];
	$hunger_raise = $HTTP_POST_VARS['hunger_raise'];
	$thirst_raise = $HTTP_POST_VARS['thirst_raise'];
	$hygiene_raise = $HTTP_POST_VARS['hygiene_raise'];
	$power_raise = $HTTP_POST_VARS['power_raise'];
	$magicpower_raise = $HTTP_POST_VARS['magicpower_raise'];
	$armor_raise = $HTTP_POST_VARS['armor_raise'];
	$attack_raise = $HTTP_POST_VARS['attack_raise'];
	$magicattack_raise = $HTTP_POST_VARS['magicattack_raise'];
	$mp_raise = $HTTP_POST_VARS['mp_raise'];
	$experience_min = $HTTP_POST_VARS['experience_min'];
	$experience_max = $HTTP_POST_VARS['experience_max'];
	$mp_min = $HTTP_POST_VARS['mp_min'];
	$mp_max = $HTTP_POST_VARS['mp_max'];
	$attack_reload = $HTTP_POST_VARS['attack_reload'];
	$magic_reload = $HTTP_POST_VARS['magic_reload'];
	$level_up_penalty = $HTTP_POST_VARS['level_up_penalty'];

	// V: could use class_common
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$magic_reload' WHERE config_name = 'magic_reload' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$attack_reload' WHERE config_name = 'attack_reload' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$level_up_penalty' WHERE config_name = 'next_level_penalty' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$mp_min' WHERE config_name = 'mp_min' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$mp_max' WHERE config_name = 'mp_max' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$experience_min' WHERE config_name = 'experience_min' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$experience_max' WHERE config_name = 'experience_max' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$health_raise' WHERE config_name = 'health_raise' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hunger_raise' WHERE config_name = 'hunger_raise' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$thirst_raise' WHERE config_name = 'thirst_raise' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hygiene_raise' WHERE config_name = 'hygiene_raise' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$power_raise' WHERE config_name = 'power_raise' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$magicpower_raise' WHERE config_name = 'magicpower_raise' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$armor_raise' WHERE config_name = 'armor_raise' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$attack_raise' WHERE config_name = 'attack_raise' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$magicattack_raise' WHERE config_name = 'magicattack_raise' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$mp_raise' WHERE config_name = 'mp_raise' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$health_price' WHERE config_name = 'health_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hunger_price' WHERE config_name = 'hunger_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$thirst_price' WHERE config_name = 'thirst_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hygiene_price' WHERE config_name = 'hygiene_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$level_price' WHERE config_name = 'level_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$power_price' WHERE config_name = 'power_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$magicpower_price' WHERE config_name = 'magicpower_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$armor_price' WHERE config_name = 'armor_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$attack_price' WHERE config_name = 'attack_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$magicattack_price' WHERE config_name = 'magicattack_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$mp_price' WHERE config_name = 'mp_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$use' WHERE config_name = 'rabbitoshi_enable' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$name' WHERE config_name = 'rabbitoshi_name' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$use_cron' WHERE config_name = 'rabbitoshi_enable_cron' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$cron_time' WHERE config_name = 'rabbitoshi_cron_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hunger_time' WHERE config_name = 'hunger_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hunger_value' WHERE config_name = 'hunger_value' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$thirst_time' WHERE config_name = 'thirst_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$thirst_value' WHERE config_name = 'thirst_value' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$health_time' WHERE config_name = 'health_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$health_value' WHERE config_name = 'health_value' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hygiene_time' WHERE config_name = 'hygiene_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 	
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hygiene_value' WHERE config_name = 'hygiene_value' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$rebirth' WHERE config_name = 'rebirth_enable' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 	
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$rebirth_price' WHERE config_name = 'rebirth_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$vet' WHERE config_name = 'vet_enable' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 	
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$vet_price' WHERE config_name = 'vet_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hotel' WHERE config_name = 'hotel_enable' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hotel_price' WHERE config_name = 'hotel_cost' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hotel_exp' WHERE config_name = 'exp_lose' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$evolution' WHERE config_name = 'evolution_enable' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$evolution_price' WHERE config_name = 'evolution_cost' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$evolution_time' WHERE config_name = 'evolution_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	message_die(GENERAL_MESSAGE, sprintf($lang['Rabbitoshi_updated_return_settings'], '<a href="' . append_sid(basename(__FILE__)) . '">', '</a>'), $lang['Rabbitoshi_settings']);
}

$template->assign_vars(array(
	'L_RABBITOSHI_SETTINGS' => $lang['Rabbitoshi_settings'],
	'L_RABBITOSHI_SETTINGS_EXPLAIN' => $lang['Rabbitoshi_settings_explain'],
	'L_RABBITOSHI_USE' => $lang['Rabbitoshi_use'],
	'L_RABBITOSHI_NAME' => $lang['Rabbitoshi_settings_name'],
	'L_RABBITOSHI_REBIRTH' => $lang['Rabbitoshi_rebirth_enable'],
	'L_RABBITOSHI_REBIRTH_PRICE' => $lang['Rabbitoshi_rebirth_price'],
	'L_RABBITOSHI_REBIRTH_EXPLAIN' => $lang['Rabbitoshi_rebirth_enable_explain'],
	'L_RABBITOSHI_VET' => $lang['Rabbitoshi_vet_enable'],
	'L_RABBITOSHI_VET_PRICE' => $lang['Rabbitoshi_vet_price'],
	'L_RABBITOSHI_VET_EXPLAIN' => $lang['Rabbitoshi_rebirth_vet_explain'],
	'L_RABBITOSHI_HOTEL_USE' => $lang['Rabbitoshi_hotel_use'],
	'L_RABBITOSHI_HOTEL_USE_EXPLAIN' => $lang['Rabbitoshi_hotel_use_explain'],
	'L_RABBITOSHI_HOTEL_PRICE' => $lang['Rabbitoshi_hotel_price'],
	'L_RABBITOSHI_HOTEL_PRICE_EXPLAIN' => $lang['Rabbitoshi_hotel_price_explain'],
	'L_RABBITOSHI_HOTEL_EXP' => $lang['Rabbitoshi_hotel_exp'],
	'L_RABBITOSHI_HOTEL_EXP_EXPLAIN' => $lang['Rabbitoshi_hotel_exp_explain'],
	'L_RABBITOSHI_EVOLUTION_USE' => $lang['Rabbitoshi_evolution_use'],
	'L_RABBITOSHI_EVOLUTION_USE_EXPLAIN' => $lang['Rabbitoshi_evolution_use_explain'],
	'L_RABBITOSHI_EVOLUTION_PRICE' => $lang['Rabbitoshi_evolution_price'],
	'L_RABBITOSHI_EVOLUTION_PRICE_EXPLAIN' => $lang['Rabbitoshi_evolution_price_explain'],
	'L_RABBITOSHI_EVOLUTION_TIME' => $lang['Rabbitoshi_evolution_time'],
	'L_RABBITOSHI_EVOLUTION_TIME_EXPLAIN' => $lang['Rabbitoshi_evolution_time_explain'],
	'L_RABBITOSHI_HUNGER_TIME' => $lang['Rabbitoshi_hunger_time'],
	'L_RABBITOSHI_HUNGER_VALUE' => $lang['Rabbitoshi_hunger_value'],
	'L_RABBITOSHI_THIRST_TIME' => $lang['Rabbitoshi_thirst_time'],
	'L_RABBITOSHI_THIRST_VALUE' => $lang['Rabbitoshi_thirst_value'],
	'L_RABBITOSHI_HEALTH_TIME' => $lang['Rabbitoshi_health_time'],
	'L_RABBITOSHI_HEALTH_EXPLAIN' => $lang['Rabbitoshi_health_explain'],
	'L_RABBITOSHI_HEALTH_VALUE' => $lang['Rabbitoshi_health_value'],
	'L_RABBITOSHI_HYGIENE_TIME' => $lang['Rabbitoshi_hygiene_time'],
	'L_RABBITOSHI_HYGIENE_VALUE' => $lang['Rabbitoshi_hygiene_value'],
	'L_RABBITOSHI_HEALTH_PRICE' => $lang['Rabbitoshi_health_price'],
	'L_RABBITOSHI_HUNGER_PRICE' => $lang['Rabbitoshi_hunger_price'],
	'L_RABBITOSHI_THIRST_PRICE' => $lang['Rabbitoshi_thirst_price'],
	'L_RABBITOSHI_HYGIENE_PRICE' => $lang['Rabbitoshi_hygiene_price'],
	'L_RABBITOSHI_LEVEL_PRICE' => $lang['Rabbitoshi_level_price'],
	'L_RABBITOSHI_POWER_PRICE' => $lang['Rabbitoshi_power_price'],
	'L_RABBITOSHI_MAGICPOWER_PRICE' => $lang['Rabbitoshi_magicpower_price'],
	'L_RABBITOSHI_ARMOR_PRICE' => $lang['Rabbitoshi_armor_price'],
	'L_RABBITOSHI_ATTACK_PRICE' => $lang['Rabbitoshi_attack_price'],
	'L_RABBITOSHI_MAGICATTACK_PRICE' => $lang['Rabbitoshi_magicattack_price'],
	'L_RABBITOSHI_ATTACK_RELOAD_PRICE' => $lang['Rabbitoshi_attack_reload_price'],
	'L_RABBITOSHI_MAGIC_RELOAD_PRICE' => $lang['Rabbitoshi_magic_reload_price'],
	'L_RABBITOSHI_MP_PRICE' => $lang['Rabbitoshi_mp_price'],
	'L_RABBITOSHI_HEALTH_RAISE' => $lang['Rabbitoshi_health_raise'],
	'L_RABBITOSHI_HUNGER_RAISE' => $lang['Rabbitoshi_hunger_raise'],
	'L_RABBITOSHI_THIRST_RAISE' => $lang['Rabbitoshi_thirst_raise'],
	'L_RABBITOSHI_HYGIENE_RAISE' => $lang['Rabbitoshi_hygiene_raise'],
	'L_RABBITOSHI_POWER_RAISE' => $lang['Rabbitoshi_power_raise'],
	'L_RABBITOSHI_MAGICPOWER_RAISE' => $lang['Rabbitoshi_magicpower_raise'],
	'L_RABBITOSHI_ARMOR_RAISE' => $lang['Rabbitoshi_armor_raise'],
	'L_RABBITOSHI_ATTACK_RAISE' => $lang['Rabbitoshi_attack_raise'],
	'L_RABBITOSHI_MAGICATTACK_RAISE' => $lang['Rabbitoshi_magicattack_raise'],
	'L_RABBITOSHI_MP_RAISE' => $lang['Rabbitoshi_mp_raise'],
	'L_RABBITOSHI_EXPERIENCE_MIN' => $lang['Rabbitoshi_experience_min'],
	'L_RABBITOSHI_EXPERIENCE_MAX' => $lang['Rabbitoshi_experience_max'],
	'L_RABBITOSHI_MP_MIN' => $lang['Rabbitoshi_mp_min'],
	'L_RABBITOSHI_MP_MAX' => $lang['Rabbitoshi_mp_max'],
	'L_EXPLANATIONS' => $lang['Rabbitoshi_settings_explanations'],
	'L_SUBMIT' => $lang['Submit'],
	'L_TRANSLATOR' => $lang['Rabbitoshi_translation'],
	'L_SECONDS' => $lang['Rabbitoshi_seconds'],
	'L_RABBITOSHI_USE_CRON' => $lang['Rabbitoshi_cron_use'],
	'L_RABBITOSHI_USE_CRON_EXPLAIN' => $lang['Rabbitoshi_cron_explain'],
	'L_RABBITOSHI_LEVEL_UP_PENALTY' => $lang['Rabbitoshi_level_up_penalty'],
	'L_RABBITOSHI_LEVEL_UP_PENALTY_EXPLAIN' => $lang['Rabbitoshi_level_up_penalty_explain'],
	'L_RABBITOSHI_CRON_TIME' => $lang['Rabbitoshi_cron_time'],
	'S_RABBITOSHI_ACTION' => append_sid(basename(__FILE__)))
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>