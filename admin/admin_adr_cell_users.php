<?php
/***************************************************************************
 *                              	   adr_admin_cell_users.php
 *                                   ------------------
 *
 *   begin                             : 26/02/2004
 *
 *
 ***************************************************************************/

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['Adr_Users']['Adr_Jail'] = $file;
	return;
}

define('IN_PHPBB', true);
define('IN_ADR_CELL', 1);

$phpbb_root_path = './../';
require($phpbb_root_path . 'extension.inc');
require("pagestart.$phpEx");
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

adr_template_file('admin/config_adr_cell_body.tpl');

$submit = isset($_POST['submit']); 
$update = isset($_POST['update']); 
$manual_update = isset($_POST['manual_update']); 
$user_update = isset($_POST['user_update']); 

if(isset($_POST['from']))
{
	$user = ($_POST['from'] == 'list') ? TRUE : FALSE;
}
else if(isset($_GET['from']))
{
	$user = ($_GET['from'] == 'list') ? TRUE : FALSE;
}
/* Removed by aUsTiN
$sql = "SELECT * FROM " . USERS_TABLE . "
	WHERE user_cell_time = 0
	AND user_id > 1
	ORDER by username";
if ( !($result = $db->sql_query($sql)) )
{
	message_die(GENERAL_ERROR, 'Could not obtain group list', '', __LINE__, __FILE__, $sql);
}

$select_list = '';
if ( $row = $db->sql_fetchrow($result) )
{
	$select_list .= '<select name="celled_id">';
	do
	{
		$select_list .= '<option value="' . $row['user_id'] . '">' . $row['username'] . '</option>';
	}
	while ( $row = $db->sql_fetchrow($result) );
	$select_list .= '</select>';
}
*/
if( $submit )
{
/* Removed by aUsTiN
	$celled_id = ( !empty($_POST['celled_id']) ) ? intval($_POST['celled_id']) : intval($_GET['celled_id']);
*/	

	#======================================================= |
	#==== Start: Add By aUsTiN ============================= |
	$jailed_username 	= ($_POST['jailed_username']) 	? $_POST['jailed_username'] : $_POST['jailed_username'];
	$jailed_userid 		= ($_POST['jailed_user_id']) 	? $_POST['jailed_user_id'] 	: $_POST['jailed_user_id'];

	#==== They Choose Both, We Cancel Username ============= |
	( ($jailed_username) && (is_numeric($jailed_userid)) ) ? $jailed_username = '' : $jailed_username = $jailed_username;

	#==== If We Dont Have A User Id, Then Use Username ===== |
	if ($jailed_username)
		{
	$q = "SELECT user_id
		  FROM ". USERS_TABLE ."
		  WHERE username = '". str_replace("\'", "''", $jailed_username) ."'";
	$r 		= $db->sql_query($q);
	$row 	= $db->sql_fetchrow($r);
		if(!$row['user_id'])
			{
		message_die(GENERAL_ERROR, 'This Username Doesn\'t Exist!', 'Error');
			}
		else
			{
		$celled_id = $row['user_id'];
			}
		}
	#==== Getting User Id Failed, Use POST ================= |
	if (!$celled_id)
		{
		#==== Make Sure What They Sent Is Numeric! ============= |
		if (!is_numeric($jailed_userid))
			{
		message_die(GENERAL_ERROR, 'User Ids <b>Are Always</b> A Numeric Value!', 'Error');
			}
		else
			{
		$celled_id = $jailed_userid;
			}
		}
				
	if (!$celled_id)
		{
	message_die(GENERAL_ERROR, 'No User Selected!', 'Error');
		}
	#==== End: Add By aUsTiN =============================== |
	#======================================================= |	
	
	$time_day 			= intval( $_POST['time_day'] );
	$time_hour 			= intval( $_POST['time_hour'] );
	$time_minute 		= intval( $_POST['time_minute'] );
	$caution 			= intval( $_POST['caution'] );
	$cautionable 		= intval( $_POST['cautionable'] );
	$freeable 			= intval( $_POST['freeable'] );
	$punishment 		= intval( $_POST['punishment'] );
	$sentence 			= addslashes(stripslashes( $_POST['sentence'] ));

	if ( ( $time_day == '' && $time_hour == '' && $time_minute == '' ) || !$punishment )
	{
		message_die(MESSAGE, $lang['Fields_empty']);
	}

	adr_cell_imprison_user($celled_id,$time_day,$time_hour,$time_minute,$caution,$cautionable,$freeable,$sentence,$punishment);

	adr_previous( Adr_cell_admin_celled_ok , admin_adr_cell_users , '' );
}

else if( $user )
{
	adr_template_file('admin/config_adr_cell_users_body.tpl');

	$user_id = ( !empty($_POST['id']) ) ? intval($_POST['id']) : intval($_GET['id']);

	$sql = "SELECT * FROM " . USERS_TABLE . "
		WHERE user_id = ".$user_id;
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain celled list', '', __LINE__, __FILE__, $sql);
	}
	$celled = $db->sql_fetchrow($result);

	$stamp_age =  $celled['user_cell_time'];
	$days = floor($stamp_age/86400);
	$stamp_age = $stamp_age - ( $days * 86400 );
	$hours = floor($stamp_age/3600);
	$stamp_age = $stamp_age - ( $hours * 3600 );
	$minutes = floor($stamp_age/60);

	$template->assign_vars(array(
		'DAY' => $days ,
		'HOUR' => $hours ,
		'MINUTE' => $minutes ,
		'FREEABLE' => ($celled['user_cell_enable_free'] ? 'CHECKED' : ''),
		'CAUTIONNABLE' => ($celled['user_cell_enable_caution'] ? 'CHECKED' : ''),
		'SELECTED_CELLED' => $celled['username'],
		'SELECTED_CELLED_ID' => $celled['user_id'],
		'CELLED_SENTENCE' => $celled['user_cell_sentence'],
		'CELLED_CAUTION' => $celled['user_cell_caution'],	
		'PUNISHMENT_GLOBAL' => ( $celled['user_cell_punishment'] == 1 ? 'CHECKED' : ''),
		'PUNISHMENT_POSTS' => ( $celled['user_cell_punishment'] == 2 ? 'CHECKED' : ''),
		'PUNISHMENT_READ' => ( $celled['user_cell_punishment'] == 3 ? 'CHECKED' : ''),
	));
}

else if( $user_update )
{
	$celled_id = ( !empty($_POST['id']) ) ? intval($_POST['id']) : intval($_GET['id']);
	$time_day = intval( $_POST['time_day'] );
	$time_hour = intval( $_POST['time_hour'] );
	$time_minute = intval( $_POST['time_minute'] );
	$caution = intval( $_POST['caution'] );
	$cautionable = intval( $_POST['cautionable'] );
	$freeable = intval( $_POST['freeable'] );
	$sentence = addslashes(stripslashes( $_POST['sentence'] ));
	$blank = intval( $_POST['blank'] );
	$punishment = intval( $_POST['punishment'] );

	if ( ( $time_day == '' && $time_hour == '' && $time_minute == '' ) || !$punishment )
	{
		message_die(MESSAGE, $lang['Fields_empty']);
	}

	$tsql = "SELECT * FROM " . ADR_JAIL_USERS_TABLE . "
		WHERE user_id = $celled_id
		ORDER BY celled_id
		DESC LIMIT 1 ";
	if ( !($tresult = $db->sql_query($tsql)) )
	{
		message_die(GENERAL_ERROR, "Could not update user's jail infos", '', __LINE__, __FILE__, $tsql);
	}
	$trow = $db->sql_fetchrow($tresult);
	$cell_id = intval($trow['celled_id']);

	if ( $blank )
	{
		$sql = "DELETE FROM " . ADR_JAIL_USERS_TABLE . " 
		WHERE user_id = $celled_id
		AND celled_id <> $cell_id ";
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR,"", __LINE__, __FILE__, $sql);
		}
		$sql = "UPDATE " . USERS_TABLE . "
		SET user_cell_celleds = 1
		WHERE user_id = $celled_id";
		if (!$db->sql_query($sql))
		{
			message_die(GENERAL_ERROR, "Could not update user's jail infos", '', __LINE__, __FILE__, $sql);
		}
	}

	$time = ( $time_day * 86400 ) + ( $time_hour * 3600 ) + ( $time_minute * 60 );

	$sql = "UPDATE " . ADR_JAIL_USERS_TABLE . "
		SET user_sentence = '$sentence', 
		    user_caution = $caution
		WHERE user_id = $celled_id
		AND celled_id = $cell_id ";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not update user's jail infos", '', __LINE__, __FILE__, $sql);
	}

	$sql = "UPDATE " . USERS_TABLE . "
		SET user_cell_time = $time ,
		user_cell_time_judgement = ".time()." ,
		user_cell_caution = $caution,
		user_cell_enable_caution = $cautionable,
		user_cell_enable_free = $freeable,
		user_cell_punishment = $punishment,
		user_cell_sentence = '$sentence'
		WHERE user_id = $celled_id";
	if (!$db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not update user's points", '', __LINE__, __FILE__, $sql);
	}
	else
	{
		adr_previous( Adr_cell_admin_celled_edited_ok , admin_adr_cell_users , '' );
	}
}

else if( $update )
{
	$sql = "SELECT * FROM " . USERS_TABLE . "
		WHERE user_cell_time > 0
		ORDER BY username";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain celled list', '', __LINE__, __FILE__, $sql);
	}
	$celleds = $db->sql_fetchrowset($result);

	$sql = array();
	
	while( list(,$celled) = @each($celleds) )
	{
		if ( isset($_POST[$celled['user_id']]))
		{
			adr_cell_free_user( $celled['user_id'] , 2 );
		}
	}
	adr_previous( Adr_cell_admin_uncelled_ok , admin_adr_cell_users , '' );
}

else if( $manual_update )
{
	$free = '';
	$free = adr_cell_update_users();
	$free = ( $free == '' ) ? $lang['None'] : $free ;

	message_die(GENERAL_MESSAGE, $lang['Adr_cell_admin_celled_manual_update_ok'].'<br />'.$free);	
}

else
{	
	$sql = "SELECT * FROM " . USERS_TABLE . "
		WHERE user_cell_time > 0
		AND user_id > 1
		ORDER by username";
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, 'Could not obtain celled list', '', __LINE__, __FILE__, $sql);
	}
	$celled = $db->sql_fetchrowset($result);

	for ( $i = 0; $i < count ( $celled ) ; $i++ )
	{
		$user_id =  $celled[$i]['user_id'];
		$template->assign_block_vars('celled',array(
			'CELLED_ID' => $celled[$i]['user_id'],
			'CELLED_NAME' => $celled[$i]['username'],
			'CELLED_SENTENCE' => $celled[$i]['user_cell_sentence'],
			'CELLED_TIME' => adr_make_time($celled[$i]['user_cell_time']),
			'CELLED_CAUTION' => $celled[$i]['user_cell_caution'],
			'U_EDIT' => append_sid("admin_adr_cell_users.$phpEx?from=list&amp;id=".$user_id.""),
		));
	}
}

$template->assign_vars(array(
	"L_CELL_TITLE" => $lang['Adr_cell_admin_title'],
	"L_CELL_TEXT" => $lang['Adr_cell_admin_title_explain'],
	"L_SUBMIT" => $lang['Submit'],
	"L_SELECT" => $lang['Adr_cell_admin_select'],
	"L_SELECT_CELLED" => $lang['Adr_cell_admin_select_user'],
	"L_DAY" => $lang['Adr_cell_days'],
	"L_HOUR" => $lang['Adr_cell_hours'],
	"L_MINUTE" => $lang['Adr_cell_minutes'],
	"L_CELL_TIME" => $lang['Adr_cell_admin_time'],
	"L_CELL_TIME_EXPLAIN" => $lang['Adr_cell_admin_time_explain'],
	"L_CELL_CAUTION" => $lang['Adr_cell_admin_caution'],
	"L_CELL_CAUTION_EXPLAIN" => $lang['Adr_cell_admin_caution_explain'],
	"L_SENTENCE" => $lang['Adr_cell_sentence_example'],
	"L_CELLED_SENTENCE" => $lang['Adr_cell_sentence'],
	"L_CELLED_SENTENCE_EXPLAIN" => $lang['Adr_cell_sentence_explain'],
	"L_CELLED_FREEABLE" => $lang['Adr_cell_freeable'],
	"L_CELLED_FREEABLE_EXPLAIN" => $lang['Adr_cell_freeable_explain'],
	"L_CELLED_CAUTIONNABLE" => $lang['Adr_cell_cautionnable'],
	"L_CELLED_CAUTIONNABLE_EXPLAIN" => $lang['Adr_cell_cautionnable_explain'],
	"L_CELLED_USERS" => $lang['Adr_cell_admin_celled_users'],
	"L_CELLED_USERS_EXPLAIN" => $lang['Adr_cell_admin_celled_users_explain'],
	"L_CELLED_NAME" => $lang['Adr_cell_admin_celled_name'],
	"L_CELLED_CAUTION" => $lang['Adr_cell_admin_celled_caution'],
	"L_CELLED_TIME" => $lang['Adr_cell_admin_celled_time'],
	"L_CELLED_FREE" => $lang['Adr_cell_admin_celled_free'],
	"L_MANUAL_UPDATE" => $lang['Adr_cell_admin_manual_update'],
	"L_MANUAL_UPDATE_EXPLAIN" => $lang['Adr_cell_admin_manual_update_explain'],
	"L_SELECTED_CELLED" => $lang['Adr_cell_selected_celled'],
	"L_CELLED_BLANK" => $lang['Adr_cell_admin_celled_blank'],
	"L_CELLED_BLANK_EXPLAIN" => $lang['Adr_cell_admin_celled_blank_explain'],
	"L_PUNISHMENT" => $lang['Adr_cell_admin_punishment'],
	"L_PUNISHMENT_GLOBAL" => $lang['Adr_cell_admin_punishment_global'],
	"L_PUNISHMENT_POSTS" => $lang['Adr_cell_admin_punishment_posts'],
	"L_PUNISHMENT_READ" => $lang['Adr_cell_admin_punishment_read'],
	"S_SELECT_CELLED" => $select_list,
	"S_SUBMIT_ACTION" => append_sid("admin_adr_cell_users.$phpEx"),
));


$template->pparse("body");

include('./page_footer_admin.'.$phpEx);

?>
