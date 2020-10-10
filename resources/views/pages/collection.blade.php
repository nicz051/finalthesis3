@extends('layouts.index')

@section('content')
<div id="searchcontainer" class="container" style="text-align: right">
    <input type="text" id="search" placeholder="Search Collection" onkeyup="searchFun()" style="margin-top:20px">
</div>

<div class="container" style="margin-top: 30px">
        <div class="row" style="height:450px; overflow-y: scroll; overflow-x: hidden;">
            <div class="col-md-12" style="text-align:center;">
                <table id= "collectiontable" class="table table-striped" style="background-color: rgb(192, 192, 192);">
                    <thead>
                        <tr>
                          <th>Transaction Id</th>
                          <th>Date-Time</th>
                          <th>Bill Id</th>
                          <th>Amount Paid</th>
                          <th>Credit Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{$transaction->transaction_id}}</td>
                            <td>{{$transaction->date_time}}</td>
                            <td>{{$transaction->transactions_bill_id}}</td>
                            <td>{{$transaction->amount_paid}}</td>
                            <td>{{$transaction->credit_balance}}</td>
                        </tr> 
                        @endforeach
                        <!-- <tr>
                          <td>112</td>
                          <td>2019-09-24 10:11:16</td>
                          <td>2019091396012</td>
                          <td>800</td>
                          <td>0.85</td>
                        </tr>
                        <tr>
                          <td>113</td>
                          <td>2019-09-21 10:53:01</td>
                          <td>2019091396011</td>
                          <td>1600</td>
                          <td>12.55</td>
                        </tr> -->
                        
                    </tbody>
                </table>
            </div>
        </div>
</div>
<script>
    const searchFun = () =>{
        let filter = document.getElementById('search').value.toUpperCase();
        let collectiontable = document.getElementById('collectiontable');
        let tr= collectiontable.getElementsByTagName('tr');

        
        for (var i=0; i<tr.length; i++){
            let td =tr[i];

            if (td){
                    for (k=0; k<5; k++){
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