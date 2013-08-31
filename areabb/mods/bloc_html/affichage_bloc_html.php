<?php
/*********************************************************************
*		  affichage_bloc_html.php
*
*  Commencé le 20 juillet 2006 par Saint-Pere - www.yep-yop.com
*
*  Cette page permet de traiter le contenu des blocs HTML
*  Le PHP inclus y est extrait affin de pouvoir en executer le contenu
*
**********************************************************************/
if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

global $id_BLOC_HTML, $affiche,$squelette;

$template->set_filenames(array(
	'bloc_html'.$id_BLOC_HTML => 'areabb/mods/bloc_html/tpl/bloc_html.tpl'
));
//
// fonction permettant d'écrire le fichier PHP
if (!function_exists('creer_fichier_php'))
{
	function creer_fichier_php($NomFichier,$contenu)
	{
		$rFile = fopen($NomFichier,"w+");
		//$rFile = tmpfile();
		if (!$rFile) {
			die("ERREUR: Impossible d'ecrire dans le dossier 1 " . dirname(realpath($NomFichier)) ." (avez vous fait un CHMOD 777 ? )") ;
		}
		fwrite($rFile,'<?php '.$contenu.' ?>');
		fclose($rFile);
		return true;
		
	}
}
// on va décomposer le contenu du bloc en morceau délimité par un  marqueur <ph>
$parties = explode('<php>',$squelette->liste_blocs_html[$id_BLOC_HTML]['message']);

// On part du principe où le php est encadré par le marqueur DONC
// la première entrée du tableau $parties est forcement du HTML. 
// $parties[0] et tous les numéros pair vont contenir du HTML
// les numéros impair contiendront du PHP

$nbre_parties = sizeof($parties);
$affiche = '';
for ($i=0;$i<$nbre_parties;$i++)
{
	if ($i%2 == 0)
    	{
		// pair donc HTML
        	$affiche .= $parties[$i];
	}else{
		// impaire donc du PHP
		$NomFichier = 'areabb/cache/'. substr(md5(uniqid(rand())),0,10).'.php'; 
		
		// FCKeditor à la facheuse manie de nettoyer le code et de refermer les balises ouvertes
		// on doit donc virer les balises fermantes avant affichage.
		creer_fichier_php($NomFichier,str_replace('</php>','',$parties[$i]));
		include_once($NomFichier);
		//
		// Si la personne veut que l'affichage sorte DANS LE BLOC il devra rediriger le flux vers $affiche	
		//
		
		// on efface ce fichier temporaire créé.
		// il faudra songer un systeme qui permette de ne pas créer un fichier à durée de vie si faible 
		// Peut être créer le fichier dans sauv_squelette.php ? 	
		
		// on efface le fichier temporaire
		unlink($NomFichier);
	}
}
$template->assign_vars(array(
	'TITRE'	  => $squelette->liste_blocs_html[$id_BLOC_HTML]['titre'],
	'MESSAGE' => $affiche
));

$template->assign_var_from_handle('HTML_'.$id_BLOC_HTML, 'bloc_html'.$id_BLOC_HTML);
?>