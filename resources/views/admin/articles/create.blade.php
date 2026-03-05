@extends('admin.layout')
@section('title', 'Nouvel article')
@section('subtitle', 'Rédigez et publiez un nouveau contenu')

@section('content')
    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content (Left Column) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Contenu principal</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Titre de l'article</label>
                            <input type="text" name="titre" value="{{ old('titre') }}" required
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors placeholder-gray-400"
                                placeholder="Ex: Les 10 compétences clés en 2025...">
                            @error('titre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Extrait (Introduction)</label>
                            <textarea name="extrait" rows="3" required
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors placeholder-gray-400"
                                placeholder="Un bref résumé qui donne envie de lire la suite...">{{ old('extrait') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Contenu complet</label>
                            <textarea name="contenu" rows="20" required
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors font-mono text-sm"
                                placeholder="Rédigez votre article ici..."
                                id="markdown-editor">{{ old('contenu') }}</textarea>
                            <p class="text-xs text-gray-500 mt-2 text-right">Markdown supporté</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Options (Right Column) -->
            <div class="lg:sticky lg:top-24 space-y-6 self-start">
                <!-- Actions Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Publication</h3>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></span>
                            <span class="text-sm text-green-600 font-medium">Brouillon auto</span>
                        </div>
                    </div>

                    <div class="space-y-4 mb-6">
                        <label
                            class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors">
                            <span class="text-sm font-medium text-gray-700">Statut Public</span>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="actif" value="1" class="sr-only peer" checked>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                </div>
                            </div>
                        </label>

                        <label
                            class="flex items-center justify-between p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors">
                            <span class="text-sm font-medium text-gray-700">Mettre en avant</span>
                            <div class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="featured" value="1" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                </div>
                            </div>
                        </label>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.articles.index') }}"
                            class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-center text-sm font-semibold hover:bg-gray-50 transition-colors">
                            Annuler
                        </a>
                        <button type="submit"
                            class="px-4 py-2.5 rounded-xl bg-orange-600 text-white text-center text-sm font-semibold hover:bg-orange-700 shadow-lg shadow-orange-900/20 transition-all hover:scale-105">
                            Publier
                        </button>
                    </div>
                </div>

                <!-- Meta Data Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Détails</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Catégorie</label>
                            <select name="categorie_id" required
                                class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Image de couverture</label>
                            <input type="file" name="image" accept="image/*"
                                class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG, WEBP (max 2MB)</p>
                            @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Auteur</label>
                            <div class="relative">
                                <input type="text" name="auteur" value="{{ old('auteur', 'Coach Didi') }}"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                                <i class="fas fa-user absolute left-3 top-3.5 text-gray-400"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Temps de lecture</label>
                            <div class="relative">
                                <input type="text" name="temps_lecture" value="{{ old('temps_lecture', '5 min') }}"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                                <i class="far fa-clock absolute left-3 top-3.5 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection