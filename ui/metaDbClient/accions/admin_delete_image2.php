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
		$ly=new layout();
		$i=new instances();
		$at=new attributes();
		$ly_t=new layout_template();
		$in_t=new instances_template();

		$params['p_mode']='V';

		$title=EDITORA_NAME." -> ".getMessage('info_delete_image');
		$i->deleteImage($_REQUEST['image_full']);
		$message=html_message_ok(getMessage('info_image_deleted'));
			
		$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $i, $lg, $params);			
		$body=$in_t->imagesList_view($i->unlinkedImages());

		$_REQUEST['view']='container';
	}
?>