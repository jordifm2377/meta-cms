<?php
//à

	$url = "http://localhost:3334/metacatalog/getEntitesAttributes";
	$result = restRequest($url);

	function getEntity($id) {
		$url = "http://localhost:3334/metacatalog/getEntity/".$id;
		return restRequest($url);
	}

	function getAttribute($id) {
		$url = "http://localhost:3334/metacatalog/getAttr/".$id;
		return restRequest($url);
	}

	function getRelation($id) {
		$url = "http://localhost:3334/metacatalog/getRelation/".$id;
		return restRequest($url);
	}


	echo '<html>';
	echo '<body>';
	echo '<table width="100%" border="1">';
	echo '<tr><td colspan="6" align="right"><a href="/entities-attributes_add">Add</a>&nbsp;<a href="/get_main">Menu</a></td></tr>';
	echo '<tr><td></td><td>Entity</td><td>Attribute</td><td>Relation</td><td>Mandatory</td><td></td>';
	foreach ($result as $key => $value) {
		$entity = getEntity($value->entityId);
		$attr = getAttribute($value->attrId);
		$rel = getRelation($value->relId);
		echo '<tr>';
		echo '<td><a href="/entities-attributes_view/?p_entity_attr_id='.$value->id.'">'.$value->id.'</a></td>';
		echo '<td>'.$entity->name.'</td>';
		echo '<td>'.$attr->name.'</td>';
		echo '<td>'.$rel->name.'</td>';
		if($value->mandatory == "Y") {
		  echo '<td>Yes</td>';
		}
		if($value->mandatory == "N") {
		  echo '<td>No</td>';
		}

		if($value->enabled == "N") {
			echo '<td><a href="/entities-attributes_edit/?p_entity_attr_id='.$value->id.'">Edit</a>
			&nbsp;<a href="/entities-attributes_enable/?p_entity_attr_id='.$value->id.'">Enable</a></td>';
		}
		else {
			echo '<td><a href="/entities-attributes_edit/?p_entity_attr_id='.$value->id.'">Edit</a>
			&nbsp;<a href="/entities-attributes_disable/?p_entity_attr_id='.$value->id.'">Disable</a></td>';
		}
		echo '</tr>';
	}
	echo '</table>';
	echo '</body>';
	echo '</html>';

?>
