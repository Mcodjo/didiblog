<?php
require_once '../config/config.php';
require_once '../core/functions.php';

// Vérification de l'authentification admin
if (!isLoggedIn() || !isAdmin()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit;
}

$pdo = getDatabase();
$success = '';
$error = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_status') {
        $id = (int)($_POST['id'] ?? 0);
        $statut = cleanInput($_POST['statut'] ?? '');
        
        if (in_array($statut, ['en_attente', 'approuve', 'rejete'])) {
            try {
                $stmt = $pdo->prepare("UPDATE testimonials SET statut = :statut WHERE id = :id");
                $stmt->execute([':statut' => $statut, ':id' => $id]);
                
                $success = 'Statut du témoignage mis à jour avec succès !';
            } catch (Exception $e) {
                $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
            }
        }
    }
    
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        
        try {
            $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = :id");
            $stmt->execute([':id' => $id]);
            
            $success = 'Témoignage supprimé avec succès !';
        } catch (Exception $e) {
            $error = 'Erreur lors de la suppression : ' . $e->getMessage();
        }
    }
}

// Filtres
$filter = $_GET['filter'] ?? 'tous';
$whereClause = '';
$params = [];

switch ($filter) {
    case 'en_attente':
        $whereClause = 'WHERE statut = :statut';
        $params[':statut'] = 'en_attente';
        break;
    case 'approuve':
        $whereClause = 'WHERE statut = :statut';
        $params[':statut'] = 'approuve';
        break;
    case 'rejete':
        $whereClause = 'WHERE statut = :statut';
        $params[':statut'] = 'rejete';
        break;
}

// Récupération des témoignages
try {
    $stmt = $pdo->prepare("SELECT * FROM testimonials $whereClause ORDER BY created_at DESC");
    $stmt->execute($params);
    $testimonials = $stmt->fetchAll();
    
    // Statistiques
    $statsStmt = $pdo->prepare("SELECT statut, COUNT(*) as count FROM testimonials GROUP BY statut");
    $statsStmt->execute();
    $stats = [];
    while ($row = $statsStmt->fetch()) {
        $stats[$row['statut']] = $row['count'];
    }
} catch (Exception $e) {
    $testimonials = [];
    $stats = [];
    $error = 'Erreur lors du chargement des témoignages : ' . $e->getMessage();
}

$pageTitle = 'Gestion Témoignages - Admin';
?>

<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= escape($pageTitle) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        orange: {
                            50: '#fff7ed',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900">
    <div class="flex h-full">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
                <div class="flex items-center flex-shrink-0 px-4">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                        <i class="fas fa-cog text-orange-600 mr-2"></i>
                        Admin Panel
                    </h1>
                </div>
                <div class="mt-8 flex-grow flex flex-col">
                    <nav class="flex-1 px-2 space-y-1">
                        <a href="<?= SITE_URL ?>/admin/dashboard.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-home mr-3"></i>Dashboard
                        </a>
                        <a href="<?= SITE_URL ?>/admin/articles.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-newspaper mr-3"></i>Articles
                        </a>
                        <a href="<?= SITE_URL ?>/admin/about.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-user mr-3"></i>À Propos
                        </a>
                        <a href="<?= SITE_URL ?>/admin/coach-images.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-images mr-3"></i>Images Coach
                        </a>
                        <a href="<?= SITE_URL ?>/admin/testimonials.php" class="bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-200 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-quote-left mr-3"></i>Témoignages
                        </a>
                        <a href="<?= SITE_URL ?>/admin/settings.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-cog mr-3"></i>Paramètres
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow border-b border-gray-200 dark:border-gray-700">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                <i class="fas fa-quote-left text-orange-600 mr-2"></i>
                                Gestion Témoignages
                            </h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="<?= SITE_URL ?>/" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <i class="fas fa-external-link-alt mr-2"></i>Voir le site
                            </a>
                            <a href="<?= SITE_URL ?>/logout.php" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenu -->
            <main class="flex-1 overflow-y-auto p-6">
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
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <i class="fas fa-quote-left text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= array_sum($stats) ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                                <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">En attente</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $stats['en_attente'] ?? 0 ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                                <i class="fas fa-check text-green-600 dark:text-green-400"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Approuvés</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $stats['approuve'] ?? 0 ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="p-2 bg-red-100 dark:bg-red-900 rounded-lg">
                                <i class="fas fa-times text-red-600 dark:text-red-400"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rejetés</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $stats['rejete'] ?? 0 ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtres -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 mb-6">
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2">
                            <a href="?filter=tous" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium <?= $filter === 'tous' ? 'bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' ?>">
                                Tous
                            </a>
                            <a href="?filter=en_attente" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium <?= $filter === 'en_attente' ? 'bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' ?>">
                                <i class="fas fa-clock mr-2"></i>En attente
                            </a>
                            <a href="?filter=approuve" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium <?= $filter === 'approuve' ? 'bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' ?>">
                                <i class="fas fa-check mr-2"></i>Approuvés
                            </a>
                            <a href="?filter=rejete" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium <?= $filter === 'rejete' ? 'bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' ?>">
                                <i class="fas fa-times mr-2"></i>Rejetés
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Liste des témoignages -->
                <div class="space-y-6">
                    <?php if (empty($testimonials)): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                        <div class="p-8 text-center">
                            <i class="fas fa-quote-left text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">Aucun témoignage trouvé pour ce filtre.</p>
                        </div>
                    </div>
                    <?php else: ?>
                    <?php foreach ($testimonials as $testimonial): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                                        <span class="text-orange-600 dark:text-orange-400 font-semibold text-lg">
                                            <?= strtoupper(substr($testimonial['nom'], 0, 1)) ?>
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white"><?= escape($testimonial['nom']) ?></h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <?= escape($testimonial['poste']) ?><?= $testimonial['entreprise'] ? ' chez ' . escape($testimonial['entreprise']) : '' ?>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500"><?= escape($testimonial['email']) ?></p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <div class="flex text-yellow-400">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star<?= $i <= $testimonial['note'] ? '' : '-o' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full <?= 
                                        $testimonial['statut'] === 'approuve' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 
                                        ($testimonial['statut'] === 'rejete' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : 
                                        'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200') ?>">
                                        <?= ucfirst(str_replace('_', ' ', $testimonial['statut'])) ?>
                                    </span>
                                </div>
                            </div>
                            
                            <blockquote class="text-gray-700 dark:text-gray-300 mb-4 italic">
                                "<?= escape($testimonial['message']) ?>"
                            </blockquote>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span>Reçu le <?= date('d/m/Y à H:i', strtotime($testimonial['created_at'])) ?></span>
                                <span>IP: <?= escape($testimonial['ip_address']) ?></span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <form method="POST" class="flex items-center space-x-2">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="id" value="<?= $testimonial['id'] ?>">
                                    <select name="statut" onchange="this.form.submit()" class="px-3 py-1 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded focus:outline-none focus:ring-2 focus:ring-orange-500">
                                        <option value="en_attente" <?= $testimonial['statut'] === 'en_attente' ? 'selected' : '' ?>>En attente</option>
                                        <option value="approuve" <?= $testimonial['statut'] === 'approuve' ? 'selected' : '' ?>>Approuver</option>
                                        <option value="rejete" <?= $testimonial['statut'] === 'rejete' ? 'selected' : '' ?>>Rejeter</option>
                                    </select>
                                </form>
                                
                                <button type="button" onclick="deleteTestimonial(<?= $testimonial['id'] ?>)" class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded">
                                    <i class="fas fa-trash mr-1"></i>Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Form de suppression caché -->
    <form id="deleteForm" method="POST" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" id="deleteId">
    </form>

    <script>
        function deleteTestimonial(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce témoignage ?')) {
                document.getElementById('deleteId').value = id;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>
