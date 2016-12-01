<?php
//à

$postData = array(
  'entityId' => $_POST['entity_id'],
  'attrId' => $_POST['attr_id'],
  'relId' => $_POST['relation_id'],
  'row' => $_POST['row'],
  'column' => $_POST['column'],
  'orderKey' => $_POST['order_key'],
  'mandatory' => $_POST['mandatory']
);


$url = "http://localhost:3334/metacatalog/addEntityAttribute";
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
echo '<tr><td>Hopefully the entity-attribute was added. '.$result.' => <a href="/entities-attributes_list">Entities attributes list</a></td></tr>';
echo '</table>';
echo '</body>';
echo '</html>';

?>
