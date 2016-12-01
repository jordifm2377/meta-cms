<?php
//à
	$sc=new security();	
	if ($sc->testSession()==0) {
		$_SESSION['u_message'] = getMessage('info_word_privileges');
		redirect_action(APP_BASE.'/');
		return;
	}
	else {
		$params=get_params_info();
		if ($sc->getAccess('deleteable',$params)) {
			$ly=new layout();
			$in=new instances();
			$at=new attributes();
			$ly_t=new layout_template();
			$in_t=new instances_template();

			$params['p_mode']='V';

			$title=EDITORA_NAME." -> ".getMessage('info_delete_object')." ".getClassName($params['param1']);
			$message=html_message_ok($in->deleteInstance($params));
			$params['param1']='';
			
			$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);
			$instances = $in->instanceList($params);
			$body=$in_t->instancesList_view($instances, $in->instanceList_count($params), $params);

			$_REQUEST['view']='container';
		}
		else {
			$_SESSION['missatge']=html_message_error(getMessage('error_role_privileges'));
			$sc->redirect_url('/admin/get_main');
		}
	}
?>