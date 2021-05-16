@extends('layouts.master')
@section('content')
<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include('C:\xampp\htdocs\projects\Laravel\book\app\Http\Controllers\commonFunctions.php');
$db = new db();

$arr = array('Админ','Худалдагч','Үйлчлүүлэгч');
//erhgui hereglechdiig butsaah
if(!empty($_SESSION['user_id'])){
	if($_SESSION['user_type'] == 3){
		if($_SESSION['user_id'] != $user_id){
			header("Location: /");
			exit;
		}
	}
	else if($_SESSION['user_type']==1){
		if(isset($_GET['delete'])){
			$sql = "DELETE FROM users WHERE id = $user_id";
			mysqli_query($db->conn,$sql);
			header("Location: /users");
				exit;
		}
	}
}
else{
	header("Location: /login");
	exit;
}



$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($db->conn,$sql);
while($row = mysqli_fetch_assoc($result)){
	$name = $row["user_name"];
	$email = $row["user_email"];
	$phone = $row["user_phone"];
	$wallet = $row["user_wallet"];
	$password = $row["user_password"];
	$address = $row["user_address"];
	$user_type = $row["user_type_id"];
}

$sql = "select user_type_name from user_type where id = $user_type";
$result = mysqli_query($db->conn,$sql);
$row = mysqli_fetch_row($result);
$type_name = $row[0];

//edit-g darah uyd
if (isset($_GET['edit']))	$_SESSION['edit_user'] ='true';
//cancel-g darah uyd
if(isset($_GET['cancel'])){
	$_SESSION['edit_user'] = null;
}

$success = $error = "";
// save-g darah uyd
if(isset($_GET['save'])){
	$c1 = $_GET['name'];
	//herew admin busdiin medeelliig oorchloh uyd login session-ii medeelluudiig oorchlohgui baih
	//zowhon admin busdiin medeelluudiig oorchilj chadah uchir
	//door uzuulsneer ooriin medeelliih zasah uyd login session-ii utguud mun oorchlogdono ogogdliin
	//sand oorchlogdhiin zeregtsee
	if($_SESSION['user_type']!=1 and $_SESSION['user_id'] == $user_id)
		$_SESSION['user_name'] = $c1;
	$c2 = $_GET['phone'];
	$c3 = $_GET['address'];
	$c5 = $_GET['password'];
	//admin bol
	if($_SESSION['user_type']==1){
		$c4 = $_GET['wallet'];
		$c6 = $_GET['role_select'];
		$key = array_search($c6, $arr) + 1;
		if(!empty($c1)&&!empty($c2)&&!empty($c3)&&($c4==0or!empty($c4))&&!empty($c5)){
			$sql = "update users set user_name = '$c1',user_phone = '$c2',user_address = '$c3',user_wallet = '$c4',
			user_password='$c5',updated_at = NOW(),user_type_id='$key' WHERE id = '$user_id'";
			mysqli_query($db->conn,$sql);
			$_SESSION['edit_user'] = null;
			header("Location: /user/$user_id");
			exit;
		}
		else{
			$error = "Оролтууд хоосон байж болохгүй";
		}
	}
	else{
		if(!empty($c1)&&!empty($c2)&&!empty($c3)&&!empty($c5)){
			$sql = "update users set user_name = '$c1',user_phone = '$c2',user_address = '$c3',
			user_password='$c5',updated_at = NOW() WHERE id = '$user_id'";
			mysqli_query($db->conn,$sql);
			$_SESSION['edit_user'] = null;
			header("Location: /user/$user_id");
			exit;
		}
		else{
			$error = "Оролтууд хоосон байж болохгүй";
		}

	}
	
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>{{$name}}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		
		input{
			width: 200%;
		}
					.nm{
			white-space:nowrap;
		}
		table {border: none;
			margin-left:90px;
			width: 100%;
		}
		.desc{
			font-weight:bold;
		}
		.nm{
			white-space:nowrap;
		}
		.button{
			width: 100%;
			background-color: #f4511e;
  		border: none;
  		color: white;
			padding: 16px 32px;
  		text-align: center;
  		font-size: 16px;
  		margin: 4px 2px;
  		opacity: 0.6;
  		transition: 0.3s;
		}
		button:hover {opacity: 1}
		td{padding: 15px;}
		textarea{
			width: 100%;
		}
		.error {color: #FF0000;}
		.success{color:green;}
		.tab {
  		float: left;
 		 	border: none;
  		background-color: #2F4F4F;
  		width: 20%;
  		height: 100%;
			
		}
		/* Style the buttons inside the tab */
		.tab button {
			font-weight: bold;
			display: block;
			background-color: white;
			color: black;
  		padding: 22px 16px;
  		width: 100%;
  		border: none;
  		outline: none;
  		text-align: left;
  		cursor: pointer;
  		transition: 0.3s;
  		font-size: 17px;
		}
		/* Change background color of buttons on hover */
		.tab button:hover {
  		background-color: #ddd;
		}
		/* Create an active/current "tab button" class */
		.tab button.active {
  		background-color: #A52A2A;
		}
	</style>
</head>
<body>
	<div class="tab">
		<button class="active" onclick="parent.location='http://localhost:8000/user/{{$user_id}}'" id="stud">ЕРӨНХИЙ МЭДЭЭЛЭЛ</button>
		<button onclick="parent.location='http://localhost:8000/user/{{$user_id}}/order'" id="srch">ЗАХИАЛГУУД</button>
		<button onclick="parent.location='http://localhost:8000/user/{{$user_id}}/rent'" id="srch">ТҮРЭЭСҮҮД</button>
	</div>
	<div class="container">
		<div class="card">
			<div class="card-header bg-transparent"><div class="col-sm-6"><h3>ЕРӨНХИЙ МЭДЭЭЛЭЛ</h3></div></div>
			<div class="card-body">
				<form action="/user/{{$user_id}}" method="GET">
					<div class="row">
						<div class='col-sm-8'>
							<table cellspacing='0' cellpadding='0'>
								<tbody>
									<tr>
										<td class ='nm'>Нэр:</td>
										<td class='desc'><?php echo (!isset($_SESSION['edit_user']))?$name:
										"<input class='form-control' type = 'text' value='$name' name='name'>";?></td>
									</tr>
									<tr>
										<td class ='nm'>И-Мэйл:</td>
										<td class='desc'>{{$email}}</td>
									</tr>
									<tr>
										<td class ='nm'>Утасны дугаар:  </td>
										<td class='desc'>
										<?php echo(!isset($_SESSION['edit_user']))?$phone:"<input class='form-control' type = 'text' value='$phone' name='phone'>";?>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Хаяг:</td>
										<td class='desc'><?php 
										echo(!isset($_SESSION['edit_user']))?$address:"<textarea  class='form-control' name='address'>$address</textarea>";
										?></td>
									</tr>
									<tr>
										<td class ='nm'>Цахим хэтэвч:</td>
										<td class='desc'><?php
										if(isset($_SESSION['edit_user'])and$_SESSION['user_type'] == 1)
											echo "<input class='form-control' type='number' value='$wallet' name='wallet'>";
										else	echo $wallet;
										?>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Нууц үг:</td>
										<td class='desc'><?php echo(!isset($_SESSION['edit_user']))?$password:"<input class='form-control' type='text'name='password'value='$password'>";
										?></td>
									</tr>
									<?php
									if($_SESSION['user_type'] == 1){
										if(isset($_SESSION['edit_user'])){
											echo"
											<tr>
											<td class ='nm'>Эрх өгөх:</td>
											<td class='desc'>";
											echo "<select class='form-control' name='role_select'>";
											foreach($arr as $value){
												if($type_name == $value){
													echo "<option selected='selected' value = '$value'>$value</option>";
												}
												else{
													echo "<option value = '$value'>$value</option>";
												}
												
											}
											echo"</select></td></tr>";
										}
										
									}
									?>
								</tbody>
							</table>
							<div class='row' style='margin-left:90px;'>
								<div class='col-sm-12'>
									<p><span class = 'success'>{{$success}}</span></p>
									<p><span class = 'error'>{{$error}}</span></p>
								</div>
								<div class='col-sm-6' style='float:left;'>
									<?php
										if(isset($_SESSION['edit_user'])){
											echo "<input class='button'type='submit'name='cancel' value='Болих'>";
											echo"</div>
											<div class='col-sm-6' style='float:left;'>";	
											echo "<input class='button'type='submit'name='save' value='Хадгалах'>";
										}
										else{
											if($_SESSION['user_type'] == 2){
												if($_SESSION['user_id'] == $user_id){
													echo "<input class='button'type='submit'name='edit' value='Өөрчлөх'></div>";
												}
											}
											else{
												echo "<input class='button'type='submit'name='edit' value='Өөрчлөх'></div>";
											}
										}
								?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div> 
</body>
</html>
@endsection