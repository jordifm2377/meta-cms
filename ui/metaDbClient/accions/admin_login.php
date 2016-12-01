<?php
//à
	$sc=new security();

	if ($sc->login($_REQUEST['p_username'],$_REQUEST['p_password'])==1) {
		if (isset($_SESSION['last_page']) && $_SESSION['last_page']!='') redirect_action($_SESSION['last_page']);
		else redirect_action(APP_BASE.'/get_main');
	}
	else {
		$_SESSION['u_message'] = getMessage('info_error');
		redirect_action(APP_BASE.'/');
		return;
	}

?>
