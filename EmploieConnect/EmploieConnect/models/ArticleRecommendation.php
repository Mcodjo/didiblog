<?php

class ArticleRecommendation {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Obtenir des articles similaires basés sur plusieurs critères
     */
    public function getSimilarArticles($articleId, $limit = 6) {
        // Récupérer l'article de référence
        $stmt = $this->pdo->prepare("
            SELECT categorie_id, titre, extrait 
            FROM articles 
            WHERE id = :id AND actif = 1
        ");
        $stmt->execute([':id' => $articleId]);
        $currentArticle = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$currentArticle) {
            return [];
        }
        
        $recommendations = [];
        
        // 1. Articles de la même catégorie (poids: 40%)
        $categoryArticles = $this->getByCategory($currentArticle['categorie_id'], $articleId, 3);
        foreach ($categoryArticles as $article) {
            $article['score'] = 40;
            $article['reason'] = 'Même catégorie';
            $recommendations[] = $article;
        }
        
        // 2. Articles avec mots-clés similaires (poids: 35%)
        $keywordArticles = $this->getByKeywords($currentArticle['titre'], $currentArticle['extrait'], $articleId, 3);
        foreach ($keywordArticles as $article) {
            $article['score'] = 35;
            $article['reason'] = 'Mots-clés similaires';
            $recommendations[] = $article;
        }
        
        // 3. Articles populaires récents (poids: 25%)
        $popularArticles = $this->getPopularRecent($articleId, 2);
        foreach ($popularArticles as $article) {
            $article['score'] = 25;
            $article['reason'] = 'Article populaire';
            $recommendations[] = $article;
        }
        
        // Fusionner et scorer les doublons
        $recommendations = $this->mergeAndScore($recommendations);
        
        // Trier par score décroissant
        usort($recommendations, function($a, $b) {
            return $b['final_score'] - $a['final_score'];
        });
        
        return array_slice($recommendations, 0, $limit);
    }
    
    /**
     * Articles de la même catégorie
     */
    private function getByCategory($categoryId, $excludeId, $limit) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur, c.icone as categorie_icone
            FROM articles a
            LEFT JOIN categories c ON a.categorie_id = c.id
            WHERE a.categorie_id = :category_id 
            AND a.id != :exclude_id 
            AND a.actif = 1
            ORDER BY a.vues DESC, a.created_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':exclude_id', $excludeId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Articles avec mots-clés similaires
     */
    private function getByKeywords($title, $excerpt, $excludeId, $limit) {
        // Extraire les mots-clés importants
        $keywords = $this->extractKeywords($title . ' ' . $excerpt);
        
        if (empty($keywords)) {
            return [];
        }
        
        // Construire la requête de recherche
        $searchTerms = implode(' ', $keywords);
        
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur, c.icone as categorie_icone,
                   MATCH(a.titre, a.extrait) AGAINST(:search_terms IN NATURAL LANGUAGE MODE) as relevance
            FROM articles a
            LEFT JOIN categories c ON a.categorie_id = c.id
            WHERE a.id != :exclude_id 
            AND a.actif = 1
            AND MATCH(a.titre, a.extrait) AGAINST(:search_terms IN NATURAL LANGUAGE MODE) > 0
            ORDER BY relevance DESC
            LIMIT :limit
        ");
        
        try {
            $stmt->bindValue(':search_terms', $searchTerms, PDO::PARAM_STR);
            $stmt->bindValue(':exclude_id', $excludeId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Fallback si FULLTEXT pas disponible
            return $this->getByKeywordsFallback($keywords, $excludeId, $limit);
        }
    }
    
    /**
     * Fallback pour la recherche par mots-clés
     */
    private function getByKeywordsFallback($keywords, $excludeId, $limit) {
        $conditions = [];
        $params = [':exclude_id' => $excludeId];
        
        foreach ($keywords as $i => $keyword) {
            $conditions[] = "(a.titre LIKE :keyword{$i} OR a.extrait LIKE :keyword{$i})";
            $params[":keyword{$i}"] = "%{$keyword}%";
        }
        
        if (empty($conditions)) {
            return [];
        }
        
        $whereClause = implode(' OR ', $conditions);
        
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur, c.icone as categorie_icone
            FROM articles a
            LEFT JOIN categories c ON a.categorie_id = c.id
            WHERE a.id != :exclude_id 
            AND a.actif = 1
            AND ({$whereClause})
            ORDER BY a.vues DESC, a.created_at DESC
            LIMIT :limit
        ");
        
        $params[':limit'] = $limit;
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Articles populaires récents
     */
    private function getPopularRecent($excludeId, $limit) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur, c.icone as categorie_icone
            FROM articles a
            LEFT JOIN categories c ON a.categorie_id = c.id
            WHERE a.id != :exclude_id 
            AND a.actif = 1
            AND a.created_at >= DATE_SUB(NOW(), INTERVAL 3 MONTH)
            ORDER BY a.vues DESC, a.created_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':exclude_id', $excludeId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Extraire les mots-clés importants d'un texte
     */
    private function extractKeywords($text) {
        // Mots vides à ignorer
        $stopWords = [
            'le', 'la', 'les', 'un', 'une', 'des', 'du', 'de', 'et', 'ou', 'mais', 'donc', 'or', 'ni', 'car',
            'ce', 'cette', 'ces', 'cet', 'son', 'sa', 'ses', 'mon', 'ma', 'mes', 'ton', 'ta', 'tes',
            'pour', 'par', 'sur', 'avec', 'dans', 'sans', 'sous', 'vers', 'chez', 'entre', 'jusqu',
            'est', 'sont', 'était', 'étaient', 'sera', 'seront', 'avoir', 'être', 'faire', 'aller',
            'comment', 'pourquoi', 'quand', 'où', 'qui', 'que', 'quoi', 'dont', 'lequel', 'laquelle'
        ];
        
        // Nettoyer et normaliser le texte
        $text = strtolower($text);
        $text = preg_replace('/[^\w\s\-àâäéèêëïîôöùûüÿç]/u', ' ', $text);
        $words = preg_split('/\s+/', $text);
        
        // Filtrer les mots
        $keywords = [];
        foreach ($words as $word) {
            $word = trim($word);
            if (strlen($word) >= 4 && !in_array($word, $stopWords)) {
                $keywords[] = $word;
            }
        }
        
        // Retourner les mots uniques les plus fréquents
        $wordCount = array_count_values($keywords);
        arsort($wordCount);
        
        return array_slice(array_keys($wordCount), 0, 5);
    }
    
    /**
     * Fusionner les recommandations et calculer le score final
     */
    private function mergeAndScore($recommendations) {
        $merged = [];
        
        foreach ($recommendations as $rec) {
            $id = $rec['id'];
            
            if (isset($merged[$id])) {
                // Article déjà présent, additionner les scores
                $merged[$id]['final_score'] += $rec['score'];
                $merged[$id]['reasons'][] = $rec['reason'];
            } else {
                // Nouvel article
                $rec['final_score'] = $rec['score'];
                $rec['reasons'] = [$rec['reason']];
                $merged[$id] = $rec;
            }
        }
        
        return array_values($merged);
    }
    
    /**
     * Obtenir les articles les plus partagés
     */
    public function getMostShared($limit = 5) {
        $stmt = $this->pdo->prepare("
            SELECT a.*, c.nom as categorie_nom, c.couleur as categorie_couleur, 
                   SUM(s.share_count) as total_shares
            FROM articles a
            LEFT JOIN categories c ON a.categorie_id = c.id
            LEFT JOIN social_shares s ON a.id = s.article_id
            WHERE a.actif = 1
            GROUP BY a.id
            ORDER BY total_shares DESC, a.vues DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
