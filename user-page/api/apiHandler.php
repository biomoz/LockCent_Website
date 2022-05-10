<?php
include("api.php");

$apiObject = new API();

if($_GET["action"] == 'outputData'){
    $username= $_GET['username'];
    $data = $apiObject->outputData($username);
}

echo $data;
?>