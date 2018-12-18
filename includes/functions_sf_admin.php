<?php
//
//	file: includes/functions_sf_admin.php
//	author: ptirhiik
//	begin: 03/10/2006
//	version: 0.0.3 - 08/10/2006
//	license: http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
//

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

// search: get the selected forums list from the form
function _sf_get_selected(&$selected_forums_all, &$_sf_tree)
{
	global $HTTP_POST_VARS, $HTTP_GET_VARS;

	// retrieved the selected forums list
	$selected_forums_all = true;
	$selected_forums = array();
	if ( (isset($HTTP_POST_VARS['search_cat']) || isset($HTTP_POST_VARS['search_forum'])) && !isset($HTTP_POST_VARS['search_tree']) )
	{
		$search_cat = isset($HTTP_POST_VARS['search_cat']) ? intval($HTTP_POST_VARS['search_cat']) : -1;
		$search_forum = isset($HTTP_POST_VARS['search_forum']) ? intval($HTTP_POST_VARS['search_forum']) : -1;
		if ( !($selected_forums_all = ($search_cat == -1) && ($search_forum == -1)) )
		{
			$tree_id = false;
			if ( ($search_cat > 0) && isset($_sf_tree->data[POST_CAT_URL . '.' . $search_cat]) )
			{
				$tree_id = $_sf_tree->data[POST_CAT_URL . '.' . $search_cat];
			}
			else if ( ($search_forum > 0) && isset($_sf_tree->data[POST_FORUM_URL . '.' . $search_forum]) )
			{
				$tree_id = $_sf_tree->data[POST_FORUM_URL . '.' . $search_forum];
			}
			if ( $tree_id )
			{
				$keys = array_keys($_sf_tree->data);
				$from = $_sf_tree->data[$tree_id]['idx'];
				$to = $_sf_tree->data[ $_sf_tree->data[$tree_id]['last_child_id'] ]['idx'];
				for ( $i = $from; $i <= $to; $i++ )
				{
					if ( $s_sf_tree->data[ $keys[$i] ]['forum_type'] == POST_FORUM_URL )
					{
						$selected_forums[ $s_sf_tree->data[ $keys[$i] ]['forum_id'] ] = true;
					}
				}
			}
		}
	}
	else if ( isset($HTTP_POST_VARS['search_tree']) && is_array($HTTP_POST_VARS['search_tree']) )
	{
		$selected_forums_all = false;
		$search_tree = $HTTP_POST_VARS['search_tree'];
		$count_search_tree = count($search_tree);
		for ( $i = 0; $i < $count_search_tree; $i++ )
		{
			$search_tree[$i] = trim(htmlspecialchars(stripslashes($search_tree[$i])));
			if ( $search_tree[$i] == POST_CAT_URL . '.' . 0 )
			{
				$selected_forums_all = true;
				$selected_forums = array();
				break;
			}
			else if ( isset($_sf_tree->data[ $search_tree[$i] ]) && ($_sf_tree->data[ $search_tree[$i] ]['forum_type'] == POST_FORUM_URL) )
			{
				$selected_forums[ $_sf_tree->data[ $search_tree[$i] ]['forum_id'] ] = true;
			}
		}
	}
	$selected_forums_all |= empty($selected_forums);
	return $selected_forums;
}

// search: reduce the selected forums list to the viewable ones
function _sf_filter_selected(&$_sf_tree, &$_sf_selected_forums, $_sf_selected_forums_all)
{
	global $userdata;

	// format for auth()
	$_sf_forum_rows = array();
	foreach ( $_sf_tree->data as $tree_id => $data )
	{
		if ( ($data['forum_type'] == POST_FORUM_URL) && ($_sf_selected_forums_all || isset($_sf_selected_forums[ $data['forum_id'] ])) )
		{
			$_sf_forum_rows[] = $data;
		}
	}

	$_sf_selected_forums = array();
	if ( !empty($_sf_forum_rows) )
	{
		$is_auth_ary = auth(AUTH_READ, AUTH_LIST_ALL, $userdata, $_sf_forum_rows);
		unset($_sf_forum_rows);

		if ( !empty($is_auth_ary) )
		{
			foreach ( $is_auth_ary as $key => $values )
			{
				if ( $values['auth_read'] || $values['auth_mod'] )
				{
					$_sf_selected_forums[] = $key;
				}
			}
		}
	}
}

// search: display forums list selection field
function _sf_display_selected(&$_sf_tree)
{
	global $lang, $template, $userdata;

	$_sf_forum_rows = array();
	foreach ( $_sf_tree->data as $tree_id => $dummy )
	{
		if ( $_sf_tree->data[$tree_id]['forum_type'] == POST_FORUM_URL )
		{
			$_sf_forum_rows[] = &$_sf_tree->data[$tree_id];
		}
	}
	if ( empty($_sf_forum_rows) )
	{
		return false;
	}
	$is_auth_ary = array();
	$is_auth_ary = auth(AUTH_READ, AUTH_LIST_ALL, $userdata, $_sf_forum_rows);
	unset($_sf_forum_rows);

	// build the select list
	$cat_displayed = $nest_level = $forum_is_cat = $forum_parents = $forum_last_childs = array();
	$keys = array_keys($_sf_tree->data);
	$count_keys = count($keys);
	for ( $i = 0; $i < $count_keys; $i++ )
	{
		$tree_id = $keys[$i];
		$data = $_sf_tree->data[$tree_id];
		if ( $data['forum_type'] == POST_FORUM_URL )
		{
			if ( !$is_auth_ary[ $data['forum_id'] ] )
			{
				// not authorised: jump over the branch
				$i = $_sf_tree->data[ $_sf_tree->data[$tree_id]['last_child_id'] ]['idx'];
				continue;
			}

			// do we have to display a cat first ?
			$parent_id = $_sf_tree->make_id($data['forum_parent'], $data['cat_id']);
			if ( $_sf_tree->data[$parent_id]['forum_type'] == POST_CAT_URL )
			{
				if ( !isset($cat_displayed[0]) )
				{
					$cat_id = $keys[0];
					$template->assign_block_vars('option', array(
						'VALUE' => $cat_id,
						'L_VALUE' => $lang['All_available'],
						'SELECTED' => ' selected="selected"',
					));
					$cat_displayed[0] = true;
					$nest_level[$cat_id] = 0;
					$forum_parents[] = 0;
					$forum_is_cat[] = 1;
				}
				if ( !isset($cat_displayed[ $data['cat_id'] ]) )
				{
					// display cat
					$cat_id = $_sf_tree->make_id(0, $data['cat_id']);
					$nest_level[$cat_id] = intval($nest_level[ $keys[0] ]) + 1;
					$template->assign_block_vars('option', array(
						'VALUE' => $cat_id,
						'L_VALUE' => $_sf_tree->data[$cat_id]['forum_name'],
						'INDENT' => $nest_level[$cat_id] ? implode('', array_pad(array(), ($nest_level[$cat_id] - 1) * 4, '&nbsp;')) . '--&nbsp;' : '',
						'SELECTED' => ' selected="selected"',
					));
					$cat_displayed[ $data['cat_id'] ] = true;
					$forum_parents[] = 0;
					$forum_is_cat[] = 1;
				}
			}

			// display the forum
			$nest_level[$tree_id] = intval($nest_level[$parent_id]) + 1;
			$template->assign_block_vars('option', array(
				'VALUE' => $tree_id,
				'L_VALUE' => $data['forum_name'],
				'INDENT' => $nest_level[$tree_id] ? implode('', array_pad(array(), ($nest_level[$tree_id] - 1) * 4, '&nbsp;')) . '--&nbsp;' : '',
				'SELECTED' => ' selected="selected"',
			));
			$forum_parents[] = $_sf_tree->data[$parent_id]['idx'];
			$forum_is_cat[] = 0;
		}
	}
	if ( empty($cat_displayed) )
	{
		return false;
	}

	// get the last idx of branches
	$keys = array_keys($nest_level);
	$tkeys = array_flip($keys);
	$forum_last_childs = array();
	for ( $i = count($keys) - 1; $i > 0; $i-- )
	{
		if ( !isset($forum_last_childs[$i]) )
		{
			$forum_last_childs[$i] = $i;
		}
		$parent_id = $_sf_tree->data[ $keys[$i] ]['forum_type'] == POST_CAT_URL ? $_sf_tree->make_id(0, 0) : $_sf_tree->make_id($_sf_tree->data[ $keys[$i] ]['forum_parent'], $_sf_tree->data[ $keys[$i] ]['cat_id']);
		if ( !isset($forum_last_childs[ $tkeys[$parent_id] ]) )
		{
			$forum_last_childs[ $tkeys[$parent_id] ] = $forum_last_childs[$i];
		}
	}
	unset($tkeys);
	if ( !empty($forum_last_childs) )
	{
		ksort($forum_last_childs);
	}

	$template->assign_vars(array(
		'S_FORUM_SIZE' => max(1, min(8, count($forum_parents))),
		'S_FORUM_IS_CAT' => empty($forum_is_cat) ? '' : implode(', ', $forum_is_cat),
		'S_FORUM_PARENT' => empty($forum_parents) ? '' : implode(', ', $forum_parents),
		'S_FORUM_LAST_CHILDS' => empty($forum_last_childs) ? '' : implode(', ', $forum_last_childs),
	));
	return true;
}

// admin & search
class _sf_tree
{
	var $data;

	function _sf_tree()
	{
		$this->data = array();
	}

	function make_id($forum_id, $cat_id='')
	{
		return intval($forum_id) || ($cat_id === '') ? POST_FORUM_URL . '.' . intval($forum_id) : POST_CAT_URL . '.' . intval($cat_id);
	}

	function read()
	{
		global $db;

		$this->data = array();

		$cats = array(0 => array(
			'forum_id' => 0,
			'forum_type' => POST_CAT_URL,
			'forum_name' => 'Forum_index',
			'forum_desc' => '',
			'cat_id' => 0,
			'forum_parent' => 0,
			'forum_order' => 0,
		));
		$sql = 'SELECT cat_id, cat_title, cat_order
					FROM ' . CATEGORIES_TABLE . '
					ORDER BY cat_order';
		if ( !($result = $db->sql_query($sql, false, 'sf_tree_read_categories')) )
		{
			message_die(GENERAL_ERROR, 'Could not query categories list', '', __LINE__, __FILE__, $sql);
		}
		while ( $row = $db->sql_fetchrow($result) )
		{
			$cats[] = array(
				'forum_id' => intval($row['cat_id']),
				'forum_type' => POST_CAT_URL,
				'forum_name' => $row['cat_title'],
				'forum_desc' => '',
				'cat_id' => intval($row['cat_id']),
				'forum_parent' => 0,
				'forum_order' => intval($row['cat_order']),
			);
		}
		$db->sql_freeresult($result);

		$forums_keys = array();
		$forums = array();
		$sql = 'SELECT *
					FROM ' . FORUMS_TABLE . '
					ORDER BY cat_id, forum_order';
		if ( !($result = $db->sql_query($sql, false, 'sf_tree_read_forums')) )
		{
			message_die(GENERAL_ERROR, 'Could not query forums list', '', __LINE__, __FILE__, $sql);
		}
		while ( ($row = $db->sql_fetchrow($result)) )
		{
			if ( !isset($forums[ intval($row['cat_id']) ]) )
			{
				$forums[ intval($row['cat_id']) ] = array();
			}
			$forums_keys[ intval($row['forum_id']) ] = count($forums[ intval($row['cat_id']) ]);
			$forums[ intval($row['cat_id']) ][] = array_merge($row, array(
				'forum_id' => intval($row['forum_id']),
				'forum_type' => POST_FORUM_URL,
				'forum_name' => $row['forum_name'],
				'forum_desc' => $row['forum_desc'],
				'cat_id' => intval($row['cat_id']),
				'forum_parent' => intval($row['forum_parent']),
				'forum_order' => intval($row['forum_order']),
			));
		}
		$db->sql_freeresult($result);

		// build the tree
		$count_cats = count($cats);
		for ( $i = $count_cats - 1; $i >= 0; $i-- )
		{
			// deal with attached forums
			$cat_id = $cats[$i]['forum_id'];
			if ( ($count_forums = count($forums[$cat_id])) )
			{
				for ( $j = $count_forums - 1; $j >= 0; $j-- )
				{
					$forum = $forums[$cat_id][$j];
					if ( !isset($forum['last_sub_id']) )
					{
						$forum['last_sub_id'] = $this->make_id($forum['forum_id']);
					}
					if ( !isset($forum['last_child_id']) )
					{
						$forum['last_child_id'] = $this->make_id($forum['forum_id']);
					}

					$parent_type = intval($forum['forum_parent']) ? POST_FORUM_URL : POST_CAT_URL;
					$parent_idx = intval($forum['forum_parent']) ? $forums_keys[ $forum['forum_parent'] ] : $i;
					if ( ($parent_type == POST_CAT_URL) && !isset($cats[$parent_idx]['last_sub_id']) )
					{
						$cats[$parent_idx]['last_sub_id'] = $this->make_id($forum['forum_id']);
					}
					else if ( ($parent_type == POST_FORUM_URL) && !isset($forums[$cat_id][$parent_idx]['last_sub_id']) )
					{
						$forums[$cat_id][$parent_idx]['last_sub_id'] = $this->make_id($forum['forum_id']);
					}
					if ( ($parent_type == POST_CAT_URL) && !isset($cats[$parent_idx]['last_child_id']) )
					{
						$cats[$parent_idx]['last_child_id'] = $forum['last_child_id'];
					}
					else if ( ($parent_type == POST_FORUM_URL) && !isset($forums[$cat_id][$parent_idx]['last_child_id']) )
					{
						$forums[$cat_id][$parent_idx]['last_child_id'] = $forum['last_child_id'];
					}

					$this->data[ $this->make_id($forum['forum_id']) ] = $forum;
					unset($forums[$cat_id][$j]);
				}
				unset($forums[$cat_id]);
			}

			// add the cat
			$cat = $cats[$i];
			if ( !isset($cat['last_sub_id']) )
			{
				$cat['last_sub_id'] = $this->make_id(0, $cat['forum_id']);
			}
			if ( !isset($cat['last_child_id']) )
			{
				$cat['last_child_id'] = $this->make_id(0, $cat['forum_id']);
			}

			if ( $i && !isset($cats[0]['last_sub_id']) )
			{
				$cats[0]['last_sub_id'] = $this->make_id(0, $cat['forum_id']);
			}
			if ( $i && !isset($cats[0]['last_child_id']) )
			{
				$cats[0]['last_child_id'] = $cat['last_child_id'];
			}

			$this->data[ $this->make_id(0, $cat['forum_id']) ] = $cat;
			unset($cats[$i]);
		}
		$this->data = array_reverse($this->data, true);

		// fix the current order if required
		$sqls = array();
		$idx = -1;
		foreach ($this->data as $tree_id => $data )
		{
			$idx++;
			$this->data[$tree_id]['idx'] = $idx;
			if ( $tree_id == 'c.0' )
			{
				$cat_order = 0;
				continue;
			}
			// categories
			if ( $data['forum_type'] == POST_CAT_URL )
			{
				$cat_order += 10;
				$forum_order = 0;
				if ( $data['forum_order'] != $cat_order )
				{
					$data['forum_order'] = $cat_order;
					$sqls[] = 'UPDATE ' . CATEGORIES_TABLE . '
									SET cat_order = ' . intval($cat_order) . '
									WHERE cat_id = ' . intval($data['forum_id']);
				}
			}
			// forums
			else
			{
				$forum_order += 10;
				if ( $data['forum_order'] != $forum_order )
				{
					$data['forum_order'] = $forum_order;
					$sqls[] = 'UPDATE ' . FORUMS_TABLE . '
									SET forum_order = ' . intval($forum_order) . '
									WHERE forum_id = ' . intval($data['forum_id']);
				}
			}
		}
		$count_sqls = count($sqls);
		for ( $i = 0; $i < $count_sqls; $i++ )
		{
			$sql = $sqls[$i];
			if ( !$db->sql_query($sql) )
			{
				message_die(GENERAL_ERROR, 'Could not update forums/categories order', '', __LINE__, __FILE__, $sql);
			}
		}
	}

	function move_up_down($type, $id, $direction)
	{
		global $db;

		$tree_id = $this->make_id($type == POST_FORUM_URL ? $id : 0, $type == POST_FORUM_URL ? 0 : $id);
		if ( !$id || !isset($this->data[$tree_id]) )
		{
			return false;
		}

		// category move
		if ( $type == POST_CAT_URL )
		{
			if ( (($direction < 0) && ($this->data[$tree_id]['forum_order'] > 10)) || (($direction >= 0) && ($tree_id != $this->data['c.0']['last_sub_id'])) )
			{
				$sql = 'UPDATE ' . CATEGORIES_TABLE . '
							SET cat_order = cat_order' . ($direction < 0 ? ' - 15' : ' + 15') . '
							WHERE cat_id = ' . intval($id);
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forums/categories order', '', __LINE__, __FILE__, $sql);
				}
				$this->read();
			}
		}
		// forum move
		else
		{
			// get the brothers (subs of the parent)
			$parent_id = $this->make_id($this->data[$tree_id]['forum_parent'], $this->data[$tree_id]['cat_id']);
			$from = $this->data[$parent_id]['idx'];
			$to = $this->data[ $this->data[$parent_id]['last_sub_id'] ]['idx'];
			$brothers = array();
			$keys = array_keys($this->data);
			$cur_idx = 0;
			for ( $i = $from; $i <= $to; $i++ )
			{
				if ( $keys[$i] == $tree_id )
				{
					$cur_idx = count($brothers);
				}
				$brothers[] = $keys[$i];

				// jump over the subs of the brother branch
				if ( $i > $from )
				{
					$i = $this->data[ $this->data[ $keys[$i] ]['last_child_id'] ]['idx'];
				}
			}
			unset($keys);
			$new_idx = $direction < 0 ? $cur_idx - 2 : $cur_idx + 1;
			if ( !($count_brothers = count($brothers)) || !$cur_idx || ($new_idx < 0) || ($new_idx >= $count_brothers) )
			{
				return;
			}
			$target_id = $brothers[$new_idx];
			unset($brothers);
			$target_main = $parent_id;
			if ( $this->move($tree_id, $target_main, $target_id) )
			{
				$this->read();
			}
		}
	}

	function move($tree_id, $target_main, $target_id='')
	{
		global $db;

		if ( !isset($this->data[$tree_id]) || !isset($this->data[$target_main]) || (!empty($target_id) && !isset($this->data[$target_id])) )
		{
			return false;
		}
		if ( empty($target_id) )
		{
			$target_id = $this->data[$target_main]['last_sub_id'];
		}
		if ( $target_id == $tree_id )
		{
			return;
		}

		// move
		if ( $tree_id[0] == POST_CAT_URL )
		{
			// move a cat to a cat
			if ( $target_main == 'c.0' )
			{
				$sql = 'UPDATE ' . CATEGORIES_TABLE . '
							SET cat_order = ' . intval($this->data[$target_id]['forum_order'] + 5) . '
							WHERE cat_id = ' . intval($this->data[$target_id]['cat_id']);
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update categories order', '', __LINE__, __FILE__, $sql);
				}
			}
			// the original cat is considered as to delete
			else if ( ($target_main[0] == POST_FORUM_URL) && ($this->data[$target_id]['cat_id'] != $this->data[$tree]['cat_id']) )
			{
				$target_order = $target_id == $target_main ? ($target_id[0] == POST_CAT_URL ? 0 : $this->data[$target_id]['forum_order']) : $this->data[ $this->data[$target_id]['last_child_id'] ]['forum_order'];
				$size_order = $this->data[ $this->data[$tree_id]['last_child_id'] ]['forum_order'];

				// make some room at the target place
				$sql = 'UPDATE ' . FORUMS_TABLE . '
							SET forum_order = forum_order + ' . intval($size_order) . '
							WHERE cat_id = ' . intval($this->data[$target_id]['cat_id']) . '
								AND forum_order > ' . intval($target_order);
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forums order', '', __LINE__, __FILE__, $sql);
				}

				// attach the cat content to the new forum parent
				$sql = 'UPDATE ' . FORUMS_TABLE . '
							SET forum_parent = ' . intval($this->data[$target_main]['forum_id']) . '
							WHERE cat_id = ' . intval($this->data[$tree_id]['cat_id']) . '
								AND forum_parent = 0';
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forums order', '', __LINE__, __FILE__, $sql);
				}

				// renum the original cat and re-attach
				$sql = 'UPDATE ' . FORUMS_TABLE . '
							SET forum_order = forum_order + ' . intval($target_order) . ', cat_id = ' . intval($this->data[$target_id]['cat_id']) . '
							WHERE cat_id = ' . intval($this->data[$tree_id]['cat_id']);
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forums order', '', __LINE__, __FILE__, $sql);
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			$from_order = $this->data[$tree_id]['forum_order'];
			$to_order = $this->data[ $this->data[$tree_id]['last_child_id'] ]['forum_order'];
			$target_order = $target_id == $target_main ? ($target_id[0] == POST_CAT_URL ? 0 : $this->data[$target_id]['forum_order']) : $this->data[ $this->data[$target_id]['last_child_id'] ]['forum_order'];
			$size_order = $to_order - $from_order + 10;

			// ensure we are not moving the branch into itself
			if ( ($this->data[$target_id]['cat_id'] == $this->data[$tree_id]['cat_id']) && ($target_order >= $from_order) && ($target_order <= $to_order) )
			{
				if ( $target_order != $to_order )
				{
					return false;
				}
				// the target order is actually the current one, so no move
				$target_order = $from_order - 10;
			}
			// change the order
			if ( ($this->data[$target_id]['cat_id'] != $this->data[$tree_id]['cat_id']) || ($target_order != $from_order -10) )
			{
				// move the branch at end
				$max_order = count($this->data) * 100;
				$sql = 'UPDATE ' . FORUMS_TABLE . '
							SET forum_order = forum_order + ' . intval($max_order - $from_order) . '
							WHERE cat_id = ' . intval($this->data[$tree_id]['cat_id']) . '
								AND forum_order BETWEEN ' . intval($from_order) . ' AND ' . intval($to_order);
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forums order', '', __LINE__, __FILE__, $sql);
				}

				// remove the left hole
				$sql = 'UPDATE ' . FORUMS_TABLE . '
							SET forum_order = forum_order - ' . intval($size_order) . '
							WHERE  cat_id = ' . intval($this->data[$tree_id]['cat_id']) . '
								AND forum_order BETWEEN ' . intval($to_order) . ' AND ' . intval($max_order - 1);
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forums order', '', __LINE__, __FILE__, $sql);
				}
				if ( ($target_order > $to_order) && ($this->data[$target_id]['cat_id'] == $this->data[$tree_id]['cat_id']) )
				{
					$target_order = $target_order - $size_order;
				}

				// make some room at the target place
				$sql = 'UPDATE ' . FORUMS_TABLE . '
							SET forum_order = forum_order + ' . intval($size_order) . '
							WHERE cat_id = ' . intval($this->data[$target_id]['cat_id']) . (intval($this->data[$target_id]['cat_id']) == intval($this->data[$tree_id]['cat_id']) ? '
								AND forum_order BETWEEN ' . intval($target_order + 1) . ' AND ' . intval($max_order - 1) : '
								AND forum_order > ' . intval($target_order));
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forums order', '', __LINE__, __FILE__, $sql);
				}

				// move the branch
				$sql = 'UPDATE ' . FORUMS_TABLE . '
							SET forum_order = forum_order - ' . intval($max_order - ($target_order + 10)) . (intval($this->data[$target_id]['cat_id']) == intval($this->data[$tree_id]['cat_id']) ? '' : ', cat_id = ' . intval($this->data[$target_id]['cat_id'])) . '
							WHERE cat_id = ' . intval($this->data[$tree_id]['cat_id']) . '
								AND forum_order BETWEEN ' . intval($max_order) . ' AND ' . intval($max_order + $size_order - 10);
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forums order', '', __LINE__, __FILE__, $sql);
				}
			}

			// change the parent
			if ( (($this->data[$target_main]['forum_type'] == POST_CAT_URL) && intval($this->data[$tree_id]['forum_parent'])) || (($this->data[$target_main]['forum_type'] != POST_CAT_URL) && (intval($this->data[$target_main]['forum_id']) != intval($this->data[$tree_id]['forum_parent']))) )
			{
				$sql = 'UPDATE ' . FORUMS_TABLE . '
							SET forum_parent = ' . ($this->data[$target_main]['forum_type'] == POST_CAT_URL ? 0 : intval($this->data[$target_main]['forum_id'])) . '
							WHERE forum_id = ' . intval($this->data[$tree_id]['forum_id']);
				if ( !$db->sql_query($sql) )
				{
					message_die(GENERAL_ERROR, 'Could not update forums order', '', __LINE__, __FILE__, $sql);
				}
			}
		}
		return true;
	}
	function select($select_id, $except_id=false, $forum_only=false)
	{
		if ( ($except_id && ($select_id == $except_id)) || !isset($this->data[$select_id]) )
		{
			$select_id = false;
		}
		if ( !$except_id || !isset($this->data[$except_id]) )
		{
			$except_id = false;
		}
		$except_from = $except_to = 0;
		if ( $except_id )
		{
			$except_from = $this->data[$except_id]['forum_type'] == POST_CAT_URL ? 0 : $this->data[$except_id]['forum_order'];
			$except_to = $this->data[ $this->data[$except_id]['last_child_id'] ]['forum_order'];
		}
		$options = '';
		$nest_level = array(POST_CAT_URL . '.' . 0 => 0);
		$first = true;
		foreach ( $this->data as $tree_id => $data )
		{
			$parent_id = $this->make_id($data['forum_parent'], $data['cat_id']);
			$nest_level[$tree_id] = ($data['forum_type'] == POST_CAT_URL) || ($this->data[$parent_id]['forum_type'] == POST_CAT_URL) ? 0 : intval($nest_level[$parent_id]) + 1;
			$forum_order = $data['forum_type'] == POST_CAT_URL ? 0 : $data['forum_order'];
			if ( !$data['forum_id'] || ($except_id && ($data['cat_id'] == $this->data[$except_id]['cat_id']) && ($forum_order >= $except_from) && ($forum_order <= $except_to)) )
			{
				continue;
			}
			if ( !$first && ($data['forum_type'] == POST_CAT_URL) )
			{
				$options .= '<option value="-2" disabled="disabled"> </option>';
			}
			$first = false;
			$disabled = $forum_only && ($data['forum_type'] == POST_CAT_URL) ? ' disabled="disabled"' : '';
			$selected = empty($disabled) && $select_id && ($tree_id == $select_id) ? ' selected="selected"' : '';
			$options .= '<option value="' . (empty($disabled) ? ($forum_only ? $data['forum_id'] : $tree_id) : -2) . '"' . $selected . $disabled . '>' . ($nest_level[$tree_id] ? implode('', array_pad(array(), ($nest_level[$tree_id] - 1) * 4, '&nbsp;')) . '--&nbsp;' : '') . $data['forum_name'] . '</option>';
			if ( $data['forum_type'] == POST_CAT_URL )
			{
				$options .= '<option value="" disabled="disabled">----------------</option>';
			}
		}
		return $options;
	}
}