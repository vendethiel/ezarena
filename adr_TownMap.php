<?php 
/***************************************************************************
 *					adr_TownMap.php
 *				------------------------
 *	begin 			: 18/11/2004
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
define('IN_TOWNMAP_TEMPLE', true);
define('IN_TOWNMAP_FORGE', true);
define('IN_TOWNMAP_PRISON', true);
define('IN_TOWNMAP_BANQUE', true);
define('IN_TOWNMAP_BOUTIQUE', true);
define('IN_TOWNMAP_ENTRAINEMENT', true);
define('IN_TOWNMAP_ENTREPOT', true);
define('IN_TOWNMAP_COMBAT', true);
define('IN_TOWNMAP_MINE', true);
define('IN_TOWNMAP_ENCHANTEMENT', true);
define('IN_TOWNMAP_CLAN', true);
define('IN_TOWNMAP_MONSTRE', true);
define('IN_TOWNMAP_MAISON', true);
define('IN_TOWNMAP_INFOBOX', true);
define('IN_TOWNMAP_COPYRIGHT', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_TownMap';

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
	$redirect = "adr_TownMap.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header and choice of the season and music

$music_spring = '';
$music_summer = '';
$music_automn = '';
$music_winter = '';

$sql = "select  music_spring, music_summer, music_automn, music_winter from " . phpbb_adr_townmap_music ;
if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, "Could not acces music table.", '', __LINE__, __FILE__, $sql);
if ($alignments = $db->sql_fetchrow($result))
{
	$music_spring = $alignments['music_spring'];
	$music_summer = $alignments['music_summer'];
	$music_automn = $alignments['music_automn'];
	$music_winter = $alignments['music_winter'];
}

$carte = '';

$sql = "select  townmap_map  from " . ADR_TOWNMAPMAP_TABLE ;
if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, "Could not acces TownMapMAP table.", '', __LINE__, __FILE__, $sql);
if ($alignments = $db->sql_fetchrow($result))

{
	$carte = $alignments['townmap_map'];
}

	if ( $carte == '1' ) 
	{
	$saison = 'Carte1';
	$musique = $music_spring;
	}

	if ( $carte == '2' ) 
	{
	$saison = 'Carte2';
	$musique = $music_summer;
	}

	if ( $carte == '3' ) 
	{
	$saison = 'Carte3';
	$musique = $music_automn;
	}

	if ( $carte == '4' ) 
	{
	$saison = 'Carte4';
	$musique = $music_winter;
	}

include($phpbb_root_path . 'includes/page_header.'.$phpEx);
adr_template_file('adr_TownMap_body.tpl');

// Who is looking at this page ?
$user_id = $userdata['user_id'];
if ( (!( isset($HTTP_POST_VARS[POST_USERS_URL]) || isset($HTTP_GET_VARS[POST_USERS_URL]))) || ( empty($HTTP_POST_VARS[POST_USERS_URL]) && empty($HTTP_GET_VARS[POST_USERS_URL])))
{ 
	$view_userdata = $userdata; 
} 
else 
{ 
	$view_userdata = get_userdata(intval($HTTP_GET_VARS[POST_USERS_URL])); 
} 

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

//====================================================================

// Begin Infos

$InfoPrison = $HTTP_POST_VARS['InfoPrison'];

if ( $InfoPrison )
{
	adr_previous( Adr_TownMap_Prison_Infos , adr_TownMap , '' );
}

$InfoBanque = $HTTP_POST_VARS['InfoBanque'];

if ( $InfoBanque )
{
	adr_previous( Adr_TownMap_Banque_Infos , adr_TownMap , '' );
}

$InfoMaison = $HTTP_POST_VARS['InfoMaison'];

if ( $InfoMaison )
{
	adr_previous( Adr_TownMap_Maison_Infos , adr_TownMap , '' );
}

$InfoForge = $HTTP_POST_VARS['InfoForge'];

if ( $InfoForge )
{
	adr_previous( Adr_TownMap_Forge_Infos , adr_TownMap , '' );
}

$InfoTemple = $HTTP_POST_VARS['InfoTemple'];

if ( $InfoTemple )
{
	adr_previous( Adr_TownMap_Temple_Infos , adr_TownMap , '' );
}

$InfoBoutique = $HTTP_POST_VARS['InfoBoutique'];

if ( $InfoBoutique )
{
	adr_previous( Adr_TownMap_Boutique_Infos , adr_TownMap , '' );
}

$InfoEntrainement = $HTTP_POST_VARS['InfoEntrainement'];

if ( $InfoEntrainement )
{
	adr_previous( Adr_TownMap_Entrainement_Infos , adr_TownMap , '' );
}

$InfoEntrepot = $HTTP_POST_VARS['InfoEntrepot'];

if ( $InfoEntrepot )
{
	adr_previous( Adr_TownMap_Entrepot_Infos , adr_TownMap , '' );
}

$InfoCombat = $HTTP_POST_VARS['InfoCombat'];

if ( $InfoCombat )
{
	adr_previous( Adr_TownMap_Combat_Infos , adr_TownMap , '' );
}

$InfoMine = $HTTP_POST_VARS['InfoMine'];

if ( $InfoMine )
{
	adr_previous( Adr_TownMap_Mine_Infos , adr_TownMap , '' );
}

$InfoEnchantement = $HTTP_POST_VARS['InfoEnchantement'];

if ( $InfoEnchantement )
{
	adr_previous( Adr_TownMap_Enchantement_Infos , adr_TownMap , '' );
}

$InfoClan = $HTTP_POST_VARS['InfoClan'];

if ( $InfoClan )
{
	adr_previous( Adr_TownMap_Clan_Infos , adr_TownMap , '' );
}

{
	$template->assign_vars(array(

		'MUSIQUE' => $musique,
		'SAISON' => $saison,
		'L_TOWNMAP' => $lang['Adr_TownMap_name'],
		'L_TOWNMAP_MONSTRE' => $lang['TownMap_Monstre'],
		'L_TOWNMAP_TEMPLE' => $lang['TownMap_Temple'],
		'L_TOWNMAP_FORGE' => $lang['TownMap_Forge'],
		'L_TOWNMAP_PRISON' => $lang['TownMap_Prison'],
		'L_TOWNMAP_BANQUE' => $lang['TownMap_Banque'],
		'L_TOWNMAP_BOUTIQUE' => $lang['TownMap_Boutique'],
		'L_TOWNMAP_MAISON' => $lang['TownMap_Maison'],
		'L_TOWNMAP_ENTRAINEMENT' => $lang['TownMap_Entrainement'],
		'L_TOWNMAP_ENTREPOT' => $lang['TownMap_Entrepot'],
		'L_TOWNMAP_COMBAT' => $lang['TownMap_Combat'],
		'L_TOWNMAP_MINE' => $lang['TownMap_Mine'],
		'L_TOWNMAP_ENCHANTEMENT' => $lang['TownMap_Enchantement'],
		'L_TOWNMAP_CLAN' => $lang['TownMap_Clan'],
		'L_TOWNBOUTONINFO1' => $lang['Adr_TownMap_Bouton_Infos1'],
		'L_TOWNBOUTONINFO2' => $lang['Adr_TownMap_Bouton_Infos2'],
		'L_TOWNBOUTONINFO3' => $lang['Adr_TownMap_Bouton_Infos3'],
		'L_TOWNBOUTONINFO4' => $lang['Adr_TownMap_Bouton_Infos4'],
		'L_TOWNBOUTONINFO5' => $lang['Adr_TownMap_Bouton_Infos5'],
		'L_TOWNBOUTONINFO6' => $lang['Adr_TownMap_Bouton_Infos6'],
		'L_TOWNBOUTONINFO7' => $lang['Adr_TownMap_Bouton_Infos7'],
		'L_TOWNBOUTONINFO8' => $lang['Adr_TownMap_Bouton_Infos8'],
		'L_TOWNBOUTONINFO9' => $lang['Adr_TownMap_Bouton_Infos9'],
		'L_TOWNBOUTONINFO10' => $lang['Adr_TownMap_Bouton_Infos10'],
		'L_TOWNBOUTONINFO11' => $lang['Adr_TownMap_Bouton_Infos11'],
		'L_TOWNBOUTONINFO12' => $lang['Adr_TownMap_Bouton_Infos12'],
		'L_TEMPLEPRESENTATION' => $lang['Adr_TownMap_Temple_Presentation'],
		'L_PRISONPRESENTATION' => $lang['Adr_TownMap_Prison_Presentation'],
		'L_BANQUEPRESENTATION' => $lang['Adr_TownMap_Banque_Presentation'],
		'L_MAISONPRESENTATION' => $lang['Adr_TownMap_Maison_Presentation'],
		'L_FORGEPRESENTATION' => $lang['Adr_TownMap_Forge_Presentation'],
		'L_BOUTIQUEPRESENTATION' => $lang['Adr_TownMap_Boutique_Presentation'],
		'L_ENTRAINEMENTPRESENTATION' => $lang['Adr_TownMap_Entrainement_Presentation'],
		'L_ENTREPOTPRESENTATION' => $lang['Adr_TownMap_Entrepot_Presentation'],
		'L_COMBATPRESENTATION' => $lang['Adr_TownMap_Combat_Presentation'],
		'L_MINEPRESENTATION' => $lang['Adr_TownMap_Mine_Presentation'],
		'L_ENCHANTEMENTPRESENTATION' => $lang['Adr_TownMap_Enchantement_Presentation'],
		'L_CLANPRESENTATION' => $lang['Adr_TownMap_Clan_Presentation'],
		'L_COPYRIGHT' => $lang['TownMap_Copyright'],
		'U_TOWNMAP_TEMPLE' => append_sid("adr_temple.$phpEx"),
		'U_TOWNMAP_FORGE' => append_sid("adr_TownMap_forge.$phpEx"),
		'U_TOWNMAP_PRISON' => append_sid("adr_TownMap_Prison.$phpEx"),
		'U_TOWNMAP_BANQUE' => append_sid("adr_TownMap_Banque.$phpEx"),
		'U_TOWNMAP_BOUTIQUE' => append_sid("adr_TownMap_Boutique.$phpEx"),
		'U_TOWNMAP_MAISON' => append_sid("adr_TownMap_Maison.$phpEx"),
		'U_TOWNMAP_ENTRAINEMENT' => append_sid("adr_TownMap_Entrainement.$phpEx"),
		'U_TOWNMAP_ENTREPOT' => append_sid("adr_TownMap_Entrepot.$phpEx"),
		'U_TOWNMAP_COMBAT' => append_sid("adr_battle.$phpEx"),
		'U_TOWNMAP_MINE' => append_sid("adr_TownMap_mine.$phpEx"),
		'U_TOWNMAP_ENCHANTEMENT' => append_sid("adr_TownMap_pierrerunique.$phpEx"),
		'U_TOWNMAP_CLAN' => append_sid("adr_TownMap_Clan.$phpEx"),
		'U_COPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
		'S_CHARACTER_ACTION' => append_sid("adr_TownMap.$phpEx"),
	));
}

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?> 