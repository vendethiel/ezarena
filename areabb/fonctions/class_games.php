<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                             class_games.php
//
//   Commencé le   :  Jeudi 8 juin 2006
//   Par  Saint-Pere www.yep-yop.com
//
//
//--------------------------------------------------------------------------------------------------------------------------------------

class games
{
	var $location;
	var $type;
	var $_xml;
	var $p_list;
	
	function games($location,$type='game')
	{
		if (is_dir($location)) {
			$this->location = $location;
		} else {
			$this->location = NULL;
		}
		$this->type = $type;
	}
	
	//
	// Modifie l'ordre d'affichage des jeux
	
	function monter_jeu($game_id,$arcade_catid,$sens='+')
	{
		global $db;
		$liste_jeux= array();
		
		$sql = 'SELECT game_id
				FROM '. AREABB_GAMES_TABLE .' 
				WHERE arcade_catid='.$arcade_catid;
		$sql .= ' ORDER BY game_order ASC';
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'obtenir des infos sur ce squelette", '', __LINE__, __FILE__, $sql); 
		}
		while ($row = $db->sql_fetchrow($result))
		{
			$liste_jeux[] = $row['game_id'];
		}
		if (in_array($game_id,$liste_jeux))
		{
			$clef = array_search($game_id,$liste_jeux);
			switch ($sens)
			{
				case '+':
					$tmp = $liste_jeux[$clef]; 
					$liste_jeux[$clef] = $liste_jeux[($clef-1)];
					$liste_jeux[($clef-1)] = $tmp;
					break;
				case '-':
					$tmp = $liste_jeux[$clef]; 
					$liste_jeux[$clef] = $liste_jeux[($clef+1)];
					$liste_jeux[($clef+1)] = $tmp;		
					break;		
			}
			$cmpt = count($liste_jeux);
			for ($i=0;$i<$cmpt;$i++)
			{
				$sql = 'UPDATE '. AREABB_GAMES_TABLE .' 
						SET game_order='.$i.' 
						WHERE game_id='.$liste_jeux[$i];
				$db->sql_query($sql);
			}
			return true;
		}else{
			return false;
		}
		
	}
	//
	// Permet de mettre à jour le nombre de jeux stockés dans chaque catégorie
	//
	function resynch_arcade_categorie($catid=NULL)
	{
		global $db;
		$sql = 'SELECT COUNT(game_id) AS Nb,arcade_catid 
				FROM ' . AREABB_GAMES_TABLE . '
				GROUP BY arcade_catid'; 
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des catégories", "", __LINE__, __FILE__, $sql);
		}
		while ($row = $db->sql_fetchrow($result))
		{
			$cat_utilisees[] = $row['arcade_catid'];
			$sql2 = 'UPDATE ' . AREABB_CATEGORIES_TABLE . ' 
					SET arcade_nbelmt = '.$row['Nb'] .'
					WHERE arcade_catid ='.$row['arcade_catid']; 
			if( !$resultat = $db->sql_query($sql2) )
			{
				message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des catégories", "", __LINE__, __FILE__, $sql);
			}
		}
		$sql = 'UPDATE ' . AREABB_CATEGORIES_TABLE . ' 
				SET arcade_nbelmt = 0
				WHERE arcade_catid NOT IN ('.implode(', ',$cat_utilisees).')';
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des catégories", "", __LINE__, __FILE__, $sql);
		}
		return true;
	}
	//
	// Ajoute un nouveau jeu dans la base 
	//
	function createsave_jeu($next_order,$game_pic,$game_pic_large,$game_desc,$game_name,$game_swf,$game_width,$game_height,$game_scorevar,$game_type,$arcade_catid,$cheater)
	{
			global $db;
			
			// On cherche la position maximale dans les jeux existants
			$sql = 'SELECT MAX(game_order) AS max_order
				FROM ' . AREABB_GAMES_TABLE;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible d'obtenir le dernier numéro d'ordre de la table jeux", "", __LINE__, __FILE__, $sql);
			}
			$row = $db->sql_fetchrow($result);

			// on définit la position max de notre nouveau jeu
			$max_order = $row['max_order'];
			$next_order = $max_order + 10;

			// on fait péter la roquete
			$sql = 'INSERT INTO ' . AREABB_GAMES_TABLE . '
			( game_order, game_pic, game_pic_large, game_desc, game_highscore, game_highdate, game_highuser, game_libelle, game_swf, game_width, game_height, game_scorevar, game_type, arcade_catid,game_cheat_control ) 
			VALUES 
			('.$next_order.',
			\''.$game_pic.'\',
			\''.$game_pic_large.'\',
			\'' . $game_desc . '\',
			0,
			0,
			0,
			\'' . $game_name . '\',
			\''.$game_swf.'\',
			\''.$game_width.'\',
			\''.$game_height.'\',
			\''.$game_scorevar.'\',
			\''.$game_type.'\',
			\''.$arcade_catid.'\',
			\''.$cheater.'\'
			)';		
			
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't insert row in games table", "", __LINE__, __FILE__, $sql);
			}
			$sql = 'UPDATE ' . AREABB_CATEGORIES_TABLE . ' SET
					arcade_nbelmt = arcade_nbelmt + 1 
					WHERE arcade_catid = '.$arcade_catid;				
			if( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Couldn't update categories table", "", __LINE__, __FILE__, $sql);
			}
		return true;	
	}
	
	//
	// Edition de la fiche d'un jeu 
	//
	function editsave_jeu($game_name,$game_desc,$game_pic,$game_pic_large,$game_scorevar,$game_swf,$game_width,$game_height,$game_type,$arcade_catid,$game_id,$last_catid,$cheater)
	{
		global $db;
		
		$sql = 'UPDATE ' . AREABB_GAMES_TABLE . ' SET 
				game_libelle 	= \'' . $game_name . '\',
				game_desc 	= \'' . $game_desc . '\',
				game_pic 	= \'' . $game_pic . '\',
				game_pic_large 	= \'' . $game_pic_large . '\',
				game_scorevar 	= \'' . $game_scorevar . '\',
				game_swf 	= \'' . $game_swf . '\',
				game_width 	= ' . $game_width . ',
				game_height 	= ' . $game_height . ',
				game_type 	= ' . $game_type . ',
				arcade_catid 	= ' . $arcade_catid . ',
				game_cheat_control = \''. $cheater .'\' 
				WHERE game_id 	= ' . $game_id;
			
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update game informations", "", __LINE__, __FILE__, $sql);
		}

		$this->resynch_arcade_categorie();
		return true;
	}
	
	//
	// Remet les scores à 0 des jeux selectionnés 
	//
	function resetscore_jeu($select_id_sql)
	{
		global $db;
		$sql = 'DELETE FROM ' . AREABB_SCORES_TABLE . ' 
				WHERE game_id IN ('.$select_id_sql.')';
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des scores', '', __LINE__, __FILE__, $sql);
		}
		$sql = 'UPDATE ' . AREABB_GAMES_TABLE . ' SET 
				game_highscore = 0, 
				game_highuser = 0, 
				game_highdate = 0 
				WHERE game_id IN ('.$select_id_sql.')';
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des jeux', '', __LINE__, __FILE__, $sql);
		}
		return true;
	}
	
	//
	// Supprime un jeu de la base
	//
	function suppr_jeu($select_id_sql,$arcade_catid,$csc)
	{
		global $db;
		$sql = 'DELETE FROM ' . AREABB_SCORES_TABLE . ' 
				WHERE game_id IN ('.$select_id_sql.')';
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des scores', '', __LINE__, __FILE__, $sql);
		}
		$sql = 'DELETE FROM ' . AREABB_GAMES_TABLE . ' 
				WHERE game_id IN ('.$select_id_sql.')';
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des jeux', '', __LINE__, __FILE__, $sql);
		}
		$sql = 'DELETE FROM ' . AREABB_NOTE . ' 
				WHERE game_id IN ('.$select_id_sql.')';
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des notes', '', __LINE__, __FILE__, $sql);
		}
		$sql = 'UPDATE ' . AREABB_CATEGORIES_TABLE . ' SET 
				arcade_nbelmt = arcade_nbelmt - '.$csc.' 
				WHERE arcade_catid = '.$arcade_catid;				
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update categories table", "", __LINE__, __FILE__, $sql);
		}
		return true;	
	}
	
	//
	// met à jour le nombre de parties
	//
	function synchro_jeu($select_id_sql)
	{
		global $db;
		$sql = 'SELECT SUM(score_set) AS nbset, game_id 
				FROM ' . AREABB_SCORES_TABLE . '  
				WHERE game_id IN ('.$select_id_sql.') 
				GROUP BY game_id';
		if ( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Impossible d\'accéder à la table des scores', '', __LINE__, __FILE__, $sql);
		}

		while ($row = $db->sql_fetchrow($result))
		{
			$sql2 = 'UPDATE ' . AREABB_GAMES_TABLE . ' 
					SET game_set = ' . $row['nbset'] .'
					WHERE game_id = ' . $row['game_id'];
			if ( !$db->sql_query($sql2) )
			{
				message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des jeux', '', __LINE__, __FILE__, $sql);
			}
		}
		return true;
	}
		
	//
	//  Change la catégorie d'un jeu
	//
	function deplacer_jeu($cat_id,$select_id_sql)
	{
		global $db;
		$sql = 'UPDATE '.AREABB_GAMES_TABLE.' 
				SET arcade_catid='.$cat_id.' 
				WHERE game_id IN('.$select_id_sql.')';
		if ( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Impossible de mettre à jour la table des jeux', '', __LINE__, __FILE__, $sql);
		}
		 $this->resynch_arcade_categorie($cat_id);
		return true;
	}
	//
	// Récupere toutes les informations contenues dans info.xml dans tous els dossiers
	//
	function getGames()
	{
			if (($list_files = $this->_readDir()) !== false)
			{
				$this->p_list = array();
				foreach ($list_files as $entry => $pfile)
				{
					if (($info = $this->_getGamesInfo($pfile)) !== false) 
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
		
	function getGamesList()
	{
		return $this->p_list;
	}
		
	# Copie d'un fichier binaire distant
	function copyRemote($src,$dest)
	{
		//  On essaye de forcer les limites du serveur..
		@set_time_limit(0);

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
	// Permet d'ajouter ce jeu dans la base de données
	//
	function installe($titre)
	{
		global $db;
		
		// On cherche la position maximale dans les jeux existants
		$sql = 'SELECT MAX(game_order) AS max_order
			FROM ' . AREABB_GAMES_TABLE;
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'obtenir le dernier numéro d'ordre de la table jeux", "", __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);

		// on définit la position max de notre nouveau jeu
		$max_order = $row['max_order'];
		$next_order = $max_order + 10;
			
		// On crée le chemin vers le .xml
		$pfile = $this->location.$titre.'/info.xml';
		
		// On recupere les infos du info.xml
		if (($info = $this->_getGamesInfo($pfile)) !== false) 
		{ 
				$this->p_list = $info;
		}
		
		// On ajoute ce jeu dans la base
		$sql = 'INSERT INTO '. AREABB_GAMES_TABLE.' 
		(game_date,game_order,game_libelle,game_pic,game_pic_large, game_desc, game_name, game_swf, game_scorevar, game_type, game_width, game_height, game_cheat_control) 
				VALUES 
		('.time().',
		'.$next_order.',
		\''.addslashes($this->p_list['label']).'\',
		\''.addslashes($this->p_list['icone']).'\',
		\''.addslashes($this->p_list['image']).'\',
		\''.addslashes($this->p_list['description']).'\',
		\''.addslashes($this->p_list['nom']).'\',
		\''.addslashes($this->p_list['jeu']).'\',
		\''.addslashes($this->p_list['variable']).'\',
		'.intval($this->p_list['type']).',
		'.intval($this->p_list['largeur']).',
		'.intval($this->p_list['hauteur']).',
		'.intval($this->p_list['CheaterTracker']).'
		)';
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'ajouter ce jeu", '', __LINE__, __FILE__, $sql); 
		}
		$this->resynch_arcade_categorie();
		return true;
	}
	

	
	// Installation d'un jeu
	function ajoute($url)
	{
		$dest = $this->location.basename($url);
		$dest = '../../cache/'.substr(md5($dest),8);
		if (($err = $this->copyRemote($url,$dest)) !== true)
		{
			message_die(GENERAL_MESSAGE,$err);
			exit;
		}
		else
		{
			if (($content = @implode('',@gzfile($dest))) === false) {
				message_die(GENERAL_MESSAGE,'Impossible de lire le fichier');
				exit;
			} else {
				if (($list = unserialize($content)) === false)
				{
					message_die(GENERAL_MESSAGE,'Jeu non valide, vérifiez que c\'est bien une archive .pkg.gz créée spécifiquement pour AreaBB');
					exit;
				}
				else
				{
					if (is_dir($this->location.$list['dirs'][0]))
					{
						unlink($dest);
						message_die(GENERAL_MESSAGE,'Ce jeu existe déjà. Supprimez le avant.');
						exit;
					}
				
					foreach ($list['dirs'] as $d)
					{
						mkdir ($this->location.$d,0777);
						chmod($this->location.$d,0777);
					}
					
					foreach ($list['files'] as $f => $v)
					{
						$v = base64_decode($v);
						$fp = fopen($this->location.$f,'w');
						fwrite($fp,$v,strlen($v));
						fclose($fp);
						chmod($this->location.$f,0777);
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
			is_dir($this->location.$entry) && file_exists($this->location.$entry.'/info.xml'))
			{
				$res[$entry] = $this->location.$entry.'/info.xml';
			}
		}
		return $res;
	}
	
	function _getGamesInfo($p)
	{

		if (file_exists($p))
		{
			$this->_current_tag_cdata = '';
			$this->_p_info = array(
			'nom'=>NULL,
			'label'=>NULL,
			'description'=>NULL,
			'adapteur'=>NULL,
			'type'=>NULL,
			'variable'=>NULL,
			'CheaterTracker'=>NULL,
			'largeur'=>NULL,
			'hauteur'=>NULL,
			'icone'=>NULL,
			'image'=>NULL,
			'jeu'=>NULL
			);
			
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
			$this->_p_info['label']			= $attr['label'];
			$this->_p_info['description']	= $attr['description'];
			$this->_p_info['adapteur']		= $attr['adapteur'];
			$this->_p_info['type']			= $attr['type'];
			$this->_p_info['variable']		= $attr['variable'];
			$this->_p_info['CheaterTracker']= $attr['CheaterTracker'];
			$this->_p_info['largeur']		= $attr['largeur'];
			$this->_p_info['hauteur']		= $attr['hauteur'];
			$this->_p_info['icone']			= $attr['icone'];
			$this->_p_info['image']			= $attr['image'];
			$this->_p_info['jeu']			= $attr['jeu'];
		}
		if ($tag == 'callback') {
			$this->_p_info['callbacks'][] = array($attr['event'],$attr['function']);
		}
	}
	
	function _closeTag($p,$tag)
	{
		switch ($tag)
		{
			case 'label':
			case 'description':
			case 'adapteur':
			case 'type':
			case 'variable':
			case 'CheaterTracker':
			case 'largeur':
			case 'hauteur':
			case 'icone':
			case 'image':
			case 'jeu':
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