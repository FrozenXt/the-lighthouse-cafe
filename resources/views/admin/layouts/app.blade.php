<!-- resources/views/admin/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Dashboard</title>
    @vite(['resources/css/app.css'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-100">
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="bg-gradient-to-b from-slate-800 to-slate-900 text-white transition-all duration-300 flex flex-col hidden md:flex">
            <!-- Logo -->
            <div class="p-6 border-b border-slate-700">
                <div class="flex items-center" :class="!sidebarOpen && 'justify-center'">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                        <svg class="w-6 h-6 text-slate-900" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" />
                        </svg>
                    </div>
                    <div x-show="sidebarOpen" x-transition class="ml-3">
                        <h2 class="font-serif font-bold text-lg text-amber-400">Lighthouse</h2>
                        <p class="text-xs text-slate-400">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 mb-2 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-slate-900' : 'hover:bg-slate-700' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Dashboard</span>
                </a>

                <div x-show="sidebarOpen" x-transition class="px-4 py-3 mt-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wider">Management</p>
                </div>

                <!-- Orders -->
                <a href="{{ route('admin.orders') }}"
                    class="flex items-center px-4 py-3 mb-2 rounded-lg transition {{ request()->routeIs('admin.orders*') ? 'bg-amber-500 text-slate-900' : 'hover:bg-slate-700' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Orders</span>
                </a>

                <!-- Menu/Dishes -->
                <a href="{{ route('admin.dishes.index') }}"
                    class="flex items-center px-4 py-3 mb-2 rounded-lg transition {{ request()->routeIs('admin.dishes*') ? 'bg-amber-500 text-slate-900' : 'hover:bg-slate-700' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Menu Management</span>
                </a>

                <!-- Reservations -->
                <a href="{{ route('admin.reservations.index') }}"
                    class="flex items-center px-4 py-3 mb-2 rounded-lg transition {{ request()->routeIs('admin.reservations*') ? 'bg-amber-500 text-slate-900' : 'hover:bg-slate-700' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Reservations</span>
                </a>

                <!-- Members -->
                <a href="{{ route('admin.members.index') }}"
                    class="flex items-center px-4 py-3 mb-2 rounded-lg transition {{ request()->routeIs('admin.members*') ? 'bg-amber-500 text-slate-900' : 'hover:bg-slate-700' }}">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Members</span>
                </a>

                <div x-show="sidebarOpen" x-transition class="px-4 py-3 mt-6">
                    <p class="text-xs text-slate-500 uppercase tracking-wider">Quick Links</p>
                </div>

                <a href="{{ route('menu') }}" target="_blank"
                    class="flex items-center px-4 py-3 mb-2 rounded-lg hover:bg-slate-700 transition">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">View Website</span>
                </a>
            </nav>

            <!-- User Section & Toggle -->
            <div class="border-t border-slate-700">
                <div class="p-4">
                    <div class="flex items-center" :class="!sidebarOpen && 'justify-center'">
                        <div class="w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center flex-shrink-0">
                            <span
                                class="text-amber-400 font-bold text-lg">{{ substr(auth('admin')->user()->name, 0, 1) }}</span>
                        </div>
                        <div x-show="sidebarOpen" x-transition class="ml-3 flex-1">
                            <p class="text-sm font-semibold">{{ auth('admin')->user()->name }}</p>
                            <p class="text-xs text-slate-400">{{ ucfirst(auth('admin')->user()->role) }}</p>
                        </div>
                    </div>
                </div>
                <button @click="sidebarOpen = !sidebarOpen"
                    class="w-full p-4 hover:bg-slate-800 transition flex items-center justify-center border-t border-slate-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-md z-10">
                <div class="flex items-center justify-between p-4 md:p-6">
                    <div class="flex items-center gap-4">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-xl md:text-2xl font-serif font-bold text-slate-800">@yield('title')</h1>
                            <p class="text-sm text-slate-600 hidden md:block">{{ now()->format('l, F j, Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span
                            class="text-slate-700 font-medium hidden md:block">{{ auth('admin')->user()->name }}</span>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="hidden md:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" x-transition
                class="md:hidden bg-white border-b border-slate-200 p-4">
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}"
                        class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-white' : 'hover:bg-slate-100' }}">Dashboard</a>
                    <a href="{{ route('admin.orders') }}"
                        class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.orders*') ? 'bg-amber-500 text-white' : 'hover:bg-slate-100' }}">Orders</a>
                    <a href="{{ route('admin.dishes.index') }}"
                        class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.dishes*') ? 'bg-amber-500 text-white' : 'hover:bg-slate-100' }}">Menu
                        Management</a>
                    <a href="{{ route('admin.reservations.index') }}"
                        class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.reservations*') ? 'bg-amber-500 text-white' : 'hover:bg-slate-100' }}">Reservations</a>
                    <a href="{{ route('admin.members.index') }}"
                        class="block px-4 py-2 rounded-lg {{ request()->routeIs('admin.members*') ? 'bg-amber-500 text-white' : 'hover:bg-slate-100' }}">Members</a>
                    <a href="{{ route('menu') }}" target="_blank"
                        class="block px-4 py-2 rounded-lg hover:bg-slate-100">View Website</a>
                </nav>
            </div>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8">
                @if (session('success'))
                    <div
                        class="bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg mb-6 flex items-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
