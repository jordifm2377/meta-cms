<?php
//à
require_once(DIR_APLI_ADMIN.'/templates/template.php');

class instances_template extends template
{
	function __construct()
	{
		return;
	}

	private function getActionTitle($p_search_query, $p_class_id, $p_fecha_ini, $p_fecha_fin)
	{ //AKI FALTEN TRADUCCIONS !!!
		$ins_title='';
		if ($p_class_id)
			$ins_title.=' (de tipo '.getClassName($p_class_id).')';

		if ($p_fecha_ini)
			$ins_title.=' (creado des de '.$p_fecha_ini.')';

		if ($p_fecha_fin)
			$ins_title.=' (creado hasta '.$p_fecha_fin.')';

		if ($p_search_query)
		{
			if (is_numeric($p_search_query))
				$ins_title.=' (buscando el ID "'.$p_search_query.'")';
			else
				$ins_title.=' (buscando el texto "'.$p_search_query.'")';
		}

		return $ins_title;
	}

	private function instancesList($inst_arr, $inst_count, $p_action, $p_search_query, $p_class_id, $p_fecha_ini, $p_fecha_fin, $p_pagina, $p_order_by, $p_search_state, $p_mode, $p_relation_id, $p_parent_inst_id, $p_parent_class_id, $p_child_class_id) {
		$res='';
		$ins_title=$this->getActionTitle($p_search_query, $p_class_id, $p_fecha_ini, $p_fecha_fin);

		if(isset($_REQUEST['tab'])) $tab = $_REQUEST['tab'];
		else $tab = '';

		//$res.='<div id="titol_taula">'.getMessage('info_objects_found').' '.$ins_title.':</div>';
		if ($p_mode=='R') {
			$res.='<div class="col_item searcher searcher_height visible">';
				$res.='<form class="form" method="post" enctype="multipart/form-data" name="Form_search_inner" action="'.APP_BASE.'/'.$p_action.'">
				<fieldset class="adv_search">
					<legend>Buscador</legend>
					<span class="split"></span>
					<div class="visible">
						<div class="p">
							<p>
								<label for="p_search_query">'.getMessage('info_word_text').':</label>
								<input type="text" name="p_search_query" size="16" value="'.$p_search_query.'"/>
							</p>
						</div>
						<div class="p">
							<p>
								<label for="">'.getMessage('info_word_initial_date').'</label>
								<input type="text" name="p_fecha_ini" size="10" value="'.$p_fecha_ini.'" class="inputcerca" id="date_s1"/>
							</p>
						</div>
						<div class="p">
							<p>
								<label for="date_s2">'.getMessage('info_word_final_date').'</label>
								<input type="text" name="p_fecha_fin" size="10" value="'.$p_fecha_fin.'" class="inputcerca" id="date_s2"/>
							</p>
						</div>
					 </div>
				</fieldset>
				<p class="btn btn2"><input type="submit" value="'.getMessage('info_word_search_button').'" title="'.getMessage('info_word_search_button').'" /></p>';

				$res.='<input type="hidden" name="p_pagina" value="1"/>
				<input type="hidden" name="p_class_id" value="'.$p_class_id.'"/>
				<input type="hidden" name="p_relation_id" value="'.$p_relation_id.'"/>
				<input type="hidden" name="p_inst_id" value="'.$p_parent_inst_id.'"/>
				<input type="hidden" name="p_parent_inst_id" value="'.$p_parent_inst_id.'"/>
				<input type="hidden" name="p_parent_class_id" value="'.$p_parent_class_id.'"/>
				<input type="hidden" name="p_child_class_id" value="'.$p_child_class_id.'"/>
				<input type="hidden" name="p_tab" value="'.$tab.'"/>
				</form>
			</div>';
		}

		//$res.='<div id="lasupertabla">';
		if ($p_mode=='R') {
			$res.=' <form class="form" id="relation_all" name="relation_all" method="post" enctype="multipart/form-data" action="'.APP_BASE.'/join_all">
				<input type="hidden" name="p_pagina" value="1"/>
				<input type="hidden" name="p_class_id" value="'.$p_class_id.'"/>
				<input type="hidden" name="p_relation_id" value="'.$p_relation_id.'"/>
				<input type="hidden" name="p_inst_id" value="'.$p_parent_inst_id.'"/>
				<input type="hidden" name="p_parent_inst_id" value="'.$p_parent_inst_id.'"/>
				<input type="hidden" name="p_parent_class_id" value="'.$p_parent_class_id.'"/>
				<input type="hidden" name="p_multiple" value="1"/>
				<input type="hidden" name="p_tab" value="'.$tab.'"/>';
		}
		else {
			$res.=' <form class="form" id="delete_all" name="delete_all" method="post" enctype="multipart/form-data" action="'.APP_BASE.'/delete_all">
				<input type="hidden" name="p_pagina" value="1"/>
				<input type="hidden" name="p_class_id" value="'.$p_class_id.'"/>
				<input type="hidden" name="p_relation_id" value="'.$p_relation_id.'"/>
				<input type="hidden" name="p_parent_inst_id" value="'.$p_parent_inst_id.'"/>
				<input type="hidden" name="p_inst_id" value="'.$p_parent_inst_id.'"/>
				<input type="hidden" name="p_parent_class_id" value="'.$p_parent_class_id.'"/>
				<input type="hidden" name="p_multiple" value="1"/>
				<input type="hidden" name="p_tab" value="'.$tab.'"/>';
		}
		$res.='<div class="col_item tbl_objects">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tabla-objects">
				<colgroup>
					<col class="w_30" />
					<col class="w_30" />
					<col class="" />
					<col class="" />
					<col class="" />
					<col class="w_80" />
					<col class="w_170" />
					<col class="w_110" />
				</colgroup>';
				$res.='<!-- CAPÇALERA -->
				<tbody>
					<tr class="thead">';
		$url_ordre='controller.php?p_action='.$p_action.'&p_search_query='.$p_search_query.'&amp;p_class_id='.$p_class_id
		.'&amp;p_relation_id='.$p_relation_id.'&amp;p_inst_id='.$p_parent_inst_id.'&amp;p_parent_inst_id='.$p_parent_inst_id.'&amp;p_parent_class_id='.$p_parent_class_id
		.'&amp;p_child_class_id='.$p_child_class_id.'&p_fecha_ini='.$p_fecha_ini.'&p_fecha_fin='.$p_fecha_fin;
		if ($p_mode=='R')
		{
			$res.='<th scope="col"><input type="checkbox" id="select_all" name="select_all" onclick="select_unselect_del_all()" /></th>

			<th scope="col"><strong><a href="'.order_link($url_ordre,$p_order_by,'id').'" title="'.getMessage('info_word_ID_explanation').'">'.getMessage('info_word_ID').'</label></th>
                        <th scope="col"><strong>Rel</strong></th>
                        <th scope="col"><strong><a href="'.order_link($url_ordre,$p_order_by,'key_fields').'" title="'.getMessage('info_word_keyword_explanation').'">'.getMessage('info_word_keyword').'</a></strong></th>
                        <th scope="col"><strong><a href="'.order_link($url_ordre,$p_order_by,'class_name').'" title="'.getMessage('info_word_type_explanation').'">'.getMessage('info_word_type').'</a></strong></th>
                        <th scope="col" class="center"><strong><a href="'.order_link($url_ordre,$p_order_by,'status').'" title='.getMessage('info_word_status_explanation').'">'.getMessage('info_word_status').'</a></strong></th>
                        <th scope="col"><strong><a href="'.order_link($url_ordre,$p_order_by,'cd_ordre').'" title="'.getMessage('info_word_publishing_begins_explanation').'">'.getMessage('info_word_publishing_begins').'</a></strong></th>
                        <th scope="col"><strong>'.getMessage('acciones').'</strong></th>


			<!--td class="header" align="center" ><strong><a title="'.getMessage('info_word_publishing_creation_date_explanation').'" href="'.order_link($url_ordre,$p_order_by,'cd_ordre').'">'.getMessage('info_word_creation_date').'</a></strong></td-->
			<!--td class="header" width="75">&nbsp;</td-->
			 </tr>
                        <!-- /end CAPÇALERA -->';
		}
		else
		{
                    $res.='<th scope="col"><input type="checkbox" id="select_all" name="select_all" onclick="select_unselect_del_all()" /></th>

			<th scope="col"><strong><a href="'.order_link($url_ordre,$p_order_by,'id').'" title="'.getMessage('info_word_ID_explanation').'">'.getMessage('info_word_ID').'</strong></a></th>
                        <th scope="col"><strong></strong></th>
                        <th scope="col"><strong><a href="'.order_link($url_ordre,$p_order_by,'key_fields').'" title="'.getMessage('info_word_keyword_explanation').'">'.getMessage('info_word_keyword').'</a></strong></th>
                        <th scope="col"><strong><a href="'.order_link($url_ordre,$p_order_by,'class_name').'" title="'.getMessage('info_word_type_explanation').'">'.getMessage('info_word_type').'</a></strong></th>
                        <th scope="col" class="center"><strong><a href="'.order_link($url_ordre,$p_order_by,'status').'" title='.getMessage('info_word_status_explanation').'">'.getMessage('info_word_status').'</a></strong></th>
                        <th scope="col"><strong><a href="'.order_link($url_ordre,$p_order_by,'cd_ordre').'" title="'.getMessage('info_word_publishing_begins_explanation').'">'.getMessage('info_word_creation_date').'</a></strong></th>
                        <th scope="col"><strong>'.getMessage('acciones').'</strong></th>
			 </tr>
                        <!-- /end CAPÇALERA -->';
		}

		$pijama=' class="even"';
		$id_rel=0;
		$id_del=0;
		//while ($Row = mysql_fetch_array($Result, MYSQL_ASSOC)) {
		if (is_array($inst_arr)) {
			foreach ($inst_arr as $Row) {
				$res.='<tr'.$pijama.'>';
				if ($pijama==' class="even"') $pijama=' class="odd"';
				else $pijama=' class="even"';
				if ($p_mode=='R') {
					$res.='<td><input id="rel_chb_'.$id_rel.'" name="rel_chb[]" type="checkbox" value="'.$Row['id'].'" /></td>';
									//$res.='<th scope="row"><label for="del_chb_'.$id_rel.'">'.$Row['id'].'</label></th>';

					$res.='<td class="bold"><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_class_id='.$Row['class_id'].'&amp;p_inst_id='.$Row['id'].'" title="'.getMessage('info_word_view').'"><strong>'.$Row['id'].'</strong></a></td>';
					$res.='<td><ul class="icos_list"><li class="ico link"><a href="'.APP_BASE.'/join2/?p_pagina=1&amp;p_relation_id='.$p_relation_id.'&amp;p_parent_class_id='.$p_parent_class_id.'&amp;p_parent_inst_id='.$p_parent_inst_id.'&amp;p_child_inst_id='.$Row['id'].'&amp;p_tab='.$tab.'" title="'.getMessage('info_word_join').'">Rel</a></li></ul></td>';
									$res.='<td><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_class_id='.$Row['class_id'].'&amp;p_inst_id='.$Row['id'].'" title="'.getMessage('info_word_view').'"><strong>'.$Row['key_fields'].'</strong></a></td>';
					$res.='<td><span>'.$Row['class_name'].'</span></td>';
					$id_rel++;
				}
				else {
					$res.='<td><input id="del_chb_'.$id_del.'" name="del_chb[]" type="checkbox" value="'.$Row['id'].'" /></td>';
					$res.='<th scope="row"><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_class_id='.$Row['class_id'].'&amp;p_inst_id='.$Row['id'].'" title="'.getMessage('info_word_view').'"><strong>'.$Row['id'].'</strong></a></th>';
					$res.='<td></td>';
									$res.='<td><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_class_id='.$Row['class_id'].'&amp;p_inst_id='.$Row['id'].'" title="'.getMessage('info_word_view').'">'.$Row['key_fields'].'</a></td>';
					$res.='<td class="bold"><a href="'.APP_BASE.'/list_instances/?p_pagina=1&amp;p_class_id='.$Row['class_id'].'"><strong>'.$Row['class_name'].'</strong></a></td>';
					$id_del++;
				}


				//$res.='<td>'.parent::status_to_html($Row['status']).'</td>';
				// nou bloc per permetre a l'admin veure l'status de la cache de memcache, apons 20130914
				$cache_add='';

				$res.='<td>'.parent::status_to_html($Row['status']).$cache_add.'</td>';
				// fi nou bloc per permetre a l'admin veure l'status de la cache de memcache, apons 20130914



				//$res.='<td class="omp_listelement" align="center"><strong>'.$Row->attributes_found.'</strong></td>';
				$res.='<!--td>'.$Row['creation_date'].'</td-->
				<td><span>'.$Row['publishing_begins'].'</span></td>';

				$res.='<td class="edi_tit">
										<ul>';
				$res.='         <li class="ico fav"><a href="'.APP_BASE.'/add_favorite/?p_pagina=1&amp;p_class_id='.$Row['class_id'].'&amp;p_inst_id='.$Row['id'].'" title="'.getMessage('info_word_addfavorites').'"/>'.getMessage('info_word_addfavorites').'</a></li>';
				if ($Row['edit']=='Y') $res.='<li class="ico edi"><a href="'.APP_BASE.'/edit_instance/?p_pagina=1&amp;p_class_id='.$Row['class_id'].'&amp;p_inst_id='.$Row['id'].'" title="'.getMessage('info_word_edit').'"/>'.getMessage('info_word_edit').'</a></li>';

				if ($Row['status']!='O' && $Row['deletea']=='Y')
				{

					if($Row['id']<USERINSTANCES && $_SESSION['rol_id']<>SUPERROLID)
						$res.='&nbsp;';
					else
						$res.='<li class="ico del"><a href="'.APP_BASE.'/delete_instance/?p_pagina=1&amp;p_class_id='.$Row['class_id'].'&amp;p_inst_id='.$Row['id'].'" title="'.getMessage('info_word_delete').'"/>'.getMessage('info_word_delete').'</a></li>';

				}
				else
					$res.='&nbsp;';


				if (!INST_PERM) {
					if (getAccess('permisos',$Row['class_id'],$_SESSION['rol_id'])==1) {
						$res.='aaaaaaaaaaaaaaaaaa<a href="controller.php?p_action=view_permisos&amp;p_class_id='.$Row['class_id'].'&amp;p_inst_id='.$Row['id'].'"><img src="'.ICONO_PERM.'" border="0" title="'.getMessage('info_word_modifyperm').'"/></a>&nbsp;';
					}
					else {
						$res.='bbbbbbbbbbbbbbbbbbbbb&nbsp;';
					}
				}
				$res.='</td>

				</tr>';
			}
		}

		$res.='</tbody></table></div><!-- /end TAULA OBJECTES -->';
                $res.='<div class="col_item">';
		if ($p_mode=='R') {
			$res.='
			 <div class="left">
				<input type="hidden" id="num_rel" name="num_rel" value="'.$id_rel.'"/>
				<p class="btn"><input type="submit" value="'.getMessage('relacionar_varis').'" title="'.getMessage('relacionar_varis').'" /></p>
			</div>';
		}
		else {
			$res.='<div class="left">
				<input type="hidden" id="num_del" name="num_del" value="'.$id_del.'"/>
				<p class="btn"><input type="submit" value="'.getMessage('eliminar_varis').'" title="'.getMessage('eliminar_varis').'" /></p>
			</div>';
		}
		//$res.='</div>';

		if ($p_mode=='R') {
			$params_url=generate_url_params($p_search_query,$p_fecha_ini,$p_fecha_fin,$p_order_by,$p_search_state,$p_relation_id,$p_parent_inst_id,$p_parent_class_id,$p_child_class_id);
			$res.=parent::pinta_paginacion($p_pagina, $p_action, '&amp;p_class_id='.$p_class_id.$params_url, count($inst_arr), $inst_count);
		}
		else {
			$params_url=generate_url_params($p_search_query,$p_fecha_ini,$p_fecha_fin,$p_order_by,$p_search_state);
			$res.=parent::pinta_paginacion($p_pagina, $p_action, '&amp;p_class_id='.$p_class_id.$params_url, count($inst_arr), $inst_count);
		}
                $res.='</div></form>';

		return $res;
	}

	function instancesList_relate($inst_arr, $inst_count, $param_arr) {
		return($this->instancesList($inst_arr, $inst_count, $param_arr['p_action'], $param_arr['param4'], $param_arr['param1'], str_replace("-", "/", $param_arr['param5']), str_replace("-", "/", $param_arr['param6']), $param_arr['param3'], $param_arr['param7'], $param_arr['param8'], $param_arr['p_mode'], $param_arr['param9'], $param_arr['param11'], $param_arr['param10'], $param_arr['param12']));
	}

	function instancesList_view($inst_arr, $inst_count, $param_arr) {
		return($this->instancesList($inst_arr, $inst_count, $param_arr['p_action'], $param_arr['param4'], $param_arr['param1'], str_replace("-", "/", $param_arr['param5']), str_replace("-", "/", $param_arr['param6']), $param_arr['param3'], $param_arr['param7'], $param_arr['param8'], $param_arr['p_mode'], NULL, NULL, NULL, NULL));
	}

	function instancesRelated_list($inst_arr, $param_arr)
	{
		$l_cont=0;
		$p_class_id=$param_arr['param1'];
		$p_inst_id=$param_arr['param2'];

		//$ins_title = $this->getActionTitle();
		$res='<div id="taula" class="col_item tbl_objects" style="width: 100%">';
		$res.='<div id="titol_taula">'.getMessage('related_objects').':</div>';

		$res.='<div id="lasupertabla">';
		$res.='<table id="tabla-objects" width="100%">
                            <colgroup>
                                <col class="w_30">
                                <col class="">
                                <col class="">
                                <col class="">
                            </colgroup>
                            <tbody>';
		$res.='<tr class="thead">
			<th class="center" scope="col"><strong>'.getMessage('info_word_ID').'</strong></th>
			<th class="center" scope="col"><strong>'.getMessage('info_word_keyword').'</strong></th>
			<th class="center" scope="col"><strong>'.getMessage('info_word_type').'</strong></th>
			<th class="center" scope="col"><strong>'.getMessage('info_word_status').'</strong></th>
		</tr>';
		$pijama=' class="even"';
		foreach ($inst_arr['pares'] as $row)
		{
			$res.='<tr'.$pijama.'>';
			if ($pijama==' class="even"')
				$pijama=' class="odd"';
			else
				$pijama=' class="even"';
			$res.='
                        <th scope="row" class="center"><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_inst_id='.$row['id'].'&amp;p_class_id='.$row['class_id'].'" title="'.getMessage('info_word_view').'"><strong>'.$row['id'].'</strong></a></th>
			<td class="center"><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_inst_id='.$row['id'].'&amp;p_class_id='.$row['class_id'].'" title="'.getMessage('info_word_view').'">'.$row['key_fields'].'</a></td>
			<td class="bold center"><span>'.getClassName($row['class_id']).'</span></td>
			<td><span class="status publish">'.parent::status_to_html($row['status']).'</span></td>
			</tr>';
			$l_cont=$l_cont+1;
		}


		foreach ($inst_arr['fills'] as $row)
		{
			$res.='<tr'.$pijama.'>';
			if ($pijama==' class="even"')
				$pijama=' class="odd"';
			else
				$pijama=' class="even"';

			$res.='<td class="omp_listelement"><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_inst_id='.$row['id'].'&amp;p_class_id='.$row['class_id'].'" title="'.getMessage('info_word_view').'">'.$row['id'].'</a></td>
			<td class="omp_listelement"><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_inst_id='.$row['id'].'&amp;p_class_id='.$row['class_id'].'" title="'.getMessage('info_word_view').'">'.$row['key_fields'].'</a></td>
			<td class="omp_list_element">'.getClassName($row['class_id']).'</td>
			<td class="omp_listelement">'.parent::status_to_html($row['status']).'</td></tr>';
			$l_cont=$l_cont+1;
		}
		$res.='</tbody></table>';
		$res.='</div>';

		if ($l_cont >= 1)
		{
			$message='<div id="fill_ariadna2">'.html_message_error(''.getMessage('error_object_delete').'&nbsp;<a href="javascript: history.go(-1)" class="omp_copyright">'.getMessage('navigation_back').'</a>').'</div>';
		}

		if ($l_cont == 0)
		{
			$message.='<div id="fill_ariadna2">'.html_message_warning(''.getMessage('info_word_areyousure').'&nbsp;<a href="'.APP_BASE.'/delete_instance2/?p_pagina=1&amp;p_class_id='.$p_class_id.'&amp;p_inst_id='.$p_inst_id.'">'.getMessage('info_word_yes').'</a> &nbsp;&nbsp; <a href="javascript: history.go(-1)" class="omp_copyright">'.getMessage('info_word_no').'</a>').'</div>';
		}
		$res.='</div>';

		return $message.$res;
	}

	function imagesConfirm() {
		$res='';
		$res.='<div id="fill_ariadna2">
			'.html_message_warning(''.getMessage('info_word_areyousure').'&nbsp;
			<a href="'.APP_BASE.'/delete_image2/?image_full='.$_REQUEST['image_full'].'&image='.$_REQUEST['image'].'">'.getMessage('info_word_yes').'</a>
			&nbsp;&nbsp;<a href="javascript: history.go(-1)" class="omp_copyright">'.getMessage('info_word_no').'</a>').'
		</div>

		<br /><img alt="'.$_REQUEST['image'].'" src="'.urldecode($_REQUEST['image']).'" />';

		return $res;
	}


	function instancesDelete_list($delete_array)
	{
		if($delete_array[0] == "unexpeted")
			return '<div id="fill_ariadna2">'.html_message_error('Unexpected Error').'<a class="omp_copyright" href="javascript: history.go(-1)">Tornar</a></div>';

		$l_cont=0;
		$res = '<div id="taula" class="col_item tbl_objects" style="width: 100%">';
				$res.='<div id="lasupertabla">';
				$res.='<table id="tabla-objects" width="100%">
                                        <colgroup>
                                            <col class="w_30">
                                            <col class="">
                                            <col class="">
                                            <col class="">
                                            <col class="">
                                        </colgroup>
                                        <tbody>';
				$res.='<tr class="thead">
						<th scope="col" class="center"><strong>'.getMessage('info_word_ID').'</strong></th>
						<th scope="col" class="center"><strong>'.getMessage('info_word_keyword').'</strong></th>
						<th scope="col" class="center"><strong>'.getMessage('info_word_type').'</strong></th>
						<th scope="col" class="center"><strong>'.getMessage('info_word_status').'</strong></th>
						<th scope="col" class="center"><strong>'.getMessage('info_word_childs').'</strong></th>
					</tr>';

		$to_eliminate = $res;
		$total_eliminate = 0;
		$total_res = 0;
		$insts = '';
		foreach($delete_array as $row)
		{
			$sentence ='<tr class="odd">
                        <th class="center" scope="row"><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_inst_id='.$row['id'].'&amp;p_class_id='.$row['class_id'].'" title="'.getMessage('info_word_view').'">'.$row['id'].'</a></th>
			<td class="center"><a href="'.APP_BASE.'/view_instance/?p_pagina=1&amp;p_inst_id='.$row['id'].'&amp;p_class_id='.$row['class_id'].'" title="'.getMessage('info_word_view').'">'.$row['key_fields'].'</a></td>
			<td class="bold center"><span>'.getClassName($row['class_id']).'</span></td>
			<td><span class="status publish">'.parent::status_to_html($row['status']).'</span></td>
			<td class="center"><span>'.$row['num_fills'].'</span></td></tr>';

			$status = $row['status'];
			$inst = $row['id'].',';

			if ($row['num_fills'] == 0 and $status == 'P')
			{
				$to_eliminate .= $sentence;
				$total_eliminate++;
				$insts .= $inst;
			}
			else
			{
				$res .= $sentence;
				$total_res++;
			}
		}

		$res.='</tbody></table> </div> </div>';

		$to_eliminate.='</table> </div> </div>';

		$insts = substr($insts, 0 , strlen($insts)-1);
		if($total_eliminate >= 0 && $total_res == 0)
		{
			$message = '<div id="fill_ariadna2">'.html_message_warning(''.getMessage('info_word_areyousure').'	<a href="'.APP_BASE.'/delete_all2/?p_pagina=1&amp;p_inst_id='.$insts.'">'.getMessage('info_word_yes').'</a> &nbsp;&nbsp; <a href="javascript: history.go(-1)" class="omp_copyright">'.getMessage('info_word_no').'</a></span>').'</div>';
			return $message.$to_eliminate;
		}

		if($total_res >= 0 && $total_eliminate == 0)
		{
			$message = '<div id="fill_ariadna2">'.html_message_warning(''.getMessage('info_word_not_eliminate').' <a class="omp_copyright" href="javascript: history.go(-1)">Volver</a>').'</div>';
			return $message.$res;
		}

		if($total_res > 0 && $total_eliminate > 0)
		{
			$message2 = '<div id="fill_ariadna2">'.html_message_warning(''.getMessage('info_word_not_eliminate').' <a class="omp_copyright" href="javascript: history.go(-1)">Tornar</a>').'</div>';
			$message = '<div id="fill_ariadna2">'.html_message_warning(''.getMessage('info_word_areyousure_arr').'	<a href="'.APP_BASE.'/delete_all2/?p_pagina=1&amp;p_inst_id='.$insts.'">'.getMessage('info_word_yes').'</a> &nbsp;&nbsp; <a href="javascript: history.go(-1)" class="omp_copyright">'.getMessage('info_word_no').'</a></span>').'</div>';
			return $message.$to_eliminate.$message2.$res;
		}
	}

	function imagesList_view($files) {
		$res='';
		$ins_title=$this->getActionTitle($p_search_query, $p_class_id, $p_fecha_ini, $p_fecha_fin);

		if(isset($_REQUEST['tab'])) $tab = $_REQUEST['tab'];
		else $tab = '';

		$res.='<div class="col_item tbl_objects">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" id="tabla-objects">
				<colgroup>
					<col class="" />
					<col class="" />
					<col class="" />
					<col class="" />
					<col class="" />
					<col class="" />
					<col class="" />
				</colgroup>';
				$res.='<!-- CAPÇALERA -->
				<tbody>
					<tr class="thead">
						<th scope="col"><strong>'.getMessage('file_name').'</label></th>
						<th scope="col"><strong>'.getMessage('file_image').'</strong></th>
						<th scope="col"><strong>'.getMessage('file_upload_date').'</strong></th>
						<th scope="col"><strong>'.getMessage('acciones').'</strong></th>
					</tr>
				<!-- /end CAPÇALERA -->';
				$pijama=' class="even"';

				foreach ($files as $file) {
					$res.='<tr'.$pijama.'>';
						if ($pijama==' class="even"') $pijama=' class="odd"';
						else $pijama=' class="even"';
						if (strlen($file['name'])>40) $file_name=substr($file['name'],0,40).'...';
                                                else $file_name=$file['name'];
						$res.='<td><span>'.$file_name.'</span></td>';
						$size=getimagesize($file['full_url']);
						if ($size[0]>=$size[1]) $res.='<td><img width="200" title="'.$file['url'].'" src="'.$file['url'].'" /></td>';
						else $res.='<td><img height="200" title="'.$file['url'].'" src="'.$file['url'].'" /></td>';
						$res.='<td><span>'.$file['date'].'</span></td>';
						$res.='<td class="edi_tit">
							<ul>';
								$res.='<li class="ico del"><a href="'.APP_BASE.'/delete_image/?image_full='.urlencode($file['full_url']).'&image='.urlencode($file['url']).'" title="'.getMessage('info_word_delete').'"/>'.getMessage('info_word_delete').'</a></li>';
							$res.='</ul>';
						$res.='</td>
					</tr>';
				}
		$res.='</tbody></table></div><!-- /end TAULA OBJECTES -->';

		return $res;
	}
}
?>
