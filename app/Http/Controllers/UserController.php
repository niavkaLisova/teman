<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Follower;

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

    public function showChangePassword(Request $request)
    {
        $validator = $request->validate([
	        'password' => 'required|string|min:6'
	    ]);

	    $user = User::find(Auth::id());
	    $user->password = Hash::make($request->get('password'));
	    $user->save();

    	return ['status' => 'ok'];
    }

    public function showChangeEmail(Request $request)
    {
    	$validator = $request->validate([
	        'email' => 'required|string|email|max:255|unique:users'
	    ]);

	    $user = User::find(Auth::id());
	    $user->email = $request->get('email');
	    $user->save();

    	return ['status' => 'ok'];
    	
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

	public function unfollowpost(Request $request)
	{
		$follow = Follower::where('user_id', AUth::id())
			->where('follower_id', $request->get('user'))
			->get();

		if($follow);
			$follow[0]->delete();

		return ['status' => 'ok'];
	}

	public function followpost(Request $request)
	{
		$follow = Follower::create([
			'user_id' => Auth::id(),
			'follower_id' => $request->get('user')
		]);

		return $follow;
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

	public function imageStore(Request $request)
    {
        $imageName = time().'.'.$request->image->getClientOriginalExtension();

        $request->image->move(public_path('storage/user'), $imageName);

        return response()->json(['success'=>'You have successfully upload image.', 'name' => $imageName]);
    }

    public function imageUpdate(Request $request)
    {
        $user = User::find($request->get('id'));
        $image_path = 'no';

        // check prev img
        if(strlen($user->avatar) > 3 && $user->avatar != 'noimage.jpg') {
            $image_path = public_path('storage/user') . '/' . $user->avatar; 
            unlink($image_path);
        }

        $user->avatar = $request->get('image');

        $user->save();

        return ['status' => 'ok'];
    }
}
