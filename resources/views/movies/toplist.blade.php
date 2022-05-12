<x-app-layout>
    <div class="flex h-auto p-6 justify-center items-center">
        <div class="text-center">
            <span class="font-semibold text-xl tracking-tight">
                Toplista
            </span>
        </div>
    </div>
    <div class="flex flex-col text-left h-auto px-20">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div
              class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider " >
                      Film címe
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-left text-xs
                        font-medium
                        text-gray-500
                        uppercase
                        tracking-wider
                      "
                    >
                      Film szerzője
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-left text-xs
                        font-medium
                        text-gray-500
                        uppercase
                        tracking-wider
                      "
                    >
                      Értékelés
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @forelse ($movies as $movie)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-15 w-10">
                            <a href={{route('movies.show',$movie)}}>
                                <img class="h-10 w-10 "
                                    src={{ asset(
                                        $movie->image
                                            ? 'storage/thumbnails/' . $movie->image
                                            : 'images/placeholder.jpg'
                                        ) }}
                                />
                            </a>
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            <a href={{route('movies.show',$movie)}}>{{$movie->title}}</a>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{$movie->director}}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <ul class="flex justify-center">
                            @for ($i = 1; $i <= intval($movie->ratings_avg_rating);$i++)
                                <li>
                                    <i class="fas fa-star fa-sm text-yellow-500 mr-1"></i>
                                </li>
                            @endfor
                            @for ($i = 1; $i<= 5-intval($movie->ratings_avg_rating);$i++)
                                <li>
                                    <i class="far fa-star fa-sm text-yellow-500 mr-1"></i>
                                </li>
                            @endfor
                        </ul>
                    </td>
                  </tr>
                  @empty
                  @endforelse

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
</x-app-layout>
