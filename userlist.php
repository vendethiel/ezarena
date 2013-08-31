<?php
/**
*
* @package rank_color_system_mod
* @version $Id: userlist.php,v 0.9 18:21 24/09/2007 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

define('IN_PHPBB', true);
$phpbb_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'userlist';
include($phpbb_root_path . 'common.' . $phpEx);
include($get->url('includes/class_rcs_set'));
include($get->url('includes/bbcode'));
// mod: QTE
include($get->url('includes/class_attributes'));

// start session management
$userdata = session_pagestart($user_ip, PAGE_VIEWMEMBERS);
init_userprefs($userdata);
// end session management

/**
* usr class
*
* This is the main class which contains all common methods
* used by the other classes during the userlist process.
*/
class usr
{
	var $root;
	var $ext;

	var $data;
	var $requester;
	var $parms;

	var $is_admin;
	var $per_page;
	var $total_members;

	var $user_vars;
	var $ranks_done;
	var $ranks_special;
	var $ranks_regular;

	var $user_fields;
	var $count_user_fields;
	var $sort_fields;
	var $order_fields;

	function usr($requester, $parms='')
	{
		global $board_config, $userdata, $phpbb_root_path, $phpEx;

		$this->root = &$phpbb_root_path;
		$this->ext = &$phpEx;

		$this->data = array();

		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;

		$this->is_admin = $userdata['session_logged_in'] && ($userdata['user_level'] == ADMIN);

		$this->per_page = intval($board_config['topics_per_page']);
		$this->total_members = 0;

		$this->user_vars = array();

		$this->ranks_done = false;
		$this->ranks_special = array();
		$this->ranks_regular = array();

		$this->user_fields = array(
			'username',
			'user_session_time',
			'user_lastvisit',
			'user_regdate',
			'user_level',
			'user_posts',
			'user_viewemail',
			'user_allowavatar',
			'user_allow_viewonline',
			'user_rank',
			'user_avatar',
			'user_avatar_type',
			'user_email',
			'user_icq',
			'user_website',
			'user_from',
			'user_sig',
			'user_sig_bbcode_uid',
			'user_aim',
			'user_yim',
			'user_msnm',
			'user_occ',
			'user_interests',
			'user_color',
			'user_group_id',
//-- mod : birthday ------------------------------------------------------------
//-- add
			'user_birthday',
			'user_zodiac',
//-- fin mod : birthday --------------------------------------------------------			
//-- mod : flags ---------------------------------------------------------------
//-- add
			'user_flag',
//-- fin mod : flags -----------------------------------------------------------			
		);

		$this->count_user_fields = count($this->user_fields);

		$this->sort_fields = array(
			'joined' => array('legend' => 'Sort_Joined', 'field' => 'user_regdate'),
			'username' => array('legend' => 'Sort_Username', 'field' => 'username'),
			'location' => array('legend' => 'Sort_Location', 'field' => 'user_from'),
			'posts' => array('legend' => 'Sort_Posts', 'field' => 'user_posts'),
			'email' => array('legend' => 'Sort_Email', 'field' => 'user_email'),
			'website' => array('legend' => 'Sort_Website', 'field' => 'user_website'),
//-- mod : flags ---------------------------------------------------------------
//-- add
			'flag' => array('legend' => 'flag_country', 'field' => 'user_flag'),
//-- fin mod : flags -----------------------------------------------------------			
			'topten' => array('legend' => 'Sort_Top_Ten', 'field' => 'user_posts'),
		);

		$this->order_fields = array(
			'a' => 'Sort_Ascending',
			'd' => 'Sort_Descending',
		);
	}

	function get_order()
	{
		global $common, $rcs;

		$sql_order = array();

		// username search
		$username_search = preg_replace('/\*/', '%', $this->parms['username']);
		$username_validate = !empty($username_search) && (str_replace('%', '', $username_search) != '');

		switch ( $this->parms['sort'] )
		{
			case 'topten':
				$sql_order = array(
					'fields' => 'user_id' . ($this->count_user_fields ? ', ' . implode(', ', $this->user_fields) : ''),
					'order' => $this->sort_fields['topten']['field'] . ' DESC LIMIT 10',
				);
				break;
			default:
				$sql_order = array(
					'fields' => 'user_id' . ($this->count_user_fields ? ', ' . implode(', ', $this->user_fields) : ''),
					'where' => !$username_validate ? '' : 'username LIKE \'' . $common->sql_escape_string($username_search) . '\' AND ',
					'order' => ( empty($this->parms['sort']) ? 'user_regdate' : $this->sort_fields[$this->parms['sort']]['field'] ) . ($this->parms['order'] != 'd' ? '' : ' DESC') . ' LIMIT ' . $this->parms['start'] . ', ' . $this->per_page,
				);
				break;
		}

		if ( !empty($this->parms[RCS_LEVEL_URL]) || !empty($this->parms[RCS_USER_URL]) )
		{
			$sql_order = array_merge($sql_order, array(
				'where' => $sql_order['where'] . ( !empty($this->parms[RCS_LEVEL_URL]) ? 'user_level = ' . intval($this->parms[RCS_LEVEL_URL]) . ' AND ' : ( !empty($this->parms[RCS_USER_URL]) ? 'user_color = ' . intval($this->parms[RCS_USER_URL]) . ' AND ' : '' ) ),
			));
		}
		if ( !empty($this->parms[RCS_GROUP_URL]) )
		{
			$sql_order = array_merge($sql_order, array(
				'fields' => 'u.user_id' . ($this->count_user_fields ? ', u.' . implode(', u.', $this->user_fields) : ''),
				'from' => ' u, ' . GROUPS_TABLE . ' g, ' . USER_GROUP_TABLE . ' ug',
				'where' => 'g.group_color = ' . intval($this->parms[RCS_GROUP_URL]) . '
						AND g.group_id = ug.group_id
						AND ug.user_pending = 0
						AND u.user_id = ug.user_id
						AND ' . $sql_order['where'] . 'u.',
				'group' => ' GROUP BY u.username ',
				'order' => 'u.' . $sql_order['order'],
			));
		}

		return $sql_order;
	}

	function get_user_vars($user_id)
	{
		global $board_config, $userdata, $lang, $images;
		global $rcs, $get;
//-- mod : birthday ------------------------------------------------------------
//-- add
		global $birthday;
//-- fin mod : birthday --------------------------------------------------------		

		if ( !isset($this->user_vars[$user_id]) && isset($this->data[$user_id]) && ($user_id != ANONYMOUS) )
		{
			// rank
			$rank = $this->get_rank($user_id);

			// avatar
			$avatar = $this->get_avatar($user_id);
//-- mod : birthday ------------------------------------------------------------
//-- add
			// birthday
			$birthdays = $birthday->display_details($this->data[$user_id]['user_birthday'], $this->data[$user_id]['user_zodiac'], true);
//-- fin mod : birthday --------------------------------------------------------			
//-- mod : flags ---------------------------------------------------------------
//-- add
			// country flag
			$flag = display_flag($this->data[$user_id]['user_flag'], true);
//-- fin mod : flags -----------------------------------------------------------			

			// buttons
			$buttons['profile'] = array(
				'u' => $get->url($this->requester, array('mode' => 'viewprofile', POST_USERS_URL => $user_id), true),
			);

			$buttons['search_author'] = array(
				'u' => $get->url('search', array('search_author' => $this->data[$user_id]['username'], 'showresults' => 'posts'), true),
				'l' => sprintf($lang['Search_user_posts'], $this->data[$user_id]['username']),
			);

			$online = ($this->data[$user_id]['user_session_time'] < (time() - 300)) ? 0 : ( $this->data[$user_id]['user_allow_viewonline'] ? 1 : ( ($user_id == $userdata['user_id']) || ($userdata['user_level'] == ADMIN) ? 2 : 0 ) );
			$buttons['online'] = array(
				'u' => $get->url('viewonline', '', true),
				'i' => !$online ? $images['icon_offline'] : ($online == 1 ? $images['icon_online'] : $images['icon_hidden']),
				'l' => !$online ? $lang['Offline'] : ($online == 1 ? $lang['Online'] : $lang['Hidden']),
			);

			$buttons['pm'] = array(
				'u' => $get->url('privmsg', array('mode' => 'post', POST_USERS_URL => $user_id), true),
			);

			if ( !empty($this->data[$user_id]['user_viewemail']) || ($userdata['user_level'] == ADMIN) )
			{
				$buttons['email'] = array(
					'u' => $board_config['board_email_form'] ? $get->url('profile', array('mode' => 'email', POST_USERS_URL => $user_id), true) : 'mailto:' . $this->data[$user_id]['user_email'],
				);
			}

			if ( !empty($this->data[$user_id]['user_website']) )
			{
				$buttons['www'] = array(
					'u' => $this->data[$user_id]['user_website'],
				);
			}

			if ( !empty($this->data[$user_id]['user_icq']) )
			{
				$buttons['icq_status'] = array(
					'u' => 'http://wwp.icq.com/' . $this->data[$user_id]['user_icq'] . '#pager',
					'i' => 'http://web.icq.com/whitepages/online?icq=' . $this->data[$user_id]['user_icq'] . '&amp;img=5',
				);

				$buttons['icq'] = array(
					'u' => 'http://wwp.icq.com/scripts/search.dll?to=' . $this->data[$user_id]['user_icq'],
				);
			}

			if ( !empty($this->data[$user_id]['user_aim']) )
			{
				$buttons['aim'] = array(
					'u' => 'aim:goim?screenname=' . $this->data[$user_id]['user_aim'] . '&amp;message=Hello+Are+you+there?',
				);
			}

			if ( !empty($this->data[$user_id]['user_msnm']) )
			{
				$buttons['msn'] = array(
					'u' => $get->url($this->requester, array('mode' => 'viewprofile', POST_USERS_URL => $user_id), true),
				);
			}

			if ( !empty($this->data[$user_id]['user_yim']) )
			{
				$buttons['yim'] = array(
					'u' => 'http://edit.yahoo.com/config/send_webmesg?.target=' . $this->data[$user_id]['user_yim'] . '&amp;.src=pg',
				);
			}

			$this->user_vars[$user_id]['data'] = array(
				'USERNAME' => $this->data[$user_id]['username'],
				'USER_STYLE' => $rcs->get_colors($this->data[$user_id]),
				'USERNAME_STYLED' => $rcs->get_colors($this->data[$user_id], $this->data[$user_id]['username']),
				'USER_FROM' => empty($this->data[$user_id]['user_from']) ? '' : $this->data[$user_id]['user_from'],
				'USER_OCC' => empty($this->data[$user_id]['user_occ']) ? '' : $this->data[$user_id]['user_occ'],
				'USER_INTERESTS' => empty($this->data[$user_id]['user_interests']) ? '' : $this->data[$user_id]['user_interests'],
				'USER_JOINED' => create_date($lang['DATE_FORMAT'], $this->data[$user_id]['user_regdate'], $board_config['board_timezone']),
				'USER_POSTS' => intval($this->data[$user_id]['user_posts']),
				'USER_MSN' => empty($this->data[$user_id]['user_msnm']) ? '' : $this->data[$user_id]['user_msnm'],
//-- mod : birthday ------------------------------------------------------------
//-- add
				'USER_BIRTHDATE' => empty($birthdays) ? '' : $birthdays['birthday'],
				'USER_AGE' => empty($birthdays) ? '' : $birthdays['age'],
				'L_USER_ZODIAC' => empty($birthdays) ? '' : lang_item($birthdays['zodiac']),
				'I_USER_ZODIAC' => empty($birthdays) ? '' : $images[$birthdays['zodiac']],
//-- fin mod : birthday --------------------------------------------------------				
//-- mod : flags ---------------------------------------------------------------
//-- add
				'L_USER_FLAG' => empty($flag) ? '' : $flag['name'],
				'I_USER_FLAG' => empty($flag) ? '' : $flag['img'],
//-- fin mod : flags -----------------------------------------------------------				

				'L_USER_RANK' => empty($rank) ? '' : $rank['txt'],
				'I_USER_RANK' => empty($rank) ? '' : $rank['img'],

				'USER_AVATAR' => $avatar,
			);
			$this->user_vars[$user_id]['switches'] = array(
				'from' => !empty($this->user_vars[$user_id]['data']['USER_FROM']),
				'joined' => !empty($this->user_vars[$user_id]['data']['USER_JOINED']),
				'occupation' => !empty($this->user_vars[$user_id]['data']['USER_OCC']),
				'interests' => !empty($this->user_vars[$user_id]['data']['USER_INTERESTS']),
				'avatar' => !empty($this->user_vars[$user_id]['data']['USER_AVATAR']),
//-- mod : flags ---------------------------------------------------------------
//-- add
				'flag' => !empty($flag),
//-- fin mod : flags -----------------------------------------------------------
//-- mod : birthday ------------------------------------------------------------
//-- add
				'birthday' => !empty($birthdays),
//-- fin mod : birthday --------------------------------------------------------				
				'rank' => !empty($rank),
			);
//-- mod : birthday ------------------------------------------------------------
//-- add
			if ( !empty($birthdays) )
			{
				$this->user_vars[$user_id]['switches'] += array(
					'birthday.zodiac' => !empty($birthdays['zodiac']),
					'birthday.birthcake' => !empty($birthdays['birthcake']),
				);
			}
//-- fin mod : birthday --------------------------------------------------------			
			if ( !empty($rank) )
			{
				$this->user_vars[$user_id]['switches'] += array(
					'rank.img' => !empty($rank['img']),
				);
			}

			if ( !empty($buttons) )
			{
				foreach ( $buttons as $button => $data )
				{
					foreach ( $data as $key => $value )
					{
						$this->user_vars[$user_id]['data'][strtoupper($key . '_' . $button)] = $value;
						$this->user_vars[$user_id]['switches'][$button] = true;
					}
				}
			}
			unset($buttons);
		}

		return $this->user_vars[$user_id];
	}

	function get_rank($user_id)
	{
		global $db;

		if ( !$this->ranks_done )
		{
			$this->ranks_done = true;
			$this->ranks_special = array();
			$this->ranks_regular = array();

			// grab all ranks data
			$sql = 'SELECT rank_id, rank_title, rank_min, rank_special, rank_image
				FROM ' . RANKS_TABLE . '
				ORDER BY rank_special, rank_min';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain ranks information', '', __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				if ( $row['rank_special'] )
				{
					$this->ranks_special[ $row['rank_id'] ] = array('txt' => $row['rank_title'], 'img' => $row['rank_image']);
				}
				else
				{
					$this->ranks_regular[ $row['rank_min'] ] = array('txt' => $row['rank_title'], 'img' => $row['rank_image']);
				}
			}
			$db->sql_freeresult($result);

			// sort regular ranks on descending rank_min
			if ( !empty($this->ranks_regular) )
			{
				@krsort($this->ranks_regular);
			}
		}

		// find the rank
		if ( $this->data[$user_id]['user_rank'] && isset($this->ranks_special[ $this->data[$user_id]['user_rank'] ]) )
		{
			return $this->ranks_special[ $this->data[$user_id]['user_rank'] ];
		}

		if ( !empty($this->ranks_regular) )
		{
			foreach ( $this->ranks_regular as $rank_min => $dummy )
			{
				if ( $this->data[$user_id]['user_posts'] >= $rank_min )
				{
					return $this->ranks_regular[$rank_min];
				}
			}
		}

		return array();
	}

	function get_avatar($user_id)
	{
		global $board_config;

		$avatar = '';
		if ( ($user_id != ANONYMOUS) && $this->data[$user_id]['user_allowavatar'] )
		{
			if ( !empty($this->data[$user_id]['user_avatar']) )
			{
				switch ( $this->data[$user_id]['user_avatar_type'] )
				{
					case USER_AVATAR_UPLOAD:
						$avatar = $board_config['allow_avatar_upload'] ? $board_config['avatar_path'] . '/' . $this->data[$user_id]['user_avatar'] : '';
						break;
					case USER_AVATAR_REMOTE:
						$avatar = $board_config['allow_avatar_remote'] ? $this->data[$user_id]['user_avatar'] : '';
						break;
					case USER_AVATAR_GALLERY:
						$avatar = $board_config['allow_avatar_local'] ? $board_config['avatar_gallery_path'] . '/' . $this->data[$user_id]['user_avatar'] : '';
						break;
				}
			}
		}
		return $avatar;
	}

	function get_signature($message, $bbcode_uid)
	{
		global $board_config, $userdata;

		if ( !empty($message) && $board_config['allow_sig'] )
		{
			// html process
			if ( !$board_config['allow_html'] || !$userdata['user_allowhtml'] )
			{
				$message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);
			}

			// parse bbcode
			if ( $board_config['allow_bbcode'] && $bbcode_uid )
			{
				$message = bbencode_second_pass($message, $bbcode_uid);
			}
			else if ( $bbcode_uid )
			{
				$message = preg_replace('/\:' . $bbcode_uid . '/si', '', $message);
			}

			// magic url
			$message = make_clickable($message);

			// parse smilies
			if ( $board_config['allow_smilies'] )
			{
				$message = smilies_pass($message);
			}

			// censor
			$message = censor_text($message);

			// replace newlines
			$message = str_replace("\n", "\n<br />\n", $message);
		}

		return !$board_config['allow_sig'] ? '' : $message;
	}

	function global_achievement($l_key)
	{
		global $lang, $get;

		$message = $lang[$l_key] . '<br /><br />' . sprintf($lang['click_return_userlist'], '<a href="' . $get->url($this->requester, '', true) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . $get->url('index', '', true) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
}

/**
* usr_list class
*
* This class is used to display registered users and
* allows to sort this list with several criterias.
*/
class usr_list extends usr
{
	var $sql_data;

	function usr_list($requester, $parms='')
	{
		parent::usr($requester, $parms);

		$this->sql_data = array();
	}

	function process()
	{
		$this->init();
		$this->display();
	}

	function init()
	{
		$this->read();
	}

	function read()
	{
		global $db;

		$this->sql_data = $this->get_order();

		$sql = 'SELECT ' . $this->sql_data['fields'] . '
			FROM ' . USERS_TABLE . $this->sql_data['from'] . '
			WHERE ' . $this->sql_data['where'] . 'user_id <> ' . ANONYMOUS
				. ( $this->is_admin ? '' : ' AND user_active = 1' ) . $this->sql_data['group'] . '
			ORDER BY ' . $this->sql_data['order'];
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain userlist data', '', __LINE__, __FILE__, $sql);
		}

		$this->data = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$user_id = intval($row['user_id']);

			$fields = array('user_id' => $user_id);
			foreach ( $this->user_fields as $user_fields => $user_field )
			{
				$fields += array_merge($fields, array(
					$user_field => $row[$user_field],
				));
			}

			// allowed
			$this->data[$user_id] = $fields;
		}
		$db->sql_freeresult($result);

		// get total members
		if ( !empty($this->data) )
		{
			$this->get_total_members();
		}

		// unset some vars
		unset($fields);
		$this->sql_data = array();
	}

	function get_total_members()
	{
		global $db;

		if ( $this->parms['sort'] != 'topten' )
		{
			$sql = 'SELECT COUNT(DISTINCT ' . ( empty($this->sql_data['from']) ? '' : 'u.' ) . 'user_id) AS total_users
				FROM ' . USERS_TABLE . $this->sql_data['from'] . '
				WHERE ' . $this->sql_data['where'] . 'user_id <> ' . ANONYMOUS
					. ( $this->is_admin ? '' : ' AND user_active = 1' );
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
			}
			while ($row = $db->sql_fetchrow($result))
			{
				$this->total_members = $row['total_users'];
			}
			$db->sql_freeresult($result);
		}
	}

	function display()
	{
		global $template, $lang, $images, $theme;
		global $get, $rcs, $set;

		// display username search
		$username_search = preg_replace('/\*/', '%', $this->parms['username']);
		$username_validate = !empty($username_search) && (str_replace('%', '', $username_search) != '');

		// display sort method
		$select_sort = '';
		foreach ( $this->sort_fields as $sort_fields => $sort )
		{
			$selected = ( $this->parms['sort'] == $sort_fields ) ? ' selected="selected"' : '';
			$select_sort .= '<option value="' . $sort_fields . '"' . $selected . '>' . $lang[ $sort['legend'] ] . '</option>';
		}

		// display order method
		$select_order = '';
		foreach ( $this->order_fields as $order_fields => $order )
		{
			$selected = ( $this->parms['order'] == $order_fields ) ? ' selected="selected"' : '';
			$select_order .= '<option value="' . $order_fields . '"' . $selected . '>' . $lang[ $order ] . '</option>';
		}

		// let's display the list
		$count_data = count($this->data);
		if ( $count_data > 0 )
		{
			$i = 0;
			$throw = false;
			foreach ( $this->data as $rows => $row )
			{
				$throw = !$throw;

				$user_blocks = $this->get_user_vars($row['user_id']);
				$switches = empty($user_blocks['switches']) ? array() : $user_blocks['switches'];
				$user_block_vars = empty($user_blocks['data']) ? array() : $user_blocks['data'];
				unset($user_blocks);

				// build final tpl_vars
				$tpl_vars = array_merge($user_block_vars, array(
					'ROW_NUMBER' => $i + ( $this->parms['start'] + 1 ),
					'ROW_COLOR' => $throw ? '#' . $theme['td_color1'] : '#' . $theme['td_color2'],
					'ROW_CLASS' => $throw ? $theme['td_class1'] : $theme['td_class2'],
				));
				unset($user_block_vars);

				// send to template
				$template->assign_block_vars('usrlist', $tpl_vars);

				// build user switches
				if ( !empty($switches) )
				{
					foreach ( $switches as $key => $value )
					{
						$get->assign_switch('usrlist.' . $key, $value);
					}
				}
				$i++;
			}
		}
		else
		{
			$get->assign_switch('empty', true);
		}

		// constants
		$template->assign_vars(array(
			'USERNAME' => !$username_validate ? '' : $this->parms['username'],

			'I_VIEWPROFILE' => $images['icon_profile'],
			'L_VIEWPROFILE' => $lang['Read_profile'],
			'I_USER_SEARCH' => $images['icon_search'],
			'I_USER_PM' => $images['icon_pm'],
			'L_USER_PM' => $lang['Send_private_message'],
			'I_USER_EMAIL' => $images['icon_email'],
			'L_USER_EMAIL' => $lang['Send_email'],
			'I_USER_WWW' => $images['icon_www'],
			'L_USER_WWW' => $lang['Visit_website'],
			'I_USER_AIM' => $images['icon_aim'],
			'L_USER_AIM' => $lang['AIM'],
			'I_USER_ICQ' => $images['icon_icq'],
			'L_USER_ICQ' => $lang['ICQ'],
			'I_USER_MSN' => $images['icon_msnm'],
			'L_USER_MSN' => $lang['MSNM'],
			'I_USER_YIM' => $images['icon_yim'],
			'L_USER_YIM' => $lang['YIM'],

			'S_SORT_SELECT' => $select_sort,
			'S_ORDER_SELECT' => $select_order,
		));
		$get->assign_switch('nav_links', true);

		// pagination
		$set->pagination($this->requester, array_merge($this->parms, array('start' => 0)), $this->total_members, $this->per_page, $this->parms['start'], 'users_count');

		// send to template
		$template->set_filenames(array('body' => 'userlist_body.tpl'));
	}
}

/**
* usr_groups class
*
* This class is used to show the informations for the selected usergroup.
*/
class usr_groups extends usr
{
	var $gdata;
	var $groupid;

	var $display;

	function usr_groups($requester, $parms='')
	{
		parent::usr($requester, $parms);

		$this->gdata = array();
		$this->groupid = 0;
		$this->display = !_butt('change_default');
	}

	function process()
	{
		$this->init();
		$this->check();

		if ( !empty($this->groupid) )
		{
			$this->validate();
			$this->display();
		}
	}

	function init()
	{
		$this->parms['groupid'] = request_var(POST_GROUPS_URL, TYPE_INT);
		$this->parms['members'] = request_var('members', TYPE_INT);

		// grab usergroup details
		if ( !empty($this->parms['groupid']) )
		{
			$this->read();
		}
	}

	function check()
	{
		// no selected group, show the main page
		if ( empty($this->groupid) )
		{
			$this->display_select();
		}
	}

	function validate()
	{
		global $rcs;

		// change default group for the selected users
		if ( _butt('change_default') )
		{
			$l_key = empty($this->is_admin) ? 'not_admin_of_board' : 'no_users_selected';
			if ( $this->is_admin && !empty($this->parms['members']) )
			{
				$sql_in = '';
				$l_key = 'already_default_group';
				foreach ( $this->parms['members'] as $member_id )
				{
					if ( $this->data[$member_id]['user_group_id'] != $this->groupid )
					{
						$sql_in .= ( !empty($sql_in) ? ', ' : '' ) . intval($member_id);
					}
				}

				if ( !empty($sql_in) )
				{
					$rcs->update_user_group_id($sql_in, $this->groupid, true, $this->groupid);
					$l_key = 'changed_default_group';
				}

			}
			$this->_achievement($l_key);
		}
	}

	function _achievement($l_key)
	{
		global $lang, $get;

		$message = $lang[$l_key] . '<br /><br />' . sprintf($lang['click_return_usergroup'], '<a href="' . $get->url($this->requester, array('mode' => 'groups', POST_GROUPS_URL => $this->groupid), true) . '">', '</a>') . '<br /><br />' . sprintf($lang['click_return_userlist'], '<a href="' . $get->url($this->requester, '', true) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}

	function read()
	{
		global $db;

		// get group information and moderator details
		$sql = 'SELECT g.group_id, g.group_type, g.group_name, g.group_description, g.group_moderator, g.group_color, u.user_id' . ($this->count_user_fields ? ', u.' . implode(', u.', $this->user_fields) : '') . '
			FROM ' . GROUPS_TABLE . ' g
				LEFT JOIN ' . USERS_TABLE . ' u
					ON u.user_id = g.group_moderator
			WHERE g.group_id = ' . intval($this->parms['groupid']) . '
				AND g.group_single_user = 0';
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error getting group information', '', __LINE__, __FILE__, $sql);
		}

		$this->data = array();
		$this->gdata = array();
		$fields = array();
		$members_row = array();
		while ($grow = $db->sql_fetchrow($result))
		{
			$this->groupid = intval($grow['group_id']);

			$fields['group'] = array(
				'group_id' => $grow['group_id'],
				'group_type' => $grow['group_type'],
				'group_name' => $grow['group_name'],
				'group_desc' => $grow['group_description'],
				'group_color' => $grow['group_color'],
				'group_moderator' => $grow['group_moderator'],
			);

			$mod_id = intval($grow['user_id']);
			$fields['mod'] = array('user_id' => $mod_id);
			foreach ( $this->user_fields as $user_fields => $user_field )
			{
				$fields['mod'] += array_merge($fields['mod'], array(
					$user_field => $grow[$user_field],
				));
			}

			// allowed
			$this->gdata[$this->groupid] = $fields['group'];
		}
		$db->sql_freeresult($result);

		if ( !empty($this->groupid) )
		{
			// get members details for this group
			$sql = 'SELECT u.user_id' . ($this->count_user_fields ? ', u.' . implode(', u.', $this->user_fields) : '') . '
				FROM ' . USERS_TABLE . ' u, ' . USER_GROUP_TABLE . ' ug
				WHERE ug.group_id = ' . $this->groupid . '
					AND u.user_id = ug.user_id
					AND ug.user_pending = 0
					AND ug.user_id <> ' . $mod_id . '
				ORDER BY u.username
				LIMIT ' . intval($this->parms['start']) . ', ' . $this->per_page;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting usergroup data', '', __LINE__, __FILE__, $sql);
			}

			while ($row = $db->sql_fetchrow($result))
			{
				$user_id = intval($row['user_id']);
				$fields['user'] = array('user_id' => $user_id);
				foreach ( $this->user_fields as $user_fields => $user_field )
				{
					$fields['user'] += array_merge($fields['user'], array(
						$user_field => $row[$user_field],
					));
				}

				// allowed
				$members_row[$user_id] = $fields['user'];
			}
			$db->sql_freeresult($result);

			// final result
			$this->data = array($mod_id => $fields['mod']) + $members_row;

			// get total members
			if ( !empty($members_row) && $this->display )
			{
				$this->get_total_members($mod_id);
			}

			// unset some vars
			unset($fields, $members_row);
		}
	}

	function get_total_members($mod_id)
	{
		global $db;

		$sql = 'SELECT COUNT(DISTINCT u.user_id) AS total_users
			FROM ' . USERS_TABLE . ' u, ' . USER_GROUP_TABLE . ' ug
			WHERE ug.group_id = ' . $this->groupid . '
				AND u.user_id = ug.user_id
				AND ug.user_pending = 0
				AND ug.user_id <> ' . intval($mod_id);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
		}
		while ($row = $db->sql_fetchrow($result))
		{
			$this->total_members = $row['total_users'];
		}
		$db->sql_freeresult($result);
	}

	function display_select()
	{
		global $template, $lang, $images, $images;
		global $get, $rcs, $set, $navigation;

		// get usergroups list
		$items = $set->get_usergroups_list();

		// let's go
		if ( !empty($items) )
		{
			// build groups list
			$groups_list = array('name' => POST_GROUPS_URL, 'items' => $items);
			$rcs->constructor($groups_list);
			unset($items);

			// constants
			$template->assign_vars(array(
				'L_USERGROUPS' => $lang['usergroups_list'],
				'L_SELECT_USERGROUP' => $lang['select_usergroup'],
				'L_SELECT_USERGROUP_DETAILS' => $lang['select_usergroup_details'],
				'L_VIEW_INFORMATION' => $lang['View_Information'],
	
				'I_SUBMIT' => $images['cmd_submit'],
	
				'S_USERGROUP_ACTION' => $get->url($this->requester, array('mode' => 'groups'), true),
			));

			// navigation
			$navigation->add('groups', 'groups', $this->requester, array('mode' => 'groups'));

			// send to template
			$template->set_filenames(array('body' => 'groupcp_select_body.tpl'));
		}
		else
		{
			$this->global_achievement('No_groups_exist');
		}
	}

	function display()
	{
		global $template, $lang, $images, $theme;
		global $get, $rcs, $set, $navigation;

		// let's go
		if ( !empty($this->gdata[$this->groupid]) )
		{
			$throw = false;
			$count['members'] = 0;
			$only_moderator = false;
			foreach ( $this->data as $rows => $row )
			{
				$is_moderator = ($row['user_id'] == $this->gdata[$this->groupid]['group_moderator']);
				$throw = ($count['members'] == 1) ? $throw : !$throw;

				$user_blocks = $this->get_user_vars($row['user_id']);
				$switches = empty($user_blocks['switches']) ? array() : $user_blocks['switches'];
				$user_block_vars = empty($user_blocks['data']) ? array() : $user_blocks['data'];
				unset($user_blocks);

				// build final tpl_vars
				$tpl_vars = array_merge($user_block_vars, array(
					'USER_ID' => $row['user_id'],
					'ROW_COLOR' => $throw ? '#' . $theme['td_color1'] : '#' . $theme['td_color2'],
					'ROW_CLASS' => $throw ? $theme['td_class1'] : $theme['td_class2'],
				));
				unset($user_block_vars);

				// send to template
				$template->assign_block_vars('membership', $tpl_vars);
				$get->assign_switch('membership.select', $this->is_admin);

				// build user switches
				if ( !empty($switches) )
				{
					foreach ( $switches as $key => $value )
					{
						$get->assign_switch('membership.' . $key, $value);
					}
				}
				$count['members']++;

				if ( $is_moderator || $count['members'] == 2 )
				{
					$only_moderator = !$only_moderator;
					$template->assign_block_vars('membership.header', array(
						'L_HEADER' => $is_moderator ? $lang['Group_Moderator'] : $lang['Group_Members'],
					));
					$get->assign_switch('membership.header.select', $this->is_admin);
				}
			}

			// group type
			switch ( $this->gdata[$this->groupid]['group_type'] )
			{
				case GROUP_OPEN:
					$l_group_type = 'open';
				break;

				case GROUP_CLOSED:
					$l_group_type = 'closed';
				break;

				case GROUP_HIDDEN:
					$l_group_type = 'hidden';
				break;
			}

			// constants
			$template->assign_vars(array(
				'GROUP_NAME' => $rcs->get_group_class($this->groupid, $this->gdata[$this->groupid]['group_name']),
				'GROUP_DESC' => $this->gdata[$this->groupid]['group_desc'],
				'GROUP_TYPE' => $lang['group_is_' . $l_group_type],

				'L_GROUP_INFORMATION' => $lang['Group_Information'],
				'L_GROUP_NAME' => $lang['Group_name'],
				'L_GROUP_DESC' => $lang['Group_description'],
				'L_SELECT' => $lang['Select'],
				'L_GROUP_MEMBERSHIP' => $lang['Group_Members'],
				'L_NO_MEMBERS' => $lang['No_group_members'],

				'I_VIEWPROFILE' => $images['icon_profile'],
				'L_VIEWPROFILE' => $lang['Read_profile'],
				'I_USER_SEARCH' => $images['icon_search'],
				'I_USER_PM' => $images['icon_pm'],
				'L_USER_PM' => $lang['Send_private_message'],
				'I_USER_EMAIL' => $images['icon_email'],
				'L_USER_EMAIL' => $lang['Send_email'],
				'I_USER_WWW' => $images['icon_www'],
				'L_USER_WWW' => $lang['Visit_website'],
				'I_USER_AIM' => $images['icon_aim'],
				'L_USER_AIM' => $lang['AIM'],
				'I_USER_ICQ' => $images['icon_icq'],
				'L_USER_ICQ' => $lang['ICQ'],
				'I_USER_MSN' => $images['icon_msnm'],
				'L_USER_MSN' => $lang['MSNM'],
				'I_USER_YIM' => $images['icon_yim'],
				'L_USER_YIM' => $lang['YIM'],

				'I_SUBMIT' => $images['cmd_submit'],

				'L_CHANGE_DEFAULT' => $lang['change_default_group'],
				'L_MARK_ALL' => $lang['Mark_all'],
				'L_UNMARK_ALL' => $lang['Unmark_all'],

				'S_GROUP_ACTION' => $get->url($this->requester, array('mode' => 'groups', POST_GROUPS_URL => $this->groupid), true),
			));

			// switchs
			$get->assign_switch('select', $this->is_admin);
			$get->assign_switch('no_membership', $only_moderator);
			if ( $only_moderator )
			{
				$get->assign_switch('no_membership.select', $this->is_admin);
			}

			// navigation
			$navigation->add('groups', 'groups', $this->requester, array('mode' => 'groups'));
			$navigation->add($this->gdata[$this->groupid]['group_name'], $this->gdata[$this->groupid]['group_desc'], $this->requester, array('mode' => 'groups', POST_GROUPS_URL => $this->groupid));

			// pagination
			$set->pagination($this->requester, array('mode' => 'groups', POST_GROUPS_URL => $this->groupid), $this->total_members, $this->per_page, $this->parms['start'], 'users_count');

			// send the display
			$template->set_filenames(array('body' => 'userlist_group.tpl'));
		}
		else
		{
			$this->global_achievement('No_groups_exist');
		}
	}
}

/**
* usr_leaders class
*
* This class is used to display a listing of board admins, moderators.
*/
class usr_leaders extends usr
{
	var $gdata;

	var $forums;
	var $fmoderator;
	var $undisclosed_forum;

	function usr_leaders($requester)
	{
		parent::usr($requester);

		$this->gdata = array();
		$this->forums = array();
		$this->fmoderator = array();
		$this->undisclosed_forum = array();
	}

	function process()
	{
		$this->init();
		$this->display();
	}

	function init()
	{
		$this->read();
	}

	function read()
	{
		global $db, $userdata;

		// get administrators and moderators details
		$sql = 'SELECT g.group_id, g.group_type, g.group_name, u.user_id' . ($this->count_user_fields ? ', u.' . implode(', u.', $this->user_fields) : '') . '
			FROM ' . USERS_TABLE . ' u
				LEFT JOIN ' . GROUPS_TABLE . ' g
					ON g.group_id = u.user_group_id
			WHERE u.user_level IN (' . MOD . ', ' . ADMIN . ')
			GROUP BY u.user_id
			ORDER BY u.user_level, u.username';
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain leaders data', '', __LINE__, __FILE__, $sql);
		}

		$cnt_moderators = 0;
		$this->data = array();
		$this->gdata = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$user_id = intval($row['user_id']);

			$fields = array('user_id' => $user_id);
			foreach ( $this->user_fields as $user_fields => $user_field )
			{
				$fields += array_merge($fields, array(
					$user_field => $row[$user_field],
				));
			}

			// allowed
			$this->data[$user_id] = $fields;

			// default group
			if ( !empty($row['group_id']) )
			{
				$group_allowed = ( $row['group_type'] != GROUP_HIDDEN || $userdata['user_id'] == $row['user_id'] || $userdata['user_level'] == ADMIN );
				$this->gdata[$user_id] = empty($group_allowed) ? array('undisclosed' => true) : array(
					'group_id' => $row['group_id'],
					'group_name' => $row['group_name'],
				);
			}

			// count moderators
			if ( $row['user_level'] == MOD )
			{
				$cnt_moderators++;
			}
		}
		$db->sql_freeresult($result);

		// unset some vars
		unset($fields);

		if ( !empty($cnt_moderators) )
		{
			// obtain list of forums moderate by each moderator
			$sql = 'SELECT f.forum_id, f.forum_name, f.auth_view, ug.user_id
				FROM ' . AUTH_ACCESS_TABLE . ' aa, ' . FORUMS_TABLE . ' f, ' . USER_GROUP_TABLE . ' ug
				WHERE aa.auth_mod = 1
					AND ug.group_id = aa.group_id
					AND f.forum_id = aa.forum_id
				GROUP BY aa.forum_id, ug.user_id
				ORDER BY aa.forum_id, ug.user_id';
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query forum moderator information', '', __LINE__, __FILE__, $sql);
			}

			$forum_id = 0;
			$forum_data = array();
			$this->forums = array();
			$forum_moderator = array();
			while ($row = $db->sql_fetchrow($result))
			{
				if ( $this->data[ $row['user_id'] ]['user_level'] == MOD )
				{
					$forum_moderator[ $row['forum_id'] ][ $row['user_id'] ] = true;

					if ( $forum_id != $row['forum_id'] )
					{
						$forum_data[] = array(
							'forum_id' => $row['forum_id'],
							'auth_view' => $row['auth_view'],
						);
						$forum_id = $row['forum_id'];
					}
				}
				$this->forums[ $row['forum_id'] ] = $row['forum_name'];
			}
			$db->sql_freeresult($result);

			$this->fmoderator = array();
			$this->undisclosed_forum = array();
			if ( !empty($forum_moderator) )
			{
				$forum_view_ary = auth(AUTH_VIEW, AUTH_LIST_ALL, $userdata, $forum_data);
				foreach ( $forum_view_ary as $forum_id => $allowed )
				{
					foreach ( $forum_moderator[$forum_id] as $mod_id => $in_mod )
					{
						if ( $allowed['auth_view'] && $in_mod )
						{
							$this->fmoderator[$mod_id][$forum_id] = $this->forums[$forum_id];
						}
						else
						{
							$this->fmoderator[$mod_id][$forum_id] = false;
							$this->undisclosed_forum[$mod_id] = true;
						}
					}
				}
				unset($forum_moderator, $forum_data, $forum_view_ary);
			}
		}
	}

	function display()
	{
		global $template, $lang, $images, $theme;
		global $get, $rcs, $set, $navigation;

		// let's display the list
		$count_data = count($this->data);
		if ( $count_data > 0 )
		{
			$throw = false;
			$block_header_sent = false;
			$count = array('admin' => 0, 'mod' => 0);
			foreach ( $this->data as $rows => $row )
			{
				$throw = ( $block_header_sent && ($current_level != $row['user_level']) ) ? true : !$throw;

				$user_blocks = $this->get_user_vars($row['user_id']);
				$switches = empty($user_blocks['switches']) ? array() : $user_blocks['switches'];
				$user_block_vars = empty($user_blocks['data']) ? array() : $user_blocks['data'];
				unset($user_blocks);

				// display list of moderate forums
				$s_forum_select = $lang['all_forums'];
				if ( $this->fmoderator[ $row['user_id'] ] && sizeof(array_diff(array_keys($this->forums), array_keys($this->fmoderator[ $row['user_id'] ]))) )
				{
					$s_forum_select = '<select style="width:200px;">';
					$s_forum_option = '';
					foreach ( $this->fmoderator[ $row['user_id'] ] as $fid => $fname )
					{
						if ( !empty($fname) )
						{
							$s_forum_option .= '<option value="">' . $fname . '</option>';
						}
					}
					$s_forum_select .= $s_forum_option . '</select>';

					// only moderate hidden forums
					if ( !$s_forum_option && $this->undisclosed_forum[ $row['user_id'] ] )
					{
						$s_forum_select = $lang['forum_undisclosed'];
					}
				}

				// build final tpl_vars
				$tpl_vars = array_merge($user_block_vars, array(
					'ROW_COLOR' => $throw ? '#' . $theme['td_color1'] : '#' . $theme['td_color2'],
					'ROW_CLASS' => $throw ? $theme['td_class1'] : $theme['td_class2'],
					'L_GROUP_UNDISCLOSED' => !empty($this->gdata[$row['user_id']]['undisclosed']) ? $lang['group_undisclosed'] : $lang['None'],
					'S_FORUM_SELECT' => $s_forum_select,
				));
				unset($user_block_vars);

				// send to template
				$template->assign_block_vars('leadership', $tpl_vars);
				$get->assign_switch('leadership.moderate_forums', !empty($this->fmoderator[ $row['user_id'] ]));
				$get->assign_switch('leadership.spacing', $block_header_sent && ($current_level != $row['user_level']));

				// build user switches
				if ( !empty($switches) )
				{
					foreach ( $switches as $key => $value )
					{
						$get->assign_switch('leadership.' . $key, $value);
					}
				}

				// default group
				if ( !empty($this->gdata[$row['user_id']]['group_id']) )
				{
					$template->assign_block_vars('leadership.default_group', array(
						'GROUP_NAME' => $this->gdata[$row['user_id']]['group_name'],
						'GROUP_STYLE' => $rcs->get_group_class($this->gdata[$row['user_id']]['group_id']),
						'U_GROUP' => $get->url($this->requester, array('mode' => 'groups', POST_GROUPS_URL => $this->gdata[$row['user_id']]['group_id']), true),
					));
				}
				$count[ $row['user_level'] == ADMIN ? 'admin' : 'mod' ]++;

				// block header
				if ( !$block_header_sent || ($current_level != $row['user_level']) )
				{
					$template->assign_block_vars('leadership.header', array(
						'L_HEADER' => $row['user_level'] == ADMIN ? $lang['Administrators'] : $lang['Moderators'],
					));
					$block_header_sent = true;
					$current_level = $row['user_level'];
				}
			}
		}
		else
		{
			$get->assign_switch('empty', true);
		}

		// constants
		$template->assign_vars(array(
			'L_ADMINISTRATORS' => $lang['Administrators'],
			'L_NO_ADMINISTRATORS' => $lang['no_administrators'],
			'L_MODERATORS' => $lang['Moderators'],
			'L_NO_MODERATORS' => $lang['no_moderators'],

			'L_MODERATE_FORUMS' => $lang['moderate_forums'],
			'L_PRIMARY_GROUP' => $lang['primary_group'],

			'L_VIEWPROFILE' => $lang['Read_profile'],
			'I_USER_PM' => $images['icon_pm'],
			'L_USER_PM' => $lang['Send_private_message'],
			'I_USER_EMAIL' => $images['icon_email'],
			'L_USER_EMAIL' => $lang['Send_email'],
		));

		// switchs
		$get->assign_switch('no_administrators', empty($count['admin']));
		$get->assign_switch('no_moderators', empty($count['mod']));

		// navigation
		$navigation->add('the_team', 'the_team', $this->requester, array('mode' => 'leaders'));

		// send to template
		$template->set_filenames(array('body' => 'userlist_leaders.tpl'));
	}
}

/**
* usr_details class
*
* This class is used to display a profile.
*/
class usr_details extends usr
{
	var $userid;

	function usr_details($requester)
	{
		parent::usr($requester);

		$this->userid = 0;
	}

	function process()
	{
		$this->init();
		$this->check();

		if ( !empty($this->userid) )
		{
			$this->validate();
			$this->display();
		}
	}

	function init()
	{
		$this->userid = 0;
		$this->parms = array(
			'userid' => request_var(POST_USERS_URL, TYPE_INT),
			'rcs_rank' => request_var('rcs_rank', TYPE_INT),
		);

		// grab user details
		if ( !empty($this->parms['userid']) || $this->parms['userid'] != ANONYMOUS )
		{
			$this->read();
		}
	}

	function check()
	{
		// check if user exists
		if ( empty($this->userid) )
		{
			$this->global_achievement('No_user_id_specified');
		}
	}

	function validate()
	{
		global $rcs;

		// change individual rank color
		if ( _butt('change_individual') )
		{
			$l_key = empty($this->is_admin) ? 'not_admin_of_board' : 'option_assigned_user';
			if ( $this->is_admin && ($this->data[$this->userid]['user_color'] != $this->parms['rcs_rank']) )
			{
				// update user color field
				$rcs->update_colors($this->data[$this->userid]['user_id'], true, intval($this->parms['rcs_rank']));

				$l_key = empty($this->parms['rcs_rank']) ? 'removed_individual_rank' : 'changed_individual_rank';
			}
			$this->_achievement($l_key);
		}
	}

	function _achievement($l_key)
	{
		global $lang, $get;

		$message = $lang[$l_key] . '<br /><br />' . sprintf($lang['click_return_viewprofile'], '<a href="' . $get->url($this->requester, array('mode' => 'viewprofile', POST_USERS_URL => $this->userid), true) . '">', '</a>') . '<br /><br />' . sprintf($lang['click_return_userlist'], '<a href="' . $get->url($this->requester, '', true) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}

	function read()
	{
		global $db;

		$sql = 'SELECT user_id' . ($this->count_user_fields ? ', ' . implode(', ', $this->user_fields) : '') . '
			FROM ' . USERS_TABLE . '
			WHERE user_id = ' . intval($this->parms['userid']);
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Tried obtaining data for a non-existent user', '', __LINE__, __FILE__, $sql);
		}

		$this->data = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$this->userid = intval($row['user_id']);
			$this->data[$this->userid] = $row;
		}
		$db->sql_freeresult($result);
	}

	function display()
	{
		global $template, $lang, $images, $theme, $board_config;
		global $get, $rcs, $set, $navigation, $qte;

		display_upload_attach_box_limits($this->userid);


		// let's go
		if ( !empty($this->data[$this->userid]) )
		{
			$user_blocks = $this->get_user_vars($this->userid);
			$switches = empty($user_blocks['switches']) ? array() : $user_blocks['switches'];
			$user_block_vars = empty($user_blocks['data']) ? array() : $user_blocks['data'];
			unset($user_blocks);

			// user activity
			$userstats = array(
				'regdate' => $this->data[$this->userid]['user_regdate'],
				'posts' => $this->data[$this->userid]['user_posts'],
				'session_time' => $this->data[$this->userid]['user_session_time'],
				'lastvisit' => $this->data[$this->userid]['user_lastvisit'],
				'viewonline' => $this->data[$this->userid]['user_allow_viewonline'],
			);
			$set->display_user_activity($this->userid, $userstats);

			// signature
			$user_sig = $this->data[$this->userid]['user_sig'];
			$user_sig = $this->get_signature($user_sig, $this->data[$this->userid]['user_sig_bbcode_uid']);

			// ranks color
			if ( $this->is_admin )
			{
				$rcs->select_colors($this->data[$this->userid]['user_color'], true);
			}

			if ( $board_config['Adr_profile_display'] ) 
			{
				$this->do_adr_profile();
			} 

			// build final tpl_vars
			$tpl_vars = array_merge($user_block_vars, array(
				'L_AVATAR' => $lang['Avatar'],
				'L_PROFILE' => $lang['Profile'],
				'L_CONTACT' => $lang['Contact'],
				'L_USER_STATS' => $lang['user_statistics'],
				'L_SIGNATURE' => $lang['Signature'],
				'L_RANK_COLOR' => $lang['rcs_rank'],

				'I_MINI_SUBMIT' => $images['cmd_mini_submit'],
				'L_CHANGE_INDIVIDUAL' => $lang['change_individual_rank'],

				'I_USER_PM' => $images['icon_pm'],
				'L_USER_PM' => $lang['Send_private_message'],
				'I_USER_EMAIL' => $images['icon_email'],
				'L_USER_EMAIL' => $lang['Send_email'],
				'I_USER_WWW' => $images['icon_www'],
				'L_USER_WWW' => $lang['Visit_website'],
				'I_USER_AIM' => $images['icon_aim'],
				'L_USER_AIM' => $lang['AIM'],
				'I_USER_ICQ' => $images['icon_icq'],
				'L_USER_ICQ' => $lang['ICQ'],
				'I_USER_MSN' => $images['icon_msnm'],
				'L_USER_MSN' => $lang['MSNM'],
				'I_USER_YIM' => $images['icon_yim'],
				'L_USER_YIM' => $lang['YIM'],

				'SIGNATURE' => $user_sig,

				'U_RABBITOSHI' => append_sid("rabbitoshi.$phpEx?" . POST_USERS_URL . "=" . $this->userid),
				'L_RABBITOSHI' => $lang['Rabbitoshi_topic'],

				'S_PROFILE_ACTION' => $get->url($this->requester, array('mode' => 'viewprofile', POST_USERS_URL => $this->userid), true),
			));
			unset($user_block_vars);

			// constants
			$template->assign_vars($tpl_vars);

			// build user switches
			$get->assign_switch('user_is_admin', $this->is_admin);
			$get->assign_switch('signature', !empty($user_sig));
			if ( !empty($switches) )
			{
				foreach ( $switches as $key => $value )
				{
					$get->assign_switch($key, $value);
				}
			}

			// navigation
			$navigation->add($this->data[$this->userid]['username'], 'Read_profile', $this->requester, array('mode' => 'viewprofile', POST_USERS_URL => $this->userid));

			// Mod groups on profile
			$this->display_groups();

			// send to template
			$template->set_filenames(array('body' => 'userlist_view.tpl'));
		}
		else
		{
			$this->global_achievement('No_user_id_specified');
		}
	}

	function do_adr_profile()
	{
		// V: having adr_constants just makes it painful ;_;
		global $phpbb_root_path, $phpEx, $board_config, $table_prefix;
		global $lang, $template, $db;

		define ( 'IN_ADR_CHARACTER' , true ); 
		define ( 'IN_ADR_SHOPS' , true ); 
		define ( 'IN_ADR_SKILLS' , true ); 
		define ( 'IN_ADR_BATTLE' , true ); 
		include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx); 

		// Get the general config 
		$adr_general = adr_get_general_config(); 
		$searchid = $this->userid; 


		$sql = "SELECT c.* , r.race_name , r.race_img , r.race_weight , r.race_weight_per_level , e.element_name , e.element_img , a.alignment_name , a.alignment_img , cl.class_name , cl.class_img , cl.class_update_xp_req 
			FROM  " . ADR_CHARACTERS_TABLE . " c , " . ADR_RACES_TABLE . " r , " . ADR_ELEMENTS_TABLE . " e , " . ADR_ALIGNMENTS_TABLE . " a , " . ADR_CLASSES_TABLE . " cl 
			WHERE c.character_id= $searchid 
			AND cl.class_id = c.character_class 
			AND r.race_id = c.character_race 
			AND e.element_id = c.character_element 
			AND a.alignment_id = c.character_alignment "; 
		if ( !($result = $db->sql_query($sql)) ) 
		{ 
			message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
		}	 
		$row = $db->sql_fetchrow($result); 

		if (is_numeric($row['character_class']))
		{ 
			$template->assign_block_vars( 'adr_profile' , array(
				'U_RPG_CHAR' => append_sid("adr_character.$phpEx?" . POST_USERS_URL . "=" . $this->userid),
				'CHAR_NAME' => $row['character_name'],
			));
		}
	}

	function display_groups()
	{
		global $get, $db, $template, $rcs;

		$user_id = $this->userid;
		$view_user_id = $user_id; //$this->userid;
		$groups = array();
		$sql = '
			SELECT 
				g.group_id, 
				g.group_name, 
				g.group_description, 
				g.group_type 
			FROM 
				'.USER_GROUP_TABLE.' as l, 
				'.GROUPS_TABLE.' as g 
			WHERE 
				l.user_pending = 0 AND 
				g.group_single_user = 0 AND 
				l.user_id ='. $view_user_id.' AND 
				g.group_id = l.group_id 
			ORDER BY 
				g.group_name, 
				g.group_id';
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not read groups', '', __LINE__, __FILE__, $sql);	
		}
		while ($group = $db->sql_fetchrow($result))
		{
			$groups[] = $group;
		}

		$template->assign_var('HAS_GROUP', !!count($groups));
		if (count($groups))
		{
			for ($i=0; $i < count($groups); $i++)
			{
				$is_ok = false;
				//
				// groupe invisible ?
				if ( ($groups[$i]['group_type'] != GROUP_HIDDEN) || ($userdata['user_level'] == ADMIN) )
				{
					$is_ok=true;
				}
				else
				{
					$group_id = $groups[$i]['group_id'];
					$sql = 'SELECT * FROM '.USER_GROUP_TABLE.' WHERE group_id='.$group_id.' AND user_id='.$user_id.' AND user_pending=0';
					if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, 'Couldn\'t obtain viewer group list', '', __LINE__, __FILE__, $sql);
					$is_ok = ( $group = $db->sql_fetchrow($result) );
				}  // end if ($view_list[$i]['group_type'] == GROUP_HIDDEN)
				//
				// groupe visible : afficher
				if ($is_ok)
				{
					$u_group_name = append_sid("groupcp.php?g=".$groups[$i]['group_id']);
					$l_group_name = $groups[$i]['group_name'];
					$l_group_desc = $groups[$i]['group_description'];
					$template->assign_block_vars('groups',array(
						'U_GROUP' => $u_group_name,
						// V: integrate $rcs
						'GROUP_NAME' => $rcs->get_group_class($groups[$i]['group_id'], $groups[$i]['group_name']),
						'GROUP_DESC' => $l_group_desc,
						)
					);
				}  // end if ($is_ok)
			}  // end for ($i=0; $i < count($groups); $i++)
		}  // end if (count($groups) > 0)
	}
}

/**
* main process
*/

// init objects
$common = new common();
$set = new rcs_set();

// navigation start
$navigation = new navigation();
$navigation->add('userlist', 'userlist', $requester);

// default parms
$dft_order = 'a';
$dft_sort = 'joined';

// values allowed
$mode_allowed = array('groups', 'leaders', 'viewprofile');
$sort_allowed = array(
//-- mod : flags ---------------------------------------------------------------
//-- add
	'flag',
//-- fin mod : flags -----------------------------------------------------------
	'joined',
	'username',
	'location',
	'posts',
	'email',
	'website',
	'topten',
);

// get parms
$parms = array(
	RCS_USER_URL => request_var(RCS_USER_URL, TYPE_INT),
	RCS_GROUP_URL => request_var(RCS_GROUP_URL, TYPE_INT),
	RCS_LEVEL_URL => request_var(RCS_LEVEL_URL, TYPE_INT),
	'username' => stripslashes(phpbb_clean_username(addslashes(request_var('username', '')))),
	'sort' => request_var('sort', TYPE_NO_HTML, $dft_sort, $sort_allowed),
	'order' => request_var('order', TYPE_NO_HTML, $dft_order, array('a', 'd')),
	'start' => max(0, request_var('start', TYPE_INT)),
);
$mode = request_var('mode', TYPE_NO_HTML, '', $mode_allowed);

// hidden fields
_hide_build(array(
	RCS_USER_URL => $parms[RCS_USER_URL],
	RCS_GROUP_URL => $parms[RCS_GROUP_URL],
	RCS_LEVEL_URL => $parms[RCS_LEVEL_URL],
));

// let's go
switch ( $mode )
{
	case 'viewprofile':
		$parms = array();
		$child_title = $lang['Viewing_profile'];
		$usr_details = new usr_details($requester);
		$usr_details->process();
		break;
	case 'groups':
		$child_title = $lang['groups'];
		$usr_groups = new usr_groups($requester, $parms);
		$usr_groups->process();
		break;
	case 'leaders':
		$parms = array();
		$child_title = $lang['the_team'];
		$usr_leaders = new usr_leaders($requester);
		$usr_leaders->process();
		break;
	default:
		$mode = '';
		$child_title = '';
		$usr_list = new usr_list($requester, $parms);
		$usr_list->process();
		break;
}

// constants
$template->assign_vars(array(
	'L_USERLIST' => $lang['userlist'],
	'L_OPTIONS' => $lang['Options'],
	'L_EMPTY' => $lang['no_members_match'],

	'L_USERNAME' => $lang['Username'],
	'L_JOINED' => $lang['Joined'], 
	'L_FROM' => $lang['Location'],
	'L_OCCUPATION' => $lang['Occupation'],
	'L_INTERESTS' => $lang['Interests'],
	'L_POSTS' => $lang['Posts'], 
	'L_RANK' => $lang['Poster_rank'],
	'L_PM' => $lang['Message'],
	'L_EMAIL' => $lang['Email'],
	'L_WEBSITE' => $lang['Website'],

	'L_AIM' => $lang['AIM'],
	'L_ICQ' => $lang['ICQ'],
	'L_MSNM' => $lang['MSNM'],
	'L_YIM' => $lang['YIM'],
//-- mod : birthday ------------------------------------------------------------
//-- add
	'L_BIRTHDATE' => $lang['birthdate'],
	'L_AGE' => $lang['poster_age'],
	'L_BIRTHCAKE' => $lang['happy_birthday'],
	'I_BIRTHCAKE' => $images['mini_birthcake'],
//-- fin mod : birthday --------------------------------------------------------
	'L_SEARCH_USERNAME' => $lang['Find_username'],
	'L_SEARCH_EXPLAIN' => $lang['Search_author_explain'],
	'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
	'L_ORDER' => $lang['Order'],
	'L_SORT' => $lang['Sort'],

	'L_SUBMIT' => $lang['Submit'],
	'I_SUBMIT' => $images['cmd_submit'],

	'L_TEAM' => $lang['the_team'],
	'U_TEAM' => $get->url($requester, array('mode' => 'leaders'), true),
	'L_GROUPS' => $lang['groups'],
	'U_GROUPS' => $get->url($requester, array('mode' => 'groups'), true),
//-- mod : flags ---------------------------------------------------------------
//-- add
	'L_FLAG' => $lang['flag_country'],
	'U_SORT_FLAG' => $get->url($requester, array_merge($parms, array('sort' => 'flag', 'order' => ($parms['order'] == 'd' ? '' : 'd'))), true),
//-- fin mod : flags -----------------------------------------------------------	

	'U_SORT_USERNAME' => $get->url($requester, array_merge($parms, array('sort' => 'username', 'order' => ($parms['order'] == 'd' ? '' : 'd'))), true),
	'U_SORT_JOINED' => $get->url($requester, array_merge($parms, array('sort' => 'joined', 'order' => ($parms['order'] == 'd' ? '' : 'd'))), true),
	'U_SORT_POSTS' => $get->url($requester, array_merge($parms, array('sort' => 'posts', 'order' => ($parms['order'] == 'd' ? '' : 'd'))), true),
	'U_SORT_EMAIL' => $get->url($requester, array_merge($parms, array('sort' => 'email', 'order' => ($parms['order'] == 'd' ? '' : 'd'))), true),
	'U_SORT_WEBSITE' => $get->url($requester, array_merge($parms, array('sort' => 'website', 'order' => ($parms['order'] == 'd' ? '' : 'd'))), true),

	'S_USERLIST_ACTION' => $get->url($requester, '', true),
));
_hide_send();

// navigation end
$navigation->display();
unset($navigation);

// generate the page
$page_title = $lang['userlist'] . ( empty($child_title) ? '' : ' - ' . $child_title );
include($get->url('includes/page_header'));
$template->pparse('body');
include($get->url('includes/page_tail'));

?>