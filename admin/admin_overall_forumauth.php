<?php
/***************************************************************************
 *                         admin_overall_forumauth.php
 *                            -------------------
 *   begin                : Friday, July 12, 2002
 *   copyright            : (C) 2002 Smartor
 *   email                : smartor_xp@hotmail.com
 *
 *   $Id: admin_overall_forumauth.php,v 1.0.2 2002/8/08, 19:41:51 hnt Exp $
 *
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

$forum_id = 2; // You could change this value unless forum ID 3 did not exist in your board

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Forums']['Permissions globales']   = $filename . '?' . POST_FORUM_URL . "=$forum_id";

	return;
}

//
// Load default header
//
$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Start program - define vars
//
//                View      Read      Post      Reply     Edit     Delete    Sticky   Announce    Vote      Poll
$simple_auth_ary = array(
	0  => array(AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG),
	1  => array(AUTH_ALL, AUTH_ALL, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG),
	2  => array(AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_REG, AUTH_MOD, AUTH_MOD, AUTH_REG, AUTH_REG),
	3  => array(AUTH_ALL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_ACL, AUTH_ACL),
	4  => array(AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_ACL, AUTH_MOD, AUTH_ACL, AUTH_ACL),
	5  => array(AUTH_ALL, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD),
	6  => array(AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD, AUTH_MOD),
);


$simple_auth_types = array($lang['Public'], $lang['Registered'], $lang['Registered'] . ' [' . $lang['Hidden'] . ']', $lang['Private'], $lang['Private'] . ' [' . $lang['Hidden'] . ']', $lang['Moderators'], $lang['Moderators'] . ' [' . $lang['Hidden'] . ']');

$forum_auth_fields = array('auth_view', 'auth_read', 'auth_post', 'auth_reply', 'auth_edit', 'auth_delete', 'auth_sticky', 'auth_announce', 'auth_vote', 'auth_pollcreate', 'auth_ban', 'auth_bluecard', 'auth_greencard', 'auth_attachments', 'auth_download');

$forum_auth_levels = array('ALL', 'REG', 'PRIVATE', 'MOD', 'ADMIN');
$forum_auth_const = array(AUTH_ALL, AUTH_REG, AUTH_ACL, AUTH_MOD, AUTH_ADMIN);
attach_setup_forum_auth($simple_auth_ary, $forum_auth_fields, $field_names);
$forum_auth_images = array(
	AUTH_ALL => 'ALL',
	AUTH_REG => 'REG',
	AUTH_ACL => 'PRIVATE',
	AUTH_MOD => 'MOD',
	AUTH_ADMIN => 'ADMIN',
);
$forum_auth_cats = array(
	'VIEW' => 'auth_view',
	'READ' => 'auth_read',
	'POST' => 'auth_post',
	'REPLY' => 'auth_reply',
	'EDIT' => 'auth_edit',
	'DELETE' => 'auth_delete',
	'STICKY' => 'auth_sticky',
	'ANNOUNCE' => 'auth_announce',
	'VOTE' => 'auth_vote',
	'AUTH_BAN' => 'auth_ban',
	'AUTH_BLUECARD' => 'auth_bluecard',	
	'AUTH_GREENCARD' => 'auth_greencard',
	'POLLCREATE' => 'auth_pollcreate',
	'AUTH_ATTACHMENTS' => 'auth_attachments',
	'AUTH_DOWNLOAD' => 'auth_download',
);

for($i=0; $i<count($forum_auth_const); $i++) {
	$auth_key .= '<img src="/images/spacer.gif" width=10 height=10 class="' . $forum_auth_classes[$forum_auth_const[$i]] . '">&nbsp;' . $forum_auth_levels[$i] . '&nbsp;&nbsp;';
	$template->assign_block_vars("authedit",	array(
		'CLASS' => $forum_auth_classes[$forum_auth_const[$i]],
		'NAME' => $forum_auth_levels[$i],
		'VALUE' => $forum_auth_const[$i],
	));
}

if( isset($HTTP_GET_VARS['adv']) )
{
	$adv = intval($HTTP_GET_VARS['adv']);
}
else
{
	unset($adv);
}

$template->set_filenames(array(
	"body" => "admin/auth_overall_forum_body.tpl")
);
//
// Start program proper
//
if( isset($HTTP_POST_VARS['submit']) )
{
	foreach($_POST['auth'] as $forum_id => $forum) {
		$forum_id = intval($forum_id);
		$sql = '';
		foreach($forum as $a => $newval) {
			if ($newval && in_array($newval, $forum_auth_levels) && array_key_exists($a, $forum_auth_cats)) { // Changed and is valid
				$sql .= ( ( $sql != '' ) ? ', ' : '' ) . $forum_auth_cats[$a] . '=' . array_search($newval, $forum_auth_images);
			}
		}
		if ($sql != '') {
			$sql = "UPDATE " . FORUMS_TABLE . " SET $sql WHERE forum_id = $forum_id;";
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update auth table', '', __LINE__, __FILE__, $sql);
			}
		}
	}
} // End of submit

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
		// V: let's integrate subforums+ here...
		$_sf_forum_keys = array();
		$cat_id = $category_rows[$i]['cat_id'];

		$template->assign_block_vars("catrow", array(
			'CAT_ID' => $cat_id,
			'CAT_DESC' => $category_rows[$i]['cat_title'],
		));
		for($j = 0; $j < $total_forums; $j++)
		{
			if ($forum_rows[$j]['cat_id'] != $cat_id)
			{
				continue;
			}

			if ( intval($forum_rows[$j]['forum_parent']) && !isset($_sf_forum_keys[ intval($forum_rows[$j]['forum_parent']) ]) )
			{
				continue;
			}
			$_sf_forum_keys[ $forum_rows[$j]['forum_id'] ] = $j;
			$forum_rows[$j]['_sf_nest_level'] = intval($forum_rows[$j]['forum_parent']) ? intval($forum_rows[ $_sf_forum_keys[ intval($forum_rows[$j]['forum_parent']) ] ]['_sf_nest_level']) + 1 : 0;

			$forum_id = $forum_rows[$j]['forum_id'];
			$template->assign_block_vars("catrow.forumrow",	array(
				// V: this looks pretty bad, tbh, but better than no marker
				'FORUM_NAME' => ($forum_rows[$j]['_sf_nest_level'] ? implode('', array_pad(array(), ($forum_rows[$j]['_sf_nest_level'] - 1) * 4, '&nbsp;')) . '--&nbsp;' : '')
				 . $forum_rows[$j]['forum_name'] . ' ' . ($forum_rows[$j]['forum_external'] ? $lang['paren_external'] : ''),
				'FORUM_ID' => $forum_rows[$j]['forum_id'],
				'ROW_COLOR' => $row_color,
				'AUTH_VIEW_IMG' => $forum_auth_images[$forum_rows[$j]['auth_view']],
				'AUTH_READ_IMG' => $forum_auth_images[$forum_rows[$j]['auth_read']],
				'AUTH_POST_IMG' => $forum_auth_images[$forum_rows[$j]['auth_post']],
				'AUTH_REPLY_IMG' => $forum_auth_images[$forum_rows[$j]['auth_reply']],
				'AUTH_EDIT_IMG' => $forum_auth_images[$forum_rows[$j]['auth_edit']],
				'AUTH_DELETE_IMG' => $forum_auth_images[$forum_rows[$j]['auth_delete']],
				'AUTH_STICKY_IMG' => $forum_auth_images[$forum_rows[$j]['auth_sticky']],
				'AUTH_ANNOUNCE_IMG' => $forum_auth_images[$forum_rows[$j]['auth_announce']],
				'AUTH_VOTE_IMG' => $forum_auth_images[$forum_rows[$j]['auth_vote']],
				'AUTH_BAN_IMG' => $forum_auth_images[$forum_rows[$j]['auth_ban']],
				'AUTH_BLUECARD_IMG' => $forum_auth_images[$forum_rows[$j]['auth_bluecard']],
				'AUTH_GREENCARD_IMG' => $forum_auth_images[$forum_rows[$j]['auth_greencard']],
				'AUTH_POLLCREATE_IMG' => $forum_auth_images[$forum_rows[$j]['auth_pollcreate']],
				'AUTH_ATTACHMENTS_IMG' => $forum_auth_images[$forum_rows[$j]['auth_attachments']],
				'AUTH_DOWNLOAD_IMG' => $forum_auth_images[$forum_rows[$j]['auth_download']],
			));
		} // for ... forums

	} // for ... categories

}// if ... total_categories

$template->assign_vars(array(
	'L_FORUM_TITLE' => $lang['Auth_Control_Forum'],
	'L_FORUM_EXPLAIN' => $lang['Forum_auth_explain_overall'],
	'L_FORUM_EXPLAIN_EDIT' => $lang['Forum_auth_explain_overall_edit'],
	'L_FORUM_OVERALL_RESTORE' => $lang['Forum_auth_overall_restore'],
	'L_FORUM_OVERALL_STOP' => $lang['Forum_auth_overall_stop'],
	'L_SUBMIT' => $lang['Submit'],

	'L_VOIR' => $lang['voir'],
	'L_LIRE' => $lang['lire'],
	'L_POSTER' => $lang['poster'],
	'L_REP' => $lang['reponse'],
	'L_EDIT' => $lang['editer'],
	'L_SUPP' => $lang['supprimer'],
	'L_POST_IT' => $lang['poste_it'],
	'L_ANNONCE' => $lang['annonces'],
	'L_VOTE' => $lang['vote'],
	'L_SONDAGE' => $lang['sondage'],
	'L_BAN' => $lang['ban'],
	'L_BLUECARD' => $lang['bluecard'],
	'L_GREENCARD' => $lang['greencard'],
	'L_ATTACHMENTS' => $lang['Auth_attach'],
	'L_DOWNLOAD' => $lang['Auth_download'],
	'AUTH_KEY' => $auth_key,
));

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);