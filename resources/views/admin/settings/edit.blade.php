@extends('admin.layout')
@section('title', 'Paramètres du site')
@section('subtitle', 'Personnaliser les pages À propos et Qui suis-je')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-8">
            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- Section Qui suis-je (Page d'accueil) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-home text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Section "Qui suis-je ?" (Page d'accueil)</h2>
                        <p class="text-sm text-gray-500">Informations affichées sur la page d'accueil</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Titre</label>
                        <input type="text" name="qui_suis_je_title" value="{{ old('qui_suis_je_title', $settings['qui_suis_je_title']) }}"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                            placeholder="Ex: Coach Didi, ton expert en employabilité">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description 1</label>
                        <textarea name="qui_suis_je_description1" rows="3"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                            placeholder="Premier paragraphe de présentation">{{ old('qui_suis_je_description1', $settings['qui_suis_je_description1']) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description 2</label>
                        <textarea name="qui_suis_je_description2" rows="3"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                            placeholder="Second paragraphe de présentation">{{ old('qui_suis_je_description2', $settings['qui_suis_je_description2']) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Image</label>
                        @if($settings['qui_suis_je_image'])
                        <div class="mb-3">
                            <img src="{{ $settings['qui_suis_je_image'] }}" alt="Image actuelle" class="w-full max-w-md h-48 object-cover rounded-xl">
                            <p class="text-xs text-gray-500 mt-1">Image actuelle</p>
                        </div>
                        @endif
                        <input type="file" name="qui_suis_je_image" accept="image/*"
                            class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF (max 2MB). Laissez vide pour conserver l'image actuelle.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 1 - Valeur</label>
                            <input type="text" name="qui_suis_je_stat1_value" value="{{ old('qui_suis_je_stat1_value', $settings['qui_suis_je_stat1_value']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                                placeholder="Ex: 4 300+">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 1 - Label</label>
                            <input type="text" name="qui_suis_je_stat1_label" value="{{ old('qui_suis_je_stat1_label', $settings['qui_suis_je_stat1_label']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                                placeholder="Ex: Personnes accompagnées">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 2 - Valeur</label>
                            <input type="text" name="qui_suis_je_stat2_value" value="{{ old('qui_suis_je_stat2_value', $settings['qui_suis_je_stat2_value']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                                placeholder="Ex: 85%">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 2 - Label</label>
                            <input type="text" name="qui_suis_je_stat2_label" value="{{ old('qui_suis_je_stat2_label', $settings['qui_suis_je_stat2_label']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                                placeholder="Ex: Taux de réussite">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Page À propos -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Page "À propos"</h2>
                        <p class="text-sm text-gray-500">Informations affichées sur la page dédiée</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Titre</label>
                        <input type="text" name="about_title" value="{{ old('about_title', $settings['about_title']) }}"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                            placeholder="Ex: Bonjour, je suis Cadnel DOSSOU">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                        <textarea name="about_description" rows="8"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors"
                            placeholder="Décrivez votre parcours et votre mission">{{ old('about_description', $settings['about_description']) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Image</label>
                        @if($settings['about_image'])
                        <div class="mb-3">
                            <img src="{{ $settings['about_image'] }}" alt="Image actuelle" class="w-full max-w-md h-48 object-cover rounded-xl">
                            <p class="text-xs text-gray-500 mt-1">Image actuelle</p>
                        </div>
                        @endif
                        <input type="file" name="about_image" accept="image/*"
                            class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF (max 2MB). Laissez vide pour conserver l'image actuelle.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 1 - Valeur</label>
                            <input type="text" name="about_stat1_value" value="{{ old('about_stat1_value', $settings['about_stat1_value']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 1 - Label</label>
                            <input type="text" name="about_stat1_label" value="{{ old('about_stat1_label', $settings['about_stat1_label']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 2 - Valeur</label>
                            <input type="text" name="about_stat2_value" value="{{ old('about_stat2_value', $settings['about_stat2_value']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 2 - Label</label>
                            <input type="text" name="about_stat2_label" value="{{ old('about_stat2_label', $settings['about_stat2_label']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 3 - Valeur</label>
                            <input type="text" name="about_stat3_value" value="{{ old('about_stat3_value', $settings['about_stat3_value']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 3 - Label</label>
                            <input type="text" name="about_stat3_label" value="{{ old('about_stat3_label', $settings['about_stat3_label']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 4 - Valeur</label>
                            <input type="text" name="about_stat4_value" value="{{ old('about_stat4_value', $settings['about_stat4_value']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 4 - Label</label>
                            <input type="text" name="about_stat4_label" value="{{ old('about_stat4_label', $settings['about_stat4_label']) }}"
                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-orange-500 focus:ring-orange-500 transition-colors">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="px-8 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit"
                    class="px-8 py-3 rounded-xl bg-orange-600 text-white font-semibold hover:bg-orange-700 shadow-lg shadow-orange-900/20 transition-all hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
            </div>
        </div>
    </form>
@endsection
