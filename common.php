<?php
/***************************************************************************
 *                                common.php
 *                            -------------------
 *   begin                : Saturday, Feb 23, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : support@phpbb.com
 *
 *   $Id: common.php,v 1.74.2.23 2006/02/26 17:34:50 grahamje Exp $
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

// V: LOL date() notices
date_default_timezone_set(@date_default_timezone_get());

// V: ok no, far too many errors :'(
error_reporting  (E_ERROR | E_WARNING | E_PARSE); // This will NOT report uninitialized variables

error_reporting(-1);

@set_magic_quotes_runtime(0); // Disable magic_quotes_runtime
@ini_set('register_globals',0); 
@ini_set('variables_order','GPC'); 
@ini_set('register_argc_argv',0); 
@ini_set('expose_php',0); 
@ini_set('default_socket_timeout',10); 
@ini_set('allow_url_fopen',0);

// The following code (unsetting globals)
// Thanks to Matt Kavanagh and Stefan Esser for providing feedback as well as patch files

// PHP5 with register_long_arrays off?
if (@phpversion() >= '5.0.0' && (!@ini_get('register_long_arrays') || @ini_get('register_long_arrays') == '0' || strtolower(@ini_get('register_long_arrays')) == 'off'))
{
	$HTTP_POST_VARS = $_POST;
	$HTTP_GET_VARS = $_GET;
	$HTTP_SERVER_VARS = $_SERVER;
	$HTTP_COOKIE_VARS = $_COOKIE;
	$HTTP_ENV_VARS = $_ENV;
	$HTTP_POST_FILES = $_FILES;

	// _SESSION is the only superglobal which is conditionally set
	if (isset($_SESSION))
	{
		$HTTP_SESSION_VARS = $_SESSION;
	}
}

// Protect against GLOBALS tricks
if (isset($HTTP_POST_VARS['GLOBALS']) || isset($HTTP_POST_FILES['GLOBALS']) || isset($HTTP_GET_VARS['GLOBALS']) || isset($HTTP_COOKIE_VARS['GLOBALS']))
{
	die("Hacking attempt");
}

// Protect against HTTP_SESSION_VARS tricks
if (isset($HTTP_SESSION_VARS) && !is_array($HTTP_SESSION_VARS))
{
	die("Hacking attempt");
}

if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'off')
{
	// PHP4+ path
	$not_unset = array('HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_COOKIE_VARS', 'HTTP_SERVER_VARS', 'HTTP_SESSION_VARS', 'HTTP_ENV_VARS', 'HTTP_POST_FILES', 'phpEx', 'phpbb_root_path');

	// Not only will array_merge give a warning if a parameter
	// is not an array, it will actually fail. So we check if
	// HTTP_SESSION_VARS has been initialised.
	if (!isset($HTTP_SESSION_VARS) || !is_array($HTTP_SESSION_VARS))
	{
		$HTTP_SESSION_VARS = array();
	}

	// Merge all into one extremely huge array; unset
	// this later
	$input = array_merge($HTTP_GET_VARS, $HTTP_POST_VARS, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS, $HTTP_SESSION_VARS, $HTTP_ENV_VARS, $HTTP_POST_FILES);

	unset($input['input']);
	unset($input['not_unset']);

	while (list($var,) = @each($input))
	{
		if (in_array($var, $not_unset,TRUE)) 
		{ 
			die('Hacking attempt!'); 
		} 
		unset($$var);
	}

	unset($input);
}

//
// addslashes to vars if magic_quotes_gpc is off
// this is a security precaution to prevent someone
// trying to break out of a SQL statement.
//
if( !@get_magic_quotes_gpc() )
{
	if( is_array($HTTP_GET_VARS) )
	{
		while( list($k, $v) = each($HTTP_GET_VARS) )
		{
			if( is_array($HTTP_GET_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_GET_VARS[$k]) )
				{
					$HTTP_GET_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_GET_VARS[$k]);
			}
			else
			{
				$HTTP_GET_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_GET_VARS);
	}

	if( is_array($HTTP_POST_VARS) )
	{
		while( list($k, $v) = each($HTTP_POST_VARS) )
		{
			if( is_array($HTTP_POST_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_POST_VARS[$k]) )
				{
					if (!is_array($v2))
					{
						$HTTP_POST_VARS[$k][$k2] = addslashes($v2);
					}
				}
				@reset($HTTP_POST_VARS[$k]);
			}
			else
			{
				$HTTP_POST_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_POST_VARS);
	}

	if( is_array($HTTP_COOKIE_VARS) )
	{
		while( list($k, $v) = each($HTTP_COOKIE_VARS) )
		{
			if( is_array($HTTP_COOKIE_VARS[$k]) )
			{
				while( list($k2, $v2) = each($HTTP_COOKIE_VARS[$k]) )
				{
					$HTTP_COOKIE_VARS[$k][$k2] = addslashes($v2);
				}
				@reset($HTTP_COOKIE_VARS[$k]);
			}
			else
			{
				$HTTP_COOKIE_VARS[$k] = addslashes($v);
			}
		}
		@reset($HTTP_COOKIE_VARS);
	}
}

function microtime_float()  
{  
   list($usec, $sec) = explode(" ", microtime());  
   return ((float)$usec + (float)$sec);  
}  
 
$GLOBALS['page_gen_start'] = microtime_float();
//
// Define some basic configuration arrays this also prevents
// malicious rewriting of language and otherarray values via
// URI params
//
$board_config = array();
$announcement_centre_config = array();
$userdata = array();
$theme = array();
$images = array();
$lang = array();
$nav_links = array();
$gen_simple_header = FALSE;

include $phpbb_root_path . 'config.'.$phpEx;

if( !defined("PHPBB_INSTALLED") )
{
	header('Location: ' . $phpbb_root_path . 'install/install.' . $phpEx);
	exit;
}

include $phpbb_root_path . 'includes/constants.'.$phpEx;
include $phpbb_root_path . 'includes/template.'.$phpEx;
include $phpbb_root_path . 'includes/sessions.'.$phpEx;
include $phpbb_root_path . 'includes/auth.'.$phpEx;
include $phpbb_root_path . 'includes/functions.'.$phpEx;
include $phpbb_root_path . 'includes/db.'.$phpEx;
include $phpbb_root_path . 'includes/functions_points.'.$phpEx;
include $phpbb_root_path . 'includes/functions_topics.'.$phpEx;
include $phpbb_root_path . 'includes/functions_bbc_box.'.$phpEx;
include $phpbb_root_path . 'includes/class_common.' . $phpEx;
include $phpbb_root_path . 'includes/mods/index.' . $phpEx;

// We do not need this any longer, unset for safety purposes
unset($dbpasswd);

//
// Obtain and encode users IP
//
// I'm removing HTTP_X_FORWARDED_FOR ... this may well cause other problems such as
// private range IP's appearing instead of the guilty routable IP, tough, don't
// even bother complaining ... go scream and shout at the idiots out there who feel
// "clever" is doing harm rather than good ... karma is a great thing ... :)
//
$client_ip = ( !empty($HTTP_SERVER_VARS['REMOTE_ADDR']) ) ? $HTTP_SERVER_VARS['REMOTE_ADDR'] : ( ( !empty($HTTP_ENV_VARS['REMOTE_ADDR']) ) ? $HTTP_ENV_VARS['REMOTE_ADDR'] : getenv('REMOTE_ADDR') );
$user_ip = encode_ip($client_ip);

//
// Setup forum wide options, if this fails
// then we output a CRITICAL_ERROR since
// basic forum information is not available
//
//
//BEGIN ACP Site Announcement Centre by lefty74
$sql = "SELECT *
	FROM " . ANNOUNCEMENTS_LEFTY74_TABLE;
if( !($result = $db->sql_query($sql, false, 'announcement_centre')) )
{
	message_die(CRITICAL_ERROR, "Could not query site announcement information", "", __LINE__, __FILE__, $sql);
}

while ( $row = $db->sql_fetchrow($result) )
{
	$announcement_centre_config[stripslashes($row['announcement_desc'])] = stripslashes($row['announcement_value']);
}
$db->sql_freeresult($result);

$sql = "SELECT *
	FROM " . CONFIG_TABLE;
if( !($result = $db->sql_query($sql, false, 'config_')) )
{
	message_die(CRITICAL_ERROR, "Could not query config information", "", __LINE__, __FILE__, $sql);
}

while ( $row = $db->sql_fetchrow($result) )
{
	$board_config[$row['config_name']] = $row['config_value'];
}

if (!defined('NO_ATTACH_MOD'))
{
	include $phpbb_root_path . 'attach_mod/attachment_mod.'.$phpEx;
}

//-- mod : rank color system ---------------------------------------------------
// include rank color system file
include $phpbb_root_path . 'includes/class_rcs.' . $phpEx;

// instantiate rank color system class
$rcs = new rcs();

// grab rank color system variables, re-cache if necessary
$rcs->obtain_ids_colors();

//-- mod : birthday ------------------------------------------------------------
include $phpbb_root_path . 'includes/class_birthday.' . $phpEx;

// instantiate birthday object
$birthday = new birthday_class();
//-- fin mod : birthday --------------------------------------------------------
// www.phpBB-SEO.com SEO TOOLKIT BEGIN
include $phpbb_root_path . 'includes/phpbb_seo_class.'.$phpEx;
$phpbb_seo = new phpbb_seo();

// www.phpBB-SEO.com SEO TOOLKIT END
if (!DEBUG && (file_exists('install') || file_exists('contrib')))
{
	message_die(GENERAL_MESSAGE, 'Please_remove_install_contrib');
}

include_once($phpbb_root_path . 'adr/includes/adr_functions_alone.'.$phpEx);