<?php
/***************************************************************************
 * admin_bbc_box_settings.php
 * --------------------------
 * begin	: 12/06/2005
 * copyright	: reddog - http://www.reddevboard.com
 * version	: 0.0.4 - 09/10/2005
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

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['BBcode_Box']['bbc_box_a_settings'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.'.$phpEx);
include($phpbb_root_path . 'language/lang_' . $userdata['user_lang'] . '/lang_bbc_box.'.$phpEx);

// ------------------
// Begin function block
//
// this one was inspirated by Ptirhiik's function date from categories hierarchy 2.1.x
// used here to ensure "today at/yesterday at" compliancy, the previous function bbc_date_format
// showed a double "today at/yesterday at" while using bbcode box reloaded with categories hierarchy.
function bbc_date_format($config_field)
{
	global $db, $board_config, $lang;

	// fix parms with default
	$fmt = $board_config['default_dateformat'];
	$time = (!empty($config_field)) ? $config_field : time();

	// get config timezone & dst
	$time_zone = (intval($board_config['board_timezone']) + intval($board_config['dstime'])) * 3600;

	// get date standard format
	$d_day = $time + $time_zone;
	$res = @gmdate($fmt, $d_day);

	// get current day
	$now = time() + $time_zone;
	$today = @gmmktime(0, 0, 0, @gmdate('m', $now), @gmdate('d', $now), @gmdate('Y', $now));

	// is the d day between yesterday and today ?
	if ( ($d_day >= $today - 86400) && ($d_day < $today + 86400) )
	{
		// get new fmt for time and compute
		$new_fmt = sprintf(strpos(' ' . $fmt, 'h') ? 'h%s a' : (strpos(' ' . $fmt, 'H') ? 'H%s' : (strpos(' '. $fmt, 'g') ? 'g%s a' : (strpos(' ' . $fmt, 'G') ? 'G%s' : ''))), strpos(' ' . $fmt, 's') ? ':i:s' : ':i');
		$res = sprintf((($d_day >= $today) ? $lang['bbc_today_at'] : $lang['bbc_yesterday_at']), @gmdate($new_fmt, $time + $time_zone));
	}
	return strtr($res, $lang['datetime']);
}

// function _button() from CH 2.1.x by Ptirhiik
function _bbcbutton($var)
{
	global $HTTP_POST_VARS, $HTTP_GET_VARS;

	// image buttons return an _x and _y value in the $_POST array
	if ( isset($HTTP_POST_VARS[$var . '_x']) && isset($HTTP_POST_VARS[$var . '_y']) )
	{
		$HTTP_POST_VARS[$var] = true;
		unset($HTTP_POST_VARS[$var . '_x']);
		unset($HTTP_POST_VARS[$var . '_y']);
	}
	return (isset($HTTP_POST_VARS[$var]) && !empty($HTTP_POST_VARS[$var])) || (isset($HTTP_GET_VARS[$var]) && intval($HTTP_GET_VARS[$var]));
}
//
// End function block
// ------------------

//
// Pull all config data
//
$sql = 'SELECT *
	FROM ' . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query caches config information", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if( _bbcbutton('submit') && $default_config[$config_name] != $new[$config_name] )
		{
			$bbc_advanced = $new['bbc_advanced'];

			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( _bbcbutton('submit') )
	{
		if($default_config['bbc_advanced'] != $new['bbc_advanced'])
		{
			$template->assign_block_vars('left_refresh', array(
				'ACTION' => append_sid('index.'.$phpEx.'?pane=left')
			));
		}

		$message = $lang['bbc_settings_updated'] . '<br /><br />' . sprintf($lang['bbc_click_return_settings'], '<a href="' . append_sid('admin_bbc_box_settings.'.$phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.'.$phpEx.'?pane=right') . '">', '</a>');

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $lang['Information'],
			'MESSAGE_TEXT' => $message,
		));

		// send the display
		$template->set_filenames(array('body' => 'admin/bbc_box_message_body.tpl'));
		$template->pparse('body');
		include('./page_footer_admin.'.$phpEx);
	}
}

// display bbc style
if( isset($HTTP_POST_VARS['bbc_syle_prev']) )
{
	$bbc_style = $HTTP_POST_VARS['bbc_style_path'];
}
$bbc_style = ( isset($HTTP_POST_VARS['bbc_style_path']) ) ? $HTTP_POST_VARS['bbc_style_path'] : $default_config['bbc_style_path'];
display_bbc_style($bbc_style);
$new['bbc_style_path'] = $bbc_style;

// mode selection (beginner or advanced)
$bbc_mode_select_adv = ( $new['bbc_advanced'] ) ? 'checked="checked"' : '';
$bbc_mode_select_bgn = ( !$new['bbc_advanced'] ) ? 'checked="checked"' : '';

// switch on/off (buttons)
$bbc_switch_on = ( $new['bbc_box_on'] ) ? 'checked="checked"' : '';
$bbc_switch_off = ( !$new['bbc_box_on'] ) ? 'checked="checked"' : '';

// regen cache
if( _bbcbutton('regen_bbc_cache') )
{
	cache_bbc_box();
	bbc_time_regen('bbc_time_regen');	

	$message = $lang['bbc_cache_updated'] . '<br /><br />' . sprintf($lang['bbc_click_return_settings'], '<a href="' . append_sid('admin_bbc_box_settings.'.$phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.'.$phpEx.'?pane=right') . '">', '</a>');

	message_die(GENERAL_MESSAGE, $message);
}

// generate bbc date format
$l_bbc_time_regen = (!empty($board_config['mod_cat_hierarchy'])) ? create_date($board_config['default_dateformat'], $board_config['bbc_time_regen'], $board_config['board_timezone']) : bbc_date_format($board_config['bbc_time_regen']);

//
// Generate the page
//
$template->assign_vars(array(
	'S_BBC_SETTINGS_ACTION' => append_sid('admin_bbc_box_settings.'.$phpEx),

	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_BBC_SETTINGS_TITLE' => $lang['bbc_settings_title'],
	'L_BBC_SETTINGS_EXPLAIN' => $lang['bbc_settings_explain'],
	'L_BBC_SETTINGS_ADJUST' => $lang['bbc_settings_adjust'],
	'L_BBC_SETTINGS_CACHE' => $lang['bbc_settings_cache'],
	'L_LAST_REGEN' => $lang['bbc_last_regen'],
	'L_REGEN' => $lang['bbc_regen'],
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],

	'I_REGEN' => $phpbb_root_path . $images['bbc_regen'],
	'I_SUBMIT' => $phpbb_root_path . $images['bbc_submit'],

	// cache
	'L_BBC_CACHE' => $lang['bbc_box_cache'],
	'L_BBC_TIME_REGEN' => (!$board_config['bbc_time_regen']) ? $lang['Acc_None'] : $l_bbc_time_regen,
	
	// bbc per row
	'L_BBC_PER_ROW' => $lang['bbc_per_row'],
	'L_BBC_PER_ROW_EXPLAIN' => $lang['bbc_per_row_explain'],
	'BBC_PER_ROW' => $new['bbc_per_row'],
	
	// mode advanced
	'L_BBC_MODE_SELECT' => $lang['bbc_mode_select'],
	'L_BBC_MODE_SELECT_EXPLAIN' => $lang['bbc_mode_select_explain'],
	'L_BBC_ADVANCED' => $lang['bbc_advanced'],
	'L_BBC_BEGINNER' => $lang['bbc_beginner'],
	'BBC_MODE_SELECT_ADV' => $bbc_mode_select_adv,
	'BBC_MODE_SELECT_BGN' => $bbc_mode_select_bgn,
	
	// switch on/off
	'L_BBC_SWITCH_SELECT' => $lang['bbc_switch_select'],
	'L_BBC_SWITCH_SELECT_EXPLAIN' => $lang['bbc_switch_select_explain'],
	'BBC_SWITCH_ON' => $bbc_switch_on,
	'BBC_SWITCH_OFF' => $bbc_switch_off,
));

// send the display
$template->set_filenames(array('body' => 'admin/bbc_box_settings_body.tpl'));
$template->pparse('body');
include('./page_footer_admin.'.$phpEx);

?>