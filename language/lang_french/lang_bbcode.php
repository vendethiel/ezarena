<?php

/***************************************************************************
 *                            lang_bbcode.php [french]
 *                              -------------------
 *     begin                : Sat Dec 16 2000
 *     copyright            : (C) 2004 PhpBB France
 *
 *     $Id: lang_bbcode.php
 *
 ****************************************************************************/

/***************************************************************************
*

 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

//
// Traduction : phpBB France (http://www.phpbbfrance.org/)
//
 
// ---English---
// To add an entry to your BBCode guide simply add a line to this file in this format:
// $faq[] = array("question", "answer");
// If you want to separate a section enter $faq[] = array("--","Block heading goes here if wanted");
// Links will be created automatically
//
// DO NOT forget the ; at the end of the line.
// Do NOT put double quotes (") in your BBCode guide entries, if you absolutely must then escape them ie. \"something\"
//
// The BBCode guide items will appear on the BBCode guide page in the same order they are listed in this file
//
// If just translating this file please do not alter the actual HTML unless absolutely necessary, thanks :)
//
// ---French---
// In addition please do not translate the colours referenced in relation to BBCode any section, if you do
// users browsing in your language may be confused to find they're BBCode doesn't work :D You can change
// references which are 'in-line' within the text though.
//
//
// Si vous voulez ajouter une section, ajoutez simplement une ligne à ce fichier, ressemblant à celle-ci :
// $faq[] = array("--","titre du paragraphe désiré");
// Pour ajouter un article dans votre guide du BBCode, ajoutez simplement une ligne à ce fichier, ressemblant à celle-ci :
// $faq[] = array("question", "réponse");
// Ne vous préoccupez pas des liens, ou du reste, tout est créé automatiquement.
//
// N'OUBLIEZ PAS !
// - Pensez à bien mettre un point virgule (;) (sans paranthèses bien entendu) à la fin de votre ligne.
// - Ne mettez pas de guillemets (") dans votre guide du BBCode, si vous en avez absolument besoin,
//      soustrayez-le en l'antislashant (ex : \"quelquechose\").
// - Ne touchez pas aux éléments HTML de ce fichier, sauf cas de force majeure. Merci :)
//
// Les sections du guide du BBCode apparaitront dans la page correspondante, dans le même ordre que celui présenté dans ce fichier.
//
 
$faq[] = array("--","Introduction");
$faq[] = array("Qu'est ce que le BBCode ?", "Le BBCode est un langage \"à balises\" qui vous permet de mettre en forme et d'organiser le texte de vos messages, notes et annonces. <br /> Sur le principe du code HTML, le BBCode s'appuie sur l'ouverture et la fermeture de balises, contenues dans des crochets [ et ], pour délimiter votre texte suivant le modèle [balise]texte[/balise]. Le slash (\"/\") précédant le nom de la balise indique la fermeture d'une balise préalablement ouverte.<br />Des explications propres à chacune des balises BBCode sont dispensées plus bas. <br />L'activation du BBCode est déterminée par l'administrateur. En outre, vous pouvez désactiver le BBCode dans un message lors de sa composition.<br />Vous pourrez facilement rajouter des balises BBCode à vos messages au travers d'une interface de boutons \"cliquables\" au-dessus de la zone de saisie des messages. Toutefois, le guide qui suit pourra vous être utile.");  

$faq[] = array("--","Mise en forme du texte");
$faq[] = array("Comment rendre le texte en gras, en italique, ou le souligner ?", "Le BBCode correspond à des balises permettant d'organiser et mettre en forme votre texte avec clarté, facilité et rapidité. <ul><li>Pour modifier une partie de votre texte en gras, encadrez ce texte avec les balises <b>[b] [/b]</b>, exemple: <br /><br /><b>[b]</b>Texte en gras<b>[/b]</b> donnera : <b>Texte en gras</b></li><br /><li>Pour souligner une partie de votre texte, encadrez ce texte des balises <b>[u] [/u]</b>, par exemple :<br /><br /><b>[u]</b>Texte souligné<b>[/u]</b> donnera : <u>Texte souligné</u></li><br /><li>Pour mettre une partie de texte en italique, encadrez ce texte avec les balises <b>[i] [/i]</b>, exemple:<br /><br /><b>[i]</b>Texte en Italique<b>[/i]</b> donnera : <i>Texte en Italique</i></li></ul>");
$faq[] = array("Comment changer la taille ou la couleur d'un texte ?", "Gardez à l'esprit que ce qui apparaîtra à l'écran dépendra de votre navigateur, de votre système d'exploitation, de leurs configurations, ainsi que de votre matériel. Pour changer la couleur ou la taille de votre texte, vous pouvez utiliser les balises suivantes : <ul><li>Pour rendre une partie de votre texte en couleur, encadrez-la par les balises <b>[color=][/color]</b>. Vous devez spécifier un nom de couleur reconnu (ex : red, blue, yellow, etc. pour rouge, bleu, jaune, etc.) ou en employant comme alternative la valeur hexadécimale de la couleur (ex : #FFFFFF, #000000). Par exemple, pour créer un texte rouge, encadrez-le comme il suit :<br /><br /><b>[color=red]</b>Texte en rouge<b>[/color]</b><br /><br />ou<br /><br /><b>[color=#FF0000]</b>Texte en rouge<b>[/color]</b><br /><br />cela donnera <span style=\"color:red\">Texte rouge</span>.</li><li>Pour changer la taille du texte, procédez de la même façon, en utilisant les balises <b>[size=][/size]</b>. Ces balises dépendent du thème utilisé, mais les valeurs que vous pouvez employer sont des valeurs numériques représentant la taille du texte en pixels, allant de 1 (si petit que le texte sera illisible) jusqu'à 29 (très grand). Par exemple :<br /><br /><b>[size=9]</b>petit<b>[/size]</b><br /><br />donnera <span style=\"font-size:9px\">petit</span><br /><br />alors que :<br /><br /><b>[size=24]</b>ENORME<b>[/size]</b><br /><br />donnera <span style=\"font-size:24px\">ENORME</span>.</li></ul>");
$faq[] = array("Est il possible de combiner les balises BBCode?", "Oui ! Par exemple, pour attirer l'attention sur ce que vous venez d'écrire, encadrez-le par :<br /><br /><b>[size=18][color=red][b]</b>REGARDEZ MOI !<b>[/b][/color][/size]</b><br /><br />ce qui donnera <span style=\"color:red;font-size:18px\"><b>REGARDEZ MOI !</b></span><br /><br />Nous vous déconseillons d'abuser de ce type de messages, bien qu'il vous soit possible d'en créer. N'oubliez pas que c'est à vous, membre utilisateur, de vous assurer que les balises sont correctement fermées. Par exemple, ce qui suit est incorrect :<br /><br /><b>[b][u]</b>Ceci est faux !<b>[/b][/u]</b>");

$faq[] = array("--","Citation et différence de largeur du texte.");
$faq[] = array("Citation dans la réponse.", "Il y a deux méthodes pour citer tout ou partie d'un message : avec ou sans référence.<ul><li>La première méthode consiste à utiliser le bouton \"Citer\" pour répondre à un message. Le message cité est automatiquement ajouté dans la zone de texte et encadré par les balises <b>[quote=\"\"]</b> et <b>[/quote]</b>. Cette méthode vous permet de citer un message avec une référence à son auteur (ou ce que vous aurez choisi de mettre !). Par exemple, pour citer une partie du texte écrit par X, vous devrez saisir:<br /><br /><b>[quote=\"X\"]</b>Texte de X que vous souhaitez citer<b>[/quote]</b><br /><br />Une fois le message posté, le texte de X sera précédé de <b>X a écrit</b><br />Souvenez-vous que vous <b>devez</b> encadrer la référence que vous citez par des guillemets \"\". Ils ne sont pas optionnels.</li><br /><li>La seconde méthode vous permet de citer un texte sans faire référence à son auteur. Pour l'utiliser, encadrez le texte à citer par les balises <b>[quote]</b> et <b>[/quote]</b>. Le message cité sera simplement précédé de la mention <b>Citation</b>.</li></ul>");
$faq[] = array("Texte brut, ou partie de code", "Pour afficher dans vos messages du texte sans mise en forme, avec une taille fixe de caractères, en police d'écriture de type Courrier ou bien encore des parties de code informatique sans interprétation (ex : description de balise BBCode) , vous devez encadrez votre texte avec les balises <b>[code][/code]</b>, exemple: <br /><ul><b>[code]</b>[b]Texte en Gras [/b]<b>[/code]</b> donnera [b]Texte en Gras [/b] (et non <b>Texte en Gras</b>)</ul>Toute mise en forme utilisée dans  les balises <b>[code][/code]</b> sera donc ignorée.<br />");

$faq[] = array("--","Créer des listes");
$faq[] = array("Créer une liste non-ordonnée", "Le BBCode permet de créer deux types de listes : les listes non-ordonnées et les listes ordonnées. Elles sont quasi identiques à leurs équivalents en HTML.<br />Une liste non-ordonnée affichera chaque item les uns à la suite des autres dans l'ordre de saisie. Chaque item de la liste sera précédé par une puce.<br /> Pour créer une liste non-ordonnée, utilisez les balises <b>[list] [/list]</b> et définissez chaque item à l'intérieur de la liste en utilisant <b>[*]</b>. <ul>Par exemple, pour établir une liste de vos couleurs favorites, saisissez:<br /><br /><b>[list]</b><br /><b>[*]</b>Rouge<br /><b>[*]</b>Bleu<br /><b>[*]</b>Jaune<br /><b>[/list]</b><br /><br />Vous obtiendrez :<br /><br /><li>Rouge</li><li>Bleu</li><li>Jaune</li></ul>");
$faq[] = array("Créer une liste ordonnée", "Une liste ordonnée affichera chaque item les uns à la suite des autres dans l'ordre de saisie. Chaque item de la liste sera précédé d'une lettre ou d'un chiffre, spécifiant ainsi son numéro d'ordre dans la liste. Pour créer une liste ordonnée avec des items précédés d'une lettre, vous devez encadrez votre texte des balises <b>[list=a][/list]</b>. De la même manière, pour créer une liste ordonnée avec des items précédés d'un chiffre, utilisez les balises <b>[list=1][/list]</b>. Comme pour les listes non-ordonnées, chaque item est définie en utilisant <b>[*]</b>. <ul>Exemple de liste ordonnée alpha : <br /><br /><b>[list=a]</b><br /><b>[*]</b>Rouge<br /><b>[*]</b>Bleu<br /><b>[*]</b>Jaune<br /><b>[/list]</b><br /><br />donnera : </ul><ol type=\"a\"><li>Rouge</li><li>Bleu</li><li>Jaune</li></ol><ul>Exemple de liste ordonnée numérique : <br /><br /><b>[list=1]</b><br /><b>[*]</b>Rouge<br /><b>[*]</b>Bleu<br /><b>[*]</b>Jaune<br /><b>[/list]</b><br /><br />donnera :</ul><ol type=\"1\"><li>Rouge</li><li>Bleu</li><li>Jaune</li></ol>");

$faq[] = array("--", "Créer des liens");
$faq[] = array("Créer un lien vers un autre site", "Le BBCode offre plusieurs possibilités pour créer des liens hypertextes vers d'autres ressources, plus communément appelés URLs (pour Uniform Resource Indicators).<ul><li>La première méthode consiste à utiliser les balises <b>[url=][/url]</b>. Tapez l'adresse vers laquelle pointera votre URL après le signe '=' comme dans l'exemple suivant :<br /><br /><b>[url=http://www.phpbb.com/]</b>Visitez phpBB !<b>[/url]</b>  permet d'obtenir le lien suivant : <a href=\"http://www.phpbb.com/\" target=\"_blank\">Visitez phpBB !</a> <br /><br />Vous noterez que la page web vers laquelle pointe votre lien s'ouvrira dans une nouvelle fenêtre, ce qui permet à l'utilisateur de continuer à utiliser le forum à sa convenance.</li><br /><li>Vous pouvez également afficher l'adresse de votre lien en utilisant les balises <b>[url] [/url]</b> de la manière suivante: <br /><br /><b>[url]</b>http://www.phpbb.com/<b>[/url]</b> ce qui aura pour résultat : <a href=\"http://www.phpbb.com/\" target=\"_blank\">http://www.phpbb.com/</a></li><br /><li>En outre, phpBB intègre la technologie <i>Magic Links</i>. Cette technologie permet de rendre active toute URL correcte sans avoir à utiliser les balises BBCode ou la faire précéder de http://. Par exemple, en saisissant www.phpbb.com dans votre message, celui-ci sera automatiquement reconnu comme un lien actif : <a href=\"http://www.phpbb.com/\" target=\"_blank\">www.phpbb.com</a>.</li><br /><li> Cette règle s'applique également aux adresses de courrier électroniques (e-mails). Ainsi, l'usage des balises <b>[email] [/email]</b> pour encadrer une adresse e-mail aura le même résultat que la saisie directe de cette même adresse <br /><br /><b>[email]</b>nom@domaine.com<b>[/email]</b> et nom@domaine.com auront tous deux pour résultat <a href=\"emailto:nom@domaine.com\">nom@domaine.com</a></li></ul>Enfin, ces balises BBCode peuvent être combinées avec d'autres balises comme <b>[img][/img]</b> (voir paragaphe suivant), <b>[b][/b]</b>, etc... <br />Dans ce cas, veillez à l'ordre d'ouverture des balises et assurez vous de fermer les balises correctement. <br /> Ainsi, l'exemple ci-après n'est pas correct :<br /><ul><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/url][/img]</b></ul>");

$faq[] = array("--", "Afficher une image dans un message");
$faq[] = array("Ajouter une image dans un message", "Le BBCode possède aussi des balises pour inclure des images dans vos messages. Vous devez vous souvenir de deux choses très importantes lorsque vous utiliserez ces balises ! Premièrement, beaucoup d'utilisateurs n'apprécient pas voir apparaitre un nombre important d'images dans les messages. Deuxièmement, l'image que vous voulez afficher doit obligatoirement se trouver sur Internet (elle ne doit pas se trouver sur votre ordinateur, par exemple, sauf si vous postez depuis un ordinateur qui fait office de serveur web !). Il est actuellement impossible d'afficher des images depuis votre ordinateur avec un forum phpBB comme fourni dans le fichier d'installation (des solutions sont succeptibles de se trouver dans la prochaine version de phpBB). Pour afficher une image, vous devez mettre de part et d'autre de l'URL pointant vers l'image les balises <b>[img][/img]</b>. Par exemple :<br/><br/><b>[img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img]</b><br /><br />Comme noté dans la section traitant des liens, vous pouvez aussi utiliser votre image pour comme lien en utilisant les balises <b>[url]<b> et <b>[/url]</b> si vous le désirez. Exemple :<br /><br /><b>[url=http://www.phpbb.com/][img]</b>http://www.phpbb.com/images/phplogo.gif<b>[/img][/url]</b><br /><br />donnera : <br /><br /><a href=\"http://www.phpbb.com/\" target=\"_blank\"><img src=\"templates/subSilver/images/logo_phpBB_med.gif\" border=\"0\" alt=\"\" /></a><br />");

$faq[] = array("--", "D'autres problèmes ?");
$faq[] = array("Est-il possible d'ajouter et d'utiliser mes propres balises ?", "Non, pas dans les versions actuelles. Mais cela sera rendu possible avec la prochaine version majeure.");


//
// This ends the BBCode guide entries
//

?>