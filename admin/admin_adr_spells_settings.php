<?php
/***************************************************************************
*                              admin_adr_spells_settings.php
*                              -------------------
*   begin                : 18/06/08
*   copyright            : 
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
define('IN_ADR_CHARACTER', 1);
define('IN_ADR_SHOPS', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['ADR Spells']['Spell Settings'] = $filename;
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

adr_template_file('admin/config_adr_spells_general_body.tpl');

$sql = "SELECT * FROM  " . ADR_GENERAL_TABLE ;
if (!$result = $db->sql_query($sql))
{
	message_die(GENERAL_MESSAGE, $lang['Adr_character_lack']);
}
while( $row = $db->sql_fetchrow($result) )
{
	$adr_general[$row['config_name']] = $row['config_value'];
}

$submit = isset($_POST['submit']);


if ($submit)
{

	$pm = intval($_POST['pm']);

	// update pm
	$sql= "UPDATE ". ADR_GENERAL_TABLE . " 
		SET config_value = '$pm' 
		WHERE config_name = 'spell_enable_pm' ";
	if ( !($result = $db->sql_query($sql)) ) 
		message_die(GENERAL_ERROR, "Could not update pm.", '', __LINE__, __FILE__, $sql);

	adr_previous( Adr_spells_general_change_successful , admin_adr_spells_settings , '' );
}


$template->assign_vars(array(
	"SPELLS_PM_SEND" => ($adr_general['spell_enable_pm'] == '1' ? 'CHECKED' :'' ),
	"SPELLS_NO_PM_SEND" => ($adr_general['spell_enable_pm'] == '0' ? 'CHECKED' :'' ),
	"L_SPELLS_GENERAL_TITLE" => $lang['Adr_spells_general_title'],
	"L_SPELLS_GENERAL_EXPLAIN" => $lang['Adr_spells_general_explain'],
	"L_SPELLS_PM" => $lang['Adr_spells_pm'],
	"L_SPELLS_PM_EXPLAIN" => $lang['Adr_spells_pm_explain'],
	"L_YES" => $lang['Yes'],
	"L_NO" => $lang['No'],
	"L_SPELLS_SUBMIT" => $lang['Submit'],
	"S_SPELLS_ACTION" => append_sid("admin_adr_spells_settings.$phpEx"))
);

$template->pparse("body");
include_once('./page_footer_admin.'.$phpEx);

?>