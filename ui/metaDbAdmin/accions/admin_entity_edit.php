<?php
//à
$entityId=$_REQUEST['p_entity_id'];
$url = "http://localhost:3334/metacatalog/getEntity/".$entityId;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$result = json_decode(curl_exec($curl));

curl_close($curl);


echo '<html>';
echo '<body>';
echo '<form method="post" action="/entity_edit2">';
echo '<input type="hidden" name="entity_id" value="'.$entityId.'" />';
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/attr_list">Cancel</a></td></tr>';
echo '<tr><td>Internal name</td><td><input type="text" name="entity_name" value="'.$result->name.'" /></td></tr>';
echo '<tr><td>CMS caption</td><td><input type="text" name="entity_caption" value="'.$result->caption.'" /></td></tr>';
echo '<tr><td>JSON tag</td><td><input type="text" name="entity_tag" value="'.$result->tag.'" /></td></tr>';
echo '<tr><td>Description</td><td><textarea name="entity_desc">'.$result->description.'</textarea></td></tr>';
echo '<tr><td>Group</td><td>(lookup!!)</td></tr>';
echo '<tr><td>Group order</td><td>(think about how to display it)</td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" value="Send" /></td></tr>';
echo '</table>';

echo '</form>';
echo '</body>';
echo '</html>';

?>
