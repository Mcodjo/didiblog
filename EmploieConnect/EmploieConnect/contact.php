<?php
require_once 'config/config.php';
require_once 'core/functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = cleanInput($_POST['nom'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $sujet = cleanInput($_POST['sujet'] ?? '');
    $message = cleanInput($_POST['message'] ?? '');
    $type = cleanInput($_POST['type'] ?? 'general');
    
    // Validation
    if (empty($nom) || empty($email) || empty($sujet) || empty($message)) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!isValidEmail($email)) {
        $error = 'Veuillez entrer une adresse email valide.';
    } else {
        try {
            $pdo = getDatabase();
            
            // Insérer le message de contact
            $stmt = $pdo->prepare("INSERT INTO contacts (nom, email, sujet, message, type, ip_address) VALUES (:nom, :email, :sujet, :message, :type, :ip)");
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':sujet' => $sujet,
                ':message' => $message,
                ':type' => $type,
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? ''
            ]);
            
            $success = 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.';
            
            // Envoyer une notification par email
            $emailSubject = 'Nouveau message de contact - ' . $sujet;
            $emailMessage = "
            <h2>Nouveau message de contact</h2>
            <p><strong>Nom :</strong> $nom</p>
            <p><strong>Email :</strong> $email</p>
            <p><strong>Type :</strong> $type</p>
            <p><strong>Sujet :</strong> $sujet</p>
            <p><strong>Message :</strong></p>
            <p>" . nl2br(escape($message)) . "</p>
            <p><strong>IP :</strong> " . ($_SERVER['REMOTE_ADDR'] ?? 'Inconnue') . "</p>
            <p><strong>Date :</strong> " . date('d/m/Y H:i:s') . "</p>
            ";
            
            sendEmail(CONTACT_EMAIL, $emailSubject, $emailMessage);
            
            // Réinitialiser les champs
            $nom = $email = $sujet = $message = '';
            
        } catch (Exception $e) {
            $error = 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer.';
        }
    }
}

$pageTitle = 'Contact - Emploi Connect';
$pageDescription = 'Contactez Coach Didi pour vos questions sur l\'emploi, les formations ou pour un coaching personnalisé.';

require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-600 to-blue-600 text-white py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold mb-6">
            <i class="fas fa-envelope mr-3"></i>
            Contactez-moi
        </h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Une question ? Un projet ? Besoin d'un coaching personnalisé ? Je suis là pour t'aider à décrocher l'emploi de tes rêves !
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Informations de contact -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
                    <i class="fas fa-info-circle text-orange-600 mr-3"></i>
                    Mes coordonnées
                </h2>
                
                <div class="space-y-6 mb-8">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-orange-600 dark:text-orange-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Email</h3>
                            <p class="text-gray-600 dark:text-gray-400"><?= CONTACT_EMAIL ?></p>
                            <p class="text-sm text-gray-500 dark:text-gray-500">Réponse sous 24h maximum</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-orange-600 dark:text-orange-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Téléphone</h3>
                            <p class="text-gray-600 dark:text-gray-400">+229 66 68 34 87</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500">Lun-Ven 9h-18h</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-orange-600 dark:text-orange-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Localisation</h3>
                            <p class="text-gray-600 dark:text-gray-400">Bénin</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500">Consultations en ligne</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-orange-600 dark:text-orange-400"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Horaires</h3>
                            <p class="text-gray-600 dark:text-gray-400">Lundi - Vendredi : 9h - 18h</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500">Samedi sur rendez-vous</p>
                        </div>
                    </div>
                </div>
                
                <!-- Réseaux sociaux -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Suivez-moi</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-sky-500 hover:bg-sky-600 text-white rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-500 hover:bg-pink-600 text-white rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Formulaire de contact -->
            <div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-paper-plane text-orange-600 mr-3"></i>
                        Envoyez-moi un message
                    </h2>
                    
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
                    
                    <form method="POST" class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom complet *
                                </label>
                                <input type="text" 
                                       id="nom" 
                                       name="nom" 
                                       required
                                       value="<?= escape($nom ?? '') ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Votre nom et prénom">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Adresse email *
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       required
                                       value="<?= escape($email ?? '') ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="votre@email.com">
                            </div>
                        </div>
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type de demande
                            </label>
                            <select id="type" 
                                    name="type"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="general">Question générale</option>
                                <option value="coaching">Coaching personnalisé</option>
                                <option value="formation">Information sur les formations</option>
                                <option value="partenariat">Partenariat</option>
                                <option value="media">Demande média</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="sujet" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Sujet *
                            </label>
                            <input type="text" 
                                   id="sujet" 
                                   name="sujet" 
                                   required
                                   value="<?= escape($sujet ?? '') ?>"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   placeholder="Résumez votre demande en quelques mots">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Message *
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      required
                                      rows="6"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                                      placeholder="Décrivez votre demande en détail..."><?= escape($message ?? '') ?></textarea>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-handshake text-orange-600 mr-3"></i>
                Mes Services
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Je t'accompagne à chaque étape de ta recherche d'emploi avec des solutions personnalisées
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-alt text-2xl text-orange-600 dark:text-orange-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Optimisation CV</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Création et optimisation de CV percutants qui sortent du lot
                </p>
                <div class="text-orange-600 dark:text-orange-400 font-semibold"></div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-comments text-2xl text-orange-600 dark:text-orange-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Préparation Entretiens</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Simulations d'entretiens et coaching pour réussir tes entretiens
                </p>
                <div class="text-orange-600 dark:text-orange-400 font-semibold"></div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-2xl text-orange-600 dark:text-orange-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Stratégie Recherche</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Plan d'action personnalisé pour optimiser ta recherche d'emploi
                </p>
                <div class="text-orange-600 dark:text-orange-400 font-semibold"></div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="<?= SITE_URL ?>/formations.php" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold rounded-lg transition-all duration-300">
                <i class="fas fa-graduation-cap mr-2"></i>
                Découvrir toutes les formations
            </a>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-question-circle text-orange-600 mr-3"></i>
                Questions Fréquentes
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Les réponses aux questions les plus courantes
            </p>
        </div>
        
        <div class="max-w-4xl mx-auto">
            <div class="space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
                    <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none" onclick="toggleFaq(this)">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">Combien de temps faut-il pour voir des résultats ?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            En moyenne, mes clients trouvent un emploi dans les 2-3 mois suivant l'application de mes méthodes. Cependant, cela dépend de votre secteur, votre expérience et votre implication dans le processus.
                        </p>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
                    <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none" onclick="toggleFaq(this)">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">Proposez-vous un suivi personnalisé ?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            Oui ! Toutes mes formations incluent un suivi personnalisé par email. Pour un accompagnement plus poussé, je propose également des sessions de coaching individuel.
                        </p>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
                    <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none" onclick="toggleFaq(this)">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">Vos méthodes fonctionnent-elles pour tous les secteurs ?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            Absolument ! Mes méthodes sont adaptables à tous les secteurs d'activité. J'ai accompagné des profils très variés : IT, marketing, finance, RH, commerce, etc.
                        </p>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
                    <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none" onclick="toggleFaq(this)">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">Que se passe-t-il si je ne suis pas satisfait(e) ?</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform"></i>
                    </button>
                    <div class="faq-content hidden px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            Je propose une garantie satisfait ou remboursé de 30 jours sur toutes mes formations. Si vous n'êtes pas satisfait(e), je vous rembourse intégralement.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleFaq(button) {
    const content = button.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>

<?php require_once 'includes/footer.php'; ?>
