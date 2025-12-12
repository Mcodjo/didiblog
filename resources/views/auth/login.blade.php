<x-layouts.app title="Connexion">
    <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-8">Connexion</h1>
                    
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('email') border-red-500 @enderror">
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Mot de passe</label>
                            <input type="password" name="password" id="password" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('password') border-red-500 @enderror">
                            @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                <span class="ml-2 text-gray-700 dark:text-gray-300">Se souvenir de moi</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full px-6 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i>Se connecter
                        </button>
                    </form>

                    <p class="text-center mt-6 text-gray-600 dark:text-gray-400">
                        Pas encore de compte ? <a href="{{ route('register') }}" class="text-orange-600 hover:text-orange-700 font-semibold">Créer un compte</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
