@extends('admin.layout')
@section('title', 'Catégories')
@section('actions')
    <a href="{{ route('admin.categories.create') }}"
        class="group flex items-center gap-2 px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-xl transition-all shadow-lg shadow-orange-900/20 hover:shadow-orange-900/30 font-medium text-sm">
        <i class="fas fa-plus transition-transform group-hover:rotate-180"></i>
        <span>Nouvelle catégorie</span>
    </a>
@endsection

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nom
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Contenu
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $cat)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg shadow-sm"
                                        style="background-color: {{ $cat->couleur }}15; color: {{ $cat->couleur }}">
                                        <i class="{{ $cat->icone }}"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors">
                                            {{ $cat->nom }}</div>
                                        <div class="text-xs text-gray-500 font-mono mt-0.5">#{{ $cat->couleur }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    <i class="fas fa-newspaper text-[10px]"></i>
                                    {{ $cat->articles_count }} articles
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($cat->actif)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.categories.edit', $cat) }}"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-blue-400 hover:bg-blue-50 hover:text-blue-600 transition-colors"
                                        title="Modifier">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
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
                                    <i class="fas fa-folder-open text-2xl"></i>
                                </div>
                                <p class="font-medium">Aucune catégorie trouvée</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection