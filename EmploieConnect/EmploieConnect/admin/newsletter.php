<?php
require_once '../config/config.php';
require_once '../core/functions.php';

// Vérifier si l'utilisateur est connecté
if (!isLoggedIn()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit;
}

// Connexion à la base de données
$pdo = getDatabase();

// Gestion des actions
$action = $_GET['action'] ?? 'list';
$message = '';

if ($_POST) {
    if ($action === 'delete' && isset($_POST['email'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM newsletter WHERE email = ?");
            $stmt->execute([$_POST['email']]);
            setFlashMessage('Abonné supprimé avec succès', 'success');
            header('Location: ' . SITE_URL . '/admin/newsletter.php');
            exit;
        } catch (Exception $e) {
            $message = 'Erreur lors de la suppression';
        }
    }
    
    if ($action === 'export') {
        try {
            $stmt = $pdo->query("SELECT email, created_at FROM newsletter ORDER BY created_at DESC");
            $subscribers = $stmt->fetchAll();
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="newsletter_subscribers_' . date('Y-m-d') . '.csv"');
            
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Email', 'Date d\'inscription']);
            
            foreach ($subscribers as $subscriber) {
                fputcsv($output, [$subscriber['email'], $subscriber['created_at']]);
            }
            
            fclose($output);
            exit;
        } catch (Exception $e) {
            $message = 'Erreur lors de l\'export';
        }
    }
}

// Récupération des statistiques
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM newsletter");
    $totalSubscribers = $stmt->fetch()['total'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as today FROM newsletter WHERE DATE(created_at) = CURDATE()");
    $todaySubscribers = $stmt->fetch()['today'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as week FROM newsletter WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $weekSubscribers = $stmt->fetch()['week'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as month FROM newsletter WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $monthSubscribers = $stmt->fetch()['month'];
} catch (Exception $e) {
    $totalSubscribers = $todaySubscribers = $weekSubscribers = $monthSubscribers = 0;
}

// Récupération des abonnés
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

try {
    $stmt = $pdo->prepare("SELECT email, created_at FROM newsletter ORDER BY created_at DESC LIMIT ? OFFSET ?");
    $stmt->execute([$limit, $offset]);
    $subscribers = $stmt->fetchAll();
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM newsletter");
    $totalPages = ceil($stmt->fetch()['total'] / $limit);
} catch (Exception $e) {
    $subscribers = [];
    $totalPages = 0;
}

$pageTitle = 'Gestion Newsletter - Admin';
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
    </style>
</head>
<body class="bg-gray-100">

    <div class="flex">
        <!-- Sidebar -->
        <div class="admin-sidebar w-64 bg-gray-900 text-white fixed left-0 top-0 z-50">
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
                    <a href="<?= SITE_URL ?>/admin/formations.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-graduation-cap mr-3"></i>
                        Formations
                    </a>
                    <a href="<?= SITE_URL ?>/admin/newsletter.php" class="flex items-center px-4 py-3 bg-orange-600 rounded-lg text-white">
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
        <div class="flex-1 ml-64">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Gestion Newsletter</h1>
                        <p class="text-gray-600">Gérez vos abonnés et suivez les statistiques</p>
                    </div>
                    <form method="POST" action="<?= SITE_URL ?>/admin/newsletter.php?action=export" class="inline">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-download mr-2"></i>
                            Exporter CSV
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                <?php if ($message): ?>
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <?= escape($message) ?>
                </div>
                <?php endif; ?>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Abonnés</p>
                                <p class="text-2xl font-bold text-gray-900"><?= number_format($totalSubscribers) ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-day text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Aujourd'hui</p>
                                <p class="text-2xl font-bold text-gray-900"><?= number_format($todaySubscribers) ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-week text-orange-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Cette Semaine</p>
                                <p class="text-2xl font-bold text-gray-900"><?= number_format($weekSubscribers) ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Ce Mois</p>
                                <p class="text-2xl font-bold text-gray-900"><?= number_format($monthSubscribers) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subscribers Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Liste des Abonnés</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date d'inscription
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($subscribers as $subscriber): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-envelope text-orange-600 text-sm"></i>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900"><?= escape($subscriber['email']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('d/m/Y H:i', strtotime($subscriber['created_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form method="POST" action="<?= SITE_URL ?>/admin/newsletter.php?action=delete" class="inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet abonné ?')">
                                            <input type="hidden" name="email" value="<?= escape($subscriber['email']) ?>">
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <?php if (empty($subscribers)): ?>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                        Aucun abonné trouvé
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <?php if ($page > 1): ?>
                            <a href="<?= SITE_URL ?>/admin/newsletter.php?page=<?= $page - 1 ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Précédent
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($page < $totalPages): ?>
                            <a href="<?= SITE_URL ?>/admin/newsletter.php?page=<?= $page + 1 ?>" 
                               class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Suivant
                            </a>
                            <?php endif; ?>
                        </div>
                        
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Page <span class="font-medium"><?= $page ?></span> sur <span class="font-medium"><?= $totalPages ?></span>
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                    <?php if ($page > 1): ?>
                                    <a href="<?= SITE_URL ?>/admin/newsletter.php?page=<?= $page - 1 ?>" 
                                       class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                    <a href="<?= SITE_URL ?>/admin/newsletter.php?page=<?= $i ?>" 
                                       class="relative inline-flex items-center px-4 py-2 border text-sm font-medium <?= $i === $page ? 'bg-orange-50 border-orange-500 text-orange-600' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50' ?>">
                                        <?= $i ?>
                                    </a>
                                    <?php endfor; ?>
                                    
                                    <?php if ($page < $totalPages): ?>
                                    <a href="<?= SITE_URL ?>/admin/newsletter.php?page=<?= $page + 1 ?>" 
                                       class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    <?php endif; ?>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
