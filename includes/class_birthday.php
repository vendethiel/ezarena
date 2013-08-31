<?php
/**
*
* @package birthday_event_mod
* @version $Id: class_birthday.php,v 1.0.3 17:56 17/08/2007 reddog Exp $
* @copyright (c) 2007 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// current version
define('BE_VERSION', '1.1.0c');

define('MAX_IN_BLIST', 50);

class birthday_class
{
	var $config;
	var $now;
	var $birthdate;
	var $zodiac;

	var $user_fields;
	var $count_user_fields;

	var $rcs_compliance;

	function birthday_class()
	{
		global $board_config;
		global $rcs;

		$this->now = !$this->now ? getdate(time() + intval($board_config['board_timezone']) - date('Z')) : $this->now;
		$this->birthdate = false;

		// birthday variables
		$this->config = array(
			'show' => intval($board_config['bday_show']),
			'wishes' => intval($board_config['bday_wishes']),
			'require' => intval($board_config['bday_require']),
			'lock' => intval($board_config['bday_lock']),
			'lookahead' => intval($board_config['bday_lookahead']),
			'min' => intval($board_config['bday_min']),
			'max' => intval($board_config['bday_max']),
			'timezone' => intval($board_config['board_timezone']),
		);

		// instantiate zodiac object
		$this->zodiac = new zodiac_signs();

		$this->user_fields = array(
			'username',
			'user_level',
			'user_birthday',
			'user_zodiac',
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

	function select_birthdate($values)
	{
		global $userdata, $template, $lang;
		global $get;

		// prepare data
		$fields = array(
			'd' => array('name' => 'bday_day', 'options' => $this->get_list('d'), 'value' => intval($values['d'])),
			'm' => array('name' => 'bday_month', 'options' => $this->get_list('m'), 'value' => intval($values['m'])),
			'y' => array('name' => 'bday_year', 'options' => $this->get_list('y'), 'value' => intval($values['y'])),
		);
		$cnt_fields = 0;

		$checkdate = $this->checkdate($values);
		$readonly = $this->config['lock'] && !empty($checkdate) && ($userdata['user_level'] != ADMIN);

		//process display
		$get->assign_switch('birthdate', true);
		foreach ( $fields as $field => $data )
		{
			$cnt_fields++;
			$template->assign_block_vars('birthdate.field', array(
				'NAME' => $data['name'],
				'VALUE' => $data['value'],
			));
			$get->assign_switch('birthdate.field.readonly', $readonly);
			$get->assign_switch('birthdate.field.sep', $cnt_fields < 3);

			foreach ( $data['options'] as $value => $desc )
			{
				if ( $readonly && ($data['value'] != $value) )
				{
					continue;
				}
				$template->assign_block_vars('birthdate.field.option', array(
					'VALUE' => intval($value),
					'DESCRIPTION' => !$value ? lang_item($desc) : ( $field == 'm' ? $lang['datetime'][$desc] : $desc ),
				));
				$get->assign_switch('birthdate.field.option.selected', $data['value'] == $value);
			}
		}

		// constants
		$template->assign_vars(array(
			'L_BIRTHDATE' => $lang['birthdate'],
			'L_BIRTHDATE_REQUIRE' => $this->config['require'] ? ' *' : '',
			'L_BIRTHDATE_EXPLAIN' => $lang['birthdate_explain'],
		));

		// send to display
		$template->set_filenames(array('birthday_select_box' => 'ucp/ucp_birthday_select_box.tpl'));
		$template->assign_var_from_handle('BIRTHDAY_SELECT_BOX', 'birthday_select_box');
	}

	function display_details($user_birthday, $user_zodiac, $force=false, $tpl_level='')
	{
		global $template, $lang, $images;
		global $get;

		static $already_sent = false;

		// prepare data
		$data_bday = array();
		$addon = array();

		$this->birthdate = $this->split($user_birthday);
		$checkdate = $this->checkdate($this->birthdate);

		// process display
		if ( !empty($this->birthdate) && $checkdate )
		{
			// which is the date of birth of this user?
			$birthday_format = str_replace('Y', $this->birthdate['y'], $lang['birthday_dateformat']);
			$data_bday['birthday'] = strtr( date($birthday_format, mktime(0, 0, 0, $this->birthdate['m'], $this->birthdate['d'], 4)), $lang['datetime'] );

			// how old is this user?
			$diff = $this->birthdate['m'] == $this->now['mon'] ? ( $this->birthdate['d'] <= $this->now['mday'] ? 0 : 1 ) : ( $this->birthdate['m'] < $this->now['mon'] ? 0 : 1 );
			$data_bday['age'] = $this->now['year'] - ( $this->birthdate['y'] + $diff );

			// happy birthday?
			$data_bday['birthcake'] = !$this->config['wishes'] ? 0 : $this->compare_date('%02d%02d');

			// zodiac signs
			$addon['zodiac'] = $this->zodiac->set_zodiac($user_zodiac);
			$data_bday['zodiac'] = $addon['zodiac']['value'];
			$tpl_data = $addon['zodiac']['tpl_data'];
		}

		if ( !empty($force) )
		{
			return $data_bday;
		}

		if ( !empty($this->birthdate) && $checkdate )
		{
			// send to template
			if ( empty($already_sent) )
			{
				$template->assign_vars(array(
					'L_BIRTHDATE' => $lang['birthdate'],
					'L_AGE' => $lang['poster_age'],
					'L_BIRTHCAKE' => $lang['happy_birthday'],
					'I_BIRTHCAKE' => $images['mini_birthcake'],
				));
				$already_sent = true;
			}

			$tpl_level = empty($tpl_level) ? '' : $tpl_level . '.';
			$template->assign_block_vars($tpl_level . 'birthday', $tpl_data + array(
				'BIRTHDATE' => $data_bday['birthday'],
				'AGE' => $data_bday['age'],
			));
			$get->assign_switch($tpl_level . 'birthday.zodiac', !empty($data_bday['zodiac']));
			$get->assign_switch($tpl_level . 'birthday.birthcake', !empty($data_bday['birthcake']));
		}
	}

	function display_config($values)
	{
		global $template, $lang;

		// constants
		$template->assign_vars(array(
			'L_BDAY_SETTINGS' => $lang['birthday_settings'],
			'L_BDAY_SHOW' => $lang['birthday_show'],
			'L_BDAY_SHOW_EXPLAIN' => $lang['birthday_show_explain'],
			'L_BDAY_WISHES' => $lang['birthday_wishes'],
			'L_BDAY_WISHES_EXPLAIN' => $lang['birthday_wishes_explain'],
			'L_BDAY_REQUIRE' => $lang['birthday_require'],
			'L_BDAY_REQUIRE_EXPLAIN' => $lang['birthday_require_explain'],
			'L_BDAY_LOCK' => $lang['birthday_lock'],
			'L_BDAY_LOCK_EXPLAIN' => $lang['birthday_lock_explain'],
			'L_BDAY_LOOKAHEAD' => $lang['birthday_lookahead'],
			'L_BDAY_LOOKAHEAD_EXPLAIN' => $lang['birthday_lookahead_explain'],
			'L_BDAY_AGE_RANGE' => $lang['birthday_age_range'],
			'L_BDAY_AGE_RANGE_EXPLAIN' => $lang['birthday_age_range_explain'],
			'L_BDAY_ZODIAC' => $lang['birthday_zodiac'],
			'L_BDAY_ZODIAC_EXPLAIN' => $lang['birthday_zodiac_explain'],

			'L_YES' => $lang['Yes'],
			'L_NO' => $lang['No'],
			'L_TO' => $lang['To'],

			'BDAY_SHOW_YES' => !$values['bday_show'] ? '' : ' checked="checked"',
			'BDAY_SHOW_NO' => $values['bday_show'] ? '' : ' checked="checked"',
			'BDAY_WISHES_YES' => !$values['bday_wishes'] ? '' : ' checked="checked"',
			'BDAY_WISHES_NO' => $values['bday_wishes'] ? '' : ' checked="checked"',
			'BDAY_REQUIRE_YES' => !$values['bday_require'] ? '' : ' checked="checked"',
			'BDAY_REQUIRE_NO' => $values['bday_require'] ? '' : ' checked="checked"',
			'BDAY_LOCK_YES' => !$values['bday_lock'] ? '' : ' checked="checked"',
			'BDAY_LOCK_NO' => $values['bday_lock'] ? '' : ' checked="checked"',
			'BDAY_LOOKAHEAD' => intval($values['bday_lookahead']),
			'BDAY_MIN' => intval($values['bday_min']),
			'BDAY_MAX' => intval($values['bday_max']),
			'BDAY_ZODIAC_YES' => !$values['bday_zodiac'] ? '' : ' checked="checked"',
			'BDAY_ZODIAC_NO' => $values['bday_zodiac'] ? '' : ' checked="checked"',
		));

		// send to display
		$template->set_filenames(array('birthday_config_box' => 'acp/acp_birthday_config_box.tpl'));
		$template->assign_var_from_handle('BIRTHDAY_CONFIG_BOX', 'birthday_config_box');
	}

	function generate_list($blockname='', $onset=false)
	{
		global $db, $template, $lang, $images;
		global $get, $rcs;

		if ( !empty($blockname) && empty($onset) )
		{
			return;
		}

		// prepare data
		$blockname = empty($blockname) ? '' : $blockname . '.';
		$addon = array();

		// prepare the counts
		$max_in_Blist = defined('MAX_IN_BLIST') && (MAX_IN_BLIST != 0);
		$see = !$max_in_Blist ? '' : request_var('see', TYPE_NO_HTML);
		$counts = array(
			'today' => array('displayed' => 0, 'full_list' => !$max_in_Blist || ($see == 'today')),
			'lookahead' => array('displayed' => 0, 'full_list' => !$max_in_Blist || ($see == 'lookahead')),
		);

		if ( !empty($this->config['wishes']) )
		{
			// start the display
			$get->assign_switch('birthdays');
			$get->assign_switch('birthdays.today');
			$get->assign_switch('birthdays.lookahead', $this->config['lookahead']);

			if ( $this->config['lookahead'] )
			{
				$between = array(
					'start' => gmdate('m-d-0000', strtotime('+1 day') + (3600 * $this->config['timezone'])),
					'end' => gmdate('m-d-9999', strtotime('+' . $this->config['lookahead'] . ' day') + (3600 * $this->config['timezone'])),
				);
			}

			// build the main request
			$date = sprintf('%02d-%02d-', intval($this->now['mon']), intval($this->now['mday']));
			$sql = 'SELECT user_id' . ($this->count_user_fields ? ', ' . implode(', ', $this->user_fields) : '') . '
					FROM ' . USERS_TABLE . '
					WHERE user_birthday LIKE \'' . $date . '%\'
						' . ( $this->config['lookahead'] ? 'OR (user_birthday BETWEEN \'' . $between['start'] . '\' AND \'' . $between['end'] . '\')' : '' ) . '
						AND user_id <> ' . ANONYMOUS . '
						AND user_active = 1
					ORDER BY username';
			// Vende: ça va faire mal au dossier de cache
			// M'enfin vu que tout est clean à chaque visite ACP ... ;)
			if( !($result = $db->sql_query($sql, false, 'birthdays_' . $date)) )
			{
				message_die(GENERAL_ERROR, 'Could not obtain members birthday information', '', __LINE__, __FILE__, $sql);
			}

			while ( $row = $db->sql_fetchrow($result) )
			{
				// process counts
				$this->birthdate = $this->split($row['user_birthday']);
				$ranges = array(
					'today' => $this->compare_date('%02d-%02d'),
					'lookahead' => $this->compare_date('%02d-%02d', 'greater'),
				);

				// process display
				$user_style_done = false;
				$user_style = '';
				$u_profile = '';

				foreach ( $ranges as $range => $in_range )
				{
					if ( !$in_range )
					{
						continue;
					}

					// what to display?
					$display = $counts[$range]['full_list'] || ($counts[$range]['displayed'] < MAX_IN_BLIST) ? 'standard' : ($counts[$range]['displayed'] == MAX_IN_BLIST ? 'next' : 'none');

					// get user style if necessary
					if ( !$user_style_done && ($display == 'standard') )
					{
						// get user style
						$fields_color = array(
							'user_level' => intval($row['user_level']),
							'user_color' => $this->rcs_compliance ? intval($row['user_color']) : 0,
							'user_group_id' => $this->rcs_compliance ? intval($row['user_group_id']) : 0,
						);
						$user_style = $this->get_user_style($fields_color);
						$u_profile = $get->url(($this->rcs_compliance ? 'userlist' : 'profile'), array('mode' => 'viewprofile', POST_USERS_URL => intval($row['user_id'])), true);
						$diff = $this->birthdate['m'] == $this->now['mon'] ? ( $this->birthdate['d'] <= $this->now['mday'] ? 0 : 1 ) : ( $this->birthdate['m'] < $this->now['mon'] ? 0 : 1 );
						$user_age = $this->now['year'] - ( $this->birthdate['y'] + $diff );
						$user_style_done = true;

						// zodiac signs
						$addon['zodiac'] = $this->zodiac->set_zodiac($row['user_zodiac']);
						$user_zodiac = $addon['zodiac']['value'];
						$tpl_data = $addon['zodiac']['tpl_data'];
					}

					// process display
					switch ( $display )
					{
						case 'standard':
							$template->assign_block_vars($blockname . 'birthdays.' . $range . '.row', $tpl_data + array(
								'U_VIEW_PROFILE' => $u_profile,
								'USERNAME' => $row['username'],
								'STYLE' => $user_style,
								'AGE' => $user_age,
							));
							$get->assign_switch($blockname . 'birthdays.' . $range . '.row.age', !empty($user_age));
							$get->assign_switch($blockname . 'birthdays.' . $range . '.row.zodiac', !empty($user_zodiac));
							$get->assign_switch($blockname . 'birthdays.' . $range . '.row.sep', $counts[$range]['displayed']);
							break;

						case 'next':
							$template->assign_block_vars($blockname . 'birthdays.' . $range . '.row', array(
								'U_VIEW_PROFILE' => $get->url('index', array('see' => $range), true),
								'USERNAME' => '...',
								'STYLE' => '',
								'AGE' => '',
							));
							$get->assign_switch($blockname . 'birthdays.' . $range . '.row.sep');
							break;
					}
					$counts[$range]['displayed']++;
				}
			}
			$db->sql_freeresult($result);

			// go with display
			// V: display seulement si y'a des trucs à display :°
			if ((!empty($counts['today']['displayed']) || !empty($counts['lookahead']['displayed'])) && $this->config['show'])
			{
				// send to template
				$template->assign_vars(array(
					'L_BIRTHDAYS' => $lang['birthdays'],
					'L_WHICH_BIRTHDAY' => $lang['which_birthday'],
					'L_CONGRATULATIONS' => $lang['congratulations'],
					'L_NO_BIRTHDAYS' => $lang['no_birthdays'],
					'L_UPCOMING' => !$this->config['lookahead'] ? '' : sprintf($lang['upcoming_birthdays'], $this->config['lookahead']),
					'L_NO_UPCOMING' => !$this->config['lookahead'] ? '' : sprintf($lang['no_upcoming'], $this->config['lookahead']),
					'L_VIEW_PROFILE' => $lang['Read_profile'],
					'I_BIRTHCAKE' => $images['birthcake'],
				));

				// send to display
				$template->set_filenames(array('birthdays_box' => 'index_birthdays_box.tpl'));
				$template->assign_var_from_handle('BIRTHDAYS_BOX', 'birthdays_box');
			}
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

	function get_list($frag)
	{
		switch ( $frag )
		{
			case 'd':
				$list = array(0 => 'default_day');
				for ( $i = 1; $i <= 31; $i++ )
				{
					$list[$i] = sprintf('%02d', $i);
				}
				return $list;
				break;
			case 'm':
				return array(0 => 'default_month', 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
				break;
			case 'y' :
				$list = array(0 => 'default_year');
				for ( $i = $this->now['year'] - $this->config['max']; $i <= $this->now['year'] - $this->config['min']; $i++ )
				{
					$list[$i] = sprintf('%04d', $i);
				}
				return $list;
				break;
		}
		return array(0 => '---');
	}

	function checkdate($values)
	{
		if ( !intval($values['y']) || !intval($values['m']) || !intval($values['d']) )
		{
			return false;
		}
		$numdate = sprintf('%02d%02d%04d', intval($values['m']), intval($values['d']), intval($values['y']));
		return intval($numdate);
	}

	function split($date)
	{
		$parsed = false;
		if ( !empty($date) )
		{
			$tmp = explode('-', $date);
			$parsed = array(
				'm' => intval($tmp[0]),
				'd' => intval($tmp[1]),
				'y' => intval($tmp[2]),
			);
		}
		return $parsed;
	}

	function pack($values)
	{
		if ( !intval($values['y']) || !intval($values['m']) || !intval($values['d']) )
		{
			return '';
		}
		return sprintf('%02d-%02d-%04d', intval($values['m']), intval($values['d']), intval($values['y']));
	}

	function compare_date($mask, $operator='')
	{
		$mask = !$mask ? '%02d%02d' : $mask;
		$first = sprintf($mask, $this->birthdate['m'], $this->birthdate['d']);
		$second = sprintf($mask, intval($this->now['mon']), intval($this->now['mday']));

		switch ( $operator )
		{
			case 'greater':
				return $result = $first > $second;
				break;
			case 'smaller':
				return $result = $first < $second;
				break;
			default:
				return $result = $first == $second;
				break;
		}
	}
}

class zodiac_signs
{
	var $config;
	var $zodiacs;
	var $zodiacdates;

	function zodiac_signs()
	{
		global $board_config;

		// zodiac variables
		$this->config = array(
			'zodiac' => intval($board_config['bday_zodiac']),
		);

		$this->zodiacdates = array (
			'0101', '0120',
			'0121', '0220',
			'0221', '0320',
			'0321', '0420',
			'0421', '0520',
			'0521', '0621',
			'0622', '0722',
			'0723', '0823',
			'0824', '0923',
			'0924', '1023',
			'1024', '1122',
			'1123', '1221',
			'1222', '1231',
		);

		$this->zodiacs = array (
			1 => 'Capricorn', 'Aquarius', 'Pisces', 'Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 'Virgo', 'Libra', 'Scorpio', 'Sagittarius', 'Capricorn'
		);
	}

	function get_zodiac($values)
	{
		$zodiac = 0;
		if ( !empty($values) && is_array($values) )
		{
			$date = sprintf('%02d%02d', intval($values['m']), intval($values['d']));
			for ($i = 0; $i < 26; $i+=2)
			{
				if ( $date >= $this->zodiacdates[$i] && $date <= $this->zodiacdates[$i+1] )
				{
					$zodiac = ($i/2) + 1;
					break;
				}
			}
		}
		return $zodiac == 13 ? 1 : $zodiac;
	}

	function set_zodiac($user_zodiac, $tpl_data=array())
	{
		global $images;

		$img = isset($images[ $this->zodiacs[$user_zodiac] ]);
		$tpl_data = !is_array($tpl_data) ? array() : $tpl_data;
		$tpl_data = !$this->config['zodiac'] ? array() : array_merge($tpl_data, array(
			'L_ZODIAC' => lang_item($this->zodiacs[$user_zodiac]),
			'I_ZODIAC' => $img ? $images[$this->zodiacs[$user_zodiac]] : '',
		));

		return array('value' => ( $this->config['zodiac'] ? $this->zodiacs[$user_zodiac] : 0 ), 'tpl_data' => $tpl_data);
	}
}

?>