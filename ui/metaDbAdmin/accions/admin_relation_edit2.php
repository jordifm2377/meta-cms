<?php
//à

$postData = array(
  'id' => $_POST['relation_id'],
  'name' => $_POST['relation_name'],
  'caption' => $_POST['relation_caption'],
  'description' => $_POST['relation_desc'],
  'parentId' => $_POST['relation_parent_id'],
  'childId' => $_POST['relation_child_id'],
  'orderType' => $_POST['relation_order_type'],
  'tag' => $_POST['relation_tag']
);


$url = "http://localhost:3334/metacatalog/updateRelation";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));

$result = json_decode(curl_exec($curl));

curl_close($curl);
//print_r($result);
echo '<html>';
echo '<body>';
echo '<table width="100%" border="1">';
echo '<tr><td>Hopefully the relation was updated. '.$result.' => <a href="/relation_list">Relations list</a></td></tr>';
echo '</table>';
echo '</body>';
echo '</html>';

?>
