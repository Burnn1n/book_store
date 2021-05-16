@extends('layouts.master')
@section('content')
<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include('C:\xampp\htdocs\projects\Laravel\book\app\Http\Controllers\commonFunctions.php');
$db = new db();
//newtreh
$name_error = $pass_error = $error = $reg_error = $success = "";
if(isset($_GET['log'])){
	 //newtreh ner
	 $username = $_GET['email'];
	 //form-g zow bogoljuu shalgah
	 if(empty($username)){
		 $name_error = "Хэрэглэгчийн нэр оруулна уу!";
	 }
	 else if (!filter_var($username, FILTER_VALIDATE_EMAIL)) { // email-n format
		 $name_error = "И-Мэйл хаяг буруу байна";
	 }
	//sql injection - с сэргийлж байна.
  $safe_username = mysqli_real_escape_string($db->conn, $username);
	$pass=$_GET["password"];

	$sql = "select * from users where user_email='$safe_username' and user_password='$pass'";
  $result = mysqli_query($db->conn,$sql);
	//holbogdchih uyd
  if(mysqli_num_rows($result)>0){
		$sql = "select * from users where user_email = '$safe_username'";
		$result = mysqli_query($db->conn,$sql);
		$row = mysqli_fetch_assoc($result);
		//newtersen gedgiig iltgeh huwisagchuud
		$_SESSION['user_id']  = $row['id'];
		$_SESSION['user_name'] = $row['user_name'];
		$_SESSION['user_email'] = $safe_username;
		$_SESSION['user_address'] = $row['user_address'];
		$_SESSION['user_type'] = $row['user_type_id'];
		$_SESSION['user_wallet'] = $row['user_wallet'];
		header("Location: /");
		exit;
	}
	else{
		$error = "Нэвтрэлт амжилтгүй";
	}
}
//burtguuleh
if(isset($_GET['reg'])){
	//server talaas dahin oroltuud hooson esehiig nygtlah
	if(!empty($_GET['name1'])&&!empty($_GET['email1'])&&!empty($_GET['phone'])&&!empty($_GET['password1'])&&
	!empty($_GET['password2'])&&!empty($_GET['address'])){
		//reg ok
		if($_GET['password1'] == $_GET['password2']){
			//sql injection-s hamgaalj baina
			$name = mysqli_real_escape_string($db->conn, $_GET['name1']);
			$email = mysqli_real_escape_string($db->conn, $_GET['email1']);
			$phone = mysqli_real_escape_string($db->conn, $_GET['phone']);
			$password = mysqli_real_escape_string($db->conn, $_GET['password1']);
			$address = mysqli_real_escape_string($db->conn, $_GET['address']);
			$sql = "SELECT * FROM users WHERE user_email = '$email'";
			$result = mysqli_query($db->conn,$sql);
			if(mysqli_num_rows($result)>0){
				$reg_error = "И-Мэйл хаяг аль хэдийнээ бүртгэгдсэн байна";
			}
			else{
				$sql = "SELECT * FROM users WHERE user_phone = '$phone'";
				$result = mysqli_query($db->conn,$sql);
				if(mysqli_num_rows($result)>0){
					$reg_error = "Утасны дугаар аль хэдийнээ бүртгэгдсэн байна";
				}
				//mysql-d insert hiihed belen email batalgaajuulahiig huleej baina
				else{
					$_SESSION['login_name'] = $name;
					$_SESSION['login_email'] = $email;
					$_SESSION['login_phone'] = $phone;
					$_SESSION['login_password'] = $password;
					$_SESSION['login_address'] = $address;
					header("Location: /verify/$email");
					exit;
				}
			}
		}
		// 2 password-n orolt zoroh uyd
		else{
			$reg_error = "Нууц үгс таарахгүй байна";
		}
	}
	else{
		$reg_error = "Бүх оролтуудыг оруулна уу";
	}
}


// email batalgaajuulalt hiisnii daraa
if(isset($_GET['verified'])){
	$name = $_SESSION['login_name'];
	$email = strtolower($_SESSION['login_email']);
	$phone = $_SESSION['login_phone'];
	$password = $_SESSION['login_password'];
	$address = $_SESSION['login_address'];

	//shine hereglegchiig burtgeh
	$sql = "INSERT INTO users(user_name,user_email,user_phone,user_password,user_address,user_type_id,user_wallet)
	values('$name','$email',$phone,'$password','$address',3,0)";
	if(mysqli_query($db->conn,$sql))
	$success = "Амжилттай бүртгэж авлаа та одоо нэвтэрж болно";
	$reg_error = "";
	unset($_SESSION['login_name']);
	unset($_SESSION['login_email']);
	unset($_SESSION['login_phone']);
	unset($_SESSION['login_password']);
	unset($_SESSION['login_address']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Нэвтрэх</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		.error {color: #FF0000;}
		.success{color:green;}
	</style>
</head>
<body>
{{ csrf_field()}}	
	<div class="container">
	<div class="row">
					<div class="col-sm-6" style="padding:20px;">
						<form action="login" id="login" method="GET " onsubmit="return check_log();">
							<div class="form-group">
								<h2>Нэвтрэх</h2>
							</div>
							<div class="form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="И-мейлээ оруулна уу">
								<p><span class = "error" id="name_err"><?php echo $name_error; ?></span></p>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password">
								<p><span class = "error" id="pass_err"><?php echo $pass_error; ?></span></p>
								<div><span class = "error"><?php echo $error; ?></span></div>
							</div>
							<button type="submit" class="btn btn-primary" name="log">Submit</button>
						</form>
					</div>
					<div class="col-sm-6" style="padding:20px;">
						<form action="login" id="register" method="GET" onsubmit="return check_reg();">
							<div class="form-group">
								<h2>Бүртгүүлэх</h2>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" id="name1" name="name1" placeholder="Нэр">
							</div>
							<div class="form-group">
								<input type="email" class="form-control" id="email1" name="email1" placeholder="И-мейлээ хаяг">
							</div>
							<div class="form-group">
								<input type="number" class="form-control" id="phone" name="phone" placeholder="Утасны дугаар">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="password1" name="password1" placeholder="Нууц үг">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="password2" name="password2" placeholder="Нууц үг давтана уу">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" id="address" name="address" placeholder="Хаяг">
								<p><span class = "error" id="reg_err"><?php echo $reg_error; ?></span></p>
								<p><span class = "success"><?php echo $success; ?></span></p>
							</div>
							<button type="submit" class="btn btn-primary" name="reg">Submit</button>
						</form>
					</div>
				</div>
	</div>
</body>
</html>
<script>
//lo
  function check_log(){
    var name = document.getElementById("email").value;
    var pass = document.getElementById("password").value;
    var name_err = document.getElementById("name_err").innerHTML;
    var pass_err = document.getElementById("pass_err").innerHTML;
    //username password zow oruulsan esehiig shalgah javascript
    if(!name.length<1&& !pass.length<1){
      return true;
    }
    else{
      if(name.length<1) {document.getElementById("name_err").innerHTML = "Хэрэглэгчийн нэр оруулна уу!";}

      else if(!re.test(name)) {document.getElementById("name_err").innerHTML = "И-Мэйл хаяг буруу байна";}
    
      else {document.getElementById("name_err").innerHTML = "";}
    
      if(pass.length<1){ document.getElementById("pass_err").innerHTML = "Нууц үг оруулна уу!";}
    
    else {document.getElementById("pass_err").innerHTML = "";}
      return false;
    }
  }
	function check_reg(){
		var name = document.getElementById("name1").value;
		var email = document.getElementById("email1").value;
		var phone = document.getElementById("phone").value;
		var address = document.getElementById("address").value;
    var pass = document.getElementById("password1").value;
		var pass1 = document.getElementById("password2").value;
    var name_err = document.getElementById("name_err").innerHTML;
    var pass_err = document.getElementById("pass_err").innerHTML;
    //username password zow oruulsan esehiig shalgah javascript
    if(!email.length<1&&!name.length<1&&!phone.length<1&&!address.length<1&&!pass.length<1&&!pass1.length<1){
			if(pass == pass1){
				return true
			}
			else{
				document.getElementById("reg_err").innerHTML = "Нууц үгс таарахгүй байна";
				return false;
			}	
    }
    else{
      document.getElementById("reg_err").innerHTML = "Бүх оролтуудыг оруулна уу";
      return false;
    }

	}
</script>
@endsection