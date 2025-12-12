<x-layouts.app title="Contact">
    <section class="bg-gradient-to-r from-orange-600 to-blue-600 text-white py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6"><i class="fas fa-envelope mr-3"></i>Contactez-moi</h1>
            <p class="text-xl max-w-3xl mx-auto">Une question ? Un projet ? N'hésite pas à me contacter !</p>
        </div>
    </section>

    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto">
                <form action="{{ route('contact.store') }}" method="POST" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                    @csrf
                    <div class="mb-6">
                        <label for="nom" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Nom complet</label>
                        <input type="text" name="nom" id="nom" required value="{{ old('nom') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('nom') border-red-500 @enderror">
                        @error('nom')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Email</label>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-6">
                        <label for="type" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Type de demande</label>
                        <select name="type" id="type" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            <option value="general">Question générale</option>
                            <option value="coaching">Demande de coaching</option>
                            <option value="formation">Question sur une formation</option>
                            <option value="partenariat">Proposition de partenariat</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label for="sujet" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Sujet</label>
                        <input type="text" name="sujet" id="sujet" required value="{{ old('sujet') }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('sujet') border-red-500 @enderror">
                        @error('sujet')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-6">
                        <label for="message" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Message</label>
                        <textarea name="message" id="message" rows="6" required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="w-full px-6 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer le message
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
