<?php
/***************************************************************************
 *                                mod_change_style.php
 *   fait le                : Dimanche,3 Aout, 2003
 *   Par : giefca - giefca@hotmail.com - http://www.gf-phpbb.fr.st
 *
 *  Adapté pour AreaBB par Saint-Pere - www.yep-yop.com
 ***************************************************************************/

 if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

global $HTTP_POST_VARS,$phpEx,$lang,$userdata,$db;

//chargement du template
$template->set_filenames(array(
			'changestyle' => 'areabb/mods/changestyle/tpl/mod_change_style.tpl'
));
	
if ($userdata['session_logged_in'])
{
	if ( isset($HTTP_POST_VARS['cstyle']))
	{
		$newstyle = intval($HTTP_POST_VARS['cstyle']);
		$sql = 'UPDATE ' . USERS_TABLE . ' 
					SET user_style =\''.$newstyle.'\' 
					WHERE user_id = \'' . $userdata['user_id'] . '\'' ;
		if(!($result = $db->sql_query($sql)))
		{
			message_die(GENERAL_ERROR, 'Could not update user\'s theme', '', __LINE__, __FILE__, $sql);
		}
		$redirect  = str_replace($board_config['script_path'],'',$_SERVER['REQUEST_URI']);
		$redirect = str_replace('sid='.$userdata['session_id'],'',$redirect);
		$redirect = str_replace('?','',$redirect);
		
		$message = $lang['style_change'] . '<br /><br />' ;
		$message .=	sprintf($lang['Click_return_arcade'], '<a href="' . append_sid($redirect).'">', '</a>') ;
		message_die(GENERAL_MESSAGE,$message);
		exit;
	}

	$sql = 'SELECT themes_id, style_name 
			FROM ' . THEMES_TABLE . ' 
			ORDER BY style_name ASC ' ;
	if(!($result = $db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR, 'Could not query themes information', '', __LINE__, __FILE__, $sql);
	}

	$liste_styles = '';
	while ( $row = $db->sql_fetchrow( $result ) )
	{
			$selected = ( $row['themes_id'] == $userdata['user_style'] ) ? ' selected' : '' ;
			$liste_styles .= "\n".'<option value="' . $row['themes_id'] . '"'.$selected.'>' . $row['style_name'] . '</ option>' ;
	}

	$template->assign_vars( array(
			'L_STYLE'		=> $lang['Title_styles'],
			'S_STYLES'		=> $liste_styles,
			'L_ENREGISTRER'	=> $lang['L_ENREGISTRER'] 
	));
	$template->assign_block_vars('logged_in',array());
}
	
$template->assign_var_from_handle('changestyle', 'changestyle');

?>