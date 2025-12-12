<x-layouts.app :title="$article->titre">
    <article class="py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <div class="mb-8">
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 mb-4">
                        <i class="fas fa-arrow-left mr-2"></i>Retour au blog
                    </a>
                    <span class="px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: {{ $article->categorie->couleur ?? '#f97316' }}">{{ $article->categorie->nom ?? 'Général' }}</span>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mt-4 mb-4">{{ $article->titre }}</h1>
                    <div class="flex items-center text-gray-500 space-x-4">
                        <span><i class="fas fa-user mr-2"></i>{{ $article->auteur }}</span>
                        <span><i class="fas fa-calendar mr-2"></i>{{ $article->created_at->format('d M Y') }}</span>
                        <span><i class="fas fa-clock mr-2"></i>{{ $article->temps_lecture }}</span>
                        <span><i class="fas fa-eye mr-2"></i>{{ number_format($article->vues) }} vues</span>
                    </div>
                </div>

                @if($article->image_url)
                <img src="{{ $article->image_url }}" alt="{{ $article->titre }}" class="w-full h-96 object-cover rounded-2xl mb-8">
                @endif

                <div class="prose prose-lg dark:prose-invert max-w-none mb-12">
                    {!! nl2br(e($article->contenu)) !!}
                </div>

                <section class="border-t pt-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-comments text-orange-600 mr-2"></i>Commentaires ({{ $article->approvedComments->count() }})
                    </h3>

                    @foreach($article->approvedComments as $comment)
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $comment->author_name }}</span>
                            <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                    </div>
                    @endforeach

                    <form action="{{ route('comments.store', $article) }}" method="POST" class="bg-gray-100 dark:bg-gray-800 rounded-lg p-6 mt-6">
                        @csrf
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Laisser un commentaire</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <input type="text" name="author_name" placeholder="Votre nom" required class="px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            <input type="email" name="author_email" placeholder="Votre email" required class="px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>
                        <textarea name="content" rows="4" placeholder="Votre commentaire..." required class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent mb-4"></textarea>
                        <button type="submit" class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i>Envoyer
                        </button>
                    </form>
                </section>
            </div>

            @if($relatedArticles->count())
            <section class="mt-16">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-center">Articles similaires</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedArticles as $related)
                    <article class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <img src="{{ $related->image_url ?? 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?w=500' }}" alt="{{ $related->titre }}" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                                <a href="{{ route('blog.show', $related->slug) }}" class="hover:text-orange-600">{{ $related->titre }}</a>
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ Str::limit($related->extrait, 80) }}</p>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @endif
        </div>
    </article>
</x-layouts.app>
