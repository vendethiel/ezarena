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
$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.'.$phpEx);

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

$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_id = '$area_id' ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$zone = $db->sql_fetchrow($result);
$zone_name = $zone['zone_name'];
$zone_img = $zone['zone_img'];
$zone_desc = $zone['zone_desc'];
$zone_element = $zone['zone_element'];
$cost_goto1 = $zone['cost_goto1'];
$cost_goto2 = $zone['cost_goto2'];
$cost_goto3 = $zone['cost_goto3'];
$cost_goto4 = $zone['cost_goto4'];
$cost_return = $zone['cost_return'];
$goto1_name = $zone['goto1_name'];
$goto2_name = $zone['goto2_name'];
$goto3_name = $zone['goto3_name'];
$goto4_name = $zone['goto4_name'];
$return_name = $zone['return_name'];
$zone_shops = $zone['zone_shops'];
$zone_forge = $zone['zone_forge'];
$zone_mine = $zone['zone_mine'];
$zone_enchant = $zone['zone_enchant'];
$zone_temple = $zone['zone_temple'];
$zone_prison = $zone['zone_prison'];
$zone_bank = $zone['zone_bank'];
$event_1 = $zone['zone_event1'];
$event_2 = $zone['zone_event2'];
$event_3 = $zone['zone_event3'];
$event_4 = $zone['zone_event4'];
$event_5 = $zone['zone_event5'];
$event_6 = $zone['zone_event6'];
$event_7 = $zone['zone_event7'];
$event_8 = $zone['zone_event8'];
$zone_pointwin1 = $zone['zone_pointwin1'];
$zone_pointwin2 = $zone['zone_pointwin2'];
$zone_pointloss1 = $zone['zone_pointloss1'];
$zone_pointloss2 = $zone['zone_pointloss2'];
$zone_chance = $zone['zone_chance'];


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
$template->assign_var('HAS_MONSTERS', $has_monsters = !empty($zone['zone_monsters_list']));

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
	// Let's assign some switches to
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

//Go To first choice zone
$goto1 = $HTTP_POST_VARS['goto1'];

if ( $goto1 )
{
	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Select the zone destination
	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
      	WHERE zone_name = '$goto1_name' ";
	if( !($result = $db->sql_query($sql)) )
       	 message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone_id = $db->sql_fetchrow($result);
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_goto1 , adr_zones , '' );

		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_area = '$destination_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = '' . $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//Go To second choice zone
$goto2 = $HTTP_POST_VARS['goto2'];

if ( $goto2 )
{
	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Prevent blank destination error
	if ( $goto2_name == '' . $lang['Adr_zone_destination_none'] . '' )
		adr_previous( Adr_zone_change_unavaible , adr_zones , '' );

	//Select the zone destination
	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
      	WHERE zone_name = '$goto2_name' ";
	if( !($result = $db->sql_query($sql)) )
       	 message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone_id = $db->sql_fetchrow($result);
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_goto2 , adr_zones , '' );

		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_area = '$destination_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = '' . $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//Go To third choice zone
$goto3 = $HTTP_POST_VARS['goto3'];

if ( $goto3 )
{
	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Prevent blank destination error
	if ( $goto3_name == '' . $lang['Adr_zone_destination_none'] . '' )
		adr_previous( Adr_zone_change_unavaible , adr_zones , '' );

	//Select the zone destination
	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
      	WHERE zone_name = '$goto3_name' ";
	if( !($result = $db->sql_query($sql)) )
       	 message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone_id = $db->sql_fetchrow($result);
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_goto3 , adr_zones , '' );

		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_area = '$destination_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = '' . $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//Go To fourth choice zone
$goto4 = $HTTP_POST_VARS['goto4'];

if ( $goto4 )
{
	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Prevent blank destination error
	if ( $goto4_name == '' . $lang['Adr_zone_destination_none'] . '' )
		adr_previous( Adr_zone_change_unavaible , adr_zones , '' );

	//Select the zone destination
	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
      	WHERE zone_name = '$goto4_name' ";
	if( !($result = $db->sql_query($sql)) )
       	 message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone_id = $db->sql_fetchrow($result);
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_goto4 , adr_zones , '' );

		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_area = '$destination_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = '' . $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//Return to the previous zone
$return = $HTTP_POST_VARS['return'];

if ( $return )
{
	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Prevent blank destination error
	if ( $return_name == '' . $lang['Adr_zone_destination_none'] )
		adr_previous( Adr_zone_change_unavaible , adr_zones , '' );

	//Select the zone destination
	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
      	WHERE zone_name = '$return_name' ";
	if( !($result = $db->sql_query($sql)) )
       	 message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone_id = $db->sql_fetchrow($result);
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_return , adr_zones , '' );

		//Update character zone
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_area = '$destination_id'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);
	
		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = '' . $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//
// END of Zones Navigation
//

//
// BEGIN of Zones Events
//

//Define if the event happened
$zone_events = rand( 1 , $zone_chance );

if ( $zone_events == '1' )
{
	$what_event = rand( 1 , 8 );

	//Get points
	if ( $what_event == '1' && $event_1 == '1' )
	{
		//Define money value
		$win = rand( $zone_pointwin1 , $zone_pointwin2 );

		adr_add_points( $user_id , $win );

		$message = '<img src="adr/images/zones/get_money.gif"><br \><br \>' . $lang['Adr_zone_event_winpoint'] . ' ' . $win . ' ' . $board_config['points_name'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Loss of points
	else if ( $what_event == '2' && $event_2 == '1' )
	{
		//Define money value
		$loss = rand( $zone_pointloss1 , $zone_pointloss2 );

		if ( $loss > $userdata['user_points'] ) $loss = ( $userdata['user_points'] / 2 );

		adr_substract_points( $user_id , $loss , adr_zones , '' );

		$message = '<img src="adr/images/zones/loss_money.gif"><br \><br \>' . $lang['Adr_zone_event_losspoint'] . ' ' . $loss . ' ' . $board_config['points_name'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Fountain of youth
	else if ( $what_event == '3' && $event_3 == '1' )
	{
		//Update character health
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_hp = character_hp_max
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		$message = '<img src="adr/images/zones/fountain_of_youth.gif"><br \><br \>' . $lang['Adr_zone_event_fountain_youth'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Fountain of mana
	else if ( $what_event == '4' && $event_4 == '1' )
	{
		//Update character mp
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_mp = character_mp_max
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		$message = '<img src="adr/images/zones/fountain_of_mana.gif"><br \><br \>' . $lang['Adr_zone_event_fountain_mana'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Poisonned
	else if ( $what_event == '5' && $event_5 == '1' )
	{
		//Update character hp
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_hp = '1'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		$message = '<img src="adr/images/zones/poisonned.gif"><br \><br \>' . $lang['Adr_zone_event_poison'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Weakness
	else if ( $what_event == '6' && $event_6 == '1' )
	{
		//Update character mp
		$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
			SET character_mp = '0'
			WHERE character_id = '$user_id' ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);

		$message = '<img src="adr/images/zones/weakness.gif"><br \><br \>' . $lang['Adr_zone_event_weakness'] . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Get items
	else if ( $what_event == '7' && $event_7 == '1' )
	{
		// Make the new id for the item
		$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_owner_id = '$user_id'
			ORDER BY 'item_id' DESC 
			LIMIT 1";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);

		$data = $db->sql_fetchrow($result);
		$new_item_id = $data['item_id'] + 1 ;

		//Select zone specific items
		$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . " 
			WHERE item_owner_id = '1'
			AND ( item_zone = '$area_id' || item_zone = '0' )
			ORDER BY rand() LIMIT 1 ";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);

		$new_item				= $db->sql_fetchrow($result);
		$item_type_use 			= $new_item['item_type_use'];
		$item_name 				= trim(rtrim(addslashes(stripslashes($new_item['item_name']))));
		$item_desc 				= trim(rtrim(addslashes(stripslashes($new_item['item_desc']))));
		$item_icon 				= trim(rtrim($new_item['item_icon']));
		$item_price				= $new_item['item_price'];
		$item_quality 			= $new_item['item_quality'];
		$item_duration 			= $new_item['item_duration'];
		$item_duration_max 		= $new_item['item_duration_max'];
		$item_power 			= $new_item['item_power'];
		$item_add_power 			= $new_item['item_add_power'];
		$item_mp_use 			= $new_item['item_mp_use'];
		$item_element 			= $new_item['item_element'];
		$item_element_str_dmg 		= $new_item['item_element_str_dmg'];
		$item_element_same_dmg 		= $new_item['item_element_same_dmg'];
		$item_element_weak_dmg 		= $new_item['item_element_weak_dmg'];
		$item_weight 			= $new_item['item_weight'];
		$item_max_skill 			= $new_item['item_max_skill'];
		$item_sell_back_percentage 	= $new_item['item_sell_back_percentage'];

		if ( $item_duration_max < $item_duration ) $item_duration_max = $item_duration;

		$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . "
			( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_duration_max , item_power , item_add_power , item_mp_use , item_weight , item_auth , item_element , item_element_str_dmg , item_element_same_dmg , item_element_weak_dmg , item_max_skill , item_sell_back_percentage )
			VALUES ( '$new_item_id' , '$user_id' , '$item_type_use' , '$item_name' , '$item_desc' , '" . str_replace("\'", "''", $item_icon) . "' , '$item_price' , '$item_quality' , '$item_duration' , '$item_duration_max' , '$item_power' , '$item_add_power' , '$item_mp_use' , '$item_weight' , '0' , '$item_element' , '$item_element_str_dmg' , '$item_element_same_dmg' , '$item_element_weak_dmg' , '$item_max_skill' , '$item_sell_back_percentage' )";
		$result = $db->sql_query($sql);
		if( !$result )
			message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);

		$message = '<img src="adr/images/zones/get_item.gif"><br \><br \>' . $lang['Adr_zone_event_item'] . '<br \><br \><b>' . $item_name . '</b><br \><br \><img src="adr/images/items/' . $item_icon . '"><br \><br \>' . $item_desc . '<br \><br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}

	//Ambush
	else if ( $what_event == '8' && $event_8 == '1' )
	{
		//Define money value
		$loss = rand( $zone_pointloss1 , $zone_pointloss2 );

		if ( $loss > $userdata['user_points'] ) $loss =  $userdata['user_points'];

		adr_substract_points( $user_id , $loss , adr_zones , '' );

		$message = '<img src="adr/images/zones/ambush.gif"><br \><br \>' . $lang['Adr_zone_event_ambush'] . ' ' . $loss . ' ' . $board_config['points_name'] . '<br \><br \>' . $lang['Adr_zone_event_battle'] . '<br \>' . $lang['Adr_zone_event_return'] . '<br \><br \>';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

//
// END of Zones Events
//

if ( isset($HTTP_GET_VARS['npc']) || isset($HTTP_POST_VARS['npc']) )
	$npc_action = ( isset($HTTP_POST_VARS['npc']) ) ? htmlspecialchars($HTTP_POST_VARS['npc']) : htmlspecialchars($HTTP_GET_VARS['npc']);

$npc_give_action = $HTTP_POST_VARS['npc_give'];
$user_npc_visit_array = explode( ',' , $adr_user['character_npc_visited'] );
$user_npc_quest_array = explode( ';' , $adr_user['character_npc_check'] );

if( isset($npc_action) )
{
	// Deny access if user is imprisioned
	if($userdata['user_cell_time']){
		adr_previous(Adr_zone_no_thief_npc, adr_cell, '');}

	if ( isset($HTTP_GET_VARS['npc_id']) || isset($HTTP_POST_VARS['npc_id']) )
	{
		$npc_id = ( isset($HTTP_POST_VARS['npc_id']) ) ? htmlspecialchars($HTTP_POST_VARS['npc_id']) : htmlspecialchars($HTTP_GET_VARS['npc_id']);
	}
    $adr_user = adr_npc_visit_update( $npc_id, $adr_user );
	$sql = "SELECT * FROM  " . ADR_NPC_TABLE . "
			WHERE npc_id = '$npc_id'
				AND npc_enable = '1'";
	if ( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query npc information', '', __LINE__, __FILE__, $sql);

	//prevent user exploit
	if ( !($npc_row = $db->sql_fetchrow($result)))
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);

	$npc_zone_array = explode( ',' , $npc_row['npc_zone'] );
	$npc_race_array = explode( ',' , $npc_row['npc_race'] );
	$npc_class_array = explode( ',' , $npc_row['npc_class'] );
	$npc_alignment_array = explode( ',' , $npc_row['npc_alignment'] );
	$npc_element_array = explode( ',' , $npc_row['npc_element'] );
	$npc_character_level_array = explode( ',' , $npc_row['npc_character_level'] );
	$npc_visit_array = explode( ',' , $npc_row['npc_visit_prerequisite'] );
	$npc_quest_array = explode( ',' , $npc_row['npc_quest_prerequisite'] );

	$npc_visit = array();
	$npc_quest = array();
	$no_talk_message = array();
	$npc_quest_hide_array = array();
	$x = 0;

	if ( !($npc_row['npc_enable']) )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	if ( !in_array( $area_id , $npc_zone_array ) && $npc_zone_array[0] != '0' )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	if ( !in_array( $adr_user['character_race'] , $npc_race_array ) && $npc_race_array[0] != '0' && !$npc_row['npc_view'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	else if ( !in_array( $adr_user['character_race'] , $npc_race_array ) && $npc_race_array[0] != '0' && $npc_row['npc_view'] )
	{
	    $no_talk_message[$x] = $lang['Adr_Npc_race_no_talk_message'];
	    $x = $x + 1;
	}

	if ( !in_array( $adr_user['character_class'] , $npc_class_array ) && $npc_class_array[0] != '0' && !$npc_row['npc_view'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	else if ( !in_array( $adr_user['character_class'] , $npc_class_array ) && $npc_class_array[0] != '0' && $npc_row['npc_view'] )
	{
	    $no_talk_message[$x] = $lang['Adr_Npc_class_no_talk_message'];
	    $x = $x + 1;
	}

	if ( !in_array( $adr_user['character_alignment'] , $npc_alignment_array ) && $npc_alignment_array[0] != '0' && !$npc_row['npc_view'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	else if ( !in_array( $adr_user['character_alignment'] , $npc_alignment_array ) && $npc_alignment_array[0] != '0' && $npc_row['npc_view'] )
	{
	    $no_talk_message[$x] = $lang['Adr_Npc_alignment_no_talk_message'];
	    $x = $x + 1;
	}

	if ( !in_array( $adr_user['character_element'] , $npc_element_array ) && $npc_element_array[0] != '0' && !$npc_row['npc_view'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	else if( !in_array( $adr_user['character_element'] , $npc_element_array ) && $npc_element_array[0] != '0' && $npc_row['npc_view'] )
	{
	    $no_talk_message[$x] = $lang['Adr_Npc_element_no_talk_message'];
	    $x = $x + 1;
	}
	if ( !in_array( $adr_user['character_level'] , $npc_character_level_array ) && $npc_character_level_array[0] != '0' && !$npc_row['npc_view'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	else if ( !in_array( $adr_user['character_level'] , $npc_character_level_array ) && $npc_character_level_array[0] != '0' && $npc_row['npc_view'] )
	{
	    $no_talk_message[$x] = $lang['Adr_Npc_character_level_no_talk_message'];
	    $x = $x + 1;
	}

	for ( $y = 0 ; $y < count( $user_npc_visit_array ) ; $y++ )
		$npc_visit[$y] = ( in_array( $user_npc_visit_array[$y] , $npc_visit_array ) ) ? '1' : '0';
	
	if ( !in_array( '1' , $npc_visit ) && $npc_visit_array[0] != '0' && !$npc_row['npc_view'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	else if ( !in_array( '1' , $npc_visit ) && $npc_visit_array[0] != '0' && $npc_row['npc_view'] )
	{
	    $no_talk_message[$x] = $lang['Adr_Npc_character_visit_no_talk_message'];
	    $x = $x + 1;
	}
	
	for ( $y = 0 ; $y < count( $user_npc_quest_array ) ; $y++ )
	{
		$npc_quest_id = explode( ':' , $user_npc_quest_array[$y] );
		$npc_quest[$y] = ( in_array( $npc_quest_id[0] , $npc_quest_array ) ) ? '1' : '0';
		$npc_quest_hide_array[$y] = ( $npc_quest_id[0] == $npc_row['npc_id'] ) ? '1' : '0';
	}
	
	if ( !in_array( '1' , $npc_quest ) && $npc_quest_array[0] != '0' && !$npc_row['npc_view'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	else if ( !in_array( '1' , $npc_quest ) && $npc_quest_array[0] != '0' && $npc_row['npc_view'] )
	{
	    $no_talk_message[$x] = $lang['Adr_Npc_character_quest_no_talk_message'];
	}
	
	if 	( in_array( '1' , $npc_quest_hide_array ) && $npc_row['npc_quest_hide'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	$adr_moderators_array = explode( ',' , $board_config['zone_adr_moderators'] );
	if ( $npc_row['npc_user_level'] != '0' && !( ( $npc_row['npc_user_level'] == '1' && $userdata['user_level'] == ADMIN ) || ( $npc_row['npc_user_level'] == '2' && ( in_array( $user_id , $adr_moderators_array ) || $userdata['user_level'] == ADMIN ) ) ) )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	//----

	adr_substract_points( $user_id , $npc_row['npc_price'] , adr_zones , '' );
	if ( count( $no_talk_message ) >= 1 )
	{
		$message_id = rand( 0 , ( count( $no_talk_message ) - 1 ) );
		$message = "<img src=\"adr/images/zones/npc/" . $npc_row['npc_img'] . "\"><br \><br \><b>" . $npc_row['npc_name'] . ":</b> <i>\"" . $no_talk_message[$message_id] . "\"</i><br \><br \>" . $lang['Adr_zone_event_return'];
		$adr_zone_npc_title = sprintf( $lang['Adr_Npc_speaking_with'], $npc_row['npc_name'] );
		message_die(GENERAL_ERROR, $message , $adr_zone_npc_title , '' );
		break;
	}
	else
	{
		if ( adr_item_quest_check($npc_row['npc_id'], $adr_user['character_npc_check'], $npc_row['npc_times'] ) )
		{
			//[QUEST] Check if the NPC needs an item(s)
			if ( $npc_row['npc_item'] != "0" || $npc_row['npc_item'] != "" || $npc_row['npc_quest_clue'] )
			{
				if ( !$npc_row['npc_quest_clue'] )
				{
					$npc_item_array = explode( ',' , $npc_row['npc_item'] );
					$npc_item_list = '';
					$npc_item_id_list = '';
					$required_items = false;
					for ( $i = 0 ; $i < count( $npc_item_array ) ; $i++ )
					{
			 			// Check if user has the item
						$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
					   			WHERE item_name = '" . $npc_item_array[$i] . "'
					   				AND item_owner_id = '$user_id'
		   							AND item_in_shop = '0'
		   							AND item_in_warehouse = '0'
								LIMIT 1 ";
						$result = $db->sql_query($sql);
						if( !$result )
					   		message_die( GENERAL_ERROR , 'Could not obtain required item information' , "" , __LINE__ , __FILE__ , $sql );
						if ( $item_npc = $db->sql_fetchrow($result) )
						{
							if ( ( count( $npc_item_array ) == 1 ) || ( $i == ( count( $npc_item_array ) - 1 ) ) )
							{
								if ( $i == ( count( $npc_item_array ) - 1 ) && $i != 0 )
									$npc_item_list .= ' et ' . adr_get_lang( $npc_item_array[$i] );
								else
									$npc_item_list .= adr_get_lang( $npc_item_array[$i] );
								$npc_item_id_list .= $item_npc['item_id'];
							}
							else
							{
								if ( $i != 0 )
									$npc_item_list .=  ', ';
								$npc_item_list .= adr_get_lang( $npc_item_array[$i] );
								$npc_item_id_list .= $item_npc['item_id'] . ',';
							}
						    $required_items = true;
						}
						else
						{
						    $required_items = false;
						    break;
						}
					}
					############ QUESTBOOK MOD v1.0.2 - START ############
					// Get Quest Info
					$sql = " SELECT * FROM  " . ADR_QUEST_LOG_TABLE . "
						WHERE user_id = '$user_id'
						AND npc_id = '$npc_id'
				   		";
					$result = $db->sql_query($sql);
					if( !$result )
			   		message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql);
					
					if ( $quest_log = $db->sql_fetchrow($result))
					{
						if ( $required_items == true && ($npc_row['npc_kill_monster'] == '0' || $npc_row['npc_kill_monster'] == ""))
						{
							$give_lang = sprintf($lang['Adr_zone_npc_give_item'], $npc_item_list, $npc_row['npc_name']);
							$give = "<br \><br \><form method=\"post\" action=\"".append_sid("adr_zones.$phpEx")."\"><input type=\"hidden\" name=\"npc_id\" value=\"$npc_id\"><input type=\"hidden\" name=\"item_id\" value=\"".$npc_item_id_list."\"><input type=\"submit\" name=\"npc_give\" value=\"$give_lang\" class=\"mainoption\" /></form>";
						}
						elseif ( $required_items == true && $quest_log['quest_kill_monster_amount'] == $quest_log['quest_kill_monster_current_amount'])
						{
							$give_lang = sprintf($lang['Adr_zone_npc_give_item'], $npc_item_list, $npc_row['npc_name']);
							$give = "<br \><br \><form method=\"post\" action=\"".append_sid("adr_zones.$phpEx")."\"><input type=\"hidden\" name=\"npc_id\" value=\"$npc_id\"><input type=\"hidden\" name=\"item_id\" value=\"".$npc_item_id_list."\"><input type=\"submit\" name=\"npc_give\" value=\"$give_lang\" class=\"mainoption\" /></form>";
						}
					}
					############ QUESTBOOK MOD v1.0.2 - END ############
				}
				else
				{
					$give_lang = sprintf($lang['Adr_zone_npc_pay_price'], number_format( intval( $npc_row['npc_quest_clue_price'] ) ) . ' ' . $board_config['points_name'], $npc_row['npc_name']);
					$give = "<br \><br \><form method=\"post\" action=\"".append_sid("adr_zones.$phpEx")."\"><input type=\"hidden\" name=\"npc_id\" value=\"$npc_id\"><input type=\"hidden\" name=\"item_id\" value=\"0\"><input type=\"submit\" name=\"npc_give\" value=\"$give_lang\" class=\"mainoption\" /></form>";
				}
			}

			############ QUESTBOOK MOD v1.0.2 - START ############
			if ( ($npc_row['npc_item'] != "0" && $npc_row['npc_item'] != "") OR ($npc_row['npc_kill_monster'] != "0" && $npc_row['npc_kill_monster'] != "" && $npc_row['npc_kill_monster_amount'] != "0"))
			{
				// Check if the character already has the Quest !
				$sql = " SELECT * FROM  " . ADR_QUEST_LOG_TABLE . "
			   		WHERE (quest_item_need = '".$npc_row['npc_item']."'
					OR quest_kill_monster = '".$npc_row['npc_kill_monster']."')
					AND user_id = '$user_id'
					AND npc_id = '$npc_id'
			   		";
				$result = $db->sql_query($sql);
				if( !$result )
			   		message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql);
				if ( !($quest_log = $db->sql_fetchrow($result)) )
				{
					//Add the quest to the questlog
					$sql = "INSERT INTO " . ADR_QUEST_LOG_TABLE . "
						( user_id, quest_kill_monster , quest_kill_monster_amount , quest_kill_monster_current_amount , quest_item_have, quest_item_need, npc_id )
						VALUES ( '$user_id' , '".$npc_row['npc_kill_monster']."' , '".$npc_row['npc_monster_amount']."' , '0' , '', '". $npc_row['npc_item'] ."' , '". $npc_row['npc_id'] ."' )";
					$result = $db->sql_query($sql);
					if( !$result )
						message_die(GENERAL_ERROR, "Couldn't insert new quest", "", __LINE__, __FILE__, $sql);
				}
			}
			// Check if user has killed enough monsters
			$sqlm3 = " SELECT * FROM  " . ADR_QUEST_LOG_TABLE . "
		   		WHERE quest_kill_monster = '".$npc_row['npc_kill_monster']."'
		   		AND quest_kill_monster_current_amount = '".$npc_row['npc_monster_amount']."'
				AND user_id = '$user_id'
				AND npc_id = '$npc_id'
		   		";
			$resultm3 = $db->sql_query($sqlm3);
			if( !$resultm3 )
		   		message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sqlm3);
			if ( $kills_npc = $db->sql_fetchrow($resultm3) )
			{
				if ($kills_npc['quest_kill_monster'] != "" && $kills_npc['quest_kill_monster'] != '0' && ($kills_npc['quest_item_need'] == '0' || $kills_npc['quest_item_need'] == ""))
				{
					$give_lang = sprintf($lang['Adr_zone_npc_complete_kill_quest'], $npc_row['npc_monster_amount'], adr_get_lang($npc_row['npc_kill_monster']));
					$give = "<br \><br \><form method=\"post\" action=\"".append_sid("adr_zones.$phpEx")."\"><input type=\"hidden\" name=\"npc_id\" value=\"$npc_id\"><input type=\"submit\" name=\"npc_give\" value=\"$give_lang\" class=\"mainoption\" /></form>";
				}
			}
			############ QUESTBOOK MOD v1.0.2 - END ############

			$message = "<img src=\"adr/images/zones/npc/" . $npc_row['npc_img'] . "\"><br \><br \><b>" . $npc_row['npc_name'] . ":</b> <i>\"" . $npc_row['npc_message'] . "\"</i>$give<br \><br \>" . $lang['Adr_zone_event_return'];
			$adr_zone_npc_title = sprintf( $lang['Adr_Npc_speaking_with'], $npc_row['npc_name'] );
			message_die(GENERAL_ERROR, $message , $adr_zone_npc_title , '' );
			break;
		}
		else
		{
			$message = "<img src=\"adr/images/zones/npc/" . $npc_row['npc_img'] . "\"><br \><br \><b>" . $npc_row['npc_name'] . ":</b> <i>\"" . $npc_row['npc_message3'] . "\"</i><br \><br \>" . $lang['Adr_zone_event_return'];
			$adr_zone_npc_title = sprintf( $lang['Adr_Npc_speaking_with'], $npc_row['npc_name'] );
			message_die(GENERAL_ERROR, $message , $adr_zone_npc_title , '' );
			break;
		}
	}
}
else if( isset($npc_give_action) )
{
	$npc_id = intval($HTTP_POST_VARS['npc_id']);
	$item_id_array = explode( ',' , $HTTP_POST_VARS['item_id']);
	$sql = "SELECT * FROM  " . ADR_NPC_TABLE . "
			WHERE npc_id = '$npc_id'
				AND npc_enable = 1 " ;
	if ( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query npc information', '', __LINE__, __FILE__, $sql);

	//prevent user exploit
	if ( !($npc_give_row = $db->sql_fetchrow($result)))
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	if ( !($npc_give_row['npc_enable']) )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);

	$npc_zone_array = explode( ',' , $npc_give_row['npc_zone'] );
	$npc_race_array = explode( ',' , $npc_give_row['npc_race'] );
	$npc_class_array = explode( ',' , $npc_give_row['npc_class'] );
	$npc_alignment_array = explode( ',' , $npc_give_row['npc_alignment'] );
	$npc_element_array = explode( ',' , $npc_give_row['npc_element'] );
	$npc_character_level_array = explode( ',' , $npc_give_row['npc_character_level'] );
	$npc_visit_array = explode( ',' , $npc_give_row['npc_visit_prerequisite'] );
	$npc_quest_array = explode( ',' , $npc_give_row['npc_quest_prerequisite'] );

	$npc_visit = array();
	$npc_quest = array();
	$npc_quest_hide_array = array();
	if ( !in_array( $area_id , $npc_zone_array ) && $npc_zone_array[0] != '0' )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	if ( !in_array( $adr_user['character_race'] , $npc_race_array ) && $npc_race_array[0] != '0' )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	if ( !in_array( $adr_user['character_class'] , $npc_class_array ) && $npc_class_array[0] != '0' )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	if ( !in_array( $adr_user['character_alignment'] , $npc_alignment_array ) && $npc_alignment_array[0] != '0' )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	if ( !in_array( $adr_user['character_element'] , $npc_element_array ) && $npc_element_array[0] != '0' )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	if ( !in_array( $adr_user['character_level'] , $npc_character_level_array ) && $npc_character_level_array[0] != '0' )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	for ( $y = 0 ; $y < count( $user_npc_visit_array ) ; $y++ )
		$npc_visit[$y] = ( in_array( $user_npc_visit_array[$y] , $npc_visit_array ) ) ? '1' : '0';
	if ( !in_array( '1' , $npc_visit ) && $npc_visit_array[0] != '0' && !$npc_give_row['npc_view'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	for ( $y = 0 ; $y < count( $user_npc_quest_array ) ; $y++ )
	{
		$npc_quest_id = explode( ':' , $user_npc_quest_array[$y] );
		$npc_quest[$y] = ( in_array( $npc_quest_id[0] , $npc_quest_array ) ) ? '1' : '0';
		$npc_quest_hide_array[$y] = ( $npc_quest_id[0] == $npc_give_row['npc_id'] ) ? '1' : '0';
	}
	if ( !in_array( '1' , $npc_quest ) && $npc_quest_array[0] != '0' && !$npc_give_row['npc_view'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	if 	( in_array( '1' , $npc_quest_hide_array ) && $npc_give_row['npc_quest_hide'] )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	$adr_moderators_array = explode( ',' , $board_config['zone_adr_moderators'] );
	if ( $npc_give_row['npc_user_level'] != '0' && !( ( $npc_give_row['npc_user_level'] == '1' && $userdata['user_level'] == ADMIN ) || ( $npc_give_row['npc_user_level'] == '2' && ( in_array( $user_id , $adr_moderators_array ) || $userdata['user_level'] == ADMIN ) ) ) )
		adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);

	if ( !$npc_give_row['npc_quest_clue'] )
	{
 		// Check if user has the item(s)
		$npc_item_array = explode( ',' , $npc_give_row['npc_item'] );
		for ( $i = 0 ; $i < count( $npc_item_array ) ; $i++ )
		{
			$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   					WHERE item_id = '" . $item_id_array[$i] ."'
   					    AND item_name = '" . $npc_item_array[$i] . "'
   						AND item_owner_id = '$user_id'
	   					AND item_in_shop = '0'
		   				AND item_in_warehouse = '0'
					LIMIT 1 ";
			if ( !($result = $db->sql_query($sql)) )
    		    message_die(GENERAL_ERROR, 'Could not query shop item information', '', __LINE__, __FILE__, $sql);
	    	$item_npc = $db->sql_fetchrowset($result);
			if ( count($item_npc) == 0 && ($npc_give_row['npc_kill_monster'] == "" or $npc_give_row['npc_kill_monster'] == '0'))
		        adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_1']);
		}
	}
	else
	{
		if ( !$npc_give_row['npc_quest_clue'] )
			adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
	}
	//----

	if ( adr_item_quest_check($npc_give_row['npc_id'], $adr_user['character_npc_check'], $npc_give_row['npc_times'] ) )
	{
		if ( !$npc_give_row['npc_quest_clue'] )
		{
			//Delete item(s) from character inventory
			for ( $i = 0 ; $i < count( $npc_item_array ) ; $i++ )
			{
				$delsql =  "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
							WHERE item_owner_id = '$user_id'
								AND item_id = '" . $item_id_array[$i] . "' ";
				if( !($aresult = $db->sql_query($delsql)) )
					message_die(GENERAL_ERROR, "Couldn't update inventory info", "", __LINE__, __FILE__, $asql);

				############ QUESTBOOK MOD v1.0.2 - START ############
				$sql5 = "SELECT * FROM " . ADR_QUEST_LOG_TABLE . "
					WHERE quest_item_need like '".$npc_item_array[$i].","."%' 
					OR quest_item_need like '".$npc_item_array[$i]."'
					OR quest_item_need like '".$npc_item_array[$i].","."'
					OR quest_item_need like '%".",".$npc_item_array[$i].","."%'
					OR quest_item_need like '%".",".$npc_item_array[$i]."'
					AND user_id = '$user_id'
					";
				$cresult = $db->sql_query($sql5);
				if( !$cresult )
			   		message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql5);
				if ( $got_item_log = $db->sql_fetchrow($cresult) )
					$got_item += 1;
				
				if ($got_item == count( $npc_item_array ) && ($npc_give_row['npc_kill_monster'] == '0' || $npc_give_row['npc_kill_monster'] == ""))
				{
					//Copy Quest to the History
					$insertsql = "INSERT INTO " . ADR_QUEST_LOG_HISTORY_TABLE . "
						( user_id, quest_killed_monster , quest_killed_monsters_amount , npc_id, quest_item_gave)
						VALUES ( '$user_id' , '".$npc_give_row['npc_kill_monster']."' , '".$npc_give_row['npc_monster_amount']."' , '". $npc_give_row['npc_id'] ."', '".$npc_give_row['npc_item']."' )";
					$result = $db->sql_query($insertsql);
					if( !$result )
						message_die(GENERAL_ERROR, "Couldn't insert finished quest", "", __LINE__, __FILE__, $insertsql);

					//Delete the Quest of the log
					$delsql2 = " DELETE FROM  " . ADR_QUEST_LOG_TABLE . "
				   		WHERE user_id = '$user_id'
						AND npc_id = '$npc_id'
				   		";
					if( !($bresult = $db->sql_query($delsql2)) )
						message_die(GENERAL_ERROR, "Couldn't update questlog info", "", __LINE__, __FILE__, $delsql2);
				}
				############ QUESTBOOK MOD v1.0.2 - END ############
			}
			############ QUESTBOOK MOD v1.0.2 - START ############
			if ($npc_give_row['npc_kill_monster'] != '0' && $npc_give_row['npc_kill_monster'] != "" && ($npc_give_row['quest_kill_monster_current_amount'] == $npc_give_row['npc_kill_monster_amount']))
			{
				//Copy Quest to the History
				$insertsql = "INSERT INTO " . ADR_QUEST_LOG_HISTORY_TABLE . "
					( user_id, quest_killed_monster , quest_killed_monsters_amount , npc_id, quest_item_gave)
					VALUES ( '$user_id' , '".$npc_give_row['npc_kill_monster']."' , '".$npc_give_row['npc_monster_amount']."' , '". $npc_give_row['npc_id'] ."', '".$npc_give_row['npc_item']."' )";
				$result = $db->sql_query($insertsql);
				if( !$result )
					message_die(GENERAL_ERROR, "Couldn't insert finished quest", "", __LINE__, __FILE__, $insertsql);
				
				//Delete the Quest of the log
				$delsql3 = " DELETE FROM  " . ADR_QUEST_LOG_TABLE . "
		   			WHERE quest_kill_monster = '".$npc_give_row['npc_kill_monster']."'
		   			AND quest_kill_monster_current_amount = '".$npc_give_row['npc_monster_amount']."'
					AND user_id = '$user_id'
					AND npc_id = '$npc_id'
			   		";
				if( !($dresult = $db->sql_query($delsql3)) )
					message_die(GENERAL_ERROR, "Couldn't update questlog info", "", __LINE__, __FILE__, $delsql3);
			}
			############ QUESTBOOK MOD v1.0.2 - END ############
		}
		else
		############ QUESTBOOK MOD v1.0.2 - START ############
		{
			adr_substract_points( $user_id , $npc_give_row['npc_quest_clue_price'] , adr_zones , '' );
			//Delete the Quest of the log
			$delsql2 = " DELETE FROM  " . ADR_QUEST_LOG_TABLE . "
		   		WHERE user_id = '$user_id'
				AND npc_id = '$npc_id'
		   		";
			if( !($bresult = $db->sql_query($delsql2)) )
				message_die(GENERAL_ERROR, "Couldn't update questlog info", "", __LINE__, __FILE__, $delsql2);
		}
		############ QUESTBOOK MOD v1.0.2 - END ############

		//give points prize
		adr_add_points( $user_id , $npc_give_row['npc_points'] );

		//give exp and sp prize
		$sql = "UPDATE  " . ADR_CHARACTERS_TABLE . "
				SET character_xp = character_xp + '".$npc_give_row['npc_exp']."',
					character_sp = character_sp + '".$npc_give_row['npc_sp']."'
				WHERE character_id = '$user_id' ";
		if ( !($result = $db->sql_query($sql)) )
	        message_die(GENERAL_ERROR, 'Could not update character information', '', __LINE__, __FILE__, $sql);

		$prize_item = '';
		if ( $npc_give_row['npc_item2'] != "0" && $npc_give_row['npc_item2'] != "" )
		{
			$npc_item2_array = explode( ',' , $npc_give_row['npc_item2'] );
			for ( $i = 0 ; $i < count( $npc_item2_array ) ; $i++ )
			{
				// Make the new id for the item
				$sql = "SELECT item_id FROM " . ADR_SHOPS_ITEMS_TABLE . "
						WHERE item_owner_id = '$user_id'
						ORDER BY 'item_id' DESC
						LIMIT 1";
				$result = $db->sql_query($sql);
				if( !$result )
					message_die(GENERAL_ERROR, 'Could not obtain item information', "", __LINE__, __FILE__, $sql);

				$data = $db->sql_fetchrow($result);
				$new_item_id = $data['item_id'] + 1 ;

				//Select NPC specific items
				$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
						WHERE item_owner_id = '1'
							AND item_name = '" . $npc_item2_array[$i] . "' LIMIT 1 ";
				if( !($result = $db->sql_query($sql)) )
					message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);

				$new_item					= $db->sql_fetchrow($result);
				$item_type_use 				= $new_item['item_type_use'];
				$item_name 					= trim(rtrim(addslashes(stripslashes($new_item['item_name']))));
				$item_desc 					= trim(rtrim(addslashes(stripslashes($new_item['item_desc']))));
				$item_icon 					= trim(rtrim($new_item['item_icon']));
				$item_price					= $new_item['item_price'];
				$item_quality 				= $new_item['item_quality'];
				$item_duration 				= $new_item['item_duration'];
				$item_duration_max 			= $new_item['item_duration_max'];
				$item_power 				= $new_item['item_power'];
				$item_add_power 			= $new_item['item_add_power'];
				$item_mp_use 				= $new_item['item_mp_use'];
				$item_element 				= $new_item['item_element'];
				$item_element_str_dmg 		= $new_item['item_element_str_dmg'];
				$item_element_same_dmg 		= $new_item['item_element_same_dmg'];
				$item_element_weak_dmg 		= $new_item['item_element_weak_dmg'];
				$item_weight 				= $new_item['item_weight'];
				$item_max_skill 			= $new_item['item_max_skill'];
				$item_sell_back_percentage 	= $new_item['item_sell_back_percentage'];

				if ( $item_duration_max < $item_duration ) $item_duration_max = $item_duration;

				$sql = "INSERT INTO " . ADR_SHOPS_ITEMS_TABLE . "
						( item_id , item_owner_id , item_type_use , item_name , item_desc , item_icon , item_price , item_quality , item_duration , item_duration_max , item_power , item_add_power , item_mp_use , item_weight , item_auth , item_element , item_element_str_dmg , item_element_same_dmg , item_element_weak_dmg , item_max_skill , item_sell_back_percentage )
						VALUES ( '$new_item_id' , '$user_id' , '$item_type_use' , '$item_name' , '$item_desc' , '" . str_replace("\'", "''", $item_icon) . "' , '$item_price' , '$item_quality' , '$item_duration' , '$item_duration_max' , '$item_power' , '$item_add_power' , '$item_mp_use' , '$item_weight' , '0' , '$item_element' , '$item_element_str_dmg' , '$item_element_same_dmg' , '$item_element_weak_dmg' , '$item_max_skill' , '$item_sell_back_percentage' )";
				$result = $db->sql_query($sql);
				if( !$result )
					message_die(GENERAL_ERROR, "Couldn't insert new item", "", __LINE__, __FILE__, $sql);
				if ( count( $npc_item2_array ) == 1 )
					$prize_item .= adr_get_lang( $npc_item2_array[$i] ) ;
				else
				{
					if ( ( $i >= 1 ) && ( $i == ( count( $npc_item2_array ) + 1 ) ) )
						$prize_item .= ' and ' . adr_get_lang( $npc_item2_array[$i] ) ;
					else
						$prize_item .= ', ' . adr_get_lang( $npc_item2_array[$i] ) ;
				}
			}
			$prize_message = sprintf($lang['Adr_zone_npc_item_prize'], $npc_give_row['npc_name'] , $prize_item ) ;
		}

		//Insert Character in check field
		if( $npc_give_row['npc_times'] > 0 )
			adr_item_quest_check_insert( $adr_user['character_npc_check'] , $npc_give_row['npc_id'] , $user_id );
		//----

		$points_prize_lang = ( $npc_give_row['npc_points'] == 0 ) ? "" : sprintf( $lang['Adr_zone_npc_points_prize'] , number_format( intval( $npc_give_row['npc_points'] ) ) , $board_config['points_name'] ) ;
		$exp_prize_lang = ( $npc_give_row['npc_exp'] == 0 ) ? "" : sprintf( $lang['Adr_zone_npc_exp_prize'] , number_format( intval( $npc_give_row['npc_exp'] ) ) ) ;
		$sp_prize_lang = ( $npc_give_row['npc_sp'] == 0 ) ? "" : sprintf( $lang['Adr_zone_npc_sp_prize'] , number_format( intval( $npc_give_row['npc_sp'] ) ) ) ;
		$item_prize_lang = ( count( $npc_item2_array ) == 0 || $npc_give_row['npc_item2'] == "" ) ? "" : $prize_message;

		$message = "<img src=\"adr/images/zones/npc/" . $npc_give_row['npc_img'] . "\"><br \><br \><b>" . $npc_give_row['npc_name'] . ":</b> <i>\"" . $npc_give_row['npc_message2'] . "\"</i><br \><br \>".$item_prize_lang."".$points_prize_lang."".$exp_prize_lang."".$sp_prize_lang."<br \>" . $lang['Adr_zone_event_return'];
		$adr_zone_npc_title = sprintf( $lang['Adr_Npc_speaking_with'], $npc_row['npc_name'] );
		message_die(GENERAL_ERROR, $message , $adr_zone_npc_title , '' );
		break;
	}
	else
	{
		$message = "<img src=\"adr/images/zones/npc/" . $npc_give_row['npc_img'] . "\"><br \><br \><b>" . $npc_give_row['npc_name'] . ":</b> <i>\"" . $npc_give_row['npc_message2'] . "\"</i><br \><br \>" . $lang['Adr_zone_event_return'];
		$adr_zone_npc_title = sprintf( $lang['Adr_Npc_speaking_with'], $npc_row['npc_name'] );
		message_die(GENERAL_ERROR, $message , $adr_zone_npc_title , '' );
		break;
	}
}

$sql = "SELECT * FROM  " . ADR_NPC_TABLE . "
		WHERE npc_enable = 1 ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$row = $db->sql_fetchrowset($result);

$npc_count1 = 0;
for ( $i = 0 ; $i < count( $row ) ; $i++ )
{
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
// BEGIN of zones seasons and weather
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
$weather = $adr_user['character_weather'];

if ( $weather == '1' ) 
{
	$weather_image = 'sun';
	$weather_name = $lang['Adr_Zone_Weather_1'];
}

if ( $weather == '2' ) 
{
	$weather_image = 'night';
	$weather_name = $lang['Adr_Zone_Weather_2'];
}

if ( $weather == '3' ) 
{
	$weather_image = 'cloud';
	$weather_name = $lang['Adr_Zone_Weather_3'];
}

if ( $weather == '4' ) 
{
	$weather_image = 'rain';
	$weather_name = $lang['Adr_Zone_Weather_4'];
}

if ( $weather == '5' ) 
{
	$weather_image = 'cloudsun';
	$weather_name = $lang['Adr_Zone_Weather_5'];
}

if ( $weather == '6' ) 
{
	$weather_image = 'snow';
	$weather_name = $lang['Adr_Zone_Weather_6'];
}

//
// END of zones seasons and weather
//

//
// BEGIN of characters in zone
//

$sql = " SELECT * FROM  " . ADR_CHARACTERS_TABLE . "
      WHERE character_area = '$area_id'
	ORDER BY character_name ASC";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

while( $row = $db->sql_fetchrow($result)) 
	$users_connected_list.=' <a href="' . append_sid("profile.$phpEx?mode=viewprofile&amp;" . POST_USERS_URL . "=" . $row['character_id']) . '">' . $row['character_name'] . '</a> . ';

if ( !$users_connected_list) $users_connected_list = $lang['None'];

$users_connected_list = '<b><u>'. $lang['Adr_zone_connected']. '</u></b> : ' . $users_connected_list;

//
// END of characters in zone
//

// Building images


( $zone_temple == '1' ) ? $temple = 'temple_enable' : $temple = 'temple_disable';


( $zone_prison == '1' ) ? $prison = 'prison_enable' : $prison = 'prison_disable';


( $zone_shops == '1' ) ? $shops = 'shops_enable' : $shops = 'shops_disable';


( $zone_forge == '1' ) ? $forge = 'forge_enable' : $forge = 'forge_disable';
( $zone_mine == '1' ) ? $mine = 'mine_enable' : $mine = 'mine_disable';
( $zone_enchant == '1' ) ? $enchant = 'enchant_enable' : $enchant = 'enchant_disable';


( $zone_bank == '1' ) ? $bank = 'bank_enable' : $bank = 'bank_disable';





// Building links


( $zone_temple == '1' ) ? $temple_link = '<a href="'.append_sid("adr_temple.$phpEx").'">'. $lang['Adr_zone_goto_temple'] .'</a>' : $temple_link = $lang['Adr_zone_building_disable'];
( $zone_prison == '1' ) ? $prison_link = '<a href="'.append_sid("adr_courthouse.$phpEx").'">'. $lang['Adr_zone_goto_prison'] .'</a>' : $prison_link = $lang['Adr_zone_building_disable'];
( $zone_shops == '1' ) ? $shops_link = '<a href="'.append_sid("adr_shops.$phpEx").'">'. $lang['Adr_zone_goto_shops'] .'</a>' : $shops_link = $lang['Adr_zone_building_disable'];
( $zone_forge == '1' ) ? $forge_link = '<a href="'.append_sid("adr_forge.$phpEx").'">'. $lang['Adr_zone_goto_forge'] .'</a>' : $forge_link = $lang['Adr_zone_building_disable'];
( $zone_mine == '1' ) ? $mine_link = '<a href="'.append_sid("adr_mine.$phpEx").'">'. $lang['Adr_zone_goto_mine'] .'</a>' : $mine_link = $lang['Adr_zone_building_disable'];
( $zone_enchant == '1' ) ? $enchant_link = '<a href="'.append_sid("adr_enchant.$phpEx").'">'. $lang['Adr_zone_goto_enchant'] .'</a>' : $enchant_link = $lang['Adr_zone_building_disable'];
( $zone_bank == '1' ) ? $bank_link = '<a href="'.append_sid("adr_vault.$phpEx").'">'. $lang['Adr_zone_goto_bank'] .'</a>' : $bank_link = $lang['Adr_zone_building_disable'];


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

	'U_SHOUTBOX_BODY' =>  append_sid("adr_battle_community.$phpEx?only_body=1"),
));

$template->pparse('body');

include_once($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>