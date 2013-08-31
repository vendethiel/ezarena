<?php
/**
*
* @package quick_post_es_mod
* @version $Id: qpes.php,v 1.10 21/08/2006 10:40 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

/**
* begin process
*/
$phpEx = substr(strrchr(__FILE__, '.'), 1);
$phpbb_root_path = './';

// initialize vars
$qp_lvl = ($userdata['session_logged_in'] && ($userdata['user_level'] == ADMIN)) ? true : false;
$qp_logged = ($userdata['session_logged_in']) ? true : false;
$qp_form = $qp_show = $qp_subject = $qp_bbcode = $qp_smilies = $qp_more = 0;
$user_qp = $user_qp_show = $user_qp_subject = $user_qp_bbcode = $user_qp_smilies = $user_qp_more = 0;
$anon_qp = $anon_qp_show = $anon_qp_subject = $anon_qp_bbcode = $anon_qp_smilies = $anon_qp_more = 0;

// config data
if (!empty($board_config['users_qp_settings']))
{
	list($board_config['user_qp'], $board_config['user_qp_show'], $board_config['user_qp_subject'], $board_config['user_qp_bbcode'], $board_config['user_qp_smilies'], $board_config['user_qp_more']) = explode('-', $board_config['users_qp_settings']);
}

if (!empty($board_config['anons_qp_settings']))
{
	list($anon_qp, $anon_qp_show, $anon_qp_subject, $anon_qp_bbcode, $anon_qp_smilies, $anon_qp_more) = explode('-', $board_config['anons_qp_settings']);
}

// user data
if (!empty($userdata['user_qp_settings']))
{
	list($user_qp, $user_qp_show, $user_qp_subject, $user_qp_bbcode, $user_qp_smilies, $user_qp_more) = explode('-', $userdata['user_qp_settings']);
}

// set toggles for various options
$html_on = ( !$board_config['allow_html'] ) ? 0 : ( ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['disable_html']) ) ? 0 : TRUE ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? $board_config['allow_html'] : $userdata['user_allowhtml'] ) );
$bbcode_on = ( !$board_config['allow_bbcode'] ) ? 0 : ( ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['disable_bbcode']) ) ? 0 : TRUE ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? $board_config['allow_bbcode'] : $userdata['user_allowbbcode'] ) );
$smilies_on = ( !$board_config['allow_smilies'] ) ? 0 : ( ( $submit || $refresh ) ? ( ( !empty($HTTP_POST_VARS['disable_smilies']) ) ? 0 : TRUE ) : ( ( $userdata['user_id'] == ANONYMOUS ) ? $board_config['allow_smilies'] : $userdata['user_allowsmile'] ) );

/**
* main process
*/
if ( !( ( !$is_auth['auth_reply'] || $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED ) && $userdata['user_level'] != ADMIN ) )
{
	// show quick post form
	if (
		$board_config['user_qp'] && $user_qp && $qp_logged ||
		$anon_qp && !$qp_logged ||
		$user_qp && $qp_lvl )
	{
		$qp_form = true;
		$template->assign_block_vars('qp_form', array());
	}

	// html toggle selection
	$html_status = $lang['HTML_is_OFF'];
	if ($board_config['allow_html'])
	{
		$html_status = $lang['HTML_is_ON'];
		$template->assign_block_vars('html_checkbox', array());
	}

	// bbcode toggle selection
	$bbcode_status = $lang['BBCode_is_OFF'];
	if ($board_config['allow_bbcode'])
	{
		$bbcode_status = $lang['BBCode_is_ON'];
		$template->assign_block_vars('bbcode_checkbox', array());
	}

	// smilies toggle selection
	$smilies_status = $lang['Smilies_are_OFF'];
	if ($board_config['allow_smilies'])
	{
		$smilies_status = $lang['Smilies_are_ON'];
		$template->assign_block_vars('smilies_checkbox', array());
	}

	// check quick post options and display its
	$dta_users = array('user_qp_show', 'user_qp_subject', 'user_qp_bbcode', 'user_qp_smilies', 'user_qp_more');
	$dta_anons = array('anon_qp_show', 'anon_qp_subject', 'anon_qp_bbcode', 'anon_qp_smilies', 'anon_qp_more');

	// more options
	$attach_sig = ($userdata['session_logged_in']) ? $userdata['user_attachsig'] : 0;
	$notify_user = ($userdata['session_logged_in']) ? $userdata['user_notify'] : 0;

	for($i = 0; $i < count($dta_users); $i++)
	{
		if (
			$board_config[$dta_users[$i]] && $$dta_users[$i] && $qp_logged ||
			$$dta_anons[$i] && !$qp_logged ||
			$$dta_users[$i] && $qp_lvl )
		{
			$qp_action = str_replace('user_', '', $dta_users[$i]);
			$$qp_action = 1;
			$template->assign_block_vars($qp_action, array());

			if (!empty($qp_more) && $userdata['session_logged_in'])
			{
				$template->assign_block_vars('qp_more.logged', array(
					'ATTACH_SIGNATURE' => (!empty($attach_sig)) ? ' checked="checked"' : '',
					'NOTIFY_ON_REPLY' => (!empty($notify_user)) ? ' checked="checked"' : '',
				));
			}
		}
	}

	// lite or full form?
	$qp_lite = (!$qp_subject && !$qp_bbcode && !$qp_smilies && !$qp_more) ? true : false;

	// display button
	if (!$qp_show)
	{
		$qp_url = 'javascript:qp_switch(\'qp_box\');';
		$qp_img = ( $forum_topic_data['forum_status'] == FORUM_LOCKED || $forum_topic_data['topic_status'] == TOPIC_LOCKED ) ? $images['reply_locked'] : $images['qp_button'];

		$template->assign_block_vars('qp_form.qp_button', array(
			'I_QPES' => $qp_img,
			'L_QPES_ALT' => $lang['qp_quick_post'],
			'U_QPES' => $qp_url,
		));
	}
	
	// username select
	if (!$userdata['session_logged_in'])
	{
		$qp_block_select = (!empty($qp_lite)) ? 'qpl_select' : 'qpm_select';
		$template->assign_block_vars($qp_block_select, array());
	}

	// font size combobox
	$size_types_text = array($lang['font_tiny'], $lang['font_small'], $lang['font_normal'], $lang['font_large'], $lang['font_huge']);
	$size_types = array('7', '9', '12', '18', '24');

	$select_font_size = '<select name="addbbcodefontsize" onchange="bbfontstyle(\'[size=\' + this.form.addbbcodefontsize.options[this.form.addbbcodefontsize.selectedIndex].value + \']\', \'[/size]\');this.form.addbbcodefontsize.selectedIndex = 2;" onmouseover="helpline(\'f\')">';
	for ($i = 0; $i < count($size_types_text); $i++)
	{
		$selected = ( $i == 2 ) ? ' selected="selected"' : '';
		$select_font_size .= '<option value="' . $size_types[$i] . '"' . $selected . '>' . $size_types_text[$i] . '</option>';
	}
	$select_font_size .= '</select>';

	// font color combobox
	$font_types_text = array($lang['color_default'], $lang['color_dark_red'], $lang['color_red'], $lang['color_orange'], $lang['color_brown'], $lang['color_yellow'], $lang['color_green'], $lang['color_olive'], $lang['color_cyan'], $lang['color_blue'], $lang['color_dark_blue'], $lang['color_indigo'], $lang['color_violet'], $lang['color_white'], $lang['color_black']);
	$font_types = array($theme['fontcolor1'], 'darkred', 'red', 'orange', 'brown', 'yellow', 'green', 'olive', 'cyan', 'blue', 'darkblue', 'indigo', 'violet', 'white', 'black');

	$select_font_color = '<select name="addbbcodefontcolor" onchange="bbfontstyle(\'[color=\' + this.form.addbbcodefontcolor.options[this.form.addbbcodefontcolor.selectedIndex].value + \']\', \'[/color]\');this.form.addbbcodefontcolor.selectedIndex = 0;" onmouseover="helpline(\'s\')">';
	for ($i = 0; $i < count($font_types_text); $i++)
	{
		$selected = ( $i == 0 ) ? ' selected="selected"' : '';
		$select_font_color .= '<option style="color:' . $font_types[$i] . '" value="' . $font_types[$i] . '"' . $selected . '>' . $font_types_text[$i] . '</option>';
	}
	$select_font_color .= '</select>';

	// generate smilies box
	if (!empty($qp_smilies))
	{
		generate_smilies_box();
	}

	// build hidden fields
	$s_hidden_fields = array(
		'sid' => $userdata['session_id'],
		'mode' => 'reply',
		POST_TOPIC_URL => intval($topic_id),
	);

	// check attach sig
	if (($qp_lite || !$qp_lite && !$qp_more) && $attach_sig)
	{
		$s_hidden_fields = array_merge($s_hidden_fields, array(
			'attach_sig' => $userdata['user_attachsig'],
		));
	}

	// send hidden fields
	_hide_build($s_hidden_fields);
	_hide_send();

        // sent to template
        $template->assign_vars(array(
		'HTML_STATUS' => $html_status,
		'BBCODE_STATUS' => sprintf($bbcode_status, '<a href="' . append_sid('faq.' . $phpEx . '?mode=bbcode') . '" target="_phpbbcode">', '</a>'),
		'SMILIES_STATUS' => $smilies_status,
		'QP_ROWSPAN' => ($qp_more && $qp_logged) ? ' rowspan="2"' : '',
		'QP_DISPLAY' => ($qp_show) ? 'block' : 'none',
		'QP_WIDTH' => ($qp_lite) ? '40' : '100',

		'L_OPTIONS' => $lang['Options'],
		'L_DISABLE_HTML' => $lang['Disable_HTML_post'],
		'L_DISABLE_BBCODE' => $lang['Disable_BBCode_post'],
		'L_DISABLE_SMILIES' => $lang['Disable_Smilies_post'],
		'U_MORE_SMILIES' => append_sid('posting.' . $phpEx . '?mode=smilies'),
		'L_MORE_SMILIES' => $lang['More_emoticons'],
		'L_ATTACH_SIGNATURE' => $lang['Attach_signature'],
		'L_NOTIFY_ON_REPLY' => $lang['Notify'],
		'L_QUOTE_SELECTED' => $lang['qp_quote_selected'],
		'L_NO_TEXT_SELECTED' => $lang['qp_quote_empty'],

		'L_BBCODE_B_HELP' => $lang['bbcode_b_help'],
		'L_BBCODE_I_HELP' => $lang['bbcode_i_help'],
		'L_BBCODE_U_HELP' => $lang['bbcode_u_help'],
		'L_BBCODE_Q_HELP' => $lang['bbcode_q_help'],
		'L_BBCODE_C_HELP' => $lang['bbcode_c_help'],
		'L_BBCODE_L_HELP' => $lang['bbcode_l_help'],
		'L_BBCODE_O_HELP' => $lang['bbcode_o_help'],
		'L_BBCODE_P_HELP' => $lang['bbcode_p_help'],
		'L_BBCODE_W_HELP' => $lang['bbcode_w_help'],
		'L_BBCODE_A_HELP' => $lang['bbcode_a_help'],
		'L_BBCODE_E_HELP' => $lang['bbcode_e_help'],
		'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
		'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],

		'L_FONT_COLOR' => $lang['Font_color'],
		'L_FONT_SIZE' => $lang['Font_size'],
		'L_BBCODE_CLOSE_TAGS' => $lang['Close_Tags'],
		'L_STYLES_TIP' => $lang['Styles_tip'],

		'I_PREVIEW' => $images['cmd_preview'],
		'I_SELECT' => $images['cmd_select'],
		'I_SUBMIT' => $images['cmd_submit'],

		'S_FONT_SIZE_TYPES' => $select_font_size,
		'S_FONT_COLOR_TYPES' => $select_font_color,

                'S_HTML_CHECKED' => (!$html_on) ? ' checked="checked"' : '',
		'S_BBCODE_CHECKED' => (!$bbcode_on) ? ' checked="checked"' : '',
		'S_SMILIES_CHECKED' => (!$smilies_on) ? ' checked="checked"' : '',
	));
}

// generate the page
$template->assign_vars(array(
	'L_EMPTY_MESSAGE' => $lang['Empty_message'],
	'L_QP_TITLE' => $lang['qp_quick_post'],
	'L_QP_OPTIONS' => $lang['qp_options'],
	'L_USERNAME' => $lang['Username'],
	'L_SUBJECT' => $lang['Subject'],
	'L_MESSAGE_BODY' => $lang['Message_body'],
	'L_PREVIEW' => $lang['Preview'],
	'L_SUBMIT' => $lang['Submit'],

	'S_POST_ACTION' => append_sid('posting.' . $phpEx),
));

// send the display
if (!empty($qp_form))
{
	$qp_block_name = (!empty($qp_lite)) ? 'qpl' : 'qpm';
	$template->assign_block_vars($qp_block_name, array());

	$template->set_filenames(array('qp_box' => 'qpes_box.tpl'));
	$template->assign_var_from_handle('QP_BOX', 'qp_box');
}

// function generate_smilies_box()
function generate_smilies_box()
{
        global $db, $board_config, $template, $lang;

	$inline_columns = 4;
	$inline_rows = 5;

	$sql = 'SELECT emoticon, code, smile_url
		FROM ' . SMILIES_TABLE . '
		ORDER BY smilies_id';
	if ($result = $db->sql_query($sql, false, true))
	{
		$num_smilies = 0;
		$rowset = array();
		while ($row = $db->sql_fetchrow($result))
		{
			if (empty($rowset[$row['smile_url']]))
			{
				$rowset[$row['smile_url']]['code'] = str_replace('\'', '\\\'', str_replace('\\', '\\\\', $row['code']));
				$rowset[$row['smile_url']]['emoticon'] = $row['emoticon'];
				$num_smilies++;
			}
		}

		if ($num_smilies)
		{
			$smilies_count = min(19, $num_smilies);
			$smilies_split_row = $inline_columns - 1;

			$s_colspan = 0;
			$row = 0;
			$col = 0;

			while (list($smile_url, $data) = @each($rowset))
			{
				if (!$col)
				{
					$template->assign_block_vars('qp_smilies.smilies_row', array());
				}

				$template->assign_block_vars('qp_smilies.smilies_row.smilies_col', array(
					'SMILEY_CODE' => $data['code'],
					'SMILEY_IMG' => $board_config['smilies_path'] . '/' . $smile_url,
					'SMILEY_DESC' => $data['emoticon'],
				));

				$s_colspan = max($s_colspan, $col + 1);

				if ($col == $smilies_split_row)
				{
					if ($row == $inline_rows - 1)
					{
						break;
					}
					$col = 0;
					$row++;
				}
				else
				{
					$col++;
				}
			}

			if ($num_smilies > $inline_rows * $inline_columns)
			{
				$template->assign_block_vars('qp_smilies.smilies_extra', array());

				$template->assign_vars(array(
					'L_MORE_SMILIES' => $lang['More_emoticons'],
					'U_MORE_SMILIES' => append_sid('posting.' . $phpEx . '?mode=smilies'),
				));
			}

			$template->assign_vars(array(
				'L_EMOTICONS' => $lang['Emoticons'],
				'L_CLOSE_WINDOW' => $lang['Close_window'],
				'S_SMILIES_COLSPAN' => $s_colspan,
			));
		}
	}

}