@extends('layouts.master')
@section('content')
<?php
include('C:\xampp\htdocs\projects\Laravel\book\app\Http\Controllers\commonFunctions.php');
$db = new db();

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if(!empty($_SESSION['user_id'])){
	if($_SESSION['user_type'] == 3){
		header("Location: /");
		exit;
	}
}
else{
	header("Location: /login");
	exit;
}



$img_admin = 'https://thumbs.dreamstime.com/b/admin-icon-trendy-design-style-isolated-white-background-vector-simple-modern-flat-symbol-web-site-mobile-logo-app-135742404.jpg';
$img_cashier = 'https://thumbs.dreamstime.com/b/cashier-machine-icon-vector-isolated-white-background-your-web-mobile-app-design-cashier-machine-logo-concept-cashier-134155251.jpg';
$img_user = 'https://icon-library.com/images/my-account-icon/my-account-icon-18.jpg';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Хэрэглэгчид</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
		<style>
			.table a.table-link.danger {
				color: #fe635f;
			}
			.table a.table-link.danger:hover {
				color: #dd504c;
			}
		</style>
	</head>
	<body>
		
		<div class="container">
			<div class="card">
				<div class="card-header bg-transparent"><div class="col-sm-6"><h3>Бүх хэрэглэгчид</h3></div></div>
				<div class="card-body">
					<div class="row">
						{{ csrf_field()}}
						<div class='col-sm-12'>
						<form action="/user" method="GET">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-11">
										<input type = "number" class="form-control"name = "result"placeholder="Утасны дугаарар хайх"required>
									</div>
									<div class="col-sm-1">
										<input type="image" src="https://logoeps.com/wp-content/uploads/2014/08/2074-google-web-search-icon-vector-icon-vector-eps.png"
						 				alt="submit" name="submit" width="44" height="43">
									</div>
								</div>
							</div>
						</form>
						</div>
						@if(isset($_GET['result']))
						<div class='col-sm-12'style=';margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'>Хайлтын илэрц</div>
						<div class='col-sm-12'>
							<table class='table table-striped mt-3'>
								<tr><th>Нэр</th><th>И-мэйл</th><th>Утасны дугаар</th><th>Хэтэвч</th><th>Удирдах</th></tr>
								</div>
							<?php
								$phone = $_GET['result'];
								$sql = "SELECT * FROM users WHERE user_phone LIKE '$phone%'";
								$db->print_user($img_user,$sql,3,$_SESSION['user_type']);
							?>
							</table>
						
						@else
						<div class='col-sm-12'style=';margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'>Захиалга баталгаажсан хэрэглэгчид</div>
						<div class='col-sm-12'>
							<table class='table table-striped mt-3'>
								<tr><th>Нэр</th><th>И-мэйл</th><th>Утасны дугаар</th><th>Удирдах</th></tr>
								<?php
								$sql = "SELECT order_user_id FROM orders WHERE order_tuluw_id = 3";
								$result = mysqli_query($db->conn,$sql);
								while($row = mysqli_fetch_row($result)){
									$user_id = $row[0];
									$sql = "SELECT * FROM users WHERE id = $user_id";
									$db->print_user($img_user,$sql,3,$_SESSION['user_type']);
								}
								?>
							</table>
						</div>
						<div class='col-sm-12'style=';margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'>Админ</div>
						<div class='col-sm-12'>
							<table class='table table-striped mt-3'>
								<tr><th>Нэр</th><th>И-мэйл</th><th>Утасны дугаар</th><th>Удирдах</th></tr>
								<?php
								$sql = 'SELECT * FROM users WHERE user_type_id = 1';
								$db->print_user($img_admin,$sql,null,$_SESSION['user_type']);
								?>
							</table>
						</div>
						<div class='col-sm-12'style=';margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'>Худалдагч</div>
						<div class='col-sm-12'>
							<table class='table table-striped mt-3'>
								<tr><th>Нэр</th><th>И-мэйл</th><th>Утасны дугаар</th><th>Удирдах</th></tr>
								<?php
								$sql = 'SELECT * FROM users WHERE user_type_id = 2';
								$db->print_user($img_cashier,$sql,null,$_SESSION['user_type']);
								?>
							</table>
						</div>
						<div class='col-sm-12'style=';margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'>Хэрэглэгч</div>
						<div class='col-sm-12'>
							<table class='table table-striped mt-3'>
								<tr><th>Нэр</th><th>И-мэйл</th><th>Утасны дугаар</th><th>Хэтэвч</th><th>Удирдах</th></tr>
								<?php
								$sql = 'SELECT * FROM users WHERE user_type_id = 3';
								$db->print_user($img_user,$sql,3,$_SESSION['user_type']);
								?>
							</table>
						</div>
						@endif
						

						
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Хэрэглэгчийг устгахдаа итгэлтэй байна уу?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>
@endsection