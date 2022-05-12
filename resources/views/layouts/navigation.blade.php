<nav class="flex items-center justify-between bg-white p-6">
    <div class="flex items-center flex-shrink-0 text-black mr-6">
      <span class="font-semibold text-xl tracking-tight"><a href={{route('movies.index')}}>Főoldal</a> </span>
    </div>
    <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
        <div class="text-sm lg:flex-grow">
          <a href={{route('movies.toplist')}} class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 mr-4">
            Toplista
          </a>
        </div>
    </div>
    @auth
        <div class="flex items-center flex-shrink-0 text-black mr-6">
            <span class="font-semibold text-xl tracking-tight">{{Auth::user()->name}}</span>
        </div>
        @if (Route::is('movies.index') &&Auth::user()->can('create',App\Models\Movie::class))
            <div>
                <a href={{route('movies.create')}} class="inline-block text-sm px-4 py-2 leading-none border rounded text-black border-black hover:border-transparent hover:text-teal-500 hover:text-white hover:bg-black mt-4 lg:mt-0">Új film</a>
            </div>
        @endif
        <div>
            <form method="POST" action="{{ route('logout') }}" id="nav-logout-form">
                @csrf
                <a class="inline-block text-sm px-4 py-2 leading-none border rounded text-black border-black hover:border-transparent hover:text-teal-500 hover:text-white hover:bg-black mt-4 lg:mt-0"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.querySelector('#nav-logout-form').submit();"
                >
                    Kilépés
                </a>
            </form>
        </div>
    @else
        <div>
            <a href={{route('login')}} class="inline-block text-sm px-4 py-2 leading-none border rounded text-black border-black hover:border-transparent hover:text-teal-500 hover:text-white hover:bg-black mt-4 lg:mt-0">Bejelentkezés</a>
            <a href={{route('register')}} class="inline-block text-sm px-4 py-2 leading-none border rounded text-black border-black hover:border-transparent hover:text-teal-500 hover:text-white hover:bg-black mt-4 lg:mt-0">Regisztráció</a>
        </div>
    @endauth
</nav>
