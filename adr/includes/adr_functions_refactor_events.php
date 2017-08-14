<?php
function event_trigger_get_points($zone)
{
	global $userdata, $lang;

	//Define money value
	$win = rand( $zone['zone_pointwin1'] , $zone['zone_pointwin2'] );

	adr_add_points( $userdata['user_id'] , $win );

	$message = '<img src="adr/images/zones/get_money.gif"><br /><br />' . $lang['Adr_zone_event_winpoint'] . ' ' . $win . ' ' . $board_config['points_name'] . '<br /><br />' . $lang['Adr_zone_event_return'] . '<br /><br />';
	message_die(GENERAL_ERROR, $message , 'Zones' , '' );
}

function event_trigger_lose_points($zone)
{
	global $userdata, $lang;

	$loss = rand( $zone['zone_pointloss1'] , $zone['zone_pointloss2'] );

	if ( $loss > $userdata['user_points'] ) $loss = ( $userdata['user_points'] / 2 );

	adr_substract_points( $userdata['user_id'] , $loss , adr_zones , '' );

	$message = '<img src="adr/images/zones/loss_money.gif"><br /><br />' . $lang['Adr_zone_event_losspoint'] . ' ' . $loss . ' ' . $board_config['points_name'] . '<br /><br />' . $lang['Adr_zone_event_return'] . '<br /><br />';
	message_die(GENERAL_ERROR, $message , 'Zones' , '' );
}

function event_trigger_fountain_youth($zone)
{
	global $user_id, $db, $lang;

	//Update character health
	$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
		SET character_hp = character_hp_max
		WHERE character_id = '$user_id' ";
	if( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);
	$db->sql_freeresult($event);

	$message = '<img src="adr/images/zones/fountain_of_youth.gif"><br /><br />' . $lang['Adr_zone_event_fountain_youth'] . '<br /><br />' . $lang['Adr_zone_event_return'] . '<br /><br />';
	message_die(GENERAL_ERROR, $message , 'Zones' , '' );
}

function event_trigger_fountain_mana($zone)
{
	global $user_id, $db, $lang;

	//Update character mp
	$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
		SET character_mp = character_mp_max
		WHERE character_id = '$user_id' ";
	if( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);
	$db->sql_freeresult($result);

	$message = '<img src="adr/images/zones/fountain_of_mana.gif"><br /><br />' . $lang['Adr_zone_event_fountain_mana'] . '<br /><br />' . $lang['Adr_zone_event_return'] . '<br /><br />';
	message_die(GENERAL_ERROR, $message , 'Zones' , '' );
}

function event_trigger_poisoned($zone)
{
	global $user_id, $db, $lang;

	//Update character hp
	$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
		SET character_hp = '1'
		WHERE character_id = '$user_id' ";
	if( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);
	$db->sql_freeresult($result);

	$message = '<img src="adr/images/zones/poisonned.gif"><br /><br />' . $lang['Adr_zone_event_poison'] . '<br /><br />' . $lang['Adr_zone_event_return'] . '<br /><br />';
	message_die(GENERAL_ERROR, $message , 'Zones' , '' );
}

function event_trigger_weakness($zone)
{
	global $user_id, $db, $lang;

	//Update character mp
	$sql = " UPDATE  " . ADR_CHARACTERS_TABLE . " 
		SET character_mp = '0'
		WHERE character_id = '$user_id' ";
	if( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, 'Could not update character zone', '', __LINE__, __FILE__, $sql);
	$db->sql_freeresult($result);

	$message = '<img src="adr/images/zones/weakness.gif"><br /><br />' . $lang['Adr_zone_event_weakness'] . '<br /><br />' . $lang['Adr_zone_event_return'] . '<br /><br />';
	message_die(GENERAL_ERROR, $message , 'Zones' , '' );
}

function event_trigger_get_item($zone)
{
	global $area_id, $db, $lang, $user_id;

	//Select zone specific items
	$sql = " SELECT * FROM  " . ADR_SHOPS_ITEMS_TABLE . " 
		WHERE item_owner_id = '1'
		AND ( item_zone = '$area_id' || item_zone = '0' )
		ORDER BY rand() LIMIT 1 ";
	if( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	$new_item				= $db->sql_fetchrow($result);
	$db->sql_freeresult($result);

	if (!$new_item)
	{
		return;
	}

	adr_shop_insert_item($new_item['item_id'], adr_next_item_id($user_id), $user_id, 1);
	$item_name = $new_item['item_name'];
	$message = '<img src="adr/images/zones/get_item.gif"><br /><br />' . $lang['Adr_zone_event_item'] . '<br /><br /><b>' . $item_name . '</b><br /><br /><img src="adr/images/items/' . $item_icon . '"><br /><br />' . $item_desc . '<br /><br />' . $lang['Adr_zone_event_return'] . '<br /><br />';
	message_die(GENERAL_ERROR, $message , 'Zones' , '' );
}

function event_trigger_ambush($zone)
{
	global $userdata, $lang, $user_id;

	//Define money value
	$loss = rand( $zone['zone_pointloss1'] , $zone['zone_pointloss2'] );

	if ( $loss > $userdata['user_points'] ) $loss =  $userdata['user_points'];

	adr_substract_points( $user_id , $loss , 'adr_zones' , '' );

	$message = '<img src="adr/images/zones/ambush.gif"><br /><br />' . $lang['Adr_zone_event_ambush'] . ' ' . $loss . ' ' . $board_config['points_name'] . '<br /><br />' . $lang['Adr_zone_event_battle'] . '<br />' . $lang['Adr_zone_event_return'] . '<br /><br />';
	message_die(GENERAL_ERROR, $message , 'Zones' , '' );
}
