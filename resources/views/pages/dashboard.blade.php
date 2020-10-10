@extends('layouts.index')

@section('content')

<div class="container">
                <form action="/search" method="POST" role="search" style="margin-bottom: 30px;">
                     {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="q"
                            placeholder="Search account number"> <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </form>
<div class="container" >
<div class="row">

<div class="col-md-6 col-sm-6">
    <div class="x_panel tile overflow_hidden">
        <div class="x_title">
                <h2>Energy Consumption Per Month</h2>
                  <!-- <ul class="nav navbar-right panel_toolbox" >
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul> -->
                  <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div style="height:200px">
                 {!!  $ECCchart->container() !!}
                 {!! $ECCchart->script() !!}
          </div>
        </div>
    </div>
</div>

<div class="col-md-4 col-sm-4 ">
    <div class="x_panel tile overflow_hidden">
        <div class="x_title">
            <h4>Subscribers Status</h4>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div style="height:190px">
                {!!  $substatus->container() !!}
                {!! $substatus->script() !!}
            </div>
        </div>
    </div>
</div>

<div class="col-md-4 col-sm-4 ">
    <div class="x_panel tile overflow_hidden">
        <div class="x_title">
            <h4>Consumption by Category</h4>
            <!-- <ul class="nav navbar-right panel_toolbox" >
            <li><a class="close-link"><i class="fa fa-close"></i></a>
            </li>
            </ul> -->
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div style="height:190px">
                {!!  $consumption->container() !!}
                {!! $consumption->script() !!}
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-sm-6 ">
        <div class="x_panel tile overflow_hidden">
            <div class="x_title">
                <h2>Number of Power Cuts per Month</h2>
                <!-- <ul class="nav navbar-right panel_toolbox" >
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
                </ul> -->
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div style="height:180px">
                    {!!  $powercuts->container() !!}
                    {!! $powercuts->script() !!}
                </div>
            </div>
        </div>
</div>

<!-- <div class="container" >
            <div class="row">
                <div class="col-xl-8">
                    <div class="header1">
                        <table class="table table-striped">
                            <thead>
                                <tr>List of Accounts Due Today</tr>
                                <tr>
                                    <td>Account Number</td>
                                    <td>Account Name</td>
                                    <td>Address</td>
                                    <td>Category</td>
                                    <td>Post Type</td>
                                    <td>Contact Number</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="scrollable">
                        <table class="table table-striped">
                            <tbody>
                            @foreach($accounts as $account)
                                <tr>
                                    <td>{{$account->account_number}}</td>
                                    <td>{{$account->account_name}}</td>
                                    <td>{{$account->address}}</td>
                                    <td>{{$account->category}}</td>
                                    <td>{{$account->post_type}}</td>
                                    <td>{{$account->contact_number}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xl-4" >
                    <div class="container" style="background color: rgb(192, 192, 192)">
                        <div class="row">
                            <div class="col-xl-12"  style= "color: white;">
                                <h5 style="margin-top: 20px; color: white;">Notifications</h5> 
                                    @foreach($notifications as $notification)
                                        <tr class="table-success">
                                            <td style="text-align: right;"><img src="/images/CHE.png" style="width: 40px; height: 40px;"> Account Number  <strong>{{$notification->accountnum}}</strong></td>
                                            @if($notification->status == 1)
                                                <td><strong>Reconnection    </strong>was Successful</td>
                                            @elseif($notification->status == 0)
                                                <td><strong>Disconnection   </strong>was Successful</td>
                                            @endif
                                            <td  style="text-align: left;">{{$notification->created}}</td>
                                            <td> ------------------------------------</td>
                                        </tr>
                                    @endforeach  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8">
                <form action="{{ route('login') }}" style="margin-top: 5px;">
                        <button style="background-color: #4CAF50; color: white;" class= "btn btn-success;" type="submit" formaction="/SendReminder">Send Reminder</button>
                </form>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8">
                    <div class="header1"  style="margin-top:10px">
                        <table class="table table-striped">
                            <thead>
                                <tr>List of Accounts to be Disconnected Today</tr>
                                <tr>
                                    <td>Account Number</td>
                                    <td>Account Name</td>
                                    
                                    <td>Address</td>
                                    <td>Category</td>
                                    <td>Post Type</td>
                                    <td>Contact Number</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="scrollable">
                        <table class="table table-striped">
                            <tbody>
                            @foreach($accounts1 as $account)
                                <tr>
                                    <td>{{$account->account_number}}</td>
                                    <td>{{$account->account_name}}</td>
                                   
                                    <td>{{$account->address}}</td>
                                    <td>{{$account->category}}</td>
                                    <td>{{$account->post_type}}</td>
                                    <td>{{$account->contact_number}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-xl-4" >
                    <div class="container" style="background color: rgb(192, 192, 192)">
                        <div class="row">
                            <div class="col-xl-12"  style= "color: white;">
                                <a style="color: white;" href="/userschart">View Charts</a> 
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-xl-8">
                    <form action="{{ route('login') }}" style="margin-top: 7px;">
                        <button style="background-color: #4CAF50; color: white;" class= "btn btn-success;" type="submit" formaction="/SendDisconnection">Send Disconnection</button>
                    </form>
                </div>
            </div>
        </div> -->
        
    
@endsection