<?php
require_once('config.php');
?>
<?php
		if(isset($_POST['create'])){

			if ($_POST['password'] === $_POST['re-password']) {
				$method = 'aes-256-cbc';
				$string = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				$ekey= substr(str_shuffle($string),0,32);
				$enc_ekey = substr(hash('sha256', $ekey, true), 0, 32);

				$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

				$email = $_POST['email'];
				$username = $_POST['username'];
				$password = $_POST['password'];

				$enc_email = base64_encode(openssl_encrypt($email, $method, $enc_ekey, OPENSSL_RAW_DATA, $iv));
				$dec_email = openssl_decrypt(base64_decode($enc_email), $method, $enc_ekey, OPENSSL_RAW_DATA, $iv);

				$enc_pass = base64_encode(openssl_encrypt($password, $method, $enc_ekey, OPENSSL_RAW_DATA, $iv));
				$dec_pass = openssl_decrypt(base64_decode($enc_pass), $method, $enc_ekey, OPENSSL_RAW_DATA, $iv);
			
				$sql ="INSERT INTO user_accounts (email, username, password, ekey ) VALUES(:email,:username,:password, :ekey)";	

				$stmtinsert = $db->prepare($sql);
				$stmtinsert->bindParam(':email', $enc_email);
				$stmtinsert->bindParam(':username', $username);
				$stmtinsert->bindParam(':password', $enc_pass);
				$stmtinsert->bindParam(':ekey', $enc_ekey);
				$result = $stmtinsert->execute();

				if($result){
				echo 'Successfully saved.';
				}else{
				echo 'Failed.';
				}

			}
			else {
				echo "Failed. Password doesn't match.";
			}
			
			}else{
				echo "No data";
			}
?>	