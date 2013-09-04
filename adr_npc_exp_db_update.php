<?php
/***************************************************************************
 *                               db_update.php
 *                            -------------------
 *
 *   copyright            : ©2003 Freakin' Booty ;-P & Antony Bailey
 *   project              : http://sourceforge.net/projects/dbgenerator
 *   Website              : http://freakingbooty.no-ip.com/ & http://www.rapiddr3am.net
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

define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//


if( !$userdata['session_logged_in'] )
{
	$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header($header_location . append_sid("login.$phpEx?redirect=db_update.$phpEx", true));
	exit;
}

if( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, 'You are not authorised to access this page');
}


$page_title = 'Updating the database';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

echo '<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline">';
echo '<tr><th>Updating the database</th></tr><tr><td><span class="genmed"><ul type="circle">';

( file_exists ( $phpbb_root_path . 'admin/admin_adr_manage_zone_maps.php' ) ) ? $dynamic_townmaps_installed = true : $dynamic_townmaps_installed = false ;

$sql = array();
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_characters` ADD `character_npc_visited` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_message3` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_random` int(1) NOT NULL default '0'";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_random_chance` int(7) NOT NULL default '1'";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_user_level` int(1) NOT NULL default '0'";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_class` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_race` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_character_level` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_element` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_alignment` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_visit_prerequisite` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_quest_prerequisite` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_view` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_quest_hide` int(1) NOT NULL default '0'";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_quest_clue` int(1) NOT NULL default '0'";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` ADD `npc_quest_clue_price` int(8) NOT NULL default '0'";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` CHANGE `npc_zone` `npc_zone` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` CHANGE `npc_item` `npc_item` TEXT NOT NULL";
$sql[] = "ALTER TABLE `" . $table_prefix . "adr_npc` CHANGE `npc_item2` `npc_item2` TEXT NOT NULL";
$sql[] = "UPDATE `" . $table_prefix . "adr_npc` SET `npc_class` = '0'";
$sql[] = "UPDATE `" . $table_prefix . "adr_npc` SET `npc_race` = '0'";
$sql[] = "UPDATE `" . $table_prefix . "adr_npc` SET `npc_character_level` = '0'";
$sql[] = "UPDATE `" . $table_prefix . "adr_npc` SET `npc_element` = '0'";
$sql[] = "UPDATE `" . $table_prefix . "adr_npc` SET `npc_alignment` = '0'";
$sql[] = "UPDATE `" . $table_prefix . "adr_npc` SET `npc_visit_prerequisite` = '0'";
$sql[] = "UPDATE `" . $table_prefix . "adr_npc` SET `npc_quest_prerequisite` = '0'";
$sql[] = "UPDATE `" . $table_prefix . "adr_npc` SET `npc_view` = '0'";
$sql[] = "INSERT INTO `" . $table_prefix . "adr_general` VALUES ('Adr_zone_cheat_member_pm', 2)";
$sql[] = "INSERT INTO `" . $table_prefix . "adr_general` VALUES ('npc_image_size', 75)";
$sql[] = "INSERT INTO `" . $table_prefix . "adr_general` VALUES ('npc_image_count', 10)";
if ( !$dynamic_townmaps_installed )
{
	$sql[] = "INSERT INTO `" . $table_prefix . "adr_general` VALUES ('npc_display_text', 0)";
	$sql[] = "INSERT INTO `" . $table_prefix . "adr_general` VALUES ('npc_image_link', 1)";
	$sql[] = "INSERT INTO `" . $table_prefix . "adr_general` VALUES ('npc_button_link', 0)";
}
$sql[] = "INSERT INTO `" . $table_prefix . "adr_general` VALUES ('npc_display_enable', 1)";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_adr_moderators', '')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_member_pm', '2')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_ban_adr', '0')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_ban_board', '0')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_jail', '0')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_time_day', '1')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_time_hour', '0')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_time_minute', '0')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_caution', '0')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_freeable', '0')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_cautionable', '0')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_punishment', '1')";
$sql[] = "INSERT INTO `" . $table_prefix . "config` VALUES ('zone_cheat_auto_public', '0')";
$sql[] = "CREATE TABLE `" . $table_prefix . "adr_cheat_log` (
  `cheat_id` mediumint(8) NOT NULL auto_increment,
  `cheat_ip` varchar(15) NOT NULL default '',
  `cheat_reason` varchar(50) NOT NULL default '',
  `cheat_date` int(10) NOT NULL default '0',
  `cheat_user_id` mediumint(8) NOT NULL default '0',
  `cheat_punished` varchar(255) NOT NULL default '',
  `cheat_public` int(1) NOT NULL default '0',
  PRIMARY KEY  (`cheat_id`)
) ENGINE=MyISAM";

for( $i = 0; $i < count($sql); $i++ )
{
	if( !$result = $db->sql_query ($sql[$i]) )
	{
		$error = $db->sql_error();

		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#FF0000"><b>Error:</b></font> ' . $error['message'] . '</li><br />';
	}
	else
	{
		echo '<li>' . $sql[$i] . '<br /> +++ <font color="#00AA00"><b>Successfull</b></font></li><br />';
	}
}


echo '</ul></span></td></tr><tr><td class="catBottom" height="28">&nbsp;</td></tr>';

echo '<tr><th>End</th></tr><tr><td><span class="genmed">Installation is now finished. Please be sure to delete this file now.<br />If you have run into any errors, please visit the <a href="http://www.phpbbsupport.co.uk" target="_phpbbsupport">phpBBSupport.co.uk</a> and ask someone for help.</span></td></tr>';
echo '<tr><td class="catBottom" height="28" align="center"><span class="genmed"><a href="' . append_sid("index.$phpEx") . '">Have a nice day</a></span></td></table>';

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
