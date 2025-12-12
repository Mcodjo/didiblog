<?php
require_once '../config/config.php';
require_once '../core/functions.php';
require_once '../models/Article.php';
require_once '../models/Category.php';
require_once '../models/Formation.php';

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isAdmin()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit;
}

// Connexion à la base de données
$pdo = getDatabase();

// Initialisation des modèles
$articleModel = new Article($pdo);
$categoryModel = new Category($pdo);
$formationModel = new Formation($pdo);

// Récupération des statistiques
$stats = [
    'articles' => $articleModel->count(),
    'categories' => $categoryModel->count(),
    'formations' => $formationModel->count(),
    'newsletter' => $pdo->query("SELECT COUNT(*) FROM newsletter")->fetchColumn()
];

// Récupération des derniers articles
$recentArticles = $articleModel->getAll(5);

// Configuration de la page
$pageTitle = 'Administration - Emploi Connect';
$pageDescription = 'Interface d\'administration du site Emploi Connect';
?>

<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <meta name="description" content="<?= $pageDescription ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .admin-sidebar { min-height: 100vh; }
        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
        }
        .stat-card { transition: transform 0.2s ease; }
        .stat-card:hover { transform: translateY(-2px); }
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex">
        <!-- Sidebar -->
        <div class="admin-sidebar w-64 bg-gray-900 text-white fixed left-0 top-0 z-50 lg:relative lg:translate-x-0 transform -translate-x-full transition-transform duration-300 ease-in-out" id="sidebar">
            <div class="p-6">
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tachometer-alt text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Admin Panel</h1>
                        <p class="text-gray-400 text-sm">Emploi Connect</p>
                    </div>
                </div>
                
                <nav class="space-y-2">
                    <a href="<?= SITE_URL ?>/admin/" class="flex items-center px-4 py-3 bg-orange-600 rounded-lg text-white">
                        <i class="fas fa-home mr-3"></i>
                        Dashboard
                    </a>
                    <a href="<?= SITE_URL ?>/admin/articles.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-newspaper mr-3"></i>
                        Articles
                    </a>
                    <a href="<?= SITE_URL ?>/admin/categories.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-tags mr-3"></i>
                        Catégories
                    </a>
                    <a href="<?= SITE_URL ?>/admin/comments.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-comments mr-3"></i>
                        Commentaires
                    </a>
                    <a href="<?= SITE_URL ?>/admin/formations.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-graduation-cap mr-3"></i>
                        Formations
                    </a>
                        <a href="<?= SITE_URL ?>/admin/about.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-orange-700 rounded-lg transition-colors">
                            <i class="fas fa-user mr-3"></i>
                            À propos
                        </a>
                    <a href="<?= SITE_URL ?>/admin/guides.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
                        <i class="fas fa-file-pdf mr-3"></i>
                        Guides & Fichiers
                    </a>
                    <a href="<?= SITE_URL ?>/admin/users.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
                        <i class="fas fa-users mr-3"></i>
                        Utilisateurs
                    </a>
                    <a href="<?= SITE_URL ?>/admin/newsletter.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-envelope mr-3"></i>
                        Newsletter
                    </a>
                    <a href="<?= SITE_URL ?>/admin/settings.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-cog mr-3"></i>
                        Paramètres
                    </a>
                </nav>
                
                <div class="mt-8 pt-8 border-t border-gray-700">
                    <a href="<?= SITE_URL ?>" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-external-link-alt mr-3"></i>
                        Voir le site
                    </a>
                    <a href="<?= SITE_URL ?>/logout.php" class="flex items-center px-4 py-3 text-red-400 hover:bg-red-900/20 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Déconnexion
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0 min-w-0">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-4 lg:px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Mobile menu button -->
                    <button class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                        <p class="text-gray-600">Bienvenue dans l'espace d'administration</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">
                            Connecté en tant que <strong>Admin</strong>
                        </span>
                        <div class="w-8 h-8 bg-orange-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-4 lg:p-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="stat-card bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Articles</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $stats['articles'] ?></p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-newspaper text-blue-600"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Catégories</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $stats['categories'] ?></p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tags text-green-600"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Formations</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $stats['formations'] ?></p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-purple-600"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stat-card bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Abonnés Newsletter</p>
                                <p class="text-2xl font-bold text-gray-900"><?= $stats['newsletter'] ?></p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-orange-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Articles -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Articles récents</h2>
                            <a href="<?= SITE_URL ?>/admin/articles.php" class="text-orange-600 hover:text-orange-700 text-sm font-medium">
                                Voir tous
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <?php if (empty($recentArticles)): ?>
                            <p class="text-gray-500 text-center py-8">Aucun article trouvé</p>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($recentArticles as $article): ?>
                                <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <img src="<?= escape($article['image_url']) ?>" 
                                         alt="<?= escape($article['titre']) ?>" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-900"><?= escape($article['titre']) ?></h3>
                                        <p class="text-sm text-gray-600"><?= escape($article['categorie_nom']) ?></p>
                                        <p class="text-xs text-gray-500"><?= formatDate($article['created_at']) ?></p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 text-xs rounded-full <?= $article['actif'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                            <?= $article['actif'] ? 'Publié' : 'Brouillon' ?>
                                        </span>
                                        <a href="<?= SITE_URL ?>/admin/articles.php?action=edit&id=<?= $article['id'] ?>" 
                                           class="text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
    // Toggle sidebar for mobile
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const menuButton = e.target.closest('button');
        
        if (window.innerWidth < 1024 && 
            !sidebar.contains(e.target) && 
            !menuButton?.onclick?.toString().includes('toggleSidebar')) {
            sidebar.classList.add('-translate-x-full');
        }
    });
    </script>

</body>
</html>
