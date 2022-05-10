<?php 

session_start();
require_once('../useraccounts-master/config.php');
	if(!isset($_SESSION['userlogin'])){
		header("Location: login.php");
	}

	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION);
		header("Location: ../useraccounts-master/login.php");
	}
  $username= $_SESSION['username'];
  $sql = "SELECT username, ekey FROM user_accounts WHERE username='$username'";
  $result = $db->query($sql);
  
  $row = $result->fetch(PDO::FETCH_ASSOC);
   
  $enc_ekey= (binary)$row["ekey"];

  if(isset($_POST['addtxt'])){
    $method = 'aes-256-cbc';
    $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    
     $n_notes = $_POST['addtext'];
      
       $sql = "SELECT username, passwords FROM user_data WHERE username='$username'";
       $result = $db->query($sql);
       
       if ($result->rowCount() > 0) {
        
         $row = $result->fetch(PDO::FETCH_ASSOC);
         $enc_passwords = $row["passwords"];}
         else{
          $enc_passwords=0;
         }

       if ($enc_passwords===0){
       $dec_passwords = "0 results";
       $enc_passwords = base64_encode(openssl_encrypt($dec_passwords, $method, $enc_ekey, OPENSSL_RAW_DATA, $iv));


       $dec_notes =  $n_notes;
       $notes = base64_encode(openssl_encrypt($dec_notes, $method, $enc_ekey, OPENSSL_RAW_DATA, $iv));

       $sql ="INSERT INTO user_data (username, passwords, notes ) VALUES(:username,:passwords,:notes)";	

       $stmtinsert = $db->prepare($sql);
       $stmtinsert->bindParam(':username', $username);
       $stmtinsert->bindParam(':passwords', $enc_passwords);
       $stmtinsert->bindParam(':notes', $notes);
       $result=$stmtinsert->execute();
       }
       else{
        
        $n_notes = $_POST['addtext'];                
        $dec_notes =  $n_notes;
        $notes = base64_encode(openssl_encrypt($dec_notes, $method, $enc_ekey, OPENSSL_RAW_DATA, $iv));

         $sql ="UPDATE user_data SET notes =? WHERE username='$username'";
         $stmtselect  = $db->prepare($sql);
         $result=$stmtselect->execute([$notes]);

       }
       if($result){
        $msg = 'Successful!';
      }else{
        $error = 'Failed.';
      }
       header("Refresh:0");

      }

      //API
      $link_a = "http://localhost/LockCent_Website/user-page/api/apiHandler.php?action=outputData&username=$username";

      $client = curl_init("http://localhost/LockCent_Website/user-page/api/apiHandler.php?action=outputData&username=$username");
      curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($client);
      $output = '';
      $output .= $response;




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
                <li><a class="dropdown-item" href="settings.php">Settings</a></li>
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
              <a href="#" class="nav-link px-3 active">
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
      <div class="container-fluid">
      <br><br>
        <div class="row">
          <div class="col-md-12 text-white">
            <h4>Notes</h4>
            <hr class="mb-3">
            <p><?php echo $username ."'s notes:" ;?></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 mb-3">
            <form action="notes.php" name="notes" method="post">
            <div class="card">
              <div class="card-header text-black">
                <span><i class="bi bi-table me-2"></i></span> Notes
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table
                    id="example"
                    class="table table-striped"
                    style="width: 100%">
                    <tbody>
                    <div class="form-group">
                    <textarea class="form-control" 
                        id="addtext" name="addtext" rows="15"><?php echo $output ?></textarea>
                    </textarea>
                    </div>
                    </tbody>     
                    <input type="hidden" name="username" value="<?php echo $username ?>" />
                    <hr class="mb-1">
                  <?php if(isset($error)){echo '<p class="alert-danger rounded p-3">'.$error.'</p>';}?>
                  <?php if(isset($msg)){echo '<p class="alert-success rounded p-3">'.$msg.'</p>';}?>
                  <input class="btn btn-primary" type="submit" id="addtxt" name="addtxt" value="Save Note">
                  </table>
                </div>
              </div>
            </div>
            </form>
               
            </div>
        </div>
          </div>
        </div>
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
