<?php
/**
*
* @package Icy Phoenix
* @version $Id: lang_admin.php 41 2009-07-14 08:11:27Z Mighty Gorgon $
* @copyright (c) 2008 Icy Phoenix
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @Icy Phoenix is based on phpBB
* @copyright (c) 2008 phpBB Group
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @Extra credits for this file
* (c) 2002 Meik Sievertsen (Acyd Burn)
* Lopalong
*** French Translation Vendethiel and Yros **
*/


if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
// Modules, this replaces the keys used
	'Control_Panel' => 'Panneau de contr&ocirc;le',
	'Shadow_attachments' => 'Fichiers fant&ocirc;mes',
	'Forbidden_extensions' => 'Extensions interdites',
	'Extension_control' => 'Contr&ocirc;le des extensions',
	'Extension_group_manage' => 'Contr&ocirc;le des groupes d&#39;extension',
	'Special_categories' => 'Catégories spéciales',
	'Sync_attachments' => 'Synchroniser les fichiers joints',
	'Quota_limits' => 'Quotas',

// Attachments -> Management
	'Attach_settings' => 'Configuration des fichiers joints',
	'Manage_attachments_explain' => '<b>Configurez les réglages principaux pour les fichiers joints.</b><br /> Si vous cliquez sur le bouton "Essayer les réglages", le Module fera plusieurs tests pour vérifier que le module marchera correctement. Si vous avez un probl&egrave;me lors de l&#39;envoi des fichiers, lancez ce test pour avoir une erreur détaillée.',
	'Attach_filesize_settings' => 'Configuration de la taille des fichiers',
	'Attach_number_settings' => 'Configuration de la numérotation des fichiers',
	'Attach_options_settings' => 'Options des fichiers',

	'Upload_directory' => 'Dossier d&#39;envoi',
	'Upload_directory_explain' => 'Entrez le dossier relatif &agrave; votre installation IcyPhoenix pour l&#39;envoi des fichiers. Par exemple, entrez <b>files</b> si votre installation IcyPhoenix est située sur http://www.votredomaine.fr/ip et le dossier d&#39;upload est situé &agrave; http://www.votredomaine.fr/ip/files.',
	'Attach_img_path' => 'Ic&ocirc;ne sur les messages avec un fichier joint',
	'Attach_img_path_explain' => 'Cette image est affiché &agrave; c&ocirc;té du lien pour télécharger le fichier dans les messages. Laissez ce champ blanc si vous ne voulez pas afficher d&#39;ic&ocirc;ne. Cette option sera écrasée par celle du contr&ocirc;le de l&#39;extension des groupes.',
	'Attach_topic_icon' => 'Ic&ocirc;ne sur les sujets avec un fichier joint',
	'Attach_topic_icon_explain' => 'Cette image est affichée &agrave; c&ocirc;té du nom des sujets poss&egrave;dant un/des fichier(s) joint(s). Laissez ce champ vide si vous ne voulez pas afficher d&#39;ic&ocirc;ne.',
	'Attach_display_order' => 'Ordre d&#39;affichage des fichiers attachés',
	'Attach_display_order_explain' => 'Choississez comment afficher les fichiers joints dans les messages/messages privés en ordre Descendant (Nouveaux en haut) / Ascendant (Anciens en haut).',
	'Show_apcp' => 'Montrer le nouveau panneau de contr&ocirc;le des fichiers joints lors de l&#39;envoi d&#39;un message',
	'Show_apcp_explain' => 'Choississez to montrer (ou non) le nouveau panneau de contr&ocirc;le (oui) ou l&#39;ancien avec 2 cadres pour attacher et éditer les fichiers déj&agrave; attachés (non). Il est compliqué d&#39;expliquer l&#39;apparence de chacun des deux, le mieux pour vous rendre compte est de tester.',

	'Max_filesize_attach' => 'Taille du fichier',
	'Max_filesize_attach_explain' => 'Taille maximum des fichiers joints. Mettre 0 en valeur signifie &#39;illimité&#39;. Cette option est restreinte par la configuration de votre serveur. Par exemple, si votre configuration PHP autorise au maximum des envois de 2MB, l&#39;option sera bridée &agrave; 2MB.',
	'Attach_quota' => 'Quota',
	'Attach_quota_explain' => 'Taille maximum que peuvent prendre TOUS les fichiers attachés sur votre hébergement. Mettre 0 en valeur signifie &#39;illimité&#39;.',
	'Max_filesize_pm' => 'Taille maximum totale des fichiers dans les messages privés',
	'Max_filesize_pm_explain' => 'Espace disque maximum que chaque utilisateur peut avoir dans sa boîte de messages privés. Mettre 0 en valeur signifie &#39;illimité&#39;.',
	'Default_quota_limit' => 'Quota limite par défaut',
	'Default_quota_limit_explain' => 'Sélectionnez le quota limite automatiquement donné aux utilisateurs qui vont s&#39;enregistrer, et &agrave; ceux qui n&#39;ont pas de limite définie. L&#39;option &#39;Pas de quota limite&#39; signifie ne pas utiliser les quotas, &agrave; la place d&#39;utiliser les réglages par défaut.',

	'Max_attachments' => 'Nombre maximum de fichiers joints',
	'Max_attachments_explain' => 'Le nombre maximum de fichiers qui peuvent &ecirc;tre joints avec un message.',
	'Max_attachments_pm' => 'Nombre maximum de fichiers joints (MP)',
	'Max_attachments_pm_explain' => 'Le nombre maximum de fichiers qui peuvent &ecirc;tre joints avec un message privé.',

	'Disable_mod' => 'Désactiver les fichiers joints',
	'Disable_mod_explain' => 'Cette option est surtout faite pour tester les nouveaux th&egrave;mes, cela désactive toutes les fonctionnalités des fichiers joints sur le panneau de contr&ocirc;le.',
	'PM_Attachments' => 'Autoriser les fichiers joints dans les messages privés',
	'PM_Attachments_explain' => 'Autoriser/Interdire de joindre des fichiers dans les messages privés.',
	'Ftp_upload' => 'Autoriser l&#39;envoi de fichiers par FTP',
	'Ftp_upload_explain' => 'Activer/Désactiver l&#39;envoi de fichiers par FTP. Si vous choississez oui, vous devrez définir la configuration pour la connexion au FTP, et le dossier d&#39;envoi ne sera plus utilisé.',
	'Attachment_topic_review' => 'Voulez-vous afficher les fichiers joints dans la fen&ecirc;tre de revue de sujet ?',
	'Attachment_topic_review_explain' => 'Si vous choississez oui, tous les fichiers attachés seront affichés dans la revue du sujet quand vous envoyez un message.',

	'Ftp_server' => 'Serveur d&#39;envoi FTP',
	'Ftp_server_explain' => 'Entrez l&#39;adresse IP ou le nom de domaine du serveur pour envoyer vos fichiers. Si vous laissez ce champ vide, le serveur o&ugrave; IcyPhoenix est installé sera utilisé. Veuillez noter qu&#39;il est interdit d&#39;ajouter ftp:// ou quelque chose d&#39;autre dans l&#39;adresse, "ftp.votredomaine.fr" ou (ce qui est plus rapide) l&#39;adresse IP suffisent largement.',

	'ftp_username' => 'Nom d&#39;utilisateur FTP',
	'ftp_password' => 'Mot de passe FTP',

	'Attach_ftp_path' => 'Dossier d&#39;envoi sur le FTP',
	'Attach_ftp_path_explain' => 'Le dossier o&ugrave; les fichiers joints seront stockés. Ce dossier n&#39;a pas besoin d&#39;avoir un CHMOD. Veuillez ne pas entrer l&#39;adresse IP / le nom de domaine du FTP, ce champ ne prend que le nom du dossier, par exemple: /home/web/envois/',
	'Ftp_download_path' => 'Lien vers le dossier d&#39;envois du FTP',
	'Ftp_download_path_explain' => 'Entrez l&#39;adresse vers le dossier o&ugrave; sont stockés les fichiers joints.<br />Si vous utilisez un serveur FTP distant, veuillez entrer l&#39;adresse compl&egrave;te, par exemple http://www.mesfichiers.com/ip/envois.<br />Si vous utilisez le serveur o&ugrave; IcyPhoenix est installé pour stocker vos fichiers, vous pouvez rentrer le dossier relatif au dossier qui contient IcyPhoenix, par exemple &#39;envois&#39;. Laissez ce champ vide si le dossier n&#39;est pas accessible via internet. En laissant ce champ vide vous ne pourrez utiliser le téléchargement.',
	'Ftp_passive_mode' => 'Activer le mode "passif" sur le FTP',
	'Ftp_passive_mode_explain' => 'La commande PASV envoi une requ&ecirc;te au serveur distant, ouvre un port pour la connexion et retourne l&#39;adresse de ce port. Le serveur distant se connectera alors &agrave; ce port.',

	'No_ftp_extensions_installed' => 'Vous ne pouvez utiliser l&#39;envois par FTP, parce que l&#39;extension FTP n&#39;est pas activée dans votre installation PHP.',

// Attachments -> Shadow Attachments
	'Shadow_attachments_explain' => 'Supprimer les informations sur les fichiers joints dans les messages avec des fichiers n&#39;existant plus, et supprimer les fichiers qui ne sont plus attachés &agrave; des fichiers. Vous pouvez voir ou télécahrger un fichier en cliquant dessus ; si aucun lien n&#39;est disponible, cela signifie que le fichier n&#39;existe plus.',
	'Shadow_attachments_file_explain' => 'Supprimer tous les fichiers qui existent sur votre hébergement mais qui ne sont plus rattachés &agrave; un message.',
	'Shadow_attachments_row_explain' => 'Supprimer toutes les informations sur les fichiers joints pour les fichiers qui n&#39;existent plus sur votre syst&egrave;me.',
	'Empty_file_entry' => 'Liste vide',

// Attachments -> Sync
	'Sync_thumbnail_recreated' => 'Miniature créée pour: %s', // replace %s with physical Filename
	'Sync_thumbnail_resetted' => 'Miniature refaire pour: %s', // replace %s with physical Filename
	'Attach_sync_finished' => 'Synchronisation des fichiers joints terminée.',
	'Sync_topics' => 'Synchroniser les sujets',
	'Sync_posts' => 'Synchroniser les messages',
	'Sync_thumbnails' => 'Synchroniser les miniatures',


// Extensions -> Extension Control
	'Manage_extensions' => 'Gestion des extensions',
	'Manage_extensions_explain' => 'Modifier les extensions de fichiers. Si vous voulez autoriser/interdire une extension pour les fichiers joints, veuiillez utiliser l&#39;extension de contr&ocirc;le des groupes.',
	'Explanation' => 'Explication',
	'Extension_group' => 'Groupe d&#39;extension',
	'Invalid_extension' => 'Extension invalide',
	'Extension_exist' => 'L&#39;extension %s existe déj&agrave;', // replace %s with the Extension
	'Unable_add_forbidden_extension' => 'L&#39;extension %s est interdite, vous ne pouvez l&#39;ajouter aux extensions autorisées', // replace %s with Extension

// Extensions -> Extension Groups Management
	'Manage_extension_groups' => 'Gérer les groupes d&#39;extensions',
	'Manage_extension_groups_explain' => 'Ajouter, supprimer et modifier vos groupes d&#39;extensions, vous pouvez désactiver les groupes d&#39;extensions, leur assigner une catégorie spéciale, changer la mani&egrave;re de téléchargement et définir un ic&ocirc;ne pour le groupe.',
	'Special_category' => 'Catégorie spéciale',
	'Category_images' => 'Images',
	'Category_stream_files' => 'Fichiers stream', #signification de "stream" ici ?
	'Category_swf_files' => 'Fichiers Flash',
	'Allowed' => 'Autorisé',
	'Allowed_forums' => 'Forums autorisés',
	'Ext_group_permissions' => 'Permissions des groupes',
	'Download_mode' => 'Mode téléchargement',
	'Upload_icon' => 'Ic&ocirc;ne d&#39;envoi',
	'Max_groups_filesize' => 'Taille maximum des fichiers',
	'Extension_group_exist' => 'Le groupe d&#39;extension %s existe déj&agrave;', // replace %s with the group name
	'Collapse' => '+',
	'Decollapse' => '-',

// Extensions -> Special Categories
	'Manage_categories' => 'Gérer les catégories spéciales',
	'Manage_categories_explain' => 'Ajouter des param&egrave;tres spéciaux et des conditions pour les catégories spéciales assignées aux groupes d&#39;extensions.',
	'Settings_cat_images' => 'Options pour les catégories spéciales: Images',
	'Settings_cat_streams' => 'Options pour les catégories spéciales: Fichiers Stream',
	'Settings_cat_flash' => 'Options pour les catégories spéciales: fichiers Flash',
	'Display_inlined' => 'Afficher les images directement dans le message',
	'Display_inlined_explain' => 'Choississez d&#39;afficher ou non les images jointes directement sur le message (oui) ou afficher les images avec un lien (non) ?',
	'Max_image_size' => 'Dimensions maximum des images',
	'Max_image_size_explain' => 'Définissez les dimensions maximum des images pouvant &ecirc;tre jointes (Longueur x Largeur en pixels).<br />Si vous choississez "0x0" comme valeur, aucune vérification ne sera faite. Avec certaines images, cette vérification ne marchera pas &agrave; cause de limitations PHP.',
	'Image_link_size' => 'Dimensions des images-lien',
	'Image_link_size_explain' => 'Si l&#39;image est plus grande que le maximum, elle sera affichée en tant que lien, au lieu de la visualiser directement dans le message (Hauteur x Largeur en pixels).<br />Si vous rentrer choissisez "0x0" comme valeur, cette fonctionnalité sera désactivée. Avec certaines images cette fonctionnalité ne marchera pas &agrave; cause de limitations PHP.',
	'Assigned_group' => 'Groupe assigné',

	'Image_create_thumbnail' => 'Créer une miniature',
	'Image_create_thumbnail_explain' => 'Toujours créer une miniature. Cette fonctionnalité écrase la configuration des catégories spéciales, sauf la configuration des des dimensions maximum. Si vous activez cette fonctionnalité, une miniature sera affichée dans le message, que l&#39;utilisateur pourra cliquer pour voir l&#39;image originale.<br />Veuillez noter que cette fonctionnalité nécéssite Imagick. Si Safe-Mode est activé, le module PHP GD sera activé. Si le type d&#39;image n&#39;est pas reconnue par PHP, cette fonctionnalité ne sera pas utilisée.',
	'Image_min_thumb_filesize' => 'Taille minimum pour créer une miniature',
	'Image_min_thumb_filesize_explain' => 'Si une image est plus petite que la taille, la miniature ne sera pas crée car l&#39;image sera jugée suffisament petite.',
	'Image_imagick_path' => 'Programme Imagick (Chemin complet)',
	'Image_imagick_path_explain' => 'Entrez le chemin complet du programme Imagick, normallement /usr/bin/convert sous linux et c:/imagemagick/convert.exe sous windows.',
	'Image_search_imagick' => 'Chercher imagick',

	'Use_gd2' => 'Utiliser l&#39;extension GD2',
	'Use_gd2_explain' => 'PHP peut &ecirc;tre compilé avec l&#39;extension GD1 ou GD2 pour la manipulation d&#39;image. Pour créer correctement des miniatures sans imagick, le module de fichiers joints utilisera deux méthodes, selon votre configuration. Si vos miniatures sont de mauvaises qualités ou ne s&#39;affichent pas, essayez de changer ce param&egrave;tre.',
	'Attachment_version' => 'Attachment Mod Version %s', // %s is the version number

// Extensions -> Forbidden Extensions
	'Manage_forbidden_extensions' => 'Gérer les extensions interdites',
	'Manage_forbidden_extensions_explain' => 'Ajouter ou supprimes des extensions interdites. Les extensions php, php3 et php4 sont interdites par défaut et ne peuvent &ecirc;tre supprimées pour des raisons de sécurité.',
	'Forbidden_extension_exist' => 'L&#39;extension interdite %s existe déj&agrave;', // replace %s with the extension
	'Extension_exist_forbidden' => 'L&#39;extension %s existe déj&agrave; dans la liste des extensions autorisées, veuillez d&#39;abord la supprimer de celle-ci.', // replace %s with the extension

// Extensions -> Extension Groups Control -> Group Permissions
	'Group_permissions_title' => 'Permissions des groupes d&#39;extensions -> &#39;%s&#39;', // Replace %s with the Groups Name
	'Group_permissions_explain' => 'Restreindre le groupe d&#39;extensions sur le forum de votre choix (dans le cadre "Forums autorisés"). Par défaut, tous les forums sont sélectionnés. Ajoutez les forums que vous voulez autoriser pour ce groupe d&#39;extension, la configuration par défaut "TOUS LES FORUMS" disparaîtra quand vous aurez ajouté les forums &agrave; la liste. Vous pourrez re-choisir "TOUS LES FORUMS" si vous le voulez. Si vous ajouter un forum et que les permissions sont sur "TOUS LES FORUMS", rien ne se passera (le forum sera bien pris en compte). MAis si vous avec changé les restrictions d&#39;utilisation &agrave; certains forums, vous devrez revenir ici pour cocher le nouveau forum.', //It is easy to do this automatically, but this will force you to edit a bunch of Files, therefore I have chosen the way it is now. Please keep in mind, that all of your Forums will be listed here.',
	'Note_admin_empty_group_permissions' => '<b>NOTE:</b> Dans la liste ci-dessous des forums, vos utilisateurs normalement autorisés &agrave; attacher des fichiers qui essayeront d&#39;attacher des fichiers dans un forum dans lequel ils n&#39;ont pas le droit recevront un message d&#39;erreur. Vous pouvez changer la permission &#39;Poster un fichier&#39; &agrave; &#39;ADMIN&#39; dans ces forums.<br /><br />',
	'Add_forums' => 'Ajouter un forum',
	'Add_selected' => 'Ajouter la sélection',
	'Perm_all_forums' => 'TOUS LES FORUMS',

// Attachments -> Quota Limits
	'Manage_quotas' => 'Gérer les limites de quota',
	'Manage_quotas_explain' => 'Ajouter, modifier ou supprimer les limites de quota. Vous pouvez assigner les quotas pour les utilisateurs et groupes plus tard. Si vous assignez un quota &agrave; un utilisateur, vous devez aller dans Utilisateurs > Gérer, sélectionner l&#39;utilisateur, les options seront en bas de la page. Pour assigner un quota &agrave; un groupe, allze dans Groupes > Gérer, sélectionner le groupe &agrave; éditer et configurez le quota. Si vous voulez savoir quels utilisateurs/groupes sont assignées &agrave; un quota spécifique, cliquez sur &#39;View&#39; &agrave; gauche de la description du quota.',
	'Assigned_users' => 'Utilisateurs assignés',
	'Assigned_groups' => 'Groupes assignéés',
	'Quota_limit_exist' => 'Le quota %s existe déj&agrave;.', // Replace %s with the Quota Description

// Attachments -> Control Panel
	'Control_panel_title' => 'Panneau de contr&ocirc;le des fichiers attachés',
	'Control_panel_explain' => 'Voir et contr&ocirc;ler tous les fichiers attachés, basé sur les utilisateurs, fichiers joints, vues, et&ccedil;...',
	'File_comment_cp' => 'Commentaire',

// Control Panel -> Search
	'Search_wildcard_explain' => 'Utilisez * comme joker pour les recherches partielles',
	'Size_smaller_than' => 'Taille du fichier plus petite que (bytes)',
	'Size_greater_than' => 'Taille du fichier plus grande que (bytes)',
	'Count_smaller_than' => 'Compteur de téléchargement plus petit que',
	'Count_greater_than' => 'Compteur de téléchargement plus grand que',
	'More_days_old' => 'Ajouté il y a plus de (jours)',
	'No_attach_search_match' => 'Aucun fichier n&#39;a été trouvé selon vos crit&egrave;res',

// Control Panel -> Statistics
	'Number_of_attachments' => 'Nombre de fichiers joints',
	'Total_filesize' => 'Taille totale',
	'Number_posts_attach' => 'Nombre de messages avec un/des fichier(s)',
	'Number_topics_attach' => 'Nombre de sujets avec un/des fichier(s)',
	'Number_users_attach' => 'Fichiers envoyés par des utilisateurs indépendants',
	'Number_pms_attach' => 'Nombre total de fichiers joints dans les messages privés',

// Control Panel -> Attachments
	'Statistics_for_user' => 'Statistiques de %s', // replace %s with username
	'Size_in_kb' => 'Taille (KB)',
	'Downloads' => 'Téléchargements',
	'Post_time' => 'Date du message',
	'Posted_in_topic' => 'Posté dans le sujet',
	'Submit_changes' => 'Enregistrer les modifications',

// Sort Types
	'Sort_Attachments' => 'Fichiers joints',
	'Sort_Size' => 'Taille',
	'Sort_Filename' => 'Nom du fichier',
	'Sort_Comment' => 'Comment',
	'Sort_Extension' => 'Extension',
	'Sort_Downloads' => 'Téléchargements',
	'Sort_Posttime' => 'Date du message',
	'Sort_Posts' => 'Messages',

// View Types
	'View_Statistic' => 'Statistiques',
	'View_Search' => 'Recherche',
	'View_Username' => 'Nom d&#39;utilisateur',
	'View_Attachments' => 'Fichiers joints',

// Successfully updated
	'Attach_config_updated' => 'La configuration des fichiers joints &agrave; été correctement mise &agrave; jour',
	'Click_return_attach_config' => 'Cliquez %sici%s pour retourner &agrave; la configuration des fichiers joints',
	'Test_settings_successful' => 'Les tests sont concluants, la configuration semble marcher.',

// Some basic definitions
	'Attachments' => 'Fichiers joints',
	'Attachment' => 'Fichier joint',
	'Extensions' => 'Extensions',
	'Extension' => 'Extension',

// Auth pages
	'Auth_attach' => 'Poster des fichiers',
	'Auth_download' => 'Télécharger des fichiers',
	)
);

$lang['Image_max_thumb_size'] = 'Plus grande taille pour le côté d\'une image';
$lang['Image_max_thumb_size_explain'] = 'Si un côté de l\'image est plus grand que cette taille, l\'aperçu sera pareil qu\'une image.';
$lang['Image_thumb_quality'] = 'Qualité des aperçus';
$lang['Image_thumb_quality_explain'] = 'Change la qualité des aperçus, allant de 0 (mauvaise qualité, aperçus légers) à 100 (meilleure qualité, plus grande taille de fichier).';


?>