@extends('admin.layout')
@section('title', 'Pages du site')
@section('subtitle', 'Modifier les contenus des pages À propos et Qui suis-je')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-home text-orange-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Section "Qui suis-je ?" - Page d'accueil</h3>
                        <p class="text-sm text-gray-500">Personnalisez la section de présentation sur la page d'accueil</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Titre</label>
                            <input type="text" name="qui_suis_je_title" value="{{ old('qui_suis_je_title', $settings['qui_suis_je_title']) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Premier paragraphe</label>
                            <textarea name="qui_suis_je_description1" rows="4"
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">{{ old('qui_suis_je_description1', $settings['qui_suis_je_description1']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Deuxième paragraphe</label>
                            <textarea name="qui_suis_je_description2" rows="4"
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">{{ old('qui_suis_je_description2', $settings['qui_suis_je_description2']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Image</label>
                            <input type="file" name="qui_suis_je_image" accept="image/*"
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-50 file:text-orange-600 file:font-semibold hover:file:bg-orange-100">
                            <p class="text-xs text-gray-500 mt-1">Formats acceptés : JPG, PNG, GIF. Max 2 Mo.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 1 - Valeur</label>
                                <input type="text" name="qui_suis_je_stat1_value" value="{{ old('qui_suis_je_stat1_value', $settings['qui_suis_je_stat1_value']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 1 - Label</label>
                                <input type="text" name="qui_suis_je_stat1_label" value="{{ old('qui_suis_je_stat1_label', $settings['qui_suis_je_stat1_label']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 2 - Valeur</label>
                                <input type="text" name="qui_suis_je_stat2_value" value="{{ old('qui_suis_je_stat2_value', $settings['qui_suis_je_stat2_value']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Statistique 2 - Label</label>
                                <input type="text" name="qui_suis_je_stat2_label" value="{{ old('qui_suis_je_stat2_label', $settings['qui_suis_je_stat2_label']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                        </div>

                        @if($settings['qui_suis_je_image'])
                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Image actuelle</label>
                            <img src="{{ $settings['qui_suis_je_image'] }}" alt="Aperçu" class="w-full h-48 object-cover rounded-xl border">
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Page "À Propos"</h3>
                        <p class="text-sm text-gray-500">Personnalisez le contenu de la page À propos</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Titre principal</label>
                            <input type="text" name="about_title" value="{{ old('about_title', $settings['about_title']) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                            <textarea name="about_description" rows="6"
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">{{ old('about_description', $settings['about_description']) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Image</label>
                            <input type="file" name="about_image" accept="image/*"
                                class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-600 file:font-semibold hover:file:bg-blue-100">
                            <p class="text-xs text-gray-500 mt-1">Formats acceptés : JPG, PNG, GIF. Max 2 Mo.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 1 - Valeur</label>
                                <input type="text" name="about_stat1_value" value="{{ old('about_stat1_value', $settings['about_stat1_value']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 1 - Label</label>
                                <input type="text" name="about_stat1_label" value="{{ old('about_stat1_label', $settings['about_stat1_label']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 2 - Valeur</label>
                                <input type="text" name="about_stat2_value" value="{{ old('about_stat2_value', $settings['about_stat2_value']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 2 - Label</label>
                                <input type="text" name="about_stat2_label" value="{{ old('about_stat2_label', $settings['about_stat2_label']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 3 - Valeur</label>
                                <input type="text" name="about_stat3_value" value="{{ old('about_stat3_value', $settings['about_stat3_value']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 3 - Label</label>
                                <input type="text" name="about_stat3_label" value="{{ old('about_stat3_label', $settings['about_stat3_label']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 4 - Valeur</label>
                                <input type="text" name="about_stat4_value" value="{{ old('about_stat4_value', $settings['about_stat4_value']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Stat 4 - Label</label>
                                <input type="text" name="about_stat4_label" value="{{ old('about_stat4_label', $settings['about_stat4_label']) }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-900 focus:border-orange-500 focus:ring-orange-500">
                            </div>
                        </div>

                        @if($settings['about_image'])
                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Image actuelle</label>
                            <img src="{{ $settings['about_image'] }}" alt="Aperçu" class="w-full h-48 object-cover rounded-xl border">
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-orange-600 text-white font-semibold hover:bg-orange-700 shadow-lg shadow-orange-900/20 transition-all">
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
            </div>
        </div>
    </form>
@endsection