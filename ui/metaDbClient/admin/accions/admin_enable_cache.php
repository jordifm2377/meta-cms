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
		if ($sc->getAccess('browseable',$params)) {
			$ly=new layout();
			$in=new instances();
			$at=new attributes();
			$ly_t=new layout_template();
			$at_t=new attributes_template();

			$params['p_mode']='V';
			$params['p_acces_type']='F';
			$params['p_cache_status']='Y';
			
			
			$ret=$in->changeInstanceCacheStatus($params);

			if($ret>0)
				$message=html_message_ok("Cache activada OK");
			else 
				$message=html_message_warning("Unexpected error: ".$ret);

			$title=EDITORA_NAME." -> ".getMessage('info_view_object');
			$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);
			$body=$at_t->instanceAttributes_view($at->getInstanceAttributes('V', $params), $params);
			$parents=$ly_t->paintParentsList($in->getParents($params),$params);

			$_REQUEST['view']='container';
		}
		else {
			$_SESSION['missatge']=html_message_error(getMessage('error_role_privileges'));
			$sc->redirect_url('/admin/get_main');
		}
	}
?>