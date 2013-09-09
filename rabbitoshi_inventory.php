<?php
/***************************************************************************
 *                              rabbitoshi_inventory.php
 *                              -------------------
 *     begin                : Thurs June 9 2006
 *     copyright            : (C) 2006 The ADR Dev Crew
 *     site                 : http://www.adr-support.com
 *
 *     $Id: rabbitoshi_inventory.php,v 4.00.0.00 2006/06/09 02:32:18 Ethalic Exp $
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
$userdata = session_pagestart($user_ip, PAGE_RABINV);
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
$page_title = $lang['Rabbitoshi_inventory'];
include($phpbb_root_path . 'includes/page_header.'.$phpEx);
rabbitoshi_template_file('rabbitoshi_inventory_body.tpl');

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
if (!$result = $db->sql_query($sql)) {
	message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
}
$rabbit_user = $db->sql_fetchrow($result);

$sql = "SELECT * FROM  " . RABBITOSHI_GENERAL_TABLE ;
if (!$result = $db->sql_query($sql)) {
	message_die(GENERAL_MESSAGE, $lang['Rabbitoshi_owner_pet_lack']);
}
while( $row = $db->sql_fetchrow($result) )
{
	$rabbit_general[$row['config_name']] = $row['config_value'];
}

$board_config['points_name'] = $board_config['points_name'] ? $board_config['points_name'] : $lang['Rabbitoshi_default_points_name'];

$shop_action = isset($HTTP_POST_VARS['shop_action']);

if ( $board_config['rabbitoshi_enable'] && $searchid == $user_id ) 
{

	$sql = "SELECT * FROM " . RABBITOSHI_SHOP_TABLE ." s , " . RABBITOSHI_SHOP_USERS_TABLE ." u
		WHERE u.user_id = ".$userdata['user_id']."
		AND u.item_id = s.item_id
		AND u.item_amount > 0 
                ORDER BY s.item_name";
	$result = $db->sql_query($sql);
	if(!$result) {
		message_die(GENERAL_ERROR, "Unable to aquire a list of the users pet items.", "", __LINE__, __FILE__, $sql);
	}
	$rabbitoshi_shop = $db->sql_fetchrowset($result);
	$number_items = count($rabbitoshi_shop);
	for($k = 0; $k < $number_items ; $k++)
	{
		$usql = "SELECT item_amount
			FROM " . RABBITOSHI_SHOP_USERS_TABLE ."
			WHERE user_id = ".$userdata['user_id']."
			AND item_id = ".$rabbitoshi_shop[$k]['item_id'];
		$uresult = $db->sql_query($usql);
		if(!$uresult) {
			message_die(GENERAL_ERROR, "Unable to determine the quanity of this item.", "", __LINE__, __FILE__, $usql);
		}
		$rabbitoshi_shop_users = $db->sql_fetchrow($uresult);
		$amount = $rabbitoshi_shop_users['item_amount'] ? $rabbitoshi_shop_users['item_amount'] : 0 ;

		$item_desc = isset($lang[$rabbitoshi_shop[$k]['item_desc']]) ? $lang[$rabbitoshi_shop[$k]['item_desc']] : $rabbitoshi_shop[$k]['item_desc'];
		$item_name = isset($lang[$rabbitoshi_shop[$k]['item_name']]) ? $lang[$rabbitoshi_shop[$k]['item_name']] : $rabbitoshi_shop[$k]['item_name'];


		if(file_exists($phpbb_root_path."rabbitoshi/images/items/".$rabbitoshi_shop[$k]['item_img'].""))
		{ $pic = '<img src="'.$phpbb_root_path.'rabbitoshi/images/items/'.$rabbitoshi_shop[$k]['item_img'].'">'; }
		else { $pic = ''; }

		$row_class = ( !($k % 2) ) ? $theme['td_class1'] : $theme['td_class2'];

		$template->assign_block_vars('items', array(
			"NAME" =>  $item_name,
			"IMG" =>  $pic,
                        "DESC" =>  $item_desc,
			"SUM" => $amount,
			"PRIZE" =>  $rabbitoshi_shop[$k]['item_prize'],
			"ROW_CLASS" => $row_class)
		);
	}
}

$template->assign_vars(array(
	'NUMBER_ITEMS'          => $number_items,

        'L_PUBLIC_TITLE'        => $lang['Rabbitoshi_inventory'],
	'L_NAME' 		=> $lang['Rabbitoshi_shop_name'],
	'L_PIC' 		=> $lang['Rabbitoshi_shop_img'],
	'L_DESC' 		=> $lang['Rabbitoshi_item_desc'],
	'L_QUANITY' 		=> $lang['Rabbitoshi_inventory_quanity'],
	'L_VALUE' 		=> $lang['Rabbitoshi_inventory_value'],
	'L_POINTS' 		=> $board_config['points_name'],

	'S_PET_ACTION'          => append_sid("rabbitoshi_inventory.$phpEx"),
	'S_PET_RETURN'          => append_sid("rabbitoshi.$phpEx"),
	'S_HIDDEN_FIELDS'	=> $s_hidden_fields
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