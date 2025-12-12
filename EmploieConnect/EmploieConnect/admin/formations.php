<?php
require_once '../config/config.php';
require_once '../core/functions.php';
require_once '../models/Formation.php';

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isAdmin()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit;
}

// Connexion à la base de données
$pdo = getDatabase();
$formationModel = new Formation($pdo);

// Gestion des actions
$action = $_GET['action'] ?? 'list';
$message = '';

if ($_POST) {
    if ($action === 'create' || $action === 'edit') {
        // Gestion de l'upload d'image
        $image_url = $_POST['image_url'];
        
        if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../images/formations/';
            
            // Créer le dossier s'il n'existe pas
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file = $_FILES['image_upload'];
            $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($file_extension, $allowed_extensions) && $file['size'] <= 2 * 1024 * 1024) {
                // Générer un nom de fichier unique
                $filename = uniqid('formation_') . '.' . $file_extension;
                $upload_path = $upload_dir . $filename;
                
                if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                    $image_url = SITE_URL . '/images/formations/' . $filename;
                } else {
                    $message = 'Erreur lors de l\'upload de l\'image';
                }
            } else {
                $message = 'Format d\'image non valide ou fichier trop volumineux';
            }
        }
        
        $data = [
            'nom' => $_POST['nom'],
            'slug' => generateSlug($_POST['nom']),
            'description' => $_POST['description'],
            'prix' => $_POST['prix'],
            'prix_promo' => $_POST['prix_promo'] ?: null,
            'duree' => $_POST['duree'],
            'niveau' => $_POST['niveau'],
            'image_url' => $image_url,
            'contenu' => $_POST['contenu'],
            'objectifs' => $_POST['objectifs'],
            'prerequis' => $_POST['prerequis'],
            'note' => $_POST['note'],
            'nb_etudiants' => $_POST['nb_etudiants'],
            'statut' => $_POST['statut'],
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'badge' => $_POST['badge'] ?: null
        ];
        
        if ($action === 'create') {
            $data['date_creation'] = date('Y-m-d H:i:s');
            if ($formationModel->create($data)) {
                setFlashMessage('Formation créée avec succès', 'success');
                header('Location: ' . SITE_URL . '/admin/formations.php');
                exit;
            } else {
                $message = 'Erreur lors de la création de la formation';
            }
        } else {
            $id = $_GET['id'];
            if ($formationModel->update($id, $data)) {
                setFlashMessage('Formation mise à jour avec succès', 'success');
                header('Location: ' . SITE_URL . '/admin/formations.php');
                exit;
            } else {
                $message = 'Erreur lors de la mise à jour de la formation';
            }
        }
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    if ($formationModel->delete($_GET['id'])) {
        setFlashMessage('Formation supprimée avec succès', 'success');
    } else {
        setFlashMessage('Erreur lors de la suppression', 'error');
    }
    header('Location: ' . SITE_URL . '/admin/formations.php');
    exit;
}

// Récupération des données
$formations = $formationModel->getAll();

if ($action === 'edit' && isset($_GET['id'])) {
    $formation = $formationModel->getById($_GET['id']);
    if (!$formation) {
        header('Location: ' . SITE_URL . '/admin/formations.php');
        exit;
    }
}

$pageTitle = 'Gestion des Formations - Admin';
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
                    <a href="<?= SITE_URL ?>/admin/categories.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="fas fa-tags mr-3"></i>
                        Catégories
                    </a>
                    <a href="<?= SITE_URL ?>/admin/formations.php" class="flex items-center px-4 py-3 bg-orange-600 rounded-lg text-white mx-2">
                        <i class="fas fa-graduation-cap mr-3"></i>
                        Formations
                    </a>
                    <a href="<?= SITE_URL ?>/admin/guides.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
                        <i class="fas fa-file-pdf mr-3"></i>
                        Guides & Fichiers
                    </a>
                    <a href="<?= SITE_URL ?>/admin/newsletter.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
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
                                Nouvelle Formation
                            <?php elseif ($action === 'edit'): ?>
                                Modifier la Formation
                            <?php else: ?>
                                Gestion des Formations
                            <?php endif; ?>
                        </h1>
                        <p class="text-gray-600">
                            <?php if ($action === 'list'): ?>
                                Gérez votre catalogue de formations
                            <?php else: ?>
                                Créez ou modifiez une formation
                            <?php endif; ?>
                        </p>
                    </div>
                    <?php if ($action === 'list'): ?>
                    <a href="<?= SITE_URL ?>/admin/formations.php?action=create" 
                       class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvelle Formation
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
                <!-- Formations Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    <?php foreach ($formations as $formation): ?>
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="relative">
                            <img src="<?= escape($formation['image_url']) ?>" 
                                 alt="<?= escape($formation['nom']) ?>" 
                                 class="w-full h-48 object-cover">
                            <?php if ($formation['badge']): ?>
                            <div class="absolute top-4 left-4 bg-orange-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                <?= escape($formation['badge']) ?>
                            </div>
                            <?php endif; ?>
                            <?php if (isset($formation['featured']) && $formation['featured']): ?>
                            <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-star mr-1"></i>
                                Featured
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= escape($formation['nom']) ?></h3>
                            <p class="text-gray-600 text-sm mb-4"><?= escape(substr($formation['description'], 0, 100)) ?>...</p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span><i class="fas fa-clock mr-1"></i><?= escape($formation['duree']) ?></span>
                                    <span><i class="fas fa-signal mr-1"></i><?= escape($formation['niveau']) ?></span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-star text-yellow-400"></i>
                                    <span class="text-sm text-gray-600"><?= escape($formation['note']) ?></span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <?php if (isset($formation['prix_promo']) && $formation['prix_promo']): ?>
                                    <span class="text-lg font-bold text-orange-600"><?= escape($formation['prix_promo']) ?>€</span>
                                    <span class="text-sm text-gray-500 line-through ml-2"><?= escape($formation['prix']) ?>€</span>
                                    <?php else: ?>
                                    <span class="text-lg font-bold text-gray-900"><?= escape($formation['prix']) ?>€</span>
                                    <?php endif; ?>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full <?= $formation['actif'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                                    <?= $formation['actif'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500"><?= escape($formation['etudiants'] ?? 0) ?> étudiants</span>
                                <div class="flex space-x-2">
                                    <a href="<?= SITE_URL ?>/admin/formations.php?action=edit&id=<?= $formation['id'] ?>" 
                                       class="text-orange-600 hover:text-orange-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= SITE_URL ?>/admin/formations.php?action=delete&id=<?= $formation['id'] ?>" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?')"
                                       class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php else: ?>
                <!-- Formation Form -->
                <div class="bg-white rounded-lg shadow p-4 lg:p-6 max-w-none overflow-hidden">
                    <form method="POST" enctype="multipart/form-data" class="space-y-6">
                        <!-- Nom et Durée -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-graduation-cap mr-2 text-orange-500"></i>Nom de la formation *
                                </label>
                                <input type="text" id="nom" name="nom" required
                                       value="<?= $action === 'edit' ? escape($formation['nom']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                       placeholder="Entrez le nom de la formation">
                            </div>
                            
                            <div>
                                <label for="duree" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-clock mr-2 text-orange-500"></i>Durée *
                                </label>
                                <input type="text" id="duree" name="duree" required placeholder="Ex: 8 semaines"
                                       value="<?= $action === 'edit' ? escape($formation['duree']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-2 text-orange-500"></i>Description *
                            </label>
                            <textarea id="description" name="description" rows="3" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Description courte de la formation (150-200 caractères)"><?= $action === 'edit' ? escape($formation['description']) : '' ?></textarea>
                            <div class="text-sm text-gray-500 mt-1">
                                <span id="description-count">0</span>/200 caractères
                            </div>
                        </div>
                        
                        <!-- Contenu détaillé -->
                        <div>
                            <label for="contenu" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-file-alt mr-2 text-orange-500"></i>Contenu détaillé *
                            </label>
                            <textarea id="contenu" name="contenu" rows="8" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                      placeholder="Décrivez le contenu complet de la formation..."><?= $action === 'edit' ? escape($formation['contenu']) : '' ?></textarea>
                        </div>
                        
                        <!-- Objectifs et Prérequis -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="objectifs" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-bullseye mr-2 text-orange-500"></i>Objectifs *
                                </label>
                                <textarea id="objectifs" name="objectifs" rows="4" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                          placeholder="Listez les objectifs pédagogiques..."><?= $action === 'edit' && isset($formation['objectifs']) ? escape($formation['objectifs']) : '' ?></textarea>
                            </div>
                            
                            <div>
                                <label for="prerequis" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-list-check mr-2 text-orange-500"></i>Prérequis
                                </label>
                                <textarea id="prerequis" name="prerequis" rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                          placeholder="Indiquez les prérequis nécessaires..."><?= $action === 'edit' && isset($formation['prerequis']) ? escape($formation['prerequis']) : '' ?></textarea>
                            </div>
                        </div>
                        
                        <!-- Image -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-image mr-2 text-orange-500"></i>Image de la formation
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label for="image_upload" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-upload mr-2 text-blue-500"></i>Upload d'image
                                    </label>
                                    <input type="file" id="image_upload" name="image_upload" accept="image/*"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF (max 2MB)</p>
                                </div>
                                
                                <div>
                                    <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-link mr-2 text-green-500"></i>Ou URL de l'image
                                    </label>
                                    <input type="url" id="image_url" name="image_url"
                                           value="<?= $action === 'edit' ? escape($formation['image_url']) : '' ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200"
                                           placeholder="https://exemple.com/image.jpg">
                                    <p class="text-xs text-gray-500 mt-1">L'upload a la priorité sur l'URL</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Prix et Statistiques -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <label for="prix" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-euro-sign mr-2 text-green-500"></i>Prix (€) *
                                </label>
                                <input type="number" id="prix" name="prix" min="0" step="0.01" required
                                       value="<?= $action === 'edit' ? escape($formation['prix']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                       placeholder="99.00">
                            </div>
                            
                            <div>
                                <label for="prix_promo" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-2 text-red-500"></i>Prix promo (€)
                                </label>
                                <input type="number" id="prix_promo" name="prix_promo" min="0" step="0.01"
                                       value="<?= $action === 'edit' && isset($formation['prix_promo']) ? escape($formation['prix_promo']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                       placeholder="79.00">
                            </div>
                            
                            <div>
                                <label for="note" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-star mr-2 text-yellow-500"></i>Note (/5)
                                </label>
                                <input type="number" id="note" name="note" min="0" max="5" step="0.1"
                                       value="<?= $action === 'edit' && isset($formation['note']) ? escape($formation['note']) : '4.8' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                            </div>
                            
                            <div>
                                <label for="nb_etudiants" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-users mr-2 text-blue-500"></i>Nb étudiants
                                </label>
                                <input type="number" id="nb_etudiants" name="nb_etudiants" min="0"
                                       value="<?= $action === 'edit' && isset($formation['nb_etudiants']) ? escape($formation['nb_etudiants']) : '0' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200"
                                       placeholder="0">
                            </div>
                        </div>
                        
                        <!-- Paramètres -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-cogs mr-2 text-orange-500"></i>Paramètres de la formation
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <label for="niveau" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-layer-group mr-2 text-purple-500"></i>Niveau *
                                    </label>
                                    <select id="niveau" name="niveau" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                        <option value="Débutant" <?= ($action === 'edit' && isset($formation['niveau']) && $formation['niveau'] === 'Débutant') ? 'selected' : '' ?>>Débutant</option>
                                        <option value="Intermédiaire" <?= ($action === 'edit' && isset($formation['niveau']) && $formation['niveau'] === 'Intermédiaire') ? 'selected' : '' ?>>Intermédiaire</option>
                                        <option value="Avancé" <?= ($action === 'edit' && isset($formation['niveau']) && $formation['niveau'] === 'Avancé') ? 'selected' : '' ?>>Avancé</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-toggle-on mr-2 text-green-500"></i>Statut *
                                    </label>
                                    <select id="statut" name="statut" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                        <option value="active" <?= ($action === 'edit' && isset($formation['statut']) && $formation['statut'] === 'active') ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?= ($action === 'edit' && isset($formation['statut']) && $formation['statut'] === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="badge" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-award mr-2 text-yellow-500"></i>Badge
                                    </label>
                                    <input type="text" id="badge" name="badge" placeholder="Nouveau, Populaire..."
                                           value="<?= $action === 'edit' ? escape($formation['badge']) : '' ?>"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                </div>
                                
                                <div class="flex items-end">
                                    <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200 w-full">
                                        <input type="checkbox" id="featured" name="featured" value="1"
                                               <?= ($action === 'edit' && isset($formation['featured']) && $formation['featured']) ? 'checked' : '' ?>
                                               class="w-5 h-5 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                                        <label for="featured" class="ml-3 text-sm font-medium text-gray-700">
                                            <i class="fas fa-star mr-2 text-yellow-500"></i>Formation en vedette
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
                                    <?= $action === 'edit' ? 'Mettre à jour' : 'Créer la formation' ?>
                                </button>
                                <a href="<?= SITE_URL ?>/admin/formations.php" 
                                   class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-8 py-3 rounded-lg transition-all duration-300 text-center">
                                    <i class="fas fa-times mr-2"></i>Annuler
                                </a>
                            </div>
                            <?php if ($action === 'edit'): ?>
                            <div class="text-sm text-gray-500">
                                Dernière modification : <?= formatDate($formation['updated_at'] ?? $formation['created_at']) ?>
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

    // Character counter for description
    document.addEventListener('DOMContentLoaded', function() {
        const descriptionTextarea = document.getElementById('description');
        const descriptionCount = document.getElementById('description-count');
        
        if (descriptionTextarea && descriptionCount) {
            function updateCount() {
                const count = descriptionTextarea.value.length;
                descriptionCount.textContent = count;
                
                // Change color based on character count
                if (count > 200) {
                    descriptionCount.classList.add('text-red-500');
                    descriptionCount.classList.remove('text-gray-500', 'text-yellow-500');
                } else if (count > 150) {
                    descriptionCount.classList.add('text-yellow-500');
                    descriptionCount.classList.remove('text-gray-500', 'text-red-500');
                } else {
                    descriptionCount.classList.add('text-gray-500');
                    descriptionCount.classList.remove('text-yellow-500', 'text-red-500');
                }
            }
            
            // Update count on page load
            updateCount();
            
            // Update count on input
            descriptionTextarea.addEventListener('input', updateCount);
        }

        // Image upload preview
        const imageUpload = document.getElementById('image_upload');
        const imageUrl = document.getElementById('image_url');
        
        if (imageUpload) {
            imageUpload.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Clear URL field when file is selected
                    if (imageUrl) {
                        imageUrl.value = '';
                    }
                    
                    // Validate file size (2MB max)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Le fichier est trop volumineux. Taille maximale: 2MB');
                        e.target.value = '';
                        return;
                    }
                    
                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Type de fichier non supporté. Utilisez JPG, PNG ou GIF.');
                        e.target.value = '';
                        return;
                    }
                }
            });
        }

        // Clear file input when URL is entered
        if (imageUrl) {
            imageUrl.addEventListener('input', function() {
                if (this.value.trim() && imageUpload) {
                    imageUpload.value = '';
                }
            });
        }
    });
    </script>

</body>
</html>
