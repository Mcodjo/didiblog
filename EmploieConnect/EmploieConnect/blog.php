<?php
require_once 'config/config.php';
require_once 'core/functions.php';
require_once 'models/Article.php';
require_once 'models/Category.php';

// Connexion à la base de données
$pdo = getDatabase();

// Initialisation des modèles
$articleModel = new Article($pdo);
$categoryModel = new Category($pdo);

// Paramètres de pagination
$page = (int)($_GET['page'] ?? 1);
$limit = 9;
$offset = ($page - 1) * $limit;

// Filtres
$categorySlug = cleanInput($_GET['category'] ?? '');
$searchQuery = cleanInput($_GET['search'] ?? '');

// Récupération des articles
if ($searchQuery) {
    $articles = $articleModel->search($searchQuery, $limit, $offset);
    $totalArticles = $articleModel->searchCount($searchQuery);
    $pageTitle = "Recherche : " . $searchQuery . " - Blog Emploi Connect";
} elseif ($categorySlug) {
    $category = $categoryModel->getBySlug($categorySlug);
    if (!$category) {
        redirect(SITE_URL . '/blog.php');
    }
    $articles = $articleModel->getByCategory($category['id'], $limit, $offset);
    $totalArticles = $articleModel->countByCategory($category['id']);
    $pageTitle = $category['nom'] . " - Blog Emploi Connect";
} else {
    $articles = $articleModel->getAll($limit, $offset);
    $totalArticles = $articleModel->count();
    $pageTitle = "Blog - Emploi Connect";
}

// Calcul de la pagination
$totalPages = ceil($totalArticles / $limit);

// Récupération des catégories
$categories = $categoryModel->getAll();

// Meta tags
$pageDescription = "Découvrez tous nos articles sur l'emploi, le CV, les entretiens d'embauche et la recherche d'emploi. Conseils pratiques par Coach Didi.";

require_once 'includes/header.php';
?>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-600 to-blue-600 text-white py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold mb-6">
            <i class="fas fa-newspaper mr-3"></i>
            Blog Emploi Connect
        </h1>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Tous mes conseils pour décrocher l'emploi de tes rêves. CV, entretiens, LinkedIn, recherche d'emploi... tout y est !
        </p>
        
        <!-- Barre de recherche -->
        <div class="max-w-2xl mx-auto">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" 
                           name="search" 
                           value="<?= escape($searchQuery) ?>"
                           placeholder="Rechercher un article..."
                           class="w-full px-6 py-4 pl-12 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button type="submit" class="px-8 py-4 bg-white text-orange-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Rechercher
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Filtres et contenu -->
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Filtres par catégorie -->
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                <i class="fas fa-filter mr-2"></i>
                Filtrer par catégorie
            </h2>
            <div class="flex flex-wrap gap-3">
                <a href="<?= SITE_URL ?>/blog.php" 
                   class="px-4 py-2 rounded-full font-medium transition-colors <?= empty($categorySlug) ? 'bg-orange-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-orange-100 dark:hover:bg-gray-700' ?>">
                    <i class="fas fa-th-large mr-2"></i>
                    Tous les articles
                </a>
                <?php foreach ($categories as $cat): ?>
                <a href="<?= SITE_URL ?>/blog.php?category=<?= escape($cat['slug']) ?>" 
                   class="px-4 py-2 rounded-full font-medium transition-colors <?= $categorySlug === $cat['slug'] ? 'text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?>"
                   <?= $categorySlug === $cat['slug'] ? 'style="background-color: ' . escape($cat['couleur']) . '"' : '' ?>>
                    <i class="<?= escape($cat['icone']) ?> mr-2"></i>
                    <?= escape($cat['nom']) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Résultats -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <?php if ($searchQuery): ?>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Résultats pour "<?= escape($searchQuery) ?>"
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        <?= $totalArticles ?> article<?= $totalArticles > 1 ? 's' : '' ?> trouvé<?= $totalArticles > 1 ? 's' : '' ?>
                    </p>
                    <?php elseif ($categorySlug && isset($category)): ?>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Articles dans "<?= escape($category['nom']) ?>"
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        <?= $totalArticles ?> article<?= $totalArticles > 1 ? 's' : '' ?>
                    </p>
                    <?php else: ?>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Tous les articles
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        <?= $totalArticles ?> article<?= $totalArticles > 1 ? 's' : '' ?> au total
                    </p>
                    <?php endif; ?>
                </div>
                
                <!-- Tri -->
                <div class="flex items-center space-x-4">
                    <label class="text-sm text-gray-600 dark:text-gray-400">Trier par :</label>
                    <select id="sortSelect" class="px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="recent">Plus récents</option>
                        <option value="popular">Plus populaires</option>
                        <option value="alphabetical">Alphabétique</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Grille d'articles -->
        <?php if (empty($articles)): ?>
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Aucun article trouvé</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                <?php if ($searchQuery): ?>
                Essayez avec d'autres mots-clés ou explorez nos catégories.
                <?php else: ?>
                Il n'y a pas encore d'articles dans cette catégorie.
                <?php endif; ?>
            </p>
            <a href="<?= SITE_URL ?>/blog.php" class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Voir tous les articles
            </a>
        </div>
        <?php else: ?>
        <div id="articlesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <?php foreach ($articles as $article): ?>
            <article class="article-card bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 cursor-pointer" 
                     onclick="window.location.href='<?= SITE_URL ?>/article.php?slug=<?= escape($article['slug']) ?>'"
                     data-date="<?= $article['created_at'] ?>"
                     data-views="<?= $article['vues'] ?>"
                     data-title="<?= escape($article['titre']) ?>">
                <div class="relative">
                    <img src="<?= escape($article['image_url']) ?>" 
                         alt="<?= escape($article['titre']) ?>" 
                         class="w-full h-48 object-cover">
                    <?php if ($article['featured']): ?>
                    <div class="absolute top-3 left-3 bg-orange-600 text-white px-2 py-1 rounded-full text-xs font-bold">
                        <i class="fas fa-star mr-1"></i>
                        Vedette
                    </div>
                    <?php endif; ?>
                </div>
                
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
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                        <?= escape($article['titre']) ?>
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                        <?= escape($article['extrait']) ?>
                    </p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-user mr-2"></i>
                            <span><?= escape($article['auteur']) ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-eye mr-1"></i>
                            <span><?= number_format($article['vues']) ?></span>
                        </div>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
        <div class="flex justify-center">
            <nav class="flex items-center space-x-2">
                <?php if ($page > 1): ?>
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" 
                   class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <?php endif; ?>
                
                <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" 
                   class="px-4 py-2 rounded-lg transition-colors <?= $i === $page ? 'bg-orange-600 text-white' : 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' ?>">
                    <?= $i ?>
                </a>
                <?php endfor; ?>
                
                <?php if ($page < $totalPages): ?>
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>" 
                   class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-chevron-right"></i>
                </a>
                <?php endif; ?>
            </nav>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Newsletter -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-orange-600 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">
            Ne rate aucun conseil !
        </h2>
        <p class="text-lg mb-8 max-w-2xl mx-auto">
            Reçois mes nouveaux articles directement dans ta boîte mail
        </p>
        
        <form action="<?= SITE_URL ?>/newsletter.php" method="POST" class="max-w-md mx-auto flex flex-col sm:flex-row gap-4">
            <input type="email" name="email" placeholder="Ton email" required
                   class="flex-1 px-6 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white">
            
            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
            <input type="hidden" name="source" value="blog">
            
            <button type="submit" class="px-8 py-3 bg-white text-orange-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                S'abonner
            </button>
        </form>
    </div>
</section>

<script>
// Tri des articles
document.getElementById('sortSelect').addEventListener('change', function() {
    const sortType = this.value;
    const grid = document.getElementById('articlesGrid');
    const articles = Array.from(grid.children);
    
    articles.sort((a, b) => {
        switch(sortType) {
            case 'recent':
                return new Date(b.dataset.date) - new Date(a.dataset.date);
            case 'popular':
                return parseInt(b.dataset.views) - parseInt(a.dataset.views);
            case 'alphabetical':
                return a.dataset.title.localeCompare(b.dataset.title);
            default:
                return 0;
        }
    });
    
    // Réorganiser les articles
    articles.forEach(article => grid.appendChild(article));
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

document.querySelectorAll('.article-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(card);
});
</script>

<?php require_once 'includes/footer.php'; ?>
