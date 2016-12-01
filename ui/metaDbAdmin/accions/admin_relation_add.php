<?php
//à

$url = "http://localhost:3334/metacatalog/getEntities";
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = json_decode(curl_exec($curl));

curl_close($curl);

$entityList = '';
foreach ($result as $key => $value) {
  $entityList = $entityList.'<option value="'.$value->id.'">'.$value->name.'</option>';
}

echo '<html>';
echo '<body>';
echo '<form method="post" action="/relation_add2">';
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/relation_list">Cancel</td></tr>';
echo '<tr><td>Internal name</td><td><input type="text" name="relation_name" /></td></tr>';
echo '<tr><td>CMS caption</td><td><input type="text" name="relation_caption" /></td></tr>';
echo '<tr><td>JSON tag</td><td><input type="text" name="relation_tag" /></td></tr>';
echo '<tr><td>Description</td><td><textarea name="relation_desc"></textarea></td></tr>';
echo '<tr><td>Parent Entity</td><td><select name="relation_parent_id">';
echo $entityList;
echo '</select></td></tr>';
echo '<tr><td>Child Entity</td><td><select name="relation_child_id">';
echo $entityList;
echo '</select></td></tr>';
echo '<tr><td>Order Type</td><td>
<input type="radio" name="relation_order_type" value="T" checked="checked" /> Timestamp<br/>
<input type="radio" name="relation_order_type" value="M" /> Manual
</td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" value="Send" /></td></tr>';
echo '</table>';
echo '</form>';
echo '</body>';
echo '</html>';

?>
