<x-app-layout>
    <div class="w-full min-h-screen">
        <section class="bg-cover bg-center py-12">
            <div class="container mx-auto text-center text-white">
                <h2 class="text-3xl font-semibold text-gray-800 text-center mb-8">{{ __('Choose your restuarant') }}</h2>

                <p class="text-gray-600 text-center">
                    {{ __('Warning: You must be logged in to make a reservation.') }}
                </p>
            </div>
        </section>

        <section class="mx-2 md:mx-5 rounded-2xl space-y-4 flex flex-col items-center justify-center">
            <div class="gap-8 flex flex-col items-center py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach( $restaurants as $restaurant)
                        <a href="{{ route('reservation.index', $restaurant->slug) }}" class="flex flex-col gap-5 bg-white hover:shadow-lg rounded-lg p-6 transition duration-300 transform hover:scale-105">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $restaurant->name }}</h3>
                            <p class="flex flex-inline items-center text-gray-600">
                                <img class="w-7 h7 mr-2" src="{{ asset('img/map-point.svg') }}" alt="Map point">
                                {{ $restaurant->address }}
                            </p>
                            <p class="flex flex-wrap items-center text-gray-600">
                                <img class="w-7 h7 mr-2" src="{{ asset('img/time.svg') }}" alt="Map point">
                                {{ $restaurant->open_from }} - {{ $restaurant->open_to }}
                            </p>
                            <p class="flex flex-wrap items-center text-gray-600">
                                Tables: {{ $restaurant->capacity }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
