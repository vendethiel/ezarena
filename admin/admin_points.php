<?php
/***************************************************************************
 *                               admin_points.php
 *                            -------------------
 *   begin                : Sunday, April 14, 2002
 *   copyright            : (C) 2002 Bulletin Board Mods
 *   email                : robbie@robbieshields.net
 *
 *   $Id: mod_install.php,v 1.0.1 2003/12/08 17:13:00 Robbie Shields Exp $
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

if (!empty($setmodules))
{
	$file = basename(__FILE__);
	$module['ADR-Points']['Points_Configuration'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = '../';
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);

if (isset($HTTP_POST_VARS['submit']))
{
	$reset_points = $HTTP_POST_VARS['reset_points'];
	if($reset_points != "")
	{
		$sql = "SELECT user_id FROM " . USERS_TABLE . " 
			WHERE user_id != " . ANONYMOUS;
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain User Data', '', __LINE__, __FILE__, $sql);
		}
		$users = $db->sql_fetchrowset($result);
		$total_users = count($users);

		for($i = 0; $i < $total_users; $i++)
		{
			$user_id = $users[$i]['user_id'];
			$points = intval($reset_points);

			$sql = "UPDATE " . USERS_TABLE . " 
				SET user_points = $points
				WHERE user_id = " . $user_id;
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could Not Update Users Data', '', __LINE__, __FILE__, $sql);
			}
		}
	}
}

$sql = "SELECT *
	FROM " . CONFIG_TABLE . "
	WHERE config_name IN('points_reply', 'points_topic', 'points_post', 'points_poll', 'points_vote', 'points_browse', 'points_page', 'points_donate', 'points_name', 'points_user_group_auth_ids')";
if (!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, 'Could not query points config information in admin_points', '', __LINE__, __FILE__, $sql);
}
else
{
	while ($row = $db->sql_fetchrow($result))
	{
		$config_name = $row['config_name'];
		$config_value = $row['config_value'];
		$default_config[$config_name] = $config_value;

		$new[$config_name] = (isset($HTTP_POST_VARS[$config_name])) ? $HTTP_POST_VARS[$config_name] : $default_config[$config_name];

		if (isset($HTTP_POST_VARS['submit']))
		{
			$sql = "UPDATE " . CONFIG_TABLE . "
				SET config_value = '" . str_replace("\'", "''", $new[$config_name]) . "'
				WHERE config_name = '$config_name'";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, "Failed to update points configuration for $config_name", '', __LINE__, __FILE__, $sql);
			}
		}
	}

	if (isset($HTTP_POST_VARS['submit']))
	{
		$message = $lang['Points_updated'] . '<br /><br />' . sprintf($lang['Click_return_points'], '<a href="' . append_sid("admin_points.$phpEx") . '">', '</a>') . '<br /><br />' . sprintf($lang['Click_return_admin_index'], '<a href="' . append_sid("index.$phpEx?pane=right") . '">', '</a>');
		message_die(GENERAL_MESSAGE, $message);
	}
}

$points_post_yes = ($new['points_post']) ? 'checked="checked"' : '';
$points_post_no	 = (!$new['points_post']) ? 'checked="checked"' : '';

$points_poll_yes = ($new['points_poll']) ? 'checked="checked"' : '';
$points_poll_no = (!$new['points_poll']) ? 'checked="checked"' : '';

$points_browse_yes = ($new['points_browse']) ? 'checked="checked"' : '';
$points_browse_no	 = (!$new['points_browse']) ? 'checked="checked"' : '';

$points_donate_yes = ($new['points_donate']) ? 'checked="checked"' : '';
$points_donate_no  = (!$new['points_donate']) ? 'checked="checked"' : '';

$points_reply = $new['points_reply'];
$points_topic = $new['points_topic'];
$points_vote = $new['points_vote'];
$points_page = $new['points_page'];
$points_name = $new['points_name'];
$points_user_group_auth = $new['points_user_group_auth_ids'];

$template->set_filenames(array(
	'body' => 'admin/points_config_body.tpl')
);

$template->assign_vars(array(
	'S_CONFIG_ACTION' => append_sid("admin_points.$phpEx"),
 
	'L_YES' => $lang['Yes'],
	'L_NO' => $lang['No'],
	'L_SUBMIT' => $lang['Submit'],
	'L_RESET' => $lang['Reset'],
	'L_CONFIGURATION_TITLE' => $lang['Points_cp'],
	'L_CONFIGURATION_EXPLAIN' => $lang['Points_config_explian'],
	'L_SYS_SETTINGS' => $lang['Points_sys_settings'] . " [v" . $board_config['points_system_version'] . "]",
	'L_ENABLE_POST' => sprintf($lang['Points_enable_post'], $board_config['points_name']),
	'L_ENABLE_BROWSE' => sprintf($lang['Points_enable_browse'], $board_config['points_name']),
	'L_ENABLE_DONATION' => $lang['Points_enable_donation'],
	'L_POINTS_NAME' => $lang['Points_name'],
	'L_PER_REPLY' => $lang['Points_per_reply'],
	'L_PER_TOPIC' => $lang['Points_per_topic'],
	'L_PER_PAGE' => $lang['Points_per_page'],
	'L_USER_GROUP_AUTH' => $lang['Points_user_group_auth'],
	'L_ENABLE_POST_EXPLAIN' => sprintf($lang['Points_enable_post_explain'], $board_config['points_name']),
	'L_ENABLE_BROWSE_EXPLAIN' => sprintf($lang['Points_enable_browse_explain'], $board_config['points_name']),
	'L_ENABLE_DONATION_EXPLAIN' => sprintf($lang['Points_enable_donation_explain'], $board_config['points_name']),
	'L_POINTS_NAME_EXPLAIN' => $lang['Points_name_explain'],
	'L_PER_REPLY_EXPLAIN' => sprintf($lang['Points_per_reply_explain'], $board_config['points_name']),
	'L_PER_TOPIC_EXPLAIN' => sprintf($lang['Points_per_topic_explain'], $board_config['points_name']),
	'L_PER_PAGE_EXPLAIN' => sprintf($lang['Points_per_page_explain'], $board_config['points_name']),
	'L_USER_GROUP_AUTH_EXPLAIN' => $lang['Points_user_group_auth_explain'],
	'L_POINTS_RESET' => $lang['Points_reset'],
	'L_POINTS_RESET_EXPLAIN' => $lang['Points_reset_explain'],

	'S_POINTS_POST_YES' => $points_post_yes,
	'S_POINTS_POST_NO' => $points_post_no,
	'S_POINTS_BROWSE_YES' => $points_browse_yes,
	'S_POINTS_BROWSE_NO' => $points_browse_no,
	'S_POINTS_DONATE_YES' => $points_donate_yes,
	'S_POINTS_DONATE_NO' => $points_donate_no,
	'S_POINTS_REPLY' => $points_reply,
	'S_POINTS_TOPIC' => $points_topic,
	'S_POINTS_PAGE' => $points_page,
	'S_POINTS_NAME' => $points_name,
	'S_USER_GROUP_AUTH' => $points_user_group_auth,
	'S_HIDDEN_FIELDS' => '')
);

//
// Generate the page
//
$template->pparse('body');

include('page_footer_admin.' . $phpEx);

?>