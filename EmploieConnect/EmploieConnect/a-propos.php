<?php
require_once 'config/config.php';
require_once 'core/functions.php';

$pdo = getDatabase();

// Récupération des sections "À propos"
try {
    $stmt = $pdo->prepare("SELECT * FROM about WHERE actif = 1 ORDER BY ordre ASC, id ASC");
    $stmt->execute();
    $sections = $stmt->fetchAll();
} catch (Exception $e) {
    $sections = [];
}

// Meta tags
$pageTitle = 'À Propos - Coach Didi | Emploi Connect';
$pageDescription = 'Découvrez Coach Didi, votre expert en employabilité. Plus de 4 300 personnes accompagnées vers l\'emploi avec des méthodes éprouvées et un coaching personnalisé.';

require_once 'includes/header.php';

// Fonction pour convertir le markdown simple en HTML
function simpleMarkdown($text) {
    // Gras **texte**
    $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
    
    // Italique *texte*
    $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
    
    // Listes • item
    $text = preg_replace('/^• (.+)$/m', '<li>$1</li>', $text);
    $text = preg_replace('/(<li>.*<\/li>)/s', '<ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-400">$1</ul>', $text);
    
    // Sauts de ligne
    $text = nl2br($text);
    
    return $text;
}
?>

<!-- Hero Section -->
<?php 
$heroSection = null;
foreach ($sections as $section) {
    if ($section['section_key'] === 'hero') {
        $heroSection = $section;
        break;
    }
}
?>

<?php if ($heroSection): ?>
<section class="relative py-20 lg:py-32 bg-gradient-to-br from-orange-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                    <?= escape($heroSection['title']) ?>
                </h1>
                <div class="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                    <?= simpleMarkdown($heroSection['content']) ?>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?= SITE_URL ?>/formations.php" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Découvrir mes formations
                    </a>
                    <a href="<?= SITE_URL ?>/contact.php" class="inline-flex items-center px-8 py-4 border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-envelope mr-2"></i>
                        Me contacter
                    </a>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <?php if ($heroSection['image_url']): ?>
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-blue-500 rounded-2xl transform rotate-3"></div>
                    <img src="<?= escape($heroSection['image_url']) ?>" 
                         alt="Coach Didi" 
                         class="relative w-full max-w-md mx-auto rounded-2xl shadow-2xl border-4 border-white">
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Statistiques -->
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl text-orange-600 dark:text-orange-400"></i>
                </div>
                <div class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 stat-counter" data-target="4300+">
                    <span class="counter-value">0</span>
                </div>
                <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Personnes accompagnées</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Vers l'emploi de leurs rêves</div>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-line text-2xl text-green-600 dark:text-green-400"></i>
                </div>
                <div class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 stat-counter" data-target="85%">
                    <span class="counter-value">0%</span>
                </div>
                <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Taux de réussite</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Dans les 3 mois</div>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-2xl text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 stat-counter" data-target="2-3">
                    <span class="counter-value">0</span>
                </div>
                <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Mois en moyenne</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Pour décrocher un emploi</div>
            </div>
            
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-2xl text-purple-600 dark:text-purple-400"></i>
                </div>
                <div class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 stat-counter" data-target="5+">
                    <span class="counter-value">0</span>
                </div>
                <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1">Années d'expérience</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">En coaching emploi</div>
            </div>
        </div>
    </div>
</section>

<!-- Sections dynamiques -->
<?php 
$otherSections = array_filter($sections, function($section) {
    return $section['section_key'] !== 'hero';
});
?>

<?php if ($otherSections): ?>
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto space-y-16">
            <?php foreach ($otherSections as $index => $section): ?>
            <div class="<?= $index % 2 === 0 ? 'lg:flex lg:items-center lg:space-x-12' : 'lg:flex lg:flex-row-reverse lg:items-center lg:space-x-reverse lg:space-x-12' ?>">
                <?php if ($section['image_url']): ?>
                <div class="lg:w-1/3 mb-8 lg:mb-0">
                    <img src="<?= escape($section['image_url']) ?>" 
                         alt="<?= escape($section['title']) ?>" 
                         class="w-full rounded-xl shadow-lg">
                </div>
                <?php endif; ?>
                
                <div class="<?= $section['image_url'] ? 'lg:w-2/3' : 'w-full' ?>">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                        <?= escape($section['title']) ?>
                    </h2>
                    <div class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed prose prose-lg max-w-none">
                        <?= simpleMarkdown($section['content']) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Témoignages -->
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-quote-left text-orange-600 mr-3"></i>
                Ce qu'ils disent de moi
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Découvrez les témoignages de personnes qui ont transformé leur carrière grâce à mes méthodes.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-4 italic">
                    "Grâce aux conseils de Coach Didi, j'ai décroché mon emploi de rêve en seulement 6 semaines ! Ses méthodes sont vraiment efficaces."
                </p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-200 rounded-full flex items-center justify-center mr-3">
                        <span class="text-orange-800 font-semibold">M</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">Marie L.</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Développeuse Web</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-4 italic">
                    "Un accompagnement personnalisé exceptionnel. Coach Didi m'a aidé à reprendre confiance et à optimiser ma recherche d'emploi."
                </p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center mr-3">
                        <span class="text-blue-800 font-semibold">A</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">Ahmed K.</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Chef de Projet</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-4 italic">
                    "Les formations de Coach Didi sont un investissement qui en vaut la peine. J'ai multiplié mes entretiens par 3 !"
                </p>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-200 rounded-full flex items-center justify-center mr-3">
                        <span class="text-green-800 font-semibold">S</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-white">Sophie M.</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">Marketing Manager</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Final -->
<section class="py-16 bg-gradient-to-r from-orange-600 to-blue-600 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold mb-6">
            Prêt(e) à transformer ta carrière ?
        </h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Rejoins les milliers de personnes qui ont déjà décroché leur emploi de rêve grâce à mes méthodes éprouvées.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= SITE_URL ?>/formations.php" class="inline-flex items-center px-8 py-4 bg-white text-orange-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-graduation-cap mr-2"></i>
                Découvrir mes formations
            </a>
            <a href="<?= SITE_URL ?>/guide-gratuit.php" class="inline-flex items-center px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-orange-600 font-semibold rounded-lg transition-colors">
                <i class="fas fa-download mr-2"></i>
                Guide gratuit
            </a>
            <a href="<?= SITE_URL ?>/contact.php" class="inline-flex items-center px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-orange-600 font-semibold rounded-lg transition-colors">
                <i class="fas fa-envelope mr-2"></i>
                Me contacter
            </a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
