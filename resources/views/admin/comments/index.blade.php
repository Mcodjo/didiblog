@extends('admin.layout')
@section('title', 'Commentaires')
@section('subtitle', 'Modérez les échanges avec votre communauté')

@section('content')
    <!-- Filter Tabs -->
    <div class="mb-8 flex flex-wrap gap-2">
        <a href="{{ route('admin.comments.index') }}"
            class="px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ !$status ? 'bg-orange-600 text-white shadow-lg shadow-orange-900/20' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-100' }}">
            Tous les messages
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}"
            class="px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ $status === 'pending' ? 'bg-yellow-500 text-white shadow-lg shadow-yellow-900/20' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-100' }}">
            <i class="fas fa-clock mr-2"></i>En attente
        </a>
        <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}"
            class="px-5 py-2.5 rounded-xl font-medium text-sm transition-all {{ $status === 'approved' ? 'bg-green-500 text-white shadow-lg shadow-green-900/20' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-100' }}">
            <i class="fas fa-check-circle mr-2"></i>Approuvés
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Auteur
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Commentaire</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($comments as $c)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm shadow-sm flex-shrink-0">
                                        {{ substr($c->author_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $c->author_name }}</div>
                                        <div class="text-xs text-gray-500 hover:text-orange-600 transition-colors">
                                            {{ $c->author_email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="max-w-md">
                                    <p class="text-sm text-gray-900 mb-1 leading-relaxed">"{{ Str::limit($c->content, 80) }}"
                                    </p>
                                    <a href="{{ $c->article ? route('blog.show', $c->article->slug) : '#' }}"
                                        class="inline-flex items-center text-xs text-gray-500 hover:text-orange-600 transition-colors bg-gray-100 hover:bg-orange-50 px-2 py-0.5 rounded-lg"
                                        target="_blank">
                                        <i class="fas fa-newspaper mr-1.5"></i>
                                        {{ $c->article->titre ?? 'Article supprimé' }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($c->status === 'approved')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                        <i class="fas fa-check-circle text-[10px]"></i> Approuvé
                                    </span>
                                @elseif($c->status === 'pending')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-100 animate-pulse">
                                        <i class="fas fa-clock text-[10px]"></i> En attente
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                                        <i class="fas fa-ban text-[10px]"></i> Rejeté
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @if($c->status !== 'approved')
                                        <form action="{{ route('admin.comments.approve', $c) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center text-green-500 hover:bg-green-50 hover:text-green-600 transition-colors"
                                                title="Approuver">
                                                <i class="fas fa-check text-sm"></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if($c->status !== 'rejected')
                                        <form action="{{ route('admin.comments.reject', $c) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center text-yellow-500 hover:bg-yellow-50 hover:text-yellow-600 transition-colors"
                                                title="Rejeter">
                                                <i class="fas fa-times text-sm"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.comments.destroy', $c) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce commentaire ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 rounded-lg flex items-center justify-center text-red-400 hover:bg-red-50 hover:text-red-600 transition-colors"
                                            title="Supprimer">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div
                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <i class="fas fa-comments text-2xl"></i>
                                </div>
                                <p class="font-medium">Aucun commentaire trouvé</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">
        {{ $comments->links() }}
    </div>
@endsection