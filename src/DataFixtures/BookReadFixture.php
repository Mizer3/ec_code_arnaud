<?php

namespace App\DataFixtures;

use App\Entity\BookRead;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookReadFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $now    = new \DateTime();
        $data   = [
            [
                'user_id' => 1,
                'book_id' => 1, // Le Pouvoir du Moment Présent
                'rating' => "5",
                'is_read' => true,
                'description' => '<ul><li>Excellente introduction à la pleine conscience.</li><li>Un livre transformateur pour ceux qui cherchent à vivre dans l\'instant présent.</li><li>Des pratiques concrètes pour réduire le stress et l\'anxiété.</li></ul>',
            ],
            [
                'user_id' => 1,
                'book_id' => 2, // Les 7 habitudes des gens efficaces
                'rating' => "4.5",
                'is_read' => true,
                'description' => '<ul><li>Des conseils pratiques et bien structurés pour améliorer sa productivité.</li><li>Les habitudes sont faciles à appliquer dans la vie quotidienne.</li><li>Parfait pour ceux qui cherchent à se fixer des objectifs clairs et les atteindre.</li></ul>',
            ],
            [
                'user_id' => 1,
                'book_id' => 3, // L’Alchimiste
                'rating' => null,
                'is_read' => false,
                'description' => '<ul><li>Un roman fascinant qui combine aventure et sagesse spirituelle.</li><li>Le message sur la poursuite des rêves est puissant et inspirant.</li><li>Une lecture qui pousse à la réflexion sur sa propre vie.</li></ul>',
            ],
            [
                'user_id' => 1,
                'book_id' => "4", // Réfléchissez et devenez riche
                'rating' => null,
                'is_read' => false,
                'description' => '<ul><li>Une analyse approfondie de la psychologie de la richesse.</li><li>Les principes sont toujours d\'actualité et appliqués par de nombreux entrepreneurs.</li><li>Des conseils pratiques pour ceux qui veulent améliorer leur situation financière.</li></ul>',
            ],
            [
                'user_id' => 1,
                'book_id' => 5, // Comment se faire des amis
                'rating' => null,
                'is_read' => false,
                'description' => '<ul><li>Un guide intemporel pour améliorer ses relations personnelles et professionnelles.</li><li>Les principes sont faciles à appliquer et extrêmement efficaces.</li><li>Un livre incontournable pour ceux qui souhaitent exceller dans l\'art de la communication.</li></ul>',
            ],
            [
                'user_id' => 1,
                'book_id' => 6, // Les Secrets de l\'esprit millionnaire
                'rating' => "4",
                'is_read' => true,
                'description' => '<ul><li>Une approche intéressante sur la façon de penser comme un riche.</li><li>Les conseils sont pertinents, mais il faut un engagement réel pour réussir.</li><li>Un excellent livre pour ceux qui veulent changer leur mentalité financière.</li></ul>',
            ],
            [
                'user_id' => 1,
                'book_id' => 7, // Pensez et devenez riche
                'rating' => null,
                'is_read' => false,
                'description' => '<ul><li>Des principes solides sur la réussite, mais parfois un peu redondants.</li><li>Une lecture inspirante, mais il faut faire preuve de patience pour appliquer les concepts.</li><li>Idéal pour ceux qui sont prêts à s’investir dans leur développement personnel.</li></ul>',
            ],
            [
                'user_id' => 1,
                'book_id' => 8, // La Magie du rangement
                'rating' => "4",
                'is_read' => true,
                'description' => '<ul><li>Un livre qui montre comment le rangement peut changer notre vie intérieure.</li><li>Des conseils pratiques et faciles à suivre pour désencombrer sa maison et son esprit.</li><li>Un bon livre pour commencer un changement positif dans sa vie quotidienne.</li></ul>',
            ],
            [
                'user_id' => 1,
                'book_id' => 9, // Le Moine qui vendit sa Ferrari
                'rating' => "5",
                'is_read' => true,
                'description' => '<ul><li>Une fable inspirante qui combine sagesse et développement personnel.</li><li>Les enseignements sur la recherche de l\'épanouissement intérieur sont précieux.</li><li>Un livre qui incite à une remise en question profonde de ses priorités.</li></ul>',
            ],
            [
                'user_id' => 1,
                'book_id' => 10, // Le Cercle des menteurs
                'rating' => "3",
                'is_read' => true,
                'description' => '<ul><li>Une critique intéressante de la manipulation dans le monde des affaires.</li><li>Le livre est parfois difficile à suivre, mais il apporte une réflexion utile.</li><li>Peut être un peu trop négatif pour certains lecteurs.</li></ul>',
            ]
        ];

        // Iterate over the data and create entities
        foreach ($data as $item) {
            $bookRead = new BookRead();
            $bookRead->setUserId($item['user_id']);
            $bookRead->setBookId($item['book_id']);
            $bookRead->setRating($item['rating']);
            $bookRead->setRead($item['is_read']);
            $bookRead->setDescription($item['description']);
            $bookRead->setCreatedAt($now);
            $bookRead->setUpdatedAt($now);

            $manager->persist($bookRead);
        }

        // Persist data to the database
        $manager->flush();
    }
}
