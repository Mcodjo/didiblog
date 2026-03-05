<x-layouts.app :title="$article->titre . ' — Emploi Connect'">
    {{-- PAGE HEADER ARTICLE --}}
    <section class="relative bg-[#0A0A0A] pt-32 lg:pt-48 pb-16 lg:pb-24 overflow-hidden border-b border-white/5">
        {{-- Glow subtil --}}
        <div class="absolute top-0 right-1/4 w-[400px] h-[400px] bg-[#FF6B00]/15 rounded-full blur-[120px] pointer-events-none"></div>
        
        <div class="max-w-4xl mx-auto px-6 relative z-10">
            {{-- Fil d'Ariane --}}
            <div class="flex flex-wrap items-center gap-2 font-['DM_Sans'] text-xs text-[#A3A3A3] font-medium tracking-widest uppercase mb-8">
                <a href="{{ route('home') }}" class="hover:text-[#FF6B00] transition-colors">Accueil</a>
                <span class="text-white/20">/</span>
                <a href="{{ route('blog.index') }}" class="hover:text-[#FF6B00] transition-colors">Blog</a>
                <span class="text-white/20">/</span>
                <span class="text-white truncate max-w-[200px] sm:max-w-xs">{{ $article->titre }}</span>
            </div>

            <div class="flex items-center gap-4 mb-6">
                {{-- Catégorie --}}
                @if($article->categorie)
                <span class="bg-[#FF6B00]/10 border border-[#FF6B00]/20 text-[#FF6B00] text-[10px] font-['DM_Sans'] font-bold tracking-widest uppercase px-4 py-1.5 rounded-full">
                    {{ $article->categorie->nom }}
                </span>
                @endif
                {{-- Temps de lecture --}}
                @if($article->temps_lecture)
                <span class="flex items-center gap-2 text-xs font-['DM_Sans'] text-[#A3A3A3] font-medium tracking-widest uppercase">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $article->temps_lecture }} min
                </span>
                @endif
            </div>

            {{-- Titre --}}
            <h1 class="font-['Playfair_Display'] text-4xl lg:text-6xl font-bold text-white leading-tight mb-8">
                {{ $article->titre }}
            </h1>

            {{-- Méta --}}
            <div class="flex flex-wrap items-center gap-4 sm:gap-6 font-['DM_Sans'] text-sm text-[#A3A3A3]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#111111] border border-white/10 overflow-hidden flex items-center justify-center">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100" alt="Coach Didi" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-white font-medium">{{ $article->auteur ?? 'Coach Didi' }}</p>
                        <p class="text-xs">{{ $article->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
                <div class="w-px h-8 bg-white/10 hidden sm:block"></div>
                <div class="flex items-center gap-2 text-xs font-medium tracking-widest uppercase">
                    <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <span>{{ number_format($article->vues) }} vues</span>
                </div>
            </div>
        </div>
    </section>

    {{-- IMAGE COVER --}}
    <div class="bg-[#050505] w-full pt-10 pb-8 lg:pt-16 lg:pb-12 px-6">
        <div class="max-w-6xl mx-auto">
            @if($article->image_url)
            <div class="relative rounded-2xl overflow-hidden border border-white/5 shadow-2xl">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A] via-transparent to-transparent z-10 opacity-80"></div>
                <img src="{{ $article->image_url }}" alt="{{ $article->titre }}"
                     class="w-full h-auto max-h-[400px] lg:max-h-[600px] object-cover relative z-0">
            </div>
            @endif
        </div>
    </div>

    {{-- CORPS ARTICLE --}}
    <section class="bg-[#050505] pb-24 lg:pb-32">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-16 lg:gap-24">
                
                {{-- Contenu Principal --}}
                <div class="lg:flex-1 min-w-0">
                    <article class="prose prose-lg lg:prose-xl max-w-none prose-invert font-['DM_Sans'] text-[#A3A3A3] 
                                    prose-headings:font-['Playfair_Display'] prose-headings:text-white prose-headings:font-bold
                                    prose-h2:text-3xl prose-h2:mt-12 prose-h2:mb-6 prose-h2:border-b prose-h2:border-white/5 prose-h2:pb-4
                                    prose-h3:text-2xl
                                    prose-p:leading-relaxed prose-p:mb-6
                                    prose-a:text-[#FF6B00] prose-a:no-underline hover:prose-a:underline 
                                    prose-img:rounded-2xl prose-img:border prose-img:border-white/5 
                                    prose-blockquote:border-l-[3px] prose-blockquote:border-[#FF6B00] prose-blockquote:bg-[#111111]/50 prose-blockquote:py-4 prose-blockquote:px-8 prose-blockquote:rounded-r-xl prose-blockquote:text-white prose-blockquote:font-style-italic prose-blockquote:m-0 prose-blockquote:my-8
                                    prose-strong:text-white prose-li:marker:text-[#FF6B00]">
                        {!! $article->contenu !!}
                    </article>

                    {{-- Partage --}}
                    <div class="mt-16 pt-10 border-t border-white/5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                        <span class="font-['DM_Sans'] text-xs font-bold tracking-widest uppercase text-white/50">Partager cet article</span>
                        <div class="flex items-center gap-4">
                            <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(request()->url()) }}&title={{ urlencode($article->titre) }}" target="_blank" rel="noopener noreferrer"
                               class="group flex items-center gap-3 font-['DM_Sans'] text-xs font-bold tracking-widest uppercase border border-white/10 rounded-full px-6 py-3 text-white hover:border-transparent hover:bg-[#0077b5] transition-all">
                                <i class="fab fa-linkedin text-lg group-hover:text-white"></i> LinkedIn
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer"
                               class="group flex items-center gap-3 font-['DM_Sans'] text-xs font-bold tracking-widest uppercase border border-white/10 rounded-full px-6 py-3 text-white hover:border-transparent hover:bg-[#1877f2] transition-all">
                                <i class="fab fa-facebook text-lg group-hover:text-white"></i> Facebook
                            </a>
                        </div>
                    </div>

                    {{-- Retour --}}
                    <div class="mt-16">
                        <a href="{{ route('blog.index') }}"
                           class="inline-flex items-center gap-4 font-['DM_Sans'] text-sm font-bold tracking-widest uppercase text-white/50 hover:text-[#FF6B00] transition-colors group">
                            <span class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center group-hover:bg-[#FF6B00]/20 group-hover:border-[#FF6B00]/30 transition-all">
                                ←
                            </span>
                            Retour à l'accueil du blog
                        </a>
                    </div>
                </div>

                {{-- Sidebar --}}
                <aside class="lg:w-[380px] flex-shrink-0">
                    <div class="sticky top-32 space-y-10">
                        {{-- Lead Magnet / Newsletter --}}
                        <div class="bg-[#111111]/80 backdrop-blur-xl border border-white/5 rounded-2xl p-8 relative overflow-hidden group hover:border-[#FF6B00]/20 transition-colors duration-500">
                            <div class="absolute top-0 right-0 w-48 h-48 bg-[#FF6B00]/10 rounded-full blur-[50px] pointer-events-none group-hover:bg-[#FF6B00]/20 transition-all duration-500"></div>
                            
                            <h3 class="font-['Playfair_Display'] text-2xl font-bold text-white mb-4 relative z-10">
                                Le Cercle Privé
                            </h3>
                            <p class="font-['DM_Sans'] text-[#A3A3A3] mb-8 relative z-10 leading-relaxed text-sm">
                                Rejoins <span class="text-white font-bold">4.3k+ candidats</span> qui reçoivent mes stratégies d'employabilité confidentielles chaque semaine.
                            </p>
                            <form action="{{ route('newsletter.store') }}" method="POST" class="flex flex-col gap-4 relative z-10">
                                @csrf
                                <input type="hidden" name="source" value="blog-show">
                                <div>
                                    <input type="email" name="email" placeholder="Ton adresse email" required
                                           class="w-full px-5 py-4 rounded-xl font-['DM_Sans'] text-sm bg-[#050505] text-white border border-white/10 focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] placeholder-white/30 transition-all">
                                </div>
                                <button type="submit"
                                        class="w-full bg-[#FF6B00] text-white rounded-xl font-['DM_Sans'] text-xs font-bold tracking-widest uppercase px-6 py-4 hover:bg-[#ff8533] hover:shadow-[0_0_20px_rgba(255,107,0,0.3)] transition-all duration-300">
                                    Débloquer l'accès
                                </button>
                            </form>
                        </div>

                        {{-- Articles liés --}}
                        @if(isset($relatedArticles) && $relatedArticles->count())
                        <div class="bg-[#111111]/40 border border-white/5 rounded-2xl p-8">
                            <h3 class="font-['DM_Sans'] text-xs font-bold tracking-widest uppercase text-white/50 mb-8 flex items-center gap-3">
                                <span class="w-8 h-[1px] bg-[#FF6B00]"></span>
                                À lire ensuite
                            </h3>
                            <div class="flex flex-col gap-6">
                                @foreach($relatedArticles as $related)
                                <a href="{{ route('blog.show', $related->slug) }}" class="group flex gap-5 items-start">
                                    <div class="w-24 h-20 rounded-xl overflow-hidden flex-shrink-0 relative">
                                        <div class="absolute inset-0 bg-[#FF6B00]/20 mix-blend-overlay opacity-0 group-hover:opacity-100 transition-opacity z-10"></div>
                                        <img src="{{ $related->image_url ?? 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=200' }}"
                                             alt="{{ $related->titre }}"
                                             class="w-full h-full object-cover grayscale-[0.8] group-hover:grayscale-0 group-hover:scale-110 transition-all duration-500">
                                    </div>
                                    <div class="flex flex-col h-full justify-between">
                                        <h4 class="font-['Playfair_Display'] font-bold text-white group-hover:text-[#FF6B00] transition-colors leading-snug line-clamp-2 text-sm">
                                            {{ $related->titre }}
                                        </h4>
                                        <p class="font-['DM_Sans'] text-[10px] text-white/30 uppercase tracking-wider font-bold mt-2">
                                            {{ $related->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.app>
