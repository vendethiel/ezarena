<?php 
/***************************************************************************
 *					rabbitoshi_shop.php
 *				------------------------
 *	begin 			: 06/12/2003
 *	copyright			: Malicious Rabbit / Dr DLP
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
define('IN_RABBITOSHI', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true); 
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);


//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_RABBITOSHI); 
init_userprefs($userdata); 
// End session management
//
$user_id = $userdata['user_id'];
include($phpbb_root_path . 'language/lang_' . $board_config['default_lang'] . '/lang_rabbitoshi.'.$phpEx);

// Get the general settings
$adr_general = adr_get_general_config();
adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);

// Deny access if the user is into a battle
	$sql = "SELECT * 
			FROM  ". ADR_BATTLE_LIST_TABLE ." 
			WHERE battle_challenger_id = '$user_id'
			AND battle_result = '0'
			AND battle_type = '1'";
		if( !($result = $db->sql_query($sql)) )
			message_die(GENERAL_ERROR, 'Could not query battle list', '', __LINE__, __FILE__, $sql);
	
	$bat = $db->sql_fetchrow($result);
	
	if (is_numeric($bat['battle_id']))
		adr_previous( Adr_battle_progress , adr_battle , '' );

include($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/lang_adr.'.$phpEx);

if ( !$userdata['session_logged_in'] )
{
	$redirect = "rabbitoshi.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
$template->set_filenames(array(
	'body' => 'rabbitoshi_shop_body.tpl')
);
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$board_config['points_name'] = $board_config['points_name'] ? $board_config['points_name'] : $lang['Rabbitoshi_default_points_name'] ;

$user_id = $userdata['user_id'];
if ( empty($HTTP_GET_VARS[POST_USERS_URL])) 
{ 
	$view_userdata = $userdata; 
} 
else 
{ 
	$view_userdata = get_userdata($HTTP_GET_VARS[POST_USERS_URL]); 
} 
$searchid = $view_userdata['user_id'];
$points = $userdata['user_points'];

$sql = "SELECT * FROM  " . RABBITOSHI_USERS_TABLE . " 
WHERE owner_id = ".$view_userdata['user_id'];	
if (!$result = $db->sql_query($sql)) 
{
	message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
}
$rabbit_user = $db->sql_fetchrow($result);

$sql = "SELECT * FROM  " . RABBITOSHI_GENERAL_TABLE ; 
if (!$result = $db->sql_query($sql)) 
{
	message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
}
while( $row = $db->sql_fetchrow($result) )
{
	$rabbit_general[$row['config_name']] = $row['config_value'];
}

$shop_action = isset($HTTP_POST_VARS['shop_action']);

if ( $board_config['rabbitoshi_enable'] && $searchid == $user_id ) 
{
	if ( $shop_action )
	{
		$sql = "SELECT item_id
			FROM " . RABBITOSHI_SHOP_TABLE ."
			ORDER by item_id 
			DESC LIMIT 1";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain items pets information', "", __LINE__, __FILE__, $sql);
		}
		$max_items = $db->sql_fetchrow($result);
		$max = $max_items['item_id'];

		$sql = "SELECT item_prize , item_id
			FROM " . RABBITOSHI_SHOP_TABLE ."
			ORDER by item_id ";
		if( !$result = $db->sql_query($sql) )
		{
			message_die(GENERAL_ERROR, 'Could not obtain items pets information', "", __LINE__, __FILE__, $sql);
		}
		$items = $db->sql_fetchrowset($result);

		$prizee = 0;
		for ($i=0; $i <= $max ; $i++) 
		{
			$input = 'buy_item' . $i; 
			$$input = intval($HTTP_POST_VARS[$input]);
			$input2 = 'sell_item' . $i; 
			$$input2 = intval($HTTP_POST_VARS[$input2]);
			$price = (( $$input - $$input2 ) * ( $items[$i]['item_prize'] ));
			$prizee = 	$prizee + $price ;

			$item_id = $items[$i]['item_id'];
			if ( is_numeric($item_id) )
			{
				$usql = "SELECT item_amount
					FROM " . RABBITOSHI_SHOP_USERS_TABLE . "
					WHERE user_id = $user_id
					AND item_id =  $item_id ";
				if( !$uresult = $db->sql_query($usql))
				{
					message_die(GENERAL_ERROR, 'Could not obtain items pets information', "", __LINE__, __FILE__, $usql);
				}
				$item_data = $db->sql_fetchrow($uresult);

				if ( ($price > $points) && $price > 0 )
				{
					message_die( GENERAL_MESSAGE,'You don\'t have enough money to purchase all these items'.$lang['Rabbitoshi_general_return'] );
				}

				$amount = $item_data['item_amount'] ? $item_data['item_amount'] : 0 ;
				if ( $amount < ( $$input2 - $$input ))
				{
					message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_shop_lack_items'].$lang['Rabbitoshi_general_return'] );
				}
				else if (!(is_numeric($item_data['item_amount'])))
				{
					$item_amount = ( $$input - $$input2 );
					$isql = "INSERT INTO " . RABBITOSHI_SHOP_USERS_TABLE . "
						( user_id , item_id , item_amount )
						VALUES ( ".$user_id." , ".$item_id." , ".$item_amount." )";
					if( !$iresult = $db->sql_query($isql))
					{
						message_die(GENERAL_ERROR, 'Could not obtain insert items pets into db', "", __LINE__, __FILE__, $isql);
					}	
				}
				else
				{
					$item_amount = ( $$input - $$input2 );
					$isql = "UPDATE " . RABBITOSHI_SHOP_USERS_TABLE . "
						SET item_amount = item_amount + $item_amount 
						WHERE user_id = $user_id
						AND item_id = $item_id ";
					if( !$iresult = $db->sql_query($isql))
					{
						message_die(GENERAL_ERROR, 'Could not obtain insert items pets into db', "", __LINE__, __FILE__, $isql);
					}	
				}

				$psql = "UPDATE " . USERS_TABLE . "
					SET user_points = user_points - $price
					WHERE user_id = $user_id";
				if (!$db->sql_query($psql))
				{
					message_die(GENERAL_ERROR, "Could not update user's points", '', __LINE__, __FILE__, $psql);
				}
				$points = $points - $price ;
			}			
		}

		$prize = $prizee.'&nbsp;'.$board_config['points_name'];
		if ( $prizee > 0 )
		{
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_shop_action_plus'].$prize.$lang['Rabbitoshi_general_return'] );
		}
		else if ( $prizee != 0 )
		{
			$prizee = 0 - $prizee ;
			$prize = $prizee.'&nbsp;'.$board_config['points_name'];
			message_die( GENERAL_MESSAGE,$lang['Rabbitoshi_shop_action_less'].$prize.$lang['Rabbitoshi_general_return'] );
		}

	}

	$sql = "SELECT *
	FROM " . RABBITOSHI_SHOP_TABLE ."
	ORDER BY item_id";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain rabbitoshi_shops from database", "", __LINE__, __FILE__, $sql);
	}
	$rabbitoshi_shop = $db->sql_fetchrowset($result);
	$number_items = count($rabbitoshi_shop);
	for($k = 0; $k < $number_items ; $k++)
	{
		$buy_item[$k] = "";
		$buy_item[$k] = '<select name="buy_item'.$k.'" >';
		for( $i = 0; $i < 21; $i++ )
		{
			$buy_item[$k] .= '<option value="' . $i . '" >' . $i . '</option>';
		}
		$buy_item[$k] .= '</select>';

		$sell_item[$k] = "";
		$sell_item[$k] = '<select name="sell_item'.$k.'" >';
		for( $i = 0; $i < 21; $i++ )
		{
			$sell_item[$k] .= '<option value="' . $i . '" >' . $i . '</option>';
		}
		$sell_item[$k] .= '</select>';

		$usql = "SELECT item_amount
			FROM " . RABBITOSHI_SHOP_USERS_TABLE ."
			WHERE user_id = ".$userdata['user_id']."
			AND item_id = ".$rabbitoshi_shop[$k]['item_id'];
		$uresult = $db->sql_query($usql);
		if( !$uresult )
		{
			message_die(GENERAL_ERROR, "Couldn't obtain rabbitoshi_shops from database", "", __LINE__, __FILE__, $usql);
		}
		$rabbitoshi_shop_users = $db->sql_fetchrow($uresult);
		$amount = $rabbitoshi_shop_users['item_amount'] ? $rabbitoshi_shop_users['item_amount'] : 0 ;

		$item_desc = isset($lang[$rabbitoshi_shop[$k]['item_desc']]) ? $lang[$rabbitoshi_shop[$k]['item_desc']] : $rabbitoshi_shop[$k]['item_desc'];
		$item_name = isset($lang[$rabbitoshi_shop[$k]['item_name']]) ? $lang[$rabbitoshi_shop[$k]['item_name']] : $rabbitoshi_shop[$k]['item_name'];
		$row_color = ( !($k % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($k % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$pic = $rabbitoshi_shop[$k]['item_img'];
		if (!(file_exists("images/Rabbitoshi/$pic")) || !$pic )
		{
			$pic = $rabbitoshi_shop[$k]['item_name'].'.gif';
		}

		$template->assign_block_vars('items', array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"NAME" =>  $item_name, 
			"PRIZE" =>  $rabbitoshi_shop[$k]['item_prize'],
			"IMG" =>  $pic,
			"BUY" =>  $buy_item[$k],
			"SELL" =>  $sell_item[$k],
			"SUM" => $amount,
			"DESC" =>  $item_desc)			
		);
	}
}

$template->assign_vars(array(
	'L_PUBLIC_TITLE' => $lang['Rabbitoshi_Shop'],
	'L_RETURN' => $lang['Rabbitoshi_shop_return'],
	'L_OWNER_POINTS' => $lang['Rabbitoshi_owner_points'],
	'L_POINTS'         => $board_config['points_name'],
	'L_NAME' 		 => $lang['Rabbitoshi_shop_name'],
	'L_PRIZE' 		 => $lang['Rabbitoshi_shop_prize'],
	'L_DESC' 		 => $lang['Rabbitoshi_item_desc'],
	'L_SUM' 		 => $lang['Rabbitoshi_item_sum'],
	'L_PIC' 		 => $lang['Rabbitoshi_shop_img'],
	'L_ACTION' 		 => $lang['Rabbitoshi_shop_action'],
	'L_BUY'		 => $lang['Rabbitoshi_shop_buy'],
	'L_SELL'		 => $lang['Rabbitoshi_shop_sell'],
	'L_TRANSLATOR'     => $lang['Rabbitoshi_translation'],
	'L_PET_GENERAL_MESSAGE' => $lang['Rabbitoshi_general_message'],
	'L_PET_MESSAGE'    => $lang['Rabbitoshi_message'],
	'PET_GENERAL_MESSAGE' => $thought,
	'PET_MESSAGE'      => $message,
	'POINTS'           => $userdata['user_points'],
	'NUMBER_ITEMS'     => $number_items ,
	'S_PET_ACTION'     => append_sid("rabbitoshi_shop.$phpEx"),
	'S_PET_RETURN'     => append_sid("rabbitoshi.$phpEx"),
	'S_HIDDEN_FIELDS'	 => $s_hidden_fields,
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 