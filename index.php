<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
	$user_login->redirect('home.php');
}

if(isset($_POST['btn-login']))
{
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);
  $lat   = $_POST['lat'];
  $lng   = $_POST['lng'];
	
	if($user_login->login($email,$upass,$lat,$lng))
	{
		$user_login->redirect('home.php');
	}
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Login </title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
    
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <style type="text/css">
      .field-group {
    margin-top:15px;
  }
    </style>

    <script type="text/javascript">
      function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    document.getElementById("lat").value = pos.lat;
                    document.getElementById("lng").value = pos.lng;
                });

            }

        }

        
    </script>

  </head>
  <body id="login" onload="getLocation()">
    <div class="container">
		
        <form class="form-signin" method="post">
        <?php
        if(isset($_GET['error']))
		{
			?>
            <div class='alert alert-success'>
				<button class='close' data-dismiss='alert'>&times;</button>
				<strong>Wrong Details!</strong> 
			</div>
            <?php
		}
		?>
        <h2 class="form-signin-heading">Sign In.</h2><hr />
        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>" required />
        <input type="password" class="input-block-level" placeholder="Password" name="txtupass" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" required />
     	<hr />
      <div class="field-group">
    <div><input type="checkbox" name="remember" id="remember" <?php if(isset($_COOKIE["email"])) { ?> checked <?php } ?> />
    <label for="remember-me">Remember me</label>
    <input type="hidden" name="lat" id="lat" > <input type="hidden" name="lng" id="lng" >
  </div>
        <button class="btn btn-large btn-primary" type="submit" name="btn-login">Sign in</button>
        <a href="signup.php" style="float:right;" class="btn btn-large">Sign Up</a><hr />
      </form>

    </div> <!-- /container -->
    <script src="bootstrap/js/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </body>
</html>