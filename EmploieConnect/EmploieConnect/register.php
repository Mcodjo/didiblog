<?php
require_once 'config/config.php';
require_once 'core/functions.php';

// Redirection si déjà connecté
if (isLoggedIn()) {
    redirect(SITE_URL . '/admin/');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = cleanInput($_POST['username'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $prenom = cleanInput($_POST['prenom'] ?? '');
    $nom = cleanInput($_POST['nom'] ?? '');
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($prenom) || empty($nom)) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!isValidEmail($email)) {
        $error = 'Veuillez entrer une adresse email valide.';
    } elseif (strlen($password) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        $pdo = getDatabase();
        
        // Vérifier si l'utilisateur ou l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->execute([':username' => $username, ':email' => $email]);
        
        if ($stmt->fetch()) {
            $error = 'Ce nom d\'utilisateur ou cette adresse email est déjà utilisé.';
        } else {
            // Créer le nouvel utilisateur
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, prenom, nom, role) VALUES (:username, :email, :password, :prenom, :nom, 'user')");
            
            if ($stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':prenom' => $prenom,
                ':nom' => $nom
            ])) {
                $success = 'Compte créé avec succès ! Redirection vers la page de connexion...';
                
                // Envoyer un email de bienvenue (optionnel)
                $subject = 'Bienvenue sur Emploi Connect';
                $message = "
                <h2>Bienvenue $prenom $nom !</h2>
                <p>Votre compte utilisateur a été créé avec succès sur Emploi Connect.</p>
                <p><strong>Nom d'utilisateur :</strong> $username</p>
                <p>Vous pouvez maintenant vous connecter pour accéder à nos contenus et services.</p>
                <p><a href='" . SITE_URL . "/login.php'>Se connecter</a></p>
                ";
                
                sendEmail($email, $subject, $message);
            } else {
                $error = 'Une erreur est survenue lors de la création du compte.';
            }
        }
    }
}

$pageTitle = 'Inscription - Emploi Connect';
$pageDescription = 'Créez votre compte administrateur Emploi Connect';
?>

<?php require_once 'includes/header.php'; ?>

<main class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 py-20">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-2xl text-orange-600 dark:text-orange-400"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Inscription</h1>
                <p class="text-gray-600 dark:text-gray-400">Créez votre compte utilisateur</p>
            </div>

            <!-- Messages -->
            <?php if ($error): ?>
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="text-red-700 dark:text-red-400"><?= escape($error) ?></span>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($success): ?>
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-green-700 dark:text-green-400"><?= escape($success) ?></span>
                </div>
            </div>
            <?php endif; ?>

            <!-- Formulaire d'inscription -->
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Prénom *
                        </label>
                        <input type="text" 
                               id="prenom" 
                               name="prenom" 
                               required
                               value="<?= escape($_POST['prenom'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="Votre prénom">
                    </div>
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nom *
                        </label>
                        <input type="text" 
                               id="nom" 
                               name="nom" 
                               required
                               value="<?= escape($_POST['nom'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="Votre nom">
                    </div>
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nom d'utilisateur *
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="username" 
                               name="username" 
                               required
                               value="<?= escape($_POST['username'] ?? '') ?>"
                               class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="Choisissez un nom d'utilisateur">
                        <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Adresse email *
                    </label>
                    <div class="relative">
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               value="<?= escape($_POST['email'] ?? '') ?>"
                               class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="votre@email.com">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Mot de passe *
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               minlength="6"
                               class="w-full px-4 py-3 pl-12 pr-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="Au moins 6 caractères">
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
                        Confirmer le mot de passe *
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

                <div class="flex items-start">
                    <input type="checkbox" 
                           id="terms" 
                           name="terms" 
                           required
                           class="w-4 h-4 mt-1 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                    <label for="terms" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                        J'accepte les <a href="<?= SITE_URL ?>/cgv.php" class="text-orange-600 hover:text-orange-700 transition-colors">conditions générales</a> 
                        et la <a href="<?= SITE_URL ?>/politique-confidentialite.php" class="text-orange-600 hover:text-orange-700 transition-colors">politique de confidentialité</a>
                    </label>
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Créer mon compte
                </button>
            </form>

            <!-- Lien vers la connexion -->
            <div class="mt-8 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    Déjà un compte ? 
                    <a href="<?= SITE_URL ?>/login.php" class="text-orange-600 hover:text-orange-700 font-medium transition-colors">
                        Se connecter
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
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && password !== confirmPassword) {
        this.setCustomValidity('Les mots de passe ne correspondent pas');
    } else {
        this.setCustomValidity('');
    }
});

// Redirection automatique désactivée - l'utilisateur peut cliquer manuellement sur le lien
</script>

<?php require_once 'includes/footer.php'; ?>
