/***************************************************************************
 * def_bbc_box.php
 * ---------------
 * begin	: 11/06/2005
 * copyright	: reddog
 *
 * version	: 1.0.0 - 11/06/2005
 *
 * last update	: {TIME} by {USERNAME}
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
	exit;
}

//--------------------------------------------------------------------------------------------------
//
// $bbc_config : templates
// -----------
//--------------------------------------------------------------------------------------------------

$bbc_config = array(
	<!-- BEGIN cache_row -->
	{cache_row.ID} => array({cache_row.CELLS}),
	<!-- END cache_row -->
);