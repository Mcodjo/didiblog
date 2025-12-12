<?php
require_once '../config/config.php';
require_once '../core/functions.php';
require_once '../models/User.php';

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isAdmin()) {
    header('Location: ' . SITE_URL . '/login.php');
    exit;
}

// Connexion à la base de données
$pdo = getDatabase();
$userModel = new User($pdo);

// Gestion des actions
$action = $_GET['action'] ?? 'list';
$message = '';

if ($_POST) {
    if ($action === 'create' || $action === 'edit') {
        $username = cleanInput($_POST['username'] ?? '');
        $email = cleanInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'user';
        $nom = cleanInput($_POST['nom'] ?? '');
        $prenom = cleanInput($_POST['prenom'] ?? '');
        $actif = isset($_POST['actif']) ? 1 : 0;
        
        // Validation
        if (empty($username) || empty($email)) {
            $message = 'Le nom d\'utilisateur et l\'email sont obligatoires.';
        } elseif (!isValidEmail($email)) {
            $message = 'Veuillez entrer une adresse email valide.';
        } elseif ($action === 'create' && empty($password)) {
            $message = 'Le mot de passe est obligatoire pour créer un utilisateur.';
        } else {
            $userId = $action === 'edit' ? $_GET['id'] : null;
            
            // Vérifier l'unicité de l'email et du username
            if ($userModel->emailExists($email, $userId)) {
                $message = 'Cette adresse email est déjà utilisée.';
            } elseif ($userModel->usernameExists($username, $userId)) {
                $message = 'Ce nom d\'utilisateur est déjà utilisé.';
            } else {
                $data = [
                    'username' => $username,
                    'email' => $email,
                    'role' => $role,
                    'nom' => $nom ?: null,
                    'prenom' => $prenom ?: null,
                    'actif' => $actif
                ];
                
                if (!empty($password)) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }
                
                if ($action === 'create') {
                    if ($userModel->create($data)) {
                        setFlashMessage('success', 'Utilisateur créé avec succès !');
                        header('Location: ' . SITE_URL . '/admin/users.php');
                        exit;
                    } else {
                        $message = 'Erreur lors de la création de l\'utilisateur.';
                    }
                } else {
                    if ($userModel->update($userId, $data)) {
                        setFlashMessage('success', 'Utilisateur mis à jour avec succès !');
                        header('Location: ' . SITE_URL . '/admin/users.php');
                        exit;
                    } else {
                        $message = 'Erreur lors de la mise à jour de l\'utilisateur.';
                    }
                }
            }
        }
    }
    
    if ($action === 'toggle_status' && isset($_POST['user_id'])) {
        $userId = $_POST['user_id'];
        $user = $userModel->getById($userId);
        
        if ($user) {
            $newStatus = $user['actif'] ? 0 : 1;
            if ($userModel->update($userId, ['actif' => $newStatus])) {
                $statusText = $newStatus ? 'activé' : 'désactivé';
                setFlashMessage('success', "Utilisateur $statusText avec succès !");
            } else {
                setFlashMessage('error', 'Erreur lors du changement de statut.');
            }
        }
        header('Location: ' . SITE_URL . '/admin/users.php');
        exit;
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Empêcher la suppression de son propre compte
    if ($userId == $_SESSION['user_id']) {
        setFlashMessage('error', 'Vous ne pouvez pas supprimer votre propre compte.');
    } else {
        if ($userModel->delete($userId)) {
            setFlashMessage('success', 'Utilisateur supprimé avec succès !');
        } else {
            setFlashMessage('error', 'Erreur lors de la suppression.');
        }
    }
    header('Location: ' . SITE_URL . '/admin/users.php');
    exit;
}

// Pagination et filtres
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 20;
$offset = ($page - 1) * $limit;
$roleFilter = $_GET['role'] ?? '';
$search = cleanInput($_GET['search'] ?? '');

// Récupération des utilisateurs
if (!empty($search)) {
    $users = $userModel->search($search, $limit);
    $totalUsers = count($users);
} else {
    $users = $userModel->getAll($limit, $offset, $roleFilter ?: null);
    $totalUsers = $userModel->count($roleFilter ?: null);
}

$totalPages = ceil($totalUsers / $limit);

// Récupération des statistiques
$stats = $userModel->getStats();

// Récupération de l'utilisateur à éditer
if ($action === 'edit' && isset($_GET['id'])) {
    $editUser = $userModel->getById($_GET['id']);
    if (!$editUser) {
        header('Location: ' . SITE_URL . '/admin/users.php');
        exit;
    }
}

$pageTitle = 'Gestion des Utilisateurs - Admin';
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
                <a href="<?= SITE_URL ?>/admin/guides.php" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 transition-colors">
                    <i class="fas fa-file-pdf mr-3"></i>
                    Guides & Fichiers
                </a>
                <a href="<?= SITE_URL ?>/admin/users.php" class="flex items-center px-4 py-3 bg-orange-600 rounded-lg text-white mx-2">
                    <i class="fas fa-users mr-3"></i>
                    Utilisateurs
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
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestion des Utilisateurs</h1>
                            <p class="text-gray-600 dark:text-gray-400">Gérez les comptes utilisateurs et leurs permissions</p>
                        </div>
                    </div>
                    <?php if ($action === 'list'): ?>
                    <a href="<?= SITE_URL ?>/admin/users.php?action=create" 
                       class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Nouvel Utilisateur
                    </a>
                    <?php endif; ?>
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

                <?php if ($action === 'list'): ?>
                <!-- Statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/20">
                                <i class="fas fa-users text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $stats['total'] ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/20">
                                <i class="fas fa-user-check text-green-600 dark:text-green-400"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Actifs</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $stats['actifs'] ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900/20">
                                <i class="fas fa-user-plus text-orange-600 dark:text-orange-400"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ce mois</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $stats['nouveaux'] ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/20">
                                <i class="fas fa-user-shield text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Admins</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $stats['admins'] ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900/20">
                                <i class="fas fa-clock text-indigo-600 dark:text-indigo-400"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Récents</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white"><?= $stats['recents'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtres et recherche -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6 p-6">
                    <form method="GET" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="<?= escape($search) ?>" 
                                   placeholder="Rechercher par nom, email, username..."
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <select name="role" class="px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Tous les rôles</option>
                                <option value="user" <?= $roleFilter === 'user' ? 'selected' : '' ?>>Utilisateurs</option>
                                <option value="admin" <?= $roleFilter === 'admin' ? 'selected' : '' ?>>Administrateurs</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-search mr-2"></i>Rechercher
                        </button>
                        <?php if (!empty($search) || !empty($roleFilter)): ?>
                        <a href="<?= SITE_URL ?>/admin/users.php" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors text-center">
                            <i class="fas fa-times mr-2"></i>Effacer
                        </a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- Liste des utilisateurs -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            <i class="fas fa-list mr-2 text-orange-500"></i>
                            Utilisateurs (<?= $totalUsers ?>)
                        </h2>
                    </div>

                    <?php if (empty($users)): ?>
                    <div class="p-8 text-center">
                        <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">Aucun utilisateur trouvé</p>
                    </div>
                    <?php else: ?>
                    
                    <!-- Desktop Table -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Utilisateur
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Rôle
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Inscription
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <?php foreach ($users as $user): ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-500 dark:text-gray-400"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    <?= escape($user['prenom'] . ' ' . $user['nom']) ?: escape($user['username']) ?>
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    <?= escape($user['email']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $user['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' ?>">
                                            <?= $user['role'] === 'admin' ? 'Admin' : 'Utilisateur' ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $user['actif'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                            <?= $user['actif'] ? 'Actif' : 'Inactif' ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <?= formatDate($user['created_at']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="<?= SITE_URL ?>/admin/users.php?action=edit&id=<?= $user['id'] ?>"
                                               class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <form method="POST" class="inline">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <button type="submit" name="action" value="toggle_status"
                                                        class="<?= $user['actif'] ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' ?>">
                                                    <i class="fas <?= $user['actif'] ? 'fa-user-slash' : 'fa-user-check' ?>"></i>
                                                </button>
                                            </form>
                                            
                                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                            <a href="<?= SITE_URL ?>/admin/users.php?action=delete&id=<?= $user['id'] ?>" 
                                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"
                                               class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>

                <?php elseif ($action === 'create' || $action === 'edit'): ?>
                <!-- Formulaire de création/édition -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            <i class="fas <?= $action === 'create' ? 'fa-plus' : 'fa-edit' ?> mr-2 text-orange-500"></i>
                            <?= $action === 'create' ? 'Nouvel Utilisateur' : 'Modifier l\'Utilisateur' ?>
                        </h2>
                    </div>

                    <form method="POST" class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-user mr-2 text-orange-500"></i>Nom d'utilisateur *
                                </label>
                                <input type="text" id="username" name="username" required
                                       value="<?= $action === 'edit' && isset($editUser) ? escape($editUser['username']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Nom d'utilisateur unique">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-envelope mr-2 text-orange-500"></i>Email *
                                </label>
                                <input type="email" id="email" name="email" required
                                       value="<?= $action === 'edit' && isset($editUser) ? escape($editUser['email']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="adresse@email.com">
                            </div>

                            <!-- Mot de passe -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-lock mr-2 text-orange-500"></i>Mot de passe <?= $action === 'create' ? '*' : '(laisser vide pour ne pas changer)' ?>
                                </label>
                                <input type="password" id="password" name="password" <?= $action === 'create' ? 'required' : '' ?>
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Mot de passe sécurisé">
                            </div>

                            <!-- Rôle -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-user-shield mr-2 text-orange-500"></i>Rôle
                                </label>
                                <select id="role" name="role"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                    <option value="user" <?= $action === 'edit' && isset($editUser) && $editUser['role'] === 'user' ? 'selected' : '' ?>>Utilisateur</option>
                                    <option value="admin" <?= $action === 'edit' && isset($editUser) && $editUser['role'] === 'admin' ? 'selected' : '' ?>>Administrateur</option>
                                </select>
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-id-card mr-2 text-orange-500"></i>Prénom
                                </label>
                                <input type="text" id="prenom" name="prenom"
                                       value="<?= $action === 'edit' && isset($editUser) ? escape($editUser['prenom']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Prénom">
                            </div>

                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-id-card mr-2 text-orange-500"></i>Nom
                                </label>
                                <input type="text" id="nom" name="nom"
                                       value="<?= $action === 'edit' && isset($editUser) ? escape($editUser['nom']) : '' ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Nom de famille">
                            </div>

                            <!-- Statut actif -->
                            <div class="flex items-center">
                                <input type="checkbox" id="actif" name="actif" value="1" 
                                       <?= $action === 'create' || ($action === 'edit' && isset($editUser) && $editUser['actif']) ? 'checked' : '' ?>
                                       class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <label for="actif" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    <i class="fas fa-toggle-on mr-2 text-orange-500"></i>Compte actif
                                </label>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                            <a href="<?= SITE_URL ?>/admin/users.php" 
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Retour
                            </a>
                            <button type="submit" 
                                    class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                <?= $action === 'create' ? 'Créer l\'utilisateur' : 'Mettre à jour' ?>
                            </button>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
                
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Fermer la sidebar en cliquant en dehors (mobile)
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = event.target.closest('button[onclick="toggleSidebar()"]');
            
            if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth < 1024) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>
