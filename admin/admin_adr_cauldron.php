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
	$module['ADR-Recipes']['Adr_Cauldron'] = $filename;

	return;
}

define('IN_ADR_ADMIN', 1);
define('IN_ADR_CAULDRON', 1);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$mode = $_REQUEST['mode'];
// V: fixup that "add" button...
if (isset($_POST['add']))
	$mode = 'add';

if ( $mode != "" )
{
	switch( $mode )
	{
		case 'add':
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
				$item_created_list .= '<option value = "'. $item_data[$i]['item_id'] .'" class="post">' . $item_data[$i]['item_name'] . '</option>';
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
			break;
		case 'delete':

			$pack_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			$sql = "DELETE FROM " . ADR_CAULDRON_TABLE  . "
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
				FROM " . ADR_CAULDRON_TABLE ."
				WHERE pack_id = " . $pack_id;
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain cauldron pack information', "", __LINE__, __FILE__, $sql);
			}
			$pack = $db->sql_fetchrow($result);

			$combine1_item = $pack['item1_id'];
			$combine2_item = $pack['item2_id'];
			$combine3_item = $pack['item3_id'];
			$combinewin_item = $pack['itemwin_id'];

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="pack_id" value="' . $pack['pack_id'] . '" />';

			//
			//Begin Item Choice List
			//

			// V: fixed all this shit up... many unnecessary queries... sigh...
			// Show item created list
			$wsql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . " 
				WHERE item_owner_id = '1' ";
			$wresult = $db->sql_query($wsql);
			if( !$wresult )
			{
				message_die(GENERAL_ERROR, 'Could not obtain inventory information', "", __LINE__, __FILE__, $wsql);
			}
			$items = $db->sql_fetchrowset($wresult);

			$item_created_list = '<select name="item_created">';
			for ( $i = 0 ; $i < count($items) ; $i ++)
			{
			  	$item_created_list .= '<option value = "'.$items[$i]['item_id'].'"' . html_selected($items[$i]['item_id'] == $combinewin_item) . '>' . $items[$i]['item_name'] . '</option>';
			}
			$item_created_list .= '</select>';

			$item1_list = '<select name="item1">';
			for ( $i = 0 ; $i < count($items) ; $i ++)
			{
			  	$item1_list .= '<option value = "'.$items[$i]['item_id'].'"' . html_selected($items[$i]['item_id'] == $combine1_item) . '>' . $items[$i]['item_name'] . '</option>';
			}
			$item1_list .= '</select>';

			// Show item2 list
			$item2_list = '<select name="item2">';
			for ( $i = 0 ; $i < count($items) ; $i ++)
			{
  				$item2_list .= '<option value = "'.$items[$i]['item_id'].'"' . html_selected($items[$i]['item_id'] == $combine2_item) . '>' . $items[$i]['item_name'] . '</option>';
			}
			$item2_list .= '</select>';

			// Show item3 list
			$item3_list = '<select name="item3">';
			for ( $i = 0 ; $i < count($items) ; $i ++)
			{
			  	$item3_list .= '<option value = "'.$items[$i]['item_id'].'"' . html_selected($items[$i]['item_id'] == $combine3_item) . '>' . $items[$i]['item_name'] . '</option>';
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

			$sql = "UPDATE " . ADR_CAULDRON_TABLE . "
				SET item1_id = '" . intval($combine1) . "', 	
					item2_id = '" . intval($combine2) . "', 
					item3_id = '" . intval($combine3) . "',
					itemwin_id = '" . intval($combine_result) . "'
				WHERE pack_id = " . $pack_id;
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update cauldron pack info", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_cauldron_successful_edited , admin_adr_cauldron , '' );
			break;

		case "savenew":

			$sql = "SELECT *
			FROM " . ADR_CAULDRON_TABLE ."
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

			$sql = "INSERT INTO " . ADR_CAULDRON_TABLE . " 
				( pack_id , item1_id , item2_id ,  item3_id , itemwin_id )
				VALUES ( $new_id,'" . intval($combine1) . "', '" . intval($combine2) . "' , '" . intval($combine3) . "' , '" . intval($combine_result) . "' )";
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
		FROM " . ADR_CAULDRON_TABLE;
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain cauldron pack information', "", __LINE__, __FILE__, $sql);
	}
	$cauldron_pack = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($cauldron_pack); $i++)
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		// V: annoyingly enough, we need to call adr_get_item/adr_get_lang (I added it) here.. :(
		$template->assign_block_vars("cauldron", array(
			"ROW_CLASS" => $row_class,
			"ITEM_CREATED" => adr_get_lang(adr_get_item($cauldron_pack[$i]['itemwin_id'])['item_name']),
			"ITEM_COMBINE1" => adr_get_lang(adr_get_item($cauldron_pack[$i]['item1_id'])['item_name']),
			"ITEM_COMBINE2" => adr_get_lang(adr_get_item($cauldron_pack[$i]['item2_id'])['item_name']),
			"ITEM_COMBINE3" => adr_get_lang(adr_get_item($cauldron_pack[$i]['item3_id'])['item_name']),
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
