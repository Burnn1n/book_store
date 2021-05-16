<?php
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
//on submit

?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="icon" type="image/gif/svg" href="https://iconape.com/wp-content/files/iz/297176/svg/297176.svg">
	<style>
		.header {
			text-align: center;
			color: white;
		}
		.header1{
			margin-top: 5px;
			margin-bottom: 5px;
			margin-right:5%;
			text-align: right;
		}
		.header2{
			margin-top: 10px;
			margin-bottom: 5px;
		}
		.header3{
			background: #282828;
			padding: 10px;
		}
	</style>
</head>
<body style="font-family: 'Century Gothic'">
<div class="card">
	<div class="header">
		<div class="header1">
		<?php
		//Newtreegui bol
		if(empty($_SESSION['user_id'])){
			echo"<a href='/login'>
			<img src='https://icon-library.com/images/my-account-icon/my-account-icon-18.jpg'style='width:30px;height:30px;'>
					</a>";
		}
		//Newtersen bol
		else {
			$n = $_SESSION['user_name'];
			$t = $_SESSION['user_type'];
			$i = $_SESSION['user_id'];
			echo"<a href='/user/$i'>
			<img src='https://icon-library.com/images/my-account-icon/my-account-icon-18.jpg'style='width:30px;height:30px;'>$n</a>";
			// newtersen hereglegch ni uilchluulegch bol
			if($t == '3'){
				$w = $_SESSION['user_wallet'];
				echo "<a href=''><img src='https://www.svgrepo.com/show/99360/wallet.svg'style='width:30px;height:30px;'>$w төгрөг</a>";
			}
			//hudaldagch bol
			else if ($t == '2'){
				
				echo "<a href=''><img src='https://thumbs.dreamstime.com/b/cashier-machine-icon-vector-isolated-white-background-your-web-mobile-app-design-cashier-machine-logo-concept-cashier-134155251.jpg'
				style='width:30px;height:30px;'>Худалдагч</a>";
			}
			//admin bol
			else if ($t == '1'){
				echo "<a href=''><img src='https://www.svgrepo.com/show/308141/use-laptop-programmer-computer-internet.svg'
				style='width:30px;height:30px;'>Админ</a>";
			}
			//log out
			echo "<a href='/log_out'><img src='data:image/png;base64,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'
				style='width:30px;height:30px;'>Гарах</a>";
		}
		?>
		</div>
		<div class="header2">
			<form action="/search" method="GET">
				<div class="row">
			 		<div class="col-sm-4">
			 			<a href="/">
					 		<img src="https://iconape.com/wp-content/files/iz/297176/svg/297176.svg"style="width:154px;height:114px;">
				 		</a>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="col-sm-11">
								<input type = "text" class="form-control"name = "name"placeholder="Номын нэрээр хайх">
							</div>
							<div class="col-sm-1">
								<input type="image" src="https://logoeps.com/wp-content/uploads/2014/08/2074-google-web-search-icon-vector-icon-vector-eps.png"
						 		alt="submit" name="submit" width="44" height="43">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="header3">
			<div class="row">
				<?php
					//admin bol
					if(!empty($_SESSION['user_id'])){
						if($_SESSION['user_type'] == "1"){
							echo '<div class="col-sm-3"><a href="/">Эхлэл</a></div>
							<div class="col-sm-3"><a href="/book">Бүх номнууд</a></div>
							<div class="col-sm-3"><a href="/category">Ангилал</a>	</div>';
							echo "<div class='col-sm-3'><a href='/user'>Хэрэглэгчид</a>	</div>";
						}
							//hudaldagch bol
						else if($_SESSION['user_type'] == "2" ){
							echo '<div class="col-sm-2"><a href="/">Эхлэл</a></div>
							<div class="col-sm-2"><a href="/book">Бүх номнууд</a></div>
							<div class="col-sm-2"><a href="/category">Ангилал</a>	</div>';
							echo "<div class='col-sm-3'><a href='/user'>Хэрэглэгчид</a>	</div>";
							echo "<div class='col-sm-2'><a href='/helps'>Тусламж</a>	</div>";
							
							}	
							//hereglegch bol
						else{
							echo '<div class="col-sm-3"><a href="/">Эхлэл</a></div>
						<div class="col-sm-3"><a href="/book">Бүх номнууд</a></div>
						<div class="col-sm-3"><a href="/category">Ангилал</a>	</div>
						<div class="col-sm-3"><a href="/help">Тусламж/Данс цэнэглэх</a>	</div>';
							}
					}
					//zochin bol
					else{
						echo '<div class="col-sm-4"><a href="/">Эхлэл</a></div>
						<div class="col-sm-4"><a href="/book">Бүх номнууд</a></div>
						<div class="col-sm-4"><a href="/category">Ангилал</a>	</div>';
					}
				?>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="panel" >@yield('content')</div>
	</div>
	<div class="card-footer">
	</div>
</div>
</body>
</html>