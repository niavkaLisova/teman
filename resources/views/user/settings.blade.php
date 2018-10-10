@extends('layouts.app')

@section('content')
<div class="container">
    <settings-component :user="{{$user}}"></settings-component>
</div>
@endsection