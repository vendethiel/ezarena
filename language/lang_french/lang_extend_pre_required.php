<?php
/**
*
* @package presentation required
* @version $Id: lang_extend_pre_required.php, v 1.0.0 2007/09/19 15:18 OxyGen Powered Exp $
* @copyright (c) 2007 OxyGen Powered, http://www.oxygen-powered.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

if ( $lang_extend_admin )
{
	$lang['Presentation_Required'] = 'Obliger les membres à se présenter';
	$lang['Presentation_Forum'] = 'Sélectionnez le forum de présentation';
}

$lang['Presentation_Message'] = 'Vous devez vous présenter sur le forum prévu à cet effet avant de pouvoir poster';
$lang['Presentation_Forum_Link'] = 'Cliquez %sici%s';

?>