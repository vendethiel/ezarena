<?php
/**
*
* @package phpBB SEO GYM Sitemaps
* @version $Id: lang_ggs_main.php 2007/04/12 13:48:48 dcz Exp $
* @copyright (c) 2006 dcz - www.phpbb-seo.com
* @license http://opensource.org/osi3.0/licenses/lgpl-license.php GNU Lesser General Public License
*
*/ 
// 
// The format of this file is: 
// 
// ---> $lang["message"] = "text"; 
// 
// Specify your language character encoding... [optional]
// 
// setlocale(LC_ALL, "fr");

// Flux RSS
$lang['rss_short'] = ' - Liste Courte';
$lang['rss_long'] = ' - Liste Longue';
$lang['rss_msg'] = ' - Résumé';
$lang['rss_item_stats'] = '<u>Stats :</u> ';
$lang['rss_more'] = 'Suite ...';
$lang['rss_chan_list'] = ' - Liste des flux RSS';
$lang['rss_answer'] = 'Message';
$lang['rss_answers'] = 'Réponses';
$lang['rss_auth_some'] = "<b><u>Attention :</u></b> Ce flux rss est personalisé pour les authorisations de <b>%s</b>.<br/> Des éléments du flux pourraient ne pas apparaitre hors connexion.";
$lang['rss_auth_this'] = "<b><u>Attention :</u></b> Ce flux rss est personalisé pour les autorisations de <b>%s</b>.<br/> Ce flux n'apparaitra pas hors connexion.";
$lang['rss_reply'] = " [Dernier message]";
// Yahoo Notify API - error handling
$lang['yahoo_error_503'] = "L'appel au service de notification Yahoo! a échoué et retourné un header HTTP 503.<br/>Ce qui signifie que le service est indisponible.<br/>Une erreur interne a empêché Yahoo! d'envoyer une réponse.";
$lang['yahoo_error_403'] = "L'appel au service de notification Yahoo! a échoué et retourné un header HTTP 403.<br/>Ce qui signifie que la requête a été refusée.<br/>Cela peut provenir d'un erreur d'AppID Yahoo! ou du dépassement de la limite de notification quotidienne. ";
$lang['yahoo_error_400'] = "L'appel au service de notification Yahoo! a échoué et retourné un header HTTP 400.<br/>Ce qui signifie que la requête est mal formée.<br/>Les paramètres requis n'ont pas été trouvés. L'erreur exacte se trouve dans la réponse.<br/> Requête : %s<br/> Réponse : %s";
$lang['yahoo_error'] = "L'appel au service de notification Yahoo! a échoué et retourné un header HTTP inattendu : %s<br/> Requête : %s<br/> Réponse : %s";
$lang['yahoo_no_method'] = "L'appel au service de notification Yahoo! a échoué tant avec la méthode curl qu'avec file_get_contents.<br/>Veuillez vérifier la valeur de allow_url_fopen dans votre fichier de configuration php.ini.<br/> Réponse : %s<br/> Réponse : %s";

//
// That's all Folks!
// -------------------------------------------------
?>
