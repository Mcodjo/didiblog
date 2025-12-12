<?php
require_once 'config/config.php';
require_once 'core/functions.php';

$pdo = getDatabase();
$success = '';
$error = '';

// Traitement du formulaire de témoignage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = cleanInput($_POST['nom'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $entreprise = cleanInput($_POST['entreprise'] ?? '');
    $poste = cleanInput($_POST['poste'] ?? '');
    $message = cleanInput($_POST['message'] ?? '');
    $note = (int)($_POST['note'] ?? 5);
    
    // Validation
    if (empty($nom) || empty($email) || empty($message)) {
        $error = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!isValidEmail($email)) {
        $error = 'Veuillez entrer une adresse email valide.';
    } elseif ($note < 1 || $note > 5) {
        $error = 'La note doit être comprise entre 1 et 5.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO testimonials (nom, email, entreprise, poste, message, note, ip_address) VALUES (:nom, :email, :entreprise, :poste, :message, :note, :ip)");
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':entreprise' => $entreprise,
                ':poste' => $poste,
                ':message' => $message,
                ':note' => $note,
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? ''
            ]);
            
            $success = 'Votre témoignage a été envoyé avec succès ! Il sera publié après validation par notre équipe.';
            
            // Réinitialiser les champs
            $nom = $email = $entreprise = $poste = $message = '';
            $note = 5;
            
        } catch (Exception $e) {
            $error = 'Une erreur est survenue lors de l\'envoi de votre témoignage. Veuillez réessayer.';
        }
    }
}

// Récupération des témoignages approuvés pour affichage
try {
    $stmt = $pdo->prepare("SELECT nom, entreprise, poste, message, note, created_at FROM testimonials WHERE statut = 'approuve' ORDER BY created_at DESC LIMIT 12");
    $stmt->execute();
    $approvedTestimonials = $stmt->fetchAll();
} catch (Exception $e) {
    $approvedTestimonials = [];
}

$pageTitle = 'Témoignages - Emploi Connect';
$pageDescription = 'Découvrez les témoignages de personnes qui ont transformé leur carrière grâce à Coach Didi. Partagez votre propre expérience !';

require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-600 to-blue-600 text-white py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold mb-6">
            <i class="fas fa-quote-left mr-3"></i>
            Témoignages
        </h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Découvrez les histoires de réussite de personnes qui ont transformé leur carrière grâce à mes méthodes et mon accompagnement.
        </p>
    </div>
</section>

<!-- Témoignages approuvés -->
<?php if (!empty($approvedTestimonials)): ?>
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Ce qu'ils disent de moi
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Plus de <?= count($approvedTestimonials) ?> personnes ont partagé leur expérience positive avec mes services.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($approvedTestimonials as $testimonial): ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400 mr-3">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star<?= $i <= $testimonial['note'] ? '' : '-o' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        <?= date('M Y', strtotime($testimonial['created_at'])) ?>
                    </span>
                </div>
                
                <blockquote class="text-gray-600 dark:text-gray-400 mb-4 italic leading-relaxed">
                    "<?= escape($testimonial['message']) ?>"
                </blockquote>
                
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-200 dark:bg-orange-800 rounded-full flex items-center justify-center mr-3">
                        <span class="text-orange-800 dark:text-orange-200 font-semibold">
                            <?= strtoupper(substr($testimonial['nom'], 0, 1)) ?>
                        </span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white"><?= escape($testimonial['nom']) ?></div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <?= escape($testimonial['poste']) ?><?= $testimonial['entreprise'] ? ' chez ' . escape($testimonial['entreprise']) : '' ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Formulaire de témoignage -->
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-pen text-orange-600 mr-3"></i>
                    Partagez votre expérience
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Vous avez bénéficié de mes services ? Partagez votre témoignage pour aider d'autres personnes dans leur recherche d'emploi !
                </p>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl shadow-xl p-8">
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                        
                        <div>
                            <label for="poste" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Poste actuel
                            </label>
                            <input type="text" 
                                   id="poste" 
                                   name="poste" 
                                   value="<?= escape($poste ?? '') ?>"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   placeholder="Développeur Web, Chef de Projet...">
                        </div>
                        
                        <div>
                            <label for="entreprise" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Entreprise
                            </label>
                            <input type="text" 
                                   id="entreprise" 
                                   name="entreprise" 
                                   value="<?= escape($entreprise ?? '') ?>"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                   placeholder="Nom de votre entreprise">
                        </div>
                    </div>
                    
                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Note sur 5 *
                        </label>
                        <div class="flex items-center space-x-2">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <label class="flex items-center">
                                <input type="radio" name="note" value="<?= $i ?>" <?= ($note ?? 5) == $i ? 'checked' : '' ?> class="sr-only">
                                <i class="fas fa-star text-2xl cursor-pointer star-rating <?= ($note ?? 5) >= $i ? 'text-yellow-400' : 'text-gray-300' ?>" data-rating="<?= $i ?>"></i>
                            </label>
                            <?php endfor; ?>
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">(<span id="rating-text"><?= $note ?? 5 ?></span>/5)</span>
                        </div>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Votre témoignage *
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  required
                                  rows="6"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                                  placeholder="Partagez votre expérience avec Coach Didi et comment ses services vous ont aidé..."><?= escape($message ?? '') ?></textarea>
                    </div>
                    
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mr-2 mt-1"></i>
                            <div class="text-sm text-blue-700 dark:text-blue-400">
                                <p class="font-medium mb-1">Information importante :</p>
                                <p>Votre témoignage sera examiné par notre équipe avant publication. Nous nous réservons le droit de ne pas publier les témoignages inappropriés ou non conformes à nos conditions d'utilisation.</p>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-4 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Envoyer mon témoignage
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-orange-600 to-blue-600 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6">
            Prêt(e) à écrire votre propre success story ?
        </h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Rejoignez les centaines de personnes qui ont transformé leur carrière grâce à mes méthodes éprouvées.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= SITE_URL ?>/formations.php" class="inline-flex items-center px-8 py-4 bg-white text-orange-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-graduation-cap mr-2"></i>
                Découvrir mes formations
            </a>
            <a href="<?= SITE_URL ?>/contact.php" class="inline-flex items-center px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-orange-600 font-semibold rounded-lg transition-colors">
                <i class="fas fa-envelope mr-2"></i>
                Me contacter
            </a>
        </div>
    </div>
</section>

<script>
// Gestion des étoiles de notation
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-rating');
    const ratingText = document.getElementById('rating-text');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            
            // Mettre à jour les étoiles visuellement
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
            
            // Mettre à jour le radio button
            document.querySelector(`input[name="note"][value="${rating}"]`).checked = true;
            
            // Mettre à jour le texte
            ratingText.textContent = rating;
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('text-yellow-300');
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            stars.forEach(s => {
                s.classList.remove('text-yellow-300');
            });
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
