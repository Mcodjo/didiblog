<?php
require_once 'config/config.php';
require_once 'core/functions.php';

// Redirection si déjà connecté
if (isLoggedIn()) {
    redirect(SITE_URL . '/admin/');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = cleanInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        $pdo = getDatabase();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND actif = 1");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            
            // Mise à jour de la dernière connexion
            $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = :id");
            $stmt->execute([':id' => $user['id']]);
            
            setFlashMessage('success', 'Connexion réussie ! Bienvenue ' . $user['prenom'] . ' ' . $user['nom']);
            
            // Redirection selon le rôle
            if ($user['role'] === 'admin') {
                redirect(SITE_URL . '/admin/');
            } else {
                redirect(SITE_URL . '/');
            }
        } else {
            $error = 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
    }
}

$pageTitle = 'Connexion - Emploi Connect';
$pageDescription = 'Connectez-vous à votre compte Emploi Connect';
?>

<?php require_once 'includes/header.php'; ?>

<main class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 py-20">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-shield text-2xl text-orange-600 dark:text-orange-400"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Connexion</h1>
                <p class="text-gray-600 dark:text-gray-400">Accédez à votre Compte</p>
            </div>

            <!-- Messages d'erreur -->
            <?php if ($error): ?>
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="text-red-700 dark:text-red-400"><?= escape($error) ?></span>
                </div>
            </div>
            <?php endif; ?>

            <!-- Formulaire de connexion -->
            <form method="POST" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nom d'utilisateur
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="username" 
                               name="username" 
                               required
                               value="<?= escape($_POST['username'] ?? '') ?>"
                               class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="Votre nom d'utilisateur">
                        <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Mot de passe
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               class="w-full px-4 py-3 pl-12 pr-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="Votre mot de passe">
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button type="button" 
                                onclick="togglePassword()" 
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="remember" 
                               class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Se souvenir de moi</span>
                    </label>
                    
                    <a href="<?= SITE_URL ?>/forgot-password.php" class="text-sm text-orange-600 hover:text-orange-700 transition-colors">
                        Mot de passe oublié ?
                    </a>
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Se connecter
                </button>
            </form>

            <!-- Lien vers l'inscription -->
            <div class="mt-8 text-center space-y-4">
                <p class="text-gray-600 dark:text-gray-400">
                    <a href="<?= SITE_URL ?>/forgot-password.php" class="text-orange-600 hover:text-orange-700 font-medium transition-colors">
                        Mot de passe oublié ?
                    </a>
                </p>
                
                <p class="text-gray-600 dark:text-gray-400">
                    Pas encore de compte ? 
                    <a href="<?= SITE_URL ?>/register.php" class="text-orange-600 hover:text-orange-700 font-medium transition-colors">
                        S'inscrire
                    </a>
                </p>
            </div>

            <!-- Retour au site -->
            <div class="mt-6 text-center">
                <a href="<?= SITE_URL ?>" class="inline-flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour au site
                </a>
            </div>
        </div>

</main>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('password-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        passwordIcon.className = 'fas fa-eye';
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
