@extends('layouts.app')

@section('content')
<div class="container">
    <edit-component :id="{{$post->id}}" :me="{{Auth::id()}}"></edit-component>

</div>
@endsection

