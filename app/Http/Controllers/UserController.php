<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        return view('user')->with('user', $user);
    }

    public function follow(Request $request, User $user)
	{
	    if($request->user()->canFollow($user)) {
	        $request->user()->following()->attach($user);
	    }
	    return redirect()->back();
	}

	public function unFollow(Request $request, User $user)
	{
	   if($request->user()->canUnFollow($user)) {
	       $request->user()->following()->detach($user);
	    }
	       return redirect()->back();
	}

	/**
	 * Get all favorite posts by user
	 *
	 * @return Response
	 */
	public function myFavorites()
	{
	    $myFavorites = Auth::user()->favorites;
	    
	    return view('user.my_favorites')->with('myFavorites', $myFavorites);
	}
}
