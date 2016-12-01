<?php
//à
echo '<html>';
echo '<body>';
echo '<form method="post" action="/attr_add2">';
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/attr_list"></td></tr>';
echo '<tr><td>Internal name</td><td><input type="text" name="attr_name" /></td></tr>';
echo '<tr><td>CMS caption</td><td><input type="text" name="attr_caption" /></td></tr>';
echo '<tr><td>JSON tag</td><td><input type="text" name="attr_tag" /></td></tr>';
echo '<tr><td>Description</td><td><textarea name="attr_desc"></textarea></td></tr>';
echo '<tr><td>Type</td><td>
<input type="radio" name="attr_type" value="S" checked="checked" /> String<br/>
<input type="radio" name="attr_type" value="T" /> Text<br/>
<input type="radio" name="attr_type" value="I" /> Image<br/>
<input type="radio" name="attr_type" value="N" /> Numeric<br/>
<input type="radio" name="attr_type" value="D" /> Date<br/>
<input type="radio" name="attr_type" value="B" /> Binary<br/>
</td></tr>';
echo '<tr><td>Lookup</td><td>HERE THE LOOKUP LIST!!</td></tr>';
echo '<tr><td>Field width</td><td><input type="text" name="attr_width" /></td></tr>';
echo '<tr><td>Field height</td><td><input type="text" name="attr_height" /></td></tr>';
echo '<tr><td>Field Max. Lenght</td><td><input type="text" name="attr_maxlength" /></td></tr>';
echo '<tr><td>Image width</td><td><input type="text" name="attr_imgwidth" /></td></tr>';
echo '<tr><td>Image height</td><td><input type="text" name="attr_imgheight" /></td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" value="Send" /></td></tr>';
echo '</table>';
echo '</form>';
echo '</body>';
echo '</html>';

?>
