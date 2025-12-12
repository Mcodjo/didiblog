<x-layouts.app title="Accueil">
    <section class="relative min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
        <div class="absolute inset-0 gradient-hero"></div>
        <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6">
                <span class="text-orange-300">Bienvenue sur</span><br>
                Emploi Connect
            </h1>
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold mb-6">Le blog pour décrocher un emploi plus vite</h2>
            <p class="text-lg sm:text-xl mb-8 max-w-2xl mx-auto leading-relaxed">
                Tu veux trouver un emploi rapidement, te démarquer avec ton CV ou réussir tes entretiens ? Tu es au bon endroit.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('guide-gratuit') }}" class="inline-flex items-center px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors shadow-lg">
                    <i class="fas fa-download mr-3"></i>Télécharger ton guide gratuit
                </a>
                <a href="{{ route('blog.index') }}" class="inline-flex items-center px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-gray-900 font-semibold rounded-lg transition-colors">
                    Explorer les articles<i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        </div>
    </section>

    @if($statistics->count())
    <section class="py-16 lg:py-20 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($statistics as $stat)
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="{{ $stat->icone }} text-2xl text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <div class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $stat->valeur }}</div>
                    <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">{{ $stat->nom }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $stat->description }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if($formations->count())
    <section class="py-16 lg:py-20 bg-gradient-to-br from-orange-50 to-blue-50 dark:from-gray-800 dark:to-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-graduation-cap text-orange-600 mr-3"></i>Mes Formations en Ligne
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Transforme ta carrière avec mes formations complètes. Méthodes éprouvées, exercices pratiques et suivi personnalisé !
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($formations as $formation)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                    @if($formation->image_url)
                    <img src="{{ $formation->image_url }}" alt="{{ $formation->nom }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        @if($formation->badge)
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold text-white mb-3" style="background-color: {{ $formation->couleur_badge }}">{{ $formation->badge }}</span>
                        @endif
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $formation->nom }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ $formation->description }}</p>
                        <div class="flex items-center justify-between mb-6">
                            <div class="text-2xl font-bold text-orange-600">
                                {{ number_format($formation->prix, 0) }}€
                                @if($formation->prix_barre)
                                <span class="text-sm text-gray-500 line-through ml-2">{{ number_format($formation->prix_barre, 0) }}€</span>
                                @endif
                            </div>
                            <div class="flex items-center space-x-1">
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-sm"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">({{ $formation->note }})</span>
                            </div>
                        </div>
                        <a href="{{ route('formations.show', $formation->slug) }}" class="w-full block text-center bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300">
                            <i class="fas fa-play mr-2"></i>Découvrir la formation
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{ route('formations.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-graduation-cap mr-2"></i>Voir toutes les formations
                </a>
            </div>
        </div>
    </section>
    @endif

    <section class="py-16 lg:py-20 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-orange-600 dark:text-orange-400 font-semibold text-lg">Qui suis-je ?</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">Coach Didi, ton expert en employabilité</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                        Bonjour ! Je suis <strong>Cadnel DOSSOU</strong>, plus connu sous le nom de <strong>Coach Didi</strong>. 
                        Depuis plus de 8 ans, j'accompagne les étudiants et jeunes diplômés dans leur recherche d'emploi.
                    </p>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        Ma mission ? T'aider à décrocher l'emploi de tes rêves plus rapidement et efficacement grâce à des méthodes éprouvées et un accompagnement personnalisé.
                    </p>
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">4 300+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Personnes accompagnées</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">85%</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Taux de réussite</div>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('about') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold rounded-lg transition-all duration-300">
                            <i class="fas fa-user mr-2"></i>En savoir plus sur moi
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white font-semibold rounded-lg transition-all duration-300">
                            <i class="fas fa-envelope mr-2"></i>Me contacter
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-orange-100 to-blue-100 dark:from-orange-900 dark:to-blue-900 rounded-2xl p-8">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Coach Didi" class="w-full h-80 object-cover rounded-xl shadow-xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($recentArticles->count())
    <section class="py-16 lg:py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-newspaper text-orange-600 mr-3"></i>Articles Récents
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    Découvre mes derniers conseils pour booster ta recherche d'emploi et décrocher le poste de tes rêves.
                </p>
            </div>

            @if($featuredArticle)
            <div class="mb-12">
                <div class="bg-gradient-to-r from-orange-100 to-blue-100 dark:from-orange-900 dark:to-blue-900 rounded-2xl overflow-hidden shadow-xl">
                    <div class="lg:flex">
                        <div class="lg:w-1/2">
                            <img src="{{ $featuredArticle->image_url ?? 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=800' }}" alt="{{ $featuredArticle->titre }}" class="w-full h-64 lg:h-full object-cover">
                        </div>
                        <div class="lg:w-1/2 p-8 lg:p-12">
                            <span class="px-3 py-1 rounded-full text-sm font-medium text-white bg-orange-600"><i class="fas fa-star mr-1"></i>Article vedette</span>
                            <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white my-4">{{ $featuredArticle->titre }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">{{ $featuredArticle->extrait }}</p>
                            <div class="flex items-center justify-between mb-6">
                                <span class="text-sm text-gray-500"><i class="fas fa-user mr-2"></i>{{ $featuredArticle->auteur }}</span>
                                <span class="text-sm text-gray-500">{{ $featuredArticle->created_at->format('d M Y') }} · {{ $featuredArticle->temps_lecture }}</span>
                            </div>
                            <a href="{{ route('blog.show', $featuredArticle->slug) }}" class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                                Lire l'article<i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($recentArticles->take(3) as $article)
                @if(!$featuredArticle || $article->id !== $featuredArticle->id)
                <article class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <img src="{{ $article->image_url ?? 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=500' }}" alt="{{ $article->titre }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: {{ $article->categorie->couleur ?? '#f97316' }}">{{ $article->categorie->nom ?? 'Général' }}</span>
                            <span class="text-sm text-gray-500">{{ $article->temps_lecture }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $article->titre }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($article->extrait, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500"><i class="fas fa-user mr-2"></i>{{ $article->auteur }}</span>
                            <a href="{{ route('blog.show', $article->slug) }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 font-medium">Lire<i class="fas fa-arrow-right ml-2"></i></a>
                        </div>
                    </div>
                </article>
                @endif
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('blog.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition-all duration-300">
                    <i class="fas fa-newspaper mr-2"></i>Voir tous les articles
                </a>
            </div>
        </div>
    </section>
    @endif

    @if($categories->count())
    <section class="py-16 lg:py-20 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-tags text-orange-600 mr-3"></i>Catégories d'Articles
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
                @foreach($categories as $category)
                <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100 dark:border-gray-700">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300" style="background-color: {{ $category->couleur }}20">
                        <i class="{{ $category->icone }} text-2xl" style="color: {{ $category->couleur }}"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-orange-600 transition-colors">{{ $category->nom }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $category->description }}</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" style="background-color: {{ $category->couleur }}20; color: {{ $category->couleur }}">
                        {{ $category->articles_count }} article{{ $category->articles_count > 1 ? 's' : '' }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</x-layouts.app>
