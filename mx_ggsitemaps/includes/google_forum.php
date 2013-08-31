<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: google_forum.php 2007/04/12 13:48:48 dcz Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/
// First basic security
if ( !defined('IN_PHPBB') && !defined('IN_PORTAL') ) {
	die('Hacking attempt');
	exit;
}
if (!($this->actions['type'] === 'google_')) {
	$this->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Request not accepted');
}

// Filter $this->actions['list_id'] var type
$this->actions['list_id'] = intval($this->actions['list_id']);

// Build unauthed array
$this->set_exclude_list($this->ggsitemaps_config['ggs_exclude_forums']);
// Filter forums & build sql components
if (!empty($this->output_data['exclude_list'])) {
	$not_in_id_sql = " f.forum_id NOT IN (" . implode(",", $this->output_data['exclude_list']) . ") AND f.auth_view = " . AUTH_ALL . " AND f.auth_read = " . AUTH_ALL;
} else {
	$not_in_id_sql = "f.auth_view = " . AUTH_ALL . " AND f.auth_read = " . AUTH_ALL;
}
// we can start wroking
if ($this->actions['action'] === 'forum') {
	if ($this->actions['list_id'] > 0) {
		// then It's a forum sitemap
		// Check forum auth and grab necessary infos			
		$sql = "SELECT f.*, p.post_time
			FROM ". FORUMS_TABLE ." AS f, " . POSTS_TABLE . " AS p
			WHERE f.forum_id = " . $this->actions['list_id'] . "
			AND p.post_id = f.forum_last_post_id";
		if ( !($result = $db->sql_query($sql)) ) {
			$this->mx_sitemaps_message_die(GENERAL_ERROR, "Could not obtain Forum data", '', __LINE__, __FILE__, $sql);
		}
		$forum_data = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if ( empty($forum_data) || ( $forum_data['auth_view'] != 0 ) || ( $forum_data['auth_read'] != 0 ) || (in_array($forum_id, $this->output_data['exclude_list'])) ) {
			$this->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Invalid Sitemap');
		}

		// This forum is allowed and has posts, so let's start
		$forum_id = $forum_data['forum_id'];
		$forum_url_ok = $phpbb_seo->format_url($forum_data['forum_name'], $phpbb_seo->seo_static['forum']);
		$forum_sitemap_url = $this->path_config['sitemap_url'] . (($this->mod_r_config['forum_pre_google'] !='') ? $this->mod_r_config['forum_pre_google'] . $forum_id . $this->mod_r_config['ext_out'] : $forum_url_ok . '-gf' .  $forum_id . $this->mod_r_config['ext_out']);
		$this->seo_kill_dupes($forum_sitemap_url);

		$forum_url = $this->path_config['phpbb_url'] . (($this->mod_r_config['forum_pre'] !='') ? $this->mod_r_config['forum_pre'] . $forum_id . $this->mod_r_config['ext'] : $forum_url_ok . $phpbb_seo->seo_delim['forum'] .  $forum_id . $phpbb_seo->seo_ext['forum']);

		$this->output_data['data'] .= sprintf($this->style_config['Sitemap_tpl'], $forum_url, gmdate('Y-m-d\TH:i:s'.'+00:00', $forum_data['post_time']), 'always', '1.0');
		$this->output_data['url_sofar']++;

		// So let's go for max item per query
		$sql = "SELECT COUNT(topic_id) AS forum_topics
			FROM " . TOPICS_TABLE . "
			WHERE forum_id = $forum_id";
		if ( !($result = $db->sql_query($sql)) ) {
			$this->mx_sitemaps_message_die(GENERAL_ERROR, 'Could not obtain limited topics count information', '', __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);
		$topics_count = ( $row['forum_topics'] ) ? $row['forum_topics'] : 1;
		$db->sql_freeresult($result);
		unset($row);
		// Absolute limit 
		$topic_sofar = 0;
		$topics = array();
		// Define censored word matches
		$orig_word = array();
		$replacement_word = array();
		obtain_word_list($orig_word, $replacement_word);
		$paginated = $board_config['posts_per_page'];
		$sql_first = "SELECT t.topic_id, t.topic_title, t.topic_type, t.topic_status, t.topic_replies, topic_last_post_id, p.post_time
				FROM " . TOPICS_TABLE . " AS t, " . POSTS_TABLE . " AS p
				WHERE t.topic_last_post_id=p.post_id
					AND t.forum_id = $forum_id
					AND t.topic_status <> " . TOPIC_MOVED . "
				ORDER BY t.topic_last_post_id " . $this->google_config['ggs_sort'];

		while( ( $topic_sofar <  $topics_count ) && ($this->output_data['url_sofar'] < $this->google_config['ggs_url_limit']) ) {
			$sql = $sql_first . " LIMIT $topic_sofar," . $this->google_config['ggs_sql_limit'];	
			if ( !($result = $db->sql_query($sql)) ) {
				$this->mx_sitemaps_message_die(GENERAL_ERROR, "Could not obtain category data", '', __LINE__, __FILE__, $sql);
			}
			while ($topic = $db->sql_fetchrow($result)) {
				$pages = ceil( ($topic['topic_replies'] + 1) / $paginated);
				$topic['topic_title'] = (count($orig_word)) ? preg_replace($orig_word, $replacement_word, $topic['topic_title']) : $topic['topic_title'];
				$topic_url = $this->path_config['phpbb_url'] . (($this->mod_r_config['topic_pre'] !='') ? $this->mod_r_config['topic_pre'] . $topic['topic_id'] : $phpbb_seo->format_url($topic['topic_title'], $phpbb_seo->seo_static['topic']) . $phpbb_seo->seo_delim['topic'] .  $topic['topic_id']);
				if ($topic['topic_type'] == 0 ) {
					$topic_priority = $this->google_config['ggs_default_priority'];
				} else {
					$topic_priority = ($topic['topic_type'] > 1) ? $this->google_config['ggs_announce_priority'] : $this->google_config['ggs_sticky_priority'];
				}
				$topic_change = ($topic['topic_status'] == 1) ? "never" : "always";
				$topic_time = gmdate('Y-m-d\TH:i:s'.'+00:00', $topic['post_time']);
				$this->output_data['data'] .= sprintf($this->style_config['Sitemap_tpl'], $topic_url . $phpbb_seo->seo_ext['topic'], $topic_time, $topic_change, $topic_priority);
				$this->output_data['url_sofar']++;
				if ($pages > 1 && $this->google_config['ggs_pagination']) {
					// Reset Pages limits for this topic
					$pag_limit1 = $this->google_config['ggs_limitdown'];
					$pag_limit2 = $this->google_config['ggs_limitup'];	
					// If $pag_limit2 too big for this topic, lets output all pages
					$pag_limit2 = ( $pages < $pag_limit2 ) ?  ($pages - 1) :  $pag_limit2;
					$i=1;
					while ( ($i < $pages) ) {
						if ( ( $i <= $pag_limit1 ) || ( $i > ($pages - $pag_limit2 ) ) ) {
							$start = $this->mod_r_config['start'] . $paginated * $i;
							$this->output_data['data'] .= sprintf($this->style_config['Sitemap_tpl'], $topic_url . $start . $phpbb_seo->seo_ext['topic'], $topic_time, $topic_change, $topic_priority);
							$i++;
							$this->output_data['url_sofar']++;
						} else {
							$i++;
						}
					}
				}
			}// End topic loop
			// Used to separate query
			$topic_sofar = $topic_sofar + $this->google_config['ggs_sql_limit'];
			$db->sql_freeresult($result);
			unset($topic);
		}// End Query limit loop
	} else {
		// it's the forums sitemap
		$forum_sitemap_url = $this->path_config['sitemap_url'] . (($this->mod_r_config['mod_rewrite']) ? 'forum-sitemap.xml' . $this->ext_config['gzip_ext_out'] : 'sitemap.'.$phpEx . '?forum');
		$this->seo_kill_dupes($forum_sitemap_url);
		// Forum index location
		$this->output_data['data'] .= sprintf($this->style_config['Sitemap_tpl'], $this->path_config['phpbb_url'] . $phpbb_seo->seo_static['index'], gmdate('Y-m-d\TH:i:s'.'+00:00', time()), 'always', '1.0');
		$this->output_data['url_sofar']++;

		$sql = "SELECT f.*, p.post_time
			FROM " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p 
			WHERE $not_in_id_sql
				AND p.post_id = f.forum_last_post_id
			ORDER BY f.forum_last_post_id " . $this->google_config['ggs_sort'];
		if ( !($result = $db->sql_query($sql)) ) {
			$this->mx_sitemaps_message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
		}
		$last_ever = 0;
		$paginated = $board_config['topics_per_page'];
		// Forums loop
		while( $forum_data = $db->sql_fetchrow($result) ) {
			$pages = ceil($forum_data['forum_topics'] / $paginated);
			$forum_id = $forum_data['forum_id'];
			$forum_url = $this->path_config['phpbb_url'] . ( ($this->mod_r_config['forum_pre'] !='') ? $this->mod_r_config['forum_pre'] . $forum_id : $phpbb_seo->format_url($forum_data['forum_name'], $phpbb_seo->seo_static['forum']) . $phpbb_seo->seo_delim['forum'] .  $forum_id );
			$forum_time = gmdate('Y-m-d\TH:i:s'.'+00:00', $forum_data['post_time']);
			$this->output_data['data'] .= sprintf($this->style_config['Sitemap_tpl'], $forum_url . $phpbb_seo->seo_ext['forum'], $forum_time, 'always', '1.0');
			$this->output_data['url_sofar']++;
			if ($pages > 1 && $this->google_config['ggs_pagination']) {
				// Reset Pages limits for this topic
				$pag_limit1 = $this->google_config['ggs_limitdown'];
				$pag_limit2 = $this->google_config['ggs_limitup'];	
				// If $pag_limit2 too big for this topic, lets output all pages
				$pag_limit2 = ( $pages < $pag_limit2 ) ?  ($pages - 1) :  $pag_limit2;
				$i=1;
				while ( ($i < $pages) ) {
					if ( ( $i <= $pag_limit1 ) || ( $i > ($pages - $pag_limit2 ) ) ) {
						$start = $this->mod_r_config['start'] . $paginated * $i;
						$this->output_data['data'] .= sprintf($this->style_config['Sitemap_tpl'], $forum_url . $start . $phpbb_seo->seo_ext['topic'], $forum_time, 'always', '1.0');
						$i++;
					$this->output_data['url_sofar']++;
					} else {
						$i++;
					}
				}
			}
		} // End Forum map loop
		$db->sql_freeresult($result);
		unset ($forum_data);
	}
} else { // it's a sitemap index call
	// Forum maps locations
	$sitemap_forums_url = ($this->mod_r_config['mod_rewrite']) ? 'forum-sitemap.xml' . $this->ext_config['gzip_ext_out'] : 'sitemap.'.$phpEx.'?forum';
	$this->output_data['data'] .= sprintf( $this->style_config['SitmIndex_tpl'], $this->path_config['sitemap_url'] .  $sitemap_forums_url, gmdate('Y-m-d\TH:i:s'.'+00:00', time()) );
	$this->output_data['url_sofar']++;
	$sql = "SELECT f.*, p.post_time
		FROM " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p 
		WHERE $not_in_id_sql
			AND p.post_id = f.forum_last_post_id
		ORDER BY f.forum_last_post_id " . $this->google_config['ggs_sort'];
	if ( !($result = $db->sql_query($sql)) ) {
			$this->mx_sitemaps_message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
	}
	// Reset vars
	$forum_sitemap_urls = '';
	$last_ever = 0;
	while( $forum_data = $db->sql_fetchrow($result) ) {
		$forum_id = $forum_data['forum_id'];
			if (!(in_array($forum_id, $this->output_data['exclude_list'])) ) {
				// Set mod rewrite type
				$forum_sitemap_urls = ($this->mod_r_config['forum_pre_google'] !='') ? $this->mod_r_config['forum_pre_google'] . $forum_id . $this->mod_r_config['ext_out'] : $phpbb_seo->format_url($forum_data['forum_name'], $phpbb_seo->seo_static['forum']) . '-gf' .  $forum_id . $this->mod_r_config['ext_out'];
				$this->output_data['data'] .= sprintf( $this->style_config['SitmIndex_tpl'],  $this->path_config['sitemap_url'] .  $forum_sitemap_urls, gmdate('Y-m-d\TH:i:s'.'+00:00', $forum_data['post_time']) );
				$this->output_data['url_sofar']++;
			}
	}// End Forum map loop
	$db->sql_freeresult($result);
	unset($forum_data);
}
?>
