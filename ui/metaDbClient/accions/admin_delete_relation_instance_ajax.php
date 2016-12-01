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
		
		$re=new relations();
		$in=new instances();
		$re->deleteRelationInstance($params);
		$in->refreshCache($params);
		$rel_id=$_REQUEST['p_rel_id'];
		
		$rel_id=$_REQUEST['p_rel_id'];
		$parent_inst_id=$_REQUEST['p_inst_id'];
		$tab_id=$_REQUEST['p_tab'];

/*
		print_r($params);
		echo 'rel_id='.$rel_id;
		echo 'parent_inst_id='.$parent_inst_id;
		echo 'tab_id='.$tab_id;
		die;
*/
		$at=new attributes();
		$at_t=new attributes_template();

		$rows=$at->getRelatedInstances($rel_id, $parent_inst_id);
		$ret.=$at_t->getRelationInstances($rows, $parent_inst_id, 1000, $tab_id, $rel_id);
    echo $ret;
		
	}
	// no volem incloure capçaleres ni res
	die;
