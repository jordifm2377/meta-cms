<?php
//à
	$sc=new security();
	$c=new cache();
	if ($sc->testSession()==0) {
		$_SESSION['u_message'] = getMessage('error_session_timeout');
		redirect_action(APP_BASE.'/');
		return;
	}
	else {
		$_SESSION['missatge']=$c->regenerateCache();
		$sc->redirect_url('/admin/get_main');
	}
?>