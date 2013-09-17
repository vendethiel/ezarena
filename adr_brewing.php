<?php 
/***************************************************************************
 *					adr_brewing.php
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
define('IN_ADR_BREWING', true);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_recipebook';

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
	$redirect = "adr_house_of_wonders.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_brewing_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();

// Get userdata
$user_id = $userdata['user_id'];

// Get the general config
$adr_general = adr_get_general_config();

// Grab details for skill limit and brewing skill
$sql = " SELECT character_skill_limit, character_skill_brewing, character_level, character_area FROM " . ADR_CHARACTERS_TABLE . "
		WHERE character_id = $user_id ";
if( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not query skill limit value', '', __LINE__, __FILE__, $sql);
}
$char = $db->sql_fetchrow($result);

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

$actual_zone = $char['character_area'];

$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_id = $actual_zone ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$info = $db->sql_fetchrow($result);
$access = $info['zone_brewing'];

if ( $access == '0' )
	adr_previous( Adr_zone_building_noaccess , adr_zones , '' );

//set colors
$color_impossible = '#dd02eb'; //Impossible
$color_very_hard = '#FF0000'; //Very Hard
$color_hard = '#0099FF'; //Hard
$color_normal = '#00FF00'; //Normal
$color_easy = '#FFFFFF'; //Easy
$color_very_easy = '#8f8f8f'; // Very Easy
$color_enough = '#00FF00'; //enough items
$color_not_enough = '#FF0000'; //not enough items


if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);	
}
else
{
	$mode = "";
}

if ( $mode != "" )
{
	switch($mode)
	{
		case 'craft' :
			$tool = intval($HTTP_POST_VARS['item_tool']);
			$recipe_id = intval($HTTP_POST_VARS['recipe_id']);

			//get original recipe information
			$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_owner_id = 1
				AND item_original_recipe_id = $recipe_id
				";
			$result = $db->sql_query($sql);
			if( !$result )
			       message_die(GENERAL_ERROR, 'Could not obtain owners recipes information', "", __LINE__, __FILE__, $sql);
			$original_recipe = $db->sql_fetchrow($result);

			//get original (up-to-date) potion info now
			$sql_potion = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_id = " . $original_recipe['item_recipe_linked_item'] . "
				AND item_owner_id = 1
				";
			$result_potion = $db->sql_query($sql_potion);
			if( !$result_potion )
				message_die(GENERAL_ERROR, "Couldn't select recipe info", "", __LINE__, __FILE__, $sql_potion);
			$potion_data = $db->sql_fetchrow($result_potion);

			$items_req = explode(':',$potion_data['item_brewing_items_req']);

			for ($i = 0; $i < count($items_req); $i++)
			{
				$switch = ( !($i % 2) ) ? $check_item=0 : $check_item=1;
				if ($check_item == 1) 
				{
					//get item info
					$sql_info = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
						where item_id = ".$items_req[$i-1];
					$result_info = $db->sql_query($sql_info);
					if( !$result_info )
						message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql_info);
					$item_info = $db->sql_fetchrow($result_info);
					
					//check the amount in user inventory of each needed item
					$req_item_name = str_replace("'","\'",$item_info['item_name']);
					$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_ITEMS_TABLE . "
						WHERE item_owner_id = $user_id
						AND item_name = '".$req_item_name."'
						AND item_in_warehouse = 0
						AND item_in_shop = 0
						AND item_duration > 0
						";
					$result = $db->sql_query($sql);
					if( !$result )
				        message_die(GENERAL_ERROR, 'Could not obtain total amount of the needed item', "", __LINE__, __FILE__, $sql);
					$total = $db->sql_fetchrow($result);
					
					if ($total['total'] < $items_req[$i])
						adr_previous ( brewing_missing_item , adr_brewing , "mode=view&amp;known_recipes=".$recipe_id."&amp;item_tool=".$tool."" ); 
				}
			}
			
			
			// No tool
			if ( !$tool )
			{
				adr_previous ( brewing_tool_needed , adr_brewing , "mode=view&known_recipes=".$recipe_id."&item_tool=".$tool."" );
			}
			else
			{	
				$new_item_id = adr_use_skill($user_id , $tool, $recipe_id, 7, brewing);
				if ( !$new_item_id )
				{
					adr_previous ( brewing_failure , adr_brewing , "mode=view&known_recipes=".$recipe_id."&item_tool=".$tool."" );
				}
				elseif (strlen($new_item_id) > 15)
				{
					$direction = append_sid("adr_brewing.$phpEx?mode=view&known_recipes=".$recipe_id."&item_tool=".$tool."");
					$new_item_id .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;
					message_die ( GENERAL_MESSAGE , $new_item_id );
				}
				else
				{
					$sql = " SELECT item_name , item_price FROM " . ADR_SHOPS_ITEMS_TABLE . "
						WHERE item_owner_id = $user_id 
						AND item_in_warehouse = 0
						AND item_id = $new_item_id ";
					if ( !($result = $db->sql_query($sql)))
						message_die(GENERAL_ERROR, 'Could not check user tools',"", __LINE__, __FILE__, $sql);
					$new_item = $db->sql_fetchrow($result);
					
					$direction = append_sid("adr_brewing.$phpEx?mode=view&known_recipes=".$recipe_id."&item_tool=".$tool."");
					$message = sprintf($lang['brewing_success'] , adr_get_lang($new_item['item_name']) , $new_item['item_price'] , get_reward_name() );
					$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>") ;
					
					message_die ( GENERAL_MESSAGE , $message );
				}
			}
			
		break;

		case 'view':
			$template->assign_block_vars('recipe',array());

			$existing_recipe = ( isset($HTTP_POST_VARS['known_recipes']) ) ? trim($HTTP_POST_VARS['known_recipes']) : trim($HTTP_GET_VARS['known_recipes']);

			//brewing tools
			$sql = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_owner_id = $user_id
				AND item_in_shop = 0
				AND item_in_warehouse = 0
				AND item_duration > 0
				AND item_type_use = 18 ";
			if ( !($result = $db->sql_query($sql)))
				message_die(GENERAL_ERROR, 'Could not check user tools',"", __LINE__, __FILE__, $sql);
			$tools = $db->sql_fetchrowset($result);
			
			$existing_tool = ( isset($HTTP_POST_VARS['item_tool']) ) ? trim($HTTP_POST_VARS['item_tool']) : trim($HTTP_GET_VARS['item_tool']);
			
			$tool_list = '<select name="item_tool" style="background-color:#000000;color:#FFFFFF">';
			$tool_list .= '<option value = "0" >' . $lang['brewing_no_tool'] . '</option>';
			
			for ( $i = 0 ; $i < count($tools) ; $i ++ )
			{
				if ($tools[$i]['item_id'] == $existing_tool){$selected_tool = 'selected';}
				$tool_list .= '<option value = "'.$tools[$i]['item_id'].'" '.$selected_tool.'>' . adr_get_lang($tools[$i]['item_name']) . ' ( ' . $lang['Adr_items_power'] . ' : ' . $tools[$i]['item_power'] . ' - ' . $lang['Adr_items_duration'] . ' : ' . $tools[$i]['item_duration'] . ' )'.'</option>';
				$selected_tool = '';
			}
			$tool_list .= '</select>';
			
			if ($existing_recipe != 0 && $existing_recipe != '')
			{
				//get recipe info
				$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_owner_id = 1
					AND item_id = ".$existing_recipe;
				$result = $db->sql_query($sql);
				if( !$result )
			        message_die(GENERAL_ERROR, 'Could not obtain original recipe information', "", __LINE__, __FILE__, $sql);
				$recipe_data = $db->sql_fetchrow($result);
				
				//get the potion info
				$sql_p = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
					WHERE item_owner_id = 1
					AND item_id = ".$recipe_data['item_recipe_linked_item'];
				$result_p = $db->sql_query($sql_p);
				if( !$result_p )
			        message_die(GENERAL_ERROR, 'Could not obtain original recipe information', "", __LINE__, __FILE__, $sql_p);
				$potion_data = $db->sql_fetchrow($result_p);
		
				//generate effects list of the potion/recipe
				$effects_list = array();
				$effects_list = explode(':',$recipe_data['item_effect']);
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
		
				//generate items required print_list
				$items_req = array();
				$items_req = explode(':',$recipe_data['item_brewing_items_req']);
				$items_req_print = '<table border="0" width="100%" cellspacing="2" cellpadding="2" align="center">';
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
						$items_req_print .= '<tr><td style="font-family:\'serif\';color:#FFFFFF;">'.adr_get_lang($item_info['item_name']).'</td><td align="center"><img src="adr/images/items/'.$item_info['item_icon'].'"></td>';
					}
					else {
						//get item info
						$sql_info = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
							where item_id = ".$items_req[$i-1];
						$result_info = $db->sql_query($sql_info);
						if( !$result_info )
						{
							message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql_info);
						}
						$item_info = $db->sql_fetchrow($result_info);
						
						//check the amount in user inventory of each needed item
						$req_item_name = str_replace("'","\'",$item_info['item_name']);
						$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_ITEMS_TABLE . "
							WHERE item_owner_id = $user_id
							AND item_name = '".$req_item_name."'
							AND item_in_warehouse = 0
							AND item_in_shop = 0
							AND item_duration > 0
							";
						$result = $db->sql_query($sql);
						if( !$result )
					        message_die(GENERAL_ERROR, 'Could not obtain total amount of the needed item', "", __LINE__, __FILE__, $sql);
						$total = $db->sql_fetchrow($result);
						$color = ( $total['total'] >= $items_req[$i] ) ?  $color_enough :  $color_not_enough;
						$items_req_print .= '<td align="center" style="color:#FFFFFF;">(x'.$items_req[$i].')  (<font color="'.$color.'">'.$total['total'].'</font>)</td></tr>';
					}
				}
				$items_req_print .= '</table>';

				$template->assign_vars(array(
					'RECIPE_ID' => $recipe_data['item_id'],
					"RECIPE_IMG" => $recipe_data['item_icon'],
					"RECIPE_NAME" => $recipe_data['item_name'],
					"RECIPE_LEVEL" => $recipe_data['item_power'],
					"RECIPE_DESC" => $recipe_data['item_desc'],
					"RECIPE_PRICE" => $recipe_data['item_price'],
					"RECIPE_WEIGHT" => $recipe_data['item_weight'],
					"RECIPE_EFFECT" => $effects_print_list,
					"RECIPE_ITEMS_REQ" => $items_req_print,
					"POTION_NAME" => $potion_data['item_name'],
					"POTION_IMG" => $potion_data['item_icon'],
					"POTION_DESC" => $potion_data['item_desc'],
					"POTION_LEVEL" => $potion_data['item_power'],
					"POTION_MP_USE" => $potion_data['item_mp_use'],
					"POTION_DESC" => $potion_data['item_desc'],
					"POTION_EFFECTS" => $effects_print_list,
					"POTION_PRICE" => $potion_data['item_price'],
					"POTION_WEIGHT" => $potion_data['item_weight'],
					"POTION_DURATION" => $potion_data['item_duration'],
					"POTION_DURATION_MAX" => $potion_data['item_duration_max'],
					"POTION_TYPE" => adr_get_item_type($potion_data['item_type_use'],'simple'),
				));
			}

		break;
	}
}
$template->assign_block_vars('main',array());

$sql = "SELECT * FROM " . ADR_RECIPEBOOK_TABLE . "
	WHERE recipe_owner_id = $user_id
	AND recipe_skill_id = 7
	ORDER BY recipe_level
	";
$result = $db->sql_query($sql);
if( !$result )
       message_die(GENERAL_ERROR, 'Could not obtain owners recipes information', "", __LINE__, __FILE__, $sql);
$recipes = $db->sql_fetchrowset($result);
if (count($recipes) > 0)
{
	for ($i = 0; $i < count($recipes);$i++)
		$owner_recipes .= ( $owner_recipes == '' ) ? $recipes[$i]['recipe_original_id'] : ':'.$recipes[$i]['recipe_original_id'];
	
	$original_recipes = explode(':',$owner_recipes);
	
	$recipe_list .= '<select name="known_recipes" size="4" style="background-color:#000000;width:520px;overflow:hidden;" ONCHANGE="document.list_recipes.submit()">';
	for ($a = 0; $a < count($original_recipes); $a++)
	{
		$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
			WHERE item_owner_id = 1
			AND item_id = ".$original_recipes[$a]." 
			ORDER BY item_power, item_name
			";
		$result = $db->sql_query($sql);
		if( !$result )
	        message_die(GENERAL_ERROR, 'Could not obtain original recipe information', "", __LINE__, __FILE__, $sql);
		$original_recipe = $db->sql_fetchrow($result);
		
		if ($original_recipes[$a] == $existing_recipe)
			$selected_recipe = 'selected';
		//get difficulty color
		$difference = intval($char['character_skill_brewing'] - $original_recipe['item_power']);
		switch(TRUE)
		{
			case ($difference < -9):$color = $color_impossible;break; //Impossible
			case ($difference >= -9 && $difference < -6):$color = $color_very_hard;break; //Very Hard
			case ($difference >= -6 && $difference < -4):$color =  $color_hard;break; //Hard
			case ($difference >= -4 && $difference < -2):$color =  $color_normal;break; //Normal
			case ($difference >= -2 && $difference < 0):$color =  $color_easy;break; //Easy
			case ($difference >= 0):$color =  $color_very_easy;break; //Very Easy
		}
		
		$recipe_list .= '<option style="color:'.$color.'" value = "'.$original_recipes[$a].'" '.$selected_recipe.'>Level: '.$original_recipe['item_power'].' - '.$original_recipe['item_name'].'</option>';
		$selected_recipe = '';
	}
	$recipe_list .= '</select>';
}


$template->assign_vars(array(
	"L_RECIPE_ITEMS_REQ" => $lang['Adr_recipes_items_req'],
	"L_RECIPE_WEIGHT" => $lang['Adr_shops_item_weight'],
	"L_RECIPE_TYPE" => $lang['Adr_items_type_use'],
	"L_RECIPE_MP_USE" => $lang['Adr_items_mp_use'],
	"L_RECIPE_DURATION" => $lang['Adr_items_duration'],
	"L_RECIPE_DESC" => $lang['Adr_recipes_desc'],
	"L_RECIPE_EFFECT" => $lang['Adr_recipes_effect'],
	'L_RECIPE_LEVEL' => $lang['Adr_recipes_level'],
	'L_RECIPE_ITEMS_NEEDED' => $lang['recipe_items_needed'],
	'L_RECIPE_INFO' => $lang['recipe_info'],
	'L_BREWING_SELECT_TOOL' => $lang['brewing_select_tool'],
	'L_BREWING_CREATE' =>  $lang['brewing_create'],
	'L_BREWING_SELECT_RECIPE' => $lang['brewing_select_recipe'],
	'L_BREWING_VERY_EASY' => $lang['brewing_very_easy'],
	'L_BREWING_EASY' => $lang['brewing_easy'],
	'L_BREWING_NORMAL' => $lang['brewing_normal'],
	'L_BREWING_HARD' => $lang['brewing_hard'],
	'L_BREWING_VERY_HARD' => $lang['brewing_very_hard'],
	'L_BREWING_IMPOSSIBLE' => $lang['brewing_impossible'],
	'COLOR_VERY_EASY'=> $color_very_easy,
	'COLOR_EASY'=> $color_easy,
	'COLOR_NORMAL'=> $color_normal,
	'COLOR_HARD'=> $color_hard,
	'COLOR_VERY_HARD'=> $color_very_hard,
	'COLOR_IMPOSSIBLE'=> $color_impossible,
	'RECIPE_LIST'=> $recipe_list,
	'TOOL_LIST'=> $tool_list,
	'S_BREWING_ACTION'=> append_sid("adr_brewing.$phpEx?known_recipes=$known_recipes"),
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>

