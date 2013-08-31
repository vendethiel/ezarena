<?php
/**
*
* @package quick_title_edition_mod
* @version $Id: admin_quick_title.php,v 1.6.7 2007/11/21 12:00 OxyGen Powered Exp $
* @copyright (c) 2007 ABDev, OxyGen Powered
* @copyright (c) 2007 PastisD, OxyGen Powered
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Original author : Xavier Olive, xavier@2037.biz, 2003
*/

/**
* begin process
*/
define('IN_PHPBB', 1);

if (!empty($setmodules))
{
	$file = basename(__FILE__);
	$module['General']['Attributes'] = $file;

	return;
}

/**
* Let's set the root dir for phpBB
*/
$phpbb_root_path = './../';
$requester = 'admin/admin_quick_title';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

include($get->url('includes/class_attributes'));

/**
* Get parms
*/
$cancel = request_var('cancel', TYPE_NO_HTML);
$mode = request_var('mode', TYPE_NO_HTML);

/**
* Define $mode with additional parameters
*/
$mode = _butt('submit_form') ? 'save' : ( _butt('cancel_form') ? '' : $mode);
$mode = !empty($cancel) ? '' : $mode;

if (!empty($mode))
{
	if ($mode == 'edit' || $mode == 'add')
	{
		/**
		* They want to add a new title info, show the form
		*/
		$attribute_id = request_var('id', TYPE_INT);
		$s_hidden_fields = '';

		if ($mode == 'edit')
		{
			if ( empty($attribute_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['Must_Select_Attribute']);
			}

			$sql = 'SELECT * FROM ' . ATTRIBUTES_TABLE . ' WHERE attribute_id = ' . intval($attribute_id);
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, $lang['Attr_Error_Message_01'], '', __LINE__, __FILE__, $sql);
			}

			$attribute = $db->sql_fetchrow($result);

			$attribute_tmp_order = $attribute['attribute_order'];

			_hide_build(array(
				'id' => $attribute_id,
				'attribute_tmp_order' => $attribute_tmp_order,
			));

			$template->assign_vars(array(
				'L_TITLE'					=> sprintf($lang['Attribute_Edit'], get_color($attribute['attribute'], $attribute['attribute_color']), ((isset($lang[$attribute['attribute']])) ? $lang[$attribute['attribute']] : $attribute['attribute'])),
				'L_TITLE_EXPLAIN'	=> $lang['Attribute_Edit_Explain'],
			));
		}
		else
		{
			$sql = 'SELECT attribute_id, attribute_order FROM ' . ATTRIBUTES_TABLE . ' ORDER BY attribute_order DESC LIMIT 1';
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, $lang['Attr_Error_Message_02'], '', __LINE__, __FILE__, $sql);
			}

			$attribute_disp = $db->sql_fetchrow($result);

			$attribute_last_id = $attribute_disp['attribute_id'];
			$attribute_tmp_order = $attribute_disp['attribute_order'];

			_hide_build(array('attribute_tmp_order' => $attribute_tmp_order));

			$attribute_tmp_order += 10;

			$template->assign_vars(array(
				'L_TITLE'					=> $lang['New_Attribute'],
				'L_TITLE_EXPLAIN'	=> $lang['New_Attribute_Explain'],
			));
		}

		_hide_send();

		$template->assign_vars(array(
			'TYPE_IMAGE'								=> !$attribute['attribute_type'] ? '' : ' selected="selected"',
			'DISPLAY_IMAGE'							=> !$attribute['attribute_type'] ? 'display:none' : '',

			'ATTRIBUTE'									=> str_replace("\"", "'", $attribute['attribute']),
			'ATTRIBUTE_IMAGE'						=> $attribute['attribute_image'],
			'ADMINISTRATOR_CHECKED'			=> $attribute['attribute_administrator'] ? 'checked="checked"' : '',
			'MODERATOR_CHECKED'					=> $attribute['attribute_moderator'] ? 'checked="checked"' : '',
			'AUTHOR_CHECKED'						=> $attribute['attribute_author'] ? 'checked="checked"' : '',
			'DATE_FORMAT'								=> $attribute['attribute_date_format'],
			'LEFT'											=> !$attribute['attribute_position'] ? 'checked="checked"' : '',
			'RIGHT'											=> $attribute['attribute_position'] ? 'checked="checked"' : '',
			'COLOR'											=> str_replace("\"", "'", $attribute['attribute_color']),

			'L_ATTRIBUTE_TYPE'					=> $lang['Attribute_Type'],
			'L_ATTRIBUTE_TYPE_EXPLAIN'	=> $lang['Attribute_Type_Explain'],
				'L_TEXT'									=> $lang['Text'],
				'L_IMAGE'									=> $lang['Image'],

			'L_ATTRIBUTE'								=> $lang['Attribute'],
			'L_ATTRIBUTE_EXPLAIN'				=> $lang['Attribute_Explain'],

			'L_ATTRIBUTE_IMAGE'					=> $lang['Attribute_Image'],
			'L_ATTRIBUTE_IMAGE_EXPLAIN'	=> $lang['Attribute_Image_Explain'],

			'L_PERMISSIONS'							=> $lang['Attribute_Permissions'],
			'L_PERMISSIONS_EXPLAIN'			=> $lang['Attribute_Permissions_Explain'],
				'ADMINISTRATOR'						=> $lang['Administrator'],
				'MODERATOR'								=> $lang['Moderator'],
				'AUTHOR'									=> $lang['Author'],

			'L_DATE_FORMAT'							=> $lang['Date_format'],
			'L_DATE_FORMAT_EXPLAIN'			=> $lang['Date_format_explain'],

			'L_POSITION'								=> $lang['Attribute_Position'],
			'L_POSITION_EXPLAIN'				=> $lang['Attribute_Position_Explain'],
				'L_LEFT'									=> $lang['Left'],
				'L_RIGHT'									=> $lang['Right'],

			'L_COLOR'										=> $lang['Attribute_Color'],
			'L_COLOR_EXPLAIN'						=> $lang['Attribute_Color_Explain'],

			'L_SUBMIT'									=> $lang['Submit'],
			'L_RESET'										=> $lang['Reset'],

			'I_SUBMIT'									=> $phpbb_root_path . $images['cmd_submit'],
			'I_CANCEL'									=> $phpbb_root_path . $images['cmd_cancel'],

			'S_ATTR_ACTION'							=> $get->url($requester, '', true),
		));

		/**
		*	Send to template
		*/
		$template->set_filenames(array('body' => 'admin/title_edit_body.tpl'));
	}
	else if ($mode == 'save')
	{
		/**
		* Ok, they sent us our info, let's update it
		*/
		$attribute			= request_var('attribute', TYPE_NO_HTML);
		$attribute_id		= request_var('id', TYPE_INT);
		$type				= request_var('attribute_type', TYPE_NO_HTML);
		$attribute_image	= request_var('attribute_image', TYPE_NO_HTML);
		$administrator		= $HTTP_POST_VARS['attribute_administrator'] ? 1 : 0;
		$moderator			= $HTTP_POST_VARS['attribute_moderator'] ? 1 : 0;
		$author				= $HTTP_POST_VARS['attribute_author'] ? 1 : 0;
		$date				= request_var('attribute_date_format', TYPE_NO_HTML);
		$position			= empty($HTTP_POST_VARS['attribute_position']) ? 0 : 1;
		$color				= request_var('attribute_color', TYPE_NO_HTML);
		$tmp_order			= request_var('attribute_tmp_order', TYPE_INT);
		$order				= isset($HTTP_POST_VARS['attribute_order']) ? (intval($HTTP_POST_VARS['attribute_order']) + 1) : $tmp_order;

		if ( empty($attribute) )
		{
			message_die(GENERAL_MESSAGE, $lang['Attr_Error_Message_14']);
		}

		if ( empty($attribute_image) && $type )
		{
			message_die(GENERAL_MESSAGE, $lang['Attr_Error_Message_13']);
		}

		if ( $attribute_id )
		{
			$sql = 'UPDATE ' . ATTRIBUTES_TABLE . ' 
				SET attribute_type = \'' . str_replace("\'", "''", $type) . '\', attribute = \'' . str_replace("\'", "''", $attribute) . '\', attribute_image= \'' . str_replace("\'", "''", $attribute_image) . '\', attribute_color = \'' . str_replace("\'", "''", $color) . '\', attribute_date_format = \'' . str_replace("\'", "''", $date) . '\', attribute_position = ' . $position . ', attribute_administrator = ' . $administrator . ', attribute_moderator = ' . $moderator . ', attribute_author = ' . $author . ', attribute_order = ' . $order . '
				WHERE attribute_id = ' . intval($attribute_id);
			$message = $lang['Attribute_Updated'];
		}
		else
		{
			$new_order = $order - 1;
			$order = ($tmp_order == $new_order) ? $order + 9 : $order;

			$sql = 'INSERT INTO ' . ATTRIBUTES_TABLE . ' (attribute_type, attribute, attribute_image, attribute_color, attribute_administrator, attribute_moderator, attribute_author, attribute_date_format, attribute_position, attribute_order)
				VALUES (\'' . str_replace("\'", "''", $type) . '\', \'' . str_replace("\'", "''", $attribute) . '\', \'' . str_replace("\'", "''", $attribute_image) . '\', \'' . str_replace("\'", "''", $color) . '\', ' . $administrator . ', ' . $moderator . ', ' . $author . ', \'' . str_replace("\'", "''", $date) . '\', ' . $position . ', ' . $order . ')';
			$message = $lang['Attribute_Added'];
		}

		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, $lang['Attr_Error_Message_03'], '', __LINE__, __FILE__, $sql);
		}

		if ( $order != $tmp_order )
		{
			$sql = 'SELECT attribute_id FROM ' . ATTRIBUTES_TABLE . ' ORDER BY attribute_order';
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, $lang['Attr_Error_Message_04'], '', __LINE__, __FILE__, $sql);
			}

			$inc = 0;
			while ($row = $db->sql_fetchrow($result))
			{
				$inc += 10;
				$sql = 'UPDATE ' . ATTRIBUTES_TABLE . ' SET attribute_order = ' . $inc . ' WHERE attribute_id = ' . intval($row['attribute_id']);
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, $lang['Attr_Error_Message_05'], '', __LINE__, __FILE__, $sql);
				}
			}
			$db->sql_freeresult($result);
		}

		$message .= '<br /><br />' . sprintf($lang['Click_Return_Attributes_Management'], '<a href="' . $get->url($requester, '', true) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . $get->url('admin/index', array('pane' => 'right'), true) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
	else if ($mode == 'delete')
	{
		/**
		* Ok, they want to delete their attribute
		*/
		$attribute_id = 0;
		if ( isset($HTTP_POST_VARS['id']) || isset($HTTP_GET_VARS['id']) )
		{
			$attribute_id = request_var('id', TYPE_INT);
		}

		$confirm = isset($HTTP_POST_VARS['confirm']);

		if ( $attribute_id && $confirm )
		{
			$sql = 'DELETE FROM ' . ATTRIBUTES_TABLE . ' WHERE attribute_id = ' . intval($attribute_id);
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, $lang['Attr_Error_Message_06'], '', __LINE__, __FILE__, $sql);
			}

			$sql = 'SELECT attribute_id FROM ' . ATTRIBUTES_TABLE . ' ORDER BY attribute_order';
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, $lang['Attr_Error_Message_04'], '', __LINE__, __FILE__, $sql);
			}

			$inc = 0;
			while ( $row = $db->sql_fetchrow($result) )
			{
				$inc += 10;
				$sql = 'UPDATE ' . ATTRIBUTES_TABLE . ' SET attribute_order = ' . $inc . ' WHERE attribute_id = ' . intval($row['attribute_id']);
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, $lang['Attr_Error_Message_05'], '', __LINE__, __FILE__, $sql);
				}
			}
			$db->sql_freeresult($result);

			$message = $lang['Attribute_Removed'] . '<br /><br />' . sprintf($lang['Click_Return_Attributes_Management'], '<a href="' . $get->url($requester, '', true) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . $get->url('admin/index', array('pane' => 'right'), true) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}
		elseif ($attribute_id && !$confirm)
		{
			/**
			* Present the confirmation screen to the user
			*/
			$template->set_filenames(array('body' => 'admin/confirm_body.tpl'));

			_hide_build(array('mode' => 'delete', 'id' => $attribute_id));
			_hide_send();

			$template->assign_vars(array(
				'MESSAGE_TITLE'			=> $lang['Confirm'],
				'MESSAGE_TEXT'			=> $lang['Attribute_Confirm_Delete'],
				'L_YES'							=> $lang['Yes'],
				'L_NO'							=> $lang['No'],
				'S_CONFIRM_ACTION'	=> $get->url($requester, '', true),
			));
		}
		else
		{
			message_die(GENERAL_MESSAGE, $lang['Must_Select_Attribute']);
		}
	}
	else if ( $mode == 'moveup' || $mode == 'movedw' )
	{
		$inc = ($mode == 'movedw') ? +15 : -15;
		$attribute_id = request_var('id', TYPE_INT);

		if ( empty($attribute_id) )
		{
			$message = $lang['Must_Select_Attribute'] . '<br /><br />' . sprintf($lang['Click_Return_Attributes_Management'], '<a href="' . $get->url($requester, '', true) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . $get->url('admin/index', array('pane' => 'right'), true) . '">', '</a>');
			message_die(GENERAL_MESSAGE, $message);
		}

		$sql = 'UPDATE ' . ATTRIBUTES_TABLE . ' SET attribute_order = attribute_order + ' . $inc . ' WHERE attribute_id = ' . intval($attribute_id);
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, $lang['Attr_Error_Message_05'], '', __LINE__, __FILE__, $sql);
		}

		$sql = 'SELECT attribute_id FROM ' . ATTRIBUTES_TABLE . ' ORDER BY attribute_order';
		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, $lang['Attr_Error_Message_04'], '', __LINE__, __FILE__, $sql);
		}

		$inc = 0;
		while ( $row = $db->sql_fetchrow($result) )
		{
			$inc += 10;
			$sql = 'UPDATE ' . ATTRIBUTES_TABLE . ' SET attribute_order = ' . $inc . ' WHERE attribute_id = ' . intval($row['attribute_id']);
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, $lang['Attr_Error_Message_05'], '', __LINE__, __FILE__, $sql);
			}
		}
		$db->sql_freeresult($result);

		$message = $lang['Attribute_Order_Updated'] . '<br /><br />' . sprintf($lang['Click_Return_Attributes_Management'], '<a href="' . $get->url($requester, '', true) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . $get->url('admin/index', array('pane' => 'right'), true) . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
}
else
{
	/**
	* Show the default page
	*/
	$template->set_filenames(array('body' => 'admin/title_list_body.tpl'));

	$sql = 'SELECT * FROM ' . ATTRIBUTES_TABLE . ' ORDER BY attribute_order ASC';
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, $lang['Attr_Error_Message_09'], '', __LINE__, __FILE__, $sql);
	}

	$row = $db->sql_fetchrowset($result);
	$row_count = count($row);

	for ( $i = 0; $i < $row_count; $i++ )
	{
		$permissions		= $row[$i]['attribute_administrator'] ? $lang['Administrator'] . '<br />' : '';
		$permissions		.= $row[$i]['attribute_moderator'] ? $lang['Moderator'] . '<br />' : '';
		$permissions		.= $row[$i]['attribute_author'] ? $lang['Author'] : '';

		$color					= trim($row[$i]['attribute_color']);
		$text						= lang_item($row[$i]['attribute']);
		$image					= '<img src="' . $phpbb_root_path . image_item($row[$i]['attribute_image']) . '" alt="' . $text . '" title="' . $text . '" />';

		$template->assign_block_vars('attribute', array(
			'ROW_CLASS'		=> !($i % 2) ? $theme['td_class1'] : $theme['td_class2'],

			'ATTRIBUTE'		=> !$row[$i]['attribute_type'] ? '<span ' . get_color($row[$i]['attribute'], $color) . '>' . $text  . '</span>' : $image,
			'COLOR'				=> $row[$i]['attribute_color'] ? '<span ' . get_color($row[$i]['attribute'], $color) . '>' . $color  . '</span>' : $lang['Attribute_None'],
			'PERMISSIONS'	=> $permissions,
			'DATE_FORMAT'	=> $row[$i]['attribute_date_format'] ? $row[$i]['attribute_date_format'] : $lang['Attribute_None'],
			'POSITION'		=> !$row[$i]['attribute_position'] ? $lang['Left'] : $lang['Right'],

			'U_MOVEUP'		=> $get->url($requester, array('mode' => 'moveup', 'id' => $row[$i]['attribute_id']), true),
			'U_MOVEDW'		=> $get->url($requester, array('mode' => 'movedw', 'id' => $row[$i]['attribute_id']), true),
			'U_EDIT'			=> $get->url($requester, array('mode' => 'edit', 'id' => $row[$i]['attribute_id']), true),
			'U_DELETE'		=> $get->url($requester, array('mode' => 'delete', 'id' => $row[$i]['attribute_id']), true),
		));
	}

	$template->assign_vars(array(
		'L_TITLE'					=> $lang['Attributes_System'],
		'L_TITLE_EXPLAIN'	=> $lang['Attributes_System_Explain'],
		'L_ATTRIBUTE'			=> $lang['Attribute'],
		'L_COLOR'					=> $lang['Attribute_Color'],
		'L_PERMISSIONS'		=> $lang['Attribute_Permissions'],
		'L_DATE_FORMAT'		=> $lang['Date_format'],
		'L_POSITION'			=> $lang['Attribute_Position'],
		'L_MOVEUP'				=> $lang['Move_up'],
		'L_MOVEDW'				=> $lang['Move_down'],
		'L_CREATE'				=> $lang['Create_new'],
		'L_ACTION'				=> $lang['Action'],

		'I_MOVEUP'				=> $phpbb_root_path . $images['cmd_up_arrow'],
		'I_MOVEDW'				=> $phpbb_root_path . $images['cmd_down_arrow'],
		'I_DELETE'				=> $phpbb_root_path . $images['cmd_delete'],
		'I_EDIT'					=> $phpbb_root_path . $images['cmd_edit'],
		'I_CREATE'				=> $phpbb_root_path . $images['cmd_create'],

		'U_CREATE'				=> $get->url($requester, array('mode' => 'add'), true),
		'S_ATTR_ACTION'		=> $get->url($requester),
	));
}

$template->pparse('body');
include($get->url('admin/page_footer_admin'));

?>
