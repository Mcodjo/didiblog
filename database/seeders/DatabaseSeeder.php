<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\Formation;
use App\Models\Statistique;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'prenom' => 'Coach Didi',
            'email' => 'admin@emploiconnect.fr',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'actif' => true,
        ]);

        $categories = [
            ['nom' => 'CV & Candidatures', 'description' => 'Conseils pour créer un CV impactant', 'couleur' => '#3b82f6', 'icone' => 'fas fa-file-alt'],
            ['nom' => 'Entretiens', 'description' => 'Réussir vos entretiens d\'embauche', 'couleur' => '#10b981', 'icone' => 'fas fa-comments'],
            ['nom' => 'LinkedIn', 'description' => 'Optimiser votre profil LinkedIn', 'couleur' => '#0077b5', 'icone' => 'fab fa-linkedin'],
            ['nom' => 'Recherche d\'emploi', 'description' => 'Stratégies de recherche efficaces', 'couleur' => '#f97316', 'icone' => 'fas fa-search'],
            ['nom' => 'Développement personnel', 'description' => 'Booster votre carrière', 'couleur' => '#8b5cf6', 'icone' => 'fas fa-rocket'],
        ];

        foreach ($categories as $i => $cat) {
            Category::create(array_merge($cat, ['ordre' => $i]));
        }

        $articles = [
            ['titre' => 'Comment créer un CV qui attire l\'attention des recruteurs', 'extrait' => 'Découvrez les secrets d\'un CV efficace qui vous démarquera des autres candidats.', 'contenu' => 'Un bon CV est la clé pour décrocher un entretien. Voici mes conseils pour créer un CV qui attire l\'attention:\n\n1. Un design professionnel et épuré\n2. Des mots-clés pertinents\n3. Des résultats quantifiables\n4. Une mise en page claire\n5. Pas plus de 2 pages', 'categorie_id' => 1, 'featured' => true, 'image_url' => 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=800'],
            ['titre' => 'Les 10 questions les plus posées en entretien', 'extrait' => 'Préparez-vous aux questions classiques pour réussir vos entretiens.', 'contenu' => 'Voici les 10 questions incontournables en entretien et comment y répondre:\n\n1. Parlez-moi de vous\n2. Pourquoi ce poste ?\n3. Vos qualités et défauts\n4. Où vous voyez-vous dans 5 ans ?\n5. Pourquoi vous embaucher ?', 'categorie_id' => 2, 'image_url' => 'https://images.unsplash.com/photo-1565688534245-05d6b5be184a?w=800'],
            ['titre' => 'Optimiser votre profil LinkedIn en 2024', 'extrait' => 'Les meilleures pratiques pour un profil LinkedIn qui attire les recruteurs.', 'contenu' => 'LinkedIn est devenu incontournable. Voici comment optimiser votre profil:\n\n1. Photo professionnelle\n2. Titre accrocheur\n3. Résumé impactant\n4. Expériences détaillées\n5. Recommandations', 'categorie_id' => 3, 'image_url' => 'https://images.unsplash.com/photo-1611944212129-29977ae1398c?w=800'],
        ];

        foreach ($articles as $art) {
            Article::create(array_merge($art, ['auteur' => 'Coach Didi', 'temps_lecture' => '5 min', 'actif' => true]));
        }

        $formations = [
            ['nom' => 'CV Parfait', 'description' => 'Apprenez à créer un CV qui décroche des entretiens', 'prix' => 47, 'prix_barre' => 97, 'badge' => 'Best-seller', 'couleur_badge' => '#10b981', 'niveau' => 'Débutant', 'duree' => '3h', 'image_url' => 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=500'],
            ['nom' => 'Réussir ses entretiens', 'description' => 'Toutes les techniques pour briller en entretien', 'prix' => 67, 'prix_barre' => 147, 'badge' => 'Populaire', 'couleur_badge' => '#3b82f6', 'niveau' => 'Intermédiaire', 'duree' => '5h', 'image_url' => 'https://images.unsplash.com/photo-1565688534245-05d6b5be184a?w=500'],
            ['nom' => 'Pack VIP', 'description' => 'Toutes les formations + coaching personnalisé', 'prix' => 197, 'prix_barre' => 347, 'badge' => 'VIP', 'couleur_badge' => '#f97316', 'niveau' => 'Tous niveaux', 'duree' => '15h', 'image_url' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=500'],
        ];

        foreach ($formations as $i => $f) {
            Formation::create(array_merge($f, ['ordre' => $i, 'actif' => true, 'note' => 5.0]));
        }

        $stats = [
            ['nom' => 'Personnes accompagnées', 'valeur' => '4300+', 'icone' => 'fas fa-users', 'description' => 'Depuis 2016'],
            ['nom' => 'Taux de réussite', 'valeur' => '85%', 'icone' => 'fas fa-trophy', 'description' => 'Emploi trouvé'],
            ['nom' => 'Formations', 'valeur' => '5', 'icone' => 'fas fa-graduation-cap', 'description' => 'En ligne'],
            ['nom' => 'Avis positifs', 'valeur' => '4.9/5', 'icone' => 'fas fa-star', 'description' => 'Note moyenne'],
        ];

        foreach ($stats as $i => $s) {
            Statistique::create(array_merge($s, ['ordre' => $i, 'actif' => true]));
        }
    }
}
