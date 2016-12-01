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
		$params['p_mode']='R';
		
		if (isset($params['param12']) && $params['param12']!='') $title=EDITORA_NAME." -> ".getMessage('info_joinsearch_object')." ".getClassName($params['param12'])." ".getMessage('info_word_joinwith')." ".getClassName($params['param10']);
		else $title=EDITORA_NAME." -> ".getMessage('info_joinsearch_object_lite')." ".getClassName($params['param12'])." ".getMessage('info_word_joinwith')." ".getClassName($params['param10']);
		$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);
		$instances = $in->instanceList($params);
		$body=$in_t->instancesList_relate($instances, $in->instanceList_count($params), $params);
		$parents=$ly_t->paintParentsList($in->getParents($params),$params);

		$_REQUEST['view']='container';

	}

?>
