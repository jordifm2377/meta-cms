<?php
//à
	$_SESSION = array();
	session_destroy();
	redirect_action(APP_BASE.'/');
	return;
?>