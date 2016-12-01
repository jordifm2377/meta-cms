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
		$params['param1']=$params['param12'];
		$child_class_id=$_REQUEST['p_child_class_id'];
		$term=$_REQUEST['term'];
		
		$m=new model();
		$rows=$m->get_data("select id value, key_fields label, status `desc`
		from omp_instances
		where class_id=$child_class_id
		and key_fields like '%".$term."%'
		");
		
		echo json_encode($rows);

		if ($sc->getAccess('editable',$params)) 
		{
		  json_encode(array('hola1','hola2'));
		}
		else 
		{
      echo 'KO';
		}
	}
	// no volem incloure capçaleres ni res
	die;
