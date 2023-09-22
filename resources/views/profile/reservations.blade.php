<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My reservations') }}
        </h2>
    </x-slot>

    <x-auth-session-status class="max-w-6xl flex items-center justify-center text-center my-5"
                           :status="session('status')"/>

    <div class="flex flex-col items-center justify-center py-12">
        <table class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 relative overflow-x-auto shadow-md sm:rounded-lg">
            <thead class="w-full text-sm text-left text-gray-500">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Reseravion Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Restaurant
                </th>
                <th scope="col" class="px-6 py-3">
                    Table
                </th>
                <th scope="col" class="px-6 py-3">
                    Time
                </th>
                <th scope="col" class="px-6 py-3">
                    Created
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>

            @if( $reservations->count() > 0 )
                @foreach( $reservations as $reservation )
                    <tr class="bg-white border-b bg-gray-800 hover:bg-gray-50">
                        <th scope="row" class="px-6 py-4 font-base text-gray-900 whitespace-nowrap dark:text-white">
                            #{{ $reservation->id }}
                        </th>
                        <th class="px-6 py-4">
                            {{ $reservation->restaurant->name }}
                        </th>
                        <th class="px-6 py-4">
                            {{ $reservation->table->table_number }}
                        </th>
                        <th class="px-6 py-4">
                            {{ $reservation->time_from }} - {{ $reservation->time_to }}
                        </th>
                        <th class="px-6 py-4">
                            {{ $reservation->created_at->format('d.m.Y H:i') }}
                        </th>
                        <th class="font-medium text-red-500">
                            @if( $reservation->time_from < now() )
                                <a href="{{ route('profile.cancel-reservation', $reservation->id) }}"
                                   class="hover:underline">Cancel</a>
                            @endif
                        </th>
                    </tr>

                @endforeach
            @else
                <tr class="bg-white border-b bg-gray-800 hover:bg-gray-50">
                    <th scope="row" class="px-6 py-4 font-base text-gray-900 whitespace-nowrap dark:text-white"
                        colspan="6">
                        No reservations yet
                    </th>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</x-app-layout>
