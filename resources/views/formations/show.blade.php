<x-layouts.app :title="$formation->nom">
    <section class="py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <a href="{{ route('formations.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 mb-6">
                    <i class="fas fa-arrow-left mr-2"></i>Retour aux formations
                </a>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    @if($formation->image_url)
                    <img src="{{ $formation->image_url }}" alt="{{ $formation->nom }}" class="w-full h-64 object-cover">
                    @else
                    <div class="w-full h-64 bg-gradient-to-br from-orange-400 to-blue-500 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-6xl text-white"></i>
                    </div>
                    @endif
                    
                    <div class="p-8">
                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            @if($formation->badge)
                            <span class="px-3 py-1 rounded-full text-sm font-semibold text-white" style="background-color: {{ $formation->couleur_badge }}">{{ $formation->badge }}</span>
                            @endif
                            <span class="text-sm text-gray-500"><i class="fas fa-layer-group mr-1"></i>{{ $formation->niveau }}</span>
                            @if($formation->duree)
                            <span class="text-sm text-gray-500"><i class="fas fa-clock mr-1"></i>{{ $formation->duree }}</span>
                            @endif
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $formation->nom }}</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">{{ $formation->description }}</p>

                        @if($formation->contenu)
                        <div class="prose prose-lg dark:prose-invert max-w-none mb-8">
                            {!! nl2br(e($formation->contenu)) !!}
                        </div>
                        @endif

                        <div class="bg-orange-50 dark:bg-gray-700 rounded-xl p-6 mb-8">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <div class="text-3xl font-bold text-orange-600">
                                        {{ number_format($formation->prix, 0, ',', ' ') }} FCFA
                                        @if($formation->prix_barre)
                                        <span class="text-lg text-gray-500 line-through ml-2">{{ number_format($formation->prix_barre, 0, ',', ' ') }} FCFA</span>
                                        <span class="text-sm text-green-600 font-semibold ml-2">-{{ $formation->discount_percentage }}%</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center mt-2">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                        <span class="text-gray-600 dark:text-gray-400 ml-2">({{ $formation->note }}/5)</span>
                                    </div>
                                </div>
                                @if($formation->lien_achat)
                                <a href="{{ $formation->lien_achat }}" target="_blank" class="inline-flex items-center px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                                    <i class="fas fa-shopping-cart mr-2"></i>Acheter maintenant
                                </a>
                                @else
                                <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                                    <i class="fas fa-envelope mr-2"></i>Me contacter
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>