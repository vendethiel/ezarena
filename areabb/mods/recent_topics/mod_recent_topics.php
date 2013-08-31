<?php

/***************************************************************************
 *                                mod_recent_topics.php
 *
 *       Adapté par Saint-Pere www.yep-yop.com
 *
 * 	Module Original :
 * 	Title: Recent Topics Block for Smartor's ezPortal
 * 	Author: Smartor <smartor_xp@hotmail.com> - http://smartor.is-root.com
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $areabb;

//chargement du template
$template->set_filenames(array(
   'recent_topics' => 'areabb/mods/recent_topics/tpl/mod_recent_topics.tpl'
 ));

$sql = 'SELECT * 
		FROM '. FORUMS_TABLE . ' 
		ORDER BY forum_id';
if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not query forums information', '', __LINE__, __FILE__, $sql);
}
$forum_data = array();
while( $row = $db->sql_fetchrow($result) )
{
	$forum_data[] = $row;
}

$is_auth_ary = array();
$is_auth_ary = auth(AUTH_ALL, AUTH_LIST_ALL, $userdata, $forum_data);
$except_forum_id = "" ;

for ($i = 0; $i < count($forum_data); $i++)
{
	if ((!$is_auth_ary[$forum_data[$i]['forum_id']]['auth_read']) or (!$is_auth_ary[$forum_data[$i]['forum_id']]['auth_view']))
	{
			$except_forum_id .= ( $except_forum_id == '' ) ? $forum_data[$i]['forum_id'] : ',' . $forum_data[$i]['forum_id'] ;
	}
}
$sql_except = ( $except_forum_id != '' ) ?  ' AND t.forum_id NOT IN ( '.$except_forum_id.' ) ' :'';


$sql = 'SELECT t.topic_id, t.topic_title, t.topic_last_post_id, t.forum_id, p.post_id, p.poster_id, p.post_time, u.user_id, u.username
		FROM ' . TOPICS_TABLE . ' AS t, ' . POSTS_TABLE . ' AS p, ' . USERS_TABLE . ' AS u
		WHERE t.topic_status <> 2 
		'.$sql_except .' 
		AND p.post_id = t.topic_last_post_id
		AND p.poster_id = u.user_id
		ORDER BY p.post_id DESC
		LIMIT 0,' . $areabb['nbre_topics_recents'];

if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, 'Could not query recent topics information', '', __LINE__, __FILE__, $sql);
}

if ($db->sql_numrows($result) > 0)
{

	while ($row = $db->sql_fetchrow($result))
	{
			$template->assign_block_vars('recent_topic_row', array(
			'U_TITLE'		=> append_sid('viewtopic.'.$phpEx.'?' . POST_POST_URL . '=' . $row['post_id']) . '#' .$row['post_id'],
			'L_TITLE'		=> $row['topic_title'],
			'U_POSTER'		=> areabb_profile($row['user_id'],$row['username']),
			'S_POSTTIME'	=> create_date($board_config['default_dateformat'], $row['post_time'], $board_config['board_timezone'])
		));	
	}

	// Activer le Scrolling
	if ( $areabb['defiler_topics_recents'] == 1)
	{
		$template->assign_block_vars('scrolling_row',array());
	}

	$template->assign_vars(	array(
		'BY'				=> $lang['topic_by'],
		'ON'				=> $lang['topic_on'],	
		'L_RECENT_TOPICS'	=> $lang['Recent_topics']
	));
}


$template->assign_var_from_handle('recent_topics', 'recent_topics');

?>