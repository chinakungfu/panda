<?php
$jsonData = getDataAsJson($_GET['symbol']);
echo $_GET['callback'] . '(' . $jsonData . ');';
// prints: jsonp1232617941775({"symbol" : "IBM", "price" : "91.42"});
?>