<div class="flex flex-wrap pt-5">
    <div class="flex justify-center items-center w-full mx-20 bg-white border border-2 border-gray-300 p-2 shadow-lg rounded-xl">
        <div class="text-center">
            <h1 class="text-center text-xl">
                {{ $headline }}
            </h1>
        </div>
    </div>
</div>
<!--
    title (string)
    director (string)
    description (text, nullable)
    year (integer)
    length (integer, másodpercekben mérjük)
    image (string, nullable)
-->
<div class="flex flex-wrap pt-2 pb-20">
    <div class="w-full h-full flex justify-center items-center mb-0 mx-20 bg-white border border-2 border-gray-300 p-2 shadow-lg rounded-xl">
        <div class="m-5 w-4/5">
            <form action={{ $route }} method={{ strtoupper($method) }} enctype="multipart/form-data">
                @csrf
                @if (isset($methodChanger))
                    @method(strtoupper($methodChanger))
                @endif
                <div class="grid grid-row-2 gap-3">
                    <div class="grid gap-3 grid-cols-1">
                        <div class="col-span-1">
                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" for="title">
                                <p class="ml-2">Cím:</p>
                                <input class="w-full rounded-xl shadow-md" type="text" id="title" name="title" placeholder="Film címe" value="{{$titleValue}}">
                            </label>
                            @error('title')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" for="director">
                                <p class="ml-2">Rendező neve:</p>
                                <input class="w-full rounded-xl shadow-md" type="text" id="director" name="director" placeholder="Rendező neve" value="{{$directorValue}}">
                            </label>
                            @error('director')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="col-span-1">
                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" for="length">
                                <p class="ml-2">Hosszúság (másodpercben):</p>
                                <input class="w-full rounded-xl shadow-md" type="number" id="length" name="length" placeholder="Film hossza másodpercben" value={{$lengthValue}}>
                            </label>
                            @error('length')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-1" >
                            <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" for="year">
                                <p class="ml-2">Megjelenés éve:</p>
                                <input class="w-full rounded-xl shadow-md" type="number" id="year" name="year" placeholder="Megjelenés éve" value={{$yearValue}}>
                            </label>
                            @error('year')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <label class="block uppercase text-blueGray-600 text-sm font-bold mb-2" for="description">
                        <p class="ml-2">Leírás:</p>
                        <textarea rows="5" class="w-full rounded-xl shadow-md" id="description" name="description" placeholder="Leírás">{{$descriptionValue}}</textarea>
                    </label>
                    @error('description')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <p class="block uppercase text-blueGray-600 text-sm font-bold mb-2" for="image">
                        Borítókép:
                    </p>
                    @if (isset($isModify))
                        <div class="flex flex-col">
                            <div class="self-center w-1/4 h-1/4 shadow-xl ring-2 ring-gray-500 rounded-lg">
                                <img id="display" class="rounded-xl" src={{ asset(
                                    $movie->image
                                        ? 'storage/thumbnails/' . $movie->image
                                        : 'images/placeholder.jpg'
                                    ) }}>
                            </div>
                            <div class="mt-5 self-center">
                                <input type="file" name="image" id="image">
                            </div>
                            @error('image')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                            <label class="self-center mt-1" for="deleteImage">
                                <input type="checkbox" name="deleteImage" id="deleteImage">
                                <span class="ml-2">Kép törlése</span>
                            </label>
                        </div>
                    @else
                        <div class="flex flex-col">
                            <div class="mt-2 self-start">
                                <input type="file" name="image" id="image">
                            </div>
                            @error('image')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="flex justify-between">
                    <div class="self-start mt-5">
                        <input
                        class="text-xl p-2 mt-5 border border-gray-400 rounded-xl hover:bg-gray-900 hover:text-white cursor-pointer"
                        type="submit" value="{{$submitValue}}">
                    </div>
                    @if (isset($isModify))
                        <div class="self-end">
                            <a href={{route('movies.show',$movie)}} >
                                <p class="text-xl p-2 mt-5 border border-gray-400 rounded-xl hover:bg-gray-900 hover:text-white cursor-pointer">
                                    Vissza
                                </p>
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
