<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//					class_jeux.php
//
//   Commencé le   :  Mardi 20 juin 2006
//   Par Saint-Pere www.yep-yop.com
//
//--------------------------------------------------------------------------------------------------------------------------------------


class jeux
{
	var $gid;
	var $info_jeu;
	var $liste_score;
	var $affichage;
	var $scriptpath;
	
	function jeux()
	{
	}
	//
	// Récupere les informations que l'on possede sur ce jeu
	//
	function recup_infos()
	{
		global $db;
		$sql = 'SELECT g.*  
				FROM ' . AREABB_GAMES_TABLE . ' as g  
				WHERE g.game_id = '.$this->gid.' 
				LIMIT 1' ; 
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'acceder à la tables des jeux", '', __LINE__, __FILE__, $sql); 
		}
		if ( !( $row = $db->sql_fetchrow($result) ) )
		{
			message_die(GENERAL_ERROR, "Ce jeu n'existe pas", '', __LINE__, __FILE__, $sql); 
		}
		$this->info_jeu = $row;
		return true;
	}
	
	//
	// incrémente le compteur de parties 
	//
	function incremente_gameset()
	{
		global $db;
		$sql = 'UPDATE ' . AREABB_GAMES_TABLE . ' 
				SET game_set = game_set+1 
				WHERE game_id = '.$this->gid; 
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des jeux", '', __LINE__, __FILE__, $sql); 
		}
		return true;
	}

	//
	// récupere la liste des scores
	function recup_liste_scores($limit=15)
	{
		global $db;
		$sql = 'SELECT s.* ,u.user_id, u.username, u.user_avatar_type, u.user_allowavatar, u.user_avatar 
				FROM ' . AREABB_SCORES_TABLE . ' as s 
				LEFT JOIN ' . USERS_TABLE . ' as u 
				ON s.user_id = u.user_id 
				WHERE s.game_id = '.$this->gid.' 
				ORDER BY s.score_game DESC, s.score_date ASC 
				LIMIT 0,'.$limit ;

		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des scrores", '', __LINE__, __FILE__, $sql); 
		}

		$i = 1 ;
		$score_precedent = -999999;
		$position_precedente = 0;
		while ( $row = $db->sql_fetchrow($result) ) 
		{
			// On compare le score actuel avec le score précédent
			if ($row['score_game'] == $score_precedent)
			{
				$position = $position_precedente;
			}else{
				$position++;
				$position_precedente = $position;
			}
			$this->liste_score[$i]['position']	= $position;
			$this->liste_score[$i]['avatar']	= $this->affiche_avatar($row['user_avatar_type'],$row['user_allowavatar'],$row['user_avatar']);
			$this->liste_score[$i]['username']	= $row['username'];
			$this->liste_score[$i]['user_id']	= $row['user_id'];
			$this->liste_score[$i]['score']		= $row['score_game'];
			$this->liste_score[$i]['date']= create_date( $board_config['default_dateformat'] , $row['score_date'] , $board_config['board_timezone'] );
			$i++;
		}
		return true;
	}
	
	//
	// affiche l'avatar selectionné
	//
	function affiche_avatar($user_avatar_type,$user_allowavatar,$user_avatar)
	{
		global $board_config;
		if ( $user_avatar_type && $user_allowavatar ) 
		{ 
			switch( $user_avatar_type ) 
			{ 
				case USER_AVATAR_UPLOAD: 
					$avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $user_avatar . '" alt="" border="0" hspace="20" align="center" valign="center">' : ''; 
					break; 
				case USER_AVATAR_REMOTE: 
					$avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $user_avatar . '" alt="" border="0"  hspace="20" align="center" valign="center">' : ''; 
					break; 
				case USER_AVATAR_GALLERY: 
					$avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $user_avatar . '" alt="" border="0"  hspace="20" align="center" valign="center">' : ''; 
					break; 
			} 
			return $avatar_img;
		}else{
			return '';
		}			
	}


	//
	// lance une partie... initialise les variables de session..
	//
	function definir_partie()
	{
		global $board_config,$userdata,$db;
		// on active l'affichage suivant le type
		if (( $this->info_jeu['game_type'] == 3 ) || ($this->info_jeu['game_type'] == 4) )
		{
			$this->affichage = 'game_type_V2';
		}
		else
		{
			$this->affichage = 'game_type_V1';
		}
		$sql = 'UPDATE '.SESSIONS_TABLE.' 
				SET areabb_tps_depart='.time().', 
					areabb_gid='.$this->gid.', 
					areabb_variable=\''.$this->info_jeu['game_scorevar'].'\'
				WHERE session_id=\''.$userdata['session_id'].'\'';
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d\'accéder à la tables des sessions", '', __LINE__, __FILE__, $sql); 
		}
		
		// on définit l'URL du site.
		if ( substr($board_config['script_path'] , strlen( $board_config['script_path'] ) - 1 , 1 ) == '/')
		{
				$scriptpath =  substr( $board_config['script_path'] , 0 , strlen( $board_config['script_path'] ) - 1 );
		}else{
				$scriptpath = $board_config['script_path'] ;
		}
		$this->scriptpath = "http://" . $board_config['server_name'] .$scriptpath ;
		return true;
	}
	
	//
	// Ajoute une note à un jeu
	//
	function ajoute_note($note,$user_id)
	{
		global $db;
		$sql = 'SELECT note 
				FROM '.AREABB_NOTE.'
				WHERE user_id='.$user_id.'
				AND game_id='.$this->gid;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d\acceder à la tables des notes", '', __LINE__, __FILE__, $sql); 
		}
		if ($row = $db->sql_fetchrow($result))
		{
			// on alerte
			message_die(GENERAL_ERROR, "Tu as déjà noté ce jeu", '');
		}else{
			$sql = 'INSERT INTO '.AREABB_NOTE.'
					(game_id,user_id,note)
					VALUES
					('.$this->gid.','.$user_id.','.$note.')';
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Impossible d\'accéder à la tables des notes", '', __LINE__, __FILE__, $sql); 
			}
			$this->calcule_note_moyenne();
		}
		return true;
	}
	
	//
	// Calcule la note moyenne et l'enregistre.
	//
	function calcule_note_moyenne()
	{
		global $db;
		$sql = 'SELECT count(note) as nbre_total, sum(note) as total
				FROM '. AREABB_NOTE .' 
				WHERE game_id='.$this->gid;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d\'accéder à la tables des notes", '', __LINE__, __FILE__, $sql); 
		}
		$row = $db->sql_fetchrow($result);
		
		$note_moy  = round($row['total']/$row['nbre_total']);

		// on l'enregistre
		$sql = 'UPDATE '. AREABB_GAMES_TABLE.' 
				SET note='.$note_moy.' 
				WHERE game_id='. $this->gid;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d\'accéder à la tables des jeux", '', __LINE__, __FILE__, $sql); 
		}
		return true;
	}

}
?>