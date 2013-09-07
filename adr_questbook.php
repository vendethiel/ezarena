<?php 
/***************************************************************************
 *					adr_questbook.php
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

$loc = 'questbook';
$sub_loc = 'adr_questbook';

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
	$redirect = "adr_questbook.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_questbook_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);


// Check for any active quests
$sql = " SELECT * FROM " . ADR_QUEST_LOG_TABLE . "
	WHERE user_id = '$user_id'
	";
if( !($result = $db->sql_query($sql)) )
	message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql);
	
if ( $quest_log = $db->sql_fetchrow($result) )
{
	do
	{
		//Get all the information about the NPC
		$sql2 = " SELECT * FROM  " . ADR_NPC_TABLE . "
	    	WHERE npc_id = '".$quest_log['npc_id']."' 
			";
		if( !($result2 = $db->sql_query($sql2)) )
			message_die(GENERAL_ERROR, 'No items found', "", __LINE__, __FILE__, $sql2);
		if ($npc_info = $db->sql_fetchrow($result2))
		{
			if ($quest_log['quest_kill_monster'] != "" && $quest_log['quest_kill_monster'] != "0" && $quest_log['quest_kill_monster_current_amount'] < $quest_log['quest_kill_monster_amount'])
			{
				$quest_status .= sprintf($lang['Adr_questbook_quest_typ_kill'], $quest_log['quest_kill_monster'], $quest_log['quest_kill_monster_current_amount'], $quest_log['quest_kill_monster_amount']);
			}
			elseif ($quest_log['quest_kill_monster'] != "" && $quest_log['quest_kill_monster'] != "0" && $quest_log['quest_kill_monster_current_amount'] == $quest_log['quest_kill_monster_amount'])
			{
				$quest_status .= sprintf($lang['Adr_questbook_quest_typ_kill_done'], $quest_log['quest_kill_monster_amount'], $quest_log['quest_kill_monster']);
			}
			
			if ($quest_log['quest_item_need']  != "" && $quest_log['quest_item_need'] != '0')
			{
				$npc_item_need_array = explode( ',' , $quest_log['quest_item_need'] );	
				for ( $i = 0 ; $i < count( $npc_item_need_array ) ; $i++ )
				{
					$sql3 = " SELECT * FROM " . ADR_SHOPS_ITEMS_TABLE . "
			  			WHERE item_owner_id = '$user_id' 
						AND item_name = '".$npc_item_need_array[$i]."' 
						AND item_in_shop = '0'
						";
					$result3 = $db->sql_query($sql3);
					if( !$result3 )
			  				message_die(GENERAL_ERROR, 'No items found', "", __LINE__, __FILE__, $sql3);
					if ( $quest_log3 = $db->sql_fetchrow($result3) )
					{
						$sql4 = "SELECT * FROM " . ADR_QUEST_LOG_TABLE . "
						WHERE quest_item_need like '".$quest_log3['item_name'].","."%' 
						OR quest_item_need like '".$quest_log3['item_name']."'
						OR quest_item_need like '".$quest_log3['item_name'].","."'
						OR quest_item_need like '%".",".$quest_log3['item_name'].","."%'
						OR quest_item_need like '%".",".$quest_log3['item_name']."'
						AND user_id = '$user_id'
						";
						$result4 = $db->sql_query($sql4);
						if ( $got_item_log = $db->sql_fetchrow($result4) )
							$quest_status .= sprintf($lang['Adr_questbook_quest_typ_item_have'], adr_get_lang($quest_log3['item_name']));
					}
					else
					{
						if ($npc_item_need_array[$i] != "")
							$quest_status .= sprintf($lang['Adr_questbook_quest_typ_item_need'], adr_get_lang($npc_item_need_array[$i]));
					}
				}
			}


			$sql6 = " SELECT * FROM  " . ADR_ZONES_TABLE . "
			       WHERE zone_id = '".$npc_info['npc_zone']."' ";
			if( !($result6 = $db->sql_query($sql6)) )
			        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql6);

			$zone = $db->sql_fetchrow($result6);
			$zone_name = $zone['zone_name'];
			
			$template->assign_block_vars('quest', array(
				"QUEST_STATUS" => $quest_status,
				"NPC_ZONE" => $zone_name,
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
				"NPC_KILL_MONSTER" => $npc_info['npc_kill_monster'],
				"NPC_MONSTER_AMOUNT" => $npc_info['npc_monster_amount'],
			));
		}
		$quest_status = "";
	}
	while ( $quest_log = $db->sql_fetchrow($result) );
}

$template->assign_vars(array(
	'LANG' => $board_config['default_lang'],
	"QUEST_BOOK_TITLE" => $lang['Adr_questbook_title'],
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