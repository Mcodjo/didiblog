@extends('admin.layout')
@section('title', 'Modifier la catégorie')
@section('subtitle', 'Mise à jour des informations de section')

@section('content')
    <div class="max-w-2xl mx-auto">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de la catégorie</label>
                    <input type="text" name="nom" value="{{ $category->nom }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                        placeholder="Ex: Entretiens, CV & Lettres...">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description courte</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                        placeholder="De quoi parle cette catégorie ?">{{ $category->description }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Couleur</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="couleur" value="{{ $category->couleur }}"
                                class="h-12 w-16 rounded-lg border border-gray-900 p-1 cursor-pointer">
                            <span class="text-sm text-gray-500">Code: {{ $category->couleur }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-50">
                    <label
                        class="flex items-center justify-between p-4 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors group">
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-gray-700">Statut actif</span>
                            <span class="text-xs text-gray-500">Rendre cette catégorie visible immédiatement</span>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="actif" value="1" class="sr-only peer" {{ $category->actif ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3 max-w-2xl">
                <a href="{{ route('admin.categories.index') }}"
                    class="px-6 py-2.5 rounded-xl text-gray-600 hover:bg-gray-100 font-medium transition-colors">
                    Annuler
                </a>
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-orange-600 text-white font-semibold hover:bg-orange-700 shadow-lg shadow-orange-900/20 transition-all hover:scale-105">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
@endsection