<?php
/***************************************************************************
 *                               viewtopic.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: viewtopic.php,v 1.186.2.45 2005/10/05 17:42:04 grahamje Exp $
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
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);

//
// Start initial var setup
//
$topic_id = $post_id = 0;
$vote_id = array();
if ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) )
{
	$topic_id = intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
else if ( isset($HTTP_GET_VARS['topic']) )
{
	$topic_id = intval($HTTP_GET_VARS['topic']);
}

if ( isset($HTTP_GET_VARS[POST_POST_URL]))
{
	$post_id = intval($HTTP_GET_VARS[POST_POST_URL]);
}


$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$start = ($start < 0) ? 0 : $start;

//START MOD Keep_unread_2
$mode = ( isset($HTTP_GET_VARS['mode']) ) ? htmlspecialchars( $HTTP_GET_VARS['mode'] ) : '';

if ( !empty($post_id) )
{ //added topic_last_post_id, p.post_time to sql
	$sql = "SELECT t.forum_id, t.topic_id, t.topic_last_post_id, p.post_time
		FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p
		WHERE t.topic_id = p.topic_id
		AND t.topic_moved_id = 0
		AND p.post_id = $post_id";
}
else if ( !empty($topic_id) )
{
	$sql = "SELECT t.forum_id, t.topic_id, t.topic_last_post_id
		FROM " . TOPICS_TABLE . " t
		WHERE t.topic_moved_id = 0
		AND t.topic_id = $topic_id";
}
else
{
	message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
}
if ( !$result = $db->sql_query($sql, false, 'movetopic_') )
{
	message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
}
if ( !$row = $db->sql_fetchrow($result) )
{
	message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
}
$db->sql_freeresult($result);
$forum_id = $row['forum_id'];
$topic_id = $row['topic_id'];
$post_time = $row['post_time'];
$topic_last_post_id = $row['topic_last_post_id'];
//END MOD Keep_unread_2

//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//
if ( $userdata['user_cell_time'] > 0 && !defined('CELL') && $userdata['session_logged_in'] && $userdata['user_level'] != ADMIN && $userdata['user_cell_punishment'] == 3 ) 
{ 
   redirect(append_sid("adr_cell.$phpEx", true)); 
} 
//-- mod: sf
include($phpbb_root_path . 'includes/functions_sf.'.$phpEx);
_sf_display_nav($forum_id);
//-- mod: sf - end

//START MOD Keep_unread_2 * Keep topic unread from given post onwards
if ($mode == 'unread')
{
	$board_config['tracking_unreads'][$topic_id] = $post_time-1; //testing for ">" only later on
	write_cookies($userdata);
	$message = $lang['keep_unread_done'] . '<br /><br />' .
	sprintf($lang['Click_return_forum'], '<a href="' . append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id") . '">', '</a> ') . '<br /><br />' .
	sprintf($lang['Click_return_index'], '<a href="' . append_sid("index.$phpEx") . '">', '</a> ');
	message_die(GENERAL_MESSAGE, $message);
}
$topic_last_read = topic_last_read($forum_id, $topic_id);
//END MOD Keep_unread_2

//
// Find topic id if user requested a newer
// or older topic
//
if ( isset($HTTP_GET_VARS['view']) && empty($HTTP_GET_VARS[POST_POST_URL]) )
{
	if ( $HTTP_GET_VARS['view'] == 'newest' )
	{ // read the first unread post in this topic
		$sql = "SELECT p.post_id, t.topic_last_post_id
			FROM (" . TOPICS_TABLE . " t
			LEFT JOIN " . POSTS_TABLE . " p ON p.topic_id = t.topic_id AND p.post_time > $topic_last_read)
			WHERE t.topic_id = $topic_id
			AND t.topic_moved_id = 0
			ORDER BY p.post_time";
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain newer/older topic information', '', __LINE__, __FILE__, $sql);
		}

		if ( !($row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_MESSAGE, 'No_new_posts_last_visit');
		}
		$post_id = empty($row['post_id']) ? $row['topic_last_post_id'] : $row['post_id'];
		redirect(append_sid("./viewtopic.$phpEx?" . POST_POST_URL . "=$post_id#$post_id", true));
	}
	else if ( $HTTP_GET_VARS['view'] == 'next' || $HTTP_GET_VARS['view'] == 'previous' )
	{
		$sql_condition = ( $HTTP_GET_VARS['view'] == 'next' ) ? '>' : '<';
		$sql_ordering = ( $HTTP_GET_VARS['view'] == 'next' ) ? 'ASC' : 'DESC';

		$sql = "SELECT t.topic_id
			FROM " . TOPICS_TABLE . " t, " . TOPICS_TABLE . " t2
			WHERE
				t2.topic_id = $topic_id
				AND t.forum_id = t2.forum_id
				AND t.topic_moved_id = 0
				AND t.topic_last_post_id $sql_condition t2.topic_last_post_id
			ORDER BY t.topic_last_post_id $sql_ordering
			LIMIT 1";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain newer/older topic information", '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$topic_id = intval($row['topic_id']);
			//MOD Keep_unread_2
			redirect(append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id", true));			
		}
		else
		{
			$message = ( $HTTP_GET_VARS['view'] == 'next' ) ? 'No_newer_topics' : 'No_older_topics';
			message_die(GENERAL_MESSAGE, $message);
		}
	}
}

//
// This rather complex gaggle of code handles querying for topics but
// also allows for direct linking to a post (and the calculation of which
// page the post is on and the correct display of viewtopic)
//
$join_sql_table = (!$post_id) ? '' : ", " . POSTS_TABLE . " p, " . POSTS_TABLE . " p2 ";
$join_sql = (!$post_id) ? "t.topic_id = $topic_id" : "p.post_id = $post_id AND t.topic_id = p.topic_id AND p2.topic_id = p.topic_id AND p2.post_id <= $post_id";
$count_sql = (!$post_id) ? '' : ", COUNT(p2.post_id) AS prev_posts";

$order_sql = (!$post_id) ? '' : "GROUP BY p.post_id, t.topic_id, t.topic_title, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id, f.forum_name, f.forum_status, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments, f.auth_ban, f.auth_greencard, f.auth_bluecard ORDER BY p.post_id ASC";

$sql = "SELECT t.topic_id, t.topic_title, t.topic_attribute, t.topic_poster, t.topic_status, t.topic_replies, t.topic_time, t.topic_type, t.topic_vote, t.topic_last_post_id,
		f.forum_name, f.forum_status, f.forum_password, f.forum_id, f.auth_view, f.auth_read, f.auth_post, f.auth_reply, f.auth_edit, f.auth_delete, f.auth_sticky, f.auth_announce, f.auth_pollcreate, f.auth_vote, f.auth_attachments, f.auth_ban, f.auth_greencard, f.auth_bluecard
		" . $count_sql . "
	FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f" . $join_sql_table . "
	WHERE $join_sql
		AND f.forum_id = t.forum_id
		$order_sql";
attach_setup_viewtopic_auth($order_sql, $sql);

//-- mod : quick post es -------------------------------------------------------
//-- add
$sql = str_replace(', f.forum_id', ', f.forum_id, f.forum_qpes', $sql);
//-- fin mod : quick post es ---------------------------------------------------		
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain topic information", '', __LINE__, __FILE__, $sql);
}

if ( !($forum_topic_data = $db->sql_fetchrow($result)) )
{
	message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
}

$forum_id = intval($forum_topic_data['forum_id']);

//MOD Keep_unread_2: session management already done above

//
// Start auth check
//
$is_auth = array();
$is_auth = auth(AUTH_ALL, $forum_id, $userdata, $forum_topic_data);

if( !$is_auth['auth_view'] || !$is_auth['auth_read'] )
{
	if ( !$userdata['session_logged_in'] )
	{
		$redirect = ($post_id) ? POST_POST_URL . "=$post_id" : POST_TOPIC_URL . "=$topic_id";
		$redirect .= ($start) ? "&start=$start" : '';
		redirect(append_sid("login.$phpEx?redirect=viewtopic.$phpEx&$redirect", true));
	}

	$message = ( !$is_auth['auth_view'] ) ? $lang['Topic_post_not_exist'] : sprintf($lang['Sorry_auth_read'], $is_auth['auth_read_type']);

	message_die(GENERAL_MESSAGE, $message);
}
//
// End auth check
//

$forum_name = $forum_topic_data['forum_name'];
$topic_title = $forum_topic_data['topic_title'];
//-- mod : quick title edition -------------------------------------------------
//-- add
include($get->url('includes/class_attributes'));
$qte->attr($topic_title, $forum_topic_data['topic_attribute']);
//-- fin mod : quick title edition ---------------------------------------------
$topic_id = intval($forum_topic_data['topic_id']);
$topic_time = $forum_topic_data['topic_time'];
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
		if( $forum_topic_data['topic_password'] != '' )
		{
			password_check('topic', $topic_id, $HTTP_POST_VARS['password'], $redirect);
		}
		else if( $forum_topic_data['forum_password'] != '' )
		{
			password_check('forum', $forum_id, $HTTP_POST_VARS['password'], $redirect);
		}
	}

	if( $forum_topic_data['topic_password'] != '' )
	{
		$passdata = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_tpass']) ) ? unserialize(stripslashes($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_tpass'])) : '';
		if( $passdata[$topic_id] != md5($forum_topic_data['topic_password']) )
		{
			password_box('topic', $redirect);
		}
	}
	else if( $forum_topic_data['forum_password'] != '' )
	{
		$passdata = ( isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_fpass']) ) ? unserialize(stripslashes($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_fpass'])) : '';
		if( $passdata[$forum_id] != md5($forum_topic_data['forum_password']) )
		{
			password_box('forum', $redirect);
		}
	}
}
//
// END: Password check
//

if ($post_id)
{
	$start = floor(($forum_topic_data['prev_posts'] - 1) / intval($board_config['posts_per_page'])) * intval($board_config['posts_per_page']);
}
// www.phpBB-SEO.com SEO TOOLKIT BEGIN
if ( !isset($phpbb_seo->seo_url['forum'][$forum_topic_data['forum_id']]) ) {
	$phpbb_seo->seo_url['forum'][$forum_topic_data['forum_id']] = $phpbb_seo->format_url($forum_name, $phpbb_seo->seo_static['forum']);
}
// www.phpBB-SEO.com SEO TOOLKIT END
// www.phpBB-SEO.com SEO TOOLKIT BEGIN
// Define censored word matches
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);
$topic_title = ( count($orig_word) ) ? preg_replace($orig_word, $replacement_word, $topic_title) : $topic_title;
if ( !isset($phpbb_seo->seo_url['topic'][$topic_id]) ) {
	$phpbb_seo->seo_url['topic'][$topic_id] = $phpbb_seo->format_url($topic_title);
}
$uri = $phpbb_seo->seo_req_uri();
$postorder_redir = empty($_POST['postorder']) && empty($_GET['postorder']);
if ($_GET['postorder'] == 'asc'  || $_POST['postorder'] == 'asc' ) {
	$postorder_redir = TRUE;
}
$phpbb_seo->seo_start( $start, $board_config['posts_per_page'] );
$phpbb_seo->page_url = $phpbb_seo->seo_url['topic'][$topic_id] . $phpbb_seo->seo_delim['topic'] . $topic_id . $phpbb_seo->start . $phpbb_seo->seo_ext['topic'];
$phpbb_seo->seo_cond(!$userdata['session_logged_in'] && ( strpos($uri, "sid=" ) !== FALSE ) );
if ( $phpbb_seo->do_redir || ( $postorder_redir &&  strpos($uri, 'watch=') === FALSE && strpos($uri, $phpbb_seo->page_url) === FALSE )  ) {
	$phpbb_seo->seo_redirect( $phpbb_seo->seo_path['phpbb_url'] . $phpbb_seo->page_url . ( ( $post_id ) ? "#$post_id" : "" ) );
}
// www.phpBB-SEO.com SEO TOOLKIT END

//
// Is user watching this thread?
//
if( $userdata['session_logged_in'] )
{
	$can_watch_topic = TRUE;

	$sql = "SELECT notify_status
		FROM " . TOPICS_WATCH_TABLE . "
		WHERE topic_id = $topic_id
			AND user_id = " . $userdata['user_id'];
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain topic watch information", '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		if ( isset($HTTP_GET_VARS['unwatch']) )
		{
			if ( $HTTP_GET_VARS['unwatch'] == 'topic' )
			{
				$is_watching_topic = 0;

				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "DELETE $sql_priority FROM " . TOPICS_WATCH_TABLE . "
					WHERE topic_id = $topic_id
						AND user_id = " . $userdata['user_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not delete topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">')
			);

			$message = $lang['No_longer_watching'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$is_watching_topic = TRUE;

			if ( $row['notify_status'] )
			{
				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "UPDATE $sql_priority " . TOPICS_WATCH_TABLE . "
					SET notify_status = 0
					WHERE topic_id = $topic_id
						AND user_id = " . $userdata['user_id'];
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not update topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}
		}
	}
	else
	{
		if ( isset($HTTP_GET_VARS['watch']) )
		{
			if ( $HTTP_GET_VARS['watch'] == 'topic' )
			{
				$is_watching_topic = TRUE;

				$sql_priority = (SQL_LAYER == "mysql") ? "LOW_PRIORITY" : '';
				$sql = "INSERT $sql_priority INTO " . TOPICS_WATCH_TABLE . " (user_id, topic_id, notify_status)
					VALUES (" . $userdata['user_id'] . ", $topic_id, 0)";
				if ( !($result = $db->sql_query($sql)) )
				{
					message_die(GENERAL_ERROR, "Could not insert topic watch information", '', __LINE__, __FILE__, $sql);
				}
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">')
			);

			$message = $lang['You_are_watching'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start") . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			$is_watching_topic = 0;
		}
	}
}
else
{
	if ( isset($HTTP_GET_VARS['unwatch']) )
	{
		if ( $HTTP_GET_VARS['unwatch'] == 'topic' )
		{
			redirect(append_sid("login.$phpEx?redirect=viewtopic.$phpEx&" . POST_TOPIC_URL . "=$topic_id&unwatch=topic", true));
		}
	}
	else
	{
		$can_watch_topic = 0;
		$is_watching_topic = 0;
	}
}
//-- mod : addon hide for bbcbxr -----------------------------------------------
//-- add
$valid = FALSE;
if( $userdata['session_logged_in'] )
{
  $sql = "SELECT p.poster_id, p.topic_id
    FROM " . POSTS_TABLE . " p
    WHERE p.topic_id = $topic_id
    AND p.poster_id = " . $userdata['user_id'];
  $resultat = $db->sql_query($sql);
  $valid = $db->sql_numrows($resultat) || $is_auth['auth_mod'];
}
//-- fin mod : addon hide for bbcbxr -------------------------------------------
//
// Generate a 'Show posts in previous x days' select box. If the postdays var is POSTed
// then get it's value, find the number of topics with dates newer than it (to properly
// handle pagination) and alter the main query
//
$previous_days = array(0, 1, 7, 14, 30, 90, 180, 364);
$previous_days_text = array($lang['All_Posts'], $lang['1_Day'], $lang['7_Days'], $lang['2_Weeks'], $lang['1_Month'], $lang['3_Months'], $lang['6_Months'], $lang['1_Year']);

if( !empty($HTTP_POST_VARS['postdays']) || !empty($HTTP_GET_VARS['postdays']) )
{
	$post_days = ( !empty($HTTP_POST_VARS['postdays']) ) ? intval($HTTP_POST_VARS['postdays']) : intval($HTTP_GET_VARS['postdays']);
	$min_post_time = time() - (intval($post_days) * 86400);

	$sql = "SELECT COUNT(p.post_id) AS num_posts
		FROM " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p
		WHERE t.topic_id = $topic_id
			AND p.topic_id = t.topic_id
			AND p.post_time >= $min_post_time";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain limited topics count information", '', __LINE__, __FILE__, $sql);
	}

	$total_replies = ( $row = $db->sql_fetchrow($result) ) ? intval($row['num_posts']) : 0;

	$limit_posts_time = "AND p.post_time >= $min_post_time ";

	if ( !empty($HTTP_POST_VARS['postdays']))
	{
		$start = 0;
	}
}
else
{
	$total_replies = intval($forum_topic_data['topic_replies']) + 1;

	$limit_posts_time = '';
	$post_days = 0;
}

$select_post_days = '<select name="postdays">';
for($i = 0; $i < count($previous_days); $i++)
{
	$selected = ($post_days == $previous_days[$i]) ? ' selected="selected"' : '';
	$select_post_days .= '<option value="' . $previous_days[$i] . '"' . $selected . '>' . $previous_days_text[$i] . '</option>';
}
$select_post_days .= '</select>';

//
// Decide how to order the post display
//
if ( !empty($HTTP_POST_VARS['postorder']) || !empty($HTTP_GET_VARS['postorder']) )
{
	$post_order = (!empty($HTTP_POST_VARS['postorder'])) ? htmlspecialchars($HTTP_POST_VARS['postorder']) : htmlspecialchars($HTTP_GET_VARS['postorder']);
	$post_time_order = ($post_order == "asc") ? "ASC" : "DESC";
}
else
{
	$post_order = 'asc';
	$post_time_order = 'ASC';
}

$select_post_order = '<select name="postorder">';
if ( $post_time_order == 'ASC' )
{
	$select_post_order .= '<option value="asc" selected="selected">' . $lang['Oldest_First'] . '</option><option value="desc">' . $lang['Newest_First'] . '</option>';
}
else
{
	$select_post_order .= '<option value="asc">' . $lang['Oldest_First'] . '</option><option value="desc" selected="selected">' . $lang['Newest_First'] . '</option>';
}
$select_post_order .= '</select>';

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
// Go ahead and pull all data for this topic
//
$sql = "SELECT u.username, u.user_id, u.user_posts, u.user_from, u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_regdate,
		u.user_msnm, u.user_viewemail, u.user_rank, u.user_sig, u.user_colortext, u.user_sig_bbcode_uid, u.user_avatar, u.user_avatar_type,
		u.user_allowavatar, u.user_allowsmile, u.user_allowdefaultavatar, u.user_allow_viewonline, u.user_session_time, u.user_points,
		u.user_warnings, u.user_level, u.user_level, u.user_gender, u.user_cell_time, u.user_adr_ban,
		p.*, pt.post_text, pt.post_subject, pt.bbcode_uid
	FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt
	WHERE p.topic_id = $topic_id
		$limit_posts_time
		AND pt.post_id = p.post_id
		AND u.user_id = p.poster_id
	ORDER BY p.post_time $post_time_order
	LIMIT $start, ".$board_config['posts_per_page'];
//-- mod : post description ----------------------------------------------------
//-- add
$sql = str_replace(', pt.post_subject', ', pt.post_subject, pt.post_sub_title', $sql);
//-- fin mod : post description ------------------------------------------------	
//-- mod : flags ---------------------------------------------------------------
//-- add
$sql = str_replace('SELECT ', 'SELECT u.user_flag, ', $sql);
//-- fin mod : flags -----------------------------------------------------------	
//-- mod : birthday ------------------------------------------------------------
//-- add
$sql = str_replace('SELECT ', 'SELECT u.user_birthday, u.user_zodiac, ', $sql);
//-- fin mod : birthday --------------------------------------------------------
//-- mod : rank color system ---------------------------------------------------
//-- add
$sql = str_replace('SELECT ', 'SELECT u.user_level, u.user_color, u.user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------	
//-- mod : quick title edition -------------------------------------------------
//-- add
$sql = str_replace('pt.bbcode_uid', 'pt.bbcode_uid, t.topic_poster, t.topic_attribute', $sql);
$sql = str_replace(POSTS_TEXT_TABLE . ' pt', POSTS_TEXT_TABLE . ' pt, ' . TOPICS_TABLE . ' t', $sql);
$sql = str_replace('WHERE p.topic_id = ' . $topic_id, 'WHERE p.topic_id = ' . $topic_id . ' AND t.topic_id = p.topic_id', $sql);
//-- fin mod : quick title edition ---------------------------------------------
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain post/user information.", '', __LINE__, __FILE__, $sql);
}

$postrow = array();
if ($row = $db->sql_fetchrow($result))
{
	do
	{
		$postrow[] = $row;
	}
	while ($row = $db->sql_fetchrow($result));
	$db->sql_freeresult($result);

	$total_posts = count($postrow);
}
else 
{ 
   include($phpbb_root_path . 'includes/functions_admin.' . $phpEx); 
   sync('topic', $topic_id); 

   message_die(GENERAL_MESSAGE, $lang['No_posts_topic']); 
} 

$resync = FALSE; 
if ($forum_topic_data['topic_replies'] + 1 < $start + count($postrow)) 
{ 
   $resync = TRUE; 
} 
elseif ($start + $board_config['posts_per_page'] > $forum_topic_data['topic_replies']) 
{ 
   $row_id = intval($forum_topic_data['topic_replies']) % intval($board_config['posts_per_page']); 
   if ($postrow[$row_id]['post_id'] != $forum_topic_data['topic_last_post_id'] || $start + count($postrow) < $forum_topic_data['topic_replies']) 
   { 
      $resync = TRUE; 
   } 
} 
elseif (count($postrow) < $board_config['posts_per_page']) 
{ 
   $resync = TRUE; 
} 

if ($resync) 
{ 
   include($phpbb_root_path . 'includes/functions_admin.' . $phpEx); 
   sync('topic', $topic_id); 

   $result = $db->sql_query('SELECT COUNT(post_id) AS total FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $topic_id); 
   $row = $db->sql_fetchrow($result); 
   $total_replies = $row['total']; 
}

$sql = "SELECT *
	FROM " . RANKS_TABLE . "
	ORDER BY rank_special, rank_min";
if ( !($result = $db->sql_query($sql, false, true)) )
{
	message_die(GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql);
}

$ranksrow = array();
while ( $row = $db->sql_fetchrow($result) )
{
	$ranksrow[] = $row;
}
$db->sql_freeresult($result);

// www.phpBB-SEO.com SEO TOOLKIT BEGIN
// Moved this a little above for the zero dupe
//
// Define censored word matches
//
//$orig_word = array();
//$replacement_word = array();
//obtain_word_list($orig_word, $replacement_word);

//
// Censor topic title
//
//if ( count($orig_word) )
//{
//	$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
//}
// www.phpBB-SEO.com SEO TOOLKIT END
//words surronded by brackets [] 

$topic_title_without_tth = $forum_topic_data['topic_title'];

//
// Was a highlight request part of the URI?
//
$highlight_match = $highlight = '';
if (isset($HTTP_GET_VARS['highlight']))
{
	// Split words and phrases
	$words = explode(' ', trim(htmlspecialchars($HTTP_GET_VARS['highlight'])));

	for($i = 0; $i < sizeof($words); $i++)
	{
		if (trim($words[$i]) != '')
		{
			$highlight_match .= (($highlight_match != '') ? '|' : '') . str_replace('*', '\w*', preg_quote($words[$i], '#'));
		}
	}
	unset($words);

	$highlight = urlencode($HTTP_GET_VARS['highlight']);
	$highlight_match = phpbb_rtrim($highlight_match, "\\");
}

//
// Post, reply and other URL generation for
// templating vars
//
$new_topic_url = append_sid("posting.$phpEx?mode=newtopic&amp;" . POST_FORUM_URL . "=$forum_id");
$reply_topic_url = append_sid("posting.$phpEx?mode=reply&amp;" . POST_TOPIC_URL . "=$topic_id");
$view_forum_url = append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id");
$view_prev_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=previous");
$view_next_topic_url = append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;view=next");

//
// Mozilla navigation bar
//
$nav_links['prev'] = array(
	'url' => $view_prev_topic_url,
	'title' => $lang['View_previous_topic']
);
$nav_links['next'] = array(
	'url' => $view_next_topic_url,
	'title' => $lang['View_next_topic']
);
$nav_links['up'] = array(
	'url' => $view_forum_url,
	'title' => $forum_name
);

$reply_img = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED ) ? $images['reply_locked'] : $images['reply_new'];
$reply_alt = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED ) ? $lang['Topic_locked'] : $lang['Reply_to_topic'];
$post_img = ( $forum_topic_data['forum_status'] == FORUM_LOCKED ) ? $images['post_locked'] : $images['post_new'];
$post_alt = ( $forum_topic_data['forum_status'] == FORUM_LOCKED ) ? $lang['Forum_locked'] : $lang['Post_new_topic'];

//
// Set a cookie for this topic
//
//START MOD Keep_unread_2 * $topic_last_read is known
//Reached the last post in a topic with unread posts
// (note: the definition in the next line makes sure things work right regardless of whether viewtopic is set to display from oldest to newest or newest to oldest) 
$lastpost = $postrow[0]['post_time'] < $postrow[($total_posts-1)]['post_time'] ? $total_posts-1 : 0;
if ($topic_last_post_id == $postrow[$lastpost]['post_id']) 
{
	//Read up to time of retrieval of this topic
	$board_config['tracking_unreads'][$topic_id] = time();
}
//Reading a page, but not the last one, in a topic with new posts
elseif (isset($board_config['tracking_unreads'][$topic_id]))
{
	//Set the highest of current topic_last_read and time of last post on page
	$board_config['tracking_unreads'][$topic_id] = max($topic_last_read, $postrow[$lastpost]['post_time']);  
}
write_cookies($userdata); //Save
//END MOD Keep_unread_2

//
// Load templates
//
$template->set_filenames(array(
	'body' => 'viewtopic_body.tpl')
);
make_jumpbox('viewforum.'.$phpEx, $forum_id);

//
// Output page header
//
// www.phpBB-SEO.com SEO TOOLKIT BEGIN - TITLE
$extra_title = ($start != 0) ? ' - ' . $lang['Page'] . ( floor( ($start / $board_config['posts_per_page']) ) + 1 ) : '';
$page_title = $topic_title_without_tth . $extra_title; //modified by Topic Title Highlighter mod 
// www.phpBB-SEO.com SEO TOOLKIT BEGIN - META

$phpbb_seo->seo_meta['meta_desc'] = $phpbb_seo->meta_filter_txt($board_config['sitename'] . " : $page_title");
$m_kewrd = '';
$sql = "SELECT w.word_text
		FROM " . TOPICS_TABLE . " t, " . SEARCH_MATCH_TABLE . " m, " . SEARCH_WORD_TABLE . " w
		WHERE t.topic_id = $topic_id
			AND t.topic_first_post_id = m.post_id
			AND m.word_id = w.word_id LIMIT 15";
if( ($result = $db->sql_query($sql)) ) {

	while ( $meta_row = $db->sql_fetchrow($result) ) {
		$m_kewrd .= " " . $meta_row['word_text'];
	}
}
$phpbb_seo->seo_meta['keywords'] = $phpbb_seo->make_keywords("$m_kewrd " . $phpbb_seo->seo_meta['meta_desc']);
// www.phpBB-SEO.com SEO TOOLKIT END - META
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
//-- mod : toolbar -------------------------------------------------------------
//-- add
if ( $can_watch_topic )
{
	$uw_parm = $is_watching_topic ? 'unwatch' : 'watch';
	$tlbr_more = array(
		'watch' => array('link_pgm' => 'viewtopic', 'link_parms' => array(POST_TOPIC_URL => intval($topic_id), $uw_parm => 'topic', 'start' => intval($start)), 'txt' => $is_watching_topic ? 'Stop_watching_topic' : 'Start_watching_topic', 'img' => $is_watching_topic ? 'tlbr_un_watch' : 'tlbr_watch'),
	);
}
build_toolbar('viewtopic', $l_privmsgs_text, $s_privmsg_new, $forum_id, $tlbr_more);
//-- fin mod : toolbar ---------------------------------------------------------
//-- mod : quick post es -------------------------------------------------------
//-- add
$forum_qpes = intval($forum_topic_data['forum_qpes']);
if (!empty($forum_qpes))
{
	include($phpbb_root_path . 'qpes.' . $phpEx);
}
//-- fin mod : quick post es ---------------------------------------------------

//
// User authorisation levels output
//
$s_auth_can = ( ( $is_auth['auth_post'] ) ? $lang['Rules_post_can'] : $lang['Rules_post_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_reply'] ) ? $lang['Rules_reply_can'] : $lang['Rules_reply_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_edit'] ) ? $lang['Rules_edit_can'] : $lang['Rules_edit_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_delete'] ) ? $lang['Rules_delete_can'] : $lang['Rules_delete_cannot'] ) . '<br />';
$s_auth_can .= ( ( $is_auth['auth_vote'] ) ? $lang['Rules_vote_can'] : $lang['Rules_vote_cannot'] ) . '<br />';
attach_build_auth_levels($is_auth, $s_auth_can);
$s_auth_can .= ( $is_auth['auth_ban'] ) ? $lang['Rules_ban_can'] . "<br />" : ""; 
$s_auth_can .= ( $is_auth['auth_greencard'] ) ? $lang['Rules_greencard_can'] . "<br />" : ""; 
$s_auth_can .= ( $is_auth['auth_bluecard'] ) ? $lang['Rules_bluecard_can'] . "<br />" : "";

$topic_mod = '';

if ( $is_auth['auth_mod'] )
{
	$s_auth_can .= sprintf($lang['Rules_moderate'], "<a href=\"modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=delete&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_delete'] . '" alt="' . $lang['Delete_topic'] . '" title="' . $lang['Delete_topic'] . '" border="0" /></a>&nbsp;';

	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=move&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_move'] . '" alt="' . $lang['Move_topic'] . '" title="' . $lang['Move_topic'] . '" border="0" /></a>&nbsp;';

	$topic_mod .= ( $forum_topic_data['topic_status'] == TOPIC_UNLOCKED ) ? "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=lock&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_lock'] . '" alt="' . $lang['Lock_topic'] . '" title="' . $lang['Lock_topic'] . '" border="0" /></a>&nbsp;' : "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=unlock&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_unlock'] . '" alt="' . $lang['Unlock_topic'] . '" title="' . $lang['Unlock_topic'] . '" border="0" /></a>&nbsp;';

	$topic_mod .= "<a href=\"modcp.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;mode=split&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_mod_split'] . '" alt="' . $lang['Split_topic'] . '" title="' . $lang['Split_topic'] . '" border="0" /></a>&nbsp;';
}

//-- mod : quick title edition -------------------------------------------------
//-- add
if ( ( ($userdata['user_id'] == $postrow[$row_id]['topic_poster']) && ($userdata['user_level'] == USER) ) || ($userdata['user_level'] == MOD) || ($userdata['user_level'] == ADMIN) )
{
	$get->assign_switch('switch_attribute', true);
}
//-- fin mod : quick title edition ---------------------------------------------
//
// Topic watch information
//
$s_watching_topic = '';
if ( $can_watch_topic )
{
	if ( $is_watching_topic )
	{
		$s_watching_topic = "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;unwatch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '">' . $lang['Stop_watching_topic'] . '</a>';
		$s_watching_topic_img = ( isset($images['topic_un_watch']) ) ? "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;unwatch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['topic_un_watch'] . '" alt="' . $lang['Stop_watching_topic'] . '" title="' . $lang['Stop_watching_topic'] . '" border="0"></a>' : '';
	}
	else
	{
		$s_watching_topic = "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;watch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '">' . $lang['Start_watching_topic'] . '</a>';
		$s_watching_topic_img = ( isset($images['Topic_watch']) ) ? "<a href=\"viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;watch=topic&amp;start=$start&amp;sid=" . $userdata['session_id'] . '"><img src="' . $images['Topic_watch'] . '" alt="' . $lang['Start_watching_topic'] . '" title="' . $lang['Start_watching_topic'] . '" border="0"></a>' : '';
	}
}

//
// If we've got a hightlight set pass it on to pagination,
// I get annoyed when I lose my highlight after the first page.
//
$pagination = ( $highlight != '' ) ? generate_pagination("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order&amp;highlight=$highlight", $total_replies, $board_config['posts_per_page'], $start) : generate_pagination("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order", $total_replies, $board_config['posts_per_page'], $start);

// Start Smilies Invasion Mod
if ( $board_config['allow_smilies'] )
{
  $forum_name = smilies_pass($forum_name);
  $topic_title = smilies_pass($topic_title);
}
// End Smilies Invasion Mod
//
// Send vars to template
//
$template->assign_vars(array(
	'FORUM_ID' => $forum_id,
    'FORUM_NAME' => $forum_name,
    'TOPIC_ID' => $topic_id,
    'TOPIC_TITLE' => $topic_title,
	'PAGINATION' => $pagination,
	'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / intval($board_config['posts_per_page']) ) + 1 ), ceil( $total_replies / intval($board_config['posts_per_page']) )),

	'POST_IMG' => $post_img,
	'REPLY_IMG' => $reply_img,

	'L_AUTHOR' => $lang['Author'],
	'L_MESSAGE' => $lang['Message'],
	'L_ATTRIBUTE' => $lang['Attribute'],
	'L_POSTED' => $lang['Posted'],
	'L_POST_SUBJECT' => $lang['Post_subject'],
	'L_VIEW_NEXT_TOPIC' => $lang['View_next_topic'],
	'L_VIEW_PREVIOUS_TOPIC' => $lang['View_previous_topic'],
	'L_POST_NEW_TOPIC' => $post_alt,
	'L_POST_REPLY_TOPIC' => $reply_alt,
	'L_BACK_TO_TOP' => $lang['Back_to_top'],
	'L_DISPLAY_POSTS' => $lang['Display_posts'],
	'L_LOCK_TOPIC' => $lang['Lock_topic'],
	'L_UNLOCK_TOPIC' => $lang['Unlock_topic'],
	'L_MOVE_TOPIC' => $lang['Move_topic'],
	'L_SPLIT_TOPIC' => $lang['Split_topic'],
	'L_DELETE_TOPIC' => $lang['Delete_topic'],
	'L_GOTO_PAGE' => $lang['Goto_page'],

	'S_TOPIC_LINK' => POST_TOPIC_URL,
	'S_SELECT_POST_DAYS' => $select_post_days,
	'S_SELECT_POST_ORDER' => $select_post_order,
	'S_POST_DAYS_ACTION' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . '=' . $topic_id . "&amp;start=$start"),
	'S_AUTH_LIST' => $s_auth_can,
	'S_TOPIC_ADMIN' => $topic_mod,
	'S_WATCH_TOPIC' => $s_watching_topic,
	'S_WATCH_TOPIC_IMG' => $s_watching_topic_img,
//-- mod : quick title edition -------------------------------------------------
//-- add
	'S_ATTRIBUTE_SELECTOR' => $qte->combo($forum_topic_data['topic_attribute'], $forum_topic_data['topic_poster']),
	'F_ATTRIBUTE_URL' => $get->url('modcp', array('sid' => $userdata['session_id']), true),
	'L_ATTRIBUTE_APPLY' => $lang['Attribute_apply'],
	'I_MINI_SUBMIT' => $images['cmd_mini_submit'],
//-- fin mod : quick title edition ---------------------------------------------

	'U_VIEW_TOPIC' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;start=$start&amp;postdays=$post_days&amp;postorder=$post_order&amp;highlight=$highlight"),
	'U_VIEW_FORUM' => $view_forum_url,
	'U_VIEW_OLDER_TOPIC' => $view_prev_topic_url,
	'U_VIEW_NEWER_TOPIC' => $view_next_topic_url,
	'U_POST_NEW_TOPIC' => $new_topic_url,
	'U_POST_REPLY_TOPIC' => $reply_topic_url)
);

//
// Does this topic contain a poll?
//
if ( !empty($forum_topic_data['topic_vote']) )
{
	$s_hidden_fields = '';

	$sql = "SELECT vd.vote_id, vd.vote_text, vd.vote_start, vd.vote_length, vd.vote_max, vd.vote_voted, vd.vote_hide, vd.vote_tothide, vr.vote_option_id, vr.vote_option_text, vr.vote_result
		FROM " . VOTE_DESC_TABLE . " vd, " . VOTE_RESULTS_TABLE . " vr
		WHERE vd.topic_id = $topic_id
			AND vr.vote_id = vd.vote_id
		ORDER BY vr.vote_option_id ASC";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain vote data for this topic", '', __LINE__, __FILE__, $sql);
	}

	if ( $vote_info = $db->sql_fetchrowset($result) )
	{
		$db->sql_freeresult($result);
		$vote_options = count($vote_info);

		$vote_id = $vote_info[0]['vote_id'];
		$vote_title = $vote_info[0]['vote_text'];
		$max_vote = $vote_info[0]['vote_max'];
		$voted_vote = $vote_info[0]['vote_voted'];
		$hide_vote = $vote_info[0]['vote_hide'];
		$tothide_vote = $vote_info[0]['vote_tothide'];		

		$sql = "SELECT vote_id
			FROM " . VOTE_USERS_TABLE . "
			WHERE vote_id = $vote_id
				AND vote_user_id = " . intval($userdata['user_id']);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain user vote data for this topic", '', __LINE__, __FILE__, $sql);
		}

		$user_voted = ( $row = $db->sql_fetchrow($result) ) ? TRUE : 0;
		$db->sql_freeresult($result);

		if ( isset($HTTP_GET_VARS['vote']) || isset($HTTP_POST_VARS['vote']) )
		{
			$view_result = ( ( ( isset($HTTP_GET_VARS['vote']) ) ? $HTTP_GET_VARS['vote'] : $HTTP_POST_VARS['vote'] ) == 'viewresult' ) ? TRUE : 0;
		}
		else
		{
			$view_result = 0;
		}

		$poll_expired = ( $vote_info[0]['vote_length'] ) ? ( ( $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] < time() ) ? TRUE : 0 ) : 0;

		if ( $user_voted || $view_result || $poll_expired || !$is_auth['auth_vote'] || $forum_topic_data['topic_status'] == TOPIC_LOCKED )
		{
// Colour on Poll Results MOD, By Manipe (Begin)
			$sql1 = "SELECT vote_option_id 
				FROM " . VOTE_USERS_TABLE . " 
				WHERE vote_user_id = '" . $userdata['user_id'] . "' 
				AND vote_id = '" . $vote_id . "'";
			if ( !($result1 = $db->sql_query($sql1)) )
			{
			 	message_die(GENERAL_ERROR, 'Could not obtain user voted information', '', __LINE__, __FILE__, $sql);
			}
			$row1 = $db->sql_fetchrow($result1);
			$voted_option_id =  $row1['vote_option_id'];
			$db->sql_freeresult($result1);
// Colour on Poll Results MOD, By Manipe (End)		
			$template->set_filenames(array(
				'pollbox' => 'viewtopic_poll_result.tpl')
			);

			$vote_results_sum = 0;

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_results_sum += $vote_info[$i]['vote_result'];
			}

			$vote_graphic = 0;
			$vote_graphic_max = count($images['voting_graphic']);

			for($i = 0; $i < $vote_options; $i++)
			{
// Colour on Poll Results MOD, By Manipe (Begin)
				$vote_percent = ( $vote_results_sum > 0 ) ? $vote_info[$i]['vote_result'] / $vote_results_sum : 0; 
				$vote_graphic_length = round($vote_percent * $board_config['vote_graphic_length']);
// Colour on Poll Results MOD, By Manipe (End)

				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}
// Colour on Poll Results MOD, By Manipe (Begin)
				if ($voted_option_id == ($i+1)){
					$vote_color = 'purple';
				}
				else{
					if ( $vote_percent <= 0.3 ){
						$vote_color = 'green';
					}
					else if ( ($vote_percent > 0.3) && ($vote_percent <= 0.6) ){
						$vote_color = 'blue';
					}
					else if ( $vote_percent > 0.6 ){
						$vote_color = 'red';
					}
				}
// Colour on Poll Results MOD, By Manipe (End)				

				$hide_vote_bl = '';
				$hide_vote_zr = '0';
				$total_votes_1 = $lang['Total_votes'] ;
				$total_votes_2 = $vote_results_sum ;
				if ( ( $poll_expired == 0 ) && ( $hide_vote == 1 ) && ( $vote_info[0]['vote_length'] <> 0 ) )
				{
					if ( $tothide_vote == 1 )
					{
						$total_votes_1 = '' ;
						$total_votes_2 = '' ;
					}
					$poll_expires_c = $lang['Results_after'];
					$template->assign_block_vars("poll_option", array(
						'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'],
						'POLL_OPTION_RESULT' => $hide_vote_bl,
						'POLL_OPTION_PERCENT' => $hide_vote_bl,
						'POLL_OPTION_IMG' => $vote_graphic_img,
						'POLL_OPTION_IMG_WIDTH' => $hide_vote_zr)
					);
				}
				else
				{
				$poll_expires_c = '';				
				$template->assign_block_vars("poll_option", array(
					'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'],
					'POLL_OPTION_RESULT' => $vote_info[$i]['vote_result'],
					'POLL_OPTION_PERCENT' => sprintf("%.1d%%", ($vote_percent * 100)),
// Colour on Poll Results MOD, By Manipe (Begin)
					'POLL_OPTION_COLOR' => $vote_color,
// Colour on Poll Results MOD, By Manipe (End)
					'POLL_OPTION_IMG' => $vote_graphic_img,
					'POLL_OPTION_IMG_WIDTH' => $vote_graphic_length)
				);
				}				
			}

			if ( ( $poll_expired == 0 ) && ( $vote_info[0]['vote_length'] <> 0 ) )
			{
				$poll_expire_1 = (( $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] ) - time() );
				$poll_expire_2 = intval($poll_expire_1/86400);
				$poll_expire_a = $poll_expire_2*86400;
				$poll_expire_3 = intval(($poll_expire_1 - ($poll_expire_a))/3600);
				$poll_expire_b = $poll_expire_3*3600;
				$poll_expire_4 = intval((($poll_expire_1 - ($poll_expire_a) - ($poll_expire_b)))/60);
				$poll_comma = ', ';
				$poll_space = ' ';
				$poll_expire_2 == '0' ? $poll_expire_6='' : ( ( $poll_expire_3 == 0 && $poll_expire_4 == 0 ) ? $poll_expire_6=$poll_expire_2.$poll_space.$lang['Days'] : $poll_expire_6=$poll_expire_2.$poll_space.$lang['Days'].$poll_comma ) ;
				$poll_expire_3 == '0' ? $poll_expire_7='' : ( $poll_expire_4 == 0 ? $poll_expire_7=$poll_expire_3.$poll_space.$lang['Hours'] : $poll_expire_7=$poll_expire_3.$poll_space.$lang['Hours'].$poll_comma ) ;
				$poll_expire_4 == '0' ? $poll_expire_8='' : $poll_expire_8=$poll_expire_4.$poll_space.$lang['Minutes'] ;
				$poll_expires_d = $lang['Poll_expires'];
			}
			else if ($poll_expired == 1)
			{
				$poll_expires_6 = '';
				$poll_expires_7 = '';
				$poll_expires_8 = '';
				$poll_expires_d = $lang['Poll_expiredyes'];
			}
			else
			{
				$poll_expires_6 = '';
				$poll_expires_7 = '';
				$poll_expires_8 = '';
				$poll_expires_d = $lang['Poll_noexpire'];
			}
			$voted_vote_nb = $voted_vote;
			$template->assign_vars(array(
				'VOTED_SHOW' => $lang['Voted_show'],
				'L_TOTAL_VOTES' => $total_votes_1,
				'L_RESULTS_AFTER' => $poll_expires_c,
				'L_POLL_EXPIRES' => $poll_expires_d,
				'POLL_EXPIRES' => ($poll_expire_6.$poll_expire_7.$poll_expire_8),
				'TOTAL_VOTES' => $total_votes_2)
			);
		}
		else
		{
			$template->set_filenames(array(
				'pollbox' => 'viewtopic_poll_ballot.tpl')
			);
			if ( $max_vote > 1 )
			{
				$vote_box = 'checkbox';
			}
			else 	$vote_box = 'radio';			

			for($i = 0; $i < $vote_options; $i++)
			{
				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}

				$template->assign_block_vars("poll_option", array(
					'POLL_VOTE_BOX' => $vote_box,				
					'POLL_OPTION_ID' => $vote_info[$i]['vote_option_id'],
					'POLL_OPTION_CAPTION' => $vote_info[$i]['vote_option_text'])
				);
			}

			$template->assign_vars(array(
				'L_SUBMIT_VOTE' => $lang['Submit_vote'],
				'L_VIEW_RESULTS' => $lang['View_results'],

				'U_VIEW_RESULTS' => append_sid("viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;postdays=$post_days&amp;postorder=$post_order&amp;vote=viewresult"))
			);

			$s_hidden_fields = '<input type="hidden" name="topic_id" value="' . $topic_id . '" /><input type="hidden" name="mode" value="vote" />';
		}
				if ( ( $max_vote > 1 ) && ( $max_vote < $vote_options ) )
				{
					$vote_br = '<br/>';
					$max_vote_nb = $max_vote;
				}
				else
				{
					$vote_br = '';
					$lang['Max_voting_1_explain'] = '';
					$lang['Max_voting_2_explain'] = '';
					$lang['Max_voting_3_explain'] = '';
					$max_vote_nb = '';
				}		

		if ( count($orig_word) )
		{
			$vote_title = preg_replace($orig_word, $replacement_word, $vote_title);
		}

		$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		$template->assign_vars(array(
			'POLL_QUESTION' => $vote_title,
			'POLL_VOTE_BR' => $vote_br,
			'MAX_VOTING_1_EXPLAIN' => $lang['Max_voting_1_explain'],
			'MAX_VOTING_2_EXPLAIN' => $lang['Max_voting_2_explain'],
			'MAX_VOTING_3_EXPLAIN' => $lang['Max_voting_3_explain'],
			'max_vote' => $max_vote_nb,
			'voted_vote' => $voted_vote_nb,			

			'S_HIDDEN_FIELDS' => $s_hidden_fields,
			'S_POLL_ACTION' => append_sid("posting.$phpEx?mode=vote&amp;" . POST_TOPIC_URL . "=$topic_id"))
		);

		$template->assign_var_from_handle('POLL_DISPLAY', 'pollbox');
	}
}

init_display_post_attachments($forum_topic_data['topic_attachment']);

//
// Update the topic view counter
//
if (mt_rand(1, 3) == 1)
{
	$sql = "UPDATE " . TOPICS_TABLE . "
		SET topic_views = topic_views + 3
		WHERE topic_id = $topic_id";
	if ( !$db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Could not update topic views.", '', __LINE__, __FILE__, $sql);
	}
}

#==== Get all adr info OUTSIDE the looping array, so it doesn't keep adding up SQL's. We can use the
#==== info from the array later in the loop below. I'm gonna add my name for faster finding later.
$adr_topic_info_char 	= adr_get_posters_char_info();
$adr_topic_info_race 	= adr_get_posters_races_info();
$adr_topic_info_elem 	= adr_get_posters_elements_info();
$adr_topic_info_clas 	= adr_get_posters_class_info();
$adr_topic_info_alig 	= adr_get_posters_alignment_info();
$adr_topic_info_pvp		= adr_get_posters_pvp_info();
$adr_topic_info_adr		= adr_get_posters_adr_info();
#==== Added By aUsTiN

//
// Okay, let's do the loop, yeah come on baby let's do the loop
// and it goes like this ...
//
//-- mod : topics enhanced -----------------------------------------------------
//-- topics nav buttons
$num_row = 0;
//-- fin mod : topics enhanced -------------------------------------------------
for($i = 0; $i < $total_posts; $i++)
{
	$post_number = $i+$start;
	$post_number = $post_number+1;
	$post_id = $postrow[$i]['post_id'];
//-- mod : topics enhanced -----------------------------------------------------
//-- topics nav buttons
	$num_row++;

	$nav_buttons = (empty($i)) ? '<a href="' . append_sid('viewtopic.' . $phpEx . '?' . POST_TOPIC_URL . '=' . $topic_id . '&amp;view=previous') . '"><img alt="" src="' . $images['nav_prev'] . '" title="' . $lang['View_previous_topic'] . '" border="0" /></a>' : '';
	$nav_buttons .= (($i == $total_posts - 1) && $total_posts != 1) ? '<a href="#top"><img alt="" src="' . $images['nav_top'] . '" title="' . $lang['Back_to_top'] . '" border="0" /></a>' : '';
	$nav_buttons .= (!empty($i)) ? '<a href="#' . ($num_row - 1) . '"><img alt="" src="' . $images['nav_prev_post'] . '" title="' . $lang['View_previous_post'] . '" border="0" /></a>' : '';
	$nav_buttons .= ($i != $total_posts - 1) ? '<a href="#' . ($num_row + 1) . '"><img alt="" src="' . $images['nav_next_post'] . '" title="' . $lang['View_next_post'] . '" border="0" /></a>' : '';
	$nav_buttons .= (empty($i)) ? '<a href="#bot"><img alt="" src="' . $images['nav_bot'] . '" title="' . $lang['Go_to_bottom'] . '" border="0" /></a>' : '';
	$nav_buttons .= (empty($i)) ? '<a href="' . append_sid('viewtopic.' . $phpEx . '?' . POST_TOPIC_URL . '=' . $topic_id . '&amp;view=next') . '"><img alt="" src="' . $images['nav_next'] . '" title="' . $lang['View_next_topic'] . '" border="0" /></a>' : '';
//-- fin mod : topics enhanced -------------------------------------------------
	$poster_id = $postrow[$i]['user_id'];
	$poster = ( $poster_id == ANONYMOUS ) ? $lang['Guest'] : $postrow[$i]['username'];
//-- mod : flags ---------------------------------------------------------------
	$poster_flag = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $postrow[$i]['user_flag'] : '';
//-- fin mod : flags -----------------------------------------------------------	
//-- mod : birthday ------------------------------------------------------------
	$poster_birthday = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $postrow[$i]['user_birthday'] : '';
	$poster_zodiac = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $postrow[$i]['user_zodiac'] : '';
//-- fin mod : birthday --------------------------------------------------------	

	$post_date = create_date2($board_config['default_dateformat'], $postrow[$i]['post_created'], $board_config['board_timezone']);

   // DEBUT MOD Postographie d'un membre depuis viewtopic 
   // Delete
   // $poster_posts = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Posts'] . ': ' . $postrow[$i]['user_posts'] : ''; 
   $poster_posts = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Posts'] . ' : <a href="' . append_sid("search.$phpEx?user_id" . "=" . $poster_id) . '" title="' . sprintf($lang['Search_user_posts'], $poster) . '" class="gensmall">' . $postrow[$i]['user_posts'] . '</a>': ''; 
   // FIN MOD Postographie d'un membre depuis viewtopic

	$poster_from = ( $postrow[$i]['user_from'] && $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Location'] . ': ' . $postrow[$i]['user_from'] : '';

	$poster_joined = ( $postrow[$i]['user_id'] != ANONYMOUS ) ? $lang['Joined'] . ': ' . create_date($lang['DATE_FORMAT'], $postrow[$i]['user_regdate'], $board_config['board_timezone']) : '';
		
	$poster_avatar = '';
	if ( $postrow[$i]['user_avatar_type'] && $poster_id != ANONYMOUS && $postrow[$i]['user_allowavatar'] )
	{
		switch( $postrow[$i]['user_avatar_type'] )
		{
			case USER_AVATAR_UPLOAD:
				$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img onload="rmwa_img_loaded(this,' .  $board_config['avatar_max_width'] . ',' .  $board_config['avatar_max_height'] . ')"' . ' src="' . $board_config['avatar_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_REMOTE:
				$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img onload="rmwa_img_loaded(this,' .  $board_config['avatar_max_width'] . ',' .  $board_config['avatar_max_height'] . ')"' . ' src="' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_GALLERY:
				$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img onload="rmwa_img_loaded(this,' .  $board_config['avatar_max_width'] . ',' .  $board_config['avatar_max_height'] . ')"' . ' src="' . $board_config['avatar_gallery_path'] . '/' . $postrow[$i]['user_avatar'] . '" alt="" border="0" />' : '';
				break;
		}
	}
	// Default avatar MOD, By Manipe (Begin)
	default_avatar($postrow[$i], $poster_avatar);
	// Default avatar MOD, By Manipe (End)	

	//
	//START MOD Keep_Unread_2 * Define the little post icon
	//
	if ( $postrow[$i]['post_time'] > $topic_last_read )
	{
		$mini_post_img = $images['icon_minipost_new'];
		$mini_post_alt = $lang['New_post'];
	}
	else
	{
		$mini_post_img = $images['icon_minipost'];
		$mini_post_alt = $lang['Post'];
	}
	//END MOD Keep_unread_2

	$mini_post_url = append_sid("viewtopic.$phpEx?" . POST_POST_URL . '=' . $postrow[$i]['post_id']) . '#' . $postrow[$i]['post_id'];

	//
	// Generate ranks, set them to empty string initially.
	//
	$poster_rank = '';
	$rank_image = '';
	$rank_tags = '';
	// Start add - Gender MOD
	$gender_image = ''; 
	// End add - Gender MOD	
	if ( $postrow[$i]['user_id'] == ANONYMOUS )
	{
	}
	else if ( $postrow[$i]['user_rank'] )
	{
		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $postrow[$i]['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
			{
				$rank_tags = ($ranksrow[$j]['rank_tags']) ? explode("\n", $ranksrow[$j]['rank_tags']) : '';
				$poster_rank = $ranksrow[$j]['rank_title'];
				$poster_rank = ( sizeof ( $rank_tags ) ) ? $rank_tags[0] . $poster_rank . $rank_tags[1] : $poster_rank;
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
	}
	else
	{
		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $postrow[$i]['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] )
			{
				$rank_tags = ($ranksrow[$j]['rank_tags']) ? explode("\n", $ranksrow[$j]['rank_tags']) : '';
				$poster_rank = $ranksrow[$j]['rank_title'];
				$poster_rank = ( sizeof ( $rank_tags ) ) ? $rank_tags[0] . $poster_rank . $rank_tags[1] : $poster_rank;
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
	}

	//
	// Handle anon users posting with usernames
	//
	if ( $poster_id == ANONYMOUS && $postrow[$i]['post_username'] != '' )
	{
		$poster = $postrow[$i]['post_username'];
		$poster_rank = $lang['Guest'];
	}

	$temp_url = '';

	if ( $poster_id != ANONYMOUS )
	{
//-- mod : rank color system ---------------------------------------------------
/*-MOD
		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
MOD-*/
		$temp_url = $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $poster_id), true);
//-- fin mod : rank color system -----------------------------------------------
		$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
		$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';

		$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
		$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
		// Start add - Gender MOD
		switch ($postrow[$i]['user_gender']) 
		{ 
			case 1 : $gender_image = $lang['Gender']." : <img src=\"" . $images['icon_minigender_male'] . "\" alt=\"" . $lang['Gender'].  ":".$lang['Male']."\" title=\"" . $lang['Gender'] . " : ".$lang['Male']. "\" border=\"0\" />"; break; 
			case 2 : $gender_image = $lang['Gender']." : <img src=\"" . $images['icon_minigender_female'] . "\" alt=\"" . $lang['Gender']. ":".$lang['Female']. "\" title=\"" . $lang['Gender'] . " : ".$lang['Female']. "\" border=\"0\" />"; break; 
			default : $gender_image=""; 
		}
		// End add - Gender MOD		
		$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

		if ( !empty($postrow[$i]['user_viewemail']) || $is_auth['auth_mod'] )
		{
			$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $postrow[$i]['user_email'];

			$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
			$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
		}
		else
		{
			$email_img = '';
			$email = '';
		}

		$www_img = ( $postrow[$i]['user_website'] ) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
		$www = ( $postrow[$i]['user_website'] ) ? '<a href="' . $postrow[$i]['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';

		if ( !empty($postrow[$i]['user_icq']) )
		{
			$icq_status_img = '<a href="http://wwp.icq.com/' . $postrow[$i]['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $postrow[$i]['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
			$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
			$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $postrow[$i]['user_icq'] . '">' . $lang['ICQ'] . '</a>';
		}
		else
		{
			$icq_status_img = '';
			$icq_img = '';
			$icq = '';
		}

		$aim_img = ( $postrow[$i]['user_aim'] ) ? '<a href="aim:goim?screenname=' . $postrow[$i]['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '';
		$aim = ( $postrow[$i]['user_aim'] ) ? '<a href="aim:goim?screenname=' . $postrow[$i]['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '';

//-- mod : rank color system ---------------------------------------------------
/*-MOD
		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
MOD-*/
		$temp_url = $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $poster_id), true);
//-- fin mod : rank color system -----------------------------------------------
		$msn_img = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
		$msn = ( $postrow[$i]['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

		$yim_img = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
		$yim = ( $postrow[$i]['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $postrow[$i]['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';

		$temp_url = append_sid("profile.$phpEx?mode=miniprofile&amp;" . POST_USERS_URL . "=$poster_id");

		$mini_profile_img = '<a href="#" class="ajax_tooltip" data-url="' . $temp_url . '" onclick="window.open(\'' . $temp_url . '\',\'\',\'width=470,height=250,scrollbars=yes\');return(false)"><img src="' . $images['icon_mini_profile'] . '" alt="' . $lang['Read_mini_profile'] . '" title="' . $lang['Read_mini_profile'] . '" border="0" /></a>';
		$mini_profile = '<a href="#" class="ajax_tooltip" data-url="' . $temp_url . '" onclick="window.open(\'' . $temp_url . '\',\'\',\'width=470,height=250,scrollbars=yes\');return(false)">' . $lang['Read_mini_profile'] . '</a>';
	}
	else
	{
		$profile_img = '';
		$profile = '';
		$pm_img = '';
		$pm = '';
		$email_img = '';
		$email = '';
		$www_img = '';
		$www = '';
		$icq_status_img = '';
		$icq_img = '';
		$icq = '';
		$aim_img = '';
		$aim = '';
		$msn_img = '';
		$msn = '';
		$yim_img = '';
		$yim = '';
		$mini_profile_img = '';
		$mini_profile = '';
	}

	$temp_url = append_sid("posting.$phpEx?mode=quote&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id']);
	$quote_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_quote'] . '" alt="' . $lang['Reply_with_quote'] . '" title="' . $lang['Reply_with_quote'] . '" border="0" /></a>';
	$quote = '<a href="' . $temp_url . '">' . $lang['Reply_with_quote'] . '</a>';
//-- mod : quick post es -------------------------------------------------------
//-- add
	$qp_quote_img = (!empty($qp_form) && empty($qp_lite)) ? '&nbsp;<img alt="' . $lang['Reply_with_quote'] . '" src="' . $images['qp_quote'] . '" title="' . $lang['Reply_with_quote'] . '" onmousedown="addquote(' . $postrow[$i]['post_id'] . ', \'' . str_replace('\'', '\\\'', (($poster_id == ANONYMOUS) ? (($postrow[$i]['post_username'] != '') ? $postrow[$i]['post_username'] : $lang['Guest']) : $postrow[$i]['username'])) . '\')" style="cursor:pointer;" border="0" />' : '';
//-- fin mod : quick post es ---------------------------------------------------

	$temp_url = append_sid("search.$phpEx?search_author=" . urlencode($postrow[$i]['username']) . "&amp;showresults=posts");
	$search_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_search'] . '" alt="' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '" title="' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '" border="0" /></a>';
	$search = '<a href="' . $temp_url . '">' . sprintf($lang['Search_user_posts'], $postrow[$i]['username']) . '</a>';
	//START MOD Keep_Unread_2
	$temp_url = append_sid("viewtopic.$phpEx?mode=unread&amp;" . POST_POST_URL . '=' . $postrow[$i]['post_id']);
	//$keep_unread_img_ms = '<a class="postmenu" onclick="this.blur();" href="' . $temp_url . '" title = "' . $lang['keep_post_unread_explain'] . '">' . $lang['keep_post_unread'] . '</a>';
	$keep_unread_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_keep_unread'] . '" title = "' . $lang['keep_post_unread_explain'] . '" border="0" /></a>';	

	if ( ( $userdata['user_id'] == $poster_id && $is_auth['auth_edit'] ) || $is_auth['auth_mod'] )
	{
		$temp_url = append_sid("posting.$phpEx?mode=editpost&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id']);
		$edit_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_edit'] . '" alt="' . $lang['Edit_delete_post'] . '" title="' . $lang['Edit_delete_post'] . '" border="0" /></a>';
		$edit = '<a href="' . $temp_url . '">' . $lang['Edit_delete_post'] . '</a>';
	}
	else
	{
		$edit_img = '';
		$edit = '';
	}

	if ( $is_auth['auth_mod'] )
	{
		$temp_url = "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata['session_id'];
		$ip_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_ip'] . '" alt="' . $lang['View_IP'] . '" title="' . $lang['View_IP'] . '" border="0" /></a>';
		$ip = '<a href="' . $temp_url . '">' . $lang['View_IP'] . '</a>';

		$temp_url = "posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;sid=" . $userdata['session_id'];
		$delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>';
		$delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
	}
	else
	{
		$ip_img = '';
		$ip = '';

		if ( $userdata['user_id'] == $poster_id && $is_auth['auth_delete'] && $forum_topic_data['topic_last_post_id'] == $postrow[$i]['post_id'] )
		{
			$temp_url = "posting.$phpEx?mode=delete&amp;" . POST_POST_URL . "=" . $postrow[$i]['post_id'] . "&amp;sid=" . $userdata['session_id'];
			$delpost_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_delpost'] . '" alt="' . $lang['Delete_post'] . '" title="' . $lang['Delete_post'] . '" border="0" /></a>';
			$delpost = '<a href="' . $temp_url . '">' . $lang['Delete_post'] . '</a>';
		}
		else
		{
			$delpost_img = '';
			$delpost = '';
		}
	}
	if($poster_id != ANONYMOUS && $postrow[$i]['user_level'] != ADMIN) 
{ 
	$current_user = str_replace("'","\'",$postrow[$i]['username']);
	if ($is_auth['auth_greencard']) 
	{ 
	      $g_card_img = ' <input type="image" name="unban" value="unban" onClick="return confirm(\''.sprintf($lang['Green_card_warning'],$current_user).'\')" src="'. $images['icon_g_card'] . '" alt="' . $lang['Give_G_card'] . '" >'; 
	} 
	else 
	{
		$g_card_img = ''; 
	}
	$user_warnings = $postrow[$i]['user_warnings'];
	$card_img = ($user_warnings) ? (( $user_warnings < $board_config['max_user_bancard']) ? sprintf($lang['Warnings'], $user_warnings) : $lang['Banned'] ) : '';
// these lines will make a icon apear beside users post, if user have warnings or ar banned
// used instead of the previous line of code, witch shows the status as a text
//  ------ From here --- do not include this line
// $card_img = ($user_warnings) ? '<img src="'.(( $user_warnings < $board_config['max_user_bancard']) ? 
//		$images['icon_y_card'] . '" alt="'. sprintf($lang['Warnings'], $user_warnings) .'">' : 
//		$images['icon_r_card'] . '" alt="'. $lang['Banned'] .'">') : '';
//  ----- To this line --- Do not included this line
// 
// You may also included several images, instead of only one yellow, these lines below will produce several yellow images, depending on mumber of yellow cards
//  ------ From here --- do not include this line
$card_img = ($user_warnings >= $board_config['max_user_bancard'])  ? '<img src="'.$images['icon_r_card'] . '" alt="'. $lang['Banned'] .'">' : '';
for ($n=0 ; $n<$user_warnings && $user_warnings < $board_config['max_user_bancard'];$n++)
{
$card_img .= ($user_warnings) ? '<img src="'.(( $user_warnings < $board_config['max_user_bancard']) ? 
$images['icon_y_card'] . '" alt="'. sprintf($lang['Warnings'], $user_warnings) .'">' : 
$images['icon_r_card'] . '" alt="'. $lang['Banned'] .'">') : '';
}
//  ----- To this line --- Do not included this line

	if ($user_warnings<$board_config['max_user_bancard'] && $is_auth['auth_ban'] )
	{ 
		$y_card_img = ' <input type="image" name="warn" value="warn" onClick="return confirm(\''.sprintf($lang['Yellow_card_warning'],$current_user).'\')" src="'. $images['icon_y_card'] . '" alt="' . sprintf($lang['Give_Y_card'],$user_warnings+1) . '" >'; 
     		$r_card_img = ' <input type="image" name="ban" value="ban"  onClick="return confirm(\''.sprintf($lang['Red_card_warning'],$current_user).'\')" src="'. $images['icon_r_card'] . '" alt="' . $lang['Give_R_card'] . '" >'; 
	}
	else
	{
		$y_card_img = '';
		$r_card_img = ''; 
	} 
} else
{
	$card_img = '';
	$g_card_img = '';
	$y_card_img = '';
	$r_card_img = '';
}

	if ($is_auth['auth_bluecard']) 
	{ 
		if ($is_auth['auth_mod']) 
		{ 
			$b_card_img = (($postrow[$i]['post_bluecard'])) ? ' <input type="image" name="report_reset" value="report_reset" onClick="return confirm(\''.$lang['Clear_blue_card_warning'].'\')" src="'. $images['icon_bhot_card'] . '" alt="'. sprintf($lang['Clear_b_card'],$postrow[$i]['post_bluecard']) . '">':' <input type="image" name="report" value="report" onClick="return confirm(\''.$lang['Blue_card_warning'].'\')" src="'. $images['icon_b_card'] . '" alt="'. $lang['Give_b_card'] . '" >'; 
		} 
   		else 
		{ 
			$b_card_img = ' <input type="image" name="report" value="report" onClick="return confirm(\''.$lang['Blue_card_warning'].'\')" src="'. $images['icon_b_card'] . '" alt="'. $lang['Give_b_card'] . '" >';
			
   		}
	} else $b_card_img = '';

// parse hidden filds if cards visible
$card_hidden = ($g_card_img || $r_card_img || $y_card_img || $b_card_img) ? '<input type="hidden" name="post_id" value="'. $postrow[$i]['post_id'].'">' :'';

	$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : '';
//-- mod : post description ----------------------------------------------------
//-- add
	$post_sub_title = !empty($postrow[$i]['post_sub_title']) ? ( count($orig_word) ? preg_replace($orig_word, $replacement_word, $postrow[$i]['post_sub_title']) : $postrow[$i]['post_sub_title'] ) : '';
//-- fin mod : post description ------------------------------------------------	
//-- mod : quick title edition -------------------------------------------------
//-- add
	if ( !$i )
	{
		$qte->attr($post_subject, $postrow[$i]['topic_attribute']);
	}
//-- fin mod : quick title edition ---------------------------------------------
	$message = $postrow[$i]['post_text'];
	$bbcode_uid = $postrow[$i]['bbcode_uid'];

	$user_sig = ( $postrow[$i]['enable_sig'] && $postrow[$i]['user_sig'] != '' && $board_config['allow_sig'] && !$signature[$poster_id] ) ? $postrow[$i]['user_sig'] : '';
	$user_sig_bbcode_uid = $postrow[$i]['user_sig_bbcode_uid'];
	#==== Removed By aUsTiN
	#$adr_topic_box = adr_display_poster_infos($postrow[$i]['user_id'], $userdata['user_id']);
	if(($postrow[$i]['user_id'] != ANONYMOUS) && ($postrow[$i]['user_adr_ban'] != '1'))
		$adr_topic_box = adr_display_poster_infos($postrow[$i]['user_id'], $adr_topic_info_char, $adr_topic_info_race, $adr_topic_info_elem, $adr_topic_info_clas, $adr_topic_info_alig, $adr_topic_info_pvp, $adr_topic_info_adr, $adr_topic_info_jobs, $postrow[$i]['user_cell_time']);
	#==== Added By aUsTiN
	$rabbitoshi_link = append_sid("rabbitoshi.$phpEx?" . POST_USERS_URL . "=" . $postrow[$i]['user_id']);
	if ($poster_id != ANONYMOUS)
	{
		$user_points = ($userdata['user_level'] == ADMIN || user_is_authed($userdata['user_id'])) ? '<a href="' . append_sid("pointscp.$phpEx?" . POST_USERS_URL . "=" . $postrow[$i]['user_id']) . '" class="gensmall" title="' . sprintf($lang['Points_link_title'], $board_config['points_name']) . '">' . $board_config['points_name'] . '</a>' : $board_config['points_name'];
		$user_points = '<br />' . $user_points . ' : ' . $postrow[$i]['user_points'];

		if ($board_config['points_donate'] && $userdata['user_id'] != ANONYMOUS && $userdata['user_id'] != $poster_id)
		{
			$donate_points = '<br />' . sprintf($lang['Points_donate'], '<a href="' . append_sid("pointscp.$phpEx?mode=donate&amp;" . POST_USERS_URL . "=" . $postrow[$i]['user_id']) . '" class="gensmall" title="' . sprintf($lang['Points_link_title_2'], $board_config['points_name']) . '">', '</a>');
		}
		else
		{
			$donate_points = '';
		}
	}
	else
	{
		$user_points = '';
		$donate_points = '';
	}	

	//
	// Note! The order used for parsing the message _is_ important, moving things around could break any
	// output
	//

	//
	// If the board has HTML off but the post has HTML
	// on then we process it, else leave it alone
	//
	if ( !$board_config['allow_html'] || !$userdata['user_allowhtml'])
	{
		if ( $user_sig != '' )
		{
			$user_sig = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $user_sig);
		}

		if ( $postrow[$i]['enable_html'] )
		{
			$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
		}
	}

	//
	// Parse message and/or sig for BBCode if reqd
	//
	if ($user_sig != '' && $user_sig_bbcode_uid != '')
	{
		$user_sig = ($board_config['allow_bbcode']) ? bbencode_second_pass($user_sig, $user_sig_bbcode_uid) : preg_replace("/\:$user_sig_bbcode_uid/si", '', $user_sig);
//-- mod : addon hide for bbcbxr -----------------------------------------------
//-- add
		$user_sig = bbencode_third_pass($user_sig, $user_sig_bbcode_uid, $valid);
//-- fin mod : addon hide for bbcbxr -------------------------------------------
	}

	if ($bbcode_uid != '')
	{
		$message = ($board_config['allow_bbcode']) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $message);
//-- mod : addon hide for bbcbxr -----------------------------------------------
//-- add
		$message = bbencode_third_pass($message, $bbcode_uid, $valid);
//-- fin mod : addon hide for bbcbxr -------------------------------------------
	}

	if ( $user_sig != '' )
	{
		$user_sig = make_clickable($user_sig);
	}
	$message = make_clickable($message);

	//
	// Parse smilies
	//
	if ( $board_config['allow_smilies'] )
	{
		if ( $postrow[$i]['user_allowsmile'] && $user_sig != '' )
		{
			$user_sig = smilies_pass($user_sig);
		}

		if ( $postrow[$i]['enable_smilies'] )
		{
			$message = smilies_pass($message);
		}
	}

	//
	// Highlight active words (primarily for search)
	//
	if ($highlight_match)
	{
		// This has been back-ported from 3.0 CVS
		$message = preg_replace('#(?!<.*)(?<!\w)(' . $highlight_match . ')(?!\w|[^<>]*>)#i', '<b style="color:#'.$theme['fontcolor3'].'">\1</b>', $message);
	}
	$sql = "SELECT word, replacement
		FROM  " . QUICKLINKS_TABLE;
	if( !($result = $db->sql_query($sql, false, true)) )
	{
		message_die(GENERAL_ERROR, 'Could not get quicklinks from database', '', __LINE__, __FILE__, $sql);
	}
	
	if ( $row = $db->sql_fetchrow($result) )
	{
		do 
		{
			$quicklink_word[] = '#\b(' . $row['word'] . ')\s#i';
			$quicklink_url[] = '<a href="' . $row['replacement'] . '" class="postlink">' . $row['word'] . '</a> ';
			$quicklink_word[] = '#\s(' . $row['word'] . ')\b#i';
			$quicklink_url[] = ' <a href="' . $row['replacement'] . '" class="postlink">' . $row['word'] . '</a>';
		}
		while ( $row = $db->sql_fetchrow($result) );
	}
	if (count($quicklink_word)) {
		$message = str_replace('\"', '"', substr(preg_replace('#(\µ(((?>([^µ§]+|(?R)))*)\§))#se', "preg_replace(\$quicklink_word, \$quicklink_url, '\\0')", 'µ' . $message . '§'), 1, -1));
	}	

	//
	// Replace naughty words
	//
	if (count($orig_word))
	{
		$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);

		if ($user_sig != '')
		{
			$user_sig = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $user_sig . '<'), 1, -1));
		}

		$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $message . '<'), 1, -1));
	}

	//
	// Replace newlines (we use this rather than nl2br because
	// till recently it wasn't XHTML compliant)
	//
	if ( $user_sig != '' )
	{
		$user_sig = '<br />_________________<br />' . str_replace("\n", "\n<br />\n", $user_sig);
		$signature[$poster_id] = 1; 		
	}

	$message = str_replace("\n", "\n<br />\n", $message);
	if ( $board_config['allow_colortext'] )
	{
		if ( $postrow[$i]['user_colortext'] != '' )
		{
			$message = '<font color="' . $postrow[$i]['user_colortext'] . '">' . $message . '</font>';
		}
	}	

	//
	// Editing information
	//
	if ( $postrow[$i]['post_edit_count'] )
	{
		$l_edit_time_total = ( $postrow[$i]['post_edit_count'] == 1 ) ? $lang['Edited_time_total'] : $lang['Edited_times_total'];

		$l_edited_by = '<br /><br />' . sprintf($l_edit_time_total, $poster, create_date($board_config['default_dateformat'], $postrow[$i]['post_edit_time'], $board_config['board_timezone']), $postrow[$i]['post_edit_count']);
	}
	else
	{
		$l_edited_by = '';
	}

	//
	// Again this will be handled by the templating
	// code at some point
	//
	$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
	$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	$adr_topic_box = ($postrow[$i]['user_id'] != '-1') ? $adr_topic_box : '';
    // Mod PageRank par SP 
    $PageRank = str_replace('http://','',$postrow[$i]['user_website']); 
    $PageRank = ($postrow[$i]['user_website'] != '') ? '<a href="http://www.pagerank.fr/rapport-indexation.fr.html?uri='.$PageRank.'" target="_blank" title="'.$poster.'"><img src="http://www.pagerank.fr/pagerank-actuel.gif?uri='.$PageRank.'" title="'.$poster.'" border="0"></a>':'';	

// Start add - Direct user link MOD
	switch ($postrow[$i]['user_level'])
	{
		case ADMIN:
		    $poster = "<b>$poster</b>"; 
      		$poster_style_color = 'style="color:#' . $theme['fontcolor3'] . '"';
			break;
		case MOD:
		    $poster = "<b>$poster</b>"; 
      		$poster_style_color = 'style="color:#' . $theme['fontcolor2'] . '"';
			break;
		default:
			$poster_style_color = '';
	}
// End add - Direct user link MOD
//Online/Offline
	if (($postrow[$i]['user_session_time'] >= ( time() - 300 )) && ($postrow[$i]['user_allow_viewonline']))
	{
		$on_off_hidden = '<img src="' . $images['icon_online'] . '" alt="' . $lang['Online'] . '" title="' . $lang['Online'] . '" border="0" />';
	}
	else if (($postrow[$i]['user_allow_viewonline']) == 0)
	{
		$on_off_hidden = '<img src="' . $images['icon_hidden'] . '" alt="' . $lang['Hidden'] . '" title="' . $lang['Hidden'] . '" border="0" />';
	}
	else if ($poster_id == ANONYMOUS)
	{
		$on_off_hidden = '';
	}
	else
	{
		$on_off_hidden = '<img src="' . $images['icon_offline'] . '" alt="' . $lang['Offline'] . '" title="' . $lang['Offline'] . '" border="0" />';
	}
//Online/Offline
	// Start Smilies Invasion Mod
  if ( $board_config['allow_smilies'] )
  {
    $post_subject = smilies_pass($post_subject);
  }
  // End Smilies Invasion Mod
  	$message = AddClicksCounter($message);  
	$template->assign_block_vars('postrow', array(
		'ROW_COLOR' => '#' . $row_color,
		'ROW_CLASS' => $row_class,
		'ADR_TOPIC_BOX' => $adr_topic_box, 
		'RABBITOSHI_LINK' => $rabbitoshi_link,
//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
		'POSTER_NAME' => $poster,
MOD-*/
		'POSTER_NAME' => ($poster_id == ANONYMOUS) ? (($postrow[$i]['post_username'] != '') ? $postrow[$i]['post_username'] : $lang['Guest']) : $rcs->get_colors($postrow[$i], $postrow[$i]['username']),
//-- fin mod : rank color system -----------------------------------------------
		'PAGERANK' => $PageRank,
		'POSTER_RANK' => $poster_rank,
// Start add - Gender MOD
'POSTER_GENDER' => $gender_image,
// End add - Gender MOD		
		'RANK_IMAGE' => $rank_image,
		'POSTER_JOINED' => $poster_joined,
		'POSTER_POSTS' => $poster_posts,
		'POSTER_FROM' => $poster_from,
		'POSTER_AVATAR' => $poster_avatar,
		'POSTER_ONLINE' => $on_off_hidden,
		'POST_DATE' => $post_date,
		'POST_SUBJECT' => $post_subject,
		'MESSAGE' => $message,
		'POST_NUMBER' => $post_number,
		'POST_ID' => $post_id,
		'SIGNATURE' => $user_sig,
		'EDITED_MESSAGE' => $l_edited_by,
//-- mod : topics enhanced -----------------------------------------------------
//-- add
//-- topics nav buttons		
		'S_NUM_ROW' => $num_row,
		'S_NAV_BUTTONS' => $nav_buttons,
//-- minitime
		'I_MINITIME' => $images['icon_minitime'],
//-- fin mod : topics enhanced -------------------------------------------------		

		'MINI_POST_IMG' => $mini_post_img,
		'PROFILE_IMG' => $profile_img,
		'PROFILE' => $profile,
		'MINI_PROFILE_IMG' => $mini_profile_img,
		'MINI_PROFILE' => $mini_profile,
		'SEARCH_IMG' => $search_img,
		'SEARCH' => $search,
		'PM_IMG' => $pm_img,
		'PM' => $pm,
		'EMAIL_IMG' => $email_img,
		'EMAIL' => $email,
		'WWW_IMG' => $www_img,
		'WWW' => $www,
		'ICQ_STATUS_IMG' => $icq_status_img,
		'ICQ_IMG' => $icq_img,
		'ICQ' => $icq,
		'AIM_IMG' => $aim_img,
		'AIM' => $aim,
		'MSN_IMG' => $msn_img,
		'MSN' => $msn,
		'YIM_IMG' => $yim_img,
		'YIM' => $yim,
		'EDIT_IMG' => $edit_img,
		'EDIT' => $edit,
		'QUOTE_IMG' => $quote_img,
		'QUOTE' => $quote,
		'IP_IMG' => $ip_img,
		'IP' => $ip,
		'DELETE_IMG' => $delpost_img,
		'DELETE' => $delpost,
		//-- mod : quick post es -------------------------------------------------------
		//-- add
		'I_QP_QUOTE' => $qp_quote_img,
		//-- fin mod : quick post es ---------------------------------------------------		
		// Start add - Gender MOD
		'L_GENDER' => $lang['Gender'],
		// End add - Gender MOD		
		'POINTS' => $user_points,
		'DONATE_POINTS' => $donate_points,		
		'USER_WARNINGS' => $user_warnings,
		'CARD_IMG' => $card_img,
		'CARD_HIDDEN_FIELDS' => $card_hidden,
		'CARD_EXTRA_SPACE' => ($r_card_img || $y_card_img || $g_card_img || $b_card_img) ? ' ' : '',
		'L_MINI_POST_ALT' => $mini_post_alt,
	 	//MOD Keep_Unread_2
	 	'KEEP_UNREAD_IMG' => $keep_unread_img,
	 	//'KEEP_UNREAD_IMG_MS' => $keep_unread_img_ms,		
		'L_POST' => $lang['Post'],
		'U_MINI_POST' => $mini_post_url,
		'U_G_CARD' => $g_card_img, 
		'U_Y_CARD' => $y_card_img, 
		'U_R_CARD' => $r_card_img, 
		'U_B_CARD' => $b_card_img,
		'S_CARD' => append_sid("card.".$phpEx),
// Start add - Direct user link MOD
		'U_VIEW_POSTER_PROFILE' => ($userdata['user_level'] != ADMIN)? append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $poster_id) : append_sid("admin/admin_users.$phpEx?mode=edit&amp;" . POST_USERS_URL . "=" . $poster_id . "&amp;sid=" . $userdata['session_id'] ) , 
		'POSTER_STYLE' => $poster_style_color,
// End add - Direct user link MOD		
		'U_POST_ID' => $postrow[$i]['post_id'])
	);
	display_post_attachments($postrow[$i]['post_id'], $postrow[$i]['post_attachment']);

//-- mod : birthday ------------------------------------------------------------
	$birthday->display_details($poster_birthday, $poster_zodiac, false, 'postrow');
//-- mod : flags ---------------------------------------------------------------
	display_flag($poster_flag, false, 'postrow');
//-- mod : post description ----------------------------------------------------
	display_sub_title('postrow', $post_sub_title, $board_config['sub_title_length']);
//-- mod : topics enhanced -----------------------------------------------------
	if ( $i != $total_posts - 1 )
	{
		$template->assign_block_vars('postrow.spacing', array());
	}
}

include($phpbb_root_path . 'includes/functions_related.'.$phpEx);
get_related_topics($topic_id);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);