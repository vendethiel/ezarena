<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                             class_categorie.php
//
//   Commencé le   :  mecredi 14 juin 2006
//   Par  Saint-Pere
//
//--------------------------------------------------------------------------------------------------------------------------------------



class manage_cat
{
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
		if (sizeof($cat_utilisees) != 0)
		{
			$sql = 'UPDATE ' . AREABB_CATEGORIES_TABLE . ' 
					SET arcade_nbelmt = 0
					WHERE arcade_catid NOT IN ('.implode(', ',$cat_utilisees).')';
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des catégories", "", __LINE__, __FILE__, $sql);
			}
		}
		return true;
	}

	//
	// déplace tous les jeux d'une catégorie vers une autre
	// déplace toutes les sous cat vers la racine 
	// ensuite la catégorie est supprimée
	//
	function movedel_arcade_categorie($arcade_catid,$to_catid)
	{
		global $db;
		$sql = 'UPDATE '. AREABB_GAMES_TABLE .' 
				SET arcade_catid = '.$to_catid.' 
				WHERE arcade_catid = '.$arcade_catid;
	    if( !$db->sql_query($sql) )
	    {
		  message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des jeux", "", __LINE__, __FILE__, $sql);
	    }
		$sql = 'UPDATE '.AREABB_CATEGORIES_TABLE.' 
				SET arcade_parent=0 
				WHERE arcade_parent='.$arcade_catid;  //arcade_parent
		if( !$db->sql_query($sql) )
	    {
		  message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des catégories", "", __LINE__, __FILE__, $sql);
	    }
		$sql = 'DELETE FROM ' . AREABB_CATEGORIES_TABLE . ' 
				WHERE arcade_catid = '.$arcade_catid;
	    if( !$db->sql_query($sql) )
	    {
		  message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des catégories", "", __LINE__, __FILE__, $sql);
	    }
		$this->resynch_arcade_categorie();
		return true;
	}
	
	//
	// Supprime une catégorie et les jeux qui sont dedans
	//
	function delete_arcade_categorie($arcade_catid,$verif='OK')
	{
		global $template,$db,$lang,$phpEx,$phpbb_root_path;
		// on compte le nombre d'enregistrement
		$sql = 'SELECT game_id  
				FROM ' . AREABB_GAMES_TABLE . ' 
				WHERE arcade_catid = '.$arcade_catid;
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la table des jeux", "", __LINE__, __FILE__, $sql);
		}
		$cpt = $db->sql_numrows($result);  
		
		
		// Si la categorie est vide on la supprime
		if ( $cpt == 0 )
		{
			$sql = 'DELETE FROM ' . AREABB_CATEGORIES_TABLE . ' 
					WHERE arcade_catid = '.$arcade_catid;
			if( !$result = $db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, "Impossible de supprimer la catégorie", "", __LINE__, __FILE__, $sql);
			}
			$sql = 'UPDATE '.AREABB_CATEGORIES_TABLE.' 
				SET arcade_parent=0 
				WHERE arcade_parent='.$arcade_catid;  //arcade_parent
			if( !$db->sql_query($sql) )
		    {
			  message_die(GENERAL_ERROR, "Impossible de mettre à jour la table des catégories", "", __LINE__, __FILE__, $sql);
		    }
		}else{
		      //Reste t-il une catégorie où l'on peut déplacer le contenu de celle-ci
			  //avant suppression.
			  $sql = 'SELECT arcade_catid, arcade_cattitle 
					FROM ' . AREABB_CATEGORIES_TABLE ;
		      if( !$result = $db->sql_query($sql) )
		      {
			     message_die(GENERAL_ERROR, "Impossible d'acceder à la table des catégorie", "", __LINE__, __FILE__, $sql);
		      }
			  $liste_cat = '';
			  while( $row = $db->sql_fetchrow($result))
			  {
			     if($row['arcade_catid']!=$arcade_catid)
				    $liste_cat .= "<option value='" . $row['arcade_catid'] . "'>" . stripslashes( $row['arcade_cattitle']) . "</option>\n";
				 else
				    $cattitle = $row['arcade_cattitle'];
			  }
			  // s'il n'y a plus de catégorie on ne peut pas supprimer celle là tant qu'elle n'est pas vide
		      if ( $liste_cat == '')	  
			  {
			     message_die(GENERAL_ERROR, "Impossible de supprimer la catégorie, elle n'est pas vide.");
			  }

				$template->set_filenames(array(
					'body' =>  $phpbb_root_path .'areabb/mods/games/tpl/arcade_cat_delete_body.tpl'
				));

				$hidden_fields = '<input type="hidden" name="action" value="movedel" />';
				$hidden_fields .= '<input type="hidden" name="arcade_catid" value="' . $arcade_catid . '" />';
			
				$template->assign_vars(array(
					"S_ACTION" 				=> append_sid("admin_arcade_games.$phpEx"),
					"S_HIDDEN_FIELDS"		=> $hidden_fields,
					'S_SELECT_TO'			=> $liste_cat,
					'CATTITLE'				=> $cattitle,
					"L_TITLE"				=> $lang['arcade_cat_delete'],
					"L_EXPLAIN"				=> $lang['arcade_delete_cat_explain'],
					"L_ARCADE_CAT_DELETE"	=> $lang['arcade_cat_delete'],
					"L_ARCADE_CAT_TITLE"	=> $lang['arcade_cat_title'],
					"L_MOVE_CONTENTS"		=> $lang['arcade_cat_move_elmt'],
					"S_SUBMIT_VALUE"		=> $lang['arcade_cat_move_and_del'])
				);

				$template->pparse("body");
			include($phpbb_root_path.'admin/page_footer_admin.'.$phpEx);
			exit;		
		}
		return true;
	}
	
	//
	// Ajoute une catégorie
	//
	function ajoute_arcade_categorie($arcade_cattitle,$icones,$arcade_parent,$salle)
	{
		global $db;
		$sql = 'SELECT MAX(arcade_catorder) AS max_order
				FROM ' . AREABB_CATEGORIES_TABLE;
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Impossible d'obtenir le dernier numéro d'ordre de la table arcade_categories", "", __LINE__, __FILE__, $sql);
		}
		$row = $db->sql_fetchrow($result);

		$max_order = $row['max_order'];
		$next_order = $max_order + 10;

		$sql = 'INSERT INTO ' . AREABB_CATEGORIES_TABLE . ' 
				( arcade_cattitle,arcade_parent,arcade_icone,arcade_nbelmt, arcade_catorder,salle )
				VALUES 
				(\'' . $arcade_cattitle . '\',' . $arcade_parent . ',\'' . $icones . '\', 0, '.$next_order.','.$salle.')';
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update arcade_categories table", "", __LINE__, __FILE__, $sql);
		}
		return true;	
	}
	
	
	//
	// Edite le titre / les permissions et l'icone d'une catégorie
	//
	function edite_arcade_categorie($arcade_cattitle,$icones,$arcade_catid,$arcade_parent,$salle)
	{
		global $db;
		$sql = 'UPDATE ' . AREABB_CATEGORIES_TABLE . ' SET 
			arcade_icone = \''.$icones.'\',
			arcade_parent = '.$arcade_parent.',
			arcade_cattitle = \''. $arcade_cattitle . '\',
			salle = '.$salle.'  
	        WHERE arcade_catid = \''.$arcade_catid.'\'';

		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update arcade_categories table", "", __LINE__, __FILE__, $sql);
		}
		// on déplace toutes les éventuelles sous catégories vers la bonne salle
		$sql = 'UPDATE '. AREABB_CATEGORIES_TABLE . ' 
				SET salle='.$salle.' 
				WHERE arcade_parent=\''.$arcade_catid.'\'';
		if( !$db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, "Couldn't update arcade_categories table", "", __LINE__, __FILE__, $sql);
		}
		return true;
	}
	
	//
	// Modifie l'ordre d'affichage des catégories
	//
	function move_arcade_categorie($arcade_catid,$sens='+')
	{
		global $db;
		$liste= array();
		$sql = 'SELECT arcade_parent 
					FROM '.AREABB_CATEGORIES_TABLE.' 
					WHERE arcade_catid='.$arcade_catid;
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'obtenir des infos sur ces feuilles", '', __LINE__, __FILE__, $sql); 
		}
		$row = $db->sql_fetchrow($result);
		$sql = 'SELECT arcade_catid
				FROM '.AREABB_CATEGORIES_TABLE.'
				WHERE arcade_parent = '.$row['arcade_parent'].'
				ORDER BY arcade_catorder ASC';
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'obtenir des infos sur ces feuilles", '', __LINE__, __FILE__, $sql); 
		}
		while ($row = $db->sql_fetchrow($result))
		{
			$liste[] = $row['arcade_catid'];
		}
		if (in_array($arcade_catid,$liste))
		{
			
			$clef = array_search($arcade_catid,$liste);
			switch ($sens)
			{
				case '+':
					$tmp = $liste[$clef]; 
					$liste[$clef] = $liste[($clef-1)];
					$liste[($clef-1)] = $tmp;
					break;
				case '-':
					$tmp = $liste[$clef]; 
					$liste[$clef] = $liste[($clef+1)];
					$liste[($clef+1)] = $tmp;		
					break;		
			}
			$cmpt = count($liste);
			for ($i=0;$i<$cmpt;$i++)
			{
				$sql = 'UPDATE '. AREABB_CATEGORIES_TABLE .' 
						SET arcade_catorder='.$i.' 
						WHERE arcade_catid='.$liste[$i];
				$db->sql_query($sql);
			}
			return true;
		}else{
			return false;
		}
	}

	
	
	//
	// récupere la liste des icones des catégories
	//
	function icone_arcade($chemin)
	{
		$dos=opendir($chemin); // Met le pointeur de lecture sur le dossier courant.
		$liste = array();
		while ($fich = readdir($dos))
		{
			if (($fich != '.') && ($fich != '..'))
			{
				$liste[]=$fich; 
			}
		} 
		closedir($dos);
		return $liste;
	}
	
	function affichage_liste($liste_cat,$i)
	{
		global $template,$phpEx,$nbcat,$lang,$phpbb_root_path;
		// gestion des fleches HAUT et BAS
		if ( $i > 0)
		{
			$l_up = $lang['Up_arcade_cat'] . '<br />'; 
			$u_up = append_sid("admin_arcade_games.$phpEx?action=monter&amp;arcade_catid=" . $liste_cat[ $i ]['arcade_catid'] );
		}else{
			$l_up = '';
			$u_up =  '';

		}
		if ( $i < $nbcat-1 )
		{
			$l_down = $lang['Down_arcade_cat'];
			$u_down = append_sid("admin_arcade_games.$phpEx?action=descendre&amp;arcade_catid=" . $liste_cat[ $i ]['arcade_catid'] );		
		}else{
			$l_down = '';
			$u_down = '';
		}
		
		// l'icone
		if ($liste_cat[$i]['arcade_icone'] != '')
		{
			$icone = '<img src="'.$phpbb_root_path.'areabb/images/menu/'.$liste_cat[$i]['arcade_icone'].'" alt="" align="left" border="0">';
		}else{
			$icone = '';
		}
		if ($liste_cat[$i]['arcade_parent'] != 0)  $icone = '<img src="'.$phpbb_root_path.'areabb/images/arrow_ltr.gif" border="0" align="left">'.$icone;
		
	   $template->assign_block_vars('salle.arcade_catrow', array(
		  'TD_ROW'				=> $td_row,
		  'L_UP'				=> $l_up,
		  'L_DOWN'				=> $l_down,
	      'ARCADE_CATID'		=> $liste_cat[$i]['arcade_catid'],
	      'ARCADE_CATTITLE' 	=> stripslashes($liste_cat[$i]['arcade_cattitle']),
		  'U_EDIT'				=> append_sid("admin_arcade_games.$phpEx?action=edit&amp;arcade_catid=" . $liste_cat[$i]['arcade_catid']),
		  'U_MANAGE'			=> append_sid("arcade_elmt.$phpEx?arcade_catid=" . $liste_cat[$i]['arcade_catid']),
	 	  'U_UP'				=> $u_up,
	 	  'U_DOWN'				=> $u_down,
		  'ICONE'				=> $icone,
		  'U_DELETE'			=> append_sid("admin_arcade_games.$phpEx?action=delete&amp;arcade_catid=" . $liste_cat[$i]['arcade_catid']),
		  'U_SYNCHRO'			=> append_sid("admin_arcade_games.$phpEx?action=resynch&amp;arcade_catid=" . $liste_cat[$i]['arcade_catid']),
		  'ARCADE_CAT_NBELMT'	=> $liste_cat[$i]['arcade_nbelmt'],
		  'ARCADE_CATORDER'		=> $liste_cat[$i]['arcade_catorder']
	    ));
		
		return true;
	}
}


?>