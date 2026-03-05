<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'Emploi Connect - Le blog pour décrocher un emploi plus vite par Coach Didi' }}">
    <title>{{ $title ?? 'Emploi Connect' }} — Coach Didi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-white text-[#111111] antialiased" style="font-family: 'DM Sans', sans-serif;">

    {{-- Navbar --}}
    <x-navbar />

    {{-- Flash messages --}}
    @if(session('success'))
        <div id="flash-success" class="bg-green-50 border-b border-green-200 text-green-700 px-6 py-3 flex items-center justify-between text-sm" role="alert" style="font-family: 'DM Sans', sans-serif;">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flash-success').remove()" class="ml-4 text-green-500 hover:text-green-800 font-bold text-lg leading-none" aria-label="Fermer">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div id="flash-error" class="bg-red-50 border-b border-red-200 text-red-700 px-6 py-3 flex items-center justify-between text-sm" role="alert" style="font-family: 'DM Sans', sans-serif;">
            <span>{{ session('error') }}</span>
            <button onclick="document.getElementById('flash-error').remove()" class="ml-4 text-red-500 hover:text-red-800 font-bold text-lg leading-none" aria-label="Fermer">&times;</button>
        </div>
    @endif

    {{-- Contenu de la page --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-footer />

    {{-- Auto-fermeture des flash après 4s --}}
    <script>
        ['flash-success', 'flash-error'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) setTimeout(function() { el.remove(); }, 4000);
        });
    </script>

    @stack('scripts')
</body>
</html>
