<?php
require_once '../config/config.php';
require_once '../core/functions.php';
require_once '../models/Article.php';
require_once '../models/Category.php';

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isAdmin()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit;
}

// Connexion à la base de données
$pdo = getDatabase();
$articleModel = new Article($pdo);
$categoryModel = new Category($pdo);

// Gestion des actions
$action = $_GET['action'] ?? 'list';
$message = '';

if ($_POST) {
    if ($action === 'create' || $action === 'edit') {
        $data = [
            'titre' => $_POST['titre'],
            'slug' => generateSlug($_POST['titre']),
            'contenu' => $_POST['contenu'],
            'extrait' => $_POST['extrait'],
            'image_url' => $_POST['image_url'],
            'categorie_id' => $_POST['categorie_id'],
            'statut' => $_POST['statut'],
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'meta_description' => $_POST['meta_description'],
            'temps_lecture' => $_POST['temps_lecture']
        ];
        
        if ($action === 'create') {
            $data['date_creation'] = date('Y-m-d H:i:s');
            if ($articleModel->create($data)) {
                setFlashMessage('Article créé avec succès', 'success');
                header('Location: ' . SITE_URL . '/admin/articles.php');
                exit;
            } else {
                $message = 'Erreur lors de la création de l\'article';
            }
        } else {
            $id = $_GET['id'];
            if ($articleModel->update($id, $data)) {
                setFlashMessage('Article mis à jour avec succès', 'success');
                header('Location: ' . SITE_URL . '/admin/articles.php');
                exit;
            } else {
                $message = 'Erreur lors de la mise à jour de l\'article';
            }
        }
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    if ($articleModel->delete($_GET['id'])) {
        setFlashMessage('Article supprimé avec succès', 'success');
    } else {
        setFlashMessage('Erreur lors de la suppression', 'error');
    }
    header('Location: ' . SITE_URL . '/admin/articles.php');
    exit;
}

// Récupération des données
$articles = $articleModel->getAll();
$categories = $categoryModel->getAll();

if ($action === 'edit' && isset($_GET['id'])) {
    $article = $articleModel->getById($_GET['id']);
    if (!$article) {
        header('Location: ' . SITE_URL . '/admin/articles.php');
        exit;
    }
}

$pageTitle = 'Gestion des Articles - Admin';
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
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
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
                    <a href="<?= SITE_URL ?>/admin/articles.php" class="flex items-center px-4 py-3 bg-orange-600 rounded-lg text-white">
                        <i class="fas fa-newspaper mr-3"></i>
                        Articles
                    </a>
                    <a href="<?= SITE_URL ?>/admin/categories.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
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
                                Nouvel Article
                            <?php elseif ($action === 'edit'): ?>
                                Modifier l'Article
                            <?php else: ?>
                                Gestion des Articles
                            <?php endif; ?>
                        </h1>
                        <p class="text-gray-600">
                            <?php if ($action === 'list'): ?>
                                Gérez tous vos articles de blog
                            <?php else: ?>
                                Créez ou modifiez un article
                            <?php endif; ?>
                        </p>
                    </div>
                    <?php if ($action === 'list'): ?>
                    <a href="<?= SITE_URL ?>/admin/articles.php?action=create" 
                       class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvel Article
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
                <!-- Articles List -->
                <!-- Version mobile : cartes -->
                <div class="lg:hidden space-y-4">
                    <?php foreach ($articles as $article): ?>
                    <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                        <div class="flex items-start space-x-4">
                            <img src="<?= escape($article['image_url']) ?>" 
                                 alt="<?= escape($article['titre']) ?>" 
                                 class="w-16 h-16 object-cover rounded-lg flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-medium text-gray-900 truncate">
                                    <?= escape($article['titre']) ?>
                                </h3>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                    <?= escape(substr($article['extrait'], 0, 80)) ?>...
                                </p>
                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex flex-col space-y-1">
                                        <span class="text-xs text-gray-600">
                                            <?= escape($article['categorie_nom']) ?>
                                        </span>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $article['actif'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                                <?= $article['actif'] ? 'Publié' : 'Brouillon' ?>
                                            </span>
                                            <?php if ($article['vedette']): ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                                Vedette
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="<?= SITE_URL ?>/article.php?slug=<?= escape($article['slug']) ?>" 
                                           target="_blank"
                                           class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="<?= SITE_URL ?>/admin/articles.php?action=edit&id=<?= $article['id'] ?>" 
                                           class="p-2 text-orange-600 hover:text-orange-900 hover:bg-orange-50 rounded-lg transition-colors">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <a href="<?= SITE_URL ?>/admin/articles.php?action=delete&id=<?= $article['id'] ?>" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')"
                                           class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors">
                                            <i class="fas fa-trash text-sm"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-400 mt-2">
                                    <?= formatDate($article['created_at']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Version desktop : tableau -->
                <div class="hidden lg:block bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 xl:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[300px]">Article</th>
                                    <th class="px-4 xl:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">Catégorie</th>
                                    <th class="px-4 xl:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[140px]">Statut</th>
                                    <th class="px-4 xl:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">Date</th>
                                    <th class="px-4 xl:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[120px]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($articles as $article): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 xl:px-6 py-4">
                                        <div class="flex items-center">
                                            <img src="<?= escape($article['image_url']) ?>" 
                                                 alt="<?= escape($article['titre']) ?>" 
                                                 class="w-12 h-12 object-cover rounded-lg mr-4 flex-shrink-0">
                                            <div class="min-w-0 flex-1">
                                                <div class="text-sm font-medium text-gray-900 truncate max-w-[200px]">
                                                    <?= escape($article['titre']) ?>
                                                </div>
                                                <div class="text-sm text-gray-500 truncate max-w-[200px]">
                                                    <?= escape(substr($article['extrait'], 0, 60)) ?>...
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 xl:px-6 py-4 text-sm text-gray-900">
                                        <span class="truncate block max-w-[100px]">
                                            <?= escape($article['categorie_nom']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 xl:px-6 py-4">
                                        <div class="flex flex-col space-y-1">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $article['actif'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                                <?= $article['actif'] ? 'Publié' : 'Brouillon' ?>
                                            </span>
                                            <?php if ($article['vedette']): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                Vedette
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-4 xl:px-6 py-4 text-sm text-gray-500">
                                        <span class="whitespace-nowrap">
                                            <?= formatDate($article['created_at']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 xl:px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="<?= SITE_URL ?>/article.php?slug=<?= escape($article['slug']) ?>" 
                                               target="_blank"
                                               class="p-2 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors"
                                               title="Voir l'article">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= SITE_URL ?>/admin/articles.php?action=edit&id=<?= $article['id'] ?>" 
                                               class="p-2 text-orange-600 hover:text-orange-900 hover:bg-orange-50 rounded-lg transition-colors"
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= SITE_URL ?>/admin/articles.php?action=delete&id=<?= $article['id'] ?>" 
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')"
                                               class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors"
                                               title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php else: ?>
                <!-- Article Form -->
                <div class="bg-white rounded-lg shadow p-4 lg:p-6 max-w-none overflow-hidden">
                    <form method="POST" class="space-y-6">
                        <!-- Titre et Catégorie -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <div class="lg:col-span-2">
                                <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-heading mr-2 text-orange-500"></i>Titre *
                                </label>
                                <input type="text" id="titre" name="titre" required
                                       value="<?= $action === 'edit' ? escape($article['titre']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                       placeholder="Entrez le titre de l'article">
                            </div>
                            
                            <div>
                                <label for="categorie_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-2 text-orange-500"></i>Catégorie *
                                </label>
                                <select id="categorie_id" name="categorie_id" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                    <option value="">Sélectionner une catégorie</option>
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" 
                                            <?= ($action === 'edit' && isset($article['categorie_id']) && $article['categorie_id'] == $category['id']) ? 'selected' : '' ?>>
                                        <?= escape($category['nom']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label for="extrait" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-2 text-orange-500"></i>Extrait *
                            </label>
                            <textarea id="extrait" name="extrait" rows="3" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 resize-none"
                                      placeholder="Résumé court de l'article (150-200 caractères)"><?= $action === 'edit' ? escape($article['extrait']) : '' ?></textarea>
                            <div class="text-sm text-gray-500 mt-1">
                                <span id="extrait-count">0</span>/200 caractères
                            </div>
                        </div>
                        
                        <div>
                            <label for="contenu" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-file-alt mr-2 text-orange-500"></i>Contenu *
                            </label>
                            <textarea id="contenu" name="contenu" rows="15" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Rédigez le contenu complet de votre article..."><?= $action === 'edit' ? escape($article['contenu']) : '' ?></textarea>
                        </div>
                        
                        <!-- Image et Temps de lecture -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-image mr-2 text-orange-500"></i>URL de l'image *
                                </label>
                                <input type="url" id="image_url" name="image_url" required
                                       value="<?= $action === 'edit' ? escape($article['image_url']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                       placeholder="https://exemple.com/image.jpg">
                            </div>
                            
                            <div>
                                <label for="temps_lecture" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-clock mr-2 text-orange-500"></i>Temps de lecture
                                </label>
                                <input type="text" id="temps_lecture" name="temps_lecture" placeholder="5 min"
                                       value="<?= $action === 'edit' ? escape($article['temps_lecture']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                        
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-search mr-2 text-orange-500"></i>Meta Description (SEO)
                            </label>
                            <textarea id="meta_description" name="meta_description" rows="2"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200 resize-none"
                                      placeholder="Description pour les moteurs de recherche (150-160 caractères)"><?= $action === 'edit' ? escape($article['meta_description']) : '' ?></textarea>
                            <div class="text-sm text-gray-500 mt-1">
                                <span id="meta-count">0</span>/160 caractères
                            </div>
                        </div>
                        
                        <!-- Paramètres de publication -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-cogs mr-2 text-orange-500"></i>Paramètres de publication
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                                <div class="sm:col-span-1">
                                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-eye mr-2 text-gray-500"></i>Statut *
                                    </label>
                                    <select id="statut" name="statut" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                        <option value="brouillon" <?= ($action === 'edit' && isset($article['statut']) && $article['statut'] === 'brouillon') ? 'selected' : '' ?>>
                                            Brouillon
                                        </option>
                                        <option value="publie" <?= ($action === 'edit' && isset($article['statut']) && $article['statut'] === 'publie') ? 'selected' : '' ?>>
                                            Publié
                                        </option>
                                    </select>
                                </div>
                                
                                <div class="flex items-end">
                                    <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200 w-full">
                                        <input type="checkbox" id="featured" name="featured" value="1"
                                               <?= ($action === 'edit' && isset($article['featured']) && $article['featured']) ? 'checked' : '' ?>
                                               class="w-5 h-5 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                                        <label for="featured" class="ml-3 text-sm font-medium text-gray-700">
                                            <i class="fas fa-star mr-2 text-yellow-500"></i>Article en vedette
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                                <button type="submit" 
                                        class="w-full sm:w-auto bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold px-8 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <i class="fas <?= $action === 'edit' ? 'fa-save' : 'fa-plus' ?> mr-2"></i>
                                    <?= $action === 'edit' ? 'Mettre à jour' : 'Créer l\'article' ?>
                                </button>
                                <a href="<?= SITE_URL ?>/admin/articles.php" 
                                   class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-8 py-3 rounded-lg transition-all duration-300 text-center">
                                    <i class="fas fa-times mr-2"></i>Annuler
                                </a>
                            </div>
                            <?php if ($action === 'edit'): ?>
                            <div class="text-sm text-gray-500">
                                Dernière modification : <?= formatDate($article['updated_at'] ?? $article['created_at']) ?>
                            </div>
                            <?php endif; ?>
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

    // Character counters
    function updateCharacterCount(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        
        function updateCount() {
            const length = input.value.length;
            counter.textContent = length;
            
            if (length > maxLength) {
                counter.parentElement.classList.add('text-red-500');
                counter.parentElement.classList.remove('text-gray-500');
            } else {
                counter.parentElement.classList.add('text-gray-500');
                counter.parentElement.classList.remove('text-red-500');
            }
        }
        
        input.addEventListener('input', updateCount);
        updateCount(); // Initial count
    }

    // Initialize character counters
    document.addEventListener('DOMContentLoaded', function() {
        updateCharacterCount('extrait', 'extrait-count', 200);
        updateCharacterCount('meta_description', 'meta-count', 160);
        
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
    });
    </script>

</body>
</html>
