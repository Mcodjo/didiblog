<x-layouts.app title="Contact — Emploi Connect">
    {{-- PAGE HEADER --}}
    <section class="relative bg-[#0A0A0A] pt-32 lg:pt-48 pb-16 lg:pb-24 overflow-hidden border-b border-white/5">
        {{-- Glow subtil --}}
        <div class="absolute top-0 right-1/4 w-[500px] h-[500px] bg-[#FF6B00]/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-[#111111] border border-white/10 text-[#FF6B00] text-xs font-['DM_Sans'] font-bold tracking-widest uppercase mb-6">
                Le premier pas
            </span>
            <h1 class="font-['Playfair_Display'] text-5xl lg:text-7xl font-bold text-white mb-6 tracking-tight">
                Parlons de ton <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF6B00] to-[#ff984d] italic">projet</span>
            </h1>
            <p class="max-w-2xl mx-auto text-lg text-[#A3A3A3] font-['DM_Sans']">
                Que ce soit pour une demande de coaching explosif, une intervention en entreprise ou simplement briser la glace. Je réponds à tout (sauf au blabla).
            </p>
        </div>
    </section>

    {{-- FORMULAIRE + INFOS --}}
    <section class="bg-[#050505] py-20 lg:py-32 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col lg:flex-row gap-12 lg:gap-24">

                {{-- Colonne Infos (Gauche) --}}
                <div class="lg:w-2/5 flex flex-col gap-8">
                    
                    {{-- Carte Info principale --}}
                    <div class="bg-[#111111]/80 backdrop-blur-xl border border-white/5 rounded-3xl p-8 lg:p-10 group hover:border-[#FF6B00]/20 transition-all duration-500 relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-[#FF6B00]/5 rounded-full blur-[40px] group-hover:bg-[#FF6B00]/10 transition-colors"></div>
                        
                        <h2 class="font-['Playfair_Display'] text-2xl font-bold text-white mb-10 relative z-10">
                            Mes coordonnées
                        </h2>
                        
                        <div class="flex flex-col gap-8 relative z-10">
                            <div class="flex items-start gap-5">
                                <div class="w-12 h-12 rounded-xl bg-[#050505] border border-white/5 flex items-center justify-center flex-shrink-0 text-[#FF6B00] group-hover:-translate-y-1 transition-transform duration-500 shadow-inner">
                                    <i class="fas fa-envelope text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-['DM_Sans'] text-[10px] font-bold tracking-widest uppercase text-white/50 mb-1">E-mail pro</p>
                                    <a href="mailto:contact@emploiconnect.fr" class="font-['DM_Sans'] text-white hover:text-[#FF6B00] transition-colors text-lg">
                                        contact@emploiconnect.fr
                                    </a>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-5">
                                <div class="w-12 h-12 rounded-xl bg-[#050505] border border-white/5 flex items-center justify-center flex-shrink-0 text-[#FF6B00] group-hover:-translate-y-1 transition-transform duration-500 shadow-inner">
                                    <i class="fab fa-linkedin-in text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-['DM_Sans'] text-[10px] font-bold tracking-widest uppercase text-white/50 mb-1">Réseau pro</p>
                                    <a href="#" class="font-['DM_Sans'] text-white hover:text-[#FF6B00] transition-colors text-lg">
                                        Cadnel DOSSOU (Coach Didi)
                                    </a>
                                    <p class="font-['DM_Sans'] text-sm text-[#A3A3A3] mt-1">+ de 10k abonnés actifs</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FAQ rapide --}}
                    <div class="bg-transparent border border-white/5 rounded-3xl p-8 lg:p-10">
                        <h3 class="font-['DM_Sans'] text-[10px] font-bold tracking-widest uppercase text-[#FF6B00] mb-8 flex items-center gap-3">
                            <span class="w-8 h-[1px] bg-[#FF6B00]"></span>
                            Questions Fréquentes
                        </h3>
                        <div class="flex flex-col gap-8">
                            <div>
                                <p class="font-['DM_Sans'] text-white font-bold mb-2">Quel est le délai de réponse ?</p>
                                <p class="font-['DM_Sans'] text-sm text-[#A3A3A3] leading-relaxed">Je traite personnellement mes emails. Prévoyez un délai de 48h à 72h ouvrées max.</p>
                            </div>
                            <div>
                                <p class="font-['DM_Sans'] text-white font-bold mb-2">Proposez-vous du mentoring 1-to-1 ?</p>
                                <p class="font-['DM_Sans'] text-sm text-[#A3A3A3] leading-relaxed">Oui, l'accompagnement premium est ouvert sous sélection. Utilisez le type "Demande de coaching" ci-contre.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Formulaire (Droite) --}}
                <div class="lg:w-3/5">
                    <div class="bg-[#111111] border border-white/5 p-8 lg:p-12 rounded-3xl relative overflow-hidden shadow-2xl">
                        {{-- Ornement design --}}
                        <div class="absolute top-0 right-0 w-full h-1 bg-gradient-to-r from-[#050505] via-[#FF6B00] to-[#050505] opacity-50"></div>

                        <div class="mb-10">
                            <h2 class="font-['Playfair_Display'] text-3xl font-bold text-white mb-3">Laisse-moi ton message</h2>
                            <p class="font-['DM_Sans'] text-[#A3A3A3]">Même au format court, sois percutant, va droit au but.</p>
                        </div>

                        @if(session('success'))
                        <div class="bg-[#050505] border border-green-500/30 text-green-400 font-['DM_Sans'] text-sm p-6 mb-8 rounded-xl flex items-center gap-4">
                            <i class="fas fa-check-circle text-2xl"></i>
                            <div>
                                <p class="font-bold text-white">Message envoyé !</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="flex flex-col gap-6 font-['DM_Sans']">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                {{-- Nom --}}
                                <div class="group">
                                    <label for="nom" class="block text-[10px] font-bold tracking-widest uppercase text-white/50 mb-3 ml-1 group-focus-within:text-[#FF6B00] transition-colors">
                                        Prénom & Nom *
                                    </label>
                                    <input type="text" name="nom" id="nom" required value="{{ old('nom') }}"
                                           placeholder="Ex: John Doe"
                                           class="w-full px-5 py-4 text-white bg-[#050505] border border-white/5 rounded-xl focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] transition-all placeholder-white/20 @error('nom') border-red-500 @enderror">
                                    @error('nom')<p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>@enderror
                                </div>

                                {{-- Email --}}
                                <div class="group">
                                    <label for="email" class="block text-[10px] font-bold tracking-widest uppercase text-white/50 mb-3 ml-1 group-focus-within:text-[#FF6B00] transition-colors">
                                        E-mail Pro ou Perso *
                                    </label>
                                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                           placeholder="ton@email.com"
                                           class="w-full px-5 py-4 text-white bg-[#050505] border border-white/5 rounded-xl focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] transition-all placeholder-white/20 @error('email') border-red-500 @enderror">
                                    @error('email')<p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- Type de demande --}}
                            <div class="group">
                                <label for="type" class="block text-[10px] font-bold tracking-widest uppercase text-white/50 mb-3 ml-1 group-focus-within:text-[#FF6B00] transition-colors">
                                    Nature de la requête *
                                </label>
                                <div class="relative">
                                    <select name="type" id="type" required
                                            class="w-full px-5 py-4 text-white bg-[#050505] border border-white/5 rounded-xl focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] transition-all appearance-none cursor-pointer">
                                        <option value="" class="bg-[#111] text-white/50">-- Sélectionner une option --</option>
                                        <option value="coaching" class="bg-[#111] text-white" {{ old('type') === 'coaching' ? 'selected' : '' }}>🌟 Demande de coaching privé</option>
                                        <option value="formation" class="bg-[#111] text-white" {{ old('type') === 'formation' ? 'selected' : '' }}>📚 Question sur un programme / formation</option>
                                        <option value="partenariat" class="bg-[#111] text-white" {{ old('type') === 'partenariat' ? 'selected' : '' }}>🤝 Proposition de partenariat / B2B</option>
                                        <option value="general" class="bg-[#111] text-white" {{ old('type') === 'general' ? 'selected' : '' }}>💬 Question générale</option>
                                        <option value="autre" class="bg-[#111] text-white" {{ old('type') === 'autre' ? 'selected' : '' }}>⚡ Autre chose</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-5 pointer-events-none text-white/40">
                                        <i class="fas fa-chevron-down text-sm"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Sujet --}}
                            <div class="group">
                                <label for="sujet" class="block text-[10px] font-bold tracking-widest uppercase text-white/50 mb-3 ml-1 group-focus-within:text-[#FF6B00] transition-colors">
                                    Sujet *
                                </label>
                                <input type="text" name="sujet" id="sujet" required value="{{ old('sujet') }}"
                                       placeholder="En quelques mots"
                                       class="w-full px-5 py-4 text-white bg-[#050505] border border-white/5 rounded-xl focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] transition-all placeholder-white/20 @error('sujet') border-red-500 @enderror">
                                @error('sujet')<p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Message --}}
                            <div class="group">
                                <label for="message" class="block text-[10px] font-bold tracking-widest uppercase text-white/50 mb-3 ml-1 group-focus-within:text-[#FF6B00] transition-colors">
                                    Ton Message *
                                </label>
                                <textarea name="message" id="message" rows="5" required
                                          placeholder="Explique ta situation, tes objectifs et ce que tu attends de moi..."
                                          class="w-full px-5 py-4 text-white bg-[#050505] border border-white/5 rounded-xl focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] transition-all placeholder-white/20 resize-y @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                                @error('message')<p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Bouton Submit --}}
                            <button type="submit"
                                    class="w-full bg-[#FF6B00] text-white text-xs font-bold tracking-widest uppercase py-5 rounded-xl hover:bg-[#ff8533] transition-all duration-300 shadow-lg shadow-[#FF6B00]/20 hover:shadow-[#FF6B00]/40 mt-4 group flex justify-center items-center gap-3">
                                <span>Envoyer le message</span>
                                <i class="fas fa-paper-plane group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                            </button>
                            <p class="text-center text-[10px] text-white/20 tracking-widest uppercase font-['DM_Sans'] mt-2">
                                Tes données sont strictement confidentielles
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
