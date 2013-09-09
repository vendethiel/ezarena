<?php
/***************************************************************************
 *                          admin_rabbitoshi_abilities.php
 *                              -------------------
 *     begin                : Thurs June 9 2006
 *     copyright            : (C) 2006 The ADR Dev Crew
 *     site                 : http://www.adr-support.com
 *
 *     $Id: admin_rabbitoshi_abilities.php,v 4.00.0.00 2006/06/09 02:32:18 Ethalic Exp $
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
	$module['Rabbitoshi']['Rabbitoshi_Abilities'] = $file;
	return;
}

$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require("./pagestart.$phpEx");
include($phpbb_root_path.'rabbitoshi/includes/functions_rabbitoshi.'.$phpEx);

rabbitoshi_template_file('admin/config_rabbitoshi_abilities_body.tpl');

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
	'REGENERATION_LEVEL' => $rabitoshi['regeneration_level'],
	'REGENERATION_MAGICPOWER' => $rabitoshi['regeneration_magicpower'],
	'REGENERATION_MP' => $rabitoshi['regeneration_mp'],
	'REGENERATION_MP_NEED' => $rabitoshi['regeneration_mp_need'],
	'REGENERATION_HP_GIVE' => $rabitoshi['regeneration_hp_give'],
	'REGENERATION_PRICE' => $rabitoshi['regeneration_price'],
	'HEALTH_LEVEL' => $rabitoshi['health_transfert_level'],
	'HEALTH_MAGICPOWER' => $rabitoshi['health_transfert_magicpower'],
	'HEALTH_HEALTH' => $rabitoshi['health_transfert_health'],
	'HEALTH_PERCENT' => $rabitoshi['health_transfert_percent'],
	'HEALTH_PRICE' => $rabitoshi['health_transfert_price'],
	'MANA_LEVEL' => $rabitoshi['mana_transfert_level'],
	'MANA_MAGICPOWER' => $rabitoshi['mana_transfert_magicpower'],
	'MANA_MP' => $rabitoshi['mana_transfert_mp'],
	'MANA_PERCENT' => $rabitoshi['mana_transfert_percent'],
	'MANA_PRICE' => $rabitoshi['mana_transfert_price'],
	'SACRIFICE_LEVEL' => $rabitoshi['sacrifice_level'],
	'SACRIFICE_POWER' => $rabitoshi['sacrifice_power'],
	'SACRIFICE_ARMOR' => $rabitoshi['sacrifice_armor'],
	'SACRIFICE_MP' => $rabitoshi['sacrifice_mp'],
	'SACRIFICE_PRICE' => $rabitoshi['sacrifice_price'],
));

if ( $submit )
{
	$regeneration_level = $HTTP_POST_VARS['regeneration_level'];
	$regeneration_magicpower = $HTTP_POST_VARS['regeneration_magicpower'];
	$regeneration_mp = $HTTP_POST_VARS['regeneration_mp'];
	$regeneration_mp_need = $HTTP_POST_VARS['regeneration_mp_need'];
	$regeneration_hp_give = $HTTP_POST_VARS['regeneration_hp_give'];
	$regeneration_price = $HTTP_POST_VARS['regeneration_price'];
	$health_level = $HTTP_POST_VARS['health_level'];
	$health_magicpower = $HTTP_POST_VARS['health_magicpower'];
	$health_health = $HTTP_POST_VARS['health_health'];
	$health_percent = $HTTP_POST_VARS['health_percent'];
	$health_price = $HTTP_POST_VARS['health_price'];
	$mana_level = $HTTP_POST_VARS['mana_level'];
	$mana_magicpower = $HTTP_POST_VARS['mana_magicpower'];
	$mana_mp = $HTTP_POST_VARS['mana_mp'];
	$mana_percent = $HTTP_POST_VARS['mana_percent'];
	$mana_price = $HTTP_POST_VARS['mana_price'];
	$sacrifice_level = $HTTP_POST_VARS['sacrifice_level'];
	$sacrifice_power = $HTTP_POST_VARS['sacrifice_power'];
	$sacrifice_armor = $HTTP_POST_VARS['sacrifice_armor'];
	$sacrifice_mp = $HTTP_POST_VARS['sacrifice_mp'];
	$sacrifice_price = $HTTP_POST_VARS['sacrifice_price'];


	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$regeneration_level' WHERE config_name = 'regeneration_level' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$regeneration_magicpower' WHERE config_name = 'regeneration_magicpower' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}

	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$regeneration_mp' WHERE config_name = 'regeneration_mp' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$regeneration_mp_need' WHERE config_name = 'regeneration_mp_need' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$regeneration_hp_give' WHERE config_name = 'regeneration_hp_give' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$regeneration_price' WHERE config_name = 'regeneration_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$health_level' WHERE config_name = 'health_transfert_level' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$health_magicpower' WHERE config_name = 'health_transfert_magicpower' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$health_health' WHERE config_name = 'health_transfert_health' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$health_percent' WHERE config_name = 'health_transfert_percent' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$health_price' WHERE config_name = 'health_transfert_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$mana_level' WHERE config_name = 'mana_transfert_level' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$mana_magicpower' WHERE config_name = 'mana_transfert_magicpower' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$mana_mp' WHERE config_name = 'mana_transfert_mp' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$mana_percent' WHERE config_name = 'mana_transfert_percent' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$mana_price' WHERE config_name = 'mana_transfert_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$sacrifice_level' WHERE config_name = 'sacrifice_level' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$sacrifice_power' WHERE config_name = 'sacrifice_power' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$sacrifice_armor' WHERE config_name = 'sacrifice_armor' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$sacrifice_mp' WHERE config_name = 'sacrifice_mp' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$sacrifice_price' WHERE config_name = 'sacrifice_price' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 

	message_die(GENERAL_MESSAGE, sprintf($lang['Rabbitoshi_updated_return_settings'], '<a href="' . append_sid(basename(__FILE__)) . '">', '</a>'), $lang['Rabbitoshi_settings']);
}

$template->assign_vars(array(
	'L_RABBITOSHI_ABILITY_SETTINGS' => $lang['Rabbitoshi_abilities_settings'],
	'L_RABBITOSHI_ABILITY_SETTINGS_EXPLAIN' => $lang['Rabbitoshi_abilities_settings_explain'],
	'L_ABILITY_REGENERATION_LEVEL' => $lang['Rabbitoshi_regeneration_level'],
	'L_ABILITY_REGENERATION_MAGICPOWER' => $lang['Rabbitoshi_regeneration_magicpower'],
	'L_ABILITY_REGENERATION_MP' => $lang['Rabbitoshi_regeneration_mp'],
	'L_ABILITY_REGENERATION_MP_NEED' => $lang['Rabbitoshi_regeneration_mp_need'],
	'L_ABILITY_REGENERATION_HP_GIVE' => $lang['Rabbitoshi_regeneration_hp_give'],
	'L_ABILITY_REGENERATION_PRICE' => $lang['Rabbitoshi_regeneration_price'],
	'L_ABILITY_HEALTH_LEVEL' => $lang['Rabbitoshi_health_level'],
	'L_ABILITY_HEALTH_MAGICPOWER' => $lang['Rabbitoshi_health_magicpower'],
	'L_ABILITY_HEALTH_HEALTH' => $lang['Rabbitoshi_health_health'],
	'L_ABILITY_HEALTH_PERCENT' => $lang['Rabbitoshi_health_percent'],
	'L_ABILITY_HEALTH_PRICE' => $lang['Rabbitoshi_healthtransfert_price'],
	'L_ABILITY_MANA_LEVEL' => $lang['Rabbitoshi_mana_level'],
	'L_ABILITY_MANA_MAGICPOWER' => $lang['Rabbitoshi_mana_magicpower'],
	'L_ABILITY_MANA_MP' => $lang['Rabbitoshi_mana_mp'],
	'L_ABILITY_MANA_PERCENT' => $lang['Rabbitoshi_mana_percent'],
	'L_ABILITY_MANA_PRICE' => $lang['Rabbitoshi_mana_price'],
	'L_ABILITY_SACRIFICE_LEVEL' => $lang['Rabbitoshi_sacrifice_level'],
	'L_ABILITY_SACRIFICE_POWER' => $lang['Rabbitoshi_sacrifice_power'],
	'L_ABILITY_SACRIFICE_ARMOR' => $lang['Rabbitoshi_sacrifice_armor'],
	'L_ABILITY_SACRIFICE_MP' => $lang['Rabbitoshi_sacrifice_mp'],
	'L_ABILITY_SACRIFICE_PRICE' => $lang['Rabbitoshi_sacrifice_price'],
	'L_SUBMIT' => $lang['Submit'],
	'L_TRANSLATOR' => $lang['Rabbitoshi_translation'],
	'S_RABBITOSHI_ACTION' => append_sid(basename(__FILE__)))
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>