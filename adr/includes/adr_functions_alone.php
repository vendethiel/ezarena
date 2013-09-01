<?php
/***************************************************************************
 *                                 adr_functions_alone.php
 *                            -------------------
 *   begin                : 11/02/2004
 *   copyright            : Dr DLP / Malicious Rabbit
 *   email                : ukc@wanadoo.fr
 *
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
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

function adr_delete_character($user_id)
{
	global $db , $phpbb_root_path , $phpEx , $table_prefix ;

	define('IN_ADR_ADMIN', 1);
	define('IN_ADR_SHOPS', 1);
	define('IN_ADR_SETTINGS', 1);
	define('IN_ADR_VAULT', 1);
	define('IN_ADR_BATTLE', 1);
	define('IN_ADR_TEMPLE', 1);
	define('IN_ADR_CHARACTER', 1);

	include_once($phpbb_root_path . 'includes/constants.'.$phpEx);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$user_id = intval($user_id);

	$sql = " DELETE FROM " . ADR_CHARACTERS_TABLE . "
		WHERE character_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Cannot delete this user', '', __LINE__, __FILE__, $sql);
	}

	$sql = " DELETE FROM " . ADR_SHOPS_TABLE . "
		WHERE shop_owner_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Cannot delete this user', '', __LINE__, __FILE__, $sql);
	}

	$sql = " DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
		WHERE item_owner_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Cannot delete this user', '', __LINE__, __FILE__, $sql);
	}

	$sql = " DELETE FROM " . ADR_VAULT_BLACKLIST_TABLE . "
		WHERE user_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Cannot delete this user', '', __LINE__, __FILE__, $sql);
	}

	$sql = " DELETE FROM " . ADR_VAULT_EXCHANGE_USERS_TABLE . "
		WHERE user_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Cannot delete this user', '', __LINE__, __FILE__, $sql);
	}

	$sql = " DELETE FROM " . ADR_VAULT_USERS_TABLE . "
		WHERE owner_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Cannot delete this user', '', __LINE__, __FILE__, $sql);
	}

	$sql = " DELETE FROM " . ADR_BATTLE_LIST_TABLE . "
		WHERE battle_challenger_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Cannot delete this user', '', __LINE__, __FILE__, $sql);
	}
}

function adr_add_experience_points($user_id,$mode)
{
	global $lang , $phpEx , $userdata , $db , $board_config, $phpbb_root_path, $table_prefix ;

	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path . 'adr/includes/adr_constants.'.$phpEx);

	$user_id = intval($user_id);

	switch($mode)
	{
		case 'newtopic' :

			$more_xp = $board_config['Adr_experience_for_new'];

		break;

		case 'reply' :

			$more_xp = $board_config['Adr_experience_for_reply'];

		break;

		case 'editpost' :

			$more_xp = $board_config['Adr_experience_for_edit'];

		break;

		default :

			$more_xp = 0;

		break;
	}

	$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
		SET character_xp = character_xp + $more_xp
		WHERE character_id = $user_id ";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Error in posting', '', __LINE__, __FILE__, $sql);
	}
}

#======================================================================= |
#==== Start: == Viewtopic Functions ==================================== |
#==== Ripped from v1.0.0 code ========================================== |
#====

#==== Lets try to build the above functions a bit better. I know mr Ptirhiik had everything
#==== all nice & cached, but yea, 4 queries PER POST was not working So lets use 5 Queries TOTAL.
function adr_get_posters_adr_info()
{
	global $db, $phpbb_root_path, $phpEx, $table_prefix;
	include_once($phpbb_root_path .'adr/includes/adr_constants.'. $phpEx);

	$q = "SELECT * FROM ". ADR_GENERAL_TABLE;
	$r = $db->sql_query($q, false, 'adr_config');
	while ($row = $db->sql_fetchrow($r))
		$config[$row['config_name']] = $row['config_value'];
	$db->sql_freeresult($r);

	return $config;
}

function adr_get_posters_pvp_info()
{
	global $db, $table_prefix;

	#==== I tried to use the defined name, but the shit wouldn't work unless it was like this
	$q = "SELECT * FROM ". $table_prefix .'adr_battle_pvp';
	$r = $db->sql_query($q, false, 'adr_infos');
	$pvp = $db->sql_fetchrowset($r);
	$db->sql_freeresult($r);
	return $pvp;
}

function adr_get_posters_char_info()
{
	global $db, $phpbb_root_path, $phpEx, $table_prefix;
	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path .'adr/includes/adr_constants.'. $phpEx);

	$q = "SELECT * FROM ". ADR_CHARACTERS_TABLE;
	$r = $db->sql_query($q, false);
	$char = $db->sql_fetchrowset($r);

	return $char;
}

function adr_get_posters_alignment_info()
{
	global $db, $phpbb_root_path, $phpEx, $table_prefix;
	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path .'adr/includes/adr_constants.'. $phpEx);

	$q = "SELECT * FROM ". ADR_ALIGNMENTS_TABLE;
	$r = $db->sql_query($q, false, 'adr_infos');
	$alig = $db->sql_fetchrowset($r);
	$db->sql_freeresult($r);
	return $alig;
}

function adr_get_posters_class_info()
{
	global $db, $phpbb_root_path, $phpEx, $table_prefix;
	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path .'adr/includes/adr_constants.'. $phpEx);

	$q = "SELECT * FROM ". ADR_CLASSES_TABLE;
	$r = $db->sql_query($q, false, 'adr_infos');
	$clas = $db->sql_fetchrowset($r);
	$db->sql_freeresult($r);
	return $clas;
}

function adr_get_posters_races_info()
{
	global $db, $phpbb_root_path, $phpEx, $table_prefix;
	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path .'adr/includes/adr_constants.'. $phpEx);

	$q = "SELECT * FROM ". ADR_RACES_TABLE;
	$r = $db->sql_query($q, false, 'adr_infos');
	$race = $db->sql_fetchrowset($r);
	$db->sql_freeresult($r);
	return $race;
}

function adr_get_posters_elements_info()
{
	global $db, $phpbb_root_path, $phpEx, $table_prefix;
	define('IN_ADR_CHARACTER', 1);
	include_once($phpbb_root_path .'adr/includes/adr_constants.'. $phpEx);

	$q = "SELECT *
		  FROM ". ADR_ELEMENTS_TABLE;
	$r = $db->sql_query($q, false, 'adr_infos');
	$elem = $db->sql_fetchrowset($r);
	$db->sql_freeresult($r);

	return $elem;
}

function character_rank_info()
{
	global $db, $phpbb_root_path, $phpEx, $table_prefix;

	include_once($phpbb_root_path .'adr/includes/adr_constants.'. $phpEx);
	define('IN_ADR_CHARACTER', 1);

	$q = "SELECT character_id, SUM(character_victories + character_defeats + character_flees) AS most_active
		  FROM ". ADR_CHARACTERS_TABLE ."
		  GROUP BY character_id
		  ORDER BY most_active DESC";
	if (!$r = $db->sql_query($q))
		message_die(GENERAL_ERROR, 'Error Sorting ADR Ranks.', '', __LINE__, __FILE__, $q);
	$ranks = $db->sql_fetchrowset($r);

	return $ranks;
}

function adr_display_poster_infos($poster_id, $character_info, $race_info, $element_info, $class_info, $alignment_info, $pvp_info, $adr_con_info, $job_info, $user_cell_time)
{
	global $db, $phpbb_root_path, $lang, $board_config, $phpEx, $table_prefix, $userdata;
	define('IN_ADR_CHARACTER', 1);
	define('IN_ADR_BATTLE', 1);
	include_once($phpbb_root_path .'adr/includes/adr_constants.'. $phpEx);
	include_once($phpbb_root_path .'adr/includes/adr_global.'. $phpEx);
	include_once($phpbb_root_path .'adr/includes/adr_functions_battle.'. $phpEx);

	$adr_general 			= $adr_con_info;
	$topic_config 			= explode('-', $board_config['Adr_topics_display']);
	$adr_topic_box 			= '';
	$character_rank_info 	= character_rank_info();
	$total_ranks			= number_format(count($character_rank_info));

	if((!$topic_config[0]) && (!$topic_config[1]) && (!$topic_config[2]) && (!$topic_config[3]) && (!$topic_config[4]) && (!$topic_config[5]))
		return $adr_topic_box;

		for ($adr = 0; $adr < count($character_info); $adr++)
			{
			$adr_topic_box = '';
			if (($character_info[$adr]['character_id'] == $poster_id) && ($character_info[$adr]['character_class'] > '0'))
				{
				for ($x = 0; $x < count($character_rank_info); $x++)
					{
					if ($character_rank_info[$x]['character_id'] == $poster_id)
						$rank = sprintf($lang['adr_stats_rank'], ($x + 1), $total_ranks);
					}

				$adr_topic_box .= '<fieldset class="fieldset" style="margin: 0px 0px 0px 0px;">';
				$adr_topic_box .= '<legend>'. $lang['Adr_character'] .'</legend>';

				#==== Show INACTIVE or JAILED status, if necessary
//				if($character_info[$adr]['character_prefs_active'] == '0'){
//					$adr_topic_box .= ($poster_id == $userdata['user_id']) ? sprintf($lang['Adr_character_inactive_topic'], '<a href="'. append_sid('adr_character_prefs.'. $phpEx .').'">', '</a>').'<br><br>' : sprintf($lang['Adr_character_inactive_topic'], '<b>', '</b>').'<br><br>';
//				}
//				elseif(($character_info[$adr]['character_prefs_active'] != '0') && ($user_cell_time > '0')){
				if($user_cell_time > '0'){
					$adr_topic_box .= ($poster_id != $userdata['user_id']) ? sprintf($lang['Adr_character_status_jail_topic'], '<a target="_blank" href="'. append_sid('adr_courthouse.'. $phpEx .'?celled_user_id='.$poster_id).'">', '</a>').'<br><br>' : sprintf($lang['Adr_character_status_jail_topic'], '<b>', '</b>').'<br><br>';
				}

				#==== Show character_name
				if ($topic_config[5])
					$adr_topic_box .= '&nbsp;<a href="'. append_sid('adr_character.'. $phpEx .'?u='. $character_info[$adr]['character_id']) .'">'. $character_info[$adr]['character_name'] .'</a><br>';

				#==== Show current rank
				if ($topic_config[7])
				$adr_topic_box .= '&nbsp;&nbsp;'. $rank .'<br>';

				##=== Show character level
				if ($topic_config[0])
					$adr_topic_box .= '&nbsp;&nbsp;'. $lang['Adr_topics_level'] .':&nbsp;'. $character_info[$adr]['character_level'] .'<br />';

				#==== Show PvP link where applicable
//				if(($topic_config[6]) && ($character_info[$adr]['prefs_pvp_allow'] == '1') && ($character_info[$adr]['character_prefs_active'] == '1') && ($character_info[$adr]['character_id'] != '0') && ($userdata['user_id'] > '0'))
				if(($topic_config[6]) && ($character_info[$adr]['prefs_pvp_allow'] == '1') && ($character_info[$adr]['character_id'] != '0') && ($userdata['user_id'] > '0'))
				{
					#==== Check if the user hasn't already exceeded his maximum number of defies allowed
					$total_battles = 0;
					for ($pvp = 0; $pvp < count($pvp_info); $pvp++)
					{
						if ( ($pvp_info[$pvp]['battle_opponent_id'] == $poster_id || $pvp_info[$pvp]['battle_challenger_id'] == $poster_id) && ($pvp_info[$pvp]['battle_result'] == '0' || $pvp_info[$pvp]['battle_result'] == '3') )
						{
							$total_battles = $total_battles + 1;
						if (!$pvp_info[$pvp]['battle_opponent_id'])
							break;
						}
					}

					if ( ($adr_general['battle_pvp_defies_max'] >= $total_battles) && $adr_general['battle_pvp_defies_max'] && $poster_id != $userdata['user_id'] )
					{
						for ($pvp = 0; $pvp < count($pvp_info); $pvp++)
						{
							if ( ($pvp_info[$pvp]['battle_challenger_id'] == $poster_id || $pvp_info[$pvp]['battle_challenger_id'] == $userdata['user_id']) && ($pvp_info[$pvp]['battle_opponent_id'] == $poster_id || $pvp_info[$pvp]['battle_opponent_id'] == $userdata['user_id']) && ($pvp_info[$pvp]['battle_result'] == '0' || $pvp_info[$pvp]['battle_result'] == '3') )
							{
								$this_battle_id		= $pvp_info[$pvp]['battle_id'];
								$this_battle_turn 	= $pvp_info[$pvp]['battle_turn'];
								$this_battle_result = $pvp_info[$pvp]['battle_result'];
								break;
							}
						} #==== Close 2nd for array

						if ($this_battle_id)
						{
							#==== Check if is current chars turn
							if($this_battle_turn == $userdata['user_id'])
							{
								$adr_topic_box .= '&nbsp;&nbsp;'. $lang['Adr_pvp_post_text'] . ':&nbsp;<a href="'. append_sid("adr_battle_pvp.$phpEx?battle_id=". $this_battle_id) .'" target="_parent">'. $lang['Adr_pvp_post_your_turn'] .'</a><br />';
							}
							elseif(($this_battle_turn == 0) && ($this_battle_result == 0))
							{
								$opponent_turn = sprintf($lang['Adr_pvp_post_opponent_turn'], $character_info[$adr]['character_name']);
								$adr_topic_box .= '&nbsp;&nbsp;'. $lang['Adr_pvp_post_text'] . ':&nbsp;<a href="'. append_sid("adr_character_pvp.$phpEx?mode=waiting") .'" target="_parent"><i>'. $lang['Adr_pvp_opponent_awaiting'] .'</i></a><br />';
							}
							else
							{
								$opponent_turn = sprintf($lang['Adr_pvp_post_opponent_turn'], $character_info[$adr]['character_name']);
								$adr_topic_box .= '&nbsp;&nbsp;'. $lang['Adr_pvp_post_text'] . ':&nbsp;<a href="'. append_sid("adr_battle_pvp.$phpEx?mode=see&amp;battle_id=". $this_battle_id) .'" target="_parent">'. $opponent_turn .'</a><br />';
							}
						}
						else
						{
							$total_battles = 0;
							for ($pvp = 0; $pvp < count($pvp_info); $pvp++)
							{
								if ( ($pvp_info[$pvp]['battle_opponent_id'] == $userdata['user_id'] || $pvp_info[$pvp]['battle_challenger_id'] == $userdata['user_id']) && ($pvp_info[$pvp]['battle_result'] == '0' || $pvp_info[$pvp]['battle_result'] == '3') )
								{
									$total_battles = $total_battles + 1;
									if (!$pvp_info[$pvp]['battle_opponent_id'])
										break;
								}
							}
							$total = $total_battles;

							if ( ($adr_general['battle_pvp_defies_max'] >= $total) && ($adr_general['battle_pvp_defies_max']) && ($poster_id != $userdata['user_id']))
								$adr_topic_box .= '&nbsp;&nbsp;'. $lang['Adr_pvp_post_text'] . ':&nbsp;<a href="'. append_sid("adr_character_pvp.$phpEx?mode=defy_action&amp;defied=". $poster_id).'" target="_parent">'. $lang['Adr_pvp_post_attack'] .'</a><br />';
							}
						} #==== Close 2nd if statement
					} #==== End of pvp check

				if ($topic_config[8]){
				$adr_topic_box .= '<br>'.$lang['Adr_character_battle_stats_title'].':<br>';
				$adr_topic_box .= '&nbsp;&nbsp;'.$lang['Adr_monster_list_hp'].': '.$character_info[$adr]['character_hp'].'/'.$character_info[$adr]['character_hp_max'].'<br>';
				$adr_topic_box .= '&nbsp;&nbsp;'.$lang['Adr_monster_list_mp'].': '.$character_info[$adr]['character_mp'].'/'.$character_info[$adr]['character_mp_max'].'<br>';
				$adr_topic_box .= '&nbsp;&nbsp;'.$lang['Adr_monster_list_att'].':&nbsp;'. adr_battle_make_att($character_info[$adr]['character_might'], $character_info[$adr]['character_dexterity']) .'<br>';
				$adr_topic_box .= '&nbsp;&nbsp;'.$lang['Adr_monster_list_def'].':&nbsp;'. adr_battle_make_def($character_info[$adr]['character_ac'], $character_info[$adr]['character_dexterity']) .'<br>';
				$adr_topic_box .= '&nbsp;&nbsp;'.$lang['Adr_monster_list_ma'].':&nbsp;'. adr_battle_make_magic_att($character_info[$adr]['character_intelligence']) .'<br>';
				$adr_topic_box .= '&nbsp;&nbsp;'.$lang['Adr_monster_list_md'].':&nbsp;'. adr_battle_make_magic_def($character_info[$adr]['character_wisdom']) .'<br>';
					}

				if (($topic_config[1]) || ($topic_config[2]) || ($topic_config[3]) || ($topic_config[4]))
					$adr_topic_box .= '<br>'.$lang['Adr_character_characteristics'].':<br>';

				if ($topic_config[1])
					{
				$adr_topic_box .= '&nbsp;&nbsp;'. $lang['Adr_topics_class'].':&nbsp;&nbsp;';

					for ($class = 0; $class < count($class_info); $class++)
						{
						if ($character_info[$adr]['character_class'] == $class_info[$class]['class_id'])
							{
						$class_lang = adr_get_lang($class_info[$class]['class_name']);
						$class_img	= $class_info[$class]['class_img'];
						break;
							}
						}

					if ($topic_config[1] == '1')
						$adr_topic_box .= $class_lang;
					else
						$adr_topic_box .= '<img src="adr/images/classes/'. $class_img .'">';

				$adr_topic_box .= '<br />';
					} #==== Close topic_config[1] if statement

				if ($topic_config[2])
					{
					$adr_topic_box .= '&nbsp;&nbsp;'. $lang['Adr_topics_race'].':&nbsp;&nbsp;';

					for ($race = 0; $race < count($race_info); $race++)
						{
						if ($character_info[$adr]['character_race'] == $race_info[$race]['race_id'])
							{
						$race_lang 	= adr_get_lang([$race_info[$race]['race_name']]);
						$race_img	= $race_info[$race]['race_img'];
						break;
							}
						}

					if ($topic_config[2] == '1')
						$adr_topic_box .= $race_lang;
					else
						$adr_topic_box .= '<img src="adr/images/races/'. $race_img .'">';
				$adr_topic_box .= '<br />';
					} #==== Close topic_config[2] if statement

				if ($topic_config[3])
					{
				$adr_topic_box .= '&nbsp;&nbsp;'. $lang['Adr_topics_element'].':&nbsp;&nbsp;';

					for ($elements = 0; $elements < count($element_info); $elements++)
						{
						if ($character_info[$adr]['character_element'] == $element_info[$elements]['element_id'])
							{
						$element_lang 	= adr_get_lang([$element_info[$elements]['element_name']]);
						$element_img	= $element_info[$elements]['element_img'];
						break;
							}
						}

					if ($topic_config[3] == '1')
						$adr_topic_box .= $element_lang;
					else
						$adr_topic_box .= '<img src="adr/images/elements/'. $element_img .'">';
				$adr_topic_box .= '<br />';
					} #==== Close topic_config[3] if statement

				if ($topic_config[4])
					{
					$adr_topic_box .= '&nbsp;&nbsp;'. $lang['Adr_topics_alignment'].':&nbsp;&nbsp;';

					for ($alignment = 0; $alignment < count($alignment_info); $alignment++)
						{
						if ($character_info[$adr]['character_alignment'] == $alignment_info[$alignment]['alignment_id'])
							{
						$alignment_lang = adr_get_lang([$alignment_info[$alignment]['alignment_name']]);
						$alignment_img = $alignment_info[$alignment]['alignment_img'];
						break;
							}
						}

					if ($topic_config[4] == '1')
						$adr_topic_box .= $alignment_lang;
					else
						$adr_topic_box .= '<img src="adr/images/alignments/'. $alignment_img .'">';
				$adr_topic_box .= '<br />';
					} #==== Close topic_config[4] if statement

				$adr_topic_box .= '</fieldset>';
				break;
				} #==== End if statement for matching id
			} #==== End for array
		return $adr_topic_box;
		} #==== End function

#====
#==== Author: aUsTiN [austin@phpbb-amod.com] [http://phpbb-tweaks.com] = |
#==== End: ==== Viewtopic Functions ==================================== |
#======================================================================= |
function adr_character_created_check($user_id)
{
	global $db , $lang , $phpEx , $phpbb_root_path , $board_config, $table_prefix ;

	$user_id = intval($user_id);

	// Check if user has created an ADR character or not
	$sql = "SELECT character_id FROM  " . ADR_CHARACTERS_TABLE . "
		WHERE character_id = $user_id ";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(CRITICAL_ERROR, 'Error checking if user has character'); 
	}	
	$row = $db->sql_fetchrow($result);

	if ( !$row['character_id'] ) 
	{	
		adr_previous( Adr_character_lack , 'adr_character' , '' );
	}
}

function adr_ban_check($user_id)
{
	global $db , $lang , $userdata;

	if ( $userdata['user_adr_ban'] != 0 ) 
	{	
		adr_previous ( Adr_character_ban , 'index' , '' );
	}
}
	
?>