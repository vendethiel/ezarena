<?php
//--------------------------------------------------------------------------------------------------------------------------------------
//                            class_liste_categories.php
//
//   Commencé le   :  mercredi 24 Mai 2006
//   Par  Saint-Pere
//
//--------------------------------------------------------------------------------------------------------------------------------------

CLASS liste_categorie
{

	var $liste_cat;
	var $icone;
	var $nbre_jeux;
	var $nbre_categorie;
	var $id_salle;
	
	function liste_categorie($id_salle)
	{
		$this->id_salle = $id_salle;
		$this->icone = '';	
		$this->nbre_jeux = '';	
		$this->nbre_categorie = 0;	
	}
	
	//
	// Récupération de la liste des catégories
	//
	function recup_infos_cat()
	{
		global $db,$phpEx;
		
		$liste_cat = array();		
	 	$sql = 'SELECT arcade_catid, arcade_parent, arcade_cattitle, arcade_icone, arcade_catorder, arcade_nbelmt   
				FROM ' . AREABB_CATEGORIES_TABLE . ' 
				WHERE salle='.$this->id_salle.' 
				ORDER BY arcade_catorder';
				
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Impossible d'accéder à la tables des catégories", '', __LINE__, __FILE__, $sql); 
		}

		$i =0;
		while( $row = $db->sql_fetchrow($result))
		{
				$liste_cat[$i]['lien']		= append_sid(NOM_ARCADE.'.'.$phpEx.'?salle='.$this->id_salle.'&cid=' . $row['arcade_catid'] );
				$liste_cat[$i]['nbre_jeux']	= $row['arcade_nbelmt'];
				$liste_cat[$i]['titre']		= $row['arcade_cattitle'];
				$liste_cat[$i]['id']		= $row['arcade_catid'];
				$liste_cat[$i]['icone']		= $row['arcade_icone'];
				$liste_cat[$i]['parent']	= $row['arcade_parent'];
				$liste_cat[$i]['order']		= $row['arcade_catorder'];
				$i++;
		}	
		$this->liste_cat = $liste_cat;
		$this->nbre_categorie = sizeof($liste_cat);
	}
	
	
	//
	// Affiche une icone devant la cétégorie
	//
	function affichage_icone()
	{
		FOR ($i=0;$i<$this->nbre_categorie;$i++)
		{
			if ($this->liste_cat[$i]['icone'] != '')
			{
				$this->icone[$i] = '<img src="areabb/images/menu/'.$this->liste_cat[$i]['icone']; 
				$this->icone[$i] .= '" align="left" valign="middle" border="0" width="30" height="30">';
			}
		}
	}
	
	//
	// Affiche le nombre de jeux dans chaque catégorie
	//
	function affichage_nbre_jeux()
	{
		FOR ($i=0;$i<$this->nbre_categorie;$i++)
		{
			$this->nbre_jeux[$i] = '&nbsp;('. $this->liste_cat[$i]['nbre_jeux'].')';
		}	
	}
}
?>