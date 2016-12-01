<?php
//à
	$sc=new security();	
	if ($sc->testSession()==0) {
		$_SESSION['u_message'] = getMessage('info_word_privileges');
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
		$instances = $in->instanceList($params);
		$body=$in_t->instancesList_view($instances, $in->instanceList_count($params), $params);

		$_REQUEST['view']='container';
	}
?>