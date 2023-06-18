<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const POSTS = [
        [
            'title' => ' Comprendre les agrégats',
            'author' => 'Ifzas',
            'createdAt' => '2023-05-18 14:07:38',
            'content' => "Dans le domaine de l'analyse des données, un terme revient souvent : l'agrégat. Que vous soyez un professionnel de la data science ou simplement curieux d'en savoir plus sur ce concept, cet article vous fournira une explication claire et concise de ce qu'est un agrégat et de son importance dans l'analyse de données.",
        ],
        [
            'title' => 'L\'audace de ne pas tester son code : une perspective controversée',
            'author' => 'Rémy',
            'createdAt' => '2009-01-24 05:03:47',
            'content' => "Dans le monde du développement logiciel, il existe un consensus général selon lequel le test du code est essentiel pour garantir sa qualité et sa stabilité. Les pratiques de test, telles que les tests unitaires, les tests d'intégration et les tests de régression, sont considérées comme des piliers fondamentaux de la programmation. Cependant, dans cet article, nous explorerons une perspective controversée : le fait de ne pas tester son code. Est-il possible que cette audacieuse approche ait des mérites insoupçonnés ?",
        ],
        [
            'title' => 'Révélations choquantes : Les secrets pour devenir un maître Product Owner révélés !',
            'author' => 'Nicolas',
            'createdAt' => '2022-02-15 15:16:17',
            'content' => "Chers lecteurs, êtes-vous prêts à découvrir les secrets bien gardés pour devenir un Product Owner (PO) extraordinaire ? Dans cet article sensationnel, nous allons lever le voile sur les compétences et les astuces nécessaires pour exceller en tant que PO. Attachez vos ceintures, car nous vous emmenons dans un voyage palpitant vers le succès !",
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::POSTS as $post) {
            $postEntity = new Post();
            $postEntity
                ->setTitle($post['title'])
                ->setAuthor($post['author'])
                ->setCreatedAt(\DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $post['createdAt']))
                ->setContent($post['content'])
            ;
            $manager->persist($postEntity);
        }

        $manager->flush();
    }
}
