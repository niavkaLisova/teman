@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            @if(Auth::id())
                <main-info :user="{{$user}}" me="{{Auth::id()}}"></main-info>
            @else
                <main-info :user="{{$user}}" me=0></main-info>
            @endif
            <following-component :following="{{$user->following}}"></following-component>
            <hr>
            @if(Auth::id())
            <follow-component
                :check="{{Auth::check()}}"
                :auth="{{Auth::id()}}"
                :user="{{$user}}"
                :following="{{Auth::user()->following}}"
                ></follow-component>
            @endif
            <info-component :user="{{$user}}"></info-component>
        </div>
        <div class="col-md-8">
            <p>Test in User blade php</p>
        </div>
    </div>
</div>
@endsection