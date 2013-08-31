<?php
/***************************************************************************
 *                         admin_rabbitoshi_levelup.php
 *                            ------------------
 *   begin                : 26/01/2005
 *   copyright		  : One_Piece
 *
 ***************************************************************************/

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Rabbitoshi']['Rabbitoshi_Level_Up'] = $file;
	return;
}

define('IN_PHPBB', true);

$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require("pagestart.$phpEx");

include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_rabbitoshi.'.$phpEx);
include($phpbb_root_path . 'includes/functions_rabbitoshi.'.$phpEx);

$template->set_filenames(array(
	'body' => 'admin/config_rabbitoshi_levelup_body.tpl')
);

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
	'HEALTH_LEVELUP' => $rabitoshi['health_levelup'],
	'HUNGER_LEVELUP' => $rabitoshi['hunger_levelup'],
	'THIRST_LEVELUP' => $rabitoshi['thirst_levelup'],
	'HYGIENE_LEVELUP' => $rabitoshi['hygiene_levelup'],
	'POWER_LEVELUP' => $rabitoshi['power_levelup'],
	'MAGICPOWER_LEVELUP' => $rabitoshi['magicpower_levelup'],
	'ARMOR_LEVELUP' => $rabitoshi['armor_levelup'],
	'MP_LEVELUP' => $rabitoshi['mp_levelup'],
	'ATTACK_LEVELUP' => $rabitoshi['attack_levelup'],
	'MAGICATTACK_LEVELUP' => $rabitoshi['magicattack_levelup'],
));

if ( $submit )
{
	$health_levelup = $HTTP_POST_VARS['health_levelup'];
	$hunger_levelup = $HTTP_POST_VARS['hunger_levelup'];
	$thirst_levelup = $HTTP_POST_VARS['thirst_levelup'];
	$hygiene_levelup = $HTTP_POST_VARS['hygiene_levelup'];
	$power_levelup = $HTTP_POST_VARS['power_levelup'];
	$magicpower_levelup = $HTTP_POST_VARS['magicpower_levelup'];
	$armor_levelup = $HTTP_POST_VARS['armor_levelup'];
	$mp_levelup = $HTTP_POST_VARS['mp_levelup'];
	$attack_levelup = $HTTP_POST_VARS['attack_levelup'];
	$magicattack_levelup = $HTTP_POST_VARS['magicattack_levelup'];


	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$health_levelup' WHERE config_name = 'health_levelup' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hunger_levelup' WHERE config_name = 'hunger_levelup' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}

	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$thirst_levelup' WHERE config_name = 'thirst_levelup' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$hygiene_levelup' WHERE config_name = 'hygiene_levelup' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$power_levelup' WHERE config_name = 'power_levelup' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$magicpower_levelup' WHERE config_name = 'magicpower_levelup' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	}
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$armor_levelup' WHERE config_name = 'armor_levelup' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$mp_levelup' WHERE config_name = 'mp_levelup' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$attack_levelup' WHERE config_name = 'attack_levelup' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". RABBITOSHI_GENERAL_TABLE . " SET config_value = '$magicattack_levelup' WHERE config_name = 'magicattack_levelup' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Rabbitoshi_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 

	message_die(GENERAL_MESSAGE, sprintf($lang['Rabbitoshi_updated_return_settings'], '<a href="' . append_sid(basename(__FILE__)) . '">', '</a>'), $lang['Rabbitoshi_settings']);
}

$template->assign_vars(array(
	'L_RABBITOSHI_LEVELUP_SETTINGS' => $lang['Rabbitoshi_abilities_settings'],
	'L_RABBITOSHI_LEVELUP_SETTINGS_EXPLAIN' => $lang['Rabbitoshi_abilities_settings_explain'],
	'L_HEALTH_LEVELUP' => $lang['Rabbitoshi_health_levelup'],
	'L_HUNGER_LEVELUP' => $lang['Rabbitoshi_hunger_levelup'],
	'L_THIRST_LEVELUP' => $lang['Rabbitoshi_thirst_levelup'],
	'L_HYGIENE_LEVELUP' => $lang['Rabbitoshi_hygiene_levelup'],
	'L_POWER_LEVELUP' => $lang['Rabbitoshi_power_levelup'],
	'L_MAGICPOWER_LEVELUP' => $lang['Rabbitoshi_magicpower_levelup'],
	'L_ARMOR_LEVELUP' => $lang['Rabbitoshi_armor_levelup'],
	'L_MP_LEVELUP' => $lang['Rabbitoshi_mp_levelup'],
	'L_ATTACK_LEVELUP' => $lang['Rabbitoshi_attack_levelup'],
	'L_MAGICATTACK_LEVELUP' => $lang['Rabbitoshi_magicattack_levelup'],
	'L_SUBMIT' => $lang['Submit'],
	'L_TRANSLATOR' => $lang['Rabbitoshi_translation'],
	'S_RABBITOSHI_ACTION' => append_sid(basename(__FILE__)))
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>