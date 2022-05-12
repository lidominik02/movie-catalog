<x-app-layout>
    <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
        @forelse ( $movies as $movie)
            <a href={{route('movies.show',$movie)}} class="rounded overflow-hidden shadow-lg bg-white" id={{$movie->id}}>
                <img class="w-full" src={{ asset(
                    $movie->image
                        ? 'storage/thumbnails/' . $movie->image
                        : 'images/placeholder.jpg'
                    ) }}>
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">
                        {{$movie->director.' - ' . $movie->title}}
                        @if ($movie->trashed())
                            <p class="text-red-500">(Törölve)</p>
                        @endif
                    </div>
                    <p class="text-gray-700 text-base">
                        {{ Str::of($movie->description)->limit(100)}}
                    </p>
                </div>

                <ul class="flex justify-center">
                    @foreach ($ratings as $rating)
                        @if ($rating->id == $movie->id)
                            @for ($i = 1; $i <= intval($rating->ratings_avg_rating);$i++)
                                <li>
                                    <i class="fas fa-star fa-sm text-yellow-500 mr-1"></i>
                                </li>
                            @endfor
                            @for ($i = 1; $i<= 5-intval($rating->ratings_avg_rating);$i++)
                                <li>
                                    <i class="far fa-star fa-sm text-yellow-500 mr-1"></i>
                                </li>
                            @endfor
                        @endif
                    @endforeach
                </ul>
            </a>
        @empty
            <p>Nincsenek filmek!</p>
        @endforelse
    </div>
    <div class="content-center p-6">
        {{ $movies->links() }}
    </div>
</x-app-layout>
