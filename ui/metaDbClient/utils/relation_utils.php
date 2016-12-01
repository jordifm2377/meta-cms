<?php

/**
 * relation utils
 *
 * @version $Id$
 * @copyright 2004 
 **/

 function html_relation_shake($p_relinst_id, $delta) {
	 global $dbh;
   $sql='select weight, rel_id, parent_inst_id from omp_relation_instances where id='.str_replace("\"", "\\\"", str_replace("[\]","",$p_relinst_id));

  $Result = mysql_query($sql, $dbh);
  $Row = mysql_fetch_array($Result, MYSQL_ASSOC);
   
  $pes_inicial = $Row['weight'];
  $parent_inst_id = $Row['parent_inst_id'];
  $rel_id = $Row['rel_id'];

  $pes_desti = $pes_inicial+$delta;
   
  $sql='update omp_relation_instances set weight=-1 where id='.str_replace("\"", "\\\"", str_replace("[\]","",$p_relinst_id));
  $Result = mysql_query($sql, $dbh);

   $sql='update omp_relation_instances set weight='.$pes_inicial.' 
   where 
   rel_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$rel_id)).'
   and parent_inst_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$parent_inst_id)).'
   and weight='.str_replace("\"", "\\\"", str_replace("[\]","",$pes_desti)).'
   ';
  $Result = mysql_query($sql, $dbh);
  
   $sql='update omp_relation_instances set weight='.$pes_desti.' 
   where 
   rel_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$rel_id)).'
   and parent_inst_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$parent_inst_id)).'
   and weight=-1
   ';
  $Result = mysql_query($sql, $dbh);
   
 }
 
 function html_relation_shake_top($p_relinst_id, $delta) {
	 global $dbh;
   $sql='select weight, rel_id, parent_inst_id from omp_relation_instances where id='.str_replace("\"", "\\\"", str_replace("[\]","",$p_relinst_id));

   $Result = mysql_query($sql, $dbh);
   $Row = mysql_fetch_array($Result, MYSQL_ASSOC);
   
   $pes_inicial = $Row['weight'];
   $parent_inst_id = $Row['parent_inst_id'];
   $rel_id = $Row['rel_id'];

   $pes_desti = $pes_inicial+$delta;
   
   $sql='select max(weight) as max, min(weight) as min from omp_relation_instances where rel_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$rel_id)).'
   and parent_inst_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$parent_inst_id));
   $Result = mysql_query($sql, $dbh);
   $Row = mysql_fetch_array($Result, MYSQL_ASSOC);
   $max=$Row['max'];
   $min=$Row['min'];
	
   $sql='update omp_relation_instances set weight=-1 where id='.str_replace("\"", "\\\"", str_replace("[\]","",$p_relinst_id));
   $Result = mysql_query($sql, $dbh);

  
   if($delta>0)
   {
     $new_delta=$min;
	 $sql='update omp_relation_instances set weight=(weight+'.$delta.') 
		   where 
		   rel_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$rel_id)).'
		   and parent_inst_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$parent_inst_id)).'
		   and weight<'.str_replace("\"", "\\\"", str_replace("[\]","",$pes_inicial)).' 
		   and weight!=-1';
   }
   else
   {
     $new_delta=$max;
	 $sql='update omp_relation_instances set weight=(weight-'.abs($delta).') 
		   where 
		   rel_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$rel_id)).'
		   and parent_inst_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$parent_inst_id)).'
		   and weight>'.str_replace("\"", "\\\"", str_replace("[\]","",$pes_inicial)).' 
		   and weight!=-1';
   }
	
   $Result = mysql_query($sql, $dbh);
  
   $sql='update omp_relation_instances set weight='.$new_delta.' 
   where 
   rel_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$rel_id)).'
   and parent_inst_id = '.str_replace("\"", "\\\"", str_replace("[\]","",$parent_inst_id)).'
   and weight=-1
   ';
   
   $Result = mysql_query($sql, $dbh);   
 }

 function html_relation_instance_up($p_relinst_id)
 {
   html_relation_shake($p_relinst_id, -10);
   return getMessage('info_word_orderjoin');
 }
  function  html_relation_instance_up_top($p_relinst_id)
 {
   html_relation_shake_top($p_relinst_id, 10);
   return getMessage('info_word_orderjoin');
 }


 function html_relation_instance_down($p_relinst_id)
 {
   html_relation_shake($p_relinst_id, 10);
   return getMessage('info_word_orderjoin');
 }
 function  html_relation_instance_down_bottom($p_relinst_id)
 {
   html_relation_shake_top($p_relinst_id, -10);
   return getMessage('info_word_orderjoin');
 }

 function create_relation ($p_relation_id, $p_parent_inst_id, $p_child_inst_id) {
	 global $dbh;
   $sql='
   select r.order_type, min(weight) weight
   from omp_relations r
   , omp_relation_instances ri
   where ri.parent_inst_id='.str_replace("\"", "\\\"", str_replace("[\]","",$p_parent_inst_id)).'
   and ri.rel_id='.str_replace("\"", "\\\"", str_replace("[\]","",$p_relation_id)).'
   and ri.rel_id = r.id
   group by r.order_type
   ';
   $Result = mysql_query($sql, $dbh);
   $Row = $row = mysql_fetch_array($Result, MYSQL_ASSOC);
   
   if ($Row && $Row['weight'])
   {
     $weight = ($Row['weight'])-10;
   }
   else
   {// No tenim cap insertat, posem el valor inicial pel pes 100000
     $weight = 100000;
   }
   
	$sql='insert into omp_relation_instances
   (rel_id, parent_inst_id, child_inst_id, weight, relation_date)
   values
   ('.str_replace("\"", "\\\"", str_replace("[\]","",$p_relation_id)).','.str_replace("\"", "\\\"", str_replace("[\]","",$p_parent_inst_id)).', '.str_replace("\"", "\\\"", str_replace("[\]","",$p_child_inst_id)).', '.str_replace("\"", "\\\"", str_replace("[\]","",$weight)).', now())';
   $res.=$sql;

   $result = mysql_query($sql, $dbh);

/* Nou tro� de codi per retornar el relation_instance_id */
   $sql='select last_insert_id() last;';
   
   $res.=$sql;
   $result = mysql_query($sql, $dbh);
   $result_row = $row = mysql_fetch_array($result, MYSQL_ASSOC);
   
   $new_relation_instance_id = $result_row['last'];
/* Fi nou tro� de codi */
   
  return $new_relation_instance_id;
}
?>
