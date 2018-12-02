<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Chat;
use App\User;
use App\follower;

class ChatController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index($id = 0)
    {
        return view('chat.index')->with('chat_id', $id);
    }

    public function chatList()
    {
    	// $id = Auth::id();

    	// $chats = Chat::whereRaw('JSON_CONTAINS(users->"$.list", \'[' . $id . ']\')')->get();

        $chats = Auth::user()->chats()->with('users')->get();

    	return $chats;
    }

    public function updateTitle(Request $request)
    {
        Chat::find($request->chat_id)->update(['title' => $request->title]);
    }

    public function leaveChat(Request $request)
    {
        Auth::user()->chats()->detach([$request->chat_id]);
        $chat = Chat::find($request->chat_id);
        if($chat->users()->count() == 0) {
            $chat->messages()->delete();
            $chat->delete();
        }
    }

    public function findUser(Request $request) {
        $search = '%' . $request->search . '%';

        $users =  collect(Auth::user()->following()->where('name', 'like', $search)->take(10)->select('name', 'email', 'avatar', 'follower_id as id')->get());

        $users2 = collect(User::where('name', 'like', $search)
            ->where('id', '<>', Auth::id())
            ->take(10)
            ->select('name', 'email', 'avatar', 'id')
            ->get());

        $result = $users->merge($users2)->unique('id')->take(10);

        return $result;
    }

    public function chatState(Request $request) {
        $result = Chat::find($request->chat_id);
        $users = $result->users()->get();
        return ['chat' => $result, 'users' => $users];
    }

    // public function chatMessages()
    // {
    // 	$id = Auth::id();
    // 	$companion = 2;

    // 	return DB::table('chats')
    // 		->where('users->1', $id)
		  //   ->orWhere('users->2', $companion)
		  //   ->get();
    // }

    public function openChat(Request $request)
    {
       return Auth::user()->specChat($request->user_id)->get();
    }

    public function openPoliChat(Request $request)
    {
       return Auth::user()->specPoliChat($request->user_id)->get();
    }

    public function companionInfo(Request $request)
    {
    	return DB::table('users')
            ->whereIn('id', $request->list)
            ->select('name')
            ->get();
    }
}
