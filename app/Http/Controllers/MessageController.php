<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessagePushed;
use App\Message;
use App\Chat;

class MessageController extends Controller
{
    public function index($chat_id, $page)
    {
    	$perPage = 20;
    	$messages = Chat::find($chat_id)->messages()->orderBy('created_at', 'desc')->with('user')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($messages);
    }

    public function store(Request $request)
	{
		$id = $request->user()->id;

	    $message = Chat::find($request->chat_id)->messages()->create([
	    		"body"=> $request->body,
	    		"user_id" => $id,
	    		"read" => $request->read,
	    		"del" => '{"list": []}'
	    	]);

	    \App\Events\Message::dispatch($message, $request->chat_id, $request->user());

	    return response()->json($message);
	}

	public function read(Request $request) {
		$messages = Chat::find($request->chat_id)->messages()->where('user_id', '<>', Auth::id())->update(['read' => 1]);

    	$newMessages = Chat::find($request->chat_id)->messages()->orderBy('created_at', 'desc')->with('user')->paginate(20, ['*'], 'page', 0);
		return $newMessages;
	}

	public function readOne(Request $request) {
		$message = Message::find($request->message_id)->update(['read' => 1]);

		return $request->message_id;
	}
}
