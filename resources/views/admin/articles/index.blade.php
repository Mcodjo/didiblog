@extends('admin.layout')
@section('title', 'Articles')
@section('actions')
<a href="{{ route('admin.articles.create') }}" class="group flex items-center gap-2 px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-xl transition-all shadow-lg shadow-orange-900/20 hover:shadow-orange-900/30 font-medium text-sm">
    <i class="fas fa-plus transition-transform group-hover:rotate-180"></i>
    <span>Nouvel article</span>
</a>
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Article</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Catégorie</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Performance</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($articles as $article)
                <tr class="group hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 flex-shrink-0 flex items-center justify-center text-gray-400 overflow-hidden">
                                @if($article->image_url)
                                <img src="{{ $article->image_url }}" alt="" class="w-full h-full object-cover">
                                @else
                                <i class="fas fa-image text-xl"></i>
                                @endif
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 line-clamp-1 group-hover:text-orange-600 transition-colors">{{ $article->titre }}</div>
                                <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $article->created_at->format('d/m/Y') }}
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span>{{ $article->author ?? 'Admin' }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($article->categorie)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border" style="background-color: {{ $article->categorie->couleur }}10; color: {{ $article->categorie->couleur }}; border-color: {{ $article->categorie->couleur }}20">
                            <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $article->categorie->couleur }}"></span>
                            {{ $article->categorie->nom }}
                        </span>
                        @else
                        <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col items-start gap-1">
                            @if($article->actif)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Public
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Brouillon
                            </span>
                            @endif
                            
                            @if($article->featured)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                <i class="fas fa-star text-[10px]"></i> Vedette
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <i class="far fa-eye text-gray-400"></i>
                            <span class="font-medium">{{ number_format($article->vues) }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('blog.show', $article->slug) }}" target="_blank" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors" title="Voir l'article">
                                <i class="fas fa-external-link-alt text-sm"></i>
                            </a>
                            <a href="{{ route('admin.articles.edit', $article) }}" class="w-8 h-8 rounded-lg flex items-center justify-center text-blue-400 hover:bg-blue-50 hover:text-blue-600 transition-colors" title="Modifier">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg flex items-center justify-center text-red-400 hover:bg-red-50 hover:text-red-600 transition-colors" title="Supprimer">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fas fa-newspaper text-2xl"></i>
                        </div>
                        <p class="font-medium">Aucun article trouvé</p>
                        <p class="text-sm mt-1">Commencez par créer votre premier article.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">
    {{ $articles->links() }}
</div>
@endsection