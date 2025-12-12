<x-layouts.app title="À Propos">
    <section class="bg-gradient-to-r from-orange-600 to-blue-600 text-white py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-6"><i class="fas fa-user mr-3"></i>À Propos de Coach Didi</h1>
            <p class="text-xl max-w-3xl mx-auto">Découvre mon parcours et ma mission pour t'aider à décrocher ton emploi de rêve.</p>
        </div>
    </section>

    <section class="py-16 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="{{ $about['image'] }}" alt="Coach Didi" class="w-full h-auto max-h-[500px] object-contain rounded-2xl shadow-xl border-4 border-orange-500">
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">{{ $about['title'] }}</h2>
                    <div class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                        {!! $about['description'] !!}
                    </div>
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="text-center bg-orange-50 dark:bg-gray-800 p-6 rounded-xl">
                            <div class="text-3xl font-bold text-orange-600">{{ $about['stat1_value'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $about['stat1_label'] }}</div>
                        </div>
                        <div class="text-center bg-green-50 dark:bg-gray-800 p-6 rounded-xl">
                            <div class="text-3xl font-bold text-green-600">{{ $about['stat2_value'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $about['stat2_label'] }}</div>
                        </div>
                        <div class="text-center bg-blue-50 dark:bg-gray-800 p-6 rounded-xl">
                            <div class="text-3xl font-bold text-blue-600">{{ $about['stat3_value'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $about['stat3_label'] }}</div>
                        </div>
                        <div class="text-center bg-purple-50 dark:bg-gray-800 p-6 rounded-xl">
                            <div class="text-3xl font-bold text-purple-600">{{ $about['stat4_value'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ $about['stat4_label'] }}</div>
                        </div>
                    </div>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                        <i class="fas fa-envelope mr-2"></i>Me contacter
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>