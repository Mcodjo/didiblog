<x-layouts.app title="Inscription">
    <section class="py-16 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-8">Créer un compte</h1>
                    
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Nom</label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 @error('name') border-red-500 @enderror">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label for="prenom" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Prénom</label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500">
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Email</label>
                            <input type="email" name="email" id="email" required value="{{ old('email') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 @error('email') border-red-500 @enderror">
                            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Mot de passe</label>
                            <input type="password" name="password" id="password" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 @error('password') border-red-500 @enderror">
                            @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500">
                        </div>

                        <button type="submit" class="w-full px-6 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>Créer mon compte
                        </button>
                    </form>

                    <p class="text-center mt-6 text-gray-600 dark:text-gray-400">
                        Déjà un compte ? <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-semibold">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
