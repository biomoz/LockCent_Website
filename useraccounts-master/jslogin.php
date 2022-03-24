<?php
session_start();
require_once('config.php');


$username = $_POST['username'];
$sql = "SELECT username, ekey FROM user_accounts WHERE username='$username'";
$result = $db->query($sql);

if ($result->rowCount() > 0) {
  // output data of each row
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
 
	$enc_ekey= (binary)$row["ekey"];
  }
} else {
  echo "0 results";
}

$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
$method = 'aes-256-cbc';

$password = base64_encode(openssl_encrypt($_POST['password'], $method, $enc_ekey, OPENSSL_RAW_DATA, $iv));

$sql = "SELECT * FROM user_accounts WHERE username = ? AND password = ? LIMIT 1";
$stmtselect  = $db->prepare($sql);
$result = $stmtselect->execute([$username, $password]);

if($result){
	$user = $stmtselect->fetch(PDO::FETCH_ASSOC);
	if($stmtselect->rowCount() > 0){
		$_SESSION['userlogin'] = $user;
		echo 'Succesfull';
	}else{
		echo 'The username or password is incorrect';		
	}
}else{
	echo 'There were errors while connecting to database';
}