@extends('layouts.app')

@section('content')
<div class="container">
	@if(Auth::id()) 
    	<portfolio-index :user_id="{{$user_id}}" :me="{{Auth::id()}}"></portfolio-index>
    @else
		<portfolio-index :user_id="{{$user_id}}" :me="0"></portfolio-index>
    @endif
</div>
@endsection