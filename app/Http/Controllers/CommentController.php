<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Post;
use App\User;

class CommentController extends Controller
{
	/**
    * get comments for post
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
 
   public function index($comment, $page)
   {
   		$perPage = 5;
   		if($page == 0) {
   			$count = Comment::where('post_id', $comment)->where('reply_id', 0)->count();
   			$page = ceil($count / $perPage);
   		}

   		$comments = Comment::where('post_id', $comment)
   			->where('reply_id', 0)
   			->with('user')
   			->with('replies')
   			->paginate($perPage, ['*'], 'page', $page);

   		return response()->json($comments);
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
 
   public function store(Request $request, Comment $comment)
   {
        $newComment = Post::find($request->post_id)->comments()->create([
        	'comment' => $request->get('comment'),
        	'user_id' => $request->get('user_id'),
        	'edit' => false
        ]);
        
        return response()->json($comment->with('user')->with('replies')->find($newComment->id));
   }
   
   public function storeReply(Request $request, Comment $comment)
   {
        $newComment = Post::find($request->post_id)->comments()->create([
        	'comment' => $request->get('comment'),
        	'user_id' => $request->get('user_id'),
        	'reply_id' => $request->get('reply_id'),
        	'edit' => false
        ]);
        
        return response()->json($comment->with('user')->find($newComment->id));
   }

   /**
    * Update Comment
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request)
   {
   		$comment = Comment::find($request->get('comment_id'));
   		$comment->comment = $request->get('comment');
   		$comment->edit = true;
   		$comment->updated_at = date("Y-m-d H:i:s");

   		$comment->save();

   		return $comment;
   }

   /**
     * Destroy Comment
     *
     * @return void
     */
   public function destroy(Request $request)
   {
   		Comment::where('id', $request->get('comment_id'))
   			->orWhere('reply_id', $request->get('comment_id'))
   			->delete();
   		return ['status' => 'ok'];
   }

}
