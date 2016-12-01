<?php
//à
$entityId=$_REQUEST['p_entity_id'];
$url = "http://localhost:3334/metacatalog/getEntity/".$entityId;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = json_decode(curl_exec($curl));

curl_close($curl);


echo '<html>';
echo '<body>';
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/entity_edit/?p_entity_id='.$result->id.'">Edit</a>&nbsp;<a href="/entity_list">Back to list</a></td></tr>';
echo '<tr><td>Id</td><td>'.$result->id.'</td></tr>';
echo '<tr><td>Internal name</td><td>'.$result->name.'</td></tr>';
echo '<tr><td>CMS caption</td><td>'.$result->caption.'</td></tr>';
echo '<tr><td>JSON tag</td><td>'.$result->tag.'</td></tr>';
echo '<tr><td>Description</td><td>'.$result->description.'</td></tr>';
echo '<tr><td>Group</td><td>HERE THE GROUP!!</td></tr>';
echo '<tr><td>Group order</td><td>HERE THE GROUP ORDER!!</td></tr>';
echo '</table>';
echo '</body>';
echo '</html>';

?>
