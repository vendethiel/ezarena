<?php
/***************************************************************************
 *                              adr_header.php
 *                            -------------------
 *   begin                : 09/03/2005
 *   copyright            : one_piece
 *   site                 : http://mangas-no-ushi.com/
 *
 *
 *
 ***************************************************************************//***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
if ( !defined('IN_PHPBB') )
	die('Hacking attempt');
// Includes the tpl
$template->assign_var('OUT_OF_ZONES', true);
adr_advanced_template_file('adr_header_body.tpl', 'header');
// Job check
adr_job_salary_check( $userdata['user_id'] );
// Just because this may be if use for furthers versions
// $template->assign_block_vars('header',array());
// Display message to admin if RPG is currently disabled while viewing
if(!$adr_general['Adr_disable_rpg'])
	echo('<br><center><b>'.$lang['Adr_disabled_admin_msg1'].':</b> <i>'.$lang['Adr_disabled_admin_msg2'].'</i></center>');

// V: character replen (every 15 minutes)
if (empty($adr_general['last_character_replen']) || time() < $adr_general['last_character_replen'] + (15 * 60)) {
	adr_character_replen_quota();
	adr_update_general_config();
}

// Includes the tpl
$adr_user = adr_get_user_infos($userdata['user_id']);
// Get Zone infos
$area_id = $adr_user['character_area'];
$actual_season = $board_config['adr_seasons'];
$actual_time = $board_config['adr_time'];
$zone = zone_get($area_id);
$zone_shops = $zone['zone_shops'];
$zone_forge = $zone['zone_forge'];
$zone_mine = $zone['zone_mine'];
$zone_enchant = $zone['zone_enchant'];
$zone_temple = $zone['zone_temple'];
$zone_prison = $zone['zone_prison'];
$zone_bank = $zone['zone_bank'];

// Building images
( $zone_temple == '1' ) ? $temple = 'temple_enable' : $temple = 'temple_disable';
( $zone_prison == '1' ) ? $prison = 'prison_enable' : $prison = 'prison_disable';
( $zone_shops == '1' ) ? $shops = 'shops_enable' : $shops = 'shops_disable';
( $zone_forge == '1' ) ? $forge = 'forge_enable' : $forge = 'forge_disable';
( $zone_mine == '1' ) ? $mine = 'mine_enable' : $mine = 'mine_disable';
( $zone_enchant == '1' ) ? $enchant = 'enchant_enable' : $enchant = 'enchant_disable';
( $zone_bank == '1' ) ? $bank = 'bank_enable' : $bank = 'bank_disable';

// Building links
if ( $board_config['Adr_zone_picture_link'] )
{
	$picture_link = 1;
	$temple_link = ( $zone_temple == '1' ) ? '<a href="'.append_sid("adr_temple.$phpEx").'">' : '';
	$prison_link = ( $zone_prison == '1' ) ? '<a href="'.append_sid("adr_courthouse.$phpEx").'">' : '';
	$shops_link = ( $zone_shops == '1' ) ? '<a href="'.append_sid("adr_shops.$phpEx").'">' : '';
	$forge_link = ( $zone_forge == '1' ) ? '<a href="'.append_sid("adr_forge.$phpEx").'">' : '';
	$bank_link = ( $zone_bank == '1' ) ? '<a href="'.append_sid("adr_vault.$phpEx").'">' : '';
	$enchant_link = ( $zone_enchant == '1' ) ? '<a href="'.append_sid("adr_enchant.$phpEx").'">' : '';
	$mine_link = ( $zone_mine == '1' ) ? '<a href="'.append_sid("adr_mine.$phpEx").'">' : '';
}
else
{
	$picture_link = 0;
	( $zone_temple == '1' ) ? $temple_link = '<a href="'.append_sid("adr_temple.$phpEx").'">'. $lang['Adr_zone_goto_temple'] .'</a>' : $temple_link = $lang['Adr_zone_building_disable'];
	( $zone_prison == '1' ) ? $prison_link = '<a href="'.append_sid("adr_courthouse.$phpEx").'">'. $lang['Adr_zone_goto_prison'] .'</a>' : $prison_link = $lang['Adr_zone_building_disable'];
	( $zone_shops == '1' ) ? $shops_link = '<a href="'.append_sid("adr_shops.$phpEx").'">'. $lang['Adr_zone_goto_shops'] .'</a>' : $shops_link = $lang['Adr_zone_building_disable'];
	( $zone_forge == '1' ) ? $forge_link = '<a href="'.append_sid("adr_forge.$phpEx").'">'. $lang['Adr_zone_goto_forge'] .'</a>' : $forge_link = $lang['Adr_zone_building_disable'];
	( $zone_bank == '1' ) ? $bank_link = '<a href="'.append_sid("adr_vault.$phpEx").'">'. $lang['Adr_zone_goto_bank'] .'</a>' : $bank_link = $lang['Adr_zone_building_disable'];
	( $zone_enchant == '1' ) ? $enchant_link = '<a href="'.append_sid("adr_enchant.$phpEx").'">'. $lang['Adr_zone_goto_enchant'] .'</a>' : $enchant_link = $lang['Adr_zone_building_disable'];
	( $zone_mine == '1' ) ? $mine_link = '<a href="'.append_sid("adr_mine.$phpEx").'">'. $lang['Adr_zone_goto_mine'] .'</a>' : $mine_link = $lang['Adr_zone_building_disable'];
}

if ( ( $zone_temple == '1' || $zone_prison == '1' || $zone_shops == '1' || $zone_forge == '1' || $zone_bank =='1' || $zone_enchant == '1' || $zone_mine = '1' ) && $picture_link )
{
	$template->assign_block_vars('switch_header_picture_link_enable',array());
}
else if ( ( $zone_temple == '1' || $zone_prison == '1' || $zone_shops == '1' || $zone_forge == '1' || $zone_bank =='1' || $zone_enchant == '1' || $zone_mine = '1' ) && !$picture_link )
{
	$template->assign_block_vars('switch_header_no_picture_link_enable',array());
}

$template->assign_vars(array(
	// V: idk
	//'ADR_YEAR' => $timezone_info[0],
	//'ADR_MONTH' => $timezone_info[1],
	//'ADR_DAY' => $timezone_info[2],
	//'ADR_HOUR' => $timezone_info[3],
	'L_YEAR' => $lang['year'],
	'L_MONTH' => $lang['month'],
	'L_DAY' => $lang['day'],
	'L_HOUR' => $lang['hour'],
	'ZONE_SEASON' => $actual_season,
	'ZONE_TIME' => $actual_time,
	'H_SHOPS_IMG' => $shops,
	'H_TEMPLE_IMG' => $temple,
	'H_FORGE_IMG' => $forge,
	'H_MINE_IMG' => $mine,
	'H_ENCHANT_IMG' => $enchant,
	'H_BANK_IMG' => $bank,
	'H_PRISON_IMG' => $prison,
	'SHOPS_LINK' => $shops_link,
	'TEMPLE_LINK' => $temple_link,
	'FORGE_LINK' => $forge_link,
	'MINE_LINK' => $mine_link,
	'ENCHANT_LINK' => $enchant_link,
	'BANK_LINK' => $bank_link,
	'PRISON_LINK' => $prison_link,
	'ZONE_RETURN' => $lang['Adr_zone_header_return'],
	'L_COPYRIGHT' => $lang['Adr_copyright'],
	'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
));
$template->pparse('header');
