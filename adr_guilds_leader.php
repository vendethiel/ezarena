<?php 
/***************************************************************************
 *                                        adr_guilds_leader.php
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

define('IN_PHPBB', true); 
define('IN_ADR_TOWN', true); 
define('IN_ADR_GUILDS', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_BATTLE', true);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'zones';
$sub_loc = 'adr_guilds';
$page_title = ' Guild Admin';
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

adr_guild_add_lang();

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	header('Location: ' . append_sid("index.$phpEx", true));
	exit;
}

// Deny access if user is imprisioned 
if($userdata['user_cell_time']){ 
	adr_previous(Adr_shops_no_thief, adr_cell, '');
}

// Includes the tpl and the header
adr_template_file('adr_guilds_leader_body.tpl');
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

// V: aliased just because this mod is weird
$char = $adr_user;
$character_id = $char['character_id'];
$character_name = $char['character_name'];
$character_level = $char['character_level'];
$character_guild_auth_id = $char['character_guild_auth_id'];
$character_guild_approval = $char['character_guild_approval'];
//V: that's retarded. Don't. Let's query the guild instead...
// $character_guild_id = $char['character_guild_id'];
$sql = "SELECT *
    FROM " . ADR_GUILDS_TABLE . "
    WHERE guild_leader_id = " . $user_id;
if (!($result = $db->sql_query($sql)))
{
  message_die(GENERAL_ERROR, "Cannot query guilds");
}
$guild = $db->sql_fetchrow($result);
// V: prevent access if you don't have a guild...
if (!$guild)
{
	adr_previous("Adr_guild_not_leader", 'adr_guilds');
}
$guild_id = $guild['guild_id'];
// V: btw,the guild_id is NOT for you to choose. query it here.
// Grab details from Guilds table...
$guild = adr_guild_get($guild_id);

switch($mode)
{
case 'guilds_leader_page' :

  $template->assign_block_vars('guilds_leader_page' , array());

  //guild forums details
  $guild_forum = $guild['guild_forums'];
  if ($guild_forum == NULL)
  {
    $guild_forum_text = $lang['Adr_guilds_buy_hq'];
    $guild_forum_link = append_sid('adr_guilds_leader.php?mode=buy_forum');
  }
  else
  {
    $guild_forum_text = $lang['Adr_guilds_go_hq'];
    $guild_forum_link = append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$guild_forum");
  }
  $guilds_name = $guild['guild_name'];
  $date_created = date( "F jS Y" , $guild['guild_date_created'] );
  $date_length = floor( ( time() - $guild['guild_date_created'] ) / 86400 ) ;

  // If Guild has logo URL then show...
  $guilds_logo = adr_guild_logo($guild['guild_logo']);

  // Work out Exp bars...
  $exp_text = $guild['guild_exp'] .'/'. $guild['guild_exp_max'];
  $exp_bar = "<img src=\"bars.php?val=".$guild['guild_exp']."&max=".$guild['guild_exp_max']."&type=exp\" alt=\"$exp_text\">";

  //count members
  $sql = "SELECT count(guild_member_guild_id) AS count
    FROM " . ADR_GUILD_MEMBER_TABLE . " 
    WHERE guild_member_guild_id = $guild_id";
  if ( !($result = $db->sql_query($sql)) ) 
  { 
    message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
  }
  $guildmems = $db->sql_fetchrow($result);

  // Count characters awaiting approval
  $sql = " SELECT COUNT(1) as total
    FROM " . ADR_GUILD_MEMBER_TABLE . "
    WHERE guild_member_auth = " . ADR_GUILD_MEMBER_PENDING . "
      AND guild_member_guild_id = $guild_id";
  if( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not query count for total awaiting approval', '', __LINE__, __FILE__, $sql);
  }
  $total_awaiting = $db->sql_fetchrow($result);
  $total_awaiting = $total_awaiting['total'];

  $template->assign_vars(array(
    'U_GUILDS_LEADER' => $guild['guild_name'],
    'U_GUILDS_FORUMS' => $guild_forum_link,
    'L_GUILDS_FORUMS' => $guild_forum_text,
    'U_GUILDS_LEADER_GUILD_DESC' => $guild['guild_description'],
    'U_GUILDS_INFO_LOGO' => $guilds_logo,
    'U_GUILDS_INFO_EXP' => $exp_bar,
    'U_GUILDS_INCREASE_SIZE' => append_sid('adr_guilds_leader.php?mode=increase_size&guild_id='.$guild_id.''),
    'L_GUILDS_INCREASE_SIZE' => $lang['Adr_guilds_increase_title'].' ('.$guild['guild_size'].')',
    'U_GUILDS_INFO_EXP_MIN' => $guild['guild_exp'],
    'U_GUILDS_INFO_EXP_MAX' => $guild['guild_exp_max'],
    'U_GUILDS_LEADER_LOGO' => $guild['guild_logo'],
    'U_GUILDS_INFO_LEADER' => $guild['guild_leader'],
    'U_GUILDS_INFO_MEMBERS' => $guildmems['count'],
    'U_GUILDS_INFO_LEVEL' => $guild['guild_level'],
    'L_GUILDS_INFO_POINTS' => $board_config['points_name'],
    'U_GUILDS_INFO_VAULT' => $guild['guild_vault'],
    'U_GUILDS_INFO_DATE' => $date_created,
    'U_GUILDS_INFO_COPPER_PEC' => $guild['guild_copper_pec'],
    'U_GUILDS_INFO_HEAL_PEC' => $guild['guild_heal_pec'],
    'U_GUILDS_INFO_EXP_PEC' => $guild['guild_exp_pec'],
    'U_GUILDS_INFO_DATE2' => $date_length,
    'U_GUILDS_APPROVE_COUNT' => $total_awaiting,
    'U_GUILDS_LEADER_APPROVE' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_approve_list"),
    'U_GUILDS_LEADER_USERS' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_users"),
    'U_GUILDS_LEADER_SET_RANKS' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_set_ranks"),
    'U_GUILDS_VAULT' => append_sid("adr_guilds_leader.$phpEx?mode=vault"),
    'U_GUILDS_LEADER_NEW_LEADER' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_new_leader"),
    'U_GUILDS_LEADER_DELETE' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_delete_confirm"),
    'U_GUILDS_ACCEPT_NEW_CHECKED' => ( $guild['guild_accept_new'] ? 'CHECKED' :'' ),
    'U_NO_GUILDS_ACCEPT_NEW_CHECKED' => ( !$guild['guild_accept_new'] ? 'CHECKED' :'' ),
    'U_GUILDS_INFO_JOIN_LEVEL' => $guild['guild_join_min_level'],
    'U_GUILDS_INFO_JOIN_MONEY' => $guild['guild_join_min_money'],
    'U_GUILDS_APPROVE_NEW_CHECKED' => ( $guild['guild_approve'] ? 'CHECKED' :'' ),
    'U_NO_GUILDS_APPROVE_NEW_CHECKED' => ( !$guild['guild_approve'] ? 'CHECKED' :'' ),
    'U_GUILDS_INFO_RANKS' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_ranks&amp;guild_id=$guild_id"),
    'L_GUILDS_LEADER_RANK_LEADER' => $lang['Adr_guilds_leader_rank_leader'],
    'U_GUILDS_LEADER_RANK_LEADER' => $guild['guild_rank_leader'],
    'U_GUILDS_LEADER_RANK1' => $guild['guild_rank_1'],
    'U_GUILDS_LEADER_RANK2' => $guild['guild_rank_2'],
    'U_GUILDS_LEADER_RANK3' => $guild['guild_rank_3'],
    'U_GUILDS_LEADER_RANK4' => $guild['guild_rank_4'],
    'U_GUILDS_LEADER_RANK5' => $guild['guild_rank_5'],
    'U_GUILDS_LEADER_RANK_MEMBER' => $guild['guild_rank_member'],
    'U_GUILDS_LEADER_BIO' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_bio"),
    'U_SUBMIT' => append_sid("adr_guilds.$phpEx?mode=guilds_leader_page_update"),
    'U_GUILDS_BACK' => append_sid("adr_guilds.php?mode=guilds_join"),
  ));

  break;

case'increase_size':
  switch($sub_mode)
  {
  default:
    adr_template_file('adr_guilds_confirm_body.tpl');
    $template->assign_block_vars('guilds_confirm' , array());

    $cost = round((($guild['guild_size']-1)*10000)/(($guild['guild_level']-$guild['guild_size'])/70));
    $template->assign_vars(array(
      'L_GUILDS_CONFIRM_TEXT' => sprintf($lang['Adr_guilds_increase_text'], ($guild['guild_size']*2), (($guild['guild_size']+1)*2), $cost),
      'U_GUILDS_CONFIRM_YES' => append_sid("adr_guilds_leader.$phpEx?mode=increase_size"),
      'U_GUILDS_CONFIRM_NO' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_page"),
      'U_GUILDS_BACK' => append_sid("adr_guilds_leader.php?mode=guilds_leader_page"),
    ));
    break;

  case 'true':
    $cost = adr_guild_increase_size_cost($guild);
    if($guild['guild_vault'] >= $cost)
    {
      $sql = "UPDATE " . ADR_GUILDS_TABLE . "
        SET guild_size = guild_size + 1,
        guild_vault = guild_vault - $cost
        WHERE guild_id = $guild_id ";
      if( !($result = $db->sql_query($sql)) )
      {
        message_die(GENERAL_ERROR, 'Could not query Guild table for info page', '', __LINE__, __FILE__, $sql);
      }

      adr_previous('Adr_guilds_leader_size_increased', 'adr_guilds_leader', "mode=guilds_leader_page");
    }
    else
    {
      adr_previous('Adr_guilds_leader_size_increase_error', 'adr_guilds_leader', "mode=guilds_leader_page");
    }
    break;
  }
  break;

case 'guilds_leader_page_update' :
  // Define some actions
  $accept_new = intval($HTTP_POST_VARS['accept_new']);
  $approve = intval($HTTP_POST_VARS['approve_enable']);
  $min_join_level = intval($HTTP_POST_VARS['min_join_level']);
  $min_join_money = intval($HTTP_POST_VARS['min_join_money']);					
  $desc = ( isset($HTTP_POST_VARS['desc']) ) ? trim($HTTP_POST_VARS['desc']) : '';
  $logo = ( isset($HTTP_POST_VARS['logo']) ) ? $HTTP_POST_VARS['logo'] : '';
  $rank_leader = ( isset($HTTP_POST_VARS['rank_leader']) ) ? trim($HTTP_POST_VARS['rank_leader']) : '';
  $rank1 = ( isset($HTTP_POST_VARS['rank1']) ) ? trim($HTTP_POST_VARS['rank1']) : '';
  $rank2 = ( isset($HTTP_POST_VARS['rank2']) ) ? trim($HTTP_POST_VARS['rank2']) : '';
  $rank3 = ( isset($HTTP_POST_VARS['rank3']) ) ? trim($HTTP_POST_VARS['rank3']) : '';
  $rank4 = (isset($HTTP_POST_VARS['rank4']) ) ? trim($HTTP_POST_VARS['rank4']) : '';
  $rank5 = ( isset($HTTP_POST_VARS['rank5']) ) ? trim($HTTP_POST_VARS['rank5']) : '';
  $rank_member = ( isset($HTTP_POST_VARS['rank_member']) ) ? trim($HTTP_POST_VARS['rank_member']) : '';
  $copper_pec = ( isset($HTTP_POST_VARS['copper_pec']) ) ? intval($HTTP_POST_VARS['copper_pec']) : 0;
  $exp_pec = ( isset($HTTP_POST_VARS['exp_pec']) ) ? intval($HTTP_POST_VARS['exp_pec']) : 0;
  $heal_pec = $HTTP_POST_VARS['heal_pec'];

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
    guild_rank_member = '$rank_member' ,
    guild_copper_pec = '$copper_pec' , 
    guild_exp_pec = '$exp_pec',
    guild_heal_pec = $heal_pec
    WHERE guild_id = $guild_id ";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not update Leader page settings',"", __LINE__, __FILE__, $sql);
  }

  adr_previous('Adr_guilds_leader_page_updated', 'adr_guilds_leader', "mode=guilds_leader_page");
  break;

case 'guilds_users':
  $template->assign_block_vars('guilds_users' , array());

  // Grab details from Guilds table...
  // V: fixed
  $sql= " SELECT * FROM " . ADR_CHARACTERS_TABLE . " c
    LEFT JOIN " . ADR_GUILD_MEMBER_TABLE . " gm
    ON gm.guild_member_user_id = c.character_id
      AND gm.guild_member_guild_id = $guild_id
    WHERE c.character_id != $user_id
      AND gm.guild_member_auth = " . ADR_GUILD_MEMBER_CONFIRMED;
  if( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 1', '', __LINE__, __FILE__, $sql);
  }

  $action_select = '<select name="mode">';
  $action_select .= '<option value="">' . $lang['Adr_items_select_action'] . '</option>';
  $action_select .= '<option value="guilds_users_update">' . $lang['Adr_guilds_users_remove'] . '</option>';
  $action_select .= '</select>';

  $i = 0;
  while ( $member = $db->sql_fetchrow($result) )
  {
    $row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

    $template->assign_block_vars('guilds_users.rows', array(
      "USERS_ROW" => $i + 1,
      "ROW_CLASS" => $row_class,
      "USERS_ID" => $member['character_id'],
      "USERS_NAME" => $member['character_name'],
      "USERS_LEVEL" => $member['character_level'],
      "USERS_HP" => $member['character_hp_max'],
      "USERS_MP" => $member['character_mp_max'],
      "USERS_WINS" => $member['character_victories'],
      "USERS_DEFEATS" => $member['character_defeats'],
      "USERS_FLEES" => $member['character_flees'],
      "USERS_HOPS" => $member['character_guild_hops'],
    ));

    $i++;
  }

  $template->assign_vars(array(
    'ACTION_SELECT' => $action_select,
    'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=guilds_leader_page"),
    'U_SUBMIT' => append_sid("adr_guilds.$phpEx?mode=$action_select&amp;users_box=$users_id"),
    'U_GUILDS_BACK' => append_sid("adr_guilds_leader.php?mode=guilds_leader_page"),
  ));

  break;

case 'guilds_users_update':
  $users_id = ( !empty($HTTP_POST_VARS['users_box']) ) ? $HTTP_POST_VARS['users_box'] : array();
  $users_id = array_map('intval', $users_id);
  if ($users_id)
  {
    // V: filter guild members we ACTUALLY are going to delete.
    // We don't want leaders to remove people from other guilds...
    $sql = "SELECT *
      FROM " . ADR_GUILD_MEMBER_TABLE . "
      WHERE guild_member_guild_id = $guild_id
        AND guild_member_user_id != " . $guild['guild_leader_id'] . "
        AND guild_member_user_id IN (" . implode(', ', $users_id) . ")";
    $result = $db->sql_query($sql);
    $guild_users = $db->sql_fetchrowset($result);
    $db->sql_freeresult($result);
    $users_id = array();
    foreach ($guild_users as $guild_user)
    {
      $users_id[] = $guild_user['guild_member_user_id'];
      // TODO send private message "You got fired"
    }

    if ($users_id)
    {
      $sql = "UPDATE " . ADR_CHARACTERS_TABLE . "
        SET character_guild_hops = character_guild_hops + 1
        WHERE character_id IN (" . implode(', ', $users_id) . ")";
      $db->sql_query($sql);

      $sql = "DELETE FROM " . ADR_GUILD_MEMBER_TABLE . "
        WHERE guild_member_user_id IN (" . implode(', ', $users_id) . ")";
      $db->sql_query($sql);
    }
  }


  adr_previous('Adr_guilds_leader_users_updated', 'adr_guilds_leader', "mode=guilds_leader_page");
                                                
  break;

  //START guild HQ mod by psychobunny
case 'buy_forum' :
  // V: ...use a variable...
  $guild_forums = $guild['guild_forums'];
  if ($guild_forums)
  {
    message_die('Guild HQ Creation', $lang['Adr_guilds_have_hq']);
  }

  $guild_points = $guild['guild_vault'];
  if ($guild_points < 100000)
  {
    message_die($guild_points, sprintf($lang['Adr_guilds_too_expensive'], $guild_points));
  }
  $guild_points = $guild_points - 100000;

  $sql = " UPDATE " . ADR_GUILDS_TABLE . "
    SET guild_vault = $guild_points
          WHERE guild_id = $guild_id";
  if( !($check = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not query Guild table for info page. Please contact the administrator.', '', __LINE__, __FILE__, $sql);
  }

  $guilds_desc = $guild['guild_description'];
  $guilds_name = $guild['guild_name'];
  $guilds_name .= $lang['Adr_guilds_hq_postfix'];
  $guilds_leader = $guild['guild_leader_id'];

  $sql = "SELECT MAX(forum_order) AS max_order
    FROM " . FORUMS_TABLE . "
    WHERE cat_id = 2";
  if( !$result = $db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, "Couldn't get order number from forums table. Please contact the administrator.", "", __LINE__, __FILE__, $sql);
  }
  $row = $db->sql_fetchrow($result);

  $max_order = $row['max_order'];
  $next_order = $max_order + 10;
  // credit to phpbb, used its structure for creating a new forum
  // "dont reinvent the wheel"
  $sql = "SELECT MAX(forum_id) AS max_id
    FROM " . FORUMS_TABLE;
  if( !$result = $db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, "Couldn't get order number from forums table. Please contact the administrator.", "", __LINE__, __FILE__, $sql);
  }
  $row = $db->sql_fetchrow($result);

  $max_id = $row['max_id'];
  $next_id = $max_id + 1;

  $sql = "INSERT INTO " . FORUMS_TABLE . " (forum_id, forum_name, cat_id, forum_desc, forum_order, forum_status, prune_enable, auth_view " . $field_sql . ")
    VALUES ('" . $next_id . "', '" . $guilds_name . "', 2 , '" . $guilds_desc . "', $next_order, " . "0" . ", " . "0, '2' " . $value_sql . ")";
  if( !$result = $db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, "Couldn't insert new forums.  Please contact the administrator.", "", __LINE__, __FILE__, $sql);
  }

  $sql = "INSERT INTO " . GROUPS_TABLE . " (group_type, group_name, group_description, group_moderator, group_single_user) 
    VALUES ('1', '$guilds_name' , '$guilds_desc' , '$guilds_leader', '0')";
  if ( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not insert new group. Please contact the administrator.', '', __LINE__, __FILE__, $sql);
  }
  $new_group_id = $db->sql_nextid();
		
  $sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending)
    VALUES ($new_group_id, '$guilds_leader', 0)";
  if ( !$db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, 'Could not insert new user-group info. Please contact the administrator', '', __LINE__, __FILE__, $sql);
  }
					
  $sql = " UPDATE " . ADR_GUILDS_TABLE . "
    SET guild_forums = $next_id,
    guild_forum_group = $new_group_id
    WHERE guild_id = $guild_id ";
  if( !$result = $db->sql_query($sql) )
  {
    message_die(GENERAL_ERROR, "Couldn't update guild forums. Please contact the administrator.", "", __LINE__, __FILE__, $sql);
  }
		
  $sql = "UPDATE  " . AUTH_ACCESS_TABLE . " 
    SET auth_view = 1,
    forum_id = $next_id
    WHERE group_id = " . $new_group_id;
  if ( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Cannot set Forum Authentication. Please contact the administrator.', '', __LINE__, __FILE__, $sql);
  }
  break;

case 'guilds_leader_set_ranks' :
  $template->assign_block_vars('guilds_leader_set_ranks' , array());
  $template->assign_block_vars('admin_button_two' , array());

  $rank_member_1 = adr_guild_get_character_by_rank(1, $guild_id);
  $rank_member_2 = adr_guild_get_character_by_rank(2, $guild_id);
  $rank_member_3 = adr_guild_get_character_by_rank(3, $guild_id);
  $rank_member_4 = adr_guild_get_character_by_rank(4, $guild_id);
  $rank_member_5 = adr_guild_get_character_by_rank(5, $guild_id);
  $rank_1 = $rank_member_1 ? $rank_member_1['character_name'] : $lang['Adr_guilds_rank_none'];
  $rank_2 = $rank_member_2 ? $rank_member_2['character_name'] : $lang['Adr_guilds_rank_none'];
  $rank_3 = $rank_member_3 ? $rank_member_3['character_name'] : $lang['Adr_guilds_rank_none'];
  $rank_4 = $rank_member_4 ? $rank_member_4['character_name'] : $lang['Adr_guilds_rank_none'];
  $rank_5 = $rank_member_5 ? $rank_member_5['character_name'] : $lang['Adr_guilds_rank_none'];

  // Grab details from Guilds table. V: refactor /o/
  $members = adr_guild_get_members($guild_id, 'list', true);

  // START lists for ranks
  $list_1 = adr_guild_build_members_select($members, $guild['guild_rank_1_id'], 'list_rank_1', $lang['Adr_guilds_set_rank']);
  $list_2 = adr_guild_build_members_select($members, $guild['guild_rank_2_id'], 'list_rank_2', $lang['Adr_guilds_set_rank']);
  $list_3 = adr_guild_build_members_select($members, $guild['guild_rank_3_id'], 'list_rank_3', $lang['Adr_guilds_set_rank']);
  $list_4 = adr_guild_build_members_select($members, $guild['guild_rank_4_id'], 'list_rank_4', $lang['Adr_guilds_set_rank']);
  $list_5 = adr_guild_build_members_select($members, $guild['guild_rank_5_id'], 'list_rank_5', $lang['Adr_guilds_set_rank']);

  $template->assign_vars(array(
    'U_RANK_1' => $rank_1,
    'RANK_1' => $list_1,
    'U_RANK_2' => $rank_2,
    'RANK_2' => $list_2,
    'U_RANK_3' => $rank_3,
    'RANK_3' => $list_3,
    'U_RANK_4' => $rank_4,
    'RANK_4' => $list_4,
    'U_RANK_5' => $rank_5,
    'RANK_5' => $list_5,
    'ACTION_SELECT' => $action_select,
    'U_SUBMIT' => append_sid("adr_guilds_leader.$phpEx?mode=$action_select&amp;users_box=$users_id"),
    'U_GUILDS_BACK' => append_sid("adr_guilds_leader.php?mode=guilds_leader_page"),
  ));
  break;

case 'guilds_leader_set_ranks_update' :
  $rank_1 = intval($HTTP_POST_VARS['list_rank_1']);
  $rank_2 = intval($HTTP_POST_VARS['list_rank_2']);
  $rank_3 = intval($HTTP_POST_VARS['list_rank_3']);
  $rank_4 = intval($HTTP_POST_VARS['list_rank_4']);
  $rank_5 = intval($HTTP_POST_VARS['list_rank_5']);

  // V: TODO check members are IN the guild...
  $rank_1_character = adr_get_user_infos($rank_1);
  $rank_2_character = adr_get_user_infos($rank_2);
  $rank_3_character = adr_get_user_infos($rank_3);
  $rank_4_character = adr_get_user_infos($rank_4);
  $rank_5_character = adr_get_user_infos($rank_5);

  /**
   *
        guild_rank_1 = '" . addslashes($rank_1_character['character_name']) . "',
        guild_rank_2 = '" . addslashes($rank_2_character['character_name']) . "',
        guild_rank_3 = '" . addslashes($rank_3_character['character_name']) . "',
        guild_rank_4 = '" . addslashes($rank_4_character['character_name']) . "',
        guild_rank_5 = '" . addslashes($rank_5_character['character_name']) . "'
   */
  $sql = "UPDATE " . ADR_GUILDS_TABLE . " 
    SET guild_rank_1_id = $rank_1,
        guild_rank_2_id = $rank_2,
        guild_rank_3_id = $rank_3,
        guild_rank_4_id = $rank_4,
        guild_rank_5_id = $rank_5
    WHERE guild_id = $guild_id";
  if (!($result = $db->sql_query($sql)) ) 
  { 
    message_die(GENERAL_MESSAGE, 'Could not set ranks', '', __LINE__, __FILE__, $sql); 
  }	

  adr_previous('Adr_guilds_leader_set_ranks_updated', 'adr_guilds_leader', "mode=guilds_leader_page");

  break;

case 'guilds_leader_new_leader' :
  $template->assign_block_vars('guilds_leader_new_leader' , array());

  // Grab details from Guilds table...
  $old_leader = adr_get_user_infos($guild['guild_leader_id']);

  // Grab details from Guilds table...
  $members = adr_guild_get_members($guild_id, 'list', true);
  $members_list = adr_guild_build_members_select($members, 0, 'list_members', $lang['Adr_guilds_no_members']);

  $template->assign_vars(array(
    'L_CURRENT_LEADER' => $lang['Adr_guilds_leader_current'],
    'U_CURRENT_LEADER' => $old_leader['character_name'],
    'L_NEW_LEADER' => $lang['Adr_guilds_leader_new'],
    'L_MEMBERS_LIST' => $lang['Adr_guilds_leader_select'],
    'U_MEMBERS_LIST' => $members_list,
    'L_SUBMIT' => $lang['Adr_guilds_submit'],
    'L_GUILDS_BACK' => $lang['Adr_guilds_back_to_guild_admin'],
    'U_GUILDS_BACK' => append_sid("adr_guilds_leader.php?mode=guilds_leader_page&guild_id=$guild_id"),
  ));
  break;


case 'guilds_leader_new_leader_update' :
  $new_leader_id = intval($HTTP_POST_VARS['list_members']);

  /* V: don't delete old leader membership.
   *    If you give leadership, you stay in the guild - but as an underling.
  $guild_leader = adr_get_user_infos($guild['guild_leader_id']);
  $sql = "DELETE FROM " . ADR_GUILD_MEMBER_TABLE . "
    WHERE guild_member_user_id = " . $guild['guild_leader_id'];
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not reset Leader to normal user',"", __LINE__, __FILE__, $sql);
  }
   */

  // V: check new leader is correct
  $sql = "SELECT gm.*, c.character_name
    FROM " . ADR_GUILD_MEMBER_TABLE . " gm
    LEFT JOIN " . ADR_CHARACTERS_TABLE . " c
      ON c.character_id = gm.guild_member_user_id
    WHERE guild_member_user_id = " . $new_leader_id;
  $result = $db->sql_query($sql);
  $new_leader = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  if (!$new_leader
    || $new_leader['guild_member_guild_id'] != $guild_id
    || $new_leader['guild_member_auth'] != ADR_GUILD_MEMBER_CONFIRMED)
  {
    message_die(GENERAL_ERROR, 'Invalid leader ID');
  }

  // Set new leader
  $sql = "UPDATE " . ADR_GUILDS_TABLE . "
    SET guild_leader_id = $new_leader_id,
        guild_leader = '" . addslashes($new_leader['character_name']) . "'
    WHERE guild_id = $guild_id ";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not update Leader page settings',"", __LINE__, __FILE__, $sql);
  }

  adr_previous('Adr_guilds_leader_new_leader_updated', 'adr_guilds', "");
  break;

case 'guilds_leader_delete_confirm' :
  adr_template_file('adr_guilds_confirm_body.tpl');
  $template->assign_block_vars('guilds_leader_delete_confirm' , array());

  $template->assign_vars(array(
    'U_GUILDS_DELETE_YES' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_delete&amp;sub_mode=&amp;guild_id=$guild_id"),
    'U_GUILDS_DELETE_NO' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=$guild_id"),
    'U_GUILDS_BACK' => append_sid("adr_guilds_leader.php?mode=guilds_leader_page&guild_id=$guild_id"),
  ));

  break;

case 'guilds_leader_delete' :
  // V: only delete group if... there's a group...
  if ($guild['guild_forum_group'])
  {
    //delete usergroup
    // V: HOW FUCKING RETARDED CAN YOU BE? This used to delete every group the user moderates.
    $sql = "DELETE FROM " . GROUPS_TABLE . "
      WHERE group_id = " . $row['guild_forum_group'];
    if( !$db->sql_query($sql))
    {
      message_die(GENERAL_ERROR, 'Could not delete Guild from Guild table',"", __LINE__, __FILE__, $sql);
    }
  }

  //delete the guild forum if they have one
  if ($guild['guild_forums'])
  {
    $sql = "DELETE FROM " . FORUMS_TABLE . "
      WHERE forum_id = " . $row['guild_forums'];
    if( !$db->sql_query($sql))
    {
      message_die(GENERAL_ERROR, 'Could not delete Guild from Guild table',"", __LINE__, __FILE__, $sql);
    }

    //delete all posts from forum
    $sql = "SELECT post_id, topic_id FROM " . POSTS_TABLE . "
      WHERE forum_id = " . $row['guild_forums'];
    if( !$db->sql_query($sql))
    {
      message_die(GENERAL_ERROR, 'Could not delete Guild from Guild table',"", __LINE__, __FILE__, $sql);
    }

    //delete everything else
    while($postdetails = $db->sql_fetchrow($result))
    {
      //delete posts body
      $sql = "DELETE FROM " . POSTS_TEXT_TABLE . "
        WHERE post_id = " . $postdetails['post_id'];
      if( !$db->sql_query($sql))
      {
        message_die(GENERAL_ERROR, 'Could not delete Guild forum information',"", __LINE__, __FILE__, $sql);
      }

      //delete post edits information
      $sql = "DELETE FROM " . POSTS_EDIT_TABLE . "
        WHERE post_id = " . $postdetails['post_id'];
      if( !$db->sql_query($sql))
      {
        message_die(GENERAL_ERROR, 'Could not delete Guild forum information',"", __LINE__, __FILE__, $sql);
      }

      //delete topic
      $sql = "DELETE FROM " . TOPICS_TABLE . "
        WHERE topic_id = " . $postdetails['topic_id'];
      if( !$db->sql_query($sql))
      {
        message_die(GENERAL_ERROR, 'Could not delete Guild forum information',"", __LINE__, __FILE__, $sql);
      }

      //delete any watching information
      $sql = "DELETE FROM " . TOPICS_WATCH_TABLE . "
        WHERE topic_id = " . $postdetails['topic_id'];
      if( !$db->sql_query($sql))
      {
        message_die(GENERAL_ERROR, 'Could not delete Guild forum information',"", __LINE__, __FILE__, $sql);
      }

      //delete actual post
      $sql = "DELETE FROM " . POSTS_TABLE . "
        WHERE post_id = " . $postdetails['post_id'];
      if( !$db->sql_query($sql))
      {
        message_die(GENERAL_ERROR, 'Could not delete Guild forum information',"", __LINE__, __FILE__, $sql);
      }

    }

  }

  //delete members
  $sql = "DELETE FROM " . ADR_GUILD_MEMBER_TABLE . "
    WHERE guild_member_guild_id = $guild_id ";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not delete members',"", __LINE__, __FILE__, $sql);
  }

  // Delete Guild from Guilds Table...
  $sql = "DELETE FROM " . ADR_GUILDS_TABLE . " 
    WHERE guild_id = $guild_id ";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not delete Guild from Guild table',"", __LINE__, __FILE__, $sql);
  }

  adr_previous('Adr_guilds_leader_delete_updated', 'adr_guilds', '');
  break;

case 'guilds_approve_list' :
  $template->assign_block_vars('guilds_approve_list' , array());

  // Grab details from Guilds table...
  // V: only take people who havn't been accepted yet.
  $pending_members = adr_guild_get_members($guild_id, 'list', true, ADR_GUILD_MEMBER_PENDING);

  // Define some actions
  $guilds_approve_select = intval($HTTP_POST_VARS['guilds_approve_select']);

  $action_select = '<select name="mode">';
  $action_select .= '<option value="">' . $lang['Adr_items_select_action'] . '</option>';
  $action_select .= '<option value="guilds_approve_yes">' . $lang['Adr_guilds_approve_yes'] . '</option>';
  $action_select .= '<option value="guilds_approve_no">' . $lang['Adr_guilds_approve_no'] . '</option>';
  $action_select .= '</select>';

  $i = 0;
  foreach ($pending_members as $pending_member)
  {
    $row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

    $template->assign_block_vars('guilds_approve_list.rows', array(
      "APPROVE_ROW" => $i + 1,
      "ROW_CLASS" => $row_class,
      "APPROVE_ID" => $pending_member['character_id'],
      "APPROVE_NAME" => $pending_member['character_name'],
      "APPROVE_LEVEL" => $pending_member['character_level'],
      "APPROVE_HP" => $pending_member['character_hp_max'],
      "APPROVE_MP" => $pending_member['character_mp_max'],
      "APPROVE_WINS" => $pending_member['character_victories'],
      "APPROVE_DEFEATS" => $pending_member['character_defeats'],
      "APPROVE_FLEES" => $pending_member['character_flees'],
      "APPROVE_HOPS" => $pending_member['character_guild_hops'],
    ));

    $i++;
  }

  $template->assign_vars(array(
    'ACTION_SELECT' => $action_select,
    'GUILD_ID' => $guild_id,
    'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=$guild_id"),
    'U_SUBMIT' => append_sid("adr_guilds.$phpEx?mode=$action_select&amp;sub_mode=&amp;guild_id=$guild_id&amp;approve_box=$approve_id"),
    'U_GUILDS_BACK' => append_sid("adr_guilds_leader.php?mode=guilds_leader_page&guild_id=$guild_id"),
  ));
  break;

case 'guilds_approve_yes' :
  $approve_ids = ( isset($HTTP_POST_VARS['approve_box']) ) ? $HTTP_POST_VARS['approve_box'] : array();
  $approve_ids = array_map('intval', $approve_ids);

  $approve_users = array();
  if ($approve_ids)
  {
    // V: select members we're actually going to approve
    $sql = "SELECT *
      FROM " . ADR_GUILD_MEMBER_TABLE . "
      WHERE guild_member_guild_id = $guild_id
        AND guild_member_auth = " . ADR_GUILD_MEMBER_PENDING . "
        AND guild_member_user_id IN (" . implode(', ', $approve_ids) . ")";
    $result = $db->sql_query($sql);
    $approve_users = $db->sql_fetchrowset($result);
    $db->sql_freeresult($result);
    $approve_ids = array();
    foreach ($approve_users as $approve_user)
    {
      $approve_ids[] = $approve_user['guild_member_user_id'];

      if ($guild['guild_forum_group'])
      {
        $sql = "INSERT INTO " . USER_GROUP_TABLE . " (group_id, user_id, user_pending)
          VALUES (".$guild['guild_forum_group'].", '" . $approve_user['guild_member_user_id'] . "', 0)";
        if ( !$db->sql_query($sql) )
        {
          message_die(GENERAL_ERROR, 'Could not insert new user-group info. Please contact the administrator', '', __LINE__, __FILE__, $sql);
        }
      }

      // TODO send pm
    }
  }

  if ($approve_users)
  {
    // V: let's do it in a single SQL query.
    //     only update pending users so that you can't reset join date.
    $sql = "UPDATE " . ADR_GUILD_MEMBER_TABLE . "
      SET guild_member_auth = " . ADR_GUILD_MEMBER_CONFIRMED . ",
          guild_member_join_date = " . time() . "
      WHERE guild_member_user_id IN (" . implode(', ', $approve_ids) . ")";
    $db->sql_query($sql);
  }

  adr_previous('Adr_guilds_approve_list_approve', 'adr_guilds_leader', "mode=guilds_leader_page&amp;guild_id=".$guild_id);        

  break;

case 'guilds_approve_no' :
  $approve_ids = ( isset($HTTP_POST_VARS['approve_box']) ) ? $HTTP_POST_VARS['approve_box'] : array();

  if ($approve_ids)
  {
    $approve_ids = array_map('intval', $approve_ids);
    $sql = "DELETE FROM " . ADR_GUILD_MEMBER_TABLE . "
      WHERE guild_member_auth = " . ADR_GUILD_MEMBER_PENDING . "
        AND guild_member_guild_id = $guild_id
        AND guild_member_user_id IN (" . implode(', ', $approve_ids) . ")";
    $db->sql_query($sql);

    // TODO send PMs
  }

  adr_previous('Adr_guilds_approve_list_reject', 'adr_guilds_leader', "mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=".$guild_id);        
  break;

case 'guilds_leader_bio' :
  $template->assign_block_vars('guilds_leader_bio' , array());

  $template->assign_vars(array(
    'U_GUILDS_BIO' => $guild['guild_history'],
    'U_SUBMIT' => append_sid("adr_guilds.$phpEx?mode=guilds_leader_bio_update&amp;sub_mode="),
    'U_GUILDS_BACK' => append_sid("adr_guilds_leader.php?mode=guilds_leader_page&guild_id=$guild_id"),
  ));
  break;

case 'guilds_leader_bio_update' :
  $guilds_bio = $HTTP_POST_VARS['guilds_bio'];
  $sql = "UPDATE " . ADR_GUILDS_TABLE . "
    SET guild_history = '$guilds_bio'   
    WHERE guild_id = $guild_id ";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not update Guild bio',"", __LINE__, __FILE__, $sql);
  }

  adr_previous('Adr_guilds_leader_bio_updated', 'adr_guilds_leader', "mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=".$guild_id);
  break;

case 'vault':
  $template->assign_block_vars('guild_vault' , array());

  $template->assign_vars(array(
    'U_VAULT_TOTAL' => $guild['guild_vault'],
    'L_GUILDS_BACK' => $lang['Adr_guilds_back_to_guild_admin'],
    'U_GUILDS_BACK' => append_sid("adr_guilds_leader.php?mode=guilds_leader_page&guild_id=$guild_id"),
  ));
  break;
}

$template->assign_vars(array(
	'POINTS_NAME' => $board_config['points_name'],
));


include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?>
