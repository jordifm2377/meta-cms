<?php
//à
	$sc=new security();
	$i=new instances();
	if ($sc->testSession()==0) {
		$_SESSION['u_message'] = getMessage('error_session_timeout');
		redirect_action(APP_BASE.'/');
		return;
	}
	else {
		$ly=new layout();
		$in=new instances();
		$ly_t=new layout_template();
		$in_t=new instances_template();

		$params=get_params_info();
		$params['p_mode']='V';

		$title=EDITORA_NAME;
		$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);
		$body=$in_t->imagesList_view($i->unlinkedImages());

		$_REQUEST['view']='container';
	}
?>