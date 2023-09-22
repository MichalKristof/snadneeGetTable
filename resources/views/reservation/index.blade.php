<x-app-layout>
    <div class="w-full flex flex-col items-center justify-center mt-20" id="app">
        <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900">{{ $restaurant->name }}</h2>
        <div class="flex flex-col items-center justify-center">
            <span class="text-lx text-gray-500">{{ $restaurant->address }}</span>
            <span class="text-base text-gray-500">Opening hours: {{ $restaurant->open_from }} - {{ $restaurant->open_to }}</span>
        </div>

        <reservation-component :restaurant="{{ json_encode( $restaurant->id ) }}"
                               :times="{{ json_encode( $times ) }}"
                               :auth="{{ json_encode( Auth::id() ) }}"
                               :routeReservations="{{ json_encode(route('profile.reservations')) }}"
                               :routeHome="{{ json_encode(route('home')) }}"
        ></reservation-component>
    </div>
</x-app-layout>
