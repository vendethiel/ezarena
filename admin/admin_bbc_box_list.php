<?php
/***************************************************************************
 * admin_bbc_box_list.php
 * ----------------------
 * begin	: 10/06/2005
 * copyright	: reddog - http://www.reddevboard.com
 * version	: 0.0.6 - 06/10/2005
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
	$module['BBcode_Box']['bbc_box_b_list'] = "$file";
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.'.$phpEx);
include($phpbb_root_path . 'language/lang_' . $userdata['user_lang'] . '/lang_bbc_box.'.$phpEx);

//
// constants
//
$auths = array(
	AUTH_ALL => $lang['Forum_ALL'],
	AUTH_REG => $lang['Forum_REG'],
	AUTH_MOD => $lang['Forum_MOD'],
	AUTH_ADMIN => $lang['Forum_ADMIN'],
);

$params = array('perms' => 'perms');
while( list($var, $param) = @each($params) )
{
	if ( !empty($HTTP_POST_VARS[$param]) || !empty($HTTP_GET_VARS[$param]) )
	{
		$$var = ( !empty($HTTP_POST_VARS[$param]) ) ? $HTTP_POST_VARS[$param] : $HTTP_GET_VARS[$param];
	}
	else
	{
		$$var = "";
	}
}
$perms = intval($perms);

//
// Pull all bbc_box config data
//
$sql = 'SELECT *
	FROM ' . BBC_BOX_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query bbc_box config information", "", __LINE__, __FILE__, $sql);
}
else
{
	$i = 0;
	while( $row = $db->sql_fetchrow($result) )
	{		
		$bbc_id = $row['bbc_id'];
		$bbc_name = $row['bbc_name'];
		$bbc_value = $row['bbc_value'];
		$bbc_auth = $row['bbc_auth'];
		$bbc_name_auth = $row['bbc_name'] . '_auth';

		$default_bbc[$bbc_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $bbc_value) : $bbc_value;
		$new[$bbc_name] = ( isset($HTTP_POST_VARS[$bbc_name]) ) ? $HTTP_POST_VARS[$bbc_name] : $default_bbc[$bbc_name];

		$default_auth[$bbc_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $bbc_auth) : $bbc_auth;
		$new_auth[$bbc_name] = ( isset($HTTP_POST_VARS[$bbc_name_auth]) ) ? $HTTP_POST_VARS[$bbc_name_auth] : $default_auth[$bbc_name];

		// prepare auth level list
		$bbc_s_auths = '';
		foreach ( $auths as $key => $data )
		{
			$selected = ($bbc_auth == $key) ? ' selected="selected"' : '';
			$bbc_s_auths .= sprintf('<option value="%s"%s>%s</option>', $key, $selected, $data);
		}
		$bbc_s_auths = sprintf('<select name="%s_auth">%s</select>', $bbc_name, $bbc_s_auths);
	
		$i++;
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	
		$template->assign_block_vars('bbc_list', array(
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'ROW_ID' => (($i-1)*2),
			'BBC_ID' => $bbc_id,
			'BBC_NAME' => $bbc_name,
			'BBC_LANG' => isset($lang['bbcbxr_desc'][$bbc_name]) ? $lang['bbcbxr_desc'][$bbc_name] : $bbc_name,
			'BBC_IMG' => $images[$row['bbc_img']],
		));
		
		if ( !$perms )
		{
			$template->assign_block_vars('bbc_list.act', array(
				'BBC_BOX_YES' => ( $new[$bbc_name] ) ? 'checked="checked"' : '',
				'BBC_BOX_NO' => ( !$new[$bbc_name] ) ? 'checked="checked"' : '',
			));
		}
		else
		{
			$template->assign_block_vars('bbc_list.perms', array(
				'BBC_S_AUTHS' => $bbc_s_auths,
			));
		}

		if( isset($HTTP_POST_VARS['submit']) && $default_bbc[$bbc_name] != $new[$bbc_name] )
		{
			$perms = 1;
			$sql = "UPDATE " . BBC_BOX_TABLE . " SET
				bbc_value = '" . str_replace("\'", "''", $new[$bbc_name]) . "'
				WHERE bbc_name = '$bbc_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for $bbc_name", "", __LINE__, __FILE__, $sql);
			}
		}
		if( isset($HTTP_POST_VARS['submit']) && $default_auth[$bbc_name] != $new_auth[$bbc_name] )
		{
			$sql = "UPDATE " . BBC_BOX_TABLE . " SET
				bbc_auth = '" . str_replace("\'", "''", $new_auth[$bbc_name]) . "'
				WHERE bbc_name = '$bbc_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for $bbc_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		cache_bbc_box();
		bbc_time_regen('bbc_time_regen');

		$perms_switch = ( empty($perms) ) ? 1 : 0;

		$message = $lang['bbc_box_updated'] . '<br /><br />' . sprintf($lang['bbc_box_return'], '<a href="' . append_sid('admin_bbc_box_list.'.$phpEx.'?perms='.$perms_switch) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.'.$phpEx.'?pane=right') . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);
	}
}

//
// Mode switch
//
$perms_switch = ( empty($perms) ) ? 1 : 0;
$switch_mode = append_sid('admin_bbc_box_list.'.$phpEx.'?perms='.$perms_switch);
$switch_mode_text = ( empty($perms) ) ? $lang['bbc_perms_mode'] : $lang['bbc_act_mode'];
$u_switch_mode = '<a href="' . $switch_mode . '" title="' . sprintf($lang['bbc_go_to'], $switch_mode_text) . '">' . $switch_mode_text . '</a>';

if ( !$perms )
{
	$template->assign_block_vars('act_options', array());
}

//
// Generate the page
//
$template->assign_vars(array(
	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_BBC_BOX_TITLE' => $lang['bbc_box_title'],
	'L_BBC_BOX_EXPLAIN' => $lang['bbc_box_explain'],
	'L_BBC_BOX_LIST' => $lang['bbc_box_list'],
	'L_BUTTON_SWITCH' => $lang['Button_switch'],
	'L_SUBMIT' => $lang['Submit'], 
	'L_RESET' => $lang['Reset'],
	'L_ENABLE_ALL' => $lang['Enable_all'],
	'L_DISABLE_ALL' => $lang['Disable_all'],

	'BBC_HOVERBG_IMG' => $images['bbc_hoverbg'],
	'BBC_BG_IMG' => $images['bbc_bg'],

	'U_SWITCH_MODE' => $u_switch_mode,
	'U_BBC_BOX_LIST' => append_sid('admin_bbc_box_list.'.$phpEx),

	'S_HIDDEN_FIELDS' => $s_hidden_fields,
	'S_BBC_BOX_ACTION' => append_sid('admin_bbc_box_list.'.$phpEx),
));

// send the display
$template->set_filenames(array('body' => 'admin/bbc_box_list_body.tpl'));
$template->pparse('body');
include('./page_footer_admin.'.$phpEx);

?>