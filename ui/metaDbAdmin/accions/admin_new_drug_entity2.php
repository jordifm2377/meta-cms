<?php
//à

function getEntitySummary($id) {
  if($id != null) {
    $url = "http://localhost:3334/metacatalogClient/fullSummary/".$id;
    return restRequest($url);
  }
  else
    return null;
}

print_r($_REQUEST);
?>
