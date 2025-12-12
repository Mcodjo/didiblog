<?php
require_once 'config/config.php';
require_once 'core/functions.php';

// Rediriger si déjà connecté
if (isLoggedIn()) {
    redirect(SITE_URL . '/admin/');
}

$message = '';
$messageType = '';

if ($_POST) {
    $email = trim($_POST['email']);
    
    if (!isValidEmail($email)) {
        $message = 'Veuillez saisir une adresse email valide.';
        $messageType = 'error';
    } else {
        $pdo = getDatabase();
        
        // Vérifier si l'email existe
        $stmt = $pdo->prepare("SELECT id, username, prenom, nom FROM users WHERE email = :email AND actif = 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Générer un token de réinitialisation
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Stocker le token en base
            $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at) ON DUPLICATE KEY UPDATE token = :token, expires_at = :expires_at");
            $stmt->execute([
                ':user_id' => $user['id'],
                ':token' => $token,
                ':expires_at' => $expires
            ]);
            
            // Envoyer l'email de réinitialisation
            $resetLink = SITE_URL . '/reset-password.php?token=' . $token;
            $subject = 'Réinitialisation de votre mot de passe - Emploi Connect';
            $emailMessage = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <div style='background: linear-gradient(135deg, #f97316, #2563eb); padding: 30px; text-align: center;'>
                    <h1 style='color: white; margin: 0; font-size: 24px;'>Emploi Connect</h1>
                </div>
                <div style='padding: 30px; background: #f9f9f9;'>
                    <h2 style='color: #333; margin-bottom: 20px;'>Réinitialisation de mot de passe</h2>
                    <p style='color: #666; line-height: 1.6; margin-bottom: 20px;'>
                        Bonjour {$user['prenom']} {$user['nom']},
                    </p>
                    <p style='color: #666; line-height: 1.6; margin-bottom: 20px;'>
                        Vous avez demandé la réinitialisation de votre mot de passe pour votre compte <strong>{$user['username']}</strong>.
                    </p>
                    <p style='color: #666; line-height: 1.6; margin-bottom: 30px;'>
                        Cliquez sur le bouton ci-dessous pour créer un nouveau mot de passe :
                    </p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='{$resetLink}' 
                           style='background: #f97316; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>
                            Réinitialiser mon mot de passe
                        </a>
                    </div>
                    <p style='color: #999; font-size: 14px; line-height: 1.6; margin-top: 30px;'>
                        Ce lien expire dans 1 heure. Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.
                    </p>
                    <p style='color: #999; font-size: 14px; line-height: 1.6;'>
                        Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :<br>
                        <span style='word-break: break-all;'>{$resetLink}</span>
                    </p>
                </div>
                <div style='background: #333; padding: 20px; text-align: center;'>
                    <p style='color: #999; margin: 0; font-size: 14px;'>
                        © " . date('Y') . " Emploi Connect - Coach Didi
                    </p>
                </div>
            </div>";
            
            if (sendEmail($email, $subject, $emailMessage)) {
                $message = 'Un email de réinitialisation a été envoyé à votre adresse email.';
                $messageType = 'success';
            } else {
                $message = 'Erreur lors de l\'envoi de l\'email. Veuillez réessayer.';
                $messageType = 'error';
            }
        } else {
            // Pour des raisons de sécurité, on affiche le même message même si l'email n'existe pas
            $message = 'Un email de réinitialisation a été envoyé à votre adresse email si elle existe dans notre système.';
            $messageType = 'success';
        }
    }
}

$pageTitle = 'Mot de passe oublié - Emploi Connect';
$pageDescription = 'Réinitialisez votre mot de passe Emploi Connect';
?>

<?php require_once 'includes/header.php'; ?>

<main class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 py-20">
    <div class="max-w-md w-full mx-4">
        <!-- Logo et titre -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-600 to-orange-700 rounded-full mb-4">
                <i class="fas fa-key text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Mot de passe oublié</h1>
            <p class="text-gray-600 dark:text-gray-400">
                Saisissez votre adresse email pour recevoir un lien de réinitialisation
            </p>
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
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">
            <form method="POST" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Adresse email
                    </label>
                    <div class="relative">
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               value="<?= isset($_POST['email']) ? escape($_POST['email']) : '' ?>"
                               class="w-full px-4 py-3 pl-12 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="votre@email.com">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Envoyer le lien de réinitialisation
                </button>
            </form>

            <!-- Liens -->
            <div class="mt-8 space-y-4">
                <div class="text-center">
                    <a href="<?= SITE_URL ?>/login.php" class="text-orange-600 hover:text-orange-700 font-medium transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour à la connexion
                    </a>
                </div>
                
                <div class="text-center">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Pas encore de compte ? 
                        <a href="<?= SITE_URL ?>/register.php" class="text-orange-600 hover:text-orange-700 font-medium transition-colors">
                            S'inscrire
                        </a>
                    </p>
                </div>
            </div>

            <!-- Retour au site -->
            <div class="mt-6 text-center">
                <a href="<?= SITE_URL ?>" class="inline-flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                    <i class="fas fa-home mr-2"></i>
                    Retour au site
                </a>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
