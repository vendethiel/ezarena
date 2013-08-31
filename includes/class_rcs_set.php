<?php
/**
*
* @package rank_color_system_mod
* @version $Id: class_rcs_set.php,v 0.1 24/11/2006 12:41 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class rcs_set
{
	var $root;

	function rcs_set()
	{
		global $phpbb_root_path;

		$this->root = &$phpbb_root_path;
	}

	/**
	* Pagination routine, generates page number sequence
	* Some parts are borrowed from phpBB3 (aka Olympus)
	*/
	function pagination($requester, $parms='', $total_items, $items_per_page, $start_item, $item_name_count='', $add_prevnext_text=true)
	{
		global $template, $lang;
		global $get;

		// init
		$item = array(
			'total' => intval($total_items),
			'per' => !$items_per_page ? 50 : intval($items_per_page),
			'start' => intval($start_item),
		);

		// set vars
		$l_count = empty($item_name_count) ? '' : ( ($item['total'] == 1) ? $item_name_count . '_1' : $item_name_count );
		$on_page = floor($item['start'] / $item['per']) + 1;
		$total_pages = !$item['total'] ? 1 : ceil($item['total'] / $item['per']);

		// constants
		$lang['Page_of'] = str_replace(array('<b>', '</b>'), array('', ''), $lang['Page_of']);
		$template->assign_vars(array(
			'PAGE_NUMBER' => sprintf($lang['Page_of'], $on_page, $total_pages),
			'L_COUNT' => empty($item['total']) ? '' : sprintf($lang[$l_count], $item['total']),
		));

		if ( $total_pages == 1 || !$item['total'] )
		{
			return false;
		}

		$base_url = $get->url($requester, $parms, true);
		$page_string = ($on_page == 1) ? '<strong>1</strong>' : '<a href="' . $base_url . '">1</a>';

		if ( $total_pages > 5 )
		{
			$start_cnt = min(max(1, $on_page - 4), $total_pages - 5);
			$end_cnt = max(min($total_pages, $on_page + 4), 6);

			$page_string .= ($start_cnt > 1) ? ' ... ' : ', ';

			for ( $i = $start_cnt + 1; $i < $end_cnt; $i++ )
			{
				$page_string .= ($i == $on_page) ? '<strong>' . $i . '</strong>' : '<a href="' . $base_url . '&amp;start=' . (($i - 1) * $item['per']) . '">' . $i . '</a>';

				if ( $i < $end_cnt - 1 )
				{
					$page_string .= ', ';
				}
			}

			$page_string .= ($end_cnt < $total_pages) ? ' ... ' : ', ';
		}
		else
		{
			$page_string .= ', ';

			for ( $i = 2; $i < $total_pages; $i++ )
			{
				$page_string .= ($i == $on_page) ? '<strong>' . $i . '</strong>' : '<a href="' . $base_url . '&amp;start=' . (($i - 1) * $item['per']) . '">' . $i . '</a>';

				if ( $i < $total_pages )
				{
					$page_string .= ', ';
				}
			}
		}

		$page_string .= ($on_page == $total_pages) ? '<strong>' . $total_pages . '</strong>' : '<a href="' . $base_url . '&amp;start=' . (($total_pages - 1) * $item['per']) . '">' . $total_pages . '</a>';

		if ( $add_prevnext_text )
		{
			if ( $on_page != 1 ) 
			{
				$page_string = '<a href="' . $base_url . '&amp;start=' . (($on_page - 2) * $item['per']) . '">' . $lang['Previous'] . '</a>&nbsp;&nbsp;' . $page_string;
			}

			if ( $on_page != $total_pages )
			{
				$page_string .= '&nbsp;&nbsp;<a href="' . $base_url . '&amp;start=' . ($on_page * $item['per']) . '">' . $lang['Next'] . '</a>';
			}
		}

		// build pagination
		$template->assign_block_vars('pagination', array(
			'PAGINATION' => $page_string,
			'L_GOTO_PAGE' => $lang['Goto_page'],
		));

		return $page_string;
	}

	/**
	* Used to display usergroups data in a drop-down menu,
	* built by two distinct processes (registered user or guest)
	*/
	function get_usergroups_list()
	{
		global $db, $userdata, $lang;
		global $rcs;

		$items = array();
		if ( $userdata['session_logged_in'] )
		{
			// init vars
			$in_group = array();
			$g_pending = array();
			$g_member = array();
			$g_other = array();

			// select groups to which the user belongs or has a pending membership
			$sql = 'SELECT g.group_id, g.group_name, g.group_type, ug.group_id as ug_id, ug.user_pending
				FROM ' . GROUPS_TABLE . ' g
					LEFT JOIN ' . USER_GROUP_TABLE . ' ug
						ON ug.user_id = ' . intval($userdata['user_id']) . '
							AND ug.group_id = g.group_id
				WHERE g.group_single_user = 0
				ORDER BY g.group_name, ug.user_id';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				$group_color = $rcs->get_group_class($row['group_id']);
				if ( $row['ug_id'] == $row['group_id'] )
				{
					$in_group[] = intval($row['group_id']);
					if ( $row['user_pending'] )
					{
						$g_pending[] = array('name' => $row['group_name'], 'value' => intval($row['group_id']), 'style' => $group_color, 'optgroup' => $lang['Memberships_pending']);
					}
					else
					{
						$g_member[] = array('name' => $row['group_name'], 'value' => intval($row['group_id']), 'style' => $group_color, 'optgroup' => $lang['Current_memberships']);
					}
				}
	
				if ( !in_array($row['group_id'], $in_group) && ( $row['group_type'] != GROUP_HIDDEN || $userdata['user_level'] == ADMIN ) )
				{
					$g_other[] = array('name' => $row['group_name'], 'value' => intval($row['group_id']), 'style' => $group_color, 'optgroup' => $lang['Non_member_groups']);
				}
			
			}
			$db->sql_freeresult($result);

			$items = array_merge($g_pending, $g_member, $g_other);

			// unset some vars
			unset($in_group, $g_pending, $g_member, $g_other);
		}
		else
		{
			// select all groups (guest process)
			$sql = 'SELECT group_id, group_name, group_type
				FROM ' . GROUPS_TABLE . '
				WHERE group_single_user = 0
				ORDER BY group_name';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				if ( $row['group_type'] != GROUP_HIDDEN || $userdata['user_level'] == ADMIN )
				{
					$group_color = $rcs->get_group_class($row['group_id']);
					$items[] = array('name' => $row['group_name'], 'value' => intval($row['group_id']), 'style' => $group_color, 'optgroup' => $lang['Non_member_groups']);
				}
			}
			$db->sql_freeresult($result);
		}

		return $items;
	}

	/**
	* Display user activity (last visit, posts per day, active forum/topic)
	*/
	function display_user_activity($user_id, $userstats)
	{
		global $db, $board_config, $userdata, $template, $lang;
		global $get, $qte;

		if ( (empty($user_id) || $user_id == ANONYMOUS) || (empty($userstats) || !is_array($userstats)) )
		{
			return;
		}

		// init vars
		$statistics = array('total_posts' => 0);
		$forum_data = array();
		$forum_read_ary = array();
		$forum_ary = array();
		$most_active = array();
		$most_active_tpls = array();

		// find which forums are visible for this user
		$sql = 'SELECT forum_id, forum_posts, auth_read
			FROM ' . FORUMS_TABLE . '
			ORDER BY forum_id';
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
		}

		while ($row = $db->sql_fetchrow($result))
		{
			$forum_data[] = $row;
			$statistics['total_posts'] += $row['forum_posts'];
		}
		$db->sql_freeresult($result);

		
		// keep only those forums the user is having read access to...
		$forum_read_ary = auth(AUTH_READ, AUTH_LIST_ALL, $userdata, $forum_data);
		foreach ($forum_read_ary as $forum_id => $allowed)
		{
			if ( $allowed['auth_read'] )
			{
				$forum_ary[] = intval($forum_id);
			}
		}
		unset($forum_data, $forum_read_ary);

		if ( !empty($forum_ary) )
		{
			// obtain active forum
			$sql = 'SELECT f.forum_id, f.forum_name, COUNT(p.post_id) AS num_posts
				FROM ' . FORUMS_TABLE . ' f, ' . POSTS_TABLE . ' p
				WHERE p.poster_id = ' . intval($user_id) . '
					AND f.forum_id = p.forum_id
					AND f.forum_id IN (' . implode(', ', $forum_ary) . ')
				GROUP BY f.forum_id
				ORDER BY num_posts DESC
				LIMIT 1';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting user activity', '', __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				$most_active = array(
					'f_id' => $row['forum_id'],
					'f_name' => $row['forum_name'],
					'f_count' => $row['num_posts'],
					'f_pct' => $userstats['posts'] ? ($row['num_posts'] / $userstats['posts']) * 100 : 0,
				);
			}
			$db->sql_freeresult($result);

			// obtain active topic
			$sql = 'SELECT f.forum_id, t.topic_id, t.topic_title, t.topic_attribute, COUNT(p.post_id) AS num_posts
				FROM ' . FORUMS_TABLE . ' f, ' . POSTS_TABLE . ' p, ' . TOPICS_TABLE . ' t
				WHERE p.poster_id = ' . intval($user_id) . '
					AND t.topic_id = p.topic_id
					AND f.forum_id = t.forum_id
					AND f.forum_id IN (' . implode(', ', $forum_ary) . ')
				GROUP BY t.topic_id
				ORDER BY num_posts DESC
				LIMIT 1';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting user activity', '', __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				$most_active = array_merge($most_active, array(
					't_id' => $row['topic_id'],
					't_title' => $row['topic_title'],
					't_count' => $row['num_posts'],
					't_attribute' => $row['topic_attribute'],
					't_pct' => $userstats['posts'] ? ($row['num_posts'] / $userstats['posts']) * 100 : 0,
				));
			}
			$db->sql_freeresult($result);

			// constants
			if (!empty($most_active))
			{
				$most_active_title = $most_active['t_title'];
				$qte->attr($most_active_title, $most_active['t_attribute']);
			}
			$most_active_tpls = empty($most_active) ? array() : array(
				'L_ACTIVE_IN_FORUM' => $lang['active_in_forum'],
				'L_ACTIVE_IN_TOPIC' => $lang['active_in_topic'],
				'ACTIVE_FORUM' => $most_active['f_name'],
				'ACTIVE_FORUM_POSTS' => sprintf($lang[ ($most_active['f_count'] == 1) ? 'user_posts_1' : 'user_posts' ], $most_active['f_count']),
				'ACTIVE_FORUM_PCT' => sprintf($lang['post_pct_active'], $most_active['f_pct']),
				'ACTIVE_TOPIC' => censor_text($most_active_title),
				'ACTIVE_TOPIC_POSTS' => sprintf($lang[ ($most_active['t_count'] == 1) ? 'user_posts_1' : 'user_posts' ], $most_active['t_count']),
				'ACTIVE_TOPIC_PCT' => sprintf($lang['post_pct_active'], $most_active['t_pct']),
				'U_ACTIVE_FORUM' => $get->url('viewforum', array(POST_FORUM_URL => $most_active['f_id']), true),
				'U_ACTIVE_TOPIC' => $get->url('viewtopic', array(POST_TOPIC_URL => $most_active['t_id']), true),
			);
			$get->assign_switch('load_activity', !empty($most_active));
			$get->assign_switch('load_activity.f_most_active', !empty($most_active['f_id']));
			$get->assign_switch('load_activity.t_most_active', !empty($most_active['t_id']));
		}

		$statistics['memberdays'] = max(1, round((time() - $userstats['regdate']) / 86400));
		$statistics['posts_per_day'] = $userstats['posts'] / $statistics['memberdays'];
		$statistics['percentage'] = $statistics['total_posts'] ? min(100, ($userstats['posts'] / $statistics['total_posts']) * 100) : 0;

		$has_visited = !empty($userstats['session_time']) ? $userstats['session_time'] : $userstats['lastvisit'];
		$view_allowed = $userstats['viewonline'] || ( ($userdata['user_level'] == ADMIN) || ($userdata['user_id'] == intval($user_id)) );
		$last_visit = $has_visited ? ( $view_allowed ? create_date($board_config['default_dateformat'], intval($has_visited), $board_config['board_timezone']) : $lang['Hidden_last_visit'] ) : $lang['Never_last_visit'];

		$template->assign_vars($most_active_tpls + array(
			'L_TOTAL_POSTS' => $lang['Total_posts'],
			'L_VISITED' => $lang['Visited'],
			'VISITED' => $last_visit,
			'POST_DAY' => sprintf($lang['User_post_day_stats'], $statistics['posts_per_day']), 
			'POSTS_PCT' => sprintf($lang['User_post_pct_stats'], $statistics['percentage']), 
		));
		$get->assign_switch('load_statistics', !empty($userstats['posts']));
	}	
}

class navigation
{
	var $root;
	var $nav;

	function navigation()
	{
		global $phpbb_root_path;

		$this->root = &$phpbb_root_path;

		$this->clear();
	}

	function clear()
	{
		global $board_config;

		$this->nav = array();
		$this->add('Forum_index', $board_config['sitename'], 'index', '', 'favicon');
	}

	function add($name, $desc='', $url, $parms='', $img='')
	{
		$this->nav[] = array('name' => $name, 'desc' => $desc, 'url' => $url, 'parms' => $parms, 'img' => $img);
	}

	function display()
	{
		global $template, $images;
		global $get;

		$count_nav = count($this->nav);
		for ( $i = 0; $i < $count_nav; $i++ )
		{
			$template->assign_block_vars('nav', array(
				'U_NAV' => $get->url($this->nav[$i]['url'], $this->nav[$i]['parms'], true),
				'L_NAV' => lang_item($this->nav[$i]['name']),
				'L_NAV_DESC' => lang_item($this->nav[$i]['desc']),
				'I_NAV' => !isset($images[ $this->nav[$i]['img'] ]) ? '' : $this->root . $images[ $this->nav[$i]['img'] ],
			));
			$get->assign_switch('nav.img', !empty($this->nav[$i]['img']) && isset($images[ $this->nav[$i]['img'] ]));
			$get->assign_switch('nav.sep', $i < ($count_nav-1));
		}

		if ( !empty($count_nav) )
		{
			$template->set_filenames(array('navigation_box' => 'navigation_box.tpl'));
			$template->assign_var_from_handle('NAVIGATION_BOX', 'navigation_box');
		}
	}
}

?>