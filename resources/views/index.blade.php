<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>URL Shortener</title>
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
	<div id="container">
		<h2>短链接生成器</h2>
		@if (session()->has('errors'))
			<h3 class="error">
				{{ $errors->first('link') }}		
			</h3>
		@elseif (session()->has('message'))
			<h3 class="error">
				{{ session()->get('message') }}
			</h3>
		@elseif (session()->has('link'))
			<h3 class="success">
				<a href="{{ url('/', [session()->get('link')]) }}" target="_blank">
				{{ url('/', [session()->get('link')]) }}
				</a>
			</h3>
		@endif
		<form action="" method="POST">
			{!! csrf_field() !!}
			<input type="text" name="link" placeholder="请输入您的网址！" value="{{ old('link') }}">
		</form>
	</div>
</body>
</html>