<?php 
/***************************************************************************
 *					adr_questbook_history.php
 *				------------------------
 *	begin 			: 27/12/2005
 *	copyright		: Himmelweiss
 *	web				: http://www.nightcrawlers.be
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
define('IN_ADR_QUESTBOOK', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_ZONES', true);

$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'questbook_history';
$sub_loc = 'adr_questbook_history';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX); 
init_userprefs($userdata); 
// End session management
//

$user_id = $userdata['user_id'];
$points = $userdata['user_points'];

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_questbook_history.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_questbook_history_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);


// Check for any active quests
$sql = " SELECT * FROM " . ADR_QUEST_LOG_HISTORY_TABLE . "
	WHERE user_id = '$user_id'
	ORDER BY quest_id DESC
	";
if( !($result = $db->sql_query($sql)) )
	message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql);
	
while ( $quest_log = $db->sql_fetchrow($result) )
{
	$quest_status = "";
	//Get all the information about the NPC
	$sql2 = " SELECT * FROM  " . ADR_NPC_TABLE . "
    	WHERE npc_id = '".$quest_log['npc_id']."' 
		";
	if( !($result2 = $db->sql_query($sql2)) )
		message_die(GENERAL_ERROR, 'No items found', "", __LINE__, __FILE__, $sql2);
	if ($npc_info = $db->sql_fetchrow($result2))
	{
		if ($quest_log['quest_killed_monster'] != "" && $quest_log['quest_killed_monster'] != '0')
		{
			$quest_status .= sprintf($lang['Adr_questbook_quest_typ_killed'], $quest_log['quest_killed_monsters_amount'], $quest_log['quest_killed_monster']);
		}
		if ($quest_log['quest_item_gave'] != "" && $quest_log['quest_item_gave'] != '0')
		{
			$npc_item_need_array = explode( ',' , $quest_log['quest_item_gave'] );	
			for ( $i = 0 ; $i < count( $npc_item_need_array ) ; $i++ )
			{
				$sql4 = "SELECT * FROM " . ADR_QUEST_LOG_HISTORY_TABLE . "
				WHERE quest_item_gave like '".$npc_item_need_array[$i].","."%' 
				OR quest_item_gave like '".$npc_item_need_array[$i]."'
				OR quest_item_gave like '".$npc_item_need_array[$i].","."'
				OR quest_item_gave like '%".",".$npc_item_need_array[$i].","."%'
				OR quest_item_gave like '%".",".$npc_item_need_array[$i]."'
				AND user_id = '$user_id'
				";
				$result4 = $db->sql_query($sql4);
				if ( $got_item_log = $db->sql_fetchrow($result4) )
					$quest_status .= sprintf($lang['Adr_questbook_quest_typ_item_gave'], adr_get_lang($npc_item_need_array[$i]));
			}
		}
    if ($quest_status == '')
    {
      // V: no items, no mob killed. User paid.
      $quest_status .= $lang['Adr_questbook_quest_typ_clue'];
    }
		
		$template->assign_block_vars('quest', array(
			
			"QUEST_KILLED_MONSTER" => $quest_log['quest_killed_monster'],
			"QUEST_KILLED_MONSTERS_AMOUNT" => $quest_log['quest_killed_monsters_amount'],
			"QUEST_ITEM_GAVE" => $quest_log['quest_item_gave'],
			
			"QUEST_STATUS" => $quest_status,
			
			"NPC_ZONE" => $npc_info['npc_zone'],
			"NPC_NAME" => $npc_info['npc_name']."<br>",
			"NPC_IMG" => $npc_info['npc_img'],
			"NPC_ENABLE" => $npc_info['npc_enable'],
			"NPC_PRICE" => $npc_info['npc_price'],
			"NPC_MESSAGE" => $npc_info['npc_message'],
			"NPC_ITEM" => $npc_info['npc_item'],
			"NPC_MESSAGE2" => $npc_info['npc_message2'],
			"NPC_POINTS" => $npc_info['npc_points'],
			"NPC_EXP" => $npc_info['npc_exp'],
			"NPC_SP" => $npc_info['npc_sp'],
			"NPC_ITEM2" => $npc_info['npc_item2'],
			"NPC_TIMES" => $npc_info['npc_times'],

		));
	}
}

$template->assign_vars(array(
	'LANG' => $board_config['default_lang'],
	"QUEST_BOOK_TITLE" => $lang['Adr_questbook_history_title'],
	"QUEST_BOOK_LINK" => $lang['Adr_questbook_link'],
	"QUEST_BOOK_HISTORY_LINK" => $lang['Adr_questbook_history_link'],
	"NPC_NAME_HEADER" => $lang['Adr_questbook_npc_name'],
	"NPC_ZONE_HEADER" => $lang['Adr_questbook_npc_zone'],
	"NPC_MESSAGE_HEADER" => $lang['Adr_questbook_npc_message'],
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?>
