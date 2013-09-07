<?php 
/***************************************************************************
 *					adr_recipebook.php
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
define('IN_ADR_COOKING', true);
define('IN_ADR_BLACKSMITHING', true);

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
	$redirect = "adr_character.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_recipebook_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();

// Get userdata
$user_id = $userdata['user_id'];

if( isset($HTTP_POST_VARS['view_recipes_skill']) || isset($HTTP_GET_VARS['view_recipes_skill']) )
{
	$view_recipes_skill = ( isset($HTTP_POST_VARS['view_recipes_skill']) ) ? $HTTP_POST_VARS['view_recipes_skill'] : $HTTP_GET_VARS['view_recipes_skill'];
	$view_recipes_skill = htmlspecialchars($view_recipes_skill);	
}
else
{
	$view_recipes_skill = "";
}

if ( $view_recipes_skill != "" )
{
	switch($view_recipes_skill)
	{
		case 'brewing' :
				$template->assign_block_vars('view_recipes',array());

				$existing_recipe = ( isset($HTTP_POST_VARS['known_recipes']) ) ? trim($HTTP_POST_VARS['known_recipes']) : trim($HTTP_GET_VARS['known_recipes']);

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
					
					$recipe_list .= '<select name="known_recipes" size="4" style="width:320px;overflow:hidden;background-color:#e7d3c1;" ONCHANGE="document.list_recipes.submit()">';
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
						$recipe_list .= '<option value = "'.$original_recipes[$a].'" '.$selected_recipe.'>Level: '.$original_recipe['item_power'].' - '.$original_recipe['item_name'].'</option>';
						$selected_recipe = '';
					}
					$recipe_list .= '</select>';
					
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
						$result_data = $db->sql_fetchrow($result_p);
	
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

						$template->assign_block_vars('view_recipes.recipe', array(
							"RECIPE_IMG" => $recipe_data['item_icon'],
							"RECIPE_NAME" => $recipe_data['item_name'],
							"RECIPE_LEVEL" => $recipe_data['item_power'],
							"RECIPE_DESC" => $recipe_data['item_desc'],
							"RECIPE_PRICE" => $recipe_data['item_price'],
							"RECIPE_WEIGHT" => $recipe_data['item_weight'],
							"RECIPE_EFFECT" => $effects_print_list,
							"RECIPE_ITEMS_REQ" => $items_req_print,
							"L_RECIPE_ITEMS_REQ" => $lang['Adr_recipes_items_req'],
							"RESULT_NAME" => $result_data['item_name'],
							"RESULT_IMG" => $result_data['item_icon'],
							"RESULT_LEVEL" => $result_data['item_power'],
							"RESULT_DESC" => $result_data['item_desc'],
							"RESULT_EFFECTS" => $effects_print_list,
							"RESULT_PRICE" => $result_data['item_price'],
							"RESULT_WEIGHT" => $result_data['item_weight'],
							"RESULT_DURATION" => $result_data['item_duration'],
							"RESULT_DURATION_MAX" => $result_data['item_duration_max'],
						));
					}
				}
				
				
				$template->assign_vars(array(
					'RECIPE_LIST'=> $recipe_list,
					'RECIPEBOOK_SKILL_LINKS' => '<br /><img src="adr/images/misc/brewing_button2.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=brewing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/blacksmithing_button.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=blacksmithing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/cooking_button.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=cooking\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/empty_button.gif"  onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/empty_button.gif" onMouseOver="this.style.cursor=\'pointer\';">',
					'S_RECIPEBOOK_ACTION'=> append_sid("adr_recipebook.$phpEx?view_recipes_skill=brewing&amp;known_recipes=$known_recipes"),
					'L_RECIPE_STATS' => $lang['recipe_stats'],
					'L_PRODUCT_EFFECTS' => $lang['potion_effects'],
					'L_PRODUCT_STATS' => $lang['potion_stats'],
				));
			break;

		case 'blacksmithing' :
				$template->assign_block_vars('view_recipes',array());

				$existing_recipe = ( isset($HTTP_POST_VARS['known_recipes']) ) ? trim($HTTP_POST_VARS['known_recipes']) : trim($HTTP_GET_VARS['known_recipes']);

				$sql = "SELECT * FROM " . ADR_RECIPEBOOK_TABLE . "
					WHERE recipe_owner_id = $user_id
					AND recipe_skill_id = 13
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
					
					$recipe_list .= '<select name="known_recipes" size="4" style="width:320px;overflow:hidden;background-color:#e7d3c1;" ONCHANGE="document.list_recipes.submit()">';
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
						$recipe_list .= '<option value = "'.$original_recipes[$a].'" '.$selected_recipe.'>Level: '.$original_recipe['item_power'].' - '.$original_recipe['item_name'].'</option>';
						$selected_recipe = '';
					}
					$recipe_list .= '</select>';
					
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
						
						//get the food info
						$sql_p = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
							WHERE item_owner_id = 1
							AND item_id = ".$recipe_data['item_recipe_linked_item'];
						$result_p = $db->sql_query($sql_p);
						if( !$result_p )
					        message_die(GENERAL_ERROR, 'Could not obtain original recipe information', "", __LINE__, __FILE__, $sql_p);
						$result_data = $db->sql_fetchrow($result_p);
	
						//generate effects list of the food/recipe
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

						$template->assign_block_vars('view_recipes.recipe', array(
							"RECIPE_IMG" => $recipe_data['item_icon'],
							"RECIPE_NAME" => $recipe_data['item_name'],
							"RECIPE_LEVEL" => $recipe_data['item_power'],
							"RECIPE_DESC" => $recipe_data['item_desc'],
							"RECIPE_PRICE" => $recipe_data['item_price'],
							"RECIPE_WEIGHT" => $recipe_data['item_weight'],
							"RECIPE_EFFECT" => $effects_print_list,
							"RECIPE_ITEMS_REQ" => $items_req_print,
							"L_RECIPE_ITEMS_REQ" => $lang['Adr_recipes_items_req'],
							"RESULT_NAME" => $result_data['item_name'],
							"RESULT_IMG" => $result_data['item_icon'],
							"RESULT_LEVEL" => $result_data['item_power'],
							"RESULT_DESC" => $result_data['item_desc'],
							"RESULT_EFFECTS" => $effects_print_list,
							"RESULT_PRICE" => $result_data['item_price'],
							"RESULT_WEIGHT" => $result_data['item_weight'],
							"RESULT_DURATION" => $result_data['item_duration'],
							"RESULT_DURATION_MAX" => $result_data['item_duration_max'],
						));
					}
				}
				
				
				$template->assign_vars(array(
					'RECIPE_LIST'=> $recipe_list,
					'RECIPEBOOK_SKILL_LINKS' => '<br /><img src="adr/images/misc/brewing_button.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=brewing\'" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=blacksmithing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/blacksmithing_button2.gif" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/cooking_button.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=cooking\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/empty_button.gif"  onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/empty_button.gif" onMouseOver="this.style.cursor=\'pointer\';">',
					'S_RECIPEBOOK_ACTION'=> append_sid("adr_recipebook.$phpEx?view_recipes_skill=blacksmithing&amp;known_recipes=$known_recipes"),
					'L_RECIPE_STATS' => $lang['pattern_stats'],
					'L_PRODUCT_EFFECTS' => $lang['product_effects'],
					'L_PRODUCT_STATS' => $lang['product_stats'],
				));
			break;

		case 'cooking' :
				$template->assign_block_vars('view_recipes',array());

				$existing_recipe = ( isset($HTTP_POST_VARS['known_recipes']) ) ? trim($HTTP_POST_VARS['known_recipes']) : trim($HTTP_GET_VARS['known_recipes']);

				$sql = "SELECT * FROM " . ADR_RECIPEBOOK_TABLE . "
					WHERE recipe_owner_id = $user_id
					AND recipe_skill_id = 12
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
					
					$recipe_list .= '<select name="known_recipes" size="4" style="width:320px;overflow:hidden;background-color:#e7d3c1;" ONCHANGE="document.list_recipes.submit()">';
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
						$recipe_list .= '<option value = "'.$original_recipes[$a].'" '.$selected_recipe.'>Level: '.$original_recipe['item_power'].' - '.$original_recipe['item_name'].'</option>';
						$selected_recipe = '';
					}
					$recipe_list .= '</select>';
					
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
						
						//get the food info
						$sql_p = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
							WHERE item_owner_id = 1
							AND item_id = ".$recipe_data['item_recipe_linked_item'];
						$result_p = $db->sql_query($sql_p);
						if( !$result_p )
					        message_die(GENERAL_ERROR, 'Could not obtain original recipe information', "", __LINE__, __FILE__, $sql_p);
						$result_data = $db->sql_fetchrow($result_p);
	
						//generate effects list of the food/recipe
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

						$template->assign_block_vars('view_recipes.recipe', array(
							"RECIPE_IMG" => $recipe_data['item_icon'],
							"RECIPE_NAME" => $recipe_data['item_name'],
							"RECIPE_LEVEL" => $recipe_data['item_power'],
							"RECIPE_DESC" => $recipe_data['item_desc'],
							"RECIPE_PRICE" => $recipe_data['item_price'],
							"RECIPE_WEIGHT" => $recipe_data['item_weight'],
							"RECIPE_EFFECT" => $effects_print_list,
							"RECIPE_ITEMS_REQ" => $items_req_print,
							"L_RECIPE_ITEMS_REQ" => $lang['Adr_recipes_items_req'],
							"RESULT_NAME" => $result_data['item_name'],
							"RESULT_IMG" => $result_data['item_icon'],
							"RESULT_LEVEL" => $result_data['item_power'],
							"RESULT_DESC" => $result_data['item_desc'],
							"RESULT_EFFECTS" => $effects_print_list,
							"RESULT_PRICE" => $result_data['item_price'],
							"RESULT_WEIGHT" => $result_data['item_weight'],
							"RESULT_DURATION" => $result_data['item_duration'],
							"RESULT_DURATION_MAX" => $result_data['item_duration_max'],
						));
					}
				}
				
				
				$template->assign_vars(array(
					'RECIPE_LIST'=> $recipe_list,
					'RECIPEBOOK_SKILL_LINKS' => '<br /><img src="adr/images/misc/brewing_button.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=brewing\'" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=blacksmithing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/blacksmithing_button.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=blacksmithing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/cooking_button2.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=cooking\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/empty_button.gif"  onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/empty_button.gif" onMouseOver="this.style.cursor=\'pointer\';">',
					'S_RECIPEBOOK_ACTION'=> append_sid("adr_recipebook.$phpEx?view_recipes_skill=cooking&amp;known_recipes=$known_recipes"),
					'L_RECIPE_STATS' => $lang['recipe_stats'],
					'L_PRODUCT_EFFECTS' => $lang['food_effects'],
					'L_PRODUCT_STATS' => $lang['food_stats'],
				));
			break;
	}
}
else
{
	$template->assign_block_vars('main',array());

	$template->assign_vars(array(
		'RECIPEBOOK_SKILL_LINKS' => '<br /><img src="adr/images/misc/brewing_button.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=brewing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/blacksmithing_button.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=blacksmithing\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/cooking_button.gif" onclick="location=\'adr_recipebook.'.$phpEx.'?view_recipes_skill=cooking\'" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/empty_button.gif" onMouseOver="this.style.cursor=\'pointer\';"><img src="adr/images/misc/empty_button.gif" onMouseOver="this.style.cursor=\'pointer\';">',
		'S_RECIPEBOOK_ACTION'=> append_sid("adr_recipebook.$phpEx"),
	));
}

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
