<?php

$fichier = 'http://xoap.weather.com/search/search?where='.$_GET['ville'];
$id_ville = array();
$id_villes = array();
$ville = array();
$villes = array();
function lire_fichier($fichier)
{
	global $id_ville,$id_villes,$ville,$villes;
		$i = 0;
		$lines = @file($fichier);
		if ($lines == '') die('<span class="gen">Serveur introuvable</span>');
		foreach ($lines as $line_num => $line)
		{
			eregi("loc id=\"(.*)\" ",$line,$id_ville[$i]);
			eregi("[?>](.*)[?<]",$line,$ville[$i]);
			if (strlen($id_ville[$i][1]) == 8 )
			{
				$id_villes[] = $id_ville[$i][1];
				$villes[] = $ville[$i][1];
			}
			$i++;
		}
}
lire_fichier($fichier);

$nbre_villes = sizeof($id_villes);
if  ($nbre_villes == 0)
{
	echo utf8_encode('<span class="genmed">Aucune ville trouvée</span>');
}else{
	echo '<select id="select_ville">';
	for ($i=0;$i <$nbre_villes;$i++)
	{
		echo "\n".'<option value="'.$id_villes[$i].'">'.$villes[$i].'</option>';
	}
	echo "\n".'</select> &nbsp;<input type="button" value="GO"  onClick="EcrireCookie(\'AreaMeteo\', document.getElementById(\'select_ville\').value);ville=document.getElementById(\'select_ville\').value;init_meteo();" />';
}
?> 