<?php
/***************************************************************************
                                inc_date.php

	Par Saint-Pere www.yep-yop.com

****************************************************************************/


if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $areabb,$images,$HTTP_GET_VARS,$lang,$bbc_tag;
include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);

$is_auth = array();
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

$template->set_filenames(array(
      'news' => 'areabb/mods/news/tpl/news_normal.tpl'
));


// on détermine à quel jour la date choisie correspond
if (strlen($date_news) == 6)
{
	$m = substr($date_news,0,2);
	$y = substr($date_news,2,4);
	$date_min = mktime(0,0,0,$m,1,$y);
	$date_max = mktime(23,59,59,$m,31,$y);
}else{
	$d = explode('-',$date_news);
	$date_min = mktime(0,0,0,$d[1],$d[2],$d[0]);
	$date_max = mktime(23,59,59,$d[1],$d[2],$d[0]);
}



$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$areabb['news_forums'] =  ($areabb['news_forums'] == '') ? '""' : $areabb['news_forums'];
$forum_icon = ($areabb['news_aff_icone'] == '1') ? ' forum_icon, ' : ''; 

// nombre maximal de news pour cette demande
$sql = 'SELECT count(topic_id) as max_news
	FROM ' . TOPICS_TABLE . ' 
	WHERE  forum_id IN (' . $areabb['news_forums'] . ')
	AND  topic_time > \''.$date_min.'\'
	AND  topic_time < \''.$date_max.'\'';
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain newer/older topic information', '', __LINE__, __FILE__, $sql);
}
$row = $db->sql_fetchrow($result);
$max_news = $row['max_news'];


$sql = 'SELECT t.topic_id, t.topic_time, t.topic_title, pt.post_text, u.username, u.user_id, '.$forum_icon.'
		  t.topic_replies,t.topic_views, pt.bbcode_uid, t.forum_id, t.topic_poster, t.topic_first_post_id,
		  t.topic_status, pt.post_id, p.post_id, p.enable_smilies FROM ' . TOPICS_TABLE . 
		  ' AS t, ' . USERS_TABLE . ' AS u, ' . POSTS_TEXT_TABLE . ' AS pt, ' . POSTS_TABLE .
		  ' AS p, '.FORUMS_TABLE.' as f WHERE  t.forum_id IN (' . $areabb['news_forums'] . 
		  ') AND t.topic_poster = u.user_id 
		  AND  t.topic_time > \''.$date_min.'\'
		  AND  t.topic_time < \''.$date_max.'\'
		  AND f.forum_id=t.forum_id 
		  AND t.topic_first_post_id = pt.post_id 
		  AND t.topic_first_post_id = p.post_id 
		  AND t.topic_status <> 2
		ORDER BY  t.topic_time DESC 
		  LIMIT '.$start.','.$areabb['news_nbre_news'];

if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain newer/older topic information', '', __LINE__, __FILE__, $sql);
}
if ($db->sql_numrows($result) == 0)
{
	$template->assign_block_vars('no_news', array());
}else{
	$template->assign_block_vars('news', array());
	while ($row = $db->sql_fetchrow($result))
	{
		// visiteur autorisé à lire cette news ? 
		$is_auth = auth(AUTH_ALL, $row['forum_id'], $userdata, $row);
		if( $is_auth['auth_view'] || $is_auth['auth_read'] )
		{
			// formatages des BBcodes
			$message = $row['post_text'];
			$bbcode_uid = $row['bbcode_uid'];
			// Formatage de l'HTML
			if ( !$board_config['allow_html'] || !$userdata['user_allowhtml'])
			{
				if ( $row['enable_html'] ) $message = preg_replace('#(<)([\/]?.*?)(>)#is', "&lt;\\2&gt;", $message);	
			}
			if ($bbcode_uid != '')
			{
				$message = ($board_config['allow_bbcode']) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $message);
			}
			// Il y a des liens ?
			$message = make_clickable($message);
			// Des petits smileys ? 
			if ( $board_config['allow_smilies'] )
			{
				if ( $row['enable_smilies'] )	$message = smilies_pass($message);
			}
			// On censure les gros mots ..
			$message = str_replace('\"', '"', substr(@preg_replace('#(\>(((?>([^><]+|(?R)))*)\<))#se', "@preg_replace(\$orig_word, \$replacement_word, '\\0')", '>' . $message . '<'), 1, -1));
			$message = str_replace("\n", '<br />', $message);
			// on affiche l'icone de la catégorie ? 
			$icone = ($arcade_config['news_aff_icone'] == '1') ? '<img src="'.$row['forum_icon'].'" alt="'.$row['forum_desc'].'" border="0" align="right">' : '';
			
			$template->assign_block_vars('news.lignes', array(
				'ICONE'		=> $icone,
				'TITRE'		=> preg_replace($orig_word, $replacement_word, $row['topic_title']),
				'AUTEUR'	=> areabb_profile($row['topic_poster'],$row['username']),
				'SUITE'		=> append_sid('news.'.$phpEx.'?action=detail&article='.$row['topic_id']),
				'COMS'		=> $row['topic_replies'],
				'VIEWS'		=> $row['topic_views'],
				'DATE'		=> MySQLDateToExplicitDate(date("Y-m-d", $row['topic_time'])),
				'NEWS'		=> couper_texte($message,$areabb['news_nbre_mots'])

			));	
		}
	}
}
if ($areabb['news_forums'] != '') $template->assign_block_vars('news_icone', array());

$template->assign_vars(array(	
	'L_PAGINATION'	=> $lang['L_PAGE_NEWS'],
	'L_NO_NEWS'		=> $lang['L_NO_NEWS'],
	'L_NO_NEWS_TITRE'=> $page_title,
	'I_VIEWS'		=> $phpbb_root_path.$images['icon_areabb_views'],
	'I_COMS'		=> $phpbb_root_path.$images['icon_areabb_coms'],
	'L_SUITE'		=> $lang['Read_Full'],
	'SID'			=> $userdata['session_id'],
	'LE'			=> $lang['topic_on'],
	'L_PAR'			=> $lang['topic_by'],
	'PAGINATION'	=> pagination_news('action=date&date_news='.$date_news,$max_news,$start)
));

?>