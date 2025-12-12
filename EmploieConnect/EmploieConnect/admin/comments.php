<?php
require_once '../config/config.php';
require_once '../core/functions.php';
require_once '../models/Comment.php';

// Vérifier si l'utilisateur est admin
if (!isAdmin()) {
    redirect(SITE_URL . '/login.php');
}

$pdo = getDatabase();
$commentModel = new Comment($pdo);

$success = '';
$error = '';

// Gestion des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = cleanInput($_POST['action'] ?? '');
    $commentId = (int)($_POST['comment_id'] ?? 0);
    
    switch ($action) {
        case 'approve':
            if ($commentModel->updateStatus($commentId, 'approved')) {
                $success = 'Commentaire approuvé avec succès.';
            } else {
                $error = 'Erreur lors de l\'approbation du commentaire.';
            }
            break;
            
        case 'reject':
            if ($commentModel->updateStatus($commentId, 'rejected')) {
                $success = 'Commentaire rejeté avec succès.';
            } else {
                $error = 'Erreur lors du rejet du commentaire.';
            }
            break;
            
        case 'delete':
            if ($commentModel->delete($commentId)) {
                $success = 'Commentaire supprimé avec succès.';
            } else {
                $error = 'Erreur lors de la suppression du commentaire.';
            }
            break;
    }
}

// Pagination
$page = (int)($_GET['page'] ?? 1);
$limit = 20;
$offset = ($page - 1) * $limit;

// Filtres
$status = cleanInput($_GET['status'] ?? 'all');

// Récupération des commentaires
if ($status === 'pending') {
    $comments = $commentModel->getPending($limit, $offset);
} else {
    // Pour l'instant, on utilise getPending, mais il faudrait une méthode getAll avec filtres
    $comments = $commentModel->getPending($limit, $offset);
}

// Statistiques
$stats = $commentModel->getStats();

$pageTitle = 'Gestion des Commentaires - Admin';
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
                    <a href="<?= SITE_URL ?>/admin/" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
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
                    <a href="<?= SITE_URL ?>/admin/comments.php" class="flex items-center px-4 py-3 bg-orange-600 rounded-lg text-white">
                        <i class="fas fa-comments mr-3"></i>
                        Commentaires
                    </a>
                    <a href="<?= SITE_URL ?>/admin/formations.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
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
                    <a href="<?= SITE_URL ?>/admin/newsletter.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
                        <i class="fas fa-envelope mr-3"></i>
                        Newsletter
                    </a>
                </nav>
            </div>
            
            <div class="absolute bottom-0 w-full p-6">
                <a href="<?= SITE_URL ?>/logout.php" class="flex items-center px-4 py-2 text-red-400 hover:bg-red-900 rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Déconnexion
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center">
                        <button class="lg:hidden text-gray-600 mr-4" onclick="toggleSidebar()">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-2xl font-bold text-gray-900">Gestion des Commentaires</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">
                            Connecté en tant que <strong><?= escape($_SESSION['username']) ?></strong>
                        </span>
                        <a href="<?= SITE_URL ?>" class="text-orange-600 hover:text-orange-700 transition-colors" title="Voir le site">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
            <!-- Messages -->
            <?php if ($success): ?>
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-green-700 dark:text-green-400"><?= escape($success) ?></span>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="text-red-700 dark:text-red-400"><?= escape($error) ?></span>
                </div>
            </div>
            <?php endif; ?>

            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <i class="fas fa-comments text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-gray-900"><?= number_format($stats['total']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-lg">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Approuvés</p>
                            <p class="text-2xl font-bold text-gray-900"><?= number_format($stats['approved']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-lg">
                            <i class="fas fa-clock text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">En attente</p>
                            <p class="text-2xl font-bold text-gray-900"><?= number_format($stats['pending']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-lg">
                            <i class="fas fa-calendar-day text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Aujourd'hui</p>
                            <p class="text-2xl font-bold text-gray-900"><?= number_format($stats['today']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtres -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700">Statut:</label>
                        <select onchange="window.location.href='?status=' + this.value" 
                                class="px-3 py-2 border border-gray-300 bg-white text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>Tous</option>
                            <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>En attente</option>
                            <option value="approved" <?= $status === 'approved' ? 'selected' : '' ?>>Approuvés</option>
                            <option value="rejected" <?= $status === 'rejected' ? 'selected' : '' ?>>Rejetés</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Liste des commentaires -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Commentaires en attente de modération
                    </h3>
                </div>

                <?php if (!empty($comments)): ?>
                <div class="divide-y divide-gray-200">
                    <?php foreach ($comments as $comment): ?>
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4 mb-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-orange-600 text-sm"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900">
                                                <?= escape($comment['author_name']) ?>
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                <?= escape($comment['author_email']) ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?= formatDate($comment['created_at']) ?>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <p class="text-sm text-gray-600 mb-2">
                                        Article: <strong><?= escape($comment['article_title']) ?></strong>
                                    </p>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <p class="text-gray-700">
                                            <?= nl2br(escape($comment['content'])) ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        <?= $comment['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($comment['status'] === 'approved' ? 'bg-green-100 text-green-800' : 
                                            'bg-red-100 text-red-800') ?>">
                                        <?= ucfirst($comment['status']) ?>
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 ml-4">
                                <?php if ($comment['status'] === 'pending'): ?>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="action" value="approve">
                                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                    <button type="submit" 
                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition-colors"
                                            onclick="return confirm('Approuver ce commentaire ?')">
                                        <i class="fas fa-check mr-1"></i>
                                        Approuver
                                    </button>
                                </form>

                                <form method="POST" class="inline">
                                    <input type="hidden" name="action" value="reject">
                                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg transition-colors"
                                            onclick="return confirm('Rejeter ce commentaire ?')">
                                        <i class="fas fa-times mr-1"></i>
                                        Rejeter
                                    </button>
                                </form>
                                <?php endif; ?>

                                <form method="POST" class="inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                    <button type="submit" 
                                            class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white text-sm rounded-lg transition-colors"
                                            onclick="return confirm('Supprimer définitivement ce commentaire ?')">
                                        <i class="fas fa-trash mr-1"></i>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="p-12 text-center">
                    <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucun commentaire en attente</p>
                </div>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('show');
}

// Fermer la sidebar sur mobile quand on clique en dehors
document.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = event.target.closest('button');
    
    if (!sidebar.contains(event.target) && !toggleBtn && window.innerWidth < 1024) {
        sidebar.classList.remove('show');
    }
});
</script>

</body>
</html>
