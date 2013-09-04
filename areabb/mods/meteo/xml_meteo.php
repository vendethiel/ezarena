<?
//--------------------------------------------------------------------------
//   PHPWeatherControl 
//   Développé par Romelard Fabrice
//   Disponible sur à l'adresse : 
//            http://www.asp-php.net/scripts/asp.net/weathercontrol.php
//--------------------------------------------------------------------------

$zipcode =  $HTTP_GET_VARS['ville'];

//$zipcode = "FRXX0072";				// Code de la ville sur Weather.com
$partner = "XXXXXXXXXX";			// ID Partner si enregistré
$license = "XXXXXXXXXXXXXX";			// License Key si enregistré
$nbjours = "6";					// Nombre de jours à afficher

$url	 = "http://xoap.weather.com/weather/local/";	// URL to xoap.weather

$xmlsource = "$url$zipcode?cc=*&unit=s&prod=xoap&par=$partner&key=$license&dayf=$nbjours";

// ----------------------------------------------------------------------------
function conversiontemperature($farenheit) {
	if (is_numeric($farenheit)) {
//		return $farenheit;
		$temp = (int) ($farenheit - 32);
		$temp = (float) ($temp/9*5);
		return round($temp,0);
	}
	else {
		return $farenheit;
	}
}

// ----------------------------------------------------------------------------
function dcomplete($date) {
 return date("w",$date);
}

// ----------------------------------------------------------------------------
function DateAdd($Nbjours) {

    $date_time_array = getdate();
    $hours = $date_time_array['hours'];
    $minutes = $date_time_array['minutes'];
    $seconds = $date_time_array['seconds'];
    $month = $date_time_array['mon'];
    $day = $date_time_array['mday'];
    $year = $date_time_array['year'];

    $dayAdd = $day + $Nbjours;
    $timestamp= mktime($hours,$minutes,$seconds,$month,$dayAdd,$year);
    return ($timestamp);
}

function lit_xml($fichier,$item,$champs) {
   if($chaine = @implode("",@file($fichier))) 
   {
      // on explode sur <item>
      $tmp = preg_split("/<\/?".$item.">/",$chaine);
      // pour chaque <item>
      for($i=1;$i<sizeof($tmp)-1;$i+=2)
         foreach($champs as $champ)
         {
            $tmp2 = preg_split("/<\/?".$champ.">/",$tmp[$i]);
            $tmp3[$i-1][] = @$tmp2[1];
         }
      return $tmp3;
   }else{
  //if (sizeof($chaine) == 0 ) 
  die(utf8_encode('<span class="genmed">Connexion à la météo impossible</span>'));  
}
}

function lit_xml_with_attr($fichier,$item,$champs) {
   // on lit le fichier
   if($chaine = @implode("",@file($fichier))) {
      // on explode sur <item>
      $tmp = preg_split("/<\/?".$item."?>/",$chaine);
     
      // pour chaque <item>
      for($i=0;$i<sizeof($tmp)-1;$i+=1) {
        foreach($champs as $champ) {
            $tmp2 = preg_split("/<\/?".$champ."?>/",$tmp[$i]);
            $tmp3[$i-1][] = @$tmp2[1];
        }
      }
	return $tmp3;
   }
}

// Récupération de la date de chargement
$ladate = lit_xml($xmlsource,"dayf", array("lsup"));
     
foreach($ladate as $rowDate) {
	$LaDateAffiche = $rowDate[0];
}

$MeteoJours = lit_xml_with_attr($xmlsource, "part", array("icon","t","ppcp","hmid","dnam"));

// Récupération des données de chaque journée
$xml = lit_xml_with_attr($xmlsource,"day",array("hi","low"));

// On francaise les jours en forcant..
$semaine  = array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');
function semaine_fr($jour)
{
	global $semaine;
	return  $semaine[$jour];
}

// On est en pleine journée ou encore dans la nuit.. 
$heure = intval(date("H"));
if ((8 < $heure) && ($heure < 21))
{
 $jour = 'd'; 
 $temp_aujourdhui =conversiontemperature($xml[0][0]);
}else{
 $jour = 'n';
  $temp_aujourdhui = conversiontemperature($xml[-1][1]);
}

$meteo = '<table cellSpacing="0" cellPadding="0" border="0" width="98%" style="background-image:url(\'areabb/mods/meteo/images/grandes/'.$MeteoJours[-1][0].$jour.'.png\');background-repeat:no-repeat;">
<tr height="10">
<!-- Aujourdhui -->
	<td colspan="6" align="right" valign="bottom"><span class="forumlink">'.$MeteoJours[-1][4].'</span></td>
</tr>
<tr height="100">
	<td colspan="6" align="right" valign="top"><span class="forumlink">'.$temp_aujourdhui.'°C</span></td>
</tr>
<tr>
	<!-- Titres jours 1 2 3 -->
	<td class="catLeft" colspan="2" align="center"><span class="forumlink">'.semaine_fr(dcomplete(DateAdd(1))).'</span></td>
	<td class="catLeft" colspan="2" align="center"><span class="forumlink">'.semaine_fr(dcomplete(DateAdd(2))).'</span></td>
	<td class="catLeft" colspan="2" align="center"><span class="forumlink">'.semaine_fr(dcomplete(DateAdd(3))).'</span></td>
</tr>
<tr>
	<!-- icones jours 1 2 3 -->
	<td class="row1" colspan="2" align="center"><img src="areabb/mods/meteo/images/'.$MeteoJours[1][0].'.png" border="0"></td>
	<td class="row1" colspan="2" align="center"><img src="areabb/mods/meteo/images/'.$MeteoJours[3][0].'.png" border="0"></td>
	<td class="row1" colspan="2" align="center"><img src="areabb/mods/meteo/images/'.$MeteoJours[5][0].'.png" border="0"></td>
</tr>
<tr>
	<!-- temperatures jours 1 2 3  -->
	<td class="row1" align="center"><span class="gen">'.conversiontemperature($xml[0][0]).'</span></td>
	<td class="row1" align="center"><span class="gensmall">'.conversiontemperature($xml[0][1]).'</span></td>
	
	<td class="row1" align="center"><span class="gen">'.conversiontemperature($xml[1][0]).'</span></td>
	<td class="row1" align="center"><span class="gensmall">'.conversiontemperature($xml[1][1]).'</span></td>
	
	<td class="row1" align="center"><span class="gen">'.conversiontemperature($xml[2][0]).'</span></td>
	<td class="row1" align="center"><span class="gensmall">'.conversiontemperature($xml[2][1]).'</span></td>
</tr>
<tr>
	<!-- Titres jours 4 5  -->
	<td class="catLeft" colspan="2" align="center"><span class="forumlink">'.semaine_fr(dcomplete(DateAdd(4))).'</span></td>
	<td class="catLeft" colspan="2" align="center"><span class="forumlink">'.semaine_fr(dcomplete(DateAdd(5))).'</span></td>
	<td class="catLeft" colspan="2" align="center"></td>
</tr>
<tr>
	<!-- icones jours 4 5 + lune -->
	<td class="row1" colspan="2" align="center"><img src="areabb/mods/meteo/images/'.$MeteoJours[7][0].'.png" border="0"></td>
	<td class="row1" colspan="2" align="center"><img src="areabb/mods/meteo/images/'.$MeteoJours[9][0].'.png" border="0"></td>
	<td class="row1" colspan="2" align="center"></td>
</tr>
<tr>
	<!-- temperatures jours 1 2 3  -->
	<td class="row1" align="center"><span class="gen">'.conversiontemperature($xml[3][0]).'</span></td>
	<td class="row1" align="center"><span class="gensmall">'.conversiontemperature($xml[3][1]).'</span></td>
	
	<td class="row1" align="center"><span class="gen">'.conversiontemperature($xml[4][0]).'</span></td>
	<td class="row1" align="center"><span class="gensmall">'.conversiontemperature($xml[4][1]).'</span></td>
	
	<td class="row1" align="center"><span class="gen"></span></td>
	<td class="row1" align="center"><span class="gensmall"></span></td>
</tr>
</table>';

echo utf8_encode($meteo);
?>