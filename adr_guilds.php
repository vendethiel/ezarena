<?php 
/***************************************************************************
 *                                        adr_guilds.php
 *                                ------------------------
 *       	begin                         : 30/05/2004
 *       	copyright                     : Seteo-Bloke
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
define('IN_ADR_CHARACTER', true); 
define('IN_ADR_BATTLE', true);
define('IN_ADR_GUILDS', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_guilds';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
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
adr_template_file('../../adr/templates/adr_guilds_body.tpl');
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


// Define some actions...
$guilds_create = isset($HTTP_POST_VARS['guilds_create']);
$guilds_create_confirm = isset($HTTP_POST_VARS['guilds_create_confirm']);
$guilds_create_success = isset($HTTP_POST_VARS['guilds_create_success']);

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
$character_guild = $char['character_guild'];
$character_guild_id = $char['character_guild_id'];
$character_guild_rank = $char['character_guild_rank'];
$character_guild_approval = $char['character_guild_approval'];



if ( $mode != "" )
{
	switch($mode)
	{
		case 'guilds_create' :

			$template->assign_block_vars('guilds_create',array());

			if ( $sub_mode == "" )
			{
				adr_template_file('adr_guilds_error_body.tpl');
				$template->assign_block_vars('guilds_general_error' , array());
                                        
				$template->assign_vars(array(
					'L_GUILDS_ERROR_TITLE' => $lang['Adr_guilds_error_title'],
					'L_GUILDS_ERROR_TEXT' => $lang['Adr_guilds_error_text'],
					'L_YES' => $lang['Yes'],
					'L_NO' => $lang['No'],
					'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
					'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
				));

				break;
			}

			else
			{
				switch($sub_mode)
				{
					case 'guilds_create_confirm' :

						if ( $points >= $adr_general['Adr_guild_create_min_money'] )
						{
							adr_template_file('adr_guilds_confirm_body.tpl');
							$template->assign_block_vars('guilds_create_confirm' , array());

							$template->assign_vars(array(
								'L_GUILDS_CREATE_TITLE' => $lang['Adr_guilds_create_title'],
								'L_GUILDS_CREATE_TEXT' => $lang['Adr_guilds_create_confirm'],
								'L_YES' => $lang['Adr_guilds_yes'],
								'L_NO' => $lang['Adr_guilds_no'],
								'U_GUILDS_CREATE_YES' => append_sid("adr_guilds.$phpEx?mode=guilds_create&amp;sub_mode=guilds_create_info"),
								'U_GUILDS_CREATE_NO' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
							));
						}
						else
						{   
							adr_template_file('adr_guilds_error_body.tpl');     
							$template->assign_block_vars('guilds_money_error_create' , array());

							$template->assign_vars(array(
								'L_GUILDS_CREATE_MONEY_TITLE' => $lang['Adr_guilds_create_money_title'],
								'L_GUILDS_CREATE_MONEY_TEXT' => $lang['Adr_guilds_create_money_text'],
								'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
								'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
							));        
						}

					break;

					case 'guilds_create_info' :

						// Check if the user meets Guild creation reqs...
						if ( !$adr_general['Adr_guild_create_allow'] || $character_level < $adr_general['Adr_guild_create_min_level'] || $character_guild != 0 || $character_guild_approval != 0 )
						{
							adr_previous( Adr_guilds_creation_error , adr_guilds , '' );
						}

						$template->assign_block_vars('guilds_create_info' , array());

						//$guilds_name = isset($HTTP_POST_VARS['guilds_name']);
						//$guilds_description = isset($HTTP_POST_VARS['guilds_description']);
						//$guilds_join_min_level = isset($HTTP_POST_VARS['guilds_join_min_level']);
						//$guilds_join_min_money = isset($HTTP_POST_VARS['guilds_join_min_money']);
						//$guilds_submit = isset($HTTP_POST_VARS['guilds_submit']);

						$template->assign_vars(array(
							'L_GUILD_TITLE' => $lang['Adr_guilds_create_title'],
							'L_GUILD_NAME' => $lang['Adr_guilds_name'],
							'L_GUILD_DESCRIPTION' => $lang['Adr_guilds_description'],
							'L_GUILD_LOGO' => $lang['Adr_guilds_logo'],
							'L_GUILD_JOIN_LEVEL' => $lang['Adr_guilds_join_level'],
							'L_GUILD_JOIN_MONEY1' => $lang['Adr_guilds_join_money1'],
							'L_GUILD_JOIN_MONEY2' => $lang['Adr_guilds_join_money2'],
							'L_SUBMIT' => $lang['Adr_guilds_create_submit'],
							'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
							'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
							'U_GUILDS_CREATE_SUBMIT' => append_sid("adr_guilds.$phpEx?mode=guilds_create&amp;sub_mode=guilds_create_success"),                                                        
						));

					break;

					case 'guilds_create_success' :

						$guilds_name = ( isset($HTTP_POST_VARS['guilds_name']) ) ? trim($HTTP_POST_VARS['guilds_name']) : trim($HTTP_GET_VARS['guilds_name']);
						$guilds_description = ( isset($HTTP_POST_VARS['guilds_description']) ) ? trim($HTTP_POST_VARS['guilds_description']) : trim($HTTP_GET_VARS['guilds_description']);

						if (( $guilds_name == '' ) || ( $guilds_description == '' ))
						{
							message_die(MESSAGE, $lang['Adr_guilds_create_required']);
						}

						$date_created = time();

						// Insert new guild into database...
						$sql = " INSERT INTO " . ADR_GUILDS_TABLE . " 
								( guild_name , guild_leader , guild_leader_id , guild_description , guild_date_created )
							VALUES ( '$guilds_name' , '$character_name' , $user_id , '$guilds_description' , $date_created ) ";
						$result = $db->sql_query($sql);
						if( !$result )
						{
							message_die(GENERAL_ERROR, "Couldn't insert new Guild into database", "", __LINE__, __FILE__, $sql);
						}

						// Grab Guild id...
						$sql = " SELECT guild_id FROM " . ADR_GUILDS_TABLE . "
							WHERE guild_leader_id = $user_id ";
						if( !($result = $db->sql_query($sql)) )
						{
							message_die(GENERAL_ERROR, 'Could not query Guild table for info page', '', __LINE__, __FILE__, $sql);
						}
						
						$guilds_table = $db->sql_fetchrow($result);
						$guilds_id = $guilds_table['guild_id'];
						$points_penalty = $adr_general['Adr_guild_create_min_money'];

						// Update Character table with Guild name & rank...
						$sql = "UPDATE " . USERS_TABLE . "
							SET user_points = user_points - $points_penalty  
							WHERE user_id = $user_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not remove money penalty for Guild creation',"", __LINE__, __FILE__, $sql);
						}

						// Update Character table with Guild name & rank...
						$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
							SET character_guild_auth_id = 1 , 
								character_guild_id = $guilds_id , 
								character_guild_join_date = $date_created 
							WHERE character_id = $user_id ";
						if( !$db->sql_query($sql))
						{
							message_die(GENERAL_ERROR, 'Could not update Character table',"", __LINE__, __FILE__, $sql);
						}

						adr_previous( Adr_guilds_create_success , adr_guilds , '' );

					break;
					}
				}


		case 'guilds_join' :

			$template->assign_block_vars('guilds_join',array());

				$guild_id = intval($HTTP_GET_VARS['guild_id']);

				if ( $sub_mode == "" )
				{
					adr_template_file('adr_guilds_error_body.tpl');
					$template->assign_block_vars('guilds_general_error' , array());
                                        
					$template->assign_vars(array(
						'L_GUILDS_ERROR_TITLE' => $lang['Adr_guilds_error_title'],
						'L_GUILDS_ERROR_TEXT' => $lang['Adr_guilds_error_text'],
						'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
						'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
					));

				break;
                        }

				else
                        {
					switch($sub_mode)
					{
						case 'guilds_info_page' :

							$template->assign_block_vars('guilds_info_page' , array());

							// Grab details from Guilds table...
							$sql = " SELECT * FROM " . ADR_GUILDS_TABLE . "
								WHERE guild_id = $guild_id ";
							if( !($result = $db->sql_query($sql)) )
							{
								message_die(GENERAL_ERROR, 'Could not query Guild table for info page', '', __LINE__, __FILE__, $sql);
							}
							$guilds_table = $db->sql_fetchrow($result);
							$date_created = date( "F jS Y" , $guilds_table['guild_date_created'] );
							$date_length = floor( ( time() - $guilds_table['guild_date_created'] ) / 86400 ) ;

							// Show new applicant status...
							if ($guilds_table['guild_accepting_new'] == '0')
							{
								$guild_accepting_new = $lang['Adr_guilds_no'];
							}
							else
							{
								$guild_accepting_new = $lang['Adr_guilds_yes'];
							}

							// Show whether new applicant approval is enabled...
							if ($guilds_table['guild_approve'] == '0')
							{
								$guild_approve = $lang['Adr_guilds_no'];
							}
							else
							{
								$guild_approve = $lang['Adr_guilds_yes'];
							}

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
									else // $height > $width
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
							
							// Count current members
							$sql = " SELECT character_guild_id FROM " . ADR_CHARACTERS_TABLE . "
								WHERE character_guild_id = $guild_id ";
							if( !($result = $db->sql_query($sql)) )
							{
								message_die(GENERAL_ERROR, 'Could not query count for info page', '', __LINE__, __FILE__, $sql);
							}
							$count_members = $db->sql_numrows($result);

							$template->assign_vars(array(
								'U_GUILDS_INFO_NAME' => $guilds_table['guild_name'],
								'U_GUILDS_INFO_DESC' => $guilds_table['guild_description'],
								'U_GUILDS_INFO_LOGO' => $guilds_logo,
								'U_GUILDS_INFO_EXP' => $exp_bar,
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
								'L_GUILDS_INFO_RANKS' => $lang['Adr_guilds_info_ranks'],
								'U_GUILDS_INFO_RANKS' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_ranks&amp;guild_id=$guild_id"),
								'L_GUILDS_INFO_BIO' => $lang['Adr_guilds_info_bio'],
								'U_GUILDS_INFO_BIO' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_bio&amp;guild_id=$guild_id"),
								'L_GUILDS_INFO_JOIN_REQS' => $lang['Adr_guilds_join_reqs'],
								'L_GUILDS_INFO_JOIN_ACCEPT_NEW' => $lang['Adr_guilds_join_accept_new'],
								'L_GUILDS_INFO_JOIN_ACCEPT' => $guild_accepting_new,
								'L_GUILDS_INFO_JOIN_LEVEL' => $lang['Adr_guilds_join_reqs_level'],
								'U_GUILDS_INFO_JOIN_LEVEL' => $guilds_table['guild_join_min_level'],
								'L_GUILDS_INFO_JOIN_MONEY' => $lang['Adr_guilds_join_reqs_money'],
								'U_GUILDS_INFO_JOIN_MONEY' => $guilds_table['guild_join_min_money'],
								'L_GUILDS_INFO_JOIN_APPROVE_NEW' => $lang['Adr_guilds_join_approve'],
								'L_GUILDS_INFO_JOIN_APPROVE' => $guild_approve,
								'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
								'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
							)); 

							if ( $character_guild_id == 0 && $character_guild_approval == 0 && $guilds_table['guild_accept_new'] == 1 && $guilds_table['guild_leader_id'] != $character_id )
							{
								$template->assign_block_vars('guilds_join_button' , array());

								$template->assign_vars(array(
									'L_GUILDS_JOIN_BUTTON' => $lang['Adr_guilds_join_button'],
									'U_GUILDS_JOIN_BUTTON' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_apply_confirm&amp;guild_id=$guild_id"),
								));
							}

							if ( $character_guild_approval == $guilds_table['guild_id'] && $character_guild_id == 0 )
							{
								$template->assign_block_vars('guilds_retract_button' , array());

								$template->assign_vars(array(
									'L_GUILDS_RETRACT_BUTTON' => $lang['Adr_guilds_retract_button'],
									'U_GUILDS_RETRACT_BUTTON' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_retract&amp;guild_id=$guild_id"),
								));
							}

							if ( $character_guild_id == $guilds_table['guild_id'] && $user_id != $guilds_table['guild_leader_id'] )
							{
								$template->assign_block_vars('guilds_leave_button' , array());

								$template->assign_vars(array(
									'L_GUILDS_LEAVE_BUTTON' => $lang['Adr_guilds_leave_button'],
									'U_GUILDS_LEAVE_BUTTON' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_leave_confirm&amp;guild_id=$guild_id"),
								));
							}

							if ( $user_id == $guilds_table['guild_leader_id'] && $character_id == $guilds_table['guild_leader_id'] && $character_guild_id == $guild_id || $admin_level == 1 )
							{
								$template->assign_block_vars('guilds_leader_button' , array());

								$template->assign_vars(array(
									'L_GUILDS_LEADER_BUTTON' => $lang['Adr_guilds_leader_button'],
									'U_GUILDS_LEADER_BUTTON' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=$guild_id"),
								));
							}

						break;


						case 'guilds_apply_confirm' :

							// Grab details from Guilds table...
							$sql = " SELECT guild_join_min_money FROM " . ADR_GUILDS_TABLE . "
								WHERE guild_id = $guild_id ";
							if( !($result = $db->sql_query($sql)) )
							{
								message_die(GENERAL_ERROR, 'Could not query Guild table for info page', '', __LINE__, __FILE__, $sql);
							}
							$guilds_table = $db->sql_fetchrow($result);

							if ( $points >= $guilds_table['guild_join_min_money'] )
							{
								adr_template_file('adr_guilds_confirm_body.tpl');
								$template->assign_block_vars('guilds_apply_confirm' , array());

								$template->assign_vars(array(
									'L_GUILDS_APPLY_TITLE' => $lang['Adr_guilds_apply_title'],
									'L_GUILDS_APPLY_TEXT' => $lang['Adr_guilds_apply_text'],
									'L_YES' => $lang['Adr_guilds_yes'],
									'L_NO' => $lang['Adr_guilds_no'],
									'U_GUILDS_APPLY_YES' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_join_success&amp;guild_id=$guild_id"),
									'U_GUILDS_APPLY_NO' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
								));
							}
							else
							{      
								adr_template_file('adr_guilds_error_body.tpl');  
								$template->assign_block_vars('guilds_money_error_join' , array());

								$template->assign_vars(array(
									'L_GUILDS_JOIN_MONEY_TITLE' => $lang['Adr_guilds_join_money_title'],
									'L_GUILDS_JOIN_MONEY_TEXT' => $lang['Adr_guilds_join_money_text'],
								));        
							}

						break;


						case 'guilds_join_success' :

							// Grab details from Guilds table...
							$sql = " SELECT guild_approve , guild_id , guild_join_min_money , guild_leader_id , guild_name FROM " . ADR_GUILDS_TABLE . "
								WHERE guild_id = $guild_id ";
							if( !($result = $db->sql_query($sql)) )
							{
								message_die(GENERAL_ERROR, 'Could not query Guild table for join success', '', __LINE__, __FILE__, $sql);
							}
							$guilds_table = $db->sql_fetchrow($result);
							$guilds_id = $guilds_table['guild_id'];

							if ($guilds_table['guild_approve'] == '0')
							{
								$date_joined = time();

								// Update Character table with Guild name & basic member rank...
								$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
										SET character_guild_id = $guild_id , 
											character_guild_auth_id = 0 , 
											character_guild_join_date = $date_joined 
									WHERE character_id = $user_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not update Character table upon successful join',"", __LINE__, __FILE__, $sql);
								}

								// Remove money penalty from character...
								$sql = "UPDATE " . USERS_TABLE . "
										SET user_points = user_points - '".$guilds_table['guild_join_min_money']."'  
										WHERE user_id = $user_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not remove money penalty for Guild join',"", __LINE__, __FILE__, $sql);
								}

								// Update Guild Vault with new applicant money...
								$sql = "UPDATE " . ADR_GUILDS_TABLE . "
									SET guild_vault = guild_vault + '".$guilds_table['guild_join_min_money']."'  
									WHERE guild_id = $guild_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not add money penalty to Guild in join',"", __LINE__, __FILE__, $sql);
								}

								// Send leader PM notification...
								$subject = sprintf($lang['Adr_guilds_join_pm_subject'] , $character_name , $guilds_table['guild_name']);
								$message = sprintf($lang['Adr_guilds_join_pm_msg'] , $character_name , $guilds_table['guild_name']);

								// Grab details from Guilds table...
								$sql = " SELECT character_guild_prefs_notify FROM " . ADR_CHARACTERS_TABLE . " 
										LEFT JOIN " . ADR_GUILDS_TABLE . "
											ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_leader_id 
										WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 1', '', __LINE__, __FILE__, $sql);
								}
								$character = $db->sql_fetchrow($result);
										
								if ( $character['character_guild_prefs_notify'] )
								{
									adr_send_pm ( $guilds_table['guild_leader_id'] , $subject , $message );
								}

								adr_previous( Adr_guilds_join_success , adr_guilds , "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id."" );
							}

							else
							{
								// Put character onto waiting list for approval...
								$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
									SET character_guild_approval = $guild_id , 
										character_guild_auth_id = 0 ,  
										character_guild_id = 0 , 
										character_guild_join_date = 0 
									WHERE character_id = $user_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not update Character table upon awaiting approval',"", __LINE__, __FILE__, $sql);
								}

								// Remove money penalty from character. Will put back if leader rejects application and Guild vault is not updated until then either...
								$sql = "UPDATE " . USERS_TABLE . "
									SET user_points = user_points - '".$guilds_table['guild_join_min_money']."'  
									WHERE user_id = $user_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not remove money penalty for Guild join and approve',"", __LINE__, __FILE__, $sql);
								}

								// Send leader PM notification...
								$subject = sprintf($lang['Adr_guilds_join_pm_list_sub'] , $character_name , $guilds_table['guild_name']);
								$message = sprintf($lang['Adr_guilds_join_pm_list_msg'] , $character_name);

								// Grab details from Guilds table...
								$sql = " SELECT character_guild_prefs_notify FROM " . ADR_CHARACTERS_TABLE . " 
									LEFT JOIN " . ADR_GUILDS_TABLE . "
										ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_leader_id 
									WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 1', '', __LINE__, __FILE__, $sql);
								}
								$character = $db->sql_fetchrow($result);
										
								if ( $character['character_guild_prefs_notify'] )
								{
									adr_send_pm ( $guilds_table['guild_leader_id'] , $subject , $message );
								}
									
								adr_previous( Adr_guilds_join_approval , adr_guilds , "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id."" );
							}

							break;

							case 'guilds_retract' :

								// Remove from Character table...
								$sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
									SET character_guild_approval = 0   
									WHERE character_id = $user_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not remove Character table upon retraction',"", __LINE__, __FILE__, $sql);
								}

								// Grab details from Guilds table...
								$sql = " SELECT guild_join_min_money FROM " . ADR_GUILDS_TABLE . "
									WHERE guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for application retract', '', __LINE__, __FILE__, $sql);
								}
								$guilds_table = $db->sql_fetchrow($result);

								// Give user their money back...
								$sql = "UPDATE " . USERS_TABLE . "
									SET user_points = user_points + '".$guilds_table['guild_join_min_money']."'  
									WHERE user_id = $user_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not remove money penalty for Guild join and approve',"", __LINE__, __FILE__, $sql);
								}

								adr_previous( Adr_guilds_retract_success , adr_guilds , "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id."" );        

								break;

							case 'guilds_leave_confirm' :

								adr_template_file('adr_guilds_confirm_body.tpl');
								$template->assign_block_vars('guilds_leave_confirm' , array());

								$template->assign_vars(array(
									'L_GUILDS_LEAVE_TITLE' => $lang['Adr_guilds_leave_title'],
									'L_GUILDS_LEAVE_TEXT' => $lang['Adr_guilds_leave_text'],
									'L_YES' => $lang['Adr_guilds_yes'],
									'L_NO' => $lang['Adr_guilds_no'],
									'U_GUILDS_LEAVE_YES' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_leave&amp;guild_id=$guild_id"),
									'U_GUILDS_LEAVE_NO' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
								));

							break;

							case 'guilds_leave' :

								$guild_id = intval($HTTP_GET_VARS['guild_id']);

								// Remove Guilds details from Character table...
								$sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
									SET character_guild_auth_id = 0 , 
										character_guild_approval = 0 , 
										character_guild_id = 0 , 
										character_guild_hops = character_guild_hops + 1 , 
										character_guild_join_date = 0    
									WHERE character_id = $user_id ";
								if( !$db->sql_query($sql))
								{
									message_die(GENERAL_ERROR, 'Could not remove Guild details from Character table upon leaving',"", __LINE__, __FILE__, $sql);
								}

								adr_previous( Adr_guilds_leave_success , adr_guilds , '' );        

							break;

							case 'guilds_ranks' :

								$guild_id = intval($HTTP_GET_VARS['guild_id']);

								$template->assign_block_vars('guilds_ranks' , array());

								// Grab details from Guilds table
								$sql = " SELECT * FROM " . ADR_GUILDS_TABLE . "
									WHERE guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for info page', '', __LINE__, __FILE__, $sql);
								}
								$guilds_table = $db->sql_fetchrow($result);
								$guilds_member_rank = $guilds_table['guild_rank_member'];

								// Grab rank 1 character names
								$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
									LEFT JOIN " . ADR_GUILDS_TABLE . "
										ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_1_id 
									WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 1', '', __LINE__, __FILE__, $sql);
								}
								$rank_1 = $db->sql_fetchrow($result);

								// Grab rank 2 character names
								$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
									LEFT JOIN " . ADR_GUILDS_TABLE . "
										ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_2_id 
									WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 2', '', __LINE__, __FILE__, $sql);
								}
								$rank_2 = $db->sql_fetchrow($result);

								// Grab rank 3 character names
								$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
									LEFT JOIN " . ADR_GUILDS_TABLE . "
										ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_3_id 
									WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 3', '', __LINE__, __FILE__, $sql);
								}
								$rank_3 = $db->sql_fetchrow($result);

								// Grab rank 4 character names...
								$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
									LEFT JOIN " . ADR_GUILDS_TABLE . "
										ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_4_id 
									WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 3', '', __LINE__, __FILE__, $sql);
								}
								$rank_4 = $db->sql_fetchrow($result);

								// Grab rank 5 character names...
								$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . " 
									LEFT JOIN " . ADR_GUILDS_TABLE . "
										ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_5_id 
									WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 3', '', __LINE__, __FILE__, $sql);
								}
								$rank_5 = $db->sql_fetchrow($result);

								// Grab general guild member details...
								$sql = " SELECT character_name FROM " . ADR_CHARACTERS_TABLE . "     
									WHERE character_guild_id = $guild_id 
										AND character_id <> '" . $guilds_table['guild_rank_1'] . "'
										AND character_id <> '" . $guilds_table['guild_rank_2'] . "'
										AND character_id <> '" . $guilds_table['guild_rank_3'] . "'
										AND character_id <> '" . $guilds_table['guild_rank_4'] . "'
										AND character_id <> '" . $guilds_table['guild_rank_5'] . "'
										AND character_guild_auth_id = 0 "; 
								$runquery = $db->sql_query($sql); 
								$countmembers = $db->sql_numrows($runquery); 

								if ( $countmembers > 0 ):
								$members_list = "";
								for ( $i = 0; $i < $countmembers; $i++ ): 
									$rank_member = $db->sql_fetchrow($runquery); 
								if ( $i < ($countmembers - 1) ):
									$members_list .= $rank_member['character_name'].", "; 
								else:
									$members_list .= $rank_member['character_name']; 
								endif; 
								endfor; 

								else: 
									$members_list = $lang['Adr_guilds_ranks_no_members']; 
								endif;

								$template->assign_vars(array(
									'U_GUILDS_RANKS_NAME' => $guilds_table['guild_name'],
									'L_GUILDS_RANKS' => $lang['Adr_guilds_ranks'],
									'L_GUILD_LEADER' => $guilds_table['guild_rank_leader'],
									'U_GUILD_LEADER' => $guilds_table['guild_leader'],
									'L_GUILD_RANK1' => $guilds_table['guild_rank_1'],
									'U_GUILD_RANK1' => $rank_1['character_name'],
									'L_GUILD_RANK2' => $guilds_table['guild_rank_2'],
									'U_GUILD_RANK2' => $rank_2['character_name'],
									'L_GUILD_RANK3' => $guilds_table['guild_rank_3'],
									'U_GUILD_RANK3' => $rank_3['character_name'],
									'L_GUILD_RANK4' => $guilds_table['guild_rank_4'],
									'U_GUILD_RANK4' => $rank_4['character_name'],
									'L_GUILD_RANK5' => $guilds_table['guild_rank_5'],
									'U_GUILD_RANK5' => $rank_5['character_name'],
									'L_GUILD_MEMBERS' => $guilds_table['guild_rank_member'],
									'U_GUILD_MEMBERS' => $members_list,
									'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
									'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=guilds_leader&amp;sub_mode=guilds_leader_page&amp;guild_id=$guild_id"),
								));
                                                
							break;

							case 'guilds_bio' :

								// Grab details from Guilds table...
								$sql = " SELECT guild_history FROM " . ADR_GUILDS_TABLE . "
									WHERE guild_id = $guild_id ";
								if( !($result = $db->sql_query($sql)) )
								{
									message_die(GENERAL_ERROR, 'Could not query Guild table for bio', '', __LINE__, __FILE__, $sql);
								}
								$guilds_table = $db->sql_fetchrow($result);

								if ($guilds_table['guild_history'] != '')
								{
									$history = $guilds_table['guild_history'];
								}							
								else
								{
									$history = $lang['Adr_guilds_bio_none'];									
								}

								$template->assign_block_vars('guilds_bio' , array());

								$template->assign_vars(array(
									'L_GUILDS_BIO_TITLE' => $lang['Adr_guilds_bio_title'],
									'U_GUILDS_BIO' => $history,
									'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
									'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=$guild_id"),
								));
						break;
					}
				}
			}
		}

else
{
	// Check if the Guild feature is turned on by admin...
	if ( $adr_general['Adr_guild_overall_allow'] != 1 )
	{
		adr_previous( Adr_guilds_closed , adr_town , '' );
	}

	$template->assign_block_vars('guilds_main',array());

	// List all current guilds in table...
	$sql = "SELECT * FROM " . ADR_GUILDS_TABLE . "
			ORDER BY guild_level DESC ";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(CRITICAL_ERROR, 'Error Getting Guild names!'); 
	}

	if ( $row = $db->sql_fetchrow($result) ) 
	{ 
		$i = 0; 
		do 
		{ 
			$guild_id = $row['guild_id'];
			$guild_members = $row['guild_members'];

			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			$gsql = "SELECT character_victories , character_defeats , character_flees FROM " . ADR_CHARACTERS_TABLE . " 
				WHERE character_guild_id = $guild_id"; 
			if ( !($gresult = $db->sql_query($gsql)) ) 
			{ 
				message_die(GENERAL_MESSAGE, 'Fatal Error Getting Guild info'); 
			} 
			$guild_row = $db->sql_fetchrowset($gresult); 

			$guild_wins = 0; 
			$guild_defs = 0; 
			$guild_escs = 0;

			for ( $v = 0 ; $v < count($row) ; $v ++ ) 
			{ 
				$guild_wins = $guild_wins + $guild_row[$v]['character_victories']; 
				$guild_defs = $guild_defs + $guild_row[$v]['character_defeats']; 
				$guild_escs = $guild_escs + $guild_row[$v]['character_flees'];
			} 
			$guild_diff = $guild_wins - ($guild_defs + $guild_escs); 

			$template->assign_block_vars('guilds_main.rows',array(
				'GUILD_ROW' => $i + 1,
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,
				'GUILD_NAME' => $row['guild_name'],
				'U_GUILD_INFO_PAGE' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=$guild_id"),
				'GUILD_LEADER' => $row['guild_leader'],
				'GUILD_WINS' => $guild_wins,
				'GUILD_DEFS' => $guild_defs,
				'GUILD_ESCS' => $guild_escs,
				'GUILD_DIFF' => $guild_diff,
				'GUILD_LEVEL' => $row['guild_level'], 
			)); 

			$i++; 
		} 
			while ( $row = $db->sql_fetchrow($result) ); 
	}

	// Check if the user meets Guild creation reqs...
	if ( $adr_general['Adr_guild_create_allow'] && $character_level >= $adr_general['Adr_guild_create_min_level'] && $character_guild_id == 0 && $character_guild_approval == 0 )
	{
		$template->assign_block_vars('create_allow',array());
	}
}

	$template->assign_vars(array(
		'L_LEAGUE_TABLE' => $lang['Adr_guilds_league_table'],
		'L_ROW' => $lang['Adr_guilds_position'],
		'L_NAME' => $lang['Adr_guilds_name2'],
		'L_LEADER' => $lang['Adr_guilds_leader'],
		'L_WINS' => $lang['Adr_guilds_wins'],
		'L_DEFS' => $lang['Adr_guilds_defeats'],
		'L_ESCS' => $lang['Adr_guilds_escapes'],
		'L_DIFF' => $lang['Adr_guilds_difference'],
		'L_LEVEL' => $lang['Adr_guilds_level'],
		'L_GUILDS_CREATE' => $lang['Adr_guilds_create_title'],
		'U_GUILDS_CREATE' => append_sid("adr_guilds.$phpEx?mode=guilds_create&amp;sub_mode=guilds_create_confirm"),
		'POINTS_NAME' => $board_config['points_name'],
	));


include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?>
