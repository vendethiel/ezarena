<?php
/**
*
* @package post_description_mod [french]
* @version $Id: lang_extend_sub_title.php,v 1.0 24/08/2006 17:18 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

// admin part
if ( $lang_extend_admin )
{
	// sub-title
	$lang['Sub_title_length'] = 'Longueur du sous-titre (description) du sujet';
	$lang['Sub_title_length_explain'] = 'Choisissez la longueur en nombre de caractères des sous-titres (description) des messages. Renseignez cette valeur à 0 si vous ne désirez pas afficher les sous-titres.';
}

// main
$lang['Sub_title'] = 'Description du sujet';;

?>