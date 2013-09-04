<?php
/***************************************************************************
 *                              page_header.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: page_header.php,v 1.106.2.25 2005/10/30 15:17:14 acydburn Exp $
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

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

define('HEADER_INC', TRUE);
// www.phpBB-SEO.com SEO TOOLKIT BEGIN - BOTS
$bots_online = array();
$online_botlist = '';
$bot_count = 0;
$bot_style = array( 'Google' => 'style="color:#2159D6;font-weight:bold"', 'MSN' => 'style="color:#52BA18;font-weight:bold"', 'Yahoo!' => 'style="color:#FF0031;font-weight:bold"' );
$bot_to_style = array( 'Google', 'Yahoo!', 'Yahoo!' , 'Yahoo!', 'MSN',  'MSN', 'MSN', 'MSN');
$bot_ips = array( '66.249', '74.6', '66.196', '66.142', '64.4', '65.5', '131.107', '207.46' );
// www.phpBB-SEO.com SEO TOOLKIT END - BOTS

//
// gzip_compression
//
$do_gzip_compress = FALSE;
if ( $board_config['gzip_compress'] )
{
	$phpver = phpversion();

	$useragent = (isset($_SERVER["HTTP_USER_AGENT"]) ) ? $_SERVER["HTTP_USER_AGENT"] : $HTTP_USER_AGENT;

	if ( $phpver >= '4.0.4pl1' && ( strstr($useragent,'compatible') || strstr($useragent,'Gecko') ) )
	{
		if ( extension_loaded('zlib') )
		{
			if (headers_sent() != TRUE) 
			{ 
				//
				// Here we updated the gzip function.
				// With this method we can get the server up
				// to 10% faster
				//
				$gz_possible = isset($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING']) && eregi('gzip, deflate',$HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING']); 
				if ($gz_possible) 
				{
					ob_start('ob_gzhandler'); 
				}
			}
		}
	}
	else if ( $phpver > '4.0' )
	{
		if ( strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') )
		{
			if ( extension_loaded('zlib') )
			{
				$do_gzip_compress = TRUE;
				ob_start();
				ob_implicit_flush(0);

				header('Content-Encoding: gzip');
			}
		}
	}
}

//
// Parse and show the overall header.
//
$template->set_filenames(array(
	'overall_header' => ( empty($gen_simple_header) ) ? 'overall_header.tpl' : 'simple_header.tpl')
);

//
// Generate logged in/logged out status
//
if ( $userdata['session_logged_in'] )
{
	$u_login_logout = 'login.'.$phpEx.'?logout=true&amp;sid=' . $userdata['session_id'];
	$l_login_logout = $lang['Logout'] . ' [ ' . $userdata['username'] . ' ]';
	if ($board_config['points_browse'] && !$post_info['points_disabled'] )
	{
		$points = $board_config['points_browse'];

		if (($userdata['user_id'] !=ANONYMOUS) && ($userdata['admin_allow_points']))
		{
			add_points($userdata['user_id'], $points);
		}
	}	
}
else
{
	$u_login_logout = 'login.'.$phpEx;
	$l_login_logout = $lang['Login'];
}

$t = $userdata['session_logged_in'] ? $userdata['user_lastvisit'] :	$board_config['guest_lastvisit'];
$s_last_visit = create_date($board_config['default_dateformat'], $t, $board_config['board_timezone']);

if (defined('SHOW_ONLINE'))
{
	new show_online();
}

//
// Obtain number of new private messages
// if user is logged in
//
if ( ($userdata['session_logged_in']) && (empty($gen_simple_header)) )
{
	if ( $userdata['user_new_privmsg'] )
	{
		$l_message_new = ( $userdata['user_new_privmsg'] == 1 ) ? $lang['New_pm'] : $lang['New_pms'];
		$l_privmsgs_text = sprintf($l_message_new, $userdata['user_new_privmsg']);

		if ( $userdata['user_last_privmsg'] > $userdata['user_lastvisit'] )
		{
			$sql = "UPDATE " . USERS_TABLE . "
				SET user_last_privmsg = " . $userdata['user_lastvisit'] . "
				WHERE user_id = " . $userdata['user_id'];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update private message new/read time for user', '', __LINE__, __FILE__, $sql);
			}

			$s_privmsg_new = 1;
			$icon_pm = $images['pm_new_msg'];
		}
		else
		{
			$s_privmsg_new = 0;
			$icon_pm = $images['pm_new_msg'];
		}
	}
	else
	{
		$l_privmsgs_text = $lang['No_new_pm'];

		$s_privmsg_new = 0;
		$icon_pm = $images['pm_no_new_msg'];
	}

	if ( $userdata['user_unread_privmsg'] )
	{
		$l_message_unread = ( $userdata['user_unread_privmsg'] == 1 ) ? $lang['Unread_pm'] : $lang['Unread_pms'];
		$l_privmsgs_text_unread = sprintf($l_message_unread, $userdata['user_unread_privmsg']);
	}
	else
	{
		$l_privmsgs_text_unread = $lang['No_unread_pm'];
	}
}
else
{
	$icon_pm = $images['pm_no_new_msg'];
	$l_privmsgs_text = $lang['Login_check_pm'];
	$l_privmsgs_text_unread = '';
	$s_privmsg_new = 0;
}

//
// Generate HTML required for Mozilla Navigation bar
//
if (!isset($nav_links))
{
	$nav_links = array();
}
//-- mod : rank color system ---------------------------------------------------
//-- add
$nav_links = empty($nav_links) ? array() : array_merge($nav_links, array(
	'author' => array(
		'url' => $get->url('userlist', '', true),
		'title' => $lang['Memberlist'],
	),
));
//-- fin mod : rank color system -----------------------------------------------
$nav_links_html = '';
$nav_link_proto = '<link rel="%s" href="%s" title="%s" />' . "\n";
while( list($nav_item, $nav_array) = @each($nav_links) )
{
	if ( !empty($nav_array['url']) )
	{
		$nav_links_html .= sprintf($nav_link_proto, $nav_item, append_sid($nav_array['url']), $nav_array['title']);
	}
	else
	{
		// We have a nested array, used for items like <link rel='chapter'> that can occur more than once.
		while( list(,$nested_array) = each($nav_array) )
		{
			$nav_links_html .= sprintf($nav_link_proto, $nav_item, $nested_array['url'], $nested_array['title']);
		}
	}
}
// DEBUT MOD Logo aléatoire 
$intervalle = intval($board_config['LoAl_Intervalle_logos']) * 60; 

// Récupération du logo actuel. 
$sql = "SELECT * FROM " . LOGOS_TABLE . " WHERE selected = 1"; 
if( !($result = $db->sql_query($sql, false, 'logos_')) ) 
{ 
	message_die(GENERAL_ERROR, 'Could not obtain logos information', '', __LINE__, __FILE__, $sql); 
}

// Si un logo est sélectionne et s'il est suffisemment récent, on le conserve. 
$timeNow = time(); 
if(($logoCaracs = $db->sql_fetchrow($result)) && (($logoCaracs['date_select'] + $intervalle) > $timeNow))
{ 
	$logoIMG = $logoCaracs['adresse']; 
} 
// Sinon, on cherch un remplaçant. 
else 
{ 
	// Récupération du total des probas. 
	$sql = "SELECT sum(proba) AS total FROM " . LOGOS_TABLE; 
	if( !($result2 = $db->sql_query($sql, false, 'logos_proba_')) ) 
	{ 
		message_die(GENERAL_ERROR, 'Could not obtain logos information', '', __LINE__, __FILE__, $sql); 
	}    
	if(!($rowProba = $db->sql_fetchrow($result2))) 
	{
		message_die(GENERAL_ERROR, 'Tous les logos on une probabilité nulle', '', __LINE__, __FILE__, $sql); 
	}
	$db->sql_freeresult($result2);

	// Récuération des caracs des logos. 
	$sql = "SELECT * FROM " . LOGOS_TABLE . " ORDER BY logo_id"; 
	if( !($result3 = $db->sql_query($sql, false, 'logos_')) ) 
	{
		message_die(GENERAL_ERROR, 'Could not obtain logos information', '', __LINE__, __FILE__, $sql); 
	}

	// Recherche du bon logo.
	$cur = 1; 
	$logoId = 0; 
	$logoSelect = rand(1,$rowProba['total']); // Calcul au hasard entre 1 et le total des probas. 
	while(($cur <= $logoSelect) && ($rowLogo = $db->sql_fetchrow($result3))) 
	{ 
		$cur += $rowLogo['proba']; 
		$logoIMG = $rowLogo['adresse']; 
		$logoId = $rowLogo['logo_id']; 
	}
	$db->sql_freeresult($result3);

	// On ne met à jour le logo selectionné que si l'intervalle est positif. 
	if($intervalle > 0) 
	{       
		// Déselection du logo prcédent dans la base. 
		$sql = "UPDATE " . LOGOS_TABLE . " 
		SET selected = 0, date_select = 0 
		WHERE selected = 1"; 
		if ( !$db->sql_query($sql) ) 
		{ 
		message_die(GENERAL_ERROR, 'Could not update logos information', '', __LINE__, __FILE__, $sql); 
		} 

		// Marquage du nouveau logo dans la base. 
		$sql = "UPDATE " . LOGOS_TABLE . " 
		SET selected = 1, date_select = $timeNow 
		WHERE logo_id = $logoId";

		if ( !$db->sql_query($sql) ) 
		{ 
			message_die(GENERAL_ERROR, 'Could not update logos information', '', __LINE__, __FILE__, $sql); 
		}

		$db->clear_cache('logos_');
	} 
}
$db->sql_freeresult($result);
// FIN MOD Logo aléatoire

// Format Timezone. We are unable to use array_pop here, because of PHP3 compatibility
$l_timezone = explode('.', $board_config['board_timezone']);
$l_timezone = (count($l_timezone) > 1 && $l_timezone[count($l_timezone)-1] != 0) ? $lang[sprintf('%.1f', $board_config['board_timezone'])] : $lang[number_format($board_config['board_timezone'])];
//
// The following assigns all _common_ variables that may be used at any point
// in a template.
//
//START MOD Keep_unread_2
// check to see if we are supposed to toggle unread link from "View your unread posts" to "You have no unread posts" depending on whether 
// there are unread posts (on large boards people may want to skip that toggle by defining $toggle_unreads_link as false 
// in index.php to save query time)
if ($toggle_unreads_link)
{
	// only run a new list_new_unreads check if we haven't already done that by the time we get here (if we're coming from index.php this will already have been done in index.php)
	if ( !isset($new_unreads) )
	{
		$new_unreads = (list_new_unreads($forum_unreads, $toggle_unreads_link)) ? true : false;
	}
}
else
{
	// if we get here, we are not supposed to toggle the unread link so we'll just set the link to read "View your unread posts" in all cases
	$new_unreads = true;
}
//END MOD Keep_unread_2
// www.phpBB-SEO.com SEO TOOLKIT BEGIN - META
$seo_meta = "";
if (is_object($phpbb_seo) ) {
	// phpBB SEO - META
	$seo_meta = $phpbb_seo->build_meta($page_title);
}
$admin_link = ( $userdata['user_level'] == ADMIN ) ? '<a href="admin/index.' . $phpEx . '?sid=' . $userdata['session_id'] . '">' . $lang['Admin_panel'] . '</a><br /><br />' : '';

if ($userdata['user_level'] == ADMIN)
{
	$template->assign_block_vars('isadmin', array());
}

// www.phpBB-SEO.com SEO TOOLKIT END - META
$template->assign_vars(array(
	'ADMIN_LINK' => $admin_link,
	'ADMIN_LINK_HEADER' => str_replace('<a', '<a class="mainmenu"', $admin_link),
	'LOGO_IMG' => $logoIMG, 
	'SERVER_NAME' => $board_config['server_name'],
	'SCRIPT_PATH' => $board_config['script_path'],
	'PHPEX' => $phpEx,
	'POST_POST_URL' => POST_POST_URL,
	'COPY' => $lang['Copy'],
	'SITENAME' => $board_config['sitename'],
	'SITE_DESCRIPTION' => $board_config['site_desc'],
	'PAGE_TITLE' => $page_title,
	'META_TAG' => $seo_meta,
	'LAST_VISIT_DATE' => sprintf($lang['You_last_visit'], $s_last_visit),
	'CURRENT_TIME' => sprintf($lang['Current_time'], create_date($board_config['default_dateformat'], time(), $board_config['board_timezone'])),
	'RECORD_USERS' => sprintf($lang['Record_online_users'], $board_config['record_online_users'], create_date($board_config['default_dateformat'], $board_config['record_online_date'], $board_config['board_timezone'])),
	'PRIVATE_MESSAGE_INFO' => $l_privmsgs_text,
	'PRIVATE_MESSAGE_INFO_UNREAD' => $l_privmsgs_text_unread,
	'PRIVATE_MESSAGE_NEW_FLAG' => $s_privmsg_new,
	'PRIVMSG_IMG' => $icon_pm,
	'I_BT_SHOWHIDE' => $images['bt_showhide'],
			
	'L_BT_TITLE' => $lang['bt_title'],
	'L_BT_PERMS' => $lang['bt_perms'],
	'L_BT_ICONS' => $lang['bt_icons'],
	'L_BT_SHOWHIDE_ALT' => $lang['bt_showhide_alt'],

	'L_USERNAME' => $lang['Username'],
	'L_PASSWORD' => $lang['Password'],
	'L_LOGIN_LOGOUT' => $l_login_logout,
	'L_LOGIN' => $lang['Login'],
	'L_LOG_ME_IN' => $lang['Log_me_in'],
	'L_AUTO_LOGIN' => $lang['Log_me_in'],
	'L_INDEX' => sprintf($lang['Forum_Index'], $board_config['sitename']),
	'L_REGISTER' => $lang['Register'],
	'L_PROFILE' => $lang['Profile'],
	'L_SEARCH' => $lang['Search'],
	'L_PRIVATEMSGS' => $lang['Private_Messages'],
	'L_WHO_IS_ONLINE' => $lang['Who_is_Online'],
	'L_MEMBERLIST' => $lang['Memberlist'],
	'L_FAQ' => $lang['FAQ'],
	'L_USERGROUPS' => $lang['Usergroups'],
	'L_SEARCH_NEW' => ($new_unreads) ? $lang['View_unread_posts'] : $lang['No_unread_posts'],
	'L_SEARCH_UNANSWERED' => $lang['Search_unanswered'],
	'L_SEARCH_SELF' => $lang['Search_your_posts'],
	'L_WHOSONLINE_ADMIN' => sprintf($lang['Admin_online_color'], '<span style="color:#' . $theme['fontcolor3'] . '">', '</span>'),
	'L_WHOSONLINE_MOD' => sprintf($lang['Mod_online_color'], '<span style="color:#' . $theme['fontcolor2'] . '">', '</span>'),
	'L_BOARD_STYLE' => $lang['Board_style'],	
	'L_RMW_IMAGE_TITLE' => $lang['rmw_image_title'],

	'U_SEARCH_UNANSWERED' => append_sid('search.'.$phpEx.'?search_id=unanswered'),
	'U_SEARCH_SELF' => append_sid('search.'.$phpEx.'?search_id=egosearch'),
	'U_SEARCH_NEW' => append_sid('search.'.$phpEx.'?search_id=newposts'),
	'U_INDEX' => append_sid('index.'.$phpEx),
	'U_REGISTER' => append_sid('profile.'.$phpEx.'?mode=register'),
	'U_PROFILE' => append_sid('profile.'.$phpEx.'?mode=editprofile'),
	'U_PRIVATEMSGS' => append_sid('privmsg.'.$phpEx.'?folder=inbox'),
	'U_PRIVATEMSGS_POPUP' => append_sid('privmsg.'.$phpEx.'?mode=newpm'),
	'U_SEARCH' => append_sid('search.'.$phpEx),
	'U_MEMBERLIST' => append_sid('memberlist.'.$phpEx),
	'U_ADR' => append_sid('adr_character.'.$phpEx), 
	'L_ADR' => $lang['Adr_character_page_name'], 
	'U_TOWNMAP' => append_sid('adr_TownMap.'.$phpEx), 
	'L_TOWNMAP' => $lang['Adr_TownMap_name'], 
	'U_RABBITOSHI' => append_sid('rabbitoshi.'.$phpEx), 
	'L_RABBITOSHI' => $board_config['rabbitoshi_name'], 
	'L_RABBITOSHI_POSTS' => $lang['Rabbitoshi_topic'], 
	'U_CAULDRON' => append_sid('adr_cauldron.'.$phpEx), 
	'L_CAULDRON' => $lang['Adr_cauldron_title'], 
	'U_MODCP' => append_sid('modcp.'.$phpEx),
	'U_FAQ' => append_sid('faq.'.$phpEx),
	'U_VIEWONLINE' => append_sid('viewonline.'.$phpEx),
	'U_LOGIN_LOGOUT' => append_sid($u_login_logout),
	'U_GROUP_CP' => append_sid('groupcp.'.$phpEx),
	
	'S_CONTENT_DIRECTION' => $lang['DIRECTION'],
	'S_CONTENT_ENCODING' => $lang['ENCODING'],
	'S_CONTENT_DIR_LEFT' => $lang['LEFT'],
	'S_CONTENT_DIR_RIGHT' => $lang['RIGHT'],
	'S_TIMEZONE' => sprintf($lang['All_times'], $l_timezone),
	'S_LOGIN_ACTION' => append_sid('login.'.$phpEx),
	'BBC_BOX_SHEET' => isset($images['bbc_box_sheet']) ? $images['bbc_box_sheet'] : '',
	'T_TEMPLATE_NAME' => $theme['template_name'],
	'T_STYLE_NAME' => $theme['style_name'],
	'T_HEAD_STYLESHEET' => $theme['head_stylesheet'],
	'HYPERCELL_PATH' => $theme['template_name'] . '/hypercell',
	'T_BODY_BACKGROUND' => $theme['body_background'],
	'T_BODY_BGCOLOR' => '#'.$theme['body_bgcolor'],
	'T_BODY_TEXT' => '#'.$theme['body_text'],
	'T_BODY_LINK' => '#'.$theme['body_link'],
	'T_BODY_VLINK' => '#'.$theme['body_vlink'],
	'T_BODY_ALINK' => '#'.$theme['body_alink'],
	'T_BODY_HLINK' => '#'.$theme['body_hlink'],
	'T_TR_COLOR1' => '#'.$theme['tr_color1'],
	'T_TR_COLOR2' => '#'.$theme['tr_color2'],
	'T_TR_COLOR3' => '#'.$theme['tr_color3'],
	'T_TR_CLASS1' => $theme['tr_class1'],
	'T_TR_CLASS2' => $theme['tr_class2'],
	'T_TR_CLASS3' => $theme['tr_class3'],
	'T_TH_COLOR1' => '#'.$theme['th_color1'],
	'T_TH_COLOR2' => '#'.$theme['th_color2'],
	'T_TH_COLOR3' => '#'.$theme['th_color3'],
	'T_TH_CLASS1' => $theme['th_class1'],
	'T_TH_CLASS2' => $theme['th_class2'],
	'T_TH_CLASS3' => $theme['th_class3'],
	'T_TD_COLOR1' => '#'.$theme['td_color1'],
	'T_TD_COLOR2' => '#'.$theme['td_color2'],
	'T_TD_COLOR3' => '#'.$theme['td_color3'],
	'T_TD_CLASS1' => $theme['td_class1'],
	'T_TD_CLASS2' => $theme['td_class2'],
	'T_TD_CLASS3' => $theme['td_class3'],
	'T_FONTFACE1' => $theme['fontface1'],
	'T_FONTFACE2' => $theme['fontface2'],
	'T_FONTFACE3' => $theme['fontface3'],
	'T_FONTSIZE1' => $theme['fontsize1'],
	'T_FONTSIZE2' => $theme['fontsize2'],
	'T_FONTSIZE3' => $theme['fontsize3'],
	'T_FONTCOLOR1' => '#'.$theme['fontcolor1'],
	'T_FONTCOLOR2' => '#'.$theme['fontcolor2'],
	'T_FONTCOLOR3' => '#'.$theme['fontcolor3'],
	'T_SPAN_CLASS1' => $theme['span_class1'],
	'T_SPAN_CLASS2' => $theme['span_class2'],
	'T_SPAN_CLASS3' => $theme['span_class3'],
	'S_SEARCH_ACTION' => append_sid("search.$phpEx?mode=results"),
	'L_SEARCH_QUERY' => $lang['Search_query'],
	'L_ADVANCED_SEARCH' => $lang['Advanced_Search'],	

	'NAV_LINKS' => $nav_links_html)
);

//
// Login box?
//
if ( !$userdata['session_logged_in'] )
{
	$template->assign_block_vars('switch_user_logged_out', array());
	//
	// Allow autologin?
	//
	if (!isset($board_config['allow_autologin']) || $board_config['allow_autologin'] )
	{
		$template->assign_block_vars('switch_allow_autologin', array());
		$template->assign_block_vars('switch_user_logged_out.switch_allow_autologin', array());
	}
}
else
{
	$template->assign_block_vars('switch_user_logged_in', array());
	if ( !empty($userdata['user_popup_pm']) )
	{
		$template->assign_block_vars('switch_enable_pm_popup', array());
	}
}
//
// Show board disabled note
//
if (defined('BOARD_DISABLE'))
{
	$disable_message = (!empty($board_config['board_disable_msg'])) ? htmlspecialchars($board_config['board_disable_msg']) : $lang['Board_disable'];
	$template->assign_block_vars('board_disable', array(
		'MSG' => str_replace("\n", '<br />', $disable_message))
	);
}
	if ( $userdata['user_level'] == ADMIN ) 
	{ 
		$template->assign_block_vars('switch_admin_logged_in', array()); 
	}

// Add no-cache control for cookies if they are set
//$c_no_cache = (isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_sid']) || isset($HTTP_COOKIE_VARS[$board_config['cookie_name'] . '_data'])) ? 'no-cache="set-cookie", ' : '';

// Work around for "current" Apache 2 + PHP module which seems to not
// cope with private cache control setting
if (!empty($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Apache/2'))
{
	header ('Cache-Control: no-cache, pre-check=0, post-check=0');
}
else
{
	header ('Cache-Control: private, pre-check=0, post-check=0, max-age=0');
}
header ('Expires: 0');
header ('Pragma: no-cache');

$template->pparse('overall_header');

if ( $userdata['user_cell_time'] > 0 && !defined('CELL') && $userdata['session_logged_in'] && $userdata['user_level'] != ADMIN && $userdata['user_cell_punishment'] == 1 ) 
{
	redirect(append_sid("adr_cell.$phpEx", true));
}