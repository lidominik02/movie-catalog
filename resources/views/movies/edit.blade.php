<x-app-layout>
    @if (Session::has('movie_updated'))
            <div class="px-3 py-5 mb-5 bg-green-500 text-white font-semibold">
                A film sikeresen módosítva lett!
            </div>
    @endif
    @include('components.movie.form',[
        "headline" => "Film módosítása",
        "route" => route('movies.update',$movie),
        "method" => "POST",
        "methodChanger" => "PUT",
        "isModify" => true,
        "titleValue" => old('title',$movie->title),
        "directorValue" => old('director',$movie->director),
        "lengthValue" => old('length', $movie->length),
        "descriptionValue" => old('description',$movie->description),
        "yearValue" => old('year',$movie->year),
        "submitValue" => "Film módosítása"
    ])
</x-app-layout>
