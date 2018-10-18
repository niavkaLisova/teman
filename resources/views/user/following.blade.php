@extends('layouts.app')

@section('content')
<following-list :user_id="{{$user_id}}"></following-list>
@endsection