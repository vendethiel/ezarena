<?php
/***************************************************************************
                            admin_category_order.php 
                            ------------------------
    begin			: Sat May 14 2006
    copyright		: Daniel Vandersluis
    email			: daniel@codexed.com
    version			: 1.0.0

 ***************************************************************************/

/***************************************************************************
 *                                                                                      
 *   This program is free software; you can redistribute it and/or modify   
 *   it under the terms of the GNU General Public License as published by  
 *   the Free Software Foundation; either version 2 of the License, or          
 *   (at your option) any later version.
 *
 ***************************************************************************/
 
define('IN_PHPBB', 1);

if( !empty($setmodules)	)
{
	return;
}

function sort_categories($s, $t)
{
	if (is_numeric($s) && is_numeric($t)) return $t - $s;
	elseif (is_numeric($s) && !is_numeric($t)) return -1;
	elseif (is_numeric($t) && !is_numeric($s)) return 1;
	else return strcmp($s, $t);
}

//
// Load default header
//
$phpbb_root_path = './../';
require $phpbb_root_path . 'extension.inc';

$no_page_header = FALSE;
require './pagestart.' . $phpEx;

//
// Handle the different modes:
//
if (isset($HTTP_POST_VARS['mode']) || (isset($HTTP_GET_VARS['mode'])))
{
	$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $HTTP_POST_VARS['mode'];
	$mode = strtolower(htmlspecialchars($mode));
}

//
// Get Module information:
//
$setmodules = 1;
$dir = @opendir(".");
while( $file = @readdir($dir) )
{
	if( preg_match("/^admin_.*?\." . $phpEx . "$/", $file) && strcmp($file, basename(__FILE__)) != 0 )
	{
		include_once('./' . $file);
	}
}
@closedir($dir);
unset($setmodules);

$categories = $module;
foreach($categories as $c) 
{
	$c = array(); // we're just interested in the category name
}

$sql = "SELECT *
	FROM " . ADMIN_CATS_TABLE;

if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_ERROR, "Couldn't obtain admin category information.", "", __LINE__, __FILE__, $sql);
}

while ($row = $db->sql_fetchrow($result))
{
	$id = $row['cat_identifier'];

	if (!empty($row['cat_order']))
	{
		$order = $row['cat_order'];
		$categories[$order]['identifier'] = $id;
		$categories[$order]['display_name'] = (empty($row['cat_display']) ? NULL : $row['cat_display']);
		$categories[$order]['id'] = $row['id'];
		unset($categories[$id]);
	}
	else
	{
		$categories[$id]['order'] = (empty($row['cat_order']) ? NULL : $row['cat_order']);
		$categories[$id]['display_name'] = (empty($row['cat_display']) ? NULL : $row['cat_display']);
		$categories[$id]['id'] = $row['id'];
	}
}
uksort($categories, "sort_categories");

//
// Handle the different modes:
//
if ($mode == "move" || $mode == "create")
{
	$dir = isset($HTTP_GET_VARS['dir']) ? intval($HTTP_GET_VARS['dir']) : NULL;
	$pivot_set = isset($HTTP_GET_VARS['id']);
	$pivot = ($mode == "move") ? intval($HTTP_GET_VARS['id']) : urldecode(base64_decode($HTTP_GET_VARS['id']));
}

if (($mode == "move" || $mode == "create") && ($dir == DIR_UP || $dir == DIR_DOWN) && $pivot_set)
{
	//
	// Set an order index for each category (even though not all of them will be saved):
	//
	$i = 0;
	$max = 0;
	foreach($categories as $id => $cat)
	{
		if (is_numeric($id))
		{
			$max = $id;
			if ($mode == "move" && $cat['id'] == $pivot) $p = $id;
		}
		else
		{
			$categories[$max-$i] = $categories[$id];
			$categories[$max-$i]['identifier'] = $id;
			if ($mode == "move" && $cat['id'] == $pivot) $p = $max-$i;
			elseif ($mode == "create" && $id == $pivot) $p = $max-$i;

			unset($categories[$id]);
			$id = $max - $i;
		}
		$i++;
	}
	
	$min = min(array_keys($categories));
	if ($min < 1)
	{
		foreach ($categories as $key => $cat)
		{
			$new_id = $key + 1 - $min;
			$categories[$new_id] = $cat;

			if ($mode == "move" && $cat['id'] == $pivot) $p = $new_id;
			elseif ($mode == "create" && $key == $p) $p = $new_id;

			unset($categories[$key]);
		}
	}

	$penultimate = false;
	$last = NULL;
	$prev = NULL;
	$prev_key = NULL;

	reset($categories);
	while (list($key, $val) = each($categories))
	{
		prev($categories);
		$next = next($categories);
		$next = is_null($next) || $next === false ? null : $next;
		$next_key = key($categories);
	
		if ($dir == DIR_UP) // Move up
		{
			if ($key == $p)
			{
				if (!is_null($prev))
				{
					$categories[$key] = $prev;
					$categories[$prev_key] = $val;
				}

				$last = $key;

				break;
			}
		}
		elseif ($dir == DIR_DOWN) // Move down
		{
			if ($penultimate == true)
			{
				$last = $key;
				break;
			}
			elseif ($key == $p)
			{
				$penultimate = true;

				if (!is_null($next))
				{
					$categories[$key] = $next;
					$categories[$next_key] = $val;
				}
			}
		}

		$prev = is_null($val) || $val === false ? null : $val;
		$prev_key = $key;
	}

	if (is_null($last))
	{
		end($categories);
		$last = key($categories);
	}
		
	foreach ($categories as $order => $cat)
	{
		// Remove everything after the last needed item:
		if ($order < $last) unset($categories[$order]);
	}

	foreach ($categories as $order => $cat)
	{
		if (isset($cat['id']))
		{
			$sql = "UPDATE " . ADMIN_CATS_TABLE . "
				SET cat_order = $order
				WHERE id = {$cat['id']}";
		}
		else
		{
			$sql = "INSERT INTO " . ADMIN_CATS_TABLE . "
				(cat_identifier, cat_order)
				VALUES('{$cat['identifier']}', $order)";
		}
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Couldn't write admin category information.", "", __LINE__, __FILE__, $sql);
		}
	}

	$message = $lang['ACP_cat_moved'] . "<br /><br />"
			 . sprintf($lang['Click_return_catadmin'], "<a href=\""
			 . append_sid("admin_category_order.$phpEx") . "\">", "</a>") . "<br /><br />"
			 . sprintf($lang['Click_return_admin_index'], "<a href=\""
			 . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

	message_die(GENERAL_MESSAGE, $message);
}
else
{
	$template->set_filenames(array(
		"body" => "admin/acp_category_list_body.tpl")
	);
	
	$template->assign_vars(array(
		"L_MOVE_UP" => $lang['Move_up'],
		"L_MOVE_DOWN" => $lang['Move_down'],
		"L_CAT_DISPLAY" => $lang['ACP_cat_display'],
		"L_REORDER" => $lang['Reorder'],
		"L_CATEGORIES_TITLE" => $lang['ACP_cat_title'],
		"L_CATEGORIES_EXPLAIN" => $lang['ACP_cat_explain'],
		
		"S_ACTIONS_ACTION" => append_sid("admin_category_order.$phpEx"))
	);

	$i = 0;
	foreach ($categories as $id => $cat)
	{
		$ident = isset($cat['identifier']) ? $cat['identifier'] : $id;
		$langstr = isset($lang[$id]) ? $lang[$id] : preg_replace("/_/", " ", $id);
		$cat_title = isset($cat['identifier'])
			? (isset($lang[$cat['identifier']]) ? $lang[$cat['identifier']] : preg_replace("/_/", " ", $cat['identifier']))
			: $langstr;
		$cat_id = $cat['id'];
		$ordered = isset($cat['identifier']);

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		
		if (!empty($cat_id))
		{
			$move_up = "?mode=move&amp;dir=1&amp;id=$cat_id";
			$move_down = "?mode=move&amp;dir=-1&amp;id=$cat_id";
		}
		else
		{
			$ident = urlencode(base64_encode($ident));
			$move_up = "?mode=create&amp;id=$ident&amp;dir=1";
			$move_down = "?mode=create&amp;id=$ident&amp;dir=-1";
		}

		$template->assign_block_vars("categories", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"DISPLAY" => $cat_title,
			"ID" => $cat_id,

			"U_MOVE_UP" => append_sid("admin_category_order.{$phpEx}{$move_up}"),
			"U_MOVE_DOWN" => append_sid("admin_category_order.{$phpEx}{$move_down}"))
		);
		$i++;
	}
	unset($i);
}

$template->pparse("body");
include('./page_footer_admin.'.$phpEx);
?>
