<?php
//à

//echo "Jordi";
//die;
	session_start();

	ini_set("memory_limit", "500M");
	set_time_limit(0);

	$doc_root = $_SERVER['DOCUMENT_ROOT'];
#	require_once($doc_root.'/conf/ompinfo.php');
#	error_reporting(ERROR_LEVEL);

	require_once($doc_root.'/utils/urls.php');
#	require_once(DIR_APLI_ADMIN.'/utils/omputils.php');
#	require_once(DIR_APLI.'/utils/utils_common_admin.php');
#	require_once(DIR_APLI_ADMIN.'/utils/parameters.php');
	global $dbh;

	header('Content-Type: text/html; charset=UTF-8', true);
	header("Cache-control: private");

	$_REQUEST['header']='header';
	$_REQUEST['footer']='footer';

	$googlemaps=false;
	$pag_num=null;
	extract_url_info();

#	$lg = getDefaultLanguage();

	//REQUIRES
#	require_once(DIR_LANGS.$lg.'/messages.inc');
#	require_once(DIR_APLI_ADMIN.'/models/security.php');
#	require_once(DIR_APLI_ADMIN.'/utils/redirect.php');
#	require_once(DIR_APLI_ADMIN.'/utils/message_utils.php');
#	require_once(DIR_APLI_ADMIN.'/models/attributes.php');
#	require_once(DIR_APLI_ADMIN.'/models/cache.php');
#	require_once(DIR_APLI_ADMIN.'/models/instances.php');
#	require_once(DIR_APLI_ADMIN.'/models/layout.php');
#	require_once(DIR_APLI_ADMIN.'/models/relations.php');

	#require_once($doc_root.'/templates/attributes.php');
	#require_once($doc_root.'/templates/instances.php');
	#require_once($doc_root.'/templates/layout.php');


	$action = $_REQUEST['action'];
	$accion_name='admin_'.$action.'.php';

	if (!file_exists($doc_root.'/accions/'.$accion_name)) {
		header('HTTP/1.1 404 Not Found');
		eval('require_once($doc_root."/accions/admin_get_main.php");');
		$_REQUEST['view']='notfound';
	}
	else {
		eval('require_once($doc_root."/accions/$accion_name");');
	}


#	if (isset($_SESSION['missatge']) && $_SESSION['missatge']<>'') $message=$_SESSION['missatge'];
#	if ($_REQUEST['header']<>'') include(DIR_VIEWS."/".$_REQUEST['header'].".php");
#	include(DIR_VIEWS."/".$_REQUEST['view'].".php");
#	if ($_REQUEST['footer']<>'') include(DIR_VIEWS."/".$_REQUEST['footer'].".php");

	debug_print_backtrace();

	$_SESSION['missatge']='';
?>
