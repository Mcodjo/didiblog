<nav role="navigation"
     class="sticky top-0 z-50 bg-white border-b border-gray-100 h-16">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between h-full">

        {{-- ── Logo ── --}}
        <a href="{{ route('home') }}" class="flex items-center">
            <span class="font-black text-xl tracking-tight text-[#FF6B00]"
                  style="font-family: 'Playfair Display', serif;">Emploi</span>
            <span class="font-black text-xl tracking-tight text-[#111111] ml-0.5"
                  style="font-family: 'Playfair Display', serif;">Connect</span>
        </a>

        {{-- ── Liens desktop ── --}}
        <div class="hidden lg:flex items-center gap-8">
            <a href="{{ route('home') }}"
               class="relative text-sm transition-all duration-300
                      {{ request()->routeIs('home')
                         ? 'font-semibold text-[#FF6B00] after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[2px] after:bg-[#FF6B00] after:content-[\'\']'
                         : 'text-gray-600 hover:text-[#FF6B00]' }}"
               style="font-family: 'DM Sans', sans-serif;">
                Accueil
            </a>
            <a href="{{ route('blog.index') }}"
               class="relative text-sm transition-all duration-300
                      {{ request()->routeIs('blog.*')
                         ? 'font-semibold text-[#FF6B00] after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[2px] after:bg-[#FF6B00] after:content-[\'\']'
                         : 'text-gray-600 hover:text-[#FF6B00]' }}"
               style="font-family: 'DM Sans', sans-serif;">
                Blog
            </a>
            <a href="{{ route('formations.index') }}"
               class="relative text-sm transition-all duration-300
                      {{ request()->routeIs('formations.*')
                         ? 'font-semibold text-[#FF6B00] after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[2px] after:bg-[#FF6B00] after:content-[\'\']'
                         : 'text-gray-600 hover:text-[#FF6B00]' }}"
               style="font-family: 'DM Sans', sans-serif;">
                Formations
            </a>
            <a href="{{ route('about') }}"
               class="relative text-sm transition-all duration-300
                      {{ request()->routeIs('about')
                         ? 'font-semibold text-[#FF6B00] after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[2px] after:bg-[#FF6B00] after:content-[\'\']'
                         : 'text-gray-600 hover:text-[#FF6B00]' }}"
               style="font-family: 'DM Sans', sans-serif;">
                À Propos
            </a>
            <a href="{{ route('contact') }}"
               class="relative text-sm transition-all duration-300
                      {{ request()->routeIs('contact')
                         ? 'font-semibold text-[#FF6B00] after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[2px] after:bg-[#FF6B00] after:content-[\'\']'
                         : 'text-gray-600 hover:text-[#FF6B00]' }}"
               style="font-family: 'DM Sans', sans-serif;">
                Contact
            </a>
        </div>

        {{-- ── Zone droite ── --}}
        <div class="flex items-center gap-3">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-gray-400 hover:text-[#FF6B00] transition-all duration-300"
                       aria-label="Administration">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            class="text-sm text-gray-500 hover:text-red-500 transition-all duration-300"
                            style="font-family: 'DM Sans', sans-serif;">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="text-sm text-gray-600 hover:text-[#FF6B00] transition-all duration-300"
                   style="font-family: 'DM Sans', sans-serif;">
                    Connexion
                </a>
            @endauth

            <a href="{{ route('guide-gratuit') }}"
               class="hidden sm:inline-flex items-center bg-[#FF6B00] text-white text-xs font-medium tracking-widest uppercase px-5 py-2.5 hover:bg-[#E55A00] transition-all duration-300"
               style="font-family: 'DM Sans', sans-serif;">
                Guide Gratuit
            </a>

            {{-- Hamburger mobile --}}
            <button id="nav-hamburger"
                    onclick="document.getElementById('mobile-nav').classList.toggle('hidden')"
                    class="lg:hidden p-2 text-gray-600 hover:text-[#FF6B00] transition-all duration-300"
                    aria-label="Menu">
                <svg id="icon-menu" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
                <svg id="icon-close" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- ── Menu mobile ── --}}
    <div id="mobile-nav"
         class="hidden lg:hidden absolute top-16 left-0 right-0 bg-white border-b border-gray-100 z-40">
        <div class="flex flex-col px-6 py-5 gap-4" style="font-family: 'DM Sans', sans-serif;">
            <a href="{{ route('home') }}"
               class="text-sm {{ request()->routeIs('home') ? 'font-semibold text-[#FF6B00]' : 'text-gray-600 hover:text-[#FF6B00]' }} transition-all duration-300">
                Accueil
            </a>
            <a href="{{ route('blog.index') }}"
               class="text-sm {{ request()->routeIs('blog.*') ? 'font-semibold text-[#FF6B00]' : 'text-gray-600 hover:text-[#FF6B00]' }} transition-all duration-300">
                Blog
            </a>
            <a href="{{ route('formations.index') }}"
               class="text-sm {{ request()->routeIs('formations.*') ? 'font-semibold text-[#FF6B00]' : 'text-gray-600 hover:text-[#FF6B00]' }} transition-all duration-300">
                Formations
            </a>
            <a href="{{ route('about') }}"
               class="text-sm {{ request()->routeIs('about') ? 'font-semibold text-[#FF6B00]' : 'text-gray-600 hover:text-[#FF6B00]' }} transition-all duration-300">
                À Propos
            </a>
            <a href="{{ route('contact') }}"
               class="text-sm {{ request()->routeIs('contact') ? 'font-semibold text-[#FF6B00]' : 'text-gray-600 hover:text-[#FF6B00]' }} transition-all duration-300">
                Contact
            </a>
            <hr class="border-gray-100 my-1">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-sm text-gray-600 hover:text-[#FF6B00] transition-all duration-300">
                        Administration
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-500 transition-all duration-300">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="text-sm text-gray-600 hover:text-[#FF6B00] transition-all duration-300">
                    Connexion
                </a>
            @endauth
            <a href="{{ route('guide-gratuit') }}"
               class="bg-[#FF6B00] text-white text-xs font-medium tracking-widest uppercase px-5 py-3 hover:bg-[#E55A00] transition-all duration-300 text-center">
                Guide Gratuit
            </a>
        </div>
    </div>
</nav>

<script>
    // Toggle icônes hamburger
    document.getElementById('nav-hamburger').addEventListener('click', function () {
        document.getElementById('icon-menu').classList.toggle('hidden');
        document.getElementById('icon-close').classList.toggle('hidden');
    });
</script>
