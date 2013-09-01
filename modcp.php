<?php
/***************************************************************************
 *                                 modcp.php
 *                            -------------------
 *   begin                : July 4, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: modcp.php,v 1.71.2.28 2006/01/20 19:50:27 grahamje Exp $
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

/**
 * Moderator Control Panel
 *
 * From this 'Control Panel' the moderator of a forum will be able to do
 * mass topic operations (locking/unlocking/moving/deleteing), and it will
 * provide an interface to do quick locking/unlocking/moving/deleting of
 * topics via the moderator operations buttons on all of the viewtopic pages.
 */

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_admin.'.$phpEx);
//-- mod : quick title edition -------------------------------------------------
//-- add
include($get->url('includes/class_attributes'));
//-- fin mod : quick title edition ---------------------------------------------

//
// Obtain initial var settings
//
if ( isset($HTTP_GET_VARS[POST_FORUM_URL]) || isset($HTTP_POST_VARS[POST_FORUM_URL]) )
{
	$forum_id = (isset($HTTP_POST_VARS[POST_FORUM_URL])) ? intval($HTTP_POST_VARS[POST_FORUM_URL]) : intval($HTTP_GET_VARS[POST_FORUM_URL]);
}
else
{
	$forum_id = '';
}

if ( isset($HTTP_GET_VARS[POST_POST_URL]) || isset($HTTP_POST_VARS[POST_POST_URL]) )
{
	$post_id = (isset($HTTP_POST_VARS[POST_POST_URL])) ? intval($HTTP_POST_VARS[POST_POST_URL]) : intval($HTTP_GET_VARS[POST_POST_URL]);
}
else
{
	$post_id = '';
}

if ( isset($HTTP_GET_VARS[POST_TOPIC_URL]) || isset($HTTP_POST_VARS[POST_TOPIC_URL]) )
{
	$topic_id = (isset($HTTP_POST_VARS[POST_TOPIC_URL])) ? intval($HTTP_POST_VARS[POST_TOPIC_URL]) : intval($HTTP_GET_VARS[POST_TOPIC_URL]);
}
else
{
	$topic_id = '';
}

$confirm = ( $HTTP_POST_VARS['confirm'] ) ? TRUE : 0;

//
// Continue var definitions
//
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$start = ($start < 0) ? 0 : $start;

$delete = ( isset($HTTP_POST_VARS['delete']) ) ? TRUE : FALSE;
$move = ( isset($HTTP_POST_VARS['move']) ) ? TRUE : FALSE;
$lock = ( isset($HTTP_POST_VARS['lock']) ) ? TRUE : FALSE;
$unlock = ( isset($HTTP_POST_VARS['unlock']) ) ? TRUE : FALSE;
//-- mod : quick title edition -------------------------------------------------
//-- add
$attribute = isset($HTTP_POST_VARS['attribute']) ? TRUE : FALSE;
$attribute_id = request_var('attribute_id', TYPE_INT);
//-- fin mod : quick title edition ---------------------------------------------

if ( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	if ( $delete )
	{
		$mode = 'delete';
	}
	else if ( $move )
	{
		$mode = 'move';
	}
	else if ( $lock )
	{
		$mode = 'lock';
	}
	else if ( $unlock )
	{
		$mode = 'unlock';
	}
	//-- mod : quick title edition -------------------------------------------------
	//-- add
	else if ( $attribute )
	{
		$mode = 'attribute';
	}
	//-- fin mod : quick title edition ---------------------------------------------
	else
	{
		$mode = '';
	}
}

// session id check
if (!empty($HTTP_POST_VARS['sid']) || !empty($HTTP_GET_VARS['sid']))
{
	$sid = (!empty($HTTP_POST_VARS['sid'])) ? $HTTP_POST_VARS['sid'] : $HTTP_GET_VARS['sid'];
}
else
{
	$sid = '';
}

//
// Obtain relevant data
//
if ( !empty($topic_id) )
{
	$sql = "SELECT t.topic_poster, f.forum_id, f.forum_name, f.forum_topics
		FROM " . TOPICS_TABLE . " t, " . FORUMS_TABLE . " f
		WHERE t.topic_id = " . $topic_id . "
			AND f.forum_id = t.forum_id";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
	}
	$topic_row = $db->sql_fetchrow($result);

	if (!$topic_row)
	{
		message_die(GENERAL_MESSAGE, 'Topic_post_not_exist');
	}

	$forum_topics = ( $topic_row['forum_topics'] == 0 ) ? 1 : $topic_row['forum_topics'];
	$forum_id = $topic_row['forum_id'];
	$forum_name = $topic_row['forum_name'];
}
else if ( !empty($forum_id) )
{
	$sql = "SELECT forum_name, forum_topics
		FROM " . FORUMS_TABLE . "
		WHERE forum_id = " . $forum_id;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_MESSAGE, 'Forum_not_exist');
	}
	$topic_row = $db->sql_fetchrow($result);

	if (!$topic_row)
	{
		message_die(GENERAL_MESSAGE, 'Forum_not_exist');
	}

	$forum_topics = ( $topic_row['forum_topics'] == 0 ) ? 1 : $topic_row['forum_topics'];
	$forum_name = $topic_row['forum_name'];
}
else
{
	message_die(GENERAL_MESSAGE, 'Forum_not_exist');
}

//
// Start session management
//
$userdata = session_pagestart($user_ip, $forum_id);
init_userprefs($userdata);
//
// End session management
//
//-- mod: sf
include($phpbb_root_path . 'includes/functions_sf.'.$phpEx);
_sf_display_nav($forum_id);
//-- mod: sf - end

// session id check
if ($sid == '' || $sid != $userdata['session_id'])
{
	message_die(GENERAL_ERROR, 'Invalid_session');
}

//
// Check if user did or did not confirm
// If they did not, forward them to the last page they were on
//
if ( isset($HTTP_POST_VARS['cancel']) )
{
	if ( $topic_id )
	{
		$redirect = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id";
	}
	else if ( $forum_id )
	{
		$redirect = "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id";
	}
	else
	{
		$redirect = "index.$phpEx";
	}

	redirect(append_sid($redirect, true));
}

//
// Start auth check
//
//-- mod : quick title edition -------------------------------------------------
//-- delete
/*-MOD
$is_auth = auth(AUTH_ALL, $forum_id, $userdata);

if ( !$is_auth['auth_mod'] )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
}
MOD-*/
//-- add
if ($mode != 'attribute')
{
	$is_auth = auth(AUTH_ALL, $forum_id, $userdata);
	if ( !$is_auth['auth_mod'] )
	{
		message_die(GENERAL_MESSAGE, $lang['Not_Moderator'], $lang['Not_Authorised']);
	}
}
else
{
	if ( $attribute_id > -1 )
	{
		$sql = 'SELECT * FROM ' . ATTRIBUTES_TABLE . ' WHERE attribute_id = ' . intval($attribute_id);
		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_MESSAGE, $lang['Attr_Error_Message_11']);
		}

		$row = $db->sql_fetchrow($result);

		if (($userdata['user_level'] == ADMIN && !$row['attribute_administrator']) || ($userdata['user_level'] == MOD && !$row['attribute_moderator']) || ($userdata['user_level'] == USER && !$row['attribute_author']) || ($userdata['user_level'] == USER && $row['attribute_author'] && $userdata['user_id'] != $topic_row['topic_poster'] ))
		{
			message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
		}
	}
	else
	{
		if ($userdata['user_level'] == USER && $userdata['user_id'] != $topic_row['topic_poster'])
		{	
			message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
		}
		$row = array('title_info' => '');
	}
}
//-- fin mod : quick title edition ---------------------------------------------
//
// End Auth Check
//

//
// Do major work ...
//
switch( $mode )
{
	case 'delete':
		if (!$is_auth['auth_delete'])
		{
			message_die(GENERAL_MESSAGE, sprintf($lang['Sorry_auth_delete'], $is_auth['auth_delete_type']));
		}
		if( $userdata['user_level'] != ADMIN )
		{
			$topics_sql = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? implode(',', $HTTP_POST_VARS['topic_id_list']) : $topic_id;
			$sql = "SELECT t.topic_id
					FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u
					WHERE u.user_id = t.topic_poster
						AND u.user_level = " . ADMIN . "
						AND t.topic_id IN ($topics_sql)";
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not retrieve topics list', '', __LINE__, __FILE__, $sql);
			}

			if( $db->sql_numrows($result) > 0 )
			{
				message_die(GENERAL_MESSAGE, $lang['Not_auth_edit_delete_admin']);
			}
		}		

		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		if ( $confirm )
		{
  			if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			include($phpbb_root_path . 'includes/functions_search.'.$phpEx);

			$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ? $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

			$topic_id_sql = '';
			for($i = 0; $i < count($topics); $i++)
			{
				$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
			}

			$sql = "SELECT topic_id 
				FROM " . TOPICS_TABLE . "
				WHERE topic_id IN ($topic_id_sql)
					AND forum_id = $forum_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic id information', '', __LINE__, __FILE__, $sql);
			}
			
			$topic_id_sql = '';
			while ($row = $db->sql_fetchrow($result))
			{
				$topic_id_sql .= (($topic_id_sql != '') ? ', ' : '') . intval($row['topic_id']);
			}
			$db->sql_freeresult($result);

			if ( $topic_id_sql == '')
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$sql = "SELECT poster_id, COUNT(post_id) AS posts 
				FROM " . POSTS_TABLE . " 
				WHERE topic_id IN ($topic_id_sql) 
				GROUP BY poster_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get poster id information', '', __LINE__, __FILE__, $sql);
			}

			$count_sql = array();
			while ( $row = $db->sql_fetchrow($result) )
			{
				$count_sql[] = "UPDATE " . USERS_TABLE . " 
					SET user_posts = user_posts - " . $row['posts'] . " 
					WHERE user_id = " . $row['poster_id'];
			}
			$db->sql_freeresult($result);

			if ( sizeof($count_sql) )
			{
				for($i = 0; $i < sizeof($count_sql); $i++)
				{
					if ( !$db->sql_query($count_sql[$i]) )
					{
						message_die(GENERAL_ERROR, 'Could not update user post count information', '', __LINE__, __FILE__, $sql);
					}
				}
			}
			
			$sql = "SELECT post_id 
				FROM " . POSTS_TABLE . " 
				WHERE topic_id IN ($topic_id_sql)";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get post id information', '', __LINE__, __FILE__, $sql);
			}

			$post_id_sql = '';
			while ( $row = $db->sql_fetchrow($result) )
			{
				$post_id_sql .= ( ( $post_id_sql != '' ) ? ', ' : '' ) . intval($row['post_id']);
			}
			$db->sql_freeresult($result);

			$sql = "SELECT vote_id 
				FROM " . VOTE_DESC_TABLE . " 
				WHERE topic_id IN ($topic_id_sql)";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get vote id information', '', __LINE__, __FILE__, $sql);
			}

			$vote_id_sql = '';
			while ( $row = $db->sql_fetchrow($result) )
			{
				$vote_id_sql .= ( ( $vote_id_sql != '' ) ? ', ' : '' ) . $row['vote_id'];
			}
			$db->sql_freeresult($result);

			//
			// Got all required info so go ahead and start deleting everything
			//
			$sql = "DELETE 
				FROM " . TOPICS_TABLE . " 
				WHERE topic_id IN ($topic_id_sql) 
					OR topic_moved_id IN ($topic_id_sql)";
			if ( !$db->sql_query($sql, BEGIN_TRANSACTION) )
			{
				message_die(GENERAL_ERROR, 'Could not delete topics', '', __LINE__, __FILE__, $sql);
			}

			if ( $post_id_sql != '' )
			{
				$sql = "DELETE 
					FROM " . POSTS_TABLE . " 
					WHERE post_id IN ($post_id_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete posts', '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE 
					FROM " . POSTS_TEXT_TABLE . " 
					WHERE post_id IN ($post_id_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete posts text', '', __LINE__, __FILE__, $sql);
				}

				remove_search_post($post_id_sql);
				delete_attachment(explode(', ', $post_id_sql));
			}

			if ( $vote_id_sql != '' )
			{
				$sql = "DELETE 
					FROM " . VOTE_DESC_TABLE . " 
					WHERE vote_id IN ($vote_id_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete vote descriptions', '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE 
					FROM " . VOTE_RESULTS_TABLE . " 
					WHERE vote_id IN ($vote_id_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete vote results', '', __LINE__, __FILE__, $sql);
				}

				$sql = "DELETE 
					FROM " . VOTE_USERS_TABLE . " 
					WHERE vote_id IN ($vote_id_sql)";
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not delete vote users', '', __LINE__, __FILE__, $sql);
				}
			}

			$sql = "DELETE 
				FROM " . TOPICS_WATCH_TABLE . " 
				WHERE topic_id IN ($topic_id_sql)";
			if ( !$db->sql_query($sql, END_TRANSACTION) )
			{
				message_die(GENERAL_ERROR, 'Could not delete watched post list', '', __LINE__, __FILE__, $sql);
			}

			sync('forum', $forum_id);

			if ( !empty($topic_id) )
			{
				$redirect_page = "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$l_redirect = sprintf($lang['Click_return_forum'], '<a href="' . $redirect_page . '">', '</a>');
			}
			else
			{
				$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$l_redirect = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
			}

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
			);
			
			$db->clear_cache('posts_');

			message_die(GENERAL_MESSAGE, $lang['Topics_Removed'] . '<br /><br />' . $l_redirect);
		}
		else
		{
			// Not confirmed, show confirmation message
			if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

			if ( isset($HTTP_POST_VARS['topic_id_list']) )
			{
				$topics = $HTTP_POST_VARS['topic_id_list'];
				for($i = 0; $i < count($topics); $i++)
				{
					$hidden_fields .= '<input type="hidden" name="topic_id_list[]" value="' . intval($topics[$i]) . '" />';
				}
			}
			else
			{
				$hidden_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
			}

			//
			// Set template files
			//
			$template->set_filenames(array(
				'confirm' => 'confirm_body.tpl')
			);

			$template->assign_vars(array(
				'MESSAGE_TITLE' => $lang['Confirm'],
				'MESSAGE_TEXT' => $lang['Confirm_delete_topic'],

				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],

				'S_CONFIRM_ACTION' => append_sid("modcp.$phpEx"),
				'S_HIDDEN_FIELDS' => $hidden_fields)
			);

			$template->pparse('confirm');

			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		}
		break;

	case 'move':
		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		if ( $confirm )
		{
			if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$new_forum_id = intval($HTTP_POST_VARS['new_forum']);
			$old_forum_id = $forum_id;

			$sql = 'SELECT forum_id FROM ' . FORUMS_TABLE . '
				WHERE forum_id = ' . $new_forum_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not select from forums table', '', __LINE__, __FILE__, $sql);
			}
			
			if (!$db->sql_fetchrow($result))
			{
				message_die(GENERAL_MESSAGE, 'New forum does not exist');
			}

			$db->sql_freeresult($result);

			if ( $new_forum_id != $old_forum_id )
			{
				$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

				$topic_list = '';
				for($i = 0; $i < count($topics); $i++)
				{
					$topic_list .= ( ( $topic_list != '' ) ? ', ' : '' ) . intval($topics[$i]);
				}

				$sql = "SELECT * 
					FROM " . TOPICS_TABLE . " 
					WHERE topic_id IN ($topic_list)
						AND forum_id = $old_forum_id
						AND topic_status <> " . TOPIC_MOVED;
				if ( !($result = $db->sql_query($sql, BEGIN_TRANSACTION)) )
				{
					message_die(GENERAL_ERROR, 'Could not select from topic table', '', __LINE__, __FILE__, $sql);
				}

				$row = $db->sql_fetchrowset($result);
				$db->sql_freeresult($result);

				for($i = 0; $i < count($row); $i++)
				{
					$topic_id = $row[$i]['topic_id'];
					
					if ( isset($HTTP_POST_VARS['move_leave_shadow']) )
					{
						// Insert topic in the old forum that indicates that the forum has moved.
						$sql = "INSERT INTO " . TOPICS_TABLE . " (forum_id, topic_title, topic_poster, topic_time, topic_status, topic_type, topic_vote, topic_views, topic_replies, topic_first_post_id, topic_last_post_id, topic_moved_id)
							VALUES ($old_forum_id, '" . addslashes(str_replace("\'", "''", $row[$i]['topic_title'])) . "', '" . str_replace("\'", "''", $row[$i]['topic_poster']) . "', " . $row[$i]['topic_time'] . ", " . TOPIC_MOVED . ", " . POST_NORMAL . ", " . $row[$i]['topic_vote'] . ", " . $row[$i]['topic_views'] . ", " . $row[$i]['topic_replies'] . ", " . $row[$i]['topic_first_post_id'] . ", " . $row[$i]['topic_last_post_id'] . ", $topic_id)";
						if ( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not insert shadow topic', '', __LINE__, __FILE__, $sql);
						}
					}

					$sql = "UPDATE " . TOPICS_TABLE . " 
						SET forum_id = $new_forum_id  
						WHERE topic_id = $topic_id";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update old topic', '', __LINE__, __FILE__, $sql);
					}

					$sql = "UPDATE " . POSTS_TABLE . " 
						SET forum_id = $new_forum_id 
						WHERE topic_id = $topic_id";
					if ( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not update post topic ids', '', __LINE__, __FILE__, $sql);
					}
				}

				// Sync the forum indexes
				sync('forum', $new_forum_id);
				sync('forum', $old_forum_id);

				$message = $lang['Topics_Moved'] . '<br /><br />';
				$db->clear_cache('posts_');
				$db->clear_cache('movetopic_');
			}
			else
			{
				$message = $lang['No_Topics_Moved'] . '<br /><br />';
			}

			if ( !empty($topic_id) )
			{
				$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
				$message .= sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
			}
			else
			{
				$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
				$message .= sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
			}

			$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$old_forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

			$template->assign_vars(array(
				'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
			);

			message_die(GENERAL_MESSAGE, $message);
		}
		else
		{
			if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}

			$hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="mode" value="' . $mode . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />';

			if ( isset($HTTP_POST_VARS['topic_id_list']) )
			{
				$topics = $HTTP_POST_VARS['topic_id_list'];

				for($i = 0; $i < count($topics); $i++)
				{
					$hidden_fields .= '<input type="hidden" name="topic_id_list[]" value="' . intval($topics[$i]) . '" />';
				}
			}
			else
			{
				$hidden_fields .= '<input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" />';
			}

			//
			// Set template files
			//
			$template->set_filenames(array(
				'movetopic' => 'modcp_move.tpl')
			);

			$template->assign_vars(array(
				'MESSAGE_TITLE' => $lang['Confirm'],
				'MESSAGE_TEXT' => $lang['Confirm_move_topic'],

				'L_MOVE_TO_FORUM' => $lang['Move_to_forum'], 
				'L_LEAVESHADOW' => $lang['Leave_shadow_topic'], 
				'L_YES' => $lang['Yes'],
				'L_NO' => $lang['No'],

				'S_FORUM_SELECT' => make_forum_select('new_forum', $forum_id), 
				'S_MODCP_ACTION' => append_sid("modcp.$phpEx"),
				'S_HIDDEN_FIELDS' => $hidden_fields)
			);

			$template->pparse('movetopic');

			include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
		}
		break;

	case 'lock':
		if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != '' ) ? ', ' : '' ) . intval($topics[$i]);
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_LOCKED . " 
			WHERE topic_id IN ($topic_id_sql) 
				AND forum_id = $forum_id
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		$db->clear_cache('posts_');
		message_die(GENERAL_MESSAGE, $lang['Topics_Locked'] . '<br /><br />' . $message);

		break;

	case 'unlock':
		if ( empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id) )
		{
			message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics = ( isset($HTTP_POST_VARS['topic_id_list']) ) ?  $HTTP_POST_VARS['topic_id_list'] : array($topic_id);

		$topic_id_sql = '';
		for($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( ( $topic_id_sql != "") ? ', ' : '' ) . intval($topics[$i]);
		}

		$sql = "UPDATE " . TOPICS_TABLE . " 
			SET topic_status = " . TOPIC_UNLOCKED . " 
			WHERE topic_id IN ($topic_id_sql) 
				AND forum_id = $forum_id
				AND topic_moved_id = 0";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update topics table', '', __LINE__, __FILE__, $sql);
		}

		if ( !empty($topic_id) )
		{
			$redirect_page = "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = "modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'];
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br \><br \>' . sprintf($lang['Click_return_forum'], '<a href="' . "viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">')
		);

		$db->clear_cache('posts_');
		message_die(GENERAL_MESSAGE, $lang['Topics_Unlocked'] . '<br /><br />' . $message);

		break;

	case 'split':
		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$post_id_sql = '';

		if (isset($HTTP_POST_VARS['split_type_all']) || isset($HTTP_POST_VARS['split_type_beyond']))
		{
			$posts = $HTTP_POST_VARS['post_id_list'];

			for ($i = 0; $i < count($posts); $i++)
			{
				$post_id_sql .= (($post_id_sql != '') ? ', ' : '') . intval($posts[$i]);
			}
		}

		if ($post_id_sql != '')
		{
			$sql = "SELECT post_id 
				FROM " . POSTS_TABLE . "
				WHERE post_id IN ($post_id_sql)
					AND forum_id = $forum_id";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get post id information', '', __LINE__, __FILE__, $sql);
			}
			
			$post_id_sql = '';
			while ($row = $db->sql_fetchrow($result))
			{
				$post_id_sql .= (($post_id_sql != '') ? ', ' : '') . intval($row['post_id']);
			}
			$db->sql_freeresult($result);

			if ($post_id_sql == '')
			{
				message_die(GENERAL_MESSAGE, $lang['None_selected']);
			}
			// start mod split posts and merge in one step... replace most of the rest of the split case with the following

			// find out if the user wants to move or copy the split posts
			$split_copy = (empty($HTTP_POST_VARS['split_move_or_copy'])) ? true : '';

			// now check to see if subject (title title of the new topic) is empty...if so, and if there is a destination topic,
			// set $final_topic_id to the destination topic_id and $final_forum_id to the destination forum_id
			$new_topic_title = (!empty($HTTP_POST_VARS['subject'])) ? trim(htmlspecialchars($HTTP_POST_VARS['subject'])) : '';
			if (empty($new_topic_title))
			{
				// if we get here, the subject (topic title for the new topic) is blank so the user is presumably trying to
				// specify a target topic rather split into a new topic...so let's check to see if a destination topic
				// is actually filled in and if not give an error message
				$destination_topic = $HTTP_POST_VARS['destination_topic'];
				if (empty($destination_topic))
				{
					message_die(GENERAL_MESSAGE, $lang['Forgot_to_specify']);
				}
				else
				{
					// ok, the subject is blank and the destination topic line is filled in so let's
					// figure out what the topic_id and forum_id of the destination topic is...

					// the next block of code is borrowed from the simply merge mod...it extracts the topic id from topic_id, topic url or post url...
					// is this a direct value?
					$num_topic = intval($destination_topic);
					if ($destination_topic == "$num_topic")
					{
						$final_topic_id = $num_topic;
					}
					// is this a url with topic id or post id ?
					else
					{
						$name = explode('?', $destination_topic);
						$parms = ( isset($name[1]) ) ? $name[1] : $name[0];
						parse_str($parms, $parm);
						$found = false;
						$final_topic_id = 0;
						while ((list($key, $val) = each($parm)) && !$found)
						{
							$vals = explode('#', $val);
							$val = $vals[0];
							if (empty($val))
							{
								$val = 0;
							}
							else $val = intval($val);
							switch($key)
							{
								case POST_POST_URL:
								$sql = "SELECT topic_id FROM " . POSTS_TABLE . " WHERE post_id=$val";
								if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, 'Could not get post information', '', __LINE__, __FILE__, $sql);
								if ($row = $db->sql_fetchrow($result))
								{
									$val = $row['topic_id'];
									$found = true;
								}
								break;

								case POST_TOPIC_URL:
								$found = true;
								break;
							}
							if ($found)
							{
								$final_topic_id = $val;
							}
						}
					}

					// ok, we've fetched the topic_id for the destination topic and we've set $final_topic_id to that topic_id...
					// now, let's get the forum_id for destination topic and set $final_forum_id to that forum_id...
					$sql = "SELECT forum_id
							FROM " . TOPICS_TABLE . "
							WHERE topic_id = $final_topic_id";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not get forum information for destination topic', '', __LINE__, __FILE__, $sql);
					}
					$row = $db->sql_fetchrow($result);
					$final_forum_id = $row['forum_id'];
					$db->sql_freeresult($result);

					// if there is no forum_id (probably because there is no such topic_id), give error message
					if ($final_forum_id == '')
					{
						message_die(GENERAL_MESSAGE, 'Could not get forum information (no such topic_id?)');
					}
				}
			}

			// now get the post_time of the earliest post
			$sql = "SELECT post_time
					FROM " . POSTS_TABLE . "
					WHERE post_id IN ($post_id_sql)
					ORDER BY post_time ASC
					LIMIT 1";

			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not get post information', '', __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);
			$post_time = $row['post_time'];
			$db->sql_freeresult($result);

			// define the $sql_where variables used in the main query to pick the right posts in the topic
			// (the definitions depend on whether the admin has elected to 'split from selected post' or 'split selected postss')
			if (!empty($HTTP_POST_VARS['split_type_beyond']))
			{
				$sql_where_move = " post_time >= $post_time AND topic_id = $topic_id";
				$sql_where_copy = " p.post_time >= $post_time AND p.topic_id = $topic_id";
			}
			else
			{
				$sql_where_move = " post_id IN ($post_id_sql)";
				$sql_where_copy = " p.post_id IN ($post_id_sql)";
			}

			// now get the relevant post info, but the amount of relevant info depends on whether we are moving or copying the posts
			if ($split_copy)
			{
				// we are copying rather than moving, so we will need all the post and post text info
				$sql = "SELECT *
						FROM " . POSTS_TABLE . " p, " . POSTS_TEXT_TABLE . " pt
						WHERE $sql_where_copy
						AND pt.post_id = p.post_id
						ORDER BY post_time ASC";
			}
		else
		{
			// we are moving rather than copying, so collect only the info we need for a move
			$sql = "SELECT post_id, poster_id, topic_id, post_time
					FROM " . POSTS_TABLE . "
					WHERE $sql_where_move
					ORDER BY post_time ASC";
		}

		if (!$result = $db->sql_query($sql, BEGIN_TRANSACTION))
		{
			message_die(GENERAL_ERROR, 'Could not get post information', '', __LINE__, __FILE__, $sql);
		}

		// now actually fetch the post info
		$rows = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$rows[] = $row;
			$user_id_sql .= (($user_id_sql != '') ? ', ' : '') . $row['poster_id'];
			$post_id_sql .= (($post_id_sql != '') ? ', ' : '') . $row['post_id'];

			// check to confirm that the relevant post being split is in the current topic (if not, something is wrong)
			if ($topic_id != $row['topic_id'])
			{
				message_die(GENERAL_MESSAGE, 'For some reason, topic_id of one of the split posts does not match the topic we are splitting');
			}
		}
		$db->sql_freeresult($result);

		// check to see if user wants to split the posts to a brand new topic; if so, create that new topic
		if (!empty($new_topic_title))
		{
			$first_poster = $rows[0]['poster_id'];
			$final_forum_id = intval($HTTP_POST_VARS['new_forum_id']);

			$sql = 'SELECT forum_id FROM ' . FORUMS_TABLE . '
					WHERE forum_id = ' . $final_forum_id;
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not select from forums table', '', __LINE__, __FILE__, $sql);
			}
			if (!$db->sql_fetchrow($result))
			{
				message_die(GENERAL_MESSAGE, 'New forum does not exist');
			}
			$db->sql_freeresult($result);

			$sql = "INSERT INTO " . TOPICS_TABLE . " (topic_title, topic_poster, topic_time, forum_id, topic_status, topic_type)
					VALUES ('" . str_replace("\'", "''", $new_topic_title) . "', $first_poster, " . $post_time . ", $final_forum_id, " . TOPIC_UNLOCKED . ", " . POST_NORMAL . ")";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not insert new topic', '', __LINE__, __FILE__, $sql);
			}
			$final_topic_id = $db->sql_nextid();
		}

		// check to see if user wants to copy or move the split posts...handle differently depending on answer
		if ($split_copy)
		{
			// if we get here, the user wants to copy the posts, so do so...
			$split_post_count = count($rows);

			for ($i = 0; $i < $split_post_count; $i++)
			{
				$split_post_username = str_replace("'", "\'", $rows[$i]['post_username']);
				$split_post_poster_ip = str_replace("'", "\'", $rows[$i]['poster_ip']);
				$sql = "INSERT INTO " . POSTS_TABLE . " (topic_id, forum_id, poster_id, post_username, post_time, poster_ip, enable_bbcode, enable_html, enable_smilies, enable_sig) VALUES ($final_topic_id, $final_forum_id, " . $rows[$i]['poster_id'] . ", '$split_post_username', " . $rows[$i]['post_time'] . ", '$split_post_poster_ip', " . $rows[$i]['enable_bbcode'] . ", " . $rows[$i]['enable_html'] . ", " . $rows[$i]['enable_smilies'] . ", " . $rows[$i]['enable_sig'] . ")";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not insert post into posts table', '', __LINE__, __FILE__, $sql);
				}
				$split_post_id = $db->sql_nextid();
				$split_post_subject = str_replace("'", "\'", $rows[$i]['post_subject']);
				$split_post_bbcode_uid = $rows[$i]['bbcode_uid'];
				$split_post_text = str_replace("'", "\'", $rows[$i]['post_text']);

				$sql = "INSERT INTO " . POSTS_TEXT_TABLE . " (post_id, post_subject, bbcode_uid, post_text) VALUES ($split_post_id, '$split_post_subject', '$split_post_bbcode_uid', '$split_post_text')";
				if (!$db->sql_query($sql))
				{
					message_die(GENERAL_ERROR, 'Could not insert post text into posts text table', '', __LINE__, __FILE__, $sql);
				}
			}

			// now run a meaningless query so we can formally END TRANSACTION
			$sql = "SELECT 1";
			if (!$db->sql_query($sql, END_TRANSACTION))
			{
				message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
			}
		}
		else
		{
			// and if we get here, the user wants to move the posts, so...
			// do a sql for switching the split posts over to the final topic and forum
			$sql = "UPDATE " . POSTS_TABLE . "
					SET topic_id = $final_topic_id, forum_id = $final_forum_id
					WHERE $sql_where_move";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not update posts table', '', __LINE__, __FILE__, $sql);
			}

			//
			// The rest of this else statement deals with subscribing and unsubscribing users in the TOPICS_WATCH_TABLE
			//

			// Look up which users with split posts also have posts remaining behind so we
			// can figure out which users should not be unsubscribed from original topic
			$sql = "SELECT poster_id
					FROM " . POSTS_TABLE . "
					WHERE topic_id = $topic_id
					AND poster_id IN ($user_id_sql)";

			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not get the user_ids for users who still have posts in old topic', '', __LINE__, __FILE__, $sql);
			}

			// fetch user_id for each user that remains in the old topic
			$user_id_keep_subscribed_sql = 0;
			while ($row = $db->sql_fetchrow($result))
			{
				$user_id_keep_subscribed_sql .= ', ' . $row['poster_id'];
			}
			$db->sql_freeresult($result);

			// Now, look up which users with split posts don't already have an entry in the destination topic
			// so we can figure out which ones to subscribe to the destination topic

			$sql = "SELECT user_id
					FROM " . TOPICS_WATCH_TABLE . "
					WHERE topic_id = $final_topic_id
					AND user_id IN ($user_id_sql)";

			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not get the user_ids for users not already subscribed to the destination topic', '', __LINE__, __FILE__, $sql);
			}

			// now fetch user_id for each poster of a split post that is already subscribed to the destination topic
			$user_id_already_subscribed_sql = 0;
			while ($row = $db->sql_fetchrow($result))
			{
				$user_id_already_subscribed_sql .= ', ' . $row['user_id'];
			}
			$db->sql_freeresult($result);

			// Now insert an entry in topic watch table for each user with a split post going to the final topic
			// who had an entry for the original topic in that table unless that user already has an entry for the final topic
			// in that table

			$sql = "INSERT INTO " . TOPICS_WATCH_TABLE . " (user_id, topic_id, notify_status)
					SELECT DISTINCT user_id, $final_topic_id, 0
					FROM " . TOPICS_WATCH_TABLE . "
					WHERE topic_id = $topic_id
					AND user_id IN ($user_id_sql)
					AND user_id NOT IN ($user_id_already_subscribed_sql)";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not insert topic watch information for split post users', '', __LINE__, __FILE__, $sql);
			}

			// Finally, unsubscribe from old topic any user with split posts who has no posts remaining behind
			$sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
					WHERE topic_id = $topic_id
					AND user_id IN ($user_id_sql)
					AND user_id NOT IN ($user_id_keep_subscribed_sql)";

			if ( !$db->sql_query($sql, END_TRANSACTION) )
			{
				message_die(GENERAL_ERROR, 'Could not unsubscribe the users of posts being split', '', __LINE__, __FILE__, $sql);
			}

		}

		sync('topic', $final_topic_id);
		sync('topic', $topic_id);
		sync('forum', $final_forum_id);
		sync('forum', $forum_id);

		$template->assign_vars(array(
			'META' => '<meta http-equiv="refresh" content="3;url=' . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$final_topic_id&amp;sid=" . $userdata['session_id'] . '">')
			);

		$message = $lang['Topic_split'] . '<br /><br />' . sprintf($lang['Click_return_topic'], '<a href="' . "viewtopic.$phpEx?" . POST_TOPIC_URL . "=$final_topic_id&amp;sid=" . $userdata['session_id'] . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
		// end mod split posts and merge in one step
		}
		else
		{
			//
			// Set template files
			//
			$template->set_filenames(array(
				'split_body' => 'modcp_split.tpl')
			);

			$sql = "SELECT u.username, u.user_colortext, p.*, pt.post_text, pt.bbcode_uid, pt.post_subject, p.post_username
				FROM " . POSTS_TABLE . " p, " . USERS_TABLE . " u, " . POSTS_TEXT_TABLE . " pt
				WHERE p.topic_id = $topic_id
					AND p.poster_id = u.user_id
					AND p.post_id = pt.post_id
				ORDER BY p.post_time ASC";
//-- mod : rank color system ---------------------------------------------------
//-- add
			$sql = str_replace('SELECT ', 'SELECT u.user_level, u.user_color, u.user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------				
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not get topic/post information', '', __LINE__, __FILE__, $sql);
			}

			$s_hidden_fields = '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" /><input type="hidden" name="' . POST_TOPIC_URL . '" value="' . $topic_id . '" /><input type="hidden" name="mode" value="split" />';

			if( ( $total_posts = $db->sql_numrows($result) ) > 0 )
			{
				// Start Smilies Invasion Mod
				if ( $board_config['allow_smilies'] )
				{
					$forum_name = smilies_pass($forum_name);
				}
				// End Smilies Invasion Mod			
				$postrow = $db->sql_fetchrowset($result);

				$template->assign_vars(array(
					'L_SPLIT_TOPIC' => $lang['Split_Topic'],
					'L_SPLIT_TOPIC_EXPLAIN' => $lang['Split_Topic_explain'],
					'L_AUTHOR' => $lang['Author'],
					'L_MESSAGE' => $lang['Message'],
					'L_SELECT' => $lang['Select'],
					'L_SPLIT_SUBJECT' => $lang['Split_title'],
					'L_SPLIT_FORUM' => $lang['Split_forum'],
					'L_POSTED' => $lang['Posted'],
					'L_SPLIT_POSTS' => $lang['Split_posts'],
					'L_SUBMIT' => $lang['Submit'],
					'L_SPLIT_AFTER' => $lang['Split_after'], 
					'L_POST_SUBJECT' => $lang['Post_subject'], 
					'L_MARK_ALL' => $lang['Mark_all'], 
					'L_UNMARK_ALL' => $lang['Unmark_all'], 
					'L_POST' => $lang['Post'],
					'L_IF_TITLE_BLANK' => $lang['If_title_blank'],
					'L_DESTINATION_TOPIC' => $lang['Destination_topic'],
					'L_DESTINATION_TOPIC_FORMAT' => $lang['Destination_topic_format'],
					'L_SPLIT_MOVE_OR_COPY' => $lang['Split_move_or_copy'],
					'L_SPLIT_MOVE' => $lang['Split_move'],
					'L_SPLIT_COPY' => $lang['Split_copy'],
					'L_SPLIT_MOVE_OR_COPY_EXPLANATION' => $lang['Split_move_or_copy_explanation'],					

					'FORUM_NAME' => $forum_name, 

					'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"), 

					'S_SPLIT_ACTION' => append_sid("modcp.$phpEx"),
					'S_HIDDEN_FIELDS' => $s_hidden_fields,
					'S_FORUM_SELECT' => make_forum_select("new_forum_id", false, $forum_id))
				);

				//
				// Define censored word matches
				//
				$orig_word = array();
				$replacement_word = array();
				obtain_word_list($orig_word, $replacement_word);

				for($i = 0; $i < $total_posts; $i++)
				{
					$post_id = $postrow[$i]['post_id'];
					$poster_id = $postrow[$i]['poster_id'];
					$poster = $postrow[$i]['username'];

					$post_date = create_date($board_config['default_dateformat'], $postrow[$i]['post_time'], $board_config['board_timezone']);

					$bbcode_uid = $postrow[$i]['bbcode_uid'];
					$message = $postrow[$i]['post_text'];
					$post_subject = ( $postrow[$i]['post_subject'] != '' ) ? $postrow[$i]['post_subject'] : $topic_title;

					//
					// If the board has HTML off but the post has HTML
					// on then we process it, else leave it alone
					//
					if ( !$board_config['allow_html'] )
					{
						if ( $postrow[$i]['enable_html'] )
						{
							$message = preg_replace('#(<)([\/]?.*?)(>)#is', '&lt;\\2&gt;', $message);
						}
					}

					if ( $bbcode_uid != '' )
					{
						$message = ( $board_config['allow_bbcode'] ) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace('/\:[0-9a-z\:]+\]/si', ']', $message);
					}

					if ( count($orig_word) )
					{
						$post_subject = preg_replace($orig_word, $replacement_word, $post_subject);
						$message = preg_replace($orig_word, $replacement_word, $message);
					}

					$message = make_clickable($message);

					if ( $board_config['allow_smilies'] && $postrow[$i]['enable_smilies'] )
					{
						$message = smilies_pass($message);
					}

					$message = str_replace("\n", '<br />', $message);
					if ( $board_config['allow_colortext'] )
					{
						if ( $postrow[$i]['user_colortext'] != '' )
						{
							$message = '<font color="' . $postrow[$i]['user_colortext'] . '">' . $message . '</font>';
						}
					}					
					
					$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

					$checkbox = '<input type="checkbox" name="post_id_list[]" value="' . $post_id . '" />';
					// Start Smilies Invasion Mod
					if ( $board_config['allow_smilies'] )
					{
						$post_subject = smilies_pass($post_subject);
					}
					// End Smilies Invasion Mod					
					
					$template->assign_block_vars('postrow', array(
						'ROW_COLOR' => '#' . $row_color,
						'ROW_CLASS' => $row_class,
//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
						'POSTER_NAME' => $poster,
MOD-*/
						'POSTER_NAME' => ($poster_id == ANONYMOUS) ? (($postrow[$i]['post_username'] != '') ? $postrow[$i]['post_username'] : $lang['Guest']) : $rcs->get_colors($postrow[$i], $postrow[$i]['username']),
//-- fin mod : rank color system -----------------------------------------------						
						'POST_DATE' => $post_date,
						'POST_SUBJECT' => $post_subject,
						'MESSAGE' => $message,
						'POST_ID' => $post_id,
						
						'S_SPLIT_CHECKBOX' => $checkbox)
					);
				}

				$template->pparse('split_body');
			}
		}
		break;

	case 'ip':
		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);

		$rdns_ip_num = ( isset($HTTP_GET_VARS['rdns']) ) ? $HTTP_GET_VARS['rdns'] : "";

		if ( !$post_id )
		{
			message_die(GENERAL_MESSAGE, $lang['No_such_post']);
		}

		//
		// Set template files
		//
		$template->set_filenames(array(
			'viewip' => 'modcp_viewip.tpl')
		);

		// Look up relevent data for this post
		$sql = "SELECT poster_ip, poster_id 
			FROM " . POSTS_TABLE . " 
			WHERE post_id = $post_id
				AND forum_id = $forum_id";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get poster IP information', '', __LINE__, __FILE__, $sql);
		}
		
		if ( !($post_row = $db->sql_fetchrow($result)) )
		{
			message_die(GENERAL_MESSAGE, $lang['No_such_post']);
		}

		$ip_this_post = decode_ip($post_row['poster_ip']);
		$ip_this_post = ( $rdns_ip_num == $ip_this_post ) ? htmlspecialchars(gethostbyaddr($ip_this_post)) : $ip_this_post;

		$poster_id = $post_row['poster_id'];

		$template->assign_vars(array(
			'L_IP_INFO' => $lang['IP_info'],
			'L_THIS_POST_IP' => $lang['This_posts_IP'],
			'L_OTHER_IPS' => $lang['Other_IP_this_user'],
			'L_OTHER_USERS' => $lang['Users_this_IP'],
			'L_LOOKUP_IP' => $lang['Lookup_IP'], 
			'L_SEARCH' => $lang['Search'],

			'SEARCH_IMG' => $images['icon_search'], 

			'IP' => $ip_this_post, 
				
			'U_LOOKUP_IP' => "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;" . POST_TOPIC_URL . "=$topic_id&amp;rdns=$ip_this_post&amp;sid=" . $userdata['session_id'])
		);

		//
		// Get other IP's this user has posted under
		//
		$sql = "SELECT poster_ip, COUNT(*) AS postings 
			FROM " . POSTS_TABLE . " 
			WHERE poster_id = $poster_id 
			GROUP BY poster_ip 
			ORDER BY " . (( SQL_LAYER == 'msaccess' ) ? 'COUNT(*)' : 'postings' ) . " DESC";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get IP information for this user', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$i = 0;
			do
			{
				if ( $row['poster_ip'] == $post_row['poster_ip'] )
				{
					$template->assign_vars(array(
						'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ))
					);
					continue;
				}

				$ip = decode_ip($row['poster_ip']);
				$ip = ( $rdns_ip_num == $row['poster_ip'] || $rdns_ip_num == 'all') ? htmlspecialchars(gethostbyaddr($ip)) : $ip;

				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				$template->assign_block_vars('iprow', array(
					'ROW_COLOR' => '#' . $row_color, 
					'ROW_CLASS' => $row_class, 
					'IP' => $ip,
					'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ),

					'U_LOOKUP_IP' => "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=$post_id&amp;" . POST_TOPIC_URL . "=$topic_id&amp;rdns=" . $row['poster_ip'] . "&amp;sid=" . $userdata['session_id'])
				);

				$i++; 
			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		//
		// Get other users who've posted under this IP
		//
		$sql = "SELECT u.user_id, u.username, COUNT(*) as postings 
			FROM " . USERS_TABLE ." u, " . POSTS_TABLE . " p 
			WHERE p.poster_id = u.user_id 
				AND p.poster_ip = '" . $post_row['poster_ip'] . "'
			GROUP BY u.user_id, u.username
			ORDER BY " . (( SQL_LAYER == 'msaccess' ) ? 'COUNT(*)' : 'postings' ) . " DESC";
//-- mod : rank color system ---------------------------------------------------
//-- add
		$sql = str_replace('SELECT ', 'SELECT u.user_level, u.user_color, u.user_group_id, ', $sql);
//-- fin mod : rank color system -----------------------------------------------			
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not get posters information based on IP', '', __LINE__, __FILE__, $sql);
		}

		if ( $row = $db->sql_fetchrow($result) )
		{
			$i = 0;
			do
			{
				$id = $row['user_id'];
				$username = ( $id == ANONYMOUS ) ? $lang['Guest'] : $row['username'];

				$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
				$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

				$template->assign_block_vars('userrow', array(
					'ROW_COLOR' => '#' . $row_color, 
					'ROW_CLASS' => $row_class, 
//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
					'USERNAME' => $username,
MOD-*/
//-- add
					'USERNAME' => ($id == ANONYMOUS) ? $lang['Guest'] : $rcs->get_colors($row, $row['username']),
//-- fin mod : rank color system -----------------------------------------------					
					'POSTS' => $row['postings'] . ' ' . ( ( $row['postings'] == 1 ) ? $lang['Post'] : $lang['Posts'] ),
					'L_SEARCH_POSTS' => sprintf($lang['Search_user_posts'], $username), 

//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD
					'U_PROFILE' => ($id == ANONYMOUS) ? "modcp.$phpEx?mode=ip&amp;" . POST_POST_URL . "=" . $post_id . "&amp;" . POST_TOPIC_URL . "=" . $topic_id . "&amp;sid=" . $userdata['session_id'] : append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$id"),
MOD-*/
//-- add
					'U_PROFILE' => ($id == ANONYMOUS) ? $get->url('modcp', array('mode' => 'ip', POST_POST_URL => $post_id, POST_TOPIC_URL => $topic_id, 'sid' => $userdata['session_id']), true) : $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $id), true),
//-- fin mod : rank color system -----------------------------------------------
					'U_SEARCHPOSTS' => append_sid("search.$phpEx?search_author=" . (($id == ANONYMOUS) ? 'Anonymous' : urlencode($username)) . "&amp;showresults=topics"))
				);

				$i++; 
			}
			while ( $row = $db->sql_fetchrow($result) );
		}

		$template->pparse('viewip');

		break;
//-- mod : quick title edition -------------------------------------------------
//-- add
	case 'attribute':
		if (empty($HTTP_POST_VARS['topic_id_list']) && empty($topic_id))
		{
		  message_die(GENERAL_MESSAGE, $lang['None_selected']);
		}

		$topics	= isset($HTTP_POST_VARS['topic_id_list']) ? $HTTP_POST_VARS['topic_id_list'] : array($topic_id);
		$topic_id_sql = '';

		for ($i = 0; $i < count($topics); $i++)
		{
			$topic_id_sql .= ( !empty($topic_id_sql) ? ', ' : '' ) . intval($topics[$i]);
		}

		$attribute = ($row['attribute_id'] > -1) ? implode(',', array($row['attribute_id'], $userdata['user_id'], time())) : '';

		$sql = 'UPDATE ' . TOPICS_TABLE . ' 
			SET topic_attribute = \'' . $attribute . '\' 
			WHERE topic_id IN (' . $topic_id_sql . ') 
				AND topic_moved_id = 0';
		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, $lang['Attr_Error_Message_12'], '', __LINE__, __FILE__, $sql);
		}

		if (!empty($topic_id))
		{
			$redirect_page = $get->url('viewtopic', array(POST_TOPIC_URL => $topic_id, 'sid' => $userdata['session_id']), true);
			$message = sprintf($lang['Click_return_topic'], '<a href="' . $redirect_page . '">', '</a>');
		}
		else
		{
			$redirect_page = $get->url('modcp', array(POST_FORUM_URL => $forum_id, 'sid' => $userdata['session_id']), true);
			$message = sprintf($lang['Click_return_modcp'], '<a href="' . $redirect_page . '">', '</a>');
		}

		$message = $message . '<br /><br />' . sprintf($lang['Click_return_forum'], '<a href="' . $get->url('viewforum', array(POST_FORUM_URL => $forum_id, 'sid' => $userdata['session_id']), true) . '">', '</a>');
		$template->assign_vars(array('META' => '<meta http-equiv="refresh" content="3;url=' . $redirect_page . '">'));

		message_die(GENERAL_MESSAGE, $lang['Attribute_Edited'] . '<br /><br />' . $message);
		break;
//-- fin mod : quick title edition ---------------------------------------------

	default:
		$page_title = $lang['Mod_CP'];
		include($phpbb_root_path . 'includes/page_header.'.$phpEx);
		// Start Smilies Invasion Mod
		if ( $board_config['allow_smilies'] )
		{
			$forum_name = smilies_pass($forum_name);
		}
		// End Smilies Invasion Mod		

		$template->assign_vars(array(
			'FORUM_NAME' => $forum_name,
			//-- mod : quick title edition -------------------------------------------------
			//-- add
			'S_ATTRIBUTE_SELECTOR' => $qte->combo('', $userdata['user_id']),
			'L_ATTRIBUTE_APPLY' => $lang['Attribute_apply'],
			'I_MINI_SUBMIT' => $images['cmd_mini_submit'],
			//-- fin mod : quick title edition ---------------------------------------------

			'L_MOD_CP' => $lang['Mod_CP'],
			'L_MOD_CP_EXPLAIN' => $lang['Mod_CP_explain'],
			'L_SELECT' => $lang['Select'],
			'L_DELETE' => $lang['Delete'],
			'L_MOVE' => $lang['Move'],
			'L_LOCK' => $lang['Lock'],
			'L_UNLOCK' => $lang['Unlock'],
			'L_TOPICS' => $lang['Topics'], 
			'L_REPLIES' => $lang['Replies'],
//-- mod : rank color system ---------------------------------------------------
//-- add
			'L_AUTHOR' => $lang['Author'],
			'L_VIEWS' => $lang['Views'],
//-- fin mod : totally erc -----------------------------------------------------			
			'L_LASTPOST' => $lang['Last_Post'], 
			'L_SELECT' => $lang['Select'], 

			'U_VIEW_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$forum_id"), 
			'S_HIDDEN_FIELDS' => '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" /><input type="hidden" name="' . POST_FORUM_URL . '" value="' . $forum_id . '" />',
			'S_MODCP_ACTION' => append_sid("modcp.$phpEx"))
		);

		$template->set_filenames(array(
			'body' => 'modcp_body.tpl')
		);
		make_jumpbox('modcp.'.$phpEx);

		//
		// Define censored word matches
		//
		$orig_word = array();
		$replacement_word = array();
		obtain_word_list($orig_word, $replacement_word);

//-- mod : rank color system ---------------------------------------------------
//-- delete
/*-MOD		
		$sql = "SELECT t.*, u.username, u.user_id, p.post_time
			FROM " . TOPICS_TABLE . " t, " . USERS_TABLE . " u, " . POSTS_TABLE . " p
			WHERE t.forum_id = $forum_id
				AND t.topic_poster = u.user_id
				AND p.post_id = t.topic_last_post_id
			ORDER BY t.topic_type DESC, p.post_time DESC
			LIMIT $start, " . $board_config['topics_per_page'];
MOD-*/
//-- add
		$sql = 'SELECT t.*, u.username, u.user_id, u.user_level, u.user_color, u.user_group_id, u2.username as user2, u2.user_id as id2, u2.user_level as level2, u2.user_color as color2, u2.user_group_id as group_id2, p.post_username, p2.post_username AS post_username2, p2.post_time
			FROM ' . TOPICS_TABLE . ' t, ' . USERS_TABLE . ' u, ' . POSTS_TABLE . ' p, ' . POSTS_TABLE . ' p2, ' . USERS_TABLE . ' u2
			WHERE t.forum_id = ' . intval($forum_id) . '
				AND t.topic_poster = u.user_id
				AND p.post_id = t.topic_first_post_id
				AND p2.post_id = t.topic_last_post_id
				AND u2.user_id = p2.poster_id
			ORDER BY t.topic_type DESC, t.topic_last_post_id DESC
			LIMIT ' . $start . ', ' . $board_config['topics_per_page'];
//-- fin mod : rank color system ----------------------------------------------			
		if ( !($result = $db->sql_query($sql)) )
		{
	   		message_die(GENERAL_ERROR, 'Could not obtain topic information', '', __LINE__, __FILE__, $sql);
		}

		while ( $row = $db->sql_fetchrow($result) )
		{
			$topic_title = '';

			if ( $row['topic_status'] == TOPIC_LOCKED )
			{
				$folder_img = $images['folder_locked'];
				$folder_alt = $lang['Topic_locked'];
			}
			else
			{
				if ( $row['topic_type'] == POST_ANNOUNCE )
				{
					$folder_img = $images['folder_announce'];
				}
				else if ( $row['topic_type'] == POST_STICKY )
				{
					$folder_img = $images['folder_sticky'];
				}				
				else 
				{
					$folder_img = $images['folder'];
				}
				$folder_alt = topic_type_lang($row['topic_type']);
			}

			$topic_id = $row['topic_id'];
			$topic_type = topic_type_lang($row['topic_type'], $row['topic_status']);
	
			if ( $row['topic_vote'] )
			{
				$topic_type .= $lang['Topic_Poll'] . ' ';
			}
	
			$topic_title = $row['topic_title'];
			//-- mod : quick title edition -------------------------------------------------
			//-- add
			$qte->attr($topic_title, $row['topic_attribute']);
			//-- fin mod : quick title edition ---------------------------------------------
			if ( count($orig_word) )
			{
				$topic_title = preg_replace($orig_word, $replacement_word, $topic_title);
			}

			$u_view_topic = "modcp.$phpEx?mode=split&amp;" . POST_TOPIC_URL . "=$topic_id&amp;sid=" . $userdata['session_id'];
			$topic_replies = $row['topic_replies'];
//-- mod : rank color system ---------------------------------------------------
//-- add
			$topic_author_color = $rcs->get_colors($row);
			$topic_author = ($row['user_id'] != ANONYMOUS) ? '<a href="' . $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $row['user_id']), true) . '"' . $topic_author_color .'>' : '';
			$topic_author .= ($row['user_id'] != ANONYMOUS) ? $row['username'] : (($row['post_username'] != '') ? $row['post_username'] : $lang['Guest']);
			$topic_author .= ($row['user_id'] != ANONYMOUS) ? '</a>' : '';

			$first_post_time = create_date($board_config['default_dateformat'], $row['topic_time'], $board_config['board_timezone']);

			$last_post_author_color = $rcs->get_colors($row, '', false, 'group_id2', 'color2', 'level2');
			$last_post_author = ($row['id2'] == ANONYMOUS) ? (($row['post_username2'] != '') ? $row['post_username2'] : $lang['Guest']) : '<a href="' . $get->url('userlist', array('mode' => 'viewprofile', POST_USERS_URL => $row['id2']), true) . '"' . $last_post_author_color . '>' . $row['user2'] . '</a>';

			$last_post_url = '<a href="' . $get->url('viewtopic', array(POST_POST_URL => $row['topic_last_post_id']), true, $row['topic_last_post_id']) . '"><img src="' . $images['icon_latest_reply'] . '" alt="' . $lang['View_latest_post'] . '" title="' . $lang['View_latest_post'] . '" border="0" /></a>';

			$views = $row['topic_views'];
//-- fin mod : rank color system -----------------------------------------------			

			$last_post_time = create_date($board_config['default_dateformat'], $row['post_time'], $board_config['board_timezone']);

			// Start Smilies Invasion Mod
			if ( $board_config['allow_smilies'] )
			{
				$topic_title = smilies_pass($topic_title);
			}
			// End Smilies Invasion Mod			
			$template->assign_block_vars('topicrow', array(
				'U_VIEW_TOPIC' => $u_view_topic,
				'TOPIC_FOLDER_IMG' => $folder_img,
//-- mod : hypercell class -----------------------------------------------------
//-- add
				'HYPERCELL_CLASS' => get_hypercell_class($row['topic_status'], false, $row['topic_type']),
//-- fin mod : hypercell class -------------------------------------------------				
				'TOPIC_TYPE' => $topic_type, 
				'TOPIC_TITLE' => $topic_title,
				'REPLIES' => $topic_replies,
//-- mod : rank color system ---------------------------------------------------
//-- add
				'TOPIC_AUTHOR' => $topic_author,
				'VIEWS' => $views,
				'FIRST_POST_TIME' => $first_post_time,
				'LAST_POST_TIME' => $last_post_time,
				'LAST_POST_AUTHOR' => $last_post_author,
				'LAST_POST_IMG' => $last_post_url,
//-- fin mod : rank color system -----------------------------------------------				
				'LAST_POST_TIME' => $last_post_time,
				'TOPIC_ID' => $topic_id,
				'TOPIC_ATTACHMENT_IMG' => topic_attachment_image($row['topic_attachment']),

				'L_TOPIC_FOLDER_ALT' => $folder_alt)
			);
		}

		$template->assign_vars(array(
			'PAGINATION' => generate_pagination("modcp.$phpEx?" . POST_FORUM_URL . "=$forum_id&amp;sid=" . $userdata['session_id'], $forum_topics, $board_config['topics_per_page'], $start),
			'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $forum_topics / $board_config['topics_per_page'] )), 
			'L_GOTO_PAGE' => $lang['Goto_page'])
		);

		$template->pparse('body');

		break;
}

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>