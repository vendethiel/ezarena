<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                             class_liste_jeux.php
//
//   Commencé le   :  mercredi 24 Mai 2006
//   Par  Saint-Pere
//
//--------------------------------------------------------------------------------------------------------------------------------------


class liste_jeux 
{

	var $titre_page; 
	var $order_by;
	var $cat_id;
	var $order;
	var $start;
	var $liste;
	var $game_popup;
	var $max_pages;
	var $pagination;
	var $page_actuelle;
	var $salle;
	
	//
	// initialisation de certaines données
	//
	function liste_jeux()
	{
		global $areabb,$lang,$page_title ;
		$this->titre_page = $page_title ; // $lang['lib_arcade'];
		$this->cat_id = '';
		$this->order_by = $areabb['game_order'];
		$this->game_popup = $areabb['game_popup'];
		$this->start = '0,'.$areabb['games_par_page'];
	}
	
	//
	// définis l'ordre dans lequel apparaitront les jeux
	//
	function order_by($order='')
	{
		$this->order=$order;
		switch ($order)
		{
			case 'Alpha':	$this->order_by = ' game_name ASC ';	break;
			case 'Popular':	$this->order_by = ' game_set DESC ';	break;
			case 'Fixed':	$this->order_by = ' game_order ASC ';	break;
			case 'Random':	$this->order_by = ' RAND() ';		break;
			case 'News':	$this->order_by = ' game_id DESC ';	break;
			default :	$this->order_by = ' game_name ASC ';	break;
		}
		return true;
	}

	//
	// On choisit si le jeu s'ouvrira dans un popup ou dans une page normale
	//
	function definir_lancement_jeu($id_jeu,$largeur,$hauteur)
	{
		global $phpEx,$userdata,$theme,$lang;
		
		// Si la personne n'est pas identifiée on lui propose de le faire
		if (!$userdata['session_logged_in'])
		{
			$jeu = 	'<a href="' . append_sid('login.'.$phpEx.'?redirect='.NOM_ARCADE.'.'.$phpEx, true).'">' ;
		}else{
			if ($this->game_popup == '1')
			{
				// on affiche en popup
				$jeu = 	'<a onClick="window.open(\''.append_sid('./'.NOM_GAME.'.'.$phpEx.'?gid=' . $id_jeu ).'\', \''. $lang['lib_arcade'].'\', \'height='.($hauteur+10).',resizable=yes,width='.($largeur+10).'\')" style="cursor:pointer;color:#'.$theme['body_link'].'">' ;
			}else{
				// on affiche une page normale
				$jeu = 	'<a href="' . append_sid(NOM_GAME.'.'.$phpEx.'?gid=' . $id_jeu ).'">' ;
			}	
		}
		return $jeu;
	}
	
	
	//
	// permet de définir les limites d'extractions de données pour la requete
	//
	
	function definir_limites($start)
	{
		global $areabb;
		$start = round(abs($start));
		$this->start = $start.','.$areabb['games_par_page'];
	}
	
	
	// 
	// récupération des données des jeux
	//
	
	function recup_infos_jeux($salle)
	{
		global $userdata,$db;
		
		$this->salle = $salle;
		
		$sql = 'SELECT g.*, u.username, u.user_id, s.score_game, s.score_date, arcade_cattitle, arcade_nbelmt 
				FROM ' . AREABB_GAMES_TABLE . ' g 
				LEFT JOIN ' . USERS_TABLE . ' u ON g.game_highuser = u.user_id 
				LEFT JOIN '.  AREABB_CATEGORIES_TABLE .' c ON g.arcade_catid=c.arcade_catid 
				LEFT JOIN ' . AREABB_SCORES_TABLE. ' s on s.game_id = g.game_id AND s.user_id = ' . $userdata['user_id'] . ' 
				WHERE c.salle='.$this->salle;
		if ($this->cat_id != '') $sql .= ' AND g.arcade_catid = '.$this->cat_id;
		$sql .= ' ORDER BY '.$this->order_by ; 
		$sql .= ' LIMIT '. $this->start;

		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des catégories", '', __LINE__, __FILE__, $sql); 
		}
		if ($db->sql_numrows($result) != 0)
		{
			while( $row = $db->sql_fetchrow($result))
			{
				$this->liste[] = $row ;
				if ($this->cat_id != '') $this->titre_page = $row['arcade_cattitle'];
			}
		}else{
				$sql = 'SELECT arcade_cattitle FROM '.  AREABB_CATEGORIES_TABLE .' WHERE arcade_catid = '.$this->cat_id;
				$result = $db->sql_query($sql);
				$row = $db->sql_fetchrow($result);
				$this->titre_page = $row['arcade_cattitle'];
		}
		return true;
	}
	
	
	//
	// Pagination des catégories de jeux
	
	function pagination_jeux($start)
	{
		global $db,$squelette,$areabb,$phpEx;
		
		// On détermine le nombre maximal de jeux
		$sql = 'SELECT count(g.game_id) as max 
			FROM '.AREABB_GAMES_TABLE.' as g 
			LEFT JOIN '.AREABB_CATEGORIES_TABLE.' as c 
			ON g.arcade_catid=c.arcade_catid WHERE ';
		if ($this->cat_id != '')
		{
			$sql .=	' g.arcade_catid='.$this->cat_id. ' AND ';
		}
		
		$sql .= ' salle='.$this->salle;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder aux jeux", '', __LINE__, __FILE__, $sql); 
		}
		$row = $db->sql_fetchrow($result);
		$max_jeu = $row['max'];
		
		// nombre de pages maximal
		if ($max_jeu <= $areabb['games_par_page'])
		{
			$this->max_pages = 1;
		}else{
			$this->max_pages = ceil($max_jeu / $areabb['games_par_page']);
		}
				
		// la page où on se trouve
		$this->page_actuelle = round($start / $areabb['games_par_page']);
		
		// montage du lien
		for ($i=0;$i<=$this->max_pages;$i++)
		{
			$this->pagination[$i] = append_sid(NOM_ARCADE.'.'.$phpEx.'?salle='.$squelette->id_squelette.'&cid='.$this->cat_id.'&start='.($i * $areabb['games_par_page']).'&order='.$this->order);
		}			
		return $true;
	}
	
	//
	// Affichage de la pagination
	
	// présentation classique
	// aller à : 1 2 3 4 5 6 7 8 9
	
	function pagination_classique()
	{
		$retour = '';
		for ($i=0;$i < $this->max_pages;$i++)
		{
			if ($i == $this->page_actuelle)
			{
				$retour .= ($i+1).'&nbsp;';
			}else{
				$retour .= '<a href="'.$this->pagination[$i].'" alt"">'.($i+1).'</a>&nbsp;';
			}
		}
		return $retour;		
	}
	
	// présentation phpbb
	// aller à : 1 2 3 4 5 .... 31 32 33 34 35 .... 57 58 59 60 61
	
	function pagination_phpbb()
	{
		$retour = '';
		for ($i=0;$i< $this->max_pages; $i++)
		{
			// on définit les 3 zones où on veut des numéros affichés
			//if (($i <= 5) || ($i <= $this->max_pages) || ($i <= ($page_actuelle - 2 )) || ($i => ($page_actuelle + 2 )))
			if (($i <= 5) || ($i <= $this->max_pages) || ($i <= ($this->page_actuelle - 2 )) || ($i <= ($this->page_actuelle + 2 )))
			{
				if ($i == $this->page_actuelle)
				{
					$retour .= ($i+1).'&nbsp;';
				}else{
					$retour .= '<a href="'.$this->pagination[$i].'" alt"">'.($i+1).'</a>&nbsp;';
				}
			}
			
			// on mets des petits points entre les zones
			if ((($i == 5) && (($this->page_actuelle - 2) > 6 )) || ((($this->page_actuelle + 3) < $this->max_pages) && ($i == $this->page_actuelle + 2)))
			{
				$retour .= '....';	
			}
		}
		return $retour;				
	}
	
	// présentation Google
	// aller à : ... 7 8 9 10 11 12 13 14 15 ... (5 chiffres de chaque coté)
	
	function pagination_google()
	{
		$retour = '';
		for ($i=0;$i<$this->max_pages;$i++)
		{
			// on mets des petits points entre les zones
			if ((($this->page_actuelle - 5) > 1 ) || ($this->page_actuelle + 5) < $this->max_pages)
			{
				$retour .= '....';	
			} 
			
			// on définit les 3 zones où on veut des numéros affichés
			if ($i <= ($this->page_actuelle - 5) ||$i <= ($this->page_actuelle + 5))
			{
				if ($i == $this->page_actuelle)
				{
					$retour .= ($i+1).'&nbsp;';
				}else{
					$retour .= '<a href="'.$this->pagination[$i].'" alt"">'.($i+1).'</a>&nbsp;';
				}
			}

		}
		return $retour;		
	}
}



?>