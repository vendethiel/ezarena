<?php 
/***************************************************************************
 *				adr_lake.php
 *				------------------------
 *	begin 			: 19/11/2004
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
define('IN_ADR_LAKE', true); 
define('IN_ADR_TOWNMAP', true);
define('IN_TOWNMAP_INFOBOX', true);
define('IN_TOWNMAP_LAKE', true);
define('IN_TOWNMAP_COPYRIGHT', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_SHOPS', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_lake';

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
	$redirect = "adr_lake.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_lake_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Deny access if the user is into a battle
$sql = "SELECT * FROM  " . ADR_BATTLE_LIST_TABLE . " 
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

$actual_zone = $adr_char['character_area'];

$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_id = $actual_zone ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$info = $db->sql_fetchrow($result);
$access = $info['zone_lake'];

if ( $access == '0' )
	adr_previous( Adr_zone_building_noaccess , adr_zones , '' );

$InfoLake = $HTTP_POST_VARS['InfoLake'];

if ( $InfoLake )
{
	adr_previous( Adr_TownMap_Lake_Infos , adr_lake , '' );
}


$donation_amount = $HTTP_POST_VARS['donation_amount'];
$donate = $HTTP_POST_VARS['donation'];

if ($donate)
{
	if ($adr_char['character_hp'] < '1') adr_previous(Adr_lake_donation_dead, adr_lake, '');
	if (empty($donation_amount) || !is_numeric($donation_amount)) adr_previous(Adr_lake_donation_none, adr_lake, '');
	if ($userdata['user_points'] < $donation_amount) adr_previous(Adr_lake_donation_not_enough, adr_lake, '');

	// Remove donation from user
	subtract_reward($user_id, $donation_amount);
	
	// Update total donations to lake
	$total_donations = ($adr_general['lake_total_donations'] + $donation_amount);

	$sql= "UPDATE " . ADR_GENERAL_TABLE . " SET config_value = $total_donations WHERE config_name = 'lake_total_donations'";
	if ( !($result = $db->sql_query($sql)) )
	{
		adr_previous( Adr_character_general_update_error, adr_lake , '' );
	}

	$message = '<img src="adr/images/misc/gift02.jpg"><br /><br />';
	$message .= sprintf($lang['Adr_lake_donation_successful'], number_format($donation_amount), $board_config['points_name']).'<br />';

	if($donation_amount >= $adr_general['lake_min_donation'])
	{
		$min_chance = round($donation_amount / $adr_general['lake_chance_increase']);
		
		// Min chance cannot be more than 40%
		$min_chance = $min_chance > 40 ? 40: $min_chance;
		$chance = rand($min_chance,100);

		// Work out value for user to reach to win any type of item
		$win_chance = (100 - $adr_general['lake_win_chance']);

		if($chance >= $win_chance)
		{
			$item_rand = rand(1,100);

			if($item_rand > '0' && $item_rand < '65')
			{
				$item_id = adr_lake_donation($user_id, 0, $donation_amount);
				$lake_info = adr_temple_infos($user_id, $item_id);

				$message .= $lake_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$lake_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_lake_donation_won_common'], adr_get_lang($lake_info['item_name']));
			}
			elseif($item_rand > '64' && $item_rand < '94')
			{
				$item_id = adr_lake_donation($user_id, 1, $donation_amount);
				$lake_info = adr_temple_infos($user_id, $item_id);

				$message .= $lake_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$lake_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_lake_donation_won_uncommon'], adr_get_lang($lake_info['item_name']));
			}
			elseif($item_rand > '93' && $item_rand < '100')
			{
				$item_id = adr_lake_donation($user_id, 2, $donation_amount);
				$lake_info = adr_temple_infos($user_id, $item_id);

				$message .= $lake_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$lake_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_lake_donation_won_rare'], adr_get_lang($lake_info['item_name']));
			}
			elseif($item_rand > '95' && $item_rand < '101' && $donation_amount < $adr_general['lake_super_rare_amount'])
			{
				$item_id = adr_lake_donation($user_id, 3, $donation_amount);
				$lake_info = adr_temple_infos($user_id, $item_id);

				$message .= $lake_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$lake_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_lake_donation_won_very_rare'], adr_get_lang($lake_info['item_name']));
			}
			elseif($item_rand > '95' && $item_rand < '101' && $donation_amount >= $adr_general['lake_super_rare_amount'])
			{
				$item_id = adr_lake_donation($user_id, 4, $donation_amount);
				$lake_info = adr_temple_infos($user_id, $item_id);

				$message .= $lake_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$lake_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_lake_donation_won_very_rare'], adr_get_lang($lake_info['item_name']));
			}
		}
	}

	$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>");
	message_die( GENERAL_MESSAGE,$message);

}

else
{
	$template->assign_vars(array(
		'L_TOWNMAP_LAKE' => $lang['TownMap_Lake'],
		'L_LAKE_PRIXGUERISON' => $lang['TownMap_Lake_PrixGuerison'],
		'L_LAKE_PRIXRESURRECTION' => $lang['TownMap_Lake_PrixResurrection'],
		'L_GUERIR' => $lang['TownMap_Lake_Guerir'],
		'L_RESUSSITER' => $lang['TownMap_Lake_Resussiter'],
		'L_PRETRESSE1' => $lang['TownMap_Lake_NomPretresse1'],
		'L_PRETRESSE2' => $lang['TownMap_Lake_NomPretresse2'],
		'L_TOWNMAP_PRETRESSE1' => $lang['TownMap_Lake_Pretresse1'],
		'L_TOWNMAP_PRETRESSE2' => $lang['TownMap_Lake_Pretresse2'],
		'L_LAKEENTREE' => $lang['TownMap_Lake_Entree'],
		'L_TOWNBOUTONINFO' => $lang['Adr_TownMap_Bouton_Infos'],
		'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
		'L_LAKEPRESENTATION' => $lang['Adr_TownMap_Lake_Presentation'],
		'L_COPYRIGHT' => $lang['Adr_copyright'],
		'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
		'U_TOWNBOUTONRETOUR' => append_sid("adr_TownMap.$phpEx"),
		'U_TOWNMAP_LAKE' => append_sid("adr_lake.$phpEx"),
		'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
		'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
		'L_POINTS' => $board_config['points_name'],
		'L_DONATION_TITLE' 	=> $lang['Adr_lake_donation_title'],
		'L_DONATION'    	=> $lang['Adr_lake_donation_amount'],
		'L_DONATE'	    	=> $lang['Adr_lake_donation_submit'],
		'S_CHARACTER_ACTION' => append_sid("adr_lake.$phpEx"),
	));
}

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 
