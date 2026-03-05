<x-layouts.app title="Le Blog — Emploi Connect">
    {{-- EN-TÊTE PREMIUM STYLED --}}
    <section class="bg-[#0A0A0A] relative pt-32 lg:pt-48 pb-32 lg:pb-40 overflow-hidden">
        {{-- Effet de lueur --}}
        <div class="absolute top-[-20%] left-[50%] translate-x-[-50%] w-[600px] h-[600px] bg-[#FF6B00] blur-[150px] opacity-10 rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#FF6B00]/10 border border-[#FF6B00]/20 text-[#FF6B00] text-xs font-bold uppercase tracking-widest mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-[#FF6B00] animate-pulse"></span>
                Ressources & Stratégies
            </span>
            <h1 class="text-5xl lg:text-7xl font-bold text-white mb-6 tracking-tight">
                Le journal de bord <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF6B00] to-yellow-500">du candidat d'élite.</span>
            </h1>
            <p class="text-lg text-gray-400 max-w-2xl mx-auto font-light">
                Méthodes concrètes, retours d'expérience et conseils pratiques pour décrocher les meilleures opportunités sur le marché.
            </p>
        </div>
    </section>

    {{-- BARRE DE NAVIGATION ET RECHERCHE (GLASSMORPHISM FLOATTANT) --}}
    <div class="relative z-50 max-w-6xl mx-auto px-6 -mt-10 lg:-mt-12 mb-16">
        <div class="bg-[#111111]/80 backdrop-blur-xl border border-[#222] rounded-2xl p-4 flex flex-col md:flex-row gap-4 items-center justify-between shadow-2xl shadow-black/50">
            {{-- Filtres Catégories --}}
            <div class="flex flex-wrap gap-2 items-center w-full md:w-auto overflow-x-auto pb-2 md:pb-0 scrollbar-hide">
                <a href="{{ route('blog.index') }}"
                   class="whitespace-nowrap text-xs font-bold tracking-widest uppercase px-5 py-2.5 rounded-xl transition-all {{ empty($categorySlug) ? 'bg-[#FF6B00] text-white shadow-[0_0_15px_rgba(255,107,0,0.3)] border border-[#FF6B00]' : 'bg-transparent text-gray-400 hover:text-white hover:bg-[#222] border border-transparent' }}">
                    Tout voir
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                   class="whitespace-nowrap text-xs font-bold tracking-widest uppercase px-5 py-2.5 rounded-xl transition-all {{ $categorySlug === $cat->slug ? 'bg-[#FF6B00] text-white shadow-[0_0_15px_rgba(255,107,0,0.3)] border border-[#FF6B00]' : 'bg-transparent text-gray-400 hover:text-white hover:bg-[#222] border border-transparent' }}">
                    {{ $cat->nom }}
                </a>
                @endforeach
            </div>
            
            {{-- Recherche --}}
            <form method="GET" action="{{ route('blog.index') }}" class="relative w-full md:w-80 group">
                @if(!empty($categorySlug))
                <input type="hidden" name="category" value="{{ $categorySlug }}">
                @endif
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-500 group-focus-within:text-[#FF6B00] transition-colors"></i>
                </div>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="Rechercher un article..."
                       class="w-full bg-[#0A0A0A] border border-[#222] text-white text-sm rounded-xl pl-11 pr-4 py-3 focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] transition-all placeholder-gray-600">
            </form>
        </div>
    </div>

    <div class="bg-[#0A0A0A] pb-24 lg:pb-32 -mt-32 pt-32">
        <div class="max-w-7xl mx-auto px-6">
            
            {{-- EN VEDETTE --}}
            @if(isset($featured) && $featured && empty($search) && empty($categorySlug))
            <div class="mb-20">
                <div class="bg-[#111111] border border-[#222] rounded-3xl overflow-hidden flex flex-col lg:flex-row hover:border-[#FF6B00]/40 transition-all duration-300 shadow-xl group">
                    {{-- Image --}}
                    <div class="lg:w-1/2 aspect-video lg:aspect-auto overflow-hidden relative">
                        {{-- Overlay transparent vers sombre (uniquement desktop) --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-[#111111] z-10 hidden lg:block border-r border-[#111]/50"></div>
                        <img src="{{ $featured->image_url ?? asset('images/article-placeholder.svg') }}"
                             alt="{{ $featured->titre }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                    </div>
                    
                    {{-- Contenu Droite --}}
                    <div class="lg:w-1/2 p-8 lg:p-12 xl:p-16 flex flex-col justify-center relative z-20">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="bg-[#FF6B00]/10 text-[#FF6B00] border border-[#FF6B00]/20 text-[10px] font-bold tracking-widest uppercase px-3 py-1.5 rounded-md flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#FF6B00] animate-pulse"></span>
                                À la une
                            </span>
                            @if($featured->categorie)
                            <span class="text-gray-400 bg-[#1A1A1A] border border-[#333] text-[10px] uppercase tracking-widest px-3 py-1.5 rounded-md">
                                {{ $featured->categorie->nom }}
                            </span>
                            @endif
                        </div>
                        
                        <a href="{{ route('blog.show', $featured->slug) }}" class="block group/link">
                            <h2 class="text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-6 leading-snug group-hover/link:text-[#FF6B00] transition-colors">
                                {{ $featured->titre }}
                            </h2>
                        </a>
                        
                        <p class="text-gray-400 text-base leading-relaxed mb-8 line-clamp-3">
                            {{ $featured->extrait }}
                        </p>
                        
                        <div class="flex items-center justify-between pt-6 border-t border-[#222] mt-auto">
                            <div class="flex flex-col">
                                <span class="text-white text-sm font-bold">{{ $featured->auteur ?? "L'Équipe" }}</span>
                                <span class="text-gray-500 text-[11px] mt-1 uppercase tracking-wider">{{ $featured->created_at->format('d M Y') }} · {{ $featured->temps_lecture ?? '5 min' }}</span>
                            </div>
                            <a href="{{ route('blog.show', $featured->slug) }}" class="flex items-center justify-center w-12 h-12 rounded-full bg-[#FF6B00] text-white hover:bg-[#e55a00] hover:shadow-[0_0_15px_rgba(255,107,0,0.4)] transition-all transform group-hover:translate-x-1">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- LISTE DES ARTICLES --}}
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-[#222]">
                <h3 class="text-2xl font-bold text-white">
                    @if(!empty($search))
                        Résultats pour « <span class="text-[#FF6B00]">{{ $search }}</span> »
                    @elseif(!empty($categorySlug))
                        Articles dans <span class="text-[#FF6B00]">{{ $categorySlug }}</span>
                    @else
                        Dernières publications
                    @endif
                </h3>
                <span class="hidden md:inline-block text-[#FF6B00] text-xs font-bold tracking-widest bg-[#111] px-4 py-2 rounded-full border border-[#222] uppercase">
                    {{ $articles->total() }} Ressources
                </span>
            </div>

            @if($articles->isEmpty())
                <div class="bg-[#111111] border border-[#222] rounded-3xl p-16 text-center">
                    <div class="w-20 h-20 bg-[#1A1A1A] rounded-full mx-auto flex items-center justify-center mb-6">
                        <i class="fas fa-ghost text-3xl text-[#555]"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Aucun article trouvé</h3>
                    <p class="text-gray-400 mb-8 max-w-lg mx-auto">Nous n'avons trouvé aucun article correspondant à ta recherche. Essaie d'autres mots-clés ou réinitialise les filtres ou navigue dans les catégories.</p>
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 bg-[#FF6B00] text-white text-xs font-bold uppercase tracking-widest px-8 py-4 rounded-xl hover:bg-[#e55a00] hover:-translate-y-1 transition-all shadow-[0_5px_20px_-5px_rgba(255,107,0,0.5)]">
                        <i class="fas fa-sync-alt"></i> Tout afficher
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    @foreach($articles as $article)
                        @if(!isset($featured) || empty($featured) || $article->id !== $featured->id || !empty($search) || !empty($categorySlug))
                        <article class="group relative flex flex-col bg-[#111111] border border-[#222] hover:border-[#FF6B00]/70 rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_10px_40px_-10px_rgba(255,107,0,0.15)]">
                            <a href="{{ route('blog.show', $article->slug) }}" class="absolute inset-0 z-20"></a>
                            <div class="aspect-[16/10] overflow-hidden relative bg-[#0A0A0A]">
                                <div class="absolute inset-0 bg-[#0A0A0A] opacity-20 group-hover:opacity-0 transition-opacity duration-500 z-10"></div>
                                <img src="{{ $article->image_url ?? asset('images/article-placeholder.svg') }}"
                                     alt="{{ $article->titre }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                @if($article->categorie)
                                <span class="absolute top-4 left-4 z-10 bg-[#0A0A0A]/90 backdrop-blur-md border border-[#333] text-white text-[10px] font-bold tracking-widest uppercase px-3 py-1.5 rounded-lg">
                                    {{ $article->categorie->nom }}
                                </span>
                                @endif
                                <div class="absolute bottom-4 right-4 z-10 bg-[#111]/90 backdrop-blur text-white text-[10px] font-bold tracking-widest uppercase px-2 py-1 rounded border border-[#333]">
                                    {{ $article->temps_lecture ?? '5 min' }}
                                </div>
                            </div>
                            <div class="p-6 flex flex-col flex-1 relative z-30">
                                <div class="flex items-center gap-2 text-[10px] text-[#FF6B00] font-bold uppercase tracking-widest mb-3">
                                    <span>{{ $article->created_at->format('d M. Y') }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3 leading-snug group-hover:text-[#FF6B00] transition-colors">
                                    {{ $article->titre }}
                                </h3>
                                <p class="text-gray-400 text-sm line-clamp-2 mb-6 flex-1">
                                    {{ Str::limit($article->extrait, 120) }}
                                </p>
                                <div class="flex items-center justify-between pt-4 border-t border-[#222] mt-auto">
                                    <div class="flex items-center gap-2 text-xs">
                                        <div class="w-7 h-7 rounded-full bg-[#1A1A1A] border border-[#333] flex items-center justify-center text-gray-400">
                                            <i class="fas fa-user-astronaut text-[10px]"></i>
                                        </div>
                                        <span class="text-gray-400 font-bold group-hover:text-white transition-colors">{{ $article->auteur ?? 'Auteur' }}</span>
                                    </div>
                                    <span class="text-[#333] group-hover:text-[#FF6B00] transition-colors">
                                        <i class="fas fa-arrow-right -rotate-45 group-hover:rotate-0 transition-all duration-300"></i>
                                    </span>
                                </div>
                            </div>
                        </article>
                        @endif
                    @endforeach
                </div>
                
                {{-- Pagination Customisée Dark --}}
                <div class="flex justify-center mt-12 [&>nav_span]:bg-[#111] [&>nav_span]:border-[#222] [&>nav_a]:bg-[#111] [&>nav_a]:border-[#222]">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- NEWSLETTER CALL TO ACTION EXTRA PREMIUM --}}
    <section class="bg-[#0A0A0A] border-t border-[#1A1A1A] py-24 relative overflow-hidden">
        <div class="absolute inset-0 block pointer-events-none">
            <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-[#FF6B00] blur-[150px] opacity-10 rounded-full"></div>
        </div>
        <div class="max-w-5xl mx-auto px-6 relative z-10">
            <div class="bg-[#111111] border border-[#222] rounded-3xl p-10 lg:p-16 flex flex-col lg:flex-row items-center justify-between gap-12 shadow-2xl overflow-hidden relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#FF6B00] to-yellow-600 blur-[80px] opacity-10 rounded-full mix-blend-screen pointer-events-none"></div>
                <div class="lg:w-1/2 relative z-10">
                    <div class="w-14 h-14 bg-[#FF6B00]/10 border border-[#FF6B00]/20 rounded-2xl flex items-center justify-center mb-6 text-[#FF6B00]">
                        <i class="fas fa-envelope-open-text text-2xl"></i>
                    </div>
                    <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4 leading-tight">
                        Rejoins le sommet.<br>Abonne-toi.
                    </h2>
                    <p class="text-gray-400 text-sm leading-relaxed mb-0 font-light">
                        Reçois chaque semaine des hacks de productivité, des offres exclusives et les méthodes que seuls les top talents connaissent pour booster leur carrière.
                    </p>
                </div>
                <div class="lg:w-1/2 w-full relative z-10">
                    <form action="{{ route('newsletter.store') }}" method="POST" class="w-full bg-[#0A0A0A] p-2 rounded-[1.25rem] border border-[#222] flex flex-col sm:flex-row">
                        @csrf
                        <input type="hidden" name="source" value="blog_footer">
                        <div class="flex items-center pl-4 pr-2 text-gray-500">
                            <i class="fas fa-at"></i>
                        </div>
                        <input type="email" name="email" placeholder="ton-adresse@email.com" required
                               class="flex-1 bg-transparent text-white text-sm px-2 py-4 focus:outline-none placeholder-[#444]">
                        <button type="submit"
                                class="bg-[#FF6B00] text-white font-bold text-xs tracking-widest uppercase rounded-xl px-6 py-4 mt-2 sm:mt-0 hover:bg-[#e55a00] hover:shadow-[0_0_20px_rgba(255,107,0,0.3)] transition-all">
                            M'INSCRIRE
                        </button>
                    </form>
                    <p class="text-[#555] text-xs mt-4 flex items-center gap-2 pl-2">
                        <i class="fas fa-shield-alt text-[#FF6B00]/60"></i> Zéro spam. Désabonnement en 1 clic.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
