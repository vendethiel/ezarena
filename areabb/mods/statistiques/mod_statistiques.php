<?php

/***************************************************************************
 *                                mod_statistiques.php
 *                            -------------------
 *
 *	Adapté par Saint-Pere www.yep-yop.com
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $lang;
//chargement du template
$template->set_filenames(array(
   'statistiques' => 'areabb/mods/statistiques/tpl/mod_statistiques.tpl'
));

$total_posts = get_db_stat('postcount');
$total_topics = get_db_stat('topiccount'); 

$total_users = get_db_stat('usercount');
$newest_userdata = get_db_stat('newestuser');
$newest_user = $newest_userdata['username'];
$newest_uid = $newest_userdata['user_id'];

if( $total_posts == 0 )
{
	$l_total_post_s = $lang['Posted_articles_zero_total'];
}
else if( $total_posts == 1 )
{
	$l_total_post_s = $lang['Posted_article_total'];
}
else
{
	$l_total_post_s = $lang['Posted_articles_total'];
}

if( $total_users == 0 )
{
	$l_total_user_s = $lang['Registered_users_zero_total'];
}
else if( $total_users == 1 )
{
	$l_total_user_s = $lang['Registered_user_total'];
}
else
{
	$l_total_user_s = $lang['Registered_users_total'];
}


$template->assign_vars( array(
	'TOTAL_POSTS'	=> sprintf($l_total_post_s, $total_posts),
	'TOTAL_USERS'	=> sprintf($l_total_user_s, $total_users),
	'TOTAL_TOPICS'	=> sprintf($lang['total_topics'], $total_topics),
	'NEWEST_USER'	=> $lang['dernier_user'].areabb_profile($newest_uid,$newest_user),
	'L_STATISTICS'	=> $lang['Statistics']));
	
$template->assign_var_from_handle('statistiques', 'statistiques');

?>