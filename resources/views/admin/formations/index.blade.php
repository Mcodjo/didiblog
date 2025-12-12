@extends('admin.layout')
@section('title', 'Formations')
@section('actions')
    <a href="{{ route('admin.formations.create') }}"
        class="group flex items-center gap-2 px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white rounded-xl transition-all shadow-lg shadow-orange-900/20 hover:shadow-orange-900/30 font-medium text-sm">
        <i class="fas fa-plus transition-transform group-hover:rotate-180"></i>
        <span>Nouvelle formation</span>
    </a>
@endsection

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Formation</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Prix
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($formations as $f)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-500 shadow-sm flex-shrink-0">
                                        <i class="fas fa-graduation-cap text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors">
                                            {{ $f->nom }}</div>
                                        <div class="text-xs text-gray-500 mt-0.5 flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] bg-gray-100 text-gray-600 font-medium uppercase tracking-wide">
                                                {{ $f->niveau }}
                                            </span>
                                            <span>•</span>
                                            <span>{{ $f->duree ?? 'Durée indéfinie' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col items-start text-sm">
                                    <span class="font-bold text-gray-900">{{ number_format($f->prix, 0) }}€</span>
                                    @if($f->prix_barre)
                                        <span
                                            class="text-xs text-gray-400 line-through">{{ number_format($f->prix_barre, 0) }}€</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($f->actif)
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
                                    <a href="{{ route('admin.formations.edit', $f) }}"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-blue-400 hover:bg-blue-50 hover:text-blue-600 transition-colors"
                                        title="Modifier">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.formations.destroy', $f) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?');">
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
                                    <i class="fas fa-graduation-cap text-2xl"></i>
                                </div>
                                <p class="font-medium">Aucune formation trouvée</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection