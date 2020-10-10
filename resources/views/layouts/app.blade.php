<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <title>Central Negros Electric Cooperative, Inc. Server</title>
        <!-- <link rel="stylesheet" type="text/css" href="/css/style.css"> -->
        <link rel="stylesheet" type="text/css" href="/css/style.css?d=<?php echo time(); ?>" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="background-color: #696969;">
    <header style="background-image: linear-gradient(to right, #F0FFF0, #006400);">
		<img src="images/download2.png" style="width: 100px; height: 100px; padding-top: 10px;"><strong> CENTRAL NEGROS ELECTRIC COOPERATIVE, INC.</strong>
		<p class="server" style="padding-bottom: 20px; margin-top: -15px;"> Server </p>
	</header>
    
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<script src="/js/style.js" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src-"/js/bootstrap.js"></script>
<script src="/js/bootstrap.min.js"></script>

</html>
