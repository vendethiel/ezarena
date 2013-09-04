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

/*
 *V:
 * Just a note if you come check what's in here.
 *  ShadowTek's ADR premod (included in ezArena)
 *  DOES NOT USE TOWN ENVIRONMENT. Using townenv would
 *  defeat the purpose of the modifications made.
 *
 * However, it *does* use the graphical modifications
 *  This is why there are no "carteX" folders.
 *  See the old ShadowTek todos from the ADR github issue :
 *   https://github.com/Nami-Doc/ezarena/issues/7#issuecomment-23674076
 *
 * Basically, yes, we could remove those files now, they're not used
 *  and we could probably remove them. However, we could also go the
 *  other way around and integrate them. I have not done this because
 * I think they're more cumbersome with all those added texts
 *  and they keep adding more and more barriers to a fast user experience
 *
 * !!! EDIT !!!
 * So, this got integrated and we know use Town Env with Zone mod \o/
 */

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

$sql = "SELECT music_spring, music_summer, music_automn, music_winter FROM " . ADR_TOWNMAP_MUSIC_TABLE ;
if ( !($result = $db->sql_query($sql)) ) message_die(GENERAL_ERROR, "Could not acces music table.", '', __LINE__, __FILE__, $sql);
if ($alignments = $db->sql_fetchrow($result))
{
	$musics = array(
		$alignments['music_spring'],
		$alignments['music_summer'],
		$alignments['music_automn'],
		$alignments['music_winter'],
	);
}

$saison = 'Carte' . $board_config['adr_seasons'];
$musique = $musics[$board_config['adr_seasons'] - 1];

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
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
// Deny access if user is imprisioned
if($userdata['user_cell_time']){
	adr_previous(Adr_shops_no_thief, adr_cell, '');}

// Get the user infos
$adr_char = adr_get_user_infos($user_id);

//====================================================================

// Begin Infos

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$InfoPrison = $HTTP_POST_VARS['InfoPrison'];

if ( $InfoPrison )
{
	adr_previous( "Adr_TownMap_Prison_Infos" , "adr_zones" , '' );
}

$InfoBanque = $HTTP_POST_VARS['InfoBanque'];

if ( $InfoBanque )
{
	adr_previous( "Adr_TownMap_Banque_Infos" , "adr_zones" , '' );
}

$InfoMaison = $HTTP_POST_VARS['InfoMaison'];

if ( $InfoMaison )
{
	adr_previous( "Adr_TownMap_Maison_Infos" , "adr_zones" , '' );
}

$InfoForge = $HTTP_POST_VARS['InfoForge'];

if ( $InfoForge )
{
	adr_previous( "Adr_TownMap_Forge_Infos" , "adr_zones" , '' );
}

$InfoTemple = $HTTP_POST_VARS['InfoTemple'];

if ( $InfoTemple )
{
	adr_previous( "Adr_TownMap_Temple_Infos" , "adr_zones" , '' );
}

$InfoBoutique = $HTTP_POST_VARS['InfoBoutique'];

if ( $InfoBoutique )
{
	adr_previous( "Adr_TownMap_Boutique_Infos" , "adr_zones" , '' );
}

$InfoEntrainement = $HTTP_POST_VARS['InfoEntrainement'];

if ( $InfoEntrainement )
{
	adr_previous( "Adr_TownMap_Entrainement_Infos" , "adr_zones" , '' );
}

$InfoEntrepot = $HTTP_POST_VARS['InfoEntrepot'];

if ( $InfoEntrepot )
{
	adr_previous( "Adr_TownMap_Entrepot_Infos" , "adr_zones" , '' );
}

$InfoCombat = $HTTP_POST_VARS['InfoCombat'];

if ( $InfoCombat )
{
	adr_previous( "Adr_TownMap_Combat_Infos" , "adr_zones" , '' );
}

$InfoMine = $HTTP_POST_VARS['InfoMine'];

if ( $InfoMine )
{
	adr_previous( "Adr_TownMap_Mine_Infos" , "adr_zones" , '' );
}

$InfoEnchantement = $HTTP_POST_VARS['InfoEnchantement'];

if ( $InfoEnchantement )
{
	adr_previous( "Adr_TownMap_Enchantement_Infos" , "adr_zones" , '' );
}

$InfoClan = $HTTP_POST_VARS['InfoClan'];

if ( $InfoClan )
{
	adr_previous( "Adr_TownMap_Clan_Infos" , "adr_zones" , '' );
}

// V: Disable that french crap ... :p
define('PAGE_DISABLED', true);

if (PAGE_DISABLED && $userdata['user_level'] != ADMIN)
{
	header('location:'.append_sid("adr_zones.$phpEx"));
	exit;
}

$template->assign_vars(array(
	// V: adr_townmap is disabled, show alert message
	'ADMIN_ALERT' => PAGE_DISABLED,

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

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?> 