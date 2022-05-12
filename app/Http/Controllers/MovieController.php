<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Movie;
use App\Models\Rating;
use App\Models\User;
use Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $ratings = (Auth::check() && Auth::user()->is_admin)
        ? Movie::select('id')->withTrashed()->withAvg('ratings','rating')->get()
        : Movie::select('id')->withAvg('ratings','rating')->get();

        $movies = (Auth::check() && Auth::user()->is_admin)
        ? $movies = Movie::withTrashed()->paginate(10)
        : $movies = Movie::paginate(10);

        return view('movies.index',compact('movies','ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Movie::class);
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Movie::class);

        $data = $request->validate([
                "title" => "required|max:255",
                "director" => "required|max:128",
                "year" => "required|integer|min:1870|max:". date('Y'),
                "description" => "nullable|max:512",
                "length" => "required|integer|min:0",
                "image" => "image|mimes:jpg,png|max:2048",
         ]);
        $data['ratings_enabled'] = true;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $data['image'] = $file->hashName();
            Storage::disk('public')->put('thumbnails/' . $data['image'], $file->get());
        }

        $newMovie = Movie::create($data);
        $request->session()->flash('movie_created', true);
        return redirect()->route('movies.show',$newMovie);
    }

    public function restore(Request $request,Movie $movie)
    {
        $this->authorize('restore',$movie);
        $movie->restore();
        $request->session()->flash('movie_restored', true);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        $this->authorize('view',$movie);

        $avgRating = Rating::where('movie_id','=',$movie->id)->avg('rating');

        $ratings = Rating::where('movie_id','=',$movie->id)
        ->orderBy('updated_at','desc')
        ->paginate(10);

        $userIDs = $ratings->map(fn($item)=>$item->user_id);
        $users = User::select('id','name')->whereIn('id',$userIDs)->get();
        return view('movies.show',compact('movie','ratings','avgRating','users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        $this->authorize('update',$movie);
        return view('movies.edit',compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Movie $movie)
    {
        $this->authorize('update',$movie);

        $data = $request->validate([
            "title" => "required|max:255",
            "director" => "required|max:128",
            "year" => "required|integer|min:1870|max:". date('Y'),
            "description" => "nullable|max:512",
            "length" => "required|integer|min:0",
            "image" => "image|mimes:jpg,png|max:2048",
        ]);
        $data['ratings_enabled'] = true;

        if ($request->hasFile('image')) {
            if(!is_null($movie->image)){
                $deleted = Storage::disk('public')->delete('thumbnails/' . $movie->image);
                abort_if(!$deleted,500);
            }
            $file = $request->file('image');
            $data['image'] = $file->hashName();
            Storage::disk('public')->put('thumbnails/' . $data['image'], $file->get());
        }

        if($request->has('deleteImage') && !$request->hasFile('image')){
            $deleted = Storage::disk('public')->delete('thumbnails/' . $movie->image);
            abort_if(!$deleted,500);
            $data['image'] = null;
        }

        abort_if(!$movie->update($data),500);

        $request->session()->flash('movie_updated', true);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Movie $movie)
    {
        $this->authorize('delete',$movie);

        if(!$movie->delete()){
            abort(500);
        }

        $request->session()->flash('movie_deleted', true);
        return back();
    }

    public function toplist()
    {
        $movies = Movie::select('id','title','image','director')
            ->withAvg('ratings','rating')
            ->orderBy('ratings_avg_rating','desc')
            ->take(6)->get();
        return view('movies.toplist',compact('movies'));
    }

    public function deleteRatings(Request $request,Movie $movie)
    {
        //abort_if(!Auth::user()->is_admin,403);
        $this->authorize('deleteRatings',Movie::class);

        $deleteCount = $movie->ratings()->delete();

        if($deleteCount === 0){
            $request->session()->flash('ratings_zero', true);
        }
        else{
            $request->session()->flash('deleteCount',$deleteCount);
            $request->session()->flash('ratings_deleted', true);
        }
        return back();
    }
}
