<?php
/***************************************************************************
 * lang_bbc_box.php [French]
 * -------------------------
 * begin	: Wednesday, June 08, 2005
 * copyright	: reddog - http://www.reddevboard.com/
 * version	: 1.0.8 - 09/10/2005
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// bbc box settings (acp)
//

//main
$lang['bbc_settings_title'] = 'BBcode Box Reloaded - Configuration';
$lang['bbc_settings_explain'] = 'En utilisant ce formulaire vous pouvez régénérer le fichier cache des bbcodes et modifier les options du module.';
$lang['bbc_settings_adjust'] = 'Réglages';
$lang['bbc_settings_cache'] = 'Cache';

// regen
$lang['bbc_box_cache'] = 'Mise en cache de la liste des bbcodes';
$lang['bbc_last_regen'] = 'Dernière régénération';
$lang['bbc_today_at'] = 'aujourd\'hui, à %s';
$lang['bbc_yesterday_at'] = 'hier, à %s';

// bbc per row
$lang['bbc_per_row'] = 'Nombre de boutons par ligne';
$lang['bbc_per_row_explain'] = 'Renseignez ici le nombre de boutons affichés par ligne dans l\'écran de postage.';

// mode selection (beginner or advanced)
$lang['bbc_mode_select'] = 'Sélectionner le mode d\'affichage';
$lang['bbc_mode_select_explain'] = 'Vous avez le choix entre le mode <span style="color:darkred"><strong>confirmé</strong></span> qui offre des réglages supplémentaires et le mode <span style="color:green"><strong>débutant</strong></span>, idéal pour ne pas commettre d\'erreurs.';
$lang['bbc_advanced'] = '<span style="color:darkred"><strong>confirmé</strong></span>';
$lang['bbc_beginner'] = '<span style="color:green"><strong>débutant</strong></span>';

// switch on/off (buttons)
$lang['bbc_switch_select'] = 'Afficher les boutons bbcode dans l\'écran de postage';
$lang['bbc_switch_select_explain'] = 'Si cette option est désactivée, les boutons bbcode de base seront affichés dans l\'écran de postage. Toutefois, pour désactiver réellement les balises bbcodes, utilisez le menu listant les boutons.';

// skin selection
$lang['Select_skin'] = 'Sélectionner un style';
$lang['Skin_preview'] = 'Prévisualiser';

// actions
$lang['bbc_regen'] = 'Régénérer le cache';
$lang['bbc_settings_updated'] = 'La configuration des bbcodes a été mise à jour avec succès.';
$lang['bbc_cache_updated'] = 'La mise en cache de la liste des bbcodes a abouti.';
$lang['bbc_click_return'] = 'Cliquez %sici%s pour revenir à la page précédente.';
$lang['bbc_click_return_settings'] = 'Cliquez %sici%s pour retourner à la configuration des boutons bbcode.';

//
// bbc box manage (acp)
//

//main
$lang['bbc_manage_title'] = 'BBcode Box Reloaded - Gestion des bbcodes';
$lang['bbc_manage_explain'] = 'En utilisant ce formulaire vous pouvez ajouter, éditer, voir et supprimer des bbcodes. Chaque bbcode nécessite des lignes de code dans le fichier <span style="color:darkred"><em>bbcode.php</em></span> (et accessoirement <span style="color:darkred"><em>bbcode.tpl</em></span>), ainsi qu\'une clef <span style="color:darkblue"><em>$lang[\'bbcbxr_help\'][\'helpline\']</em></span> et une clef <span style="color:darkblue"><em>$lang[\'bbcbxr_desc\'][\'helpline\']</em></span> dans le fichier <span style="color:darkred"><em>lang_bbc_box.php</em></span> (où la variable helpline correspond à sa valeur).';
$lang['bbc_edit_title'] = 'BBcode Box Reloaded - Edition du bbcode %s';
$lang['bbc_edit_explain'] = 'En utilisant ce formulaire, vous pouvez modifier les champs du bbcode sélectionné. <span style="color:darkred"><strong>ATTENTION!</strong></span> Un champ ne doit être composé que d\'<span style="color:green"><strong>un seul mot (ou lettre)</strong></span>, ne comportant aucun <span style="color:darkred"><strong>caractères spéciaux</strong></span>, <span style="color:darkred"><strong>espace</strong></span> ou <span style="color:darkred"><strong>majuscules</strong></span>.';
$lang['bbc_edit_rules'] = '<strong>Champs début et fin de tag:</strong> <span style="color:darkred"><strong>vous ne devez pas modifier</strong></span> les variables placées avant (exemple: width, height) et après (exemple: down, left, right) un caractère =, celles-ci sont définies dans le fichier <span style="color:darkred"><em>bbcode.php</em></span>.';
$lang['bbc_add_title'] = 'BBcode Box Reloaded - Ajouter un nouveau bbcode';
$lang['bbc_add_explain'] = 'En utilisant ce formulaire, vous pouvez définir les champs du nouveau bbcode. <span style="color:darkred"><strong>ATTENTION!</strong></span> Un champ ne doit être composé que d\'<span style="color:green"><strong>un seul mot (ou lettre)</strong></span>, ne comportant aucun <span style="color:darkred"><strong>caractères spéciaux</strong></span>, <span style="color:darkred"><strong>espace</strong></span> ou <span style="color:darkred"><strong>majuscules</strong></span>. Une image doit être présente dans le répertoire prévu à cet effet (par défaut: <em>templates/bbc_box/styles/default/</em>).';
$lang['bbc_add_rules'] = 'Le premier champ est <span style="color:darkred"><strong>important</strong></span>, il est utilisé pour gérer le bbcode depuis le fichier <span style="color:darkred"><em>bbcode.php</em></span>. Des variables peuvent être ajoutées dans les champs tag si celles-ci sont définies dans le même fichier (exemple: <em>tag=</em><strong>center</strong> ou <em>tag</em> <strong>width</strong><em>=100</em>). Ajouter un nouveau bbcode depuis ce formulaire ne suffit pas, chaque bbcode nécessite des lignes de code dans le fichier <span style="color:darkred"><em>bbcode.php</em></span> (et accessoirement <span style="color:darkred"><em>bbcode.tpl</em></span>).';

// fields
$lang['bbc_name'] = 'bbcode';
$lang['bbc_name_explain'] = 'variable <span style="color:darkred"><strong>importante</strong></span> utilisée comme nom pour le bbcode, sans espace ni caractères spéciaux.';
$lang['bbc_img_display'] = 'bouton';
$lang['bbc_before'] = 'début de tag';
$lang['bbc_before_explain'] = 'variable utilisée comme début de tag, sans les crochets.';
$lang['bbc_before_edit_explain'] = 'Ce qui donnera [%s] comme balise dans un message.';
$lang['bbc_after'] = 'fin de tag';
$lang['bbc_after_explain'] = 'variable utilisée comme fin de tag, sans les crochets.';
$lang['bbc_after_edit_explain'] = 'Ce qui donnera [/%s] comme balise dans un message.';
$lang['bbc_helpline'] = 'helpline';
$lang['bbc_helpline_explain'] = 'variable utilisée pour la ligne explicative quand la souris passe sur un bouton bbcode, sans espace ni caractères spéciaux.';
$lang['bbc_img'] = 'image';
$lang['bbc_img_explain'] = 'variable utilisée pour les clefs $images[].';
$lang['bbc_divider'] = 'espacement';
$lang['bbc_divider_explain'] = 'pour ajouter ou non un espacement après ce bouton bbcode.';

// actions
$lang['Edit'] = 'Editer';
$lang['Delete'] = 'Supprimer';
$lang['bbc_move_after'] = 'Positionner ce bbcode après';
$lang['bbc_top'] = '___ Début ___';
$lang['Add_new_bbc'] = 'Ajouter un nouveau bbcode';
$lang['bbc_must_select'] = 'Vous devez sélectionner un bbcode';
$lang['bbc_must_fill'] = 'Vous devez remplir tous les champs';
$lang['bbc_updated'] = 'Le bbcode a été mis à jour avec succès';
$lang['bbc_added'] = 'Le bbcode a été ajouté avec succès';
$lang['bbc_removed'] = 'Le bbcode a été supprimé avec succès';
$lang['bbc_click_return_manage'] = 'Cliquez %sici%s pour retourner à la gestion des boutons bbcode';

//
// bbc box list (acp)
//

// main
$lang['bbc_box_title'] = 'BBcode Box Reloaded';
$lang['bbc_box_explain'] = 'Vous pouvez ici activer, désactiver les boutons bbcode utilisés sur le forum ; ainsi que gérer les permissions d\'utilisation de chacun d\'entre eux.';
$lang['bbc_box_list'] = 'Liste des boutons bbcodes';

// actions
$lang['Enable_all'] = 'Tout activer';
$lang['Disable_all'] = 'Tout désactiver';
$lang['Button_switch'] = 'Activer ou désactiver le bouton sélectionné';
$lang['bbc_act_mode'] = 'Mode Activer/Désactiver';
$lang['bbc_perms_mode'] = 'Mode Permissions';
$lang['bbc_go_to'] = 'aller au %s';
$lang['bbc_box_updated'] = 'La configuration des boutons bbcode a été mise à jour';
$lang['bbc_box_return'] = 'Cliquez %sici%s pour retourner à l\'administration des boutons bbcode';

//
// bbc box (board)
//

// main
$lang['Font_size'] = 'Taille';
$lang['Font_type'] = 'Police';
$lang['Font_color'] = 'Couleur';
$lang['Type_default'] = 'Défaut';
$lang['Close_Tags'] = 'Fermer les Balises';
$lang['Styles_tip'] = 'Astuce: Une mise en forme peut être appliquée au texte sélectionné.';

// generic help
$lang['bbcbxr_e_help'] = 'Liste: ajouter une puce';
$lang['bbcode_a_help'] = 'Fermer toutes les balises BBCode ouvertes';
$lang['bbcode_s_help'] = 'Couleur du texte: [color=red]texte[/color] Astuce: #FF0000 fonctionne aussi';
$lang['bbcode_f_help'] = 'Taille du texte: [size=x-small]texte en petit[/size]';
$lang['bbcbxr_t_help'] = 'Type de police: [font=Verdana]texte[/font]';
$lang['bbcbxr_bs_help'] = 'Couleur d\'arrière plan: [bcolor=red]texte[/bcolor] Astuce: #FF0000 fonctionne aussi';

// default
$lang['bbcbxr_help']['bold'] = 'Texte gras: [b]texte[/b]';
$lang['bbcbxr_help']['italic'] = 'Texte italique: [i]texte[/i]';
$lang['bbcbxr_help']['underline'] = 'Texte souligné: [u]texte[/u]';
$lang['bbcbxr_help']['quote'] = 'Citation: [quote]texte cité[/quote]';
$lang['bbcbxr_help']['code'] = 'Afficher du code: [code]code[/code]';
$lang['bbcbxr_help']['ulist'] = 'Liste: [list]texte[/list]';
$lang['bbcbxr_help']['olist'] = 'Liste ordonnée: [list=]texte[/list]';
$lang['bbcbxr_help']['picture'] = 'Insérer une image: [img]http://image_url/[/img]';
$lang['bbcbxr_help']['www'] = 'Insérer un lien: [url]http://url/[/url] ou [url=http://url/]Nom[/url]';

// bbcode box
$lang['bbcbxr_help']['strike'] = 'Texte barré: [%s]texte[/%s]';
$lang['bbcbxr_help']['spoiler'] = 'Spoiler: [%s]texte[/%s]';
$lang['bbcbxr_help']['fade'] = 'Opacité: [%s]texte[/%s] ou avec [img]http://image_url/[/img]';
$lang['bbcbxr_help']['rainbow'] = 'Insérer un effet arc-en-ciel: [%s]texte[/%s]';
$lang['bbcbxr_help']['justify'] = 'Texte justifié: [%s]texte[/%s]';
$lang['bbcbxr_help']['right'] = 'Aligner le texte à droite: [%s]texte[/%s]';
$lang['bbcbxr_help']['center'] = 'Centrer le texte: [%s]texte[/%s]';
$lang['bbcbxr_help']['left'] = 'Aligner le texte à gauche: [%s]texte[/%s]';
$lang['bbcbxr_help']['link'] = 'Insérer une ancre lien: [%snom_cible]texte[/%s]';
$lang['bbcbxr_help']['target'] = 'Insérer une ancre cible: [%snom_cible]texte[/%s]';
$lang['bbcbxr_help']['marqd'] = 'Défilement du texte vers le bas: [%s]texte[/%s]';
$lang['bbcbxr_help']['marqu'] = 'Défilement du texte vers le haut: [%s]texte[/%s]';
$lang['bbcbxr_help']['marql'] = 'Défilement du texte vers la gauche: [%s]texte[/%s]';
$lang['bbcbxr_help']['marqr'] = 'Défilement du texte vers la droite: [%s]texte[/%s]';
$lang['bbcbxr_help']['email'] = 'Insérer une adresse email: [%s]adresse email[/%s]';
$lang['bbcbxr_help']['flash'] = 'Insérer un fichier Flash: [%s]URL du flash[/%s]';
$lang['bbcbxr_help']['video'] = 'Insérer un fichier vidéo: [%s]URL du fichier[/%s]';
$lang['bbcbxr_help']['stream'] = 'Insérer un fichier en streaming: [%s]URL du fichier[/%s]';
$lang['bbcbxr_help']['real'] = 'Insérer un fichier Real Media: [%s]URL du fichier[/%s]';
$lang['bbcbxr_help']['quick'] = 'Vidéo Quicktime: [%s]http://lien_video_quicktime/[/%s]';
$lang['bbcbxr_help']['sup'] = 'Mettre le texte en exposant: [%s]texte[/%s]';
$lang['bbcbxr_help']['sub'] = 'Mettre le texte en indice: [%s]texte[%s]';
// undefined
$lang['bbcbxr_help_none'] = 'Utilisation du bbcode: [%s]texte[/%s]';

// font size
$lang['font_tiny'] = 'Très petit';
$lang['font_small'] = 'Petit';
$lang['font_normal'] = 'Normal';
$lang['font_large'] = 'Grand';
$lang['font_huge'] = 'Très grand';

// font type
$lang['type_arial'] = 'Arial';
$lang['type_comicsansms'] = 'Comic Sans MS';
$lang['type_couriernew'] = 'Courier New';
$lang['type_georgia'] = 'Georgia';
$lang['type_lucidaconsole'] = 'Lucida Console';
$lang['type_microsoft'] = 'Microsoft Sans Serif';
$lang['type_tahoma'] = 'Tahoma';
$lang['type_timesnewroman'] = 'Times New Roman';
$lang['type_trebuchet'] = 'Trebuchet MS';
$lang['type_verdana'] = 'Verdana';

// tools bar
$lang['bbcbxr_swc_help'] = 'Basculer du mode couleur du texte à couleur d\'arrière plan';
$lang['bbcbxr_hr_help'] = 'Insérer un séparateur';
$lang['bbcbxr_chr_help'] = 'Insérer un caractère spécial';

// charmap popup
$lang['charmap_page'] = 'Caractères spéciaux';
$lang['charmap_title'] = 'Sélectionner un caractère spécial';

// description
$lang['bbcbxr_desc']['strike'] = 'Texte barré';
$lang['bbcbxr_desc']['spoiler'] = 'Spoiler';
$lang['bbcbxr_desc']['fade'] = 'Opacité';
$lang['bbcbxr_desc']['rainbow'] = 'Effet arc-en-ciel';
$lang['bbcbxr_desc']['justify'] = 'Texte justifié';
$lang['bbcbxr_desc']['right'] = 'Texte aligné à droite';
$lang['bbcbxr_desc']['center'] = 'Texte centré';
$lang['bbcbxr_desc']['left'] = 'Texte aligné à gauche';
$lang['bbcbxr_desc']['link'] = 'Ancre lien';
$lang['bbcbxr_desc']['target'] = 'Ancre cible';
$lang['bbcbxr_desc']['marqd'] = 'Défilement du texte vers le bas';
$lang['bbcbxr_desc']['marqu'] = 'Défilement du texte vers le haut';
$lang['bbcbxr_desc']['marql'] = 'Défilement du texte vers la gauche';
$lang['bbcbxr_desc']['marqr'] = 'Défilement du texte vers la droite';
$lang['bbcbxr_desc']['email'] = 'Adresse email';
$lang['bbcbxr_desc']['flash'] = 'Fichier Flash';
$lang['bbcbxr_desc']['video'] = 'Fichier vidéo';
$lang['bbcbxr_desc']['stream'] = 'Fichier en streaming';
$lang['bbcbxr_desc']['real'] = 'Fichier Real Media';
$lang['bbcbxr_desc']['quick'] = 'Vidéo Quicktime';
$lang['bbcbxr_desc']['sup'] = 'Texte en exposant';
$lang['bbcbxr_desc']['sub'] = 'Texte en indice';

// addons
// add keys $lang[] from addons below this line

// Flv Video
$lang['bbcbxr_help']['movie'] = 'FLV: [movie]http://...movie.flv/[/movie]';
$lang['bbcbxr_desc']['movie'] = 'FLV';

// Play Vidéo
$lang['bbcbxr_help']['play'] = "Play: [play]http://Lien média/[/play]";
$lang['bbcbxr_desc']['play'] = 'Play';

// thumbnail
$lang['bbcbxr_help']['tmb'] = 'Insérer une miniature: [tmb]http://image_url[/tmb]';
$lang['bbcbxr_desc']['tmb'] = 'Miniature';

// hide
$lang['bbcbxr_help']['hidde'] = "Message protégé: [hide]texte caché[/hide]";
$lang['bbcbxr_desc']['hidde'] = 'Texte caché';

// YouTube
$lang['bbcbxr_help']['youtube'] = 'YouTube: [youtube]URL YouTube[/youtube]';
$lang['bbcbxr_desc']['youtube'] = 'YouTube';

// Website
$lang['bbcbxr_help']['website'] = 'Website: [website]URL site[/website]';
$lang['bbcbxr_desc']['website'] = 'Website';

// Google Video
$lang['bbcbxr_help']['google'] = 'Google: [GVideo]http://video.google.com/[/GVideo]';
$lang['bbcbxr_desc']['google'] = 'Google';

// Dailymotion
$lang['bbcbxr_help']['dailymotion'] = 'Dailymotion: [dailymotion]URL Dailymotion[/dailymotion]';
$lang['bbcbxr_desc']['dailymotion'] = 'Dailymotion';

// Titre 1
$lang['bbcbxr_help']['titre 1'] = 'Titre1: [titre1]titre[/titre1]';
$lang['bbcbxr_desc']['titre 1'] = 'Titre1';

//
// That's all Folks!
// -------------------------------------------------

?>