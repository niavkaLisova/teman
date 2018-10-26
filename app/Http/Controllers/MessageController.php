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
	    		"del" => '{"list": []}'
	    	]);

	    \App\Events\Message::dispatch($message, $request->chat_id, $request->user());

	    return response()->json($message);
	}
}
