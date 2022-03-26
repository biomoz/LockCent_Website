<?php 

	session_start();
	
	if(isset($_SESSION['userlogin'])){
		header("Location: ../user-page/index.php");
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>LockCent | Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../LockCent.css"  rel="stylesheet">
</head>
<body>
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
                href="#"
                role="button"
                aria-expanded="false"
              >
              Login
              </a>              
            </li>
            <li class="nav-item">
              <a
                class="nav-link ms-2"
                href="registration.php"
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
						<h1>Login</h1>
						<hr class="mb-3">
						
						<label for="phonenumber"><b>Username</b></label>
						<input class="form-control" id="username"  type="text" name="username" required>

						<label for="password"><b>Password</b></label>
						<input class="form-control" id="password"  type="password" name="password" required>
                        
						<hr class="mb-3">
						<input class="btn btn-primary" type="submit" id="login" name="login" value="Login">
					</div>
				</div>
				<div class="mt-4">
				<div class="d-flex links">
					Don't have an account? -><a href="registration.php" class="ml-2">Sign Up</a>
				</div>
				<div class="d-flex">
					<a href="#">Forgot your password?</a>
				</div>
			</div>
			</div>
		</form>
	</div>
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
	$(function(){
		$('#login').click(function(e){

			var valid = this.form.checkValidity();

			if(valid){
				var username = $('#username').val();
				var password = $('#password').val();
			}

			e.preventDefault();

			$.ajax({
				type: 'POST',
				url: 'jslogin.php',
				data:  {username: username, password: password},
				success: function(data){
					alert(data);
					if($.trim(data) === "Succesfull"){
						setTimeout(' window.location.href =  "../user-page/index.php"', 10);
					}
				},
				error: function(data){
					alert('The username or password is incorrect');
				}
			});

		});
	});
</script>
</body>
</html>