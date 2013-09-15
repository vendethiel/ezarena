<?php
/***************************************************************************
*                      admin_adr_manage_zone_maps.php
*                      ------------------------------
*     begin                : 06/04/2005
*     copyright            : Ozzie
*
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
define('IN_PHPBB', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_ZONES_ADMIN', 1);
define('IN_ADR_CHARACTER', 1);
define('IN_ADR_SHOPS', 1);
define('IN_ADR_ZONE_MAPS', 1);
// START global variable fix
if(is_array($_GET))
{
   extract($_GET, EXTR_PREFIX_SAME, "get");
}

if(is_array($_POST))
{
   extract($_POST, EXTR_PREFIX_SAME, "post");
}
// END global variable fix
if(	!empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['ADR-Zones']['Manage Zone Maps'] = $file;
	return;
}

//
// Let's set the root dir for phpBB
//
$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require('pagestart.' . $phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
//
//check for userlevel
//
if( !$userdata['session_logged_in'] )
{
	header('Location: ' . append_sid("login.$phpEx?redirect=tableupdate.$phpEx", true));
}

if( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, $lang['Not_Authorised']);
}
//end check

$adr_general = adr_get_general_config();
adr_template_file('admin/config_adr_zones_manage_maps_body.tpl');

$zone_townmap_name = $HTTP_POST_VARS['Adr_zone_townmap_name'];
$mode = stripslashes($HTTP_POST_VARS['mode']);
$action = stripslashes($HTTP_POST_VARS['action']);
$zone_name2 = $HTTP_POST_VARS['zone_name2'];
$zone_name1 = $HTTP_POST_VARS['zone_name1'];
$assignzone = $HTTP_POST_VARS['assignzone'];
$id = $HTTP_POST_VARS['id'];
$zone_name = $HTTP_POST_VARS['zone_name'];
$remove = $HTTP_POST_VARS['remove'];
$buildingcell = $HTTP_POST_VARS['buildingcell'];
$buildingcellitem = $HTTP_POST_VARS['buildingcellitem'];
$buildingname = $HTTP_POST_VARS['buildingname'];
$btype = $HTTP_POST_VARS['btype'];
$building_name = $HTTP_POST_VARS['building_name'];
$image_name = $HTTP_POST_VARS['image_name'];
$zone_link = $HTTP_POST_VARS['zone_link'];
$zone_name_tag = $HTTP_POST_VARS['zone_name_tag'];
$building_tag_no = $HTTP_POST_VARS['building_tag_no'];
$upitem = $HTTP_POST_VARS['upitem'];
$zone_link_val = $HTTP_POST_VARS['zone_link_val'];
$zone_name_tag_val = $HTTP_POST_VARS['zone_name_tag_val'];
$building_tag_no_val = $HTTP_POST_VARS['building_tag_no_val'];
$record_id2 = $HTTP_POST_VARS['record_id2'];
$editzone = $HTTP_POST_VARS['editzone'];
$thatzone = $HTTP_POST_VARS['thatzone'];
$buildingcells = $HTTP_POST_VARS['buildingcells'];
$editmap = $HTTP_POST_VARS['editmap'];
$townmaptype = $HTTP_POST_VARS['townmaptype'];
$townmapname = $HTTP_POST_VARS['townmapname'];
$townmapbg = $HTTP_POST_VARS['townmapbg'];
$townmapwidth = $HTTP_POST_VARS['townmapwidth'];
$townmapcellwidth = $HTTP_POST_VARS['townmapcellwidth'];
$townmapcellwidthnumber = $HTTP_POST_VARS['townmapcellwidthnumber'];
$townmapheight = $HTTP_POST_VARS['townmapheight'];
$townmapcellheight = $HTTP_POST_VARS['townmapcellheight'];
$townmapcellheightnumber = $HTTP_POST_VARS['townmapcellheightnumber'];
$origname = $HTTP_POST_VARS['origname'];
$origtype = $HTTP_POST_VARS['origtype'];

//--------------------------------Main Page START-----------------------------------------

if ((empty($mode)) || ($mode == 'MAIN') || ($mode == 'Main'))
{

	$sql = "SELECT zone_name,zone_id from " . ADR_ZONES_TABLE . " WHERE zone_name = 'World Map'";
	if ( !($result = $db->sql_query($sql)) )  {message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_2']);}
	$data1 = $db->sql_fetchrowset($result);
	if ( !($data1[0]['zone_name'] == 'World Map') )
	{
		$sql2 = "SELECT * from " . ADR_ZONES_TABLE . " ORDER by zone_id DESC";
		if ( !($result2 = $db->sql_query($sql2)) ) {message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_2']);}
		$data2 = $db->sql_fetchrowset($result2);
		$bottom_zone = $data2[0]['zone_id']+1;
		$sql3 = "INSERT INTO " . ADR_ZONES_TABLE . " (zone_id, zone_name, zone_desc, zone_img, zone_element, return_name) VALUES ($bottom_zone, 'World Map', 'Map of the World', 'World.gif', 'Earth', 'World Map')";
		if ( !($db->sql_query($sql3)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_11']); }
        $sql4 = "UPDATE ". CONFIG_TABLE . " SET config_value = '$bottom_zone' WHERE config_name = 'Adr_zone_worldmap_zone' ";
		if ( !($result4 = $db->sql_query($sql4)) ) { message_die(GENERAL_ERROR, $lang['Adr_admin_maps_error_14']); }
		$sql5 = "UPDATE ". ADR_ZONE_MAPS_TABLE . " SET zone_id = '$bottom_zone' WHERE zone_world = 1";
		if ( !($result5 = $db->sql_query($sql5)) ) {message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_1']);}
	}
	else
	{
		$world_zone_id = $data1[0]['zone_id'];
		if ( !( $world_zone_id == $board_config['Adr_zone_worldmap_zone'] ) && $result['zone_name'] == 'World Map' )
		{
        	$sql4 = "UPDATE ". CONFIG_TABLE . " SET config_value = '$world_zone_id' WHERE config_name = 'Adr_zone_worldmap_zone' ";
			if ( !($result4 = $db->sql_query($sql4)) ) { message_die(GENERAL_ERROR, $lang['Adr_admin_maps_error_14']); }
		}
	}
	$sql2 = "SELECT * from " . ADR_ZONES_TABLE . " ORDER by zone_id DESC";
	if ( !($result2 = $db->sql_query($sql2)) ) {message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_2']);}
	$data2 = $db->sql_fetchrowset($result2);
	$bottom_zone = $data2[0]['zone_id']+1;

	$sql = "SELECT * from " . ADR_ZONE_MAPS_TABLE . " m
			LEFT JOIN  " . ADR_ZONES_TABLE . " z ON ( m.zone_id = z.zone_id )
			WHERE m.zone_id > 0
			ORDER by z.zone_name ASC";
	if ( !($iresult = $db->sql_query($sql)) ) {message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_1']);}
	$zonemaplist = "";
//	$irow = mysql_fetch_array($iresult);
	for ($x = 0; $x < $bottom_zone; $x++)
	{
		$irow = mysql_fetch_array($iresult);
		if ( !($irow['zone_id'] == '' || $irow['zone_id'] == 0 ) )
		{
			$jsql = "SELECT zone_name from " . ADR_ZONES_TABLE . " WHERE zone_id = $irow[zone_id]";
			if ( !($jresult = $db->sql_query($jsql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_2']); }
			$jrow = mysql_fetch_array($jresult);

			$zonemaplist .= "<option value=\"".$jrow['zone_name']."\">Carte de ".ucfirst($jrow['zone_name'])."</option>";
		}
	}

	$zonemaplist2 = "";

	$nsql = "select zone_name, zone_id from ".ADR_ZONES_TABLE." ORDER by zone_name ASC";
	$nresult = $db->sql_query($nsql);
	if ( !$nresult ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_2']); }
	$nrow = $db->sql_fetchrowset($nresult);

		$irow = mysql_fetch_array($iresult);
			$ksql = "SELECT * from " . ADR_ZONE_MAPS_TABLE . " ORDER by zone_id ASC";
			if ( !($kresult = $db->sql_query($ksql)) ) {message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_1']);}
			$krow = $db->sql_fetchrowset($kresult);

			for ($y = 0; $y < count($nrow); $y++)
			{
				$nrow[$y]['map_assigned'] = 0;
				for ( $z = 0; $z < count($krow); $z++)
				{
					if ( $krow[$z]['zone_id'] == $nrow[$y]['zone_id'] )
					{
						$nrow[$y]['map_assigned'] = 1;
						break;
					}
				}
				if ( $nrow[$y]['map_assigned'] == 0 )
				{
					$zonemaplist2 .= "<option value=\"".$nrow[$y]['zone_name']."\">".ucfirst($nrow[$y]['zone_name'])."</option>";
				}
			}
	$statinfo = '
	<tr><td class="row2" colspan="2"><br></td></tr>
	<tr><input type="hidden" value="main" name="action">
		<td class="row2"><span class="gen">'.$lang['Adr_admin_maps_zonemaps_title'].'</span></td>
		<td class="row2"><input type="submit" VALUE="'.$lang['Adr_admin_maps_townmap_types'].'" name="mode"></td>
	</tr>
	<tr>
		<td class="row2"><span class="gen">'.$lang['Adr_admin_maps_building_title'].'</span></td>
		<td class="row2"><input type="submit" VALUE="'.$lang['Adr_admin_maps_building_cells'].'" name="mode"></td>
	</tr>
	<tr>
		<td class="row2"><span class="gen">'.$lang['Adr_admin_maps_building_types_title'].'</span></td>
		<td class="row2"><input type="submit" VALUE="'.$lang['Adr_admin_maps_building_types'].'" name="mode"></td>
	</tr>
	<tr>
		<td class="row2"><span class="gen">'.$lang['Adr_admin_maps_townmap_create_title'].'</span></td>
		<td class="row2"><select name="zone_name2"><option value="">'.$lang['Adr_admin_maps_none'].'</option>'.$zonemaplist2.'</select> <input type="submit" value="'.$lang['Adr_admin_maps_zone_townmap_edit'].'" name="mode"></td>
	</tr>
	<tr>
		<td class="row2"><span class="gen">'.$lang['Adr_admin_maps_townmap_edit_title'].'</span></td>
		<td class="row2"><select name="zone_name1"><option value="">'.$lang['Adr_admin_maps_none'].'</option>'.$zonemaplist.'</select> <input type="submit" value="'.$lang['Adr_admin_maps_zone_townmap_edit'].'" name="mode"></td>
	</tr>';

	$template->assign_vars(array(
		'STATCONFIGINFO' => "$statinfo",
		'STATTABLETITLE' => $lang['Adr_admin_maps_townmap_system_title'],
		'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
		'STATTITLE' => $lang['Adr_admin_maps_townmap_system_title'],
		'STATEXPLAIN' => $lang['Adr_admin_maps_townmap_system_explain'])
	);

}
//--------------------------------Main Page END-----------------------------------------
//--------------------------------Edit Zone TownMap Page START-----------------------------------------

if ($mode == $lang['Adr_admin_maps_zone_townmap_edit'] )
{
	if ($action == 'main')
	{
		if ($zone_name == '')
		{
			if (($zone_name1 != '') && ($zone_name2 != ''))
			{
				$message = '<br />'.$lang['Adr_admin_maps_missing_town_name'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
				$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
				message_die(GENERAL_MESSAGE, $message);
			}
			if (($zone_name1 == '') && ($zone_name2 == ''))
			{
				$message = '<br />'.$lang['Adr_admin_maps_missing_town_name'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
				$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
				message_die(GENERAL_MESSAGE, $message);
			}
			if ($zone_name1 != '') {$zone_name = $zone_name1;}
			if ($zone_name2 != '') {$zone_name = $zone_name2;}
		}
		$sql = "select zone_name, zone_id from ".ADR_ZONES_TABLE." where zone_name='$zone_name'";
		if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_3']); }
		$prow = mysql_fetch_array($result);

		if ($prow['zone_id'] == 0)
		{
			$message = '<br />'.sprintf( $lang['Adr_admin_maps_zone_not_exist'], $zone_name );
			$message .= sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
			$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
			message_die(GENERAL_MESSAGE, $message);
		}
		$id = $prow['zone_id'];

		$sql = "select * from ".ADR_ZONE_BUILDINGS_TABLE."";
		if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_4']); }
		$brow = mysql_fetch_array($result);

		$sql = "select * from ".ADR_ZONE_MAPS_TABLE." where zone_id='$id'";
		if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_5']); }
		$uhrow = mysql_fetch_array($result);

		if ($uhrow['zonemap_type'] == '')
		{

			$sql = "select * from ".ADR_ZONE_TOWNMAP_TABLE." order by zonemap_type";
			if ( !($result = $db->sql_query($sql)) )
			{		message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_6'] );	}

			$zones = "<span class=\"genmed\"><select name=\"assignzone\">";
			for ($x = 0; $x < mysql_num_rows($result); $x++)
			{
				$zoneinfo = mysql_fetch_array($result);
				$zones .= "<option value=\"".$zoneinfo['zonemap_type']."\">".$zoneinfo['zonemap_type']." - ".$zoneinfo['zonemap_name']."</option>";
			}
			$zones .= "</select>";

			$statinfo = '
			<tr>
				<td colspan="2" align="center" class="row2"><span class="gen"><b>'.$zone_name.$lang['Adr_admin_maps_no_townmap'].'</b></span><input type="hidden" value="'.$lang['Adr_admin_maps_edit_townmap'].'" name="mode"><input type="hidden" value="'.$id.'" name="id"><input type="hidden" value="'.$zone_name.'" name="zone_name"></td>
			</tr>
			<tr>
				<td class="row2"><span class="genmed"><b>'.$lang['Adr_admin_maps_townmap_type'].':</b></span></td>
				<td class="row2">'.$zones.'<input type="submit" value="'.$lang['Adr_admin_maps_assign'].'" name="action"></td>
			</tr>';

			$template->assign_vars(array(
				'STATCONFIGINFO' => "$statinfo",
				'STATTABLETITLE' => $lang['Adr_admin_maps_edit_zonemaps_title'],
				'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
				'STATTITLE' => $lang['Adr_admin_maps_edit_zonemaps_title'],
				'STATEXPLAIN' => $lang['Adr_admin_maps_edit_zonemaps_explain'])
			);

		}
		else
		{
			$sql = "select * from ".ADR_ZONE_TOWNMAP_TABLE." where zonemap_type=$uhrow[zonemap_type]";
			if ( !($result = $db->sql_query($sql)) ) {
				message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_7']);
			}
			$zrow = mysql_fetch_array($result);

			$townmap = $zrow['zonemap_bg'];
			$zwidth = $zrow['zonemap_width'];
			$zcellsh = $zrow['zonemap_cellwidth'] - 2;
			$zcellshn = $zrow['zonemap_cellwidthnumber'];
			$zheight = $zrow['zonemap_height'];
			$zcellsv = $zrow['zonemap_cellheight'] - 2;
			$zcellsvn = $zrow['zonemap_cellheightnumber'];
			$zbuildingcells = explode(",",$zrow['zonemap_building']);
			$zbuildingcellsamount = count ($zbuildingcells);
			$cellamount = $zcellshn * $zcellsvn;
			$buildingarray = explode('~',$uhrow['zonemap_buildings']);
			$buildingamount = count ($buildingarray);
			$buildingcount = count($brow);

			$buildings = '';
			$zonebuildinginv = '';

			for ($a = 0; $a < $buildingamount; $a++)
			{
				if ($buildingarray[$a] != '')
				{
					$c = $a + 1;
					$desc = isset($lang['Adr_building_'.$buildingarray[$a]]) ? $lang['Adr_building_'.$buildingarray[$a]] : $buildingarray[$a];
					$zonebuildinginv .= '<option value="'.$a.'">'.$desc.' sur la cellule-'.$c.'</option>';
				}
			}

			$sql = "select * from ".ADR_ZONE_BUILDINGS_TABLE." order by sdesc";
			if ( !($iresult = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_4']); }
			for ($x = 0; $x < mysql_num_rows($iresult); $x++)
			{
				$irow = mysql_fetch_array($iresult);
				$buildinglist .= $irow['sdesc'];
				if ($irow['zone_building_type'] == 0 || $irow['zone_building_type'] == 1 || $irow['zone_building_type'] == 2)
				{
					$desc = isset($lang['Adr_building_'.$irow['sdesc']]) ? $lang['Adr_building_'.$irow['sdesc']] : ucfirst($irow['sdesc']);
					$buildingtypes .= "<option value=\"".$irow['sdesc']."\">".$desc."</option>";
				}
			}

// some pixies fly by and get our buildings organized
			$ia = 0;
			for ($iv = 1; $iv <= $zcellsvn; $iv++)
			{
				for ($ih = 1; $ih <= $zcellshn; $ih++)
				{
					if ($buildingarray[$ia] != '')
					{
						$sql = "select * from ".ADR_ZONE_BUILDINGS_TABLE." WHERE sdesc = '$buildingarray[$ia]'";
						if ( !($bresult = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_4'].'test'); }
						$brow2 = mysql_fetch_array($bresult);
						$buildinglist2[$iv][$ih] = $brow2['name'];
					}
					else
  					{
						$buildinglist2[$iv][$ih] = 'empty';
					}
					$ia++;
				}
			}

// lets get some gnomes to build the map

			$statinfo = '
<tr>
	<td class="row1" align="center" valign="center" colspan="2"><span class="genmed"><b>'.sprintf( $lang['Adr_admin_maps_editing_townmap'], $zone_name ).'</b></span>
</tr>
<tr>
	<td class="row1" align="center" valign="center">
<br>
<b>Cliquez sur une case valide pour la sélectionner.</b>
<table background="../adr/images/zones/townmap/'.$townmap.'" width="'.$zwidth.'px" height="'.$zheight.'px" cellpadding=0 cellspacing=0 marginwidth=0 marginheight=0 topmargin=0 leftmargin=0 border=1>';

			$cn = 1;
			// V: helper to select a cell.
			$total_valid = 0;
			for ($sv = 1; $sv <= $zcellsvn; $sv++)
			{
				$statinfo .= '<tr>';
				for ($sh = 1; $sh <= $zcellshn; $sh++)
				{
					$celltitle = '';
					if (in_array($cn, $zbuildingcells))
					{
						$total_valid++;
						$celltitle = 'title="Cellule - '.$cn.'"
						onclick="document.getElementById(\'buildingcell\').selectedIndex = ' . $total_valid . ';"';
					}
					$statinfo .= '
		<td width="'.$zcellsh.'px" height="'.$zcellsv.'px"><img src="../adr/images/zones/townmap/buildings/'.$buildinglist2[$sv][$sh].'.gif" ' . $celltitle . ' width="'.$zcellsh.'px" height="'.$zcellsv.'px" border="0" alt="Cell - '.$cn.'"></td>';
					$cn++;
				}
				$statinfo .= '</tr>';
			}

			$statinfo .= '
</table>
<br>
</td>
</tr>
<tr>
<td class="row1" align="center" valign="center" colspan="2">
<table width="95%" align"center" valign="center">
<tr><input type="hidden" value="'.$lang['Adr_admin_maps_buildings'].'" name="mode">
<td align="center" valign="center"><span class="genmed"><b>'.$lang['Adr_admin_maps_remove_building'].'</b></span></td>
<td align="center" valign="center"><span class="genmed">'.$lang['Adr_admin_maps_item'].'<select name="remove"><option value="" SELECTED>'.$lang['Adr_admin_maps_none'].'</option>'.$zonebuildinginv.'</select></span></td>
<td align="center" valign="center"><span class="genmed"><input type="submit" value="'.$lang['Adr_admin_maps_remove'].'" name="action"></span></td>';
			$statinfo .= '<tr></table></td></tr>';
			$statinfo .= '
<tr>
	<td class="row1" align="center" valign="center" colspan="2">
	<table width="95%" align"center" valign="center">
	<tr><input type="hidden" value="'.$lang['Adr_admin_maps_edit_zonemap'].'" name="mode"><input type="hidden" value="'.$id.'" name="id"><input type="hidden" value="'.$zone_name.'" name="zone_name">
		<td align="center"><span class="genmed"><b>'.$lang['Adr_admin_maps_buildings'].':</b></span></td>
		<td align="center">
		<span class="genmed">'.$lang['Adr_admin_maps_place'].'<select id="buildingcell" name="buildingcell">';
			$statinfo .= '<option value="" SELECTED>'.$lang['Adr_admin_maps_none'].'</option>';
			for ($fc = 1; $fc < $zbuildingcellsamount; $fc++)
			{
				$statinfo .= '<option value="'.$zbuildingcells[$fc].'">'.$lang['Adr_admin_maps_cells'].$zbuildingcells[$fc].'</option>';
			}
			$statinfo .= '</select></span></td>

		<td align="center">
		<span class="genmed">'.$lang['Adr_admin_maps_building'].':<select name="buildingcellitem">';
			$statinfo .= '<option value="" SELECTED>'.$lang['Adr_admin_maps_none'].'</option>'.$buildingtypes.'</select></span></td>';

			$statinfo .= '<td align="center"><input type="submit" value="'.$lang['Adr_admin_maps_place building'].'" name="action"></td>
	</tr>';

			$statinfo .= '
	<tr>
		<td colspan="5" align="center" class="row1"><span class="genmed">'.$lang['Adr_admin_maps_delete_townmap_explain'].'<P><input type="submit" value="'.$lang['Adr_admin_maps_delete_townmap'].'" name="action" style="color:white;background-color:red;"></span></td>
	</tr>
<tr>
	<td class="row1" align="center" valign="center" colspan="5">
	<span class="genmed">'.$lang['Adr_admin_maps_main_back'].'<br /><input type="submit" value="'.$lang['Adr_admin_maps_main'].'" name="mode"></span>
	</table>
	</td>
</tr>';


			$template->assign_vars(array(
				'STATCONFIGINFO' => "$statinfo",
				'STATTABLETITLE' => $lang['Adr_admin_maps_edit_townmaps_title'],
				'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
				'STATTITLE' => $lang['Adr_admin_maps_edit_townmaps_title'],
				'STATEXPLAIN' => $lang['Adr_admin_maps_edit_zone_townmaps_explain'])
			);
		}
	}
}
if ($action == $lang['Adr_admin_maps_delete_townmap'])
{
//update buildings
	$u3sql="DELETE FROM ".ADR_ZONE_MAPS_TABLE." WHERE zone_id=$id";
	if ( !($u3result = $db->sql_query($u3sql)) )
	{
		message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_8']);
	}

	$message = '<br />'.$lang['Adr_admin_maps_zone_townmap_deleted'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
	$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
	message_die(GENERAL_MESSAGE, $message);
}
if ($action == $lang['Adr_admin_maps_assign'])
{
	if (!isset($assignzone))
	{
		$message = '<br />'. $lang['Adr_admin_maps_select_zonemap'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
		$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
		message_die(GENERAL_MESSAGE, $message);
	}
	$sql = "select * from ".ADR_ZONE_TOWNMAP_TABLE." where zonemap_type=$assignzone";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_7']); }
	$hrow = mysql_fetch_array($result);

	$zcellshn = $hrow['zonemap_cellwidthnumber'];
	$zcellsvn = $hrow['zonemap_cellheightnumber'];
	$cellamount = $zcellshn * $zcellsvn;

	$buildinglist = '';
	for ($a = 1; $a <= $cellamount; $a++)
	{
		$buildinglist .= "~";
	}

	$sql2 = "INSERT INTO ".ADR_ZONE_MAPS_TABLE." (zone_id, zonemap_type, zonemap_buildings) VALUES ($id, $assignzone, '$buildinglist')";
	if ( !($db->sql_query($sql2)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_8']); }

	$message = '<br />'. $lang['Adr_admin_maps_zonemap_assigned'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
	$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
	message_die(GENERAL_MESSAGE, $message);
}

if ($action == $lang['Adr_admin_maps_remove'])
{
	if ($remove =='') {message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_zone_remove_info']);}

	$sql = "select * from ".ADR_ZONE_MAPS_TABLE." where zone_id='$id'";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_5']); }
	$uhrow = mysql_fetch_array($result);

	$sql = "select zone_name from ".ADR_ZONES_TABLE." where zone_id='$id'";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_3']); }
	$prow = mysql_fetch_array($result);

	$sql = "select zonemap_name from ".ADR_ZONE_TOWNMAP_TABLE." where zonemap_type=$uhrow[zonemap_type]";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_7']); }
	$hrow = mysql_fetch_array($result);

	$buildingarray = explode('~',$uhrow['zonemap_buildings']);
	$buildingamount = count ($buildingarray);

	for ($a = 0; $a < $buildingamount; $a++)
	{
		if ($a == $remove)
		{
			$buildingarray[$a] = '';
		}
	}

	$buildinglist = '';
	for ($a = 0; $a < $buildingamount; $a++)
	{
		$buildinglist .= $buildingarray[$a].'~';
	}

	$sql = "update ".ADR_ZONE_MAPS_TABLE." set zonemap_buildings='$buildinglist' where zone_id='$id'";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_8']); }


	$statinfo = '
<tr>
	<td class="row1" align="center" valign="center" colspan="2">
<br><span class="genmed">'.$lang['Adr_admin_maps_building_removed'].'</span></td>
</tr>
<tr>
	<td class="row1" align="center" valign="center">
	<span class="genmed">'.$lang['Adr_admin_maps_main_back'].'<br><input type="submit" value="'.$lang['Adr_admin_maps_main'].'" name="mode"></span>
	</td>
	<td class="row1" align="center" valign="center"><input type="hidden" value="'.$zone_name.'" name="zone_name"><input type="hidden" value="main" name="action">
	<span class="genmed">'.$lang['Adr_admin_maps_edit_townmap_back'].'<br><input type="submit" value="'.$lang['Adr_admin_maps_zone_townmap_edit'].'" name="mode"></span>
	</td>
</tr>';


	$template->assign_vars(array(
		'STATCONFIGINFO' => "$statinfo",
		'STATTABLETITLE' => $lang['Adr_admin_maps_zone_townmap_edit'],
		'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
		'STATTITLE' => $lang['Adr_admin_maps_zone_townmap_edit'],
		'STATEXPLAIN' => $lang['Adr_admin_maps_townmaps_explain'])
	);
}

if ($action == $lang['Adr_admin_maps_place building'])
{
	if ($buildingcell == '')
	{message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_need_info']);}
	$sql = "select * from ".ADR_ZONE_MAPS_TABLE." where zone_id='$id'";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_9']); }
	$uhrow = mysql_fetch_array($result);

	$sql = "select zone_name from ".ADR_ZONES_TABLE." where zone_id='$id'";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_7']); }
	$prow = mysql_fetch_array($result);

	$sql = "select zonemap_name from ".ADR_ZONE_TOWNMAP_TABLE." where zonemap_type=$uhrow[zonemap_type]";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_4']); }
	$hrow = mysql_fetch_array($result);

	$buildingarray = explode('~',$uhrow['zonemap_buildings']);
	$buildingamount = count ($buildingarray);

	if ($buildingcell != '')
	{
		if ($buildingarray[$buildingcell-1] != '') {message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_duplicate_buildings']);}

		$buildinglist = '';
		for ($a = 0; $a < $buildingamount; $a++)
		{
			if ($a == ($buildingcell-1))
			{$buildinglist .= $buildingcellitem.'~';}
			else
			{$buildinglist .= $buildingarray[$a].'~';}
		}
	}

	$sql = "update ".ADR_ZONE_MAPS_TABLE." set zonemap_buildings='$buildinglist' where zone_id='$id'";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_8']); }


	$statinfo = '
<tr>
	<td class="row1" align="center" valign="center" colspan="2">
<br><span class="genmed">'.$lang['Adr_admin_maps_place_building_success'].'</span></td>
</tr>
<tr>
	<td class="row1" align="center" valign="center">
	<span class="genmed">'.$lang['Adr_admin_maps_main_back'].'<br><input type="submit" value="'.$lang['Adr_admin_maps_main'].'" name="mode"></span>
	</td>
	<td class="row1" align="center" valign="center"><input type="hidden" value="'.$zone_name.'" name="zone_name"><input type="hidden" value="main" name="action">
	<span class="genmed">'.$lang['Adr_admin_maps_edit_townmap_back'].'<br><input type="submit" value="'.$lang['Adr_admin_maps_zone_townmap_edit'].'" name="mode"></span>
	</td>
</tr>';


	$template->assign_vars(array(
		'STATCONFIGINFO' => "$statinfo",
		'STATTABLETITLE' => $lang['Adr_admin_maps_zone_townmap_edit'],
		'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
		'STATTITLE' => $lang['Adr_admin_maps_zone_townmap_edit'],
		'STATEXPLAIN' => $lang['Adr_admin_maps_townmaps_explain'])
	);
}

//--------------------------------Edit Zone TownMap Page END-----------------------------------------

//--------------------------------Building/City Types START-----------------------------------------

if ($mode == $lang['Adr_admin_maps_building_types'])
{
	if ($action == "main")
	{
		$sql = "select * from ".ADR_ZONE_BUILDINGS_TABLE." ORDER by sdesc";
		if ( !($iresult = $db->sql_query($sql)) )
		{
			message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_4']);
		}
		$typebuilding = ' CHECKED';
		$items = "<select name=\"buildingname\">";
		$cities = '<br><b>'.$lang['Adr_admin_maps_defined_city_images'].'</b><br><br>';
		$buildings = '<br><b>'.$lang['Adr_admin_maps_defined_building_images'].'</b><br><br>';
		$landscapes = '<br><b>'.$lang['Adr_admin_maps_defined_landscape_images'].'</b><br><br>';
		for ($x = 0; $x < mysql_num_rows($iresult); $x++)
		{
			$irow = mysql_fetch_array($iresult);
			$items .= "<option value=\"".$irow['name']."\">".ucfirst($irow['sdesc'])."</option>";
			if ($irow['zone_building_type'] == 0) {$cities .= ''.$irow['sdesc'].'<br>';}
			if ($irow['zone_building_type'] == 1) {$buildings .= ''.$irow['sdesc'].'<br>';}
			if ($irow['zone_building_type'] == 2) {$landscapes .= ''.$irow['sdesc'].'<br>';}
		}
		$items .= "</select>";
		$description = $lang['Adr_admin_maps_no_images'];
		$edit_text = $lang['Adr_admin_maps_edit_item'];
		if (is_null($irow['name'])) { $items = "<span class=\"gensmall\"><font color='red'><b>$description</b></span>"; }
		else { $items = "<span class=\"genmed\">".$items."</span><span class=\"genmed\"><input type=\"submit\" value=\"$edit_text\" name=\"action\"></span>"; }

		$statinfo = '
	<tr><td class="row2" colspan="2" align="center"><br><input type="hidden" name="mode" value="'.$lang['Adr_admin_maps_building_types'].'"><span class="genmed"><b>'.$lang['Adr_admin_maps_images_define'].'</b></span><br></td></tr>
	<tr>
		<td colspan="2" align="center" class="row2"><span class="gen"><b>'.$lang['Adr_admin_maps_add_building_new'].'</b></span></td>
	</tr>
	<tr>
		<td class="row2" width="45%">'.$lang['Adr_admin_maps_select_building'].'</td>
		<td class="row2"><span class="gen"><b>
		<input type=radio name="btype" value="0"'.$typecity.'> '.$lang['Adr_admin_maps_place_city'].' <br />
		<input type=radio name="btype" value="1"'.$typebuilding.'> '.$lang['Adr_admin_maps_place_building'].' <br />
		<input type=radio name="btype" value="2"'.$typelandscape.'> '.$lang['Adr_admin_maps_place_image'].' <br />
		</span></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_building_name'].'</b><br /><font color=red>'.$lang['Adr_admin_maps_required'].'</font> '.$lang['Adr_admin_maps_building_name_explain'].'</td>
		<td class="row2"><input type="text" name="building_name" value=""></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_building_image'].'</b><br /><font color=red>'.$lang['Adr_admin_maps_required'].'</font> '.$lang['Adr_admin_maps_building_image_explain'].'</td>
		<td class="row2"><input type="text" name="image_name" value=""></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_building_zone_link'].'</b><br />'.$lang['Adr_admin_maps_building_zone_link_explain'].'</td>
		<td class="row2"><input type="text" name="zone_link" value=""></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_building_mouseover_tag'].'</b><br />'.$lang['Adr_admin_maps_building_mouseover_tag_explain'].'</td>
		<td class="row2"><input type="text" name="zone_name_tag" value=""</td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_building_tag_no'].'</b><br />'.$lang['Adr_admin_maps_building_tag_no_explain'].'</td>
		<td class="row2"><input type="text" name="building_tag_no" value="" size="5" MAXLENGTH="5"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2">
			<input type="hidden" name="mode" value="'.$lang['Adr_admin_maps_building_types'].'" />
			<input type="submit" value="'.$lang['Adr_admin_maps_add_building'].'" name="action"></td>
	</tr>
	<br /><br />

	<tr>
		<td class="row2"><span class="gen"><b>'.$lang['Adr_admin_maps_edit_item'].':</b></span></td>
		<td class="row2">'.$items.'</td>
	</tr>
	<tr>
		<td class="row2" colspan="2">
		<table width="90%" border="0">
		<tr>
		<td align="center" valign="top"><span class="genmed">'.$cities.'</span></td>
		<td align="center" valign="top"><span class="genmed">'.$buildings.'</span></td>
		<td align="center" valign="top"><span class="genmed">'.$landscapes.'</span></td>
		</tr>
		</table>
	</tr>';

		$template->assign_vars(array(
			'STATCONFIGINFO' => "$statinfo",
			'STATTABLETITLE' => $lang['Adr_admin_maps_building_configure_title'],
			'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
			'STATTITLE' => $lang['Adr_admin_maps_building_configure_title'],
			'STATEXPLAIN' => $lang['Adr_admin_maps_building_configure_title_explain'])
		);
	}

	if ($action == $lang['Adr_admin_maps_add_building'])
	{

//check they've filled the required textfields!
		if (($building_name == '') || ($image_name == ''))
		{ message_die(GENERAL_MESSAGE,$lang['Adr_admin_maps_need_info']);}

//check if the number fields are numeric
		if (!is_numeric($building_tag_no))
		{
    		$building_tag_no1 = 999;
		}
		else
		{
    		$building_tag_no1 = $building_tag_no;
		}

//update the buildings table
		$sql2 = "INSERT INTO ".ADR_ZONE_BUILDINGS_TABLE." (name,sdesc,zone_link,zone_name_tag,zone_building_tag_no,zone_building_type) VALUES ('$image_name','$building_name','$zone_link','$zone_name_tag',$building_tag_no1,$btype)";
		if ( !($db->sql_query($sql2)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_10']); }

		$message = '<br />'. $lang['Adr_admin_maps_bulding_added'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
		$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
		message_die(GENERAL_MESSAGE, $message);
	}

	if ($action == $lang['Adr_admin_maps_edit_item'])
	{

		$sql = "select * from ".ADR_ZONE_BUILDINGS_TABLE." where name='$buildingname'";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_4']);
		}
		$buildingrow = mysql_fetch_array($result);
	
		if ($buildingrow['zone_building_type'] == 0) {$typecity = ' CHECKED';}
		if ($buildingrow['zone_building_type'] == 1) {$typebuilding = ' CHECKED';}
		if ($buildingrow['zone_building_type'] == 2) {$typelandscape = ' CHECKED';}

		$imagename = $buildingrow['name'];
		$buildingname = $buildingrow['sdesc'];
		$zonelink = $buildingrow['zone_link'];
		$zone_name_tag = $buildingrow['zone_name_tag'];
		if ( $buildingrow['zone_building_tag_no'] == 999 )
		{
			$building_tag_no = '';
		}
		else
		{
			$building_tag_no = $buildingrow['zone_building_tag_no'];
		}

		$statinfo = '
	<tr><td class="row2" colspan="2" align="center"><br><input type="hidden" name="mode" value="'.$lang['Adr_admin_maps_building_types'].'"><input type="hidden" name="upitem" value="'.$buildingname.'"><span class="genmed"><b>'.$lang['Adr_admin_maps_images_define'].'</b></span><br></td></tr>
	<tr>
		<td class="row2" align="center" valign="center"><span class="gen"><b>'.$buildingname.' is :<br /><img src="../adr/images/zones/townmap/buildings/'.$buildingrow['name'].'.gif" border="0" alt="'.$buildingrow['name'].'"></b></span></td>
		<td class="row2"><span class="gen"><b>
		<input type=radio name="btype" value="0"'.$typecity.'> '.$lang['Adr_admin_maps_place_city'].' <br />
		<input type=radio name="btype" value="1"'.$typebuilding.'> '.$lang['Adr_admin_maps_place_building'].' <br />
		<input type=radio name="btype" value="2"'.$typelandscape.'> '.$lang['Adr_admin_maps_place_image'].' <br />
		</span></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_building_name'].'</b><br /><font color=red>'.$lang['Adr_admin_maps_required'].'</font>'.$lang['Adr_admin_maps_building_name_explain'].'</td>
		<td class="row2"><input type="text" name="building_name" value="'.$buildingname.'"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_building_image'].'</b><br /><font color=red>'.$lang['Adr_admin_maps_required'].'</font>'.$lang['Adr_admin_maps_building_image_explain'].'</td>
		<td class="row2"><input type="text" name="image_name" value="'.$imagename.'"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_building_zone_link'].'</b><br />'.$lang['Adr_admin_maps_building_zone_link_explain'].'</td>
		<td class="row2"><input type="text" name="zone_link_val" value="'.$zonelink.'"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_building_mouseover_tag'].'</b><br />'.$lang['Adr_admin_maps_building_mouseover_tag_explain'].'</td>
		<td class="row2"><input type="text" name="zone_name_tag_val" value="'.$zone_name_tag.'"</td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_building_tag_no'].'</b><br />'.$lang['Adr_admin_maps_building_tag_no_explain'].'</td>
		<td class="row2"><input type="text" name="building_tag_no_val" value="'.$building_tag_no.'" size="5" MAXLENGTH="5"></td>
	</tr>
	<tr>
		<td class="row2" align="center" colspan="2"><input type="hidden" name="record_id2" value="'.$buildingrow['id'].'"><input type="submit" value="'.$lang['Adr_admin_maps_building_update'].'" name="action"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2"><input type="submit" value="'.$lang['Adr_admin_maps_building_delete'].'" name="action" style="color:white;background-color:red;"></td>
	</tr>';

		$template->assign_vars(array(
			'STATCONFIGINFO' => "$statinfo",
			'STATTABLETITLE' => $lang['Adr_admin_maps_building_configure_title'],
			'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
			'STATTITLE' => $lang['Adr_admin_maps_building_configure_title'],
			'STATEXPLAIN' => $lang['Adr_admin_maps_building_configure_title_explain'])
		);
	}

	if ($action == $lang['Adr_admin_maps_building_update'])
	{
//check they've filled the required textfields!
		if (($building_name == '') || ($image_name == ''))
		{ message_die(GENERAL_MESSAGE,$lang['Adr_admin_maps_need_info']);}

//check if the number fields are numeric
		if (!is_numeric($building_tag_no_val))
		{
    		$building_tag_no_val1 = 999;
		}
		else
		{
    		$building_tag_no_val1 = $building_tag_no_val;
		}

		$sql2 = "UPDATE ".ADR_ZONE_BUILDINGS_TABLE." SET name='$image_name',sdesc='$building_name',zone_link='$zone_link_val',zone_name_tag='$zone_name_tag_val',zone_building_tag_no=$building_tag_no_val1,zone_building_type=$btype WHERE id='$record_id2'";
		if ( !($db->sql_query($sql2)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_10']); }

		$message = '<br />'. $lang['Adr_admin_maps_bulding_added'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
		$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
		message_die(GENERAL_MESSAGE, $message);
	}
}
if ($action == $lang['Adr_admin_maps_building_delete'])
{
//update class table
	$sql2 = "DELETE FROM ".ADR_ZONE_BUILDINGS_TABLE." WHERE id='$record_id2'";
	if ( !($db->sql_query($sql2)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_10']); }


	$message = '<br />'. $lang['Adr_admin_maps_bulding_added'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
	$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
	message_die(GENERAL_MESSAGE, $message);
}

//--------------------------------Building/City Types END-----------------------------------------

//--------------------------------Building Cells START-----------------------------------------

if ($mode == $lang['Adr_admin_maps_building_cells'])
{
	if ($action == "main")
	{
		$sql = "select * from ".ADR_ZONE_TOWNMAP_TABLE." order by zonemap_type";
		if ( !($result = $db->sql_query($sql)) )
		{		message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_1'] );	}

		$zones = "<span class=\"genmed\"><select name=\"editzone\">";
		for ($x = 0; $x < mysql_num_rows($result); $x++)
		{
			$zoneinfo = mysql_fetch_array($result);
			$zones .= "<option value=\"".$zoneinfo['zonemap_type']."\">".$zoneinfo['zonemap_type']." - ".$zoneinfo['zonemap_name']."</option>";
		}
		$zones .= "</select>";

		$statinfo = '
	<tr>
		<td class="row2" colspan="2"><br></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2"><span class="gen"><b>'.$lang['Adr_admin_maps_zone_cell_edit'].'</b></span></td>
	</tr>
	<input type="hidden" name="mode" value="'.$lang['Adr_admin_maps_building_cells'].'">
	<tr>
		<td class="row2"><b>'.$lang['Adr_admin_maps_zone_cell_edit'].':</b></td>
		<td class="row2">'.$zones.'<input type="submit" value="'.$lang['Adr_admin_maps_zone_edit'].'" name="action"></td>
	</tr>';

		$template->assign_vars(array(
			'STATCONFIGINFO' => "$statinfo",
			'STATTABLETITLE' => $lang['Adr_admin_maps_zone_cell_edit'],
			'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
			'STATTITLE' => $lang['Adr_admin_maps_zone_cell_edit'],
			'STATEXPLAIN' => $lang['Adr_admin_maps_zone_cell_edit_explain'])
		);
	}
	if ($action == $lang['Adr_admin_maps_zone_edit'])
	{
		$sql = "select * from ".ADR_ZONE_TOWNMAP_TABLE." where zonemap_type=$editzone";
		if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_5']); }
		$hrow = mysql_fetch_array($result);

		$zonemap = $hrow['zonemap_bg'];
		$zwidth = $hrow['zonemap_width'];
		$zcellsh = $hrow['zonemap_cellwidth'] - 2;
		$zcellshn = $hrow['zonemap_cellwidthnumber'];
		$zheight = $hrow['zonemap_height'];
		$zcellsv = $hrow['zonemap_cellheight'] - 2;
		$zcellsvn = $hrow['zonemap_cellheightnumber'];
		$currentbuilding = explode(",",$hrow['zonemap_building']);


		$statinfo = '
	<tr>
		<td class="row2" colspan="2"><br></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2"><span class="gen"><b>'.$lang['Adr_admin_maps_zone_cell_edit_for'].' '.$hrow['zonemap_type'].' - '.$hrow['zonemap_name'].'</b></span></td>
	</tr>
	<input type="hidden" name="mode" value="'.$lang['Adr_admin_maps_building_cells'].'"><input type="hidden" name="thatzone" value="'.$editzone.'">
	<tr>
		<td class="row2" align="center">
	<br>
	<span class="genmed">'.$lang['Adr_admin_maps_zonemap_cell_explain'].'</span>
	<br>
	<table background="../adr/images/zones/townmap/'.$zonemap.'" width="'.$zwidth.'px" height="'.$zheight.'px" cellpadding=0 cellspacing=0 marginwidth=0 marginheight=0 topmargin=0 leftmargin=0 border=1>';

		$cn = 1;
		for ($sv = 1; $sv <= $zcellsvn; $sv++)
		{
			$statinfo .= '<tr>';
			for ($sh = 1; $sh <= $zcellshn; $sh++)
			{
				if (in_array($cn,$currentbuilding))
				{$statinfo .= '<td width="'.$zcellsh.'px" height="'.$zcellsv.'px"><img src="../adr/images/zones/townmap/building.gif" width="'.$zcellsh.'px" height="'.$zcellsv.'px" border="0" alt="'.$lang['Adr_admin_maps_cells'].$cn.'"></td>';}
				else
				{$statinfo .= '<td width="'.$zcellsh.'px" height="'.$zcellsv.'px"><img src="../adr/images/zones/townmap/empty.gif" width="'.$zcellsh.'px" height="'.$zcellsv.'px" border="0" alt="'.$lang['Adr_admin_maps_cells'].$cn.'"></td>';}
				$cn++;
			}
			$statinfo .= '</tr>';
		}

		$statinfo .= '</table><br></td></tr>';

		$cellamount = $zcellshn * $zcellsvn;

		$statinfo .= '
	<tr>
		<td class="row2" colspan="2" align="center">
		<br>
		<table width="95%" cellpadding=0 cellspacing=0 marginwidth=0 marginheight=0 topmargin=0 leftmargin=0 border=0>
		<tr>
		<td align="center"><span class="gen"><b>'.$lang['Adr_admin_maps_zonemap_cell_define'].'</b></span></td>
		</tr>
		<tr>';


// building cells

		$statinfo .= '
		<td align="center">
		<span class="genmed"><select name="buildingcells[]" size="15" multiple>';
		$statinfo .= ($hrow['zonemap_building'] == '') ? '<option value="" SELECTED>'.$lang['Adr_admin_maps_none'].'</option>' : '<option value="">'.$lang['Adr_admin_maps_none'].'</option>';

		for ($fc = 1; $fc <= $cellamount; $fc++)
		{
			$statinfo .= (in_array($fc,$currentbuilding)) ? '<option value="'.$fc.'" SELECTED>'.$lang['Adr_admin_maps_cells'].$fc.'</option>' : '<option value="'.$fc.'">'.$lang['Adr_admin_maps_cells'].$fc.'</option>';
		}

		$statinfo .= '</select></span></td>';
		$statinfo .= '</tr></table><tr><td class="row2" colspan="2" align="center"><span class="genmed">'.$lang['Adr_admin_maps_zonemap_cell_ctrl'].'</span></td></tr>';
		$statinfo .= '<tr><td class="row2" colspan="2" align="center"><span class="genmed"><input type="submit" value="'.$lang['Adr_admin_maps_zonemap_cell_update'].'" name="action"></span></td></tr>';

		$template->assign_vars(array(
			'STATCONFIGINFO' => "$statinfo",
			'STATTABLETITLE' => $lang['Adr_admin_maps_zone_cell_edit'],
			'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
			'STATTITLE' => $lang['Adr_admin_maps_zone_cell_edit'],
			'STATEXPLAIN' => $lang['Adr_admin_maps_zone_cell_edit_explain'])
		);

	}
	if ($action == $lang['Adr_admin_maps_zonemap_cell_update'])
	{
		$buildingcount = count($buildingcells);
		$buildingfield = '';
		if ((in_array('',$buildingcells)) && ($buildingcount > 1))
		{message_die(GENERAL_MESSAGE,$lang['Adr_admin_maps_building_info']);}
		if (!(in_array('',$buildingcells))) {for ($a = 0; $a < $buildingcount; $a++) { $buildingfield .= ','.$buildingcells[$a].'';}}

		$sql2 = "UPDATE ".ADR_ZONE_TOWNMAP_TABLE." SET zonemap_building='$buildingfield' WHERE zonemap_type=$thatzone";
		if ( !($db->sql_query($sql2)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_11']); }

		$message = '<br />'. $lang['Adr_admin_maps_building_cell_updated'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
		$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
		message_die(GENERAL_MESSAGE, $message);

	}
}
//--------------------------------Building Cells END-----------------------------------------


//--------------------------------TownMap Editor START-----------------------------------------
if ($mode == $lang['Adr_admin_maps_townmap_types'])
{
	if ($action == 'main')
	{
		$sql = "select * from ".ADR_ZONE_TOWNMAP_TABLE." order by zonemap_type";
		if ( !($result = $db->sql_query($sql)) )
		{ message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_7'] ); }

		$townmap = "<span class=\"genmed\"><select name=\"editmap\">";
		for ($x = 0; $x < mysql_num_rows($result); $x++)
		{
			$townmapinfo = mysql_fetch_array($result);
			$townmap .= "<option value=\"".$townmapinfo['zonemap_type']."\">".$townmapinfo['zonemap_type']." - ".$townmapinfo['zonemap_name']."</option>";
		}
		$townmap .= "</select>";

		$statinfo = '
	<tr>
		<td class="row2" colspan="2"><br></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2"><span class="gen"><b>'.$lang['Adr_admin_maps_zonemap_edit'].'</b></span></td>
	</tr>
	<input type="hidden" name="mode" value="'.$lang['Adr_admin_maps_townmap_types'].'">
	<tr>
		<td class="row2"><b>'.$lang['Adr_admin_maps_zonemap_edit_existing'].':</b></td>
		<td class="row2">'.$townmap.'<input type="submit" value="'.$lang['Adr_admin_maps_zonemap_edit_map'].'" name="action"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2"><span class="gen"><b>'.$lang['Adr_admin_maps_zonemap_add_new'].'</b></span></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_id'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_id_explain'].'</td>
		<td class="row2"><input type="text" name="townmaptype" value="" size="2" MAXLENGTH="2"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_name'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_name_explain'].'</td>
		<td class="row2"><input type="text" name="townmapname" value=""></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_image'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_image_explain'].'</td>
		<td class="row2"><input type="text" name="townmapbg" value=""></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_image_width'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_image_width_explain'].'</td>
		<td class="row2"><input type="text" name="townmapwidth" value="" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_cell_width'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_cell_width_explain'].'</td>
		<td class="row2"><input type="text" name="townmapcellwidth" value="20" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_cell_width_amount'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_cell_width_amount_explain'].'</td>
		<td class="row2"><input type="text" name="townmapcellwidthnumber" value="" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_image_height'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_image_height_explain'].'</td>
		<td class="row2"><input type="text" name="townmapheight" value="" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_cell_height'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_cell_height_explain'].'</td>
		<td class="row2"><input type="text" name="townmapcellheight" value="20" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_cell_height_amount'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_cell_height_amount_explain'].'</td>
		<td class="row2"><input type="text" name="townmapcellheightnumber" value="" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2"><input type="submit" value="'.$lang['Adr_admin_maps_zonemap_map_add'].'" name="action"></td>
	</tr>';

		$template->assign_vars(array(
			'STATCONFIGINFO' => "$statinfo",
			'STATTABLETITLE' => $lang['Adr_admin_maps_zonemap_map_edit'],
			'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
			'STATTITLE' => $lang['Adr_admin_maps_zonemap_map_edit'],
			'STATEXPLAIN' => $lang['Adr_admin_maps_zonemap_map_edit_explain'])
		);
	}

	if ($action == $lang['Adr_admin_maps_zonemap_map_add'])
	{

//check they've filled the textfields!
		if (($townmapname == '') || ($townmapbg == ''))
		{ message_die(GENERAL_MESSAGE,$lang['Adr_admin_maps_need_info']);}

//check if the number fields are numeric
		if ((!is_numeric($townmapwidth)) || (!is_numeric($townmapcellwidth)) || (!is_numeric($townmapcellwidthnumber)) || (!is_numeric($townmapheight)) || (!is_numeric($townmapcellheight)) || (!is_numeric($townmapcellheightnumber)) || (!is_numeric($townmaptype)))
		{ message_die(GENERAL_MESSAGE,$lang['Adr_admin_maps_need_numeric']);}

		if ($townmaptype <= 0)
		{ message_die(GENERAL_MESSAGE,$lang['Adr_admin_maps_need_negative']);}

//Check that the Town Map type doesn't already exist!
		$sql = "select zonemap_type from ".ADR_ZONE_TOWNMAP_TABLE." where zonemap_type='$townmaptype'";
		if ( !($result = $db->sql_query($sql)) )
		{ message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_12'] ); }
		$existingtownmaptype = mysql_fetch_array($result);

		if ($townmaptype == $existingtownmaptype['zonemap_type'])
		{ message_die(GENERAL_MESSAGE,$lang['Adr_admin_maps_need_exists']); }

//update house table
		$sql2 = "INSERT INTO ".ADR_ZONE_TOWNMAP_TABLE." (zonemap_type,zonemap_name,zonemap_bg,zonemap_width,zonemap_cellwidth,zonemap_cellwidthnumber,zonemap_height,zonemap_cellheight,zonemap_cellheightnumber) VALUES ($townmaptype,'$townmapname','$townmapbg',$townmapwidth,$townmapcellwidth,$townmapcellwidthnumber,$townmapheight,$townmapcellheight,$townmapcellheightnumber)";
		if ( !($db->sql_query($sql2)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_13']); }

		$message = '<br />'. $lang['Adr_admin_maps_zonemap_added'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
		$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
		message_die(GENERAL_MESSAGE, $message);
	}
}
if ($action == $lang['Adr_admin_maps_zonemap_edit_map'])
{
//get info for class being edited
	$sql = "select * from ".ADR_ZONE_TOWNMAP_TABLE." where zonemap_type=$editmap";
	if ( !($result = $db->sql_query($sql)) )
	{ message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_8'] ); }
	$row = mysql_fetch_array($result);

	$statinfo = '
	<tr>
		<td class="row2" colspan="2"><br></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2"><span class="gen"><b>'.$lang['Adr_admin_maps_zonemap_map_editing'].' '.$row['zonemap_type'].' - \''.$row['zonemap_name'].'\'</b><br /><br /><b>'.$lang['Adr_admin_maps_zonemap_map_warn'].'</b></span></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_id'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_id_explain'].'</td>
		<td class="row2"><input type="text" name="townmaptype" value="'.$row['zonemap_type'].'" size="2" MAXLENGTH="2"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_name'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_name_explain'].'</td>
		<td class="row2"><input type="text" name="townmapname" value="'.$row['zonemap_name'].'"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_image'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_image_explain'].'</td>
		<td class="row2"><input type="text" name="townmapbg" value="'.$row['zonemap_bg'].'"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2"><span class="gen"><img src="../adr/images/zones/townmap/'.$row['zonemap_bg'].'" border="0" alt="Current Town Map Background"></span></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_image_width'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_image_width_explain'].'</td>
		<td class="row2"><input type="text" name="townmapwidth" value="'.$row['zonemap_width'].'" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_cell_width'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_cell_width_explain'].'</td>
		<td class="row2"><input type="text" name="townmapcellwidth" value="'.$row['zonemap_cellwidth'].'" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_cell_width_amount'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_cell_width_amount_explain'].'</td>
		<td class="row2"><input type="text" name="townmapcellwidthnumber" value="'.$row['zonemap_cellwidthnumber'].'" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_image_height'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_image_height_explain'].'</td>
		<td class="row2"><input type="text" name="townmapheight" value="'.$row['zonemap_height'].'" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_cell_height'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_cell_height_explain'].'</td>
		<td class="row2"><input type="text" name="townmapcellheight" value="'.$row['zonemap_cellheight'].'" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td class="row2" width="45%"><b>'.$lang['Adr_admin_maps_zonemap_map_cell_height_amount'].':</b><br />'.$lang['Adr_admin_maps_zonemap_map_cell_height_amount_explain'].'</td>
		<td class="row2"><input type="text" name="townmapcellheightnumber" value="'.$row['zonemap_cellheightnumber'].'" size="8" MAXLENGTH="8"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2"><input type="hidden" name="mode" value="Town Map Types"><input type="hidden" name="origname" value="'.$row['zonemap_name'].'"><input type="hidden" name="origtype" value="'.$row['zonemap_type'].'"><input type="submit" name="action" value="'.$lang['Adr_admin_maps_zonemap_map_update'].'"></td>
	</tr>
	<tr>
		<td colspan="2" align="center" class="row2">'.$lang['Adr_admin_maps_zonemap_map_note'].'<P><input type="hidden" name="mode" value="Town Map Types"><input type="hidden" name="origname" value="'.$row['zonemap_name'].'"><input type="hidden" name="origtype" value="'.$row['zonemap_type'].'"><input type="submit" name="action" value="'.$lang['Adr_admin_maps_zonemap_map_delete'].'" style="color:white;background-color:red;"></td>
	</tr>';

	$template->assign_vars(array(
		'STATCONFIGINFO' => "$statinfo",
		'STATTABLETITLE' => $lang['Adr_admin_maps_zonemap_map_edit'],
		'S_CONFIG_ACTION' => append_sid('admin_adr_manage_zone_maps.' . $phpEx),
		'STATTITLE' => $lang['Adr_admin_maps_zonemap_map_edit'],
		'STATEXPLAIN' => $lang['Adr_admin_maps_zonemap_map_edit_explain'])
	);
}

if ($action == $lang['Adr_admin_maps_zonemap_map_update'])
{
//check they've filled the textfields!
	if (($townmapname == '') || ($townmapbg == ''))
	{ message_die(GENERAL_MESSAGE,$lang['Adr_admin_maps_need_info']); }

//check if the number fields are numeric
	if ((!is_numeric($townmapwidth)) || (!is_numeric($townmapcellwidth)) || (!is_numeric($townmapcellwidthnumber)) || (!is_numeric($townmapheight)) || (!is_numeric($townmapcellheight)) || (!is_numeric($townmapcellheightnumber)) || (!is_numeric($townmaptype)))
	{ message_die(GENERAL_MESSAGE,$lang['Adr_admin_maps_need_numeric']); }

//Check that the house type doesn't already exist!
	if ($townmaptype != $origtype)
	{
		$sql = "select zonemap_type from ".ADR_ZONE_TOWNMAP_TABLE." where zonemap_type=$townmaptype";
		if ( !($result = $db->sql_query($sql)) )
		{ message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_12'] ); }
		$existingtownmaptype = mysql_fetch_array($result);

		if ($townmaptype == $existingtownmaptype[0])
		{ message_die(GENERAL_MESSAGE,$lang['Adr_admin_maps_need_exists']); }
	}
//update house table
	$sql2 = "UPDATE ".ADR_ZONE_TOWNMAP_TABLE." SET zonemap_type=$townmaptype,zonemap_name='$townmapname',zonemap_bg='$townmapbg',zonemap_width=$townmapwidth,zonemap_cellwidth=$townmapcellwidth,zonemap_cellwidthnumber=$townmapcellwidthnumber,zonemap_height=$townmapheight,zonemap_cellheight=$townmapcellheight,zonemap_cellheightnumber=$townmapcellheightnumber WHERE zonemap_type=$townmaptype";
	if ( !($db->sql_query($sql2)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_13']); }

//update user houses
  	$u3sql="DELETE FROM ".ADR_ZONE_MAPS_TABLE." WHERE zonemap_type=$origtype";
  	if ( !($u3result = $db->sql_query($u3sql)) )
  	{
  		message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_11']);
  	}

	$message = '<br />'. $lang['Adr_admin_maps_zonemap_added'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
	$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
	message_die(GENERAL_MESSAGE, $message);
}

if ($action == $lang['Adr_admin_maps_zonemap_map_delete'])
{
//update class table
	$sql2 = "DELETE FROM ".ADR_ZONE_TOWNMAP_TABLE." WHERE zonemap_type=$origtype";
	if ( !($db->sql_query($sql2)) ) { message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_12']); }

//update Town Maps
	$u3sql="DELETE FROM ".ADR_ZONE_MAPS_TABLE." WHERE zonemap_type=$origtype";
	if ( !($u3result = $db->sql_query($u3sql)) )
	{
		message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_11']);
	}

	$message = '<br />'. $lang['Adr_admin_maps_zonemap_added'].sprintf( $lang['Adr_admin_maps_return_1'] ,"<a href=\"".append_sid("admin_adr_manage_zone_maps.".$phpEx)."\">", "</a>" );
	$message .= sprintf( $lang['Adr_admin_maps_return_2'] ,"<a href=\"".append_sid("index.".$phpEx."?pane=right")."\">","</a> to return to Admin Index.<p>" );
	message_die(GENERAL_MESSAGE, $message);
}

//--------------------------------TownMap Editor END-----------------------------------------

//
// Generate the page
//
$template->pparse('body');

include('page_footer_admin.' . $phpEx);


?>
