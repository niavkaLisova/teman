@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <chat-component :chat_id="{{$chat_id}}" :me="{{Auth::user()}}"></chat-component>
    </div>
</div>
@endsection