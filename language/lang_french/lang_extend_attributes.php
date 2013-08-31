<?php
/**
*
* @package quick title edition
* @version $Id: lang_extend_attributes.php,v 1.1.3 2007/11/21 12:06 ABDev Exp $
* @copyright (c) 2007 ABDev, OxyGen Powered
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Original author : Xavier Olive, xavier@2037.biz, 2003
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

/**
* description
*/
$lang['mod_qte_title'] = 'Quick Title Edition';
$lang['mod_qte_explain'] = 'Permet d\'appliquer un attribut, comme <span style="color:#006600">[R&eacute;gl&eacute;]</span>, aux titres des sujets. L\'attribut peut, selon le choix de l\'administrateur lors de la cr&eacute;ation, être appliqu&eacute; par l\'administrateur, le mod&eacute;rateur ou l\'auteur du sujet.';

/**
* admin part
*/
if ( $lang_extend_admin )
{
	$lang['Attributes'] = 'Attributs';
	$lang['Attributes_System'] = 'Gestion du syst&egrave;me d\'attributs';
	$lang['Attributes_System_Explain'] = 'Vous pouvez ici &eacute;diter, supprimer et cr&eacute;er des attributs.';

	// list
	$lang['Attribute_Color'] = 'Couleur de l\'attribut';
	$lang['Attribute_None'] = '<em>N/A</em>';

	// permissions
	$lang['Attribute_Permissions'] = 'Permissions';
		$lang['Administrator'] = 'Administrateur';
		$lang['Moderator'] = 'Mod&eacute;rateur';
		$lang['Author'] = 'Auteur';

	// editor
	$lang['New_Attribute'] = 'Ajouter un nouvel attribut';
	$lang['Attribute_Edit'] = '&Eacute;dition de l\'attribut <span %s>%s</span>';

	$lang['Attribute_Type'] = 'Type d\'attribut';
		$lang['Text'] = 'Texte';
		$lang['Image'] = 'Image';

	$lang['Attribute_Image'] = 'Image';
	$lang['Attribute_Image_Explain'] = 'Vous pouvez aussi utiliser une cl&eacute; du tableau <strong>$images[]</strong>, ou saisir le chemin relatif de l\'image';

	// position
	$lang['Attribute_Position'] = 'Position';
		$lang['Left'] = 'Gauche';
		$lang['Right'] = 'Droite';

	// messages
	$lang['Click_Return_Attributes_Management'] = 'Cliquez %sici%s pour retourner au gestionnaire du syst&egrave;me d\'attributs';
	$lang['Attribute_Added'] = 'Attribut ajout&eacute;';
	$lang['Attribute_Updated'] = 'Attribut mis &agrave; jour';
	$lang['Attribute_Removed'] = 'Attribut supprim&eacute;';
	$lang['Attribute_Order_Updated'] = 'Le positionnement de l\'attribut a &eacute;t&eacute; mis &agrave; jour.';
	$lang['Attribute_Confirm_Delete'] = 'Confirmez-vous la suppression de cet attribut ?';

	// explanations
	$lang['Attribute_Explain'] = '- Vous pouvez aussi utiliser une cl&eacute; du tableau <strong>$lang[]</strong>, ou saisir le nom en clair<br />- Ins&eacute;rer <b>%mod%</b> affichera le nom de la personne ayant appliqu&eacute; l\'attribut<br />- Ins&eacute;rer <strong>%date%</strong> affichera la date du jour o&ugrave; l\'attribut a &eacute;t&eacute; appliqu&eacute;<br /><br />- Exemple : <strong>[R&eacute;gl&eacute; par %mod%]</strong> affichera <strong>[R&eacute;gl&eacute; par NomDuMod&eacute;rateur</strong>]';
	$lang['New_Attribute_Explain'] = 'Vous pouvez cr&eacute;er de courts morceaux de phrases informatives que vous pourrez ensuite ajouter au titre d\'un sujet en cliquant simplement sur un bouton.';
	$lang['Attribute_Edit_Explain'] = 'Vous pouvez ici modifier les champs de l\'attribut s&eacute;lectionn&eacute;.';
	$lang['Attribute_Permissions_Explain'] = 'Les membres ayant ce niveau pourront appliquer des attributs';
	$lang['Attribute_Color_Explain'] = 'S&eacute;lectionnez une valeur dans le <em>color picker</em>, ou entrer la manuellement (sans #).<br />Laissez vide pour utiliser une classe CSS nomm&eacute;e comme le rang.';
	$lang['Attribute_Position_Explain'] = 'Choisissez si l\'attribut sera situ&eacute; &agrave; gauche ou &agrave; droite du titre du sujet';

	// error messages
	$lang['Attr_Error_Message_01'] = 'Impossible d\'obtenir les informations de l\'attribut';
	$lang['Attr_Error_Message_02'] = 'Impossible de s&eacute;lectionner les champs de l\'attribut';
	$lang['Attr_Error_Message_03'] = 'Impossible de mettre &agrave; jour ou d\'enregistrer les informations dans la table des attributs';
	$lang['Attr_Error_Message_04'] = 'Impossible de s&eacute;lectionner le champ id';
	$lang['Attr_Error_Message_05'] = 'Impossible de mettre &agrave; jour l\'ordre';
	$lang['Attr_Error_Message_06'] = 'Impossible de supprimer les informations de l\'attribut';
	$lang['Attr_Error_Message_07'] = 'Une erreur s\'est produite lors de la tentative d\'obtention des informations des attributs';
	$lang['Attr_Error_Message_08'] = 'Entr&eacute;e invalide sur le champ: ';
	$lang['Attr_Error_Message_13'] = 'Vous devez définir le lien d\'une image';
	$lang['Attr_Error_Message_14'] = 'Vous devez saisir un attribut';
}

// moderation part
$lang['No_Attribute'] = 'Aucun';
$lang['Attribute_apply'] = 'Appliquer';
$lang['Attribute_Edited'] = 'L\'attribut a &eacute;t&eacute; appliqu&eacute;/modifi&eacute;.';

// posting part
$lang['Attribute'] = 'Attribut';

// error messages
$lang['Attr_Error_Message_09'] = 'Impossible d\'acc&eacute;der &agrave; la table des attributs';
$lang['Attr_Error_Message_10'] = 'Impossible d\'acc&eacute;der &agrave; la table des utilisateurs';
$lang['Attr_Error_Message_11'] = 'Cet attribut n\'existe pas';
$lang['Attr_Error_Message_12'] = 'Impossible de mettre &agrave; jour la table des sujets';

// attributes examples
$lang['QTE_Solved'] = 'Réglé';
$lang['QTE_Cancelled'] = 'Annulé';

?>
