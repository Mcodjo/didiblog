@extends('admin.layout')
@section('title', 'Tableau de bord')
@section('subtitle', 'Aperçu global de votre activité')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Articles Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <i class="fas fa-newspaper text-xl"></i>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">Total</span>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Articles publiés</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($stats['articles']) }}</h3>
            </div>
        </div>

        <!-- Formations Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-600">Actives</span>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Formations</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($stats['formations']) }}</h3>
            </div>
        </div>

        <!-- Newsletter Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <i class="fas fa-envelope text-xl"></i>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-orange-50 text-orange-600">Abonnés</span>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Newsletter</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($stats['newsletters']) }}</h3>
            </div>
        </div>

        <!-- Commentaires Card -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <i class="fas fa-comments text-xl"></i>
                </div>
                @if($stats['pending_comments'] > 0)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-50 text-red-600 animate-pulse">Action
                        requise</span>
                @else
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-gray-50 text-gray-600">Tout est calme</span>
                @endif
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium mb-1">Commentaires en attente</p>
                <h3 class="text-3xl font-bold text-gray-900">{{ number_format($stats['pending_comments']) }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Articles -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Articles récents</h3>
                <a href="{{ route('admin.articles.index') }}"
                    class="text-sm font-medium text-orange-600 hover:text-orange-700 hover:underline">Voir tout</a>
            </div>
            <div class="flex-1 p-2">
                @forelse($recentArticles as $article)
                    <div class="group flex items-center justify-between p-4 hover:bg-gray-50 rounded-xl transition-colors">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-white group-hover:shadow-sm transition-all">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div>
                                <p
                                    class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors line-clamp-1">
                                    {{ $article->titre }}</p>
                                <p class="text-xs text-gray-500 flex items-center gap-2">
                                    <i class="far fa-clock"></i> {{ $article->created_at->format('d M Y') }}
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>{{ $article->vues }} vues</span>
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('admin.articles.edit', $article) }}"
                            class="p-2 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-all">
                            <i class="fas fa-pen"></i>
                        </a>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-newspaper text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Aucun article publié</p>
                        <a href="{{ route('admin.articles.create') }}"
                            class="mt-2 inline-block text-sm text-orange-600 font-medium">Créer votre premier article</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Comments -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Activité récente</h3>
                <a href="{{ route('admin.comments.index') }}"
                    class="text-sm font-medium text-orange-600 hover:text-orange-700 hover:underline">Modérer</a>
            </div>
            <div class="flex-1 p-2">
                @forelse($recentComments as $comment)
                    <div class="group flex items-start gap-4 p-4 hover:bg-gray-50 rounded-xl transition-colors">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-sm font-bold shadow-sm flex-shrink-0">
                            {{ substr($comment->author_name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="font-semibold text-gray-900 text-sm">{{ $comment->author_name }}</p>
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] uppercase font-bold tracking-wide {{ $comment->status === 'approved' ? 'bg-green-100 text-green-700' : ($comment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $comment->status }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-2">"{{ $comment->content }}"</p>
                            <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-comments text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Aucun commentaire récent</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection