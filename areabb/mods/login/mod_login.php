<?php
/***************************************************************************
*                                mod_login.php
*
* Adapté par Saint-Pere - www.yep-yop.com
*
* Ce bloc permet de se connecter à son forum
*  
***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $lang,$user,$board_config,$userdata;

$template->set_filenames(array(
   'login' => 'areabb/mods/login/tpl/mod_login.tpl'
));

if (!$userdata['session_logged_in'])
{

	$redirect  = str_replace($board_config['script_path'],'',$_SERVER['REQUEST_URI']);
	$redirect = str_replace('sid='.$userdata['session_id'],'',$redirect);
	$redirect = str_replace('?','',$redirect);

	$template->assign_vars(array(
		'REDIRECT'				=> $redirect,
		'L_SEND_PASSWORD'		=> $lang['Forgotten_password'],
		'U_SEND_PASSWORD'		=> append_sid("profile.$phpEx?mode=sendpassword"),
		'L_REGISTER_NEW_ACCOUNT'=> sprintf($lang['Register_new_account'], '<a href="' . append_sid("profile.$phpEx?mode=register") . '">', '</a>'),
		'L_REMEMBER_ME'			=> $lang['Remember_me'],
		'AVATAR_IMG'			=> $avatar_img
	));
	$template->assign_block_vars('logged_out',array());
}
	
$template->assign_var_from_handle('login', 'login');

?>