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
    // Gestion upload image
    function handleImageUpload($fileInputName) {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $filename = $_FILES[$fileInputName]['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) return '';
            $newName = uniqid('about_', true) . '.' . $ext;
            $dest = '../images/' . $newName;
            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $dest)) {
                return 'images/' . $newName;
            }
        }
        return '';
    }

    if ($action === 'update') {
        $section_key = cleanInput($_POST['section_key'] ?? '');
        $title = cleanInput($_POST['title'] ?? '');
        $content = cleanInput($_POST['content'] ?? '');
        $image_url = cleanInput($_POST['image_url'] ?? '');
        $ordre = (int)($_POST['ordre'] ?? 0);
        $actif = isset($_POST['actif']) ? 1 : 0;
        // Upload image si présente
        $uploadedImage = handleImageUpload('edit_image');
        if ($uploadedImage) $image_url = $uploadedImage;
        if (empty($section_key) || empty($title) || empty($content)) {
            $error = 'Veuillez remplir tous les champs obligatoires.';
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE about SET title = :title, content = :content, image_url = :image_url, ordre = :ordre, actif = :actif WHERE section_key = :section_key");
                $stmt->execute([
                    ':title' => $title,
                    ':content' => $content,
                    ':image_url' => $image_url,
                    ':ordre' => $ordre,
                    ':actif' => $actif,
                    ':section_key' => $section_key
                ]);
                $success = 'Section mise à jour avec succès !';
            } catch (Exception $e) {
                $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
            }
        }
    }

    if ($action === 'add') {
        $section_key = cleanInput($_POST['new_section_key'] ?? '');
        $title = cleanInput($_POST['new_title'] ?? '');
        $content = cleanInput($_POST['new_content'] ?? '');
        $image_url = cleanInput($_POST['new_image_url'] ?? '');
        $ordre = (int)($_POST['new_ordre'] ?? 0);
        // Upload image si présente
        $uploadedImage = handleImageUpload('add_image');
        if ($uploadedImage) $image_url = $uploadedImage;
        if (empty($section_key) || empty($title) || empty($content)) {
            $error = 'Veuillez remplir tous les champs obligatoires pour la nouvelle section.';
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO about (section_key, title, content, image_url, ordre, actif) VALUES (:section_key, :title, :content, :image_url, :ordre, 1)");
                $stmt->execute([
                    ':section_key' => $section_key,
                    ':title' => $title,
                    ':content' => $content,
                    ':image_url' => $image_url,
                    ':ordre' => $ordre
                ]);
                $success = 'Nouvelle section ajoutée avec succès !';
            } catch (Exception $e) {
                $error = 'Erreur lors de l\'ajout : ' . $e->getMessage();
            }
        }
    }
    
    if ($action === 'delete') {
        $section_key = cleanInput($_POST['delete_section_key'] ?? '');
        
        if (!empty($section_key)) {
            try {
                $stmt = $pdo->prepare("DELETE FROM about WHERE section_key = :section_key");
                $stmt->execute([':section_key' => $section_key]);
                
                $success = 'Section supprimée avec succès !';
            } catch (Exception $e) {
                $error = 'Erreur lors de la suppression : ' . $e->getMessage();
            }
        }
    }
}

// Récupération des sections
try {
    $stmt = $pdo->prepare("SELECT * FROM about ORDER BY ordre ASC, id ASC");
    $stmt->execute();
    $sections = $stmt->fetchAll();
} catch (Exception $e) {
    $sections = [];
    $error = 'Erreur lors du chargement des sections : ' . $e->getMessage();
}

$pageTitle = 'Gestion À Propos - Admin';
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
                            <i class="fas fa-home mr-3"></i>
                            Dashboard
                        </a>
                        <a href="<?= SITE_URL ?>/admin/articles.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-newspaper mr-3"></i>
                            Articles
                        </a>
                        <a href="<?= SITE_URL ?>/admin/categories.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-tags mr-3"></i>
                            Catégories
                        </a>
                        <a href="<?= SITE_URL ?>/admin/formations.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-graduation-cap mr-3"></i>
                            Formations
                        </a>
                        <a href="<?= SITE_URL ?>/admin/comments.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-comments mr-3"></i>
                            Commentaires
                        </a>
                        <a href="<?= SITE_URL ?>/admin/about.php" class="bg-orange-100 dark:bg-orange-900 text-orange-700 dark:text-orange-200 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-user mr-3"></i>
                            À Propos
                        </a>
                        <a href="<?= SITE_URL ?>/admin/settings.php" class="text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-cog mr-3"></i>
                            Paramètres
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
                            <button type="button" class="md:hidden -ml-2 mr-2 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-orange-500" onclick="toggleSidebar()">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                <i class="fas fa-user text-orange-600 mr-2"></i>
                                Gestion À Propos
                            </h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="<?= SITE_URL ?>/a-propos.php" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Voir la page
                            </a>
                            <a href="<?= SITE_URL ?>/logout.php" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Déconnexion
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

                <!-- Bouton d'ajout -->
                <div class="flex justify-end mb-6">
                    <button onclick="document.getElementById('addSectionModal').classList.remove('hidden')" type="button" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvelle section
                    </button>
                </div>

                <!-- Liste des sections avec édition intégrée -->
                <div class="space-y-6">
                    <?php foreach ($sections as $section): ?>
                    <div class="bg-white rounded-lg shadow-md border border-gray-200" id="section-<?= escape($section['section_key']) ?>">
                        <!-- En-tête de section -->
                        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <?php if ($section['image_url']): ?>
                                <img src="<?= escape($section['image_url']) ?>" alt="<?= escape($section['title']) ?>" class="w-12 h-12 object-cover rounded-lg">
                                <?php endif; ?>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900"><?= escape($section['title']) ?></h3>
                                    <p class="text-sm text-gray-500">Clé: <?= escape($section['section_key']) ?> | Ordre: <?= escape($section['ordre']) ?></p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $section['actif'] ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                    <?= $section['actif'] ? 'Actif' : 'Inactif' ?>
                                </span>
                                <button onclick="toggleEdit('<?= escape($section['section_key']) ?>')" class="p-2 text-orange-600 hover:text-orange-900 hover:bg-orange-50 rounded-lg transition-colors" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteSection('<?= escape($section['section_key']) ?>')" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Contenu affiché -->
                        <div class="p-4" id="display-<?= escape($section['section_key']) ?>">
                            <div class="prose max-w-none">
                                <?= nl2br(escape($section['content'])) ?>
                            </div>
                        </div>

                        <!-- Formulaire d'édition (caché par défaut) -->
                        <div class="p-4 border-t border-gray-200 hidden" id="edit-<?= escape($section['section_key']) ?>">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="section_key" value="<?= escape($section['section_key']) ?>">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Titre *</label>
                                        <input type="text" name="title" value="<?= escape($section['title']) ?>" required 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ordre</label>
                                        <input type="number" name="ordre" value="<?= escape($section['ordre']) ?>" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                                        <input type="file" name="edit_image" accept="image/*" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">URL Image</label>
                                        <input type="url" name="image_url" value="<?= escape($section['image_url']) ?>" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Contenu *</label>
                                    <textarea name="content" rows="6" required 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"><?= escape($section['content']) ?></textarea>
                                </div>

                                <div class="flex items-center justify-between">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="actif" <?= $section['actif'] ? 'checked' : '' ?> 
                                               class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                        <span class="ml-2 text-sm text-gray-600">Section active</span>
                                    </label>
                                    
                                    <div class="flex items-center space-x-2">
                                        <button type="button" onclick="toggleEdit('<?= escape($section['section_key']) ?>')" 
                                                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                                            Annuler
                                        </button>
                                        <button type="submit" 
                                                class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-md">
                                            <i class="fas fa-save mr-2"></i>Sauvegarder
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Modal ajout section -->
                <div id="addSectionModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 w-full max-w-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                <i class="fas fa-plus text-orange-600 mr-2"></i>
                                Ajouter une nouvelle section
                            </h3>
                            <button onclick="document.getElementById('addSectionModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-700"><i class="fas fa-times"></i></button>
                        </div>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Clé de section *</label>
                                    <input type="text" name="new_section_key" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="ex: nouvelle_section">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Titre *</label>
                                    <input type="text" name="new_title" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Titre de la section">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image</label>
                                    <input type="file" name="add_image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">URL Image</label>
                                    <input type="url" name="new_image_url" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md" placeholder="Ou collez une URL d'image">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ordre</label>
                                    <input type="number" name="new_ordre" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md" placeholder="Ordre d'affichage">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contenu *</label>
                                    <textarea name="new_content" rows="4" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Contenu de la section"></textarea>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-md">
                                    <i class="fas fa-save mr-2"></i>
                                    Ajouter
                                </button>
                            </div>
                        </form>
                                    <input type="text" name="new_title" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">URL Image</label>
                                    <input type="url" name="new_image_url" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ordre</label>
                                    <input type="number" name="new_ordre" value="<?= count($sections) + 1 ?>" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contenu *</label>
                                <textarea name="new_content" rows="4" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"></textarea>
                            </div>
                            
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter la section
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Form de suppression caché -->
    <form id="deleteForm" method="POST" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="delete_section_key" id="deleteKey">
    </form>

    <script>
        function deleteSection(sectionKey) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette section ?')) {
                document.getElementById('deleteKey').value = sectionKey;
                document.getElementById('deleteForm').submit();
            }
        }

        function toggleEdit(sectionKey) {
            const displayDiv = document.getElementById('display-' + sectionKey);
            const editDiv = document.getElementById('edit-' + sectionKey);
            
            if (editDiv.classList.contains('hidden')) {
                // Afficher le formulaire d'édition
                displayDiv.style.display = 'none';
                editDiv.classList.remove('hidden');
                
                // Focus sur le premier champ
                const titleInput = editDiv.querySelector('input[name="title"]');
                if (titleInput) {
                    titleInput.focus();
                }
                
                // Faire défiler vers la section
                document.getElementById('section-' + sectionKey).scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            } else {
                // Masquer le formulaire d'édition
                displayDiv.style.display = 'block';
                editDiv.classList.add('hidden');
            }
        }

        function toggleSidebar() {
            // Implémentation pour mobile si nécessaire
        }
    </script>
</body>
</html>
