<?php
//
//	file: language/lang_english/lang_sf.php
//	author: ptirhiik
//	begin: 03/10/2006
//	version: 0.0.1 - 06/10/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$lang = array(
	'sf_Run_install' => 'Please run %sthe SF installation%s',
	'sf_Delete_install' => 'Please remove the install_sf/ directory',
	'sf_Subforums' => 'Sous-forums',

) + (defined('IN_INSTALL') ? array(
	'sf_Install' => 'SF Installation',
	'sf_previous_version' => 'Version previously running',
	'sf_current_version' => 'Version to install',
	'sf_SQL_failed' => 'failed',
	'sf_SQL_succeed' => 'succeed',
	'sf_SQL_Error' => 'The installation has failed to create correctly the phpbb_forums.forum_parent field. Do it manually, then relaunch the installation.',
	'sf_Forum_tree_ordered' => 'Some forums orders have been adjusted. Please recheck the forums tree in the ACP/Forum management.',
	'sf_Install_done' => 'The SF installation has succeed.',
	'sf_Back_to_index'=> 'Click here to return to the board index',

) : array()) + (defined('IN_ADMIN') ? array(
	'sf_Forum_parent' => 'Attaché à',
	'sf_Forum_parent_not_exist' => 'Le forum parent n\'existe pas.',
	'sf_Forum_not_empty' => 'Ce forum a des sous-forums. Veuillez les déplacer ou les supprimer d\'abord.',

) : array());