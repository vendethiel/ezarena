<?php
# ***** BEGIN LICENSE BLOCK *****
# This file is part of DotClear.
# Copyright (c) 2004 Olivier Meunier and contributors. All rights
# reserved.
#
# DotClear is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
# 
# DotClear is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with DotClear; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# ***** END LICENSE BLOCK *****

class files
{
	function scandir($d,$order=0)
	{
		$res = array();
		if (($dh = @opendir($d)) !== false)
		{
			while (($f = readdir($dh)) !== false) {
				$res[] = $f;
			}
			closedir($dh);
			
			sort($res);
			if ($order == 1) {
				rsort($res);
			}
			
			return $res;
		}
		else
		{
			return false;
		}
	}
	
	function isDeletable($f)
	{
		if (is_file($f)) {
			return is_writable(dirname($f));
		} elseif (is_dir($f)) {
			return (is_writable(dirname($f)) && count(files::scandir($f)) <= 2);
		}
	}
	
	# Suppression récursive d'un répertoire (rm -rf)
	function deltree($dir)
	{
		$current_dir = opendir($dir);
		while($entryname = readdir($current_dir))
		{
			if (is_dir($dir.'/'.$entryname) and ($entryname != '.' and $entryname!='..'))
			{
				if (!$this->deltree($dir.'/'.$entryname)) {
					return false;
				}
			}
			elseif ($entryname != '.' and $entryname!='..')
			{
				if (!@unlink($dir.'/'.$entryname)) {
					return false;
				}
			}
		}
		closedir($current_dir);
		return @rmdir($dir);
	}
	
	function touch($f)
	{
		if (is_writable($f)) {
			$c = implode('',file($f));
			if ($fp = @fopen($f,'w')) {
				fwrite($fp,$c,strlen($c));
				fclose($fp);
			}			
		}
	}
	
	function secureFile($f)
	{
		if (is_file($f))
		{
			@chmod($f,0600);
			if (is_readable($f)) {
				return true;
			} else {
				@chmod($f,0660);
				if (is_readable($f)) {
					return true;
				} else {
					@chmod($f,0666);
				}
			}
		}
	}
	
	function makeDir($f)
	{
		if (@mkdir($f,fileperms(dirname($f))) === false) {
			return false;
		}
		
		@chmod($f,fileperms(dirname($f)));
	}
	
	function putContent($f, $f_content)
	{
		if (is_writable($f))
		{
			if ($fp = @fopen($f, 'w'))
			{
				fwrite($fp,$f_content,strlen($f_content));
				fclose($fp);
				return true;
			}
		}
		
		return false;
	}
	
	function size($size)
	{
		$kb = 1024;
		$mb = 1024 * $kb;
		$gb = 1024 * $mb;
		$tb = 1024 * $gb;
		
		if($size < $kb) {
			return $size." B";
		}
		else if($size < $mb) {
			return round($size/$kb,2)." KB";
		}
		else if($size < $gb) {
			return round($size/$mb,2)." MB";
		}
		else if($size < $tb) {
			return round($size/$gb,2)." GB";
		}
		else {
			return round($size/$tb,2)." TB";
		}
	}
	
	# Copier d'un fichier binaire distant
	function copyRemote($src,$dest)
	{
	//  On essaye de forcer les limites du serveur..
			
		@set_time_limit(0);
		@max_execution_time(0);
			
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
	
	
	# Fonctions de création de packages
	#
	function getDirList($dirName)
	{
		static $filelist = array();
		static $dirlist = array(); 
		
		$exclude_list=array('.','..','.svn');
		
		if (empty($res)) {
			$res = array();
		}

		$dirName = preg_replace('|/$|','',$dirName);
		
		if (!is_dir($dirName))
		{
			return false;
		}
		
		$dirlist[] = $dirName;
		
		$d = dir($dirName);
		while($entry = $d->read())
		{
			if (!in_array($entry,$exclude_list))
			{
				if (is_dir($dirName.'/'.$entry))
				{
					if ($entry != 'CVS')
					{
						$this->getDirList($dirName.'/'.$entry);
					}
				}
				else
				{
					$filelist[] = $dirName.'/'.$entry;
				}
			}
		}
		$d->close();
		
		return array('dirs'=>$dirlist, 'files'=>$filelist);
	}
	
	function makePackage($name,$dir,$remove_path='',$gzip=true)
	{
		if ($gzip && !function_exists('gzcompress'))
		{
			return false;
		}
		
		if (($filelist = $this->getDirList($dir)) === false)
		{
			return false;
		}
		$res = array ('name' => $name, 'dirs' => array(), 'files' => array());
		
		foreach ($filelist['dirs'] as $v)
		{
			$res['dirs'][] = preg_replace('/^'.preg_quote($remove_path,'/').'/','',$v);
		}
		
		foreach ($filelist['files'] as $v)
		{
			$f_content = base64_encode(file_get_contents($v));
			$v = preg_replace('/^'.preg_quote($remove_path,'/').'/','',$v);
			$res['files'][$v] = $f_content;
		}
		
		$res = serialize($res);
		
		if ($gzip)
		{
			$res = gzencode($res);
		}	

		return $res;
	}
}


class path
{
	function real($p,$strict=true)
	{
		$os = (DIRECTORY_SEPARATOR == '\\') ? 'win' : 'nix';
		
		# Chemin absolu ou non ?
		if ($os == 'win') {
			$_abs = preg_match('/^\w+:/',$p);
		} else {
			$_abs = substr($p,0,1) == '/';
		}
		
		# Transformation du chemin, forme std
		if ($os == 'win') {
			$p = str_replace('\\','/',$p);
		}
		
		# Ajout de la racine du fichier appelant si 
		if (!$_abs) {
			$p = dirname($_SERVER['SCRIPT_FILENAME']).'/'.$p;
		}
		
		# Nettoyage
		$p = preg_replace('|/+|','/',$p);
		
		if (strlen($p) > 1) {
			$p = preg_replace('|/$|','',$p);
		}
		
		$_start = '';
		if ($os == 'win') {
			list($_start,$p) = explode(':',$p);
			$_start .= ':/';
		} else {
			$_start = '/';
		}
		$p = substr($p,1);
		
		# Parcours
		$P = explode('/',$p);
		$res = array();
		
		for ($i=0;$i<count($P);$i++)
		{
			if ($P[$i] == '.') {
				continue;
			}
			
			if ($P[$i] == '..') {
				if (count($res) > 0) {
					array_pop($res);
				}
			} else {
				array_push($res,$P[$i]);
			}
		}
		
		$p = $_start.implode('/',$res);
		
		if ($strict && !@file_exists($p)) {
			return false;
		}
		
		return $p;
	}
}
?>