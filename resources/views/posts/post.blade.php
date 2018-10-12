@extends('layouts.app')

@section('content')
	@if(Auth::id()) 
		<post-component :user="{{Auth::id()}}" :id="{{$post->id}}" :favorited={{ $post->favorited() ? 'true' : 'false' }}></post-component>

		<comments-component :user="{{Auth::id()}}" :author="{{$post->user->id}}" :id="{{$post->id}}"></comments-component>
	@else
		<post-component :user=0 :id="{{$post->id}}" ></post-component>
		<comments-component :user=0 :author="{{$post->user->id}}" :id="{{$post->id}}"></comments-component>
	@endif
@endsection
