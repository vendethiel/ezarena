<?php
/**
*
* @package class_common_mod
* @version $Id: class_common.php,v 0.9 24/01/2007 20:16 reddog Exp $
* @copyright (c) 2006 reddog - http://www.reddevboard.com/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// current version
define('CLASS_COMMON_VERSION', '0.0.9');

// data type
define('TYPE_INT', 1);
define('TYPE_NO_HTML', 2);
define('TYPE_FLOAT', 3);

/**
* Common Global Functions
* Some parts and/or functions are inspired from Categories Hierarchy 2.1.x by Ptirhiik
*/

/**
* Borrowed from Categories Hierarchy 2.1.x
* Used with image buttons to return an _x and _y value in the $_POST array
*/
function _butt($var)
{
	global $HTTP_POST_VARS;

	if ( isset($HTTP_POST_VARS[$var . '_x']) && isset($HTTP_POST_VARS[$var . '_y']) )
	{
		$HTTP_POST_VARS[$var] = true;
	}
	return (isset($HTTP_POST_VARS[$var]) && !empty($HTTP_POST_VARS[$var]));
}

/**
* Borrowed from Categories Hierarchy 2.1.x
* Used to convert pic buttons to standard input
*/
function _cvt_pic_butts()
{
	global $HTTP_POST_VARS;

	if ( !empty($HTTP_POST_VARS) )
	{
		$added = array();
		foreach ( $HTTP_POST_VARS as $key => $val )
		{
			$var = substr($key, 0, strlen($key)-2);
			if ( ($key == $var . '_x') && isset($HTTP_POST_VARS[$var . '_y']) )
			{
				$added[$var] = true;
			}
		}
		$HTTP_POST_VARS += $added;
	}
}

/**
* Convert special characters to HTML entities
*/
function _html_encode($string)
{
	$cleaned_chars = array("\r\n" => "\n", "\r" => "\n", "\xFF" => ' ');
	$string = trim(htmlentities(
		str_replace(array_keys($cleaned_chars), array_values($cleaned_chars), $string)
		// V: force ISO here, else you're gonna get in trouble ...
		, false, 'ISO-8859-1'));

	return $string;
}

/**
* Convert special HTML entities back to characters
*/
function _html_decode($string)
{
	static $rev_html_translation_table;

	if ( empty($rev_html_translation_table) )
	{
		$rev_html_translation_table = function_exists('get_html_translation_table') ? array_flip(get_html_translation_table(HTML_SPECIALCHARS)) : array('&amp;' => '&', '&#039;' => '\'', '&quot;' => '"', '&lt;' => '<', '&gt;' => '>');
	}
	$string = str_replace('<br />', "\n", $string);

	return function_exists('htmlspecialchars_decode') ? htmlspecialchars_decode($string) : strtr($string, $rev_html_translation_table);
}

/**
* Set variable by type, used by the request_var function
*/
function set_var($val, $type, $list='', $escape_html=true)
{
	switch ( $type )
	{
		case TYPE_INT: // integer
			$val = intval($val);
			$_list = $list;
			break;
		case TYPE_FLOAT: // numeric
			$val = doubleval($val);
			$_list = $list;
			break;
		case TYPE_NO_HTML: // no slashes nor html
			if ( $escape_html )
			{
				$val = _html_encode($val);
				$_list = $list;
				break;
			}
		default:
			$_list = array();
			if ( !$escape_html )
			{
				$val = _html_decode($val);
				$_list = $list;
			}
			break;
	}

	if ( !empty($_list) && is_array($_list) )
	{
		$val = in_array($val, $_list) ? $val : '';
	}

	return $val;
}

/**
* Used to get passed variable
*/
function request_var($var, $type, $dft='', $list='')
{
	global $HTTP_POST_VARS, $HTTP_GET_VARS;

	// adjust with dft
	$res = set_var($dft, $type, $list, false);

	if ( !empty($var) )
	{
		if ( isset($HTTP_POST_VARS[$var]) || isset($HTTP_GET_VARS[$var]) )
		{
			$res = isset($HTTP_POST_VARS[$var]) ? $HTTP_POST_VARS[$var] : urldecode($HTTP_GET_VARS[$var]);
			if ( isset($HTTP_POST_VARS[$var]) && is_array($res) )
			{
				// we have received an array, so do a basic clean
				if ( !empty($res) )
				{
					$tres = array();
					foreach ( $res as $key => $val )
					{
						$key = trim(stripslashes(str_replace(array("\r\n", "\r", '\xFF'), array("\n", "\n", ' '), $key)));
						$val = trim(stripslashes(str_replace(array("\r\n", "\r", '\xFF'), array("\n", "\n", ' '), $val)));
						$tres[$key] = set_var($val, $type, $list);
					}
					$res = $tres;
					unset($tres);
				}
			}
			else if ( !is_array($res) )
			{
				$res = stripslashes($res);
				$res = set_var($res, $type, $list);
			}
			else
			{
				$res = '';
			}
		}
	}
	
	return $res;
}

/**
* Build simple hidden fields from array
*/
function _hide_build($field_ary)
{
	global $s_hidden_fields;

	$s_hidden_fields = '';

	if ( !empty($field_ary) && is_array($field_ary) )
	{
		foreach ( $field_ary as $name => $value )
		{
			$s_hidden_fields .= '<input type="hidden" name="' . addslashes(stripslashes($name)) . '" value="' . addslashes(stripslashes($value)) . '" />';
		}
	}
}

/**
* Send hidden fields to template
*/
function _hide_send($tpl_varname='')
{
	global $s_hidden_fields, $template;

	$tpl_varname = empty($tpl_varname) ? 'S_HIDDEN_FIELDS' : $tpl_varname;
	$template->assign_vars(array($tpl_varname => $s_hidden_fields));
}

/**
* Used to check if a lang key exists
*/
function lang_item($key)
{
	global $lang;

	return !empty($key) && isset($lang[$key]) ? $lang[$key] : $key;
}

/**
* Censoring
*/
function censor_text($str)
{
	static $censors;

	if ( !isset($censors) || !is_array($censors) )
	{
		$censors = array();
		obtain_word_list($censors['match'], $censors['replace']);
	}

	return count($censors['match']) ? preg_replace($censors['match'], $censors['replace'], $str) : $str;
}

/**
* common class
*
* Contains some methods which can be used under certain conditions.
*/
class common
{
	/**
	* Escapes special characters in a string for use in a SQL statement
	*/
	function sql_escape_string($str)
	{
		return str_replace(array('\\\'', '\\"'), array('\'\'', '"'), addslashes($str));
	}

	/**
	* Get the float or integer value of a variable
	* Escapes special characters in a string for use in a SQL statement
	*/
	function sql_type_cast($value, $force_string=false)
	{
		// stripslashes
		$value = stripslashes($value);

		if ( is_numeric($value) && !$force_string )
		{
			return is_float($value) ? doubleval($value) : intval($value);
		}
		if ( is_string($value) || empty($value) || $force_string )
		{
			return '\'' . $this->sql_escape_string($value) . '\'';
		}

		// uncastable var : let's do a basic protection on it to prevent sql injection attempt
		return '\'' . $this->sql_escape_string(htmlspecialchars($value)) . '\'';
	}

	/**
	* Set config value. Creates missing config entry.
	*/
	function set_config($config_name, $config_value)
	{
		global $db, $board_config;

		// stripslashes
		$config_name = stripslashes($config_name);

		if ( !isset($board_config[$config_name]) )
		{
			$sql = 'INSERT INTO ' . CONFIG_TABLE . '
				(config_name, config_value) VALUES (\'' . $this->sql_escape_string($config_name) . '\', ' . $this->sql_type_cast($config_value) . ')';
		}
		else
		{
			$sql = 'UPDATE ' . CONFIG_TABLE . '
				SET config_value = ' . $this->sql_type_cast($config_value) . '
				WHERE config_name = \'' . $this->sql_escape_string($config_name) . '\'';
		}
		$db->sql_query($sql, false, __LINE__, __FILE__);
		$db->clear_cache('config_');

		$board_config[$config_name] = $config_value;
	}
}

/**
* common_get class
*
* Contains other methods which can be used in any circumstance.
*/
class common_get
{
	var $root;
	var $ext;

	function common_get()
	{
		global $phpbb_root_path, $phpEx;

		$this->root = &$phpbb_root_path;
		$this->ext = &$phpEx;
	}

	/**
	* Borrowed from Categories Hierarchy 2.1.x
	* Set foo or foo_ELSE switchs
	*/
	function assign_switch($switch_name, $on=true, $onset=true)
	{
		global $template;

		if ( $onset )
		{
			$template->assign_block_vars($switch_name . ($on ? '' : '_ELSE'), array());
		}
	}

	/**
	* Borrowed from Categories Hierarchy 2.1.x
	* Set url and parms
	*/
	function url($basename, $parms='', $add_sid=false, $fragments='', $force=false)
	{
		global $SID;

		$url_parms = '';
		$parms = empty($parms) ? array() : $parms;

		if ( $add_sid && empty($parms['sid']) )
		{
			$parms['sid'] = substr($SID, strlen('sid='));
		}

		if ( !empty($parms) && is_array($parms) )
		{
			foreach ( $parms as $key => $val )
			{
				if ( !empty($key) && (!empty($val) || $force) )
				{
					$url_parms .= (empty($url_parms) ? '?' : '&amp;') . urlencode($key) . '=' . urlencode(_html_decode($val));
				}
			}
		}

		if ( !empty($fragments) )
		{
			$url_parms .= (empty($url_parms) ? '?#' : '#') . $fragments;
		}

		return ($add_sid && (substr($this->root, 0, 2) == './') ? substr($this->root, 2) : $this->root) . $basename . '.' . $this->ext . $url_parms;
	}
}

/**
* init
*/

// get common settings
$get = new common_get();

// convert pic buttons to standard input
_cvt_pic_butts();

?>