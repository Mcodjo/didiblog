<x-layouts.app title="Connexion — Emploi Connect">
    <section class="relative min-h-screen flex items-center justify-center bg-[#0A0A0A] py-32 px-6 overflow-hidden">
        {{-- Glow subtil d'arrière-plan --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#FF6B00]/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="w-full max-w-md relative z-10">
            {{-- En-tête du formulaire --}}
            <div class="text-center mb-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1 mb-6 group">
                    <span class="font-['Playfair_Display'] text-4xl font-bold text-white tracking-tight group-hover:opacity-80 transition-opacity">Emploi</span>
                    <span class="font-['Playfair_Display'] text-4xl font-bold text-[#FF6B00] tracking-tight group-hover:opacity-80 transition-opacity">Connect</span>
                </a>
                <h1 class="font-['Playfair_Display'] text-3xl font-bold text-white mb-3 tracking-tight">Bon retour parmi nous</h1>
                <p class="font-['DM_Sans'] text-sm text-[#A3A3A3]">Entre tes identifiants pour accéder à ton espace élite.</p>
            </div>

            {{-- Carte Formulaire --}}
            <div class="bg-[#111111]/80 backdrop-blur-xl border border-white/5 rounded-3xl p-8 lg:p-10 shadow-2xl relative overflow-hidden">
                {{-- Ornement haut --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#FF6B00] to-transparent opacity-50"></div>

                <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-6 font-['DM_Sans']">
                    @csrf

                    {{-- Email --}}
                    <div class="group">
                        <label for="email" class="block text-[10px] font-bold tracking-widest uppercase text-white/50 mb-3 ml-1 group-focus-within:text-[#FF6B00] transition-colors">
                            Adresse Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-white/30 group-focus-within:text-[#FF6B00] transition-colors"></i>
                            </div>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                   placeholder="ton@email.com"
                                   class="w-full pl-12 pr-5 py-4 text-white bg-[#050505] border border-white/5 rounded-xl focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] transition-all placeholder-white/20 @error('email') border-red-500/50 focus:border-red-500 focus:ring-red-500 @enderror">
                        </div>
                        @error('email')<p class="text-xs text-red-400 mt-2 ml-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Mot de passe --}}
                    <div class="group">
                        <div class="flex items-center justify-between mb-3 ml-1">
                            <label for="password" class="block text-[10px] font-bold tracking-widest uppercase text-white/50 group-focus-within:text-[#FF6B00] transition-colors">
                                Mot de passe
                            </label>
                             @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[10px] font-bold tracking-widest uppercase text-white/30 hover:text-[#FF6B00] transition-colors">
                                    Oublié ?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-white/30 group-focus-within:text-[#FF6B00] transition-colors"></i>
                            </div>
                            <input type="password" name="password" id="password" required
                                   placeholder="••••••••"
                                   class="w-full pl-12 pr-5 py-4 text-white bg-[#050505] border border-white/5 rounded-xl focus:outline-none focus:border-[#FF6B00] focus:ring-1 focus:ring-[#FF6B00] transition-all placeholder-white/20 @error('password') border-red-500/50 focus:border-red-500 focus:ring-red-500 @enderror">
                        </div>
                        @error('password')<p class="text-xs text-red-400 mt-2 ml-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Se souvenir de moi --}}
                    <div class="flex items-center ml-1">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-white/10 bg-[#050505] text-[#FF6B00] focus:ring-[#FF6B00] focus:ring-offset-0 focus:ring-offset-[#111111]">
                        <label for="remember" class="ml-3 text-xs text-[#A3A3A3] cursor-pointer hover:text-white transition-colors">
                            Garder ma session active
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full bg-[#FF6B00] text-white text-xs font-bold tracking-widest uppercase py-4 rounded-xl hover:bg-[#ff8533] transition-all duration-300 shadow-lg shadow-[#FF6B00]/20 hover:shadow-[#FF6B00]/40 mt-2 group flex justify-center items-center gap-3">
                        <i class="fas fa-sign-in-alt group-hover:-translate-x-1 transition-transform"></i>
                        <span>Se connecter</span>
                    </button>
                </form>

                {{-- Suppression du lien d'inscription public (blog géré par admin uniquement) --}}
            </div>
        </div>
    </section>
</x-layouts.app>
