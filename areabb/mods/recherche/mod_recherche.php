<?php
/***************************************************************************
*                                mod_recherche.php
*
*  
***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

$template->set_filenames(array(
   'recherche' => 'areabb/mods/recherche/tpl/mod_recherche.tpl')
);

$template->assign_vars(array(
			'L_RECHERCHER'	=> $lang['L_RECHERCHER']
));
	
$template->assign_var_from_handle('recherche', 'recherche');

?>