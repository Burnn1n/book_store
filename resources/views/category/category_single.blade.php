@extends('layouts.master')
@section('content')
<?php
include('C:\xampp\htdocs\projects\Laravel\book\app\Http\Controllers\commonFunctions.php');
$db = new db();

$title = (isset($home_name))? $home_name:$category_name;
?>
<!DOCTYPE html>
<html>
<head>
	<title>{{$title}}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="card">
			<div class="card-header bg-transparent"><h3>{{$title}}</h3></div>
			<div class="card-body">
				<div class="row">
					{{ csrf_field()}}	
					<?php
					if(isset($home_name)){
						$db->print_category_single('home',$home_name);
					}
					elseif(isset($category_name)){
						$db->print_category_single('category',$category_name);
					}
          ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
@endsection