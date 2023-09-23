<x-app-layout>
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

    <section class="max-w-3xl mx-auto my-6">
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
                                <span class="font-semibold">{{ $reservation->date->format('d.m.Y') }}</span>
                            </div>
                        </div>
                        <div class="mt-4 text-red-500">
                            @if( $reservation->date > now()->format('Y-m-d') )
                                <a href="{{ route('profile.cancel-reservation', $reservation->id) }}"
                                   class="hover:underline">
                                    {{ __('Cancel Reservation') }}
                                </a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="bg-white shadow-lg rounded-lg p-4">
                <p class="text-lg font-semibold text-gray-900">
                    {{ __('No reservations yet') }}
                </p>
            </div>
        @endif
    </section>
</x-app-layout>
