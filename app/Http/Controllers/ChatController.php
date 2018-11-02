<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Chat;
use App\User;

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

    public function chatMessages()
    {
    	$id = Auth::id();
    	$companion = 2;

    	return DB::table('chats')
    		->where('users->1', $id)
		    ->orWhere('users->2', $companion)
		    ->get();
    }

    public function companionInfo(Request $request)
    {
    	return DB::table('users')
            ->whereIn('id', $request->list)
            ->select('name')
            ->get();
    }
}
