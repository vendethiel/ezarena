<?php 
/***************************************************************************
 *				TownMap_Copyright.php
 *				------------------------
 *	begin 			: 18/11/2004
 *	copyright			: One_Piece
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
define('IN_TOWNMAP_COPYRIGHT', true); 
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$loc = 'character_prefs';
$sub_loc = 'TownMap_Copyright';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

// Includes the tpl and the header
adr_template_file('TownMap_Copyright_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);


$template->assign_vars(array(
      'L_COPYRIGHT' => $lang['TownMap_Copyright'],
	'L_COPYRIGHT_EXPLICATION' => $lang['TownMap_copyright_explication'],
	'L_IMAGES' => $lang['TownMap_copyright_images'],
	'L_TRADUCTEUR' => $lang['TownMap_copyright_traducteur'],
	'L_REMERCIEMENT' => $lang['TownMap_copyright_remerciement'],
	'L_AUTEUR' => $lang['TownMap_copyright_auteur'],
));

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

// Empty the memory
$db->sql_freeresult($result);

?> 