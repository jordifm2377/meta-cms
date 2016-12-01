<?php
//à
$_REQUEST['footer']='';

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
		if($sc->getAccess('editable',$params)) 
		{
			if(INST_PERM || $_SESSION['rol_id']==1 || $sc->buscaAccessTotal($params) || $sc->getAccess2($params)) 
			{
				$at=new attributes();
				$inst_id=$_REQUEST['p_inst_id'];
				$p_class_id=$params['param1'];
                                $p_tab_id=$_REQUEST['p_tab_id'];
				$images=$at->getImageAttributes($p_class_id);
			  if (empty($_REQUEST['p_image_to_clone']))
				// primer cop que entrem
				{
					$params['p_mode']='U';
					$params['p_acces_type']='A';
					
					$image_to_clone_atri_id=$_REQUEST['p_atri_id'];
					$image_to_clone=$at->getAttributeValues($image_to_clone_atri_id, $inst_id);
					$url_image_to_clone=$image_to_clone[0]['text_val'];
					$info_image_to_clone=explode('.', $image_to_clone[0]['img_info']);
					$width_image_to_clone=$info_image_to_clone[0];
					$height_image_to_clone=$info_image_to_clone[0];
					//$body.=print_r($image_to_clone, true);
					$body.='<div class="photo wrap">
                                                    <img src="'.URL_APLI.$url_image_to_clone.'" width="100px"/>';
					$body.='    <div id="clone-form" style="float:right; width: 270px;">';
					//$body.='    <form id="cloneimage" action="/admin/clone_image" method="post">';
                                        $body.='    <form id="cloneimage" action="/admin/clone_image" method="post">';
					$body.='    <input type="hidden" name="p_image_to_clone" value="'.$url_image_to_clone.'"/>';
					$body.='    <input type="hidden" name="p_inst_id" value="'.$inst_id.'"/>';
					$body.='    <input type="hidden" name="p_atri_id" value="'.$_REQUEST['p_atri_id'].'"/>';
					$body.='    <input type="hidden" name="p_class_id" value="'.$_REQUEST['p_class_id'].'"/>';
                                        $body.='    <input type="hidden" name="p_tab_id" value="'.$_REQUEST['p_tab_id'].'"/>';
                                        $body.='<ul>';
					$prev_tab='';
					foreach ($images as $image)
					{
						$previous_image='';
						$error_msg='';
						if ($prev_tab!=$image['tab_name']) $body.='<label for="">'.$image['tab_name'].'</label><span class="clear"></span>';
						$prev_tab=$image['tab_name'];
						$previous_image_value=$at->getAttributeValues($image['id'], $inst_id);
						if (!empty($previous_image_value))
						{
							$url_previous_image=$previous_image_value[0]['text_val'];
							$info_previous_image=explode('.', $image_to_clone[0]['img_info']);
							$width_previous_image=$info_image_to_clone[0];
							$height_previous_image=$info_image_to_clone[0];

							if ($image['id']!=$image_to_clone_atri_id)
							{// no es el mateix id
								if (empty($url_previous_image))
								{// no teniem imatge previament
									if ((empty($image['ai_width']) || $image['ai_width']<=$width_image_to_clone) 
									&& (empty($image['ai_height']) || $image['ai_height']<=$height_image_to_clone))
									{
										$checked=' checked="checked"';
									}
									else
									{
										$error_msg=' -- [Original too small]';
									}
								}
								else
								{
									$error_msg=' -- [Not empty]';
								}
							}
							else
							{// es la mateixa imatge
								$error_msg=' -- [Original]';
							}
						}
						else
						{// no teniem imatge previament
							if ((empty($image['ai_width']) || $image['ai_width']<=$width_image_to_clone) 
							&& (empty($image['ai_height']) || $image['ai_height']<=$height_image_to_clone))
							{
								$checked=' checked="checked"';
							}
							else
							{
								$error_msg=' -- <span class="red">[Original too small]</span>';
							}
						}
						$check='<input type="checkbox" name="p_clone[]" value="'.$image['id'].'" '.$checked.'/>';
						$body.='<li>'.$check.' <span>'.$image['caption'].' '.$image['ai_width'].'x'.$image['ai_height'].$error_msg.'</span></li>';
					}
                                        $body.='</ul>';
					$body.='<p class="btn"><input class="boto20" type="submit" value="Clonar" /></p>';
					$body.='</form>
					</div></div>';

                                        echo($body);
					
					//$_REQUEST['view']='container_popup';
                                        //$_REQUEST['view']='container';
				}
				else
				{// ja estem llançant el form
					require_once(DIR_APLI_ADMIN.'/models/imagecloner.php');
				  //print_r($_REQUEST);
					$cloned=0;
					if (!empty($_REQUEST['p_clone']))
					{
						foreach ($_REQUEST['p_clone'] as $atri_id)
						{
						  foreach ($images as $key=>$image_atr)
							{
							  if ($image_atr['id']==$atri_id)
								{
								  $image_attributes=$images[$key];
									break;
								}
							}
						
                                                        $image_cloner=new ImageCloner(DIR_APLI.'/'.$_REQUEST['p_image_to_clone']);
							$dst_filename=$image_cloner->generateFileName($image_cloner->img['file_name']);
							$new_atr_value=$image_cloner->clone_image($dst_filename, $image_attributes['ai_width'], $image_attributes['ai_height']);
							$size_array = getimagesize(DIR_APLI.'/'.$new_atr_value);
							$new_width=$size_array[0];
							$new_height=$size_array[1];
							//echo $new_atr_value.' '.$new_width.'x'.$new_height.'<br />';
							$image_cloner->save_image_attribute($inst_id, $atri_id, $new_atr_value, $new_width, $new_height);
							$cloned++;
						}					
					}
					if ($cloned>0)
					{// Actualitzem la cache
					  $cache_refresh=new cache();
						$cache_refresh->updateCache($inst_id, 'Y');
						//$message=$cloned.' Imágenes clonadas con éxito<br />';
                                                $_SESSION['missatge']=html_message_ok($cloned.' Imágenes clonadas con éxito');
					}
					else
					{
					  //$message='No se ha clonado ninguna imagen<br />';
                                          $_SESSION['missatge']=html_message_error('No se ha clonado ninguna imagen');
					}
					//$message="<a href='/admin/view_instance/?p_class_id=$p_class_id&p_inst_id=$inst_id&p_active_tab=fotos'>Cerrar</a>";
                                        $sc->redirect_url("/admin/view_instance/?p_class_id=$p_class_id&p_inst_id=$inst_id&p_active_tab=$p_tab_id");
                                        $_REQUEST['view']='container';

				}
			}
			else
			{
				$_SESSION['missatge']=html_message_error(getMessage('error_role_privileges2'));
				$sc->redirect_url('/admin/get_main');
			}
		}
		else
		{
			$_SESSION['missatge']=html_message_error(getMessage('error_role_privileges'));
			$sc->redirect_url('/admin/get_main');
		}
	}

?>
