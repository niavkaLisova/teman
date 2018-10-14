@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form-component :me="{{Auth::id()}}"></form-component>
        </div>
    </div>
</div>
@endsection

