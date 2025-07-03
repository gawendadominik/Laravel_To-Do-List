<nav x-data="{ mobileMenuOpen: false, profileMenuOpen: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center h-14 text-3xl md:text-4xl font-black tracking-tight text-transparent bg-gradient-to-br from-orange-400 via-orange-500 to-orange-700 bg-clip-text drop-shadow-lg animate-gradient-x">
                    Tasklify
                </a>
            </div>

            <!-- Desktop Links (hidden, only one invisible link for accessibility/structure) -->
            <div class="hidden md:flex md:space-x-8 md:items-center md:flex-1 md:justify-center">
                <a href="#" class="invisible">Hidden</a>
            </div>

            <!-- Right side: Account -->
            <div class="flex items-center space-x-4">
                <!-- Profile dropdown -->
                <div class="relative" x-data="{ open: false }" @keydown.escape="open = false" @click.away="open = false">
                    <a @click.prevent="open = !open" href="#" class="px-2 py-1 text-gray-700 hover:text-orange-600 transition-colors font-medium focus:outline-none" style="font-size: 1rem;">
                        My Account
                    </a>

                    <div x-show="open" x-transition x-cloak style="display: none;" class="origin-top-right absolute right-0 mt-2 w-60 rounded-md shadow bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-20" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <!-- User Info Section -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-9 h-9 text-orange-300" fill="none" stroke="currentColor" stroke-width="2"
                                         viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="7" r="4"/>
                                        <path d="M5.5 21a7.5 7.5 0 0 1 13 0"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 text-base">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                        </div>
                        <!-- Dropdown Links -->
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-50" role="menuitem" tabindex="-1">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-50" role="menuitem" tabindex="-1">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-orange-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <svg x-show="!mobileMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu (hidden, only one invisible link for structure) -->
    <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t border-gray-200">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="#" class="invisible">Hidden</a>
        </div>
    </div>
</nav>
