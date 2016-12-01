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
		$params['p_mode']='V';

		$title=EDITORA_NAME." -> ".getMessage('info_create_object')." ".getClassName($params['param1']);
		$res=$in->insertAttributes($params);
                //echo($res); die;

		if ($res<0) {
                   // echo(error);
                        $ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);
			$body=$at_t->instanceAttributes_insert($at->getInstanceAttributes('I', $params), $params);
		
                        if ($res==-1) $message=html_message_error(getMessage('error_param_mandatory'));
                        elseif ($res==-2) $message=html_message_error(getMessage('error_param_data'));
                        elseif ($res==-3) $message=html_message_error(getMessage('error_param_urlnice'));

                }else {
			$params['p_acces_type']='A';
			$params['param2']=$res;
			$in->logAccess($params);
			$message=html_message_ok(getMessage('info_word_object').' '.$res.' '.getMessage('info_object_created'));
			
			$p_multiple = false;
			if(isset($_REQUEST['p_multiple'])) $p_multiple=$_REQUEST['p_multiple'];
				
			$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);

			if ($p_multiple) {
				$title=EDITORA_NAME." -> ".getMessage('info_view_object');
				$res2=$re->createRelation($params);
				$body=$at_t->instanceAttributes_view($at->getInstanceAttributes('V', $params), $params);
			}
			elseif ($params['param11']) {// Vengo del relacionar
				$params['param2']=$params['param11'];
				$in->refreshCache($params);
				$params['param13']=$res;
				$params['param2']=$params['param13'];
				$title=EDITORA_NAME." -> ".getMessage('info_view_object');
				$res2=$re->createRelation($params);
				$body=$at_t->instanceAttributes_view($at->getInstanceAttributes('V', $params), $params);
                                $parents=$ly_t->paintParentsList($in->getParents($params),$params);
			}
			else {// No vengo del relacionar
				$params['param2'] = $res;
				$body=$at_t->instanceAttributes_view($at->getInstanceAttributes('V', $params), $params);
                                $parents=$ly_t->paintParentsList($in->getParents($params),$params);
			}
			$ch=new cache();
			$ch->updateCache($res,'Y');
		}

		//$parents=$ly_t->paintParentsList($in->getParents($params),$params);
		$_REQUEST['view']='container';
	}
?>