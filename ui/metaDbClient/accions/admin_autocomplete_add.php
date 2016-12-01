<?php
//à
	$sc=new security();

	if ($sc->testSession()==0) 
	{
    echo 'KO';
	}
	else 
	{
		$params=get_params_info();
		$child_inst_id=$_REQUEST['p_child_inst_id'];
		$parent_inst_id=$_REQUEST['p_parent_inst_id'];
		$parent_class_id=$_REQUEST['p_parent_class_id'];
		$rel_id=$_REQUEST['p_rel_id'];
		$tab_id=$_REQUEST['p_tab_id'];

		$param_arr=array();
    $param_arr['param9']=$rel_id;
		$param_arr['param11']=$parent_inst_id;
		$param_arr['param13']=$child_inst_id;		
		
		$at=new attributes();
		$at_t=new attributes_template();

		$r=new relations();
		$r->createRelation($param_arr);
		$rows=$at->getRelatedInstances($rel_id, $parent_inst_id);
		$ret.=$at_t->getRelationInstances($rows, $parent_inst_id, 1000, $tab_id, $rel_id);
    echo $ret;
		
	}
	// no volem incloure capçaleres ni res
	die;
