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
//text ee submit hiih uyd
if(!empty($_GET['req'])){
	$id = $_SESSION['user_id'];
	$text = $_GET['req'];
	//xss-s hamgaalah
	$text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	$sql = "INSERT INTO qa(qa_text,qa_user)VALUES('$text',$id)";
	mysqli_query($db->conn,$sql);
	echo "<script>alert('amjilttai')</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Тусламж/Данс цэнэглэх</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="card">
			<div class="card-header bg-transparent"><div class="col-sm-6"><h3>Тусламж/Данс цэнэглэх</h3></div></div>
			<div class="card-body">
					{{ csrf_field()}}
					<div class='col-sm-12'style='margin-top: 20px;margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'><h2>Хүсэлт</h2></div>
					<form>
					<div class="row">
						<div class="col-sm-6">
							<input type="text" class="form-control" name="req" required>
						</div>
						<div class="col-sm-6">
						<input type="submit" class="btn btn-primary"name="submit">
						</div>
					</div>
					</form>
					<div class='col-sm-12'style='margin-top: 20px;margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'><h2>Данс цэнэглэх</h2></div>
					<h3>Ta 5946447050 данс руу <?php echo $_SESSION['user_email'];?> гэсэн гүйлгээний утгатайгаар 
					хүссэн мөнгөө шилжүүлснээр дансаа цэнэглэх боломжтой Бид 20 минутын дотор баталгаажуулна</h3>
			</div>
		</div>
	</div>
</body>
</html>
@endsection