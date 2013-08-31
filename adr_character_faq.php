<?php 
/***************************************************************************
 *					adr_character_faq.php
 *				------------------------
 *	begin 			: 13/10/2004
 *	copyright			: Seteo-Bloke
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

define('IN_PHPBB', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_VAULT', true);
define('IN_ADR_PREFERENCES', true);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'character_prefs';
$sub_loc = 'adr_character_faq';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry, only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Get the general config
$adr_general = adr_get_general_config();

// Includes the tpl and the header
adr_template_file('adr_character_faq_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$lang_file = 'lang_adr_faq';
$l_title = $lang['rpg_faq'];
include($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/' . $lang_file . '.' . $phpEx);

//
// Pull the array data from the lang pack
//

$j = 0;
$counter = 0;
$counter_2 = 0;
$faq_block = array();
$faq_block_titles = array();

for($i = 0; $i < count($faq); $i++)
{
	if( $faq[$i][0] != '--' )
	{
		$faq_block[$j][$counter]['id'] = $counter_2;
		$faq_block[$j][$counter]['question'] = $faq[$i][0];
		$faq_block[$j][$counter]['answer'] = $faq[$i][1];

		$counter++;
		$counter_2++;
	}
	else
	{
		$j = ( $counter != 0 ) ? $j + 1 : 0;

		$faq_block_titles[$j] = $faq[$i][1];

		$counter = 0;
	}
}

//$template->set_filenames(array(
//	'body' => (isset($HTTP_GET_VARS['dhtml']) && $HTTP_GET_VARS['dhtml'] == 'no' ? 'faq_body.tpl' : 'adr/templates/adr_character_faq_body.tpl')
//));

$template->assign_vars(array(
	'U_CFAQ_JSLIB' => $phpbb_root_path . 'adr/templates/collapsible_faq.js',
	'L_CFAQ_NOSCRIPT' => $lang['dhtml_faq_noscript'],
	'L_BACK_TO_TOP' => $lang['Back_to_top'],
	'L_FAQ_TITLE' => $lang['Adr_faq_title'],
));

for($i = 0; $i < count($faq_block); $i++)
{
	if( count($faq_block[$i]) )
	{
		$template->assign_block_vars('faq_block', array(
			'BLOCK_TITLE' => $faq_block_titles[$i]
		));
		$template->assign_block_vars('faq_block_link', array( 
			'BLOCK_TITLE' => $faq_block_titles[$i]
		));

		for($j = 0; $j < count($faq_block[$i]); $j++)
		{
			$row_color = ( !($j % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($j % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			$template->assign_block_vars('faq_block.faq_row', array(
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,
				'FAQ_QUESTION' => $faq_block[$i][$j]['question'], 
				'FAQ_ANSWER' => $faq_block[$i][$j]['answer'], 
				'U_FAQ_ID' => $faq_block[$i][$j]['id']
			));

			$template->assign_block_vars('faq_block_link.faq_row_link', array(
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,
				'FAQ_LINK' => $faq_block[$i][$j]['question'], 
				'U_FAQ_LINK' => '#' . $faq_block[$i][$j]['id']
			));
		}
	}
}

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 