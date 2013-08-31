<?php
// -------------------------------------------------------------------------
//
//				fonctions_chaine.php
//
//	Chargement des fonctions de traitement de chaines/dates/etc
// -------------------------------------------------------------------------
if (!defined('IN_PHPBB'))
{
	die('Hacking attempt');
}

//
// Recherche une URL dans un texte et la rend cliquable
//
function url_cliquable($texte)
{
	$texte = eregi_replace(
    "([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])",
    "<A HREF=\"\\1://\\2\\3\" TARGET=\"_blank\">\\1://\\2\\3</a>",
    $texte);
	return $texte;
}

//
// Fonction transformant une date mysql en format Francais
// 
// entrée :
// sortie :

function MySQLDateToExplicitDate($MyDate, $WeekDayOn=1, $YearOn=1, $HoursOn=0)
{
  $MyMonths = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
        "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
  $MyDays = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", 
                  "Vendredi", "Samedi");

  $DF=explode('-',$MyDate);
  $h = 0; $m = 0; $s = 0;
  if ($DF[3] != '') $h = $DF[3];
  if ($DF[4] != '') $m = $DF[4];
  if ($DF[5] != '') $s = $DF[5];
  $TheDay=getdate(mktime($h,$m,$s,$DF[1],$DF[2],$DF[0]));

  $MyDate=$DF[2]." ".$MyMonths[$DF[1]-1];
  if($WeekDayOn){$MyDate=$MyDays[$TheDay["wday"]]." ".$MyDate;}
  if($YearOn){$MyDate.=" ".$DF[0];}
  if($HoursOn){$MyDate.=" à ".$DF[3].":".$DF[4];}
        
  return $MyDate; 
} 

// 
// fonction convertissant un temps timestamp UNIX en format standard

function timestamp_to_gmd($timestamp)
{
	return date("Y-m-d",$timestamp);
}


//
// Coupure nette d'un texte 
function couper_texte($Texte,$nbcar=100)
{
	if (strlen($Texte) > $nbcar)
	{
	    $Texte = substr($Texte, 0, $nbcar);
	    $last_space = strrpos($Texte, " "); 
	    $Texte = substr($Texte, 0, $last_space)."...";
	} 
	return $Texte;
}
