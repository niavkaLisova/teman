@extends('layouts.app')

@section('content')
<follower-list :user_id="{{$user_id}}"></follower-list>
@endsection