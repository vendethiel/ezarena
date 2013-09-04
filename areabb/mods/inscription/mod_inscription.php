<?php
/***************************************************************************
 *                          mod_inscription.php
 *                            -------------------
 *   begin                : 2006/03/04
 *   copyright          : (C) Oyo - http://u-web.org
 *   email                : oyo@u-web.org
 *
 *   $Id: mod_inscription.php,v 1.0.0 04/03/2006 Oyo Exp $
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   adapté pour AreaBB par Saint-Pere
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}
 
include_once($phpbb_root_path . 'includes/functions_validate.'.$phpEx);

if($board_config['enable_confirm'])
{
	$template->set_filenames(array(
			'inscription' => 'areabb/mods/inscription/tpl/mod_inscription.tpl'
	));
}else{
	$template->set_filenames(array(
		'inscription' => 'areabb/mods/inscription/tpl/mod_inscription_2.tpl'
	));
}

if( !$userdata['session_logged_in'] )
{
	$confirm_image = '';
	if (!empty($board_config['enable_confirm']))
	{
		$sql = 'SELECT session_id FROM ' . SESSIONS_TABLE; 
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not select session data', '', __LINE__, __FILE__, $sql);
		}

		if ($row = $db->sql_fetchrow($result))
		{
			$confirm_sql = '';
			do
			{
				$confirm_sql .= (($confirm_sql != '') ? ', ' : '') . "'" . $row['session_id'] . "'";
			}
			while ($row = $db->sql_fetchrow($result));
			
			$sql = 'DELETE FROM ' .  CONFIRM_TABLE . " WHERE session_id NOT IN ($confirm_sql)";
			if (!$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not delete stale confirm data', '', __LINE__, __FILE__, $sql);
			}
		}
		$db->sql_freeresult($result);

		$sql = 'SELECT COUNT(session_id) AS attempts  FROM ' . CONFIRM_TABLE . "  WHERE session_id = '" . $userdata['session_id'] . "'";
		if (!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not obtain confirm code count', '', __LINE__, __FILE__, $sql);
		}

		if ($row = $db->sql_fetchrow($result))
		{
			if ($row['attempts'] > 3)
			{
				message_die(GENERAL_MESSAGE, $lang['Too_many_registers']);
			}
		}
		$db->sql_freeresult($result);
			
		$confirm_chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',  'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',  'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9');

		list($usec, $sec) = explode(' ', microtime()); 
		mt_srand($sec * $usec); 

		$max_chars = count($confirm_chars) - 1;
		$code = '';
		for ($i = 0; $i < 6; $i++)
		{
			$code .= $confirm_chars[mt_rand(0, $max_chars)];
		}

		$confirm_id = md5(uniqid($user_ip));

		$sql = 'INSERT INTO ' . CONFIRM_TABLE . " (confirm_id, session_id, code)  VALUES ('$confirm_id', '". $userdata['session_id'] . "', '$code')";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Could not insert new confirm code information', '', __LINE__, __FILE__, $sql);
		}

		unset($code);
			
		$confirm_image = (@extension_loaded('zlib')) ? '<img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id") . '" alt="" title="" />' : '<img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=1") . '" alt="" title="" /><img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=2") . '" alt="" title="" /><img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=3") . '" alt="" title="" /><img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=4") . '" alt="" title="" /><img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=5") . '" alt="" title="" /><img src="' . append_sid("profile.$phpEx?mode=confirm&amp;id=$confirm_id&amp;c=6") . '" alt="" title="" />';
		$s_hidden_fields .= '<input type="hidden" name="confirm_id" value="' . $confirm_id . '" />';
		
		$template->assign_vars(array(
			'CONFIRM_IMG' => $confirm_image,
			'L_CONFIRM_CODE_IMPAIRED'	=> sprintf($lang['Confirm_code_impaired'], '<a href="mailto:' . $board_config['board_email'] . '">', '</a>'), 
			'L_CONFIRM_CODE' => $lang['Confirm_code'], 
			'L_CONFIRM_CODE_EXPLAIN'	=> $lang['Confirm_code_explain'], 
		));
	}
	
	$template->assign_block_vars('afficher_inscription', array());

	$template->assign_vars(array(
		'USERNAME' 				=> $username,
		'CUR_PASSWORD' 			=> $cur_password,
		'NEW_PASSWORD' 			=> $new_password,
		'PASSWORD_CONFIRM' 		=> $password_confirm,
		'EMAIL'					=> $email,
		'L_CURRENT_PASSWORD' 	=> $lang['Current_password'],
		'L_NEW_PASSWORD' 		=> $lang['Password'],
		'L_CONFIRM_PASSWORD' 	=> $lang['Confirm_password'],
		'L_CONFIRM_PASSWORD_EXPLAIN' 	=> '',
		'L_PASSWORD_IF_CHANGED' 		=> ( $mode == 'editprofile' ) ? $lang['password_if_changed'] : '',
		'L_PASSWORD_CONFIRM_IF_CHANGED' => ( $mode == 'editprofile' ) ? $lang['password_confirm_if_changed'] : '',
		'L_SUBMIT' 						=> $lang['Submit'],
		'L_RESET' 						=> $lang['Reset'],
		'L_ITEMS_REQUIRED' 		=> $lang['Items_required'],
		'L_REGISTRATION_INFO' 	=> $lang['Registration_info'],
		'L_EMAIL_ADDRESS' 		=> $lang['Email_address'],
		'S_HIDDEN_FIELDS' 		=> $s_hidden_fields,
		'S_FORM_ENCTYPE' 		=> $form_enctype,
		'S_PROFILE_ACTION' 		=> append_sid("profile.$phpEx"))
	);
}
	
$template->assign_var_from_handle('inscription', 'inscription');

?>