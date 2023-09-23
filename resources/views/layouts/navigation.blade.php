<nav x-data="{ open: false }" class="fixed top-0 z-40 w-full bg-[#333333] shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto h-20 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-full items-center">
            <div class="flex items-center justify-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="text-white text-xl font-semibold">
                    <img class="w-12 h-auto" src="{{ asset('img/icon.svg')}}" alt="dining table">
                </a>

                <div class="hidden space-x-4 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('restaurants.index')" :active="request()->routeIs('restaurants.index')">
                        {{ __('Restaurants') }}
                    </x-nav-link>
                </div>
            </div>


            <!-- Authentication Links -->
            <div class="hidden space-x-4 sm:-my-px sm:ml-10 sm:flex">
                @auth
                    <!-- User Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-white text-sm font-medium hover:text-gray-300 focus:outline-none focus:text-gray-300 transition duration-150 ease-in-out">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.reservations')">
                                {{ __('Reservations') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Login and Register Links -->
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Log in') }}
                    </x-nav-link>

                    @if (Route::has('register'))
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('Register') }}
                        </x-nav-link>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-300 focus:outline-none focus:text-gray-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('restaurants.index')" :active="request()->routeIs('restaurants.index')">
                {{ __('Restaurants') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-700">
            <div class="px-4">
                @auth
                    <div class="text-base text-white font-semibold">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-300">{{ Auth::user()->email }}</div>
                @endauth
            </div>

            <div class="mt-3 space-y-1">
                @auth
                    <x-responsive-nav-link :href="route('profile.reservations')" class="text-gray-900 hover:text-gray-300">
                        {{ __('Reservations') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-900 hover:text-gray-300">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                    this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @else
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>

                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>
