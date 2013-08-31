<?php
/** 
*
* @package phpBB3
* @version $Id: utf_tools.php,v 1.48 2007/01/27 16:40:38 acydburn Exp $
* @copyright (c) 2006 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/
/**
 * GYM Sitemaps version www.phpbb-seo.com
 * */
/**
*/
if (!defined('IN_PHPBB')) {
	exit;
}

// Enforce ASCII only string handling
setlocale(LC_CTYPE, 'C');

/**
* UTF-8 tools
*
* Whenever possible, these functions will try to use PHP's built-in functions or
* extensions, otherwise they will default to custom routines.
*
* @package phpBB3
*/

if (!extension_loaded('xml')) {
	/**
	* Implementation of PHP's native utf8_encode for people without XML support
	* This function exploits some nice things that ISO-8859-1 and UTF-8 have in common
	*
	* @param string $str ISO-8859-1 encoded data
	* @return string UTF-8 encoded data
	*/
	function utf8_encode($str) {
		$out = '';
		for ($i = 0, $len = strlen($str); $i < $len; $i++) {
			$letter = $str[$i];
			$num = ord($letter);
			if ($num < 0x80) {
				$out .= $letter;
			} else if ($num < 0xC0) {
				$out .= "\xC2" . $letter;
			} else {
				$out .= "\xC3" . chr($num - 64);
			}
		}
		return $out;
	}
	/**
	* Implementation of PHP's native utf8_decode for people without XML support
	*
	* @param string $str UTF-8 encoded data
	* @return string ISO-8859-1 encoded data
	*/
	function utf8_decode($str) {
		$pos = 0;
		$len = strlen($str);
		$ret = '';
		while ($pos < $len) {
			$ord = ord($str[$pos]) & 0xF0;
			if ($ord === 0xC0 || $ord === 0xD0) {
				$charval = ((ord($str[$pos]) & 0x1F) << 6) | (ord($str[$pos + 1]) & 0x3F);
				$pos += 2;
				$ret .= (($charval < 256) ? chr($charval) : '?');
			} else if ($ord === 0xE0) {
				$ret .= '?';
				$pos += 3;
			} else if ($ord === 0xF0) {
				$ret .= '?';
				$pos += 4;
			} else {
				$ret .= $str[$pos];
				++$pos;
			}
		}
		return $ret;
	}
}
if (extension_loaded('mbstring')) {
	mb_internal_encoding('UTF-8');
	/**
	* UTF-8 aware alternative to strrpos
	* Find position of last occurrence of a char in a string
	*
	* Notes:
	* - offset for mb_strrpos was added in 5.2.0, we emulate if it is lower
	*/
	if (version_compare(phpversion(), '5.2.0', '>=')) {
		/**
		* UTF-8 aware alternative to strrpos
		* @ignore
		*/
		function utf8_strrpos($str,	$needle, $offset = null) {
			// Emulate behaviour of strrpos rather than raising warning
			if (empty($str)) {
				return false;
			}
			if (is_null($offset)) {
				return mb_strrpos($str, $needle);
			} else {
				return mb_strrpos($str, $needle, $offset);
			}
		}
	} else {
		/**
		* UTF-8 aware alternative to strrpos
		* @ignore
		*/
		function utf8_strrpos($str,	$needle, $offset = null) {
			// offset for mb_strrpos was added in 5.2.0
			if (is_null($offset)) {
				// Emulate behaviour of strrpos rather than raising warning
				if (empty($str)) {
					return false;
				}
				return mb_strrpos($str, $needle);
			} else {
				if (!is_int($offset)) {
					trigger_error('utf8_strrpos expects parameter 3 to be long', E_USER_WARNING);
					return false;
				}
				$str = mb_substr($str, $offset);
				if (false !== ($pos = mb_strrpos($str, $needle))) {
					return $pos + $offset;
				}
				return false;
			}
		}
	}
	/**
	* UTF-8 aware alternative to strpos
	* @ignore
	*/
	function utf8_strpos($str, $needle, $offset = null) {
		if (is_null($offset)) {
			return mb_strpos($str, $needle);
		} else {
			return mb_strpos($str, $needle, $offset);
		}
	}

	/**
	* UTF-8 aware alternative to substr
	* @ignore
	*/
	function utf8_substr($str, $offset, $length = null) {
		if (is_null($length)) {
			return mb_substr($str, $offset);
		} else {
			return mb_substr($str, $offset, $length);
		}
	}

	/**
	* Return the length (in characters) of a UTF-8 string
	* @ignore
	*/
	function utf8_strlen($text) {
		return mb_strlen($text, 'utf-8');
	}
} else {
	/**
	* UTF-8 aware alternative to strrpos
	* Find position of last occurrence of a char in a string
	* 
	* @author Harry Fuecks
	* @param string $str haystack
	* @param string $needle needle
	* @param integer $offset (optional) offset (from left)
	* @return mixed integer position or FALSE on failure
	*/
	function utf8_strrpos($str,	$needle, $offset = null) {
		if (is_null($offset)) {
			$ar	= explode($needle, $str);	
			if (sizeof($ar) > 1) {
				// Pop off the end of the string where the last	match was made
				array_pop($ar);
				$str = join($needle, $ar);

				return utf8_strlen($str);
			}
			return false;
		} else {
			if (!is_int($offset)) {
				trigger_error('utf8_strrpos	expects	parameter 3	to be long', E_USER_WARNING);
				return false;
			}
			$str = utf8_substr($str, $offset);
			if (false !== ($pos = utf8_strrpos($str, $needle))) {
				return $pos	+ $offset;
			}
			return false;
		}
	}

	/**
	* UTF-8 aware alternative to strpos
	* Find position of first occurrence of a string
	*
	* @author Harry Fuecks
	* @param string $str haystack
	* @param string $needle needle
	* @param integer $offset offset in characters (from left)
	* @return mixed integer position or FALSE on failure
	*/
	function utf8_strpos($str, $needle, $offset = null) {
		if (is_null($offset)) {
			$ar = explode($needle, $str);
			if (sizeof($ar) > 1)
			{
				return utf8_strlen($ar[0]);
			}
			return false;
		} else {
			if (!is_int($offset)) {
				trigger_error('utf8_strpos: Offset must  be an integer', E_USER_ERROR);
				return false;
			}
			$str = utf8_substr($str, $offset);

			if (false !== ($pos = utf8_strpos($str, $needle))) {
				return $pos + $offset;
			}
			return false;
		}
	}

	/**
	* UTF-8 aware alternative to substr
	* Return part of a string given character offset (and optionally length)
	*
	* Note arguments: comparied to substr - if offset or length are
	* not integers, this version will not complain but rather massages them
	* into an integer.
	*
	* Note on returned values: substr documentation states false can be
	* returned in some cases (e.g. offset > string length)
	* mb_substr never returns false, it will return an empty string instead.
	* This adopts the mb_substr approach
	*
	* Note on implementation: PCRE only supports repetitions of less than
	* 65536, in order to accept up to MAXINT values for offset and length,
	* we'll repeat a group of 65535 characters when needed.
	*
	* Note on implementation: calculating the number of characters in the
	* string is a relatively expensive operation, so we only carry it out when
	* necessary. It isn't necessary for +ve offsets and no specified length
	*
	* @author Chris Smith<chris@jalakai.co.uk>
	* @param string $str
	* @param integer $offset number of UTF-8 characters offset (from left)
	* @param integer $length (optional) length in UTF-8 characters from offset
	* @return mixed string or FALSE if failure
	*/
	function utf8_substr($str, $offset, $length = NULL) {
		// generates E_NOTICE
		// for PHP4 objects, but not PHP5 objects
		$str = (string) $str;
		$offset = (int) $offset;
		if (!is_null($length)) {
			$length = (int) $length;
		}
		// handle trivial cases
		if ($length === 0 || ($offset < 0 && $length < 0 && $length < $offset)) {
			return '';
		}
		// normalise negative offsets (we could use a tail
		// anchored pattern, but they are horribly slow!)
		if ($offset < 0) {
			// see notes
			$strlen = utf8_strlen($str);
			$offset = $strlen + $offset;
			if ($offset < 0)
			{
				$offset = 0;
			}
		}
		$op = '';
		$lp = '';
		// establish a pattern for offset, a
		// non-captured group equal in length to offset
		if ($offset > 0) {
			$ox = (int) ($offset / 65535);
			$oy = $offset % 65535;
			if ($ox) {
				$op = '(?:.{65535}){' . $ox . '}';
			}

			$op = '^(?:' . $op . '.{' . $oy . '})';
		} else {	
			// offset == 0; just anchor the pattern
			$op = '^';
		}
		// establish a pattern for length
		if (is_null($length)) {
			// the rest of the string
			$lp = '(.*)$';
		} else {
			if (!isset($strlen)) {
				// see notes
				$strlen = utf8_strlen($str);
			}
			// another trivial case
			if ($offset > $strlen) {
				return '';
			}
			if ($length > 0) {
				// reduce any length that would
				// go passed the end of the string
				$length = min($strlen - $offset, $length);
				$lx = (int) ($length / 65535);
				$ly = $length % 65535;
				// negative length requires a captured group
				// of length characters
				if ($lx) {
					$lp = '(?:.{65535}){' . $lx . '}';
				}
				$lp = '(' . $lp . '.{'. $ly . '})';
			} else if ($length < 0) {
				if ($length < ($offset - $strlen)) {
					return '';
				}
				$lx = (int)((-$length) / 65535);
				$ly = (-$length) % 65535;
				// negative length requires ... capture everything
				// except a group of -length characters
				// anchored at the tail-end of the string
				if ($lx) {
					$lp = '(?:.{65535}){' . $lx . '}';
				}
				$lp = '(.*)(?:' . $lp . '.{' . $ly . '})$';
			}
		}

		if (!preg_match('#' . $op . $lp . '#us', $str, $match)) {
			return '';
		}
		return $match[1];
	}
	/**
	* Return the length (in characters) of a UTF-8 string
	*
	* @param	string	$text		UTF-8 string
	* @return	integer				Length (in chars) of given string
	*/
	function utf8_strlen($text) {
		// Since utf8_decode is replacing multibyte characters to ? strlen works fine
		return strlen(utf8_decode($text));
	}
}
/**
* Recode a string to UTF-8
*
* If the encoding is not supported, the string is returned as-is
*
* @param	string	$string		Original string
* @param	string	$encoding	Original encoding (lowered)
* @return	string				The string, encoded in UTF-8
*/
function utf8_recode($string, $encoding = 'iso-8859-1', $gym_sitemaps) {
	$encoding = strtolower($encoding);
	if ($encoding == 'utf-8' || !is_string($string) || !isset($string[0])) {
		return $string;
	}
	// start with something simple
	if ( ($gym_sitemaps->rss_config['rss_charset_conv'] === 'utf8_encode') || ($encoding == 'iso-8859-1') ) {
		return utf8_encode($string);
	}
	// First, try iconv()
	if ( function_exists('iconv') && ( ($gym_sitemaps->rss_config['rss_charset_conv'] === 'auto') || ($gym_sitemaps->rss_config['rss_charset_conv'] === 'iconv') ) ) {
		$ret = @iconv($encoding, 'utf-8', $string);

		if (isset($ret[0])) {
			return $ret;
		}
	}
	// Try the mb_string extension
	if (function_exists('mb_convert_encoding') && ( ($gym_sitemaps->rss_config['rss_charset_conv'] === 'auto') || ($gym_sitemaps->rss_config['rss_charset_conv'] === 'iconv') ) ) {
		$ret = @mb_convert_encoding($string, 'utf-8', $encoding);
		if (isset($ret[0])) {
			return $ret;
		}
	}
	// Try the recode extension
	if (function_exists('recode_string') && ( ($gym_sitemaps->rss_config['rss_charset_conv'] === 'auto') || ($gym_sitemaps->rss_config['rss_charset_conv'] === 'recode_string') ) ) {
		$ret = @recode_string($encoding . '..utf-8', $string);
		if (isset($ret[0])) {
			return $ret;
		}
	}
	// If nothing works, check if we have a custom transcoder available
	if (!preg_match('#^[a-z0-9\\-]+$#', $encoding)) {
		// Make sure the encoding name is alphanumeric, we don't want it to be abused into loading arbitrary files
		$gym_sitemaps->mx_sitemaps_message_die(GENERAL_MESSAGE,'Unknown encoding: ' . $encoding);
	}
	global $phpEx;
	// iso-8859-* character encoding
	if (preg_match('/iso[_ -]?8859[_ -]?(\\d+)/', $encoding, $array)) {
		switch ($array[1]) {
			case '1':
			case '2':
			case '4':
			case '7':
			case '9':
			case '15':
				if (!function_exists('iso_8859_' . $array[1])) {
					if (!file_exists($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_basic.' . $phpEx)) {
						$gym_sitemaps->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Basic reencoder file is missing');
					}
					include($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_basic.' . $phpEx);
				}
				return call_user_func('iso_8859_' . $array[1], $string);
			break;
			default:
				$gym_sitemaps->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Unknown encoding: ' . $encoding);
			break;
		}
	}
	// CP/WIN character encoding
	if (preg_match('/(?:cp|windows)[_\- ]?(\\d+)/', $encoding, $array)) {
		switch ($array[1]) {
			case '932':
			break;
			case '1250':
			case '1251':
			case '1254':
			case '1255':
			case '1256':
			case '1257':
			case '874':
				if (!function_exists('cp' . $array[1])) {
					if (!file_exists($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_basic.' . $phpEx)) {
						$gym_sitemaps->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Basic reencoder file is missing');
					}
					include($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_basic.' . $phpEx);
				}
				return call_user_func('cp' . $array[1], $string);
			break;
			default:
				$gym_sitemaps->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Unknown encoding: ' . $encoding);
			break;
		}
	}
	// TIS-620
	if (preg_match('/tis[_ -]?620/', $encoding)) {
		if (!function_exists('tis_620')) {
			if (!file_exists($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_basic.' . $phpEx)) {
				$gym_sitemaps->mx_sitemaps_message_die(GENERAL_MESSAGE, 'Basic reencoder file is missing');
			}
			include($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_basic.' . $phpEx);
		}
		return tis_620($string);
	}
	// SJIS
	if (preg_match('/sjis(?:[_ -]?win)?|(?:cp|ibm)[_ -]?932|shift[_ -]?jis/', $encoding)) {
		if (!function_exists('sjis')) {
			if (!file_exists($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_cjk.' . $phpEx)) {
				$gym_sitemaps->mx_sitemaps_message_die(GENERAL_MESSAGE, 'CJK reencoder file is missing');
			}
			include($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_cjk.' . $phpEx);
		}
		return sjis($string);
	}
	// EUC_KR
	if (preg_match('/euc[_ -]?kr/', $encoding)) {
		if (!function_exists('euc_kr')) {
			if (!file_exists($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_cjk.' . $phpEx)) {
				$gym_sitemaps->mx_sitemaps_message_die(GENERAL_MESSAGE, 'CJK reencoder file is missing');
			}
			include($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_cjk.' . $phpEx);
		}
		return euc_kr($string);
	}
	// BIG-5
	if (preg_match('/big[_ -]?5/', $encoding)) {
		if (!function_exists('big5')) {
			if (!file_exists($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_cjk.' . $phpEx)) {
				$gym_sitemaps->mx_sitemaps_message_die(GENERAL_MESSAGE, 'CJK reencoder file is missing');
			}
			include($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_cjk.' . $phpEx);
		}
		return big5($string);
	}
	// GB2312
	if (preg_match('/gb[_ -]?2312/', $encoding)) {
		if (!function_exists('gb2312')) {
			if (!file_exists($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_cjk.' . $phpEx)) {
				$gym_sitemaps->mx_sitemaps_message_die(GENERAL_MESSAGE, 'CJK reencoder file is missing');
			}
			include($gym_sitemaps->path_config['module_path'] . 'includes/utf/data/recode_cjk.' . $phpEx);
		}
		return gb2312($string);
	}
	// Trigger an error?! Fow now just give bad data :-(
	//trigger_error('Unknown encoding: ' . $encoding, E_USER_ERROR);
	return $string;
}
?>
