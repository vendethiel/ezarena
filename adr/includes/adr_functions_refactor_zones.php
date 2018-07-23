<?php
/* V:
 * This functions were made as modifications done to the EzArena premodded board
 * and are "just" code refactoring, because sometimes it makes me cry to have 5-times dups.
 */

function zone_get_all()
{
  global $db;
  static $zones_cache;
  if ($zones_cache)
    return $zones_cache;

	$sql = "SELECT * FROM  " . ADR_ZONES_TABLE;
	if( !($result = $db->sql_query($sql)) )
	        message_die(GENERAL_ERROR, 'Could not query zone list', '', __LINE__, __FILE__, $sql);
  $zones_cache = $data = $db->sql_fetchrowset($result);
  $db->sql_freeresult($result);
  return $data;
}

function zone_get($zone_id)
{
	global $db;
	static $zone_cache;
	if (isset($zone_cache[$zone_id]))
	{
		return $zone_cache[$zone_id];
	}

	$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
	       WHERE zone_id =  " . intval($zone_id);
	if( !($result = $db->sql_query($sql)) )
	        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

	$zone = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	return $zone_cache[$zone_id] = $zone;
}

function zone_goto($goto_id, $cost_goto)
{
	global $board_config, $adr_user, $db, $adr_user, $phpEx, $user_id, $lang;

	if ( ( $board_config['zone_dead_travel'] == '1' ) && ( $adr_user['character_hp'] < '1' ) )
		adr_previous( Adr_zone_change_dead , adr_zones , '' );

	//Prevent blank destination error
	if ( $goto_id . '' == $lang['Adr_zone_destination_none'] )
		adr_previous( Adr_zone_change_unavaible , adr_zones , '' );

	//Select the zone destination
	$zone_id = zone_get($goto_id);
	if (!$zone_id)
	{
		adr_previous('Adr_zone_change_unavaible', 'adr_zones');
	}
	$destination_id = $zone_id['zone_id'];
	$required_item = $zone_id['zone_item'];

	$required_level = $zone_id['zone_level'];

	if( $adr_user['character_level'] < $required_level )
	{ adr_previous( adr_zone_change_level , adr_zones , '' ); }


 	// Check if user has the required item
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
   		WHERE item_name = '$required_item'
   		AND item_owner_id = '$user_id'
   		AND item_in_shop = '0'
   		AND item_in_warehouse = '0' ";
	$result = $db->sql_query($sql);
	if( !$result )
   		message_die(GENERAL_ERROR, 'Could not obtain required item information', "", __LINE__, __FILE__, $sql);

	$item_check = $db->sql_fetchrow($result);

	if ( ( $required_item == '0' ) || ( $required_item == $item_check['item_name'] ) ) 
	{
		adr_substract_points( $user_id , $cost_goto , adr_zones , '' );
    adr_teleport_character($user_id, $destination_id);

		@header('Location:'.append_sid("adr_zones.$phpEx"));
		adr_previous( Adr_zone_change_success , adr_zones , '' );
		break;
	}
	else
	{
		$message = $lang['Adr_zone_item_lack'] . ' : ' . $required_item . '<br /><br />' . $lang['Adr_zone_event_return'] . '<br /><br />';
		message_die(GENERAL_ERROR, $message , Zones , '' );
		break;
	}
}

function adr_teleport_character($user_id, $destination_id)
{
  global $db;

  $sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
    SET character_area = '$destination_id'
    WHERE character_id = '$user_id' ";
  if( !($result = $db->sql_query($sql)) )
    message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);
  $db->sql_freeresult($result);
}

function zone_events($zone)
{
	global $db, $userdata, $lang, $user_id, $phpEx, $zone_events, $area_id;

	static $events = array(
		// V: see adr_functions_refactor_events
		'1' => 'get_points',
		'2' => 'lose_points',
		'3' => 'fountain_youth',
		'4' => 'fountain_mana',
		'5' => 'poisoned',
		'6' => 'weakness',
		'7' => 'get_item',
		'8' => 'ambush',
	);
	if (!$zone_events)
	{
		return;
	}

	$do = rand( 1 , $zone_chance );

	if ( $do == '1' )
	{
		$event = rand(1, count($events));
		if ($zone['zone_event'.$event])
		{
			call_user_func('zone_event_trigger_'.$events[$event], $zone);
		}
	}
}

// Zone - NPCs
function zone_npc_check_preconditions($npc_row)
{
  global $lang, $adr_user, $user_id;
  global $user_npc_visit_array, $user_npc_quest_array;

  $no_talk_message = array();

  $npc_zone_array = explode( ',' , $npc_row['npc_zone'] );
  $npc_race_array = explode( ',' , $npc_row['npc_race'] );
  $npc_class_array = explode( ',' , $npc_row['npc_class'] );
  $npc_alignment_array = explode( ',' , $npc_row['npc_alignment'] );
  $npc_element_array = explode( ',' , $npc_row['npc_element'] );
  $npc_character_level_array = explode( ',' , $npc_row['npc_character_level'] );
  $npc_visit_array = explode( ',' , $npc_row['npc_visit_prerequisite'] );
  $npc_quest_array = explode( ',' , $npc_row['npc_quest_prerequisite'] );

  $npc_visit = array();
  $npc_quest = array();
  $npc_quest_hide_array = array();

  // you can't click a disabled npc
  if ( !($npc_row['npc_enable']) )
    adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
  // you can't click a npc in another area
  if ( !in_array( $area_id , $npc_zone_array ) && $npc_zone_array[0] != '0' )
    adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
  if ( !in_array( $adr_user['character_race'] , $npc_race_array ) && $npc_race_array[0] != '0')
      $no_talk_message[] = $lang['Adr_Npc_race_no_talk_message'];

  if ( !in_array( $adr_user['character_class'] , $npc_class_array ) && $npc_class_array[0] != '0')
    $no_talk_message[] = $lang['Adr_Npc_class_no_talk_message'];

  if ( !in_array( $adr_user['character_alignment'] , $npc_alignment_array ) && $npc_alignment_array[0] != '0')
    $no_talk_message[] = $lang['Adr_Npc_alignment_no_talk_message'];

  if ( !in_array( $adr_user['character_element'] , $npc_element_array ) && $npc_element_array[0] != '0')
    $no_talk_message[] = $lang['Adr_Npc_element_no_talk_message'];

  if ( !in_array( $adr_user['character_level'] , $npc_character_level_array ) && $npc_character_level_array[0] != '0')
    $no_talk_message[] = $lang['Adr_Npc_character_level_no_talk_message'];

  for ($y = 0; $y < count($user_npc_visit_array); $y++)
    $npc_visit[$y] = ( in_array( $user_npc_visit_array[$y] , $npc_visit_array ) ) ? '1' : '0';

  if (!in_array('1' , $npc_visit) && $npc_visit_array[0] != '0')
    $no_talk_message[] = $lang['Adr_Npc_character_visit_no_talk_message'];

  for ($y = 0; $y < count($user_npc_quest_array); $y++)
  {
    $npc_quest_id = explode( ':' , $user_npc_quest_array[$y] );
    $npc_quest[$y] = ( in_array( $npc_quest_id[0] , $npc_quest_array ) ) ? '1' : '0';
    $npc_quest_hide_array[$y] = ( $npc_quest_id[0] == $npc_row['npc_id'] ) ? '1' : '0';
  }
  if ( !in_array( '1' , $npc_quest ) && $npc_quest_array[0] != '0')
    $no_talk_message[] = $lang['Adr_Npc_character_quest_no_talk_message'];

  // here, uses npc_quest_hide
  if	( in_array( '1' , $npc_quest_hide_array ) && $npc_row['npc_quest_hide'] )
    adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);

  if ($no_talk_message && !$npc_row['npc_view'])
    adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
  return $no_talk_message;
}

function zone_npc_actions()
{
	global $board_config, $db, $userdata, $area_id, $user_id, $lang, $adr_user, $user_npc_visit_array, $user_npc_quest_array;

	if ( isset($_GET['npc']) || isset($_POST['npc']) )
		$npc_action = ( isset($_POST['npc']) ) ? intval($_POST['npc']) : intval($_GET['npc']);

	$npc_give_action = isset($_POST['npc_give']) ? $_POST['npc_give'] : null;

	if( isset($npc_action) )
	{
		if ( isset($_GET['npc_id']) || isset($_POST['npc_id']) )
		{
			$npc_id = ( isset($_POST['npc_id']) ) ? intval($_POST['npc_id']) : intval($_GET['npc_id']);
		}
		$sql = "SELECT * FROM  " . ADR_NPC_TABLE . "
				WHERE npc_id = '$npc_id'
					AND npc_enable = '1'";
		if ( !($result = $db->sql_query($sql)) )
	        message_die(GENERAL_ERROR, 'Could not query npc information', '', __LINE__, __FILE__, $sql);

		//prevent user exploit
		if ( !($npc_row = $db->sql_fetchrow($result)))
			adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);

    $adr_user = adr_npc_visit_update( $npc_id, $adr_user );
    $no_talk_message = zone_npc_check_preconditions($npc_row);

		$adr_moderators_array = explode( ',' , $board_config['zone_adr_moderators'] );
		if ( $npc_row['npc_user_level'] != '0' && !( ( $npc_row['npc_user_level'] == '1' && $userdata['user_level'] == ADMIN ) || ( $npc_row['npc_user_level'] == '2' && ( in_array( $user_id , $adr_moderators_array ) || $userdata['user_level'] == ADMIN ) ) ) )
			adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
		//----

		adr_substract_points( $user_id , $npc_row['npc_price'] , 'adr_zones' , '' );
		if ( count( $no_talk_message ) )
		{
			$message_id = rand( 0 , ( count( $no_talk_message ) - 1 ) );
			$message = "<img src=\"adr/images/zones/npc/" . $npc_row['npc_img'] . "\"><br /><br /><b>" . $npc_row['npc_name'] . ":</b> <i>\"" . $no_talk_message[$message_id] . "\"</i><br /><br />" . $lang['Adr_zone_event_return'];
			$adr_zone_npc_title = sprintf( $lang['Adr_Npc_speaking_with'], $npc_row['npc_name'] );
			message_die(GENERAL_MESSAGE, $message , $adr_zone_npc_title , '' );
		}
		else
		{
			if ( adr_npc_check_times($npc_row['npc_id'], $adr_user['character_npc_check'], $npc_row['npc_times'] ) )
			{
				zone_npc_item_quest_check($npc_row);
			}
			else
			{
				$message = "<img src=\"adr/images/zones/npc/" . $npc_row['npc_img'] . "\"><br /><br /><b>" . $npc_row['npc_name'] . ":</b><br /><div class=\"npc_dialog\">\"" . $npc_row['npc_message3'] . "\"</div><br /><br />" . $lang['Adr_zone_event_return'];
				$adr_zone_npc_title = sprintf( $lang['Adr_Npc_speaking_with'], $npc_row['npc_name'] );
				message_die(GENERAL_ERROR, $message , $adr_zone_npc_title , '' );
				break;
			}
		}
	}
	else if( isset($npc_give_action) )
	{
		$npc_id = intval($_POST['npc_id']);
		$item_id_array = explode( ',' , $_POST['item_id']);
		$sql = "SELECT * FROM  " . ADR_NPC_TABLE . "
				WHERE npc_id = '$npc_id'" ;
		if ( !($result = $db->sql_query($sql)) )
	        message_die(GENERAL_ERROR, 'Could not query npc information', '', __LINE__, __FILE__, $sql);

		//prevent user exploit
		if ( !($npc_give_row = $db->sql_fetchrow($result)))
			adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);
    $no_talk_message = zone_npc_check_preconditions($npc_give_row);
		$adr_moderators_array = explode( ',' , $board_config['zone_adr_moderators'] );
		if ( $npc_give_row['npc_user_level'] != '0' && !( ( $npc_give_row['npc_user_level'] == '1' && $userdata['user_level'] == ADMIN ) || ( $npc_give_row['npc_user_level'] == '2' && ( in_array( $user_id , $adr_moderators_array ) || $userdata['user_level'] == ADMIN ) ) ) )
			adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_2']);

		if ( !$npc_give_row['npc_quest_clue'] )
		{
	 		// Check if user has the item(s)
			$npc_item_array = explode( ',' , $npc_give_row['npc_item'] );
			for ( $i = 0 ; $i < count( $npc_item_array ) ; $i++ )
			{
				$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
	   					WHERE item_id = '" . $item_id_array[$i] ."'
	   					    AND item_name = '" . $npc_item_array[$i] . "'
	   						AND item_owner_id = '$user_id'
		   					AND item_in_shop = '0'
			   				AND item_in_warehouse = '0'
						LIMIT 1 ";
				if ( !($result = $db->sql_query($sql)) )
	    		    message_die(GENERAL_ERROR, 'Could not query shop item information', '', __LINE__, __FILE__, $sql);
		    	$item_npc = $db->sql_fetchrowset($result);
				if ( count($item_npc) == 0 && ($npc_give_row['npc_kill_monster'] == "" or $npc_give_row['npc_kill_monster'] == '0'))
			        adr_item_quest_cheat_notification($user_id, $lang['Adr_zone_npc_cheating_type_1']);
			}
		}

		if ( adr_npc_check_times($npc_give_row['npc_id'], $adr_user['character_npc_check'], $npc_give_row['npc_times'] ) )
		{
			if ( !$npc_give_row['npc_quest_clue'] )
			{
				//Delete item(s) from character inventory
				for ( $i = 0 ; $i < count( $npc_item_array ) ; $i++ )
				{
					$delsql =  "DELETE FROM " . ADR_SHOPS_ITEMS_TABLE . "
								WHERE item_owner_id = '$user_id'
									AND item_id = '" . $item_id_array[$i] . "' ";
					if( !($aresult = $db->sql_query($delsql)) )
						message_die(GENERAL_ERROR, "Couldn't update inventory info", "", __LINE__, __FILE__, $asql);

					$sql5 = "SELECT * FROM " . ADR_QUEST_LOG_TABLE . "
						WHERE quest_item_need like '".$npc_item_array[$i].",%' 
						OR quest_item_need like '".$npc_item_array[$i]."'
						OR quest_item_need like '".$npc_item_array[$i].","."'
						OR quest_item_need like '%,".$npc_item_array[$i].",%'
						OR quest_item_need like '%,".$npc_item_array[$i]."'
						AND user_id = '$user_id'
						";
					$cresult = $db->sql_query($sql5);
					if( !$cresult )
				   		message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql5);
					if ( $got_item_log = $db->sql_fetchrow($cresult) )
						$got_item += 1;
        }
					
        if ($got_item == count( $npc_item_array ) && ($npc_give_row['npc_kill_monster'] == '0' || $npc_give_row['npc_kill_monster'] == ""))
        {
          //Copy Quest to the History
          $insertsql = "INSERT INTO " . ADR_QUEST_LOG_HISTORY_TABLE . "
            ( user_id, quest_killed_monster , quest_killed_monsters_amount , npc_id, quest_item_gave)
            VALUES ( '$user_id' , '".$npc_give_row['npc_kill_monster']."' , '".$npc_give_row['npc_monster_amount']."' , '". $npc_give_row['npc_id'] ."', '".$npc_give_row['npc_item']."' )";
          $result = $db->sql_query($insertsql);
          if( !$result )
            message_die(GENERAL_ERROR, "Couldn't insert finished quest", "", __LINE__, __FILE__, $insertsql);

          //Delete the Quest of the log
          $delsql2 = " DELETE FROM  " . ADR_QUEST_LOG_TABLE . "
            WHERE user_id = '$user_id'
            AND npc_id = '$npc_id'
";
          if( !($bresult = $db->sql_query($delsql2)) )
            message_die(GENERAL_ERROR, "Couldn't update questlog info", "", __LINE__, __FILE__, $delsql2);
        }
				if ($npc_give_row['npc_kill_monster'] != '0' && $npc_give_row['npc_kill_monster'] != "" && ($npc_give_row['quest_kill_monster_current_amount'] == $npc_give_row['npc_kill_monster_amount']))
				{
					//Copy Quest to the History
					$insertsql = "INSERT INTO " . ADR_QUEST_LOG_HISTORY_TABLE . "
						( user_id, quest_killed_monster , quest_killed_monsters_amount , npc_id, quest_item_gave)
						VALUES ( '$user_id' , '".$npc_give_row['npc_kill_monster']."' , '".$npc_give_row['npc_monster_amount']."' , '". $npc_give_row['npc_id'] ."', '".$npc_give_row['npc_item']."' )";
					$result = $db->sql_query($insertsql);
					if( !$result )
						message_die(GENERAL_ERROR, "Couldn't insert finished quest", "", __LINE__, __FILE__, $insertsql);
					
					//Delete the Quest of the log
					$delsql3 = " DELETE FROM  " . ADR_QUEST_LOG_TABLE . "
						AND user_id = '$user_id'
						AND npc_id = '$npc_id'
				   		";
					if( !($dresult = $db->sql_query($delsql3)) )
						message_die(GENERAL_ERROR, "Couldn't update questlog info", "", __LINE__, __FILE__, $delsql3);
				}
      }
      else
      {
        adr_substract_points( $user_id , $npc_give_row['npc_quest_clue_price'] , 'adr_zones' , '' );
        //Delete the Quest of the log
        $delsql2 = " DELETE FROM  " . ADR_QUEST_LOG_TABLE . "
			   		WHERE user_id = '$user_id'
					AND npc_id = '$npc_id'
			   		";
				if( !($bresult = $db->sql_query($delsql2)) )
					message_die(GENERAL_ERROR, "Couldn't update questlog info", "", __LINE__, __FILE__, $delsql2);

        // Insert empty values as the user paid for it all.
        $insertsql = "INSERT INTO " . ADR_QUEST_LOG_HISTORY_TABLE . "
        ( user_id, quest_killed_monster , quest_killed_monsters_amount , npc_id, quest_item_gave)
        VALUES ( '$user_id' , '' , '0' , '". $npc_give_row['npc_id'] ."', '' )";
        $result = $db->sql_query($insertsql);
        if( !$result )
          message_die(GENERAL_ERROR, "Couldn't insert finished quest", "", __LINE__, __FILE__, $insertsql);
			}

			//give points prize
			adr_add_points( $user_id , $npc_give_row['npc_points'] );

			//give exp and sp prize
			$sql = "UPDATE  " . ADR_CHARACTERS_TABLE . "
					SET character_xp = character_xp + '".$npc_give_row['npc_exp']."',
						character_sp = character_sp + '".$npc_give_row['npc_sp']."'
					WHERE character_id = '$user_id' ";
			if ( !($result = $db->sql_query($sql)) )
		        message_die(GENERAL_ERROR, 'Could not update character information', '', __LINE__, __FILE__, $sql);

			$prize_item = '';
			if ( $npc_give_row['npc_item2'] != "0" && $npc_give_row['npc_item2'] != "" )
			{
				$npc_item2_array = explode( ',' , $npc_give_row['npc_item2'] );
				for ( $i = 0 ; $i < count( $npc_item2_array ) ; $i++ )
				{
					adr_shop_insert_item($npc_item2_array[$i], adr_next_item_id($user_id), $user_id, 1, 0, 0, 'item_name');

					if ( count( $npc_item2_array ) == 1 )
						$prize_item .= adr_get_lang( $npc_item2_array[$i] ) ;
					else
					{
						if ( ( $i >= 1 ) && ( $i == ( count( $npc_item2_array ) + 1 ) ) )
							$prize_item .= ' and ' . adr_get_lang( $npc_item2_array[$i] ) ;
						else
							$prize_item .= ', ' . adr_get_lang( $npc_item2_array[$i] ) ;
					}
				}
				$prize_message = sprintf($lang['Adr_zone_npc_item_prize'], $npc_give_row['npc_name'] , $prize_item ) ;
			}

			//Insert Character in check field
			if( $npc_give_row['npc_times'] > 0 )
				adr_npc_check_times_insert( $adr_user['character_npc_check'] , $npc_give_row['npc_id'] , $user_id );
			//----

			$points_prize_lang = ( $npc_give_row['npc_points'] == 0 ) ? "" : sprintf( $lang['Adr_zone_npc_points_prize'] , number_format( intval( $npc_give_row['npc_points'] ) ) , $board_config['points_name'] ) ;
			$exp_prize_lang = ( $npc_give_row['npc_exp'] == 0 ) ? "" : sprintf( $lang['Adr_zone_npc_exp_prize'] , number_format( intval( $npc_give_row['npc_exp'] ) ) ) ;
			$sp_prize_lang = ( $npc_give_row['npc_sp'] == 0 ) ? "" : sprintf( $lang['Adr_zone_npc_sp_prize'] , number_format( intval( $npc_give_row['npc_sp'] ) ) ) ;
			$item_prize_lang = ( count( $npc_item2_array ) == 0 || $npc_give_row['npc_item2'] == "" ) ? "" : $prize_message;

			$message = "<img src=\"adr/images/zones/npc/" . $npc_give_row['npc_img'] . "\"><br /><br /><b>" . $npc_give_row['npc_name'] . ":</b> <i>\"" . $npc_give_row['npc_message2'] . "\"</i><br /><br />".$item_prize_lang."".$points_prize_lang."".$exp_prize_lang."".$sp_prize_lang."<br />" . $lang['Adr_zone_event_return'];
			$adr_zone_npc_title = sprintf( $lang['Adr_Npc_speaking_with'], $npc_give_row['npc_name'] );
			message_die(GENERAL_ERROR, $message , $adr_zone_npc_title , '' );
			break;
		}
		else
		{
			$message = "<img src=\"adr/images/zones/npc/" . $npc_give_row['npc_img'] . "\"><br /><br /><b>" . $npc_give_row['npc_name'] . ":</b> <i>\"" . $npc_give_row['npc_message2'] . "\"</i><br /><br />" . $lang['Adr_zone_event_return'];
			$adr_zone_npc_title = sprintf( $lang['Adr_Npc_speaking_with'], $npc_give_row['npc_name'] );
			message_die(GENERAL_ERROR, $message , $adr_zone_npc_title , '' );
			break;
		}
	}
}

function zone_npc_item_quest_check($npc_row)
{
	global $user_id, $db, $lang, $phpEx, $board_config;

	$npc_id = $npc_row['npc_id'];
  // V: moved this part at the beginning, so that we always insert the quest first and foremost.
  //    This fixes a "bug": say a quest requires item X, and you already have it before ever talking to the NPC - before this was moved, you'd need to talk to the NPC twice.
  //    (first to add the quest to your questlog, then to submit)
	if ( ($npc_row['npc_item'] != "0" && $npc_row['npc_item'] != "")
		|| ($npc_row['npc_kill_monster'] != "0" && $npc_row['npc_kill_monster'] != "" && $npc_row['npc_kill_monster_amount'] != "0"))
	{
		// Check if the character already has the Quest !
    // V: removed this part. I think we should only compare quests by npc_id,
    //    since NPCs can only have one quest.
    //    Completed quests have their own table anyway.
    /*
	   		WHERE (quest_item_need = '".$npc_row['npc_item']."'
				OR quest_kill_monster = '".$npc_row['npc_kill_monster']."')
     */
		$sql = " SELECT * FROM  " . ADR_QUEST_LOG_TABLE . "
			WHERE user_id = '$user_id'
			AND npc_id = '$npc_id'
	   		";
		$result = $db->sql_query($sql);
		if( !$result )
	   		message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql);
		if ( !($quest_log = $db->sql_fetchrow($result)) )
		{
			//Add the quest to the questlog
			$sql = "INSERT INTO " . ADR_QUEST_LOG_TABLE . "
				( user_id, quest_kill_monster , quest_kill_monster_amount , quest_kill_monster_current_amount , quest_item_have, quest_item_need, npc_id )
				VALUES ( '$user_id' , '".$npc_row['npc_kill_monster']."' , '".$npc_row['npc_monster_amount']."' , '0' , '', '". $npc_row['npc_item'] ."' , '". $npc_row['npc_id'] ."' )";
			$result = $db->sql_query($sql);
			if( !$result )
				message_die(GENERAL_ERROR, "Couldn't insert new quest", "", __LINE__, __FILE__, $sql);
		}
	}

	//[QUEST] Check if the NPC needs an item(s)
	if ( $npc_row['npc_item'] != "0" || $npc_row['npc_item'] != "" || $npc_row['npc_quest_clue'] )
	{
		if ( !$npc_row['npc_quest_clue'] )
		{
			$npc_item_array = explode( ',' , $npc_row['npc_item'] );
			$npc_item_list = '';
			$npc_item_id_list = '';
			$required_items = false;
			for ( $i = 0 ; $i < count( $npc_item_array ) ; $i++ )
			{
	 			// Check if user has the item
				$sql = "SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . "
			   			WHERE item_name = '" . $npc_item_array[$i] . "'
			   				AND item_owner_id = '$user_id'
   							AND item_in_shop = '0'
   							AND item_in_warehouse = '0'
						LIMIT 1 ";
				$result = $db->sql_query($sql);
				if( !$result )
			   		message_die( GENERAL_ERROR , 'Could not obtain required item information' , "" , __LINE__ , __FILE__ , $sql );
				if ( $item_npc = $db->sql_fetchrow($result) )
				{
					if ( ( count( $npc_item_array ) == 1 ) || ( $i == ( count( $npc_item_array ) - 1 ) ) )
					{
						if ( $i == ( count( $npc_item_array ) - 1 ) && $i != 0 )
							$npc_item_list .= ' et ' . adr_get_lang( $npc_item_array[$i] );
						else
							$npc_item_list .= adr_get_lang( $npc_item_array[$i] );
						$npc_item_id_list .= $item_npc['item_id'];
					}
					else
					{
						if ( $i != 0 )
							$npc_item_list .=  ', ';
						$npc_item_list .= adr_get_lang( $npc_item_array[$i] );
						$npc_item_id_list .= $item_npc['item_id'] . ',';
					}
				    $required_items = true;
				}
				else
				{
				    $required_items = false;
				    break;
				}
			}
			// Get Quest Info
			$sql = " SELECT * FROM  " . ADR_QUEST_LOG_TABLE . "
				WHERE user_id = '$user_id'
				AND npc_id = '$npc_id'";
			$result = $db->sql_query($sql);
			if( !$result )
	   		message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sql);
			
			if ( $quest_log = $db->sql_fetchrow($result))
			{
				if ( $required_items == true && ($npc_row['npc_kill_monster'] == '0' || $npc_row['npc_kill_monster'] == ""))
				{
					$give_lang = sprintf($lang['Adr_zone_npc_give_item'], $npc_item_list, $npc_row['npc_name']);
					$give = "<br /><br /><form method=\"post\" action=\"".append_sid("adr_zones.$phpEx")."\"><input type=\"hidden\" name=\"npc_id\" value=\"$npc_id\"><input type=\"hidden\" name=\"item_id\" value=\"".$npc_item_id_list."\"><input type=\"submit\" name=\"npc_give\" value=\"$give_lang\" class=\"mainoption\" /></form>";
				}
				elseif ( $required_items == true && $quest_log['quest_kill_monster_amount'] == $quest_log['quest_kill_monster_current_amount'])
				{
					$give_lang = sprintf($lang['Adr_zone_npc_give_item'], $npc_item_list, $npc_row['npc_name']);
					$give = "<br /><br /><form method=\"post\" action=\"".append_sid("adr_zones.$phpEx")."\"><input type=\"hidden\" name=\"npc_id\" value=\"$npc_id\"><input type=\"hidden\" name=\"item_id\" value=\"".$npc_item_id_list."\"><input type=\"submit\" name=\"npc_give\" value=\"$give_lang\" class=\"mainoption\" /></form>";
				}
			}
		}
		else
		{
			$give_lang = sprintf($lang['Adr_zone_npc_pay_price'], number_format( intval( $npc_row['npc_quest_clue_price'] ) ) . ' ' . $board_config['points_name'], $npc_row['npc_name']);
			$give = "<br /><br /><form method=\"post\" action=\"".append_sid("adr_zones.$phpEx")."\"><input type=\"hidden\" name=\"npc_id\" value=\"$npc_id\"><input type=\"hidden\" name=\"item_id\" value=\"0\"><input type=\"submit\" name=\"npc_give\" value=\"$give_lang\" class=\"mainoption\" /></form>";
		}
	}

	// Check if user has killed enough monsters
  // V: removed this part, since a NPC can only have a quest
  //    instead I added a count check
  /*
   		AND quest_kill_monster_current_amount = '".$npc_row['npc_monster_amount']."'
   */
	$sqlm3 = " SELECT * FROM  " . ADR_QUEST_LOG_TABLE . "
   		WHERE quest_kill_monster = '".$npc_row['npc_kill_monster']."'
		AND user_id = '$user_id'
		AND npc_id = '$npc_id'
    AND quest_kill_monster_current_amount < quest_kill_monster_amount
   		";
	$resultm3 = $db->sql_query($sqlm3);
	if( !$resultm3 )
   		message_die(GENERAL_ERROR, 'Could not obtain required quest information', "", __LINE__, __FILE__, $sqlm3);
	if ( $kills_npc = $db->sql_fetchrow($resultm3) )
	{
    // V: apparently, we check here an "EITHER OR", that is, validate EITHER if we gave the item (earlier this function),
    //    and here, we validate via mob kills ONLY if we don't also need an item.
    //    This needs refactored ASAP.
		if (($kills_npc['quest_item_need'] == '0' || $kills_npc['quest_item_need'] == ""))
		{
			$give_lang = sprintf($lang['Adr_zone_npc_complete_kill_quest'], $npc_row['npc_monster_amount'], adr_get_lang($npc_row['npc_kill_monster']));
			$give = "<br /><br /><form method=\"post\" action=\"".append_sid("adr_zones.$phpEx")."\"><input type=\"hidden\" name=\"npc_id\" value=\"$npc_id\"><input type=\"submit\" name=\"npc_give\" value=\"$give_lang\" class=\"mainoption\" /></form>";
		}
	}

	$message = "<img src=\"adr/images/zones/npc/" . $npc_row['npc_img'] . "\"><br /><br /><b>" . $npc_row['npc_name'] . ":</b><br/><div class='npc_dialog'>" . $npc_row['npc_message'] . "</div>$give<br /><br />" . $lang['Adr_zone_event_return'];
  $message .= '<link rel="stylesheet" type="text/css" href="' . $phpbb_root_path . 'templates/_shared/npc-dialog.css" />';
  $message .= '<script type="text/javascript" src="' . $phpbb_root_path . 'templates/_shared/npc-dialog.js"></script>';
	$adr_zone_npc_title = sprintf( $lang['Adr_Npc_speaking_with'], $npc_row['npc_name'] );
	message_die(GENERAL_MESSAGE, $message , $adr_zone_npc_title );
}
