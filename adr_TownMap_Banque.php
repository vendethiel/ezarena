<?php 
/***************************************************************************
 *				adr_Townmap_Banque.php
 *				------------------------
 *	begin 			: 21/11/2004
 *	copyright			: One_Piece
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
define('IN_TOWNMAP_INFOBOX', true);
define('IN_TOWNMAP_BANQUE', true);
define('IN_TOWNMAP_COPYRIGHT', true);
define('IN_ADR_TOWNMAP', true);
define('IN_ADR_VAULT', true); 
define('IN_ADR_BATTLE', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'town';
$sub_loc = 'adr_TownMap_Banque';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_TownMap_Banque.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header and season choice
adr_template_file('adr_TownMap_Banque_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

$user_id = $userdata['user_id'];
$points = $userdata['user_points'];

$saison = 'Carte' . $board_config['adr_seasons'];


// Get the general settings
$vault_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
// Deny access if user is imprisioned
if($userdata['user_cell_time']){
	adr_previous(Adr_shops_no_thief, adr_cell, '');}

// Define the actions
$open = isset($HTTP_POST_VARS['open']);
$close = isset($HTTP_POST_VARS['close']);
$deposit = isset($HTTP_POST_VARS['deposit']);
$withdraw = isset($HTTP_POST_VARS['withdraw']);
$loan = isset($HTTP_POST_VARS['loan']);
$loan_back = isset($HTTP_POST_VARS['loan_back']);
$preferences = isset($HTTP_POST_VARS['preferences']);
$list = isset($HTTP_POST_VARS['list']);
$stock_exchange = isset($HTTP_POST_VARS['stock_exchange']);
$deposit_sum = intval($HTTP_POST_VARS['deposit_sum']);
$withdraw_sum = intval($HTTP_POST_VARS['withdraw_sum']);
$due_off = isset($HTTP_POST_VARS['due_payoff']);
$loan_sum = intval($HTTP_POST_VARS['loan_sum']);
$exchange_submit = isset($HTTP_POST_VARS['exchange_submit']);

if(isset($HTTP_POST_VARS['from']))
{
	$stock_exchange = ($HTTP_POST_VARS['from'] == 'pm') ? TRUE : FALSE;
	$list = ($HTTP_POST_VARS['from'] == 'list') ? TRUE : FALSE;
}
else if(isset($HTTP_GET_VARS['from']))
{
	$stock_exchange = ($HTTP_GET_VARS['from'] == 'pm') ? TRUE : FALSE;
	$list = ($HTTP_GET_VARS['from'] == 'list') ? TRUE : FALSE;
}

if ( $due_off )
{
	$due = intval($HTTP_POST_VARS['due']);

	if ( $due > $userdata['user_points'] ) 
	{
		adr_previous( Adr_vault_loan_lack_points , adr_vault , '' );
	}

	$sql = "UPDATE " . USERS_TABLE ."
		SET user_points = user_points - $due 
		WHERE user_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . ADR_VAULT_USERS_TABLE ."
		SET loan_sum = 0 ,
		loan_time = 0
		WHERE owner_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}

	$sql = "DELETE FROM " . ADR_VAULT_BLACKLIST_TABLE . " 
		WHERE user_id = " . $user_id;
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't delete user into black list", "", __LINE__, __FILE__, $sql);
	}
	adr_previous( Adr_vault_due_ok , adr_vault , '' );
}

$sql = "SELECT * FROM " . ADR_VAULT_USERS_TABLE . "
	WHERE owner_id = $user_id ";
if ( !($result = $db->sql_query($sql)) ) 
{ 
	message_die(CRITICAL_ERROR, 'Error Getting Vault Users!'); 
}
$vault = $db->sql_fetchrow($result);

if ( $vault['loan_time'] != 0 )
{
	if ( ($vault_general['loan_interests_time'] - ( time() - $vault['loan_time'])) < 0 )
	{
		$loan = $vault['loan_sum'] * ( 1 + ( $vault_general['loan_interests'] / 100 ));
		$due = ceil($loan * ( 1 + ( $vault_general['loan_interests'] / 100 )));

		$sql = "SELECT * FROM  " . ADR_VAULT_BLACKLIST_TABLE . "
			WHERE user_id = ".$user_id; 
		if (!$result = $db->sql_query($sql)) 
		{
			message_die(CRITICAL_ERROR, 'Error Getting Vault black list!');
		}
		$black = $db->sql_fetchrow($result);
		
		if ( !(is_numeric($black['user_due'])) )
		{
			$sql = "INSERT INTO  " . ADR_VAULT_BLACKLIST_TABLE . " ( user_id , user_due ) VALUES ( $user_id , $due ) ";
			if (!$result = $db->sql_query($sql)) 
			{
				message_die(CRITICAL_ERROR, 'Error Getting Vault black list!');
			}
		}
		else
		{
			$due = $black['user_due'];
		}
		$is_black = TRUE ;
		$template->assign_block_vars( 'blacked' , array());
	}
}

if ( $is_black != TRUE )
{
	if ( !(is_numeric($vault['account_id'])) ) 
	{
		$template->assign_block_vars( 'no_account' , array());
	}
	else
	{
		$template->assign_block_vars( 'account' , array());
		if ( $vault_general['vault_loan_enable'] )
		{
			$template->assign_block_vars( 'account.loan_authed' , array());
			if ( $vault['loan_sum'] != 0 ) 
			{
				$template->assign_block_vars( 'account.loan_authed.active_loan' , array());
			}
			else if ( $userdata['user_posts'] < $vault_general['loan_requirements'] ) 
			{
				$template->assign_block_vars( 'account.loan_authed.no_loan' , array());
			}
			else
			{
				$template->assign_block_vars( 'account.loan_authed.loan' , array());
			}
		}
		if ( $board_config['stock_use'] )
		{
			$template->assign_block_vars( 'account.stock' , array());
		}
	}
}

$account_time = time() - $vault['account_time'];
if ( $account_time > $vault_general['interests_time'] )
{
	$interests_mult = floor ( $account_time / $vault_general['interests_time']);
	$mult = 1 + ( $vault_general['interests_rate'] / 100 );
	$puissance = 1 + (( $vault_general['interests_rate'] / 100 ) * $interests_mult);
	$account_interests = floor ( $puissance * $vault['account_sum'] ); 
	$sup_time = floor( $vault['account_time'] + ( $vault_general['interests_time'] * $interests_mult ));

	$sql = "UPDATE " . ADR_VAULT_USERS_TABLE ."
		SET account_sum = $account_interests ,
		account_time = ".$sup_time."
		WHERE owner_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}

}

if ( $open )
{
	$sql = "SELECT account_id FROM " . ADR_VAULT_USERS_TABLE ."
		ORDER BY account_id 
		DESC LIMIT 1";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}
	$max = $db->sql_fetchrow($result);
	$account_id = $max['account_id'] + 1 ;

	$sql = "INSERT INTO " . ADR_VAULT_USERS_TABLE . " ( owner_id , account_id , account_sum , account_time , loan_sum , loan_time)
		VALUES ( $user_id , $account_id , 0 ,  '" . time() . "' ,  0 , 0 )";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't insert new account", "", __LINE__, __FILE__, $sql);
	}
	adr_previous( Adr_vault_account_opened, adr_vault , '' );
}

if ( $close )
{
	$loan = ( $vault['loan_sum'] > 0 ) ? ( $vault['loan_sum'] * ( 1 + ( $vault_general['loan_interests'] / 100 ))) : 0;
	$sql = "DELETE FROM " . ADR_VAULT_USERS_TABLE ."
		WHERE owner_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . USERS_TABLE ."
		SET user_points = user_points + ".$vault['account_sum']." - $loan 
		WHERE user_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}

	$sql = "SELECT * FROM " . ADR_VAULT_EXCHANGE_USERS_TABLE . "
		WHERE user_id = " . $user_id;
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't delete stock", "", __LINE__, __FILE__, $sql);
	}
	$users = $db->sql_fetchrowset($result);

	for ( $i = 0 ; $i < count ( $users ) ; $i ++ )
	{
		$ssql = "SELECT stock_price FROM " . ADR_VAULT_EXCHANGE_TABLE . "
			WHERE stock_id = " . $users[$i]['stock_id'];
			$sresult = $db->sql_query($ssql);
		if( !$sresult )
		{
			message_die(GENERAL_ERROR, "Couldn't delete stock", "", __LINE__, __FILE__, $ssql);
		}
		$prize = $db->sql_fetchrow($sresult);
		$price = $prize['stock_price'] * $users[$i]['stock_amount'];
		$usql = "UPDATE " . USERS_TABLE . "
			SET user_points = user_points + $price 
			WHERE user_id =  ".$users[$i]['user_id'];
		$uresult = $db->sql_query($usql);
		if( !$uresult )
		{
			message_die(GENERAL_ERROR, "Couldn't delete stock", "", __LINE__, __FILE__, $usql);
		}
	}
	$sql = "DELETE FROM " . ADR_VAULT_EXCHANGE_USERS_TABLE . " 
		WHERE user_id = " . $user_id;
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't delete stock", "", __LINE__, __FILE__, $sql);
	}
	adr_previous( Adr_vault_account_closed, adr_vault , '' );
}

if ( $exchange_submit )
{
	$sql = "SELECT *
		FROM " . ADR_VAULT_EXCHANGE_TABLE ."
		ORDER BY stock_id 
		DESC LIMIT 1";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain stock exchange information', "", __LINE__, __FILE__, $sql);
	}
	$stock_data = $db->sql_fetchrow($result);
	$max = $stock_data['stock_id'];

	for ($i=0; $i <= $max; $i++) 
	{ 
		$input = 'buy_item' . $i; 
		$$input = intval($HTTP_POST_VARS[$input]);
		$input2 = 'sell_item' . $i; 
		$$input2 = intval($HTTP_POST_VARS[$input2]);
	}
	$sql = "SELECT stock_price , stock_id FROM " . ADR_VAULT_EXCHANGE_TABLE ." 
		ORDER BY stock_id";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, 'Could not obtain items shares information', "", __LINE__, __FILE__, $sql);
	}
	$items = $db->sql_fetchrowset($result);
	for ( $i = 0 ; $i < count($items) ; $i ++ )
	{
		$price = 0;
		$a = $items[$i]['stock_id'] ;
		$buys = 'buy_item'.$items[$i]['stock_id'].'';
		$buy = $$buys;
		$sells = 'sell_item'.$items[$i]['stock_id'].'';
		$sell = $$sells;
		$price = ( ( $buy -  $sell ) * $items[$i]['stock_price'] );

		$ssql = "SELECT stock_amount FROM " . ADR_VAULT_EXCHANGE_USERS_TABLE ." 
		WHERE stock_id = ".$items[$i]['stock_id']."
		AND user_id = ".$user_id;
		$sresult = $db->sql_query($ssql);
		if( !$sresult )
		{
			message_die(GENERAL_ERROR, 'Could not obtain items pets information', "", __LINE__, __FILE__, $ssql);
		}
		$user_items = $db->sql_fetchrow($sresult);

		if ( (( $sell - $buy ) > $user_items['stock_amount'] && is_numeric($user_items['stock_amount'])) || ( !(is_numeric($user_items['stock_amount'])) && (( $buy - $sell ) < 0) ) )

		{
			adr_previous( Adr_vault_stock_lack , adr_vault , '' );
		}
		if ( $price > $userdata['user_points'])
		{
			adr_previous( Adr_vault_points_lack, adr_vault , '' );
		}
		else
		{
			$sql = "UPDATE " . USERS_TABLE ."
				SET user_points = user_points - $price
				WHERE user_id = $user_id";
			if( !$db->sql_query($sql))
			{
				message_die(GENERAL_ERROR, 'Could not obtain update user points', "", __LINE__, __FILE__, $sql);
			}
		}
		$userdata['user_points'] = $userdata['user_points'] - $price;

		$prize = $buy -  $sell;
		if ( is_numeric($user_items['stock_amount']) &&	$prize != 0 )
		{
			$rsql = "UPDATE " . ADR_VAULT_EXCHANGE_USERS_TABLE ."
				SET stock_amount = stock_amount + $prize
				WHERE user_id = $user_id
				AND stock_id = ".$items[$i]['stock_id'];
			if( !$db->sql_query($rsql))
			{
				message_die(GENERAL_ERROR, 'Could not update user stock', "", __LINE__, __FILE__, $rsql);
			}
		}
		else if ( !(is_numeric($user_items['stock_amount'])) && $prize != 0 )
		{
			$rsql = "INSERT INTO " . ADR_VAULT_EXCHANGE_USERS_TABLE ."
				( stock_id , user_id , stock_amount )
				VALUES ( ".$items[$i]['stock_id']." , $user_id , $prize )";
			if( !$db->sql_query($rsql))
			{
				message_die(GENERAL_ERROR, 'Could not update user stock', "", __LINE__, __FILE__, $rsql);
			}
		}
	}
	$stock_exchange = TRUE;	

}

if ( $stock_exchange )
{
	adr_template_file('adr_vault_exchange_body.tpl');

	$sql = "SELECT *
		FROM " . ADR_VAULT_EXCHANGE_TABLE ."
		ORDER BY stock_id ";
	$result = $db->sql_query($sql);
	if( !$result )
	{
		message_die(GENERAL_ERROR, "Couldn't obtain stock exchange from database", "", __LINE__, __FILE__, $sql);
	}
	$exchange = $db->sql_fetchrowset($result);

	for($i = 0; $i < count($exchange); $i++)
	{
		$a = $exchange[$i]['stock_id']; 
		$buy_item[$a] = "";
		$buy_item[$a] = '<select name="buy_item'.$a.'" >';
		for( $k = 0; $k < 51; $k++ )
		{
			$buy_item[$a] .= '<option value="' . $k . '" >' . $k . '</option>';
		}
		$buy_item[$a] .= '</select>';

		$sell_item[$a] = "";
		$sell_item[$a] = '<select name="sell_item'.$a.'" >';
		for( $l = 0; $l < 51; $l++ )
		{
			$sell_item[$a] .= '<option value="' . $l . '" >' . $l . '</option>';
		}
		$sell_item[$a] .= '</select>';

		$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
		$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$sql = "SELECT * FROM " . ADR_VAULT_EXCHANGE_USERS_TABLE ."
			WHERE stock_id = ".$exchange[$i]['stock_id']."
			AND user_id = ".$user_id;
		$result = $db->sql_query($sql);
		if( !$result )
		{
			message_die(GENERAL_ERROR, "Couldn't obtain stock exchange from database", "", __LINE__, __FILE__, $sql);
		}
		$owned = $db->sql_fetchrow($result);
		$actions_owned = $owned['stock_amount'];
		if ( !$actions_owned )
		{
			$actions_owned = $lang['Adr_vault_exchange_none'];
		}
		$stock_name = adr_get_lang($exchange[$i]['stock_name']);
		$stock_desc = adr_get_lang($exchange[$i]['stock_desc']);

		$template->assign_block_vars("exchange", array(
			"ROW_COLOR" => "#" . $row_color,
			"ROW_CLASS" => $row_class,
			"STOCK_NAME" =>  $stock_name, 
			"STOCK_DESC" =>  $stock_desc , 
			"STOCK_AMOUNT" =>  $exchange[$i]['stock_price'], 
			"STOCK_PREVIOUS" =>  $exchange[$i]['stock_previous_price'], 
			"STOCK_WORST" =>  $exchange[$i]['stock_worst_price'], 
			"STOCK_BEST" =>  $exchange[$i]['stock_best_price'], 
			"STOCK_BUY" =>  $buy_item[$a],
			"STOCK_SELL" =>  $sell_item[$a],
			"STOCK_OWNED" =>  $actions_owned)
		);
	}
	$template->assign_vars(array(
		'L_STOCK_EXCHANGE_ACTIONS' => $lang['Adr_vault_exchange_actions'],
		'L_STOCK_NAME' => $lang['Adr_vault_exchange_actions_name'],
		'L_STOCK_DESC' => $lang['Adr_vault_exchange_actions_desc'],
		'L_STOCK_AMOUNT' => $lang['Adr_vault_exchange_actions_amount'],
		'L_STOCK_PREVIOUS' => $lang['Adr_vault_exchange_previous_price'],
		'L_STOCK_WORST' => $lang['Adr_vault_exchange_worst_price'],
		'L_STOCK_BEST' => $lang['Adr_vault_exchange_best_price'],
		'L_STOCK_OWNED' => $lang['Adr_vault_exchange_owned'],
		'L_STOCK_BUY'  => $lang['Adr_vault_exchange_buy'],
		'L_STOCK_SELL'  => $lang['Adr_vault_exchange_sell'],
		'L_SUBMIT' => $lang['Submit'],
	));
}

if ( $list )
{
	adr_template_file('adr_vault_list_body.tpl');

	if ( $board_config['stock_use'] )
	{
		$template->assign_block_vars( 'stock' , array());
	}

	$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;

	if ( isset($HTTP_GET_VARS['mode']) || isset($HTTP_POST_VARS['mode']) )
	{
		$mode = ( isset($HTTP_POST_VARS['mode']) ) ? htmlspecialchars($HTTP_POST_VARS['mode']) : htmlspecialchars($HTTP_GET_VARS['mode']);
	}
	else
	{
		$mode = 'username';
	}

	if(isset($HTTP_POST_VARS['order']))
	{
		$sort_order = ($HTTP_POST_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else if(isset($HTTP_GET_VARS['order']))
	{
		$sort_order = ($HTTP_GET_VARS['order'] == 'ASC') ? 'ASC' : 'DESC';
	}
	else
	{
		$sort_order = 'ASC';
	}

	$mode_types_text = array( $lang['Sort_Username'], $lang['Adr_vault_account_amount'],$lang['Adr_vault_loan_amount']);
	$mode_types = array('username', 'account', 'loan');

	$select_sort_mode = '<select name="mode">';
	for($i = 0; $i < count($mode_types_text); $i++)
	{
		$selected = ( $mode == $mode_types[$i] ) ? ' selected="selected"' : '';
		$select_sort_mode .= '<option value="' . $mode_types[$i] . '"' . $selected . '>' . $mode_types_text[$i] . '</option>';
	}
	$select_sort_mode .= '</select>';

	$select_sort_order = '<select name="order">';
	if($sort_order == 'ASC')
	{
		$select_sort_order .= '<option value="ASC" selected="selected">' . $lang['Sort_Ascending'] . '</option><option value="DESC">' . $lang['Sort_Descending'] . '</option>';
	}
	else
	{
		$select_sort_order .= '<option value="ASC">' . $lang['Sort_Ascending'] . '</option><option value="DESC" selected="selected">' . $lang['Sort_Descending'] . '</option>';
	}	
	$select_sort_order .= '</select>';

	switch( $mode )
	{
		case 'username':
			$order_by = "u.username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'account':
			$order_by = "v.account_sum $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		case 'loan':
			$order_by = "v.loan_sum $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
		default:
			$order_by = "u.username $sort_order LIMIT $start, " . $board_config['topics_per_page'];
			break;
	}
	$sql = "SELECT u.username, u.user_id, v.*  
		FROM " . USERS_TABLE . " u , " . ADR_VAULT_USERS_TABLE . " v
		WHERE u.user_id = v.owner_id 
		AND u.user_id > 0
		ORDER BY $order_by";
	if( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not query users', '', __LINE__, __FILE__, $sql);
	}

	if ( $row = $db->sql_fetchrow($result) )
	{
		$i = 0;
		do
		{
			$username = $row['username'];
			$user_id = $row['user_id'];
			$account_sum = ( $row['account_protect'] && $row['user_id'] != $userdata['user_id'] ) ? $lang['Adr_vault_confidential'] : $row['account_sum'];
			$row['loan_sum'] = ( $row['loan_sum'] != 0 ) ? $row['loan_sum'] : $lang['Adr_vault_loan_none'];
			$loan_sum = ( $row['loan_protect'] && $row['user_id'] != $userdata['user_id'] ) ? $lang['Adr_vault_confidential'] : $row['loan_sum'];

			$profile_img = '<img src="' . $images['icon_profile'] . '" alt="' . $lang['Read_profile'] . '" title="' . $lang['Read_profile'] . '" border="0" />';


			$row_color = ( !($i % 2) ) ? $theme['td_color1'] : $theme['td_color2'];
			$row_class = ( !($i % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

			$template->assign_block_vars('vault_users', array(
				'ROW_NUMBER' => $i + ( $HTTP_GET_VARS['start'] + 1 ),
				'ROW_COLOR' => '#' . $row_color,
				'ROW_CLASS' => $row_class,
				'USERNAME' => $username ,
				'ACCOUNT' => $account_sum ,
				'LOAN' => $loan_sum,
				'PROFILE_IMG' => $profile_img, 
			
				'U_VIEWPROFILE' => append_sid("adr_character.$phpEx?" . POST_USERS_URL ."=".$row['user_id']))
			);

			$i++;
		}
		while ( $row = $db->sql_fetchrow($result) );
	}
	$sql = "SELECT count(*) AS total FROM " . ADR_VAULT_USERS_TABLE;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Error getting total users', '', __LINE__, __FILE__, $sql);
	}

	if ( $total = $db->sql_fetchrow($result) )
	{
		$total_members = $total['total'];
		$pagination = generate_pagination("adr_vault.$phpEx?from=list&amp;mode=$mode&amp;order=$sort_order", $total_members, $board_config['topics_per_page'], $start). '&nbsp;';
	}

	$template->assign_vars(array(
		'L_SUBMIT' => $lang['Submit'],
		'L_ON_ACCOUNT' => $lang['Adr_vault_account_amount'],
		'L_ON_LOAN' => $lang['Adr_vault_loan_amount'],
		'L_SELECT_SORT_METHOD' => $lang['Select_sort_method'],
		'S_MODE_SELECT' => $select_sort_mode,
		'S_ORDER_SELECT' => $select_sort_order,
		'PAGINATION' => $pagination,
		'PAGE_NUMBER' => sprintf($lang['Page_of'], ( floor( $start / $board_config['topics_per_page'] ) + 1 ), ceil( $total_members / $board_config['topics_per_page'] )), 
		'L_GOTO_PAGE' => $lang['Goto_page'],
	));
}

if ( $deposit && $deposit_sum > 0 )
{
	if ( $deposit_sum > $userdata['user_points'] )
	{
		adr_previous( Adr_vault_deposit_lack, adr_vault , '' );
	}
	$sql = "UPDATE " . ADR_VAULT_USERS_TABLE ."
		SET account_sum = account_sum + $deposit_sum 
		WHERE owner_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . USERS_TABLE ."
		SET user_points = user_points - $deposit_sum 
		WHERE user_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}
	adr_previous( Adr_vault_account_ok, adr_vault , '' );
}

if ( $withdraw && $withdraw_sum > 0 )
{
	if ( $withdraw_sum > $vault['account_sum'] )
	{
		adr_previous( Adr_vault_withdraw_lack, adr_vault , '' );
	}
	$sql = "UPDATE " . ADR_VAULT_USERS_TABLE ."
		SET account_sum = account_sum - $withdraw_sum 
		WHERE owner_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . USERS_TABLE ."
		SET user_points = user_points + $withdraw_sum 
		WHERE user_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}
	adr_previous( Adr_vault_account_ok, adr_vault , '' );

}

if ( $loan && $loan_sum > 0 )
{
	if ( !is_numeric( $vault['owner_id'] ))
	{
		// Send admin PM notification of attempted cheating...
		$member_id = 2;
		$subject = $lang['Adr_report_pm_sub'];	
		$message = sprintf($lang['Adr_report_pm_msg2'] , $userdata['username']);

		adr_send_pm ( $member_id , $subject , $message );
		adr_previous ( Adr_vault_cheater , 'adr_vault' , '' );					
	}

	if ( $vault['loan_sum'] != 0 ) 
	{
		adr_previous( Adr_vault_loan_no_double, adr_vault , '' );
	}
	if ( $userdata['user_posts'] < $vault_general['loan_requirements'] || $vault['loan_sum'] != 0 ) 
	{
		$message = $lang['Adr_vault_loan_no_explain'].$vault_general['loan_requirements'].$lang['Posts'];
		$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . append_sid("adr_vault.$phpEx") . "\">", "</a>");
		message_die( GENERAL_MESSAGE,$message);
	}
	if ( $loan_sum > $vault_general['loan_max_sum'] || $loan_sum < 0 ) 
	{
		adr_previous( Adr_vault_loan_no_such , adr_vault , '' );
	}

	$sql = "UPDATE " . USERS_TABLE ."
		SET user_points = user_points + $loan_sum 
		WHERE user_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . ADR_VAULT_USERS_TABLE ."
		SET loan_sum = $loan_sum ,
		loan_time = ".time()."
		WHERE owner_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}

	$message = $lang['Adr_vault_loan_ok'].$loan_sum.'&nbsp;'.$board_config['points_name'];
	$message .= '<br /><br />'.sprintf($lang['Adr_return'],"<a href=\"" . append_sid("adr_vault.$phpEx") . "\">", "</a>");
		
	message_die( GENERAL_MESSAGE,$message);
}

if ( $loan_back )
{
	$pay_off = $vault['loan_sum'] * ( 1 + ( $vault_general['loan_interests'] / 100 ));
	if ( $pay_off > $userdata['user_points'] ) 
	{
		adr_previous( Adr_vault_loan_lack_points, adr_vault , '' );
	}

	$sql = "UPDATE " . USERS_TABLE ."
		SET user_points = user_points - $pay_off
		WHERE user_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}
	$sql = "UPDATE " . ADR_VAULT_USERS_TABLE ."
		SET loan_sum = 0,
		loan_time = 0
		WHERE owner_id = $user_id";
	if( !$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, 'Could not obtain accounts information', "", __LINE__, __FILE__, $sql);
	}
	adr_previous( Adr_vault_loan_pay_off_ok , adr_vault , '' );
}

$sql = "SELECT * FROM " . ADR_VAULT_USERS_TABLE;
if ( !($result = $db->sql_query($sql)) ) 
{ 
	message_die(CRITICAL_ERROR, 'Error Getting Vault Users!'); 
}
$vault_stats = $db->sql_fetchrowset($result);

$opened_accounts = 0;
$total_deposit = 0;
for ( $i = 0 ; $i < count($vault_stats) ; $i++ )
{
	$opened_accounts = $opened_accounts +1;
	$total_deposit = $total_deposit + $vault_stats[$i]['account_sum'];
}

$sql = "SELECT * FROM " . ADR_VAULT_USERS_TABLE."
	WHERE owner_id = $user_id ";
if ( !($result = $db->sql_query($sql)) ) 
{ 
	message_die(CRITICAL_ERROR, 'Error Getting Vault Users!'); 
}
$vault = $db->sql_fetchrow($result);
$remaining_time = $vault_general['loan_interests_time'] - ( time() - $vault['loan_time']);
$remaining_date = $vault['loan_time'] + $vault_general['loan_interests_time'];
$loan = $vault['loan_sum'] * ( 1 + ( $vault_general['loan_interests'] / 100 ));

// Fix the values

$InfoMaison = $HTTP_POST_VARS['InfoMaison'];

if ( $InfoBanque )
{
	adr_previous( Adr_TownMap_Banque_Infos , adr_TownMap_Banque , '' );
}

else

$template->assign_vars(array(
	'SAISON'			 => $saison,
	'POINTS'                 => $userdata['user_points'],
	'ACCOUNTS'               => $opened_accounts,
	'TOTAL_DEPOSIT'          => $total_deposit,
	'ACCOUNT_SUM'            => $vault['account_sum'],
	'INTEREST_TIME'          => adr_make_time($vault_general['interests_time']),
	'INTEREST_RATE'          => $vault_general['interests_rate'],
	'POSTS_REQ'              => $vault_general['loan_requirements'],
	'LOAN_RATE'              => $vault_general['loan_interests'],
	'LOAN_TIME'              => adr_make_time($vault_general['loan_interests_time']),
	'LOAN_MAX_SUM'           => $vault_general['loan_max_sum'],
	'LOAN_SUM'       	       => $vault['loan_sum'],
	'LOAN_REMAINING_TIME'    => adr_make_time($remaining_time),
	'LOAN_REMAINING_DATE'    => create_date($board_config['default_dateformat'], $remaining_date, $board_config['board_timezone']), 
	'LOAN_LOAN'              => $loan,
	'DUE'                    => $due,
	'L_OTHERS'               => $lang['Adr_vault_others'],
	'L_VAULT_LIST'           => $lang['Adr_vault_list'],
	'L_STOCK_EXCHANGE'       => $lang['Adr_vault_stock_exchange'],
	'L_LOAN_SUM'             => $lang['Adr_vault_loan_sum'],
	'L_LOAN_REMAINING_TIME'  => $lang['Adr_vault_loan_remaining_time'],
	'L_LOAN_REMAINING_DATE'  => $lang['Adr_vault_loan_remaining_date'],
	'L_LOAN_LOAN'            => $lang['Adr_vault_loan_loan'],
	'L_LOAN_BACK'            => $lang['Adr_vault_loan_back'],
	'L_LOAN_ACTIVE'          => $lang['Adr_vault_loan_active'],
	'L_LOAN_RATE'            => $lang['Adr_vault_loan_rate'],
	'L_LOAN_TIME'            => $lang['Adr_vault_loan_time'],
	'L_LOAN_MAX_SUM'         => $lang['Adr_vault_loan_max_sum'],
	'L_ACCOUNT_LOAN'         => $lang['Adr_vault_loan_make'],
	'L_LOAN'                 => $lang['Adr_vault_loan_action'],
	'L_POSTS_REQ'            => $lang['Posts'],
	'L_NO_LOAN_EXPLAIN'      => $lang['Adr_vault_loan_no_explain'],
	'L_INTEREST_TIME'        => $lang['Adr_vault_interests_time'],
	'L_LOAN_INFORMATIONS'    => $lang['Adr_vault_loan_informations'],
	'L_INTEREST_RATE'        => $lang['Adr_vault_interests_rate'],
	'L_ACCOUNT_DEPOSIT'      => $lang['Adr_vault_account_deposit'],
	'L_DEPOSIT'              => $lang['Adr_vault_deposit'],
	'L_ACCOUNT_WITHDRAW'     => $lang['Adr_vault_account_withdraw'],
	'L_WITHDRAW'             => $lang['Adr_vault_withdraw'],
	'L_PERSONAL_INFORMATIONS'=> $lang['Adr_vault_user_informations'],
	'L_ACCOUNT_INFORMATIONS' => $lang['Adr_vault_account_informations'],
	'L_OPENED_ACCOUNTS'      => $lang['Adr_vault_opened_accounts'],
	'L_TOTAL_DEPOSIT'        => $lang['Adr_vault_accounts_sum'],
	'L_OWNER_POINTS'         => $lang['Adr_vault_user_points'],
	'L_POINTS'               => $board_config['points_name'],
	'L_PUBLIC_TITLE'         => $lang['Adr_vault__page_name'],
	'L_NO_ACCOUNT'           => $lang['Adr_vault_no_account'],
	'L_ACCOUNT'              => $lang['Adr_vault_account'],
	'L_OPEN_ACCOUNT'         => $lang['Adr_vault_open_account'],
	'L_CLOSE_ACCOUNT'        => $lang['Adr_vault_close_account'],
	'L_BLACK_LISTED'         => $lang['Adr_vault_blacklist'],
	'L_BLACK_LISTED_EXPLAIN' => $lang['Adr_vault_blacklist_explain'],
	'L_BLACK_LISTED_DUE'     => $lang['Adr_vault_blacklist_due'],
	'L_DUE_PAYOFF'           => $lang['Adr_vault_blacklist_due_payoff'],
	'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
	'U_TOWNBOUTONRETOUR' => append_sid("adr_zones.$phpEx"),
	'L_TOWNMAP_BANQUE' => $lang['TownMap_Banque'],
	'L_TOWNBOUTONINFO' => $lang['Adr_TownMap_Bouton_Infos'],
	'L_TOWNBOUTONRETOUR' => $lang['Adr_TownMap_Bouton_Retour'],
	'L_BANQUEPRESENTATION' => $lang['Adr_TownMap_Banque_Presentation'],
	'L_BANQUEENTREE' => $lang['TownMap_Banque_Entree'],
	'L_BANQUEGENERALE' => $lang['TownMap_Banque_Banque'],
	'L_BANQUEBOURSE' => $lang['TownMap_Banque_Bourse'],
	'L_BANQUELISTE' => $lang['TownMap_Banque_Liste'],
	'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
	'L_COPYRIGHT' => $lang['Adr_copyright'],
	'L_TOWNMAPCOPYRIGHT' => $lang['TownMap_Copyright'],
	'U_TOWNBOUTONRETOUR' => append_sid("adr_TownMap.$phpEx"),
	'U_TOWNMAP_BANQUE' => append_sid("adr_vault.$phpEx"),
	'U_TOWNMAP_BANQUEGENERALE' => append_sid("adr_vault.$phpEx"),
	'U_COPYRIGHT' => append_sid("adr_copyright.$phpEx"),
	'U_TOWNMAPCOPYRIGHT' => append_sid("TownMap_Copyright.$phpEx"),
	'S_CHARACTER_ACTION' => append_sid("adr_TownMap_Banque.$phpEx"),
	'S_VAULT_ACTION'         => append_sid("adr_vault.$phpEx"),
));

$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
 
?> 