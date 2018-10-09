@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    	
        <div class="col-md-4">
            Some conent
        </div>
        <div class="col-md-8">
            <timeline-component id="{{ Auth::id()}}"></timeline-component>
        </div>
    </div>
</div>
@endsection

