<x-layouts.app title="Guide Gratuit">
    <section class="bg-gradient-to-r from-orange-600 to-blue-600 text-white py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6"><i class="fas fa-download mr-3"></i>Guide Gratuit</h1>
            <p class="text-xl max-w-3xl mx-auto">Télécharge ton guide gratuit pour booster ta recherche d'emploi !</p>
        </div>
    </section>

    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center">
                <div class="bg-gradient-to-br from-orange-100 to-blue-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-8 shadow-xl">
                    <div class="w-24 h-24 bg-orange-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-book text-4xl text-white"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Les 10 secrets pour décrocher un emploi rapidement</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">
                        Ce guide gratuit contient mes meilleurs conseils pour optimiser ton CV, réussir tes entretiens et te démarquer des autres candidats.
                    </p>
                    <ul class="text-left text-gray-700 dark:text-gray-300 mb-8 space-y-3">
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Comment rédiger un CV qui attire l'attention</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Les erreurs à éviter en entretien</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Comment optimiser ton profil LinkedIn</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Les meilleures stratégies de networking</li>
                        <li><i class="fas fa-check text-green-500 mr-2"></i>Comment négocier ton salaire</li>
                    </ul>
                    
                    <form action="{{ route('newsletter.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="source" value="guide-gratuit">
                        <input type="email" name="email" placeholder="Ton adresse email" required class="w-full px-6 py-4 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <button type="submit" class="w-full px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                            <i class="fas fa-download mr-2"></i>Recevoir mon guide gratuit
                        </button>
                    </form>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-4">En t'inscrivant, tu recevras également mes conseils par email.</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
