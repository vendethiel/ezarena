<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: yahoo_forum.php 2007/04/12 13:48:48 dcz Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/
// First basic security
if ( !defined('IN_PHPBB') && !defined('IN_PORTAL') ) {
	die('Hacking attempt');
	exit;
}
// Filter $this->actions['list_id'] var type
$this->actions['list_id'] = intval($this->actions['list_id']);
// Take care about dupe
$urllist_url = $this->path_config['yahoo_url'] . (($this->mod_r_config['mod_rewrite']) ? 'urllist.txt' . $this->ext_config['gzip_ext_out'] : 'urllist.'.$phpEx);
$this->seo_kill_dupes($urllist_url);
if ($this->actions['type'] === 'yahoo_') {
	// Build unauthed array
	$this->set_exclude_list($this->ggsitemaps_config['yahoo_exclude']);
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
		$not_in_id_sql_ptc = " t.forum_id NOT IN $not_in_id_sql_fid";
		$not_in_id_sql = " $not_in_id_sql_ptc AND ";
	} else {
		$not_in_id_sql = $not_in_id_sql_ptc = $not_in_id_sql = $not_in_id_sql_fid = '';
	}
	if ($this->yahoo_config['limit_time'] > 0 ) {
		$time_limit = ($this->output_data['time'] - $this->yahoo_config['limit_time']);
		$time_limit_sql = " p.post_id = t.topic_last_post_id AND p.post_time > $time_limit AND ";
		$time_limit_sql_sel = ", " . POSTS_TABLE . " AS p";
		$time_limit_sql_ptc = " WHERE p.post_id = t.topic_last_post_id AND p.post_time > $time_limit";
		$not_in_id_sql_ptc = (!empty($not_in_id_sql_ptc) ) ? " AND $not_in_id_sql_ptc AND " : ' AND ';
	} else {
		$time_limit_sql = "";
		$time_limit_sql_sel = "";
		$time_limit_sql_ptc = "";
		$not_in_id_sql_ptc = (!empty($not_in_id_sql_ptc) ) ? " WHERE $not_in_id_sql_ptc AND" : ' WHERE ';
	}
	$sql = "SELECT COUNT(t.topic_id) AS topic
		FROM " . TOPICS_TABLE . " as t $time_limit_sql_sel
		$time_limit_sql_ptc
		$not_in_id_sql_ptc t.topic_status <> " . TOPIC_MOVED;
	//echo "<pre>$sql</pre>";
	if ( !($result = $db->sql_query($sql)) ) {
		$this->mx_sitemaps_message_die(GENERAL_ERROR, 'Could not obtain limited posts count information', '', __LINE__, __FILE__, $sql);
	}
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	$item_count = ( $row['topic'] ) ? $row['topic'] : 1;
	// Grabb forums info
	$forumdata = array(); 
	$forum_not_in_id = ( !empty($not_in_id_sql_fid) ) ? " WHERE forum_id NOT IN $not_in_id_sql_fid " : '';
	$sql = "SELECT forum_id, forum_name, forum_topics
		FROM " . FORUMS_TABLE . $forum_not_in_id;
	//echo "<pre>$sql</pre>";
	if ( !($result = $db->sql_query($sql)) ) {
		$this->mx_sitemaps_message_die(GENERAL_ERROR, 'Could not query forum data', '', __LINE__, __FILE__, $sql);
	}
	while ($row = $db->sql_fetchrow($result)) {
		$forumdata[$row['forum_id']] = $row;
	}
	$db->sql_freeresult($result);
	// Topic info 
	$sql_first = "SELECT t.topic_id, t.forum_id, t.topic_title, t.topic_replies
			FROM " . TOPICS_TABLE . " AS t $time_limit_sql_sel
			WHERE $time_limit_sql $not_in_id_sql
				t.topic_status <> " . TOPIC_MOVED . "
			ORDER BY t.topic_last_post_id " . $this->yahoo_config['yahoo_sort'];
	//echo "<pre>$sql_first</pre>";
	// Absolute limit 
	$topic_sofar = 0;
	$topics = array();
	$item_opt = array();
	// Define censored word matches
	$orig_word = array();
	$replacement_word = array();
	if ($this->mod_r_config['mod_r_type'] >= 3) { // +Advanced
		obtain_word_list($orig_word, $replacement_word);
	}
	$t_paginated = $board_config['posts_per_page'];
	$f_paginated = $board_config['topics_per_page'];
	// Do the loop
	while( ( $topic_sofar <  $item_count ) && ($this->output_data['url_sofar'] < $this->yahoo_config['yahoo_limit']) ) {
		$result = "";
		$sql = $sql_first . " LIMIT $topic_sofar," . $this->yahoo_config['yahoo_sql_limit'];
		if ( !($result = $db->sql_query($sql)) ) {
			$this->mx_sitemaps_message_die(GENERAL_ERROR, "Could not obtain topic data", '', __LINE__, __FILE__, $sql);
		}
		while ($topic = $db->sql_fetchrow($result) ) {
			$t_pages = ceil( ($topic['topic_replies'] + 1) / $t_paginated);
			$topic['topic_title'] = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, $topic['topic_title']) : $topic['topic_title'];
			$forum_id = $topic['forum_id'];
			// Only output forum urls once
			if (!isset($item_opt[$forum_id])) {
				$item_opt[$forum_id] = $forum_id;
				$f_pages = ceil($forumdata[$forum_id]['forum_topics'] / $f_paginated);
				$forum_url = $this->path_config['phpbb_url'] . ( ($this->mod_r_config['forum_pre'] !='') ? $this->mod_r_config['forum_pre'] . $forum_id :  $phpbb_seo->format_url($forumdata[$forum_id]['forum_name'], $phpbb_seo->seo_static['forum']) . $phpbb_seo->seo_delim['forum'] .  $forum_id );
				$this->output_data['data'] .= $forum_url . $phpbb_seo->seo_ext['forum'] . "\n";
				$this->output_data['url_sofar']++;
				if ($f_pages > 1 && $this->yahoo_config['yahoo_pagination']) {
					// Reset Pages limits for this topic
					$pag_limit1 = $this->yahoo_config['yahoo_limitdown'];
					$pag_limit2 = $this->yahoo_config['yahoo_limitup'];	
					// If $pag_limit2 too big for this topic, lets output all pages
					$pag_limit2 = ( $f_pages < $pag_limit2 ) ?  ($f_pages - 1) :  $pag_limit2;
					$i=1;
					while ( ($i < $f_pages) ) {
						if ( ( $i <= $pag_limit1 ) || ( $i > ($f_pages - $pag_limit2 ) ) ) {
							$start = $this->mod_r_config['start'] . $f_paginated * $i;
							$this->output_data['data'] .= $forum_url . $start . $phpbb_seo->seo_ext['forum'] . "\n";
							$i++;
							$this->output_data['url_sofar']++;
						} else {
							$i++;
						}
					}
				}
			}
			$topic_url = $this->path_config['phpbb_url'] . (($this->mod_r_config['topic_pre'] !='') ? $this->mod_r_config['topic_pre'] . $topic['topic_id'] :  $phpbb_seo->format_url($topic['topic_title'], $phpbb_seo->seo_static['topic']) . $phpbb_seo->seo_delim['topic'] .  $topic['topic_id'] );
			$this->output_data['data'] .= $topic_url . $phpbb_seo->seo_ext['topic'] . "\n";
			$this->output_data['url_sofar']++;
			if ($t_pages > 1 && $this->yahoo_config['yahoo_pagination']) {
				// Reset Pages limits for this topic
				$pag_limit1 = $this->yahoo_config['yahoo_limitdown'];
				$pag_limit2 = $this->yahoo_config['yahoo_limitup'];	
				// If $pag_limit2 too big for this topic, lets output all pages
				$pag_limit2 = ( $t_pages < $pag_limit2 ) ?  ($t_pages - 1) :  $pag_limit2;
				$i=1;
				while ( ($i < $t_pages) ) {
					if ( ( $i <= $pag_limit1 ) || ( $i > ($t_pages - $pag_limit2 ) ) ) {
						$start = $this->mod_r_config['start'] . $t_paginated * $i;
						$this->output_data['data'] .= $topic_url . $start . $phpbb_seo->seo_ext['topic'] . "\n";
						$i++;
						$this->output_data['url_sofar']++;
					} else {
						$i++;
					}
				}
			}
		}// End topic loop
		// Used to separate query
		$topic_sofar = $topic_sofar + $this->yahoo_config['yahoo_sql_limit'];
		$db->sql_freeresult($result);
		unset($topic);
	}// End Query limit loop
} else {
	$this->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Request not accepted');
}
?>
