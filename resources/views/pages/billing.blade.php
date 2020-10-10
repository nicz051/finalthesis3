@extends('layouts.index')

@section('content')

<style>
    #billingtable
{
	height: 100px;
	overflow: scroll;
}
</style>    


<div id="searchcontainer" class="container" style="text-align: right">
    <input type="text" id="search" placeholder="Search Billing" onkeyup="searchFun()" style="margin-top:20px">
</div>

<div class="container" style="margin-top: 30px">
        <div class="row" style="height:450px; width:1250px; soverflow-y: scroll; overflow-x: hidden;">
            <div class="col-md-12"  style="text-align: center;">
                <table id= "billingtable" class="table table-striped" style="background-color: rgb(192, 192, 192);">
                    <thead>
                        <tr>
                          <th>Bill Id</th>
                          <th>Account Number</th>
                          <th>Bill Month</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Previous Reading</th>
                          <th>Current Reading</th>
                          <th>Energy</th>
                          <th>Bill Date</th>
                          <th>Due Date</th>
                          <th>Disconnection Date</th>
                          <th>Bill Amount</th>
                          <th>Bill Balance</th>
                          <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($bills as $bill)
                        <tr>
                            <td>{{$bill->bill_id}}</td>
                            <td>{{$bill->bills_account_number}}</td>
                            <td>{{$bill->bill_month}}</td>
                            <td>{{$bill->bill_period_start}}</td>
                            <td>{{$bill->bill_period_end}}</td>
                            <td>{{$bill->previous_reading}}</td>
                            <td>{{$bill->current_reading}}</td>
                            <td>{{$bill->energy}}</td>
                            <td>{{$bill->bill_date}}</td>
                            <td>{{$bill->due_date}}</td>
                            <td>{{$bill->disconnection_date}}</td>
                            <td>{{$bill->bill_amount}}</td>
                            <td>{{$bill->bill_balance}}</td>
                        @if($bill->status == '1')
                            <td><img src="/images/userr.png" style="width: 40px; height: 40px;"></td>
                        @else
                            <td><img src="/images/userred.png" style="width: 40px; height: 40px;"></td>
                        @endif
                        <!-- @if($bill->bills_transaction_id == NULL)
                            <td>NA</td>
                        @else
                            <td>{{$bill->bills_transaction_id}}</td>
                        @endif -->
                        </tr>
                        @endforeach
                        <!-- <tr>
                            <td>20190913960112</td>
                            <td>1234562</td>
                            <td>SEPT 2019</td>
                            <td>2019-08-16 to 2019-09-16</td>
                            <td>2019-09-16</td>
                            <td>2019-09-24</td>
                            <td>2019-09-25</td>
                            <td>799.15</td>
                            <td><img src="/images/userr.png" id="disco" style="height:30px"></td>
                            <td>112</td>
                        </tr>
                        <tr>
                            <td>20190913960113</td>
                            <td>1234561</td>
                            <td>SEPT 2019</td>
                            <td>2019-08-17 to 2019-09-17</td>
                            <td>2019-09-17</td>
                            <td>2019-09-25</td>
                            <td>2019-09-26</td>
                            <td>987.12</td>
                            <td><img src="/images/userred.png" id="disco" style="height:30px"></td>
                            <td>113</td>
                        </tr>
                        <tr>
                            <td>20190913960113</td>
                            <td>1234561</td>
                            <td>OCT 2019</td>
                            <td>2019-08-17 to 2019-09-17</td>
                            <td>2019-09-17</td>
                            <td>2019-09-25</td>
                            <td>2019-09-26</td>
                            <td>987.12</td>
                            <td><img src="/images/userred.png" id="disco" style="height:30px"></td>
                            <td>114</td>
                        </tr>                                             -->
                    </tbody>
                </table>
            </div>
        </div>
</div>

<script>
    const searchFun = () =>{
        let filter = document.getElementById('search').value.toUpperCase();
        let billingtable = document.getElementById('billingtable');
        let tr= billingtable.getElementsByTagName('tr');

        for (var i=0; i<tr.length; i++){
            let td =tr[i];

            if (td){
                for (k=0; k<10; k++){
                    let tx=td.getElementsByTagName('td')[k];

                    if (tx){
                        let textvalue = td.textContent || td.innerHTML;

                        if (textvalue.toUpperCase().indexOf(filter) > -1){
                            tr[i].style.display = "";
                        }else{
                            tr[i].style.display = "none";
                        }
                    }
                }
            }
        }
    }
</script>
@endsection