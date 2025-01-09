<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $now    = new \DateTime();
        $data   = [
            [
                'name' => 'Le Pouvoir du Moment Présent',
                'description' => 'Un ouvrage essentiel sur la pleine conscience et la spiritualité.',
                'category_id' => 3, // Spiritualité
                'pages' => 256,
                'publication_date' => new \DateTime('1997-01-01'),
            ],
            [
                'name' => 'Les 7 habitudes des gens efficaces',
                'description' => 'Un guide pratique pour améliorer sa productivité et ses relations.',
                'category_id' => 4, // Leadership
                'pages' => 432,
                'publication_date' => new \DateTime('1989-01-01'),
            ],
            [
                'name' => 'L’Alchimiste',
                'description' => 'Un roman spirituel qui inspire à poursuivre ses rêves.',
                'category_id' => 3, // Spiritualité
                'pages' => 208,
                'publication_date' => new \DateTime('1988-05-01'),
            ],
            [
                'name' => 'Réfléchissez et devenez riche',
                'description' => 'Des principes de succès et de richesse basés sur la pensée positive.',
                'category_id' => 5, // Entrepreneuriat
                'pages' => 238,
                'publication_date' => new \DateTime('1937-01-01'),
            ],
            [
                'name' => 'Comment se faire des amis',
                'description' => 'Un guide sur l\'art de la communication et des relations humaines.',
                'category_id' => 6, // Communication
                'pages' => 291,
                'publication_date' => new \DateTime('1936-10-01'),
            ],
            [
                'name' => 'Les Secrets de l\'esprit millionnaire',
                'description' => 'Des stratégies pour transformer sa mentalité et réussir financièrement.',
                'category_id' => 7, // Finance
                'pages' => 288,
                'publication_date' => new \DateTime('2005-01-01'),
            ],
            [
                'name' => 'Pensez et devenez riche',
                'description' => 'Un ouvrage de développement personnel pour atteindre l\'indépendance financière.',
                'category_id' => 7, // Finance
                'pages' => 250,
                'publication_date' => new \DateTime('1937-01-01'),
            ],
            [
                'name' => 'La Magie du rangement',
                'description' => 'L\'art de désencombrer pour trouver la paix intérieure.',
                'category_id' => 1, // Croissance
                'pages' => 240,
                'publication_date' => new \DateTime('2011-10-01'),
            ],
            [
                'name' => 'Le Moine qui vendit sa Ferrari',
                'description' => 'Un conte sur la quête du bonheur et du succès intérieur.',
                'category_id' => 3, // Spiritualité
                'pages' => 198,
                'publication_date' => new \DateTime('1997-06-01'),
            ],
            [
                'name' => 'Le Cercle des menteurs',
                'description' => 'L\'histoire d\'une entreprise basée sur la manipulation et le mensonge.',
                'category_id' => 5, // Entrepreneuriat
                'pages' => 350,
                'publication_date' => new \DateTime('1996-04-01'),
            ],
            [
                'name' => 'L\'art de la guerre',
                'description' => 'Des stratégies militaires appliquées au leadership et à la gestion.',
                'category_id' => 4, // Leadership
                'pages' => 273,
                'publication_date' => new \DateTime('5-01-01'),
            ],
            [
                'name' => 'Le Charisme',
                'description' => 'Comment développer son charisme et sa présence.',
                'category_id' => 6, // Communication
                'pages' => 240,
                'publication_date' => new \DateTime('2002-01-01'),
            ],
            [
                'name' => 'La Magie du matin',
                'description' => 'Un livre pour transformer sa vie en adoptant une routine matinale.',
                'category_id' => 1, // Croissance
                'pages' => 208,
                'publication_date' => new \DateTime('2016-01-01'),
            ],
            [
                'name' => 'Réveillez le leader en vous',
                'description' => 'Un guide pour développer des compétences de leadership et de gestion.',
                'category_id' => 4, // Leadership
                'pages' => 400,
                'publication_date' => new \DateTime('2014-10-01'),
            ],
            [
                'name' => 'La semaine de 4 heures',
                'description' => 'Comment réorganiser sa vie pour travailler moins et profiter davantage.',
                'category_id' => 5, // Entrepreneuriat
                'pages' => 416,
                'publication_date' => new \DateTime('2007-04-01'),
            ],
            [
                'name' => 'Une vie de créativité',
                'description' => 'Ouvrage sur la façon de stimuler et développer sa créativité.',
                'category_id' => 9, // Créativité
                'pages' => 250,
                'publication_date' => new \DateTime('2012-05-01'),
            ],
            [
                'name' => 'Vivre et réussir',
                'description' => 'Conseils pratiques pour une vie équilibrée et réussie.',
                'category_id' => 1, // Croissance
                'pages' => 289,
                'publication_date' => new \DateTime('2008-11-01'),
            ],
            [
                'name' => 'La richesse intérieure',
                'description' => 'Des stratégies pour cultiver la paix intérieure et l\'épanouissement personnel.',
                'category_id' => 3, // Spiritualité
                'pages' => 210,
                'publication_date' => new \DateTime('2010-05-01'),
            ],
            [
                'name' => 'Vaincre le stress',
                'description' => 'Méthodes pratiques pour gérer le stress et retrouver son calme.',
                'category_id' => 2, // Psychologie
                'pages' => 300,
                'publication_date' => new \DateTime('2009-01-01'),
            ],
            [
                'name' => 'L\'art du bonheur',
                'description' => 'Une exploration des principes qui mènent à une vie plus heureuse et épanouie.',
                'category_id' => 1, // Croissance
                'pages' => 210,
                'publication_date' => new \DateTime('2001-01-01'),
            ]
        ];

        // Iterate over the data and create entities
        foreach ($data as $item) {
            $book = new Book();
            $book->setCategoryId($item['category_id']);
            $book->setName($item['name']);
            $book->setDescription($item['description']);
            $book->setPages($item['pages']);
            $book->setPublicationDate($item['publication_date']);
            $book->setCreatedAt($now);
            $book->setUpdatedAt($now);

            $manager->persist($book);
        }

        // Persist data to the database
        $manager->flush();
    }
}
