<?php
//à
require_once(DIR_APLI_ADMIN.'/models/model.php');


class security extends model
{
	function __construct()
	{
		return;
	}

	function clean($str)
	{
	  $ret=str_replace("\"", "\\\"", str_replace("[\]","",$str));
		$ret=str_replace("'", "", $ret);
		$ret=str_replace('"', '', $ret);
		return $ret;
	}

	function login ($p_username, $p_password) {
		global $dbh;
		$sql = "select u.id u_id, u.complete_name nom,
		u.rol_id r_id, r.rol_name r_nom, u.tipus tipus,
		language
		from omp_users u, omp_roles r
		where username = '".$this->clean($p_username)."'
		and password = '".$this->clean($p_password)."'
		and r.id = u.rol_id
		limit 1;";

		$ret = mysql_query($sql, $dbh);
		if(!$ret) return 0;

		$row = mysql_fetch_array($ret, MYSQL_ASSOC);

		if (count($row)==0) return 0;
		else { //Validacio correcte
			$_SESSION['user_id'] = $row['u_id'];
			$_SESSION['user_nom'] = $row['nom'];
			$_SESSION['rol_id'] = $row['r_id'];
			$_SESSION['rol_nom'] = $row['r_nom'];
			$_SESSION['user_type'] = $row['tipus'];
			$_SESSION['user_language'] = $row['language'];

			/* Inici carrega de la cache de classes */
			$sql2 = "select c.id, c.name_".getDefaultLanguage()." name
					from omp_classes c
					, omp_roles_classes rc
					, omp_users u
					where u.id=".$row['u_id']."
					and u.rol_id = rc.rol_id
					and rc.class_id = c.id
					and (rc.browseable = 'Y' or rc.browseable = 'P');";
			$ret2 = mysql_query($sql2, $dbh);
			if(!$ret2) return 0;

			$cc = array();
			while ($row2 = mysql_fetch_array($ret2, MYSQL_ASSOC)) {
				$cc[$row2['id']]=$row2['name'];
			}
			$_SESSION['classes_cache'] = $cc;
			/* Fi carrega de la cache de classes */

			$sql3="delete from omp_user_instances where user_id=".$row['u_id']." and tipo_acceso='A' and fecha<DATE_SUB(NOW(),INTERVAL 60 DAY)";
			$ret3 = mysql_query($sql3, $dbh);
			if(!$ret3)  return 0;

			return 1;
		}
	}

	function testSession()
	{
		if ($_SERVER['REQUEST_URI']!='/admin/') $_SESSION['last_page']=$_SERVER['REQUEST_URI'];
		if (isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
			return 1;
		else
			return 0;
	}


	function getStatus($p_status, $p_class_id)
	{
		$p_rol_id=$_SESSION['rol_id'];

//$sql = "select status".$p_status." st from omp_roles_classes where class_id = ".$this->clean($p_class_id)." and rol_id = ".$this->clean($p_rol_id)." ;";
		$sql = "select status".$p_status." st from omp_roles_classes where class_id = ".$this->clean($p_class_id)." and rol_id = ".$this->clean($p_rol_id)." ;";
//echo $sql;die;
		$ret=parent::get_one($sql);
		if(!$ret)
			return 0;

		if ($ret['st']=="Y")
			return 1;

		return 0;
	}

	function getAccess($p_camp_nom, $param_arr) {
		global $dbh;

		$p_class_id=$param_arr['param1'];
		$p_rol_id=$_SESSION['rol_id'];

		$sql = "select ".$this->clean($p_camp_nom)." x_able from omp_roles_classes where class_id = ".$this->clean($p_class_id)." and rol_id = ".$this->clean($p_rol_id)." ;";

		$ret = mysql_query($sql, $dbh);
		if(!$ret)
			return 0;

		while ($row = mysql_fetch_array($ret, MYSQL_ASSOC))
		{
			if ($row['x_able']=="Y")
				return 1;
			elseif ($row['x_able']=="P")
				return 1;
		}
		return 0;
	}


	function getAccess2($param_arr) {
		global $dbh;
		$p_inst_id=$param_arr['param2'];
		$p_rol_id=$_SESSION['rol_id'];

		$sql = "select count(id) num from omp_instances_roles where inst_id = ".$p_inst_id." and rol_id = ".$p_rol_id.";";
		$ret = mysql_query($sql, $dbh);
		if(!$ret)
			return 0;

		$row = mysql_fetch_array($ret, MYSQL_ASSOC);
		return $row['num'];
	}


	function buscaAccessTotal($param_arr) {
		global $dbh;
		$p_inst_id=$param_arr['param2'];
		$p_rol_id=$_SESSION['rol_id'];

		$result = 0;
		if ($this->getAccess2 ($param_arr)) return 1;
		else { //pillo els pare/s !!
			$sql="select ri.* from omp_relation_instances ri where ri.child_inst_id = ".$p_inst_id.";";
			$ret = mysql_query($sql, $dbh);
			if(!$ret)
				return 0;
			$flag = 0;
			while ($row = mysql_fetch_array($ret, MYSQL_ASSOC))
			{
				$flag = 1;
				$result = $result || buscaAccessTotal ($row['parent_inst_id'], $p_rol_id);
			}
			if ($flag == 0)
				return 0;
			else
				return $result;
		}
	}

	function getStatusAccess($param_arr) {
		global $dbh;
		$p_inst_id=$param_arr['param2'];
		$p_rol_id=$_SESSION['rol_id'];

		$sql = "select i.status st, rc.status1 st1, rc.status2 st2, rc.status3 st3
		from omp_instances i, omp_roles_classes rc
		where i.id = ".$this->clean($p_inst_id)."
		and rc.rol_id = ".$this->clean($p_rol_id)."
		and rc.class_id = i.class_id;";

		$ret = mysql_query($sql, $dbh);
		if(!$ret)
			return 0;

		while ($row = mysql_fetch_array($ret, MYSQL_ASSOC))
		{
			if ($row['st']=="P" && $row['st1']=="Y")
				return 1;
			if ($row['st']=="V" && $row['st2']=="Y")
				return 1;
			if ($row['st']=="O" && $row['st3']=="Y")
				return 1;
		}
		return 0;
	}

	function redirect_url($url)
	{
		header("Location: ".$url);
		die();
	}

}
?>
