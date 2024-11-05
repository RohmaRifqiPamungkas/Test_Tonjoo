<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-full mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Dashboard Link -->
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Home Page') }}
                    </x-nav-link>

                    <!-- News Link -->
                    <x-nav-link href="{{ route('news') }}" :active="request()->routeIs('news')">
                        {{ __('News') }}
                    </x-nav-link>

                    <!-- Pesanan Link -->
                    <x-nav-link href="{{ route('pesanan') }}" :active="request()->routeIs('pesanan')">
                        {{ __('Pesanan') }}
                    </x-nav-link>

                    <!-- Kontak Link -->
                    <x-nav-link href="{{ route('kontak') }}" :active="request()->routeIs('kontak')">
                        {{ __('Kontak') }}
                    </x-nav-link>

                </div>
            </div>
            
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Transactions Dropdown -->
                <div class="relative ms-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                                {{ __('Transactions') }}
                                <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- All Transactions -->
                            <x-dropdown-link href="{{ route('transactions.index') }}">
                                {{ __('All Transactions') }}
                            </x-dropdown-link>
                            <!-- Add Transaction -->
                            <x-dropdown-link href="{{ route('transactions.create') }}">
                                {{ __('Add Transaction') }}
                            </x-dropdown-link>
                            <!-- Transaction Recap -->
                            <x-dropdown-link href="{{ route('transactions.recap') }}">
                                {{ __('Transaction Recap') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- User Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                                {{ Auth::user()->name }}
                                <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Account') }}</div>
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>
