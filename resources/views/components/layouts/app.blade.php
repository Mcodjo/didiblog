<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'Emploi Connect - Le blog pour décrocher un emploi plus vite par Coach Didi' }}">
    <title>{{ $title ?? 'Emploi Connect' }} - Coach Didi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        .gradient-hero { background: linear-gradient(135deg, rgba(249, 115, 22, 0.9), rgba(37, 99, 235, 0.9)); }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">
    <nav class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-2xl font-bold text-orange-600">Emploi</span>
                    <span class="text-2xl font-bold text-blue-600">Connect</span>
                </a>
                
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 transition-colors {{ request()->routeIs('home') ? 'text-orange-600 font-semibold' : '' }}">Accueil</a>
                    <a href="{{ route('blog.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 transition-colors {{ request()->routeIs('blog.*') ? 'text-orange-600 font-semibold' : '' }}">Blog</a>
                    <a href="{{ route('formations.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 transition-colors {{ request()->routeIs('formations.*') ? 'text-orange-600 font-semibold' : '' }}">Formations</a>
                    <a href="{{ route('about') }}" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 transition-colors {{ request()->routeIs('about') ? 'text-orange-600 font-semibold' : '' }}">À Propos</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 transition-colors {{ request()->routeIs('contact') ? 'text-orange-600 font-semibold' : '' }}">Contact</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-orange-600"><i class="fas fa-cog"></i></a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">@csrf
                            <button type="submit" class="text-gray-700 dark:text-gray-300 hover:text-orange-600"><i class="fas fa-sign-out-alt"></i></button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-orange-600">Connexion</a>
                    @endauth
                    <a href="{{ route('guide-gratuit') }}" class="hidden sm:inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                        <i class="fas fa-download mr-2"></i>Guide Gratuit
                    </a>
                </div>
                
                <button id="mobile-menu-btn" class="md:hidden text-gray-700 dark:text-gray-300"><i class="fas fa-bars text-xl"></i></button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-800 border-t">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block text-gray-700 dark:text-gray-300 hover:text-orange-600">Accueil</a>
                <a href="{{ route('blog.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-orange-600">Blog</a>
                <a href="{{ route('formations.index') }}" class="block text-gray-700 dark:text-gray-300 hover:text-orange-600">Formations</a>
                <a href="{{ route('about') }}" class="block text-gray-700 dark:text-gray-300 hover:text-orange-600">À Propos</a>
                <a href="{{ route('contact') }}" class="block text-gray-700 dark:text-gray-300 hover:text-orange-600">Contact</a>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3" role="alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3" role="alert">{{ session('error') }}</div>
    @endif

    <main>{{ $slot }}</main>

    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4"><span class="text-orange-500">Emploi</span><span class="text-blue-400">Connect</span></h3>
                    <p class="text-gray-400">Le blog pour décrocher un emploi plus vite avec Coach Didi.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Navigation</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-orange-500">Accueil</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-orange-500">Blog</a></li>
                        <li><a href="{{ route('formations.index') }}" class="hover:text-orange-500">Formations</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-orange-500">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Ressources</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('guide-gratuit') }}" class="hover:text-orange-500">Guide Gratuit</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-orange-500">À Propos</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Newsletter</h4>
                    <form action="{{ route('newsletter.store') }}" method="POST" class="flex flex-col gap-2">@csrf
                        <input type="email" name="email" placeholder="Ton email" required class="px-4 py-2 rounded-lg bg-gray-800 text-white border border-gray-700 focus:border-orange-500 focus:outline-none">
                        <button type="submit" class="px-4 py-2 bg-orange-600 hover:bg-orange-700 rounded-lg font-semibold transition-colors">S'abonner</button>
                    </form>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Emploi Connect - Coach Didi. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>document.getElementById('mobile-menu-btn').addEventListener('click', function() { document.getElementById('mobile-menu').classList.toggle('hidden'); });</script>
</body>
</html>
