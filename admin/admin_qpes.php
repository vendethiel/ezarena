<?php
/** 
*
* @package quick_post_es_mod
* @version $Id: admin_qpes.php,v 1.2 27/11/2006 16:04 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* begin process
*/
define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['General']['Quick_Post_ES'] = $file;
	return;
}

// load default header
$phpbb_root_path = './../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$requester = 'admin_qpes.';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

/**
* qpes settings process
*/

class qpes_settings
{
	var $requester;
	var $root;
	var $ext;

	function qpes_settings($requester)
	{
		global $phpbb_root_path, $phpEx;

		$this->requester = $requester;
		$this->root = &$phpbb_root_path;
		$this->ext = &$phpEx;
	}

	function get_options_list()
	{
		return array(
			array('title' => 'qp_enable', 'desc' => 'qp_enable_explain', 'user_var' => 'user_qp', 'anon_var' => 'anon_qp'),
			array('title' => 'qp_show', 'desc' => 'qp_show_explain', 'user_var' => 'user_qp_show', 'anon_var' => 'anon_qp_show'),
			array('title' => 'qp_subject', 'desc' => 'qp_subject_explain', 'user_var' => 'user_qp_subject', 'anon_var' => 'anon_qp_subject'),
			array('title' => 'qp_bbcode', 'desc' => 'qp_bbcode_explain', 'user_var' => 'user_qp_bbcode', 'anon_var' => 'anon_qp_bbcode'),
			array('title' => 'qp_smilies', 'desc' => 'qp_smilies_explain', 'user_var' => 'user_qp_smilies', 'anon_var' => 'anon_qp_smilies'),
			array('title' => 'qp_more', 'desc' => 'qp_more_explain', 'user_var' => 'user_qp_more', 'anon_var' => 'anon_qp_more'),
		);
	}

	function _achievement($l_key)
	{
		global $lang;

		$message = $lang[$l_key] . '<br /><br />' . sprintf($lang['qp_click_return_config'], '<a href="' . append_sid($this->requester . $this->ext) . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid('index.' . $this->ext . '?pane=right') . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	
		return;
	}
}

/**
* qpes config process
*/

class qpes_config extends qpes_settings
{
	var $cfg;

	function process()
	{
		$this->init();
		$this->display();
	}

	function init()
	{
		global $board_config, $new;

		$this->cfg = &$new;
	}

	function display()
	{
		global $board_config, $template, $lang;

		// get options
		$options = $this->get_options_list();

		// build options form
		foreach ($options as $option => $result)
		{
			// options constants
			$template->assign_block_vars('qpes', array(
				'L_QP_TITLE' => $lang[$result['title']],
				'L_QP_DESC' => $lang[$result['desc']],

				'USER_QP_VAR' => $result['user_var'],
				'ANON_QP_VAR' => $result['anon_var'],

				'USER_QP_YES' => ($this->cfg[$result['user_var']]) ? ' checked="checked"' : '',
				'USER_QP_NO' => (!$this->cfg[$result['user_var']]) ? ' checked="checked"' : '',

				'ANON_QP_YES' => ($this->cfg[$result['anon_var']]) ? ' checked="checked"' : '',
				'ANON_QP_NO' => (!$this->cfg[$result['anon_var']]) ? ' checked="checked"' : '',
			));
		}

		// display
		$template->set_filenames(array('body' => 'admin/qpes_body.tpl'));
	}
}

/**
* main process
*/

// instantiate common class
$common = new common();

// instantiate some objects
$qpes_config = new qpes_config($requester);

// initialize
$user_qp = $user_qp_show = $user_qp_subject = $user_qp_bbcode = $user_qp_smilies = $user_qp_more = 0;
$anon_qp = $anon_qp_show = $anon_qp_subject = $anon_qp_bbcode = $anon_qp_smilies = $anon_qp_more = 0;

// get qpes data
if (!empty($board_config['users_qp_settings']))
{
	list($user_qp, $user_qp_show, $user_qp_subject, $user_qp_bbcode, $user_qp_smilies, $user_qp_more) = explode('-', $board_config['users_qp_settings']);
}

if (!empty($board_config['anons_qp_settings']))
{
	list($anon_qp, $anon_qp_show, $anon_qp_subject, $anon_qp_bbcode, $anon_qp_smilies, $anon_qp_more) = explode('-', $board_config['anons_qp_settings']);
}

// grab qpes config
$qpes_config_ary = array('users_qp_settings', 'anons_qp_settings');
$sql = 'SELECT config_name, config_value
	FROM ' . CONFIG_TABLE . '
	WHERE config_name IN (\'' . implode('\', \'', $qpes_config_ary) . '\')';
if (!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, 'Could not query config qpes data', '', __LINE__, __FILE__, $sql);
}

while ($row = $db->sql_fetchrow($result))
{
	$config_name = $row['config_name'];
	$config_value = $row['config_value'];

	$def[$config_name] = $config_value;
	$new[$config_name] = (_butt('submit_form')) ? request_var($config_name, TYPE_INT) : $def[$config_name];

	$params = array(
		'user_qp', 'user_qp_show', 'user_qp_subject', 'user_qp_bbcode', 'user_qp_smilies', 'user_qp_more',
		'anon_qp', 'anon_qp_show', 'anon_qp_subject', 'anon_qp_bbcode', 'anon_qp_smilies', 'anon_qp_more',
	);
	for ($i = 0; $i < count($params); $i++)
	{
		$new[$params[$i]] = (isset($HTTP_POST_VARS[$params[$i]])) ? intval($HTTP_POST_VARS[$params[$i]]) : intval($$params[$i]);
	}

	$users_qp_settings = array($new['user_qp'], $new['user_qp_show'], $new['user_qp_subject'], $new['user_qp_bbcode'], $new['user_qp_smilies'], $new['user_qp_more']);
	$anons_qp_settings = array($new['anon_qp'], $new['anon_qp_show'], $new['anon_qp_subject'], $new['anon_qp_bbcode'], $new['anon_qp_smilies'], $new['anon_qp_more']);
	$new['users_qp_settings'] = implode('-', $users_qp_settings);
	$new['anons_qp_settings'] = implode('-', $anons_qp_settings);

	if (_butt('submit_form') && $def[$config_name] != $new[$config_name])
	{
		$common->set_config($config_name, $new[$config_name]);
	}
}
$db->sql_freeresult($result);

// submitted
if (_butt('submit_form'))
{
	// send achievement message
	$qpes_config->_achievement('qp_config_updated');
}

// let's go
$qpes_config->process();

// constants
$template->assign_vars(array(
	'S_QPES_ACTION' => append_sid($requester . $phpEx),

	'L_QP_CONFIGURATION_TITLE' => $lang['qp_config_title'],
	'L_QP_CONFIGURATION_DESC' => $lang['qp_config_title_desc'],

	'L_QP_SETTINGS' => $lang['qp_settings'],
	'L_QP_USER' => $lang['qp_user'],
	'L_QP_ANON' => $lang['qp_anon'],

	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_SUBMIT' => $lang['Submit'], 

	'I_SUBMIT' => $phpbb_root_path . $images['cmd_submit'],
));

// send the display
$template->pparse('body');
include('./page_footer_admin.' . $phpEx);

?>