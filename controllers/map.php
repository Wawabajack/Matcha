<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/config/db_connect.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/models/queryfuncs.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/models/checkfuncs.php');


$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$connection = $db;



$result = getUsermap($db);
//var_dump($result);

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = $result->fetch(PDO::FETCH_ASSOC)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['id']);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
}

echo $dom->saveXML();

$dom->formatOutput = true; 
$test1 = $dom->saveXML(); // put string in test1
$dom->save('map.xml'); // save as file
 ?>