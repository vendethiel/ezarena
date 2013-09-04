<?php 
/***************************************************************************
 *                                        adr_guilds_leader.php
 *                                ------------------------
 *        	begin                         : 30/05/2004
 *        	 copyright                     : Seteo-Bloke
 *		version				: v0.0.3
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
define('IN_ADR_TOWN', true); 
define('IN_ADR_GUILDS', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_BATTLE', true);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_guilds';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 
// End session management
//
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$user_id = $userdata['user_id'];
$points = $userdata['user_points'];
$admin_level = $userdata['user_level'];


// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
        $redirect = "adr_character.$phpEx";
        $redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
        header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('../../adr/templates/adr_guilds_leader_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config and character infos
$adr_general = adr_get_general_config();
$adr_user = adr_get_user_infos($user_id);


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

// Grab details from ADR Characters table...
$sql = "SELECT * FROM " . ADR_CHARACTERS_TABLE . " 
                WHERE character_id = $user_id ";
if ( !($result = $db->sql_query($sql)) ) 
{ 
        message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
}        
$char = $db->sql_fetchrow($result);
$character_id = $char['character_id'];
$character_name = $char['character_name'];
$character_level = $char['character_level'];
$character_guild_id = $char['character_guild_id'];
$character_guild_auth_id = $char['character_guild_auth_id'];
$character_guild_approval = $char['character_guild_approval'];



if ( $mode != "" )
{
        switch($mode)
        {
                        case 'guilds_leader_page' :

                              $guild_id = intval($HTTP_GET_VARS['guild_id']);

					$template->assign_block_vars('guilds_leader_page' , array());

                              // Grab details from Guilds table...
                              $sql = " SELECT * FROM " . ADR_GUILDS_TABLE . "
                                       WHERE guild_id = $guild_id ";
                              if( !($result = $db->sql_query($sql)) )
                              {
                                    message_die(GENERAL_ERROR, 'Could not query Guild table for info page', '', __LINE__, __FILE__, $sql);
                              }
                              $guilds_table = $db->sql_fetchrow($result);
                              $guilds_name = $guilds_table['guild_name'];
					$date_created = date( "F jS Y" , $guilds_table['guild_date_created'] );
					$date_length = floor( ( time() - $guilds_table['guild_date_created'] ) / 86400 ) ;

					// If Guild has logo URL then show...
					if ($guilds_table['guild_logo'] == '')
					{
						$guilds_logo = $lang['Adr_guilds_logo_none'];
					}
					else
					{
                              	// Resize logo if too large...
                               	list($width, $height) = getimagesize($guilds_table['guild_logo']);
                              	$width_attr = '';
                             		$height_attr = '';
                               	$max_height = 200;
                              	$max_width = 250;

                             		$resize = $width > $max_width || $height > $max_height;

                               	// Resize to new dimensions...
                               	if ( $resize )
                                	{
                               		if ( $width == $height ) 
                                          {
                                          	$width_attr = 'width="' . $max_width . '"';
                                           	$height_attr = 'height="' . $max_height . '"';
                                          }
                                          else if ( $width > $height )
                                          {
                                          	$width_attr = 'width="' . $max_width . '"';
                                          	$height_attr = 'height="' . $max_height * $height / $width . '"';
                                          }
                                          else
                                         	{
                                          	$width_attr = 'width="' . $max_width * $width / $height . '"';
                                          	$height_attr = 'height="' . $max_height . '"';
                                          }
                              	}

                              	$guilds_logo = '<img src="' . $guilds_table['guild_logo'] . '" alt="" border="0"' . $width_attr . $height_attr . '>';
					}

					// Work out Exp bars...
					if ($guilds_table['guild_exp'] <= $guilds_table['guild_exp_max'])
					{
						$exp_fullwidth = floor(( $guilds_table['guild_exp'] / $guilds_table['guild_exp_max']) * 100 );
						$exp_full = ($exp_fullwidth != 0) ? '<img src="adr/images/misc/barfull.gif" width="'.$exp_fullwidth.'" height="10" border="0" ALT="' . $exp_fullwidth . '%">' : '';
						$exp_emptywidth = 100 - $exp_fullwidth;
						$exp_empty = ($exp_emptywidth != 0) ? '<img src="adr/images/misc/barempty.gif" width="'.$exp_emptywidth.'" height="10" border="0" ALT="' . $exp_fullwidth . '%">' : '';
						$exp_bar = '<img src="adr/images/misc/barstart.gif" width="2" height="10" border="0">'.$exp_full.$exp_empty.'<img src="adr/images/misc/barend.gif" width="2" height="10" border="0">';
					}
                
					// Count current guild members
					$sql = " SELECT character_guild_id FROM " . ADR_CHARACTERS_TABLE . "
						WHERE character_guild_id = $guild_id ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query count for info page', '', __LINE__, __FILE__, $sql);
					}
					$count_members = $db->sql_numrows($result);

					// Count characters awaiting approval
					$sql = " SELECT character_guild_approval FROM " . ADR_CHARACTERS_TABLE . "
						WHERE character_guild_approval = $guild_id ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query count for total awaiting approval', '', __LINE__, __FILE__, $sql);
					}
					$total_awaiting = $db->sql_numrows($result);

					$template->assign_vars(array(
						'U_GUILDS_LEADER' => $guilds_table['guild_name'],
						'L_GUILDS_LEADER_DESC' => $lang['Adr_guilds_leader_desc'],
						'U_GUILDS_LEADER_GUILD_DESC' => $guilds_table['guild_description'],
						'L_GUILDS_LEADER_CP' => $lang['Adr_guilds_leader_cp'],
						'U_GUILDS_INFO_LOGO' => $guilds_logo,
						'U_GUILDS_INFO_EXP' => $exp_bar,
						'U_GUILDS_LEADER_LOGO' => $guilds_table['guild_logo'],
						'L_GUILDS_LEADER_LOGO' => $lang['Adr_guilds_logo'],
						'L_GUILDS_LEADER_GENERAL' => $lang['Adr_guilds_leader_general'],
						'L_GUILDS_INFO' => $lang['Adr_guilds_info'],
						'L_GUILDS_INFO_LEADER' => $lang['Adr_guilds_info_leader'],
						'U_GUILDS_INFO_LEADER' => $guilds_table['guild_leader'],
						'L_GUILDS_INFO_MEMBERS' => $lang['Adr_guilds_info_members'],
						'U_GUILDS_INFO_MEMBERS' => $count_members,
						'L_GUILDS_INFO_LEVEL' => $lang['Adr_guilds_info_level'],
						'U_GUILDS_INFO_LEVEL' => $guilds_table['guild_level'],
						'L_GUILDS_INFO_VAULT' => $lang['Adr_guilds_info_vault'],
						'L_GUILDS_INFO_POINTS' => $board_config['points_name'],
						'U_GUILDS_INFO_VAULT' => $guilds_table['guild_vault'],
						'L_GUILDS_INFO_DATE' => $lang['Adr_guilds_info_date'],
						'U_GUILDS_INFO_DATE' => $date_created,
						'L_GUILDS_INFO_LENGTH' => $lang['Adr_guilds_info_length'],
						'L_GUILDS_INFO_DATE2' => $lang['Adr_guilds_info_date2'],
						'U_GUILDS_INFO_DATE2' => $date_length,
						'L_GUILDS_MANAGEMENT' => $lang['Adr_guilds_management'],
						'L_GUILDS_LEADER_APPROVE' => $lang['Adr_guilds_leader_approve'],
						'U_GUILDS_APPROVE_COUNT' => $total_awaiting,
						'U_GUILDS_LEADER_APPROVE' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_approve_list&amp;sub_mode=&amp;guild_id=$guild_id"),
						'L_GUILDS_LEADER_USERS' => $lang['Adr_guilds_leader_users'],
						'U_GUILDS_LEADER_USERS' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_users&amp;sub_mode=&amp;guild_id=$guild_id"),
						'L_GUILDS_LEADER_SET_RANKS' => $lang['Adr_guilds_leader_set_ranks'],
						'U_GUILDS_LEADER_SET_RANKS' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_set_ranks&amp;sub_mode=&amp;guild_id=$guild_id"),
						'L_GUILDS_LEADER_NEW_LEADER' => $lang['Adr_guilds_leader_new_leader'],
						'U_GUILDS_LEADER_NEW_LEADER' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_new_leader&amp;sub_mode=&amp;guild_id=$guild_id"),
						'L_GUILDS_LEADER_DELETE' => $lang['Adr_guilds_leader_delete'],
						'U_GUILDS_LEADER_DELETE' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_delete_confirm&amp;sub_mode=&amp;guild_id=$guild_id"),
						'L_GUILDS_INFO_JOIN_REQS' => $lang['Adr_guilds_join_reqs'],
						'L_GUILDS_INFO_JOIN_ACCEPT_NEW' => $lang['Adr_guilds_join_accept_new'],
						'U_GUILDS_ACCEPT_NEW_CHECKED' => ( $guilds_table['guild_accept_new'] ? 'CHECKED' :'' ),
						'U_NO_GUILDS_ACCEPT_NEW_CHECKED' => ( !$guilds_table['guild_accept_new'] ? 'CHECKED' :'' ),
						'L_GUILDS_INFO_JOIN_LEVEL' => $lang['Adr_guilds_join_reqs_level'],
						'U_GUILDS_INFO_JOIN_LEVEL' => $guilds_table['guild_join_min_level'],
						'L_GUILDS_INFO_JOIN_MONEY' => $lang['Adr_guilds_join_reqs_money'],
						'U_GUILDS_INFO_JOIN_MONEY' => $guilds_table['guild_join_min_money'],
						'L_GUILDS_INFO_JOIN_APPROVE_NEW' => $lang['Adr_guilds_join_approve'],
						'U_GUILDS_APPROVE_NEW_CHECKED' => ( $guilds_table['guild_approve'] ? 'CHECKED' :'' ),
						'U_NO_GUILDS_APPROVE_NEW_CHECKED' => ( !$guilds_table['guild_approve'] ? 'CHECKED' :'' ),
						'L_GUILDS_INFO_RANKS' => $lang['Adr_guilds_info_ranks'],
						'U_GUILDS_INFO_RANKS' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_ranks&amp;guild_id=$guild_id"),
						'L_GUILDS_LEADER_RANK_LEADER' => $lang['Adr_guilds_leader_rank_leader'],
						'U_GUILDS_LEADER_RANK_LEADER' => $guilds_table['guild_rank_leader'],
						'L_GUILDS_LEADER_RANK1' => $lang['Adr_guilds_leader_rank1'],
						'U_GUILDS_LEADER_RANK1' => $guilds_table['guild_rank_1'],
						'L_GUILDS_LEADER_RANK2' => $lang['Adr_guilds_leader_rank2'],
						'U_GUILDS_LEADER_RANK2' => $guilds_table['guild_rank_2'],
						'L_GUILDS_LEADER_RANK3' => $lang['Adr_guilds_leader_rank3'],
						'U_GUILDS_LEADER_RANK3' => $guilds_table['guild_rank_3'],
						'L_GUILDS_LEADER_RANK4' => $lang['Adr_guilds_leader_rank4'],
						'U_GUILDS_LEADER_RANK4' => $guilds_table['guild_rank_4'],
						'L_GUILDS_LEADER_RANK5' => $lang['Adr_guilds_leader_rank5'],
						'U_GUILDS_LEADER_RANK5' => $guilds_table['guild_rank_5'],
						'L_GUILDS_LEADER_RANK_MEMBER' => $lang['Adr_guilds_leader_rank_member'],
						'U_GUILDS_LEADER_RANK_MEMBER' => $guilds_table['guild_rank_member'],
						'L_GUILDS_LEADER_BIO' => $lang['Adr_guilds_leader_bio'],
						'U_GUILDS_LEADER_BIO' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_bio&amp;sub_mode=&amp;guild_id=$guild_id"),
						'L_SUBMIT' => $lang['Adr_guilds_submit'],
						'U_SUBMIT' => append_sid("adr_guilds.$phpEx?mode=guilds_leader_page_update&amp;sub_mode="),
						'L_YES' => $lang['Adr_guilds_yes'],
						'L_NO' => $lang['Adr_guilds_no'],
						'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
						'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
					));

					break;


					case 'guilds_leader_page_update' :

					// Define some actions
					$guild_id = intval($HTTP_GET_VARS['guild_id']);
					$accept_new = intval($HTTP_POST_VARS['accept_new']);
					$approve = intval($HTTP_POST_VARS['approve_enable']);
					$min_join_level = intval($HTTP_POST_VARS['min_join_level']);
					$min_join_money = intval($HTTP_POST_VARS['min_join_money']);					
					$desc = ( isset($HTTP_POST_VARS['desc']) ) ? trim($HTTP_POST_VARS['desc']) : trim($HTTP_GET_VARS['desc']);
					$logo = ( isset($HTTP_POST_VARS['logo']) ) ? trim($HTTP_POST_VARS['logo']) : trim($HTTP_GET_VARS['logo']);
					$rank_leader = ( isset($HTTP_POST_VARS['rank_leader']) ) ? trim($HTTP_POST_VARS['rank_leader']) : trim($HTTP_GET_VARS['rank_leader']);
					$rank1 = ( isset($HTTP_POST_VARS['rank1']) ) ? trim($HTTP_POST_VARS['rank1']) : trim($HTTP_GET_VARS['rank1']);
					$rank2 = ( isset($HTTP_POST_VARS['rank2']) ) ? trim($HTTP_POST_VARS['rank2']) : trim($HTTP_GET_VARS['rank2']);
					$rank3 = ( isset($HTTP_POST_VARS['rank3']) ) ? trim($HTTP_POST_VARS['rank3']) : trim($HTTP_GET_VARS['rank3']);
					$rank4 = (isset($HTTP_POST_VARS['rank4']) ) ? trim($HTTP_POST_VARS['rank4']) : trim($HTTP_GET_VARS['rank4']);
					$rank5 = ( isset($HTTP_POST_VARS['rank5']) ) ? trim($HTTP_POST_VARS['rank5']) : trim($HTTP_GET_VARS['rank5']);
					$rank_member = ( isset($HTTP_POST_VARS['rank_member']) ) ? trim($HTTP_POST_VARS['rank_member']) : trim($HTTP_GET_VARS['rank_member']);

					// Update guild leader page...
					$sql = "UPDATE " . ADR_GUILDS_TABLE . "
						SET guild_accept_new = $accept_new , 
							guild_approve = $approve, 
							guild_join_min_level = $min_join_level , 
							guild_join_min_money = $min_join_money , 
							guild_description = '$desc' , 
							guild_logo = '$logo' , 
							guild_rank_leader = '$rank_leader' , 
							guild_rank_1 = '$rank1' , 
							guild_rank_2 = '$rank2' , 
							guild_rank_3 = '$rank3' , 
							guild_rank_4 = '$rank4' , 
							guild_rank_5 = '$rank5' , 
							guild_rank_member = '$rank_member' 
						WHERE guild_id = $guild_id ";
					if( !$db->sql_query($sql))
					{
						message_die(GENERAL_ERROR, 'Could not update Leader page settings',"", __LINE__, __FILE__, $sql);
					}

					adr_previous( Adr_guilds_leader_page_updated , adr_guilds_leader , "mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=".$guild_id."" );
                                                
					break;


				case 'guilds_users' :

					$guild_id = intval($HTTP_GET_VARS['guild_id']);

					$template->assign_block_vars('guilds_users' , array());

					// Grab details from Guilds table...
					$sql = " SELECT * FROM " . ADR_CHARACTERS_TABLE . " 
							LEFT JOIN " . ADR_GUILDS_TABLE . "
							ON " . ADR_CHARACTERS_TABLE . ".character_guild_id = " . ADR_GUILDS_TABLE . ".guild_id 
						WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id 
						AND " . ADR_CHARACTERS_TABLE . ".character_id <> " . ADR_GUILDS_TABLE . ".guild_leader_id ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 1', '', __LINE__, __FILE__, $sql);
					}

					$action_select = '<select name="mode">';
					$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
					$action_select .= '<option value = "guilds_users_update">' . $lang['Adr_guilds_users_remove'] . '</option>';
					$action_select .= '</select>';

					if ( $guilds_table = $db->sql_fetchrow($result) )
					{
						$i = 0;
						do
						{
							$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

							$template->assign_block_vars('guilds_users.rows', array(
								"USERS_ROW" => $i + 1,
								"ROW_CLASS" => $row_class,
								"USERS_ID" => $guilds_table['character_id'],
								"USERS_NAME" => $guilds_table['character_name'],
								"USERS_LEVEL" => $guilds_table['character_level'],
								"USERS_HP" => $guilds_table['character_hp_max'],
								"USERS_MP" => $guilds_table['character_mp_max'],
								"USERS_WINS" => $guilds_table['character_victories'],
								"USERS_DEFEATS" => $guilds_table['character_defeats'],
								"USERS_FLEES" => $guilds_table['character_flees'],
								"USERS_HOPS" => $guilds_table['character_guild_hops'],
								));

							$i++;
						}
							while ( $guilds_table = $db->sql_fetchrow($result) );
					}

					$template->assign_vars(array(
						'L_USERS_ROW' => $lang['Adr_guilds_position'],
						'ACTION_SELECT' => $action_select,
						'GUILD_ID' => $guild_id,
						'L_USERS_LIST' => $lang['Adr_guilds_users'],
						'L_USERS_NAME' => $lang['Adr_guilds_approve_applicant'],
						'L_USERS_LEVEL' => $lang['Adr_guilds_approve_level'],
						'L_USERS_HP' => $lang['Adr_guilds_approve_hp'],
						'L_USERS_MP' => $lang['Adr_guilds_approve_mp'],
						'L_USERS_WINS' => $lang['Adr_guilds_approve_wins'],
						'L_USERS_DEFEATS' => $lang['Adr_guilds_approve_defeats'],
						'L_USERS_FLEES' => $lang['Adr_guilds_approve_flees'],
						'L_USERS_HOPS' => $lang['Adr_guilds_approve_hops'],
						'L_USERS_SELECT' => $lang['Adr_guilds_approve_select'],
						'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
						'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=$guild_id"),
						'L_SUBMIT' => $lang['Adr_guilds_submit'],
						'U_SUBMIT' => append_sid("adr_guilds.$phpEx?mode=$action_select&amp;sub_mode=&amp;guild_id=$guild_id&amp;users_box=$users_id"),
					));
                                                
					break;


					case 'guilds_users_update' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);
						$users_id = ( isset($HTTP_POST_VARS['users_box']) ) ? $HTTP_POST_VARS['users_box'] : array();

						if ( count($users_id) > 0 )
						{        
							for($i = 0; $i < count($users_id); $i++)
							{
								$member_id = $users_id[$i];

								// Remove Guilds details from Character table...
								$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
									SET character_guild_auth_id = 0 , 
										character_guild_approval = 0 , 
										character_guild_id = 0 , 
										character_guild_hops = character_guild_hops + 1     
									WHERE character_id = $member_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not update rejected characters',"", __LINE__, __FILE__, $sql);
								}

								// Grab details from Guilds table...
								$sql = " SELECT guild_name FROM " . ADR_GUILDS_TABLE . "
									WHERE guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for info page', '', __LINE__, __FILE__, $sql);
								}
								$guilds_table = $db->sql_fetchrow($result);
                                        
								// Send user PM notification...
								$subject = sprintf($lang['Adr_guilds_users_pm_remove_subject'] , $guilds_table['guild_name']);
								$message = sprintf($lang['Adr_guilds_users_pm_remove_msg'] , $guilds_table['guild_name'] , $character_name , $character_name);
	
								// Grab details from Guilds table...
								$sql = " SELECT character_guild_prefs_notify FROM " . ADR_CHARACTERS_TABLE . "
										WHERE character_id = $member_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for users update page', '', __LINE__, __FILE__, $sql);
								}
								$character = $db->sql_fetchrow($result);
                                                                                
								if ( $character['character_guild_prefs_notify'] )
								{
									adr_send_pm ( $member_id , $subject , $message );
								}
							}
						}

						adr_previous( Adr_guilds_leader_users_updated , adr_guilds_leader , "mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=".$guild_id."" );
                                                
					break;


				case 'guilds_leader_set_ranks' :

					$guild_id = intval($HTTP_GET_VARS['guild_id']);

					$template->assign_block_vars('guilds_leader_set_ranks' , array());

					// Grab all current rank names
					$sql = " SELECT * FROM " . ADR_GUILDS_TABLE . "
						WHERE guild_id = $guild_id ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query Guild table for Ranks', '', __LINE__, __FILE__, $sql);
					}
					$ranks = $db->sql_fetchrow($result);

					// Grab rank 1
					$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
							LEFT JOIN " . ADR_GUILDS_TABLE . "
							ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_1_id 
						WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 1', '', __LINE__, __FILE__, $sql);
					}
					$rank_member_1 = $db->sql_fetchrow($result);

					// If no rank member...
					if ($ranks['guild_rank_1_id'] == 0)
					{
						$rank_1 = $lang['Adr_guilds_rank_none'];
					}
					else
					{
						$rank_1 = $rank_member_1['character_name'];
					}

					// Grab rank 2
					$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
							LEFT JOIN " . ADR_GUILDS_TABLE . "
							ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_2_id 
						WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 2', '', __LINE__, __FILE__, $sql);
					}
					$rank_member_2 = $db->sql_fetchrow($result);

					// If no rank member...
					if ($ranks['guild_rank_2_id'] == 0)
					{
						$rank_2 = $lang['Adr_guilds_rank_none'];
					}
					else
					{
						$rank_2 = $rank_member_2['character_name'];
					}

					// Grab rank 3
					$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
							LEFT JOIN " . ADR_GUILDS_TABLE . "
							ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_3_id 
						WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 3', '', __LINE__, __FILE__, $sql);
					}
					$rank_member_3 = $db->sql_fetchrow($result);

					// If no rank member...
					if ($ranks['guild_rank_3_id'] == 0)
					{
						$rank_3 = $lang['Adr_guilds_rank_none'];
					}
					else
					{
						$rank_3 = $rank_member_3['character_name'];
					}

					// Grab rank 4
					$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
							LEFT JOIN " . ADR_GUILDS_TABLE . "
							ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_4_id 
						WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 4', '', __LINE__, __FILE__, $sql);
					}
					$rank_member_4 = $db->sql_fetchrow($result);

					// If no rank member...
					if ($ranks['guild_rank_4_id'] == 0)
					{
						$rank_4 = $lang['Adr_guilds_rank_none'];
					}
					else
					{
						$rank_4 = $rank_member_4['character_name'];
					}

					// Grab rank 5
					$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
							LEFT JOIN " . ADR_GUILDS_TABLE . "
							ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_5_id 
						WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 5', '', __LINE__, __FILE__, $sql);
					}
					$rank_member_5 = $db->sql_fetchrow($result);

					// If no rank member...
					if ($ranks['guild_rank_5_id'] == 0)
					{
						$rank_5 = $lang['Adr_guilds_rank_none'];
					}
					else
					{
						$rank_5 = $rank_member_5['character_name'];
					}

					// Grab details from Guilds table
					$sql = " SELECT character_name , character_id FROM " . ADR_CHARACTERS_TABLE . " 
							LEFT JOIN " . ADR_GUILDS_TABLE . "
							ON " . ADR_CHARACTERS_TABLE . ".character_guild_id = " . ADR_GUILDS_TABLE . ".guild_id 
								WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id 
							AND " . ADR_CHARACTERS_TABLE . ".character_id <> " . ADR_GUILDS_TABLE . ".guild_leader_id ";
					if( !($result = $db->sql_query($sql)) )
					{
						message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 1', '', __LINE__, __FILE__, $sql);
					}
					$members = $db->sql_fetchrowset($result);
			
					// START lists for ranks

					$list_1 = '<select name="list_rank_1">';
                  		$list_1 .= '<option value = "0" >' . $lang['Adr_guilds_set_rank'] . '</option>';
                  		for( $i = 0; $i < count($members); $i++ )
                  		{
						$members[$i]['character_name'] = adr_get_lang($members[$i]['character_name']);
						$list_1_selected = ( $ranks['guild_rank_1_id'] == $members[$i]['character_id'] ) ? 'selected' : '';
						$list_1 .= '<option value = "'.$members[$i]['character_id'].'" '.$list_1_selected.' >' . $members[$i]['character_name'] . '</option>';
                 		 	}
                 		 	$list_1 .= '</select>';	

					$list_2 = '<select name="list_rank_2">';
                  		$list_2 .= '<option value = "0" >' . $lang['Adr_guilds_set_rank'] . '</option>';
                  		for( $i = 0; $i < count($members); $i++ )
                  		{
						$members[$i]['character_name'] = adr_get_lang($members[$i]['character_name']);
						$list_2_selected = ( $ranks['guild_rank_2_id'] == $members[$i]['character_id'] ) ? 'selected' : '';
						$list_2 .= '<option value = "'.$members[$i]['character_id'].'" '.$list_2_selected.' >' . $members[$i]['character_name'] . '</option>';
                 		 	}
                 		 	$list_2 .= '</select>';	

					$list_3 = '<select name="list_rank_3">';
                  		$list_3 .= '<option value = "0" >' . $lang['Adr_guilds_set_rank'] . '</option>';
                  		for( $i = 0; $i < count($members); $i++ )
                  		{
						$members[$i]['character_name'] = adr_get_lang($members[$i]['character_name']);
						$list_3_selected = ( $ranks['guild_rank_3_id'] == $members[$i]['character_id'] ) ? 'selected' : '';
						$list_3 .= '<option value = "'.$members[$i]['character_id'].'" '.$list_3_selected.' >' . $members[$i]['character_name'] . '</option>';
                 		 	}
                 		 	$list_3 .= '</select>';	

					$list_4 = '<select name="list_rank_4">';
                  		$list_4 .= '<option value = "0" >' . $lang['Adr_guilds_set_rank'] . '</option>';
                  		for( $i = 0; $i < count($members); $i++ )
                  		{
						$members[$i]['character_name'] = adr_get_lang($members[$i]['character_name']);
						$list_4_selected = ( $ranks['guild_rank_4_id'] == $members[$i]['character_id'] ) ? 'selected' : '';
						$list_4 .= '<option value = "'.$members[$i]['character_id'].'" '.$list_4_selected.' >' . $members[$i]['character_name'] . '</option>';
                 		 	}
                 		 	$list_4 .= '</select>';	

					$list_5 = '<select name="list_rank_5">';
                  		$list_5 .= '<option value = "0" >' . $lang['Adr_guilds_set_rank'] . '</option>';
                  		for( $i = 0; $i < count($members); $i++ )
                  		{
						$members[$i]['character_name'] = adr_get_lang($members[$i]['character_name']);
						$list_5_selected = ( $ranks['guild_rank_5_id'] == $members[$i]['character_id'] ) ? 'selected' : '';
						$list_5 .= '<option value = "'.$members[$i]['character_id'].'" '.$list_5_selected.' >' . $members[$i]['character_name'] . '</option>';
                 		 	}
                 		 	$list_5 .= '</select>';	

					$template->assign_vars(array(
						'L_RANK_SET_1' => $lang['Adr_guilds_set_rank_1'],
						'L_RANK_1' => $lang['Adr_guilds_rank_1'],
						'U_RANK_1' => $rank_1,
						'RANK_1' => $list_1,
						'L_RANK_SET_2' => $lang['Adr_guilds_set_rank_2'],
						'L_RANK_2' => $lang['Adr_guilds_rank_2'],
						'U_RANK_2' => $rank_2,
						'RANK_2' => $list_2,
						'L_RANK_SET_3' => $lang['Adr_guilds_set_rank_3'],
						'L_RANK_3' => $lang['Adr_guilds_rank_3'],
						'U_RANK_3' => $rank_3,
						'RANK_3' => $list_3,
						'L_RANK_SET_4' => $lang['Adr_guilds_set_rank_4'],
						'L_RANK_4' => $lang['Adr_guilds_rank_4'],
						'U_RANK_4' => $rank_4,
						'RANK_4' => $list_4,
						'L_RANK_SET_5' => $lang['Adr_guilds_set_rank_5'],
						'L_RANK_5' => $lang['Adr_guilds_rank_5'],
						'U_RANK_5' => $rank_5,
						'RANK_5' => $list_5,
						'L_MEMBERS_LIST' => $lang['Adr_guilds_set_rank_list'],
						'ACTION_SELECT' => $action_select,
						'GUILD_ID' => $guild_id,
						'L_SUBMIT' => $lang['Adr_guilds_submit'],
						'U_SUBMIT' => append_sid("adr_guilds_leader.$phpEx?mode=$action_select&amp;sub_mode=&amp;guild_id=$guild_id&amp;users_box=$users_id"),
					));
                                                
					break;


				case 'guilds_leader_set_ranks_update' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);
						$rank_1 = intval($HTTP_POST_VARS['list_rank_1']);
						$rank_2 = intval($HTTP_POST_VARS['list_rank_2']);
						$rank_3 = intval($HTTP_POST_VARS['list_rank_3']);
						$rank_4 = intval($HTTP_POST_VARS['list_rank_4']);
						$rank_5 = intval($HTTP_POST_VARS['list_rank_5']);

						$sql = "UPDATE " . ADR_GUILDS_TABLE . " 
							SET guild_rank_1_id = $rank_1,
								guild_rank_2_id = $rank_2,
								guild_rank_3_id = $rank_3,
								guild_rank_4_id = $rank_4,
								guild_rank_5_id = $rank_5  
							WHERE guild_id = $guild_id";
						if ( !($result2 = $db->sql_query($sql)) ) 
						{ 
							message_die(GENERAL_MESSAGE, 'Could not set ranks', '', __LINE__, __FILE__, $sql); 
						}

//						if ( $rank_1 != 0 )
//						{
//							// Update rank 1
//							$sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
//								SET character_guild_auth_id = 2,
//								WHERE character_id = $rank_1";
//							if ( !($result2 = $db->sql_query($sql)) ) 
//							{ 
//								message_die(GENERAL_MESSAGE, 'Could not set rank 1', '', __LINE__, __FILE__, $sql); 
//							}
//						}	

						adr_previous( Adr_guilds_leader_set_ranks_updated , adr_guilds_leader , "mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=".$guild_id."" );
                                                
					break;


				case 'guilds_leader_new_leader' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);

						$template->assign_block_vars('guilds_leader_new_leader' , array());

						// Grab details from Guilds table...
						$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
								LEFT JOIN " . ADR_GUILDS_TABLE . "
								ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_leader_id 
							WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
						if( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not query Guild table for new leader', '', __LINE__, __FILE__, $sql);
						}
						$old_leader = $db->sql_fetchrow($result);

						// Grab details from Guilds table...
						$sql = " SELECT character_id , character_name FROM " . ADR_CHARACTERS_TABLE . " 
								LEFT JOIN " . ADR_GUILDS_TABLE . "
								ON " . ADR_CHARACTERS_TABLE . ".character_guild_id = " . ADR_GUILDS_TABLE . ".guild_id 
							WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id 
								AND " . ADR_CHARACTERS_TABLE . ".character_id <> " . ADR_GUILDS_TABLE . ".guild_leader_id ";
						if( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not query Guild table for new leader', '', __LINE__, __FILE__, $sql);
						}
						$members = $db->sql_fetchrowset($result);

						$members_list = '<select name="list_members">';
						$members_list .= '<option value = "0" >' . $lang['Adr_guilds_no_members'] . '</option>';
						for ( $i = 0 ; $i < count($members) ; $i ++ )
						{
							$members_list .= '<option value = "'.$members[$i]['character_id'].'" >' . $members[$i]['character_name'] . '</option>';
						}
						$members_list .= '</select>';

						$template->assign_vars(array(
							'L_CURRENT_LEADER' => $lang['Adr_guilds_leader_current'],
							'U_CURRENT_LEADER' => $old_leader['character_name'],
							'L_NEW_LEADER' => $lang['Adr_guilds_leader_new'],
							'L_MEMBERS_LIST' => $lang['Adr_guilds_leader_select'],
							'U_MEMBERS_LIST' => $members_list,
							'L_SUBMIT' => $lang['Adr_guilds_submit'],
						));
                                                
					break;


				case 'guilds_leader_new_leader_update' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);
						$new_leader_id = intval($HTTP_POST_VARS['list_members']);

						// Grab current leader name...
						$sqla = " SELECT guild_rank_member , guild_leader_id FROM " . ADR_GUILDS_TABLE . " 
							WHERE guild_id = $guild_id ";
						if( !($resulta = $db->sql_query($sqla)) )
						{
							message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 1', '', __LINE__, __FILE__, $sql);
						}
						$guild_leader = $db->sql_fetchrow($resulta);

						// Set current Guild Leader as normal member...
						$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
							SET character_guild_auth_id = 0  
							WHERE character_id = '".$guild_leader['guild_leader_id']."' 
								AND character_guild_id = $guild_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not reset Leader to norm user',"", __LINE__, __FILE__, $sql);
						}

						// Set new leader
						$sql = "UPDATE " . ADR_GUILDS_TABLE . "
							SET guild_leader_id = $new_leader_id 
							WHERE guild_id = $guild_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not update Leader page settings',"", __LINE__, __FILE__, $sql);
						}

						// Set new Guild Leader in Character table...
						$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
							SET character_guild_auth_id = 1  
							WHERE character_id = $new_leader_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not reset Leader to norm user',"", __LINE__, __FILE__, $sql);
						}

						// Grab details from Guilds table...
						$sqlb = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
							LEFT JOIN " . ADR_GUILDS_TABLE . "
							ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_leader_id 
							WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
						if( !($resultb = $db->sql_query($sqlb)) )
						{
							message_die(GENERAL_ERROR, 'Could not query Guild table for leader name', '', __LINE__, __FILE__, $sql);
						}
						$leader_name = $db->sql_fetchrow($resultb);

						// Set new leader name...
						$sql = "UPDATE " . ADR_GUILDS_TABLE . "
							SET guild_leader = '".$leader_name['character_name']."'  
							WHERE guild_id = $guild_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could set new leader',"", __LINE__, __FILE__, $sql);
						}

						adr_previous( Adr_guilds_leader_new_leader_updated , adr_guilds_leader , "mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=".$guild_id."" );
                                                
					break;

				case 'guilds_leader_delete_confirm' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);

						adr_template_file('adr_guilds_confirm_body.tpl');
						$template->assign_block_vars('guilds_leader_delete_confirm' , array());

						$template->assign_vars(array(
							'L_GUILDS_DELETE_TITLE' => $lang['Adr_guilds_delete_title'],
							'L_GUILDS_DELETE_TEXT' => $lang['Adr_guilds_delete_text'],
							'L_YES' => $lang['Adr_guilds_yes'],
							'L_NO' => $lang['Adr_guilds_no'],
							'U_GUILDS_DELETE_YES' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_delete&amp;sub_mode=&amp;guild_id=$guild_id"),
							'U_GUILDS_DELETE_NO' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=$guild_id"),
						));
                                                			
					break;

				case 'guilds_leader_delete' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);

						// Reset all old Guild members to no guild status...
						$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
							SET character_guild_auth_id = 0 ,  
								character_guild_approval = 0 , 
								character_guild_id = 0 ,
								character_guild_join_date = '' 
							WHERE character_guild_id = $guild_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not reset old members stats',"", __LINE__, __FILE__, $sql);
						}

						// Delete Guild from Guilds Table...
						$sql = "DELETE FROM " . ADR_GUILDS_TABLE . " 
							WHERE guild_id = $guild_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not delete Guild from Guild table',"", __LINE__, __FILE__, $sql);
						}

						adr_previous( Adr_guilds_leader_delete_updated , adr_guilds , '' );
                                                
					break;

				case 'guilds_approve_list' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);

						$template->assign_block_vars('guilds_approve_list' , array());

						// Grab details from Guilds table...
						$sql = " SELECT * FROM " . ADR_CHARACTERS_TABLE . " 
							LEFT JOIN " . ADR_GUILDS_TABLE . "
								ON " . ADR_CHARACTERS_TABLE . ".character_guild_approval = " . ADR_GUILDS_TABLE . ".guild_id
							WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
						if( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 3', '', __LINE__, __FILE__, $sql);
						}

						// Define some actions
						$guilds_approve_select = intval($HTTP_POST_VARS['guilds_approve_select']);

						$action_select = '<select name="mode">';
						$action_select .= '<option value = "">' . $lang['Adr_items_select_action'] . '</option>';
						$action_select .= '<option value = "guilds_approve_yes">' . $lang['Adr_guilds_approve_yes'] . '</option>';
						$action_select .= '<option value = "guilds_approve_no">' . $lang['Adr_guilds_approve_no'] . '</option>';
						$action_select .= '</select>';

						if ( $guilds_table = $db->sql_fetchrow($result) )
						{
							$i = 0;
							do
							{
								$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

								$template->assign_block_vars('guilds_approve_list.rows', array(
									"APPROVE_ROW" => $i + 1,
									"ROW_CLASS" => $row_class,
									"APPROVE_ID" => $guilds_table['character_id'],
									"APPROVE_NAME" => $guilds_table['character_name'],
									"APPROVE_LEVEL" => $guilds_table['character_level'],
									"APPROVE_HP" => $guilds_table['character_hp_max'],
									"APPROVE_MP" => $guilds_table['character_mp_max'],
									"APPROVE_WINS" => $guilds_table['character_victories'],
									"APPROVE_DEFEATS" => $guilds_table['character_defeats'],
									"APPROVE_FLEES" => $guilds_table['character_flees'],
									"APPROVE_HOPS" => $guilds_table['character_guild_hops'],
								));

								$i++;
							}
								while ( $guilds_table = $db->sql_fetchrow($result) );
						}

						$template->assign_vars(array(
							'L_APPROVE_ROW' => $lang['Adr_guilds_position'],
							'ACTION_SELECT' => $action_select,
							'GUILD_ID' => $guild_id,
							'L_APPROVE_LIST' => $lang['Adr_guilds_approve_list'],
							'L_APPROVE_NAME' => $lang['Adr_guilds_approve_applicant'],
							'L_APPROVE_LEVEL' => $lang['Adr_guilds_approve_level'],
							'L_APPROVE_HP' => $lang['Adr_guilds_approve_hp'],
							'L_APPROVE_MP' => $lang['Adr_guilds_approve_mp'],
							'L_APPROVE_WINS' => $lang['Adr_guilds_approve_wins'],
							'L_APPROVE_DEFEATS' => $lang['Adr_guilds_approve_defeats'],
							'L_APPROVE_FLEES' => $lang['Adr_guilds_approve_flees'],
							'L_APPROVE_HOPS' => $lang['Adr_guilds_approve_hops'],
							'L_APPROVE_SELECT' => $lang['Adr_guilds_approve_select'],
							'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
							'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=$guild_id"),
							'L_YES' => $lang['Adr_guilds_yes'],
							'L_NO' => $lang['Adr_guilds_no'],
							'L_SUBMIT' => $lang['Adr_guilds_submit'],
							'U_SUBMIT' => append_sid("adr_guilds.$phpEx?mode=$action_select&amp;sub_mode=&amp;guild_id=$guild_id&amp;approve_box=$approve_id"),
						));
                                                
					break;

				case 'guilds_approve_yes' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);
						$approve_id = ( isset($HTTP_POST_VARS['approve_box']) ) ? $HTTP_POST_VARS['approve_box'] : array();
						$join_date = time();

						if ( count($approve_id) > 0 )
						{        
							for($i = 0; $i < count($approve_id); $i++)
							{
								$approved_user_id = $approve_id[$i];

								// Update Guilds details in Character table
								$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
										SET character_guild_auth_id = 0 , 
											character_guild_approval = 0 , 
											character_guild_id = $guild_id , 
											character_guild_join_date = $join_date 
										WHERE character_id = $approved_user_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not update approved characters',"", __LINE__, __FILE__, $sql);
								}

								// Grab details from Guilds table...
								$sql = " SELECT guild_name FROM " . ADR_GUILDS_TABLE . "
									WHERE guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for info page', '', __LINE__, __FILE__, $sql);
								}
								$guilds_table = $db->sql_fetchrow($result);
                                        
								// Send user PM notification...
								$subject = sprintf($lang['Adr_guilds_approve_pm_subject'] , $guilds_table['guild_name']);
								$message = sprintf($lang['Adr_guilds_approve_pm_yes'] , $guilds_table['guild_name'] , $character_name);

								// Grab details from Guilds table...
								$sql = " SELECT character_guild_prefs_notify FROM " . ADR_CHARACTERS_TABLE . "
										WHERE character_id = $approved_user_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for approve yes', '', __LINE__, __FILE__, $sql);
								}
								$character = $db->sql_fetchrow($result);
                                                                                
								if ( $character['character_guild_prefs_notify'] )
								{
									adr_send_pm ( $approved_user_id , $subject , $message );
								}
							}		
						}

						adr_previous( Adr_guilds_approve_list_approve , adr_guilds_leader , "mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=".$guild_id."" );        

					break;


				case 'guilds_approve_no' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);
						$approve_id = ( isset($HTTP_POST_VARS['approve_box']) ) ? $HTTP_POST_VARS['approve_box'] : array();

						if ( count($approve_id) > 0 )
						{        
							for($i = 0; $i < count($approve_id); $i++)
							{
								$rejected_user_id = $approve_id[$i];

								// Remove Guilds details from Character table...
								$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
										SET character_guild_auth_id = 0 , 
											character_guild_approval = 0 , 
											character_guild_id = 0     
										WHERE character_id = $rejected_user_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not update rejected characters',"", __LINE__, __FILE__, $sql);
								}

								// Grab details from Guilds table...
								$sql = " SELECT guild_name FROM " . ADR_GUILDS_TABLE . "
										WHERE guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for info page', '', __LINE__, __FILE__, $sql);
								}
								$guilds_table = $db->sql_fetchrow($result);
                                        
								// Send user PM notification...
								$subject = sprintf($lang['Adr_guilds_approve_pm_subject'] , $guilds_table['guild_name']);
								$message = sprintf($lang['Adr_guilds_approve_pm_no'] , $guilds_table['guild_name'] , $character_name);

								// Grab details from Guilds table...
								$sql = " SELECT character_guild_prefs_notify FROM " . ADR_CHARACTERS_TABLE . "
									WHERE character_id = $rejected_user_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for approve no', '', __LINE__, __FILE__, $sql);
								}
								$character = $db->sql_fetchrow($result);
                                                                                
								if ( $character['character_guild_prefs_notify'] )
								{
									adr_send_pm ( $rejected_user_id , $subject , $message );
								}
							}
						}

						adr_previous( Adr_guilds_approve_list_reject , adr_guilds_leader , "mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=".$guild_id."" );        

					break;

					case 'guilds_leader_bio' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);

						$template->assign_block_vars('guilds_leader_bio' , array());

						// Grab details from Guilds table...
						$sql = " SELECT guild_history FROM " . ADR_GUILDS_TABLE . "
								WHERE guild_id = $guild_id ";
						if( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not query Guild history for leader page', '', __LINE__, __FILE__, $sql);
						}
						$guilds_table = $db->sql_fetchrow($result);

						$guilds_bio = intval($HTTP_GET_VARS['guilds_bio']);

						$template->assign_vars(array(
							'L_GUILDS_BIO_TITLE' => $lang['Adr_guilds_bio_title'],
							'L_GUILDS_BIO_TEXT' => $lang['Adr_guilds_bio_text'],
							'U_GUILDS_BIO' => $guilds_table['guild_history'],
							'L_SUBMIT' => $lang['Adr_guilds_submit'],
							'U_SUBMIT' => append_sid("adr_guilds.$phpEx?mode=guilds_leader_bio_update&amp;sub_mode="),
						));
                                                
					break;


					case 'guilds_leader_bio_update' :

						$guild_id = intval($HTTP_GET_VARS['guild_id']);
						$guilds_bio = $HTTP_POST_VARS['guilds_bio'];

						// Reset all old Guild members to no guild status...
						$sql = "UPDATE " . ADR_GUILDS_TABLE . "
							SET guild_history = '$guilds_bio'   
							WHERE guild_id = $guild_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not update Guild bio',"", __LINE__, __FILE__, $sql);
						}

						adr_previous( Adr_guilds_leader_bio_updated , adr_guilds_leader , "mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=".$guild_id."" );
                                                
					break;
        }
}

else
{
	//Seteo-Bloke:
	// Nothing
	//--
	//Ganondorf:
	//Sure...XD
}

$template->assign_vars(array(
	'POINTS_NAME' => $board_config['points_name'],
));


include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?>
