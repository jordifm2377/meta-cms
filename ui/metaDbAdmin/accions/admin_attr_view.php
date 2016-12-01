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
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/attr_edit/?p_attr_id='.$result->id.'">Edit</a>&nbsp;<a href="/attr_list">Back to list</a></td></tr>';
echo '<tr><td>Id</td><td>'.$result->id.'</td></tr>';
echo '<tr><td>Internal name</td><td>'.$result->name.'</td></tr>';
echo '<tr><td>CMS caption</td><td>'.$result->caption.'</td></tr>';
echo '<tr><td>JSON tag</td><td>'.$result->tag.'</td></tr>';
echo '<tr><td>Description</td><td>'.$result->description.'</td></tr>';
echo '<tr><td>Type</td><td>';
if($result->type == "S") {
  echo 'String';
}
if($result->type == "T") {
  echo 'Text';
}
if($result->type == "I") {
  echo 'Image';
}
if($result->type == "N") {
  echo 'Numeric';
}
if($result->type == "D") {
  echo 'Date';
}
if($result->type == "B") {
  echo 'Binary';
}
echo '</td></tr>';
echo '<tr><td>Lookup</td><td>HERE THE LOOKUP LIST!!</td></tr>';
echo '<tr><td>Field width</td><td>'.$result->width.'</td></tr>';
echo '<tr><td>Field height</td><td>'.$result->height.'</td></tr>';
echo '<tr><td>Field Max. Lenght</td><td>'.$result->maxLenght.'</td></tr>';
echo '<tr><td>Image width</td><td>'.$result->imgWidth.'</td></tr>';
echo '<tr><td>Image height</td><td>'.$result->imgHeight.'</td></tr>';
echo '</table>';
echo '</body>';
echo '</html>';

?>
