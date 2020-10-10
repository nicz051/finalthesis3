@extends('layouts.index')

@section('content')
<div id="searchcontainer" class="container" style="text-align: right">
    <input type="text" id="search" placeholder="Search Disconnected Accounts" onkeyup="searchFun()" style="margin-top:20px">
</div>

<div class="container" style="margin-top: 30px">
        <div class="row">
            <div class="col-md-12"  style="text-align:center">
                <table id= "disaccountstable" class="table table-striped" style="background-color: rgb(192, 192, 192)">
                    <thead>
                        <tr>
                          <!-- <td><strong>Account Number</strong></td>
                          <td><strong>Account Name</strong></td>
                          <td><strong>Meter Number</strong></td>
                          <td><strong>Address</strong></td>
                          <td><strong>Due Date</strong></td>
                          <td><strong>Disconnection Date-Time</strong></td> -->
                          <th>Account Number</th>
                          <th>Account Name</th>
                          <!-- <th>Meter Number</th> -->
                          <th>Address</th>
                          <th>Category</th>
                          <th>Post_Type</th>
                          <th>Status</th>
                          <th>Disconnection Date-Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($disconnectedaccounts as $disconnectedaccount)
                        <tr>
                            <td>{{$disconnectedaccount->account_number}}</td>
                            <td>{{$disconnectedaccount->account_name}}</td>
                            <td>{{$disconnectedaccount->address}}</td>
                            <td>{{$disconnectedaccount->category}}</td>
                            <td>{{$disconnectedaccount->post_type}}</td>
                            @if($disconnectedaccount->status == '0')
                                <td><img src="/images/userred.png" style="width: 40px; height: 40px;"></td>
                            @else
                                <td><img src="/images/userr.png" style="width: 40px; height: 40px;"></td>
                            @endif
                            <td>{{$disconnectedaccount->time}}</td>
                        </tr>
                    @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
</div>

<script>
    const searchFun = () =>{
        let filter = document.getElementById('search').value.toUpperCase();
        let disaccountstable = document.getElementById('disaccountstable');
        let tr= disaccountstable.getElementsByTagName('tr');

        
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
</script>
@endsection