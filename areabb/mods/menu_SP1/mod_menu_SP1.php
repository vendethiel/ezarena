<?php
/***************************************************************************
*                                mod_menu_SP1.php
*
* Adapté par Saint-Pere le lundi 29 Mai 2006 - www.yep-yop.com
*
* Ce bloc affiche un menu vertical dynamique. Les sous menus s'ouvrent latéralement
*  
***************************************************************************/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $squelette,$areabb,$lang,$theme;
load_lang('arcade');

$template->set_filenames(array(
      'mod_menu_SP1' => 'areabb/mods/menu_SP1/tpl/arcade_menu_SP1.tpl'
)); 

//-------------------------------------------------------------------------------------
//		AFFICHAGE des CATEGORIES
//
load_function('class_liste_categories');
$categorie = new liste_categorie($squelette->id_squelette);
$categorie ->recup_infos_cat();



// affichage de l'icone de catégorie si il est coché dans l'ACP
if ($areabb['affichage_icone'] == 1) $categorie ->affichage_icone();

// Affichage du nombre de jeux si c'est coché dans l'ACP
if ($areabb['affichage_nbre_jeux'] == 1) $categorie ->affichage_nbre_jeux();


//
// affiche la liste des catégories
// les sous-catégories s'affichent à coté
//
$menu = "\n<ul class=\"menulist\" id=\"listMenuRoot\">\n";

for ($i=0;$i<$categorie->nbre_categorie;$i++)
{
	// C'est une catégorie racine 
	if ($categorie->liste_cat[$i]['parent'] == 0)
	{
		// On affiche le lien
		$menu .= "\n<li><a href=\"".$categorie->liste_cat[$i]['lien'].'" title="'.stripslashes($categorie->liste_cat[$i]['titre']).'">';
		$menu .= $categorie->icone[$i].'&nbsp;'.stripslashes($categorie->liste_cat[$i]['titre']) .$categorie->nbre_jeux[$i].'</a>';
		
		$i_sous_menu = 0;
		$sous_menu = '';
		// on cherche d'éventuels enfants
		FOR ($a=0;$a<$categorie->nbre_categorie;$a++)
		{
			// C'est un enfant de cette catégorie
			if ($categorie->liste_cat[$a]['parent'] == $categorie->liste_cat[$i]['id'])
			{
				$i_sous_menu++;
				$sous_menu .= '<li><a href="'.$categorie->liste_cat[$a]['lien'].'" title="'.stripslashes($categorie->liste_cat[$a]['titre']).'">';
				$sous_menu .= $categorie->icone[$a].'&nbsp;'.stripslashes($categorie->liste_cat[$a]['titre']) .$categorie->nbre_jeux[$a].'</a></li>';
			}
		}
		// on monte le sous menu
		if ($i_sous_menu > 0)
		{
			$menu .= "\n<ul>".$sous_menu."</ul>\n";
		}
		$menu .= "</li>\n";
	}			
}
$menu .= "</ul>\n";
$style = '

<style type="text/css">
.menulist, .menulist ul {
	background-color:#'.$theme['tr_color1'].';
}
.menulist ul {
	background-color:#'.$theme['tr_color1'].';
	border: 2px solid #'.$theme['th_color2'].';
}
.menulist a {
	color: #'.$theme['body_link'].';
	font-family:'.$theme['fontface2'].';
	font-size:'.$theme['fontsize3'].';
}
.menulist a:hover, .menulist a.highlighted:hover, .menulist a:focus {
	color: #'.$theme['body_link'].';
	font-family:'.$theme['fontface2'].';
	font-size:'.$theme['fontsize3'].';
	background-color:#'.$theme['tr_color2'].';
	border: 0px solid #'.$theme['th_color2'].';
	height:30px;
}
</style>
';

$template->assign_vars(array(	
	'CAT' => $menu,
	'ENTETE' => $style,
	'L_TITRE'	=> $lang['LES_CAT']
));

$template->assign_var_from_handle('menu_SP1', 'mod_menu_SP1'); 

?>