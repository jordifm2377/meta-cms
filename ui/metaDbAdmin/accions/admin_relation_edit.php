<?php
//à
$relationId=$_REQUEST['p_relation_id'];
$url = "http://localhost:3334/metacatalog/getRelation/".$relationId;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = json_decode(curl_exec($curl));
curl_close($curl);

$url = "http://localhost:3334/metacatalog/getEntities";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result_entity = json_decode(curl_exec($curl));
curl_close($curl);

echo '<html>';
echo '<body>';
echo '<form method="post" action="/relation_edit2">';
echo '<input type="hidden" name="relation_id" value="'.$relationId.'" />';
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/relation_list">Cancel</td></tr>';
echo '<tr><td>Internal name</td><td><input type="text" name="relation_name" value="'.$result->name.'" /></td></tr>';
echo '<tr><td>CMS caption</td><td><input type="text" name="relation_caption" value="'.$result->caption.'" /></td></tr>';
echo '<tr><td>JSON tag</td><td><input type="text" name="relation_tag" value="'.$result->tag.'" /></td></tr>';
echo '<tr><td>Description</td><td><textarea name="relation_desc">'.$result->description.'</textarea></td></tr>';
echo '<tr><td>Parent Entity</td><td><select id="relation_parent_id" name="relation_parent_id">';
foreach ($result_entity as $entityKey => $entityValue) {
  if($entityValue->id == $result->parentId){
    echo '<option value="'.$entityValue->id.'" selected="true">'.$entityValue->name.'</option>';
  }
  else {
    echo '<option value="'.$entityValue->id.'">'.$entityValue->name.'</option>';
  }
}
echo '</select></td></tr>';
echo '<tr><td>Child Entity</td><td><select id="relation_child_id" name="relation_child_id">';
foreach ($result_entity as $entityKey => $entityValue) {
  if($entityValue->id == $result->childId){
    echo '<option value="'.$entityValue->id.'" selected="true">'.$entityValue->name.'</option>';
  }
  else {
    echo '<option value="'.$entityValue->id.'">'.$entityValue->name.'</option>';
  }
}
echo '</select></td></tr>';

echo '<tr><td>Order Type</td><td>';
if($result->orderType == "T") {
  echo '<input type="radio" name="relation_order_type" value="T" checked="checked" /> Timestamp<br/>';
} else {
  echo '<input type="radio" name="relation_order_type" value="T" /> Timestamp<br/>';
}
if($result->orderType == "M") {
  echo '<input type="radio" name="relation_order_type" value="M" checked="checked" /> Manual<br/>';
} else {
  echo '<input type="radio" name="relation_order_type" value="M" /> Manual<br/>';
}
echo '</td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" value="Send" /></td></tr>';
echo '</table>';
echo '</form>';
echo '</body>';
echo '</html>';

?>
