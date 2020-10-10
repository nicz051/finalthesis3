<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Central Negros Electric Cooperative, Inc. Server</title>
        <link href="../build/css/custom.min.css" rel="stylesheet">
        <!-- <link rel="stylesheet" type="text/css" href="/css/style.css"> -->
        <link rel="stylesheet" type="text/css" href="/css/style.css?d=<?php echo time(); ?>" />
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta charset="utf-8">
      
        
    </head>



    <body onload=display_ct(); style="background-color: #696969;">
    
    <div class="nav-bar" style="background-image: linear-gradient(to right, #F0FFF0, #006400);">

        <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#"><img src="/images/download2.png" style="width: 75px; height: 75px;"></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Dashboard</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="/user_profile">User Profile</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="/notifications">Notifications</a>
            </li> -->
            <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Data Tables
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/data_table/accounts">Accounts</a>
                    <a class="dropdown-item" href="/data_table/disconnected_accounts">Disconnected Accounts</a>
                    <a class="dropdown-item" href="/data_table/billing">Billing</a>
                    <a class="dropdown-item" href="/data_table/collection">Collection</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Log-out</a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                 @csrf
                 </form>
            </li>
            </ul>
        </div>
        </nav>
        </div>

        <div class="datetime">

		<p id="datetime1" style="margin:0;display:inline;float:left"></p>
		<p style="margin:0;display:inline;float:left">,</p>
		<p id="datetime2" style="margin:0;display:inline:float:right"></p>

		<p> <span id="datetime"></span></p>

            <script>
                function display_c(){
                var refresh=1000; // Refresh rate in milli seconds
                mytime=setTimeout('display_ct()',refresh)
                }

                function display_ct(){
                    var dt = new Date();
                    document.getElementById("datetime1").innerHTML = dt.toDateString();
                    document.getElementById("datetime2").innerHTML = dt.toLocaleTimeString();
                    display_c();
                }
            </script>

        </div>
                
       @yield('content')

       <script src="/js/style.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src-"/js/bootstrap.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <!-- <script>
           window.addEventListener('load', function() {
    var xhr = null;

    getXmlHttpRequestObject = function() {
        if (!xhr) {
            // Create a new XMLHttpRequest object 
            xhr = new XMLHttpRequest();
        }
        return xhr;
    };

    updateLiveData = function() {
        var now = new Date();
        // Date string is appended as a query with live data 
        // for not to use the cached version 
        var url = 'livefeed.txt?' + now.getTime();
        xhr = getXmlHttpRequestObject();
        xhr.onreadystatechange = evenHandler;
        // asynchronous requests
        xhr.open("GET", url, true);
        // Send the request over the network
        xhr.send(null);
    };

    updateLiveData();

    function evenHandler() {
        // Check response is ready or not
        if (xhr.readyState == 4 && xhr.status == 200) {
            dataDiv = document.getElementById('liveData');
            // Set current data text
            dataDiv.innerHTML = xhr.responseText;
            // Update the live data every 1 sec
            setTimeout(updateLiveData(), 1000);
        }
    }
});
</script> -->

<script src="https://unpkg.com/vue"></script>
        <script>
            var app = new Vue({
                el: '#app',
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
        <script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js charset=utf-8></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
       
        

    </body>

    
</html>
