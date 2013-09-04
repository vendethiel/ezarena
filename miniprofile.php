<?php
/***************************************************************************
 * miniprofile.php
 * -----------------
 * begin		: Mardi 15 Mars 2005
 * copyright		: crewstyle - http://crewstyle.free.fr <crewstyle@free.fr>
 * version		: 2.3.1 - 31/03/2005 00:39
 *
 * $Id		: miniprofile.php, v 2.3.1 - 31/03/2005 00:39 - crewstyle Exp $
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

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
	exit;
}

if ( empty($HTTP_GET_VARS[POST_USERS_URL]) || $HTTP_GET_VARS[POST_USERS_URL] == ANONYMOUS )
{
	message_die(GENERAL_MESSAGE, $lang['No_user_id_specified']);
}
$profiledata = get_userdata($HTTP_GET_VARS[POST_USERS_URL]);

$sql = "SELECT *
	FROM " . RANKS_TABLE . "
	ORDER BY rank_special, rank_min";
if ( !($result = $db->sql_query($sql, false, true)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain ranks information', '', __LINE__, __FILE__, $sql);
}

$ranksrow = array();
while ( $row = $db->sql_fetchrow($result) )
{
	$ranksrow[] = $row;
}
$db->sql_freeresult($result);

$avatar_img = '';
if ( $profiledata['user_avatar_type'] && $profiledata['user_allowavatar'] )
{
	switch( $profiledata['user_avatar_type'] )
	{
		case USER_AVATAR_UPLOAD:
			$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_REMOTE:
			$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
		case USER_AVATAR_GALLERY:
			$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $profiledata['user_avatar'] . '" alt="" border="0" />' : '';
			break;
	}
}

$page_title = $profiledata['username'];

$poster_rank = '';
$rank_image = '';
if ( $profiledata['user_rank'] )
{
	for($i = 0; $i < count($ranksrow); $i++)
	{
		if ( $profiledata['user_rank'] == $ranksrow[$i]['rank_id'] && $ranksrow[$i]['rank_special'] )
		{
			$poster_rank = $ranksrow[$i]['rank_title'];
			$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
		}
	}
}
else
{
	for($i = 0; $i < count($ranksrow); $i++)
	{
		if ( $profiledata['user_posts'] >= $ranksrow[$i]['rank_min'] && !$ranksrow[$i]['rank_special'] )
		{
			$poster_rank = $ranksrow[$i]['rank_title'];
			$rank_image = ( $ranksrow[$i]['rank_image'] ) ? '<img src="' . $ranksrow[$i]['rank_image'] . '" alt="' . $poster_rank . '" title="' . $poster_rank . '" border="0" /><br />' : '';
		}
	}
}

$temp_url = append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']);
$profile_img = '<a href="' . $temp_url . '" onclick="opener.document.location.href=\'' . $temp_url . '\';window.close();return false;" target="_new"><img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" /></a>';
$profile = '<a href="' . $temp_url . '" target="_userwww">' . $lang['Read_profile'] . '</a>';

$temp_url = append_sid("privmsg.$phpEx?mode=post&amp;" . POST_USERS_URL . "=" . $profiledata['user_id']);
$pm_img = '<a href="' . $temp_url . '" onclick="opener.document.location.href=\'' . $temp_url . '\';window.close();return false;" target="_new"><img src="' . $images['icon_pm'] . '" alt="' . $lang['Send_private_message'] . '" title="' . $lang['Send_private_message'] . '" border="0" /></a>';
$pm = '<a href="' . $temp_url . '" target="_userwww">' . $lang['Send_private_message'] . '</a>';

if ( !empty($profiledata['user_viewemail']) || $userdata['user_level'] == ADMIN )
{
	$email_uri = ( $board_config['board_email_form'] ) ? append_sid("profile.$phpEx?mode=email&amp;" . POST_USERS_URL .'=' . $profiledata['user_id']) : 'mailto:' . $profiledata['user_email'];

	$email_img = '<a href="' . $email_uri . '"><img src="' . $images['icon_email'] . '" alt="' . $lang['Send_email'] . '" title="' . $lang['Send_email'] . '" border="0" /></a>';
	$email = '<a href="' . $email_uri . '">' . $lang['Send_email'] . '</a>';
}
else
{
	$email_img = '';
	$email = '';
}

$www_img = ( $profiledata['user_website'] ) ? '<a href="' . $profiledata['user_website'] . '" target="_userwww"><img src="' . $images['icon_www'] . '" alt="' . $lang['Visit_website'] . '" title="' . $lang['Visit_website'] . '" border="0" /></a>' : '';
$www = ( $profiledata['user_website'] ) ? '<acronym title="' . $profiledata['user_website'] . '"><a href="' . $profiledata['user_website'] . '" target="_userwww" class="genmed">' . $lang['Visit_website'] . '</a></acronym>' : '';

if ( isset($profiledata['user_icq']) )
{
	$icq_status_img = '<a href="http://wwp.icq.com/' . $profiledata['user_icq'] . '#pager" target="_userwww"><img src="http://web.icq.com/whitepages/online?icq=' . $profiledata['user_icq'] . '&img=5" width="18" height="18" border="0" /></a>';
	$icq_img = '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $profiledata['user_icq'] . '" target="_userwww"><img src="' . $images['icon_icq'] . '" alt="' . $lang['ICQ'] . '" title="' . $lang['ICQ'] . '" border="0" /></a>';
	$icq =  '<a href="http://wwp.icq.com/scripts/search.dll?to=' . $profiledata['user_icq'] . '" target="_userwww">' . $lang['ICQ'] . '</a>';
}
else
{
	$icq_status_img = '';
	$icq_img = '';
	$icq = '';
}

$aim_img = ( $profiledata['user_aim'] ) ? '<a href="aim:goim?screenname=' . $profiledata['user_aim'] . '&amp;message=Hello+Are+you+there?" target="_userwww"><img src="' . $images['icon_aim'] . '" alt="' . $lang['AIM'] . '" title="' . $lang['AIM'] . '" border="0" /></a>' : '';
$aim = ( $profiledata['user_aim'] ) ? '<a href="aim:goim?screenname=' . $profiledata['user_aim'] . '&amp;message=Hello+Are+you+there?" target="_userwww">' . $lang['AIM'] . '</a>' : '';

$msn_img = ( $profiledata['user_msnm'] ) ? $profiledata['user_msnm'] : '';
$msn = $msn_img;

$yim_img = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg" target="_userwww"><img src="' . $images['icon_yim'] . '" alt="' . $lang['YIM'] . '" title="' . $lang['YIM'] . '" border="0" /></a>' : '';
$yim = ( $profiledata['user_yim'] ) ? '<a href="http://edit.yahoo.com/config/send_webmesg?.target=' . $profiledata['user_yim'] . '&amp;.src=pg" target="_userwww">' . $lang['YIM'] . '</a>' : '';

// Addon for Birthday Event
$birthdays = $birthday->display_details($profiledata['user_birthday'], $profiledata['user_zodiac'], true);

// Start add - Gender MOD
if ( !empty($profiledata['user_gender']) )
{
	switch($profiledata['user_gender'])
	{
		case 1:
			$gender = $lang['Male'];
			$gender_img = "<img src=\"" . $images['icon_minigender_male'] . "\" alt=\"" . $lang['Gender'] .  ":" . $lang['Male'] . "\" title=\"" . $lang['Gender'] . ":" . $lang['Male'] . "\" border=\"0\" />";
			break;
		case 2:
			$gender = $lang['Female'];
			$gender_img = "<img src=\"" . $images['icon_minigender_female'] . "\" alt=\"" . $lang['Gender'] . ":" . $lang['Female'] . "\" title=\"" . $lang['Gender'] . ":" . $lang['Female'] . "\" border=\"0\" />";
			break;
		default:
			$gender = $lang['No_gender_specify'];
			$gender_img = $lang['No_gender_specify'];
	}
}
else
{
	$gender = $lang['No_gender_specify'];
}
// End add - Gender MOD

//
// Generate page
//
define('IS_AJAX', !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

$gen_simple_header = TRUE;
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$template->set_filenames(array(
	'miniprofile' => 'miniprofile_body.tpl',
));


if (function_exists('get_html_translation_table'))
{
	$u_search_author = urlencode(strtr($profiledata['username'], array_flip(get_html_translation_table(HTML_ENTITIES))));
}
else
{
	$u_search_author = urlencode(str_replace(array('&amp;', '&#039;', '&quot;', '&lt;', '&gt;'), array('&', "'", '"', '<', '>'), $profiledata['username']));
}

if (strlen($profiledata['user_occ'])>23) { 
	$profiledata['user_occ'] = '<acronym title="' . $profiledata['user_occ'] . '">' . substr($profiledata['user_occ'],0,20) . '...</acronym>'; 
}

if (strlen($profiledata['user_interests'])>23) { 
	$profiledata['user_interests'] = '<acronym title="' . $profiledata['user_interests'] . '">' . substr($profiledata['user_interests'],0,20) . '...</acronym>'; 
}

$profiledata['username'] = $rcs->get_colors($profiledata, $profiledata['username']);

$template->assign_vars(array(
	'USERNAME' => $profiledata['username'],
	'POSTER_RANK' => $poster_rank,
	'RANK_IMAGE' => $rank_image,
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
	'YIM' => $yim,
	'AVATAR_IMG' => $avatar_img,
	'PROFILE_IMG' => $profile_img,
	'PROFILE' => $profile,

	'LOCATION' => ( $profiledata['user_from'] ) ? $profiledata['user_from'] : '',
	'OCCUPATION' => ( $profiledata['user_occ'] ) ? $profiledata['user_occ'] : '',
	'INTERESTS' => ( $profiledata['user_interests'] ) ? $profiledata['user_interests'] : '',
	'GENDER' => $gender,
	'GENDER_IMG' => $gender_img,

	'L_GENDER' => $lang['Gender'],
	'L_CLOSE_WINDOW' => "<a href='javascript:window.close();'>" . $lang['Close_window'] . "</a>",
	'L_VIEWING_MINI_PROFILE' => sprintf($lang['Viewing_user_mini_profile'], $profiledata['username']),
	'L_AVATAR' => $lang['Avatar'],
	'L_POSTER_RANK' => $lang['Poster_rank'],
	'L_SEARCH_USER_POSTS' => sprintf($lang['Search_user_posts'], $profiledata['username']),
	'L_CONTACT' => $lang['Contact'],
	'L_EMAIL_ADDRESS' => $lang['Email_address'],
	'L_EMAIL' => $lang['Email'],
	'L_PM' => $lang['Private_Message'],
	'L_ICQ_NUMBER' => $lang['ICQ'],
	'L_YAHOO' => $lang['YIM'],
	'L_AIM' => $lang['AIM'],
	'L_MESSENGER' => $lang['MSNM'],
	'L_WEBSITE' => $lang['Website'],
	'L_BIRTHDAY' => $lang['Birthday'],

	'L_OCCUPATION' => $lang['Occupation'],
	'L_INTERESTS' => $lang['Interests'],

	'U_SEARCH_USER' => append_sid("search.$phpEx?search_author=" . $u_search_author),

//-- mod : birthday ------------------------------------------------------------
	'USER_BIRTHDATE' => empty($birthdays) ? '' : $birthdays['birthday'],
	'USER_AGE' => empty($birthdays) ? '' : $birthdays['age'],
	'L_USER_ZODIAC' => empty($birthdays) ? '' : lang_item($birthdays['zodiac']),
	'I_USER_ZODIAC' => empty($birthdays) ? '' : $images[$birthdays['zodiac']],

	'IS_AJAX' => IS_AJAX,
));

$template->pparse('miniprofile');

// no footer §