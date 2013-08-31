<?php
/***************************************************************************
 *                                mod_welcome.php
 *                            -------------------
*
 * Adapté par Saint-Pere www.yep-yop.com
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $board_config,$userdata,$lang;
//chargement du template
$template->set_filenames(array(
   'welcome' => 'areabb/mods/welcome/tpl/mod_welcome.tpl'
));

if( $userdata['session_logged_in'] )
{
	$sql = "SELECT COUNT(post_id) as total
			FROM " . POSTS_TABLE . "
			WHERE post_time >= " . $userdata['user_lastvisit'];
	$result = $db->sql_query($sql);
	if( $result )
	{
		$row = $db->sql_fetchrow($result);
		$user->lang['Search_new'] = $user->lang['Search_new'] . "&nbsp;(" . $row['total'] . ")";
	}

	// Avatar
	$avatar_img = '';
	if ( $userdata['user_avatar_type'] && $userdata['user_allowavatar'] )
	{
		switch( $userdata['user_avatar_type'] )
		{
			case USER_AVATAR_UPLOAD:
				$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_REMOTE:
				$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
				break;
			case USER_AVATAR_GALLERY:
				$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $userdata['user_avatar'] . '" alt="" border="0" />' : '';
				break;
		}
	}
	// Check For Anonymous User
	if ($userdata['user_id'] != '-1')
	{
		$name_link =  areabb_profile($userdata['user_id'],$userdata['username']);
		if ($userdata['user_avatar'] == '')
		{
			$avatar_img = '<img src="areabb/images/guest_avatar.gif" alt="" border="0" />';
		}
	}
	// END: Avatar

	$redirect  = eregi_replace($board_config['script_path'],'',$_SERVER['REQUEST_URI']);
	$redirect = str_replace('sid='.$userdata['session_id'],'',$redirect);
	$redirect = str_replace('?','',$redirect);

	$template->assign_vars(array(
		'L_LOGOUT'				=> $lang['Logout'],
		'U_LOGOUT'				=> append_sid('login.'.$phpEx.'?logout=true&amp;redirect='.$redirect.'&amp;sid=' .$userdata['session_id']),
		'L_REGISTER_NEW_ACCOUNT'=> sprintf($user->lang['Register_new_account'], '<a href="' . append_sid('profile.'.$phpEx.'?mode=register') . '">', '</a>'),
		'U_NAME_LINK'			=> $name_link,
		'L_NAME_WELCOME'		=> $lang['Welcome'],	
		'AVATAR_IMG'			=> $avatar_img
	));
	$template->assign_block_vars('user_logged_in', array());
	
}else{
	$name_link = $user->lang['Guest'];
	$avatar_img = '<img src="areabb/images/guest_avatar.gif" alt="" border="0" />';
	$template->assign_vars(array(
		'L_REGISTER_NEW_ACCOUNT'=> sprintf($user->lang['Register_new_account'], '<a href="' . append_sid('profile.'.$phpEx.'?mode=register') . '">', '</a>'),
		'U_NAME_LINK'			=> $name_link,
		'L_NAME_WELCOME'		=> $lang['Welcome'],	
		'AVATAR_IMG'			=> $avatar_img
	));
	$template->assign_block_vars('user_logged_out', array());
}
$template->assign_var_from_handle('welcome', 'welcome');

?>