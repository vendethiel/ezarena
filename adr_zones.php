<?php
/***************************************************************************
 *					adr_zones.php
 *				------------------------
 *	begin 		: 05/03/2005
 *	copyright		: One_Piece
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
define('IN_ADR_TOWN', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_ZONES', true);
define('IN_ADR_TOWNMAP', true); 
define('IN_ADR_BATTLE', true); 
define('IN_ADR_NPC_ADMIN', true); // V: lang keys and shit

$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.'.$phpEx);

// V: Integrate Town Env
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

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR);
init_userprefs($userdata);
// End session management
//
$user_id = $userdata['user_id'];
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_zones_body.tpl');
include_once($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config and character infos
$adr_general = adr_get_general_config();
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
$adr_user = adr_get_user_infos($user_id);

// Get Zone infos
$area_id = $adr_user['character_area'];

$sql = "SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_id = '$area_id' ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$zone = $db->sql_fetchrow($result);
// V: let's make sure nothing bad happened for some reason
//  i.e. somebody deleted the zone.
//  of course, it's still gonna fail its race's start zone got ERASED
if (!$zone)
{
	$sql = "SELECT race_zone_begin FROM " . ADR_RACES_TABLE . "
		WHERE race_id = " . $adr_user['character_race'];
	$result = $db->sql_query($sql);
	if (!($race = $db->sql_fetchrow($result)))
		message_die(GENERAL_MESSAGE, 'Could not query race data');

	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_area = " . $race['race_zone_begin'];
	$db->sql_query($sql);

	adr_previous('ADR_MOVED_BACK_TO_SAFE_ZONE', 'adr_zones');
}

$zone_name = $zone['zone_name'];
$zone_img = $zone['zone_img'];
$zone_desc = $zone['zone_desc'];
$zone_element = $zone['zone_element'];
$return_name = $zone['return_name'];
$zone_shops = $zone['zone_shops'];
$zone_forge = $zone['zone_forge'];
$zone_mine = $zone['zone_mine'];
$zone_enchant = $zone['zone_enchant'];
$zone_temple = $zone['zone_temple'];
$zone_prison = $zone['zone_prison'];
$zone_bank = $zone['zone_bank'];

// V: let's build actions stuff
$has_actions = false;
$extra_buildings = array(
	'beggar',
	'blacksmith',
	'brewing',
	'cooking',
	'fish',
	'herbal',
	'hunting',
	'jobs',
	'lake',
	'lumberjack',
	'research',
	'tailor',
);
foreach ($extra_buildings as $k) {
	$template->assign_var('ZONE_'.strtoupper($k), $building_enabled = $zone['zone_'.$k]);
	if ($building_enabled) {
		$has_actions = true;
	}
}
$template->assign_var('ZONE_HAS_ACTIONS', $has_actions);

// Begin NSEW Nav
$cost_goto1 = $zone['cost_goto1'];
$cost_goto2 = $zone['cost_goto2'];
$cost_goto3 = $zone['cost_goto3'];
$cost_goto4 = $zone['cost_goto4'];
$goto1_name = $zone['goto1_name'];
$goto2_name = $zone['goto2_name'];
$goto3_name = $zone['goto3_name'];
$goto4_name = $zone['goto4_name'];
$gotoreturn_name = $zone['return_name'];
$cost_return = $zone['cost_return'];

// V: let's check for neighborhood level
$sql = "SELECT zone_name, zone_level FROM " . ADR_ZONES_TABLE . "
	WHERE " . $db->sql_in_set('zone_name', array($goto1_name, $goto2_name, $goto3_name, $goto4_name));
if (!$result = $db->sql_query($sql))
	message_die(GENERAL_ERROR, 'Unable to query neighborhood zones');
$level_goto1 = $level_goto2 = $level_goto3 = $level_goto4 = $level_return = 0;
while ($row = $db->sql_fetchrow($result))
{
	foreach (array(2, 3, 4, 'return') as $i)
	{
		if ($row['zone_name'] == ${'goto'.$i.'_name'})
			${'level_goto'.$i} = $row['zone_level'];
	}
}
$template->assign_vars(array(
	// 'ZONE_LEVEL1' => $level_goto1,
	'ZONE_LEVEL2' => $level_goto2,
	'ZONE_LEVEL3' => $level_goto3,
	'ZONE_LEVEL4' => $level_goto4,
	'ZONE_LEVEL_RETURN' => $level_return,
	'CHARACTER_LEVEL' => $adr_user['character_level'],

	'L_REQ_LEVEL' => $lang['Adr_Npc_acp_npc_character_level'],
));
// End check for neighborhood level

//prevent blank destination
if ( $goto2_name == '' )
{
	$goto2_name = $lang['Adr_zone_destination_none'];
}
else
{
	$template->assign_var('HAS_GOTO_2', true);
}

if ( $goto3_name == '' )
{
	$goto3_name = $lang['Adr_zone_destination_none'];
}
else
{
	$template->assign_var('HAS_GOTO_3', true);
}

if ( $goto4_name == '' )
{
	$goto4_name = $lang['Adr_zone_destination_none'];
}
else
{
	$template->assign_var('HAS_GOTO_4', true);
}

if ( $return_name == '' )
{
	$return_name = $lang['Adr_zone_destination_none'];
}
else
{
	$template->assign_var('HAS_GOTO_RETURN', true);
}

/** V:
 * Let's check for fighting a bit.
 */
// first, let's check if we have any monster ...
$template->assign_var('HAS_MONSTERS', $has_monsters = $zone['zone_monsters_list'] != '');

// then current player's battle
$sql = " SELECT * FROM  " . ADR_BATTLE_LIST_TABLE . " 
   WHERE battle_challenger_id = $user_id 
   AND battle_result = 0 
   AND battle_type = 1 "; 
if( !($result = $db->sql_query($sql)) ) 
{ 
   message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql); 
} 
$in_battle = $db->sql_fetchrow($result); 

// now, let's check for duels. Code ripped off adr_battle_pvp
// ... Duh. I can't understand how this link ever worked, tbh
// since adr_battle_pvp needs a battle ID to work.
// Maybe I should do a duel listing page...
//$template->assign_var('HAS_DUELS', $has_duels = false);

// Global check
//$template->assign_var('CAN_BATTLE', $has_duels || $has_monsters);
// - End fighting stuff check.

/** V:
 * Let's integrate Town Env and Zones Mod together.
 */
$template->assign_vars(array(
	'IN_BATTLE' => $in_battle,
	'CAN_TRAVEL' => !$in_battle && ( $board_config['zone_dead_travel'] == '0' || $adr_user['character_hp'] > 0 ),
	'WORLD_MAP' => $board_config['adr_world_map'],
	// some special links
	'U_SHAME' => append_sid("adr_cheat_log.$phpEx"),
	'U_SHOUTBOX_BODY' => append_sid("adr_battle_community.$phpEx?only_body=1"),
	// Let's assign some switches too
	// show unoccupied ground if not av
	'HAS_SHOPS' => $zone['zone_shops'],
	'HAS_FORGE' => $zone['zone_forge'],
	'HAS_MINE' => $zone['zone_mine'],
	'HAS_ENCHANT' => $zone['zone_enchant'],
	'HAS_TEMPLE' => $zone['zone_temple'],
	'HAS_PRISON' => $zone['zone_prison'],
	'HAS_BANK' => $zone['zone_bank'],
	'SAISON' => 'Carte'.$board_config['adr_seasons'],
	// FROM adr_TownMap.php
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
// END - Enhanced Town Env for Zones Mod

//
// BEGIN of Zones Navigation
//
if ( !empty($_POST['goto2']) && !$in_battle )
{
	zone_goto($goto2_name, $cost_goto2);
}
else if ( !empty($_POST['goto3']) && !$in_battle )
{
	zone_goto($goto3_name, $cost_goto3);
}
else if ( !empty($_POST['goto3']) && !$in_battle )
{
	zone_goto($goto3_name, $cost_goto3);
}
else if ( !empty($_POST['return']) && !$in_battle )
{
	zone_goto($return_name, $cost_return);
}
//
// END of Zones Navigation
//

//
// BEGIN of Zones Events
//

//Define if the event happened
zone_events($zone);
//
// END of Zones Events
//
zone_npc_actions();

$sql = "SELECT * FROM  " . ADR_NPC_TABLE . "
		WHERE npc_enable = 1 ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$row = $db->sql_fetchrowset($result);

$npc_count1 = 0;
for ( $i = 0 ; $i < count( $row ) ; $i++ )
{
	$user_npc_visit_array = explode( ',' , $adr_user['character_npc_visited'] );
	$user_npc_quest_array = explode( ';' , $adr_user['character_npc_check'] );

	$npc_zone_array = explode( ',' , $row[$i]['npc_zone'] );
	$npc_race_array = explode( ',' , $row[$i]['npc_race'] );
	$npc_class_array = explode( ',' , $row[$i]['npc_class'] );
	$npc_alignment_array = explode( ',' , $row[$i]['npc_alignment'] );
	$npc_element_array = explode( ',' , $row[$i]['npc_element'] );
	// V: I believe using a list like that is pretty dumb ...
	// But does it allow for range and more, mmh
	$npc_character_level_array = explode( ',' , $row[$i]['npc_character_level'] );
	$npc_visit_array = explode( ',' , $row[$i]['npc_visit_prerequisite'] );
	$npc_quest_array = explode( ',' , $row[$i]['npc_quest_prerequisite'] );

	$npc_visit = array();
	$npc_quest = array();
	$npc_quest_hide_array = array();
	$npc_zone_check = ( in_array( $area_id , $npc_zone_array ) || $npc_zone_array[0] == '0' ) ? true : false;
	$npc_race_check = ( in_array( $adr_user['character_race'] , $npc_race_array ) || $npc_race_array[0] == '0' || $row[$i]['npc_view'] ) ? true : false;
	$npc_class_check = ( in_array( $adr_user['character_class'] , $npc_class_array ) || $npc_class_array[0] == '0' || $row[$i]['npc_view'] ) ? true : false;
	$npc_alignment_check = ( in_array( $adr_user['character_alignment'] , $npc_alignment_array ) || $npc_alignment_array[0] == '0' || $row[$i]['npc_view'] ) ? true : false;
	$npc_element_check = ( in_array( $adr_user['character_element'] , $npc_element_array ) || $npc_element_array[0] == '0' || $row[$i]['npc_view'] ) ? true : false;
	$npc_character_level_check = ( in_array( $adr_user['character_level'] , $npc_character_level_array ) || $npc_character_level_array[0] == '0' || $row[$i]['npc_view'] ) ? true : false;
	for ( $x = 0 ; $x < count( $user_npc_visit_array ) ; $x++ )
		$npc_visit[$x] = ( in_array( $user_npc_visit_array[$x] , $npc_visit_array ) ) ? '1' : '0';
	$npc_visit_check = ( in_array( '1' , $npc_visit ) || $npc_visit_array[0] == '0' || $row[$i]['npc_view'] ) ? true : false;
	for ( $x = 0 ; $x < count( $user_npc_quest_array ) ; $x++ )
	{
		$npc_quest_id = explode( ':' , $user_npc_quest_array[$x] );
		$npc_quest[$x] = ( in_array( $npc_quest_id[0] , $npc_quest_array ) ) ? '1' : '0';
		$npc_quest_hide_array[$x] = ( $npc_quest_id[0] == $row[$i]['npc_id'] ) ? '1' : '0';
	}
	$npc_quest_check = ( in_array( '1' , $npc_quest ) || $npc_quest_array[0] == '0' || $row[$i]['npc_view'] ) ? true : false;
	$npc_quest_hide_check = ( in_array( '1' , $npc_quest_hide_array ) && $row[$i]['npc_quest_hide'] ) ? false : true;
	$adr_moderators_array = explode( ',' , $board_config['zone_adr_moderators'] );
	if ( $row[$i]['npc_user_level'] == '0' )
	    $npc_user_level_check = true;
	else if  ( $row[$i]['npc_user_level'] == '1' && $userdata['user_level'] == ADMIN )
	    $npc_user_level_check = true;
	else if  ( $row[$i]['npc_user_level'] == '2' && ( in_array( $user_id , $adr_moderators_array ) || $userdata['user_level'] == ADMIN ) )
	    $npc_user_level_check = true;
	else
		$npc_user_level_check = false;

	if ( $npc_zone_check && $npc_race_check && $npc_class_check && $npc_alignment_check && $npc_element_check && $npc_character_level_check && $npc_user_level_check && $npc_visit_check && $npc_quest_check && $npc_quest_hide_check )
	{
		if ( $row[$i]['npc_random'] )
		{
			$npc_display = rand( 1 , $row[$i]['npc_random_chance'] );
			if ( $npc_display == 1 )
			{
				$row1[$npc_count1] = $row[$i];
				$npc_count1++;
			}
		}
		else
		{
			$row1[$npc_count1] = $row[$i];
			$npc_count1++;
		}
	}
}

$npc_count = ( $npc_count1 <= $adr_general['npc_image_count'] ) ? $npc_count1 : $adr_general['npc_image_count'];

if ( $adr_general['npc_display_enable'] && ( $npc_count >= '1' ) )
	$template->assign_block_vars("npc_display_enable" , array());

$a=0;
$r=0;
for ( $i = 0 ; $i < $npc_count1 ; $i++ )
{
	$npc_link = '';
	$hidden_fields = '';
	$npc_input = '';
	$npc_title = '';
	$points_name = $board_config['points_name'];
    $npc_id = $row1[$i]['npc_id'];
    $npc_price = $row1[$i]['npc_price'];
   	$npc_name1 = sprintf( $lang['Adr_zone_npc_link_text'], $row1[$i]['npc_name'], number_format( intval( $npc_price ) ), $points_name );
    $npc_img = $row1[$i]['npc_img'];

	if ( $adr_general['npc_display_text'] )
	{
		// V: better display ...
		if ($npc_price)
		{
			$npc_title = sprintf( $lang['Adr_zone_npc_title_text'], $row1[$i]['npc_name'],
				number_format( intval( $npc_price ) ), $points_name );
		}
		else
		{
			$npc_title = sprintf( $lang['Adr_zone_npc_title_text_simple'], $row1[$i]['npc_name']);
		}
	}
	if ( $adr_general['npc_button_link'] )
	{
		$hidden_fields = "<input type=\"hidden\" name=\"npc_id\" value=\"$npc_id\">";
		$npc_input = "<input type=\"submit\" name=\"npc\" value=\"". $lang['Adr_zone_npc_talk'] ."\" class=\"mainoption\" />";
		$npc_button = '<br /><br />' . $hidden_fields . $npc_input . '<br /><br />';
	}
	if ( !$adr_general['npc_button_link'] && $adr_general['npc_display_text'] )
		$npc_button = '<br /><br />';
	if ( $adr_general['npc_image_link'] || ( !$adr_general['npc_image_link'] && !$adr_general['npc_button_link'] ) )
	{
		$npc_link = '<a href="' . append_sid("adr_zones.$phpEx?npc=". $lang['Adr_zone_npc_talk'] . "&amp;npc_id=" . $npc_id . "") .' "><img src="adr/images/zones/npc/' . $npc_img . '" border="0" height="' . $adr_general['npc_image_size'] . 'px" alt="' . $npc_name1 . '" title="' . $npc_name1 . '" ></a>';
	}
	else
	{
		$npc_link = '<img src="adr/images/zones/npc/' . $npc_img . '" border="0" height="' . $adr_general['npc_image_size'] . 'px" alt="' . $npc_name1 . '" title="' . $npc_name1 . '" >';
	}

	if ($a==0)
	{
	    $tr1 = "<tr align=\"center\">";
    	$r++;
	}
	else
    	$tr1 = "";

    if  ($r % 2)
	    $row_class = ( !($a % 2) ) ? $theme['td_class1'] : $theme['td_class2'];
	else
	    $row_class = ( !($a % 2) ) ? $theme['td_class2'] : $theme['td_class1'];
	$a++;

	if ($a==$npc_count ) {
		$tr2 = "</tr>";
		$a=0;
	}
	else
		$tr2 = "";

	if ( $adr_general['npc_display_enable'] )
	{
		$template->assign_block_vars("npc_display_enable.npc", array(
			"ROW_CLASS" => $row_class,
			"VAL_A" => $a,
			"TR_INIT" => $tr1,
			"TR_END" => $tr2,
			"NPC_TITLE" => $npc_title,
			"NPC_BUTTON" => $npc_button,
			"NPC_LINK" => $npc_link,
			"NPC_IMG" => $npc_img,
			"NPC_PRICE" => $npc_price,
			"POINTS_NAME" => $board_config['points_name'],
			"NPC_INPUT" => $npc_input,
			"HIDDEN_FIELDS" => $hidden_fields,
		));
	}
}
if($a!=0)
{
	for(;$a<$npc_count;$a++)
	{
	    $row_class = ( $row_class == $theme['td_class1'] ) ? $theme['td_class2'] : $theme['td_class1'];
	    $tr2 = ( $a == ( $npc_count ) ) ? "</tr>" : "" ;
		if ( $adr_general['npc_display_enable'] )
		{
			$template->assign_block_vars("npc_display_enable.npc_end", array(
				"ROW_CLASS" => $row_class,
				"TR_END" => $tr2,
			));
		}
	}
}

//
// BEGIN of zones seasons and weather and time
//

//Begin seasons
$actual_season = $board_config['adr_seasons'];

if ( $actual_season == '1' ) 
{
	$season_image = 'spring';
	$season_name = $lang['Adr_Zone_Season_1'];
}

if ( $actual_season == '2' ) 
{
	$season_image = 'summer';
	$season_name = $lang['Adr_Zone_Season_2'];
}

if ( $actual_season == '3' ) 
{
	$season_image = 'automn';
	$season_name = $lang['Adr_Zone_Season_3'];
}

if ( $actual_season == '4' ) 
{
	$season_image = 'winter';
	$season_name = $lang['Adr_Zone_Season_4'];
}

//Begin weather
// V: better that way
$weather = $adr_user['character_weather'];
$weathers = array('sun', 'night', 'cloud', 'rain', 'cloudsun', 'snow');
$weather_image = $weathers[$weather-1];
$weather_name = $lang['Adr_Zone_Weather_'.$weather];

//Begin time
$actual_time = $board_config['adr_time'];
if ( $actual_time == '1' )
{
	$time_image = 'dawn';
	$time_name = $lang['Adr_Zone_Time_1'];
}
if ( $actual_time == '2' )
{
	$time_image = 'day';
	$time_name = $lang['Adr_Zone_Time_2'];
}
if ( $actual_time == '3' )
{
	$time_image = 'dusk';
	$time_name = $lang['Adr_Zone_Time_3'];
}
if ( $actual_time == '4' )
{
	$time_image = 'night';
	$time_name = $lang['Adr_Zone_Time_4'];
}


//
// END of zones seasons and weather and time
//

//
// BEGIN of characters in zone
//

$sql = " SELECT * FROM  " . ADR_CHARACTERS_TABLE . "
      WHERE character_area = '$area_id'
	ORDER BY character_name ASC";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$users_connected_list = '';
while( $row = $db->sql_fetchrow($result)) 
	$users_connected_list.=' <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['character_id']) . '">' . $row['character_name'] . '</a> . ';

if ( !$users_connected_list) $users_connected_list = $lang['None'];

$users_connected_list = '<b><u>'. $lang['Adr_zone_connected']. '</u></b> : ' . $users_connected_list;

//
// END of characters in zone
//

// Dynamic Zone Maps
$sql = "select * from ".ADR_ZONE_MAPS_TABLE." where zone_id=$area_id";
if ( !($result = $db->sql_query($sql)) ) {
	message_die(GENERAL_ERROR, 'Could not query Zone Maps Table' );
}
$uhrow = mysql_fetch_array($result);
if ( $uhrow['zonemap_type'] == '' || !$board_config['Adr_zone_townmap_enable'] )
{
	$template->assign_block_vars('switch_Adr_zone_townmap_disable',array());
}
else
{
	$template->assign_block_vars('switch_Adr_zone_townmap_enable',array());
}

if ( $board_config['Adr_zone_townmap_enable'] && $uhrow['zonemap_type'] > 0 )
{
	$sql = "select * from ".ADR_ZONE_TOWNMAP_TABLE." where zonemap_type=$uhrow[zonemap_type]";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_ERROR, 'Unable to query townmap table' ); }
	$zrow = mysql_fetch_array($result);

	$townmap = $zrow['zonemap_bg'];
	$zwidth = $zrow['zonemap_width'];
	$zcellsh = $zrow['zonemap_cellwidth'];
	$zcellshn = $zrow['zonemap_cellwidthnumber'];
	$zheight = $zrow['zonemap_height'];
	$zcellsv = $zrow['zonemap_cellheight'];
	$zcellsvn = $zrow['zonemap_cellheightnumber'];

	$buildingarray = explode('~',$uhrow['zonemap_buildings']);
	$buildingamount = count ($buildingarray);

	$browcount = count ($brow);
	// some pixies fly by and get our furniture organised
	// V: let's make a better code ...
	$sql = "SELECT * FROM " . ADR_ZONE_BUILDINGS_TABLE;
	if ( !($result = $db->sql_query($sql, false, 'zone_building')) ) {
		message_die(GENERAL_ERROR, 'Unable to query zone buildings');
	}
	$adr_buildings = array();
	while ($brow = $db->sql_fetchrow($result)){
		$adr_buildings[$brow['sdesc']] = $brow;
	}
	$db->sql_freeresult($result);

	$ia = 0;
	for ($iv = 1; $iv <= $zcellsvn; $iv++)
	{
		for ($ih = 1; $ih <= $zcellshn; $ih++)
		{
			if ($buildingarray[$ia] != '')
			{
				$brow = $adr_buildings[$buildingarray[$ia]];
				$buildinglist2[$iv][$ih] = $brow['name'];
				// V: go for it
				//if (true || $brow['zone_name_tag'] =='' )
				$desc = isset($lang['Adr_building_'.$irow['sdesc']]) ? $lang['Adr_building_'.$irow['sdesc']] : ucfirst($irow['sdesc']);
	   			$building_name_tag1[$iv][$ih] = 'alt="' . $desc . '" ';
	   			$building_name_tag2[$iv][$ih] = 'name="' . $desc . '" ';
	   			//}

				if ( $brow['zone_link'] == '' )
				{
					$building_link[$iv][$ih] = '';
				}
				else
				{
					$linkarray = explode('/',$brow['zone_link']);
					$linkarraycount = count ($linkarray);
					if ( $linkarraycount == 1 )
					{
						$link = $brow['zone_link'];
						$defined_link = append_sid("$link.$phpEx");
					}
					else if ( $linkarraycount == 2 )
					{
						$link1 = $linkarray[0];
						$link2 = $linkarray[1];
						$link = $link1 . '.' . $phpEx . $link2;
						$defined_link = append_sid("$link");
					}
					$building_link[$iv][$ih] = '<a href="'.$defined_link.'">';
				}
				if ( $brow['zone_building_tag_no'] == 999  )
				{
					$building_tag_no[$iv][$ih] = '';
				}
				else
				{
					$building_tag_no[$iv][$ih] = 'onMouseOver="stm(Text['.$brow['zone_building_tag_no'].'],Style[0])" onMouseOut="htm()"';
				}
			}
			else
			{
				$buildinglist2[$iv][$ih] = 'empty';
	   			$building_name_tag1[$iv][$ih] = 'alt="" ';
	   			$building_name_tag2[$iv][$ih] = 'name="" ';
	            $building_tag_no[$iv][$ih] = '';
	            $building_link[$iv][$ih] = '';
			}
			$ia++;
		}
	}

	// lets get some gnomes to build the house

	$showmap = '
	<tr>
		<td class="row1" align="center" valign="center">
	<table background="./adr/images/zones/townmap/'.$actual_season.'/'.$townmap.'" width="'.$zwidth.'px" height="'.$zheight.'px" cellpadding=0 cellspacing=0 marginwidth=0 marginheight=0 topmargin=0 leftmargin=0 border=0>';

	for ($sv = 1; $sv <= $zcellsvn; $sv++)
	{
		$showmap .= '<tr>';
		for ($sh = 1; $sh <= $zcellshn; $sh++)
		{
			$showmap .= '
			<td width="'.$zcellsh.'px" height="'.$zcellsv.'px">'.$building_link[$sv][$sh].'<img src="./adr/images/zones/townmap/buildings/'.$buildinglist2[$sv][$sh].'.gif" width="'.$zcellsh.'px" height="'.$zcellsv.'px" border="0" '.$building_name_tag1[$sv][$sh].' '.$building_name_tag2[$sv][$sh].''.$building_tag_no[$sv][$sh].'></td>';
		}
		$showmap .= '</tr>';
	}

	$showmap .= '
	</table>';
}
// End dynamic zone maps

// Building images


( $zone_temple == '1' ) ? $temple = 'temple_enable' : $temple = 'temple_disable';
( $zone_prison == '1' ) ? $prison = 'prison_enable' : $prison = 'prison_disable';
( $zone_shops == '1' ) ? $shops = 'shops_enable' : $shops = 'shops_disable';
( $zone_forge == '1' ) ? $forge = 'forge_enable' : $forge = 'forge_disable';
( $zone_mine == '1' ) ? $mine = 'mine_enable' : $mine = 'mine_disable';
( $zone_enchant == '1' ) ? $enchant = 'enchant_enable' : $enchant = 'enchant_disable';
( $zone_bank == '1' ) ? $bank = 'bank_enable' : $bank = 'bank_disable';

// Building links

// V: integrate enchant&mine everywhere
if ( $board_config['Adr_zone_picture_link'] )
{
	$picture_link = 1;
	$temple_link = ( $zone_temple == '1' ) ? '<a href="'.append_sid("adr_temple.$phpEx").'">' : '';
	$prison_link = ( $zone_prison == '1' ) ? '<a href="'.append_sid("adr_courthouse.$phpEx").'">' : '';
	$shops_link = ( $zone_shops == '1' ) ? '<a href="'.append_sid("adr_shops.$phpEx").'">' : '';
	$forge_link = ( $zone_forge == '1' ) ? '<a href="'.append_sid("adr_forge.$phpEx").'">' : '';
	$bank_link = ( $zone_bank == '1' ) ? '<a href="'.append_sid("adr_vault.$phpEx").'">' : '';
	$enchant_link = ( $zone_enchant == '1' ) ? '<a href="'.append_sid("adr_enchant.$phpEx").'">' : '';
	$mine_link = ( $zone_mine == '1' ) ? '<a href="'.append_sid("adr_mine.$phpEx").'">' : '';
}
else
{
	$picture_link = 0;
	$temple_link = ( $zone_temple == '1' ) ? '<a href="'.append_sid("adr_temple.$phpEx").'">'. $lang['Adr_zone_goto_temple'] .'</a>' : $lang['Adr_zone_building_disable'];
	$prison_link = ( $zone_prison == '1' ) ? '<a href="'.append_sid("adr_courthouse.$phpEx").'">'. $lang['Adr_zone_goto_prison'] .'</a>' : $lang['Adr_zone_building_disable'];
	$shops_link = ( $zone_shops == '1' ) ? '<a href="'.append_sid("adr_shops.$phpEx").'">'. $lang['Adr_zone_goto_shops'] .'</a>' : $lang['Adr_zone_building_disable'];
	$forge_link = ( $zone_forge == '1' ) ? '<a href="'.append_sid("adr_forge.$phpEx").'">'. $lang['Adr_zone_goto_forge'] .'</a>' : $lang['Adr_zone_building_disable'];
	$bank_link = ( $zone_bank == '1' ) ? '<a href="'.append_sid("adr_vault.$phpEx").'">'. $lang['Adr_zone_goto_bank'] .'</a>' : $lang['Adr_zone_building_disable'];
	$enchant_link = ( $zone_enchant == '1' ) ? '<a href="'.append_sid("adr_enchant.$phpEx").'">'. $lang['Adr_zone_goto_enchant'] .'</a>' : $lang['Adr_zone_building_disable'];
	$mine_link = ( $zone_mine == '1' ) ? '<a href="'.append_sid("adr_mine.$phpEx").'">'. $lang['Adr_zone_goto_mine'] .'</a>' : $lang['Adr_zone_building_disable'];
}
if ( ( $zone_temple == '1' || $zone_prison == '1' || $zone_shops == '1' || $zone_forge == '1' || $zone_bank =='1' || $zone_enchant == '1' || $zone_mine = '1' ) && $picture_link )
{
	$template->assign_block_vars('switch_header_picture_link_enable',array());
}
else if ( ( $zone_temple == '1' || $zone_prison == '1' || $zone_shops == '1' || $zone_forge == '1' || $zone_bank =='1' || $zone_enchant == '1' || $zone_mine = '1' ) && !$picture_link )
{
	$template->assign_block_vars('switch_header_no_picture_link_enable',array());
}

// Define user money
$points = $userdata['user_points'] . ' ' . $board_config['points_name'];

$template->assign_vars(array(
	'LANG' => $board_config['default_lang'],
	'POINTS' => $points,
	'ZONE_NAME' => $zone_name,
	'ZONE_IMG' => $zone_img,
	'ZONE_DESCRIPTION' => $zone_desc,
	'NPC_SPAN' => $npc_count,
	'NPC_WIDTH' => ($npc_count != 0 ) ? ( 100 / $npc_count ) : '',
	'ZONE_ELEMENT' => $zone_element,
	'ZONE_SEASON' => $actual_season,
	'ZONE_SEASON_NAME' => $season_name,
	'ZONE_SEASON_IMG' => $season_image,
	'ZONE_WEATHER_NAME' => $weather_name,
	'ZONE_WEATHER_IMG' => $weather_image,
	'ZONE_TIME' => $actual_time,
	'ZONE_TIME_NAME' => $time_name,
	'ZONE_TIME_IMG' => $time_image,
	'ZONE_GOTO1' => $goto1_name,
	'ZONE_COST1' => $cost_goto1,
	'ZONE_GOTO2' => $goto2_name,
	'ZONE_COST2' => $cost_goto2,
	'ZONE_GOTO3' => $goto3_name,
	'ZONE_COST3' => $cost_goto3,
	'ZONE_GOTO4' => $goto4_name,
	'ZONE_COST4' => $cost_goto4,
	'ZONE_RETURN' => $return_name,
	'ZONE_COST_RETURN' => $cost_return,
	'USERS_CONNECTED_LIST' => $users_connected_list,
	'SHOPS_IMG' => $shops,
	'TEMPLE_IMG' => $temple,
	'FORGE_IMG' => $forge,
	'MINE_IMG' => $mine,
	'ENCHANT_IMG' => $enchant,
	'BANK_IMG' => $bank,
	'PRISON_IMG' => $prison,
	'SHOPS_LINK' => $shops_link,
	'TEMPLE_LINK' => $temple_link,
	'FORGE_LINK' => $forge_link,
	'MINE_LINK' => $mine_link,
	'ENCHANT_LINK' => $enchant_link,
	'BANK_LINK' => $bank_link,
	'PRISON_LINK' => $prison_link,
	'SHOWMAP' => isset($showmap) ? $showmap : '',
	'MAP_NAME' => isset($map_name) ? $map_name : '',
	'L_TEMPLE_NAME' => $lang['Adr_zone_goto_temple'],
	'L_FORGE_NAME' => $lang['Adr_zone_goto_forge'],
	'L_MINE_NAME' => $lang['Adr_zone_goto_mine'],
	'L_ENCHANT_NAME' => $lang['Adr_zone_goto_enchant'],
	'L_SHOPS_NAME' => $lang['Adr_zone_goto_shops'],
	'L_PRISON_NAME' => $lang['Adr_zone_goto_prison'],
	'L_BANK_NAME' => $lang['Adr_zone_goto_bank'],
	'L_ZONE_NPC' => $lang['Adr_zone_npc_title'],
	'L_ZONE_BUILDINGS' => $lang['Adr_zone_buildings_title'],
	'L_ZONE_ACTION' => $lang['Adr_zone_action_title'],
	'L_ZONE_CONNECTED' => $lang['Adr_zone_connected_title'],
	'L_ZONE_DESCRIPTION' => $lang['Adr_zone_description_title'],
	'L_ZONE_ELEMENT' => $lang['Adr_zone_element_title'],
	'L_ZONE_SEASON' => $lang['Adr_zone_season_title'],
	'L_ZONE_TIME' => $lang['Adr_zone_time_title'],
	'L_ZONE_WEATHER' => $lang['Adr_zone_weather_title'],
	'L_ZONE_GOTO' => $lang['Adr_zone_goto_title'],
	'L_ZONE_GOTO1' => $lang['Adr_zone_goto1_title'],
	'L_ZONE_GOTO2' => $lang['Adr_zone_goto2_title'],
	'L_ZONE_GOTO3' => $lang['Adr_zone_goto3_title'],
	'L_ZONE_GOTO4' => $lang['Adr_zone_goto4_title'],
	'L_ZONE_RETURN' => $lang['Adr_zone_return_title'],
	'L_ZONE_COST' => $lang['Adr_zone_cost_title'],
	'L_ZONE_TOWN' => $lang['Adr_zone_town_title'],
	'L_ZONE_BATTLE' => $lang['Adr_zone_battle_title'],
	'L_ZONE_SHOUTBOX' => $lang['Adr_zone_other_title'],
	'L_BATTLE' => $lang['Adr_zone_battle'],
	'L_PVP_BATTLE' => $lang['Adr_zone_pvp_battle'],
	'L_GOTO' => $lang['Adr_zone_goto'],
	'L_POINTS' => $lang['Adr_zone_points'],
	'U_ZONE_GUILD' => append_sid("adr_guilds.$phpEx"),
	'U_ZONE_ANIMALERY' => append_sid("rabbitoshi.$phpEx"),
	'U_ZONE_AUTEL' => append_sid("adr_cauldron.$phpEx"),
	'U_ZONE_BARRACK' => append_sid("adr_town.$phpEx"),
	'U_ZONE_WORKSHOP' => append_sid("adr_jobs.$phpEx"),
	'U_ZONE_HOUSE' => append_sid("adr_house.$phpEx"),
	'U_ZONE_LIBRARY' => append_sid("adr_library.$phpEx"),
	'U_ZONE_TOWER' => append_sid("adr_tower.$phpEx"),
	'U_ZONE_BATTLE' => append_sid("adr_battle.$phpEx"),
	'U_ZONE_PVP_BATTLE' => append_sid("adr_battle_pvp.$phpEx"),
	'S_ZONES_ACTION' => append_sid("adr_zones.$phpEx"),
));

$template->pparse('body');

include_once($phpbb_root_path . 'includes/page_tail.'.$phpEx);
