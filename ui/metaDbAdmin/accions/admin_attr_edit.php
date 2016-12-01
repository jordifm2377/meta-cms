<?php
//à
$attrId=$_REQUEST['p_attr_id'];
$url = "http://localhost:3334/metacatalog/getAttr/".$attrId;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = json_decode(curl_exec($curl));

curl_close($curl);


echo '<html>';
echo '<body>';
echo '<form method="post" action="/attr_edit2">';
echo '<input type="hidden" name="attr_id" value="'.$attrId.'" />';
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/attr_list">Cancel</a></td></tr>';
echo '<tr><td>Internal name</td><td><input type="text" name="attr_name" value="'.$result->name.'" /></td></tr>';
echo '<tr><td>CMS caption</td><td><input type="text" name="attr_caption" value="'.$result->caption.'" /></td></tr>';
echo '<tr><td>JSON tag</td><td><input type="text" name="attr_tag" value="'.$result->tag.'" /></td></tr>';
echo '<tr><td>Description</td><td><textarea name="attr_desc">'.$result->description.'</textarea></td></tr>';
echo '<tr><td>Type</td><td>';
if($result->type == "S") {
  echo '<input type="radio" name="attr_type" value="S" checked="checked" /> String<br/>';
} else {
  echo '<input type="radio" name="attr_type" value="S" /> String<br/>';
}

if($result->type == "T") {
  echo '<input type="radio" name="attr_type" value="T" checked="checked" /> Text<br/>';
} else {
  echo '<input type="radio" name="attr_type" value="T" /> Text<br/>';
}

if($result->type == "I") {
  echo '<input type="radio" name="attr_type" value="I" checked="checked" /> Image<br/>';
} else {
  echo '<input type="radio" name="attr_type" value="I" /> Image<br/>';
}

if($result->type == "N") {
  echo '<input type="radio" name="attr_type" value="N" checked="checked" /> Numeric<br/>';
} else {
  echo '<input type="radio" name="attr_type" value="N" /> Numeric<br/>';
}

if($result->type == "D") {
  echo '<input type="radio" name="attr_type" value="D" checked="checked" /> Date<br/>';
} else {
  echo '<input type="radio" name="attr_type" value="D" /> Date<br/>';
}

if($result->type == "B") {
  echo '<input type="radio" name="attr_type" value="B" checked="checked" /> Binary<br/>';
} else {
  echo '<input type="radio" name="attr_type" value="B" /> Binary<br/>';
}
echo '</td></tr>';
echo '<tr><td>Lookup</td><td>HERE THE LOOKUP LIST!!</td></tr>';
echo '<tr><td>Field width</td><td><input type="text" name="attr_width" value="'.$result->width.'" /></td></tr>';
echo '<tr><td>Field height</td><td><input type="text" name="attr_height" value="'.$result->height.'" /></td></tr>';
echo '<tr><td>Field Max. Lenght</td><td><input type="text" name="attr_maxlength" value="'.$result->maxLength.'" /></td></tr>';
echo '<tr><td>Image width</td><td><input type="text" name="attr_imgwidth" value="'.$result->imgWidth.'" /></td></tr>';
echo '<tr><td>Image height</td><td><input type="text" name="attr_imgheight" value="'.$result->imgHeight.'" /></td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" value="Send" /></td></tr>';
echo '</table>';
echo '</form>';
echo '</body>';
echo '</html>';

?>
