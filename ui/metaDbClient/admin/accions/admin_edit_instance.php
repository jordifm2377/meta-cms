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
		if ($sc->getAccess('editable',$params)) {
			if ($sc->getStatusAccess($params)) {
				$ly=new layout();
				$in=new instances();
				$at=new attributes();
				$ly_t=new layout_template();
				$at_t=new attributes_template();

				$params['p_mode']='V';
				$params['p_acces_type']='A';
				
				if ($params['param1'] == '' or $params['param1']<0)
					$params['param1']=$params['param12'];
				
				$in->logAccess($params);
				$title=EDITORA_NAME." -> ".getMessage('info_view_object');
				$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);
				$body=$at_t->instanceAttributes_edit($at->getInstanceAttributes('U', $params), $params);

				$_REQUEST['view']='container';
			}
			else {
				$_SESSION['missatge']=html_message_error(getMessage('error_role_privileges3'));
				$sc->redirect_url('/admin/get_main');
			}
		}
		else {
			$_SESSION['missatge']=html_message_error(getMessage('error_role_privileges3'));
			$sc->redirect_url('/admin/get_main');
		}
	}
?>