<?php
/**
*
* @package rank_color_system_mod
* @version $Id: admin_versions.php,v 0.1 06/12/2006 18:33 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* begin process
*/

define('IN_PHPBB', 1);
define('VERSION_CHECK_DELAY', 86400);

if ( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Versions'] = $file;

	return;
}

// load default header
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin/admin_versions';
require('./pagestart.' . $phpEx);

class acp_versions
{
	var $root;
	var $ext;

	var $requester;
	var $parms;
	var $data;

	function acp_versions($requester, $parms='')
	{
		global $phpbb_root_path, $phpEx;

		$this->root = &$phpbb_root_path;
		$this->ext = &$phpEx;

		$this->requester = $requester;
		$this->parms = empty($parms) ? array() : $parms;
		$this->data = array();
	}

	function read()
	{
		$this->data = array(
			'phpBB' => array(
				'author' => 'phpBB Group',
				'author_url' => 'http://www.phpbb.com',
				'infos' => 'Mailing_list_subscribe_reminder',
				'host' => 'www.phpbb.com',
				'file' => '/updatecheck/20x.txt',
				'protocol' => 'phpbb',
				'mods' => array(
					'version' => array('name' => 'phpBB', 'desc' => '', 'page' => 'http://www.phpbb.com/downloads.php', 'head' => '2'),
				),
			),
			'reddog' => array(
				'author' => 'reddog',
				'author_url' => 'http://www.reddevboard.com',
				'host' => 'www.reddevboard.com',
				'file' => '/files/versions/versions.dta',
				'protocol' => 'multiple',
				'mods' => array(
					'rcs_version' => array('name' => 'mod_rcs_title', 'desc' => 'mod_rcs_explain', 'page' => 'http://www.reddevboard.com/forum/viewtopic.php?t=1505'),
					'class_common_version' => array('name' => 'Class Common', 'desc' => '', 'page' => 'http://www.reddevboard.com/forum/viewtopic.php?t=2497'),
				),
			),
			//-- mod : quick title edition -------------------------------------------------
//-- add
			'oxygen_powered' => array(
				'author' => 'OxyGen Powered',
				'author_url' => 'http://www.oxygen_powered.net',
				'host' => 'abdev.free.fr',
				'file' => '/versions/versions.dta',
				'protocol' => 'multiple',
				'mods' => array(
					'qte_version' => array('name' => 'mod_qte_title', 'desc' => 'mod_qte_explain', 'page' => 'http://www.oxygen-powered.net/viewtopic.php?t=300'),
				),
			),
//-- fin mod : quick title edition ---------------------------------------------

//-- premod : ultimarena -------------------------------------------------
//-- add
			'joebart' => array(
				'author' => 'joebart',
				'author_url' => 'http://ultimarena.net',
				'host' => 'joebart72.free.fr',
				'file' => '/version.txt',
				'protocol' => 'multiple',
				'mods' => array(
					'ultimarena_version' => array('name' => 'ultimarena', 'desc' => '', 'page' => 'http://ultimarena.net/'),
				),
			),
//-- fin premod : ultimarena ---------------------------------------------			
			'ezarena' => array(
				'author' => 'Informpro',
				'author_url' => 'http://github.com/vendethiel/ezarena',
				'host' => '',
				'file' => '', ///files/versions/ezarena.dta',
				'protocol' => 'multiple',
				'mods' => array(
					'ezarena_version' => array('name' => 'ezarena', 'desc' => '', 'page' => 'http://ezcom-fr.com')
				),
			),
		);
	}

	function refresh($force=false)
	{
		global $board_config, $common;

		// we don't want to check at any time : do it only once a day
		if ( !$force |= !intval($board_config['version_check_delay']) || (time() - intval($board_config['version_check_delay']) > VERSION_CHECK_DELAY) )
		{
			return;
		}
		foreach ( $this->data as $provider => $info )
		{
			// get remote file
			$content = $this->get_remote_file($provider);

			// analyse content
			switch ( $info['protocol'] )
			{
				case 'phpbb':
					$this->process_phpbb($provider, $content);
					break;
				case 'multiple':
					$this->process_multiple($provider, $content);
					break;
			}
		}
		$common->set_config('version_check_delay', time());
	}

	function get_remote_file($provider)
	{
		$res = '';
		$this->data[$provider]['errno'] = 0;
		$this->data[$provider]['errstr'] = '';
		if ( $fsock = @fsockopen($this->data[$provider]['host'], 80, $this->data[$provider]['errno'], $this->data[$provider]['errstr'], 10) )
		{
			$lf = "\r\n";
			@fputs($fsock, 'GET ' . $this->data[$provider]['file'] . ' HTTP/1.1' . $lf);
			@fputs($fsock, 'HOST: ' . $this->data[$provider]['host'] . $lf);
			@fputs($fsock, 'Connection: close' . $lf . $lf);

			$get_info = false;
			while ( !@feof($fsock) )
			{
				if ( $get_info || (($get_info = @fgets($fsock, 1024) == $lf) && !@feof($fsock)) )
				{
					$res .= @fread($fsock, 1024);
				}
			}
		}
		@fclose($fsock);

		return trim($res);
	}

	function process_phpbb($provider, $content)
	{
		global $board_config;

		if ( empty($content) )
		{
			return;
		}

		$mod_data = array();
		$content = explode("\n", $content);
		$count_content = count($content);
		for ( $i = 0; $i < $count_content; $i++ )
		{
			$content[$i] = intval(trim(preg_replace("/[\r\n]/", '', $content[$i])));
		}
		$mod_name = 'version';
		$mod_data = array(
			'latest' => implode('.', array_splice($content, 0, 3)),
		);
		if ( !empty($mod_name) && !empty($mod_data['latest']) )
		{
			$this->data[$provider]['mods'][$mod_name] = array_merge($this->data[$provider]['mods'][$mod_name], $mod_data);
		}
		unset($mod_data);
	}

	function process_multiple($provider, $content)
	{
		global $board_config;

		if ( empty($content) )
		{
			return;
		}

		$mod_data = array();
		$content = explode("\n", $content);
		$count_content = count($content);
		for ( $i = 0; $i < $count_content; $i++ )
		{
			$str = trim(preg_replace("/[\r\n]/", '', $content[$i]));
			$line = empty($str) ? array() : explode(':', $str);
			$mod_name = trim($line[0]);
			$mod_data = array(
				'latest' => trim($line[1]),
				'announcement' => empty($line[2]) ? '' : trim(htmlspecialchars($line[2])),
			);
			if ( !empty($mod_name) && !empty($mod_data['latest']) && isset($this->data[$provider]['mods'][$mod_name]) )
			{
				$this->data[$provider]['mods'][$mod_name] = array_merge($this->data[$provider]['mods'][$mod_name], $mod_data);
			}
		}
		unset($mod_data);
	}

	function display()
	{
		global $board_config, $template, $lang;
		global $get;

		if ( !empty($this->data) )
		{
			foreach ( $this->data as $provider => $data )
			{
				// process author
				$template->assign_block_vars('author', array(
					'AUTHOR' => empty($data['author']) ? $provider : $data['author'],
					'AUTHOR_INFO' => lang_item($data['infos']),
					'U_AUTHOR' => $data['author_url'],
				));
				$get->assign_switch('author.info', !empty($data['infos']));
				$get->assign_switch('author.link', !empty($data['author_url']));

				// process error
				if ( !empty($this->data[$provider]['errno']) )
				{
					$template->assign_block_vars('author.error_msg', array(
						'ERROR_MSG' => $this->data[$provider]['errstr'] ? sprintf($lang['version_socket_error'], $this->data[$provider]['errstr']) : $lang['version_socket_disabled'],
					));
				}

				// dump the mods
				if ( empty($this->data[$provider]['errno']) && !empty($this->data[$provider]['mods']) )
				{
					foreach ( $this->data[$provider]['mods'] as $mod_name => $mod_data )
					{
						// get current version
						$mod_data['current'] = $mod_data['head'] . ($board_config[$mod_name] ? $board_config[$mod_name] : ( defined(strtoupper($mod_name)) ? constant(strtoupper($mod_name)) : '' ));

						$template->assign_block_vars('author.mod', array(
							'NAME' => lang_item($mod_data['name']),
							'DESC' => lang_item($mod_data['desc']),
							'U_PAGE' => $mod_data['page'],
							'ANNOUNCEMENT' => empty($mod_data['announcement']) ? '' : sprintf($lang['version_announcement'], $mod_data['announcement']),
							'CURRENT_VERSION' => $mod_data['current'],
							'LATEST_VERSION' => $mod_data['latest'],
						));
						$get->assign_switch('author.mod.desc', !empty($mod_data['desc']));
						$get->assign_switch('author.mod.page', !empty($mod_data['page']));
						$get->assign_switch('author.mod.announcement', !empty($mod_data['announcement']));
						$get->assign_switch('author.mod.latest', !empty($mod_data['latest']));

						// check results
						$up_to_date = version_compare(strtolower($mod_data['current']), strtolower($mod_data['latest']), '<') ? false : true;
						$get->assign_switch('author.mod.success', !empty($up_to_date) && !empty($mod_data['latest']));
						$get->assign_switch('author.mod.error', empty($up_to_date) && !empty($mod_data['latest']));
						$get->assign_switch('author.mod.unchecked', empty($mod_data['latest']));
						if ( !empty($mod_data['latest']) )
						{
							$get->assign_switch('author.mod.latest.success', !empty($up_to_date));
						}
					}
				}
			}
		}
	}
}

/**
* main process
*/

// init some objects
$common = new common();

// version verification
$versions = new acp_versions($requester, array('pane' => 'right'));
$versions->read();
$versions->refresh(request_var('vchk', TYPE_INT));
$versions->display();
unset($versions);

// constants
$template->assign_vars(array(
	'L_VERSIONS_CHECK' => $lang['versions_check'],
	'L_VERSIONS_CHECK_EXPLAIN' => $lang['versions_check_explain'],
	'L_VERSION_INFORMATION' => $lang['version_information'],
	'L_CURRENT_VERSION' => $lang['version_current_info'],
	'L_LATEST_VERSION' => $lang['version_stable_info'],

	'L_VERSION_UP_TO_DATE' => $lang['version_stable'],
	'L_VERSION_NOT_UP_TO_DATE' => $lang['version_not_stable'],

	'I_CHECK' => $phpbb_root_path . $images['cmd_check'],
	'L_CHECK' => $lang['version_check'],
	'U_CHECK' => $get->url($requester, array('pane' => 'right', 'vchk' => true), true),
));

// send the display
$template->set_filenames(array('body' => 'admin/versions_body.tpl'));
$template->pparse('body');
include($get->url('admin/page_footer_admin'));

?>