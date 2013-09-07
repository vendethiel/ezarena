<?php
/***************************************************************************
 *                              admin_adr_users.php
 *                            -------------------
 *   begin                : 20/03/2004
 *   
 ***************************************************************************/

define('IN_PHPBB', 1);
define('IN_ADR_ADMIN', true);
define('IN_ADR_USERS', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_SKILLS', true);
define('IN_ADR_SHOPS', true);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr_Users']['Adr_characters'] = $filename;

	return;
}

$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require('./pagestart.' . $phpEx);
require($phpbb_root_path . 'includes/functions_selects.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

if( isset( $_POST['mode'] ) || isset( $_GET['mode'] ) )
{
	$mode = ( isset( $_POST['mode']) ) ? $_POST['mode'] : $_GET['mode'];
	$mode = htmlspecialchars($mode);
}
else
{
	$mode = '';
}

// Get the general config
$adr_general = adr_get_general_config();

if ( $mode != '' )
{	
	switch($mode)
	{

		case 'delete' :

			$searchid = intval($_GET[POST_USERS_URL]);

			$sql = " DELETE FROM " . ADR_CHARACTERS_TABLE . "
				WHERE character_id = '$searchid'";
			if (!$db->sql_query($sql)) 
			{
				message_die(CRITICAL_ERROR, 'Error deleting character !');
			}

			adr_update_posters_infos();
			adr_previous ( Adr_admin_character_deleted , admin_adr_users , '' );

			break;

		case 'delete_item' :

			$user_id = intval($_GET['user_id']);
			$items = ( isset($_POST['item_box']) ) ?  $_POST['item_box'] : array();

			if ( count($items) > 0 )
			{	
				for($i = 0; $i < count($items); $i++)
				{
	   				$item_id = $items[$i];
					$sql = "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE ."
						WHERE item_owner_id = '$user_id'
						AND item_id = '$item_id'";
					if( !$db->sql_query($sql) )
					{
						message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
					}
				}
			}

			adr_update_posters_infos();
			adr_previous ( Adr_admin_item_deleted , admin_adr_users , '' );

			break;

		case 'delete_inventory' :

			$user_id = intval($_GET['user_id']);

			$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
				WHERE item_owner_id = '$user_id'";
			if (!$db->sql_query($sql)){
				message_die(CRITICAL_ERROR, 'Error deleting entire inventory !');}

			adr_update_posters_infos();
			adr_previous(Adr_admin_delete_entire_inventory, admin_adr_users, '');

			break;

		case 'validate' :

			$searchid = intval($_GET[POST_USERS_URL]);

			$bio = trim($_POST['new_bio']);
			$name = $_POST['character_name'];
			$level = intval($_POST['character_level']); 
			$power = intval($_POST['character_might']);
			$agility = intval($_POST['character_dexterity']);
			$endurance = intval($_POST['character_constitution']);
			$intelligence = intval($_POST['character_intelligence']);
			$willpower = intval($_POST['character_wisdom']);
			$charm = intval($_POST['character_charisma']);
			$race = intval($_POST['character_race']);
			$element = intval($_POST['character_element']);
			$alignment = intval($_POST['character_alignment']);
			$class = intval($_POST['character_class']);

			$hp = intval($_POST['character_hp']);
			$hp_max = intval($_POST['character_hp_max']);
			$mp = intval($_POST['character_mp']);
			$mp_max = intval($_POST['character_mp_max']);
			$xp = intval($_POST['character_xp']);
			$ac = intval($_POST['character_ac']);
			$sp = intval($_POST['character_sp']);

			$mining = intval($_POST['character_skill_mining']);
			$brewing = intval($_POST['character_skill_brewing']);
			$cooking = intval($HTTP_POST_VARS['character_skill_cooking']);
			$blacksmithing = intval($HTTP_POST_VARS['character_skill_blacksmithing']);
			$stone = intval($_POST['character_skill_stone']);
			$forge = intval($_POST['character_skill_forge']);
			$enchantment = intval($_POST['character_skill_enchantment']);
			$trading = intval($_POST['character_skill_trading']);
			$thief = intval($_POST['character_skill_thief']);
			$fishing = intval($HTTP_POST_VARS['character_skill_fishing']);
			$tailoring = intval($HTTP_POST_VARS['character_skill_tailoring']);
			$hunting = intval($HTTP_POST_VARS['character_skill_hunting']);
			$herbalism = intval($HTTP_POST_VARS['character_skill_herbalism']);
			$lumberjack = intval($HTTP_POST_VARS['character_skill_lumberjack']);
			$alchemy = intval($HTTP_POST_VARS['character_skill_alchemy']);
			$mining_uses = intval($_POST['character_skill_mining_uses']);
			$blacksmithing_uses = intval($HTTP_POST_VARS['character_skill_blacksmithing_uses']);
			$brewing_uses = intval($HTTP_POST_VARS['character_skill_brewing_uses']);
			$cooking_uses = intval($HTTP_POST_VARS['character_skill_cooking_uses']);
			$stone_uses = intval($_POST['character_skill_stone_uses']);
			$forge_uses = intval($_POST['character_skill_forge_uses']);
			$enchantment_uses = intval($_POST['character_skill_enchantment_uses']);
			$trading_uses = intval($_POST['character_skill_trading_uses']);
			$thief_uses = intval($_POST['character_skill_thief_uses']);
			$herbalism_uses = intval($HTTP_POST_VARS['character_skill_herbalism_uses']);
			$hunting_uses = intval($HTTP_POST_VARS['character_skill_hunting_uses']);
			$lumberjack_uses = intval($HTTP_POST_VARS['character_skill_lumberjack_uses']);
			$tailoring_uses = intval($HTTP_POST_VARS['character_skill_tailoring_uses']);
			$alchemy_uses = intval($HTTP_POST_VARS['character_skill_alchemy_uses']);
			$fishing_uses = intval($HTTP_POST_VARS['character_skill_fishing_uses']);

			$victories = intval($_POST['character_victories']);
			$defeats = intval($_POST['character_defeats']);
			$flees = intval($_POST['character_flees']);
			$character_battle_limit = intval($_POST['character_battle_limit']);
			$character_skill_limit = intval($_POST['character_skill_limit']);
			$character_trading_limit = intval($_POST['character_trading_limit']);
			$character_thief_limit = intval($_POST['character_thief_limit']);

			$sql = "UPDATE " . ADR_CHARACTERS_TABLE ."
				SET character_class = $class ,
					character_name = '" . str_replace("\'", "''", $name ) . "',
					character_desc = '$bio' ,
					character_alignment = $alignment ,
					character_race = $race ,
					character_element = $element ,
					character_might = $power ,
					character_dexterity = $agility ,
					character_constitution = $endurance ,
					character_intelligence = $intelligence ,
					character_wisdom = $willpower ,
					character_charisma = $charm ,
					character_skill_mining =  $mining ,
					character_skill_brewing =  $brewing ,
					character_skill_cooking =  $cooking ,
					character_skill_blacksmithing =  $blacksmithing ,
					character_skill_stone = $stone ,
					character_skill_forge = $forge ,
					character_skill_enchantment = $enchantment ,
					character_skill_trading = $trading ,
					character_skill_thief = $thief ,
					character_skill_fishing =  $fishing ,
					character_skill_tailoring =  $tailoring ,
					character_skill_herbalism =  $herbalism ,
					character_skill_lumberjack =  $lumberjack ,
					character_skill_hunting =  $hunting ,
					character_skill_alchemy =  $alchemy ,
					character_skill_mining_uses = $mining_uses ,
					character_skill_brewing_uses = $brewing_uses ,
					character_skill_stone_uses = $stone_uses ,
					character_skill_forge_uses = $forge_uses ,
					character_skill_cooking_uses = $cooking_uses ,
					character_skill_blacksmithing_uses = $blacksmithing_uses ,
					character_skill_enchantment_uses = $enchantment_uses ,
					character_skill_trading_uses = $trading_uses ,
					character_skill_thief_uses = $thief_uses ,
					character_skill_fishing_uses = $fishing_uses ,
					character_skill_lumberjack_uses = $lumberjack_uses ,
					character_skill_hunting_uses = $hunting_uses ,
					character_skill_herbalism_uses = $herbalism_uses ,
					character_skill_tailoring_uses = $tailoring_uses ,
					character_skill_alchemy_uses = $alchemy_uses ,
					character_victories = $victories ,
					character_defeats = $defeats ,
					character_flees = $flees ,
					character_level = $level ,
					character_hp = $hp,
					character_hp_max = $hp_max,
					character_mp = $mp,
					character_mp_max = $mp_max,
					character_xp = $xp,
					character_sp = $sp,
					character_battle_limit = $character_battle_limit,
					character_skill_limit = $character_skill_limit,	
					character_trading_limit = $character_trading_limit,	
					character_thief_limit = $character_thief_limit,	
					character_ac = $ac
			WHERE character_id = '$searchid'";
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(CRITICAL_ERROR, 'Error updating character !');
			}

			adr_update_posters_infos();
			adr_previous ( Adr_admin_character_edited, admin_adr_users, "mode=edit&amp;".POST_USERS_URL."=".$searchid);

			break;

	case 'edit' :

		adr_template_file('admin/config_adr_character_body.tpl');
		$template->assign_block_vars('edit',array());

		if( isset( $_GET[POST_USERS_URL]) || isset( $_POST[POST_USERS_URL]) )
		{
			$user_id = ( isset( $_POST[POST_USERS_URL]) ) ? intval( $_POST[POST_USERS_URL]) : intval( $_GET[POST_USERS_URL]);
			$this_userdata = get_userdata($user_id);
			if( !$this_userdata )
			{
				message_die(GENERAL_MESSAGE, $lang['No_user_id_specified'] );
			}
		}
		else
		{
			$this_userdata = get_userdata($_POST['username'], true);
			if( !$this_userdata )
			{
				message_die(GENERAL_MESSAGE, $lang['No_user_id_specified'] );
			}
		}
		$searchid = $this_userdata['user_id'];

		$sql = "SELECT c.* , r.race_name , r.race_img , e.element_name , e.element_img , a.alignment_name , a.alignment_img , cl.class_name , cl.class_img , cl.class_update_xp_req
			FROM  " . ADR_CHARACTERS_TABLE . " c , " . ADR_RACES_TABLE . " r , " . ADR_ELEMENTS_TABLE . " e , " . ADR_ALIGNMENTS_TABLE . " a , " . ADR_CLASSES_TABLE . " cl
			WHERE c.character_id= '$searchid'
			AND cl.class_id = c.character_class
			AND r.race_id = c.character_race
			AND e.element_id = c.character_element
			AND a.alignment_id = c.character_alignment ";
		if ( !($result = $db->sql_query($sql)) ) 
		{ 
			message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
		}	
		$row = $db->sql_fetchrow($result);

		if ( !(is_numeric($row['character_class'])))
		{
			adr_previous ( Adr_admin_character_lack , admin_adr_users , '' );
		}

		$max_hp = $row['class_update_xp_req'];
		for($p = 1; $p < $row['character_level']; $p++)
		{
			$max_hp = floor($max_hp *(( $adr_general['next_level_penalty'] + 100) /100));
		}

		$class = adr_get_lang($row['class_name']);
		$race = adr_get_lang($row['race_name']);
		$element = adr_get_lang($row['element_name']);
		$alignment = adr_get_lang($row['alignment_name']);

		$message = $row['character_desc'];
		$message = str_replace('<', '&lt;', $message);
		$message = str_replace('>', '&gt;', $message);
		$message = str_replace('<br />', "\n", $message);

		$skills = adr_get_skill_data('');

		// Generate the lists
		$sql = "SELECT * FROM " . ADR_RACES_TABLE ;
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, 'Could not obtain races information', "", __LINE__, __FILE__, $sql);
		}
		$races = $db->sql_fetchrowset($result);
		$races_list = '<select name="character_race" >';
		for($i = 0; $i < count($races); $i++)
		{
			$races[$i]['race_name'] = adr_get_lang($races[$i]['race_name']);
			$race_selected = ( $row['character_race'] == $races[$i]['race_id'] ) ? 'selected' : '';
			$races_list .= '<option value = "'.$races[$i]['race_id'].'" '.$race_selected.' >' . $races[$i]['race_name'] . '</option>';
		}
		$races_list .= '</select>';

		$sql = "SELECT * FROM " . ADR_ELEMENTS_TABLE ;
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, 'Could not obtain elements information', "", __LINE__, __FILE__, $sql);
		}
		$elements = $db->sql_fetchrowset($result);
		$elements_list = '<select name="character_element">';
		for($i = 0; $i < count($elements); $i++)
		{
			$elements[$i]['element_name'] = adr_get_lang($elements[$i]['element_name']);
			$element_selected = ( $row['character_element'] == $elements[$i]['element_id'] ) ? 'selected' : '';
			$elements_list .= '<option value = "'.$elements[$i]['element_id'].'" '.$element_selected.' >' . $elements[$i]['element_name'] . '</option>';
		}
		$elements_list .= '</select>';
	
		$sql = "SELECT * FROM " . ADR_ALIGNMENTS_TABLE;
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, 'Could not obtain alignments information', "", __LINE__, __FILE__, $sql);
		}
		$alignments = $db->sql_fetchrowset($result);
		$alignments_list = '<select name="character_alignment">';
		for($i = 0; $i < count($alignments); $i++)
		{
			$alignments[$i]['alignment_name'] = adr_get_lang($alignments[$i]['alignment_name']);
			$alignment_selected = ( $row['character_alignment'] == $alignments[$i]['alignment_id'] ) ? 'selected' : '';
			$alignments_list .= '<option value = "'.$alignments[$i]['alignment_id'].'" '.$alignment_selected.' >' . $alignments[$i]['alignment_name'] . '</option>';
		}
		$alignments_list .= '</select>';

		$sql = "SELECT * FROM " . ADR_CLASSES_TABLE;
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, 'Could not obtain alignments information', "", __LINE__, __FILE__, $sql);
		}
		$classes = $db->sql_fetchrowset($result);
		$classes_list = '<select name="character_class">';
		for($i = 0; $i < count($classes); $i++)
		{
			$classes[$i]['class_name'] = adr_get_lang($classes[$i]['class_name']);
			$class_selected = ( $row['character_class'] == $classes[$i]['class_id'] ) ? 'selected' : '';
			$classes_list .= '<option value = "'.$classes[$i]['class_id'].'" '.$class_selected.' >' . $classes[$i]['class_name'] . '</option>';
		}
		$classes_list .= '</select>';


		$template->assign_vars(array(
			'RACES_LIST' => $races_list,
			'ELEMENTS_LIST' => $elements_list,
			'ALIGNMENTS_LIST' => $alignments_list,
			'CLASSES_LIST' => $classes_list,
			'LEVEL' => $row['character_level'],
			'POWER' => $row['character_might'],
			'AGILITY' => $row['character_dexterity'],
			'CONSTIT' => $row['character_constitution'],
			'INT' => $row['character_intelligence'],
			'WIS' => $row['character_wisdom'],
			'CHA' => $row['character_charisma'],
			'HP' => $row['character_hp'],
			'HP_MAX' => $row['character_hp_max'],
			'MP' => $row['character_mp'],
			'MP_MAX' => $row['character_mp_max'],
			'EXP' => $row['character_xp'],
			'HP_MAX' => $row['character_hp_max'],
			'MP_MAX' => $row['character_mp_max'],
			'SP' => $row['character_sp'],
			'EXP_MAX' => $max_hp,
			'BATTLE_VICTORIES' => $row['character_victories'],
			'BATTLE_DEFEATS' => $row['character_defeats'],
			'BATTLE_FLEES' => $row['character_flees'],
			'AC' => $row['character_ac'],
			'NAME' => $row['character_name'],
			'CLASS' => $class,
			'RACE' => $race,
			'ELEMENT' => $element,
			'ALIGNMENT' => $alignment,
			'NEW_BIO' => $message,
			'MINING' => $row['character_skill_mining'],
			'MINING_MIN' => $row['character_skill_mining_uses'],
			'MINING_MAX' => $skills[1]['skill_req'],
			'STONE' => $row['character_skill_stone'],
			'STONE_MIN' => $row['character_skill_stone_uses'],
			'STONE_MAX' => $skills[2]['skill_req'],
			'FORGE' => $row['character_skill_forge'],
			'FORGE_MIN' => $row['character_skill_forge_uses'],
			'FORGE_MAX' => $skills[3]['skill_req'],
			'ENCHANTMENT' => $row['character_skill_enchantment'],
			'ENCHANTMENT_MIN' => $row['character_skill_enchantment_uses'],
			'ENCHANTMENT_MAX' => $skills[4]['skill_req'],
			'TRADING' => $row['character_skill_trading'],
			'TRADING_MIN' => $row['character_skill_trading_uses'],
			'TRADING_MAX' => $skills[5]['skill_req'],
			'THIEF' => $row['character_skill_thief'],
			'THIEF_MIN' => $row['character_skill_thief_uses'],
			'THIEF_MAX' => $skills[6]['skill_req'],
			'BREWING' => $row['character_skill_brewing'],
			'BREWING_MIN' => $row['character_skill_brewing_uses'],
			'BREWING_MAX' => $skills[7]['skill_req'],
			'COOKING' => $row['character_skill_cooking'],
			'COOKING_MIN' => $row['character_skill_cooking_uses'],
			'COOKING_MAX' => $skills[12]['skill_req'],
			'BLACKSMITHING' => $row['character_skill_blacksmithing'],
			'BLACKSMITHING_MIN' => $row['character_skill_blacksmithing_uses'],
			'BLACKSMITHING_MAX' => $skills[13]['skill_req'],
			'FISHING' => $row['character_skill_fishing'],
			'FISHING_MIN' => $row['character_skill_fishing_uses'],
			'FISHING_MAX' => $skills[15]['skill_req'],
			'LUMBERJACK' => $row['character_skill_lumberjack'],
			'LUMBERJACK_MIN' => $row['character_skill_lumberjack_uses'],
			'LUMBERJACK_MAX' => $skills[8]['skill_req'],
			'TAILORING' => $row['character_skill_tailoring'],
			'TAILORING_MIN' => $row['character_skill_tailoring_uses'],
			'TAILORING_MAX' => $skills[9]['skill_req'],
			'HERBALISM' => $row['character_skill_herbalism'],
			'HERBALISM_MIN' => $row['character_skill_herbalism_uses'],
			'HERBALISM_MAX' => $skills[10]['skill_req'],
			'HUNTING' => $row['character_skill_hunting'],
       		'HUNTING_MIN' => $row['character_skill_hunting_uses'],
       		'HUNTING_MAX' => $skills[11]['skill_req'],
			'ALCHEMY' => $row['character_skill_alchemy'],
			'ALCHEMY_MIN' => $row['character_skill_alchemy_uses'],
			'ALCHEMY_MAX' => $skills[14]['skill_req'],
			'BATTLE_LIMIT' => $row['character_battle_limit'],
			'SKILL_LIMIT' => $row['character_skill_limit'],
			'TRADING_LIMIT' => $row['character_trading_limit'],
			'THIEF_LIMIT' => $row['character_thief_limit'],
			'U_INVENTORY' => append_sid("admin_adr_users.$phpEx?mode=inventory&amp;user_id=".$searchid.""),
			'L_INVENTORY' => $lang['Adr_character_admin_inventory'],
			'L_BIO' => $lang['Adr_character_new_bio'],
			'L_CLASS' => $lang['Adr_character_class'],
			'L_RACE' => $lang['Adr_character_race'],
			'L_ELEMENT' => $lang['Adr_character_element'],
			'L_ALIGNMENT' => $lang['Adr_character_alignment'],
			'L_HEALTH'=> $lang['Adr_character_health'],
			'L_MAGIC' => $lang['Adr_character_magic'],
			'L_EXPERIENCE' => $lang['Adr_character_experience'],	
			'L_AC' => $lang['Adr_character_ac'],
			'L_POWER' => $lang['Adr_character_power'],
			'L_AGILITY' => $lang['Adr_character_agility'],
			'L_CONSTIT' => $lang['Adr_character_endurance'],
			'L_INT' => $lang['Adr_character_intelligence'],
			'L_WIS' => $lang['Adr_character_willpower'],
			'L_CHA' => $lang['Adr_character_charm'],
			'L_MA' => $lang['Adr_character_ma'],
			'L_MD' => $lang['Adr_character_md'],
			'L_SP' => $lang['Adr_character_sp'],
			'L_POINTS' => $board_config['points_name'],
			'L_BATTLE_STATISTICS' => $lang['Adr_character_battle_statistics'],
			'L_BATTLE_VICTORIES' => $lang['Adr_character_victories'],
			'L_BATTLE_DEFEATS' => $lang['Adr_character_defeats'],
			'L_BATTLE_FLEES' => $lang['Adr_character_flees'],
			'L_BATTLE_SEE' => $lang['Adr_character_battle_history'],
			'L_DELETE_CHARACTER' => $lang['Adr_admin_character_delete'],
			'L_EDIT_CHARACTER' => $lang['Adr_admin_character_edit'],
			'L_CHARACTERISTICS' => $lang['Adr_admin_character_charac'],
			'L_MINING' => $lang['Adr_mining'],
			'L_BREWING' => $lang['Adr_brewing'],
			'L_COOKING' => $lang['Adr_cooking'],
			'L_STONE' => $lang['Adr_stone'],
			'L_FORGE' => $lang['Adr_forge'],
			'L_ENCHANTMENT' => $lang['Adr_enchantment'],
			'L_TRADING' => $lang['Adr_trading'],
			'L_BLACKSMITHING' => $lang['Adr_blacksmithing'],
			'L_THIEF' => $lang['Adr_thief'],
			'L_FISHING' => $lang['Adr_fishing'],
			'L_HUNTING' => $lang['Adr_hunting'],
			'L_HERBALISM' => $lang['Adr_herbalism'],
			'L_LUMBERJACK' => $lang['Adr_lumberjack'],
			'L_TAILORING' => $lang['Adr_tailoring'],
			'L_ALCHEMY' => $lang['Adr_alchemy'],
			'L_BATTLE_SKILLS' => $lang['Adr_user_battle_skills'],
			'L_BATTLE_LIMIT' => $lang['Adr_user_battle_limit'],
			'L_SKILL_LIMIT' => $lang['Adr_user_skill_limit'],
			'L_TRADING_LIMIT' => $lang['Adr_user_trading_limit'],
			'L_THIEF_LIMIT' => $lang['Adr_user_thief_limit'],
			'L_SKILLS' => $lang['Adr_character_skills'],
		));

		break;

		case 'inventory' :
			adr_template_file('admin/config_adr_character_body.tpl');
			$template->assign_block_vars('inventory',array());

			$user_id = intval($_GET['user_id']);
            $other_user_infos = adr_get_user_infos($user_id);
			$start = ( isset($_GET['start']) ) ? intval($_GET['start']) : 0;

			if ( isset($_GET['mode2']) || isset($_POST['mode2']) )
			{
				$mode2 = ( isset($_POST['mode2']) ) ? htmlspecialchars($_POST['mode2']) : htmlspecialchars($_GET['mode2']);
			}
			else
			{
				$mode2 = 'itemname';
			}

			if(isset($_POST['order']))
			{
				$sort_order = ($_POST['order'] == 'ASC') ? 'ASC' : 'DESC';
			}
			else if(isset($_GET['order']))
			{
				$sort_order = ($_GET['order'] == 'ASC') ? 'ASC' : 'DESC';
			}
			else
			{
				$sort_order = 'ASC';
			}

			if ( isset($_GET['cat']) || isset($_POST['cat']) )
			{
				$cat = ( isset($_POST['cat']) ) ? htmlspecialchars($_POST['cat']) : htmlspecialchars($_GET['cat']);
			}
			else
			{
				$cat = 0;
			}
			$cat_sql = ( $cat ) ? 'AND i.item_type_use = '.$cat : '';

			$categories_text = array();
			$categories = array();
			$categories_cat = array();
			adr_get_item_type_categories();

			$select_category = '<select name="cat">';
			for($i = 0; $i < count($categories_text); $i++)
			{
				if($prev_cat != $categories_cat[$i]) $select_category .= '<option style="font-weight:bold;color:black" disabled>' . adr_get_lang($categories_cat[$i]) . '</option>';
				$selected = ( $cat == $categories[$i] ) ? ' selected="selected"' : '';
				$select_category .= '<option value="' . $categories[$i] . '"' . $selected . '>' . adr_get_lang($categories_text[$i]) . '</option>';
				$prev_cat = $categories_cat[$i];
			}
			$select_category .= '</select>';

			$mode_types_text = array( $lang['Adr_shops_categories_item_name'] , $lang['Adr_items_price'] , $lang['Adr_items_type_use'] , $lang['Adr_items_quality'] , $lang['Adr_items_power'] );
			$mode_types = array( 'name', 'price' , 'type' , 'quality' , 'power' );

			$select_sort_mode = '<select name="mode2">';
			for($i = 0; $i < count($mode_types_text); $i++)
			{
				$selected = ( $mode2 == $mode_types[$i] ) ? ' selected="selected"' : '';
				$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
			}
			$select_sort_mode .= '</select>';

			$select_sort_order = '<select name="order">';
			if($sort_order == 'ASC')
			{
				$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
			}
			else
			{
				$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
			}
			$select_sort_order .= '</select>';

			switch( $mode2 )
			{
				case 'name':
					$order_by = "i.item_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				case 'price':
					$order_by = "i.item_price $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				case 'type':
					$order_by = "i.item_type_use $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				case 'quality':
					$order_by = "i.item_quality $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				case 'power':
					$order_by = "i.item_power $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
				default:
					$order_by = "i.item_name $sort_order LIMIT $start, " . $board_config['topics_per_page'];
					break;
			}

			$sql = "SELECT i.* , q.item_quality_lang , t.item_type_lang FROM " . ADR_SHOPS_ITEMS_TABLE . " i
				LEFT JOIN " . ADR_SHOPS_ITEMS_QUALITY_TABLE . " q ON ( i.item_quality = q.item_quality_id )
				LEFT JOIN " . ADR_SHOPS_ITEMS_TYPE_TABLE . " t ON ( i.item_type_use = t.item_type_id )
				WHERE i.item_owner_id = '$user_id'
				$cat_sql
				ORDER BY $order_by";
			if( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Could not query WH items', '', __LINE__, __FILE__, $sql);
			}

			$action_select = '<select name="mode">';
			$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
			$action_select .= '<option value = "delete_item">' . $lang['Delete'] . '</option>';
			$action_select .= '<option value = "delete_inventory">' . $lang['Adr_delete_inventory'] . '</option>';
			$action_select .= '</select>';

			if ( $row = $db->sql_fetchrow($result) )
			{
				$i = 0;
				do
				{
					$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

					$template->assign_block_vars('inventory.items', array(
						"ROW_CLASS" => $row_class,
						"ITEM_ID" => $row['item_id'],
						"ITEM_NAME" => adr_get_lang($row['item_name']),
						"ITEM_DESC" => adr_get_lang($row['item_desc']),
						"ITEM_IMG" => $row['item_icon'],
						"ITEM_QUALITY" => $lang[$row['item_quality_lang']],
						"ITEM_TYPE" => $lang[$row['item_type_lang']],
						"ITEM_DURATION" => $row['item_duration'],
						"ITEM_DURATION_MAX" => $row['item_duration_max'],
						"ITEM_POWER" => $row['item_power'],
						"ITEM_PRICE" => $row['item_price'],
					));

					$i++;
				}
				while ( $row = $db->sql_fetchrow($result) );
			}

			$cat_sql = ( $cat ) ? 'AND item_type_use = '.$cat : '';
			$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_ITEMS_TABLE ." 
				WHERE item_owner_id = '$user_id'
				$cat_sql
				AND item_duration > '0'";
			if ( !($result = $db->sql_query($sql)) )
			{
				message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
			}
			if ( $total = $db->sql_fetchrow($result) )
			{
				$total_items = $total['total'];
				$pagination = generate_pagination("admin_adr_users.$phpEx?mode=inventory&amp;order=$sort_order&amp;cat=$cat&amp;user_id=".$user_id."", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';
			}

			$template->assign_vars(array(
				'ORDER_BY' => $order_by,
				'ACTION_SELECT' => $action_select,
				'SELECT_CAT' => $select_category,
				'SELECT_QUANTITY' => $select_quantity,
				'SHOP_OWNER_ID' => $shop_owner,
				'OWNER_S' => $lang['Adr_warehouse_s'],
				'WAREHOUSE_NAME' => $lang['Adr_warehouse_name'],
				'OWNER_NAME' => $userdata['username'],
                'OWNER_NAME' => $other_user_infos['character_name'],
				'INVENTORY_NAME' => $lang['Adr_character_inventory_title'],
				'L_CHECK_ALL' => $lang['Adr_check_all'],
				'L_UNCHECK_ALL' => $lang['Adr_uncheck_all'],
				"L_SELECT_CAT" => $lang['Adr_items_select'],
				"L_SELECT_QUANTITY" => $lang['Adr_items_select_quantity'],
				"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
				"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
				"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
				"L_ITEM_POWER" => $lang['Adr_items_power'],
				"L_ITEM_DURATION" => $lang['Adr_items_duration'],
				"L_ACTION" => $lang['Adr_items_action'],
				"L_ITEM_IMG" => $lang['Adr_races_image'],
				"L_ITEM_PRICE" => $lang['Adr_items_price'],
				"L_ITEM_TYPE" => $lang['Adr_items_type_use'],
				"L_NO_ITEMS" => $lang['Adr_items_none'],
				'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
				'L_ORDER' => $lang['Order'],
				'L_SORT' => $lang['Sort'],
				'L_SUBMIT' => $lang['Submit'],
				'S_MODE_SELECT' => $select_sort_mode,
				'S_ORDER_SELECT' => $select_sort_order,
				'PAGINATION' => $pagination,
				'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_items / $board_config['topics_per_page'] )), 
				'L_GOTO_PAGE' => $lang['Goto_page'],
				'S_MODE_ACTION' => append_sid("admin_adr_users.$phpEx?mode=inventory"),
			));
			break;
	}
}
else
{
	adr_template_file('admin/config_adr_user_select_body.tpl');

	$sql = "SELECT u.user_id, u.username FROM " . USERS_TABLE . " u, " . ADR_CHARACTERS_TABLE . " c
		WHERE u.user_id = c.character_id
		AND c.character_class <> '0' 
		ORDER BY u.username";
	if ( !$result = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain characters list', "", __LINE__, __FILE__, $sql);
	}
	$chars = $db->sql_fetchrowset($result);
	$chars_list = '<select name="'.POST_USERS_URL.'">';
	for($i = 0; $i < count($chars); $i++)
	{
		$chars_list .= '<option value = "'.$chars[$i]['user_id'].'" >' . $chars[$i]['username'] . '</option>';
	}
	$chars_list .= '</select>';

	$template->assign_vars(array(
		'CHARS_LIST' => $chars_list ,
		'L_USER_TITLE' => $lang['Adr_user_admin'],
		'L_USER_EXPLAIN' => $lang['Adr_user_admin_explain'],
		'L_USER_SELECT' => $lang['Select_a_User'],
		'L_LOOK_UP' => $lang['Look_up_user'],
		'L_FIND_USERNAME' => $lang['Find_username'],
		'U_SEARCH_USER' => append_sid("./../search.$phpEx?mode=searchuser"), 
		'S_USER_ACTION' => append_sid("admin_adr_users.$phpEx?mode=edit"),
		'S_USER_SELECT' => $select_list,
	));
}

$template->assign_vars(array(
	'L_USER_TITLE' => $lang['Adr_user_admin'],
	'L_USER_EXPLAIN' => $lang['Adr_user_admin_explain'],
	'L_NAME' => $lang['Adr_races_name'],
	'L_LEVEL' => $lang['Adr_character_level'],
	'L_CHARACTER_OF' => sprintf ( $lang['Adr_character_of'], $this_userdata['username'] ),
	'S_CHARACTER_ACTION' => append_sid("admin_adr_users.$phpEx?".POST_USERS_URL."=".$searchid),
));

$template->pparse('body');
include('./page_footer_admin.'.$phpEx);
?>
