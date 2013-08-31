<?php
/** 
*
* @package quick_post_es_mod [french]
* @version $Id: lang_extend_qpes.php,v 1.0 10/06/2006 16:22 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// admin part
if ($lang_extend_admin)
{
	$lang['qp_config_title'] = 'Configuration du MODule Quick Post ES';
	$lang['qp_config_title_desc'] = 'Vous pouvez gérer ici les options du MODule Quick Post ES.';
	$lang['qp_config_updated'] = 'La configuration du MODule Quick Post ES a été mise à jour.';
	$lang['qp_click_return_config'] = 'Cliquez %sici%s pour retourner à la configuration du MODule Quick Post ES.';
	$lang['qp_user'] = 'membres:';
	$lang['qp_anon'] = 'invités:';
}

// main
$lang['qp_quick_post'] = 'Réponse Rapide';
$lang['qp_settings'] = 'Options de la Réponse Rapide';

// display
$lang['qp_quote_selected'] = 'Sélectionner une citation';
$lang['qp_quote_empty'] = 'Aucun texte sélectionné';
$lang['qp_options'] = 'Plus d\'options';
$lang['bbcode_e_help'] = 'Liste: ajouter une puce';

// fields
$lang['qp_enable'] = 'Activer la réponse rapide';
$lang['qp_enable_explain'] = 'activer/désactiver la réponse rapide sur le forum';
$lang['qp_show'] = 'Voir la réponse rapide';
$lang['qp_show_explain'] = 'Voir le bloc de réponse rapide ouvert par défaut';
$lang['qp_subject'] = 'Activer le titre du sujet';
$lang['qp_subject_explain'] = 'permet de spécifier ou non un titre au message entré dans la réponse rapide';
$lang['qp_bbcode'] = 'Activer les boutons bbcode';
$lang['qp_bbcode_explain'] = 'afficher ou non les boutons bbcode dans la réponse rapide';
$lang['qp_smilies'] = 'Activer les emoticônes';
$lang['qp_smilies_explain'] = 'afficher ou non les émoticônes dans la réponse rapide';
$lang['qp_more'] = 'Activer les options';
$lang['qp_more_explain'] = 'afficher ou non les options supplémentaires de la réponse rapide';

?>