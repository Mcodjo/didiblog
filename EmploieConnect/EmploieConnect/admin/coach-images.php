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
    
    if ($action === 'upload') {
        $alt_text = cleanInput($_POST['alt_text'] ?? '');
        $ordre = (int)($_POST['ordre'] ?? 0);
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../images/';
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize = 5 * 1024 * 1024; // 5MB
            
            $fileType = $_FILES['image']['type'];
            $fileSize = $_FILES['image']['size'];
            $originalName = $_FILES['image']['name'];
            
            if (!in_array($fileType, $allowedTypes)) {
                $error = 'Type de fichier non autorisé. Utilisez JPG, PNG, GIF ou WebP.';
            } elseif ($fileSize > $maxSize) {
                $error = 'Le fichier est trop volumineux. Taille maximum : 5MB.';
            } else {
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $filename = 'coach_' . time() . '_' . uniqid() . '.' . $extension;
                $uploadPath = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    try {
                        $stmt = $pdo->prepare("INSERT INTO coach_images (filename, original_name, alt_text, ordre, actif) VALUES (:filename, :original_name, :alt_text, :ordre, 1)");
                        $stmt->execute([
                            ':filename' => $filename,
                            ':original_name' => $originalName,
                            ':alt_text' => $alt_text,
                            ':ordre' => $ordre
                        ]);
                        
                        $success = 'Image uploadée avec succès !';
                    } catch (Exception $e) {
                        unlink($uploadPath); // Supprimer le fichier si erreur DB
                        $error = 'Erreur lors de l\'enregistrement : ' . $e->getMessage();
                    }
                } else {
                    $error = 'Erreur lors de l\'upload du fichier.';
                }
            }
        } else {
            $error = 'Veuillez sélectionner une image.';
        }
    }
    
    if ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $alt_text = cleanInput($_POST['alt_text'] ?? '');
        $ordre = (int)($_POST['ordre'] ?? 0);
        $actif = isset($_POST['actif']) ? 1 : 0;
        
        try {
            $stmt = $pdo->prepare("UPDATE coach_images SET alt_text = :alt_text, ordre = :ordre, actif = :actif WHERE id = :id");
            $stmt->execute([
                ':alt_text' => $alt_text,
                ':ordre' => $ordre,
                ':actif' => $actif,
                ':id' => $id
            ]);
            
            $success = 'Image mise à jour avec succès !';
        } catch (Exception $e) {
            $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
        }
    }
    
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        
        try {
            // Récupérer le nom du fichier
            $stmt = $pdo->prepare("SELECT filename FROM coach_images WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $image = $stmt->fetch();
            
            if ($image) {
                // Supprimer de la base de données
                $stmt = $pdo->prepare("DELETE FROM coach_images WHERE id = :id");
                $stmt->execute([':id' => $id]);
                
                // Supprimer le fichier physique
                $filePath = '../images/' . $image['filename'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                
                $success = 'Image supprimée avec succès !';
            }
        } catch (Exception $e) {
            $error = 'Erreur lors de la suppression : ' . $e->getMessage();
        }
    }
}

// Récupération des images
try {
    $stmt = $pdo->prepare("SELECT * FROM coach_images ORDER BY ordre ASC, id ASC");
    $stmt->execute();
    $images = $stmt->fetchAll();
} catch (Exception $e) {
    $images = [];
    $error = 'Erreur lors du chargement des images : ' . $e->getMessage();
}

$pageTitle = 'Gestion Images Coach - Admin';
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
                        <a href="<?= SITE_URL ?>/admin/coach-images.php" class="bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-200 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-images mr-3"></i>Images Coach
                        </a>
                        <a href="<?= SITE_URL ?>/admin/testimonials.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
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
                                <i class="fas fa-images text-orange-600 mr-2"></i>
                                Gestion Images Coach
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

                <!-- Upload nouvelle image -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 mb-8">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-plus text-orange-600 mr-2"></i>
                            Ajouter une nouvelle image
                        </h3>
                        
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="upload">
                            
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <div class="lg:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image *</label>
                                    <input type="file" name="image" accept="image/*" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <p class="text-sm text-gray-500 mt-1">Formats acceptés: JPG, PNG, GIF, WebP (max 5MB)</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ordre</label>
                                    <input type="number" name="ordre" value="<?= count($images) + 1 ?>" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Texte alternatif</label>
                                <input type="text" name="alt_text" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Description de l'image">
                            </div>
                            
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-md">
                                    <i class="fas fa-upload mr-2"></i>
                                    Uploader l'image
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Liste des images -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
                            Images existantes (<?= count($images) ?>)
                        </h3>
                        
                        <?php if (empty($images)): ?>
                        <div class="text-center py-8">
                            <i class="fas fa-images text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">Aucune image trouvée. Uploadez votre première image !</p>
                        </div>
                        <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php foreach ($images as $image): ?>
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                                <div class="aspect-w-16 aspect-h-12">
                                    <img src="<?= SITE_URL ?>/images/<?= escape($image['filename']) ?>" 
                                         alt="<?= escape($image['alt_text']) ?>" 
                                         class="w-full h-48 object-cover">
                                </div>
                                
                                <div class="p-4">
                                    <form method="POST" class="space-y-3">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="id" value="<?= $image['id'] ?>">
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Texte alternatif</label>
                                            <input type="text" name="alt_text" value="<?= escape($image['alt_text']) ?>" class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded focus:outline-none focus:ring-1 focus:ring-orange-500">
                                        </div>
                                        
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ordre</label>
                                                <input type="number" name="ordre" value="<?= $image['ordre'] ?>" class="w-16 px-2 py-1 text-sm border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded focus:outline-none focus:ring-1 focus:ring-orange-500">
                                            </div>
                                            
                                            <label class="flex items-center">
                                                <input type="checkbox" name="actif" <?= $image['actif'] ? 'checked' : '' ?> class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Actif</span>
                                            </label>
                                        </div>
                                        
                                        <div class="flex justify-between pt-2">
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded">
                                                <i class="fas fa-save mr-1"></i>Sauver
                                            </button>
                                            
                                            <button type="button" onclick="deleteImage(<?= $image['id'] ?>)" class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded">
                                                <i class="fas fa-trash mr-1"></i>Supprimer
                                            </button>
                                        </div>
                                    </form>
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

    <!-- Form de suppression caché -->
    <form id="deleteForm" method="POST" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" id="deleteId">
    </form>

    <script>
        function deleteImage(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
                document.getElementById('deleteId').value = id;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>
