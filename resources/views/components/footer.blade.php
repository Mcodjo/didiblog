<footer class="bg-[#0A0A0A] text-white py-16">
    <div class="max-w-7xl mx-auto px-6">

        {{-- ── Grille 4 colonnes ── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-12">

            {{-- Col 1 — Branding --}}
            <div class="flex flex-col gap-4">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="font-black text-xl text-[#FF6B00]"
                          style="font-family: 'Playfair Display', serif;">Emploi</span>
                    <span class="font-black text-xl text-white ml-0.5"
                          style="font-family: 'Playfair Display', serif;">Connect</span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed max-w-xs"
                   style="font-family: 'DM Sans', sans-serif;">
                    Le blog de Coach Didi pour décrocher un emploi plus vite. Des méthodes concrètes, des résultats prouvés.
                </p>
                {{-- Réseaux sociaux --}}
                <div class="flex items-center gap-4 mt-2">
                    <a href="#" aria-label="LinkedIn"
                       class="text-gray-500 hover:text-[#FF6B00] transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="YouTube"
                       class="text-gray-500 hover:text-[#FF6B00] transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-2.75 12.38 12.38 0 0 0-8.64 0A4.83 4.83 0 0 1 3.41 6.69 49.14 49.14 0 0 0 3 12a49.14 49.14 0 0 0 .41 5.31 4.83 4.83 0 0 1 3.77 2.75 12.38 12.38 0 0 0 8.64 0 4.83 4.83 0 0 1 3.77-2.75A49.14 49.14 0 0 0 21 12a49.14 49.14 0 0 0-.41-5.31zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Instagram"
                       class="text-gray-500 hover:text-[#FF6B00] transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Col 2 — Navigation --}}
            <div class="flex flex-col gap-3">
                <h4 class="text-xs font-semibold tracking-widest uppercase text-gray-500 mb-2"
                    style="font-family: 'DM Sans', sans-serif;">
                    Navigation
                </h4>
                <a href="{{ route('home') }}"
                   class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 w-fit"
                   style="font-family: 'DM Sans', sans-serif;">
                    Accueil
                </a>
                <a href="{{ route('blog.index') }}"
                   class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 w-fit"
                   style="font-family: 'DM Sans', sans-serif;">
                    Blog
                </a>
                <a href="{{ route('formations.index') }}"
                   class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 w-fit"
                   style="font-family: 'DM Sans', sans-serif;">
                    Formations
                </a>
                <a href="{{ route('contact') }}"
                   class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 w-fit"
                   style="font-family: 'DM Sans', sans-serif;">
                    Contact
                </a>
            </div>

            {{-- Col 3 — Ressources --}}
            <div class="flex flex-col gap-3">
                <h4 class="text-xs font-semibold tracking-widest uppercase text-gray-500 mb-2"
                    style="font-family: 'DM Sans', sans-serif;">
                    Ressources
                </h4>
                <a href="{{ route('guide-gratuit') }}"
                   class="text-sm text-gray-400 hover:text-[#FF6B00] hover:translate-x-1 transition-all duration-300 w-fit"
                   style="font-family: 'DM Sans', sans-serif;">
                    Guide Gratuit
                </a>
                <a href="{{ route('about') }}"
                   class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 w-fit"
                   style="font-family: 'DM Sans', sans-serif;">
                    À Propos
                </a>
                <a href="{{ route('blog.index') }}"
                   class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 w-fit"
                   style="font-family: 'DM Sans', sans-serif;">
                    Articles
                </a>
                <a href="#"
                   class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 w-fit"
                   style="font-family: 'DM Sans', sans-serif;">
                    Mentions légales
                </a>
                <a href="#"
                   class="text-sm text-gray-400 hover:text-white hover:translate-x-1 transition-all duration-300 w-fit"
                   style="font-family: 'DM Sans', sans-serif;">
                    Politique de confidentialité
                </a>
            </div>

            {{-- Col 4 — Newsletter --}}
            <div class="flex flex-col gap-4">
                <h4 class="text-xs font-semibold tracking-widest uppercase text-gray-500 mb-2"
                    style="font-family: 'DM Sans', sans-serif;">
                    Newsletter
                </h4>
                <p class="text-sm text-gray-400 leading-relaxed"
                   style="font-family: 'DM Sans', sans-serif;">
                    Reçois chaque semaine les meilleurs conseils emploi directement dans ta boîte mail.
                </p>
                <form action="{{ route('newsletter.store') }}" method="POST" class="flex flex-col gap-2">
                    @csrf
                    <input type="email"
                           name="email"
                           required
                           placeholder="ton@email.com"
                           class="bg-[#1A1A1A] border border-gray-800 text-white text-sm px-4 py-3 placeholder-gray-600 focus:outline-none focus:border-[#FF6B00] transition-all duration-300 w-full"
                           style="font-family: 'DM Sans', sans-serif;">
                    <button type="submit"
                            class="bg-[#FF6B00] text-white text-xs font-medium tracking-widest uppercase px-6 py-3 hover:bg-[#E55A00] transition-all duration-300 w-full"
                            style="font-family: 'DM Sans', sans-serif;">
                        S'abonner
                    </button>
                </form>
                @if(session('newsletter_success'))
                    <p class="text-xs text-green-400" style="font-family: 'DM Sans', sans-serif;">
                        ✓ Inscription confirmée !
                    </p>
                @endif
            </div>
        </div>

        {{-- ── Bandeau bas ── --}}
        <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p class="text-xs text-gray-600" style="font-family: 'DM Sans', sans-serif;">
                &copy; {{ date('Y') }} Emploi Connect — Coach Didi. Tous droits réservés.
            </p>
            <p class="text-xs text-gray-700" style="font-family: 'DM Sans', sans-serif;">
                Fait avec <span class="text-[#FF6B00]">♥</span> pour les chercheurs d'emploi africains
            </p>
        </div>

    </div>
</footer>
