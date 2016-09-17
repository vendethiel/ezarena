<?php 
/***************************************************************************
 *				adr_Temple.php
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
define('IN_ADR_TEMPLE', true); 
define('IN_ADR_TOWNMAP', true);
define('IN_TOWNMAP_INFOBOX', true);
define('IN_TOWNMAP_TEMPLE', true);
define('IN_TOWNMAP_COPYRIGHT', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_SHOPS', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_temple';

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
	$redirect = "adr_temple.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_temple_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

//
//BEGIN zone Temple Restriction
//
$zone_user = adr_get_user_infos($user_id);
$actual_zone = $zone_user['character_area'];

$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_id = $actual_zone ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$info = $db->sql_fetchrow($result);
$access = $info['zone_temple'];

if ( $access == '0' )
	adr_previous( Adr_zone_building_noaccess , adr_zones , '' );

//
//END zone Temple Restriction
//
// Deny access if the user is into a battle or is imprisoned
adr_battle_cell_check($user_id, $userdata);

// Get the general config
$adr_general = adr_get_general_config();

if ( !$adr_general['Adr_disable_rpg'] && $userdata['user_level'] != ADMIN ) 
{	
	adr_previous ( Adr_disable_rpg , 'index' , '' );
}

// Get the user infos
$adr_char = adr_get_user_infos($user_id);

//get guild info
// V: why??
$sql = "SELECT g.guild_heal_pec, g.guild_id FROM " . ADR_GUILDS_TABLE . " g
  LEFT JOIN " . ADR_GUILD_MEMBER_TABLE . " gm ON ( g.guild_id = gm.guild_member_guild_id )
  WHERE gm.guild_member_user_id = $user_id";
if( !($result = $db->sql_query($sql)) )
{
  message_die(GENERAL_ERROR, 'Could not query guild info', '', __LINE__, __FILE__, $sql);
}
$guild = $db->sql_fetchrow($result);


// Fix the values
$InfoTemple = $HTTP_POST_VARS['InfoTemple'];

if ( $InfoTemple )
{
	adr_previous( Adr_TownMap_Temple_Infos , adr_temple , '' );
}


$heal_price = ceil( $adr_general['temple_heal_cost'] * ( $adr_char['character_hp_max'] - $adr_char['character_hp'] ) );
$resurrect_price = ceil( $adr_general['temple_resurrect_cost'] * ( $adr_char['character_hp_max'] ) );

$heal = $HTTP_POST_VARS['heal'];
$resurrect = $HTTP_POST_VARS['resurrect'];
$donation_amount = $HTTP_POST_VARS['donation_amount'];
$donate = $HTTP_POST_VARS['donation'];

if ( $heal )
{
	if (  $adr_char['character_hp'] < 1 )
	{
		adr_previous( TownMap_Temple_BesoinResurrection , adr_temple , '' );
	}

	if ( ( $adr_char['character_hp'] == $adr_char['character_hp_max'] ) && ( $adr_char['character_mp'] == $adr_char['character_mp_max'] ) )
	{
		adr_previous( TownMap_Temple_PasSoin , adr_temple , '' );
	}

	adr_substract_points( $user_id , $heal_price , adr_temple , '' );

	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_hp = character_hp_max ,
		    character_mp = character_mp_max
		WHERE character_id = $user_id ";
	if ( !($result=$db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR , 'Can not update the user characteristics');
	}
	adr_previous( TownMap_Temple_Soin , adr_temple , '' );
}

else if ( $resurrect )
{
	if (  $adr_char['character_hp'] > 0 )
	{
		adr_previous( TownMap_Temple_PasResurrection , adr_temple , '' );
	}

	adr_substract_points( $user_id , $resurrect_price , adr_temple , '' );

	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_hp = character_hp_max ,
		    character_mp = character_mp_max
		WHERE character_id = $user_id ";
	if ( !($result=$db->sql_query($sql)))
	{
		message_die(GENERAL_ERROR , 'Can not update the user characteristics');
	}
	adr_previous( TownMap_Temple_Resurrection , adr_temple , '' );
}

elseif($donate)
{
	if ($adr_char['character_hp'] < '1') adr_previous(Adr_temple_donation_dead, adr_temple, '');
	if (empty($donation_amount) || !is_numeric($donation_amount)) adr_previous(Adr_temple_donation_none, adr_temple, '');
	if ($userdata['user_points'] < $donation_amount) adr_previous(Adr_temple_donation_not_enough, adr_temple, '');

	// Remove donation from user
	subtract_reward($user_id, $donation_amount);
	
	// Update total donations to temple
	$total_donations = ($adr_general['temple_total_donations'] + $donation_amount);

	$sql= "UPDATE " . ADR_GENERAL_TABLE . " SET config_value = $total_donations WHERE config_name = 'temple_total_donations'";
	if ( !($result = $db->sql_query($sql)) )
	{
		adr_previous( Adr_character_general_update_error, adr_temple , '' );
	}

	$message = '<img src="adr/images/misc/priestess.gif"><br /><br />';
	$message .= sprintf($lang['Adr_temple_donation_successful'], number_format($donation_amount), $board_config['points_name']).'<br />';

	if($donation_amount >= $adr_general['temple_min_donation'])
	{
		$min_chance = round($donation_amount / $adr_general['temple_chance_increase']);
		
		// Min chance cannot be more than 40%
		$min_chance = $min_chance > 40 ? 40: $min_chance;
		$chance = rand($min_chance,100);

		// Work out value for user to reach to win any type of item
		$win_chance = (100 - $adr_general['temple_win_chance']);

		if($chance >= $win_chance)
		{
			$item_rand = rand(1,100);

			if($item_rand > '0' && $item_rand < '65')
			{
				$item_id = adr_temple_donation($user_id, 0, $donation_amount);
				$temple_info = adr_temple_infos($user_id, $item_id);

				$message .= $temple_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$temple_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_temple_donation_won_common'], adr_get_lang($temple_info['item_name']));
			}
			elseif($item_rand > '64' && $item_rand < '94')
			{
				$item_id = adr_temple_donation($user_id, 1, $donation_amount);
				$temple_info = adr_temple_infos($user_id, $item_id);

				$message .= $temple_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$temple_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_temple_donation_won_uncommon'], adr_get_lang($temple_info['item_name']));
			}
			elseif($item_rand > '93' && $item_rand < '100')
			{
				$item_id = adr_temple_donation($user_id, 2, $donation_amount);
				$temple_info = adr_temple_infos($user_id, $item_id);

				$message .= $temple_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$temple_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_temple_donation_won_rare'], adr_get_lang($temple_info['item_name']));
			}
			elseif($item_rand > '95' && $item_rand < '101' && $donation_amount < $adr_general['temple_super_rare_amount'])
			{
				$item_id = adr_temple_donation($user_id, 3, $donation_amount);
				$temple_info = adr_temple_infos($user_id, $item_id);

				$message .= $temple_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$temple_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_temple_donation_won_very_rare'], adr_get_lang($temple_info['item_name']));
			}
			elseif($item_rand > '95' && $item_rand < '101' && $donation_amount >= $adr_general['temple_super_rare_amount'])
			{
				$item_id = adr_temple_donation($user_id, 4, $donation_amount);
				$temple_info = adr_temple_infos($user_id, $item_id);

				$message .= $temple_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$temple_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_temple_donation_won_very_rare'], adr_get_lang($temple_info['item_name']));
			}
		}
	}

	$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>");
	message_die( GENERAL_MESSAGE,$message);

}

else
{
	$template->assign_vars(array(
		'HEAL_COST' => $heal_price,
		'RESURRECT_COST' => $resurrect_price,
		'L_TOWNMAP_TEMPLE' => $lang['TownMap_Temple'],
		'L_TEMPLE_PRIXGUERISON' => $lang['TownMap_Temple_PrixGuerison'],
		'L_TEMPLE_PRIXRESURRECTION' => $lang['TownMap_Temple_PrixResurrection'],
		'L_GUERIR' => $lang['TownMap_Temple_Guerir'],
		'L_RESUSSITER' => $lang['TownMap_Temple_Resussiter'],
		'L_PRETRESSE1' => $lang['TownMap_Temple_NomPretresse1'],
		'L_PRETRESSE2' => $lang['TownMap_Temple_NomPretresse2'],
		'L_TOWNMAP_PRETRESSE1' => $lang['TownMap_Temple_Pretresse1'],
		'L_TOWNMAP_PRETRESSE2' => $lang['TownMap_Temple_Pretresse2'],
		'L_TEMPLEENTREE' => $lang['TownMap_Temple_Entree'],
		'L_TOWNBOUTONINFO' => $lang['Adr_TownMap_Bouton_Infos'],
		'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
		'L_TEMPLEPRESENTATION' => $lang['Adr_TownMap_Temple_Presentation'],
		'L_COPYRIGHT' => $lang['Adr_copyright'],
		'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
		'U_TOWNBOUTONRETOUR' => append_sid("adr_TownMap.$phpEx"),
		'U_TOWNMAP_TEMPLE' => append_sid("adr_temple.$phpEx"),
		'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
		'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
		'L_POINTS' => $board_config['points_name'],
		'L_DONATION_TITLE' 	=> $lang['Adr_temple_donation_title'],
		'L_DONATION'    	=> $lang['Adr_temple_donation_amount'],
		'L_DONATE'	    	=> $lang['Adr_temple_donation_submit'],
		'S_CHARACTER_ACTION' => append_sid("adr_temple.$phpEx"),
	));
}

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 
