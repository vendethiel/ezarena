<?php
/***************************************************************************
 *					 adr_maps.php
 *				------------------------
 *	begin 		    : 06/12/2005
 *	copyright		: Ozzie
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
define('IN_ADR', true);
define('IN_ADR_ZONES', true);
define('IN_ADR_CAULDRON', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_TOWN', true);
$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc'); 
include_once($phpbb_root_path . 'common.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
include_once($phpbb_root_path . 'adr/language/lang_' . $board_config['default_lang'] . '/lang_adr.'.$phpEx);
$loc = 'zones';
$sub_loc = 'adr_maps';

//
// Start session management
$userdata = session_pagestart($user_ip, 'ADR World Map');
init_userprefs($userdata); 
// End session management
//

$user_id = $userdata['user_id'];

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_maps.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}
adr_template_file('adr_maps_body.tpl');
$page_title = $lang['Adr_zone_maps_adr_world_map_title'];
$adr_general = adr_get_general_config();

include($phpbb_root_path . 'includes/page_header.'.$phpEx);
include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx); 
$zone_id = $board_config['Adr_zone_worldmap_zone'];
// Dynamic Zone Maps
$sql = "select * from ".ADR_ZONE_MAPS_TABLE." where zone_id='$zone_id'";
if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_zone_maps_error_message_1'] ); }
$uhrow = mysql_fetch_array($result);
if ( $uhrow['zonemap_type'] == '' )
{
	$template->assign_block_vars('switch_Adr_zone_townmap_disable',array());
}
else
{
	$template->assign_block_vars('switch_Adr_zone_townmap_enable',array());
}
if ( $uhrow['zonemap_type'] > 0 )
{
$sql = "select * from ".ADR_ZONE_TOWNMAP_TABLE." where zonemap_type=$uhrow[zonemap_type]";
if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_zone_maps_error_message_2'] ); }
$zrow = mysql_fetch_array($result);

$townmap = $zrow['zonemap_bg'];
$zwidth = $zrow['zonemap_width'];
$zcellsh = $zrow['zonemap_cellwidth']+1;
$zcellshn = $zrow['zonemap_cellwidthnumber'];
$zheight = $zrow['zonemap_height'];
$zcellsv = $zrow['zonemap_cellheight']+1;
$zcellsvn = $zrow['zonemap_cellheightnumber'];

$buildingarray = explode('~',$uhrow['zonemap_buildings']);
$buildingamount = count ($buildingarray);

// some pixies fly by and get our buildings organized
$ia = 0;
for ($iv = 1; $iv <= $zcellsvn; $iv++)
{
	for ($ih = 1; $ih <= $zcellshn; $ih++)
	{
		if ($buildingarray[$ia] != '')
		{
			$sql = "select * from ".ADR_ZONE_BUILDINGS_TABLE." where sdesc='".$buildingarray[$ia]."'";
			if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_zone_maps_error_message_3'] ); }
			$brow = mysql_fetch_array($result);
			$buildinglist2[$iv][$ih] = $brow['name'];

			if ( $brow['zone_name_tag'] =='' )
			{
   				$building_name_tag1[$iv][$ih] = 'alt=""';
   				$building_name_tag2[$iv][$ih] = 'name=""';
   			}
   			else
   			{
	   			$building_name_tag1[$iv][$ih] = 'alt="'.$brow['zone_name_tag'].'"';
   				$building_name_tag2[$iv][$ih] = 'name="'.$brow['zone_name_tag'].'"';
   			}
			if ( $brow['zone_link'] == '' )
			{
				$building_link[$iv][$ih] = '';
			}
			else
			{
				$building_link[$iv][$ih] = '<a href="'. append_sid('javascript:Teleport_Popup(\'adr_maps_teleport.'. $phpEx .'?zone='. $brow['zone_link'] .'\', \'New_Window\', \'800\', \'425\', \'no\')') .'" class="nav">';
			}
			if ( $brow['zone_building_tag_no'] == 999  )
			{
				$building_tag_no[$iv][$ih] = '';
			}
			else
			{
				$building_tag_no[$iv][$ih] = 'onMouseOver="stm(Text['.$brow['zone_building_tag_no'].'],Style[0])" onMouseOut="htm()"';
			}
		}
		else
		{
			$buildinglist2[$iv][$ih] = 'empty';
   			$building_name_tag1[$iv][$ih] = 'alt=""';
   			$building_name_tag2[$iv][$ih] = 'name=""';
            $building_tag_no[$iv][$ih] = '';
            $building_link[$iv][$ih] = '';
		}
		$ia++;
	}
}

// lets get some gnomes to build the map

$showmap = '
<tr>
	<td class="row1" align="center" valign="center">
<table background="./adr/images/zones/townmap/'.$townmap.'" width="'.$zwidth.'px" height="'.$zheight.'px" cellpadding=0 cellspacing=0 marginwidth=0 marginheight=0 topmargin=0 leftmargin=0 border=0>';

for ($sv = 1; $sv <= $zcellsvn; $sv++)
{
	$showmap .= '<tr>';
	for ($sh = 1; $sh <= $zcellshn; $sh++)
	{
		$showmap .= '
		<td width="'.$zcellsh.'px" height="'.$zcellsv.'px">'.$building_link[$sv][$sh].'<img src="./adr/images/zones/townmap/buildings/'.$buildinglist2[$sv][$sh].'.gif" width="'.$zcellsh.'px" height="'.$zcellsv.'px" border="0" '.$building_name_tag1[$sv][$sh].' '.$building_name_tag2[$sv][$sh].' '.$building_tag_no[$sv][$sh].'></td>';
	}
	$showmap .= '</tr>';
}

$showmap .= '
</table>';
}

// Define map name
if ( $board_config['Adr_zone_townmap_name'] == '' )
{
	$map_name = sprintf($lang['Adr_zone_maps_map'], $board_config['sitename']);
}
else
{
	$map_name = sprintf($lang['Adr_zone_maps_map'], $board_config['Adr_zone_townmap_name']);
}

	$template->assign_vars(array(
		'STATINFO' => "$showmap",
		'STATTABLETITLE' => $map_name,
		'ZONES_LINK' => $lang['Adr_zone_header_return'],
		)
	);
$template->pparse('body');

include($phpbb_root_path . 'includes/page_tail.'.$phpEx);
?>
