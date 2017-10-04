<?php

require_once 'dbconfig.php';

class USER
{	

	private $conn;
	private $salt = '802ae2e14dec8189740aa497c944bb8e';

	public function Secured_password($upass)
	{
		try {
			
			$upass = hash('sha512', $upass);
			$saltedPass = $this->salt . $upass;
			$hashedPass = hash('sha512', $saltedPass);
			return $hashedPass;
		
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function __construct()
	{

		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	
	public function register($fname,$email,$upass,$num,$type,$lat,$lng)
	{
		try
		{							
			
			$password = $this->Secured_password($upass);
			$stmt = $this->conn->prepare("INSERT INTO tbl_users(fullName,userEmail,num,userPass,type,lat,lng) 
			                                             VALUES(:user_name, :user_mail, :num, :user_pass, :type, :lat, :lng)");
			$stmt->bindparam(":user_name",$fname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password); $stmt->bindparam(":num",$num);
			$stmt->bindparam(":type",$type); $stmt->bindparam(":lat",$lat); $stmt->bindparam(":lng",$lng);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	public function login($email,$upass,$lat,$lng)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				
					if($userRow['userPass']==$this->Secured_password($upass))
					{
						$_SESSION['userSession'] = $userRow['userID'];
						$update = $this->conn->prepare("UPDATE tbl_users SET lat = :lat, lng = :lng WHERE userID = ".$userRow['userID']." ");
						$update->bindparam(":lat", $lat); $update->bindparam(":lng", $lng);
						$update->execute();
						
						if(!empty($_POST['remember'])){
							setcookie ("email",$email,time()+ (30 * 24 * 60 * 60)); //30 days
							setcookie ("password",$upass,time()+ (30 * 24 * 60 * 60)); //30 days
						} else {
							@setcookie("email","");
							@setcookie("password","");
						}

							return true;



						
					} else {
					
						header("Location: index.php?error");
						exit;
					}
					
				
				
			}
			else
			{
				header("Location: index.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function logout()
	{
		session_destroy();
		$_SESSION['userSession'] = false;
	}
	
	function send_mail($email,$message,$subject)
	{						
		require_once('mailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                  
		$mail->SMTPSecure = "ssl";                 
		$mail->Host       = "smtp.gmail.com";      
		$mail->Port       = 465;             
		$mail->AddAddress($email);
		$mail->Username="your_gmail_id_here@gmail.com";  
		$mail->Password="your_gmail_password_here";            
		$mail->SetFrom('your_gmail_id_here@gmail.com','Coding Cage');
		$mail->AddReplyTo("your_gmail_id_here@gmail.com","Coding Cage");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}	
}