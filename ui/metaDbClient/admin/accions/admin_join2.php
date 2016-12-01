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
		$at=new attributes();
		$re=new relations();
		$ly_t=new layout_template();
		$at_t=new attributes_template();

		$params=get_params_info();
		$params['p_mode']='R';
		$params['p_acces_type']='A';
		$params['param1']=$params['param10'];
		$params['param2']=$params['param11'];

		$title=EDITORA_NAME." -> ".getMessage('info_view_object');
		$res=$re->createRelation($params);
		$in->refreshCache($params);
		if ($res) $message=html_message_ok(getMessage('info_word_object').$params['param13'].' '.getMessage('info_object_joined'));
		else $message=html_message_error(getMessage('info_word_object').$params['param13'].' '.getMessage('info_object_unjoined'));
		
		$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);
		$body=$at_t->instanceAttributes_view($at->getInstanceAttributes('V', $params), $params);
		$parents=$ly_t->paintParentsList($in->getParents($params),$params);

		$_REQUEST['view']='container';
		
	}
?>