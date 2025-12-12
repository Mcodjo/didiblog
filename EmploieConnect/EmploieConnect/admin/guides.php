<?php
require_once '../config/config.php';
require_once '../core/functions.php';

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isAdmin()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit;
}

// Connexion à la base de données
$pdo = getDatabase();

// Gestion des actions
$action = $_GET['action'] ?? 'list';
$message = '';

if ($_POST) {
    if ($action === 'upload') {
        $titre = cleanInput($_POST['titre'] ?? '');
        $description = cleanInput($_POST['description'] ?? '');
        
        if (empty($titre)) {
            $message = 'Le titre est obligatoire.';
        } elseif (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../downloads/';
            
            // Créer le dossier s'il n'existe pas
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file = $_FILES['fichier'];
            $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['pdf', 'doc', 'docx', 'zip'];
            
            if (in_array($file_extension, $allowed_extensions) && $file['size'] <= 10 * 1024 * 1024) {
                // Générer un nom de fichier sécurisé
                $filename = generateSlug($titre) . '.' . $file_extension;
                $upload_path = $upload_dir . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                    // Sauvegarder en base de données
                    try {
                        $stmt = $pdo->prepare("INSERT INTO guides (titre, description, filename, file_path, file_size, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
                        $stmt->execute([
                            $titre,
                            $description,
                            $filename,
                            '/downloads/' . $filename,
                            $file['size']
                        ]);
                        
                        setFlashMessage('success', 'Guide uploadé avec succès !');
                        header('Location: ' . SITE_URL . '/admin/guides.php');
                        exit;
                    } catch (Exception $e) {
                        $message = 'Erreur lors de la sauvegarde en base de données.';
                        unlink($upload_path); // Supprimer le fichier uploadé
                    }
                } else {
                    $message = 'Erreur lors de l\'upload du fichier.';
                }
            } else {
                $message = 'Format de fichier non autorisé ou fichier trop volumineux (max 10MB).';
            }
        } else {
            $message = 'Veuillez sélectionner un fichier.';
        }
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    try {
        // Récupérer les infos du guide
        $stmt = $pdo->prepare("SELECT * FROM guides WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $guide = $stmt->fetch();
        
        if ($guide) {
            // Supprimer le fichier physique
            $file_path = '../downloads/' . $guide['filename'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            
            // Supprimer de la base de données
            $stmt = $pdo->prepare("DELETE FROM guides WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            
            setFlashMessage('success', 'Guide supprimé avec succès !');
        }
    } catch (Exception $e) {
        setFlashMessage('error', 'Erreur lors de la suppression.');
    }
    
    header('Location: ' . SITE_URL . '/admin/guides.php');
    exit;
}

// Récupération des guides
try {
    $stmt = $pdo->query("SELECT * FROM guides ORDER BY created_at DESC");
    $guides = $stmt->fetchAll();
} catch (Exception $e) {
    $guides = [];
}

$pageTitle = 'Gestion des Guides - Admin';
?>

<!DOCTYPE html>
<html lang="fr" class="<?= $_COOKIE['theme'] ?? 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 40;
        }
        
        @media (max-width: 1023px) {
            .sidebar-fixed {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            .sidebar-fixed.show {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-fixed w-64 bg-gray-800 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <h1 class="text-xl font-bold">Admin Panel</h1>
            </div>
            
            <nav class="mt-8">
                <a href="<?= SITE_URL ?>/admin/" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="<?= SITE_URL ?>/admin/articles.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
                    <i class="fas fa-newspaper mr-3"></i>
                    Articles
                </a>
                <a href="<?= SITE_URL ?>/admin/categories.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
                    <i class="fas fa-tags mr-3"></i>
                    Catégories
                </a>
                <a href="<?= SITE_URL ?>/admin/formations.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
                    <i class="fas fa-graduation-cap mr-3"></i>
                    Formations
                </a>
                <a href="<?= SITE_URL ?>/admin/guides.php" class="flex items-center px-4 py-3 bg-orange-600 rounded-lg text-white mx-2">
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
                <a href="<?= SITE_URL ?>/logout.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-red-600 transition-colors">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Déconnexion
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-64">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between px-4 lg:px-6 py-4">
                    <div class="flex items-center">
                        <button onclick="toggleSidebar()" class="lg:hidden text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white mr-4">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Guides</h1>
                            <p class="text-gray-600 dark:text-gray-400">Gérez vos guides PDF et fichiers téléchargeables</p>
                        </div>
                    </div>
                    <a href="<?= SITE_URL ?>/admin/guides.php?action=upload" 
                       class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Nouveau Guide
                    </a>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 p-4 lg:p-6 min-w-0">
                <?php if ($message): ?>
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <span class="text-red-700 dark:text-red-400"><?= escape($message) ?></span>
                </div>
                <?php endif; ?>

                <?php $flash = getFlashMessage(); if ($flash): ?>
                <div class="mb-6 p-4 <?= $flash['type'] === 'success' ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 text-green-700 dark:text-green-400' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800 text-red-700 dark:text-red-400' ?> border rounded-lg">
                    <?= escape($flash['message']) ?>
                </div>
                <?php endif; ?>

                <?php if ($action === 'upload'): ?>
                <!-- Formulaire d'upload -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 lg:p-6 max-w-none overflow-hidden">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            <i class="fas fa-upload text-orange-500 mr-2"></i>Uploader un nouveau guide
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400">
                            Ajoutez un guide PDF, document ou fichier ZIP téléchargeable
                        </p>
                    </div>

                    <form method="POST" enctype="multipart/form-data" class="space-y-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="titre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-heading mr-2 text-orange-500"></i>Titre du guide *
                                </label>
                                <input type="text" id="titre" name="titre" required
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                       placeholder="Ex: Guide Emploi 30 Jours">
                            </div>
                            
                            <div>
                                <label for="fichier" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-file mr-2 text-blue-500"></i>Fichier *
                                </label>
                                <input type="file" id="fichier" name="fichier" required accept=".pdf,.doc,.docx,.zip"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    Formats acceptés: PDF, DOC, DOCX, ZIP (max 10MB)
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-align-left mr-2 text-green-500"></i>Description
                            </label>
                            <textarea id="description" name="description" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Description du contenu du guide..."></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" 
                                    class="bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold px-8 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-upload mr-2"></i>Uploader le guide
                            </button>
                            <a href="<?= SITE_URL ?>/admin/guides.php" 
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-8 py-3 rounded-lg transition-all duration-300 text-center">
                                <i class="fas fa-times mr-2"></i>Annuler
                            </a>
                        </div>
                    </form>
                </div>

                <?php else: ?>
                <!-- Liste des guides -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            <i class="fas fa-list mr-2 text-orange-500"></i>
                            Guides disponibles (<?= count($guides) ?>)
                        </h2>
                    </div>

                    <?php if (empty($guides)): ?>
                    <div class="p-8 text-center">
                        <i class="fas fa-file-pdf text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Aucun guide uploadé pour le moment</p>
                        <a href="<?= SITE_URL ?>/admin/guides.php?action=upload" 
                           class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i>Uploader le premier guide
                        </a>
                    </div>
                    <?php else: ?>
                    
                    <!-- Desktop Table -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Guide
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Fichier
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Taille
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <?php foreach ($guides as $guide): ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                <?= escape($guide['titre']) ?>
                                            </div>
                                            <?php if ($guide['description']): ?>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                                <?= escape($guide['description']) ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                        <div class="flex items-center">
                                            <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                            <?= escape($guide['filename']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <?= formatFileSize($guide['file_size']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <?= formatDate($guide['created_at']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="<?= SITE_URL . $guide['file_path'] ?>" target="_blank"
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="<?= SITE_URL ?>/admin/guides.php?action=delete&id=<?= $guide['id'] ?>" 
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce guide ?')"
                                               class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="lg:hidden">
                        <?php foreach ($guides as $guide): ?>
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        <?= escape($guide['titre']) ?>
                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <i class="fas fa-file-pdf text-red-500 mr-1"></i>
                                        <?= escape($guide['filename']) ?> • <?= formatFileSize($guide['file_size']) ?>
                                    </p>
                                    <?php if ($guide['description']): ?>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                                        <?= escape($guide['description']) ?>
                                    </p>
                                    <?php endif; ?>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                        <?= formatDate($guide['created_at']) ?>
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <a href="<?= SITE_URL . $guide['file_path'] ?>" target="_blank"
                                       class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <a href="<?= SITE_URL ?>/admin/guides.php?action=delete&id=<?= $guide['id'] ?>" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce guide ?')"
                                       class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
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

<?php
// Fonction utilitaire pour formater la taille des fichiers
function formatFileSize($bytes) {
    if ($bytes >= 1048576) {
        return round($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return round($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}
?>
