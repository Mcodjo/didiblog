<x-layouts.app title="Formations — Emploi Connect">
    {{-- MENU DE NAVIGATION INTÉGRÉ AU THÈME --}}
    
    {{-- HEADER FAÇON MASTERCLASS / PLATEFORME E-LEARNING --}}
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-[#0A0A0A] overflow-hidden">
        {{-- Background effect --}}
        <div class="absolute inset-0">
            <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-[#FF6B00] filter blur-[150px] opacity-10 rounded-full translate-x-1/3 -translate-y-1/3 mix-blend-screen pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-yellow-600 filter blur-[150px] opacity-5 rounded-full -translate-x-1/2 translate-y-1/2 mix-blend-screen pointer-events-none"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20 pointer-events-none"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-3/5 text-left">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-[#FF6B00]/10 border border-[#FF6B00]/20 text-[#FF6B00] text-[10px] font-bold uppercase tracking-widest mb-6 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-[#FF6B00] animate-pulse"></span>
                    Catalogue Premium
                </span>
                <h1 class="text-4xl lg:text-7xl font-bold text-white leading-tight mb-6 tracking-tight">
                    Accélère ta carrière <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF6B00] to-yellow-500">à ton propre rythme.</span>
                </h1>
                <p class="text-lg text-gray-400 mb-10 max-w-xl font-light">
                    Rejoins des milliers de professionnels qui ont transformé leur parcours avec des stratégies prouvées. Apprends avec Coach Didi, où tu veux, quand tu veux.
                </p>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="#catalogue" class="bg-[#FF6B00] text-white px-8 py-4 rounded-xl font-bold text-sm tracking-widest uppercase hover:bg-[#e55a00] hover:shadow-[0_0_20px_rgba(255,107,0,0.4)] hover:-translate-y-1 transition-all duration-300">
                        Explorer le catalogue
                    </a>
                    <div class="flex items-center gap-3 text-sm text-gray-400 px-4">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gray-600 border-2 border-[#0A0A0A]"></div>
                            <div class="w-8 h-8 rounded-full bg-gray-500 border-2 border-[#0A0A0A]"></div>
                            <div class="w-8 h-8 rounded-full bg-[#FF6B00] border-2 border-[#0A0A0A] flex items-center justify-center text-[10px] text-white font-bold">+2k</div>
                        </div>
                        Étudiants actifs
                    </div>
                </div>
            </div>
            
            {{-- Statistiques style E-learning --}}
            <div class="lg:w-2/5 w-full grid grid-cols-2 gap-4">
                <div class="bg-[#111111]/80 backdrop-blur-xl border border-[#222] p-6 rounded-2xl flex flex-col justify-center transform lg:translate-x-4 lg:-translate-y-8 hover:border-[#FF6B00]/40 transition-colors">
                    <i class="fas fa-video text-2xl text-[#FF6B00] mb-4"></i>
                    <h4 class="text-3xl font-bold text-white mb-1">100%</h4>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">En ligne & Flexible</p>
                </div>
                <div class="bg-[#111111]/80 backdrop-blur-xl border border-[#222] p-6 rounded-2xl flex flex-col justify-center hover:border-[#FF6B00]/40 transition-colors">
                    <i class="fas fa-infinity text-2xl text-[#FF6B00] mb-4"></i>
                    <h4 class="text-3xl font-bold text-white mb-1">À vie</h4>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">Accès illimité</p>
                </div>
                <div class="col-span-2 bg-gradient-to-r from-[#111111] to-[#1A1A1A] border border-[#222] p-6 rounded-2xl flex items-center justify-between group hover:border-[#FF6B00]/40 transition-colors cursor-default">
                    <div>
                        <div class="flex items-center gap-1 text-[#FF6B00] mb-2">
                            <i class="fas fa-star text-sm"></i><i class="fas fa-star text-sm"></i><i class="fas fa-star text-sm"></i><i class="fas fa-star text-sm"></i><i class="fas fa-star text-sm"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white mb-1">4.9/5 Moyenne</h4>
                        <p class="text-xs text-gray-500">Basé sur les avis certifiés</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-[#222] flex items-center justify-center text-white group-hover:bg-[#FF6B00] transition-colors">
                        <i class="fas fa-medal"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BARRE DE FILTRES E-LEARNING (STICKY) --}}
    <div id="catalogue" class="sticky top-[72px] z-40 bg-[#0A0A0A]/95 backdrop-blur-xl border-b border-[#222] py-4">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 scrollbar-hide">
                <button class="bg-[#FF6B00] text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest whitespace-nowrap">Toutes les formations</button>
                <button class="bg-[#111] border border-[#222] text-gray-400 hover:text-white hover:border-[#444] px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest whitespace-nowrap transition-colors">Les Plus Populaires</button>
                <button class="bg-[#111] border border-[#222] text-gray-400 hover:text-white hover:border-[#444] px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest whitespace-nowrap transition-colors">Nouveautés</button>
            </div>
            <div class="relative w-full md:w-64">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                <input type="text" placeholder="Rechercher une compétence..." class="w-full bg-[#111] border border-[#222] text-white text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:border-[#FF6B00] transition-colors">
            </div>
        </div>
    </div>

    {{-- GRILLE CATALOGUE PREMIUM (STYLE UDEMY / COURSERA) --}}
    <section class="bg-[#0A0A0A] py-16 lg:py-24 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            
            <h2 class="text-2xl font-bold text-white mb-8 border-b border-[#222] pb-4">
                Développez vos compétences
                <span class="block text-sm font-normal text-gray-500 mt-2">Découvrez notre catalogue de formations certifiantes.</span>
            </h2>

            {{-- FORMATION À LA UNE --}}
            @if($formations->count() > 0)
            @php $featuredFormation = $formations->first(); @endphp
            <div class="mb-16">
                <div class="group bg-[#111111] border border-[#222] rounded-3xl overflow-hidden flex flex-col lg:flex-row hover:border-[#FF6B00]/40 transition-all duration-300 shadow-xl">
                    {{-- Image --}}
                    <div class="lg:w-1/2 aspect-video lg:aspect-auto relative overflow-hidden bg-[#050505] flex-shrink-0">
                        {{-- Overlay de jonction plus doux pour écran large --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-[#111111] z-10 hidden lg:block border-r border-[#1A1A1A]"></div>
                        <img src="{{ $featuredFormation->image_url ?? asset('images/formation-placeholder.jpg') }}" 
                             alt="{{ $featuredFormation->nom }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                        
                        <div class="absolute top-6 left-6 z-20">
                            <span class="bg-[#FF6B00] text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-md shadow-lg flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                Formation à la une
                            </span>
                        </div>
                    </div>
                    
                    {{-- Contenu Droite --}}
                    <div class="lg:w-1/2 p-8 lg:p-12 xl:p-16 flex flex-col justify-center relative z-20">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-[#FF6B00] font-bold">{{ $featuredFormation->note ?? '5.0' }}</span>
                            <div class="flex text-[#FF6B00] text-xs">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="text-xs text-gray-500 ml-1">(Best-seller)</span>
                        </div>
                        
                        <a href="{{ route('formations.show', $featuredFormation->slug) }}" class="block">
                            <h3 class="text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-6 leading-tight group-hover:text-[#FF6B00] transition-colors">
                                {{ $featuredFormation->nom }}
                            </h3>
                        </a>
                        
                        <p class="text-gray-400 text-base leading-relaxed mb-8">
                            {{ Str::limit($featuredFormation->description_courte ?? 'Acquiers des compétences ultra-prisées et démarque-toi sur le marché caché de l\'emploi grâce aux méthodes de Coach Didi.', 150) }}
                        </p>

                        <div class="flex flex-wrap gap-3 mb-8 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                            <span class="bg-[#1A1A1A] border border-[#333] px-3 py-1.5 rounded-lg flex items-center">
                                <i class="far fa-clock mr-2 text-[#FF6B00] text-sm"></i> {{ $featuredFormation->duree ?? 'Programme complet' }}
                            </span>
                            <span class="bg-[#1A1A1A] border border-[#333] px-3 py-1.5 rounded-lg flex items-center">
                                <i class="fas fa-certificate mr-2 text-[#FF6B00] text-sm"></i> Certifiante
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between border-t border-[#222] pt-8 mt-auto">
                            <div>
                                <div class="font-bold text-2xl lg:text-3xl text-white">
                                    {{ number_format($featuredFormation->prix, 0, ',', ' ') }} <span class="text-sm text-[#FF6B00] uppercase tracking-widest">FCFA</span>
                                </div>
                                @if($featuredFormation->prix_barre)
                                <div class="text-xs text-gray-500 line-through mt-1">
                                    {{ number_format($featuredFormation->prix_barre, 0, ',', ' ') }} FCFA
                                </div>
                                @endif
                            </div>
                            <a href="{{ route('formations.show', $featuredFormation->slug) }}" class="flex items-center justify-center bg-[#FF6B00] text-white px-6 py-4 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[#e55a00] hover:shadow-[0_0_15px_rgba(255,107,0,0.4)] transition-all gap-2 group/btn">
                                <span>Découvrir</span>
                                <i class="fas fa-arrow-right transform group-hover/btn:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 hover:cursor-pointer">
                @forelse($formations as $formation)
                    @if(isset($featuredFormation) && $formation->id === $featuredFormation->id)
                        @continue
                    @endif
                    <a href="{{ route('formations.show', $formation->slug) }}" class="group flex flex-col bg-[#111111] border border-[#222] rounded-2xl overflow-hidden hover:border-[#FF6B00]/70 hover:shadow-[0_10px_30px_rgba(255,107,0,0.1)] transition-all duration-300">
                        
                        {{-- Image & Badges --}}
                        <div class="relative aspect-video bg-[#050505] overflow-hidden">
                            <img src="{{ $formation->image_url ?? asset('images/formation-placeholder.jpg') }}" 
                                 alt="{{ $formation->nom }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                            
                            {{-- Badge Bestseller (Conditionnel simule) --}}
                            @if($loop->first || ($formation->badge && str_contains(strtolower($formation->badge), 'phare')))
                                <span class="absolute top-3 left-3 bg-[#FF6B00] text-white text-[9px] font-bold uppercase tracking-widest px-2 py-1 rounded shadow-md">
                                    Meilleure Vente
                                </span>
                            @endif

                            {{-- Overlay Play Button --}}
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="w-12 h-12 rounded-full bg-[#FF6B00] flex items-center justify-center text-white scale-75 group-hover:scale-100 transition-transform duration-300 delay-100">
                                    <i class="fas fa-play ml-1"></i>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Contenu Pédagogique --}}
                        <div class="p-5 flex flex-col flex-grow relative">
                            {{-- Titre --}}
                            <h3 class="font-bold text-lg text-white mb-2 leading-tight group-hover:text-[#FF6B00] transition-colors line-clamp-2">
                                {{ $formation->nom }}
                            </h3>
                            
                            {{-- Formateur --}}
                            <p class="text-xs text-gray-400 mb-2">Par Coach Didi</p>
                            
                            {{-- Rating Style Udemy --}}
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-[#FF6B00] font-bold text-sm">{{ $formation->note ?? '4.9' }}</span>
                                <div class="flex text-[#FF6B00] text-[10px]">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-xs text-gray-500">({{ rand(120, 850) }})</span>
                            </div>

                            {{-- Metadata Chips --}}
                            <div class="flex flex-wrap items-center gap-2 mb-4 text-[10px] uppercase font-bold tracking-widest text-gray-500">
                                <span class="bg-[#1A1A1A] px-2 py-1 rounded border border-[#333]">
                                    <i class="far fa-clock mr-1"></i> {{ $formation->duree ?? '4 H' }}
                                </span>
                                <span class="bg-[#1A1A1A] px-2 py-1 rounded border border-[#333]">
                                    <i class="fas fa-layer-group mr-1"></i> Tous Niveaux
                                </span>
                            </div>

                            {{-- Prix --}}
                            <div class="mt-auto pt-4 border-t border-[#222] flex items-end justify-between">
                                <div>
                                    <div class="font-bold text-xl text-white">
                                        {{ number_format($formation->prix, 0, ',', ' ') }} <span class="text-sm text-[#FF6B00]">FCFA</span>
                                    </div>
                                    @if($formation->prix_barre)
                                        <div class="text-xs text-gray-500 line-through">
                                            {{ number_format($formation->prix_barre, 0, ',', ' ') }} FCFA
                                        </div>
                                    @endif
                                </div>
                                <span class="text-[#FF6B00] opacity-0 group-hover:opacity-100 group-hover:-translate-x-1 transition-all duration-300">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-20 text-center bg-[#111] border border-[#222] rounded-2xl">
                        <i class="fas fa-exclamation-circle text-4xl text-gray-600 mb-4"></i>
                        <p class="text-white text-lg font-bold">Aucune formation disponible</p>
                        <p class="text-gray-500 mt-2">Le catalogue est en cours de mise à jour.</p>
                    </div>
                @endforelse
            </div>

            {{-- Bouton Charger plus / Pagination --}}
            @if(count($formations) > 0)
            <div class="mt-16 text-center border-t border-[#222] pt-12">
                <button class="bg-transparent border border-[#333] text-white px-8 py-3 rounded-xl font-bold uppercase tracking-widest text-xs hover:border-[#FF6B00] hover:text-[#FF6B00] transition-colors">
                    Afficher plus de formations
                </button>
            </div>
            @endif
        </div>
    </section>

    {{-- SECTION GARANTIES E-LEARNING PREMIUM --}}
    <section class="bg-[#050505] py-20 border-t border-[#111]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center md:text-left flex flex-col md:flex-row items-center md:items-start gap-4">
                    <div class="w-12 h-12 bg-[#111] rounded-full flex items-center justify-center text-[#FF6B00] flex-shrink-0">
                        <i class="fas fa-mobile-alt text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-1">Apprends à ton rythme</h4>
                        <p class="text-sm text-gray-500">Accessible 24/7 sur PC, tablette ou smartphone.</p>
                    </div>
                </div>
                <div class="text-center md:text-left flex flex-col md:flex-row items-center md:items-start gap-4">
                    <div class="w-12 h-12 bg-[#111] rounded-full flex items-center justify-center text-[#FF6B00] flex-shrink-0">
                        <i class="fas fa-certificate text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-1">Certificat de réussite</h4>
                        <p class="text-sm text-gray-500">Obtiens un certificat pour valoriser ton profil.</p>
                    </div>
                </div>
                <div class="text-center md:text-left flex flex-col md:flex-row items-center md:items-start gap-4">
                    <div class="w-12 h-12 bg-[#111] rounded-full flex items-center justify-center text-[#FF6B00] flex-shrink-0">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-1">Communauté privée</h4>
                        <p class="text-sm text-gray-500">Rejoins un réseau d'ambitieux pour t'entraider.</p>
                    </div>
                </div>
                <div class="text-center md:text-left flex flex-col md:flex-row items-center md:items-start gap-4">
                    <div class="w-12 h-12 bg-[#111] rounded-full flex items-center justify-center text-[#FF6B00] flex-shrink-0">
                        <i class="fas fa-shield-alt text-xl"></i>
                    </div>
                    <div>
                        <h4 class="text-white font-bold mb-1">Paiement sécurisé</h4>
                        <p class="text-sm text-gray-500">Transactions 100% protégées et chiffrées.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
