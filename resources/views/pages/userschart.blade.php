@extends('layouts.index')

@section('content')

 


<div class="container">
        <div class="col-m-6">
            <div id="app">
                <h1> Average Consumed Energy Per Month</h1>
                    {!! $usersChart1->container() !!}
            </div>
        </div>
    <div class="col-m-6">
    <div id="app">
    <h1> Rate of Disconnected Accounts</h1>
        {!! $usersChart2->container() !!}
    </div>
</div>
<div class="container">
    <div id="app">
    <h1> Rate of Transactions</h1>
        {!! $usersChart3->container() !!}
    </div>
</div>


<script src="/js/style.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src-"/js/bootstrap.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <script>
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
</script>

<script src="https://unpkg.com/vue"></script>
        <script>
            var app = new Vue({
                el: '#app',
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
        <script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js charset=utf-8></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>

        


{!! $usersChart1->script() !!}
{!! $usersChart2->script() !!}
{!! $usersChart3->script() !!}
       
    
@endsection