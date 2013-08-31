<?php
/**
*
* @package lang_settings_mod
* @version $Id: lang_extend_mac.php,v 0.2 07/05/2006 09:42 reddog Exp $
* @copyright (c) 2006 Ptirhiik - http://ptifo.clanmckeen.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

if (defined('LANG_EXTEND_DONE'))
{
	return;
}

// check for admin part
$lang_extend_admin = defined('IN_ADMIN');

// get the english settings
$phpExLen = strlen($phpEx);
// get the user settings
$t = microtime();
if ( !empty($board_config['default_lang']) )
{
	$dir = @opendir($lang_dir = $phpbb_root_path . 'language/lang_' . $board_config['default_lang']);
	while( $file = @readdir($dir) )
	{
		if ( 0 === strpos($file, 'lang_extend_') && substr($file, -$phpExLen) == $phpEx )
		{
			include $lang_dir . '/' . $file;
		}
	}

	// include the customizations
	if ( @file_exists(@phpbb_realpath($lang_dir . '/lang_extend' . $phpEx)) )
	{
		include($lang_dir . '/lang_extend' . $phpEx);
	}
	@closedir($dir);
}

// define lang extend done
define('LANG_EXTEND_DONE', true);