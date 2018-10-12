@extends('layouts.app')

@section('content')
<div class="container">
    <portfolio-edit :id="{{$id}}"></portfolio-edit>
</div>
@endsection