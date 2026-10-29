<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Product Admin Dashboard') - {{ config('app.name', 'Ace360degree Enterprise Suite') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="h-full antialiased text-slate-800 bg-[#f8fafc]">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" 
         onclick="toggleMobileSidebar()" 
         class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-30 hidden lg:hidden transition-opacity"></div>

    <!-- Left Sidebar -->
    <aside id="mainSidebar" 
           class="w-64 bg-white border-r border-slate-200 flex flex-col fixed inset-y-0 z-40 transition-transform duration-200 -translate-x-full lg:translate-x-0 shadow-xs">
        
        <!-- Brand Header -->
        <div class="h-16 px-6 border-b border-slate-100 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-extrabold text-base tracking-tight shadow-sm shadow-blue-500/20">
                    A3
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-bold text-slate-900 leading-tight">Ace360degree</span>
                    <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest leading-none mt-0.5">Enterprise Suite</span>
                </div>
            </a>
            <!-- Mobile Close Button -->
            <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-1.5 text-slate-400 hover:text-slate-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'font-semibold text-blue-600 bg-blue-50/70 border border-blue-100/50 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Product Management -->
            <a href="{{ route('products.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('products.*') ? 'font-semibold text-blue-600 bg-blue-50/70 border border-blue-100/50 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('products.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span>Product Management</span>
            </a>

            <!-- Store Management -->
            <a href="{{ route('stores.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('stores.*') ? 'font-semibold text-blue-600 bg-blue-50/70 border border-blue-100/50 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('stores.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span>Store Management</span>
            </a>

            <!-- Orders -->
            <a href="{{ route('orders.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('orders.*') ? 'font-semibold text-blue-600 bg-blue-50/70 border border-blue-100/50 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('orders.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>Orders</span>
            </a>

            <!-- Vendor Management -->
            <a href="{{ route('vendors.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('vendors.*') ? 'font-semibold text-blue-600 bg-blue-50/70 border border-blue-100/50 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('vendors.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Vendor Management</span>
            </a>

            <!-- Promotions -->
            <a href="{{ route('promotions.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('promotions.*') ? 'font-semibold text-blue-600 bg-blue-50/70 border border-blue-100/50 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('promotions.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span>Promotions</span>
            </a>

            <!-- Marketing Management -->
            <a href="{{ route('marketing.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('marketing.*') ? 'font-semibold text-blue-600 bg-blue-50/70 border border-blue-100/50 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('marketing.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                </svg>
                <span>Marketing Management</span>
            </a>

            <!-- POS (Point of Sale) -->
            <a href="{{ route('pos.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('pos.*') ? 'font-semibold text-blue-600 bg-blue-50/70 border border-blue-100/50 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('pos.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <div class="flex items-center justify-between flex-1">
                    <span>POS Terminal</span>
                    <span class="px-1.5 py-0.5 text-[10px] font-bold rounded bg-emerald-100 text-emerald-700">Live</span>
                </div>
            </a>

            <!-- User Profile Link -->
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('profile.*') ? 'font-semibold text-blue-600 bg-blue-50/70 border border-blue-100/50 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('profile.*') ? 'text-blue-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>My Profile</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-100 space-y-3">
            @auth
                <!-- Authenticated User Card in Sidebar -->
                <div class="flex items-center justify-between px-2 py-1 bg-slate-50 rounded-xl border border-slate-100">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 overflow-hidden">
                        <div class="w-7 h-7 rounded-lg bg-blue-600 text-white font-bold text-xs flex items-center justify-center shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="flex flex-col text-left truncate">
                            <span class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email }}</span>
                        </div>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Log Out">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            @else
                <div class="px-2 py-1 flex items-center justify-between text-xs font-bold">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700">Sign In</a>
                    <a href="{{ route('register') }}" class="text-slate-600 hover:text-slate-800">Register</a>
                </div>
            @endauth

            <div class="flex items-center gap-2.5 px-2 py-0.5">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="text-[11px] text-emerald-600 font-medium">MySQL Active</span>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper (Sidebar offset on large screens) -->
    <div class="lg:pl-64 flex-1 flex flex-col min-h-screen">

        <!-- Top Header Bar -->
        <header class="h-16 bg-white border-b border-slate-200 sticky top-0 z-20 px-4 sm:px-8 flex items-center justify-between">
            <!-- Left: Mobile Toggle & Breadcrumbs -->
            <div class="flex items-center gap-3">
                <button type="button" 
                        onclick="toggleMobileSidebar()" 
                        class="lg:hidden p-2 -ml-2 text-slate-600 hover:text-slate-900 rounded-lg hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex items-center gap-2 text-sm">
                    @yield('breadcrumbs')
                </div>
            </div>

            <!-- Right: Toast Flash Notification (if present) & User Profile -->
            <div class="flex items-center gap-3 sm:gap-4">
                @if (session('success'))
                    <div id="flashToast" class="flex items-center gap-2.5 px-3.5 py-1.5 bg-emerald-50 border border-emerald-200 rounded-xl shadow-xs text-xs">
                        <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="font-semibold text-emerald-800">{{ session('success') }}</span>
                        <button type="button" onclick="document.getElementById('flashToast').remove()" class="text-emerald-500 hover:text-emerald-700 ml-1">
                            &times;
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div id="flashErrorToast" class="flex items-center gap-2.5 px-3.5 py-1.5 bg-rose-50 border border-rose-200 rounded-xl shadow-xs text-xs">
                        <div class="w-5 h-5 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <span class="font-semibold text-rose-800">{{ session('error') }}</span>
                        <button type="button" onclick="document.getElementById('flashErrorToast').remove()" class="text-rose-500 hover:text-rose-700 ml-1">
                            &times;
                        </button>
                    </div>
                @endif

                <!-- POS Quick Button in Header -->
                <a href="{{ route('pos.index') }}" 
                   class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-lg shadow-xs transition-colors">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span>Launch POS</span>
                </a>

                @auth
                    <!-- Authenticated User Avatar -->
                    <div class="flex items-center gap-2.5 pl-2 sm:border-l sm:border-slate-200">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 group">
                            <div class="w-9 h-9 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center ring-2 ring-white shadow-xs group-hover:bg-blue-700 transition-colors">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="hidden md:flex flex-col text-left">
                                <span class="text-xs font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-slate-400 font-medium">Administrator</span>
                            </div>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Log Out">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-2 pl-2 sm:border-l sm:border-slate-200 text-xs">
                        <a href="{{ route('login') }}" class="px-3 py-1.5 font-bold text-blue-600 hover:text-blue-700">Sign In</a>
                        <a href="{{ route('register') }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-xs">Register</a>
                    </div>
                @endauth
            </div>
        </header>

        <!-- Main Content View -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 space-y-6">
            @yield('content')
        </main>
    </div>

    <!-- Mobile Drawer Javascript -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mainSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
