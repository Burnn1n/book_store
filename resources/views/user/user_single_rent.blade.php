@extends('layouts.master')
@section('content')
<?php
include('C:\xampp\htdocs\projects\Laravel\book\app\Http\Controllers\commonFunctions.php');
$db = new db();

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
//herew newtreegui bolon admin eswel hudaldagch bish mon ooriinhoo hayg ruu oroogui bol ucheer oor page ruu zoogdono
if(!empty($_SESSION['user_id'])){
	if($_SESSION['user_type'] == 3){
		if($_SESSION['user_id'] != $user_id){
			header("Location: /");
			exit;
		}
		else{
			$same = true;
		}
	}
}
else{
	header("Location: /login");
	exit;
}

//order edit
if(isset($_GET['edit_rent'])){
	//hereglegch tureesee oorchilj chadahgui zowhon hudaldagch eswel admin oorchloh erhtei
	if($_SESSION['user_type'] != 3){
	//session-r edit hiih esehiig lawlana
	$_SESSION['edit_rent'] = true;
	$_SESSION['edit_rent_id'] = $_GET['edit_rent_id'];
	}
}
//rent cancel
if(isset($_GET['rent_cancel'])){
	unset($_SESSION['edit_rent']);
}
//rent submit
if(isset($_GET['rent_submit'])){
	unset($_SESSION['edit_rent']);
	$id = $_SESSION['edit_rent_id'];
	if($_SESSION['user_type'] != 3){
	$deadline = $_GET['deadline'];
	$sql = "select started_at from rent where rent_id=$id";
	$start = $db->single_value($sql);
	$tuluw = $_GET['tuluw'];
	$payment = ($_GET['payment'] == "Хийгдсэн")? 1:0;
	$id = $_SESSION['edit_rent_id'];
	//herew tureesiin hugatsaa ywj ehleegui baisan bol hereglegch huleen awsan bolgoh uyd autamataar utguudiig ogno
	if($tuluw == 2 and $start == null){
		$sql = "UPDATE rent SET rent_tuluw_id = $tuluw,rent_tulbur = $payment,started_at = NOW(),
		deadline_at = NOW()+ INTERVAL 7 DAY WHERE rent_id=$id";
	}
	// tureesiin duusah hugatsaag update hiih uyd
	else if($deadline != null){
		$sql = "UPDATE rent SET rent_tuluw_id = 6,rent_tulbur = $payment,deadline_at='$deadline' WHERE rent_id=$id";
	}
	// time input ni default value hadgaldaggui tul value-g ogoogui busad input-g oorchloh uyd 
	else{
		$sql = "UPDATE rent SET rent_tuluw_id = $tuluw,rent_tulbur = $payment WHERE rent_id=$id";
	}
	
	mysqli_query($db->conn,$sql);
	}
}
//turessiin tulburiig tuluh uyd
if(isset($_GET['pay'])){
	$pay_id = $_GET['pay_id'];
	$sql = "SELECT rent_book_id FROM rent WHERE rent_id=$pay_id";
	//nomnii id
	$pay_book_id = $db->single_value($sql);
	$sql = "SELECT book_rent_price FROM book where book_id = $pay_book_id";
	// nomnii une
	$pay_book_price = $db->single_value($sql);
	if($_SESSION['user_wallet'] < $pay_book_price){
		echo"<script>alert('Дансны үлдэгдэл хүрэлцэхгүй байна')</script>";
	}
	else{
		$sql = "UPDATE rent SET rent_tulbur = 1,rent_tuluw_id = 3 WHERE rent_id = $pay_id";
		mysqli_query($db->conn,$sql);
		$wallet = $_SESSION['user_wallet'] - $pay_book_price;
		$sql = "UPDATE users SET user_wallet = $wallet WHERE id= $user_id";
		mysqli_query($db->conn,$sql);
		echo"<script>alert('Амжилттай')</script>";
		$_SESSION['user_wallet'] = $wallet;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Захиалгууд</title>
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
		<button onclick="parent.location='http://localhost:8000/user/{{$user_id}}'" id="stud">ЕРӨНХИЙ МЭДЭЭЛЭЛ</button>
		<button onclick="parent.location='http://localhost:8000/user/{{$user_id}}/order'" id="srch">ЗАХИАЛГУУД</button>
		<button class="active" onclick="parent.location='http://localhost:8000/user/{{$user_id}}/rent'" id="srch">ТҮРЭЭСҮҮД</button>
	</div>
	<div class="container">
		<div class="card">
			<div class="card-header bg-transparent"><div class="col-sm-6"><h3>Бүх түрээсүүд</h3></div></div>
			<div class="card-body">
				<div class="row">
					{{ csrf_field()}}
					<div class='col-sm-12'>
					<form action="/user/{{$user_id}}/rent" method="GET">
						<table class='table table-striped mt-3'>
							<?php
							echo"<tr><th>ID</th><th>Нэр</th><th>Ном</th><th>Төлөв</th>
							<th>Үнэ</th><th>Төлбөр</th><th>эхэлсэн цаг</th><th>Дуусах цаг</th>";
							echo ($_SESSION['user_type'] != 3)?"<th>Удирдах</th>":"";
							echo"</tr>";
							$sql = "SELECT * FROM rent WHERE rent_user_id = $user_id ORDER BY rent_id DESC";
							$result = mysqli_query($db->conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								$c = $row["rent_id"];
								$c_id = $row["rent_book_id"];
								$sql = "SELECT book_name FROM book WHERE book_id = '$c_id'";
								//nomnii ner
								$c1 = $db->single_value($sql);
								//ooriinhoo zahialgiig uzej baiwal login session-s neriig awna
								if(isset($same))
									$c2 = $_SESSION['user_name'];
								else{
									$c2 = $row["rent_user_id"];
									$sql = "SELECT user_name FROM users WHERE id = '$c2'";
									$c2 = $db->single_value($sql);
								}
								$c3 = $row["rent_tuluw_id"];
								$sql = "SELECT tuluw_name FROM tuluw WHERE id = '$c3'";
								$c3 = $db->single_value($sql);

								//nomiin tureesiin une
								$sql = "SELECT book_rent_price FROM book WHERE book_id = '$c_id'";
								$c6 = $db->single_value($sql);

								$c4 = $row["rent_tulbur"];
								$c4 = ($c4==true)?"Хийгдсэн":"Үгүй";
								
								$c5 = $row["started_at"];
								$c7 = $row['deadline_at'];
								
								echo "<tr>
								<td>$c</td>
								<td>$c2</td>
								<td><a href='/book/$c1'>$c1</a></td>";
								//edit session active uyd edit hiigdej baih uyd
								if(isset($_SESSION['edit_rent'])&&$_SESSION['edit_rent_id'] == $c){
									$tuluw_data = array("Захиалагдсан","Хэрэглэгч хүлээн авсан","Захиалга баталгаажсан","Цуцлагдсан",
								"Түрээсийн цаг хэтэрсэн","Түрээсийн цаг сунгагдсан","Хаагдсан");
									$count = 1;
									//tuluw
									echo "<td>
									<select name='tuluw'>";
									foreach($tuluw_data as $value){
										echo ($value == $c3)? "<option selected = 'selected' value='$count'>$value</option>":
																					"<option value='$count'>$value</option>";
										$count+=1;
									}
									echo "</select></td>";
									echo "<td>$c6</td>";			//tureesiin une
									// tulburiin heseg
									echo"
										<td>
										<select name='payment'>";
									$payment_data = array("Хийгдсэн","Үгүй");
									foreach($payment_data as $value){
										echo ($value == $c4)? "<option selected = 'selected' value='$value'>$value</option>":
																					"<option value='$value'>$value</option>";
									}
									echo"</select>
									</td>";
									echo"<td>$c5</td>";			//tureesiin ehelsen tsag
									echo"<td><input type='datetime-local'name='deadline'value=$c7></td>";	//tureesiin duusah tsag
									echo "<td><input  type='submit' name='rent_cancel' value= 'Болих'>";	//cancel submit
									echo "<input style='color: yellow;
									background-color: darkgreen;' type='submit' name='rent_submit' value= 'Хадгалах'></td>";	//submit
								}
								//engiin uyd
								else{
									echo"<td>$c3</td>";
									echo "<td>$c6</td>";
									//hereglegch bol tuluh gesen link garj irsneer tulbur tuluh bolomjtoi
									// harin hereglegch bish bol zugeer utga ni garj irne
									echo ($c4 == "Үгүй" and $user_id == $_SESSION['user_id'])? "<td><a href='/user/$user_id/rent?pay=true&pay_id=$c'>Төлөх</a></td>":"<td>$c4</td>";
									echo"<td>$c5</td>";	//ehelsen tsag
									echo"<td>$c7</td>";	//duusah tsag
									//udirdah-n edit button hereglegch bish bol garj irne
									if($_SESSION['user_type'] != 3){
										echo"
										<td>
										<a href='/user/$user_id/rent?edit_rent=true&edit_rent_id=$c' class='table-link'>
											<span class='fa-stack'>
												<i class='fa fa-square fa-stack-2x'></i>
												<i class='fa fa-pencil fa-stack-1x fa-inverse'></i>
											</span>
										</a>
										</td>
										</tr>";
									}
								}
							}
							?>
						</table>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
@endsection