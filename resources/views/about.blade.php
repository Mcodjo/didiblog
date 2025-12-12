<x-layouts.app title="À Propos">
    <section class="bg-gradient-to-r from-orange-600 to-blue-600 text-white py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6"><i class="fas fa-user mr-3"></i>À Propos de Coach Didi</h1>
            <p class="text-xl max-w-3xl mx-auto">Découvre mon parcours et ma mission pour t'aider à décrocher ton emploi de rêve.</p>
        </div>
    </section>

    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Coach Didi" class="w-full h-96 object-cover rounded-2xl shadow-xl">
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Bonjour, je suis Cadnel DOSSOU</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                        Plus connu sous le nom de <strong class="text-orange-600">Coach Didi</strong>, je suis passionné par l'accompagnement des jeunes dans leur recherche d'emploi.
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                        Depuis plus de 8 ans, j'aide les étudiants et jeunes diplômés à décrocher leur premier emploi ou à réorienter leur carrière. Ma méthode ? Un accompagnement personnalisé, des conseils pratiques et une énergie positive !
                    </p>
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="text-center bg-orange-50 dark:bg-gray-800 p-6 rounded-xl">
                            <div class="text-3xl font-bold text-orange-600">4 300+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Personnes accompagnées</div>
                        </div>
                        <div class="text-center bg-green-50 dark:bg-gray-800 p-6 rounded-xl">
                            <div class="text-3xl font-bold text-green-600">85%</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Taux de réussite</div>
                        </div>
                        <div class="text-center bg-blue-50 dark:bg-gray-800 p-6 rounded-xl">
                            <div class="text-3xl font-bold text-blue-600">8+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Années d'expérience</div>
                        </div>
                        <div class="text-center bg-purple-50 dark:bg-gray-800 p-6 rounded-xl">
                            <div class="text-3xl font-bold text-purple-600">5</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Formations disponibles</div>
                        </div>
                    </div>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                        <i class="fas fa-envelope mr-2"></i>Me contacter
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
