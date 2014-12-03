<?php
/**
*
* @package rank_color_system_mod
* @version $Id: class_rcs.php,v 0.16 18:25 19/02/2008 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class rcs_setup
{
	var $ext;
	var $root;
	var $cache_dir;

	var $rcs_var;
	var $rcs_fields;

	function rcs_setup()
	{
		global $board_config, $phpbb_root_path, $phpEx;

		// basic parameters
		$this->ext = &$phpEx;
		$this->root = &$phpbb_root_path;
		$this->cache_dir = $this->root . 'cache/';

		// rcs fields
		$this->rcs_fields = array(
			'rcs_id',
			'rcs_name',
			'rcs_color',
			'rcs_single',
			'rcs_display',
			'rcs_order',
		);

		// common variables
		$this->rcs_var = array(
			'cache' => intval($board_config['cache_rcs']),
			'enable' => intval($board_config['rcs_enable']),
			'level_adm' => intval($board_config['rcs_level_admin']),
			'level_mod' => intval($board_config['rcs_level_mod']),
			'ranks_sts' => intval($board_config['rcs_ranks_stats']),
		);

		// basic setup
		$this->_constants();
	}

	function _constants()
	{
		global $table_prefix;

		// current version
		define('RCS_VERSION', '0.1.5b');

		// table name
		define('RCS_TABLE', $table_prefix . 'rcs');

		// url parameters
		define('RCS_USER_URL', 'uc');
		define('RCS_GROUP_URL', 'gc');
		define('RCS_LEVEL_URL', 'level');

		// legend ids
		define('LID_ADMIN', -2);
		define('LID_MOD', -1);
		define('LID_USER', 9999);
	}

	function get($var_name)
	{
		$this->from_cache = false;

		if ( $this->rcs_var['cache'] )
		{
			if ( !$this->_exists($var_name) )
			{
				return false;
			}

			@include($this->cache_dir . 'data_' . $var_name . '.' . $this->ext);

			$this->gentime = ( empty($this->gentime) || ($this->gentime < $data_time) ) ? $data_time : $this->gentime;
			$this->from_cache = !empty($data_time);

			return isset($data) ? $data : false;
		}
		else
		{
			return false;
		}
	}

	function put($var_name, $var)
	{
		if ( $this->rcs_var['cache'] )
		{
			if ($fp = @fopen($this->cache_dir . 'data_' . $var_name . '.' . $this->ext, 'wb'))
			{
				@flock($fp, LOCK_EX);
				@fwrite($fp, "<?php\n\nif ( !defined('IN_PHPBB') ) { die('Hacking attempt'); }\n\n\$data_time = " . time() . ";\n\n\$data = unserialize('" . str_replace('\'', '\\\'', str_replace('\\', '\\\\', serialize($var))) . "');\n\n?>");
				@flock($fp, LOCK_UN);
				@fclose($fp);
				@umask(0000);
				@chmod($this->cache_dir . 'data_' . $var_name . '.' . $this->ext, 0666);
			}
		}
	}

	function _exists($var_name)
	{
		return file_exists($this->cache_dir . 'data_' . $var_name . '.' . $this->ext);
	}
}

class rcs extends rcs_setup
{
	var $gentime;
	var $from_cache;
	var $list_ids;

	var $id_color;

	/**
	* main functions
	*/

	function constructor($list, $tpl_varname='', $tpl_switch='list')
	{
		global $template, $get;

		if ( empty($list['items']) || !is_array($list['items']) )
		{
			return;
		}

		$template->assign_block_vars($tpl_switch, array(
			'LIST_NAME' => $list['name'],
			'LIST_WIDTH' => intval($list['width']),
			'LIST_HTML' => !empty($list['html']) ? $list['html'] : '',
		));
		$get->assign_switch($tpl_switch . '.width', !empty($list['width']));

		$opt = false;
		$curoptgroup = '';
		foreach ( $list['items'] as $elem )
		{
			// build element
			$template->assign_block_vars($tpl_switch . '.element', array(
				'NAME' => $elem['name'],
				'VALUE' => $elem['value'],
				'STYLE' => $elem['style'],
			));
			$get->assign_switch($tpl_switch . '.element.selected', !empty($elem['selected']));

			// build optgroup
			if ( isset($elem['optgroup']) && ($elem['optgroup'] != $curoptgroup) )
			{
				if ( $opt )
				{
					$get->assign_switch($tpl_switch . '.element.optgroup_close', true);
					$opt = false;
				}
				if ( !empty($elem['optgroup']) )
				{
					$template->assign_block_vars($tpl_switch . '.element.optgroup_open', array(
						'LABEL' => $elem['optgroup'],
					));
					$curoptgroup = $elem['optgroup'];
					$opt = true;
				}
			}
		}

		// close optgroup so still open
		if ( $opt )
		{
			$get->assign_switch($tpl_switch . '.optgroup', true);
			$opt = false;
		}

		// send the display
		if ( $tpl_switch == 'list' )
		{
			$template->set_filenames(array('list_box' => 'list_box.tpl'));
			$template->assign_var_from_handle(empty($tpl_varname) ? 'LIST_BOX' : strtoupper($tpl_varname), 'list_box');
		}
	}

	function get_style($r_name, $r_color)
	{
		return empty($r_color) ? ( empty($r_name) ? '' : ' class="' . $r_name . '"' ) : ' style="color:#' . $r_color . '; font-weight:bold;"';
	}

	function select_colors($select, $single=false)
	{
		global $db, $lang;

		$single = !empty($single);
		$sql = 'SELECT ' . implode(', ', $this->rcs_fields) . '
			FROM ' . RCS_TABLE . '
				WHERE rcs_single = ' . intval($single) . '
			ORDER BY rcs_order';
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain rank color system data', '', __LINE__, __FILE__, $sql);
		}

		$items = array();
		$items[] = array('name' => $lang['None'], 'value' => 0, 'style' => '', 'selected' => '');
		while ($row = $db->sql_fetchrow($result))
		{
			$items[] = array('name' => lang_item($row['rcs_name']), 'value' => intval($row['rcs_id']), 'style' => $this->get_style($row['rcs_name'], $row['rcs_color']), 'selected' => ($select == intval($row['rcs_id'])));
		}
		$db->sql_freeresult($result);

		$rank_list = array('name' => 'rcs_rank', 'width' => '150', 'items' => $items);
		$this->constructor($rank_list);
		unset($items);
	}

	/**
	* cache functions
	*/

	function obtain_ids_colors($force=false)
	{
		if ( !$this->rcs_var['enable'] )
		{
			return false;
		}

		// try with the cache
		$this->id_color = $this->get('rcs');

		// read tables if no data or force
		if ( (!$this->id_color && !$this->from_cache) || $force )
		{
			global $db;

			$sql = 'SELECT g.group_id, r.' . implode(', r.', $this->rcs_fields) . '
				FROM ' . RCS_TABLE . ' r
					LEFT JOIN ' . GROUPS_TABLE . ' g
						ON g.group_color = r.rcs_id
				ORDER BY r.rcs_order';
			if ( !$result = $db->sql_query($sql, false, 'rcs_') )
			{
				message_die(GENERAL_ERROR, 'Could not obtain rank color system data', '', __LINE__, __FILE__, $sql);
			}

			$this->id_color = array();
			while ($row = $db->sql_fetchrow($result))
			{
				$types = array(
					RCS_GROUP_URL => array('key' => $row['group_id'], 'fields' => array('name', 'color'), 'cond' => ($row['group_id'] && !$row['rcs_single'])),
					RCS_USER_URL => array('key' => $row['rcs_id'], 'fields' => array('name', 'color'), 'cond' => (!$row['group_id'] && $row['rcs_single'])),
					'legend' => array('key' => $row['rcs_order'], 'fields' => array('id', 'name', 'color', 'single', 'display'), 'cond' => !isset($this->id_color['legend'][ $row['rcs_order'] ])),
				);

				foreach ( $types as $type => $data )
				{
					if ( !isset($data['cond']) || $data['cond'] )
					{
						$fields = array();
						foreach ( $data['fields'] as $field )
						{
							$fields += array_merge($fields, array(
								$field => $row['rcs_' . $field],
							));
						}
						$this->id_color[ $type ][ $data['key'] ] = $fields;
					}
				}
			}
			$db->sql_freeresult($result);
			unset($fields);

			$this->put('rcs', $this->id_color);
		}

		return true;
	}

	/**
	* users functions
	*/

	function get_group_user_ids($group_id=false, $dft=false)
	{
		global $db;

		if ( $group_id === false )
		{
			return false;
		}

		$rows_clause = !empty($dft) ? 'u.user_group_id = ug.group_id' : 'u.user_id = ug.user_id';
		$sql = 'SELECT u.user_id
			FROM ' . USER_GROUP_TABLE . ' ug
				LEFT JOIN ' . USERS_TABLE . ' u
					ON ' . $rows_clause . '
				WHERE ug.group_id = ' . intval($group_id) . '
					AND ug.user_pending <> 1';
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Failed to obtain user ids', '', __LINE__, __FILE__, $sql);
		}

		$this->list_ids = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$row_id = $row['user_id'];
			if ( !empty($row_id) )
			{
				$this->list_ids[ intval($row_id) ] = true;
			}
		}
		$db->sql_freeresult($result);
	}

	function update_user_group_id($user_id_ary=false, $group_id=false, $checking=false, $default_id=false)
	{
		global $db;

		if ( !empty($user_id_ary) || !empty($this->list_ids) )
		{
			$user_id_ary = ( !empty($this->list_ids) && empty($user_id_ary) ) ? implode(', ', array_keys($this->list_ids)) : $user_id_ary;
			$checking_mode = ( (intval($group_id) == intval($default_id)) ? '<> ' : '= ' ) . intval($default_id);

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET user_group_id = ' . intval($group_id) . '
				WHERE user_id IN (' . $user_id_ary . ')' .
					( !empty($checking) ? ' AND user_group_id ' . $checking_mode : '' );
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql);
			}

			unset($user_id_ary);
		}
	}

	function update_colors($usergroup_id_ary, $single=false, $new_color=0)
	{
		global $db;

		if ( !empty($usergroup_id_ary) )
		{
			$sql = 'UPDATE ' . ( !empty($single) ? USERS_TABLE : GROUPS_TABLE ) . '
				SET ' . ( !empty($single) ? 'user_color' : 'group_color' ) . ' = ' . intval($new_color) . '
				WHERE ' . ( !empty($single) ? 'user_id'  : 'group_id' ) . ' IN (' . $usergroup_id_ary . ')';
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update users/groups table', '', __LINE__, __FILE__, $sql);
			}

			unset($usergroup_id_ary);
		}
	}

	/**
	* display functions
	*/

	function get_group_class($g_id, $g_name='')
	{
		$group_color = '';
		if ( $this->rcs_var['enable'] )
		{
			$group_color = !empty($g_name) ? '<span' : '';
			$group_color .= $this->get_style($this->id_color[RCS_GROUP_URL][$g_id]['name'], $this->id_color[RCS_GROUP_URL][$g_id]['color']);
			$group_color .= !empty($g_name) ? '>' . $g_name . '</span>' : '';
		}

		return empty($this->rcs_var['enable']) ? ( empty($g_name) ? '' : $g_name ) : $group_color;
	}

	function get_user_class($u_level, $u_color, $u_id)
	{
		global $theme;

		switch ( $u_level )
		{
			case ADMIN:
				$class_name = 'admincolor';
				$style_color = $theme['rcs_admincolor'];
				break;
			case MOD:
				$class_name = 'modcolor';
				$style_color = $theme['rcs_modcolor'];
				break;
			default:
				$class_name = 'usercolor';
				$style_color = $theme['rcs_usercolor'];
				break;
		}

		if ( $this->rcs_var['enable'] )
		{
			if ( !empty($u_color) )
			{
				$class_name = $this->id_color[RCS_USER_URL][$u_color]['name'];
				$style_color = $this->id_color[RCS_USER_URL][$u_color]['color'];
			}
			else if ( !empty($u_id) && !empty($this->id_color[RCS_GROUP_URL][$u_id]) )
			{
				$class_name = $this->id_color[RCS_GROUP_URL][$u_id]['name'];
				$style_color = $this->id_color[RCS_GROUP_URL][$u_id]['color'];
			}
		}

		return $this->get_style($class_name, $style_color);
	}

	function get_colors($_var, $_user='', $number=false, $_id='', $_color='', $_level='')
	{
		global $db, $theme;

		// initialize vars
		$_id = !$_id ? ( $number ? 'user_group_id' . $number : 'user_group_id' ) : $_id;
		$_color = !$_color ? ( $number ? 'user_color' . $number : 'user_color' ) : $_color;
		$_level = !$_level ? ( $number ? 'user_level' . $number : 'user_level' ) : $_level;

		// get user colour
		$user_color = !empty($_user) ? '<span' : '';
		$level = isset($_var[$_level]) ? $_var[$_level] : null;
		$color = isset($_var[$_color]) ? $_var[$_color] : null;
		$id = isset($_var[$_id]) ? $_var[$_id] : null;
		$user_color .= $this->get_user_class($level, $color, $id);
		$user_color .= !empty($_user) ? '>' . $_user . '</span>' : '';

		return $user_color;
	}

	function display_legend($blockname='', $onset=false)
	{
		global $db, $lang, $theme, $template;
		global $get;

		if ( !empty($blockname) && empty($onset) )
		{
			return;
		}

		// initialize vars
		$legend = array(
			'count' => 0,
			'list' => array(),
			'allowed' => $this->rcs_var['enable'] && $this->rcs_var['ranks_sts'] && !empty($this->id_color['legend']),
		);

		// get user levels
		$user_levels = array(
			LID_ADMIN => array('id' => ADMIN, 'name' => 'Administrator', 'color' => $theme['rcs_admincolor'], 'style' => 'admincolor', 'single' => 2, 'display' => ( $this->rcs_var['level_adm'] || !$this->rcs_var['ranks_sts'] || !$this->rcs_var['enable'] )),
			LID_MOD => array('id' => MOD, 'name' => 'Moderator', 'color' => $theme['rcs_modcolor'], 'style' => 'modcolor', 'single' => 2, 'display' => ( $this->rcs_var['level_mod'] || !$this->rcs_var['ranks_sts'] || !$this->rcs_var['enable'] )),
			LID_USER => array('id' => USER, 'name' => 'User', 'color' => $theme['rcs_usercolor'], 'style' => 'usercolor', 'single' => 2, 'display' => true),
		);

		// build legend
		$legend['list'] = !$legend['allowed'] ? $user_levels : $user_levels + $this->id_color['legend'];
		$legend['count'] = count($legend['list']);
		@ksort($legend['list']);

		// display legend
		$cnt_ranks = 0;
		foreach ( $legend['list'] as $rank )
		{
			if ( !empty($rank['display']) )
			{
				$var = ( $rank['single'] == 2 ) ? RCS_LEVEL_URL : ( !empty($rank['single']) ? RCS_USER_URL : RCS_GROUP_URL );
				$template->assign_block_vars((empty($blockname) ? '' : $blockname . '.') . 'legend', array(
					'RANK_NAME' => lang_item($rank['name']),
					'RANK_STYLE' => $this->get_style($rank[ !empty($rank['style']) ? 'style' : 'name' ], $rank['color']),
					'RANK_SEP' => ($cnt_ranks < ($legend['count'] - 1)) ? ',' : '',
					'U_RANK' => $get->url('userlist', array($var => $rank['id']), true),
				));
				$get->assign_switch((empty($blockname) ? '' : $blockname . '.') . 'legend.sep', ($cnt_ranks < ($legend['count'] - 1)));
			}
			$cnt_ranks++;
		}

		// constants
		$template->assign_vars(array(
			'L_LEGEND' => $lang['Legend'],
		));
	}
}

?>