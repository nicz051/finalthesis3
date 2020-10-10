@extends('layouts.index')

@section('content')




<!-- <div class="container">
    @if(isset($details))
        <p> The Search results for your query <b> {{ $query }} </b> are :</p>
    <h2>Sample User details</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Account Number</th>
                <th>Account Name</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Meter Number</th>
                <th>Category</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $user)
            <tr>
                <td>{{$user->account_number}}</td>
                <td>{{$user->account_name}}</td>
                <td>{{$user->address}}</td>
                <td>{{$user->contact_number}}</td>
                <td>{{$user->meter_number}}</td>
                <td>{{$user->category}}</td>
                <td>{{$user->status}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div> -->








@endsection