<?php
/***************************************************************************
*                               admin_adr_library.php
*                              -------------------
*     begin                : 01/07/2007
*     copyright            : egdcltd (http://games.directorygold.com)
*
*
****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_LIBRARY', 1);
define('IN_ADR_ZONES_ADMIN', 1);
define('IN_ADR_SHOPS', 1);
define('ADR_TYPE_RECIPE', 20);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ADR-Zones']['Library'] = $filename;

	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);


if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) ){
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);}
else{
	$mode = "";}

if( isset($HTTP_POST_VARS['add']) || isset($HTTP_GET_VARS['add']) )
{
	adr_template_file('admin/config_adr_library_edit_body.tpl');

	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	$template->assign_block_vars( 'library_add', array());

	// Zone list
	$zone_list = '<select name="book_zone[]" size="10" multiple>';
	$zone_list .= '<option value="0" SELECTED class="post">'. $lang['Adr_library_acp_zones_all'] .'</option>';
	$sql = "SELECT * FROM " . ADR_ZONES_TABLE ."
			ORDER BY zone_id ASC";
	if( !($result = $db->sql_query($sql)) ){
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);}

	while( $row = $db->sql_fetchrow($result) ){
		$zone_list .= '<option value="' . $row['zone_id'] . '" class="post">' . $row['zone_id'] . '-' . $row['zone_name'] . '</option>';}
	$zone_list .= '</select>';

	//recipe list
  	$sql = "SELECT * FROM ". ADR_SHOPS_ITEMS_TABLE ."
       	WHERE item_owner_id = '1'
	AND item_type_use = '" . ADR_TYPE_RECIPE . "'
		ORDER BY item_name ASC";
   	if (!$result = $db->sql_query($sql))
     		message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $sql);

   	$itemlist = $db->sql_fetchrowset($result);

   	$item_list = '<select name="book_crafting">';
   	$item_list .= '<option selected value="0" class="post">'. $lang['Adr_zone_acp_item_nothing'] .'</option>';
   	for ($i = 0; $i < count($itemlist); $i++)
     		$item_list .= '<option value = "'. $itemlist[$i]['item_id'] .'" class="post">' . adr_get_lang($itemlist[$i]['item_name']) . '</option>';
   	$item_list .= '</select>';

	//difficulty lists
	$difficulty[0] = $lang['Adr_library_very_easy'];
	$difficulty[1] = $lang['Adr_library_easy'];
	$difficulty[2] = $lang['Adr_library_average'];
	$difficulty[3] = $lang['Adr_library_tough'];
	$difficulty[4] = $lang['Adr_library_challenging'];
	$difficulty[5] = $lang['Adr_library_formidable'];
	$difficulty[6] = $lang['Adr_library_heroic'];
	$difficulty[7] = $lang['Adr_library_impossible'];
	$difficulty_list = '<select name="book_difficulty">';
	for( $i = 0; $i < 8; $i++ ){
		$difficulty_list .= '<option value = "'.$i.'">' . $difficulty[$i] . '</option>';}
	$difficulty_list .= '</select>';

	$template->assign_vars(array(
		"LIBRARY_ZONA" => $zone_list,
		"LIBRARY_CRAFTING" => $item_list,
		"DIFFICULTY_LIST" => $difficulty_list,
		"L_LIBRARY_CRAFTING" => $lang['Adr_library_crafting'],
		"L_LIBRARY_CRAFTING_EXPLAIN" => $lang['Adr_library_crafting_explain'],
		"L_LIBRARY_TITLE" => $lang['Adr_library_add_edit'],
		"L_LIBRARY_EXPLAIN" => $lang['Adr_library_add_edit_explain'],
		"L_LIBRARY_NAME" => $lang['Adr_library_name'],
		"L_LIBRARY_NAME_EXPLAIN" => $lang['Adr_library_name_explain'],
		"L_LIBRARY_DESC" => $lang['Adr_library_desc'],
		"L_LIBRARY_DESC_EXPLAIN" => $lang['Adr_library_desc_explain'],
		"L_LIBRARY_ZONE" => $lang['Adr_library_zone'],
		"L_LIBRARY_ZONE_EXPLAIN" => $lang['Adr_library_zone_explain'],
		"L_LIBRARY_DIFFICULTY" => $lang['Adr_library_difficulty'],
		"L_LIBRARY_DIFFICULTY_EXPLAIN" => $lang['Adr_library_difficulty_explain'],
		"L_LIBRARY_DIS" => $lang['Adr_library_false'],
		"L_LIBRARY_DIS_EXPLAIN" => $lang['Adr_library_false_explain'],
		"L_SUBMIT" => $lang['Submit'],
		"S_HIDDEN_FIELDS" => $s_hidden_fields
	));

	$template->pparse("body");
}
else if ( $mode != "" )
{
	switch( $mode )
	{
		case 'delete':

			$book_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			$sql = "DELETE FROM " . ADR_LIBRARY_TABLE . "
					WHERE book_id = " . $book_id;
			if( !($result = $db->sql_query($sql)) ){
				message_die(GENERAL_ERROR, "Couldn't delete book", "", __LINE__, __FILE__, $sql);}

			adr_previous( Adr_library_successful_deleted , admin_adr_library , '' );
			break;

		case 'edit':

			$book_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			adr_template_file('admin/config_adr_library_edit_body.tpl');

			$template->assign_block_vars( 'library_edit', array());

			$sql = "SELECT * FROM " . ADR_LIBRARY_TABLE ."
					WHERE book_id = $book_id ";
			if( !($result = $db->sql_query($sql)) ){
				message_die(GENERAL_ERROR, 'Could not obtain book information', "", __LINE__, __FILE__, $sql);
			}
			$library = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="book_id" value="' . $library['book_id'] . '" />';

			//zone lists
			$zone_selected_array = explode( ',' , $library['book_zone'] );
			$zone_list = '<select name="book_zone[]" size="10" multiple>';
   			$zone_list .= ( $zone_selected_array[0] == '0' ) ? '<option value="0" selected="selected" class="post">'. $lang['Adr_library_acp_zones_all'] .'</option>' : '<option value="0" class="post">'. $lang['Adr_library_acp_zones_all'] .'</option>';
			$sql = "SELECT zone_id, zone_name FROM " . ADR_ZONES_TABLE . "
					ORDER BY zone_id ASC";
			if( !($result = $db->sql_query($sql)) ){
        		message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);}
			while( $row = $db->sql_fetchrow($result) )
			{
				if ( in_array( $row['zone_id'] , $zone_selected_array ) ){
					$zone_list .= '<option value="' . $row['zone_id'] . '" SELECTED class="post">' . $row['zone_id'] . '-' . $row['zone_name'] . '</option>';}
				else{
					$zone_list .= '<option value="' . $row['zone_id'] . '" class="post">' . $row['zone_id'] . '-' . $row['zone_name'] . '</option>';}
			}
			$zone_list .= '</select>';

			//recipe list
 			$sql = "SELECT * FROM ". ADR_SHOPS_ITEMS_TABLE ."
       				WHERE item_owner_id = '1'
				AND item_type_use = '" . ADR_TYPE_RECIPE . "'
					ORDER BY item_name ASC";
   			if (!$result = $db->sql_query($sql))
     				message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $sql);

			$itemlist = $db->sql_fetchrowset($result);

			if($library['book_crafting'])
			{
				$sql = "SELECT item_name FROM ". ADR_SHOPS_ITEMS_TABLE ."
       					WHERE item_owner_id = '1'
					AND item_id = " . $library['book_crafting'] ;
			 	if (!$result = $db->sql_query($sql))
     					message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $sql);

				$crafting = $db->sql_fetchrow($result);
				$crafting_name = adr_get_lang($crafting['item_name']);
			}
			else
			{
				$crafting_name = $lang['Adr_zone_acp_item_nothing'];
			}

			$item_list = '<select name="book_crafting">';
			$item_list .= '<option selected value="0" class="post">'. $lang['Adr_zone_acp_item_nothing'] .'</option><option selected value="'. $library['book_crafting'] .'" class="post">'. $crafting_name .'</option>';
			for ($i = 0; $i < count($itemlist); $i++)
				$item_list .= '<option value = "'. $itemlist[$i]['item_id'] .'" class="post">' . adr_get_lang($itemlist[$i]['item_name']) . '</option>';
			$item_list .= '</select>';

			//difficulty lists
			$difficulty[0] = $lang['Adr_library_very_easy'];
			$difficulty[1] = $lang['Adr_library_easy'];
			$difficulty[2] = $lang['Adr_library_average'];
			$difficulty[3] = $lang['Adr_library_tough'];
			$difficulty[4] = $lang['Adr_library_challenging'];
			$difficulty[5] = $lang['Adr_library_formidable'];
			$difficulty[6] = $lang['Adr_library_heroic'];
			$difficulty[7] = $lang['Adr_library_impossible'];
			$difficulty_list = '<select name="book_difficulty">';
			for( $i = 0; $i < 8; $i++ ){
				$selected = ( $i == $library['book_difficulty'] ) ? ' selected="selected"' : '';
				$difficulty_list .= '<option value = "'.$i.'" '.$selected.' >' . $difficulty[$i] . '</option>';}
			$difficulty_list .= '</select>';

			$template->assign_vars(array(
				"LIBRARY_NAME" => $library['book_name'],
				"LIBRARY_NAME_EXPLAIN" => $library['book_name'],
				"LIBRARY_DESC" => $library['book_details'],
				"LIBRARY_DESC_EXPLAIN" => $library['book_details'],
				"LIBRARY_ZONA" => $zone_list,
				"LIBRARY_FALSE" => ($library['book_false'] ? 'CHECKED' : ''),
				"LIBRARY_CRAFTING" => $item_list,
				"DIFFICULTY_LIST" => $difficulty_list,
				"L_LIBRARY_TITLE" => $lang['Adr_library_add_edit'],
				"L_LIBRARY_EXPLAIN" => $lang['Adr_library_add_edit_explain'],
				"L_LIBRARY_NAME" => $lang['Adr_library_name'],
				"L_LIBRARY_NAME_EXPLAIN" => $lang['Adr_library_name_explain'],
				"L_LIBRARY_DESC" => $lang['Adr_library_desc'],
				"L_LIBRARY_DESC_EXPLAIN" => $lang['Adr_library_desc_explain'],
				"L_LIBRARY_ZONE" => $lang['Adr_library_zone'],
				"L_LIBRARY_ZONE_EXPLAIN" => $lang['Adr_library_zone_explain'],
				"L_LIBRARY_DIFFICULTY" => $lang['Adr_library_difficulty'],
				"L_LIBRARY_DIFFICULTY_EXPLAIN" => $lang['Adr_library_difficulty_explain'],
				"L_LIBRARY_DIS" => $lang['Adr_library_false'],
				"L_LIBRARY_DIS_EXPLAIN" => $lang['Adr_library_false_explain'],
				"L_LIBRARY_CRAFTING" => $lang['Adr_library_crafting'],
				"L_LIBRARY_CRAFTING_EXPLAIN" => $lang['Adr_library_crafting_explain'],
				"L_SUBMIT" => $lang['Submit'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields
			));

			$template->pparse("body");
			break;

		case "save":

			$book_id = ( !empty($HTTP_POST_VARS['book_id']) ) ? intval($HTTP_POST_VARS['book_id']) : intval($HTTP_GET_VARS['book_id']);
			$book_name = ( isset($HTTP_POST_VARS['book_name']) ) ? trim($HTTP_POST_VARS['book_name']) : trim($HTTP_GET_VARS['book_name']);
			if ( in_array( '0' , $HTTP_POST_VARS['book_zone'] ) )
			    $book_zone = '0';
			else
				$book_zone = implode(',' , $HTTP_POST_VARS['book_zone']);
			$book_details = ( isset($HTTP_POST_VARS['book_details']) ) ? trim($HTTP_POST_VARS['book_details']) : trim($HTTP_GET_VARS['book_details']);
			$book_difficulty = intval($HTTP_POST_VARS['book_difficulty']);
			$book_false = intval($HTTP_POST_VARS['book_false']);
			$book_crafting = intval($HTTP_POST_VARS['book_crafting']);

			if (($book_name == '' ) || ($book_details == '' )){
				message_die(MESSAGE, $lang['Fields_empty']);}

			$sql = "UPDATE " . ADR_LIBRARY_TABLE . "
					SET book_name = '" . str_replace("\'", "''", $book_name) . "', 	
						book_details = '" . str_replace("\'", "''", $book_details) . "',
						book_zone = '" . str_replace("\'", "''", $book_zone) . "', 
						book_difficulty = $book_difficulty,
						book_false = '$book_false',
						book_crafting = '$book_crafting'
					WHERE book_id = " . $book_id;
			if( !($result = $db->sql_query($sql)) ){
				message_die(GENERAL_ERROR, "Couldn't update book", "", __LINE__, __FILE__, $sql);}

			adr_previous( Adr_library_successful_edited , admin_adr_library , '' );
			break;

		case "savenew":

			$sql = "SELECT * FROM " . ADR_LIBRARY_TABLE ."
					ORDER BY book_id 
					DESC LIMIT 1";
			if( !($result = $db->sql_query($sql)) ){
				message_die(GENERAL_ERROR, 'Could not obtain books information', "", __LINE__, __FILE__, $sql);}
			$fields_data = $db->sql_fetchrow($result);

			$book_name = ( isset($HTTP_POST_VARS['book_name']) ) ? trim($HTTP_POST_VARS['book_name']) : trim($HTTP_GET_VARS['book_name']);
			if ( in_array( '0' , $HTTP_POST_VARS['book_zone'] ) ){
			    $book_zone = '0';}
			else{
				$book_zone = implode(',' , $HTTP_POST_VARS['book_zone']);}
			$book_details = ( isset($HTTP_POST_VARS['book_details']) ) ? trim($HTTP_POST_VARS['book_details']) : trim($HTTP_GET_VARS['book_details']);
			$book_difficulty = intval($HTTP_POST_VARS['book_difficulty']);
			$book_false = intval($HTTP_POST_VARS['book_false']);
			$book_crafting = intval($HTTP_POST_VARS['book_crafting']);

			$book_id = $fields_data['book_id'] +1;

			if (($book_name == '' ) || ($book_details == '' )){
				message_die(MESSAGE, $lang['Fields_empty']);}

			$sql = "INSERT INTO " . ADR_LIBRARY_TABLE . " 
				( book_id , book_name , book_details , book_zone , book_difficulty , book_false , book_crafting )
				VALUES ( $book_id,'" . str_replace("\'", "''", $book_name) . "', '" . str_replace("\'", "''", $book_details) . "' , '" . str_replace("\'", "''", $book_zone) . "' , $book_difficulty , '$book_false' , '$book_crafting' )";
			if( !($result = $db->sql_query($sql)) ){
				message_die(GENERAL_ERROR, "Couldn't insert new alignment", "", __LINE__, __FILE__, $sql);}

			adr_previous( Adr_library_successful_added , admin_adr_library , '' );
			break;
	}
}
else
{
	adr_template_file('admin/config_adr_library_list_body.tpl');

	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

	if ( isset($HTTP_GET_VARS['mode2']) || isset($HTTP_POST_VARS['mode2']) ){
		$mode2 = ( isset($HTTP_POST_VARS['mode2']) ) ? htmlspecialchars($HTTP_POST_VARS['mode2']) : htmlspecialchars($HTTP_GET_VARS['mode2']);}
	else{
		$mode2 = 'book_id';}

	if(isset($HTTP_POST_VARS['order'])){
		$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';}
	else if(isset($HTTP_GET_VARS['order'])){
		$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';}
	else{
		$sort_order = 'ASC';}

	$mode_types_text = array( $lang['Adr_library_id'] , $lang['Adr_library_zone'] , $lang['Adr_library_name'] , $lang['Adr_library_false'] );
	$mode_types = array( 'book_id','book_zone', 'book_name', 'book_false' );

	$select_sort_mode = '<select name="mode2">';
	for($i = 0; $i < count($mode_types_text); $i++){
		$selected = ( $mode2 == $mode_types[$i] ) ? ' selected="selected"' : '';
		$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';}
	$select_sort_mode .= '</select>';

	$select_sort_order = '<select name="order">';
	if($sort_order == 'ASC'){
		$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';}
	else{
		$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';}
	$select_sort_order .= '</select>';

	switch( $mode2 )
	{
		case 'book_name':
			$order_by = "book_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'book_zone':
			$order_by = "book_zone $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'book_false':
			$order_by = "book_false $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		default:
			$order_by = "book_id $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
	}

	$sql = "SELECT zone_id, zone_name FROM " . ADR_ZONES_TABLE ."
			ORDER BY zone_id ASC";
	if( !($result = $db->sql_query($sql)) ){
		message_die(GENERAL_ERROR, 'Could not obtain zones information', "", __LINE__, __FILE__, $sql);}

	$zone_list = $db->sql_fetchrowset($result);

	$sql = "SELECT * FROM " . ADR_LIBRARY_TABLE . "
			ORDER BY $order_by";
	if( !($result = $db->sql_query($sql)) ){
		message_die(GENERAL_ERROR, 'Could not obtain alignments information', "", __LINE__, __FILE__, $sql);}
	$library = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($library); $i++)
	{
		$book_zone_array = explode( ',' , $library[$i]['book_zone'] );
		$book_false = $library[$i]['book_false'];
		if($library[$i]['book_difficulty'] == '0') $book_difficulty = $lang['Adr_library_very_easy'];
		elseif($library[$i]['book_difficulty'] == '1') $book_difficulty = $lang['Adr_library_easy'];
		elseif($library[$i]['book_difficulty'] == '2') $book_difficulty = $lang['Adr_library_average'];
		elseif($library[$i]['book_difficulty'] == '3') $book_difficulty = $lang['Adr_library_tough'];
		elseif($library[$i]['book_difficulty'] == '4') $book_difficulty = $lang['Adr_library_challenging'];
		elseif($library[$i]['book_difficulty'] == '5') $book_difficulty = $lang['Adr_library_formidable'];
		elseif($library[$i]['book_difficulty'] == '6') $book_difficulty = $lang['Adr_library_heroic'];
		elseif($library[$i]['book_difficulty'] == '7') $book_difficulty = $lang['Adr_library_impossible'];

		$book_zone = '';
		$y = 0;
		for ( $x = 0 ; $x < count( $zone_list ) ; $x++ )
		{
		    if ( in_array( $zone_list[$x]['zone_id'] , $book_zone_array ) )
		    {
				if ( $y == 0 )
				{
					$book_zone .= $zone_list[$x]['zone_id'] . '-' . $zone_list[$x]['zone_name'];
					$y = $y + 1;
				}
				else
				    $book_zone .= '<br />' . $zone_list[$x]['zone_id'] . '-' . $zone_list[$x]['zone_name'];
			}
			else
			{
				if ( $book_zone_array[0] == '0' )
				    $book_zone = $lang['Adr_library_acp_zones_all'];
			}
		}
		$book_false = ( $book_false == 0 ) ? '<font color="green"><b>' . $lang["No"] . '</b></font>' : '<font color="red"><b>' . $lang["Yes"] . '</b></font>';

		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars("library", array(
			"ROW_CLASS" => $row_class,
			"NAME" => $library[$i]['book_name'],
			"ZONE" => $book_zone,
			"DIFFICULTY" => $book_difficulty,
			"FALSE" => $book_false,
			"U_LIBRARY_EDIT" => append_sid("admin_adr_library.$phpEx?mode=edit&amp;id=" . $library[$i]['book_id']), 
			"U_LIBRARY_DELETE" => append_sid("admin_adr_library.$phpEx?mode=delete&amp;id=" . $library[$i]['book_id'])
		));
	}

	$sql = "SELECT * FROM " . ADR_LIBRARY_TABLE;
	if( !($result = $db->sql_query($sql)) ){
		message_die(GENERAL_ERROR, 'Error getting total books', '', __LINE__, __FILE__, $sql);}
	if ( $total_books = $db->sql_numrows($result) ){
		$pagination = generate_pagination("admin_adr_library.$phpEx?mode2=$mode2&amp;order=$sort_order", $total_books, $board_config['topics_per_page'], $start). '&nbsp;';}


	$template->assign_vars(array(
		"L_LIBRARY_TITLE" => $lang['Adr_library'],
		"L_LIBRARY_TEXT" => $lang['Adr_library_explain'],
		"L_SELECT_SORT_METHOD" => $lang['Select_sort_method'],
		"L_ORDER" => $lang['Order'],
		"L_LIBRARY_NAME" => $lang['Adr_library_name'],
		"L_LIBRARY_ZONE" => $lang['Adr_library_zone'],
		"L_LIBRARY_DIFFICULTY" => $lang['Adr_library_difficulty'],
		"L_LIBRARY_FALSE" => $lang['Adr_library_false'],
		"L_LIBRARY_ADD" => $lang['Adr_library_add'],
		"L_ACTION" => $lang['Action'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		"L_SORT" => $lang['Sort'],
		"L_SUBMIT" => $lang['Submit'],
		"S_ORDER_SELECT" => $select_sort_order,
		"S_MODE_SELECT" => $select_sort_mode,
		"PAGINATION" => $pagination,
		"PAGE_NUMBER" => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )),
		"S_LIBRARY_ACTION" => append_sid("admin_adr_library.$phpEx")
	));

	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}
?>