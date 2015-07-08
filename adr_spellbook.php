<?php 
/***************************************************************************
 *					adr_spellbook.php
 *				------------------------
 *	begin 			: 28/12/2005
 *	copyright			: Himmelweiss
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
define('IN_ADR_SHOPS', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_BATTLE', true);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_spellbook';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 
// End session management
//

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_spellbook_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get userdata
$user_id = $userdata['user_id'];

// Get the general config
$adr_general = adr_get_general_config();
$adr_user = adr_get_user_infos($user_id);

//adr_battle_cell_check($user_id, $userdata);

if( isset($_POST['view_spells_skill']) || isset($_GET['view_spells_skill']) )
{
	$view_spells_skill = ( isset($_POST['view_spells_skill']) ) ? $_POST['view_spells_skill'] : $_GET['view_spells_skill'];
	$view_spells_skill = htmlspecialchars($view_spells_skill);	
}
else
{
	$view_spells_skill = "";
}

if ( $view_spells_skill != "" )
{
	switch($view_spells_skill)
	{
		// V: I removed the "known_spells" part of the URL. what is that even supposed to do??
		case 'evocation' :
			$current_skill_id = 107;
			$recipebook_skill_links = '<br /><img src="adr/images/misc/evocation2.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=evocation\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/healing.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=healing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/abjuration.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=abjuration\'" onMouseOver="this.style.cursor=\'pointer\';">';
			$recipebook_action = append_sid("adr_spellbook.$phpEx?view_spells_skill=evocation");
			$spell_skill = $lang['Adr_spells_skill_evocation'];
		break;
		case 'healing' :
			$current_skill_id = 108;
			$recipebook_skill_links = '<br /><img src="adr/images/misc/evocation.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=evocation\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/healing2.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=healing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/abjuration.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=abjuration\'" onMouseOver="this.style.cursor=\'pointer\';">';
			$recipebook_action = append_sid("adr_spellbook.$phpEx?view_spells_skill=healing");
			$spell_skill = $lang['Adr_spells_skill_healing'];
		break;
		case 'abjuration' :
			$current_skill_id = 109;
			$recipebook_skill_links = '<br /><img src="adr/images/misc/evocation.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=evocation\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/healing.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=healing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/abjuration2.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=abjuration\'" onMouseOver="this.style.cursor=\'pointer\';">';
			$recipebook_action = append_sid("adr_spellbook.$phpEx?view_spells_skill=abjuration");
			$spell_skill = $lang['Adr_spells_skill_abjuration'];
		break;
	}

	$template->assign_block_vars('view_spells',array());

	$known_spells = ( isset($_REQUEST['known_spells']) ) ? trim($_REQUEST['known_spells']) : '';

	$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . "
		WHERE spell_owner_id = $user_id
		AND item_type_use = '$current_skill_id'
		ORDER BY spell_power
		";
	$result = $db->sql_query($sql);
	if( !$result )
        message_die(GENERAL_ERROR, 'Could not obtain owners spells information', "", __LINE__, __FILE__, $sql);
	$spells = $db->sql_fetchrowset($result);
	$db->sql_freeresult($spells);

	$spell_list = '';
	if (count($spells) > 0)
	{
		for ($i = 0; $i < count($spells);$i++)
			$owner_spells .= ( $owner_spells == '' ) ? $spells[$i]['spell_original_id'] : ':'.$spells[$i]['spell_original_id'];
		
		$original_spells = explode(':',$owner_spells);
		
		$spell_list .= '<select name="known_spells" size="4" style="width:320px;overflow:hidden;background-color:#e7d3c1;" ONCHANGE="document.list_spells.submit()">';
		for ($a = 0; $a < count($original_spells); $a++)
		{
			$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . "
				WHERE spell_owner_id = 1
				AND spell_id = ".$original_spells[$a]." 
				ORDER BY spell_power, spell_name
				";
			$result = $db->sql_query($sql);
			if( !$result )
		        message_die(GENERAL_ERROR, 'Could not obtain original spell information', "", __LINE__, __FILE__, $sql);
			$original_spell = $db->sql_fetchrow($result);
			
			if ($original_spells[$a] == $existing_spell)
				$selected_spell = 'selected';
			$spell_list .= '<option value = "'.$original_spells[$a].'" '.$selected_spell.'>Level: '.$original_spell['spell_power'].' - '.$original_spell['spell_name'].'</option>';
			$selected_spell = '';
		}
		$spell_list .= '</select>';
		
		if ($existing_spell != 0 && $existing_spell != '')
		{
			//get spell info
			$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . "
				WHERE spell_owner_id = 1
				AND spell_id = ".$existing_spell;
			$result = $db->sql_query($sql);
			if( !$result )
		        message_die(GENERAL_ERROR, 'Could not obtain original spell information', "", __LINE__, __FILE__, $sql);
			$spell_data = $db->sql_fetchrow($result);
/*						
			//get the potion info
			$sql_p = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . "
				WHERE item_owner_id = 1
				AND item_id = ".$spell_data['item_recipe_linked_item'];
			$result_p = $db->sql_query($sql_p);
			if( !$result_p )
		        message_die(GENERAL_ERROR, 'Could not obtain original spell information', "", __LINE__, __FILE__, $sql_p);
			$result_data = $db->sql_fetchrow($result_p);

			//generate effects list of the spell
			$effects_list = array();
			$effects_list = explode(':',$spell_data['item_effect']);
			$effects_print_list = '';
			$stats = array('','HP','MP','AC','STR','DEX','CON','INT','WIS','CHA','MA','MD','EXP','GOLD','SP','BATTLES_REM','SKILLUSE_REM','TRADINGSKILL_REM','THEFTSKILL_REM','LEVEL');
			for ($i = 0; $i < count($effects_list);$i++)
			{
				if(array_search($effects_list[$i],$stats)) {
					$effects_print_list .= $effects_list[$i].": ".$effects_list[$i+1];
					if($effects_list[$i+3]==0)
						$effects_print_list .= '';
					else
						$effects_print_list .= ' (Target Monster)';
					if($effects_list[$i+5]==0)
						$effects_print_list .= ' (TEMP Effect)';
					else
						$effects_print_list .= ' (PERM Effect)';
					$effects_print_list .= '<br />';
				}
			}
*/
			//generate items required print_list
			$items_req = explode(':',$spell_data['spell_items_req']);

			//Check if spell can be cast
			if($spell_data['spell_battle'] == '1' || $spell_data['spell_battle'] == '2')
			{
				$cast_spell = "<a href=\"adr_spell_cast.$phpEx?spell_id=$existing_spell\">Cast Spell</a>";
//							$cast_spell = "<br /><input type=\"submit\" name=\"cast_spell\" value=\"Cast Spell\" class=\"mainoption\" onclick=\"location=\'adr_spell_cast.'.$phpEx.'?spell_id='.$existing_spell.'\'" />";
			}

			if(($spell_data['spell_items_req'] !='0') && ($spell_data['spell_items_req'] !=''))
			{
				$items_req_print = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
				for ($i = 0; $i < count($items_req); $i++)
				{
					$switch = ( !($i % 2) ) ? $get_info=1 : $get_info=0;
					if ($get_info == 1) {
						$sql_info = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
							where item_id = ".$items_req[$i];
						$result_info = $db->sql_query($sql_info);
						if( !$result_info )
						{
							message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql_info);
						}
						$item_info = $db->sql_fetchrow($result_info);
						$items_req_print .= '<tr><td style="font-family:\'serif\'">'.$item_info['item_name'].'</td><td><img src="adr/images/items/'.$item_info['item_icon'].'"></td>';
					}
					else {
						$items_req_print .= '<td>(x'.$items_req[$i].')</td></tr>';
					}
				}
				$items_req_print .= '</table>';
			}

			else
			{
				$items_req_print = 'None';
			}
			
			$template->assign_block_vars('view_spells.spell', array(
				"RECIPE_IMG" => $spell_data['spell_icon'],
				"RECIPE_NAME" => $spell_data['spell_name'],
				"RECIPE_LEVEL" => $spell_data['spell_power'],
				"RECIPE_DESC" => $spell_data['spell_desc'],
//							"RECIPE_PRICE" => $spell_data['item_price'],
//							"RECIPE_WEIGHT" => $spell_data['item_weight'],
//							"RECIPE_EFFECT" => $effects_print_list,
				"RECIPE_ITEMS_REQ" => $items_req_print,
//							"L_RECIPE_ITEMS_REQ" => $lang['Adr_recipes_items_req'],
//							"RESULT_NAME" => $result_data['item_name'],
//							"RESULT_IMG" => $result_data['item_icon'],
//							"RESULT_LEVEL" => $result_data['item_power'],
//							"RESULT_DESC" => $result_data['item_desc'],
//							"RESULT_EFFECTS" => $effects_print_list,
//							"RESULT_PRICE" => $result_data['item_price'],
//							"RESULT_WEIGHT" => $result_data['item_weight'],
//							"RESULT_DURATION" => $result_data['item_duration'],
//							"RESULT_DURATION_MAX" => $result_data['item_duration_max'],
				"CAST_SPELL" => $cast_spell,
			));
		}
	}

	$template->assign_vars(array(
		'RECIPE_LIST'=> $spell_list,
		'RECIPEBOOK_SKILL_LINKS' => $recipebook_skill_links,
		'S_RECIPEBOOK_ACTION'=> $recipebook_action,
		'L_SPELL_SKILL' => $spell_skill,
		'L_RECIPE_STATS' => $lang['recipe_stats'],
		'L_PRODUCT_EFFECTS' => $lang['potion_effects'],
		'L_PRODUCT_STATS' => $lang['potion_stats'],
	));

}
else
{
	$template->assign_block_vars('main',array());

	$template->assign_vars(array(
		'RECIPEBOOK_SKILL_LINKS' => '<br /><img src="adr/images/misc/evocation.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=evocation\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/healing.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=healing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/abjuration.jpg" onclick="location=\'adr_spellbook.'.$phpEx.'?view_spells_skill=abjuration\'" onMouseOver="this.style.cursor=\'pointer\';">',
		'S_RECIPEBOOK_ACTION'=> append_sid("adr_spellbook.$phpEx"),
	));
}

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
