@extends('layouts.master')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>verify</title>
</head>
<body>
	<center>
	<h1>
		Таны и-мэйл рүү баталгаажуулалт явуулсан. Та и-мэйлээ баталгаажуулна уу.
	</h1>
	<h1>
		<a href="/verify/{{$email}}">Дахин явуулах</a>
	</h1>
	</center>
</body>
</html>
@endsection