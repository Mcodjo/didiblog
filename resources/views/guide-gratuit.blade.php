<x-layouts.app title="Guide Gratuit — Emploi Connect">
    {{-- HERO PLEIN ÉCRAN --}}
    <section class="bg-[#0A0A0A] min-h-[70vh] flex items-center pt-24 pb-20">
        <div class="max-w-7xl mx-auto px-6 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                {{-- Texte --}}
                <div>
                    <p class="text-xs font-['DM_Sans'] font-semibold tracking-widest uppercase text-[#FF6B00] mb-4">
                        GRATUIT · IMMÉDIAT
                    </p>
                    <h1 class="font-['Playfair_Display'] text-4xl lg:text-6xl font-bold text-white leading-tight mb-6">
                        Les 10 secrets pour décrocher un emploi rapidement
                    </h1>
                    <div class="w-12 h-0.5 bg-[#FF6B00] mb-6 rounded-full"></div>
                    <p class="font-['DM_Sans'] text-base text-[#888] leading-relaxed mb-10">
                        CV percutant, entretien maîtrisé, LinkedIn optimisé, networking stratégique, négociation salariale — tout ce qu'il faut pour passer de candidat à recruté.
                    </p>
                    {{-- Bullets --}}
                    <ul class="flex flex-col gap-4 mb-10">
                        @foreach([
                            'Rédiger un CV qui attire l\'attention en 6 secondes',
                            'Les 3 erreurs fatales à éviter en entretien',
                            'Optimiser ton profil LinkedIn pour être trouvé',
                            'Les meilleures stratégies de networking actif',
                            'Comment négocier ton salaire avec confiance'
                        ] as $item)
                        <li class="flex items-start gap-3 font-['DM_Sans'] text-sm text-white">
                            <svg class="w-4 h-4 text-[#FF6B00] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="square" d="M5 13l4 4L19 7"/></svg>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Formulaire --}}
                <div class="bg-white border border-[#2A2A2A] p-8 lg:p-10 rounded-xl">
                    <h2 class="font-['Playfair_Display'] text-2xl font-bold text-[#111] mb-2">
                        Reçois ton guide maintenant
                    </h2>
                    <p class="font-['DM_Sans'] text-sm text-[#888] mb-8">
                        Entrez votre email pour recevoir le guide gratuitement.
                    </p>

                    @if(session('success'))
                    <div class="bg-[#F0FFF4] border border-green-400 text-green-700 font-['DM_Sans'] text-sm p-4 mb-6 rounded-lg">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('newsletter.store') }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        <input type="hidden" name="source" value="guide-gratuit">

                        <div>
                            <label class="block font-['DM_Sans'] text-xs font-semibold tracking-widest uppercase text-[#888] mb-2">
                                Prénom
                            </label>
                            <input type="text" name="prenom" placeholder="Ton prénom" value="{{ old('prenom') }}"
                                   class="w-full px-4 py-3 font-['DM_Sans'] text-sm border border-[#E5E5E5] rounded-lg focus:outline-none focus:border-[#FF6B00] placeholder-[#AAA]">
                        </div>

                        <div>
                            <label class="block font-['DM_Sans'] text-xs font-semibold tracking-widest uppercase text-[#888] mb-2">
                                Email *
                            </label>
                            <input type="email" name="email" placeholder="ton@email.com" required value="{{ old('email') }}"
                                   class="w-full px-4 py-3 font-['DM_Sans'] text-sm border border-[#E5E5E5] rounded-lg focus:outline-none focus:border-[#FF6B00] placeholder-[#AAA] @error('email') border-red-400 @enderror">
                            @error('email')
                            <p class="font-['DM_Sans'] text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full bg-[#FF6B00] text-white font-['DM_Sans'] text-xs font-semibold tracking-widest uppercase py-4 rounded-full hover:bg-[#e55a00] transition-colors mt-2 hover:shadow-lg hover:shadow-[#FF6B00]/25">
                            TÉLÉCHARGER MON GUIDE GRATUIT
                        </button>
                        <p class="font-['DM_Sans'] text-xs text-[#AAA] text-center">
                            En t'inscrivant, tu acceptes de recevoir mes conseils par email. Désinscription possible à tout moment.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- RÉASSURANCE --}}
    <section class="bg-white border-t border-[#E5E5E5] py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div>
                    <p class="font-['Playfair_Display'] text-4xl font-bold text-[#FF6B00] mb-2">100%</p>
                    <p class="font-['DM_Sans'] text-sm text-[#888]">Gratuit, aucune carte requise</p>
                </div>
                <div>
                    <p class="font-['Playfair_Display'] text-4xl font-bold text-[#FF6B00] mb-2">+2 000</p>
                    <p class="font-['DM_Sans'] text-sm text-[#888]">Personnes déjà accompagnées</p>
                </div>
                <div>
                    <p class="font-['Playfair_Display'] text-4xl font-bold text-[#FF6B00] mb-2">Immédiat</p>
                    <p class="font-['DM_Sans'] text-sm text-[#888]">Reçu dans ta boîte mail en 2 minutes</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
