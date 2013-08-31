<?php
/**
*
* @package rank_color_system_mod
* @version $Id: admin_rcs_settings.php,v 0.12 02/02/2007 20:03 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* begin process
*/

define('IN_PHPBB', 1);

if ( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Color_Ranks']['rcs_a_settings'] = $file;

	return;
}

// load default header
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_rcs_settings';
require('./pagestart.' . $phpEx);

/**
* ranks settings process
*/

class rcs_settings
{
	var $requester;
	var $root;
	var $ext;

	var $style_fields;

	function rcs_settings($requester)
	{
		global $phpbb_root_path, $phpEx;

		$this->requester = $requester;
		$this->root = &$phpbb_root_path;
		$this->ext = &$phpEx;

		// style fields
		$this->style_fields = array(
			'rcs_admincolor',
			'rcs_modcolor',
			'rcs_usercolor',
		);
	}

	function select_style($style_id)
	{
		global $db, $rcs;

		$sql = 'SELECT themes_id, style_name, ' . implode(', ', $this->style_fields) . '
			FROM ' . THEMES_TABLE . '
			ORDER BY template_name';
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain themes data', '', __LINE__, __FILE__, $sql);
		}

		$items = array();
		while ($style = $db->sql_fetchrow($result))
		{
			// color fields data
			$fields = array();
			foreach ( $this->style_fields as $field )
			{
				$fields += array_merge($fields, array(
					$field => stripslashes($style[$field]),
				));
			}
			$this->style_color[ $style['themes_id'] ] = $fields;

			// build styles list
			$items[] = array('name' => $style['style_name'], 'value' => intval($style['themes_id']), 'selected' => ($style_id == intval($style['themes_id'])));
		}
		$db->sql_freeresult($result);

		$select_style = array('name' => 'style_id', 'html' => ' onchange="this.form.submit();"', 'items' => $items);
		$rcs->constructor($select_style);
	}

	function update_style($style_id)
	{
		global $db, $common;

		$updated_list = '';
		foreach ( $this->style_fields as $style_field )
		{
			$updated[$style_field] = request_var($style_field, TYPE_NO_HTML);
			$color[$style_field] = !preg_match('/^[0-9a-f]{6}$/i', $updated[$style_field]) ? '' : $updated[$style_field];
			$updated_list .= ( ($updated_list != '') ? ', ' : '' ) . $style_field . ' = \'' . $color[$style_field] . '\'';
		}

		$sql = 'UPDATE ' . THEMES_TABLE . '
			SET ' . $updated_list . '
			WHERE themes_id = ' . $style_id;
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not update themes table', '', __LINE__, __FILE__, $sql);
		}

		// send achievement message
		$this->_achievement('rcs_style_updated');
	}

	function _regen()
	{
		global $board_config, $common, $rcs;

		if ( empty($board_config['cache_rcs']) )
		{
			// send achievement message
			$this->_achievement('rcs_cache_disabled');

			return;
		}

		$now = time();
		$l_key = 'rcs_cache_succeed';

		// process		
		$rcs->obtain_ids_colors(true);

		// read
		$rcs->obtain_ids_colors();

		// failed
		if ( $rcs->gentime < $now )
		{
			$common->set_config('cache_rcs', 0);
			$l_key = 'rcs_cache_failed';
		}

		// send achievement message
		$this->_achievement($l_key);
	}

	function _achievement($l_key)
	{
		global $get, $lang;

		$message = $lang[$l_key] . '<br /><br />' . sprintf($lang['rcs_click_return_settings'], '<a href="' . $get->url($this->requester, '', true) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . $get->url('admin/index', array('pane' => 'right'), true) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
}

/**
* ranks config process
*/

class rcs_config extends rcs_settings
{
	var $cfg;
	var $style_id;
	var $style_color = array();

	function process()
	{
		$this->init();

		if ( _butt('updated_style') )
		{
			$this->update_style($this->style_id);
		}

		if ( _butt('regen_cache_rcs') )
		{
			$this->_regen();
		}

		$this->display();
	}

	function init()
	{
		global $board_config, $new, $style_id;

		$this->cfg = &$new;
		$this->style_id = empty($style_id) ? intval($board_config['default_style']) : intval($style_id);
	}

	function get_options_list()
	{
		return array(
			'rcs_admincolor' => array('blockname' => 'style', 'legend' => 'rcs_admincolor', 'desc' => '', 'var' => 'rcs_admincolor'),
			'rcs_modcolor' => array('blockname' => 'style', 'legend' => 'rcs_modcolor', 'desc' => '', 'var' => 'rcs_modcolor'),
			'rcs_usercolor' => array('blockname' => 'style', 'legend' => 'rcs_usercolor', 'desc' => '', 'var' => 'rcs_usercolor'),
			'rcs_enable' => array('blockname' => 'config', 'legend' => 'rcs_enable', 'desc' => 'rcs_enable_desc', 'var' => 'rcs_enable'),
			'rcs_ranks_stats' => array('blockname' => 'config', 'legend' => 'rcs_ranks_stats', 'desc' => 'rcs_ranks_stats_desc', 'var' => 'rcs_ranks_stats'),
			'rcs_level_admin' => array('blockname' => 'level_ranks', 'legend' => 'rcs_level_admin', 'desc' => '', 'var' => 'rcs_level_admin'),
			'rcs_level_mod' => array('blockname' => 'level_ranks', 'legend' => 'rcs_level_mod', 'desc' => '', 'var' => 'rcs_level_mod'),
		);
	}

	function display()
	{
		global $board_config, $template, $lang;
		global $rcs;

		// get options
		$options = $this->get_options_list();

		// build styles form
		$this->select_style($this->style_id);

		// build cache form
		if ( $board_config['rcs_enable'] )
		{
			// data last regeneration
			$l_rcs_regen_time = !empty($rcs->gentime) ? create_date($board_config['default_dateformat'], intval($rcs->gentime), $board_config['board_timezone']) : 0;

			// cache constants
			$template->assign_block_vars('cache', array(
				'L_RCS_CACHE' => $lang['rcs_cache'],
				'L_LAST_REGEN' => $lang['rcs_cache_last_generation'],
				'L_RCS_REGEN_TIME' => empty($l_rcs_regen_time) ? $lang['Acc_None'] : $l_rcs_regen_time,
				'CACHE_RCS_YES' => $this->cfg['cache_rcs'] ? ' checked="checked"' : '',
				'CACHE_RCS_NO' => !$this->cfg['cache_rcs'] ? ' checked="checked"' : '',
			));
		}

		// build options form
		foreach ( $options as $option => $data )
		{
			$blockname = $data['blockname'];

			$tpl_data = array(
				'L_OPTION_TITLE' => $lang[ $data['legend'] ],

				'OPTION_NAME' => $data['var'],
				'OPTION_YES' => $this->cfg[ $data['var'] ] ? ' checked="checked"' : '',
				'OPTION_NO' => !$this->cfg[ $data['var'] ] ? ' checked="checked"' : '',
			);

			if ( $blockname == 'style' )
			{
				$tpl_data += array(
					'OPTION_VALUE' => $this->style_color[ $this->style_id ][ $data['var'] ],
				);
			}

			if ( $blockname == 'config' )
			{
				$tpl_data += array(
					'L_OPTION_DESC' => $lang[ $data['desc'] ],
				);
			}

			// options constants
			$template->assign_block_vars($blockname, $tpl_data);
		}

		// display
		$template->set_filenames(array('body' => 'admin/rcs_admin_body.tpl'));
	}
}

/**
* main process
*/

// instantiate common class
$common = new common();

// instantiate some objects
$rcs_config = new rcs_config($requester);

// get parms
$style_id = request_var('style_id', TYPE_INT);
$enabled = request_var('rcs_enable', TYPE_INT);

// config fields
$rcs_config_ary = array(
	'cache_rcs',
	'rcs_enable',
	'rcs_level_admin',
	'rcs_level_mod',
	'rcs_ranks_stats',
);

// grab rcs config
$sql = 'SELECT config_name, config_value
	FROM ' . CONFIG_TABLE . '
	WHERE config_name IN (\'' . implode('\', \'', $rcs_config_ary) . '\')';
if ( !$result = $db->sql_query($sql) )
{
	message_die(CRITICAL_ERROR, 'Could not query config rank color system data', '', __LINE__, __FILE__, $sql);
}

while ($row = $db->sql_fetchrow($result))
{
	$config_name = $row['config_name'];
	$config_value = $row['config_value'];

	$def[$config_name] = $config_value;
	$new[$config_name] = _butt('submit_form') ? request_var($config_name, TYPE_INT) : $def[$config_name];

	if ( _butt('submit_form') && ($def[$config_name] != $new[$config_name]) )
	{
		if ( !$enabled && !empty($board_config['cache_rcs']) )
		{
			$new['cache_rcs'] = 0;
		}
		$common->set_config($config_name, $new[$config_name]);
	}
}
$db->sql_freeresult($result);

// submitted
if ( _butt('submit_form') )
{
	// send achievement message
	$rcs_config->_achievement('rcs_setup_updated');
}

// let's go
$rcs_config->process();

// constants
$template->assign_vars(array(
	'S_RCS_ACTION' => $get->url($requester, '', true),

	'L_RCS_SETTINGS_TITLE' => $lang['rcs_settings_title'],
	'L_RCS_SETTINGS_TITLE_DESC' => $lang['rcs_settings_title_desc'],
	'L_RCS_STYLE_SETTINGS' => $lang['rcs_style_settings'],
	'L_RCS_CACHE_SETTINGS' => $lang['rcs_cache_settings'],
	'L_RCS_MAIN_SETTINGS' => $lang['rcs_main_settings'],

	'L_RCS_SELECT_STYLE' => $lang['rcs_select_style'],
	'L_RCS_LEVEL_RANKS' => $lang['rcs_level_ranks'],
	'L_RCS_LEVEL_RANKS_DESC' => $lang['rcs_level_ranks_desc'],

	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_REGEN' => $lang['rcs_cache_regen'],
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],

	'L_PICK_COLOR' => $lang['rcs_pick_color'],

	'I_REGEN' => $phpbb_root_path . $images['cmd_regen'],
	'I_SUBMIT' => $phpbb_root_path . $images['cmd_submit'],
));

// send the display
$template->pparse('body');
include($get->url('admin/page_footer_admin'));

?>