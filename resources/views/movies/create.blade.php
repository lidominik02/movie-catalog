<x-app-layout>
    @include('components.movie.form',[
        "headline" => "Film létrehozása",
        "route" => route('movies.store'),
        "method" => "POST",
        "titleValue" => old('title'),
        "directorValue" => old('director'),
        "lengthValue" => old('length'),
        "descriptionValue" => old('description'),
        "yearValue" => old('year'),
        "submitValue" => "Film létrehozása"
    ])
</x-app-layout>
