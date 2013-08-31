<?php
define('IN_PHPBB', true);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'config.'.$phpEx);
include($phpbb_root_path . 'includes/constants.'.$phpEx);
include($phpbb_root_path . 'includes/db.'.$phpEx);

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

$id = (is_numeric($_GET['id'])) ? $_GET['id'] : '';

if(!$id)
{
	echo '<strong>ERROR:</strong> Please enter a VALID click ID in URL';
	exit;
}

$sql = $db->sql_query('UPDATE '.CLICKS_TABLE.' SET clicks=clicks+1 WHERE id=\''.$id.'\'');
$sql = $db->sql_query('SELECT url FROM '.CLICKS_TABLE.' WHERE id=\''.$id.'\' LIMIT 0,1');
$row = $db->sql_fetchrow($sql);

$row['url'] = ($row['url']) ? stripslashes($row['url']) : 'http://www.google.com/';

header("Status: 301 Moved Permanently", false, 301);
header("Location: ".trim($row['url']));
exit;
?>