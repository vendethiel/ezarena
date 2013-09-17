<?php 
/***************************************************************************
 *					adr_research.php
 *				------------------------
 *	begin 			: 01/07/2007
 *	copyright		: egdcltd (http://games.directorygold.com)
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
define('IN_ADR_LIBRARY', true);
define('IN_ADR_CHARACTER', true);
define('IN_ADR_SHOPS', true);
define('IN_ADR_CRAFTING', true);
$phpbb_root_path = './'; 
include($phpbb_root_path . 'extension.inc'); 
include($phpbb_root_path . 'common.'.$phpEx);

$loc = 'skills';
$sub_loc = 'adr_research';

//
// Start session management
$userdata = session_pagestart($user_ip, PAGE_ADR); 
init_userprefs($userdata); 
// End session management
//

$user_id = $userdata['user_id'];
$points = $userdata['user_points'];

include($phpbb_root_path . 'adr/includes/adr_global.'.$phpEx);

// Sorry , only logged users ...
if ( !$userdata['session_logged_in'] )
{
	$redirect = "adr_research.$phpEx";
	$redirect .= ( isset($user_id) ) ? '&user_id=' . $user_id : '';
	header('Location: ' . append_sid("login.$phpEx?redirect=$redirect", true));
}

// Includes the tpl and the header
adr_template_file('adr_research_body.tpl');
include($phpbb_root_path . 'includes/page_header.'.$phpEx);

// Get the general config
$adr_general = adr_get_general_config();

adr_enable_check();
adr_ban_check($user_id);
adr_character_created_check($user_id);
$adr_user = adr_get_user_infos($user_id);

$actual_zone = $adr_user['character_area'];

$sql = " SELECT * FROM  " . ADR_ZONES_TABLE . "
       WHERE zone_id = $actual_zone ";
if( !($result = $db->sql_query($sql)) )
        message_die(GENERAL_ERROR, 'Could not query area list', '', __LINE__, __FILE__, $sql);

$info = $db->sql_fetchrow($result);
$access = $info['zone_research'];

if ( $access == '0' )
	adr_previous( Adr_zone_building_noaccess , adr_zones , '' );

// Get Zone infos
$area_id = $adr_user['character_area'];

if( isset($HTTP_POST_VARS['mode']) || isset($HTTP_GET_VARS['mode']) )
{
	$mode = ( isset($HTTP_POST_VARS['mode']) ) ? $HTTP_POST_VARS['mode'] : $HTTP_GET_VARS['mode'];
	$mode = htmlspecialchars($mode);	
}
else
{
	$mode = "";
}

if ( $mode != "" )
{
	switch($mode)
	{
		case 'library_action' :

			//Cost for using library
			adr_substract_points($user_id, 100,'', adr_research);

			//Research success calculation
			$rand = rand(1,20);

			//Critical failure
			if($rand == '1')
			{
				$book_false = '1';
			}
			else
			{
				$research = ($rand + adr_modifier_calc($adr_user['character_intelligence']));

				if($research >= '150') $book_difficulty = '7';
				elseif(($research >= '100') && ($research < '150'))$book_difficulty = '6';
				elseif(($research >= '75') && ($research < '100'))$book_difficulty = '5';
				elseif(($research >= '45') && ($research < '75'))$book_difficulty = '4';
				elseif(($research >= '30') && ($research < '45'))$book_difficulty = '3';
				elseif(($research >= '20') && ($research < '30'))$book_difficulty = '2';
				elseif(($research >= '12') && ($research < '20'))$book_difficulty = '1';
				elseif(($research >= '1') && ($research < '12'))$book_difficulty = '0';
			}

			if($book_false)
			{
				$sql = "SELECT *
					FROM " . ADR_LIBRARY_TABLE ."
					WHERE book_false = $book_false";
				$result = $db->sql_query($sql);
				if( !$result )
				{
					message_die(GENERAL_ERROR, 'Could not obtain book information', "", __LINE__, __FILE__, $sql);
				}

				$library = array();
				while ( $row = $db->sql_fetchrow($result) )
				{
					// Loop through all rows:

					if ( $row['book_zone'] != '0' )
					{
						// Check to see if the area id is in the book zone
 						$book_zone = explode(",", $row['book_zone']);    // Create our array
						$success = in_array($area_id, $book_zone);   // Check our array
					}
					else
					{
						$success = true;
					}

					if ( $success )
					{
						// This row PASSES all checks so should be stored.
						$library[] = $row;
					}

				}
			}
			else
			{
				$sql = "SELECT *
					FROM " . ADR_LIBRARY_TABLE ."
					WHERE book_difficulty <= $book_difficulty 
					AND book_false = '0'";
				$result = $db->sql_query($sql);
				if( !$result )
				{
					message_die(GENERAL_ERROR, 'Could not obtain book information', "", __LINE__, __FILE__, $sql);
				}

				$library = array();
				while ( $row = $db->sql_fetchrow($result) )
				{
					// Loop through all rows:

					if ( $row['book_zone'] != '0' )
					{
						// Check to see if the area id is in the book zone
 						$book_zone = explode(",", $row['book_zone']);    // Create our array
						$success = in_array($area_id, $book_zone);   // Check our array
					}
					else
					{
						$success = true;
					}

					if ( $success )
					{
						// This row PASSES all checks so should be stored.
						$library[] = $row;
					}

				}

			}

			if ( !$library )
			{
				adr_previous ( Adr_library_failure , adr_research , '' );
			}
			else
			{
				// Now roll for research
				$rand_library = $library[array_rand($library, 1)];
				$book_name = $rand_library['book_name'];
				$book_details = $rand_library['book_details'];
				$research_keep = intval($HTTP_POST_VARS['research_keep']);
				$crafting_recipe = $rand_library['book_crafting'];

				if($crafting_recipe)
				{
					//get now all info of the up-to-date recipe in the forums shop (id 1) (Admin might have changed or deleted it)
  					$sql_admin = "SELECT * FROM ". ADR_SHOPS_ITEMS_TABLE ."
						WHERE item_owner_id = 1
						AND item_id = " . $crafting_recipe;
						$result_admin = $db->sql_query($sql_admin);
					if( !($admin_recipe = $db->sql_fetchrow($result_admin)) ) 
					{
						//recipe deleted
					}
					else 
					{
						//check if the user already has written the recipe into the recipebook
	  					$sql_check_book = "SELECT * FROM ". ADR_RECIPEBOOK_TABLE ."
							WHERE recipe_original_id = ".$admin_recipe['item_id']."
							AND recipe_owner_id = $user_id
							AND recipe_skill_id = ".$admin_recipe['item_recipe_skill_id']."
							";
						$result_check_book = $db->sql_query($sql_check_book);
						if( $check_book = $db->sql_fetchrow($result_check_book) ) 
						{
							//recipe already known
						}
						else if (!($check_book = $db->sql_fetchrow($result_check_book))) 
						{
							//get new recipe_id
							$sql = "SELECT recipe_id FROM " . ADR_RECIPEBOOK_TABLE ."
								WHERE recipe_skill_id = ".$admin_recipe['item_recipe_skill_id']."
								ORDER BY recipe_id
								DESC LIMIT 1";
							$result = $db->sql_query($sql);
							if( !$result )
							{
								message_die(GENERAL_ERROR, 'Could not obtain recipes total entrys', "", __LINE__, __FILE__, $sql);
							}
							$recipebook_data = $db->sql_fetchrow($result);
							$new_recipe_id = $recipebook_data['recipe_id'] + 1;

							//write recipe into the owners recipebook
							$sql = "INSERT INTO " . ADR_RECIPEBOOK_TABLE . " 
								( recipe_id , recipe_owner_id , recipe_level , recipe_linked_item , recipe_items_req , recipe_effect , recipe_original_id, recipe_skill_id)
								VALUES ( $new_recipe_id , $user_id , '".$admin_recipe['item_power']."' , '".$admin_recipe['item_recipe_linked_item']."' , '".$admin_recipe['item_brewing_items_req']."', '".$admin_recipe['item_effect']."', '".$admin_recipe['item_original_recipe_id']."', '".$admin_recipe['item_recipe_skill_id']."')";
							$result = $db->sql_query($sql);
							if( !$result )
							{
								message_die(GENERAL_ERROR, "Couldn't insert new recipe into the recipebook", "", __LINE__, __FILE__, $sql);
							}

						}
					}
				}
				else
				{

					if ( $research_keep != 0 )
					{
						// Extra cost for keeping learned information
						adr_substract_points($user_id, 1000, '', adr_research);
               	
						// Get learned infomation
						$sql = "SELECT book_id FROM " . ADR_LIBRARY_LEARN_TABLE . "
							WHERE user_id = $user_id
							AND book_id = ".$rand_library['book_id'];

						if( !($result = $db->sql_query($sql)) ){
							message_die(GENERAL_ERROR, "Couldn't get learned information", "", __LINE__, __FILE__, $sql);}
						$row_learn = $db->sql_fetchrow($result);

						// Check to see if you already know this information
						if ( $row_learn == '' )
						{
							$sql_learn = "INSERT INTO " . ADR_LIBRARY_LEARN_TABLE . "
							(user_id, book_id, book_name, book_details)
							VALUES ($user_id, ".$rand_library['book_id'].", '".$rand_library['book_name']."', '".$rand_library['book_details']."')";

							if( !($result_learn = $db->sql_query($sql_learn)) ){
								message_die(GENERAL_ERROR, "Couldn't insert learned information", "", __LINE__, __FILE__, $sql_learn);}
						}
						else
						{
							$sql_learn = "UPDATE " . ADR_LIBRARY_LEARN_TABLE . "
								SET book_name = '".$rand_library['book_name']."',
									book_details = '".$rand_library['book_details']."'
								WHERE user_id = $user_id
								AND book_id = ".$rand_library['book_id'];
							if( !($result_learn = $db->sql_query($sql_learn)) ){
								message_die(GENERAL_ERROR, "Couldn't insert learned information", "", __LINE__, __FILE__, $sql_learn);}
						}
					}
				}
            
				$direction = append_sid("adr_research.$phpEx");
				$message = $lang['Adr_library_success_top'];
				$message .= '<b>'.$book_name.'</b><br /><br /><div align="center">' . $book_details. '</div>';
				$message .= $lang['Adr_library_success_bottom'];
				$message .= sprintf($lang['Adr_return'],"<a href=\"" . $direction . "\">", "</a>");

				message_die ( GENERAL_MESSAGE , $message );

			}
			
		break;
	}
}
else
{
	$template->assign_block_vars('research',array());

	$template->assign_vars(array(
		'L_PERFORM_RESEARCH' => $lang['Adr_library_perform_research'],
		'L_RESEARCH_EXPLAIN' => $lang['Adr_library_explain'],
	));
}

$template->assign_vars(array(
	'L_RESEARCH_TITLE' => $lang['Adr_library_title'],
	'L_RESEARCH' => $lang['Adr_library_main'],
	'L_RESEARCH_GO_TO' => $lang['Adr_library_go_to'],
	'L_RESEARCH_EXPLAIN' => $lang['Adr_library_area_explain'],
	'L_RESEARCH_HELPER' => $lang['Adr_library_helper'],
	'L_RESEARCH_KEEP' => $lang['Adr_library_keep_info'],
	'L_POINTS' => get_reward_name(),
	'POINTS' => $points,
	'U_RESEARCH' => append_sid("adr_research.$phpEx"),
	'S_FORGE_ACTION'=> append_sid("adr_research.$phpEx"),
));

include($phpbb_root_path . 'adr/includes/adr_header.'.$phpEx);
$template->pparse('body');
include($phpbb_root_path . 'includes/page_tail.'.$phpEx); 
?>