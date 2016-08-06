<?php
/***************************************************************************
 *                              rabbitoshi_shop.php
 *                              -------------------
 *     begin                : Thurs June 9 2006
 *     copyright            : (C) 2006 The ADR Dev Crew
 *     site                 : http://www.adr-support.com
 *
 *     $Id: rabbitoshi_shop.php,v 4.00.0.00 2006/06/09 02:32:18 Ethalic Exp $
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
define('IN_RABBITOSHI', true);
$phpbb_root_path = './';
include($phpbb_root_path.'extension.inc');
include($phpbb_root_path.'common.'.$phpEx);
include($phpbb_root_path.'rabbitoshi/includes/functions_rabbitoshi.'.$phpEx);

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_RABSHO);
init_userprefs($userdata);
// End session management
//

if ( !$userdata['session_logged_in'] )
{
	$redirect = "rabbitoshi.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

//
// Generate page
//
$page_title = $lang['Rabbitoshi_title'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
rabbitoshi_template_file('rabbitoshi_shop_body.tpl');

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
			$prizee = $prizee + $price ;

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
		
		if(file_exists($phpbb_root_path."rabbitoshi/images/items/".$rabbitoshi_shop[$k]['item_img'].""))
		{ $pic = '<img src="'.$phpbb_root_path.'rabbitoshi/images/items/'.$rabbitoshi_shop[$k]['item_img'].'">'; }
		else { $pic = ''; }

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
	'L_PUBLIC_TITLE'        => $lang['Rabbitoshi_Shop'],
	'L_RETURN'              => $lang['Rabbitoshi_shop_return'],
	'L_OWNER_POINTS'        => $lang['Rabbitoshi_owner_points'],
	'L_POINTS'              => $board_config['points_name'],
	'L_NAME' 		=> $lang['Rabbitoshi_shop_name'],
	'L_PRIZE' 		=> $lang['Rabbitoshi_shop_prize'],
	'L_DESC' 		=> $lang['Rabbitoshi_item_desc'],
	'L_SUM' 		=> $lang['Rabbitoshi_item_sum'],
	'L_PIC' 		=> $lang['Rabbitoshi_shop_img'],
	'L_ACTION' 		=> $lang['Rabbitoshi_shop_action'],
	'L_BUY'		        => $lang['Rabbitoshi_shop_buy'],
	'L_SELL'		=> $lang['Rabbitoshi_shop_sell'],
	'L_TRANSLATOR'          => $lang['Rabbitoshi_translation'],
	'L_PET_GENERAL_MESSAGE' => $lang['Rabbitoshi_general_message'],
	'L_PET_MESSAGE'         => $lang['Rabbitoshi_message'],
	'PET_GENERAL_MESSAGE'   => $thought,
	'PET_MESSAGE'           => $message,
	'POINTS'                => $userdata['user_points'],
	'NUMBER_ITEMS'          => $number_items ,
	'S_PET_ACTION'          => append_sid("rabbitoshi_shop.$phpEx"),
	'S_PET_RETURN'          => append_sid("rabbitoshi.$phpEx"),
	'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
));

$template->pparse('body');

#==== Start Copyright ======================== |
?>
<script language="JavaScript">

function copyright()
{
	var popurl = "rabbitoshi/includes/rabbitoshi_copy.php"
	var winpops = window.open(popurl, "", "width=400, height=350,")
}
</script>

<?php
echo "<table width='100%' border='0'>
		<tr>
			<td align='center' valign='top' colspan='1'>
				<span class='genmed'>
					<a style='text-decoration:none;' href='javascript:copyright();'><span class='gensmall'>Rabbitoshi &copy; 2006</a></span>
				</span>
			</td>
		</tr>
	  </table>";
#==== End Copyright ========================== |

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
