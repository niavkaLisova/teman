@extends('layouts.app')

@section('content')
<div class="container">
    <portfolio-show :id="{{$id}}"></portfolio-show>
</div>
@endsection