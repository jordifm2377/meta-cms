<?php
//à
	$sc=new security();	
	if ($sc->testSession()==0)
	{
		$_SESSION['u_message'] = getMessage('info_word_privileges');
		redirect_action(APP_BASE.'/');
		return;
	}
	else
	{
		$params=get_params_info();

		$ly=new layout();
		$in=new instances();
		$at=new attributes();
		$re=new relations();
		$ly_t=new layout_template();
		$at_t=new attributes_template();

		$re->deleteRelationInstance($params);
		$in->refreshCache($params);
		if ($re) $message=html_message_ok(getMessage('info_word_deletejoin'));
		else $message=html_message_ok(getMessage('info_word_deletejoin_error'));
		
		$title=EDITORA_NAME." -> ".getMessage('info_view_object');
		$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);
		$body=$at_t->instanceAttributes_view($at->getInstanceAttributes('V', $params), $params);
		$parents=$ly_t->paintParentsList($in->getParents($params),$params);

		$_REQUEST['view']='container';
	}
?>