<?php
/***************************************************************************
*                                mod_sondage.php
*
* Adapté par Saint-Pere - www.areabb.com
*  
***************************************************************************/


if ( !defined('IN_PHPBB') )
{
	die("Hacking attempt");
}

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_magic_quotes_runtime(0);
global $userdata,$HTTP_GET_VARS,$HTTP_POST_VARS,$theme,$images,$areabb,$board_config;
 
//chargement du template
$template->set_filenames(array(
   'sondage' => 'areabb/mods/sondage/tpl/mod_sondage.tpl')
);

$graphic_width = 80;
$s_hidden_fields = '';

$template->assign_vars(array(
	'L_THEME_NAME'	=> $theme['template_name'],
	'L_POLL'		=> $lang['Poll'],
	'L_VOTE_BUTTON' => $lang['Vote']
));
	
$sql = 'SELECT vd.vote_id, vd.vote_text, vd.vote_start, vd.vote_length, vr.vote_option_id, vr.vote_option_text, vr.vote_result, t.forum_id
	FROM '. VOTE_DESC_TABLE .' vd, '. VOTE_RESULTS_TABLE . ' vr, ' . TOPICS_TABLE . ' t
	WHERE vd.topic_id = \'' . $areabb['id_sondage'] . '\'
	AND vr.vote_id = vd.vote_id
	AND t.topic_id = vd.topic_id
	ORDER BY vr.vote_option_id ASC';
	if ( !($result = $db->sql_query($sql)) )
	{
		message_die(GENERAL_ERROR, "Could not obtain vote data for this topic", '', __LINE__, __FILE__, $sql);
	}
	if ( $vote_info = $db->sql_fetchrowset($result) )
	{
		$db->sql_freeresult($result);
		$vote_options		= count($vote_info);
		$vote_id			= $vote_info[0]['vote_id'];
		$forum_vote_id		= $vote_info[0]['forum_id'];
		$vote_title			= $vote_info[0]['vote_text'];

		$sql = 'SELECT vote_id
			FROM ' . VOTE_USERS_TABLE . '
			WHERE vote_id = '.$vote_id.'
			AND vote_user_id = ' . intval($userdata['user_id']);
	
		if ( !($result = $db->sql_query($sql)) )
		{
			message_die(GENERAL_ERROR, "Could not obtain user vote data for this topic", '', __LINE__, __FILE__, $sql);
		}

		$user_voted = ( $row = $db->sql_fetchrow($result) ) ? TRUE : 0;
		$db->sql_freeresult($result);

		if ( isset($HTTP_GET_VARS['vote']) || isset($HTTP_POST_VARS['vote']) )
		{
			$view_result = ( ( ( isset($HTTP_GET_VARS['vote']) ) ? $HTTP_GET_VARS['vote'] : $HTTP_POST_VARS['vote'] ) == 'viewresult' ) ? TRUE : 0;
		}
		else
		{
			$view_result = 0;
		}
		$poll_expired = ( $vote_info[0]['vote_length'] ) ? ( ( $vote_info[0]['vote_start'] + $vote_info[0]['vote_length'] < time() ) ? TRUE : 0 ) : 0;
		
		$is_auth = array();
		$is_auth = auth(AUTH_VOTE, $forum_vote_id, $userdata, "");

		if ( $user_voted || $view_result || $poll_expired || !$is_auth['auth_vote'] || $forum_topic_data['topic_status'] == TOPIC_LOCKED )
		{
			$template->set_filenames(array(
				'pollbox' => 'areabb/mods/sondage/tpl/poll_result.tpl'
			));

			$vote_results_sum = 0;

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_results_sum += $vote_info[$i]['vote_result'];
			}
			$vote_graphic = 0;
			$vote_graphic_max = count($images['voting_graphic']);

			for($i = 0; $i < $vote_options; $i++)
			{
				$vote_percent			= ( $vote_results_sum > 0 ) ? $vote_info[$i]['vote_result'] / $vote_results_sum : 0;
				$vote_graphic_length	= round($vote_percent * $graphic_width);
				$vote_graphic_img		= $images['voting_graphic'][$vote_graphic];
				$vote_graphic			= ($vote_graphic < $vote_graphic_max - 1) ? $vote_graphic + 1 : 0;

				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}

				$template->assign_block_vars('poll_option', array(
					'POLL_OPTION_CAPTION'	=> $vote_info[$i]['vote_option_text'],
					'POLL_OPTION_RESULT'	=> $vote_info[$i]['vote_result'],
					'POLL_OPTION_PERCENT'	=> sprintf("%.1d%%", ($vote_percent * 100)),
					'POLL_OPTION_IMG'		=> $vote_graphic_img,
					'POLL_OPTION_IMG_WIDTH' => $vote_graphic_length
				));
			}

			$template->assign_vars(array(
				'L_TOTAL_VOTES'	=> $lang['Total_votes'],
				'TOTAL_VOTES'	=> $vote_results_sum
			));
		}
		else
		{
			$template->set_filenames(array(
				'pollbox' =>  'areabb/mods/sondage/tpl/poll_ballot.tpl')
			);

			for($i = 0; $i < $vote_options; $i++)
			{
				if ( count($orig_word) )
				{
					$vote_info[$i]['vote_option_text'] = preg_replace($orig_word, $replacement_word, $vote_info[$i]['vote_option_text']);
				}

				$template->assign_block_vars('poll_option', array(
					'POLL_OPTION_ID'		=> $vote_info[$i]['vote_option_id'],
					'POLL_OPTION_CAPTION'	=> $vote_info[$i]['vote_option_text'])
				);
			}
			$suite = (ereg("\?",$_SERVER['REQUEST_URI']))? '&amp;':'?';
			if (eregi($board_config['script_path'],$_SERVER['REQUEST_URI']))
			{
				$suite = eregi_replace($board_config['script_path'],'', $_SERVER['REQUEST_URI']). $suite. 'vote=viewresult#sondage';
			}
			
			$template->assign_vars(array(
				'L_SUBMIT_VOTE'		=> $lang['Submit_vote'],
				'L_VIEW_RESULTS'	=> $lang['View_results'],
				'U_VIEW_RESULTS'	=> append_sid($suite)
			));

			$s_hidden_fields = '<input type="hidden" name="topic_id" value="' . $areabb['id_sondage'] . '" /><input type="hidden" name="mode" value="vote" />';
		}

		if ( count($orig_word) )
		{
			$vote_title = preg_replace($orig_word, $replacement_word, $vote_title);
		}

		$s_hidden_fields .= '<input type="hidden" name="sid" value="' . $userdata['session_id'] . '" />';

		$template->assign_vars(array(
			'POLL_QUESTION'		=> $vote_title,
			'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
			'S_POLL_ACTION'		=> append_sid('posting.'.$phpEx.'?mode=vote&amp;' . POST_TOPIC_URL . '=' . $areabb['id_sondage']))	
		);

		$template->assign_var_from_handle('POLL_DISPLAY', 'pollbox');
	}


$template->assign_var_from_handle('sondage', 'sondage');

?>