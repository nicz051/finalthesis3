@extends('layouts.index')

@section('content')


<div id="searchcontainer" class="container" style="text-align: right">
    <input type="text" id="search" placeholder="Search Accounts" onkeyup="searchFun()" style="margin-top:20px">
</div>

<div class="container" style="margin-top: 30px">
        <div class="row" >
            <div class="col-md-12" style="text-align: center">
                <table id= "accountstable" class="table table-striped" style="background-color: rgb(192, 192, 192)">
                    <thead>
                          <th>Account Number</th>
                          <th>Account Name</th>
                          <!-- <th>Meter Number</th> -->
                          <th>Address</th>
                          <th>Category</th>
                          <th>Post Type</th>
                          <th>Credit Balance</th>
                          <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($accounts as $account)
                        <tr>
                            <td>{{$account->account_number}}</td>
                            <td>{{$account->account_name}}</td>
                            <!-- <td>{{$account->meter_number}}</td> -->
                            <td>{{$account->address}}</td>
                            <td>{{$account->category}}</td>
                            <td>{{$account->post_type}}</td>
                            <td>{{$account->credit_balance}}</td>
                        @if($account->status == '1')
                            <td><img src="/images/userr.png" style="width: 40px; height: 40px;"></td>
                        @else
                            <td><img src="/images/userred.png" style="width: 40px; height: 40px;"></td>
                        @endif
            
                        </tr>
                    @endforeach
                        <!-- <tr>
                            <td>1396013</td>
                            <td>Villanueva, Jane</td>
                            <td>1234561</td>
                            <td>Alijis, Bacolod City</td>
                            <td>Residential</td>
                            <td>15.65</td>
                            <td><img src="/images/userr.png" id="disco" style="height:30px"></td>
                        </tr>
                        <tr>
                            <td>1396012</td>
                            <td>Batulan, Shairra</td>
                            <td>1234562</td>
                            <td>Tangub, Bacolod City</td>
                            <td>Commercial</td>
                            <td>0</td>
                            <td><img src="/images/userred.png" id="disco" style="height:30px"></td>
                        </tr>
                        <tr>
                            <td>1396015</td>
                            <td>Cimatu, Bern</td>
                            <td>1234563</td>
                            <td>Villamonte, Bacolod City</td>
                            <td>Residential</td>
                            <td>1.25</td>
                            <td><img src="/images/userred.png" id="disco" style="height:30px"></td>
                        </tr>
                        <tr>
                            <td>1396014</td>
                            <td>Mendoza, Jenny</td>
                            <td>1234564</td>
                            <td>Homesite, Bacolod City</td>
                            <td>Commercial</td>
                            <td>7.15</td>
                            <td><img src="/images/userr.png" id="disco" style="height:30px"></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container">
            <!-- <div class="row" >
                <button onclick="sortTableAccountNumber()" style="padding: 3px">Sort by Account Number</button>
            </div> -->
            <div class="row" style="margin-top: 10px">
                <button onclick="sortTableAccountName()" style="padding: 3px">Sort by Account Name</button>
            </div>
            <!-- <div class="row" style="margin-top: 10px">
                <button onclick="sortTableAccountName()" style="padding: 3px">Filter Disconnected Accounts</button>
            </div> -->
        </div>
</div>

<script>
    const searchFun = () =>{
        let filter = document.getElementById('search').value.toUpperCase();
        let accountstable = document.getElementById('accountstable');
        let tr= accountstable.getElementsByTagName('tr');

        
        for (var i=0; i<tr.length; i++){
            let td =tr[i];

            if (td){
                    for (k=0; k<6; k++){
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

        function sortTableAccountName(){
            var table, i, x, y;
            table= document.getElementById('accountstable');
            var switching=true;

            while(switching){
                switching=false;
                var rows=table.rows;

                for (i=1; i<(rows.length-1); i++){
                    var Switch=false;

                    x=rows[i].getElementsByTagName("td")[1];
                    y=rows[i+1].getElementsByTagName("td")[1];

                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()){
                        Switch=true;
                        break;
                    }
                }
                if (Switch){
                    rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
                    switching=true;
                }
            }
        }

        function sortTableAccountNumber(){
            var table, i, x, y;
            table= document.getElementById('accountstable');
            var switching=true;

            while(switching){
                switching=false;
                var rows=table.rows;

                for (i=1; i<(rows.length-1); i++){
                    var Switch=false;

                    x=rows[i].getElementsByTagName("td")[0];
                    y=rows[i+1].getElementsByTagName("td")[0];

                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()){
                        Switch=true;
                        break;
                    }
                }
                if (Switch){
                    rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
                    switching=true;
                }
            }
        }

</script>

                    
    
@endsection