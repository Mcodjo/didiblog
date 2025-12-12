<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Admin Emploi Connect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .sidebar-link {
            transition: all 0.2s ease-in-out;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            transform: translateX(4px);
        }

        .admin-sidebar {
            background-color: #0f172a !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="h-full bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/80 z-40 lg:hidden">
    </div>

    <!-- Sidebar (Fixed Position) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="admin-sidebar fixed inset-y-0 left-0 z-50 w-72 text-white transition-transform duration-300 ease-in-out 
                  lg:translate-x-0 shadow-xl border-r border-slate-800 flex flex-col h-full overflow-y-auto">

        <!-- Logo Section -->
        <div class="h-20 flex items-center px-8 border-b border-slate-800 flex-shrink-0 sticky top-0 bg-[#0f172a] z-10">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-orange-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                    <i class="fas fa-bolt text-white text-lg"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-bold tracking-tight text-white">Emploi<span
                            class="text-orange-400">Connect</span></span>
                    <span class="text-xs text-slate-400 uppercase tracking-wider font-medium">Administration</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden ml-auto text-slate-400 hover:text-white p-2">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-2">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Menu Principal</p>

            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link flex items-center px-4 py-3.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i
                    class="fas fa-th-large w-6 flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.articles.index') }}"
                class="sidebar-link flex items-center px-4 py-3.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.articles.*') ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i
                    class="fas fa-newspaper w-6 flex-shrink-0 {{ request()->routeIs('admin.articles.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Articles
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="sidebar-link flex items-center px-4 py-3.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i
                    class="fas fa-folder-tree w-6 flex-shrink-0 {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Catégories
            </a>
            <a href="{{ route('admin.formations.index') }}"
                class="sidebar-link flex items-center px-4 py-3.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.formations.*') ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i
                    class="fas fa-graduation-cap w-6 flex-shrink-0 {{ request()->routeIs('admin.formations.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Formations
            </a>

            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mt-8 mb-2">Gestion</p>

            <a href="{{ route('admin.comments.index') }}"
                class="sidebar-link flex items-center px-4 py-3.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.comments.*') ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i
                    class="fas fa-comments w-6 flex-shrink-0 {{ request()->routeIs('admin.comments.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Commentaires
            </a>
            <a href="{{ route('admin.newsletters.index') }}"
                class="sidebar-link flex items-center px-4 py-3.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.newsletters.*') ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i
                    class="fas fa-envelope-open-text w-6 flex-shrink-0 {{ request()->routeIs('admin.newsletters.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Newsletters
            </a>
            <a href="{{ route('admin.contacts.index') }}"
                class="sidebar-link flex items-center px-4 py-3.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.contacts.*') ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <i
                    class="fas fa-inbox w-6 flex-shrink-0 {{ request()->routeIs('admin.contacts.*') ? 'text-white' : 'text-slate-400' }}"></i>
                Messages
            </a>
        </nav>

        <!-- User Profile -->
        <div class="p-4 border-t border-slate-800 sticky bottom-0 bg-[#0f172a] z-10">
            <div class="flex items-center gap-3 px-4 py-3 mb-2 rounded-xl bg-slate-800/50">
                <div
                    class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-sm font-bold shadow-md text-white">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ Auth::user()->email ?? 'admin@example.com' }}</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('home') }}"
                    class="flex-1 flex items-center justify-center px-3 py-2 text-xs font-medium text-slate-300 bg-slate-800 hover:bg-slate-700 rounded-lg transition-colors border border-slate-700"
                    target="_blank">
                    <i class="fas fa-external-link-alt mr-2"></i> Site
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center justify-center px-3 py-2 text-xs font-medium text-red-200 bg-red-900/20 hover:bg-red-900/40 rounded-lg transition-colors border border-red-900/30">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="min-h-screen lg:ml-72 flex flex-col transition-all duration-300">
        <!-- Header Sticky -->
        <header
            class="bg-white/90 backdrop-blur sticky top-0 z-30 border-b border-gray-200 px-6 py-4 flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true"
                    class="lg:hidden p-2 -ml-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="flex flex-col">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900 tracking-tight leading-tight">@yield('title')
                    </h1>
                    <p class="hidden md:block text-sm text-gray-500 font-medium">
                        @yield('subtitle', 'Gestion de votre plateforme')</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @yield('actions')
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6 md:p-8">
            @if(session('success'))
                <div
                    class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 text-green-700 flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-check-circle text-xl"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div
                    class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-700 flex items-center gap-3 animate-fade-in-down shadow-sm">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
</body>

</html>