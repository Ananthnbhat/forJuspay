<?php
session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
	$reg_user->redirect('home.php');
}


if(isset($_POST['btn-signup']))
{
	$fname = trim($_POST['txtuname']);
	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtpass']);
	$num   = trim($_POST['number']);
	$type  = $_POST['type'];
	$lat   = $_POST['lat'];
	$lng   = $_POST['lng'];
	
	$stmt = $reg_user->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
	$stmt->bindparam(":email_id",$email);
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() > 0)
	{
		$msg = "
		      <div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry !</strong>  email allready exists , Please Try another one
			  </div>
			  ";
	}
	else
	{
		if($reg_user->register($fname,$email,$upass,$num,$type,$lat,$lng))
		{			
			$message = "Succesfully registerd";
		}
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Signup | Scryptonite</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
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
				<?php if(isset($msg)) echo $msg;  ?>
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        <input type="text" class="input-block-level" placeholder="Full Name" name="txtuname" required />
        <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
        <input type="number" name="number" class="input-block-level" placeholder="Contact number" required/>
        <input type="password" class="input-block-level" placeholder="Password" name="txtpass" required />
        I'm a <br>
        <input type="radio" name="type" value="Teacher">&nbspTeacher &nbsp;
        <input type="radio" name="type" value="Student">&nbspStudent
        <input type="hidden" name="lat" id="lat" > <input type="hidden" name="lng" id="lng" >

     	<hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
        <a href="index.php" style="float:right;" class="btn btn-large">Sign In</a>
      </form><br>
      <span><?php if(isset($message)){echo $message;} ?></span>

    </div> <!-- /container -->
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    
  </body>
</html>