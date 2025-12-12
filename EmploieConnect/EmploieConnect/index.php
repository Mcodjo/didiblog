<?php
require_once 'config/config.php';
require_once 'core/functions.php';
require_once 'models/Article.php';
require_once 'models/Category.php';
require_once 'models/Formation.php';

// Connexion à la base de données
$pdo = getDatabase();

// Initialisation des modèles
$articleModel = new Article($pdo);
$categoryModel = new Category($pdo);
$formationModel = new Formation($pdo);

// Récupération des données
$featuredArticle = $articleModel->getFeatured(1);
$recentArticles = $articleModel->getAll(4);
$categories = $categoryModel->getAll();
$formations = $formationModel->getAll();

// Statistiques
$stmt = $pdo->prepare("SELECT * FROM statistiques WHERE actif = 1 ORDER BY ordre ASC");
$stmt->execute();
$statistics = $stmt->fetchAll();

// Meta tags
$pageTitle = "Emploi Connect - Coach Didi | Blog pour décrocher un emploi plus vite";
$pageDescription = "Blog professionnel d'employabilité et carrière par Coach Didi. Conseils CV, entretiens, LinkedIn et recherche d'emploi pour étudiants et jeunes diplômés.";

require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section id="home" class="relative min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
    <div class="absolute inset-0 gradient-hero"></div>
    <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6">
            <span class="text-orange-300">Bienvenue sur</span><br>
            Emploi Connect
        </h1>
        <h2 class="text-xl sm:text-2xl lg:text-3xl font-semibold mb-6">
            Le blog pour décrocher un emploi plus vite
        </h2>
        <p class="text-lg sm:text-xl mb-8 max-w-2xl mx-auto leading-relaxed">
            Tu veux trouver un emploi rapidement, te démarquer avec ton CV ou réussir tes entretiens ? Tu es au bon endroit.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= SITE_URL ?>/guide-gratuit.php" class="inline-flex items-center px-8 py-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors shadow-lg">
                <i class="fas fa-download mr-3"></i>
                Télécharger ton guide gratuit
            </a>
            <a href="<?= SITE_URL ?>/blog.php" class="inline-flex items-center px-8 py-4 border-2 border-white text-white hover:bg-white hover:text-gray-900 font-semibold rounded-lg transition-colors">
                <span class="mr-3">Explorer les articles</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 lg:py-20 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach ($statistics as $index => $stat): ?>
            <div class="text-center stat-counter" data-target="<?= escape($stat['valeur']) ?>">
                <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="<?= escape($stat['icone']) ?> text-2xl text-orange-600 dark:text-orange-400"></i>
                </div>
                <div class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 counter-value">
                    0
                </div>
                <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-1"><?= escape($stat['nom']) ?></div>
                <div class="text-sm text-gray-600 dark:text-gray-400"><?= escape($stat['description']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Formations Section -->
<section id="formations" class="py-16 lg:py-20 bg-gradient-to-br from-orange-50 to-blue-50 dark:from-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-graduation-cap text-orange-600 mr-3"></i>
                Mes Formations en Ligne
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Transforme ta carrière avec mes formations complètes. Méthodes éprouvées, exercices pratiques et suivi personnalisé !
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <?php foreach ($formations as $formation): ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 <?= $formation['slug'] === 'pack-vip' ? 'bg-gradient-to-br from-orange-600 to-blue-600 text-white' : '' ?>">
                <?php if ($formation['slug'] !== 'pack-vip'): ?>
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
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">
                        <?= escape($formation['description']) ?>
                    </p>
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
                    <a href="<?= SITE_URL ?>/formations.php#<?= escape($formation['slug']) ?>" class="w-full bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-play mr-2"></i>
                        Découvrir la formation
                    </a>
                </div>
                <?php else: ?>
                <!-- Pack VIP avec design spécial -->
                <div class="relative p-6">
                    <div class="text-center mb-4">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4">
                            <i class="fas fa-crown text-2xl text-yellow-300"></i>
                        </div>
                        <div class="bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-bold inline-block mb-2">
                            🏆 <?= escape($formation['badge']) ?>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-center">
                        <?= escape($formation['nom']) ?>
                    </h3>
                    <p class="text-white/90 mb-4 text-sm text-center">
                        <?= escape($formation['description']) ?>
                    </p>
                    <div class="text-center mb-6">
                        <div class="text-3xl font-bold">
                            <?= number_format($formation['prix'], 0) ?>€
                            <span class="text-lg text-white/70 line-through ml-2"><?= number_format($formation['prix_barre'], 0) ?>€</span>
                        </div>
                        <div class="text-yellow-300 text-sm font-semibold">-43% jusqu'au 31 janvier !</div>
                    </div>
                    <a href="<?= SITE_URL ?>/formations.php#<?= escape($formation['slug']) ?>" class="w-full bg-white text-orange-600 font-bold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center hover:bg-gray-100">
                        <i class="fas fa-crown mr-2"></i>
                        Accéder au Pack VIP
                    </a>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- CTA Section -->
        <div class="text-center">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 max-w-4xl mx-auto border border-gray-100 dark:border-gray-700">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Prêt(e) à transformer ta carrière ? 🚀
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Rejoins plus de 4,300 personnes qui ont déjà décroché leur emploi de rêve grâce à mes formations !
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= SITE_URL ?>/formations.php" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Voir toutes les formations
                    </a>
                    <a href="<?= SITE_URL ?>/guide-gratuit.php" class="inline-flex items-center px-8 py-4 bg-white dark:bg-gray-700 border-2 border-orange-600 text-orange-600 dark:text-orange-400 font-semibold rounded-lg hover:bg-orange-50 dark:hover:bg-gray-600 transition-colors">
                        <i class="fas fa-download mr-2"></i>
                        Guide gratuit d'abord
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Présentation Coach Didi -->
<section class="py-16 lg:py-20 bg-white dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <div class="flex items-center mb-4">
                    <div class="w-3 h-8 bg-gradient-to-b from-orange-500 to-blue-600 rounded-full mr-4"></div>
                    <span class="text-orange-600 dark:text-orange-400 font-semibold text-lg">Qui suis-je ?</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    Coach Didi, ton expert en employabilité
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                    Bonjour ! Je suis <strong>Cadnel DOSSOU</strong>, plus connu sous le nom de <strong>Coach Didi</strong>. 
                    Depuis plus de 8 ans, j'accompagne les étudiants et jeunes diplômés dans leur recherche d'emploi.
                </p>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                    Ma mission ? T'aider à décrocher l'emploi de tes rêves plus rapidement et efficacement grâce à des méthodes éprouvées et un accompagnement personnalisé.
                </p>
                
                <!-- Statistiques en ligne -->
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">4 300+</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Personnes accompagnées</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">85%</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Taux de réussite</div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?= SITE_URL ?>/a-propos.php" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-user mr-2"></i>
                        En savoir plus sur moi
                    </a>
                    <a href="<?= SITE_URL ?>/contact.php" class="inline-flex items-center px-6 py-3 border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white font-semibold rounded-lg transition-all duration-300">
                        <i class="fas fa-envelope mr-2"></i>
                        Me contacter
                    </a>
                </div>
            </div>
            
            <div class="order-1 lg:order-2">
                <div class="relative">
                    <!-- Décoration de fond -->
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-blue-500 rounded-2xl transform rotate-3 opacity-20"></div>
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-orange-200 dark:bg-orange-800 rounded-full opacity-50"></div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-blue-200 dark:bg-blue-800 rounded-full opacity-50"></div>
                    
                    <!-- Diaporama d'images -->
                    <div class="relative bg-white dark:bg-gray-700 rounded-2xl p-6 shadow-2xl">
                        <div id="coach-carousel" class="relative overflow-hidden rounded-xl">
                            <?php
                            // Récupération des images actives de Coach Didi
                            try {
                                $stmt = $pdo->prepare("SELECT filename, alt_text FROM coach_images WHERE actif = 1 ORDER BY ordre ASC");
                                $stmt->execute();
                                $coachImages = $stmt->fetchAll();
                            } catch (Exception $e) {
                                // Images par défaut si erreur
                                $coachImages = [
                                    ['filename' => 'coach.jpeg', 'alt_text' => 'Coach Didi'],
                                    ['filename' => 'DIDI.jpeg', 'alt_text' => 'Coach Didi - Expert en employabilité']
                                ];
                            }
                            
                            if (!empty($coachImages)): ?>
                                <div class="carousel-container">
                                    <?php foreach ($coachImages as $index => $image): ?>
                                    <div class="carousel-slide <?= $index === 0 ? 'active' : '' ?>" data-slide="<?= $index ?>">
                                        <img src="<?= SITE_URL ?>/images/<?= escape($image['filename']) ?>" 
                                             alt="<?= escape($image['alt_text']) ?>" 
                                             class="w-full h-80 object-cover rounded-xl transition-opacity duration-500">
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <?php if (count($coachImages) > 1): ?>
                                <!-- Contrôles du carousel -->
                                <button id="prev-slide" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-2 rounded-full transition-all duration-300">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button id="next-slide" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-2 rounded-full transition-all duration-300">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                
                                <!-- Indicateurs -->
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                    <?php foreach ($coachImages as $index => $image): ?>
                                    <button class="carousel-indicator w-3 h-3 rounded-full transition-all duration-300 <?= $index === 0 ? 'bg-white' : 'bg-white bg-opacity-50' ?>" data-slide="<?= $index ?>"></button>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <!-- Image par défaut si aucune image en base -->
                                <img src="<?= SITE_URL ?>/images/coach.jpeg" 
                                     alt="Coach Didi" 
                                     class="w-full h-80 object-cover rounded-xl">
                            <?php endif; ?>
                        </div>
                        
                        <!-- Badge de confiance -->
                        <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-white dark:bg-gray-800 rounded-full px-4 py-2 shadow-lg border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center space-x-2">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star text-sm"></i>
                                    <i class="fas fa-star text-sm"></i>
                                    <i class="fas fa-star text-sm"></i>
                                    <i class="fas fa-star text-sm"></i>
                                    <i class="fas fa-star text-sm"></i>
                                </div>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Expert certifié</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Articles récents -->
<section id="blog" class="py-16 lg:py-20 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-newspaper text-orange-600 mr-3"></i>
                Articles Récents
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Découvre mes derniers conseils pour booster ta recherche d'emploi et décrocher le poste de tes rêves.
            </p>
        </div>

        <?php if ($featuredArticle): ?>
        <!-- Article vedette -->
        <div class="mb-12">
            <div class="bg-gradient-to-r from-orange-100 to-blue-100 dark:from-orange-900 dark:to-blue-900 rounded-2xl overflow-hidden shadow-xl">
                <div class="lg:flex">
                    <div class="lg:w-1/2">
                        <img src="<?= escape($featuredArticle['image_url']) ?>" 
                             alt="<?= escape($featuredArticle['titre']) ?>" 
                             class="w-full h-64 lg:h-full object-cover">
                    </div>
                    <div class="lg:w-1/2 p-8 lg:p-12">
                        <div class="flex items-center mb-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium text-white" 
                                  style="background-color: <?= escape($featuredArticle['categorie_couleur'] ?? '#f97316') ?>">
                                <i class="fas fa-star mr-1"></i>
                                Article vedette
                            </span>
                        </div>
                        <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                            <?= escape($featuredArticle['titre']) ?>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                            <?= escape($featuredArticle['extrait']) ?>
                        </p>
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-user mr-2"></i>
                                <span><?= escape($featuredArticle['auteur']) ?></span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 space-x-4">
                                <span><?= formatDate($featuredArticle['created_at']) ?></span>
                                <span><?= escape($featuredArticle['temps_lecture']) ?></span>
                            </div>
                        </div>
                        <a href="<?= SITE_URL ?>/article.php?slug=<?= escape($featuredArticle['slug']) ?>" 
                           class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                            <span class="mr-2">Lire l'article</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Grille d'articles -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <?php 
            $count = 0;
            foreach ($recentArticles as $article): 
                if ($featuredArticle && $article['id'] === $featuredArticle['id']) continue;
                if ($count >= 3) break;
                $count++;
            ?>
            <article class="article-card bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden cursor-pointer" 
                     onclick="window.location.href='<?= SITE_URL ?>/article.php?slug=<?= escape($article['slug']) ?>'">
                <img src="<?= escape($article['image_url']) ?>" 
                     alt="<?= escape($article['titre']) ?>" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium text-white" 
                              style="background-color: <?= escape($article['categorie_couleur'] ?? '#f97316') ?>">
                            <?= escape($article['categorie_nom']) ?>
                        </span>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 space-x-2">
                            <span><?= formatDate($article['created_at']) ?></span>
                            <span><?= escape($article['temps_lecture']) ?></span>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3"><?= escape($article['titre']) ?></h3>
                    
                    <p class="text-gray-600 dark:text-gray-400 mb-4"><?= escape(truncateText($article['extrait'], 100)) ?></p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-user mr-2"></i>
                            <span><?= escape($article['auteur']) ?></span>
                        </div>
                        <button class="inline-flex items-center text-orange-600 dark:text-orange-400 hover:text-orange-700 font-medium">
                            <span class="mr-2">Lire la suite</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Lien vers le blog -->
        <div class="text-center">
            <a href="<?= SITE_URL ?>/blog.php" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg transition-all duration-300">
                <i class="fas fa-newspaper mr-2"></i>
                Voir tous les articles
            </a>
        </div>
    </div>
</section>

<!-- Catégories -->
<section id="categories" class="py-16 lg:py-20 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-tags text-orange-600 mr-3"></i>
                Catégories d'Articles
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Explore nos articles par thématique pour trouver exactement ce dont tu as besoin.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            <?php foreach ($categories as $category): ?>
            <a href="<?= SITE_URL ?>/blog.php?category=<?= escape($category['slug']) ?>" 
               class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 text-center border border-gray-100 dark:border-gray-700 hover:border-orange-200 dark:hover:border-orange-800">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300" 
                     style="background-color: <?= escape($category['couleur']) ?>20">
                    <i class="<?= escape($category['icone']) ?> text-2xl" style="color: <?= escape($category['couleur']) ?>"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-orange-600 transition-colors">
                    <?= escape($category['nom']) ?>
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    <?= escape($category['description']) ?>
                </p>
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" 
                     style="background-color: <?= escape($category['couleur']) ?>20; color: <?= escape($category['couleur']) ?>">
                    <?= $category['article_count'] ?> article<?= $category['article_count'] > 1 ? 's' : '' ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
