<?php
/***************************************************************************
 *                             areabb_squelette_blocs.php
 *                            -------------------
 *   Commencé le samedi 10 juin 2006
 *   Par Saint-Pere www.yep-yop.com
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);

//
// Let's set the root dir for phpBB
//
define('ROOT_STYLE','admin');
$phpbb_root_path = '../../../';
require($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
load_lang('admin');

// Nombre de caracteres à afficher pour les blocs HTML
$nbcar = 100;
load_function('class_squelette');
$squelette = new generation_squelette($phpbb_root_path);
$squelette->id_squelette	= eregi_replace('[^0-9]','',$HTTP_GET_VARS['id_squelette']);


// --------------------------------------------------------------------------------------------
//    AFFICHAGE
//

$template->set_filenames(array(
	'body' => 'areabb/mods/config/tpl/areabb_squelette_blocs.tpl'
));

// Quel est le type de page de cette salle ?
$sql = 'SELECT type 
	FROM '.AREABB_SQUELETTE.' 
	WHERE id_squelette='.$squelette->id_squelette;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Impossible de récuperer le type de cette salle', '', __LINE__, __FILE__, $sql); 
}
$row = $db->sql_fetchrow($result);
$type_salle = $row['type'];
//
// Liste des mods dispos 
//
$sql = 'SELECT id_mod,nom,page 
		FROM '. AREABB_MODS .' 
		WHERE affiche=1
		ORDER BY nom ASC';

if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Impossible de récuperer la liste des mods dispos', '', __LINE__, __FILE__, $sql); 
}
$listes_mods = array();
while ($row = $db->sql_fetchrow($result))
{
	if ($row['page'] == '?' || in_array($type_salle, explode(',',$row['page'])))
	{
		$listes_mods[$row['nom']] = $row['id_mod'];
	}
}	

//
// Infos détaillés fournies par les fichiers XML
//

load_function('class_plugins');
$plugins = new plugins(CHEMIN_MODS);
$plugins->getPlugins(true);
$plugins_list = $plugins->getPluginsList();

$mods_dispos = '';
foreach ($plugins_list as $k => $v)
{
	if (array_key_exists($k,$listes_mods))
	{
		$id_mod = $listes_mods[$k];
		$mods[$id_mod]['nom']= $k;
		$mods[$id_mod]['label']= $v['label'];
		$mods[$id_mod]['description']= $v['description'];
		
		// affichage des mods dispos
		$mods_dispos .= '<li id="mod_'.$id_mod.'" style="background-image:url('.CHEMIN_MODS.$k.'/logo.png);background-repeat:no-repeat;background-position:bottom center"><b>'.$v['label'].'</b></li>'."\n";
	}
}

// On va également récuperer la liste des blocs HTML que l'on a créé.

$sql = 'SELECT id_bloc, titre, message 
	FROM '. AREABB_BLOCS_HTML.' 
	ORDER BY titre ASC' ;
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, "Impossible de récuperer la liste des blocs HMTL", '', __LINE__, __FILE__, $sql); 
}
$liste_blocs_html = '';
while ($row = $db->sql_fetchrow($result))
{
	// affichage des mods dispos
	$liste_blocs_html .= '<li id="HTML_'.$row['id_bloc'].'"  style="background-image:url('.CHEMIN_MODS.'/bloc_html/logo.png);background-repeat:no-repeat;background-position:bottom center"><b>'.$row['titre'].'</b></li>'."\n";
}



//
// on crée un affichage schematique de ce squelette
//
$squelette->assembler_squelette();
$squelette->afficher_blocs($mods);

// On rajoute le lien vers la feuille correspondante
$feuille = '<a href="'.append_sid('areabb_squelette_feuilles.'.$phpEx.'?id_squelette='.$squelette->id_squelette).'">';
$feuille .= '<img src="'.$phpbb_root_path .$images['icon_areabb_feuilles'].'" border="0"></a>';

$template->assign_vars(array(	
	'ID_SQUELETTE'		=> $squelette->id_squelette,
	'MODS_DISPOS'		=> $mods_dispos.$liste_blocs_html,
	'SQUELETTE'			=> $squelette->squelette,
	'L_BLOCS'			=> $lang['L_BLOCS'],
	'L_EXPLAIN_BLOCS'	=> sprintf($lang['L_EXPLAIN_BLOCS'],$feuille),
	'L_MODS_DISPOS'		=> $lang['L_MODS_DISPOS'],
	'L_MODS_CASES'		=> $lang['L_MODS_CASES'],
	'L_ENREGISTRER'		=> $lang['L_ENREGISTRER']
));	

// Génération de la page

$template->pparse("body");

include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);

?>