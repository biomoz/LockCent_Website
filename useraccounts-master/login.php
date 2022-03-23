<?php 

	session_start();
	
	if(isset($_SESSION['userlogin'])){
		header("Location: index.php");
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
<nav class="navbar navbar-expand-lg navbar-light bg-light" >
		<div class="navbar-collapse" id="navbarTogglerDemo01">
		<a class="navbar-brand" href="../LockCent.html">  <image src="../images/LockCent_w.png" alt="Logo" width="50px" class="px-lg-2"></image> LockCent</a>
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<li class="nav-item active">
			<a class="nav-link" href="../LockCent.html">Home </a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="https://github.com/LynxarA-Coding/LockCent/releases">Download</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="#">Login</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="../useraccounts-master/registration.php">Register</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="../Feedback.php">Feedback</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="../AboutUs.html">About Us</a>
			</li>
		</ul>	
		</div>
	</nav>
	<div style="height: 100%; max-width:80%; margin: 0 auto; padding: 10px; background-color: rgba(150, 147, 147, 0.5);">
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
						
						<div class="form-group">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="rememberme" class="custom-control-input" id="customControlInline">
							<label class="custom-control-label" for="customControlInline">Remember me</label>
						</div>
					</div>
						<hr class="mb-3">
						<input class="btn btn-primary" type="submit" id="login" name="create" value="Login">
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
					if($.trim(data) === "1"){
						setTimeout(' window.location.href =  "index.php"', 1000);
					}
				},
				error: function(data){
					alert('there were erros while doing the operation.');
				}
			});

		});
	});
</script>
</body>
</html>