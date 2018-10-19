@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <chat-component :chat_id="{{$chat_id}}"></chat-component>
        <user-component :chat_id="{{$chat_id}}"></user-component>
    </div>
</div>
@endsection