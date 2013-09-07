<?php
/***************************************************************************
 *                                        adr_battle_pvp.php
 *                                ------------------------
 *        begin                         : 30/03/2004
 *        copyright                : Malicious Rabbit / Dr DLP
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
define('IN_ADR_CHARACTER', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_PVP', true);
define('IN_ADR_SHOPS', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_battle';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR);
init_userprefs($userdata);
// End session management
//
$user_id = $userdata['user_id'];
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
        $redirect = "adr_battle.$phpEx";
        $redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
        header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Get the general config
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
adr_levelup_check($user_id);
adr_weight_check($user_id);

if ( !$adr_general['battle_pvp_enable'] )
{
    adr_previous ( Adr_pvp_disabled , adr_character , '' );
}

// Deny access if user is imprisioned
if($userdata['user_cell_time']){
    adr_previous(Adr_shops_no_thief, adr_cell, '');
}


// Get the battle id
$battle_id = intval($HTTP_GET_VARS['battle_id']);

// Define the available actions
$attack = isset($HTTP_POST_VARS['attack']);
$spell = isset($HTTP_POST_VARS['spell']);
$potion = isset($HTTP_POST_VARS['potion']);
$defend = isset($HTTP_POST_VARS['defend']);
$flee = isset($HTTP_POST_VARS['flee']);
$custom_taunt = $HTTP_POST_VARS['custom_taunt'];
$taunt = $HTTP_POST_VARS['taunt'];

// Have the current battle informations
$sql = "SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
        WHERE battle_result = 3
        AND (battle_opponent_id = $user_id  OR battle_challenger_id = $user_id)
        AND battle_id = '$battle_id'";
if(!($result = $db->sql_query($sql)))
    message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
$battle_pvp = $db->sql_fetchrow($result);

// Check if the battle exists and the turn
if((!$battle_id) || (($battle_pvp['battle_challenger_id'] != $user_id) && ($battle_pvp['battle_opponent_id'] != $user_id)))
    adr_previous(Adr_pvp_wrong_turn, adr_character_pvp, '');

// Check for PvP exploit
if(($battle_pvp['battle_challenger_id'] === $user_id) && ($battle_pvp['battle_opponent_id'] === $user_id)){
    // Send admin PM notification of attempted cheating...
    $member_id = intval(2);
    $subject = $lang['Adr_report_pm_sub'];
    $message = sprintf($lang['Adr_report_pm_pvp'], $current_infos['character_name']);
    adr_send_pm($member_id, $subject, $message);

    // Remove PvP battle
    $sql = " DELETE FROM " . ADR_BATTLE_PVP_TABLE . "
            WHERE battle_id = '$battle_id'";
    if( !($result = $db->sql_query($sql)))
        message_die(GENERAL_ERROR, 'Could not delete PvP battle at exploit', '', __LINE__, __FILE__, $sql);

    adr_previous(Adr_pvp_exploit_error, adr_character, '');
}
// have the mail sender infos , it will be of use later
$script_name = preg_replace('/^\/?(.*?)\/?$/', "\\1", trim($board_config['script_path']));
$script_name = ( $script_name != '' ) ? $script_name . '/adr_battle_pvp.'.$phpEx : 'adr_battle_pvp.'.$phpEx;
$server_name = trim($board_config['server_name']);
$server_protocol = ( $board_config['cookie_secure'] ) ? 'https://' : 'http://';
$server_port = ( $board_config['server_port'] <> 80 ) ? ':' . trim($board_config['server_port']) . '/' : '/';

// Includes the tpl and the header
adr_template_file('adr_battle_pvp_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
// Grab both user infos
$current_infos = ($user_id === $battle_pvp['battle_challenger_id']) ? adr_get_user_infos($battle_pvp['battle_challenger_id']) : adr_get_user_infos($battle_pvp['battle_opponent_id']);
$opponent_infos = ($user_id === $battle_pvp['battle_challenger_id']) ? adr_get_user_infos($battle_pvp['battle_opponent_id']) : adr_get_user_infos($battle_pvp['battle_challenger_id']);
### START restriction checks ###
$item_sql = adr_make_restrict_sql($current_infos);
### END restriction checks ###

// Get the current user and the opponent infos
if ( $user_id == $battle_pvp['battle_challenger_id'] )
{
        $current_hp  = $battle_pvp['battle_challenger_hp'];
        $current_mp  = $battle_pvp['battle_challenger_mp'];
        $current_hp_max  = $battle_pvp['battle_challenger_hp_max'];
        $current_mp_max  = $battle_pvp['battle_challenger_mp_max'];
        $current_hp_regen  = $battle_pvp['battle_challenger_hp_regen'];
        $current_mp_regen  = $battle_pvp['battle_challenger_mp_regen'];
        $current_att  = $battle_pvp['battle_challenger_att'];
        $current_def  = $battle_pvp['battle_challenger_def'];
        $current_element  = $battle_pvp['battle_challenger_element'];
        $current_alignment  = $current_infos['character_alignment'];
        $current_class  = $current_infos['character_class'];
        $current_str  = $current_infos['character_might'];
        $current_dex  = $current_infos['character_dexterity'];
        $current_ma  = $battle_pvp['battle_challenger_magic_attack'];
        $current_md  = $battle_pvp['battle_challenger_magic_resistance'];
        $current_dmg  = $battle_pvp['battle_challenger_dmg'];
        $opponent_hp  = $battle_pvp['battle_opponent_hp'];
        $opponent_mp  = $battle_pvp['battle_opponent_mp'];
        $opponent_hp_max  = $battle_pvp['battle_opponent_hp_max'];
        $opponent_mp_max  = $battle_pvp['battle_opponent_mp_max'];
        $opponent_hp_regen  = $battle_pvp['battle_opponent_hp_regen'];
        $opponent_mp_regen  = $battle_pvp['battle_opponent_mp_regen'];
        $opponent_att  = $battle_pvp['battle_opponent_att'];
        $opponent_def  = $battle_pvp['battle_opponent_def'];
        $opponent_element  = $battle_pvp['battle_opponent_element'];
        $opponent_alignment  = $opponent_infos['character_alignment'];
        $opponent_class  = $opponent_infos['character_class'];
        $opponent_str  = $opponent_infos['character_might'];
        $opponent_dex  = $opponent_infos['character_dexterity'];
        $opponent_ma  = $battle_pvp['battle_opponent_magic_attack'];
        $opponent_md  = $battle_pvp['battle_opponent_magic_resistance'];
        $opponent_dmg  = $battle_pvp['battle_opponent_dmg'];
        $dest = $battle_pvp['battle_opponent_id'];
}
else if ( $user_id == $battle_pvp['battle_opponent_id'] )
{
        $current_hp  = $battle_pvp['battle_opponent_hp'];
        $current_mp  = $battle_pvp['battle_opponent_mp'];
        $current_hp_max  = $battle_pvp['battle_opponent_hp_max'];
        $current_mp_max  = $battle_pvp['battle_opponent_mp_max'];
        $current_hp_regen  = $battle_pvp['battle_opponent_hp_regen'];
        $current_mp_regen  = $battle_pvp['battle_opponent_mp_regen'];
        $current_att  = $battle_pvp['battle_opponent_att'];
        $current_def  = $battle_pvp['battle_opponent_def'];
	    $current_element  = $battle_pvp['battle_opponent_element'];
        $current_alignment  = $current_infos['character_alignment'];
        $current_class  = $current_infos['character_class'];
        $current_str  = $current_infos['character_might'];
        $current_dex  = $current_infos['character_dexterity'];
        $current_ma  = $battle_pvp['battle_opponent_magic_attack'];
        $current_md  = $battle_pvp['battle_opponent_magic_resistance'];
        $current_dmg  = $battle_pvp['battle_opponent_dmg'];
        $opponent_hp  = $battle_pvp['battle_challenger_hp'];
        $opponent_mp  = $battle_pvp['battle_challenger_mp'];
        $opponent_hp_max  = $battle_pvp['battle_challenger_hp_max'];
        $opponent_mp_max  = $battle_pvp['battle_challenger_mp_max'];
        $opponent_hp_regen  = $battle_pvp['battle_challenger_hp_regen'];
        $opponent_mp_regen  = $battle_pvp['battle_challenger_mp_regen'];
        $opponent_att  = $battle_pvp['battle_challenger_att'];
        $opponent_def  = $battle_pvp['battle_challenger_def'];
        $opponent_element  = $battle_pvp['battle_challenger_element'];
        $opponent_alignment  = $opponent_infos['character_alignment'];
        $opponent_class  = $opponent_infos['character_class'];
        $opponent_str  = $opponent_infos['character_might'];
        $opponent_dex  = $opponent_infos['character_dexterity'];
        $opponent_ma  = $battle_pvp['battle_challenger_magic_attack'];
        $opponent_md  = $battle_pvp['battle_challenger_magic_resistance'];
        $opponent_dmg  = $battle_pvp['battle_challenger_dmg'];
        $dest = $battle_pvp['battle_challenger_id'];
}
else
{
        adr_previous ( Adr_pvp_wrong_turn , adr_character_pvp , '' );
}
$battle_challenger_id = $battle_pvp['battle_challenger_id'];
$battle_opponent_id = $battle_pvp['battle_opponent_id'];
$battle_text = $battle_pvp['battle_text'];
$battle_text_chat = $battle_pvp['battle_text_chat'];
$battle_background = $battle_pvp['battle_bkg'];

// Empty the request in memory
$db->sql_freeresult($result);

$current_name = htmlspecialchars($userdata['username']);

$sql = " SELECT username FROM " . USERS_TABLE . "
                WHERE user_id = $dest ";
if( !($result = $db->sql_query($sql)) )
{
        message_die(GENERAL_ERROR, 'Could not query opponent name', '', __LINE__, __FILE__, $sql);
}
$opponent_inf = $db->sql_fetchrow($result);
$opponent_name = htmlspecialchars($opponent_inf['username']);

// Define character names for both users
$current_name = htmlspecialchars($current_infos['character_name']);
$opponent_name = htmlspecialchars($opponent_infos['character_name']);
$opponent_id = intval($opponent_infos['character_id']);

// Grab opponents PM notification preference
$sql = "SELECT prefs_pvp_notif_pm FROM " . ADR_CHARACTERS_TABLE . "
        WHERE character_id = '$opponent_id'";
if( !($result = $db->sql_query($sql)))
    message_die(GENERAL_ERROR, 'Could not query opponent prefs', '', __LINE__, __FILE__, $sql);
$opponent_pref = $db->sql_fetchrow($result);
$opponent_pm_me = !!$opponent_pref['prefs_pvp_notif_pm'];

// Empty the request in memory
$db->sql_freeresult($result);

//  Taunt code
if ( !empty($custom_taunt) || !empty($taunt) )
{	
	if ( $custom_taunt != '' )
	{
		$custom_taunt = htmlspecialchars($custom_taunt);
		$updated_chat = str_replace('<br />', "\n", $custom_taunt);	

		$new_message = $updated_chat = 'Þ'. $current_name .': '. str_replace('Þ', 'p', str_replace('þ', 'p', $updated_chat)) .'þ';
		$old_session = $battle_pvp['battle_text'];
		$update_chat_session = $new_message;
		$update_chat_session .= $old_session;
		$apos_fix = str_replace("\'", "%APOS%", $update_chat_session);
		
		$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
			SET battle_text = '" . $apos_fix . "'
			WHERE battle_id = $battle_id ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
		}
	}
	else
	{
		$taunt = htmlspecialchars($taunt);
		$updated_chat = str_replace('<br />', "\n", $taunt);

		$new_message = $updated_chat = 'Þ'. $current_name .': '. str_replace('Þ', 'p', str_replace('þ', 'p', $updated_chat)) .'þ';
		$old_session = $battle_pvp['battle_text'];
		$update_chat_session = $new_message;
		$update_chat_session .= $old_session;
		$apos_fix = str_replace("\'", "%APOS%", $update_chat_session);
		
		$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
			SET battle_text = '" . $apos_fix . "'
			WHERE battle_id = $battle_id ";
		if( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
		}
	}
}

include_once($phpbb_root_path . '/adr/includes/adr_functions_battle_setup.'.$phpEx);
adr_battle_effects_initialise($user_id,0,'',1);

##=== START: battle code ===##
// First we need to stop a user from backing up in their browser and repeat hitting
if((($user_id === $battle_pvp['battle_challenger_id']) && ($battle_pvp['battle_turn'] === $user_id)) || (($user_id === $battle_pvp['battle_opponent_id']) && ($battle_pvp['battle_turn'] === $user_id)))
	$turn_check = TRUE;
else
	$turn_check = FALSE;

if ( $turn_check && ( $attack || ( $spell && intval($HTTP_POST_VARS['item_spell']) ) || ( $potion && intval($HTTP_POST_VARS['item_potion']) ) || $flee ))
{
    if($flee)
    {
        if($user_id === $battle_pvp['battle_challenger_id'])
            $battle_result = intval(8);
        else
            $battle_result = intval(9);

        // Update the database
        $sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
                SET battle_result = $battle_result
                WHERE battle_id = '$battle_id'";
        if(!($result = $db->sql_query($sql)))
            message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);

        // Update total flees
        $sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
                SET character_flees_pvp = (character_flees_pvp + 1)
                WHERE character_id = '$user_id'";
        if(!($result = $db->sql_query($sql)))
            message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);

        if($opponent_pm_me){
            $subject = $lang['Adr_pvp_flee'];
            $message = sprintf($lang['Adr_pvp_flee_by'], $current_infos['character_name']);
            adr_send_pm($dest, $subject, $message);
        }

        adr_previous(Adr_battle_flee_pvp, adr_character_pvp, '');
    } // end if flee
	else if ( $spell )
	{
        // Define the weapon quality and power
        $item_spell = intval($HTTP_POST_VARS['item_spell']);
        $power = 0;

        if ( $item_spell )
        {
            $sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
                    WHERE item_in_shop = 0
                    AND item_owner_id = $user_id
			  			AND item_in_warehouse = 0
			  			AND item_monster_thief = '0'
					AND (item_bought_timestamp < '".$battle_pvp['battle_start']."' OR item_bought_timestamp = '0')
                    $item_sql
                    AND item_id = $item_spell ";
            if( !($result = $db->sql_query($sql)) )
            {
                message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
            }
            $item = $db->sql_fetchrow($result);

			if ( $current_mp < ($item['item_mp_use'] + $item['item_power']) || $current_mp < 0 ) 
			{	
				adr_previous ( Adr_battle_check , 'adr_battle' , '' );
			}

 		    $dice = rand(0,5);
	      	$power = ($item['item_power'] + $item['item_add_power'] + $dice);

            adr_use_item($item_spell , $user_id);

            // Substract the magic points
            if ( $user_id == $battle_challenger_id )
            {
                $sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
					SET battle_challenger_mp = battle_challenger_mp - (" . $item['item_power'] . " + " . $item['item_mp_use'] . ")
                    WHERE battle_challenger_id = $user_id
                    AND battle_id = $battle_id ";
                    if( !($result = $db->sql_query($sql)) )
                    {
                    	message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
                    }
            }
            else if ( $user_id == $battle_opponent_id )
            {
                $sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
					SET battle_opponent_mp = battle_opponent_mp - (" . $item['item_power'] . " + " . $item['item_mp_use'] . ")
                    WHERE battle_opponent_id = $user_id
                    AND battle_id = $battle_id ";
                if( !($result = $db->sql_query($sql)) )
                {
                	message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
                }
            }
        } // end if item_spell

    	if($item['item_type_use'] == '11')
		{
			// Grab details for Elemental infos
			$elemental = adr_get_element_infos($opponent_element);
			$element_name = ($item['item_element'] > '0') ? adr_get_element_infos($item['item_element']) : '';

			// Here we apply text colour if set
			if($element_name['element_colour'] != ''){
				$item['item_name'] = '<font color="'.$element_name['element_colour'].'">'.adr_get_lang($item['item_name']).'</font>';}
			else{
				$item['item_name'] = adr_get_lang($item['item_name']);}

			// Sort out magic check & opponents saving throw
			$dice = rand(1,20);
			$magic_check = ceil($dice + $item['item_power'] + adr_modifier_calc($current_infos['character_intelligence']));
			$fort_save = (11 + adr_modifier_calc($opponent_infos['character_wisdom']));
			$success = ((($magic_check >= $fort_save) && ($dice != '1')) || ($dice == '20')) ? TRUE : FALSE;
			$power = ($power + adr_modifier_calc($current_infos['character_intelligence']));

			// Check for successful strike upon opponent
			if($success === TRUE){
				$damage = 0;

				if(($item['item_element']) && ($item['item_element'] === $elemental['element_oppose_strong']) && (!empty($item['item_name']))){
					$damage = ceil($power *($item['item_element_weak_dmg'] /100));
				}
				elseif(($item['item_element']) && ($item['item_element'] === $opponent_element) && (!empty($item['item_name']))){
					$damage = ceil($power *($item['item_element_same_dmg'] /100));
				}
				elseif(($item['item_element']) && ($item['item_element'] === $elemental['element_oppose_weak']) && (!empty($item['item_name']))){
					$damage = ceil($power *($item['item_element_str_dmg'] /100));
				}
				else{
					$damage = ceil($power);
				}

				$damage = ($damage < '1') ? rand(1,3) : $damage;
				$damage = ($damage > $opponent_hp) ? $opponent_hp : $damage;

				if(($item['item_element'] != '') && ($item['item_element'] != '0')){
					$battle_message .= sprintf($lang['Adr_pvp_spell_success'], $current_name, $item['item_name'], $element_name['element_name'], $opponent_name, $damage).'<br />';}
				else{
					$battle_message .= sprintf($lang['Adr_pvp_spell_success_norm'], $current_name, $item['item_name'], $opponent_name, $damage).'<br />';}
			}
			else{
				$damage = 0;
				$battle_message .= sprintf($lang['Adr_pvp_spell_failure'], $current_name, $item['item_name'], $opponent_name).'<br />';
			}

			// Check for low dura
			if($item['item_duration'] < '2'){
				$battle_message .= '<span class="gensmall">'; // set new span class
				$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_pvp_spell_dura'], $current_name, $item['item_name']).'<br />';
				$battle_message .= '</span>'; // reset span class to default
			}

			// Work out correct details for db update
			if($user_id === $battle_challenger_id){
				$hp_opponent_check = 'battle_opponent_hp = (battle_opponent_hp - '.$damage.')';
				$dmg_opponent_check = 'battle_opponent_dmg = '.$damage;
			}
			else{
				$hp_opponent_check = 'battle_challenger_hp = (battle_challenger_hp - '.$damage.')';
				$dmg_opponent_check = 'battle_challenger_dmg = '.$damage;
			}

			// Update the database
			$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
				SET $hp_opponent_check,
					$dmg_opponent_check
					WHERE battle_id = '$battle_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
		} // end if item use 11
 		elseif($item['item_type_use'] == '12')
		{
			// Create message
			$battle_message .= sprintf($lang['Adr_pvp_spell_defensive_success'], $current_name, adr_get_lang($item['item_name']), $current_name, $power).'<br />';

			// Check for low dura
			if($item['item_duration'] < '2'){
				$battle_message .= '<span class="gensmall">'; // set new span class
				$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_pvp_spell_dura'], $current_name, adr_get_lang($item['item_name'])).'<br />';
				$battle_message .= '</span>'; // reset span class to default
			}

			// Update the database
			if($user_id === $battle_challenger_id){
				$check_att = 'battle_challenger_att';
				$check_def = 'battle_challenger_def';
			}
			elseif($user_id === $battle_opponent_id){
				$check_att = 'battle_opponent_att';
				$check_def = 'battle_opponent_def';
			}

			$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
				SET $check_att = ($check_att + $power),
					$check_def = ($check_def + $power)
				WHERE battle_id = '$battle_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
        } // end if item use 12
	} 
    else if ( $potion )
    {
        // Define the weapon quality and power
        $item_potion = intval($HTTP_POST_VARS['item_potion']);
        $power = 1;

        if($item_potion)
        {
        	$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
        		WHERE item_in_shop = '0'
        		AND item_owner_id = '$user_id'
        		AND item_in_warehouse = '0'
        		AND item_monster_thief = 0
        		AND (item_bought_timestamp < '".$battle_pvp['battle_start']."' OR item_bought_timestamp = '0')
                $item_sql
        		AND item_id = '$item_potion'";
        	if(!($result = $db->sql_query($sql))){
        		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
        	$item = $db->sql_fetchrow($result);
        
        	if($current_mp < '0'){
        		adr_previous(Adr_battle_check, 'adr_battle', '');}
        
        	$power = ($item['item_power'] + $item['item_add_power']);
        	adr_use_item($item_potion, $user_id);
        }

  		if($item['item_type_use'] == '15')
  		{
  			// Create message
  			$power = ($power > ($current_hp_max - $current_hp)) ? ($current_hp_max - $current_hp) : $power;
  			$battle_message .= sprintf($lang['Adr_pvp_potion_hp_success'], $current_name, adr_get_lang($item['item_name']), $power, $current_name, adr_get_lang($item['item_name'])).'<br />';
  		
  			// Check for low dura
  			if($item['item_duration'] < '2'){
  				$battle_message .= '<span class="gensmall">'; // set new span class
  				$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_pvp_potion_hp_dura'], $current_name, adr_get_lang($item['item_name'])).'<br />';
  				$battle_message .= '</span>'; // reset span class to default
  			}
  		
  			// Update the database
  			$check_hp = ($user_id === $battle_challenger_id) ? 'battle_challenger_hp' : 'battle_opponent_hp';
  		
  			$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
  				SET $check_hp = ($check_hp + $power)
  				WHERE battle_id = '$battle_id'";
  			if(!($result = $db->sql_query($sql))){
  				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
  		} // end use 15
  		elseif($item['item_type_use'] == '16')
  		{
  			// Create message
  			$power = ($power > ($current_mp_max - $current_mp)) ? ($current_mp_max - $current_mp) : $power;
  			$battle_message .= sprintf($lang['Adr_pvp_potion_mp_success'], $current_name, adr_get_lang($item['item_name']), $power, $current_name, adr_get_lang($item['item_name'])).'<br />';
  		
  			// Check for low dura
  			if($item['item_duration'] < '2'){
  				$battle_message .= '<span class="gensmall">'; // set new span class
  				$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_pvp_potion_hp_dura'], $current_name, adr_get_lang($item['item_name'])).'<br />';
  				$battle_message .= '</span>'; // reset span class to default
  			}
  		
  			// Update the database
  			$check_mp = ($user_id === $battle_challenger_id) ? 'battle_challenger_mp' : 'battle_opponent_mp';
  		
  			$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
  				SET $check_mp = ($check_mp + $power)
  				WHERE battle_id = '$battle_id'";
  			if(!($result = $db->sql_query($sql))){
  				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
  		} // end use 16
        else if ( $item['item_type_use'] == 19 )
        {
            include_once($phpbb_root_path . '/adr/includes/adr_functions_battle_setup.'.$phpEx);

            $e_message = adr_battle_effects_initialise($user_id,$item_potion,$opponent_infos['character_name'],1);
            
            // Use item
            adr_use_item($item_potion, $user_id);

            $battle_message .= $e_message;

            // Check for low dura
            if($item['item_duration'] < '2'){
                $battle_message .= '<span class="gensmall">'; // set new span class
                $battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_pvp_potion_hp_dura'], $current_name, adr_get_lang($item['item_name'])).'<br />';
                $battle_message .= '</span>'; // reset span class to default
            }
        } // end us 19
    } // end if potion
    else if ( $attack )
    {
    	if($weap)
    	{
    		$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
    			WHERE item_in_shop = '0'
    			AND item_owner_id = '$user_id'
    			AND item_in_warehouse = '0'
    			AND item_monster_thief = 0
    			AND (item_bought_timestamp < '".$battle_pvp['battle_start']."' OR item_bought_timestamp = '0')
                $item_sql
    			AND item_id = '$weap'";
    		if(!($result = $db->sql_query($sql))){
    			message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
    		$item = $db->sql_fetchrow($result);

    		if(($current_mp < $item['item_mp_use']) || ($current_mp < '0')){	
    			adr_previous(Adr_battle_check, 'adr_battle', '');
    		}

    		// Remove any MP costs
    		if($item['item_mp_use'] > '0'){
    			$check_mp = ($user_id === $battle_challenger_id) ? 'battle_challenger_mp' : 'battle_opponent_mp';

    			$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
    				SET $check_mp = ($check_mp - " . $item['item_mp_use'] . ")
    				WHERE battle_id = '$battle_id'";
    			if(!($result = $db->sql_query($sql))){
    				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
    		}

    		// Define theses values according to the item type ( enchanted weapon are better than normal weapons )
    		$quality = ( $item['item_type_use'] == '6') ? ($item['item_quality'] *2) : $item['item_quality'];
    		$power = ($item['item_power'] + $item['item_add_power']);
    		adr_use_item($weap, $user_id);
    	} // end if weap

        
    	// Let's check if the attack succeeds
    	$dice = rand(1,20);
    	$diff = (($current_att + $quality + $dice + $current_infos['character_level']) > ($opponent_def + $opponent_infos['character_level'])) ? TRUE : FALSE;
    	$power = ($power + adr_modifier_calc($current_infos['character_might']));
    	$damage = 1;

    	// Elemental infos
    	$elemental = adr_get_element_infos($opponent_element);
    	$element_name = ($item['item_name'] != '') ? adr_get_element_infos($item['item_element']) : '';

    	// Here we apply text colour if set
    	if($element_name['element_colour'] != ''){
    		$item['item_name'] = '<font color="'.$element_name['element_colour'].'">'.adr_get_lang($item['item_name']).'</font>';
    	}
    	else{
    		$item['item_name'] = adr_get_lang($item['item_name']);
    	}

    	##=== START: Critical hit code
    	$threat_range = ($item['item_type_use'] == '6') ? '19' : '20'; // magic weaps get slightly better threat range
    	$crit_result = adr_battle_make_crit_roll($current_att, $current_infos['character_level'], $opponent_def, $item['item_type_use'], $power, $quality, $threat_range);
    	##=== END: Critical hit code

    	// Bare hands strike!
       	if($item['item_name'] == '')
       	{
    		// Opponent roll
    		$opponent_def_dice = rand(1,20);

    		// Grab modifers
    		$str_modifier = (1+ adr_modifier_calc($current_str));
    		$dex_modifier = (1+ adr_modifier_calc($opponent_dex));

    		if(((($dice + $str_modifier) >= ($opponent_def_dice + $dex_modifier)) && ($dice > '1')) || ($dice == '20'))
    		{
    			// Attack success, calculate the damage. Critical dice roll is still success
    			$damage = rand(1,3);
    			$damage = ($damage > $opponent_hp) ? $opponent_hp : $damage;
    			$battle_message .= sprintf($lang['Adr_pvp_attack_bare_success'], $current_name, $opponent_name, $damage).'<br />';
    		}
    		else{
    			$damage = 0;
    			$battle_message .= sprintf($lang['Adr_pvp_attack_bare_fail'], $current_name, $opponent_name).'<br />';
    		}
        } // end if empty item name
			else{
				if((($diff == TRUE) && ($dice != '1')) || ($dice >= $threat_range)){
					// Prefix msg if crit hit
					$battle_message .= ($crit_result === TRUE) ? '<br>'.$lang['Adr_battle_critical_hit'].'</b><br />' : '';
					$damage = 0;

					// Work out attack type
					if(($item['item_element']) && ($item['item_element'] == $elemental['element_oppose_strong']) && ($item['item_duration'] > '1') && (!empty($item['item_name']))){
						$damage = ceil(($power *($item['item_element_weak_dmg'] /100)));
					}
           			elseif(($item['item_element']) && (!empty($item['item_name'])) && ($item['item_element'] == $opponent_element) && ($item['item_duration'] > '1')){
						$damage = ceil(($power *($item['item_element_same_dmg'] /100)));
					}
					elseif(($item['item_element']) && (!empty($item['item_name'])) && ($item['item_element'] == $elemental['element_oppose_weak']) && ($item['item_duration'] > '1')){
						$damage = ceil(($power *($item['item_element_str_dmg'] /100)));
					}
					else{
						$damage = $power;
					}

					// Fix dmg value
					$damage = ($damage < '1') ? rand(1,3) : $damage;
					$damage = ($damage > $opponent_hp) ? $opponent_hp : $damage;

					// Fix attack msg type
					if($item['item_element'] > '0'){
						$battle_message .= sprintf($lang['Adr_pvp_attack_success'], $current_name, $opponent_name, $item['item_name'], $element_name['element_name'], $damage).'<br />';}
					else{
						$battle_message .= sprintf($lang['Adr_pvp_attack_success_norm'], $current_name, $opponent_name, $item['item_name'], $damage).'<br />';}
				}
				else{
					$damage = 0;
					$battle_message .= sprintf($lang['Adr_pvp_attack_failure'], $current_name, $opponent_name, $item['item_name']).'<br />';
				}

				// Check for low dura
				if(($item['item_duration'] < '2') && ($item['item_name'] != '')){
					$battle_message .= '<span class="gensmall">'; // set new span class
					$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_pvp_attack_dura'], $current_name, $item['item_name']).'<br />';
					$battle_message .= '</span>'; // reset span class to default
				}
			}

			// Update the database
			$check_user = ($user_id === $battle_challenger_id) ? 'battle_opponent_hp' : 'battle_challenger_hp';
			$check_user_dmg = ($user_id === $battle_challenger_id) ? 'battle_opponent_dmg' : 'battle_challenger_dmg';

			$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
					SET $check_user = ($check_user - $damage),
						$check_user_dmg = $damage
					WHERE battle_id = '$battle_id'";
			if(!($result = $db->sql_query($sql))){
				message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
    } // end if attack


    ##=== START: additional status checks on user ===##
    if($turn_check == TRUE)
    {
    	$battle_message .= '<span class="gensmall">'; // prefix new span class
    
    	// Refresh hp/mp stats
    	$sql = "SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
    	        WHERE battle_id = '$battle_id'";
    	if(!($result = $db->sql_query($sql)))
    		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
    	$hp_refresh_infos = $db->sql_fetchrow($result);
    	$current_hp = ($user_id === $hp_refresh_infos['battle_challenger_id']) ? $hp_refresh_infos['battle_challenger_hp'] : $hp_refresh_infos['battle_opponent_hp'];
    	$current_hp_max = ($user_id === $hp_refresh_infos['battle_challenger_id']) ? $hp_refresh_infos['battle_challenger_hp_max'] : $hp_refresh_infos['battle_opponent_hp_max'];
    	$current_mp = ($user_id === $hp_refresh_infos['battle_challenger_id']) ? $hp_refresh_infos['battle_challenger_mp'] : $hp_refresh_infos['battle_opponent_mp'];
    	$current_mp_max = ($user_id === $hp_refresh_infos['battle_challenger_id']) ? $hp_refresh_infos['battle_challenger_mp_max'] : $hp_refresh_infos['battle_opponent_mp_max'];
    
    	// HP regen code
    	if(($current_hp_regen > '0') && ($current_hp < $current_hp_max)){
    		$hp_regen = ($current_hp_regen > ($current_hp_max - $current_hp)) ? ($current_hp_max - $current_hp) : $current_hp_regen;
    		$hp_user_check = ($user_id === $battle_challenger_id) ? 'battle_challenger_hp = (battle_challenger_hp + '.$hp_regen.')' : 'battle_opponent_hp = (battle_opponent_hp + '.$hp_regen.')';
    		$user_id_check = ($user_id === $battle_challenger_id) ? 'battle_challenger_id = '.$user_id : 'battle_opponent_id = '.$user_id;
    
    		$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
    				SET $hp_user_check
    				WHERE $user_id_check
    				AND battle_id = '$battle_id'";
    		if( !($result = $db->sql_query($sql)))
    			message_die(GENERAL_ERROR, 'Could not update hp regen', '', __LINE__, __FILE__, $sql);
    
    		$current_hp = ($current_hp + $hp_regen);
    		$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_pvp_regen_xp'], $current_name, $hp_regen).'<br>';
    	}
    
    	// MP regen code
    	if(($current_mp_regen > '0') && ($current_mp < $current_mp_max))
    	{
    		$mp_regen = ($current_mp_regen > ($current_mp_max - $current_mp)) ? ($current_mp_max - $current_mp) : $current_mp_regen;
    		$mp_user_check = ($user_id === $battle_challenger_id) ? 'battle_challenger_mp = (battle_challenger_mp + '.$mp_regen.')' : 'battle_opponent_mp = (battle_opponent_mp + '.$mp_regen.')';
    		$user_id_check = ($user_id === $battle_challenger_id) ? 'battle_challenger_id = '.$user_id : 'battle_opponent_id = '.$user_id;
    
    		$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
    				SET $mp_user_check
    				WHERE $user_id_check
    				AND battle_id = '$battle_id'";
    		if( !($result = $db->sql_query($sql)))
    			message_die(GENERAL_ERROR, 'Could not update mp regen', '', __LINE__, __FILE__, $sql);
    
    		$current_mp = ($current_mp + $mp_regen);
    		$battle_message .= '&nbsp;&nbsp;>&nbsp;'.sprintf($lang['Adr_pvp_regen_mp'], $current_name, $mp_regen).'<br>' ;
    	}
    
    	$battle_message .= '</span>'; // reset span class to default
    }
    ##=== END: additional status checks on user ===##
	// Update the database accordingly
	// $new_battle_text = addslashes( str_replace('<br />', "\n", $battle_message) );
	$new_battle_text = addslashes(str_replace('<br />', '<br>', $battle_message));
	$new_battle_text = '%BSS%'. str_replace('\'', '%APOS%', $new_battle_text) .'%BSE%';
	$new_battle_text .= $battle_text;

	$sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
		SET battle_text = '" . $new_battle_text . "'
		WHERE battle_id = $battle_id";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
	}

    // Now we look the results of this turn !
    // Have the updated battle informations
    $sql = " SELECT * FROM " . ADR_BATTLE_PVP_TABLE . "
            WHERE battle_result = 3
            AND ( battle_opponent_id = $user_id        OR battle_challenger_id = $user_id )
            AND battle_id = $battle_id ";
    if( !($result = $db->sql_query($sql)) )
    {
            message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
    }
    $battle_pvp = $db->sql_fetchrow($result);

    // Get the current user and the opponent infos
    if ( $user_id == $battle_pvp['battle_challenger_id'] )
    {
        $current_hp  = $battle_pvp['battle_challenger_hp'];
        $current_mp  = $battle_pvp['battle_challenger_mp'];
        $current_hp_max  = $battle_pvp['battle_challenger_hp_max'];
        $current_mp_max  = $battle_pvp['battle_challenger_mp_max'];
        $current_hp_regen  = $battle_pvp['battle_challenger_hp_regen'];
        $current_mp_regen  = $battle_pvp['battle_challenger_mp_regen'];
        $current_att  = $battle_pvp['battle_challenger_att'];
        $current_def  = $battle_pvp['battle_challenger_def'];
        $current_dmg  = $battle_pvp['battle_challenger_dmg'];
        $opponent_hp  = $battle_pvp['battle_opponent_hp'];
        $opponent_mp  = $battle_pvp['battle_opponent_mp'];
        $opponent_hp_max  = $battle_pvp['battle_opponent_hp_max'];
        $opponent_mp_max  = $battle_pvp['battle_opponent_mp_max'];
        $opponent_hp_regen  = $battle_pvp['battle_opponent_hp_regen'];
        $opponent_mp_regen  = $battle_pvp['battle_opponent_mp_regen'];
        $opponent_att  = $battle_pvp['battle_opponent_att'];
        $opponent_def  = $battle_pvp['battle_opponent_def'];
        $opponent_dmg  = $battle_pvp['battle_opponent_dmg'];
        $dest = $battle_pvp['battle_opponent_id'];
    }
    else if ( $user_id == $battle_pvp['battle_opponent_id'] )
    {
        $current_hp  = $battle_pvp['battle_opponent_hp'];
        $current_mp  = $battle_pvp['battle_opponent_mp'];
        $current_hp_max  = $battle_pvp['battle_opponent_hp_max'];
        $current_mp_max  = $battle_pvp['battle_opponent_mp_max'];
        $current_hp_regen  = $battle_pvp['battle_opponent_hp_regen'];
        $current_mp_regen  = $battle_pvp['battle_opponent_mp_regen'];
        $current_att  = $battle_pvp['battle_opponent_att'];
        $current_def  = $battle_pvp['battle_opponent_def'];
        $current_dmg  = $battle_pvp['battle_opponent_dmg'];
        $opponent_hp  = $battle_pvp['battle_challenger_hp'];
        $opponent_mp  = $battle_pvp['battle_challenger_mp'];
        $opponent_hp_max  = $battle_pvp['battle_challenger_hp_max'];
        $opponent_mp_max  = $battle_pvp['battle_challenger_mp_max'];
        $opponent_hp_regen  = $battle_pvp['battle_challenger_hp_regen'];
        $opponent_mp_regen  = $battle_pvp['battle_challenger_mp_regen'];
        $opponent_att  = $battle_pvp['battle_challenger_att'];
        $opponent_def  = $battle_pvp['battle_challenger_def'];
        $opponent_dmg  = $battle_pvp['battle_challenger_dmg'];
        $dest = $battle_pvp['battle_challenger_id'];
    }

    if ( $opponent_hp < 1 )
    {
        // The opponent is dead , give money and xp to the users , then update the database

        $sql = " SELECT character_level FROM " . ADR_CHARACTERS_TABLE . "
                WHERE character_id = $user_id ";
        if( !($result = $db->sql_query($sql)) )
        {
                message_die(GENERAL_ERROR, 'Could not query character level', '', __LINE__, __FILE__, $sql);
        }
        $level = $db->sql_fetchrow($result);
        $current_level = $level['character_level'];

        $sql = " SELECT character_level FROM " . ADR_CHARACTERS_TABLE . "
                WHERE character_id = $dest ";
        if( !($result = $db->sql_query($sql)) )
        {
            message_die(GENERAL_ERROR, 'Could not query character level', '', __LINE__, __FILE__, $sql);
        }
        $level = $db->sql_fetchrow($result);
        $opponent_level = $level['character_level'];

        $exp = rand ( $adr_general['pvp_base_exp_min'] , $adr_general['pvp_base_exp_max'] );
        if (( $opponent_level - $current_level ) > 1 )
        {
                $exp = floor( ( ( $opponent_level - $current_level ) * $adr_general['pvp_base_exp_modifier'] ) / 100 );
        }

        // Get the money earned
        $reward = rand ( $adr_general['pvp_base_reward_min'] , $adr_general['pvp_base_reward_max'] );
        if (( $opponent_level - $current_level ) > 1 )
        {
                $reward = floor( ( ( $opponent_level - $current_level ) * $adr_general['pvp_base_reward_modifier'] ) / 100 );
        }

        //Guild Experience
        $guild_exp = rand($adr_general['battle_guild_exp_min'], $adr_general['battle_guild_exp_max']);

        // Write the result in the db
        if ( $user_id == $battle_pvp['battle_challenger_id'] )
        {
            $sql = " UPDATE  " . ADR_BATTLE_PVP_TABLE . "
            SET battle_result = 1
            WHERE battle_id = $battle_id
            AND battle_result = 3 ";
            if( !($result = $db->sql_query($sql)) )
            {
                    message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);
            }
        }
        else
        {
            $sql = " UPDATE  " . ADR_BATTLE_PVP_TABLE . "
            SET battle_result = 2
            WHERE battle_id = $battle_id
            AND battle_result = 3 ";
            if( !($result = $db->sql_query($sql)) )
            {
                    message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);
            }
        }

         // Give the rewards 
             add_reward( $user_id, $reward );

            $sql = " UPDATE  " . ADR_CHARACTERS_TABLE . "
                    SET character_xp = character_xp + $exp ,
                            character_victories_pvp = character_victories_pvp + 1
                    WHERE character_id = $user_id ";
            if( !($result = $db->sql_query($sql)) )
            {
                    message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
            }

            $sql = " UPDATE  " . ADR_CHARACTERS_TABLE . "
                    SET character_defeats_pvp = character_defeats_pvp + 1
                    WHERE character_id = $dest ";
            if( !($result = $db->sql_query($sql)) )
            {
                    message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
            }

            if ( $opponent_pm_me )
            {
                    $subject = $lang['Adr_pvp_lost'];
                    $message = sprintf($lang['Adr_pvp_lost_by'] , $current_infos['character_name'] , $opponent_dmg);

                    adr_send_pm ( $dest , $subject  , $message );
            }

            $message = sprintf($lang['Adr_battle_pvp_won'] , $opponent_dmg , $exp , $reward , get_reward_name() );
            $message .= '<br /><br />'.sprintf($lang['Adr_pvp_return'] ,"<a href=\"" . 'adr_character.'.$phpEx . "\">", "</a>") ;
            message_die ( GENERAL_MESSAGE , $message );
        }

        if ( $current_hp < 1 )
        {
                // This condition should never be true . But I prefer prevent !

                $sql = " SELECT character_level FROM " . ADR_CHARACTERS_TABLE . "
                        WHERE character_id = $user_id ";
                if( !($result = $db->sql_query($sql)) )
                {
                        message_die(GENERAL_ERROR, 'Could not query character level', '', __LINE__, __FILE__, $sql);
                }
                $level = $db->sql_fetchrow($result);
                $current_level = $level['character_level'];

                $sql = " SELECT character_level FROM " . ADR_CHARACTERS_TABLE . "
                        WHERE character_id = $dest ";
                if( !($result = $db->sql_query($sql)) )
                {
                        message_die(GENERAL_ERROR, 'Could not query character level', '', __LINE__, __FILE__, $sql);
                }
                $level = $db->sql_fetchrow($result);
                $opponent_level = $level['character_level'];

                $exp = rand ( $adr_general['pvp_base_exp_min'] , $adr_general['pvp_base_exp_max'] );
                if (( $current_level - $opponent_level ) > 1 )
                {
                        $exp = floor( ( ( $current_level - $opponent_level ) * $adr_general['pvp_base_exp_modifier'] ) / 100 );
                }

                // Get the money earned
                $reward = rand ( $adr_general['pvp_base_reward_min'] , $adr_general['pvp_base_reward_max'] );
                if (( $current_level - $opponent_level ) > 1 )
                {
                        $reward = floor( ( ( $current_level - $opponent_level ) * $adr_general['pvp_base_reward_modifier'] ) / 100 );
                }

                // Write the result in the db
                if ( $user_id == $battle_pvp['battle_challenger_id'] )
                {
                        $sql = " UPDATE  " . ADR_BATTLE_PVP_TABLE . "
                        SET battle_result = 2
                        WHERE battle_id = $battle_id
                        AND battle_result = 3 ";
                        if( !($result = $db->sql_query($sql)) )
                        {
                                message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);
                        }
                }
                else
                {
                        $sql = " UPDATE  " . ADR_BATTLE_PVP_TABLE . "
                        SET battle_result = 1
                        WHERE battle_id = $battle_id
                        AND battle_result = 3 ";
                        if( !($result = $db->sql_query($sql)) )
                        {
                                message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);
                        }
                }

         // Give the rewards 
         add_reward( $dest, $reward );

                $sql = " UPDATE  " . ADR_CHARACTERS_TABLE . "
                        SET character_xp = character_xp + $exp ,
                                character_victories_pvp = character_victories_pvp + 1
                        WHERE character_id = $dest ";
                if( !($result = $db->sql_query($sql)) )
                {
                        message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
                }

                $sql = " UPDATE  " . ADR_CHARACTERS_TABLE . "
                        SET character_defeats_pvp = character_defeats_pvp + 1
                        WHERE character_id = $user_id ";
                if( !($result = $db->sql_query($sql)) )
                {
                        message_die(GENERAL_ERROR, 'Could not update character', '', __LINE__, __FILE__, $sql);
                }

                if ( $opponent_pm_me )
                {
                        $subject = $lang['Adr_pvp_won'];
                        $message = sprintf($lang['Adr_pvp_won_by'] , $current_dmg , $current_infos['character_name'], $exp , $reward , get_reward_name());

                        adr_send_pm ( $dest , $subject  , $message );
                }


                $message = sprintf( $lang['Adr_battle_pvp_lost'] , $current_dmg );
                $message .= '<br /><br />'.sprintf($lang['Adr_battle_temple'] ,"<a href=\"" . 'adr_TownMap_Temple.'.$phpEx . "\">", "</a>") ;
                $message .= '<br /><br />'.sprintf($lang['Adr_pvp_return'] ,"<a href=\"" . 'adr_character.'.$phpEx . "\">", "</a>") ;
                message_die ( GENERAL_MESSAGE , $message );

        }

        // End the turn of the user
        $sql = " UPDATE  " . ADR_BATTLE_PVP_TABLE . "
                SET battle_turn = $dest
                WHERE battle_id = $battle_id
                AND battle_result = 3 ";
        if( !($result = $db->sql_query($sql)) )
        {
                message_die(GENERAL_ERROR, 'Could not update battle list', '', __LINE__, __FILE__, $sql);
        }

        if ( $opponent_pm_me )
        {
                $subject = $lang['Adr_pvp_turn'];
                $message = sprintf($lang['Adr_pvp_turn_by'] , $current_infos['character_name']);

                adr_send_pm ( $dest , $subject  , $message );
        }
}


// Select the battle text again
$sql = " SELECT battle_text , battle_text_chat , battle_turn FROM " . ADR_BATTLE_PVP_TABLE . "
        WHERE battle_result = 3
        AND ( battle_opponent_id = $user_id	OR battle_challenger_id = $user_id )
        AND battle_id = $battle_id ";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
}
$battle = $db->sql_fetchrow($result);

if ( $battle['battle_turn'] == $user_id )
{
$template->assign_block_vars('pvp',array());

// Get the users infos
$sql = "SELECT user_avatar , user_avatar_type, user_allowavatar FROM " . USERS_TABLE . "
        WHERE user_id = $dest ";
if( !($result = $db->sql_query($sql)) )
{
        message_die(GENERAL_ERROR, 'Could not query user', '', __LINE__, __FILE__, $sql);
}
$challenger = $db->sql_fetchrow($result);

$opponent_avatar_img = '';
if ( $challenger['user_avatar_type'] && $challenger['user_allowavatar'] )
{
        switch( $challenger['user_avatar_type'] )
        {
                case USER_AVATAR_UPLOAD:
                        $opponent_avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
                        break;
                case USER_AVATAR_REMOTE:
                        $opponent_avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
                        break;
                case USER_AVATAR_GALLERY:
                        $opponent_avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
                        break;
        }
}

$sql = "SELECT c.character_level , u.user_avatar , u.user_avatar_type, u.user_allowavatar FROM " . USERS_TABLE . " u , " . ADR_CHARACTERS_TABLE . " c
        WHERE u.user_id = $user_id
        AND c.character_id = u.user_id ";
if( !($result = $db->sql_query($sql)) )
{
        message_die(GENERAL_ERROR, 'Could not query user', '', __LINE__, __FILE__, $sql);
}
$challenger = $db->sql_fetchrow($result);

$current_avatar_img = '';
if ( $challenger['user_avatar_type'] && $challenger['user_allowavatar'] )
{
        switch( $challenger['user_avatar_type'] )
        {
                case USER_AVATAR_UPLOAD:
                        $current_avatar_img = ( $board_config['allow_avatar_upload'] ) ? '<img src="' . $board_config['avatar_path'] . '/' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
                        break;
                case USER_AVATAR_REMOTE:
                        $current_avatar_img = ( $board_config['allow_avatar_remote'] ) ? '<img src="' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
                        break;
                case USER_AVATAR_GALLERY:
                        $current_avatar_img = ( $board_config['allow_avatar_local'] ) ? '<img src="' . $board_config['avatar_gallery_path'] . '/' . $challenger['user_avatar'] . '" alt="" border="0" />' : '';
                        break;
        }
}


// First select the available items
$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_in_shop = '0'
		$item_sql
		AND item_duration > '0'
		AND item_in_warehouse = '0'
		AND item_monster_thief = '0'
		AND (item_bought_timestamp < '".$battle_pvp['battle_start']."' OR item_bought_timestamp = '0')
        AND item_owner_id = '$user_id'";
if(!($result = $db->sql_query($sql))){
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);}
$items = $db->sql_fetchrowset($result);

// Prepare the items list
$weapon_list = '<select name="item_weapon">';
$weapon_list .= '<option value = "0" >' . $lang['Adr_battle_no_weapon'] . '</option>';
$spell_list = '<select name="item_spell">';
$spell_list .= '<option value = "0" >' . $lang['Adr_battle_no_spell'] . '</option>';
$potion_list = '<select name="item_potion">';
$potion_list .= '<option value = "0" >' . $lang['Adr_battle_no_potion'] . '</option>'; 

for ( $i = 0, $i_count = count($items) ; $i < $i_count ; $i ++ )  
{
	$item_power = $items[$i]['item_power'] + $items[$i]['item_add_power']; 

	  if ( ( $items[$i]['item_type_use'] ==  5 || $items[$i]['item_type_use'] ==  6 ) && ( $items[$i]['item_mp_use'] <= $current_mp ) )
        {
                $weapon_selected = ( $HTTP_POST_VARS['item_weapon'] == $items[$i]['item_id'] ) ? 'selected' : '';
		    $weapon_list .= '<option value = "'.$items[$i]['item_id'].'" '.$weapon_selected.'>' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>'; 
        }
        else if ( ( $items[$i]['item_type_use'] == 11 ||  $items[$i]['item_type_use'] == 12 ) && ( $items[$i]['item_power'] <= $current_mp ) )
        {
                $spell_selected = ( $HTTP_POST_VARS['item_spell'] == $items[$i]['item_id'] ) ? 'selected' : '';
                $spell_list .= '<option value = "'.$items[$i]['item_id'].'" '.$spell_selected.' >' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
        }
        else if ( $items[$i]['item_type_use'] == 15 || $items[$i]['item_type_use'] == 16 || $items[$i]['item_type_use'] == 19 )
        {
                $potion_selected = ( $HTTP_POST_VARS['item_potion'] == $items[$i]['item_id'] ) ? 'selected' : '';
                $potion_list .= '<option value = "'.$items[$i]['item_id'].'" '.$potion_selected.' >' . adr_get_lang($items[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $item_power . ' - ' . $lang['Adr_items_duration'] . ' : ' . $items[$i]['item_duration'] . ' )'.'</option>';
        }
}

$weapon_list .= '</select>';
$spell_list .= '</select>';
$potion_list .= '</select>';
}

##=== START: custom taunt list ===##
$level_list = '<select name="taunt">';
$level_list .= '<option value="">'.$lang['Adr_pvp_taunt_none'].'</option>';
$level_list .= '<option value="'.$lang['Adr_pvp_taunt_1'].'">'.$lang['Adr_pvp_taunt_1'].'</option>';
$level_list .= '<option value="'.$lang['Adr_pvp_taunt_2'].'">'.$lang['Adr_pvp_taunt_2'].'</option>';
$level_list .= '<option value="'.$lang['Adr_pvp_taunt_3'].'">'.$lang['Adr_pvp_taunt_3'].'</option>';
$level_list .= '<option value="'.$lang['Adr_pvp_taunt_4'].'">'.$lang['Adr_pvp_taunt_4'].'</option>';
$level_list .= '<option value="'.$lang['Adr_pvp_taunt_5'].'">'.$lang['Adr_pvp_taunt_5'].'</option>';
$level_list .= '<option value="'.$lang['Adr_pvp_taunt_6'].'">'.$lang['Adr_pvp_taunt_6'].'</option>';
$level_list .= '<option value="'.$lang['Adr_pvp_taunt_7'].'">'.$lang['Adr_pvp_taunt_7'].'</option>';
$level_list .= '<option value="'.$lang['Adr_pvp_taunt_8'].'">'.$lang['Adr_pvp_taunt_8'].'</option>';
$level_list .= '<option value="'.$lang['Adr_pvp_taunt_9'].'">'.$lang['Adr_pvp_taunt_9'].'</option>';
$level_list .= '<option value="'.$lang['Adr_pvp_taunt_10'].'">'.$lang['Adr_pvp_taunt_10'].'</option>';
$level_list .= '</select>';
##=== END: custom taunt list ===##

##=== START calculate HP/MP bar width ===##
list($challenger_hp_width, $challenger_hp_empty) = adr_make_bars($current_hp, $current_hp_max, '100');
list($challenger_mp_width, $challenger_mp_empty) = adr_make_bars($current_mp, $current_mp_max, '100');
list($opponent_hp_width, $opponent_hp_empty) = adr_make_bars($opponent_hp, $opponent_hp_max, '100');
list($opponent_mp_width, $opponent_mp_empty) = adr_make_bars($opponent_mp, $opponent_mp_max, '100');
##=== END calculate HP/MP bar width ===##

##=== START: grab challenger & opponent infos ===##
$current_element_infos = adr_get_element_infos($current_element);
$current_alignment_infos = adr_get_alignment_infos($current_alignment);
$current_class_infos = adr_get_class_infos($current_class);
$opponent_element_infos = adr_get_element_infos($opponent_element);
$opponent_alignment_infos = adr_get_alignment_infos($opponent_alignment);
$opponent_class_infos = adr_get_class_infos($opponent_class);
##=== END: grab challenger & opponent infos ===##
    
// Let's sort out the start animations...
// Make table for start battle sequence...
// 0 = Standing image , 1 = Attack image
$challenger_action = 0; 
$opponent_action = 0;

// Grab user details for graphical battles...
if ( $user_id == $battle_challenger_id )
{
	$sql = "SELECT c.* , cl.class_name , cl.class_img 
		FROM  " . ADR_CHARACTERS_TABLE . " c , " . ADR_CLASSES_TABLE . " cl 
		WHERE c.character_id = $battle_challenger_id  
			AND cl.class_id = c.character_class ";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
	}	
	$row = $db->sql_fetchrow($result);
	$challenger_class = adr_get_lang($row['class_name']);

	$sql = "SELECT c.* , cl.class_name , cl.class_img 
		FROM  " . ADR_CHARACTERS_TABLE . " c , " . ADR_CLASSES_TABLE . " cl 
		WHERE c.character_id = $battle_opponent_id 
			AND cl.class_id = c.character_class ";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
	}	
	$row1 = $db->sql_fetchrow($result);
	$opponent_class = adr_get_lang($row1['class_name']);
}
else if ( $user_id == $battle_opponent_id )
{
	$sql = "SELECT c.* , cl.class_name , cl.class_img 
		FROM  " . ADR_CHARACTERS_TABLE . " c , " . ADR_CLASSES_TABLE . " cl 
		WHERE c.character_id = $battle_challenger_id  
			AND cl.class_id = c.character_class ";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
	}	
	$row1 = $db->sql_fetchrow($result);
	$opponent_class = adr_get_lang($row1['class_name']);

	$sql = "SELECT c.* , cl.class_name , cl.class_img 
		FROM  " . ADR_CHARACTERS_TABLE . " c , " . ADR_CLASSES_TABLE . " cl 
		WHERE c.character_id = $battle_opponent_id 
		AND cl.class_id = c.character_class ";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
	}	
	$row = $db->sql_fetchrow($result);
	$challenger_class = adr_get_lang($row['class_name']);
}

// Get actions!
$battle_action = "";
if ( $user_id == $battle_challenger_id )
{
	if ( $battle['battle_turn'] == $battle_pvp['battle_opponent_id'] )
	{
		$battle_action = "It's currently <b>".$opponent_name."</b>'s turn!<br><a href=\"".$file."?battle_id=".$battle_id."\">Refresh</a>";
	}
	else
	{
		$battle_action = "It's currently your turn to strike!";
	}
}

if ( $user_id == $battle_opponent_id )
{
	if ( $battle['battle_turn'] == $battle_pvp['battle_challenger_id'] )
	{
		$battle_action = "It's currently <b>".$opponent_name."</b>'s turn!<br><a href=\"".$file."?battle_id=".$battle_id."\">Refresh</a>";
	}
	else
	{
		$battle_action = "It's currently your turn to strike!";
	}
}

/* Start: Format chat - Credit to aUsTiN*/
$format_chat = str_replace('Þ', '<tr><td class="row2"><span class="genmed"><i>', $battle['battle_text']);
$format_chat .= str_replace('þ', '</i></span></td></tr>', $format_chat);
$format_chat .= str_replace('%COLOR%orange', '', $format_chat);
$format_chat .= str_replace('%COLOR%blue', '', $format_chat);
$format_chat .= str_replace('%APOS%', '\'', $format_chat);		
/* End: Format chat */

if (!$battle_id)
	{
message_die(GENERAL_MESSAGE, '<i>No Fight Specified!</i>'); 
	}
else
{
// Grab the current battle info
$q = "SELECT username, user_id
	  FROM ". USERS_TABLE ."";
$r 			= $db -> sql_query($q);
$user_data 	= $db -> sql_fetchrowset($r);
$user_count = $db -> sql_numrows($r);
	
$sql = "SELECT * 
		FROM " . ADR_BATTLE_PVP_TABLE . "
		WHERE battle_id = '$battle_id'";
	if( !($result = $db->sql_query($sql)) )
		{
	message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
		}
$row 	= $db->sql_fetchrow($result);	
$log 	= $row['battle_text'];
$blue = $row['battle_challenger_id'];
$orange = $row['battle_opponent_id'];
}

$b = 0;
for($b = 0; $b < $user_count; $b++)
	{		
	if ($user_data[$b]['user_id'] == $blue)
		{			
	$new_blue = $user_data[$b]['username'];
	break;
		}
	}
		
$o = 0;
for($o = 0; $o < $user_count; $o++)
	{		
	if ($user_data[$o]['user_id'] == $orange)
		{			
	$new_orange = $user_data[$o]['username'];
	break;
		}
	}			
			
/* Start: Format chat */
$log 			= smilies_pass($log);	
$format_chat 	= str_replace('Þ', '<tr><td class="row2" align="left" width="100%"><span class="genmed"><i>', $log);
$format_chat2 	= str_replace('þ', '</i></span></td></tr>', $format_chat);
$format_chat3 	= str_replace('%APOS%', '\'', $format_chat2);
$format_chat4	= str_replace($new_orange, '<font color="orange">'. $new_orange .'</font>', $format_chat3);	
$format_chat5	= str_replace($new_blue, '<font color="blue">'. $new_blue .'</font>', $format_chat4);		
$format_chat6	= str_replace('%BSS%', '<tr><td class="row2" align="left" width="100%"><span class="genmed"><font color="red"><i>', $format_chat5);
$format_chat7	= str_replace('%BSE%', '</i></font></span></td></tr>', $format_chat6);	
$formatted		= $format_chat7;		
/* End: Format chat */

// Grab challenger details for graphical battles...
$sql = "SELECT * 
	FROM " . ADR_CHARACTERS_TABLE ." ch , " . ADR_ELEMENTS_TABLE ." e , " . ADR_ALIGNMENTS_TABLE ." a , " . ADR_CLASSES_TABLE ." c
	WHERE ch.character_id = $battle_challenger_id 
	AND e.element_id = $opponent_element 
	AND a.alignment_id = ch.character_alignment
	AND c.class_id = ch.character_class ";
if (!$result = $db->sql_query($sql)) 
{
	message_die(CRITICAL_ERROR, 'Error grabbing character details!');
}
$challenger_details = $db->sql_fetchrow($result);

// Armour set?
$armour_set = !$battle_pvp['battle_challenger_armour_set'] ? $lang['Adr_store_element_none'] : adr_get_lang($battle_pvp['battle_challenger_armour_set']);

// Grab opponent details for graphical battles...
$sql = "SELECT * 
	FROM " . ADR_CHARACTERS_TABLE ." ch , " . ADR_ELEMENTS_TABLE ." e , " . ADR_ALIGNMENTS_TABLE ." a , " . ADR_CLASSES_TABLE ." c
	WHERE ch.character_id = $battle_opponent_id 
	AND e.element_id = $opponent_element 
	AND a.alignment_id = ch.character_alignment
	AND c.class_id = ch.character_class ";
if (!$result = $db->sql_query($sql)) 
{
	message_die(CRITICAL_ERROR, 'Error grabbing character details!');
}
$opponent_details = $db->sql_fetchrow($result);

// Armour set?
$opponent_armour_set = !$battle_pvp['battle_opponent_armour_set'] ? $lang['Adr_store_element_none'] : adr_get_lang($battle_pvp['battle_opponent__armour_set']);

// Grab background details
if( !$bck_grnd_name )
{
	$bck_grnd_name = $battle_pvp['battle_bkg'];
}

// Required to prevent battles with no background image
if ( !$bck_grnd_name && !$battle_pvp['battle_bkg'] )
{
	$bck_grnd_name = "battle_bgnd_1.gif";
}

$template->assign_vars(array(
        'L_ATTRIBUTES' => $lang['Adr_battle_attributes'],
        'L_PHY_ATT' => $lang['Adr_battle_phy_att'],
        'L_PHY_DEF' => $lang['Adr_battle_phy_def'],
        'L_MAG_ATT' => $lang['Adr_battle_mag_att'],
        'L_MAG_DEF' => $lang['Adr_battle_mag_def'],
        'L_ALIGNMENT' => $lang['Adr_battle_alignment'],
        'L_ELEMENT' => $lang['Adr_battle_element'],
        'L_CLASS' => $lang['Adr_battle_class'],
        'ALIGNMENT' => adr_get_lang($current_alignment_infos['alignment_name']),
        'ELEMENT' => adr_get_lang($current_element_infos['element_name']),
        'CHALLENGER_CLASS' => adr_get_lang($current_class_infos['class_name']),
        'M_ATT' => $current_ma,
        'M_DEF' => $current_md,
        'OPPONENT_ALIGNMENT' => adr_get_lang($opponent_alignment_infos['alignment_name']),
        'OPPONENT_ELEMENT' => adr_get_lang($opponent_element_infos['element_name']),
        'OPPONENT_CLASS' => adr_get_lang($opponent_class_infos['class_name']),
        'OPPONENT_M_ATT' => $opponent_ma,
        'OPPONENT_M_DEF' => $opponent_md,
        'HP_EMPTY' => $challenger_hp_empty,
        'MP_EMPTY' => $challenger_mp_empty,
        'OPPONENT_HP_EMPTY' => $opponent_hp_empty,
        'OPPONENT_MP_EMPTY' => $opponent_mp_empty,
        'TAUNT_LIST' => $level_list,
        'L_COMMS' => $lang['Adr_pvp_comms'],
        'L_TYPE_HERE' => $lang['Adr_pvp_custom_taunt'],
        'L_CUSTOM_SENTANCE' => $lang['Adr_pvp_taunt'],
        'S_CHATBOX' => append_sid("adr_battle_pvp_chatbox.$phpEx?battle_id=".$battle_id),
        'ATTACK' => $weapon_list,
        'SPELL' => $spell_list,
        'POTION' => $potion_list,
        'NAME' => $current_name,
        'AVATAR_IMG' => $current_avatar_img,
        'OPPONENT_NAME' => $opponent_name,
        'OPPONENT_IMG' => $opponent_avatar_img,
        'BATTLE_TEXT' => $battle_text,
        'BATTLE_CHAT' => $battle_text_chat,
        'HP' => $current_hp,
        'MP' => $current_mp,
        'HP_MAX' => $current_hp_max,
        'MP_MAX' => $current_mp_max,
        'HP_WIDTH' => $challenger_hp_width,
        'MP_WIDTH' => $challenger_mp_width,
        'ATT' => $current_att,
        'DEF' => $current_def,
        'OPPONENT_HP' => $opponent_hp,
        'OPPONENT_MP' => $opponent_mp,
        'OPPONENT_HP_MAX' => $opponent_hp_max,
        'OPPONENT_MP_MAX' => $opponent_mp_max,
        'OPPONENT_HP_WIDTH' => $opponent_hp_width,
        'OPPONENT_MP_WIDTH' => $opponent_mp_width,
        'OPPONENT_ATT' => $opponent_att,
        'OPPONENT_DEF' => $opponent_def,
		// START Graphical sequences
        'M_ATT' => $current_ma,
        'M_DEF' => $current_md,
        'ALIGNMENT' => adr_get_lang($challenger_details['alignment_name']),
        'ELEMENT' => adr_get_lang($challenger_details['element_name']),
        'ARMOUR_SET' => adr_get_lang($armour_set),
        'OPPONENT_M_ATT' => $opponent_ma,
        'OPPONENT_M_DEF' => $opponent_md,
        'OPPONENT_ALIGNMENT' => adr_get_lang($opponent_details['alignment_name']),
        'OPPONENT_ELEMENT' => adr_get_lang($opponent_details['element_name']),
        'OPPONENT_ARMOUR_SET' => adr_get_lang($opponent_armour_set),
	'L_TYPE_HERE' => $lang['Adr_pvp_custom_taunt'],
	'LOG' => $formatted,
	'L_CUSTOM_SENTANCE' => $lang['Adr_pvp_taunt'],
	'L_COMMS' => $lang['Adr_pvp_comms'],
	'S_PVP_BATTLE' => append_sid("adr_battle_pvp.$phpEx?battle_id=".$battle_id),
	'BATTLE_ACTION' => $battle_action,
	'CHALLENGER_ACTION' => $challenger_action,
	'OPPONENT_ACTION' => $opponent_action,
	'CHALLENGER_CLASS' => $challenger_class,
	'OPPONENT_CLASS' => $opponent_class,
	'RANDOM_BKG' => $battle_background,
	'TAUNT_SYSTEM' => $tauntsystem,
	'L_NO_TAUNT' => $lang['Adr_pvp_taunt_none'],
	'L_TAUNT_1' => $lang['Adr_pvp_taunt_1'],
	'L_TAUNT_2' => $lang['Adr_pvp_taunt_2'],
	'L_TAUNT_3' => $lang['Adr_pvp_taunt_3'],
	'L_TAUNT_4' => $lang['Adr_pvp_taunt_4'],
	'L_TAUNT_5' => $lang['Adr_pvp_taunt_5'],
	'L_TAUNT_6' => $lang['Adr_pvp_taunt_6'],
	'L_TAUNT_7' => $lang['Adr_pvp_taunt_7'],
	'L_TAUNT_8' => $lang['Adr_pvp_taunt_8'],
	'L_TAUNT_9' => $lang['Adr_pvp_taunt_9'],
	'L_TAUNT_10' => $lang['Adr_pvp_taunt_10'],
		// END Graphical sequences
    'L_HP'=> $lang['Adr_character_health'],
    'L_MP' => $lang['Adr_character_magic'],
    'L_ATT' => $lang['Adr_attack'],
    'L_DEF' => $lang['Adr_defense'],
    'L_ATTACK' => $lang['Adr_attack_opponent'],
    'L_POTION' => $lang['Adr_potion_opponent'],
    'L_DEFEND' => $lang['Adr_defend_opponent'],
    'L_FLEE' => $lang['Adr_flee_opponent'],
    'L_SPELL' => $lang['Adr_spell_opponent'],
    'L_ACTIONS' => $lang['Adr_actions_opponent'],
    'L_BATTLE_CHAT' => $lang['Adr_pvp_battle_chat'],
    'S_PVP_ACTION' => append_sid("adr_battle_pvp.$phpEx?battle_id=".$battle_id),
	'L_BATTLE_REFRESH' => $lang['Adr_pvp_refresh_page'],
));



include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);


?>