<x-app-layout>
    <div class="w-full flex flex-col items-center justify-center mt-20" id="app">
        <section class="bg-cover bg-center py-12">
            <div class="container mx-auto text-center text-white">
                <h2 class="text-3xl font-semibold text-gray-800 text-center mb-8">{{ $restaurant->name }}</h2>

                <p class="text-gray-600 text-center">
                    {{ $restaurant->address }}
                </p>
                <p class="text-gray-600 text-center">
                    Opening hours: {{ $restaurant->open_from }} - {{ $restaurant->open_to }}
                </p>
            </div>
        </section>

        <reservation-component :restaurant="{{ json_encode( $restaurant->id ) }}"
                               :times="{{ json_encode( $times ) }}"
                               :auth="{{ json_encode( Auth::id() ) }}"
                               :routeReservations="{{ json_encode(route('profile.reservations')) }}"
                               :routeHome="{{ json_encode(route('home')) }}"
        ></reservation-component>
    </div>
</x-app-layout>
