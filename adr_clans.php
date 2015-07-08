<?php
/***************************************************************************
 *
 *   Copyright (C) 2004  Guido Kessels (aka Nuladion)
 *
 *   This program is free software; you can redistribute it and/or
 *   modify it under the terms of the GNU General Public License
 *   as published by the Free Software Foundation; either version 2
 *   of the License, or (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   http://www.gnu.org/copyleft/gpl.html
 *
 ***************************************************************************/

// phpBB stuff
define('IN_PHPBB', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_SHOPS', true);

$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.' . $phpEx);
include_once($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_clans';

$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

// Pagination Data [START]
$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0; 
$pagination = '&'; 
$total_pag_items = 1;
// Pagination Data [END]

// Set filename
$file = 'adr_clans.php';
$shoutbox = false;

//
// Start MOD Code
//

// V: fix a few warnings
if (empty($_GET['action']))
	$_GET['action'] = null;

$user_id = $userdata['user_id']; // Get users' id
$points_name = get_reward_name(); // Get points name
$adr_user = adr_get_user_infos($user_id); //Grab character details

// Sorry , only logged users ...
if(!$userdata['session_logged_in'])
{
	$redirect = "adr_clans.$phpEx";
	$redirect .= (isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Get the general settings
$adr_general = adr_get_general_config();
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

$actual_zone = $adr_user['character_area'];

$info = zone_get($actual_zone);
//V: let's say you always have access to the clans page, wherever you are
//$access = $info['zone_clans'];

//if ( $access == '0' )
//	adr_previous( Adr_zone_building_noaccess , adr_zones , '' );

// Clan list
if((!isset($_GET['action'])) || ($_GET['action'] == "list")) {
	$this_title = $lang['clans_title_clanslist'];

	// Get clans user belongs to!
	$sql = "SELECT * FROM ". ADR_CLANS_TABLE ."
			WHERE leader = '".$user_id."' OR members LIKE '%ß".$user_id."Þ%' OR approvelist LIKE '%ß".$user_id."Þ%'
			ORDER BY name,id";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql); } 

	if(($db->sql_numrows($result)) < 1) {
		$template->assign_block_vars('no_userclans', array(
			'L_NONE' => $lang['clans_none']
		));
	}

	if ( $row = $db->sql_fetchrow($result) ) 
	{ 
		// Get leader name!
		$Lrow = adr_get_user_infos($row['leader']);
  		$leader = '<a href="'.$phpbb_root_path.'adr_character.php?' . POST_USERS_URL .'='.$row['leader'].'" target="_blank">'.$Lrow['character_name'].'</a>';
		
		// Get member names!
		$members = '';
		if($row['members'] == '') {
			$members = $lang['clans_none'];
		} else {
			$allmembers = str_replace("ß", "", $row['members']);
			$newmembers = explode("Þ",$allmembers);
			$count = count($newmembers);

			for($x=0;$x<$count;$x++) {
				$Usql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ."
						WHERE character_id = '".$newmembers[$x]."' ";
				if ( !($Uresult = $db->sql_query($Usql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Usql); } 
				while ( $Urow = $db->sql_fetchrow($Uresult) ) { 
					if($members == '') {
						$members .= '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$newmembers[$x].'" target="_blank">'.$Urow['character_name'].'</a>';
					} else {
						$members .= ', <a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$newmembers[$x].'" target="_blank">'.$Urow['character_name'].'</a>';
					}
				}
			}
		}

		// Check if the user has joined this clan or is in their approve list. Change the button's text and action accordingly
		$leavebuttontext = $lang['clans_leave'];
		$leaveaction = 'leave';
		if ((substr_count($row['members'],"ß".$user_id."Þ") < 1) && (substr_count($row['approvelist'],"ß".$user_id."Þ") > 0)){
			$leavebuttontext = $lang['clans_leave_list'];
			$leaveaction = 'leavelist';
		}

		$template->assign_block_vars('userclans', array(
			'FILE' => $file,
			'NAME' => $row['name'],
			'LEADER' => $leader,
			'ID' => $row['id'],
			'MEMBERS' => $members,
			'L_LEAVE' => $leavebuttontext,
			'ACTION' => $leaveaction
		));
	}

	// Get clans user doesn't belong to!
	$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ."
			WHERE leader != '".$user_id."' AND members NOT LIKE '%ß".$user_id."Þ%' AND approvelist NOT LIKE '%ß".$user_id."Þ%'
			ORDER BY name,id";
	if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 

	if(($db->sql_numrows($result2)) < 1) {
		$template->assign_block_vars('no_allclans', array(
			'L_NONE' => $lang['clans_none']
		));
	}

	while ( $row2 = $db->sql_fetchrow($result2) ) 
	{ 
		// Get leader name!
		$Lsql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ."
				WHERE character_id = '".$row2['leader']."' ";
		if ( !($Lresult = $db->sql_query($Lsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Lsql); } 
		while ( $Lrow = $db->sql_fetchrow($Lresult) ) { $leader = '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$row2['leader'].'" target="_blank">'.$Lrow['character_name'].'</a>'; }

		// Get member names!
		$members = '';
		if($row2['members'] == '') {
			$members = $lang['clans_none'];
		} else {
			$allmembers = str_replace("ß", "", $row2['members']);
			$newmembers = explode("Þ",$allmembers);
			$count = count($newmembers);

			for($x=0;$x<$count;$x++)
			{
				$Usql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ."
						WHERE character_id = '".$newmembers[$x]."' ";
				if ( !($Uresult = $db->sql_query($Usql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Usql); } 
				while ( $Urow = $db->sql_fetchrow($Uresult) ) { 
					if($members == '') {
						$members .= '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$newmembers[$x].'" target="_blank">'.$Urow['character_name'].'</a>';
					} else {
						$members .= ', <a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$newmembers[$x].'" target="_blank">'.$Urow['character_name'].'</a>';
					}
				}
			}
		}

		$template->assign_block_vars('allclans', array(
			'FILE' => $file,
			'NAME' => $row2['name'],
			'LEADER' => $leader,
			'ID' => $row2['id'],
			'MEMBERS' => $members,
			'L_JOIN' => $lang['clans_join']
		));
	}

//	$template->set_filenames(array('body' => 'adr_clans_list_body.tpl'));
    adr_template_file('adr_clans_list_body.tpl');

	$template->assign_vars(array( 
		'L_NAME' => $lang['clans_name'],
		'L_LEADER' => $lang['clans_leader'],
		'L_MEMBERS' => $lang['clans_members'],
		'L_LEAVE' => $lang['clans_leave'],
		'L_JOIN' => $lang['clans_join'],
		'L_CREATE_NEW' => $lang['clans_createnew'],
		'L_JOINED' => $lang['clans_joined'],
		'L_ALLCLANS' => $lang['clans_allclans'],
		'FILE' => $file,
		'TABLEROWS' => 4
	));
}

// Clan page
if($_GET['action'] ==  "clanpage") {

	if(!isset($_GET['clan'])) {
		{ message_die(GENERAL_ERROR, $lang['clans_none_selected']); }
	}

	// Get clan info!
	$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ."
			WHERE id = '".intval($_GET['clan'])."' ";
	if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 
	while ( $row2 = $db->sql_fetchrow($result2) ) 
	{ 
		// Get leader name!
		$Lsql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ."
				WHERE character_id = '".$row2['leader']."' ";
		if ( !($Lresult = $db->sql_query($Lsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Lsql); } 
		while ( $Lrow = $db->sql_fetchrow($Lresult) ) { $leader = '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$row2['leader'].'" target="_blank">'.$Lrow['character_name'].'</a>'; }

		// Get member names!
		$members = '';
		if($row2['members'] == '') {
			$members = $lang['clans_none'];
		} else {
			$allmembers = str_replace("ß", "", $row2['members']);
			$newmembers = explode("Þ",$allmembers);
			$count = count($newmembers);

			for($x=0;$x<$count;$x++) {
				$Usql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ."
						WHERE character_id = '".$newmembers[$x]."' ";
				if ( !($Uresult = $db->sql_query($Usql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Usql); } 
				while ( $Urow = $db->sql_fetchrow($Uresult) ) { 
					if($members == '') {
						$members .= '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$newmembers[$x].'" target="_blank">'.$Urow['character_name'].'</a>';
					} else {
						$members .= ', <a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$newmembers[$x].'" target="_blank">'.$Urow['character_name'].'</a>';
					}
				}
			}
		}

		// Get news amount and order!
		$news_amount = $row2['news_amount'];
		if($row2['news_order'] == 0) { $news_order = 'DESC'; } else { $news_order = 'ASC'; }
		$news_orderby = $row2['news_orderby'];

		// Get requirements + join fee!
		if($row2['req_posts'] == '0') { $req_posts = $lang['clans_none']; } else { $req_posts = $row2['req_posts']; }
		if($row2['req_points'] == '0') { $req_points = $lang['clans_none']; } else { $req_points = $row2['req_points'].' '.$points_name; }
		if($row2['req_level'] == '0') { $req_level = $lang['clans_none']; } else { $req_level = $row2['req_level']; }
		if($row2['join_fee'] == '0') { $join_fee = $lang['clans_none']; } else { $join_fee = $row2['join_fee'].' '.$points_name; }

		// Get approve settings + approve list!
		if($row2['approving'] == '0') { $approving = $lang['clans_disabled']; $approvelist = $lang['clans_empty']; } else {
			$approving = $lang['clans_enabled'];
			$approvelist = '';
			if($row2['approvelist'] == '') {
				$approvelist = $lang['clans_empty'];
			} else {
				$allapprovelist = str_replace("ß", "", $row2['approvelist']);
				$newapprovelist = explode("Þ",$allapprovelist);
				$count = count($newapprovelist);
	
				for($x=0; $x<$count; $x++)
				{
					$Usql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ."
							WHERE character_id = '".$newapprovelist[$x]."' ";
					if ( !($Uresult = $db->sql_query($Usql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Usql); } 
					while ( $Urow = $db->sql_fetchrow($Uresult) )
					{
						if($approvelist == '')
						{
							$approvelist .= '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$newapprovelist[$x].'" target="_blank">'.$Urow['character_name'].'</a>';
						}
						else
						{
							$approvelist .= ', <a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$newapprovelist[$x].'" target="_blank">'.$Urow['character_name'].'</a>';
						}
					}
				}
			}
		}

		// Get name of founder!
		$UFsql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ."
				WHERE character_id = '".$row2['founder']."' ";
		if ( !($UFresult = $db->sql_query($UFsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $UFsql); } 
		while ( $UFrow = $db->sql_fetchrow($UFresult) ) {
			$founder = $UFrow['character_name'];
		}

		// Get number of items in clan stash
		$stash_getitems = str_replace("Þ", "", $row2['stash_items']);
		$stash_items = explode('ß', $stash_getitems);
		$itemstash = (count($stash_items) -1);

		// Other stuff
		$founded = create_date($board_config['default_dateformat'], $row2['founded'], $board_config['board_timezone']);
		$description = nl2br($row2['description']);

		$this_title = sprintf($lang['clans_title_clanspage'], $row2['name']);

		$template->assign_vars(array( 
			'L_NAME' => $lang['clans_name'],
			'L_LEADER' => $lang['clans_leader'],
			'L_MEMBERS' => $lang['clans_members'],
			'L_DESCRIPTION' => $lang['clans_description'],
			'L_LOGO' => $lang['clans_logo'],
			'L_DETAILS' => $lang['clans_details'],
			'L_APPROVING' => $lang['clans_approving'],
			'L_APPROVELIST' => $lang['clans_approvelist'],
			'L_REQ_POSTS' => $lang['clans_req_posts'],
			'L_REQ_POINTS' => $lang['clans_req_points'],
			'L_REQ_LEVEL' => $lang['clans_req_level'],
			'L_JOIN_FEE' => $lang['clans_join_fee'],
			'L_POINTS' => $points_name,
			'L_FOUNDED' => $lang['clans_founded'],
			'L_SHOUTBOX' => $lang['clans_shoutbox'],
			'L_SHOUT' => $lang['clans_shout'],
			'L_BACKTOLIST' => sprintf($lang['clans_backtolist'],'<a href="'.$file.'?action=list">','</a>'),
			'L_FOUNDED_BY' => $lang['clans_by'],
			'L_STASH' => sprintf($lang['clans_stash_points'],$points_name),
			'L_ISTASH' => $lang['clans_stash_items'],
			'FILE' => $file,
			'NAME' => $row2['name'],
			'LOGO' => $row2['logo'],
			'DESCRIPTION' => smilies_pass($description),
			'LEADER' => $leader,
			'ID' => $row2['id'],
			'MEMBERS' => $members,
			'APPROVING' => $approving,
			'APPROVELIST' => $approvelist,
			'REQ_POSTS' => $req_posts,
			'REQ_POINTS' => $req_points,
			'REQ_LEVEL' => $req_level,
			'JOIN_FEE' => $join_fee,
			'FOUNDED' => $founded,
			'FOUNDER' => $founder,
			'FOUNDER_ID' => $row2['founder'],
			'STASH' => $row2['stash_points'],
			'ISTASH' => $itemstash
		));

		if(($row2['leader'] == $user_id) OR ($userdata['user_level'] == ADMIN)) {
			$template->assign_block_vars('clanleader', array(
				'CLAN' => $row2['id'],
				'FILE' => $file,
				'L_GOTOPANEL' => $lang['clans_goto_clp']
			));
		}
	}

	// Get newsposts!
	$Nsql = "SELECT * FROM ". ADR_CLANS_NEWS_TABLE ."
			WHERE clan= '".intval($_GET['clan'])."'
			ORDER BY ".$news_orderby." ".$news_order."
			LIMIT ".$start.",".$news_amount;
	if ( !($Nresult = $db->sql_query($Nsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Nsql); } 
	while ( $Nrow = $db->sql_fetchrow($Nresult) ) { 
		$title = stripslashes($Nrow['title']);
		$title = smilies_pass($title);
		$text = stripslashes($Nrow['text']);
		$text = nl2br($text);
		$text = smilies_pass($text);

		$date = create_date($board_config['default_dateformat'], $Nrow['date'], $board_config['board_timezone']);

		// Get poster's name!
		$NUsql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ."
			WHERE character_id = '".$Nrow['poster']."' ";
		if ( !($NUresult = $db->sql_query($NUsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $NUsql); } 
		while ( $NUrow = $db->sql_fetchrow($NUresult) ) { $poster = '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$Nrow['poster'].'" target="_blank">'.$NUrow['character_name'].'</a>'; }

		$template->assign_block_vars('newsposts', array(
			'L_BY' => $lang['clans_by'],
			'TITLE' => $title,
			'TEXT' => $text,
			'DATE' => $date,
			'POSTER' => $poster
		));
	}

	// Pagination Data [START]
	$sql = "SELECT count(*) AS total FROM ". ADR_CLANS_NEWS_TABLE ."
			WHERE clan = '".intval($_GET['clan'])."' ";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_ERROR, 'Error getting total', '', __LINE__, __FILE__, $sql); } 

	if ( $total = $db->sql_fetchrow($result) ) { 
		$thetotal = $total['total'];
		// Prevent from blank pages after deleting newspost. [START]
		if($start == $thetotal) { $start = $start - $news_amount; $thetotal = $thetotal - 1; }
		if($start <= 0) { $start = 0; }
		// Prevent from blank pages after deleting newspost. [END]
		$total_pag_items = $thetotal; 
		$pagination = generate_pagination($file."?action=clanpage&clan=".$_GET['clan'], $total_pag_items, $news_amount, $start); 
	} 

	if($thetotal >= 1) {
		$template->assign_vars(array( 
			'PAGINATION' => $pagination, 
			'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $news_amount ) + 1 ), ceil( $total_pag_items / $news_amount )) 
		)); 
	}
	// Pagination Data [END]

//	$template->set_filenames(array('body' => 'adr_clans_clanpage_body.tpl'));
    adr_template_file('adr_clans_clanpage_body.tpl');

}

// Leave clan!
if($_GET['action'] ==  "leave") {

	if(!isset($_GET['clan'])) {
		{ message_die(GENERAL_ERROR, $lang['clans_none_selected']); }
	}

	// V: integrate that crap
	if ($adr_user['character_party']) {
		message_die(GENERAL_MESSAGE, 'Adr_clan_cant_leave_party');
	}

	// Get clan info!
	$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ."
			WHERE id = '".intval($_GET['clan'])."' ";
	if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 
	while ( $row2 = $db->sql_fetchrow($result2) ) 
	{ 
		// Check if user is leader of clan!
		if($row2['leader'] == $user_id) {
			$message = sprintf($lang['clans_cant_leave_leader'], '<b>'.$row2['name'].'</b>').'<br />'.$lang['clans_appoint_new_first'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=list">','</a>');

			message_die(GENERAL_MESSAGE, $message);
		} else {
			// Remove user from members list!
			$newmembers = str_replace("ß".$user_id."Þ", "", $row2['members']);
			
			$sql2 = "UPDATE ". ADR_CLANS_TABLE ."
				SET members = '".$newmembers."'
				WHERE id = '".intval($_GET['clan'])."' ";
			if ( !$db->sql_query($sql2) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 

			$message = sprintf($lang['clans_you_left'], '<b>'.$row2['name'].'</b>').'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=list">','</a>');

			message_die(GENERAL_MESSAGE, $message);
		}
	}
}

// Leave approve list!
if($_GET['action'] ==  "leavelist") {

	if(!isset($_GET['clan'])) {
		{ message_die(GENERAL_ERROR, $lang['clans_none_selected']); }
	}

	// Get clan info!
	$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ."
			WHERE id = '".intval($_GET['clan'])."' ";
	if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 
	while ( $row2 = $db->sql_fetchrow($result2) ) 
	{ 
		// Check if user is leader of clan!
		if($row2['leader'] == $user_id) {
			$message = sprintf($lang['clans_cant_leave_leader'], '<b>'.$row2['name'].'</b>').'<br />'.$lang['clans_appoint_new_first'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=list">','</a>');

			message_die(GENERAL_MESSAGE, $message);
		} else {
			// Remove user from approve list!
			$newmembers = str_replace("ß".$user_id."Þ", "", $row2['approvelist']);
			
			$sql2 = "UPDATE ". ADR_CLANS_TABLE ."
					SET approvelist = '".$newmembers."'
					WHERE id = '".intval($_GET['clan'])."' ";
			if ( !$db->sql_query($sql2) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 

			$message = sprintf($lang['clans_you_left_list'], '<b>'.$row2['name'].'</b>').'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=list">','</a>');

			message_die(GENERAL_MESSAGE, $message);
		}
	}
}

// Join clan!
if($_GET['action'] ==  "join") {

	if(!isset($_GET['clan'])) {
		{ message_die(GENERAL_ERROR, $lang['clans_none_selected']); }
	}

	// Check if user is a member of an other clan, or on a clan's Approve List!
	$inclan = false;
	$sql = "SELECT name FROM ". ADR_CLANS_TABLE ."
			WHERE leader = '".$user_id."' OR members LIKE '%ß".$user_id."Þ%' OR approvelist LIKE '%ß".$user_id."Þ%' ";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql); } 
	while ( $row = $db->sql_fetchrow($result) ) 
	{ if(!empty($row['name'])) { $inclan= true; $theclan = $row['name']; } }

	// Get clan info!
	$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
	if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 
	while ( $row2 = $db->sql_fetchrow($result2) ) 
	{ 
		if($inclan) {
			// User already is in a clan, output message!
			$message = sprintf($lang['clans_already_in_clan'], '<b>'.$row2['name'].'</b>','<b>'.$theclan.'</b>').'<br />'.sprintf($lang['clans_please_leave'], '<b>'.$theclan.'</b>').'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=list">','</a>');
			message_die(GENERAL_MESSAGE, $message);
		} else {
			// User isn't in a clan yet, check if he/she meets the clan requirements!

			$this_title = sprintf($lang['clans_title_join'], $row2['name']);

			// Check postcount!
			$req_posts = true;
			if($row2['req_posts'] != '0') {
				if($row2['req_posts'] > $userdata['user_posts']) {
					$req_posts = false;
				}
			}
			// Check level!
			$req_level = true;
			if($row2['req_level'] != '0') {
				if($row2['req_level'] > $adr_user['character_level']) {
					$req_level = false;
				}
			}
			// Check points!
			$req_points = true;
			if($row2['req_points'] != '0') {
				if($row2['req_points'] > get_reward($user_id)) {
					$req_points = false;
				}
			}
			// Check if user has enough points to pay the join fee!
			$join_fee = true;
			if($row2['join_fee'] != '0') {
				if($row2['join_fee'] > get_reward($user_id)) {
					$join_fee = false;
				}
			}

			// Checks be done, lets see if user can join the clan!
			$join = true;
			if($req_posts) { $c_posts = $lang['clans_yes']; } else { $c_posts = $lang['clans_no']; $join = false; }
			if($req_level) { $c_level = $lang['clans_yes']; } else { $c_level = $lang['clans_no']; $join = false; }
			if($req_points) { $c_points = $lang['clans_yes']; } else { $c_points = $lang['clans_no']; $join = false; }
			if($join_fee) { $c_fee = $lang['clans_yes']; } else { $c_fee = $lang['clans_no']; $join = false; }

			if($_GET['appr'] != 1) { $appr = 0; } else { $appr = 1; }

			if(($join) && ($appr == 0)) {
				// User can join clan, check for approving!
				if($row2['approving'] == '1') {
					$thetext = sprintf($lang['clans_can_join'],'<b>'.$row2['name'].'</b>').'<br />'.$lang['clans_applist'].'<br />'.sprintf($lang['clans_on_applist'],'<b>'.$row2['name'].'</b>').'<br /><br /><a href="'.$file.'?action=join&appr=1&clan='.$_GET['clan'].'">'.$lang['clans_get_on_applist'].'</a><br /><a href="'.$file.'?action=list">'.$lang['clans_dont_join'].'</a>';
				} else {
					if($row2['join_fee'] == '0') {
						// Add user to members list!
						$newmembers = $row2['members']."ß".$user_id."Þ";
				
						$sql3 = "UPDATE ". ADR_CLANS_TABLE ."
							SET members = '".$newmembers."'
							WHERE id = '".intval($_GET['clan'])."' ";
						if ( !$db->sql_query($sql3) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql3); } 

						$thetext = sprintf($lang['clans_can_join'],'<b>'.$row2['name'].'</b>').'<br />'.$lang['clans_have_joined'].'<br /><br /><a href="'.$file.'?action=clanpage&clan='.$_GET['clan'].'">'.sprintf($lang['clans_goto_clanpage'],$row2['name']).'</a><br /><a href="'.$file.'?action=list">'.$lang['clans_dont_join'].'</a>';
					} else {
						$thetext = sprintf($lang['clans_can_join'],'<b>'.$row2['name'].'</b>').'<br />'.sprintf($lang['clans_wanna_pay_fee'],$row2['join_fee'],$points_name).'<br /><br /><a href="'.$file.'?action=payfee&clan='.$_GET['clan'].'">'.sprintf($lang['clans_pay_fee'],$row2['join_fee'],$points_name,$row2['name']).'</a><br /><a href="'.$file.'?action=list">'.$lang['clans_dont_join'].'</a>';
					}
				}
			}
			elseif(($join) && ($appr == 1)) {
				// Aight, put him on the approve list!
					$newapprove = $row2['approvelist']."ß".$user_id."Þ";
					$newfee = $row2['approvefee']."ß".$row2['join_fee']."Þ";
					$newpoints = $userdata['user_points'] - $row2['join_fee'];
			
					$sql3 = "UPDATE ". ADR_CLANS_TABLE ." c, ". USERS_TABLE ." u
						SET c.approvelist = '".$newapprove."', c.approve_fee = '".$newfee."', u.user_points = '".$newpoints."'
						WHERE c.id = '".intval($_GET['clan'])."'
						AND u.user_id = '".$user_id."' ";
					if ( !$db->sql_query($sql3) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql3); } 

					$thetext = sprintf($lang['clans_appr1'],'<b>'.$row2['name'].'</b>').'<br />'.sprintf($lang['clans_appr2'],$row2['req_points'],$points_name).'<br />'.sprintf($lang['clans_appr3'],'<b>'.$row2['name'].'</b>').'<br />'.$lang['clans_appr4'].'<br /><br /><a href="'.$file.'?action=clanpage&clan='.$_GET['clan'].'">'.sprintf($lang['clans_goto_clanpage'],$row2['name']).'</a><br /><a href="'.$file.'?action=list">'.$lang['clans_dont_join'].'</a>';
					message_die(GENERAL_MESSAGE, $thetext);
			}
			else {
					$thetext = sprintf($lang['clans_cant_join'],'<b>'.$row2['name'].'</b>').'<br />'.$lang['clans_and_cannot'].'<br /><br /><a href="'.$file.'?action=list">'.$lang['clans_dont_join'].'</a>';
			}

			$template->assign_vars(array( 
				'TEXT' => '<b>'.$row2['name'].'</b> '.$lang['clans_check_text'],
				'CHECK_POSTS' => sprintf($lang['clans_check_posts'],$row2['req_posts']),
				'CHECK_POINTS' => sprintf($lang['clans_check_points'],$points_name,$row2['req_points'],$points_name),
				'CHECK_LEVEL' => sprintf($lang['clans_check_level'],$row2['req_level']),
				'CHECK_FEE' => sprintf($lang['clans_check_fee'],$row2['join_fee'],$points_name),
				'C_POSTS' => $c_posts,
				'C_POINTS' => $c_points,
				'C_LEVEL' => $c_level,
				'C_FEE' => $c_fee,

				'JOIN_TEXT' => $thetext
			));	
//			$template->set_filenames(array('body' => 'adr_clans_joinchecks_body.tpl'));
    		adr_template_file('adr_clans_joinchecks_body.tpl');
			
		}
	}
}

// Pay fee and join clan!
if($_GET['action'] ==  "payfee") {

	if(!isset($_GET['clan'])) {
		{ message_die(GENERAL_ERROR, $lang['clans_none_selected']); }
	}

	// Check if user is a member of an other clan, or on a clan's Approve List!
	$inclan = false;
	$sql = "SELECT name FROM ". ADR_CLANS_TABLE ."
			WHERE leader = '".$user_id."' OR members LIKE '%ß".$user_id."Þ%' OR approvelist LIKE '%ß".$user_id."Þ%' ";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql); } 
	while ( $row = $db->sql_fetchrow($result) ) 
	{ if(!empty($row['name'])) { $inclan= true; $theclan = $row['name']; } }

	// Get clan info!
	$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
	if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 
	while ( $row2 = $db->sql_fetchrow($result2) ) 
	{ 
		if($inclan) {
			// User already is in a clan, output message!
			$message = sprintf($lang['clans_already_in_clan'], '<b>'.$row2['name'].'</b>','<b>'.$theclan.'</b>').'<br />'.sprintf($lang['clans_please_leave'], '<b>'.$theclan.'</b>').'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=list">','</a>');
			message_die(GENERAL_MESSAGE, $message);
		} else {
			// User isn't in a clan yet, check if he/she meets the clan requirements!

			$this_title = sprintf($lang['clans_title_join'], $row2['name']);

			// Check postcount!
			$req_posts = true;
			if($row2['req_posts'] != '0') {
				if($row2['req_posts'] > $userdata['user_posts']) {
					$req_posts = false;
				}
			}
			// Check level!
			$req_level = true;
			if($row2['req_level'] != '0') {
				if($row2['req_level'] > $userdata['user_statlevel']) {
					$req_level = false;
				}
			}
			// Check points!
			$req_points = true;
			if($row2['req_points'] != '0') {
				if($row2['req_points'] > get_reward($user_id)) {
					$req_points = false;
				}
			}
			// Check if user has enough points to pay the join fee!
			$join_fee = true;
			if($row2['join_fee'] != '0') {
				if($row2['join_fee'] > get_reward($user_id)) {
					$join_fee = false;
				}
			}

			// Checks be done, lets see if user can join the clan!
			$join = true;
			if($req_posts) { $c_posts = $lang['clans_yes']; } else { $c_posts = $lang['clans_no']; $join = false; }
			if($req_level) { $c_level = $lang['clans_yes']; } else { $c_level = $lang['clans_no']; $join = false; }
			if($req_points) { $c_points = $lang['clans_yes']; } else { $c_points = $lang['clans_no']; $join = false; }
			if($join_fee) { $c_fee = $lang['clans_yes']; } else { $c_fee = $lang['clans_no']; $join = false; }


			if($join) {
				// User can join clan, check for approving!
				if($row2['approving'] == '1') {
					$thetext = sprintf($lang['clans_can_join'],'<b>'.$row2['name'].'</b>').'<br />'.$lang['clans_applist'].'<br />'.sprintf($lang['clans_on_applist'],'<b>'.$row2['name'].'</b>').'<br /><br /><a href="'.$file.'?action=approvelist&clan='.$_GET['clan'].'">'.$lang['clans_get_on_applist'].'</a><br /><a href="'.$file.'?action=list">'.$lang['clans_dont_join'].'</a>';
				} else {
					if($row2['join_fee'] == '0') {
						// Add user to members list!
						$newmembers = $row2['members']."ß".$user_id."Þ";
				
						$sql3 = "UPDATE ". ADR_CLANS_TABLE ."
								SET members = '".$newmembers."'
								WHERE id = '".intval($_GET['clan'])."' ";
						if ( !$db->sql_query($sql3) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql3); } 

						$thetext = sprintf($lang['clans_can_join'],'<b>'.$row2['name'].'</b>').'<br />'.$lang['clans_have_joined'].'<br /><br /><a href="'.$file.'?action=clanpage&clan='.$_GET['clan'].'">'.sprintf($lang['clans_goto_clanpage'],$row2['name']).'</a><br /><a href="'.$file.'?action=list">'.$lang['clans_dont_join'].'</a>';
					} else {
						// Add user to members list!
						$newmembers = $row2['members']."ß".$user_id."Þ";
				
						$sql3 = "UPDATE ". ADR_CLANS_TABLE ."
								SET members = '".$newmembers."'
								WHERE id = '".intval($_GET['clan'])."' ";
						if ( !$db->sql_query($sql3) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql3); } 

						$newpoints = ($userdata['user_points'] - $row2['join_fee']);

						set_reward($user_id, $newpoints);
//						$sql4 = "UPDATE ". USERS_TABLE ."
//							SET user_points = '".$newpoints."'
//							WHERE user_id = '".$user_id."' ";
//						if ( !$db->sql_query($sql4) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql4); }

						// Add the paid points to the clan stash! :)
						$new_stash = $row2['stash_points'] + $row2['join_fee'];
						$sql5 = "UPDATE ". ADR_CLANS_TABLE ." SET stash_points = '".$new_stash."' WHERE id = '".intval($_GET['clan'])."' ";
						if ( !$db->sql_query($sql5) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql5); }

						$message = sprintf($lang['clans_paid_fee'],$row2['join_fee'],$points_name,'<b>'.$row2['name']).'<br /><br /><a href="'.$file.'?action=clanpage&clan='.$_GET['clan'].'">'.sprintf($lang['clans_goto_clanpage'],$row2['name']).'</a><br /><a href="'.$file.'?action=list">'.$lang['clans_dont_join'].'</a>';

						message_die(GENERAL_MESSAGE, $message);
					}
				}
			} else {
					$thetext = sprintf($lang['clans_cant_join'],'<b>'.$row2['name'].'</b>').'<br />'.$lang['clans_and_cannot'].'<br /><br /><a href="'.$file.'?action=list">'.$lang['clans_dont_join'].'</a>';
			}

			$template->assign_vars(array( 
				'TEXT' => '<b>'.$row2['name'].'</b> '.$lang['clans_check_text'],
				'CHECK_POSTS' => sprintf($lang['clans_check_posts'],$row2['req_posts']),
				'CHECK_POINTS' => sprintf($lang['clans_check_points'],$points_name,$row2['req_points'],$points_name),
				'CHECK_LEVEL' => sprintf($lang['clans_check_level'],$row2['req_level']),
				'CHECK_FEE' => sprintf($lang['clans_check_fee'],$row2['join_fee'],$points_name),
				'C_POSTS' => $c_posts,
				'C_POINTS' => $c_points,
				'C_LEVEL' => $c_level,
				'C_FEE' => $c_fee,

				'JOIN_TEXT' => $thetext
			));	
//			$template->set_filenames(array('body' => 'adr_clans_joinchecks_body.tpl'));
    		adr_template_file('adr_clans_joinchecks_body.tpl');
			
		}
	}
}


// Add a Shout!
if($_GET['action'] ==  "addshout") {

	if(!isset($_GET['clan'])) {
	{
		message_die(GENERAL_ERROR, $lang['clans_none_selected']); }
	}

	$text = stripslashes($_POST['shout']);
	$text = addslashes($text);
	$text = htmlspecialchars($text);

	if($text != "") {
		// Add shout!
		$Nsql = "INSERT INTO ". ADR_CLANS_SHOUTS_TABLE ." (clan,poster,text) VALUES ('".intval($_GET['clan'])."','".$user_id."','".$text."')";
		if ( !$db->sql_query($Nsql) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Nsql); } 
	}

	$shoutbox = true;
}

// Shoutbox on clanpage!
if(($_GET['action'] ==  "shoutbox") OR ($shoutbox)) {

	if(!isset($_GET['clan'])) {
		{ message_die(GENERAL_ERROR, $lang['clans_none_selected']); }
	}

	// Get newsposts!
	$Nsql = "SELECT * FROM ". ADR_CLANS_SHOUTS_TABLE ."
			WHERE clan = '".intval($_GET['clan'])."'
			ORDER BY id DESC LIMIT 0,25";
	if(!($Nresult = $db->sql_query($Nsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Nsql); }

	while($Nrow = $db->sql_fetchrow($Nresult))
	{
		$text = stripslashes($Nrow['text']);
		$text = smilies_pass($text);

		// Get poster's name!
		$NUsql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ."
				WHERE character_id = '".$Nrow['poster']."'";
		if ( !($NUresult = $db->sql_query($NUsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving adr character data', '', __LINE__, __FILE__, $NUsql); }

		while($NUrow = $db->sql_fetchrow($NUresult))
		{
			$poster = '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$Nrow['poster'].'" target="_blank">'.$NUrow['character_name'].'</a>';
		}

		$template->assign_block_vars('shouts', array(
			'SHOUT' => $text,
			'POSTER' => $poster
		));
	}

	$shoutbox = true;

//	$template->set_filenames(array('body' => 'adr_clans_shoutbox_body.tpl'));
    adr_template_file('adr_clans_shoutbox_body.tpl');
}

// Create a new clan!!
if($_GET['action'] ==  "create") {
	// Check if user is a member of an other clan, or on a clan's Approve List!
	$sql = "SELECT name FROM ". ADR_CLANS_TABLE ."
			WHERE leader = '".$user_id."' OR members LIKE '%ß".$user_id."Þ%' OR approvelist LIKE '%ß".$user_id."Þ%' ";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql); } 
	while ( $row = $db->sql_fetchrow($result) ) 
	{ if(!empty($row['name'])) { 
		// User already is in a clan, output message!
		$message = sprintf($lang['clans_cant_create'], '<b>'.$row['name'].'</b>').'<br />'.sprintf($lang['clans_please_leave'], '<b>'.$row['name'].'</b>').'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=list">','</a>');
		message_die(GENERAL_MESSAGE, $message);
	} }

	$this_title = $lang['clans_createnew'];

	$template->assign_vars(array( 
		'L_CREATENEW' => $lang['clans_createnew'],
		'L_CREATE_TEXT' => $lang['clans_create_text'],
		'L_NAME' => $lang['clans_name'],
		'L_LEADER' => $lang['clans_leader'],
		'L_DESCRIPTION' => $lang['clans_description'],
		'L_URLLOGO' => $lang['clans_urllogo'],
		'L_LOGO' => $lang['clans_logo'],
		'L_APPROVING' => $lang['clans_approve_new'],
		'L_REQ_POSTS' => $lang['clans_req_posts'],
		'L_REQ_POINTS' => $lang['clans_req_points'],
		'L_REQ_LEVEL' => $lang['clans_req_level'],
		'L_JOIN_FEE' => $lang['clans_join_fee'],
		'L_POINTS' => $points_name,
		'L_CREATE' => $lang['clans_create'],
		'L_BACKTOLIST' => sprintf($lang['clans_backtolist'],'<a href="'.$file.'?action=list">','</a>'),
		'L_YES' => $lang['clans_yes'],
		'L_NO' => $lang['clans_no'],

		'FILE' => $file,
		'USERNAME' => '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$user_id.'" target="_blank">'.$userdata['username'].'</a>'
	));	

//	$template->set_filenames(array('body' => 'adr_clans_create_body.tpl'));
    adr_template_file('adr_clans_create_body.tpl');
}

// Add new clan to db!
if($_GET['action'] ==  "docreate") {

	// Check if user is a member of an other clan, or on a clan's Approve List!
	$sql = "SELECT name FROM ". ADR_CLANS_TABLE ."
			WHERE leader = '".$user_id."' OR members LIKE '%ß".$user_id."Þ%' ";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql); } 
	while ( $row = $db->sql_fetchrow($result) ) 
	{ if(!empty($row['name'])) { 
		// User already is in a clan, output message!
		$message = sprintf($lang['clans_cant_create'], '<b>'.$row['name'].'</b>').'<br />'.sprintf($lang['clans_please_leave'], '<b>'.$row['name'].'</b>').'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=list">','</a>');
		message_die(GENERAL_MESSAGE, $message);
	} }

	$name = $_POST['name'];
	$desc = $_POST['description'];
	$leader = $user_id;
	$founder = $user_id;
	$logo = $_POST['logo'];
	$posts = $_POST['req_posts'];
	$level = $_POST['req_level'];
	$points = $_POST['req_points'];
	$fee = $_POST['join_fee'];

	if(
		($name == "") OR 
		($desc == "") OR 
		($leader == "") OR 
		($founder == "") OR 
		($logo == "") OR 
		($logo == "http://") OR 
		($posts == "") OR 
		($level == "") OR 
		($points == "") OR 
		($fee == "")
	) {
		message_die(GENERAL_MESSAGE, $lang['clans_not_all_fields'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=create">','</a>'));
	}
	if(($level < 0) || (!is_numeric($level))) {
		message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_level'],$level).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=create">','</a>'));
	}
	if(($posts < 0) || (!is_numeric($posts))) {
		message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_posts'],$posts).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=create">','</a>'));
	}
	if(($fee < 0) || (!is_numeric($fee))) {
		message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_fee'], $fee, $points_name).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=create">','</a>'));
	}
	if(($points < 0) || (!is_numeric($points))) {
		message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_points'],$points_name, $points, $points_name).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=create">','</a>'));
	}

	// Check if logo is a jpg/jpeg/gif/png file. If not, output error!
	if ( !preg_match("#^((ht|f)tp://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png))$)#is", $logo) )
	{
		message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_invalid_logo'],'<b>'.$logo.'</b>').'<br />'.$lang['clans_clp_details_invalid_logo2'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=create">','</a>'));
	}

	// Check if Approving is a right value! (only 0 or 1!)
	$set_approving = $_POST['approving'];
	if(($set_approving < 0) || ($set_approving > 1) || (!is_numeric($set_approving))) {
		message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_approving'],$set_approve).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=create">','</a>'));
	}

	// Check if there's a clan with the same name already!
	$sql = "SELECT name FROM ". ADR_CLANS_TABLE ." WHERE name = '".$name."' ";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql); } 
	while ( $row = $db->sql_fetchrow($result) ) 
	{ if(!empty($row['name'])) { 
		// Clan already exists!!
		$message = sprintf($lang['clans_couldnt_create'], '<b>'.$name.'</b>').'<br />'.$lang['clans_same_name'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=create">','</a>');
		message_die(GENERAL_MESSAGE, $message);
	} }
		
	$time = time();

	// Get rid of all those nasty 's, "s and HTML codes
		$name = stripslashes($name);
		$name = addslashes($name);
		$name = htmlspecialchars($name);
		$desc = stripslashes($desc);
		$desc = addslashes($desc);
		$desc = htmlspecialchars($desc);

	$Nsql = "INSERT INTO ". ADR_CLANS_TABLE ." (name,leader,members,logo,description,approving,approvelist,approve_fee,req_posts,req_points,req_level,join_fee,founded,founder,news_orderby,news_order,news_amount) VALUES
		('".$name."','".$leader."','','".$logo."','".$desc."','".$set_approving."','','','".$posts."','".$points."','".$level."','".$fee."','".$time."','".$founder."','date','0','10')
	";
	if ( !$db->sql_query($Nsql) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Nsql); } 	

	message_die(GENERAL_MESSAGE, sprintf($lang['clans_created_succesfully'],'<b>'.$name.'</b>').'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=list">','</a>'));

}

// CLP!
if($_GET['action'] ==  "clp") {
	// Get clan info!
	if($_GET['clan'] == "") { message_die(GENERAL_ERROR, $lang['clans_none_selected']); }

	$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
	if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 

	while ( $row2 = $db->sql_fetchrow($result2) )  {
		if(($row2['leader'] != $user_id) && ($userdata['user_level'] != ADMIN)) { message_die(GENERAL_ERROR, $lang['clans_clp_not_authorized']); }
	}

	if ( ($db->sql_numrows($result2)) < 1) {
		message_die(GENERAL_ERROR, $lang['clans_clp_doesnt_exist']);
	}

	$news = false;

	if($_GET['t'] == "") {
		$this_title = $lang['clans_clp'];
		$template->assign_vars(array( 
			'FILE' => $file,
			'L_HEADER' => $lang['clans_clp'],
			'L_INTRO' => $lang['clans_clp_intro'],
			'L_DETAILS' => $lang['clans_clp_details'],
			'L_MEMBERS' => $lang['clans_clp_members'],
			'L_NEWS' => $lang['clans_clp_news'],

			'INTRO_WELCOME' => $lang['clans_clp_intro_text_welcome'],
			'INTRO_1' => $lang['clans_clp_intro_text1'],
			'INTRO2' => $lang['clans_clp_intro_text2'],
			'INTRO3' => $lang['clans_clp_intro_text3'],
			'INTRO4' => $lang['clans_clp_intro_text4'],
			'INTRO5' => $lang['clans_clp_intro_text5'],

			'CLAN' => $_GET['clan']

		));

//		$template->set_filenames(array('body' => 'adr_clans_clp_intro_body.tpl'));
    	adr_template_file('adr_clans_clp_intro_body.tpl');
	}
	if($_GET['t'] == "news") {
	   if($_GET['a'] == "drop") {
		// Do checks!
		if($_GET['news'] == "") { message_die(GENERAL_ERROR, $lang['clans_clp_nonews_selected']); }

		if($_POST['yes']) {
			$sqlN = "DELETE FROM ". ADR_CLANS_NEWS_TABLE ." WHERE id = '".$_GET['news']."' ";
			if ( !($resultN = $db->sql_query($sqlN)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlN); } 
		}

		$news = true;
	   }
	   if($_GET['a'] == "alter") {
		// Do checks!
		if($_GET['news'] == "") { message_die(GENERAL_ERROR, $lang['clans_clp_nonews_selected']); }
		if(($_POST['text'] == "") OR ($_POST['title'] == "")) {
			message_die(GENERAL_MESSAGE, $lang['clans_not_all_fields'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=news&a=edit&news='.$_GET['news'].'&clan='.$_GET['clan'].'">','</a>'));
		}

		$text = stripslashes($_POST['text']);
		$text = addslashes($text);
		$text = htmlspecialchars($text);
		$title = stripslashes($_POST['title']);
		$title = addslashes($title);
		$title = htmlspecialchars($title);

		$sqlN = "UPDATE ". ADR_CLANS_NEWS_TABLE ." SET title = '".$title."', text = '".$text."' WHERE id = '".$_GET['news']."' ";
		if ( !($resultN = $db->sql_query($sqlN)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlN); } 

		$news = true;
	   }
	   if($_GET['a'] == "add") {
		// Do checks!
		if(($_POST['text'] == "") OR ($_POST['title'] == "")) {
			message_die(GENERAL_MESSAGE, $lang['clans_not_all_fields'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=news&a=new&clan='.$_GET['clan'].'">','</a>'));
		}

		$text = stripslashes($_POST['text']);
		$text = addslashes($text);
		$text = htmlspecialchars($text);
		$title = stripslashes($_POST['title']);
		$title = addslashes($title);
		$title = htmlspecialchars($title);

		$Nsql = "INSERT INTO ". ADR_CLANS_NEWS_TABLE ." (clan,poster,title,text,date) VALUES ('".intval($_GET['clan'])."',')".$user_id."','".$title."','".$text."','".time()."') ";
		if ( !$db->sql_query($Nsql) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Nsql); } 

		$news = true;
	   }
	   if(($_GET['a'] == "") OR ($news)) {
		$this_title = $lang['clans_title_manage_news'];
		// [START] Check to see if we need HTTP_GET_VARS or HTTP_POST_VARS *sigh* this shouldn't be needed...
		$vars = 'none';
		if(($HTTP_POST_VARS['order'] == "") && ($HTTP_POST_VARS['asc'] == "")) {
			$vars = 'get';
			// Check sort settings!
			if($HTTP_GET_VARS['order'] == "") { $order = 'date'; } else { $order = $HTTP_GET_VARS['order']; }
			if($HTTP_GET_VARS['asc'] == "") { $asc = 'desc'; } else { $asc = $HTTP_GET_VARS['asc']; }
	
			// Do SELECTED checks
			if($HTTP_GET_VARS['order'] == 'date') { $d_selected = 'SELECTED'; } else { $d_selected = ''; }
			if($HTTP_GET_VARS['order'] == 'poster') { $a_selected = 'SELECTED'; } else { $a_selected = ''; }
			if($HTTP_GET_VARS['order'] == 'title') { $t_selected = 'SELECTED'; } else { $t_selected = ''; }
			if($HTTP_GET_VARS['desc'] == 'desc') { $desc_selected = 'SELECTED'; } else { $desc_selected = ''; }
			if($HTTP_GET_VARS['asc'] == 'asc') { $asc_selected = 'SELECTED'; } else { $asc_selected = ''; }
		}
		if(($HTTP_GET_VARS['order'] == "") && ($HTTP_GET_VARS['asc'] == "")) {
			$vars = 'post';
			// Check sort settings!
			if($HTTP_POST_VARS['order'] == "") { $order = 'date'; } else { $order = $HTTP_POST_VARS['order']; }
			if($HTTP_POST_VARS['asc'] == "") { $asc = 'desc'; } else { $asc = $HTTP_POST_VARS['asc']; }
	
			// Do SELECTED checks
			if($HTTP_POST_VARS['order'] == 'date') { $d_selected = 'SELECTED'; } else { $d_selected = ''; }
			if($HTTP_POST_VARS['order'] == 'poster') { $a_selected = 'SELECTED'; } else { $a_selected = ''; }
			if($HTTP_POST_VARS['order'] == 'title') { $t_selected = 'SELECTED'; } else { $t_selected = ''; }
			if($HTTP_POST_VARS['desc'] == 'desc') { $desc_selected = 'SELECTED'; } else { $desc_selected = ''; }
			if($HTTP_POST_VARS['asc'] == 'asc') { $asc_selected = 'SELECTED'; } else { $asc_selected = ''; }
		}
		if($vars == '') {
			$order = 'date';
			$asc = 'desc';
		}
		// [END] Check to see if we need HTTP_GET_VARS or HTTP_POST_VARS

		// Pagination Data [START]
		$sql = "SELECT count(*) AS total FROM ". ADR_CLANS_NEWS_TABLE ." WHERE clan = '".intval($_GET['clan'])."' ";
		if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_ERROR, 'Error getting total', '', __LINE__, __FILE__, $sql); } 

		if ( $total = $db->sql_fetchrow($result) ) { 
			$thetotal = $total['total'];
			// Prevent from blank pages after deleting newspost. [START]
			if($start == $thetotal) { $start = $start - $board_config['posts_per_page']; $thetotal = $thetotal - 1; }
			if($start <= 0) { $start = 0; }
			// Prevent from blank pages after deleting newspost. [END]
			$total_pag_items = $thetotal; 
			$pagination = generate_pagination($file."?action=clp&t=news&clan=".$_GET['clan'].'&order='.$order.'&asc='.$asc, $total_pag_items, $board_config['posts_per_page'], $start); 
		} 
		
		if($thetotal >= 1) {
			$template->assign_vars(array( 
				'PAGINATION' => $pagination, 
				'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['posts_per_page'] ) + 1 ), ceil( $total_pag_items / 	$board_config['posts_per_page'] )) 
			)); 
		}
		// Pagination Data [END]

		$sqlN = "SELECT * FROM ". ADR_CLANS_NEWS_TABLE ." WHERE clan = '".intval($_GET['clan'])."' ORDER BY ".$order." ".$asc." LIMIT " . $start . ", " . $board_config['posts_per_page'];
		if ( !($resultN = $db->sql_query($sqlN)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlN); } 

		$x = 1;
		while ( $rowN = $db->sql_fetchrow($resultN) )  {

			$sqlU = "SELECT character_name FROM ".ADR_CHARACTERS_TABLE."
					WHERE character_id = '".$rowN['poster']."' ";
			if ( !($resultU = $db->sql_query($sqlU)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlU); } 
			while ( $rowU = $db->sql_fetchrow($resultU) )  { $poster = $rowU['character_name']; }

			$text = stripslashes($rowN['text']);
			$text = nl2br($text);

			$template->assign_block_vars('news', array(
				'FILE' => $file,
				'BULLET' => $lang['clans_clp_news_bullet'],
				'ID' => $rowN['id'],
				'NID' => $rowN['id'],
				'TITLE' => smilies_pass($rowN['title']),
				'TEXT' => smilies_pass($text),
				'ROW' => $x,
				'POSTER' => $poster,
				'POSTERID' => $rowN['poster'],
				'BY' => $lang['clans_postedby'],
				'DATE' => create_date($board_config['default_dateformat'], $rowN['date'], $board_config['board_timezone']),
				'L_BACK_TO_CLANPAGE' => sprintf($lang['clans_clp_back_to_clanpage'],'<a href="'.$file.'?action=clanpage&clan='.$_GET['clan'].'">','</a>'),
				'L_ID' => $lang['clans_clp_news_postid'],
				'ORDER' => $order,
				'START' => $start,
				'ASC' => $asc,
				'CLAN' => $_GET['clan']
			));

			$x++;
			if($x > 2) { $x = 1; }
		}

		$template->assign_vars(array( 
			'FILE' => $file,
			'L_HEADER' => $lang['clans_clp'],
			'L_INTRO' => $lang['clans_clp_intro'],
			'L_DETAILS' => $lang['clans_clp_details'],
			'L_MEMBERS' => $lang['clans_clp_members'],
			'L_NEWS' => $lang['clans_clp_news'],
			'L_TITLE' => $lang['clans_title'],
			'L_NEWSPOST' => $lang['clans_message'],
			'L_EDIT' => $lang['clans_edit'],
			'AUTHOR' => $lang['clans_clp_news_author'],
			'DATE' => $lang['clans_clp_news_date'],
			'GO' => $lang['clans_clp_news_go'],
			'L_SORT_BY' => $lang['clans_clp_news_sortby'],
			'ASC' => $lang['clans_clp_news_asc'],
			'DESC' => $lang['clans_clp_news_desc'],
			'D_SELECTED' => $d_selected,
			'A_SELECTED' => $a_selected,
			'T_SELECTED' => $t_selected,
			'ASC_SELECTED' => $asc_selected,
			'DESC_SELECTED' => $desc_selected,
			'U_ORDER' => $order,
			'U_START' => $start,
			'U_ASC' => $asc,
			'NEWPOST_IMG' => $images['pm_postmsg'],
			'MINIPOST_IMG' => $images['icon_minipost'],
			'EDIT_IMG' => $images['icon_edit'],
			'DELETE_IMG' => $images['icon_delpost'],
			'CLAN' => $_GET['clan']
		));

//		$template->set_filenames(array('body' => 'adr_clans_clp_news_body.tpl'));
    	adr_template_file('adr_clans_clp_news_body.tpl');
	   }
	   if($_GET['a'] == "new") {
		$this_title = $lang['clans_clp_news_new'];
		$sqlN = "SELECT name FROM ". ADR_CLANS_TABLE ."
				WHERE id = '".intval($_GET['clan'])."' ";
		if ( !($resultN = $db->sql_query($sqlN)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlN); } 
		while ( $rowN = $db->sql_fetchrow($resultN) )  { $clanname = $rowN['name']; }

		$template->assign_vars(array( 
			'FILE' => $file,
			'L_HEADER' => $lang['clans_clp'],
			'L_INTRO' => $lang['clans_clp_intro'],
			'L_DETAILS' => $lang['clans_clp_details'],
			'L_MEMBERS' => $lang['clans_clp_members'],
			'L_NEWS' => $lang['clans_clp_news'],
			'L_POSTER' => $lang['clans_clp_news_newauthor'],
			'L_CLAN' => $lang['clans_clp_news_newclan'],
			'L_TITLE' => $lang['clans_title'],
			'L_NEWSPOST' => $lang['clans_clp_news_newmessage'],
			'L_POST' => $lang['clans_clp_news_newpost'],
			'L_POST_NEW' => $lang['clans_clp_news_new'],
			'CLANNAME' => $clanname,
			'POSTER' => $userdata['username'],
			'POSTERID' => $user_id,
			'ACTION' => 'add',
			'CLICK_BACK' => sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=news&clan='.$_GET['clan'].'&order='.$_GET['order'].'&asc='.$_GET['asc'].'&start='.$_GET['start'].'">','</a>'),
			'P_TITLE' => '',
			'P_TEXT' => '',
			'CLAN' => $_GET['clan']
		));

//		$template->set_filenames(array('body' => 'adr_clans_clp_news_add_body.tpl'));
   	 	adr_template_file('adr_clans_clp_news_add_body.tpl');
	   }
	   if($_GET['a'] == "edit") {
		$this_title = $lang['clans_clp_news_edit'];
		if($_GET['news'] == "") { message_die(GENERAL_ERROR, $lang['clans_clp_nonews_selected']); }

		$sqlR = "SELECT name FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
		if ( !($resultR = $db->sql_query($sqlR)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlR); } 
		while ( $rowR = $db->sql_fetchrow($resultR) )  { $clanname = $rowR['name']; }

		$sqlN = "SELECT * FROM ". ADR_CLANS_NEWS_TABLE ." WHERE id = '".$_GET['news']."' AND clan = '".intval($_GET['clan'])."' ";
		if ( !($resultN = $db->sql_query($sqlN)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlN); } 
		while ( $rowN = $db->sql_fetchrow($resultN) )  {

			$sqlU = "SELECT character_name FROM ".ADR_CHARACTERS_TABLE." WHERE character_id = '".$rowN['poster']."' ";
			if ( !($resultU = $db->sql_query($sqlU)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlU); } 
			while ( $rowU = $db->sql_fetchrow($resultU) )  { $postername = $rowU['character_name']; }

			$template->assign_vars(array( 
				'FILE' => $file,
				'L_HEADER' => $lang['clans_clp'],
				'L_INTRO' => $lang['clans_clp_intro'],
				'L_DETAILS' => $lang['clans_clp_details'],
				'L_MEMBERS' => $lang['clans_clp_members'],
				'L_NEWS' => $lang['clans_clp_news'],
				'L_POSTER' => $lang['clans_clp_news_newauthor'],
				'L_CLAN' => $lang['clans_clp_news_newclan'],
				'L_TITLE' => $lang['clans_title'],
				'L_NEWSPOST' => $lang['clans_clp_news_newmessage'],
				'L_POST' => $lang['clans_edit'],
				'L_POST_NEW' => $lang['clans_clp_news_edit'],
				'CLANNAME' => $clanname,
				'POSTER' => $postername,
				'POSTERID' => $rowN['poster'],
				'ACTION' => 'alter&news='.$_GET['news'].'&order='.$_GET['order'].'&asc='.$_GET['asc'].'&start='.$_GET['start'].'#'.$_GET['news'],
				'CLICK_BACK' => sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=news&clan='.$_GET['clan'].'&order='.$_GET['order'].'&asc='.$_GET['asc'].'&start='.$_GET['start'].'">','</a>'),
				'P_TITLE' => $rowN['title'],
				'P_TEXT' => $rowN['text'],
				'CLAN' => $_GET['clan']
			));

		}

//		$template->set_filenames(array('body' => 'adr_clans_clp_news_add_body.tpl'));
    	adr_template_file('adr_clans_clp_news_add_body.tpl');
	   }
	   if($_GET['a'] == "delete") {
		if($_GET['news'] == "") { message_die(GENERAL_ERROR, $lang['clans_clp_nonews_selected']); }

		message_die(GENERAL_MESSAGE, '
					<form style="margin: 0px 0px 0px 0px;" action="'.$file.'?action=clp&t=news&a=drop&news='.$_GET['news'].'&clan='.$_GET['clan'].'&order='.$_GET['order'].'&asc='.$_GET['asc'].'&start='.$_GET['start'].'" method="post">'.$lang['clans_clp_news_confirm'].'<br /><br />
						<input type="submit" name="yes" class="mainoption" value="'.$lang['clans_yes'].'"> <input type="submit" name="no" class="liteoption" value="'.$lang['clans_no'].'">
					</form>
		');
	   }
	}
	if($_GET['t'] == "details") {
		$this_title = $lang['clans_clp_details_manage'];
		if(($_GET['a'] != "edit") && ($_GET['a'] != "gameover")) {
			$sqlN = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
			if ( !($resultN = $db->sql_query($sqlN)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlN); }
			while ( $rowN = $db->sql_fetchrow($resultN) )  { 
				if($rowN['approving'] == 0) {
					$no_s = 'SELECTED';
					$yes_s = '';
				} else {
					$no_s = '';
					$yes_s = 'SELECTED';
				}
				if($rowN['news_order'] == 0) {
					$desc_s = 'SELECTED';
					$asc_s = '';
				} else {
					$desc_s = '';
					$asc_s = 'SELECTED';
				}

				$date_s = '';
				$author_s = '';
				$title_s = '';

				if($rowN['news_orderby'] == "date") { $date_s = 'SELECTED'; }
				if($rowN['news_orderby'] == "poster") { $author_s = 'SELECTED'; }
				if($rowN['news_orderby'] == "title") { $title_s = 'SELECTED'; }


				$template->assign_vars(array( 
					'FILE' => $file,
					'L_HEADER' => $lang['clans_clp'],
					'L_INTRO' => $lang['clans_clp_intro'],
					'L_DETAILS' => $lang['clans_clp_details'],
					'L_MEMBERS' => $lang['clans_clp_members'],
					'L_NEWS' => $lang['clans_clp_news'],

					'L_MANAGE' => $lang['clans_clp_details_manage'],
					'L_NAME' => $lang['clans_name'],
					'L_DESCRIPTION' => $lang['clans_description'],
					'L_LOGO' => $lang['clans_logo'],
					'L_APPROVE' => $lang['clans_approving'],
					'L_APPROVE_EXP' => sprintf($lang['clans_clp_details_approve_exp'],'<b>','</b>','<b>','</b>'),
					'L_YES' => $lang['clans_yes'],
					'L_NO' => $lang['clans_no'],
					'L_POSTS' => $lang['clans_req_posts'],
					'L_POINTS' => $lang['clans_req_points'],
					'L_LEVEL' => $lang['clans_req_level'],
					'L_FEE' => $lang['clans_join_fee'],
					'L_FEE_EXP' => sprintf($lang['clans_clp_details_fee_exp'],$points_name),
					'L_AMOUNT' => $lang['clans_clp_details_amount'],
					'L_AMOUNT_EXP' => $lang['clans_clp_details_amount_exp'],
					'L_ORDER' => $lang['clans_clp_details_order'],
					'L_ORDER_EXP' => $lang['clans_clp_details_order_exp'],
					'L_ORDERBY' => $lang['clans_clp_details_orderby'],
					'L_DATE' => $lang['clans_clp_news_date'],
					'L_AUTHOR' => $lang['clans_clp_news_author'],
					'L_TITLE' => $lang['clans_title'] = 'Title',
					'L_DESC' => $lang['clans_clp_news_desc'],
					'L_ASC' => $lang['clans_clp_news_asc'],
					'L_SUBMIT' => $lang['clans_clp_news_go'],
					'L_POINTSNAME' => $points_name,

					'L_DELETE' => $lang['clans_clp_details_delete_text'],
					'L_DELETE_EXP' => sprintf($lang['clans_clp_details_delete_text_exp'],'<b>','</b>'),
					'L_DODEL' => sprintf($lang['clans_clp_details_delete_checkbox'],'<b>'.$rowN['name'].'</b>'),

					'V_NAME' => $rowN['name'],
					'V_DESC' => $rowN['description'],
					'V_LOGO' => $rowN['logo'],
					'NO_CHECKED' => $no_s,
					'YES_CHECKED' => $yes_s,
					'V_POSTS' => $rowN['req_posts'],
					'V_POINTS' => $rowN['req_points'],
					'V_LEVEL' => $rowN['req_level'],
					'V_FEE' => $rowN['join_fee'],
					'V_AMOUNT' => $rowN['news_amount'],
					'DATE_SELECTED' => $date_s,
					'AUTHOR_SELECTED' => $author_s,
					'TITLE_SELECTED' => $title_s,
					'DESC_CHECKED' => $desc_s,
					'ASC_CHECKED' => $asc_s,

					'CLAN' => $_GET['clan']
				));
			}

//			$template->set_filenames(array('body' => 'adr_clans_clp_details_body.tpl'));
    		adr_template_file('adr_clans_clp_details_body.tpl');
		}
		if($_GET['a'] == "edit") {
			$name = $_POST['name'];
			$desc = $_POST['desc'];
			$logo = $_POST['logo'];
			$approve = $_POST['approve'];
			$posts = $_POST['posts'];
			$level = $_POST['level'];
			$points = $_POST['points'];
			$fee = $_POST['fee'];
			$amount = $_POST['amount'];
			$orderby = $_POST['orderby'];
			$order = $_POST['order'];

			if(
				($name == "") OR 
				($desc == "") OR 
				($logo == "") OR 
				($logo == "http://") OR 
				($approve == "") OR 
				($posts == "") OR 
				($level == "") OR 
				($points == "") OR 
				($fee == "") OR 
				($amount == "") OR 
				($orderby == "") OR 
				($order == "")
			) {
				message_die(GENERAL_MESSAGE, $lang['clans_not_all_fields'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>'));
			}
			if(($amount < 1) || (!is_numeric($amount))) {
				message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_amount'],$amount).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>'));
			}
			if(($level < 0) || (!is_numeric($level))) {
				message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_level'],$level).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>'));
			}
			if(($posts < 0) || (!is_numeric($posts))) {
				message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_posts'],$posts).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>'));
			}
			if(($fee < 0) || (!is_numeric($fee))) {
				message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_fee'],$fee,$points_name).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>'));
			}
			if(($points < 0) || (!is_numeric($points))) {
				message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_points'],$points_name,$points,$points_name).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>'));
			}

			// Check if Approving is a right value! (only 0 or 1!)
			if(($approve < 0) || ($approve > 1) || (!is_numeric($approve))) {
				message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_inv_approving'],$approve).'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>'));
			}


			// Check if logo is a jpg/jpeg/gif/png file. If not, output error!
			if ( !preg_match("#^((ht|f)tp://)([^ \?&=\#\"\n\r\t<]*?(\.(jpg|jpeg|gif|png))$)#is", $logo) )
			{
				message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_invalid_logo'],'<b>'.$logo.'</b>').'<br />'.$lang['clans_clp_details_invalid_logo2'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>'));
			}

			// If clan name has changed, check if there's a clan with the same name already!
			if($name != $_POST['oldname']) {
				$sql = "SELECT name FROM ". ADR_CLANS_TABLE ." WHERE name = '".$name."' ";
				if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql); } 
				while ( $row = $db->sql_fetchrow($result) ) 
					{ if(!empty($row['name'])) { 
					// Clan already exists!!
					$message = $lang['clans_same_name'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a 	href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>');
					message_die(GENERAL_MESSAGE, $message);
				} }
			}

			// If Approving is set to 0 (=NO) then get rid of the approvelist and approve fees already paid by those on the approve list!
			if($approve == 0) {
				$approvelist_sql = ", approvelist = '', approve_fee = '' ";

					// Give all those on the approve list their money back! [START]
					$sqlZZ = "SELECT approvelist, approve_fee FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
					if ( !($resultZZ = $db->sql_query($sqlZZ)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlZZ); } 
					while ( $rowZZ = $db->sql_fetchrow($resultZZ) ) 
					{
						if($rowZZ['approvelist'] != '') {
							$allapprove = str_replace("ß", "", $rowZZ['approvelist']);
							$newapprove = explode("Þ",$allapprove);
							$count = (count($newapprove)-1);

							$allfees = str_replace("ß", "", $rowZZ['approve_fee']);
							$newfees = explode("Þ",$allfees);

							for($xy=0;$xy<$count;$xy++) {
//								$sqlZZ2 = "SELECT user_points FROM ". USERS_TABLE ." WHERE user_id = '".$newapprove[$xy]."' ";
								$sqlZZ2 = get_reward($newapprove[$xy]);
								if ( !($resultZZ2 = $db->sql_query($sqlZZ2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlZZ2); } 
								while ( $rowZZ2 = $db->sql_fetchrow($resultZZ2) ) 
								{ $newpoints = $rowZZ2['user_points'] + $newfees[$xy]; }

								set_reward($newapprove[$xy], $newpoints);
//								$sql23 = "UPDATE ". USERS_TABLE ." SET user_points = '".$newpoints."' WHERE user_id = '".$newapprove[$xy]."' ";
//								if ( !$db->sql_query($sql23) ) { message_die(GENERAL_ERROR, 'Error updating clan info', '', __LINE__, __FILE__, $sql23); }
							}
						}
					}
					// Give all those on the approve list their money back! [END]
			} else {
				$approvelist_sql = "";
			}

			// Get rid of all those nasty 's, "s and HTML codes
				$name = stripslashes($name);
				$name = addslashes($name);
				$name = htmlspecialchars($name);
				$desc = stripslashes($desc);
				$desc = addslashes($desc);
				$desc = htmlspecialchars($desc);

			// Everything seems to be OK. Lets update the db!
			$sql2 = "UPDATE ". ADR_CLANS_TABLE ." SET
					name = '".$name."', 
					description = '".$desc."', 
					logo = '".$logo."', 
					approving = '".$approve."', 
					req_posts = '".$posts."', 
					req_points = '".$points."', 
					req_level = '".$level."', 
					join_fee = '".$fee."', 
					news_amount = '".$amount."', 
					news_orderby = '".$orderby."', 
					news_order = '".$order."' 
					".$approvelist_sql."
					WHERE id = '".intval($_GET['clan'])."' "; 
			if ( !$db->sql_query($sql2) ) { message_die(GENERAL_ERROR, 'Error updating clan info', '', __LINE__, __FILE__, $sql2); } 

			message_die(GENERAL_MESSAGE, $lang['clans_clp_details_success'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>'));
		}
		if($_GET['a'] == "gameover") {
			$sqlG = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
			if ( !($resultG = $db->sql_query($sqlG)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlG); } 
			while ( $rowG = $db->sql_fetchrow($resultG) )  {
				$thisclan = $rowG['name'];
			}

			if($_POST['dodelete'] == "killmenow") {
				// GAMEOVER baby!
				$sql2 = "DELETE FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
				if ( !$db->sql_query($sql2) ) { message_die(GENERAL_ERROR, 'Error deleting clan (clan)', '', __LINE__, __FILE__, $sql2); } 
				$sql3 = "DELETE FROM ". ADR_CLANS_SHOUTS_TABLE ." WHERE clan = '".intval($_GET['clan'])."' ";
				if ( !$db->sql_query($sql3) ) { message_die(GENERAL_ERROR, 'Error deleting clan (shouts)', '', __LINE__, __FILE__, $sql3); }
				$sql4 = "DELETE FROM ". ADR_CLANS_NEWS_TABLE ." WHERE clan = '".intval($_GET['clan'])."' ";
				if ( !$db->sql_query($sql4) ) { message_die(GENERAL_ERROR, 'Error deleting clan (news)', '', __LINE__, __FILE__, $sql4); } 

				message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_delete_gameover'],'<b>'.$thisclan.'</b>').'<br /><br />'.sprintf($lang['clans_backtolist'], '<a href="'.$file.'">','</a>'));
			} else {
				// Not used to happen. Someone's doing funny thigns :P
				message_die(GENERAL_MESSAGE, sprintf($lang['clans_clp_details_delete_nocheck'],'<b>'.$thisclan.'</b>').'<br />'.sprintf($lang['clans_clp_details_delete_nocheck2'],'<b>','</b>').'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=details&clan='.$_GET['clan'].'">','</a>'));
			}
		}
	}


	if($_GET['t'] == "members") {
		$this_title = $lang['clans_clp_members_manage'];
		if($_GET['a'] == "dokick") {
			if(($_GET['member'] == "") || (!is_numeric($_GET['member']))) {
				message_die(GENERAL_MESSAGE, $lang['clans_clp_members_none_selected'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
			}

			$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
			if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 

			while ( $row2 = $db->sql_fetchrow($result2) )  {
				if($_GET['member'] == $row2['leader']) {
					message_die(GENERAL_MESSAGE, $lang['clans_clp_members_no_leader_kick'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
				}
				if (substr_count($row2['members'],"ß".$_GET['member']."Þ") < 1) {
					message_die(GENERAL_MESSAGE, $lang['clans_clp_members_non_exist'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
				}

				if($_POST['yes']) {
					$newmembers = substr_replace($row2['members'], "", strpos($row2['members'], "ß".$_GET['member']."Þ"), strlen("ß".$_GET['member']."Þ"));

					// Delete member!
					$sql9 = "UPDATE ". ADR_CLANS_TABLE ." SET members = '".$newmembers."' WHERE id = '".intval($_GET['clan'])."' ";
					if ( !$db->sql_query($sql9) ) { message_die(GENERAL_ERROR, 'Error updating clan info', '', __LINE__, __FILE__, $sql9); }

					// Get name and output message!
					$Lsql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ." WHERE character_id = '".$_GET['member']."' ";
					if ( !($Lresult = $db->sql_query($Lsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Lsql); } 
					while ( $Lrow = $db->sql_fetchrow($Lresult) ) { 
						$kicked_text = sprintf($lang['clans_clp_members_kick_done'],'<b>'.$Lrow['character_name'].'</b>','<b>'.$row2['name'].'</b>');

						clans_sendpm($row2['leader'],$_GET['member'],$lang['clans_pm_kicked_s'],sprintf($lang['clans_pm_kicked_t'],'<b>'.$row2['name'].'</b>','<b>'.$row2['name'].'</b>'),$lang['clans_pm_little_note']);

						message_die(GENERAL_MESSAGE, $kicked_text.'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
					}
				}
			}

			$members = true;
		}
		if($_GET['a'] == "dopromote") {
			if(($_GET['member'] == "") || (!is_numeric($_GET['member']))) {
				message_die(GENERAL_MESSAGE, $lang['clans_clp_members_none_selected'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
			}

			$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
			if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 

			while ( $row2 = $db->sql_fetchrow($result2) )  {
				if($_GET['member'] == $row2['leader']) {
					message_die(GENERAL_MESSAGE, $lang['clans_clp_members_promote_already_leader'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
				}
				if (substr_count($row2['members'],"ß".$_GET['member']."Þ") < 1) {
					message_die(GENERAL_MESSAGE, $lang['clans_clp_members_non_exist'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
				}

				if($_POST['yes']) {
					$remove_newleader = substr_replace($row2['members'], "", strpos($row2['members'], "ß".$_GET['member']."Þ"), strlen("ß".$_GET['member']."Þ"));
					$newmembers = $remove_newleader . "ß".$row2['leader']."Þ";

					// Set new leader and memberlist!
					$sql9 = "UPDATE ". ADR_CLANS_TABLE ." SET members = '".$newmembers."', leader = '".$_GET['member']."' WHERE id = '".intval($_GET['clan'])."' ";
					if ( !$db->sql_query($sql9) ) { message_die(GENERAL_ERROR, 'Error updating clan info', '', __LINE__, __FILE__, $sql9); }

					// Get name and output message!
					$Lsql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ." WHERE character_id = '".$_GET['member']."' ";
					if ( !($Lresult = $db->sql_query($Lsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Lsql); } 
					while ( $Lrow = $db->sql_fetchrow($Lresult) ) { 
						$text1 = sprintf($lang['clans_clp_members_promote_done'],'<b>'.$Lrow['character_name'].'</b>','<b>'.$row2['name'].'</b>');
						$text2 = $lang['clans_clp_members_promote_done2'];
						$text3 = sprintf($lang['clans_clp_members_promote_done3'],'<b>'.$row2['name'].'</b>');

						clans_sendpm($row2['leader'],$_GET['member'],$lang['clans_pm_promoted_s'],sprintf($lang['clans_pm_promoted_t'],'<b>'.$row2['name'].'</b>'),$lang['clans_pm_little_note']);

						message_die(GENERAL_MESSAGE, $text1.'<br />'.$text2.'<br />'.$text3.'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
					}
				}
			}

			$members = true;
		}
		if(($_GET['a'] == "") || ($members)) {
			$sqlN = "SELECT leader, founder, members, approving, approvelist, approve_fee FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
			if ( !($resultN = $db->sql_query($sqlN)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sqlN); }
			while ( $rowN = $db->sql_fetchrow($resultN) )  { 

				// Get leader name!
				$Lsql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ." WHERE character_id = '".$rowN['leader']."' ";
				if ( !($Lresult = $db->sql_query($Lsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Lsql); } 
				while ( $Lrow = $db->sql_fetchrow($Lresult) ) { $leader_name = '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$rowN['leader'].'" target="_blank">'.$Lrow['character_name'].'</a>'; }

				if($rowN['leader'] == $rowN['founder']) {
					$leader_rank = $lang['clans_clp_members_clanleader'] . ' & ' . $lang['clans_clp_members_founder'];
				} else {
					$leader_rank = $lang['clans_clp_members_clanleader'];
				}

				// Get member names!
				if($rowN['members'] != '') {
					$allmembers = str_replace("ß", "", $rowN['members']);
					$newmembers = explode("Þ",$allmembers);
					$count = (count($newmembers)-1);

					for($x=0;$x<$count;$x++) {
						$Usql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ." WHERE character_id = '".$newmembers[$x]."' ";
						if ( !($Uresult = $db->sql_query($Usql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Usql); } 
						while ( $Urow = $db->sql_fetchrow($Uresult) ) { 
								$member_name = '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$newmembers[$x].'" target="_blank">'.$Urow['character_name'].'</a>';
						}

						$member_rank = $lang['clans_clp_members_member'];
						$template->assign_block_vars('memberlist', array(
							'L_PROMOTE' => $lang['clans_clp_members_promote'],
							'L_KICK' => $lang['clans_clp_members_kick'],
							'NAME' => $member_name,
							'RANK' => $member_rank,
							'ID' => $newmembers[$x]
						));
					}
				}

				// Get approve list
				if($rowN['approvelist'] != '') {
					$allapprove = str_replace("ß", "", $rowN['approvelist']);
					$newapprove = explode("Þ",$allapprove);
					$count = (count($newapprove)-1);

					$allfees = str_replace("ß", "", $rowN['approve_fee']);
					$newfees = explode("Þ",$allfees);

					for($xy=0;$xy<$count;$xy++) {
						$U2sql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ." WHERE character_id = '".$newapprove[$xy]."' ";
						if ( !($U2result = $db->sql_query($U2sql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $U2sql); } 
						while ( $U2row = $db->sql_fetchrow($U2result) ) { 
								$approve_name = '<a href="'.$phpbb_root_path.'adr_character.php?" . POST_USERS_URL ."='.$newapprove[$xy].'" target="_blank">'.$U2row['character_name'].'</a>';
						}

						$approve_fee = $newfees[$xy];

						$template->assign_block_vars('approvelist', array(
							'L_APPROVE' => $lang['clans_clp_members_approve'],
							'L_DISAPPROVE' => $lang['clans_clp_members_disapprove'],
							'NAME' => $approve_name,
							'ID' => $newapprove[$xy],
							'L_FEE' => sprintf($lang['clans_clp_members_approve_paid'],$approve_fee,$points_name)
						));
					}

					$template->assign_vars(array( 
						'L_TRANSFER' => $lang['clans_clp_members_approve_transfer']
					));
				} else {
					if($rowN['approving'] == 1) {
						$template->assign_block_vars('no_approvelist', array(
							'L_EMPTY' => $lang['clans_empty']
						));
					} else {
						$template->assign_block_vars('no_approvelist', array(
							'L_EMPTY' => $lang['clans_disabled']
						));
					}
				}
			}
				
			$template->assign_vars(array( 
				'FILE' => $file,
				'L_HEADER' => $lang['clans_clp'],
				'L_INTRO' => $lang['clans_clp_intro'],
				'L_DETAILS' => $lang['clans_clp_details'],
				'L_MEMBERS' => $lang['clans_clp_members'],
				'L_NEWS' => $lang['clans_clp_news'],
				'L_MANAGE' => $lang['clans_clp_members_manage'],
				'L_MANAGE_APPROVE' => $lang['clans_approvelist'],
				'LEADER_NAME' => $leader_name,
				'LEADER_RANK' => $leader_rank,

				'CLAN' => $_GET['clan']
			));

//			$template->set_filenames(array('body' => 'adr_clans_clp_members_body.tpl'));
   			adr_template_file('adr_clans_clp_members_body.tpl');
		}
		if($_GET['a'] == "kick") {
			if(($_GET['member'] == "") || (!is_numeric($_GET['member']))) {
				message_die(GENERAL_MESSAGE, $lang['clans_clp_members_none_selected'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
			}

			$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
			if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 

			while ( $row2 = $db->sql_fetchrow($result2) )  {
				if($_GET['member'] == $row2['leader']) {
					message_die(GENERAL_MESSAGE, $lang['clans_clp_members_no_leader_kick'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
				}
				if (substr_count($row2['members'],"ß".$_GET['member']."Þ") < 1) {
					message_die(GENERAL_MESSAGE, $lang['clans_clp_members_non_exist'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
				}

				// Get name and output message!
				$Lsql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ." WHERE character_id = '".$_GET['member']."' ";
				if ( !($Lresult = $db->sql_query($Lsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Lsql); } 
				while ( $Lrow = $db->sql_fetchrow($Lresult) ) { 
					$kick_text = sprintf($lang['clans_clp_members_kick_confirm'],'<b>'.$Lrow['character_name'].'</b>','<b>'.$row2['name'].'</b>');
					message_die(GENERAL_MESSAGE, '
						<form style="margin: 0px 0px 0px 0px;" action="'.$file.'?action=clp&t=members&a=dokick&member='.$_GET['member'].'&clan='.$_GET['clan'].'" method="post">'.$kick_text.'<br /><br />
							<input type="submit" name="yes" class="mainoption" value="'.$lang['clans_yes'].'"> <input type="submit" name="no" class="liteoption" value="'.$lang['clans_no'].'">
						</form>
					');
				}
			}
		}
		if($_GET['a'] == "promote") {
			if(($_GET['member'] == "") || (!is_numeric($_GET['member']))) {
				message_die(GENERAL_MESSAGE, $lang['clans_clp_members_none_selected'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
			}

			$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
			if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 

			while ( $row2 = $db->sql_fetchrow($result2) )  {
				if($_GET['member'] == $row2['leader']) {
					message_die(GENERAL_MESSAGE, $lang['clans_clp_members_promote_already_leader'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
				}
				if (substr_count($row2['members'],"ß".$_GET['member']."Þ") < 1) {
					message_die(GENERAL_MESSAGE, $lang['clans_clp_members_non_exist'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
				}

				// Get name and output message!
				$Lsql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ." WHERE character_id = '".$_GET['member']."' ";
				if ( !($Lresult = $db->sql_query($Lsql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $Lsql); } 
				while ( $Lrow = $db->sql_fetchrow($Lresult) ) { 
					$promote_text = sprintf($lang['clans_clp_members_promote_confirm'],'<b>'.$Lrow['character_name'].'</b>','<b>'.$row2['name'].'</b>');
					message_die(GENERAL_MESSAGE, '
						<form style="margin: 0px 0px 0px 0px;" action="'.$file.'?action=clp&t=members&a=dopromote&member='.$_GET['member'].'&clan='.$_GET['clan'].'" method="post">'.$promote_text.'<br />'.$lang['clans_clp_members_promote_confirm2'].'<br /><br />
							<input type="submit" name="yes" class="mainoption" value="'.$lang['clans_yes'].'"> <input type="submit" name="no" class="liteoption" value="'.$lang['clans_no'].'">
						</form>
					');
				}
			}
		}
		if($_GET['a'] == "approve") {
			if(($_GET['member'] == "") || (!is_numeric($_GET['member']))) {
				message_die(GENERAL_MESSAGE, $lang['clans_clp_members_none_selected'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
			}

			$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
			if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 

			while ( $row2 = $db->sql_fetchrow($result2) )  {
				if($row2['approvelist'] != '') {
					$allapprove = str_replace("ß", "", $row2['approvelist']);
					$newapprove = explode("Þ",$allapprove);
					$count = (count($newapprove)-1);

					$allfees = str_replace("ß", "", $row2['approve_fee']);
					$newfees = explode("Þ",$allfees);

					for($xy=0;$xy<$count;$xy++) {
						if($newapprove[$xy] == $_GET['member']) {
							$U2sql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ." WHERE character_id = '".$newapprove[$xy]."' ";
							if ( !($U2result = $db->sql_query($U2sql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $U2sql); } 
							while ( $U2row = $db->sql_fetchrow($U2result) ) { $approve_name = $U2row['character_name']; }
	
							$paid_fee = $newfees[$xy];
							$upd_stash = ($newfees[$xy] + $row2['stash_points']);
							$newmembers = $row2['members'].'ß'.$_GET['member'].'Þ';
							$newfees[$xy] = '';
							$newapprove[$xy] = '';

							for($c=0;$c<count($newfees);$c++) {
								if(($newfees[$c] != '') || ($newapprove[$c] != '')) {
								$newfees[$c] = 'ß'.$newfees[$c].'Þ';
								$newapprove[$c] = 'ß'.$newapprove[$c].'Þ';
								}
							}

							$upd_approve = implode("",$newapprove);
							$upd_fees = implode("",$newfees);

							$sql9 = "UPDATE ". ADR_CLANS_TABLE ." SET
								members = '".$newmembers."', 
								approvelist = '".$upd_approve."', 
								approve_fee = '".$upd_fees."', 
								stash_points = '".$upd_stash."' 
								WHERE id = '".intval($_GET['clan'])."' "; 
							if ( !$db->sql_query($sql9) ) { message_die(GENERAL_ERROR, 'Error updating clan info', '', __LINE__, __FILE__, $sql9); }
	
							$text = sprintf($lang['clans_clp_members_approve_done'],'<b>'.$approve_name.'</b>');
							$text .= '<br />'.sprintf($lang['clans_clp_members_approve_done_stash'], '<b>'.$paid_fee, $points_name.'</b>');

							clans_sendpm($row2['leader'],$_GET['member'],$lang['clans_pm_approved_s'],sprintf($lang['clans_pm_approved_t'],'<b>'.$row2['name'].'</b>'),$lang['clans_pm_little_note']);

							message_die(GENERAL_MESSAGE,$text.'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
						}
					}
							message_die(GENERAL_MESSAGE,$lang['clans_clp_members_approve_err_not_on_list'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
				} else {
					message_die(GENERAL_MESSAGE, $lang['clans_clp_members_approve_empty']);
				}
			}
		}
		if($_GET['a'] == "disapprove") {
			if(($_GET['member'] == "") || (!is_numeric($_GET['member']))) {
				message_die(GENERAL_MESSAGE, $lang['clans_clp_members_none_selected'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
			}

			$sql2 = "SELECT * FROM ". ADR_CLANS_TABLE ." WHERE id = '".intval($_GET['clan'])."' ";
			if ( !($result2 = $db->sql_query($sql2)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $sql2); } 

			while ( $row2 = $db->sql_fetchrow($result2) )  {
				if($row2['approvelist'] != '') {
					$allapprove = str_replace("ß", "", $row2['approvelist']);
					$newapprove = explode("Þ",$allapprove);
					$count = (count($newapprove)-1);

					$allfees = str_replace("ß", "", $row2['approve_fee']);
					$newfees = explode("Þ",$allfees);

					for($xy=0;$xy<$count;$xy++) {
						if($newapprove[$xy] == $_GET['member']) {
							$U2sql = "SELECT character_name FROM ". ADR_CHARACTERS_TABLE ." WHERE character_id = '".$newapprove[$xy]."' ";
							if ( !($U2result = $db->sql_query($U2sql)) ) { message_die(GENERAL_ERROR, 'Error retrieving data', '', __LINE__, __FILE__, $U2sql); } 
							while ( $U2row = $db->sql_fetchrow($U2result) ) { $approve_name = $U2row['character_name']; }
	
							$paid_fee = $newfees[$xy];
							$this_user = $newapprove[$xy];
							$newfees[$xy] = '';
							$newapprove[$xy] = '';

							for($c=0;$c<count($newfees);$c++) {
								if(($newfees[$c] != '') || ($newapprove[$c] != '')) {
								$newfees[$c] = 'ß'.$newfees[$c].'Þ';
								$newapprove[$c] = 'ß'.$newapprove[$c].'Þ';
								}
							}

							$upd_approve = implode("",$newapprove);
							$upd_fees = implode("",$newfees);

							add_reward($this_user, $paid_fee);
//							$sql10 = "UPDATE ". USERS_TABLE ."
//								SET	user_points = user_points + '".$paid_fee."'
//								WHERE user_id = '".$this_user."' ";
//							if ( !$db->sql_query($sql10) ) { message_die(GENERAL_ERROR, 'Error updating clan info', '', __LINE__, __FILE__, $sql10); }
							
							$sql9 = "UPDATE ". ADR_CLANS_TABLE ."
								SET	approvelist = '".$upd_approve."',
								approve_fee = '".$upd_fees."' 
								WHERE id = '".intval($_GET['clan'])."' "; 
							if ( !$db->sql_query($sql9) ) { message_die(GENERAL_ERROR, 'Error updating clan info', '', __LINE__, __FILE__, $sql9); }

							$text = sprintf($lang['clans_clp_members_approve_disapprove'],'<b>'.$approve_name.'</b>');
							$text .= '<br />'.sprintf($lang['clans_clp_members_approve_points_back'], '<b>'.$paid_fee, $points_name.'</b>','<b>'.$approve_name.'</b>');

							clans_sendpm($row2['leader'],$_GET['member'],$lang['clans_pm_disapproved_s'],sprintf($lang['clans_pm_disapproved_t'],'<b>'.$row2['name'].'</b>','<b>'.$paid_fee,$points_name.'</b>'),$lang['clans_pm_little_note']);

							message_die(GENERAL_MESSAGE,$text.'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
						}
					}
							message_die(GENERAL_MESSAGE,$lang['clans_clp_members_approve_err_not_on_list'].'<br /><br />'.sprintf($lang['clans_click_here'], '<a href="'.$file.'?action=clp&t=members&clan='.$_GET['clan'].'">','</a>'));
				} else {
					message_die(GENERAL_MESSAGE, $lang['clans_clp_members_approve_empty']);
				}
			}
		}
	}

	$template->assign_block_vars('nuladion', array(
		'NULADION' => 'Clans MOD Advanced made by <a href="http://www.nuladion.com" target="_blank">Nuladion</a>'
	));

	$template->assign_block_vars('bars', array(
		'FILE' => $file,
		'L_BACKTOLIST' => sprintf($lang['clans_backtolist'],'<a href="'.$file.'?action=list">','</a>'),
		'L_BACK_TO_CLANPAGE' => sprintf($lang['clans_clp_back_to_clanpage'],'<a href="'.$file.'?action=clanpage&clan='.$_GET['clan'].'">','</a>')
	));
}

$page_title = $lang['clans_modtitle'].' :: '.$this_title;

//
// Start output of page
//

if(!$shoutbox) {
	include($phpbb_root_path . 'includes/page_header.' . $phpEx);
	include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
}

$template->pparse('body');

if(!$shoutbox) {
	include($phpbb_root_path . 'includes/page_tail.' . $phpEx);
}
?>
