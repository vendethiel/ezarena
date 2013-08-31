<?php
/***************************************************************************
*                               admin_adr_cauldron.php
*                              -------------------
*     begin                : 07/02/2005
*     copyright            : One_Piece
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
$phpbb_root_path = "./../";
include_once($phpbb_root_path . 'extension.inc');
include_once('./pagestart.' . $phpEx);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr']['Adr_Cauldron'] = $filename;

	return;
}

define('IN_ADR_ADMIN', 1);
define('IN_ADR_CAULDRON', 1);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

	$mode = ($_POST['mode']) ? $_POST['mode'] : $HTTP_POST_VARS['mode'];
		if (!$mode)
			$mode = ($_GET['mode']) ? $_GET['mode'] : $HTTP_GET_VARS['mode'];

if($mode == 'add')
{
	adr_template_file('admin/config_adr_cauldron_edit_body.tpl');
	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	//
	//Begin Item Choice List
	//

	//Fix item value
	$created_item 	= $HTTP_POST_VARS['item_created'];
	$first_item 	= $HTTP_POST_VARS['item1'];
	$second_item 	= $HTTP_POST_VARS['item2'];
	$third_item 	= $HTTP_POST_VARS['item3'];

// Show item1 list
	$q = "SELECT * 
		  FROM ". $table_prefix ."adr_shops_items
		  WHERE item_owner_id = '1'";
	if (!$r = $db->sql_query($q))
		message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $q);

	$item_data = $db->sql_fetchrowset($r);

// Show item created list
	$item_created_list 	= '<select name="item_created">';
	$item_created_list 	.= '<option selected value="" class="post">'. $lang['Adr_item_choose_item'] .'</option>';
	for ($i = 0; $i < count($item_data); $i++)
		$item_created_list .= '<option value = "'. $item_data[$i]['item_name'] .'" class="post">' . $item_data[$i]['item_name'] . '</option>';
	$item_created_list 	.= '</select>';
		
// Show item1 list	
	$item1_list 	= '<select name="item1">';
	$item1_list 	.= '<option selected value="" class="post">'. $lang['Adr_item_choose_item'] .'</option>';
	for ($i = 0; $i < count($item_data); $i++)
		$item1_list .= '<option value = "'. $item_data[$i]['item_id'] .'" class="post">' . $item_data[$i]['item_name'] . '</option>';
	$item1_list 	.= '</select>';

// Show item2 list
	$item2_list 	= '<select name="item2">';
	$item2_list 	.= '<option selected value="" class="post">'. $lang['Adr_item_choose_item'] .'</option>';
	for ($i = 0; $i < count($item_data); $i++)
		$item2_list .= '<option value = "'. $item_data[$i]['item_id'] .'" class="post">' . $item_data[$i]['item_name'] . '</option>';
	$item2_list 	.= '</select>';

// Show item3 list
	$item3_list 	= '<select name="item3">';
	$item3_list 	.= '<option selected value="" class="post">'. $lang['Adr_item_choose_item'] .'</option>';
	for ($i = 0; $i < count($item_data); $i++)
		$item3_list .= '<option value = "'. $item_data[$i]['item_id'] .'" class="post">' . $item_data[$i]['item_name'] . '</option>';
	$item3_list 	.= '</select>';
	
	//
	//END Item Choice List
	//

	$template->assign_vars(array(
		"ITEM1" => $item1_list,
		"ITEM2" => $item2_list,
		"ITEM3" => $item3_list,
		"ITEM_CREATED" => $item_created_list,
		"L_CAULDRON_TITLE" => $lang['Adr_cauldron'],
		"L_CAULDRON_EXPLAIN" => $lang['Adr_cauldron_explain'],
		"L_ITEM1_TITLE" => $lang['Adr_item1_combine_name'],
		"L_ITEM2_TITLE" => $lang['Adr_item2_combine_name'],
		"L_ITEM3_TITLE" => $lang['Adr_item3_combine_name'],
		"L_ITEM_CREATED_TITLE" => $lang['Adr_item_created_name'],
		"L_SUBMIT" => $lang['Submit'],
		"S_HIDDEN_FIELDS" => $s_hidden_fields,
		"S_CAULDRON_ACTION" => append_sid("admin_adr_cauldron.$phpEx"))
	);

	$template->pparse("body");
}
else if ( $mode != "" )
{
	switch( $mode )
	{
		case 'delete':

			$pack_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			$sql = "DELETE FROM " . phpbb_adr_cauldron_pack  . "
				WHERE pack_id = " . $pack_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete cauldron pack", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_cauldron_pack_successful_deleted , admin_adr_cauldron , '' );
			break;

		case 'edit':

			$pack_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			adr_template_file('admin/config_adr_cauldron_edit_body.tpl');

			$sql = "SELECT *
				FROM " . phpbb_adr_cauldron_pack ."
				WHERE pack_id = " . $pack_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain cauldron pack information', "", __LINE__, __FILE__, $sql);
			}
			$pack = $db->sql_fetchrow($result);

			$combine1_item = $pack['item1_name'];
			$combine2_item = $pack['item2_name'];
			$combine3_item = $pack['item3_name'];
			$combine4_item = $pack['itemwin_name'];

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="pack_id" value="' . $pack['pack_id'] . '" />';

			//
			//Begin Item Choice List
			//

			//Fix item value
			$created_item = $HTTP_POST_VARS['item_created'];
			$first_item = $HTTP_POST_VARS['item1'];
			$second_item = $HTTP_POST_VARS['item2'];
			$third_item = $HTTP_POST_VARS['item3'];

			// Show item created list
			$wsql = " SELECT * FROM  " . phpbb_adr_shops_items . " 
				WHERE item_owner_id = '1' ";
			$wresult = $db->sql_query($wsql);
			If( !$wresult )
			{
				message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $wsql);
			}
			$item_created = $db->sql_fetchrowset($wresult);

			$item_created_list = '<select name="item_created">';
			$item_created_list .= '<option value = "' . $combine4_item . '" >' . $combine4_item . '</option>';
			for ( $i = 0 ; $i < count($item_created) ; $i ++)
			{
			  	$item_created_list .= '<option value = "'.$item_created[$i]['item_name'].'" >' . $item_created[$i]['item_name'] . '</option>';
			}
			$item_created_list .= '</select>';

			// Show item1 list
			$xsql = " SELECT * FROM  " . phpbb_adr_shops_items . " 
				WHERE item_owner_id = '1' ";
			$xresult = $db->sql_query($xsql);
			If( !$xresult )
			{
				message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $xsql);
			}
			$item1 = $db->sql_fetchrowset($xresult);

			$item1_list = '<select name="item1">';
			$item1_list .= '<option value = "' . $combine1_item . '" >' . $combine1_item . '</option>';
			for ( $i = 0 ; $i < count($item1) ; $i ++)
			{
			  	$item1_list .= '<option value = "'.$item1[$i]['item_name'].'" >' . $item1[$i]['item_name'] . '</option>';
			}
			$item1_list .= '</select>';

			// Show item2 list
			$ysql = " SELECT * FROM  " . phpbb_adr_shops_items . " 
				WHERE item_owner_id = '1' ";
			$yresult = $db->sql_query($ysql);
			If( !$yresult )
			{
				message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $ysql);
			}
			$item2 = $db->sql_fetchrowset($yresult);

			$item2_list = '<select name="item2">';
			$item2_list .= '<option value = "' . $combine2_item . '" >' . $combine2_item . '</option>';
			for ( $i = 0 ; $i < count($item2) ; $i ++)
			{
  				$item2_list .= '<option value = "'.$item2[$i]['item_name'].'" >' . $item2[$i]['item_name'] . '</option>';
			}
			$item2_list .= '</select>';

			// Show item3 list
			$zsql = " SELECT * FROM  " . phpbb_adr_shops_items . " 
				WHERE item_owner_id = '1' ";
			$zresult = $db->sql_query($zsql);
			If( !$zresult )
			{
				message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $zsql);
			}
			$item3 = $db->sql_fetchrowset($zresult);

			$item3_list = '<select name="item3">';
			$item3_list .= '<option value = "' . $combine3_item . '" >' . $combine3_item . '</option>';
			for ( $i = 0 ; $i < count($item3) ; $i ++)
			{
			  	$item3_list .= '<option value = "'.$item3[$i]['item_name'].'" >' . $item3[$i]['item_name'] . '</option>';
			}
			$item3_list .= '</select>';

			//
			//END Item Choice List
			//

			$template->assign_vars(array(
				"ITEM1" => $item1_list,
				"ITEM2" => $item2_list,
				"ITEM3" => $item3_list,
				"ITEM_CREATED" => $item_created_list,
				"L_CAULDRON_TITLE" => $lang['Adr_cauldron'],
				"L_CAULDRON_EXPLAIN" => $lang['Adr_cauldron_explain'],
				"L_ITEM1_TITLE" => $lang['Adr_item1_combine_name'],
				"L_ITEM2_TITLE" => $lang['Adr_item2_combine_name'],
				"L_ITEM3_TITLE" => $lang['Adr_item3_combine_name'],
				"L_ITEM_CREATED_TITLE" => $lang['Adr_item_created_name'],
				"L_SUBMIT" => $lang['Submit'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields,
				"S_CAULDRON_ACTION" => append_sid("admin_adr_cauldron.$phpEx")) 
			);

			$template->pparse("body");
			break;

		case "save":

			$pack_id = ( !empty($HTTP_POST_VARS['pack_id']) ) ? intval($HTTP_POST_VARS['pack_id']) : intval($HTTP_GET_VARS['pack_id']);
			$combine1 = ( isset($HTTP_POST_VARS['item1']) ) ? trim($HTTP_POST_VARS['item1']) : trim($HTTP_GET_VARS['item1']);
			$combine2 = ( isset($HTTP_POST_VARS['item2']) ) ? trim($HTTP_POST_VARS['item2']) : trim($HTTP_GET_VARS['item2']);
			$combine3 = ( isset($HTTP_POST_VARS['item3']) ) ? trim($HTTP_POST_VARS['item3']) : trim($HTTP_GET_VARS['item3']);
			$combine_result = ( isset($HTTP_POST_VARS['item_created']) ) ? trim($HTTP_POST_VARS['item_created']) : trim($HTTP_GET_VARS['item_created']);

			if ( $combine1 == '0' || $combine2 == '0' || $combine3 == '0' || $combine_result == '0' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "UPDATE " . phpbb_adr_cauldron_pack . "
				SET item1_name = '" . str_replace("\'", "''", $combine1) . "', 	
					item2_name = '" . str_replace("\'", "''", $combine2) . "', 
					item3_name = '" . str_replace("\'", "''", $combine3) . "',
					itemwin_name = '" . str_replace("\'", "''", $combine_result) . "'
				WHERE pack_id = " . $pack_id;
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update cauldron pack info", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_cauldron_successful_edited , admin_adr_cauldron , '' );
			break;

		case "savenew":

			$sql = "SELECT *
			FROM " . phpbb_adr_cauldron_pack ."
			ORDER BY pack_id 
			DESC LIMIT 1";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain cauldron pack information', "", __LINE__, __FILE__, $sql);
			}
			$fields_data = $db->sql_fetchrow($result);

			$combine1 = ( isset($HTTP_POST_VARS['item1']) ) ? trim($HTTP_POST_VARS['item1']) : trim($HTTP_GET_VARS['item1']);
			$combine2 = ( isset($HTTP_POST_VARS['item2']) ) ? trim($HTTP_POST_VARS['item2']) : trim($HTTP_GET_VARS['item2']);
			$combine3 = ( isset($HTTP_POST_VARS['item3']) ) ? trim($HTTP_POST_VARS['item3']) : trim($HTTP_GET_VARS['item3']);
			$combine_result = ( isset($HTTP_POST_VARS['item_created']) ) ? trim($HTTP_POST_VARS['item_created']) : trim($HTTP_GET_VARS['item_created']);

			$new_id = $fields_data['pack_id'] +1;

			if ( $combine1 == '0' || $combine2 == '0' || $combine3 == '0' || $combine_result == '0' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "INSERT INTO " . phpbb_adr_cauldron_pack . " 
				( pack_id , item1_name , item2_name ,  item3_name , itemwin_name )
				VALUES ( $new_id,'" . str_replace("\'", "''", $combine1) . "', '" . str_replace("\'", "''", $combine2) . "' , '" . str_replace("\'", "''", $combine3) . "' , '" . str_replace("\'", "''", $combine_result) . "' )";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new cauldron pack", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_cauldron_pack_successful_added , admin_adr_cauldron , '' );
			break;
	}
}
else
{
	adr_template_file('admin/config_adr_cauldron_list_body.tpl');

	$template->assign_vars(array(
		'LINK'	=> 'admin_adr_cauldron.'. $phpEx .'?mode=add&sid='. $userdata['session_id'])
			);
			
	$sql = "SELECT *
		FROM " . phpbb_adr_cauldron_pack;
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain cauldron pack information', "", __LINE__, __FILE__, $sql);
	}
	$cauldron_pack = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($cauldron_pack); $i++)
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars("cauldron", array(
			"ROW_CLASS" => $row_class,
			"ITEM_CREATED" => $cauldron_pack[$i]['itemwin_name'],
			"ITEM_COMBINE1" => $cauldron_pack[$i]['item1_name'],
			"ITEM_COMBINE2" => $cauldron_pack[$i]['item2_name'],
			"ITEM_COMBINE3" => $cauldron_pack[$i]['item3_name'],
			"U_CAULDRON_EDIT" => append_sid("admin_adr_cauldron.$phpEx?mode=edit&amp;id=" . $cauldron_pack[$i]['pack_id']), 
			"U_CAULDRON_DELETE" => append_sid("admin_adr_cauldron.$phpEx?mode=delete&amp;id=" . $cauldron_pack[$i]['pack_id']))
		);
	}


	$template->assign_vars(array(
		"L_CAULDRON_TITLE" => $lang['Adr_cauldron'],
		"L_CAULDRON_TEXT" => $lang['Adr_cauldron_explain'],
		"L_ITEM_CREATED" => $lang['Adr_item_created_name'],
		"L_ITEM_COMBINE1" => $lang['Adr_item1_combine_name'],
		"L_ITEM_COMBINE2" => $lang['Adr_item2_combine_name'],
		"L_ITEM_COMBINE3" => $lang['Adr_item3_combine_name'],
		"L_CAULDRON_ADD" => $lang['Adr_cauldron_add'],
		"L_ACTION" => $lang['Action'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		"L_SUBMIT" => $lang['Submit'],
		"S_CAULDRON_ACTION" => append_sid("admin_adr_cauldron.$phpEx"))
	);

	$template->pparse("body");
}
	include_once('./page_footer_admin.'.$phpEx);

?>