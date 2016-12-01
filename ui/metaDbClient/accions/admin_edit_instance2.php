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
				$re=new relations();
				$ly_t=new layout_template();
				$at_t=new attributes_template();

				$params['p_mode']='V';

				$title=EDITORA_NAME." -> ".getMessage('info_create_object')." ".getClassName($params['param1']);
				$res=$in->insertAttributes($params);

				if ($res<0) {
					$body=$at_t->instanceAttributes_edit($at->getInstanceAttributes('U', $params), $params);
					$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);
					$parents=$ly_t->paintParentsList($in->getParents($params),$params);
				}

				if ($res==-1)
					$message=html_message_error(getMessage('error_param_mandatory'));			
				elseif ($res==-2)
					$message=html_message_error(getMessage('error_param_data'));
				elseif ($res==-3)
					$message=html_message_error(getMessage('error_param_urlnice'));
				else
				{
					//sabem que s'han insertat be els atribs, peticio de refresc de cache
					$in->refreshCache($params);
					
					$params['p_acces_type']='A';			
					$in->logAccess($params);
					$message=html_message_ok(getMessage('info_word_object').' '.$res.' '.getMessage('info_object_updated'));
					if (isset($_REQUEST['p_multiple'])) $p_multiple=$_REQUEST['p_multiple'];
					else $p_multiple=NULL;
					$ly_t->pinta_CommonLayout($top_menu, $buscador, $last_accessed, $favorites, $special, $ly, $in, $lg, $params);
					$parents=$ly_t->paintParentsList($in->getParents($params),$params);
					if ($p_multiple)
					{
						$title=EDITORA_NAME." -> ".getMessage('info_view_object');
						$res=$re->createRelation($params);
						$body=$at_t->instanceAttributes_view($at->getInstanceAttributes('V', $params), $params);
					}
					elseif ($params['param11'])
					{// Vengo del relacionar
						$title=EDITORA_NAME." -> ".getMessage('info_view_object');
						$res=$re->createRelation($params);
						$body=$at_t->instanceAttributes_view($at->getInstanceAttributes('V', $params), $params);
					}
					else
					{// No vengo del relacionar
						$params['param2'] = $res;
						$body=$at_t->instanceAttributes_view($at->getInstanceAttributes('V', $params), $params);
					}
					$ch=new cache();
					$ch->updateCache($res,'Y');
				}

				$_REQUEST['view']='container';
			}
			else
			{
				$_SESSION['missatge']=html_message_error(getMessage('error_role_privileges3'));
				$sc->redirect_url('/admin/get_main');
			}
		}
		else
		{
			$_SESSION['missatge']=html_message_error(getMessage('error_role_privileges3'));
			$sc->redirect_url('/admin/get_main');
		}
	}
?>