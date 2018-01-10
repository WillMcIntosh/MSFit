<!DOCTYPE html>
<html lang="en">
<!-- html template from getbootstrap.com  -->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head 
    content must come *after* these tags -->
    <title>Contact Us</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
  </head>
  <body>

    <!-- create Nav bar -->
    <nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.html"><img class="logo" 
            src="images/logo.jpeg" alt="company logo"></a>
          <!-- type button is for assistive tech -->
          <button type="button" class="navbar-toggle"
            data-target="#navbarCollapse" data-toggle="collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbarCollapse" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.html">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="schedule.html">Schedule</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Create header -->
    <div class="jumbotron">
      <div class="container" id="pageContent">
        <h1>Contact Us</h1>
      </div>
    </div>
    

<?php

$secrets = parse_ini_file(realpath(__DIR__ . "/../private/secrets.ini"));

// mysqli_connect ( host, username, pw, databasename)
$link = mysqli_connect($secrets[host], $secrets[username], $secrets[pw], 
    $secrets[databasename]) or die("Error. Unable to connect: 
    " . mysqli_connect_error());

?>
       
<?php
// define all user inputs
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];

// error messages
$missingFirstname = "<p><strong>Please enter your firstname</strong></p>";
$missingLastname = "<p><strong>Please enter your lastname</strong></p>";
$missingEmail = "<p><strong>Please enter your email</strong></p>";
$invalidEmail = "<p><strong>Please enter a valid email</strong></p>";

// check for errors
if($_POST["submit"]) {
  if(!$firstname) {
    $errors .= $missingFirstname;
  } else {
    $firstname = filter_var($firstname, FILTER_SANITIZE_STRING);
  }

  if(!$lastname) {
    $errors .= $missingLastname;
  } else {
    $lastname = filter_var($lastname, FILTER_SANITIZE_STRING);
  }

  if(!$email) {
    $errors .= $missingEmail;
  } else {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors .= $invalidEmail;
    }
  }

  if($errors) {
    $resultsMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultsMessage;
  } else {
    // no errors, prepare variables for query
    $tblname = "signup";
    $firstname = mysqli_real_escape_string($link, $firstname);
    $lastname = mysqli_real_escape_string($link, $lastname);
    $email = mysqli_real_escape_string($link, $email);


    // execute insert query
      $sql = "INSERT INTO $tblname (firstname, lastname, email)
        VALUES ('$firstname', '$lastname', '$email')";

    if(mysqli_query($link, $sql)) {
      $resultsMessage = '<div class="alert alert-success">Data added!</div>';
    } else {
      $resultsMessage = '<div class="alert alert-warning">Error: '
        . $sql . '. ' . mysqli_error($link). ' </div>';
    }
    echo $resultsMessage;
  }
}
?>
          <form method="post">
            <div class="form-group">
              <label for="firstname">Firstname:</label>
              <input type="text" id="firstname" placeholder="Firstname"
              class="form-control" name="firstname"  maxlength="20" 
              value="<?php echo $POST["firstname"]; ?>">
            </div>
            <div class="form-group">
              <label for="lastname">Lastname:</label>
              <input type="text" id="lastname" placeholder="Lastname"
              class="form-control" name="lastname"  maxlength="20"
              value="<?php echo $POST["lastname"]; ?>">
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" id="email" placeholder="Email" 
              class="form-control" name="email"  maxlength="30"
              value="<?php echo $POST["email"]; ?>">
            </div>
            
            <input type="submit" name="submit" class="btn btn-success 
            btn-lg" value="Send data">
          </div>
    <!-- Create the footer -->
    <div class="footer">
      <div class="container-fluid">
        <p>&copy;MS Fit 2018</p>
      </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/javascript.js"></script>
  </body>
</html>


