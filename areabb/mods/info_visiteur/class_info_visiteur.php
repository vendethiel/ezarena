<?php
// -----------------------------------------------------------------
// 
// boîte à outils sur la fonction $_SERVER
// Créée par Saint-Pere - www.areabb.com
//
// -----------------------------------------------------------------

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
class info_visiteur
{
	function get_ip() 
	{
	    if (isset($_SERVER['HTTP_CLIENT_IP'])){ 
	        return $_SERVER['HTTP_CLIENT_IP']; 
	    }elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){ 
	        return $_SERVER['HTTP_X_FORWARDED_FOR']; 
	    }else{ 
	        return $_SERVER['REMOTE_ADDR']; 
	    }
	} 

	function get_browser($browser)
	{
		if (ereg("MSIE", $browser)) {
		   return 'Internet explorer';
		} else if (ereg("Firefox/2.", $browser)) {
		   return 'Firefox 2.x';
		} else if (ereg("Firefox/1.", $browser)) {
		   return 'Firefox 1.x';
		} else if (ereg("^Mozilla/", $browser)) {
		   return 'Mozilla';
		} else if (ereg("^Opera/", $browser)) {
		   return 'Opera';
		} else {
		   return 'Inconnu';
		}
	}

	function get_langue($langue)
	{
	    $langs=explode(",",$langue);
	    return $langs[0];
	}

	function get_os($os)
	{
		if (ereg("Linux", $os)) {    								return "linux";
		} else if (ereg("WinNT", $os)||ereg("Windows NT", $os)) {	return "Windows XP/NT/2000";
		} else if (ereg("Windows 98", $os)||ereg("Win98", $os)) {	return "Windows 98";
		} else if (ereg("Windows 95", $os)||ereg("Win95", $os)) {	return "Windows 95";
		} else if (ereg("Macintosh", $os)||ereg("Mac_PowerPC", $os)){return "Mac OS X / Tiger>";
		} else return "Inconnu";
	}
}



?>