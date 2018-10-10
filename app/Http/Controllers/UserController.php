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

    public function settings()
    {
    	$user = User::find(Auth::id());

    	return view('user.settings')->with('user', $user);
    }

    public function updateInfo(Request $request)
    {
       	$update = $request->get('update');
       	$date = $update['bday'];
    	$user = User::find($update['id']);
    	$user->username = $update['username'];
    	$user->gender = $update['gender'];
    	$user->bday = $date;
    	$user->country = $update['country'];
    	$user->city = $update['city'];
    	$user->save();

    	return ['status'=> $date];
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
