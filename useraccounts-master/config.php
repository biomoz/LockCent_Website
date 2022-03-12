<?php 

$db_user = "BuVg5vx3v6";
$db_pass = "nlbkpvJADI";
$db_name = "BuVg5vx3v6";

$db = new PDO('mysql:host=remotemysql.com;dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);