<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                             class_plugins.php
//
//   Commencé le   :  Jeudi 8 juin 2006
//   Par  Saint-Pere www.yep-yop.com
//
// Ce système de plugin est extrait du code créé par Olivier Meunier
// pour Dotclear. Je l'ai un peu remanié pour mon besoin.
// Je remercie donc la communauté Dotclear pour son système 
// que je trouve très performant
//
//
//--------------------------------------------------------------------------------------------------------------------------------------

class plugins
{
	var $location;
	var $type;
	var $_xml;
	var $p_list;
	
	function plugins($location,$type='plugin')
	{
		if (is_dir($location)) {
			$this->location = $location;
		} else {
			$this->location = NULL;
		}
		$this->type = $type;
	}
	
	function getPlugins($active_only=true)
	{
		if (($list_files = $this->_readDir()) !== false)
		{
			$this->p_list = array();
			foreach ($list_files as $entry => $pfile)
			{
				if (($info = $this->_getPluginInfo($pfile)) !== false) 
				{ 
						$this->p_list[$entry] = $info;
				}				
			}
			ksort($this->p_list);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function getPluginsList()
	{
		return $this->p_list;
	}
	
	# Copier d'un fichier binaire distant
	function copyRemote($src,$dest)
	{
	//  On essaye de forcer les limites du serveur..
			
		@set_time_limit(0);
		@max_execution_time(0);
			
		// Si CURL est installé on l'utilise c'est mieux que les sockets.
		if (function_exists('curl_init'))
		{
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $src);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
			$info = curl_exec($curl);
			curl_close($curl);
		}else{
			//  Sinon on utilise Fsocket mais il est limité sur les gros fichiers
			$errno = 0;
			$url = parse_url($src);
			$errstr = $info = '';
			$fichier = '';
			$fichier .= ($url['path'] != '')? $url['path'] : '';
			$fichier .= ($url['query'] != '')? '?'.$url['query'] : '';
			$fsock = @fsockopen($url['host'], 80, $errno, $errstr, 10);
			@fputs($fsock, "GET ".$fichier." HTTP/1.1\r\n");
			@fputs($fsock, "HOST: ".$url['host']." \r\n");
			@fputs($fsock, "Connection: close\r\n\r\n");
			$get_info = false;
			while (!@feof($fsock))
			{
				if ($get_info)
				{
					$info .= @fread($fsock, 1024);
				}
				else
				{
					if (@fgets($fsock, 1024) == "\r\n")
					{
						$get_info = true;
					}
				}
			}
			@fclose($fsock);
		}
		if (($fp2 = @fopen($dest,'w')) === false)
		{
			return ('Impossible d\'écrire les données du jeu sur le disque.');
		}
		else
		{
			fwrite($fp2,$info);
			fclose($fp2);
			return true;
		}
	}
	//
	// Permet d'ajouter ce mod dans la base de données
	//
	function installe($titre,$page)
	{
		global $db;
		
		// lancement du script d'installation
		if (file_exists($this->location.$titre.'/install.php'))
		{
			require_once($this->location.$titre.'/install.php');
		}
		
		// On vérifie si le mod comporte un bloc visible
		if (file_exists($this->location.$titre.'/mod_'.$titre.'.php'))
		{
			$affiche = 1;
		}else{
			$affiche = 0;
		}
		
		// On ajoute ce mod dans la base
		$sql = 'INSERT INTO '. AREABB_MODS.' (nom,page,affiche) 
				VALUES (\''.$titre.'\',\''.$page.'\','.$affiche.')';
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'ajouter ce mod", '', __LINE__, __FILE__, $sql); 
		}
		return true;
	}
	
	//
	// Le mod sera désinstallé
	//
	function supprime($titre,$id)
	{
		global $db;
		
		// lancement du script de suppression
		if (file_exists($this->location.$titre.'/desinstall.php'))
		{
			require_once($this->location.$titre.'/desinstall.php');
		}
		// on supprime le mod d'un bloc.
		$sql = 'UPDATE '.AREABB_BLOCS.' 
			SET id_mod=0, type_mod="" 
			WHERE id_mod='.$id;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible de supprimer ce mod", '', __LINE__, __FILE__, $sql); 
		}
		
		// On supprime ce mod de la base
		$sql = 'DELETE FROM '. AREABB_MODS.' 
				WHERE id_mod=\''.$id.'\'';
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible de supprimer ce mod", '', __LINE__, __FILE__, $sql); 
		}
		
		// On recupere la liste des fichiers à supprimer
		// On les supprime 1 par 1
		 $liste_mods_suppression = array();
		 $max=  sizeof( $liste_mods_suppression);
		 for ($i=0;$i<$max;$i++)
		{
			@unlink($liste_mods_suppression[$i]);
		}		
		
		return true;	
	}
	
	/* Installation d'un plugin */
	function ajoute($url)
	{
		$dest = $this->location.'/'.basename($url);
		if (($err = $this->copyRemote($url,$dest)) !== true)
		{
			message_die(GENERAL_MESSAGE,$err);
			exit;
		}
		else
		{
			if (($content = @implode('',@gzfile($dest))) === false) {
				message_die(GENERAL_MESSAGE,"Impossible de lire le fichier");
				exit;
			} else {
				if (($list = unserialize($content)) === false)
				{
					message_die(GENERAL_MESSAGE,"Mod non valide");
					exit;
				}
				else
				{
					if (is_dir($this->location.'/'.$list['name']))
					{
						unlink($dest);
						message_die(GENERAL_MESSAGE,"Ce mod existe déjà. Supprimez le avant.");
						exit;
					}
					
					foreach ($list['dirs'] as $d)
					{
						mkdir ($this->location.'/'.$d,0777);
						chmod($this->location.'/'.$d,0777);
					}
					
					foreach ($list['files'] as $f => $v)
					{
						$v = base64_decode($v);
						$fp = fopen($this->location.'/'.$f,'w');
						fwrite($fp,$v,strlen($v));
						fclose($fp);
						chmod($this->location.'/'.$f,0777);
					}
					
					unlink($dest);
				}
			}
		}
		return true;
	}
	
	/* Lecture d'un répertoire à la recherche des desc.xml */
	function _readDir()
	{
		if ($this->location === NULL) {
			return false;
		}
		
		$res = array();
		
		$d = dir($this->location);
		
		# Liste du répertoire des plugins
		while (($entry = $d->read()) !== false)
		{
			if ($entry != '.' && $entry != '..' &&
			is_dir($this->location.$entry) && file_exists($this->location.$entry.'/details.xml'))
			{
				$res[$entry] = $this->location.$entry.'/details.xml';
			}
		}
		return $res;
	}
	
	function _getPluginInfo($p)
	{

		if (file_exists($p))
		{
			$this->_current_tag_cdata = '';
			$this->_p_info = array(
			'nom'=>NULL,
			'label'=>NULL,
			'description'=>NULL,
			'version'=>NULL,
			'page'=>NULL,
			'auteur'=>NULL);
			
			$this->_xml = xml_parser_create('ISO-8859-1');
			xml_parser_set_option($this->_xml, XML_OPTION_CASE_FOLDING, false);
			xml_set_object($this->_xml, $this);
			xml_set_element_handler($this->_xml,'_openTag','_closeTag');
			xml_set_character_data_handler($this->_xml, '_cdata');
			
			xml_parse($this->_xml,implode('',file($p)));
			xml_parser_free($this->_xml);
			if (!empty($this->_p_info['nom']))
			{
				return $this->_p_info;
			} else {
				return false;
			}
		}
	}
	
	function _openTag($p,$tag,$attr)
	{
		if ($tag == $this->type && !empty($attr['nom']))
		{
			$this->_p_info['nom']			= $attr['nom'];
			$this->_p_info['version']		= $attr['version'];
			$this->_p_info['page']			= $attr['page'];
			$this->_p_info['label']			= $attr['label'];
			$this->_p_info['auteur']		= $attr['auteur'];
			$this->_p_info['description']	= $attr['description'];
		}
		if ($tag == 'callback') {
			$this->_p_info['callbacks'][] = array($attr['event'],$attr['function']);
		}
	}
	
	function _closeTag($p,$tag)
	{
		switch ($tag)
		{
			case 'auteur':
			case 'label':
			case 'page':
			case 'description':
				$this->_p_info[$tag] = $this->_current_tag_cdata;
				break;
		}
	}
	
	function _cdata($p,$cdata)
	{
		$this->_current_tag_cdata = $cdata;
	}
}

?>