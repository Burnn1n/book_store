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
if(isset($_GET['edit_order'])){
	if($_SESSION['user_type'] != 3){
	$_SESSION['edit_order'] = true;
	$_SESSION['edit_order_id'] = $_GET['edit_order_id'];
	}
}
//order cancel
if(isset($_GET['order_cancel'])){
	unset($_SESSION['edit_order']);
}
//order submit
if(isset($_GET['order_submit'])){
	unset($_SESSION['edit_order']);
	if($_SESSION['user_type'] != 3){
	$tuluw = $_GET['tuluw'];
	$payment = $_GET['payment'];
	$payment = ($payment == "Хийгдсэн")? 1:0;
	$id = $_SESSION['edit_order_id'];
	$sql = "UPDATE orders SET order_tuluw_id = $tuluw,order_tulbur = $payment,updated_at = NOW() WHERE order_id=$id";
	mysqli_query($db->conn,$sql);
	}
}

if(isset($_GET['pay'])){
	$pay_id = $_GET['pay_id'];
	$sql = "SELECT order_book_id FROM orders WHERE order_id=$pay_id";
	//nomnii id
	$pay_book_id = $db->single_value($sql);
	$sql = "SELECT book_price FROM book where book_id = $pay_book_id";
	// nomnii une
	$pay_book_price = $db->single_value($sql);
	if($_SESSION['user_wallet'] < $pay_book_price){
		echo"<script>alert('Дансны үлдэгдэл хүрэлцэхгүй байна')</script>";
	}
	else{
		$sql = "UPDATE orders SET order_tulbur = 1,order_tuluw_id = 3 WHERE order_id = $pay_id";
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
		<button class="active" onclick="parent.location='http://localhost:8000/user/{{$user_id}}/order'" id="srch">ЗАХИАЛГУУД</button>
		<button onclick="parent.location='http://localhost:8000/user/{{$user_id}}/rent'" id="srch">ТҮРЭЭСҮҮД</button>
	</div>
	<div class="container">
		<div class="card">
			<div class="card-header bg-transparent"><div class="col-sm-6"><h3>Бүх захиалгууд</h3></div></div>
			<div class="card-body">
				<div class="row">
					{{ csrf_field()}}
					<div class='col-sm-12'>
					<form action="/user/{{$user_id}}/order" method="GET">
						<table class='table table-striped mt-3'>
							<tr><th>ID</th><th>Нэр</th><th>Ном</th><th>Төлөв</th>
							<th>Үнэ</th><th>Төлбөр</th><th>Захиалсан огноо</th>
							<th>Удирдах</th></tr>
							<?php
							$sql = "SELECT * FROM orders WHERE order_user_id = $user_id ORDER BY order_id DESC";
							$result = mysqli_query($db->conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								$c = $row["order_id"];
								$c_id = $row["order_book_id"];
								$sql = "SELECT book_name FROM book WHERE book_id = '$c_id'";
								//nomnii ner
								$c1 = $db->single_value($sql);
								//ooriinhoo zahialgiig uzej baiwal login session-s neriig awna
								if(isset($same))
									$c2 = $_SESSION['user_name'];
								else{
									$c2 = $row["order_user_id"];
									$sql = "SELECT user_name FROM users WHERE id = '$c2'";
									$c2 = $db->single_value($sql);
								}
								$c3 = $row["order_tuluw_id"];
								$sql = "SELECT tuluw_name FROM tuluw WHERE id = '$c3'";
								$c3 = $db->single_value($sql);

								//nomiin une
								$sql = "SELECT book_price FROM book WHERE book_id = '$c_id'";
								$c6 = $db->single_value($sql);

								$c4 = $row["order_tulbur"];
								$c4 = ($c4==true)?"Хийгдсэн":"Үгүй";
								
								$c5 = $row["created_at"];
								
								echo "<tr>
								<td>$c</td>
								<td>$c2</td>
								<td><a href='/book/$c1'>$c1</a></td>";
								if(isset($_SESSION['edit_order'])&&$_SESSION['edit_order_id'] == $c){
									$tuluw_data = array("Захиалагдсан","Хэрэглэгч хүлээн авсан","Захиалга баталгаажсан","Цуцлагдсан");
									$count = 1;
									echo "<td>
									<select name='tuluw'>";
									foreach($tuluw_data as $value){
										echo ($value == $c3)? "<option selected = 'selected' value='$count'>$value</option>":
																					"<option value='$count'>$value</option>";
										$count+=1;
									}
									echo "</select></td>";
									echo "<td>$c6</td>";
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
									echo"<td>$c5</td>";
									echo "<td><input  type='submit' name='order_cancel' value= 'Болих'>";
									echo "<input style='color: yellow;
									background-color: darkgreen;' type='submit' name='order_submit' value= 'Хадгалах'></td>";
								}
								else{
									echo"<td>$c3</td>";
									echo "<td>$c6</td>";
									echo ($c4 == "Үгүй")? "<td><a href='/user/$user_id/order?pay=true&pay_id=$c'>Төлөх</a></td>":"<td>$c4</td>";
									echo"<td>$c5</td>";
									if($_SESSION['user_type'] != 3){
										echo"
										<td>
										<a href='/user/$user_id/order?edit_order=true&edit_order_id=$c' class='table-link'>
											<span class='fa-stack'>
												<i class='fa fa-square fa-stack-2x'></i>
												<i class='fa fa-pencil fa-stack-1x fa-inverse'></i>
											</span>
										</a>
										</td>
										</tr>";
									}
									else{
										echo "<td></td></tr>";
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