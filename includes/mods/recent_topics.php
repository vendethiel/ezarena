<?php
class recent_topics
{
	public function __construct()
	{
		global $template, $db, $board_config, $phpbb_seo, $lang;
		global $rcs, $get, $qte;

		$template->assign_vars(array(
			'MARQUEE_TOPIC' => str_replace("%s",$board_config['topics_on_index'],$lang['marquee_topic']) ) 
		);

		if ( !($result = $db->sql_query($a = $this->getFetchSql())) ) 
		{ 
			message_die(GENERAL_ERROR, 'Could not query recent posts marquee information', '', __LINE__, __FILE__, $sql); 
		} 

		if ($rows = $db->sql_fetchrowset($result)) 
		{ 
			$db->sql_freeresult($result); 
		}

		$topics = count($rows) <= $board_config['topics_on_index'] ? count($rows) : $board_config['topics_on_index'];

		for ($i = 0; $i < $topics; ++$i)
		{
			$topic = $rows[$i];
			$mar_title = $topic["topic_title"];
		   // www.phpBB-SEO.com SEO TOOLKIT BEGIN 
			if ( !isset($phpbb_seo->seo_url['topic'][$topic['topic_id']]) )
			{ 
		   		$phpbb_seo->seo_url['topic'][$topic['topic_id']] = $phpbb_seo->format_url($mar_title); 
		  	}
		    // www.phpBB-SEO.com SEO TOOLKIT END	
			$mar_url = $get->url('viewtopic', array(POST_TOPIC_URL => $topic["topic_id"])); 
			$mar_user = $topic["username"];
			$pic = pic_for_topic($topic);
			if ( $board_config['allow_smilies'] ) 
			{ 
				$topic["topic_title"] = smilies_pass($topic["topic_title"]); 
			}
			$topic_title = $topic['topic_title'];
			$qte->attr($topic_title, $topic['topic_attribute']);

			$template->assign_block_vars('marqueerow', array( 
				'FOLD_URL' => $pic, 
				'TOPIC_TITLE' => $topic_title, 
				'TOPIC_URL' => $get->url('viewtopic', array(POST_TOPIC_URL => $topic["topic_id"]), true),
				'POST_URL' => $get->url('viewtopic', array('p' => $topic["post_id"]), true) . '#' . $topic["post_id"],
				'STYLE' => $rcs->get_colors($topic),
				'USERNAME' => $topic["username"], 
				'USER_PROF' => $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $topic["user_id"]), true), 
				'POST_DATE' => create_date($board_config['default_dateformat'], $topic["post_time"], $board_config['board_timezone']))
			); 
		}
	}

	private function getFetchSql()
	{
		return "SELECT t.topic_id, t.topic_title, t.topic_last_post_id, t.forum_id, t.topic_type, t.topic_status, t.topic_attribute,
				p.post_id, p.poster_id, p.post_time,
				u.user_id, u.username, u.user_lastvisit, u.username, u.user_level, u.user_color, u.user_group_id
			FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f, " . POSTS_TABLE . " p, " . USERS_TABLE . " u 
			WHERE t.forum_id IN " . $this->getAuthViewSql() . " AND t.topic_id = p.topic_id 
			AND f.forum_id = t.forum_id 
			AND t.topic_status <> 2 
			AND p.post_id = t.topic_last_post_id 
			AND p.poster_id = u.user_id 
			ORDER BY t.topic_last_post_id DESC";
	}

	/**
	 * Finds which forum are available to the user for see
	 */
	private function getAuthViewSql()
	{
		global $total_categories, $total_forums, $category_rows, $userdata, $forum_data, $is_auth_ary;

		$ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata, $forum_data); 
		$ary2 = auth(AUTH_READ, AUTH_LIST_ALL, $userdata, $forum_data); 
		$is_auth_ary = array_merge_replace($ary, $ary2); 
		$auth_view_forum_sql = ''; 

		for($i = 0; $i < $total_categories; $i++) 
		{
			$cat_id = $category_rows[$i]['cat_id']; 
			for($j = 0; $j < $total_forums; $j++) 
			{ 
				if ( $is_auth_ary[$forum_data[$j]['forum_id']]['auth_view'] && $is_auth_ary[$forum_data[$j]['forum_id']]['auth_read'] && $forum_data[$j]['cat_id'] == $cat_id ) 
				{ 
					$auth_view_forum_sql .= ($auth_view_forum_sql == '' ? '' : ', ' ) . $forum_data[$j]['forum_id']; 
				} 
			} 
		} 
		
		return $auth_view_forum_sql == '' ? '(0)' : '(' . $auth_view_forum_sql . ')';
	}
}