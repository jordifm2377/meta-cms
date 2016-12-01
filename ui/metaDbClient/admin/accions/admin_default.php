<?php
//à
	$message='';
	if (isset($_SESSION['u_message']) && $_SESSION['u_message'] != '') $message=$_SESSION['u_message'];

	$title=EDITORA_NAME;
	$_REQUEST['view']='login';
	$_REQUEST['header']='';
	$_REQUEST['footer']='';
	$_SESSION['u_message'] = '';
?>