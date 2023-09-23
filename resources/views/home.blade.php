<x-app-layout>
    <div class="w-full min-h-screen">
        <section class="bg-gray-100 py-12">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-semibold text-gray-800 text-center mb-8">Book Your Dinner Table With Ease</h2>

                <p class="text-gray-600 text-center mb-12">
                    Experience a delightful dining experience. Reserve your table in just a few simple steps.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:scale-105 duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-16 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 15a7 7 0 110-14 7 7 0 010 14zm0-12a1 1 0 00-1 1v5a1 1 0 002 0V6a1 1 0 00-1-1z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Easy Booking</h3>
                        <p class="text-gray-600">Book your table quickly and conveniently through our website.</p>
                    </div>

                    <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:scale-105 duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-16 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 15a7 7 0 110-14 7 7 0 010 14zm-1-9a1 1 0 00-1 1v3a1 1 0 002 0V9a1 1 0 00-1-1z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Variety of Choices</h3>
                        <p class="text-gray-600">Explore a wide range of restaurants and cuisines for your dinner.</p>
                    </div>

                    <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:scale-105 duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-16 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 15a7 7 0 110-14 7 7 0 010 14zm-1-10a1 1 0 00-1 1h2a1 1 0 000-2h-2a1 1 0 00-1 1z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Special Offers</h3>
                        <p class="text-gray-600">Discover exclusive deals and discounts on your bookings.</p>
                    </div>

                    <div class="bg-white shadow-lg rounded-lg p-6 text-center hover:scale-105 duration-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-16 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 15a7 7 0 110-14 7 7 0 010 14zm-2-9a1 1 0 012 0h2a1 1 0 110 2h-2a1 1 0 01-2 0z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Quality Service</h3>
                        <p class="text-gray-600">Enjoy top-notch service and a memorable dining experience.</p>
                    </div>
                </div>
            </div>
        </section>


        <div class="flex justify-center items-center my-10">
            <a href="{{ route('restaurants.index') }}"
                class="bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 hover:from-red-500 hover:via-pink-500 hover:to-purple-500 text-white font-semibold py-2 px-4 rounded-full transform hover:scale-105 transition duration-500 hover:shadow-xl"
            >
                Find restaurant
            </a>
        </div>


    </div>
</x-app-layout>
