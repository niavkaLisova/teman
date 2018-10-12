<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Portfolio;
use App\User;

class PortfolioController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'indexInfo', 'show', 'showInfo']]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id = 0)
    {
    	if($user_id == 0 && Auth::id()) $user_id = Auth::id();
        return view('portfolio.index')->with('user_id', $user_id);
    }

    public function indexInfo(Request $request)
    {
    	$user_id = $request->get('user_id');
    	$portfolio = Portfolio::where('user_id', $user_id)->with('posts')->orderBy('created_at', 'desc')->with('users')->get();

    	return $portfolio;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('portfolio.create');
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //    $validator = $request->validate([
	    //     'title' => 'required|string|max:255|unique:portfolios'
	    // ]);

    	$title = $request->get('title');
    	$describe = $request->get('describe');

    	return Auth::user()->portfolios()->create(['title' => $title, 'describe' => $describe ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('portfolio.show')->with('id', $id);
    }

    public function showInfo(Request $request)
    {
    	$portfolio = Portfolio::where('id', $request->get('id'))
    		->with('posts')
    		->with('users')
    		->first();
    	return $portfolio;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$portfolio = Portfolio::find($id);
    	if($portfolio->user_id == Auth::id()) {
    		return view('portfolio.edit')->with('id', $id);
    	}
     	
     	return "You can not edit this Portfolio";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$portfolio = Portfolio::find($id);
    	$portfolio->title = $request->get('title');
    	$portfolio->describe = $request->get('describe');
    	$portfolio->save();

    	return $request->get('title');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Array
     */
    public function destroy($id)
    {
        $portfolio = Portfolio::find($id);

        // Check for correct user
        if(Auth::id() !== $portfolio->user_id) {
            return ['status' => 'Unautorized User'];
        }
        
        $portfolio->delete();

        return ['status' => 'ok'];
    }
}
