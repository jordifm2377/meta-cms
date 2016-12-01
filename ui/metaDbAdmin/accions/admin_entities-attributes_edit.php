<?php
//à
function getEntityAttribute($id) {
  $url = "http://localhost:3334/metacatalog/getEntityAttr/".$id;
  return restRequest($url);
}

$entityAttrId=$_REQUEST['p_entity_attr_id'];
$result = getEntityAttribute($entityAttrId);

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
  if($value->id == $result->entityId) {
    $entityList = $entityList.'<option value="'.$value->id.'" selected="true">'.$value->name.'</option>';
  }
  else {
    $entityList = $entityList.'<option value="'.$value->id.'">'.$value->name.'</option>';
  }
}

$attrListMatch = 0;
$attrList = '';
foreach (getAttribute() as $key => $value) {
  if($value->id == $result->attrId) {
    $attrList = $attrList.'<option value="'.$value->id.'" selected="true">'.$value->name.'</option>';
    $attrListMatch = 1;
  }
  else {
    $attrList = $attrList.'<option value="'.$value->id.'">'.$value->name.'</option>';
  }
}

$relListMatch = 0;
$relList = '';
foreach (getRelations() as $key => $value) {
  if($value->id == $result->relId) {
    $relList = $relList.'<option value="'.$value->id.'" selected="true">'.$value->name.'</option>';
    $relListMatch = 1;
  }
  else {
    $relList = $relList.'<option value="'.$value->id.'">'.$value->name.'</option>';
  }
}

echo '<html>';
echo '<body>';
echo '<form method="post" action="/entities-attributes_edit2">';
echo '<input type="hidden" name="entity_attr_id" value="'.$entityAttrId.'" />';
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/entities-attributes_list">Cancel</a></td></tr>';
echo '<tr><td width="30%">Entity</td><td><select name="entity_id">';
echo $entityList;
echo '</select></td></tr>';
echo '<tr><td>Attribute</td><td><select name="attr_id">';
if($attrListMatch == 0) {
  echo '<option value="0" selected="true"></option>';
}
echo $attrList;
echo '</select></td></tr>';
echo '<tr><td>Relation</td><td><select name="relation_id">';
if($relListMatch == 0) {
  echo '<option value="0" selected="true"></option>';
}
echo $relList;
echo '</select></td></tr>';
echo '<tr><td>Row</td><td><input type="text" name="row" value="'.$result->row.'" /></td></tr>';
echo '<tr><td>Column</td><td><input type="text" name="column" value="'.$result->column.'" /></td></tr>';
echo '<tr><td>Order key (for keyword generation)</td><td><input type="text" name="order_key" value="'.$result->orderKey.'" /></td></tr>';
echo '<tr><td>Mandatory</td><td>';
if($result->mandatory == "Y") {
  echo '<input type="radio" name="mandatory" value="Y" checked="checked"/> Y&nbsp;
  <input type="radio" name="mandatory" value="N" /> N';
}
else {
  echo '<input type="radio" name="mandatory" value="Y" /> Y&nbsp;
  <input type="radio" name="mandatory" value="N" checked="checked" /> N';
}
echo '</td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" value="Send" /></td></tr>';
echo '</table>';
echo '</form>';
echo '</body>';
echo '</html>';

?>
