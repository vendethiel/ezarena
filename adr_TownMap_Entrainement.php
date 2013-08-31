<?php 
/***************************************************************************
 *				adr_TownMap_Entrainement.php
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
define('IN_ADR_TOWNMAP', true);
define('IN_TOWNMAP_INFOBOX', true);
define('IN_TOWNMAP_ENTRAINEMENT', true);
define('IN_TOWNMAP_COPYRIGHT', true);
define('IN_ADR_TOWN', true); 
define('IN_ADR_CHARACTER', true); 
define('IN_ADR_SKILLS', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_TownMap_Entrainement';

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

// Includes the tpl and the header and the choice of the season
adr_template_file('adr_TownMap_Entrainement_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$carte = '';

$lsql = "select  townmap_map  from " . ADR_TOWNMAPMAP_TABLE ;
if ( !($lresult = $db->sql_query($lsql)) ) message_die(GENERAL_ERROR, "Could not acces TownMapMAP table.", '', __LINE__, __FILE__, $sql);
if ($alignments = $db->sql_fetchrow($lresult))
{
	$carte = $alignments['townmap_map'];
}
	if ( $carte == '1' ) 
	{
	$saison = 'Carte1';
	}

	if ( $carte == '2' ) 
	{
	$saison = 'Carte2';
	}

	if ( $carte == '3' ) 
	{
	$saison = 'Carte3';
	}

	if ( $carte == '4' ) 
	{
	$saison = 'Carte4';
	}

// Get the general config and character infos
$adr_general = adr_get_general_config();
$adr_user = adr_get_user_infos($user_id);

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
					'U_TOWN_TRAINING_SKILL' => append_sid("adr_TownMap_Entrainement.$phpEx?mode=training&amp;sub_mode=train_skill"),
					'U_TOWN_TRAINING_UPGRADE' => append_sid("adr_TownMap_Entrainement.$phpEx?mode=training&amp;sub_mode=train_upgrade"),
					'U_TOWN_TRAINING_CHARAC' => append_sid("adr_TownMap_Entrainement.$phpEx?mode=training&amp;sub_mode=train_charac"),
					'U_TOWN_TRAINING_CHANGE' => append_sid("adr_TownMap_Entrainement.$phpEx?mode=training&amp;sub_mode=change_class"),
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

						if ( !$board_config['Adr_skill_sp_enable'] )
						{
							$lang_points = $board_config['points_name'];
						}
						else
						{
							$lang_points = $lang['Adr_character_sp'];							
						}

						$template->assign_vars(array(
							'MINING' => $adr_user['character_skill_mining'],
							'MINING_COST' => ( $adr_user['character_skill_mining'] * $base ).'&nbsp;'.$lang_points,	
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
							'L_MINING' => $lang['Adr_mining'],
							'L_STONE' => $lang['Adr_stone'],
							'L_FORGE' => $lang['Adr_forge'],
							'L_ENCHANTMENT' => $lang['Adr_enchantment'],
							'L_TRADING' => $lang['Adr_trading'],
							'L_THIEF' => $lang['Adr_thief'],
						));

						$template->assign_vars(array(
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
							adr_previous ( Adr_town_training_grounds_train_skill_must  , adr_TownMap_Entrainement , "mode=training&amp;sub_mode=train_skill" );	
						}

						$skill[1] = $adr_user['character_skill_mining'];
						$skill[2] = $adr_user['character_skill_stone'];
						$skill[3] = $adr_user['character_skill_forge'];
						$skill[4] = $adr_user['character_skill_enchantment'];
						$skill[5] = $adr_user['character_skill_trading'];
						$skill[6] = $adr_user['character_skill_thief'];
						$skills = $skill[$skill_id];
						$base = $adr_general['training_skill_cost'];
						$price = $skills * $base;

						if ( !$board_config['Adr_skill_sp_enable'] )
						{
							adr_substract_points( $user_id , $price , adr_TownMap_Entrainement , "mode=training&amp;sub_mode=train_skill" );
						}
						else
						{
							adr_substract_sp( $user_id , $price , adr_TownMap_Entrainement , "mode=training&amp;sub_mode=train_skill" );							
						}
	
						$skill[1] = 'character_skill_mining';
						$skill[2] = 'character_skill_stone';
						$skill[3] = 'character_skill_forge';
						$skill[4] = 'character_skill_enchantment';
						$skill[5] = 'character_skill_trading';
						$skill[6] = 'character_skill_thief';
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
							'STONE' => $adr_user['character_dexterity'],
							'STONE_COST' => ( $adr_user['character_dexterity'] * $base ).'&nbsp;'.$lang_points,	
							'FORGE' => $adr_user['character_constitution'],
							'FORGE_COST' => ( $adr_user['character_constitution'] * $base ).'&nbsp;'.$lang_points,	
							'ENCHANTMENT' => $adr_user['character_intelligence'],
							'ENCHANTMENT_COST' => ( $adr_user['character_intelligence'] * $base ).'&nbsp;'.$lang_points,	
							'TRADING' => $adr_user['character_wisdom'],
							'TRADING_COST' => ( $adr_user['character_wisdom'] * $base ).'&nbsp;'.$lang_points,	
							'THIEF' => $adr_user['character_charisma'],
							'THIEF_COST' => ( $adr_user['character_charisma'] * $base ).'&nbsp;'.$lang_points,
							'L_MINING' => $lang['Adr_character_power'],
							'L_STONE' => $lang['Adr_character_agility'],
							'L_FORGE' => $lang['Adr_character_endurance'],
							'L_ENCHANTMENT' => $lang['Adr_character_intelligence'],
							'L_TRADING' => $lang['Adr_character_willpower'],
							'L_THIEF' => $lang['Adr_character_charm'],
							'L_MA' => $lang['Adr_character_ma'],
							'L_MD' => $lang['Adr_character_md'],
						));

						$template->assign_vars(array(
							'L_NAME' => $lang['Adr_races_name'],
							'L_LEVEL' => $lang['Adr_character_level'],
							'L_COST' => $lang['Adr_town_training_grounds_train_skill_cost'],
							'L_SELECT' => $lang['Select'],
							'L_SKILLS' => $lang['Adr_town_training_grounds_train_charac'],
							'L_SKILLS_ACTION' => $lang['Adr_town_training_grounds_train_charac_action'],
						));

						break;

					case 'train_charac_action' :

						$skill_id = intval($HTTP_POST_VARS['training_charac']);
						if ( !$skill_id )
						{
							adr_previous ( Adr_town_training_grounds_train_charac_must  , adr_TownMap_Entrainement , "mode=training&amp;sub_mode=train_charac" );	
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
							adr_substract_points( $user_id , $price , adr_TownMap_Entrainement , "mode=training&amp;sub_mode=train_charac" );
						}
						else
						{
							adr_substract_sp( $user_id , $price , adr_TownMap_Entrainement , "mode=training&amp;sub_mode=train_charac" );							
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
							WHERE c.class_might_req < u.character_might
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
							adr_previous ( Adr_town_training_grounds_train_upgrade_lack_class , adr_TownMap_Entrainement , "mode=training" );
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
							adr_previous ( Adr_town_training_grounds_select_upgrade_must  , adr_TownMap_Entrainement , "mode=training&amp;sub_mode=train_upgrade" );
						}

						adr_substract_points( $user_id , $adr_general['training_upgrade_cost'] , adr_TownMap_Entrainement , "mode=training&amp;sub_mode=train_upgrade" );

						$sql = " UPDATE " . ADR_CHARACTERS_TABLE . "
							SET character_class = $new_class
							WHERE character_id = $user_id ";
						if ( !$db->sql_query($sql))
						{
							message_die(CRITICAL_ERROR, 'Error updating ADR Classes!');
						}

						adr_update_posters_infos();
						adr_previous ( Adr_town_training_grounds_select_upgrade_done  , adr_character , '' );

						break;

					case 'change_class' :

						if ( !$adr_general['training_allow_change'] )
						{
							adr_previous ( Adr_town_training_grounds_change_class_forbid , adr_TownMap_Entrainement , "mode=training" );
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
							adr_previous ( Adr_town_training_grounds_change_class_lack_class , adr_TownMap_Entrainement , "mode=training" );
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
							adr_previous ( Adr_town_training_grounds_change_class_must  , adr_TownMap_Entrainement , "mode=training&amp;sub_mode=change_class" );
						}

						adr_substract_points( $user_id , $adr_general['training_change_cost'] , adr_TownMap_Entrainement , "mode=training&amp;sub_mode=change_class" );

						$sql = " UPDATE " . ADR_CHARACTERS_TABLE . "
							SET character_class = $new_class
							WHERE character_id = $user_id ";
						if ( !$db->sql_query($sql))
						{
							message_die(CRITICAL_ERROR, 'Error updating ADR Classes!');
						}

						adr_update_posters_infos();
						adr_previous ( Adr_town_training_grounds_change_class_done  , adr_character , '' );

						break;
				}
			}

			break;
	}
}

else
{
	$template->assign_block_vars('main',array());
}

// Fix the values

$InfoEntrainement = $HTTP_POST_VARS['InfoEntrainement'];

if ( $InfoEntrainement )
{
	adr_previous( Adr_TownMap_Entrainement_Infos , adr_TownMap_Entrainement , '' );
}

else

$template->assign_vars(array(

	'SAISON' => $saison,
	'L_TOWNMAP_ENTRAINEMENT' => $lang['TownMap_Entrainement'],
	'L_TOWNBOUTONINFO' => $lang['Adr_TownMap_Bouton_Infos'],
	'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
	'L_ENTRAINEMENTPRESENTATION' => $lang['Adr_TownMap_Entrainement_Presentation'],
	'L_ENTRAINEMENTENTREE' => $lang['TownMap_Entrainement_Entree'],
	'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
	'L_TOWN_TRAINING' => $lang['Adr_town_training_grounds'],
	'L_TOWN_WAREHOUSE' => $lang['Adr_town_warehouse'],
	'L_COPYRIGHT' => $lang['Adr_copyright'],
	'L_TOWN_TRAINING_SKILL' => $lang['Adr_town_training_grounds_train_skill'],
	'L_TOWN_TRAINING_UPGRADE' => $lang['Adr_town_training_grounds_train_upgrade'],
	'L_TOWN_TRAINING_CHARAC' => $lang['Adr_town_training_grounds_train_charac'],
	'L_TOWN_TRAINING_CHANGE' => $lang['Adr_town_training_grounds_change_class'],
	'L_CHALLENGE' => $lang['TownMap_Entrainement_Challenge'],
	'U_TOWN_TRAINING_SKILL' => append_sid("adr_TownMap_Entrainement.$phpEx?mode=training&amp;sub_mode=train_skill"),
	'U_TOWN_TRAINING_UPGRADE' => append_sid("adr_TownMap_Entrainement.$phpEx?mode=training&amp;sub_mode=train_upgrade"),
	'U_TOWN_TRAINING_CHARAC' => append_sid("adr_TownMap_Entrainement.$phpEx?mode=training&amp;sub_mode=train_charac"),
	'U_TOWN_TRAINING_CHANGE' => append_sid("adr_TownMap_Entrainement.$phpEx?mode=training&amp;sub_mode=change_class"),
	'U_CHALLENGE' => append_sid("adr_character_pvp.$phpEx"),
	'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
	'U_TOWNBOUTONRETOUR' => append_sid("adr_TownMap.$phpEx"),
	'U_TOWNMAP_ENTRAINEMENT' => append_sid("adr_TownMap_Entrainement.$phpEx"),
	'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
	'U_TOWN_TRAINING' => append_sid("adr_TownMap_Entrainement.$phpEx?mode=training"),
	'U_TOWN_WAREHOUSE' => append_sid("adr_shops.$phpEx?mode=see_warehouse"),
	'S_TOWN_ACTION'=> append_sid("adr_TownMap_Entrainement.$phpEx"),
	'S_CHARACTER_ACTION' => append_sid("adr_TownMap_Entrainement.$phpEx"),
));

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 