<!DOCTYPE html>
<html lang="es">
<head>
    <title>ETB - Te lo cambio</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700'
          rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>

<body>
	<main role="main">
		<!--page-->
		@yield('content')
	</main>
	<script src="{{ url('js/all.js') }}"></script>
    <script>
   (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
       (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
   })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

   ga('create', 'UA-82737406-2', 'auto');
   ga('send', 'pageview');
  </script>
	@yield('scripts')
</body>
</html>
