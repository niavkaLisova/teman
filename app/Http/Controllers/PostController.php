<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;
use Image;

class PostController extends Controller
{
      
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'postAll', 'postInfo']]);
        $this->middleware(['verified'], ['except' => ['index', 'show', 'postAll', 'postInfo']]);
    }

	public function index(Request $request, Post $post)
    {
        $posts = $post->whereIn('user_id', $request->user()->following()
            ->pluck('users.id')
            ->push($request->user()->id))
            ->where('type', 'public')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take($request->get('limit', 10))
            ->get();

        return response()->json($posts);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request, Post $post)
    {
        $newPost = $request->user()->posts()->create([
            'body' => $request->get('body'),
            'title' => $request->get('title'),
            'type' => $request->get('type'),
            'image' => 'noimage.jpg'
        ]);

        return response()->json($post->with('user')->find($newPost->id));
    }

    public function show(Post $post)
    {
        return view('posts.post')->with('post', $post);
    }

    public function postInfo(Request $request, Post $post)
    {
        $post = Post::where('id', $request->get('id'))
            ->with('user')
            ->with('favorite')
            ->first();

        return response()->json($post);
    }

    public function postAll()
    {
        $posts = Post::where('type', 'public')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts);
    }


    public function edit(Request $request, Post $post)
    {
        if($post->user_id == Auth::id()) {
            return view('posts.edit')->with('post', $post);
        } else {
            return 'Erorr';
        }
    }

    public function update(Request $request)
    {
        $post = Post::find($request->get('id'));
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->type = $request->get('type');

        $post->save();

        return $post;
    }

    public function destroy(Request $request)
    {
        $post = Post::find($request->get('id'));

        if(strlen($post->image) > 3 && $post->image != 'noimage.jpg') {
            $image_path = public_path('images') . '/' . $post->image; 
            unlink($image_path);
        }
           
        $post->delete();

        return ['status' => 'ok'];
    }

    public function imageStore(Request $request)
    {
        $imageName = time().'.'.$request->image->getClientOriginalExtension();

        $request->image->move(public_path('images'), $imageName);

        return response()->json(['success'=>'You have successfully upload image.', 'name' => $imageName]);
    }

    public function imageUpdate(Request $request)
    {
        $post = Post::find($request->get('id'));
        $image_path = 'no';
        // check prev img
        if(strlen($post->image) > 3 && $post->image != 'noimage.jpg') {
            $image_path = public_path('images') . '/' . $post->image; 
            unlink($image_path);
        }

        $post->image = $request->get('image');

        $post->save();

        return $image_path;
    }

    /**
     * Favorite a particular post
     *
     * @param  Post $post
     * @return Response
     */
    public function favoritePost(Post $post)
    {
        Auth::user()->favorites()->attach($post->id);

        return back();
    }

    /**
     * Unfavorite a particular post
     *
     * @param  Post $post
     * @return Response
     */
    public function unFavoritePost(Post $post)
    {
        Auth::user()->favorites()->detach($post->id);

        return back();
    }

    /**
     * Increment view count
     *
     * @return Response
     */
    public function visit(Request $request)
    {
        return Post::find($request->get('post_id'))->increment('view_count');
    }

}
