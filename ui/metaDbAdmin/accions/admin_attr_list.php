<?php
//à
	$url = "http://localhost:3334/metacatalog/getAttribs";
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	$result = json_decode(curl_exec($curl));

	curl_close($curl);
	//print_r($result);
	echo '<html>';
	echo '<body>';
	echo '<table width="100%" border="1">';
	echo '<tr><td colspan="6" align="right"><a href="/attr_add">Add</a>&nbsp;<a href="/get_main">Menu</a></td></tr>';
	echo '<tr><td></td><td>Internal Name</td><td>CMS Caption</td><td>JSON tag</td><td>Type</td><td></td>';
	foreach ($result as $key => $value) {
		echo '<tr>';
		echo '<td><a href="/attr_view/?p_attr_id='.$value->id.'">'.$value->id.'</a></td>';
		echo '<td>'.$value->name.'</td>';
		echo '<td>'.$value->caption.'</td>';
		echo '<td>'.$value->tag.'</td>';
		echo '<td>'.$value->type.'</td>';
		if($value->enabled == "N") {
			echo '<td><a href="/attr_edit/?p_attr_id='.$value->id.'">Edit</a>&nbsp;<a href="/attr_enable/?p_attr_id='.$value->id.'">Enable</a></td>';
		}
		else {
			echo '<td><a href="/attr_edit/?p_attr_id='.$value->id.'">Edit</a>&nbsp;<a href="/attr_disable/?p_attr_id='.$value->id.'">Disable</a></td>';
		}
		echo '</tr>';
	}
	echo '</table>';
	echo '</body>';
	echo '</html>';

?>
