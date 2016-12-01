<?php
	//à

	session_start();

	ini_set("memory_limit", "500M");
	set_time_limit(0);

	require_once($_SERVER['DOCUMENT_ROOT'].'/conf/ompinfo.php');
	error_reporting(ERROR_LEVEL);

	require_once(DIR_APLI_ADMIN.'/utils/urls.php');
	require_once(DIR_APLI_ADMIN.'/utils/omputils.php');
	require_once(DIR_APLI.'/utils/utils_common_admin.php');
	require_once(DIR_APLI_ADMIN.'/utils/parameters.php');
	global $dbh;

	header('Content-Type: text/html; charset=UTF-8', true);
	header("Cache-control: private");

	$_REQUEST['header']='header';
	$_REQUEST['footer']='footer';

	$googlemaps=false;
	$pag_num=null;
	extract_url_info();
	$lg = getDefaultLanguage();

	//REQUIRES
	require_once(DIR_LANGS.$lg.'/messages.inc');
	require_once(DIR_APLI_ADMIN.'/models/security.php');
	require_once(DIR_APLI_ADMIN.'/utils/redirect.php');
	require_once(DIR_APLI_ADMIN.'/utils/message_utils.php');
	require_once(DIR_APLI_ADMIN.'/models/attributes.php');
	require_once(DIR_APLI_ADMIN.'/models/cache.php');
	require_once(DIR_APLI_ADMIN.'/models/instances.php');
	require_once(DIR_APLI_ADMIN.'/models/layout.php');
	require_once(DIR_APLI_ADMIN.'/models/relations.php');
	require_once(DIR_APLI_ADMIN.'/templates/attributes.php');
	require_once(DIR_APLI_ADMIN.'/templates/instances.php');
	require_once(DIR_APLI_ADMIN.'/templates/layout.php');

	$accion_name='admin_'.$_REQUEST['action'].'.php';

	$action = $_REQUEST['action'];
	$mini_actions = array(
		'view_instance', 'edit_instance', 'join', 'join_all', 'delete_instance', 'edit_instance2',
		'new_instance', 'new_instance2', 'add_favorite', 'delete_favorite', 'order_up_top', 'order_down_bottom',
		'order_up', 'order_down', 'join2', 'delete_relation_instance', 'clone_instance', 'add_and_join'
	);

	$minibuscador_bool = false;
	$buscador = false;
	if (array_search($action, $mini_actions) !== false) {
		$minibuscador_bool = true;
		$buscador = true;
	}

	if (!file_exists(DIR_APLI_ADMIN.'/accions/'.$accion_name)) {
		header('HTTP/1.1 404 Not Found');
		eval('require_once(DIR_APLI_ADMIN."/accions/admin_get_main.php");');
		$_REQUEST['view']='notfound';
	}
	else {
		eval('require_once(DIR_APLI_ADMIN."/accions/$accion_name");');
	}


	if (isset($_SESSION['missatge']) && $_SESSION['missatge']<>'') $message=$_SESSION['missatge'];
	if ($_REQUEST['header']<>'') include(DIR_VIEWS."/".$_REQUEST['header'].".php");
	include(DIR_VIEWS."/".$_REQUEST['view'].".php");
	if ($_REQUEST['footer']<>'') include(DIR_VIEWS."/".$_REQUEST['footer'].".php");

	debug_print_backtrace();
	
	$_SESSION['missatge']='';
?>
