<?php
//à

$postData = array(
  'id' => $_POST['entity_id'],
  'name' => $_POST['entity_name'],
  'caption' => $_POST['entity_caption'],
  'description' => $_POST['entity_desc'],
  'groupId' => $_POST['entity_group_id'],
  'groupOrder' => $_POST['entity_group_order'],
  'tag' => $_POST['entity_tag']
);


$url = "http://localhost:3334/metacatalog/updateEntity";
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
echo '<tr><td>Hopefully the entity was updated. '.$result.' => <a href="/entity_list">Entities list</a></td></tr>';
echo '</table>';
echo '</body>';
echo '</html>';

?>
