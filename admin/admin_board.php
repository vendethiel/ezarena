<?php
//-- mod : pm threshold ----------------------------------------------------------------------------
/***************************************************************************
 *                              admin_board.php
 *                            -------------------
 *   begin                : Thursday, Jul 12, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: admin_board.php,v 1.51.2.15 2006/02/10 22:19:01 grahamje Exp $
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Configuration'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'includes/functions_selects.'.$phpEx);
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_merge.' . $phpEx);

//
// Pull all config data
//
$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_board", "", __LINE__, __FILE__, $sql);
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

//+MOD: Search latest 24h 48h 72h
		if ($config_name == 'search_latest_hours' && isset($HTTP_POST_VARS['submit']))
		{
			$temp = explode(',', $new['search_latest_hours']);
			sort($temp);
			for( $num = 0; $num < count($temp); $num++ )
			{
				if( ($temp[$num] = intval($temp[$num])) <= 0 )
				{
					message_die(GENERAL_ERROR, $lang['Search_latest_hours_error']);
				}
			}
			$new['search_latest_hours'] = implode(',', $temp);
			unset($temp, $num);
		}
//-MOD: Search latest 24h 48h 72h		
		if ($config_name == 'cookie_name')
		{
			$new['cookie_name'] = str_replace('.', '_', $new['cookie_name']);
		}

		// Attempt to prevent a common mistake with this value,
		// http:// is the protocol and not part of the server name
		if ($config_name == 'server_name')
		{
			$new['server_name'] = str_replace('http://', '', $new['server_name']);
		}
		// Attempt to prevent a mistake with this value.
		if ($config_name == 'avatar_path')
		{
			$new['avatar_path'] = trim($new['avatar_path']);
			if (strstr($new['avatar_path'], "\0") || !is_dir($phpbb_root_path . $new['avatar_path']) || !is_writable($phpbb_root_path . $new['avatar_path']))
			{
				$new['avatar_path'] = $default_config['avatar_path'];
			}
		}		

		if( isset($HTTP_POST_VARS['submit']) )
		{
			if ($config_name == 'board_disable_mode' && is_array($new['board_disable_mode']))
			{
				$new[$config_name] = implode(',', $new[$config_name]);
			}		
			$sql = "UPDATE " . CONFIG_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update general configuration for $config_name", "", __LINE__, __FILE__, $sql);
			}
		}
	}

	if( isset($HTTP_POST_VARS['submit']) )
	{
		$message = $lang['Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_config'], "<a href=\"" . append_sid("admin_board.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
}

$style_select = style_select($new['default_style'], 'default_style', "../templates");
$lang_select = language_select($new['default_lang'], 'default_lang', "language");
$timezone_select = tz_select($new['board_timezone'], 'board_timezone');
$ty_use_rel_date_yes = ( $new['ty_use_rel_date'] ) ? "checked=\"checked\"" : ""; 
$ty_use_rel_date_no  = (!$new['ty_use_rel_date'] ) ? "checked=\"checked\"" : ""; 
$ty_use_rel_time_yes = ( $new['ty_use_rel_time'] ) ? "checked=\"checked\"" : ""; 
$ty_use_rel_time_no  = (!$new['ty_use_rel_time'] ) ? "checked=\"checked\"" : "";

// Begin Account Self-Delete MOD
$account_delete_yes = ( $new['account_delete'] ) ? "checked=\"checked\"" : "";
$account_delete_no = ( !$new['account_delete'] ) ? "checked=\"checked\"" : "";
// End Account Self-Delete MOD
$default_avatar_guests = ( $new['default_avatar_type'] == DEFAULT_AVATAR_GUESTS ) ? "checked=\"checked\"" : "";
$default_avatar_users = ( $new['default_avatar_type'] == DEFAULT_AVATAR_USERS ) ? "checked=\"checked\"" : "";
$default_avatar_both = ( $new['default_avatar_type'] == DEFAULT_AVATAR_BOTH ) ? "checked=\"checked\"" : "";
$default_avatar_yes = ( $new['default_avatar'] ) ? "checked=\"checked\"" : "";
$default_avatar_no = ( !$new['default_avatar'] ) ? "checked=\"checked\"" : "";
$default_avatar_choose_yes = ( $new['default_avatar_choose'] ) ? "checked=\"checked\"" : "";
$default_avatar_choose_no = ( !$new['default_avatar_choose'] ) ? "checked=\"checked\"" : "";
$default_avatar_random_yes = ( $new['default_avatar_random'] ) ? "checked=\"checked\"" : "";
$default_avatar_random_no = ( !$new['default_avatar_random'] ) ? "checked=\"checked\"" : "";
$default_avatar_override_yes = ( $new['default_avatar_override'] ) ? "checked=\"checked\"" : "";
$default_avatar_override_no = ( !$new['default_avatar_override'] ) ? "checked=\"checked\"" : "";

$cookie_secure_yes = ( $new['cookie_secure'] ) ? "checked=\"checked\"" : "";
$cookie_secure_no = ( !$new['cookie_secure'] ) ? "checked=\"checked\"" : "";

$html_tags = $new['allow_html_tags'];

//+MOD: Search latest 24h 48h 72h
$search_latest_results_posts = ( $new['search_latest_results'] == 'posts' ) ? ' checked="checked"' : '';
$search_latest_results_topics = ( $new['search_latest_results'] != 'posts' ) ? ' checked="checked"' : '';
//-MOD: Search latest 24h 48h 72h

$override_user_style_yes = ( $new['override_user_style'] ) ? "checked=\"checked\"" : "";
$override_user_style_no = ( !$new['override_user_style'] ) ? "checked=\"checked\"" : "";

$html_yes = ( $new['allow_html'] ) ? "checked=\"checked\"" : "";
$html_no = ( !$new['allow_html'] ) ? "checked=\"checked\"" : "";

$bbcode_yes = ( $new['allow_bbcode'] ) ? "checked=\"checked\"" : "";
$bbcode_no = ( !$new['allow_bbcode'] ) ? "checked=\"checked\"" : "";

$activation_none = ( $new['require_activation'] == USER_ACTIVATION_NONE ) ? "checked=\"checked\"" : "";
$activation_user = ( $new['require_activation'] == USER_ACTIVATION_SELF ) ? "checked=\"checked\"" : "";
$activation_admin = ( $new['require_activation'] == USER_ACTIVATION_ADMIN ) ? "checked=\"checked\"" : "";

$confirm_yes = ($new['enable_confirm']) ? 'checked="checked"' : '';
$confirm_no = (!$new['enable_confirm']) ? 'checked="checked"' : '';

//Ajout confirmation �crite
$question_conf_yes = ($new['question_conf_enable']) ? 'checked="checked"' : '';
$question_conf_no = (!$new['question_conf_enable']) ? 'checked="checked"' : '';
//Fin confirmation �crite

$allow_autologin_yes = ($new['allow_autologin']) ? 'checked="checked"' : '';
$allow_autologin_no = (!$new['allow_autologin']) ? 'checked="checked"' : '';

$board_email_form_yes = ( $new['board_email_form'] ) ? "checked=\"checked\"" : "";
$board_email_form_no = ( !$new['board_email_form'] ) ? "checked=\"checked\"" : "";

$gzip_yes = ( $new['gzip_compress'] ) ? "checked=\"checked\"" : "";
$gzip_no = ( !$new['gzip_compress'] ) ? "checked=\"checked\"" : "";

$privmsg_on = ( !$new['privmsg_disable'] ) ? "checked=\"checked\"" : "";
$privmsg_off = ( $new['privmsg_disable'] ) ? "checked=\"checked\"" : "";

$prune_yes = ( $new['prune_enable'] ) ? "checked=\"checked\"" : "";
$prune_no = ( !$new['prune_enable'] ) ? "checked=\"checked\"" : "";

$smile_yes = ( $new['allow_smilies'] ) ? "checked=\"checked\"" : "";
$smile_no = ( !$new['allow_smilies'] ) ? "checked=\"checked\"" : "";

$sig_yes = ( $new['allow_sig'] ) ? "checked=\"checked\"" : "";
$sig_no = ( !$new['allow_sig'] ) ? "checked=\"checked\"" : "";

$namechange_yes = ( $new['allow_namechange'] ) ? "checked=\"checked\"" : "";
$namechange_no = ( !$new['allow_namechange'] ) ? "checked=\"checked\"" : "";

$allow_colortext_yes = ( $new['allow_colortext'] ) ? "checked=\"checked\"" : ""; 
$allow_colortext_no = ( !$new['allow_colortext'] ) ? "checked=\"checked\"" : "";

$avatars_local_yes = ( $new['allow_avatar_local'] ) ? "checked=\"checked\"" : "";
$avatars_local_no = ( !$new['allow_avatar_local'] ) ? "checked=\"checked\"" : "";
$avatars_remote_yes = ( $new['allow_avatar_remote'] ) ? "checked=\"checked\"" : "";
$avatars_remote_no = ( !$new['allow_avatar_remote'] ) ? "checked=\"checked\"" : "";
$avatars_upload_yes = ( $new['allow_avatar_upload'] ) ? "checked=\"checked\"" : "";
$avatars_upload_no = ( !$new['allow_avatar_upload'] ) ? "checked=\"checked\"" : "";

$smtp_yes = ( $new['smtp_delivery'] ) ? "checked=\"checked\"" : "";
$smtp_no = ( !$new['smtp_delivery'] ) ? "checked=\"checked\"" : "";

// Start add - Gender Mod
$gender_required_yes = ( $new['gender_required'] ) ? ' checked="checked"' : '';
$gender_required_no = ( !$new['gender_required'] ) ? ' checked="checked"' : '';
// End add - Gender Mod

// Toggle ACP Login
$admin_login_yes = ( $new['admin_login'] ) ? "checked=\"checked\"" : "";
$admin_login_no = ( !$new['admin_login'] ) ? "checked=\"checked\"" : "";

$board_disable_mode_select = disable_mode_select($new['board_disable_mode']);
$board_disable_yes = ($new['board_disable']) ? ' checked="checked"' : '';
$board_disable_no = (!$new['board_disable']) ? ' checked="checked"' : '';
$template->set_filenames(array(
	"body" => "admin/board_config_body.tpl")
);
//-- mod : birthday ------------------------------------------------------------
//-- add
$bday_fields = array(
	'bday_show' => $new['bday_show'],
	'bday_wishes' => $new['bday_wishes'],	
	'bday_require' => $new['bday_require'],
	'bday_lock' => $new['bday_lock'],
	'bday_lookahead' => $new['bday_lookahead'],
	'bday_min' => $new['bday_min'],
	'bday_max' => $new['bday_max'],
	'bday_zodiac' => $new['bday_zodiac'],
);
$birthday->display_config($bday_fields);
//-- fin mod : birthday --------------------------------------------------------

//report forum selection
$sql = "SELECT f.forum_name, f.forum_id
	FROM " . FORUMS_TABLE . " f, " . CATEGORIES_TABLE . " c
	WHERE c.cat_id = f.cat_id ORDER BY c.cat_order ASC, f.forum_order ASC";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Couldn't obtain forum list", "", __LINE__, __FILE__, $sql);
}
$report_forum_rows = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);
$report_forum_select_list = '<select name="report_forum">';
$report_forum_select_list .= '<option value="0">' . $lang['None'] . '</option>';
for($i = 0; $i < count($report_forum_rows); $i++)
{
	$report_forum_select_list .= '<option value="' . $report_forum_rows[$i]['forum_id'] . '">' . $report_forum_rows[$i]['forum_name'] . '</option>';
}
$report_forum_select_list .= '</select>';
$report_forum_select_list = str_replace("value=\"".$new['report_forum']."\">", "value=\"".$new['report_forum']."\" SELECTED>*" ,$report_forum_select_list);

//
// Escape any quotes in the site description for proper display in the text
// box on the admin page 
//
$new['site_desc'] = str_replace('"', '&quot;', $new['site_desc']);
$new['sitename'] = str_replace('"', '&quot;', strip_tags($new['sitename']));
$template->assign_vars(array(
//-- mod : pm threshold ----------------------------------------------------------------------------
//-- add
	'L_PM_ALLOW_THRESHOLD' => $lang['pm_allow_threshold'],
	'L_PM_ALLOW_TRHESHOLD_EXPLAIN' => $lang['pm_allow_threshold_explain'],
	'PM_ALLOW_THRESHOLD' => $new['pm_allow_threshold'],
//-- fin mod : pm threshold ------------------------------------------------------------------------
	"S_CONFIG_ACTION" => append_sid("admin_board.$phpEx"),

	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	"L_CONFIGURATION_TITLE" => $lang['General_Config'],
	"L_CONFIGURATION_EXPLAIN" => $lang['Config_explain'],
	"L_GENERAL_SETTINGS" => $lang['General_settings'],
	"L_SERVER_NAME" => $lang['Server_name'], 
	"L_SERVER_NAME_EXPLAIN" => $lang['Server_name_explain'], 
	"L_SERVER_PORT" => $lang['Server_port'], 
	"L_SERVER_PORT_EXPLAIN" => $lang['Server_port_explain'], 
	"L_SCRIPT_PATH" => $lang['Script_path'], 
	"L_SCRIPT_PATH_EXPLAIN" => $lang['Script_path_explain'], 
	"L_SITE_NAME" => $lang['Site_name'],
	"L_SITE_DESCRIPTION" => $lang['Site_desc'],
  // Begin Account Self-Delete MOD
  "L_ACCOUNT_DELETE" => $lang['account_delete'],
  // End Account Self-Delete MOD	
	"L_ACCT_ACTIVATION" => $lang['Acct_activation'],
	//Ajout confirmation �crite
	"L_ACTIVE_QUESTION_CONF_ECRITE" => $lang['Active_question_conf_ecrite'],
	"L_QUESTION_CONF_ECRITE" => $lang['Question_conf_ecrite'],
	"L_REPONSE_CONF_ECRITE" => $lang['Reponse_conf_write'],
	//Fin confirmation �crite	
	"L_NONE" => $lang['Acc_None'], 
	"L_USER" => $lang['Acc_User'], 
	"L_ADMIN" => $lang['Acc_Admin'], 
	"L_VISUAL_CONFIRM" => $lang['Visual_confirm'], 
	"L_VISUAL_CONFIRM_EXPLAIN" => $lang['Visual_confirm_explain'], 
	"L_ALLOW_AUTOLOGIN" => $lang['Allow_autologin'],
	"L_ALLOW_AUTOLOGIN_EXPLAIN" => $lang['Allow_autologin_explain'],
	"L_AUTOLOGIN_TIME" => $lang['Autologin_time'],
	"L_AUTOLOGIN_TIME_EXPLAIN" => $lang['Autologin_time_explain'],
	"L_COOKIE_SETTINGS" => $lang['Cookie_settings'], 
	"L_COOKIE_SETTINGS_EXPLAIN" => $lang['Cookie_settings_explain'], 
	"L_COOKIE_DOMAIN" => $lang['Cookie_domain'],
	"L_COOKIE_NAME" => $lang['Cookie_name'], 
	"L_COOKIE_PATH" => $lang['Cookie_path'], 
	"L_COOKIE_SECURE" => $lang['Cookie_secure'], 
	"L_COOKIE_SECURE_EXPLAIN" => $lang['Cookie_secure_explain'], 
	"L_SESSION_LENGTH" => $lang['Session_length'], 
	"L_PRIVATE_MESSAGING" => $lang['Private_Messaging'], 
	"L_INBOX_LIMIT" => $lang['Inbox_limits'], 
	"L_SENTBOX_LIMIT" => $lang['Sentbox_limits'], 
	"L_SAVEBOX_LIMIT" => $lang['Savebox_limits'], 
	"L_DISABLE_PRIVATE_MESSAGING" => $lang['Disable_privmsg'], 
	"L_ENABLED" => $lang['Enabled'], 
	"L_DISABLED" => $lang['Disabled'], 
	"L_ABILITIES_SETTINGS" => $lang['Abilities_settings'],
	"L_MAX_POLL_OPTIONS" => $lang['Max_poll_options'],
	"L_FLOOD_INTERVAL" => $lang['Flood_Interval'],
	"L_FLOOD_INTERVAL_EXPLAIN" => $lang['Flood_Interval_explain'], 
	"L_SEARCH_FLOOD_INTERVAL" => $lang['Search_Flood_Interval'],
	"L_SEARCH_FLOOD_INTERVAL_EXPLAIN" => $lang['Search_Flood_Interval_explain'], 

	'L_MAX_LOGIN_ATTEMPTS'			=> $lang['Max_login_attempts'],
	'L_MAX_LOGIN_ATTEMPTS_EXPLAIN'	=> $lang['Max_login_attempts_explain'],
	'L_LOGIN_RESET_TIME'			=> $lang['Login_reset_time'],
	'L_LOGIN_RESET_TIME_EXPLAIN'	=> $lang['Login_reset_time_explain'],
	'MAX_LOGIN_ATTEMPTS'			=> $new['max_login_attempts'],
	'LOGIN_RESET_TIME'				=> $new['login_reset_time'],

	"L_BOARD_EMAIL_FORM" => $lang['Board_email_form'], 
	"L_BOARD_EMAIL_FORM_EXPLAIN" => $lang['Board_email_form_explain'],
//+MOD: Search latest 24h 48h 72h
	'L_SEARCH_LATEST_HOURS' => $lang['Search_latest_hours'],
	'L_SEARCH_LATEST_HOURS_EXPLAIN' => $lang['Search_latest_hours_explain'],
	'L_SEARCH_LATEST_RESULTS' => $lang['Search_latest_results'],
	'L_SEARCH_LATEST_RESULTS_EXPLAIN' => $lang['Search_latest_results_explain'],
	'L_TOPICS' => $lang['Topics'],
	'L_POSTS' => $lang['Posts'],
//-MOD: Search latest 24h 48h 72h	
	"L_TOPICS_PER_PAGE" => $lang['Topics_per_page'],
	"L_POSTS_PER_PAGE" => $lang['Posts_per_page'],
	"L_HOT_THRESHOLD" => $lang['Hot_threshold'],
	"L_DEFAULT_STYLE" => $lang['Default_style'],
	"L_OVERRIDE_STYLE" => $lang['Override_style'],
	"L_OVERRIDE_STYLE_EXPLAIN" => $lang['Override_style_explain'],
	"L_DEFAULT_LANGUAGE" => $lang['Default_language'],
	"L_DATE_FORMAT" => $lang['Date_format'],
	"L_SYSTEM_TIMEZONE" => $lang['System_timezone'],
	"L_ENABLE_GZIP" => $lang['Enable_gzip'],
	"L_ENABLE_PRUNE" => $lang['Enable_prune'],
   "L_MAX_URL_LENGTH" => $lang['Max_url_length'],//Autoshorten URL MOD v1.0.4 	
// Start add - Fully integrated shoutbox MOD
'L_PRUNE_SHOUTS' => $lang['Prune_shouts'], 
'L_PRUNE_SHOUTS_EXPLAIN' => $lang['Prune_shouts_explain'], 
// End add - Fully integrated shoutbox MOD	
	"L_TOPICS_ON_INDEX" => $lang['Topics_on_index'],
	'L_BLUECARD_LIMIT' => $lang['Bluecard_limit'], 
	'L_BLUECARD_LIMIT_EXPLAIN' => $lang['Bluecard_limit_explain'], 
	'L_BLUECARD_LIMIT_2' => $lang['Bluecard_limit_2'], 
	'L_BLUECARD_LIMIT_2_EXPLAIN' => $lang['Bluecard_limit_2_explain'], 
	'L_MAX_USER_BANCARD' => $lang['Max_user_bancard'], 
	'L_MAX_USER_BANCARD_EXPLAIN' => $lang['Max_user_bancard_explain'], 
	'L_REPORT_FORUM' => $lang['Report_forum'],
	'L_REPORT_FORUM_EXPLAIN' => $lang['Report_forum_explain'],
	"L_ALLOW_HTML" => $lang['Allow_HTML'],
	"L_ALLOW_BBCODE" => $lang['Allow_BBCode'],
	"L_ALLOWED_TAGS" => $lang['Allowed_tags'],
	"L_ALLOWED_TAGS_EXPLAIN" => $lang['Allowed_tags_explain'],
	"L_ALLOW_SMILIES" => $lang['Allow_smilies'],
	"L_SMILIES_PATH" => $lang['Smilies_path'],
	"L_SMILIES_PATH_EXPLAIN" => $lang['Smilies_path_explain'],
	"L_ALLOW_SIG" => $lang['Allow_sig'],
	"L_MAX_SIG_LENGTH" => $lang['Max_sig_length'],
	"L_MAX_SIG_LENGTH_EXPLAIN" => $lang['Max_sig_length_explain'],
	"L_ALLOW_NAME_CHANGE" => $lang['Allow_name_change'],
	"L_ALLOW_COLORTEXT" => $lang['Allow_colortext'],	
	"L_AVATAR_SETTINGS" => $lang['Avatar_settings'],
	"L_ALLOW_LOCAL" => $lang['Allow_local'],
	"L_ALLOW_REMOTE" => $lang['Allow_remote'],
	"L_ALLOW_REMOTE_EXPLAIN" => $lang['Allow_remote_explain'],
	"L_ALLOW_UPLOAD" => $lang['Allow_upload'],
	"L_MAX_FILESIZE" => $lang['Max_filesize'],
	"L_MAX_FILESIZE_EXPLAIN" => $lang['Max_filesize_explain'],
	"L_MAX_AVATAR_SIZE" => $lang['Max_avatar_size'],
	"L_MAX_AVATAR_SIZE_EXPLAIN" => $lang['Max_avatar_size_explain'],
	"L_AVATAR_STORAGE_PATH" => $lang['Avatar_storage_path'],
	"L_AVATAR_STORAGE_PATH_EXPLAIN" => $lang['Avatar_storage_path_explain'],
	"L_AVATAR_GALLERY_PATH" => $lang['Avatar_gallery_path'],
	"L_AVATAR_GALLERY_PATH_EXPLAIN" => $lang['Avatar_gallery_path_explain'],
	"L_FORUM_ICON_PATH" => $lang['Forum_icon_path'], // Forum Icon MOD
	"L_FORUM_ICON_PATH_EXPLAIN" => $lang['Forum_icon_path_explain'], // Forum Icon MOD	
	"L_COPPA_SETTINGS" => $lang['COPPA_settings'],
	"L_COPPA_FAX" => $lang['COPPA_fax'],
	"L_COPPA_MAIL" => $lang['COPPA_mail'],
	"L_COPPA_MAIL_EXPLAIN" => $lang['COPPA_mail_explain'],
	"L_EMAIL_SETTINGS" => $lang['Email_settings'],
	"L_ADMIN_EMAIL" => $lang['Admin_email'],
	"L_EMAIL_SIG" => $lang['Email_sig'],
	"L_EMAIL_SIG_EXPLAIN" => $lang['Email_sig_explain'],
	"L_USE_SMTP" => $lang['Use_SMTP'],
	"L_USE_SMTP_EXPLAIN" => $lang['Use_SMTP_explain'],
	"L_SMTP_SERVER" => $lang['SMTP_server'], 
	"L_SMTP_USERNAME" => $lang['SMTP_username'], 
	"L_SMTP_USERNAME_EXPLAIN" => $lang['SMTP_username_explain'], 
	"L_SMTP_PASSWORD" => $lang['SMTP_password'], 
	"L_SMTP_PASSWORD_EXPLAIN" => $lang['SMTP_password_explain'],
	// Toggle ACP Login
	"L_ADMIN_LOGIN" => $lang['admin_login'],
	"L_ADMIN_LOGIN_EXPLAIN" => $lang['admin_login_explain'],	
	"L_SUBMIT" => $lang['Submit'], 
	"L_RESET" => $lang['Reset'],
//-- mod : presentation required -----------------------------------------------
//-- add
	'L_PRESENTATION_REQUIRED' => $lang['Presentation_Required'],
	'L_PRESENTATION_FORUM' => $lang['Presentation_Forum'],
	'PRESENTATION_REQUIRED_YES' => $new['presentation_required'] ? 'checked="checked"' : '',
	'PRESENTATION_REQUIRED_NO' => !$new['presentation_required'] ? 'checked="checked"' : '', 
	'PRESENTATION_FORUM_COMBO' => forum_combo('presentation_forum'),
//-- fin mod : presentation required -------------------------------------------	
// Default Avatar MOD, By Manipe (Begin)
	"L_DEFAULT_AVATAR_SETTINGS" => $lang['Default_avatar_settings'],
	"L_DEFAULT_AVATAR_SETTINGS_EXPLAIN" => $lang['Default_avatar_settings_explain'],
	"L_DEFAULT_AVATAR_USE" => $lang['Default_avatar_use'],
	"L_DEFAULT_AVATAR_RANDOM" => $lang['Default_avatar_random'],
	"L_DEFAULT_AVATAR_RANDOM_EXPLAIN" => $lang['Default_avatar_random_explain'],
	"L_DEFAULT_AVATAR_TYPE" => $lang['Default_avatar_type'],
	"L_DEFAULT_AVATAR_USERS" => $lang['Default_avatar_users'],
	"L_DEFAULT_AVATAR_GUESTS" => $lang['Default_avatar_guests'],
	"L_DEFAULT_AVATAR_BOTH" => $lang['Default_avatar_both'],
	"L_DEFAULT_AVATAR_USERS_SET" => $lang['Default_avatar_users_set'],
	"L_DEFAULT_AVATAR_USERS_EXPLAIN" => $lang['Default_avatar_users_explain'],
	"L_DEFAULT_AVATAR_GUESTS_SET" => $lang['Default_avatar_guests_set'],
	"L_DEFAULT_AVATAR_GUESTS_EXPLAIN" => $lang['Default_avatar_guests_explain'],
	"L_DEFAULT_AVATAR_CHOOSE" => $lang['Default_avatar_choose'],
	"L_DEFAULT_AVATAR_CHOOSE_EXPLAIN" => $lang['Default_avatar_choose_explain'],
	"L_DEFAULT_AVATAR_OVERRIDE" => $lang['Default_avatar_override'],
	"L_DEFAULT_AVATAR_OVERRIDE_EXPLAIN" => $lang['Default_avatar_override_explain'],

	"DEFAULT_AVATAR_YES" => $default_avatar_yes,
	"DEFAULT_AVATAR_NO" => $default_avatar_no,
	"DEFAULT_AVATAR_RANDOM_YES" => $default_avatar_random_yes,
	"DEFAULT_AVATAR_RANDOM_NO" => $default_avatar_random_no,
	"DEFAULT_AVATAR_USERS" => DEFAULT_AVATAR_USERS,
	"DEFAULT_AVATAR_GUESTS" => DEFAULT_AVATAR_GUESTS,
	"DEFAULT_AVATAR_BOTH" => DEFAULT_AVATAR_BOTH,
	"DEFAULT_AVATAR_USERS_YES" => $default_avatar_users,
	"DEFAULT_AVATAR_GUESTS_YES" => $default_avatar_guests,
	"DEFAULT_AVATAR_BOTH_YES" => $default_avatar_both,
	"DEFAULT_AVATAR_USERS_URL" => $new['default_avatar_users'],
	"DEFAULT_AVATAR_GUESTS_URL" => $new['default_avatar_guests'],
	"DEFAULT_AVATAR_CHOOSE_YES" => $default_avatar_choose_yes,
	"DEFAULT_AVATAR_CHOOSE_NO" => $default_avatar_choose_no,
	"DEFAULT_AVATAR_OVERRIDE_YES" => $default_avatar_override_yes,
	"DEFAULT_AVATAR_OVERRIDE_NO" => $default_avatar_override_no,
// Default Avatar MOD, By Manipe (End)	
   // Start add - Gender Mod
   "L_GENDER_REQUIRED" => $lang['Gender_required'],
   "GENDER_REQUIRED_YES" => $gender_required_yes,
   "GENDER_REQUIRED_NO" => $gender_required_no,
   // End add - Gender Mod	
	
// DEBUT MOD Logo al�atoire 
	"L_INTERVALLE_LOGOS" => $lang['LoAl_Intervalle_logos'], 
	"L_INTERVALLE_LOGOS_EXPLAIN" => $lang['LoAl_Intervalle_logos_explain'], 
// FIN MOD Logo al�atoire	

	"L_TIME_TO_MERGE" => $lang['Merge_time_limit'],
	"L_TIME_TO_MERGE_EXPLAIN" => $lang['Merge_time_limit_explain'],
	"L_MERGE_FLOOD_INTERVAL" => $lang['Merge_flood_interval'],
	"L_MERGE_FLOOD_INTERVAL_EXPLAIN" => $lang['Merge_flood_interval_explain'],
	"SERVER_NAME" => $new['server_name'], 
	"SCRIPT_PATH" => $new['script_path'], 
	"SERVER_PORT" => $new['server_port'], 
	"SITENAME" => $new['sitename'],
	"SITE_DESCRIPTION" => $new['site_desc'],
	// Begin Account Self-Delete MOD  
	"S_ACCOUNT_DELETE_YES" => $account_delete_yes,
	"S_ACCOUNT_DELETE_NO" => $account_delete_no, 
	// End Account Self-Delete MOD
	"ACTIVATION_NONE" => USER_ACTIVATION_NONE, 
	"ACTIVATION_NONE_CHECKED" => $activation_none,
	"ACTIVATION_USER" => USER_ACTIVATION_SELF, 
	"ACTIVATION_USER_CHECKED" => $activation_user,
	"ACTIVATION_ADMIN" => USER_ACTIVATION_ADMIN, 
	"ACTIVATION_ADMIN_CHECKED" => $activation_admin, 
	"CONFIRM_ENABLE" => $confirm_yes,
	"CONFIRM_DISABLE" => $confirm_no,
	//Ajout confirmation �crite
	"QUESTION_CONF_YES" => $question_conf_yes,
	"QUESTION_CONF_NO" => $question_conf_no,
	"QUESTION_CONF" => $new['question_conf'],
	"REPONSE_CONF" => $new['reponse_conf'],
	//Fin confirmation �crite
	'ALLOW_AUTOLOGIN_YES' => $allow_autologin_yes,
	'ALLOW_AUTOLOGIN_NO' => $allow_autologin_no,
	'AUTOLOGIN_TIME' => (int) $new['max_autologin_time'],
	"BOARD_EMAIL_FORM_ENABLE" => $board_email_form_yes, 
	"BOARD_EMAIL_FORM_DISABLE" => $board_email_form_no, 
	"MAX_POLL_OPTIONS" => $new['max_poll_options'], 
	"FLOOD_INTERVAL" => $new['flood_interval'],
	"SEARCH_FLOOD_INTERVAL" => $new['search_flood_interval'],
//+MOD: Search latest 24h 48h 72h
	'SEARCH_LATEST_HOURS' => $new['search_latest_hours'],
	'SEARCH_LATEST_RESULTS_POSTS' => $search_latest_results_posts,
	'SEARCH_LATEST_RESULTS_TOPICS' => $search_latest_results_topics,
//-MOD: Search latest 24h 48h 72h	
	"TOPICS_PER_PAGE" => $new['topics_per_page'],
	"POSTS_PER_PAGE" => $new['posts_per_page'],
	"HOT_TOPIC" => $new['hot_threshold'],
//-- mod : post description ----------------------------------------------------
//-- add
	'L_SUB_TITLE_LENGTH' => $lang['Sub_title_length'],
	'L_SUB_TITLE_LENGTH_EXPLAIN' => $lang['Sub_title_length_explain'],
	'SUB_TITLE_LENGTH' => $new['sub_title_length'],
//-- fin mod : post description ------------------------------------------------	
	"STYLE_SELECT" => $style_select,
	"OVERRIDE_STYLE_YES" => $override_user_style_yes,
	"OVERRIDE_STYLE_NO" => $override_user_style_no,
	"LANG_SELECT" => $lang_select,
	"L_DATE_FORMAT_EXPLAIN" => $lang['Date_format_explain'],
	"DEFAULT_DATEFORMAT" => $new['default_dateformat'],
	"TIMEZONE_SELECT" => $timezone_select,
	"L_USE_REL_DATE" => $lang['Use_rel_date'],		
	"L_USE_REL_DATE_EXPLAIN" => $lang['Use_rel_date_explain'],		
	"L_USE_REL_TIME" => $lang['Use_rel_time'],		
	"L_USE_REL_TIME_EXPLAIN" => $lang['Use_rel_time_explain'],
	"L_LASTPOST_CUTOFF" => $lang['Lastpost_cutoff'],
	"L_LASTPOST_APPEND" => $lang['Lastpost_append'], 
	"L_LASTPOST_CUTOFF_EXPLAIN"=>$new['Lastpost_cutoff_explain'],
	"L_LASTPOST_APPEND_EXPLAIN"=>$new['Lastpost_append_explain'],
	"USE_REL_DATE_YES" => $ty_use_rel_date_yes, 
	"USE_REL_DATE_NO" => $ty_use_rel_date_no, 	
	"USE_REL_TIME_YES" => $ty_use_rel_time_yes, 
	"USE_REL_TIME_NO" => $ty_use_rel_time_no,
	"LASTPOST_CUTOFF"=>$new['ty_lastpost_cutoff'],
	"LASTPOST_APPEND"=>$new['ty_lastpost_append'],	
	"S_PRIVMSG_ENABLED" => $privmsg_on, 
	"S_PRIVMSG_DISABLED" => $privmsg_off, 
	"INBOX_LIMIT" => $new['max_inbox_privmsgs'], 
	"SENTBOX_LIMIT" => $new['max_sentbox_privmsgs'],
	"SAVEBOX_LIMIT" => $new['max_savebox_privmsgs'],
	"COOKIE_DOMAIN" => $new['cookie_domain'], 
	"COOKIE_NAME" => $new['cookie_name'], 
	"COOKIE_PATH" => $new['cookie_path'], 
	"SESSION_LENGTH" => $new['session_length'], 
	"S_COOKIE_SECURE_ENABLED" => $cookie_secure_yes, 
	"S_COOKIE_SECURE_DISABLED" => $cookie_secure_no, 
	"GZIP_YES" => $gzip_yes,
	"GZIP_NO" => $gzip_no,
	"PRUNE_YES" => $prune_yes,
	"PRUNE_NO" => $prune_no,
   "MAX_URL_LENGTH" => $new['max_url_length'],//Autoshorten URL MOD v1.0.4 	
// Start add - Fully integrated shoutbox MOD
'PRUNE_SHOUTS' => $new['prune_shouts'], 
// End add - Fully integrated shoutbox MOD	
	"TOPICS_ON_INDEX" => $new['topics_on_index'],
	'BLUECARD_LIMIT' => $new['bluecard_limit'], 
	'BLUECARD_LIMIT_2' => $new['bluecard_limit_2'], 
	'MAX_USER_BANCARD' => $new['max_user_bancard'], 
	'S_REPORT_FORUM' => $report_forum_select_list,
	"HTML_TAGS" => $html_tags, 
	"HTML_YES" => $html_yes,
	"HTML_NO" => $html_no,
	"BBCODE_YES" => $bbcode_yes,
	"BBCODE_NO" => $bbcode_no,
	"SMILE_YES" => $smile_yes,
	"SMILE_NO" => $smile_no,
	"SIG_YES" => $sig_yes,
	"SIG_NO" => $sig_no,
	"SIG_SIZE" => $new['max_sig_chars'], 
	"NAMECHANGE_YES" => $namechange_yes,
	"NAMECHANGE_NO" => $namechange_no,
	"ALLOW_COLORTEXT_YES" => $allow_colortext_yes, 
	"ALLOW_COLORTEXT_NO" => $allow_colortext_no,	
	"AVATARS_LOCAL_YES" => $avatars_local_yes,
	"AVATARS_LOCAL_NO" => $avatars_local_no,
	"AVATARS_REMOTE_YES" => $avatars_remote_yes,
	"AVATARS_REMOTE_NO" => $avatars_remote_no,
	"AVATARS_UPLOAD_YES" => $avatars_upload_yes,
	"AVATARS_UPLOAD_NO" => $avatars_upload_no,
	"AVATAR_FILESIZE" => $new['avatar_filesize'],
	"AVATAR_MAX_HEIGHT" => $new['avatar_max_height'],
	"AVATAR_MAX_WIDTH" => $new['avatar_max_width'],
	"AVATAR_PATH" => $new['avatar_path'], 
	"AVATAR_GALLERY_PATH" => $new['avatar_gallery_path'],
	"FORUM_ICON_PATH" => $new['forum_icon_path'], // Forum Icon MOD	
	"SMILIES_PATH" => $new['smilies_path'],
//-- mod : flags ---------------------------------------------------------------
//-- add
	'L_FLAGS_PATH' => $lang['flags_path'],
	'L_FLAGS_PATH_EXPLAIN' => $lang['flags_path_explain'],

	'FLAGS_PATH' => $new['flags_path'],
//-- fin mod : flags -----------------------------------------------------------	
	"INBOX_PRIVMSGS" => $new['max_inbox_privmsgs'], 
	"SENTBOX_PRIVMSGS" => $new['max_sentbox_privmsgs'], 
	"SAVEBOX_PRIVMSGS" => $new['max_savebox_privmsgs'], 
	"EMAIL_FROM" => $new['board_email'],
	"EMAIL_SIG" => $new['board_email_sig'],
	"SMTP_YES" => $smtp_yes,
	"SMTP_NO" => $smtp_no,
	"SMTP_HOST" => $new['smtp_host'],
	"SMTP_USERNAME" => $new['smtp_username'],
	"SMTP_PASSWORD" => $new['smtp_password'],
	// Toggle ACP Login
	"ADMIN_LOGIN_YES" => $admin_login_yes,
	"ADMIN_LOGIN_NO" => $admin_login_no,	
	"COPPA_MAIL" => $new['coppa_mail'],
// DEBUT MOD Logo al�atoire 
	"INTERVALLE_LOGOS" => $new['LoAl_Intervalle_logos'], 
// FIN MOD Logo al�atoire	
	"COPPA_FAX" => $new['coppa_fax'],

// Addon Disable Rewriting for SEO
	'L_DISABLE_REWRITE' => $lang['Disable_rewrite'],
	'L_DISABLE_REWRITE_EXPLAIN' => $lang['Disable_rewrite_explain'],
	'DISABLE_REWRITE_YES' => $new['Disable_rewrite'] ? 'checked="checked"' : '',
	'DISABLE_REWRITE_NO' => !$new['Disable_rewrite'] ? 'checked="checked"' : '', 

	'L_BOARD_DISABLE' => $lang['Board_disable'],
	'L_BOARD_DISABLE_EXPLAIN' => $lang['Board_disable_explain'],
	'BOARD_DISABLE_YES' => $board_disable_yes,
	'BOARD_DISABLE_NO' => $board_disable_no,
	'L_BOARD_DISABLE_MODE' => $lang['Board_disable_mode'],
	'L_BOARD_DISABLE_MODE_EXPLAIN' => $lang['Board_disable_mode_explain'],
	'BOARD_DISABLE_MODE' => $board_disable_mode_select,
	'L_BOARD_DISABLE_MSG' => $lang['Board_disable_msg'],
	'L_BOARD_DISABLE_MSG_EXPLAIN' => $lang['Board_disable_msg_explain'],
	'BOARD_DISABLE_MSG' => htmlspecialchars($new['board_disable_msg']))
);

$template->assign_vars(array(
	"TIME_TO_MERGE" => $new['time_to_merge'],
	"MERGE_FLOOD_INTERVAL" => $new['merge_flood_interval'])
);
$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
