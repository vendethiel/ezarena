<?php
/***************************************************************************
 * bbc_box_tags.php
 * ----------------
 * begin	: Tuesday, June 07, 2005
 * copyright	: reddog - http://www.reddevboard.com/
 * version	: 0.0.11 - 11/10/2005
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

// bbc box language file
if ( $userdata['user_id'] != ANONYMOUS )
{
	if ( !empty($userdata['user_lang']))
	{
		$board_config['default_lang'] = $userdata['user_lang'];
	}
}
if ( !file_exists(@phpbb_realpath($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_bbc_box.'.$phpEx)) )
{
	$board_config['default_lang'] = 'english';
}
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_bbc_box.'.$phpEx);

//
// Main process
//
if ($board_config['bbc_box_on'])
{
	// send to template
	$template->assign_block_vars('bbc', array());

	// separator
	$bbc_style_path = $board_config['bbc_style_path'];
	$bbc_box_img = "templates/_shared/bbc_box/styles/" . $bbc_style_path;
	$separator = ( file_exists(@phpbb_realpath($phpbb_root_path . $bbc_box_img . '/separator.gif')) ) ? '&nbsp;<img alt="" src="' . $bbc_box_img . '/separator.gif" />' : '&nbsp;&nbsp;';

	//
	// Default BBcode tags
	//

	// ------------------------------------------------------------------
	// Do not alter these lines!
	$bbc_tags_def = array(
		'bold' => array('before' => '[b]', 'after' => '[/b]', 'helpline' => 'bold', 'bbstyle' => '0', 'img' => 'bold', 'divider' => '0'),
		'italic' => array('before' => '[i]', 'after' => '[/i]', 'helpline' => 'italic', 'bbstyle' => '2', 'img' => 'italic', 'divider' => '0'),
		'underline' => array('before' => '[u]', 'after' => '[/u]', 'helpline' => 'underline', 'bbstyle' => '4', 'img' => 'underline', 'divider' => '1'),
		'quote' => array('before' => '[quote]', 'after' => '[/quote]', 'helpline' => 'quote', 'bbstyle' => '6', 'img' => 'quote', 'divider' => '0'),
		'code' => array('before' => '[code]', 'after' => '[/code]', 'helpline' => 'code', 'bbstyle' => '8', 'img' => 'code', 'divider' => '1'),
		'ulist' => array('before' => '[list]', 'after' => '[/list]', 'helpline' => 'ulist', 'bbstyle' => '10', 'img' => 'ulist', 'divider' => '0'),
		'olist' => array('before' => '[list=]', 'after' => '[/list]', 'helpline' => 'olist', 'bbstyle' => '12', 'img' => 'olist', 'divider' => '1'),
		'picture' => array('before' => '[img]', 'after' => '[/img]', 'helpline' => 'picture', 'bbstyle' => '14', 'img' => 'picture', 'divider' => '0'),
		'www' => array('before' => '[url]', 'after' => '[/url]', 'helpline' => 'www', 'bbstyle' => '16', 'img' => 'www', 'divider' => '0'),
	);

	$count_tags = count($bbc_tags_def);
	$count = 0;
	foreach ( $bbc_tags_def as $bbc_tag_def => $bbc_tag_data )
	{
		$count++;
		$template->assign_block_vars('bbc.def', array(
			'BEFORE' => $bbc_tag_data['before'],
			'AFTER' => $bbc_tag_data['after'],
			'SEP' => ($count == $count_tags) ? '' : ',',
			'HELPLINE' => $bbc_tag_data['helpline'],
			'LANG_HELP' => $lang['bbcbxr_help'][$bbc_tag_data['helpline']],
			'BBSTYLE' => $bbc_tag_data['bbstyle'],
			'IMG' => $phpbb_root_path . $images[$bbc_tag_data['img']],
			'BBC_BG_IMG' => $images['bbc_bg'],
			'DIVIDER' => ($bbc_tag_data['divider']) ? $separator : '',
		));
	}
	// ------------------------------------------------------------------

	//
	// BBcode box tags
	//

	// new bbcode tags added
	$bbc_config = $bbc_tagsrow_box = array();
	@include($phpbb_root_path . 'includes/def_bbc_box.'.$phpEx);
	if ( empty($bbc_config) )
	{
		cache_bbc_box();
		bbc_time_regen('bbc_time_regen');
		@include($phpbb_root_path . 'includes/def_bbc_box.'.$phpEx);
	}
	foreach ( $bbc_config as $key => $value )
	{
		$bbc_sort = bbc_auth($value['bbc_auth']);
		if (!empty($value['bbc_value']) && $bbc_sort)
		{
			$bbc_tagsrow_box[] = array(
				'value' => $value['bbc_value'],
				'auth' => $value['bbc_auth'],
				'before' => $value['bbc_before'],
				'after' => $value['bbc_after'],
				'helpline' => $value['bbc_helpline'],
				'img' => $value['bbc_img'],
				'divider' => $value['bbc_divider'],
			);
		}
	}

	// get the number of buttons per row from config
	$bbc_per_row = isset($board_config['bbc_per_row']) ? intval($board_config['bbc_per_row']) : 14;
	if ($bbc_per_row <= 1)
	{
		$bbc_per_row = 14;
	}


	// let's go!
	$bbc_tags_box_count = count($bbc_tagsrow_box);
	$nb_row = intval( ($bbc_tags_box_count-1) / $bbc_per_row )+1;
	$offset = 0;
	$addbbcode = 0;
	for($j = 0; $j < $nb_row; $j++)
	{
		if (!empty($bbc_tagsrow_box[$nb_row]['value']))
		{
			$template->assign_block_vars('bbc.row',array());
		}
		for ($k = 0; ( ($k < $bbc_per_row) && ($offset < $bbc_tags_box_count) ); $k++)
		{
			$bbc_sort_box = bbc_auth($bbc_tagsrow_box[$offset]['auth']);
			if (!empty($bbc_tagsrow_box[$nb_row]['value']) && $bbc_sort_box)
			{
				$val = ($addbbcode*2)+18;
				$template->assign_block_vars('bbc.row.box', array(
					'BEFORE' => '[' . $bbc_tagsrow_box[$offset]['before'] . ']',
					'AFTER' => '[/' . $bbc_tagsrow_box[$offset]['after'] . ']',
					'HELPLINE' => $bbc_tagsrow_box[$offset]['helpline'],
					'LANG_HELP' => sprintf( (isset($lang['bbcbxr_help'][$bbc_tagsrow_box[$offset]['helpline']]) ? $lang['bbcbxr_help'][$bbc_tagsrow_box[$offset]['helpline']] : $lang['bbcbxr_help_none'] ), $bbc_tagsrow_box[$offset]['before'], $bbc_tagsrow_box[$offset]['after']),
					'BBSTYLE' => $val,
					'IMG' => $phpbb_root_path . $images[$bbc_tagsrow_box[$offset]['img']],
					'BBC_BG_IMG' => $images['bbc_bg'],
					'DIVIDER' => ($bbc_tagsrow_box[$offset]['divider']) ? $separator : '',
				));
				$addbbcode++;
			}
			$offset++;
		}
	}

	// font types combobox
	$font_types_list = array($lang['type_arial'], $lang['type_comicsansms'], $lang['type_couriernew'], $lang['type_georgia'], $lang['type_lucidaconsole'], $lang['type_microsoft'], $lang['type_tahoma'], $lang['type_timesnewroman'], $lang['type_trebuchet']);
	$font_types_count = count($font_types_list);

	$select_font_types = '<select name="addbbcodefonttype" onchange="bbfontstyle(\'[font=\' + this.form.addbbcodefonttype.options[this.form.addbbcodefonttype.selectedIndex].value + \']\', \'[/font]\');this.form.addbbcodefonttype.selectedIndex = 0;" onmouseover="helpline(\'t\')">';
	$select_font_types .= '<option value="' . $lang['type_verdana'] . '" class="genmed" selected="selected">' . $lang['Type_default'] . '</option>';
	for($i = 0; $i < count($font_types_list); $i++)
	{
		$select_font_types .= '<option value="' . $font_types_list[$i] . '" style="font-family:' . $font_types_list[$i] . '">' . $font_types_list[$i] . '</option>';
	}
	$select_font_types .= '</select>';
}
else
{
	// send to template
	$template->assign_block_vars('bbc_else', array());

	$bbc_tags_def = array(
		'bold' => array('before' => '[b]', 'after' => '[/b]', 'accesskey' => 'b', 'value' => ' B ', 'style' => 'font-weight:bold;width:30px', 'helpline' => 'b', 'bbstyle' => '0'),
		'italic' => array('before' => '[i]', 'after' => '[/i]', 'accesskey' => 'i', 'value' => ' i ', 'style' => 'font-style:italic;width:30px', 'helpline' => 'i', 'bbstyle' => '2'),
		'underline' => array('before' => '[u]', 'after' => '[/u]', 'accesskey' => 'u', 'value' => ' u ', 'style' => 'text-decoration:underline;width:30px', 'helpline' => 'u', 'bbstyle' => '4'),
		'quote' => array('before' => '[quote]', 'after' => '[/quote]', 'accesskey' => 'q', 'value' => 'Quote', 'style' => 'width:50px', 'helpline' => 'q', 'bbstyle' => '6'),
		'code' => array('before' => '[code]', 'after' => '[/code]', 'accesskey' => 'c', 'value' => 'Code', 'style' => 'width:40px', 'helpline' => 'c', 'bbstyle' => '8'),
		'ulist' => array('before' => '[list]', 'after' => '[/list]', 'accesskey' => 'l', 'value' => 'List', 'style' => 'width:40px', 'helpline' => 'ulist', 'bbstyle' => '10'),
		'olist' => array('before' => '[list=]', 'after' => '[/list]', 'accesskey' => 'o', 'value' => 'List=', 'style' => 'width:40px', 'helpline' => 'olist', 'bbstyle' => '12'),
		'picture' => array('before' => '[img]', 'after' => '[/img]', 'accesskey' => 'p', 'value' => 'Img', 'style' => 'width:40px', 'helpline' => 'p', 'bbstyle' => '14'),
		'www' => array('before' => '[url]', 'after' => '[/url]', 'accesskey' => 'w', 'value' => 'URL', 'style' => 'text-decoration:underline;width:40px', 'helpline' => 'w', 'bbstyle' => '16'),
	);

	$count_tags = count($bbc_tags_def);
	$count = 0;
	foreach ( $bbc_tags_def as $bbc_tag_def => $bbc_tag_data )
	{
		$count++;
		$template->assign_block_vars('bbc_else.def_else', array(
			'BEFORE' => $bbc_tag_data['before'],
			'AFTER' => $bbc_tag_data['after'],
			'SEP' => ($count == $count_tags) ? '' : ',',
			'ACCESSKEY' => $bbc_tag_data['accesskey'],
			'VALUE' => $bbc_tag_data['value'],
			'STYLE' => $bbc_tag_data['style'],
			'HELPLINE' => $bbc_tag_data['helpline'],
			'BBSTYLE' => $bbc_tag_data['bbstyle'],
		));
	}
}

//
// Default process
//

// font size combobox
$size_types_text = array($lang['font_tiny'], $lang['font_small'], $lang['font_normal'], $lang['font_large'], $lang['font_huge']);
$size_types = array('7', '9', '12', '18', '24');

$select_font_size = '<select name="addbbcodefontsize" onchange="bbfontstyle(\'[size=\' + this.form.addbbcodefontsize.options[this.form.addbbcodefontsize.selectedIndex].value + \']\', \'[/size]\');this.form.addbbcodefontsize.selectedIndex = 2;" onmouseover="helpline(\'f\')">';
for($i = 0; $i < count($size_types_text); $i++)
{
	$selected = ( $i == 2 ) ? ' selected="selected"' : '';
	$select_font_size .= '<option value="' . $size_types[$i] . '"' . $selected . '>' . $size_types_text[$i] . '</option>';
}
$select_font_size .= '</select>';

// font color combobox
$font_types_text = array($lang['color_default'], $lang['color_dark_red'], $lang['color_red'], $lang['color_orange'], $lang['color_brown'], $lang['color_yellow'], $lang['color_green'], $lang['color_olive'], $lang['color_cyan'], $lang['color_blue'], $lang['color_dark_blue'], $lang['color_indigo'], $lang['color_violet'], $lang['color_white'], $lang['color_black']);
$font_types = array($theme['fontcolor1'], 'darkred', 'red', 'orange', 'brown', 'yellow', 'green', 'olive', 'cyan', 'blue', 'darkblue', 'indigo', 'violet', 'white', 'black');

$select_font_color = '<select name="addbbcodefontcolor" onchange="bbfontstyle(\'[color=\' + this.form.addbbcodefontcolor.options[this.form.addbbcodefontcolor.selectedIndex].value + \']\', \'[/color]\');this.form.addbbcodefontcolor.selectedIndex = 0;" onmouseover="helpline(\'s\')">';
for($i = 0; $i < count($font_types_text); $i++)
{
	$selected = ( $i == 0 ) ? ' selected="selected"' : '';
	$select_font_color .= '<option style="color:' . $font_types[$i] . '" value="' . $font_types[$i] . '"' . $selected . '>' . $font_types_text[$i] . '</option>';
}
$select_font_color .= '</select>';

// background color combobox replacements
$patterns = array('/addbbcodefontcolor/', '/\[color/', '/color\]/', '/\'s/');
$replacements = array('addbbcodebackcolor', '[bcolor', 'bcolor]', '\'bs');
$select_back_color = preg_replace($patterns, $replacements, $select_font_color);

// constants
$template->assign_vars(array(
	// img
	'BBC_HOVERBG_IMG' => $images['bbc_hoverbg'],
	'BBC_BG_IMG' => $images['bbc_bg'],
	// main
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
	'L_BBCODE_S_HELP' => $lang['bbcode_s_help'],
	'L_BBCODE_F_HELP' => $lang['bbcode_f_help'],
	'L_BBCBXR_E_HELP' => $lang['bbcbxr_e_help'],
	'L_BBCBXR_T_HELP' => $lang['bbcbxr_t_help'],
	'L_BBCBXR_BS_HELP' => $lang['bbcbxr_bs_help'],

	'L_FONT_SIZE' => $lang['Font_size'],
	'L_FONT_TYPE' => $lang['Font_type'],
	'L_FONT_COLOR' => $lang['Font_color'],
	'L_CLOSE_TAGS' => $lang['Close_Tags'],
	'L_STYLES_TIP' => $lang['Styles_tip'],
	'L_TYPE_DEFAULT' => $lang['Type_default'],
	'L_EMPTY_MESSAGE' => $lang['Empty_message'],

	// tools bar
	'I_SWITCHCOLOR' => $images['switchcolor'],
	'I_H_RULE' => $images['horizontal_rule'],
	'I_CHARMAP' => $images['charmap'],
	'I_CLEANUP' => $images['cleanup'],
	'L_BBCBXR_SWC_HELP' => $lang['bbcbxr_swc_help'],
	'L_BBCBXR_HR_HELP' => $lang['bbcbxr_hr_help'],
	'L_BBCBXR_CHR_HELP' => $lang['bbcbxr_chr_help'],
	'U_CHARMAP' => append_sid("posting.$phpEx?mode=charmap"),

	'S_STYLE_PATH' => $board_config['bbc_style_path'],
	'S_BBC_BOX_ON' => $board_config['bbc_box_on'],

	// select
	'S_FONT_SIZE_TYPES' => $select_font_size,
	'S_FONT_TYPES_LIST' => $select_font_types,
	'S_FONT_COLOR_TYPES' => $select_font_color,
	'S_BACK_COLOR_TYPES' => $select_back_color,
));

// send the display
$template->set_filenames(array(
	'bbc_js_box' => '{ROOT}bbc_js_box.tpl',
	'bbc_display_box' => '{ROOT}bbc_display_box.tpl',
));

$template->assign_var_from_handle('BBC_JS_BOX', 'bbc_js_box');
$template->assign_var_from_handle('BBC_DISPLAY_BOX', 'bbc_display_box');

?>