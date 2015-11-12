<?php

$scheda = $_GET['scheda'];

Header('Content-type: text/xml');
print($scheda->asXML());


?>