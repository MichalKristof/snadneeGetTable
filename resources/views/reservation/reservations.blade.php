<x-app-layout>
    <div class="w-full flex flex-col min-h-screen">
        <section class="bg-cover bg-center py-12">
            <div class="container mx-auto text-center text-white">
                <h2 class="text-3xl font-semibold text-gray-800 text-center mb-8">
                    {{ __('My Reservations') }}
                </h2>

                <p class="text-gray-600 text-center">
                    {{ __("View and manage your reservations.") }}
                </p>
            </div>
        </section>

        <section class="w-full max-w-3xl mx-auto my-6">
            @if(session('success'))
                <div id="success-container"
                     class="w-full text-center bg-green-200 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if( $reservations->count() > 0)
                <ul class="space-y-4">
                    @foreach( $reservations as $reservation)
                        <li class="bg-white shadow-lg rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <span class="text-lg font-semibold text-gray-900">
                                        Reservation #{{ $reservation->id }}
                                    </span>
                                    @if( $reservation->date > now()->format('Y-m-d') )
                                        <div class="w-4 h-4 bg-green-400 rounded-full"></div>
                                    @endif
                                </div>
                                <span class="text-sm text-gray-600">
                                    Created: {{ $reservation->created_at->format('d.m.Y H:i') }}
                            </span>
                            </div>
                            <div class="mt-2 text-sm text-gray-600">
                                <div class="flex items-center space-x-4">
                                    <span>{{ __('Restaurant: ') }}</span>
                                    <span class="font-semibold">{{ $reservation->restaurant->name }}</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span>{{ __('Table: ') }}</span>
                                    <span class="font-semibold">{{ $reservation->table->table_number }}</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span>{{ __('Time: ') }}</span>
                                    <span
                                        class="font-semibold">{{ $reservation->time_from }} - {{ $reservation->time_to }}</span>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span>{{ __('Date: ') }}</span>
                                    <span class="font-semibold">{{ $reservation->date }}</span>
                                </div>
                            </div>
                            <div class="mt-4 text-red-500">
                                @if( $reservation->date > now()->format('Y-m-d') )
                                    <form action="{{ route('reservation.cancelReservation', $reservation->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="hover:underline">
                                            {{ __('Cancel Reservation') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="w-full bg-white shadow-lg rounded-lg p-4 mb-10">
                    <p class="text-lg font-semibold text-gray-900">
                        {{ __('No reservations yet') }}
                    </p>
                </div>
            @endif

            <div class="flex justify-center items-center my-10">
                <a href="{{ route('restaurants.index') }}"
                   class="flex items-center justify-center px-3 py-2 text-center bg-gradient-to-r from-purple-500 to-red-500 border-2 border-gray-100 hover:border-gray-800 text-white font-semibold py-2 px-4 rounded-2xl hover:shadow-xl duration-500">
                    Create new reservation
                </a>
            </div>
        </section>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let successContainer = document.getElementById("success-container");
        if (successContainer) {
            setTimeout(function () {
                successContainer.style.display = "none";
            }, 3000);
        }
    });
</script>

