<?php 
/***************************************************************************
 *                                        adr_guilds.php
 *                                ------------------------			
 *		begin					: 30/05/2004
 *		copyright				: Seteo-Bloke
 *
 *		Last Update
 *		begin					: 21/06/2007
 *		copyright				: renlok (http://www.zarioth.com)
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
//lets start the guilds!!!! HORAH

define('IN_PHPBB', true); 
define('IN_ADR_TOWN', true);
define('IN_ADR_CHARACTER', true); 
define('IN_ADR_BATTLE', true);
define('IN_ADR_VAULT', true);
define('IN_ADR_GUILDS', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$loc = 'zones';
$sub_loc = 'adr_guilds';
$page_title = ' Guilds';
//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 
// End session management
//

$user_id = $userdata['user_id'];
$points = $userdata['user_points'];
$admin_level = $userdata['user_level'];

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_character.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("index.$phpEx?type=7143e2e85a1608c4ee1af3955f85c3ea", true));
}

// Includes the tpl and the header
adr_template_file('adr_guilds_body.tpl');

// Get the general config and character infos
$adr_general = adr_get_general_config();
$adr_user = adr_get_user_infos($user_id);

// Deny access if user is imprisioned 
if($userdata['user_cell_time']){ 
	adr_previous(Adr_shops_no_thief, adr_cell, '');
}
adr_guild_add_lang();
adr_guild_add_urls();


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
	$sub_mode = "guilds_info_page";
}

// Check if the Guild feature is turned on by admin...
// V: check beforehand
if ( $adr_general['Adr_guild_overall_allow'] != 1 )
{
	adr_previous( Adr_guilds_closed , adr_town , '' );
}

// Grab details from ADR Characters table...
$character_id = $adr_user['character_id'];
$character_name = $adr_user['character_name'];
$character_level = $adr_user['character_level'];
$sql = "SELECT * FROM " . ADR_GUILD_MEMBER_TABLE . " 
		WHERE guild_member_user_id = $user_id ";
if ( !($result = $db->sql_query($sql)) ) 
{ 
	message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
}
$gm = $db->sql_fetchrow($result);
if ($gm)
{
  $character_guild_id = $guild_id = $gm['guild_member_guild_id'];
}

switch($mode)
{
case 'guilds_create' : // mode
  $template->assign_block_vars('guilds_create',array());
  // Check if the user meets Guild creation reqs...
  // V: check for criterions here instead of duplicating code.
  // V: also check we don't have a guild_id
  if ( !$adr_general['Adr_guild_create_allow'] || $character_level < $adr_general['Adr_guild_create_min_level'] || $character_guild != 0 && empty($guild_id) )
  {
    adr_previous( Adr_guilds_creation_error , adr_guilds , '' );
  }
  if ( $points < $adr_general['Adr_guild_create_min_money'] )
  {
    adr_template_file('adr_guilds_error_body.tpl');     
    $template->assign_block_vars('guilds_money_error_create' , array());
    break;
  }

  switch($sub_mode) // guilds_create submodes
  {
  case 'guilds_create_confirm': // guilds_create submode
    adr_template_file('adr_guilds_confirm_body.tpl');
    $template->assign_block_vars('guilds_create_confirm' , array());
    break;

  case 'guilds_create_info': // guilds_create submode
    $template->assign_block_vars('guilds_create_info' , array());
    break;

  case 'guilds_create_success': // guilds_create submode
    adr_guild_create();
    break;

  default:
    adr_template_file('adr_guilds_error_body.tpl');
    $template->assign_block_vars('guilds_general_error' , array());
    break;
  }

  break;

case 'guilds_join' : // mode
  $template->assign_block_vars('guilds_join',array());
  $guild_id = intval($_GET['guild_id']);
  $guild = adr_guild_get($guild_id);
  if (!$guild)
    break;

  switch ($sub_mode)
  {
  case '': // guilds_join submode
    adr_template_file('adr_guilds_error_body.tpl');
    $template->assign_block_vars('guilds_general_error' , array());
    break;

  case 'guilds_info_page': // guilds_join submode
    $template->assign_block_vars('guilds_info_page' , array());
    adr_guild_info_page($_GET['guild_id'], $gm);
    break;

  case 'guilds_apply_confirm': // guilds_join submode
    $guildmems = adr_guild_count_all_members($guild_id);
    if ($points >= $guild['guild_join_min_money'] )
    {
      adr_template_file('adr_guilds_confirm_body.tpl');
      $template->assign_block_vars('guilds_apply_confirm' , array());

      $template->assign_vars(array(
        'U_GUILDS_APPLY_YES' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_join_success&amp;guild_id=$guild_id"),
      ));
    }
    else
    {      
      adr_template_file('adr_guilds_error_body.tpl');  
      $template->assign_block_vars('guilds_money_error_join' , array());
    }
    break;

  case 'guilds_join_success': // guilds_join submode
    if ($gm)
    {
      adr_previous('Adr_guilds_already_member', 'adr_guilds', "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id);
    }
    // V: check for points - always!
    if ($points < $guild['guild_join_min_money'] || !$guild['guild_accepting_new'])
    {      
      adr_template_file('adr_guilds_error_body.tpl');  
      $template->assign_block_vars('guilds_money_error_join' , array());
    }
    
    if (!$guild['guild_accepting_new'])
    {      
      adr_template_file('adr_guilds_error_body.tpl');  
      $template->assign_block_vars('guilds_general_error' , array());
    }
      

    if ($guild['guild_approve'] == '0')
      adr_guild_register($guild, $adr_user);
    else
      adr_guild_register_unapproved($guild, $adr_user);

    break;

  case 'guilds_retract': // guilds_join submode
    // V: make sure we can retract something...
    if (!$gm || $gm['guild_member_auth'] != ADR_GUILD_MEMBER_PENDING)
      break;
    $guild = adr_guild_get($gm['guild_member_guild_id']);

    // Remove from Character table...
    $sql = "DELETE FROM " . ADR_GUILD_MEMBER_TABLE . "
      WHERE guild_member_user_id = $user_id";
    if( !$db->sql_query($sql))
    {
      message_die(GENERAL_ERROR, 'Could not remove Character table upon retraction',"", __LINE__, __FILE__, $sql);
    }

    // Give user their money back...
    /*
     * V: DO NOT GIVE MONEY BACK.
     *    Otherwise you can easily plot a scheme with some that makes a guild.
     *    You apply at 0gold, then they update the guild min money to 9999,
     *    so you get tons of money when you retract.
     *  Several notes:
     *   - The money should be from the Vault. That'd fix the issue at hand.
     *   - The money paid should be stored in the guild_member table.
    $sql = "UPDATE " . USERS_TABLE . "
      SET user_points = user_points + '".$guild['guild_join_min_money']."'  
      WHERE user_id = $user_id ";
    if( !$db->sql_query($sql))
    {
      message_die(GENERAL_ERROR, 'Could not remove money penalty for Guild join and approve',"", __LINE__, __FILE__, $sql);
    }
     */

    adr_previous('Adr_guilds_retract_success', 'adr_guilds', "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id."" );        
    break;

  case 'guilds_leave_confirm': // guilds_join submode
    adr_template_file('adr_guilds_confirm_body.tpl');
    $template->assign_block_vars('guilds_leave_confirm' , array());
    $template->assign_vars(array(
      'U_GUILDS_LEAVE_YES' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_leave&amp;guild_id=$guild_id"),
    ));
    break;

  case 'guilds_leave': // guilds_join submode
    // V: make sure there's something to leave.
    if (!$gm || $gm['guild_member_auth'] != ADR_GUILD_MEMBER_CONFIRMED)
      break;
    $guild = adr_guild_get($gm['guild_member_guild_id']);
    // V: I'd rather the leader not jump ship.
    if ($guild['guild_leader_id'] == $user_id)
      break;

    // Remove Guilds details from Character table...
    $sql = "DELETE FROM " . ADR_GUILD_MEMBER_TABLE . "
      WHERE guild_member_user_id = $user_id";
    if( !$db->sql_query($sql))
    {
      message_die(GENERAL_ERROR, 'Could not remove Guild details from Character table upon leaving',"", __LINE__, __FILE__, $sql);
    }

    $sql = "UPDATE " . ADR_CHARACTERS_TABLE . " 
        SET character_guild_hops = character_guild_hops + 1  
        WHERE character_id = $user_id ";
    if( !$db->sql_query($sql))
    {
      message_die(GENERAL_ERROR, 'Could not remove Guild details from Character table upon leaving',"", __LINE__, __FILE__, $sql);
    }

    adr_previous( Adr_guilds_leave_success , adr_guilds , '' );        
    break;

  case 'guilds_ranks': // guilds_join submode
    if (!$guild)
      break;
    $template->assign_block_vars('guilds_ranks' , array());

    $rank_1 = adr_guild_get_character_by_rank(1, $guild_id);
    $rank_2 = adr_guild_get_character_by_rank(2, $guild_id);
    $rank_3 = adr_guild_get_character_by_rank(3, $guild_id);
    $rank_4 = adr_guild_get_character_by_rank(4, $guild_id);
    $rank_5 = adr_guild_get_character_by_rank(5, $guild_id);

    // Grab general guild member details...
    $sql = "SELECT character_name
      FROM " . ADR_CHARACTERS_TABLE . " c
      INNER JOIN " . ADR_GUILD_MEMBER_TABLE . " gm
        ON gm.guild_member_user_id = c.character_id
      WHERE gm.guild_member_guild_id = $guild_id
        AND gm.guild_member_auth = " . ADR_GUILD_MEMBER_CONFIRMED . "
        AND character_id NOT IN (
          '" . $guild['guild_rank_1_id'] . "',
          '" . $guild['guild_rank_2_id'] . "',
          '" . $guild['guild_rank_3_id'] . "',
          '" . $guild['guild_rank_4_id'] . "',
          '" . $guild['guild_rank_5_id'] . "'
        )";
    $result = $db->sql_query($sql); 
    $members = $db->sql_fetchrowset($result);
    $db->sql_freeresult($result);
    $members_list = '';
    $member_names = array();
    foreach ($members as $member)
      $member_names[] = $member['character_name'];
    $members_list = $member_names ? implode(', ', $member_names) : $lang['Adr_guilds_ranks_no_members'];

    $template->assign_vars(array(
      'U_GUILDS_RANKS_NAME' => $guild['guild_name'],
      'L_GUILD_LEADER' => $guild['guild_rank_leader'],
      'U_GUILD_LEADER' => $guild['guild_leader'],
      'L_GUILD_RANK1' => $guild['guild_rank_1'],
      'U_GUILD_RANK1' => $rank_1['character_name'],
      'L_GUILD_RANK2' => $guild['guild_rank_2'],
      'U_GUILD_RANK2' => $rank_2['character_name'],
      'L_GUILD_RANK3' => $guild['guild_rank_3'],
      'U_GUILD_RANK3' => $rank_3['character_name'],
      'L_GUILD_RANK4' => $guild['guild_rank_4'],
      'U_GUILD_RANK4' => $rank_4['character_name'],
      'L_GUILD_RANK5' => $guild['guild_rank_5'],
      'U_GUILD_RANK5' => $rank_5['character_name'],
      'L_GUILD_MEMBERS' => $guild['guild_rank_member'],
      'U_GUILD_MEMBERS' => $members_list,
      'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=$guild_id"),
    ));
    break;

  case 'guilds_bio': // guilds_join submode
    if (!$gm)
      break;
    $guild = adr_guild_get($guild_id);
    if (!$guild)
      break;

    if ($guild['guild_history'] != '')
      $history = $guild['guild_history'];
    else
      $history = $lang['Adr_guilds_bio_none'];									
    $template->assign_block_vars('guilds_bio' , array());

    $template->assign_vars(array(
      'U_GUILDS_BIO' => $history,
      'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=$guild_id"),
    ));
    break;
  }
  break;

default: // mode
	$template->assign_block_vars('guilds_main',array());

	// List all current guilds in table...
	$sql = "SELECT * FROM " . ADR_GUILDS_TABLE . "
			ORDER BY guild_level DESC";
	if ( !($result = $db->sql_query($sql)) ) 
	{ 
		message_die(CRITICAL_ERROR, 'Error Getting Guild names!'); 
	}

	$i = 0; 
	while ($row = $db->sql_fetchrow($result)) 
	{ 
		$guild_id = $row['guild_id'];

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

    // V: not sure how to avoid the N+1. Selecting every single char (that has a guild) to do the calculation sounds suboptimal as well...
    $gsql = "SELECT character_victories , character_defeats , character_flees
      FROM " . ADR_CHARACTERS_TABLE . " c
      LEFT JOIN " . ADR_GUILD_MEMBER_TABLE . " gm
        ON ( c.character_id = gm.guild_member_user_id )
			WHERE gm.guild_member_guild_id = $guild_id"; 
		if ( !($gresult = $db->sql_query($gsql)) ) 
		{ 
			message_die(GENERAL_MESSAGE, 'Fatal Error Getting Guild info'); 
		} 
		$guild_rows = $db->sql_fetchrowset($gresult); 

		$guild_wins = 0; 
		$guild_defs = 0; 
		$guild_escs = 0;

		$countresults = count($row);
    foreach ($guild_rows as $guild_row)
		{ 
			$guild_wins += $guild_row['character_victories']; 
			$guild_defs += $guild_row['character_defeats']; 
			$guild_escs += $guild_row['character_flees'];
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

	// Check if the user meets Guild creation reqs...
  if ( $adr_general['Adr_guild_create_allow']
    && $character_level >= $adr_general['Adr_guild_create_min_level']
    && $character_guild_id == 0 && $character_guild_approval == 0 )
	{
		$template->assign_block_vars('create_allow',array());
	}
}

// Interest addon to clan vault
$account_time = time() - $guild['guild_account_time'];
// V: only do this if you have a guild...
if ( $account_time > $adr_general['interests_time'] && $character_guild_id )
{
  $guild = adr_guild_get($character_guild_id);
	$interests_mult = floor ( $account_time / $adr_general['interests_time']);
	$mult = 1 + ( $adr_general['interests_rate'] / 100 );
	$puissance = 1 + (( $adr_general['interests_rate'] / 100 ) * $interests_mult);
	$account_interests = floor ( $puissance * $guild['guild_vault'] ); 
	$sup_time = floor( $guild['guild_account_time'] + ( $adr_general['interests_time'] * $interests_mult ));

	$sql = "UPDATE " . ADR_GUILDS_TABLE ."
		SET guild_vault = guild_vault + $account_interests,
		guild_account_time = ".$sup_time."
		WHERE guild_id = $guild_id ";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}
}
// end interest addon

$template->assign_vars(array(
  'POINTS_NAME' => $board_config['points_name'],
));


include($phpbb_root_path . 'includes/page_header.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
