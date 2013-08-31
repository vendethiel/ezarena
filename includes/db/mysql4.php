<?php
/***************************************************************************
 *                                 mysql4.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2001 The phpBB Group
 *   email                : supportphpbb.com
 *
 *   $Id: mysql4.php,v 1.5.2.1 2005/09/18 16:17:20 acydburn Exp $
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

if(!defined("SQL_LAYER"))
{

define("SQL_LAYER","mysql4");

class sql_db
{

	var $db_connect_id;
	var $query_result;
	var $row = array();
	var $rowset = array();
	var $queries;
	var $num_queries = 0;
	var $caching = false;
	var $cached = false;
	var $cache = array();	
	var $in_transaction = 0;

	//
	// Constructor
	//
	function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)
	{
		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;

		$this->db_connect_id = ($this->persistency) ? mysql_pconnect($this->server, $this->user, $this->password) : mysql_connect($this->server, $this->user, $this->password);

		if( $this->db_connect_id )
		{
			if( $database != "" )
			{
				$this->dbname = $database;
				$dbselect = mysql_select_db($this->dbname);

				if( !$dbselect )
				{
					mysql_close($this->db_connect_id);
					$this->db_connect_id = $dbselect;
				}
			}

			return $this->db_connect_id;
		}
		else
		{
			return false;
		}
	}

	//
	// Other base methods
	//
	function sql_close()
	{
		if( $this->db_connect_id )
		{
			//
			// Commit any remaining transactions
			//
			if( $this->in_transaction )
			{
				mysql_query("COMMIT", $this->db_connect_id);
			}

			return mysql_close($this->db_connect_id);
		}
		else
		{
			return false;
		}
	}

	//
	// Base query method
	//
	function sql_query($query = "", $transaction = FALSE, $cache = false)
	{
		//
		// Remove any pre-existing queries
		//
		unset($this->query_result);
		// Check cache
		$this->caching = false;
		$this->cache = array();
		$this->cached = false;
		if($query !== '' && $cache)
		{
			global $phpbb_root_path;
			$hash = md5($query);
			if(strlen($cache))
			{
				$hash = $cache . $hash;
			}
			$filename = $phpbb_root_path . 'cache/sql_' . $hash . '.php';
			if(@file_exists($filename))
			{
				$set = array();
				include($filename);
				$this->cache = $set;
				$this->cached = true;
				$this->caching = false;
				return 'cache';
			}
			$this->caching = $hash;
		}		

		if( $query != "" )
		{
			$this->num_queries++;
			if( $transaction == BEGIN_TRANSACTION && !$this->in_transaction )
			{
				$result = mysql_query("BEGIN", $this->db_connect_id);
				if(!$result)
				{
					return false;
				}
				$this->in_transaction = TRUE;
			}
			$qstart = microtime();
			$this->query_result = mysql_query($query, $this->db_connect_id);
			
			if (DEBUG)
			{
				$qend = microtime();
				ob_start();
				debug_print_backtrace();
				$backtrace = ob_get_clean();
				$this->queries[] = array($query, $backtrace, $qend - $qstart);
			}
		}
		else
		{
			if( $transaction == END_TRANSACTION && $this->in_transaction )
			{
				$result = mysql_query("COMMIT", $this->db_connect_id);
			}
		}

		if( $this->query_result )
		{
			unset($this->row[$this->query_result]);
			unset($this->rowset[$this->query_result]);

			if( $transaction == END_TRANSACTION && $this->in_transaction )
			{
				$this->in_transaction = FALSE;

				if ( !mysql_query("COMMIT", $this->db_connect_id) )
				{
					mysql_query("ROLLBACK", $this->db_connect_id);
					return false;
				}
			}
			
			return $this->query_result;
		}
		else
		{
			if( $this->in_transaction )
			{
				mysql_query("ROLLBACK", $this->db_connect_id);
				$this->in_transaction = FALSE;
			}
			return false;
		}
	}

	//
	// Other query methods
	//
	function sql_numrows($query_id = 0)
	{
		if($query_id === 'cache' && $this->cached)
		{
			return count($this->cache);
		}	
		if( !$query_id )
		{
			$query_id = $this->query_result;
		}

		return ( $query_id ) ? mysql_num_rows($query_id) : false;
	}

	function sql_affectedrows()
	{
		return ( $this->db_connect_id ) ? mysql_affected_rows($this->db_connect_id) : false;
	}

	function sql_numfields($query_id = 0)
	{
		if( !$query_id )
		{
			$query_id = $this->query_result;
		}

		return ( $query_id ) ? mysql_num_fields($query_id) : false;
	}

	function sql_fieldname($offset, $query_id = 0)
	{
		if( !$query_id )
		{
			$query_id = $this->query_result;
		}

		return ( $query_id ) ? mysql_field_name($query_id, $offset) : false;
	}

	function sql_fieldtype($offset, $query_id = 0)
	{
		if( !$query_id )
		{
			$query_id = $this->query_result;
		}

		return ( $query_id ) ? mysql_field_type($query_id, $offset) : false;
	}

	function sql_fetchrow($query_id = 0)
	{
		if($query_id === 'cache' && $this->cached)
		{
			return count($this->cache) ? array_shift($this->cache) : false;
		}	
		if( !$query_id )
		{
			$query_id = $this->query_result;
		}

		if( $query_id )
		{
			$this->row[(int)$query_id] = mysql_fetch_array($query_id, MYSQL_ASSOC);
			if($this->caching)
			{
				if($this->row[$query_id] === false)
				{
					$this->write_cache();
				}
				$this->cache[] = $this->row[$query_id];
			}			
			return $this->row[(int)$query_id];
		}
		else
		{
			return false;
		}
	}

	function sql_fetchrowset($query_id = 0)
	{
		if($query_id === 'cache' && $this->cached)
		{
			return $this->cache;
		}	
		if( !$query_id )
		{
			$query_id = $this->query_result;
		}

		if( $query_id )
		{
			unset($this->rowset[$query_id]);
			unset($this->row[$query_id]);

			while($rowset = mysql_fetch_array($query_id, MYSQL_ASSOC))
			{
				/*Vende: WTF?
				if($this->caching)
				{
					if($this->row[$query_id] === false)
					{
						$this->write_cache();
					}
					$this->cache[] = $this->row[$query_id];
				}*/		
				$result[] = $rowset; //$this->rowset[$query_id];
			}
			if($this->caching)
			{
				$this->cache = $result;
				$this->write_cache();
			}			

			return $result;
		}
		else
		{
			return false;
		}
	}

	function sql_fetchfield($field, $rownum = -1, $query_id = 0)
	{
		if( !$query_id )
		{
			$query_id = $this->query_result;
		}

		if( $query_id )
		{
			if( $rownum > -1 )
			{
				$result = mysql_result($query_id, $rownum, $field);
			}
			else
			{
				if( empty($this->row[$query_id]) && empty($this->rowset[$query_id]) )
				{
					if( $this->sql_fetchrow() )
					{
						$result = $this->row[$query_id][$field];
					}
				}
				else
				{
					if( $this->rowset[$query_id] )
					{
						$result = $this->rowset[$query_id][0][$field];
					}
					else if( $this->row[$query_id] )
					{
						$result = $this->row[$query_id][$field];
					}
				}
			}

			return $result;
		}
		else
		{
			return false;
		}
	}

	function sql_rowseek($rownum, $query_id = 0)
	{
		if( !$query_id )
		{
			$query_id = $this->query_result;
		}

		return ( $query_id ) ? mysql_data_seek($query_id, $rownum) : false;
	}

	function sql_nextid()
	{
		return ( $this->db_connect_id ) ? mysql_insert_id($this->db_connect_id) : false;
	}

	function sql_freeresult($query_id = 0)
	{
		if($query_id === 'cache')
		{
			$this->caching = false;
			$this->cached = false;
			$this->cache = array();
		}
		if($this->caching)
		{
			$this->write_cache();
		}	
		if( !$query_id )
		{
			$query_id = $this->query_result;
		}

		if ( $query_id )
		{
			unset($this->row[$query_id]);
			unset($this->rowset[$query_id]);

			@mysql_free_result($query_id);

			return true;
		}
		else
		{
			return false;
		}
	}

	// Vende: **PAN**
	function sql_quote($value)
	{
		return mysql_real_escape_string($value);
	}

	function sql_error()
	{
		$result['message'] = mysql_error($this->db_connect_id);
		$result['code'] = mysql_errno($this->db_connect_id);

		return $result;
	}

	function write_cache()
	{
		if(!$this->caching)
		{
			return;
		}
		global $phpbb_root_path;
		$f = fopen($phpbb_root_path . 'cache/sql_' . $this->caching . '.php', 'w');
		$data = var_export($this->cache, true);
		@fputs($f, '<?php $set = ' . $data . '; ?>');
		@fclose($f);
		@chmod($phpbb_root_path . 'cache/sql_' . $this->caching . '.php', 0777);
		$this->caching = false;
		$this->cached = false;
		$this->cache = array();
	}

	function clear_cache($prefix = '')
	{
		global $phpbb_root_path;
		$this->caching = false;
		$this->cached = false;
		$this->cache = array();
		$prefix = 'sql_' . $prefix;
		$prefix_len = strlen($prefix);
		if($res = opendir($phpbb_root_path . 'cache'))
		{
			while(($file = readdir($res)) !== false)
			{
				if(substr($file, 0, $prefix_len) === $prefix)
				{
					@unlink($phpbb_root_path . 'cache/' . $file);
				}
			}
		}
		@closedir($res);
	}

} // class sql_db

} // if ... define

?>
