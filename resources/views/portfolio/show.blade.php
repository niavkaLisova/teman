@extends('layouts.app')

@section('content')
<div class="container">
    @if(Auth::id())
    	<portfolio-show :id="{{$id}}" :me="{{Auth::id()}}"></portfolio-show>
    @else
    	<portfolio-show :id="{{$id}}" :me=0></portfolio-show>
    @endif
</div>
@endsection