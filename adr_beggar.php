<?php 
/***************************************************************************
 *				adr_beggar.php
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
define('IN_ADR_BEGGAR', true);
define('IN_ADR_TEMPLE', true); 
define('IN_ADR_TOWNMAP', true);
define('IN_TOWNMAP_INFOBOX', true);
define('IN_TOWNMAP_BEGGAR', true);
define('IN_TOWNMAP_COPYRIGHT', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_SHOPS', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_beggar';

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
	$redirect = "adr_beggar.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_beggar_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

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


$InfoBeggar = $HTTP_POST_VARS['InfoBeggar'];

if ( $InfoBeggar )
{
	adr_previous( Adr_TownMap_Beggar_Infos , adr_beggar , '' );
}


$donation_amount = $HTTP_POST_VARS['donation_amount'];
$donate = $HTTP_POST_VARS['donation'];

if ($donate)
{
	if ($adr_char['character_hp'] < '1') adr_previous(Adr_beggar_donation_dead, adr_beggar, '');
	if (empty($donation_amount) || !is_numeric($donation_amount)) adr_previous(Adr_beggar_donation_none, adr_beggar, '');
	if ($userdata['user_points'] < $donation_amount) adr_previous(Adr_beggar_donation_not_enough, adr_beggar, '');

	// Remove donation from user
	subtract_reward($user_id, $donation_amount);
	
	// Update total donations to beggar
	$total_donations = ($adr_general['beggar_total_donations'] + $donation_amount);

	$sql= "UPDATE " . ADR_GENERAL_TABLE . " SET config_value = $total_donations WHERE config_name = 'beggar_total_donations'";
	if ( !($result = $db->sql_query($sql)) )
	{
		adr_previous( Adr_character_general_update_error, adr_beggar , '' );
	}

	$message = '<img src="adr/images/misc/gift01.jpg"><br /><br />';
	$message .= sprintf($lang['Adr_beggar_donation_successful'], number_format($donation_amount), $board_config['points_name']).'<br />';

	if($donation_amount >= $adr_general['beggar_min_donation'])
	{
		$min_chance = round($donation_amount / $adr_general['beggar_chance_increase']);
		
		// Min chance cannot be more than 40%
		$min_chance = $min_chance > 40 ? 40: $min_chance;
		$chance = rand($min_chance,100);

		// Work out value for user to reach to win any type of item
		$win_chance = (100 - $adr_general['beggar_win_chance']);

		if($chance >= $win_chance)
		{
			$item_rand = rand(1,100);

			if($item_rand > '0' && $item_rand < '65')
			{
				$item_id = adr_beggar_donation($user_id, 0, $donation_amount);
				$beggar_info = adr_temple_infos($user_id, $item_id);

				$message .= $beggar_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$beggar_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_beggar_donation_won_common'], adr_get_lang($beggar_info['item_name']));
			}
			elseif($item_rand > '64' && $item_rand < '94')
			{
				$item_id = adr_beggar_donation($user_id, 1, $donation_amount);
				$beggar_info = adr_temple_infos($user_id, $item_id);

				$message .= $beggar_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$beggar_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_beggar_donation_won_uncommon'], adr_get_lang($beggar_info['item_name']));
			}
			elseif($item_rand > '93' && $item_rand < '100')
			{
				$item_id = adr_beggar_donation($user_id, 2, $donation_amount);
				$beggar_info = adr_temple_infos($user_id, $item_id);

				$message .= $beggar_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$beggar_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_beggar_donation_won_rare'], adr_get_lang($beggar_info['item_name']));
			}
			elseif($item_rand > '95' && $item_rand < '101' && $donation_amount < $adr_general['beggar_super_rare_amount'])
			{
				$item_id = adr_beggar_donation($user_id, 3, $donation_amount);
				$beggar_info = adr_temple_infos($user_id, $item_id);

				$message .= $beggar_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$beggar_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_beggar_donation_won_very_rare'], adr_get_lang($beggar_info['item_name']));
			}
			elseif($item_rand > '95' && $item_rand < '101' && $donation_amount >= $adr_general['beggar_super_rare_amount'])
			{
				$item_id = adr_beggar_donation($user_id, 4, $donation_amount);
				$beggar_info = adr_temple_infos($user_id, $item_id);

				$message .= $beggar_info['item_icon'] != '' ? '<br /><img src="adr/images/items/'.$beggar_info['item_icon'].'"><br />' : '<br />';
				$message .= sprintf($lang['Adr_beggar_donation_won_very_rare'], adr_get_lang($beggar_info['item_name']));
			}
		}
	}

	$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>");
	message_die( GENERAL_MESSAGE,$message);

}

else
{
	$template->assign_vars(array(
		'L_TOWNMAP_BEGGAR' => $lang['TownMap_Beggar'],
		'L_BEGGAR_PRIXGUERISON' => $lang['TownMap_Beggar_PrixGuerison'],
		'L_BEGGAR_PRIXRESURRECTION' => $lang['TownMap_Beggar_PrixResurrection'],
		'L_GUERIR' => $lang['TownMap_Beggar_Guerir'],
		'L_RESUSSITER' => $lang['TownMap_Beggar_Resussiter'],
		'L_PRETRESSE1' => $lang['TownMap_Beggar_NomPretresse1'],
		'L_PRETRESSE2' => $lang['TownMap_Beggar_NomPretresse2'],
		'L_TOWNMAP_PRETRESSE1' => $lang['TownMap_Beggar_Pretresse1'],
		'L_TOWNMAP_PRETRESSE2' => $lang['TownMap_Beggar_Pretresse2'],
		'L_BEGGARENTREE' => $lang['TownMap_Beggar_Entree'],
		'L_TOWNBOUTONINFO' => $lang['Adr_TownMap_Bouton_Infos'],
		'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
		'L_BEGGARPRESENTATION' => $lang['Adr_TownMap_Beggar_Presentation'],
		'L_COPYRIGHT' => $lang['Adr_copyright'],
		'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
		'U_TOWNBOUTONRETOUR' => append_sid("adr_TownMap.$phpEx"),
		'U_TOWNMAP_BEGGAR' => append_sid("adr_beggar.$phpEx"),
		'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
		'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
		'L_POINTS' => $board_config['points_name'],
		'L_DONATION_TITLE' 	=> $lang['Adr_beggar_donation_title'],
		'L_DONATION'    	=> $lang['Adr_beggar_donation_amount'],
		'L_DONATE'	    	=> $lang['Adr_beggar_donation_submit'],
		'S_CHARACTER_ACTION' => append_sid("adr_beggar.$phpEx"),
	));
}

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 
