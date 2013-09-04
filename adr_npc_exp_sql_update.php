<?php

define('IN_PHPBB', true);

$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
include($phpbb_root_path . 'includes/bbcode.'.$phpEx);
include($phpbb_root_path . 'includes/functions_post.'.$phpEx);

//
// Start session management
//
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);
//
// End session management
//


if( !$userdata['session_logged_in'] )
{
	$header_location = ( @preg_match('/Microsoft|WebSTAR|Xitami/', getenv('SERVER_SOFTWARE')) ) ? 'Refresh: 0; URL=' : 'Location: ';
	header($header_location . append_sid("login.$phpEx?redirect=db_update.$phpEx", true));
	exit;
}

if( $userdata['user_level'] != ADMIN )
{
	message_die(GENERAL_MESSAGE, 'You are not authorized to access this page');
}


$page_title = 'Updating the database';
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

echo '<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline">';
echo '<tr><th>Updating the NPC database</th></tr><tr><td><span class="genmed"><ul type="circle">';

$adr_zone_info = array();

$sql = "SELECT zone_id, zone_name FROM " . $table_prefix . "adr_zones";
if ( !($result = $db->sql_query($sql)) ) {message_die(GENERAL_MESSAGE, 'Error obtaining zonemap data');}
//$zone_data = $db->sql_fetchrowset($result);

while( $row = $db->sql_fetchrow($result) )
	$adr_zone_info[$row['zone_name']] = $row['zone_id'];

$sql = "SELECT * FROM " . $table_prefix . "adr_npc";
if ( !($result = $db->sql_query($sql)) ) {message_die(GENERAL_MESSAGE, 'Error obtaining NPC data');}
$data = $db->sql_fetchrowset($result);

$npc_count = count($data);

for ($x = 0; $x < $npc_count; $x++)
{
	$npc_id = $data[$x]['npc_id'];
	$npc_zone_name = $data[$x]['npc_zone'];
	$npc_zone_data = $adr_zone_info[$npc_zone_name];

echo 'NPC - ' . $data[$x]['npc_name'] . ' with NPC ID = ' . $npc_id . ' and Zone ID = ' . $npc_zone_name . ' Updated to Zone ID = ' . $npc_zone_data . '<br />';
	$sql = "UPDATE " . $table_prefix . "adr_npc SET npc_zone = '$npc_zone_data' WHERE npc_id='$npc_id'";
	if ( !($result = $db->sql_query($sql)) ) { message_die(GENERAL_MESSAGE, 'Error updating NPC Zone data'); }
}

echo '<hr>The End<br>Delete this file!';
include($phpbb_root_path . 'includes/page_tail.'.$phpEx);

?>
