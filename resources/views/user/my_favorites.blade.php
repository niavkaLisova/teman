@extends('layouts.app')

@section('content')
<my-favorite :list="{{$myFavorites}}"></my-favorite>
{{-- <div class="container">
   <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h3>My Favorites</h3>
            </div>
            @forelse ($myFavorites as $myFavorite)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $myFavorite->title }}
                    </div>

                    <div class="panel-body">
                        {!! $myFavorite->body !!}
                    </div>
                    @if (Auth::check())
                        <div class="panel-footer">
                            <like-component
                                :post={{ $myFavorite->id }}
                                :favorited={{ $myFavorite->favorited() ? 'true' : 'false' }}
                            ></like-component>
                        </div>
                    @endif
                </div>
            @empty
                <p>You have no favorite posts.</p>
            @endforelse
         </div>
    </div>
</div>  --}}
@endsection