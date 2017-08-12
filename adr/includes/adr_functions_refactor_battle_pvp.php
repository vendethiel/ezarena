<?php
/* V:
 * This functions were made as modifications done to the EzArena premodded board
 * and are "just" code refactoring, because sometimes it makes me cry to have 5-times dups.
 */

function adr_pvp_substract_mp($mp_usage)
{
  global $db, $self_prefix, $battle_id;

  $sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
    SET battle_{$self_prefix}_mp = battle_{$self_prefix}_mp - " . intval($mp_usage) ."
    WHERE battle_{$self_prefix}_id = $user_id
    AND battle_id = $battle_id ";
  if( !($result = $db->sql_query($sql)) )
  {
    message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);
  }
}

function adr_pvp_inflict_damage($prefix, $damage, $battle_id)
{
  global $db;
  $sql = "UPDATE " . ADR_BATTLE_PVP_TABLE . "
    SET battle_{$prefix}_hp = battle_{$prefix}_hp - $damage
        battle_{$prefix}_dmg = $damage
    WHERE battle_id = '$battle_id'";
  if(!($result = $db->sql_query($sql))){
    message_die(GENERAL_ERROR, 'Could not update battle', '', __LINE__, __FILE__, $sql);}
}
