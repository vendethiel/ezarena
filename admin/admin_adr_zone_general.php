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

if ($submit)
{
	$dead_travel = intval($HTTP_POST_VARS['dead_travel']);
	$stat_bonus = intval($HTTP_POST_VARS['stat_bonus']);
	$att_bonus = $HTTP_POST_VARS['att_bonus'];
	$def_bonus = $HTTP_POST_VARS['def_bonus'];

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

	adr_previous( Adr_zone_general_change_successful , admin_adr_zone_general , '' );
}

$template->assign_vars(array(
	"ZONE_DEAD_TRAVEL" => ($board_config['zone_dead_travel'] ? 'CHECKED' : ''),
	"ZONE_BONUS_STAT" => ($board_config['zone_bonus_enable'] ? 'CHECKED' : ''),
	"ZONE_BONUS_ATT" => $board_config['zone_bonus_att'],
	"ZONE_BONUS_DEF" => $board_config['zone_bonus_def'],
	"L_ZONE_GENERAL_TITLE" => $lang['Adr_zone_acp_general_title'],
	"L_ZONE_GENERAL_EXPLAIN" => $lang['Adr_zone_acp_general_explain'],
	"L_ZONE_DEAD_TRAVEL" => $lang['Adr_zone_acp_dead_travel'],
	"L_ZONE_BONUS_STAT" => $lang['Adr_zone_acp_bonus_stat'],
	"L_ZONE_BONUS_ATT" => $lang['Adr_zone_acp_bonus_att'],
	"L_ZONE_BONUS_DEF" => $lang['Adr_zone_acp_bonus_def'],
	"L_ZONE_SUBMIT" => $lang['Adr_zone_acp_submit'],
	"S_ZONE_ACTION" => append_sid("admin_adr_zone_general.$phpEx"))
);

$template->pparse("body");
include_once('./page_footer_admin.'.$phpEx);

?>