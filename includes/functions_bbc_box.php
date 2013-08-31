<?php
/***************************************************************************
 * functions_bbc_box.php
 * ---------------------
 * begin	: 11/06/2005
 * copyright	: reddog - http://www.reddevboard.com/
 * version	: 0.0.7 - 16/12/2005
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

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

define('CACHE_BBC_BOX', true);

//--------------------------------------------------------------------------------------------------
//
// display_bbc_style() : display the combobox style selection
//
//--------------------------------------------------------------------------------------------------
function display_bbc_style(&$bbc_style)
{
	global $board_config, $db, $template, $lang, $images, $theme;
	global $phpbb_root_path, $phpEx;

	$bbc_style_basedir = $phpbb_root_path . 'templates/_shared/bbc_box/styles';
	$key = $board_config['bbc_style_path'];
	$dir = @opendir($bbc_style_basedir);

	$bbc_images = array();
	$s_categories = '<select name="bbc_style_path">';
	while( $file = @readdir($dir) )
	{
		if( $file != '.' && $file != '..' && !is_file($bbc_style_basedir . '/' . $file) && !is_link($bbc_style_basedir . '/' . $file) )
		{
			$sub_dir = @opendir($bbc_style_basedir . '/' . $file);

			$bbc_row_count = 0;
			$bbc_col_count = 0;
			while( $sub_file = @readdir($sub_dir) )
			{
				if( preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $sub_file) )
				{
					$bbc_images[$file][$bbc_row_count][$bbc_col_count] = $file . '/' . $sub_file;
					$bbc_name[$file][$bbc_row_count][$bbc_col_count] = ucfirst(str_replace("_", " ", preg_replace('/^(.*)\..*$/', '\1', $sub_file)));

					$bbc_col_count++;
					if( $bbc_col_count == 14 )
					{
						$bbc_row_count++;
						$bbc_col_count = 0;
					}

				}
			}
			$selected = ( $bbc_style == $file ) ? ' selected="selected"' : '';
			if ( $bbc_images )
			{
				$s_categories .= '<option value="' . $file . '"' . $selected . '>' . ucfirst($file) . '</option>';
			}
		}
	}
	$s_categories .= '</select>';

	@closedir($dir);

	@ksort($bbc_images);
	@reset($bbc_images);

	for($i = 0; $i < count($bbc_images[$bbc_style]); $i++)
	{
		$template->assign_block_vars('bbc_row', array());

		for($j = 0; $j < count($bbc_images[$bbc_style][$i]); $j++)
		{
			$template->assign_block_vars('bbc_row.bbc_column', array(
				'BBC_IMAGE' => $bbc_style_basedir . '/' . $bbc_images[$bbc_style][$i][$j],
				'BBC_NAME' => $bbc_name[$bbc_style][$i][$j],
			));
		}
	}

	$s_hidden_vars = '<input type="hidden" name="bbc_style" value="' . str_replace('"', '&quot;', $bbc_style) . '" />';

	$template->assign_vars(array(
		'L_SKIN' => $lang['Select_skin'],
		'L_PREVIEW' => $lang['Skin_preview'],
		'S_STYLE_BASEDIR' => $bbc_style_basedir,
		'S_CATEGORY_SELECT' => $s_categories,
		'S_HIDDEN_FIELDS' => $s_hidden_vars,
	));

	return;
}

//--------------------------------------------------------------------------------------------------
//
// charmap() : display the complete custom characters map
//
//--------------------------------------------------------------------------------------------------
function charmap($page_id)
{
	global $db, $board_config, $template, $lang, $images, $theme, $phpEx, $phpbb_root_path;
	global $user_ip, $session_length, $starttime;
	global $userdata;

	// ensure categories hierarchy v2.1.x compliancy
	if (!empty($board_config['mod_cat_hierarchy']))
	{
		global $config, $user, $censored_words, $icons, $navigation, $themes, $smilies;
		global $forums, $forum_id;

		// fix this missing var
		$topic_title = '';
		$forum_id = intval($forum_id);
		if ( empty($forum_id) )
		{
			$forum_id = _read(POST_FORUM_URL, TYPE_INT);
		}
	}

	$userdata = session_pagestart($user_ip, $page_id);
	init_userprefs($userdata);

	// bbc box language file
	if ( $userdata['user_id'] != ANONYMOUS )
	{
		if ( !empty($userdata['user_lang']))
		{
			$board_config['default_lang'] = $userdata['user_lang'];
		}
	}
	if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_bbc_box.'.$phpEx)) )
	{
		$board_config['default_lang'] = 'english';
	}
	include_once($phpbb_root_path.'language/lang_'.$board_config['default_lang'].'/lang_bbc_box.'.$phpEx);

	$gen_simple_header = TRUE;

	$page_title = $lang['charmap_page'] . " - $topic_title";
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array('chrpopup' => 'bbc_chr_popup.tpl'));

	$template->assign_vars(array(
		'L_CHARMAP_TITLE' => $lang['charmap_title'],
		'L_CLOSE_WINDOW' => $lang['Close_window'],
		'BBC_CHR_SHEET' => $images['bbc_chr_sheet'],
	));

	$template->pparse('chrpopup');
}

//--------------------------------------------------------------------------------------------------
//
// bbc_auth() : get the list of bbcode available to the user
//
//--------------------------------------------------------------------------------------------------
function bbc_auth($bbc_type)
{
	global $db, $userdata, $is_auth;

	$bbc_sort = false;
	switch( $bbc_type )
	{
		case AUTH_ADMIN:
			if ( $userdata['user_level'] == ADMIN )
			{
				$bbc_sort = true;
			}
			break;
		case AUTH_MOD:
			if ( $is_auth['auth_mod'] )
			{
				$bbc_sort = true;
			}
			break;
		case AUTH_REG:
			if ( $userdata['session_logged_in'] )
			{
				$bbc_sort = true;
			}
			break;
		default:
			$bbc_sort = true;
			break;
	}
	return $bbc_sort;
}

//--------------------------------------------------------------------------------------------------
//
// bbc_get_list() : get the list of bbcode
//
//--------------------------------------------------------------------------------------------------
function bbc_get_list($order, $bbc_id, $bbc_tmp_order, $select)
{
	global $db, $lang;

	$sql_where = (!empty($select)) ? ' WHERE bbc_id <> ' . $bbc_id : '';
	$sql_order = (!empty($order)) ? ' ORDER BY ' . $order : '';

	$sql = 'SELECT *
		FROM ' . BBC_BOX_TABLE . $sql_where . $sql_order;
	$result = $db->sql_query($sql, false, __LINE__, __FILE__);

	$bbc_pos = $bbc_tmp_order - 10;
	$bbc_list_order = '<select name="bbc_order"><option value="0"' . ((!$bbc_pos) ? ' selected="selected"' : '') . '>' . $lang['bbc_top'] . '</option>';
	while ( $bbc_row = $db->sql_fetchrow($result) )
	{
		$selected = ($bbc_row['bbc_order'] == $bbc_pos) ? ' selected="selected"' : '';
		$bbc_list_order .= '<option value="' . $bbc_row['bbc_order'] . '"' . $selected . '>' . $lang['bbcbxr_desc'][$bbc_row['bbc_name']] . '</option>';
	}
	$bbc_list_order .= '</select>';

	return($bbc_list_order);
}
//--------------------------------------------------------------------------------------------------
//
// bbc_time_regen() : generate the bbc time regen
//
//--------------------------------------------------------------------------------------------------
function bbc_time_regen($field)
{
	global $db;

	$time = time();
	$sql = 'UPDATE ' . CONFIG_TABLE . '
		SET config_value = \'' . $time . '\'
		WHERE config_name = \'' . $field . '\'';
	if( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not insert bbc time regen', '', __LINE__, __FILE__, $sql);
	}
	return;
}

//--------------------------------------------------------------------------------------------------
//
// cache_bbc_box() : build the cache bbc_box file
//
//--------------------------------------------------------------------------------------------------
function cache_bbc_box()
{
	global $phpbb_root_path, $phpEx, $db;

	if ( !defined('CACHE_BBC_BOX') )
	{
		return;
	}
	bbc_box_generic('def_bbc_box_def', 'def_bbc_box', BBC_BOX_TABLE, 'bbc_id', '', 'ORDER BY bbc_order');
}

//--------------------------------------------------------------------------------------------------
//
// bbc_box_generic() : generic bbc_box process
//
//--------------------------------------------------------------------------------------------------
/**
 * This is the function cache_generic() coded by Ptirhiik and used in Categories hierarchy 2.0.5
 * and Profile Control Panel 2.0.0-1
 */
function bbc_box_generic($cache_tpl, $cache_file, $table, $key_field, $sql_where='', $order_by='')
{
	global $board_config, $phpbb_root_path, $phpEx, $db, $userdata;

	// assign vars
	$cache_tpl_path = 'includes/cache_tpls/';

	// ensure categories hierarchy v2.1.x compliancy
	if (!empty($board_config['mod_cat_hierarchy']))
	{
		global $config;

		// intantiate the template
		$template = new template_class($config->root . $cache_tpl_path, false, $cache_tpl_path);

		$template->set_filenames(array('cache' => $cache_tpl . '.tpl'));
	}
	else
	{
		// intantiate the template
		$template = new Template($phpbb_root_path);

		$template->set_filenames(array('cache' => $cache_tpl_path . $cache_tpl . '.tpl'));
	}

	$time = time();
	$template->assign_vars(array(
		'TIME' => date('Y-m-d H:i:s', $time) . ' (GMT)',
		'DAY' => mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time) ),
		'USERNAME' => $userdata['username'],
	));

	$sql = "SELECT * FROM $table $sql_where $order_by";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not read ' . $table . ' table', '', __LINE__, __FILE__, $sql);
	}
	while ( $row = $db->sql_fetchrow($result) )
	{
		$id = $row[$key_field];
		$cells = array();
		foreach ( $row as $key => $value )
		{
			$nkey = intval($key);
			if ( $key != "$nkey" )
			{
				$cells[] = sprintf( "'%s' => '%s'", str_replace("'", "\'", $key), str_replace("'", "\'", $value));
			}
		}
		$s_cells = empty($cells) ? '' : implode(', ', $cells);

		$template->assign_block_vars('cache_row', array(
			'ID' => sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS' => $s_cells,
		));
	}

	// transfert to a var
	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	// output to file
	$cache_path = 'includes/';
	$handle = @fopen($phpbb_root_path . $cache_path . $cache_file . '.' . $phpEx, 'w');
	@flock($fp, LOCK_EX);
	@fwrite($handle, $res);
	@flock($fp, LOCK_UN);
	@fclose($handle);
	@umask(0000);
	@chmod($phpbb_root_path . $cache_path . $cache_file . '.' . $phpEx, 0666);
}

?>