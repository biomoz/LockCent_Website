<?php
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LockCent | Registration</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../LockCent.css"  rel="stylesheet">
	
  </head>

<body>
	<div>
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
          $msg = 'Successful!';
				}else{
          $error = 'Failed.';
				}

			}
			else {
				$error1 = "Failed.Password doesn't match.";
			}
			
			}
		?>	
	</div>
	<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="container-fluid">
     
        <a class="navbar-brand me-auto ms-lg-0 ms-3 fw-bold" href="../LockCent.html">  <image src="../images/LockCent_w.png" alt="Logo" width="50px" class="px-lg-2"></image> LockCent</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#topNavBar"
          aria-controls="topNavBar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topNavBar">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link ms-2">
              </a>              
            </li>
            <li class="nav-item">
              <a
                class="nav-link ms-2"
                href="../LockCent.html"
                role="button"
                aria-expanded="false"
              >
                Home
              </a>              
            </li>
            <li class="nav-item">
              <a
                class="nav-link ms-2"
                href="login.php"
                role="button"
                aria-expanded="false"
              >
              Login
              </a>              
            </li>
            <li class="nav-item">
              <a
                class="nav-link ms-2"
                href="#"
                role="button"
                aria-expanded="false"
              >
              Register
              </a>              
            </li>
            <li class="nav-item">
              <a
                class="nav-link ms-2"
                href="https://github.com/LynxarA-Coding/LockCent/releases"
                role="button"
                aria-expanded="false"
              >
               Download
              </a>              
            </li>  
            <li class="nav-item">
              <a
                class="nav-link ms-2"
                href="../AboutUs.html"
                role="button"
                aria-expanded="false"
              >
              About Us
              </a>              
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div style="max-height: 100%; max-width:80%; margin: 0 auto; padding: 10px; background-color: rgba(150, 147, 147, 0.5);">
      <br><br><br>
		<form action="registration.php" method="post">
			<div class="container">
				
				<div class="row">
					<div class="col-sm-5">
						<br>
						<h1>Registration</h1>
						<hr class="mb-3">
						<label for="email"><b>Email Address</b></label>
						<input class="form-control" id="email"  type="email" name="email" required>

						<label for="phonenumber"><b>Username</b></label>
						<input class="form-control" id="username"  type="text" name="username" required>

						<label for="password"><b>Password</b></label>
						<input class="form-control" id="password"  type="password" name="password" required>

						<label for="password"><b>Confirm Password</b></label>
						<input class="form-control" id="re-password"  type="password" name="re-password" required>

						<hr class="mb-3">
            <?php if(isset($error)){echo '<p class="alert-danger rounded p-3">'.$error.'</p>';}?>
            <?php if(isset($error1)){echo '<p class="alert-danger rounded p-3">'.$error1.'</p>';}?>
            <?php if(isset($msg)){echo '<p class="alert-success rounded p-3">'.$msg.'</p>';}?>
						<input class="btn btn-primary" type="submit" id="register" name="create" value="Sign Up">
					</div>
				</div>
			</div>
		</form>
	</div>

</body>
</html>

