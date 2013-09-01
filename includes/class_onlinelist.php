<?php
/**
*
* @package today_userlist_mod
* @version $Id: class_onelinelist.php,v 1.0.4 18:15 10/11/2007 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// current version
define('TUL_VERSION', '1.2.2a');

define('MAX_IN_LIST', 50);

class onlinelist_class
{
	var $now;
	var $current_hour;
	var $yesterday;

	var $user_fields;
	var $count_user_fields;

	var $rcs_compliance;

	function onlinelist_class()
	{
		global $rcs;

		$this->now = time();
		$this->current_hour = 3600 * floor($this->now / 3600);
		$this->yesterday = $this->current_hour - 86400;

		$this->init();

		$this->user_fields = array(
			'username',
			'user_allow_viewonline',
			'user_level',
			'user_session_time',
		);

		// ensure rank color system compliance
		$this->rcs_compliance = false;
		if ( !empty($rcs) || is_object($rcs) )
		{
			$this->user_fields = array_merge($this->user_fields, array(
				'user_color',
				'user_group_id',
			));
			$this->rcs_compliance = true;
		}

		$this->count_user_fields = count($this->user_fields);
	}

	function init()
	{
		global $db, $board_config;

		// get guests stats
		$has_updated = !empty($board_config['gfirst_hour']);
		$gfirst_hour = empty($board_config['gfirst_hour']) ? 0 : intval($board_config['gfirst_hour']);

		// clean old guests visit if necessary
		if ( !empty($gfirst_hour) && ( $gfirst_hour < $this->yesterday ) )
		{
			$sql = 'DELETE FROM ' . GUESTS_VISIT_TABLE . '
				WHERE guest_time < ' . intval($this->yesterday);
			if ( !$db->sql_query($sql) )
			{
				message_die(CRITICAL_ERROR, 'Error removing old guests visit data', '', __LINE__, __FILE__, $sql);
			}
			$has_updated = false;
		}

		if ( !$has_updated )
		{
			$common = new common();
			$common->set_config('gfirst_hour', intval($this->current_hour));
			unset($common);
		}
	}

	function get_user_style($user_style)
	{
		global $theme;
		global $rcs;

		if ( !empty($user_style) && is_array($user_style) )
		{
			if ( $this->rcs_compliance )
			{
				$style_color = $rcs->get_colors($user_style);

				return $style_color;
			}

			switch ( $user_style['user_level'] )
			{
				case ADMIN:
					$style_color = ' style="color:#' . $theme['fontcolor3'] . '; font-weight:bold;"';
					break;
				case MOD:
					$style_color = ' style="color:#' . $theme['fontcolor2'] . '; font-weight:bold;"';
					break;
				default:
					$style_color = '';
					break;
			}

			return $style_color;
		}
	}

	function display($blockname='', $onset=false)
	{
		global $db, $board_config, $userdata, $template, $lang;
		global $get, $rcs;

		if ( !empty($blockname) && empty($onset) )
		{
			return;
		}

		// prepare data
		$is_admin = ($userdata['user_level'] == ADMIN);
		$blockname = empty($blockname) ? '' : $blockname . '.';
		$addon = $tpl_data = array();

		// prepare the counts
		$max_in_list = defined('MAX_IN_LIST') && (MAX_IN_LIST != 0);
		$see = !$max_in_list ? '' : request_var('see', TYPE_NO_HTML);
		$counts = array(
			'hour' => array('hidden' => 0, 'visible' => 0, 'guests' => 0),
			'today' => array('hidden' => 0, 'visible' => 0, 'guests' => 0, 'displayed' => 0, 'full_list' => !$max_in_list || ($see == 'alltoday')),
		);

		// get guests visit
		$sql = 'SELECT guest_time, guest_visit
				FROM ' . GUESTS_VISIT_TABLE . '
				WHERE guest_time >= ' . intval($this->yesterday);
		if( !($result = $db->sql_query($sql, false, 'online_guests_')) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain guests visit data', '', __LINE__, __FILE__, $sql);
		}

		while ( $row = $db->sql_fetchrow($result) )
		{
			if ( intval($row['guest_time']) >= $this->current_hour )
			{
				$counts['hour']['guests'] += intval($row['guest_visit']);
			}
			$counts['today']['guests'] += intval($row['guest_visit']);
		}
		$db->sql_freeresult($result);

		// start the display
		$get->assign_switch('online', true);
		$get->assign_switch('online.today');

		// build the main request to read registered users
		$sql = 'SELECT user_id' . ($this->count_user_fields ? ', ' . implode(', ', $this->user_fields) : '') . '
				FROM ' . USERS_TABLE . '
				WHERE user_id <> ' . ANONYMOUS . '
					AND user_session_time >= ' . intval($this->yesterday) . '
				ORDER BY username';
		if( !($result = $db->sql_query($sql, false, 'online_users_')) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain today userlist data', '', __LINE__, __FILE__, $sql);
		}

		while ( $row = $db->sql_fetchrow($result) )
		{
			// process counts
			$hidden = !$row['user_allow_viewonline'];
			$ranges = array(
				'hour' => $row['user_session_time'] >= $this->current_hour,
				'today' => $row['user_session_time'] >= $this->yesterday,
			);
			foreach ( $ranges as $range => $in_range )
			{
				if ( $in_range )
				{
					$counts[$range][ ($hidden ? 'hidden' : 'visible') ]++;
				}
			}

			// prepare display
			$user_style_done = false;
			$user_style = '';
			$u_profile = '';
			$viewable = true;

			// what to display?
			$display = $counts['today']['full_list'] || ($counts['today']['displayed'] < MAX_IN_LIST) ? 'standard' : ($counts['today']['displayed'] == MAX_IN_LIST ? 'next' : 'none');

			// get user style if necessary
			if ( !$user_style_done && ($display == 'standard') )
			{
				if ( $viewable = (!$hidden || $is_admin) )
				{
					// get user style
					$fields_color = array(
						'user_level' => intval($row['user_level']),
						'user_color' => $this->rcs_compliance ? intval($row['user_color']) : 0,
						'user_group_id' => $this->rcs_compliance ? intval($row['user_group_id']) : 0,
					);
					$user_style = $this->get_user_style($fields_color);
					$u_profile = $get->url(($this->rcs_compliance ? 'userlist' : 'profile'), array('mode' => 'viewprofile', POST_USERS_URL => intval($row['user_id'])), true);
				}
				$user_style_done = true;
			}
			if ( !$viewable )
			{
				continue;
			}

			// process display
			switch ( $display )
			{
				case 'standard':
					$template->assign_block_vars($blockname . 'online.today.row', $tpl_data + array(
						'U_VIEW_PROFILE' => $u_profile,
						'USERNAME' => $row['username'],
						'STYLE' => $user_style,
					));
					$get->assign_switch($blockname . 'online.today.row.hidden', $hidden);
					$get->assign_switch($blockname . 'online.today.row.sep', $counts['today']['displayed']);
					break;
				case 'next':
					$template->assign_block_vars($blockname . 'online.today.row', array(
						'U_VIEW_PROFILE' => $get->url('index', array('see' => 'alltoday'), true),
						'USERNAME' => '...',
						'STYLE' => '',
					));
					$get->assign_switch($blockname . 'online.today.row.sep');
					break;
			}
			$counts['today']['displayed']++;
		}
		$db->sql_freeresult($result);

		// count users
		$total_hour = $counts['hour']['visible'] + $counts['hour']['hidden'] + $counts['hour']['guests'];
		$total_today = $counts['today']['visible'] + $counts['today']['hidden'] + $counts['today']['guests'];

		// build listing
		$hour_online =
			$this->sprintf_build($counts['hour']['visible'], 'past_reg') .
			$this->sprintf_build($counts['hour']['hidden'], 'past_hidden') .
			$this->sprintf_build($counts['hour']['guests'], 'past_guests');
		$today_online =
			$this->sprintf_build($counts['today']['visible'], 'past_reg') .
			$this->sprintf_build($counts['today']['hidden'], 'past_hidden') .
			$this->sprintf_build($counts['today']['guests'], 'past_guests');

		// constants
		$template->assign_vars(array(
			'NO_USERS_ONLINE' => $lang['None'],
			'L_VIEW_PROFILE' => $lang['Read_profile'],
			'L_REGISTERED_USERS' => $lang['Today_users'],
			'L_TOTAL_TODAY' => $this->sprintf_build($total_today, 'past'),

			'TOTAL_TODAY_USERS' => $today_online,
			'TOTAL_HOUR_USERS' => sprintf($lang['hour_visits'], $hour_online),
		));

		// send to display
		$template->set_filenames(array('onlinelist_box' => 'onlinelist_box.tpl'));
		$template->assign_var_from_handle('ONLINELIST_BOX', 'onlinelist_box');
	}

	function sprintf_build($count, $l_prefix)
	{
		global $lang;

		return sprintf($lang[$l_prefix . ( !$count ? '_users_zero_total' : ( $count == 1 ? '_user_total' : '_users_total' ) )], $count);
	}
}

?>