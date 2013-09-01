<?php
class show_online
{
	public function __construct()
	{
		global $template, $db, $get, $rcs, $lang;

		if( !($result = $db->sql_query($this->getFetchSql())) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain user/online information', '', __LINE__, __FILE__, $sql);
		}

		$logged_visible_online = 0;
		$logged_hidden_online = 0;
		$bot_count = 0;
		$guests_online = 0;
		$online_userlist = '';
		$l_online_users = '';
		$gender_image = '';
		$online_botlist = '';

		$userlist_ary = array();
		$userlist_visible = array();

		$prev_user_id = 0;
		$prev_user_ip = $prev_session_ip = '';
		
		while ($row = $db->sql_fetchrow($result))
		{
			// User is logged in and therefor not a guest
			if ( $row['session_logged_in'] )
			{
				$agent = strtolower($row['session_agent']);
				$browser = $this->getBrowserIcon($agent);		
				// Skip multiple sessions for one user
				if ( $row['user_id'] != $prev_user_id )
				{
					$style_color = $rcs->get_colors($row);
					if ( $row['user_allow_viewonline'] )
					{
						$user_online_link = '<a href="' . $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true) . '"' . $style_color . '>' . $row['username'] . '</a>'. $browser . '';
						$logged_visible_online++;
						if ( $dta_flag = display_flag($row['user_flag'], true) )
						{
							$i_online_flag = '&nbsp;<img class="gensmall" src="' . $dta_flag['img'] . '" alt="' . $dta_flag['name'] . '" title="' . $dta_flag['name'] . '" style="vertical-align:text-bottom; border:0;" />';
							$user_online_link = $user_online_link . $i_online_flag;
						}
					}
					else
					{
						$user_online_link = '<a href="' . $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true) . '"' . $style_color . '><i>' . $row['username'] . '</i></a>'. $browser . '';
						$logged_hidden_online++;
					}

					if ( $row['user_allow_viewonline'] || $userdata['user_level'] == ADMIN )
					{
						$online_userlist .= ( $online_userlist != '' ) ? ', ' . $user_online_link : $user_online_link;
						switch ($row['user_gender'])
						{
							case 1 : $online_userlist .= " <img src=\"" . $images['icon_minigender_male'] . "\" alt=\"" . $lang['Gender'].  ":".$lang['Male']."\" title=\"" . $lang['Gender'] . ":".$lang['Male']. "\" border=\"0\" />"; break;
							case 2 : $online_userlist .= " <img src=\"" . $images['icon_minigender_female'] . "\" alt=\"" . $lang['Gender']. ":".$lang['Female']. "\" title=\"" . $lang['Gender'] . ":".$lang['Female']. "\" border=\"0\" />"; break;
						}					
					}
				}
				$prev_user_id = $row['user_id'];
			}
			else
			{
				// Skip multiple sessions for one user
				if ( $row['session_ip'] != $prev_session_ip )
				{
					$guests_online++;
					$bot_id = is_bot(decode_ip($row['session_ip']));
					if ($bot_id >=0)
					{
						$guests_online--;
						$bot_count++;
						if (!array_key_exists($bot_to_style[$bot_id], $bots_online))
						{
							$bots_online[$bot_to_style[$bot_id]] = 1;
						}
						else
						{
							$bots_online[$bot_to_style[$bot_id]] ++;
						}
					}
				}
			}

			$prev_session_ip = $row['session_ip'];
		}
		$db->sql_freeresult($result);

		// www.phpBB-SEO.com SEO TOOLKIT BEGIN
		if ( !empty($bots_online) ) {
			foreach ( $bots_online as $bot => $bot_num) {
				$bot_cnt = ( $bot_num > 1) ? "($bot_num)" : '';
				$online_botlist .= (($online_botlist!='') ? ', ' : '') . "<span ".$bot_style[$bot].">$bot $bot_cnt</span>";
			}
		}
		// www.phpBB-SEO.com SEO TOOLKIT END	
		if ( empty($online_userlist) )
		{
			$online_userlist = $lang['None'];
		}
		$online_userlist = ( ( isset($forum_id) ) ? $lang['Browsing_forum'] : $lang['Registered_users'] ) . ' ' . $online_userlist;

		$total_online_users = $logged_visible_online + $logged_hidden_online + $guests_online;
		// www.phpBB-SEO.com SEO TOOLKIT BEGIN
		$total_online_users += $bot_count;
		// www.phpBB-SEO.com SEO TOOLKIT END 	

		$this->tryUpdateBest($total_online_users);

		if ( $total_online_users == 0 )
		{
			$l_t_user_s = $lang['Online_users_zero_total'];
		}
		else if ( $total_online_users == 1 )
		{
			$l_t_user_s = $lang['Online_user_total'];
		}
		else
		{
			$l_t_user_s = $lang['Online_users_total'];
		}
 
		if ( $logged_visible_online == 0 )
		{
			$l_r_user_s = $lang['Reg_users_zero_total'];
		}
		else if ( $logged_visible_online == 1 )
		{
			$l_r_user_s = $lang['Reg_user_total'];
		}
		else
		{
			$l_r_user_s = $lang['Reg_users_total'];
		}

		if ( $logged_hidden_online == 0 )
		{
			$l_h_user_s = $lang['Hidden_users_zero_total'];
		}
		else if ( $logged_hidden_online == 1 )
		{
			$l_h_user_s = $lang['Hidden_user_total'];
		}
		else
		{
			$l_h_user_s = $lang['Hidden_users_total'];
		}

		if ( $guests_online == 0 )
		{
			$l_g_user_s = $lang['Guest_users_zero_total'];
		}
		else if ( $guests_online == 1 )
		{
			$l_g_user_s = $lang['Guest_user_total'];
		}
		else
		{
			$l_g_user_s = $lang['Guest_users_total'];
		}
		if ( $bot_count == 0 )
		{
			$l_bot = $lang['Bot_nul'];
		}
		else if ( $bot_count == 1 )
		{
			$l_bot = $lang['Bot_one'];
		}
		else
		{
			$l_bot = $lang['Bot_total'];
		}

		$l_online_users = sprintf($l_t_user_s, $total_online_users);
		$l_online_users .= sprintf($l_r_user_s, $logged_visible_online);
		$l_online_users .= sprintf($l_h_user_s, $logged_hidden_online);
		$l_online_users .= sprintf($l_g_user_s, $guests_online);
		$l_online_users .= sprintf($l_bot, $bot_count);
		

		$template->assign_vars(array(
			'TOTAL_USERS_ONLINE' => $l_online_users,
			'LOGGED_IN_USER_LIST' => $online_userlist,
			'BOT_LIST' => $bot_count ? $lang['Bot_online'] . ( ($online_botlist != '') ? $online_botlist : $lang['None']) : '',
		));
	}

	private function tryUpdateBest($total)
	{
		global $board_config, $db;

		if ($total <= $board_config['record_online_users'])
		{
			return;
		}

		$board_config['record_online_users'] = $total_online_users;
		$board_config['record_online_date'] = time();

		$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '$total'
			WHERE config_name = 'record_online_users'";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update online user record (nr of users)', '', __LINE__, __FILE__, $sql);
		}

		$sql = "UPDATE " . CONFIG_TABLE . "
			SET config_value = '" . $board_config['record_online_date'] . "'
			WHERE config_name = 'record_online_date'";
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update online user record (date)', '', __LINE__, __FILE__, $sql);
		}
	}

	private function getBrowserIcon($agent)
	{
		global $images;

        if (false !== strpos($agent, 'firefox')) return ' <img src="' . $images['ff'] . '" alt="Firefox" title="Firefox" border="0" />'; 
        if (false !== strpos($agent, 'phoenix')) return ' <img src="' . $images['phoenix'] . '" alt="Phoenix" title="Phoenix" border="0" />'; 
        if (false !== strpos($agent, 'k-meleon')) return ' <img src="' . $images['kmeleon'] . '" alt="K-Meleon" title="K-Meleon" border="0" />'; 
        if (false !== strpos($agent, 'opera')) return '  <img src="' . $images['opera'] . '" alt="Opera" title="Opera" border="0" />'; 
        if (false !== strpos($agent, 'netscape')) return ' <img src="' . $images['netscape'] . '" alt="Netscape" title="Netscape" border="0" />'; 
        if (false !== strpos($agent, 'safari')) return ' <img src="' . $images['safari'] . '" alt="Safari" title="Safari" border="0" />'; 
        if (false !== strpos($agent, 'msie')) return ' <img src="' . $images['ie'] . '" alt="Internet Explorer" title="Internet Explorer" border="0" />'; 
        if (false !== strpos($agent, 'opera')) {} // opera image
        if (false !== strpos($agent, 'gecko')) return ' <img src="' . $images['mozilla'] . '" alt="Mozilla" title="Mozilla" border="0" />'; 
        if (false !== strpos($agent, 'epiphany')) return ' <img src="' . $images['epiphany'] . '" alt="Epiphany" title="Epiphany" border="0" />'; 
        if (false !== strpos($agent, 'galeon')) return ' <img src="' . $images['galeon'] . '" alt="Galeon" title="Galeon" border="0" />'; 
        if (false !== strpos($agent, 'konqueror')) return  ' <img src="' . $images['konqueror'] . '" alt="Konqueror" title="Konqueror" border="0" />'; 
        if (false !== strpos($agent, 'avant browser')) return ' <img src="' . $images['avantbrowser'] . '" alt="Avant Browser" title="Avant Browser" border="0" />'; 
        if (false !== strpos($agent, 'myie2')) return ' <img src="' . $images['myie'] . '" alt="MyIE2" title="MyIE2" border="0" />'; 
        if (false !== strpos($agent, 'maxthon')) return ' <img src="' . $images['maxthon'] . '" alt="Maxthon" title="Maxthon" border="0" />'; 
        if (false !== strpos($agent, 'crazy browser')) return ' <img src="' . $images['crasybrowser'] . '" alt="Crazy Browser" title="Crazy Browser" border="0" />';          
        if (false !== strpos($agent, 'netcaptor')) return ' <img src="' . $images['netcaptor'] . '" alt="Netcaptor" title="Netcaptor" border="0" />'; 
        if (false !== strpos($agent, 'camino')) return ' <img src="' . $images['camino'] . '" alt="Camino" title="Camino" border="0" />'; 
        return ' ?';
	}

	private function getFetchSql()
	{
		global $forum_id;
		$user_forum_sql = ( !empty($forum_id) ) ? "AND s.session_page = " . intval($forum_id) : '';
		return "SELECT u.username, u.user_flag, u.user_color, u.user_group_id, u.user_id, u.user_allow_viewonline, u.user_level, u.user_gender,
				s.session_logged_in, s.session_ip, s.session_agent
			FROM ".USERS_TABLE." u, ".SESSIONS_TABLE." s
			WHERE u.user_id = s.session_user_id
				AND s.session_time >= ".( time() - 300 ) . "
				$user_forum_sql
			ORDER BY u.username ASC, s.session_ip ASC";	
	}
}