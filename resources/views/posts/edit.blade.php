@extends('layouts.app')

@section('content')
<div class="container">
    <edit-component :id="{{$post->id}}"></edit-component>

</div>
@endsection

