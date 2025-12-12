@extends('admin.layout')
@section('title', 'Newsletter')
@section('subtitle', 'Gérez votre liste de diffusion')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Abonné
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Source
                            d'inscription</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($newsletters as $n)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-orange-500">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $n->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                    {{ $n->source ?? 'Site Web' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">
                                {{ $n->created_at->format('d/m/Y à H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.newsletters.destroy', $n) }}" method="POST"
                                    class="inline-block opacity-0 group-hover:opacity-100 transition-opacity"
                                    onsubmit="return confirm('Supprimer cet abonné ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 rounded-lg flex items-center justify-center text-red-400 hover:bg-red-50 hover:text-red-600 transition-colors"
                                        title="Désinscrire">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div
                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                                <p class="font-medium">Aucun abonné pour le moment</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">
        {{ $newsletters->links() }}
    </div>
@endsection