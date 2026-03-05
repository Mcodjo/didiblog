<x-layouts.app title="Accueil">

{{-- ═══════════════════════════════════════════════════════════
     SECTION 1 — HERO COACH
     Fond: Noir #0A0A0A | Layout 2 colonnes asymétriques
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#0A0A0A] relative overflow-hidden pt-28 pb-12 lg:pt-32 lg:pb-16">
    {{-- Subtle grid pattern --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="max-w-6xl mx-auto px-8 lg:px-16 relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-20">

            {{-- Colonne gauche — Texte --}}
            <div class="w-full lg:w-[55%] flex flex-col justify-center">
                <span class="text-[#FF6B00] text-xs font-bold tracking-[0.3em] uppercase mb-3 block">
                    Coach Emploi &amp; Carrière
                </span>

                <h1 class="text-4xl sm:text-5xl lg:text-5xl xl:text-6xl font-bold text-white leading-[1.1] mb-4">
                    Décroche<br>
                    l'emploi que<br>
                    <span class="text-[#FF6B00]">tu mérites</span>
                </h1>

                <div class="w-16 h-[3px] bg-[#FF6B00] mb-5 rounded-full"></div>

                <p class="text-gray-400 text-sm sm:text-base leading-relaxed max-w-xl mb-10 font-medium">
                    Je t'aide, talent d'Afrique, à décrocher ton poste idéal en moins de 90 jours avec des méthodes concrètes qui fonctionnent.
                </p>

                {{-- CTA --}}
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('guide-gratuit') }}"
                       class="bg-[#FF6B00] text-white px-7 py-3.5 text-xs font-bold tracking-[0.2em] uppercase rounded-full hover:bg-[#E55A00] transition-all duration-300 text-center shadow-[0_4px_14px_rgba(255,107,0,0.3)] hover:shadow-[0_6px_20px_rgba(255,107,0,0.4)] hover:-translate-y-0.5">
                        <i class="fas fa-download mr-2"></i> Télécharger le guide gratuit
                    </a>
                    <a href="{{ route('blog.index') }}"
                       class="border border-white/30 text-white px-7 py-3.5 text-xs font-bold tracking-[0.2em] uppercase rounded-full hover:bg-white hover:text-[#0A0A0A] transition-all duration-300 text-center hover:-translate-y-0.5">
                        Lire le blog
                    </a>
                </div>
            </div>

            {{-- Colonne droite — Photo Coach --}}
            <div class="w-full lg:w-[45%] hidden lg:block">
                <div class="relative w-full max-w-[22rem] ml-auto aspect-[4/5] rounded-[2rem] overflow-hidden shadow-[0_20px_50px_rgba(255,107,0,0.1)] border border-white/10 group">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A] via-transparent to-transparent opacity-80 z-10"></div>
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                         alt="Coach Didi — Cadnel DOSSOU, expert en employabilité"
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-700">
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     SECTION 1.5 — STATISTIQUES ANIMÉES
     Fond: Noir profond #111111 | 4 colonnes
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#111] border-y border-[#222] py-12 relative z-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-0 divide-y md:divide-y-0 md:divide-x divide-[#333] text-center">
            
            {{-- Stat 1 --}}
            <div class="py-4 md:py-0 flex flex-col items-center justify-center">
                <div class="text-4xl lg:text-5xl font-bold text-white font-['Playfair_Display'] mb-2">
                    <span class="animate-counter" data-target="4300">0</span><span class="text-[#FF6B00]">+</span>
                </div>
                <div class="text-xs text-gray-300 font-bold tracking-[0.15em] uppercase mb-1">Personnes accompagnées</div>
                <div class="text-[10px] text-gray-500 tracking-wider">Depuis 2016</div>
            </div>

            {{-- Stat 2 --}}
            <div class="py-4 md:py-0 flex flex-col items-center justify-center">
                <div class="text-4xl lg:text-5xl font-bold text-white font-['Playfair_Display'] mb-2">
                    <span class="animate-counter" data-target="85">0</span><span class="text-[#FF6B00]">%</span>
                </div>
                <div class="text-xs text-gray-300 font-bold tracking-[0.15em] uppercase mb-1">Taux de réussite</div>
                <div class="text-[10px] text-gray-500 tracking-wider">Emploi trouvé</div>
            </div>

            {{-- Stat 3 --}}
            <div class="py-4 md:py-0 flex flex-col items-center justify-center">
                <div class="text-4xl lg:text-5xl font-bold text-white font-['Playfair_Display'] mb-2">
                    <span class="animate-counter" data-target="5">0</span><span class="text-[#FF6B00]"></span>
                </div>
                <div class="text-xs text-gray-300 font-bold tracking-[0.15em] uppercase mb-1">Formations</div>
                <div class="text-[10px] text-gray-500 tracking-wider">En ligne</div>
            </div>

            {{-- Stat 4 --}}
            <div class="py-4 md:py-0 flex flex-col items-center justify-center">
                <div class="text-4xl lg:text-5xl font-bold text-white font-['Playfair_Display'] mb-2">
                    <span class="animate-counter" data-target="4.9">0.0</span><span class="text-[#FF6B00]">/5</span>
                </div>
                <div class="text-xs text-gray-300 font-bold tracking-[0.15em] uppercase mb-1">Note moyenne</div>
                <div class="text-[10px] text-gray-500 tracking-wider">Avis certifiés</div>
            </div>

        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const endVal = parseFloat(target.getAttribute('data-target'));
                const isFloat = endVal % 1 !== 0;
                const duration = 2000; // Animation dure 2 secondes
                const startVal = 0;
                let startTime = null;

                const step = (currentTime) => {
                    if (!startTime) startTime = currentTime;
                    const progress = Math.min((currentTime - startTime) / duration, 1);
                    // Easing effect (easeOutExpo)
                    const easeProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                    const currentVal = easeProgress * endVal;
                    
                    if (isFloat) {
                        target.innerText = currentVal.toFixed(1);
                    } else {
                        target.innerText = Math.floor(currentVal);
                    }

                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    } else {
                        target.innerText = isFloat ? endVal.toFixed(1) : endVal;
                    }
                };
                window.requestAnimationFrame(step);
                obs.unobserve(target); // Animer une seule fois
            }
        });
    });

    document.querySelectorAll('.animate-counter').forEach(el => observer.observe(el));
});
</script>

{{-- Removed SECTION 2 and SECTION 3 and SECTION 4 as requested. --}}


{{-- ═══════════════════════════════════════════════════════════
     SECTION 5 — FORMATIONS
     Fond: Noir #0A0A0A | Conditionnelle
════════════════════════════════════════════════════════════════ --}}
@if($formations->isNotEmpty())
<section class="bg-[#0A0A0A] py-20 lg:py-28 relative">
    <div class="absolute inset-0 opacity-[0.02]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 40px 40px;"></div>
    <div class="max-w-7xl mx-auto px-6 sm:px-12 relative z-10">

        {{-- En-tête --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between mb-14 gap-4">
            <div>
                <span class="text-[#FF6B00] text-xs font-medium tracking-[0.3em] uppercase block mb-4">
                    Formations
                </span>
                <h2 class="text-4xl lg:text-5xl font-bold text-white">
                    Investis dans<br>ta carrière
                </h2>
                <div class="w-16 h-[2px] bg-[#FF6B00] mt-6 rounded-full"></div>
            </div>
            <a href="{{ route('formations.index') }}"
               class="text-sm text-gray-400 hover:text-[#FF6B00] transition-all duration-300 tracking-wide self-end">
                Voir toutes les formations →
            </a>
        </div>

        {{-- Grille formations --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($formations as $formation)
            <div class="bg-[#111] border border-[#222] hover:border-[#FF6B00] transition-all duration-300 flex flex-col rounded-2xl overflow-hidden group">
                {{-- Image --}}
                <div class="aspect-video overflow-hidden relative">
                    <div class="absolute inset-0 bg-[#0A0A0A] opacity-20 group-hover:opacity-0 transition-opacity z-10"></div>
                    <img src="{{ $formation->image_url ?? asset('images/article-placeholder.svg') }}"
                         alt="{{ $formation->nom }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700">
                </div>
                {{-- Contenu --}}
                <div class="p-8 flex flex-col flex-1">
                    @if($formation->badge)
                    <span class="inline-block bg-[#FF6B00]/10 text-[#FF6B00] text-xs font-bold uppercase tracking-widest px-3 py-1.5 mb-4 rounded-full border border-[#FF6B00]/20 w-fit">
                        {{ $formation->badge }}
                    </span>
                    @endif
                    <h3 class="text-xl font-bold text-white mt-1 mb-4 flex-1">
                        {{ $formation->nom }}
                    </h3>
                    {{-- Étoiles + Prix --}}
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-2">
                            <span class="text-[#FF6B00] text-sm tracking-tight">★★★★★</span>
                            @if(isset($formation->note))
                            <span class="text-gray-500 text-xs">({{ $formation->note }})</span>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="text-[#FF6B00] font-bold text-lg">{{ number_format($formation->prix, 0) }} XOF</span>
                            @if($formation->prix_barre)
                            <span class="text-gray-500 text-sm line-through ml-2">{{ number_format($formation->prix_barre, 0) }}</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('formations.show', $formation->slug) }}"
                       class="border border-[#333] text-gray-300 px-6 py-3.5 text-xs font-bold tracking-[0.2em] uppercase rounded-full hover:border-[#FF6B00] hover:bg-[#FF6B00] hover:text-white transition-all duration-300 text-center hover:-translate-y-0.5">
                        Découvrir la formation
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════
     SECTION 6 — ARTICLES RÉCENTS
     Fond: Gris Très Foncé #111111 | Conditionnelle
════════════════════════════════════════════════════════════════ --}}
@if($recentArticles->isNotEmpty())
<section class="bg-[#111111] py-20 lg:py-28 font-sans">
    <div class="max-w-7xl mx-auto px-6 sm:px-12">

        {{-- En-tête --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between mb-14 gap-4">
            <div>
                <span class="text-[#FF6B00] text-xs font-bold tracking-[0.3em] uppercase block mb-4">
                    Le Blog
                </span>
                <h2 class="text-4xl lg:text-5xl font-bold text-white">
                    Conseils gratuits<br>pour booster ta recherche
                </h2>
                <div class="w-16 h-[2px] bg-[#FF6B00] mt-6 rounded-full"></div>
            </div>
            <a href="{{ route('blog.index') }}"
               class="text-sm text-gray-400 hover:text-[#FF6B00] transition-all duration-300 tracking-wide self-end">
                Voir tous les articles →
            </a>
        </div>

        {{-- Article vedette --}}
        @if($featuredArticle)
        <div class="bg-[#0A0A0A] border border-[#222] hover:border-[#FF6B00] transition-all duration-300 mb-10 lg:flex rounded-2xl overflow-hidden group">
            <div class="lg:w-1/2 aspect-video lg:aspect-auto overflow-hidden relative">
                <div class="absolute inset-0 bg-[#0A0A0A] opacity-20 group-hover:opacity-0 transition-opacity z-10"></div>
                <img src="{{ $featuredArticle->image_url ?? asset('images/article-placeholder.svg') }}"
                     alt="{{ $featuredArticle->titre }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700">
            </div>
            <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                <span class="inline-block bg-[#FF6B00]/10 text-[#FF6B00] text-xs font-bold uppercase tracking-widest px-3 py-1.5 mb-5 w-fit rounded-full border border-[#FF6B00]/20">
                    Article vedette
                </span>
                <h3 class="text-2xl lg:text-3xl font-bold text-white mb-4">
                    {{ $featuredArticle->titre }}
                </h3>
                <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-2">
                    {{ $featuredArticle->extrait }}
                </p>
                <div class="flex items-center gap-4 mb-8 text-xs text-gray-500">
                    <span><i class="fas fa-user mr-1 text-gray-600"></i>{{ $featuredArticle->auteur }}</span>
                    <span>{{ $featuredArticle->created_at->format('d M Y') }}</span>
                    <span>{{ $featuredArticle->temps_lecture }}</span>
                </div>
                <a href="{{ route('blog.show', $featuredArticle->slug) }}"
                   class="text-[#FF6B00] text-sm font-bold tracking-wider hover:underline">
                    Lire l'article →
                </a>
            </div>
        </div>
        @endif

        {{-- Grille 3 articles --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recentArticles->take(3) as $article)
            @if(!$featuredArticle || $article->id !== $featuredArticle->id)
            <article class="bg-[#0A0A0A] border border-[#222] hover:border-[#FF6B00] transition-all duration-300 flex flex-col rounded-2xl overflow-hidden group">
                <div class="aspect-video overflow-hidden relative">
                    <div class="absolute inset-0 bg-[#0A0A0A] opacity-20 group-hover:opacity-0 transition-opacity z-10"></div>
                    <img src="{{ $article->image_url ?? asset('images/article-placeholder.svg') }}"
                         alt="{{ $article->titre }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700">
                </div>
                <div class="p-8 flex flex-col flex-1">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs uppercase tracking-widest font-bold text-white px-3 py-1 bg-[#1A1A1A] rounded-full border border-[#333]">
                            {{ $article->categorie->nom ?? 'Général' }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $article->temps_lecture }}
                        </span>
                    </div>
                    <h3 class="font-bold text-white text-lg mb-3 flex-1 leading-snug">
                        {{ $article->titre }}
                    </h3>
                    <p class="text-gray-400 text-sm mb-6 line-clamp-2">
                        {{ Str::limit($article->extrait, 100) }}
                    </p>
                    <div class="flex items-center justify-between mt-auto pt-5 border-t border-[#222]">
                        <span class="text-xs text-gray-500">
                            {{ $article->auteur }} · {{ $article->created_at->format('d M Y') }}
                        </span>
                        <a href="{{ route('blog.show', $article->slug) }}"
                           class="text-[#FF6B00] text-xs font-bold uppercase tracking-wider hover:underline">
                            Lire →
                        </a>
                    </div>
                </div>
            </article>
            @endif
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════
     SECTION 6.5 — TÉMOIGNAGES (Réintégré avant Explorer)
     Fond: Noir #0A0A0A | Conditionnelle
════════════════════════════════════════════════════════════════ --}}
@if(isset($testimonials) && $testimonials->isNotEmpty())
<section class="bg-[#0A0A0A] py-20 lg:py-28 relative overflow-hidden">
    {{-- Decorative element --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#FF6B00] rounded-full mix-blend-multiply filter blur-[128px] opacity-10"></div>
    <div class="max-w-7xl mx-auto px-6 sm:px-12 relative z-10">

        {{-- En-tête --}}
        <div class="mb-14 text-center">
            <span class="text-[#FF6B00] text-xs font-bold tracking-[0.3em] uppercase block mb-4">
                Témoignages
            </span>
            <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                Des résultats concrets
            </h2>
            <div class="w-16 h-[2px] bg-[#FF6B00] mx-auto rounded-full"></div>
        </div>

        {{-- Grille témoignages --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($testimonials->take(3) as $testimonial)
            <div class="bg-[#111] border border-[#222] p-8 rounded-2xl relative">
                <i class="fas fa-quote-right absolute top-6 right-6 text-4xl text-[#222]"></i>
                @if($testimonial->featured)
                <span class="inline-flex items-center gap-1 bg-[#FF6B00]/10 text-[#FF6B00] text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 mb-5 rounded-full border border-[#FF6B00]/20">
                    <i class="fas fa-star"></i> Coup de cœur
                </span>
                @endif
                <p class="font-['Playfair_Display'] text-gray-300 text-lg italic leading-relaxed mb-8 relative z-10">
                    &ldquo;{{ $testimonial->content }}&rdquo;
                </p>
                <div class="flex items-center gap-4 border-t border-[#222] pt-6">
                    @if($testimonial->photo)
                    <img src="{{ $testimonial->photo }}" alt="{{ $testimonial->name }}"
                         class="w-12 h-12 rounded-full object-cover border border-[#333]">
                    @else
                    <div class="w-12 h-12 rounded-full bg-[#1A1A1A] border border-[#333] flex items-center justify-center text-[#FF6B00] font-bold">
                        {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                    </div>
                    @endif
                    <div>
                        <div class="font-bold text-white text-sm">
                            {{ $testimonial->name }}
                        </div>
                        @if($testimonial->role || $testimonial->company)
                        <div class="text-gray-500 text-xs mt-1">
                            {{ $testimonial->role }}@if($testimonial->role && $testimonial->company) · @endif{{ $testimonial->company }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════
     SECTION 7 — CATÉGORIES
     Fond: Noir #0A0A0A | Conditionnelle
════════════════════════════════════════════════════════════════ --}}
@if($categories->isNotEmpty())
<section class="bg-[#0A0A0A] py-20 lg:py-28">
    <div class="max-w-7xl mx-auto px-6 sm:px-12">

        {{-- En-tête --}}
        <div class="mb-14">
            <span class="text-[#FF6B00] text-xs font-medium tracking-[0.3em] uppercase block mb-4">
                Explorer
            </span>
            <h2 class="text-4xl lg:text-5xl font-bold text-white">
                Par où commencer ?
            </h2>
            <div class="w-16 h-[2px] bg-[#FF6B00] mt-6 rounded-full"></div>
        </div>

        {{-- Grille catégories --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($categories as $category)
            <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
               class="group bg-[#1A1A1A] border border-gray-800 hover:border-[#FF6B00] transition-all duration-300 p-6 flex flex-col rounded-xl hover:-translate-y-1"
               aria-label="Voir les articles de la catégorie {{ $category->nom }}">
                <div class="text-3xl mb-4" style="color: {{ $category->couleur }}">
                    <i class="{{ $category->icone }}"></i>
                </div>
                <h3 class="font-semibold text-white group-hover:text-[#FF6B00] transition-all duration-300 text-base mb-2">
                    {{ $category->nom }}
                </h3>
                @if($category->description)
                <p class="text-gray-400 text-xs mt-1 mb-4 leading-relaxed flex-1">
                    {{ Str::limit($category->description, 60) }}
                </p>
                @endif
                <span class="border border-gray-700 text-gray-400 text-xs px-2 py-1 w-fit mt-auto rounded-full">
                    {{ $category->articles_count }} article{{ $category->articles_count > 1 ? 's' : '' }}
                </span>
            </a>
            @endforeach
        </div>

    </div>
</section>
@endif


{{-- ═══════════════════════════════════════════════════════════
     SECTION 8 — CTA FINAL
     Fond: Orange #FF6B00
════════════════════════════════════════════════════════════════ --}}
<section class="bg-[#FF6B00] py-24">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-4xl lg:text-6xl font-bold text-white mb-6">
            Prêt à décrocher<br>ton emploi ?
        </h2>
        <p class="text-white opacity-90 text-lg mb-10 max-w-xl mx-auto">
            Rejoins les 4 300+ personnes que Coach Didi a déjà accompagnées.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('guide-gratuit') }}"
               class="bg-white text-[#FF6B00] px-8 py-3.5 text-xs font-semibold tracking-[0.2em] uppercase rounded-full hover:bg-[#0A0A0A] hover:text-white transition-all duration-300 hover:-translate-y-0.5">
                Télécharger le guide gratuit
            </a>
            <a href="{{ route('contact') }}"
               class="border border-white text-white px-8 py-3.5 text-xs font-semibold tracking-[0.2em] uppercase rounded-full hover:bg-white hover:text-[#FF6B00] transition-all duration-300 hover:-translate-y-0.5">
                Contacter Coach Didi
            </a>
        </div>
    </div>
</section>

</x-layouts.app>
