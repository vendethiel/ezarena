<?php
/***************************************************************************
 *                              admin_adr_vault_exchange.php
 *                            ------------------
 *   begin                : 15/02/2004
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_VAULT', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Adr_vault']['Adr_vault_exchange'] = $file;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

adr_template_file('admin/config_adr_vault_exchange_body.tpl');

$submit = isset($HTTP_POST_VARS['submit']); 

$sql = "SELECT * FROM " . ADR_GENERAL_TABLE ;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
}
while( $row = $db->sql_fetchrow($result) )
{
	$vault[$row['config_name']] = $row['config_value'];
}

if ( $submit )
{
	$use = intval ( $HTTP_POST_VARS['use']);
	$min = intval ( $HTTP_POST_VARS['min']);
	$max = intval ( $HTTP_POST_VARS['max']);
	$time = intval ( $HTTP_POST_VARS['time']);

	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$use' WHERE config_name = 'stock_use' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Adr_vault_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". ADR_GENERAL_TABLE . " SET config_value = '$min' WHERE config_name = 'stock_min_change' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Adr_vault_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 
	$lsql= "UPDATE ". ADR_GENERAL_TABLE . " SET config_value = '$max' WHERE config_name = 'stock_max_change' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Adr_vault_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 	
	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = '$time' WHERE config_name = 'stock_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, $lang['Adr_vault_update_error'] , "", __LINE__, __FILE__, $lsql); 
	} 

	adr_update_general_config();
	message_die(GENERAL_MESSAGE, sprintf($lang['Adr_vault_exchange_updated_return_settings'], '<a href="' . append_sid(basename(__FILE__)) . '">', '</a>'), $lang['Adr_vault_settings']);
}

if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = "";
}

if( isset($HTTP_POST_VARS['add']) || isset($HTTP_GET_VARS['add']) )
{
	adr_template_file('admin/config_adr_vault_exchange_add_body.tpl');

	$template->assign_block_vars('exchange_add',array());

	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	$template->assign_vars(array(
		'L_VAULT_EXCHANGE_ADD_SETTINGS' => $lang['Adr_vault_exchange_settings_add'],
		'L_VAULT_EXCHANGE_ADD_SETTINGS_EXPLAIN' => $lang['Adr_vault_exchange_settings_explain_add'],
		'L_STOCK_EXCHANGE_ACTIONS_ADD' => $lang['Adr_vault_exchange_actions_add'],
		'L_STOCK_NAME' => $lang['Adr_vault_exchange_actions_name'],
		'L_STOCK_DESC' => $lang['Adr_vault_exchange_actions_desc'],
		'L_STOCK_AMOUNT' => $lang['Adr_vault_exchange_actions_amount'],
		"S_HIDDEN_FIELDS" => $s_hidden_fields) 
	);

}
else if ( $mode != "" )
{
	switch( $mode )
	{
		case 'delete':

			$stock_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			$sql = "SELECT * FROM " . ADR_VAULT_EXCHANGE_USERS_TABLE . "
				WHERE stock_id = " . $stock_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete stock", "", __LINE__, __FILE__, $sql);
			}
			$users = $db->sql_fetchrowset($result);
			for ( $i = 0 ; $i < count ( $users ) ; $i ++ )
			{
				$ssql = "SELECT stock_price FROM " . ADR_VAULT_EXCHANGE_TABLE . "
					WHERE stock_id = " . $stock_id;
				$sresult = $db->sql_query($ssql);
				if( !$sresult )
				{
					message_die(GENERAL_ERROR, "Couldn't delete stock", "", __LINE__, __FILE__, $ssql);
				}
				$prize = $db->sql_fetchrow($sresult);
				$price = $prize['stock_price'] * $users[$i]['stock_amount'];
				$usql = "UPDATE " . USERS_TABLE . "
					SET user_points = user_points + $price 
					WHERE user_id =  ".$users[$i]['user_id'];
				$uresult = $db->sql_query($usql);
				if( !$uresult )
				{
					message_die(GENERAL_ERROR, "Couldn't delete stock", "", __LINE__, __FILE__, $usql);
				}
			}

			$sql = "DELETE FROM " . ADR_VAULT_EXCHANGE_USERS_TABLE . " 
 				WHERE stock_id = " . $stock_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete stock", "", __LINE__, __FILE__, $sql);
			}

			$sql = "DELETE FROM " . ADR_VAULT_EXCHANGE_TABLE . "
				WHERE stock_id = " . $stock_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete stock", "", __LINE__, __FILE__, $sql);
			}

			message_die(GENERAL_MESSAGE, sprintf($lang['Adr_vault_exchange_deleted_return_settings'], '<a href="' . append_sid(basename(__FILE__)) . '">', '</a>'), $lang['Adr_vault_settings']);
			break;

		case 'edit':

			$stock_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			$sql = "SELECT * FROM " . ADR_VAULT_EXCHANGE_TABLE . "
				WHERE stock_id = " . $stock_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain stock exchange information', "", __LINE__, __FILE__, $sql);
			}
			$stock_data = $db->sql_fetchrow($result);

			adr_template_file('admin/config_adr_vault_exchange_add_body.tpl');

			$template->assign_block_vars('exchange_edit',array());

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="stock_id" value="' . $stock_data['stock_id'] . '" />';

			$template->assign_vars(array(
				'STOCK_NAME' => $stock_data['stock_name'],
				'STOCK_DESC' => $stock_data['stock_desc'],
				'STOCK_AMOUNT' => $stock_data['stock_price'],
				'L_STOCK_EXCHANGE_ACTIONS_EDIT'  => $lang['Adr_vault_exchange_actions_edit'],
				'L_VAULT_EXCHANGE_EDIT_SETTINGS' => $lang['Adr_vault_exchange_settings_edit'],
				'L_VAULT_EXCHANGE_EDIT_SETTINGS_EXPLAIN' => $lang['Adr_vault_exchange_settings_explain_edit'],
				'L_STOCK_NAME' => $lang['Adr_vault_exchange_actions_name'],
				'L_STOCK_DESC' => $lang['Adr_vault_exchange_actions_desc'],
				'L_STOCK_AMOUNT' => $lang['Adr_vault_exchange_actions_amount'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields) 
			);

			break;

		case "save":

			$stock_name = ( isset($HTTP_POST_VARS['stock_name']) ) ? trim($HTTP_POST_VARS['stock_name']) : trim($HTTP_GET_VARS['stock_name']);
			$stock_desc = ( isset($HTTP_POST_VARS['stock_desc']) ) ? trim($HTTP_POST_VARS['stock_desc']) : trim($HTTP_GET_VARS['stock_desc']);
			$stock_price = ( isset($HTTP_POST_VARS['stock_price']) ) ? intval($HTTP_POST_VARS['stock_price']) : intval($HTTP_GET_VARS['stock_price']);
			$stock_id = ( isset($HTTP_POST_VARS['stock_id']) ) ? intval($HTTP_POST_VARS['stock_id']) : intval($HTTP_GET_VARS['stock_id']);

			if ($stock_name == '' || $stock_desc == '' || $stock_price == '' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "UPDATE " . ADR_VAULT_EXCHANGE_TABLE . "
				SET stock_name = '" . str_replace("\'", "''", $stock_name) . "', 
				stock_desc = '" . str_replace("\'", "''", $stock_desc) . "', 
				stock_price = $stock_price
				WHERE stock_id = " . $stock_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't update stock", "", __LINE__, __FILE__, $sql);
			}

			message_die(GENERAL_MESSAGE, sprintf($lang['Adr_vault_exchange_edited_return_settings'], '<a href="' . append_sid(basename(__FILE__)) . '">', '</a>'), $lang['Adr_vault_settings']);
			break;

		case "savenew":

			$sql = "SELECT *	FROM " . ADR_VAULT_EXCHANGE_TABLE ."
			ORDER BY stock_id 
			DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain stock exchange information', "", __LINE__, __FILE__, $sql);
			}
			$stock_data = $db->sql_fetchrow($result);

			$stock_name = ( isset($HTTP_POST_VARS['stock_name']) ) ? trim($HTTP_POST_VARS['stock_name']) : trim($HTTP_GET_VARS['stock_name']);
			$stock_desc = ( isset($HTTP_POST_VARS['stock_desc']) ) ? trim($HTTP_POST_VARS['stock_desc']) : trim($HTTP_GET_VARS['stock_desc']);
			$stock_price = ( isset($HTTP_POST_VARS['stock_price']) ) ? intval($HTTP_POST_VARS['stock_price']) : intval($HTTP_GET_VARS['stock_price']);
			$stock_id = $stock_data['stock_id'] +1;

			if ($stock_name == '' || $stock_desc == '' || $stock_price == '' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "INSERT INTO " . ADR_VAULT_EXCHANGE_TABLE . " (stock_id, stock_name, stock_desc, stock_price,stock_previous_price,stock_worst_price,stock_best_price)
				VALUES ( $stock_id, '" . str_replace("\'", "''", $stock_name) . "' , '" . str_replace("\'", "''", $stock_desc) . "' , $stock_price, $stock_price, $stock_price, $stock_price)";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new stock", "", __LINE__, __FILE__, $sql);
			}

			message_die(GENERAL_MESSAGE, sprintf($lang['Adr_vault_exchange_added_return_settings'], '<a href="' . append_sid(basename(__FILE__)) . '">', '</a>'), $lang['Adr_vault_settings']);
			break;
	}
}
else
{
	$sql = "SELECT *	FROM " . ADR_VAULT_EXCHANGE_TABLE ."
		ORDER BY stock_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain stock exchange from database", "", __LINE__, __FILE__, $sql);
	}

	$exchange = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($exchange); $i++)
	{		
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$stock_name = adr_get_lang($exchange[$i]['stock_name']);
		$stock_desc = adr_get_lang($exchange[$i]['stock_desc']);

		$template->assign_block_vars("exchange", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"STOCK_NAME" =>  $stock_name,
			"STOCK_DESC" =>  $stock_desc,
			"STOCK_AMOUNT" =>  $exchange[$i]['stock_price'], 
			"U_STOCK_EDIT" => append_sid("admin_adr_vault_exchange.$phpEx?mode=edit&amp;id=" . $exchange[$i]['stock_id']), 
			"U_STOCK_DELETE" => append_sid("admin_adr_vault_exchange.$phpEx?mode=delete&amp;id=" . $exchange[$i]['stock_id']))
		);
	}
	$template->assign_vars(array(
		'L_STOCK_EXCHANGE_ACTIONS' => $lang['Adr_vault_exchange_actions'],
		'L_STOCK_NAME' => $lang['Adr_vault_exchange_actions_name'],
		'L_STOCK_DESC' => $lang['Adr_vault_exchange_actions_desc'],
		'L_STOCK_AMOUNT' => $lang['Adr_vault_exchange_actions_amount'],
		'L_ACTION' => $lang['Adr_vault_exchange_action'],
		'L_EDIT' => $lang['Adr_vault_exchange_edit'],
		'L_DELETE' => $lang['Adr_vault_exchange_delete'],
		'L_STOCK_ADD' => $lang['Adr_vault_exchange_actions_add'],
	));

}

$template->assign_vars(array(
	'VAULT_EXCHANGE_USE_CHECKED' => ( $board_config['stock_use'] ? 'CHECKED' :'' ),
	'VAULT_EXCHANGE_TIME' => $board_config['stock_time'],
	'VAULT_EXCHANGE_TIME_EXPLAIN' => $lang['Adr_vault_time_explain'].adr_make_time($board_config['stock_time']),
	'VAULT_EXCHANGE_MAX' => $vault['stock_max_change'],
	'VAULT_EXCHANGE_MIN' => $vault['stock_min_change'],
	'L_VAULT_EXCHANGE_SETTINGS' => $lang['Adr_vault_exchange_settings'],
	'L_VAULT_EXCHANGE_SETTINGS_EXPLAIN' => $lang['Adr_vault_exchange_settings_explain'],
	'L_VAULT_EXCHANGE_USE' => $lang['Adr_vault_exchange_use'],
	'L_VAULT_EXCHANGE_MIN' => $lang['Adr_vault_exchange_min'],
	'L_VAULT_EXCHANGE_MIN_EXPLAIN' => $lang['Adr_vault_exchange_min_explain'],
	'L_VAULT_EXCHANGE_MAX' => $lang['Adr_vault_exchange_max'],
	'L_VAULT_EXCHANGE_MAX_EXPLAIN' => $lang['Adr_vault_exchange_max_explain'],
	'L_VAULT_EXCHANGE_TIME' => $lang['Adr_vault_exchange_time'],
	'L_VAULT_EXCHANGE_TIME_EXPLAIN' => $lang['Adr_vault_exchange_time_explain'],
	'L_SUBMIT' => $lang['Submit'],
	'S_VAULT_ACTION' => append_sid(basename(__FILE__)),
	"S_HIDDEN_FIELDS" => $s_hidden_fields)
);

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>