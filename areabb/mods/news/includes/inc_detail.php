<?php
/***************************************************************************
                                inc_normal.php

	Adapté par Saint-Pere www.yep-yop.com

****************************************************************************/


if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $areabb,$images,$bbc_tag;
include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);

$is_auth = array();
$orig_word = array();
$replacement_word = array();
obtain_word_list($orig_word, $replacement_word);

// on récupère les rangs.
$sql = "SELECT *
	FROM " . RANKS_TABLE . "
	ORDER BY rank_special, rank_min";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Could not obtain ranks information.", '', __LINE__, __FILE__, $sql);
}

$ranksrow = array();
while ( $row = $db->sql_fetchrow($result) )
{
	$ranksrow[] = $row;
}
$db->sql_freeresult($result);

$template->set_filenames(array(
      'news' => 'areabb/mods/news/tpl/news_detail.tpl'
));

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$areabb['news_forums'] =  ($areabb['news_forums'] == '') ? '""' : $areabb['news_forums'];
$topic_id = intval($HTTP_GET_VARS['article']);
$forum_icon = ($areabb['news_aff_icone'] == '1') ? ' forum_icon, ' : ''; 

// on affiche l'ASV ?
if ($areabb['news_aff_asv'] == '1')
{
	$asv = ',u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_regdate, u.user_msnm, u.user_viewemail, u.user_rank, u.user_sig, u.user_sig_bbcode_uid, u.user_avatar, u.user_avatar_type, u.user_allowavatar ';
}

$sql = 'SELECT t.topic_id, t.topic_time, t.topic_title, pt.post_text, u.username, u.user_id,'.$forum_icon.'
		  t.topic_replies, pt.bbcode_uid, t.forum_id, t.topic_poster, p.post_id, p.enable_smilies '.$asv.' 
		  FROM ' . TOPICS_TABLE . 
		  ' AS t, ' . USERS_TABLE . ' AS u, ' . POSTS_TEXT_TABLE . ' AS pt, ' . POSTS_TABLE .
		  ' AS p, '.FORUMS_TABLE.' as f WHERE  t.forum_id IN (' . $areabb['news_forums'] . ') 
		  AND t.topic_id='.$topic_id.'
		  AND f.forum_id=t.forum_id 
		  AND t.topic_poster = u.user_id 
		  AND t.topic_first_post_id = pt.post_id 
		  AND t.topic_first_post_id = p.post_id';
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain newer/older topic information', '', __LINE__, __FILE__, $sql);
}


$row = $db->sql_fetchrow($result);

// visiteur autorisé à lire cette news ? 

$is_auth = auth(AUTH_ALL, $row['forum_id'], $userdata, $row);
if( !$is_auth['auth_view'] || !$is_auth['auth_read'] )
{
	message_die(GENERAL_ERROR, 'Ca forum vous est interdit !');
}

//
// Compteur de lecture ...
//
$sql = 'UPDATE ' . TOPICS_TABLE . '
	SET topic_views = topic_views + 1
	WHERE topic_id = '.$topic_id;
if ( !$db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not update topic views.", '', __LINE__, __FILE__, $sql);
}


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
// id de ce post
$post_id = $row['post_id'];

// On affiche l'ASV de l'auteur ? 
if ($areabb['news_aff_asv'] == '1')
{
	$poster_id = $row['user_id'];
	$poster_rank = '';
	$rank_image = '';
	if ( $row['user_id'] == ANONYMOUS )
	{
	}
	else if ( $row['user_rank'] )
	{
		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $row['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
			{
				$poster_rank = $ranksrow[$j]['rank_title'];
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
	}
	else
	{
		for($j = 0; $j < count($ranksrow); $j++)
		{
			if ( $postrow[$i]['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] )
			{
				$poster_rank = $ranksrow[$j]['rank_title'];
				$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
			}
		}
	}

	//
	// Handle anon users posting with usernames
	//
	if ( $poster_id == ANONYMOUS && $row['post_username'] != '' )
	{
		$poster = $postrow[$i]['post_username'];
		$poster_rank = $lang['Guest'];
	}

	$temp_url = '';

	if ( $poster_id != ANONYMOUS )
	{
		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
		$profile_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
		$profile = '<a href="' . $temp_url . '">' . $lang['Read_profile'] . '</a>';

		$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=$poster_id");
		$pm_img = '<a href="' . $temp_url . '"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
		$pm = '<a href="' . $temp_url . '">' . $lang['Send_private_message'] . '</a>';

		if ( !empty($row['user_viewemail']) || $is_auth['auth_mod'] )
		{
			$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $poster_id) : 'mailto:' . $row['user_email'];

			$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
			$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
		}
		else
		{
			$email_img = '';
			$email = '';
		}

		$www_img = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
		$www = ( $row['user_website'] ) ? '<a href="' . $row['user_website'] . '" target="_userwww">' . $lang['Visit_website'] . '</a>' : '';

		if ( !empty($row['user_icq']) )
		{
			$icq_status_img = '<a href="http://wwp.icq.com/' . $row['user_icq'] . '#pager"><img src="http://web.icq.com/whitepages/online?icq=' . $row['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
			$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
			$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $row['user_icq'] . '">' . $lang['ICQ'] . '</a>';
		}
		else
		{
			$icq_status_img = '';
			$icq_img = '';
			$icq = '';
		}

		$aim_img = ( $row['user_aim'] ) ? '<a href="aim:goim?screenname=' . $row['user_aim'] . '&amp;message=Hello+Are+you+there?"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '';
		$aim = ( $postrow[$i]['user_aim'] ) ? '<a href="aim:goim?screenname=' . $row['user_aim'] . '&amp;message=Hello+Are+you+there?">' . $lang['AIM'] . '</a>' : '';

		$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=$poster_id");
		$msn_img = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '"><img src="' . $images['icon_msnm'] . '" alt="' . $lang['MSNM'] . '" title="' . $lang['MSNM'] . '" border="0" /></a>' : '';
		$msn = ( $row['user_msnm'] ) ? '<a href="' . $temp_url . '">' . $lang['MSNM'] . '</a>' : '';

		$yim_img = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
		$yim = ( $row['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $row['user_yim'] . '&amp;.src=pg">' . $lang['YIM'] . '</a>' : '';
		
	}else{
		$profile_img = '';
		$profile = '';
		$pm_img = '';
		$pm = '';
		$email_img = '';
		$email = '';
		$www_img = '';
		$www = '';
		$icq_status_img = '';
		$icq_img = '';
		$icq = '';
		$aim_img = '';
		$aim = '';
		$msn_img = '';
		$msn = '';
		$yim_img = '';
		$yim = '';
	}
	$template->assign_block_vars('ASV', array(
		'MINI_POST_IMG' => $mini_post_img,
		'PROFILE_IMG' => $profile_img,
		'PROFILE' => $profile,
		'SEARCH_IMG' => $search_img,
		'SEARCH' => $search,
		'PM_IMG' => $pm_img,
		'PM' => $pm,
		'EMAIL_IMG' => $email_img,
		'EMAIL' => $email,
		'WWW_IMG' => $www_img,
		'WWW' => $www,
		'ICQ_STATUS_IMG' => $icq_status_img,
		'ICQ_IMG' => $icq_img,
		'ICQ' => $icq,
		'AIM_IMG' => $aim_img,
		'AIM' => $aim,
		'MSN_IMG' => $msn_img,
		'MSN' => $msn,
		'YIM_IMG' => $yim_img,
		'YIM' => $yim
	));
}
// on affiche l'icone de la catégorie ? 
$icone = ($areabb['news_aff_icone'] == '1') ? '<img src="images/forum_icons/'.$row['forum_icon'].'" alt="'.$row['forum_desc'].'" border="0" align="right">' : '';

$template->assign_vars(array(	
	'ICONE'			=> $icone,
	'L_PAGINATION'	=> $lang['L_PAGINATION'],
	'L_SUITE'		=> $lang['L_SUITE'],
	'L_COMS'		=> $lang['L_COMS'],
	'LE'			=> $lang['topic_on'],
	'L_PAR'			=> $lang['topic_by'],
	'L_NO_COMMENTAIRE'=> $lang['L_NO_COMMENTAIRE'],
	'COMMENTAIRES'	=> $lang['Comments'],
	'SID'			=> $userdata['session_id'],
	'TOPIC_ID'		=> $row['topic_id'],
	'L_POST_COM'	=> $lang['Post_your_comment'],
	'TITRE'			=> preg_replace($orig_word, $replacement_word, $row['topic_title']),
	'AUTEUR'		=> areabb_profile($row['topic_poster'],$row['username']),
	'SUITE'			=> append_sid('news.'.$phpEx.'?action=detail&article='.$row['topic_id']),
	'DATE'			=> MySQLDateToExplicitDate(date("Y-m-d-H-i-s", $row['topic_time']),1,1,1),
	'COMS'			=> $row['topic_replies'],
	'NEWS'			=> $message,
	'PAGES'			=> pagination_coms($row['topic_id'],$row['topic_replies'],$start),
	'L_PAGES'		=> $lang['L_PAGE_COM']
));



	// Listage des commentaires
	$areabb['news_forums'] =  ($areabb['news_forums'] == '' )? '""' : $areabb['news_forums'];
	$sql = 'SELECT pt.post_text, u.username,u.user_avatar, u.user_avatar_type,u.user_allowavatar,u.user_rank,u.user_posts, u.user_id,p.post_time, pt.bbcode_uid, p.poster_id, p.post_id, p.enable_smilies 
			FROM ' . POSTS_TABLE .' AS p 
			LEFT JOIN ' . POSTS_TEXT_TABLE . ' AS pt ON (p.post_id=pt.post_id) 
			LEFT JOIN ' . USERS_TABLE . ' AS u ON (p.poster_id=u.user_id) 
			WHERE  p.forum_id IN (' . $areabb['news_forums'] . ') 
			AND p.topic_id='.$topic_id.' 
			AND p.post_id !='.$post_id.' 
			LIMIT '.$start.','.$areabb['news_nbre_coms'];
			
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain newer/older topic information', '', __LINE__, __FILE__, $sql);
	}
	if ($db->sql_numrows($result) == 0)
	{
		$template->assign_block_vars('no_commentaires', array());
	}else{
		$template->assign_block_vars('commentaires', array());
		while ($row = $db->sql_fetchrow($result))
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
			
			// Avatar du commentaire
			$poster_avatar = '';
			if ( $row['user_avatar_type'] && $row['poster_id'] != ANONYMOUS && $row['user_allowavatar'] )
			{
				switch( $row['user_avatar_type'] )
				{
					case USER_AVATAR_UPLOAD:
						$poster_avatar = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
						break;
					case USER_AVATAR_REMOTE:
						$poster_avatar = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="" border="0" />' : '';
						break;
					case USER_AVATAR_GALLERY:
						$poster_avatar = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $row['user_avatar'] . '" alt="" border="0" />' : '';
						break;
					default :
						$poster_avatar = '<img src="arcade/images/guest_avatar.gif" alt="" border="0" />';
						break;
				}
			}
			// Hop on mets le rang au dessus de l'avatar
			$poster_rank = '';
			$rank_image = '';
			if ( $row['user_id'] == ANONYMOUS )
			{
			}
			else if ( $row['user_rank'] )
			{
				for($j = 0; $j < count($ranksrow); $j++)
				{
					if ( $row['user_rank'] == $ranksrow[$j]['rank_id'] && $ranksrow[$j]['rank_special'] )
					{
						$poster_rank = $ranksrow[$j]['rank_title'];
						$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
					}
				}
			}
			else
			{
				for($j = 0; $j < count($ranksrow); $j++)
				{
					if ( $row['user_posts'] >= $ranksrow[$j]['rank_min'] && !$ranksrow[$j]['rank_special'] )
					{
						$poster_rank = $ranksrow[$j]['rank_title'];
						$rank_image = ( $ranksrow[$j]['rank_image'] ) ? '<img src="' . $ranksrow[$j]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
					}
				}
			}
		
			$template->assign_block_vars('commentaires.lignes', array(
				'AUTEUR'	=> areabb_profile($row['poster_id'],$row['username']),
				'RANK'		=> $poster_rank,
				'IMG_RANK'	=> $rank_image,
				'AVATAR'	=> $poster_avatar,
				'DATE'		=> MySQLDateToExplicitDate(date("Y-m-d-H-i-s", $row['post_time']),1,1,1),
				'NEWS'		=> $message		
			));

		
		}
	}
	// On permet de saisir un commentaire ?
if ($areabb['news_aff_coms'] == '1')
{
	$template->assign_block_vars('saisir_commentaire', array());
}
?>