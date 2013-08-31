<?php
/*****************************************************************************
*
*		admin_news.php
*
* commencé le 17 Août 2006 par Saint-Pere - www.yep-yop.com
*
*
******************************************************************************/


define('IN_PHPBB', 1);

if( !empty($setmodules) )
{
	$file = basename(__FILE__);
	$module['AreaBB Extensions']['Les news'] = '../areabb/mods/news/'.$file;
	return;
}
//
// Let's set the root dir for phpBB
//
define('ROOT_STYLE','admin');
$phpbb_root_path = "../../../";
require($phpbb_root_path . 'extension.inc');
require($phpbb_root_path . 'admin/pagestart.' . $phpEx);
include($phpbb_root_path . 'areabb/fonctions/preload.' . $phpEx);
load_lang('admin');
load_lang('news');

// --------------------------------------------------------------------------------------------
// TRAITEMENT des données
//
if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action	= $HTTP_POST_VARS['action']; 
		if (isset($HTTP_POST_VARS['news_forums']))
		{
			$HTTP_POST_VARS['news_forums'] = implode(',',$HTTP_POST_VARS['news_forums']);
		}
		
	}else{
		$action	= $HTTP_GET_VARS['action']; 
	}

	switch($action)
	{
		case 'enregistrer':
			// Enregistrement des modifications effectuées sur la config générale	
			$sql = 'SELECT * FROM ' . AREABB;
			if(!$result = $db->sql_query($sql))
			{
				message_die(CRITICAL_ERROR, "Could not query config information in admin", "", __LINE__, __FILE__, $sql);
			}
			while( $row = $db->sql_fetchrow($result) )
			{
				$nom = $row['nom'];
				$valeur = $row['valeur'];
				$default[$nom] = $valeur;
				
				$new[$nom] = ( isset($HTTP_POST_VARS[$nom]) ) ? $HTTP_POST_VARS[$nom] : $default[$nom];
		
				$sql = 'UPDATE ' . AREABB . ' 
					SET valeur = \'' . str_replace("\'", "''", $new[$nom]) . '\'
					WHERE nom = \''.$nom.'\'';
				if( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Failed to update areabb ', '', __LINE__, __FILE__, $sql);
				}
			}
		break;
	}

}

// --------------------------------------------------------------------------------------------
//    AFFICHAGE
//

$template->set_filenames(array(
	'body' => 'areabb/mods/news/tpl/admin_news.tpl'
));

//
// INFOS sur l'Arcade 

$sql = 'SELECT * FROM ' . AREABB;
if(!$result = $db->sql_query($sql))
{
	message_die(CRITICAL_ERROR, "Could not query config information in admin_arcade", "", __LINE__, __FILE__, $sql);
}
while( $row = $db->sql_fetchrow($result) )
{
	$new[$row['nom']]= $row['valeur'];	
}

$forums_de_news = explode(',',$new['news_forums']);
$s_news_forums = '';

// V: let's adapt sf+
// quels sont les forums de news ? 

$sql = "SELECT cat_id, cat_title, cat_order
	FROM " . CATEGORIES_TABLE . "
	ORDER BY cat_order";
if( !$q_categories = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Could not query categories list", "", __LINE__, __FILE__, $sql);
}

if( $total_categories = $db->sql_numrows($q_categories) )
{
	$category_rows = $db->sql_fetchrowset($q_categories);

	$sql = "SELECT *
		FROM " . FORUMS_TABLE . "
		ORDER BY cat_id, forum_order";
	if(!$q_forums = $db->sql_query($sql))
	{
		message_die(GENERAL_ERROR, "Could not query forums information", "", __LINE__, __FILE__, $sql);
	}

	if( $total_forums = $db->sql_numrows($q_forums) )
	{
		$forum_rows = $db->sql_fetchrowset($q_forums);
	}

	//
	// Okay, let's build the index
	//
	$gen_cat = array();

	for($i = 0; $i < $total_categories; $i++)
	{
		// V: let's integrate subforums+ here...
		$_sf_forum_keys = array();
		$cat_id = $category_rows[$i]['cat_id'];

		$s_news_forums .= ($s_news_forums ? '</optgroup>' : '') . '<optgroup label="' . $category_rows[$i]['cat_title'] . '">';
		for($j = 0; $j < $total_forums; $j++)
		{
			if ($forum_rows[$j]['cat_id'] != $cat_id)
			{
				continue;
			}
			if ( intval($forum_rows[$j]['forum_parent']) && !isset($_sf_forum_keys[ intval($forum_rows[$j]['forum_parent']) ]) )
			{
				continue;
			}

			$_sf_forum_keys[ $forum_rows[$j]['forum_id'] ] = $j;
			$forum_rows[$j]['_sf_nest_level'] = intval($forum_rows[$j]['forum_parent']) ? intval($forum_rows[ $_sf_forum_keys[ intval($forum_rows[$j]['forum_parent']) ] ]['_sf_nest_level']) + 1 : 0;

			$forum_id = $forum_rows[$j]['forum_id'];
			$selected = in_array($forum_rows[$j]['forum_id'], $forums_de_news) ? 'selected' : '';

			$s_news_forums .= '<option value="' . $forum_id . '" ' . $selected . '>'
			 . ($forum_rows[$j]['_sf_nest_level'] ? implode('', array_pad(array(), ($forum_rows[$j]['_sf_nest_level'] - 1) * 4
			 , '&nbsp;')) . '--&nbsp;' : '') . $forum_rows[$j]['forum_name'] . ' '
			 . ($forum_rows[$j]['forum_external'] ? $lang['paren_external'] : '') . '</option>';
		}
	}
}

// Nombre de mots
$s_news_nbre_mots = ( $new['news_nbre_mots'] == '') ? '200' : $new['news_nbre_mots'];
// Nombre de commentaires
$s_news_nbre_coms = ( $new['news_nbre_coms'] == '') ? '10' : $new['news_nbre_coms'];
// Nombre de news
$s_news_nbre_news = ( $new['news_nbre_news'] == '') ? '10' : $new['news_nbre_news'];
// Afficher Icone ?
$s_news_aff_icone_yes = ( $new['news_aff_icone'] == 1) ? 'checked' : '';
$s_news_aff_icone_no = ( $new['news_aff_icone'] == 0) ? 'checked' : '';
$sql = 'SHOW COLUMNS FROM '.FORUMS_TABLE;
if( ! $result = $db->sql_query($sql) )
{
	message_die(GENERAL_ERROR, "Impossible d'accéder aux stats de la table FORUMS", "", __LINE__, __FILE__, $sql);
}
unset($liste_colonnes);
while ( $row = $db->sql_fetchrow( $result ) )
{
	$liste_colonnes[] = $row['Field'];
}
$desactive_icon = (in_array('forum_icon',$liste_colonnes))? 'enabled':'disabled';
// Afficher commentaires ?
$s_news_aff_coms_yes = ( $new['news_aff_coms'] == 1) ? 'checked' : '';
$s_news_aff_coms_no = ( $new['news_aff_coms'] == 0) ? 'checked' : '';
// Afficher l'ASV ?
$s_news_aff_asv_yes = ( $new['news_aff_asv'] == 1) ? 'checked' : '';
$s_news_aff_asv_no = ( $new['news_aff_asv'] == 0) ? 'checked' : '';


$template->assign_vars(array(	
	'L_YES'					=> $lang['Yes'],
	'L_NO'					=> $lang['No'],
	'L_FORUMS_NEWS'			=> $lang['L_FORUMS_NEWS'],
	'L_NBRE_MOTS'			=> $lang['L_NBRE_MOTS'],
	'L_NBRE_COMS'			=> $lang['L_NBRE_COMS'],
	'L_NBRE_NEWS'			=> $lang['L_NBRE_NEWS'],
	'L_AFF_ICONE'			=> $lang['L_AFF_ICONE'],
	'L_AFF_COMS'			=> $lang['L_AFF_COMS'],
	'L_AFF_ASV'				=> $lang['L_AFF_ASV'],
	's_news_forums' 		=> $s_news_forums,
	's_news_nbre_mots'		=> $s_news_nbre_mots,
	's_news_nbre_coms'		=> $s_news_nbre_coms,
	's_news_nbre_news'		=> $s_news_nbre_news,
	's_news_aff_icone_yes'	=> $s_news_aff_icone_yes,
	's_news_aff_icone_no'	=> $s_news_aff_icone_no,
	'desactive_icon'		=> $desactive_icon,
	's_news_aff_coms_yes'	=> $s_news_aff_coms_yes,
	's_news_aff_coms_no'	=> $s_news_aff_coms_no,
	's_news_aff_asv_yes'	=> $s_news_aff_asv_yes,
	's_news_aff_asv_no'		=> $s_news_aff_asv_no,
	'L_GENERAL_NEWS_ADMIN'	=> $lang['L_GENERAL_NEWS_ADMIN'],
	'L_GENERAL_NEWS_ADMIN_EXP'=>$lang['L_GENERAL_NEWS_ADMIN_EXP'],
	'L_GENERAL_SETTINGS'	=> $lang['General_arcade_settings'],
	'L_SUBMIT'				=> $lang['Submit'],
	'L_RESET'				=> $lang['Reset']
	));


$template->pparse('body');
include($phpbb_root_path . 'admin/page_footer_admin.'.$phpEx);