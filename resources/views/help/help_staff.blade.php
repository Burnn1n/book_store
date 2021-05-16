@extends('layouts.master')
@section('content')
<?php
include('C:\xampp\htdocs\projects\Laravel\book\app\Http\Controllers\commonFunctions.php');
$db = new db();

//newtreegu bol butsaagdana
if(empty($_SESSION['user_id'])){
	header("Location: /login");
	exit;
}
// text submit hiih uyd
if(!empty($_GET['req'])){
	$id = $_SESSION['user_id'];
	$txt = $_GET['req'];
	$sql = "INSERT INTO qa(qa_text,qa_user)VALUES('$txt',$id)";
	mysqli_query($db->conn,$sql);
	echo "<script>alert('amjilttai')</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Хүсэлтүүд</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="card">
			<div class="card-header bg-transparent"><div class="col-sm-6"><h3>Хүсэлтүүд</h3></div></div>
			<div class="card-body">
					{{ csrf_field()}}
					<table class='table table-striped mt-3'>
					<tr>
					<th>email</th>
					<th>text</th>
					</tr>
					<?php
						$sql = "SELECT * FROM qa";
						$result = mysqli_query($db->conn,$sql);
						while($row = mysqli_fetch_assoc($result)){
							$user = $row['qa_user'];
							$sql = "SELECT user_email from users where id = $user";
							$user = $db->single_value($sql);
							$txt = $row['qa_text']; 
							echo "<tr><td>$user</td><td>$txt</td></tr>";
						}
					?>
					</table>
					
			</div>
		</div>
	</div>
</body>
</html>
@endsection