<nav class="bg-white border-b border-gray-200 shadow-md">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

        <!-- Logo / Brand -->
        <a href="/" class="flex items-center space-x-3">
            <span class="self-center text-2xl font-bold text-gray-800">Shop Module</span>
        </a>

        <!-- Mobile Toggle -->
        <button data-collapse-toggle="navbar-dropdown" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-600 rounded-lg md:hidden
                       hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>

        <!-- Navbar Links -->
        <div class="hidden w-full md:flex md:items-center md:w-auto justify-end space-x-6" id="navbar-dropdown">
            <ul class="flex flex-col md:flex-row md:space-x-6 font-medium items-center p-4 md:p-0 mt-4 md:mt-0">

                {{-- Guest Links --}}
                @guest
                    <li>
                        <a href="/auth/login"
                           class="block bg-black text-white rounded-sm px-3 py-1 hover:bg-gray-800 transition">
                            Login
                        </a>
                    </li>
                @endguest

                {{-- Authenticated Links --}}
                @auth
                    {{-- Shop --}}

                    <li>
                        <a href="/products"
                           class="block bg-indigo-600 text-white px-3 py-1 rounded-sm hover:bg-indigo-700 transition">
                            {{auth()->user()->profile->role === 'customer'?'Shop now':'Products'}}
                        </a>
                    </li>

                    {{-- Admin --}}
                    @if(auth()->check() && auth()->user()->profile->role === 'admin')
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                               class="block text-gray-700 hover:text-indigo-600 px-3 py-1 rounded-sm transition">
                                Admin Dashboard
                            </a>
                        </li>
                    @elseif(auth()->check() && auth()->user()->profile->role === 'manager')
                        <li>
                            <a href="{{ route('manager.reports.index') }}"
                               class="block text-gray-700 hover:text-indigo-600 px-3 py-1 rounded-sm transition">
                                Manager Dashboard
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="/orders"
                               class="block text-gray-700 hover:text-indigo-600 px-3 py-1 rounded-sm transition">
                                Orders
                            </a>
                        </li>
                    @endif
                    {{-- Cart --}}
                    <li>
                        <a href="/cart" class="relative flex items-center text-gray-700 hover:text-indigo-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9M9 21h6"/>
                            </svg>
                            @if(session('cart_count', 0) > 0)
                                <span class="absolute -top-1 -right-2 bg-red-600 text-white text-xs font-semibold rounded-full px-1.5 py-0.5">
                                    {{ session('cart_count') }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- User Dropdown --}}
                    <li class="relative group">
                        <button class="flex items-center text-gray-700 hover:text-indigo-600 px-3 py-1 rounded-sm focus:outline-none">
                            Hi, {{ auth()->user()->name }}
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        {{-- Dropdown Menu --}}
                        <ul class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 invisible group-hover:visible transition-all">
                            <li>
                                <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            </li>
                            <li>
                                <form method="POST" action="/auth/logout">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
