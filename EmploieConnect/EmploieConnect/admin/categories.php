<?php
require_once '../config/config.php';
require_once '../core/functions.php';
require_once '../models/Category.php';

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isAdmin()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit;
}

// Connexion à la base de données
$pdo = getDatabase();
$categoryModel = new Category($pdo);

// Gestion des actions
$action = $_GET['action'] ?? 'list';
$message = '';

if ($_POST) {
    if ($action === 'create' || $action === 'edit') {
        $data = [
            'nom' => $_POST['nom'],
            'slug' => generateSlug($_POST['nom']),
            'description' => $_POST['description'],
            'couleur' => $_POST['couleur'],
            'icone' => $_POST['icone']
        ];
        
        if ($action === 'create') {
            if ($categoryModel->create($data)) {
                setFlashMessage('Catégorie créée avec succès', 'success');
                header('Location: ' . SITE_URL . '/admin/categories.php');
                exit;
            } else {
                $message = 'Erreur lors de la création de la catégorie';
            }
        } else {
            $id = $_GET['id'];
            if ($categoryModel->update($id, $data)) {
                setFlashMessage('Catégorie mise à jour avec succès', 'success');
                header('Location: ' . SITE_URL . '/admin/categories.php');
                exit;
            } else {
                $message = 'Erreur lors de la mise à jour de la catégorie';
            }
        }
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    if ($categoryModel->delete($_GET['id'])) {
        setFlashMessage('Catégorie supprimée avec succès', 'success');
    } else {
        setFlashMessage('Erreur lors de la suppression', 'error');
    }
    header('Location: ' . SITE_URL . '/admin/categories.php');
    exit;
}

// Récupération des données
$categories = $categoryModel->getAll();

if ($action === 'edit' && isset($_GET['id'])) {
    $category = $categoryModel->getById($_GET['id']);
    if (!$category) {
        header('Location: ' . SITE_URL . '/admin/categories.php');
        exit;
    }
}

$pageTitle = 'Gestion des Catégories - Admin';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    
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
                    <a href="<?= SITE_URL ?>/admin/" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-home mr-3"></i>
                        Dashboard
                    </a>
                    <a href="<?= SITE_URL ?>/admin/articles.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-newspaper mr-3"></i>
                        Articles
                    </a>
                    <a href="<?= SITE_URL ?>/admin/categories.php" class="flex items-center px-4 py-3 bg-orange-600 rounded-lg text-white">
                        <i class="fas fa-tags mr-3"></i>
                        Catégories
                    </a>
                    <a href="<?= SITE_URL ?>/admin/formations.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
                        <i class="fas fa-graduation-cap mr-3"></i>
                        Formations
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
                        <h1 class="text-2xl font-bold text-gray-900">
                            <?php if ($action === 'create'): ?>
                                Nouvelle Catégorie
                            <?php elseif ($action === 'edit'): ?>
                                Modifier la Catégorie
                            <?php else: ?>
                                Gestion des Catégories
                            <?php endif; ?>
                        </h1>
                        <p class="text-gray-600">
                            <?php if ($action === 'list'): ?>
                                Organisez vos articles par catégories
                            <?php else: ?>
                                Créez ou modifiez une catégorie
                            <?php endif; ?>
                        </p>
                    </div>
                    <?php if ($action === 'list'): ?>
                    <a href="<?= SITE_URL ?>/admin/categories.php?action=create" 
                       class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvelle Catégorie
                    </a>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Content -->
            <main class="p-4 lg:p-6">
                <?php if ($message): ?>
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <?= escape($message) ?>
                </div>
                <?php endif; ?>

                <?php if ($action === 'list'): ?>
                <!-- Categories Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($categories as $category): ?>
                    <div class="bg-white rounded-lg shadow p-6 border-l-4" style="border-left-color: <?= escape($category['couleur']) ?>">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: <?= escape($category['couleur']) ?>20">
                                    <i class="<?= escape($category['icone']) ?>" style="color: <?= escape($category['couleur']) ?>"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900"><?= escape($category['nom']) ?></h3>
                                    <p class="text-sm text-gray-500"><?= $category['article_count'] ?> articles</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="<?= SITE_URL ?>/admin/categories.php?action=edit&id=<?= $category['id'] ?>" 
                                   class="text-orange-600 hover:text-orange-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= SITE_URL ?>/admin/categories.php?action=delete&id=<?= $category['id'] ?>" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')"
                                   class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm"><?= escape($category['description']) ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php else: ?>
                <!-- Category Form -->
                <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
                    <form method="POST" class="space-y-6">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom de la catégorie</label>
                            <input type="text" id="nom" name="nom" required
                                   value="<?= $action === 'edit' ? escape($category['nom']) : '' ?>"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500"><?= $action === 'edit' ? escape($category['description']) : '' ?></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="couleur" class="block text-sm font-medium text-gray-700 mb-2">Couleur</label>
                                <input type="color" id="couleur" name="couleur" required
                                       value="<?= $action === 'edit' ? escape($category['couleur']) : '#f97316' ?>"
                                       class="w-full h-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            
                            <div>
                                <label for="icone" class="block text-sm font-medium text-gray-700 mb-2">Icône (Font Awesome)</label>
                                <input type="text" id="icone" name="icone" placeholder="fas fa-briefcase"
                                       value="<?= $action === 'edit' ? escape($category['icone']) : '' ?>"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <p class="text-xs text-gray-500 mt-1">Exemple: fas fa-briefcase, fas fa-graduation-cap</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <button type="submit" 
                                    class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg transition-colors">
                                <?= $action === 'edit' ? 'Mettre à jour' : 'Créer la catégorie' ?>
                            </button>
                            <a href="<?= SITE_URL ?>/admin/categories.php" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
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
