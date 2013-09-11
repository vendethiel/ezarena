<?php 
/***************************************************************************
 *                                 
 *                            -------------------
 *	begin			: 21/09/2004
 *	copyright		: 
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
 ***************************************************************************/

// The following check must be at the start of all scripts to stop direct
// access to the script
//if ( !defined('IN_PHPBB') )
//{
//	die("Hacking attempt");
//}

define('IN_PHPBB', true); 
define('IN_ADR_SHOPS', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_BATTLE', true);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 
// End session management
//

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

$user_id = $userdata['user_id'];

// Includes the tpl and the header
adr_template_file('adr_spell_cast_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// General script config options
$adr_general = adr_get_general_config();
$adr_user = adr_get_user_infos($user_id);

adr_battle_cell_check($user_id, $userdata);

// Fix values
$cast_spell = $_POST['cast_upon'];
$to_member_id = $_POST['cast'];
$spell_id = $_GET['spell_id'];

// Check to see if spell can be cast on others
//$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . " 
//	WHERE spell_owner_id = $user_id
//	AND spell_id = $spell_id
//	LIMIT 1";
//if( !($result = $db->sql_query($sql)) )
//{
//	adr_previous( Adr_shop_items_failure_deleted , adr_spellbook , '');
//}

// Show user list
$sql = "SELECT u.user_id , u.username , c.* FROM " . USERS_TABLE . " u , " . ADR_CHARACTERS_TABLE . " c
	WHERE u.user_id = c.character_id 
	AND c.character_hp < c.character_hp_max
	AND c.character_hp > 0
	ORDER by u.username ";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain user list', '', __LINE__, __FILE__, $sql);
}
$users = $db->sql_fetchrowset($result);

$chars_list = '<select name="cast">';
$chars_list .= '<option value = "0" >Select member:</option>';
for ( $i = 0 ; $i < count($users) ; $i ++)
{
	$chars_list .= '<option value = "'.$users[$i]['user_id'].'" >' . $users[$i]['character_name'] . '&nbsp;(&nbsp;HP:&nbsp;' . $users[$i]['character_hp'] . '/' . $users[$i]['character_hp_max'] . '&nbsp;-&nbsp;MP:&nbsp;' . $users[$i]['character_mp'] . '/' . $users[$i]['character_mp_max'] . '&nbsp;-&nbsp;' . $lang['Adr_character_level'] . ':&nbsp;' . $users[$i]['character_level'] . '&nbsp;)&nbsp;</option>';
}
$chars_list .= '</select>';


if ( $cast_spell )
{

	// Get other char info
	$other_member = adr_get_user_infos($to_member_id);

	// Get spell info
       	$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . " 
		WHERE spell_owner_id = $user_id
		AND spell_original_id = $spell_id
		LIMIT 1";
	if( !($result = $db->sql_query($sql)) )
	{
		adr_previous( Adr_shop_items_failure_deleted , adr_spellbook , '');
	}
   	$item = $db->sql_fetchrow($result);

	$spell_skill = $item['item_type_use'];
	$power = 0;

	// Spell components check
	if (($item['spell_items_req'] !='') && ($item['spell_items_req'] !='0'))
	{
		adr_spell_check_components($spell_id, $user_id, 'adr_spellbook');
	}

	// MP check
	if ( $adr_user['character_mp'] < ($item['spell_mp_use'] + $item['spell_power']) || $adr_user['character_mp'] < 0 ) 
	{	
		adr_previous ( Adr_battle_check_two , 'adr_spellbook' , '' );
	}

	$power = (($item['spell_power'] * 1.2) + $item['spell_add_power']);
	$mp_usage = ($item['spell_mp_use'] + $item['spell_power']);

	if ( $mp_usage == '' )
	{
		adr_previous ( Adr_battle_check , 'adr_spellbook' , '' );				
	}

	// Check if target is in combat
	$sql = " SELECT * FROM " . ADR_BATTLE_LIST_TABLE . " 
		WHERE battle_challenger_id = $to_member_id
		AND battle_result = 0
		AND battle_type = 1 ";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	}
	$bat = $db->sql_fetchrow($result);

	if ( is_numeric($bat['battle_id']) )
	{
		adr_previous( Adr_spells_target_battle , adr_spellbook , '' );
	}

	// Check if other person is alive
	if ( $other_member['character_hp'] < 1 )
	{
		adr_previous( Adr_spells_target_dead , adr_spellbook , '' );
	}

	// Check if target is in the same zone
//	if($adr_user['character_area'] != $other_member['character_area'])
//	{
//		adr_previous( Adr_spells_wrong_place, adr_spellbook , '');
//	}

	// Subtract the magic points
	spell_remove_mp( $user_id , $mp_usage , 0 );

	// Use the item
	adr_use_item($spell_id , $user_id);

	// Healing spell
	if($spell_skill == '108')
	{
		$attbonus = 0;
		$attbonus = adr_weapon_skill_check($user_id , $bonus_hit);
		$power = ceil($power * $attbonus);

		if($code = $item['spell_xtreme'])
		{
			eval($code);
			message_die ( GENERAL_MESSAGE , $message );
		}
		else
		{

			// Check if other person is already at full health
			if ( $other_member['character_hp'] >= $other_member['character_hp_max'] )
			{
				adr_previous( Adr_spells_target_health_full , adr_spellbook , '' );
			}

			// Check if other user goes over max_hp with spell
			$hp_heal = (( $power + $other_member['character_hp']) > $other_member['character_hp_max']) ? $other_member['character_hp_max'] - $other_member['character_hp'] : $power ;

			// Restore HP
			spell_add_hp_to_member( $to_member_id , $hp_heal , 0 );

			if ($adr_general['spell_enable_pm'] == '1')
			{	
				// Notify other user of heal
				$subject = $lang['Adr_spells_heal_pm_title'];
				$message = sprintf($lang['Adr_spells_heal_pm_text'] , $adr_user['character_name'] , $hp_heal);

				if($to_member_id != $user_id)
				{
					adr_send_pm ( $to_member_id , $subject  , $message );
				}
			}

			$direction = append_sid("adr_spellbook.$phpEx");
			$message = sprintf($lang['Adr_spells_heal_cast'], $item['spell_name'], $other_member['character_name'], $hp_heal);
			$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;

			message_die ( GENERAL_MESSAGE , $message );
		}
	}
	// Defensive spell
	else if($spell_skill == '109')
	{
		$attbonus = 0;
		$attbonus = adr_weapon_skill_check($user_id , $bonus_hit);
		$power = ceil($power * $attbonus);

		if($code = $item['spell_xtreme'])
		{
			eval($code);
			message_die (GENERAL_MESSAGE, $message);
		}
		else
		{
			if ($other_member['character_spell_pre_effects'] == '' || $other_member['character_spell_pre_effects'] == NULL || $other_member['character_spell_pre_effects'] == '0')
			{
				// Define standard effects
				$effects ="ATT:$power:DEF:$power";

				$sql = "UPDATE " . ADR_CHARACTERS_TABLE ."
					SET character_spell_pre_effects = '$effects'
					WHERE character_id = $to_member_id  ";
				if (!$result = $db->sql_query($sql)) 
					message_die(CRITICAL_ERROR, 'Error updating ADR character spell pre-effects!');

				if ($adr_general['spell_enable_pm'] == '1')
				{	
					// Notify other user
					$subject = $lang['Adr_lang_cast_boost_pm_title'];
					$message = sprintf($lang['Adr_lang_cast_boost_pm_text'], $adr_user['character_name'], $item['spell_name']);

					if($to_member_id != $user_id)
					{
						adr_send_pm ( $to_member_id , $subject  , $message );
					}
				}

				$direction = append_sid("adr_spellbook.$phpEx");
				$message = sprintf($lang['Adr_spells_cast_boost_success'], $item['spell_name'], $other_member['character_name']);
				$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;

				message_die ( GENERAL_MESSAGE , $message );
			}
			else
			{
				$direction = append_sid("adr_spellbook.$phpEx");
				$message = sprintf($lang['Adr_spells_cast_already'], $other_member['character_name']);
				$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;

				message_die ( GENERAL_MESSAGE , $message );
			}
		}
	}
}

else
{

	$template->assign_vars(array(
		'SELECT_CHARACTER' => $chars_list,
		'L_SPELLS_MP' => sprintf($lang['Adr_spells_cast_mp'], $adr_user['character_mp']),
		'L_SCRIPT_TITLE' => $lang['Adr_spells_target_select'],
		'L_CAST_TYPE' => $lang['Adr_spells_cast'],
		'S_CHARACTER_ACTION' => append_sid("adr_spell_cast.$phpEx?spell_id=$spell_id"),
	));
}


include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 