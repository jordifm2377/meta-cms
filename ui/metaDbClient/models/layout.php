<?php
//à
require_once(DIR_APLI_ADMIN.'/models/model.php');

class layout extends model 
{
	var $class_name = 'menu';
	
	function __construct()
	{ 
		return;
	}	
	
	function get_topMenu($lg)
	{
		$menu = array();
		$sql = "select id, caption_".$lg." as lg_cap from omp_class_groups order by ordering";

		$ret=parent::get_data($sql);
		if(!$ret)
			return $menu;

		$arr_tmp = array();
		
		foreach ($ret as $r)
		{
			$sql2 = "select c.id, c.name_".$lg." as lg_name, grp_order 
			from omp_classes c, omp_roles_classes rc 
			where c.grp_id = ".$r['id']." 
			and c.id = rc.class_id 
			and rc.rol_id = ".$_SESSION['rol_id']."
			and browseable='Y'
			order by c.grp_order";
			$ret2=parent::get_data($sql2);
			$arr_tmp=$r;
			$arr_tmp['list']=$ret2;
/*			
			$arr_tmp['caption'] = $r;
			$arr_tmp['list'] = $ret2;
*/			
			array_push($menu, $arr_tmp);
			
			
		}
		return $menu;
	}
}
