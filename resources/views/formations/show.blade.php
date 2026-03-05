<x-layouts.app :title="$formation->nom . ' — Emploi Connect'">
    
    {{-- HERO SECTION : Premium Dark Mode --}}
    <section class="relative bg-[#0A0A0A] pt-32 lg:pt-48 pb-16 lg:pb-32 overflow-hidden border-b border-white/5">
        {{-- Glow subtil --}}
        <div class="absolute top-1/2 left-0 -translate-y-1/2 w-[500px] h-[500px] bg-[#FF6B00]/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-start">
                
                {{-- Contenu Hero Gauche --}}
                <div class="lg:w-7/12 xl:w-2/3">
                    {{-- Fil d'Ariane --}}
                    <div class="flex flex-wrap items-center gap-2 text-[10px] font-bold tracking-widest uppercase text-white/50 mb-8">
                        <a href="{{ route('home') }}" class="hover:text-[#FF6B00] transition-colors">Accueil</a>
                        <span class="text-white/20">/</span>
                        <a href="{{ route('formations.index') }}" class="hover:text-[#FF6B00] transition-colors">Catalogue</a>
                        <span class="text-white/20">/</span>
                        <span class="text-[#FF6B00] truncate max-w-[200px] sm:max-w-none">{{ $formation->nom }}</span>
                    </div>

                    <h1 class="font-['Playfair_Display'] text-4xl lg:text-5xl xl:text-6xl font-bold text-white leading-tight mb-6 tracking-tight">
                        {{ $formation->nom }}
                    </h1>
                    
                    <p class="font-['DM_Sans'] text-lg text-[#A3A3A3] mb-10 leading-relaxed max-w-3xl">
                        {{ $formation->description }}
                    </p>

                    <div class="flex flex-wrap items-center gap-4 sm:gap-6 font-['DM_Sans'] text-sm mb-10">
                        @if($formation->badge)
                        <span class="bg-[#FF6B00]/10 border border-[#FF6B00]/20 text-[#FF6B00] px-4 py-1.5 rounded-full font-bold uppercase tracking-widest text-[10px]" style="{{ $formation->couleur_badge ? 'color: '.$formation->couleur_badge.'; border-color: '.$formation->couleur_badge.'40; background-color: '.$formation->couleur_badge.'1A;' : '' }}">
                            {{ $formation->badge }}
                        </span>
                        @endif
                        
                        <div class="flex items-center gap-2 bg-white/5 px-4 py-1.5 rounded-full border border-white/5">
                            <span class="text-[#FF6B00] font-bold">{{ $formation->note ?? '5.0' }}</span>
                            <div class="flex text-[#FF6B00] text-xs">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <span class="text-white/50 text-xs ml-1">(Évaluations)</span>
                        </div>
                        
                        <div class="flex items-center gap-2 text-[#A3A3A3] text-xs font-bold uppercase tracking-widest">
                            <i class="fas fa-layer-group text-white/40"></i> Niveau : {{ $formation->niveau ?? 'Tous niveaux' }}
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 text-sm text-[#A3A3A3] pt-6 border-t border-white/5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#111111] border border-white/10 overflow-hidden flex items-center justify-center shrink-0">
                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100" alt="Coach Didi" class="w-full h-full object-cover">
                            </div>
                            <div class="font-['DM_Sans']">
                                <span class="text-xs text-white/50 uppercase tracking-widest font-bold">Créé par</span><br>
                                <span class="text-white font-bold">Coach Didi</span>
                            </div>
                        </div>
                        <div class="w-px h-8 bg-white/10 hidden sm:block"></div>
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest">
                            <i class="fas fa-sync-alt text-white/40"></i> Maj: {{ $formation->updated_at->format('m/Y') }}
                        </div>
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest">
                            <i class="fas fa-globe text-white/40"></i> Français
                        </div>
                    </div>
                </div>

                {{-- Espace réservé pour la Box flottante sur Desktop, visible en Hero sur mobile --}}
                <div class="lg:hidden w-full mt-4">
                    @if($formation->image_url)
                    <div class="relative aspect-video rounded-2xl overflow-hidden mb-6 border border-white/10 shadow-2xl">
                        <img src="{{ $formation->image_url }}" alt="{{ $formation->nom }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center backdrop-blur-[2px]">
                            <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white cursor-pointer hover:bg-[#FF6B00] transition-colors">
                                <i class="fas fa-play text-xl ml-1"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6">
                        <div class="flex items-baseline gap-3 mb-6">
                            <span class="text-4xl font-['Playfair_Display'] font-bold text-white">
                                @if($formation->prix == 0) GRATUIT
                                @else {{ number_format($formation->prix, 0, ',', ' ') }} <span class="text-xl font-['DM_Sans'] text-[#A3A3A3]">FCFA</span>
                                @endif
                            </span>
                            @if($formation->prix_barre && $formation->prix_barre > $formation->prix)
                            <span class="text-lg font-['DM_Sans'] text-white/40 line-through">
                                {{ number_format($formation->prix_barre, 0, ',', ' ') }}
                            </span>
                            @endif
                        </div>
                        
                        <a href="{{ $formation->lien_achat ?? route('contact') }}" target="{{ $formation->lien_achat ? '_blank' : '_self' }}" 
                           class="flex justify-center items-center w-full bg-[#FF6B00] text-white font-['DM_Sans'] text-xs font-bold tracking-widest uppercase py-4 rounded-xl hover:bg-[#ff8533] transition-colors shadow-lg shadow-[#FF6B00]/20">
                            {{ $formation->lien_achat ? "Accéder à la formation" : "Demander l'accès" }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CORPS DE LA PAGE --}}
    <section class="bg-[#050505] py-20 lg:py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 relative items-start">

                {{-- Contenu Principal (Gauche) --}}
                <div class="lg:w-7/12 xl:w-2/3 space-y-16">
                    
                    {{-- Description Complète (Prose) dynamique --}}
                    @if($formation->contenu)
                    <div>
                        <h2 class="font-['Playfair_Display'] text-3xl font-bold text-white mb-8 border-b border-white/5 pb-4">Détails de la formation</h2>
                        <div class="font-['DM_Sans'] text-[#A3A3A3] text-base leading-relaxed space-y-6 prose prose-invert prose-lg max-w-none 
                                    prose-headings:font-['Playfair_Display'] prose-headings:text-white prose-headings:font-bold
                                    prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-4
                                    prose-p:mb-6 prose-strong:text-white
                                    prose-ul:text-[#A3A3A3] prose-li:marker:text-[#FF6B00]
                                    prose-a:text-[#FF6B00] prose-a:no-underline hover:prose-a:underline">
                            {sed -i 's/$formation->image/$formation->image_url/g' resources/views/formations/index.blade.php $formation->contenu !!}
                        </div>
                    </div>
                    @endif

                    {{-- Section Formateur --}}
                    <div>
                        <h2 class="font-['Playfair_Display'] text-3xl font-bold text-white mb-8 border-b border-white/5 pb-4">Ton mentor</h2>
                        <div class="bg-[#111111] border border-white/5 p-8 lg:p-10 rounded-3xl flex flex-col md:flex-row gap-8 items-center md:items-start group hover:border-[#FF6B00]/20 transition-colors duration-500">
                            <div class="w-32 h-32 rounded-full border border-white/10 shrink-0 flex items-center justify-center overflow-hidden relative">
                                <div class="absolute inset-0 bg-[#FF6B00]/20 mix-blend-overlay opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400" alt="Coach Didi" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="font-['Playfair_Display'] text-2xl font-bold text-white mb-2">Cadnel DOSSOU <span class="text-[#FF6B00] text-lg font-normal italic">(Coach Didi)</span></h3>
                                <p class="text-[10px] font-bold tracking-widest uppercase text-white/50 mb-5">Expert en Stratégie de Carrière</p>
                                
                                <div class="flex flex-wrap gap-4 mb-5 text-[10px] font-bold tracking-widest uppercase text-white font-['DM_Sans']">
                                    <div class="flex items-center gap-2 bg-[#050505] px-3 py-1.5 rounded-lg border border-white/5"><i class="fas fa-star text-[#FF6B00]"></i> 4.9/5</div>
                                    <div class="flex items-center gap-2 bg-[#050505] px-3 py-1.5 rounded-lg border border-white/5"><i class="fas fa-user-graduate text-[#FF6B00]"></i> 4.3k+ Accompagnés</div>
                                </div>
                                <p class="text-[#A3A3A3] font-['DM_Sans'] text-sm leading-relaxed">
                                    Ancien recruteur en cabinet international, j'ai analysé des milliers de candidatures. Je connais exactement les failles qui vous disqualifient et les leviers psychologiques qui forcent le "Oui". Je mets cette expertise à votre disposition sans filtre.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- TICKETS FLOTTANTS DESKTOP (STICKY RIGHT) --}}
                <div class="hidden lg:block lg:w-5/12 xl:w-1/3">
                    <div class="sticky top-28 bg-[#111111]/90 backdrop-blur-2xl border border-white/10 rounded-3xl shadow-[0_20px_40px_rgba(0,0,0,0.8)] overflow-hidden -mt-64 z-20 transition-transform duration-500 hover:-translate-y-2">
                        
                        {{-- Image / Vidéo Preview --}}
                        @if($formation->image_url)
                        <div class="relative aspect-video bg-[#050505] cursor-pointer group overflow-hidden">
                            <img src="{{ $formation->image_url }}" alt="{{ $formation->nom }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-all duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-black/40 backdrop-blur-md flex items-center justify-center text-white border border-white/20 group-hover:bg-[#FF6B00] group-hover:border-[#FF6B00] transition-all duration-500 shadow-[0_0_20px_rgba(0,0,0,0.5)] group-hover:shadow-[0_0_30px_rgba(255,107,0,0.4)]">
                                    <i class="fas fa-play text-xl ml-1"></i>
                                </div>
                            </div>
                            <div class="absolute bottom-4 left-0 right-0 text-center font-['DM_Sans'] font-bold tracking-widest text-white text-[10px] uppercase">
                                Couverture de la formation
                            </div>
                        </div>
                        @else
                        <div class="aspect-video bg-[#050505] flex items-center justify-center border-b border-white/5">
                            <div class="w-20 h-20 rounded-full bg-[#111111] border border-white/10 flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-3xl text-[#FF6B00]/50"></i>
                            </div>
                        </div>
                        @endif

                        <div class="p-8">
                            {{-- Prix --}}
                            <div class="flex flex-col mb-8 pb-6 border-b border-white/5">
                                <div class="flex items-baseline gap-3">
                                    <span class="text-5xl font-['Playfair_Display'] font-bold text-white tracking-tight">
                                        @if($formation->prix == 0) GRATUIT
                                        @else {{ number_format($formation->prix, 0, ',', ' ') }} <span class="text-xl font-['DM_Sans'] text-[#A3A3A3] font-normal">FCFA</span>
                                        @endif
                                    </span>
                                </div>
                                @if($formation->prix_barre && $formation->prix_barre > $formation->prix)
                                <div class="mt-2 text-[#A3A3A3] font-['DM_Sans'] text-sm">
                                    Valeur réelle : <span class="line-through decoration-red-500/50 decoration-2">{{ number_format($formation->prix_barre, 0, ',', ' ') }} FCFA</span>
                                </div>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="space-y-4 mb-8">
                                <a href="{{ $formation->lien_achat ?? route('contact') }}" target="{{ $formation->lien_achat ? '_blank' : '_self' }}" 
                                   class="flex items-center justify-center w-full bg-[#FF6B00] text-white font-['DM_Sans'] font-bold text-xs tracking-widest uppercase py-5 rounded-xl hover:bg-[#ff8533] hover:shadow-[0_0_25px_rgba(255,107,0,0.35)] transition-all duration-300 group">
                                    <span>{{ $formation->lien_achat ? "Accéder à la formation" : "Demander l'accès" }}</span>
                                    @if($formation->lien_achat)
                                    <i class="fas fa-arrow-right ml-3 opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all"></i>
                                    @endif
                                </a>
                            </div>

                            <div class="flex items-center justify-center gap-2 mb-8">
                                <i class="fas fa-shield-alt text-[#FF6B00]"></i>
                                <span class="text-center text-[10px] font-bold uppercase tracking-widest text-[#A3A3A3]">Paiement 100% sécurisé</span>
                            </div>

                            {{-- Inclus --}}
                            <div class="bg-[#050505] rounded-2xl p-6 border border-white/5">
                                <h4 class="text-white font-['DM_Sans'] font-bold mb-5 text-sm">Le pack inclut :</h4>
                                <ul class="space-y-4 text-xs font-['DM_Sans'] text-[#A3A3A3]">
                                    <li class="flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-white"><i class="fas fa-clock text-[10px]"></i></div> {{ $formation->duree ?? 'Accès 24/7' }}</li>
                                    <li class="flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-white"><i class="fas fa-file-pdf text-[10px]"></i></div> Ressources téléchargeables</li>
                                    <li class="flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-white"><i class="fas fa-infinity text-[10px]"></i></div> Accès illimité sans limite de temps</li>
                                    <li class="flex items-center gap-3"><div class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center text-white"><i class="fas fa-award text-[10px]"></i></div> Mise à jour gratuite</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-layouts.app>
