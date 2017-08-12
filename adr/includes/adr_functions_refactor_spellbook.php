<?php
/* V:
 * This functions were made as modifications done to the EzArena premodded board
 * and are "just" code refactoring, because sometimes it makes me cry to have 5-times dups.
 *
 * Also yes, I just copy-pasted this code comment from refactor_battle. :)
 */

define('ADR_SKILL_EVOCATION', 107); // offense
define('ADR_SKILL_HEALING', 108); // heal
define('ADR_SKILL_ADJURATION', 109); // defense

function adr_spellbook_category_name($category)
{
  switch ($category)
  {
  case ADR_SKILL_EVOCATION:
    return 'evocation';
  case ADR_SKILL_HEALING:
    return 'healing';
  case ADR_SKILL_ADJURATION:
    return 'adjuration';
  default:
    return '???';
  }
}

/**
 * Returns an user's spells in some skill category.
 */
function adr_spellbook_fetch($user_id, $skill_id)
{
  global $db;

	$sql = "SELECT * FROM " . ADR_SHOPS_SPELLS_TABLE . "
		WHERE spell_owner_id = " . intval($user_id) . "
		AND item_type_use = " . intval($skill_id) . "
		ORDER BY spell_power
		";
	$result = $db->sql_query($sql);
	if( !$result )
        message_die(GENERAL_ERROR, 'Could not obtain owners spells information', "", __LINE__, __FILE__, $sql);
	$spells = $db->sql_fetchrowset($result);
	$db->sql_freeresult($spells);
  return $spells;
}

/**
 * Builds a spell list for adr_spellbook
 * 
 * Note: the original code for the spellbook queries uses "spell_original_id"
 *       to query the template, but that should be unnecessary, since updating
 *       a template updates all its references as well.
 */
function adr_spellbook_build_list($spells, $selected)
{
  $spell_list = '<select name="show_spell" style="width: 100%;" size="4" ONCHANGE="document.list_spells.submit()">';
  if (!$spells)
    $spell_list .= '<option value="">----</option>';
  foreach ($spells as $spell)
  {
    $selected_html = $spell['spell_id'] == $selected ? ' selected="selected"' : '';
    $spell_list .= '<option value="'.$spell['spell_id'].'"'.$selected_html.'>'.adr_get_lang($spell['spell_name']).' (' . $lang['Adr_items_level'] . ' ' . $spell['spell_power'] . ')</option>';
  }
  $spell_list .= '</select>';
  return $spell_list;
}

function adr_spellbook_print_reqitems($items_req)
{
  $items_req_print = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
  for ($i = 0; $i < count($items_req); $i += 2)
  {
    $switch = ( !($i % 2) ) ? $get_info=1 : $get_info=0;
    $item_info = adr_get_item($items_req[$i]);
    $items_req_print .= '<tr><td style="font-family:\'serif\'">'.$item_info['item_name'].'</td><td><img src="adr/images/items/'.$item_info['item_icon'].'"></td>
  <td>' . ($items_req[$i + 1] == 1 ? '&nbsp;' : 'x' . $items_req[$i + 1]) . '</td></tr>';
  }
  $items_req_print .= '</table>';
  return $items_req_print;
}
