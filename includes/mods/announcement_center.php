<?php
// lefty74's announcement center
class announcement_center
{
	public function __construct()
	{
		global $template, $announcement_centre_config;
		$this->config = $announcement_centre_config;

		$this->config['announcement_text']	= smilies_pass($this->config['announcement_text']);
		$announcement_text_uid = make_bbcode_uid();
		$this->config['announcement_text']	= bbencode_first_pass( $this->config['announcement_text'], $announcement_text_uid );
		$this->config['announcement_text']	= bbencode_second_pass ( $this->config['announcement_text'], $announcement_text_uid );
		$this->config['announcement_text']	= str_replace("\n", "\n<br />\n", $this->config['announcement_text']);

		$this->config['announcement_guest_text']	= smilies_pass($this->config['announcement_guest_text']);
		$announcement_guest_text_uid = make_bbcode_uid();
		$this->config['announcement_guest_text']	= bbencode_first_pass( $this->config['announcement_guest_text'], $announcement_guest_text_uid );
		$this->config['announcement_guest_text']	= bbencode_second_pass ( $this->config['announcement_guest_text'], $announcement_guest_text_uid );
		$this->config['announcement_guest_text']	= str_replace("\n", "\n<br />\n", $this->config['announcement_guest_text']);

		$announcement_guest_text = $this->config['announcement_guest_text'];

		$announcement_title			= empty($this->config['announcement_title']) ? $lang['Site_announcement_block_title'] : str_replace("\n", "\n<br />\n", $this->config['announcement_title']);
		$announcement_guest_title	= empty($this->config['announcement_guest_title']) ? $lang['Guest_announcement_block_title'] : str_replace("\n", "\n<br />\n", $this->config['announcement_guest_title']);

		// get the post information in case last topic or forum has been entered
		if ( !$this->config['announcement_forum_id'] == '' ||  !$this->config['announcement_topic_id'] == '')
		{	
			if (!($result = $db->sql_query($this->getFetchSql())))
			{
				message_die(GENERAL_ERROR, 'Error in getting announcement post', '', __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$row['post_text']	= smilies_pass($row['post_text']);
				$row['post_text']	= bbencode_first_pass( $row['post_text'], $row['bbcode_uid'] );
				$row['post_text']	= bbencode_second_pass ( $row['post_text'], $row['bbcode_uid'] );
				$row['post_text']	= str_replace("\n", "\n<br />\n", $row['post_text']);
				$announcement_text = $row['post_text'];
			}
		}
		else
		{
			$announcement_text = $this->config['announcement_text'];
		}	

		// who sees the announcements
		if ( $this->config['announcement_status'] == ANNOUNCEMENTS_LEFTY74_SHOW_YES )
		{
			switch ($this->getDisplay())
			{
				case 'normal':
					$template->assign_block_vars('announcement_displayed', array());
					break;
				case 'guest':
					$template->assign_block_vars('guest_announcement_displayed', array());
					break;
				default:
					$template->assign_block_vars('announcement_not_displayed', array());
			}
		}

		//BEGIN ACP Site Announcement Centre by lefty74
	 	$template->assign_vars(array(
	 		'L_ANNOUNCEMENT_TITLE' => $announcement_title,
		    'SITE_ANNOUNCEMENTS_LEFTY74' => $announcement_text, 
		  	'L_ANNOUNCEMENT_GUEST_TITLE' => $announcement_guest_title,
		   'GUEST_ANNOUNCEMENTS_LEFTY74' => $announcement_guest_text,
		));
	}

	private function getDisplay()
	{
		global $userdata;
		if( $this->config['announcement_access'] == ANNOUNCEMENTS_LEFTY74_SHOW_ADM && $userdata['user_level'] == ADMIN )
		{
			return 'normal';
		}
		else if ( $this->config['announcement_access'] == ANNOUNCEMENTS_LEFTY74_SHOW_MOD && ( $userdata['user_level'] == MOD || $userdata['user_level'] == ADMIN ) )
		{
			return 'normal';
		}
		else if ( $this->config['announcement_access'] == ANNOUNCEMENTS_LEFTY74_SHOW_REG && $userdata['session_logged_in'] )
		{
			return 'normal';
		}
		else if ( $this->config['announcement_access'] == ANNOUNCEMENTS_LEFTY74_SHOW_ALL )
		{
			return 'normal';
		}
		else if (  $this->config['announcement_guest_status'] == ANNOUNCEMENTS_LEFTY74_GUEST_YES && !$userdata['session_logged_in'] && !$this->config['announcement_access'] == ANNOUNCEMENTS_LEFTY74_SHOW_ALL )
		{
			return 'guest';
		}
	}

	private function getFetchSql()
	{
		if ( !$this->config['announcement_forum_id'] == '')
		{
			$where = 'p.forum_id = ' . $this->config['announcement_forum_id'];
		}
		elseif ( !$this->config['announcement_topic_id'] == '')
		{
			$where = ('p.topic_id = ' . $this->config['announcement_topic_id']);
		}
		 
		if ( $this->config['announcement_forum_topic_first_latest'] == ANNOUNCEMENTS_LEFTY74_FORUM_TOPIC_FIRST )
		{
			$order = 'ASC';
		}
		elseif ( $this->config['announcement_forum_topic_first_latest'] == ANNOUNCEMENTS_LEFTY74_FORUM_TOPIC_LATEST )
		{
			$order = 'DESC';
		}
		 					
		return "SELECT p.post_id, p.forum_id, p.topic_id, pt.*
		FROM " . POSTS_TABLE . ' as p, ' . POSTS_TEXT_TABLE . " as pt
		WHERE ". $where ."
		AND p.post_id = pt.post_id 
		ORDER BY p.post_id ". $order ." LIMIT 1";
	}
}