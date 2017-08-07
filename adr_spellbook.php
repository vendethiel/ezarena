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

$spell_categories = array(ADR_SKILL_EVOCATION, ADR_SKILL_HEALING, ADR_SKILL_ADJURATION);
if( isset($_POST['view_spells_skill']) || isset($_GET['view_spells_skill']) )
{
	$view_spells_skill = ( isset($_POST['view_spells_skill']) ) ? $_POST['view_spells_skill'] : $_GET['view_spells_skill'];
	$view_spells_skill = htmlspecialchars($view_spells_skill);	
}
else
{
	$view_spells_skill = $spell_categories[0];
}

$spellbook_category_links = '';
foreach ($spell_categories as $i => $category)
{
  $skill_name = adr_spellbook_category_name($category);
  $current = $view_spells_skill == $category;
  if ($current)
  {
    $spells = adr_spellbook_fetch($user_id, $category);
    $template->assign_block_vars('view_spells', array());
    $show_spell = isset($_POST['show_spell']) ? intval($_POST['show_spell']) : intval($_GET['show_spell']);
		$spell_list = '<select name="known_spells" size="4" style="width:320px;overflow:hidden;background-color:#e7d3c1;" ONCHANGE="document.list_spells.submit()">';
    foreach ($spells as $spell)
    {
      if ($show_spell && $spell['spell_id'] == $show_spell)
      {
        //generate items required print_list
        $items_req = explode(':',$spell['spell_items_req']);

        //Check if spell can be cast
        if($spell['spell_battle'] == '1' || $spell['spell_battle'] == '2')
        {
          $cast_spell = "<a href=\"adr_spell_cast.$phpEx?spell_id=$existing_spell\">Cast Spell</a>";
        }

        if ($spell['spell_items_req'] != '0' && $spell['spell_items_req'] !='')
        {
          $items_req_print = adr_spellbook_print_reqitems(explode(':', $spell['spell_items_req']));
        }
        else
        {
          $items_req_print = 'None';
        }

        // TODO print required class/element/alignment

        $template->assign_block_vars('view_spells.spell', array(
          "RECIPE_IMG" => $spell['spell_icon'],
          "RECIPE_NAME" => $spell['spell_name'],
          "RECIPE_LEVEL" => $spell['spell_power'],
          "RECIPE_DESC" => $spell['spell_desc'],
          "RECIPE_ITEMS_REQ" => $items_req_print,
          "CAST_SPELL" => $cast_spell,
        ));
      }
    }
    $template->assign_vars(array(
      'SPELL_LIST' => adr_spellbook_build_list($spells, $show_spell),
      'S_SPELLBOOK_ACTION' => append_sid('adr_spellbook.'.$phpEx.'?view_spells_skill='.$category),
    ));
  }

  $name = adr_get_lang('Adr_'.$skill_name);
  $spellbook_category_links .= '<td align="center" class="row' . (1 + $i % 2) . '"><br /><a href="adr_spellbook.'.$phpEx.'?view_spells_skill='.$category . '"><span class="gen">' . ($current ? "<b>$name</b>" : $name) . '</span></a><br /><br /></td>';
}

$template->assign_vars(array(
  'SPELLBOOK_SKILL_LINKS' => $spellbook_category_links,
  'SPELLBOOK_SKILL_COUNT' => count($spell_categories),
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
