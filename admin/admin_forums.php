<?php
/***************************************************************************
 *                             admin_forums.php
 *                            -------------------
 *   begin                : Thursday, Jul 12, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: admin_forums.php,v 1.40.2.13 2006/03/09 21:55:09 grahamje Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Forums']['Manage'] = $file;
	return;
}

//
// Load default header
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
include($phpbb_root_path . 'includes/bbc_box_tags.'.$phpEx);
//-- mod: sf
include($phpbb_root_path . 'includes/functions_sf.' . $phpEx);
include($phpbb_root_path . 'includes/functions_sf_admin.' . $phpEx);
_sf_lang($lang);

$_sf_tree = new _sf_tree();
$_sf_tree->read();
//-- mod: sf - end
$forum_auth_ary = array(
	"auth_view" => AUTH_ALL, 
	"auth_read" => AUTH_ALL, 
	"auth_post" => AUTH_REG, 
	"auth_reply" => AUTH_REG, 
	"auth_edit" => AUTH_REG, 
	"auth_delete" => AUTH_REG, 
	"auth_sticky" => AUTH_MOD, 
	"auth_announce" => AUTH_MOD, 
	"auth_vote" => AUTH_REG, 
	"auth_pollcreate" => AUTH_REG,
	"auth_ban" => AUTH_MOD, 
	"auth_greencard" => AUTH_ADMIN, 
	"auth_bluecard" => AUTH_REG
);

//-- mod : Edit Forums On Index -----------------------------------------------------
//-- add			
			$in_from = ($_POST['popup']) ? $_POST['popup'] : $HTTP_POST_VARS['popup'];
			if ( ($in_from) && ($userdata['user_level'] != ADMIN) )
				message_die(GENERAL_ERROR, '<a href="#" onclick="javascript:window.close();">'. $lang['close_popup'] .'</a>');
//-- fin mod : Edit Forums On Index -------------------------------------------------

$forum_auth_ary['auth_attachments'] = AUTH_REG;
$forum_auth_ary['auth_download'] = AUTH_REG;

//
// Mode setting
//
if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = "";
}

// ------------------
// Begin function block
//
function get_info($mode, $id)
{
	global $db;

	switch($mode)
	{
		case 'category':
			$table = CATEGORIES_TABLE;
			$idfield = 'cat_id';
			$namefield = 'cat_title';
			break;

		case 'forum':
			$table = FORUMS_TABLE;
			$idfield = 'forum_id';
			$namefield = 'forum_name';
			break;

		default:
			message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
	}
	$sql = "SELECT count(*) as total
		FROM $table";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get Forum/Category information", "", __LINE__, __FILE__, $sql);
	}
	$count = $db->sql_fetchrow($result);
	$count = $count['total'];

	$sql = "SELECT *
		FROM $table
		WHERE $idfield = $id"; 

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get Forum/Category information", "", __LINE__, __FILE__, $sql);
	}

	if( $db->sql_numrows($result) != 1 )
	{
		message_die(GENERAL_ERROR, "Forum/Category doesn't exist or multiple forums/categories with ID $id", "", __LINE__, __FILE__);
	}

	$return = $db->sql_fetchrow($result);
	$return['number'] = $count;
	return $return;
}

function get_list($mode, $id, $select)
{
	global $db;

	switch($mode)
	{
		case 'category':
			$table = CATEGORIES_TABLE;
			$idfield = 'cat_id';
			$namefield = 'cat_title';
			break;

		case 'forum':
			$table = FORUMS_TABLE;
			$idfield = 'forum_id';
			$namefield = 'forum_name';
			break;

		default:
			message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
	}

	$sql = "SELECT *
		FROM $table";
	if( $select == 0 )
	{
		$sql .= " WHERE $idfield <> $id";
	}

	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Categories/Forums", "", __LINE__, __FILE__, $sql);
	}

	$cat_list = "";

	while( $row = $db->sql_fetchrow($result) )
	{
		$s = "";
		if ($row[$idfield] == $id)
		{
			$s = " selected=\"selected\"";
		}
		$catlist .= "<option value=\"$row[$idfield]\"$s>" . $row[$namefield] . "</option>\n";
	}

	return($catlist);
}

function renumber_order($mode, $cat = 0)
{
	global $db;

	switch($mode)
	{
		case 'category':
			$table = CATEGORIES_TABLE;
			$idfield = 'cat_id';
			$orderfield = 'cat_order';
			$cat = 0;
			break;

		case 'forum':
			$table = FORUMS_TABLE;
			$idfield = 'forum_id';
			$orderfield = 'forum_order';
			$catfield = 'cat_id';
			break;

		default:
			message_die(GENERAL_ERROR, "Wrong mode for generating select list", "", __LINE__, __FILE__);
			break;
	}

	$sql = "SELECT * FROM $table";
	if( $cat != 0)
	{
		$sql .= " WHERE $catfield = $cat";
	}
	$sql .= " ORDER BY $orderfield ASC";


	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't get list of Categories", "", __LINE__, __FILE__, $sql);
	}

	$i = 10;
	$inc = 10;

	while( $row = $db->sql_fetchrow($result) )
	{
		$sql = "UPDATE $table
			SET $orderfield = $i
			WHERE $idfield = " . $row[$idfield];
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update order fields", "", __LINE__, __FILE__, $sql);
		}
		$i += 10;
	}

}
//
// End function block
// ------------------

//
// Begin program proper
//
if( isset($HTTP_POST_VARS['addforum']) || isset($HTTP_POST_VARS['addcategory']) )
{
	$mode = ( isset($HTTP_POST_VARS['addforum']) ) ? "addforum" : "addcat";

	if( $mode == "addforum" )
	{
		list($cat_id) = each($HTTP_POST_VARS['addforum']);
		$cat_id = intval($cat_id);
		// 
		// stripslashes needs to be run on this because slashes are added when the forum name is posted
		//
		$forumname = stripslashes($HTTP_POST_VARS['forumname'][$cat_id]);
	}
}
if( !empty($HTTP_POST_VARS['password']) )
{
	if( !preg_match("#^[A-Za-z0-9]{3,20}$#si", $HTTP_POST_VARS['password']) )
	{
		message_die(GENERAL_MESSAGE, $lang['Only_alpha_num_chars']);
	}
}
if( !empty($mode) ) 
{
	switch($mode)
	{
		case 'addforum':
		case 'editforum':
			//
			// Show form to create/modify a forum
			//
			// Forum Icon MOD
			$dir = @opendir($phpbb_root_path . $board_config['forum_icon_path']);
			$count = 0;
			while( $file = @readdir($dir) )
			{
				if( !@is_dir(phpbb_realpath($phpbb_root_path . $board_config['forum_icon_path'] . '/' . $file)) )
				{
					if( preg_match('/(\.gif$|\.png$|\.jpg|\.jpeg)$/is', $file) )
					{
						$forum_icons[$count] = $file; 
						$count++;
					}
				}
			}

			@closedir($dir);
				
			if ($mode == 'addforum')
			{
				$forum_icons_list = "";
				$default_ficon = $forum_icons[0];
				for( $i = 0, $c = count($forum_icons); $i < $c; $i++ )
				{
					$selected = false === strpos($forum_icons[$i], 'rien') ? '' : ' selected="selected"';
					$forum_icons_list .= '<option value="' . $forum_icons[$i] . '"' . $selected . '>'
					 . $forum_icons[$i] . '</option>';
					if ($selected)
					{
						$default_ficon = $forum_icons[$i];
					}
				}
			}			
			if ($mode == 'editforum')
			{
				// $newmode determines if we are going to INSERT or UPDATE after posting?

				$l_title = $lang['Edit_forum'];
				$newmode = 'modforum';
				$buttonvalue = $lang['Update'];

				$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

				$row = get_info('forum', $forum_id);

				$cat_id = $row['cat_id'];
				$forumname = $row['forum_name'];
				$forumdesc = $row['forum_desc'];
				$forumdesc_long = $row['forum_desc_long'];
				$forumstatus = $row['forum_status'];
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
				$forum_display_sort = $row['forum_display_sort'];
				$forum_display_order = $row['forum_display_order'];
//-- fin mod : topic display order -----------------------------------------------------------------				
				$forum_password = $row['forum_password'];
				$forum_enter_limit = $row['forum_enter_limit'];
				$forumicon = $row['forum_icon']; // Forum Icon MOD

				// Forum Icon MOD - New fix for 1.0.8
				$forum_icons_list = "";
				for( $i = 0; $i < count($forum_icons); $i++ )
				{
					if ($forum_icons[$i] == $row['forum_icon'])
					{
						$forum_icons_list .= '<option value="' . $forum_icons[$i] . '" selected="selected">' . $forum_icons[$i] . '</option>';
					}
					else
					{
						$forum_icons_list .= '<option value="' . $forum_icons[$i] . '">' . $forum_icons[$i] . '</option>';
					}
					$default_ficon = $forum_icons[0];
				}
				$forum_external = $row['forum_external'];
				$forum_redirect_url = $row['forum_redirect_url'];
				$forum_ext_newwin = $row['forum_ext_newwin'];
				$forum_ext_image = $row['forum_ext_image'];				
//-- mod : quick post es -------------------------------------------------------
//-- add
				$forum_qpes = $row['forum_qpes'];
//-- fin mod : quick post es ---------------------------------------------------				

				//
				// start forum prune stuff.
				//
				if( $row['prune_enable'] )
				{
					$prune_enabled = "checked=\"checked\"";
					$sql = "SELECT *
               			FROM " . PRUNE_TABLE . "
               			WHERE forum_id = $forum_id";
					if(!$pr_result = $db->sql_query($sql))
					{
						 message_die(GENERAL_ERROR, "Auto-Prune: Couldn't read auto_prune table.", __LINE__, __FILE__);
        			}

					$pr_row = $db->sql_fetchrow($pr_result);
				}
				else
				{
					$prune_enabled = '';
				}
			}
			else
			{
				$l_title = $lang['Create_forum'];
				$newmode = 'createforum';
				$buttonvalue = $lang['Create_forum'];

				$forumdesc = '';
				$forumdesc_long = '';
				$forumstatus = FORUM_UNLOCKED;
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
				$forum_display_sort = 0;
				$forum_display_order = 0;
//-- fin mod : topic display order -----------------------------------------------------------------				
				$forum_password = '';				
				$forum_enter_limit = '';
				$forumicon = ''; // Forum Icon MOD				
//-- mod : quick post es -------------------------------------------------------
//-- add
				$forum_qpes = 1;
//-- fin mod : quick post es ---------------------------------------------------				
				$forum_id = ''; 
				$prune_enabled = '';
				$forum_external = '0';
				$forum_redirect_url = '';
				$forum_ext_newwin = '0';
				$forum_ext_image = '';				
			}

			$forumstatus == ( FORUM_LOCKED ) ? $forumlocked = "selected=\"selected\"" : $forumunlocked = "selected=\"selected\"";
			
			// These two options ($lang['Status_unlocked'] and $lang['Status_locked']) seem to be missing from
			// the language files.
			$lang['Status_unlocked'] = isset($lang['Status_unlocked']) ? $lang['Status_unlocked'] : 'Unlocked';
			$lang['Status_locked'] = isset($lang['Status_locked']) ? $lang['Status_locked'] : 'Locked';
			
			$statuslist = "<option value=\"" . FORUM_UNLOCKED . "\" $forumunlocked>" . $lang['Status_unlocked'] . "</option>\n";
			$statuslist .= "<option value=\"" . FORUM_LOCKED . "\" $forumlocked>" . $lang['Status_locked'] . "</option>\n";
			if ($row['points_disabled'])
			{
				$yes = 'selected="selected"';
			}
			else
			{
				$no = 'selected="selected"';
			}
			$pointslist = '<option value="' . TRUE . '" ' . $yes . '>' . $lang['Yes'] . '</option>';
			$pointslist .= '<option value="' . FALSE . '" ' . $no . '>' . $lang['No'] . '</option>';			

			$template->set_filenames(array(
				"body" => "admin/forum_edit_body.tpl")
			);
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
			$forum_display_sort_list = get_forum_display_sort_option($forum_display_sort, 'list', 'sort');
			$forum_display_order_list = get_forum_display_sort_option($forum_display_order, 'list', 'order');
//-- fin mod : topic display order -----------------------------------------------------------------			

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode .'" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';
//-- mod : Edit Forums On Index -----------------------------------------------------
//-- add
			$in_from = ($_GET['in_from']) ? $_GET['in_from'] : $HTTP_GET_VARS['in_from'];
			if (isset($in_from))
				$s_hidden_fields .= '<input type="hidden" name="popup" value="1">';
//-- fin mod : Edit Forums On Index -------------------------------------------------
			//-- mod: sf
/*
			$catlist = get_list('category', $cat_id, TRUE);
			*/
			$parent_id = $_sf_tree->make_id(intval($forum_id) ? $_sf_tree->data[ $_sf_tree->make_id($forum_id) ]['forum_parent'] : 0, $cat_id);
			$catlist = $_sf_tree->select($parent_id, intval($forum_id) ? $_sf_tree->make_id($forum_id) : 0, false);
//-- mod: sf - end
			$template->assign_vars(array(
//-- mod : topic display order ---------------------------------------------------------------------
//-- add
				'L_FORUM_DISPLAY_SORT'			=> $lang['Sort_by'],
				'S_FORUM_DISPLAY_SORT_LIST'		=> $forum_display_sort_list,
				'S_FORUM_DISPLAY_ORDER_LIST'	=> $forum_display_order_list,
//-- fin mod : topic display order -----------------------------------------------------------------			
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"),
				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_SUBMIT_VALUE' => $buttonvalue, 
				'S_CAT_LIST' => $catlist,
				'S_STATUS_LIST' => $statuslist,
				'S_PRUNE_ENABLED' => $prune_enabled,
				'S_POINTS_LIST' => $pointslist,				
//-- mod : quick post es -------------------------------------------------------
//-- add
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],
				'L_QP_TITLE' => $lang['qp_quick_post'],
				'FORUM_QP_YES' => ($forum_qpes) ? 'checked="checked"' : '',
				'FORUM_QP_NO' => (!$forum_qpes) ? 'checked="checked"' : '',
//-- fin mod : quick post es ---------------------------------------------------				

				'L_FORUM_TITLE' => $l_title, 
				'L_FORUM_EXPLAIN' => $lang['Forum_edit_delete_explain'], 
				'L_FORUM_SETTINGS' => $lang['Forum_settings'], 
				'L_FORUM_NAME' => $lang['Forum_name'], 
				//-- mod: sf
/*
				'L_CATEGORY' => $lang['Category'], 
				*/
				'L_CATEGORY' => $lang['sf_Forum_parent'],
//-- mod: sf - end
				'L_FORUM_DESCRIPTION' => $lang['Forum_desc'],
				'L_FORUM_DESC_EXPLAIN' => $lang['Forum_desc_explain'],
				'L_FORUM_DESC_LONG' => $lang['Forum_desc_long'],				
				'L_DESC_LONG_EXPLAIN' => $lang['Forum_desc_long_explain'],
				'L_FORUM_STATUS' => $lang['Forum_status'],
				'L_PASSWORD' => $lang['Forum_password'],
				'L_FORUM_ICON' => $lang['Forum_icon'], // Forum Icon MOD				
				'L_AUTO_PRUNE' => $lang['Forum_pruning'],
				'L_ENABLED' => $lang['Enabled'],
				'L_PRUNE_DAYS' => $lang['prune_days'],
				'L_PRUNE_FREQ' => $lang['prune_freq'],
				'L_DAYS' => $lang['Days'],
				'FORUM_EXTERNAL_YES' => ($forum_external) ? 'checked="checked"' : '',
				'FORUM_EXTERNAL_NO' => (!$forum_external) ? 'checked="checked"' : '',
				'FORUM_REDIRECT_URL' => $forum_redirect_url,
				'FORUM_EXT_NEWWIN_YES' => ($forum_ext_newwin) ? 'checked="checked"' : '',
				'FORUM_EXT_NEWWIN_NO' => (!$forum_ext_newwin) ? 'checked="checked"' : '',
				'FORUM_EXT_IMAGE' => $forum_ext_image,
				'L_FORUM_EXT_NEWWIN' => $lang['Forum_ext_newwin'],
				'L_FORUM_EXT_IMAGE' => $lang['Forum_ext_image'],
				'L_FORUM_EXTERNAL' => $lang['Forum_external'],
				'L_FORUM_REDIRECT_URL' => $lang['Forum_redirect_url'],
				'L_NO' => $lang['No'],
				'L_YES' => $lang['Yes'],				
				'L_POINTS_DISABLED' => sprintf($lang['Points_disabled'], $board_config['points_name']),			

				'PRUNE_DAYS' => ( isset($pr_row['prune_days']) ) ? $pr_row['prune_days'] : 7,
				'PRUNE_FREQ' => ( isset($pr_row['prune_freq']) ) ? $pr_row['prune_freq'] : 1,
				'FORUM_NAME' => $forumname,
				'FORUM_PASSWORD' => $forum_password,
				'FORUM_ENTER_LIMIT' => $forum_enter_limit,
				'L_FORUM_ENTER_LIMIT' => $lang['Forum_enter_limit'],				
				'DESCRIPTION' => $forumdesc, 
				'DESCRIPTION_LONG' => $forumdesc_long,
				'ICON_LIST' => $forum_icons_list, // Forum Icon MOD
				'ICON_BASEDIR' => $phpbb_root_path . $board_config['forum_icon_path'], // Forum Icon MOD
				'ICON_IMG' => ( $forumicon ) ? $phpbb_root_path . $board_config['forum_icon_path'] . '/' . $forumicon : $phpbb_root_path . $board_config['forum_icon_path'] . '/' . $default_ficon // Forum Icon MOD
			));
			$template->pparse("body");
			break;

		case 'createforum':
			//
			// Create a forum in the DB
			//
			if( trim($HTTP_POST_VARS['forumname']) == "" )
			{
				message_die(GENERAL_ERROR, "Can't create a forum without a name");
			}
//-- mod: sf
/*
			$sql = "SELECT MAX(forum_order) AS max_order
				FROM " . FORUMS_TABLE . "
				WHERE cat_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]);
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't get order number from forums table", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			$max_order = $row['max_order'];
			$next_order = $max_order + 10;
			*/
			// force cat value
			$attach_id = htmlspecialchars(trim(stripslashes($HTTP_POST_VARS[POST_CAT_URL])));
			if ( !isset($_sf_tree->data[$attach_id]) )
			{
				$message = $lang['sf_Forum_parent_not_exist'] . '<br /><br />' . sprintf($lang['Click_return_forumadmin'], '<a href="' . append_sid('admin_forums.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
			// V: laissez les faire :< 
			/*
			if ($_sf_tree->data[$attach_id]['forum_external'])
			{
				message_die(GENERAL_MESSAGE, $lang['cant_attach_extern']);
			}
			*/
			$HTTP_POST_VARS[POST_CAT_URL] = $_sf_tree->data[$attach_id]['cat_id'];
			$forum_auth_ary['forum_parent'] = $_sf_tree->data[$attach_id]['forum_type'] == POST_CAT_URL ? 0 : $_sf_tree->data[$attach_id]['forum_id'];
			$next_order = $_sf_tree->data[ $_sf_tree->data[$attach_id]['last_child_id'] ]['forum_order'] + 5;
//-- mod: sf - end

			$sql = "SELECT MAX(forum_id) AS max_id
				FROM " . FORUMS_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't get order number from forums table", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			$max_id = $row['max_id'];
			$next_id = $max_id + 1;

			//
			// Default permissions of public :: 
			//
			$field_sql = "";
			$value_sql = "";
			while( list($field, $value) = each($forum_auth_ary) )
			{
				$field_sql .= ", $field";
				$value_sql .= ", $value";
			}

//-- mod : topic display order ---------------------------------------------------------------------
			$field_sql .= ', forum_display_sort';
			$value_sql .= ', ' . intval($HTTP_POST_VARS['forum_display_sort']);
			$field_sql .= ', forum_display_order';
			$value_sql .= ', ' . intval($HTTP_POST_VARS['forum_display_order']);
//-- fin mod : topic display order -----------------------------------------------------------------			

			// There is no problem having duplicate forum names so we won't check for it.
//-- mod : quick post es -------------------------------------------------------
// here we added
//	, forum_qpes
//	, " . intval($HTTP_POST_VARS['forum_qpes']) . "
//-- modify			

			$sql = "INSERT INTO " . FORUMS_TABLE . " (forum_id, forum_name, cat_id, forum_desc, forum_desc_long, forum_order, forum_status, forum_password, forum_enter_limit, forum_icon, forum_external, forum_redirect_url, forum_ext_newwin, forum_ext_image, forum_qpes, prune_enable, points_disabled" . $field_sql . ")
				VALUES ('" . $next_id . "', '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "', " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ", '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "', '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc_long']) . "', $next_order, " . intval($HTTP_POST_VARS['forumstatus']) . ", '" . str_replace("\'", "''", $HTTP_POST_VARS['password']) . "', " . intval($HTTP_POST_VARS['forum_enter_limit']) . ", '" . str_replace("\'", "''", $HTTP_POST_VARS['forumicon']) . "', " . intval($HTTP_POST_VARS['forum_external']) . ", '" . $HTTP_POST_VARS['forum_redirect_url'] . "', " . intval($HTTP_POST_VARS['forum_ext_newwin']) . ", '" . $HTTP_POST_VARS['forum_ext_image'] . "', " . intval($HTTP_POST_VARS['forum_qpes']) . ", " . intval($HTTP_POST_VARS['prune_enable']) .", " .  intval($HTTP_POST_VARS['points_disabled']) . $value_sql . ")";
//-- fin mod : quick post es ---------------------------------------------------				
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in forums table", "", __LINE__, __FILE__, $sql);
			}
			//-- mod: sf
			$_sf_tree->read();
//-- mod: sf - end

			if( $HTTP_POST_VARS['prune_enable'] )
			{

				if( $HTTP_POST_VARS['prune_days'] == "" || $HTTP_POST_VARS['prune_freq'] == "")
				{
					message_die(GENERAL_MESSAGE, $lang['Set_prune_data']);
				}

				$sql = "INSERT INTO " . PRUNE_TABLE . " (forum_id, prune_days, prune_freq)
					VALUES('" . $next_id . "', " . intval($HTTP_POST_VARS['prune_days']) . ", " . intval($HTTP_POST_VARS['prune_freq']) . ")";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't insert row in prune table", "", __LINE__, __FILE__, $sql);
				}
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");
//-- mod : Edit Forums On Index -----------------------------------------------------
//-- add			
			$in_from = ($_POST['popup']) ? $_POST['popup'] : $HTTP_POST_VARS['popup'];
			if ($in_from)
				$message = $lang['successfull_popup'] .'<br><br><a href="#" onclick="javascript:window.close();">'. $lang['close_popup'] .'</a>';
//-- fin mod : Edit Forums On Index ------------------------------------------------			

			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'modforum':
			// Modify a forum in the DB
			if( isset($HTTP_POST_VARS['prune_enable']))
			{
				if( $HTTP_POST_VARS['prune_enable'] != 1 )
				{
					$HTTP_POST_VARS['prune_enable'] = 0;
				}
			}
			//-- mod: sf
			// force cat value
			$attach_id = htmlspecialchars(trim(stripslashes($HTTP_POST_VARS[POST_CAT_URL])));
			if ( !isset($_sf_tree->data[$attach_id]) )
			{
				$message = $lang['sf_Forum_parent_not_exist'] . '<br /><br />' . sprintf($lang['Click_return_forumadmin'], '<a href="' . append_sid('admin_forums.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
			$HTTP_POST_VARS[POST_CAT_URL] = $_sf_tree->data[$attach_id]['cat_id'];
			$forum_id = intval($HTTP_POST_VARS[POST_FORUM_URL]);
			$tree_id = $_sf_tree->make_id($forum_id);
			if ( !isset($_sf_tree->data[$tree_id]) )
			{
				$message = $lang['Forum_not_exist'] . '<br /><br />' . sprintf($lang['Click_return_forumadmin'], '<a href="' . append_sid('admin_forums.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
			// if attachment changed, move to new position
			if ( $attach_id != $_sf_tree->make_id($_sf_tree->data[$tree_id]['forum_parent'], $_sf_tree->data[$tree_id]['cat_id']) )
			{
				$_sf_tree->move($tree_id, $attach_id);
				$_sf_tree->read();
			}
			// V: forum is external
			// let's check it doesn't have subforums ...
			// V: actually not, forget about that /o/. They're displayed correctly
			/*
			if (intval($HTTP_POST_VARS['forum_external']))
			{
				$tree_id = $_sf_tree->make_id($forum_id);
				if ( !isset($_sf_tree->data[$tree_id]) )
				{
					$message = $lang['Forum_not_exist'] . '<br /><br />' . sprintf($lang['Click_return_forumadmin'], '<a href="' . append_sid('admin_forums.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
				}
				if ( $_sf_tree->data[$tree_id]['last_child_id'] != $tree_id )
				{
					$message = $lang['sf_Forum_not_empty'] . '<br /><br />' . sprintf($lang['Click_return_forumadmin'], '<a href="' . append_sid('admin_forums.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');
					message_die(GENERAL_MESSAGE, $message);
				}
			}
			*/

//-- mod: sf - end
//-- mod : quick post es -------------------------------------------------------
// here we added
//	, forum_qpes = " . intval($HTTP_POST_VARS['forum_qpes']) . "
//-- modify
//-- mod : topic display order ---------------------------------------------------------------------
// here we have added :
//		, forum_display_order = " . intval($HTTP_POST_VARS['forum_display_order']) . ", forum_display_sort = " . intval($HTTP_POST_VARS['forum_display_sort']) . "
//-- modify
			$sql = "UPDATE " . FORUMS_TABLE . "
				SET forum_name = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumname']) . "',
					cat_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]) . ",
					forum_desc = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc']) . "',
					forum_desc_long = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumdesc_long']) . "',
					forum_status = " . intval($HTTP_POST_VARS['forumstatus']) . ",
					forum_password = '" . str_replace("\'", "''", $HTTP_POST_VARS['password']) . "',
					forum_enter_limit = " . intval($HTTP_POST_VARS['forum_enter_limit']) . ",
					forum_icon = '" . str_replace("\'", "''", $HTTP_POST_VARS['forumicon']) . "',
					forum_external = " . intval($HTTP_POST_VARS['forum_external']) . ",
					forum_redirect_url = '" . str_replace("\'", "''", $HTTP_POST_VARS['forum_redirect_url']) . "',
					forum_ext_newwin = " . intval($HTTP_POST_VARS['forum_ext_newwin']) . ",
					forum_ext_image = '" . str_replace("\'", "''", $HTTP_POST_VARS['forum_ext_image']) . "',
					forum_qpes = " . intval($HTTP_POST_VARS['forum_qpes']) . ",
					forum_display_order = " . intval($HTTP_POST_VARS['forum_display_order']) . ",
					forum_display_sort = " . intval($HTTP_POST_VARS['forum_display_sort']) . ",
					prune_enable = " . intval($HTTP_POST_VARS['prune_enable']) . ",
					points_disabled = " . intval($HTTP_POST_VARS['points_disabled']) . "
				WHERE forum_id = " . intval($HTTP_POST_VARS[POST_FORUM_URL]);
//-- fin mod : topic display order -----------------------------------------------------------------				
//-- fin mod : quick post es ---------------------------------------------------				
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update forum information", "", __LINE__, __FILE__, $sql);
			}

			if( $HTTP_POST_VARS['prune_enable'] == 1 )
			{
				if( $HTTP_POST_VARS['prune_days'] == "" || $HTTP_POST_VARS['prune_freq'] == "" )
				{
					message_die(GENERAL_MESSAGE, $lang['Set_prune_data']);
				}

				$sql = "SELECT *
					FROM " . PRUNE_TABLE . "
					WHERE forum_id = " . intval($HTTP_POST_VARS[POST_FORUM_URL]);
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't get forum Prune Information","",__LINE__, __FILE__, $sql);
				}

				if( $db->sql_numrows($result) > 0 )
				{
					$sql = "UPDATE " . PRUNE_TABLE . "
						SET	prune_days = " . intval($HTTP_POST_VARS['prune_days']) . ",	prune_freq = " . intval($HTTP_POST_VARS['prune_freq']) . "
				 		WHERE forum_id = " . intval($HTTP_POST_VARS[POST_FORUM_URL]);
				}
				else
				{
					$sql = "INSERT INTO " . PRUNE_TABLE . " (forum_id, prune_days, prune_freq)
						VALUES(" . intval($HTTP_POST_VARS[POST_FORUM_URL]) . ", " . intval($HTTP_POST_VARS['prune_days']) . ", " . intval($HTTP_POST_VARS['prune_freq']) . ")";
				}

				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't Update Forum Prune Information","",__LINE__, __FILE__, $sql);
				}
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;
			
		case 'addcat':
			// Create a category in the DB
			if( trim($HTTP_POST_VARS['categoryname']) == '')
			{
				message_die(GENERAL_ERROR, "Can't create a category without a name");
			}

			$sql = "SELECT MAX(cat_order) AS max_order
				FROM " . CATEGORIES_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't get order number from categories table", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			$max_order = $row['max_order'];
			$next_order = $max_order + 10;

			//
			// There is no problem having duplicate forum names so we won't check for it.
			//
			$sql = "INSERT INTO " . CATEGORIES_TABLE . " (cat_title, cat_order)
				VALUES ('" . str_replace("\'", "''", $HTTP_POST_VARS['categoryname']) . "', $next_order)";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in categories table", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;
			
		case 'editcat':
			//
			// Show form to edit a category
			//
			$newmode = 'modcat';
			$buttonvalue = $lang['Update'];

			$cat_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			$row = get_info('category', $cat_id);
			$cat_title = $row['cat_title'];

			$template->set_filenames(array(
				"body" => "admin/category_edit_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="' . POST_CAT_URL . '" value="' . $cat_id . '" />';

			$template->assign_vars(array(
				'CAT_TITLE' => $cat_title,

				'L_EDIT_CATEGORY' => $lang['Edit_Category'], 
				'L_EDIT_CATEGORY_EXPLAIN' => $lang['Edit_Category_explain'], 
				'L_CATEGORY' => $lang['Category'], 

				'S_HIDDEN_FIELDS' => $s_hidden_fields, 
				'S_SUBMIT_VALUE' => $buttonvalue, 
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"))
			);

			$template->pparse("body");
			break;

		case 'modcat':
			// Modify a category in the DB
			$sql = "UPDATE " . CATEGORIES_TABLE . "
				SET cat_title = '" . str_replace("\'", "''", $HTTP_POST_VARS['cat_title']) . "'
				WHERE cat_id = " . intval($HTTP_POST_VARS[POST_CAT_URL]);
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update forum information", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;
			
		case 'deleteforum':
			// Show form to delete a forum
			$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

			$select_to = '<select name="to_id">';
			$select_to .= "<option value=\"-1\"$s>" . $lang['Delete_all_posts'] . "</option>\n";
			//-- mod: sf
/*
			$select_to .= get_list('forum', $forum_id, 0);
			*/
			$tree_id = $_sf_tree->make_id($forum_id);
			if ( !isset($_sf_tree->data[$tree_id]) )
			{
				$message = $lang['Forum_not_exist'] . '<br /><br />' . sprintf($lang['Click_return_forumadmin'], '<a href="' . append_sid('admin_forums.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
			if ( $_sf_tree->data[$tree_id]['last_child_id'] != $tree_id )
			{
				$message = $lang['sf_Forum_not_empty'] . '<br /><br />' . sprintf($lang['Click_return_forumadmin'], '<a href="' . append_sid('admin_forums.' . $phpEx) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $phpEx . '?pane=right') . '">', '</a>');
				message_die(GENERAL_MESSAGE, $message);
			}
			$select_to .= '<option value="-2" disabled="disabled"> </option>';
			$select_to .= $_sf_tree->select('', $_sf_tree->make_id($forum_id), true);
//-- mod: sf - end
			$select_to .= '</select>';

			$buttonvalue = $lang['Move_and_Delete'];

			$newmode = 'movedelforum';

			$foruminfo = get_info('forum', $forum_id);
			$name = $foruminfo['forum_name'];

			$template->set_filenames(array(
				"body" => "admin/forum_delete_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="from_id" value="' . $forum_id . '" />';

			$template->assign_vars(array(
				'NAME' => $name, 

				'L_FORUM_DELETE' => $lang['Forum_delete'], 
				'L_FORUM_DELETE_EXPLAIN' => $lang['Forum_delete_explain'], 
				'L_MOVE_CONTENTS' => $lang['Move_contents'], 
				'L_FORUM_NAME' => $lang['Forum_name'], 

				"S_HIDDEN_FIELDS" => $s_hidden_fields,
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"), 
				'S_SELECT_TO' => $select_to,
				'S_SUBMIT_VALUE' => $buttonvalue)
			);

			$template->pparse("body");
			break;

		case 'movedelforum':
			//
			// Move or delete a forum in the DB
			//
			$from_id = intval($HTTP_POST_VARS['from_id']);
			$to_id = intval($HTTP_POST_VARS['to_id']);
			$delete_old = intval($HTTP_POST_VARS['delete_old']);

			// Either delete or move all posts in a forum
			if($to_id == -1)
			{
				// Delete polls in this forum
				$sql = "SELECT v.vote_id 
					FROM " . VOTE_DESC_TABLE . " v, " . TOPICS_TABLE . " t 
					WHERE t.forum_id = $from_id 
						AND v.topic_id = t.topic_id";
				if (!($result = $db->sql_query($sql)))
				{
					message_die(GENERAL_ERROR, "Couldn't obtain list of vote ids", "", __LINE__, __FILE__, $sql);
				}

				if ($row = $db->sql_fetchrow($result))
				{
					$vote_ids = '';
					do
					{
						$vote_ids .= (($vote_ids != '') ? ', ' : '') . $row['vote_id'];
					}
					while ($row = $db->sql_fetchrow($result));

					$sql = "DELETE FROM " . VOTE_DESC_TABLE . " 
						WHERE vote_id IN ($vote_ids)";
					$db->sql_query($sql);

					$sql = "DELETE FROM " . VOTE_RESULTS_TABLE . " 
						WHERE vote_id IN ($vote_ids)";
					$db->sql_query($sql);

					$sql = "DELETE FROM " . VOTE_USERS_TABLE . " 
						WHERE vote_id IN ($vote_ids)";
					$db->sql_query($sql);
				}
				$db->sql_freeresult($result);
				
				include($phpbb_root_path . "includes/prune.$phpEx");
				prune($from_id, 0, true); // Delete everything from forum
			}
			else
			{
				$sql = "SELECT *
					FROM " . FORUMS_TABLE . "
					WHERE forum_id IN ($from_id, $to_id)";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't verify existence of forums", "", __LINE__, __FILE__, $sql);
				}

				if($db->sql_numrows($result) != 2)
				{
					message_die(GENERAL_ERROR, "Ambiguous forum ID's", "", __LINE__, __FILE__);
				}
				$sql = "UPDATE " . TOPICS_TABLE . "
					SET forum_id = $to_id
					WHERE forum_id = $from_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move topics to other forum", "", __LINE__, __FILE__, $sql);
				}
				$sql = "UPDATE " . POSTS_TABLE . "
					SET	forum_id = $to_id
					WHERE forum_id = $from_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move posts to other forum", "", __LINE__, __FILE__, $sql);
				}
				sync('forum', $to_id);
			}

			// Alter Mod level if appropriate - 2.0.4
			$sql = "SELECT ug.user_id 
				FROM " . AUTH_ACCESS_TABLE . " a, " . USER_GROUP_TABLE . " ug 
				WHERE a.forum_id <> $from_id 
					AND a.auth_mod = 1
					AND ug.group_id = a.group_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't obtain moderator list", "", __LINE__, __FILE__, $sql);
			}

			if ($row = $db->sql_fetchrow($result))
			{
				$user_ids = '';
				do
				{
					$user_ids .= (($user_ids != '') ? ', ' : '' ) . $row['user_id'];
				}
				while ($row = $db->sql_fetchrow($result));

				$sql = "SELECT ug.user_id 
					FROM " . AUTH_ACCESS_TABLE . " a, " . USER_GROUP_TABLE . " ug 
					WHERE a.forum_id = $from_id 
						AND a.auth_mod = 1 
						AND ug.group_id = a.group_id
						AND ug.user_id NOT IN ($user_ids)";
				if( !$result2 = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't obtain moderator list", "", __LINE__, __FILE__, $sql);
				}
					
				if ($row = $db->sql_fetchrow($result2))
				{
					$user_ids = '';
					do
					{
						$user_ids .= (($user_ids != '') ? ', ' : '' ) . $row['user_id'];
					}
					while ($row = $db->sql_fetchrow($result2));

					$sql = "UPDATE " . USERS_TABLE . " 
						SET user_level = " . USER . " 
						WHERE user_id IN ($user_ids) 
							AND user_level <> " . ADMIN;
					$db->sql_query($sql);
				}
				$db->sql_freeresult($result);

			}
			$db->sql_freeresult($result2);

			$sql = "DELETE FROM " . FORUMS_TABLE . "
				WHERE forum_id = $from_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete forum", "", __LINE__, __FILE__, $sql);
			}
			
			$sql = "DELETE FROM " . AUTH_ACCESS_TABLE . "
				WHERE forum_id = $from_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete forum", "", __LINE__, __FILE__, $sql);
			}
			
			$sql = "DELETE FROM " . PRUNE_TABLE . "
				WHERE forum_id = $from_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete forum prune information!", "", __LINE__, __FILE__, $sql);
			}
			//-- mod: sf
			$tree_id = $_sf_tree->make_id($from_id);
			if ( isset($_sf_tree->data[$tree_id]) )
			{
				$sql = 'UPDATE ' . FORUMS_TABLE . '
							SET forum_order = forum_order - 10
							WHERE cat_id = ' . intval($_sf_tree->data[$tree_id]['cat_id']) . '
								AND forum_order > ' . intval($_sf_tree->data[$tree_id]['forum_order']);
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Couldn\'t re-order the forums', '', __LINE__, __FILE__, $sql);
				}
			}
			else
			{
				$_sf_tree->read();
			}
//-- mod: sf - end

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;
			
		case 'deletecat':
			//
			// Show form to delete a category
			//
			$cat_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			$buttonvalue = $lang['Move_and_Delete'];
			$newmode = 'movedelcat';
			$catinfo = get_info('category', $cat_id);
			$name = $catinfo['cat_title'];

			if ($catinfo['number'] == 1)
			{
				$sql = "SELECT count(*) as total
					FROM ". FORUMS_TABLE;
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't get Forum count", "", __LINE__, __FILE__, $sql);
				}
				$count = $db->sql_fetchrow($result);
				$count = $count['total'];

				if ($count > 0)
				{
					message_die(GENERAL_ERROR, $lang['Must_delete_forums']);
				}
				else
				{
					$select_to = $lang['Nowhere_to_move'];
				}
			}
			else
			{
				$select_to = '<select name="to_id">';
				$select_to .= get_list('category', $cat_id, 0);
				$select_to .= '</select>';
			}

			$template->set_filenames(array(
				"body" => "admin/forum_delete_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="' . $newmode . '" /><input type="hidden" name="from_id" value="' . $cat_id . '" />';

			$template->assign_vars(array(
				'NAME' => $name, 

				'L_FORUM_DELETE' => $lang['Forum_delete'], 
				'L_FORUM_DELETE_EXPLAIN' => $lang['Forum_delete_explain'], 
				'L_MOVE_CONTENTS' => $lang['Move_contents'], 
				'L_FORUM_NAME' => $lang['Forum_name'], 
				
				'S_HIDDEN_FIELDS' => $s_hidden_fields,
				'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"), 
				'S_SELECT_TO' => $select_to,
				'S_SUBMIT_VALUE' => $buttonvalue)
			);

			$template->pparse("body");
			break;

		case 'movedelcat':
			//
			// Move or delete a category in the DB
			//
			$from_id = intval($HTTP_POST_VARS['from_id']);
			//-- mod: sf
/*
			$to_id = intval($HTTP_POST_VARS['to_id']);

			if (!empty($to_id))
			{
				$sql = "SELECT *
					FROM " . CATEGORIES_TABLE . "
					WHERE cat_id IN ($from_id, $to_id)";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't verify existence of categories", "", __LINE__, __FILE__, $sql);
				}
				if($db->sql_numrows($result) != 2)
				{
					message_die(GENERAL_ERROR, "Ambiguous category ID's", "", __LINE__, __FILE__);
				}

				$sql = "UPDATE " . FORUMS_TABLE . "
					SET cat_id = $to_id
					WHERE cat_id = $from_id";
				if( !$result = $db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, "Couldn't move forums to other category", "", __LINE__, __FILE__, $sql);
				}
			}
			*/
			$to_id = htmlspecialchars(trim(stripslashes($HTTP_POST_VARS['to_id'])));
			if ( !empty($to_id) && isset($_sf_tree->data[$to_id]) )
			{
				$_sf_tree->move($_sf_tree->make_id(0, $from_id), $to_id);
			}
//-- mod: sf - end

			$sql = "DELETE FROM " . CATEGORIES_TABLE ."
				WHERE cat_id = $from_id";
				
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't delete category", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['Forums_updated'] . "<br /><br />" . sprintf($lang['Click_return_forumadmin'], "<a href=\"" . append_sid("admin_forums.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);

			break;

		case 'forum_order':
		//-- mod: sf
/*
			//
			// Change order of forums in the DB
			//
			$move = intval($HTTP_GET_VARS['move']);
			$forum_id = intval($HTTP_GET_VARS[POST_FORUM_URL]);

			$forum_info = get_info('forum', $forum_id);

			$cat_id = $forum_info['cat_id'];

			$sql = "UPDATE " . FORUMS_TABLE . "
				SET forum_order = forum_order + $move
				WHERE forum_id = $forum_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't change category order", "", __LINE__, __FILE__, $sql);
			}

			renumber_order('forum', $forum_info['cat_id']);
			*/
			$_sf_tree->move_up_down(POST_FORUM_URL, intval($HTTP_GET_VARS[POST_FORUM_URL]), intval($HTTP_GET_VARS['move']));
//-- mod: sf - end
			$show_index = TRUE;

			break;
			
		case 'cat_order':
		//-- mod: sf
/*
			//
			// Change order of categories in the DB
			//
			$move = intval($HTTP_GET_VARS['move']);
			$cat_id = intval($HTTP_GET_VARS[POST_CAT_URL]);

			$sql = "UPDATE " . CATEGORIES_TABLE . "
				SET cat_order = cat_order + $move
				WHERE cat_id = $cat_id";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't change category order", "", __LINE__, __FILE__, $sql);
			}

			renumber_order('category');
			*/
			$_sf_tree->move_up_down(POST_CAT_URL, intval($HTTP_GET_VARS[POST_CAT_URL]), intval($HTTP_GET_VARS['move']));
//-- mod: sf - end
			$show_index = TRUE;

			break;

		case 'forum_sync':
			sync('forum', intval($HTTP_GET_VARS[POST_FORUM_URL]));
			$show_index = TRUE;

			break;

		default:
			message_die(GENERAL_MESSAGE, $lang['No_mode']);
			break;
	}

	if ($show_index != TRUE)
	{
		include('./page_footer_admin.'.$phpEx);
		exit;
	}
}

//
// Start page proper
//
$template->set_filenames(array(
	"body" => "admin/forum_admin_body.tpl")
);

$template->assign_vars(array(
	'S_FORUM_ACTION' => append_sid("admin_forums.$phpEx"),
	'L_FORUM_TITLE' => $lang['Forum_admin'], 
	'L_FORUM_EXPLAIN' => $lang['Forum_admin_explain'], 
	'L_CREATE_FORUM' => $lang['Create_forum'], 
	'L_CREATE_CATEGORY' => $lang['Create_category'], 
	'L_EDIT' => $lang['Edit'], 
	'L_DELETE' => $lang['Delete'], 
	'L_MOVE_UP' => $lang['Move_up'], 
	'L_MOVE_DOWN' => $lang['Move_down'], 
	'L_RESYNC' => $lang['Resync'])
);

$sql = "SELECT cat_id, cat_title, cat_order
	FROM " . CATEGORIES_TABLE . "
	ORDER BY cat_order";
if( !$q_categories = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not query categories list", "", __LINE__, __FILE__, $sql);
}

if( $total_categories = $db->sql_numrows($q_categories) )
{
	$category_rows = $db->sql_fetchrowset($q_categories);

	$sql = "SELECT *
		FROM " . FORUMS_TABLE . "
		ORDER BY cat_id, forum_order";
	if(!$q_forums = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query forums information", "", __LINE__, __FILE__, $sql);
	}

	if( $total_forums = $db->sql_numrows($q_forums) )
	{
		$forum_rows = $db->sql_fetchrowset($q_forums);
	}

	//
	// Okay, let's build the index
	//
	$gen_cat = array();

	for($i = 0; $i < $total_categories; $i++)
	{
		$cat_id = $category_rows[$i]['cat_id'];
		//-- mod: sf
		$forum_keys = array();
//-- mod: sf - end

		$template->assign_block_vars("catrow", array( 
			'S_ADD_FORUM_SUBMIT' => "addforum[$cat_id]", 
			'S_ADD_FORUM_NAME' => "forumname[$cat_id]", 

			'CAT_ID' => $cat_id,
			'CAT_DESC' => $category_rows[$i]['cat_title'],

			'U_CAT_EDIT' => append_sid("admin_forums.$phpEx?mode=editcat&amp;" . POST_CAT_URL . "=$cat_id"),
			'U_CAT_DELETE' => append_sid("admin_forums.$phpEx?mode=deletecat&amp;" . POST_CAT_URL . "=$cat_id"),
			'U_CAT_MOVE_UP' => append_sid("admin_forums.$phpEx?mode=cat_order&amp;move=-15&amp;" . POST_CAT_URL . "=$cat_id"),
			'U_CAT_MOVE_DOWN' => append_sid("admin_forums.$phpEx?mode=cat_order&amp;move=15&amp;" . POST_CAT_URL . "=$cat_id"),
			'U_VIEWCAT' => append_sid($phpbb_root_path."index.$phpEx?" . POST_CAT_URL . "=$cat_id"))
		);

		for($j = 0; $j < $total_forums; $j++)
		{
			$forum_id = $forum_rows[$j]['forum_id'];
			
			if ($forum_rows[$j]['cat_id'] == $cat_id)
			{
//-- mod: sf
/*
				$template->assign_block_vars("catrow.forumrow",	array(
				*/
				if (!empty($forum_rows[$j]['forum_desc_long']))
				{
					$long_desc_title = $lang['Forum_desc_long'] . ': ';				      
				}
				else
				{
					$long_desc_title = ''; 
				}
				$forum_keys[ $forum_rows[$j]['forum_id'] ] = $j;
				$forum_rows[$j]['nest_level'] = intval($forum_rows[$j]['forum_parent']) ? intval($forum_rows[ $forum_keys[ intval($forum_rows[$j]['forum_parent']) ] ]['nest_level']) + 1 : 0;
				$template->assign_block_vars('catrow.forumrow', array(
					'INDENT' => $forum_rows[$j]['nest_level'] ? implode('', array_pad(array(), $forum_rows[$j]['nest_level'] * 5, '&nbsp;')) : '',
//-- mod: sf - end
					'FORUM_NAME' => $forum_rows[$j]['forum_name'],
					'FORUM_DESC' => $forum_rows[$j]['forum_desc'],
				    'L_FORUM_DESC_LONG' => $long_desc_title,
					'FORUM_DESC_LONG' => str_replace('"', '&quot;',$forum_rows[$j]['forum_desc_long']),
					'FORUM_ICON_IMG' => ( $forum_rows[$j]['forum_icon'] ) ? '<img src="' . $phpbb_root_path . $board_config['forum_icon_path'] .'/' . $forum_rows[$j]['forum_icon'] . '" alt="'.$forum_data[$j]['forum_name'].'" title="'.$forum_data[$j]['forum_name'].'" />' : '', // Forum Icon Mod					
					'ROW_COLOR' => $row_color,
					'NUM_TOPICS' => $forum_rows[$j]['forum_topics'],
					'NUM_POSTS' => $forum_rows[$j]['forum_posts'],

					'U_VIEWFORUM' => append_sid($phpbb_root_path."viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_EDIT' => append_sid("admin_forums.$phpEx?mode=editforum&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_DELETE' => append_sid("admin_forums.$phpEx?mode=deleteforum&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_MOVE_UP' => append_sid("admin_forums.$phpEx?mode=forum_order&amp;move=-15&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_MOVE_DOWN' => append_sid("admin_forums.$phpEx?mode=forum_order&amp;move=15&amp;" . POST_FORUM_URL . "=$forum_id"),
					'U_FORUM_RESYNC' => append_sid("admin_forums.$phpEx?mode=forum_sync&amp;" . POST_FORUM_URL . "=$forum_id"))
				);
			}// if ... forumid == catid
			
		} // for ... forums

	} // for ... categories

}// if ... total_categories

$template->pparse("body");

include './page_footer_admin.'.$phpEx;