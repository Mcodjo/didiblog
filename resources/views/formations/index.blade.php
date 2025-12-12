<x-layouts.app title="Formations">
    <section class="bg-gradient-to-r from-orange-600 to-blue-600 text-white py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6"><i class="fas fa-graduation-cap mr-3"></i>Mes Formations</h1>
            <p class="text-xl max-w-3xl mx-auto">Transforme ta carrière avec mes formations complètes et pratiques.</p>
        </div>
    </section>

    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            @if($formations->isEmpty())
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Aucune formation disponible pour le moment</h3>
                <p class="text-gray-600 dark:text-gray-400">Revenez bientôt pour découvrir nos nouvelles formations !</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($formations as $formation)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                    @if($formation->image_url)
                    <img src="{{ $formation->image_url }}" alt="{{ $formation->nom }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gradient-to-br from-orange-400 to-blue-500 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-5xl text-white"></i>
                    </div>
                    @endif
                    <div class="p-6">
                        @if($formation->badge)
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold text-white mb-3" style="background-color: {{ $formation->couleur_badge }}">{{ $formation->badge }}</span>
                        @endif
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $formation->nom }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ $formation->description }}</p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500"><i class="fas fa-layer-group mr-1"></i>{{ $formation->niveau }}</span>
                            @if($formation->duree)
                            <span class="text-sm text-gray-500"><i class="fas fa-clock mr-1"></i>{{ $formation->duree }}</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between mb-6">
                            <div class="text-2xl font-bold text-orange-600">
                                {{ number_format($formation->prix, 0) }}€
                                @if($formation->prix_barre)
                                <span class="text-sm text-gray-500 line-through ml-2">{{ number_format($formation->prix_barre, 0) }}€</span>
                                @endif
                            </div>
                            <div class="flex items-center">
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-sm"></i>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600 dark:text-gray-400 ml-1">({{ $formation->note }})</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('formations.show', $formation->slug) }}" class="w-full block text-center bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300">
                            <i class="fas fa-play mr-2"></i>Découvrir
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>
</x-layouts.app>
