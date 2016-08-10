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
include($phpbb_root_path . 'adr/includes/adr_functions_refactor_recipebook.'.$phpEx);

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

// V: TODO bancheck?

// Get the general config
$adr_general = adr_get_general_config();

// Get userdata
$user_id = $userdata['user_id'];

if( isset($_POST['view_recipes_skill']) || isset($_GET['view_recipes_skill']) )
{
	$view_recipes_skill = ( isset($_POST['view_recipes_skill']) ) ? $_POST['view_recipes_skill'] : $_GET['view_recipes_skill'];
	$view_recipes_skill = htmlspecialchars($view_recipes_skill);	
}
else
{
	$view_recipes_skill = "brewing";
}

function recipebook_display($skill)
{
}

$craft_categories = array(ADR_SKILL_BREWING, ADR_SKILL_BLACKSMITHING, ADR_SKILL_COOKING);
foreach ($craft_categories as $category)
{
  $skill_name = adr_recipebook_skill_name($category);
  if ($view_recipes_skill == $skill_name)
  {
    $template->assign_block_vars('view_recipes',array());

    $show_recipe = ( isset($_POST['show_recipe']) ) ? intval($_POST['show_recipe']) : intval($_GET['show_recipe']);

    $recipes = adr_recipebook_fetch($category);
    $recipe_list = adr_recipebook_build_list($recipes, $show_recipe);
    if (count($recipes) > 0 && $show_recipe)
    {
      $recipe = adr_recipebook_get($show_recipe);
      $recipe_data = adr_get_item($recipe['recipe_original_id']);
      $result_data = adr_get_item($recipe['recipe_linked_item']);

      $effects_print_list = adr_recipebook_print_effects($recipe_data['item_effect']);
      $reqitems_print_list = adr_recipebook_print_reqitems($recipe_data['item_brewing_items_req']);

      //generate items required print_list

      $template->assign_block_vars('view_recipes.recipe', array(
        "RECIPE_IMG" => $recipe_data['item_icon'],
        "RECIPE_NAME" => $recipe_data['item_name'],
        "RECIPE_LEVEL" => $recipe_data['item_power'],
        "RECIPE_DESC" => $recipe_data['item_desc'],
        "RECIPE_PRICE" => $recipe_data['item_price'],
        "RECIPE_WEIGHT" => $recipe_data['item_weight'],
        "RECIPE_EFFECT" => $effects_print_list,
        "RECIPE_ITEMS_REQ" => $reqitems_print_list,
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

    $template->assign_vars(array(
      'RECIPE_LIST'=> $recipe_list,
      'S_RECIPEBOOK_ACTION'=> append_sid("adr_recipebook.$phpEx?view_recipes_skill=$skill_name"),
      'L_RECIPE_STATS' => $lang['recipe_stats'],
      'L_PRODUCT_EFFECTS' => $lang['potion_effects'],
      'L_PRODUCT_STATS' => $lang['potion_stats'],
    ));
    break;
  }
}

$recipebook_skill_links = '';
$i = 0;
foreach ($craft_categories as $craft_category)
{
  $category = adr_recipebook_skill_name($craft_category);
  $current = $view_recipes_skill == $category;
  $name = adr_get_lang('Adr_' . $category);
  $recipebook_skill_links .= '<td align="center" class="row' . (1 + $i++ % 2) . '"><br /><a href="adr_recipebook.'.$phpEx.'?view_recipes_skill='.$category . '"><span class="gen">' . ($current ? "<b>$name</b>" : $name) . '</span></a><br /><br /></td>';
}
$recipebook_skill_links .= '';
$template->assign_vars(array(
  'RECIPEBOOK_SKILL_LINKS' => $recipebook_skill_links,
  'RECIPEBOOK_SKILL_COUNT' => count($craft_categories),
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
