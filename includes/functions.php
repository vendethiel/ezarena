<?php
/***************************************************************************
 *                               functions.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: functions.php,v 1.133.2.44 2006/02/26 19:37:50 grahamje Exp $
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

/**
 * V: function to avoid re-defining constants over and over again
 *  (mainly for ADR)
 */
function redefine($name, $val)
{
	if (!defined($name))
	{
		define($name, $val);
	}
}

//-- mod : topic display order ---------------------------------------------------------------------
//-- add
// build a list of the sortable fields or return field name
function get_forum_display_sort_option($selected_row=0, $action='list', $list='sort')
{
	global $lang;

	$forum_display_sort = array(
		'lang_key'	=> array('Last_Post', 'Sort_Topic_Title', 'Sort_Time', 'Sort_Author'),
		'fields'	=> array('t.topic_last_post_id', 't.topic_title', 't.topic_time', 'u.username'),
	);
	$forum_display_order = array(
		'lang_key'	=> array('Sort_Descending', 'Sort_Ascending'),
		'fields'	=> array('DESC', 'ASC'),
	);

	// get the good list
	$list_name = 'forum_display_' . $list;
	$listrow = $$list_name;

	// init the result
	$res = '';
	if ( $selected_row > count($listrow['lang_key']) )
	{
		$selected_row = 0;
	}

	// build list
	if ($action == 'list')
	{
		for ($i=0; $i < count($listrow['lang_key']); $i++)
		{
			$selected = ($i==$selected_row) ? ' selected="selected"' : '';
			$l_value = (isset($lang[$listrow['lang_key'][$i]])) ? $lang[$listrow['lang_key'][$i]] : $listrow['lang_key'][$i];
			$res .= '<option value="' . $i . '"' . $selected . '>' . $l_value . '</option>';
		}
	}
	else
	{
		// field
		$res = $listrow['fields'][$selected_row];
	}
	return $res;
}
//-- fin mod : topic display order ----------------------------------------------------------------- 
function get_db_stat($mode)
{
	global $db;

	switch( $mode )
	{
		case 'usercount':
			$sql = "SELECT COUNT(user_id) AS total
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS;
			break;

		case 'newestuser':
			$sql = "SELECT user_id, username
				FROM " . USERS_TABLE . "
				WHERE user_id <> " . ANONYMOUS . "
				ORDER BY user_id DESC
				LIMIT 1";
//-- mod : rank color system ---------------------------------------------------
//-- add
			$sql = str_replace('SELECT ', 'SELECT user_level, user_color, user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------				
			break;
        case 'gender-male': 
            $sql = "SELECT COUNT(user_id) AS total_male 
                FROM " . USERS_TABLE . " 
                WHERE user_gender = '1'"; 
            break; 
        case 'gender-female': 
            $sql = "SELECT COUNT(user_id) AS total_female 
                FROM " . USERS_TABLE . " 
                WHERE user_gender = '2'"; 
            break;			

		case 'postcount':
		case 'topiccount':
			$sql = "SELECT SUM(forum_topics) AS topic_total, SUM(forum_posts) AS post_total
				FROM " . FORUMS_TABLE;
			break;
	}

	if ( !($result = $db->sql_query($sql, false, 'posts_')) )
	{
		return false;
	}

	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	switch ( $mode )
	{
		case 'usercount':
			return $row['total'];
			break;
		case 'newestuser':
			return $row;
			break;
		case 'postcount':
			return $row['post_total'];
			break;
		case 'topiccount':
			return $row['topic_total'];
			break;
        case 'gender-male': 
            return $row['total_male']; 
            break; 
        case 'gender-female': 
            return $row['total_female']; 
            break;			
	}

	return false;
}

// added at phpBB 2.0.11 to properly format the username
function phpbb_clean_username($username)
{
	$username = substr(htmlspecialchars(str_replace("\'", "'", trim($username))), 0, 25);
	$username = phpbb_rtrim($username, "\\");
	$username = str_replace("'", "\'", $username);

	return $username;
}

// 
// Obtain new post information for marquee 
// of new posts 
// 
// 
// Get Viewable Forums 
// 
// function to merge two auth arrays to one 
function array_merge_replace($array, $newValues)
{ 
	foreach ($newValues as $key => $value)
	{ 
		if ( is_array($value) )
		{ 
			if ( !isset($array[$key]) )
			{ 
				$array[$key] = array(); 
			} 
			$array[$key] = array_merge_replace($array[$key], $value); 
		}
		else
		{ 
			if ( isset($array[$key]) && is_array($array[$key]) )
			{ 
				$array[$key][0] = $value; 
			}
			else
			{ 
				if ( isset($array) && !is_array($array) )
				{ 
					$temp = $array; 
					$array = array(); 
					$array[0] = $temp; 
				} 
				$array[$key] = $value; 
			} 
		} 
	} 
	return $array; 
} 

/**
* This function is a wrapper for ltrim, as charlist is only supported in php >= 4.1.0
* Added in phpBB 2.0.18
*/
function phpbb_ltrim($str, $charlist = false)
{
	if ($charlist === false)
	{
		return ltrim($str);
	}
	
	$php_version = explode('.', PHP_VERSION);

	// php version < 4.1.0
	if ((int) $php_version[0] < 4 || ((int) $php_version[0] == 4 && (int) $php_version[1] < 1))
	{
		while ($str{0} == $charlist)
		{
			$str = substr($str, 1);
		}
	}
	else
	{
		$str = ltrim($str, $charlist);
	}

	return $str;
}

// added at phpBB 2.0.12 to fix a bug in PHP 4.3.10 (only supporting charlist in php >= 4.1.0)
function phpbb_rtrim($str, $charlist = false)
{
	if ($charlist === false)
	{
		return rtrim($str);
	}
	
	$php_version = explode('.', PHP_VERSION);

	// php version < 4.1.0
	if ((int) $php_version[0] < 4 || ((int) $php_version[0] == 4 && (int) $php_version[1] < 1))
	{
		while ($str{strlen($str)-1} == $charlist)
		{
			$str = substr($str, 0, strlen($str)-1);
		}
	}
	else
	{
		$str = rtrim($str, $charlist);
	}

	return $str;
}

/**
* Our own generator of random values
* This uses a constantly changing value as the base for generating the values
* The board wide setting is updated once per page if this code is called
* With thanks to Anthrax101 for the inspiration on this one
* Added in phpBB 2.0.20
*
* V: actually, I totally removed the function from phpBB 2.0.20
*  because it was using SQL for no reason, so now we just using
*  okay-entropy crap (md5 of microtime + random data, here online record date as salt)
* so ... Added in ezArena 1.0.0.
*/
function dss_rand()
{
	global $db, $board_config;

	$seed = isset($board_config['rand_seed']) ? $board_config['rand_seed'] : null;
	if ($seed === null)
	{
		$seed = md5(microtime() . '@foo:' . $board_config['record_online_date']);
	}
	$board_config['rand_seed'] = md5(uniqid($seed, true));

	return substr($board_config['rand_seed'], 4, 16);
}

//
// Get Userdata, $user can be username or user_id. If force_str is true, the username will be forced.
//
function get_userdata($user, $force_str = false)
{
	global $db;

	if (!is_numeric($user) || $force_str)
	{
		$user = phpbb_clean_username($user);
	}
	else
	{
		$user = intval($user);
	}

	$sql = "SELECT *
		FROM " . USERS_TABLE . " 
		WHERE ";
	$sql .= ( ( is_integer($user) ) ? "user_id = $user" : "username = '" .  str_replace("\'", "''", $user) . "'" ) . " AND user_id <> " . ANONYMOUS;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
	}

	return ( $row = $db->sql_fetchrow($result) ) ? $row : false;
}

function make_jumpbox($action, $match_forum_id = 0)
{
	global $template, $userdata, $lang, $db, $nav_links, $phpEx, $SID;
	// www.phpBB-SEO.com SEO TOOLKIT BEGIN
	global $phpbb_seo;
	// www.phpBB-SEO.com SEO TOOLKIT END	

//	$is_auth = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata);

	$sql = "SELECT c.cat_id, c.cat_title, c.cat_order
		FROM " . CATEGORIES_TABLE . " c, " . FORUMS_TABLE . " f
		WHERE f.cat_id = c.cat_id
		GROUP BY c.cat_id, c.cat_title, c.cat_order
		ORDER BY c.cat_order";
	if ( !($result = $db->sql_query($sql, false, true)) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain category list.", "", __LINE__, __FILE__, $sql);
	}
	
	$category_rows = array();
	while ( $row = $db->sql_fetchrow($result) )
	{
		$category_rows[] = $row;
	}

	if ( $total_categories = count($category_rows) )
	{
		$sql = "SELECT *
			FROM " . FORUMS_TABLE . "
			ORDER BY cat_id, forum_order";
		if ( !($result = $db->sql_query($sql, false, true)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
		}

		$boxstring = '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"><option value="-1">' . $lang['Select_forum'] . '</option>';

		$forum_rows = array();
		while ( $row = $db->sql_fetchrow($result) )
		{
			$forum_rows[] = $row;
		}

		if ( $total_forums = count($forum_rows) )
		{
			for($i = 0; $i < $total_categories; $i++)
			{
				//-- mod: sf
				$_sf_forum_keys = array();
//-- mod: sf - end
				$boxstring_forums = '';
				for($j = 0; $j < $total_forums; $j++)
				{
					if ($forum_rows[$j]['cat_id'] == $category_rows[$i]['cat_id'] && $forum_rows[$j]['auth_view'] <= AUTH_REG)
					{
//					if ( $forum_rows[$j]['cat_id'] == $category_rows[$i]['cat_id'] && $is_auth[$forum_rows[$j]['forum_id']]['auth_view'] )
//					{
						$selected = ( $forum_rows[$j]['forum_id'] == $match_forum_id ) ? 'selected="selected"' : '';
						//-- mod: sf
/*	
						$boxstring_forums .=  '<option value="' . $forum_rows[$j]['forum_id'] . '"' . $selected . '>' . $forum_rows[$j]['forum_name'] . '</option>';
*/
						// except a branch for which the root hasn't been retained
						if ( intval($forum_rows[$j]['forum_parent']) && !isset($_sf_forum_keys[ intval($forum_rows[$j]['forum_parent']) ]) )
						{
							continue;
						}
						$_sf_forum_keys[ $forum_rows[$j]['forum_id'] ] = $j;
						$forum_rows[$j]['_sf_nest_level'] = intval($forum_rows[$j]['forum_parent']) ? intval($forum_rows[ $_sf_forum_keys[ intval($forum_rows[$j]['forum_parent']) ] ]['_sf_nest_level']) + 1 : 0;
						$boxstring_forums .=  '<option value="' . $forum_rows[$j]['forum_id'] . '"' . $selected . '>' . ($forum_rows[$j]['_sf_nest_level'] ? implode('', array_pad(array(), ($forum_rows[$j]['_sf_nest_level'] - 1) * 4, '&nbsp;')) . '--&nbsp;' : '') . $forum_rows[$j]['forum_name'] . '</option>';
//-- mod: sf - end
						
						//
						// Add an array to $nav_links for the Mozilla navigation bar.
						// 'chapter' and 'forum' can create multiple items, therefore we are using a nested array.
						//

						// www.phpBB-SEO.com SEO TOOLKIT BEGIN
						if ( !isset($phpbb_seo->seo_url['forum'][$forum_rows[$j]['forum_id']]) ) {
							$phpbb_seo->seo_url['forum'][$forum_rows[$j]['forum_id']] = $phpbb_seo->format_url($forum_rows[$j]['forum_name'], $phpbb_seo->seo_static['forum']);
						}
						$nav_links['chapter forum'][$forum_rows[$j]['forum_id']] = array (
						//	'url' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=" . $forum_rows[$j]['forum_id']),
							'url' => $phpbb_seo->seo_url['forum'][$forum_rows[$j]['forum_id']] . $phpbb_seo->seo_delim['forum'] . $forum_rows[$j]['forum_id'] . $phpbb_seo->seo_ext['forum'],
							'title' => $forum_rows[$j]['forum_name']
						);
						// www.phpBB-SEO.com SEO TOOLKIT END								
					}
				}

				if ( $boxstring_forums != '' )
				{
					$boxstring .= '<option value="-1">&nbsp;</option>';
					$boxstring .= '<option value="-1">' . $category_rows[$i]['cat_title'] . '</option>';
					$boxstring .= '<option value="-1">----------------</option>';
					$boxstring .= $boxstring_forums;
				}
			}
		}

		$boxstring .= '</select>';
	}
	else
	{
		$boxstring .= '<select name="' . POST_FORUM_URL . '" onchange="if(this.options[this.selectedIndex].value != -1){ forms[\'jumpbox\'].submit() }"></select>';
	}

	// Let the jumpbox work again in sites having additional session id checks.
	if ( !empty($_SESSION['logged_in']) )
	{
		$boxstring .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';
	}

	$template->set_filenames(array(
		'jumpbox' => 'jumpbox.tpl')
	);
	$template->assign_vars(array(
		'L_GO' => $lang['Go'],
		'L_JUMP_TO' => $lang['Jump_to'],
		'L_SELECT_FORUM' => $lang['Select_forum'],

		'S_JUMPBOX_SELECT' => $boxstring,
		'S_JUMPBOX_ACTION' => append_sid($action))
	);
	$template->assign_var_from_handle('JUMPBOX', 'jumpbox');

	return;
}

//
// Initialise user settings on page load
function init_userprefs($userdata)
{
	global $db, $HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS;
	global $board_config, $theme, $images;
	global $template, $lang, $phpEx, $phpbb_root_path, $db;
	global $nav_links;

	if ( $userdata['user_id'] != ANONYMOUS )
	{
		if ( !empty($userdata['user_lang']))
		{
			$default_lang = phpbb_ltrim(basename(phpbb_rtrim($userdata['user_lang'])), "'");
		}

		if ( !empty($userdata['user_dateformat']) )
		{
			$board_config['default_dateformat'] = $userdata['user_dateformat'];
		}

		if ( isset($userdata['user_timezone']) )
		{
			$board_config['board_timezone'] = $userdata['user_timezone'];
		}
		if ( isset($userdata['user_use_rel_date']) )
		{
			$board_config['ty_use_rel_date'] = $userdata['user_use_rel_date'];
		}
		
		if ( isset($userdata['user_use_rel_time']) )
		{
			$board_config['ty_use_rel_time'] = $userdata['user_use_rel_time'];
		}		
	}

	else
	{
		$default_lang = phpbb_ltrim(basename(phpbb_rtrim($board_config['default_lang'])), "'");
	}

	if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $default_lang . '/lang_main.'.$phpEx)) )
	{
		if ( $userdata['user_id'] != ANONYMOUS )
		{
			// For logged in users, try the board default language next
			$default_lang = phpbb_ltrim(basename(phpbb_rtrim($board_config['default_lang'])), "'");
		}
		else
		{
			// For guests it means the default language is not present, try english
			// This is a long shot since it means serious errors in the setup to reach here,
			// but english is part of a new install so it's worth us trying
			$default_lang = 'french';
		}

		if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $default_lang . '/lang_main.'.$phpEx)) )
		{
			message_die(CRITICAL_ERROR, 'Could not locate valid language pack');
		}
	}

	// If we've had to change the value in any way then let's write it back to the database
	// before we go any further since it means there is something wrong with it
	if ( $userdata['user_id'] != ANONYMOUS && $userdata['user_lang'] !== $default_lang )
	{
		$sql = 'UPDATE ' . USERS_TABLE . "
			SET user_lang = '" . $default_lang . "'
			WHERE user_lang = '" . $userdata['user_lang'] . "'";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not update user language info');
		}

		$board_config['default_lang'] = $default_lang;
		$userdata['user_lang'] = $default_lang;
	}
	elseif ( $board_config['default_lang'] !== $default_lang )
	{
		$sql = 'UPDATE ' . CONFIG_TABLE . "
			SET config_value = '" . $default_lang . "'
			WHERE config_name = 'default_lang'";

		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(CRITICAL_ERROR, 'Could not update user language info');
		}

		$board_config['default_lang'] = $default_lang;
	}

	include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.' . $phpEx);
	
	include($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/lang_adr_common_main.' . $phpEx); 
	include($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/lang_adr_TownMap_main.' . $phpEx); 

	if ( defined('IN_ADMIN') )
	{
		if( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.'.$phpEx)) )
		{
			$board_config['default_lang'] = 'french';
		}

		include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_admin.' . $phpEx);
		include($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/lang_adr_common_admin.' . $phpEx); 
	}
	//MOD Keep_unread_2
	read_cookies($userdata);	

//-- mod : language settings ---------------------------------------------------
//-- add
	include($phpbb_root_path . 'includes/lang_extend_mac.' . $phpEx);
//-- fin mod : language settings -----------------------------------------------
	// Disable board if needed
	board_disable();
	if (!defined('NO_ATTACH_MOD'))
	{
		include_attach_lang();
	}
	//
	// Set up style
	//
	if ( !$board_config['override_user_style'] )
	{
		if ( isset($HTTP_GET_VARS[STYLE_URL]) )
		{
			$style = urldecode( $HTTP_GET_VARS[STYLE_URL] );
			if ( $theme = setup_style($style) )
			{
				if ($theme['themes_id'] == $userdata['user_style'])
				{
					return;
				}

				if ( $userdata['user_id'] != ANONYMOUS )
				{
					// user logged in --> save new style ID in user profile
					$sql = "UPDATE " . USERS_TABLE . " 
						SET user_style = " . $theme['themes_id'] . "
						WHERE user_id = " . $userdata['user_id'];
					if ( !$db->sql_query($sql) )
					{
						message_die(CRITICAL_ERROR, 'Error updating user style', '', __LINE__, __FILE__, $sql);
					}

					$userdata['user_style'] = $theme['themes_id'];
				} else
				{
					// user not logged in --> save new style ID in cookie
					setcookie($board_config['cookie_name'] . '_style', $style, time() + 31536000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
				}
				return;
			}
		}


		if ( $userdata['user_id'] == ANONYMOUS && isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_style']) )
		{
			$style = $HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_style'];
			if ( $theme = setup_style($style) )
			{
				return;
			}
		}	
		if ( $userdata['user_id'] != ANONYMOUS && $userdata['user_style'] > 0 )
		{
			if ( $theme = setup_style($userdata['user_style']) )
			{
				return;
			}
		}
	}

	$theme = setup_style($board_config['default_style']);

	//
	// Mozilla navigation bar
	// Default items that should be valid on all pages.
	// Defined here to correctly assign the Language Variables
	// and be able to change the variables within code.
	//
	$nav_links['top'] = array ( 
		'url' => append_sid($phpbb_root_path . 'index.' . $phpEx),
		'title' => sprintf($lang['Forum_Index'], $board_config['sitename'])
	);
	$nav_links['search'] = array ( 
		'url' => append_sid($phpbb_root_path . 'search.' . $phpEx),
		'title' => $lang['Search']
	);
	$nav_links['help'] = array ( 
		'url' => append_sid($phpbb_root_path . 'faq.' . $phpEx),
		'title' => $lang['FAQ']
	);
	$nav_links['author'] = array ( 
		'url' => append_sid($phpbb_root_path . 'memberlist.' . $phpEx),
		'title' => $lang['Memberlist']
	);

	return;
}

function setup_style($style)
{
	global $db, $board_config, $template, $images, $phpbb_root_path, $template;
	// V: let's just query all the themes ...
	$sql = "SELECT * FROM " . THEMES_TABLE;

	if ( !($result = $db->sql_query($sql, 0, 'style_')) )
	{
		message_die(CRITICAL_ERROR, 'Could not query database for theme info');
	}

	$style_names = array();
	while ($row = $db->sql_fetchrow($result))
	{
		$style_names[] = $row['style_name'];

		if ($style == $row['style_name'] || $style == $row['themes_id'])
		{
			$selected_style = $row;
		}
		else if ($row['themes_id'] == $board_config['default_style'])
		{
			$default_style = $row;
		}
	}
	$db->sql_freeresult($result);

	if (empty($selected_style))
	{
		// We are trying to setup a style which does not exist in the database
		// Try to fallback to the board default (if the user had a custom style)
		// and then any users using this style to the default if it succeeds
		if ( $style != $board_config['default_style'])
		{
			if (!empty($default_style))
			{ // we're safe, default style exists.
				$sql = 'UPDATE ' . USERS_TABLE . '
					SET user_style = ' . (int) $board_config['default_style'] . "
					WHERE user_style = '$style'";
				if ( !$db->sql_query($sql) )
				{
					message_die(CRITICAL_ERROR, 'Could not update user theme info');
				}
				$row = $default_style;
			}
			else
			{
				message_die(CRITICAL_ERROR, "No default theme is available");
			}
		}
		else
		{ // style is board's default but not available. We're in big trouble !
			message_die(CRITICAL_ERROR, "Could not get default style data for themes_id [$style]");
		}
	}
	else
	{
		$row = $selected_style;
	}

	$template_path = 'templates/';
	$template_name = $row['template_name'];
	$style_name = $row['style_name'];

	$template = new Template($phpbb_root_path . $template_path . $template_name);
//------------------------------------------------------------------------------
// Global Admin Template - Begin Code Alteration
//
	if ( defined('IN_ADMIN') )
	{
		// V: mod -- Force subSilver for admin
		$template_name = 'phpbb';
		$style_name = 'subSilver';
		// V: mod end -- Force subSilver for admin
		$template->set_rootdir($phpbb_root_path . 'admin/templates');
	}
//
// Global Admin Template - End Code Alteration
//------------------------------------------------------------------------------	

	foreach ($style_names as $s)
	{
		$template->assign_block_vars('style_list', array(
		 	'NAME' => $s,
		));
	}

	if ( $template )
	{
		$current_template_path = $template_path . $template_name;
		@include($phpbb_root_path . $template_path . $template_name . '/' . $template_name . '.cfg');
//-- mod : bbcode box reloaded -------------------------------------------------
//-- add
		$style = $board_config['bbc_style_path'];
		$bbcb_path = $phpbb_root_path . $current_template_path . '/bbc_box.cfg';
		// V: remember about stuff not being as clever as XS :) ?
		// try to find it in current template's dir, else in tpldef's one
		if (file_exists($bbcb_path))
		{
			include $bbcb_path;
		}
		else
		{
			include str_replace($template_name, $template->tpldef, $bbcb_path);
		}
//-- fin mod : bbcode box reloaded ---------------------------------------------		

		if ( !defined('TEMPLATE_CONFIG') )
		{
			message_die(CRITICAL_ERROR, "Could not open $template_name template config file", '', __LINE__, __FILE__);
		}

		$img_lang = ( file_exists(@phpbb_realpath($phpbb_root_path . $current_template_path . '/images/lang_' . $board_config['default_lang'])) ) ? $board_config['default_lang'] : 'french';

		$tpl_images = array();
		foreach ($images as $k => &$v)
		{
			$v = str_replace('{LANG}', 'lang_' . $img_lang, $v);
			$tpl_images['I_' . strtoupper($k)] = $v;
		}
		$template->assign_vars($tpl_images);
	}

	return $row;
}

function encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	if (count($ip_sep) == 4)
		return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

function decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

//
// Create date/time from format and timezone
//
function create_date($format, $gmepoch, $tz)
{
	global $board_config, $lang;
	static $translate;

	if ( empty($translate) && $board_config['default_lang'] != 'english' )
	{
		@reset($lang['datetime']);
		while ( list($match, $replace) = @each($lang['datetime']) )
		{
			$translate[$match] = $replace;
		}
	}

	return ( !empty($translate) ) ? strtr(@gmdate($format, $gmepoch + (3600 * $tz)), $translate) : @gmdate($format, $gmepoch + (3600 * $tz));
}

//
// Pagination routine, generates
// page number sequence
//
function generate_pagination($base_url, $num_items, $per_page, $start_item, $add_prevnext_text = TRUE)
{
	global $lang;

	$total_pages = ceil($num_items/$per_page);

	if ( $total_pages == 1 )
	{
		return '';
	}

	$on_page = floor($start_item / $per_page) + 1;

	$page_string = '';
	if ( $total_pages > 10 )
	{
		$init_page_max = ( $total_pages > 3 ) ? 3 : $total_pages;

		for($i = 1; $i < $init_page_max + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
			if ( $i <  $init_page_max )
			{
				$page_string .= ", ";
			}
		}

		if ( $total_pages > 3 )
		{
			$yada = ' <span onclick=\'paginationPrompt("' . append_sid($base_url . "&amp;start=PAGEHERE") . '", ' . $per_page . '); return false;\'>...</span> ';
			if ( $on_page > 1  && $on_page < $total_pages )
			{
				$page_string .= ( $on_page > 5 ) ? $yada : ', ';

				$init_page_min = ( $on_page > 4 ) ? $on_page : 5;
				$init_page_max = ( $on_page < $total_pages - 4 ) ? $on_page : $total_pages - 4;

				for($i = $init_page_min - 1; $i < $init_page_max + 2; $i++)
				{
					$page_string .= ($i == $on_page) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
					if ( $i <  $init_page_max + 1 )
					{
						$page_string .= ', ';
					}
				}

				$page_string .= ( $on_page < $total_pages - 4 ) ? $yada : ', ';
			}
			else
			{
				$page_string .= $yada;
			}

			for($i = $total_pages - 2; $i < $total_pages + 1; $i++)
			{
				$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>'  : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
				if( $i <  $total_pages )
				{
					$page_string .= ", ";
				}
			}
		}
	}
	else
	{
		for($i = 1; $i < $total_pages + 1; $i++)
		{
			$page_string .= ( $i == $on_page ) ? '<b>' . $i . '</b>' : '<a href="' . append_sid($base_url . "&amp;start=" . ( ( $i - 1 ) * $per_page ) ) . '">' . $i . '</a>';
			if ( $i <  $total_pages )
			{
				$page_string .= ', ';
			}
		}
	}

	if ( $add_prevnext_text )
	{
		if ( $on_page > 1 )
		{
			$page_string = ' <a href="' . append_sid($base_url . "&amp;start=" . ( ( $on_page - 2 ) * $per_page ) ) . '">' . $lang['Previous'] . '</a>&nbsp;&nbsp;' . $page_string;
		}

		if ( $on_page < $total_pages )
		{
			$page_string .= '&nbsp;&nbsp;<a href="' . append_sid($base_url . "&amp;start=" . ( $on_page * $per_page ) ) . '">' . $lang['Next'] . '</a>';
		}

	}

	$page_string = $lang['Goto_page'] . ' ' . $page_string;

	return $page_string;
}

//
// This does exactly what preg_quote() does in PHP 4-ish
// If you just need the 1-parameter preg_quote call, then don't bother using this.
//
function phpbb_preg_quote($str, $delimiter)
{
	$text = preg_quote($str);
	$text = str_replace($delimiter, '\\' . $delimiter, $text);
	
	return $text;
}

//
// Obtain list of naughty words and build preg style replacement arrays for use by the
// calling script, note that the vars are passed as references this just makes it easier
// to return both sets of arrays
//
function obtain_word_list(&$orig_word, &$replacement_word)
{
	global $db;

	//
	// Define censored word matches
	//
	$sql = "SELECT word, replacement
		FROM  " . WORDS_TABLE;
	if( !($result = $db->sql_query($sql, false, true)) )
	{
		message_die(GENERAL_ERROR, 'Could not get censored words from database', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		do 
		{
			$orig_word[] = '#\b(' . str_replace('\*', '\w*?', preg_quote($row['word'], '#')) . ')\b#i';
			$replacement_word[] = $row['replacement'];
		}
		while ( $row = $db->sql_fetchrow($result) );
	}

	return true;
}

//
// This is general replacement for die(), allows templated
// output in users (or default) language, etc.
//
// $msg_code can be one of these constants:
//
// GENERAL_MESSAGE : Use for any simple text message, eg. results 
// of an operation, authorisation failures, etc.
//
// GENERAL ERROR : Use for any error which occurs _AFTER_ the 
// common.php include and session code, ie. most errors in 
// pages/functions
//
// CRITICAL_MESSAGE : Used when basic config data is available but 
// a session may not exist, eg. banned users
//
// CRITICAL_ERROR : Used when config data cannot be obtained, eg
// no database connection. Should _not_ be used in 99.5% of cases
//
function message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '')
{
	global $db, $template, $board_config, $theme, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header, $images;
	global $userdata, $user_ip, $session_length;
	global $starttime;
//-- mod : rank color system ---------------------------------------------------
//-- add
	global $get;
//-- fin mod : rank color system -----------------------------------------------	

	if(defined('HAS_DIED'))
	{
		die("message_die() was called multiple times. This isn't supposed to happen. Was message_die() used in page_tail.php?");
	}
	
	define('HAS_DIED', 1);
	

	$sql_store = $sql;
	
	//
	// Get SQL error if we are debugging. Do this as soon as possible to prevent 
	// subsequent queries from overwriting the status of sql_error()
	//
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
	{
		$sql_error = $db->sql_error();

		$debug_text = '';

		if ( $sql_error['message'] != '' )
		{
			switch($sql_error['code'])
			{
				case '1050':
					$sql_error['help'] = $lang['SQL_exist_error'];
					break;
				case '1062':
					$sql_error['help'] = $lang['SQL_duplicate_error'];
					break;
				case '1064':
					$sql_error['help'] = $lang['SQL_syntax_error'];
					break;
			}

			$sql_error['help'] .= ( isset($sql_error['help']) ) ? '<br /><br />' : '';

			$debug_text .= '<br /><br />' . $sql_error['help'] . '<b>' . $lang['DEBUG_sql_error'] . ':</b> ' . $sql_error['code'] . ' ' . $sql_error['message'];
		}

		if ( $sql_store != '' )
		{
			$debug_text .= '<br /><br /><div align="left">
					<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center">
						<tr> 
	  						<td><span class="genmed"><b>' . $lang['DEBUG_sql_query'] . ':</b></span></td>
						</tr>
						<tr>
	  						<td class="code">' . $sql_store . '</td>
						</tr>
					</table></div>';
		}

		/*
		if (empty($err_line) || empty($err_file))
		{
			echo '<pre>';
			debug_print_backtrace();
			echo '</pre>';
		}*/

		if ( $err_line != '' && $err_file != '' )
		{
			//
			// On va ouvrir le fichier incriminé et récupéré ll ligne de l'erreur ainsi que la ligne suivante et les 5 lignes précédentes
			//
			$file_array = array();
			$file_array = explode('/', $err_file);
			$file_name = $file_array[count($file_array)-1];
			$dir_name = $file_array[count($file_array)-2];

			if ( $dir_name == 'includes' )
			{
				$phpbb_relativ_path = $phpbb_root_path . 'includes/';
			}
			else if ( ereg('^lang_', $dir_name) )
			{
				$phpbb_relativ_path = $phpbb_root_path . 'language/' . $dir_name . '/';
			}
			else if ( $dir_name == 'admin' )
			{
				$phpbb_relativ_path = $phpbb_root_path . 'admin/';
			}
			else	
			{
				// V: fix that for windows
				// maybe that broke it on oter systems :D
				$phpbb_relativ_path = '';//$phpbb_root_path;
			}

			$file_code_array = array();
			$file_code_array = @file($phpbb_relativ_path . $file_name);

			// rajoutez des données dans le tableau si vous souhaitez effectuer un débuggage plus large
			$loop_number = range(10, 0);

			// décalage, permet d'afficher des lignes + loin
			$offset = 3;

			$file_code_draw = '';
			for ( $i=0; $i<count($loop_number); $i++ )
			{
				$curline = $err_line - $loop_number[$i] + 1 + $offset;
				$file_code_draw .= '<b>' . $lang['DEBUG_line'] . '-' . $curline . ($curline == $err_line ? '!' : ':')
				 . '</b>&nbsp;&nbsp;' . $file_code_array[$err_line - $loop_number[$i] + $offset] . '<br />';
			}

			// pour éviter toute faille de sécurité il n y aura jamais de débuggage dans config.php
			$file_code_draw = ( ereg('^config.' . $phpEx . '$', $file_name) ) ? '' : $file_code_draw;

			$debug_text .= '<blockquote><div align="left"><br />
						<b>' . $lang['DEBUG_line'] . ':</b> ' . $err_line . '<br />
						<b>' . $lang['DEBUG_file'] . ':</b> ' . $err_file . '</div></blockquote>';

			if ( $file_code_draw != '' )
			{
				$debug_text .= '<br /><div align="left">
					<table width="90%" cellspacing="1" cellpadding="3" border="0" align="center">
						<tr> 
	  						<td><span class="genmed"><b>' . $lang['DEBUG_code_debbuger'] . ':</b></span></td>
						</tr>
						<tr>
	  						<td class="code">' . $file_code_draw . '</td>
						</tr>
					</table></div>';
			}
		}
	}

	if( empty($userdata) && ( $msg_code == GENERAL_MESSAGE || $msg_code == GENERAL_ERROR ) )
	{
		$userdata = session_pagestart($user_ip, PAGE_INDEX);
		init_userprefs($userdata);
	}

	//
	// If the header hasn't been output then do it
	//
	if ( !defined('HEADER_INC') && $msg_code != CRITICAL_ERROR )
	{
		if ( empty($lang) )
		{
			if ( !empty($board_config['default_lang']) )
			{
				include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_main.'.$phpEx);
			}
			else
			{
				include($phpbb_root_path . 'language/lang_french/lang_main.'.$phpEx);
			}
//-- mod : language settings ---------------------------------------------------
//-- add
			include($phpbb_root_path . 'includes/lang_extend_mac.' . $phpEx);
//-- fin mod : language settings -----------------------------------------------			
		}

		if ( empty($template) || empty($theme) )
		{
			$theme = setup_style($board_config['default_style']);
		}

		$toggle_unreads_link = true;		
		//
		// Load the Page Header
		//
		if ( !defined('IN_ADMIN') )
		{
			include($phpbb_root_path . 'includes/page_header.'.$phpEx);
		}
		else
		{
			include($phpbb_root_path . 'admin/page_header_admin.'.$phpEx);
		}
	}

	switch($msg_code)
	{
		case GENERAL_MESSAGE:
			if ( $msg_title == '' )
			{
				$msg_title = $lang['Information'];
			}
			break;

		case CRITICAL_MESSAGE:
			if ( $msg_title == '' )
			{
				$msg_title = $lang['Critical_Information'];
			}
			break;

		case GENERAL_ERROR:
			if ( $msg_text == '' )
			{
				$msg_text = $lang['An_error_occured'];
			}

			if ( $msg_title == '' )
			{
				$msg_title = $lang['General_Error'];
			}
			break;

		case CRITICAL_ERROR:
			//
			// Critical errors mean we cannot rely on _ANY_ DB information being
			// available so we're going to dump out a simple echo'd statement
			//
			include($phpbb_root_path . 'language/lang_french/lang_main.'.$phpEx);

			if ( $msg_text == '' )
			{
				$msg_text = $lang['A_critical_error'];
			}

			if ( $msg_title == '' )
			{
				$msg_title = 'phpBB : <b>' . $lang['Critical_Error'] . '</b>';
			}
			break;
	}

	//
	// Add on DEBUG info if we've enabled debug mode and this is an error. This
	// prevents debug info being output for general messages should DEBUG be
	// set TRUE by accident (preventing confusion for the end user!)
	//
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) )
	{
		if ( $debug_text != '' )
		{
			$msg_text = $msg_text . '<br /><br /><b><u>' . $lang['DEBUG'] . '</u></b>' . $debug_text;
		}
	}

	if ( $msg_code != CRITICAL_ERROR )
	{
		if ( !empty($lang[$msg_text]) )
		{
			$msg_text = $lang[$msg_text];
		}

		if ( !defined('IN_ADMIN') )
		{
			$template->set_filenames(array(
				'message_body' => 'message_body.tpl')
			);
		}
		else
		{
			$template->set_filenames(array(
				'message_body' => 'admin/admin_message_body.tpl')
			);
		}

		$template->assign_vars(array(
			'MESSAGE_TITLE' => $msg_title,
			'MESSAGE_TEXT' => $msg_text)
		);
		$template->pparse('message_body');

		if ( !defined('IN_ADMIN') )
		{
			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		}
		else
		{
			include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);
		}
	}
	else
	{
		echo "<html>\n<body>\n" . $msg_title . "\n<br /><br />\n" . $msg_text . "</body>\n</html>";
	}

	exit;
}

// V: Well, PHP4 is dead.
function phpbb_realpath($path)
{
	return realpath($path);
}

function redirect($url)
{
	global $db, $board_config;

	if (!empty($db))
	{
		$db->sql_close();
	}
//-- mod : rank color system ---------------------------------------------------
//-- add
	// Make sure no &amp;'s are in, this will break the redirect
	$url = str_replace('&amp;', '&', $url);
//-- fin mod : rank color system -----------------------------------------------
	if (strstr(urldecode($url), "\n") || strstr(urldecode($url), "\r") || strstr(urldecode($url), ';url'))
	{
		message_die(GENERAL_ERROR, 'Tried to redirect to potentially insecure url.');
	}

	$server_protocol = ($board_config['cookie_secure']) ? 'https://' : 'http://';
	$server_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['server_name']));
	$server_port = ($board_config['server_port'] <> 80) ? ':' . trim($board_config['server_port']) : '';
	$script_name = preg_replace('#^\/?(.*?)\/?$#', '\1', trim($board_config['script_path']));
	$script_name = ($script_name == '') ? $script_name : '/' . $script_name;
	$url = preg_replace('#^\/?(.*?)\/?$#', '/\1', trim($url));

	// Redirect via an HTML form for PITA webservers
	if (@preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')))
	{
		header('Refresh: 0; URL=' . $server_protocol . $server_name . $server_port . $script_name . $url);
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><meta http-equiv="refresh" content="0; url=' . $server_protocol . $server_name . $server_port . $script_name . $url . '"><title>Redirect</title></head><body><div align="center">If your browser does not support meta redirection please click <a href="' . $server_protocol . $server_name . $server_port . $script_name . $url . '">HERE</a> to be redirected</div></body></html>';
		exit;
	}

	// Behave as per HTTP/1.1 spec for others
	header('Location: ' . $server_protocol . $server_name . $server_port . $script_name . $url);
	exit;
}

function create_date_ex($format, $gmepoch, $tz)
{
  global $lang;

  static $today, $yesterday, $time;
  if(empty($today))
  {
    $today = array();
    $yesterday = array();
    $time = time();
  }
  $str = create_date($format, $gmepoch, $tz);
  if(empty($today[$format]))
  {
    $today[$format] = create_date($format, $time, $tz);
    $yesterday[$format] = create_date($format, $time - 86400, $tz);
  }
  if($str === $today[$format])
  {
    return '<span class="date-today">' . $lang['TY-Today'] . '</span>';
  }
  elseif($str === $yesterday[$format])
  {
    return '<span class="date-yesterday">' . $lang['TY-Yesterday'] . '</span>';
  }
  return $str;
}

function create_date2($format, $gmepoch, $tz)
{
	global $lang, $board_config;  

	if ($board_config['ty_use_rel_time'])
	{
		$time_ago = time() - $gmepoch;  
		$hours_ago = gmdate("H", $time_ago);  
		$mins_ago = gmdate("i", $time_ago);  
	  $secs_ago = gmdate("s", $time_ago);  
		 
		$hours_text = ( intval($hours_ago) == 1 ) ? $lang['TY-hr'] : $lang['TY-hrs'];  
		$mins_text = ( intval($mins_ago) == 1 ) ? $lang['TY-min'] : $lang['TY-mins'];  
		if( intval($hours_ago) == 0 && intval($mins_ago) == 0 )  
		{  
			$ago_text = $lang['TY-seconds_ago'];  
		}  
		else  
		{  
			$ago_text = ( (intval($hours_ago) != 0) ? $lang['TY-ago'] . $hours_ago . $hours_text  : '') . $mins_ago . $mins_text;  
		}
		$tmp = create_date_ex(substr($format, 0, strpos($format, ':') -2), $gmepoch, $tz);    
		
		if ($board_config['ty_use_rel_date'])
		{
			$str = $tmp . ( ($tmp != '<span class="date-today">' . $lang['TY-Today'] . '</span>') ? create_date(substr($format, strpos($format, ':') -2), $gmepoch, $tz) : $ago_text);
		}
		else
		{
			$str = create_date(substr($format, 0, strpos($format, ':') -2), $gmepoch, $tz);
			$str = ($tmp != '<span class="date-today">' . $lang['TY-Today'] . '</span>') ? $str . ' ' .create_date(substr($format, strpos($format, ':') -2), $gmepoch, $tz) : $ago_text;
		}
	}
	elseif ($board_config['ty_use_rel_date'])
	{
	  $str = create_date_ex(substr($format, 0, strpos($format, ':') -2), $gmepoch, $tz);
		$str .= create_date(substr($format, strpos($format, ':') -2), $gmepoch, $tz);
  }
	else
	{
		$str = create_date($format, $gmepoch, $tz);
	}
	return $str;
}

//-- mod : quick post es -------------------------------------------------------
//-- add
function display_qpes_data($qp_acp=false)
{
	global $board_config, $userdata, $lang, $template;

	// reset data
	$user_qp = $user_qp_show = $user_qp_subject = $user_qp_bbcode = $user_qp_smilies = $user_qp_more = 0;

	// is admin
	$qp_admin = $userdata['session_logged_in'] && ($userdata['user_level'] == ADMIN);

	// config data
	if (!empty($board_config['users_qp_settings']))
	{
		list($board_config['user_qp'], $board_config['user_qp_show'], $board_config['user_qp_subject'], $board_config['user_qp_bbcode'], $board_config['user_qp_smilies'], $board_config['user_qp_more']) = explode('-', $board_config['users_qp_settings']);
	}

	// user data
	if (!empty($userdata['user_qp_settings']))
	{
		list($user_qp, $user_qp_show, $user_qp_subject, $user_qp_bbcode, $user_qp_smilies, $user_qp_more) = explode('-', $userdata['user_qp_settings']);
	}

	// check if quick reply is enabled
	$qp_on = intval($board_config['user_qp']);

	// options list
	$options = array(
		array('title' => 'qp_enable', 'desc' => 'qp_enable_explain', 'var' => 'user_qp'),
		array('title' => 'qp_show', 'desc' => 'qp_show_explain', 'var' => 'user_qp_show'),
		array('title' => 'qp_subject', 'desc' => 'qp_subject_explain', 'var' => 'user_qp_subject'),
		array('title' => 'qp_bbcode', 'desc' => 'qp_bbcode_explain', 'var' => 'user_qp_bbcode'),
		array('title' => 'qp_smilies', 'desc' => 'qp_smilies_explain', 'var' => 'user_qp_smilies'),
		array('title' => 'qp_more', 'desc' => 'qp_more_explain', 'var' => 'user_qp_more'),
	);

	// build options form
	foreach ($options as $option => $result)
	{
		$qp_var = $result['var'];
		$qp_cfg = $board_config[$qp_var];

		if (!empty($qp_acp))
		{
			$tpl_data = array(
				'QP_YES' => ($$qp_var) ? ' checked="checked"' : '',
				'QP_NO' => (!$$qp_var) ? ' checked="checked"' : '',
			);
		}
		else
		{
			$tpl_data = array(
				'QP_YES' => ((($qp_var == 'user_qp') ? !$qp_on : (!$qp_cfg || !$qp_on)) && !$qp_admin) ? ' disabled="disabled"' : (($$qp_var) ? ' checked="checked"' : ''),
				'QP_NO' => ((($qp_var == 'user_qp') ? !$qp_on : (!$qp_cfg || !$qp_on)) && !$qp_admin) ?  ' disabled="disabled"' : ((!$$qp_var) ? ' checked="checked"' : ''),
			);
		}

		// options constants
		$template->assign_block_vars('qpes', $tpl_data + array(
			'L_QP_TITLE' => $lang[$result['title']],
			'L_QP_DESC' => $lang[$result['desc']],
			'QP_VAR' => $qp_var,
		));
	}
}
//-- fin mod : quick post es ---------------------------------------------------

//-- mod : flags ---------------------------------------------------------------
//-- add
function display_flag($flag, $force=false, $tpl_level='')
{
	global $phpbb_root_path, $board_config, $template, $lang;

	$data_flag = array();
	$tpl_data = array();
	if ( !empty($flag) )
	{
		$flags_path = $phpbb_root_path . ( empty($board_config['flags_path']) ? 'images/flags' : trim(preg_replace('#(.*)?\/?$#', '\1', trim($board_config['flags_path']))) );
		if ( $flags_path[ (strlen($flags_path)-1) ] != '/' )
		{
			$flags_path .= '/';
		}

		$flag_tmp = str_replace('_', ' ', substr($flag, 0, 0 - strlen(strrchr($flag, '.'))));
		$data_flag = array(
			'name' => lang_item($flag_tmp),
			'img' => $flags_path . $flag,
		);
		unset($flag_tmp);

		$tpl_data = !empty($force) ? array(): array(
			'FLAG_NAME' => $data_flag['name'],
			'FLAG_IMG' => $data_flag['img'],
		);
	}

	if ( !empty($force) )
	{
		return $data_flag;
	}

	// send to template
	$template->assign_vars(array(
		'L_FLAG' => $lang['flag_country'],
		'L_FLAG_NONE' => $lang['flag_none'],
	));

	if ( !empty($flag) )
	{
		$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'flag', $tpl_data);
	}
	else
	{
		$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'flag_ELSE', array());
	}

	return;
}

function get_flags_list($flag)
{
	global $phpbb_root_path, $board_config, $template, $lang, $images, $get;

	$flags_path = $phpbb_root_path . ( empty($board_config['flags_path']) ? 'images/flags' : trim(preg_replace('#(.*)?\/?$#', '\1', trim($board_config['flags_path']))) );
	if ( $flags_path[ (strlen($flags_path)-1) ] != '/' )
	{
		$flags_path .= '/';
	}

	// get available flags icons
	$flags_icons = array();
	$dir = @opendir(phpbb_realpath($flags_path));
	while ( $file = @readdir($dir) )
	{
		if ( preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $file) )
		{
			$flags_icons[ $file ] = str_replace('_', ' ', substr($file, 0, 0 - strlen(strrchr($file, '.'))));
		}
	}
	@closedir($dir);

	// build form
	$flags_list = '';
	if ( !empty($flags_icons) )
	{
		asort($flags_icons);

		// html for flag_name field
		$html = ' onchange="if (this.options[selectedIndex].value != \'\') {document.post.flag_img.src = \'' . $flags_path . '\' + this.options[selectedIndex].value} else {document.post.flag_img.src=\'' . $phpbb_root_path . $images['spacer'] . '\'}"';

		$data['options'] = array('' => 'no_flag') + $flags_icons;

		$flags_list = '<select name="flag"' . $html . '>';
		foreach ( $data['options'] as $val => $desc )
		{
			$selected = ( $val == $flag ) ? ' selected="selected"' : '';
			$flags_list .= '<option value="' . $val . '"' . $selected . '>' . lang_item($desc) . '</option>';
		}
		$flags_list .= '</select>';
	}

	// send to template
	$template->assign_vars(array(
		'I_FLAG' => !empty($flag) ? $flags_path . $flag : $phpbb_root_path . $images['spacer'],

		'L_FLAG' => $lang['flag_country'],
		'L_FLAG_TITLE' => $lang['flag_icon'],

		'S_FLAGS_LIST' => $flags_list,
	));
	$get->assign_switch('flags', !empty($flags_icons));
}
//-- fin mod : flags -----------------------------------------------------------

//+MOD: DHTML Collapsible Forum Index MOD
function get_cfi_cookie_name()
{
	global $board_config, $HTTP_GET_VARS;

	$k = $board_config['cookie_name'].'_CFI_cats';
	if( isset($board_config['sub_forum']) )
	{
		$k .= '_'.isset($board_config['sub_forum']);
		if( isset($HTTP_GET_VARS['c']) )
		{
			$k .= '_'.$HTTP_GET_VARS['c'];
		}
	}
	return $k;
}
function is_category_collapsed($cat_id)
{
	global $board_config, $HTTP_COOKIE_VARS;
	static $collapsed_cats = false;

	if( intval($board_config['sub_forum']) == 2 )
	{
		return false;
	}
	if( !is_array($collapsed_cats) )
	{
		if( isset($HTTP_COOKIE_VARS[get_cfi_cookie_name()]) )
		{
			$collapsed_cats = explode(':', $HTTP_COOKIE_VARS[get_cfi_cookie_name()]);
		}
		else
		{
			$collapsed_cats = array();
		}
	}
	return in_array($cat_id, $collapsed_cats) ? true : false;
}
//-MOD: DHTML Collapsible Forum Index MOD
//-- mod : toolbar -------------------------------------------------------------
//-- add
function build_toolbar($mode, $l_privmsgs_text='', $s_privmsg_new=0, $forum_id=0, $tlbr_more='')
{
	global $userdata, $template, $lang, $images, $phpEx;

	// restrict mode input to valid options
	$mode = ( in_array($mode, array('default', 'index', 'viewforum', 'viewtopic')) ) ? $mode : '';

	if ( !empty($mode) && $userdata['session_logged_in'] )
	{
		// init vars
		$s_toolbar = '';

		// toolbar actions details display
		$toolbar_actions = array(
			'inbox' => array('link_pgm' => 'privmsg', 'link_parms' => array('folder' => 'inbox'), 'txt' => $l_privmsgs_text, 'img' => !$s_privmsg_new ? 'tlbr_no_new_pm' : 'tlbr_new_pm'),
			'unanswered' => array('link_pgm' => 'search', 'link_parms' => array('search_id' => 'unanswered'), 'txt' => 'Search_unanswered', 'img' => 'tlbr_unanswered'),
			'newposts' => array('link_pgm' => 'search', 'link_parms' => array('search_id' => 'newposts'), 'txt' => 'Search_new', 'img' => 'tlbr_new'),
			'egosearch' => array('link_pgm' => 'search', 'link_parms' => array('search_id' => 'egosearch'), 'txt' => 'Search_your_posts', 'img' => 'tlbr_self'),
			'forums' => array('link_pgm' => 'index', 'link_parms' => array(POST_FORUM_URL => intval($forum_id), 'mark' => 'forums'), 'txt' => 'Mark_all_forums', 'img' => 'tlbr_markall', 'cond' => $mode == 'index'),
			'topics' => array('link_pgm' => 'viewforum', 'link_parms' => array(POST_FORUM_URL => intval($forum_id), 'mark' => 'topics'), 'txt' => 'Mark_all_topics', 'img' => 'tlbr_markall', 'cond' => !empty($forum_id) && ($mode == 'viewforum' || $mode == 'viewtopic')),
			'viewonline' => array('link_pgm' => 'viewonline', 'link_parms' => '', 'txt' => 'Who_is_Online', 'img' => 'tlbr_viewonline', 'cond' => $mode != 'viewtopic'),
		);

		// add additional actions in toolbar so existing
		if ( !empty($tlbr_more) && is_array($tlbr_more) )
		{
			$toolbar_actions = array_merge($toolbar_actions, $tlbr_more);
		}

		// let's go
		foreach ( $toolbar_actions as $action => $data )
		{
			if ( !isset($data['cond']) || $data['cond'] )
			{
				// build url parms
				$url_parms = '';
				if ( !empty($data['link_parms']) )
				{
					foreach ( $data['link_parms'] as $key => $val )
					{
						if ( !empty($key) && !empty($val) )
						{
							$url_parms .= (empty($url_parms) ? '?' : '&amp;') . $key . '=' . $val;
						}
					}
				}

				// build toolbar
				$s_toolbar .= '<a href="' . append_sid($data['link_pgm']. '.' . $phpEx . $url_parms) . '"><img src="' . $images[ $data['img'] ] . '" alt="' . ( $action == 'inbox' ? $data['txt'] : $lang[ $data['txt'] ] ) . '" title="' . ( $action == 'inbox' ? $data['txt'] : $lang[ $data['txt'] ] ) . '" border="0" /></a>';
			}
		}

		// send to template
		if ( !empty($s_toolbar) )
		{
			// constants
			$template->assign_block_vars('toolbar', array(
				'S_TOOLBAR' => $s_toolbar,
			));
		}
	}
}
//-- fin mod : toolbar ---------------------------------------------------------
//-- mod : post description ----------------------------------------------------
//-- add
function display_sub_title($tpl_level, $sub_title='', $display=true)
{
	global $template, $lang;

	$template->assign_vars(array(
		'L_SUB_TITLE' => $lang['Sub_title'],
	));

	if ( intval($display) && !empty($sub_title) )
	{
		$template->assign_block_vars((empty($tpl_level) ? '' : $tpl_level . '.') . 'sub_title', array(
			'SUB_TITLE' => $sub_title,
		));
	}
}
//-- fin mod : post description ------------------------------------------------
// Default avatar MOD, By Manipe (Begin)

//
// Sets the default avatar for users
//
function default_avatar($userdata, &$avatar_img)
{
	global $db, $board_config, $gallery_avatars, $phpbb_root_path;

	//
	// If a user has an avatar and admin doesn't want to override, abort!
	//
	if (!empty($avatar_img) && !$board_config['default_avatar_override'])
	{
		return;
	}

	//
	// If the user doesn't want the default avatar to be shown and the admin allows it, abort!
	//
	if (!$userdata['user_allowdefaultavatar'] && $board_config['default_avatar_choose'])
	{
		return;
	}

	//
	// No point getting images unless the user might use them
	//
	if ($board_config['default_avatar'])
	{
		// Get images only if admin allows it and if $default_avatars is not set
		if (empty($gallery_avatars) && $board_config['default_avatar_random'])
		{
			default_avatar_scan_dir($phpbb_root_path . $board_config['avatar_gallery_path']);
		}

		//
		// Find out which avatar to show
		//
		if ($board_config['default_avatar_random'])
		{
			$avatar_img = '<img src="' . $gallery_avatars[array_rand($gallery_avatars)] . '" alt="" border="0" />';
		}
		elseif (($board_config['default_avatar_type'] == DEFAULT_AVATAR_USERS) && ($userdata['user_id'] != ANONYMOUS) && ($board_config['default_avatar_users']))
		{
			$avatar_img = '<img src="' . $board_config['default_avatar_users'] . '" alt="" border="0" />';
		}
		elseif (($board_config['default_avatar_type'] == DEFAULT_AVATAR_GUESTS) && ($userdata['user_id'] == ANONYMOUS) && ($board_config['default_avatar_guests']))
		{
			$avatar_img = '<img src="' . $board_config['default_avatar_guests'] . '" alt="" border="0" />';
		}
		elseif ($board_config['default_avatar_type'] == DEFAULT_AVATAR_BOTH)
		{
			if (($userdata['user_id'] == ANONYMOUS) && $board_config['default_avatar_guests'])
			{
				$avatar_img = '<img src="' . $board_config['default_avatar_guests'] . '" alt="" border="0" />';
			}
			elseif (($userdata['user_id'] != ANONYMOUS) && $board_config['default_avatar_users'])
			{
				$avatar_img = '<img src="' . $board_config['default_avatar_users'] . '" alt="" border="0" />';
			}
		}
	}
}

//
// Retrieves all avatars in the images/avatars/gallery folder. Also searches subfolders
//
function default_avatar_scan_dir($parent, $dir = "")
{
	global $gallery_avatars;

	$dh  = opendir($parent . $dir);
	while (($filename = @readdir($dh)) !== false)
	{
		if ($filename != "." && $filename != "..")
		{
			if (preg_match('/(\.gif$|\.png$|\.jpg|\.jpe)/is', $filename))
			{
				$gallery_avatars[] = $parent . $dir . "/" . $filename;
			}
			elseif (is_dir("{$parent}{$dir}/{$filename}"))
			{
				default_avatar_scan_dir($parent . $dir . "/", $filename);
			}
		}
	}
	opendir("..");
}
// Default avatar MOD, By Manipe (End)
//-- mod : hypercell class -----------------------------------------------------
//-- add
function get_hypercell_class($topic_status, $unread_topics=false, $topic_type=0, $topic_replies=0, $is_link=false)
{
	global $board_config;

	// init
	$hot_topic = !empty($topic_replies) && ( intval($topic_replies) >= intval($board_config['hot_threshold']) );

	switch ( $topic_type )
	{
		case POST_GLOBAL_ANNOUNCE:
			$hcc = 'hccRow-announce';
		break;
		case POST_ANNOUNCE:
			$hcc = 'hccRow-announce';
		break;
		case POST_STICKY:
			$hcc = 'hccRow-sticky';
		break;
		default:
			$hcc = $hot_topic ? 'hccRow-hot' : ( $is_link ? 'hccRow-link' : 'hccRow' );
			$unread_topics = $is_link ? false : $unread_topics;
		break;
	}

	switch ( $topic_status )
	{
		case TOPIC_MOVED:
			$hcc = 'hccRow-moved';
			$unread_topics = false;
		break;
		case TOPIC_LOCKED:
			$hcc = 'hccRow-locked';
		break;
	}

	return $hcc . ( !empty($unread_topics) ? '-new' : '' );
}
//-- fin mod : hypercell class -------------------------------------------------
// www.phpBB-SEO.com SEO TOOLKIT BEGIN
/**
* tell if user is a bot on ip match
*/
function is_bot($user_ip) {
	global $bot_ips;
	if ( !empty($bot_ips) ) {
		foreach ( $bot_ips as $bot_id => $bot_ip) {
			if ( strpos(trim($user_ip), $bot_ip) === 0) {
				return $bot_id;
			}
		}
	}
	return -1;
}
// www.phpBB-SEO.com SEO TOOLKIT END
//START MOD Keep_Unread_2
// maximum number of items (topic_id) per cookie
define('MAX_COOKIE_ITEM', 300);
//Default if no board setting
define('KEEP_UNREAD_DB', TRUE);

function read_cookies($userdata)
{
	global $board_config, $HTTP_COOKIE_VARS;

	// do we use the tracking ?
	if ( !isset($board_config['keep_unreads']) )
	{
		$board_config['keep_unreads'] = true;
	}
	if ( !isset($board_config['keep_unreads_db']) )
	{
		$board_config['keep_unreads_db'] = KEEP_UNREAD_DB;
	}
	// do we use database to store data ?
	if ( !$userdata['session_logged_in'] || !$board_config['keep_unreads'] )
	{
		$board_config['keep_unreads_db'] = false;
	}
	// cookies name
	$user_id = ( $userdata['user_id'] == ANONYMOUS ? '_' : $userdata['user_id']);
	$base_name = $board_config['cookie_name'] . '_' . $user_id;

	// get the anonymous last visit date
	if ( !$userdata['session_logged_in'] )
	{
		if (empty($_COOKIE[$base_name . '_lastvisit']))
		{
			$userdata['user_lastvisit'] = time();
		}
		else
		{
			$userdata['user_lastvisit'] = intval($_COOKIE[$base_name . '_lastvisit']);
			if ( $userdata['user_lastvisit'] < (time()-300) )
			{
				$userdata['user_lastvisit'] = time();
			}
		}
	}
	setcookie($base_name . '_lastvisit', intval($userdata['user_lastvisit']), time() + 31536000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);

	//Assume old system: data in cookie
	$board_config['tracking_time']		= isset($_COOKIE[$base_name . '_tt']) ? intval($_COOKIE[$base_name . '_tt']) : $userdata['user_lastvisit'];
	$board_config['tracking_forums']	= isset($_COOKIE[$base_name . '_f']) ? unserialize($_COOKIE[$base_name . '_f']) : array();
	$board_config['tracking_unreads'] = array();
	if ( $board_config['keep_unreads'] )
	{
		if ( $userdata['session_logged_in'] && $board_config['keep_unreads_db'] )
		{
			$temp = explode('//', $userdata['user_unread_topics']);
			if (!empty($temp[1]))
			{
				$board_config['tracking_time'] = $temp[1];
				$w_forums = ($temp[2] ? explode(';', $temp[2]) : array());
  				for ( $i = 0; $i < count($w_forums); $i++ )
  				{
  					$forum_data = explode(':', $w_forums[$i]);
  					$board_config['tracking_forums'][ intval($forum_data[0]) ] = intval($forum_data[1]);
  				}
			}
			$w_unreads = $temp[0] ? explode(';', $temp[0]) : array();
			if ($w_unreads)
			{
				$tracking_floor = intval($w_unreads[0]); // we don't use serialized data to gain some digits
				for ( $i = 1; $i < count($w_unreads); $i++ )
				{
					$topic_data = explode(':', $w_unreads[$i]);
					$board_config['tracking_unreads'][ intval($topic_data[0]) ] = intval($topic_data[1]) + $tracking_floor;
				}
			}
		}
		else //not logged in or not database: cookie. If you delete this block then guests have no unread functionality
  		{
			//the tracking floor (min time value) allows to reduce the size of the time data, so the size of the cookie is smaller
      $val = isset($_COOKIE[$base_name . '_uf']) ? $_COOKIE[$base_name . '_uf'] : 0;
			$tracking_floor = intval($val);
			$board_config['tracking_unreads'] = isset($HTTP_COOKIE_VARS[$base_name . '_u']) ? unserialize($HTTP_COOKIE_VARS[$base_name . '_u']) : array();
			@reset( $board_config['tracking_unreads'] );
			while ( list($id, $time) = @each($board_config['tracking_unreads']) )
			{
				if ( intval($id) > 0 )
				{
					$board_config['tracking_unreads'][intval($id)] = intval($time) + $tracking_floor;
				}
				else
				{
					unset($board_config['tracking_unreads'][$id]);
				}
			}
		}
	}
	define('COOKIE_READ', true);
}

function write_cookies($userdata)
{
	global $board_config, $HTTP_COOKIE_VARS, $db;

	// do we use the tracking ?
	if ( !isset($board_config['keep_unreads']) )
	{
		$board_config['keep_unreads'] = true;
	}
	if ( !isset($board_config['keep_unreads_db']) )
	{
		$board_config['keep_unreads_db'] = KEEP_UNREAD_DB;
	}

	// do we use database to store data ?
	if ( !$userdata['session_logged_in'] || !$board_config['keep_unreads'] )
	{
		$board_config['keep_unreads_db'] = false;
	}

	// check if the cookie has been read (prevent any erase)
	if ( !defined('COOKIE_READ') )
	{
		return;
	}

	// cookies name
	$user_id = ( $userdata['user_id'] == ANONYMOUS ? '_' : $userdata['user_id']);
	$base_name = $board_config['cookie_name'] . '_' . $user_id;

	if ( $board_config['keep_unreads'] )
	{
		// sort the unread array
		if ( !empty($board_config['tracking_unreads']) )
		{
			asort($board_config['tracking_unreads']);
		}
		if ( count($board_config['tracking_unreads']) > MAX_COOKIE_ITEM )
		{
			$nb = count($board_config['tracking_unreads']) - MAX_COOKIE_ITEM;
			while ( ($nb > 0) && ( list($id, $time) = @each($board_config['tracking_unreads']) ) )
			{
				unset($board_config['tracking_unreads'][$id]);
				$nb--;
			}
		}
	}

	if (defined('IN_INDEX'))
	{
		return;
	}

	// store the unread topics
	$sql = '';
	if ( $board_config['keep_unreads'] )
	{
		// the array is already sorted
		$tracking_floor = 0;
		$tracking_forums = $board_config['tracking_forums'];
		$tracking_unreads = $board_config['tracking_unreads'];

		//Change all times to offset from lowest time.
		if ( !empty($tracking_unreads) )
		{
			$first_found = false;
			$tracking_floor = 0;
			@reset($tracking_unreads);
			while ( list($id, $time) = @each($tracking_unreads) )
			{
				if ( !$first_found )
				{
					$tracking_floor = intval($time);
					$first_found = true;
				}
				$tracking_unreads[$id] -= $tracking_floor;
			}
		}

		if ( $board_config['keep_unreads_db'] && $userdata['session_logged_in'] )
		{
			$data = intval($tracking_floor);
			reset($tracking_unreads);
			while ( list($id, $time) = each($tracking_unreads) )
			{
				if ($id) $data .= ';' . intval($id) . ':' . intval($time);
			}
			$data .= '//' . intval($board_config['tracking_time']) . '//';
			reset($tracking_forums);//board_config['tracking_forums']);
			while ( list($id, $time) = each($tracking_forums)) //$board_config['tracking_forums']) )
			{
				if ($id) $data .= ';' . intval($id) . ':' . intval($time);
			}
			//Erase old cookies
			setcookie($base_name . '_tt', '', 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			setcookie($base_name . '_f', '', 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			setcookie($base_name . '_uf', '', 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			setcookie($base_name . '_u', '', 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			$sql = "UPDATE " . USERS_TABLE . "
				SET user_unread_topics = '$data'
				WHERE user_id = " . intval($userdata['user_id']);
		}
		else
		{
    		setcookie($base_name . '_tt', intval($board_config['tracking_time']), time() + 31536000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
    		setcookie($base_name . '_f', serialize($board_config['tracking_forums']), time() + 31536000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			setcookie($base_name . '_uf', intval($tracking_floor), time() + 31536000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			setcookie($base_name . '_u', serialize($tracking_unreads), time() + 31536000, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
			// erase the users table to prevent a timewrap if the user reactivate the unreads database storage
			if ( !empty($userdata['user_unread_topics']) && $userdata['session_logged_in'] )
			{
				$sql = "UPDATE " . USERS_TABLE . "
					SET user_unread_topics = NULL
					WHERE user_id = " . intval($userdata['user_id']);
			}
		}
	}
	if ( !empty($sql) )
	{
		if ( !$db->sql_query($sql) )
		{
			message_die(CRITICAL_ERROR, 'Failed to update users table for unread topics', '', __LINE__, __FILE__, $sql);
		}
	}
}

//Return an array with all true unreads and array with topics with new posts
//Will check everything and write new arrays to database / cookie
function list_new_unreads(&$forum_unread, $check_auth = 0)
{
	global $board_config, $userdata, $db;

	//Clean tracking_forums
	$tracking_time = ( $board_config['tracking_time'] != 0 ) ? $board_config['tracking_time'] : $userdata['user_lastvisit'];
	if ($tracking_time == '') $tracking_time = 0;	
	if ( !empty($board_config['tracking_forums']) )
	{
		@reset($board_config['tracking_forums']); //Mark whole forum as read records
		while ( list($id, $time) = @each($board_config['tracking_forums']) )
		{ //obsolete if forum was marked read before current visit time
			if ( $time <= $tracking_time )	unset($board_config['tracking_forums'][$id]);
		}
	}

	//get list of remembered topic id's
	@reset($board_config['tracking_unreads']); //Mark whole forum as read records
	$list_unreads = '';
	while ( list($id, $time) = @each($board_config['tracking_unreads']) )
	{
		if ($id) $list_unreads .= ($list_unreads ? ',':'') . $id;
	}

	$new_unreads = array();
	$forum_unread = array();
	$sql_and = array();
	$sql_and[] = "p.post_time > $tracking_time";
	if (!empty($list_unreads))
	{
		$sql_and[] = "t.topic_id IN ($list_unreads) AND (p.post_time <= $tracking_time)";
	}
	$check_auth_sql = '';
	
	// the next line of code artificially sets $auth_list to true so that when it is used later on
	// in an if statement the if statement will resolve to true if either (a) $check_auth is false (since in 
	// that case $auth_list never gets reset) or (b) $check_auth is true and the user is authorized
	// to view some forums
	$auth_list = TRUE;

	if ($check_auth)
	{
		// get a list of all forums the user is allowed to read
		$is_auth_ary = array();
		$forum_ids = array();
		$is_auth_ary = auth(AUTH_READ, AUTH_LIST_ALL, $userdata);
		if ( count($is_auth_ary) )
		{
			foreach ( $is_auth_ary as $forum_id => $auths )
			{
				if ( $auths['auth_read'] )
				{
					$forum_ids[] = $forum_id;
				}
			}
		}
		$auth_list = implode("," , $forum_ids);
		$check_auth_sql = "AND t.forum_id IN (" . $auth_list . ")";
	}

	//Get all topics
	// note that $auth_list may resolve to true if $check_auth is false (i.e. we are not checking authorizations on this board)
	// or alternatively if we are checking authorizations and there are in fact forums the user is authorized to view;
	// however, if we are checking authorizations and there are no forums the user is authorized to view we can skip the rest of this
	// since the user will not be shown any unreads, and that's what the next if statement is for
	if ($auth_list)
	{
		// V: made that into one unique query
		$sql = "SELECT t.forum_id, t.topic_id, p.post_time
				FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p
				WHERE p.post_id = t.topic_last_post_id
				AND (" . implode(') OR (', $sql_and) . ")
				$check_auth_sql
				AND t.topic_moved_id = 0";

		// this gets cached along with the posts
		if ( !($result = $db->sql_query($sql, false, 'posts_')) )
		{
			message_die(GENERAL_ERROR, 'Could not query new topic information', '', __LINE__, __FILE__, $sql);
		}

		while( $topic_data = $db->sql_fetchrow($result) ) //Keep the valid unread topics
		{
			$id = $topic_data['topic_id'];
			$topic_last_read = topic_last_read($topic_data['forum_id'], $id);
			if ( $topic_data['post_time'] > $topic_last_read)
			{
				$new_unreads[$id] = $topic_last_read;
				$forum_unread[$topic_data['forum_id']]=true;
			}
		}
		$db->sql_freeresult($result);
	}
	$board_config['tracking_time'] = time();
	$board_config['tracking_unreads'] = $new_unreads;
	write_cookies($userdata); //save

	return $new_unreads;
}

function topic_last_read($forum_id, $topic_id) //Returns a time stamp
{
	global $userdata, $board_config;
	$t = intval($board_config['tracking_unreads'][$topic_id]);
	//No tracking data at all, then last read when last logged in.
	if ($t == 0)  $t = (($board_config['tracking_time'] != 0) ? intval($board_config['tracking_time']) : $userdata['user_lastvisit']);
	return $t;
}
//END MOD Keep_unread_2
//
// Disable board if needed
//
function board_disable()
{
	global $board_config, $lang, $userdata;

	// avoid multiple function calls
	static $called = false;
	if ($called == true)
	{
		return;
	}
	$called = true;

	if ($board_config['board_disable'] && !defined('IN_ADMIN') && !defined('IN_LOGIN'))
	{
		$disable_mode = explode(',', $board_config['board_disable_mode']);
		$user_level = ($userdata['user_id'] == ANONYMOUS) ? ANONYMOUS : $userdata['user_level'];

		if (in_array($user_level, $disable_mode))
		{
			$disable_message = (!empty($board_config['board_disable_msg'])) ? htmlspecialchars($board_config['board_disable_msg']) : $lang['Board_disable'];
			message_die(GENERAL_MESSAGE, str_replace("\n", '<br />', $disable_message), 'Information');
		}
		else
		{
			define('BOARD_DISABLE', true);
		}
	}
}
//
// Password-protected topics/forums
//
function password_check ($mode, $id, $password, $redirect)
{
	global $db, $template, $theme, $board_config, $lang, $phpEx, $phpbb_root_path, $gen_simple_header;
	global $userdata;
	global $HTTP_COOKIE_VARS;

	$cookie_name = $board_config['cookie_name'];
	$cookie_path = $board_config['cookie_path'];
	$cookie_domain = $board_config['cookie_domain'];
	$cookie_secure = $board_config['cookie_secure'];

	switch($mode)
	{
		case 'topic':
			exit('Topic password disabled');
		/*
			$sql = "SELECT topic_password AS password FROM " . TOPICS_TABLE . " WHERE topic_id = $id";
			$passdata = ( isset($HTTP_COOKIE_VARS[$cookie_name . '_tpass']) ) ? unserialize(stripslashes($HTTP_COOKIE_VARS[$cookie_name . '_tpass'])) : '';
			$savename = $cookie_name . '_tpass';
			break;
		*/
		case 'forum':
			$sql = "SELECT forum_password AS password FROM " . FORUMS_TABLE . " WHERE forum_id = $id";
			$passdata = ( isset($HTTP_COOKIE_VARS[$cookie_name . '_fpass']) ) ? unserialize(stripslashes($HTTP_COOKIE_VARS[$cookie_name . '_fpass'])) : '';
			$savename = $cookie_name . '_fpass';
			break;
		default:
			$sql = '';
			$passdata = '';
	}

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Could not retrieve password', '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrow($result);
	if( $password != $row['password'] )
	{
		$message = $lang['Incorrect_'.$mode.'_password'];
		message_die(GENERAL_MESSAGE, $message);
	}

	$passdata[$id] = md5($password);
	setcookie($savename, serialize($passdata), 0, $cookie_path, $cookie_domain, $cookie_secure);

	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3; url="' . $redirect . '" />'
		)
	);

	$message = $lang['Password_login_success'] . '<br /><br />' . sprintf($lang['Click_return_page'], '<a href="' . $redirect . '">', '</a>');
	message_die(GENERAL_MESSAGE, $message);
}

function password_box ($mode, $s_form_action)
{
	global $db, $template, $theme, $board_config, $lang, $phpEx, $phpbb_root_path, $gen_simple_header;
	global $userdata;

	$l_enter_password = $lang['Enter_'.$mode.'_password'];

	$page_title = $l_enter_password;
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);

	$template->set_filenames(array(
		'body' => 'password_body.tpl'
		)
	);

	$template->assign_vars(array(
		'L_ENTER_PASSWORD' => $l_enter_password,
		'L_SUBMIT' => $lang['Submit'],
		'L_CANCEL' => $lang['Cancel'],

		'S_FORM_ACTION' => $s_form_action
		)
	);

	$template->pparse('body');
	include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
}
//-- mod : presentation required -----------------------------------------------
//-- add
// function based on a code part of "Yellow Cards" MOD
function forum_combo($forum_id)
{
	global $db, $lang, $board_config;

	$sql = 'SELECT f.forum_id, f.forum_name
		FROM ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c
		WHERE c.cat_id = f.cat_id ORDER BY c.cat_order ASC, f.forum_order ASC';
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Couldn\'t obtain forum list', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$forums_list = '<select name="' . $forum_id . '"><option value="0">' . $lang['Select_forum'] . '</option>';
	for ( $i = 0; $i < count($row); $i++ )
	{
		$selected = ( $row[$i]['forum_id'] == $board_config[ $forum_id ] ) ? ' selected="selected"' : '';
		$forums_list .= '<option value="' . $row[$i]['forum_id'] . '" ' . $selected . '>' . lang_item($row[$i]['forum_name']) . '</option>';
	}
	$forums_list .= '</select>';
	return $forums_list;
}
//-- fin mod : presentation required -------------------------------------------

?>
