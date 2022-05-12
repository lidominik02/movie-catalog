<x-app-layout>
    @if (Session::has('rating_created'))
            <div class="px-3 py-5 mb-5 bg-green-500 text-white font-semibold">
                A komment sikeresen létre lett hozva!
            </div>
    @endif
    @if (Session::has('rating_updated'))
            <div class="px-3 py-5 mb-5 bg-green-500 text-white font-semibold">
                A komment sikeresen módosítva lett!
            </div>
    @endif
    @if (Session::has('rating_unable'))
            <div class="px-3 py-5 mb-5 bg-red-500 text-white font-semibold">
                A kommentek levannak tiltva ennél a filmnél!
            </div>
    @endif
    @if (Session::has('ratings_deleted'))
            <div class="px-3 py-5 mb-5 bg-green-500 text-white font-semibold">
                {{Session::get('deleteCount')}} komment sikeresen törölve lett!
            </div>
    @endif
    @if (Session::has('ratings_zero'))
            <div class="px-3 py-5 mb-5 bg-red-500 text-white font-semibold">
                Nincsenek kommentek!
            </div>
    @endif
    @if (Session::has('movie_deleted'))
            <div class="px-3 py-5 mb-5 bg-green-500 text-white font-semibold">
                A film sikeresen törölve lett!
            </div>
    @endif
    @if (Session::has('movie_restored'))
            <div class="px-3 py-5 mb-5 bg-green-500 text-white font-semibold">
                A film sikeresen vissza lett állítva!
            </div>
    @endif
    @if (Session::has('movie_created'))
            <div class="px-3 py-5 mb-5 bg-green-500 text-white font-semibold">
                A film sikeresen létre lett hozva!
            </div>
    @endif
    <div class="grid grid-cols-2 pt-10 pr-10 pl-10 pb-0 mb-0">
        <div class="flex flex-wrap justify-center">
            <div class="w-5/10 px-4 py-0">
                <img class="" src={{ asset(
                    $movie->image
                        ? 'storage/thumbnails/' . $movie->image
                        : 'images/placeholder.jpg'
                    ) }}>
            </div>
        </div>
        <div class="grid grid-rows-2 gap-1">
            <div>
                <div class="flex flex-col">
                    <span class="text-3xl flex items-center justify-between">
                        {{$movie->title}}
                        @if ($movie->trashed())
                            <p class="text-red-500">(Törölve)</p>
                        @endif
                    </span>
                    <span class="text-xl">
                        {{$movie->director}}
                    </span>
                    <span class="text-lg">
                        Készült: {{$movie->year}}, Hossza: {{ date('H:i:s', mktime(0,0,$movie->length))}}
                    </span>
                </div>
                <div class="flex justify-items-end">
                    <ul class="flex justify-center">
                        @for ($i = 1; $i <= intval($avgRating);$i++)
                        <li>
                            <i class="fas fa-star fa-lg text-yellow-500 mr-1"></i>
                        </li>
                        @endfor
                        @for ($i = 1; $i<= 5-intval($avgRating);$i++)
                            <li>
                                <i class="far fa-star fa-lg text-yellow-500 mr-1"></i>
                            </li>
                        @endfor
                    </ul>
                </div>
                @auth
                    @if ($movie->ratings_enabled)
                        <div>
                            <a href="#rate">
                                <button class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                                    Értékelés
                                </button>
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
            <div>
                <div>
                    {{$movie->description}}
                </div>
                @auth
                    <div class="flex flex-wrap items-end justify-end flex-cols-2 gap-4">
                        @can('delete',$movie)
                            @php
                                $isMovieDeleted = $movie->trashed();
                            @endphp
                            @include("components.formButton",[
                            "buttonColor" => $isMovieDeleted ? "green" : "red",
                            "inputValue" => $isMovieDeleted ? "Film visszaállítása" : "Film törlése",
                            "method" => "post",
                            "methodChanger" => $isMovieDeleted ? "post" : "delete",
                            "route" => $isMovieDeleted ? route('movies.restore',$movie) : route('movies.destroy',$movie)
                            ])
                        @endcan
                        @can('update',$movie)
                            <a href={{ route('movies.edit', $movie )}}>
                                <button
                                    class="bg-yellow-500 hover:bg-yellow-400 text-white font-bold py-2 px-4 border-b-4 border-yellow-700 hover:border-yellow-500 rounded">
                                    Film módosítása
                                </button>
                            </a>
                        @endcan
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- component -->
    <div class="antialiased mx-auto max-w-screen-sm py-10">
        <div class="flex items-center justify-between">
            <h3 class="mb-4 ml-3 text-lg font-semibold text-gray-900">Értékelések</h3>
            @can('deleteRatings',$movie)
                <div>
                    @if ($ratings->count() != 0)
                        @include("components.formButton",[
                            "buttonColor" => "red",
                            "inputValue" => "Kommentek törlése",
                            "method" => "post",
                            "methodChanger" => "delete",
                            "route" => route('movies.deleteRatings',$movie)
                            ])
                    @endif
                </div>
            @endcan
        </div>
        <div class="space-y-4">
            @forelse ($ratings as $rating)
                <div class="flex">
                    <div class="flex-1 border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
                        <strong>
                            <!--Felhasználó név-->
                            {{--@foreach ($users as $user)
                                @if ($user->id == $rating->user_id)
                                    {{$user->name}}
                                @endif
                            @endforeach--}}
                            {{$rating->user->name}}
                        </strong>
                        <span class="text-xs text-gray-400">
                            <!--Dátum -->
                            {{$rating->updated_at}}
                        </span>
                        <div class="flex justify-start">
                            <ul class="flex justify-center">
                                @for ($i = 1; $i <= intval($rating->rating);$i++)
                                <li>
                                    <i class="fas fa-star fa-sm text-yellow-500 mr-1"></i>
                                </li>
                                @endfor
                                @for ($i = 1; $i<= 5-intval($rating->rating);$i++)
                                    <li>
                                        <i class="far fa-star fa-sm text-yellow-500 mr-1"></i>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                        <p class="text-sm">
                            <!--Comment-->
                            {{$rating->comment}}
                        </p>
                    </div>
                </div>
            @empty
                <p class="ml-3">Nincsenek értékelések!</p>
            @endforelse
                {{$ratings->links()}}
        </div>
    </div>

    <!-- comment form flex mx-auto  items-center justify-center shadow-lg mt-20 mx-8 mb-4 max-w-lg-->
    @auth
        @if (isset($movie->ratings_enabled) && $movie->ratings_enabled)
            @if ($ratings->contains(fn($rating) => $rating->user_id == Auth::id()))
            <div class="antialiased mx-auto max-w-screen-sm py-10">
                <form class="w-full bg-white rounded-lg px-4 pt-2" method="POST" action={{route('ratings.update',$ratings->firstWhere('user_id',Auth::id()))}}>
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap -mx-3 mb-6">
                        @php
                            $userOldRating = $ratings->firstWhere('user_id',Auth::id())->rating;
                        @endphp
                        <h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg w-full">Értékelés módosítása:</h2>
                        <div class="flex flex-warp pl-5 w-full gap-4">
                            <label class="inline-flex items-center gap-1">
                                <span>1</span>
                                <input type="radio" name="rating" value="1" {{(old('rating',$userOldRating) == 1) ? "checked" : ""}}>
                            </label>
                            <label class="inline-flex items-center gap-1">
                                <span>2</span>
                                <input type="radio" name="rating" value="2" {{(old('rating',$userOldRating) == 2) ? "checked" : ""}}>
                            </label>
                            <label class="inline-flex items-center gap-1">
                                <span>3</span>
                                <input type="radio" name="rating" value="3" {{(old('rating',$userOldRating) == 3) ? "checked" : ""}}>
                            </label>
                            <label class="inline-flex items-center gap-1">
                                <span>4</span>
                                <input type="radio" name="rating" value="4" {{(old('rating',$userOldRating) == 4) ? "checked" : ""}}>
                            </label>
                            <label class="inline-flex items-center gap-1">
                                <span>5</span>
                                <input type="radio" name="rating" value="5" {{(old('rating',$userOldRating) == 5) ? "checked" : ""}}>
                            </label>
                            @error('rating')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full md:w-full px-3 mb-2 mt-2">
                            <textarea class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white" name="comment" placeholder='Adja meg értékelését'>{{old('comment',$ratings->firstWhere('user_id',Auth::id())->comment)}}</textarea>
                            @error('comment')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-full md:w-full flex items-start md:w-full px-3 py-3">
                            <div class="-mr-1">
                                <input type='submit' class="bg-white text-gray-700 font-medium py-1 px-4 border border-gray-400 rounded-lg tracking-wide mr-1 hover:bg-gray-100" value= "Értékelés Módosítása">
                            </div>
                        </div>
                        @error('movie')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <input type="hidden" name="movie_id" value={{$movie->id}}>
                    </div>
                </form>
            </div>
            @else
                <div class="antialiased mx-auto max-w-screen-sm py-10">
                    <form class="w-full bg-white rounded-lg px-4 pt-2" method="POST" action={{route('ratings.store')}}>
                        @csrf
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg w-full">Értékelés hozzáadása:</h2>
                            <div class="flex flex-warp pl-5 w-full gap-4">
                                <label class="inline-flex items-center gap-1">
                                    <span>1</span>
                                    <input type="radio" name="rating" value="1" {{(old('rating') == 1) ? "checked" : ""}}>
                                </label>
                                <label class="inline-flex items-center gap-1">
                                    <span>2</span>
                                    <input type="radio" name="rating" value="2" {{(old('rating') == 2) ? "checked" : ""}}>
                                </label>
                                <label class="inline-flex items-center gap-1">
                                    <span>3</span>
                                    <input type="radio" name="rating" value="3" {{(old('rating') == 3) ? "checked" : ""}}>
                                </label>
                                <label class="inline-flex items-center gap-1">
                                    <span>4</span>
                                    <input type="radio" name="rating" value="4" {{(old('rating') == 4) ? "checked" : ""}}>
                                </label>
                                <label class="inline-flex items-center gap-1">
                                    <span>5</span>
                                    <input type="radio" name="rating" value="5" {{(old('rating') == 5) ? "checked" : ""}}>
                                </label>
                                @error('rating')
                                    <p class="text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="w-full md:w-full px-3 mb-2 mt-2">
                                <textarea class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white" name="comment" placeholder='Adja meg értékelését'>{{old('comment')}}</textarea>
                                @error('comment')
                                    <p class="text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="w-full md:w-full flex items-start md:w-full px-3 py-3">
                                <div class="-mr-1">
                                    <input type='submit' class="bg-white text-gray-700 font-medium py-1 px-4 border border-gray-400 rounded-lg tracking-wide mr-1 hover:bg-gray-100" value= "Értékelés hozzáadása">
                                </div>
                            </div>
                        </div>
                        @error('movie')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                        <input type="hidden" name="movie_id" value={{$movie->id}}>
                    </form>
                </div>
            @endif
        @endif
    @endauth
    <a id="rate"></a>
</x-app-layout>
