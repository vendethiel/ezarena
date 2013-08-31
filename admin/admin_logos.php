<?php
/***************************************************************************
*                            admin_logos.php
* 
* 	Réalisé par Darathor (darathor@free.fr)
* 
****************************************************************************/

define('IN_PHPBB', 1);

//
// First we do the setmodules stuff for the admin cp.
//
if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['General']['Logos'] = $filename;

	return;
}

//
// Load default header
//
if( isset($HTTP_GET_VARS['export_pack']) )
{
	if ( $HTTP_GET_VARS['export_pack'] == "send" )
	{	
		$no_page_header = true;
	}
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);

//
// Check to see what mode we should operate in.
//
if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
}
else
{
	$mode = "";
}

$delimeter  = '=+:';

//
// Select main mode
//
if( isset($HTTP_POST_VARS['add']) || isset($HTTP_GET_VARS['add']) )
{
	//
	// Ajout d'un logo.
	//
	$template->set_filenames(array(
		"body" => "admin/logos_edit_body.tpl")
	);

	$s_hidden_fields = '<input type="hidden" name="mode" value="savenew" />';

	$template->assign_vars(array(
		"L_LOGO_TITLE" => $lang['LoAl_title'],
		"L_LOGO_CONFIG" => $lang['LoAl_config'],
		"L_LOGO_EXPLAIN" => $lang['LoAl_desc'],
		"L_LOGO_ADRESSE" => $lang['LoAl_adresse'],
		"L_LOGO_PROBA" => $lang['LoAl_proba_edit'],
		"L_LOGO_PROBA_EXPLAIN" => $lang['LoAl_proba_explain'],
		"L_SUBMIT" => $lang['Submit'],
		"L_RESET" => $lang['Reset'],

		"S_LOGO_ACTION" => append_sid("admin_logos.$phpEx"), 
		"S_HIDDEN_FIELDS" => $s_hidden_fields)
	);

	$template->pparse("body");
}
else if ( $mode != "" )
{
	$db->clear_cache('logos_');
	switch( $mode )
	{
		case 'delete':
			//
			// Suppression d'un logo.
			//
			$logo_id = ( !empty($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];

			$sql = "DELETE FROM " . LOGOS_TABLE . "
				WHERE logo_id = $logo_id";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete logo", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['LoAl_del_success'] . "<br /><br />" . sprintf($lang['LoAl_click_return_LOGOAdmin'], "<a href=\"" . append_sid("admin_logos.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
			break;

		case 'edit':
			//
			// Editer un logo.
			//
			$logo_id = ( !empty($HTTP_POST_VARS['id']) ) ? $HTTP_POST_VARS['id'] : $HTTP_GET_VARS['id'];
			
			$sql = "SELECT *
				FROM " . LOGOS_TABLE . "
				WHERE logo_id = $logo_id";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, 'Could not obtain logos informations', "", __LINE__, __FILE__, $sql);
			}
			$logo_data = $db->sql_fetchrow($result);

			$template->set_filenames(array(
				"body" => "admin/logos_edit_body.tpl")
			);

			$s_hidden_fields = '<input type="hidden" name="mode" value="save" /><input type="hidden" name="logo_id" value="' . $logo_data['logo_id'] . '" />';

			$template->assign_vars(array(
				"L_LOGO_TITLE" => $lang['LoAl_title'],
				"L_LOGO_CONFIG" => $lang['LoAl_config'],
				"L_LOGO_EXPLAIN" => $lang['LoAl_desc'],
				"L_LOGO_ADRESSE" => $lang['LoAl_adresse'],
				"L_LOGO_PROBA" => $lang['LoAl_proba_edit'],
				"L_LOGO_PROBA_EXPLAIN" => $lang['LoAl_proba_explain'],
				"L_SUBMIT" => $lang['Submit'],
				"L_RESET" => $lang['Reset'],

				"S_LOGO_ACTION" => append_sid("admin_logos.$phpEx"), 
				"S_HIDDEN_FIELDS" => $s_hidden_fields,
				
				"ADRESSE" => $logo_data['adresse'],
				"PROBA" => $logo_data['proba'])
				);

			$template->pparse("body");
			break;

		case "save":
			//
			// L'admin a soumis un logo.
			//

			//
			// Get the submitted data, being careful to ensure that we only
			// accept the data we are looking for.
			//
			$logo_adresse = ( isset($HTTP_POST_VARS['logo_adresse']) ) ? ($HTTP_POST_VARS['logo_adresse']) : ($HTTP_GET_VARS['logo_adresse']);
			$logo_proba = ( isset($HTTP_POST_VARS['logo_proba']) ) ? ($HTTP_POST_VARS['logo_proba']) : ($HTTP_GET_VARS['logo_proba']);
			$logo_id = ( isset($HTTP_POST_VARS['logo_id']) ) ? ($HTTP_POST_VARS['logo_id']) : ($HTTP_GET_VARS['logo_id']);

			// Si aucune adresse n'est donnée : ERREUR
			if ($logo_adresse == '')
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}
			
			//
			// Mettre à jour le site dans la table.
			//
			$sql = "UPDATE " . LOGOS_TABLE . "
				SET adresse = '$logo_adresse', proba = $logo_proba
				WHERE logo_id = $logo_id";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, "Couldn't update logo info", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['LoAl_edit_success'] . "<br /><br />" . sprintf($lang['LoAl_click_return_LOGOAdmin'], "<a href=\"" . append_sid("admin_logos.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
			break;

		case "savenew":
			//
			// L'admin a soumis un nouveau logo.
			//

			//
			// Get the submitted data being careful to ensure the the data
			// we recieve and process is only the data we are looking for.
			//
			$logo_adresse = ( isset($HTTP_POST_VARS['logo_adresse']) ) ? ($HTTP_POST_VARS['logo_adresse']) : ($HTTP_GET_VARS['logo_adresse']);
			$logo_proba = ( isset($HTTP_POST_VARS['logo_proba']) ) ? ($HTTP_POST_VARS['logo_proba']) : ($HTTP_GET_VARS['logo_proba']);
			
			// If no code was entered complain ...
			if ($logo_adresse == '')
			{
				message_die(MESSAGE, $lang['Fields_empty']);
			}

			//
			// Sauver le site dans la table.
			//
			$sql = "INSERT INTO " . LOGOS_TABLE . " (adresse, proba)
				VALUES ('$logo_adresse', $logo_proba)";
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't insert new logo", "", __LINE__, __FILE__, $sql);
			}

			$message = $lang['LoAl_add_success'] . "<br /><br />" . sprintf($lang['LoAl_click_return_LOGOAdmin'], "<a href=\"" . append_sid("admin_logos.$phpEx") . "\">", "</a>") . "<br /><br />" . sprintf($lang['Click_return_admin_index'], "<a href=\"" . append_sid("index.$phpEx?pane=right") . "\">", "</a>");

			message_die(GENERAL_MESSAGE, $message);
			break;
	}
}
else
{
	//
	// Affichage de la liste des logos.
	//
	$sql = "SELECT * FROM " . LOGOS_TABLE . " ORDER BY logo_id";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain logos from database", "", __LINE__, __FILE__, $sql);
	}

	$logos = $db->sql_fetchrowset($result);

	$template->set_filenames(array(
		"body" => "admin/logos_list_body.tpl")
	);
	
	$template->assign_vars(array(
		"L_LOGO_TITLE" => $lang['LoAl_title'],
		"L_LOGO_CONFIG" => $lang['LoAl_config'],
		"L_LOGO_TEXT" => $lang['LoAl_desc'],
		"L_LOGO_IMAGE" => $lang['LoAl_image'],
		"L_LOGO_ADRESSE" => $lang['LoAl_adresse'],
		"L_LOGO_PROBA" => $lang['LoAl_proba'],
		"L_SUBMIT" => $lang['Submit'],
		"L_RESET" => $lang['Reset'],		
		
		"L_ACTION" => $lang['Action'],
		"L_DELETE" => $lang['Delete'],
		"L_EDIT" => $lang['Edit'],
		"L_LOGO_ADD" => $lang['LoAl_add'],
		
		"S_HIDDEN_FIELDS" => $s_hidden_fields, 
		"S_LOGO_ACTION" => append_sid("admin_logos.$phpEx"))
	);

	//
	// Parcourrir les lignes de la table des logos et les assigner au template.
	//
	for($i = 0; $i < count($logos); $i++)
	{
		// Gestion des adresse relatives ou absolues
		$logo_adresse = $logos[$i]['adresse'];
		if(strncmp($logo_adresse, "http://", 7) != 0)
		{
			$logo_adresse = '../' . $logo_adresse;
		}
		
		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
		
		$template->assign_block_vars("logo", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			
			"ADRESSE" => $logo_adresse,
			"PROBA" => $logos[$i]['proba'],
			
			"U_LOGO_EDIT" => append_sid("admin_logos.$phpEx?mode=edit&amp;id=" . $logos[$i]['logo_id']), 
			"U_LOGO_DELETE" => append_sid("admin_logos.$phpEx?mode=delete&amp;id=" . $logos[$i]['logo_id']))
		);
	}

	//
	// Spit out the page.
	//
	$template->pparse("body");
}

//
// Page Footer
//
include('./page_footer_admin.'.$phpEx);

?>
