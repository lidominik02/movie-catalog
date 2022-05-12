<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Movie;
use App\Models\Rating;
use Storage;
use Auth;

class RatingController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->only(['store','update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('test');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'rating' => 'required|min:1|max:5',
            'comment' => 'nullable|max:255',
            'movie_id' => 'required|exists:movies,id'
        ],[
            'comment.max' => 'A komment maximális betű száma :max!',
            'rating.required' => 'Az értékelés megadása kötelező!',
            'rating.min' => 'Az értékelés 1 és 5 között legyen!',
            'rating.max' => 'Az értékelés 1 és 5 között legyen!',
            'movie_id.exist' => 'Ilyen film nem létezik!',
            'movie_id.required' => 'Film megadása kötelező!'
        ]);

        $ratedMovie = Movie::where('id','=',$data['movie_id'])->first();

        if(!isset($ratedMovie->ratings_enabled) || !$ratedMovie->ratings_enabled)
        {
            $request->session()->flash('rating_unable', true);
            return redirect()->route('movies.show', $data['movie_id']);
        }

        $data['user_id'] = Auth::user()->id;

        $rating = Rating::create($data);

        $request->session()->flash('rating_created', true);
        return redirect()->route('movies.show', $data['movie_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Rating $rating)
    {
        if(!(Auth::id() == $rating->user_id)){
            return abort(403);
        }

        $data = $request->validate([
            'rating' => 'required|min:1|max:5',
            'comment' => 'nullable|max:255',
            'movie_id' => 'required|exists:movies,id'
        ],[
            'comment.max' => 'A komment maximális betű száma :max!',
            'rating.required' => 'Az értékelés megadása kötelező!',
            'rating.min' => 'Az értékelés 1 és 5 között legyen!',
            'rating.max' => 'Az értékelés 1 és 5 között legyen!',
            'movie_id.exist' => 'Ilyen film nem létezik!',
            'movie_id.required' => 'Film megadása kötelező!'
        ]);

        Rating::where('id','=',$rating->id)
            ->update([
                'rating' => $data['rating'],
                'comment' => $data['comment'],
            ]);
        $request->session()->flash('rating_updated', true);
        return redirect()->route('movies.show', $data['movie_id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
