<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LockCent | About Us</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="Feedback.css"  rel="stylesheet">
  </head>
  <nav class="navbar navbar-expand-lg navbar-light bg-light" >
    <div class="navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="LockCent.html">  <image src="images/LockCent_w.png" alt="Logo" width="50px" class="px-lg-2"></image> LockCent</a>
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="LockCent.html">Home </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://github.com/LynxarA-Coding/LockCent/releases">Download</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="useraccounts-master/registration.php">Register</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Feedback</a>
          </li>
        <li class="nav-item">
          <a class="nav-link" href="AboutUs.html">About Us</a>
        </li>
      </div>
  </nav>
    </div>
    
    
  <body style="min-width: 1200px; ">

<?php 
  if(isset($_POST['send'])){
      $to = "sup.lockcent@outlook.com"; // this is your Email address
      $from = $_POST['email']; // this is the sender's Email address
      $username = $_POST['username'];
      $rating = $_POST['RadioOptions'];
      $subject = "Form submission";
      $subject2 = "Copy of your form submission";
      $message = "Username: ". $username ."\n\nRating: " . $rating . "\n\nComments: " . "\n\n" . $_POST['Textarea'];
      $message2 = "Here is a copy of your message " . $username . "\n\nRating: " . $rating . "\n\nComments: " . "\n\n" . $_POST['Textarea'];

      $headers = "From:" . $from;
      $headers2 = "From:" . $to;
      $send =mail($to,$subject,$message,$headers);
      
      if ($send)
      {
        echo "Mail Sent. Thank you " . $username ;
        $send2 =mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
      }
      else
        echo "Error";
      }
?>

    <div style="max-height: 100%; max-width:80%; margin: 0 auto; padding: 10px; background-color: rgba(150, 147, 147, 0.5);">
        <div class="container"> 
            <br>  
            <h1>Feedback:</h1>
            <hr class="mb-3">
            <form action="" method="post">
                <div class="form-group">
                <label for="email"><b>Email address</b></label>
                <input type="email" class="form-control" id="email" name="email">
                </div>
                <br>
                <div class="form-group">
                <label for="username"><b>Username</b></label>
                <input type="text" class="form-control" id="username" name="username">
                </div>
                <br>
                <div class="form-group">
                <label for="form-check form-check-inline"><b>How was your experience with our project?</b></label>
                <br>
                <div class="form-group">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="RadioOptions" id="inlineRadio1" value="option1">
                    <label class="form-check-label" for="inlineRadio1">Very Bad</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="RadioOptions" id="inlineRadio2" value="option2">
                    <label class="form-check-label" for="inlineRadio2">Bad</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="RadioOptions" id="inlineRadio3" value="option3">
                    <label class="form-check-label" for="inlineRadio3">Average</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="RadioOptions" id="inlineRadio4" value="option4">
                    <label class="form-check-label" for="inlineRadio4">Good</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="RadioOptions" id="inlineRadio5" value="option5">
                    <label class="form-check-label" for="inlineRadio5">Very Good</label>
                  </div>
                </div>
                <br>
                <div class="form-group">
                <label for="Textarea1"><b>Comments:</b></label>
                <textarea class="form-control" id="Textarea" name="Textarea" rows="5"></textarea>
                </div>
                
				<hr class="mb-3">
				<input class="btn btn-primary" type="submit" id="send" name="send" value="Send">
            </form>
        </div>
    </div>
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    
  </body>
</html>
