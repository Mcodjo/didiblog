<?php
require_once 'config/config.php';
require_once 'core/functions.php';

// Rediriger si déjà connecté
if (isLoggedIn()) {
    redirect(SITE_URL . '/admin/');
}

$token = $_GET['token'] ?? '';
$message = '';
$messageType = '';
$validToken = false;
$user = null;

if (!$token) {
    redirect(SITE_URL . '/forgot-password.php');
}

// Vérifier le token
$pdo = getDatabase();
$stmt = $pdo->prepare("
    SELECT pr.*, u.username, u.prenom, u.nom 
    FROM password_resets pr 
    JOIN users u ON pr.user_id = u.id 
    WHERE pr.token = :token AND pr.expires_at > NOW() AND pr.used = 0
");
$stmt->execute([':token' => $token]);
$resetData = $stmt->fetch();

if ($resetData) {
    $validToken = true;
    $user = $resetData;
} else {
    $message = 'Ce lien de réinitialisation est invalide ou a expiré.';
    $messageType = 'error';
}

// Traitement du formulaire
if ($_POST && $validToken) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    if (strlen($password) < 6) {
        $message = 'Le mot de passe doit contenir au moins 6 caractères.';
        $messageType = 'error';
    } elseif ($password !== $confirmPassword) {
        $message = 'Les mots de passe ne correspondent pas.';
        $messageType = 'error';
    } else {
        // Mettre à jour le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
        $updateSuccess = $stmt->execute([
            ':password' => $hashedPassword,
            ':user_id' => $resetData['user_id']
        ]);
        
        if ($updateSuccess) {
            // Marquer le token comme utilisé
            $stmt = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE token = :token");
            $stmt->execute([':token' => $token]);
            
            $message = 'Votre mot de passe a été réinitialisé avec succès. Redirection vers la connexion...';
            $messageType = 'success';
            $validToken = false; // Empêcher d'autres tentatives
        } else {
            $message = 'Erreur lors de la mise à jour du mot de passe. Veuillez réessayer.';
            $messageType = 'error';
        }
    }
}

$pageTitle = 'Réinitialiser le mot de passe - Emploi Connect';
$pageDescription = 'Créez un nouveau mot de passe pour votre compte Emploi Connect';
?>

<?php require_once 'includes/header.php'; ?>

<main class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 py-20">
    <div class="max-w-md w-full mx-4">
        <!-- Logo et titre -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-600 to-orange-700 rounded-full mb-4">
                <i class="fas fa-lock text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Nouveau mot de passe</h1>
            <?php if ($validToken && $user): ?>
            <p class="text-gray-600 dark:text-gray-400">
                Bonjour <?= escape($user['prenom']) ?>, créez votre nouveau mot de passe
            </p>
            <?php else: ?>
            <p class="text-gray-600 dark:text-gray-400">
                Réinitialisez votre mot de passe
            </p>
            <?php endif; ?>
        </div>

        <!-- Messages -->
        <?php if ($message): ?>
        <div class="mb-6 p-4 rounded-lg <?= $messageType === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' ?>">
            <div class="flex items-center">
                <i class="fas <?= $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?> mr-2"></i>
                <?= escape($message) ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Formulaire -->
        <?php if ($validToken): ?>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
            <form method="POST" class="space-y-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nouveau mot de passe
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               minlength="6"
                               class="w-full px-4 py-3 pl-12 pr-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="Minimum 6 caractères">
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button type="button" 
                                onclick="togglePassword('password', 'password-icon')" 
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Confirmer le mot de passe
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="confirm_password" 
                               name="confirm_password" 
                               required
                               minlength="6"
                               class="w-full px-4 py-3 pl-12 pr-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="Répétez votre mot de passe">
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button type="button" 
                                onclick="togglePassword('confirm_password', 'confirm-password-icon')" 
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i id="confirm-password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-check mr-2"></i>
                    Réinitialiser le mot de passe
                </button>
            </form>
        </div>
        <?php else: ?>
        <!-- Token invalide -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700 text-center">
            <div class="mb-6">
                <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Lien invalide</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Ce lien de réinitialisation est invalide ou a expiré.
                </p>
            </div>
            
            <div class="space-y-4">
                <a href="<?= SITE_URL ?>/forgot-password.php" 
                   class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-redo mr-2"></i>
                    Demander un nouveau lien
                </a>
                
                <a href="<?= SITE_URL ?>/login.php" 
                   class="block text-orange-600 hover:text-orange-700 font-medium transition-colors">
                    Retour à la connexion
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Retour au site -->
        <div class="mt-6 text-center">
            <a href="<?= SITE_URL ?>" class="inline-flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                <i class="fas fa-home mr-2"></i>
                Retour au site
            </a>
        </div>
    </div>
</main>

<script>
function togglePassword(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const passwordIcon = document.getElementById(iconId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.className = 'fas fa-eye-slash';
    } else {
        passwordInput.type = 'password';
        passwordIcon.className = 'fas fa-eye';
    }
}

// Validation en temps réel
document.getElementById('confirm_password')?.addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && password !== confirmPassword) {
        this.setCustomValidity('Les mots de passe ne correspondent pas');
    } else {
        this.setCustomValidity('');
    }
});

// Redirection automatique après réinitialisation réussie
<?php if ($messageType === 'success'): ?>
setTimeout(function() {
    window.location.href = '<?= SITE_URL ?>/login.php';
}, 3000);
<?php endif; ?>
</script>

<?php require_once 'includes/footer.php'; ?>
