<x-layouts.app title="Blog">
    <section class="bg-gradient-to-r from-orange-600 to-blue-600 text-white py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6"><i class="fas fa-newspaper mr-3"></i>Blog Emploi Connect</h1>
            <p class="text-xl mb-8 max-w-3xl mx-auto">Tous mes conseils pour décrocher l'emploi de tes rêves.</p>
            <form method="GET" action="{{ route('blog.index') }}" class="max-w-2xl mx-auto flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Rechercher un article..." class="w-full px-6 py-4 pl-12 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button type="submit" class="px-8 py-4 bg-white text-orange-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors"><i class="fas fa-search mr-2"></i>Rechercher</button>
            </form>
        </div>
    </section>

    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6"><i class="fas fa-filter mr-2"></i>Filtrer par catégorie</h2>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('blog.index') }}" class="px-4 py-2 rounded-full font-medium transition-colors {{ empty($categorySlug) ? 'bg-orange-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-orange-100' }}">
                        <i class="fas fa-th-large mr-2"></i>Tous
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="px-4 py-2 rounded-full font-medium transition-colors {{ $categorySlug === $cat->slug ? 'text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100' }}" @if($categorySlug === $cat->slug) style="background-color: {{ $cat->couleur }}" @endif>
                        <i class="{{ $cat->icone }} mr-2"></i>{{ $cat->nom }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="mb-8">
                <p class="text-gray-600 dark:text-gray-400">{{ $articles->total() }} article{{ $articles->total() > 1 ? 's' : '' }} trouvé{{ $articles->total() > 1 ? 's' : '' }}</p>
            </div>

            @if($articles->isEmpty())
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Aucun article trouvé</h3>
                <a href="{{ route('blog.index') }}" class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors mt-4">
                    <i class="fas fa-arrow-left mr-2"></i>Voir tous les articles
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($articles as $article)
                <article class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300">
                    <a href="{{ route('blog.show', $article->slug) }}">
                        <img src="{{ $article->image_url ?? 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=500' }}" alt="{{ $article->titre }}" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: {{ $article->categorie->couleur ?? '#f97316' }}">{{ $article->categorie->nom ?? 'Général' }}</span>
                            <span class="text-sm text-gray-500">{{ $article->temps_lecture }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            <a href="{{ route('blog.show', $article->slug) }}" class="hover:text-orange-600">{{ $article->titre }}</a>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($article->extrait, 100) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500"><i class="fas fa-user mr-2"></i>{{ $article->auteur }}</span>
                            <span class="text-sm text-gray-500"><i class="fas fa-eye mr-1"></i>{{ number_format($article->vues) }}</span>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="flex justify-center">{{ $articles->links() }}</div>
            @endif
        </div>
    </section>
</x-layouts.app>
