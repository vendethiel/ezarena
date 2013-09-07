<?php
/***************************************************************************
 *						cache_alignments.php
 *						-------------
 *	begin			: 15/02/2004
 *	copyright		: Ptirhiik
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

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}

$adr_alignments = array(
		'1' => array('alignment_id' => '1', 'alignment_name' => 'Adr_alignment_neutral', 'alignment_desc' => 'Adr_alignment_neutral_desc', 'alignment_level' => '0', 'alignment_img' => 'Neutral.gif', 'alignment_karma_min' => '0', 'alignment_karma_type' => '0'),
		'2' => array('alignment_id' => '2', 'alignment_name' => 'Adr_alignment_evil', 'alignment_desc' => 'Adr_alignment_evil_desc', 'alignment_level' => '0', 'alignment_img' => 'Evil.gif', 'alignment_karma_min' => '1000', 'alignment_karma_type' => '2'),
		'3' => array('alignment_id' => '3', 'alignment_name' => 'Adr_alignment_good', 'alignment_desc' => 'Adr_alignment_good_desc', 'alignment_level' => '0', 'alignment_img' => 'Good.gif', 'alignment_karma_min' => '1000', 'alignment_karma_type' => '1'),
	);

?>