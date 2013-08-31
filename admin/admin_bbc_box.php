<?php
/***************************************************************************
 * admin_bbc_box.php
 * -----------------
 * begin	: 12/06/2005
 * copyright	: reddog - http://www.reddevboard.com
 * version	: 0.0.3 - 09/10/2005
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
	if ($board_config['bbc_advanced'])
	{
		$file = basename(__FILE__);
		$module['BBcode_Box']['bbc_box_c_manage'] = "$file";
	}
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'language/lang_' . $userdata['user_lang'] . '/lang_bbc_box.' . $phpEx);

if( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else 
{
	//
	// These could be entered via a form button
	//
	if( isset($HTTP_POST_VARS['add']) )
	{
		$mode = "add";
	}
	else if( isset($HTTP_POST_VARS['save']) )
	{
		$mode = "save";
	}
	else
	{
		$mode = "";
	}
}


if( $mode != "" )
{
	if( $mode == "edit" || $mode == "add" )
	{
		//
		// add a new bbcode, show the form.
		//
		$bbc_id = ( isset($HTTP_GET_VARS['id']) ) ? intval($HTTP_GET_VARS['id']) : 0;
		
		$s_hidden_fields = '';
		
		if( $mode == "edit" )
		{
			if( empty($bbc_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['bbc_must_select']);
			}

			$sql = 'SELECT * FROM ' . BBC_BOX_TABLE . '
				WHERE bbc_id = ' . $bbc_id;
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't obtain bbc_box data", "", __LINE__, __FILE__, $sql);
			}
			$bbc_info = $db->sql_fetchrow($result);

			$s_hidden_fields .= '<input type="hidden" name="id" value="' . $bbc_id . '" />';

			$bbc_tmp_order = $bbc_info['bbc_order'];
			$bbc_list_order = bbc_get_list('bbc_order', $bbc_id, $bbc_tmp_order, true);

			$s_hidden_fields .= '<input type="hidden" name="bbc_tmp_order" value="' . $bbc_tmp_order . '" />';

			$template->assign_block_vars('edit', array(
				'L_BBC_EDIT_TITLE' => sprintf($lang['bbc_edit_title'], $bbc_info['bbc_name']),
				'L_BBC_EDIT_TEXT' => $lang['bbc_edit_explain'],
				'L_BBC_EDIT_RULES' => $lang['bbc_edit_rules'],
				'L_BBC_BEFORE_EDIT_EXPLAIN' => sprintf($lang['bbc_before_edit_explain'], $bbc_info['bbc_before']),
				'L_BBC_AFTER_EDIT_EXPLAIN' => sprintf($lang['bbc_after_edit_explain'], $bbc_info['bbc_after']),)
			);
		}
		else
		{
			$sql = 'SELECT bbc_id, bbc_order FROM ' . BBC_BOX_TABLE . '
				ORDER BY bbc_order DESC
				LIMIT 1';
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't obtain last bbc_order", "", __LINE__, __FILE__, $sql);
			}
			$bbc_info = $db->sql_fetchrow($result);

			$bbc_last_id = $bbc_info['bbc_id'];
			$bbc_info['bbc_divider'] = 0;
			$bbc_tmp_order = $bbc_info['bbc_order'];
			$s_hidden_fields .= '<input type="hidden" name="bbc_tmp_order" value="' . $bbc_tmp_order . '" />';

			$bbc_tmp_order += 10;
			$bbc_list_order = bbc_get_list('bbc_order', $bbc_last_id, $bbc_tmp_order, 0);

			$template->assign_block_vars('add', array(
				'L_BBC_ADD_TITLE' => $lang['bbc_add_title'],
				'L_BBC_ADD_TEXT' => $lang['bbc_add_explain'],
				'L_BBC_ADD_RULES' => $lang['bbc_add_rules'])
			);
		}

		$s_hidden_fields .= '<input type="hidden" name="mode" value="save" />';

		$bbc_is_divider = ( $bbc_info['bbc_divider'] ) ? 'checked="checked"' : '';
		$bbc_is_not_divider = ( !$bbc_info['bbc_divider'] ) ? 'checked="checked"' : '';
		
		$template->set_filenames(array('body' => 'admin/bbc_box_edit_body.tpl'));

		$template->assign_vars(array(
			'BBC_NAME' => $bbc_info['bbc_name'],
			'BBC_DIVIDER' => $bbc_is_divider,
			'BBC_NOT_DIVIDER' => $bbc_is_not_divider,
			'BBC_BEFORE' => $bbc_info['bbc_before'],
			'BBC_AFTER' => $bbc_info['bbc_after'],
			'BBC_HELPLINE' => $bbc_info['bbc_helpline'],
			'BBC_IMG' => $bbc_info['bbc_img'],

			'L_BBC_NAME' => $lang['bbc_name'],
			'L_BBC_NAME_EXPLAIN' => $lang['bbc_name_explain'],
			'L_BBC_BEFORE' => $lang['bbc_before'],
			'L_BBC_BEFORE_EXPLAIN' => $lang['bbc_before_explain'],
			'L_BBC_AFTER' => $lang['bbc_after'],
			'L_BBC_AFTER_EXPLAIN' => $lang['bbc_after_explain'],
			'L_BBC_HELPLINE' => $lang['bbc_helpline'],
			'L_BBC_HELPLINE_EXPLAIN' => $lang['bbc_helpline_explain'],
			'L_BBC_IMG' => $lang['bbc_img'],
			'L_BBC_IMG_EXPLAIN' => $lang['bbc_img_explain'],
			'L_BBC_DIVIDER' => $lang['bbc_divider'],
			'L_BBC_DIVIDER_EXPLAIN' => $lang['bbc_divider_explain'],
			'L_BBC_MOVE_AFTER' => $lang['bbc_move_after'],
			'L_SUBMIT' => $lang['Submit'],
			'L_RESET' => $lang['Reset'],
			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			
			'S_BBC_LIST_ORDER' => $bbc_list_order,
			'S_BBC_BOX_ACTION' => append_sid('admin_bbc_box.'.$phpEx),
			'S_HIDDEN_FIELDS' => $s_hidden_fields)
		);
		
	}
	else if( $mode == "save" )
	{
		//
		// Ok, they sent us our info, let's update it.
		//
		
		$bbc_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : 0;
		$bbc_name = ( isset($HTTP_POST_VARS['bbc_name']) ) ? trim($HTTP_POST_VARS['bbc_name']) : '';
		$bbc_value = 1;
		$bbc_auth = 0;
		$bbc_before = ( isset($HTTP_POST_VARS['bbc_before']) ) ? trim($HTTP_POST_VARS['bbc_before']) : '';
		$bbc_after = ( isset($HTTP_POST_VARS['bbc_after']) ) ? trim($HTTP_POST_VARS['bbc_after']) : '';
		$bbc_helpline = ( isset($HTTP_POST_VARS['bbc_helpline']) ) ? trim($HTTP_POST_VARS['bbc_helpline']) : '';
		$bbc_img = ( isset($HTTP_POST_VARS['bbc_img']) ) ? trim($HTTP_POST_VARS['bbc_img']) : '';
		$bbc_divider = ( $HTTP_POST_VARS['bbc_divider'] == 1 ) ? TRUE : 0;

		$bbc_tmp_order = ( isset($HTTP_POST_VARS['bbc_tmp_order']) ) ? intval($HTTP_POST_VARS['bbc_tmp_order']) : 0;
		$bbc_order = ( isset($HTTP_POST_VARS['bbc_order']) ) ? ( intval($HTTP_POST_VARS['bbc_order']) + 1 ) : $bbc_tmp_order;

		if( $bbc_name == '' || $bbc_before == '' || $bbc_after == '' || $bbc_helpline == '' || $bbc_img == '' )
		{
			$message = $lang['bbc_must_fill'] . '<br /><br />' . sprintf($lang['bbc_click_return'], '<a href="javascript:history.back();">', '</a>');

			message_die(GENERAL_MESSAGE, $message);
		}

		if ($bbc_id)
		{
			$sql = 'UPDATE ' . BBC_BOX_TABLE . '
				SET bbc_name = \'' . str_replace("\'", "''", $bbc_name) . '\', bbc_before = \'' . str_replace("\'", "''", $bbc_before) . '\', bbc_after = \'' . str_replace("\'", "''", $bbc_after) . '\', bbc_helpline = \'' . str_replace("\'", "''", $bbc_helpline) . '\', bbc_img = \'' . str_replace("\'", "''", $bbc_img) . '\', bbc_divider = ' . $bbc_divider . ', bbc_order = ' . $bbc_order . '
				WHERE bbc_id = ' . $bbc_id;

			$message = $lang['bbc_updated'];
		}
		else
		{
			$bbc_new_order = $bbc_order - 1;
			$bbc_order = ($bbc_tmp_order == $bbc_new_order) ? $bbc_order + 9 : $bbc_order;

			$sql = 'INSERT INTO ' . BBC_BOX_TABLE . ' (bbc_name, bbc_value, bbc_auth, bbc_before, bbc_after, bbc_helpline, bbc_img, bbc_divider, bbc_order)
				VALUES (\'' . str_replace("\'", "''", $bbc_name) . '\', ' . $bbc_value . ', ' . $bbc_auth . ', \'' . str_replace("\'", "''", $bbc_before) . '\', \'' . str_replace("\'", "''", $bbc_after) . '\', \'' . str_replace("\'", "''", $bbc_helpline) . '\', \'' . str_replace("\'", "''", $bbc_img) . '\', ' . $bbc_divider . ', ' . $bbc_order . ')';

			$bbc_order = ($bbc_tmp_order == $bbc_new_order) ? $bbc_tmp_order : $bbc_order;
			$message = $lang['bbc_added'];
		}
		
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update/insert into bbc_box table", "", __LINE__, __FILE__, $sql);
		}

		// renum order
		if ( $bbc_order != $bbc_tmp_order )
		{
			$sql = 'SELECT bbc_id
				FROM ' . BBC_BOX_TABLE . '
				ORDER BY bbc_order';
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't obtain bbc_ids list", "", __LINE__, __FILE__, $sql);
			}

			$inc = 0;
			while ( $row = $db->sql_fetchrow($result) )
			{
				$inc += 10;
				$sql = 'UPDATE ' . BBC_BOX_TABLE . '
					SET bbc_order = ' . $inc . '
					WHERE bbc_id = ' . $row['bbc_id'];
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}
		}

		cache_bbc_box();
		bbc_time_regen('bbc_time_regen');

		$message .= '<br /><br />' . sprintf($lang['bbc_click_return_manage'], '<a href="' . append_sid('admin_bbc_box.'.$phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.'.$phpEx.'?pane=right') . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);

	}
	else if( $mode == "delete" )
	{
		//
		// Ok, ready to delete the bbcode
		//
		
		if( isset($HTTP_POST_VARS['id']) || isset($HTTP_GET_VARS['id']) )
		{
			$bbc_id = ( isset($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);
		}
		else
		{
			$bbc_id = 0;
		}
		
		if( $bbc_id )
		{
			$sql = 'DELETE FROM ' . BBC_BOX_TABLE . '
				WHERE bbc_id = ' . $bbc_id;
			
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete bbc_box data", "", __LINE__, __FILE__, $sql);
			}

			// renum order
			$sql = 'SELECT bbc_id
				FROM ' . BBC_BOX_TABLE . '
				ORDER BY bbc_order';
			if(!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Couldn't obtain bbc_ids list", "", __LINE__, __FILE__, $sql);
			}

			$inc = 0;
			while ( $row = $db->sql_fetchrow($result) )
			{
				$inc += 10;
				$sql = 'UPDATE ' . BBC_BOX_TABLE . '
					SET bbc_order = ' . $inc . '
					WHERE bbc_id = ' . $row['bbc_id'];
				$db->sql_query($sql, false, __LINE__, __FILE__);
			}

			cache_bbc_box();
			bbc_time_regen('bbc_time_regen');

			$message = $lang['bbc_removed'] . '<br /><br />' . sprintf($lang['bbc_click_return_manage'], '<a href="' . append_sid('admin_bbc_box.'.$phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.'.$phpEx.'?pane=right') . '">', '</a>');

			message_die(GENERAL_MESSAGE, $message);

		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['bbc_must_select']);
		}
	}
	else
	{
		//
		// They didn't feel like giving us any information. Oh, too bad, we'll just display the
		// list then...
		//
		$template->set_filenames(array('body' => 'admin/bbc_box_body.tpl'));
		
		$sql = 'SELECT * FROM ' . BBC_BOX_TABLE . '
			ORDER BY bbc_order ASC';
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't obtain bbc box data", "", __LINE__, __FILE__, $sql);
		}
		
		$bbc_rows = $db->sql_fetchrowset($result);
		$bbc_count = count($bbc_rows);
		
		$template->assign_vars(array(
			'L_BBC_TITLE' => $lang['bbc_manage_title'],
			'L_BBC_TEXT' => $lang['bbc_manage_explain'],
			'L_BBC_NAME' => $lang['bbc_name'],
			'L_BBC_IMG_DISPLAY' => $lang['bbc_img_display'],
			'L_BBC_BEFORE' => $lang['bbc_before'],
			'L_BBC_AFTER' => $lang['bbc_after'],
			'L_BBC_HELPLINE' => $lang['bbc_helpline'],
			'L_BBC_IMG' => $lang['bbc_img'],
			'L_BBC_DIVIDER' => $lang['bbc_divider'],
			'L_EDIT' => $lang['Edit'],
			'L_DELETE' => $lang['Delete'],
			'L_ADD_BBC' => $lang['Add_new_bbc'],
			'L_ACTION' => $lang['Action'],

			'BBC_HOVERBG_IMG' => $images['bbc_hoverbg'],
			'BBC_BG_IMG' => $images['bbc_bg'],
			
			'S_BBC_BOX_ACTION' => append_sid('admin_bbc_box.'.$phpEx))
		);
		
		for( $i = 0; $i < $bbc_count; $i++)
		{
			$bbc_id = $bbc_rows[$i]['bbc_id'];
			$bbc_name = $bbc_rows[$i]['bbc_name'];
			$bbc_before = $bbc_rows[$i]['bbc_before'];
			$bbc_after = $bbc_rows[$i]['bbc_after'];
			$bbc_helpline = $bbc_rows[$i]['bbc_helpline'];
			$bbc_img = $bbc_rows[$i]['bbc_img'];
			$bbc_divider = $bbc_rows[$i]['bbc_divider'];
			
			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	
			$template->assign_block_vars('bbc', array(
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,
				'BBC_NAME' => $bbc_name,
				'BBC_IMG_DISPLAY' => $images[$bbc_img],
				'BBC_BEFORE' => $bbc_before,
				'BBC_AFTER' => $bbc_after,
				'BBC_HELPLINE' => $bbc_helpline,
				'BBC_IMG' => $bbc_img,
				'BBC_DIVIDER' => ( $bbc_divider == 1 ) ? $lang['Yes'] : $lang['No'],

				'U_BBC_EDIT' => append_sid('admin_bbc_box.'.$phpEx.'?mode=edit&amp;id='.$bbc_id),
				'U_BBC_DELETE' => append_sid('admin_bbc_box.'.$phpEx.'?mode=delete&amp;id='.$bbc_id))
			);
		}
	}
}
else
{
	//
	// Show the default page
	//
	$template->set_filenames(array('body' => 'admin/bbc_box_body.tpl'));
	
	$sql = 'SELECT * FROM ' . BBC_BOX_TABLE . '
		ORDER BY bbc_order ASC';
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain bbc box data", "", __LINE__, __FILE__, $sql);
	}
	$bbc_count = $db->sql_numrows($result);

	$bbc_rows = $db->sql_fetchrowset($result);
	
	$template->assign_vars(array(
		'L_BBC_TITLE' => $lang['bbc_manage_title'],
		'L_BBC_TEXT' => $lang['bbc_manage_explain'],
		'L_BBC_NAME' => $lang['bbc_name'],
		'L_BBC_IMG_DISPLAY' => $lang['bbc_img_display'],
		'L_BBC_BEFORE' => $lang['bbc_before'],
		'L_BBC_AFTER' => $lang['bbc_after'],
		'L_BBC_HELPLINE' => $lang['bbc_helpline'],
		'L_BBC_IMG' => $lang['bbc_img'],
		'L_BBC_DIVIDER' => $lang['bbc_divider'],
		'L_EDIT' => $lang['Edit'],
		'L_DELETE' => $lang['Delete'],
		'L_ADD_BBC' => $lang['Add_new_bbc'],
		'L_ACTION' => $lang['Action'],

		'BBC_HOVERBG_IMG' => $images['bbc_hoverbg'],
		'BBC_BG_IMG' => $images['bbc_bg'],

		'S_BBC_BOX_ACTION' => append_sid('admin_bbc_box.'.$phpEx))
	);
	
	for($i = 0; $i < $bbc_count; $i++)
	{
		$bbc_id = $bbc_rows[$i]['bbc_id'];
		$bbc_name = $bbc_rows[$i]['bbc_name'];
		$bbc_before = $bbc_rows[$i]['bbc_before'];
		$bbc_after = $bbc_rows[$i]['bbc_after'];
		$bbc_helpline = $bbc_rows[$i]['bbc_helpline'];
		$bbc_img = $bbc_rows[$i]['bbc_img'];
		$bbc_divider = $bbc_rows[$i]['bbc_divider'];

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$bbc_is_divider = ( $bbc_divider ) ? $lang['Yes'] : $lang['No'];
		
		$template->assign_block_vars('bbc', array(
			'ROW_COLOR' => '#' . $row_color,
			'ROW_CLASS' => $row_class,
			'BBC_NAME' => $bbc_name,
			'BBC_IMG_DISPLAY' => $images[$bbc_img],
			'BBC_BEFORE' => $bbc_before,
			'BBC_AFTER' => $bbc_after,
			'BBC_HELPLINE' => $bbc_helpline,
			'BBC_IMG' => $bbc_img,
			'BBC_DIVIDER' => $bbc_is_divider,

			'U_BBC_EDIT' => append_sid('admin_bbc_box.'.$phpEx.'?mode=edit&amp;id='.$bbc_id),
			'U_BBC_DELETE' => append_sid('admin_bbc_box.'.$phpEx.'?mode=delete&amp;id='.$bbc_id))
		);
	}
}

$template->pparse('body');

include('./page_footer_admin.'.$phpEx);

?>
