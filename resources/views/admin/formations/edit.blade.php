@extends('admin.layout')
@section('title', 'Modifier la formation')
@section('subtitle', 'Mettre à jour le programme')

@section('content')
    <form action="{{ route('admin.formations.update', $formation) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Informations principales</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de la formation</label>
                            <input type="text" name="nom" value="{{ $formation->nom }}" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                                placeholder="Ex: Masterclass Laravel 10">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description détaillée</label>
                            <textarea name="description" rows="5" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                                placeholder="Que vont apprendre les étudiants ?">{{ $formation->description }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Niveau</label>
                                <select name="niveau"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                                    <option value="Débutant" {{ $formation->niveau == 'Débutant' ? 'selected' : '' }}>Débutant</option>
                                    <option value="Intermédiaire" {{ $formation->niveau == 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                    <option value="Avancé" {{ $formation->niveau == 'Avancé' ? 'selected' : '' }}>Avancé</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Durée estimée</label>
                                <input type="text" name="duree" value="{{ $formation->duree }}" placeholder="Ex: 10h 30m"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Liens & Ressources</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Image de couverture</label>
                            @if($formation->image_url)
                                <div class="mb-3 max-w-xs">
                                    <img src="{{ $formation->image_url }}" alt="Image actuelle" class="w-full h-auto object-cover rounded-lg border border-gray-900">
                                </div>
                            @endif
                            <input type="file" name="image" accept="image/*"
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                            <p class="text-xs text-gray-500 mt-1">Laissez vide pour conserver l'image actuelle</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Lien d'achat / Accès</label>
                            <div class="relative">
                                <input type="url" name="lien_achat" value="{{ $formation->lien_achat }}"
                                    placeholder="https://..."
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                                <i class="fas fa-shopping-cart absolute left-3 top-4 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Tarification</h3>
                    </div>

                    <div class="space-y-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Prix (XOF)</label>
                            <div class="relative">
                                <input type="number" name="prix" value="{{ $formation->prix }}" step="1" required
                                    class="w-full pl-16 pr-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors font-mono text-lg font-bold text-gray-900">
                                <span class="absolute left-4 top-4 text-gray-400">XOF</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Prix barré (Optionnel)</label>
                            <div class="relative">
                                <input type="number" name="prix_barre" value="{{ $formation->prix_barre }}" step="1"
                                    class="w-full pl-16 pr-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors font-mono text-gray-500">
                                <span class="absolute left-4 top-4 text-gray-400">XOF</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Laissez vide si pas de promotion</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Badge promo</label>
                            <input type="text" name="badge" value="{{ $formation->badge }}" placeholder="Ex: -30%"
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <label class="flex items-center justify-between cursor-pointer group">
                                <span class="text-sm font-semibold text-gray-700">Formation active</span>
                                <div class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="actif" value="1" class="sr-only peer" {{ $formation->actif ? 'checked' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('admin.formations.index') }}"
                            class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 text-center text-sm font-semibold hover:bg-gray-50 transition-colors">
                            Annuler
                        </a>
                        <button type="submit"
                            class="px-4 py-2.5 rounded-xl bg-orange-600 text-white text-center text-sm font-semibold hover:bg-orange-700 shadow-lg shadow-orange-900/20 transition-all hover:scale-105">
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection