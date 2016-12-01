<?php
//à
$relationId=$_REQUEST['p_relation_id'];
$url = "http://localhost:3334/metacatalog/getRelation/".$relationId;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = json_decode(curl_exec($curl));

curl_close($curl);

$url = "http://localhost:3334/metacatalog/getEntity/".$result->parentId;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result_parentEntity = json_decode(curl_exec($curl));
curl_close($curl);

$url = "http://localhost:3334/metacatalog/getEntity/".$result->childId;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result_childEntity = json_decode(curl_exec($curl));
curl_close($curl);


echo '<html>';
echo '<body>';
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/relation_edit/?p_relation_id='.$result->id.'">Edit</a>&nbsp;<a href="/relation_list">Back to list</a></td></tr>';
echo '<tr><td>Id</td><td>'.$result->id.'</td></tr>';
echo '<tr><td>Internal name</td><td>'.$result->name.'</td></tr>';
echo '<tr><td>CMS caption</td><td>'.$result->caption.'</td></tr>';
echo '<tr><td>JSON tag</td><td>'.$result->tag.'</td></tr>';
echo '<tr><td>Description</td><td>'.$result->description.'</td></tr>';
echo '<tr><td>Parent Entity</td><td>'.$result_parentEntity->name.'</td></tr>';
echo '<tr><td>Child Entity</td><td>'.$result_childEntity->name.'</td></tr>';
echo '<tr><td>Order Type</td><td>';
if($result->type == "T") {
  echo 'Timestamp';
}
if($result->type == "M") {
  echo 'Manual';
}
echo '</td></tr>';
echo '<tr><td>Lookup</td><td>HERE THE LOOKUP LIST!!</td></tr>';
echo '</table>';
echo '</body>';
echo '</html>';

?>
