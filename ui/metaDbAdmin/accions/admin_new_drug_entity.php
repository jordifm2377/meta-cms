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

function getRelEntity($entityList, $entityName) {
  $retVal = null;
  foreach($entityList as $key => $value) {
    if($value->name == $entityName) {
      $retVal = $value;
    }
  }
  return $retVal;
}

function getAttribute($attrList, $attrName) {
  $retVal = null;
  foreach($attrList as $key => $value) {
    if($value->name == $attrName) {
      $retVal = $value;
    }
  }
  return $retVal;
}

function renderLookup($lookUp) {
  if($value->lookup->type=="L") {
    echo '<td><select name="'.$lookUp->renderInformation.'">';
    foreach($lookUp->lookup->lookupValues as $lupkey => $lupvalue) {
      if($lupvalue->id == $lookUp->lookup->defaultId) {
        echo '<option value="'.$lupvalue->id.'" selected="selected">'.$lupvalue->caption.'</option>';
      }
      else {
        echo '<option value="'.$lupvalue->id.'">'.$lupvalue->caption.'</option>';
      }
    }
    echo '</td></select>';
  }
  if($lookUp->lookup->type=="R") {
    echo '<td>';
    foreach($lookUp->lookup->lookupValues as $lupkey => $lupvalue) {
      if($lupvalue->id == $lookUp->lookup->defaultId) {
        echo '<input type="radio" name="'.$lookUp->renderInformation.'" value="'.$lupvalue->id.'" checked> '.$lupvalue->caption.'<br/>';
      }
      else {
        echo '<input type="radio" name="'.$lookUp->renderInformation.'" value="'.$lupvalue->id.'"> '.$lupvalue->caption.'<br/>';
      }
    }
    echo '</td>';
  }
}

$drugSummary=getEntitySummary($_REQUEST['entity_id']) ;
print_r($entitySummary);

echo '<html>';
echo '<body>';
echo '<head>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
</head>';
echo '<div id="tabs">';
echo '<ul>
        <li><a href="#tabs-1">Main drug attributes / Chemical Names</a></li>
        <li><a href="#tabs-2">Development Status</a></li>
        <li><a href="#tabs-3">...</a></li>
      </ul>';
echo '<form action="/new_drug_entity2" method="post">';
echo '<input type="hidden" name="p_entity_id" value="'.$drugSummary->id.'">';
echo '<div id="tabs-1">';
echo '<table>';
//ho pinto a lo cutre ...
foreach ($drugSummary->attributes as $key => $value) {
  echo '<tr>';
  echo '<td>'.$value->caption.'</td>';
  if($value->type=="S") {
    echo '<td><input type="text" value="" name="'.$value->renderInformation.'"/></td>';
  }
  if($value->type=="T") {
    echo '<td><textarea name="'.$value->renderInformation.'"></textarea></td>';
  }
  if($value->type=="N") {
    echo '<td><input type="text" value="" name="'.$value->renderInformation.'"/></td>';
  }
  if($value->type=="L") {
      renderLookup($value);
  }
  echo '</tr>';
}
echo '<tr><td colspan="2">Chem names<td></tr>';
echo '<tr><td colspan="2">';
echo '<table>';
$chemNames = getRelEntity($drugSummary->entities, 'itg_chem_name');
echo '<input type="hidden" name="'.$chemNames->renderInformation.'" value="'.$chemNames->id.'" />';
echo '<tr>';
echo '<td>Chem name: </td><td><input type="text" value="" name="'.getAttribute($chemNames->attributes, 'itg_name')->renderInformation.'"></td>';
echo '</tr>';
echo '</table>';
echo '</td></tr>';
echo '</table>';
echo '</div>';
echo '<div id="tabs-2">';
$devStatus = getRelEntity($drugSummary->entities, 'itg_dev_status');
echo '<table>';
echo '<input type="hidden" name="'.$devStatus->renderInformation.'" value="'.$devStatus->id.'" />';
echo '<th>IntegrityId</th><th>Discontinue</th><th>Year Phase</th><th>Star</th>';
echo '<tr>';
echo '<td><input type="text" value="" name="'.getAttribute($devStatus->attributes, 'itg_id')->renderInformation.'"></td>';
echo '<td>'.renderLookup(getAttribute($devStatus->attributes, 'itg_discontinued')).'</td>';
echo '<td><input type="text" value="" name="'.getAttribute($devStatus->attributes, 'itg_year_phase')->renderInformation.'"></td>';
echo '<td>'.renderLookup(getAttribute($devStatus->attributes, 'itg_star')).'</td>';
echo '</tr>';
echo '</table>';
echo '<table>';
echo '</table>';
echo '</div>';
echo '<input type="submit" value="Save" />';
echo '</form>';
echo '</div>';
echo '</body>';
echo '</html>';

?>
