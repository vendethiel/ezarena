<?php
/***************************************************************************
*                              admin_adr_seasons.php
*                              -------------------
*     begin                : 07/03/2005
*     copyright            : One_Piece
*
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

define('IN_PHPBB', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_ZONES_ADMIN', 1);
define('IN_ADR_CHARACTER', 1);
define('IN_ADR_CELL', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ADR-Zones']['Zone General'] = $filename;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

adr_template_file('admin/config_adr_zone_general_body.tpl');

$submit = isset($HTTP_POST_VARS['submit']);
$sql = "SELECT zone_id from " . ADR_ZONES_TABLE . " WHERE zone_name = 'World Map'";
$result = $db->sql_query($sql);
$existing_zone_worldmap_zone = $db->sql_fetchrow($result);

if ($submit)
{
	$dead_travel = intval($HTTP_POST_VARS['dead_travel']);
	$stat_bonus = intval($HTTP_POST_VARS['stat_bonus']);
	$att_bonus = $HTTP_POST_VARS['att_bonus'];
	$def_bonus = $HTTP_POST_VARS['def_bonus'];
	$zone_townmap_enable = intval($HTTP_POST_VARS['Adr_zone_townmap_enable']);
	$zone_townmap_name = $HTTP_POST_VARS['Adr_zone_townmap_name'];
	$zone_picture_link_enable = intval($HTTP_POST_VARS['Adr_zone_picture_link_enable']);
	$zone_worldmap_zone = intval($HTTP_POST_VARS['Adr_zone_worldmap_zone']);
	$zone_townmap_display_required = intval($HTTP_POST_VARS['Adr_zone_townmap_display_required']);

	$zone_npc_display_text = intval($HTTP_POST_VARS['npc_display_text']);
	$zone_npc_image_link = intval($HTTP_POST_VARS['npc_image_link']);
	$zone_npc_button_link = intval($HTTP_POST_VARS['npc_button_link']);
	$npc_display_enable = intval($HTTP_POST_VARS['npc_display_enable']);
	$zone_npc_image_count = intval($HTTP_POST_VARS['npc_image_count']);
	$zone_npc_image_size = intval($HTTP_POST_VARS['npc_image_size']);
	if ( isset( $HTTP_POST_VARS['zone_cheat_member_pm'] ) )
	{
		$zone_cheat_member_pm = implode(',' , $HTTP_POST_VARS['zone_cheat_member_pm'] );
		$zone_cheat_member_pm = ( strlen( $zone_cheat_member_pm ) <= 2 && ( $zone_cheat_member_pm <= 1 || $zone_cheat_member_pm == '' ) ) ? '2' : $zone_cheat_member_pm;
	}
	else
	{
		$zone_cheat_member_pm = '2';
	}
	if ( isset( $HTTP_POST_VARS['zone_adr_moderators'] ) )
	{
		$zone_adr_moderators = implode(',' , $HTTP_POST_VARS['zone_adr_moderators'] );
		$zone_adr_moderators = ( strlen( $zone_adr_moderators ) <= 2 && ( $zone_adr_moderators <= 1 || $zone_adr_moderators == '' ) ) ? '2' : $zone_adr_moderators;
	}
	else
	{
		$zone_adr_moderators = '2';
	}
	$zone_cheat_auto_ban_adr = intval($HTTP_POST_VARS['cheat_auto_ban_adr']);
	$zone_cheat_auto_ban_board = intval($HTTP_POST_VARS['cheat_auto_ban_board']);
	$zone_cheat_auto_jail = intval($HTTP_POST_VARS['cheat_auto_jail']);
	$zone_cheat_auto_time_day = intval($HTTP_POST_VARS['cheat_auto_time_day']);
	$zone_cheat_auto_time_hour = intval($HTTP_POST_VARS['cheat_auto_time_hour']);
	$zone_cheat_auto_time_minute = intval($HTTP_POST_VARS['cheat_auto_time_minute']);
	$zone_cheat_auto_caution = intval($HTTP_POST_VARS['cheat_auto_caution']);
	$zone_cheat_auto_freeable = intval($HTTP_POST_VARS['cheat_auto_freeable']);
	$zone_cheat_auto_cautionable = intval($HTTP_POST_VARS['cheat_auto_cautionable']);
	$zone_cheat_auto_punishment = intval($HTTP_POST_VARS['cheat_auto_punishment']);
	$zone_cheat_auto_public = intval($HTTP_POST_VARS['cheat_auto_public']);
	// verify empty fields
	if ( $att_bonus == '' || $att_bonus == '' )
		adr_previous( Field_empty , admin_adr_zone_general , '' );

	// update travel
	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$dead_travel' 
		WHERE config_name = 'zone_dead_travel' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not update travel table.", '', __LINE__, __FILE__, $sql);

	// update bonus
	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$stat_bonus' 
		WHERE config_name = 'zone_bonus_enable' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not update zone bonus table.", '', __LINE__, __FILE__, $sql);

	// update att
	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$att_bonus' 
		WHERE config_name = 'zone_bonus_att' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not update att bonus table.", '', __LINE__, __FILE__, $sql);

	// update def
	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$def_bonus' 
		WHERE config_name = 'zone_bonus_def' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not update def bonus table.", '', __LINE__, __FILE__, $sql);
	// Update Zone Cheat Member PM Setting
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_member_pm'
			WHERE config_name = 'zone_cheat_member_pm' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Member PM Setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone ADR Moderator Setting
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_adr_moderators'
			WHERE config_name = 'zone_adr_moderators' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone ADR Moderator Setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone NPC Display Text
	$sql = "UPDATE " . ADR_GENERAL_TABLE . "
		SET config_value = '$zone_npc_display_text'
		WHERE config_name = 'npc_display_text' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update  Zone NPC Display Text setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone NPC Image Link
	$sql = "UPDATE " . ADR_GENERAL_TABLE . "
		SET config_value = '$zone_npc_image_link'
		WHERE config_name = 'npc_image_link' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update NPC Image Link setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone NPC Button Link
	$sql = "UPDATE " . ADR_GENERAL_TABLE . "
		SET config_value = '$zone_npc_button_link'
		WHERE config_name = 'npc_button_link' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update NPC Button Link setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone NPC Display Enable
	$sql = "UPDATE " . ADR_GENERAL_TABLE . "
		SET config_value = '$npc_display_enable'
		WHERE config_name = 'npc_display_enable' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone NPC Display Enable setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone NPC Image Count
	$sql = "UPDATE " . ADR_GENERAL_TABLE . "
		SET config_value = '$zone_npc_image_count'
		WHERE config_name = 'npc_image_count' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone NPC Image Count setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone NPC Image Size
	$sql = "UPDATE " . ADR_GENERAL_TABLE . "
		SET config_value = '$zone_npc_image_size'
		WHERE config_name = 'npc_image_size' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone NPC Image Size setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Auto Ban ADR
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_ban_adr'
			WHERE config_name = 'zone_cheat_auto_ban_adr' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Auto Ban ADR setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Auto Ban Board
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_ban_board'
			WHERE config_name = 'zone_cheat_auto_ban_board' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Auto Ban Board setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Auto Jail
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_jail'
			WHERE config_name = 'zone_cheat_auto_jail' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Auto Jail setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Jail Day Setting
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_time_day'
			WHERE config_name = 'zone_cheat_auto_time_day' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Jail Day Setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Jail Hour Setting
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_time_hour'
			WHERE config_name = 'zone_cheat_auto_time_hour' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Jail Hour Setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Jail Minute Setting
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_time_minute'
			WHERE config_name = 'zone_cheat_auto_time_minute' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Jail Minute Setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Jail Caution Setting
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_caution'
			WHERE config_name = 'zone_cheat_auto_caution' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Jail Caution Setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Jail Freeable Setting
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_freeable'
			WHERE config_name = 'zone_cheat_auto_freeable' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Jail Freeable Setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Jail Cautionable Setting
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_cautionable'
			WHERE config_name = 'zone_cheat_auto_cautionable' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Jail Cautionable Setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Jail Punishment Setting
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_punishment'
			WHERE config_name = 'zone_cheat_auto_punishment' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Jail Punishment Setting.", '', __LINE__, __FILE__, $sql);

	// Update Zone Cheat Default Public Setting
	$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$zone_cheat_auto_public'
			WHERE config_name = 'zone_cheat_auto_public' ";
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, "Could not update Zone Cheat Default Public Setting.", '', __LINE__, __FILE__, $sql);

	// update Dynamic Zone Town Maps Enable
	$sql= "UPDATE ". CONFIG_TABLE . "
		SET config_value = '$zone_townmap_enable'
		WHERE config_name = 'Adr_zone_townmap_enable' ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not update Dynamic Zone Town Maps setting.", '', __LINE__, __FILE__, $sql);
	}

	// update Dynamic Zone Town Maps Name
	$sql= "UPDATE ". CONFIG_TABLE . "
		SET config_value = '$zone_townmap_name'
		WHERE config_name = 'Adr_zone_townmap_name' ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not update Dynamic Zone Town Maps Name setting.", '', __LINE__, __FILE__, $sql);
	}

	// update Dynamic Zone Town Maps Picture Link Enable
	$sql= "UPDATE ". CONFIG_TABLE . "
		SET config_value = '$zone_picture_link_enable'
		WHERE config_name = 'Adr_zone_picture_link' ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not update Dynamic Zone Town Maps setting.", '', __LINE__, __FILE__, $sql);
	}

	// update Dynamic Zone Town Maps World Map Zone
	$sql= "UPDATE ". CONFIG_TABLE . "
		SET config_value = '$zone_worldmap_zone'
		WHERE config_name = 'Adr_zone_worldmap_zone' ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not update Dynamic Zone Town Maps setting.", '', __LINE__, __FILE__, $sql);
	}

	// update Dynamic Zone Town Maps World Map Zone
	$sql= "UPDATE ". CONFIG_TABLE . "
		SET config_value = '$zone_townmap_display_required'
		WHERE config_name = 'Adr_zone_townmap_display_required' ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not update Dynamic Zone Town Maps setting.", '', __LINE__, __FILE__, $sql);
	}

	adr_update_general_config();
	adr_previous( Adr_zone_general_change_successful , admin_adr_zone_general , '' );
}

$sql = "SELECT * FROM  " . ADR_GENERAL_TABLE ;
if (!$result = $db->sql_query($sql))
	message_die(GENERAL_MESSAGE, 'Unable to get ADR General Settings', "", __LINE__, __FILE__, $sql);

while( $row = $db->sql_fetchrow($result) )
	$adr_general[$row['config_name']] = $row['config_value'];

$sql = "SELECT u.user_id , u.username , c.character_id FROM " . USERS_TABLE . " u
	LEFT JOIN " . ADR_CHARACTERS_TABLE . " c ON ( u.user_id = c.character_id AND c.character_class <> 0 )
	WHERE user_id > '1'
	ORDER BY username ";
if ( !$result = $db->sql_query($sql))
	message_die(GENERAL_ERROR, 'Could not obtain characters list', "", __LINE__, __FILE__, $sql);
$chars = $db->sql_fetchrowset($result);

$existing_pm_members = explode( ',' , $board_config['zone_cheat_member_pm'] );

$zone_cheat_member_pm_list = '<select name="zone_cheat_member_pm[] size="5" multiple>';
for($i = 0; $i < count($chars); $i++)
{
	if ( in_array( $chars[$i]['user_id'] , $existing_pm_members ) )
		$zone_cheat_member_pm_list .= '<option value = "'.$chars[$i]['user_id'].'" SELECTED class="post">' . $chars[$i]['username'] . '</option>';
	else
		$zone_cheat_member_pm_list .= '<option value = "'.$chars[$i]['user_id'].'" class="post">' . $chars[$i]['username'] . '</option>';
}
$zone_cheat_member_pm_list .= '</select>';

$existing_zone_adr_moderators = explode( ',' , $board_config['zone_adr_moderators'] );

$zone_moderators_list = '<select name="zone_adr_moderators[] size="5" multiple>';
for($i = 0; $i < count($chars); $i++)
{
	if ( in_array( $chars[$i]['user_id'] , $existing_zone_adr_moderators ) )
		$zone_moderators_list .= '<option value = "'.$chars[$i]['user_id'].'" SELECTED class="post">' . $chars[$i]['username'] . '</option>';
	else
		$zone_moderators_list .= '<option value = "'.$chars[$i]['user_id'].'" class="post">' . $chars[$i]['username'] . '</option>';
}
$zone_moderators_list .= '</select>';

$template->assign_vars(array(
	"ZONE_DEAD_TRAVEL" => ($board_config['zone_dead_travel'] ? 'CHECKED' : ''),
	"ZONE_BONUS_STAT" => ($board_config['zone_bonus_enable'] ? 'CHECKED' : ''),
	"ZONE_BONUS_ATT" => $board_config['zone_bonus_att'],
	"ZONE_BONUS_DEF" => $board_config['zone_bonus_def'],
	"ZONE_DYNAMIC_ZONE_MAPS" => ($board_config['Adr_zone_townmap_enable'] ? 'CHECKED' : ''),
	"ZONE_DYNAMIC_ZONE_MAPS_NAME" => $board_config['Adr_zone_townmap_name'],
	"ZONE_DYNAMIC_ZONE_MAPS_PICTURE_LINK" => ($board_config['Adr_zone_picture_link'] ? 'CHECKED' : ''),
	"ZONE_DYNAMIC_ZONE_MAPS_CURRENT_ZONE" => $existing_zone_worldmap_zone['zone_id'],
	"ZONE_DYNAMIC_ZONE_MAPS_CONFIG_ZONE" => $board_config['Adr_zone_worldmap_zone'],
	"ZONE_DYNAMIC_ZONE_MAPS_DISPLAY_REQUIRED" => ($board_config['Adr_zone_townmap_display_required'] ? 'CHECKED' : ''),
	"L_ZONE_DYNAMIC_ZONE_MAPS_DISPLAY_REQUIRED" => $lang['Adr_zone_acp_zone_dynamic_maps_display_required'],
	"L_ZONE_DYNAMIC_ZONE_MAPS_CURRENT_ZONE" => $lang['Adr_zone_acp_zone_dynamic_maps_current_zone'],
	"L_ZONE_DYNAMIC_ZONE_MAPS_CONFIG_ZONE" => $lang['Adr_zone_acp_zone_dynamic_maps_config_zone'],
	"L_ZONE_DYNAMIC_ZONE_MAPS" => $lang['Adr_zone_acp_enable_dynamic_zone_townmaps'],
	"L_ZONE_DYNAMIC_ZONE_MAPS_NAME" => $lang['Adr_zone_acp_world_map_name'],
	"L_ZONE_DYNAMIC_ZONE_MAPS_PICTURE_LINK" => $lang['Adr_zone_acp_picture_link'],
	"L_ZONE_GENERAL_TITLE" => $lang['Adr_zone_acp_general_title'],
	"L_ZONE_GENERAL_EXPLAIN" => $lang['Adr_zone_acp_general_explain'],
	"L_ZONE_DEAD_TRAVEL" => $lang['Adr_zone_acp_dead_travel'],
	"L_ZONE_BONUS_STAT" => $lang['Adr_zone_acp_bonus_stat'],
	"L_ZONE_BONUS_ATT" => $lang['Adr_zone_acp_bonus_att'],
	"L_ZONE_BONUS_DEF" => $lang['Adr_zone_acp_bonus_def'],
	"L_ZONE_SUBMIT" => $lang['Adr_zone_acp_submit'],
	"S_ZONE_ACTION" => append_sid("admin_adr_zone_general.$phpEx"),
	"ZONE_NPC_DISPLAY_ENABLE" => ($adr_general['npc_display_enable'] ? 'CHECKED' : ''),
	"ZONE_NPC_DISPLAY_TEXT" => ($adr_general['npc_display_text'] ? 'CHECKED' : ''),
	"ZONE_NPC_IMAGE_LINK" => ($adr_general['npc_image_link'] ? 'CHECKED' : ''),
	"ZONE_NPC_BUTTON_LINK" => ($adr_general['npc_button_link'] ? 'CHECKED' : ''),
	"ZONE_NPC_IMAGE_LINK" => ($adr_general['npc_image_link'] ? 'CHECKED' : ''),
	"ZONE_NPC_IMAGE_COUNT" => $adr_general['npc_image_count'],
	"ZONE_NPC_IMAGE_SIZE" => $adr_general['npc_image_size'],
	"ZONE_CHEAT_MEMBER_PM_LIST" => $zone_cheat_member_pm_list,
	"ZONE_MODERATORS_LIST" => $zone_moderators_list,
	"ZONE_CHEAT_AUTO_BAN_ADR" => ($board_config['zone_cheat_auto_ban_adr'] ? 'CHECKED' : ''),
	"ZONE_CHEAT_AUTO_BAN_BOARD" => ($board_config['zone_cheat_auto_ban_board'] ? 'CHECKED' : ''),
	"ZONE_CHEAT_AUTO_JAIL" => ($board_config['zone_cheat_auto_jail'] ? 'CHECKED' : ''),
	"ZONE_CHEAT_AUTO_TIME_DAY" => $board_config['zone_cheat_auto_time_day'],
	"ZONE_CHEAT_AUTO_TIME_HOUR" => $board_config['zone_cheat_auto_time_hour'],
	"ZONE_CHEAT_AUTO_TIME_MINUTE" => $board_config['zone_cheat_auto_time_minute'],
	"ZONE_CHEAT_AUTO_CAUTION" => $board_config['zone_cheat_auto_caution'],
	"ZONE_CHEAT_AUTO_FREEABLE" => ($board_config['zone_cheat_auto_freeable'] ? 'CHECKED' : ''),
	"ZONE_CHEAT_AUTO_CAUTIONABLE" => ($board_config['zone_cheat_auto_cautionable'] ? 'CHECKED' : ''),
	"ZONE_CHEAT_AUTO_PUNISHMENT_MAX_CHECKED" => ($board_config['zone_cheat_auto_punishment'] == '1' ? 'CHECKED' :'' ),
	"ZONE_CHEAT_AUTO_PUNISHMENT_MED_CHECKED" => ($board_config['zone_cheat_auto_punishment'] == '2' ? 'CHECKED' :'' ),
	"ZONE_CHEAT_AUTO_PUNISHMENT_MIN_CHECKED" => ($board_config['zone_cheat_auto_punishment'] == '3' ? 'CHECKED' :'' ),
	"ZONE_CHEAT_AUTO_PUBLIC" => ($board_config['zone_cheat_auto_public'] ? 'CHECKED' : ''),
	"L_ZONE_CHEAT_MEMBER_PM_LIST" => $lang['Adr_zone_cheat_member_pm'],
	"L_ZONE_MODERATORS_LIST" => $lang['Adr_zone_moderators'],
	"L_ZONE_NPC_TITLE" => $lang['Adr_zone_npc_title'],
	"L_ZONE_NPC_DISPLAY_ENABLE" => $lang['Adr_zone_npc_display_enable'],
	"L_ZONE_NPC_DISPLAY_TEXT" => $lang['Adr_zone_npc_display_text'],
	"L_ZONE_NPC_IMAGE_LINK" => $lang['Adr_zone_npc_image_link'],
	"L_ZONE_NPC_BUTTON_LINK" => $lang['Adr_zone_npc_button_link'],
	"L_ZONE_NPC_IMAGE_COUNT" => $lang['Adr_zone_npc_image_count'],
	"L_ZONE_NPC_IMAGE_SIZE" => $lang['Adr_zone_npc_image_size'],
	"L_ZONE_CHEAT_MEMBER_PM_LIST" => $lang['Adr_zone_cheat_member_pm'],
	"L_ZONE_MODERATORS_LIST" => $lang['Adr_zone_moderators'],
	"L_ZONE_CHEAT_TITLE" => $lang['Adr_zone_genral_cheat_log_title'],
	"L_ZONE_CHEAT_BAN_ADR" => $lang['Adr_zone_genral_cheat_log_ban_adr'],
	"L_ZONE_CHEAT_BAN_BOARD" => $lang['Adr_zone_genral_cheat_log_ban_board'],
	"L_ZONE_CHEAT_IMPRISONMENT" => $lang['Adr_zone_genral_cheat_log_impisonment'],
	"L_ZONE_CHEAT_IMPRISONMENT_TIME" => sprintf( $lang['Adr_zone_genral_cheat_log_auto_imprisonment'], $lang['Adr_cell_admin_time'], $lang['Adr_cell_admin_time_explain'] ),
	"L_ZONE_CHEAT_IMPRISONMENT_DAY" => $lang['Adr_cell_days'],
	"L_ZONE_CHEAT_IMPRISONMENT_HOUR" => $lang['Adr_cell_hours'],
	"L_ZONE_CHEAT_IMPRISONMENT_MINUTE" => $lang['Adr_cell_minutes'],
	"L_ZONE_CHEAT_IMPRISONMENT_CAUTION" => sprintf( $lang['Adr_zone_genral_cheat_log_auto_imprisonment'], $lang['Adr_cell_admin_caution'], $lang['Adr_cell_admin_caution_explain'] ),
	"L_ZONE_CHEAT_IMPRISONMENT_FREEABLE" => sprintf( $lang['Adr_zone_genral_cheat_log_auto_imprisonment'], $lang['Adr_cell_freeable'], $lang['Adr_cell_freeable_explain'] ),
	"L_ZONE_CHEAT_IMPRISONMENT_CAUTIONABLE" => sprintf( $lang['Adr_zone_genral_cheat_log_auto_imprisonment'], $lang['Adr_cell_cautionnable'], $lang['Adr_cell_cautionnable_explain'] ),
	"L_ZONE_CHEAT_IMPRISONMENT_PUNISHMENT" => $lang['Adr_cell_admin_punishment'],
	"L_ZONE_CHEAT_IMPRISONMENT_PUNISHMENT_GLOBAL" => $lang['Adr_cell_admin_punishment_global'],
	"L_ZONE_CHEAT_IMPRISONMENT_PUNISHMENT_POSTS" => $lang['Adr_cell_admin_punishment_posts'],
	"L_ZONE_CHEAT_IMPRISONMENT_PUNISHMENT_READ" => $lang['Adr_cell_admin_punishment_read'],
	"L_ZONE_CHEAT_AUTO_PUBLIC" => $lang['Adr_zone_genral_cheat_log_auto_public'],
));

$template->pparse("body");
include_once('./page_footer_admin.'.$phpEx);

?>