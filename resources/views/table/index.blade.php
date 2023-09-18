<x-app-layout>
    <div class="w-full flex flex-col items-center justify-center mt-20" id="app">
        @auth
            {{ Auth::user()->name }}
        @endauth
        <tables-component :restaurant="{{ json_encode( $restaurant_id ) }}"
                          :tables="{{ json_encode( $tables ) }}"
                          :open-from="{{ json_encode( $open_from ) }}"
                          :open-to="{{ json_encode( $open_to ) }}"
                          @auth :user="{{ json_encode( Auth::user()->name ) }}" @endauth
        ></tables-component>
    </div>
</x-app-layout>
