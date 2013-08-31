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
define('IN_ADR_SEASONS', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_CHARACTER', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ADR-Zones']['Seasons'] = $filename;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

adr_template_file('admin/config_adr_seasons_body.tpl');

//season list
$season[1] = $lang['Adr_Season_1'];
$season[2] = $lang['Adr_Season_2'];
$season[3] = $lang['Adr_Season_3'];
$season[4] = $lang['Adr_Season_4'];

$season_list = '<select name="season">';
for( $i = 1; $i < 5; $i++ )
{
	$selected = ( $i == $board_config['adr_seasons'] ) ? ' selected="selected"' : '';
	$season_list .= '<option value = "'.$i.'" '.$selected.' >' . $season[$i] . '</option>';
}
$season_list .= '</select>';

$submit = isset($HTTP_POST_VARS['submit']);

if ($submit)
{
	$new_season = trim(str_replace('"', '&quot;', $HTTP_POST_VARS['season']));
	$season_time = ( intval($HTTP_POST_VARS['season_time']) * 86400 );

	// verify empty fields
	if ( $season_time == '' )
		adr_previous( Adr_season_empty , admin_adr_seasons , '' );

	// update season
	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$new_season' 
		WHERE config_name = 'adr_seasons' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not acces seasons table.", '', __LINE__, __FILE__, $sql);

	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$season_time' 
		WHERE config_name = 'adr_seasons_time' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not acces seasons table.", '', __LINE__, __FILE__, $sql);

	adr_previous( Adr_season_change_successful , admin_adr_seasons , '' );
}

$template->assign_vars(array(
	"SEASON_LIST" => $season_list,
	"SEASON_TIME" => floor($board_config['adr_seasons_time'] / 86400),
	"L_SEASONS_TITLE" => $lang['Adr_seasons_acp_title'],
	"L_SEASONS_EXPLAIN" => $lang['Adr_seasons_acp_explain'],
	"L_SEASONS_CONFIG" => $lang['Adr_seasons_acp_config'],
	"L_SEASON_CHOICE" => $lang['Adr_seasons_acp_choice'],
	"L_SEASON_TIME" => $lang['Adr_seasons_acp_time'],
	"L_SEASON_DAYS" => $lang['Adr_seasons_acp_days'],
	"L_SEASON_SUBMIT" => $lang['Adr_seasons_acp_submit'],
	"S_SEASON_ACTION" => append_sid("admin_adr_seasons.$phpEx"))
);

$template->pparse("body");
include_once('./page_footer_admin.'.$phpEx);

?>