@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h3>{{ $user->name }}</h3>
            @if(Auth::check() && Auth::user()->isNot($user))
                @if(Auth::user()->isFollowing($user))
                    <a href="{{ route('user.unfollow', $user) }}" class="btn btn-danger">No Follow</a>
                @else
                     <a href="{{ route('user.follow', $user) }}" class="btn btn-success">Follow</a>
                @endif
            @endif
        </div>
        <div class="col-md-8">
        </div>
    </div>
</div>
@endsection