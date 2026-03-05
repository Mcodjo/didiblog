<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run()
    {
        // Categories
        $catConseils = Category::create(['name' => 'Conseils Emploi', 'slug' => 'conseils-emploi']);
        $catCV = Category::create(['name' => 'CV & Motivation', 'slug' => 'cv-motivation']);
        $catEntretien = Category::create(['name' => 'Entretien', 'slug' => 'entretien']);

        // Posts
        $posts = [
            [
                'category_id' => $catConseils->id,
                'title' => 'Comment trouver un emploi en 2024 ?',
                'excerpt' => 'Le marché du travail évolue. Découvrez les stratégies gagnantes pour décrocher le poste de vos rêves cette année.',
                'content' => "Le marché de l'emploi est en constante évolution. Pour réussir votre recherche d'emploi en 2024, il est crucial d'adapter votre stratégie.\n\n1. **Optimisez votre présence en ligne** : LinkedIn est incontournable. Assurez-vous que votre profil est à jour et complet.\n2. **Réseautez activement** : Ne vous contentez pas de répondre aux offres. Contactez des professionnels de votre secteur.\n3. **Ciblez vos candidatures** : La qualité prime sur la quantité. Adaptez votre CV à chaque offre.",
                'image' => 'https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1352&q=80',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'category_id' => $catCV->id,
                'title' => '5 erreurs à éviter sur votre CV',
                'excerpt' => 'Votre CV termine à la poubelle ? Vous commettez peut-être une de ces 5 erreurs fatales.',
                'content' => "Un bon CV doit être clair, concis et pertinent. Voici les erreurs les plus courantes à éviter :\n\n1. **Les fautes d'orthographe** : C'est éliminatoire. Relisez-vous !\n2. **Une mise en page chargée** : Optez pour un design épuré et lisible.\n3. **Des informations obsolètes** : Mettez à jour vos compétences et votre parcours.",
                'image' => 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'category_id' => $catEntretien->id,
                'title' => 'Réussir son entretien d\'embauche : Le guide ultime',
                'excerpt' => 'Préparez-vous comme un pro pour votre prochain entretien avec nos conseils d\'experts.',
                'content' => "L'entretien est l'étape décisive. Voici comment vous préparer :\n\n- **Renseignez-vous sur l'entreprise** : Montrez que vous avez fait vos devoirs.\n- **Préparez vos questions** : Un entretien est un échange.\n- **Soyez authentique** : Ne jouez pas un rôle, soyez vous-même.",
                'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'category_id' => $catCV->id,
                'title' => 'Lettre de motivation : Est-elle encore utile ?',
                'excerpt' => 'Faut-il encore écrire une lettre de motivation en 2024 ? La réponse est nuancée.',
                'content' => "Beaucoup de recruteurs ne la lisent plus, mais pour d'autres, elle reste essentielle.\n\nSi l'offre le demande, vous n'avez pas le choix. Sinon, un mail d'accompagnement bien rédigé peut faire la différence.",
                'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($posts as $postData) {
            $title = $postData['title'];
            $slug = Str::slug($title);

            // Ensure unique slug
            $originalSlug = $slug;
            $count = 1;
            while (Post::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            Post::create(array_merge($postData, ['slug' => $slug]));
        }
    }
}
