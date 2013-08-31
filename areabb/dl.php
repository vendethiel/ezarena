<?
define('IN_PHPBB', true);
$phpbb_root_path = '../';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);

$userdata = session_pagestart($user_ip, PAGE_ARCADES);
init_userprefs($userdata);

//
// Fonction permettant de zipper un dossier.

function zipDir($path,&$zip,$dossier='')
{   
	if (!is_dir($path)) return;
	if (!($dh = @opendir($path)))
	{
		message_die(GENERAL_ERROR, 'Une erreur s\'est produite sur '.$path);
		exit;
	}
	while ($file = readdir($dh))
	{
		if (is_dir($path.'/'.$file) && ($file != '.') && ($file != '..')) 
		{ 
			zipDir($path.'/'.$file,$zip,$dossier.'/'.$file);   
		}elseif (is_file($path.'/'.$file))
		{ 
			$zip->addFile(file_get_contents($path.'/'.$file),$dossier.'/'.$file);
		}
	}
}

// 
// Création du package du jeu demandé

function package_jeu($titre)
{
	global $phpbb_root_path,$phpEx,$areabb;
	// On est développeur et on veut le package de son mod
	load_function('lib.files');
	$package = new files();
	$name = 'AreaBB-jeux_'.$titre.'.pkg.gz';
	
	// on crée le package serialize
	$res =$package->makePackage($name,CHEMIN_JEU.$titre,CHEMIN_JEU,1);
	
	// on l'enregistre dans un fichier
	if (($fp = fopen($phpbb_root_path.$areabb['chemin_pkg_jeux'].$name,'w')) !== false)
	{
		fwrite($fp,$res,strlen($res));
		fclose($fp);
	}
	return true;
}

// As-t-on demander pour télécharger un jeu   ?
if((!empty($HTTP_GET_VARS['jeu_pkg_gz']) || !empty($HTTP_GET_VARS['jeu_zip'])) && $areabb['auth_dwld'] == 1 && $userdata['session_logged_in'])
{
	$gid =  (!empty($HTTP_GET_VARS['jeu_pkg_gz']))? eregi_replace('[^0-9]','',$HTTP_GET_VARS['jeu_pkg_gz']):eregi_replace('[^0-9]','',$HTTP_GET_VARS['jeu_zip']);
	$sql = 'SELECT game_name 
				FROM '. AREABB_GAMES_TABLE.'
				WHERE game_id='.$gid.'
				LIMIT 1';
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Impossible de trouver ce jeu", '', __LINE__, __FILE__, $sql); 
	}
	if ($db->sql_numrows($result) == 0)
	{
		message_die(GENERAL_MESSAGE,"Ce jeu n'existe pas.");
		exit;	
	}else{
		// Maintenant qu'on a suffisament d'info on recherche ce jeu dans les packages.
		$row = $db->sql_fetchrow($result);
		$path = $phpbb_root_path.$areabb['chemin_pkg_jeux'].'AreaBB-jeux_'.$row['game_name'];
		 
		if ($HTTP_GET_VARS['jeu_pkg_gz'] != '')
		{
			// PKG.GZ
			$path .= '.pkg.gz';
			if (!file_exists($path))
			{
				@set_time_limit (0);  
				// On le package et on le stocke pour un futur appel
				if (!package_jeu($row['game_name']))
				{
					message_die(GENERAL_ERROR, "Impossible de packager ce jeu", '', __LINE__, __FILE__, $sql); 
				}
			}
			$champ = 'clics_pkg';
		}elseif ($HTTP_GET_VARS['jeu_zip'] != '')
		{
			// ZIP
			$path .= '.zip';
			if (!file_exists($path))
			{
				require_once($phpbb_root_path.'areabb/lib/ziplib/zip.lib.php');

				// nom du fichier zip que l'on veut
				$fichier_zip = 'AreaBB-jeux_'.$row['game_name'].'.zip';
				$zip= new zipfile;
				 // repertoire que l'on veut zipper
				$chemin_dossier= $phpbb_root_path.$areabb['chemin_pkg_jeux'].$row['game_name'];           
				@set_time_limit (0);            // a parametrer selon vos souhaits
				zipDir($chemin_dossier,$zip,$row['game_name']);
				$filezipped=$zip->file();       // On recupere le contenu du zip dans la variable $filezipped
				$open = fopen($phpbb_root_path.$areabb['chemin_pkg_jeux'].$fichier_zip, "w");    // On la sauvegarde dans le meme repertoire que les fichiers a zipper
				fwrite($open, $filezipped,strlen($filezipped));
				fclose($open);
			}
			$champ = 'clics_zip';
		}
		// on incrémente le compteur ;)
		$sql = 'UPDATE '.AREABB_GAMES_TABLE. ' SET '.$champ.'='.$champ.'+1 WHERE  game_id='.$gid ;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible de mettre à jour ce jeu", '', __LINE__, __FILE__, $sql); 
		}
		// On force le téléchargement...
		header("Content-type: application/force-download");
		header("Content-Length: ".filesize($path));
		header("Content-Disposition: attachment; filename=".basename($path));
		readfile($path);
	}
}elseif($areabb['auth_dwld'] == 0){
	$message = 'Téléchargement de jeux bloqué';
	message_die(GENERAL_MESSAGE, $message);
	exit;
}elseif(!$userdata['session_logged_in']){
	$message = 'Il faut être enregistré pour télécharger';
	message_die(GENERAL_MESSAGE, $message);
	exit;
}
?>