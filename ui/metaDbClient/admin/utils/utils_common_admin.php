<?php
/**
 * Meta portal utils
 *
 * @version $Id$
 * @copyright 2004 
 à
**/

//////////////////////////////////////////////////////////////////////////////////////////
function pr($var) {
	echo '<pre>';
		print_r($var);
	echo '</pre>';
}

//////////////////////////////////////////////////////////////////////////////////////////
function parse_cadena($in_str) {
	$str_tmp = ereg_replace("\"", "\\\"", ereg_replace("[\]","",$in_str));
	$str_tmp = ereg_replace("'","\'",$str_tmp);

	return $str_tmp;
}

//////////////////////////////////////////////////////////////////////////////////////////
function parse_cadena_accents($string) {
	$arr1=array("À","Á","Â","Ã","Ä","Å","à","á","â","ã","ä","å","Ò","Ó","Ô","Õ","Ö","Ø","ò","ó","ô","õ","ö","ø","È","É","Ê","Ë","è","é","ê","ë","Ì","Í","Î","Ï","ì","í","î","ï","Ù","Ú","Û","Ü","ù","ú","û","ü","ÿ");
	$arr2=array("A","A","A","A","A","A","a","a","a","a","a","a","O","O","O","O","O","O","o","o","o","o","o","o","E","E","E","E","e","e","e","e","I","I","I","I","i","i","i","i","U","U","U","U","u","u","u","u","y");
	$string = str_replace ($arr1,$arr2, $string);
	return strtolower($string);
 }

//////////////////////////////////////////////////////////////////////////////////////////
function get_nice_from_id($id, $lg = 'ca') {
	global $dbh;
	if (!$dbh) return -1;

	$sql="select niceurl from omp_niceurl n, omp_instances i where i.id=inst_id and inst_id=".$id." and (language='".$lg."' or language='ALL')";

	if (isset($_REQUEST['req_info']) && $_REQUEST['req_info']==0) {
		$sql.=" and i.status = 'O'";
	}
	$result = mysql_query($sql,$dbh);
	if (!$result) return -2;

	if (mysql_num_rows($result) == 1) {
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		return $row['niceurl'];
	}

	return $id;
}

//////////////////////////////////////////////////////////////////////////////////////////
function date_to_mysql($p_date) { // Transforma de dd/mm/yyyy i opcionalment dd/mm/yyyy a yyyy-mm-dd hh24:mi:ss
	$dia = strtok($p_date,'/');
	$mes = strtok('/');
	$any = strtok('/');
	if (strlen($any)>4) {
		$any=substr($any,0, 4);
	}
	$res = $any.'-'.$mes.'-'.$dia;

	$tehora=strpos($p_date,':');
	if ($tehora) {
		$hores=substr(strtok($p_date, ':'),-2);
		$minuts=strtok(':');
		$segons=strtok(':');
		$hh24miss=' '.$hores.':'.$minuts.':'.$segons;
		$res.=$hh24miss;
	}
	
	return $res;
 }

//////////////////////////////////////////////////////////////////////////////////////////
function mysql_to_date($p_date,$hora = 0) {// reb yyyy-mm-dd hh24:mi:ss i retorna data normal
	$res='';
	$separate=explode(' ',$p_date);
	$dates=explode('-',$separate[0]);


	$res.=$dates[2].'/'.$dates[1].'/'.$dates[0];

	if ($hora) {
		$res.=' '.$separate[1];
	}

	return $res;
}

//////////////////////////////////////////////////////////////////////////////////////////
function control_idioma($lg) {
	global $array_langs;
	if (in_array ($lg,$array_langs,TRUE)) {
		return $lg;
	}
	return $array_langs[0];
}

//////////////////////////////////////////////////////////////////////////////////////////
function comproba_idioma($lg) {
	global $array_langs;
	if (in_array ($lg,$array_langs,TRUE)) {
		return TRUE;
	}
	return FALSE;
}

//////////////////////////////////////////////////////////////////////////////////////////
function filter_text2 ($original) {
	$search = array(
		"à", "á", "â", "ã", "ä", "À", "Á", "Â", "Ã", "Ä",
		"è", "é", "ê", "ë", "È", "É", "Ê", "Ë",
		"ì", "í", "î", "ï", "Ì", "Í", "Î", "Ï",
		"ó", "ò", "ô", "õ", "ö", "Ó", "Ò", "Ô", "Õ", "Ö",
		"ú", "ù", "û", "ü", "Ú", "Ù", "Û", "Ü",
		",", ".", ";", ":", "`", "´", "<", ">", "?", "}",
		"{", "ç", "Ç", "~", "^", "Ñ", "ñ"
	);
	$change = array(
		"a", "a", "a", "a", "a", "A", "A", "A", "A", "A",
		"e", "e", "e", "e", "E", "E", "E", "E",
		"i", "i", "i", "i", "I", "I", "I", "I",
		"o", "o", "o", "o", "o", "O", "O", "O", "O", "O",
		"u", "u", "u", "u", "U", "U", "U", "U",
		" ", " ", " ", " ", " ", " ", " ", " ", " ", " ",
		" ", "c", "C", " ", " ", "NY", "ny"
	);

	$filtered = strtoupper(str_ireplace($search,$change,$original));
	return $filtered;
}

//////////////////////////////////////////////////////////////////////////////////////////
function get_title_from_id ($id, $lg) {
	global $dbh;
	if (!$dbh) return -1;

	$sql="select v.text_val as id from omp_instances i, omp_attributes a, omp_values v
	where i.id = ".$id." and a.name = 'titol_".$lg."' and v.atri_id = a.id and v.inst_id = i.id";
	if ($_REQUEST['req_info']==0) {
		$sql.=" and i.status = 'O'";
	}

     
	$result = mysql_query($sql,$dbh);

        

	if (!$result) return -2;

	if (mysql_num_rows($result) == 1) {
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		return $row['id'];
	}
	return $row['id'];
}

//////////////////////////////////////////////////////////////////////////////////////////
function get_tag_from_id($p_instance_id) {
	$link = mysql_connect( dbhost, dbuser, dbpass) or die('Could not connect to server.' );
	mysql_select_db(dbname, $link) or die('Could not select database.');
	if (!$link) return -1;

	$sql="select tag
	from omp_instances i
	,omp_classes c
	where i.class_id=c.id
	and i.id=".$p_instance_id.";";

	$result = mysql_query($sql,$link);
	if (!$result) return -2;

	if (mysql_num_rows($result) == 1) {
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		return $row['tag'];
	}
	
	return '';
}

//////////////////////////////////////////////////////////////////////////////////////////
function get_value($p_lookup_id, $p_lang = 'ALL') {
	global $dbh;
	if (!$dbh) return "Error connect: ";

	$flag = 1;
	$res = "";
	$sql = "select lv.value_".$p_lang." label from omp_lookups_values lv where lv.id = ".$p_lookup_id.";";

	//echo $sql;
	$result = mysql_query($sql,$dbh);
	if ($result) {
		while ($un_valor = mysql_fetch_array($result)) {
			$res.=$un_valor['label'];
			$flag = 0;
		}
	}
        /*
	if ($flag) {
		$res=front_get_true_value($p_lookup_id, $p_lang);
	}
        */
	//echo $res;

	return $res;
}

//////////////////////////////////////////////////////////////////////////////////////////
function get_true_value($p_lookup_id, $p_lang = 'ALL') {
	global $dbh;
	if (!$dbh) {
		return "Error connect: ";
	}

	$flag = 1;
	$res = "";
	$sql = "select lv.value from omp_lookups_values lv where lv.id = ".$p_lookup_id.";";

	//echo $sql;
	$result = mysql_query($sql,$dbh);
	if ($result) $un_valor =mysql_fetch_array($result);

	return $un_valor['value'];
}

//////////////////////////////////////////////////////////////////////////////////////////
function extract_default($p_valor) {
	$string = str_replace(array("\r\n", "\r", "\n"), "<br />", $p_valor);
	return $string;
}
?>