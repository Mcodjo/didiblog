<x-layouts.app title="À propos — Emploi Connect">
    {{-- HERO SECTION : Premium Dark Mode --}}
    <section class="relative bg-[#0A0A0A] pt-32 lg:pt-48 pb-16 lg:pb-32 overflow-hidden border-b border-white/5">
        {{-- Glow subtil --}}
        <div class="absolute top-1/2 left-0 -translate-y-1/2 w-[500px] h-[500px] bg-[#FF6B00]/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-20 items-center">
                
                {{-- Contenu Hero Gauche --}}
                <div class="lg:w-1/2 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 mb-8 mx-auto lg:mx-0">
                        <span class="w-2 h-2 rounded-full bg-[#FF6B00] animate-pulse"></span>
                        <span class="text-xs font-['DM_Sans'] text-white/70 font-bold tracking-widest uppercase">Expert en Employabilité</span>
                    </div>

                    <h1 class="font-['Playfair_Display'] text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight mb-6">
                        {{ \App\Models\SiteSetting::get('about_title', 'Bonjour, je suis Cadnel DOSSOU') }}
                    </h1>
                    
                    <p class="font-['DM_Sans'] text-lg lg:text-xl text-[#A3A3A3] mb-10 leading-relaxed font-light">
                        {{ \App\Models\SiteSetting::get('about_description', 'Ancien recruteur en cabinet international, j\'ai analysé des milliers de candidatures. Je connais exactement les failles qui vous disqualifient et les leviers psychologiques qui forcent le "Oui". Je mets cette expertise à votre disposition sans filtre.') }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('formations.index') }}" 
                           class="bg-[#FF6B00] text-white font-['DM_Sans'] text-xs font-bold tracking-widest uppercase px-8 py-4 rounded-xl hover:bg-[#ff8533] transition-all transform hover:-translate-y-1 hover:shadow-[0_0_20px_rgba(255,107,0,0.3)] flex items-center justify-center gap-3">
                            Voir mes formations <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="{{ route('contact') }}" 
                           class="bg-[#111111] text-white font-['DM_Sans'] text-xs font-bold tracking-widest uppercase px-8 py-4 rounded-xl border border-white/10 hover:bg-white/5 hover:border-white/20 transition-all flex items-center justify-center gap-3">
                            Me contacter
                        </a>
                    </div>
                </div>

                {{-- Image Hero Droite (Cadnel) --}}
                <div class="lg:w-1/2 relative">
                    <div class="relative w-full max-w-lg mx-auto aspect-[4/5] rounded-3xl overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A0A0A] via-transparent to-transparent z-10"></div>
                        <img src="{{ \App\Models\SiteSetting::get('about_image', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=800') }}" 
                             alt="Cadnel DOSSOU" 
                             class="w-full h-full object-cover grayscale-[0.2] transition-transform duration-700 group-hover:scale-105">
                        
                        {{-- Floating Badge --}}
                        <div class="absolute bottom-8 left-8 right-8 z-20 bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-[#FF6B00] flex items-center justify-center text-white shrink-0">
                                    <i class="fas fa-quote-left text-xl"></i>
                                </div>
                                <p class="text-sm font-['DM_Sans'] text-white italic font-light">
                                    "Mon objectif : transformer votre potentiel en opportunités réelles."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- SECTION STATISTIQUES --}}
    <section class="bg-[#050505] py-20 border-b border-white/5 relative z-20 -mt-10 lg:-mt-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                
                {{-- Stat 1 --}}
                <div class="bg-[#111111] border border-white/5 rounded-2xl p-8 text-center hover:border-[#FF6B00]/30 transition-colors group">
                    <div class="text-4xl lg:text-5xl font-['Playfair_Display'] font-bold text-white mb-2 group-hover:scale-110 transition-transform">
                        {{ \App\Models\SiteSetting::get('about_stat1_value', '4.3k+') }}
                    </div>
                    <div class="text-[10px] font-['DM_Sans'] text-[#A3A3A3] font-bold tracking-widest uppercase">
                        {{ \App\Models\SiteSetting::get('about_stat1_label', 'Professionnels Accompagnés') }}
                    </div>
                </div>

                {{-- Stat 2 --}}
                <div class="bg-[#111111] border border-white/5 rounded-2xl p-8 text-center hover:border-[#FF6B00]/30 transition-colors group">
                    <div class="text-4xl lg:text-5xl font-['Playfair_Display'] font-bold text-white mb-2 group-hover:scale-110 transition-transform">
                        {{ \App\Models\SiteSetting::get('about_stat2_value', '85%') }}
                    </div>
                    <div class="text-[10px] font-['DM_Sans'] text-[#A3A3A3] font-bold tracking-widest uppercase">
                        {{ \App\Models\SiteSetting::get('about_stat2_label', 'Taux de Réussite') }}
                    </div>
                </div>

                {{-- Stat 3 --}}
                <div class="bg-[#111111] border border-white/5 rounded-2xl p-8 text-center hover:border-[#FF6B00]/30 transition-colors group">
                    <div class="text-4xl lg:text-5xl font-['Playfair_Display'] font-bold text-white mb-2 group-hover:scale-110 transition-transform">
                        {{ \App\Models\SiteSetting::get('about_stat3_value', '8+') }}
                    </div>
                    <div class="text-[10px] font-['DM_Sans'] text-[#A3A3A3] font-bold tracking-widest uppercase">
                        {{ \App\Models\SiteSetting::get('about_stat3_label', "Années d'Expertise") }}
                    </div>
                </div>

                {{-- Stat 4 --}}
                <div class="bg-[#111111] border border-white/5 rounded-2xl p-8 text-center hover:border-[#FF6B00]/30 transition-colors group">
                    <div class="text-4xl lg:text-5xl font-['Playfair_Display'] font-bold text-white mb-2 group-hover:scale-110 transition-transform">
                        {{ \App\Models\SiteSetting::get('about_stat4_value', '5') }}
                    </div>
                    <div class="text-[10px] font-['DM_Sans'] text-[#A3A3A3] font-bold tracking-widest uppercase">
                        {{ \App\Models\SiteSetting::get('about_stat4_label', 'Formations Exclusives') }}
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- SECTION NOTRE APPROCHE (Timeline) --}}
    <section class="bg-[#0A0A0A] py-24 lg:py-32 relative">
        <div class="max-w-3xl mx-auto px-6 text-center mb-20">
            <h2 class="font-['Playfair_Display'] text-3xl lg:text-5xl font-bold text-white mb-6">
                {{ \App\Models\SiteSetting::get('qui_suis_je_title', 'Une Méthode Éprouvée') }}
            </h2>
            <p class="font-['DM_Sans'] text-[#A3A3A3] text-lg">
                {{ \App\Models\SiteSetting::get('qui_suis_je_description1', 'Je ne crois pas aux formules magiques. Je crois aux stratégies structurées, au positionnement clair et à la compréhension profonde des attentes du marché.') }}
            </p>
        </div>

        <div class="max-w-4xl mx-auto px-6">
            <div class="space-y-12 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-white/10 before:to-transparent">
                
                {{-- Étape 1 --}}
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white/20 bg-[#111111] text-white/50 group-hover:text-[#FF6B00] group-hover:border-[#FF6B00] group-hover:shadow-[0_0_15px_rgba(255,107,0,0.5)] transition-all shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-search text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] bg-[#111111] border border-white/5 p-6 rounded-2xl group-hover:border-white/20 transition-colors">
                        <h3 class="font-['Playfair_Display'] text-xl font-bold text-white mb-2">1. Audit & Diagnostic</h3>
                        <p class="font-['DM_Sans'] text-[#A3A3A3] text-sm leading-relaxed">Analyse chirurgicale de votre parcours, de votre CV et de votre discours pour identifier les blocages qui vous empêchent d'avancer.</p>
                    </div>
                </div>

                {{-- Étape 2 --}}
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white/20 bg-[#111111] text-white/50 group-hover:text-[#FF6B00] group-hover:border-[#FF6B00] group-hover:shadow-[0_0_15px_rgba(255,107,0,0.5)] transition-all shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-pen-nib text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] bg-[#111111] border border-white/5 p-6 rounded-2xl group-hover:border-white/20 transition-colors">
                        <h3 class="font-['Playfair_Display'] text-xl font-bold text-white mb-2">2. Repositionnement</h3>
                        <p class="font-['DM_Sans'] text-[#A3A3A3] text-sm leading-relaxed">Refonte de vos outils (CV, LinkedIn) pour passer d'un simple "chercheur d'emploi" à une "solution évidente" pour le recruteur.</p>
                    </div>
                </div>

                {{-- Étape 3 --}}
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white/20 bg-[#111111] text-white/50 group-hover:text-[#FF6B00] group-hover:border-[#FF6B00] group-hover:shadow-[0_0_15px_rgba(255,107,0,0.5)] transition-all shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                        <i class="fas fa-comments text-xs"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] bg-[#111111] border border-white/5 p-6 rounded-2xl group-hover:border-white/20 transition-colors">
                        <h3 class="font-['Playfair_Display'] text-xl font-bold text-white mb-2">3. Maîtrise de l'Entretien</h3>
                        <p class="font-['DM_Sans'] text-[#A3A3A3] text-sm leading-relaxed">Entraînement intensif pour déjouer les questions pièges, maîtriser le storytelling et négocier votre salaire avec assurance.</p>
                    </div>
                </div>

            </div>
            
            <div class="text-center mt-16 font-['DM_Sans'] text-[#A3A3A3] text-sm max-w-2xl mx-auto">
                {{ \App\Models\SiteSetting::get('qui_suis_je_description2', 'Mon approche est directe et orientée résultat. Aucun blabla, uniquement des stratégies appliquées par les meilleurs candidats du marché.') }}
            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <section class="bg-[#FF6B00] py-16 lg:py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 mix-blend-overlay"></div>
        <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
            <h2 class="font-['Playfair_Display'] text-3xl lg:text-5xl font-bold text-white mb-6">
                Prêt à accélérer ta carrière ?
            </h2>
            <p class="font-['DM_Sans'] text-white/80 text-lg mb-10 max-w-2xl mx-auto">
                Ne laisse plus ta carrière au hasard. Découvre mes programmes d'accompagnement et rejoins le cercle des candidats qui choisissent leur employeur.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('formations.index') }}" 
                   class="bg-white text-[#FF6B00] font-['DM_Sans'] text-xs font-bold tracking-widest uppercase px-8 py-4 rounded-xl hover:bg-[#111111] hover:text-white transition-all shadow-xl">
                    Découvrir les formations
                </a>
            </div>
        </div>
    </section>

</x-layouts.app>
