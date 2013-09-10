<?php
/***************************************************************************
 *                                        adr_party.php
 *                                ------------------------
 *        copyright                        :  LagunaCid
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
define('IN_ADR_CHARACTER', true);
define('IN_ADR_BATTLE', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_VAULT', true);
$phpbb_root_path = './';
include_once($phpbb_root_path . 'extension.inc');
include_once($phpbb_root_path . 'common.'.$phpEx);

$loc = 'character';
$sub_loc = 'adr_character';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
// End session management
//

include_once($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
        $redirect = "adr_character.$phpEx";
        $redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
        header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
include_once($phpbb_root_path . 'includes/page_header.'.$phpEx);
include_once($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);

// Who is looking at this page ?
$user_id = $userdata['user_id'];
$searchid = $view_userdata['user_id'];
$points = $userdata['user_points'];
$char = adr_get_user_infos($user_id);
// Boxee
?>
<table width=90% border=0 align="center" valign="center" bordercolor=black cellpadding="0" cellspacing="0">
<tr><td class="row2" align="center" valign="center">
<?php
// Actions
$action = $_GET['action'];
if($action == 'leave')
{
$can = 1;
// User is a Leader?
if($char['character_leader'] == 2)
{
// Is there any other leaders?
$sql = 'SELECT character_name FROM '.ADR_CHARACTERS_TABLE.' WHERE character_leader = 2 AND character_party = '.$char['character_party'];
$re = $db->sql_query($sql);
$row = $db->sql_fetchrow($re);
if($row['character_name']){$can = 1;}else{$can = 0;}
}
if($can == 1)
{
$sql = 'UPDATE '.ADR_CHARACTERS_TABLE.' SET character_party = 0, character_leader = 0 WHERE character_id = '.$user_id;
$re = $db->sql_query($sql) or die('Error on SQL Syntax');
$message = 'You have successfully left your party';
$char['character_party'] = 0;
}
else
{
$message = 'You cannot leave your party. You have to appoint a new leader first.';
}

}
$action = $_GET['action'];
if($action == 'disband')
{
// User is a Leader?
if($char['character_leader'] == 2)
{
$can = 1;
}
if($can == 1)
{
$sql = 'UPDATE '.ADR_CHARACTERS_TABLE.' SET character_party = 0, character_leader = 0 WHERE character_party = '.$char['character_party'];
$re = $db->sql_query($sql) or die('Error on SQL Syntax');
$message = 'You have successfully disbanded your party';
$char['character_party'] = 0;
}
else
{
$message = 'You cannot disband your party. You must be the Party Leader.';
}

}
if($action == 'create')
{
$can = 1;
// User is in a party?
if($char['character_party'] != 0)
{
$message = 'You must leave your party first.';
$can = 0;
}
// Lets Create.
$sql = "SELECT character_party FROM ".ADR_CHARACTERS_TABLE." ORDER BY character_party DESC LIMIT 1";
$re = $db->sql_query($sql) or die('SQL Error on line '.__LINE__);
$row = $db->sql_fetchrow($re);
$party_id = $row['character_party'] + 1;

$sql = 'UPDATE '.ADR_CHARACTERS_TABLE.' SET character_party = '.$party_id.', character_leader = 2 WHERE character_id = '.$user_id;
$re = $db->sql_query($sql) or die('SQL Error on line '.__LINE__);
$message = 'Your party has been successfully created.';
$char['character_party'] = $party_id;
$char['character_leader'] = 2;
}

if($action == 'invite')
{
$id = intval($_GET['id']);
$sql = 'SELECT character_invites, character_name FROM '.ADR_CHARACTERS_TABLE.' WHERE character_id = '.$id;
$re = $db->sql_query($sql) or die('SQL Query Error on line '.__LINE__);
$row = $db->sql_fetchrow($re);
$newstring = $row['character_invites'].'#'.$char['character_party'];
$sql = 'UPDATE '.ADR_CHARACTERS_TABLE.' SET character_invites = "'.$newstring.'" WHERE character_id = '.$id;
$re = $db->sql_query($sql) or die('SQL Query Error on line '.__LINE__);
$message = 'You have successfully invited '.$row['character_name'].' to join your party. '.$row['character_name'].' will receive a notification when he loads this page.';
}
if($action == 'join')
{
$id = $_GET['party'];
$sql = 'UPDATE '.ADR_CHARACTERS_TABLE.' SET character_party = '.$id.', character_invites = "", character_leader = 0 WHERE character_id = '.$user_id;
$re = $db->sql_query($sql) or die('SQL Error on line '.__LINE__);
$message = 'You have successfully joined the party. Welcome!';
$char['character_party'] = $id;
$char['character_leader'] = 0;
$char['character_invites'] = "";
}
if($action == 'refuse')
{
$id = $_GET['party'];
$invites = $char['character_invites'];
$invites = split('#',$invites);
for($i=0;$i<count($invites);$i++)
{
if($invites[$i] != $id){$newstring .= $invites[$i].'#';}
}
$newstring = substr($newstring,0,(strlen($newstring)-1));
$sql = 'UPDATE '.ADR_CHARACTERS_TABLE.' SET character_invites = "'.$newstring.'" WHERE character_id = '.$user_id;
$re = $db->sql_query($sql) or die('SQL Error on line '.__LINE__);
$message = 'You have successfully refused the invitation.';
$char['character_party'] = $id;
$char['character_leader'] = 0;
$char['character_invites'] = $newstring;
}

if($action == 'promote')
{
$id = $_GET['id'];
$sql = 'SELECT character_leader, character_name FROM '.ADR_CHARACTERS_TABLE.' WHERE character_id = '.$id.' AND character_party = '.$char['character_party'];
$re = $db->sql_query($sql);
$row = $db->sql_fetchrow($re);
if($char['character_leader'] >= $row['character_leader'] && $char['character_leader'] > 0)
{
if($row['character_leader'] > 1){$plus = 2;}else{$plus = $row['character_leader'] + 1;}
$sql = 'UPDATE '.ADR_CHARACTERS_TABLE.' SET character_leader = '.$plus.' WHERE character_id = '.$id;
$re = $db->sql_query($sql) or die('SQL Error on line '.__LINE__);
$message = $row['character_name'].' has been promoted successfully.';
}
else
{
$message = 'You cannot promote that user.';
}
}
if($action == 'kick')
{
$id = $_GET['id'];
$sql = 'SELECT character_leader, character_name FROM '.ADR_CHARACTERS_TABLE.' WHERE character_id = '.$id;
$re = $db->sql_query($sql);
$row = $db->sql_fetchrow($re);
if($char['character_leader'] > $row['character_leader'])
{
$sql = 'UPDATE '.ADR_CHARACTERS_TABLE.' SET character_leader = 0, character_party = 0 WHERE character_id = '.$id.' AND character_party = '.$char['character_party'];
$re = $db->sql_query($sql) or die('SQL Error on line '.__LINE__);
$message = $row['character_name'].' has been kicked successfully.';
}
else
{
$message = 'You cannot kick that user.';
}
}
// Message Table
?>
<table width=100% border=0 bordercolor=black cellpadding="0" cellspacing="0">
<tr><td class=row2><a name=party></a><span class=gen><center><b><?=$message?></td></tr>
</table>
<?php
// User is in a party?
if($char['character_party'] == 0)
{
?>
<table width=100% bordercolor=black border=0 cellpadding="0" cellspacing="0">
<th colspan=3>You are not in a party.</th>
<tr><td class="row1" colspan=3><center><input type=button class=liteoption value="Create a party" onClick="window.location.href='./adr_party.php?action=create#party'"></td></tr><tr><td class="row1" colspan=3><span class="gen"><a href="http://spikez.exocrew.com">MOD Written By: Spikez</a></span></td></tr>
<?php

?>
</table>
<?php
}
if($char['character_party'] != 0)
{
?><table width=100% border=0 bordercolor=black cellpadding="0" cellspacing="0">
<th colspan=3>You are in a party.</th>
<tr><td class="row1" colspan=3><center><input type=button class=liteoption value="Leave party" onClick="window.location.href='./adr_party.php?action=leave#party'"><?if($char['character_leader'] == 2){?><input type=button class=liteoption value="Disband party" onClick="window.location.href='./adr_party.php?action=disband#party'"><?}?></td></tr>
<th colspan=3>Party Members</th>
<?php
$sql = 'SELECT character_name, character_id, character_leader, character_level FROM '.ADR_CHARACTERS_TABLE.' WHERE character_party = '.$char['character_party'].' ORDER BY character_leader DESC';
$re = $db->sql_query($sql);
$rowset = $db->sql_fetchrowset($re);
for($i=0;$i<count($rowset);$i++)
{
$party_level = $party_level + $rowset[$i]['character_level'];
$party_count++;
if($char['character_leader'] > 0 && $char['character_leader'] > $rowset[$i]['character_leader']  && $char['character_leader'] > 0)
{
$kick = '<td class="row1"><center><span class=gen><input type=button class=liteoption value="Kick" onClick="window.location.href=\'./adr_party.php?action=kick&id='.$rowset[$i]['character_id'].'#party\'"></td>';
}
else if($char['character_leader'] > 0)
{
$kick = '<td class="row1"><center><span class=gen>Cant Kick</td>';
}
if($char['character_leader'] >= $rowset[$i]['character_leader'] && $rowset[$i]['character_leader'] < 2  && $char['character_leader'] > 0)
{
$promote = '<td class="row1"><center><span class=gen><input class=liteoption type=button value="Promote" onClick="window.location.href=\'./adr_party.php?action=promote&id='.$rowset[$i]['character_id'].'#party\'"></td>';
}
else if($char['character_leader'] > 0)
{
$promote = '<td class="row1"><center><span class=gen>Cant Promote</td>';
}

if($rowset[$i]['character_leader'] == 0){$rank = '<span class=gen> (Member';}
if($rowset[$i]['character_leader'] == 1){$rank = '<span class=gen><i> (Officer';}
if($rowset[$i]['character_leader'] == 2){$rank = '<span class=gen><b> (Leader';}
?>
<tr><td class="row1"><span class=gen><center><?=$rowset[$i]['character_name']?> - Level: <?=$rowset[$i]['character_level']?>  <?=$rank?>)</td><?=$kick?><?=$promote?></tr>
<?php
}
?><tr><td class="row1" colspan=3><span class=gen><center>Total Party Level: <?=$party_level?> | Party Members: <?=$party_count?> | Average Party Level <?=round($party_level/$party_count)?></td></tr><tr><td class="row1" colspan=3><span class="gen"><a href="http://spikez.exocrew.com">MOD Written By: Spikez</a></span></td></tr></table><?php
if($char['character_leader'] > 0)
{
$user_list = '<select name=members>';
$sql = 'SELECT character_name, character_id FROM '.ADR_CHARACTERS_TABLE.' WHERE character_party != '.$char['character_party'].' ORDER BY character_name';
$re = $db->sql_query($sql) or die('SQL Error on Line '.__LINE__);
$rowset2 = $db->sql_fetchrowset($re);
for($i=0;$i<count($rowset2);$i++)
{
$user_list .= '<option value='.$rowset2[$i]['character_id'].'>'.$rowset2[$i]['character_name'].' (ID: '.$rowset2[$i]['character_id'].')</option>';
}
$user_list .= '</select>';
?>
<table width=100% border=0 bordercolor=black cellpadding="0" cellspacing="0">
<th colspan=3>Invite A New Member.</th><th>Actions</th>
<tr><td class="row1" colspan=3><span class=gen><center><form name=form><?=$user_list?></td><td class="row1" colspan=3><input type=button class=liteoption value="Invite!" onClick="window.location.href='./adr_party.php?action=invite&id='+form.members.value+'#party'"></form></td></tr>
</table>
<?php
}
}
if($char['character_invites'] != '')
{
$invites = split('#',$char['character_invites']);
for($i=0;$i<count($invites);$i++)
{
if($invites[$i] != '')
{
$sql = 'SELECT character_name FROM '.ADR_CHARACTERS_TABLE.' WHERE character_party = '.$invites[$i].' AND character_leader = 2 LIMIT 1';
$re = $db->sql_query($sql);
$row = $db->sql_fetchrow($re);
$party_leader = $row['character_name'];
?>
<script>alert('You have invitation(s) to join your party!');</script>
<table width=100% border=0 bordercolor=black cellpadding="0" cellspacing="0"><th colspan=3>Invitations</th>

<tr><td class="row1" width="100%"><?=$party_leader?>'s Party</td><td class="row1"><input type=button class=liteoption value=Accept onClick="window.location.href='./adr_party.php?action=join&party=<?=$invites[$i]?>#party'"></td><td class="row1"><input type=button class=liteoption value=Refuse onClick="window.location.href='./adr_party.php?action=refuse&party=<?=$invites[$i]?>#party'"></td></tr>
</table>
<?php
}
}
}
?>
</td></tr></table>
