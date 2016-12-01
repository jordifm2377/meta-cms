<?php
//à

require_once(DIR_APLI_ADMIN.'/templates/template.php');


class attributes_template extends template
{
	function __construct() {
		return;
	}

	function instanceAttributes_view($instance_arr, $param_arr) {
		return $this->paintAttributes($instance_arr, $param_arr['param1'], 'V', $param_arr['param2'], NULL, $param_arr);
	}

	function instanceAttributes_edit($instance_arr, $param_arr) {
		return $this->paintAttributes($instance_arr, $param_arr['param1'], 'U', $param_arr['param2'], NULL, $param_arr);
	}

	function instanceAttributes_insert($instance_arr, $param_arr) {
		return $this->paintAttributes($instance_arr, $param_arr['param1'], 'I', NULL, NULL, $param_arr);
	}

	function instanceAttributes_insert_relation($instance_arr, $param_arr) {
		$include_form=
		'<input type="hidden" name="p_parent_class_id" value="'.$param_arr['param1'].'">
		<input type="hidden" name="p_relation_id" value="'.$param_arr['param9'].'">
		<input type="hidden" name="p_parent_inst_id" value="'.$param_arr['param2'].'">';

		return $this->paintAttributes($instance_arr, $param_arr['param1'], 'I', NULL, $include_form, $param_arr);
	}

	private function paintAttributes($instance_arr, $p_class_id, $p_mode, $p_inst_id, $p_include_form, $param_arr) {
		// p_mode indica si estem en Insert, Update o View
		$fila=-1;
		$columna=-1;
		$k=0;

		$res='<!-- CAIXA PESTANYES -->
                <div class="col_item tab_box">';
		$num_tabs=count($instance_arr);
		$tab_array=array();

		$res.='<!-- PESTANYES -->
                    <div class="tabs"><ul id="rowtab">';

		foreach($instance_arr['instance_info']['instance_tabs'] as $Row) {
			$tab_array[]=$Row['name'];
			if ($num_tabs<7) $tab_notab='';
			else $tab_notab='2';

                        /* PINTA TABS */
			if ($Row['id'] >= 0) {
				if(!isset($_REQUEST['p_active_tab']) || $_REQUEST['p_active_tab']=="") {
					if($k==0) {
						$res.='<li class="selected'.$tab_notab.'" onClick="$(\'div#taulatab div.amagable\').hide();$(\'div#'.$Row['name'].'\').show(); $(\'input#p_active_tab\').val(\''.$Row['name'].'\');$(\'ul#rowtab li\').attr(\'class\',\''.$tab_notab.'\');$(this).attr(\'class\',\'selected'.$tab_notab.'\');"><a href="javascript://" title="'.$Row['caption'].'">'.$Row['caption'].'</a></li>';
						$a_tab=$Row['name'];
						$default_tab=$Row['name'];
					}
					else $res.='<li class="'.$tab_notab.'" onClick="$(\'div#taulatab div.amagable\').hide();$(\'div#'.$Row['name'].'\').show(); $(\'input#p_active_tab\').val(\''.$Row['name'].'\');$(\'ul#rowtab li\').attr(\'class\',\''.$tab_notab.'\');$(this).attr(\'class\',\'selected'.$tab_notab.'\');" title="'.$Row['caption'].'"><a href="javascript://">'.$Row['caption'].'</a></li>';
				}
				elseif($Row['name']==$_REQUEST['p_active_tab']) { // El tab es el que hem seleccionat
					$res.='<li class="selected'.$tab_notab.'" onClick="$(\'div#taulatab div.amagable\').hide();$(\'div#'.$Row['name'].'\').show(); $(\'input#p_active_tab\').val(\''.$Row['name'].'\');$(\'ul#rowtab li\').attr(\'class\',\''.$tab_notab.'\');$(this).attr(\'class\',\'selected'.$tab_notab.'\');" title="'.$Row['caption'].'"><a href="javascript://">'.$Row['caption'].'</a></li>';
				}
				else { // Tab que no hem seleccionat
					$res.='<li class="'.$tab_notab.'" onClick="$(\'div#taulatab div.amagable\').hide();$(\'div#'.$Row['name'].'\').show(); $(\'input#p_active_tab\').val(\''.$Row['name'].'\');$(\'ul#rowtab li\').attr(\'class\',\''.$tab_notab.'\');$(this).attr(\'class\',\'selected'.$tab_notab.'\');" title="'.$Row['caption'].'"><a href="javascript://">'.$Row['caption'].'</a></li>';
				}

				$k++;
			}
		}

		$res.='</ul><div class="clear"></div>
                        </div><!-- /end PESTANYES -->';

		$res.=' <!-- CAIXA -->
                    <div class="edi_box" id="taulatab">';
		$res.=$this->getInstanceToolbar($instance_arr, $p_class_id, $p_inst_id, $p_mode, $p_include_form);

		$res_tabs="";
		$mandatory_hidden="";
		foreach($instance_arr['instance_info']['instance_tabs'] as $Row) {
			$fila=-1;
			$columna=-1;
			$res_tabs.='<!-- inicio div tab --><div id="'.$Row['name'].'" class="amagable">';

			$cont = count($Row['elsatribs']);
			$t=1;
			$res_attributes="";
			foreach($Row['elsatribs'] as $Row2) {
				if (($Row2['type']=='R' && $p_mode=='V') || $Row2['type']!='R') {
					$res_attributes.=$this->itemStackPrefix($fila, $columna, $Row2['fila'], $Row2['columna'], $p_mode, $cont);
					$fila=$Row2['fila'];
					$columna=$Row2['columna'];
					$atr_values=NULL;
					$res_attributes.=$this->getAttributeInner($Row2, $p_mode, $p_inst_id, $Row['name'], $t, $param_arr);
					$mandatory_hidden.=$this->attributeMandatory($Row2, $p_mode);

					$cont--;
					$t++;
				}
			}
			$res_tabs.=$res_attributes;
			//$res_tabs.=$this->itemStackPostfix($p_mode);
			$res_tabs.='</div></div></div></div><!-- Fin div tab-->';
		}
		$res.=$res_tabs;

		$Row=$instance_arr['instance_info']['instance_tabs'][0];
		if ($Row['id'] >= 0)
		{
			if (isset($_REQUEST['p_active_tab']) && $_REQUEST['p_active_tab']<>'') {
				$a_tab = $_REQUEST['p_active_tab'];
			}
			$res.='<input id="p_active_tab" type="hidden" name="p_active_tab" value="'.$a_tab.'"/>';

			if((!isset($_REQUEST['tab']) || $_REQUEST['tab']=="") && in_array($a_tab,$tab_array)) {
				$res.='<script type="text/javascript">$(\'div#taulatab div.amagable\').hide();$(\'div#'.$a_tab.'\').show();</script>';
			}
			elseif(in_array($_REQUEST['tab'],$tab_array)) {
				$res.='<script type="text/javascript">$(\'div#taulatab div.amagable\').hide();$(\'div#'.$_REQUEST['tab'].'\').show();</script>';
			}
			else {
				$res.='<script type="text/javascript">$(\'div#taulatab div.amagable\').hide();$(\'div#'.$default_tab.'\').show();</script>';
			}
		}

				
                //AQUI VAN LOS BOTONES del PIE
               $res.='  <div class="row btns_row">';
               $res.='<input type="hidden" name="p_mandatories" value="'.substr($mandatory_hidden,0,strlen($mandatory_hidden)-1).'"/>';
               if ($p_mode=='I' || $p_mode=='U') $res.='<input type="hidden" name="enviat" value="1"/>';
               $res.='
                    <div class="column">
                            <p class="btn_back"><a href="javascript://" onclick="history.go(-1)" title="'.getMessage('navigation_back').'">'.getMessage('navigation_back').'</a></p>';
                    
              if($p_class_id == 121){ //BOTÓ PER FER ENVIAMENT NEWSLETTER

              	//$res.='<p class="btn"><a href="" title="">'.getMessage('info_word_test_newsletter').'</a></p>';
              	//$res.='<p class="btn"><a href="" title="">'.getMessage('info_word_def_newsletter').'</a></p>';
              	$res.='<p class="btn" style="font-size: 1.6em;margin-left:5px;"><a href="/admin/newsletter_test?inst_id='.$p_inst_id.'" title="">Test newsletter</a></p>';
              	$res.='<p class="btn" style="font-size: 1.6em;margin-left:5px;"><a href="/admin/newsletter_def?inst_id='.$p_inst_id.'" title="">Enviament definitiu</a></p>';
              	$res.='<p class="btn" style="font-size: 1.6em;margin-left:5px;"><a href="/admin/newsletter_report?inst_id='.$p_inst_id.'" title="">Report newsletter</a></p>';

              }
              $res.='</div>';
              $res.='
                    <div class="column">';
                        if ($p_mode=='I') {
                            $res.='<p class="btn"><input type="submit" value="'.getMessage('info_word_add_button').'" class="boto20" /></p>';
                        }
                        elseif ($p_mode=='U') {
                                $res.='<p class="btn"><input type="submit" value="'.getMessage('info_word_update_button').'" class="boto20" /></p>';
                        }
                        elseif ($p_mode=='V') {
                                $res.='<p class="btn"><a href="'.APP_BASE.'/edit_instance/?p_pagina=1&amp;p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'" title="'.getMessage('info_word_edit_button').'" class="boto20">'.getMessage('info_word_edit_button').'</a></p>';
                        }
                        
              $res.='</div>
                    </div>
                </div><!-- FIN BOTONS --></form>';

		$res.='</div><!-- FIN TAULTAB -->';

                $res.=' </div><!-- FIN COL_ITEM TAB_BOX -->';

		return $res;
	}

	private function getInstanceToolbar($row, $p_class_id, $p_inst_id, $p_mode, $p_include_form = "")
	{

		if (isset($row['instance_info']['reserved']) && $row['instance_info']['reserved']==1 && $_SESSION['rol_id']<>SUPERROLID)
			$p_mode='V';


		if ($p_mode=='I')
		{//objecte nou
			$res.='<div class="edi_tit wrap"><h2>'.getMessage('creando_objeto').'  '.getMessage('viendo_objeto2').': <span>'.getClassName($p_class_id).'</span></h2></div>';

			$res.= '<div class="edi_panel wrap">';

			$res.= '
			<form class="form" method="post" ENCTYPE="multipart/form-data" name="Form1" action="'.APP_BASE.'/new_instance2">
			<input type="hidden" name="p_class_id" value="'.$p_class_id.'"/>';
			$res .= $p_include_form;
                        $res.= '
                        <!-- FILA 1 -->
                                <div class="row">
                                	<!-- COLUMNA ESQUERRA -->
                                    <div class="column">
                                    	<div class="col_item">';
			$res.= '<p><label for="">'.getMessage('info_word_status').'</label>';
			$res.= '<span class="ico_field">

                                <select name="p_status" id="p_status" onchange="changestatusimg(this);">';
			if ($row['status_list']['status1']==1) $res.= '<option value="P">'.getMessage('info_word_status_pending').'</option>';
			if ($row['status_list']['status2']==1) $res.='<option value="V">'.getMessage('info_word_status_reviewed').'</option>';
			if ($row['status_list']['status3']==1) $res.='<option value="O">'.getMessage('info_word_status_published').'</option>';
			$res.='</select><span class="status pending" title="Pendiente" id="statusimg">Pendiente</span>
                            </span></p><div class="clear"></div>';
                        $res.='</div>';
                        if ($_SESSION['user_type']=='O') {
				$res.='<div class="col_item">
                                        <p class="check">
                                            	<label for="">'.getMessage('info_word_reserved_instance').'</label>';
				//if($row['instance_info']['reserved']==1) $res.='<input type="checkbox" name="p_reserved_instance" id="" value="1" checked="checked">';
				//else $res.='<input name="p_reserved_instance" type="checkbox" value="1" />';
				$res.='</p>
                                        </div>';
                            }
                       $res.='
                             </div>
                             <!-- /end COLUMNA ESQUERRA -->';
                        $res.='<!-- COLUMNA DRETA -->
                                    <div class="column">
                                    	<div class="col_item">
                                            <div class="p">
                                                <p>';

			$res.= '<label for="">'.getMessage('info_word_publishing_begins').'</label>

			<span class="field">';
			if (isset($row['instance_info']['publishing_begins'])) $res.='<input type="text" length="35" name="p_publishing_begins" value="'.$row['instance_info']['publishing_begins'].'" id="date1" class="datepicker"/>';
			else $res.='<input type="text" length="35" name="p_publishing_begins" id="date1" class="datepicker"/>';
			$res.='</span>
                            </p>
                            </div>
                       </div>';

			$res.='<div class="col_item">
                                            <div class="p">
                                                <p>';
			$res.='
			 <label for="date_s2">'.getMessage('info_word_publishing_ends').':</label>';
			$res.='<span class="ico_field">';
			if (isset($row['instance_info']['publishing_ends'])) $res.='<input type="text" class="w_100" size="10" name="p_publishing_ends" value="'.$row['instance_info']['publishing_ends'].'" id="date2" class="datepicker"/></span>';
			else $res.='<input type="text" length="35" name="p_publishing_ends" id="date2" class="datepicker"/></span></td></tr>';

			$res.='';
			$res.='</div>
                            </div>
                                    </div>
                                	<!-- /end COLUMNA DRETA -->
                                        <div class="clear"></div>';
                        $res.='</div>
                            	<!-- /end FILA 1 -->';
		}
		elseif ($p_mode=='V') { //view
			if ($row['instance_info']['status']!="O") $html_delete='<li class="ico del"><a href="'.APP_BASE.'/delete_instance/?p_pagina=1&amp;p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'" title="Eliminar">Eliminar</a></li>';
			else $html_delete='';

			$html_edit='<li class="ico edi"><a href="'.APP_BASE.'/edit_instance/?p_pagina=1&amp;p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'" title="Editar">Editar</a></li>';
			$html_clone='<li class="ico clon"><a href="'.APP_BASE.'/clone_instance/?p_pagina=1&amp;p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'" title="Clonar">Clonar</a></li>';

			if($this->has_rec_cloner($p_class_id)) $html_rec_clone='<li class="ico clon_rec"><a title="Clonar recursivament" href="'.APP_BASE.'/recursive_clone/?p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'"><img src="'.ICONO_REC_CLONE.'" border="0" title="Clonar recursivament">Clonar recursivament</a></li>';

			$res.='<!-- TITOL -->
                            <div class="edi_tit wrap">';
			$res.='<h2>'.getMessage('viendo_objeto').'<strong> "'.$row['instance_info']['key_fields'].'"</strong>'.getMessage('viendo_objeto2').': <span>'.getClassName($p_class_id).'</span></h2>';
			if($row['instance_info']['cache_option']==1) {
				if($row['instance_info']['cache_functions']==0) { //Activar cache
					$html_cache='<li class="ico cache"><a href="'.APP_BASE.'/enable_cache/?p_pagina=1&amp;p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'" title="Activar cache">Activar cache</a></li>';
				}
				else { //Desactivar cache + força regeneracio + borrar
					$html_cache='<li class="ico cache_del"><a href="'.APP_BASE.'/disable_cache/?p_pagina=1&amp;p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'" title="Desactivar cache">Desactivar cache</a></li>';
					$html_cache.='<li class="ico cache_reload"><a href="'.APP_BASE.'/reload_cache/?p_pagina=1&amp;p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'" title="Regenerar cache">Regenerar cache</a></li>';
//					$html_cache.='<li class="ico cache_delete"><a href="'.APP_BASE.'/delete_cache/?p_pagina=1&amp;p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'" title="Borrar cache">Borrar cache</a></li>';
				}
			}
			$res.='<ul>
                            	<li class="ico fav"><a href="'.APP_BASE.'/add_favorite/?p_pagina=1&amp;p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'" title="Afegir a favorits">Afegir a favorits</a></li>
                            	'.$html_edit.$html_delete.$html_clone.$html_rec_clone.$html_cache.'
                               </ul>
                            </div>
                            <!-- /end TITOL -->';

			$res .= '
                            <!-- PLAFO EDICIO -->
                            <div class="edi_panel wrap">';

/*
                                $res.= '
                                <form class="form" method="post" ENCTYPE="multipart/form-data" name="Form1" action="'.APP_BASE.'/edit_instance">
                                    <input type="hidden" name="p_class_id" value="'.$p_class_id.'"/>
                                    <input type="hidden" name="p_inst_id" value="'.$p_inst_id.'"/>';
*/
                                $res.='
                                <!-- FILA 1 -->
                                <div class="row">
                                <!-- COLUMNA ESQUERRA -->
                                    <div class="column">
                                    	<div class="col_item">
                                            <p>
                                            	<label for="">'.getMessage('info_word_status').'</label>
                                                <span class="ico_field">
                                                    '.parent::status_to_html2($row['instance_info']['status']).'
                                                </span>
                                            </p><div class="clear"></div>
                                        </div>';
                                if ($_SESSION['user_type']=='O') {
                                    $res.='
                                        <div class="col_item">
                                            <p>
                                                <!--<label for="">'.getMessage('info_word_reserved_instance').'</label>-->';
                                               // if($row['instance_info']['reserved']==1) $instance.=getMessage('info_word_yes');
                                              //  else $instance.=getMessage('info_word_no');
                                             //   $res.='<input type="text" id="" name="" value="'.$instance.'" disabled="disabled" readonly="readonly" class="w_20 disabled" />';
                                    $res.='
                                            </p>
                                        </div>';
                                        }
                        $res .='</div>
                                <!-- /end COLUMNA ESQUERRA -->';

                        $res .='<!-- COLUMNA DRETA -->
                                    <div class="column">
                                    	<div class="col_item">
                                            <p>
                                                <label for="">'.getMessage('info_word_publishing_begins').'</label>
                                                <input type="text" id="date_s1" value="'.$row['instance_info']['publishing_begins'].'" size="10" name="p_fecha_ini" class="w_100 disabled" readonly="readonly">
                                            </p>
                                        </div>
                                        <div class="col_item">
                                            <div class="p">
                                                <p>
                                                    <label for="date_s2">'.getMessage('info_word_publishing_ends').'</label>
                                                    <input type="text" id="date_s2" value="'.$row['instance_info']['publishing_ends'].'" size="10" name="p_fecha_fin" disabled="disabled" readonly="readonly" class="w_100 disabled" />
                                                </p>
                                           </div>
                                        </div>
                                     </div>
                                     <!-- /end COLUMNA DRETA -->
                                     <div class="clear"></div>
                                    </div>
                                    <!-- /end FILA 1 -->';

		}
		elseif ($p_mode=='U') {  //edit
			$res.='<div class="edi_tit wrap">';
			$res.='<h2>'.getMessage('info_edit_object').' <strong>"'.$row['instance_info']['key_fields'].'"</strong> '.getMessage('info_word_typeof').' : <span>'.getClassName($p_class_id).'</span></h2>';
			$res .= '</div>
                            <div class="edi_panel wrap">';
			$res.= '
                                <form class="form" method="post" ENCTYPE="multipart/form-data" name="Form1" action="'.APP_BASE.'/edit_instance2">
                                <input type="hidden" name="p_class_id" value="'.$p_class_id.'"/>
                                <input type="hidden" name="p_inst_id" value="'.$p_inst_id.'"/>';
                        $res.='<!-- FILA 1 -->
                                <div class="row">
                                <!-- COLUMNA ESQUERRA -->
                                    <div class="column">
                                    	<div class="col_item">
                                        <p>
                                        <label for="">'.getMessage('info_word_status').'</label>
                                        <span class="ico_field">';

			$res .='<select name="p_status" name="id" onchange="changestatusimg(this);">';
			if ($row['status_list']['status1']==1) {
				if ($row['instance_info']['status']=='P') {
					$res.='<option value="P" SELECTED>'.getMessage('info_word_status_pending').'</option>';
					$img='<span id="statusimg" title="'.getMessage('info_word_status_pending').'" class="status pending">'.getMessage('info_word_status_pending').'</span>';
				}
				else {
					$res.='<option value="P">'.getMessage('info_word_status_pending').'</option>';
				}
			}

			if ($row['status_list']['status2']==1) {
				if ($row['instance_info']['status']=='V') {
					$res.='<option value="V" SELECTED>'.getMessage('info_word_status_reviewed').'</option>';
					$img='<span id="statusimg" title="'.getMessage('info_word_status_reviewed').'" class="status revised">'.getMessage('info_word_status_reviewed').'</span>';
				}
				else {
					$res.='<option value="V">'.getMessage('info_word_status_reviewed').'</option>';
				}
			}

			if ($row['status_list']['status3']==1) {
				if ($row['instance_info']['status']=='O') {
					$res.='<option value="O" SELECTED>'.getMessage('info_word_status_published').'</option>';
					$img='<span id="statusimg" title="'.getMessage('info_word_status_published').'" class="status publish">'.getMessage('info_word_status_published').'</span>';
				}
				else {
					$res.='<option value="O">'.getMessage('info_word_status_published').'</option>';
				}
			}
			$res .='</select>'.$img;


			$res .= '</span></p>
                            </div>';
                            if ($_SESSION['user_type']=='O') {
				$res.='<div class="col_item">
                                        <p class="check">
                                            	<!--<label for="">'.getMessage('info_word_reserved_instance').'</label>-->';
				//if($row['instance_info']['reserved']==1) $res.='<input type="checkbox" name="p_reserved_instance" id="" value="1" checked="checked">';
				//else $res.='<input name="p_reserved_instance" type="checkbox" value="1" />';
				$res.='</p>
                                        </div>';
                            }
                             $res .= '
                                    </div>
                                	<!-- /end COLUMNA ESQUERRA -->


			<!-- COLUMNA DRETA -->
                                    <div class="column">
                                    	<div class="col_item">
                                            <div class="p">
                                                <p>
                                                
                                                <label for="date_s1">'.getMessage('info_word_publishing_begins').'</label>
                                                <input type="text" length="35" name="p_publishing_begins" value="'.$row['instance_info']['publishing_begins'].'" id="date1" class="datepicker" />
                                                
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col_item">
                                            <div class="p">
                                                <p>
                                                <label for="date_s2">'.getMessage('info_word_publishing_ends').'</label>
                                                <input type="text" length="35" name="p_publishing_ends" value="'.$row['instance_info']['publishing_ends'].'" id="date2" class="datepicker"/>
                                                </p>
                                            </div>
                                        </div>
                                     </div>
                                	<!-- /end COLUMNA DRETA -->
                                        <div class="clear"></div>
                                  </div>
                            	<!-- /end FILA 1 -->';

		}



		return $res;
	}

	private function get_inst_toolbar_special ($p_class_id, $p_inst_id, $p_mode)
	{
		$res='';
		if ($p_mode=='I') {//objecte nou
			$res.='<div class="filacap"><h3>Creando objeto de tipo '.getClassName($p_class_id).':</h3></div>';
		}

		return $res;
	}


	private function attributeMandatory($row, $p_mode) {
		if ($row['mandatory']=='Y') return($row['id'].',');
		else return '';
	}

	private function itemStackPrefix($p_fila_ant, $p_columna_ant, $p_fila, $p_columna, $p_mode, $p_last = 1) {
                $ret="";

		// Primera fila
		if ($p_fila_ant==-1) $ret.= "<div class='row' rel='". $p_fila." fila'>";

		// Primera fila i columna
		if ($p_columna_ant==-1) $ret.= "<div class='column' rel='". $p_columna."'>
                                                    <div class='col_item'>";

		if ($p_columna_ant!=-1) {
			if ($p_columna_ant!=$p_columna) { // Cambio de columna
				if ($p_fila_ant==$p_fila) { // En la misma fila
						$ret.= "</div>
					</div>
					<div class='column' rel='". $p_columna."'>
						<div class='col_item'>";
				}
				elseif ($p_last == 0) { // En la misma fila
					$ret.= "</div>";
				}
				else { // Canvi de columna i de fila
						$ret.= "</div>
							</div>
						<div class='clear'></div>
					</div>
					<div class='row' rel='". $p_fila."'>
						<div class='column' rel='". $p_columna."'>
							<div class='col_item'>";

				}
			}
			else {// Estamos en la misma fila
				if ($p_fila_ant!=$p_fila && $p_last != 0) // Canvi nomes de columna
					$ret.= "</div></div><div class='column' rel='". $p_columna."'><div class='col_item'>";
			}
		}

		return $ret;
	}

	private function itemStackPostfix($p_mode) {
                return "</div></div></div>";
	}

        /* ESTA FUNCION PINTA LOS ATRIBUTOS Y RELACIONES DE CADA PESTAÑA DE CONTENIDO */
	private function getAttributeInner($row, $p_mode, $p_inst_id, $tab_id='',$i, $param_arr) {
            //pr($row);
		$ret='';
		global $googlemaps;
		global $autocomplete_str;
		global $autocomplete_header_str;
		$prefix="";
		$postfix="";

		$valor_simple=array();
		if ($row['mandatory']=='Y') $prefix="atr_M".$row['type'].'_';
		else $prefix="atr_O".$row['type'].'_';

		if ($row['ordre_key']) $postfix="_".$row['ordre_key'];

		if ($p_mode != 'I') $valor_simple=$row;
/*
		if ($p_mode != 'I') {// Es update o view i ames no es un lookup, que es tracta de manera especial, escanejem els valors
			$valor_simple = mysql_fetch_array($p_values, MYSQL_ASSOC);
		}
*/
		$max_height=$row['max_height'];
		$max_width=$row['max_width'];
		$img_w=$row['img_w'];
		$img_h=$row['img_h'];



		// Pintem el camp
	   $ret .= '<div class="icos_list tit_rel">
			<h3 class="label">'.$row["caption"].' '.html_mandatory_chunk($row['mandatory']).':</h3>
			<ul>
				'.$this->getDescription($row).'
			</ul>';
			
			if ($row['type']=="R" && $p_mode=='V') {
                                        $ret.='<ul class="icos_list">';
					if ($row['join_icon']=='Y') {
						$params_url=generate_url_params($param_arr['param4'],str_replace("-", "/", $param_arr['param5']),str_replace("-", "/", $param_arr['param6']),$param_arr['param7'],$param_arr['param8'],$row['id'],$param_arr['param2'],$row['lookup_id'],$row['max_length'],$param_arr['param13']);
						$ret.='<li class="ico link"><a title="'.getMessage('info_word_join').'" href="'.APP_BASE.'/join/?p_pagina=1&amp;p_class_id='.$row['max_length'].'&amp;p_inst_id='.$param_arr['param2'].$params_url.'">'.getMessage('info_word_join').'</a></li>';
					}
					if ($row['create_icon']=='Y' && $row['max_length']!=0) {
						$params_url=generate_url_params($param_arr['param4'],str_replace("-", "/", $param_arr['param5']),str_replace("-", "/", $param_arr['param6']),$param_arr['param7'],$param_arr['param8'],$row['id'],null,$row['lookup_id'],$row['max_length'],$param_arr['param13']);
						$ret.='<li class="ico add"><a title="'.getMessage('info_word_addjoin').'" href="'.APP_BASE.'/add_and_join/?p_pagina=1&amp;p_relation_id='.$row['id'].'&amp;p_inst_id='.$p_inst_id.'&amp;p_parent_class_id='.$row['lookup_id'].'&amp;p_child_class_id='.$row['max_length'].'&amp;p_tab='.$tab_id.'">'.getMessage('info_word_addjoin').'</a></li>';
					}

			}
                        // CLONAR IMATGES
                        if ($row['type']=="I" && $p_mode=='V') {
                            //print_r($tab_id);
                                        $ret.='<ul class="icos_list">';
                                        //$ret.='<li class="ico clon"><a title="'.getMessage('info_word_clone').'" href="'.APP_BASE.'/clone_image/?p_pagina=1&amp;p_class_id='.$row['class_id'].'&amp;p_inst_id='.$p_inst_id.'&amp;p_atri_id='.$row['id'].'"&amp;p_tab='.$tab_id.'">'.getMessage('info_word_clone').'</a></li>';
                                        $ret.='<li class="ico clon2"><a title="'.getMessage('info_word_clone').'" href="javascript://" onclick="cloneImage('.$row['class_id'].','.$p_inst_id.','.$row['id'].',\''.$tab_id.'\');">'.getMessage('info_word_clone').'</a></li>';
			}
                        //
                        if ($row['join_massive']=='Y' && $row['max_length']!=0) {
                                $ret.='<a href="controller.php?p_action=add_massive&amp;p_relation_id='.$row['id'].'&amp;p_inst_id='.$p_inst_id.'&amp;p_parent_class_id='.$row['lookup_id'].'&amp;p_child_class_id='.$row['max_length'].'&amp;p_tab='.$tab_id.'" class="omp_field ico lupa"><img class="icon" src="'.APP_BASE.'/images/plus_nova.gif" border="0" title="'.getMessage('info_word_addmassive').'"/></a>';
                                $ret.='<a href="controller.php?p_action=export_massive&amp;p_relation_id='.$row['id'].'&amp;p_inst_id='.$p_inst_id.'&amp;p_parent_class_id='.$row['lookup_id'].'&amp;p_child_class_id='.$row['max_length'].'&amp;p_tab='.$tab_id.'" class="omp_field ico lupa"><img class="icon" src="'.APP_BASE.'/images/export_massiu.gif" border="0" title="'.getMessage('info_word_exportmassive').'"/></a>';
                                $ret.='<a onclick="function dr(){if (confirm(\''.getMessage('delete_massive_confirmation').'\')) return true; else return false;}return dr();"href="controller.php?p_action=delete_relation_instance_all&amp;p_relation_id='.$row['rel_id'].'&amp;p_class_id='.$row['lookup_id'].'&amp;p_inst_id='.$p_inst_id.'&amp;p_tab='.$tab_id.'" class="omp_field ico lupa"><img class="icon" src="'.APP_BASE.'/images/plus_delete.gif" border="0" title="'.getMessage('info_word_unjoin_all').'"/></a>';
                        }
          $ret.='</ul>';
					
                        if ($row['autocomplete']=='Y' && $row['max_length']!=0) {
                                $ret.='<form id="autocomplete-form-'.$row['id'].'" method="post" action="'.APP_BASE.'/autocomplete_add">
                                <input type="text" name="autocomplete-'.$row['id'].'" id="autocomplete-'.$row['id'].'" style="display:block;width:90px"/>
                                <input type="hidden" name="p_child_inst_id" id="autocomplete-hidden-'.$row['id'].'" value="" />
                                <input type="hidden" name="p_rel_id" value="'.$row['id'].'" />
                                <input type="hidden" name="p_parent_inst_id" value="'.$p_inst_id.'" />
                                <input type="hidden" name="p_tab_id" value="'.$tab_id.'" />
                                </form>';

                                $autocomplete_str.='
<script type="text/javascript">
  $( "#autocomplete-'.$row['id'].'" ).autocomplete({ 
      minLength: 3,
      source: "'.APP_BASE.'/autocomplete/?p_relation_id='.$row['id'].'&p_inst_id='.$p_inst_id.'&p_parent_class_id='.$row['lookup_id'].'&p_child_class_id='.$row['max_length'].'&p_tab='.$tab_id.'", //change here the source of your values
      focus: function( event, ui ) {
        $( "#autocomplete-'.$row['id'].'" ).val( ui.item.label );
        $( "#autocomplete-hidden-'.$row['id'].'" ).val( ui.item.value);
        //you had more stuff here
        return false;
      },
      select: function( event, ui ) {
        $( "#autocomplete-'.$row['id'].'" ).val( ui.item.label );
        $( "#autocomplete-hidden-'.$row['id'].'" ).val( ui.item.value);
        //you had more stuff here
        return false;
      }, 
      })
    .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
        .appendTo( ul );
    };

</script>
';				

        $autocomplete_header_str.='
		$("#autocomplete-form-'.$row['id'].'").on("submit", function(event) {
      var link = $(this).attr("action");
      $.ajax({
        url: link,
        type: "POST",
        data: $(this).serialize(),
        dataType: "html",
				success: function(html){
				  $("#tabrel'.$row['id'].'").html(html);
				}
    });		
		return false;
		});
';			
					
			}
			$ret .= '<div class="clear"></div>
		</div>';

		if (isset($valor_simple['atrib_values'][0]['text_val'])) $trueValue = $this->getTrueValue($valor_simple['atrib_values'][0]['text_val']);
		else $trueValue = '';
		if (isset($valor_simple['atrib_values'][0]['text_val'])) $trueCleanedValue = $this->getTrueValue($valor_simple['atrib_values'][0]['text_val'],1);
		else $trueCleanedValue = '';
		if (isset($valor_simple['atrib_values'][0]['date_val'])) $trueDateValue = $this->getTrueValue($valor_simple['atrib_values'][0]['date_val']);
		else $trueDateValue = '';
		if (isset($valor_simple['atrib_values'][0]['num_val'])) $trueNumValue = $this->getTrueValue($valor_simple['atrib_values'][0]['num_val']);
		else $trueNumValue = '';

		if ($row['type']=="S") {// String d'una linea
			if ($p_mode=='I') {
				$ret.='<input class="w_250" tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueCleanedValue.'"/>';
			}
			elseif($p_mode=='U') {
				$ret.='<input class="w_250" tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueCleanedValue.'"/>';
			}
			elseif($p_mode=='V') {
				$ret.='<span class="label">'.$trueCleanedValue.'</span>';
			}
		}
		elseif ($row['type']=="A") { // Text Area WYSIWYG
			$max_width=TEXTAREA_DEFAULT_LENGTH;
			if ($p_mode=='I') {
				$ret.='<textarea tabindex="'.$i.'" class="w_200" cols="'.$max_width.'" rows="'.$max_height.'" id="'.$prefix.$row['id'].$postfix.'" name="'.$prefix.$row['id'].$postfix.'">'.$trueCleanedValue.'</textarea>';
				$ret.='<script type="text/javascript">
					$(\'#'.$prefix.$row['id'].$postfix.'\').markItUp(mySettings);
				</script>';
			}
			elseif($p_mode=='U') {
				$ret.='<textarea tabindex="'.$i.'" class="w_200" cols="'.$max_width.'" rows="'.$max_height.'" id="'.$prefix.$row['id'].$postfix.'" name="'.$prefix.$row['id'].$postfix.'">'.$trueCleanedValue.'</textarea>';
				$ret.='<script type="text/javascript">
					$(\'#'.$prefix.$row['id'].$postfix.'\').markItUp(mySettings);
				</script>';
			}
			elseif($p_mode=='V') {
				$ret.='<textarea tabindex="'.$i.'" cols="'.$max_width.'" rows="'.$max_height.'" name="'.$prefix.$row['id'].$postfix.'" disabled="true">'.$trueCleanedValue.'</textarea>';
			}
		}
		elseif ($row['type']=="T") { // Text Area HTML
			$max_width=TEXTAREA_DEFAULT_LENGTH;
			if ($p_mode=='I') {
				$ret.='<textarea tabindex="'.$i.'" class="w_250" cols="'.$max_width.'" rows="'.$max_height.'" id="'.$prefix.$row['id'].$postfix.'" name="'.$prefix.$row['id'].$postfix.'">'.$trueCleanedValue.'</textarea>';
			}
			elseif($p_mode=='U') {
				$ret.='<textarea tabindex="'.$i.'" class="w_250" cols="'.$max_width.'" rows="'.$max_height.'" id="'.$prefix.$row['id'].$postfix.'" name="'.$prefix.$row['id'].$postfix.'">'.$trueCleanedValue.'</textarea>';
			}
			elseif($p_mode=='V') {
				$ret.='<textarea tabindex="'.$i.'" cols="'.$max_width.'" rows="'.$max_height.'" name="'.$prefix.$row['id'].$postfix.'" disabled="true">'.$trueCleanedValue.'</textarea>';
			}
		}
		elseif ($row['type']=="C") { // Text Area
			$max_width=TEXTAREA_DEFAULT_LENGTH;
			if ($p_mode=='I') {
				$ret.='<textarea tabindex="'.$i.'" cols="'.$max_width.'" rows="'.$max_height.'" id="'.$prefix.$row['id'].$postfix.'" name="'.$prefix.$row['id'].$postfix.'">'.$trueCleanedValue.'</textarea>';
				$ret.='<script type="text/javascript">
					$(\'#'.$prefix.$row['id'].$postfix.'\').markItUp(mySettings);
				</script>';
			}
			elseif($p_mode=='U') {
				$ret.='<textarea tabindex="'.$i.'" cols="'.$max_width.'" rows="'.$max_height.'" id="'.$prefix.$row['id'].$postfix.'" name="'.$prefix.$row['id'].$postfix.'">'.$trueCleanedValue.'</textarea>';
				$ret.='<script type="text/javascript">
					$(\'#'.$prefix.$row['id'].$postfix.'\').markItUp(mySettings);
				</script>';
			}
			elseif($p_mode=='V') {
				$ret.='<textarea tabindex="'.$i.'" cols="'.$max_width.'" rows="'.$max_height.'" name="'.$prefix.$row['id'].$postfix.'" disabled="true">'.$trueCleanedValue.'</textarea>';
			}
		}
		elseif ($row['type']=="Y") { // String d'una linea
			if ($p_mode=='I') {
				 $ret.='<input class="w_250" tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueCleanedValue.'"/>';
			}
			elseif($p_mode=='U') {
				$ret.='<input class="w_250" tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueCleanedValue.'"/>';
			}
			elseif($p_mode=='V') {
				if (isset($valor_simple['atrib_values'][0])) {
					$ret.='<span class="label">'.$trueCleanedValue.'</span>';
                }
			}
		}
		elseif ($row['type']=="I") { // Image
			if ($p_mode=='I') {
				if (UPLOAD_TYPE=='flash') {
					$ret.='<a href="javascript:uploadFile(\''.$row['id'].'\',\''.$prefix.$row['id'].$postfix.'\',\''.date('Ymd').'/\',\''.$p_inst_id.'\',\''.$img_w.'\',\''.$img_h.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>
	                <input class="w_200" tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" id="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'" />';
				}
				else {
					$ret.='<input class="w_200 float_left" tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" id="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'" />
					<a class="ico clip" href="javascript:show_upload(\'Form1.'.$prefix.$row['id'].$postfix.'\',\''.$img_w.'\',\''.$img_h.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>';
				}
				$ret.="<a class='ico lupa' href='javascript://' onclick='browseImage(\"".$prefix.$row['id'].$postfix."\");'></a>";
			}
			if ($p_mode=='U') {
				if (UPLOAD_TYPE=='flash') {
					$ret.='<input class="w_200" tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" id="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'"/>
					<a href="javascript://" onclick="uploadFile(\''.$row['id'].'\',\''.$prefix.$row['id'].$postfix.'\',\''.date('Ymd').'/\',\''.$p_inst_id.'\',\''.$img_w.'\',\''.$img_h.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"-->asd</a>';
				}
				else {
					$ret.='<input  class="w_200 float_left" tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" id="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'"/>
					<a class="ico clip" href="javascript:show_upload(\'Form1.'.$prefix.$row['id'].$postfix.'\', \''.$img_w.'\', \''.$img_h.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>';
				}
				$ret.="<a class='ico lupa' href='javascript://' onclick='browseImage(\"".$prefix.$row['id'].$postfix."\");'></a>";

				if (!empty($trueValue)) {
					$mida_real=explode('.',$valor_simple['atrib_values'][0]['img_info']);
					$mides=explode('(',$row['caption']);
                                        //echo($mida_real[0]).'<br/>';
                                        //echo($mida_real[1]).'<br/>';
                                        //echo($trueValue);
                                        
                    $ret.= ' <div class="photo wrap">';
						if ($mida_real[0]>=$mida_real[1]) $ret .= '<img alt="" src="'.URL_APPLICATION.$trueValue.'" />';
						else $ret.= '<img alt="" src="'.URL_APPLICATION.$trueValue.'"/>';

						$ret.='<div>
							<dl>
								<dt>'.getMessage('theoric_size').':</dt>
									<dd>'.$img_w.'x'.$img_h.'</dd>
								<dt>'.getMessage('real_size').':</dt>
									<dd>'.$mida_real[0].'x'.$mida_real[1].'</dd>';
									if ($img_w && $img_h) {
										if ($img_w!=$mida_real[0] || $img_h!=$mida_real[1]) {
											$ret.='<dd class="mida_ko">'.$mida_real[0].'x'.$mida_real[1].'</dd>';
										}
										else $ret.='<dd class="real">'.$mida_real[0].'x'.$mida_real[1].'</dd>';
									}
							$ret.='</dl>
						</div>';
					$ret.='</div>';
				}
			}
			if ($p_mode=='V') {
				if (!empty($trueValue)) {
					$ret.= '<span class="label">'.$trueValue.'</span>';

					$mida_real=explode('.',$valor_simple['atrib_values'][0]['img_info']);
					$mides=explode('(',$row['caption']);
                    $ret.= ' <div class="photo wrap">';
						if ($mida_real[0]>=$mida_real[1]) $ret .= '<img alt="" src="'.URL_APPLICATION.$trueValue.'" />';
						else $ret.= '<img alt="" src="'.URL_APPLICATION.$trueValue.'"/>';

						$ret.='<div>
							<dl>
								<dt>'.getMessage('theoric_size').':</dt>
									<dd>'.$img_w.'x'.$img_h.'</dd>
								<dt>'.getMessage('real_size').':</dt>
									<dd>'.$mida_real[0].'x'.$mida_real[1].'</dd>';
									if ($img_w && $img_h) {
										if ($img_w!=$mida_real[0] || $img_h!=$mida_real[1]) {
											$ret.='<dd class="mida_ko">'.$mida_real[0].'x'.$mida_real[1].'</dd>';
										}
										else $ret.='<dd class="real">'.$mida_real[0].'x'.$mida_real[1].'</dd>';
									}
							$ret.='</dl>
						</div>';
					$ret.='</div>';
				}
			}
		}
		elseif ($row['type']=="F") { // File
			if ($p_mode=='I') {
				if (UPLOAD_TYPE=='flash') {
					$ret.= '<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" id="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'" />
					<a href="javascript:uploadFile(\''.$row['id'].'\',\''.$prefix.$row['id'].$postfix.'\',\''.date('Ymd').'/\',\''.$p_inst_id.'\',\''.$img_w.'\',\''.$img_h.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>';
				}
				else {
					$ret.= '<input class="w_200 float_left" tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'" />
					<a class="ico clip" href="javascript:show_upload(\'Form1.'.$prefix.$row['id'].$postfix.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>';
				}
			}
			if ($p_mode=='U') {
				if (UPLOAD_TYPE=='flash') {
					$ret.= '<input tabindex="'.$i.'" type="text" name="'.$prefix.$row['id'].$postfix.'" id="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'"/>
					<a href="javascript:uploadFile(\''.$row['id'].'\',\''.$prefix.$row['id'].$postfix.'\',\''.date('Ymd').'/\',\''.$p_inst_id.'\',\''.$img_w.'\',\''.$img_h.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>';
				}
				else {
					$ret.= '<input class="w_200 float_left" tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'"/>
					<a class="ico clip" href="javascript:show_upload(\'Form1.'.$prefix.$row['id'].$postfix.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>';
				}
			}
			if ($p_mode=='V') {
				if ($trueValue!='' && (!strpos($trueValue,'http://') && !strpos($trueValue,'www'))) {
					$ret.= '<span class="label">'.URL_APPLICATION.$trueValue.'</span>';
				}
				else {
					$ret.= '<span class="label">'.$trueValue.'</span>';
				}
			}
		}
		elseif ($row['type']=="G") {// Flash File
			if ($p_mode=='I') {
				if (UPLOAD_TYPE=='flash') {
					$ret.= '<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" id="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'" />
					<a href="javascript:uploadFile(\''.$row['id'].'\',\''.$prefix.$row['id'].$postfix.'\',\''.date('Ymd').'/\',\''.$p_inst_id.'\',\''.$img_w.'\',\''.$img_h.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>';
				}
				else {
					$ret.= '<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$trueValue.'" /></span>&nbsp;
					<a class="ico clip" href="javascript:show_upload(\'Form1.'.$prefix.$row['id'].$postfix.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>';
				}
			}
			if ($p_mode=='U') {
				if (UPLOAD_TYPE=='flash') {
					$ret .= '<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" id="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'"/>
					<a href="javascript:uploadFile(\''.$row['id'].'\',\''.$prefix.$row['id'].$postfix.'\',\''.date('Ymd').'/\',\''.$p_inst_id.'\',\''.$img_w.'\',\''.$img_h.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>';
				}
				else {
					$ret.= '<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueValue.'"/>
					<a class="ico clip" href="javascript:show_upload(\'Form1.'.$prefix.$row['id'].$postfix.'\');"><!--img class="icon" src="'.ICONO_UPLOAD.'" border="0" title="Seleccionar archivo"--></a>';
				}
			}
			if ($p_mode=='V') {
				if (isset($valor_simple['atrib_values'][0]['text_val'])) {
					$ret.= '<span class="label">'.$trueValue.'</span>';
					$ret.= '<embed src="'.URL_APPLICATION.$trueValue.'" quality="high" width="100" height="100"></embed>';
				}
			}
		}
		elseif ($row['type']=="M") {
			$googlemaps=true;
			// Geoposicionament amb google Maps
			if ($p_mode=='I') {
				$ret.= '<input tabindex="'.$i.'" type="text" id="cerca_posicio" size="40"/>
				<br />
				<input type="text" disabled="disabled" id="latitud" value=""/> <input type="text" disabled="disabled" id="longitud" value=""/>
				<input type="hidden" name="'.$prefix.$row['id'].$postfix.'" value="" id="position_lat_long"/>
				<p class="btn"><input type="button" value="Buscar" onclick="recalc_gmaps();"/></p>
                                <div id="map_canvas" style="width:310px;height:220px;margin-top:15px;"></div>';
				$ret.= '<script type="text/javascript">
					$(document).ready(function(){
						posicionar(41.387917, 2.1699187);
					});
				</script>';
			}
			if ($p_mode=='U') {
				$pos2=explode("@",$trueValue);
				$pos=explode(":",$pos2[0]);
				$ret .= '<input tabindex="'.$i.'" type="text" id="cerca_posicio" value="'.$pos2[1].'"/ size="40">
				<br />
				<input type="text" disabled="disabled" id="latitud" value="'.$pos[0].'" size="20" style="float:left; margin-right:5px;"/>
                                <input type="text" disabled="disabled" id="longitud" value="'.$pos[1].'" size="20" style="float:left;"/>
				<p class="btn"><input type="button" value="Buscar" onclick="recalc_gmaps();"/></p>
				<div id="map_canvas" style="width:310px;height:220px;margin-top:15px;"></div>
				<input type="hidden" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueCleanedValue.'" id="position_lat_long"/>';
				$ret .= '<script type="text/javascript">
					$(document).ready(function(){
						posicionar('.$pos[0].', '.$pos[1].');
					});
				</script>';
			}
			if ($p_mode=='V') {
				$pos2=explode("@",$trueValue);
				$pos=explode(":",$pos2[0]);
				$ret.= '<p>('.$pos[0].' , '.$pos[1].')';
				if($pos2[1]!="") $ret .= ' @ '.$pos2[1];
				$ret.= '</p><div id="map_canvas" style="width:310px;height:220px;margin-top:15px;"></div>';
				$ret.= '<script type="text/javascript">
					$(document).ready(function(){
						posicionar('.$pos[0].', '.$pos[1].');
					});
				</script>';
			}
		}
		elseif ($row['type']=="U") { // URL
			if ($p_mode=='I') {
				$ret .= '<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueCleanedValue.'" />';
			}
			if ($p_mode=='U') {
				$ret .= '<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueCleanedValue.'"/>';
			}
			if ($p_mode=='V') {
                                if ($trueCleanedValue!='' && strpos($trueCleanedValue,'http://')!==false && strpos($trueCleanedValue,'www')!==false) {
					$ret.= '<span class="label"><a title="'.$trueCleanedValue.'" href="'.$trueCleanedValue.'" target="_blank">'.$trueCleanedValue.'</a></span>';
				}
				else {
					$ret.= '<span class="label"><a title="'.URL_APPLICATION.$trueCleanedValue.'" href="'.URL_APPLICATION.$trueCleanedValue.'" target="_blank">'.URL_APPLICATION.$trueCleanedValue.'</a></span>';
				}
			}
		}
		elseif ($row['type']=="X") { // XML
			$max_width=TEXTAREA_DEFAULT_LENGTH;
			if ($p_mode=='I') {
				$ret .= '<textarea tabindex="'.$i.'" cols="'.$max_width.'" rows="'.$max_height.'" name="'.$prefix.$row['id'].$postfix.'">'.$trueCleanedValue.'</textarea>';
			}
			if ($p_mode=='U') {
				$ret .= '<textarea tabindex="'.$i.'" cols="'.$max_width.'" rows="'.$max_height.'" name="'.$prefix.$row['id'].$postfix.'">'.$trueCleanedValue.'</textarea>';
			}
			if ($p_mode=='V') {
				$ret.='<span class="label">'.$trueCleanedValue.'</span>';
			}
		}
		elseif ($row['type']=="D") { // DATE
			if ($p_mode=='I') {
				$ret.='<input tabindex="'.$i.'" type="text" size="30" name="'.$prefix.$row['id'].$postfix.'" class="date3 datepicker" value="'.$trueDateValue.'" />';
			}
			if ($p_mode=='U') {
				$ret.='<input tabindex="'.$i.'" type="text" size="30" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueDateValue.'" class="date3 datepicker"/>';
			}
			if ($p_mode=='V') {
				$ret.='<span class="label">'.$trueDateValue.'</span>';
			}
		}
		elseif ($row['type']=="N") {// Numeric
			if ($p_mode=='I') {
				$ret.='<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueNumValue.'" />';
			}
			if ($p_mode=='U') {
				$ret.='<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$trueNumValue.'"/>';
			}
			if ($p_mode=='V') {
				$ret.='<span class="label">'.$trueNumValue.'</span>';
			}
		}
		elseif ($row['type']=="R") { // RELATION
			if ($p_mode=='V') {
				$ret .= '<div class="col_item alert list alert_right hidden">
				            <span></span>
				            <div><p></p></div>
				            <p class="btn_close"><a title="Tancar" class="close">Tancar</a></p>
				        </div>';
				$ret.='<div class="tbl_rel tbl_items" id="divrel'.$row['id'].'" inst_id="'.$p_inst_id.'">';
					$ret.='<table cellspacing="0" cellpadding="0" border="0" width="95%">';
						if (count($row['related_instances']['instances'])>1 && $row['related_instances']['info']['order_type']=='M') $ret.='<col class="w_70">';
						$ret.='<col class="w_20">
						<col class="w_20">
						<col>
						<col class="w_25">
						<col class="w_25">
						<thead>
							<tr class="thead">';
								if (count($row['related_instances']['instances'])>1 && $row['related_instances']['info']['order_type']=='M') $ret.='<th scope="col"><span>Moure ítem</span></th>';
								$ret.='<th scope="col"><span>Estat</span></th>
								<th scope="col"><span>Identificador</span></th>
								<th scope="col"><span>Títol</span></th>
								<th scope="col"><span>Editar</span></th>
								<th scope="col"><span>Esborrar</span></th>
							</tr>
						</thead>
						<tbody id="tabrel'.$row['id'].'">';
							$ret.=$this->getRelationInstances($row['related_instances'], $p_inst_id, 1000, $tab_id, $row['id']);
						$ret.='</tbody>
					</table>
				</div>';
			}
		}
		elseif ($row['type']=="L") { // LOOKUP
			$ret.=$this->getAttributeLookup($row, isset($valor_simple['atrib_values'][0]['num_val']) ? $valor_simple['atrib_values'][0]['num_val'] : '' , $prefix, $postfix, $p_mode, $p_inst_id, $i, $row['description']);
		}
		elseif ($row['type']=="Z") {// String d'una linea
			if ($p_mode=='I') {
				$ret.='<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$urlnice.'" />';
			}
			elseif($p_mode=='U') {
				$urlnice=$row['niceurl'];
				$ret .= '<input tabindex="'.$i.'" type="text" size="'.$max_width.'" name="'.$prefix.$row['id'].$postfix.'" value="'.$urlnice.'"/>';
			}
			elseif($p_mode=='V') {
				$urlnice=$row['niceurl'];
				$ret.='<p class="string_text">'.$urlnice.'</p>';
				if (isset($urlnice) && $urlnice!='') $ret.='<ul class="icos_list float_left"><li class="ico prev"><a title="Previsualizar" href="/'.$row['language'].'/'.$urlnice.'?req_info=1" target="_blank">Previsualizar</a></li></ul>';
			}
		}
                if ($row['type']=="W") {// Type APP

                        if ($p_mode=='I') {
				$ret.='<input tabindex="'.$i.'" type="text" id="store_url" class="w_200 float_left" name="'.$prefix.$row['id'].$postfix.'" /> ';
                                $ret.="<a class='ico lupa' href='javascript://' onclick='Appbrowser(\"".$prefix.$row['id'].$postfix."\");'></a>";

			}elseif($p_mode=='U') {

                                if(json_decode($valor_simple['atrib_values'][0]['text_val']) != null){
                                    $appdata = json_decode($valor_simple['atrib_values'][0]['text_val']);
                                     if(!empty($appdata->General[0])):
                                             $appURL = $appdata->General[0]->app_store_url;
                                     else:
                                            $appURL = $appdata->trackViewUrl;
                                     endif;
                                }

                                $ret.='<input tabindex="'.$i.'" type="text" id="store_url" class="w_200 float_left" name="'.$prefix.$row['id'].$postfix.'" value="'.$appURL.'"/> ';
                                $ret.="<a class='ico lupa' href='javascript://' onclick='Appbrowser(\"".$prefix.$row['id'].$postfix."\");'></a>";

                            
                        }elseif($p_mode=='V') {
                                   
                                   if(json_decode($valor_simple['atrib_values'][0]['text_val']) != null){
                                                  $appdata = json_decode($valor_simple['atrib_values'][0]['text_val']);

                                                  

                                                  //---- App from google play ---
                                                  if(!empty($appdata->General[0])):                                                       

                                                            $ret.='<span class="label">'.$appdata->General[0]->app_store_url.'</span>';
                                                            $ret.= '<div class="thumbnail">
                                                                      <img  class="imgAppdesc"  src="'.$appdata->General[0]->banner_icon.'">
                                                                      <div class="caption">
                                                                        <h3>'.$appdata->General[0]->app_title.'</h3>                                                                       
                                                                      </div>
                                                                    </div>';
                                                  
                                                  //---- App form iTunes
                                                  else:
                                                           $ret.='<span class="label">'.$appdata->trackViewUrl.'</span>';
                                                           $ret.= '<div class="thumbnail">
                                                                      <img class="imgAppdesc" style="width: 60px; float:left; margin-bottom: 10px; margin-right: 20px;" src="'.$appdata->artworkUrl512.'">
                                                                      <div class="caption">
                                                                        <h3>'.$appdata->trackName.'</h3>                                                                       
                                                                      </div>
                                                                    </div>';
                                                  endif;

                                      }else{
                                          print_r(json_last_error());
                                          echo "format ERROR";
                                      }
                                
                        }




		}



		$ret.='<div class="clear"></div>';

		return $ret;
	}

	private function getTrueValue($value = null, $clean = null) {
		if (isset($_REQUEST[$prefix.$row['id'].$postfix])) $value=$_REQUEST[$prefix.$row['id'].$postfix];
		if ($clean) {
			$value=str_replace("\"", "&#34;", $value);
			$value=str_replace(">", "&#62;", $value);
			$value=str_replace("<", "&#60;", $value);
		}

		return $value;
	}


	private function getAttributeLookup($p_row, $p_valor, $p_prefix, $p_postfix, $p_mode, $p_inst_id, $i, $desc) {
		$ret="";

		if ($p_mode=='V') { // Mode view, no necessitem tots els valors possibles, nomes els que estan informats
			foreach ($p_row['lookup_info']['selected_values'] as $r) {
				if (isset($r)) {
					$ret.='<input type="text" class="w_180 disabled" readonly="readonly" disabled="disabled" value="'.$r['label'].'" size="20" id="" name="">';
					//$ret.='<span class="omp_field">'.$r['label'].'</span><br />';
					$valors[]=$r['id'];
				}
			}
			return $ret;
		}
		else { // Mode insert o update
			//$ret=$this->getDescription($p_row);
			//$ret.="<br />";
			$lg = $_SESSION['u_lang'];

			$lookup_rows = $p_row['lookup_info'];
			if ($lookup_rows['info']['type']=="L") {
				$ret.='<select tabindex="'.$i.'" class="omp_field" name="'.$p_prefix.$p_row['id'].$p_postfix.'">';
				//$ret .= '<option class="omp_field" value="">&nbsp;</option>';

				$default=0;
				foreach ($lookup_rows['lookup_all_values'] as $row) {
					if ($p_mode=='I') {
						if (isset ($_REQUEST[$p_prefix.$p_row['id'].$p_postfix]) && $_REQUEST[$p_prefix.$p_row['id'].$p_postfix]==$row['lookup_value_id']) $ret .= '<option class="omp_field" value="'.$row['lookup_value_id'].'" selected="selected">'.$row['label'].'</option>';
						elseif ($lookup_rows['info']['default_id']==$row['lookup_value_id']) $ret.='<option class="omp_field" value="'.$row['lookup_value_id'].'" selected="selected">'.$row['label'].'</option>';
						else $ret .= '<option class="omp_field" value="'.$row['lookup_value_id'].'">'.$row['label'].'</option>';
					}
					if ($p_mode=='U') {
						if (isset ($_REQUEST[$p_prefix.$p_row['id'].$p_postfix]) && $_REQUEST[$p_prefix.$p_row['id'].$p_postfix]==$row['lookup_value_id']) $ret .= '<option class="omp_field" value="'.$row['lookup_value_id'].'" selected="selected">'.$row['label'].'</option>';
						elseif ($p_valor==$row['lookup_value_id'] && !isset ($_REQUEST[$p_prefix.$p_row['id'].$p_postfix])) $ret .= '<option class="omp_field" value="'.$row['lookup_value_id'].'" selected="selected">'.$row['label'].'</option>';
						elseif ($lookup_rows['info']['default_id']==$row['lookup_value_id'] && !isset ($_REQUEST[$p_prefix.$p_row['id'].$p_postfix]) && (!isset($p_valor) || $p_valor=='')) $ret .= '<option class="omp_field" value="'.$row['lookup_value_id'].'" selected="selected">'.$row['label'].'</option>';
						else $ret.= '<option class="omp_field" value="'.$row['lookup_value_id'].'">'.$row['label'].'</option>';
					}
				}
				$ret.='</select>';
			}
			if ($lookup_rows['info']['type']=="R") {
				foreach ($lookup_rows['lookup_all_values'] as $row)
				{
					if ($p_mode=='I') {
						if (isset ($_REQUEST[$p_prefix.$p_row['id'].$p_postfix]) && $_REQUEST[$p_prefix.$p_row['id'].$p_postfix]==$row['lookup_value_id']) $ret .= '<input type="radio" name="'.$p_prefix.$p_row['id'].$p_postfix.'" value="'.$row['lookup_value_id'].'" checked="checked"/><span class="omp_field">'.$row['label'].'</span><br />';
							else $ret .= '<input tabindex="'.$i.'" type="radio" name="'.$p_prefix.$p_row['id'].$p_postfix.'" value="'.$row['lookup_value_id'].'"/><span class="omp_field">'.$row['label'].'</span><br />';
					}
					if ($p_mode=='U') {
						if (isset ($_REQUEST[$p_prefix.$p_row['id'].$p_postfix]) && $_REQUEST[$p_prefix.$p_row['id'].$p_postfix]==$row['lookup_value_id']) $ret .= '<input type="radio" name="'.$p_prefix.$p_row['id'].$p_postfix.'" value="'.$row['lookup_value_id'].'" checked="checked"/><span class="omp_field">'.$row['label'].'</span><br />';
							//elseif (isset($valors) && in_array($row['lookup_value_id'], $valors) && !isset($_REQUEST['enviat'])) $ret .= '<input type="radio" name="'.$p_prefix.$p_row['id'].$p_postfix.'" value="'.$row['lookup_value_id'].'" checked="checked"/><span class="omp_field">'.$row['label'].'</span><br />';
							elseif (isset($valors) && in_array($row['lookup_value_id'], $valors)) $ret .= '<input type="radio" name="'.$p_prefix.$p_row['id'].$p_postfix.'" value="'.$row['lookup_value_id'].'" checked="checked"/><span class="omp_field">'.$row['label'].'</span><br />';
							elseif ($lookup_rows['info']['default_id']==$row['lookup_value_id'] && !isset ($_REQUEST[$p_prefix.$p_row['id'].$p_postfix])) $ret .= '<input type="radio" name="'.$p_prefix.$p_row['id'].$p_postfix.'" value="'.$row['lookup_value_id'].'" checked="checked"/><span class="omp_field">'.$row['label'].'</span><br />';
							else $ret .= '<input type="radio" name="'.$p_prefix.$p_row['id'].$p_postfix.'" value="'.$row['lookup_value_id'].'"/><span class="omp_field">'.$row['label'].'</span><br />';
					}
				}
			}
			if ($lookup_rows['info']['type']=="C") {
				foreach ($lookup_rows['lookup_all_values'] as $row)
				{

					if ($p_mode=='I') {
						$ret .= '<input tabindex="'.$i.'" type="checkbox" name="'.$p_prefix.$p_row['id'].$p_postfix.'[]" value="'.$row['lookup_value_id'].'"/><span class="omp_field">'.$row['label'].'</span><br />';
					}
					if ($p_mode=='U') {
						if (isset ($_REQUEST[$p_prefix.$p_row['id'].$p_postfix]) && $_REQUEST[$p_prefix.$p_row['id'].$p_postfix]==$row['lookup_value_id']) {
							$ret .= '<br />';
							$ret .= '<input type="checkbox" name="'.$p_prefix.$p_row['id'].$p_postfix.'[]" value="'.$row['lookup_value_id'].'" checked="checked"/><span class="omp_field">'.$row['label'].'</span><br />';
						}
						//elseif (isset($valors) && in_array($row['lookup_value_id'], $valors) && !isset($_REQUEST['enviat'])) {
						elseif (isset($valors) && in_array($row['lookup_value_id'], $valors)) {
							$ret .= '<br />';
							$ret .= '<input type="checkbox" name="'.$p_prefix.$p_row['id'].$p_postfix.'[]" value="'.$row['lookup_value_id'].'" checked="checked"/><span class="omp_field">'.$row['label'].'</span><br />';
						}
						elseif ($lookup_rows['info']['default_id']==$row['lookup_value_id'] && (!isset ($_REQUEST[$p_prefix.$p_row['id'].$p_postfix])))
						{
							$ret .= '<br />';
							$ret .= '<input type="checkbox" name="'.$p_prefix.$p_row['id'].$p_postfix.'[]" value="'.$row['lookup_value_id'].'" checked="checked"/><span class="omp_field">'.$row['label'].'</span><br />';
						}

						else {
							$ret .= '<br />';
							$ret .= '<input type="checkbox" name="'.$p_prefix.$p_row['id'].$p_postfix.'[]" value="'.$row['lookup_value_id'].'"/><span class="omp_field">'.$row['label'].'</span><br />';
						}
					}
				}
			}
			//$ret.=$this->getDescription($row);

			return $ret;
		}
	}


	public function getRelationInstances($p_row, $p_parent_inst_id, $num=1000, $tab='', $rel_id='') {
		if (!isset($p_row['instances']) || (!is_array($p_row['instances']))) return '';

		$num_rows = count($p_row['instances']);
		$order_type = $p_row['info']['order_type'];
		$current_row = 0;
		$res="";

		foreach($p_row['instances'] as $row) {
			$res.='<tr id="'.$row['inst_id'].'">';
				if (count($p_row['instances'])>1 && $p_row['info']['order_type']=='M') {
					$res.='<td class="move_item">';
						$res.='<ul class="sortableitem" id="relid'.($row["id"]+1).'">';
							if ($order_type=='M') {//Pintem les fletxetes d'ordenacio manual
								if ($current_row==0) { //Es el primer
									$res.='<li class="mov_begin"><span>'.getMessage('info_word_ordertop').'</span></li>';
									$res.='<li class="mov_final"><a title="'.getMessage('info_word_orderbottom').'" href="'.APP_BASE.'/order_down_bottom/?p_pagina=1&amp;p_relation_id='.$row['id'].'&amp;p_parent_inst_id='.$p_parent_inst_id.'&amp;p_parent_class_id='.$row['parent_class_id'].'&amp;p_tab='.$tab.'">'.getMessage('info_word_orderbottom').'</a></li>';
									$res.='<li class="mov_up sep"><span>'.getMessage('info_word_orderup').'</span></li>';
									$res.='<li class="mov_down"><a title="'.getMessage('info_word_orderdown').'" href="'.APP_BASE.'/order_down/?p_pagina=1&amp;p_relation_id='.$row['id'].'&amp;p_parent_inst_id='.$p_parent_inst_id.'&amp;p_parent_class_id='.$row['parent_class_id'].'&amp;p_tab='.$tab.'">'.getMessage('info_word_orderdown').'</a></li>';
								}
								else {
									if($current_row==($num_rows-1)) { // Es l'ultim
										$res.='<li class="mov_begin"><a href="'.APP_BASE.'/order_up_top/?p_pagina=1&amp;p_relation_id='.$row['id'].'&amp;p_parent_inst_id='.$p_parent_inst_id.'&amp;p_parent_class_id='.$row['parent_class_id'].'&amp;p_tab='.$tab.'" title="'.getMessage('info_word_ordertop').'">'.getMessage('info_word_ordertop').'</a></li>';
										$res.='<li class="mov_final"><span>'.getMessage('info_word_orderbottom').'</span></li>';
										$res.='<li class="mov_up sep"><a title="'.getMessage('info_word_orderup').'" href="'.APP_BASE.'/order_up/?p_pagina=1&amp;p_relation_id='.$row['id'].'&amp;p_parent_inst_id='.$p_parent_inst_id.'&amp;p_parent_class_id='.$row['parent_class_id'].'&amp;p_tab='.$tab.'">'.getMessage('info_word_orderup').'</a></li>';
										$res.='<li class="mov_down"><span>'.getMessage('info_word_orderdown').'</span></li>';
									}
									else { // Cas normal, element que no es el primer ni l'ultim
										$res.='<li class="mov_begin"><a href="'.APP_BASE.'/order_up_top/?p_pagina=1&amp;p_relation_id='.$row['id'].'&amp;p_parent_inst_id='.$p_parent_inst_id.'&amp;p_parent_class_id='.$row['parent_class_id'].'&amp;p_tab='.$tab.'" title="'.getMessage('info_word_ordertop').'">'.getMessage('info_word_ordertop').'</a></li>';
										$res.='<li class="mov_final"><a title="'.getMessage('info_word_orderbottom').'" href="'.APP_BASE.'/order_down_bottom/?p_pagina=1&amp;p_relation_id='.$row['id'].'&amp;p_parent_inst_id='.$p_parent_inst_id.'&amp;p_parent_class_id='.$row['parent_class_id'].'&amp;p_tab='.$tab.'">'.getMessage('info_word_orderbottom').'</a></li>';
										$res.='<li class="mov_up sep"><a title="'.getMessage('info_word_orderup').'" href="'.APP_BASE.'/order_up/?p_pagina=1&amp;p_relation_id='.$row['id'].'&amp;p_parent_inst_id='.$p_parent_inst_id.'&amp;p_parent_class_id='.$row['parent_class_id'].'&amp;p_tab='.$tab.'">'.getMessage('info_word_orderup').'</a></li>';
										$res.='<li class="mov_down"><a title="'.getMessage('info_word_orderdown').'" href="'.APP_BASE.'/order_down/?p_pagina=1&amp;p_relation_id='.$row['id'].'&amp;p_parent_inst_id='.$p_parent_inst_id.'&amp;p_parent_class_id='.$row['parent_class_id'].'&amp;p_tab='.$tab.'">'.getMessage('info_word_orderdown').'</a></li>';
									}
								}
							}
						$res.='</ul>
					</td>';
				}
                $res.='<td>';
				$res.=parent::status_to_html($row['status']);
				$res.='</td>';
				$res.='<th scope="row"><strong>'.$row['inst_id'].'</strong></th>';
				$res.='<td class="instance"><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_class_id='.$row['child_class_id'].'&amp;p_inst_id='.$row['inst_id'].'" title="Ver">'.$row['key_fields'].'</a></td>';
				$res.='<td class="ico del"><a class="reldelete" href="'.APP_BASE.'/delete_relation_instance/?p_pagina=1&amp;p_relation_id='.$row['id'].'&amp;p_class_id='.$row['parent_class_id'].'&amp;p_inst_id='.$p_parent_inst_id.'&amp;p_tab='.$tab.'&amp;p_rel_id='.$rel_id.'" title="'.getMessage('info_word_unjoin').'">'.getMessage('info_word_unjoin').'</a></td>';
				$res.='<td class="ico edi"><a href="'.APP_BASE.'/edit_instance/?p_pagina=1&amp;p_class_id='.$row['child_class_id'].'&amp;p_inst_id='.$row['inst_id'].'" title="'.getMessage('info_word_edit').'">'.getMessage('info_word_edit').'</a></td>';
			$res.='</tr>';
			$current_row++;
		}

		return $res;
	}

	private function getDescription($row) {
		$ret = "";
        /* PINTA LA DIV AMB INFO PELS DESENVOLUPADORS */
		if ($_SESSION['user_type']=='O') {
			if ($row['type']=="R") {       //Informació del usuari OMATECH
				$ret='<li class="ico info_admin"><span class="info_alert alert_admin"><a href="#">Informació</a> <span class="info_bubble"><span class="arrow"></span><span class="text">ID-> '.$row["id"].'<br/>Type-> '.$row['type'].'<br/>Tag-> '.$row["tag"].'<br/>Name-> '.$row["name"].'<br/>Lang-> '.$row["language"].'<br/>Detail-> '.$row['cadetail'].'</span></span></span></li>';
			}
			else {
				if ($row['type']=='I') $ret='<li class="ico info_admin"><span class="info_alert alert_admin"><a href="#">Informació</a> <span class="info_bubble"><span class="arrow"></span><span class="text">ID-> '.$row["id"].'<br/>Type-> '.$row['type'].'<br/>Tag-> '.$row["tag"].'<br/>Lang-> '.$row["language"].'<br/>Detail-> '.$row['cadetail'].'<br/>Width-> '.$row["ai_width"].'<br/>Height-> '.$row["ai_height"].'</span></span></span></li>';
				else $ret='<li class="ico info_admin"><span class="info_alert alert_admin"><a href="#">Informació</a> <span class="info_bubble"><span class="arrow"></span><span class="text">ID-> '.$row["id"].'<br/>Type-> '.$row['type'].'<br/>Tag-> '.$row["tag"].'<br/>Lang-> '.$row["language"].'<br/>Detail-> '.$row['cadetail'].'</span></span></span></li>';
			}

			/*
			$ret.='<br/>Desc-> '.$row["caption"];
			$ret.='</div>';
                        */
		}
		/* FI PINTA LA DIV AMB INFO PELS DESENVOLUPADORS */

		/* PINTA LA DIV AMB INFO PELS USUSARIS */
		if (isset($row['description']) && $row['description']!='') {
			$ret.='<li class="ico info"><span class="info_alert alert_user"><a href="#">Información</a> <span class="info_bubble"><span class="arrow"></span><span class="text">'.nl2br($row['description']).'</span></span></span></li>';
		}
        /* FI PINTA LA DIV AMB INFO PELS USUSARIS */
		return $ret;
	}

	private function has_rec_cloner($p_class_id) {
		$sql = 'SELECT recursive_clone from omp_classes where id='.$p_class_id;
		$dbh=get_db_handler();
		$ret = mysql_query($sql, $dbh);

		if($ret){
			$row = mysql_fetch_array($ret, MYSQL_ASSOC);
			if($row['recursive_clone'] == 'Y')
				return true;
			else
				return false;
		}
	}
}
?>