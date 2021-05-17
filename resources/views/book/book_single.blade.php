@extends('layouts.master')
@section('content')
<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
include('C:\xampp\htdocs\projects\Laravel\book\app\Http\Controllers\commonFunctions.php');
$db = new db();

// url-s nomnii neriig awan buh nomnii utguudiig ogogdliin sangaas awan zarlaj baina
$sql = "select * from book where book_name='$book_name'";
$result = mysqli_query($db->conn,$sql);
while($row = mysqli_fetch_assoc($result)){
	$id = $row['book_id'];
	$num = $row["book_price"];
	$img = $row["book_image"];
	$o_price = $row['book_online_price'];
	$author = $row['book_author'];
	$quantity = $row['book_quantity'];
	$desc = $row['book_about'];
	$pages = $row['book_pages'];
	$cat_id = $row['book_category'];
	$file = $row['book_file_name'];
	$downloads = $row['downloads'];
	$rent_price = $row['book_rent_price'];
}
$sql = "select category_name from category where category_id = '$cat_id'";
$cat_name = $db->single_value($sql);
$o_price = ($o_price != null)? $o_price:'Боломжгүй';	//herew online price 0 eswel null bol bolomjgui gej gargana

//edit-g darah uyd
if (isset($_GET['edit'])){
	if(isset($_SESSION['user_id'])){
		if($_SESSION['user_type'] == 1){
			$_SESSION['edit'] ='true';
		}
		else{
			header("Location: /");
			exit;
		}
	}
	else{
		header("Location: /");
		exit;
	}
} 

//cancel-g darah uyd
if(isset($_GET['cancel'])){
	$_SESSION['edit'] = null;
}

$error = "";

// save-g darah uyd
if(isset($_GET['save'])){
	$c1 = $_GET['name'];
	$c2 = $_GET['author'];
	$c3 = $_GET['price'];
	$c4 = $_GET['o_price'];
	$c5 = $_GET['quantity'];
	$c6 = $_GET['pages'];
	$c7 = $_GET['desc'];
	$c8 = $_GET['rent_price'];
	//oroltuudiig shalgaj baina hooson ugui yu gedgiig
	if(!empty($c1)&&!empty($c2)&&($c3==0or!empty($c3))&&($c4==0or!empty($c4))&&($c5==0or!empty($c5))&&($c6==0or!empty($c6))&&!empty($c7)
	&&($c8==0or!empty($c8))){
		//herew online une ni 0 eswel hooson eswel useg oruulsan baiwal null bolgoj database-d update hiih
		if (is_numeric($c4)!=1 or $c4 == '0')	$sql1 = "update book set book_online_price = null where book_id = '$id'";
		else	$sql1 = "update book set book_online_price = $c4 where book_id = '$id'";

		$sql = "UPDATE book SET book_name = '$c1',book_author = '$c2',book_price = $c3,book_quantity = '$c5',
		book_pages='$c6',book_about = '$c7',updated_at = NOW(),book_rent_price=$c8 WHERE book_id = '$id'";

		//online uniig update
		mysqli_query($db->conn,$sql1);
		mysqli_query($db->conn,$sql);
	
	
		//edit duussan gedgiig iltgeh
		$_SESSION['edit'] = null;

		//nomiin page ruu ochih
		header("Location: /book/$c1");
		exit;
	}
	else{
		$error = "Оролтууд хоосон байж болохгүй";
	}
}

//admin upload-g darah uyd
if(isset($_GET['upload'])){
	if(isset($_SESSION['user_id'])){
		if($_SESSION['user_type'] == 1){
			$_SESSION['upload'] ='true';
		}
		else{
			header("Location: /");
			exit;
		}
	}
	else{
		header("Location: /");
		exit;
	}
}
if(isset($_GET['delete'])){
	if(isset($_SESSION['user_id'])){
		if($_SESSION['user_type'] == 1){
			$sql = "DELETE FROM book WHERE book_name='$book_name'";
			mysqli_query($db->conn,$sql);
			header("Location: /book");
			exit;
		}
		else{
			header("Location: /");
			exit;
		}
	}
	else{
		header("Location: /");
		exit;
	}
}


//upload hiih gej baigaad bolih uyd
if(isset($_GET['cancel_file'])){
	$_SESSION['upload'] = null;
}

//admin oruulsan pdf file-aa hadgalah uyd
if(isset($_GET['save_file'])){
	$filename = $_GET['my_file'];
	if($_GET['my_file']=='null')
		$sql = "update book set book_file_name=null where book_name='$book_name'";
	else
		$sql = "update book set book_file_name='$filename' where book_name='$book_name'";
	if (mysqli_query($db->conn, $sql)) {
		$_SESSION['upload'] = null;
		header("Location: /book/$book_name");
		exit;
	}
}

//zahialah uyd
if(isset($_GET['order'])){
	//newterson bol
	if(!empty($_SESSION['user_id'])){
		//Hereglegchiin id
		$user_id = $_SESSION['user_id'];
		$sql = "insert into orders(order_book_id,order_user_id,order_tuluw_id)values($id,$user_id,1);";
		mysqli_query($db->conn,$sql);
		echo "<script>alert('Ном захиалагдлаа')</script>";
	}
	//zahialah uyd newtreegui bol login page ruu ochno
	else{
		header("Location: /login");
		exit;
	}
}
//tureesleh uyd
if(isset($_GET['rent'])){
	//newterson bol
	if(!empty($_SESSION['user_id'])){
		//Hereglegchiin id
		$user_id = $_SESSION['user_id'];
		$sql = "insert into rent(rent_book_id,rent_user_id,rent_tuluw_id)values($id,$user_id,1);";
		mysqli_query($db->conn,$sql);
		echo "<script>alert('Түрээс захиалагдлаа')</script>";
	}
	//zahialah uyd newtreegui bol login page ruu ochno
	else{
		header("Location: /login");
		exit;
	}
}

// online huwilbariig awah uyd
if(isset($_GET['buy_pdf'])){
	//newterson bol
	if(!empty($_SESSION['user_id'])){
		//hereglegchiin dansan dah mongo hurehgui bol
		if($o_price > $_SESSION['user_wallet']){
			echo "<script>alert('Дансан дахь үлдэгдэл хүрэлцэхгүй')</script>";
		}
		//tataj awah uildel
		else{
			$filename = "C:/xampp/htdocs/projects/Laravel/book/resources/e_books/$file";
			if(file_exists($filename)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header("Cache-Control: no-cache, must-revalidate");
				header("Expires: 0");
				header('Content-Disposition: attachment; filename="'.basename($filename).'"');
				header('Content-Length: ' . filesize($filename));
				header('Pragma: public');

				flush();
				readfile($filename);
				//ogogdliin sang shinechleh
				$downloads +=1;
				$sql = "UPDATE book SET downloads = $downloads WHERE book_id = $id";
				mysqli_query($db->conn,$sql);
				$wallet = $_SESSION['user_wallet'] - $o_price;
				$_SESSION['user_wallet'] = $wallet;
				//Hereglegchiin id
				$user_id = $_SESSION['user_id'];
				$sql = "UPDATE users SET user_wallet = $wallet WHERE id= $user_id";
				mysqli_query($db->conn,$sql);
				die();
			}
			else{
				echo "<script>alert('Зам буруу')</script>";
			}
		}
	}
	//zahialah uyd newtreegui bol login page ruu ochno
	else{
		header("Location: /login");
		exit;
	}
}

//tureesleh
if(isset($_GET['rent'])){
	//newterson bol
	if($_SESSION['user_id']){
		
	}
	//zahialah uyd newtreegui bol login page ruu ochno
	else{
		header("Location: /login");
		exit;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>{{$book_name}}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<style>
		.error {color: #FF0000;}
		.pro_name{
			font-size:50px;
			font-weight: bold;
			}
		table {border: none;
			margin-left:90px;
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
			padding: 16px;
  		text-align: center;
  		font-size: 16px;
  		margin: 4px 2px;
  		opacity: 0.6;
  		transition: 0.3s;
		}
		textarea{
			width: 100%;
		}
		button:hover {opacity: 1}
		td{padding: 15px;}
		</style>
  </head>
	<body>
    <div class="container">
			<div class="card">
				<div class="card-header bg-transparent"><div class="col-sm-6"><h3>Ном /
					 <a href="/category/{{$cat_name}}">{{$cat_name}}</a>
				</h3></div></div>
				<div class="card-body">
				<form action="/book/{{$book_name}}" method="GET" id = '1'>
					<div class="row">
						<div class='col-sm-8'>
							<table cellspacing='0' cellpadding='0'>
								<tbody>
									<tr>
										<td class='pro_name' colspan='2'><?php echo (isset($_SESSION['edit'])and$_SESSION['user_type'] == "1")?
										"<input type = 'text' value='$book_name' name='name'>":$book_name;?>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Зохиолч:</td>
										<td class='desc'><?php echo (isset($_SESSION['edit'])and$_SESSION['user_type'] == "1")?
										"<input class='form-control'  type = 'text' value='$author' name='author'>":$author;?>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Үнэ:</td>
										<td class='desc' style='font-size:2em; color: orange;'>
											<?php echo(isset($_SESSION['edit']) and $_SESSION['user_type'] == "1")?
											"<input type = 'number' value='$num' name='price'>":$num;?> төгрөг
										</td>
									</tr>
									<tr>
										<td class ='nm'>pdf үнэ:  </td>
										<td class='desc'>
										<?php echo(isset($_SESSION['edit'])and$_SESSION['user_type'] == "1")?
										"<input type = 'text' value='$o_price' name='o_price'> Хэрэв онлайн хувилбар
										байхгүй бол 0 эсвэл үсгэн утга оруулна уу":$o_price;?>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Түрээсийн үнэ(7 хоног):  </td>
										<td class='desc'>
										<?php echo(isset($_SESSION['edit'])and$_SESSION['user_type'] == "1")?
										"<input type = 'text' value='$rent_price' name='rent_price'>":$rent_price;?>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Үлдэгдэл:</td>
										<td class='desc'><?php echo(isset($_SESSION['edit'])and$_SESSION['user_type'] == "1")?
										"<input type = 'number' value='$quantity' name='quantity'>":$quantity;?> ширхэг</td>
									</tr>
									<tr>
										<td class ='nm'>Хуудасны тоо:</td>
										<td class='desc'><?php echo(isset($_SESSION['edit'])and$_SESSION['user_type'] == "1")?
										"<input type = 'number' value='$pages' name='pages'>":$pages;?> ширхэг</td>
										
									</tr>
									<tr>
										<td class ='nm'>Тухай:</td>
										<td class='desc'><?php echo(isset($_SESSION['edit'])and$_SESSION['user_type'] == "1")?
										"<textarea name='desc'>$desc</textarea>":$desc;
										?></td>
									</tr>
								</tbody>
							</table>
							<div class='row' style='margin-left:90px;'>
								<div class='col-sm-12'>
									<p><span class = 'error'>{{$error}}</span></p>
								</div>
									<?php
										if(isset($_SESSION['edit'])and$_SESSION['user_type'] == "1"){
											echo "<div class='col-sm-6' style='float:left;'>
											<input class='button'type='submit'name='cancel' value='Болих'>";
											echo"</div>
											<div class='col-sm-6' style='float:left;'>";	
											echo "<input class='button'type='submit'name='save' value='Хадгалах'></div>";
										}
										else{
											if($o_price =='Боломжгүй'){
												echo "<div class='col-sm-6' style='float:left;'>
												<input class='button'type='submit'name='order' value='Захиалах'>
												</div>";
												echo"<div class='col-sm-6' style='float:left;'>
													<input class='button'type='submit'name='rent' value='Түрээслэх'>
													</div>";
											}
											else{
												echo "<div class='col-sm-4' style='float:left;'>
												<input class='button'type='submit'name='order' value='Захиалах'>
												</div>";
												echo"<div class='col-sm-4' style='float:left;'>
													<input class='button'type='submit'name='buy_pdf' value='Онлайн хувилбар'>
													</div>";
												echo"<div class='col-sm-4' style='float:left;'>
													<input class='button'type='submit'name='rent' value='Түрээслэх'>
													</div>";
											}
											
										}
								?>
								
							</div>
						</div>
						<div class="col-sm-4">
						<div class="row">
						<div class="col-sm-12">
						<?php echo'<img src="data:image/jpeg;base64,'.base64_encode($img).'" style="width:235px;height:320px;"/>';?>
						</div>
							
							<?php
							//zowhon admin baih uyd
							if(isset($_SESSION['user_type'])and$_SESSION['user_type'] == "1"){
								if(!isset($_SESSION['edit'])){
									echo '<div class="col-sm-6"><input type="submit" value="edit" name = "edit"></div>';
								}
								echo '<div class="col-sm-6"><input type="submit" value="delete" name = "delete"></div>';
								//engiin uyd ebook-nii talaarh medeelel
								if(!isset($_SESSION['upload'])){
									echo "<div class = 'col-sm-8 '><input id= 'dl'type='submit' value='upload ebook' name = 'upload'></div>";

									echo "<div class='col-sm-12'><table style='margin-left:0px;'>
									<tr>
										<td>
											Татаж авах боломжтой эсэх
										</td>
										<td>";
									echo($file != null)?"Тийм":"Үгүй";
									echo"</td>
									</tr>";
									echo"<tr>
									<td>
										Файлын нэр
									</td>
									<td>
									$file
									</td>
									</tr>";
									echo"<tr>
										<td>
											Татаж авагдсан тоо
										</td>
										<td>
										$downloads
										</td>
									</tr></table></div>
									";
								}
								// online pdf nomnii neriig solih utgiig ustgah
								else{
									echo "<div class='col-sm-12'>
									<form action='/book/{{$book_name}}' method='GET' id='2'>
									<input type='text' name='my_file' value='$file' required> <br>
									<input type='submit' name='cancel_file' value='Болих' formnovalidate>
          				<input type='submit' name='save_file' value='Хадгалах'>
									</form>
									</div>
									";
								}
							}
							?>
							</div>	
						</div>
						<div class='col-sm-12'style=';margin-bottom:20px;border-bottom: 1px solid #7f7f7f;'>Төстэй</div>
						<?php
						//tustei nomnuudiig hewleh
							$db->print_book_single($book_name,$cat_id);
            ?>
					</div>
				</form>
				</div>
				</div>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
    var elems = document.getElementsByName('delete');
    var confirmIt = function (e) {
        if (!confirm('Номыг устгахдаа итгэлтэй байна уу?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
</script>
@endsection