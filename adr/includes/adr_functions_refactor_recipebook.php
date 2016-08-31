<?php
/* V:
 * This functions were made as modifications done to the EzArena premodded board
 * and are "just" code refactoring, because sometimes it makes me cry to have 5-times dups.
 *
 * Also yes, I just copy-pasted this code comment from refactor_battle. :)
 */

define('ADR_SKILL_BREWING', 7);
define('ADR_SKILL_COOKING', 12);
define('ADR_SKILL_BLACKSMITHING', 13);

/**
 * Returns the name of a skill
 */
function adr_recipebook_skill_name($skill)
{
  switch ($skill)
  {
  case ADR_SKILL_BREWING:
    return 'brewing';
  case ADR_SKILL_COOKING:
    return 'cooking';
  case ADR_SKILL_BLACKSMITHING:
    return 'blacksmithing';
  default:
    message_die(GENERAL_ERROR, 'No such skill');
  }
}

/**
 * Fetches a list of recipes for a designated skill that the current user knows.
 */
function adr_recipebook_fetch($skill)
{
  global $db, $user_id;

  $sql = "SELECT * FROM " . ADR_RECIPEBOOK_TABLE . "
    WHERE recipe_owner_id = $user_id
    AND recipe_skill_id = " . intval($skill) . "
    ORDER BY recipe_level
  ";
  $result = $db->sql_query($sql);
  if (!$result)
    message_die(GENERAL_ERROR, 'Could not obtain owners recipes information', "", __LINE__, __FILE__, $sql);
  $recipes = $db->sql_fetchrowset($result);
  $db->sql_freeresult($result);
  return $recipes;
}

/**
 * Fetches a list of recipes for a designated skill that the current user knows.
 */
function adr_recipebook_get($id)
{
  global $db, $user_id;

  $sql = "SELECT * FROM " . ADR_RECIPEBOOK_TABLE . "
    WHERE recipe_id = " . intval($id);
  $result = $db->sql_query($sql);
  if (!$result)
    message_die(GENERAL_ERROR, 'Could not obtain owners recipes information', "", __LINE__, __FILE__, $sql);
  $recipe = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  return $recipe;
}

/**
 * Builds a <select> of recipes that the user knows
 */
function adr_recipebook_build_list($recipes, $selected)
{
  $recipe_list = '<select name="show_recipe" style="width: 100%;" size="4" ONCHANGE="document.list_recipes.submit()">';
  if (!$recipes)
    $recipe_list .= '<option value="">----</option>';
  foreach ($recipes as $recipe)
  {
    $recipe_id = $recipe['recipe_id'];
    // fetch the recipe item
    $item = adr_get_item($recipe['recipe_original_id']);
    if (!$recipe) // skip deleted recipes
      continue;
    $selected = $recipe_id == $selected ? ' selected="selected"' : '';
    $recipe_list .= '<option value="' . $recipe_id . '">' . $item['item_name'] . '(' . $item['item_power'] . ')' . '</option>';
  }
  $recipe_list .= '</select>';
  return $recipe_list;
}

/**
 * Builds the string of effects for some recipe.
 */
function adr_recipebook_print_effects($effects)
{
  //generate effects list of the potion/recipe
  $effects_list = explode(':',$effects);
  $effects_print_list = '';
  $stats = array('','HP','MP','AC','STR','DEX','CON','INT','WIS','CHA','MA','MD','EXP','GOLD','SP','BATTLES_REM','SKILLUSE_REM','TRADINGSKILL_REM','THEFTSKILL_REM','LEVEL');
  for ($i = 0; $i < count($effects_list);$i++)
  {
    if(array_search($effects_list[$i],$stats)) {
      $effects_print_list .= $effects_list[$i].": ".$effects_list[$i+1];
      if($effects_list[$i+3]==0)
        $effects_print_list .= '';
      else
        $effects_print_list .= ' (Monstre)';
      if($effects_list[$i+5]==0)
        $effects_print_list .= ' (TEMP)';
      else
        $effects_print_list .= ' (PERM)';
      $effects_print_list .= '<br />';
    }
  }
  return $effects_print_list;
}

/**
 * Builds the string of required items.
 */
function adr_recipebook_print_reqitems($items_req)
{
  $items_req = explode(':',$items_req);
  if ($items_req[0] == '')
    $items_req = array(); // fuck you PHP.
  $items_req_print = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
  // this is pure madness. :(
  for ($i = 0; $i < count($items_req); $i += 2)
  {
    $item = adr_get_item($items_req[$i]);
    $count = $items_req[$i + 1];
    $items_req_print .= '
<tr>
  <td>' . $item['item_name'] . '</td><td><img src="adr/images/items/' . $item['item_icon'] . '" /></td>
  <td>x' . $count . '</td>
</tr>
';
  }
  $items_req_print .= '</table>';
  return $items_req_print;
}
