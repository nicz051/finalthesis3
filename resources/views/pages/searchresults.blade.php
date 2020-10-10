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
       
                <div class="row">
                    @if(isset($details))
                        <!-- <p> The Search results for your query <b> {{ $query }} </b> are :</p> -->
                        @foreach($details as $user) 
                            <div class="col-md-5 col-sm-4 ">
                                <h1>{{$user->account_name}} - {{$user->account_number}}</h1>
                                <p>ADDRESS: <b>{{$user->address}}</b></p>
                                <p>CONTACT NUMBER: <b>{{$user->contact_number}}</b></p>
                            </div>
                            <div class="col-md-4 col-sm-10 ">
                                <p>METER NUMBER: <b>{{$user->meter_number}}</b></p>                                
                                <p>CATEGORY: <b>{{$user->category}}</b></p>
                                @if($user->status == '1')
                                    <p>STATUS: <img src="/images/userr.png" style="width: 40px; height: 40px;"></p>
                                @else
                                    <p>STATUS: <img src="/images/userred.png" style="width: 40px; height: 40px;"></p>
                                @endif                                
                            </div>
                </div>
                <div class="row">
                            <h4 style="margin-top: 20px;"> Statements of Account</h4>
                            <table class="table table-striped">
                                <thead> 
                                    <tr>
                                        <th>Bill ID</th>
                                        <th>Bill Month</th>
                                        <th>Bill Period</th>
                                        <th>Previous Reading</th>
                                        <th>Current Reading</th>
                                        <th>Energy</th>
                                        <th>Bill Date</th>
                                        <th>Due Date</th>
                                        <th>Bill Amount</th>
                                        <th>Disconnection Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach($bill as $bill)
                                    <tr>
                                        <td>{{$bill->bill_id}}</td>
                                        <td>{{$bill->bill_month}}</td>
                                        <td>{{$bill->bill_period_start}}</td>
                                        <td>{{$bill->previous_reading}}</td>
                                        <td>{{$bill->current_reading}}</td>
                                        <td>{{$bill->energy}}</td>
                                        <td>{{$bill->bill_date}}</td>
                                        <td>{{$bill->due_date}}</td>
                                        <td>{{$bill->bill_amount}}</td>
                                        <td>{{$bill->disconnection_date}}</td>
                                        @if($bill->status == '1')
                                            <td>Paid</td>
                                        @else
                                            <td>Not Paid</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                <div class="row">
                <h4 style="margin-top: 20px;">Recent Transactions</h4>
                <table class="table table-striped">
                    <thead> 
                        <tr>
                            <th>Transaction ID</th>
                            <th>Date-Time</th>
                            <th>Bill ID</th>
                            <th>Amount Paid</th>
                            <th>Credit Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction as $transaction)
                        <tr>
                            <td>{{$transaction->transaction_id}}</td>
                            <td>{{$transaction->date_time}}</td>
                            <td>{{$transaction->transactions_bill_id}}</td>
                            <td>{{$transaction->amount_paid}}</td>
                            <td>{{$transaction->credit_balance}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                           



                            @endforeach
                            @endif
        </div>
    
        







@endsection