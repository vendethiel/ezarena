<?php
/***************************************************************************
*                              admin_adr_time.php
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
define('IN_ADR_TIME', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_CHARACTER', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ADR-Zones']['Time'] = $filename;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

adr_template_file('admin/config_adr_time_body.tpl');

//time list
$time[1] = $lang['Adr_Time_1'];
$time[2] = $lang['Adr_Time_2'];
$time[3] = $lang['Adr_Time_3'];
$time[4] = $lang['Adr_Time_4'];

$time_list = '<select name="time">';
for( $i = 1; $i < 5; $i++ )
{
	$selected = ( $i == $board_config['adr_time'] ) ? ' selected="selected"' : '';
	$time_list .= '<option value = "'.$i.'" '.$selected.' >' . $time[$i] . '</option>';
}
$time_list .= '</select>';

$submit = isset($HTTP_POST_VARS['submit']);

if ($submit)
{
	$new_time = trim(str_replace('"', '&quot;', $HTTP_POST_VARS['time']));
	$time_time = ( intval($HTTP_POST_VARS['time_time']) * 21600 );

	// verify empty fields
	if ( $time_time == '' )
		adr_previous( Adr_time_empty , admin_adr_time , '' );

	// update time
	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$new_time' 
		WHERE config_name = 'adr_time' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not acces time table.", '', __LINE__, __FILE__, $sql);

	$sql= "UPDATE ". CONFIG_TABLE . " 
		SET config_value = '$time_time' 
		WHERE config_name = 'adr_lenght_time' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not access time table.", '', __LINE__, __FILE__, $sql);

	adr_previous( Adr_time_change_successful , admin_adr_time , '' );
}

$template->assign_vars(array(
	"TIME_LIST" => $time_list,
	"TIME_TIME" => floor($board_config['adr_lenght_time'] / 21600),
	"L_TIME_TITLE" => $lang['Adr_time_acp_title'],
	"L_TIME_EXPLAIN" => $lang['Adr_time_acp_explain'],
	"L_TIME_CONFIG" => $lang['Adr_time_acp_config'],
	"L_TIME_CHOICE" => $lang['Adr_time_acp_choice'],
	"L_TIME_TIME" => $lang['Adr_time_acp_time'],
	"L_TIME_DAYS" => $lang['Adr_time_acp_days'],
	"L_TIME_SUBMIT" => $lang['Adr_time_acp_submit'],
	"S_TIME_ACTION" => append_sid("admin_adr_time.$phpEx"))
);

$template->pparse("body");
include_once('./page_footer_admin.'.$phpEx);

?>