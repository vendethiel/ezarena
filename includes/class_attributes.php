<?php
/**
*
* @package quick_title_edition_mod
* @version $Id: functions_attributes.php,v 1.1.4 2007/11/21 11:59 PastisD Exp $
* @copyright (c) 2007 PastisD - http://www.oxygen-powered.net/
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

class qte
{
	var $attr = array();
	var $name = array();

	function qte()
	{
		global $db;

		$sql = 'SELECT * FROM ' . ATTRIBUTES_TABLE . ' ORDER BY attribute_order ASC';
		if (!$result = $db->sql_query($sql, false, 'qte_'))
		{
			message_die(GENERAL_MESSAGE, $lang['Attr_Error_Message_09']);
		}
		while ($row = $db->sql_fetchrow($result))
		{
			$this->attr[$row['attribute_id']] = array(
				'attribute_id' => $row['attribute_id'],
				'attribute_type' => $row['attribute_type'],
				'attribute' => $row['attribute'],
				'attribute_image' => $row['attribute_image'],
				'attribute_color' => $row['attribute_color'],
				'attribute_date_format' => $row['attribute_date_format'],
				'attribute_position' => $row['attribute_position'],
				'attribute_author' => $row['attribute_author'], 
				'attribute_administrator' => $row['attribute_administrator'],
				'attribute_moderator' => $row['attribute_moderator'],
			);
		}
		$db->sql_freeresult();

		$sql = 'SELECT user_id, username FROM ' . USERS_TABLE . ' WHERE user_id <> ' . ANONYMOUS;
		if (!$result = $db->sql_query($sql, false, 'users_'))
		{
			message_die(GENERAL_MESSAGE, $lang['Attr_Error_Message_10']);
		}
		while ($row = $db->sql_fetchrow($result))
		{
			$this->name[$row['user_id']] = array('username' => $row['username']);
		}
		$db->sql_freeresult();
	}

	/**
	*	Attributes display function
	*/
	function attr(&$topic_title, $topic_attribute)
	{
		global $board_config, $lang, $db;

		if ( !empty($topic_attribute) )
		{
			list($attr_id, $user_id, $attr_date) = explode(',', $topic_attribute);
			$attribute = lang_item($this->attr[$attr_id]['attribute']);
			$attribute = str_replace('%mod%', phpbb_clean_username($this->name[$user_id]['username']), $attribute);
			$attribute = str_replace('%date%', create_date($this->attr[$attr_id]['attribute_date_format'], $attr_date, $board_config['board_timezone']), $attribute);
			$attribute = !$this->attr[$attr_id]['attribute_type'] ? '<span ' . get_color($this->attr[$attr_id]['attribute'], $this->attr[$attr_id]['attribute_color']) . '>' . $attribute . '</span>' : '<img src="' . image_item($this->attr[$attr_id]['attribute_image']) . '" alt="' . $attribute . '" title="' . $attribute . '" />';
			$topic_title = $this->attr[$attr_id]['attribute_position'] ? $topic_title . ' ' . $attribute : $attribute . ' ' . $topic_title;
		}
	}

	/**
	*	Attributes selector
	*/
	function combo($topic_attribute, $topic_poster)
	{
		global $board_config, $lang, $db, $userdata;

		$combo = '<select name="attribute_id"><option value="-1" style="font-weight: bold;">' . $lang['No_Attribute'] . '</option>';
		if ($topic_attribute)
		{
			list($attr_id, $user_id) = explode(',', $topic_attribute);
		}
		else
		{
			$attr_id = $user_id = null;
		}

		foreach ($this->attr as $attr)
		{
			if (($attr['attribute_author'] && $userdata['user_level'] == USER && $userdata['user_id'] == $topic_poster) || ($attr['attribute_moderator'] && $userdata['user_level'] == MOD) || ($attr['attribute_administrator'] && $userdata['user_level'] == ADMIN))
			{
				$selected = ( $attr['attribute_id'] == $attr_id ) ? ' selected="selected"' : '';
				$attribute = lang_item($attr['attribute']);
				$attribute = str_replace('%mod%', phpbb_clean_username($userdata['username']), $attribute);
				$attribute = str_replace('%date%', create_date($attr['attribute_date_format'], time(), $board_config['board_timezone']), $attribute);

				$combo .= '<option value="' . $attr['attribute_id'] . '" ' . get_color($attr['attribute'], $attr['attribute_color']) . $selected . '>' . $attribute . '</option>';
			}
		}
		$combo .= '</select>';

		return $combo;
	}
}

$qte = new qte();

/**
* Used to check if a image key exists
*/
function image_item($key)
{
	global $images;

	return !empty($key) && isset($images[$key]) ? $images[$key] : $key;
}

/**
*	Used to have a different color for each template
*	This function is from reddog's Rank Color System MOD, http://www.reddevboard.com/
*/
function get_color($a_name, $a_color)
{
	return empty($a_color) ? ( empty($a_name) ? '' : 'class="' . $a_name . '"' ) : 'style="color:#' . $a_color . '; font-weight:bold;"';
}