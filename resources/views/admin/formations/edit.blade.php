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
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-orange-600 text-lg"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Informations principales</h3>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-heading text-gray-400 mr-2"></i>Nom de la formation
                            </label>
                            <input type="text" name="nom" value="{{ $formation->nom }}" required
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                                placeholder="Ex: Masterclass Laravel 10">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-align-left text-gray-400 mr-2"></i>Description détaillée
                            </label>
                            <textarea name="description" rows="5" required
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                                placeholder="Que vont apprendre les étudiants ?">{{ $formation->description }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-layer-group text-gray-400 mr-2"></i>Niveau
                                </label>
                                <select name="niveau"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                                    <option value="">Sélectionnez un niveau</option>
                                    <option value="Débutant" {{ $formation->niveau == 'Débutant' ? 'selected' : '' }}>Débutant</option>
                                    <option value="Intermédiaire" {{ $formation->niveau == 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                    <option value="Avancé" {{ $formation->niveau == 'Avancé' ? 'selected' : '' }}>Avancé</option>
                                    <option value="Expert" {{ $formation->niveau == 'Expert' ? 'selected' : '' }}>Expert</option>
                                    <option value="Tous niveaux" {{ $formation->niveau == 'Tous niveaux' ? 'selected' : '' }}>Tous niveaux</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-clock text-gray-400 mr-2"></i>Durée estimée
                                </label>
                                <input type="text" name="duree" value="{{ $formation->duree }}" placeholder="Ex: 10h 30m"
                                    class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-images text-blue-600 text-lg"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Média & Ressources</h3>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-image text-gray-400 mr-2"></i>Image de couverture
                            </label>
                            @if($formation->image_url)
                            <div class="mb-3">
                                <img src="{{ $formation->image_url }}" alt="Image actuelle" class="w-full h-32 object-cover rounded-xl border-2 border-gray-200">
                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                    <i class="fas fa-check-circle text-green-500"></i>Image actuelle
                                </p>
                            </div>
                            @endif
                            <input type="file" name="image" accept="image/*"
                                class="w-full px-4 py-2.5 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF, WEBP (max 2MB). Laissez vide pour conserver l'image actuelle.</p>
                            @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-shopping-cart text-gray-400 mr-2"></i>Lien d'achat / Accès
                            </label>
                            <input type="url" name="lien_achat" value="{{ $formation->lien_achat }}"
                                placeholder="https://..."
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tag text-green-600 text-lg"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Tarification</h3>
                    </div>

                    <div class="space-y-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-coins text-gray-400 mr-2"></i>Prix (XOF)
                            </label>
                            <div class="relative">
                                <input type="number" name="prix" value="{{ $formation->prix }}" step="0.01" required
                                    class="w-full px-4 pr-16 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors font-mono text-lg font-bold text-gray-900">
                                <span class="absolute right-4 top-4 text-gray-400 font-semibold">XOF</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-percent text-gray-400 mr-2"></i>Prix barré (Optionnel)
                            </label>
                            <div class="relative">
                                <input type="number" name="prix_barre" value="{{ $formation->prix_barre }}" step="0.01"
                                    class="w-full px-4 pr-16 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors font-mono text-gray-500">
                                <span class="absolute right-4 top-4 text-gray-400 font-semibold">XOF</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>Laissez vide si pas de promotion
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-certificate text-gray-400 mr-2"></i>Badge promo
                            </label>
                            <input type="text" name="badge" value="{{ $formation->badge }}" placeholder="Ex: -30%"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <label class="flex items-center justify-between cursor-pointer group p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <span class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                    <i class="fas fa-toggle-on text-gray-400"></i>Formation active
                                </span>
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
                            class="px-4 py-2.5 rounded-xl border-2 border-gray-300 text-gray-600 text-center text-sm font-semibold hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i>Annuler
                        </a>
                        <button type="submit"
                            class="px-4 py-2.5 rounded-xl bg-orange-600 text-white text-center text-sm font-semibold hover:bg-orange-700 shadow-lg shadow-orange-900/20 transition-all hover:scale-105 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection