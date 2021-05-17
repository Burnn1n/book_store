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
					<p>Ta <span style="font-weight: bold;">5946447050</span> данс руу <?php echo $_SESSION['user_email'];?> гэсэн гүйлгээний утгатайгаар 
					хүссэн мөнгөө шилжүүлснээр дансаа цэнэглэх боломжтой Бид 20 минутын дотор баталгаажуулна. Хэрэглэгчийн нэр Болд</p>
					<div class='col-sm-12'style='margin-top: 20px;margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'><h2>Захиалга</h2></div>
					<p>Номны хуудсан дахь захиалах товчийг дарснаар таны хаяг дээр захиалга үүсэх юм. Үүний дараа та төлбөрөө өөрийн
					хуудсын захиалгууд хэсэг рүү орон онлайн хэтэвчээрээ төлөх боломжтой ингэснээрээ захиалгыг баталгаажуулна. Үүний дараа
					хүргэлтийн ажилтан таны оруулсан гар утсаар холбогдон 48 цагийн дотор барааг хүргэж өгөх байгаа.</p>
					<div class='col-sm-12'style='margin-top: 20px;margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'><h2>Түрээс</h2></div>
					<p>Номны хуудсан дахь түрээслэх товчийг дарснаар таны хаяг дээр түрээсийн захиалга үүсэх юм.Үүний дараа та төлбөрөө өөрийн
					хуудсын түрээсүүд хэсэг рүү орон онлайн хэтэвчээрээ төлөх боломжтой ингэснээрээ түрээсийг баталгаажуулна.Үүний дараа
					та өөрөө манай салбар дээр ирж авах эсвэл хүргүүлэн авах гэсэн 2 сонголтын нэгийг сонгох боломжтой.Хүргүүлж авах бол 
					захиалга хийсэнтэй адилхан. Үүний дараа ямар нэгэн аргаар түрээсийн номоо авсны дараа 7 хоногийн хугацаатай цаг явж эхэлнэ.
					Цаг дотроо амжин салбар дээр авчирж ирэх шаардлагатай
					<span style="font-weight: bold;">Хэрэв цаг хэтэрвэл таны дансанд өдөр бүр 5000 төгрөгний шимтгэл бодогдохийг анхаарна уу</span></p>
			</div>
		</div>
	</div>
</body>
</html>
@endsection