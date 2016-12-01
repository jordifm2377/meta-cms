<?php
//à
echo '<html>';
echo '<body>';
echo '<form method="post" action="/entity_add2">';
echo '<table width="100%" border="1">';
echo '<tr><td colspan="2" align="right"><a href="/entity_list"></td></tr>';
echo '<tr><td>Internal name</td><td><input type="text" name="entity_name" /></td></tr>';
echo '<tr><td>CMS caption</td><td><input type="text" name="entity_caption" /></td></tr>';
echo '<tr><td>JSON tag</td><td><input type="text" name="entity_tag" /></td></tr>';
echo '<tr><td>Description</td><td><textarea name="entity_desc"></textarea></td></tr>';
echo '<tr><td>Group</td><td>(lookup!!)</td></tr>';
echo '<tr><td>Group order</td><td>(think about how to display it)</td></tr>';
echo '<tr><td colspan="2" align="center"><input type="submit" value="Send" /></td></tr>';
echo '</table>';
echo '</form>';
echo '</body>';
echo '</html>';

?>
