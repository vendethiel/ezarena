<?php
/***************************************************************************
 *                              admin_adr_tools.php
 *                            ------------------
 *   begin                : 17/02/2004
 *
 *
 ***************************************************************************/

// Yes , we are everywhere ^_^
define('IN_PHPBB', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_CHARACTER', 1);
define('IN_ADR_SHOPS', 1);
define('IN_ADR_SETTINGS', 1);
define('IN_ADR_VAULT', 1);
define('IN_ADR_BATTLE', 1);
define('IN_ADR_TOOLS', 1);
define('IN_ADR_SKILLS', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr_Tools']['Adr_cache'] = "$filename?mode=cache";
	$module['Adr_Tools']['Adr_items_resync'] = "$filename?mode=resync_items";
	$module['Adr_Tools']['Armaggedon'] = "$filename?mode=armaggedon";
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require("pagestart.$phpEx");
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

adr_template_file('admin/config_adr_tools_body.tpl');

$mode = ( isset($_POST['mode']) ) ? $_POST['mode'] : $_GET['mode'];

// Define the actions
$tools		 				= intval($_POST['tool']);
$rebuild_cache 				= isset($_POST['rebuild_cache']);
$resync_items 				= isset($_POST['resync_items']);
$clean_battle_list 			= isset($_POST['clean_battle_list']);
$zero_dura 					= isset($_POST['zero_dura']);
$characters 				= isset($_POST['characters']);
$user_shops 				= isset($_POST['user_shops']);
$shops_items 				= isset($_POST['shops_items']);
$user_items 				= isset($_POST['user_items']);

if($mode === 'cache')
	$template->assign_block_vars(cache, array());
elseif($mode === 'resync_items')
	$template->assign_block_vars(resync, array());
else
	$template->assign_block_vars(armaggedon, array());

if($rebuild_cache)
{
	// Rebuild all cache files
	include_once($phpbb_root_path . 'adr/includes/adr_functions_cache.'.$phpEx);
	adr_update_all_cache_infos();

	adr_previous(Adr_admin_tools_cache_updated, admin_adr_tools, 'mode=cache');
}

if($zero_dura)
{
	$sql = "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id > '1'
		AND item_duration < '1'";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not clear low dura items ', "", __LINE__, __FILE__, $csql);
	}

	adr_previous(Adr_admin_tools_armaggedon_done, admin_adr_tools, '');
}

if($clean_battle_list)
{
	$sql = "UPDATE " . ADR_BATTLE_LIST_TABLE . "
		SET battle_text = ''
		WHERE battle_result != '0'";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not clean battle_list table ', "", __LINE__, __FILE__, $csql);
	}

	$sql1 = "OPTIMIZE TABLE " . ADR_BATTLE_LIST_TABLE;
	if( !$db->sql_query($sql1))
	{
		message_die(GENERAL_ERROR, 'Could not optimize battle_list table ', "", __LINE__, __FILE__, $csql);
	}

	adr_previous(Adr_admin_tools_armaggedon_done, admin_adr_tools, '');
}

if($characters)
{
	$sql = "DELETE FROM " . ADR_CHARACTERS_TABLE;
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not delete characters ', "", __LINE__, __FILE__, $sql);
	}

	adr_previous(Adr_admin_tools_armaggedon_done, admin_adr_tools, '');
}

if($shops_items)
{
	$sql = "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = '1'";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not delete items ', "", __LINE__, __FILE__, $csql);
	}

	adr_previous(Adr_admin_tools_armaggedon_shops_yes, admin_adr_tools, '');
}

if($user_shops)
{
	$sql = "DELETE FROM " . ADR_SHOPS_TABLE . "
		WHERE shop_id > '1'";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not delete shops ', "", __LINE__, __FILE__, $sql);
	}

	adr_previous(Adr_admin_tools_armaggedon_done, admin_adr_tools, '');
}

if($user_items)
{
	$sql = "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id > '1'";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not delete items ', "", __LINE__, __FILE__, $csql);
	}

	adr_previous(Adr_admin_tools_user_items, admin_adr_tools, '');
}

if($resync_items)
{
	$adr_general = adr_get_general_config();

	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = '1'";
	if ( !($result = $db->sql_query($sql))){
		message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);}
	$items = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($items); $i++)
	{
		$item_power = $items[$i]['item_power'];
		$item_quality = $items[$i]['item_quality'];
		$item_type_use = $items[$i]['item_type_use'];
		$item_id = $items[$i]['item_id'];
		$item_duration = $items[$i]['item_duration'];
		$item_duration_max = $items[$i]['item_duration_max'];

		// Get the base and modifier price
		$adr_quality_price = adr_get_item_quality($item_quality, price);
		$adr_type_price = adr_get_item_type($item_type_use, price);

		// First define the base price
		$item_price = $adr_type_price;

		// Then apply the quality modifier
		$item_price = $item_price *(($adr_quality_price /100));

		// And now the power - it's a little more complicated
		$item_price = ($item_power > '1') ? ($item_price + ($item_price *(($item_power -1) *($adr_general['item_modifier_power'] -100) /100))) : $item_price ;

		// Apply the duration penalty
		$item_price = abs($item_price / ($item_duration_max / $item_duration));

		// Finally let's use a non decimal value & add 10 %
		$item_price = ceil($item_price * 1.1);

		// Update the database
		$sql = " UPDATE " . ADR_SHOPS_ITEMS_TABLE . "
			SET item_price = $item_price
			WHERE item_owner_id = '1'
			AND item_id = '$item_id'";
		if ( !$db->sql_query($sql)){
			message_die(GENERAL_ERROR, 'Could not update items price', "", __LINE__, __FILE__, $sql);}
	}
	adr_previous(Adr_admin_tools_items_updated, admin_adr_tools, 'mode=resync_items');
}

$template->assign_vars(array(
	'L_OPTIMISE'    => $lang['Adr_admin_tools_optimize'],
	'L_DELETE'    => $lang['Adr_admin_tools_delete'],
	'L_CONVERTORS_SETTINGS' => $lang['Adr_admin_tools_convertors_settings'],
	'L_CONVERTORS_SETTINGS_EXPLAIN' => $lang['Adr_admin_tools_convertors_settings_explain'],
	'L_UPDATE' => $lang['Adr_admin_tools_convertors_update'],
	'L_UPDATE_ITEMS' => $lang['Adr_admin_tools_convertors_update_items'],
	'L_UPDATE_BANK' => $lang['Adr_admin_tools_convertors_update_bank'],
	'L_UPDATE_VAULT' => $lang['Adr_admin_tools_convertors_update_vault'],
	'L_UPDATE_CHARACTERS' => $lang['Adr_admin_tools_convertors_update_users'],
	'L_DELETE' => $lang['Adr_admin_tools_convertors_delete'],
	'L_DELETE_ITEMS' => $lang['Adr_admin_tools_convertors_delete_item'],
	'L_DELETE_VAULT' => $lang['Adr_admin_tools_convertors_delete_vault'],
	'L_DELETE_BANK' => $lang['Adr_admin_tools_convertors_delete_bank'],
	'L_DELETE_RPG_STATS' => $lang['Adr_admin_tools_convertors_delete_rpg_stats'],
	'L_CACHE_SETTINGS' => $lang['Adr_admin_tools_cache_settings'],
	'L_CACHE_SETTINGS_EXPLAIN' => $lang['Adr_admin_tools_cache_settings_explain'],
	'L_UPDATE_CACHE' => $lang['Adr_admin_tools_update_cache'],
	'L_RESYNC_SETTINGS' => $lang['Adr_admin_tools_resync_items'],
	'L_REYSNC_SETTINGS_EXPLAIN' => $lang['Adr_admin_tools_resync_items_explain'],
	'L_RESYNC_ITEMS' => $lang['Adr_admin_tools_resync_items_action'],
	'L_ARMAGGEDON_SETTINGS' => $lang['Adr_admin_tools_armaggedon'],
	'L_ARMAGGEDON_SETTINGS_EXPLAIN' => $lang['Adr_admin_tools_armaggedon_explain'],
	'L_CLEAN_BATTLE_LIST' => $lang['Adr_admin_tools_armaggedon_battle_list'],
	'L_ARMAGGEDON_ZERO_DURA' => $lang['Adr_admin_tools_armaggedon_zero_dura'],
	'L_ARMAGGEDON_CHARACTERS' => $lang['Adr_admin_tools_armaggedon_characters'],
	'L_ARMAGGEDON_SHOPS' => 	$lang['Adr_admin_tools_armaggedon_shops'],
	'L_ARMAGGEDON_USER_ITEMS' => $lang['Adr_admin_tools_armaggedon_user_items'],
	'L_ARMAGGEDON_SHOPS_ITEMS' => $lang['Adr_admin_tools_armaggedon_shops_items'],
    'L_CLEAN_BATTLE_LIST' => $lang['Adr_admin_tools_armaggedon_battle_list'],
	'L_OPTIMISE' => $lang['Adr_admin_tools_armaggedon_optimise'],
	'S_ADR_ACTION' => append_sid("admin_adr_tools.$phpEx?mode=$mode"))
);

$template->pparse('body');
include('./page_footer_admin.'.$phpEx);
?>
