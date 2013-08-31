<?php
/***************************************************************************
 *                            usercp_captcha.php
 *                            -------------------
 *   begin                : Friday, 14 April 2006
 *   copyright            : (C) 2006 paul sohier
 *   email                : webmaster@paulscripts.nl
 *
 *   $Id: usercp_captcha.php,v 1.4 2006/11/18 21:18:21 paulsohier Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}
// Do we have an id? No, then just exit
if (empty($HTTP_GET_VARS['id']))
{
	exit;
}

$confirm_id = htmlspecialchars($HTTP_GET_VARS['id']);

// Define available charset
$chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',  'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',  'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9');

if (!preg_match('/^[A-Za-z0-9]+$/', $confirm_id))
{
	$confirm_id = '';
}
/**
  * Check if GD exisits, otherwise we will use the default phpbb confirm page ;)
  **/
$gd = true;
if(!extension_loaded("gd")){
	//Gd isn't loaded
	//Display error messages always, or not?
	$gd = false;
}
if(!function_exists("gd_info") || !function_exists('imagettftext')){
	//GD function, gd_info don't exists. GD isn't loaded correctly.
	//Freetype function imagettftext doesn't exists. This is required by this mod.
	$gd = false;
}
if($gd === false){
 	//GD not loaded, or one of the needed functions aren't there. Require usercp_confirm ;)
 	require($phpbb_root_path . 'includes/usercp_confirm.' . $phpEx);
 	die;
}

// Try and grab code for this id and session
$sql = 'SELECT code
	FROM ' . CONFIRM_TABLE . "
	WHERE session_id = '" . $userdata['session_id'] . "'
		AND confirm_id = '$confirm_id'";
$result = $db->sql_query($sql);

// If we have a row then grab data else create a new id
if ($row = $db->sql_fetchrow($result))
{
	$db->sql_freeresult($result);
	$code = $row['code'];
}
else
{
	exit;
}
/**
  * The next part is orginnaly written by ted from mastercode.nl and modified for using in this mod.
  **/
header("content-type:image/png");
header('Cache-control: no-cache, no-store');
$width = 250;
$height = 60;
$img = imagecreatetruecolor($width,$height);
$background = imagecolorallocate($img, color("bg"), color("bg"), color("bg"));

srand(make_seed());

imagefilledrectangle($img, 0, 0, 249, 59, $background);
for($g = 0;$g < 30; $g++)
{
	$t = dss_rand();
	$t = $t[0];

	$ypos = rand(0,$height);
	$xpos = rand(0,$width);

	$kleur = imagecolorallocate($img, color("bgtekst"), color("bgtekst"), color("bgtekst"));

	imagettftext($img, size(), move(), $xpos, $ypos, $kleur, font(), $t);
}
$stukje = $width / (strlen($code) + 3);

for($j = 0;$j < strlen($code); $j++)
{


	$tek = $code[$j];
	$ypos = rand(35,41);
	$xpos = $stukje * ($j+1);

	$color2 = imagecolorallocate($img, color("tekst"), color("tekst"), color("tekst"));

	imagettftext($img, size(), move(), $xpos, $ypos, $color2, font() , $tek);
}

imagepng($img);
imagedestroy($img);
die;
/**
  * Some functions :)
  * Also orginally written by mastercode.nl
  **/
/**
  * Function to create a random color
  * @auteur mastercode.nl
  * @param $type string Mode for the color
  * @return int
  **/
function color($type)
{
	switch($type)
	{
		case "bg":
			$color = rand(224,255);
		break;
		case "tekst":
			$color = rand(0,127);
		break;
		case "bgtekst":
			$color = rand(200,224);
		break;
		default:
			$color = rand(0,255);
		break;
	}
	return $color;
}
/**
  * Function to ranom the size
  * @auteur mastercode.nl
  * @return int
  **/
function size()
{
	return rand(18,30);
}
/**
  * Function to random the posistion
  * @auteur mastercode.nl
  * @return int
  **/
function move()
{
	return rand(-22,22);
}
/**
  * Function to return a ttf file from fonts map
  * @auteur mastercode.nl
  * @return string
  **/
function font()
{
	global $phpbb_root_path,$phpEx;
	static $ar;
	$f = opendir($phpbb_root_path . 'includes/fonts');
	if(!is_array($ar))
	{
		$ar = array();
		while(($file = @readdir($f)) !== false)
		{
			if(!in_array($file,array('.','..')) && eregi('.ttf',$file))
			{
		 		$ar[] = $file;
		 	}
		}
	}
	if(count($ar))
	{
	//	shuffle($ar);
		$i = rand(0,(count($ar) - 1));
		return $phpbb_root_path . 'includes/fonts/' . $ar[$i];
	}
	else
	{
		//There where NO font files. Included old confirm code.
 		require($phpbb_root_path . 'includes/usercp_confirm.' . $phpEx);
 		die;
	}
}
function make_seed()
{
   list($usec, $sec) = explode(' ', microtime());
   return (float) $sec + ((float) $usec * 100000);
}
?>
