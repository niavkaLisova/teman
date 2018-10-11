@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <main-info :user="{{$user}}"></main-info>
            <following-component :following="{{$user->following}}"></following-component>
            <hr>
            <follow-component
                :check="{{Auth::check()}}"
                :auth="{{Auth::id()}}"
                :user="{{$user}}"
                :following="{{Auth::user()->following}}"
                ></follow-component>
            <info-component :user="{{$user}}"></info-component>
        </div>
        <div class="col-md-8">
        </div>
    </div>
</div>
@endsection