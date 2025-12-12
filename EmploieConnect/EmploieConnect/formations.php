<?php
require_once 'config/config.php';
require_once 'core/functions.php';
require_once 'models/Formation.php';

// Connexion à la base de données
$pdo = getDatabase();

// Initialisation du modèle
$formationModel = new Formation($pdo);

// Récupération des formations
$formations = $formationModel->getAll();

// Récupération des témoignages
$stmt = $pdo->prepare("SELECT * FROM temoignages WHERE actif = 1 ORDER BY ordre ASC");
$stmt->execute();
$testimonials = $stmt->fetchAll();

// Meta tags
$pageTitle = 'Formations - Emploi Connect';
$pageDescription = 'Découvrez les formations de Coach Didi pour décrocher votre emploi de rêve. CV, entretiens, LinkedIn, recherche d\'emploi efficace.';

require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-600 to-blue-600 text-white py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold mb-6">
            <i class="fas fa-graduation-cap mr-3"></i>
            Mes Formations
        </h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Transforme ta carrière avec mes formations complètes. Méthodes éprouvées, exercices pratiques et suivi personnalisé pour décrocher l'emploi de tes rêves !
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#formations" class="inline-flex items-center px-8 py-4 bg-white text-orange-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-arrow-down mr-2"></i>
                Découvrir les formations
            </a>
            <a href="#temoignages" class="inline-flex items-center px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-orange-600 font-semibold rounded-lg transition-colors">
                <i class="fas fa-star mr-2"></i>
                Voir les témoignages
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-orange-600 mb-2">4,300+</div>
                <div class="text-gray-600 dark:text-gray-400">Personnes formées</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-orange-600 mb-2">94%</div>
                <div class="text-gray-600 dark:text-gray-400">Taux de réussite</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-orange-600 mb-2">2.3 mois</div>
                <div class="text-gray-600 dark:text-gray-400">Délai moyen d'embauche</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-orange-600 mb-2">4.8/5</div>
                <div class="text-gray-600 dark:text-gray-400">Note moyenne</div>
            </div>
        </div>
    </div>
</section>

<!-- Formations Section -->
<section id="formations" class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Catalogue de Formations
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Chaque formation est conçue pour te donner des résultats concrets et t'aider à décrocher l'emploi de tes rêves
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
            <?php foreach ($formations as $formation): ?>
            <div id="<?= escape($formation['slug']) ?>" class="formation-card bg-white dark:bg-gray-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 <?= $formation['slug'] === 'pack-vip' ? 'bg-gradient-to-br from-orange-600 to-blue-600 text-white transform scale-105' : '' ?>">
                
                <?php if ($formation['slug'] === 'pack-vip'): ?>
                <!-- Pack VIP avec design spécial -->
                <div class="relative p-8">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <div class="bg-yellow-400 text-gray-900 px-4 py-2 rounded-full text-sm font-bold">
                            🏆 PACK VIP - LE PLUS POPULAIRE
                        </div>
                    </div>
                    
                    <div class="text-center mb-6 mt-4">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-4">
                            <i class="fas fa-crown text-3xl text-yellow-300"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-3"><?= escape($formation['nom']) ?></h3>
                        <p class="text-white/90 mb-6"><?= escape($formation['description']) ?></p>
                    </div>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center text-white/90">
                            <i class="fas fa-check-circle text-yellow-300 mr-3"></i>
                            <span>Formation CV Optimisé</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <i class="fas fa-check-circle text-yellow-300 mr-3"></i>
                            <span>Préparation Entretiens</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <i class="fas fa-check-circle text-yellow-300 mr-3"></i>
                            <span>Stratégie LinkedIn</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <i class="fas fa-check-circle text-yellow-300 mr-3"></i>
                            <span>Plan d'action personnalisé</span>
                        </div>
                        <div class="flex items-center text-white/90">
                            <i class="fas fa-check-circle text-yellow-300 mr-3"></i>
                            <span>Suivi 6 mois</span>
                        </div>
                    </div>
                    
                    <div class="text-center mb-6">
                        <div class="text-4xl font-bold mb-2">
                            <?= number_format($formation['prix'], 0) ?>€
                            <span class="text-xl text-white/70 line-through ml-2"><?= number_format($formation['prix_barre'], 0) ?>€</span>
                        </div>
                        <div class="text-yellow-300 text-sm font-semibold">-43% jusqu'au 31 janvier !</div>
                        <div class="flex items-center justify-center mt-2">
                            <div class="flex text-yellow-300 mr-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="text-white/80">(<?= $formation['note'] ?>)</span>
                        </div>
                    </div>
                    
                    <button onclick="openModal('<?= escape($formation['slug']) ?>')" 
                            class="w-full bg-white text-orange-600 font-bold py-4 px-6 rounded-lg transition-all duration-300 hover:bg-gray-100 mb-4">
                        <i class="fas fa-crown mr-2"></i>
                        Accéder au Pack VIP
                    </button>
                    
                    <div class="text-center text-white/80 text-sm">
                        <i class="fas fa-shield-alt mr-1"></i>
                        Garantie satisfait ou remboursé 30 jours
                    </div>
                </div>
                
                <?php else: ?>
                <!-- Formations normales -->
                <div class="relative overflow-hidden rounded-t-2xl">
                    <img src="<?= escape($formation['image_url']) ?>" 
                         alt="<?= escape($formation['nom']) ?>" 
                         class="w-full h-48 object-cover">
                    <div class="absolute top-4 right-4 text-white px-3 py-1 rounded-full text-sm font-semibold" 
                         style="background-color: <?= escape($formation['couleur_badge']) ?>">
                        <?= escape($formation['badge']) ?>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        <?= escape($formation['nom']) ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        <?= escape($formation['description']) ?>
                    </p>
                    
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-clock mr-2 text-orange-600"></i>
                            <span>Durée : 4-6 semaines</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-video mr-2 text-orange-600"></i>
                            <span>Vidéos + Exercices pratiques</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-support mr-2 text-orange-600"></i>
                            <span>Support email inclus</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="text-2xl font-bold text-orange-600">
                            <?= number_format($formation['prix'], 0) ?>€
                            <?php if ($formation['prix_barre']): ?>
                            <span class="text-sm text-gray-500 line-through ml-2"><?= number_format($formation['prix_barre'], 0) ?>€</span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center space-x-1">
                            <div class="flex text-yellow-400">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star"></i>
                                <?php endfor; ?>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-400 ml-1">(<?= $formation['note'] ?>)</span>
                        </div>
                    </div>
                    
                    <button onclick="openModal('<?= escape($formation['slug']) ?>')" 
                            class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-play mr-2"></i>
                        Découvrir la formation
                    </button>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Témoignages Section -->
<section id="temoignages" class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-star text-orange-600 mr-3"></i>
                Témoignages
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Découvre ce que disent ceux qui ont déjà transformé leur carrière grâce à mes formations
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center mb-4">
                    <img src="<?= escape($testimonial['photo_url']) ?>" 
                         alt="<?= escape($testimonial['nom']) ?>" 
                         class="w-12 h-12 rounded-full mr-4 object-cover">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white"><?= escape($testimonial['nom']) ?></h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><?= escape($testimonial['poste']) ?></p>
                    </div>
                </div>
                
                <div class="flex text-yellow-400 mb-3">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class="fas fa-star"></i>
                    <?php endfor; ?>
                </div>
                
                <p class="text-gray-600 dark:text-gray-400 italic mb-4">
                    "<?= escape($testimonial['contenu']) ?>"
                </p>
                
                <div class="text-sm text-gray-500 dark:text-gray-500">
                    <?= formatDate($testimonial['created_at']) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-question-circle text-orange-600 mr-3"></i>
                Questions Fréquentes
            </h2>
        </div>
        
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
                <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none" onclick="toggleFaq(this)">
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Combien de temps durent les formations ?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform"></i>
                </button>
                <div class="faq-content hidden px-6 pb-4">
                    <p class="text-gray-600 dark:text-gray-400">
                        La plupart de mes formations durent entre 4 et 6 semaines. Tu peux suivre les modules à ton rythme, avec un accès à vie au contenu.
                    </p>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
                <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none" onclick="toggleFaq(this)">
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Y a-t-il un suivi personnalisé ?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform"></i>
                </button>
                <div class="faq-content hidden px-6 pb-4">
                    <p class="text-gray-600 dark:text-gray-400">
                        Oui ! Toutes mes formations incluent un support par email. Le Pack VIP inclut également des sessions de coaching individuelles.
                    </p>
                </div>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
                <button class="faq-button w-full px-6 py-4 text-left flex items-center justify-between focus:outline-none" onclick="toggleFaq(this)">
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Que se passe-t-il si je ne suis pas satisfait(e) ?</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform"></i>
                </button>
                <div class="faq-content hidden px-6 pb-4">
                    <p class="text-gray-600 dark:text-gray-400">
                        Je propose une garantie satisfait ou remboursé de 30 jours sur toutes mes formations. Aucune question posée !
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal pour les formations -->
<div id="formationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 id="modalTitle" class="text-2xl font-bold text-gray-900 dark:text-white"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="modalContent">
                <!-- Contenu dynamique -->
            </div>
            
            <div class="mt-6 flex gap-4">
                <button onclick="closeModal()" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Fermer
                </button>
                <a href="<?= SITE_URL ?>/contact.php" class="flex-1 px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors text-center">
                    Me contacter
                </a>
            </div>
        </div>
    </div>
</div>

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

function openModal(formationSlug) {
    const modal = document.getElementById('formationModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');
    
    // Contenu spécifique selon la formation
    const formations = {
        'cv-optimise': {
            title: 'Formation CV Optimisé',
            content: `
                <div class="space-y-4">
                    <p class="text-gray-600 dark:text-gray-400">Transforme ton CV en outil de vente puissant qui te démarque de la concurrence.</p>
                    <h4 class="font-semibold text-gray-900 dark:text-white">Ce que tu vas apprendre :</h4>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Structure optimale d'un CV moderne</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Mots-clés qui passent les filtres ATS</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Design professionnel et impactant</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Adaptation selon le poste visé</li>
                    </ul>
                    <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                        <p class="text-orange-800 dark:text-orange-200 font-semibold">Prix : 97€</p>
                        <p class="text-orange-600 dark:text-orange-400 text-sm">Accès à vie + Support email</p>
                    </div>
                </div>
            `
        },
        'entretiens-reussis': {
            title: 'Formation Entretiens Réussis',
            content: `
                <div class="space-y-4">
                    <p class="text-gray-600 dark:text-gray-400">Maîtrise l'art de l'entretien d'embauche et décroche le poste à tous les coups.</p>
                    <h4 class="font-semibold text-gray-900 dark:text-white">Ce que tu vas apprendre :</h4>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Préparation complète avant l'entretien</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Réponses aux questions pièges</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Langage corporel et communication</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Négociation de salaire</li>
                    </ul>
                    <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                        <p class="text-orange-800 dark:text-orange-200 font-semibold">Prix : 147€</p>
                        <p class="text-orange-600 dark:text-orange-400 text-sm">Simulations d'entretiens incluses</p>
                    </div>
                </div>
            `
        },
        'pack-vip': {
            title: 'Pack VIP - Formation Complète',
            content: `
                <div class="space-y-4">
                    <p class="text-gray-600 dark:text-gray-400">La formation la plus complète pour transformer ta carrière de A à Z.</p>
                    <h4 class="font-semibold text-gray-900 dark:text-white">Tout ce qui est inclus :</h4>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                        <li class="flex items-center"><i class="fas fa-crown text-yellow-500 mr-2"></i> Formation CV Optimisé (97€)</li>
                        <li class="flex items-center"><i class="fas fa-crown text-yellow-500 mr-2"></i> Formation Entretiens Réussis (147€)</li>
                        <li class="flex items-center"><i class="fas fa-crown text-yellow-500 mr-2"></i> Stratégie LinkedIn Pro (97€)</li>
                        <li class="flex items-center"><i class="fas fa-crown text-yellow-500 mr-2"></i> Plan d'action personnalisé</li>
                        <li class="flex items-center"><i class="fas fa-crown text-yellow-500 mr-2"></i> 3 sessions de coaching individuelles</li>
                        <li class="flex items-center"><i class="fas fa-crown text-yellow-500 mr-2"></i> Suivi pendant 6 mois</li>
                    </ul>
                    <div class="bg-gradient-to-r from-orange-500 to-blue-600 text-white p-4 rounded-lg">
                        <p class="font-bold text-xl">Prix : 197€ au lieu de 347€</p>
                        <p class="text-sm opacity-90">Économise 150€ avec le Pack VIP !</p>
                    </div>
                </div>
            `
        }
    };
    
    const formation = formations[formationSlug] || formations['cv-optimise'];
    modalTitle.textContent = formation.title;
    modalContent.innerHTML = formation.content;
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('formationModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('formationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Animation au scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.formation-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
});
</script>

<?php require_once 'includes/footer.php'; ?>
