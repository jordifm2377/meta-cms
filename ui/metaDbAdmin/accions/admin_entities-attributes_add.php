<?php
//à

function getEntities() {
  $url = "http://localhost:3334/metacatalog/getEntities";
  return restRequest($url);
}

function getAttribute() {
  $url = "http://localhost:3334/metacatalog/getAttribs";
  return restRequest($url);
}

function getRelations() {
  $url = "http://localhost:3334/metacatalog/getRelations";
  return restRequest($url);
}

$entityList = '';
foreach (getEntities() as $key => $value) {
  $entityList = $entityList.'<option value="'.$value->id.'">'.$value->name.'</option>';
}

$attrList = '<option value="0" selected="true"></option>';
foreach (getAttribute() as $key => $value) {
  $attrList = $attrList.'<option value="'.$value->id.'">'.$value->name.'</option>';
}

$relList = '<option value="0" selected="true"></option>';
foreach (getRelations() as $key => $value) {
  $relList = $relList.'<option value="'.$value->id.'">'.$value->name.'</option>';
}

echo '<html>';
echo '<body>';
echo '<form method="post" action="/entities-attributes_add2">';
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/entities-attributes_list">Cancel</a></td></tr>';
echo '<tr><td width="30%">Entity</td><td><select name="entity_id">';
echo $entityList;
echo '</select></td></tr>';
echo '<tr><td>Attribute</td><td><select name="attr_id">';
echo $attrList;
echo '</select></td></tr>';
echo '<tr><td>Relation</td><td><select name="relation_id">';
echo $relList;
echo '</select></td></tr>';
echo '<tr><td>Row</td><td><input type="text" name="row" /></td></tr>';
echo '<tr><td>Column</td><td><input type="text" name="column" /></td></tr>';
echo '<tr><td>Order key (for keyword generation)</td><td><input type="text" name="order_key" /></td></tr>';
echo '<tr><td>Mandatory</td><td>
<input type="radio" name="mandatory" value="Y" /> Y&nbsp;
<input type="radio" name="mandatory" value="N" checked="checked" /> N
</td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" value="Send" /></td></tr>';
echo '</table>';
echo '</form>';
echo '</body>';
echo '</html>';

?>
