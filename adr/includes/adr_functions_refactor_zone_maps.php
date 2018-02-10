<?php
/* V:
 * This functions were made as modifications done to the EzArena premodded board
 * and are "just" code refactoring, because sometimes it makes me cry to have 5-times dups.
 */

function adr_map_get_world()
{
  global $db, $lang;

  $sql = "SELECT zone_name, zone_id
     FROM " . ADR_ZONES_TABLE . "
     WHERE zone_name = 'World Map'";
  if ( !($result = $db->sql_query($sql)) )
    message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_2']);
  $worldmap = $db->sql_fetchrow($result);
  $db->sql_freeresult($result);
  if ($worldmap)
  {
    if ($board_config['Adr_zone_worldmap_zone'] != $worldmap['zone_id'])
      adr_zone_map_update_config($worldmap['zone_id']);
    return $worldmap['zone_id'];
  }
  else
  {
		$sql = "INSERT INTO " . ADR_ZONES_TABLE . " (zone_name, zone_desc, zone_img, zone_element, return_name) VALUES ('World Map', 'Map of the World', 'World.gif', 'Earth', 'World Map')";
    if ( !($result = $db->sql_query($sql)) )
      message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_11']);
    $db->sql_freeresult($result);
    $worldmap_id = $db->sql_nextid();
    adr_zone_map_update_config($worldmap_id);
    return $worldmap_id;
  }
}

function adr_zone_map_update_config($worldmap_id)
{
  global $db, $lang;

  $sql = "UPDATE " . CONFIG_TABLE . " SET config_value = '$bottom_zone' WHERE config_name = 'Adr_zone_worldmap_zone'";
  if (!$db->sql_query($sql))
    message_die(GENERAL_ERROR, $lang['Adr_admin_maps_error_14']);

  $sql = "UPDATE ". ADR_ZONE_MAPS_TABLE . " SET zone_id = '$bottom_zone' WHERE zone_world = 1";
  if (!$db->sql_query($sql))
    message_die(GENERAL_MESSAGE, $lang['Adr_admin_maps_error_1']);
}
