@extends('layouts.index')

@section('content')


<div class="container">
    <div class="row" style="margin-top: 120px;">
        <div class="col-md-offset-3 col-md-6">
            <form action="{{ url('sendreminder') }}" method="post">
                {{csrf_field()}}
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile number">
                    </div>
                    <button type="submit" class="btn btn-primary">Send SMS</button>
            </form>
        </div>
    </div>
</div>







@endsection