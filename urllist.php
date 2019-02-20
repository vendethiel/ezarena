<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: urllist.php 2007/04/12 13:48:48 dcz Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/
//mxBB PORTAL
// YOU SHOULD SET HERE THE CORRECT PATH IN CASE YOUR PORTAL IN INSTALLED 
// IN A SUB FOLDER (STARTING FROM ROOT E.G. 'mxBB/')
$mx_root_path = './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
if ( @file_exists($mx_root_path . 'mx_meta.inc') ) {
	define( 'IN_PORTAL', true );
	if ( @file_exists( $mx_root_path . "mx_login.$phpEx" )) {
		define( 'MXBB27x', true );
	}
	include($mx_root_path . 'common.'.$phpEx);
	if ( defined('MXBB27x') ) {
		$userdata = session_pagestart($user_ip, PAGE_INDEX);
		mx_init_userprefs($userdata);
	} else {
		$mx_user->init($user_ip, PAGE_INDEX);
	}
	$paths = array(	'mxbb_url'	=> PORTAL_URL,
			'module_path'	=> $mx_root_path . 'modules/mx_ggsitemaps/',
			'lang_path'	=> $mx_root_path . 'modules/mx_ggsitemaps/',
	);
} else { // PHPBB
	define('IN_PHPBB', true);
	// YOU HAVE TO SET THE CORRECT PATH FOR PHPBB IF YOU WANT
	// TO USE THIS  SITEMAP SYSTEM OUTSIDE OF THE PHPBB FOLDER
	// Correct syntax : "./phpbb/"
	$phpbb_root_path = './';
	include($phpbb_root_path . 'extension.inc');
	include($phpbb_root_path . 'common.'.$phpEx);
	$paths = array(	'module_path'	=> $phpbb_root_path . 'includes/mx_ggsitemaps/',
			'lang_path'	=> $phpbb_root_path,
		);
	// Start session management
	$userdata = session_pagestart($user_ip, PAGE_INDEX);
	init_userprefs($userdata);
	// End session management
}
//set up all other paths
$paths['phpbb_path'] = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
$paths['phpbb_path'] = (trim($paths['phpbb_path'], "/") != "") ? trim($paths['phpbb_path'], "/") . '/' : '';
$server_name = trim($board_config['server_name']); 
$server_protocol = 'http://';
$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/'; 
$paths['root_url'] = 'http://' . $server_name . $server_port;
$paths['phpbb_url'] = $paths['root_url'] . $paths['phpbb_path'];
// Where is this file installed ?
// Backported from phpBB3
$script_name = (!empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : getenv('PHP_SELF');
if (!$script_name) {
	$script_name = (!empty($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
}
// Replace backslashes and doubled slashes (could happen on some proxy setups)
$script_name = str_replace(array('\\', '//'), '/', $script_name);
// The script path from the webroot to the current directory (for example: /phpBB2/adm/) : always prefixed with / and ends in /
$script_path = trim(str_replace('\\', '/', dirname($script_name)));
$script_path .= (substr($script_path, -1, 1) == '/') ? '' : '/';
$paths['yahoo_script_path'] = $script_path;
$paths['yahoo_url'] = trim($paths['root_url'], '/') . $script_path;
// In case this fails, just hard code the full url to the folder where this file is installed :
// $paths['yahoo_url'] = 'http://www.example.com/eventual_folder/';
if (defined('IN_PORTAL')) {
	$paths['mxbb_path'] = trim(str_replace($paths['root_url'], '', PORTAL_URL), "/");
	$paths['mxbb_path'] = ($paths['mxbb_path'] != '') ? $paths['mxbb_path']  . '/': '';
}
$action = 'yahoo';
$list_id = 0;
// Deal with forum auth
$not_auth_ary = array();
// We only want to output public content 
$sql = "SELECT forum_id
	FROM " . FORUMS_TABLE . "
	WHERE auth_view <> " . AUTH_ALL . "
	OR auth_read <> " . AUTH_ALL;
//Begin sql cache
if ( !$result = $db->sql_query( $sql ) ) {
//if( !($result = $db->sql_query($sql, false, 'GGS_')) ) {
//End sql cache 
	$this->mx_sitemaps_message_die(GENERAL_ERROR, 'Could not query forum data', '', __LINE__, __FILE__, $sql);
}
while ($row = $db->sql_fetchrow($result)) {
	$not_auth_ary[$row['forum_id']] = $row['forum_id'];
}
$db->sql_freeresult($result);
unset($row);

$actions = array(	'actions' 	=> $actions_from_file,
			'action' 	=> $action,
			'type' 		=> 'yahoo_',
			'list_id' 	=> $list_id,
			'not_auth' => $not_auth_ary,
		);
// Include common module stuff...
include($paths['module_path'] . 'includes/ggs_functions.' . $phpEx);
// GGSitemaps procedure (behind the class)...
$gym_sitemaps = new GGSitemaps( $actions, $paths);
exit;
?>
