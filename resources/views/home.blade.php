@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div  class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Contacts Manager</div>
				<div class="panel-body">
					<div id="contact-list">
					{{-- REACT APP RENDER HERE --}}
					</div>
				</div>
			</div>	
        </div>
    </div>
</div>
@endsection
