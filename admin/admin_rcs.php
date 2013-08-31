<?php
/**
*
* @package rank_color_system_mod
* @version $Id: admin_rcs.php,v 0.16 31/01/2007 20:52 reddog Exp $
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
	$module['Color_Ranks']['rcs_b_manage'] = $file;

	return;
}

// load default header
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_rcs';
require('./pagestart.' . $phpEx);

/**
* ranks acp process
*/

class rcs_manage
{
	var $requester;
	var $data;
	var $root;
	var $ext;

	function rcs_manage($requester)
	{
		global $phpbb_root_path, $phpEx;

		$this->requester = $requester;
		$this->root = &$phpbb_root_path;
		$this->ext = &$phpEx;
	}

	function read()
	{
		global $db;

		$sql = 'SELECT *
			FROM ' . RCS_TABLE . '
			ORDER BY rcs_order ASC';
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain rank color system data', '', __LINE__, __FILE__, $sql);
		}

		$this->data = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$rcs_id = intval($row['rcs_id']);

			// allowed
			$this->data[$rcs_id] = array(
				'id' => $rcs_id,
				'name' => stripslashes($row['rcs_name']),
				'color' => stripslashes($row['rcs_color']),
				'single' => intval($row['rcs_single']),
				'display' => intval($row['rcs_display']),
				'order' => intval($row['rcs_order']),
			);
		}
		$db->sql_freeresult($result);
	}

	function _renum_order()
	{
		global $db;

		$sql = 'SELECT rcs_id
			FROM ' . RCS_TABLE . '
			ORDER BY rcs_order ASC';
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not select id field', '', __LINE__, __FILE__, $sql);
		}

		$inc = 0;
		while ($row = $db->sql_fetchrow($result))
		{
			$inc += 10;
			$sql = 'UPDATE ' . RCS_TABLE . '
				SET rcs_order = ' . $inc . '
				WHERE rcs_id = ' . intval($row['rcs_id']);
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update order fields', '', __LINE__, __FILE__, $sql);
			}
		}
		$db->sql_freeresult($result);
	}

	function _achievement($l_key)
	{
		global $get, $lang;

		$message = $lang[$l_key] . '<br /><br />' . sprintf($lang['rcs_click_return_manage'], '<a href="' . $get->url($this->requester, '', true) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . $get->url('admin/index', array('pane' => 'right'), true) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
}

/**
* ranks list process
*/

class rcs_list extends rcs_manage
{
	var $data;
	var $mode;

	function process($mode)
	{
		$this->init($mode);

		if (in_array($this->mode, array('moveup', 'movedw')))
		{
			$this->move();
		}

		$this->display();
	}

	function init($mode)
	{
		$this->mode = $mode;

		// grab all ranks available
		$this->read();
	}

	function move()
	{
		global $db, $lang;
		global $rcs;

		$rcs_id = request_var('id', TYPE_INT);

		if ( !isset($this->data[$rcs_id]['id']) )
		{
			// send achievement message
			$this->_achievement('rcs_not_exists');
		}
		else
		{
			// get the rank id to swap with the current one
			$keys = array_keys($this->data);

			// get rcs_id index
			$tkeys = array_flip($keys);
			$cur_idx = $tkeys[$rcs_id];
			unset($tkeys);

			// search for rank id to swap
			$swap_id = ( $this->mode == 'moveup' ) ? intval($keys[ ($cur_idx-1) ]) : intval($keys[ ($cur_idx+1) ]);

			// swap
			if ( $swap_id > 0 )
			{
				$sql = 'UPDATE ' . RCS_TABLE . '
					SET rcs_order = ' . $this->data[$swap_id]['order'] . '
					WHERE rcs_id = ' . $rcs_id;
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update order field', '', __LINE__, __FILE__, $sql);
				}

				$sql = 'UPDATE ' . RCS_TABLE . '
					SET rcs_order = ' . $this->data[$rcs_id]['order'] . '
					WHERE rcs_id = ' . $swap_id;
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update order field', '', __LINE__, __FILE__, $sql);
				}
			}
		}

		// re-cache ranks color variables
		$rcs->obtain_ids_colors(true);

		// send achievement message
		$this->_achievement('rcs_order_updated');
	}

	function display()
	{
		global $theme, $lang, $template;
		global $rcs, $get;

		// let's display the list
		$count_data = count($this->data);
		if ( $count_data > 0 )
		{
			// display details
			$i = 0;
			$throw = false;
			foreach ( $this->data as $rcs_id => $rank )
			{
				$throw = !$throw;
				$rcs_style = $rcs->get_style($rank['name'], $rank['color']);

				$rcs_is_single = !empty($rank['single']) ? $lang['Yes'] : $lang['No'];
				$rcs_is_display = !empty($rank['display']) ? $lang['Yes'] : $lang['No'];

				$template->assign_block_vars('rcs', array(
					'ROW_COLOR' => $throw ? '#' . $theme['td_color1'] : '#' . $theme['td_color2'],
					'ROW_CLASS' => $throw ? $theme['td_class1'] : $theme['td_class2'],
					'RCS_NAME' => $rank['name'],
					'RCS_COLOR' => $rank['color'],
					'RCS_STYLE' => $rcs_style,
					'RCS_SINGLE' => $rcs_is_single,
					'RCS_DISPLAY' => $rcs_is_display,

					'U_RCS_MOVEUP' => $get->url($this->requester, array('mode' => 'moveup', 'id' => $rcs_id), true),
					'U_RCS_MOVEDW' => $get->url($this->requester, array('mode' => 'movedw', 'id' => $rcs_id), true),
					'U_RCS_EDIT' => $get->url($this->requester, array('mode' => 'edit', 'id' => $rcs_id), true),
					'U_RCS_DELETE' => $get->url($this->requester, array('mode' => 'delete', 'id' => $rcs_id), true),
				));
				$i++;
			}
		}
		else
		{
			$template->assign_block_vars('empty', array());
		}

		// send to template
		$template->set_filenames(array('body' => 'admin/rcs_list_body.tpl'));
	}
}

/**
* ranks details process
*/

class rcs_details extends rcs_manage
{
	var $data;
	var $mode;
	var $rcs_id;

	function process($mode)
	{
		$this->init($mode);
		$this->action();
	}

	function init($mode)
	{
		$this->mode = $mode;

		// grab all ranks available
		if ( $this->mode != 'save' )
		{
			$this->read();
		}

		$this->rcs_id = request_var('id', TYPE_INT);
	}

	function action()
	{
		global $db, $template, $lang, $images;
		global $common, $rcs, $get;

		if ( $this->mode == 'edit' || $this->mode == 'add' )
		{
			if ( $this->mode == 'edit' )
			{
				if ( !isset($this->data[$this->rcs_id]['id']) )
				{
					// send achievement message
					$this->_achievement('rcs_not_exists');
				}

				// get this rank data
				$rank = $this->data[$this->rcs_id];

				// hidden fields
				_hide_build(array(
					'id' => $this->rcs_id,
					'rcs_tmp_name' => $rank['name'],
					'rcs_tmp_color' => $rank['color'],
					'rcs_tmp_order' => $rank['order'],
					'rcs_tmp_single' => $rank['single'],
					'rcs_tmp_display' => $rank['display'],
				));

				$style = $rcs->get_style($rank['name'], $rank['color']);

				$template->assign_block_vars('edit', array(
					'L_RCS_EDIT_TITLE' => sprintf($lang['rcs_edit_title'], $style, lang_item($rank['name'])),
					'L_RCS_EDIT_TITLE_DESC' => $lang['rcs_edit_title_desc'],
				));
			}
			else
			{
				// get the last rank
				$last_idx = count($this->data);
				$keys = array_values($this->data);
				$last_rank = $keys[ intval($last_idx-1) ];

				// set last rank data
				$rank['name'] = $rank['color'] = '';
				$rank['single'] = $rank['display'] = 0;

				// hidden fields
				_hide_build(array('rcs_tmp_order' => $last_rank['order']));

				$template->assign_block_vars('add', array(
					'L_RCS_ADD_TITLE' => $lang['rcs_add_title'],
					'L_RCS_ADD_TITLE_DESC' => $lang['rcs_add_title_desc'],
				));
			}

			$rcs_is_single = $rank['single'] ? ' checked="checked"' : '';
			$rcs_is_not_single = !$rank['single'] ? ' checked="checked"' : '';

			$rcs_is_display = $rank['display'] ? ' checked="checked"' : '';
			$rcs_is_not_display = !$rank['display'] ? ' checked="checked"' : '';

			// build list order
			$after = 0;
			$items = array();
			$list_move_after = array(0 => 'Top');

			if ( !empty($this->data) )
			{
				$keys = array_keys($this->data);
				$tkeys = array_flip($keys);
				$after = intval($keys[ ($tkeys[$this->rcs_id]-1) ]);
				unset($tkeys);

				foreach ( $this->data as $rank_id => $rank_data )
				{
					if ( $rank_id != $this->rcs_id )
					{
						$list_move_after[$rank_id] = $rank_data['name'];
					}
				}
			}

			if ( !empty($list_move_after) )
			{
				foreach ( $list_move_after as $val => $desc )
				{
					$items[] = array('name' => lang_item($desc), 'value' => $this->data[$val]['order'], 'style' => !empty($val) ? $rcs->get_style($desc, $this->data[$val]['color']) : '', 'selected' => ($val == $after));
				}
				$rcs_list_order = array('name' => 'rcs_order', 'items' => $items);
				$rcs->constructor($rcs_list_order, 'LIST_ORDER');
				unset($items);
			}

			// hidden fields
			_hide_send();

			// display
			$template->assign_vars(array(
				'RCS_NAME' => $rank['name'],
				'RCS_COLOR' => $rank['color'],
				'RCS_SINGLE' => $rcs_is_single,
				'RCS_NOT_SINGLE' => $rcs_is_not_single,
				'RCS_DISPLAY' => $rcs_is_display,
				'RCS_NOT_DISPLAY' => $rcs_is_not_display,

				'L_RCS_NAME' => $lang['rcs_name'],
				'L_RCS_NAME_DESC' => $lang['rcs_name_desc'],
				'L_RCS_COLOR' => $lang['rcs_color'],
				'L_RCS_COLOR_DESC' => $lang['rcs_color_desc'],
				'L_RCS_SINGLE' => $lang['rcs_single'],
				'L_RCS_SINGLE_DESC' => $lang['rcs_single_desc'],
				'L_RCS_DISPLAY' => $lang['rcs_display'],
				'L_RCS_DISPLAY_DESC' => $lang['rcs_display_desc'],
				'L_RCS_MOVE_AFTER' => $lang['rcs_move_after'],
				'L_PICK_COLOR' => $lang['rcs_pick_color'],
				'L_SUBMIT' => $lang['Submit'],
				'L_CANCEL' => $lang['Cancel'],
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],

				'I_SUBMIT' => $this->root . $images['cmd_submit'],
				'I_CANCEL' => $this->root . $images['cmd_cancel'],

				'S_RCS_ACTION' => $get->url($this->requester, '', true),
			));

			// send to template
			$template->set_filenames(array('body' => 'admin/rcs_edit_body.tpl'));
		}
		else if ( $this->mode == 'save' )
		{
			$rcs_name = request_var('rcs_name', TYPE_NO_HTML);
			$rcs_color = request_var('rcs_color', TYPE_NO_HTML);
			$rcs_single = request_var('rcs_single', TYPE_INT);
			$rcs_display = request_var('rcs_display', TYPE_INT);

			$rcs_tmp_name = request_var('rcs_tmp_name', TYPE_NO_HTML);
			$rcs_tmp_color = request_var('rcs_tmp_color', TYPE_NO_HTML);
			$rcs_tmp_single = request_var('rcs_tmp_single', TYPE_INT);
			$rcs_tmp_display = request_var('rcs_tmp_display', TYPE_INT);

			$rcs_tmp_order = request_var('rcs_tmp_order', TYPE_INT);
			$rcs_order = request_var('rcs_order', TYPE_INT);
			$rcs_order = ( ($rcs_order + 10) == $rcs_tmp_order ) ? $rcs_tmp_order : $rcs_order + 5;

			if ( $rcs_name == '' || ( !preg_match('/^[a-z0-9_-]*$/i', $rcs_name) && empty($rcs_color) ) )
			{
				// send achievement message
				$this->_achievement('rcs_must_fill');
			}

			// prepare data
			$rcs_name = $common->sql_type_cast($rcs_name, true);
			$rcs_color = !preg_match('/^[0-9a-f]{6}$/i', $rcs_color) ? '' : $rcs_color;
			$rcs_single = $common->sql_type_cast($rcs_single);
			$rcs_display = $common->sql_type_cast($rcs_display);
			$rcs_order = $common->sql_type_cast($rcs_order);

			if ( !empty($this->rcs_id) )
			{
				$sql = 'UPDATE ' . RCS_TABLE . '
					SET rcs_name = ' . $rcs_name . ', rcs_color = \'' . $rcs_color . '\', rcs_single = ' . $rcs_single . ', rcs_display = ' . $rcs_display . ', rcs_order = ' . $rcs_order . '
					WHERE rcs_id = ' . $this->rcs_id;

				$l_key = 'rcs_updated';
			}
			else
			{
				$rcs_new_order = $rcs_order - 5;
				$rcs_order = ( $rcs_tmp_order == $rcs_new_order ) ? $rcs_order + 5 : $rcs_order;

				$sql = 'INSERT INTO ' . RCS_TABLE . ' (rcs_name, rcs_color, rcs_single, rcs_display, rcs_order)
					VALUES (' . $rcs_name . ', \'' . $rcs_color . '\', ' . $rcs_single . ', ' . $rcs_display . ', ' . $rcs_order . ')';

				$rcs_order = ( $rcs_tmp_order == $rcs_new_order ) ? $rcs_tmp_order : $rcs_order;
				$l_key = 'rcs_added';
			}

			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update/insert into rank color system table', '', __LINE__, __FILE__, $sql);
			}

			// renum order
			if ( $rcs_order != $rcs_tmp_order )
			{
				$this->_renum_order();
			}

			// update colors if individual value has changed
			if ( ($rcs_single != $rcs_tmp_single) && !empty($this->rcs_id) )
			{
				// users/groups to update
				$list_ids = array();

				$sql = 'SELECT group_id
					FROM ' . GROUPS_TABLE . '
					WHERE group_color = ' . $this->rcs_id;
				if ( !empty($rcs_tmp_single) )
				{
					$patterns = array('group_id', GROUPS_TABLE, 'group_color');
					$replacements = array('user_id', USERS_TABLE, 'user_color');
					$sql = str_replace($patterns, $replacements, $sql);
				}
				if ( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Error getting group/user information', '', __LINE__, __FILE__, $sql);
				}
				while ($row = $db->sql_fetchrow($result))
				{
					$row_id = !empty($rcs_tmp_single) ? $row['user_id'] : $row['group_id'];
					if ( !empty($row_id) )
					{
						$list_ids[intval($row_id)] = true;
					}
				}
				$db->sql_freeresult($result);

				// delete users/groups color
				if ( !empty($list_ids) )
				{
					$result_ids = implode(', ', array_keys($list_ids));
					$rcs->update_colors($result_ids, $rcs_tmp_single, 0);
				}

			}

			// re-cache ranks color variables, if necessary
			$has_modified = ( $rcs_tmp_name != $rcs_name ) || ( $rcs_tmp_color != $rcs_color ) || ( $rcs_tmp_single != $rcs_single ) || ( $rcs_tmp_display != $rcs_display );
			if ( $has_modified )
			{
				$rcs->obtain_ids_colors(true);
			}

			// send achievement message
			$this->_achievement($l_key);
		}
		else if ( $this->mode == 'delete' )
		{
			if ( !isset($this->data[$this->rcs_id]['id']) )
			{
				// send achievement message
				$this->_achievement('rcs_not_exists');
			}

			$confirm = request_var('confirm', TYPE_NO_HTML);

			if ( !empty($confirm) )
			{
				$sql = 'DELETE FROM ' . RCS_TABLE . '
					WHERE rcs_id = ' . $this->rcs_id;
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete rank color', '', __LINE__, __FILE__, $sql);
				}

				// renum order
				$this->_renum_order();

				// users/groups to update
				$list_ids = array();
				$rcs_tmp_single = $this->data[$this->rcs_id]['single'];

				$sql = 'SELECT group_id
					FROM ' . GROUPS_TABLE . '
					WHERE group_color = ' . $this->rcs_id;
				if ( !empty($rcs_tmp_single) )
				{
					$patterns = array('group_id', GROUPS_TABLE, 'group_color');
					$replacements = array('user_id', USERS_TABLE, 'user_color');
					$sql = str_replace($patterns, $replacements, $sql);
				}
				if ( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Error getting group/user information', '', __LINE__, __FILE__, $sql);
				}
				while ($row = $db->sql_fetchrow($result))
				{
					$row_id = !empty($rcs_tmp_single) ? $row['user_id'] : $row['group_id'];
					if ( !empty($row_id) )
					{
						$list_ids[intval($row_id)] = true;
					}
				}
				$db->sql_freeresult($result);

				// delete users/groups color
				if ( !empty($list_ids) )
				{
					$result_ids = implode(', ', array_keys($list_ids));
					$rcs->update_colors($result_ids, $rcs_tmp_single, false, true);
				}

				// re-cache ranks color variables
				$rcs->obtain_ids_colors(true);

				// send achievement message
				$this->_achievement('rcs_removed');
			}
			else
			{
				// hidden fields
				_hide_build(array('mode' => 'delete', 'id' => $this->rcs_id));
				_hide_send();

				$template->assign_vars(array(
					'MESSAGE_TITLE' => $lang['Confirm'],
					'MESSAGE_TEXT' => $lang['rcs_confirm_delete'],

					'L_YES' => $lang['Yes'],
					'L_NO' => $lang['No'],

					'S_CONFIRM_ACTION' => $get->url($this->requester, '', true),
				));

				// send to template
				$template->set_filenames(array('body' => 'admin/confirm_body.tpl'));
			}
		}
	}
}

/**
* main process
*/

// instantiate common class
$common = new common();

// instantiate some objects
$rcs_list = new rcs_list($requester);

// get parms
$cancel = request_var('cancel', TYPE_NO_HTML);
$mode = request_var('mode', TYPE_NO_HTML);

// define $mode with additional parameters
$mode = _butt('submit_form') ? 'save' : ( _butt('cancel_form') ? '' : $mode);
$mode = !empty($cancel) ? '' : $mode;

// let's go
switch ($mode)
{
	case 'add':
	case 'edit':
	case 'save':
	case 'delete':
		$rcs_details = new rcs_details($requester);
		$rcs_details->process($mode);
		break;
	case '':
	case 'moveup':
	case 'movedw':
		$rcs_list->process($mode);
		$mode = '';
		break;
	default:
		$rcs_list->_achievement('rcs_no_valid_action');
		break;
}

// constants
$template->assign_vars(array(
	'L_RCS_MANAGE_TITLE' => $lang['rcs_manage_title'],
	'L_RCS_MANAGE_TITLE_DESC' => $lang['rcs_manage_title_desc'],
	'L_RCS_NAME' => $lang['rcs_name'],
	'L_RCS_COLOR' => $lang['rcs_color'],
	'L_RCS_SINGLE' => $lang['rcs_single'],
	'L_RCS_DISPLAY' => $lang['rcs_display'],
	'L_MOVEUP' => $lang['Move_up'],
	'L_MOVEDW' => $lang['Move_down'],
	'L_EDIT' => $lang['Edit'],
	'L_DELETE' => $lang['Delete'],
	'L_CREATE' => $lang['Create_new'],
	'L_ACTION' => $lang['Action'],
	'L_EMPTY' => $lang['rcs_no_ranks_create'],

	'I_MOVEUP' => $phpbb_root_path . $images['cmd_up_arrow'],
	'I_MOVEDW' => $phpbb_root_path . $images['cmd_down_arrow'],
	'I_EDIT' => $phpbb_root_path . $images['cmd_edit'],
	'I_DELETE' => $phpbb_root_path . $images['cmd_delete'],
	'I_CREATE' => $phpbb_root_path . $images['cmd_create'],

	'U_RCS_CREATE' => $get->url($requester, array('mode' => 'add'), true),

	'S_RCS_ACTION' => $get->url($requester, '', true),
));

// send the display
$template->pparse('body');
include($get->url('admin/page_footer_admin'));

?>