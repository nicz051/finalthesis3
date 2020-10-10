@extends('layouts.index')

@section('content')
    

    <div class="modal-dialog text-center">
		<div class="col-m-9 main-section">
			<div id="userprofile" class="modal-content" style="background-color: rgb(192, 192, 192)">
				
				<div class="col-12 user-img">
					<img src="images\userr.png">
				</div>
                <div class="col-12">
                    <h4>{{ Auth::user()->name }}</h4>
                    <h5>{{ Auth::user()->position }}</h5>
                    <p>{{ Auth::user()->username }}</p>
                </div>
            </div>
        </div>
    </div>





@endsection

