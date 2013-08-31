<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                             mod_top_posteurs.php
//
//    par Saint-Pere
//--------------------------------------------------------------------------------------------------------------------------------------

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $board_config,$lang,$images;

$limit = 5;
//chargement du template
$template->set_filenames(array(
   'top_posteurs' => 'areabb/mods/top_posteurs/tpl/mod_top_posteurs.tpl'
));

$sql = 'SELECT p.poster_id, u.username, count(p.poster_id) as Nb
		,u.user_website, u.user_email, u.user_icq, u.user_aim, u.user_yim, u.user_regdate
		, u.user_msnm, u.user_viewemail, u.user_rank, u.user_sig, u.user_sig_bbcode_uid
		, u.user_avatar, u.user_avatar_type, u.user_allowavatar
		FROM ' . POSTS_TABLE . ' as p 
		LEFT JOIN ' . USERS_TABLE . ' as u 
		ON (p.poster_id = u.user_id)
		WHERE u.user_id > 0 
		GROUP BY poster_id 
		ORDER BY Nb DESC 
		LIMIT 0,'.$limit;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible d\'acceder à la tables des posts", '', __LINE__, __FILE__, $sql); 
}
while ($row = $db->sql_fetchrow($result))
{
	// Avatar
	$avatar_img = '';
	if ( $row['user_avatar_type'] && $row['user_allowavatar'] )
	{
		switch( $row['user_avatar_type'] )
		{
			case USER_AVATAR_UPLOAD:
				$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $row['user_avatar'] . '" alt="'.$row['username'].'" title="'.$row['username'].'" border="0" />' : '';
				break;
			case USER_AVATAR_REMOTE:
				$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $row['user_avatar'] . '" alt="'.$row['username'].'" title="'.$row['username'].'" border="0" />' : '';
				break;
			case USER_AVATAR_GALLERY:
				$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $row['user_avatar'] . '" alt="'.$row['username'].'" title="'.$row['username'].'" border="0" />' : '';
				break;
		}
	}
	// Check For Anonymous User
	if ($row['user_id'] != '-1')
	{
		if ($row['user_avatar'] == '')
		{
			$avatar_img = '<img src="areabb/images/guest_avatar.gif" alt="'.$row['username'].'" title="'.$row['username'].'" border="0" />';
		}
	}
	$poster_id = $row['user_id'];
	// On affiche les petites icones
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
		$profile_img	= '';
		$profile		= '';
		$pm_img			= '';
		$pm				= '';
		$email_img		= '';
		$email			= '';
		$www_img		= '';
		$www			= '';
		$icq_status_img = '';
		$icq_img		= '';
		$icq			= '';
		$aim_img		= '';
		$aim			= '';
		$msn_img		= '';
		$msn			= '';
		$yim_img		= '';
		$yim			= '';
	}
	//  on alterne les class
	$class = ( $class == 'row1' )? 'row2' : 'row1';
	
	$template->assign_block_vars('bloc_top_posteurs',array(
		'USER' 			=> areabb_profile($row['poster_id'],$row['username']),
		'AVATAR'		=> $avatar_img,
		'POSTS'			=> $row['Nb'],
		'class'			=> $class,
		'MINI_POST_IMG'	=> $mini_post_img,
		'PROFILE_IMG'	=> $profile_img,
		'PROFILE'		=> $profile,
		'SEARCH_IMG'	=> $search_img,
		'SEARCH'		=> $search,
		'PM_IMG'		=> $pm_img,
		'PM'			=> $pm,
		'EMAIL_IMG'		=> $email_img,
		'EMAIL'			=> $email,
		'WWW_IMG'		=> $www_img,
		'WWW'			=> $www,
		'ICQ_STATUS_IMG'=> $icq_status_img,
		'ICQ_IMG'		=> $icq_img,
		'ICQ'			=> $icq,
		'AIM_IMG'		=> $aim_img,
		'AIM'			=> $aim,
		'MSN_IMG'		=> $msn_img,
		'MSN'			=> $msn,
		'YIM_IMG'		=> $yim_img,
		'YIM'			=> $yim
	));
}



//template
$template->assign_vars( array(
	'L_TOP_POSTEURS'	=> $lang['L_TOP_POSTEURS'],
	'Posts'				=> $lang['Posts'],
));

$template->assign_var_from_handle('top_posteurs', 'top_posteurs');

?>