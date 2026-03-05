@extends('admin.layout')
@section('title', 'Messages')
@section('subtitle', 'Emails reçus via le formulaire de contact')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Expéditeur</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Sujet /
                            Motif</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Reçu le
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($contacts as $c)
                        <tr class="group hover:bg-gray-50/50 transition-colors {{ !$c->lu ? 'bg-orange-50/30' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                        {{ substr($c->nom, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900 {{ !$c->lu ? 'text-orange-900' : '' }}">
                                            {{ $c->nom }}</div>
                                        <div class="text-xs text-gray-500">{{ $c->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $c->sujet }}</div>
                                <span
                                    class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-[10px] bg-gray-100 text-gray-600 border border-gray-200 uppercase tracking-wide">
                                    {{ $c->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $c->created_at->format('d/m/Y') }}
                                <span class="text-xs block text-gray-400">{{ $c->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.contacts.show', $c) }}"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-blue-500 hover:bg-blue-50 hover:text-blue-600 transition-colors"
                                        title="Lire le message">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $c) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Supprimer ce message ?');">
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
                                    <i class="fas fa-inbox text-2xl"></i>
                                </div>
                                <p class="font-medium">Boîte de réception vide</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">
        {{ $contacts->links() }}
    </div>
@endsection