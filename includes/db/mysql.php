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

if(defined("SQL_LAYER"))
{
	return;
}

define("SQL_LAYER","mysql");

class sql_db
{
	public $db_connect_id;
	public $num_queries = 0;
	public $queries;
	protected $row = array();
	protected $rowset = array();
	protected $caching = false;
	protected $cached = false;
	protected $cache = array();	
	protected $in_transaction = 0;

	//
	// Constructor
	//
	public function __construct($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)
	{
		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;
	}

	/**
	 * V: lazily connect to the db, only if needed
	 */
	private function connect()
	{
		if ($this->db_connect_id) {
			return;
		}

		$this->db_connect_id = ($this->persistency) ? @mysql_pconnect($this->server, $this->user, $this->password) : @mysql_connect($this->server, $this->user, $this->password);

		if( $this->db_connect_id ) {
			$dbselect = @mysql_select_db($this->dbname);

			if( !$dbselect ) {
				@mysql_close($this->db_connect_id);
				$this->db_connect_id = $dbselect;
			}

			return $this->db_connect_id;
		} else {
			message_die(CRITICAL_ERROR, "Could not connect to the database");
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
	public function sql_query($query = "", $transaction = FALSE, $cache = false)
	{
		//
		// Remove any pre-existing queries
		//
		$this->query_result = null;
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

		// now, connect, since it's not cached
		$this->connect();
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
			$qstart = microtime(true);
			$this->query_result = mysql_query($query, $this->db_connect_id);
			
			if (DEBUG)
			{
				$qend = microtime(true);
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
			$this->row[(int) $this->query_result] = null;
			$this->rowset[(int) $this->query_result] = null;

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
				if($this->row[(int) $query_id] === false)
				{
					$this->write_cache();
				}
				$this->cache[] = $this->row[(int) $query_id];
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
			$this->rowset[(int) $query_id] = null;
			$this->row[(int) $query_id] = null;

			$result = array();
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

	public function sql_freeresult($query_id = 0)
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
			$this->row[(int) $query_id] = null;
			$this->rowset[(int) $query_id] = null;

			@mysql_free_result($query_id);

			return true;
		}
		else
		{
			return false;
		}
	}

	// V: **PAN**
	function sql_quote($value)
	{
		return mysql_real_escape_string($value);
	}

	// +Stolen from IP (probably from CH / phpBB3)
	/**
	* Function for validating values
	*/
	function sql_validate_value($var)
	{
		if (is_null($var))
		{
			return 'NULL';
		}
		elseif (is_string($var))
		{
			return "'" . $this->sql_escape($var) . "'";
		}
		else
		{
			return (is_bool($var)) ? intval($var) : $var;
		}
	}

	/**
	* Escape string used in sql query
	*/
	function sql_escape($msg)
	{
		if (!$this->db_connect_id)
		{
			return @mysql_real_escape_string($msg);
		}

		return @mysql_real_escape_string($msg, $this->db_connect_id);
	}

	/**
	* Correctly adjust LIKE expression for special characters
	* Some DBMS are handling them in a different way
	*
	* @param string $expression The expression to use. Every wildcard is escaped, except $this->any_char and $this->one_char
	* @return string LIKE expression including the keyword!
	*/
	function sql_like_expression($expression)
	{
		$expression = str_replace(array('_', '%'), array("\_", "\%"), $expression);
		$expression = str_replace(array(chr(0) . "\_", chr(0) . "\%"), array('_', '%'), $expression);

		return $this->_sql_like_expression('LIKE \'' . $this->sql_escape($expression) . '\'');
	}

	/**
	* Build sql statement from array for select and select distinct statements
	* Possible query values: SELECT, SELECT_DISTINCT
	*/
	function sql_build_query($query, $array)
	{
		$sql = '';
		switch ($query)
		{
			case 'SELECT':
			case 'SELECT_DISTINCT';

				$sql = str_replace('_', ' ', $query) . ' ' . $array['SELECT'] . ' FROM ';

				// Build table array. We also build an alias array for later checks.
				$table_array = $aliases = array();
				$used_multi_alias = false;

				foreach ($array['FROM'] as $table_name => $alias)
				{
					if (is_array($alias))
					{
						$used_multi_alias = true;

						foreach ($alias as $multi_alias)
						{
							$table_array[] = $table_name . ' ' . $multi_alias;
							$aliases[] = $multi_alias;
						}
					}
					else
					{
						$table_array[] = $table_name . ' ' . $alias;
						$aliases[] = $alias;
					}
				}

				// We run the following code to determine if we need to re-order the table array. ;)
				// The reason for this is that for multi-aliased tables (two equal tables) in the FROM statement the last table need to match the first comparison.
				// DBMS who rely on this: Oracle, PostgreSQL and MSSQL. For all other DBMS it makes absolutely no difference in which order the table is.
				if (!empty($array['LEFT_JOIN']) && sizeof($array['FROM']) > 1 && $used_multi_alias !== false)
				{
					// Take first LEFT JOIN
					$join = current($array['LEFT_JOIN']);

					// Determine the table used there (even if there are more than one used, we only want to have one
					preg_match('/(' . implode('|', $aliases) . ')\.[^\s]+/U', str_replace(array('(', ')', 'AND', 'OR', ' '), '', $join['ON']), $matches);

					// If there is a first join match, we need to make sure the table order is correct
					if (!empty($matches[1]))
					{
						$first_join_match = trim($matches[1]);
						$table_array = $last = array();

						foreach ($array['FROM'] as $table_name => $alias)
						{
							if (is_array($alias))
							{
								foreach ($alias as $multi_alias)
								{
									($multi_alias === $first_join_match) ? $last[] = $table_name . ' ' . $multi_alias : $table_array[] = $table_name . ' ' . $multi_alias;
								}
							}
							else
							{
								($alias === $first_join_match) ? $last[] = $table_name . ' ' . $alias : $table_array[] = $table_name . ' ' . $alias;
							}
						}

						$table_array = array_merge($table_array, $last);
					}
				}

				$sql .= $this->_sql_custom_build('FROM', implode(', ', $table_array));

				if (!empty($array['LEFT_JOIN']))
				{
					foreach ($array['LEFT_JOIN'] as $join)
					{
						$sql .= ' LEFT JOIN ' . key($join['FROM']) . ' ' . current($join['FROM']) . ' ON (' . $join['ON'] . ')';
					}
				}

				if (!empty($array['WHERE']))
				{
					$sql .= ' WHERE ' . $this->_sql_custom_build('WHERE', $array['WHERE']);
				}

				if (!empty($array['GROUP_BY']))
				{
					$sql .= ' GROUP BY ' . $array['GROUP_BY'];
				}

				if (!empty($array['ORDER_BY']))
				{
					$sql .= ' ORDER BY ' . $array['ORDER_BY'];
				}

			break;
		}

		return $sql;
	}

	/**
	* Build SQL to INSERT or UPDATE from the provided array
	*/
	function sql_build_insert_update($sql_input_array, $sql_insert = true)
	{
		$insert_fields_sql = '';
		$insert_values_sql = '';
		$update_sql = '';
		foreach ($sql_input_array as $k => $v)
		{
			$insert_fields_sql .= (($insert_fields_sql == '') ? '' : ', ') . $k;
			$insert_values_sql .= (($insert_values_sql == '') ? '' : ', ') . $this->sql_validate_value($v);
			$update_sql .= (($update_sql == '') ? '' : ', ') . $k . ' = ' . $this->sql_validate_value($v);
		}

		$sql_string = $sql_insert ? (' (' . $insert_fields_sql . ') VALUES (' . $insert_values_sql . ')') : $update_sql;

		return $sql_string;
	}

	/**
	* Build sql statement from array for insert/update/select statements
	*
	* Idea for this from Ikonboard
	* Possible query values: INSERT, INSERT_SELECT, UPDATE, SELECT
	*
	*/
	function sql_build_array($query, $assoc_ary = false)
	{
		if (!is_array($assoc_ary))
		{
			return false;
		}

		$fields = $values = array();

		if (($query == 'INSERT') || ($query == 'INSERT_SELECT'))
		{
			foreach ($assoc_ary as $key => $var)
			{
				$fields[] = $key;

				if (is_array($var) && is_string($var[0]))
				{
					// This is used for INSERT_SELECT(s)
					$values[] = $var[0];
				}
				else
				{
					$values[] = $this->sql_validate_value($var);
				}
			}

			$query = ($query == 'INSERT') ? ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')' : ' (' . implode(', ', $fields) . ') SELECT ' . implode(', ', $values) . ' ';
		}
		elseif ($query == 'MULTI_INSERT')
		{
			trigger_error('The MULTI_INSERT query value is no longer supported. Please use sql_multi_insert() instead.', E_USER_ERROR);
		}
		elseif (($query == 'UPDATE') || ($query == 'SELECT'))
		{
			$values = array();
			foreach ($assoc_ary as $key => $var)
			{
				$values[] = "$key = " . $this->sql_validate_value($var);
			}
			$query = implode(($query == 'UPDATE') ? ', ' : ' AND ', $values);
		}

		return $query;
	}

	/**
	* Build IN or NOT IN sql comparison string, uses <> or = on single element arrays to improve comparison speed
	*
	* @access public
	* @param string $field name of the sql column that shall be compared
	* @param array $array array of values that are allowed (IN) or not allowed (NOT IN)
	* @param bool $negate true for NOT IN (), false for IN () (default)
	* @param bool $allow_empty_set If true, allow $array to be empty, this function will return 1=1 or 1=0 then. Default to false.
	*/
	function sql_in_set($field, $array, $negate = false, $allow_empty_set = false)
	{
		if (!sizeof($array))
		{
			if (!$allow_empty_set)
			{
				// Print the backtrace to help identifying the location of the problematic code
				$this->sql_error('No values specified for SQL IN comparison');
			}
			else
			{
				// NOT IN () actually means everything so use a tautology
				if ($negate)
				{
					return '1=1';
				}
				// IN () actually means nothing so use a contradiction
				else
				{
					return '1=0';
				}
			}
		}

		if (!is_array($array))
		{
			$array = array($array);
		}

		if (sizeof($array) == 1)
		{
			@reset($array);
			$var = current($array);

			return $field . ($negate ? ' <> ' : ' = ') . $this->sql_validate_value($var);
		}
		else
		{
			return $field . ($negate ? ' NOT IN ' : ' IN ') . '(' . implode(', ', array_map(array($this, 'sql_validate_value'), $array)) . ')';
		}
	}

	/**
	* Run more than one insert statement.
	*
	* @param string $table table name to run the statements on
	* @param array &$sql_ary multi-dimensional array holding the statement data.
	*
	* @return bool false if no statements were executed.
	* @access public
	*/
	function sql_multi_insert($table, &$sql_ary)
	{
		if (!sizeof($sql_ary))
		{
			return false;
		}

		if ($this->multi_insert)
		{
			$ary = array();
			foreach ($sql_ary as $id => $_sql_ary)
			{
				// If by accident the sql array is only one-dimensional we build a normal insert statement
				if (!is_array($_sql_ary))
				{
					$this->sql_query('INSERT INTO ' . $table . ' ' . $this->sql_build_array('INSERT', $sql_ary));
					return true;
				}

				$values = array();
				foreach ($_sql_ary as $key => $var)
				{
					$values[] = $this->_sql_validate_value($var);
				}
				$ary[] = '(' . implode(', ', $values) . ')';
			}

			$this->sql_query('INSERT INTO ' . $table . ' ' . ' (' . implode(', ', array_keys($sql_ary[0])) . ') VALUES ' . implode(', ', $ary));
		}
		else
		{
			foreach ($sql_ary as $ary)
			{
				if (!is_array($ary))
				{
					return false;
				}

				$this->sql_query('INSERT INTO ' . $table . ' ' . $this->sql_build_array('INSERT', $ary));
			}
		}

		return true;
	}
	// End IP/CH/phpBB3 DB
	
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
