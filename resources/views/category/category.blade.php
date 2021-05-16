@extends('layouts.master')
@section('content')
<?php
include('C:\xampp\htdocs\projects\Laravel\book\app\Http\Controllers\commonFunctions.php');
$db = new db();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ангилал</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="card">
			<div class="card-header bg-transparent"><h3>Ангилал</h3></div>
			<div class="card-body">
				<div class="row">
					{{ csrf_field()}}	
					<?php
						$db->print_('category',null);
          ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
@endsection