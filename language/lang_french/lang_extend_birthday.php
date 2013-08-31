<?php
/**
*
* @package birthday_event_mod [French]
* @version $Id: lang_extend_birthday.php,v 1.0.1 11:46 17/08/2007 reddog Exp $
* @copyright (c) 2007 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// birthday dateformat
$lang['birthday_dateformat'] = 'd F Y';

// admin part
if ( $lang_extend_admin )
{
	$lang['birthday_settings'] = 'Options des anniversaires';
	$lang['birthday_show'] = 'Tableau des anniversaires';
	$lang['birthday_show_explain'] = 'D&eacute;termine si le tableau sur l\'index principal doit rester visible m&ecirc;me si aucun membre ne f&ecirc;te son anniversaire aujourd\'hui ou dans les prochains jours.';
	$lang['birthday_wishes'] = 'Voeux d\'anniversaire';
	$lang['birthday_wishes_explain'] = 'Souhaiter un Joyeux anniversaire aux membres en affichant le tableau sur l\'index principal, et un g&acirc;teau d\'anniversaire dans leur profil et &agrave; c&ocirc;t&eacute; de leurs messages.';
	$lang['birthday_require'] = 'Date de naissance obligatoire';
	$lang['birthday_require_explain'] = 'La date de naissance sera obligatoire pour tout nouvel utilisateur enregistr&eacute;, et pour les membres qui souhaiteraient modifier leur profil.';
	$lang['birthday_lock'] = 'Date de naissance non modifiable ';
	$lang['birthday_lock_explain'] = 'Une fois renseign&eacute;e, la date de naissance ne peut &ecirc;tre chang&eacute;e &agrave; nouveau.';
	$lang['birthday_lookahead'] = 'Nombre de jours &agrave; venir';
	$lang['birthday_lookahead_explain'] = 'Affecte le tableau des anniversaires sur l\'index principal. Une valeur de 0 d&eacute;sactivera la v&eacute;rification des anniversaires &agrave; venir.';
	$lang['birthday_age_range'] = 'Conditions d\'&acirc;ge (en ann&eacute;es)';
	$lang['birthday_age_range_explain'] = 'Indiquer ici l\'&acirc;ge minimum et maximum autoris&eacute; pour les utilisateurs.';
	$lang['birthday_zodiac'] = 'Signes du zodiaque';
	$lang['birthday_zodiac_explain'] = 'Affiche ou non les signes du zodiaque dans le profil des utilisateurs et &agrave; c&ocirc;t&eacute; de leurs messages.';
}

// main
$lang['birthday'] = 'Anniversaire';
$lang['happy_birthday'] = 'Joyeux anniversaire !';
$lang['poster_age'] = '&Acirc;ge';

// index's birthdays panel
$lang['birthdays'] = 'Anniversaires';
$lang['which_birthday'] = 'Qui f&ecirc;te son anniversaire ?';
$lang['congratulations'] = 'F&eacute;licitations &agrave; :';
$lang['no_birthdays'] = 'Aucun membre ne f&ecirc;te son anniversaire aujourd\'hui';
$lang['upcoming_birthdays'] = 'Membres f&ecirc;tant leur annniversaire durant les <strong>%d</strong> prochains jours :';
$lang['no_upcoming'] = 'Aucun membre ne f&ecirc;te son anniversaire dans les <strong>%d</strong> prochains jours';

// error
$lang['birthday_range'] = 'Les anniversaires doivent respecter des &acirc;ges entre %d et %d ans, inclus.';
$lang['birthday_invalid'] = 'Vous n\'avez pas sp&eacute;cifi&eacute; une date de naissance valide.';

// user's profile
$lang['birthdate'] = 'Date de naissance';
$lang['birthdate_explain'] = 'En renseignant ce champ, votre signe du zodiaque et votre &acirc;ge seront visibles';
$lang['month'] = 'Mois';
$lang['day'] = 'Jour';
$lang['year'] = 'Ann&eacute;e';
$lang['default_month'] = '[ Choisir un mois ]';
$lang['default_day'] = 'jj';
$lang['default_year'] = 'aaaa';

// zodiac signs
$lang['Capricorn'] = 'Capricorne';
$lang['Aquarius'] = 'Verseau';
$lang['Pisces'] = 'Poissons';
$lang['Aries'] = 'B&eacute;lier';
$lang['Taurus'] = 'Taureau';
$lang['Gemini'] = 'G&eacute;meau';
$lang['Cancer'] = 'Cancer';
$lang['Leo'] = 'Lion';
$lang['Virgo'] = 'Vierge';
$lang['Libra'] = 'Balance';
$lang['Scorpio'] = 'Scorpion';
$lang['Sagittarius'] = 'Sagittaire';

?>