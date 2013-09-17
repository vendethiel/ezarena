<?php

// eXtreme Styles mod cache. Generated on Mon, 16 Sep 2013 22:57:00 +0000 (time=1379372220)

?>/***************************************************************************
 *						cache_classes.php
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

$adr_classes = array(
	<?php

$cache_row_count = ( isset($this->_tpldata['cache_row.']) ) ?  sizeof($this->_tpldata['cache_row.']) : 0;
for ($cache_row_i = 0; $cache_row_i < $cache_row_count; $cache_row_i++)
{
 $cache_row_item = &$this->_tpldata['cache_row.'][$cache_row_i];
 $cache_row_item['S_ROW_COUNT'] = $cache_row_i;
 $cache_row_item['S_NUM_ROWS'] = $cache_row_count;

?>
	<?php echo isset($cache_row_item['ID']) ? $cache_row_item['ID'] : ''; ?> => array(<?php echo isset($cache_row_item['CELLS']) ? $cache_row_item['CELLS'] : ''; ?>),
	<?php

} // END cache_row

if(isset($cache_row_item)) { unset($cache_row_item); } 

?>
);
