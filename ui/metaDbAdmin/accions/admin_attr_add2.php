<?php
//à

$postData = array(
  'name' => $_POST['attr_name'],
  'caption' => $_POST['attr_caption'],
  'description' => $_POST['attr_desc'],
  'type' => $_POST['attr_type'],
  'lookupId' => $_POST[''],
  'width' => $_POST['attr_width'],
  'height' => $_POST['attr_height'],
  'maxLenght' => $_POST['attr_maxlength'],
  'imgWidth' => $_POST['attr_imgwidth'],
  'imgHeight' => $_POST['attr_imgheight'],
  'tag' => $_POST['attr_tag']
);


$url = "http://localhost:3334/metacatalog/addAttr";
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
echo '<tr><td>Hopefully the attribute was added. '.$result.' => <a href="/attr_list">Attributes list</a></td></tr>';
echo '</table>';
echo '</body>';
echo '</html>';

?>
