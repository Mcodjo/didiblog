<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Meta tags dynamiques -->
    <title><?= isset($pageTitle) ? escape($pageTitle) : 'Emploi Connect - Coach Didi' ?></title>
    <meta name="description" content="<?= isset($pageDescription) ? escape($pageDescription) : 'Blog professionnel d\'employabilité et carrière par Coach Didi' ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= isset($pageTitle) ? escape($pageTitle) : 'Emploi Connect - Coach Didi' ?>">
    <meta property="og:description" content="<?= isset($pageDescription) ? escape($pageDescription) : 'Blog professionnel d\'employabilité et carrière par Coach Didi' ?>">
    <meta property="og:url" content="<?= SITE_URL . $_SERVER['REQUEST_URI'] ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= SITE_NAME ?>">
    
    <!-- Theme Color -->
    <meta name="theme-color" content="#f97316">
    <meta name="msapplication-TileColor" content="#f97316">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%23f97316'/><text x='50' y='65' font-size='50' text-anchor='middle' fill='white'>💼</text></svg>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    
    <!-- Configuration Tailwind -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary-orange': {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-hero {
            background: linear-gradient(135deg, rgba(154, 52, 18, 0.9) 0%, rgba(30, 58, 138, 0.8) 100%);
        }
        .sticky-header {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .dark .sticky-header {
            background: rgba(17, 24, 39, 0.95);
        }
        .article-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">

    <!-- Header -->
    <header id="header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center">
                        <img src="https://page.gensparksite.com/v1/base64_upload/a456eb81c0763b6540288c7203d94cf5" 
                             alt="Coach Didi Logo" 
                             class="w-8 h-8 object-cover rounded-full">
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="<?= SITE_URL ?>" class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white hover:text-orange-600 transition-colors">
                            Emploi Connect
                        </a>
                        <div class="w-3 h-3 bg-gradient-to-r from-orange-500 to-blue-600 rounded-full animate-pulse"></div>
                    </div>
                </div>

                <!-- Navigation Desktop -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="<?= SITE_URL ?>" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-500 transition-colors font-medium">Accueil</a>
                    <a href="<?= SITE_URL ?>/a-propos.php" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-500 transition-colors font-medium">À Propos</a>
                    <a href="<?= SITE_URL ?>/testimonials.php" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-500 transition-colors font-medium">Témoignages</a>
                    <a href="<?= SITE_URL ?>/formations.php" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-500 transition-colors font-medium">Formations</a>
                    <a href="<?= SITE_URL ?>/blog.php" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-500 transition-colors font-medium">Blog</a>
                    <a href="<?= SITE_URL ?>/contact.php" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-500 transition-colors font-medium">Contact</a>
                    <?php if (isLoggedIn()): ?>
                        <?php if (isAdmin()): ?>
                            <a href="<?= SITE_URL ?>/admin/" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-500 transition-colors font-medium">Admin</a>
                        <?php endif; ?>
                        <a href="<?= SITE_URL ?>/logout.php" class="text-gray-700 dark:text-gray-300 hover:text-red-600 transition-colors font-medium">Déconnexion</a>
                    <?php else: ?>
                        <a href="<?= SITE_URL ?>/login.php" class="text-gray-700 dark:text-gray-300 hover:text-orange-600 dark:hover:text-orange-500 transition-colors font-medium">Connexion</a>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-4">
                    <!-- Mode sombre/clair -->
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <i id="theme-icon" class="fas fa-sun text-gray-600 dark:text-gray-300"></i>
                    </button>
                    
                    <!-- Recherche -->
                    <button id="search-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <i class="fas fa-search text-gray-600 dark:text-gray-300"></i>
                    </button>
                    
                    <!-- Menu mobile -->
                    <button id="mobile-menu-toggle" class="lg:hidden p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <i id="mobile-menu-icon" class="fas fa-bars text-gray-600 dark:text-gray-300"></i>
                    </button>
                </div>
            </div>

            <!-- Menu mobile -->
            <div id="mobile-menu" class="lg:hidden hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg">
                <div class="px-4 py-4 space-y-1">
                    <a href="<?= SITE_URL ?>" class="block px-3 py-3 text-gray-700 dark:text-gray-300 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors font-medium rounded-lg">
                        <i class="fas fa-home mr-3 w-5"></i>Accueil
                    </a>
                    <a href="<?= SITE_URL ?>/a-propos.php" class="block px-3 py-3 text-gray-700 dark:text-gray-300 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors font-medium rounded-lg">
                        <i class="fas fa-user mr-3 w-5"></i>À Propos
                    </a>
                    <a href="<?= SITE_URL ?>/testimonials.php" class="block px-3 py-3 text-gray-700 dark:text-gray-300 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors font-medium rounded-lg">
                        <i class="fas fa-quote-left mr-3 w-5"></i>Témoignages
                    </a>
                    <a href="<?= SITE_URL ?>/formations.php" class="block px-3 py-3 text-gray-700 dark:text-gray-300 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors font-medium rounded-lg">
                        <i class="fas fa-graduation-cap mr-3 w-5"></i>Formations
                    </a>
                    <a href="<?= SITE_URL ?>/blog.php" class="block px-3 py-3 text-gray-700 dark:text-gray-300 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors font-medium rounded-lg">
                        <i class="fas fa-blog mr-3 w-5"></i>Blog
                    </a>
                    <a href="<?= SITE_URL ?>/contact.php" class="block px-3 py-3 text-gray-700 dark:text-gray-300 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors font-medium rounded-lg">
                        <i class="fas fa-envelope mr-3 w-5"></i>Contact
                    </a>
                    <?php if (isLoggedIn()): ?>
                        <?php if (isAdmin()): ?>
                            <a href="<?= SITE_URL ?>/admin/" class="block px-3 py-3 text-gray-700 dark:text-gray-300 hover:text-orange-600 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors font-medium rounded-lg">
                                <i class="fas fa-cog mr-3 w-5"></i>Admin
                            </a>
                        <?php endif; ?>
                        <a href="<?= SITE_URL ?>/logout.php" class="block px-3 py-3 text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors font-medium rounded-lg">
                            <i class="fas fa-sign-out-alt mr-3 w-5"></i>Déconnexion
                        </a>
                    <?php else: ?>
                        <a href="<?= SITE_URL ?>/login.php" class="block px-3 py-3 text-orange-600 hover:text-orange-700 hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-colors font-medium rounded-lg">
                            <i class="fas fa-sign-in-alt mr-3 w-5"></i>Connexion
                        </a>
                        <a href="<?= SITE_URL ?>/register.php" class="block px-3 py-3 text-blue-600 hover:text-blue-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors font-medium rounded-lg">
                            <i class="fas fa-user-plus mr-3 w-5"></i>Inscription
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Barre de recherche (cachée par défaut) -->
    <div id="search-bar" class="fixed top-20 left-0 right-0 z-40 bg-white dark:bg-gray-900 shadow-lg border-b border-gray-200 dark:border-gray-700 hidden">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form action="<?= SITE_URL ?>/search.php" method="GET" class="max-w-2xl mx-auto">
                <div class="relative">
                    <input type="text" name="q" placeholder="Rechercher des articles..." 
                           class="w-full px-6 py-3 pl-12 pr-16 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                    <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                        Rechercher
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages flash -->
    <?php 
    $flashMessage = getFlashMessage();
    if ($flashMessage): 
    ?>
    <div id="flash-message" class="fixed top-20 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded-lg shadow-lg <?= $flashMessage['type'] === 'success' ? 'bg-green-500' : 'bg-red-500' ?> text-white">
        <div class="flex items-center space-x-2">
            <i class="fas <?= $flashMessage['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?>"></i>
            <span><?= escape($flashMessage['message']) ?></span>
            <button onclick="document.getElementById('flash-message').remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const flashMsg = document.getElementById('flash-message');
            if (flashMsg) flashMsg.remove();
        }, 5000);
    </script>
    <?php endif; ?>
