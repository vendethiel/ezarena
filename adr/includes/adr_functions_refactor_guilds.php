<?php
/**
 * V: the guild mod is utter shit. Refactor it.
 */

define('ADR_GUILD_MEMBER_PENDING', 0);
define('ADR_GUILD_MEMBER_CONFIRMED', 1);

function adr_guild_logo($logo)
{
  global $lang;

  if ($logo == '' || false === $img = @getimagesize($logo))
  {
    return $lang['Adr_guilds_logo_none'];
  }
  else
  {
    // Resize logo if too large...
    list($width, $height) = $img;
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
    return '<img src="' . $logo . '" alt="" border="0"' . $width_attr . $height_attr . '>';
  }
}

/**
 * Returns the confirmed members of a guild.
 *
 * Pass the second parameter as 'count' to get only the count
 */
function adr_guild_get_members($guild_id, $mode = '')
{
  global $db;

  $sql = " SELECT guild_member_guild_id FROM " . ADR_GUILD_MEMBER_TABLE . "
    WHERE guild_member_guild_id = " . intval($guild_id) . "
    AND guild_member_auth = " . ADR_GUILD_MEMBER_CONFIRMED;
  if( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not query count for info page', '', __LINE__, __FILE__, $sql);
  }
  $members = $mode == 'count' ? $db->sql_numrows($result) : $db->sql_fetchrowset($result);
  $db->sql_freeresult($result);
  return $members;
}

/**
 * Returns the total count of members, authenticated or not.
 */
function adr_guild_count_all_members($guild_id)
{
  global $db;
  $sql = "SELECT count(guild_member_guild_id) AS count
    FROM " . ADR_GUILD_MEMBER_TABLE . " 
    WHERE guild_member_guild_id = " . intval($guild_id);
  if ( !($result = $db->sql_query($sql)) ) 
  { 
    message_die(CRITICAL_ERROR, 'Error Getting Adr Users!'); 
  }
  $guildmems = $db->sql_fetchrow($result);
  //$db-sql_freeresult($result);
  return $guildmems;
}

function adr_guild_deposit($guild_id)
{
  // deposit funds
  $deposit = isset($_POST['deposit']);
  if (!$deposit)
    return;
  $deposit_sum = str_replace(',', '', $HTTP_POST_VARS['deposit_sum']);
  if ( $deposit && $deposit_sum > 0 )
  {
    $deposit_sum = str_replace(',', '', $deposit_sum);
    if ( $deposit_sum > $userdata['user_points'] )
    {
      adr_previous( Adr_vault_deposit_lack, adr_guilds , "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id);
    }

    update_guild_vault($deposit_sum, $guild_id);

    subtract_reward( $user_id, $deposit_sum );

    adr_previous( Adr_guilds_donate, adr_guilds , "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id);
  }
}

function adr_guild_get($id)
{
  global $db;
  static $cache;
  if (isset($cache[$id]))
    return $cache[$id];
  $sql = " SELECT * FROM " . ADR_GUILDS_TABLE . "
    WHERE guild_id = " . intval($id);
  if( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not query Guild table for info page', '', __LINE__, __FILE__, $sql);
  }
  $cache[$id] = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  return $cache[$id];
}

function adr_guild_withdraw($guild_id)
{
  // leader withdraw funds
  $withdraw = isset($_POST['withdraw']);
  $withdraw_sum = intval(str_replace(',', '', $_POST['withdraw_sum']));
  if ( $withdraw && $withdraw_sum > 0 )
  {
    $withdraw_sum = str_replace(',', '', $withdraw_sum);
    if ( $withdraw_sum > $guild['guild_vault'] )
    {
      adr_previous( Adr_guilds_withdraw_lack, adr_guilds , "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id );
    }
    $sql = "UPDATE " . ADR_GUILDS_TABLE ."
      SET guild_vault = guild_vault - $withdraw_sum
      WHERE guild_id = " . intval($guild_id);
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
  }

  add_reward( $user_id, $withdraw_sum );

  adr_previous( Adr_guild_account_ok, adr_guilds , "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id."" );

  }
  // end withdraw funds
}

/**
 * Template-assigns URL stuff
 */
function adr_guild_add_urls()
{
  global $template, $phpEx;
  $template->assign_vars(array(
    'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
    'U_GUILDS_CREATE' => append_sid("adr_guilds.$phpEx?mode=guilds_create&amp;sub_mode=guilds_create_confirm"),
    'U_GUILDS_APPLY_NO' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
    'U_GUILDS_LEAVE_NO' => append_sid("adr_guilds.$phpEx"),
    'U_GUILDS_CREATE_YES' => append_sid("adr_guilds.$phpEx?mode=guilds_create&amp;sub_mode=guilds_create_info"),
    'U_GUILDS_CREATE_NO' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
    'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
    'U_GUILDS_CREATE_SUBMIT' => append_sid("adr_guilds.$phpEx?mode=guilds_create&amp;sub_mode=guilds_create_success"),
    'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
  ));
}

/**
 * Template-assigns lang stuff.
 */
function adr_guild_add_lang()
{
  global $template, $lang;
  $template->assign_vars(array(
    'L_GUILDS_RANKS' => $lang['Adr_guilds_ranks'],
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
    'L_GUILDS_BIO_TITLE' => $lang['Adr_guilds_bio_title'],
    'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
    'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
    'L_GUILDS_LEAVE_TITLE' => $lang['Adr_guilds_leave_title'],
    'L_GUILDS_LEAVE_TEXT' => $lang['Adr_guilds_leave_text'],
    'L_GUILDS_LEADER_BUTTON' => $lang['Adr_guilds_leader_button'],
    'L_GUILDS_FORUM' => $lang['Adr_guilds_go_hq'],
    'L_GUILDS_CREATE_MONEY_TITLE' => $lang['Adr_guilds_create_money_title'],
    'L_GUILDS_ERROR_TITLE' => $lang['Adr_guilds_error_title'],
    'L_GUILDS_ERROR_TEXT' => $lang['Adr_guilds_error_text'],
    'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
    'L_GUILDS_CREATE_MONEY_TEXT' => $lang['Adr_guilds_create_money_text'],
    'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
    'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
    'L_GUILD_TITLE' => $lang['Adr_guilds_create_title'],
    'L_GUILD_NAME' => $lang['Adr_guilds_name'],
    'L_GUILD_DESCRIPTION' => $lang['Adr_guilds_description'],
    'L_GUILD_LOGO' => $lang['Adr_guilds_logo'],
    'L_GUILD_JOIN_LEVEL' => $lang['Adr_guilds_join_level'],
    'L_GUILD_JOIN_MONEY1' => $lang['Adr_guilds_join_money1'],
    'L_GUILD_JOIN_MONEY2' => $lang['Adr_guilds_join_money2'],
    'L_SUBMIT' => $lang['Adr_guilds_create_submit'],
    'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
    'L_GUILDS_JOIN_MONEY_TITLE' => $lang['Adr_guilds_join_money_title'],
    'L_GUILDS_ERROR_TITLE' => $lang['Adr_guilds_error_title'],
    'L_GUILDS_CREATE_TITLE' => $lang['Adr_guilds_create_title'],
    'L_GUILDS_CREATE_TEXT' => $lang['Adr_guilds_create_confirm'],
    'L_GUILDS_ERROR_TEXT' => $lang['Adr_guilds_error_text'],
    'L_GUILDS_JOIN_MONEY_TEXT' => $lang['Adr_guilds_join_money_text'],
    'L_GUILDS_APPLY_TITLE' => $lang['Adr_guilds_apply_title'],
    'L_GUILDS_APPLY_TEXT' => $lang['Adr_guilds_apply_text'],
    'L_YES' => $lang['Adr_guilds_yes'],
    'L_NO' => $lang['Adr_guilds_no'],
    'L_GUILDS_INFO_BIO' => $lang['Adr_guilds_info_bio'],
    'L_GUILDS_INFO_JOIN_REQS' => $lang['Adr_guilds_join_reqs'],
    'L_GUILDS_INFO_JOIN_ACCEPT_NEW' => $lang['Adr_guilds_join_accept_new'],
    'L_GUILDS_INFO_JOIN_LEVEL' => $lang['Adr_guilds_join_reqs_level'],
    'L_GUILDS_INFO_JOIN_MONEY' => $lang['Adr_guilds_join_reqs_money'],
    'L_GUILDS_INFO_JOIN_APPROVE_NEW' => $lang['Adr_guilds_join_approve'],
    'L_GUILDS_BACK' => $lang['Adr_guilds_back'],
    'L_GUILDS_INFO_LENGTH' => $lang['Adr_guilds_info_length'],
    'L_GUILDS_INFO_COPPER_PEC' => $lang['Adr_guilds_copper_pec'],
    'L_GUILDS_INFO_DATE' => $lang['Adr_guilds_info_date'],
    'L_GUILDS_INFO_VAULT' => $lang['Adr_guilds_info_vault'],
    'L_GUILDS_INFO_LEVEL' => $lang['Adr_guilds_info_level'],
    'L_GUILDS_INFO_MEMBERS' => $lang['Adr_guilds_info_members'],
    'L_GUILDS_INFO' => $lang['Adr_guilds_info'],
    'L_GUILDS_INFO_LEADER' => $lang['Adr_guilds_info_leader'],
    'L_GUILDS_INFO_DATE2' => $lang['Adr_guilds_info_date2'],
    'L_GUILDS_INFO_EXP_PEC' => $lang['Adr_guilds_exp_pec'],
    'L_GUILDS_INFO_HEAL_PEC' => $lang['Adr_guilds_heal_pec'],
    'L_GUILDS_JOIN_BUTTON' => $lang['Adr_guilds_join_button'],
    'L_GUILDS_RETRACT_BUTTON' => $lang['Adr_guilds_retract_button'],
    'L_GUILDS_LEAVE_BUTTON' => $lang['Adr_guilds_leave_button'],
    'L_GUILDS_INFO_RANKS' => $lang['Adr_guilds_info_ranks'],
  ));
}

function adr_guild_create()
{
  global $HTTP_POST_VARS, $db, $character_name, $user_id, $adr_general;
  $guild_name = ( isset($HTTP_POST_VARS['guilds_name']) ) ? trim($HTTP_POST_VARS['guilds_name']) : '';
  $guild_description = ( isset($HTTP_POST_VARS['guilds_description']) ) ? trim($HTTP_POST_VARS['guilds_description']) : '';

  if (empty($guild_name) || empty($guild_description))
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
  // V: ... using a function not a SQL query...
  $guilds_id = $db->sql_nextid();

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
  $sql = "INSERT INTO " . ADR_GUILD_MEMBER_TABLE . "
    (guild_member_guild_id , guild_member_user_id , guild_member_auth , guild_member_join_date)
    VALUES ($guilds_id , $user_id, ".ADR_GUILD_MEMBER_CONFIRMED.", $date_created)";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not update Character table',"", __LINE__, __FILE__, $sql);
  }

  adr_previous('Adr_guilds_create_success', 'adr_guilds', '');
}

/**
 * Builds the info page
 * 
 * @param array guild The guild.
 * @param array gm The GuildMember.
 */
function adr_guild_info_page($guild_id, $gm)
{
  global $db, $template, $phpEx, $lang, $user_id;

  $guild = adr_guild_get($guild_id);
  if (!$guild)
    return;

  $guild_forum = $guild['guild_forums'];
  if ($guild_forum)
  {
    $template->assign_block_vars('guilds_info_page.guild_forum',array(
      'U_GUILDS_FORUM' => append_sid("viewforum.$phpEx?" . POST_FORUM_URL . "=$guild_forum"),
    ));
  }
  $date_created = date( "F jS Y" , $guild['guild_date_created'] );
  $date_length = floor( ( time() - $guild['guild_date_created'] ) / 86400 ) ;

  // Show new applicant status...
  $guild_accepting_new = $lang['Adr_guilds_' . ($guild['guild_accept_new'] ? 'yes' : 'no' )];
  $guild_approve = $lang['Adr_guilds_'. ($guild['guild_approve'] ? 'yes' : 'no')];

  // If Guild has logo URL then show...
  $guild_logo = adr_guild_logo($guild['guild_logo']);

  // Work out Exp bars...
  $exp_text = $guild['guild_exp'] .'/'. $guild['guild_exp_max'];
  // V: TODO FIXME
  //$exp_bar = "<img src=\"bars.php?val=".$guild['guild_exp']."&max=".$guild['guild_exp_max']."&type=exp\" alt=\"$exp_text\">";

  // Count current members
  $count_members = adr_guild_get_members($guild['guild_id'], 'count');

  // maybe deposit...
  adr_guild_deposit($guild_id);

  $template->assign_vars(array(
    'U_GUILDS_INFO_NAME' => $guild['guild_name'],
    'U_GUILDS_INFO_DESC' => $guild['guild_description'],
    'U_GUILDS_INFO_LOGO' => $guilds_logo,
    'U_GUILDS_INFO_EXP' => $exp_bar,
    'U_GUILDS_INFO_EXP_MIN' => $guild['guild_exp'],
    'U_GUILDS_INFO_EXP_MAX' => $guild['guild_exp_max'],
    'U_GUILDS_INFO_LEADER' => $guild['guild_leader'],
    'U_GUILDS_INFO_MEMBERS' => $count_members,
    'U_GUILDS_INFO_LEVEL' => $guild['guild_level'],
    'L_GUILDS_INFO_POINTS' => $board_config['points_name'],
    'U_GUILDS_INFO_VAULT' => $guild['guild_vault'],
    'U_GUILDS_INFO_DATE' => $date_created,
    'L_GUILD_MAX_SIZE' => $lang['Adr_guild_size_limit'].($guild['guild_size']*2),
    'U_GUILDS_INFO_COPPER_PEC' => $guild['guild_copper_pec'],
    'U_GUILDS_INFO_EXP_PEC' => $guild['guild_exp_pec'],
    'U_GUILDS_INFO_HEAL_PEC' => $guild['guild_heal_pec'],
    'U_GUILDS_INFO_DATE2' => $date_length,
    'U_GUILDS_INFO_RANKS' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_ranks&amp;guild_id=$guild_id"),
    'U_GUILDS_INFO_BIO' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_bio&amp;guild_id=$guild_id"),
    'L_GUILDS_INFO_JOIN_ACCEPT' => $guild_accepting_new,
    'U_GUILDS_INFO_JOIN_LEVEL' => $guild['guild_join_min_level'],
    'U_GUILDS_INFO_JOIN_MONEY' => $guild['guild_join_min_money'],
    'L_GUILDS_INFO_JOIN_APPROVE' => $guild_approve,
    'U_GUILDS_BACK' => append_sid("adr_guilds.$phpEx?mode=&amp;sub_mode="),
  )); 

  $guildmems = adr_guild_count_all_members($guild['guild_id']);
						
  if (!$gm && $guildmems['count'] <= ($guild['guild_size']*2) && $guild['guild_accept_new'])
  {
    $template->assign_block_vars('guilds_join_button' , array());

    $template->assign_vars(array(
      'U_GUILDS_JOIN_BUTTON' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_apply_confirm&amp;guild_id=$guild_id"),
    ));
  }

  if ($gm && $gm['guild_member_auth'] == ADR_GUILD_MEMBER_PENDING && $gm['guild_member_guild_id'] == $guild['guild_id'])
  {
    $template->assign_block_vars('guilds_retract_button' , array());

    $template->assign_vars(array(
      'U_GUILDS_RETRACT_BUTTON' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_retract&amp;guild_id=$guild_id"),
    ));
  }

  if ($user_id == $guild['guild_leader_id'])
  {
    adr_guild_withdraw($guild['guild_id']);

    $template->assign_block_vars('guilds_leader_button' , array());

    $template->assign_vars(array(
      'U_GUILDS_LEADER_BUTTON' => append_sid("adr_guilds_leader.$phpEx?mode=guilds_leader_page&amp;sub_mode=&amp;guild_id=$guild_id"),
    ));
  }
  else if ($gm && $gm['guild_member_auth'] == ADR_GUILD_MEMBER_CONFIRMED && $gm['guild_member_guild_id'] == $guild['guild_id'])
  {
    $template->assign_block_vars('guilds_leave_button' , array());

    $template->assign_vars(array(
      'U_GUILDS_LEAVE_BUTTON' => append_sid("adr_guilds.$phpEx?mode=guilds_join&amp;sub_mode=guilds_leave_confirm&amp;guild_id=$guild_id"),
    ));
  }
}

function adr_guild_register($guild, $adr_user)
{
  global $lang, $db;

  $guild_id = $guild['guild_id'];
  $user_id = $adr_user['character_id'];
  $character_name = $adr_user['character_name'];

  $date_joined = time();
  // Update Character table with Guild name & basic member rank...
  $sql = "INSERT INTO " . ADR_GUILD_MEMBER_TABLE . "
    (guild_member_guild_id, guild_member_user_id, guild_member_join_date, guild_member_auth)
    VALUES ($guild_id, $user_id, $date_joined, " . ADR_GUILD_MEMBER_CONFIRMED . ")";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not update Character table upon successful join',"", __LINE__, __FILE__, $sql);
  }

  if ($guild['guild_forum_group'] > 0)
  {
    $sql = "INSERT INTO " . USER_GROUP_TABLE . "
      (group_id, user_id, user_pending)
      VALUES (".$guild['guild_forum_group'].", '$user_id', 0)";
    if (!$db->sql_query($sql))
    {
      message_die(GENERAL_ERROR, 'Could not insert new user-group info. Please contact the administrator', '', __LINE__, __FILE__, $sql);
    }
  }

  // Remove money penalty from character...
  $sql = "UPDATE " . USERS_TABLE . "
    SET user_points = user_points - '".$guild['guild_join_min_money']."'  
    WHERE user_id = $user_id";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not remove money penalty for Guild join',"", __LINE__, __FILE__, $sql);
  }

  // Update Guild Vault with new applicant money...
  $sql = "UPDATE " . ADR_GUILDS_TABLE . "
    SET guild_vault = guild_vault + '".$guild['guild_join_min_money']."'  
    WHERE guild_id = $guild_id";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not add money penalty to Guild in join',"", __LINE__, __FILE__, $sql);
  }

  // Send leader PM notification...
  $subject = sprintf($lang['Adr_guilds_join_pm_subject'], $character_name , $guild['guild_name']);
  $message = sprintf($lang['Adr_guilds_join_pm_msg'], $character_name , $guild['guild_name']);

  adr_send_pm($guild['guild_leader_id'], $subject, $message);

  adr_previous('Adr_guilds_join_success', 'adr_guilds', "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id);
}

function adr_guild_register_unapproved($guild, $adr_user)
{
  global $lang, $db;

  $guild_id = $guild['guild_id'];
  $user_id = $adr_user['character_id'];

  // Put character onto waiting list for approval...
  $sql = "INSERT INTO " . ADR_GUILD_MEMBER_TABLE . "
    (guild_member_guild_id , guild_member_user_id , guild_member_join_date , guild_member_auth)
    VALUES ($guild_id, $user_id, 0, " . ADR_GUILD_MEMBER_PENDING . ")";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not update Character table upon awaiting approval',"", __LINE__, __FILE__, $sql);
  }

  // Remove money penalty from character. Will put back if leader rejects application and Guild vault is not updated until then either...
  $sql = "UPDATE " . USERS_TABLE . "
    SET user_points = user_points - '".$guild['guild_join_min_money']."'  
    WHERE user_id = $user_id";
  if( !$db->sql_query($sql))
  {
    message_die(GENERAL_ERROR, 'Could not remove money penalty for Guild join and approve',"", __LINE__, __FILE__, $sql);
  }

/*
 * V: IDK how that's supposed to work, but there's no such column.
 *    I might add one later.

  // Send leader PM notification...
  $subject = sprintf($lang['Adr_guilds_join_pm_list_sub'] , $character_name , $guild['guild_name']);
  $message = sprintf($lang['Adr_guilds_join_pm_list_msg'] , $character_name);

 // Grab details from Guilds table...
 $sql = " SELECT character_guild_prefs_notify
 FROM " . ADR_CHARACTERS_TABLE . " 
 RIGHT INNER JOIN " . ADR_GUILDS_TABLE . "
 ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_leader_id";
if( !($result = $db->sql_query($sql)) )
{
  message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 1', '', __LINE__, __FILE__, $sql);
}
$character = $db->sql_fetchrow($result);

if ( $character['character_guild_prefs_notify'] )
{
  adr_send_pm ( $guild['guild_leader_id'] , $subject , $message );
}
 */

  adr_previous('Adr_guilds_join_approval', 'adr_guilds', "mode=guilds_join&amp;sub_mode=guilds_info_page&amp;guild_id=".$guild_id);
}

function adr_guild_get_character_by_rank($rank, $guild_id)
{
  global $db;

  $sql = " SELECT * FROM " . ADR_CHARACTERS_TABLE . " 
    LEFT JOIN " . ADR_GUILDS_TABLE . "
      ON " . ADR_CHARACTERS_TABLE . ".character_id = " . ADR_GUILDS_TABLE . ".guild_rank_" . intval($rank) . "_id 
    WHERE " . ADR_GUILDS_TABLE . ".guild_id = $guild_id";
  if( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not query Guild table for Rank 1', '', __LINE__, __FILE__, $sql);
  }
  $character = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  return $character;
}
