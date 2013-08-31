<?php

/***************************************************************************
 *                                mod_news.php
 *                            -------------------
*
*	Adapté par Saint-Pere www.yep-yop.com
 *
 ***************************************************************************/


if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}
global $HTTP_POST_VARS,$HTTP_GET_VARS;
define('max_pages_affiche',15);
load_function('fonctions_chaine');

function  pagination_coms($topic_id,$nbre_coms,$start)
{
	global $areabb,$phpEx;
	
	$max_pages = ceil($nbre_coms / $areabb['news_nbre_coms']);
	$max_pages = (max_pages_affiche < $max_pages )? max_pages_affiche:$max_pages;
	$pagination = '';
	for ($i=0;$i<$max_pages;$i++)
	{
		if ($start == ($i * $areabb['news_nbre_coms']))
		{
			$pagination .= '<b>'.($i+1).'</b>&nbsp;&nbsp;';
		}else{
			$pagination .= '<a href="'.append_sid(NOM_NEWS.'.'.$phpEx.'?action=detail&article='.$topic_id.'&start='.($i * $areabb['news_nbre_coms'])).'" alt="'.$i.'">'.($i+1).'</a>&nbsp;&nbsp;';
		}
	}
	return $pagination;
}
function  pagination_news($param,$nbre_news,$start)
{
	global $areabb,$phpEx;
	
	$max_pages = ceil($nbre_news / $areabb['news_nbre_news']);
	$max_pages = (max_pages_affiche< $max_pages )? max_pages_affiche:$max_pages;

	$pagination = '';
	for ($i=0;$i<$max_pages;$i++)
	{
		if ($start == ($i * $areabb['news_nbre_news']))
		{
			$pagination .= '<b>'.($i+1).'</b>&nbsp;&nbsp;';
		}else{
			$pagination .= '<a href="'.append_sid(NOM_NEWS.'.'.$phpEx.'?'.$param.'&start='.($i * $areabb['news_nbre_news'])).'" alt="'.$i.'">'.($i+1).'</a>&nbsp;&nbsp;';
		}
	}
	return $pagination;
}


if (isset($HTTP_POST_VARS['action']) || isset($HTTP_GET_VARS['action']))
{
	if (isset($HTTP_POST_VARS['action'])) 
	{
		$action = $HTTP_POST_VARS['action']; 
		
	}else{
		$action = $HTTP_GET_VARS['action']; 
		$date_news =  eregi_replace('[^0-9-]','',$HTTP_GET_VARS['date_news']);
		$page =  eregi_replace('[^?0-9]','',$HTTP_GET_VARS['page']);
		$article =  eregi_replace('[^0-9]','',$HTTP_GET_VARS['article']);
		$cat = eregi_replace('[^0-9]','',$HTTP_GET_VARS['cat']);
	}
	
	
}

switch ($action)
{
	case 'detail':
		// On affiche 1 seul article et de manière détaillée
		include_once($phpbb_root_path.'areabb/mods/news/includes/inc_detail.'.$phpEx);
		break;
	case 'date':
		// On affiche les news d'une date bien précise
		include_once($phpbb_root_path.'areabb/mods/news/includes/inc_date.'.$phpEx);
		break;
	case 'categorie':
		// on affiche les news d'1 seul forum
		include_once($phpbb_root_path.'areabb/mods/news/includes/inc_categorie.'.$phpEx);
		break;
	case 'normal':	
	default:
		// IDEM : On affiche les chapeaux des X derniers articles
		include_once($phpbb_root_path.'areabb/mods/news/includes/inc_normal.'.$phpEx);
		break;

}



	
$template->assign_var_from_handle('news', 'news');

?>