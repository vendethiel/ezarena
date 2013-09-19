<?php
//
//	file: includes/functions_sf.php
//	author: Dicky
//	author: ptirhiik
//	begin: 03/10/2006
//	version: 0.0.4 - 29/10/2006
//	version: 0.0.5 - 12/12/2006
//	version: 0.0.6 - 04/01/2007
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}
define('SF_CURRENT_VERSION', '0.0.6');
define('SF_CONFIG_VERSION', 'mod_sf_version');

// index: return the folder icon depneding the forum status
function _sf_get_folder($size, $status)
{
	global $images;

	// front icon set: sf_img: images that can be created in your_template.cfg, img: default phpBB set of pics
	$folders_def = array(
		'mini' => array(
			'std' => array('sf_img' => 'sforum', 'img' => 'icon_latest_reply', 'txt' => 'No_new_posts'),
			'std_new' => array('sf_img' => 'sforum_new', 'img' => 'icon_newest_reply', 'txt' => 'New_posts'),
			'std_empty' => array('sf_img' => 'sforum_empty', 'img' => 'icon_minipost', 'txt' => 'No_Posts'),
			'std_locked' => array('sf_img' => 'sforum_locked', 'img' => 'icon_latest_reply', 'txt' => 'Forum_locked'),
			'std_locked_new' => array('sf_img' => 'sforum_locked_new', 'img' => 'icon_newest_reply', 'txt' => 'Forum_locked'),
			'std_locked_empty' => array('sf_img' => 'sforum_locked', 'img' => 'icon_minipost', 'txt' => 'Forum_locked'),

			'has_sub' => array('sf_img' => 'sforums', 'img' => 'icon_latest_reply', 'txt' => 'No_new_posts'),
			'has_sub_new' => array('sf_img' => 'sforums_new', 'img' => 'icon_newest_reply', 'txt' => 'New_posts'),
			'has_sub_empty' => array('sf_img' => 'sforums_empty', 'img' => 'icon_minipost', 'txt' => 'No_Posts'),
			'has_sub_locked' => array('sf_img' => 'sforums_locked', 'img' => 'icon_latest_reply', 'txt' => 'Forum_locked'),
			'has_sub_locked_new' => array('sf_img' => 'sforums_locked_new', 'img' => 'icon_newest_reply', 'txt' => 'Forum_locked'),
			'has_sub_locked_empty' => array('sf_img' => 'sforums_locked', 'img' => 'icon_minipost', 'txt' => 'Forum_locked'),
		),

		'standard' => array(
			'std' => array('img' => 'forum', 'txt' => 'No_new_posts'),
			'std_new' => array('img' => 'forum_new', 'txt' => 'New_posts'),
			'std_empty' => array('img' => 'forum', 'txt' => 'No_new_posts'),
			'std_locked' => array('img' => 'forum_locked', 'txt' => 'Forum_locked'),
			'std_locked_new' => array('sf_img' => 'forum_locked_new', 'img' => 'forum_locked', 'txt' => 'Forum_locked'),
			'std_locked_empty' => array('img' => 'forum_locked', 'txt' => 'Forum_locked'),

			'has_sub' => array('sf_img' => 'forums', 'img' => 'forum', 'txt' => 'No_new_posts'),
			'has_sub_new' => array('sf_img' => 'forums_new', 'img' => 'forum_new', 'txt' => 'New_posts'),
			'has_sub_empty' => array('sf_img' => 'forums_empty', 'img' => 'forum', 'txt' => 'No_Posts'),
			'has_sub_locked' => array('sf_img' => 'forums_locked', 'img' => 'forum_locked', 'txt' => 'Forum_locked'),
			'has_sub_locked_new' => array('sf_img' => 'forums_locked_new', 'img' => 'forum_locked', 'txt' => 'Forum_locked'),
			'has_sub_locked_empty' => array('sf_img' => 'forums_locked', 'img' => 'forum_locked', 'txt' => 'Forum_locked'),
		),
	);

	return array(
		'img' => $folders_def[$size][$status]['sf_img'] && isset($images[ $folders_def[$size][$status]['sf_img'] ]) ? $folders_def[$size][$status]['sf_img'] : $folders_def[$size][$status]['img'],
		'txt' => $folders_def[$size][$status]['txt'],
	);
}

// index (viewforum case only): mark all subforums from a root forum read
function _sf_mark_subs_read($_sf_root_forum_id, $varname='', $value='')
{
	global $db, $userdata, $board_config;
	global $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS;

	if ( !$userdata['session_logged_in'] )
	{
		return false;
	}
	if ( !empty($varname) )
	{
		$mark_read = trim(htmlspecialchars(stripslashes(isset($HTTP_POST_VARS[$varname]) ? $HTTP_POST_VARS[$varname] : (isset($HTTP_GET_VARS[$varname]) ? $HTTP_GET_VARS[$varname] : ''))));
		if ( $mark_read != (empty($value) ? 'forums' : $value) )
		{
			return false;
		}
	}

	$retained_forums = array();
	$sql = 'SELECT f.forum_id, f.forum_parent
				FROM ' . FORUMS_TABLE . ' f, ' . FORUMS_TABLE . ' fo
				WHERE fo.forum_id = ' . intval($_sf_root_forum_id) . '
					AND f.cat_id = fo.cat_id
					AND f.forum_order > fo.forum_order
				ORDER BY f.forum_order';
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query subforums data', '', __LINE__, __FILE__, $sql);
	}
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( (intval($row['forum_parent']) == $_sf_root_forum_id) || isset($retained_forums[ intval($row['forum_parent']) ]) )
		{
			$retained_forums[ intval($row['forum_id']) ] = true;
		}
	}
	$db->sql_freeresult($result);

	// add a cooky per forum
	if ( !empty($retained_forums) )
	{
		$tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) : array();
		foreach ( $retained_forums as $mark_forum_id => $dummy )
		{
			$tracking_forums[$mark_forum_id] = time();
		}
		setcookie($board_config['cookie_name'] . '_f', serialize($tracking_forums), 0, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	}
	return true;
}

// index: check if the forum is unread
// ADDON for Keep Unread2 by Paul99Ev
function _sf_check_unread($forum_id)
{
   global $forum_unreads;
   return !empty($forum_unreads[$forum_id]);
}

// index: stack data from a level into a main level
function _sf_stack($into, $from)
{
	global $rcs;
	$more_recent = $into && isset($into['forum_last_post_id']) && ($into['forum_last_post_id'] > $from['forum_last_post_id']);
	$stack = array(
		'forum_posts' => ($into && isset($into['forum_posts']) ? intval($into['forum_posts']) : 0) + intval($from['forum_posts']),
		'forum_topics' => ($into && isset($into['forum_topics']) ? intval($into['forum_topics']) : 0) + intval($from['forum_topics']),
		'unread' => (isset($into['forum_id']) ? _sf_check_unread($into['forum_id']) : false)
			|| (isset($from['forum_id']) ? _sf_check_unread($from['forum_id']) : false)
			|| !empty($from['unread']) || !empty($into['unread']),

		'forum_last_post_id' => $more_recent ? $into['forum_last_post_id'] : $from['forum_last_post_id'],
		'user_id' => $more_recent ? $into['user_id'] : $from['user_id'],
		'post_username' => $more_recent ? $into['post_username'] : $from['post_username'],
		//-- mod: rcs
		'username' => $more_recent ? $rcs->get_colors($into, $into['username']) : $rcs->get_colors($from, $from['username']),
		//-- fin mod : rank color system -----------------------------------------------
		'post_time' => $more_recent ? $into['post_time'] : $from['post_time'],
		'post_title' => $more_recent ? $into['post_title'] : (isset($from['post_title']) ? $from['post_title'] : ''),
		//-- mod : last active topic on index ------------------------------------------
		//-- add
		'topic_id' => $more_recent ? $into['topic_id'] : $from['topic_id'],
		'topic_title' => $more_recent ? $into['topic_title'] : $from['topic_title'],
		//-- fin mod : last active topic on index --------------------------------------
		// V: QTE -- addon last active topic
		'topic_attribute' => $more_recent ? $into['topic_attribute'] : $from['topic_attribute'],
	);
	return $stack;
}

// index: return the display_categories array, and fill the forum_data array with the stacked data (posts/topic/last_post)
function _sf_get_last_stacked_data(&$forum_data, &$is_auth_ary, $_sf_root_forum_id, &$_sf_cat_first, &$_sf_last_sub_id, &$_sf_last_child_idx)
{
	global $userdata;

	// returned arrays
	$display_categories = array();
	$_sf_cat_first = array();
	$_sf_last_sub_id = defined('IN_VIEWFORUM') ? array($_sf_root_forum_id => $_sf_root_forum_id) : array();
	$_sf_last_child_idx = array();

	$total_forums = count($forum_data);
	$forum_stack = array();
	for ( $j = $total_forums - 1; $j >= 0; $j-- )
	{
		$forum_id = intval($forum_data[$j]['forum_id']);
		$parent_id = intval($forum_data[$j]['forum_parent']);

		// get end of branch (the last child of the whole branch
		if ( !isset($_sf_last_child_idx[$forum_id]) )
		{
			$_sf_last_child_idx[$forum_id] = $j;
		}
		if ( $parent_id && (!defined('IN_VIEWFORUM') || ($forum_id != $_sf_root_forum_id)) )
		{
			$_sf_last_child_idx[$parent_id] = $j;
		}

		// if not auth_view, jump to the next forum
		if ( !$is_auth_ary[$forum_id]['auth_view'] )
		{
			continue;
		}

		// get last sub of the level
		if ( !isset($_sf_last_sub_id[$forum_id]) )
		{
			$_sf_last_sub_id[$forum_id] = $forum_id;
		}
		if ( !$parent_id || (defined('IN_VIEWFORUM') && ($forum_id == $_sf_root_forum_id)) )
		{
			$display_categories[ $forum_data[$j]['cat_id'] ] = true;
			$_sf_cat_first[ $forum_data[$j]['cat_id'] ] = $j;
		}
		else if ( $is_auth_ary[$parent_id]['auth_view'] && !isset($_sf_last_sub_id[$parent_id]) )
		{
			$_sf_last_sub_id[$parent_id] = $forum_data[$j]['forum_id'];
		}

		// stack the level info with the stacked from subforums one
		$forum_stack[$forum_id] = _sf_stack(isset($forum_stack[$forum_id]) ? $forum_stack[$forum_id] : false, $forum_data[$j]);

		// check if there are some unread topics (if there are in subs, consider the level has the unread flag)
		if ( !$forum_stack[$forum_id]['unread'] )
		{
			$forum_stack[$forum_id]['unread'] = _sf_check_unread($forum_id);
		}

		// propagate to parent
		if ( $parent_id )
		{
			$forum_stack[$parent_id] = _sf_stack(isset($forum_stack[$parent_id]) ? $forum_stack[$parent_id] : false, $forum_stack[$forum_id]);
		}

		// move the result of the level to the main forums list
		$forum_data[$j] = array_merge($forum_data[$j], $forum_stack[$forum_id]);
		unset($forum_stack[$forum_id]);
	}
	return $display_categories;
}

// index: return the html generated for a handler, keep only what's between BEGINONLY/ENDONLY if asked
function _sf_get_pparse($handler, $keep=false)
{
	global $template;

	ob_start();
	$template->pparse($handler);
	$res = ob_get_contents();
	ob_end_clean();

	if ( $keep )
	{
		preg_match_all('#<!-- BEGINONLY -->(.*?)<!-- ENDONLY -->#s', $res, $matches);
		if ( $matches[1] )
		{
			$res = implode('', $matches[1]);
		}
	}
	return $res;
}

// init language
function _sf_lang(&$main_lang)
{
	global $phpbb_root_path, $board_config, $phpEx;
	$lang = array(
		'sf_Run_install' => 'Please run %sthe SF installation%s',
		'sf_Delete_install' => 'Please remove the install_sf/ directory',
		'sf_Subforums' => 'Subforums',

	) + (defined('IN_INSTALL') ? array(
		'sf_Install' => 'SF Installation',
		'sf_previous_version' => 'Version previously running',
		'sf_current_version' => 'Version to install',
		'sf_SQL_failed' => 'failed',
		'sf_SQL_succeed' => 'succeed',
		'sf_SQL_Error' => 'The installation has failed to create correctly the phpbb_forums.forum_parent field. Do it manually, then relaunch the installation.',
		'sf_Forum_tree_ordered' => 'Some forums orders have been adjusted. Please recheck the forums tree in the ACP/Forum management.',
		'sf_Install_done' => 'The SF installation has succeed.',
		'sf_Back_to_index'=> 'Click here to return to the board index',

	) : array()) + (defined('IN_ADMIN') ? array(
		'sf_Forum_parent' => 'Attached to',
		'sf_Forum_parent_not_exist' => 'The parent forum or category does not exists.',
		'sf_Forum_not_empty' => 'This forum has sub-forums. Move or delete them first.',

	) : array());
	if ( ($_sf_lang = $phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_sf.' . $phpEx) && @file_exists(@phpbb_realpath($_sf_lang)) )
	{
		include($_sf_lang);
	}
	foreach ( $lang as $key => $txt )
	{
		$main_lang[$key] = isset($main_lang[$key]) ? $main_lang[$key] : $txt;
	}
}

// display the navigation breadscrumbs
function _sf_display_nav($forum_id, $tpl_switch='')
{
	global $db, $template;
	global $phpbb_root_path, $phpEx;

	// read forum
	$sql = 'SELECT f.forum_id, f.forum_name, f.forum_desc, f.forum_parent, c.cat_id, c.cat_title
				FROM ' . FORUMS_TABLE . ' f, ' . CATEGORIES_TABLE . ' c, ' . FORUMS_TABLE . ' fo
				WHERE fo.forum_id = ' . intval($forum_id) . '
					AND c.cat_id = fo.cat_id
					AND f.cat_id = c.cat_id
					AND f.forum_order <= fo.forum_order
				ORDER BY f.forum_order DESC';
	if ( !($result = $db->sql_query($sql, false, 'forums')) )
	{
		message_die(GENERAL_ERROR, 'Could not query forums data', '', __LINE__, __FILE__, $sql);
	}
	$nav = array();
	$find_id = $forum_id;
	while ( $row = $db->sql_fetchrow($result) )
	{
		if ( empty($cat) )
		{
			$cat = array(
				'forum_id' => intval($row['cat_id']),
				'forum_name' => $row['cat_title'],
				'forum_desc' => '',
				'forum_parent' => 0,
				'forum_type' => POST_CAT_URL,
			);
		}
		unset($row['cat_id']);
		unset($row['cat_title']);
		if ( intval($row['forum_id']) == $find_id )
		{
			$row['forum_type'] = POST_FORUM_URL;
			$find_id = intval($row['forum_parent']);
			unset($row['forum_parent']);
			$nav[] = $row;
		}
		if ( !$find_id )
		{
			break;
		}
	}
	$db->sql_freeresult($result);
	if ( !empty($nav) )
	{
		$nav[] = $cat;
		$nav = array_reverse($nav);
	}

	// display
	if ( ($count_nav = count($nav)) )
	{
		for ( $i = 0; $i < $count_nav; $i++ )
		{
			$template->assign_block_vars('nav', array(
				'U_NAV' => append_sid(($nav[$i]['forum_type'] == POST_CAT_URL ? 'index.' : 'viewforum.') . $phpEx . '?' . $nav[$i]['forum_type'] . '=' . $nav[$i]['forum_id']),
				'L_NAV' => smilies_pass($nav[$i]['forum_name']),
				'L_NAV_DESC' => $nav[$i]['forum_desc'],
				'L_NAV_DESC_HTML' => $nav[$i]['forum_desc'] ? htmlspecialchars(preg_replace('#<[\/\!]*?[^<>]*?>#si', '', $nav[$i]['forum_desc'])) : '',
			));
			if ( $tpl_switch )
			{
				$template->assign_block_vars('nav.' . $tpl_switch, array());
			}
		}
	}
}

// installed version check
if ( !defined('IN_INSTALL') && !defined('IN_LOGIN') && !defined('IN_ADMIN') )
{
	if ( $userdata['session_logged_in'] && ($userdata['user_level'] == ADMIN) )
	{
		if ( $board_config[SF_CONFIG_VERSION] != SF_CURRENT_VERSION )
		{
			_sf_lang($lang);
			$message = sprintf($lang['sf_Run_install'], '<a href="' . append_sid($phpbb_root_path . 'install_sf/install.' . $phpEx) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else if ( ($userdata['user_level'] == ADMIN) && ($_sf_file = @phpbb_realpath($phpbb_root_path . 'install_sf/install.' . $phpEx)) && file_exists($_sf_file) )
		{
			_sf_lang($lang);
			message_die(GENERAL_MESSAGE, 'sf_Delete_install');
		}
	}
	else if ( $board_config[SF_CONFIG_VERSION] != SF_CURRENT_VERSION )
	{
		message_die(GENERAL_MESSAGE, 'Board_disable', 'Information');
	}
}

?>