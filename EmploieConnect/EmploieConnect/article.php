<?php
require_once 'config/config.php';
require_once 'core/functions.php';
require_once 'models/Article.php';
require_once 'models/Category.php';
require_once 'models/Comment.php';
require_once 'models/SocialShare.php';
require_once 'models/ArticleRecommendation.php';

// Récupération du slug de l'article
$slug = cleanInput($_GET['slug'] ?? '');

if (empty($slug)) {
    redirect(SITE_URL . '/blog.php');
}

// Connexion à la base de données
$pdo = getDatabase();

// Initialisation des modèles
$articleModel = new Article($pdo);
$categoryModel = new Category($pdo);
$commentModel = new Comment($pdo);
$socialShareModel = new SocialShare($pdo);
$recommendationModel = new ArticleRecommendation($pdo);

// Récupération de l'article
$article = $articleModel->getBySlug($slug);

if (!$article) {
    redirect(SITE_URL . '/blog.php');
}

// Incrémenter les vues
$articleModel->incrementViews($article['id']);

// Récupération d'articles similaires avec système de recommandation intelligent
$relatedArticles = $recommendationModel->getSimilarArticles($article['id'], 3);

// Gestion des commentaires
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $name = cleanInput($_POST['name'] ?? '');
    $email = cleanInput($_POST['email'] ?? '');
    $content = cleanInput($_POST['content'] ?? '');
    
    if (empty($name) || empty($email) || empty($content)) {
        $error = 'Tous les champs sont requis.';
    } elseif (!isValidEmail($email)) {
        $error = 'Adresse email invalide.';
    } else {
        $commentData = [
            'article_id' => $article['id'],
            'user_id' => $_SESSION['user_id'] ?? null,
            'author_name' => $name,
            'author_email' => $email,
            'content' => $content,
            'status' => 'pending'
        ];
        
        if ($commentModel->create($commentData)) {
            $success = 'Votre commentaire a été soumis et sera publié après modération.';
        } else {
            $error = 'Erreur lors de l\'ajout du commentaire.';
        }
    }
}

// Gestion du partage social
if (isset($_GET['share'])) {
    $platform = cleanInput($_GET['share']);
    if (in_array($platform, ['facebook', 'twitter', 'linkedin', 'whatsapp'])) {
        $socialShareModel->incrementShare($article['id'], $platform);
    }
}

// Récupération des commentaires et partages
$comments = $commentModel->getByArticleId($article['id']);
$commentCount = $commentModel->getCount($article['id']);
$shareCounts = $socialShareModel->getShareCounts($article['id']);
$totalShares = $socialShareModel->getTotalShares($article['id']);

// Meta tags
$pageTitle = $article['titre'] . " - Emploi Connect";
$pageDescription = $article['extrait'];
$pageImage = $article['image_url'];

require_once 'includes/header.php';
?>

<!-- Article Header -->
<article class="bg-white dark:bg-gray-900">
    <!-- Hero Image -->
    <div class="relative h-96 lg:h-[500px] overflow-hidden">
        <img src="<?= escape($article['image_url']) ?>" 
             alt="<?= escape($article['titre']) ?>" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
        
        <!-- Breadcrumb -->
        <div class="absolute top-6 left-6 right-6">
            <nav class="flex items-center space-x-2 text-white/80 text-sm">
                <a href="<?= SITE_URL ?>" class="hover:text-white transition-colors">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="<?= SITE_URL ?>/blog.php" class="hover:text-white transition-colors">Blog</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="<?= SITE_URL ?>/blog.php?category=<?= escape($article['categorie_slug']) ?>" class="hover:text-white transition-colors">
                    <?= escape($article['categorie_nom']) ?>
                </a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white"><?= escape(truncateText($article['titre'], 50)) ?></span>
            </nav>
        </div>
        
        <!-- Article Info -->
        <div class="absolute bottom-6 left-6 right-6 text-white">
            <div class="flex items-center mb-4">
                <span class="px-3 py-1 rounded-full text-sm font-medium text-white" 
                      style="background-color: <?= escape($article['categorie_couleur']) ?>">
                    <i class="<?= escape($article['categorie_icone']) ?> mr-1"></i>
                    <?= escape($article['categorie_nom']) ?>
                </span>
                <?php if (isset($article['featured']) && $article['featured']): ?>
                <span class="ml-3 px-3 py-1 bg-orange-600 rounded-full text-sm font-medium">
                    <i class="fas fa-star mr-1"></i>
                    Article vedette
                </span>
                <?php endif; ?>
            </div>
            
            <h1 class="text-3xl lg:text-4xl font-bold mb-4 leading-tight">
                <?= escape($article['titre']) ?>
            </h1>
            
            <div class="flex flex-wrap items-center gap-6 text-sm">
                <div class="flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    <span><?= escape($article['auteur']) ?></span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-calendar mr-2"></i>
                    <span><?= formatDate($article['created_at']) ?></span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    <span><?= escape($article['temps_lecture']) ?></span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    <span><?= number_format($article['vues']) ?> vues</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Content -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-4xl mx-auto">
            <div class="lg:flex lg:gap-12">
                <!-- Main Content -->
                <div class="lg:w-2/3">
                    <!-- Article Summary -->
                    <div class="bg-orange-50 dark:bg-orange-900/20 border-l-4 border-orange-600 p-6 mb-8 rounded-r-lg">
                        <h2 class="text-lg font-semibold text-orange-800 dark:text-orange-200 mb-2">
                            <i class="fas fa-lightbulb mr-2"></i>
                            En résumé
                        </h2>
                        <p class="text-orange-700 dark:text-orange-300 leading-relaxed">
                            <?= escape($article['extrait']) ?>
                        </p>
                    </div>

                    <!-- Article Body -->
                    <div class="prose prose-lg max-w-none dark:prose-invert prose-orange">
                        <?= $article['contenu'] ?>
                    </div>

                    <!-- Tags -->
                    <?php if (!empty($article['tags'])): ?>
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-tags mr-2"></i>
                            Tags
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <?php 
                            $tags = explode(',', $article['tags']);
                            foreach ($tags as $tag): 
                                $tag = trim($tag);
                                if (!empty($tag)):
                            ?>
                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-orange-100 dark:hover:bg-orange-900 transition-colors cursor-pointer">
                                #<?= escape($tag) ?>
                            </span>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Share Buttons -->
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-share-alt mr-2"></i>
                            Partager cet article
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(SITE_URL . '/article.php?slug=' . $article['slug']) ?>&share=facebook" 
                               target="_blank" 
                               onclick="trackShare('facebook')"
                               class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                <i class="fab fa-facebook-f mr-2"></i>
                                Facebook
                                <?php if ($shareCounts['facebook'] > 0): ?>
                                <span class="ml-2 bg-blue-800 px-2 py-1 rounded-full text-xs"><?= $shareCounts['facebook'] ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(SITE_URL . '/article.php?slug=' . $article['slug']) ?>&text=<?= urlencode($article['titre']) ?>&share=twitter" 
                               target="_blank" 
                               onclick="trackShare('twitter')"
                               class="flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
                                <i class="fab fa-twitter mr-2"></i>
                                Twitter
                                <?php if ($shareCounts['twitter'] > 0): ?>
                                <span class="ml-2 bg-sky-700 px-2 py-1 rounded-full text-xs"><?= $shareCounts['twitter'] ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(SITE_URL . '/article.php?slug=' . $article['slug']) ?>&share=linkedin" 
                               target="_blank" 
                               onclick="trackShare('linkedin')"
                               class="flex items-center px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg transition-colors">
                                <i class="fab fa-linkedin-in mr-2"></i>
                                LinkedIn
                                <?php if ($shareCounts['linkedin'] > 0): ?>
                                <span class="ml-2 bg-blue-900 px-2 py-1 rounded-full text-xs"><?= $shareCounts['linkedin'] ?></span>
                                <?php endif; ?>
                            </a>
                            <a href="https://wa.me/?text=<?= urlencode($article['titre'] . ' - ' . SITE_URL . '/article.php?slug=' . $article['slug']) ?>&share=whatsapp" 
                               target="_blank" 
                               onclick="trackShare('whatsapp')"
                               class="flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                <i class="fab fa-whatsapp mr-2"></i>
                                WhatsApp
                                <?php if ($shareCounts['whatsapp'] > 0): ?>
                                <span class="ml-2 bg-green-800 px-2 py-1 rounded-full text-xs"><?= $shareCounts['whatsapp'] ?></span>
                                <?php endif; ?>
                            </a>
                            <button onclick="copyToClipboard()" 
                                    class="flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                                <i class="fas fa-link mr-2"></i>
                                Copier le lien
                            </button>
                        </div>
                        <?php if ($totalShares > 0): ?>
                        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-share mr-1"></i>
                            Cet article a été partagé <?= $totalShares ?> fois
                        </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:w-1/3 mt-12 lg:mt-0">
                    <!-- Author Info -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 mb-8">
                        <div class="text-center">
                            <img src="https://page.gensparksite.com/v1/base64_upload/a456eb81c0763b6540288c7203d94cf5" 
                                 alt="Coach Didi" 
                                 class="w-20 h-20 rounded-full mx-auto mb-4 border-4 border-orange-200">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Coach Didi</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                Coach en employabilité et expert en recherche d'emploi
                            </p>
                            <div class="flex justify-center space-x-3">
                                <a href="#" class="text-gray-400 hover:text-orange-600 transition-colors">
                                    <i class="fab fa-linkedin text-xl"></i>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-orange-600 transition-colors">
                                    <i class="fab fa-twitter text-xl"></i>
                                </a>
                                <a href="<?= SITE_URL ?>/contact.php" class="text-gray-400 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-envelope text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Table of Contents -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8 border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-list mr-2"></i>
                            Sommaire
                        </h3>
                        <div id="tableOfContents" class="space-y-2 text-sm">
                            <!-- Généré dynamiquement par JavaScript -->
                        </div>
                    </div>

                    <!-- Newsletter CTA -->
                    <div class="bg-gradient-to-br from-orange-500 to-blue-600 text-white rounded-xl p-6 mb-8">
                        <div class="text-center">
                            <i class="fas fa-envelope text-3xl mb-4"></i>
                            <h3 class="text-lg font-bold mb-2">Newsletter</h3>
                            <p class="text-sm mb-4 opacity-90">
                                Reçois mes conseils directement dans ta boîte mail !
                            </p>
                            <form action="<?= SITE_URL ?>/newsletter.php" method="POST">
                                <input type="email" name="email" placeholder="Ton email" required
                                       class="w-full px-4 py-2 rounded-lg text-gray-900 mb-3 focus:outline-none focus:ring-2 focus:ring-white">
                                <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
                                <input type="hidden" name="source" value="article-<?= escape($article['slug']) ?>">
                                <button type="submit" class="w-full bg-white text-orange-600 font-semibold py-2 rounded-lg hover:bg-gray-100 transition-colors">
                                    S'abonner
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- Section Commentaires -->
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="lg:w-2/3">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">
                    <i class="fas fa-comments mr-2"></i>
                    Commentaires (<?= $commentCount ?>)
                </h2>

                <!-- Formulaire de commentaire -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Laisser un commentaire
                    </h3>

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

                    <form method="POST" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom *
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       required
                                       value="<?= escape($_POST['name'] ?? '') ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Votre nom">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email *
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       required
                                       value="<?= escape($_POST['email'] ?? '') ?>"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="votre@email.com">
                            </div>
                        </div>
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Commentaire *
                            </label>
                            <textarea id="content" 
                                      name="content" 
                                      required
                                      rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                      placeholder="Partagez votre avis sur cet article..."><?= escape($_POST['content'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" 
                                name="comment"
                                class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Publier le commentaire
                        </button>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Votre commentaire sera modéré avant publication.
                        </p>
                    </form>
                </div>

                <!-- Liste des commentaires -->
                <?php if (!empty($comments)): ?>
                <div class="space-y-6">
                    <?php foreach ($comments as $comment): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-orange-600 dark:text-orange-400"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900 dark:text-white">
                                        <?= escape($comment['author_name']) ?>
                                    </h4>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <?= formatDate($comment['created_at']) ?>
                                    </span>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    <?= nl2br(escape($comment['content'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <i class="fas fa-comments text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400">
                        Aucun commentaire pour le moment. Soyez le premier à commenter !
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Related Articles -->
<?php if (!empty($relatedArticles)): ?>
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                <i class="fas fa-brain mr-3"></i>
                Recommandations intelligentes
            </h2>
            <p class="text-gray-600 dark:text-gray-400">
                Articles sélectionnés spécialement pour vous basés sur vos intérêts
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($relatedArticles as $relatedArticle): ?>
            <article class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 cursor-pointer" 
                     onclick="window.location.href='<?= SITE_URL ?>/article.php?slug=<?= escape($relatedArticle['slug']) ?>'">
                <img src="<?= escape($relatedArticle['image_url']) ?>" 
                     alt="<?= escape($relatedArticle['titre']) ?>" 
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium text-white" 
                              style="background-color: <?= escape($relatedArticle['categorie_couleur'] ?? '#f97316') ?>">
                            <?= escape($relatedArticle['categorie_nom']) ?>
                        </span>
                        <div class="text-right">
                            <span class="text-sm text-gray-500 dark:text-gray-400 block">
                                <?= formatDate($relatedArticle['created_at']) ?>
                            </span>
                            <?php if (isset($relatedArticle['final_score'])): ?>
                            <div class="flex items-center mt-1">
                                <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                                <span class="text-xs text-orange-600 dark:text-orange-400 font-medium">
                                    <?= round($relatedArticle['final_score']) ?>% match
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                        <?= escape($relatedArticle['titre']) ?>
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                        <?= escape($relatedArticle['extrait']) ?>
                    </p>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            <?= escape($relatedArticle['temps_lecture']) ?>
                        </span>
                        <span class="text-orange-600 dark:text-orange-400 font-medium">
                            Lire l'article →
                        </span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
// Génération du sommaire
document.addEventListener('DOMContentLoaded', function() {
    const content = document.querySelector('.prose');
    const toc = document.getElementById('tableOfContents');
    const headings = content.querySelectorAll('h2, h3, h4');
    
    if (headings.length > 0) {
        headings.forEach((heading, index) => {
            const id = 'heading-' + index;
            heading.id = id;
            
            const link = document.createElement('a');
            link.href = '#' + id;
            link.textContent = heading.textContent;
            link.className = 'block text-gray-600 dark:text-gray-400 hover:text-orange-600 dark:hover:text-orange-400 transition-colors py-1 ' + 
                           (heading.tagName === 'H2' ? 'font-semibold' : 
                            heading.tagName === 'H3' ? 'ml-4' : 'ml-8 text-sm');
            
            toc.appendChild(link);
        });
    } else {
        toc.innerHTML = '<p class="text-gray-500 dark:text-gray-400 text-sm">Aucun titre trouvé</p>';
    }
});

// Copier le lien
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        // Feedback visuel
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check mr-2"></i>Copié !';
        button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
        button.classList.add('bg-green-600');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-gray-600', 'hover:bg-gray-700');
        }, 2000);
    });
}

// Tracking des partages sociaux
function trackShare(platform) {
    fetch(window.location.href + '&share=' + platform, {
        method: 'GET'
    }).catch(error => {
        console.log('Erreur tracking partage:', error);
    });
}

// Smooth scroll pour les liens du sommaire
document.querySelectorAll('#tableOfContents a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Highlight du titre actuel dans le sommaire
window.addEventListener('scroll', function() {
    const headings = document.querySelectorAll('.prose h2, .prose h3, .prose h4');
    const tocLinks = document.querySelectorAll('#tableOfContents a');
    
    let current = '';
    headings.forEach(heading => {
        const rect = heading.getBoundingClientRect();
        if (rect.top <= 100) {
            current = heading.id;
        }
    });
    
    tocLinks.forEach(link => {
        link.classList.remove('text-orange-600', 'dark:text-orange-400', 'font-semibold');
        link.classList.add('text-gray-600', 'dark:text-gray-400');
        
        if (link.getAttribute('href') === '#' + current) {
            link.classList.remove('text-gray-600', 'dark:text-gray-400');
            link.classList.add('text-orange-600', 'dark:text-orange-400', 'font-semibold');
        }
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
