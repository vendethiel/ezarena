<?php
/***************************************************************************
 *                          admin_rabbitoshi_owners.php
 *                              -------------------
 *     begin                : Thurs June 9 2006
 *     copyright            : (C) 2006 The ADR Dev Crew
 *     site                 : http://www.adr-support.com
 *
 *     $Id: admin_rabbitoshi_owners.php,v 4.00.0.00 2006/06/09 02:32:18 Ethalic Exp $
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

define('IN_PHPBB', true);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Rabbitoshi']['Rabbitoshi_owners'] = $file;
	return;
}

$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require("./pagestart.$phpEx");
include($phpbb_root_path.'rabbitoshi/includes/functions_rabbitoshi.'.$phpEx);
if ( defined('PRIVMSGA_TABLE'))
{
	include($phpbb_root_path . 'includes/functions_messages.'.$phpEx);
}

rabbitoshi_template_file('admin/config_rabbitoshi_owners_body.tpl');

$submit = isset($HTTP_POST_VARS['submit']); 
$update = isset($HTTP_POST_VARS['update']); 

$sql = "SELECT u.user_id , u.username
	FROM " . USERS_TABLE . " u , ". RABBITOSHI_USERS_TABLE . " ru
	WHERE u.user_id = ru.owner_id
	ORDER by u.username";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain group list', '', __LINE__, __FILE__, $sql);
}
$select_list = '';
if ( $row = $db->sql_fetchrow($result) )
{
	$select_list .= '<select name="owner_id">';
	do
	{
		$select_list .= '<option value="' . $row['user_id'] . '">' . $row['username'] . '</option>';
	}
	while ( $row = $db->sql_fetchrow($result) );
	$select_list .= '</select>';
}

if ( !empty($HTTP_POST_VARS['owner_id']))
{
	$owner_id = $HTTP_POST_VARS['owner_id'];
}
else
{
	$owner_id = 2;
}

if( $submit )
{
	$pet_owner_id = ( !empty($HTTP_POST_VARS['pet_owner_id']) ) ? $HTTP_POST_VARS['pet_owner_id'] : $HTTP_GET_VARS['pet_owner_id'];
	$pet_name = $HTTP_POST_VARS['pet_name'];
	$level = intval( $HTTP_POST_VARS['level'] );
	$power = intval( $HTTP_POST_VARS['power'] );
	$magicpower = intval( $HTTP_POST_VARS['magicpower'] );
	$armor = intval( $HTTP_POST_VARS['armor'] );
	$experience = intval( $HTTP_POST_VARS['experience'] );
	$mp = intval( $HTTP_POST_VARS['mp'] );
	$mpmax = intval( $HTTP_POST_VARS['mpmax'] );
	$attack = intval( $HTTP_POST_VARS['attack'] );
	$attackmax = intval( $HTTP_POST_VARS['attackmax'] );
	$magicattack = intval( $HTTP_POST_VARS['magicattack'] );
	$magicattackmax = intval( $HTTP_POST_VARS['magicattackmax'] );
	$health = intval( $HTTP_POST_VARS['health'] );
	$hunger = intval( $HTTP_POST_VARS['hunger'] );
	$thirst = intval( $HTTP_POST_VARS['thirst'] );
	$hygiene = intval( $HTTP_POST_VARS['hygiene'] );
	$healthmax = intval( $HTTP_POST_VARS['healthmax'] );
	$hungermax = intval( $HTTP_POST_VARS['hungermax'] );
	$thirstmax = intval( $HTTP_POST_VARS['thirstmax'] );
	$hygienemax = intval( $HTTP_POST_VARS['hygienemax'] );
	$notify = intval($HTTP_POST_VARS['notify']);	
	$hide = intval($HTTP_POST_VARS['hide']);	
	$feed_full = intval($HTTP_POST_VARS['feed_full']);	
	$drink_full = intval($HTTP_POST_VARS['drink_full']);	
	$clean_full= intval($HTTP_POST_VARS['clean_full']);

	$sql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
		SET owner_creature_name = '$pet_name' ,
		creature_level = $level ,
		creature_power = $power ,
		creature_magicpower = $magicpower ,
		creature_armor = $armor ,
		creature_experience = $experience ,
		creature_mp = $mp ,
		creature_max_mp = $mpmax ,
		creature_attack = $attack ,
		creature_attack_max = $attackmax ,
		creature_magicattack = $magicattack ,
		creature_magicattack_max = $magicattackmax ,
		creature_health = $health ,
		creature_hunger = $hunger ,
		creature_thirst = $thirst ,
		creature_hygiene = $hygiene ,
		creature_health_max = $healthmax ,
		creature_hunger_max = $hungermax ,
		creature_thirst_max = $thirstmax ,
		creature_hygiene_max = $hygienemax ,
		owner_notification = $notify ,
		owner_feed_full = $feed_full,
		owner_drink_full = $drink_full,
		owner_clean_full = $clean_full,
		owner_hide = $hide
		WHERE owner_id = $pet_owner_id";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update rabbiotoshi user's table", '', __LINE__, __FILE__, $sql);
	}
	else
	{
		message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_admin_ok'].$lang['Rabbitoshi_admin_general_return']);
	}

}
else if ( $update )
{
	$sql = "SELECT * FROM  " . RABBITOSHI_GENERAL_TABLE ; 
	if (!$result = $db->sql_query($sql)) 
	{
		message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
	}
	while( $row = $db->sql_fetchrow($result) )
	{
		$rabbit_general[$row['config_name']] = $row['config_value'];
	}
	$rsql = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE ; 
	if (!$rresult = $db->sql_query($rsql)) 
	{
		message_die(CRITICAL_ERROR, 'Error Getting users Config!');
	}
	$rrow = $db->sql_fetchrowset($rresult);

	for ( $i = 0 ; $i < count ( $rrow ) ; $i ++)
	{
		$rabbit_user = rabbitoshi_get_user_stats($rrow[$i]['owner_id'] );
		$message = '';
		$pet_dead = FALSE;
		$thought = '';
		$status = 0;

		$hotel_time = $rabbit_user['creature_hotel'] - time() ;
		if ( $hotel_time > 0 )
		{
			$is_in_hotel = TRUE ;
		}
		else
		{
			$is_in_hotel = FALSE ;
		}

		$visit_time = time() - $rabbit_user['owner_last_visit'];
		$hunger_time = floor( $visit_time / $rabbit_general['hunger_time']);
		$hunger_less = ($hunger_time * $rabbit_general['hunger_value']);
		$thirst_time = floor( $visit_time / $rabbit_general['thirst_time']);
		$thirst_less = ($thirst_time * $rabbit_general['thirst_value']);
		$hygiene_time = floor( $visit_time / $rabbit_general['hygiene_time']);
		$hygiene_less =($hygiene_time * $rabbit_general['hygiene_value']);
		$health_time = floor( $visit_time / $rabbit_general['health_time']);
		$health_less = ( $health_time * $rabbit_general['health_value'] ) + floor ( ( $hunger_less + $hygiene_less + $thirst_less ) / 3 );

		if ( !$is_in_hotel )
		{
			$usql = "UPDATE " . RABBITOSHI_USERS_TABLE . "
			SET creature_hunger = creature_hunger - $hunger_less ,
			creature_thirst = creature_thirst - $thirst_less ,
			creature_health = creature_health - $health_less ,
			creature_hygiene = creature_hygiene - $hygiene_less ,
			owner_last_visit = ".time()."
			WHERE owner_id = ".$rrow[$i]['owner_id'];
			if (!$db->sql_query($usql))
			{
				message_die(GENERAL_ERROR, '', __LINE__, __FILE__, $usql);
			}
		}

		$rabbit_stats = get_rabbitoshi_config($rabbit_user['owner_creature_id'] );
		$time = time() - $rabbit_user['creature_age'];
		$hunger_status = floor (( $rabbit_user['creature_hunger'] / $rabbit_stats['creature_max_hunger'] ) *100);
		$thirst_status = floor (( $rabbit_user['creature_thirst'] / $rabbit_stats['creature_max_thirst'] ) *100);
		$health_status = floor (( $rabbit_user['creature_health'] / $rabbit_stats['creature_max_health'] ) *100);
		$hygiene_status = floor (( $rabbit_user['creature_hygiene'] / $rabbit_stats['creature_max_hygiene'] ) *100);
		$status = 0;

		if ( $hunger_status < 0 || $rabbit_user['creature_hunger'] == '0')
		{
			$pet_dead = true;	
		}
		else if ( $hunger_status < 25 )
		{
			$message .= $lang['Rabbitoshi_message_very_hungry'].'<br />';
		}
		else if ( $hunger_status < 50 )
		{
			$message .= $lang['Rabbitoshi_message_hungry'].'<br />';
		}
		else
		{
			$status = $status +1 ;
		}
		if ( $thirst_status < 0 || $rabbit_user['creature_thirst'] == '0')
		{
			$pet_dead = true;	
		}
		else if ( $thirst_status < 25 )
		{
			$message .= $lang['Rabbitoshi_message_very_thirst'].'<br />';
		}
		else if ( $thirst_status < 50 )
		{
			$message .= $lang['Rabbitoshi_message_thirst'].'<br />';
		}
		else
		{
			$status = $status +1 ;
		}
		if ( $health_status < 0 || $rabbit_user['creature_health'] == '0')
		{
			$pet_dead = true;	
		}
		else if ( $health_status < 25 )
		{
			$message .= $lang['Rabbitoshi_message_very_health'].'<br />';
		}	
		else if ( $health_status < 50 )
		{
			$message .= $lang['Rabbitoshi_message_health'].'<br />';
		}
		else
		{
			$status = $status +1 ;
		}
		if ( $hygiene_status < 0 || $rabbit_user['creature_hygiene'] == '0')
		{
			$pet_dead = true;	
		}
		else if ( $hygiene_status < 25 )
		{
			$message .= $lang['Rabbitoshi_message_very_hygiene'].'<br />';
		}
		else if ( $hygiene_status < 50 )
		{
			$message .= $lang['Rabbitoshi_message_hygiene'].'<br />';
		}
		else
		{
			$status = $status +1 ;
		}
		if ( $status =='0' )
		{
			$thought = $lang['Rabbitoshi_general_message_very_bad'];
		}
		else if ( $status =='1' )
		{
			$thought = $lang['Rabbitoshi_general_message_bad'];
		}
		else if ( $status =='2' )
		{
			$thought = $lang['Rabbitoshi_general_message_neutral'];
		}
		else if ( $status =='3' )
		{
			$thought = $lang['Rabbitoshi_general_message_good'];
		}
		else
		{
			$thought = $lang['Rabbitoshi_general_message_very_good'];
		}

		$pm_comment = '<font color=red>'.$lang['Rabbitoshi_pm_news'].'</font><br /><br />';

		if ( $pet_dead )
		{
			$pm_comment .= $lang['Rabbitoshi_pet_is_dead'];

			$sql = "DELETE FROM " . RABBITOSHI_USERS_TABLE . "
			WHERE owner_id = " . $rabbit_user['owner_id'];
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete pet", "", __LINE__, __FILE__, $sql);
			}
			$sql = "DELETE FROM " . RABBITOSHI_SHOP_USERS_TABLE . "
			WHERE user_id = " . $rabbit_user['owner_id'];
			$result = $db->sql_query($sql);
			if( !$result )
			{
				message_die(GENERAL_ERROR, "Couldn't delete pet", "", __LINE__, __FILE__, $sql);
			}
		}
		else if ( $is_in_hotel )
		{
			$pm_comment .= $lang['Rabbitoshi_pm_news_hotel'];
		}
		else
		{
			$pm_comment .= '<b>'.$lang['Rabbitoshi_general_message'].'</b>'.'<br />'.$thought.'<br /><br />';
			$pm_comment .= '<b>'.$lang['Rabbitoshi_message'].'</b>'.'<br />'.$message.'<br /><br />';
		}

		if ( $rrow[$i]['owner_notification'] )
		{
			$user_id = $rrow[$i]['owner_id']; 
	
			$new_comment_subject = $lang['Rabbitoshi_pm_news'];
			$new_comment = $pm_comment;
			$comment_date = date("U"); 

			if ( defined('PRIVMSGA_TABLE'))
			{
				$new_comment = $lang['Rabbitoshi_APM_pm'];
				send_pm( 0 , '' , $user_id , $new_comment_subject, $new_comment, '' );
			}
			else
			{
				$sql = "UPDATE " . USERS_TABLE . " 
					SET user_new_privmsg = user_new_privmsg + 1 , user_last_privmsg = '9999999999' 
					WHERE user_id = " . $rrow[$i]['owner_id']; 
				if ( !($result = $db->sql_query($sql)) ) 
				{ 
					message_die(GENERAL_ERROR, 'Could not update users table', '', __LINE__, __FILE__, $sql); 
				} 
				$sql = "INSERT INTO " . PRIVMSGS_TABLE . " (privmsgs_type, privmsgs_subject, privmsgs_from_userid, privmsgs_to_userid, privmsgs_date, privmsgs_enable_html, privmsgs_enable_bbcode, privmsgs_enable_smilies, privmsgs_attach_sig) VALUES ('" . PRIVMSGS_NEW_MAIL . "', '" . str_replace("\'", "''", addslashes(sprintf($new_comment_subject))) . "', '2', '" . $user_id . "', '" . $comment_date . "', '0', '1', '1', '0')"; 
				if ( !$db->sql_query($sql) ) 
				{ 
					message_die(GENERAL_ERROR, 'Could not insert private message sent info', '', __LINE__, __FILE__, $sql); 
				} 
				$privmsg_sent_id = $db->sql_nextid(); 
				$privmsgs_text = $new_comment; 

				$sql = "INSERT INTO " . PRIVMSGS_TEXT_TABLE . " (privmsgs_text_id, privmsgs_text) VALUES ($privmsg_sent_id, '" . str_replace("\'", "''", addslashes(sprintf($privmsgs_text))) . "')"; 
				if ( !$db->sql_query($sql) ) 
				{ 
					message_die(GENERAL_ERROR, 'Could not insert private message sent text', '', __LINE__, __FILE__, $sql); 
				}
			}
		}

	}

	$new_time = $board_config['rabbitoshi_cron_last_time'] +  $board_config['rabbitoshi_cron_time'];

	$lsql= "UPDATE ". CONFIG_TABLE . " SET config_value = $new_time WHERE config_name = 'rabbitoshi_cron_last_time' ";
	if ( !($lresult = $db->sql_query($lsql)) ) 
	{ 
		message_die(GENERAL_ERROR, 'Error updating config' , "", __LINE__, __FILE__, $lsql); 
	} 
	message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_admin_cron_ok'].$lang['Rabbitoshi_admin_general_return']);
}
else
{	
	$sql = "SELECT ru.* , u.username , u.user_id , c.* FROM " . RABBITOSHI_USERS_TABLE . " ru , " . USERS_TABLE . " u , " . RABBITOSHI_CONFIG_TABLE . " c
		WHERE ru.owner_id = $owner_id
		AND ru.owner_id = u.user_id
		AND ru.owner_creature_id = c.creature_id";
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain rabbitoshi owners data", "", __LINE__, __FILE__, $sql);
	}
	$rabbit_owner = $db->sql_fetchrow($result);

	$sql = "SELECT * FROM " . RABBITOSHI_SHOP_TABLE ;
	if( !$result = $db->sql_query($sql) )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain rabbitoshi owners items data", "", __LINE__, __FILE__, $sql);
	}
	$rabbit_items = $db->sql_fetchrowset($result);	
}
$pet_type = isset($lang[$rabbit_owner['creature_name']]) ? $lang[$rabbit_owner['creature_name']] : $rabbit_owner['creature_name'];

$template->assign_vars(array(
	"OWNER" => $rabbit_owner['username'],
	"OWNER_PET" => $rabbit_owner['owner_creature_name'],
	"PET_TYPE" => $pet_type,
	"OWNER_PET_LEVEL" => $rabbit_owner['creature_level'],
	"OWNER_PET_POWER" => $rabbit_owner['creature_power'],
	"OWNER_PET_MAGICPOWER" => $rabbit_owner['creature_magicpower'],
	"OWNER_PET_ARMOR" => $rabbit_owner['creature_armor'],
	"OWNER_PET_EXPERIENCE" => $rabbit_owner['creature_experience'],
	"OWNER_PET_ATTACK" => $rabbit_owner['creature_attack'],
	"OWNER_PET_ATTACKMAX" => $rabbit_owner['creature_attack_max'],
	"OWNER_PET_MP" => $rabbit_owner['creature_mp'],
	"OWNER_PET_MPMAX" => $rabbit_owner['creature_max_mp'],
	"OWNER_PET_MAGICATTACK" => $rabbit_owner['creature_magicattack'],
	"OWNER_PET_MAGICATTACKMAX" => $rabbit_owner['creature_magicattack_max'],
	"OWNER_PET_HEALTH" => $rabbit_owner['creature_health'],
	"OWNER_PET_HUNGER" => $rabbit_owner['creature_hunger'],
	"OWNER_PET_THIRST" => $rabbit_owner['creature_thirst'],
	"OWNER_PET_HYGIENE" => $rabbit_owner['creature_hygiene'],
	"OWNER_PET_HEALTHMAX" => $rabbit_owner['creature_health_max'],
	"OWNER_PET_HUNGERMAX" => $rabbit_owner['creature_hunger_max'],
	"OWNER_PET_THIRSTMAX" => $rabbit_owner['creature_thirst_max'],
	"OWNER_PET_HYGIENEMAX" => $rabbit_owner['creature_hygiene_max'],
	"RABBITOSHI_PREFERENCES_NOTIFY_CHECKED" => ( $rabbit_owner['owner_notification'] ? 'CHECKED' : ''),
	"RABBITOSHI_PREFERENCES_HIDE_CHECKED" => ( $rabbit_owner['owner_hide'] ? 'CHECKED' : ''),
	"RABBITOSHI_PREFERENCES_FEED_FULL_CHECKED" => ( $rabbit_owner['owner_feed_full'] ? 'CHECKED' : ''),
	"RABBITOSHI_PREFERENCES_DRINK_FULL_CHECKED" => ( $rabbit_owner['owner_drink_full'] ? 'CHECKED' : ''),
	"RABBITOSHI_PREFERENCES_CLEAN_FULL_CHECKED" => ( $rabbit_owner['owner_clean_full'] ? 'CHECKED' : ''),

	"L_RABBITOSHI_TITLE" => $lang['Rabbitoshi_owner_admin_title'],
	"L_RABBITOSHI_TEXT" => $lang['Rabbitoshi_owner_admin_title_explain'],
	"L_SUBMIT" => $lang['Rabbitoshi_owner_admin_submit'],
	"L_SELECT" => $lang['Rabbitoshi_owner_admin_select_submit'],
	"L_SELECT_OWNER" => $lang['Rabbitoshi_owner_admin_select'],
	"L_OWNER" => $lang['Rabbitoshi_owner'],
	"L_OWNER_PET" => $lang['Rabbitoshi_owner_pet'],
	"L_PET_TYPE" => $lang['Rabbitoshi_owner_pet_type'],
	"L_OWNER_PET_HEALTH" => $lang['Rabbitoshi_owner_pet_health'],
	"L_OWNER_PET_LEVEL" => $lang['Rabbitoshi_owner_pet_level'],
	"L_OWNER_PET_POWER" => $lang['Rabbitoshi_owner_pet_power'],
	"L_OWNER_PET_MAGICPOWER" => $lang['Rabbitoshi_owner_pet_magicpower'],
	"L_OWNER_PET_ARMOR" => $lang['Rabbitoshi_owner_pet_armor'],
	"L_OWNER_PET_EXPERIENCE" => $lang['Rabbitoshi_owner_pet_experience'],
	"L_OWNER_PET_ATTACK" => $lang['Rabbitoshi_owner_pet_attack'],
	"L_OWNER_PET_MAGICATTACK" => $lang['Rabbitoshi_owner_pet_magicattack'],
	"L_OWNER_PET_HUNGER" => $lang['Rabbitoshi_owner_pet_hunger'],
	"L_OWNER_PET_THIRST" => $lang['Rabbitoshi_owner_pet_thirst'],
	"L_OWNER_PET_HYGIENE" => $lang['Rabbitoshi_owner_pet_hygiene'],
	"L_OWNER_PET_MP" => $lang['Rabbitoshi_owner_pet_mp'],
	"L_RABBITOSHI_PREFERENCES_NOTIFY" => $lang['Rabbitoshi_preferences_notify'],
	"L_RABBITOSHI_PREFERENCES_HIDE" => $lang['Rabbitoshi_preferences_hide'],
	"L_RABBITOSHI_PREFERENCES_FEED_FULL" => $lang['Rabbitoshi_preferences_feed_full'],
	"L_RABBITOSHI_PREFERENCES_FEED_FULL_EXPLAIN" => $lang['Rabbitoshi_preferences_feed_full_explain'],
	"L_RABBITOSHI_PREFERENCES_DRINK_FULL" => $lang['Rabbitoshi_preferences_drink_full'],
	"L_RABBITOSHI_PREFERENCES_DRINK_FULL_EXPLAIN" => $lang['Rabbitoshi_preferences_drink_full_explain'],
	"L_RABBITOSHI_PREFERENCES_CLEAN_FULL" => $lang['Rabbitoshi_preferences_clean_full'],
	"L_RABBITOSHI_PREFERENCES_CLEAN_FULL_EXPLAIN" => $lang['Rabbitoshi_preferences_clean_full_explain'],
	"L_MANUAL_UPDATE_EXPLAIN" => $lang['Rabbitoshi_cron_admin_update_explain'],
	"L_MANUAL_UPDATE" => $lang['Rabbitoshi_cron_admin_update'],

	"S_SELECT_OWNER" => $select_list,
	"S_RABBITOSHI_ACTION" => append_sid("admin_rabbitoshi_owners.$phpEx?pet_owner_id=".$rabbit_owner['user_id']),
));


$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>