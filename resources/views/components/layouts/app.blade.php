<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'Emploi Connect — Le blog pour décrocher un emploi plus vite par Coach Didi' }}">
    <title>{{ $title ?? 'Emploi Connect' }} — Coach Didi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        .nav-scrolled { background: rgba(10,10,10,.92) !important; backdrop-filter: blur(20px) saturate(1.4); -webkit-backdrop-filter: blur(20px) saturate(1.4); box-shadow: 0 1px 0 rgba(255,255,255,.06); }
        .nav-link-active { color: #FF6B00 !important; }
        #mobile-menu { max-height: 0; overflow: hidden; transition: max-height .35s cubic-bezier(.4,0,.2,1); }
        #mobile-menu.open { max-height: 400px; }
    </style>
</head>
<body class="bg-white text-[#111111] min-h-screen antialiased" x-data="{ mobileMenuOpen: false }">

    {{-- ════════ NAVBAR ════════ --}}
    <nav id="main-nav" class="fixed top-0 inset-x-0 z-50 bg-[#0A0A0A] border-b border-[#222] transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-3 items-center h-20">

                {{-- Left: Logo --}}
                <div class="flex items-center justify-start">
                    <a href="{{ route('home') }}" class="flex items-center gap-1 group">
                        <span class="font-['Playfair_Display'] text-2xl font-bold text-white tracking-tight group-hover:opacity-80 transition-opacity">Emploi</span>
                        <span class="font-['Playfair_Display'] text-2xl font-bold text-[#FF6B00] tracking-tight group-hover:opacity-80 transition-opacity">Connect</span>
                    </a>
                </div>

                {{-- Center: Desktop links --}}
                <div class="hidden lg:flex items-center justify-center gap-8">
                    <a href="{{ route('home') }}" class="relative font-['DM_Sans'] text-sm font-bold tracking-widest uppercase transition-colors duration-200 flex flex-col items-center {{ request()->routeIs('home') ? 'text-[#FF6B00]' : 'text-gray-300 hover:text-white' }}">
                        Accueil
                        @if(request()->routeIs('home')) 
                            <div class="w-1.5 h-1.5 rounded-full bg-[#FF6B00] mt-1"></div> 
                        @else 
                            <div class="w-1.5 h-1.5 mt-1 opacity-0"></div>
                        @endif
                    </a>
                    <a href="{{ route('blog.index') }}" class="relative font-['DM_Sans'] text-sm font-bold tracking-widest uppercase transition-colors duration-200 flex flex-col items-center {{ request()->routeIs('blog.*') ? 'text-[#FF6B00]' : 'text-gray-300 hover:text-white' }}">
                        Blog
                        @if(request()->routeIs('blog.*')) 
                            <div class="w-1.5 h-1.5 rounded-full bg-[#FF6B00] mt-1"></div> 
                        @else 
                            <div class="w-1.5 h-1.5 mt-1 opacity-0"></div>
                        @endif
                    </a>
                    <a href="{{ route('formations.index') }}" class="relative font-['DM_Sans'] text-sm font-bold tracking-widest uppercase transition-colors duration-200 flex flex-col items-center {{ request()->routeIs('formations.*') ? 'text-[#FF6B00]' : 'text-gray-300 hover:text-white' }}">
                        Formations
                        @if(request()->routeIs('formations.*')) 
                            <div class="w-1.5 h-1.5 rounded-full bg-[#FF6B00] mt-1"></div> 
                        @else 
                            <div class="w-1.5 h-1.5 mt-1 opacity-0"></div>
                        @endif
                    </a>
                    <a href="{{ route('about') }}" class="relative font-['DM_Sans'] text-sm font-bold tracking-widest uppercase transition-colors duration-200 flex flex-col items-center {{ request()->routeIs('about') ? 'text-[#FF6B00]' : 'text-gray-300 hover:text-white' }}">
                        À Propos
                        @if(request()->routeIs('about')) 
                            <div class="w-1.5 h-1.5 rounded-full bg-[#FF6B00] mt-1"></div> 
                        @else 
                            <div class="w-1.5 h-1.5 mt-1 opacity-0"></div>
                        @endif
                    </a>
                    <a href="{{ route('contact') }}" class="relative font-['DM_Sans'] text-sm font-bold tracking-widest uppercase transition-colors duration-200 flex flex-col items-center {{ request()->routeIs('contact') ? 'text-[#FF6B00]' : 'text-gray-300 hover:text-white' }}">
                        Contact
                        @if(request()->routeIs('contact')) 
                            <div class="w-1.5 h-1.5 rounded-full bg-[#FF6B00] mt-1"></div> 
                        @else 
                            <div class="w-1.5 h-1.5 mt-1 opacity-0"></div>
                        @endif
                    </a>
                </div>

                {{-- Right: Actions --}}
                <div class="flex items-center justify-end gap-6">
                    <div class="hidden lg:flex items-center gap-6">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-[#FF6B00] transition-colors" title="Administration"><i class="fas fa-cog"></i></a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" class="inline m-0">@csrf
                                <button type="submit" class="text-gray-400 hover:text-[#FF6B00] transition-colors" title="Déconnexion"><i class="fas fa-sign-out-alt"></i></button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="font-['DM_Sans'] text-sm font-medium text-gray-400 hover:text-white transition-colors">Connexion</a>
                        @endauth
                    </div>

                    <a href="{{ route('guide-gratuit') }}" class="hidden sm:inline-flex items-center gap-2 bg-[#FF6B00] hover:bg-[#e55a00] text-white font-['DM_Sans'] text-xs font-bold tracking-widest uppercase px-6 py-3 rounded-full transition-all duration-300 shadow-[0_4px_14px_rgba(255,107,0,0.3)] hover:shadow-[0_6px_20px_rgba(255,107,0,0.4)] hover:-translate-y-0.5">
                        <i class="fas fa-download"></i>Guide Gratuit
                    </a>

                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-300 hover:text-white transition-colors p-2 -mr-2" aria-label="Menu">
                        <i class="fas text-xl" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" @click.away="mobileMenuOpen = false" class="lg:hidden absolute top-full left-0 w-full border-t border-[#222] bg-[#0A0A0A] shadow-2xl" style="display: none;">
            <div class="px-6 py-6 flex flex-col gap-5">
                <a href="{{ route('home') }}" class="font-['DM_Sans'] text-sm tracking-widest uppercase transition-colors {{ request()->routeIs('home') ? 'text-[#FF6B00] font-bold' : 'text-gray-300 hover:text-white font-medium' }}">Accueil</a>
                <a href="{{ route('blog.index') }}" class="font-['DM_Sans'] text-sm tracking-widest uppercase transition-colors {{ request()->routeIs('blog.*') ? 'text-[#FF6B00] font-bold' : 'text-gray-300 hover:text-white font-medium' }}">Blog</a>
                <a href="{{ route('formations.index') }}" class="font-['DM_Sans'] text-sm tracking-widest uppercase transition-colors {{ request()->routeIs('formations.*') ? 'text-[#FF6B00] font-bold' : 'text-gray-300 hover:text-white font-medium' }}">Formations</a>
                <a href="{{ route('about') }}" class="font-['DM_Sans'] text-sm tracking-widest uppercase transition-colors {{ request()->routeIs('about') ? 'text-[#FF6B00] font-bold' : 'text-gray-300 hover:text-white font-medium' }}">À Propos</a>
                <a href="{{ route('contact') }}" class="font-['DM_Sans'] text-sm tracking-widest uppercase transition-colors {{ request()->routeIs('contact') ? 'text-[#FF6B00] font-bold' : 'text-gray-300 hover:text-white font-medium' }}">Contact</a>
                <div class="pt-5 border-t border-[#222] flex flex-col gap-4">
                    <a href="{{ route('guide-gratuit') }}" class="inline-flex items-center justify-center gap-2 bg-[#FF6B00] text-white font-['DM_Sans'] text-xs font-bold tracking-widest uppercase px-6 py-3.5 rounded-full shadow-[0_4px_14px_rgba(255,107,0,0.3)]">
                        <i class="fas fa-download"></i>Guide Gratuit
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed top-20 right-6 z-[60] max-w-sm bg-[#0A0A0A] border border-green-500/30 text-white font-['DM_Sans'] text-sm px-5 py-4 rounded-xl shadow-2xl flex items-center gap-3">
            <span class="w-2 h-2 bg-green-400 rounded-full flex-shrink-0"></span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed top-20 right-6 z-[60] max-w-sm bg-[#0A0A0A] border border-red-500/30 text-white font-['DM_Sans'] text-sm px-5 py-4 rounded-xl shadow-2xl flex items-center gap-3">
            <span class="w-2 h-2 bg-red-400 rounded-full flex-shrink-0"></span>
            {{ session('error') }}
        </div>
    @endif

    <main>{{ $slot }}</main>

    {{-- ════════ FOOTER ════════ --}}
    <footer class="bg-[#0A0A0A] border-t border-[#1A1A1A]">
        {{-- Main footer --}}
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16 lg:py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8">

                {{-- Brand --}}
                <div class="lg:col-span-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1 mb-6">
                        <span class="font-['Playfair_Display'] text-2xl font-bold text-white">Emploi</span>
                        <span class="font-['Playfair_Display'] text-2xl font-bold text-[#FF6B00]">Connect</span>
                    </a>
                    <p class="font-['DM_Sans'] text-sm text-gray-500 leading-relaxed max-w-xs mb-6">
                        Des méthodes concrètes pour décrocher l'emploi que tu mérites. Par Coach Didi.
                    </p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="w-9 h-9 rounded-full border border-[#2A2A2A] flex items-center justify-center text-gray-500 hover:border-[#FF6B00] hover:text-[#FF6B00] transition-all duration-300">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full border border-[#2A2A2A] flex items-center justify-center text-gray-500 hover:border-[#FF6B00] hover:text-[#FF6B00] transition-all duration-300">
                            <i class="fab fa-youtube text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 rounded-full border border-[#2A2A2A] flex items-center justify-center text-gray-500 hover:border-[#FF6B00] hover:text-[#FF6B00] transition-all duration-300">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                    </div>
                </div>

                {{-- Navigation --}}
                <div class="lg:col-span-2">
                    <h4 class="font-['DM_Sans'] text-[11px] font-semibold tracking-[0.2em] uppercase text-gray-500 mb-5">Navigation</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="{{ route('home') }}" class="font-['DM_Sans'] text-sm text-gray-400 hover:text-[#FF6B00] transition-colors">Accueil</a></li>
                        <li><a href="{{ route('blog.index') }}" class="font-['DM_Sans'] text-sm text-gray-400 hover:text-[#FF6B00] transition-colors">Blog</a></li>
                        <li><a href="{{ route('formations.index') }}" class="font-['DM_Sans'] text-sm text-gray-400 hover:text-[#FF6B00] transition-colors">Formations</a></li>
                        <li><a href="{{ route('about') }}" class="font-['DM_Sans'] text-sm text-gray-400 hover:text-[#FF6B00] transition-colors">À Propos</a></li>
                        <li><a href="{{ route('contact') }}" class="font-['DM_Sans'] text-sm text-gray-400 hover:text-[#FF6B00] transition-colors">Contact</a></li>
                    </ul>
                </div>

                {{-- Ressources --}}
                <div class="lg:col-span-2">
                    <h4 class="font-['DM_Sans'] text-[11px] font-semibold tracking-[0.2em] uppercase text-gray-500 mb-5">Ressources</h4>
                    <ul class="flex flex-col gap-3">
                        <li><a href="{{ route('guide-gratuit') }}" class="font-['DM_Sans'] text-sm text-gray-400 hover:text-[#FF6B00] transition-colors">Guide Gratuit</a></li>
                        <li><a href="{{ route('formations.index') }}" class="font-['DM_Sans'] text-sm text-gray-400 hover:text-[#FF6B00] transition-colors">Toutes les formations</a></li>
                        <li><a href="{{ route('blog.index') }}" class="font-['DM_Sans'] text-sm text-gray-400 hover:text-[#FF6B00] transition-colors">Tous les articles</a></li>
                    </ul>
                </div>

                {{-- Newsletter --}}
                <div class="lg:col-span-4">
                    <h4 class="font-['DM_Sans'] text-[11px] font-semibold tracking-[0.2em] uppercase text-gray-500 mb-5">Newsletter</h4>
                    <p class="font-['DM_Sans'] text-sm text-gray-500 mb-4">Reçois chaque semaine des conseils concrets pour ta recherche d'emploi.</p>
                    <form action="{{ route('newsletter.store') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="email" name="email" placeholder="ton@email.com" required
                               class="flex-1 px-4 py-2.5 bg-[#111] border border-[#2A2A2A] rounded-full font-['DM_Sans'] text-sm text-white placeholder-gray-600 focus:outline-none focus:border-[#FF6B00] transition-colors">
                        <button type="submit"
                                class="bg-[#FF6B00] hover:bg-[#e55a00] text-white font-['DM_Sans'] text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-full transition-all duration-300 hover:shadow-lg hover:shadow-[#FF6B00]/20 whitespace-nowrap">
                            S'abonner
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-[#1A1A1A]">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="font-['DM_Sans'] text-xs text-gray-600">
                    &copy; {{ date('Y') }} Emploi Connect — Coach Didi. Tous droits réservés.
                </p>
                <p class="font-['DM_Sans'] text-xs text-gray-600">
                    Fait avec <span class="text-[#FF6B00]">♥</span> pour les chercheurs d'emploi
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        const nav = document.getElementById('main-nav');
        window.addEventListener('scroll', function() {
            nav.classList.toggle('nav-scrolled', window.scrollY > 40);
        });
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>

