<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: rss_forum.php 2007/04/12 13:48:48 dcz Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/
// First basic security
if ( !defined('IN_PHPBB') && !defined('IN_PORTAL') ) {
	die('Hacking attempt');
	exit;
}
if (!($this->actions['type'] === 'rss_')) {
	$this->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Request not accepted');
}

// Filter $this->actions['list_id'] var type
$this->actions['list_id'] = intval($this->actions['list_id']);

// Let's do the work
$first_message = $last_message = $topic_forum_sql = '';
// Build unauthed array
$this->set_exclude_list($this->ggsitemaps_config['rss_exclude_forum']);
// Filter forums & build sql components
if ( !empty($this->actions['not_auth']) ) {
	// Merge with the exclude_list array
	foreach ($this->actions['not_auth'] as $f_id => $f_auth) {
		if ( !isset($this->output_data['exclude_list'][$f_id]) ) {
			$this->output_data['exclude_list'][$f_id] = $f_id;
		}
	}
}
// Build sql components
if (!empty($this->output_data['exclude_list'])) {
		// In case there is many, why not helping sql server a bit
		sort($this->output_data['exclude_list']);
		$not_in_id_sql_fid = " (" . implode(",", $this->output_data['exclude_list']) . ") ";
		$not_in_id_sql_ptc = " t.forum_id NOT IN $not_in_id_sql_fid ";
		$not_in_id_sql = " $not_in_id_sql_ptc AND ";
} else {
		$not_in_id_sql = $not_in_id_sql_ptc = $not_in_id_sql = '';
}
if (($this->actions['action'] === 'forum' && $this->actions['cat'] === 'cat')|| ($this->actions['action'] === 'channels')) {
	
	// No SQL cycling in here
	if ($this->actions['action'] != 'channels') {
		// it's the forums rss map, Build URL
		$rss_url = $this->path_config['rss_url'] . (($this->mod_r_config['mod_rewrite']) ? 'forums-rss' . $this->mod_r_config['extra_params'] . '.xml' . $this->ext_config['gzip_ext_out'] : 'rss.'.$phpEx.'?forum&amp;c' . $this->mod_r_config['extra_params']);
		// Kill dupes
		$this->seo_kill_dupes($rss_url);
		
		// Forum stats
		$total_posts = get_db_stat('postcount');
		$total_users = get_db_stat('usercount');
		$l_total_post_s = ( $total_posts >= 0 ) ? $lang['Posted_articles_total'] : $lang['Posted_article_total'];
		$l_total_user_s = ( $total_users >= 0 ) ? $lang['Registered_users_total'] : $lang['Registered_user_total'];
		$forum_stats = sprintf($l_total_user_s, $total_users) . ' || ' . sprintf($l_total_post_s, $total_posts);
		
		// Chan info
		$chan_title = htmlspecialchars($board_config['sitename'] . $this->rss_config['extra_title']);
		$chan_desc = htmlspecialchars($board_config['site_desc'] . '<hr/><br/>' . $forum_stats);
		$board_image = sprintf($this->style_config['rsschan_img_tpl'], $chan_title, $this->rss_config['rss_image'], $this->path_config['phpbb_url']);
		$chan_time = date('D, d M Y H:i:s \G\M\T', $this->output_data['last_mod_time']);
		$this->output_data['data'] .= sprintf($this->style_config['rsschan_tpl'], $chan_title, $this->path_config['phpbb_url'], $chan_desc . $auth_msg, $chan_time, $board_image);
		$this->output_data['data'] .= sprintf($this->style_config['rss_tpl'], htmlspecialchars($board_config['sitename']), $this->path_config['phpbb_url'], $chan_time, $chan_desc, $rss_url, $chan_title, $this->path_config['phpbb_url']);
		$this->output_data['url_sofar']++;
	} else {
		// It's a channel list call, add static channels
		// forum-rss
		$rss_furl = $this->path_config['rss_url'] . (($this->mod_r_config['mod_rewrite']) ? 'forum-rss' . $this->mod_r_config['extra_params'] . '.xml' . $this->ext_config['gzip_ext_out'] : 'rss.'.$phpEx.'?forum' . $this->mod_r_config['extra_params']);
		// Chan info
		$chan_title = htmlspecialchars($board_config['sitename'] . $this->rss_config['extra_title']);
		$chan_desc = htmlspecialchars($board_config['site_desc'] . '<hr/><br/>');
		$this->output_data['data'] .= sprintf($this->style_config['rss_tpl'], $chan_title, $this->path_config['phpbb_url'], $chan_time, $chan_desc, $rss_furl, htmlspecialchars($board_config['sitename']), $this->path_config['phpbb_url']);
		$this->output_data['url_sofar']++;
	}
	$sql = "SELECT t.*, c.cat_title, p.post_time
		FROM " . FORUMS_TABLE . " AS t, " . CATEGORIES_TABLE . " AS c , " . POSTS_TABLE . " AS p 
		WHERE $not_in_id_sql c.cat_id = t.cat_id
			AND p.post_id = t.forum_last_post_id
		ORDER BY t.forum_last_post_id " . $this->rss_config['rss_sort'];
	if ( !($result = $db->sql_query($sql)) ) {
		$this->mx_sitemaps_message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
	}
	while( $forum_data = $db->sql_fetchrow($result) ) {
			$forum_id = $forum_data['forum_id'];
			// Build Chan info
			$forum_stats = $lang['rss_item_stats'] . $forum_data['forum_topics'] . ' ' . (($forum_data['forum_topics'] >= 0) ? $lang['Topics'] : $lang['Topic'] );
			$forum_stats .= ' || ' . $forum_data['forum_posts'] . ' ' . (($forum_data['forum_posts'] >= 0) ? $lang['Posts'] : $lang['Post'] );
			$item_title = htmlspecialchars($forum_data['forum_name']);
			$item_desc = htmlspecialchars('<div class="item_sub_title">' . $forum_data['cat_title'] . ' :  ' . $forum_data['forum_name'] . ' </div> <hr/>' .  $forum_data['forum_desc'] . ' <hr/><br/> ' . $forum_stats);
			$forum_name_ok =  $phpbb_seo->format_url($forum_data['forum_name'], $phpbb_seo->seo_static['forum']);
			// Build URLs
			$forum_rss_url =   $this->path_config['rss_url'] .  (($this->mod_r_config['forum_pre_rss'] !='') ? $this->mod_r_config['forum_pre_rss'] . $forum_id . $this->mod_r_config['extra_params'] . $this->mod_r_config['ext_out'] : $forum_name_ok . '-rf' .  $forum_id . $this->mod_r_config['extra_params'] . $this->mod_r_config['ext_out']);
			$forum_url = $this->path_config['phpbb_url'] . (($this->mod_r_config['forum_pre'] !='') ? $this->mod_r_config['forum_pre'] . $forum_id : $forum_name_ok . $phpbb_seo->seo_delim['forum'] . $forum_id .  $phpbb_seo->seo_ext['forum']);
			$chan_title = htmlspecialchars($forum_data['forum_name'] . $this->rss_config['extra_title']);
			$chan_time = gmdate('D, d M Y H:i:s \G\M\T', $forum_data['post_time']);
			if ($this->actions['action'] === 'channels') { 
				// We are called for a channel list
				// Set forum Image, do it here in case one want to output a specific image per forum
				$this->output_data['data'] .= sprintf($this->style_config['rss_tpl'], $chan_title, $forum_url, $chan_time, $item_desc, $forum_rss_url, $item_title, $forum_url);
				$this->output_data['url_sofar']++;
			} else {
				// It's a forum rss listing
				$this->output_data['data'] .= sprintf($this->style_config['rss_tpl'], $item_title, $forum_url, $chan_time, $item_desc, $forum_rss_url, $chan_title, $forum_url);
				$this->output_data['url_sofar']++;
			}
	} // End Forum map loop
	$db->sql_freeresult($result);
	unset ($forum_data);
} elseif ($this->actions['action'] != 'channels' && $this->actions['cat'] != 'cat') { 
	// Here we Go for SQL cycling and additional params : msg, long and short
	// Small opt on forums
	$item_opt = array();
	if ($this->actions['action'] === 'forum' && $this->actions['list_id'] > 0 ) {
		// It's a forum sitemap
		// Check forum auth and grab necessary infos			
		$sql = "SELECT f.*, c.cat_title,  p.post_time
			FROM ". FORUMS_TABLE ." AS f, " . CATEGORIES_TABLE . " AS c , " . POSTS_TABLE . " AS p
			WHERE f.forum_id = " . $this->actions['list_id'] . "
				AND c.cat_id = f.cat_id 
				AND p.post_id = f.forum_last_post_id";
		if ( !($result = $db->sql_query($sql)) ) {
			$this->mx_sitemaps_message_die(GENERAL_ERROR, "Could not obtain Forum data", '', __LINE__, __FILE__, $sql);
		}
		$forum_data = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);
		$forum_id = $forum_data['forum_id'];
		// Deal with auth
		if ( empty($forum_data) || (in_array($forum_id, $this->output_data['exclude_list'])) ) {
			$this->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Request not accepted');
		}
		
		// This forum is allowed and has posts, so let's start
		// Build Chan info
		$forum_stats = $lang['rss_item_stats'] . $forum_data['forum_topics'] . ' ' . (($forum_data['forum_topics'] >= 0) ? $lang['Topics'] : $lang['Topic'] );
		$forum_stats .= ' || ' . $forum_data['forum_posts'] . ' ' . (($forum_data['forum_posts'] >= 0) ? $lang['Posts'] : $lang['Post'] );
		$chan_title = htmlspecialchars($forum_data['forum_name'] . $this->rss_config['extra_title']);
		$chan_desc = htmlspecialchars($forum_data['cat_title'] . ' : ' . $forum_data['forum_name'] . ' <hr/> ' .  $forum_data['forum_desc'] . ' <hr/><br/> ' . $forum_stats);
		$item_opt[$forum_id]['forum_name_ok'] =  $phpbb_seo->format_url($forum_data['forum_name'], $phpbb_seo->seo_static['forum']);
		$item_opt[$forum_id]['forum_name'] = $forum_data['forum_name'];
		
		// Build the forum's RSS feed's URL
		// Do it in two steps to allow yahoo Notifications
		$forum_rss_url =   $this->path_config['rss_url'] .  (($this->mod_r_config['forum_pre_rss'] !='') ? $this->mod_r_config['forum_pre_rss'] . $forum_id : $item_opt[$forum_id]['forum_name_ok'] . '-rf' .  $forum_id);
		// Build Yahoo notify URL
		// If the URL is not rewritten, we cannot use "&" and output a long list.
		if ( $this->mod_r_config['mod_rewrite'] && $this->rss_config['allow_long'] && $this->rss_config['yahoo_notify_long']) {
			$this->rss_config['yahoo_notify_url'] = $forum_rss_url . ( ($this->mod_r_config['mod_rewrite'])? "-l" : "&l") . $this->mod_r_config['ext_out'];
		} else {
			$this->rss_config['yahoo_notify_url'] = $forum_rss_url . $this->mod_r_config['ext_out'];
		}
		$forum_rss_url .= $this->mod_r_config['extra_params'] . $this->mod_r_config['ext_out'];
		// Kill dupes
		$this->seo_kill_dupes($forum_rss_url);
		$item_opt[$forum_id]['forum_rss_url'] = $forum_rss_url;
		// Buils forum RSS
		$item_opt[$forum_id]['forum_url'] = $this->path_config['phpbb_url'] . ( ($this->mod_r_config['forum_pre'] !='') ? $this->mod_r_config['forum_pre'] . $forum_id : $item_opt[$forum_id]['forum_name_ok'] . $phpbb_seo->seo_delim['forum'] .  $forum_id . $phpbb_seo->seo_ext['forum'] );
		
		// Set forum Image, do it here in case one want to output a specific image per forum
		$forum_image = sprintf($this->style_config['rsschan_img_tpl'], $chan_title, $this->rss_config['rss_forum_image'], $item_opt[$forum_id]['forum_url']);
		
		// Channel infos formating
		$this->output_data['data'] .= sprintf($this->style_config['rsschan_tpl'], $chan_title, $item_opt[$forum_id]['forum_url'], $chan_desc . ( ($in_not_public) ? $auth_msg : ''), gmdate('D, d M Y H:i:s \G\M\T', $forum_data['post_time']), $forum_image);
		$this->output_data['url_sofar']++;
		// In case the forum called for a feed is really big, apply time limit
		if ( $this->rss_config['limit_time'] > 0 && $this->rss_config['rss_url_limit'] <  $forum_data['forum_topics'] ) {
			$time_limit = ($this->output_data['time'] - $this->rss_config['limit_time']);
			// So let's count topic in this forum
			$sql = "SELECT COUNT(t.topic_id) AS forum_topics
				FROM " . TOPICS_TABLE . " as t, " . POSTS_TABLE . " AS p
				WHERE t.forum_id = $forum_id
					AND p.post_id = t.topic_last_post_id AND p.post_time > $time_limit
					AND topic_status <> " . TOPIC_MOVED;
			if ( !($result = $db->sql_query($sql)) ) {
				$this->mx_sitemaps_message_die(GENERAL_ERROR, 'Could not obtain limited topics count information', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$item_count = ( $row['forum_topics'] ) ? $row['forum_topics'] : 1;
			$db->sql_freeresult($result);
			unset($row);
			// now check if we've got still enough topic to ouptut
			if ( $item_count >= $this->rss_config['rss_url_limit'] ) {
				$topic_forum_sql = " t.forum_id = $forum_id AND  p.post_id = t.topic_last_post_id AND p.post_time > " . $time_limit . " AND ";
			} else { // do not limit in time, the forum is big but not much active
				$topic_forum_sql = "t.forum_id = $forum_id AND ";
			}
		} else { // Trust forum_topics to be acurate enough (no real big deal if it isn't some time)
			$topic_forum_sql = "t.forum_id = $forum_id AND ";
			$item_count = $forum_data['forum_topics'];
		}
		$time_limit_sql = '';
	} else {
		// Is it a general rss feed call or a forum rss feed call
		if ( $this->actions['action'] === 'forum' ) {
			
			//If so check for dupes and build channel header
			$rss_list_url = $this->path_config['rss_url'] . (($this->mod_r_config['mod_rewrite']) ? "forum-rss" . $this->mod_r_config['extra_params'] .".xml" . $this->ext_config['gzip_ext_out'] : 'rss.'.$phpEx . '?forum' . $this->mod_r_config['extra_params']);
			$this->seo_kill_dupes($rss_list_url);
		
			// Forum stats
			$total_posts = get_db_stat('postcount');
			$total_users = get_db_stat('usercount');
			$l_total_post_s = ( $total_posts >= 0 ) ? $lang['Posted_articles_total'] : $lang['Posted_article_total'];
			$l_total_user_s = ( $total_users >= 0 ) ? $lang['Registered_users_total'] : $lang['Registered_user_total'];
			$forum_stats = sprintf($l_total_user_s, $total_users) . ' || ' . sprintf($l_total_post_s, $total_posts);
		
			// Chan info
			$chan_title = htmlspecialchars($board_config['sitename'] . $this->rss_config['extra_title']);
			$chan_desc = htmlspecialchars($board_config['site_desc'] . ' : <hr/><br/> ' . $forum_stats);
			$forum_image = sprintf($this->style_config['rsschan_img_tpl'], $chan_title, $this->rss_config['rss_image'], $this->path_config['phpbb_url']);
			$chan_time = gmdate('D, d M Y H:i:s \G\M\T', $this->output_data['last_mod_time']);
			$this->output_data['data'] .= sprintf($this->style_config['rsschan_tpl'], $chan_title, $this->path_config['phpbb_url'], $chan_desc . $auth_msg, $chan_time, $forum_image);
			$this->output_data['data'] .= sprintf($this->style_config['rss_tpl'], htmlspecialchars($board_config['sitename']), $this->path_config['phpbb_url'], $chan_time, $chan_desc, $rss_list_url, $chan_title, $this->path_config['phpbb_url']);
			$this->output_data['url_sofar']++;
			$this->output_data['url_sofar']++;
		}
		// Grabb forums info
		$forumdata = array();
		$forum_not_in_id = ( !empty($not_in_id_sql_fid) ) ? " WHERE forum_id NOT IN $not_in_id_sql_fid " : '';
		$sql = "SELECT forum_id, forum_name, forum_topics
			FROM " . FORUMS_TABLE . $forum_not_in_id;
		if ( !($result = $db->sql_query($sql)) ) {
			$this->mx_sitemaps_message_die(GENERAL_ERROR, 'Could not query forum data', '', __LINE__, __FILE__, $sql);
		}
		while ($row = $db->sql_fetchrow($result)) {
			$forumdata[$row['forum_id']] = $row;
		}
		$db->sql_freeresult($result);
		unset($row);
		// Build sql components
		$topic_forum_sql = '';
		if ($this->rss_config['limit_time'] > 0 ) {
			$time_limit = ($this->output_data['time'] - $this->rss_config['limit_time']);
			$time_limit_sql_sel = ", " . POSTS_TABLE . " AS p";
			$time_limit_sql = " p.post_id = t.topic_last_post_id AND p.post_time > " . $time_limit . " AND ";
			$time_limit_sql_ptc = " WHERE p.post_id = t.topic_last_post_id AND p.post_time > $time_limit";
			$not_in_id_sql_ptc = (!empty($not_in_id_sql_ptc) ) ? " AND $not_in_id_sql_ptc AND " : ' AND ';
		} else {
			$time_limit_sql = "";
			$time_limit_sql_ptc = "";
			$time_limit_sql_sel = "";
			$not_in_id_sql_ptc = (!empty($not_in_id_sql_ptc) ) ? " WHERE $not_in_id_sql_ptc AND" : ' WHERE ';
		}
		$sql = "SELECT COUNT(t.topic_id) AS topic
			FROM " . TOPICS_TABLE . " as t $time_limit_sql_sel
			$time_limit_sql_ptc
			$not_in_id_sql_ptc t.topic_status <> " . TOPIC_MOVED;
		if ( !($result = $db->sql_query($sql)) ) {
			$this->mx_sitemaps_message_die(GENERAL_ERROR, 'Could not obtain limited posts count information', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$item_count = ( $row['topic'] ) ? $row['topic'] : 1;
		$db->sql_freeresult($result);
		unset($row);
	}
	// Build sql components all remaining cases
	if ( $this->rss_config['msg_out'] ) { // Go for last post content
		$msg_sql1 = "p.*, pt.*";
		$msg_sql2 = ", " . POSTS_TEXT_TABLE . " as pt";
		$msg_sql3 = " AND pt.post_id = t.topic_last_post_id ";
		
	} else {
		$msg_sql1 = "p.poster_id, p.post_time, p.post_username";
		$msg_sql2 = "";
		$msg_sql3 = "";
	}
	if($this->rss_config['rss_first']) { // First post as well ?
		$msg_sql1 .= ", pF.post_id as post_idF, pF.poster_id as poster_idF, pF.post_time as post_timeF, pF.post_username as post_usernameF, pF.post_edit_time as post_edit_timeF, pF.enable_sig as enable_sigF, pF.enable_smilies as enable_smiliesF, pF.enable_bbcode as enable_bbcodeF, pF.enable_html as enable_htmlF ";
		$msg_sql2 .= ", " . POSTS_TABLE . " as pF ";
		$msg_sql3 .= " AND pF.post_id = t.topic_first_post_id ";
		if ( $this->rss_config['msg_out'] ) { // with content ?
			$msg_sql1 .= ", ptF.bbcode_uid as bbcode_uidF, ptF.post_subject as post_subjectF, ptF.post_text as post_textF ";
			$msg_sql2 .= ", " . POSTS_TEXT_TABLE . " as ptF ";
			$msg_sql3 .= " AND ptF.post_id = t.topic_first_post_id ";
		}
	}
	// in case we're qurying for one single forum
	$not_in_id_sql = ( !empty($topic_forum_sql) ) ? '' : $not_in_id_sql;
	// in case no time limit is set
	$postselect = ( !empty($time_limit_sql) ) ? '' : 'AND p.post_id = t.topic_last_post_id ';
	$sql_first = "SELECT t.topic_id, t.forum_id, t.topic_title, t.topic_type, t.topic_status, t.topic_replies, t.topic_first_post_id, t.topic_last_post_id, $msg_sql1
			FROM " . TOPICS_TABLE . " AS t, " . POSTS_TABLE . " AS p $msg_sql2
			WHERE $time_limit_sql $not_in_id_sql
				$topic_forum_sql 
				t.topic_status <> " . TOPIC_MOVED . " 
				$postselect
				$msg_sql3
				ORDER BY t.topic_last_post_id " . $this->rss_config['rss_sort'];
	// Absolute limit 
	$topic_sofar = 0;
	$topics = array();
	// Define censored word matches
	$orig_word = array();
	$replacement_word = array();
	obtain_word_list($orig_word, $replacement_word);
	$paginated = $board_config['posts_per_page'];
	// Do the loop
	while( ( $topic_sofar <  $item_count ) && ($this->output_data['url_sofar'] < $this->rss_config['rss_url_limit']) ) {
		$result = "";
		$sql = $sql_first . " LIMIT $topic_sofar," . $this->rss_config['rss_sql_limit'];
		if ( !($result = $db->sql_query($sql)) ) {
			$this->mx_sitemaps_message_die(GENERAL_ERROR, "Could not obtain topic data", '', __LINE__, __FILE__, $sql);
		}
		while ($topic = $db->sql_fetchrow($result)) {
			$pages = ceil( ($topic['topic_replies'] + 1) / $paginated);
			$topic['topic_title'] = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, $this->un_htmlspecialchars($topic['topic_title'])) : $this->un_htmlspecialchars($topic['topic_title']);

			// Since &apos; is not HTML, but is XML convert.
			$topic['topic_title'] = str_replace("’", "'", $topic['topic_title']);

			$topic_stats = $lang['rss_item_stats'] . ($topic['topic_replies'] + 1) . ' ' . (($topic['topic_replies'] >= 1) ? $lang['rss_answers'] : $lang['rss_answer'] );

			// In case we are looking for more than one forum
			$forum_id = $topic['forum_id'];

			// In case we are going to output forum data many times, let's build this once
			if (!isset($item_opt[$forum_id])) {
				// Set mod rewrite & type
				$item_opt[$forum_id]['forum_name_ok'] =  $phpbb_seo->format_url($forumdata[$forum_id]['forum_name'], $phpbb_seo->seo_static['forum']) ;
				$item_opt[$forum_id]['forum_rss_url'] = $this->path_config['rss_url'] .  (($this->mod_r_config['forum_pre_rss'] !='') ? $this->mod_r_config['forum_pre_rss'] . $forum_id : $item_opt[$forum_id]['forum_name_ok'] . '-rf' .  $forum_id) . $this->mod_r_config['extra_params'] . $this->mod_r_config['ext_out'];
				//$item_opt[$forum_id]['forum_url'] = $this->path_config['phpbb_url'] . (($this->mod_r_config['forum_pre'] !='') ? $this->mod_r_config['forum_pre'] . $forum_id .  $this->mod_r_config['ext'] : $item_opt[$forum_id]['forum_name_ok'] . $this->mod_r_config['forum_anchor'] . $forum_id . $phpbb_seo->seo_ext['forum']);
				$item_opt[$forum_id]['forum_name'] = $forumdata[$forum_id]['forum_name'];
			}

			$topic_url = $this->path_config['phpbb_url'] . (($this->mod_r_config['topic_pre'] !='') ? $this->mod_r_config['topic_pre'] . $topic['topic_id'] :  $phpbb_seo->format_url($topic['topic_title'], $phpbb_seo->seo_static['topic']) . $phpbb_seo->seo_delim['topic'] .  $topic['topic_id']);
			
			$has_reply = ($topic['topic_last_post_id'] > $topic['topic_first_post_id']) ? TRUE : FALSE;
			$item_time = gmdate('D, d M Y H:i:s \G\M\T', $topic['post_time']);
			// Do we output the topic URL
			if( $has_reply && $this->rss_config['rss_first']) {
				$topic_urlF = $topic_url . $phpbb_seo->seo_ext['topic'];
				// With the msg content
				if ($this->rss_config['msg_out']) {
					$first_message = '<hr/> ' . $this->format_rss_txt($topic['post_subjectF'], $topic['post_textF'], $this->rss_config['msg_sumarize'], $topic_urlF, $topic['bbcode_uidF'], $topic['enable_smiliesF'], $topic['enable_htmlF'] ) . ' <hr/>';
				}
				$item_title = htmlspecialchars($topic['topic_title']);
				$item_desc = htmlspecialchars( '<div class="item_sub_title">' . $item_opt[$forum_id]['forum_name'] . ' : ' . $topic['topic_title'] . ' </div> ' .  $first_message. ' <br/> ' . $topic_stats);
				$this->output_data['data'] .= sprintf($this->style_config['rss_tpl'], $item_title, $topic_urlF, $item_time, $item_desc, $item_opt[$forum_id]['forum_rss_url'], htmlspecialchars($item_opt[$forum_id]['forum_name']), $topic_urlF);
				$this->output_data['url_sofar']++;
			}
			// Do we output the last post URL
			if ( $this->rss_config['rss_last'] || !$has_reply) {
				$start = ($pages > 1) ? $this->mod_r_config['start'] . $paginated * ($pages-1) : '';
				$post_num = ($has_reply) ? '#' . $topic['topic_last_post_id'] :'';
				$topic_url .= $start . $phpbb_seo->seo_ext['topic'] . $post_num;
				// With the msg content
				if ($this->rss_config['msg_out']) {
					$last_message = '<hr/> ' . $this->format_rss_txt($topic['post_subject'], $topic['post_text'], $this->rss_config['msg_sumarize'], $topic_url, $topic['bbcode_uid'], $topic['enable_smilies'], $topic['enable_html'] ) . ' <hr/>';
				}
				$item_title = htmlspecialchars(($has_reply && $this->rss_config['rss_first']) ? $topic['topic_title'] . $lang['rss_reply'] : $topic['topic_title']);
				$item_desc = htmlspecialchars('<div class="item_sub_title">' . $item_opt[$forum_id]['forum_name'] . ' : ' . $topic['topic_title'] . ' </div>' .  $last_message . ' <br/> ' . $topic_stats);
				$this->output_data['data'] .= sprintf($this->style_config['rss_tpl'], $item_title, $topic_url, $item_time, $item_desc, $item_opt[$forum_id]['forum_rss_url'], htmlspecialchars($item_opt[$forum_id]['forum_name']), $topic_url);
				$this->output_data['url_sofar']++;
			}
		}// End topic loop
		// Used to separate query
		$topic_sofar = $topic_sofar + $this->rss_config['rss_sql_limit'];
		$db->sql_freeresult($result);
		unset($topic);
	}// End Query limit loop
}
?>
