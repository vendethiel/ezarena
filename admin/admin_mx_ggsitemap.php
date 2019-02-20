<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: admin_mx_ggsitemap.php 2007/04/12 13:48:48 dcz Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/
// I know phpBB.com would prefer another methode here, but it's kind of tricky
// to go for the auto extension.inc include before we know where to search for it
// as this code is meant to locate some code.
// I think this method is reliable enough, and since phpBB3 uses it ...
$phpEx = substr(strrchr(__FILE__, '.'), 1);
if ( file_exists( 'admin_board.' . $phpEx ) )
{
	define('IN_PHPBB', 1);
	$admin_root_path1  = 'admin/';
	$admin_root_path2 = '';
	$module_root_path2 = $phpbb_root_path = $mx_root_path = './../';
	require($mx_root_path . 'extension.inc');
	$module_root_path =  './../includes/mx_ggsitemaps/';
	$pathkb = '';
}
else
{
	define('IN_PORTAL', 1);
	$mx_root_path = './../../../';
	$admin_root_path1 = 'admin/';
	$admin_root_path2 = 'modules/mx_ggsitemaps/admin/';
	$module_root_path2 = $module_root_path = './../';

	$pathkb = 'modules/mx_kb/';
}

if( !empty($setmodules) )
{
  $filename = basename(__FILE__);
  $module['General']['GYM_SiteMaps_&_RSS'] = $admin_root_path2.  $filename;

  return;
}

require($mx_root_path . 'admin/pagestart.' . $phpEx);


// Load language files.
if( @file_exists($module_root_path2 . 'language/lang_' . $board_config['default_lang'] . '/lang_ggs_admin.' . $phpEx) ) {
	include_once($module_root_path2 . 'language/lang_' . $board_config['default_lang'] . '/lang_ggs_admin.' . $phpEx);
} else {
	include_once($module_root_path2 . 'language/lang_english/lang_ggs_admin.' . $phpEx);
}
// Define table names.
if (defined('IN_PORTAL'))
{
	$table_prefix =  $mx_table_prefix;
}
define('GGSITEMAP_TABLE', $table_prefix.'ggs_config');

// One small cosmetic check
if (!function_exists('make_clickable')) {
	function make_clickable($text) {
		$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1&#058;", $text);

		// pad it with a space so we can match things at the start of the 1st line.
		$ret = ' ' . $text;
		// matches an "xxxx://yyyy" URL at the start of a line, or after a space.
		// xxxx can only be alpha characters.
		// yyyy is anything up to the first space, newline, comma, double quote or <
		$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
		// matches a "www|ftp.xxxx.yyyy[/zzzz]" kinda lazy URL thing
		// Must contain at least 2 dots. xxxx contains either alphanum, or "-"
		// zzzz is optional.. will contain everything up to the first space, newline, 
		// comma, double quote or <.
		$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);

		// Remove our padding..
		$ret = substr($ret, 1);
		return($ret);
	}
}
// Functionn select_menu
function select_menu($levels = array(), $level_txt = array(), $submit = '', $select = '') {
	$menu = '<select name="' . $submit . '">';
	for( $i = 0; $i < count($levels); $i++ ) {

		$selected = ( $levels[$i] == $select ) ? ' selected="selected"' : '';
		$menu .= '<option value="' . $levels[$i] . '"' . $selected . '>' . $level_txt[$i] . '</option>';
	}
	$menu .= "</select>";
	return $menu;
}

//
// Begin program proper
//

$mode = "";

if( isset($HTTP_POST_VARS['submit']) )
{
	$mode = "submit";
}

// Cahce Management
if( isset($HTTP_POST_VARS['clear_cache']) )
{
	$mode = "clear_cache";
}
$cache_action = ( isset($HTTP_POST_VARS['do_clear_cache']) ) ? intval($HTTP_POST_VARS['do_clear_cache']) : 0;
// Pull all config data
$sql = "SELECT * FROM " . GGSITEMAP_TABLE;
if ( !$result = $db->sql_query( $sql ) )
{
	message_die( CRITICAL_ERROR, "Could not query Google sitemap configuration information ", "", __LINE__, __FILE__, $sql );
}
else
{
	while( $row = $db->sql_fetchrow($result) )
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = isset($HTTP_POST_VARS['submit']) ? str_replace("'", "\'", $config_value) : $config_value;
		
		$new[$config_name] = ( isset($HTTP_POST_VARS[$config_name]) ) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		// Ok let's update config if necessary
		if( $mode == "submit" ) {
			// The dumb guy checks ;-)
			if ( ( $config_name === 'ggs_announce_priority' ) && ( ( $config_value < 0 ) || ( $config_value > 1 ) ) ) {
				$new[$config_name] = '1.0';
			}
			if ( ($config_name === 'ggs_default_priority' ) && ( ( $config_value < 0 ) || ( $config_value > 1 ) ) ) {
				$new[$config_name] = '1.0';
			}
			if ( ($config_name === 'ggs_sticky_priority' ) && ( ( $config_value < 0 ) || ( $config_value > 1 ) ) ) {
				$new[$config_name] = '1.0';
			}
			if ( ($config_name === 'ggs_url_limit' ) && ( ( $config_value < 0 ) || ( $config_value > 50000 ) ) ) {
				$new[$config_name] = 40000;
			}
			if ( ($config_name === 'ggs_sql_limit' ) && ( ( $config_value < 0 ) || ( $config_value > 1000 ) ) ) {
				$new[$config_name] = 200;
			}
			if ( ($config_name === 'rss_sql_limit' ) && ( ( $config_value < 0 ) || ( $config_value > 500 ) ) ) {
				$new[$config_name] = 100;
			}
			if ( ($config_name === 'rss_sql_limit' ) && ( ( $config_value < 0 ) || ( $config_value > 500 ) ) ) {
				$new[$config_name] = 100;
			}
			if ( ($config_name === 'rss_sql_limit_txt' ) && ( ( $config_value < 0 ) || ( $config_value > 200 ) ) ) {
				$new[$config_name] = 25;
			}
			if ( ($config_name === 'rss_url_limit' ) && ( ( $config_value < 0 ) || ( $config_value > 2000 ) ) ) {
				$new[$config_name] = 100;
			}
			if ( ($config_name === 'rss_url_limit_long' ) && ( ( $config_value < 0 ) || ( $config_value > 4000 ) ) ) {
				$new[$config_name] = 500;
			}
			if ( ($config_name === 'rss_url_limit_short' ) && ( ( $config_value < 0 ) || ( $config_value > 1000 ) ) ) {
				$new[$config_name] = 25;
			}
			if ( ($config_name === 'rss_url_limit_txt' ) && ( ( $config_value < 0 ) || ( $config_value > 500 ) ) ) {
				$new[$config_name] = 50;
			}
			if ( ($config_name === 'rss_url_limit_long_txt' ) && ( ( $config_value < 0 ) || ( $config_value > 1000 ) ) ) {
				$new[$config_name] = 200;
			}
			if ( ($config_name === 'rss_url_limit_short_txt' ) && ( ( $config_value < 0 ) || ( $config_value > 200 ) ) ) {
				$new[$config_name] = 25;
			}
			if ( ($config_name === 'yahoo_limit' ) && ( ( $config_value < 0 ) || ( $config_value > 3000 ) ) ) {
				$new[$config_name] = 500;
			}
			if ( ($config_name === 'yahoo_sql_limit' ) && ( ( $config_value < 0 ) || ( $config_value > 1000 ) ) ) {
				$new[$config_name] = 100;
			}
			if ( ($config_name === 'yahoo_limit_time' ) && ( $config_value < 0 )  ) {
				$new[$config_name] = 15;
			}
			if ( ($config_name === 'yahoo_pagination' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'yahoo_limitup' ) && ( ( $config_value < 0 ) || ( $config_value > 1000 ) ) )
			{
				$new[$config_name] = 50;
			}
			if ( ($config_name === 'yahoo_limitdown' ) && ( ( $config_value < 0 ) || ( $config_value > 1000 ) ) ) {
				$new[$config_name] = 50;
			}
			if ( ($config_name === 'ggs_pagination' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_limitup' ) && ( ( $config_value < 0 ) || ( $config_value > 1000 ) ) )
			{
				$new[$config_name] = 50;
			}
			if ( ($config_name === 'ggs_limitdown' ) && ( ( $config_value < 0 ) || ( $config_value > 1000 ) ) ) {
				$new[$config_name] = 50;
			}
			if ( ($config_name === 'ggs_mod_rewrite' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_zero_dupe' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_mod_rewrite_type' ) && ( ( $config_value < 0 ) || ( $config_value > 3 ) ) ) {
				$new[$config_name] = "0";
			}
			if ( ($config_name === 'ggs_cached' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_auto_regen' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_showstats' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_force_cache_gzip' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_cache_max_age' ) && ( $config_value < 0 ) )  {
				$new[$config_name] = "12";
			}
			if ( ($config_name === 'rss_cache_max_age' ) && ( $config_value < 0 ) )  {
				$new[$config_name] = "5";
			}
			if ( ($config_name === 'yahoo_cache_max_age' ) && ( $config_value < 0 ) )  {
				$new[$config_name] = "24";
			}
			if ( ($config_name === 'rss_limit_time' ) && ( $config_value < 0 ) )  {
				$new[$config_name] = "15";
			}
			if ( ($config_name === 'yahoo_limit_time' ) && ( $config_value < 0 ) )  {
				$new[$config_name] = "15";
			}
			if ( ($config_name === 'rss_auto_regen' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_mod_since' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'rss_lang' ) && ( trim($config_value) == ''  ) )  {
				$new[$config_name] = "en";
			}
			if ( ($config_name === 'rss_sitename' ) && ( trim($config_value) == ''  ) )  {
				$new[$config_name] = $board_config['sitename'];
			}
			if ( ($config_name === 'rss_site_desc' ) && ( trim($config_value) == ''  ) )  {
				$new[$config_name] = $board_config['site_desc'];
			}
			if ( ($config_name === 'rss_cinfo' ) && ( trim($config_value) == ''  ) )  {
				$new[$config_name] = $board_config['sitename'];
			}
			if ( ($config_name === 'rss_forum_image' ) && ( trim($config_value) == ''  ) )  {
				$new[$config_name] = 'rss_forum_big.gif';
			}
			if ( ($config_name === 'rss_image' ) && ( trim($config_value) == ''  ) )  {
				$new[$config_name] = 'rss_board_big.gif';
			}
			if ( ($config_name === 'ggs_cache_dir' ) && ( trim($config_value) == ''  ) )  {
				$new[$config_name] = 'gs_cache/';
			}
			if ( ($config_name === 'ggs_kb_mx_page' ) && ( ( $config_value < 0  ) || ( trim($config_value) == '') ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_ver' ) && ( $config_value != "v1.2.0RC4" ) ) {
				$new[$config_name] = "v1.2.0RC4";
			}
			if ( ($config_name === 'ggs_c_info' ) && ( $config_value != "(C) 2006 dcz - http://www.phpbb-seo.com/" ) ) {
				$new[$config_name] = "(C) 2006 dcz - http://www.phpbb-seo.com/";
			}
			if ( ($config_name === 'rss_utf8' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_xslt' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'rss_xslt' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'rss_force_xslt' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_gzip_ext' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'rss_gzip_ext' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_gzip' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'ggs_gzip_level' ) && ( ( $config_value < 0 ) || ( $config_value > 9 ) ) ) {
				$new[$config_name] = "6";
			}
			if ( ($config_name === 'rss_allow_auth' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "FALSE";
			}
			if ( ($config_name === 'rss_cache_auth' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "TRUE";
			}
			if ( ($config_name === 'rss_allow_bbcode' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "TRUE";
			}
			if ( ($config_name === 'rss_allow_links' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "TRUE";
			}
			if ( ($config_name === 'rss_allow_smiles' ) && ( ( $config_value != "TRUE" ) && ( $config_value != "FALSE" ) ) ) {
				$new[$config_name] = "TRUE";
			}
			// Gun zip config synchro
			if ( ($config_name === 'ggs_gzip' ) ) {
				if ($board_config['ggs_gzip'] !== $new[$config_name] ) {
					$sql = "UPDATE " . CONFIG_TABLE . " SET
						config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
						WHERE config_name = 'ggs_gzip'";
					if( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, "Failed to synchronize Google sitemap configuration ", "", __LINE__, __FILE__, $sql);
					}
				}
			}
			// GGS Gun zip ext config synchro
			if ( ($config_name === 'ggs_gzip_ext' ) ) {
				if ($board_config['ggs_gzip_ext'] !== $new[$config_name] ) {
					$sql = "UPDATE " . CONFIG_TABLE . " SET
						config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
						WHERE config_name = 'ggs_gzip_ext'";
					if( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, "Failed to synchronize Google sitemap configuration ", "", __LINE__, __FILE__, $sql);
					}
				}
			}
			// RSS Gun zip ext config synchro
			if ( ($config_name === 'rss_gzip_ext' ) ) {
				if ($board_config['rss_gzip_ext'] !== $new[$config_name] ) {
					$sql = "UPDATE " . CONFIG_TABLE . " SET
						config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
						WHERE config_name = 'rss_gzip_ext'";
					if( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, "Failed to synchronize Google sitemap configuration ", "", __LINE__, __FILE__, $sql);
					}
				}
			}
			// GS exclude list config synchro
			if ( ($config_name === 'ggs_exclude_forums' ) ) {
				if ($board_config['ggs_exclude_forums'] !== $new[$config_name] ) {
					$sql = "UPDATE " . CONFIG_TABLE . " SET
						config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
						WHERE config_name = 'ggs_exclude_forums'";
					if( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, "Failed to synchronize Google sitemap configuration ", "", __LINE__, __FILE__, $sql);
					}
				}
			}
			// RSS exclude list config synchro
			if ( ($config_name === 'rss_exclude_forum' ) ) {
				if ($board_config['rss_exclude_forum'] !== $new[$config_name] ) {
					$sql = "UPDATE " . CONFIG_TABLE . " SET
						config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
						WHERE config_name = 'rss_exclude_forum'";
					if( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, "Failed to synchronize Google sitemap configuration ", "", __LINE__, __FILE__, $sql);
					}
				}
			}
			// Allow auth config synchro
			if ( ($config_name === 'rss_allow_auth' ) ) {
				if ($board_config['rss_allow_auth'] !== $new[$config_name] ) {
					$sql = "UPDATE " . CONFIG_TABLE . " SET
						config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
						WHERE config_name = 'rss_allow_auth'";
					if( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, "Failed to synchronize Google sitemap configuration ", "", __LINE__, __FILE__, $sql);
					}
				}
			}
			$sql = "UPDATE " . GGSITEMAP_TABLE . " SET
				config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Failed to update Google sitemap configuration ", "", __LINE__, __FILE__, $sql);
			}
		}
	}
	// Cache settings checks
	$cache_dir = defined('IN_PORTAL') ? $mx_root_path . 'modules/mx_ggsitemaps/' . $new['ggs_cache_dir'] : $phpbb_root_path .'includes/mx_ggsitemaps/' . $new['ggs_cache_dir'];
	$cache_dir = phpbb_realpath($cache_dir);
	if ($cache_dir{(strlen($cache_dir)-1)} != "/"){
		$cache_dir .= "/";
	}
	// Now really check
	$exists = $write = FALSE;
	if (file_exists($cache_dir) && is_dir($cache_dir)) {
		$exists = TRUE;
		if (!is_writeable($cache_dir)) {
			@chmod($cache_dir, 0777);
				$fp = @fopen($cache_dir . 'test_lock', 'wb');
				if ($fp !== false) {
					$write = true;
				}
				@fclose($fp);
				@unlink($phpbb_root_path . $dir . 'test_lock');
		} else {
			$write = true;
		}
	}
	$exists = ($exists) ? '<b style="color:green">' . $lang['ggs_cache_found'] . '</b>' : '<b style="color:red">' . $lang['ggs_cache_not_found'] . '</b>';
	$write = ($write) ? '<br/> <b style="color:green">' . $lang['ggs_cache_writable'] . '</b>' : (($exists) ? '<br/> <b style="color:red">' . $lang['ggs_cache_unwritable'] . '</b>' : '');
	$cache_msg = sprintf($lang['ggs_cache_status'], $cache_dir) . '<br/>' . $exists . $write;

	// Send a nice message if config updated
	if( $mode == "submit" ) 
	{
		$message = $lang['Google_Config_updated'] . "<br /><br />" . sprintf($lang['Click_return_ggsitemap_config'], "<a href=\"" . append_sid("admin_mx_ggsitemap.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid($mx_root_path.$admin_root_path1 . "index.$phpEx?pane=right") . "\">", "</a>");

		message_die(GENERAL_MESSAGE, $message);
	}
	// Deal with manual clear cache and send a nice message
	$accessed = FALSE;
	$message = '';
	$deleted = '';
	$types = array( '1' => 'google_', '2' => 'rss_', '3' => 'yahoo_');
	if ($mode == "clear_cache") {
		$res = opendir($cache_dir);
		$action_len = strlen($types[$cache_action]);
		if($res) {
			$num_del = 0;
			while(($file = @readdir($res))) {
				if( !($file == '.') && !($file == '..') &&  !($file == '.htaccess')) {
					if ($cache_action == 0) {
						@unlink($cache_dir . $file);
						$deleted .=  "<li>$file</li>";
						$num_del++;
					} elseif ((substr($file, 0, $action_len) == $types[$cache_action])) {
						@unlink($cache_dir . $file);
						$deleted .=  "<li>$file</li>";
						$num_del++;
					}
				}
			}
			$accessed = TRUE;
		}
		@closedir($res);
		
		if ($accessed) {
			if ($deleted !='') { 
				$message = $lang['ggs_cache_cleared_ok'] . $cache_dir . '<br/><br/>';
				$message .= '<div align="left">' . $lang['ggs_file_cleared_ok'] . " $num_del<ul>$deleted</ul></div>";
			} else {
				$message = $lang['ggs_cache_accessed_ok'] . $cache_dir;
			}
		} else {
			$message = $lang['ggs_cache_cleared_not_ok'] . $cache_dir;
		}
		$message .= "<br />" . sprintf($lang['Click_return_ggsitemap_config'], "<a href=\"" . append_sid("admin_mx_ggsitemap.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid($mx_root_path.$admin_root_path1 . "index.$phpEx?pane=right") . "\">", "</a>");
		message_die(GENERAL_MESSAGE, $message);
	}

}
// We shall build the page then
$template->set_filenames(array(
	"admin_ggsitemap" => "admin/admin_mx_ggsitemap.tpl")
);
$sitemap_sort_desc = ( $new['ggs_sort'] == "DESC" ) ? "checked=\"checked\"" : "";
$sitemap_sort_asc = ( $new['ggs_sort'] == "ASC" ) ? "checked=\"checked\"" : "";
$rewrite_sitemaps_no = ( $new['mod_rewrite'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rewrite_sitemaps_yes = ( $new['mod_rewrite'] == "TRUE" ) ? "checked=\"checked\"" : "";

$ggs_gzipext_no = ( $new['ggs_gzip_ext'] == "FALSE" ) ? "checked=\"checked\"" : "";
$ggs_gzipext_yes = ( $new['ggs_gzip_ext'] == "TRUE" ) ? "checked=\"checked\"" : "";

$ggs_xslt_no = ( $new['ggs_xslt'] == "FALSE" ) ? "checked=\"checked\"" : "";
$ggs_xslt_yes = ( $new['ggs_xslt'] == "TRUE" ) ? "checked=\"checked\"" : "";

$ggs_pagination_no = ( $new['ggs_pagination'] == "FALSE" ) ? "checked=\"checked\"" : "";
$ggs_pagination_yes = ( $new['ggs_pagination'] == "TRUE" ) ? "checked=\"checked\"" : "";

$zero_dupe_no = ( $new['ggs_zero_dupe'] == "FALSE" ) ? "checked=\"checked\"" : "";
$zero_dupe_yes = ( $new['ggs_zero_dupe'] == "TRUE" ) ? "checked=\"checked\"" : "";

$gun_zip_no = ( $new['ggs_gzip'] == "FALSE" ) ? "checked=\"checked\"" : "";
$gun_zip_yes = ( $new['ggs_gzip'] == "TRUE" ) ? "checked=\"checked\"" : "";

$cache_maps_no = ( $new['ggs_cached'] == "FALSE" ) ? "checked=\"checked\"" : "";
$cache_maps_yes = ( $new['ggs_cached'] == "TRUE" ) ? "checked=\"checked\"" : "";

$mod_since_no = ( $new['ggs_mod_since'] == "FALSE" ) ? "checked=\"checked\"" : "";
$mod_since_yes = ( $new['ggs_mod_since'] == "TRUE" ) ? "checked=\"checked\"" : "";

$mod_rewrite_no = ( $new['ggs_mod_rewrite'] == "FALSE" ) ? "checked=\"checked\"" : "";
$mod_rewrite_yes = ( $new['ggs_mod_rewrite'] == "TRUE" ) ? "checked=\"checked\"" : "";

$showstats_no = ( $new['ggs_showstats'] == "FALSE" ) ? "checked=\"checked\"" : "";
$showstats_yes = ( $new['ggs_showstats'] == "TRUE" ) ? "checked=\"checked\"" : "";

$sitemap_auto_regen_no = ( $new['ggs_auto_regen'] == "FALSE" ) ? "checked=\"checked\"" : "";
$sitemap_auto_regen_yes = ( $new['ggs_auto_regen'] == "TRUE" ) ? "checked=\"checked\"" : "";

$force_cache_gzip_no = ( $new['ggs_force_cache_gzip'] == "FALSE" ) ? "checked=\"checked\"" : "";
$force_cache_gzip_yes = ( $new['ggs_force_cache_gzip'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_xslt_no = ( $new['rss_xslt'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_xslt_yes = ( $new['rss_xslt'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_allow_auth_no = ( $new['rss_allow_auth'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_allow_auth_yes = ( $new['rss_allow_auth'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_cache_auth_no = ( $new['rss_cache_auth'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_cache_auth_yes = ( $new['rss_cache_auth'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_force_xslt_no = ( $new['rss_force_xslt'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_force_xslt_yes = ( $new['rss_force_xslt'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_auto_regen_no = ( $new['rss_auto_regen'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_auto_regen_yes = ( $new['rss_auto_regen'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_allow_bbcode_no = ( $new['rss_allow_bbcode'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_allow_bbcode_yes = ( $new['rss_allow_bbcode'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_allow_links_no = ( $new['rss_allow_links'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_allow_links_yes = ( $new['rss_allow_links'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_allow_smilies_no = ( $new['rss_allow_smilies'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_allow_smilies_yes = ( $new['rss_allow_smilies'] == "TRUE" ) ? "checked=\"checked\"" : "";

// digest method
$digest_type_lvl = array('sentences', 'words', 'chars');
$digest_type_txt = array($lang['rss_digest_sentences'], $lang['rss_digest_words'], $lang['rss_digest_chars']);
$digest_type_sel = select_menu($digest_type_lvl, $digest_type_txt, 'rss_sumarize_method', $new['rss_sumarize_method']);

// Char-set Conversion
$rss_charset_conv_lvl = array('auto',
	'iconv',
	'mb_convert_encoding',
	'recode_string',
	'utf8_encode',
	'phpbb3',
);
$rss_charset_conv_txt = array('auto',
	'iconv',
	'mb_convert_encoding',
	'recode_string',
	'utf8_encode',
	'phpbb3',
);
$rss_charset_conv_sel = select_menu($rss_charset_conv_lvl, $rss_charset_conv_txt, 'rss_charset_conv', $new['rss_charset_conv']);

// Char-set Conversion
$rss_char_set_lvl = array(
	'iso-8859-1',
	'utf-8',
	'iso-8859-2',
	'iso-8859-4', 
	'iso-8859-7', 
	'iso-8859-9', 
	'iso-8859-15', 
	'windows-932',
	'windows-1250',
	'windows-1251',
	'windows-1254',
	'windows-1255',
	'windows-1256',
	'windows-1257',
	'windows-874',
	'tis-620',
	'x-sjis',
	'euc-kr',
	'big5',
	'gb2312',
);
$rss_char_set_txt = array(
	'iso-8859-1',
	'utf-8',
	'iso-8859-2',
	'iso-8859-4', 
	'iso-8859-7', 
	'iso-8859-9', 
	'iso-8859-15', 
	'windows-932',
	'windows-1250',
	'windows-1251',
	'windows-1254',
	'windows-1255',
	'windows-1256',
	'windows-1257',
	'windows-874',
	'tis-620',
	'x-sjis',
	'euc-kr',
	'big5',
	'gb2312',
);
$auto_charset = '';
if ( @extension_loaded('mbstring') ) {
	$auto_charset = trim(@mb_strtolower(@mb_internal_encoding()));
}
if ( !($auto_charset == '') && !($encoding == 'no value') ) {
	array_unshift($rss_char_set_lvl, 'auto' );
	array_unshift($rss_char_set_txt, 'auto' );
	$auto_charset = $lang['rss_charset_explain'] . sprintf($lang['rss_charset_test_match'], $auto_charset);
} else {
	$auto_charset = $lang['rss_charset_explain'];
}
$rss_char_set_sel = select_menu($rss_char_set_lvl, $rss_char_set_txt, 'rss_charset', $new['rss_charset']);
$rss_gzipext_no = ( $new['rss_gzip_ext'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_gzipext_yes = ( $new['rss_gzip_ext'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_allow_short_no = ( $new['rss_allow_short'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_allow_short_yes = ( $new['rss_allow_short'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_allow_long_no = ( $new['rss_allow_long'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_allow_long_yes = ( $new['rss_allow_long'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_first_no = ( $new['rss_first'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_first_yes = ( $new['rss_first'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_last_no = ( $new['rss_last'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_last_yes = ( $new['rss_last'] == "TRUE" ) ? "checked=\"checked\"" : "";

$rss_msg_txt_no = ( $new['rss_msg_txt'] == "FALSE" ) ? "checked=\"checked\"" : "";
$rss_msg_txt_yes = ( $new['rss_msg_txt'] == "TRUE" ) ? "checked=\"checked\"" : "";

$yahoo_auto_regen_no = ( $new['yahoo_auto_regen'] == "FALSE" ) ? "checked=\"checked\"" : "";
$yahoo_auto_regen_yes = ( $new['yahoo_auto_regen'] == "TRUE" ) ? "checked=\"checked\"" : "";

$yahoo_notify_no = ( $new['yahoo_notify'] == "FALSE" ) ? "checked=\"checked\"" : "";
$yahoo_notify_yes = ( $new['yahoo_notify'] == "TRUE" ) ? "checked=\"checked\"" : "";

$yahoo_notify_long_no = ( $new['yahoo_notify_long'] == "FALSE" ) ? "checked=\"checked\"" : "";
$yahoo_notify_long_yes = ( $new['yahoo_notify_long'] == "TRUE" ) ? "checked=\"checked\"" : "";

$yahoo_pagination_no = ( $new['yahoo_pagination'] == "FALSE" ) ? "checked=\"checked\"" : "";
$yahoo_pagination_yes = ( $new['yahoo_pagination'] == "TRUE" ) ? "checked=\"checked\"" : "";

// Mod rewrite type
$mod_rewrite_type_lvl = array(0, 1, 2, 3);
$mod_rewrite_type_txt = array($lang['ggs_none'], $lang['ggs_simple'], $lang['ggs_mixed'], $lang['ggs_advanced']);
$mod_rewrite_type_sel = select_menu($mod_rewrite_type_lvl, $mod_rewrite_type_txt, 'ggs_mod_rewrite_type', $new['ggs_mod_rewrite_type']);

// Gun Zip compression
$gzip_lvl = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
$gzip_lvl_sel = select_menu($gzip_lvl, $gzip_lvl, 'ggs_gzip_level', $new['ggs_gzip_level']);

// Clear cache type
$clear_cache_lvl = array(0, 1, 2, 3);
$clear_cache_txt = array($lang['ggs_clr_all'], $lang['ggs_clr_ggs'], $lang['ggs_clr_rss'], $lang['ggs_clr_yahoo']);
$clear_cache_sel = select_menu($clear_cache_lvl, $clear_cache_txt, 'do_clear_cache', $cache_action);

// Gunzip message
$gzmsg = ($board_config['gzip_compress']) ? $lang['ggs_gz_avail'] : $lang['ggs_gz_notavail'];
$template->assign_vars(array(
	
	"L_CONFIGURATION_TITLE" => $lang['ggs_conf_title'],
	"L_CONFIGURATION_EXPLAIN" => $lang['ggs_conf_explain'],
	"L_BACK_TO_TOP" => $lang['Back_to_top'],
	"L_MENU" => $lang['ggs_menu'],
	
	"S_CONFIG_ACTION" => append_sid("admin_mx_ggsitemap.$phpEx"),
	"L_CLEAR_CACHE" => $lang['ggs_clr_cache'],
	"L_CLEAR_CACHE_EXPLAIN" => $lang['ggs_clr_cache_explain'],
	"L_CACHE_STATUS" => $lang['ggs_cache_dir'],
	"L_CACHE_STATUS_MSG" => $cache_msg,
	"CLEAR_CACHE" => $clear_cache_sel,

	// General Settings
	"L_GENERAL_SETTINGS" => $lang['gen_settings'],
	"L_GENERAL_SETTINGS_EXPLAIN" => $lang['gen_settings_explain'],
	"L_S_MOD_REWRITE" => $lang['gen_mod_rewrite'],
	"L_S_MOD_REWRITE_EXPLAIN" => $lang['gen_mod_rewrite_explain'],
	"L_S_MOD_REWRITE_TYPE" => $lang['gen_mod_rewrite_type'],
	"L_S_MOD_REWRITE_TYPE_EXPLAIN" => $lang['gen_mod_rewrite_type_explain'],
	"L_ZERO_DUPE" => $lang['ggs_zero_dupe'],
	"L_ZERO_DUPE_EXPLAIN" => $lang['ggs_zero_dupe_explain'],
	"L_GUN_ZIP" => $lang['ggs_gun_zip'],
	"L_GUN_ZIP_EXPLAIN" => $lang['ggs_gun_zip_explain'] . $gzmsg,
	"L_GUN_ZIP_LEVEL" => $lang['ggs_gun_zip_lvl'],
	"L_GUN_ZIP_LEVEL_EXPLAIN" => $lang['ggs_gun_zip_lvl_explain'],
	"L_MOD_SINCE" => $lang['ggs_mod_since'],
	"L_MOD_SINCE_EXPLAIN" => $lang['ggs_mod_since_explain'],
	"L_CACHE" => $lang['ggs_cache'],
	"L_CACHE_EXPLAIN" => $lang['ggs_cache_explain'],
	"L_CACHE_DIR" => $lang['ggs_cache_dir'],
	"L_CACHE_DIR_EXPLAIN" => $lang['ggs_cache_dir_explain'],
	"L_FORCE_CACHE_GUN_ZIP" => $lang['ggs_force_cache_gzip'],
	"L_FORCE_CACHE_GUN_ZIP_EXPLAIN" => $lang['ggs_force_cache_gzip_explain'],
	"L_SHOWSTATS" => $lang['ggs_showstats'],
	"L_SHOWSTATS_EXPLAIN" => $lang['ggs_showstats_explain'],

	"L_SORT_ORDER" => $lang['gen_sort_order'],
	"L_SORT_ORDER_EXPLAIN" => $lang['gen_sort_order_explain'],
	"L_NEW_FIRST" => $lang['gen_new_first'],
	"L_OLD_FIRST" => $lang['gen_old_first'],


	"SITEMAP_SORT_DESC" => $sitemap_sort_desc,
	"SITEMAP_SORT_ASC" => $sitemap_sort_asc,
	"REWRITE_NO" => $rewrite_sitemaps_no,
	"REWRITE_YES" => $rewrite_sitemaps_yes,
	"SHOWSTATS_NO" => $showstats_no,
	"SHOWSTATS_YES" => $showstats_yes,

	"REWRITE_YES" => $mod_rewrite_yes,
	"REWRITE_NO" => $mod_rewrite_no,
	"MOD_REWRITE_TYPE" => $mod_rewrite_type_sel,
	"ZERO_DUPE_NO" => $zero_dupe_no,
	"ZERO_DUPE_YES" => $zero_dupe_yes,
	"GUN_ZIP_NO" => $gun_zip_no,
	"GUN_ZIP_YES" => $gun_zip_yes,
	"GUN_ZIP_LEVEL" => $gzip_lvl_sel,
	"MOD_SINCE_NO" => $mod_since_no,
	"MOD_SINCE_YES" => $mod_since_yes,
	"CACHE_NO" => $cache_maps_no,
	"CACHE_YES" => $cache_maps_yes,
	"CACHE_DIR" => $new['ggs_cache_dir'],
	"FORCE_CACHE_GUN_ZIP_NO" => $force_cache_gzip_no,
	"FORCE_CACHE_GUN_ZIP_YES" => $force_cache_gzip_yes,

	// GGS Settings
	"L_GGS_SETTINGS" => $lang['ggs_settings'],
	"L_GGS_SETTINGS_EXPLAIN" => sprintf($lang['ggs_settings_explain'], "<a href=\"http://www.google.com/webmasters/sitemaps/login\" target=\"_Google\">", "</a>") . '<br />' . sprintf($lang['ggss_settings_explain2'], "<a href=\"http://www.google.com/search?q=google+sitemap+submitter\" target=\"_Google\">", "</a>"),
	"L_GGS_XSLT" => $lang['ggs_xslt'],
	"L_GGS_XSLT_EXPLAIN" => $lang['ggs_xslt_explain'],
	"L_SQL_LIMIT" => $lang['ggs_sql_limit'],
	"L_SQL_LIMIT_EXPLAIN" => $lang['ggs_sql_limit_explain'],
	"L_DEFAULT_LIMIT" => $lang['ggs_default_limit'],
	"L_DEFAULT_LIMIT_EXPLAIN" => $lang['ggs_default_limit_explain'],
	"L_GGS_AUTO_REGEN" => $lang['ggs_auto_regen'],
	"L_GGS_AUTO_REGEN_EXPLAIN" => $lang['ggs_auto_regen_explain'],
	"L_GGS_CACHE_MX_AGE" => $lang['ggs_cache_max_age'],
	"L_GGS_CACHE_MX_AGE_EXPLAIN" => $lang['ggs_cache_max_age_explain'],
	"L_GGS_GZIP_EXT" => $lang['ggs_gzip_ext'],
	"L_GGS_GZIP_EXT_EXPLAIN" => $lang['ggs_gzip_ext_explain'],

	"GGS_XSLT_NO" => $ggs_xslt_no,
	"GGS_XSLT_YES" => $ggs_xslt_yes,
	"GSS_CACHE_MX_AGE" => $new['ggs_cache_max_age'],
	"AUTO_REGEN_NO" => $sitemap_auto_regen_no,
	"AUTO_REGEN_YES" => $sitemap_auto_regen_yes,
	"SQL_LIMIT" => $new['ggs_sql_limit'],
	"DEFAULT_LIMIT" => $new['ggs_url_limit'],
	"GGS_GZIP_EXT_NO" => $ggs_gzipext_no,
	"GGS_GZIP_EXT_YES" => $ggs_gzipext_yes,

		// Forum Settings
		"L_FORUM_SETTINGS" => $lang['ggs_forum_settings'],
		"L_SITEMAP_FORUM_EXCLUDE" => $lang['ggs_forum_exclude'],
		"L_SITEMAP_FORUM_EXCLUDE_EXPLAIN" => $lang['ggs_forum_exclude_explain'],
		"L_ANNOUNCE_PRIORITY" => $lang['ggs_announce_priority'],
		"L_ANNOUNCE_PRIORITY_EXPLAIN" => $lang['ggs_announce_priority_explain'],
		"L_STICKY_PRIORITY" => $lang['ggs_sticky_priority'],
		"L_STICKY_PRIORITY_EXPLAIN" => $lang['ggs_sticky_priority_explain'],
		"L_DEFAULT_PRIORITY" => $lang['ggs_default_priority'],
		"L_DEFAULT_PRIORITY_EXPLAIN" => $lang['ggs_default_priority_explain'],
		"L_PAGINATION" => $lang['ggs_pagination'],
		"L_PAGINATION_EXPLAIN" => $lang['ggs_pagination_explain'],
		"L_PAGINATION_LIMIT1" => $lang['ggs_pagination_limit1'],
		"L_PAGINATION_LIMIT_EXPLAIN1" => $lang['ggs_pagination_limit_explain1'],
		"L_PAGINATION_LIMIT2" => $lang['ggs_pagination_limit2'],
		"L_PAGINATION_LIMIT_EXPLAIN2" => $lang['ggs_pagination_limit_explain2'],

		"SITEMAP_FORUM_EXCLUDE" => $new['ggs_exclude_forums'],
		"ANNOUNCE_PRIORITY" => $new['ggs_announce_priority'],
		"STICKY_PRIORITY" => $new['ggs_sticky_priority'],
		"DEFAULT_PRIORITY" => $new['ggs_default_priority'],
		"PAGINATION_NO" => $ggs_pagination_no,
		"PAGINATION_YES" => $ggs_pagination_yes,
		"PAGINATION_LIMITDOWN" => $new['ggs_limitdown'],
		"PAGINATION_LIMITUP" => $new['ggs_limitup'],

	// RSS Settings
	"L_RSS_SETTINGS" => $lang['rss_settings'],
	"L_RSS_SETTINGS_EXPLAIN" => $lang['rss_settings_explain'],
	"L_RSS_XSLT" => $lang['rss_xslt'],
	"L_RSS_XSLT_EXPLAIN" => $lang['rss_xslt_explain'],
	"L_RSS_FORCE_XSLT" => $lang['rss_force_xslt'],
	"L_RSS_FORCE_XSLT_EXPLAIN" => $lang['rss_force_xslt_explain'],
	"L_RSS_SITENAME" => $lang['rss_sitename'],
	"L_RSS_SITENAME_EXPLAIN" => $lang['rss_sitename_explain'],
	"L_RSS_SITEDESC" => $lang['rss_sitedesc'],
	"L_RSS_SITEDESC_EXPLAIN" => $lang['rss_sitedesc_explain'],
	"L_RSS_CINFO" => $lang['rss_cinfo'],
	"L_RSS_CINFO_EXPLAIN" => $lang['rss_cinfo_explain'],
	"L_RSS_LANG" => $lang['rss_lang'],
	"L_RSS_LANG_EXPLAIN" => $lang['rss_lang_explain'],
	"L_RSS_CHARSET" => $lang['rss_charset'],
	"L_RSS_CHARSET_EXPLAIN" => $auto_charset,
	"L_RSS_CHARSET_CONV" => $lang['rss_charset_conv'],
	"L_RSS_CHARSET_CONV_EXPLAIN" => $lang['rss_charset_conv_explain'],
	"L_RSS_IMAGE" => $lang['rss_image'],
	"L_RSS_IMAGE_EXPLAIN" => $lang['rss_image_explain'],
	"L_RSS_FORUM_IMAGE" => $lang['rss_forum_image'],
	"L_RSS_FORUM_IMAGE_EXPLAIN" => $lang['rss_forum_image_explain'],
	"L_RSS_CACHE_MX_AGE" => $lang['rss_cache_max_age'],
	"L_RSS_CACHE_MX_AGE_EXPLAIN" => $lang['rss_cache_max_age_explain'],
	"L_RSS_AUTO_REGEN" => $lang['rss_auto_regen'],
	"L_RSS_AUTO_REGEN_EXPLAIN" => $lang['rss_auto_regen_explain'],
	"L_RSS_GZIP_EXT" => $lang['rss_gzip_ext'],
	"L_RSS_GZIP_EXT_EXPLAIN" => $lang['rss_gzip_ext_explain'],

	"RSS_XSLT_NO" => $rss_xslt_no,
	"RSS_XSLT_YES" => $rss_xslt_yes,
	"RSS_FORCE_XSLT_NO" => $rss_force_xslt_no,
	"RSS_FORCE_XSLT_YES" => $rss_force_xslt_yes,
	"RSS_SITENAME" => $new['rss_sitename'],
	"RSS_SITEDESC" => $new['rss_site_desc'],
	"RSS_CINFO" => $new['rss_cinfo'],
	"RSS_LANG" => $new['rss_lang'],
	"RSS_CHARSET" => $rss_char_set_sel,
	"RSS_CHARSET_CONV" => $rss_charset_conv_sel,
	"RSS_IMAGE" => $new['rss_image'],
	"RSS_FORUM_IMAGE" => $new['rss_forum_image'],
	"RSS_CACHE_MX_AGE" => $new['rss_cache_max_age'],
	"RSS_AUTO_REGEN_NO" => $rss_auto_regen_no,
	"RSS_AUTO_REGEN_YES" => $rss_auto_regen_yes,
	"RSS_GZIP_EXT_NO" => $rss_gzipext_no,
	"RSS_GZIP_EXT_YES" => $rss_gzipext_yes,
		// Yahoo! Notify Settings
		"L_YAHOO_NOTIFY" => $lang['yahoo_notify'],
		"L_YAHOO_NOTIFY_EXPLAIN" => $lang['yahoo_notify_explain'],
		"L_YAHOO_APPID" => $lang['yahoo_appid'],
		"L_YAHOO_APPID_EXPLAIN" => $lang['yahoo_appid_explain'],
		"L_YAHOO_NOTIFY_LONG" => $lang['yahoo_notify_long'],
		"L_YAHOO_NOTIFY_LONG_EXPLAIN" => $lang['yahoo_notify_long_explain'],

		"YAHOO_NOTIFY_NO" => $yahoo_notify_no,
		"YAHOO_NOTIFY_YES" => $yahoo_notify_yes,
		"YAHOO_APPID" => $new['yahoo_appid'],
		"YAHOO_NOTIFY_LONG_NO" => $yahoo_notify_long_no,
		"YAHOO_NOTIFY_LONG_YES" => $yahoo_notify_long_yes,
		// RSS Content Settings
		"L_RSS_CONTENT_SETTINGS" => $lang['rss_content_settings'],
		"L_RSS_MSG_TXT" => $lang['rss_msg_txt'],
		"L_RSS_MSG_TXT_EXPLAIN" => $lang['rss_msg_txt_explain'],
		"L_RSS_ALLOW_BBCODE" => $lang['rss_allow_bbcode'],
		"L_RSS_ALLOW_BBCODE_EXPLAIN" => $lang['rss_allow_bbcode_explain'],
		"L_RSS_STRIP_BBCODE" => $lang['rss_strip_bbcode'],
		"L_RSS_STRIP_BBCODE_EXPLAIN" => $lang['rss_strip_bbcode_explain'],
		"L_RSS_ALLOW_LINKS" => $lang['rss_allow_links'],
		"L_RSS_ALLOW_LINKS_EXPLAIN" => $lang['rss_allow_links'],
		"L_RSS_ALLOW_SMILIES" => $lang['rss_allow_smilies'],
		"L_RSS_ALLOW_SMILIES_EXPLAIN" => $lang['rss_allow_smilies_explain'],
		"L_RSS_SUMARIZE" => $lang['rss_sumarize'],
		"L_RSS_SUMARIZE_EXPLAIN" => $lang['rss_sumarize_explain'],
		"L_RSS_SUMARIZE_METHOD" => $lang['rss_sumarize_method'],
		"L_RSS_SUMARIZE_METHOD_EXPLAIN" => $lang['rss_sumarize_method_explain'],
		"L_RSS_FIRST" => $lang['rss_first'],
		"L_RSS_FIRST_EXPLAIN" => $lang['rss_first_explain'],
		"L_RSS_LAST" => $lang['rss_last'],
		"L_RSS_LAST_EXPLAIN" => $lang['rss_last_explain'],
		"L_RSS_ALLOW_SHORT" => $lang['rss_allow_short'],
		"L_RSS_ALLOW_SHORT_EXPLAIN" => $lang['rss_allow_short_explain'],
		"L_RSS_ALLOW_LONG" => $lang['rss_allow_long'],
		"L_RSS_ALLOW_LONG_EXPLAIN" => $lang['rss_allow_long_explain'],

		"RSS_MSG_TXT_NO" => $rss_msg_txt_no,
		"RSS_MSG_TXT_YES" => $rss_msg_txt_yes,
		"RSS_ALLOW_BBCODE_NO" => $rss_allow_bbcode_no,
		"RSS_ALLOW_BBCODE_YES" => $rss_allow_bbcode_yes,
		"RSS_STRIP_BBCODE" => $new['rss_strip_bbcode'],
		"RSS_ALLOW_LINKS_NO" => $rss_allow_links_no,
		"RSS_ALLOW_LINKS_YES" => $rss_allow_links_yes,
		"RSS_ALLOW_SMILIES_NO" => $rss_allow_smilies_no,
		"RSS_ALLOW_SMILIES_YES" => $rss_allow_smilies_yes,
		"RSS_SUMARIZE" => $new['rss_sumarize'],
		"RSS_SUMARIZE_METHOD" => $digest_type_sel,
		"RSS_FIRST_NO" => $rss_first_no,
		"RSS_FIRST_YES" => $rss_first_yes,
		"RSS_LAST_NO" => $rss_last_no,
		"RSS_LAST_YES" => $rss_last_yes,
		"RSS_ALLOW_SHORT_NO" => $rss_allow_short_no,
		"RSS_ALLOW_SHORT_YES" => $rss_allow_short_yes,
		"RSS_ALLOW_LONG_NO" => $rss_allow_long_no,
		"RSS_ALLOW_LONG_YES" => $rss_allow_long_yes,

		// RSS Limits Settings
		"L_RSS_LIMIT_SETTINGS" => $lang['rss_limit_settings'],
		"L_RSS_TIME_LIMIT" => $lang['rss_limit_time'],
		"L_RSS_TIME_LIMIT_EXPLAIN" => $lang['rss_limit_time_explain'],
		"L_RSS_URL_LIMIT_LONG" => $lang['rss_url_limit_long'],
		"L_RSS_URL_LIMIT_LONG_EXPLAIN" => $lang['rss_url_limit_long_explain'],
		"L_RSS_URL_LIMIT" => $lang['rss_url_limit'],
		"L_RSS_URL_LIMIT_EXPLAIN" => $lang['rss_url_limit_explain'],
		"L_RSS_URL_LIMIT_SHORT" => $lang['rss_url_limit_short'],
		"L_RSS_URL_LIMIT_SHORT_EXPLAIN" => $lang['rss_url_limit_short_explain'],
		"L_RSS_SQL_LIMIT" => $lang['rss_sql_limit'],
		"L_RSS_SQL_LIMIT_EXPLAIN" => $lang['rss_sql_limit_explain'],
		"L_RSS_URL_LIMIT_TXT_LONG" => $lang['rss_url_limit_txt_long'],
		"L_RSS_URL_LIMIT_TXT_LONG_EXPLAIN" => $lang['rss_url_limit_txt_long_explain'],
		"L_RSS_URL_LIMIT_TXT" => $lang['rss_url_limit_txt'],
		"L_RSS_URL_LIMIT_TXT_EXPLAIN" => $lang['rss_url_limit_txt_explain'],
		"L_RSS_URL_LIMIT_TXT_SHORT" => $lang['rss_url_limit_txt_short'],
		"L_RSS_URL_LIMIT_TXT_SHORT_EXPLAIN" => $lang['rss_url_limit_txt_short_explain'],
		"L_RSS_SQL_LIMIT_TXT" => $lang['rss_sql_limit_txt'],
		"L_RSS_SQL_LIMIT_TXT_EXPLAIN" => $lang['rss_sql_limit_txt_explain'],

		"RSS_TIME_LIMIT" => $new['rss_limit_time'],
		"RSS_URL_LIMIT_LONG" => $new['rss_url_limit_long'],
		"RSS_URL_LIMIT" => $new['rss_url_limit'],
		"RSS_URL_LIMIT_SHORT" => $new['rss_url_limit_short'],
		"RSS_SQL_LIMIT" => $new['rss_sql_limit'],
		"RSS_URL_LIMIT_TXT_LONG" => $new['rss_url_limit_txt_long'],
		"RSS_URL_LIMIT_TXT" => $new['rss_url_limit_txt'],
		"RSS_URL_LIMIT_TXT_SHORT" => $new['rss_url_limit_txt_short'],
		"RSS_SQL_LIMIT_TXT" => $new['rss_sql_limit_txt'],

		// Forum Settings
		"L_FORUM_SETTINGS" => $lang['ggs_forum_settings'],
		"L_RSS_ALLOW_AUTH" => $lang['rss_allow_auth'],
		"L_RSS_ALLOW_AUTH_EXPLAIN" => $lang['rss_allow_auth_explain'],
		"L_RSS_CACHE_AUTH" => $lang['rss_cache_auth'],
		"L_RSS_CACHE_AUTH_EXPLAIN" => $lang['rss_cache_auth_explain'],
		"L_RSS_EXCLUDE_FORUM" => $lang['rss_exclude_forum'],
		"L_RSS_EXCLUDE_FORUM_EXPLAIN" => $lang['rss_exclude_forum_explain'],

		"RSS_ALLOW_AUTH_NO" => $rss_allow_auth_no,
		"RSS_ALLOW_AUTH_YES" => $rss_allow_auth_yes,
		"RSS_CACHE_AUTH_NO" => $rss_cache_auth_no,
		"RSS_CACHE_AUTH_YES" => $rss_cache_auth_yes,
		"RSS_EXCLUDE_FORUM" => $new['rss_exclude_forum'],


	// Yahoo urllist.txt Settings
	"L_YAHOO_SETTINGS" => $lang['yahoo_settings'],
	"L_YAHOO_SETTINGS_EXPLAIN" => $lang['yahoo_settings_explain'],
	"L_YAHOO_LIMIT" => $lang['yahoo_limit'],
	"L_YAHOO_LIMIT_EXPLAIN" => $lang['yahoo_limit_explain'],
	"L_YAHOO_SQL_LIMIT" => $lang['yahoo_sql_limit'],
	"L_YAHOO_SQL_LIMIT_EXPLAIN" => $lang['yahoo_sql_limit_explain'],
	"L_YAHOO_LIMIT_TIME" => $lang['yahoo_limit_time'],
	"L_YAHOO_LIMIT_TIME_EXPLAIN" => $lang['yahoo_limit_time_explain'],
	"L_YAHOO_CACHE_MX_AGE" => $lang['yahoo_cache_max_age'],
	"L_YAHOO_CACHE_MX_AGE_EXPLAIN" => $lang['yahoo_cache_max_age_explain'],
	"L_YAHOO_AUTO_REGEN" => $lang['yahoo_auto_regen'],
	"L_YAHOO_AUTO_REGEN_EXPLAIN" => $lang['yahoo_auto_regen_explain'],

	"L_YAHOO_PAGINATION" => $lang['yahoo_pagination'],
	"L_YAHOO_PAGINATION_EXPLAIN" => $lang['yahoo_pagination_explain'],
	"L_YAHOO_PAGINATION_LIMIT1" => $lang['yahoo_pagination_limit1'],
	"L_YAHOO_PAGINATION_LIMIT_EXPLAIN1" => $lang['yahoo_pagination_limit_explain1'],
	"L_YAHOO_PAGINATION_LIMIT2" => $lang['yahoo_pagination_limit2'],
	"L_YAHOO_PAGINATION_LIMIT_EXPLAIN2" => $lang['yahoo_pagination_limit_explain2'],

	"YAHOO_LIMIT" => $new['yahoo_limit'],
	"YAHOO_SQL_LIMIT" => $new['yahoo_sql_limit'],
	"YAHOO_LIMIT_TIME" => $new['yahoo_limit_time'],
	"YAHOO_CACHE_MX_AGE" => $new['yahoo_cache_max_age'],
	"YAHOO_AUTO_REGEN_NO" => $yahoo_auto_regen_no,
	"YAHOO_AUTO_REGEN_YES" => $yahoo_auto_regen_yes,
	"YAHOO_PAGINATION_NO" => $yahoo_pagination_no,
	"YAHOO_PAGINATION_YES" => $yahoo_pagination_yes,
	"YAHOO_PAGINATION_LIMITDOWN" => $new['yahoo_limitdown'],
	"YAHOO_PAGINATION_LIMITUP" => $new['yahoo_limitup'],


		// Forum Settings
		"L_FORUM_SETTINGS" => $lang['ggs_forum_settings'],
		"L_YAHOO_EXCLUDE" => $lang['yahoo_exclude'],
		"L_YAHOO_EXCLUDE_EXPLAIN" => $lang['yahoo_exclude_explain'],
		
		"YAHOO_EXCLUDE" => $new['yahoo_exclude'],

	// Common
	"VER_INFO" => 'mx_ggsitemaps ' . $new['ggs_ver'] . '<br/>' .  make_clickable($new['ggs_c_info']),
	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	"L_SUBMIT" => $lang['Submit'],
	"L_RESET" => $lang['Reset']
	)
);
// If mxBB is installed with mx, let's show some more options
if (defined('IN_PORTAL'))
{
	$template -> assign_block_vars('mx_config', array(
			"L_SITEMAP_MX_SET" => $lang['gen_mx_set'],
			"L_SITEMAP_MX_SET_EXPLAIN" => sprintf($lang['gen_mx_set_explain'], "<a href=\"http://www.mx-system.com/\" target=\"_mxBB\">", "</a>"),

			// GGS Settings
			"L_GGS_SETTINGS_KB" => $lang['ggs_mx_settings'],
			"L_MX_EXCLUDE" => $lang['ggs_mx_exclude'],
			"L_MX_EXCLUDE_EXPLAIN" => $lang['ggs_mx_exclude_explain'],

			"MX_EXCLUDE" => $new['ggs_mx_exclude'],

			// RSS Settings
			"L_RSS_SETTINGS_MX" => $lang['rss_mx_settings'],
			"L_RSS_EXCLUDE_MX" => $lang['rss_exclude_mx'],
			"L_RSS_EXCLUDE_MX_EXPLAIN" => $lang['rss_exclude_mx_explain'],

			"RSS_EXCLUDE_MX" => $new['rss_exclude_mx'],

			// Yahoo Settings
			"L_YAHOO_MX_SETTINGS" => $lang['yahoo_mx_settings'],
			"L_YAHOO_EXCLUDE_MX" => $lang['yahoo_exclude_mx'],
			"L_YAHOO_EXCLUDE_MX_EXPLAIN" => $lang['yahoo_exclude_mx_explain'],

			"YAHOO_EXCLUDE_MX" => $new['yahoo_exclude_mx'],

			)
		);
}
// If kb is installed with mx, let's show some more options
if ( file_exists( $mx_root_path . $pathkb . 'includes/functions_kb.' . $phpEx ) && defined('IN_PORTAL') )
{
	$template -> assign_block_vars('kb_config', array(

			"L_SITEMAP_KB_SET" => $lang['gen_kb_set'],
			"L_SITEMAP_KB_SET_EXPLAIN" => $lang['gen_kb_set_explain'],
			
			// Mx Settings
			"L_MX_SETTINGS" => $lang['gen_mx_set'],
			"L_KB_MX_PAGE" => $lang['ggs_kb_mx_page'],
			"L_KB_MX_PAGE_EXPLAIN" => sprintf($lang['ggs_kb_mx_page_explain'], "<a href=\"http://www.mx-system.com/\" target=\"_mxBB\">", "</a>"),
			"KB_MX_PAGE" => $new['ggs_kb_mx_page'],

			// GGS Settings
			"L_GGS_SETTINGS_KB" => $lang['ggs_mx_settings'],
			"L_KB_MX_EXCLUDE" => $lang['ggs_kb_exclude'],
			"L_KB_MX_EXCLUDE_EXPLAIN" => $lang['ggs_kb_exclude_explain'],

			"KB_MX_EXCLUDE" => $new['ggs_kb_exclude'],

			// RSS Settings
			"L_RSS_SETTINGS_KB" => $lang['rss_kb_settings'],
			"L_RSS_EXCLUDE_KB" => $lang['rss_exclude_kb'],
			"L_RSS_EXCLUDE_KB_EXPLAIN" => $lang['rss_exclude_kb_explain'],

			"RSS_EXCLUDE_KB" => $new['rss_exclude_kbcat'],

			// Yahoo Settings
			"L_YAHOO_KB_SETTINGS" => $lang['yahoo_kb_settings'],
			"L_YAHOO_EXCLUDE_KB" => $lang['yahoo_exclude_kb'],
			"L_YAHOO_EXCLUDE_KB_EXPLAIN" => $lang['yahoo_exclude_kb_explain'],

			"YAHOO_EXCLUDE_KB" => $new['yahoo_exclude_kbcat'],
			)
		);
}
// If kb is installed with phpBB, let's show some more options as well
elseif ( file_exists( $phpbb_root_path . 'includes/functions_kb.' . $phpEx ) && !defined('IN_PORTAL') )
{
	$template -> assign_block_vars('kb_config_phpbb', array(

			"L_SITEMAP_KB_SET" => $lang['Sitemap_kb_set'],
			"L_SITEMAP_KB_SET_EXPLAIN" => $lang['Sitemap_kb_set_explain'],

			// GGS Settings
			"L_GGS_SETTINGS_KB" => $lang['ggs_mx_settings'],
			"L_KB_MX_EXCLUDE" => $lang['ggs_kb_exclude'],
			"L_KB_MX_EXCLUDE_EXPLAIN" => $lang['ggs_kb_exclude_explain'],

			"KB_MX_EXCLUDE" => $new['ggs_kb_exclude'],

			// RSS Settings
			"L_RSS_SETTINGS_KB" => $lang['rss_kb_settings'],
			"L_RSS_EXCLUDE_KB" => $lang['rss_exclude_kb'],
			"L_RSS_EXCLUDE_KB_EXPLAIN" => $lang['rss_exclude_kb_explain'],

			"RSS_EXCLUDE_KB" => $new['rss_exclude_kbcat'],

			// Yahoo Settings
			"L_YAHOO_KB_SETTINGS" => $lang['yahoo_kb_settings'],
			"L_YAHOO_EXCLUDE_KB" => $lang['yahoo_exclude_kb'],
			"L_YAHOO_EXCLUDE_KB_EXPLAIN" => $lang['yahoo_exclude_kb_explain'],

			"YAHOO_EXCLUDE_KB" => $new['yahoo_exclude_kbcat'],
			)
		);
}

$template->pparse('admin_ggsitemap');

include_once($mx_root_path.$admin_root_path1 . 'page_footer_admin.'.$phpEx);
?>
