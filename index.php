<?php
/***************************************************************************
 *                                index.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: index.php,v 1.99.2.7 2006/01/28 11:13:39 acydburn Exp $
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
 ***************************************************************************/
define('IN_PHPBB', true);
define('IN_INDEX', true);
define('NO_ATTACH_MOD', true);
//-- mod: sf
if ( !defined('IN_VIEWFORUM') )
{
//-- mod: sf - end
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
//-- mod : quick title edition -------------------------------------------------
//-- add
include($get->url('includes/class_attributes'));
//-- fin mod : quick title edition ---------------------------------------------

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

//-- mod: sf
include($phpbb_root_path . 'includes/functions_sf.'.$phpEx);
_sf_lang($lang);
//-- mod: sf - end

//START MOD Keep_unread_2 * set $toggle_unreads_link so that later on the script knows wheter to run the extra queries to toggle view unread link text depending on whether or not there are unread posts 
$toggle_unreads_link = true;
//END MOD Keep_unread
if(isset($HTTP_GET_VARS['act']) || isset($HTTP_POST_VARS['act']) || isset($HTTP_GET_VARS['do']) || isset($HTTP_POST_VARS['do']))
{ 
	include_once($phpbb_root_path.'proarcade.php');
	exit;
}

$viewcat = ( !empty($HTTP_GET_VARS[POST_CAT_URL]) ) ? $HTTP_GET_VARS[POST_CAT_URL] : -1;

if( isset($HTTP_GET_VARS['mark']) || isset($HTTP_POST_VARS['mark']) )
{
	$mark_read = ( isset($HTTP_POST_VARS['mark']) ) ? $HTTP_POST_VARS['mark'] : $HTTP_GET_VARS['mark'];
}
else
{
	$mark_read = '';
}

//
// Handle marking posts
//
if( $mark_read == 'forums' )
{
  	//START MOD Keep_unread_2 * Mark everything as read
	$board_config['tracking_time'] = time(); //at this moment
	$board_config['tracking_forums'] = array(); //clean
	$board_config['tracking_unreads'] = array(); //clean
	write_cookies($userdata);
  	//END MOD Keep_unread_2

	$template->assign_vars(array(
		"META" => '<meta http-equiv="refresh" content="3;url='  .append_sid("index.$phpEx") . '">')
	);

	$message = $lang['Forums_marked_read'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a> ');

	message_die(GENERAL_MESSAGE, $message);
}
//
// End handle marking posts
//
//-- mod: sf
	$_sf_root_forum_id = 0;
}
else
{
	// we are in viewforum
	if ( !defined('IN_PHPBB') )
	{
		die('Hack attempt!');
	}
	$viewcat = -1;
	$_sf_root_forum_id = $forum_row['forum_id'];
	$_sf_sav_forum_id = $forum_id;

	// mark subforums read
	if ( _sf_mark_subs_read($_sf_root_forum_id, 'mark', 'forums') )
	{
		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid('viewforum.' . $phpEx . '?' . POST_FORUM_URL . '=' . $_sf_root_forum_id) . '">',
		));
		$message = $lang['Forums_marked_read'] . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid('viewforum.' . $phpEx . '?' . POST_FORUM_URL . '=' . $_sf_root_forum_id) . '">', '</a> ');
		message_die(GENERAL_MESSAGE, $message);
	}

	// fill the categories_row array and initiate the retained forums for forum_data array() fill
	$category_rows = array(0 => array('cat_id' => $forum_row['cat_id']));
	$forum_data = array();

	$_sf_retained_forums = array();
}
//-- mod: sf - end

//MOD Keep_unread * deleted
// $tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . "_t"]) : array();
// $tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . "_f"]) : array();
//END MOD Keep_unread

//
// If you don't use these stats on your index you may want to consider
// removing them
//
//-- mod: sf
if ( !defined('IN_VIEWFORUM') )
{
//-- mod: sf - end
$total_posts = get_db_stat('postcount');
$total_users = get_db_stat('usercount');
$total_topics = get_db_stat('topiccount');
$start_date = create_date($board_config['default_dateformat'], $board_config['board_startdate'], $board_config['board_timezone']);
$boarddays = ( time() - $board_config['board_startdate'] ) / 86400;
$posts_per_day = sprintf("%.2f", $total_posts / $boarddays);
$topics_per_day = sprintf("%.2f", $total_topics / $boarddays);
$users_per_day = sprintf("%.2f", $total_users / $boarddays);
$total_male = get_db_stat('gender-male');
$total_female = get_db_stat('gender-female');
$newest_userdata = get_db_stat('newestuser');
$newest_user = $newest_userdata['username'];
$newest_uid = $newest_userdata['user_id'];

if( $total_posts == 0 )
{
	$l_total_post_s = $lang['Posted_articles_zero_total'];
}
else if( $total_posts == 1 )
{
	$l_total_post_s = $lang['Posted_article_total'];
}
else
{
	$l_total_post_s = $lang['Posted_articles_total'];
}

if( $total_users == 0 )
{
	$l_total_user_s = $lang['Registered_users_zero_total'];
}
else if( $total_users == 1 )
{
	$l_total_user_s = $lang['Registered_user_total'];
}
else
{
	$l_total_user_s = $lang['Registered_users_total'];
}
if( $total_male == 0 )
{
	$l_total_male = $lang['male_zero_total'];
}
else if( $total_male == 1 )
{
	$l_total_male = $lang['male_one_total'];
}
else
{
	$l_total_male = $lang['male_total'];
}

if( $total_female == 0 )
{
	$l_total_female = $lang['female_zero_total'];
}
else if( $total_female == 1 )
{
	$l_total_female = $lang['female_one_total'];
}
else
{
	$l_total_female = $lang['female_total'];
}

// lefty74's announcement center
new announcement_center();

//
// Start page proper
//
$sql = "SELECT c.cat_id, c.cat_title, c.cat_order
	FROM " . CATEGORIES_TABLE . " c 
	ORDER BY c.cat_order";
if( !($result = $db->sql_query($sql, false, true)) )
{
	message_die(GENERAL_ERROR, 'Could not query categories list', '', __LINE__, __FILE__, $sql);
}

$category_rows = array();
while ($row = $db->sql_fetchrow($result))
{
	$category_rows[] = $row;
	// www.phpBB-SEO.com SEO TOOLKIT BEGIN
	if ( $row['cat_id'] == $viewcat ) { $this_cat_title = $row['cat_title']; }
	// www.phpBB-SEO.com SEO TOOLKIT END
}
$db->sql_freeresult($result);
// www.phpBB-SEO.com SEO TOOLKIT BEGIN
$uri = $phpbb_seo->seo_req_uri();
$phpbb_seo->seo_cond(!$userdata['session_logged_in'] && (strpos($uri, "sid=" ) !== FALSE ));
if ( $viewcat > 0 )
{
	$phpbb_seo->page_url = $phpbb_seo->format_url($this_cat_title, $phpbb_seo->seo_static['cat']) . $phpbb_seo->seo_delim['cat'] . $viewcat . $phpbb_seo->seo_ext['cat'];
	if ( $phpbb_seo->do_redir || strpos($uri, $phpbb_seo->page_url) === FALSE)
	{
		$phpbb_seo->seo_redirect($phpbb_seo->seo_path['phpbb_url'] . $phpbb_seo->page_url);
	}
}
elseif ($viewcat == -1)
{
	$mark_use = ($userdata['session_logged_in']) ? $mark_read : '';
	if (!empty($phpbb_seo->seo_static['index']))
	{
		$phpbb_seo->seo_cond(( $mark_use == '' &&  strpos($uri, $phpbb_seo->seo_static['index']) === FALSE ), TRUE);
	}
	else
	{
		$phpbb_seo->seo_cond(( $mark_use == '' &&  strpos($uri, "index.$phpEx") !== FALSE ), TRUE);
	}

	if ($phpbb_seo->do_redir)
	{
		$phpbb_seo->seo_redirect($phpbb_seo->seo_path['phpbb_url'] . $phpbb_seo->seo_static['index']);
	}
}
// www.phpBB-SEO.com SEO TOOLKIT END
//-- mod: sf
}
//-- mod: sf - end

if ($total_categories = count($category_rows))
{
	$is_auth_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata); //, $forum_data);
	$sql = "SELECT f.*, p.post_time, p.post_username,
		u.username, u.user_id, u.user_level, u.user_color, u.user_group_id,
		t.topic_title, t.topic_id, t.topic_attribute
		FROM " . FORUMS_TABLE . " f
		LEFT JOIN " . POSTS_TABLE . " p ON p.post_id = f.forum_last_post_id
		LEFT JOIN " . TOPICS_TABLE . " t ON t.topic_id = p.topic_id
		LEFT JOIN " . USERS_TABLE . " u ON u.user_id = p.poster_id
		ORDER BY f.cat_id, f.forum_order";
	if ( !($result = $db->sql_query($sql, false, 'posts_')) )
	{
		message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
	}

	$forum_data = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		//-- mod: sf
		if ( !defined('IN_VIEWFORUM') )
		{
			//-- mod: sf - end
			$forum_data[] = $row;
			//-- mod: sf
		}
		else
		{
			if ( (intval($row['forum_id']) == $_sf_root_forum_id) || isset($_sf_retained_forums[ intval($row['forum_parent']) ]) )
			{
				$forum_data[] = $row;
				$_sf_retained_forums[ intval($row['forum_id']) ] = true;
			}
		}
		//-- mod: sf - end
	}
	$db->sql_freeresult($result);
//-- mod: sf
	if ( !defined('IN_VIEWFORUM') )
	{
//-- mod: sf - end
		if ( !($total_forums = count($forum_data)) )
		{
			message_die(GENERAL_MESSAGE, $lang['No_forums']);
		}//-- mod: sf
		
	}
	else
	{
		if ( !($total_forums = count($forum_data)) || ($total_forums <= 1) )
		{
			return;
		}
		unset($_sf_retained_forums);
	}
//-- mod: sf - end

	//MOD Keep_unread_2 * Get new_unreads list and forum_unread flags, save cookies etc.
	$new_unreads = list_new_unreads($forum_unreads, $toggle_unreads_link);
	if (!defined('IN_VIEWFORUM'))
	{
		//V: Show the 10 most recent topics
		new recent_topics();
	}

	//
	// Obtain list of moderators of each forum
	// First users, then groups ... broken into two queries
	//
	$sql = "SELECT aa.forum_id, u.user_id, u.username 
		FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g, " . USERS_TABLE . " u
		WHERE aa.auth_mod = " . TRUE . " 
			AND g.group_single_user = 1 
			AND ug.group_id = aa.group_id 
			AND g.group_id = aa.group_id 
			AND u.user_id = ug.user_id 
		GROUP BY u.user_id, u.username, aa.forum_id 
		ORDER BY aa.forum_id, u.user_id";
	$sql = str_replace(', u.user_id', ', u.user_id, u.user_level, u.user_color, u.user_group_id', $sql);
	if ( !($result = $db->sql_query($sql, false, true)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
	}

	$forum_moderators = array();
	while( $row = $db->sql_fetchrow($result) )
	{
		$style_color = $rcs->get_colors($row);
		$forum_moderators[$row['forum_id']][] = '<a title="' . $lang['Read_profile'] . '" href="' . $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true) . '"' . $style_color . '>' . $row['username'] . '</a>';
	}
	$db->sql_freeresult($result);

	$sql = "SELECT aa.forum_id, g.group_id, g.group_name, g.group_description
		FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g 
		WHERE aa.auth_mod = " . TRUE . " 
			AND g.group_single_user = 0 
			AND g.group_type <> " . GROUP_HIDDEN . "
			AND ug.group_id = aa.group_id 
			AND g.group_id = aa.group_id 
		GROUP BY g.group_id, g.group_name, aa.forum_id 
		ORDER BY aa.forum_id, g.group_id";
	if ( !($result = $db->sql_query($sql, false, true)) )
	{
		message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
	}

	while( $row = $db->sql_fetchrow($result) )
	{
		$style_color = $rcs->get_group_class($row['group_id']);
		$forum_moderators[$row['forum_id']][] = '<a title="' . str_replace('"', '', $row['group_description']) . '" href="'
		 . $get->url('groupcp', array(POST_GROUPS_URL => $row['group_id']), true) . '"' . $style_color . '>'
		 . $row['group_name'] . '</a>';
	}
	$db->sql_freeresult($result);

	//
	// Start output of page
	//
	//-- mod: sf
	// send constants
	$template->assign_vars(array(
		'L_SUBFORUMS' => $lang['sf_Subforums'],
		'L_FORUM' => $lang['Forum'],
		'L_TOPICS' => $lang['Topics'],
		'L_REPLIES' => $lang['Replies'],
		'L_VIEWS' => $lang['Views'],
		'L_POSTS' => $lang['Posts'],
		'L_LASTPOST' => $lang['Last_Post'],
		'L_MODERATOR'=> $lang['Moderators'],
	));

	if ( !defined('IN_VIEWFORUM') )
	{
//-- mod: sf - end
	define('SHOW_ONLINE', true);
	// www.phpBB-SEO.com SEO TOOLKIT BEGIN - TITLE
	$page_title = !empty($this_cat_title) ? $this_cat_title : $board_config['sitename'];
	// www.phpBB-SEO.com SEO TOOLKIT END - TITLE

	// www.phpBB-SEO.com SEO TOOLKIT BEGIN - META
	$phpbb_seo->seo_meta['meta_desc'] = $phpbb_seo->meta_filter_txt("$page_title : " . $phpbb_seo->seo_meta['meta_desc_def']);
	$phpbb_seo->seo_meta['keywords'] = $phpbb_seo->make_keywords($phpbb_seo->seo_meta['meta_desc']);
	// www.phpBB-SEO.com SEO TOOLKIT END - META	
	include($phpbb_root_path . 'includes/page_header.'.$phpEx);
	build_toolbar('index', $l_privmsgs_text, $s_privmsg_new);
	include($get->url('includes/class_onlinelist'));
	$onlinelist = new onlinelist_class();
	$onlinelist->display();
	unset($onlinelist);
	$birthday->generate_list();

	$rcs->display_legend();
	$newest_color = $rcs->get_colors($newest_userdata);
	$template->set_filenames(array(
		'body' => 'index_body.tpl')
	);
	$search_latest_hours = explode(',', $board_config['search_latest_hours']);

	for( $search_i = 0; $search_i < (count($search_latest_hours)-1); $search_i++ )
	{
		$template->assign_block_vars('search_latest', array(
			'L_SEARCH_LATEST_XXH' => sprintf($lang['Search_latest_XXh'], $search_latest_hours[$search_i]),
			'U_SEARCH_LATEST_XXH' => append_sid('search.'.$phpEx.'?search_id=latest&amp;hours=' . $search_latest_hours[$search_i])
		));
	}
	$template->assign_vars(array(
		'L_SEARCH_LATEST' => $lang['Search_latest'],
		'L_SEARCH_LATEST_XXH' => sprintf($lang['Search_latest_XXh'], $search_latest_hours[$search_i]),
		'U_SEARCH_LATEST_XXH' => append_sid('search.'.$phpEx.'?search_id=latest&amp;hours=' . $search_latest_hours[$search_i])
	));

	$template->assign_vars(array(
		'TOTAL_POSTS' => sprintf($l_total_post_s, $total_posts),
		'TOTAL_USERS' => sprintf($l_total_user_s, $total_users),
		'TOTAL_TOPICS' => $total_topics,
		'BOARD_STARTED' => $start_date,
		'POSTS_PER_DAY' => $posts_per_day,
		'TOPICS_PER_DAY' => $topics_per_day,
		'USERS_PER_DAY' => $users_per_day,		
		'TOTAL_MALE' => sprintf($l_total_male, $total_male),
		'TOTAL_FEMALE' => sprintf($l_total_female, $total_female),
		'NEWEST_USER' => sprintf($lang['Newest_user'], '<a href="' . $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $newest_uid), true) . '"' . $newest_color . '>', $newest_user, '</a>'),

//+MOD: DHTML Collapsible Forum Index MOD
/* Vende: j'ai viré cette connerie pour mettre sf+
		'U_CFI_JSLIB'			=> $phpbb_root_path . 'templates/collapsible_forum_index.js',
		'CFI_COOKIE_NAME'		=> get_cfi_cookie_name(),
		'COOKIE_PATH'			=> $board_config['cookie_path'],
		'COOKIE_DOMAIN'			=> $board_config['cookie_domain'],
		'COOKIE_SECURE'			=> $board_config['cookie_secure'],
		'L_CFI_OPTIONS'			=> str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_options']),
		'L_CFI_OPTIONS_EX'		=> str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_options_ex']),
		'L_CFI_CLOSE'			=> str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_close']),
		'L_CFI_DELETE'			=> str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_delete']),
		'L_CFI_RESTORE'			=> str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_restore']),
		'L_CFI_SAVE'			=> str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_save']),
		'L_CFI_EXPAND_ALL'		=> str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_Expand_all']),
		'L_CFI_COLLAPSE_ALL'	=> str_replace(array("'",' '), array("\'",'&nbsp;'), $lang['CFI_Collapse_all']),
		'IMG_UP_ARROW'			=> $phpbb_root_path . $images['up_arrow'],
		'IMG_DW_ARROW'			=> $phpbb_root_path . $images['down_arrow'],
		'IMG_PLUS'				=> $phpbb_root_path . $images['icon_sign_plus'],
		'IMG_MINUS'				=> $phpbb_root_path . $images['icon_sign_minus'],
		'SPACER'				=> $phpbb_root_path . 'images/spacer.gif',
*/
//-MOD: DHTML Collapsible Forum Index MOD		
		'FORUM_IMG' => $images['forum'],
		'FORUM_NEW_IMG' => $images['forum_new'],
		'FORUM_LOCKED_IMG' => $images['forum_locked'],
// Start add - Fully integrated shoutbox MOD
'U_SHOUTBOX' => append_sid("shoutbox.$phpEx"),
'L_SHOUTBOX' => $lang['Shoutbox'],
'U_SHOUTBOX_MAX' => append_sid("shoutbox_max.$phpEx"),
// End add - Fully integrated shoutbox MOD		

		'L_FORUM' => $lang['Forum'],
		'L_POSTS_PER_DAY' => $lang['Posts_per_day'],
		'L_TOTAL_TOPICS' => $lang['Total_topics'],
		'L_TOPICS_PER_DAY' => $lang['Topics_per_day'],
		'L_USERS_PER_DAY' => $lang['Users_per_day'],
		'L_BOARD_STARTED' => $lang['Board_started'],		
		'L_TOPICS' => $lang['Topics'],
		'L_REPLIES' => $lang['Replies'],
		'L_VIEWS' => $lang['Views'],
		'L_POSTS' => $lang['Posts'],
		'L_LASTPOST' => $lang['Last_Post'], 
		'L_NO_NEW_POSTS' => $lang['No_new_posts'],
		'L_NEW_POSTS' => $lang['New_posts'],
		'L_NO_NEW_POSTS_LOCKED' => $lang['No_new_posts_locked'], 
		'L_NEW_POSTS_LOCKED' => $lang['New_posts_locked'], 
		'L_ONLINE_EXPLAIN' => $lang['Online_explain'], 

		'L_MODERATOR' => $lang['Moderators'], 
		'L_FORUM_LOCKED' => $lang['Forum_is_locked'],
		'L_MARK_FORUMS_READ' => $lang['Mark_all_forums'], 

		'U_MARK_READ' => append_sid("index.$phpEx?mark=forums"))
	);
	//-- mod: sf
	}
//-- mod: sf - end

	//
	// Let's decide which categories we should display
	//
	//-- mod: sf
/*
	$display_categories = array();

	for ($i = 0; $i < $total_forums; $i++ )
	{
		if ($is_auth_ary[$forum_data[$i]['forum_id']]['auth_view'])
		{
			$display_categories[$forum_data[$i]['cat_id']] = true;
		}
	}*/
	// now get the last topic info plus the unread flag plus the cats to display
	$_sf_cat_first = array();
	$_sf_last_sub_id = array();
	$_sf_last_child_idx = array();

	$display_categories = _sf_get_last_stacked_data($forum_data, $is_auth_ary, $_sf_root_forum_id, $_sf_cat_first, $_sf_last_sub_id, $_sf_last_child_idx);
	if ( empty($display_categories) )
	{
		if ( defined('IN_VIEWFORUM') )
		{
			return;
		}
		message_die(GENERAL_MESSAGE, $lang['No_forums']);
	}
//-- mod: sf - end

	//
	// Okay, let's build the index
	//
	for($i = 0; $i < $total_categories; $i++)
	{
		$cat_id = $category_rows[$i]['cat_id'];

		if ( $board_config['allow_smilies'] )
		{
			$category_rows[$i]['cat_title'] = smilies_pass($category_rows[$i]['cat_title']);
    	}
		//
		// Yes, we should, so first dump out the category
		// title, then, if appropriate the forum list
		//
		if (isset($display_categories[$cat_id]) && $display_categories[$cat_id])
		{
			if ( !isset($phpbb_seo->seo_url['cat'][$cat_id]) )
			{
				$phpbb_seo->seo_url['cat'][$cat_id] = $phpbb_seo->format_url($category_rows[$i]['cat_title'], $phpbb_seo->seo_static['cat']);
			}
			$template->assign_block_vars('catrow', array(
				'DISPLAY' => (is_category_collapsed($cat_id) ? '' : 'none'),
				'CAT_ID' => $cat_id,
				'CAT_DESC' => trim($category_rows[$i]['cat_title']),
				'CAT_DESC_NOHTML' => trim(preg_replace('#<([^>]+)>(([^<]+)<\/([^>]+)>)?#iU', '', $category_rows[$i]['cat_title'])),
				'U_VIEWCAT' => append_sid("index.$phpEx?" . POST_CAT_URL . "=$cat_id"))
			);
			//-- mod: sf
			if ( !defined('IN_VIEWFORUM') )
			{
				$template->assign_block_vars('catrow.cat', array());
				$_sf_prev_forum_id = 0;
			}
			else
			{
				$_sf_prev_forum_id = $forum_row['forum_id'];
			}
			$_sf_first_sub = true;
			$_sf_is_sub = false;
			$_sf_rowcolor = false;
//-- mod: sf - end

			if ( $viewcat == $cat_id || $viewcat == -1 )
			{
				//-- mod: sf
/*
				for($j = 0; $j < $total_forums; $j++)
				{
					if ( $forum_data[$j]['cat_id'] == $cat_id )
					{
						$forum_id = $forum_data[$j]['forum_id'];

						if ( $is_auth_ary[$forum_id]['auth_view'] )
						{
							if ( $forum_data[$j]['forum_status'] == FORUM_LOCKED )
							{
								$folder_image = $images['forum_locked']; 
								$folder_alt = $lang['Forum_locked'];
							}
	 						else
							{
								//MOD Keep_Unread_2 * Forum_unread flags set earlier
								$unread_topic = $forum_unreads[$forum_id];
								$folder_image = ( $unread_topic ) ? $images['forum_new'] : $images['forum'];
								$folder_alt = ( $unread_topic ) ? $lang['New_posts'] : $lang['No_new_posts'];
							}*/
				for ( $j = intval($_sf_cat_first[$cat_id]); $j < $total_forums; $j++)
				{
					if ( $forum_data[$j]['cat_id'] != $cat_id )
					{
						break;
					}
					$forum_id = $forum_data[$j]['forum_id'];

					// jump over a non-authorised branch
					if ( !$is_auth_ary[$forum_id]['auth_view'] )
					{
						$j = $_sf_last_child_idx[$forum_id];
						continue;
					}
					if ( !isset($phpbb_seo->seo_url['forum'][$forum_id]) )
					{
						$phpbb_seo->seo_url['forum'][$forum_id] = $phpbb_seo->format_url($forum_data[$j]['forum_name'], $phpbb_seo->seo_static['forum']);
					}

					// attached to the main object (root, or in viewforum the selected forum)
					if ( (!defined('IN_VIEWFORUM') && !intval($forum_data[$j]['forum_parent'])) || (defined('IN_VIEWFORUM') && (intval($forum_data[$j]['forum_parent']) == $_sf_root_forum_id)) )
					{
						$_sf_prev_forum_id = $forum_id;
						$_sf_is_sub = false;
						$_sf_first_sub = true;
					}
					// attached to a viewable forum, so displayed as sub
					else if ( intval($forum_data[$j]['forum_parent']) == $_sf_prev_forum_id )
					{
						$_sf_is_sub = true;
					}
					// level not displayed: jump over
					else
					{
						if ( !defined('IN_VIEWFORUM') || ($forum_id != $_sf_root_forum_id) )
						{
							$j = $_sf_last_child_idx[$forum_id];
						}
						continue;
					}

					// prepare the display
					if ( !$_sf_is_sub )
					{
						$_sf_rowcolor = !$_sf_rowcolor;
					}
					$row_color = $_sf_rowcolor ? $theme['td_color1'] : $theme['td_color2'];
					$row_class = $_sf_rowcolor ? $theme['td_class1'] : $theme['td_class2'];

					// recompute the front icons
					// V: NOTE ! use 'unread' here because it's from _sf_stack
					$_sf_folder = _sf_get_folder($_sf_is_sub ? 'mini' : 'standard', ($_sf_last_sub_id[$forum_id] == $forum_id ? 'std' : 'has_sub') .
					 ($forum_data[$j]['forum_status'] == FORUM_LOCKED ? '_locked' : '') .
					 ($forum_data[$j]['unread'] ? '_new' : '') .
					 (intval($forum_data[$j]['forum_posts']) ? '' : '_empty'));
					$folder_image = $images[ $_sf_folder['img'] ];
					$folder_alt = $lang[ $_sf_folder['txt'] ];

					if ( $_sf_is_sub && $_sf_first_sub )
					{
						$template->assign_block_vars('catrow.forumrow.sub', array());
					}
					{{ //balance parens
//-- mod: sf - end
							$posts = $forum_data[$j]['forum_posts'];
							$topics = $forum_data[$j]['forum_topics'];
							$icon = $forum_data[$j]['forum_icon'];	// Forum Icon Mod							

							if ( $forum_data[$j]['forum_last_post_id'] )
							{
								$topic_title = $forum_data[$j]['topic_title'];
								// V: QTE -- addon Last topic on index
								$qte->attr($topic_title, $forum_data[$j]['topic_attribute']);

				                $forum_data[$j]['topic_title_normal'] = $topic_title;
				                $last_post = '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $forum_data[$j]['forum_last_post_id']) . '#' . $forum_data[$j]['forum_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a> ';
												
								$last_post_time = create_date2($board_config['default_dateformat'], $forum_data[$j]['post_time'], $board_config['board_timezone']);

				                $last_post .= '<span class="date-general">' . $last_post_time . '</span><br /><b>' . $lang['TY-in'] . '</b>';

				                // Trim the topic title to the configured amount from within the ACP
					            // www.phpBB-SEO.com SEO TOOLKIT BEGIN 
				                $seo_topic_name = $topic_title; 
				                // www.phpBB-SEO.com SEO TOOLKIT END
				                // V: use forum_data's topic_title rather than $topic_title since we don't want HTML in there
				                $last_post .= '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $forum_data[$j]['topic_id']) . '" title="' . $lang['Go_to_topic'] . $forum_data[$j]['topic_title'] . '">';
				                if (strlen($forum_data[$j]['topic_title']) > $board_config['ty_lastpost_cutoff']) 
								{
									$last_post .= substr($topic_title, 0, $board_config['ty_lastpost_cutoff']) . $board_config['ty_lastpost_append'];
	                			}
								else
								{
	                  				$last_post .= $topic_title;
	                			}
	                			$last_post .=  '</a><br /><b>' . $lang['TY-by'] . '</b>';
								$style_color = $rcs->get_colors($forum_data[$j]);
								$last_post .= ($forum_data[$j]['user_id'] == ANONYMOUS) ? ((($forum_data[$j]['post_username'] != '') ? $forum_data[$j]['post_username'] : $lang['Guest']) . '&nbsp;') : '<a href="' . $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $forum_data[$j]['user_id']), true) . '"' . $style_color . ' title="' . $lang['Read_profile'] . '">' . $forum_data[$j]['username'] . '</a>&nbsp;';
								
								$last_post_sub = '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $forum_data[$j]['forum_last_post_id']) . '#' . $forum_data[$j]['forum_last_post_id'] . '"><img src="' . ($unread_topic ? $images['icon_newest_reply'] : $images['icon_latest_reply']) . '" border="0" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" /></a>';
								$last_post_time = $forum_data[$j]['post_time'];
							}
							else
							{
								$last_post = $lang['No_Posts'];
							}
							
							if ( $forum_data[$j]['forum_status'] == FORUM_LOCKED )
							{
								$last_post_sub = '<img src="' . $images['icon_subforum_locked'] . '" border="0" alt="' . $lang['Forum_is_locked'] . '" title="' . $lang['Forum_is_locked'] . '" />';
							}

							if ( count($forum_moderators[$forum_id]) > 0 )
							{
								$l_moderators = $lang['Moderator' . (count($forum_moderators[$forum_id]) == 1 ? 's' : '')] . ':';
								$moderator_list = implode(', ', $forum_moderators[$forum_id]);
							}
							else
							{
								//V: c'est censé être &nbsp; mais ça rend juste moche
								$l_moderators = '';//'&nbsp;';
								$moderator_list = '';//'&nbsp;';
							}

							$forum_target = '';

							if ($forum_data[$j]['forum_external'])
							{
								$forum_url = append_sid("view_external.$phpEx?" . POST_FORUM_URL . "=$forum_id");

								$member_hits = $forum_data[$j]['forum_redirects_user'];
								$guest_hits = $forum_data[$j]['forum_redirects_guest'];
								$all_hits = ($member_hits + $guest_hits);

								$forum_details = $lang['External_text'] . '<b>' . $all_hits . '</b>';

								$forum_details .= ( $all_hits == 1 ) ? $lang['External_hit'] : $lang['External_hits'];
								
								$forum_details .= '<br />(' . $lang['External_members'] . ': <b>' . $member_hits . '</b>&nbsp;&middot;&nbsp;' . $lang['External_guests'] . ': <b>' . $guest_hits . '</b>)';

								$folder_image = ($forum_data[$j]['forum_ext_image']) ?  $forum_data[$j]['forum_ext_image'] : $images['forum_external'];
								$forum_posts = '--';
								$forum_topics = '--';

								$forum_target = ($forum_data[$j]['forum_ext_newwin']) ? 'target="_external"' : '';
							}
							else 
							{	
								$forum_url = append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id");

								$forum_posts = $forum_data[$j]['forum_posts'];
								$forum_topics = $forum_data[$j]['forum_topics'];
								$forum_details = $last_post;
							}

//-- mod: sf
/*
							$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
							$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

							$template->assign_block_vars('catrow.forumrow',	array(
							*/
							$template->assign_block_vars('catrow.forumrow' . ($_sf_is_sub ? '.sub.item' : ''), array(
								'L_SEP' => $forum_id == $_sf_last_sub_id[$_sf_prev_forum_id] ? '': ',',
								'FORUM_DESC_HTML' => htmlspecialchars(preg_replace('#<[\/\!]*?[^<>]*?>#si', '', $forum_data[$j]['forum_desc'])),
								'U_LAST_POST' => intval($forum_data[$j]['forum_posts']) ? append_sid('viewtopic.' . $phpEx . '?' . POST_POST_URL . '=' . $forum_data[$j]['forum_last_post_id']) . '#' . $forum_data[$j]['forum_last_post_id'] : append_sid('viewforum.' . $phpEx . '?' . POST_FORUM_URL . '=' . $forum_id),
								'L_LAST_POST' => intval($forum_data[$j]['forum_posts']) ? $lang['View_latest_post'] : $folder_alt,
//-- mod: sf - end
								'FORUM_ID' => $forum_id,
								'DISPLAY' => (is_category_collapsed($cat_id) ? 'none' : ''),
								'ROW_COLOR' => '#' . $row_color,
								'ROW_CLASS' => $row_class,
								// V: check $board_config['admin_login'] / session_admin avant d'autoriser à edit
								'FORUM_EDIT_IMG'	=> $userdata['user_level'] == ADMIN && ($userdata['session_admin'] || !$board_config['admin_login'])
								 ? '&nbsp;&nbsp;<a href="#" onclick="window.open(\'admin/admin_forums.'. $phpEx .'?mode=editforum&in_from=index&'
								 . POST_FORUM_URL .'='. $forum_id .'&sid='. $userdata['session_id'] .'\',\'popup\',\'width=600,height=800,scrollbars=yes,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no\'); return false;"><img src="images/forum_edit.gif" border="0"></a>' : '',
								'FORUM_FOLDER_IMG' => $folder_image,
								'HYPERCELL_CLASS' => get_hypercell_class($forum_data[$j]['forum_status'], ($unread_topics || $unread_topic)),
								'FORUM_ICON_IMG' => ($icon) ? '<img src="' . $phpbb_root_path . $board_config['forum_icon_path'] . '/' . $icon . '" />' : '', // Forum Icon Mod
								'FORUM_NAME' => $forum_data[$j]['forum_name'],
								'FORUM_DESC' => $forum_data[$j]['forum_desc'],
								'POSTS' => $forum_posts,
								'TOPICS' => $forum_topics,
								'LAST_POST' => $forum_details,
								'TARGET' => $forum_target,
								'MODERATORS' => $moderator_list,

								'L_MODERATOR' => $l_moderators, 
								'L_FORUM_FOLDER_ALT' => $folder_alt,
								'U_VIEWFORUM' => $forum_url)
							);
							//-- mod: sf
							if ( $_sf_is_sub )
							{
								$template->assign_block_vars('catrow.forumrow.sub.item.first' . ($_sf_first_sub ? '' : '_ELSE'), array());
								$template->assign_block_vars('catrow.forumrow.sub.item.last' . ($forum_id == $_sf_last_sub_id[$_sf_prev_forum_id] ? '' : '_ELSE'), array());
								$template->assign_block_vars('catrow.forumrow.sub.item.link' . (intval($forum_data[$j]['forum_posts']) ? '' : '_ELSE'), array());
								$_sf_first_sub = false;
							}
//-- mod: sf - end
						}
					}
				}
			}
		}
	} // for ... categories
}// if ... total_categories
else
{
	message_die(GENERAL_MESSAGE, $lang['No_forums']);
}

//
// Generate the page
//
//-- mod: sf
if ( !defined('IN_VIEWFORUM') )
{
	//-- mod: sf - end
	$template->pparse('body');

	include $phpbb_root_path . 'includes/page_tail.'.$phpEx;
	//-- mod: sf
}
else
{
	$forum_id = $_sf_sav_forum_id;
	unset($forum_data);
	unset($categories_row);

	$template->set_filenames(array('subforums' => 'index_body.tpl'));
	$_sf_subforums = _sf_get_pparse('subforums', true);
	if ( !empty($_sf_subforums) )
	{
		$template->assign_vars(array(
			'SUBFORUMS' => $_sf_subforums,
			'U_MARK_FORUMS_READ' => $userdata['session_logged_in'] ? append_sid('viewforum.' . $phpEx . '?' . POST_FORUM_URL . '=' . intval($forum_id) .'&amp;mark=forums') : '',
			'L_MARK_FORUMS_READ' => $userdata['session_logged_in'] ? $lang['Mark_all_forums'] : '',
		));
		unset($_sf_subforums);

		// send the mark forum link
		if ( $userdata['session_logged_in'] )
		{
			$template->assign_block_vars('mark_forums', array());
		}
	}
	// back to viewforum
	return;
}
//-- mod: sf - end