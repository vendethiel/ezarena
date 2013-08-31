<?php

/**************************************************************************
                                mod_liens.php

	Par Saint-Pere www.yep-yop.com

***************************************************************************/


if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $areabb;
load_lang('liens');
//
//  A-t-on activé le cache ?

if ($areabb['liens_cache'] == 1)
{
	$template->set_filenames(array(
	      'liens' => 'areabb/mods/liens/tpl/mod_cache_liens.tpl'
	));
	// Lecture du cache
	$rFile = @fopen(CHEMIN_LIENS,"r");
	if (!$rFile) {
		return "ERREUR: Impossible de lire le fichier en cache : " . dirname(realpath(CHEMIN_LIENS)) ;
	}
	$contenu =  fread($rFile,filesize(CHEMIN_LIENS));
	fclose($rFile);
	
	$template->assign_vars(array(	
		'CONTENU'		=> $contenu
	));	

}else{
	// Pas de cache alors on charge les liens.
	$template->set_filenames(array(
	      'liens' => 'areabb/mods/liens/tpl/mod_liens.tpl'
	));

	$ordre = ($areabb['liens_aleatoire'] == '1')? ' RAND() ' : ' ordre ASC ';
	$limit = ($areabb['liens_nbre_liens'] == '0')? ' 100 ' : $areabb['liens_nbre_liens'];

	$sql = 'SELECT id_lien, titre, lien, vignette 
		FROM '. AREABB_LIENS .' 
		ORDER BY '.$ordre.' 
		LIMIT '.$limit;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain link information', '', __LINE__, __FILE__, $sql);
	}
	while ($row = $db->sql_fetchrow($result))
	{
		$titre = $row['titre'];
		// si il y a une image on l'affiche
		if ($row['vignette'] != '')
		{
			$image = '<img src="'.$row['vignette'].'" border="0" alt="'.$row['titre'].'">';
			$titre = '';
		}	
		$template->assign_block_vars('liens', array(
			// on crée un lien renvoyant vers ce mod
			'IMAGE'	=> $image,
			'TITRE' => $titre,
			'LIEN'	=> $row['lien']
		));
	}

	// on affiche le scroll ? 
	if ($areabb['liens_scroll'] == 1) $template->assign_block_vars('scroll', array());
		
	$template->assign_vars(array(	
		'L_MOD_LIENS'	=> $lang['L_MOD_LIENS']
	));	
}
	
$template->assign_var_from_handle('liens', 'liens');

?>