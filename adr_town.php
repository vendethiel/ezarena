<?php 
/***************************************************************************
 *					adr_town.php
 *				------------------------
 *	begin 			: 03/03/2004
 *	copyright		: Malicious Rabbit / Dr DLP
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
define('IN_TOWNMAP_COPYRIGHT', true);
define('IN_ADR_TOWNMAP', true);
define('IN_ADR_TOWN', true); 
define('IN_ADR_CHARACTER', true); 
define('IN_ADR_SKILLS', true);
define('IN_ADR_SHOPS', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
$loc = 'town';
$sub_loc = 'adr_town';
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
	$redirect = "adr_character.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}
// Includes the tpl and the header
adr_template_file('adr_town_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
// Get the general config and character infos
$adr_general = adr_get_general_config();
$adr_user = adr_get_user_infos($user_id);
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
if ( !$adr_general['Adr_disable_rpg'] && $userdata['user_level'] != ADMIN ) 
{	
	adr_previous ( Adr_disable_rpg , 'index' , '' );
}
// Deny access if user is imprisioned
if($userdata['user_cell_time']){
	adr_previous(Adr_shops_no_thief, adr_cell, '');}
if ( isset($HTTP_POST_VARS['mode']) && !empty($HTTP_POST_VARS['mode']) )
{
	$mode = htmlspecialchars($HTTP_POST_VARS['mode']); 
}
else if ( isset($HTTP_GET_VARS['mode']) )
{
	$mode = htmlspecialchars($HTTP_GET_VARS['mode']); 
}
else
{
	$mode = "";
}

if ( isset($HTTP_POST_VARS['sub_mode']) && !empty($HTTP_POST_VARS['sub_mode']) )
{
	$sub_mode = htmlspecialchars($HTTP_POST_VARS['sub_mode']); 
}
else if ( isset($HTTP_GET_VARS['sub_mode']) )
{
	$sub_mode = htmlspecialchars($HTTP_GET_VARS['sub_mode']); 
}
else
{
	$sub_mode = "";
}

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

if ( $mode != "" )
{
	switch($mode)
	{
		case 'training' :

			$template->assign_block_vars('training',array());

			if ( $sub_mode == "" )
			{
				$template->assign_block_vars('training.training_main',array());

				if ( $adr_general['training_allow_change'] )
				{
					$template->assign_block_vars('training.training_main.change',array());
				}

				$template->assign_vars(array(
					'L_TOWN_TRAINING_SKILL' => $lang['Adr_town_training_grounds_train_skill'],
					'L_TOWN_TRAINING_UPGRADE' => $lang['Adr_town_training_grounds_train_upgrade'],
					'L_TOWN_TRAINING_CHARAC' => $lang['Adr_town_training_grounds_train_charac'],
					'L_TOWN_TRAINING_CHANGE' => $lang['Adr_town_training_grounds_change_class'],
					'U_TOWN_TRAINING_SKILL' => append_sid("adr_town.$phpEx?mode=training&amp;sub_mode=train_skill"),
					'U_TOWN_TRAINING_UPGRADE' => append_sid("adr_town.$phpEx?mode=training&amp;sub_mode=train_upgrade"),
					'U_TOWN_TRAINING_CHARAC' => append_sid("adr_town.$phpEx?mode=training&amp;sub_mode=train_charac"),
					'U_TOWN_TRAINING_CHANGE' => append_sid("adr_town.$phpEx?mode=training&amp;sub_mode=change_class"),
				));
			}

			else
			{
				switch($sub_mode)
				{
					case 'train_skill' :

						$template->assign_block_vars('training.train_skill',array());

						$skills = adr_get_skill_data('');
						$base = $adr_general['training_skill_cost'];

						// Check if points or SP is to be used as payment
						if(!$board_config['Adr_skill_sp_enable']){
							$points = get_reward($user_id);
							$lang_points = $board_config['points_name'];}
						else{
							$points = $adr_user['character_sp'];
							$lang_points = $lang['Adr_character_sp'];}

						$template->assign_vars(array(
							'POINTS' => '<b>'.$lang['Adr_my'].$lang_points.'</b>: '.number_format($points),
							'MINING' => $adr_user['character_skill_mining'],
							'MINING_COST' => ( $adr_user['character_skill_mining'] * $base ).'&nbsp;'.$lang_points,
							'BLACKSMITHING' => $adr_user['character_skill_blacksmithing'],
							'BLACKSMITHING_COST' => ( $adr_user['character_skill_blacksmithing'] * $base ).'&nbsp;'.$lang_points,
							'COOKING' => $adr_user['character_skill_cooking'],
							'COOKING_COST' => ( $adr_user['character_skill_cooking'] * $base ).'&nbsp;'.$lang_points,	
							'BREWING' => $adr_user['character_skill_brewing'],
							'BREWING_COST' => ( $adr_user['character_skill_brewing'] * $base ).'&nbsp;'.$lang_points,	
							'STONE' => $adr_user['character_skill_stone'],
							'STONE_COST' => ( $adr_user['character_skill_stone'] * $base ).'&nbsp;'.$lang_points,	
							'FORGE' => $adr_user['character_skill_forge'],
							'FORGE_COST' => ( $adr_user['character_skill_forge'] * $base ).'&nbsp;'.$lang_points,	
							'ENCHANTMENT' => $adr_user['character_skill_enchantment'],
							'ENCHANTMENT_COST' => ( $adr_user['character_skill_enchantment'] * $base ).'&nbsp;'.$lang_points,	
							'TRADING' => $adr_user['character_skill_trading'],
							'TRADING_COST' => ( $adr_user['character_skill_trading'] * $base ).'&nbsp;'.$lang_points,	
							'THIEF' => $adr_user['character_skill_thief'],
							'THIEF_COST' => ( $adr_user['character_skill_thief'] * $base ).'&nbsp;'.$lang_points,
							'HERBALISM' => $adr_user['character_skill_herbalism'],
							'HERBALISM_COST' => ( $adr_user['character_skill_herbalism'] * $base ).'&nbsp;'.$lang_points,
							'LUMBERJACK' => $adr_user['character_skill_lumberjack'],
							'LUMBERJACK_COST' => ( $adr_user['character_skill_lumberjack'] * $base ).'&nbsp;'.$lang_points,
							'HUNTING' => $adr_user['character_skill_hunting'],
                 		    'HUNTING_COST' => ( $adr_user['character_skill_hunting'] * $base ).'&nbsp;'.$lang_points,
							'TAILORING' => $adr_user['character_skill_tailoring'],
							'TAILORING_COST' => ( $adr_user['character_skill_tailoring'] * $base ).'&nbsp;'.$lang_points,
							'FISHING' => $adr_user['character_skill_fishing'],
							'FISHING_COST' => ( $adr_user['character_skill_fishing'] * $base ).'&nbsp;'.$lang_points,
							'ALCHEMY' => $adr_user['character_skill_alchemy'],
							'ALCHEMY_COST' => ( $adr_user['character_skill_alchemy'] * $base ).'&nbsp;'.$lang_points,
							'L_TRADING' => $lang['Adr_trading'],
							'L_THIEF' => $lang['Adr_thief'],
							'L_FISHING' => $lang['Adr_fishing'],
							'L_HERBALISM' => $lang['Adr_herbalism'],
							'L_LUMBERJACK' => $lang['Adr_lumberjack'],
							'L_HUNTING' => $lang['Adr_hunting'],
							'L_TAILORING' => $lang['Adr_tailoring'],
							'L_ALCHEMY' => $lang['Adr_alchemy'],
							'L_MINING' => $lang['Adr_mining'],
							'L_BLACKSMITHING' => $lang['Adr_blacksmithing'],
							'L_COOKING' => $lang['Adr_cooking'],
							'L_STONE' => $lang['Adr_stone'],
							'L_FORGE' => $lang['Adr_forge'],
							'L_ENCHANTMENT' => $lang['Adr_enchantment'],
							'L_TRADING' => $lang['Adr_trading'],
							'L_THIEF' => $lang['Adr_thief'],
							'L_BREWING' => $lang['Adr_brewing'],
							'L_NAME' => $lang['Adr_races_name'],
							'L_LEVEL' => $lang['Adr_character_level'],
							'L_COST' => $lang['Adr_town_training_grounds_train_skill_cost'],
							'L_SELECT' => $lang['Select'],
							'L_SKILLS' => $lang['Adr_town_training_grounds_train_skill'],
							'L_SKILLS_ACTION' => $lang['Adr_town_training_grounds_train_skill_action'],
						));

						break;

					case 'train_skill_action' :

						$skill_id = intval($HTTP_POST_VARS['training_skill']);
						if ( !$skill_id )
						{
							adr_previous ( Adr_town_training_grounds_train_skill_must  , adr_town , "mode=training&amp;sub_mode=train_skill" );	
						}

						$skill[1] = $adr_user['character_skill_mining'];
						$skill[2] = $adr_user['character_skill_stone'];
						$skill[3] = $adr_user['character_skill_forge'];
						$skill[4] = $adr_user['character_skill_enchantment'];
						$skill[5] = $adr_user['character_skill_trading'];
						$skill[6] = $adr_user['character_skill_thief'];
						$skill[7] = $adr_user['character_skill_brewing'];
						$skill[12] = $adr_user['character_skill_cooking'];
						$skill[13] = $adr_user['character_skill_blacksmithing'];
						$skill[15] = $adr_user['character_skill_fishing'];
						$skill[8] = $adr_user['character_skill_lumberjack'];
						$skill[9] = $adr_user['character_skill_tailoring'];
						$skill[10] = $adr_user['character_skill_herbalism'];						
						$skill[11] = $adr_user['character_skill_hunting'];
						$skill[14] = $adr_user['character_skill_alchemy'];
						$skills = $skill[$skill_id];
						$base = $adr_general['training_skill_cost'];
						$price = $skills * $base;

						if ( !$board_config['Adr_character_sp_enable'] )
						{
							adr_substract_points( $user_id , $price , adr_town , "mode=training&amp;sub_mode=train_skill" );
						}
						else
						{
							adr_substract_sp( $user_id , $price , adr_town , "mode=training&amp;sub_mode=train_skill" );							
						}
	
						$skill[1] = 'character_skill_mining';
						$skill[2] = 'character_skill_stone';
						$skill[3] = 'character_skill_forge';
						$skill[4] = 'character_skill_enchantment';
						$skill[5] = 'character_skill_trading';
						$skill[6] = 'character_skill_thief';
						$skill[7] = 'character_skill_brewing';
						$skill[12] = 'character_skill_cooking';
						$skill[13] = 'character_skill_blacksmithing';
						$skill[15] = 'character_skill_fishing';
						$skill[8] = 'character_skill_lumberjack';
						$skill[9] = 'character_skill_tailoring';
						$skill[10] = 'character_skill_herbalism';
						$skill[11] = 'character_skill_hunting';
						$skill[14] = 'character_skill_alchemy';
						$skills = $skill[$skill_id];
						$skill_uses = $skills.'_uses';

						$sql = " UPDATE " . ADR_CHARACTERS_TABLE . "
							SET $skills = $skills + 1 ,
								$skill_uses = 0
							WHERE character_id = $user_id ";
						if ( !$db->sql_query($sql))
						{
							message_die(CRITICAL_ERROR, 'Error updating ADR Classes!');
						}

						adr_previous ( Adr_town_training_grounds_train_skill_done  , adr_character_skills , '' );
						break;

					case 'train_charac' :

						$template->assign_block_vars('training.train_charac',array());

						$base = $adr_general['training_charac_cost'];

						if ( !$board_config['Adr_character_sp_enable'] )
						{
							$lang_points = $board_config['points_name'];
						}
						else
						{
							$lang_points = $lang['Adr_character_sp'];							
						}

						$template->assign_vars(array(
							'MINING' => $adr_user['character_might'],
							'MINING_COST' => ( $adr_user['character_might'] * $base ).'&nbsp;'.$lang_points,
							'COOKING' => $adr_user['character_intelligence'],
							'COOKING_COST' => ( $adr_user['character_intelligence'] * $base ).'&nbsp;'.$lang_points,
							'STONE' => $adr_user['character_dexterity'],
							'STONE_COST' => ( $adr_user['character_dexterity'] * $base ).'&nbsp;'.$lang_points,	
							'FORGE' => $adr_user['character_constitution'],
							'FORGE_COST' => ( $adr_user['character_constitution'] * $base ).'&nbsp;'.$lang_points,	
							'BREWING' => $adr_user['character_intelligence'],
							'BREWING_COST' => ( $adr_user['character_intelligence'] * $base ).'&nbsp;'.$lang_points,
							'BLACKSMITHING' => $adr_user['character_intelligence'],
							'BLACKSMITHING_COST' => ( $adr_user['character_intelligence'] * $base ).'&nbsp;'.$lang_points,
							'ENCHANTMENT' => $adr_user['character_intelligence'],
							'ENCHANTMENT_COST' => ( $adr_user['character_intelligence'] * $base ).'&nbsp;'.$lang_points,	
							'TRADING' => $adr_user['character_wisdom'],
							'TRADING_COST' => ( $adr_user['character_wisdom'] * $base ).'&nbsp;'.$lang_points,	
							'THIEF' => $adr_user['character_charisma'],
							'THIEF_COST' => ( $adr_user['character_charisma'] * $base ).'&nbsp;'.$lang_points,
							'FISHING' => $adr_user['character_wisdom'],
							'FISHING_COST' => ( $adr_user['character_wisdom'] * $base ).'&nbsp;'.$lang_points,							
							'LUMBERJACK' => $adr_user['character_might'],
							'LUMBERJACK_COST' => ( $adr_user['character_might'] * $base ).'&nbsp;'.$lang_points,
							'TAILORING' => $adr_user['character_wisdom'],
							'TAILORING_COST' => ( $adr_user['character_wisdom'] * $base ).'&nbsp;'.$lang_points,
							'HERBALISM' => $adr_user['character_wisdom'],
							'HERBALISM_COST' => ( $adr_user['character_wisdom'] * $base ).'&nbsp;'.$lang_points,
							'HUNTING' => $adr_user['character_might'],
                   		    'HUNTING_COST' => ( $adr_user['character_might'] * $base ).'&nbsp;'.$lang_points,							
							'ALCHEMY' => $adr_user['character_intelligence'],
							'ALCHEMY_COST' => ( $adr_user['character_intelligence'] * $base ).'&nbsp;'.$lang_points,
							'L_FISHING' => $lang['Adr_character_willpower'],							
							'L_LUMBERJACK' => $lang['Adr_character_power'],
							'L_TAILORING' => $lang['Adr_character_willpower'],
							'L_HERBALISM' => $lang['Adr_character_willpower'],
							'L_HUNTING' => $lang['Adr_character_power'],
							'L_ALCHEMY' => $lang['Adr_character_intelligence'],
							'L_MINING' => $lang['Adr_character_power'],
							'L_COOKING' => $lang['Adr_character_intelligence'],
							'L_STONE' => $lang['Adr_character_agility'],
							'L_FORGE' => $lang['Adr_character_endurance'],
							'L_ENCHANTMENT' => $lang['Adr_character_intelligence'],
							'L_TRADING' => $lang['Adr_character_willpower'],
							'L_THIEF' => $lang['Adr_character_charm'],
							'L_MA' => $lang['Adr_character_ma'],
							'L_MD' => $lang['Adr_character_md'],
							'L_NAME' => $lang['Adr_races_name'],
							'L_LEVEL' => $lang['Adr_character_level'],
							'L_COST' => $lang['Adr_town_training_grounds_train_skill_cost'],
							'L_SELECT' => $lang['Select'],
							'L_BREWING' => $lang['Adr_character_intelligence'],
							'L_BLACKSMITHING' => $lang['Adr_character_intelligence'],
							'L_SKILLS' => $lang['Adr_town_training_grounds_train_charac'],
							'L_SKILLS_ACTION' => $lang['Adr_town_training_grounds_train_charac_action'],
						));

						break;

					case 'train_charac_action' :

						$skill_id = intval($HTTP_POST_VARS['training_charac']);
						if ( !$skill_id )
						{
							adr_previous ( Adr_town_training_grounds_train_charac_must  , adr_town , "mode=training&amp;sub_mode=train_charac" );	
						}

						$skill[1] = $adr_user['character_might'];
						$skill[2] = $adr_user['character_dexterity'];
						$skill[3] = $adr_user['character_constitution'];
						$skill[4] = $adr_user['character_intelligence'];
						$skill[5] = $adr_user['character_wisdom'];
						$skill[6] = $adr_user['character_charisma'];
						$skills = $skill[$skill_id];
						$base = $adr_general['training_charac_cost'];
						$price = $skills * $base;
						
						if ( !$board_config['Adr_character_sp_enable'] )
						{
							adr_substract_points( $user_id , $price , adr_town , "mode=training&amp;sub_mode=train_charac" );
						}
						else
						{
							adr_substract_sp( $user_id , $price , adr_town , "mode=training&amp;sub_mode=train_charac" );							
						}

						$skill[1] = 'character_might';
						$skill[2] = 'character_dexterity';
						$skill[3] = 'character_constitution';
						$skill[4] = 'character_intelligence';
						$skill[5] = 'character_wisdom';
						$skill[6] = 'character_charisma';
						$skills = $skill[$skill_id];

						$sql = " UPDATE " . ADR_CHARACTERS_TABLE . "
							SET $skills = $skills + 1 
							WHERE character_id = $user_id ";
						if ( !$db->sql_query($sql))
						{
							message_die(CRITICAL_ERROR, 'Error updating ADR Classes!');
						}

						adr_previous ( Adr_town_training_grounds_train_charac_done  , adr_character , '' );
						break;
						break;

					case 'train_upgrade' :

						$template->assign_block_vars('training.train_class',array());

						if ( $userdata['user_level'] == ADMIN )
						{
							$sql_level = '';
						}
						else if ( $userdata['user_level'] == MOD )
						{
							$sql_level = ' AND c.class_level <> 1';
						}
						else
						{
							$sql_level = 'AND c.class_level = 0';
						}

						$sql = "SELECT c.* FROM " . ADR_CLASSES_TABLE ." c , " . ADR_CHARACTERS_TABLE ." u
							WHERE c.class_might_req <= u.character_might
							$sql_level
							AND c.class_dexterity_req <= u.character_dexterity
							AND c.class_constitution_req <= u.character_constitution
							AND c.class_intelligence_req <= u.character_intelligence
							AND c.class_wisdom_req <= u.character_wisdom
							AND c.class_charisma_req <= u.character_charisma
							AND c.class_update_of = u.character_class 
							AND c.class_update_of_req <= u.character_level
							AND u.character_id = $user_id ";
						if ( ! ($result = $db->sql_query($sql)))
						{
							message_die(CRITICAL_ERROR, 'Error Getting ADR Classes!');
						}
						$class = $db->sql_fetchrowset($result);

						if ( count($class) < 1 )
						{
							adr_previous ( Adr_town_training_grounds_train_upgrade_lack_class , adr_town , "mode=training" );
						}

						for ( $i = 0 ; $i < count($class) ; $i ++)
						{
							$template->assign_block_vars('training.train_class.classes' , array(
								"CLASS_NAME" => adr_get_lang($class[$i]['class_name']),
								"CLASS_DESC" => adr_get_lang($class[$i]['class_desc']),
								"CLASS_IMG" => $class[$i]['class_img'],
								"CLASS_ID" => $class[$i]['class_id'],
								"UPDATE_XP_REQ" => $class[$i]['class_update_xp_req'],
								"UPDATE_HP" => $class[$i]['class_update_hp'],
								"UPDATE_MP" => $class[$i]['class_update_mp'],
								"UPDATE_AC" => $class[$i]['class_update_ac'],
							));
						}

						$hidden = 'train_upgrade_action';
						$template->assign_vars(array(
							'L_NAME' => $lang['Adr_races_name'],
							'L_DESC' => $lang['Adr_races_desc'],
							'L_IMG' => $lang['Adr_races_image'],
							"L_UPDATE_HP" => $lang['Adr_classes_update_hp'],
							"L_UPDATE_MP" => $lang['Adr_classes_update_mp'],
							"L_UPDATE_AC" => $lang['Adr_classes_update_ac'],
							"L_NEW_CHARACTER_CLASS_DESC" => $lang['Adr_races_desc'],
							"L_NEW_CHARACTER_CLASS_CHOOSE" => $lang['Select'],
							"L_SELECT_UPGRADE" => $lang['Adr_town_training_grounds_select_upgrade'],
							"L_SELECT_UPGRADE_ACTION" => $lang['Adr_town_training_grounds_select'],
							"L_SELECT_UPGRADE_COST" => sprintf($lang['Adr_town_training_grounds_select_upgrade_cost'],$adr_general['training_upgrade_cost'],$board_config['points_name']),
							"S_HIDDEN" => $hidden ,
						));

						break;

					case 'train_upgrade_action' :

						$new_class = intval($HTTP_POST_VARS['new_class']);
						if ( ! $new_class )
						{
							adr_previous ( Adr_town_training_grounds_select_upgrade_must  , adr_town , "mode=training&amp;sub_mode=train_upgrade" );
						}

						adr_substract_points( $user_id , $adr_general['training_upgrade_cost'] , adr_town , "mode=training&amp;sub_mode=train_upgrade" );

						$sql = " UPDATE " . ADR_CHARACTERS_TABLE . "
							SET character_class = $new_class
							WHERE character_id = $user_id ";
						if ( !$db->sql_query($sql))
						{
							message_die(CRITICAL_ERROR, 'Error updating ADR Classes!');
						}

						adr_previous ( Adr_town_training_grounds_select_upgrade_done  , adr_character , '' );

						break;

					case 'change_class' :

						if ( !$adr_general['training_allow_change'] )
						{
							adr_previous ( Adr_town_training_grounds_change_class_forbid , adr_town , "mode=training" );
						}

						$template->assign_block_vars('training.train_class',array());

						if ( $userdata['user_level'] == ADMIN )
						{
							$sql_level = '';
						}
						else if ( $userdata['user_level'] == MOD )
						{
							$sql_level = ' AND c.class_level <> 1';
						}
						else
						{
							$sql_level = 'AND c.class_level = 0';
						}

						$sql = "SELECT c.* FROM " . ADR_CLASSES_TABLE ." c , " . ADR_CHARACTERS_TABLE ." u
							WHERE c.class_might_req < u.character_might
							$sql_level
							AND c.class_dexterity_req <= u.character_dexterity
							AND c.class_constitution_req <= u.character_constitution
							AND c.class_intelligence_req <= u.character_intelligence
							AND c.class_wisdom_req <= u.character_wisdom
							AND c.class_charisma_req <= u.character_charisma
							AND c.class_selectable = 1
							AND u.character_id = $user_id ";
						if ( ! ($result = $db->sql_query($sql)))
						{
							message_die(CRITICAL_ERROR, 'Error Getting ADR Classes!');
						}
						$class = $db->sql_fetchrowset($result);

						if ( count($class) < 1 )
						{
							adr_previous ( Adr_town_training_grounds_change_class_lack_class , adr_town , "mode=training" );
						}

						for ( $i = 0 ; $i < count($class) ; $i ++)
						{
							$template->assign_block_vars('training.train_class.classes' , array(
								"CLASS_NAME" => adr_get_lang($class[$i]['class_name']),
								"CLASS_DESC" => adr_get_lang($class[$i]['class_desc']),
								"CLASS_IMG" => $class[$i]['class_img'],
								"CLASS_ID" => $class[$i]['class_id'],
								"UPDATE_XP_REQ" => $class[$i]['class_update_xp_req'],
								"UPDATE_HP" => $class[$i]['class_update_hp'],
								"UPDATE_MP" => $class[$i]['class_update_mp'],
								"UPDATE_AC" => $class[$i]['class_update_ac'],
							));
						}

						$hidden = 'change_class_action';
						$template->assign_vars(array(
							'L_NAME' => $lang['Adr_races_name'],
							'L_DESC' => $lang['Adr_races_desc'],
							'L_IMG' => $lang['Adr_races_image'],
							"L_UPDATE_HP" => $lang['Adr_classes_update_hp'],
							"L_UPDATE_MP" => $lang['Adr_classes_update_mp'],
							"L_UPDATE_AC" => $lang['Adr_classes_update_ac'],
							"L_NEW_CHARACTER_CLASS_DESC" => $lang['Adr_races_desc'],
							"L_NEW_CHARACTER_CLASS_CHOOSE" => $lang['Select'],
							"L_SELECT_UPGRADE" => $lang['Adr_town_training_grounds_change_class_upgrade'],
							"L_SELECT_UPGRADE_ACTION" => $lang['Adr_town_training_grounds_change_class'],
							"L_SELECT_UPGRADE_COST" => sprintf($lang['Adr_town_training_grounds_change_class_cost'],$adr_general['training_change_cost'],$board_config['points_name']),
							"S_HIDDEN" => $hidden ,
						));

						break;

					case 'change_class_action' :

						$new_class = intval($HTTP_POST_VARS['new_class']);
						if ( ! $new_class )
						{
							adr_previous ( Adr_town_training_grounds_change_class_must  , adr_town , "mode=training&amp;sub_mode=change_class" );
						}

						adr_substract_points( $user_id , $adr_general['training_change_cost'] , adr_town , "mode=training&amp;sub_mode=change_class" );

						$sql = " UPDATE " . ADR_CHARACTERS_TABLE . "
							SET character_class = $new_class
							WHERE character_id = $user_id ";
						if ( !$db->sql_query($sql))
						{
							message_die(CRITICAL_ERROR, 'Error updating ADR Classes!');
						}

						adr_previous ( Adr_town_training_grounds_change_class_done  , adr_character , '' );

						break;
				}
			}

			break;

			case 'warehouse' :

				$template->assign_block_vars('warehouse',array());
	
				if ( $adr_user['character_warehouse'] != 1 )
				{
					$template->assign_block_vars('warehouse.no_warehouse',array());
					$open = isset($HTTP_POST_VARS['open']);

					if ( $open )
					{
						$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
							SET character_warehouse = 1
							WHERE character_id = $user_id ";
						$result = $db->sql_query($sql);
						if( !$result )
						{
							message_die(GENERAL_ERROR, 'Could not update WH', "", __LINE__, __FILE__, $sql);
						}
						adr_previous( Adr_warehouse_opened, adr_town , '' );
					}	

					$template->assign_vars(array(
						"L_PERSONAL_WAREHOUSE" => $lang['Adr_warehouse_own'],
						"L_NO_WAREHOUSE" => $lang['Adr_warehouse_none'],
						"L_OPEN_WAREHOUSE" => $lang['Adr_warehouse_open'],
					));
				}
				else
				{
					$template->assign_block_vars('warehouse.see_warehouse',array());

//					$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

					if ( isset($HTTP_GET_VARS['mode2']) || isset($HTTP_POST_VARS['mode2']) )
					{
						$mode2 = ( isset($HTTP_POST_VARS['mode2']) ) ? htmlspecialchars($HTTP_POST_VARS['mode2']) : htmlspecialchars($HTTP_GET_VARS['mode2']);
					}
					else
					{
						$mode2 = 'itemname';
					}

					if(isset($HTTP_POST_VARS['order']))
					{
						$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
					}
					else if(isset($HTTP_GET_VARS['order']))
					{
						$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
					}
					else
					{
						$sort_order = 'ASC';
					}

					if ( isset($HTTP_GET_VARS['cat']) || isset($HTTP_POST_VARS['cat']) )
					{
						$cat = ( isset($HTTP_POST_VARS['cat']) ) ? htmlspecialchars($HTTP_POST_VARS['cat']) : htmlspecialchars($HTTP_GET_VARS['cat']);
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

					$select_quantity = '<select name="quantity">';
					for($i = 1; $i < 21; $i++)
					{
						$select_quantity .= '<option value="' . $i . '">' .$i . '</option>';
					}
					$select_quantity .= '</select>';

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
						WHERE i.item_owner_id = $user_id
						AND i.item_in_warehouse = 1 
						$cat_sql
						ORDER BY $order_by";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query WH items', '', __LINE__, __FILE__, $sql);
					}

					$action_select = '<select name="mode">';
					$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
					$action_select .= '<option value = "sell">' . $lang['Adr_items_sell'] . '</option>';
					$action_select .= '<option value = "retrieve_from_warehouse">' . $lang['Adr_items_into_inventory'] . '</option>';
					$action_select .= '</select>';

					if ( $row = $db->sql_fetchrow($result) )
					{
						$i = 0;
						do
						{
							$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

							$template->assign_block_vars('warehouse.see_warehouse.items', array(
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
								"ITEM_WEIGHT" => $row['item_weight'],
								"ITEM_PRICE" => $row['item_price'],
								"U_ITEM_INFO" => append_sid("adr_shops.$phpEx?mode=view_item&amp;item_owner_id=".$row['item_owner_id']."&amp;shop_id=$shop_id&amp;item_id=".$row['item_id'].""),
							));
								$i++;
						}
						while ( $row = $db->sql_fetchrow($result) );
					}

					$cat_sql = ( $cat ) ? 'AND item_type_use = '.$cat : '';
					$sql = "SELECT count(*) AS total FROM " . ADR_SHOPS_ITEMS_TABLE ." 
						WHERE item_owner_id = $user_id 
						$cat_sql
						AND item_duration > 0 
						AND item_in_warehouse = 1 ";
					if ( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
					}
					if ( $total = $db->sql_fetchrow($result) )
					{
						$total_items = $total['total'];
						$pagination = generate_pagination("adr_town.$phpEx?mode=warehouse&amp;mode2=$mode2&amp;order=$sort_order&amp;cat=$cat", $total_items, $board_config['topics_per_page'], $start). '&nbsp;';
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
						"L_SELECT_CAT" => $lang['Adr_items_select'],
						"L_SELECT_QUANTITY" => $lang['Adr_items_select_quantity'],
						"L_ITEM_NAME" => $lang['Adr_shops_categories_item_name'],
						"L_ITEM_DESC" => $lang['Adr_shops_categories_item_desc'],
						"L_ITEM_QUALITY" => $lang['Adr_items_quality'],
						"L_ITEM_POWER" => $lang['Adr_items_power'],
						"L_ITEM_WEIGHT" => $lang['Adr_character_weight'],
						"L_ITEM_DURATION" => $lang['Adr_items_duration'],
						"L_WAREHOUSE_DELETE" => $lang['Adr_users_warehouse_close'],
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
						'S_MODE_ACTION' => append_sid("adr_town.$phpEx?mode=warehouse"),
						));
					}	
					break;

					case 'sell_item' :

						// Define some values
						$items = ( isset($HTTP_POST_VARS['item_box']) ) ?  $HTTP_POST_VARS['item_box'] : array();

						$sql = "SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . " 
							WHERE item_owner_id = $user_id
							AND item_in_shop = 0
							AND item_duration > 0
							AND item_auth = 0 
							AND item_no_sell = 0 
							AND item_monster_thief = 0 ";
						if( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, $lang['Adr_shop_items_failure_deleted']);
						}
						$items = $db->sql_fetchrowset($result);

						while( list(,$item) = @each($items) )
						{
							if ( isset($HTTP_POST_VARS[$item['item_id']]))
							{
								$item_id = $item['item_id'];
								adr_sell_item($item_id , $user_id);
							}
						}

						adr_previous( Adr_inventory_items_successful_selled , adr_town , "mode=warehouse" );

					break;

					case 'sell' :

						// Define some values
						$items = ( isset($HTTP_POST_VARS['item_box']) ) ?  $HTTP_POST_VARS['item_box'] : array();

						$item_id_list .= '(';
						if ( count($items) > 0 )
						{	
							for($i = 0; $i < count($items); $i++)
							{
	   							$item_id_list .= $items[$i].',';
							}
						}
						$item_id_list .= '0)';

						$sql = "SELECT i.* FROM " . ADR_SHOPS_ITEMS_TABLE . " i
							WHERE i.item_owner_id = $user_id
							AND i.item_in_shop = 0
							AND i.item_duration > 0 
							AND i.item_auth = 0 
							AND item_no_sell = 0 
							AND i.item_id IN $item_id_list 
							ORDER BY i.item_name ";
						if( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
						}
						$items = $db->sql_fetchrowset($result);

						$items_name = '';
						while( list(,$item) = @each($items) )
						{
							$item_id = $item['item_id'];
							$temp_price = adr_get_item_real_price($item_id , $user_id);
							$price = intval($price + adr_use_skill_trading($user_id , $temp_price , sell));
							$s_hidden_fields .= '<input type="hidden" name="'.$item_id.'" value="1" />';
						}

						adr_template_file('adr_confirm_body.tpl');

						$template->assign_block_vars('sell_item' , array());

						$s_hidden_fields .= '<input type="hidden" name="cat" value="'.$cat.'" />';
						$s_hidden_fields .= '<input type="hidden" name="mode" value="sell_item" />';

						$template->assign_vars(array(
							'MESSAGE_TITLE' => $lang['Adr_items_sell_confirm'],
							'MESSAGE_TEXT' => sprintf($lang['Adr_items_sell_confirm_price'], intval($price) , $board_config['points_name'] ),
							'L_YES' => $lang['Yes'],
							'L_NO' => $lang['No'],
							'S_SELL_CONFIRM_ACTION' => append_sid("adr_town.$phpEx?mode=warehouse"),
							'HIDDEN_FIELDS' => $s_hidden_fields, 
						));

						break;

					case 'retrieve_from_warehouse' :

						$sql = "SELECT character_warehouse FROM " . ADR_CHARACTERS_TABLE . "
							WHERE character_id = $user_id ";
						$result = $db->sql_query($sql);
						if( !$result )
						{
							message_die(GENERAL_ERROR, 'Could not obtain warehouse information', "", __LINE__, __FILE__, $sql);
						}
						$row = $db->sql_fetchrow($result);

						if ( $row['character_warehouse'] != 1 )
						{
							adr_previous( Adr_lack_warehouse , adr_town , '' );	
						}

						// Define some values
						$shop_id = intval($HTTP_GET_VARS['shop_id']);
						if ( !$shop_id ) $shop_id = 1;
						$shop_owner_id = intval($HTTP_POST_VARS['shop_owner_id']);

						$items = ( isset($HTTP_POST_VARS['item_box']) ) ?  $HTTP_POST_VARS['item_box'] : array();
	
						if ( count($items) > 0 )
						{	
							for($i = 0; $i < count($items); $i++)
							{
   								$item_id = $items[$i];
								$sql = "UPDATE " . ADR_SHOPS_ITEMS_TABLE ."
									SET item_in_shop = 0, 
										item_in_warehouse = 0
									WHERE item_id = $item_id 
									AND item_owner_id = $user_id ";
								if( !$db->sql_query($sql) )
								{
									message_die(GENERAL_ERROR, 'Could not obtain items information', "", __LINE__, __FILE__, $sql);
								}
							}
						}

						adr_previous( Adr_warehouse_items_successful_removed , adr_town , "mode=warehouse" );

						break;

					case 'warehouse_delete' :

						$sql = "SELECT character_warehouse FROM " . ADR_CHARACTERS_TABLE . "
							WHERE character_id = $user_id ";
						$result = $db->sql_query($sql);
						if( !$result )
						{
							message_die(GENERAL_ERROR, 'Could not grab WH status', "", __LINE__, __FILE__, $sql);
						}
						$row = $db->sql_fetchrow($result);

						if ( $row['character_warehouse'] != 1 )
						{
							adr_previous ( Adr_lack_warehouse , adr_town , '' );	
						}

						$sql = "UPDATE " . ADR_CHARACTERS_TABLE ."
							SET character_warehouse = 0
							WHERE character_id = $user_id ";
						if( !$db->sql_query($sql) )
						{
							message_die(GENERAL_ERROR, 'Could not update closed WH', "", __LINE__, __FILE__, $sql);
						}

						adr_previous( Adr_users_warehouse_deleted , adr_town , '' );

					break;
	}
}

else
{
	$template->assign_block_vars('main',array());
}

$template->assign_vars(array(
	'L_CHECK_ALL' => $lang['Adr_check_all'],
	'L_UNCHECK_ALL' => $lang['Adr_uncheck_all'],	'L_TOWN_JOB' => $lang['Adr_town_job'],

	'U_TOWN_JOB' => append_sid("adr_jobs.$phpEx"),

	'L_TOWN_TRAINING' => $lang['Adr_town_training_grounds'],
	'U_TOWN_TRAINING' => append_sid("adr_town.$phpEx?mode=training"),
	'L_TOWN_WAREHOUSE' => $lang['Adr_town_warehouse'],
	'U_TOWN_WAREHOUSE' => append_sid("adr_town.$phpEx?mode=warehouse"),
	'U_WAREHOUSE_DELETE' => append_sid("adr_town.$phpEx?mode=warehouse_delete"),

   'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
   'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
   'L_COPYRIGHT' => $lang['Adr_copyright'],
   'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
   'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
   'U_TOWNBOUTONRETOUR' => append_sid("adr_TownMap.$phpEx"),

	'S_TOWN_ACTION'=> append_sid("adr_town.$phpEx"),
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?>
