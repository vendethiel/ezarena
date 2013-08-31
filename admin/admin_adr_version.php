<?php
/***************************************************************************
 *                              admin_adr_version.php
 *                            ------------------
 *   begin                : 23/03/2006
 *
 *
 ***************************************************************************/

define('IN_PHPBB', 1);
define('IN_ADR_ADMIN', 1);
define('IN_ADR_TOOLS', 1);

if( !empty($setmodules) )
{
	$filename = basename(__FILE__);
	$module['Adr_Tools']['Check ADR Version'] = "$filename?mode=version";
	return;
}

$phpbb_root_path = "./../";
require($phpbb_root_path . 'extension.inc');
require("pagestart.$phpEx");
include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);
adr_template_file('admin/config_adr_version_body.tpl');

	##=== START: Check for new ADR version
	$current_version = explode('.', $board_config['Adr_version']);
	$errno = 0;
	$errstr = $version_info = '';

	if($fsock = @fsockopen('www.adr-support.com', 80, $errno, $errstr))
	{
		@fputs($fsock, "GET /adr_update_check/adr_check.txt HTTP/1.1\r\n");
		@fputs($fsock, "HOST: www.adr-support.com\r\n");
		@fputs($fsock, "Connection: close\r\n\r\n");

		$get_info = false;
		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$version_info .= @fread($fsock, 1024);
			}
			else
			{
				if (@fgets($fsock, 1024) == "\r\n")
				{
					$get_info = true;
				}
			}
		}
		@fclose($fsock);

		$version_info = explode("\n", $version_info);
		$latest_head_revision = (int) $version_info[0];
		$latest_minor_revision = (int) $version_info[2];
		$latest_version = (int) $version_info[0] . '.' . (int) $version_info[1] . '.' . (int) $version_info[2];

		if($board_config['Adr_version'] == $latest_version)
		{
			$version_info = '<p style="color:green">Your current ADR installation appears to be up-to-date.<br>Latest release: v'.$board_config['Adr_version'].'</p>';
		}
		elseif($board_config['Adr_version'] > $latest_version)
		{
			$version_info = '<p style="color:green">You are running v'.$board_config['Adr_version'].' which appears to be a private pre-release of ADR.<br><br>Thank you for testing this new version out!<br><br>This message should disappear once an offical release is made on the ADR Support Forums. If it has not then please PM and kick Seteo-Bloke in the nads for not updating the "adr_check.txt" file.</p>';
		}				
		else
		{
			$version_info = '<p style="color:red"><b>Your ADR installation does NOT appear to be up-to-date!</b><br>';
			$version_info .= '<br />' . sprintf('You should upgrade to v%s as soon as possible!', $latest_version).'<br /><br />'. sprintf('You are currently running v%s', $board_config['Adr_version']) . '.</p>';
			$version_info .= '<a href="http://www.adr-support.com/adr_support/index.php" target="_blank">Visit the ADR Support forum for the download</a>';
		}

		##=== START: bug reports block ===##
		$show_all = intval($_GET['show_all']);
		$install_tag_link = intval($_GET['install_tag_link']);
		$install_tag_code = $_GET['install_tag_code'];

		// First we need to sort out any install/uninstall tags
		if($install_tag_link == '1'){
			// Tag fix as installed
			$sql = "INSERT INTO " . ADR_BUG_FIX . " 
				(fix_id, fix_install_date, fix_installed_by)
				VALUES('$install_tag_code', ".time().", ".$userdata['user_id'].")";
			$result = $db->sql_query($sql);
			if(!$result) message_die(GENERAL_ERROR, "Could NOT tag fix into db", "", __LINE__, __FILE__, $sql);
		}
		if($install_tag_link == '2'){
			// Remove tag for fix
			$sql = "DELETE FROM " . ADR_BUG_FIX ."
				WHERE fix_id = '$install_tag_code'";
			$result = $db->sql_query($sql);
			if(!$result){
				message_die(GENERAL_ERROR, 'Could NOT remove tagged fix from db', "", __LINE__, __FILE__, $sql);}
		}

		$lines = file('http://www.adr-support.com/adr_update_check/adr_'.$current_version[0].''.$current_version[1].''.$current_version[2].'_bugs.txt');
		foreach ($lines AS $line_num => $line){
			$bug_explode = explode(';', $line);
			$row_class = (!($line_num %2)) ? $theme['td_class1'] : $theme['td_class2'];

			// Grab list of fixes currently installed on board
			$sql = "SELECT fix_id FROM ". ADR_BUG_FIX."
					WHERE fix_id = '".$bug_explode[0]."'";
			$result = $db->sql_query($sql);
			if (!$result) message_die(GENERAL_ERROR, 'Could not obtain bug fix list infos', '', __LINE__, __FILE__, $sql);
			$fix_sql = $db->sql_fetchrow($result);

			if(($show_all == '1') || (($show_all == '0') && (!$fix_sql['fix_id']))){
				$bug_explode[1] = adr_link_length($bug_explode[1], '95');

				if(($show_all == '0') || (($show_all == '1') && (!$fix_sql['fix_id']))){
					$install_tag = '[Not Installed]';
					$install_tag_link = append_sid("admin_adr_version.$phpEx?install_tag_link=1&install_tag_code=$bug_explode[0]");
					$install_tag_link_alt = 'Click here to tag this fix as installed on your current ADR installation!';}
				if(($show_all == '1') && ($fix_sql['fix_id'])){
					$install_tag = '[Installed]';
					$install_tag_link = append_sid("admin_adr_version.$phpEx?install_tag_link=2&install_tag_code=$bug_explode[0]");
					$install_tag_link_alt = 'Click here to tag this fix as NOT installed on your current ADR installation!';}

				// Make severity colours
				if($bug_explode[3] === 'High') $bug_explode[3]= '<font color="#FF0000"><b>'.$bug_explode[3].'</b></font>';
				elseif($bug_explode[3] === 'Moderate') $bug_explode[3]= '<font color="#0000FF">'.$bug_explode[3].'</font>';
				else $bug_explode[3] = '<font color="#000000">'.$bug_explode[3].'</font>';

				// Make table
				$bug_table .= '<tr><td class="'.$row_class.'" align="center">#'.$bug_explode[0].'</td>';
				$bug_table .= '<td class="'.$row_class.'" align="left">&nbsp;&nbsp;<a href='.$bug_explode[2].' target="_blank" title="Click to follow link to adr-support.com to read & apply the bug fix details!"><i><span class="genbig">"'.$bug_explode[1].'"</span></a><br>&nbsp;&nbsp;<span class="gensmall">Originally reported by:&nbsp;'.$bug_explode[5].';&nbsp;Fixed by:&nbsp;'.$bug_explode[6].'.</i></span></td>';
				$bug_table .= '<td class="'.$row_class.'" align="center"><span class="gensmall"><a href="'.$install_tag_link.'" title="'.$install_tag_link_alt.'">'.$install_tag.'</a></span></td>';
				$bug_table .= '<td class="'.$row_class.'" align="center">'.$bug_explode[3].'</td>';
				$bug_table .= '<td class="'.$row_class.'" align="center">'.$bug_explode[4].'</td></tr>';
			}
		}
		$bug_table = ($bug_table == '') ? '<td class="row2" align="center" colspan="5">No new bug fixes available for your current ADR installation!</td>' : $bug_table;
		$bug_show_link = ($show_all == '0') ? append_sid("admin_adr_version.$phpEx?show_all=1") : append_sid("admin_adr_version.$phpEx?show_all=0");
		##=== END: bug reports block ===##
	}
	else
	{
		$version_info = '<p style="color:red">' . 'Could not connect to ADR Support server to check for latest version details.<br><br>Please try again later.' . '</p>';
	}

	$template->assign_vars(array(
		'ADR_VERSION_INFO'	=> $version_info,
		'ADR_BUG_TABLE' => $bug_table,
		'BUG_SHOW_TYPE' => ($show_all == '0') ? '[Show all bug fixes available from adr-support.com for ADR v'.$board_config['Adr_version'].']' : '[Only list bug fixes not marked as installed]',
		'BUG_SHOW_LINK' => $bug_show_link,
		'L_ADR_VERSION_INFORMATION'	=> 'ADR Version Checker',
		'L_ADR_BUGS' => 'Latest Available Bug Fixes for ADR v'.$board_config['Adr_version'].'',
		'L_CODE' => '#',
		'L_REPORT' => 'Report Details...',
		'L_STATUS' => 'Status',
		'L_DATE' => 'Date Issued',
		'L_SEVERITY' => 'Severity'
	));
	##=== END: Check for new ADR version

$template->pparse('body');
include('./page_footer_admin.'.$phpEx);
?>
