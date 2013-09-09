<?php
/***************************************************************************
 *                                 adr_functions_cache.php
 *                            -------------------
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

if(!defined('IN_PHPBB')){
	die("Hacking attempt");}

function adr_update_all_cache_infos()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $table_prefix, $board_config;

	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	// Update cache files which are currently enabled
	if($cache_config[0] == '1') adr_update_alignment_infos();
	if($cache_config[1] == '1') adr_update_class_infos();
	if($cache_config[2] == '1') adr_update_general_config();
	if($cache_config[3] == '1') adr_update_element_infos();
	if($cache_config[4] == '1') adr_update_item_quality();
	if($cache_config[5] == '1') adr_update_item_type();
	if($cache_config[6] == '1') adr_update_posters_infos();
	if($cache_config[7] == '1') adr_update_race_infos();
	if($cache_config[8] == '1') adr_update_skills();
	if($cache_config[9] == '1') adr_update_monster_infos();

	// Update last update stamp
	$sql= "UPDATE ". ADR_GENERAL_TABLE . " SET config_value = ".time()." WHERE config_name = 'Adr_cache_last_updated' ";
	if(!($result = $db->sql_query($sql)))
		adr_previous(Adr_character_general_update_error, admin_adr_general, '');
}

function adr_get_poster_infos($poster_id)
{
	global $db, $lang, $phpEx, $phpbb_root_path, $board_config, $table_prefix;

	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$poster_id = intval($poster_id);
	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	if($cache_config[6])
	{
		// All the following code has been made by Ptirhiik
		@include( $phpbb_root_path . './adr/cache/cache_posters.' . $phpEx );

		if ( !(empty($adr_posters)) )
		{
			$cached_adr_posters = $adr_posters[$poster_id];
		}
		else
		{
			$sql = "SELECT c.character_level, r.race_name, r.race_img, e.element_name, e.element_img, a.alignment_name, a.alignment_img,
				cl.class_name, cl.class_img
				FROM  " . ADR_CHARACTERS_TABLE . " c, " . ADR_RACES_TABLE . " r, " . ADR_ELEMENTS_TABLE . " e, " . ADR_ALIGNMENTS_TABLE . " a, " . ADR_CLASSES_TABLE . " cl
				WHERE c.character_id = '$poster_id'
				AND cl.class_id = c.character_class
				AND r.race_id = c.character_race
				AND e.element_id = c.character_element
				AND a.alignment_id = c.character_alignment ";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error Getting Adr Users!', '', __LINE__, __FILE__, $sql);
			}

			@include( $phpbb_root_path . './adr/cache/cache_posters.' . $phpEx );

			if ( empty($adr_posters) )
			{
				adr_update_posters_infos();

				include( $phpbb_root_path . './adr/cache/cache_posters.' . $phpEx );

				$cached_adr_posters = $adr_posters[$poster_id];
			}
		}
	}
	else
	{
		$poster_sql = "SELECT c.character_level, r.race_name, r.race_img, e.element_name, e.element_img, a.alignment_name, a.alignment_img,
			cl.class_name, cl.class_img
			FROM  " . ADR_CHARACTERS_TABLE . " c, " . ADR_RACES_TABLE . " r, " . ADR_ELEMENTS_TABLE . " e, " . ADR_ALIGNMENTS_TABLE . " a, " . ADR_CLASSES_TABLE . " cl
			WHERE c.character_id = $poster_id
			AND cl.class_id = c.character_class
			AND r.race_id = c.character_race
			AND e.element_id = c.character_element
			AND a.alignment_id = c.character_alignment ";
		if ( !($poster_result = $db->sql_query($poster_sql)) )
		{
			message_die(GENERAL_ERROR, 'Error Getting Adr Users!', '', __LINE__, __FILE__, $sql);
		}
		$cached_adr_posters = $db->sql_fetchrow($poster_result);
	}

	return $cached_adr_posters;
}

function adr_update_posters_infos()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $table_prefix;

	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$template = new Template($phpbb_root_path);

	$template->set_filenames(array(
		'cache' => 'adr/cache/cache_tpls/cache_posters_def.tpls')
	);

	$sql = "SELECT c.character_id , c.character_level, r.race_name, r.race_img, e.element_name, e.element_img, a.alignment_name, a.alignment_img, cl.class_name , cl.class_img
		FROM  " . ADR_CHARACTERS_TABLE . " c, " . ADR_RACES_TABLE . " r, " . ADR_ELEMENTS_TABLE . " e, " . ADR_ALIGNMENTS_TABLE . " a, " . ADR_CLASSES_TABLE . " cl
		WHERE cl.class_id = c.character_class
		AND r.race_id = c.character_race
		AND e.element_id = c.character_element
		AND a.alignment_id = c.character_alignment ";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Error Getting Adr Users infos for cache update!', '', __LINE__, __FILE__, $sql);
	}

	$x = 1;
	while ( $row = $db->sql_fetchrow($result) )
	{
		$id = $x;
		$cells = array();
		@reset($row);
		while ( list($key, $value) = @each($row) )
		{
			$nkey = intval($key);
			if ( $key != "$nkey" )
			{
				$cells[] = sprintf( "'%s' => '%s'", str_replace("'", "\'", $key), str_replace("'", "\'", $value));
			}
		}
		$s_cells = empty($cells) ? '' : implode(', ', $cells);

		$template->assign_block_vars('cache_row', array(
			'ID'		=> sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS'		=> $s_cells,
		));
		$x = ($x + 1);
	}

	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	$fname = $phpbb_root_path . './adr/cache/cache_posters'.'.' . $phpEx;
	@chmod($fname, 0666);
	$handle = @fopen($fname, 'w');
	@fwrite($handle, $res);
	@fclose($handle);
}

function adr_get_skill_data($target_skill)
{

	global $db, $lang, $phpEx, $phpbb_root_path, $board_config;

	$target_skill = intval($target_skill);
	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);
	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	if($cache_config[8])
	{
		// All the following code has been made by Ptirhiik
		@include( $phpbb_root_path . './adr/cache/cache_skills.' . $phpEx );

		if ( !(empty($adr_skills)) )
		{
			while ( list($skill_id , $skill_data) = @each($adr_skills) )
			{
				$cached_adr_skills[$skill_id] = $skill_data;
			}
		}
		else
		{
			$sql = "SELECT * FROM  " . ADR_SKILLS_TABLE;
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Unable to query skill infos (cache)', '', __LINE__, __FILE__, $sql);
			}

			@include( $phpbb_root_path . './adr/cache/cache_skills.' . $phpEx );

			if ( empty($adr_skills) )
			{
				adr_update_skills();

				include( $phpbb_root_path . './adr/cache/cache_skills.' . $phpEx );

				while ( list($skill_id , $skill_data) = @each($adr_skills) )
				{
					$cached_adr_skills[$skill_id] = $skill_data;
				}
			}
		}
	}
	else
	{

		$skill_sql = "SELECT * FROM  " . ADR_SKILLS_TABLE;
		if (!$skill_result = $db->sql_query($skill_sql))
		{
			message_die(GENERAL_ERROR, 'Unable to query skill infos (non-cache)', '', __LINE__, __FILE__, $sql);
		}
		$adr_skills = $db->sql_fetchrowset($skill_result);
		for($s = 0; $s < count($adr_skills); $s++)
		{
			$cached_adr_skills[$row['skill_id']] = $adr_skills[$s];
		}
	}

	if ( $target_skill )
	{
		return $cached_adr_skills[$target_skill];
	}
	else
	{
		return $cached_adr_skills;
	}
}

function adr_update_skills()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path;

	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$template = new Template($phpbb_root_path);
	$template->set_filenames(array(
		'cache' => 'adr/cache/cache_tpls/cache_skills_def.tpls')
	);

	$sql = "SELECT * FROM  " . ADR_SKILLS_TABLE . "
		ORDER BY skill_id";
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Unable to query skill infos (updating cache)', '', __LINE__, __FILE__, $sql);
	}

	$x = 1;
	while ( $row = $db->sql_fetchrow($result) )
	{
		// $id = $x;
		// V: let's use skill ID instead of incremental id
		$id = $row['skill_id'];
		$cells = array();
		@reset($row);
		while ( list($key, $value) = @each($row) )
		{
			$nkey = intval($key);
			if ( $key != "$nkey" )
			{
				$cells[] = sprintf( "'%s' => '%s'", str_replace("'", "\'", $key), str_replace("'", "\'", $value));
			}
		}
		$s_cells = empty($cells) ? '' : implode(', ', $cells);

		$template->assign_block_vars('cache_row', array(
			'ID'		=> sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS'		=> $s_cells,
		));
		// $x = ($x + 1);
	}

	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	$fname = $phpbb_root_path . './adr/cache/cache_skills'.'.' . $phpEx;
	@chmod($fname, 0666);
	$handle = @fopen($fname, 'w');
	@fwrite($handle, $res);
	@fclose($handle);
}

function adr_get_item_quality($item, $type)
{
	global $db, $lang, $phpEx, $phpbb_root_path, $board_config, $table_prefix;

	define('IN_ADR_SHOPS', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);
	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	if($cache_config[4])
	{
		// All the following code has been made by Ptirhiik
		@include($phpbb_root_path . './adr/cache/cache_item_quality.' . $phpEx);

		if(!(empty($adr_item_quality))){
			while(list($item_quality_id , $item_quality_data) = @each($adr_item_quality)){
				$items_quality[$item_quality_id] = $item_quality_data;}
		}
		else
		{
			$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_QUALITY_TABLE;
			if(!$result = $db->sql_query($sql)){
				message_die(GENERAL_ERROR, 'Unable to query item quality infos (cache)', '', __LINE__, __FILE__, $sql);}

			@include( $phpbb_root_path . './adr/cache/cache_item_quality.' . $phpEx );

			if ( empty($adr_item_quality) )
			{
				adr_update_item_quality();

				include( $phpbb_root_path . './adr/cache/cache_item_quality.' . $phpEx );

				while ( list($item_quality_id , $item_quality_data) = @each($adr_item_quality) )
				{
					$items_quality[$item_quality_id] = $item_quality_data;
				}
			}
		}
	}
	else{
		$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_QUALITY_TABLE;
		if(!$result = $db->sql_query($sql)){
			message_die(GENERAL_ERROR, 'Unable to query item quality infos (non-cache)', '', __LINE__, __FILE__, $sql);}
		$items_quality = $db->sql_fetchrowset($result);
	}

	$item = intval($item);

	switch($type)
	{
		case 'list':

			$quality = '<select name="item_quality">';
			for ($l = 1 ; $l < count($items_quality) ; $l++ )
			{
				$selected = ( $items_quality[$l]['item_quality_id'] == $item ) ? 'selected="selected"' : '';
				$quality .= '<option value = "'.$items_quality[$l]['item_quality_id'].'" '.$selected.'>' . $lang[$items_quality[$l]['item_quality_lang']] . '</option>';
			}
			$quality .= '</select>';
			return $quality;

			break;

		case 'search':

			$quality = '<select name="item_quality">';
			for ($l = 0 ; $l < count($items_quality) ; $l++ )
			{
				$quality .= '<option value = "'.$items_quality[$l]['item_quality_id'].'" >' . $lang[$items_quality[$l]['item_quality_lang']] . '</option>';
			}
			$quality .= '</select>';
			return $quality;

			break;

		case 'simple':

			$quality = intval($item);
			$quality = $lang[$items_quality[$quality]['item_quality_lang']];
			return $quality;

			break;

		case 'price':

			$item = intval($item);
			$quality = $items_quality[$item]['item_quality_modifier_price'];
			return $quality;
			break;
	}

}

function adr_update_item_quality()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $table_prefix;

	$template = new Template($phpbb_root_path);
	define('IN_ADR_SHOPS', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$template->set_filenames(array(
		'cache' => 'adr/cache/cache_tpls/cache_item_quality_def.tpls')
	);

//	$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_QUALITY_TABLE;
	$sql = "SELECT * FROM ".$table_prefix . 'adr_shops_items_quality
		ORDER BY item_quality_id';
	if (!$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Unable to query item quality infos (updating cache)', '', __LINE__, __FILE__, $sql);
	}

	$x = 0;
	while ( $row = $db->sql_fetchrow($result) )
	{
		$id = $x;
		$cells = array();
		@reset($row);
		while ( list($key, $value) = @each($row) )
		{
			$nkey = intval($key);
			if ( $key != "$nkey" )
			{
				$cells[] = sprintf( "'%s' => '%s'", str_replace("'", "\'", $key), str_replace("'", "\'", $value));
			}
		}
		$s_cells = empty($cells) ? '' : implode(', ', $cells);

		$template->assign_block_vars('cache_row', array(
			'ID'		=> sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS'		=> $s_cells,
			));
		$x = ($x + 1);
	}

	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	$fname = $phpbb_root_path . './adr/cache/cache_item_quality'.'.' . $phpEx;
	@chmod($fname, 0666);
	$handle = @fopen($fname, 'w');
	@fwrite($handle, $res);
	@fclose($handle);
}

function adr_get_item_type($type, $mode)
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $board_config;

	$type = intval($type);
	define('IN_ADR_SHOPS', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);
	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	if($cache_config[5])
	{
		// All the following code has been made by Ptirhiik
		@include( $phpbb_root_path . './adr/cache/cache_item_type.' . $phpEx );

		if ( !(empty($adr_item_type)) )
		{
			while ( list($item_type_id , $item_type_data) = @each($adr_item_type) )
			{
				$items_type[$item_type_id] = $item_type_data;
			}
		}
		else
		{
			$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_TYPE_TABLE ;
			if (!$result = $db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Unable to query item type infos (cache)', '', __LINE__, __FILE__, $sql);
			}

			@include( $phpbb_root_path . './adr/cache/cache_item_type.' . $phpEx );

			if ( empty($adr_item_type) )
			{
				adr_update_item_type();

				include( $phpbb_root_path . './adr/cache/cache_item_type.' . $phpEx );

				while ( list($item_type_id , $item_type_data) = @each($adr_item_type) )
				{
					$items_type[$item_type_id] = $item_type_data;
				}
			}
		}
	}
	else
	{
		$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_TYPE_TABLE ;
		if (!$result = $db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, 'Unable to query item type infos (non-cache)', '', __LINE__, __FILE__, $sql);
		}
		$items_type = $db->sql_fetchrowset($result);
	}

	switch($mode)
	{
		case 'list':

			$item_type = '<select name="item_type_use">';
			for ($l = 1 ; $l < count($items_type) ; $l++ )
			{
				$selected = ( $items_type[$l]['item_type_id'] == $type ) ? 'selected="selected"' : '';
				$item_type .= '<option value = "'.$items_type[$l]['item_type_id'].'" '.$selected.'>' . adr_get_lang($items_type[$l]['item_type_lang']) . '</option>';
			}
			$item_type .= '</select>';
			return $item_type;
			break;

		case 'search':

			$item_type = '<select name="item_type_use">';
			for ($l = 0 ; $l < count($items_type) ; $l++ )
			{
				$item_type .= '<option value = "'.$items_type[$l]['item_type_id'].'" >' . adr_get_lang($items_type[$l]['item_type_lang']) . '</option>';

			}
			$item_type .= '</select>';
			return $item_type;
			break;

		case 'simple':

			$item_type = adr_get_lang($items_type[$type]['item_type_lang']);
			return $item_type;
			break;

		case 'price':

			$item_type = $items_type[$type]['item_type_base_price'];
			return $item_type;

			break;
	}
}

function adr_update_item_type()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $table_prefix;

	$template = new Template($phpbb_root_path);
	define('IN_ADR_SHOPS', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$template->set_filenames(array(
		'cache' => 'adr/cache/cache_tpls/cache_item_type_def.tpls')
	);

//	$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_TYPE_TABLE;
	$sql = "SELECT * FROM ".$table_prefix . 'adr_shops_items_type
		ORDER BY item_type_category, item_type_order';
	if(!$result = $db->sql_query($sql)){
		message_die(GENERAL_ERROR, 'Unable to query item type infos (updating cache)', '', __LINE__, __FILE__, $sql);}

	$x = 0;
	while($row = $db->sql_fetchrow($result))
	{
		$id = $x;
		$cells = array();
		@reset($row);
		while(list($key, $value) = @each($row))
		{
			$nkey = intval($key);
			if($key != "$nkey"){
				$cells[] = sprintf( "'%s' => '%s'", str_replace("'", "\'", $key), str_replace("'", "\'", $value));
			}
		}
		$s_cells = empty($cells) ? '' : implode(', ', $cells);

		$template->assign_block_vars('cache_row', array(
			'ID'		=> sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS'		=> $s_cells,
			)
		);
		$x = ($x + 1);
	}

	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	$fname = $phpbb_root_path . './adr/cache/cache_item_type'.'.' . $phpEx;
	@chmod($fname, 0666);
	$handle = @fopen($fname, 'w');
	@fwrite($handle, $res);
	@fclose($handle);
}

function adr_get_element_infos($element_id)
{
	global $db, $lang, $phpEx, $phpbb_root_path, $board_config, $table_prefix;

	if (!defined('IN_ADR_CHARACTER')){
		define('IN_ADR_CHARACTER', 1);
	}
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);
	$element_id = intval($element_id);
	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	if($cache_config[3]){
		// All the following code has been made by Ptirhiik
		@include( $phpbb_root_path . './adr/cache/cache_elements.' . $phpEx );

		if(!(empty($adr_elements))){
			$cached_adr_elements = $adr_elements[$element_id];
		}
		else
		{
			$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE . "
				WHERE element_id = '$element_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Unable to query element infos (cache)', '', __LINE__, __FILE__, $sql);}

			@include($phpbb_root_path . './adr/cache/cache_elements.' . $phpEx);

			if(empty($adr_elements)){
				adr_update_element_infos();
				include($phpbb_root_path . './adr/cache/cache_elements.' . $phpEx);
				$cached_adr_elements = $adr_elements[$element_id];
			}
		}
	}
	else{
		$element_sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE . "
			WHERE element_id = '$element_id'";
		if(!($element_result = $db->sql_query($element_sql)) ){
			message_die(GENERAL_ERROR, 'Unable to query element infos (non-cache)', '', __LINE__, __FILE__, $sql);}
		$cached_adr_elements = $db->sql_fetchrow($element_result);
	}

	return $cached_adr_elements;
}

function adr_update_element_infos()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $table_prefix;

	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$template = new Template($phpbb_root_path);

	$template->set_filenames(array(
		'cache' => 'adr/cache/cache_tpls/cache_elements_def.tpls')
	);

	$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE . "
		ORDER BY element_id";
	if (!$result = $db->sql_query($sql)){
				message_die(GENERAL_ERROR, 'Unable to query element infos (updating cache)', '', __LINE__, __FILE__, $sql);
	}

	$x = 1;
	while($row = $db->sql_fetchrow($result))
	{
		$id = $x;
		$cells = array();
		@reset($row);
		while(list($key, $value) = @each($row)){
			$nkey = intval($key);
			if($key != "$nkey"){
				$cells[] = sprintf( "'%s' => '%s'", str_replace("'", "\'", $key), str_replace("'", "\'", $value));
			}
		}
		$s_cells = empty($cells) ? '' : implode(', ', $cells);

		$template->assign_block_vars('cache_row', array(
			'ID'		=> sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS'		=> $s_cells,
		));
		$x = ($x + 1);
	}

	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	$fname = $phpbb_root_path . './adr/cache/cache_elements'.'.' . $phpEx;
	@chmod($fname, 0666);
	$handle = @fopen($fname, 'w');
	@fwrite($handle, $res);
	@fclose($handle);
}

function adr_get_alignment_infos($alignment_id)
{
	global $db, $lang, $phpEx, $phpbb_root_path, $board_config, $table_prefix;

	if (!defined('IN_ADR_CHARACTER')){
		define('IN_ADR_CHARACTER', 1);
	}
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);
	$alignment_id = intval($alignment_id);
	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	if($cache_config[0]){
		// All the following code has been made by Ptirhiik
		@include( $phpbb_root_path . './adr/cache/cache_alignments.' . $phpEx );

		if(!(empty($adr_alignments))){
			$cached_adr_alignments = $adr_alignments[$alignment_id];
		}
		else
		{
			$sql = "SELECT * FROM " . ADR_ALIGNMENTS_TABLE . "
				WHERE alignment_id = '$alignment_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Unable to query alignment infos (cache)', '', __LINE__, __FILE__, $sql);}

			@include($phpbb_root_path . './adr/cache/cache_alignments.' . $phpEx);

			if(empty($adr_alignments)){
				adr_update_alignment_infos();
				include($phpbb_root_path . './adr/cache/cache_alignments.' . $phpEx);
				$cached_adr_alignments = $adr_alignments[$alignment_id];
			}
		}
	}
	else{
		$alignment_sql = "SELECT * FROM " . ADR_ALIGNMENTS_TABLE . "
			WHERE alignment_id = '$alignment_id'";
		if(!($alignment_result = $db->sql_query($alignment_sql)) ){
			message_die(GENERAL_ERROR, 'Unable to query element infos (non-cache)', '', __LINE__, __FILE__, $sql);}
		$cached_adr_alignments = $db->sql_fetchrow($alignment_result);
	}

	return $cached_adr_alignments;
}

function adr_update_alignment_infos()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $table_prefix;

	if (!defined('IN_ADR_CHARACTER')){
		define('IN_ADR_CHARACTER', 1);
	}
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$template = new Template($phpbb_root_path);

	$template->set_filenames(array(
		'cache' => 'adr/cache/cache_tpls/cache_alignments_def.tpls')
	);

	$sql = "SELECT * FROM " . ADR_ALIGNMENTS_TABLE . "
		ORDER BY alignment_id";
	if (!$result = $db->sql_query($sql)){
		message_die(GENERAL_ERROR, 'Unable to query alignment infos (updating cache)', '', __LINE__, __FILE__, $sql);
	}

	$x = 1;
	while($row = $db->sql_fetchrow($result))
	{
		$id = $x;
		$cells = array();
		@reset($row);
		while(list($key, $value) = @each($row)){
			$nkey = intval($key);
			if($key != "$nkey"){
				$cells[] = sprintf( "'%s' => '%s'", str_replace("'", "\'", $key), str_replace("'", "\'", $value));
			}
		}
		$s_cells = empty($cells) ? '' : implode(', ', $cells);

		$template->assign_block_vars('cache_row', array(
			'ID'		=> sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS'		=> $s_cells,
		));
		$x = ($x + 1);
	}

	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	$fname = $phpbb_root_path . './adr/cache/cache_alignments'.'.' . $phpEx;
	@chmod($fname, 0666);
	$handle = @fopen($fname, 'w');
	@fwrite($handle, $res);
	@fclose($handle);
}

function adr_get_class_infos($class_id)
{
	global $db, $lang, $phpEx, $phpbb_root_path, $board_config, $table_prefix;

	if (!defined('IN_ADR_CHARACTER')){
		define('IN_ADR_CHARACTER', 1);
	}
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);
	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	if($cache_config[1]){
		// All the following code has been made by Ptirhiik
		@include( $phpbb_root_path . './adr/cache/cache_classes.' . $phpEx );

		if(!(empty($adr_classes))){
			$cached_adr_classes = $adr_classes[$class_id];
		}
		else
		{
			$sql = "SELECT * FROM " . ADR_CLASSES_TABLE . "
				WHERE class_id = '$class_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Unable to query class infos (cache)', '', __LINE__, __FILE__, $sql);}

			@include($phpbb_root_path . './adr/cache/cache_classes.' . $phpEx);

			if(empty($adr_classes)){
				adr_update_class_infos();
				include($phpbb_root_path . './adr/cache/cache_classes.' . $phpEx);
				$cached_adr_classes = $adr_classes[$class_id];
			}
		}
	}
	else{
		$class_sql = "SELECT * FROM " . ADR_CLASSES_TABLE . "
			WHERE class_id = '$class_id'";
		if(!($class_result = $db->sql_query($class_sql)) ){
			message_die(GENERAL_ERROR, 'Unable to query class infos (non-cache)', '', __LINE__, __FILE__, $sql);}
		$cached_adr_classes = $db->sql_fetchrow($class_result);
	}

	return $cached_adr_classes;
}

function adr_update_class_infos()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $table_prefix;

	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$template = new Template($phpbb_root_path);

	$template->set_filenames(array(
		'cache' => 'adr/cache/cache_tpls/cache_classes_def.tpls')
	);

	$sql = "SELECT * FROM " . ADR_CLASSES_TABLE . "
		ORDER BY class_id";
	if (!$result = $db->sql_query($sql)){
				message_die(GENERAL_ERROR, 'Unable to query class infos (updating cache)', '', __LINE__, __FILE__, $sql);
	}

	$x = 1;
	while($row = $db->sql_fetchrow($result))
	{
		$id = $x;
		$cells = array();
		@reset($row);
		while(list($key, $value) = @each($row)){
			$nkey = intval($key);
			if($key != "$nkey"){
				$cells[] = sprintf( "'%s' => '%s'", str_replace("'", "\'", $key), str_replace("'", "\'", $value));
			}
		}
		$s_cells = empty($cells) ? '' : implode(', ', $cells);

		$template->assign_block_vars('cache_row', array(
			'ID'		=> sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS'		=> $s_cells,
		));
		$x = ($x + 1);
	}

	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	$fname = $phpbb_root_path . './adr/cache/cache_classes'.'.' . $phpEx;
	@chmod($fname, 0666);
	$handle = @fopen($fname, 'w');
	@fwrite($handle, $res);
	@fclose($handle);
}

function adr_get_race_infos($race_id)
{
	global $db, $lang, $phpEx, $phpbb_root_path, $board_config, $table_prefix;

	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);
	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	if($cache_config[7]){
		// All the following code has been made by Ptirhiik
		@include( $phpbb_root_path . './adr/cache/cache_races.' . $phpEx );

		if(!(empty($adr_races))){
			$cached_adr_races = $adr_races[$race_id];
		}
		else
		{
			$sql = "SELECT * FROM " . ADR_RACES_TABLE . "
				WHERE race_id = '$race_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Unable to query race infos (cache)', '', __LINE__, __FILE__, $sql);}

			@include($phpbb_root_path . './adr/cache/cache_races.' . $phpEx);

			if(empty($adr_races)){
				adr_update_race_infos();
				include($phpbb_root_path . './adr/cache/cache_races.' . $phpEx);
				$cached_adr_races = $adr_races[$race_id];
			}
		}
	}
	else{
		$race_sql = "SELECT * FROM " . ADR_RACES_TABLE . "
			WHERE race_id = '$race_id'";
		if(!($race_result = $db->sql_query($race_sql)) ){
			message_die(GENERAL_ERROR, 'Unable to query race infos (non-cache)', '', __LINE__, __FILE__, $sql);}
		$cached_adr_races = $db->sql_fetchrow($race_result);
	}

	return $cached_adr_races;
}

function adr_update_race_infos()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $table_prefix;

	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$template = new Template($phpbb_root_path);

	$template->set_filenames(array(
		'cache' => 'adr/cache/cache_tpls/cache_races_def.tpls')
	);

	$sql = "SELECT * FROM " . ADR_RACES_TABLE . "
		ORDER BY race_id";
	if (!$result = $db->sql_query($sql)){
		message_die(GENERAL_ERROR, 'Unable to query class infos (updating cache)', '', __LINE__, __FILE__, $sql);
	}

	$x = 1;
	while($row = $db->sql_fetchrow($result))
	{
		$id = $x;
		$cells = array();
		@reset($row);
		while(list($key, $value) = @each($row)){
			$nkey = intval($key);
			if($key != "$nkey"){
				$cells[] = sprintf( "'%s' => '%s'", str_replace("'", "\'", $key), str_replace("'", "\'", $value));
			}
		}
		$s_cells = empty($cells) ? '' : implode(', ', $cells);

		$template->assign_block_vars('cache_row', array(
			'ID'		=> sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS'		=> $s_cells,
		));
		$x = ($x + 1);
	}

	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	$fname = $phpbb_root_path . './adr/cache/cache_races'.'.' . $phpEx;
	@chmod($fname, 0666);
	$handle = @fopen($fname, 'w');
	@fwrite($handle, $res);
	@fclose($handle);
}

function adr_get_monster_infos($monster_id)
{
	global $db, $lang, $phpEx, $phpbb_root_path, $board_config, $table_prefix;

	if (!defined('IN_ADR_CHARACTER')){
		define('IN_ADR_CHARACTER', 1);
	}
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);
	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	if($cache_config[9]){
		// All the following code has been made by Ptirhiik
		@include($phpbb_root_path . './adr/cache/cache_monsters.' . $phpEx);

		if(!(empty($adr_monsters))){
			$cached_adr_monsters = $adr_monsters[$monster_id];
		}
		else
		{
			$sql = "SELECT * FROM " . ADR_BATTLE_MONSTERS_TABLE . "
				WHERE monster_id = '$monster_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Unable to query monster infos (cache)', '', __LINE__, __FILE__, $sql);}

			@include($phpbb_root_path . './adr/cache/cache_monsters.' . $phpEx);

			if(empty($adr_monsters)){
				adr_update_monster_infos();
				include($phpbb_root_path . './adr/cache/cache_monsters.' . $phpEx);
				$cached_adr_monsters = $adr_monsters[$monster_id];
			}
		}
	}
	else{
		$monster_sql = "SELECT * FROM " . ADR_BATTLE_MONSTERS_TABLE . "
			WHERE monster_id = '$monster_id'";
		if(!($monster_result = $db->sql_query($monster_sql)) ){
				message_die(GENERAL_ERROR, 'Unable to query monster infos (non-cache)', '', __LINE__, __FILE__, $sql);}
		$cached_adr_monsters = $db->sql_fetchrow($monster_result);
	}

	return $cached_adr_monsters;
}

function adr_update_monster_infos()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $table_prefix;

	define('IN_ADR_BATTLE', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$template = new Template($phpbb_root_path);

	$template->set_filenames(array(
		'cache' => 'adr/cache/cache_tpls/cache_monsters_def.tpls')
	);

//	$sql = "SELECT * FROM " . ADR_BATTLE_MONSTERS_TABLE;
	$sql = "SELECT * FROM ".$table_prefix . 'adr_battle_monsters
		ORDER BY monster_id';
	if (!$result = $db->sql_query($sql)){
		message_die(GENERAL_ERROR, 'Unable to query monster infos (updating cache)', '', __LINE__, __FILE__, $sql);
	}

	$x = 1;
	while($row = $db->sql_fetchrow($result))
	{
		$id = $row['monster_id'];
		$cells = array();
		@reset($row);
		while(list($key, $value) = @each($row)){
			$nkey = intval($key);
			if($key != "$nkey"){
				$cells[] = sprintf( "'%s' => '%s'", str_replace("'", "\'", $key), str_replace("'", "\'", $value));
			}
		}
		$s_cells = empty($cells) ? '' : implode(', ', $cells);

		$template->assign_block_vars('cache_row', array(
			'ID'		=> sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS'		=> $s_cells,
		));
	}

	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	$fname = $phpbb_root_path . './adr/cache/cache_monsters'.'.' . $phpEx;
	@chmod($fname, 0666);
	$handle = @fopen($fname, 'w');
	@fwrite($handle, $res);
	@fclose($handle);
}

function adr_get_general_config()
{
	global $db, $lang, $phpEx, $phpbb_root_path, $board_config, $table_prefix;

	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);
	$cache_config = explode('-', $board_config['Adr_use_cache_system']);

	if($cache_config[6]){
		// All the following code has been made by Ptirhiik
		@include( $phpbb_root_path . './adr/cache/cache_config.' . $phpEx);

		if(!(empty($adr_config))){
			while(list($config_name, $config_value) = @each($adr_config)){
				$cached_adr_config[$config_name] = $config_value;}
		}
		else{
			$sql = "SELECT * FROM  " . ADR_GENERAL_TABLE;
			if(!$result = $db->sql_query($sql)){
				message_die(GENERAL_ERROR, 'Unable to query config infos (cache)', '', __LINE__, __FILE__, $sql);}

			@include( $phpbb_root_path . './adr/cache/cache_config.' . $phpEx);

			if(empty($adr_config)){
				adr_update_general_config();

				include($phpbb_root_path . './adr/cache/cache_config.' . $phpEx);

				while(list($config_name, $config_value) = @each($adr_config)){
					$cached_adr_config[$config_name] = $config_value;
				}
			}
		}
	}
	else{
		$sql = "SELECT * FROM  " . ADR_GENERAL_TABLE;
		if(!$result = $db->sql_query($sql)){
			message_die(GENERAL_ERROR, 'Unable to query config infos (non-cache)', '', __LINE__, __FILE__, $sql);
		}
		while( $row = $db->sql_fetchrow($result)){
			$cached_adr_config[$row['config_name']] = $row['config_value'];
		}
	}

	return $cached_adr_config;
}

function adr_update_general_config()
{
	global $db, $lang, $phpEx, $userdata, $phpbb_root_path, $table_prefix;

	$template = new Template($phpbb_root_path);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$template->set_filenames(array(
		'cache' => 'adr/cache/cache_tpls/cache_config_def.tpls')
	);

	$sql = "SELECT * FROM " . ADR_GENERAL_TABLE. "
			ORDER BY config_name ASC";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, 'Unable to query config infos (updating cache)', '', __LINE__, __FILE__, $sql);
	}
	while ( $row = $db->sql_fetchrow($result) )
	{
		$id = $row['config_name'];
		$cell_res = $row['config_value'];

		$template->assign_block_vars('cache_row', array(
			'ID'		=> sprintf("'%s'", str_replace("'", "\'", $id)),
			'CELLS'	=> sprintf("'%s'", str_replace("'", "\'", $cell_res)),
			));
	}

	$template->assign_var_from_handle('cache', 'cache');
	$res = "<?php\n" . $template->_tpldata['.'][0]['cache'] . "\n?>";

	$fname = $phpbb_root_path . './adr/cache/cache_config'.'.' . $phpEx;
	@chmod($fname, 0666);
	$handle = @fopen($fname, 'w');
	@fwrite($handle, $res);
	@fclose($handle);
}

function adr_get_item_type_categories($category = 'none'){
	global $categories_text, $categories, $categories_cat, $db, $phpbb_root_path, $phpEx, $lang, $adr_item_type;
	adr_get_item_type(0, '');
	require_once( $phpbb_root_path . './adr/cache/cache_item_type.' . $phpEx );
	
	if ( !isset($adr_item_type) )
	{
		if ( $category != 'none') 
		{
			$category = explode(",",$category);
			for($a=0;$a<=count($category);$a++) $category_list .= "'".$category[$a]."',";
			$where = " AND item_type_category IN (".$category_list." 0)";
		
		}
		// Get and display all the items type
		$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_TYPE_TABLE . "
			WHERE item_type_id <> 0 $where
			ORDER BY item_type_category, item_type_order ASC";  
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(GENERAL_ERROR, 'Unable to query config infos (updating cache)', '', __LINE__, __FILE__, $sql);
		}
		$items_type = $db->sql_fetchrowset($result);
		
		for ( $t = 0 ; $t < count($items_type) ; $t ++ )
		{
			array_push($categories_text, $items_type[$t]['item_type_lang']);
			array_push($categories, $items_type[$t]['item_type_id']);
			array_push($categories_cat, $items_type[$t]['item_type_category']);
		}
	}
	else
	{
		if($category != 'none') $category = explode(',',$category);
		for ( $t = 0 ; $t < count($adr_item_type) ; $t ++ )
		{
			if($category == 'none')
			{
				array_push($categories_text, $adr_item_type[$t]['item_type_lang']);
				array_push($categories, $adr_item_type[$t]['item_type_id']);
				array_push($categories_cat, $adr_item_type[$t]['item_type_category']);
			}
			elseif(in_array($adr_item_type[$t]['item_type_category'],$category))
			{
				array_push($categories_text, $adr_item_type[$t]['item_type_lang']);
				array_push($categories, $adr_item_type[$t]['item_type_id']);
				array_push($categories_cat, $adr_item_type[$t]['item_type_category']);
			
			}
		}
	}
}