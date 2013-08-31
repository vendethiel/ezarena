<?php
/** 
*
* attachment mod main [French]
*
* @package attachment_mod
* @version $Id: lang_main_attach.php,v 1.1 2005/11/27 17:45:22 kooky Exp $
* @copyright (c) 2002 Meik Sievertsen
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* DO NOT CHANGE
*/
if (!isset($lang) || !is_array($lang))
{
	$lang = array();
}

//
// Attachment Mod Main Language Variables
//

// Auth Related Entries
$lang['Rules_attach_can'] = 'Vous <b>pouvez</b> joindre des fichiers';
$lang['Rules_attach_cannot'] = 'Vous <b>ne pouvez pas</b> joindre des fichiers';
$lang['Rules_download_can'] = 'Vous <b>pouvez</b> t&eacute;l&eacute;charger des fichiers';
$lang['Rules_download_cannot'] = 'Vous <b>ne pouvez pas</b> t&eacute;l&eacute;charger des fichiers';
$lang['Sorry_auth_view_attach'] = 'D&eacute;sol&eacute;, mais vous n\'&ecirc;tes pas autoris&eacute; &agrave voir ou t&eacute;l&eacute;charger ce fichier';

// Viewtopic -> Display of Attachments
$lang['Description'] = 'Description'; // used in Administration Panel too...
$lang['Downloaded'] = 'T&eacute;l&eacute;charg&eacute;';
$lang['Download'] = 'T&eacute;l&eacute;charger'; // this Language Variable is defined in lang_admin.php too, but we are unable to access it from the main Language File
$lang['Filesize'] = 'Taille du fichier';
$lang['Viewed'] = 'Vu';
$lang['Download_number'] = '%d fois'; // replace %d with count
$lang['Extension_disabled_after_posting'] = 'L\'extension \'%s\' a &eacute;t&eacute; d&eacute;sactiv&eacute;e par le webmaster, par cons&eacute;quent ce fichier ne peut &ecirc;tre affich&eacute;.'; // used in Posts and PM's, replace %s with mime type

// Posting/PM -> Initial Display
$lang['Attach_posting_cp'] = 'Panneau de Contrôle des fichiers joints';
$lang['Attach_posting_cp_explain'] = 'Si vous cliquez sur <u>Joindre un fichier</u>, vous apercevrez une boîte de dialogue pour joindre des fichiers.<br />Si vous cliquez sur <u>Fichiers envoy&eacute;s</u>, vous apercevrez une liste des fichiers d&eacute;j&agrave joints et vous pourrez les &eacute;diter.<br />Si vous souhaitez remplacer un fichier joint (<u>Envoyer une nouvelle version</u>), vous devrez cliquer sur ces deux liens. Joignez le fichier comme vous le feriez normalement, par la suite ne cliquez surtout pas sur <u>Joindre un fichier</u>, cliquez plutôt sur <u>Envoyer une nouvelle version</u> en face du fichier que vous souhaitez mettre &agrave jour.';

// Posting/PM -> Posting Attachments
$lang['Add_attachment'] = 'Joindre un fichier';
$lang['Add_attachment_title'] = 'Joindre un fichier';
$lang['Add_attachment_explain'] = 'Si vous ne voulez pas joindre un fichier &agrave votre message, laissez ces champs vides';
$lang['File_name'] = 'Nom du fichier';
$lang['File_comment'] = 'Commentaire';

// Posting/PM -> Posted Attachments
$lang['Posted_attachments'] = 'Fichiers upload&eacute;s';
$lang['Options'] = 'Options';
$lang['Update_comment'] = 'Mettre &agrave jour le commentaire';
$lang['Delete_attachments'] = 'Supprimer les fichiers joints';
$lang['Delete_attachment'] = 'Supprimer le fichier joint';
$lang['Delete_thumbnail'] = 'Supprimer la miniature';
$lang['Upload_new_version'] = 'Uploader une nouvelle version';

// Errors -> Posting Attachments
$lang['Invalid_filename'] = '%s est un nom de fichier non valable'; // replace %s with given filename
$lang['Attachment_php_size_na'] = 'Le fichier joint est trop gros.<br />Impossible d\'obtenir la taille maximale d&eacute;finie dans PHP.<br />Le MOD Attachement ne peut pas d&eacute;terminer la taille maximale d\'Upload dans le fichier php.ini.';
$lang['Attachment_php_size_overrun'] = 'Le fichier joint est trop gros.<br />Taille maximale d\'Upload: %d Mo.<br />Veuillez noter que cette taille est d&eacute;finie dans le fichier php.ini, ce qui signifie qu\'elle est r&eacute;gl&eacute;e par PHP et que le MOD Attachement ne peut pas modifier cette valeur.'; // replace %d with ini_get('upload_max_filesize')
$lang['Disallowed_extension'] = 'L\'extension %s n\'est pas autoris&eacute;e'; // replace %s with extension (e.g. .php)
$lang['Disallowed_extension_within_forum'] = 'Vous n\'&ecirc;tes pas autoris&eacute; &agrave joindre des fichiers avec l\'extension %s dans ce forum'; // replace %s with the Extension
$lang['Attachment_too_big'] = 'Le fichier joint est trop gros.<br />Taille maximale: %d %s'; // replace %d with maximum file size, %s with size var
$lang['Attach_quota_reached'] = 'D&eacute;sol&eacute;, mais la taille maximale de l\'ensemble des fichiers joints a &eacute;t&eacute; atteinte. Veuillez contacter le webmaster si vous avez des questions.';
$lang['Too_many_attachments'] = 'Ce fichier ne peut &ecirc;tre ajout&eacute; car le nombre maximum de %d fichiers joints dans ce message a &eacute;t&eacute; atteint'; // replace %d with maximum number of attachments
$lang['Error_imagesize'] = 'L\'image jointe doit &ecirc;tre inf&eacute;rieure &agrave: %d x %d (largeur x Hauteur en pixels)';
$lang['General_upload_error'] = 'Erreur d\'upload: impossible d\'envoyer le fichier joint vers %s.'; // replace %s with local path

$lang['Error_empty_add_attachbox'] = 'Vous devez entrer les valeurs dans le champ \'Joindre un fichier\'';
$lang['Error_missing_old_entry'] = 'Impossible de mettre &agrave jour le fichier joint, l\'ancien fichier n\'a pas &eacute;t&eacute; trouv&eacute;';

// Errors -> PM Related
$lang['Attach_quota_sender_pm_reached'] = 'D&eacute;sol&eacute;, mais la taille maximale pour l\'ensemble des fichiers joints dans votre Boîte des Messages Priv&eacute;s a &eacute;t&eacute; atteinte. Veuillez supprimer quelques-uns de vos fichiers reçus ou envoy&eacute;s.';
$lang['Attach_quota_receiver_pm_reached'] = 'D&eacute;sol&eacute;, mais la taille maximale pour l\'ensemble des fichiers joints dans la Boîte des Messages Priv&eacute;s de \'%s\' a &eacute;t&eacute; atteinte. Veuillez le-lui faire savoir, ou attendez jusqu\'&agrave ce qu\'il/elle ait supprim&eacute; quelques-uns de ses fichiers joints.';

// Errors -> Download
$lang['No_attachment_selected'] = 'Vous n\'avez pas s&eacute;lectionn&eacute; un fichier joint &agrave t&eacute;l&eacute;charger ou &agrave visualiser.';
$lang['Error_no_attachment'] = 'Le fichier joint s&eacute;lectionn&eacute; n\'existe plus';

// Delete Attachments
$lang['Confirm_delete_attachments'] = '&Ecirc;tes-vous s&ucirc;r de vouloir supprimer les fichiers s&eacute;lectionn&eacute;s ?';
$lang['Deleted_attachments'] = 'Les fichiers s&eacute;lectionn&eacute;s ont &eacute;t&eacute; supprim&eacute;s.';
$lang['Error_deleted_attachments'] = 'Impossible de supprimer les fichiers.';
$lang['Confirm_delete_pm_attachments'] = '&Ecirc;tes-vous s&ucirc;r de vouloir supprimer tous les fichiers joints dans ce Message Priv&eacute; ?';

// General Error Messages
$lang['Attachment_feature_disabled'] = 'La fonction fichier joint est d&eacute;sactiv&eacute;e.';

$lang['Directory_does_not_exist'] = 'Le r&eacute;pertoire \'%s\' n\'existe pas ou ne peut pas &ecirc;tre trouv&eacute;.'; // replace %s with directory
$lang['Directory_is_not_a_dir'] = 'Veuillez v&eacute;rifier si \'%s\' est un r&eacute;pertoire.'; // replace %s with directory
$lang['Directory_not_writeable'] = 'Le r&eacute;pertoire \'%s\' n\'est pas inscriptible. Vous devez cr&eacute;er le chemin d\'envoi et changer ses droits d\'acc&egrave;s en &eacute;criture CHMOD 777 (ou changez les propri&eacute;t&eacute;s de votre serveur httpd sur tous) pour envoyer des fichiers.<br />Si vous avez uniquement acc&egrave;s par FTP, changez les \'attributs\' du r&eacute;pertoire en rwxrwxrwx.'; // replace %s with directory

$lang['Ftp_error_connect'] = 'Impossible de se connecter au serveur FTP: \'%s\'. Veuillez v&eacute;rifier vos param&egrave;tres FTP.';
$lang['Ftp_error_login'] = 'Impossible de se connecter au serveur FTP. Le nom d\'utilisateur \'%s\' ou le mot de passe est incorrect. Veuillez v&eacute;rifier vos param&egrave;tres FTP.';
$lang['Ftp_error_path'] = 'Impossible d\'acc&eacute;der au r&eacute;pertoire du FTP: \'%s\'. Veuillez v&eacute;rifier vos param&egrave;tres FTP.';
$lang['Ftp_error_upload'] = 'Impossible d\'envoyer des fichiers vers le r&eacute;pertoire du FTP: \'%s\'. Veuillez v&eacute;rifier vos param&egrave;tres FTP.';
$lang['Ftp_error_delete'] = 'Impossible de supprimer les fichers du r&eacute;pertoire FTP: \'%s\'. Veuillez v&eacute;rifier vos param&egrave;tres FTP.<br />Une autre raison pour cette erreur pourrait &ecirc;tre la non-existence du fichier joint, veuillez v&eacute;rifier d\'abord dans les fichiers joints perdus.';
$lang['Ftp_error_pasv_mode'] = 'Impossible d\'activer/d&eacute;sactiver le mode passif du FTP';

// Attach Rules Window
$lang['Rules_page'] = 'R&egrave;gles des fichiers joints';
$lang['Attach_rules_title'] = 'Groupes d\'extensions autoris&eacute;s et leur taille';
$lang['Group_rule_header'] = '%s &raquo; Taille maximale d\'upload: %s'; // Replace first %s with Extension Group, second one with the Size STRING
$lang['Allowed_extensions_and_sizes'] = 'Extensions et tailles autoris&eacute;es';
$lang['Note_user_empty_group_permissions'] = 'NOTE:<br />Normalement, vous &ecirc;tes autoris&eacute; &agrave joindre des fichiers dans ce forum,<br />mais tant qu\'aucun groupe d\'extensions n\'est autoris&eacute; &agrave &ecirc;tre joint ici, <br />vous ne pouvez joindre aucun fichier. Si vous essayez, <br />vous aurez un message d\'erreur.<br />';

// Quota Variables
$lang['Upload_quota'] = 'Quota d\'Upload';
$lang['Pm_quota'] = 'Quota des MP';
$lang['User_upload_quota_reached'] = 'D&eacute;sol&eacute;, mais vous avez atteint votre limite maximale de quota d\'Upload de %d %s'; // replace %d with Size, %s with Size Lang (MB for example)

// User Attachment Control Panel
$lang['User_acp_title'] = 'PC Fichiers';
$lang['UACP'] = 'Panneau de Contrôle des Fichiers';
$lang['User_uploaded_profile'] = 'Upload&eacute;: %s';
$lang['User_quota_profile'] = 'Quota: %s';
$lang['Upload_percent_profile'] = '%d%% du total';

// Common Variables
$lang['Bytes'] = 'Octets';
$lang['KB'] = 'Ko';
$lang['MB'] = 'Mo';
$lang['Attach_search_query'] = 'Rechercher des fichiers joints';
$lang['Test_settings'] = 'Tester les options';
$lang['Not_assigned'] = 'Non assign&eacute;';
$lang['No_file_comment_available'] = 'Aucun commentaire disponible';
$lang['Attachbox_limit'] = 'Votre Boîte &agrave; fichiers est pleine &agrave %d%%';
$lang['No_quota_limit'] = 'Aucune limite de quotas';
$lang['Unlimited'] = 'Illimit&eacute;';