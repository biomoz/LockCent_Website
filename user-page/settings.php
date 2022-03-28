<?php

use LDAP\Result;

session_start();

	if(!isset($_SESSION['userlogin'])){
		header("Location: login.php");
	}

	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION);
		header("Location: ../useraccounts-master/login.php");
	}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    
    <title>LockCent | User</title>
  </head>
  <body>
    <!-- top navigation bar -->
    <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    
    <title>LockCent | User</title>
  </head>
  <body>
  <div>
		<?php
		require_once('../useraccounts-master/config.php');
    $username = $_SESSION['username'];
    
    if(isset($_POST['submit'])){
      
      
      $sql = "SELECT username, ekey, email FROM user_accounts WHERE username='$username'";
      $result = $db->query($sql);
      
      if ($result->rowCount() > 0) {
        // output data of each row
        if($row = $result->fetch(PDO::FETCH_ASSOC)) {
       
        $enc_ekey= (binary)$row["ekey"];
        $email= $row["email"];
        }
      } 
      
      $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
      $method = 'aes-256-cbc';
      
      $password = base64_encode(openssl_encrypt($_POST['c_password'], $method, $enc_ekey, OPENSSL_RAW_DATA, $iv));
      
      $sql = "SELECT * FROM user_accounts WHERE username = '$username' AND password = ? LIMIT 1";
      $stmtselect  = $db->prepare($sql);
      $result = $stmtselect->execute([$password]);
      
      if($result){
        $user = $stmtselect->fetch(PDO::FETCH_ASSOC);
        if($stmtselect->rowCount() > 0){

          if ($_POST['n_password'] === $_POST['re-n_password']) {
            $method = 'aes-256-cbc';
            $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    
            $password = $_POST['n_password'];
    
            $enc_email = base64_encode(openssl_encrypt($email, $method, $enc_ekey, OPENSSL_RAW_DATA, $iv));
			    	$dec_email = openssl_decrypt(base64_decode($enc_email), $method, $enc_ekey, OPENSSL_RAW_DATA, $iv);

            $enc_pass = base64_encode(openssl_encrypt($password, $method, $enc_ekey, OPENSSL_RAW_DATA, $iv));
            $dec_pass = openssl_decrypt(base64_decode($enc_pass), $method, $enc_ekey, OPENSSL_RAW_DATA, $iv);
          
            $sql ="UPDATE user_accounts SET password =? WHERE username='$username'";
            $stmtselect  = $db->prepare($sql);
            $result = $stmtselect->execute([$enc_pass]);

            if($result){
              $msg = 'Successfully updated your password!';

            }
    
          }
          else {
            $error = 'Passwords do not match!';
          }
          
        }else{
          $error1 = 'Failed.';		
        }
      }else{
        $error2 = 'There were errors while connecting to database.';
      }
			
		}
 
		?>	
	</div>


    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#sidebar"
          aria-controls="offcanvasExample"
        >
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a class="navbar-brand me-auto ms-lg-0 ms-3 fw-bold" href="index.php">  <image src="../images/LockCent_w.png" alt="Logo" width="50px" class="px-lg-2"></image> LockCent</a>
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
          <ul class="d-flex ms-auto navbar-nav mr-auto mt-2 mt-lg-0">
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
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle ms-2"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                My Account
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="index.php?logout=true">Logout</a></li>
                <li>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div
      class="offcanvas offcanvas-start sidebar-nav bg-light border-0"
      tabindex="-1"
      id="sidebar"
    >
      <div class="offcanvas-body p-0">
        <nav class="navbar-light">
          <ul class="navbar-nav">
            <br>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3">
                CORE
              </div>
            </li>
            <li>
              <a href="index.php" class="nav-link px-3 active">
                <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                Interface
              </div>
            </li>
            <li>
              <a href="passwords.php" class="nav-link px-3 active">
                <span class="me-2"><i class="bi bi-book-fill"></i></span>
                <span>Passwords</span>
              </a>
            </li>
            <li>
              <a href="notes.php" class="nav-link px-3 active">
                <span class="me-2"><i class="bi bi-book-fill"></i></span>
                <span>Notes</span>
              </a>
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
          </ul>
        </nav>
      </div>
    </div>
    <!-- offcanvas -->

    <main class="mt-5 pt-3">
      <div style="max-height: 100%; max-width:80%; margin: 0 auto; padding: 10px; background-color: rgba(150, 147, 147, 0.5);"class="container-fluid">
      <br><br>
        <div class="row">
          <div class="col-md-12 text-white">
            <h4>Settings</h4>
            <hr class="mb-3">
            <p><?php echo $username."'s settings" ?></p>
          </div>
        </div>
        <form action="#" method="post"> 
          <div class="row">
            <div class="col-sm-5" style="color: white;">
              <br>
              <h5>Change password</h5>
              <hr class="mb-3">
              <label for="c_password">Current Password</label>
              <input class="form-control" id="c_password"  type="password" name="c_password" required>

              <label for="n_password">New Password</label>
              <input class="form-control" id="n_password"  type="password" name="n_password" required>

              <label for="re-n_password">Confirm New Password</label>
              <input class="form-control" id="re-n_password"  type="password" name="re-n_password" required>
              <hr class="mb-1">
              <?php if(isset($error)){echo '<p class="alert-danger rounded p-3">'.$error.'</p>';}?>
              <?php if(isset($error1)){echo '<p class="alert-danger rounded p-3">'.$error1.'</p>';}?>
              <?php if(isset($error2)){echo '<p class="alert-danger rounded p-3">'.$error2.'</p>';}?>
              <?php if(isset($msg)){echo '<p class="alert-success rounded p-3">'.$msg.'</p>';}?>
              <input class="btn btn-primary" type="submit" id="submit" name="submit" value="Submit">
            </div>
          </div>
		    </form>
        <form action="delete.php" method="post" onsubmit="return confirm('Are you sure to delete your account?');"> 
          <div class="row">
            <div class="col-sm-5" style="color: white;">
              <br>
              <h5>Delete Account</h5>
              <hr class="mb-3">
              <input type="hidden" name="username" value="<?php echo $username ?>" />
              <input class="btn btn-danger remove-record" type="submit" id="delete" name="delete" value="Delete">
            </div>
          </div>
		    </form>
      </div>
    </main>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
  </body>
</html>
