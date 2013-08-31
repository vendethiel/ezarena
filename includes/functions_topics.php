<?php
function pic_for_topic($topic)
{
	global $images, $new_unreads;

	//V: désactivé pour l'instant, ça marche qued' avec KUF
	$new = isset($new_unreads[$topic['topic_id']]) ? '_new' : '';
	if ( $topic["topic_status"] == TOPIC_LOCKED )
	{
		return $images['folder_locked' . $new];
	}

	if ($topic["topic_type"] == POST_GLOBAL_ANNOUNCE || $topic["topic_type"] == POST_ANNOUNCE)
	{
		return $images['folder_announce' . $new];
	}

	if ($topic["topic_type"] == POST_STICKY)
	{
		return $images['folder_sticky' . $new];
	} 

	return $images['folder' . $new];
}

function topic_type_lang($topic_type, $status = null)
{
	global $lang;

	if ($topic_type == POST_GLOBAL_ANNOUNCE)
	{
		return $lang['Topic_Global_Announcement'] . ' ';
	}
	if ($topic_type == POST_ANNOUNCE)
	{
		return $lang['Topic_Announcement'] . ' ';
	}
	if ($topic_type == POST_STICKY)
	{
		return $lang['Topic_Sticky'] . ' ';
	}

	if ($status !== null)
	{
		if ($status == TOPIC_MOVED)
		{
			return $lang['Topic_Moved'] . ' ';
		}
	}

	return '';
}