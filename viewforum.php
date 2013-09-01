<?php
/***************************************************************************
 *                               viewforum.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: viewforum.php,v 1.139.2.12 2004/03/13 15:08:23 acydburn Exp $
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
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
// Smilies Invasion Mod
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_separate.'.$phpEx);
//-- mod : quick title edition -------------------------------------------------
include($get->url('includes/class_attributes'));

//
// Start initial var setup
//
if ( isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]) )
{
	$forum_id = ( isset($HTTP_GET_VARS[POST_FORUM_URL]) ) ? intval($HTTP_GET_VARS[POST_FORUM_URL]) : intval($HTTP_POST_VARS[POST_FORUM_URL]);
}
else if ( isset($HTTP_GET_VARS['forum']))
{
	$forum_id = intval($HTTP_GET_VARS['forum']);
}
else
{
	$forum_id = '';
}

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$start = ($start < 0) ? 0 : $start;

if ( isset($HTTP_GET_VARS['mark']) || isset($HTTP_POST_VARS['mark']) )
{
	$mark_read = (isset($HTTP_POST_VARS['mark'])) ? $HTTP_POST_VARS['mark'] : $HTTP_GET_VARS['mark'];
}
else
{
	$mark_read = '';
}
//
// End initial var setup
//

//
// Check if the user has actually sent a forum ID with his/her request
// If not give them a nice error page.
//
if ( !empty($forum_id) )
{
	$sql = "SELECT *
		FROM " . FORUMS_TABLE . "
		WHERE forum_id = $forum_id";
	if ( !($result = $db->sql_query($sql, false, 'forum_')) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain forums information', '', __LINE__, __FILE__, $sql);
	}
}
else
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}
//
// If the query doesn't return any rows this isn't a valid forum. Inform
// the user.
//
if ( !($forum_row = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}
$db->sql_freeresult($result);
// www.phpBB-SEO.com SEO TOOLKIT BEGIN
if ( !isset($phpbb_seo->seo_url['forum'][$forum_id]) )
{
	$phpbb_seo->seo_url['forum'][$forum_id] = $phpbb_seo->format_url($forum_row['forum_name'], $phpbb_seo->seo_static['forum']);
}
// www.phpBB-SEO.com SEO TOOLKIT END
// www.phpBB-SEO.com SEO TOOLKIT BEGIN
$uri = $phpbb_seo->seo_req_uri();
$phpbb_seo->seo_start( $start, $board_config['topics_per_page'] );
$phpbb_seo->page_url = $phpbb_seo->seo_url['forum'][$forum_id] . $phpbb_seo->seo_delim['forum'] . $forum_id . $phpbb_seo->start . $phpbb_seo->seo_ext['forum'];
$phpbb_seo->seo_cond(!$userdata['session_logged_in'] && (strpos($uri, "sid=" ) !== FALSE ));
$topicday_redir = empty($_POST['topicdays']) && empty($_GET['topicdays']);
if ($_GET['topicdays'] == 0  || $_POST['topicdays'] == 0 )
{
	$topicday_redir = TRUE;
}
if ( $phpbb_seo->do_redir || ( ($mark_read == '') && $topicday_redir && ( strpos($uri, $phpbb_seo->page_url) === FALSE ) ) )
{
	$phpbb_seo->seo_redirect( $phpbb_seo->seo_path['phpbb_url'] . $phpbb_seo->page_url );
}
// www.phpBB-SEO.com SEO TOOLKIT END

//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//
//-- mod: sf
include($phpbb_root_path . 'includes/functions_sf.'.$phpEx);
_sf_lang($lang);

define('IN_VIEWFORUM', true);
include($phpbb_root_path . 'index.'.$phpEx);
_sf_display_nav($forum_id);
//-- mod: sf - end
// www.phpBB-SEO.com SEO TOOLKIT BEGIN

if ( !$userdata['session_logged_in'] && ($mark_read != ''))
{
	$phpbb_seo->seo_redirect( $phpbb_seo->seo_path['phpbb_url'] . $phpbb_seo->page_url );
}
// www.phpBB-SEO.com SEO TOOLKIT END

// V: let's not allow meddling with external stuff.
if ($forum_row['forum_external'])
{
	redirect($forum_row['forum_redirect_url']);
	message_die(GENERAL_MESSAGE, $lang['forum_is_external']);
}

//
// Start auth check
//
$is_auth = array();
$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $forum_row);
if ( !$is_auth['auth_read'] || !$is_auth['auth_view'] )
{
	if ( !$userdata['session_logged_in'] )
	{
		$redirect = POST_FORUM_URL . "=$forum_id" . ( ( isset($start) ) ? "&start=$start" : '' );
		redirect(append_sid("login.$phpEx?redirect=viewforum.$phpEx&$redirect", true));
	}
	//
	// The user is not authed to read this forum ...
	//
	$message = ( !$is_auth['auth_view'] ) ? $lang['Forum_not_exist'] : sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);

	message_die(GENERAL_MESSAGE, $message);
}
//
// End of auth check
//
//
// Password check
//
if( !$is_auth['auth_mod'] && $userdata['user_level'] != ADMIN )
{
	$redirect = str_replace("&amp;", "&", preg_replace('#.*?([a-z]+?\.' . $phpEx . '.*?)$#i', '\1', htmlspecialchars($HTTP_SERVER_VARS['REQUEST_URI'])));

	if( $HTTP_POST_VARS['cancel'] )
	{
		redirect(append_sid("index.$phpEx"));
	}
	else if( $HTTP_POST_VARS['pass_login'] )
	{
		if( $forum_row['forum_password'] != '' )
		{
			password_check('forum', $forum_id, $HTTP_POST_VARS['password'], $redirect);
		}
	}

	$passdata = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_fpass']) ) ? unserialize(stripslashes($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_fpass'])) : '';
	if( $forum_row['forum_password'] != '' && ($passdata[$forum_id] != md5($forum_row['forum_password'])) )
	{
		password_box('forum', $redirect);
	}
}
//
// END: Password check

if ( $mark_read == 'topics' )
{
	//START MOD Keep_unread_2
	//
	//Mark this forum as read
	$board_config['tracking_forums'][$forum_id] = time(); //right now
	$list_topics = implode(',', array_keys($board_config['tracking_unreads'])); //all tracking topic_id's
	if ($list_topics)
	{ //Get all the topics that are in this forum
		$sql = "SELECT topic_id
			FROM " . TOPICS_TABLE . "
			WHERE topic_id IN ($list_topics)
			AND forum_id = $forum_id AND topic_moved_id = 0";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not access topics', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) ) //Clean them
		{
			$id = $row['topic_id'];
			if ( isset($board_config['tracking_unreads'][$id]) )	unset($board_config['tracking_unreads'][$id]);
		}
	}
	write_cookies($userdata); //Save
	//END MOD Keep_unread_2

	//Message
	$template->assign_vars(array(
		'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("index.$phpEx") . '">')
		);
	$message = $lang['Topics_marked_read'] . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a> ');
	$message .= '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a> ');
	message_die(GENERAL_MESSAGE, $message);
}
//
// End handle marking posts
//

//START MOD Keep_unread_2
//$tracking_topics = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_t']) : '';
//$tracking_forums = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) ) ? unserialize($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_f']) : '';
//END MOD Keep_unread_2

//
// Do the forum Prune
//
if ( $is_auth['auth_mod'] && $board_config['prune_enable'] )
{
	if ( $forum_row['prune_next'] < time() && $forum_row['prune_enable'] )
	{
		include($phpbb_root_path . 'includes/prune.'.$phpEx);
		require($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
		auto_prune($forum_id);
	}
}
//
// End of forum prune
//

//
// Obtain list of moderators of each forum
// First users, then groups ... broken into two queries
//
$sql = "SELECT u.user_id, u.username 
	FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g, " . USERS_TABLE . " u
	WHERE aa.forum_id = $forum_id 
		AND aa.auth_mod = " . TRUE . " 
		AND g.group_single_user = 1
		AND ug.group_id = aa.group_id 
		AND g.group_id = aa.group_id 
		AND u.user_id = ug.user_id 
	GROUP BY u.user_id, u.username  
	ORDER BY u.user_id";
//-- mod : rank color system ---------------------------------------------------
//-- add
$sql = str_replace('SELECT ', 'SELECT u.user_level, u.user_color, u.user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------	
if ( !($result = $db->sql_query($sql, false, true)) )
{
	message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
}

$moderators = array();
while( $row = $db->sql_fetchrow($result) )
{
	
//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
	$moderators[] = '<a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['user_id']) . '">' . $row['username'] . '</a>';
MOD-*/
//-- add
	$style_color = $rcs->get_colors($row);
	$moderators[] = '<a href="' . $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true) . '"' . $style_color . '>' . $row['username'] . '</a>';
//-- fin mod : rank color system -----------------------------------------------	
}

$sql = "SELECT g.group_id, g.group_name 
	FROM " . AUTH_ACCESS_TABLE . " aa, " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g 
	WHERE aa.forum_id = $forum_id
		AND aa.auth_mod = " . TRUE . " 
		AND g.group_single_user = 0
		AND g.group_type <> ". GROUP_HIDDEN ."
		AND ug.group_id = aa.group_id 
		AND g.group_id = aa.group_id 
	GROUP BY g.group_id, g.group_name  
	ORDER BY g.group_id";
if ( !($result = $db->sql_query($sql, false, true)) )
{
	message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
}

while( $row = $db->sql_fetchrow($result) )
{
//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
	$moderators[] = '<a href="' . append_sid("groupcp.$phpEx?" . POST_GROUPS_URL . "=" . $row['group_id']) . '">' . $row['group_name'] . '</a>';
MOD-*/
//-- add
	$style_color = $rcs->get_group_class($row['group_id']);
	$moderators[] = '<a href="' . $get->url('groupcp', array(POST_GROUPS_URL => $row['group_id']), true) . '"' . $style_color . '>' . $row['group_name'] . '</a>';
//-- fin mod : rank color system -----------------------------------------------	
}
	
$l_moderators = ( count($moderators) == 1 ) ? $lang['Moderator'] : $lang['Moderators'];
$forum_moderators = ( count($moderators) ) ? implode(', ', $moderators) : $lang['None'];
unset($moderators);

//
// Generate a 'Show topics in previous x days' select box. If the topicsdays var is sent
// then get it's value, find the number of topics with dates newer than it (to properly
// handle pagination) and alter the main query
//
$previous_days = array(0, 1, 7, 14, 30, 90, 180, 364);
$previous_days_text = array($lang['All_Topics'], $lang['1_Day'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);

if ( !empty($HTTP_POST_VARS['topicdays']) || !empty($HTTP_GET_VARS['topicdays']) )
{
	$topic_days = ( !empty($HTTP_POST_VARS['topicdays']) ) ? intval($HTTP_POST_VARS['topicdays']) : intval($HTTP_GET_VARS['topicdays']);
	$min_topic_time = time() - ($topic_days * 86400);

	$sql = "SELECT COUNT(t.topic_id) AS forum_topics 
		FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p 
		WHERE t.forum_id = $forum_id 
			AND p.post_id = t.topic_last_post_id
			AND p.post_time >= $min_topic_time"; 

	if ( !($result = $db->sql_query($sql, false, 'posts_')) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain limited topics count information', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);

	$topics_count = ( $row['forum_topics'] ) ? $row['forum_topics'] : 1;
	$limit_topics_time = "AND p.post_time >= $min_topic_time";

	if ( !empty($HTTP_POST_VARS['topicdays']) )
	{
		$start = 0;
	}
}
else
{
	$topics_count = ( $forum_row['forum_topics'] ) ? $forum_row['forum_topics'] : 1;

	$limit_topics_time = '';
	$topic_days = 0;
}

$select_topic_days = '<select name="topicdays">';
for($i = 0; $i < count($previous_days); $i++)
{
	$selected = ($topic_days == $previous_days[$i]) ? ' selected="selected"' : '';
	$select_topic_days .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';
}
$select_topic_days .= '</select>';


//
// All announcement data, this keeps announcements
// on each viewforum page ...
//
$sql = "SELECT t.*, u.username, u.user_id, u2.username as user2, u2.user_id as id2, p.post_time, p.post_username, t.topic_type
	FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . USERS_TABLE . " u2
	WHERE t.topic_poster = u.user_id
		AND p.post_id = t.topic_last_post_id
		AND p.poster_id = u2.user_id
		AND ((t.topic_type = " . POST_ANNOUNCE . " AND t.forum_id = $forum_id) OR (t.topic_type = " . POST_GLOBAL_ANNOUNCE . "))
	ORDER BY t.topic_type DESC, t.topic_last_post_id DESC ";
//-- mod : rank color system ---------------------------------------------------
//-- add
$sql = str_replace(', u.user_id', ', u.user_id, u.user_level, u.user_color, u.user_group_id', $sql);
$sql = str_replace(', u2.user_id as id2', ', u2.user_id as id2, u2.user_level as level2, u2.user_color as color2, u2.user_group_id as group_id2', $sql);
//-- fin mod : rank color system -----------------------------------------------	
if ( !($result = $db->sql_query($sql, false, 'posts_')) )
{
   message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
}
$cached1 = $db->cached;
$topic_rowset = array();
$total_announcements = 0;
$total_global_announcements = 0;
while( $row = $db->sql_fetchrow($result) )
{
	$topic_rowset[] = $row;
	$total_announcements++;
	if ($row['topic_type'] == POST_GLOBAL_ANNOUNCE) {
		$total_global_announcements++;
	}
}

$db->sql_freeresult($result);

//
// forum enter limit by emrag
//
		if (!($userdata['user_level'] == ADMIN OR $userdata['user_level'] == MOD))
		{
		$sql = "SELECT f.forum_id, f.forum_enter_limit, u.user_posts
			FROM " . FORUMS_TABLE . " f, " . USERS_TABLE . " u
			WHERE user_id = " . $userdata['user_id'];

		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not query information', '', __LINE__, __FILE__, $sql);
		}

			while ($row = $db->sql_fetchrow($result))
			{
			$forum_id_limit = $row['forum_id'];
			$forum_enter_limit = $row['forum_enter_limit'];
			$user_posts_limit = $row['user_posts'];

			$error_limit = sprintf($lang['Forum_enter_limit_error'], $forum_enter_limit);

				if ($forum_id == $forum_id_limit AND $user_posts_limit < $forum_enter_limit)
				{
					message_die(GENERAL_ERROR, $error_limit);
				}
			}
		}
//
// forum enter limit by emrag
//
//
// Grab all the basic data (all topics except announcements)
// for this forum
//
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
// default forum values
$dft_sort = $forum_row['forum_display_sort'];
$dft_order = $forum_row['forum_display_order'];

// Sort def
$sort_value = $dft_sort;
if ( isset($HTTP_GET_VARS['sort']) || isset($HTTP_POST_VARS['sort']) )
{
	$sort_value = isset($HTTP_GET_VARS['sort']) ? intval($HTTP_GET_VARS['sort']) : intval($HTTP_POST_VARS['sort']);
}
$sort_list = '<select name="sort">' . get_forum_display_sort_option($sort_value, 'list', 'sort') . '</select>';

// Order def
$order_value = $dft_order;
if ( isset($HTTP_GET_VARS['order']) || isset($HTTP_POST_VARS['order']) )
{
	$order_value = isset($HTTP_GET_VARS['order']) ? intval($HTTP_GET_VARS['order']) : intval($HTTP_POST_VARS['order']);
}
$order_list = '<select name="order">' . get_forum_display_sort_option($order_value, 'list', 'order') . '</select>';

// display
$s_display_order = '&nbsp;' . $lang['Sort_by'] . ':&nbsp;' . $sort_list . $order_list . '&nbsp;';

// selected method
$sort_method = get_forum_display_sort_option($sort_value, 'field', 'sort');
$order_method = get_forum_display_sort_option($order_value, 'field', 'order');
//-- fin mod : topic display order -----------------------------------------------------------------
//-- mod : topic display order ---------------------------------------------------------------------
// here we added 
//	, $sort_method $order_method
//-- modify
$sql = "SELECT t.*, u.username, u.user_id, u2.username as user2, u2.user_id as id2, p.post_username, p2.post_username AS post_username2, p2.post_time 
	FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2, " . USERS_TABLE . " u2
	WHERE t.forum_id = $forum_id
		AND t.topic_poster = u.user_id
		AND p.post_id = t.topic_first_post_id
		AND p2.post_id = t.topic_last_post_id
		AND u2.user_id = p2.poster_id 
		AND t.topic_type <> " . POST_ANNOUNCE . " 
		AND t.topic_type <> " . POST_GLOBAL_ANNOUNCE . " 
		$limit_topics_time
	ORDER BY t.topic_type DESC, $sort_method $order_method, p2.post_time DESC 
	LIMIT $start, ".$board_config['topics_per_page'];
//-- fin mod : topic display order -----------------------------------------------------------------	
//-- mod : rank color system ---------------------------------------------------
//-- add
$sql = str_replace(', u.user_id', ', u.user_id, u.user_level, u.user_color, u.user_group_id', $sql);
$sql = str_replace(', u2.user_id as id2', ', u2.user_id as id2, u2.user_level as level2, u2.user_color as color2, u2.user_group_id as group_id2', $sql);
//-- fin mod : rank color system -----------------------------------------------	
if ( !($result = $db->sql_query($sql, false, 'posts_')) )
{
   message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
}
$cached2 = $db->cached;
$total_topics = 0;
while( $row = $db->sql_fetchrow($result) )
{
	$topic_rowset[] = $row;
	$total_topics++;
}

$db->sql_freeresult($result);

if($cached1 || $cached2)
{
	$update_list = array();
	for($i=0; $i<count($topic_rowset); $i++)
	{
		$update_list[] = $topic_rowset[$i]['topic_id'];
	}
	if(count($update_list))
	{
		$sql = "SELECT topic_id, topic_views FROM " . TOPICS_TABLE . " WHERE topic_id IN (" . implode(', ', $update_list) . ")";
		$list = array();
		$result = $db->sql_query($sql);
		while( $row = $db->sql_fetchrow($result) )
		{
			$list[$row['topic_id']] = $row['topic_views'];
		}
		$db->sql_freeresult($result);
		for($i=0; $i<count($topic_rowset); $i++)
		{
			if(isset($list[$topic_rowset[$i]['topic_id']]))
			{
				$topic_rowset[$i]['topic_views'] = $list[$topic_rowset[$i]['topic_id']];
			}
		}
		unset($list);
	}
}
//
// Total topics ...
//
$total_topics += $total_announcements;
$dividers = get_dividers($topic_rowset);

//
// Define censored word matches
//
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

//
// Post URL generation for templating vars
//
$template->assign_vars(array(
	'L_DISPLAY_TOPICS' => $lang['Display_topics'],

	'U_POST_NEW_TOPIC' => append_sid("posting.$phpEx?mode=newtopic&amp;" . POST_FORUM_URL . "=$forum_id"),

	'S_SELECT_TOPIC_DAYS' => $select_topic_days,
	'S_POST_DAYS_ACTION' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=" . $forum_id . "&amp;start=$start"))
);

//
// User authorisation levels output
//
$s_auth_can = ( ( $is_auth['auth_post'] ) ? $lang['Rules_post_can'] : $lang['Rules_post_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_reply'] ) ? $lang['Rules_reply_can'] : $lang['Rules_reply_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_edit'] ) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_delete'] ) ? $lang['Rules_delete_can'] : $lang['Rules_delete_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_vote'] ) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot'] ) . '<br />';
attach_build_auth_levels($is_auth, $s_auth_can);
$s_auth_can .= ( $is_auth['auth_ban'] ) ? $lang['Rules_ban_can'] . '<br />' : ''; 
$s_auth_can .= ( $is_auth['auth_greencard'] ) ? $lang['Rules_greencard_can'] . '<br />' : ''; 
$s_auth_can .= ( $is_auth['auth_bluecard'] ) ? $lang['Rules_bluecard_can'] . '<br />' : '';

if ( $is_auth['auth_mod'] )
{
	$s_auth_can .= sprintf($lang['Rules_moderate'], "<a href=\"modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;start=" . $start . "&amp;sid=" . $userdata['session_id'] . '">', '</a>');
}

//
// Mozilla navigation bar
//
$nav_links['up'] = array(
	'url' => append_sid('index.'.$phpEx),
	'title' => sprintf($lang['Forum_Index'], $board_config['sitename'])
);

//
// Dump out the page header and load viewforum template
//
define('SHOW_ONLINE', true);
// www.phpBB-SEO.com SEO TOOLKIT BEGIN - TITLE
$extra_title = ($start != 0) ? ' - ' . $lang['Page'] . ( floor( $start / $board_config['topics_per_page'] ) + 1 ) : '';
$page_title = strip_tags($forum_row['forum_name']) . $extra_title;
// www.phpBB-SEO.com SEO TOOLKIT END - TITLE
// www.phpBB-SEO.com SEO TOOLKIT BEGIN - META
$phpbb_seo->seo_meta['meta_desc'] = $phpbb_seo->meta_filter_txt($board_config['sitename'] . " : $page_title :  " . $forum_row['forum_desc']);
$phpbb_seo->seo_meta['keywords'] = $phpbb_seo->make_keywords($phpbb_seo->seo_meta['meta_desc']);
// www.phpBB-SEO.com SEO TOOLKIT END - META
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
//-- mod : toolbar -------------------------------------------------------------
//-- add
build_toolbar('viewforum', $l_privmsgs_text, $s_privmsg_new, $forum_id);
//-- fin mod : toolbar ---------------------------------------------------------

$template->set_filenames(array(
	'body' => 'viewforum_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx);

// Start Smilies Invasion Mod
if ( $board_config['allow_smilies'] )
{
  $forum_row['forum_name'] = smilies_pass($forum_row['forum_name']);
}

// V: Addon Smilies&Bbcode too long desc
$long_desc = $forum_row['forum_desc_long'];
if ($long_desc)
{
	$bbcode_uid = make_bbcode_uid();
	$long_desc = smilies_pass($long_desc);
	$long_desc = bbencode_first_pass($long_desc, $bbcode_uid);
	$long_desc = bbencode_second_pass($long_desc, $bbcode_uid);
	$long_desc = nl2br($long_desc);
}

$template->assign_vars(array(
	'FORUM_ID' => $forum_id,
	'FORUM_NAME' => $forum_row['forum_name'],
	'FORUM_DESC_LONG' => $long_desc,
	'MODERATORS' => $forum_moderators,
	'POST_IMG' => ( $forum_row['forum_status'] == FORUM_LOCKED ) ? $images['post_locked'] : $images['post_new'],

	'FOLDER_IMG' => $images['folder'],
	'FOLDER_NEW_IMG' => $images['folder_new'],
	'FOLDER_HOT_IMG' => $images['folder_hot'],
	'FOLDER_HOT_NEW_IMG' => $images['folder_hot_new'],
	'FOLDER_LOCKED_IMG' => $images['folder_locked'],
	'FOLDER_LOCKED_NEW_IMG' => $images['folder_locked_new'],
	'FOLDER_STICKY_IMG' => $images['folder_sticky'],
	'FOLDER_STICKY_NEW_IMG' => $images['folder_sticky_new'],
	'FOLDER_ANNOUNCE_IMG' => $images['folder_announce'],
	'FOLDER_ANNOUNCE_NEW_IMG' => $images['folder_announce_new'],

	'L_TOPICS' => $lang['Topics'],
	'L_REPLIES' => $lang['Replies'],
	'L_VIEWS' => $lang['Views'],
	'L_POSTS' => $lang['Posts'],
	'L_LASTPOST' => $lang['Last_Post'], 
	'L_MODERATOR' => $l_moderators, 
	'L_MARK_TOPICS_READ' => $lang['Mark_all_topics'], 
	'L_POST_NEW_TOPIC' => ( $forum_row['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['Post_new_topic'], 
	'L_NO_NEW_POSTS' => $lang['No_new_posts'],
	'L_NEW_POSTS' => $lang['New_posts'],
	'L_NO_NEW_POSTS_LOCKED' => $lang['No_new_posts_locked'], 
	'L_NEW_POSTS_LOCKED' => $lang['New_posts_locked'], 
	'L_NO_NEW_POSTS_HOT' => $lang['No_new_posts_hot'],
	'L_NEW_POSTS_HOT' => $lang['New_posts_hot'],
	'L_ANNOUNCEMENT' => $lang['Post_Announcement'],
	'L_GLOBAL_ANNOUNCEMENT' => $lang['Post_Global_Announcement'],	
	'L_STICKY' => $lang['Post_Sticky'], 
	'L_POSTED' => $lang['Posted'],
	'L_JOINED' => $lang['Joined'],
	'L_AUTHOR' => $lang['Author'],

	'S_AUTH_LIST' => $s_auth_can, 

	'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL ."=$forum_id"),

	'U_MARK_READ' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;mark=topics"))
);

//
// End header
//

//
// Okay, lets dump out the page ...
//
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
$template->assign_vars(array(
	'S_DISPLAY_ORDER' => $s_display_order,
	)
);
//-- fin mod : topic display order -----------------------------------------------------------------
if( $total_topics )
{
	for($i = 0; $i < $total_topics; $i++)
	{
		$topic_id = $topic_rowset[$i]['topic_id'];

		$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_title']) : $topic_rowset[$i]['topic_title'];
//-- mod : post description ----------------------------------------------------
//-- add
		$topic_sub_title = !empty($topic_rowset[$i]['topic_sub_title']) ? ( count($orig_word) ? preg_replace($orig_word, $replacement_word, $topic_rowset[$i]['topic_sub_title']) : $topic_rowset[$i]['topic_sub_title'] ) : '';
//-- fin mod : post description ------------------------------------------------		
//-- mod : quick title edition -------------------------------------------------
//-- add
		$qte->attr($topic_title, $topic_rowset[$i]['topic_attribute']);
//-- fin mod : quick title edition ---------------------------------------------

		$replies = $topic_rowset[$i]['topic_replies'];

		$topic_type = $topic_rowset[$i]['topic_type'];
		$topic_type = topic_type_lang($topic_type);

		if( $topic_rowset[$i]['topic_vote'] )
		{
			$topic_type .= $lang['Topic_Poll'] . ' ';
		}
		
		if( $topic_rowset[$i]['topic_status'] == TOPIC_MOVED )
		{
			$topic_type = $lang['Topic_Moved'] . ' ';
			$topic_id = $topic_rowset[$i]['topic_moved_id'];

			$folder_image =  $images['folder'];
			$folder_alt = $lang['Topics_Moved'];
			$newest_post_img = '';
		}
		else
		{
			if( $topic_rowset[$i]['topic_type'] == POST_GLOBAL_ANNOUNCE )
			{
				$folder = $images['folder_announce'];
				$folder_new = $images['folder_announce_new'];
			}
			else 		
			if( $topic_rowset[$i]['topic_type'] == POST_ANNOUNCE )
			{
				$folder = $images['folder_announce'];
				$folder_new = $images['folder_announce_new'];
			}
			else if( $topic_rowset[$i]['topic_type'] == POST_STICKY )
			{
				$folder = $images['folder_sticky'];
				$folder_new = $images['folder_sticky_new'];
			}
			else if( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED )
			{
				$folder = $images['folder_locked'];
				$folder_new = $images['folder_locked_new'];
			}
			else
			{
				if($replies >= $board_config['hot_threshold'])
				{
					$folder = $images['folder_hot'];
					$folder_new = $images['folder_hot_new'];
				}
				else
				{
					$folder = $images['folder'];
					$folder_new = $images['folder_new'];
				}
			}

			//START MOD Keep_unread_2
			if( $topic_rowset[$i]['post_time'] > topic_last_read($forum_id, $topic_id) )
			{
				$folder_image = $folder_new;
				$folder_alt = $lang['New_posts'];
				$newest_post_img = '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=newest") . '"><img src="' . $images['icon_newest_reply'] . '" alt="' . $lang['View_newest_post'] . '" title="' . $lang['View_newest_post'] . '" border="0" /></a> ';
			}
			else
			{
				$folder_image = $folder;
				$folder_alt = ( $topic_rowset[$i]['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['No_new_posts'];
				$newest_post_img = '';
			}
			//END MOD Keep_unread_2
		}
		// www.phpBB-SEO.com SEO TOOLKIT BEGIN
		if ( !isset($phpbb_seo->seo_url['topic'][$topic_id]) ) {
			$phpbb_seo->seo_url['topic'][$topic_id] = $phpbb_seo->format_url($topic_title);
		}
		// www.phpBB-SEO.com SEO TOOLKIT END
		if( ( $replies + 1 ) > $board_config['posts_per_page'] )
		{
			$total_pages = ceil( ( $replies + 1 ) / $board_config['posts_per_page'] );
			$goto_page = ' [ <img src="' . $images['icon_gotopost'] . '" alt="' . $lang['Goto_page'] . '" title="' . $lang['Goto_page'] . '" />' . $lang['Goto_page'] . ': ';

			$times = 1;
			for($j = 0; $j < $replies + 1; $j += $board_config['posts_per_page'])
			{
				$goto_page .= '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $topic_id . "&amp;start=$j") . '">' . $times . '</a>';
				if( $times == 1 && $total_pages > 4 )
				{
					$goto_page .= ' ... ';
					$times = $total_pages - 3;
					$j += ( $total_pages - 4 ) * $board_config['posts_per_page'];
				}
				else if ( $times < $total_pages )
				{
					$goto_page .= ', ';
				}
				$times++;
			}
			$goto_page .= ' ] ';
		}
		else
		{
			$goto_page = '';
		}
		
		$view_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id");

		$topic_author_color = $rcs->get_colors($topic_rowset[$i]);
		$topic_author = ($topic_rowset[$i]['user_id'] != ANONYMOUS) ? '<a href="' . $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $topic_rowset[$i]['user_id']), true) . '"' . $topic_author_color . '>' : '';
		$topic_author .= ( $topic_rowset[$i]['user_id'] != ANONYMOUS ) ? $topic_rowset[$i]['username'] : ( ( $topic_rowset[$i]['post_username'] != '' ) ? $topic_rowset[$i]['post_username'] : $lang['Guest'] );

		$topic_author .= ( $topic_rowset[$i]['user_id'] != ANONYMOUS ) ? '</a>' : '';

		$first_post_time = create_date2($board_config['default_dateformat'], $topic_rowset[$i]['topic_time'], $board_config['board_timezone']);

		$last_post_time = create_date2($board_config['default_dateformat'], $topic_rowset[$i]['post_time'], $board_config['board_timezone']);

		$last_post_author_color = $rcs->get_colors($topic_rowset[$i], '', false, 'group_id2', 'color2', 'level2');
		$last_post_author = ($topic_rowset[$i]['id2'] == ANONYMOUS) ? (($topic_rowset[$i]['post_username2'] != '') ? $topic_rowset[$i]['post_username2'] : $lang['Guest']) : '<a href="' . $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $topic_rowset[$i]['id2']), true) . '"' . $last_post_author_color . '>' . $topic_rowset[$i]['user2'] . '</a>';

		$last_post_url = '<a href="' . append_sid("viewtopic.$phpEx?"  . POST_POST_URL . '=' . $topic_rowset[$i]['topic_last_post_id']) . '#' . $topic_rowset[$i]['topic_last_post_id'] . '"><img src="' . $images['icon_latest_reply'] . '" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" border="0" /></a>';

		$views = $topic_rowset[$i]['topic_views'];
		
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		$topic_mod = '';
		if ( $is_auth['auth_mod'] )
		{
			$topic_mod .= '<div style="float:right; margin-right: 10px; display: inline-block;">';
			$topic_mod .= '<span class="topicmod" id="tmod_' . $topic_id . '">';
			$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=delete&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_delete'] . '" alt="' . $lang['Delete_topic'] . '" title="' . $lang['Delete_topic'] . '" border="0" /></a>&nbsp;';
			$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=move&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_move'] . '" alt="' . $lang['Move_topic'] . '" title="' . $lang['Move_topic'] . '" border="0" /></a>&nbsp;';
			$topic_mod .= ( $topic_rowset[$i]['topic_status'] == TOPIC_UNLOCKED ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=lock&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_lock'] . '" alt="' . $lang['Lock_topic'] . '" title="' . $lang['Lock_topic'] . '" border="0" /></a>&nbsp;' : "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=unlock&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_unlock'] . '" alt="' . $lang['Unlock_topic'] . '" title="' . $lang['Unlock_topic'] . '" border="0" /></a>&nbsp;';
			$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=split&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_split'] . '" alt="' . $lang['Split_topic'] . '" title="' . $lang['Split_topic'] . '" border="0" /></a>&nbsp;';
			$topic_mod .= '</span>';
			$topic_mod .= '</div>';
		}


		if ( $board_config['allow_smilies'] )
	    {
	      $topic_title = smilies_pass($topic_title);
	    }
		$template->assign_block_vars('topicrow', array(		
			'ROW_COLOR' => $row_color,
			'ROW_CLASS' => $row_class,
			'FORUM_ID' => $forum_id,
			'TOPIC_ID' => $topic_id,
			'TOPIC_FOLDER_IMG' => $folder_image,
			'HYPERCELL_CLASS' => get_hypercell_class($topic_rowset[$i]['topic_status'], ($folder_image == $folder_new), $topic_rowset[$i]['topic_type'], $replies),
			'TOPIC_AUTHOR' => $topic_author, 
			'GOTO_PAGE' => $goto_page,
			'REPLIES' => $replies,
			'NEWEST_POST_IMG' => $newest_post_img,
			'TOPIC_ATTACHMENT_IMG' => topic_attachment_image($topic_rowset[$i]['topic_attachment']),
			'TOPIC_TITLE' => $topic_title,
			'TOPIC_TYPE' => $topic_type,
			'VIEWS' => $views,
			'FIRST_POST_TIME' => $first_post_time, 
			'LAST_POST_TIME' => $last_post_time, 
			'LAST_POST_AUTHOR' => $last_post_author, 
			'LAST_POST_IMG' => $last_post_url,
			'TOPIC_MOD' => $topic_mod,

			'L_TOPIC_FOLDER_ALT' => $folder_alt, 

			'U_VIEW_TOPIC' => $view_topic_url)
		);
		display_sub_title('topicrow', $topic_sub_title, $board_config['sub_title_length']);
		if ( array_key_exists($i, $dividers) )
		{
			$template->assign_block_vars('topicrow.divider', array(
				'L_DIV_HEADERS' => $dividers[$i])
			);
		}
	}

	$topics_count -= $total_announcements;
	$topics_count += $total_global_announcements;	

	$template->assign_vars(array(
		'PAGINATION' => generate_pagination("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;topicdays=$topic_days&amp;sort=$sort_value&amp;order=$order_value", $topics_count, $board_config['topics_per_page'], $start),
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $topics_count / $board_config['topics_per_page'] )), 

		'L_GOTO_PAGE' => $lang['Goto_page'],
	));
	
	// V: better add a switch rather than an ugly empty line at the bottom when no topics
	$template->assign_var('HAS_TOPICS', true);
}
else
{
	//
	// No topics
	//
	$no_topics_msg = ( $forum_row['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['No_topics_post_one'];
	$template->assign_vars(array(
		'L_NO_TOPICS' => $no_topics_msg)
	);

	$template->assign_var('HAS_TOPICS', false );
}

//
// Parse the page and print
//
$template->pparse('body');

//
// Page footer
//
include $phpbb_root_path . 'includes/page_tail.'.$phpEx;