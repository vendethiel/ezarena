<?php
/***************************************************************************
 *                             admin_replace.php
 *                            -------------------
 *   begin                : Friday, April 02, 2004
 *   copyright            : (C) 2004 mosymuis
 *   email                : mods@mosymuis.nl
 *
 *   $Id: admin_replace.php,v 1.0.0 2004/04/02 $
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

if(!empty ($setmodules))
{
	$filename = basename(__FILE__);
	$module['General']['Replace posts'] = $filename;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

$str_old = trim(htmlspecialchars($HTTP_POST_VARS['str_old']));
$str_new = trim(htmlspecialchars($HTTP_POST_VARS['str_new']));

if ( $HTTP_POST_VARS['submit'] && !empty($str_old) && $str_old != $str_new )
{
	$template->assign_block_vars("switch_forum_sent", array() );

	$sql = "SELECT f.forum_id, f.forum_name, t.topic_id, t.topic_title, p.post_id, p.post_time, pt.post_text, u.user_id, u.username
		FROM " . FORUMS_TABLE . " f, " . TOPICS_TABLE . " t, " . POSTS_TABLE . " p, " . POSTS_TEXT_TABLE . " pt, " . USERS_TABLE . " u
		WHERE post_text LIKE '%" . $str_old . "%'
		AND p.post_id = pt.post_id
		AND p.topic_id = t.topic_id
		AND p.forum_id = f.forum_id
		AND p.poster_id = u.user_id
		ORDER BY pt.post_id DESC;";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain posts', '', __LINE__, __FILE__, $sql);
	}

	if ( $db->sql_numrows($result) >= 1 )
	{
		for ($i = 1; $row = $db->sql_fetchrow($result); $i++)
		{
			$template->assign_block_vars('switch_forum_sent.replaced', array(
				'ROW_CLASS' => ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'],
				'NUMBER' => $i,
				'FORUM_NAME' => $row['forum_name'],
				'TOPIC_TITLE' => $row['topic_title'],
				'AUTHOR' => $row['username'],
				'POST' => create_date($board_config['default_dateformat'], $row['post_time'], $board_config['board_timezone']),

				'U_FORUM' => append_sid("../viewforum.$phpEx?" . POST_FORUM_URL . "=" . $row['forum_id']),
				'U_TOPIC' => append_sid("../viewtopic.$phpEx?" . POST_TOPIC_URL . "=" . $row['topic_id']),
				'U_AUTHOR' => append_sid("../profile.$phpEx?mode=viewprofile&" . POST_USERS_URL . "=" . $row['user_id']),
				'U_POST' => append_sid("../viewtopic.$phpEx?" . POST_POST_URL . "=" . $row['post_id']) . "#" . $row['post_id'])
			);

			$sql = "UPDATE " . POSTS_TEXT_TABLE . "
				SET post_text = '" . str_replace($str_old, $str_new, addslashes($row['post_text'])) . "'
				WHERE post_id = '" . $row['post_id'] . "';";
			if ( !($result_update = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not update posts', '', __LINE__, __FILE__, $sql);
			}
		}

	} else {

		$template->assign_block_vars("switch_forum_sent.switch_no_results", array() );
	}
}

$template->set_filenames(array(
	"body" => "admin/replace_body.tpl")
);

$template->assign_vars(array(
	'S_FORM_ACTION' => append_sid("admin_replace.$phpEx"),

	'L_REPLACE_TITLE' => $lang['Replace_title'],
	'L_REPLACE_TEXT' => $lang['Replace_text'],
	'L_STR_OLD' => $lang['Str_old'],
	'L_STR_NEW' => $lang['Str_new'],
	'L_FORUM' => $lang['Forum'],
	'L_TOPIC' => $lang['Topic'],
	'L_AUTHOR' => $lang['Author'],
	'L_LINK' => $lang['Link'],
	'L_NO_RESULTS' => $lang['No_results'],
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],

	'REPLACED_COUNT' => ( $i == 0 ) ? '&nbsp;' : sprintf($lang['Replaced_count'], $i -1),

	'STR_OLD' => $str_old,
	'STR_NEW' => $str_new,
	'POST_IMG' => '../' . $images['icon_latest_reply'])
);

$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>