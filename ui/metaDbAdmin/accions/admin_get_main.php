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
	echo '<tr><td><a href="/attr_list">Attributes list</a></td></tr>';
	echo '<tr><td><a href="/entity_list">Entities list</a></td></tr>';
	echo '<tr><td><a href="/relation_list">Relations list</a></td></tr>';
	echo '<tr><td><a href="/entities-attributes_list">Entities attributes list</a></td></tr>';
	echo '</table>';
	echo '</body>';
	echo '</html>';

?>
