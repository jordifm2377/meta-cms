<?php
//à
require_once($_SERVER['DOCUMENT_ROOT'].'/conf/ompinfo.php');
require_once (DIR_APLI_ADMIN.'/utils/validator.php');

class model
{
	function __construct()
	{ 
		return;
	}	

	function get_data($sql)
	{
		global $dbh;
		$ret = mysql_query($sql, $dbh);

		if (!$ret)
		{
			//debug('Error en mysql: '.mysql_error($dbh));
			echo 'Error en mysql: '.mysql_error($dbh); die();
			return false;
		}
		else
		{
			$arr=array();
			while ($row = mysql_fetch_array($ret, MYSQL_ASSOC))
			{
				array_push($arr, $row);
			}
			if (count($arr)>0)
				return $arr;
			else
				return false;
		}
	}

	function get_one($sql)
	{
		global $dbh;
		$ret = mysql_query($sql, $dbh);

		if (!$ret)
			return false;
		else
		{
			$row = mysql_fetch_array($ret, MYSQL_ASSOC);
			if ($row)
				return $row;
			else
				return false;
		}
	}

	function insert_one($sql)
	{
		global $dbh;
		$ret = mysql_query($sql, $dbh);

		if (!$ret)
			return false;
		else
		{
			$id = mysql_insert_id($dbh);
			if ($id)
				return $id;
			else
				return false;
		}  
	}

	function update_one($sql)
	{
		global $dbh;
		$ret = mysql_query($sql, $dbh);
		if (!$ret)
			return false;
		else
			return true;
	}  

	function execute ($sql)
	{
		global $dbh;
		$ret = mysql_query($sql, $dbh);
		$id = mysql_insert_id($dbh);
		return $id;
	}

	function escape ($string)
	{
		global $dbh;
		return mysql_real_escape_string($string, $dbh);
	}
}

?>
