@extends('layouts.master')
@section('content')
<!DOCTYPE html>
<html>
	<head>
		<title>add</title>
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
				<div class="card-header bg-transparent"><div class="col-sm-6"><h3>Ном нэмэх</h3></div></div>
				<div class="card-body">
				<form action="/add" enctype="multipart/form-data" method="POST" >
				{{ csrf_field() }}
					<div class="row">
						<div class='col-sm-8'>
							<table cellspacing='0' cellpadding='0'>
								<tbody>
									<tr>
										<td class='pro_name' colspan='2'>
										<input type = 'text' placeholder="Номын нэр" name='name'required>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Зохиолч:</td>
										<td class='desc'>
											<input class='form-control'type = 'text'name='author'required>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Үнэ:</td>
										<td class='desc' style='font-size:2em; color: orange;'>
										<input type = 'number'name='price'required>төгрөг
										</td>
									</tr>
									<tr>
										<td class ='nm'>pdf үнэ:  </td>
										<td class='desc'>
											<input type = 'number'name='o_price'required> Хэрэв онлайн хувилбар
										байхгүй бол 0 гэсэн утга оруулна уу
										</td>
									</tr>
									<tr>
										<td class ='nm'>Түрээсийн үнэ(7 хоног):  </td>
										<td class='desc'>
											<input type = 'number'name='rent_price'required>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Үлдэгдэл:</td>
										<td class='desc'>
											<input type = 'number'name='quantity'required> ширхэг
										</td>
									</tr>
									<tr>
										<td class ='nm'>Хуудасны тоо:</td>
										<td class='desc'>
											<input type = 'number'name='pages'required>ширхэг
										</td>
									</tr>
									<tr>
										<td class ='nm'>Тухай:</td>
										<td class='desc'>
										<textarea name='desc'required></textarea>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Ангилал:</td>
										<td class='desc'>
										<select class='form-control' name='categ'>
											<option value = '1'>Анагаах ухаан</option>
											<option value = '2'>Бизнес эдийн засаг</option>
											<option value = '3'>Шинжлэх ухаан</option>
											<option value = '4'>Уран зохиол</option>
											<option value = '5'>Гүн ухаан</option>
											<option value = '6'>Түүх</option>
											<option value = '7'>Хууль</option>
											<option value = '8'>Танин мэдэхүй</option>
											<option value = '9'>Намтар</option>
											<option value = '10'>Хэл, Толь бичиг</option>
											<option value = '11'>Хүүхдийн</option>
										</select>
										</td>
									</tr>
									<tr>
										<td class ='nm'>Номны зураг:</td>
										<td class='desc'>
											<input type="file" name="img"accept="image/*">
										</td>
									</tr>
									<tr>
										<td class ='nm'>Номны pdf file:</td>
										<td class='desc'>
											<input type="file" name="pdf"accept=".pdf">
										</td>
									</tr>
								</tbody>
							</table>
							<div class='row' style='margin-left:90px;'>
								<div class='col-sm-12'>
									<p><span class = 'error'></span></p>
								</div>
								<div class='col-sm-6' style='float:left;'>
									<input class='button'type='reset'name='cancel' value='Болих'>
								</div>
								<div class='col-sm-6' style='float:left;'>
									<input class='button'type='submit'name='save' value='Хадгалах'>
								</div>
							</div>
						</div>
					</div>
				</form>
				</div>
				</div>
			</div>
		</div>
	</body>
</html>
@endsection