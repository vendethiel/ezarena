<?php
/***************************************************************************
*                               admin_adr_townmap.php
*                              -------------------
*     begin                : 25/11/2004
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
define('IN_TOWNMAP_ADMIN', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_CHARACTER', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr']['Adr_townmap'] = $filename;

	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);


if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);
}
else

{
	$mode = "";
}


 if ( $mode != "" )
{
	switch( $mode )
	{

		case 'edit':

			$townmap_id = ( !empty($HTTP_POST_VARS['id']) ) ? intval($HTTP_POST_VARS['id']) : intval($HTTP_GET_VARS['id']);

			adr_template_file('admin/config_adr_townmap_edit_body.tpl');

			$template->assign_block_vars( 'alignments_edit', array());

			$sql = "SELECT *
				FROM " . ADR_TOWNMAP_TABLE ."
				WHERE townmap_id = $townmap_id ";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain TownMap information', "", __LINE__, __FILE__, $sql);
			}
			$alignments = $db->sql_fetchrow($result);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="townmap_id" value="' . $alignments['townmap_id'] . '" />';

			$pic = $alignments['townmap_img'];

			$template->assign_vars(array(
				"TOWNMAP_NAME" => $alignments['townmap_name'],
				"TOWNMAP_NAME_EXPLAIN" => adr_get_lang($alignments['townmap_name']),
				"TOWNMAP_DESC" => $alignments['townmap_desc'],
				"TOWNMAP_DESC_EXPLAIN" => adr_get_lang($alignments['townmap_desc']),
				"TOWNMAP_IMG" => $alignments['townmap_img'],
				"TOWNMAP_IMG_EX" => $pic ,
				"L_TOWNMAP_TITLE" => $lang['TownMap_title_edit'],
				"L_TOWNMAP_EXPLAIN" => $lang['TownMap_title_edit_explain'],
				"L_NAME" => $lang['TownMap_townmap_name'],
				"L_NAME_EXPLAIN" => $lang['TownMap_townmap_name_explain'],
				"L_DESC" => $lang['TownMap_townmap_desc'],
				"L_IMG" => $lang['TownMap_townmap_image'],
				"L_IMG_EXPLAIN" => $lang['TownMap_townmap_image_explain'],
				"L_SUBMIT" => $lang['TownMap_Submit'],
				"S_HIDDEN_FIELDS" => $s_hidden_fields) 
			);

			$template->pparse("body");
			break;

		case "save":

			$townmap_id = ( !empty($HTTP_POST_VARS['townmap_id']) ) ? intval($HTTP_POST_VARS['townmap_id']) : intval($HTTP_GET_VARS['townmap_id']);
			$townmap_name = ( isset($HTTP_POST_VARS['townmap_name']) ) ? trim($HTTP_POST_VARS['townmap_name']) : trim($HTTP_GET_VARS['townmap_name']);
			$townmap_img = ( isset($HTTP_POST_VARS['townmap_img']) ) ? trim($HTTP_POST_VARS['townmap_img']) : trim($HTTP_GET_VARS['townmap_img']);
			$townmap_desc = ( isset($HTTP_POST_VARS['townmap_desc']) ) ? trim($HTTP_POST_VARS['townmap_desc']) : trim($HTTP_GET_VARS['townmap_desc']);

			if ($townmap_name == '' )
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			$sql = "UPDATE " . ADR_TOWNMAP_TABLE . "
				SET townmap_name = '" . str_replace("\'", "''", $townmap_name) . "', 	
					townmap_desc = '" . str_replace("\'", "''", $townmap_desc) . "', 
					townmap_img = '" . str_replace("\'", "''", $townmap_img) . "'
				WHERE townmap_id = " . $townmap_id ;
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update TownMap info", "", __LINE__, __FILE__, $sql);
			}

			adr_previous( Adr_TownMap_successful_edited , admin_adr_townmap , '' );
			break;
	}
}
else
{
	adr_template_file('admin/config_adr_townmap_list_body.tpl');

	$sql = "SELECT *
		FROM " . ADR_TOWNMAP_TABLE;
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain TownMap information', "", __LINE__, __FILE__, $sql);
	}

	$alignments = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($alignments); $i++)
	{
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$num[1] = $lang['TownMap_1'];
		$num[2] = $lang['TownMap_2'];
		$num[3] = $lang['TownMap_3'];
		$num[4] = $lang['TownMap_4'];

		$townmap_num = $num[$alignments[$i]['townmap_num']];

		$pic = $alignments[$i]['townmap_img'];

		$template->assign_block_vars("alignments", array(
			"ROW_CLASS" => $row_class,
			"NUM" => $townmap_num,
			"NAME" => adr_get_lang($alignments[$i]['townmap_name']),
			"DESC" => adr_get_lang($alignments[$i]['townmap_desc']),
			"IMG" => $pic ,
			"U_TOWNMAP_EDIT" => append_sid("admin_adr_townmap.$phpEx?mode=edit&amp;id=" . $alignments[$i]['townmap_id']))
		);
	}


//
// récupérer les boutons
$submit = isset($HTTP_POST_VARS['submit']);

// 
// vérifier le formulaire
if ($submit)
{
	// récupérer les valeurs du formulaire
	$carte = trim(str_replace('"', '&quot;', $HTTP_POST_VARS['carte']));
	
	// vérifier les valeurs
	if ( $carte == '' ) message_die(GENERAL_ERROR, $lang['Fields_empty'] . ': ' . $lang['TownMap_num_name']);

	// mettre à jour la bdd
	$sql = "select  townmap_map  from " . ADR_TOWNMAPMAP_TABLE ;
	if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, "Could not acces TownMapMAP table.", '', __LINE__, __FILE__, $sql);
	$exist = ($row = $db->sql_fetchrow($result));
	if (!$exist)
	{
	// création
	$sql = "insert into " . ADR_TOWNMAPMAP_TABLE . "(townmap_map) VALUES  ('$carte')";
	if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, "Could not acces TownMapMAP table.", '', __LINE__, __FILE__, $sql);
	}
	else
	{
	// mise à jour
	$sql ="update " . ADR_TOWNMAPMAP_TABLE . " set townmap_map='$carte'"; 
	if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, "Could not acces TownMapMAP table.", '', __LINE__, __FILE__, $sql);
	}
}


// RaZ des variables écrans
$carte = '';

// lecture de la base
$sql = "select  townmap_map  from " . ADR_TOWNMAPMAP_TABLE ;
if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, "Could not acces TownMapMAP table.", '', __LINE__, __FILE__, $sql);
if ($alignments = $db->sql_fetchrow($result))
{
	$carte = $alignments['townmap_map'];
}

// sauvegarde des paramètres
$s_hidden_fields  = '<input type="hidden" name="mode" value="' . $mode . '">';
$s_hidden_fields .= '<input type="hidden" name="key"  value="' . $key . '">';

// charger les variables
$pgm_ret = append_sid( "admin_newshr.$phpEx?mode=$mode&key=$key" );
$template->assign_vars(array(
	'TOWNMAP_MAP' => $carte,
	
	'S_PGM' => $pgm_ret,
	'S_HIDDEN_FIELDS'	=> $s_hidden_fields,	
	)
);


	$template->assign_vars(array(
		"TOWNMAP_MAP" => $carte,
		"L_NAME" => $lang['TownMap_name'],
		"L_TOWNMAP_TITLE" => $lang['TownMap_title'],
		"L_TOWNMAP_TEXT" => $lang['TownMap_explain'],
		"L_NUM_NAME" => $lang['TownMap_num_name'],
		"L_NUM" => $lang['TownMap_num'],
		"L_NUM_EXPLAIN" => $lang['TownMap_num_explain'],
		"L_IMG" => $lang['TownMap_image'],
		"L_DESC" => $lang['TownMap_desc'],
		"L_TOWNMAP_CHANGE" => $lang['TownMap_map_change'],
		"L_ACTION" => $lang['TownMap_Action'],
		"L_EDIT" => $lang['TownMap_Edit'],
		"L_SUBMIT" => $lang['TownMap_Submit'],
		"U_TOWNMAP_CHANGE" => append_sid("admin_adr_townmap.$phpEx?mode=change&amp;id=" . $alignments['townmap_map']),
		"S_TOWNMAP_ACTION" => append_sid("admin_adr_townmap.$phpEx"))
	);

	$template->pparse("body");
	include('./page_footer_admin.'.$phpEx);
}



?>