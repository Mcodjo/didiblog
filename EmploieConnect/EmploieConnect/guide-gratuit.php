<?php
require_once 'config/config.php';
require_once 'core/functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = cleanInput($_POST['nom'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    
    if (empty($nom) || empty($email)) {
        $error = 'Veuillez remplir tous les champs.';
    } elseif (!isValidEmail($email)) {
        $error = 'Veuillez entrer une adresse email valide.';
    } else {
        try {
            $pdo = getDatabase();
            
            // Vérifier si l'email existe déjà dans la newsletter
            $stmt = $pdo->prepare("SELECT id FROM newsletter WHERE email = :email");
            $stmt->execute([':email' => $email]);
            
            if (!$stmt->fetch()) {
                // Ajouter à la newsletter
                $stmt = $pdo->prepare("INSERT INTO newsletter (email, source) VALUES (:email, :source)");
                $stmt->execute([
                    ':email' => $email,
                    ':source' => 'guide-gratuit'
                ]);
            }
            
            setFlashMessage('success', 'Merci ' . $nom . ' ! Ton guide gratuit a été envoyé à ' . $email);
            
            // Envoyer le guide par email
            $subject = 'Ton Guide Gratuit "Comment Décrocher un Emploi en 30 Jours"';
            $message = "
            <h2>Bonjour $nom !</h2>
            <p>Merci d'avoir téléchargé mon guide gratuit. Tu vas découvrir mes meilleures stratégies pour décrocher un emploi rapidement.</p>
            
            <h3>🎯 Ce que tu vas apprendre dans ce guide :</h3>
            <ul>
                <li>La méthode exacte pour optimiser ton CV</li>
                <li>Comment réussir tes entretiens d'embauche</li>
                <li>Les secrets pour te démarquer sur LinkedIn</li>
                <li>Mon plan d'action en 30 jours</li>
                <li>Les erreurs à éviter absolument</li>
            </ul>
            
            <p><strong>🔗 <a href='" . SITE_URL . "/downloads/guide-emploi-30-jours.pdf'>Télécharger ton guide maintenant</a></strong></p>
            
            <p>En bonus, tu recevras également mes meilleurs conseils directement dans ta boîte mail !</p>
            
            <p>Bonne lecture et à très bientôt,<br>
            Coach Didi</p>
            
            <hr>
            <p><small>Tu peux aussi explorer mes <a href='" . SITE_URL . "/formations.php'>formations complètes</a> pour aller plus loin.</small></p>
            ";
            
            if (sendEmail($email, $subject, $message)) {
                $success = "Merci $nom ! Ton guide gratuit a été envoyé à $email. Vérifie ta boîte mail (et tes spams) !";
            } else {
                $error = 'Erreur lors de l\'envoi de l\'email. Veuillez réessayer.';
            }
            
        } catch (Exception $e) {
            $error = 'Une erreur est survenue. Veuillez réessayer.';
        }
    }
}

$pageTitle = 'Guide Gratuit - Emploi Connect';
$pageDescription = 'Téléchargez gratuitement le guide "Comment Décrocher un Emploi en 30 Jours" par Coach Didi. Stratégies éprouvées et plan d\'action concret.';

require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="bg-gradient-to-br from-orange-600 via-orange-500 to-blue-600 text-white py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-8">
                <div class="inline-flex items-center px-4 py-2 bg-white/20 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-gift mr-2"></i>
                    100% GRATUIT
                </div>
                <h1 class="text-4xl lg:text-6xl font-bold mb-6">
                    Comment Décrocher un Emploi<br>
                    <span class="text-yellow-300">en 30 Jours</span>
                </h1>
                <p class="text-xl lg:text-2xl mb-8 opacity-90">
                    Le guide complet avec mes stratégies éprouvées pour transformer ta recherche d'emploi
                </p>
            </div>
            
            <!-- Guide Preview -->
            <div class="relative mb-12">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                        <div class="text-left">
                            <h2 class="text-2xl font-bold mb-6">🎯 Ce que tu vas découvrir :</h2>
                            <ul class="space-y-3">
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-yellow-300 mr-3"></i>
                                    <span>La méthode exacte pour optimiser ton CV</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-yellow-300 mr-3"></i>
                                    <span>Comment réussir tes entretiens d'embauche</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-yellow-300 mr-3"></i>
                                    <span>Les secrets pour te démarquer sur LinkedIn</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-yellow-300 mr-3"></i>
                                    <span>Mon plan d'action jour par jour</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check-circle text-yellow-300 mr-3"></i>
                                    <span>Les erreurs à éviter absolument</span>
                                </li>
                            </ul>
                        </div>
                        <div class="text-center">
                            <div class="relative inline-block">
                                <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                                     alt="Guide Emploi 30 Jours" 
                                     class="w-64 h-80 object-cover rounded-lg shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-300">
                                <div class="absolute -top-4 -right-4 bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-bold">
                                    GRATUIT
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Formulaire de téléchargement -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 border border-gray-100 dark:border-gray-700">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-download text-2xl text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Télécharge ton guide maintenant
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Entre tes informations ci-dessous pour recevoir ton guide gratuit par email
                    </p>
                </div>

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
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Prénom *
                        </label>
                        <input type="text" 
                               id="nom" 
                               name="nom" 
                               required
                               value="<?= escape($_POST['nom'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="Ton prénom">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Adresse email *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               value="<?= escape($_POST['email'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                               placeholder="ton@email.com">
                    </div>

                    <div class="flex items-start">
                        <input type="checkbox" 
                               id="newsletter" 
                               name="newsletter" 
                               checked
                               class="w-4 h-4 mt-1 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                        <label for="newsletter" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            Je souhaite recevoir les conseils de Coach Didi par email (recommandé)
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-bold py-4 px-6 rounded-lg transition-all duration-300 flex items-center justify-center text-lg">
                        <i class="fas fa-download mr-3"></i>
                        Télécharger mon guide gratuit
                    </button>

                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                        En téléchargeant ce guide, tu acceptes de recevoir mes emails. Tu peux te désabonner à tout moment.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Pourquoi ce guide -->
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Pourquoi j'ai créé ce guide ?
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Après avoir aidé plus de 4,300 personnes à décrocher leur emploi de rêve
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://page.gensparksite.com/v1/base64_upload/a456eb81c0763b6540288c7203d94cf5" 
                         alt="Coach Didi" 
                         class="w-full rounded-xl shadow-lg">
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        Salut, moi c'est Didi ! 👋
                    </h3>
                    <div class="space-y-4 text-gray-600 dark:text-gray-400">
                        <p>
                            En tant que coach en employabilité, j'ai remarqué que beaucoup de personnes talentueuses 
                            restaient bloquées dans leur recherche d'emploi à cause de petites erreurs facilement évitables.
                        </p>
                        <p>
                            C'est pourquoi j'ai décidé de rassembler dans ce guide gratuit toutes les stratégies 
                            qui fonctionnent vraiment pour décrocher un emploi rapidement.
                        </p>
                        <p>
                            <strong>Le résultat ?</strong> Mes clients trouvent en moyenne un emploi en 2,3 mois 
                            (contre 6-8 mois en moyenne nationale).
                        </p>
                    </div>
                    
                    <div class="mt-8 p-6 bg-orange-50 dark:bg-orange-900/20 rounded-lg border border-orange-200 dark:border-orange-800">
                        <h4 class="font-semibold text-orange-800 dark:text-orange-200 mb-2">
                            🏆 Mes résultats en chiffres :
                        </h4>
                        <ul class="space-y-1 text-orange-700 dark:text-orange-300 text-sm">
                            <li>• 4,300+ personnes accompagnées</li>
                            <li>• 94% de taux de réussite</li>
                            <li>• 2,3 mois de délai moyen d'embauche</li>
                            <li>• 4,8/5 de note de satisfaction</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Témoignages -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Ce qu'ils disent du guide
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Plus de 15,000 téléchargements et des retours exceptionnels
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400 italic mb-4">
                    "Grâce à ce guide, j'ai décroché un CDI en 3 semaines ! Les conseils sont concrets et faciles à appliquer."
                </p>
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" 
                         alt="Sarah M." 
                         class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Sarah M.</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Marketing Digital</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400 italic mb-4">
                    "Le plan d'action en 30 jours m'a permis de structurer ma recherche. J'ai enfin trouvé ma voie !"
                </p>
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" 
                         alt="Thomas L." 
                         class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Thomas L.</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Développeur Web</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex text-yellow-400 mb-4">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="text-gray-600 dark:text-gray-400 italic mb-4">
                    "Excellent guide ! J'ai appliqué les conseils CV et j'ai eu 3 entretiens la semaine suivante."
                </p>
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=50&q=80" 
                         alt="Marie D." 
                         class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Marie D.</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Responsable RH</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="py-16 bg-gradient-to-r from-orange-600 to-blue-600 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">
            Prêt(e) à transformer ta recherche d'emploi ?
        </h2>
        <p class="text-lg mb-8 max-w-2xl mx-auto opacity-90">
            Rejoins les milliers de personnes qui ont déjà téléchargé ce guide et trouvé leur emploi de rêve !
        </p>
        <a href="#" onclick="document.getElementById('nom').scrollIntoView({behavior: 'smooth'}); document.getElementById('nom').focus()" 
           class="inline-flex items-center px-8 py-4 bg-white text-orange-600 font-bold rounded-lg hover:bg-gray-100 transition-colors text-lg">
            <i class="fas fa-download mr-3"></i>
            Télécharger maintenant (100% gratuit)
        </a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
