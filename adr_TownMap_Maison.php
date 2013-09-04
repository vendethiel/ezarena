<?php 
/***************************************************************************
 *				adr_TownMap_Maison.php
 *				------------------------
 *	begin 			: 21/11/2004
 *	copyright			: One_Piece
 *
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *
 ***************************************************************************/

define('IN_PHPBB', true);  
define('IN_ADR_TOWNMAP', true);
define('IN_TOWNMAP_INFOBOX', true);
define('IN_TOWNMAP_MAISON', true);
define('IN_TOWNMAP_COPYRIGHT', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_QUESTBOOK', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_TownMap_Maison';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

$user_id = $userdata['user_id'];

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_TownMap_Maison.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header and choice of the season
adr_template_file('adr_TownMap_Maison_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

$saison = 'Carte' . $board_config['adr_seasons'];

// Deny access if the user is into a battle
$sql = " SELECT * FROM  " . ADR_BATTLE_LIST_TABLE . " 
	WHERE battle_challenger_id = $user_id
	AND battle_result = 0
	AND battle_type = 1 ";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
}
$bat = $db->sql_fetchrow($result);

if ( is_numeric($bat['battle_id']) )
{
	adr_previous( Adr_battle_progress , adr_battle , '' );
}


// Get the general config
$adr_general = adr_get_general_config();

if ( !$adr_general['Adr_disable_rpg'] && $userdata['user_level'] != ADMIN ) 
{	
	adr_previous ( Adr_disable_rpg , 'index' , '' );
}
// Deny access if user is imprisioned
if($userdata['user_cell_time']){
	adr_previous(Adr_shops_no_thief, adr_cell, '');}
// Get the user infos
$adr_char = adr_get_user_infos($user_id);

// Fix the values

$InfoMaison = $HTTP_POST_VARS['InfoMaison'];

if ( $InfoMaison )
{
	adr_previous( Adr_TownMap_Maison_Infos , adr_TownMap_Maison , '' );
}

else

{
	$template->assign_vars(array(

		'SAISON' => $saison,
		'L_TOWNMAP_MAISON' => $lang['TownMap_Maison'],
		'L_TOWNBOUTONINFO' => $lang['Adr_TownMap_Bouton_Infos'],
		'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
		'L_MAISONPRESENTATION' => $lang['Adr_TownMap_Maison_Presentation'],
		'L_MAISONENTREE' => $lang['TownMap_Maison_Entree'],
		'L_MAISONFEUILLEPERSO' => $lang['TownMap_Maison_FeuillePerso'],
		'L_MAISONINVENTAIRE' => $lang['TownMap_Maison_Inventaire'],
		'L_MAISONCOMPETENCE' => $lang['TownMap_Maison_Competence'],
		'L_MAISONEQUIPEMENT' => $lang['TownMap_Maison_Equipement'],
		'L_MAISONPREFERENCE' => $lang['TownMap_Maison_Preference'],
		'L_MAISONPERSOLISTE' => $lang['TownMap_Maison_PersoListe'],
		'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
		'L_COPYRIGHT' => $lang['Adr_copyright'],
		'U_TOWNBOUTONRETOUR' => append_sid("adr_zones.$phpEx"),
		'U_MAISONFEUILLEPERSO' => append_sid("adr_character.$phpEx"),
		'U_MAISONINVENTAIRE' => append_sid("adr_character_inventory.$phpEx"),
		'U_MAISONCOMPETENCE' => append_sid("adr_character_skills.$phpEx"),
		'U_MAISONEQUIPEMENT' => append_sid("adr_character_equipment.$phpEx"),
		'U_MAISONPREFERENCE' => append_sid("adr_character_prefs.$phpEx"),
		'U_MAISONPERSOLISTE' => append_sid("adr_character_list.$phpEx"),
		'U_TOWNMAP_MAISON' => append_sid("adr_TownMap_Maison.$phpEx"),
		'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
		'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
		'S_CHARACTER_ACTION' => append_sid("adr_TownMap_Maison.$phpEx"),

		// V: let's merge QuestBook
		'U_QUESTBOOK' => append_sid("adr_questbook.$phpEx"),
		'L_QUESTBOOK' => $lang['Adr_questbook_link_townmap'],
	));
}


$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 